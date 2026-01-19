<?php

namespace App\Policies;

use App\Models\Gift;
use App\Models\User;

class GiftPolicy
{
    public function view(User $user, Gift $gift): bool
    {
        return $user->id === $gift->user_id;
    }

    public function update(User $user, Gift $gift): bool
    {
        return $user->id === $gift->user_id;
    }

    public function delete(User $user, Gift $gift): bool
    {
        return $user->id === $gift->user_id;
    }
}
