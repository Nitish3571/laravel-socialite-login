<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // public function callbackGoogle(Request $request)
    // {
    //     // $google_user = Socialite::drive('google')->user();
    //     $google_user = Socialite::driver('google')->stateless()->user();
    //     // dd($google_user);
    //     try{

    //         $user = User::where('email', $google_user->getId())->first();
    //         if($user){

    //             $new_user = User::create([
    //                 'name' => $google_user->getName(),
    //                 'email' => $google_user->getEmail(),
    //                 'google_id' => $google_user->getId(),
    //                 'password' => \Hash::make(rand(100000, 999999)),
    //             ]);

    //             Auth::login($new_user);
    //             // return redirect()->intended('dashboard');
    //             $request->session()->regenerate();
    //             return redirect()->intended(RouteServiceProvider::HOME);

    //         } else {
    //             Auth::login($user);
    //             $request->session()->regenerate();
    //             return redirect()->intended(RouteServiceProvider::HOME);

    //             // return redirect()->intended('dashboard');
    //         }

    //     } catch( \Throwable $th) {
    //         dd('Something went wrong!'. $th->getMessage());
    //         return redirect()->route('login')->with('error', 'Error al conectar con Google');
    //     }
    // }

    public function callbackGoogle(Request $request)
    {
        try {

            $googleUser = Socialite::driver('google')->stateless()->user();

            // Debugging: Check the Google user details
            \Log::info('Google User: ', (array)$googleUser);

            // Check if the user already exists
            $user = User::where('email', $googleUser->getEmail())->first();

            // Debugging: Check if user is found
            if ($user) {
                \Log::info('User found: ', ['user' => $user]);
            } else {
                \Log::info('User not found, creating new user.');
            }
            \Log::info($googleUser->getName());
            \Log::info($googleUser->getId());

            if (!$user) {
                // Create a new user if not exists
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    // 'password' => \Hash::make(rand(100000, 999999)), // Dummy password
                ]);
                // dd($user);
            }

            // Log in the user
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended(RouteServiceProvider::HOME);
        } catch (\Throwable $th) {
            dd('Something went wrong!'. $th->getMessage());
            return redirect()->route('login')->with('error', 'Error al conectar con Google: ' . $th->getMessage());
        }
    }



    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $googleUser->email)->first();
        if(!$user)
        {
            $user = User::create(['name' => $googleUser->name, 'email' => $googleUser->email, 'password' => \Hash::make(rand(100000,999999))]);
        }

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
