<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Request;
use App\Department;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name'  => 'required|max:255',
            'email'      => 'required|email|max:255|unique:users',
            'password'   => 'required|confirmed|min:6',
            'birth_date' => 'required',
            'school_year'=> 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'email'         => $data['email'],
            'birth_date'    => $data['birth_date'],
            'school_year'   => $data['school_year'],
            'department'    => $data['department'],
            'password'      => bcrypt($data['password']),
        ]);
    }

    public function getLogin()
    {
        return view('auth.login');
    }

    public function getRegister()
    {
        $departments = Department::all();
        return view('auth.register', compact('departments'));
    }

    public function register(Request $request)
    {
        $validation = $this->validator($request->all());

        if($validation->fails())
        {
            Flash::error('Inscription impossible. Veuillez vérifier les champs renseignés.');
            return redirect('auth/register')->withErrors($validation->errors());
        }

        $user = $this->create($request->all());

        Auth::login($user);

        if(Auth::guest())
        {
            Flash::error('Connexion impossible.');
            return redirect('auth/login');
        }

        $id = Auth::user()->id;

        $slug = Auth::user()->first_name.'-'.Auth::user()->last_name.'-'.$id;

        $user->update([
            'slug' => $slug,
            ]);

        Flash:success('Bienvenue '.$user->first_name . ' !');
        return redirect('/');

    }
}