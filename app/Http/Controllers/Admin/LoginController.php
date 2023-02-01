<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\User\Controller;
use App\Http\Requests\LoginAdminRequest;
use App\Services\AdminService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    public function __construct(AdminService $adminService)
    {
        $this->middleware('auth.guest')->except('logout');
        $this->adminService = $adminService;
    }

    public function showLoginForm()
    {
        return view('admin.layouts.login');
    }

    public function login(LoginAdminRequest $request)
    {
        $checkLock = $this->adminService->isLockAdminByUsername($request['username']);
        if ($checkLock) {
            return redirect()->back()->withError('This account is locked')->with('dataError', $request->all());
        }

        $data = [
            'username' => $request['username'],
            'password' => $request['password']
        ];

        // dd($data);

        if (Auth::guard('admin')->attempt($data)) {
            return redirect()->back();
        }

        return redirect()->back()->withError('The account or password is not correct')->with('dataError', $data);
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->back();
    }

    protected function redirectTo()
    {
        return route('admin.index');
    }

    protected function loggedOut(Request $request)
    {
        return $request->wantsJson()
            ? new Response('', 204)
            : redirect()->route('admin.login');
    }
}
