<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Chat::where('status', 'active')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('last_message_time', 'desc')
            ->get();
        
        return view('chat', compact('chats'));
    }

    public function getChat($id)
    {
        $chat = Chat::with('messages')->findOrFail($id);
        
        Message::where('chat_id', $id)
            ->where('sender', 'shop')
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        
        $chat->unread_count = 0;
        $chat->save();
        
        return response()->json([
            'success' => true,
            'data' => $chat
        ]);
    }

    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $chat = Chat::findOrFail($id);
        
        $message = Message::create([
            'chat_id' => $id,
            'sender' => 'user',
            'message' => $request->message,
            'is_read' => false
        ]);
        
        $chat->last_message = $request->message;
        $chat->last_message_time = now();
        $chat->unread_count = 0;
        $chat->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Pesan terkirim',
            'data' => $message
        ]);
    }

    public function togglePin($id)
    {
        $chat = Chat::findOrFail($id);
        $chat->is_pinned = !$chat->is_pinned;
        $chat->save();
        
        return response()->json([
            'success' => true,
            'is_pinned' => $chat->is_pinned
        ]);
    }

    public function archive($id)
    {
        $chat = Chat::findOrFail($id);
        $chat->status = 'archived';
        $chat->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Chat diarsipkan'
        ]);
    }

    public function destroy($id)
    {
        $chat = Chat::findOrFail($id);
        $chat->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Chat dihapus'
        ]);
    }

    public function getUnreadCount()
    {
        $totalUnread = Chat::where('status', 'active')
            ->sum('unread_count');
        
        return response()->json([
            'success' => true,
            'count' => $totalUnread
        ]);
    }
}