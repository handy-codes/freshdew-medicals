<?php
/**
 * AI Chat Button Component
 * 
 * @package FreshDewMedical
 */
$contact_info = freshdew_get_contact_info();
?>

<!-- Wrapper to isolate from parent transforms - MUST be direct child of body -->
<div id="ai-chat-widget-root" style="position: fixed; top: 0; left: 0; width: 0; height: 0; z-index: 2147483647; pointer-events: none; isolation: isolate;">
<div id="ai-chat-widget" style="position: fixed !important; bottom: 24px !important; right: 24px !important; z-index: 2147483647 !important; pointer-events: auto !important; transform: translateZ(0) !important; will-change: transform !important;">
    <!-- Chat Button -->
    <button id="ai-chat-toggle" style="width: auto !important; min-width: 120px !important; height: 50px !important; border-radius: 25px !important; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; border: none !important; color: white !important; font-size: 16px !important; font-weight: 600 !important; cursor: pointer !important; box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important; transition: transform 0.3s !important; display: flex !important; align-items: center !important; justify-content: center !important; padding: 0 20px !important; gap: 8px !important; position: relative !important; z-index: 100000 !important; pointer-events: auto !important;">
        <span id="chat-icon">💬</span>
        <span id="chat-text">Ask Dew</span>
        <span id="close-icon" style="display: none;">×</span>
    </button>
    
    <!-- Chat Window -->
    <div id="ai-chat-window" style="display: none; position: fixed; bottom: 96px; right: 24px; width: 360px; max-width: calc(100vw - 32px); height: 520px; max-height: calc(100vh - 140px); background: white; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.2); flex-direction: column; overflow: hidden; z-index: 100000;">
        <!-- Chat Header (Sticky) -->
        <div id="chat-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1rem; display: flex; justify-content: space-between; align-items: center; cursor: pointer; position: sticky; top: 0; z-index: 1;">
            <div>
                <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600;">AI Assistant</h3>
                <p style="margin: 0.25rem 0 0; font-size: 0.875rem; opacity: 0.9;">FreshDew Medical Clinic</p>
            </div>
            <button id="chat-close-btn" style="background: rgba(255,255,255,0.2); border: none; color: white; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; font-size: 20px; font-weight: bold; display: flex; align-items: center; justify-content: center; transition: background 0.3s;">×</button>
        </div>
        
        <!-- Messages Container (Scrollable) -->
        <div id="chat-messages" style="flex: 1; overflow-y: auto; padding: 1rem; background: #f9fafb; min-height: 0;">
            <div class="message assistant" style="background: white; padding: 0.75rem 1rem; border-radius: 12px; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); max-width: 85%;">
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
        
        <!-- Input Area (Sticky) -->
        <div style="padding: 1rem; background: white; border-top: 1px solid #e5e7eb; position: sticky; bottom: 0;">
            <div style="display: flex; gap: 0.5rem; align-items: stretch;">
                <input type="text" id="chat-input" placeholder="Type your message..." style="flex: 1; min-width: 0; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.875rem; outline: none;" />
                <button id="chat-send" style="flex: 0 0 auto; padding: 0.75rem 1.1rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Send</button>
            </div>
            <div style="margin-top: 0.5rem; display: flex; flex-wrap: wrap; gap: 0.5rem;">
                <button class="quick-action" style="padding: 0.5rem 1rem; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 20px; font-size: 0.75rem; cursor: pointer; color: #4b5563;">Book appointment</button>
                <button class="quick-action" style="padding: 0.5rem 1rem; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 20px; font-size: 0.75rem; cursor: pointer; color: #4b5563;">Find doctor</button>
                <button class="quick-action" style="padding: 0.5rem 1rem; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 20px; font-size: 0.75rem; cursor: pointer; color: #4b5563;">Hours</button>
            </div>
        </div>
    </div>
    
    <!-- Overlay for mobile -->
    <div id="chat-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9998;"></div>
</div>
</div><!-- Close ai-chat-widget-root -->

<style>
@keyframes typing {
    0%, 60%, 100% { transform: translateY(0); }
    30% { transform: translateY(-10px); }
}

#ai-chat-toggle:hover {
    transform: scale(1.05);
}

#chat-close-btn:hover {
    background: rgba(255,255,255,0.3) !important;
}

.message {
    word-wrap: break-word;
}

.message.user {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    margin-left: auto;
    margin-right: 0;
    text-align: right;
    padding: 0.75rem 1rem;
    border-radius: 12px;
    margin-bottom: 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    max-width: 85%;
    border: 2px solid rgba(255,255,255,0.3);
}

.message.assistant {
    background: white;
    color: #1f2937;
    max-width: 85%;
}

.quick-action:hover {
    background: #e5e7eb !important;
}

.ai-chat-sandbox,
#ai-chat-widget,
#ai-chat-widget * {
    box-sizing: border-box;
}

@media (max-width: 768px) {
    /* Force widget to be at body level, not inside menu - use maximum z-index */
    body #ai-chat-widget-root,
    body #ai-chat-widget {
        position: fixed !important;
        top: auto !important;
        left: auto !important;
        bottom: 20px !important;
        right: 16px !important;
        z-index: 2147483647 !important; /* Maximum z-index value */
        pointer-events: auto !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        transform: translateZ(0) !important;
        will-change: transform !important;
        max-width: calc(100vw - 32px) !important;
    }
    
    /* Ensure chat button is always clickable */
    #ai-chat-toggle {
        width: auto !important;
        min-width: 100px !important;
        height: 44px !important;
        font-size: 14px !important;
        padding: 0 16px !important;
        position: relative !important;
        z-index: 2147483647 !important;
        pointer-events: auto !important;
        cursor: pointer !important;
        max-width: calc(100vw - 32px) !important;
    }
    
    #chat-text {
        font-size: 14px !important;
    }
    
    #ai-chat-window {
        bottom: 80px !important;
        right: 16px !important;
        left: 16px !important;
        width: calc(100vw - 32px) !important;
        height: min(520px, calc(100vh - 120px)) !important;
        max-height: min(520px, calc(100vh - 120px)) !important;
        position: fixed !important;
        z-index: 2147483647 !important; /* Maximum z-index */
    }
    
    #chat-messages {
        max-height: calc(100vh - 200px) !important;
    }
    
    /* Ensure widget is visible even when menu is open */
    body.menu-open #ai-chat-widget-root,
    body.menu-open #ai-chat-widget,
    body.menu-open #ai-chat-toggle {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        z-index: 2147483647 !important;
        position: fixed !important;
    }
}
</style>

<script>
console.log('Chat button script loading...');
(function() {
    console.log('Chat button script initialized');
    
    // Wait for DOM to be ready
    function initChat() {
        console.log('Initializing chat...');
        const chatToggle = document.getElementById('ai-chat-toggle');
        const chatWindow = document.getElementById('ai-chat-window');
        const chatIcon = document.getElementById('chat-icon');
        const chatText = document.getElementById('chat-text');
        const closeIcon = document.getElementById('close-icon');
        const chatCloseBtn = document.getElementById('chat-close-btn');
        const chatHeader = document.getElementById('chat-header');
        const chatOverlay = document.getElementById('chat-overlay');
        const chatInput = document.getElementById('chat-input');
        const chatSend = document.getElementById('chat-send');
        const chatMessages = document.getElementById('chat-messages');
        const typingIndicator = document.getElementById('typing-indicator');
        const quickActions = document.querySelectorAll('.quick-action');
        
        console.log('Chat elements found:', {
            chatToggle: !!chatToggle,
            chatWindow: !!chatWindow,
            chatIcon: !!chatIcon,
            chatText: !!chatText
        });
        
        // Check if all elements exist
        if (!chatToggle || !chatWindow) {
            console.error('Chat elements not found', { chatToggle, chatWindow });
            return;
        }
        
        // Ensure button is clickable
        chatToggle.style.pointerEvents = 'auto';
        chatToggle.style.cursor = 'pointer';
        chatToggle.setAttribute('tabindex', '0');
        
        let isOpen = false;
        
        function closeChat() {
            console.log('Closing chat...');
            isOpen = false;
            chatWindow.style.display = 'none';
            if (chatOverlay) chatOverlay.style.display = 'none';
            if (chatIcon) chatIcon.style.display = 'inline';
            if (chatText) chatText.style.display = 'inline';
            if (closeIcon) closeIcon.style.display = 'none';
            document.body.style.overflow = '';
        }
        
        function openChat() {
            console.log('Opening chat...');
            isOpen = true;
            chatWindow.style.display = 'flex';
            console.log('Chat window display set to flex');
            if (window.innerWidth <= 768) {
                if (chatOverlay) chatOverlay.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }
            if (chatIcon) chatIcon.style.display = 'none';
            if (chatText) chatText.style.display = 'none';
            if (closeIcon) closeIcon.style.display = 'inline';
            if (chatInput) {
                setTimeout(() => chatInput.focus(), 100);
            }
            console.log('Chat window should now be visible');
        }
        
        // Toggle chat window - multiple event listeners for reliability
        function handleToggle(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            console.log('Chat button clicked', isOpen);
            if (isOpen) {
                closeChat();
            } else {
                openChat();
            }
        }
        
        // Add click event
        chatToggle.addEventListener('click', handleToggle, true);
        chatToggle.addEventListener('touchend', handleToggle, true);
        
        // Also add to parent widget for mobile
        const chatWidget = document.getElementById('ai-chat-widget');
        if (chatWidget) {
            chatWidget.addEventListener('click', function(e) {
                if (e.target === chatToggle || chatToggle.contains(e.target)) {
                    handleToggle(e);
                }
            }, true);
        }
    
    // Close button
    chatCloseBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        closeChat();
    });
    
    // Close on header click
    chatHeader.addEventListener('click', function(e) {
        if (e.target === chatHeader || e.target.closest('h3') || e.target.closest('p')) {
            closeChat();
        }
    });
    
    // Close on overlay click
    chatOverlay.addEventListener('click', function() {
        closeChat();
    });
    
    // Close on outside click (desktop)
    document.addEventListener('click', function(e) {
        if (isOpen && window.innerWidth > 768) {
            if (!chatWindow.contains(e.target) && !chatToggle.contains(e.target)) {
                closeChat();
            }
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
    }
    
    // Initialize when DOM is ready  
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initChat);
    } else {
        initChat();
    }
})();
</script>
