@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Perfil da Cloudinha -->
    <div class="card mb-4 shadow-sm border-primary rounded-4 p-3 d-flex flex-row align-items-center">
        <div class="me-3">
            <video autoplay muted loop class="rounded-circle border border-primary" style="width:120px; height:120px; object-fit:cover;">
                <source src="{{ asset('videos/CLOUDINHA.mp4') }}" type="video/mp4">
                Seu navegador não suporta vídeo.
            </video>
        </div>
        <div class="flex-fill">
            <h2 class="mb-1">Cloudinha 🌤️</h2>
            <p class="text-muted mb-2">@cloudinha_assistant</p>
            <p class="mb-0">
                🤖 Assistente Meteorológica Inteligente<br>
                💬 Responde perguntas sobre clima, tempo e curiosidades<br>
                🔗 <a href="https://www.linkedin.com/in/cloudinha-assistant" target="_blank" class="text-primary">Saiba mais</a>
            </p>
        </div>
    </div>

    <!-- Chat -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white text-center rounded-top">
            🌤️ Chat com Cloudinha
        </div>
        <div class="card-body" id="chat-box" style="min-height:300px; overflow-y:auto;">
            <div class="chat-bubble aura p-3 mb-2 rounded-3 bg-light">
                Oi! Eu sou a Cloudinha. Pergunte algo sobre clima ou curiosidades.
            </div>
        </div>
        <div class="card-footer d-flex">
            <input id="prompt" type="text" placeholder="Pergunte algo à Cloudinha..." class="form-control me-2">
            <button id="send" class="btn btn-primary">Enviar</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('send').addEventListener('click', async (e) => {
    e.preventDefault();
    const prompt = document.getElementById('prompt').value.trim();
    if (!prompt) return;

    const chatBox = document.getElementById('chat-box');

    const userMsg = document.createElement('div');
    userMsg.className = 'chat-bubble user p-3 mb-2 rounded-3 text-white bg-primary text-end';
    userMsg.textContent = prompt;
    chatBox.appendChild(userMsg);

    document.getElementById('prompt').value = '';

    const response = await fetch('/cloudinha', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ prompt })
    });

    const data = await response.json();
    const cloudReply = data?.choices?.[0]?.message?.content || '⚠️ Erro ao obter resposta.';

    const cloudMsg = document.createElement('div');
    cloudMsg.className = 'chat-bubble aura p-3 mb-2 rounded-3 bg-light';
    cloudMsg.textContent = cloudReply;
    chatBox.appendChild(cloudMsg);

    chatBox.scrollTop = chatBox.scrollHeight;
});
</script>
@endsection

@section('styles')
<style>
body {
    background: linear-gradient(to bottom, #f0f8ff, #e6f2ff);
    font-family: "Poppins", sans-serif;
}

.card {
    border-radius: 1rem;
}

.profile-card video {
    transition: transform 0.3s;
}

.profile-card video:hover {
    transform: scale(1.05);
}

.chat-bubble {
    word-wrap: break-word;
    max-width: 75%;
    padding: 12px 16px;
    border-radius: 20px;
    margin-bottom: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    animation: fadeIn 0.3s ease-in-out;
}

.user {
    margin-left: auto;
    background: #0d6efd;
    color: #fff;
}

.aura {
    background: #ffffff;
    border: 1px solid #d1d9e6;
}

#chat-box {
    min-height: 300px;
    overflow-y: auto;
    padding: 15px;
}

#chat-box::-webkit-scrollbar {
    width: 8px;
}

#chat-box::-webkit-scrollbar-thumb {
    background-color: rgba(0, 123, 255, 0.5);
    border-radius: 4px;
}

.card-footer input {
    border-radius: 50px;
    padding: 12px 16px;
    border: 1px solid #ced4da;
    transition: 0.3s;
}

.card-footer input:focus {
    outline: none;
    border-color: #0d6efd;
    box-shadow: 0 0 5px rgba(13,110,253,0.3);
}

.card-footer button {
    border-radius: 50px;
    padding: 0 20px;
    transition: 0.3s;
}

.card-footer button:hover {
    background-color: #0b5ed7;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px);}
    to { opacity: 1; transform: translateY(0);}
}
</style>
@endsection


