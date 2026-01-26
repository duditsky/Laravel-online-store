
<div id="chat-widget" class="d-flex flex-column align-items-end">
    <div id="chat-hint" class="shadow-sm border mb-2 px-3 py-2 bg-white rounded-pill text-dark small fw-bold" onclick="toggleChat()">
        Чим я можу вам допомогти?
    </div>

    <button id="chat-button" class="btn btn-primary rounded-circle shadow-lg p-0 overflow-hidden d-flex align-items-center justify-content-center" onclick="toggleChat()">
        <img src="{{ asset('img/my-photo.jpg') }}" alt="AI" class="w-100 h-100 object-fit-cover" onerror="this.src='https://ui-avatars.com/api/?name=AI&background=0D6EFD&color=fff'">
    </button>

    <div id="chat-window" class="card shadow-lg border-0 flex-column overflow-hidden">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <h6 class="mb-0 fw-bold">AI Помічник</h6>
            <button type="button" class="btn-close btn-close-white" onclick="toggleChat()"></button>
        </div>

        <div id="chat-messages" class="card-body p-3 d-flex flex-column bg-light">
            <div class="p-2 bot-msg shadow-sm small mb-2 border">
                @if(auth()->check())
                Привіт, **{{ auth()->user()->name }}**! 👋 Я ваш асистент. Чим можу допомогти сьогодні?
                @else
                Привіт! 👋 Я ваш асистент. Запитайте мене про товари!
                @endif
            </div>
        </div>

        <div class="card-footer bg-white p-3 border-top-0">
            <div class="input-group bg-light rounded-pill px-2 py-1 border">
                <input type="text" id="chat-input" class="form-control form-control-sm border-0 bg-transparent shadow-none" placeholder="Ваше запитання...">
                <button class="btn btn-primary btn-sm rounded-circle" type="button" onclick="sendMessage()" style="width: 32px; height: 32px;">
                    ➤
                </button>
            </div>
        </div>
    </div>
</div>