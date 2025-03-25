<?php
namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $message = Message::create([
            'sender_id' => auth()->id(), 
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        broadcast(new NewMessage($message))->toOthers();

        return response()->json($message);
    }

    public function getMessages($receiverId)
    {
        $senderId = auth()->id();
        $messages = Message::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                  ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', $senderId);
        })->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('chat', compact('users'));
    }
}