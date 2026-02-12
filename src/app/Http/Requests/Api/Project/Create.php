<?php

namespace App\Http\Requests\Api\Project;

use App\Http\Requests\Api\ApiRequest;

class Create extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:32',
            'problem' => 'required',
            'people' => 'required|integer|min:1',
            'period' => 'required|string|max:32',
            'stack' => 'required|string|max:200',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'アプリ名は必須です。',
            'name.max' => 'アプリ名は32文字以内で入力してください。',
            'problem.required' => 'アプリの課題は必須です。',
            'people.required' => '人数は必須です。',
            'people.integer' => '人数は整数で入力してください。',
            'people.min' => '人数は1人以上で入力してください。',
            'period.required' => '期間は必須です。',
            'period.max' => '期間は32文字以内で入力してください。',
            'stack.required' => '技術スタックは必須です。',
            'stack.max' => '技術スタックは200文字以内で入力してください。',
        ];
    }
}
