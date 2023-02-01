<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\User\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Mail\RegisterMail;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\UserService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterUserRequest $request)
    {
        $user = $this->userService->userRepository->store($request->all());
        $token = Crypt::encryptString($user->id . "=>" . date('') . now());
        $mailable = new RegisterMail($user, $token);
        Mail::to($request->email)->send($mailable);
        return 'The system has sent you an email, please confirm';
    }

    public function confirmUser($token)
    {
        $key = Crypt::decryptString($token);
        $array = explode('=>', $key);
        $id = $array[0];
        $time = strtotime($array[1]);
        $duringTime = abs(strtotime(date('') . now()) - $time) / 60;
        if ($duringTime > 15) {
            return 'This link has expired!!!!';
        }
        $user = $this->userService->userRepository->getUserUnConfirm($id)->get();
        if (count($user) === 0) {
            return 'no valid user!!!!';
        }
        $data = [
            'status_register' => '1'
        ];
        $result = $this->userService->userRepository->update($id, $data);
        if (!$result) {
            return 'Registration confirmation failed';
        }
        Auth::login($user[0], false);
        return redirect()->route('index');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
