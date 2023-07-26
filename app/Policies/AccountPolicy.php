<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\Financial;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AccountPolicy
{
    /**
     * This is a generic validation for this policy (Account)
     */
    public function getGenericPolice(User $user, Account $account = null): bool
    {
        $financial = Financial::findOrFail(app('request')->route('financial_id'));
        return $user->financials->contains($financial);
    }

    /**
     * Determine whether the user can list all models.
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
    public function view(User $user, Account $account): bool
    {
        return $this->getGenericPolice($user, $account);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Account $account): bool
    {
        return $this->getGenericPolice($user, $account);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Account $account): bool
    {
        return $this->getGenericPolice($user, $account);
    }
}
