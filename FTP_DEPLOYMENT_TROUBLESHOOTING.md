# 🔧 FTP Deployment Troubleshooting Guide

## ❌ Current Error

```
Error: Timeout (control socket)
Failed to connect, are you sure your server works via FTP or FTPS? 
Users sometimes get this error when the server only supports SFTP.
```

---

## 🔍 Possible Causes

### 1. **FTP Server Address Format**
The `HOSTINGER_FTP_SERVER` secret might be missing the port or have incorrect format.

**Correct formats:**
- `ftp.yourdomain.com` (uses default port 21)
- `ftp.yourdomain.com:21` (explicit port)
- `your-server-ip:21` (IP address with port)

**Check in Hostinger:**
- Go to **Hostinger hPanel** → **FTP Accounts**
- Look for the FTP host/server address
- It should look like: `ftp.yourdomain.com` or an IP address

---

### 2. **Hostinger Requires SFTP Instead of FTP**

Many modern hosting providers (including some Hostinger plans) **only support SFTP**, not FTP.

**SFTP uses SSH keys, not passwords:**
- Requires SSH access enabled in Hostinger
- Needs SSH private key (not FTP password)
- Uses port 22 (not port 21)

---

### 3. **FTP Credentials Are Incorrect**

Double-check your GitHub Secrets:
- `HOSTINGER_FTP_SERVER`
- `HOSTINGER_FTP_USERNAME`
- `HOSTINGER_FTP_PASSWORD`

---

## ✅ Solutions

### Solution 1: Verify FTP Settings in Hostinger

1. **Log in to Hostinger hPanel**
2. **Go to:** FTP Accounts (or File Manager)
3. **Check:**
   - FTP Host/Server address
   - FTP Username
   - FTP Password
   - Port number (usually 21 for FTP, 990 for FTPS)

4. **Update GitHub Secrets:**
   - Go to: **GitHub Repository** → **Settings** → **Secrets and variables** → **Actions**
   - Update `HOSTINGER_FTP_SERVER` with the exact server address
   - If port is not 21, include it: `ftp.yourdomain.com:21`
   - Verify username and password are correct

---

### Solution 2: Switch to SFTP (If FTP Doesn't Work)

If Hostinger only supports SFTP, you need to:

#### Step 1: Enable SSH Access in Hostinger

1. **Log in to Hostinger hPanel**
2. **Go to:** Advanced → SSH Access
3. **Enable SSH** (if not already enabled)
4. **Generate SSH Key Pair** or use existing one

#### Step 2: Get SSH Credentials

From Hostinger, you'll need:
- **SSH Host:** Usually `ssh.yourdomain.com` or an IP
- **SSH Username:** Your hosting username
- **SSH Port:** Usually `22`
- **SSH Private Key:** The private key file content

#### Step 3: Add GitHub Secrets for SFTP

Go to **GitHub Repository** → **Settings** → **Secrets and variables** → **Actions**

Add these secrets:
- `HOSTINGER_SSH_HOST` = Your SSH host (e.g., `ssh.yourdomain.com`)
- `HOSTINGER_SSH_USER` = Your SSH username
- `HOSTINGER_SSH_PORT` = `22` (or your custom port)
- `HOSTINGER_SSH_PRIVATE_KEY` = Your SSH private key (entire content, including `-----BEGIN OPENSSH PRIVATE KEY-----`)

#### Step 4: Enable SFTP Workflow

The SFTP workflow already exists at `.github/workflows/deploy-wordpress-sftp.yml`

To enable it:
1. Remove the comment that disables it
2. Change `workflow_dispatch` to include `push` triggers
3. Or manually trigger it from Actions tab

---

### Solution 3: Use Hostinger File Manager (Manual Upload)

If automated deployment continues to fail:

1. **Log in to Hostinger hPanel**
2. **Go to:** File Manager
3. **Navigate to:** `/public_html/wp-content/themes/`
4. **Upload:** Your theme files (zip or individual files)
5. **Navigate to:** `/public_html/wp-content/plugins/`
6. **Upload:** Your plugin files

**Note:** This is manual and won't auto-update from GitHub.

---

## 🧪 Test FTP Connection Locally

Before deploying via GitHub Actions, test your FTP connection:

### Using FileZilla (Free FTP Client)

1. **Download FileZilla:** https://filezilla-project.org/
2. **Open FileZilla**
3. **Enter:**
   - Host: Your FTP server (from Hostinger)
   - Username: Your FTP username
   - Password: Your FTP password
   - Port: 21 (or 990 for FTPS)
4. **Click:** "Quickconnect"
5. **If it connects:** Your FTP credentials are correct
6. **If it fails:** Check error message and verify credentials

---

## 📋 Quick Checklist

- [ ] Verified FTP server address in Hostinger hPanel
- [ ] Confirmed FTP username and password are correct
- [ ] Checked if Hostinger supports FTP or only SFTP
- [ ] Updated GitHub Secrets with correct values
- [ ] Tested FTP connection locally (FileZilla)
- [ ] If SFTP needed: Enabled SSH in Hostinger and added SSH secrets

---

## 🆘 Still Having Issues?

### Contact Hostinger Support

Ask them:
1. "Does my hosting plan support FTP or only SFTP?"
2. "What is my FTP server address and port?"
3. "Can you provide my FTP credentials?"
4. "How do I enable SSH/SFTP access?"

### Alternative: Use Hostinger's Git Integration

Some Hostinger plans support Git deployment:
1. Check if your plan has Git integration
2. Set up Git repository in Hostinger
3. Push directly to Hostinger's Git instead of using FTP

---

## 📝 Next Steps After Fixing

Once deployment works:

1. **Clear WordPress cache** (LiteSpeed Cache → Toolbox → Purge All)
2. **Clear browser cache** (F12 → Right-click refresh → Empty Cache and Hard Reload)
3. **Verify changes** on your live site

---

**Most likely issue:** Hostinger requires SFTP, not FTP. Check with Hostinger support or try enabling SSH access.







