<?php

namespace App\Policies;

use App\Models\{Store, User};

class StorePolicy
{
    /**
     * Determine whether the user can create models.
     * @param User $user
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     * @param User $user
     * @param Store $store
     */
    public function delete(User $user, Store $store): bool
    {
        return $store->user()->is($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     * @param User $user
     * @param Store $store
     */
    public function forceDelete(User $user, Store $store): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     * @param User $user
     * @param Store $store
     */
    public function restore(User $user, Store $store): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     * @param User $user
     * @param Store $store
     */
    public function update(User $user, Store $store): bool
    {
        return $store->user()->is($user);
    }

    /**
     * Determine whether the user can view the model.
     * @param User $user
     * @param Store $store
     */
    public function view(User $user, Store $store): bool
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
