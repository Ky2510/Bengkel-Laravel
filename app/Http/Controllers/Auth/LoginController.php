<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function authenticated(Request $request, $user)
    {
        if($user->akses == 'admin'){
            return redirect()->route('dashboard');
        }elseif ($user->akses == 'customer' && $user->status == 'aktif') {
            return redirect()->route('customer');
        }elseif ($user->akses == 'superadmin') {
            return redirect()->route('admin');
        }else{
            Auth::logout();
            if ($user->akses == 'customer' && $user->status == 'non-aktif') {
                return redirect()->route('login')->with('warning', 'Tidak bisa login, Hubungi Admin segera!');
            }else{
                return redirect()->route('customer');
            }
        }
    }
}
