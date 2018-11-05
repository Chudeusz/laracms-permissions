<?php

namespace Chudeusz\Permissions\Seeder;

use Illuminate\Database\Seeder;
use Chudeusz\Permissions\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configRole = config('datafixtures.roles.list');

        if(config('datafixtures.roles.generate')) {

            foreach($configRole as $key => $role){

                $roles = new Role();
                $roles->setId(config('datafixtures.roles.list.'.$key.'.id'));
                $roles->setName(config('datafixtures.roles.list.'.$key.'.name'));
                $roles->save();
                echo 'Role created ' . $key . '.' . config('datafixtures.roles.list.' . $key . '.name') . '' . PHP_EOL;
            }

        }

    }
}
