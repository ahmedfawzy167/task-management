<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ApiResponder;
class UpdateTaskRequest extends FormRequest
{
    use ApiResponder;
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('tasks', 'title')->ignore($this->route('task'))],
            'description' => ['nullable', 'string'],
            'priority' => ['sometimes', 'required', Rule::enum(TaskPriorityEnum::class)],
            'status' => ['sometimes', 'required', Rule::enum(TaskStatusEnum::class)],
            'due_date' => ['nullable', 'date_format:Y-m-d H:i:s'],
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
