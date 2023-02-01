<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | E-Shopper</title>
    <link rel="stylesheet" href="{{ asset('css/user/style.css') }}">
</head><!--/head-->
<body>
@include('user.layouts.header2')
@yield('content')

@include('user.layouts.footer')

<script src="{{ asset('js/user/custom.js') }}"></script>
@include('sweetalert::alert')
</body>
