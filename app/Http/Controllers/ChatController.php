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
        // 1. Валідація (щоб не слати порожні запити в OpenAI)
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $userMessage = $request->input('message');
        $sessionToken = Session::getId();

        // 2. Знаходимо або створюємо сесію
        $chatSession = ChatSession::firstOrCreate(
            ['session_token' => $sessionToken],
            [
                'user_id' => Auth::id(),
                'user_ip' => $request->ip()
            ]
        );

        // 3. Актуалізуємо ID користувача, якщо він щойно авторизувався
        if (Auth::check() && !$chatSession->user_id) {
            $chatSession->update(['user_id' => Auth::id()]);
        }

        // 4. Зберігаємо повідомлення користувача
        $chatSession->messages()->create([
            'role' => 'user',
            'content' => $userMessage
        ]);

        // 5. Отримуємо історію для ШІ (беремо останні 10-15 повідомлень)
        $history = $chatSession->messages()
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($m) => [
                'role' => $m->role,
                'content' => $m->content
            ])
            ->toArray();

        // 6. Отримуємо відповідь
        $userName = Auth::check() ? Auth::user()->name : 'Гість';
        $aiResponse = $assistant->getResponse($history, $userName);

        // 7. Зберігаємо відповідь асистента
        $chatSession->messages()->create([
            'role' => 'assistant',
            'content' => $aiResponse
        ]);

        // 8. Повертаємо JSON (так зручніше для фронтенда)
        return response()->json([
    'answer' => $aiResponse
], 200, [], JSON_UNESCAPED_UNICODE);
    }
}