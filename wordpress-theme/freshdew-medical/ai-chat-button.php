<?php
/**
 * AI Chat Button Component
 * 
 * @package FreshDewMedical
 */
$contact_info = freshdew_get_contact_info();
?>

<!-- Chat Button - Separate from widget container, like Next.js -->
<button id="ai-chat-toggle" style="position: fixed !important; bottom: 16px !important; right: 16px !important; z-index: 9999 !important; width: auto !important; min-width: 100px !important; height: 44px !important; border-radius: 22px !important; background: #9333EA !important; border: none !important; color: white !important; font-size: 14px !important; font-weight: 600 !important; cursor: pointer !important; box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important; transition: transform 0.3s, background-color 0.3s !important; display: flex !important; align-items: center !important; justify-content: center !important; padding: 0 16px !important; gap: 6px !important; pointer-events: auto !important;" onmouseover="this.style.backgroundColor='#7E22CE'" onmouseout="this.style.backgroundColor='#9333EA'">
    <svg id="chat-icon-svg" style="width: 16px; height: 16px; fill: currentColor;" viewBox="0 0 24 24">
        <!-- Three radiating arrowhead elements -->
        <path d="M12 2L14 8L20 6L14 10L22 12L14 14L20 18L14 16L12 22L10 16L4 18L10 14L2 12L10 10L4 6L10 8L12 2Z" />
    </svg>
    <span id="chat-text-full">Ask Dew</span>
    <span id="chat-text-short" style="display: none;">Ask Dew</span>
    <span id="close-icon" style="display: none;">×</span>
</button>

<!-- Audio element for reply sound effect -->
<audio id="chat-reply-sound" preload="auto" style="display: none;">
    <source src="<?php echo esc_url(get_template_directory_uri() . '/assets/audio/chat-reply.mp3'); ?>" type="audio/mpeg">
    <source src="<?php echo esc_url(home_url('/chat-reply.mp3')); ?>" type="audio/mpeg">
</audio>

<!-- Chat Window Container - Separate wrapper, no width/height causing overflow -->
<div id="ai-chat-widget-root" style="position: fixed; top: 0; left: 0; width: 0; height: 0; z-index: 9998; pointer-events: none;">
<div id="ai-chat-widget" style="position: fixed !important; bottom: 80px !important; right: 16px !important; z-index: 9998 !important; pointer-events: auto !important;">
    <!-- Chat Window -->
    <div id="ai-chat-window" style="display: none; position: fixed; bottom: 96px; right: 24px; width: 360px; max-width: calc(100vw - 32px); height: 520px; max-height: calc(100vh - 140px); background: white; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.2); flex-direction: column; overflow: hidden; z-index: 100000;">
        <!-- Chat Header (Sticky) -->
        <div id="chat-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1rem; display: flex; justify-content: space-between; align-items: center; cursor: pointer; position: sticky; top: 0; z-index: 1;">
            <div>
                <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600; color: white;">AI Assistant</h3>
                <p style="margin: 0.25rem 0 0; font-size: 0.875rem; opacity: 0.9; color: white;">FreshDew Medical Clinic</p>
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
    <div id="chat-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9997;"></div>
</div>
</div><!-- Close ai-chat-widget-root -->

<style>
@keyframes typing {
    0%, 60%, 100% { transform: translateY(0); }
    30% { transform: translateY(-10px); }
}

#ai-chat-toggle:hover {
    transform: scale(1.05) !important;
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

/* Simple fixed positioning - exactly like Next.js implementation */
/* Button is directly fixed to viewport - no wrapper causing overflow */
#ai-chat-toggle {
    position: fixed !important;
    bottom: 16px !important;
    right: 16px !important;
    z-index: 9999 !important;
    pointer-events: auto !important;
    cursor: pointer !important;
    display: flex !important;
    visibility: visible !important;
    opacity: 1 !important;
    margin: 0 !important;
    padding: 0 16px !important;
}

/* Always show "Ask Dew" text at all screen sizes */
#chat-text-full {
    display: inline !important;
}

#chat-text-short {
    display: none !important;
}

/* Chat window container - separate from button */
#ai-chat-widget-root {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 0 !important;
    height: 0 !important;
    z-index: 9998 !important;
    pointer-events: none !important;
}

#ai-chat-widget {
    position: fixed !important;
    bottom: 80px !important;
    right: 16px !important;
    z-index: 9998 !important;
    pointer-events: auto !important;
}

/* Responsive: Desktop/Tablet (640px+) - Show full text, match Next.js md: breakpoint */
@media (min-width: 640px) {
    #ai-chat-toggle {
        bottom: 24px !important;
        right: 24px !important;
        min-width: 120px !important;
        height: 50px !important;
        font-size: 16px !important;
        padding: 0 20px !important;
        gap: 8px !important;
        border-radius: 25px !important;
    }
    
    #ai-chat-widget {
        bottom: 96px !important;
        right: 24px !important;
    }
    
    #chat-text-full {
        display: inline !important;
    }
    
    #chat-text-short {
        display: none !important;
    }
}

/* Responsive: Mobile (< 640px) - Show "Ask Dew" but smaller */
@media (max-width: 639px) {
    /* Button stays fixed - simple positioning like Next.js */
    #ai-chat-toggle {
        bottom: 16px !important;
        right: 16px !important;
        min-width: 100px !important;
        height: 44px !important;
        font-size: 12px !important;
        padding: 0 12px !important;
    }
    
    #ai-chat-widget {
        bottom: 80px !important;
        right: 16px !important;
        left: auto !important;
        width: auto !important;
    }
    
    #chat-text-full {
        display: inline !important;
    }
    
    #chat-text-short {
        display: none !important;
    }
    
    #ai-chat-window {
        bottom: 80px !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
        right: auto !important;
        width: calc(100vw - 48px) !important;
        max-width: 320px !important;
        height: min(460px, calc(100vh - 140px)) !important;
        max-height: min(460px, calc(100vh - 140px)) !important;
        position: fixed !important;
        z-index: 2147483647 !important;
    }
    
    #chat-messages {
        max-height: calc(100vh - 340px) !important;
    }
    
    /* Ensure widget is visible even when menu is open - MAXIMUM PRIORITY */
    body.menu-open #ai-chat-widget-root,
    body.menu-open #ai-chat-widget,
    body.menu-open #ai-chat-toggle,
    html.menu-open #ai-chat-widget-root,
    html.menu-open #ai-chat-widget,
    html.menu-open #ai-chat-toggle {
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
        const chatIconSvg = document.getElementById('chat-icon-svg');
        const chatTextFull = document.getElementById('chat-text-full');
        const chatTextShort = document.getElementById('chat-text-short');
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
            chatIconSvg: !!chatIconSvg,
            chatTextFull: !!chatTextFull,
            chatTextShort: !!chatTextShort
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
            const chatIconSvg = document.getElementById('chat-icon-svg');
            if (chatIconSvg) chatIconSvg.style.display = 'inline-block';
            const chatTextFull = document.getElementById('chat-text-full');
            const chatTextShort = document.getElementById('chat-text-short');
            if (chatTextFull) chatTextFull.style.display = 'inline';
            if (chatTextShort) {
                chatTextShort.style.display = 'none';
            }
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
            const chatIconSvg = document.getElementById('chat-icon-svg');
            if (chatIconSvg) chatIconSvg.style.display = 'none';
            const chatTextFull = document.getElementById('chat-text-full');
            const chatTextShort = document.getElementById('chat-text-short');
            if (chatTextFull) chatTextFull.style.display = 'none';
            if (chatTextShort) chatTextShort.style.display = 'none';
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
    
    // Save messages to localStorage
    function saveMessagesToStorage() {
        try {
            const messages = [];
            const messageElements = chatMessages.querySelectorAll('.message');
            messageElements.forEach(msg => {
                const isUser = msg.classList.contains('user');
                const text = msg.querySelector('p')?.textContent || '';
                if (text.trim()) {
                    messages.push({
                        type: isUser ? 'user' : 'assistant',
                        text: text
                    });
                }
            });
            localStorage.setItem('freshdew_chat_messages', JSON.stringify(messages));
        } catch (e) {
            console.log('Could not save messages to localStorage:', e);
        }
    }
    
    // Load messages from localStorage
    function loadMessagesFromStorage() {
        try {
            const saved = localStorage.getItem('freshdew_chat_messages');
            if (saved) {
                const messages = JSON.parse(saved);
                // Only load if we have saved messages
                if (messages.length > 0) {
                    // Clear any existing messages
                    chatMessages.innerHTML = '';
                    
                    messages.forEach(msg => {
                        const msgDiv = document.createElement('div');
                        msgDiv.className = 'message ' + msg.type;
                        const p = document.createElement('p');
                        p.style.margin = '0';
                        p.style.lineHeight = '1.6';
                        if (msg.type === 'user') {
                            p.textContent = msg.text;
                        } else {
                            p.style.color = '#1f2937';
                            p.textContent = msg.text;
                        }
                        msgDiv.appendChild(p);
                        chatMessages.appendChild(msgDiv);
                    });
                    
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                } else {
                    // No saved messages, show welcome message
                    showWelcomeMessage();
                }
            } else {
                // No saved data, show welcome message
                showWelcomeMessage();
            }
        } catch (e) {
            console.log('Could not load messages from localStorage:', e);
            showWelcomeMessage();
        }
    }
    
    // Show welcome message
    function showWelcomeMessage() {
        const welcomeMsg = document.createElement('div');
        welcomeMsg.className = 'message assistant';
        welcomeMsg.style.cssText = 'background: white; padding: 0.75rem 1rem; border-radius: 12px; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); max-width: 85%;';
        welcomeMsg.innerHTML = '<p style="margin: 0; color: #1f2937; line-height: 1.6;">Hello! I\'m FreshDew Medical Clinic AI Assistant. How can I help you today? You can ask about symptoms, book appointments, find doctors, or get health information.</p>';
        chatMessages.appendChild(welcomeMsg);
    }
    
    // Send message
    function sendMessage(message) {
        if (!message.trim()) return;
        
        // Add user message
        const userMsg = document.createElement('div');
        userMsg.className = 'message user';
        userMsg.innerHTML = '<p style="margin: 0; line-height: 1.6;">' + escapeHtml(message) + '</p>';
        chatMessages.appendChild(userMsg);
        
        // Save to localStorage
        saveMessagesToStorage();
        
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
            const messageText = data.response || 'I apologize, but I could not process your request. Please try again.';
            const messageParagraph = document.createElement('p');
            messageParagraph.style.margin = '0';
            messageParagraph.style.color = '#1f2937';
            messageParagraph.style.lineHeight = '1.6';
            assistantMsg.appendChild(messageParagraph);
            chatMessages.appendChild(assistantMsg);
            
            // Type out the message with natural reading pace
            typeMessage(messageParagraph, messageText, function() {
                chatMessages.scrollTop = chatMessages.scrollHeight;
                
                // Play reply sound after message is typed
                const replySound = document.getElementById('chat-reply-sound');
                if (replySound) {
                    replySound.currentTime = 0;
                    replySound.play().catch(e => console.log('Could not play reply sound:', e));
                }
                
                // Save messages to localStorage
                saveMessagesToStorage();
            });
        })
        .catch(error => {
            typingIndicator.style.display = 'none';
            
            const errorMsg = document.createElement('div');
            errorMsg.className = 'message assistant';
            const errorParagraph = document.createElement('p');
            errorParagraph.style.margin = '0';
            errorParagraph.style.color = '#1f2937';
            errorParagraph.style.lineHeight = '1.6';
            const errorText = 'I apologize, but I\'m having trouble processing your request. Please try again or contact us at <?php echo esc_js($contact_info['phone_formatted']); ?>.';
            errorMsg.appendChild(errorParagraph);
            chatMessages.appendChild(errorMsg);
            
            // Type out the error message
            typeMessage(errorParagraph, errorText, function() {
                chatMessages.scrollTop = chatMessages.scrollHeight;
                
                // Play reply sound after error message is typed
                const replySound = document.getElementById('chat-reply-sound');
                if (replySound) {
                    replySound.currentTime = 0;
                    replySound.play().catch(e => console.log('Could not play reply sound:', e));
                }
                
                // Save messages to localStorage
                saveMessagesToStorage();
            });
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
        
        // Handle window resize for responsive text
        function updateChatButtonText() {
            if (!isOpen) {
                if (chatTextFull && chatTextShort) {
                    // Always show "Ask Dew" on both mobile and desktop
                    chatTextFull.style.display = 'inline';
                    chatTextShort.style.display = 'none';
                }
            }
        }
        
        window.addEventListener('resize', updateChatButtonText);
        updateChatButtonText(); // Initial call
    
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        // Type message with natural reading pace animation
        function typeMessage(element, text, callback) {
            const escapedText = escapeHtml(text);
            let index = 0;
            const typingSpeed = 20; // milliseconds per character (adjust for speed: lower = faster)
            const pauseOnPunctuation = 100; // extra pause after punctuation
            
            function typeChar() {
                if (index < escapedText.length) {
                    const char = escapedText[index];
                    element.innerHTML += char;
                    index++;
                    
                    // Add extra pause after punctuation for natural reading
                    const delay = (char === '.' || char === '!' || char === '?' || char === ',') 
                        ? typingSpeed + pauseOnPunctuation 
                        : typingSpeed;
                    
                    // Scroll to bottom as we type
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                    
                    setTimeout(typeChar, delay);
                } else {
                    // Finished typing
                    if (callback) callback();
                }
            }
            
            // Start typing
            typeChar();
        }
    }
    
        // Initialize when DOM is ready  
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initChat);
        } else {
            initChat();
        }
        
        // Load saved messages on page load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(loadMessagesFromStorage, 100);
            });
        } else {
            setTimeout(loadMessagesFromStorage, 100);
        }
})();
</script>
