<?php

namespace App\Policies;

use App\Models\Organization\Organization;
use App\Models\User\User;
use App\Models\Organization\StructuralUnit\StructuralUnit;
use Illuminate\Auth\Access\HandlesAuthorization;

class StructuralUnitPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any structural units.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the structural unit.
     *
     * @param User $user
     * @param  StructuralUnit  $structuralUnit
     * @return bool
     */
    public function view(User $user, StructuralUnit $structuralUnit): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create structural units.
     *
     * @param User $user
     * @param Organization $organization
     * @return bool
     */
    public function create(User $user, Organization $organization): bool
    {
        return $organization->editors()->where('user_id',$user->getKey())->exists()
            && $user->hasPermissionTo('create structural unit','api');
    }

    /**
     * Determine whether the user can update the structural unit.
     *
     * @param User $user
     * @param  StructuralUnit  $structuralUnit
     * @return bool
     */
    public function update(User $user, StructuralUnit $structuralUnit): bool
    {
        return $structuralUnit->organization->editors()->where('user_id',$user->getKey())->exists()
            && $user->hasPermissionTo('update structural unit','api');
    }

    /**
     * Determine whether the user can delete the structural unit.
     *
     * @param User $user
     * @param StructuralUnit $structuralUnit
     * @return bool
     */
    public function delete(User $user, StructuralUnit $structuralUnit): bool
    {
        return $structuralUnit->organization->editors()->where('user_id',$user->getKey())->exists()
            && $user->hasPermissionTo('delete structural unit','api');
    }
}
