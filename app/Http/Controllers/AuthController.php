<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\PasswordBroker;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use JWTAuth;
use View;
use App\Http\Controllers\Controller;

use App\Http\Resources\User as UserResource;

use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('customerAuth', ['only' => ['logout']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $redirectArr = explode('public/', $request->header('referer'));
        $redirect = (isset($redirectArr[1])) ? $redirectArr[1] : '';
        //dd($redirect);
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (!$validator->fails()) {
            $post = $request->all();
            $email = $post['email'];
            $password = $post['password'];
            if (!Auth::attempt(['email' => $email, 'password' => $password])) {
                return back()->with('error', 'Email/Password is Incorrect');
            }
        }

        return ($redirect=='checkout') ? redirect('checkout') : redirect('user/');
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return redirect('login');
    }
}
