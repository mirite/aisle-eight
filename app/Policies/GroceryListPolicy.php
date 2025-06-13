<?php

namespace App\Policies;

use App\Models\{GroceryList, User};

class GroceryListPolicy
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
     * @param GroceryList $groceryList
     */
    public function delete(User $user, GroceryList $groceryList): bool
    {
        return $groceryList->user()->is($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     * @param User $user
     * @param GroceryList $groceryList
     */
    public function forceDelete(User $user, GroceryList $groceryList): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     * @param User $user
     * @param GroceryList $groceryList
     */
    public function restore(User $user, GroceryList $groceryList): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     * @param User $user
     * @param GroceryList $groceryList
     */
    public function update(User $user, GroceryList $groceryList): bool
    {
        return $groceryList->user()->is($user);
    }

    /**
     * Determine whether the user can view the model.
     * @param User $user
     * @param GroceryList $groceryList
     */
    public function view(User $user, GroceryList $groceryList): bool
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
