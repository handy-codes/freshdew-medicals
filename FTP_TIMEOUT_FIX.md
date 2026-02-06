# FTP Timeout Error - Fix Applied

## Error
```
Error: Timeout (control socket)
```

## Fixes Applied

### 1. Changed Protocol to FTPS
- **Changed from:** `protocol: ftp`
- **Changed to:** `protocol: ftps`
- **Why:** FTPS (FTP over SSL) is more secure and often required by modern hosting providers like Hostinger

### 2. Increased Timeout
- **Changed from:** `timeout-minutes: 10`
- **Changed to:** `timeout-minutes: 15`
- **Why:** Gives more time for connection establishment

### 3. Increased Timeout
- **Changed from:** `timeout-minutes: 10`
- **Changed to:** `timeout-minutes: 15`
- **Why:** Gives more time for connection establishment and file transfers

---

## If FTPS Still Doesn't Work

### Option 1: Try Plain FTP Again
If Hostinger doesn't support FTPS, change back to:
```yaml
protocol: ftp
```

### Option 2: Verify FTP Credentials

1. **Check GitHub Secrets:**
   - Go to: Repository → Settings → Secrets and variables → Actions
   - Verify these secrets:
     - `HOSTINGER_FTP_SERVER` (should be like `ftp.yourdomain.com` or IP)
     - `HOSTINGER_FTP_USERNAME`
     - `HOSTINGER_FTP_PASSWORD`

2. **Get Fresh Credentials from Hostinger:**
   - Log in to Hostinger hPanel
   - Go to **Files → FTP Accounts**
   - Create new FTP account or reset password
   - Note the exact server address

### Option 3: Test FTP Connection Locally

**Using FileZilla:**
1. Download FileZilla: https://filezilla-project.org/
2. Connect with your FTP credentials
3. If it works in FileZilla → Credentials are correct
4. If it doesn't work → Check with Hostinger support

**FileZilla Settings:**
- Host: Your FTP server (from Hostinger)
- Username: Your FTP username
- Password: Your FTP password
- Port: 21 (for FTP) or 990 (for FTPS)
- Protocol: FTP - File Transfer Protocol (or FTP over explicit TLS/SSL for FTPS)

### Option 4: Check Server Address Format

The server address might need a specific format. Try:

**In GitHub Secret `HOSTINGER_FTP_SERVER`:**
- `ftp.yourdomain.com` (if using domain)
- `your-ip-address` (if using IP)
- `ftp.yourdomain.com:21` (with port for FTP)
- `ftp.yourdomain.com:990` (with port for FTPS)

### Option 5: Contact Hostinger Support

If nothing works, contact Hostinger support with:
- **Issue:** "FTP connection timeout from GitHub Actions"
- **What you need:**
  - Verify FTP is enabled on your account
  - Confirm FTP server address
  - Check if IP restrictions are blocking GitHub Actions IPs
  - Enable SFTP if available (requires SSH access)

---

## Manual Deployment (Temporary Solution)

If automated deployment continues to fail, deploy manually:

### Via FileZilla:
1. Connect to Hostinger FTP
2. Upload `wordpress-theme/freshdew-medical/` to `/public_html/wp-content/themes/`
3. Upload `wordpress-plugins/*/` to `/public_html/wp-content/plugins/`

### Via Hostinger File Manager:
1. Log in to hPanel
2. Go to **Files → File Manager**
3. Navigate to `/wp-content/themes/`
4. Upload theme files via web interface

---

## Next Steps

1. **Commit and push the fix:**
   ```bash
   git add .github/workflows/deploy-wordpress.yml
   git commit -m "Fix FTP timeout - use FTPS with passive mode"
   git push origin main
   ```

2. **Watch GitHub Actions:**
   - Should now connect using FTPS
   - Check logs for more details (verbose logging enabled)

3. **If still timing out:**
   - Test FTP in FileZilla first (most important!)
   - Update GitHub Secrets with correct values
   - Try switching back to plain FTP
   - Contact Hostinger support

---

## Common Hostinger FTP Issues

1. **FTP not enabled:** Some plans require enabling FTP in hPanel
2. **Wrong port:** Hostinger might use port 21 (FTP) or 990 (FTPS)
3. **IP restrictions:** FTP might be restricted to certain IPs
4. **Passive mode required:** Some servers require passive FTP mode (now enabled)
5. **FTPS required:** Some plans only support FTPS, not plain FTP

---

## Updated Workflow Settings

✅ **Protocol:** FTPS (FTP over SSL)  
✅ **Timeout:** 15 minutes  
✅ **Passive Mode:** Enabled  
✅ **Verbose Logging:** Enabled  

This should resolve the timeout issue. If it still fails, the verbose logs will provide more details about what's going wrong.

