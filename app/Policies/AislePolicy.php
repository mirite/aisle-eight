<?php

namespace App\Policies;

use App\Models\{Aisle, User};

class AislePolicy
{
    /**
     * Determine whether the user can create models.
     * @param User $user
     */
    public function create(User $user): bool
    {
    }

    /**
     * Determine whether the user can delete the model.
     * @param User $user
     * @param Aisle $aisle
     */
    public function delete(User $user, Aisle $aisle): bool
    {
        return $aisle->user()->is($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     * @param User $user
     * @param Aisle $aisle
     */
    public function forceDelete(User $user, Aisle $aisle): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     * @param User $user
     * @param Aisle $aisle
     */
    public function restore(User $user, Aisle $aisle): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     * @param User $user
     * @param Aisle $aisle
     */
    public function update(User $user, Aisle $aisle): bool
    {
        return $aisle->user()->is($user);
    }

    /**
     * Determine whether the user can view the model.
     * @param User $user
     * @param Aisle $aisle
     */
    public function view(User $user, Aisle $aisle): bool
    {
        //
    }

    /**
     * Determine whether the user can view any models.
     * @param User $user
     */
    public function viewAny(User $user): bool
    {
        //
    }
}
