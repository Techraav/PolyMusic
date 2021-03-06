<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use App\Department;
use Carbon\Carbon;

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
            'email'      => 'required|email|max:255|unique:users,email',
            'password'   => 'required|confirmed|min:6',
            'birth_date' => 'required',
            'department_id' => 'required',
            'school_year'=> 'required',
            'g-recaptcha-response'  => 'required'
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
            'first_name'    => ucfirst($data['first_name']),
            'last_name'     => ucfirst($data['last_name']),
            'email'         => $data['email'],
            'birth_date'    => $data['birth_date'],
            'school_year'   => $data['school_year'],
            'department_id' => $data['department_id'],
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

    public function register()
    {
        $validation = $this->validator(Input::all());

        if($validation->fails())
        {
            Flash::error('Inscription impossible. Veuillez vérifier les champs renseignés.');
            return Redirect::back()->withInput()->withErrors($validation->errors());
        }

        $bdate = Input::get('birth_date');
        if(strpos($bdate, '-'))
        {
            $bdate = Carbon::createFromFormat('Y-m-d', $bdate);
        }else
        {
            $bdate = Carbon::createFromFormat('d/m/Y', $bdate);
        }
        $bdate = $bdate->format('Y-m-d');

        $user = $this->create([
            'first_name' => Input::get('first_name'),
            'last_name' => Input::get('last_name'),
            'email' => Input::get('email'),
            'school_year' => Input::get('school_year'),
            'department_id' => Input::get('department_id'),
            'password' => Input::get('password'),
            'birth_date' => $bdate
            ]);

        Auth::login($user, true);

        if(Auth::guest())
        {
            Flash::error('Connexion impossible.');
            return redirect('auth/login');
        }

        $fn = normalizeChars(Auth::user()->first_name);
        $ln = normalizeChars(Auth::user()->last_name);

        $slug = str_slug($fn .'-'. $ln .'-'. Auth::user()->id);
        
        $user->update([
            'slug' => $slug,
            ]);

        Flash::success('Bienvenue '.$user->first_name . ' !');
        return redirect('/');
    }

    public function login()
    {
        $validator = Validator::make(Input::all(), ['g-recaptcha-response' => 'required']);
        if($validator->fails())
        {
            Flash::error('Impossible de vous connecter : mauvais captcha.');
            return redirect('auth/login');

        }
        if (Auth::attempt(['email' => Input::get('email'), 'password' => Input::get('password')], true))
        {
            if(Auth::user()->banned == 0)
            {    
               Flash::success('Vous êtes maintenant connecté');
               return redirect('/');
            } else
            {
                Auth::logout();
                Flash::error('Impossible de vous connecter : votre compte a été banni. Pour plus d\'informations ou pour des réclamations, contactez un administrateur.');
                return redirect('/');
            }  
        }
        else
        {
            $error = true;
        }

        Flash::error('Impossible de vous connecter.');
        return redirect('auth/login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}