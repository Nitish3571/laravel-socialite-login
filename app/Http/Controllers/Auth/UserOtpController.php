<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Support\Facades\Auth;

class UserOtpController extends Controller
{
    public function index(){
        return view('auth.otpLogin');
    }
    public function generate(Request $request){
        $request->validate([
            'phone_no' => 'required |min:10 |exists:users,phone_no'
        ]);

        $userOtp = $this->generateOTP($request->phone_no);
        $userOtp->sendSMS($request->phone_no);
        return redirect()->route('otp.verification', $userOtp->user_id)->with('success', 'Otp has been sent on Your Mobile Number!');
    }

    public function generateOTP( $phone){

        $user = User::where('phone_no', $phone)->first();
        $userOtp = UserOtp::where('user_id', $user->id)->latest()->first();
        $now  = now();
        if($userOtp && $now->isBefore($userOtp->expaired_at)){
            return $userOtp;
        }

        return UserOtp::create([
            'user_id' => $user->id,
            'otp' => rand(123456, 999999),
            'expaired_at' => $now->addMinutes(10),
        ]);
    }

    public function verification($id){
        return view('auth.otpVerified')->with([
            'user_id' => $id
        ]);
    }
    public function verified(Request $request){
        $request->validate([
            'otp' => 'required | min:6 | max:6',
            'user_id' => 'required | exists:users,id'
        ]);

        $userOtp = UserOtp::where('user_id', $request->user_id)->where('otp', $request->otp)->first();
        $now = now();

        if(!$userOtp){
            return redirect()->back()->with('error', 'Your otp not correct');
        }
        else if($userOtp && $now->isAfter($userOtp->expaired_at)){
            return redirect()->back()->with('error', 'Your otp has been Expaired');

        }

        $user = User::whereId($request->user_id)->first();

        if($user){
            $userOtp->update([
                'expaired_at' => now()
            ]);

            Auth::login($user);
            return redirect()->route('dashboard')->with('success', 'You have been logged in successfully');
        }
        return redirect()->route('otp')->with('error', 'Your OTP has been expaired!');
    }
}
