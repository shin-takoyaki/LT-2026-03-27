<?php

declare(strict_types=1);

namespace Tests\Unit\UseCase\Todo\UpdateTodoTitle;

use App\Domain\Todo\Entity\Todo;
use App\Domain\Todo\Exception\CannotEditCompletedTodoException;
use App\Domain\Todo\Exception\TodoNotFoundException;
use App\Domain\Todo\Repository\TodoRepository;
use App\Domain\Todo\Service\TodoTitlePolicy;
use App\Domain\Todo\ValueObject\TodoId;
use App\Domain\Todo\ValueObject\TodoTitle;
use App\UseCase\Todo\UpdateTodoTitle\UpdateTodoTitleInput;
use App\UseCase\Todo\UpdateTodoTitle\UpdateTodoTitleUseCase;
use PHPUnit\Framework\TestCase;

/**
 * 学習観点:
 * UseCaseはRepository Interfaceに依存しているため、
 * DB接続なしで業務ルールを単体検証できる。
 */
final class UpdateTodoTitleUseCaseTest extends TestCase
{
    public function test_active_todo_can_be_renamed_and_saved_result_is_returned(): void
    {
        $repository = $this->createMock(TodoRepository::class);
        $policy = new TodoTitlePolicy();

        $todo = new Todo(
            id: new TodoId(1),
            title: new TodoTitle('旧タイトル'),
            isCompleted: false,
        );

        $repository->expects($this->once())
            ->method('findById')
            ->willReturn($todo);

        $repository->expects($this->once())
            ->method('save')
            ->with($this->callback(static function (Todo $savedTodo): bool {
                return $savedTodo->id()?->value() === 1
                    && $savedTodo->title()->value() === '新しいタイトル'
                    && $savedTodo->isCompleted() === false;
            }))
            ->willReturnCallback(static fn (Todo $savedTodo): Todo => $savedTodo);

        $useCase = new UpdateTodoTitleUseCase($repository, $policy);

        $output = $useCase->handle(new UpdateTodoTitleInput(
            id: 1,
            title: '新しいタイトル',
        ));

        $this->assertSame(1, $output->todo->id);
        $this->assertSame('新しいタイトル', $output->todo->title);
        $this->assertFalse($output->todo->isCompleted);
    }

    public function test_completed_todo_cannot_be_renamed_and_repository_save_is_not_called(): void
    {
        $repository = $this->createMock(TodoRepository::class);
        $policy = new TodoTitlePolicy();

        $completedTodo = new Todo(
            id: new TodoId(1),
            title: new TodoTitle('既存タイトル'),
            isCompleted: true,
        );

        $repository->expects($this->once())
            ->method('findById')
            ->willReturn($completedTodo);

        // ルール違反時は永続化に進まないことを検証する。
        $repository->expects($this->never())
            ->method('save');

        $useCase = new UpdateTodoTitleUseCase($repository, $policy);

        $this->expectException(CannotEditCompletedTodoException::class);

        $useCase->handle(new UpdateTodoTitleInput(
            id: 1,
            title: '変更後タイトル',
        ));
    }

    public function test_not_found_throws_exception_and_save_is_not_called(): void
    {
        $repository = $this->createMock(TodoRepository::class);
        $policy = new TodoTitlePolicy();

        $repository->expects($this->once())
            ->method('findById')
            ->willReturn(null);

        $repository->expects($this->never())
            ->method('save');

        $useCase = new UpdateTodoTitleUseCase($repository, $policy);

        $this->expectException(TodoNotFoundException::class);

        $useCase->handle(new UpdateTodoTitleInput(
            id: 999,
            title: '更新タイトル',
        ));
    }
}
