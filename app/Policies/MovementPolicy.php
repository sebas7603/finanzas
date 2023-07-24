<?php

namespace App\Policies;

use App\Models\Financial;
use App\Models\Movement;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MovementPolicy
{
    /**
     * This is a generic validation for this policy (Movement)
     */
    public function getGenericPolice(User $user, Movement $movement = null): bool
    {
        $financial = Financial::findOrFail(app('request')->route('financial_id'));
        return $user->financials->contains($financial);
    }

    /**
     * Determine whether the user can create models.
     */
    public function index(User $user): bool
    {
        return $this->getGenericPolice($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->getGenericPolice($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Movement $movement): bool
    {
        return $this->getGenericPolice($user, $movement);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Movement $movement): bool
    {
        return $this->getGenericPolice($user, $movement);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Movement $movement): bool
    {
        return $this->getGenericPolice($user, $movement);
    }
}
