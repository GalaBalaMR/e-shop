<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function github()
    {
        // send user's request to github
        return Socialite::driver('github')->redirect();
    }

    public function githubRedirect()
    {
        // send user's request to github
        $user = Socialite::driver('github')->user();

        // if the user doesn't exist, add them
        // if they do, get the model
        // either way, authenticate the user into the aplication and redirect
        $user = User::firstOrCreate([
            'email' => $user->email
        ], [
            'name' => $user->nickname,
            'password' => Hash::make(Str::random(24))
        ]);

        Auth::login($user, true);

        return redirect('/');
    }
    
}
