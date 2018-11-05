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
        $this->registerPermissions();
    }

    public function register()
    {
        
    }

    public function registerPermissions()
    {
        foreach(config('permissions') as $config)
        {
            Gate::define($config['name'], function (\App\User $user) use ($config){
                return $user->hasAccess([$config['permission']]);
            });
        }


    }
}