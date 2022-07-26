<?php

namespace App\Http\Controllers;

use Validator;
use Session;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Admin;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
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
    protected $redirectTo = '/admin/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function getLogin()
    {
        return view('admin.auth.login');
    }

    /**
     * Show the application loginprocess.
     *
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        if (Auth::guard('admin')->attempt(['username' => $request->input('username'), 'password' => $request->input('password')]))
        {
            $user = auth()->guard('admin')->user();
            
            \Session::put('success','You are Login successfully!!');
            return redirect()->route('dashboard');
            
        } else {
            //  return Hash::make('holapalo');
            return back()->with('error','your username and password are wrong.');
        }

    }

    /**
     * Show the application logout.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        auth()->guard('admin')->logout();
        \Session::flush();
        Session::put('success','You are logout successfully');        
        return redirect(route('adminLogin'));
    }

    public function getsetPassword(){
        return view('admin.auth.setPassword');
    }

    public function setPassword(Request $request){
        $validator = Validator::make($request->all(),
        [
            'username' => 'required|exists:admins,username',
            'token' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        if($validator->fails()){
            return back()->with('error', 'No se ha encontrado el usuario, o las contraseñas no coinciden');
        }
        $user = Admin::where('username', $request->username)->first();
        if($user->one_time_token != $request->token){
            return back()->with('error', 'El token no es válido.');
        }
        $now = Carbon::now('UTC')->timestamp;
        $tokenDate = Carbon::parse($user->token_datetime)->timestamp;
        if(($now - $tokenDate)/60 > 5){
            return back()->with('error', 'El token era válido, pero ha caducado');
        }

        $update = Admin::find($user->id)->update([
            'one_time_token' => '',
            'password' => Hash::make($request->password)
        ]);
        return redirect(route('adminLogin'))->with('success', 'Contraseña establecida correctamente');
    }
}
