# GitHub Automated Deployment Setup
## Deploy WordPress to Hostinger Automatically

This guide explains how to set up automated deployment from GitHub to Hostinger, so WordPress automatically picks up code changes when you push to GitHub.

---

## 🎯 How It Works

1. **Push code to GitHub** → Triggers GitHub Actions workflow
2. **GitHub Actions** → Automatically deploys to Hostinger via FTP/SFTP
3. **WordPress** → Automatically uses the updated files
4. **No manual upload needed!** ✅

---

## 📋 Prerequisites

- GitHub repository set up
- Hostinger FTP/SFTP credentials
- GitHub Actions enabled (free for public repos, included in GitHub plans)

---

## 🚀 Setup Instructions

### Step 1: Get Hostinger FTP/SFTP Credentials

1. **Log in to Hostinger hPanel**
2. **Go to Files → FTP Accounts**
3. **Create or use existing FTP account:**
   - Note down:
     - FTP Server/Host
     - FTP Username
     - FTP Password
     - Port (usually 21 for FTP, 22 for SFTP)

**OR use SFTP (more secure):**
- Go to **Files → File Manager**
- Check SSH/SFTP access (may need to enable in hosting plan)
- Get SSH credentials if available

### Step 2: Add GitHub Secrets

1. **Go to your GitHub repository**
2. **Click Settings → Secrets and variables → Actions**
3. **Click "New repository secret"**
4. **Add these secrets:**

#### For FTP Deployment:
```
HOSTINGER_FTP_SERVER = your-ftp-server.hostinger.com
HOSTINGER_FTP_USERNAME = your-ftp-username
HOSTINGER_FTP_PASSWORD = your-ftp-password
```

#### For SFTP Deployment (Recommended):
```
HOSTINGER_SSH_HOST = your-server.hostinger.com
HOSTINGER_SSH_USER = your-ssh-username
HOSTINGER_SSH_PRIVATE_KEY = your-ssh-private-key
HOSTINGER_SSH_PORT = 22 (optional, defaults to 22)
```

**To get SSH private key:**
- Generate SSH key pair on your local machine:
  ```bash
  ssh-keygen -t rsa -b 4096 -C "github-deploy"
  ```
- Add public key to Hostinger (if SSH access is enabled)
- Copy private key content to GitHub secret

### Step 3: Choose Deployment Method

We've created two workflow files:

#### Option A: FTP Deployment (Easier)
- File: `.github/workflows/deploy-wordpress.yml`
- Uses FTP (less secure but easier to set up)
- Works if Hostinger FTP is enabled

#### Option B: SFTP Deployment (More Secure)
- File: `.github/workflows/deploy-wordpress-sftp.yml`
- Uses SFTP/SSH (more secure)
- Requires SSH access on Hostinger

**To use one:**
1. Keep the one you want active
2. Delete or disable the other (rename to `.yml.disabled`)

### Step 4: Push to GitHub

1. **Commit the workflow file:**
   ```bash
   git add .github/workflows/deploy-wordpress.yml
   git commit -m "Add automated deployment workflow"
   git push origin main
   ```

2. **Watch the deployment:**
   - Go to GitHub → Actions tab
   - You'll see the workflow running
   - Green checkmark = success! ✅

### Step 5: Verify Deployment

1. **Check WordPress site:**
   - Visit your website
   - Changes should be live immediately

2. **Check file timestamps:**
   - Via FTP/File Manager
   - Files should have recent timestamps

---

## 🔄 How It Works Going Forward

### Automatic Deployment

**Every time you push to `main` or `master` branch:**
1. GitHub Actions automatically triggers
2. Only WordPress files are deployed (theme & plugins)
3. WordPress automatically uses the new files
4. No manual steps needed!

**What gets deployed:**
- ✅ `wordpress-theme/freshdew-medical/` → `/wp-content/themes/`
- ✅ `wordpress-plugins/*/` → `/wp-content/plugins/`

**What doesn't get deployed:**
- ❌ Next.js files (not needed for WordPress)
- ❌ Node modules
- ❌ Git files
- ❌ Documentation files

### Manual Deployment

You can also trigger deployment manually:
1. Go to GitHub → Actions
2. Select "Deploy WordPress to Hostinger"
3. Click "Run workflow"
4. Select branch and click "Run workflow"

---

## 🔧 Configuration Options

### Deploy Only on Specific Paths

The workflow is configured to deploy only when WordPress files change:
```yaml
paths:
  - 'wordpress-theme/**'
  - 'wordpress-plugins/**'
```

This means:
- ✅ Pushing WordPress changes → Auto-deploys
- ❌ Pushing Next.js changes → Doesn't deploy (saves time)

### Deploy from Different Branches

Edit `.github/workflows/deploy-wordpress.yml`:
```yaml
on:
  push:
    branches:
      - main
      - develop  # Add more branches
```

### Deploy to Staging First

Create a separate workflow for staging:
- Deploy `develop` branch → Staging server
- Deploy `main` branch → Production server

---

## 🛠️ Troubleshooting

### Issue: Workflow fails with "Connection refused"

**Solution:**
- Check FTP/SFTP credentials
- Verify Hostinger FTP is enabled
- Check firewall settings
- Try SFTP instead of FTP

### Issue: Files not updating

**Solution:**
- Check file permissions (should be 755 for folders, 644 for files)
- Verify deployment path is correct
- Check WordPress cache (clear if needed)

### Issue: "Permission denied"

**Solution:**
- Check SSH key permissions
- Verify SSH user has write access
- Check Hostinger file permissions

### Issue: Deployment too slow

**Solution:**
- Use SFTP instead of FTP (faster)
- Exclude unnecessary files in workflow
- Use Hostinger's Git integration if available

---

## 🔐 Security Best Practices

1. **Use SFTP instead of FTP** (more secure)
2. **Never commit secrets** to repository
3. **Use GitHub Secrets** for all credentials
4. **Rotate credentials** regularly
5. **Limit SSH key access** to deployment only

---

## 📊 Monitoring Deployments

### View Deployment History

1. Go to GitHub → Actions
2. See all deployment runs
3. Click on any run to see logs
4. Green = success, Red = failed

### Get Notifications

Configure GitHub notifications:
1. Go to repository Settings → Notifications
2. Enable email notifications for workflow runs
3. Get notified on success/failure

---

## 🎯 Alternative: Hostinger Git Integration

Some Hostinger plans support Git integration:

1. **Check if available:**
   - Log in to hPanel
   - Look for "Git" or "Version Control" option

2. **If available:**
   - Connect GitHub repository
   - Set up auto-deploy
   - Even easier than GitHub Actions!

**Note:** This feature may not be available on all Hostinger plans.

---

## ✅ Checklist

- [ ] Hostinger FTP/SFTP credentials obtained
- [ ] GitHub Secrets configured
- [ ] Workflow file committed to repository
- [ ] First deployment successful
- [ ] Verified files are updating on server
- [ ] Tested automatic deployment on push

---

## 🚀 Next Steps

1. **Set up the workflow** (follow steps above)
2. **Test deployment** (push a small change)
3. **Monitor first few deployments**
4. **Enjoy automatic deployments!** 🎉

---

## 📚 Additional Resources

- [GitHub Actions Documentation](https://docs.github.com/en/actions)
- [FTP Deploy Action](https://github.com/SamKirkland/FTP-Deploy-Action)
- [Hostinger FTP Guide](https://www.hostinger.com/tutorials/how-to-use-ftp)

---

**Now you can push code to GitHub and WordPress will automatically update!** 🎉

