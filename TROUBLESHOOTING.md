# Troubleshooting Guide

## Fixed Issues

### 1. Clerk Authentication Errors
**Problem**: Clerk failing to load due to invalid/missing API keys

**Solution**: 
- Added graceful fallback - app works without Clerk keys
- ClerkProvider only wraps if key exists
- Navigation shows sign-in buttons only when Clerk is configured

**To Fix**:
1. Get your Clerk keys from https://dashboard.clerk.com
2. Add to `.env.local`:
   ```
   NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY=pk_test_...
   CLERK_SECRET_KEY=sk_test_...
   ```

### 2. Broken Images
**Problem**: Unsplash images not loading

**Solution**:
- Added fallback gradient backgrounds for each service card
- Images use `unoptimized` flag for external URLs
- Added error handlers with icon fallbacks

**Status**: Images should now load. If they don't, fallback gradients with icons will show.

### 3. Navigation 404 Errors
**Problem**: Routes returning 404

**Solution**:
- All routes exist in `app/(public)/` folder:
  - `/` → `app/(public)/page.tsx` ✅
  - `/about` → `app/(public)/about/page.tsx` ✅
  - `/walk-in-clinic` → `app/(public)/walk-in-clinic/page.tsx` ✅
  - `/family-practice` → `app/(public)/family-practice/page.tsx` ✅
  - `/contact` → `app/(public)/contact/page.tsx` ✅
  - `/telehealth` → `app/(public)/telehealth/page.tsx` ✅ (newly created)
  - `/appointments/book` → `app/(public)/appointments/book/page.tsx` ✅

**If still getting 404s**:
- Clear Next.js cache: Delete `.next` folder and restart dev server
- Check browser console for routing errors
- Verify middleware isn't blocking routes

### 4. Map Functionality
**Problem**: Is the map working or just a dummy?

**Solution**: 
- Map is **fully functional** using OpenStreetMap (free, no API key)
- Interactive iframe embed with zoom/pan controls
- "Open in Maps" button links to full OpenStreetMap view
- Shows exact hospital location at 2060 Ellesmere Rd, Scarborough, ON

**Features**:
- ✅ Interactive zoom and pan
- ✅ Marker showing hospital location
- ✅ Link to open in full map view
- ✅ No API key required (completely free)

### 5. Hero Mode Switcher Buttons
**Problem**: Image/Video toggle buttons visible but unclear purpose

**Solution**:
- **Temporarily hidden** because video source URL is not working
- Buttons were for switching between image and video hero backgrounds
- Video mode shows placeholder message
- Can be re-enabled when you have a working video URL

**To Re-enable**:
- Uncomment the hero mode switcher section in `app/(public)/page.tsx`
- Replace video source with a working URL

### 6. AI Chat Not Working
**Problem**: AI chat not responding despite Groq API key

**Solutions Applied**:
1. ✅ Removed authentication requirement (works for all users now)
2. ✅ Added better error logging
3. ✅ Improved fallback responses
4. ✅ Added `/api/ai-chat` to public routes in middleware

**To Debug**:
1. Check `.env.local` has: `GROQ_API_KEY=gsk_...`
2. Check browser console for API errors
3. Check server logs for Groq API responses
4. Test API directly: `curl -X POST http://localhost:3000/api/ai-chat -H "Content-Type: application/json" -d '{"message":"hello"}'`

**Common Issues**:
- Invalid API key format (should start with `gsk_`)
- Rate limiting (free tier has limits)
- Network issues blocking Groq API

**Fallback**: If Groq fails, AI chat uses rule-based responses automatically.

## Route Verification

All public routes should be accessible:
- ✅ `/` - Home page
- ✅ `/about` - About page
- ✅ `/walk-in-clinic` - Walk-in clinic info
- ✅ `/family-practice` - Family practice info
- ✅ `/contact` - Contact page
- ✅ `/telehealth` - Telehealth services (newly added)
- ✅ `/appointments/book` - Book appointment form
- ✅ `/sign-in` - Sign in page
- ✅ `/sign-up` - Sign up page

## Testing Checklist

- [ ] All navigation links work (no 404s)
- [ ] Images load or show fallback gradients
- [ ] Map is interactive and shows correct location
- [ ] AI chat responds (with or without Groq key)
- [ ] Appointment booking form works
- [ ] Clerk authentication works (if keys configured)
- [ ] No console errors

## Next Steps

1. **Set up Clerk** (optional but recommended):
   - Get keys from Clerk dashboard
   - Add to `.env.local`

2. **Set up Groq** (for AI chat):
   - Get free API key from https://console.groq.com
   - Add `GROQ_API_KEY=gsk_...` to `.env.local`

3. **Test all routes**:
   - Navigate through all pages
   - Verify no 404 errors

4. **Test AI chat**:
   - Click AI chat button
   - Send a message
   - Check browser console for errors if not working












