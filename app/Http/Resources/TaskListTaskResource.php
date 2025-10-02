<?php

namespace App\Http\Resources;

use App\Models\TaskListTask;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskListTaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->{TaskListTask::ID},
            'taskListId' => $this->{TaskListTask::TASK_LIST_ID},
            'description' => $this->{TaskListTask::DESCRIPTION},
            'createdAt' => $this->{TaskListTask::CREATED_AT},
            'updatedAt' => $this->{TaskListTask::UPDATED_AT},
            'completedAt' => $this->{TaskListTask::COMPLETED_AT},
            'deletedAt' => $this->{TaskListTask::DELETED_AT},
            'taskList' => TaskListResource::make($this->whenLoaded('taskList')),
        ];
    }
}
