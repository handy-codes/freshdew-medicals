"use client"

import React, { createContext, useContext, useState, useCallback } from 'react';

interface AIContextType {
  getAIResponse: (message: string) => Promise<string>;
  isLoading: boolean;
}

const AIContext = createContext<AIContextType | undefined>(undefined);

export function AIProvider({ children }: { children: React.ReactNode }) {
  const [isLoading, setIsLoading] = useState(false);

  const getAIResponse = useCallback(async (message: string): Promise<string> => {
    setIsLoading(true);
    try {
      const response = await fetch('/api/ai-chat', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ message }),
      });

      if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        console.error('AI API error:', errorData);
        throw new Error(errorData.error || 'Failed to get AI response');
      }

      const data = await response.json();
      return data.response || 'I apologize, but I could not process your request.';
    } catch (error: any) {
      console.error('AI Response error:', error);
      // Return helpful fallback message
      return 'I apologize, but I\'m having trouble processing your request right now. Please try again or contact our support team at (416) 123-4567.';
    } finally {
      setIsLoading(false);
    }
  }, []);

  return (
    <AIContext.Provider value={{ getAIResponse, isLoading }}>
      {children}
    </AIContext.Provider>
  );
}

export function useAI() {
  const context = useContext(AIContext);
  if (context === undefined) {
    throw new Error('useAI must be used within an AIProvider');
  }
  return context;
}






