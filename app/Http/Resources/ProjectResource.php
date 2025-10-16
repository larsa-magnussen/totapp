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
            'createdAt' => $this->{Project::CREATED_AT},
            'updatedAt' => $this->{Project::UPDATED_AT},
            'deletedAt' => $this->{Project::DELETED_AT},
            'user' => UserResource::make($this->whenLoaded('user')),
            'taskLists' => TaskListResource::collection($this->whenLoaded('taskLists')),
            'notepad' => NotepadResource::make($this->whenLoaded('notepad')),
        ];
    }
}
