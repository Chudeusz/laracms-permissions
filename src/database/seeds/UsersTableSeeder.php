<?php

namespace Chudeusz\Permissions\Seeder;

use Illuminate\Database\Seeder;
use Chudeusz\Permissions\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $configUsers = config('datafixtures.users.list');

        if(config('datafixtures.users.generate')) {

            foreach($configUsers as $key => $user){
                $u = new User();
                $u->setUsername(config('datafixtures.users.list.'.$key.'.username'));
                $u->setName(config('datafixtures.users.list.'.$key.'.name'));
                $u->setPassword(config('datafixtures.users.list.'.$key.'.password'));
                $u->setEmail(config('datafixtures.users.list.'.$key.'.email'));
                $u->setAvatar(config('datafixtures.users.list.'.$key.'.avatar'));
                foreach(config('permissions') as $permission)
                {
                    if($u->getUsername() == 'Administrator') {
                        $permissions[$permission['name']] = true;
                    } else {
                        $permissions[$permission['name']] = $permission['default'];
                    }

                }
                ksort($permissions);
                $u->setPermissions(json_encode($permissions));
                $u->save();
                $u->roles()->attach(config('datafixtures.users.list.'.$key.'.role'));

                echo 'User created ' . $key . '.' . config('datafixtures.users.list.'.$key.'.username') . '' . PHP_EOL;
                echo $u->getPermissions() . PHP_EOL;
            }

        }




    }
}
