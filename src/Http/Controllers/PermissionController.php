<?php

namespace Chudeusz\Permissions\Http\Controllers;

use Illuminate\Routing\Controller;
use App\User;
use Illuminate\Http\Request;
use Session;

class PermissionController extends Controller
{
    /**
     * @var Session $session
     */
    public $session;

    public function __construct(Session $session)
    {
        /**
         * @var Session $session
         */
        $this->session = $session;
    }

    public function update($permission, $user, $value)
    {
        $u = User::findOrFail($user);
        $perms = json_decode($u['permissions']);
        foreach ($perms as $perm => $p)
        {
            if($perm == $permission) {
                $perms->$perm = $this->parseValue($value);
                $u->setPermissions(json_encode($perms));
                $u->save();
            }
        }

        return response()->json(['user' => $u]);
    }

    protected function parseValue($value)
    {
        if($value == "true") {
            return true;
        }

        return false;
    }
}