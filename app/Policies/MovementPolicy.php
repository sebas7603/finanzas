<?php

namespace App\Policies;

use App\Models\Financial;
use App\Models\Movement;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MovementPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $financial = Financial::findOrFail(app('request')->get('financial_id'));
        return $user->financials->contains($financial);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Movement $movement): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Movement $movement): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Movement $movement): bool
    {
        //
    }
}
