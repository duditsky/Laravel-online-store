function toggleChat() {
    const chatWindow = document.getElementById('chat-window');
    const chatHint = document.getElementById('chat-hint');

    if (chatWindow.style.display === 'flex') {
        chatWindow.style.display = 'none';
        chatHint.style.opacity = '1';
    } else {
        chatWindow.style.display = 'flex';
        chatHint.style.opacity = '0';
        document.getElementById('chat-input').focus();
    }
}

async function sendMessage() {
    const input = document.getElementById('chat-input');
    const container = document.getElementById('chat-messages');
    const message = input.value.trim();

    if (!message) return;

    container.insertAdjacentHTML('beforeend', `<div class="p-2 user-msg shadow-sm small mb-2">${message}</div>`);
    input.value = '';
    container.scrollTop = container.scrollHeight;

    const loadingId = 'loading-' + Date.now();
    container.insertAdjacentHTML('beforeend', `
        <div class="p-2 bot-msg shadow-sm small mb-2 border text-muted" id="${loadingId}">
            <span class="spinner-border spinner-border-sm"></span> Думаю...
        </div>
    `);
    container.scrollTop = container.scrollHeight;

    try {
        const response = await fetch(`/chat?message=${encodeURIComponent(message)}`);
        const data = await response.text();

        const botMsgDiv = document.getElementById(loadingId);
        botMsgDiv.innerHTML = data;
        botMsgDiv.classList.remove('text-muted');
    } catch (e) {
        document.getElementById(loadingId).innerText = "Помилка. Перевірте з'єднання.";
    }

    container.scrollTop = container.scrollHeight;
}

document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('chat-input');
    if (input) {
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') sendMessage();
        });
    }
});