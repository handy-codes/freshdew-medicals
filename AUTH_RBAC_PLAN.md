# Authentication & Role-Based Access Control (RBAC) Plan
## FreshDew Medical Clinic – WordPress PHP Platform

---

## 1. Executive Summary

This document outlines a comprehensive plan for implementing authentication, role-based access management, and user dashboards for FreshDew Medical Clinic's WordPress-based platform. The system will support four user roles: **Head Admin (CMO)**, **Doctors**, **Staff**, and **Patients**.

---

## 2. Recommended Technology Stack

### Option A: WordPress-Native Approach (Recommended for WordPress)

| Component | Technology | Rationale |
|---|---|---|
| **Authentication** | WordPress built-in auth + Custom login/registration pages | Native WordPress user management is the most compatible with a WP theme |
| **RBAC** | WordPress Roles & Capabilities API | Built-in, no external dependencies |
| **Database** | WordPress MySQL/MariaDB (Hostinger-provided) | Already provisioned, zero additional cost |
| **Additional Security** | Two-Factor Authentication plugin + Custom middleware | HIPAA-adjacent security for medical data |

### Option B: Hybrid Approach (Clerk + External DB)

| Component | Technology | Rationale |
|---|---|---|
| **Authentication** | [Clerk](https://clerk.com/) via JavaScript SDK + PHP webhook | Modern auth UX with social login, MFA built-in |
| **Database** | [Neon PostgreSQL](https://neon.tech/) | Serverless Postgres, free tier available |
| **Backend API** | WordPress REST API + Custom endpoints in `functions.php` | No need for Render; WP REST API handles everything |
| **Session Bridge** | Clerk JWT → WordPress session sync via webhook | Clerk authenticates, WP manages role/permissions |

> **Recommendation**: **Option A** is strongly recommended for a WordPress project. Clerk and Neon add complexity without benefit since WordPress already has robust auth, roles, and a database. Option B would make more sense if migrating to Next.js in the future.

### Why NOT Render for a WordPress Backend?
- WordPress **is** the backend — it already handles routing, templates, REST API, and database
- Render would be redundant and add latency
- All custom logic lives in `functions.php` and custom plugins

---

## 3. User Roles & Permissions

### 3.1 Head Admin / Chief Medical Officer (CMO)

**Role slug**: `head_admin`

| Permission | Description |
|---|---|
| Manage all users | Create, edit, suspend, delete any user account |
| Create Admin accounts | Promote users to Admin role |
| Create Doctor accounts | Add new doctors to the system |
| View all patient records | Full access to all patient medical data |
| Manage clinic settings | Hours, contact info, services, AI chat config |
| View analytics dashboard | Appointment stats, patient growth, revenue |
| Manage appointments | Override, reschedule, cancel any appointment |
| Manage content | Edit all pages, blog posts, announcements |
| Audit log access | View all system activity logs |
| Export data | Export patient lists, appointment data, reports |

### 3.2 Admin / Office Manager

**Role slug**: `clinic_admin`

| Permission | Description |
|---|---|
| Manage patients | Create, edit patient profiles |
| Manage appointments | Schedule, reschedule, cancel appointments |
| View patient records | Access patient data (not delete) |
| Manage content | Edit pages and announcements |
| View reports | Access appointment and patient reports |
| Manage staff | Add/edit staff members (not Admins or CMO) |

### 3.3 Doctor

**Role slug**: `clinic_doctor`

| Permission | Description |
|---|---|
| View own patients | Access assigned patient records only |
| Manage own appointments | View, update own appointment schedule |
| Write medical notes | Add/edit consultation notes, prescriptions |
| Refer patients | Create referral documents |
| View own dashboard | Personal stats, upcoming appointments |
| Telehealth access | Initiate/join virtual consultations |

### 3.4 Patient

**Role slug**: `clinic_patient`

| Permission | Description |
|---|---|
| View own profile | See and edit personal information |
| Book appointments | Schedule appointments via online booking |
| View own records | Access personal medical history, prescriptions |
| Message clinic | Send messages through the patient portal |
| View invoices | Access billing and payment history |
| Telehealth access | Join virtual consultations |

---

## 4. Dashboard Features

### 4.1 Head Admin (CMO) Dashboard

```
┌─────────────────────────────────────────────────────────┐
│  FreshDew Admin Dashboard – Dr. [CMO Name]              │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  📊 Overview Cards                                      │
│  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐  │
│  │ Total    │ │ Today's  │ │ New      │ │ Revenue  │  │
│  │ Patients │ │ Appts    │ │ Patients │ │ This Mo  │  │
│  │ 1,247   │ │ 23       │ │ 15       │ │ $12,450  │  │
│  └──────────┘ └──────────┘ └──────────┘ └──────────┘  │
│                                                         │
│  📋 Sidebar Navigation                                  │
│  ├── Dashboard (Overview)                               │
│  ├── User Management                                    │
│  │   ├── All Users                                     │
│  │   ├── Create Admin                                  │
│  │   ├── Create Doctor                                 │
│  │   └── Create Staff                                  │
│  ├── Patient Records                                    │
│  │   ├── All Patients                                  │
│  │   ├── Search Patient                                │
│  │   └── Waitlist Registrations                        │
│  ├── Appointments                                       │
│  │   ├── Today's Schedule                              │
│  │   ├── All Appointments                              │
│  │   └── Calendar View                                 │
│  ├── Clinic Settings                                    │
│  │   ├── Hours of Operation                            │
│  │   ├── Services & Pricing                            │
│  │   ├── Contact Information                           │
│  │   └── AI Chat Configuration                         │
│  ├── Reports & Analytics                                │
│  │   ├── Patient Growth Chart                          │
│  │   ├── Appointment Analytics                         │
│  │   ├── Doctor Performance                            │
│  │   └── Export Data (CSV/PDF)                         │
│  ├── Communications                                     │
│  │   ├── Announcements                                 │
│  │   ├── Patient Messages                              │
│  │   └── Email Templates                               │
│  ├── Audit Log                                          │
│  └── System Settings                                    │
│                                                         │
│  📈 Charts                                              │
│  - Patient Registration Trend (Line Chart)              │
│  - Appointments by Type (Pie Chart)                     │
│  - Doctor Utilization (Bar Chart)                       │
│  - Walk-in vs. Scheduled (Comparison)                   │
│                                                         │
│  📋 Recent Activity Feed                                │
│  - "New patient John Smith registered" (2 min ago)      │
│  - "Dr. Kinze completed appointment #1234" (15 min ago) │
│  - "Admin Karen updated clinic hours" (1 hour ago)      │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

### 4.2 Doctor Dashboard

```
┌─────────────────────────────────────────────────────────┐
│  Doctor Dashboard – Dr. [Name]                          │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  📊 Today's Overview                                    │
│  ┌──────────┐ ┌──────────┐ ┌──────────┐               │
│  │ Today's  │ │ Pending  │ │ My       │               │
│  │ Patients │ │ Reviews  │ │ Patients │               │
│  │ 8        │ │ 3        │ │ 142      │               │
│  └──────────┘ └──────────┘ └──────────┘               │
│                                                         │
│  📋 Sidebar Navigation                                  │
│  ├── Dashboard (Today's Overview)                       │
│  ├── My Schedule                                        │
│  │   ├── Today's Appointments                          │
│  │   ├── Weekly Calendar                               │
│  │   └── Availability Settings                         │
│  ├── My Patients                                        │
│  │   ├── Patient List                                  │
│  │   ├── Search Patient                                │
│  │   └── Recent Consultations                          │
│  ├── Clinical Notes                                     │
│  │   ├── Write New Note                                │
│  │   ├── Recent Notes                                  │
│  │   └── Templates                                     │
│  ├── Prescriptions                                      │
│  │   ├── Active Prescriptions                          │
│  │   └── Write Prescription                            │
│  ├── Referrals                                          │
│  │   ├── Create Referral                               │
│  │   └── Referral History                              │
│  ├── Telehealth                                         │
│  │   ├── Start Consultation                            │
│  │   └── Scheduled Sessions                            │
│  └── My Profile                                         │
│                                                         │
│  📅 Today's Schedule (Timeline View)                    │
│  9:00 AM - John Smith (Follow-up)                       │
│  9:30 AM - Jane Doe (New Patient)                       │
│  10:00 AM - [Available]                                 │
│  10:30 AM - Mike Johnson (Walk-in)                      │
│  ...                                                    │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

### 4.3 Patient Dashboard

```
┌─────────────────────────────────────────────────────────┐
│  Patient Portal – Welcome, [Patient Name]               │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  📊 Quick Actions                                       │
│  ┌────────────────┐ ┌────────────────┐                 │
│  │ 📅 Book        │ │ 💬 Message     │                 │
│  │ Appointment    │ │ My Doctor      │                 │
│  └────────────────┘ └────────────────┘                 │
│  ┌────────────────┐ ┌────────────────┐                 │
│  │ 🖥️ Start       │ │ 📋 My         │                 │
│  │ Telehealth    │ │ Records       │                 │
│  └────────────────┘ └────────────────┘                 │
│                                                         │
│  📋 Sidebar Navigation                                  │
│  ├── Dashboard (Overview)                               │
│  ├── My Appointments                                    │
│  │   ├── Upcoming                                      │
│  │   ├── Past Appointments                             │
│  │   └── Book New Appointment                          │
│  ├── My Health Records                                  │
│  │   ├── Medical History                               │
│  │   ├── Prescriptions                                 │
│  │   ├── Lab Results                                   │
│  │   └── Referrals                                     │
│  ├── Telehealth                                         │
│  │   ├── Join Consultation                             │
│  │   └── Scheduled Sessions                            │
│  ├── Messages                                           │
│  │   ├── Inbox                                         │
│  │   └── Send Message                                  │
│  ├── Billing                                            │
│  │   ├── Invoices                                      │
│  │   └── Payment History                               │
│  └── My Profile                                         │
│      ├── Personal Information                           │
│      ├── Emergency Contact                              │
│      └── Change Password                                │
│                                                         │
│  📅 Upcoming Appointments                               │
│  - Feb 15, 2026 at 10:30 AM – Dr. Kinze (Follow-up)   │
│  - Mar 01, 2026 at 2:00 PM – Dr. Doe (Annual Checkup) │
│                                                         │
│  💊 Active Prescriptions                                │
│  - Amoxicillin 500mg (Expires: Mar 2026)               │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

---

## 5. Database Schema (New Custom Tables)

These tables extend WordPress's existing `wp_users` and `wp_usermeta`:

### 5.1 `wp_fd_patients` (Patient Profiles)
```sql
CREATE TABLE wp_fd_patients (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,           -- Links to wp_users
    date_of_birth DATE,
    gender ENUM('male','female','other','prefer_not_to_say'),
    health_card_number VARCHAR(20),
    emergency_contact_name VARCHAR(100),
    emergency_contact_phone VARCHAR(20),
    family_history TEXT,
    drug_history TEXT,
    allergy_history TEXT,
    medical_surgical_history TEXT,
    blood_type VARCHAR(5),
    assigned_doctor_id BIGINT UNSIGNED,          -- Links to wp_users (doctor)
    registration_status ENUM('waitlist','active','inactive') DEFAULT 'waitlist',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES wp_users(ID),
    INDEX idx_assigned_doctor (assigned_doctor_id),
    INDEX idx_registration_status (registration_status)
);
```

### 5.2 `wp_fd_appointments`
```sql
CREATE TABLE wp_fd_appointments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    patient_id BIGINT UNSIGNED NOT NULL,
    doctor_id BIGINT UNSIGNED NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    duration_minutes INT DEFAULT 30,
    type ENUM('walk_in','scheduled','telehealth','follow_up') NOT NULL,
    status ENUM('scheduled','confirmed','in_progress','completed','cancelled','no_show') DEFAULT 'scheduled',
    reason TEXT,
    symptoms TEXT,
    notes TEXT,
    created_by BIGINT UNSIGNED,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES wp_fd_patients(id),
    INDEX idx_doctor_date (doctor_id, appointment_date),
    INDEX idx_status (status)
);
```

### 5.3 `wp_fd_medical_notes`
```sql
CREATE TABLE wp_fd_medical_notes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    appointment_id BIGINT UNSIGNED,
    patient_id BIGINT UNSIGNED NOT NULL,
    doctor_id BIGINT UNSIGNED NOT NULL,
    note_type ENUM('consultation','follow_up','prescription','referral','lab_order') NOT NULL,
    content TEXT NOT NULL,
    is_private BOOLEAN DEFAULT FALSE,           -- Doctor-only notes
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (appointment_id) REFERENCES wp_fd_appointments(id),
    FOREIGN KEY (patient_id) REFERENCES wp_fd_patients(id),
    INDEX idx_patient (patient_id),
    INDEX idx_doctor (doctor_id)
);
```

### 5.4 `wp_fd_prescriptions`
```sql
CREATE TABLE wp_fd_prescriptions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    patient_id BIGINT UNSIGNED NOT NULL,
    doctor_id BIGINT UNSIGNED NOT NULL,
    appointment_id BIGINT UNSIGNED,
    medication_name VARCHAR(255) NOT NULL,
    dosage VARCHAR(100),
    frequency VARCHAR(100),
    duration VARCHAR(100),
    instructions TEXT,
    status ENUM('active','completed','cancelled') DEFAULT 'active',
    prescribed_date DATE NOT NULL,
    expiry_date DATE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES wp_fd_patients(id),
    INDEX idx_patient_status (patient_id, status)
);
```

### 5.5 `wp_fd_messages`
```sql
CREATE TABLE wp_fd_messages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sender_id BIGINT UNSIGNED NOT NULL,
    receiver_id BIGINT UNSIGNED NOT NULL,
    subject VARCHAR(255),
    content TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_receiver_read (receiver_id, is_read)
);
```

### 5.6 `wp_fd_audit_log`
```sql
CREATE TABLE wp_fd_audit_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    action VARCHAR(100) NOT NULL,
    entity_type VARCHAR(50),                    -- 'patient', 'appointment', 'prescription', etc.
    entity_id BIGINT UNSIGNED,
    details TEXT,
    ip_address VARCHAR(45),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user_action (user_id, action),
    INDEX idx_created_at (created_at)
);
```

### 5.7 `wp_fd_chat_history`
```sql
CREATE TABLE wp_fd_chat_history (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(64) NOT NULL,
    user_id BIGINT UNSIGNED,                    -- NULL for anonymous visitors
    role ENUM('user','assistant') NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_session (session_id),
    INDEX idx_user (user_id)
);
```

---

## 6. Implementation Phases

### Phase 1: Foundation (Week 1–2)
- [ ] Create custom WordPress roles (`head_admin`, `clinic_admin`, `clinic_doctor`, `clinic_patient`)
- [ ] Define capabilities for each role
- [ ] Create database tables via plugin activation hook
- [ ] Build custom login/registration pages (styled to match theme)
- [ ] Implement role-based redirect after login (each role → their dashboard)

### Phase 2: Dashboards (Week 3–4)
- [ ] Build Head Admin dashboard (overview stats, user management)
- [ ] Build Doctor dashboard (schedule, patient list)
- [ ] Build Patient dashboard (appointments, records)
- [ ] Implement sidebar navigation for each dashboard
- [ ] Add AJAX-powered data loading for dashboard cards

### Phase 3: Core Features (Week 5–6)
- [ ] Patient records CRUD (create, read, update, delete)
- [ ] Appointment scheduling system
- [ ] Doctor schedule/availability management
- [ ] Medical notes system
- [ ] Prescription management

### Phase 4: Communication (Week 7)
- [ ] Internal messaging system
- [ ] Email notifications (appointment reminders, messages)
- [ ] Announcement system (admin → all users)

### Phase 5: Advanced Features (Week 8–9)
- [ ] Telehealth integration (video call setup)
- [ ] Audit logging
- [ ] Data export (CSV, PDF)
- [ ] Analytics charts (Chart.js or similar)
- [ ] Chat history persistence in database

### Phase 6: Security & Polish (Week 10)
- [ ] Two-factor authentication
- [ ] Session management & timeout
- [ ] Input sanitization audit
- [ ] HIPAA compliance checklist
- [ ] Performance optimization
- [ ] Mobile responsiveness for all dashboards

---

## 7. Security Considerations

| Concern | Solution |
|---|---|
| **Password security** | WordPress password hashing (bcrypt) + enforce strong passwords |
| **Session hijacking** | WordPress nonces + HTTPS only + secure cookie flags |
| **CSRF protection** | WordPress nonce verification on all forms |
| **SQL injection** | WordPress `$wpdb->prepare()` for all queries |
| **XSS** | `esc_html()`, `esc_attr()`, `wp_kses()` on all output |
| **Data encryption** | Encrypt sensitive fields (health card numbers) at rest |
| **Audit trail** | Log all data access/modifications to audit table |
| **Two-factor auth** | TOTP-based 2FA for admin and doctor accounts |
| **Rate limiting** | Limit login attempts, API requests |
| **HIPAA compliance** | Data access controls, encryption, audit logs, BAA with hosting |

---

## 8. File Structure (New Plugin)

```
wordpress-plugins/
└── freshdew-clinic-system/
    ├── freshdew-clinic-system.php          # Main plugin file
    ├── includes/
    │   ├── class-roles.php                 # Role & capability definitions
    │   ├── class-database.php              # Table creation & migrations
    │   ├── class-patient.php               # Patient CRUD
    │   ├── class-appointment.php           # Appointment CRUD
    │   ├── class-medical-notes.php         # Notes CRUD
    │   ├── class-prescriptions.php         # Prescription CRUD
    │   ├── class-messages.php              # Messaging system
    │   ├── class-audit-log.php             # Activity logging
    │   └── class-auth.php                  # Custom login/registration
    ├── admin/
    │   ├── dashboard-head-admin.php        # CMO dashboard template
    │   ├── dashboard-admin.php             # Admin dashboard template
    │   ├── dashboard-doctor.php            # Doctor dashboard template
    │   ├── user-management.php             # User CRUD pages
    │   └── reports.php                     # Analytics & reports
    ├── patient/
    │   ├── dashboard.php                   # Patient dashboard template
    │   ├── appointments.php                # Patient appointment view
    │   ├── records.php                     # Patient records view
    │   └── messages.php                    # Patient messaging
    ├── templates/
    │   ├── login.php                       # Custom login page
    │   ├── register-patient.php            # Patient self-registration
    │   └── forgot-password.php             # Password reset
    ├── assets/
    │   ├── css/
    │   │   └── dashboard.css               # Dashboard styles
    │   └── js/
    │       ├── dashboard.js                # Dashboard interactivity
    │       └── charts.js                   # Analytics charts
    └── api/
        ├── rest-appointments.php           # REST API for appointments
        ├── rest-patients.php               # REST API for patients
        └── rest-messages.php               # REST API for messages
```

---

## 9. Decision: Clerk vs WordPress Native Auth

| Factor | Clerk | WordPress Native |
|---|---|---|
| **Integration effort** | High (JWT bridge, webhook sync) | Low (built-in) |
| **Cost** | Free up to 10K MAU, then $0.02/MAU | Free |
| **Social login** | Built-in (Google, Facebook, etc.) | Plugin needed |
| **MFA/2FA** | Built-in | Plugin or custom |
| **User management UI** | Clerk dashboard | WordPress admin |
| **WordPress compatibility** | Requires custom bridge code | Native |
| **Future Next.js migration** | Easy to reuse | Would need migration |

**Verdict**: Use **WordPress Native Auth** now. If you migrate to Next.js later, you can adopt Clerk at that point. For a WordPress site, fighting WordPress's auth system to use an external provider creates more problems than it solves.

---

## 10. Next Steps (Awaiting Approval)

1. ✅ Review this plan and approve the approach
2. ✅ Confirm which dashboard features are highest priority
3. ✅ Confirm Phase 1 scope (roles + custom tables + login pages)
4. 🔄 Begin implementation after approval

**Estimated total development time**: 8–10 weeks for full implementation
**MVP (login + dashboards + patient records)**: 3–4 weeks

