<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        $user = User::where('api_token', '=', $request['api_token'])->first();
        if ($user != null) {
            $user->api_token = null;
            $user->save();
            return response()->json(['status' => 'ok', 'data' => $user, 200]);
        }
        return response()->json(['errors' => array(['code' => 404,
            'message' => 'Usuario no encontrado.'])], 404);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $user = User::find(Auth::user()->id);
            do {
                $token = Str::random(80);
                $exist = User::where('api_token', '=', $token)->get();
            } while (count($exist) != 0);
            $user->api_token = $token;
            $user->save();
            return response()->json(['status' => 'ok', 'data' => $user, 200]);
        } else {
            return response()->json(['errors' => array(['code' => 401,
                'message' => 'Usuario o Contraseña incorrecto.'])], 401);
        }
    }
}
