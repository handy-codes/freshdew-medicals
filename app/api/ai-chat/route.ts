import { NextRequest, NextResponse } from 'next/server';
import Groq from 'groq-sdk';

// Lazy initialization - only create client when needed and API key exists
function getGroqClient() {
  if (!process.env.GROQ_API_KEY) {
    return null;
  }
  return new Groq({
    apiKey: process.env.GROQ_API_KEY,
  });
}

export async function POST(request: NextRequest) {
  try {
    // Public endpoint: no auth required

    const { message } = await request.json();

    if (!message || typeof message !== 'string') {
      return NextResponse.json(
        { error: 'Message is required' },
        { status: 400 }
      );
    }

    // Check if Groq API key is configured
    if (!process.env.GROQ_API_KEY) {
      // Fallback to rule-based responses if API key is not set
      const responses: Record<string, string> = {
        'book appointment': 'To book an appointment, please visit our appointments page or call us at (416) 123-4567.',
        'find doctor': 'You can find our doctors by visiting the family practice page or contacting our office.',
        'symptoms': 'If you are experiencing symptoms, please book an appointment with one of our doctors. For emergencies, call 911.',
        'pharmacy': 'Our pharmacy hours are Monday-Friday 8AM-8PM, Saturday-Sunday 9AM-5PM.',
        'emergency': 'For life-threatening emergencies, please call 911 immediately.',
        'covid': 'For COVID-19 information and guidelines, please visit the Public Health Agency of Canada website.',
      };

      let response = 'I can help you with booking appointments, finding doctors, and general health information. How can I assist you today?';
      
      const lowerMessage = message.toLowerCase();
      for (const [key, value] of Object.entries(responses)) {
        if (lowerMessage.includes(key)) {
          response = value;
          break;
        }
      }

      return NextResponse.json({ response });
    }

    // Use Llama 3.1 8B Instant via Groq
    const groq = getGroqClient();
    if (!groq) {
      // Fallback to rule-based responses if API key is not set
      const responses: Record<string, string> = {
        'book appointment': 'To book an appointment, please visit our appointments page or call us at (416) 123-4567.',
        'find doctor': 'You can find our doctors by visiting the family practice page or contacting our office.',
        'symptoms': 'If you are experiencing symptoms, please book an appointment with one of our doctors. For emergencies, call 911.',
        'pharmacy': 'Our pharmacy hours are Monday-Friday 8AM-8PM, Saturday-Sunday 9AM-5PM.',
        'emergency': 'For life-threatening emergencies, please call 911 immediately.',
        'covid': 'For COVID-19 information and guidelines, please visit the Public Health Agency of Canada website.',
      };

      let response = 'I can help you with booking appointments, finding doctors, and general health information. How can I assist you today?';
      
      const lowerMessage = message.toLowerCase();
      for (const [key, value] of Object.entries(responses)) {
        if (lowerMessage.includes(key)) {
          response = value;
          break;
        }
      }

      return NextResponse.json({ response });
    }

    try {
      const systemPrompt = `You are a helpful AI assistant for FreshDew Medical Clinic in Canada. You help patients with:
- Booking appointments
- Finding doctors and services
- General health information
- Hospital hours and contact information
- Emergency guidance (always direct to 911 for emergencies)

Be concise, friendly, and professional. Always remind users that for medical emergencies, they should call 911.`;

      const completion = await groq.chat.completions.create({
        messages: [
          {
            role: "system",
            content: systemPrompt,
          },
          {
            role: "user",
            content: message,
          },
        ],
        model: "llama-3.1-8b-instant",
        temperature: 0.7,
        max_tokens: 200,
        top_p: 0.9,
      });

      let aiResponse = completion.choices[0]?.message?.content?.trim() || 'I apologize, but I could not process your request. Please try again.';
      
      // Fallback if response is too short or empty
      if (!aiResponse || aiResponse.length < 10) {
        aiResponse = 'I can help you with booking appointments, finding doctors, and general health information. How can I assist you today?';
      }

      return NextResponse.json({ response: aiResponse });
    } catch (groqError: any) {
      console.error('Groq API error:', groqError);
      
      // Fallback to rule-based responses on API error
      const responses: Record<string, string> = {
        'book appointment': 'To book an appointment, please visit our appointments page or call us at (416) 123-4567.',
        'find doctor': 'You can find our doctors by visiting the family practice page or contacting our office.',
        'symptoms': 'If you are experiencing symptoms, please book an appointment with one of our doctors. For emergencies, call 911.',
        'pharmacy': 'Our pharmacy hours are Monday-Friday 8AM-8PM, Saturday-Sunday 9AM-5PM.',
        'emergency': 'For life-threatening emergencies, please call 911 immediately.',
        'covid': 'For COVID-19 information and guidelines, please visit the Public Health Agency of Canada website.',
      };

      let response = 'I can help you with booking appointments, finding doctors, and general health information. How can I assist you today?';
      
      const lowerMessage = message.toLowerCase();
      for (const [key, value] of Object.entries(responses)) {
        if (lowerMessage.includes(key)) {
          response = value;
          break;
        }
      }

      return NextResponse.json({ response });
    }
  } catch (error) {
    console.error('AI Chat error:', error);
    return NextResponse.json(
      { error: 'Internal server error' },
      { status: 500 }
    );
  }
}


