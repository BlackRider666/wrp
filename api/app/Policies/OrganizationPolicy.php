<?php

namespace App\Policies;

use App\Models\Organization\Organization;
use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the article.
     *
     * @param User $user
     * @param  Organization  $organization
     * @return mixed
     */
    public function update(User $user, Organization $organization): bool
    {
        return $organization->editors()->where('user_id',$user->getKey())->exists()
            && $user->hasPermissionTo('update organization','api');
    }
}
