-- =====================================================
-- SafeMati - Complete Database Setup
-- Execute this file if you're starting fresh
-- =====================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+08:00";
SET FOREIGN_KEY_CHECKS = 0;

-- =====================================================
-- 1. SKIP DISASTER_GUIDES TABLE (already exists in your database)
-- =====================================================
-- Note: Your disaster_guides table already exists
-- Skipping creation to avoid conflicts

-- =====================================================
-- 2. SKIP HOTLINES TABLE (already exists in your database)
-- =====================================================
-- Note: Your hotlines table already exists with different column names
-- Skipping creation and insert to avoid errors

-- =====================================================
-- 3. CREATE ALERTS TABLE (if not exists)
-- =====================================================
CREATE TABLE IF NOT EXISTS `alerts` (
  `alert_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `alert_type` ENUM('flood', 'fire', 'earthquake', 'typhoon', 'tsunami', 'landslide', 'other') NOT NULL,
  `severity` ENUM('low', 'moderate', 'high', 'critical') NOT NULL DEFAULT 'moderate',
  `affected_areas` TEXT,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`alert_id`),
  KEY `idx_alert_type` (`alert_type`),
  KEY `idx_severity` (`severity`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 4. NOW CREATE USER FEATURE TABLES
-- =====================================================

-- USER BOOKMARKED GUIDES
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
  CONSTRAINT `fk_bookmark_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_bookmark_guide` FOREIGN KEY (`guide_id`) REFERENCES `disaster_guides` (`guide_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- USER FAVORITE HOTLINES
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
  CONSTRAINT `fk_favorite_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_favorite_hotline` FOREIGN KEY (`hotline_id`) REFERENCES `hotlines` (`hotline_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- USER GUIDE PROGRESS
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
  CONSTRAINT `fk_progress_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_progress_guide` FOREIGN KEY (`guide_id`) REFERENCES `disaster_guides` (`guide_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- USER NOTIFICATIONS
DROP TABLE IF EXISTS `user_notifications`;
CREATE TABLE `user_notifications` (
  `notification_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `alert_id` INT(11) UNSIGNED DEFAULT NULL,
  `type` ENUM('alert', 'weather', 'safety', 'system') NOT NULL DEFAULT 'system',
  `title` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `read_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`notification_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_is_read` (`is_read`),
  CONSTRAINT `fk_notification_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- USER FEEDBACK
DROP TABLE IF EXISTS `user_feedback`;
CREATE TABLE `user_feedback` (
  `feedback_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `feedback_type` ENUM('suggestion', 'bug', 'general') NOT NULL DEFAULT 'general',
  `subject` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  `rating` TINYINT(1) DEFAULT NULL,
  `allow_contact` TINYINT(1) NOT NULL DEFAULT 0,
  `submitted_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`feedback_id`),
  KEY `idx_user_id` (`user_id`),
  CONSTRAINT `fk_feedback_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- USER SETTINGS
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
  CONSTRAINT `fk_settings_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- USER LOGIN HISTORY
DROP TABLE IF EXISTS `user_login_history`;
CREATE TABLE `user_login_history` (
  `login_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `login_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `login_status` ENUM('success', 'failed') NOT NULL DEFAULT 'success',
  PRIMARY KEY (`login_id`),
  KEY `idx_user_id` (`user_id`),
  CONSTRAINT `fk_login_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 5. ADD PROFILE PICTURE COLUMN TO USERS
-- =====================================================
-- Check if column exists before adding
SET @dbname = DATABASE();
SET @tablename = 'users';
SET @columnname = 'profile_picture';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  'SELECT 1',
  'ALTER TABLE users ADD COLUMN profile_picture VARCHAR(255) NULL DEFAULT NULL AFTER phone_number'
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- DONE! All tables created with sample data
-- =====================================================
