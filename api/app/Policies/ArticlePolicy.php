<?php

namespace App\Policies;

use App\Models\Article\Article;
use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any articles.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the article.
     *
     * @param User $user
     * @param Article $article
     * @return mixed
     */
    public function view(User $user, Article $article): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create articles.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user): bool
    {
//        return $user->is_premium !== false;
        return $user->hasPermissionTo('create articles','api');
    }

    /**
     * Determine whether the user can update the article.
     *
     * @param User $user
     * @param  Article  $article
     * @return mixed
     */
    public function update(User $user, Article $article): bool
    {
        return $article->authors()->where('user_id',$user->getKey())->count() > 0 && $user->hasPermissionTo('update articles','api');
    }

    /**
     * Determine whether the user can delete the article.
     *
     * @param User $user
     * @param  Article  $article
     * @return mixed
     */
    public function delete(User $user, Article $article): bool
    {
        return $user->hasPermissionTo('delete articles','api');
    }

    /**
     * Determine whether the user can restore the article.
     *
     * @param User $user
     * @param Article  $article
     * @return mixed
     */
    public function restore(User $user, Article $article): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the article.
     *
     * @param User $user
     * @param Article  $article
     * @return mixed
     */
    public function forceDelete(User $user, Article $article): bool
    {
        return true;
    }
}
