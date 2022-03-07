<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\KnownUserController;

use Illuminate\Contracts\Auth\PasswordBroker;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use View;
use App\Http\Controllers\Controller;

use App\Http\Resources\User as UserResource;

use Request;
use Auth;

use App\Models\User;

class AdminAuthController extends KnownUserController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('adminAuth', ['only' => ['logout']]);
        $this->meta = new \stdClass();
        $this->meta->active = $this->meta->root = $this->menu['title'] = "Registeration";
        View::share('meta', $this->meta);
    }

    public function login_page()
    {
        $this->meta->title = 'Login User';
        return view('admin/login');
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = Request::only('email', 'password');
        
        if (!auth()->attempt($credentials) ) {
            return back()->with('error', 'Email/Password is Incorrect');
        }
        return redirect('admin/'); 
    }

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return redirect('admin/login');
    }
}
