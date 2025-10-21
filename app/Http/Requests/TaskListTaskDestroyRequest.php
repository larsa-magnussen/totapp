<?php

namespace App\Http\Requests;

use App\Models\TaskListTask;
use App\Policies\TaskListTaskPolicy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TaskListTaskDestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can(TaskListTaskPolicy::DESTROY, [
            TaskListTask::class,
            $this->route('project'),
            $this->route('task_list'),
            $this->route('task')
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
