# WordPress Deployment Guide to Hostinger
## FreshDew Medical Clinic

This guide provides step-by-step instructions for deploying the WordPress theme and plugins to Hostinger hosting.

---

## 📋 Pre-Deployment Checklist

- [ ] Hostinger hosting account is active
- [ ] Domain is pointing to Hostinger DNS
- [ ] WordPress is installed on Hostinger (via hPanel or manually)
- [ ] Database credentials are available
- [ ] SSL certificate is configured

**For Automated Deployment:**
- [ ] GitHub repository set up
- [ ] GitHub Actions enabled
- [ ] FTP/SFTP credentials added to GitHub Secrets

**For Manual Deployment:**
- [ ] FTP/SFTP credentials are available
- [ ] FTP client installed (FileZilla, WinSCP, etc.)

---

## 🚀 Deployment Steps

### Deployment Method Options

Choose one of the following methods:

#### **Option 1: Automated GitHub Deployment (Recommended)** ⭐

**Best for:** Continuous deployment, automatic updates, team collaboration

1. **Set up GitHub Actions** (see `GITHUB_DEPLOYMENT_SETUP.md` for detailed instructions)
2. **Push code to GitHub** → Automatically deploys to Hostinger
3. **WordPress automatically uses updated files**

**Benefits:**
- ✅ Automatic deployment on every push
- ✅ No manual file uploads
- ✅ Version control
- ✅ Easy rollback
- ✅ Team collaboration

**Quick Setup:**
1. Add GitHub Secrets (FTP/SFTP credentials)
2. Push code to GitHub
3. Done! Future pushes auto-deploy

**See `GITHUB_DEPLOYMENT_SETUP.md` for complete setup guide.**

---

#### **Option 2: Manual FTP/SFTP Upload** (Traditional Method)

### Step 1: Prepare Files for Upload

1. **Theme Files**: Located in `wordpress-theme/freshdew-medical/`
2. **Plugin Files**: Located in `wordpress-plugins/`
   - `hospital-core-system/`
   - `appointment-management/`
   - `emr-integration-juno/`

### Step 2: Upload Theme

1. **Via FTP/SFTP:**
   - Connect to your Hostinger server using FTP client (FileZilla, WinSCP, etc.)
   - Navigate to `/public_html/wp-content/themes/`
   - Upload the entire `freshdew-medical` folder
   - Ensure file permissions are set correctly (folders: 755, files: 644)

2. **Via hPanel File Manager:**
   - Log in to Hostinger hPanel
   - Navigate to File Manager
   - Go to `public_html/wp-content/themes/`
   - Upload `freshdew-medical` folder (zip and extract, or upload folder directly)

### Step 3: Upload Plugins

1. **Via FTP/SFTP:**
   - Navigate to `/public_html/wp-content/plugins/`
   - Upload each plugin folder:
     - `hospital-core-system/`
     - `appointment-management/`
     - `emr-integration-juno/`

2. **Via hPanel File Manager:**
   - Navigate to `public_html/wp-content/plugins/`
   - Upload each plugin folder

### Step 4: Add Hero Image

1. Upload the fresh leaf image to:
   - `wp-content/themes/freshdew-medical/assets/images/fresh-leaf-hero.jpg`
   - Or upload via WordPress Media Library and update the theme files to reference it

### Step 5: Activate Theme and Plugins

1. **Log in to WordPress Admin:**
   - Navigate to `https://yourdomain.com/wp-admin`
   - Use your WordPress admin credentials

2. **Activate Theme:**
   - Go to `Appearance > Themes`
   - Find "FreshDew Medical Clinic" theme
   - Click "Activate"

3. **Activate Plugins:**
   - Go to `Plugins > Installed Plugins`
   - Activate each plugin:
     - Hospital Core System
     - Appointment Management System
     - EMR Integration - Juno (Pending Government Approval)

### Step 6: Configure WordPress Settings

1. **Permalinks:**
   - Go to `Settings > Permalinks`
   - Select "Post name" or "Custom Structure: /%postname%/"
   - Click "Save Changes"

2. **Site Settings:**
   - Go to `Settings > General`
   - Update Site Title: "FreshDew Medical Clinic"
   - Update Tagline if needed
   - Save changes

3. **Create Pages:**
   - Create a "Home" page and set it as the homepage
   - Create "About", "Contact", "Walk-in Clinic", "Family Practice", "Telehealth" pages
   - Assign appropriate page templates if available

### Step 7: Configure Plugins

1. **Hospital Core System:**
   - Go to `Hospital > Dashboard`
   - Review and configure settings
   - Create initial user roles if needed

2. **Appointment Management:**
   - Configure booking settings
   - Set up email notifications
   - Test appointment booking form

3. **EMR Integration (Juno):**
   - Go to `EMR Juno > Settings`
   - Note: Features are pending government approval
   - Configure API settings when approval is received

### Step 8: Set Up Navigation Menu

1. Go to `Appearance > Menus`
2. Create a new menu named "Primary Menu"
3. Add pages: Home, About, Walk-in Clinic, Family Practice, Telehealth, Contact
4. Assign to "Primary Menu" location
5. Save menu

### Step 9: Configure Contact Information

The contact information is already configured in the theme's `functions.php` file:
- Address: 135 Cannifton Road, Unit 2 & 3, Belleville, Ontario, K8N 4V4
- Phone: (613) 288-0183
- Fax: (613) 288-0321
- Email: info@freshdewmedicalclinic.com
- Website: www.freshdewmedicalclinic.com

If you need to update it, edit `wp-content/themes/freshdew-medical/functions.php` and modify the `freshdew_get_contact_info()` function.

### Step 10: Test the Site

1. **Frontend Testing:**
   - Visit the homepage
   - Check all pages load correctly
   - Test navigation menu
   - Verify contact information is correct
   - Test map component
   - Check responsive design on mobile

2. **Functionality Testing:**
   - Test appointment booking form
   - Verify user registration/login
   - Check dashboard access for different user roles
   - Test contact form submission

3. **Performance Testing:**
   - Check page load times
   - Verify images are optimized
   - Test caching (if enabled)

---

## 🔧 Post-Deployment Configuration

### 1. Install Recommended Plugins

Install these plugins via WordPress admin:

- **Security**: Wordfence Security or Sucuri Security
- **Backup**: UpdraftPlus or BackupBuddy
- **Performance**: WP Super Cache or W3 Total Cache
- **Forms**: Contact Form 7 (for contact form)
- **SEO**: Yoast SEO or Rank Math

### 2. Configure Security

1. **WordPress Security:**
   - Change default admin username
   - Use strong passwords
   - Enable two-factor authentication
   - Limit login attempts

2. **File Permissions:**
   - wp-config.php: 400 or 440
   - wp-content: 755
   - wp-content/themes: 755
   - wp-content/plugins: 755

3. **SSL Certificate:**
   - Ensure SSL is active (https://)
   - Force HTTPS redirects

### 3. Set Up Backups

1. Configure automatic backups
2. Set backup schedule (daily recommended)
3. Store backups off-site (cloud storage)

### 4. Performance Optimization

1. **Caching:**
   - Enable WordPress caching plugin
   - Configure browser caching
   - Enable GZIP compression

2. **Image Optimization:**
   - Compress images
   - Use appropriate image formats
   - Implement lazy loading

3. **Database Optimization:**
   - Clean up unused data
   - Optimize database tables
   - Remove unused plugins/themes

---

## 📝 Database Migration (If Applicable)

If you're migrating from the Next.js application:

1. **Export PostgreSQL Data:**
   - Export all tables from PostgreSQL database
   - Convert data format to MySQL-compatible

2. **Import to MySQL:**
   - Use phpMyAdmin or command line
   - Import data into WordPress custom tables
   - Verify data integrity

3. **User Migration:**
   - Migrate users from Clerk to WordPress
   - Assign appropriate user roles
   - Reset passwords (users will need to set new passwords)

---

## 🐛 Troubleshooting

### Issue: Theme not appearing
- **Solution**: Check file permissions and ensure all files uploaded correctly

### Issue: Plugins not activating
- **Solution**: Check PHP version (requires 8.0+), check error logs

### Issue: Contact form not working
- **Solution**: Install Contact Form 7 plugin or configure SMTP settings

### Issue: Map not displaying
- **Solution**: Check internet connection, verify OpenStreetMap embed URL

### Issue: Images not loading
- **Solution**: Check file paths, verify image files exist, check permissions

---

## 📞 Support

For issues or questions:
- Check WordPress error logs
- Review plugin documentation
- Contact Hostinger support for hosting issues

---

## ✅ Post-Deployment Checklist

- [ ] Theme is active and displaying correctly
- [ ] All plugins are activated
- [ ] Navigation menu is configured
- [ ] Contact information is correct
- [ ] Map is displaying correctly
- [ ] Contact form is working
- [ ] Appointment booking is functional
- [ ] User roles are configured
- [ ] Security plugins are installed
- [ ] Backups are configured
- [ ] SSL certificate is active
- [ ] Site is accessible via domain
- [ ] Mobile responsive design is working
- [ ] Performance is optimized

---

## 🎯 Next Steps

1. **Content Creation:**
   - Add content to pages
   - Upload doctor profiles
   - Add service descriptions

2. **EMR Integration:**
   - Wait for government approval
   - Configure API credentials when available
   - Test integration features

3. **Ongoing Maintenance:**
   - Regular WordPress updates
   - Plugin updates
   - Security monitoring
   - Performance monitoring

---

**Last Updated**: [Current Date]  
**Version**: 1.0.0

