<?php

declare(strict_types=1);

namespace App\InterfaceAdapters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * なぜInterfaceAdaptersに置くか:
 * タイトル更新時のHTTPバリデーションをControllerから分離し、
 * UseCaseへ渡す前の形式チェック責務を明確化するため。
 */
final class UpdateTodoTitleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'タイトルは必須です。',
            'title.max' => 'タイトルは100文字以内で入力してください。',
        ];
    }
}
