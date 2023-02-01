<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\User\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\SystemService;
use App\Services\UserService;
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
    public function __construct(SystemService $systemService, UserService $userService)
    {
        $this->middleware('guest')->except('logout');
        $this->systemService = $systemService;
        $this->userService = $userService;
    }

    public function showLoginForm()
    {
        return view('user.layouts.login');
    }

    public function login(Request $request)
    {
//        dd($request->all());
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email_login' => 'required|email',
            'password_login' => 'required|string|min:6',
        ]);
        dd(auth()->attempt(['email' => $request['email_login'], 'password' => $request['password_login']]));
        $checkLock = $this->userService->isLockUserByEmail($request['email_login']);
        if ($checkLock) {
            return redirect()->back()->withError('This account is locked')->with('dataError', $request->all());
        }
        $rememberToken = isset($request['remember_login']) ? true : false;
        if (Auth::attempt(['email' => $request['email_login'], 'password' => $request['password_login'], 'status_register' => 0])) {
            $this->systemService->sendMailConfirm(auth()->user());
            auth()->logout();
            return 'login failed, account not confirmed, system sent you an email, please confirm';
        }

        if (Auth::attempt(['email' => $request['email_login'], 'password' => $request['password_login'], 'status_register' => 1], $rememberToken)) {
            return redirect()->route('index');
        } else {
            return redirect()->back()->withError('The account or password is not correct')->with('dataError', $request->all());
        }

    }

    public function logout(Request $request)
    {
        auth()->logout();
        // $request->session()->invalidate();
        return redirect()->back();
    }
}
