<?php

namespace App\Http\Requests;

use App\Models\TaskList;
use App\Policies\TaskListPolicy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TaskListStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->can(TaskListPolicy::STORE, $this->route('project'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            TaskList::PROJECT_ID => [
                'required',
                'integer',
            ],
            TaskList::TITLE => [
                'string',
                'max: 255',
            ],
        ];
    }
}
