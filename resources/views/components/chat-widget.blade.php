<div id="chat-widget">
    <button id="chat-button" class="btn btn-primary rounded-circle shadow-lg d-flex align-items-center justify-content-center" onclick="toggleChat()">
        <span style="font-size: 1.5rem;">💬</span>
    </button>

    <div id="chat-window" class="card shadow-lg border-0 mt-2 flex-column">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold">AI Помічник</h6>
            <button type="button" class="btn-close btn-close-white" onclick="toggleChat()"></button>
        </div>
        <div id="chat-messages" class="card-body p-3 d-flex flex-column gap-2">
            <div class="p-2 bot-msg shadow-sm align-self-start small">Привіт! 👋 Чим можу допомогти?</div>
        </div>
        <div class="card-footer bg-white p-2">
            <div class="input-group">
                <input type="text" id="chat-input" class="form-control form-control-sm border-0 shadow-none" placeholder="Запитайте щось...">
                <button class="btn btn-primary btn-sm px-3" type="button" onclick="sendMessage()">Ok</button>
            </div>
        </div>
    </div>
</div>