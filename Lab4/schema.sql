-- ==========================================================
-- EduPortal Management System - Database Initialization
-- ==========================================================

-- 1. Create the database with a custom name
CREATE DATABASE IF NOT EXISTS `eduportal_db` 
  CHARACTER SET utf8mb4 
  COLLATE utf8mb4_unicode_ci;

USE `eduportal_db`;

-- 2. Construct the primary student records table
CREATE TABLE IF NOT EXISTS `students` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(120) NOT NULL,
  `last_name` VARCHAR(120) NOT NULL,
  `email` VARCHAR(180) NOT NULL,
  `dob` DATE DEFAULT NULL,
  `course` VARCHAR(200) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_unique_student_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;