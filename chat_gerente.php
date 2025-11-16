<?php
include 'templates/header.php';
?>

<style>
    #chat-window {
        height: 400px;
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow-y: scroll;
        padding: 15px;
        margin-bottom: 15px;
        background-color: #f9f9f9;
    }
    .message {
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 10px;
        line-height: 1.4;
    }
    .message.user {
        background-color: #e1f5fe;
        margin-left: auto;
        max-width: 80%;
        text-align: right;
    }
    .message.assistant {
        background-color: #f1f1f1;
        max-width: 80%;
        text-align: left;
    }
    .message .sender {
        font-weight: bold;
        margin-bottom: 5px;
        font-size: 0.9em;
        color: #555;
    }
    #loading-indicator {
        display: none;
        text-align: center;
        padding: 10px;
        color: #888;
    }
</style>

<div class="container mt-5">
    <h2>Asistente de Gerencia (Gemini)</h2>
    <p>Haz una pregunta sobre el inventario en lenguaje natural.</p>

    <div id="chat-window">
        <div class="message assistant">
            <div class="sender">Asistente</div>
            Hola, soy tu asistente de inventario. ¿En qué puedo ayudarte hoy?
        </div>
    </div>

    <div id="loading-indicator">
        <div class="spinner-border spinner-border-sm" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        Pensando...
    </div>

    <form id="chat-form">
        <div class="input-group">
            <input type="text" id="message-input" class="form-control" placeholder="Escribe tu pregunta aquí..." required autocomplete="off">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
    </form>
</div>

<script>
    const chatWindow = document.getElementById('chat-window');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const loadingIndicator = document.getElementById('loading-indicator');

    let chatHistory = [];

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const userMessage = messageInput.value.trim();
        if (!userMessage) return;

        addMessageToHistory('user', userMessage);
        addMessageToUI(userMessage, 'user');
        messageInput.value = '';
        
        loadingIndicator.style.display = 'block';

        try {
            const response = await fetch('api/chat.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ 
                    mensaje: userMessage,
                    history: chatHistory 
                })
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error || `Error del servidor: ${response.statusText}`);
            }

            const data = await response.json();
            const assistantMessage = data.respuesta;

            addMessageToHistory('model', assistantMessage);
            addMessageToUI(assistantMessage, 'assistant');

        } catch (error) {
            console.error('Error:', error);
            addMessageToUI(`Hubo un error al contactar al asistente: ${error.message}`, 'assistant');
        } finally {
            loadingIndicator.style.display = 'none';
        }
    });

    function addMessageToUI(message, sender) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('message', sender);
        
        const senderName = sender === 'user' ? 'Tú' : 'Asistente';
        messageElement.innerHTML = `<div class="sender">${senderName}</div><div>${message}</div>`;
        
        chatWindow.appendChild(messageElement);
        chatWindow.scrollTop = chatWindow.scrollHeight; 
    }

    function addMessageToHistory(role, text) {
        chatHistory.push({ role: role, text: text });
    }

</script>

<?php
include 'templates/footer.php';
?>
