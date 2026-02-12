# How to Add Real Doctor Images to About Page

## Current Setup

The About page now has placeholder structure for doctor images. Currently, it shows initials (MC, SJ, JW, ER) as placeholders until you add real photos.

---

## Step-by-Step Guide

### Option 1: Upload via WordPress Media Library (Recommended)

1. **Prepare Your Images:**
   - Get professional headshots of your doctors
   - Recommended size: **400x400px** or larger (square format)
   - File format: JPG or PNG
   - File names:
     - `dr-michael-chen.jpg`
     - `dr-sarah-johnson.jpg`
     - `dr-james-wilson.jpg`
     - `dr-emily-rodriguez.jpg`

2. **Upload to WordPress:**
   - Log in to WordPress Admin
   - Go to **Media → Add New**
   - Upload all 4 doctor images
   - Note the file URLs or copy them

3. **Upload via FTP/File Manager:**
   - Log in to Hostinger hPanel
   - Go to **Files → File Manager**
   - Navigate to: `/public_html/wp-content/themes/freshdew-medical/assets/images/`
   - Create folder: `doctors` (if it doesn't exist)
   - Upload your images to: `/assets/images/doctors/`

4. **Verify File Paths:**
   - Images should be at:
     - `/wp-content/themes/freshdew-medical/assets/images/doctors/dr-michael-chen.jpg`
     - `/wp-content/themes/freshdew-medical/assets/images/doctors/dr-sarah-johnson.jpg`
     - `/wp-content/themes/freshdew-medical/assets/images/doctors/dr-james-wilson.jpg`
     - `/wp-content/themes/freshdew-medical/assets/images/doctors/dr-emily-rodriguez.jpg`

---

### Option 2: Use WordPress Media Library URLs

If you upload via WordPress Media Library, you can update the code to use WordPress attachment URLs:

1. **Upload images to Media Library**
2. **Get image URLs:**
   - Go to Media Library
   - Click on each image
   - Copy the "File URL"
3. **Update the code** (I can help with this if needed)

---

## Image Requirements

### Recommended Specifications:
- **Size:** 400x400px minimum (square format)
- **Format:** JPG (preferred) or PNG
- **Quality:** High resolution (at least 72 DPI)
- **Style:** Professional headshot
- **Background:** Neutral or professional background
- **File Size:** Under 500KB each (optimized)

### Image Guidelines:
- ✅ Professional headshot style
- ✅ Clear, well-lit photos
- ✅ Consistent style across all doctors
- ✅ Neutral or medical setting background
- ✅ Doctor wearing professional attire (white coat or business attire)
- ❌ Avoid casual photos
- ❌ Avoid low-resolution images
- ❌ Avoid inconsistent backgrounds

---

## File Structure

```
wordpress-theme/
└── freshdew-medical/
    └── assets/
        └── images/
            └── doctors/
                ├── dr-michael-chen.jpg
                ├── dr-sarah-johnson.jpg
                ├── dr-james-wilson.jpg
                └── dr-emily-rodriguez.jpg
```

---

## How It Works

The code automatically checks if the image file exists:
- **If image exists:** Shows the professional photo
- **If image doesn't exist:** Shows initials placeholder (MC, SJ, JW, ER)

This means you can add images anytime without breaking the site!

---

## Quick Upload Steps

1. **Via FTP (FileZilla):**
   ```
   Connect to your server
   Navigate to: /wp-content/themes/freshdew-medical/assets/images/
   Create folder: doctors
   Upload images with exact names:
   - dr-michael-chen.jpg
   - dr-sarah-johnson.jpg
   - dr-james-wilson.jpg
   - dr-emily-rodriguez.jpg
   ```

2. **Via Hostinger File Manager:**
   ```
   Log in to hPanel
   Files → File Manager
   Navigate to: wp-content/themes/freshdew-medical/assets/images/
   Create folder: doctors
   Upload images
   ```

3. **Via WordPress Admin:**
   ```
   Media → Add New
   Upload images
   Note: You'll need to update code to use Media Library URLs
   ```

---

## Testing

After uploading images:
1. Clear browser cache
2. Visit `/about` page
3. Doctor photos should appear automatically
4. If not, check file names match exactly (case-sensitive)

---

## Need Help?

If images don't appear:
1. Check file names match exactly (including case)
2. Verify file path is correct
3. Check file permissions (should be readable)
4. Clear browser and WordPress cache

The code is already set up - just add the images with the correct names!








