-- User Reported Incidents/Emergencies Table
CREATE TABLE IF NOT EXISTS `user_reports` (
  `report_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `incident_type` ENUM('fire', 'flood', 'accident', 'earthquake', 'landslide', 'medical', 'crime', 'other') NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `location` VARCHAR(255) NOT NULL,
  `barangay` VARCHAR(100) NOT NULL,
  `latitude` DECIMAL(10, 8) NULL,
  `longitude` DECIMAL(11, 8) NULL,
  `photo_path` VARCHAR(255) NULL,
  `status` ENUM('pending', 'accepted', 'rejected') NOT NULL DEFAULT 'pending',
  `admin_notes` TEXT NULL,
  `priority` ENUM('low', 'medium', 'high', 'critical') NOT NULL DEFAULT 'medium',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`report_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_status` (`status`),
  KEY `idx_incident_type` (`incident_type`),
  KEY `idx_created_at` (`created_at`),
  CONSTRAINT `fk_report_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Admin Notifications for User Reports
CREATE TABLE IF NOT EXISTS `admin_notifications` (
  `notification_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `report_id` INT(11) UNSIGNED NOT NULL,
  `type` ENUM('new_report', 'update_report') NOT NULL DEFAULT 'new_report',
  `message` TEXT NOT NULL,
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`notification_id`),
  KEY `idx_report_id` (`report_id`),
  KEY `idx_is_read` (`is_read`),
  CONSTRAINT `fk_admin_notif_report` FOREIGN KEY (`report_id`) REFERENCES `user_reports` (`report_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
