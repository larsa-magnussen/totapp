<?php

namespace App\Http\Resources;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->{Project::ID},
            'title' => $this->{Project::TITLE},
            'description' => $this->{Project::DESCRIPTION},
            'private' => $this->{Project::PRIVATE},
            'created_at' => $this->{Project::CREATED_AT},
            'updated_at' => $this->{Project::UPDATED_AT},
            'deleted_at' => $this->{Project::DELETED_AT},
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
