<?php

namespace App\Policies;

use App\Models\ListItem;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ListItemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ListItem $listItem): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ListItem $listItem): bool
    {
        return $listItem->user()->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ListItem $listItem): bool
    {
        return $listItem->user()->is($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ListItem $listItem): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ListItem $listItem): bool
    {
        //
    }
}
