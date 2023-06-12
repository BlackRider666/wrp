<?php

namespace App\Providers;

use App\Models\Article\Article;
use App\Models\Conference\Conference;
use App\Models\Organization\Organization;
use App\Models\Organization\StructuralUnit\StructuralUnit;
use App\Policies\ArticlePolicy;
use App\Policies\ConferencePolicy;
use App\Policies\OrganizationPolicy;
use App\Policies\StructuralUnitPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Article::class => ArticlePolicy::class,
        Conference::class => ConferencePolicy::class,
        Organization::class => OrganizationPolicy::class,
        StructuralUnit::class => StructuralUnitPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::before(function ($user) {
            if ($user->hasRole(['superadmin'])) {
                return true;
            }
            return null;
        });
    }
}
