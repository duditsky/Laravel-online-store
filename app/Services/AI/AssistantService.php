<?php

namespace App\Services\AI;

use OpenAI\Laravel\Facades\OpenAI;
use App\Models\Product;
use Exception;

class AssistantService
{
    public function getResponse(array $chatHistory)
    {
        try {
            // 1. Отримуємо товари
            $products = Product::take(15)->get(['name', 'price', 'description']);

            $productContext = "Список наших товарів:\n";
            foreach ($products as $product) {
                $price = number_format($product->price, 2, '.', ''); 
                $desc = $product->description ? " (Опис: {$product->description})" : "";
                $productContext .= "- {$product->name}: ціна {$price} грн.{$desc}\n";
            }

            // 2. Системна інструкція
            $systemMessage = [
                'role' => 'system',
                'content' => "Ти помічник магазину. Твої знання про асортимент: \n$productContext\n Відповідай ввічливо українською мовою. Якщо клієнт питає про товар, якого немає в списку, скажи, що асортимент оновлюється."
            ];

            // 3. Обмежуємо історію (беремо останні 10 повідомлень, щоб не переплачувати)
            $limitedHistory = array_slice($chatHistory, -10);
            $messages = array_merge([$systemMessage], $limitedHistory);

            // 4. Запит до OpenAI
            $result = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => $messages,
                'temperature' => 0.7, // Додає боту трохи "людяності" та креативності
            ]);

            return $result->choices[0]->message->content;

        } catch (Exception $e) {
            // Якщо щось пішло не так, повертаємо безпечне повідомлення
            logger()->error("OpenAI Error: " . $e->getMessage());
            return "Вибачте, я зараз потребую перезавантаження. Спробуйте поставити запитання ще раз через хвилину.";
        }
    }
}