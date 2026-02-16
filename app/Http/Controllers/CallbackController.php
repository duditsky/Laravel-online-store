<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CallbackRequest;
use Illuminate\Support\Facades\Http;

class CallbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
        ]);

        $callback = CallbackRequest::create([
            'name'   => $request->name,
            'phone'  => preg_replace('/[^0-9]/', '', $request->phone),
            'status' => 'new'
        ]);

        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        if ($token && $chatId) {
            $text = "🔔 *New Callback Request*\n\n";
            $text .= "👤 *Customer:* {$callback->name}\n";
            $text .= "📞 *Phone:* +{$callback->phone}\n";
            $text .= "⏰ *Time:* " . $callback->created_at->format('H:i');

            $keyboard = [
                'inline_keyboard' => [[
                    [
                        'text' => '✅ Mark as Processed',
                        'callback_data' => 'complete_' . $callback->id
                    ]
                ]]
            ];

            Http::withoutVerifying()->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'Markdown',
                'reply_markup' => json_encode($keyboard)
            ]);
        }

        return back()->with('success', 'Thank you! We will call you back.');
    }

    public function handleWebhook(Request $request)
    {
        $callbackQuery = $request->input('callback_query');

        if ($callbackQuery) {
            $data = $callbackQuery['data'];
            $chatId = $callbackQuery['message']['chat']['id'];
            $messageId = $callbackQuery['message']['message_id'];
            $callbackQueryId = $callbackQuery['id'];
            $token = env('TELEGRAM_BOT_TOKEN');

            if (str_starts_with($data, 'complete_')) {
                $id = str_replace('complete_', '', $data);
                $callback = CallbackRequest::find($id);

                if ($callback) {

                    $callback->update(['status' => 'completed']);

                    Http::withoutVerifying()->post("https://api.telegram.org/bot{$token}/answerCallbackQuery", [
                        'callback_query_id' => $callbackQueryId,
                        'text' => 'Request processed!'
                    ]);

                    Http::withoutVerifying()->post("https://api.telegram.org/bot{$token}/editMessageText", [
                        'chat_id'    => $chatId,
                        'message_id' => $messageId,
                        'text'       => "✅ *PROCESSED: Request #{$id}*\n\n👤 *Customer:* {$callback->name}\n🚀 *Status:* Completed",
                        'parse_mode' => 'Markdown',
                        'reply_markup' => json_encode([
                            'inline_keyboard' => [[
                                ['text' => '💎 Done', 'callback_data' => 'done']
                            ]]
                        ])
                    ]);
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
