<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ChatController extends Controller
{
    public function showChat()
    {
        return view('chat');
    }

    public function getAllMsg()
    {
        $messages = Message::select(['users.email', 'messages.message'])
            ->join('users', 'users.id', '=', 'messages.user_id')
            ->get();

        return response()->json($messages);
    }

    public function sendMsg(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $message = $user->messages()->create([
            'message' => $request->message
        ]);

        Redis::publish('message', json_encode([
            'email'     => $user->email,
            'message'   => $message->message
        ]));

        return response()->json([
            'message_id' => $message->id
        ]);
    }
}
