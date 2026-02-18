<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo - Clean Architecture Learning</title>
    <style>
        body { font-family: sans-serif; margin: 2rem; line-height: 1.6; }
        .container { max-width: 820px; margin: 0 auto; }
        h1 { margin-bottom: 1rem; }
        .status { background: #edf7ed; color: #1e4620; padding: 0.75rem; margin-bottom: 1rem; }
        .error { background: #fdecea; color: #611a15; padding: 0.75rem; margin-bottom: 1rem; }
        .card { border: 1px solid #ddd; border-radius: 8px; padding: 1rem; margin-bottom: 1rem; }
        .row { display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center; }
        .todo-item { border: 1px solid #e4e4e4; border-radius: 8px; padding: 1rem; margin-bottom: 0.75rem; }
        .done { background: #f7f7f7; }
        .done-title { text-decoration: line-through; color: #777; }
        input[type="text"] { padding: 0.4rem; min-width: 280px; }
        button { padding: 0.4rem 0.75rem; cursor: pointer; }
        .badge { font-size: 0.85rem; background: #f1f1f1; border-radius: 6px; padding: 0.2rem 0.5rem; }
    </style>
</head>
<body>
<div class="container">
    <h1>ToDo（Clean Architecture 学習用）</h1>

    @if (session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card">
        <h2>新規作成</h2>
        <form method="POST" action="{{ route('todos.store') }}" class="row">
            @csrf
            <input type="text" name="title" maxlength="100" value="{{ old('title') }}" placeholder="タイトルを入力">
            <button type="submit">追加</button>
        </form>
    </div>

    <div class="card">
        <h2>一覧</h2>

        @forelse ($vm->todos as $todo)
            <div class="todo-item {{ $todo->isCompleted ? 'done' : '' }}">
                <div class="row" style="margin-bottom: 0.5rem;">
                    <span class="badge">ID: {{ $todo->id }}</span>
                    <strong class="{{ $todo->isCompleted ? 'done-title' : '' }}">{{ $todo->title }}</strong>
                    @if ($todo->isCompleted)
                        <span class="badge">完了済み</span>
                    @endif
                </div>

                <div class="row" style="margin-bottom: 0.5rem;">
                    <form method="POST" action="{{ route('todos.updateTitle', ['id' => $todo->id]) }}" class="row">
                        @csrf
                        @method('PATCH')
                        <input
                            type="text"
                            name="title"
                            maxlength="100"
                            value="{{ $todo->title }}"
                            {{ $todo->canEditTitle ? '' : 'disabled' }}
                        >
                        <button type="submit" {{ $todo->canEditTitle ? '' : 'disabled' }}>タイトル更新</button>
                    </form>
                    @if (! $todo->canEditTitle)
                        <small>完了済みのためタイトル編集不可（Domainルール）</small>
                    @endif
                </div>

                <div class="row">
                    <form method="POST" action="{{ route('todos.toggle', ['id' => $todo->id]) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit">{{ $todo->isCompleted ? '未完了に戻す' : '完了にする' }}</button>
                    </form>

                    <form method="POST" action="{{ route('todos.destroy', ['id' => $todo->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit">削除</button>
                    </form>
                </div>
            </div>
        @empty
            <p>ToDoはまだありません。</p>
        @endforelse
    </div>
</div>
</body>
</html>
