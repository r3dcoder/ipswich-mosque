-- MySQL Table Creation Script for Ipswich Mosque Website
-- Tables: people, contacts

-- Create people table
CREATE TABLE `people` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `image_url` VARCHAR(255) NULL,
    `phone` VARCHAR(20) NULL,
    `email` VARCHAR(255) NULL,
    `role` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `people_role_index` (`role`),
    INDEX `people_name_index` (`name`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Create contacts table
CREATE TABLE `contacts` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `message` TEXT NOT NULL,
    `phone` VARCHAR(20) NULL,
    `contact_method` ENUM('email', 'phone', 'any') NOT NULL DEFAULT 'any',
    `read` TINYINT(1) NOT NULL DEFAULT '0',
    `read_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `contacts_read_created_at_index` (`read`, `created_at`),
    INDEX `contacts_email_index` (`email`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Insert sample data for people table
INSERT INTO `people` (`name`, `image_url`, `phone`, `email`, `role`, `created_at`, `updated_at`) VALUES
('Imam Ahmed Hassan', '/images/imam-ahmed.jpg', '+44 123 456 7890', 'imam@ipswichmosque.org', 'Imam', NOW(), NOW()),
('Sarah Johnson', '/images/sarah-johnson.jpg', '+44 123 456 7891', 'sarah@ipswichmosque.org', 'Administrator', NOW(), NOW()),
('Mohammed Ali', '/images/mohammed-ali.jpg', '+44 123 456 7892', 'mohammed@ipswichmosque.org', 'Teacher', NOW(), NOW()),
('Fatima Ahmed', '/images/fatima-ahmed.jpg', '+44 123 456 7893', 'fatima@ipswichmosque.org', 'Volunteer Coordinator', NOW(), NOW()),
('John Smith', '/images/john-smith.jpg', '+44 123 456 7894', 'john@ipswichmosque.org', 'Facilities Manager', NOW(), NOW());

-- Insert sample data for contacts table
INSERT INTO `contacts` (`name`, `email`, `subject`, `message`, `phone`, `contact_method`, `read`, `read_at`, `created_at`, `updated_at`) VALUES
('Test User 1', 'test1@example.com', 'General Inquiry', 'Hello, I would like to know more about your services.', '+44 123 456 7895', 'email', 0, NULL, NOW(), NOW()),
('Test User 2', 'test2@example.com', 'Prayer Times', 'Can you please provide the current prayer times?', '+44 123 456 7896', 'phone', 1, NOW(), NOW(), NOW()),
('Test User 3', 'test3@example.com', 'Event Information', 'I am interested in attending your upcoming events.', '+44 123 456 7897', 'any', 0, NULL, NOW(), NOW());

-- Add foreign key constraints if needed (optional)
-- ALTER TABLE `contacts` ADD CONSTRAINT `contacts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE;

-- Set auto increment starting values
ALTER TABLE `people` AUTO_INCREMENT = 1000;
ALTER TABLE `contacts` AUTO_INCREMENT = 2000;