<?php

namespace App\Http\Requests;

use App\Models\TaskList;
use App\Policies\TaskListPolicy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TaskListDestroyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->can(TaskListPolicy::DESTROY, [TaskList::class, $this->route('project'), $this->route('task_list')]);
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
