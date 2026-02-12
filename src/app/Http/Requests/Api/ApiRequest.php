<?php

namespace App\Http\Requests\Api;

use App\Http\Responses\MutationResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ApiRequest extends FormRequest
{
    protected function failedValidation(Validator $validator): void
    {
        // オーバーライドしてレスポンスカスタム
        $errors = collect($validator->errors()->messages())
            ->map(fn($messages) => $messages[0])
            ->toArray();

        throw new HttpResponseException(
            MutationResponse::validationError($errors)
        );
    }
}
