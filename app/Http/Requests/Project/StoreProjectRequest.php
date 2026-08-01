<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\ProjectStatusEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ApiResponder;
class StoreProjectRequest extends FormRequest
{
    use ApiResponder;
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:projects,name', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', Rule::enum(ProjectStatusEnum::class)],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->validationError(
                $validator->errors()
            )
        );
    }
}
