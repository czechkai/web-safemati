-- Database Schema Update: Add Profile Picture Column
-- Execute this SQL if the profile_picture column doesn't exist in the users table

-- Add profile_picture column to users table
ALTER TABLE `users` 
ADD COLUMN `profile_picture` VARCHAR(255) NULL DEFAULT NULL AFTER `phone_number`;

-- Create uploads directory structure (Note: This needs to be done manually in filesystem)
-- Create: safemati/uploads/profiles/ with write permissions

-- Sample update to test
-- UPDATE users SET profile_picture = 'uploads/profiles/profile_1_1234567890.jpg' WHERE user_id = 1;
