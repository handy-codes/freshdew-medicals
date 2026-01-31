<?php
/**
 * AI Chat Button Component
 * 
 * @package FreshDewMedical
 */
?>

<div id="ai-chat-widget" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;">
    <!-- Chat Button -->
    <button id="ai-chat-toggle" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; color: white; font-size: 24px; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.3); transition: transform 0.3s; display: flex; align-items: center; justify-content: center;">
        <span id="chat-icon">💬</span>
        <span id="close-icon" style="display: none;">×</span>
    </button>
    
    <!-- Chat Window -->
    <div id="ai-chat-window" style="display: none; position: absolute; bottom: 80px; right: 0; width: 350px; max-width: calc(100vw - 40px); height: 500px; background: white; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.2); flex-direction: column; overflow: hidden;">
        <!-- Chat Header -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1rem; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600;">AI Assistant</h3>
                <p style="margin: 0.25rem 0 0; font-size: 0.875rem; opacity: 0.9;">FreshDew Medical Clinic</p>
            </div>
        </div>
        
        <!-- Messages Container -->
        <div id="chat-messages" style="flex: 1; overflow-y: auto; padding: 1rem; background: #f9fafb;">
            <div class="message assistant" style="background: white; padding: 0.75rem 1rem; border-radius: 12px; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <p style="margin: 0; color: #1f2937; line-height: 1.6;">Hello! I'm FreshDew Medical Clinic AI Assistant. How can I help you today? You can ask about symptoms, book appointments, find doctors, or get health information.</p>
            </div>
        </div>
        
        <!-- Typing Indicator -->
        <div id="typing-indicator" style="display: none; padding: 0 1rem 1rem;">
            <div style="background: white; padding: 0.75rem 1rem; border-radius: 12px; display: inline-block;">
                <span style="display: inline-block; width: 8px; height: 8px; background: #667eea; border-radius: 50%; margin-right: 4px; animation: typing 1.4s infinite;"></span>
                <span style="display: inline-block; width: 8px; height: 8px; background: #667eea; border-radius: 50%; margin-right: 4px; animation: typing 1.4s infinite 0.2s;"></span>
                <span style="display: inline-block; width: 8px; height: 8px; background: #667eea; border-radius: 50%; animation: typing 1.4s infinite 0.4s;"></span>
            </div>
        </div>
        
        <!-- Input Area -->
        <div style="padding: 1rem; background: white; border-top: 1px solid #e5e7eb;">
            <div style="display: flex; gap: 0.5rem;">
                <input type="text" id="chat-input" placeholder="Type your message..." style="flex: 1; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.875rem; outline: none;" />
                <button id="chat-send" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Send</button>
            </div>
            <div style="margin-top: 0.5rem; display: flex; flex-wrap: wrap; gap: 0.5rem;">
                <button class="quick-action" style="padding: 0.5rem 1rem; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 20px; font-size: 0.75rem; cursor: pointer; color: #4b5563;">Book appointment</button>
                <button class="quick-action" style="padding: 0.5rem 1rem; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 20px; font-size: 0.75rem; cursor: pointer; color: #4b5563;">Find doctor</button>
                <button class="quick-action" style="padding: 0.5rem 1rem; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 20px; font-size: 0.75rem; cursor: pointer; color: #4b5563;">Hours</button>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes typing {
    0%, 60%, 100% { transform: translateY(0); }
    30% { transform: translateY(-10px); }
}

#ai-chat-toggle:hover {
    transform: scale(1.1);
}

.message {
    max-width: 80%;
    word-wrap: break-word;
}

.message.user {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    margin-left: auto;
    text-align: right;
}

.message.assistant {
    background: white;
    color: #1f2937;
}

.quick-action:hover {
    background: #e5e7eb !important;
}

@media (max-width: 768px) {
    #ai-chat-widget {
        bottom: 15px;
        right: 15px;
    }
    
    #ai-chat-window {
        width: calc(100vw - 30px);
        height: calc(100vh - 100px);
        bottom: 85px;
    }
}
</style>

<script>
(function() {
    const chatToggle = document.getElementById('ai-chat-toggle');
    const chatWindow = document.getElementById('ai-chat-window');
    const chatIcon = document.getElementById('chat-icon');
    const closeIcon = document.getElementById('close-icon');
    const chatInput = document.getElementById('chat-input');
    const chatSend = document.getElementById('chat-send');
    const chatMessages = document.getElementById('chat-messages');
    const typingIndicator = document.getElementById('typing-indicator');
    const quickActions = document.querySelectorAll('.quick-action');
    
    let isOpen = false;
    
    // Toggle chat window
    chatToggle.addEventListener('click', function() {
        isOpen = !isOpen;
        chatWindow.style.display = isOpen ? 'flex' : 'none';
        chatIcon.style.display = isOpen ? 'none' : 'inline';
        closeIcon.style.display = isOpen ? 'inline' : 'none';
        
        if (isOpen) {
            chatInput.focus();
        }
    });
    
    // Send message
    function sendMessage(message) {
        if (!message.trim()) return;
        
        // Add user message
        const userMsg = document.createElement('div');
        userMsg.className = 'message user';
        userMsg.innerHTML = '<p style="margin: 0; line-height: 1.6;">' + escapeHtml(message) + '</p>';
        chatMessages.appendChild(userMsg);
        
        // Show typing indicator
        typingIndicator.style.display = 'block';
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        // Clear input
        chatInput.value = '';
        
        // Send to API
        fetch('<?php echo esc_url(rest_url('freshdew/v1/ai-chat')); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            typingIndicator.style.display = 'none';
            
            const assistantMsg = document.createElement('div');
            assistantMsg.className = 'message assistant';
            assistantMsg.innerHTML = '<p style="margin: 0; color: #1f2937; line-height: 1.6;">' + escapeHtml(data.response || 'I apologize, but I could not process your request. Please try again.') + '</p>';
            chatMessages.appendChild(assistantMsg);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        })
        .catch(error => {
            typingIndicator.style.display = 'none';
            
            const errorMsg = document.createElement('div');
            errorMsg.className = 'message assistant';
            errorMsg.innerHTML = '<p style="margin: 0; color: #1f2937; line-height: 1.6;">I apologize, but I\'m having trouble processing your request. Please try again or contact us at <?php echo esc_js($contact_info['phone_formatted']); ?>.</p>';
            chatMessages.appendChild(errorMsg);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });
    }
    
    chatSend.addEventListener('click', function() {
        sendMessage(chatInput.value);
    });
    
    chatInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage(chatInput.value);
        }
    });
    
    // Quick actions
    quickActions.forEach(button => {
        button.addEventListener('click', function() {
            sendMessage(this.textContent);
        });
    });
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
})();
</script>

<?php
$contact_info = freshdew_get_contact_info();
?>

