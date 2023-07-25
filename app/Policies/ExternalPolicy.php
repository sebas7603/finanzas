<?php

namespace App\Policies;

use App\Models\External;
use App\Models\User;

class ExternalPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, External $external): bool
    {
        return $user->id === $external->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, External $external): bool
    {
        return $user->id === $external->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, External $external): bool
    {
        return $user->id === $external->user_id;
    }
}
