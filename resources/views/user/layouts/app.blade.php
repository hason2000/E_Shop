<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | E-Shopper</title>
    <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/user/style.css') }}">
</head><!--/head-->
<body>
@if(auth('web')->check())
    <div class="d-none" id="info-user-online"
         data-info="{{ auth('web')->id() }}-{{auth()->user()->name}}-{{ auth()->user()->avatar }}"
         data-key="{{ auth('web')->id() }}"></div>

@endif
@include('user.layouts.header')
@yield('content')

@include('user.layouts.footer')
@if(auth('web')->check())
    @include("user.layouts.chat-page")
@endif

@if(auth('web')->check())
    <script src="{{ asset('js/user/socket/main.js') }}"></script>
@endif
<script src="{{ asset('js/user/custom.js') }}"></script>
</body>
