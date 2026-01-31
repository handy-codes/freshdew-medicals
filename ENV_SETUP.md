# Environment Variables Setup Guide

This document explains how to find and configure all the required environment variables for the HealthPlus Hospital application.

## Required Environment Variables

Create a `.env.local` file in the root of your project with the following variables:

```env
# Database (Use your Neon PostgreSQL connection string)
DATABASE_URL="postgresql://user:password@host:5432/database"

# Clerk Authentication
NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY=pk_test_...
CLERK_SECRET_KEY=sk_test_...
CLERK_WEBHOOK_SECRET=whsec_...

# AI Services (Required - for AI chat features)
# Get free API key from https://console.groq.com/keys
GROQ_API_KEY=gsk_...

# Node Environment
NODE_ENV=development
```

## Step-by-Step Instructions

### 1. Database (PostgreSQL)

**Option A: Using Docker (Recommended for Development)**
- The project includes a `docker-compose.yml` file
- Run: `docker-compose up -d`
- Use: `DATABASE_URL="postgresql://admin:secure_password_123@localhost:5432/hospital_db"`

**Option B: Local PostgreSQL**
- Install PostgreSQL on your machine
- Create a database: `CREATE DATABASE hospital_db;`
- Format: `DATABASE_URL="postgresql://username:password@localhost:5432/hospital_db"`

**Option C: Cloud Database (Production)**
- Use services like:
  - **Supabase**: https://supabase.com
    - Go to Project Settings → Database
    - Copy the connection string
  - **Neon**: https://neon.tech
    - Create a project
    - Copy the connection string from dashboard
  - **Railway**: https://railway.app
    - Create a PostgreSQL service
    - Copy the connection string from variables

### 2. Clerk Authentication

1. **Sign up/Login**: Go to https://clerk.com
2. **Create Application**:
   - Click "Create Application"
   - Choose a name (e.g., "HealthPlus Hospital")
   - Select authentication methods (Email, Google, etc.)
3. **Get API Keys**:
   - Go to **API Keys** in the dashboard
   - Copy `Publishable Key` → `NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY`
   - Copy `Secret Key` → `CLERK_SECRET_KEY`
4. **Set up Webhook** (for user sync):
   - Go to **Webhooks** in Clerk dashboard
   - Click "Add Endpoint"
   - URL: `https://your-domain.com/api/auth/webhook` (or use ngrok for local: `https://your-ngrok-url.ngrok.io/api/auth/webhook`)
   - Subscribe to events: `user.created`, `user.updated`, `user.deleted`
   - Copy the **Signing Secret** → `CLERK_WEBHOOK_SECRET`

**For Local Development with Webhooks:**
- Install ngrok: https://ngrok.com
- Run: `ngrok http 3000`
- Use the ngrok URL in Clerk webhook settings

### 3. Google Maps (No Longer Required)

**Note**: The application now uses OpenStreetMap (free, no API key needed) instead of Google Maps. You can skip this step.

### 4. Groq API Key (Required - for AI Chat with Llama)

1. **Sign up/Login**: Go to https://console.groq.com (Free account works)
2. **Get API Key**:
   - Go to https://console.groq.com/keys
   - Click "Create API Key"
   - Copy the key → `GROQ_API_KEY`

**Note**: Groq offers free access to Llama models with fast inference. The AI assistant uses `llama-3.1-8b-instant` model.

### 6. Node Environment

- For development: `NODE_ENV=development`
- For production: `NODE_ENV=production`

## Quick Setup Checklist

- [ ] Database URL configured (PostgreSQL)
- [ ] Clerk Publishable Key added
- [ ] Clerk Secret Key added
- [ ] Clerk Webhook Secret added (if using webhooks)
- [ ] Google Maps (not needed - using free OpenStreetMap)
- [ ] OpenAI API Key added (optional)
- [ ] Hugging Face API Key added (optional)
- [ ] NODE_ENV set to development

## Testing Your Configuration

1. **Database**:
   ```bash
   npm run prisma:generate
   npm run prisma:push
   ```

2. **Clerk**:
   - Try signing up at `/sign-up`
   - Check if user is created in database

3. **Map Component**:
   - Visit the home page
   - Check if OpenStreetMap loads (no API key needed)

4. **AI Chat**:
   - Click the AI chat button
   - Send a message
   - Check if response is received

## Security Best Practices

1. **Never commit `.env.local` to git**
   - It's already in `.gitignore`
   - Use `.env.example` for documentation

2. **Use different keys for development and production**
   - Development: Use test keys
   - Production: Use live keys with restrictions

3. **Rotate keys regularly**
   - Especially if exposed or compromised

4. **Use environment-specific values**
   - Development: Local database, test API keys
   - Production: Cloud database, production API keys

## Troubleshooting

### Database Connection Issues
- Check if PostgreSQL is running
- Verify connection string format
- Check firewall/network settings
- Ensure database exists

### Clerk Authentication Issues
- Verify API keys are correct
- Check if Clerk application is active
- Ensure webhook URL is accessible (use ngrok for local)

### AI Chat Not Working
- Verify HUGGINGFACE_API_KEY is set correctly
- Check if you have Hugging Face account (free tier works)
- Review API logs for errors
- Ensure network requests aren't blocked
- The app will fallback to rule-based responses if API fails

## Additional Resources

- **Clerk Documentation**: https://clerk.com/docs
- **Prisma Documentation**: https://www.prisma.io/docs
- **Groq API**: https://console.groq.com/docs
- **Llama Models**: https://groq.com/models

## Support

If you encounter issues:
1. Check the troubleshooting section above
2. Review error messages in console/logs
3. Verify all environment variables are set correctly
4. Ensure all services are properly configured

