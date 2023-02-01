<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">

        @include('admin.layouts.header')
        @yield('content')
        @include('admin.layouts.footer')

        <script src="{{ asset('js/admin/custom.js') }}"></script>
        @include('sweetalert::alert')
    </div>
</div>
</body>

</html>
