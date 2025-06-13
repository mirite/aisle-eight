<?php

namespace App\Policies;

use App\Models\{Item, User};

class ItemPolicy
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
     * @param Item $item
     */
    public function delete(User $user, Item $item): bool
    {
        return $item->user()->is($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     * @param User $user
     * @param Item $item
     */
    public function forceDelete(User $user, Item $item): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     * @param User $user
     * @param Item $item
     */
    public function restore(User $user, Item $item): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     * @param User $user
     * @param Item $item
     */
    public function update(User $user, Item $item): bool
    {
        return $item->user()->is($user);
    }

    /**
     * Determine whether the user can view the model.
     * @param User $user
     * @param Item $item
     */
    public function view(User $user, Item $item): bool
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
