<?php

namespace Chudeusz\Permissions\Http\Controllers;

use App\Http\Controllers\Controller;
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

    public function index(Request $request)
    {

        return redirect()->route('home.index');
    }
}