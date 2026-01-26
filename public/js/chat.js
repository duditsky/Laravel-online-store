function toggleChat() {
    const chatWindow = document.getElementById('chat-window');
    chatWindow.style.display = chatWindow.style.display === 'flex' ? 'none' : 'flex';
}

async function sendMessage() {
    const input = document.getElementById('chat-input');
    const container = document.getElementById('chat-messages');
    const message = input.value.trim();

    if (!message) return;

    container.insertAdjacentHTML('beforeend', `<div class="p-2 user-msg shadow-sm align-self-end small">${message}</div>`);
    input.value = '';
    container.scrollTop = container.scrollHeight;

    const loadingId = 'loading-' + Date.now();
    container.insertAdjacentHTML('beforeend', `
        <div class="p-2 bot-msg shadow-sm align-self-start small text-muted" id="${loadingId}">
            <span class="spinner-border spinner-border-sm"></span> Думаю...
        </div>
    `);

    try {
        const response = await fetch(`/chat?message=${encodeURIComponent(message)}`);
        const data = await response.text();
        const botMsgDiv = document.getElementById(loadingId);
        botMsgDiv.innerHTML = data;
        botMsgDiv.classList.remove('text-muted');
    } catch (e) {
        document.getElementById(loadingId).innerHTML = "Помилка зв'язку.";
    }
    container.scrollTop = container.scrollHeight;
}

document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('chat-input');
    if(input) {
        input.addEventListener('keypress', (e) => { if (e.key === 'Enter') sendMessage(); });
    }
});