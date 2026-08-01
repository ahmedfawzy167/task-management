<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\ProjectStatusEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ApiResponder;
class UpdateProjectRequest extends FormRequest
{
    use ApiResponder;
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('projects', 'name')->ignore($this->route('project'))],
            'description' => ['nullable', 'string'],
            'status' => ['sometimes', 'required', Rule::enum(ProjectStatusEnum::class)],
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
