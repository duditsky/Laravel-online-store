<?php

namespace App\Services\AI;

use OpenAI\Laravel\Facades\OpenAI;
use App\Models\Product;
use Exception;

class AssistantService
{
    public function getResponse(array $chatHistory, string $userName = 'Клієнт')
    {
        try {
            // 1. Отримуємо товари. Використовуємо універсальний підхід
            $products = Product::take(10)->get(); 

            $productContext = "Список наших товарів:\n";
            foreach ($products as $product) {
                // Використовуємо ?? (null coalescing), щоб підтримати і укр і англ назви полів
                $name = $product->назва ?? $product->name ?? 'Товар без назви';
                $priceValue = $product->ціна ?? $product->price ?? 0;
                $description = $product->опис ?? $product->description ?? '';
                
                $price = number_format((float)$priceValue, 2, '.', '');
                $desc = $description ? " (Опис: {$description})" : "";
                
                $productContext .= "- {$name}: ціна {$price} грн.{$desc}\n";
            }

            // 2. Персоналізована системна інструкція
            $systemMessage = [
                'role' => 'system',
                'content' => "Ти — віртуальний консультант магазину комп'ютерної техніки. 
                      Зараз ти спілкуєшся з користувачем: {$userName}.
                      ОБОВ'ЯЗКОВО звертайся до нього по імені {$userName} у кожній відповіді.
                      Ось твої знання про товари: \n$productContext\n
                      Відповідай ввічливо українською мовою."
            ];

            // 3. Обмежуємо історію та додаємо системне повідомлення
            $limitedHistory = array_slice($chatHistory, -10);
            $messages = array_merge([$systemMessage], $limitedHistory);

            // 4. Запит до OpenAI (використовуємо правильний шлях до фасаду)
            $result = \OpenAI\Laravel\Facades\OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => $messages,
                'temperature' => 0.7,
            ]);

            return $result->choices[0]->message->content;

        } catch (Exception $e) {
          
            // Повертаємо текст користувачу
            return "Вибачте, {$userName}, сталася технічна заминка. Спробуйте, будь ласка, ще раз!";
        }
    }
}