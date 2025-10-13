<?php

namespace App\Http\Requests;

use App\Models\TaskList;
use App\Models\TaskListTask;
use App\Policies\TaskListTaskPolicy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TaskListTaskStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can(TaskListTaskPolicy::STORE, [TaskListTask::class, $this->route('project'), $this->route('task_list')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            TaskListTask::DESCRIPTION => [
                'required',
                'string',
                'max:150',
            ],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        return array_merge(parent::validated(), [
            TaskListTask::TASK_LIST_ID => $this->route('task_list')
        ]);
    }
}
