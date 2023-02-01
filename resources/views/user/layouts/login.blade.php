@extends('user.layouts.app')

@section('content')
    <section id="form">
        <!--form-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form">
                        <!--login form-->
                        {{-- @dd(Session::has('dataError')) --}}
                        <h2>Login to your account</h2>
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <input type="email_login" placeholder="Email" name="email_login"
                                   class="{{ $errors->first('email_login') ? 'register-error-input' : '' }}"
                                   value="{{ old('email_login') }}{{ Session::has('dataError') ? Session::get('dataError')['email_login'] :'' }}"/>
                            @if ($errors->first('email_login'))
                                <span class="register-error-content">{{ $errors->first('email_login') }}</span>
                            @endif
                            <input type="password" name="password_login" placeholder="password"
                                   class="{{ $errors->first('password_login') ? 'register-error-input' : '' }}">
                            @if ($errors->first('password_login'))
                                <span class="register-error-content">{{ $errors->first('password_login') }}</span>
                            @endif
                            <span>
                                <input type="checkbox" class="checkbox" name="remember_login">
                                Keep me signed in
                            </span>
                            <span class="register-error-content">{{ $errors->first('password_login') }}</span>
                            <button type="submit" class="btn btn-default">Login</button>
                        </form>

                        @if(Session::has('error'))
                            <span class="login-error-content">{{ Session::get('error') }}</span>
                        @endif
                    </div>
                    <!--/login form-->
                </div>
                <div class="col-sm-1">
                    <h2 class="or">OR</h2>
                </div>
                <div class="col-sm-4">
                    <div class="signup-form">
                        <!--sign up form-->
                        <h2>New User Signup!</h2>
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <input type="text" placeholder="Name" name="name"
                                   class="{{ $errors->first('name') ? 'register-error-input' : '' }}"
                                   value="{{ old('name') }}"/>
                            @if ($errors->first('name'))
                                <span class="register-error-content">{{ $errors->first('name') }}</span>
                            @endif
                            <input type="date" name="date_of_birth"
                                   class="{{ $errors->first('date_of_birth') ? 'register-error-input' : '' }}"
                                   value="{{ old('date_of_birth') }}"/>
                            @if ($errors->first('date_of_birth'))
                                <span class="register-error-content">{{ $errors->first('date_of_birth') }}</span>
                            @endif
                            <input type="text" placeholder="Phone Number" name="phone_number"
                                   class="{{ $errors->first('phone_number') ? 'register-error-input' : '' }}"
                                   value="{{ old('phone_number') }}"/>
                            @if ($errors->first('phone_number'))
                                <span class="register-error-content">{{ $errors->first('phone_number') }}</span>
                            @endif
                            {{-- <input type="text" placeholder="Address" name="address"
                                class="{{ $errors->first('address') ? 'register-error-input' : '' }}"
                                value="{{ old('address') }}" />
                            @if ($errors->first('address'))
                                <span class="register-error-content">{{ $errors->first('address') }}</span>
                            @endif --}}
                            <input type="email" placeholder="Email Address" name="email"
                                   class="{{ $errors->first('email') ? 'register-error-input' : '' }}"
                                   value="{{ old('email') }}"/>
                            @if ($errors->first('email'))
                                <span class="register-error-content">{{ $errors->first('email') }}</span>
                            @endif
                            <input type="password" placeholder="Password" name="password"
                                   class="{{ $errors->first('password') ? 'register-error-input' : '' }}"
                                   value="{{ old('password') }}"/>
                            @if ($errors->first('password'))
                                <span class="register-error-content">{{ $errors->first('password') }}</span>
                            @endif
                            <button type="submit" class="btn btn-default">Signup</button>
                        </form>
                    </div>
                    <!--/sign up form-->
                </div>
            </div>
        </div>
    </section>
    <!--/form-->
@endsection
