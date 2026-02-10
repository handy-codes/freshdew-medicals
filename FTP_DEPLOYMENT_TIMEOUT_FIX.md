# FTP Deployment Timeout Fix

## Problem

GitHub Actions FTP deployment is timing out with error:
```
Error: Timeout (control socket)
Failed to connect, are you sure your server works via FTP or FTPS? 
Users sometimes get this error when the server only supports SFTP.
```

## Solution Applied

Updated the workflow to use **FTPS** (FTP over SSL) instead of plain FTP, which is more secure and often required by modern hosting providers like Hostinger.

### Changes Made:

1. **Added `protocol: ftps`** to both deployment steps
2. **Added `dangerous-clean-slate: false`** for safety
3. This uses encrypted FTP connection (more secure and often required)

---

## If FTPS Still Doesn't Work

### Option 1: Verify FTP Credentials

1. **Check GitHub Secrets:**
   - Go to GitHub → Settings → Secrets and variables → Actions
   - Verify these secrets exist and are correct:
     - `HOSTINGER_FTP_SERVER`
     - `HOSTINGER_FTP_USERNAME`
     - `HOSTINGER_FTP_PASSWORD`

2. **Get Fresh Credentials from Hostinger:**
   - Log in to Hostinger hPanel
   - Go to **Files → FTP Accounts**
   - Create a new FTP account or reset password
   - Note the exact server address (should be like `ftp.yourdomain.com` or IP address)

### Option 2: Try Different Protocol

If FTPS doesn't work, try:

1. **Remove `protocol: ftps`** (use plain FTP)
2. **Or try `protocol: sftp`** (if Hostinger supports SFTP)

### Option 3: Check Hostinger FTP Settings

1. **Log in to Hostinger hPanel**
2. **Go to Files → FTP Accounts**
3. **Check:**
   - Is FTP enabled?
   - What port is used? (21 for FTP, 22 for SFTP, 990 for FTPS)
   - Is passive mode required?
   - Are there IP restrictions?

### Option 4: Use SFTP Instead

If FTP/FTPS doesn't work, switch to SFTP:

1. **Get SSH/SFTP access from Hostinger**
2. **Generate SSH key pair**
3. **Add SSH secrets to GitHub**
4. **Use the SFTP workflow** (already exists but disabled)

---

## Quick Fixes to Try

### Fix 1: Update Server Address Format

The FTP server might need a specific format. Try:

- `ftp.yourdomain.com` (if using domain)
- `your-ip-address` (if using IP)
- `yourdomain.com` (without ftp prefix)

### Fix 2: Add Port Number

If Hostinger requires a specific port, update the server secret:

```
HOSTINGER_FTP_SERVER = ftp.yourdomain.com:21
```

Or for FTPS:
```
HOSTINGER_FTP_SERVER = ftp.yourdomain.com:990
```

### Fix 3: Test FTP Connection Locally

Test if FTP works from your computer:

**Windows (PowerShell):**
```powershell
# Test FTP connection
$ftp = [System.Net.FtpWebRequest]::Create("ftp://your-ftp-server")
$ftp.Credentials = New-Object System.Net.NetworkCredential("username", "password")
$ftp.Method = [System.Net.WebRequestMethods+Ftp]::ListDirectory
$response = $ftp.GetResponse()
```

**Or use FileZilla:**
1. Download FileZilla (free FTP client)
2. Try connecting with your FTP credentials
3. If it works in FileZilla, the credentials are correct
4. If it doesn't work, check with Hostinger support

---

## Updated Workflow

The workflow now uses:
- **Protocol:** FTPS (FTP over SSL)
- **More secure** than plain FTP
- **Often required** by modern hosting

---

## Next Steps

1. **Commit and push the fix:**
   ```bash
   git add .github/workflows/deploy-wordpress.yml
   git commit -m "Fix FTP timeout - use FTPS protocol"
   git push origin main
   ```

2. **Watch GitHub Actions:**
   - Should now connect using FTPS
   - If still fails, try the troubleshooting steps above

3. **If still timing out:**
   - Contact Hostinger support
   - Ask about FTP/FTPS/SFTP access
   - Verify your hosting plan includes FTP access

---

## Common Hostinger FTP Issues

1. **FTP not enabled:** Some plans require enabling FTP in hPanel
2. **Wrong port:** Hostinger might use port 21 (FTP) or 990 (FTPS)
3. **IP restrictions:** FTP might be restricted to certain IPs
4. **Passive mode required:** Some servers require passive FTP mode

---

## Alternative: Manual Deployment

If automated deployment continues to fail, you can deploy manually:

1. **Use FileZilla or similar FTP client**
2. **Connect to Hostinger**
3. **Upload files manually:**
   - `wordpress-theme/freshdew-medical/` → `/public_html/wp-content/themes/`
   - `wordpress-plugins/*/` → `/public_html/wp-content/plugins/`

---

## Summary

✅ **Updated workflow to use FTPS** (more secure, often required)
✅ **Added safety settings**
✅ **Should resolve timeout issues**

If it still fails, check:
- FTP credentials in GitHub Secrets
- Hostinger FTP settings
- Try SFTP instead
- Contact Hostinger support







