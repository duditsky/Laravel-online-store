<?php

namespace App\Services\AI;

use OpenAI\Laravel\Facades\OpenAI;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Log;

class AssistantService
{
    public function getResponse(array $chatHistory, string $userName = 'Клієнт')
    {
        try {
            // 1. Отримуємо товари (залишаємо логіку take(10), але додаємо легку фільтрацію)
            $lastUserMessage = collect($chatHistory)->last(fn($m) => $m['role'] === 'user')['content'] ?? '';

            // Шукаємо за назвою, якщо нічого не знайдено — беремо просто 10 товарів
            $products = Product::select('name', 'price', 'description')
                ->where('name', 'like', "%{$lastUserMessage}%")
                ->take(10)
                ->get();

            if ($products->isEmpty()) {
                $products = Product::select('name', 'price', 'description')->take(10)->get();
            }

            $productContext = "Список наших товарів:\n";
            foreach ($products as $product) {
                $name = $product->name ?? 'Товар без назви';
                $priceValue = $product->price ?? 0;
                $description = $product->description ?? '';

                $price = number_format((float)$priceValue, 2, '.', '');
                // Трохи скоротили опис для безпеки
                $shortDesc = mb_strimwidth($description, 0, 80, "...");

                $productContext .= "- {$name}: ціна {$price} грн. {$shortDesc}\n";
            }

            // 2. Системна інструкція (залишаємо вашу, вона чудова)
            $systemMessage = [
                'role' => 'system',
                'content' => "Ти — ввічливий консультант магазину комп'ютерної техніки. " .
                             "Звертайся до клієнта на ім'я {$userName}. " .
                             "Використовуй цей список товарів: \n$productContext\n" .
                             "Відповідай ввічливо українською мовою. " .
                             "Твоя відповідь має бути лаконічною (до 3 речень). " .
                             "Якщо товару немає в списку, ввічливо скажи, що зараз його немає в наявності."
            ];

            // 3. Підготовка історії (БЕЗ змін у логіці)
            $cleanHistory = collect($chatHistory)->whereIn('role', ['user', 'assistant'])->values()->all();
            $limitedHistory = array_slice($cleanHistory, -6); // 6 повідомлень — ідеально для пам'яті

            $messages = array_merge([$systemMessage], $limitedHistory);

            // 4. Запит до OpenAI
            $result = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => $messages,
                'temperature' => 0.7,
                'max_tokens' => 250, // трохи збільшили, щоб відповідь не обривалася на півслові
            ]);

            return $result->choices[0]->message->content;

        } catch (Exception $e) {
            Log::error("OpenAI Error: " . $e->getMessage());
            return "Вибачте, {$userName}, сталася технічна заминка. Спробуйте ще раз!";
        }
    }
}