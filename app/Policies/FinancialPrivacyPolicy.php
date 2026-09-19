<?php

namespace App\Policies;

use App\Models\User;

class FinancialPrivacyPolicy
{
    /**
     * Determine if user can access financial resource.
     * Admin ALWAYS returns false for any user's financial resources.
     */
    public function view(User $authenticatedUser, mixed $resource): bool
    {
        if ($authenticatedUser->isAdmin()) {
            return false; // Admin cannot view any financial data
        }

        return $resource->user_id === $authenticatedUser->id;
    }

    public function create(User $authenticatedUser): bool
    {
        return ! $authenticatedUser->isAdmin(); // Admin cannot create financial data for users
    }

    public function update(User $authenticatedUser, mixed $resource): bool
    {
        if ($authenticatedUser->isAdmin()) {
            return false;
        }

        return $resource->user_id === $authenticatedUser->id;
    }

    public function delete(User $authenticatedUser, mixed $resource): bool
    {
        if ($authenticatedUser->isAdmin()) {
            return false;
        }

        return $resource->user_id === $authenticatedUser->id;
    }
}
