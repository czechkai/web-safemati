===============================================
SAFEMATI DATABASE - IMPORT INSTRUCTIONS
===============================================

TO FIX THE ERROR: "Table 'safemati_db.user_reports' doesn't exist"

Follow these steps:

1. Open phpMyAdmin in your browser:
   http://localhost/phpmyadmin

2. Select the 'safemati_db' database from the left sidebar

3. Click on the "Import" tab at the top

4. Click "Choose File" button

5. Navigate to and select:
   C:\wamp64\www\safemati\database\user_reports_schema.sql

6. Scroll down and click "Go" button

7. You should see: "Import has been successfully finished"

8. Verify the tables were created:
   - Click on the database name in the left sidebar
   - You should now see:
     * user_reports
     * admin_notifications

9. Refresh your SafeMati website - the error should be gone!

===============================================
TABLES CREATED:
===============================================

1. user_reports
   - Stores emergency/incident reports submitted by users
   - Fields: report_id, user_id, incident_type, title, description, 
             location, barangay, latitude, longitude, photo_path, 
             status (pending/accepted/rejected), admin_notes, 
             priority, created_at, updated_at

2. admin_notifications
   - Notifies admins when users submit new reports
   - Fields: notification_id, report_id, type, message, 
             is_read, created_at

===============================================
FEATURES ENABLED AFTER IMPORT:
===============================================

✓ Report Emergency button in user_alerts.php
✓ Emergency report submission form
✓ My Emergency Reports section in user profile
✓ Admin notifications for new reports
✓ Report status tracking (Pending/Accepted/Rejected)
✓ Photo upload for incident evidence
✓ GPS location capture
✓ Bookmarked Guides display in profile
✓ Favorite Hotlines display in profile

===============================================
