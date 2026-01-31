# Quick Start Guide - WordPress Deployment

## 🚀 Fast Deployment Steps

### 1. Upload Files to Hostinger

**Theme:**
```
Upload: wordpress-theme/freshdew-medical/
To: /public_html/wp-content/themes/
```

**Plugins:**
```
Upload: wordpress-plugins/hospital-core-system/
Upload: wordpress-plugins/appointment-management/
Upload: wordpress-plugins/emr-integration-juno/
To: /public_html/wp-content/plugins/
```

### 2. Activate in WordPress Admin

1. Go to `Appearance > Themes` → Activate "FreshDew Medical Clinic"
2. Go to `Plugins > Installed Plugins` → Activate all three plugins

### 3. Add Hero Image

Upload the fresh leaf image to:
```
/wp-content/themes/freshdew-medical/assets/images/fresh-leaf-hero.jpg
```

### 4. Configure

- Set up navigation menu (`Appearance > Menus`)
- Create pages (Home, About, Contact, etc.)
- Configure permalinks (`Settings > Permalinks`)

### 5. Test

- Visit homepage
- Check contact page
- Test appointment booking
- Verify map displays

---

## ✅ Contact Information (Already Configured)

- **Address:** 135 Cannifton Road, Unit 2 & 3, Belleville, ON K8N 4V4
- **Phone:** (613) 288-0183
- **Fax:** (613) 288-0321
- **Email:** info@freshdewmedicalclinic.com
- **Website:** www.freshdewmedicalclinic.com

---

## ⚠️ EMR Integration Status

**Status:** PENDING GOVERNMENT APPROVAL

The EMR integration plugin is installed but disabled. When approval is received:
1. Go to `EMR Juno > Settings`
2. Check "Government Approval Received"
3. Enter API credentials
4. Save settings

---

## 📚 Full Documentation

- **Deployment Guide:** `DEPLOYMENT_GUIDE.md`
- **Implementation Summary:** `WORDPRESS_IMPLEMENTATION_SUMMARY.md`
- **Theme README:** `wordpress-theme/freshdew-medical/README.md`

---

**Ready to deploy!** 🎉

