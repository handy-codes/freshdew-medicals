# Appointment Booking Verification Guide

## Email Configuration

**Appointment booking notifications are sent to:**
- **Email:** `info@freshdewmedicalclinic.com`
- **Subject:** "New Appointment Request - [Patient Name]"

---

## How to Verify Appointment Bookings

### Method 1: Check Email Inbox

1. **Check the inbox for:** `info@freshdewmedicalclinic.com`
2. **Look for emails with subject:** "New Appointment Request - [Name]"
3. **Email contains:**
   - Patient's full name
   - Email address
   - Phone number
   - Preferred date and time
   - Appointment type (In-Person, Telehealth, Urgent Care)
   - Reason for visit
   - Symptoms (if provided)
   - Submission timestamp
   - IP address

### Method 2: Check Spam/Junk Folder

- Sometimes emails can end up in spam
- Check spam folder for `info@freshdewmedicalclinic.com`
- Mark as "Not Spam" if found

### Method 3: Check WordPress Error Logs

The system now logs appointment submissions. Check your WordPress error log:

**Location:** Usually in your hosting control panel or:
- `/wp-content/debug.log` (if WP_DEBUG_LOG is enabled)
- Hosting error logs (check cPanel/hPanel)

**Look for entries like:**
```
Appointment Booking: [Name] - [Date] [Time] - Email sent: Yes/No
```

### Method 4: Test the Form

1. **Fill out the booking form** at `/appointments/book`
2. **Submit it**
3. **Check email immediately** (should arrive within 1-2 minutes)
4. **Check browser console** (F12) for any JavaScript errors

---

## Troubleshooting: Email Not Received

### Issue 1: WordPress Email Not Configured

**Solution:** WordPress needs email configuration. Check:

1. **WordPress Admin → Settings → General**
   - Verify "Administration Email Address" is set
   - Should be: `info@freshdewmedicalclinic.com` or your admin email

2. **Hosting Email Settings:**
   - Some hosts require SMTP configuration
   - Check with Hostinger support if emails aren't sending

### Issue 2: Email Going to Spam

**Solution:**
- Check spam/junk folder
- Add `info@freshdewmedicalclinic.com` to contacts
- Configure SPF/DKIM records (ask hosting support)

### Issue 3: Email Function Not Working

**Solution:** Install an SMTP plugin:

1. **Install WP Mail SMTP Plugin:**
   - Go to WordPress Admin → Plugins → Add New
   - Search "WP Mail SMTP"
   - Install and activate

2. **Configure SMTP:**
   - Go to Settings → WP Mail SMTP
   - Set up with your email provider (Gmail, Outlook, etc.)
   - Or use Hostinger's SMTP settings

### Issue 4: Form Not Submitting

**Check:**
1. **Browser Console (F12):**
   - Look for JavaScript errors
   - Check Network tab for failed requests

2. **WordPress REST API:**
   - Test endpoint: `https://freshdewmedicalclinic.com/wp-json/freshdew/v1/book-appointment`
   - Should return available endpoints

---

## Alternative: Database Storage

If emails aren't reliable, we can add database storage. The appointments can be stored in WordPress database and viewed in admin panel.

**Would you like me to add:**
- Database storage for appointments?
- Admin panel to view appointments?
- Email + Database (both)?

---

## Current Email Setup

**Recipient:** `info@freshdewmedicalclinic.com`

**Email Content:**
```
New appointment request received:

Name: [Patient Name]
Email: [Patient Email]
Phone: [Patient Phone]
Date: [Preferred Date]
Time: [Preferred Time]
Type: [Appointment Type]
Reason: [Reason for Visit]
Symptoms: [Symptoms if provided]

---
Submitted: [Timestamp]
IP Address: [IP Address]
```

---

## Quick Verification Steps

1. ✅ **Check:** `info@freshdewmedicalclinic.com` inbox
2. ✅ **Check:** Spam/junk folder
3. ✅ **Test:** Submit a test appointment
4. ✅ **Check:** WordPress error logs
5. ✅ **Verify:** Email configuration in WordPress admin

---

## Need Help?

If emails still aren't working:
1. Contact Hostinger support about email/SMTP configuration
2. Install WP Mail SMTP plugin for better email delivery
3. Consider adding database storage as backup

---

## Next Steps

**To improve reliability, I can:**
1. Add database storage for appointments
2. Create admin panel to view all appointments
3. Add email confirmation to patient
4. Add appointment calendar integration

Let me know which features you'd like added!








