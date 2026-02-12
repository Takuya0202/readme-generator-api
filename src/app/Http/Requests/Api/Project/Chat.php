<?php

namespace App\Http\Requests\Api\Project;

use App\Http\Requests\Api\ApiRequest;
use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

class Chat extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $project = Project::find($this->route('projectId'));
        return $project && $project->user_id === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message' => 'required|string|max:1000'
        ];
    }

    public function messages(): array
    {
        return [
            'message.required' => 'メッセージは必須です。',
            'message.string' => 'メッセージは文字列で入力してください。',
            'message.max' => 'メッセージは1000文字以内で入力してください。',
        ];
    }
}
