<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">
</head>

<body class="login">
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form action="{{ route('admin.login') }}" method="POST">
                    @csrf
                    <h1>Login Form</h1>
                    <div>
                        <input type="text"
                               class="form-control {{ $errors->first('username') ? 'register-error-input' : '' }}"
                               placeholder="Username" required="" name="username"
                               value="{{ Session::has('dataError') ? Session::get('dataError')['username'] : '' }}{{ old('username') }}"/>
                    </div>
                    @if ($errors->first('username'))
                        <span class="register-error-content">{{ $errors->first('username') }}</span>
                    @endif
                    <div>
                        <input type="password"
                               class="form-control {{ $errors->first('password') ? 'register-error-input' : '' }}"
                               placeholder="Password" required="" name="password"/>
                    </div>
                    @if ($errors->first('password'))
                        <span class="register-error-content">{{ $errors->first('password') }}</span>
                    @endif

                    @if(Session::has('error'))
                        <span class="register-error-content">{{ Session::get('error') }}</span>
                    @endif
                    <div>
                        <button type="submit" class="btn btn-info">Log in</button>
                        <a class="reset_pass" href="#">Lost your password?</a>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
</body>

</html>
