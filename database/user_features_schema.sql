-- =====================================================
-- SafeMati User Features - Database Schema
-- =====================================================
-- This adds user-specific features to the SafeMati system:
-- - Bookmarked guides
-- - Favorite hotlines
-- - User notifications
-- - Feedback submissions
-- - User settings/preferences
-- =====================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+08:00";
SET FOREIGN_KEY_CHECKS = 0;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- =====================================================
-- 1. USER BOOKMARKED GUIDES
-- Tracks which disaster guides users have bookmarked
-- =====================================================
DROP TABLE IF EXISTS `user_bookmarked_guides`;

CREATE TABLE `user_bookmarked_guides` (
  `bookmark_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `guide_id` INT(11) UNSIGNED NOT NULL,
  `bookmarked_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`bookmark_id`),
  UNIQUE KEY `unique_user_guide` (`user_id`, `guide_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_guide_id` (`guide_id`),
  CONSTRAINT `fk_bookmark_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bookmark_guide` FOREIGN KEY (`guide_id`) REFERENCES `disaster_guides` (`guide_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Stores user bookmarked disaster guides';

-- =====================================================
-- 2. USER FAVORITE HOTLINES
-- Tracks which emergency hotlines users have marked as favorites
-- =====================================================
DROP TABLE IF EXISTS `user_favorite_hotlines`;

CREATE TABLE `user_favorite_hotlines` (
  `favorite_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `hotline_id` INT(11) UNSIGNED NOT NULL,
  `favorited_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`favorite_id`),
  UNIQUE KEY `unique_user_hotline` (`user_id`, `hotline_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_hotline_id` (`hotline_id`),
  CONSTRAINT `fk_favorite_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_favorite_hotline` FOREIGN KEY (`hotline_id`) REFERENCES `hotlines` (`hotline_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Stores user favorite emergency hotlines';

-- =====================================================
-- 3. USER GUIDE PROGRESS
-- Tracks completion status of disaster guides
-- =====================================================
DROP TABLE IF EXISTS `user_guide_progress`;

CREATE TABLE `user_guide_progress` (
  `progress_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `guide_id` INT(11) UNSIGNED NOT NULL,
  `is_completed` TINYINT(1) NOT NULL DEFAULT 0,
  `completed_at` TIMESTAMP NULL DEFAULT NULL,
  `last_viewed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`progress_id`),
  UNIQUE KEY `unique_user_guide_progress` (`user_id`, `guide_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_guide_id` (`guide_id`),
  KEY `idx_completed` (`is_completed`),
  CONSTRAINT `fk_progress_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_progress_guide` FOREIGN KEY (`guide_id`) REFERENCES `disaster_guides` (`guide_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Tracks user progress through disaster guides';

-- =====================================================
-- 4. USER FEEDBACK SUBMISSIONS
-- Stores user feedback, suggestions, and bug reports
-- =====================================================
DROP TABLE IF EXISTS `user_feedback`;

CREATE TABLE `user_feedback` (
  `feedback_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `feedback_type` ENUM('suggestion', 'bug', 'general', 'complaint', 'praise') NOT NULL DEFAULT 'general',
  `subject` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  `rating` TINYINT(1) DEFAULT NULL COMMENT 'Rating from 1-5 stars',
  `allow_contact` TINYINT(1) NOT NULL DEFAULT 0,
  `status` ENUM('new', 'in_review', 'resolved', 'archived') NOT NULL DEFAULT 'new',
  `admin_response` TEXT DEFAULT NULL,
  `submitted_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`feedback_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_type` (`feedback_type`),
  KEY `idx_status` (`status`),
  KEY `idx_submitted_at` (`submitted_at`),
  CONSTRAINT `fk_feedback_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Stores user feedback and suggestions';

-- =====================================================
-- 5. USER SETTINGS/PREFERENCES
-- Stores user account preferences and settings
-- =====================================================
DROP TABLE IF EXISTS `user_settings`;

CREATE TABLE `user_settings` (
  `setting_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `setting_key` VARCHAR(100) NOT NULL,
  `setting_value` TEXT NOT NULL,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`setting_id`),
  UNIQUE KEY `unique_user_setting` (`user_id`, `setting_key`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_setting_key` (`setting_key`),
  CONSTRAINT `fk_settings_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Stores user preferences and settings';

-- =====================================================
-- 6. ENHANCED USER NOTIFICATIONS
-- (This is an enhanced version of user_notifications)
-- =====================================================
DROP TABLE IF EXISTS `user_notifications`;

CREATE TABLE `user_notifications` (
  `notification_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `alert_id` INT(11) UNSIGNED DEFAULT NULL,
  `notification_type` ENUM('alert', 'weather', 'safety', 'system', 'announcement') NOT NULL DEFAULT 'system',
  `title` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  `icon` VARCHAR(50) DEFAULT 'fa-bell',
  `color` VARCHAR(20) DEFAULT 'red',
  `link_url` VARCHAR(255) DEFAULT NULL,
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `read_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`notification_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_alert_id` (`alert_id`),
  KEY `idx_is_read` (`is_read`),
  KEY `idx_type` (`notification_type`),
  KEY `idx_created_at` (`created_at`),
  CONSTRAINT `fk_notification_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_notification_alert` FOREIGN KEY (`alert_id`) REFERENCES `alerts` (`alert_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='User notifications with enhanced features';

-- =====================================================
-- 7. USER LOGIN HISTORY
-- Tracks user login activity for security
-- =====================================================
DROP TABLE IF EXISTS `user_login_history`;

CREATE TABLE `user_login_history` (
  `login_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `login_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `user_agent` VARCHAR(255) DEFAULT NULL,
  `login_status` ENUM('success', 'failed') NOT NULL DEFAULT 'success',
  PRIMARY KEY (`login_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_login_time` (`login_time`),
  CONSTRAINT `fk_login_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Tracks user login history for security';

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- SAMPLE DATA
-- =====================================================

-- Insert default settings for existing users
INSERT INTO `user_settings` (`user_id`, `setting_key`, `setting_value`)
SELECT user_id, 'notifications_push', '1' FROM users
UNION ALL
SELECT user_id, 'notifications_email', '1' FROM users
UNION ALL
SELECT user_id, 'notifications_sms', '0' FROM users
UNION ALL
SELECT user_id, 'public_profile', '0' FROM users
UNION ALL
SELECT user_id, 'show_location', '1' FROM users
UNION ALL
SELECT user_id, 'activity_status', '1' FROM users;

-- =====================================================
-- USEFUL QUERIES
-- =====================================================

-- Get user's bookmarked guides
/*
SELECT g.*, b.bookmarked_at
FROM user_bookmarked_guides b
JOIN disaster_guides g ON b.guide_id = g.guide_id
WHERE b.user_id = ?
ORDER BY b.bookmarked_at DESC;
*/

-- Get user's favorite hotlines
/*
SELECT h.*, f.favorited_at
FROM user_favorite_hotlines f
JOIN hotlines h ON f.hotline_id = h.hotline_id
WHERE f.user_id = ?
ORDER BY f.favorited_at DESC;
*/

-- Get user's guide completion progress
/*
SELECT 
    COUNT(*) as total_guides,
    SUM(CASE WHEN p.is_completed = 1 THEN 1 ELSE 0 END) as completed_guides,
    ROUND((SUM(CASE WHEN p.is_completed = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as completion_percentage
FROM disaster_guides g
LEFT JOIN user_guide_progress p ON g.guide_id = p.guide_id AND p.user_id = ?;
*/

-- Get unread notifications for user
/*
SELECT *
FROM user_notifications
WHERE user_id = ? AND is_read = 0
ORDER BY created_at DESC;
*/

-- Get user settings
/*
SELECT setting_key, setting_value
FROM user_settings
WHERE user_id = ?;
*/

-- Get recent login history
/*
SELECT *
FROM user_login_history
WHERE user_id = ?
ORDER BY login_time DESC
LIMIT 10;
*/

-- =====================================================
-- END OF SCHEMA
-- =====================================================

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
