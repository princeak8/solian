<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\KnownUserController;

/*
|--------------------------------------------------------------------------
| Register Controller
|--------------------------------------------------------------------------
|
| This controller handles the registration of new users as well as their
| validation and creation. By default this controller uses a trait to
| provide this functionality without requiring any additional code.
|
*/

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\Auth\AuthService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use View;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistration;
use App\Services\User\Zend\Bcrypt;
use Hash;

use App\Models\Role;
use App\Models\User;

class RegisterController extends Controller
{
    //use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * The authservice instance.
     *
     * @var App\Services\Auth\AuthService;
     */
    private $authService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthService $_authService)
    {
        $this->middleware('adminAuth', ['except' => ['add_customer']]);
        $this->authService = $_authService;
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
        $role = Role::where('role', 'admin')->first();
        $post = $request->all();
        try{
            //dd($request->all());
            $bcrypt = new Bcrypt();
            $user = new User;
            $user->email = $post['email'];
            $user->password = $bcrypt->create($post['password']);
            $user->name = $post['name'];
            $user->phone_number = $post['phone_number'];
            $user->role_id = $role->id;
            $user->save();
                
            return redirect('admin/register')->with("msg", "New Admin created successfully");
            
        }catch(\Exception $e){
            \Log::stack(['project'])->info($e->getMessage().' in '.$e->getFile().' at Line '.$e->getLine());
            return back()->with('error', 'An error occured');
        }
    }

    public function add_customer(RegisterRequest $request)
    {
        $role = Role::where('role', 'customer')->first();
        $post = $request->all();
        try{
            //dd($request->all());
            $bcrypt = new Bcrypt();
            $user = new User;
            $user->email = $post['email'];
            $user->password = $bcrypt->create($post['password']);
            $user->name = $post['name'];
            $user->phone_number = $post['phone_number'];
            $user->role_id = $role->id;
            $user->save();
            //Send Email to solian
            Mail::to($user)->send(new UserRegistration($user));
            return back()->with("msg", "Registeration was successfull");
        }catch(\Exception $e){
            \Log::stack(['project'])->info($e->getMessage().' in '.$e->getFile().' at Line '.$e->getLine());
            return back()->with('error', 'An error occured, please contac the administrator');
        }
    }

    public function register_admin()
    {
        $role = Role::where('role', 'admin')->first();
        $this->meta->title = 'Register User';
        return view('admin/register', compact('role'));
    }

    public function register()
    {
        $role = Role::where('role', 'customer')->first();
        return view('register', compact('role'));
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
