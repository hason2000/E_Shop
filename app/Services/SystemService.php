<?php

namespace App\Services;

use App\Mail\RegisterMail;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class SystemService
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function sendMailConfirm($user)
    {
        $token = Crypt::encryptString($user->id . "=>" . date('') . now());
        $mailable = new RegisterMail($user, $token);
        Mail::to($user->email)->send($mailable);
    }
}
