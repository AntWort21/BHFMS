<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\Chat;
use App\Models\ManagerBoarding;
use App\Models\OwnerBoarding;
use App\Models\TenantBoarding;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function getChatPage()
    {
        $userRoleId = User::where('id', Auth::user()->id)->first()->user_role_id;
        $contactIDs = [];
        if ($userRoleId == 2) { //tenant
            $boardingId = TenantBoarding::where('user_id', Auth::user()->id)->where('tenant_status', 'approved')->first()->boarding_id ?? -1;

            array_push($contactIDs, OwnerBoarding::where('boarding_id', $boardingId)->first()->user_id ?? -1);
            array_push($contactIDs, ManagerBoarding::where('boarding_id', $boardingId)->first()->user_id ?? -1);
        } elseif ($userRoleId == 3) { //owner
            $boardingIDs = OwnerBoarding::where('user_id', Auth::user()->id)->where('owner_status', 'approved')->get()->pluck('boarding_id') ?? -1;

            foreach ($boardingIDs as $boardingId) {
                array_push($contactIDs, ...TenantBoarding::where('boarding_id', $boardingId)->where('tenant_status', 'approved')->get()->pluck('user_id') ?? -1);
                array_push($contactIDs, ManagerBoarding::where('boarding_id', $boardingId)->first()->user_id ?? -1);
            }
        } elseif ($userRoleId == 4) { //manager
            $boardingId = ManagerBoarding::where('user_id', Auth::user()->id)->first()->boarding_id ?? -1;

            array_push($contactIDs, ...TenantBoarding::where('boarding_id', $boardingId)->where('tenant_status', 'approved')->get()->pluck('user_id') ?? -1);
            array_push($contactIDs, OwnerBoarding::where('boarding_id', $boardingId)->first()->user_id ?? -1);
        }

        $contactDetails = [];
        foreach ($contactIDs as $id) {
            if ($id == -1) {
                continue;
            }
            array_push($contactDetails, User::where('id', $id)->first());
        }

        return Inertia::render('Chat', ['contactDetails' => $contactDetails]);
    }

    public function getChatMessage(Request $request)
    {
        $messagesSent = Chat::where('sender_id', Auth::user()->id)->where('receiver_id', $request->id)->get();
        $messagesReceived = Chat::where('sender_id', $request->id)->where('receiver_id', Auth::user()->id)->get();

        $messages = $messagesSent->merge($messagesReceived)->sortBy('id')->values()->all();

        return response()->json([
            'messages' => $messages,
            'receiverDetails' => User::where('id', $request->id)->first()
        ]);
    }

    public function storeChatMessage(Request $request)
    {
        $message = Chat::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $request->id,
            'message' => $request->message,
        ]);

        broadcast(new NewChatMessage($message))->toOthers();

        return back();
    }
}
