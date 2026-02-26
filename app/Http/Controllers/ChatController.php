<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AI\AssistantService;
use App\Models\ChatSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ChatController extends Controller
{
    public function __invoke(Request $request, AssistantService $assistant)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $userMessage = $request->input('message');
        $sessionToken = Session::getId();


        $chatSession = ChatSession::firstOrCreate(
            ['session_token' => $sessionToken],
            [
                'user_id' => Auth::id(),
                'user_ip' => $request->ip()
            ]
        );


        if (Auth::check() && !$chatSession->user_id) {
            $chatSession->update(['user_id' => Auth::id()]);
        }


        $chatSession->messages()->create([
            'role' => 'user',
            'content' => $userMessage
        ]);


        $history = $chatSession->messages()
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($m) => [
                'role' => $m->role,
                'content' => $m->content
            ])
            ->toArray();


        $userName = Auth::check() ? Auth::user()->name : 'Гість';
        $aiResponse = $assistant->getResponse($history, $userName);


        $chatSession->messages()->create([
            'role' => 'assistant',
            'content' => $aiResponse
        ]);

        return response()->json([
            'answer' => $aiResponse
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
