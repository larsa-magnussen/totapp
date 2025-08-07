<?php

namespace App\Http\Requests;

use App\Models\Project;
use App\Models\User;
use App\Policies\ProjectPolicy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProjectStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can(ProjectPolicy::STORE, [Project::class]);
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
                'required',
                'string',
                'max:100',
            ],
            Project::DESCRIPTION => [
                'nullable',
                'string',
                'max:500',
            ],
            Project::PRIVATE => [
                'required',
                'boolean',
            ],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        $user = Auth::user();

        return array_merge(parent::validated(), [
            Project::USER_ID => $user->{User::ID},
        ]);
    }
}
