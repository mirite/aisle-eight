<?php

namespace App\Policies;

use App\Models\{AisleItem, User};

class AisleItemPolicy
{
    /**
     * Determine whether the user can create models.
     * @param User $user
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     * @param User $user
     * @param AisleItem $aisleItem
     */
    public function delete(User $user, AisleItem $aisleItem): bool
    {
        return $aisleItem->user()->is($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     * @param User $user
     * @param AisleItem $aisleItem
     */
    public function forceDelete(User $user, AisleItem $aisleItem): bool
    {
        return $aisleItem->user()->is($user);
    }

    /**
     * Determine whether the user can restore the model.
     * @param User $user
     * @param AisleItem $aisleItem
     */
    public function restore(User $user, AisleItem $aisleItem): bool
    {
        return $aisleItem->user()->is($user);
    }

    /**
     * Determine whether the user can update the model.
     * @param User $user
     * @param AisleItem $aisleItem
     */
    public function update(User $user, AisleItem $aisleItem): bool
    {
        return $aisleItem->user()->is($user);
    }

    /**
     * Determine whether the user can view the model.
     * @param User $user
     * @param AisleItem $aisleItem
     */
    public function view(User $user, AisleItem $aisleItem): bool
    {
        return $aisleItem->user()->is($user);
    }

    /**
     * Determine whether the user can view any models.
     * @param User $user
     */
    public function viewAny(User $user): bool
    {
        return true;
    }
}
