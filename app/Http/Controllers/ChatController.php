<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AI\AssistantService;

class ChatController extends Controller
{
    public function __invoke(Request $request, AssistantService $assistant)
    {
        // 1. Беремо повідомлення користувача
        $userMessage = $request->input('message', 'Привіт! Розкажи про товари.');

        // 2. Витягуємо історію чату з сесії (пам'ять)
        $history = session()->get('chat_history', []);

        // 3. Додаємо нове повідомлення в історію
        $history[] = ['role' => 'user', 'content' => $userMessage];

        // 4. Запитуємо ШІ (передаємо всю історію)
        $aiResponse = $assistant->getResponse($history);

        // 5. Додаємо відповідь ШІ в історію
        $history[] = ['role' => 'assistant', 'content' => $aiResponse];

        // 6. Зберігаємо оновлену історію в сесію
        session()->put('chat_history', $history);

        return response($aiResponse);
    }
}