# 🔐 Environment & API Keys Setup Guide

## Complete Configuration for FreshDew Medical Clinic

This guide explains how to set up all environment variables, API keys, and authentication for the project.

---

## 📋 Table of Contents

1. [Groq AI API Setup](#groq-ai-api-setup)
2. [WordPress Configuration](#wordpress-configuration)
3. [GitHub Secrets](#github-secrets)
4. [Hostinger FTP Setup](#hostinger-ftp-setup)
5. [Telehealth WebRTC Setup](#telehealth-webrtc-setup)
6. [Database Configuration](#database-configuration)

---

## 1. Groq AI API Setup

### Step 1: Get Groq API Key

1. **Go to Groq Console:** https://console.groq.com
2. **Sign up** or **Log in**
3. **Navigate to:** API Keys section
4. **Click:** "Create API Key"
5. **Copy** your API key (starts with `gsk_...`)

### Step 2: Add to WordPress

**Option A: Via WordPress Admin (Recommended)**

1. **Log in to WordPress Admin**
2. **Go to:** Settings → FreshDew AI
3. **Paste** your Groq API key
4. **Click:** "Save Changes"

**Option B: Via wp-config.php**

Add to `wp-config.php`:
```php
define('FRESHDEW_GROQ_API_KEY', 'gsk_your_api_key_here');
```

**Option C: Via WordPress Option (Database)**

Add via database or use this PHP code:
```php
update_option('freshdew_groq_api_key', 'gsk_your_api_key_here');
```

### Step 3: Verify

1. **Test the chatbot** on your website
2. **Ask a question** - should get AI response (not fallback)
3. **Check WordPress error logs** if not working

---

## 2. WordPress Configuration

### Required WordPress Settings

1. **Permalinks:**
   - Go to: Settings → Permalinks
   - Select: "Post name"
   - Save Changes

2. **Site URL:**
   - Go to: Settings → General
   - WordPress Address (URL): `https://freshdewmedicalclinic.com`
   - Site Address (URL): `https://freshdewmedicalclinic.com`

3. **Timezone:**
   - Go to: Settings → General
   - Timezone: Select your timezone (e.g., Toronto)

---

## 3. GitHub Secrets

### Required GitHub Secrets for Deployment

Go to: **GitHub Repository → Settings → Secrets and variables → Actions**

#### FTP Deployment Secrets:
```
HOSTINGER_FTP_SERVER = your-ftp-server.hostinger.com
HOSTINGER_FTP_USERNAME = your-ftp-username
HOSTINGER_FTP_PASSWORD = your-ftp-password
```

#### How to Get FTP Credentials:

1. **Log in to Hostinger hPanel**
2. **Go to:** Files → FTP Accounts
3. **Create or view** FTP account
4. **Copy:**
   - FTP Server/Host
   - FTP Username
   - FTP Password

---

## 4. Hostinger FTP Setup

### FTP Account Creation

1. **Log in to Hostinger hPanel**
2. **Navigate to:** Files → FTP Accounts
3. **Click:** "Create FTP Account"
4. **Fill in:**
   - Username: (choose a username)
   - Password: (generate strong password)
   - Directory: `/public_html` (or leave default)
5. **Click:** "Create"
6. **Copy credentials** to GitHub Secrets

### File Permissions

After deployment, verify file permissions:
- **Folders:** 755
- **Files:** 644

You can set via FTP client or Hostinger File Manager.

---

## 5. Telehealth WebRTC Setup

### Current Implementation

The Telehealth page includes:
- ✅ Video call interface (WebRTC ready)
- ✅ Voice call interface
- ✅ Mute/unmute controls
- ✅ Video on/off controls

### Production Setup (Optional)

For full WebRTC functionality, you can integrate:

**Option 1: Twilio Video**
- Sign up: https://www.twilio.com/try-twilio
- Get API credentials
- Add to WordPress options

**Option 2: Jitsi Meet**
- Self-hosted or use Jitsi Meet API
- Free and open-source
- Add configuration to theme

**Option 3: Zoom SDK**
- Sign up: https://zoom.us
- Get SDK credentials
- Integrate Zoom SDK

**Current Status:** The page has the UI ready. WebRTC connection logic can be added when you choose a provider.

---

## 6. Database Configuration

### WordPress Database

WordPress database is configured via `wp-config.php`:

```php
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_database_user');
define('DB_PASSWORD', 'your_database_password');
define('DB_HOST', 'localhost');
```

**Get from Hostinger:**
1. **Go to:** hPanel → Databases → MySQL Databases
2. **View** your database credentials
3. **Update** `wp-config.php` if needed

---

## 🔒 Security Best Practices

### 1. API Keys
- ✅ Never commit API keys to GitHub
- ✅ Use WordPress options or environment variables
- ✅ Rotate keys regularly
- ✅ Use different keys for dev/production

### 2. FTP Credentials
- ✅ Store in GitHub Secrets only
- ✅ Use strong passwords
- ✅ Limit FTP access to necessary directories
- ✅ Consider SFTP if available

### 3. WordPress Security
- ✅ Keep WordPress updated
- ✅ Use strong admin passwords
- ✅ Enable two-factor authentication
- ✅ Install security plugin (Wordfence, etc.)

---

## 📝 Environment Variables Summary

### WordPress (wp-config.php)
```php
// Database
define('DB_NAME', 'database_name');
define('DB_USER', 'database_user');
define('DB_PASSWORD', 'database_password');
define('DB_HOST', 'localhost');

// Security Keys (auto-generated by WordPress)
define('AUTH_KEY', '...');
define('SECURE_AUTH_KEY', '...');
// ... etc

// Optional: Groq API Key
define('FRESHDEW_GROQ_API_KEY', 'gsk_...');
```

### GitHub Secrets
```
HOSTINGER_FTP_SERVER
HOSTINGER_FTP_USERNAME
HOSTINGER_FTP_PASSWORD
```

### WordPress Options (Database)
```
freshdew_groq_api_key = 'gsk_...'
```

---

## ✅ Setup Checklist

### Groq AI:
- [ ] Created Groq account
- [ ] Generated API key
- [ ] Added to WordPress (Settings → FreshDew AI)
- [ ] Tested chatbot

### GitHub:
- [ ] Added FTP server secret
- [ ] Added FTP username secret
- [ ] Added FTP password secret
- [ ] Tested deployment workflow

### Hostinger:
- [ ] Created FTP account
- [ ] Verified file permissions
- [ ] Tested FTP connection

### WordPress:
- [ ] Configured permalinks
- [ ] Set site URL
- [ ] Set timezone
- [ ] Activated theme
- [ ] Activated plugins

### Telehealth:
- [ ] Tested video call UI
- [ ] Tested voice call UI
- [ ] (Optional) Configured WebRTC provider

---

## 🐛 Troubleshooting

### Chatbot Not Working

**Issue:** Chatbot gives same response to all questions

**Solutions:**
1. **Check API key is set:**
   - Go to Settings → FreshDew AI
   - Verify API key is saved
   
2. **Check API key is valid:**
   - Test at https://console.groq.com
   - Regenerate if needed
   
3. **Check WordPress error logs:**
   - Look for Groq API errors
   - Check network tab in browser

4. **Verify REST API:**
   - Visit: `https://freshdewmedicalclinic.com/wp-json/freshdew/v1/ai-chat`
   - Should return endpoint info

### Deployment Not Working

**Issue:** GitHub Actions workflow fails

**Solutions:**
1. **Check GitHub Secrets:**
   - Verify all three FTP secrets are set
   - Check for typos
   
2. **Check FTP credentials:**
   - Test connection via FTP client
   - Verify server address is correct
   
3. **Check workflow logs:**
   - Go to Actions tab
   - View error messages

### Telehealth Not Working

**Issue:** Video/voice calls don't start

**Solutions:**
1. **Check browser permissions:**
   - Allow camera/microphone access
   - Check browser settings
   
2. **Check HTTPS:**
   - WebRTC requires HTTPS
   - Verify SSL certificate is active
   
3. **Check browser compatibility:**
   - Use modern browser (Chrome, Firefox, Safari, Edge)
   - Update browser if needed

---

## 📞 Support

### Groq API Support
- Documentation: https://console.groq.com/docs
- Support: support@groq.com

### Hostinger Support
- Support: https://www.hostinger.com/contact
- Live chat available in hPanel

### WordPress Support
- Documentation: https://wordpress.org/support
- Forums: https://wordpress.org/support/forums

---

## 🎯 Quick Reference

### Add Groq API Key:
```
WordPress Admin → Settings → FreshDew AI → Enter API Key → Save
```

### Test Chatbot:
```
Visit website → Click chat button → Ask question → Should get AI response
```

### Deploy Changes:
```
git push origin main → GitHub Actions runs automatically
```

### Check Deployment:
```
GitHub → Actions → View latest workflow run
```

---

**All environment variables and API keys are now documented!** 🔐









