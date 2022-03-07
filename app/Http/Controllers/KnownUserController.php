<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| KnownUser Controller
|--------------------------------------------------------------------------
|
| This controller that controllers esclusive to logged in users inherit from, 
| Holds the common function needed for logged in users
|
*/

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use View;

class KnownUserController extends Controller
{
    /**
     * Represents the menu items shown to the user.
     */
    public $menu;

    /**
     * An object holding the meta data for the view
     */
    public $meta;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('auth');
        $this->meta = new \stdClass();
        $this->meta->active = '';
        $this->meta->title = '';
        $this->meta->root = '';
        $this->meta->description = '';
        View::share('meta', $this->meta);
    }
}
