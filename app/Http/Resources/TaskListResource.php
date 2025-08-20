<?php

namespace App\Http\Resources;

use App\Models\TaskList;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->{TaskList::ID},
            'title' => $this->{TaskList::TITLE},
            'createdAt' => $this->{TaskList::CREATED_AT},
            'updatedAt' => $this->{TaskList::UPDATED_AT},
            'project' => ProjectResource::make($this->whenLoaded('project')),
        ];
    }
}
