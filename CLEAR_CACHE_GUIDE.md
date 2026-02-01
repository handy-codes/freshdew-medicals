# 🧹 How to Clear Cache - Complete Guide

## 1. Clear Browser Cache (Windows)

### Method 1: Keyboard Shortcut (If Ctrl+F5 doesn't work)

**For Chrome/Edge:**
- Press: `Ctrl + Shift + R` (hard refresh)
- Or: `Ctrl + F5` (if it works on your system)

**For Firefox:**
- Press: `Ctrl + Shift + R`
- Or: `Ctrl + F5`

**For Opera:**
- Press: `Ctrl + Shift + R`

### Method 2: Manual Clear (Most Reliable)

**Chrome/Edge:**
1. Press `Ctrl + Shift + Delete`
2. Select "Cached images and files"
3. Time range: "All time" or "Last hour"
4. Click "Clear data"

**Firefox:**
1. Press `Ctrl + Shift + Delete`
2. Select "Cache"
3. Time range: "Everything"
4. Click "Clear Now"

**Opera:**
1. Press `Ctrl + Shift + Delete`
2. Select "Cached images and files"
3. Click "Clear data"

### Method 3: Developer Tools (Best for Testing)

1. **Open Developer Tools:**
   - Press `F12` or `Ctrl + Shift + I`

2. **Right-click the refresh button** (next to address bar)

3. **Select:** "Empty Cache and Hard Reload"

This is the most reliable method!

---

## 2. Clear WordPress Cache

### Step 1: Check What Caching Plugin You Have

**Common WordPress Caching Plugins:**
- **LiteSpeed Cache** (you have this installed!)
- **WP Super Cache**
- **W3 Total Cache**
- **WP Rocket**
- **Cache Enabler**
- **Autoptimize**

### Step 2: Clear Cache Based on Plugin

#### A. LiteSpeed Cache (You Have This!)

**Method 1: From Dashboard (Where You Are Now)**

1. **You're already on:** LiteSpeed Cache → Dashboard
2. **Look for one of these:**
   - A **"Purge All"** button at the top of the Dashboard
   - A **"Purge"** button in the "Cache Status" panel
   - Click the **"More"** link next to "Cache Status" → Look for "Purge All"
3. **Click it** to clear all cache

**Method 2: From Toolbox**

1. **In left sidebar:** Click **LiteSpeed Cache → Toolbox**
2. **Click:** "Purge All" button (usually at the top)

**Method 3: Quick Admin Bar Method**

- Look for **"LiteSpeed Cache"** in the top WordPress admin bar (when viewing frontend)
- Click it → **"Purge All"**

**Method 4: If You Can't Find "Purge All"**

1. **Go to:** LiteSpeed Cache → Toolbox
2. **Look for:** "Purge" or "Clear Cache" buttons
3. **Or:** Click each cache type individually:
   - Purge Public Cache
   - Purge Private Cache  
   - Purge Object Cache

#### B. WP Super Cache

1. **Go to:** Settings → WP Super Cache
2. **Click:** "Delete Cache" button

#### C. W3 Total Cache

1. **Go to:** Performance → Dashboard
2. **Click:** "Empty All Caches" button

#### D. WP Rocket

1. **Go to:** WP Rocket → Dashboard
2. **Click:** "Clear Cache" button

#### E. No Caching Plugin?

If you don't have a caching plugin:
- **Clear browser cache** (see Method 1 above)
- **That's it!** No WordPress cache to clear

### Step 3: Clear Object Cache (If Using)

**If you see "Object Cache" in your caching plugin:**
- Clear that too
- Usually in the same plugin settings

---

## 3. Clear CDN Cache (If Using)

**If you're using a CDN (Cloudflare, etc.):**

1. **Log in to CDN dashboard**
2. **Find "Purge Cache" or "Clear Cache"**
3. **Click it**

**Common CDNs:**
- **Cloudflare:** Dashboard → Caching → Purge Everything
- **KeyCDN:** Dashboard → Purge Cache
- **MaxCDN:** Dashboard → Purge Cache

---

## 4. Complete Cache Clearing Checklist

### For Best Results, Do ALL of These:

- [ ] **Clear browser cache** (Ctrl + Shift + Delete)
- [ ] **Hard refresh page** (F12 → Right-click refresh → Empty Cache and Hard Reload)
- [ ] **Clear WordPress cache** (LiteSpeed Cache → Purge All)
- [ ] **Clear CDN cache** (if using CDN)
- [ ] **Log out and log back in** to WordPress
- [ ] **Visit site in incognito/private window** to test

---

## 5. Quick Test Method

**Easiest way to test if cache is cleared:**

1. **Open Incognito/Private Window:**
   - Chrome: `Ctrl + Shift + N`
   - Firefox: `Ctrl + Shift + P`
   - Edge: `Ctrl + Shift + N`

2. **Visit your site:**
   - `https://freshdewmedicalclinic.com`
   - This shows the site WITHOUT cache

3. **Compare:**
   - If it looks different in incognito, cache needs clearing
   - If it looks the same, cache is cleared

---

## 6. Troubleshooting

### Ctrl+F5 Opens New Tab?

**This happens sometimes. Use these instead:**

**Chrome/Edge:**
- `Ctrl + Shift + R` (hard refresh)
- Or: `F12` → Right-click refresh button → "Empty Cache and Hard Reload"

**Firefox:**
- `Ctrl + Shift + R`
- Or: `Ctrl + F5`

**Best Method:**
- `F12` (open DevTools)
- Right-click refresh button
- Select "Empty Cache and Hard Reload"

### Cache Still Not Clearing?

1. **Try incognito window** (bypasses cache completely)
2. **Clear browser data completely:**
   - Settings → Privacy → Clear browsing data
   - Select "All time"
   - Check all boxes
   - Clear
3. **Disable caching plugin temporarily:**
   - LiteSpeed Cache → Settings → Disable
   - Test site
   - Re-enable

---

## 7. For Your Specific Case

### You Have LiteSpeed Cache Installed:

**Quick Steps:**
1. **WordPress Admin** → **LiteSpeed Cache** → **Toolbox**
2. **Click:** "Purge All"
3. **Browser:** Press `F12` → Right-click refresh → "Empty Cache and Hard Reload"
4. **Done!**

---

## ✅ Recommended Method (Most Reliable)

**For clearing cache to see your changes:**

1. **Open Developer Tools:** `F12`
2. **Right-click the refresh button** (next to address bar)
3. **Select:** "Empty Cache and Hard Reload"
4. **This bypasses ALL cache!**

**This is the most reliable method!** 🎯

---

## 📋 Quick Reference

| Action | Shortcut |
|--------|----------|
| Hard Refresh (Chrome/Edge) | `Ctrl + Shift + R` |
| Hard Refresh (Firefox) | `Ctrl + Shift + R` |
| Open DevTools | `F12` |
| Empty Cache & Reload | `F12` → Right-click refresh |
| Clear Browser Cache | `Ctrl + Shift + Delete` |
| Incognito Window | `Ctrl + Shift + N` |

---

**Use the Developer Tools method (F12 → Right-click refresh) - it's the most reliable!** 🚀

