<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Providers\RouteServiceProvider;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use View;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Mail;

use App\Mail\UserRegistration;

use Hash;

use App\Services\User\UserService;
use App\Services\Auth\AuthService;
use App\Services\Utility\RoleService;

class UserController extends Controller
{
    private $authService;
    private $userService;
    private $roleService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authService = new AuthService;
        $this->userService = new UserService;
        $this->roleService = new RoleService;
    }

    public function create(RegisterRequest $request)
    {
        $post = $request->validated();
        $role = $this->roleService->customerRole();
        $post['role_id'] = $role->id;
        try{
            $user = $this->userService->save($post);
            try{
                //Send Email to solian
                Mail::to($user)->send(new UserRegistration($user));
            }catch(\Exception $e) {
                //
            }
            Auth::attempt(['email' => $post['email'], 'password' => $post['password']]);
            return back()->with("msg", "Registeration was successfull");
        }catch(\Exception $e){
            \Log::stack(['project'])->info($e->getMessage().' in '.$e->getFile().' at Line '.$e->getLine());
            return back()->with('error', 'An error occured, please contact the administrator');
        }
    }

    /**
     * Verify the token sent from email validation.
     *
     * @param  array  $data
     * @return \HttpResponse
     */
    public function verify($token)
    {
        try {
            $this->authService->verifyEmailToken($token);
            return redirect('login')->with('message', trans('Email address successfully verified'));
        } catch (\Throwable $th) {
            return redirect('login')->with("error", $th->getMessage());
        }
    }
}
