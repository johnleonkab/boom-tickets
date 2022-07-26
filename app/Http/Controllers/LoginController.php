<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Validator;
use Socialite;
use Auth;
use File;
class LoginController extends Controller
{

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function signinGoogle()
    {
        try {
    
            $user = Socialite::driver('google')->user();
            $userCol = User::where('google_id', $user->id)->first();
            if($userCol){
                Auth::login($userCol);
                return redirect('/dashboard');
            }else{
                $addUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'profile_photo_path' => $user->getAvatar(),
                    'password' => encrypt('helloadmin')
                ]);
    
                Auth::login($addUser);
                return redirect('/dashboard');
            }
    
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}