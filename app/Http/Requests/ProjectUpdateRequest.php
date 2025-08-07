<?php

namespace App\Http\Requests;

use App\Models\Project;
use App\Policies\ProjectPolicy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProjectUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can(ProjectPolicy::UPDATE, [Project::class]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            Project::TITLE => [
                'string',
                'max:100',
            ],
            Project::DESCRIPTION => [
                'string',
                'max:500',
            ],
            Project::PRIVATE => [
                'boolean',
            ],
        ];
    }
}
