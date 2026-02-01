# 🎥 WebRTC Video/Voice Conference Setup Guide

## Current Status

**The Telehealth page currently shows a UI-only interface.** The video/voice call buttons work to:
- ✅ Access your camera/microphone
- ✅ Show local video preview
- ✅ Display the conference interface
- ❌ **Do NOT connect to doctors in real-time yet**

**This is a demo interface.** To make it fully functional, you need to integrate a WebRTC service.

---

## 🔧 How to Make It Fully Functional

### Option 1: Twilio Video (Recommended for Healthcare)

**Best for:** HIPAA-compliant, production-ready video calls

#### Setup Steps:

1. **Sign up for Twilio:**
   - Go to: https://www.twilio.com/try-twilio
   - Create account
   - Verify phone number

2. **Get API Credentials:**
   - Go to: Twilio Console → Account → API Keys & Tokens
   - Get:
     - Account SID
     - API Key SID
     - API Secret

3. **Install Twilio Video SDK:**
   - Add to WordPress theme or create plugin
   - Download: https://www.twilio.com/docs/video/javascript

4. **Add to WordPress:**
   - Create plugin or add to theme functions
   - Store credentials in WordPress options
   - Integrate with Telehealth page JavaScript

5. **Configure:**
   - Add Twilio credentials to WordPress options
   - Update JavaScript to use Twilio SDK
   - Test connection

**Cost:** ~$0.004 per participant per minute

---

### Option 2: Jitsi Meet (Free & Open Source)

**Best for:** Free, self-hosted solution

#### Setup Steps:

1. **Self-Host Jitsi:**
   - Install Jitsi Meet server
   - Or use Jitsi Meet API (easier)

2. **Use Jitsi Meet API:**
   - No server setup needed
   - Embed Jitsi Meet rooms
   - Free for unlimited use

3. **Integration:**
   - Update Telehealth page to embed Jitsi
   - Generate room names dynamically
   - Link patient and doctor to same room

**Cost:** Free (if self-hosted or using public Jitsi)

---

### Option 3: Zoom SDK

**Best for:** Familiar interface, widely used

#### Setup Steps:

1. **Sign up for Zoom:**
   - Go to: https://zoom.us
   - Create developer account
   - Create SDK app

2. **Get SDK Credentials:**
   - SDK Key
   - SDK Secret
   - Meeting credentials

3. **Install Zoom SDK:**
   - Download Zoom Web SDK
   - Add to WordPress theme
   - Integrate with Telehealth page

4. **Configure:**
   - Add credentials to WordPress
   - Update JavaScript
   - Test meetings

**Cost:** Varies by plan

---

### Option 4: Custom WebRTC Server

**Best for:** Full control, custom features

#### Setup Steps:

1. **Set up Signaling Server:**
   - Use WebSocket server (Node.js, Python, etc.)
   - Handle connection signaling
   - Manage room creation

2. **Set up STUN/TURN Servers:**
   - For NAT traversal
   - Use public STUN servers (free)
   - Or set up TURN server (for better connectivity)

3. **Implement WebRTC:**
   - Peer connection setup
   - Media stream handling
   - Connection management

4. **Integrate:**
   - Add to WordPress
   - Update Telehealth page
   - Test connections

**Cost:** Server hosting costs

---

## 📋 Recommended: Twilio Video Setup

### Step-by-Step Integration:

#### 1. Add Twilio Credentials to WordPress

Add to `functions.php` or create settings page:

```php
// Store in WordPress options
update_option('twilio_account_sid', 'your_account_sid');
update_option('twilio_api_key', 'your_api_key');
update_option('twilio_api_secret', 'your_api_secret');
```

#### 2. Install Twilio Video SDK

Add to `page-telehealth.php` before closing `</script>`:

```html
<script src="https://sdk.twilio.com/js/video/releases/2.20.1/twilio-video.min.js"></script>
```

#### 3. Update JavaScript

Replace the current video/voice call handlers with Twilio integration:

```javascript
// Example Twilio integration
const Video = Twilio.Video;

// Generate access token (server-side)
async function getAccessToken(roomName) {
    const response = await fetch('/wp-json/freshdew/v1/twilio-token', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ roomName: roomName })
    });
    return response.json();
}

// Connect to room
async function connectToRoom(roomName, localVideo, remoteVideo) {
    const { token } = await getAccessToken(roomName);
    
    const room = await Video.connect(token, {
        name: roomName,
        video: true,
        audio: true
    });
    
    // Handle remote participants
    room.on('participantConnected', participant => {
        participant.tracks.forEach(track => {
            if (track.kind === 'video') {
                remoteVideo.appendChild(track.attach());
            }
        });
    });
    
    return room;
}
```

#### 4. Create Token Endpoint

Add to `functions.php`:

```php
// REST API endpoint for Twilio token
function freshdew_twilio_token_endpoint() {
    register_rest_route('freshdew/v1', '/twilio-token', array(
        'methods' => 'POST',
        'callback' => 'freshdew_generate_twilio_token',
        'permission_callback' => '__return_true',
    ));
}
add_action('rest_api_init', 'freshdew_twilio_token_endpoint');

function freshdew_generate_twilio_token($request) {
    $roomName = $request->get_param('roomName');
    
    // Use Twilio PHP SDK to generate token
    // This requires installing Twilio PHP SDK via Composer
    
    // Return token
    return rest_ensure_response(array('token' => $token));
}
```

---

## 🎯 Quick Start: Jitsi Meet (Easiest)

### Simple Integration:

Update `page-telehealth.php` JavaScript:

```javascript
// Generate unique room name
function generateRoomName() {
    return 'freshdew-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
}

// Start Video Call with Jitsi
document.getElementById('start-video-call')?.addEventListener('click', function() {
    const roomName = generateRoomName();
    const jitsiUrl = `https://meet.jit.si/${roomName}`;
    
    // Open in new window or embed
    window.open(jitsiUrl, '_blank', 'width=800,height=600');
    
    // Or embed in page
    // const iframe = document.createElement('iframe');
    // iframe.src = jitsiUrl;
    // document.getElementById('video-container').appendChild(iframe);
});

// Start Voice Call with Jitsi
document.getElementById('start-voice-call')?.addEventListener('click', function() {
    const roomName = generateRoomName();
    const jitsiUrl = `https://meet.jit.si/${roomName}#config.startWithVideoMuted=true`;
    
    window.open(jitsiUrl, '_blank', 'width=800,height=600');
});
```

**This works immediately - no API keys needed!**

---

## 🔐 Security Considerations

### For Production:

1. **HIPAA Compliance:**
   - Use HIPAA-compliant services (Twilio, Zoom Healthcare)
   - Sign BAA (Business Associate Agreement)
   - Encrypt all communications

2. **Access Control:**
   - Require user authentication
   - Verify patient identity
   - Log all sessions

3. **Room Security:**
   - Use password-protected rooms
   - Time-limited access
   - Unique room names per appointment

---

## 📊 Comparison

| Service | Cost | Setup | HIPAA | Best For |
|---------|------|-------|-------|----------|
| **Twilio Video** | ~$0.004/min | Medium | ✅ Yes | Production healthcare |
| **Jitsi Meet** | Free | Easy | ⚠️ Self-hosted | Budget-friendly |
| **Zoom SDK** | Varies | Medium | ✅ Yes | Familiar interface |
| **Custom WebRTC** | Server costs | Hard | ⚠️ Depends | Full control |

---

## ✅ Recommended Next Steps

### For Quick Demo:
1. **Use Jitsi Meet** (easiest, free)
2. Update JavaScript to open Jitsi rooms
3. Test with two browsers/devices

### For Production:
1. **Use Twilio Video** (HIPAA-compliant)
2. Set up Twilio account
3. Install Twilio SDK
4. Create token endpoint
5. Integrate with appointment system
6. Test thoroughly

---

## 🧪 Testing

### Current UI Testing:
1. Click "Start Video Call" → Should access camera
2. Click "Start Voice Call" → Should access microphone
3. See local video/voice indicator
4. Test mute/unmute controls
5. Test end call

### Full WebRTC Testing (After Integration):
1. Open in two different browsers/devices
2. Both join same room
3. Verify video/audio streams
4. Test all controls
5. Test connection stability

---

## 📝 Implementation Checklist

### Basic Setup:
- [ ] Choose WebRTC service (Twilio/Jitsi/Zoom)
- [ ] Get API credentials
- [ ] Install SDK
- [ ] Update JavaScript
- [ ] Test locally

### Production Setup:
- [ ] Add authentication
- [ ] Implement room management
- [ ] Add appointment linking
- [ ] Set up recording (if needed)
- [ ] Configure security
- [ ] Test with real users

---

## 🚀 Quick Implementation: Jitsi Meet

**Easiest way to get it working:**

1. **Update `page-telehealth.php` JavaScript section**
2. **Replace current handlers with Jitsi integration**
3. **Test immediately** - no API keys needed!

**I can provide the complete Jitsi integration code if you want the easiest solution.**

---

## 💡 Current Status

**What Works:**
- ✅ UI interface
- ✅ Camera/microphone access
- ✅ Local video preview
- ✅ Controls (mute, video on/off, end call)

**What Doesn't Work Yet:**
- ❌ Real-time connection to doctors
- ❌ Remote video/audio streams
- ❌ Actual WebRTC peer connection

**To Make It Work:**
- Choose a WebRTC service
- Integrate SDK
- Update JavaScript
- Test connections

---

**Would you like me to implement Jitsi Meet integration? It's the fastest way to get real video/voice calls working!** 🎥

