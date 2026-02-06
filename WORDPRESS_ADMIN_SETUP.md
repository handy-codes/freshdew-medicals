# 📋 WordPress Admin Setup Guide

## Step-by-Step Instructions

---

## 1. Upload Logo

### Step 1: Go to Customizer
1. **Log in to WordPress Admin:** `https://freshdewmedicalclinic.com/wp-admin`
2. **Go to:** `Appearance` → `Customize` (in the left sidebar)
3. **Click:** `Site Identity` (in the left menu)

### Step 2: Upload Logo
1. **Find:** "Logo" section
2. **Click:** "Select logo" or "Change logo" button
3. **Upload:** Your hospital logo image (PNG, JPG, or SVG)
   - Recommended size: 200px width, 50px height
   - Or any size - it will be resized automatically
4. **Click:** "Select" or "Choose Image"
5. **Click:** "Publish" button (top right) to save

### Step 3: Verify
- Your logo should now appear in the header
- If not visible, clear your browser cache

---

## 2. Create Pages

### Step 1: Create About Page
1. **Go to:** `Pages` → `Add New` (in the left sidebar)
2. **Title:** Type "About"
3. **In the right sidebar:** Find "Page Attributes"
4. **Template:** Select "About Page" from dropdown
5. **Click:** "Publish" button

### Step 2: Create Walk-in Clinic Page
1. **Go to:** `Pages` → `Add New`
2. **Title:** Type "Walk-in Clinic"
3. **Template:** Select "Walk-in Clinic Page"**
4. **Click:** "Publish"

### Step 3: Create Family Practice Page
1. **Go to:** `Pages` → `Add New`
2. **Title:** Type "Family Practice"
3. **Template:** Select "Family Practice Page"**
4. **Click:** "Publish"

### Step 4: Create Telehealth Page
1. **Go to:** `Pages` → `Add New`
2. **Title:** Type "Telehealth"
3. **Template:** Select "Telehealth Page"**
4. **Click:** "Publish"

### Step 5: Create Contact Page (if not exists)
1. **Go to:** `Pages` → `Add New`
2. **Title:** Type "Contact"
3. **Template:** Select "Contact Page"**
4. **Click:** "Publish"

**Note:** The "Home" page should already exist. If not, create it with template "Home Page".

---

## 3. Set Up Navigation Menu

### Step 1: Create Menu
1. **Go to:** `Appearance` → `Menus` (in the left sidebar)
2. **Click:** "Create a new menu" link (or use existing menu)
3. **Menu Name:** Type "Primary Menu"
4. **Click:** "Create Menu" button

### Step 2: Add Pages to Menu
1. **In the left column:** Find "Pages" section
2. **Check the boxes** next to these pages:
   - Home
   - About
   - Walk-in Clinic
   - Family Practice
   - Telehealth
   - Contact
3. **Click:** "Add to Menu" button
4. **Pages will appear** in the right column

### Step 3: Arrange Menu Items
1. **Drag and drop** menu items to reorder them
2. **Order should be:**
   - Home
   - About
   - Walk-in Clinic
   - Family Practice
   - Telehealth
   - Contact

### Step 4: Assign Menu Location
1. **Scroll down** to "Menu Settings" section
2. **Check the box:** "Primary Menu" (under "Display location")
3. **Click:** "Save Menu" button

### Step 5: Verify
- Visit your website
- The navigation menu should appear in the header
- On mobile, it should show as a hamburger menu

---

## 📸 Visual Guide

### Upload Logo:
```
WordPress Admin
  └─ Appearance
      └─ Customize
          └─ Site Identity
              └─ Logo (upload here)
```

### Create Pages:
```
WordPress Admin
  └─ Pages
      └─ Add New
          └─ Title: "About"
          └─ Template: "About Page" (right sidebar)
          └─ Publish
```

### Set Up Menu:
```
WordPress Admin
  └─ Appearance
      └─ Menus
          └─ Create Menu
          └─ Add Pages
          └─ Assign to "Primary Menu"
          └─ Save Menu
```

---

## ✅ Quick Checklist

### Logo:
- [ ] Went to Appearance → Customize → Site Identity
- [ ] Uploaded logo image
- [ ] Clicked "Publish"
- [ ] Logo appears in header

### Pages:
- [ ] Created "About" page with "About Page" template
- [ ] Created "Walk-in Clinic" page with "Walk-in Clinic Page" template
- [ ] Created "Family Practice" page with "Family Practice Page" template
- [ ] Created "Telehealth" page with "Telehealth Page" template
- [ ] Created "Contact" page with "Contact Page" template
- [ ] All pages are published

### Menu:
- [ ] Created "Primary Menu"
- [ ] Added all pages to menu
- [ ] Arranged menu items in correct order
- [ ] Assigned menu to "Primary Menu" location
- [ ] Saved menu
- [ ] Menu appears on website

---

## 🎯 Expected Results

After completing all steps:

1. **Logo:** Your hospital logo appears in the header (top left)
2. **Pages:** All pages are accessible via navigation menu
3. **Menu:** Navigation menu shows all pages
4. **Mobile:** Hamburger menu works on mobile devices
5. **Homepage:** Shows your custom theme with map and content

---

## 🐛 Troubleshooting

### Logo Not Showing:
- **Clear browser cache** (Ctrl+F5 or Cmd+Shift+R)
- **Check logo file format** (PNG, JPG, or SVG)
- **Verify logo is uploaded** in Media Library
- **Check Customizer** - make sure you clicked "Publish"

### Pages Not Showing:
- **Verify pages are published** (not draft)
- **Check template is assigned** (right sidebar → Page Attributes)
- **Clear cache** if using caching plugin

### Menu Not Showing:
- **Verify menu is assigned** to "Primary Menu" location
- **Check menu has items** added
- **Make sure menu is saved**
- **Clear cache**

### Template Not Available:
- **Make sure theme is activated:** Appearance → Themes → "FreshDew Medical Clinic" should be active
- **If templates don't appear:** The theme files may not be deployed yet
- **Deploy theme first** via GitHub Actions

---

## 📞 Need Help?

If you encounter issues:
1. Check that the theme is activated
2. Verify all files are deployed (check GitHub Actions)
3. Clear browser cache
4. Check WordPress error logs (if available)

---

**Once all steps are complete, your website will be fully functional!** 🎉









