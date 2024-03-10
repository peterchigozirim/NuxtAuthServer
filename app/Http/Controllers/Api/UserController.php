<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OTP;
use App\Notifications\ResetNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json(Auth::user(), 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public static function random($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function randomNu($length)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required',
                'new_password' => 'required'
            ]);
            
            $user = User::findOrFail(Auth::user()->id);
            if (Hash::check($request->password, Auth::user()->password )) {
                $user->update([
                    'password' => Hash::make($request->new_password)
                ]);
    
                return response()->json([
                    'message' => 'Login Password change successful'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Your former password is incorrect',
                ], 400);
            }
            
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'something went wrong',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
                'otp' => ['required'],
            ]);
            $user = User::where('email', $request->email)->first();
            $otp = OTP::where('user_id', $user->id)->first();
            if ($user) {
                if (OTP::where('user_id', $user->id)->exists()) {
                    if ($request->otp == $otp->code) {
                        $password = $this->random(13);
                        $user->password = Hash::make($password);
                        $user->show_password = $password;
                        $user->save();
                        $sub = 'Reset Password';
                        $msg = 'New Password is '. $password ;
                        $user->notify(new ResetNotification($sub, $user, $msg));
                        return response()->json([
                            'message' => 'New password sent'
                        ], 200);
                    }else{
                        return response()->json([
                            'message' => 'Incorrect OTP code'
                        ], 400);
                    }
                }else {
                    return response()->json([
                        'message' => 'Invaild OTP code'
                    ], 400);
                }
                
            }else{
                return response()->json([
                    'message' => 'Email address not found'
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'something went wrong',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function resetOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email']
            ]);
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $code = $this->randomNu(4);
                $user->otp()->create([
                    'code' => $code,
                ]);
                $sub = 'OTP Code';
                $msg = 'OTP code is '. $code ;
                $user->notify(new ResetNotification($sub, $user, $msg));
                return response()->json([
                    'message' => 'OTP code sent'
                ], 200);
            }else{
                return response()->json([
                    'message' => 'Email address not found'
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'something went wrong',
                'error' => $th->getMessage()
            ], 400);
        }
    }
}
