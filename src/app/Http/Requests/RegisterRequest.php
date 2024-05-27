<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:191',
            'email' => [
                'required',
                'string',
                'email',
                'max:191',
                Rule::unique('users'),
            ],
            'password' => 'required|string|min:8|max:191|confirmed',
            'password_confirmation' => 'required|string|min:8|max:191|same:password',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'お名前を入力してください',
            'name.string' => 'お名前は文字列で入力してください',
            'name.max' => 'お名前は191文字以内で入力してください',

            'email.required' => 'メールアドレスを入力してください',
            'email.string' => 'メールアドレスは文字列で入力してください',
            'email.email' => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',
            'email.max' => 'メールアドレスは191文字以内で入力してください',
            'email.unique' => 'このメールアドレスは既に登録されています',

            'password.required' => 'パスワードを入力してください',
            'password.string' => 'パスワードは文字列で入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'password.max' => 'パスワードは191文字以内で入力してください',
            'password.confirmed' => '確認用パスワードと一致しません',

            'password_confirmation.required' => '確認用パスワードを入力してください',
            'password_confirmation.string' => '確認用パスワードは文字列で入力してください',
            'password_confirmation.min' => '確認用パスワードは8文字以上で入力してください',
            'password_confirmation.max' => '確認用パスワードは191文字以内で入力してください',
            'password_confirmation.same' => '確認用パスワードがパスワードと一致しません',
        ];
    }
}
