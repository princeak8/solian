<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\Auth\PasswordBroker;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use JWTAuth;
use View;
use App\Http\Controllers\Controller;

use App\Http\Resources\User as UserResource;

use Auth;

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
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (!$validator->fails()) {
            $post = $request->all();
            $email = $post['email'];
            $password = $post['password'];
            if (!Auth::attempt(['email' => $email, 'password' => $password, 'role_id' => Role::role('customer')->id])) {
                return back()->with('error', 'Email/Password is Incorrect');
            }
        }

        return redirect()->back();
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
