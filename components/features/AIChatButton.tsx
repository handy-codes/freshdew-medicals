// components/features/AIChatButton.tsx
'use client';

import { useState, useRef, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import {
  X,
  Send,
  Bot,
  User,
  Loader2,
  Sparkles,
} from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Card, CardContent } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { useAI } from '@/components/providers/AIProvider';

interface Message {
  id: string;
  content: string;
  role: 'user' | 'assistant';
  timestamp: Date;
}

export default function AIChatButton() {
  const [isOpen, setIsOpen] = useState(false);
  const [input, setInput] = useState('');
  const [messages, setMessages] = useState<Message[]>([
    {
      id: '1',
      content: 'Hello! I\'m FreshDew Medical Clinic AI Assistant. How can I help you today? You can ask about symptoms, book appointments, find doctors, or get health information.',
      role: 'assistant',
      timestamp: new Date(),
    },
  ]);
  const [isTyping, setIsTyping] = useState(false);
  const messagesEndRef = useRef<HTMLDivElement>(null);
  const { getAIResponse } = useAI();

  const scrollToBottom = () => {
    messagesEndRef.current?.scrollIntoView({ behavior: 'smooth' });
  };

  useEffect(() => {
    scrollToBottom();
  }, [messages]);

  const handleSend = async () => {
    if (!input.trim()) return;

    const userMessage: Message = {
      id: Date.now().toString(),
      content: input,
      role: 'user',
      timestamp: new Date(),
    };

    setMessages((prev) => [...prev, userMessage]);
    setInput('');
    setIsTyping(true);

    try {
      const response = await getAIResponse(input);
      
      const assistantMessage: Message = {
        id: (Date.now() + 1).toString(),
        content: response,
        role: 'assistant',
        timestamp: new Date(),
      };

      setMessages((prev) => [...prev, assistantMessage]);
    } catch (error) {
      console.error('AI Response error:', error);
      
      const errorMessage: Message = {
        id: (Date.now() + 1).toString(),
        content: 'I apologize, but I\'m having trouble processing your request. Please try again or contact our support team.',
        role: 'assistant',
        timestamp: new Date(),
      };

      setMessages((prev) => [...prev, errorMessage]);
    } finally {
      setIsTyping(false);
    }
  };

  const handleKeyPress = (e: React.KeyboardEvent) => {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      handleSend();
    }
  };

  const quickActions = [
    'Book appointment',
    'Find a doctor',
    'Symptoms check',
    'Pharmacy hours',
    'Emergency info',
    'COVID guidelines',
  ];

  return (
    <>
      {/* Floating Button */}
      <motion.div
        className="fixed bottom-4 right-4 md:bottom-6 md:right-6 z-[9999] pointer-events-auto"
        initial={{ scale: 0, rotate: 180 }}
        animate={{ scale: 1, rotate: 0 }}
        transition={{ type: 'spring', stiffness: 200, damping: 20 }}
      >
        <Button
          onClick={() => setIsOpen(true)}
          className="rounded-full px-3 py-2 md:px-5 md:py-3 shadow-2xl text-white font-semibold flex items-center gap-1.5 md:gap-2 text-sm md:text-base"
          style={{ backgroundColor: '#9333EA' }}
          onMouseEnter={(e) => e.currentTarget.style.backgroundColor = '#7E22CE'}
          onMouseLeave={(e) => e.currentTarget.style.backgroundColor = '#9333EA'}
        >
          <svg className="w-4 h-4 md:w-5 md:h-5" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2L14 8L20 6L14 10L22 12L14 14L20 18L14 16L12 22L10 16L4 18L10 14L2 12L10 10L4 6L10 8L12 2Z" />
            <circle cx="12" cy="12" r="2" fill="currentColor" />
          </svg>
          <span>Ask Dew</span>
        </Button>
      </motion.div>

      {/* Chat Window */}ich
      <AnimatePresence>
        {isOpen && (
          <>
            {/* Backdrop to close on outside click */}
            <motion.div
              className="fixed inset-0 z-[9998] bg-black/30"
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              exit={{ opacity: 0 }}
              onClick={() => setIsOpen(false)}
            />

          <motion.div
            initial={{ opacity: 0, scale: 0.9, y: 20 }}
            animate={{ opacity: 1, scale: 1, y: 0 }}
            exit={{ opacity: 0, scale: 0.9, y: 20 }}
            className="fixed z-[9999] bottom-2 left-2 right-2 md:right-6 md:left-auto md:bottom-24 w-auto md:w-96 max-w-md mx-auto"
            style={{ maxHeight: 'calc(100vh - 80px)' }}
          >
            <Card className="shadow-2xl border-gray-200 bg-white rounded-xl md:rounded-2xl overflow-hidden flex flex-col h-full max-h-[calc(100vh-80px)] md:max-h-[600px]">
              <CardContent className="p-0 flex flex-col h-full">
                {/* Header - Sticky */}
                <div className="sticky top-0 z-50 p-2 md:p-4 border-b bg-gradient-to-r from-blue-600 to-teal-500 text-white rounded-t-lg md:rounded-t-xl flex-shrink-0">
                  <div className="flex items-center justify-between">
                    <div className="flex items-center space-x-2 md:space-x-3 min-w-0">
                      <div className="relative flex-shrink-0">
                        <Bot className="w-6 h-6 md:w-8 md:h-8" />
                        <Sparkles className="w-2 h-2 md:w-3 md:h-3 absolute -top-0.5 -right-0.5 md:-top-1 md:-right-1 text-yellow-300" />
                      </div>
                      <div className="min-w-0">
                        <h3 className="font-bold text-xs md:text-base truncate">FreshDew AI Assistant</h3>
                        <div className="flex items-center space-x-1.5 md:space-x-2">
                          <div className="w-1.5 h-1.5 md:w-2 md:h-2 bg-green-400 rounded-full animate-pulse flex-shrink-0" />
                          <p className="text-[10px] md:text-xs opacity-90">Online • 24/7</p>
                        </div>
                      </div>
                    </div>
                    <Button
                      variant="ghost"
                      size="icon"
                      onClick={() => setIsOpen(false)}
                      className="text-white hover:bg-white/20 flex-shrink-0 ml-1 md:ml-2 h-7 w-7 md:h-10 md:w-10"
                      aria-label="Close chat"
                    >
                      <X className="w-3 h-3 md:w-4 md:h-4" />
                    </Button>
                  </div>
                </div>

                {/* Messages - Scrollable area under sticky header */}
                <div className="flex-1 overflow-y-auto p-3 md:p-4 space-y-3 md:space-y-4 bg-gray-50 text-gray-900 min-h-0" style={{ maxHeight: 'calc(100% - 200px)' }}>
                  {messages.map((message) => (
                    <motion.div
                      key={message.id}
                      initial={{ opacity: 0, y: 10 }}
                      animate={{ opacity: 1, y: 0 }}
                      className={`flex ${message.role === 'user' ? 'justify-end' : 'justify-start'}`}
                    >
                      <div
                        className={`max-w-[80%] rounded-2xl p-3 ${
                          message.role === 'user'
                            ? 'bg-blue-500 text-white rounded-br-none'
                            : 'bg-white border border-gray-200 rounded-bl-none'
                        }`}
                      >
                        <div className="flex items-start space-x-2">
                          {message.role === 'assistant' && (
                            <Bot className="w-4 h-4 mt-1 text-gray-400 flex-shrink-0" />
                          )}
                          <div className="min-w-0">
                            <p className="text-sm leading-relaxed break-words">{message.content}</p>
                            <p className="text-xs opacity-70 mt-1">
                              {message.timestamp.toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit',
                              })}
                            </p>
                          </div>
                          {message.role === 'user' && (
                            <User className="w-4 h-4 mt-1 text-blue-200 flex-shrink-0" />
                          )}
                        </div>
                      </div>
                    </motion.div>
                  ))}
                  
                  {isTyping && (
                    <div className="flex justify-start">
                      <div className="bg-white border border-gray-200 rounded-2xl rounded-bl-none p-3">
                        <div className="flex space-x-1">
                          <div className="w-2 h-2 bg-gray-300 rounded-full animate-bounce" />
                          <div className="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style={{ animationDelay: '0.1s' }} />
                          <div className="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style={{ animationDelay: '0.2s' }} />
                        </div>
                      </div>
                    </div>
                  )}
                  <div ref={messagesEndRef} />
                </div>

                {/* Quick Actions */}
                <div className="p-2 md:p-3 bg-white flex-shrink-0">
                  <div className="flex flex-wrap gap-1.5 md:gap-2 mb-2 md:mb-3">
                    {quickActions.map((action) => (
                      <Badge
                        key={action}
                        variant="secondary"
                        className="cursor-pointer hover:bg-gray-200 text-[10px] md:text-xs px-2 py-0.5 bg-gray-100 text-gray-900 border border-gray-300"
                        onClick={() => setInput(action)}
                      >
                        {action}
                      </Badge>
                    ))}
                  </div>

                  {/* Input Area - removed border-t */}
                  <div className="flex space-x-1.5 md:space-x-2">
                    <Input
                      value={input}
                      onChange={(e) => setInput(e.target.value)}
                      onKeyPress={handleKeyPress}
                      placeholder="Type your message..."
                      className="flex-1 bg-white text-gray-900 text-sm md:text-base h-9 md:h-10"
                    />
                    <Button
                      onClick={handleSend}
                      disabled={!input.trim() || isTyping}
                      className="bg-gradient-to-r from-blue-600 to-teal-500 hover:from-blue-700 hover:to-teal-600 h-9 md:h-10 px-3 md:px-4"
                      title="Send message"
                    >
                      {isTyping ? (
                        <Loader2 className="w-3 h-3 md:w-4 md:h-4 animate-spin" />
                      ) : (
                        <Send className="w-3 h-3 md:w-4 md:h-4" />
                      )}
                    </Button>
                  </div>
                </div>

                {/* Footer */}
                <div className="px-2 md:px-4 py-1.5 md:py-2 bg-gray-50 border-t text-center flex-shrink-0">
                  <p className="text-[10px] md:text-xs text-gray-500">
                    Powered by FreshDew AI • Secure & Private
                  </p>
                </div>
              </CardContent>
            </Card>
          </motion.div>
          </>
        )}
      </AnimatePresence>
    </>
  );
}