<?php

namespace Chudeusz\Permissions;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class PermissionsServiceProvider extends ServiceProvider 
{

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/route.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations/');
//        $this->loadTranslationsFrom(__DIR__ . '/lang');
        $this->registerPermissions();
    }

    public function register()
    {
        
    }

    public function registerPermissions()
    {
        Gate::define('create-post', function (\App\User $user){
            return $user->hasAccess(['create-post']);
        });

        Gate::define('update-post', function (\App\User $user) {
            return $user->hasAccess(['update-post']);
        });

        Gate::define('delete-post', function (\App\User $user) {
            return $user->hasAccess(['delete-post']);
        });

        Gate::define('show-post', function (\App\User $user) {
            return $user->hasAccess(['show-post']);
        });

        Gate::define('like-post', function (\App\User $user) {
            return $user->hasAccess(['like-post']);
        });

        Gate::define('add-comment', function (\App\User $user) {
            return $user->hasAccess(['add-comment']);
        });

        Gate::define('show-comments', function (\App\User $user) {
            return $user->hasAccess(['show-comments']);
        });
    }
}