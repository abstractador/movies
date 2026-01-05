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
            <p class="text-sm whitespace-pre-line"></p>
        </div>
    `;

    wrapper.querySelector('p').textContent = text;
    messages.appendChild(wrapper);
    scrollToBottom();
}

async function sendToApi(message) {
    const response = await fetch('/api/chat', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute('content'),
        },
        body: JSON.stringify({ message }),
    });

    if (!response.ok) {
        throw new Error('API request failed');
    }

    return response.json();
}

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const text = input.value.trim();
    if (!text) return;

    addUserMessage(text);
    input.value = '';
    input.focus();

    addTypingIndicator();
    startAIProgress();

    try {
        
        const data = await sendToApi(text);

        removeTypingIndicator();
        stopAIProgress();

        addAIMessage(
            data.answer || 'Sorry, I could not find a good answer.'
        );
    } catch (err) {
        console.error(err);
        removeTypingIndicator();
        addAIMessage(
            '⚠️ Something went wrong while talking to Movies AI. Please try again.'
        );
    }
});

const progressWrapper = document.getElementById('aiProgressWrapper');
const progressBar = document.getElementById('aiProgressBar');

let progressInterval = null;

function startAIProgress() {
    progressWrapper.classList.remove('hidden');
    progressBar.style.width = '10%';
    progressBar.textContent = '';

    let progress = 10;

    progressInterval = setInterval(() => {
        // Slowly advance but never reach 100%
        progress += Math.random() * 10;
        if (progress > 85) progress = 85;

        progressBar.style.width = progress + '%';
    }, 400);
}

function stopAIProgress() {
    if (progressInterval) {
        clearInterval(progressInterval);
        progressInterval = null;
    }

    progressBar.style.width = '100%';
    progressBar.textContent = 'Done';

    setTimeout(() => {
        progressWrapper.classList.add('hidden');
        progressBar.style.width = '0%';
    }, 300);
}

