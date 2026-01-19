<?php

namespace App\Policies;

use App\Models\UpcomingEvent;
use App\Models\User;

class UpcomingEventPolicy
{
    public function view(User $user, UpcomingEvent $event): bool
    {
        return $user->id === $event->user_id;
    }

    public function update(User $user, UpcomingEvent $event): bool
    {
        return $user->id === $event->user_id;
    }

    public function delete(User $user, UpcomingEvent $event): bool
    {
        return $user->id === $event->user_id;
    }
}
