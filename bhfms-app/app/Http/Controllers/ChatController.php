<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function getChatPage()
    {
        $messages = Chat::where('sender_id', Auth::user()->id)->orWhere('receiver_id', Auth::user()->id)->get();
        return Inertia::render('Chat', ['messages' => $messages]);
    }

    public function storeChatMessage(Request $request)
    {
        $message = Chat::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => 3,
            'message' => $request->message,
        ]);

        broadcast(new NewChatMessage($message))->toOthers();

        return back();
    }
}
