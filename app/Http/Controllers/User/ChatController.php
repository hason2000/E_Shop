<?php

namespace App\Http\Controllers\User;

use App\Events\UserChatEvent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
//        $this->middleware('guest');
    }

    public function sendMessage(Request $request, $shopId)
    {
        // Chưa dùng đến
//        $data = [
//            'message' => $request->message,
//            'senderId' => auth('web')->id(),
//            'senderName' => auth('web')->user()->name,
//            'receiverId' => $shopId
//        ];
//         broadcast(new UserChatEvent($data));
//         return response()->json(['success' => true]);
    }
}
