<?php

namespace App\Policies;

use App\Models\Conference\Conference;
use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConferencePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any conferences.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('index conference','api');
    }

    /**
     * Determine whether the user can view the conference.
     *
     * @param User $user
     * @param Conference  $conference
     * @return mixed
     */
    public function view(User $user, Conference $conference): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create conferences.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create conference','api');
    }

    /**
     * Determine whether the user can update the conference.
     *
     * @param User $user
     * @param Conference  $conference
     * @return mixed
     */
    public function update(User $user, Conference $conference): bool
    {
        return $user->hasPermissionTo('update conference','api') && $conference->user_id === $user->getKey();
    }

    /**
     * Determine whether the user can delete the conference.
     *
     * @param User $user
     * @param  Conference  $conference
     * @return mixed
     */
    public function delete(User $user, Conference $conference): bool
    {
        return $user->hasPermissionTo('delete conference','api') && $conference->user_id === $user->getKey();
    }

    /**
     * @param User $user
     * @param Conference $conference
     * @return bool
     */
    public function addArticle(User $user, Conference $conference): bool
    {
        return $user->hasPermissionTo('add article','api') && $conference->user_id === $user->getKey();
    }

    /**
     * @param User $user
     * @param Conference $conference
     * @return bool
     */
    public function addOrgCommittee(User $user, Conference $conference): bool
    {
        return $user->hasPermissionTo('add org committee','api') && $conference->user_id === $user->getKey();
    }

    /**
     * @param User $user
     * @param Conference $conference
     * @return bool
     */
    public function removeOrgCommittee(User $user, Conference $conference): bool
    {
        return $user->hasPermissionTo('remove org committee','api') && $conference->user_id === $user->getKey();
    }

    /**
     * @param User $user
     * @param Conference $conference
     * @return bool
     */
    public function addEditor(User $user, Conference $conference): bool
    {
        return $user->hasPermissionTo('add editor','api') && $conference->user_id === $user->getKey();
    }

    /**
     * @param User $user
     * @param Conference $conference
     * @return bool
     */
    public function removeEditor(User $user, Conference $conference): bool
    {
        return $user->hasPermissionTo('remove editor','api') && $conference->user_id === $user->getKey();
    }
}
