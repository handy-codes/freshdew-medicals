# WordPress Deployment Setup Guide

## 🎯 Permanent Solution: Use SFTP (Recommended)

SFTP is more reliable, secure, and less likely to be blocked by Hostinger than FTP/FTPS.

## 📋 Step-by-Step SFTP Setup

### 1. Generate SSH Key Pair

On your local machine, run:

```bash
ssh-keygen -t rsa -b 4096 -C "github-actions-deploy"
```

- When prompted, save it as `~/.ssh/hostinger_deploy` (or any name you prefer)
- **Do NOT set a passphrase** (press Enter twice)
- This creates two files:
  - `hostinger_deploy` (private key) - **KEEP SECRET**
  - `hostinger_deploy.pub` (public key) - add to Hostinger

### 2. Add Public Key to Hostinger

1. Log in to Hostinger hPanel
2. Go to **Advanced → SSH Access**
3. Click **Add SSH Key**
4. Copy the contents of `hostinger_deploy.pub`:
   ```bash
   cat ~/.ssh/hostinger_deploy.pub
   ```
5. Paste it into Hostinger and save

### 3. Test SSH Connection

```bash
ssh -i ~/.ssh/hostinger_deploy your-username@your-server-ip
```

If successful, you'll see a shell prompt. Type `exit` to disconnect.

### 4. Add GitHub Secrets

Go to your GitHub repository:
1. **Settings → Secrets and variables → Actions**
2. Click **New repository secret**
3. Add these secrets:

| Secret Name | Value | Example |
|------------|-------|---------|
| `HOSTINGER_SSH_PRIVATE_KEY` | Contents of private key file | `-----BEGIN RSA PRIVATE KEY-----...` |
| `HOSTINGER_SSH_HOST` | Your FTP server address | `ftp.yourdomain.com` or IP |
| `HOSTINGER_SSH_USER` | Your FTP username | `u123456789` |
| `HOSTINGER_SSH_PORT` | SSH port (usually 22) | `22` |

**To get private key content:**
```bash
cat ~/.ssh/hostinger_deploy
```
Copy the entire output including `-----BEGIN RSA PRIVATE KEY-----` and `-----END RSA PRIVATE KEY-----`

### 5. Keep Existing FTP Secrets (Fallback)

Keep these secrets as backup:
- `HOSTINGER_FTP_SERVER`
- `HOSTINGER_FTP_USERNAME`
- `HOSTINGER_FTP_PASSWORD`

The workflow will try SFTP first, then fall back to FTP if SFTP fails.

## 🔧 Alternative: Fix FTP Issues

If you prefer to stick with FTP:

### 1. Verify FTP Credentials

1. Log in to Hostinger hPanel
2. Go to **Files → FTP Accounts**
3. Verify:
   - FTP is enabled
   - Server address format (e.g., `ftp.yourdomain.com`)
   - Username and password are correct

### 2. Test FTP Connection Locally

Use FileZilla:
1. Download: https://filezilla-project.org/
2. Connect with your FTP credentials
3. Note the exact path shown (e.g., `/public_html/` or `/home/u123456789/public_html/`)
4. Update `server-dir` in workflow if needed

### 3. Contact Hostinger Support

Ask them to:
- Whitelist GitHub Actions IP ranges
- Verify FTP server address format
- Check firewall settings
- Enable SFTP access (recommended)

## 🚀 How It Works

The improved workflow:

1. **Tests FTP connection** first to detect protocol (FTP/FTPS)
2. **Tries SFTP first** (if SSH keys are configured)
3. **Falls back to FTP/FTPS** if SFTP is not available
4. **Tries multiple paths** automatically
5. **Provides clear error messages** with troubleshooting steps

## ✅ Verification

After deployment, check:

1. Log in to WordPress Admin
2. Go to **Appearance → Themes**
3. Verify "FreshDew Medical Clinic" theme is present
4. Go to **Plugins → Installed Plugins**
5. Verify all plugins are present

## 🆘 Troubleshooting

### SFTP Connection Fails

- Verify SSH key is added to Hostinger
- Check SSH port (usually 22, but may be different)
- Ensure private key format is correct (includes BEGIN/END lines)
- Test SSH connection manually first

### FTP Connection Fails

- Verify credentials in GitHub Secrets
- Test with FileZilla locally
- Check Hostinger firewall settings
- Try different server address formats:
  - `ftp.yourdomain.com`
  - `ftp.yourdomain.com:21`
  - Server IP address

### Both SFTP and FTP Fail

- Contact Hostinger support
- Ask about IP restrictions
- Request SFTP access
- Verify account permissions

## 📝 Notes

- SFTP is more reliable than FTP
- SFTP uses port 22 (SSH)
- FTP uses port 21
- FTPS uses port 990
- GitHub Actions IPs change frequently, so SFTP is recommended

