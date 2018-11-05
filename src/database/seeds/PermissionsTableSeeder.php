<?php

namespace Chudeusz\Permissions\Seeder;

use Illuminate\Database\Seeder;
use Chudeusz\Permissions\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = config('permissions');
        foreach($permissions as $p)
        {
            $permission = new Permission();
            $permission->setName($p['name']);
            $permission->setPermission($p['permission']);
            $permission->setDescription($p['permission']);
            $permission->save();

            echo 'Added Permission: '. $p['name'] . ' '.PHP_EOL;
        }
    }
}
