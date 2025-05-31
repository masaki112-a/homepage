<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;

class EventPolicy
{
    public function view(User $user, Event $event)
    {
        return $user->id === $event->user_id;
    }

    public function update(User $user, Event $event)
    {
        return $user->id === $event->user_id;
    }

    public function delete(User $user, Event $event)
    {
        return $user->id === $event->user_id;
    }
}