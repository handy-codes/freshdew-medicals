# FTP Connection Timeout - Troubleshooting Guide

## Current Error

```
Error: Timeout (control socket)
Failed to connect, are you sure your server works via FTP or FTPS?
```

This means GitHub Actions cannot connect to your Hostinger FTP server.

---

## Step-by-Step Fix

### Step 1: Verify FTP Credentials in GitHub Secrets

1. **Go to GitHub:**
   - Repository → Settings → Secrets and variables → Actions

2. **Check these secrets exist:**
   - `HOSTINGER_FTP_SERVER`
   - `HOSTINGER_FTP_USERNAME`
   - `HOSTINGER_FTP_PASSWORD`

3. **Verify they're correct:**
   - Server should be like: `ftp.yourdomain.com` or IP address
   - Username should match your FTP account
   - Password should be current

### Step 2: Get Fresh FTP Credentials from Hostinger

1. **Log in to Hostinger hPanel:**
   - Go to: https://hpanel.hostinger.com

2. **Navigate to FTP:**
   - Click **Files** → **FTP Accounts**

3. **Create or View FTP Account:**
   - If you have one: Click "Manage" to see details
   - If not: Click "Create FTP Account"
   - **Note down:**
     - FTP Host/Server (e.g., `ftp.yourdomain.com` or IP)
     - FTP Username
     - FTP Password
     - Port (usually 21 for FTP)

4. **Update GitHub Secrets:**
   - Go to GitHub → Settings → Secrets
   - Update each secret with fresh values

### Step 3: Test FTP Connection Locally

**Using FileZilla (Recommended):**

1. **Download FileZilla:** https://filezilla-project.org/

2. **Connect:**
   - Host: Your FTP server (from Hostinger)
   - Username: Your FTP username
   - Password: Your FTP password
   - Port: 21 (or port from Hostinger)
   - Protocol: FTP - File Transfer Protocol

3. **Test Connection:**
   - Click "Quickconnect"
   - If it connects ✅ → Credentials are correct
   - If it fails ❌ → Check with Hostinger support

### Step 4: Check Hostinger FTP Settings

1. **In Hostinger hPanel:**
   - Go to **Files → FTP Accounts**
   - Check if FTP is enabled
   - Note the exact server address format

2. **Common Server Formats:**
   - `ftp.yourdomain.com`
   - `yourdomain.com`
   - IP address (e.g., `123.456.789.0`)
   - `ftp.hostinger.com` (shared hosting)

3. **Check Port:**
   - FTP: Port 21
   - FTPS: Port 990
   - SFTP: Port 22

### Step 5: Try Different Server Address Formats

If one format doesn't work, try these in GitHub Secrets:

**Option 1:** Domain format
```
HOSTINGER_FTP_SERVER = ftp.freshdewmedicalclinic.com
```

**Option 2:** Without ftp prefix
```
HOSTINGER_FTP_SERVER = freshdewmedicalclinic.com
```

**Option 3:** With port
```
HOSTINGER_FTP_SERVER = ftp.freshdewmedicalclinic.com:21
```

**Option 4:** IP address (if provided by Hostinger)
```
HOSTINGER_FTP_SERVER = 123.456.789.0
```

### Step 6: Check Firewall/Network Issues

1. **Hostinger might block GitHub Actions IPs:**
   - Contact Hostinger support
   - Ask if FTP access is restricted by IP
   - Request to whitelist GitHub Actions IPs

2. **GitHub Actions IP ranges:**
   - GitHub Actions uses dynamic IPs
   - You may need to disable IP restrictions in Hostinger

### Step 7: Alternative - Use SFTP Instead

If FTP doesn't work, try SFTP:

1. **Check if Hostinger supports SFTP:**
   - Log in to hPanel
   - Check if SSH/SFTP access is available
   - Some plans require enabling SSH access

2. **If SFTP is available:**
   - Generate SSH key pair
   - Add public key to Hostinger
   - Add private key to GitHub Secrets
   - Use SFTP workflow instead

---

## Quick Checklist

- [ ] GitHub Secrets are set correctly
- [ ] FTP credentials are fresh from Hostinger
- [ ] FTP connection works in FileZilla
- [ ] Server address format is correct
- [ ] Port is correct (usually 21)
- [ ] FTP is enabled in Hostinger
- [ ] No IP restrictions blocking GitHub Actions

---

## Common Issues & Solutions

### Issue 1: "Timeout (control socket)"

**Possible Causes:**
- Wrong server address
- FTP not enabled
- Firewall blocking
- Wrong port

**Solutions:**
- Verify server address in Hostinger
- Test in FileZilla first
- Contact Hostinger support

### Issue 2: "Authentication failed"

**Possible Causes:**
- Wrong username/password
- Password changed
- Account disabled

**Solutions:**
- Reset FTP password in Hostinger
- Update GitHub Secrets
- Create new FTP account

### Issue 3: "Connection refused"

**Possible Causes:**
- FTP service not running
- Wrong port
- Server address incorrect

**Solutions:**
- Verify FTP is enabled
- Check port number
- Try different server address format

---

## Manual Deployment (Temporary Solution)

If automated deployment continues to fail, deploy manually:

1. **Use FileZilla:**
   - Connect to Hostinger FTP
   - Upload `wordpress-theme/freshdew-medical/` to `/public_html/wp-content/themes/`
   - Upload `wordpress-plugins/*/` to `/public_html/wp-content/plugins/`

2. **Or use Hostinger File Manager:**
   - Log in to hPanel
   - Go to Files → File Manager
   - Upload files via web interface

---

## Contact Hostinger Support

If nothing works, contact Hostinger support with:

1. **Your issue:** "FTP connection timeout from GitHub Actions"
2. **What you need:**
   - Verify FTP is enabled
   - Confirm FTP server address
   - Check if IP restrictions are blocking
   - Enable SFTP if available

**Support Contact:**
- Live chat in hPanel
- Support ticket
- Email support

---

## Next Steps

1. **Test FTP in FileZilla first** (most important!)
2. **Update GitHub Secrets** with correct values
3. **Try the updated workflow** (now uses plain FTP with verbose logging)
4. **Check GitHub Actions logs** for more details
5. **Contact Hostinger** if still failing

The updated workflow now has:
- ✅ Verbose logging (more details in logs)
- ✅ 10-minute timeout (longer wait time)
- ✅ Plain FTP protocol (most compatible)

Try it and check the logs for more specific error messages!








