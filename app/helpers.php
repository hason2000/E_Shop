<?php

if (!function_exists('checkUserOnline')) {
    function checkUserOnline()
    {
        return auth('web')->check();
    }
}

if (!function_exists('infoUser')) {
    function infoUser()
    {
        $data = [
            "userId" => auth('web')->id(),
            "userName" => auth('web')->user()->name,
            "avatar" => auth('web')->user()->avatar
        ];

        return $data;
    }
}
