<?php

namespace Tests\Traits;

use App\Models\User;
use Illuminate\Testing\TestResponse;

trait TestRequestHelpers
{
    public function getAsUser(User $user, $url, array $headers = []): TestResponse
    {
        return $this
            ->actingAs($user)
            ->getJson($url, $headers);
    }

    public function postAsUser(User $user, $url, array $data = [], array $headers = []): TestResponse
    {
        return $this
            ->actingAs($user)
            ->postJson($url, $data, $headers);
    }

    public function putAsUser(User $user, $url, array $data = [], array $headers = []): TestResponse
    {
        return $this
            ->actingAs($user)
            ->putJson($url, $data, $headers);
    }

    public function patchAsUser(User $user, $url, array $data = [], array $headers = []): TestResponse
    {
        return $this
            ->actingAs($user)
            ->patchJson($url, $data, $headers);
    }

    public function deleteAsUser(User $user, $url, array $data = [], array $headers = []): TestResponse
    {
        return $this
            ->actingAs($user)
            ->deleteJson($url, $data, $headers);
    }
}
