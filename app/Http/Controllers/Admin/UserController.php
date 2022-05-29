<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
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
        $this->middleware('adminAuth', ['except' => ['add_customer']]);
        $this->authService = new AuthService;
        $this->userService = new UserService;
        $this->roleService = new RoleService;
        $this->meta = new \stdClass();
        $this->meta->active = $this->meta->root = $this->menu['title'] = "Registeration";
        View::share('meta', $this->meta);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return View, the email verification view
     */
    protected function create(RegisterRequest $request)
    {
        try{
            //dd($request->all());
            $post = $request->validated();
            $post['role_id'] = $this->roleService->adminRole()->id;
            $this->userService->save($post);
                
            return redirect('admin/register')->with("msg", "New Admin created successfully");
            
        }catch(\Exception $e){
            \Log::stack(['project'])->info($e->getMessage().' in '.$e->getFile().' at Line '.$e->getLine());
            return back()->with('error', 'An error occured');
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
