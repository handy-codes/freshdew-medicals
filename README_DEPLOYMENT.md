# Deployment Overview

This project supports **automated deployment from GitHub to Hostinger** using GitHub Actions.

## 🚀 Quick Start

### Automated Deployment (Recommended)

1. **Set up GitHub Secrets:**
   - Go to GitHub → Settings → Secrets → Actions
   - Add your Hostinger FTP/SFTP credentials

2. **Push to GitHub:**
   ```bash
   git push origin main
   ```

3. **Automatic Deployment:**
   - GitHub Actions automatically deploys to Hostinger
   - WordPress automatically uses the updated files
   - No manual steps needed! ✅

**See `GITHUB_DEPLOYMENT_SETUP.md` for detailed setup instructions.**

---

### Manual Deployment

If you prefer manual deployment:

1. **Upload files via FTP/SFTP:**
   - Theme: `wordpress-theme/freshdew-medical/` → `/wp-content/themes/`
   - Plugins: `wordpress-plugins/*/` → `/wp-content/plugins/`

2. **Activate in WordPress Admin:**
   - Activate theme
   - Activate plugins

**See `DEPLOYMENT_GUIDE.md` for complete manual deployment instructions.**

---

## 📁 What Gets Deployed

**Automatically deployed:**
- ✅ WordPress theme (`wordpress-theme/freshdew-medical/`)
- ✅ WordPress plugins (`wordpress-plugins/*/`)

**Not deployed:**
- ❌ Next.js application files (not needed for WordPress)
- ❌ Node modules
- ❌ Development files

---

## 🔄 Workflow

### Automated Deployment Flow

```
Developer → Push to GitHub → GitHub Actions → Deploy to Hostinger → WordPress Updates
```

### Manual Deployment Flow

```
Developer → Upload Files → Activate in WordPress → WordPress Updates
```

---

## 📚 Documentation

- **`GITHUB_DEPLOYMENT_SETUP.md`** - Automated deployment setup guide
- **`DEPLOYMENT_GUIDE.md`** - Complete deployment instructions
- **`QUICK_START.md`** - Quick reference guide

---

## ✅ Benefits of Automated Deployment

- 🚀 **Faster**: No manual file uploads
- 🔄 **Automatic**: Deploys on every push
- 📝 **Version Control**: Track all changes
- 🔙 **Easy Rollback**: Revert to previous versions
- 👥 **Team Collaboration**: Multiple developers can deploy
- 🛡️ **Safer**: Automated testing before deployment

---

**Recommended: Use automated deployment for the best experience!** ⭐

