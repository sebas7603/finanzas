<?php

namespace App\Policies;

use App\Models\Financial;
use App\Models\User;

class FinancialPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Financial $financial): bool
    {
        return $user->id === $financial->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Financial $financial): bool
    {
        return $user->id === $financial->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Financial $financial): bool
    {
        return $user->id === $financial->user_id;
    }
}
