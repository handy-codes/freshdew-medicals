# Google My Business & Google Maps Setup Guide for FreshDew Medical Clinic

## Step 1: Create a Google Business Profile

1. Go to **[Google Business Profile](https://business.google.com/)** and sign in with a Google account (preferably `info@freshdewmedicalclinic.com` or the clinic's official Google account).
2. Click **"Add your business to Google"**.
3. Search for "FreshDew Medical Clinic" first — if it already exists from Google's crawling, claim it. Otherwise, create a new listing.

### Business Information to Enter

| Field | Value |
|---|---|
| **Business name** | FreshDew Medical Clinic |
| **Business category** | Medical clinic *(primary)*, Family practice physician, Walk-in clinic |
| **Address** | 135 Cannifton Road, Unit 2 & 3, Belleville, Ontario K8N 4V4, Canada |
| **Service area** | Belleville and surrounding areas (Bay of Quinte region) |
| **Phone** | (613) 243-0110 |
| **Website** | https://freshdewmedicalclinic.com |
| **Hours** | Mon–Fri: 9:00 AM – 5:00 PM, Sat: 10:00 AM – 4:00 PM, Sun: Closed |

## Step 2: Verify Your Business

Google will need to verify you own this business. Options:
- **Postcard by mail** (most common for new businesses): Google mails a postcard with a verification code to your clinic address. Takes 5–14 days.
- **Phone verification**: If available, Google calls or texts the clinic number.
- **Video verification**: Record a short video walking through the clinic showing the address.

> **Tip**: Use the exact address format that matches your official documents and Canada Post records.

## Step 3: Optimize Your Profile

Once verified, complete these sections:

### 3a. Business Description
```
FreshDew Medical Clinic is committed to delivering exceptional patient care to persons of all ages in a warm, welcoming environment. We provide comprehensive family healthcare, walk-in clinic services, and innovative telehealth solutions in Belleville, Ontario. Now accepting new patients.
```

### 3b. Services
Add each service as a separate entry:
- Walk-in Clinic
- Family Practice
- Telehealth / Virtual Consultations
- Patient Registration
- Preventive Care
- Women's Health
- Men's Health
- Chronic Disease Management
- Musculoskeletal Health

### 3c. Photos
Upload high-quality images:
- Clinic exterior (with visible address/signage)
- Reception area
- Examination rooms
- Team photos (Dr. Joy Kinze, Dr. Jamal Doe, Karen Howald)
- The FreshDew logo

### 3d. Attributes
Mark applicable attributes:
- ✅ Wheelchair accessible
- ✅ Accepts new patients
- ✅ Walk-ins welcome
- ✅ Telehealth available
- ✅ Appointment required (for family practice)

### Fix: Wrong business showing on the right (e.g. “Freshdew Children’s Clinic” / Nigeria)

If when you search **“freshdew medical clinic”** the **right-hand panel (Knowledge Panel / map)** shows a different business (e.g. “Freshdew Children’s Clinic”, Nigeria) instead of your Belleville clinic:

- **That panel is driven by Google Business Profile (GBP), not by your website alone.** Google picks one business to show there; if you don’t have a **verified** profile for “FreshDew Medical Clinic” at 135 Cannifton Road, Belleville, it may show another similarly named business.
- **What to do:**
  1. **Create or claim the correct profile** (Steps 1–2 above): [business.google.com](https://business.google.com) → Add your business (or search for “FreshDew Medical Clinic” and claim it if it exists).
  2. Use the **exact** name **“FreshDew Medical Clinic”**, address **135 Cannifton Road, Unit 2 & 3, Belleville, Ontario K8N 4V4, Canada**, and website **https://freshdewmedicalclinic.com**.
  3. **Verify** the business (postcard to that address, or another method Google offers).
  4. After verification, fill in hours, photos, services, and description (Step 3 above).
- Once your **Belleville** profile is verified and complete, Google can start showing **your** map and details on the right for “freshdew medical clinic” (especially for users in or near Ontario). You cannot force this from the website; it depends on having the correct, verified GBP.

## Step 4: Add Your Website to Google Search Console

1. Go to **[Google Search Console](https://search.google.com/search-console/about)**
2. Click **"Start now"** and sign in with the same Google account.
3. Choose **"URL prefix"** method and enter: `https://freshdewmedicalclinic.com`
4. Verify ownership using one of these methods:
   - **HTML tag** (recommended): Copy the `<meta>` tag Google provides and add it to your WordPress theme's `header.php` inside `<head>`.
   - **DNS record**: Add a TXT record in Hostinger DNS settings.
5. Once verified, submit your sitemap:
   - **No plugin needed:** The site uses WordPress’s built-in sitemap (no need to install Yoast SEO or XML Sitemaps on Hostinger).
   - In **Google Search Console:** open the left menu → **Sitemaps** → under “Add a new sitemap” enter **`wp-sitemap.xml`** (WordPress core sitemap) → click **Submit**.
   - Full URL for reference: `https://freshdewmedicalclinic.com/wp-sitemap.xml`

### SEO & Search Console checklist (what’s already on the site)

The FreshDew theme already includes the following for search visibility. No extra plugins required.

| Item | Status |
|------|--------|
| **Document &lt;title&gt;** | ✅ Per-page (e.g. “About – FreshDew Medical Clinic”) via `pre_get_document_title` |
| **Meta description** | ✅ One per page (home, about, contact, telehealth, etc.) via `freshdew_get_meta_description()` |
| **Canonical URL** | ✅ Set on all pages (home and `get_permalink()` on inner pages) |
| **Robots** | ✅ `index, follow` in `<head>` |
| **Open Graph** | ✅ og:title, og:description, og:url, og:image, og:site_name, og:locale (per-page title/description) |
| **Twitter Card** | ✅ title, description, url, image (per-page) |
| **Structured data** | ✅ JSON-LD MedicalClinic schema (address, hours, phone, services) + BreadcrumbList on inner pages |
| **Geo / local** | ✅ geo.region, geo.placename, ICBM in `<head>` |
| **Sitemap** | ✅ `wp-sitemap.xml` (pages/posts only; users & taxonomies excluded) |

**In Search Console (after verification):**

- Submit sitemap: **`https://freshdewmedicalclinic.com/wp-sitemap.xml`** (you’ve done this).
- Use **URL Inspection** for important URLs (home, About, Contact) to request indexing if they’re “Discovered – currently not indexed.”
- Check **Pages** and **Experience** (Core Web Vitals, mobile usability) over time.

## Step 5: Set Up Google Analytics (Optional but Recommended)

1. Go to **[Google Analytics](https://analytics.google.com/)**
2. Create a property for `freshdewmedicalclinic.com`
3. Choose **GA4** (Google Analytics 4)
4. Copy the Measurement ID (looks like `G-XXXXXXXXXX`)
5. Install in WordPress:
   - Use the **"Site Kit by Google"** plugin (free, official)
   - Or manually add the GA4 snippet to `header.php` before `</head>`

## Step 6: Encourage Patient Reviews

Reviews are the #1 factor for local Google ranking:

1. From your Google Business Profile dashboard, find the **"Ask for reviews"** link.
2. Share this link with patients after visits (via email, text, or printed card).
3. Example message:
   > "Thank you for visiting FreshDew Medical Clinic! If you had a positive experience, we'd appreciate a Google review: [link]"

## Step 7: Post Regular Updates

Use Google Business Profile's **"Posts"** feature:
- Announce new services, hours changes, or health tips
- Posts appear directly in Google Search/Maps results
- Post at least 1–2 times per month

## Step 8: Monitor & Respond

- Check the **"Reviews"** tab weekly — respond to all reviews (positive and negative)
- Check **"Insights"** to see how many people find your clinic via Google
- Monitor **"Q&A"** section — answer any patient questions promptly

---

## How to Make FreshDew Discoverable Worldwide

1. **Google Business Profile** (above) = discoverable on Google Maps globally
2. **Structured Data** (already added to website) = rich search results
3. **Consistent NAP** (Name, Address, Phone): Ensure these are identical everywhere:
   - Website
   - Google Business
   - Facebook
   - Yelp
   - Yellow Pages Canada
   - Healthgrades
   - RateMDs
4. **Directory Listings**: Submit to:
   - [Canada411](https://www.canada411.ca/)
   - [YellowPages.ca](https://www.yellowpages.ca/)
   - [RateMDs](https://www.ratemds.com/)
   - [Healthgrades](https://www.healthgrades.com/)
   - Ontario College of Family Physicians directory
5. **Google Ads** (optional): Run location-based ads targeting "family doctor Belleville" etc.

---

## Timeline

| Action | Time Required |
|---|---|
| Create Google Business Profile | 30 minutes |
| Verification (postcard) | 5–14 days |
| Optimize profile | 1–2 hours |
| Google Search Console setup | 30 minutes |
| Directory submissions | 1–2 hours |
| First results visible in Google | 2–4 weeks |
| Strong local ranking | 3–6 months (with reviews) |

