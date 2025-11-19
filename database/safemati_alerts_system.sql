-- =====================================================
-- SafeMati Alerts System - Enhanced Schema
-- =====================================================
-- This adds the Mark as Safe functionality and user acknowledgments
-- to your existing SafeMati database
-- =====================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+08:00";
SET FOREIGN_KEY_CHECKS = 0;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- =====================================================
-- NOTE: The 'alerts' table already exists in safemati_schema_clean.sql
-- This file assumes you're using that existing structure.
-- If you need to modify the alerts table, use ALTER TABLE instead.
-- =====================================================

-- =====================================================
-- 1. ALERT SAFETY STATUS TABLE
-- Tracks "Mark as Safe" functionality per user per alert
-- =====================================================
DROP TABLE IF EXISTS `alert_safety_status`;

CREATE TABLE `alert_safety_status` (
  `safety_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alert_id` INT(11) UNSIGNED NOT NULL,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `status` ENUM('safe', 'unsafe', 'unmarked') NOT NULL DEFAULT 'unmarked',
  `location_details` VARCHAR(255) DEFAULT NULL COMMENT 'Optional: Where user marked themselves safe',
  `notes` TEXT DEFAULT NULL COMMENT 'Optional: User can add details about their situation',
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`safety_id`),
  UNIQUE KEY `unique_user_alert` (`user_id`, `alert_id`),
  KEY `idx_alert_id` (`alert_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_status` (`status`),
  KEY `idx_updated_at` (`updated_at`),
  CONSTRAINT `fk_safety_alert` FOREIGN KEY (`alert_id`) REFERENCES `alerts` (`alert_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_safety_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
COMMENT='Tracks user safety status for each alert (Mark as Safe feature)';

-- =====================================================
-- 2. USER ALERT ACKNOWLEDGMENTS TABLE
-- Tracks when users acknowledge/view alerts
-- =====================================================
DROP TABLE IF EXISTS `user_alert_acknowledgments`;

CREATE TABLE `user_alert_acknowledgments` (
  `ack_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alert_id` INT(11) UNSIGNED NOT NULL,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `acknowledged_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `device_info` VARCHAR(255) DEFAULT NULL COMMENT 'Optional: Track which device user used',
  PRIMARY KEY (`ack_id`),
  UNIQUE KEY `unique_user_alert_ack` (`user_id`, `alert_id`),
  KEY `idx_alert_id` (`alert_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_acknowledged_at` (`acknowledged_at`),
  CONSTRAINT `fk_ack_alert` FOREIGN KEY (`alert_id`) REFERENCES `alerts` (`alert_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ack_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Tracks when users acknowledge/read alerts';

-- =====================================================
-- 3. ENHANCED USER NOTIFICATIONS TABLE
-- Note: This already exists in your schema, but here's an enhanced version
-- If the table exists, you can use ALTER TABLE commands below instead
-- =====================================================
DROP TABLE IF EXISTS `user_notifications_enhanced`;

CREATE TABLE `user_notifications_enhanced` (
  `notification_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `alert_id` INT(11) UNSIGNED DEFAULT NULL,
  `message` TEXT NOT NULL,
  `notification_type` ENUM('alert', 'system', 'reminder', 'update', 'safety_check') NOT NULL DEFAULT 'alert',
  `priority` ENUM('low', 'normal', 'high', 'urgent') NOT NULL DEFAULT 'normal',
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `read_at` TIMESTAMP NULL DEFAULT NULL,
  `sent_via` ENUM('web', 'email', 'sms', 'push') DEFAULT 'web',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`notification_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_alert_id` (`alert_id`),
  KEY `idx_is_read` (`is_read`),
  KEY `idx_priority` (`priority`),
  KEY `idx_created_at` (`created_at`),
  CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_notif_alert` FOREIGN KEY (`alert_id`) REFERENCES `alerts` (`alert_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Enhanced notifications table with priority and delivery tracking';

-- =====================================================
-- 4. ALERT STATISTICS TABLE (Bonus)
-- Tracks aggregate statistics per alert for dashboard display
-- =====================================================
DROP TABLE IF EXISTS `alert_statistics`;

CREATE TABLE `alert_statistics` (
  `stat_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alert_id` INT(11) UNSIGNED NOT NULL,
  `total_affected_users` INT(11) NOT NULL DEFAULT 0,
  `users_marked_safe` INT(11) NOT NULL DEFAULT 0,
  `users_marked_unsafe` INT(11) NOT NULL DEFAULT 0,
  `users_acknowledged` INT(11) NOT NULL DEFAULT 0,
  `last_updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`stat_id`),
  UNIQUE KEY `unique_alert_stat` (`alert_id`),
  KEY `idx_last_updated` (`last_updated`),
  CONSTRAINT `fk_stat_alert` FOREIGN KEY (`alert_id`) REFERENCES `alerts` (`alert_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Cached statistics for each alert to improve dashboard performance';

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- SAMPLE DATA FOR TESTING
-- =====================================================

-- Sample: Insert a test alert (assuming users table has data)
-- You can remove this section if you want a clean database
/*
INSERT INTO `alerts` (`alert_title`, `description`, `category`, `severity_level`, `affected_barangay`, `status`) VALUES
('Flash Flood Warning - Bucana River', 'Heavy rainfall causing rapid water level rise in Bucana River. Residents in low-lying areas advised to evacuate immediately.', 'flood', 'critical', 'Bucana', 'active');

-- Get the alert_id of the alert we just inserted
SET @last_alert_id = LAST_INSERT_ID();

-- Sample: Mark users as safe (replace user_id values with actual user IDs from your users table)
INSERT INTO `alert_safety_status` (`alert_id`, `user_id`, `status`, `location_details`) VALUES
(@last_alert_id, 1, 'safe', 'Evacuated to higher ground'),
(@last_alert_id, 2, 'safe', 'Already in safe zone'),
(@last_alert_id, 3, 'unsafe', 'Requesting assistance');

-- Sample: User acknowledgments
INSERT INTO `user_alert_acknowledgments` (`alert_id`, `user_id`) VALUES
(@last_alert_id, 1),
(@last_alert_id, 2),
(@last_alert_id, 3);

-- Sample: Initialize statistics
INSERT INTO `alert_statistics` (`alert_id`, `total_affected_users`, `users_marked_safe`, `users_marked_unsafe`, `users_acknowledged`) VALUES
(@last_alert_id, 3, 2, 1, 3);
*/

-- =====================================================
-- USEFUL QUERIES FOR YOUR APPLICATION
-- =====================================================

-- Query 1: Get all users who marked themselves safe for a specific alert
/*
SELECT 
    u.user_id,
    u.name,
    u.email,
    u.barangay,
    ass.status,
    ass.location_details,
    ass.updated_at
FROM alert_safety_status ass
JOIN users u ON ass.user_id = u.user_id
WHERE ass.alert_id = ? AND ass.status = 'safe'
ORDER BY ass.updated_at DESC;
*/

-- Query 2: Count safety status for an alert
/*
SELECT 
    status,
    COUNT(*) as count
FROM alert_safety_status
WHERE alert_id = ?
GROUP BY status;
*/

-- Query 3: Get unread notifications for a user
/*
SELECT 
    n.notification_id,
    n.message,
    n.priority,
    n.created_at,
    a.alert_title,
    a.severity_level
FROM user_notifications_enhanced n
LEFT JOIN alerts a ON n.alert_id = a.alert_id
WHERE n.user_id = ? AND n.is_read = 0
ORDER BY n.priority DESC, n.created_at DESC;
*/

-- Query 4: Get alert statistics with details
/*
SELECT 
    a.alert_id,
    a.alert_title,
    a.severity_level,
    a.affected_barangay,
    s.users_marked_safe,
    s.users_marked_unsafe,
    s.users_acknowledged,
    s.total_affected_users,
    ROUND((s.users_marked_safe / s.total_affected_users) * 100, 2) as percent_safe
FROM alerts a
LEFT JOIN alert_statistics s ON a.alert_id = s.alert_id
WHERE a.status = 'active'
ORDER BY a.date_issued DESC;
*/

-- =====================================================
-- TRIGGERS FOR AUTO-UPDATING STATISTICS (Optional but recommended)
-- =====================================================

DELIMITER $$

-- Trigger: Update statistics when safety status changes
DROP TRIGGER IF EXISTS `update_stats_on_safety_change`$$
CREATE TRIGGER `update_stats_on_safety_change`
AFTER INSERT ON `alert_safety_status`
FOR EACH ROW
BEGIN
    -- Update or insert statistics
    INSERT INTO alert_statistics (alert_id, total_affected_users, users_marked_safe, users_marked_unsafe)
    VALUES (
        NEW.alert_id,
        1,
        IF(NEW.status = 'safe', 1, 0),
        IF(NEW.status = 'unsafe', 1, 0)
    )
    ON DUPLICATE KEY UPDATE
        total_affected_users = total_affected_users + 1,
        users_marked_safe = users_marked_safe + IF(NEW.status = 'safe', 1, 0),
        users_marked_unsafe = users_marked_unsafe + IF(NEW.status = 'unsafe', 1, 0);
END$$

-- Trigger: Update statistics when safety status is updated
DROP TRIGGER IF EXISTS `update_stats_on_safety_update`$$
CREATE TRIGGER `update_stats_on_safety_update`
AFTER UPDATE ON `alert_safety_status`
FOR EACH ROW
BEGIN
    DECLARE old_safe INT DEFAULT 0;
    DECLARE old_unsafe INT DEFAULT 0;
    DECLARE new_safe INT DEFAULT 0;
    DECLARE new_unsafe INT DEFAULT 0;
    
    SET old_safe = IF(OLD.status = 'safe', 1, 0);
    SET old_unsafe = IF(OLD.status = 'unsafe', 1, 0);
    SET new_safe = IF(NEW.status = 'safe', 1, 0);
    SET new_unsafe = IF(NEW.status = 'unsafe', 1, 0);
    
    UPDATE alert_statistics
    SET 
        users_marked_safe = users_marked_safe - old_safe + new_safe,
        users_marked_unsafe = users_marked_unsafe - old_unsafe + new_unsafe
    WHERE alert_id = NEW.alert_id;
END$$

-- Trigger: Update acknowledgment count
DROP TRIGGER IF EXISTS `update_stats_on_ack`$$
CREATE TRIGGER `update_stats_on_ack`
AFTER INSERT ON `user_alert_acknowledgments`
FOR EACH ROW
BEGIN
    UPDATE alert_statistics
    SET users_acknowledged = users_acknowledged + 1
    WHERE alert_id = NEW.alert_id;
END$$

DELIMITER ;

-- =====================================================
-- END OF SCHEMA
-- =====================================================

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
