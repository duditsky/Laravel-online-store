<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AI\AssistantService;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Session;

class ChatController extends Controller
{
    public function __invoke(Request $request, AssistantService $assistant)
    {
        // 1. Отримуємо повідомлення та токен сесії
        $userMessage = $request->input('message');
        $sessionToken = Session::getId();

        // 2. Знаходимо сесію за токеном
        $chatSession = ChatSession::firstOrCreate(
            ['session_token' => $sessionToken],
            [
                'user_id' => auth()->id(),
                'user_ip' => request()->ip() // Ось так отримується IP
            ]
        );

        // 3. Якщо користувач залогінився, прив'язуємо його ID до сесії чату
        if (auth()->check() && !$chatSession->user_id) {
            $chatSession->update(['user_id' => auth()->id()]);
        }

        // 4. Отримуємо ім'я користувача для персоналізації
        $userName = auth()->check() ? auth()->user()->name : 'Гість';

        // 5. Зберігаємо повідомлення користувача в БД
        if ($userMessage) {
            $chatSession->messages()->create([
                'role' => 'user',
                'content' => $userMessage
            ]);
        }

        // 6. Формуємо історію повідомлень для ШІ
        $history = $chatSession->messages()
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($m) => [
                'role' => $m->role,
                'content' => $m->content
            ])
            ->toArray();

        // 7. Отримуємо відповідь від сервісу, передаючи ім'я
        $aiResponse = $assistant->getResponse($history, $userName);

        // 8. Зберігаємо відповідь асистента в БД
        $chatSession->messages()->create([
            'role' => 'assistant',
            'content' => $aiResponse
        ]);

        return response($aiResponse);
    }
}
