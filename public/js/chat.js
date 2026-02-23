/**
 * Скрипт керування чат-помічником
 */

// Функція відкриття/закриття вікна чату
function toggleChat() {
    const chatWindow = document.getElementById('chat-window');
    const chatHint = document.getElementById('chat-hint');
    const chatInput = document.getElementById('chat-input');

    if (!chatWindow || !chatHint) return;

    if (chatWindow.style.display === 'flex') {
        chatWindow.style.display = 'none';
        chatHint.style.opacity = '1';
    } else {
        chatWindow.style.display = 'flex';
        chatHint.style.opacity = '0';
        // Фокусуємося на полі введення при відкритті
        if (chatInput) chatInput.focus();
    }
}

// Головна функція відправки повідомлення
async function sendMessage() {
    const input = document.getElementById('chat-input');
    const container = document.getElementById('chat-messages');
    
    if (!input || !container) return;

    const message = input.value.trim();

    // Перевірка на порожнє повідомлення
    if (!message) return;

    // 1. Додаємо повідомлення користувача в інтерфейс
    appendMessage('user', message);
    
    // Очищуємо поле введення та блокуємо його на час запиту
    input.value = '';
    input.disabled = true;

    // 2. Створюємо тимчасовий блок для анімації завантаження
    const loadingId = 'loading-' + Date.now();
    appendMessage('bot', `
        <div class="d-flex align-items-center">
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            Думаю...
        </div>
    `, loadingId);

    try {
        // 3. Запит до сервера (використовуємо .json() для обробки об'єкта)
        const response = await fetch(`/chat?message=${encodeURIComponent(message)}`);
        
        if (!response.ok) throw new Error('Network response was not ok');

        const data = await response.json();
        const botMsgDiv = document.getElementById(loadingId);

        if (botMsgDiv) {
            // Виводимо тільки текст відповіді (поле 'answer')
            botMsgDiv.innerHTML = data.answer || "Вибачте, не вдалося сформувати відповідь.";
            botMsgDiv.classList.remove('text-muted');
        }

    } catch (e) {
        console.error('AI Chat Error:', e);
        const botMsgDiv = document.getElementById(loadingId);
        if (botMsgDiv) {
            botMsgDiv.innerHTML = "<span class='text-danger'>Помилка з'єднання. Спробуйте пізніше.</span>";
        }
    } finally {
        // 4. Розблоковуємо поле введення
        input.disabled = false;
        input.focus();
        // Прокручуємо вниз
        container.scrollTop = container.scrollHeight;
    }
}

/**
 * Допоміжна функція для додавання повідомлень у контейнер
 * @param {string} type - 'user' або 'bot'
 * @param {string} text - зміст повідомлення
 * @param {string|null} id - унікальний ID (для блоку завантаження)
 */
function appendMessage(type, text, id = null) {
    const container = document.getElementById('chat-messages');
    if (!container) return;

    const msgClass = type === 'user' 
        ? 'user-msg ms-auto bg-primary text-white' 
        : 'bot-msg border bg-light text-dark';
    
    const alignment = type === 'user' ? 'text-end' : 'text-start';

    const html = `
        <div class="mb-3 ${alignment}">
            <div class="p-2 d-inline-block shadow-sm small ${msgClass}" 
                 style="max-width: 85%; border-radius: 12px; word-wrap: break-word;"
                 ${id ? `id="${id}"` : ''}>
                ${text}
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
    container.scrollTop = container.scrollHeight;
}

// Ініціалізація при завантаженні сторінки
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('chat-input');
    
    if (input) {
        // Відправка по натисканню Enter
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !input.disabled) {
                sendMessage();
            }
        });
    }
});