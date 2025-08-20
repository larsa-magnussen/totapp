<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->{User::ID},
            'name' => $this->{User::NAME},
            'email' => $this->{User::EMAIL},
            'emailVerifiedAt' => $this->{User::EMAIL_VERIFIED_AT},
            'createdAt' => $this->{User::CREATED_AT},
            'updatedAt' =>  $this->{User::UPDATED_AT},
        ];
    }
}
