<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\User;
use Validator;
use App\Model\Pengaturan\Profil;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

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
    protected $redirectTo = '/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function getLogin()
    {
        
      $profil = Profil::find(1);
      return view('login.login',['profil'=>$profil]);
    }

    public function postLogin(Request $r)
    {
      $username = $r->input('username');
      $password = $r->input('password');
      $remember = ($r->input('remember')) ? true : false;

      if (Auth::attempt(['username' => $username, 'password' => $password,'status'=>1],$remember)) {
        if (Auth::viaRemember()) {
        return redirect('/');
        }
        return redirect('/');
      }

      $msgclass = "danger";
      $msg = "Username atau password tidak valid";
      return redirect('login')->with('msgclass',$msgclass)->with('msg',$msg)->withInput();
    }
    //
    public function getLogout()
    {
        
      Auth::logout();
      return redirect('login');
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
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
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
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
