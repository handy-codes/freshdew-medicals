# 🔑 How to Add Groq API Key

## The settings page will appear after deployment, but here are 3 ways to add your API key NOW:

---

## Method 1: Direct Database Update (Quickest)

### Step 1: Access phpMyAdmin
1. **Log in to Hostinger hPanel**
2. **Go to:** Databases → phpMyAdmin
3. **Select** your WordPress database

### Step 2: Update Option
1. **Click** on `wp_options` table (or `yourprefix_options` if custom prefix)
2. **Click** "Search" tab
3. **Search for:** `option_name` = `freshdew_groq_api_key`
4. **If found:** Click "Edit" → Update `option_value` with your API key → Save
5. **If not found:** Click "Insert" → Add:
   - `option_name`: `freshdew_groq_api_key`
   - `option_value`: `gsk_your_api_key_here`
   - `autoload`: `yes`
   - Click "Go"

---

## Method 2: Via WordPress Functions (Temporary)

### Step 1: Edit functions.php
1. **Go to:** WordPress Admin → Appearance → Theme Editor
2. **Select:** `functions.php`
3. **Add this code** at the very end (before the closing `?>` or at the end):

```php
// Temporary: Add Groq API Key
// Remove this after adding via Settings page
add_action('admin_init', function() {
    if (!get_option('freshdew_groq_api_key')) {
        update_option('freshdew_groq_api_key', 'gsk_your_api_key_here');
    }
});
```

4. **Replace** `gsk_your_api_key_here` with your actual API key
5. **Click:** "Update File"
6. **Remove this code** after the settings page appears

---

## Method 3: Via FTP/File Manager

### Step 1: Create a temporary file
Create a file called `add-api-key.php` in your WordPress root directory:

```php
<?php
// Temporary script to add Groq API Key
// Delete this file after use!

require_once('wp-load.php');

// Replace with your API key
$api_key = 'gsk_your_api_key_here';

update_option('freshdew_groq_api_key', $api_key);

echo "API key added successfully!";
echo "<br>Please delete this file now for security.";
?>
```

### Step 2: Upload and run
1. **Upload** `add-api-key.php` to your WordPress root (same folder as `wp-config.php`)
2. **Visit:** `https://freshdewmedicalclinic.com/add-api-key.php`
3. **You should see:** "API key added successfully!"
4. **Delete** the file immediately after

---

## Method 4: Wait for Settings Page (After Deployment)

Once you deploy the updated theme files:

1. **Deploy changes:**
   ```bash
   git push origin main
   ```

2. **Wait for deployment** (check GitHub Actions)

3. **Go to:** WordPress Admin → Settings → FreshDew AI

4. **Enter** your API key and save

---

## 🔍 Verify Settings Page Will Appear

The settings page code is in:
- **File:** `wordpress-theme/freshdew-medical/functions.php`
- **Function:** `freshdew_add_settings_page()` (line 273)
- **Location:** Under Settings menu

**It will appear when:**
- ✅ Theme is active
- ✅ Theme files are deployed
- ✅ You have admin permissions

---

## ✅ Quick Test

After adding the API key via any method above:

1. **Test the chatbot** on your website
2. **Ask a question** - should get AI response (not fallback)
3. **Check browser console** for any errors

---

## 🎯 Recommended: Use Method 1 (Database)

**Easiest and safest:**
1. Get your Groq API key from https://console.groq.com
2. Use phpMyAdmin to add it directly
3. Test the chatbot
4. Settings page will appear after deployment for future updates

---

## 📝 Get Your Groq API Key

1. **Visit:** https://console.groq.com
2. **Sign up** or **Log in**
3. **Go to:** API Keys section
4. **Click:** "Create API Key"
5. **Copy** the key (starts with `gsk_...`)

---

**Choose the method that's easiest for you!** Method 1 (Database) is recommended. 🔑









