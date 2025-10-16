<?php

namespace App\Http\Resources;

use App\Models\Notepad;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotepadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->{Notepad::ID},
            'createdAt' => $this->{Notepad::CREATED_AT},
            'updatedAt' => $this->{Notepad::UPDATED_AT},
            'deletedAt' => $this->{Notepad::DELETED_AT},
            'project' => ProjectResource::make($this->whenLoaded('project')),
        ];
    }
}
