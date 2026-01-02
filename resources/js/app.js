import './bootstrap';

const form = document.getElementById('chatForm');
const input = document.getElementById('chatInput');
const messages = document.getElementById('chatMessages');

function scrollToBottom() {
    messages.scrollTop = messages.scrollHeight;
}

function addUserMessage(text) {
    const wrapper = document.createElement('div');
    wrapper.className = 'flex items-start gap-4 justify-end';

    wrapper.innerHTML = `
        <div class="bg-indigo-600 text-white rounded-2xl px-4 py-3 max-w-[80%]">
            <p class="text-sm"></p>
        </div>
        <div class="h-8 w-8 rounded-full bg-slate-300 flex items-center justify-center text-sm font-semibold">
            U
        </div>
    `;

    wrapper.querySelector('p').textContent = text;
    messages.appendChild(wrapper);
    scrollToBottom();
}

function addTypingIndicator() {
    const wrapper = document.createElement('div');
    wrapper.id = 'typingIndicator';
    wrapper.className = 'flex items-start gap-4';

    wrapper.innerHTML = `
        <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-white text-sm font-bold">
            AI
        </div>
        <div class="bg-slate-100 rounded-2xl px-4 py-3 text-sm text-slate-500">
            AI is thinking…
        </div>
    `;

    messages.appendChild(wrapper);
    scrollToBottom();
}

function removeTypingIndicator() {
    const el = document.getElementById('typingIndicator');
    if (el) el.remove();
}

function addAIMessage(text) {
    const wrapper = document.createElement('div');
    wrapper.className = 'flex items-start gap-4';

    wrapper.innerHTML = `
        <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-white text-sm font-bold">
            AI
        </div>
        <div class="bg-slate-100 rounded-2xl px-4 py-3 max-w-[80%]">
            <p class="text-sm"></p>
        </div>
    `;

    wrapper.querySelector('p').textContent = text;
    messages.appendChild(wrapper);
    scrollToBottom();
}

form.addEventListener('submit', (e) => {
    e.preventDefault();

    const text = input.value.trim();
    if (!text) return;

    addUserMessage(text);
    input.value = '';
    input.focus();

    addTypingIndicator();

    // Simulated AI response (replace with real API call next)
    setTimeout(() => {
        removeTypingIndicator();
        addAIMessage(
            "Nice choice! Based on that, I’d recommend Arrival, Ad Astra, and Solaris. Want something faster-paced or more philosophical?"
        );
    }, 1200);
});
