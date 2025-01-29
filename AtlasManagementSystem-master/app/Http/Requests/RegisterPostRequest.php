<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterPostRequest extends FormRequest
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
        $currentDate = date('Y-m-d');
        return [
            // 姓 バリデーション
            'over_name' => 'required|string|max:10',

            // 名
            'under_name' => 'required|string|max:10',

            // セイ
            'over_name_kana' => [
                'required',
                'string',
                'max:30',
                'regex:/^[ァ-ンヴー]+$/u', // カタカナのみ
            ],

            // メイ
            'under_name_kana' => [
                'required',
                'string',
                'max:30',
                'regex:/^[ァ-ンヴー]+$/u', // カタカナのみ
            ],

            // メールアドレス
            'mail_address' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('users', 'mail_address')->ignore($this->user), // 登録済み無効
            ],

            // 性別
            'sex' => [
                'required',
                Rule::in(['男性', '女性', 'その他']), // 選択肢の限定
            ],

            // 生年月日関連
            'old_year' => [
                'required',
                'date',
                'before_or_equal:' . $currentDate,
                'after_or_equal:2000-01-01',
            ],
            'old_month' => 'required|integer|between:1,12', // 月の範囲
            'old_day' => 'required|integer|between:1,31', // 日の範囲

            // 役割
            'role' => [
                'required',
                Rule::in(['講師(国語)', '講師(数学)', '講師(英語)', '生徒']), // 選択肢の限定
            ],

            // パスワード
            'password' => [
                'required',
                'string',
                'min:8',
                'max:30',
                'confirmed', // 確認用と一致しているか
            ],
        ];
    }

    /**
     * カスタムエラーメッセージを定義する
     *
     * @return array
     */
    public function messages()
    {
        return [
            'over_name.required' => '姓は必須項目です。',
            'over_name.string' => '姓は文字列で入力してください。',
            'over_name.max' => '姓は10文字以下で入力してください。',

            'under_name.required' => '名は必須項目です。',
            'under_name.string' => '名は文字列で入力してください。',
            'under_name.max' => '名は10文字以下で入力してください。',

            'over_name_kana.required' => 'セイは必須項目です。',
            'over_name_kana.regex' => 'セイはカタカナのみで入力してください。',
            'over_name_kana.max' => 'セイは30文字以下で入力してください。',

            'under_name_kana.required' => 'メイは必須項目です。',
            'under_name_kana.regex' => 'メイはカタカナのみで入力してください。',
            'under_name_kana.max' => 'メイは30文字以下で入力してください。',

            'mail_address.required' => 'メールアドレスは必須項目です。',
            'mail_address.email' => 'メールアドレスの形式が正しくありません。',
            'mail_address.max' => 'メールアドレスは100文字以下で入力してください。',
            'mail_address.unique' => 'このメールアドレスはすでに登録されています。',

            'sex.required' => '性別は必須項目です。',
            'sex.in' => '性別は「男性」「女性」「その他」から選択してください。',

            'old_year.required' => '生年月日は必須項目です。',
            'old_year.date' => '正しい日付を入力してください。',
            'old_year.before_or_equal' => '生年月日は今日以前の日付を入力してください。',
            'old_year.after_or_equal' => '生年月日は2000年1月1日以降の日付を入力してください。',
            'old_month.required' => '生年月日の月を入力してください。',
            'old_month.between' => '生年月日の月は1〜12の範囲で入力してください。',
            'old_day.required' => '生年月日の日を入力してください。',
            'old_day.between' => '生年月日の日は1〜31の範囲で入力してください。',

            'role.required' => '役割は必須項目です。',
            'role.in' => '役割は「講師(国語)」「講師(数学)」「講師(英語)」「生徒」から選択してください。',

            'password.required' => 'パスワードは必須項目です。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.max' => 'パスワードは30文字以下で入力してください。',
            'password.confirmed' => 'パスワードが一致しません。',
        ];
    }
}
