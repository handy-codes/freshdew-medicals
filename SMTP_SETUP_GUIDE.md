# SMTP Email Configuration Guide

## ✅ SMTP Configuration Added

I've added SMTP configuration directly to your WordPress theme. This ensures appointment booking emails are sent from an authenticated SMTP server, significantly reducing spam filtering.

---

## 🚀 How to Configure

### Step 1: Access Settings

1. **Log in to WordPress Admin:**
   - Go to: `https://freshdewmedicalclinic.com/wp-admin`

2. **Navigate to Settings:**
   - Click **Settings** → **FreshDew AI** (in the left sidebar)
   - Or go directly to: `Settings → FreshDew AI`

3. **Click the "Email SMTP Settings" tab**

### Step 2: Configure SMTP

#### For Gmail (Recommended for Testing):

1. **Enable SMTP:** Check the "Enable SMTP" checkbox

2. **SMTP Host:** `smtp.gmail.com`

3. **SMTP Port:** `587`

4. **Encryption:** Select `TLS (Recommended)`

5. **SMTP Username:** `princeowo73@gmail.com` (your Gmail address)

6. **SMTP Password:** 
   - **Important:** You need a Gmail App Password (not your regular password)
   - See instructions below to get an App Password

7. **From Email:** `princeowo73@gmail.com`

8. **From Name:** `FreshDew Medical Clinic`

9. **Click "Save Changes"**

---

## 📧 Getting Gmail App Password

Since you're using Gmail, you need to create an App Password:

1. **Go to Google Account:**
   - Visit: https://myaccount.google.com/

2. **Enable 2-Step Verification** (if not already enabled):
   - Go to Security → 2-Step Verification
   - Follow the setup process

3. **Create App Password:**
   - Go to: https://myaccount.google.com/apppasswords
   - Or: Security → App passwords
   - Select "Mail" and "Other (Custom name)"
   - Enter: "WordPress SMTP"
   - Click "Generate"
   - **Copy the 16-character password** (no spaces)

4. **Use this App Password in WordPress:**
   - Paste it in the "SMTP Password" field
   - Save settings

---

## 🔧 Other Email Providers

### Outlook/Hotmail:
- **SMTP Host:** `smtp-mail.outlook.com`
- **Port:** `587`
- **Encryption:** `TLS`
- **Username:** Your Outlook email
- **Password:** Your Outlook password

### Yahoo:
- **SMTP Host:** `smtp.mail.yahoo.com`
- **Port:** `587` or `465`
- **Encryption:** `TLS` or `SSL`
- **Username:** Your Yahoo email
- **Password:** Your Yahoo password (or App Password)

### Custom SMTP (Hostinger):
- **SMTP Host:** Check with Hostinger support
- **Port:** Usually `587` or `465`
- **Encryption:** `TLS` or `SSL`
- **Username:** Your email address
- **Password:** Your email password

---

## ✅ Testing

After configuring SMTP:

1. **Submit a test appointment:**
   - Go to `/appointments/book`
   - Fill out the form
   - Submit

2. **Check your email:**
   - Should arrive in inbox (not spam)
   - Sent from authenticated SMTP server
   - Better deliverability

---

## 🎯 Benefits

✅ **Better Deliverability:** Emails sent from authenticated SMTP server  
✅ **Less Spam:** Proper authentication reduces spam filtering  
✅ **Professional:** Emails appear more legitimate  
✅ **Reliable:** Consistent email delivery  

---

## 🔍 Troubleshooting

### Emails Still Going to Spam?

1. **Check SPF/DKIM records** (advanced - contact hosting support)
2. **Verify App Password** is correct (for Gmail)
3. **Test with different email provider** (Outlook, etc.)
4. **Check email headers** in received email

### Can't Connect to SMTP?

1. **Verify SMTP settings** are correct
2. **Check firewall** isn't blocking port 587/465
3. **Try different port** (587 vs 465)
4. **Try different encryption** (TLS vs SSL)

### Need Help?

- Check WordPress error logs
- Enable SMTP debugging (uncomment in code)
- Contact your email provider support

---

## 📝 Summary

✅ SMTP configuration added to theme  
✅ Admin settings page created  
✅ Easy configuration via WordPress admin  
✅ Works with Gmail, Outlook, and other providers  
✅ Better email deliverability  

**Next Step:** Go to WordPress Admin → Settings → FreshDew AI → Email SMTP Settings tab and configure!



