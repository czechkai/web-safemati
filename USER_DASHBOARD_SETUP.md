# SafeMati User Dashboard System - Complete Setup Guide

## 🎯 Overview

This comprehensive user-side system includes all necessary pages, database integration, real-time features, and consistent dark theme design for the SafeMati disaster management platform.

---

## 📋 What's Included

### ✅ User Pages Created

1. **user_profile.php** - Complete profile management with:
   - Personal information editing (name, email, phone, barangay)
   - Password change functionality
   - Notification preferences
   - Profile avatar with user initials
   - Real-time form validation

2. **user_notifications.php** - Notification center with:
   - Unread/read status tracking
   - Filter by type (alerts, weather, safety, system)
   - Mark as read functionality
   - "Mark all as read" button
   - Real-time updates
   - Category-based filtering

3. **user_settings.php** - Settings & Privacy with:
   - Account visibility toggles
   - Privacy & security options
   - Notification preferences
   - Two-factor authentication setup
   - Login history view
   - Data download option
   - Danger zone (account deactivation/deletion)

4. **user_help.php** - Help & Support center with:
   - Quick help cards
   - Expandable FAQ section
   - Contact support form
   - Video tutorials link
   - User guide access

5. **user_feedback.php** - Feedback system with:
   - Feedback type selection (suggestion, bug, general)
   - 5-star rating system
   - Subject and message fields
   - Contact permission checkbox
   - Beautiful animations

6. **user_guides.php** - Enhanced guides page with:
   - Progress tracker (X/6 guides completed)
   - Checkmarks on completed guides
   - Bookmark functionality
   - Personalized resources based on barangay
   - "Your Location" info box

7. **user_hotlines.php** - Enhanced hotlines page with:
   - Favorite star toggle on each hotline
   - "Your Favorite Hotlines" section at top
   - Real-time favorite management
   - Copy number button
   - Call button

### ✅ Database Schema

**File:** `database/user_features_schema.sql`

**Tables Created:**
1. `user_bookmarked_guides` - Stores bookmarked disaster guides
2. `user_favorite_hotlines` - Stores favorite emergency hotlines
3. `user_guide_progress` - Tracks completion of disaster guides
4. `user_feedback` - Stores user feedback and ratings
5. `user_settings` - Stores user preferences
6. `user_notifications` - Enhanced notification system
7. `user_login_history` - Security tracking

### ✅ AJAX Handlers (Real-time Features)

**Location:** `ajax/` folder

1. **toggle_bookmark.php** - Add/remove guide bookmarks
2. **toggle_favorite.php** - Add/remove favorite hotlines
3. **mark_notification_read.php** - Mark notifications as read
4. **toggle_safe_status.php** - Update "Mark as Safe" status
5. **update_setting.php** - Update user preferences

### ✅ Design Consistency

**Dark Theme Colors:**
- Background: gray-900 (#121212)
- Cards: gray-800 (#1f2937)
- Borders: gray-700 (#374151)
- Accent: red-500 (#ef4444)
- Text: white/gray-300

**All pages feature:**
- Consistent navigation (Dashboard, Alerts, Disaster Guides, Emergency Hotlines)
- Unified header with profile dropdown
- Matching footer
- Hover effects with red glow
- Font Awesome icons
- Responsive Tailwind CSS design

---

## 🚀 Installation Steps

### 1. Import Database Schema

```sql
-- Run these files in phpMyAdmin in order:

1. database/safemati_schema_clean.sql (if not already done)
2. database/safemati_alerts_system.sql (if not already done)
3. database/user_features_schema.sql (NEW - run this now)
```

### 2. Verify Database Tables

After import, you should have these tables:
- users
- alerts
- alert_safety_status
- user_notifications
- user_bookmarked_guides
- user_favorite_hotlines
- user_guide_progress
- user_feedback
- user_settings
- user_login_history
- hotlines
- disaster_guides
- safety_tips
- evacuation_centers
- weather
- incident_reports
- system_logs

### 3. Update Session Variables

Ensure `user_header.php` sets these session variables on login:
```php
$_SESSION['user_id']
$_SESSION['user_name']
$_SESSION['user_email']
$_SESSION['user_barangay']
```

### 4. Test Each Page

Visit each page to verify functionality:
- http://localhost/safemati/user_dashboard.php
- http://localhost/safemati/user_profile.php
- http://localhost/safemati/user_notifications.php
- http://localhost/safemati/user_settings.php
- http://localhost/safemati/user_help.php
- http://localhost/safemati/user_feedback.php
- http://localhost/safemati/user_guides.php
- http://localhost/safemati/user_hotlines.php
- http://localhost/safemati/user_alerts.php

---

## 🔧 Configuration

### Database Connection

Verify `db_connect.php` has correct credentials:
```php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'safemati_db');
```

### AJAX Paths

All AJAX handlers expect to be called from the root directory:
```javascript
fetch('ajax/toggle_bookmark.php', {
    method: 'POST',
    body: formData
})
```

---

## 💡 Features Explanation

### 1. Progress Tracker (Guides Page)
- Shows "3/6" completed guides
- Visual progress bar
- Checkmarks on completed guides
- Tracks user learning journey

### 2. Favorite Hotlines
- Star icon on each hotline card
- Click to toggle favorite status
- Favorites appear at top in dedicated section
- Persists across sessions via database

### 3. Bookmark Guides
- "View Bookmarked Guides" button
- Save guides to review later
- Quick access to important information

### 4. Mark as Safe (Alerts)
- Toggle button on alert cards
- Click once: "You're Safe" (green)
- Click again: Undo (red "Mark as Safe")
- Updates database via AJAX

### 5. Notifications
- Real-time unread count
- Filter by category
- Mark individual or all as read
- Links to relevant pages

### 6. Settings Toggles
- Smooth animated switches
- Instant visual feedback
- Saves to database
- Persistent preferences

---

## 🎨 Design Features

### Consistent Elements

**All Cards:**
```css
background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
border: 2px solid #374151;
```

**Hover Effects:**
```css
border-color: #ef4444;
box-shadow: 0 0 25px rgba(239, 68, 68, 0.3);
transform: translateY(-5px);
```

**Buttons:**
```css
background: linear-gradient(135deg, #ef4444, #dc2626);
hover: transform: translateY(-2px);
```

### Icons Used

- Dashboard: fa-house-user
- Alerts: fa-bell
- Guides: fa-book-open
- Hotlines: fa-phone-alt
- Profile: fa-user-circle
- Settings: fa-gear
- Notifications: fa-bell
- Help: fa-circle-question
- Feedback: fa-comment-dots

---

## 📊 Database Queries Reference

### Get User's Bookmarked Guides
```sql
SELECT g.*, b.bookmarked_at
FROM user_bookmarked_guides b
JOIN disaster_guides g ON b.guide_id = g.guide_id
WHERE b.user_id = ?
ORDER BY b.bookmarked_at DESC;
```

### Get User's Favorite Hotlines
```sql
SELECT h.*, f.favorited_at
FROM user_favorite_hotlines f
JOIN hotlines h ON f.hotline_id = h.hotline_id
WHERE f.user_id = ?
ORDER BY f.favorited_at DESC;
```

### Get Guide Completion Progress
```sql
SELECT 
    COUNT(*) as total_guides,
    SUM(CASE WHEN p.is_completed = 1 THEN 1 ELSE 0 END) as completed_guides,
    ROUND((SUM(CASE WHEN p.is_completed = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as completion_percentage
FROM disaster_guides g
LEFT JOIN user_guide_progress p ON g.guide_id = p.guide_id AND p.user_id = ?;
```

### Get Unread Notifications
```sql
SELECT *
FROM user_notifications
WHERE user_id = ? AND is_read = 0
ORDER BY created_at DESC;
```

---

## 🐛 Troubleshooting

### Issue: "User not logged in" error
**Solution:** Ensure session is started and user_id is set in session

### Issue: AJAX not working
**Solution:** Check browser console for errors, verify paths are correct

### Issue: Database connection failed
**Solution:** Verify db_connect.php credentials and MySQL service is running

### Issue: Foreign key constraints failing
**Solution:** Ensure parent tables (users, alerts, guides, hotlines) exist first

### Issue: Pages not displaying correctly
**Solution:** Clear browser cache, check Tailwind CSS CDN is loading

---

## 📱 Mobile Responsiveness

All pages are fully responsive:
- **Mobile:** Single column layout
- **Tablet:** 2-column grids
- **Desktop:** 3-column grids, sidebar layouts

Tested on:
- iPhone (iOS Safari)
- Android (Chrome)
- iPad
- Desktop (1920x1080)

---

## 🔒 Security Features

1. **Session Management:** All pages check for active session
2. **Prepared Statements:** All database queries use prepared statements
3. **Password Hashing:** Uses PHP password_hash() with bcrypt
4. **Input Validation:** Server-side validation on all forms
5. **CSRF Protection:** (Recommended: Add tokens to forms)
6. **SQL Injection Prevention:** Parameterized queries throughout

---

## 🎯 Next Steps

### Recommended Additions:

1. **Admin Dashboard** - Manage users, alerts, feedback
2. **Email Notifications** - Send alerts via email
3. **SMS Integration** - Send critical alerts via SMS
4. **PWA Features** - Make it installable as mobile app
5. **Push Notifications** - Browser push notifications
6. **Real-time Updates** - WebSocket for live alert updates
7. **Analytics Dashboard** - Track user engagement
8. **Multi-language Support** - Tagalog/English toggle

---

## 📄 File Structure

```
safemati/
├── user_dashboard.php          (Main dashboard)
├── user_profile.php            (Profile management)
├── user_notifications.php      (Notification center)
├── user_settings.php           (Settings & privacy)
├── user_help.php               (Help & support)
├── user_feedback.php           (Feedback form)
├── user_guides.php             (Disaster guides with bookmarks)
├── user_hotlines.php           (Emergency hotlines with favorites)
├── user_alerts.php             (Alerts with mark as safe)
├── user_header.php             (Consistent header)
├── user_footer.php             (Consistent footer)
├── db_connect.php              (Database connection)
├── ajax/
│   ├── toggle_bookmark.php     (Bookmark handler)
│   ├── toggle_favorite.php     (Favorite handler)
│   ├── mark_notification_read.php (Notification handler)
│   ├── toggle_safe_status.php  (Safety status handler)
│   └── update_setting.php      (Settings handler)
└── database/
    ├── safemati_schema_clean.sql        (Core tables)
    ├── safemati_alerts_system.sql       (Alert system)
    └── user_features_schema.sql         (User features - NEW)
```

---

## ✅ Checklist

- [x] All user pages created
- [x] Database schema designed
- [x] AJAX handlers implemented
- [x] Consistent dark theme applied
- [x] Navigation updated
- [x] Profile management working
- [x] Notifications system functional
- [x] Settings page complete
- [x] Help & feedback pages done
- [x] Bookmarks feature added
- [x] Favorites feature added
- [x] Mark as safe functionality
- [x] Dashboard improved
- [x] Hazard map aligned
- [x] Weather widget enhanced
- [x] Mobile responsive design
- [x] Security measures implemented

---

## 📞 Support

For questions or issues:
- Check the FAQ in user_help.php
- Submit feedback via user_feedback.php
- Review this README for setup instructions

---

## 🎉 Congratulations!

Your SafeMati user dashboard system is now complete with all features, database integration, and consistent design!

**Last Updated:** November 19, 2025
**Version:** 1.0.0
**Status:** Production Ready ✅
