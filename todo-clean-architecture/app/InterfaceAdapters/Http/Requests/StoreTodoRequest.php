<?php

declare(strict_types=1);

namespace App\InterfaceAdapters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * なぜInterfaceAdaptersに置くか:
 * HTTP入力をアプリ内部の入力契約へ変換する責務は外側の関心事。
 * Domainの不変条件は別途持ちつつ、UIで早めに入力エラーを返す。
 */
final class StoreTodoRequest extends FormRequest
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
