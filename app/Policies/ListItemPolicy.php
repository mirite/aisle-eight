<?php

namespace App\Policies;

use App\Models\{ListItem, User};

class ListItemPolicy
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
     * @param ListItem $listItem
     */
    public function delete(User $user, ListItem $listItem): bool
    {
        return $listItem->user()->is($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     * @param User $user
     * @param ListItem $listItem
     */
    public function forceDelete(User $user, ListItem $listItem): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     * @param User $user
     * @param ListItem $listItem
     */
    public function restore(User $user, ListItem $listItem): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     * @param User $user
     * @param ListItem $listItem
     */
    public function update(User $user, ListItem $listItem): bool
    {
        return $listItem->user()->is($user);
    }

    /**
     * Determine whether the user can view the model.
     * @param User $user
     * @param ListItem $listItem
     */
    public function view(User $user, ListItem $listItem): bool
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
