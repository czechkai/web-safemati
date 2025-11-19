-- =====================================================
-- SafeMati Disaster Management System
-- Database Schema
-- =====================================================
-- Run this entire file in phpMyAdmin to create all tables
-- Make sure you have selected your database first
-- =====================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+08:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- =====================================================
-- 1. USERS TABLE
-- =====================================================
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'user', 'responder') NOT NULL DEFAULT 'user',
  `barangay` VARCHAR(100) NOT NULL,
  `phone_number` VARCHAR(20) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` ENUM('active', 'inactive', 'suspended') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `unique_email` (`email`),
  KEY `idx_barangay` (`barangay`),
  KEY `idx_role` (`role`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 2. ALERTS TABLE
-- =====================================================
CREATE TABLE IF NOT EXISTS `alerts` (
  `alert_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alert_title` VARCHAR(200) NOT NULL,
  `description` TEXT NOT NULL,
  `category` ENUM('flood', 'fire', 'earthquake', 'typhoon', 'landslide', 'tsunami', 'volcanic', 'health', 'security', 'other') NOT NULL,
  `severity_level` ENUM('low', 'moderate', 'high', 'critical') NOT NULL DEFAULT 'moderate',
  `affected_barangay` VARCHAR(100) NOT NULL,
  `date_issued` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_expires` DATETIME DEFAULT NULL,
  `status` ENUM('active', 'inactive', 'expired', 'resolved') NOT NULL DEFAULT 'active',
  `issued_by` INT(11) UNSIGNED DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`alert_id`),
  KEY `idx_category` (`category`),
  KEY `idx_severity` (`severity_level`),
  KEY `idx_barangay` (`affected_barangay`),
  KEY `idx_status` (`status`),
  KEY `idx_date_issued` (`date_issued`),
  KEY `idx_issued_by` (`issued_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 3. USER NOTIFICATIONS TABLE
-- =====================================================
CREATE TABLE IF NOT EXISTS `user_notifications` (
  `notification_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `alert_id` INT(11) UNSIGNED DEFAULT NULL,
  `message` TEXT NOT NULL,
  `read_status` ENUM('unread', 'read') NOT NULL DEFAULT 'unread',
  `notification_type` ENUM('alert', 'system', 'reminder', 'update') NOT NULL DEFAULT 'alert',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`notification_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_alert_id` (`alert_id`),
  KEY `idx_read_status` (`read_status`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 4. HOTLINES TABLE
-- =====================================================
CREATE TABLE IF NOT EXISTS `hotlines` (
  `hotline_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `office_name` VARCHAR(150) NOT NULL,
  `contact_number` VARCHAR(50) NOT NULL,
  `category` ENUM('police', 'fire', 'rescue', 'medical', 'lgu', 'emergency', 'utility', 'other') NOT NULL,
  `barangay` VARCHAR(100) DEFAULT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `available_24_7` TINYINT(1) NOT NULL DEFAULT 1,
  `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
  `display_order` INT(11) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`hotline_id`),
  KEY `idx_category` (`category`),
  KEY `idx_status` (`status`),
  KEY `idx_display_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 5. DISASTER GUIDES TABLE
-- =====================================================
CREATE TABLE IF NOT EXISTS `disaster_guides` (
  `guide_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(200) NOT NULL,
  `type` ENUM('fire', 'earthquake', 'flood', 'typhoon', 'landslide', 'tsunami', 'volcanic', 'general', 'first_aid', 'other') NOT NULL,
  `description` TEXT NOT NULL,
  `content` LONGTEXT DEFAULT NULL,
  `file_link` VARCHAR(255) DEFAULT NULL,
  `thumbnail` VARCHAR(255) DEFAULT NULL,
  `author` VARCHAR(100) DEFAULT NULL,
  `views` INT(11) NOT NULL DEFAULT 0,
  `status` ENUM('active', 'inactive', 'draft') NOT NULL DEFAULT 'active',
  `display_order` INT(11) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`guide_id`),
  KEY `idx_type` (`type`),
  KEY `idx_status` (`status`),
  KEY `idx_display_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 6. SAFETY TIPS TABLE
-- =====================================================
CREATE TABLE IF NOT EXISTS `safety_tips` (
  `tip_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tip_content` TEXT NOT NULL,
  `category` ENUM('fire', 'earthquake', 'flood', 'typhoon', 'landslide', 'health', 'general', 'evacuation', 'first_aid', 'preparation') NOT NULL,
  `priority` ENUM('low', 'medium', 'high') NOT NULL DEFAULT 'medium',
  `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
  `display_order` INT(11) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tip_id`),
  KEY `idx_category` (`category`),
  KEY `idx_status` (`status`),
  KEY `idx_priority` (`priority`),
  KEY `idx_display_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 7. EVACUATION CENTERS TABLE
-- =====================================================
CREATE TABLE IF NOT EXISTS `evacuation_centers` (
  `center_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NOT NULL,
  `barangay` VARCHAR(100) NOT NULL,
  `address` TEXT NOT NULL,
  `capacity` INT(11) NOT NULL DEFAULT 0,
  `current_occupancy` INT(11) NOT NULL DEFAULT 0,
  `status` ENUM('open', 'closed', 'full', 'maintenance') NOT NULL DEFAULT 'closed',
  `contact_person` VARCHAR(100) DEFAULT NULL,
  `contact_number` VARCHAR(50) DEFAULT NULL,
  `facilities` TEXT DEFAULT NULL,
  `latitude` DECIMAL(10, 8) DEFAULT NULL,
  `longitude` DECIMAL(11, 8) DEFAULT NULL,
  `notes` TEXT DEFAULT NULL,
  `last_updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`center_id`),
  KEY `idx_barangay` (`barangay`),
  KEY `idx_status` (`status`),
  KEY `idx_capacity` (`capacity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 8. WEATHER TABLE (Optional Dashboard Data)
-- =====================================================
CREATE TABLE IF NOT EXISTS `weather` (
  `weather_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `location` VARCHAR(100) NOT NULL DEFAULT 'General',
  `temperature` DECIMAL(5, 2) DEFAULT NULL,
  `condition` VARCHAR(100) DEFAULT NULL,
  `humidity` INT(11) DEFAULT NULL,
  `wind_speed` DECIMAL(5, 2) DEFAULT NULL,
  `wind_direction` VARCHAR(20) DEFAULT NULL,
  `rainfall` DECIMAL(5, 2) DEFAULT NULL,
  `pressure` DECIMAL(6, 2) DEFAULT NULL,
  `forecast` TEXT DEFAULT NULL,
  `alert_level` ENUM('none', 'advisory', 'watch', 'warning') NOT NULL DEFAULT 'none',
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`weather_id`),
  KEY `idx_location` (`location`),
  KEY `idx_updated_at` (`updated_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 9. INCIDENT REPORTS TABLE (Bonus - for user submissions)
-- =====================================================
CREATE TABLE IF NOT EXISTS `incident_reports` (
  `report_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED DEFAULT NULL,
  `incident_type` ENUM('flood', 'fire', 'earthquake', 'accident', 'crime', 'medical', 'other') NOT NULL,
  `description` TEXT NOT NULL,
  `location` VARCHAR(200) NOT NULL,
  `barangay` VARCHAR(100) NOT NULL,
  `latitude` DECIMAL(10, 8) DEFAULT NULL,
  `longitude` DECIMAL(11, 8) DEFAULT NULL,
  `image_path` VARCHAR(255) DEFAULT NULL,
  `severity` ENUM('minor', 'moderate', 'serious', 'critical') NOT NULL DEFAULT 'moderate',
  `status` ENUM('pending', 'verified', 'responded', 'resolved', 'false_alarm') NOT NULL DEFAULT 'pending',
  `responder_notes` TEXT DEFAULT NULL,
  `responded_by` INT(11) UNSIGNED DEFAULT NULL,
  `responded_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`report_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_incident_type` (`incident_type`),
  KEY `idx_barangay` (`barangay`),
  KEY `idx_status` (`status`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_responded_by` (`responded_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 10. SYSTEM LOGS TABLE (Optional - for audit trail)
-- =====================================================
CREATE TABLE IF NOT EXISTS `system_logs` (
  `log_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED DEFAULT NULL,
  `action` VARCHAR(100) NOT NULL,
  `table_name` VARCHAR(50) DEFAULT NULL,
  `record_id` INT(11) DEFAULT NULL,
  `details` TEXT DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `user_agent` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_action` (`action`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- FOREIGN KEY CONSTRAINTS
-- =====================================================
-- NOTE: If you get errors, comment out this section and use safemati_schema_clean.sql instead
-- These will only work if tables exist and have no existing constraints

-- ALTER TABLE `alerts`
--   ADD CONSTRAINT `fk_alert_issued_by` FOREIGN KEY (`issued_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- ALTER TABLE `user_notifications`
--   ADD CONSTRAINT `fk_notification_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
--   ADD CONSTRAINT `fk_notification_alert` FOREIGN KEY (`alert_id`) REFERENCES `alerts` (`alert_id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- ALTER TABLE `incident_reports`
--   ADD CONSTRAINT `fk_incident_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
--   ADD CONSTRAINT `fk_incident_responder` FOREIGN KEY (`responded_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- ALTER TABLE `system_logs`
--   ADD CONSTRAINT `fk_log_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- =====================================================
-- SAMPLE DATA INSERTION (Optional - Remove if not needed)
-- =====================================================

-- Sample Hotlines
INSERT INTO `hotlines` (`office_name`, `contact_number`, `category`, `available_24_7`, `display_order`) VALUES
('National Emergency Hotline', '911', 'emergency', 1, 1),
('Bureau of Fire Protection', '(02) 426-0219', 'fire', 1, 2),
('Philippine National Police', '117', 'police', 1, 3),
('NDRRMC Hotline', '(02) 911-5061', 'emergency', 1, 4),
('Red Cross Emergency', '143', 'medical', 1, 5),
('PAGASA Weather Bureau', '(02) 8927-1335', 'emergency', 1, 6),
('Coast Guard', '(02) 8527-8481', 'rescue', 1, 7);

-- Sample Safety Tips
INSERT INTO `safety_tips` (`tip_content`, `category`, `priority`, `display_order`) VALUES
('Drop, Cover, and Hold On during earthquakes. Get under sturdy furniture and protect your head.', 'earthquake', 'high', 1),
('Prepare a go-bag with essentials: water, food, first aid kit, flashlight, and important documents.', 'preparation', 'high', 2),
('During floods, move to higher ground immediately. Never walk or drive through flowing water.', 'flood', 'high', 3),
('Keep fire extinguishers accessible and learn how to use them properly.', 'fire', 'medium', 4),
('Create a family emergency plan and establish meeting points.', 'general', 'medium', 5),
('Stay indoors during typhoons. Secure loose objects and stay away from windows.', 'typhoon', 'high', 6),
('Know the location of your nearest evacuation center.', 'evacuation', 'medium', 7),
('Keep emergency contact numbers saved in your phone and written down.', 'general', 'medium', 8);

-- Sample Disaster Guides
INSERT INTO `disaster_guides` (`title`, `type`, `description`, `display_order`) VALUES
('Earthquake Preparedness Guide', 'earthquake', 'Comprehensive guide on what to do before, during, and after an earthquake. Includes building safety, emergency kit preparation, and post-earthquake procedures.', 1),
('Flood Safety Manual', 'flood', 'Essential information about flood preparedness, evacuation procedures, and water safety during flood events.', 2),
('Fire Prevention and Response', 'fire', 'Learn how to prevent fires, use fire extinguishers, and evacuate safely during fire emergencies.', 3),
('Typhoon Preparation Guide', 'typhoon', 'Complete guide to preparing your home and family for typhoon season, including supply checklist and safety protocols.', 4),
('First Aid Basics', 'first_aid', 'Basic first aid procedures for common emergencies including CPR, wound care, and treating shock.', 5),
('General Emergency Preparedness', 'general', 'Overall disaster preparedness covering multiple scenarios, family planning, and emergency communications.', 6);

-- Sample Weather Entry (you would update this via API or admin panel)
INSERT INTO `weather` (`location`, `temperature`, `condition`, `humidity`, `wind_speed`, `alert_level`) VALUES
('General Area', 28.5, 'Partly Cloudy', 75, 15.2, 'none');

-- =====================================================
-- END OF SCHEMA
-- =====================================================

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
