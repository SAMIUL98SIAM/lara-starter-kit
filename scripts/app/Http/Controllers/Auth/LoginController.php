<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\App;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
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

    // Github login
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }
    public function handleGithubCallback(Request $request)
    {
        $user = Socialite::driver('github')->user();

        $this->_registerOrLoginUser($user);
        // Return home after login
        notify()->success('You have successfully logged in with '.$user->name.' ','Success');
        return redirect()->route('home');
    }


    // Google login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback(Request $request)
    {
        $user = Socialite::driver('google')->user();

        $this->_registerOrLoginUser($user);
        // Return home after login
        notify()->success('You have successfully logged in with '.$user->name.' ','Success');
        return redirect()->route('home');
    }

    public function  _registerOrLoginUser($data)
    {
        //Find existing user.
        $user = User::whereEmail($data->getEmail())->first();

        if (!$user) {
            $user = new User();
            $user->role_id = Role::where('slug','user')->first()->id;
            $user->name = $data->name;
            $user->email = $data->email;
            $user->status = true;
            // if($data->file('image')){
            //     $file = $data->file('image');
            //     $filename = date('YmdHi').$file->getClientOriginalName();
            //     $file->move(('uploads/user_images'),$filename);
            //     $user['image'] = $filename;
            // }
            $user->save();

        }
        Auth::login($user);

        // if ($existingUser)
        // {
        //     Auth::login($existingUser);
        // }
        // else
        // {
        //     // Create new user.
        //     // $newUser = User::create([
        //     //     'role_id' => Role::where('slug','user')->first()->id,
        //     //     'name' => $user->getName(),
        //     //     'email' => $user->getEmail(),
        //     //     'status' => true
        //     // ]);
        //     // upload images
        //     ///$file = $request->file('image');
        //     // $filename = date('YmdHi').$user['image']->getClientOriginalName();
        //     // $user['image']->move(('uploads/user_images'),$filename);
        //     // $newUser['image'] = $filename;
        //     // $newUser->save();
        //     // Auth::login($newUser);
        // }
        //notify()->success('You have successfully logged in with '.ucfirst($provider).'!','Success');
        //return redirect($this->redirectPath());
    }

}
