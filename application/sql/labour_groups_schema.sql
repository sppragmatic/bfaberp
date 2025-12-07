-- Labour Groups Module Database Schema
-- Table: labour_groups

CREATE TABLE IF NOT EXISTS `labour_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(100) DEFAULT 'System',
  `updated_by` varchar(100) DEFAULT 'System',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_labour_groups_name` (`name`),
  KEY `idx_labour_groups_name` (`name`),
  KEY `idx_labour_groups_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample data for testing
INSERT INTO `labour_groups` (`name`, `description`, `created_at`, `updated_at`, `created_by`) VALUES
('Skilled Workers', 'Highly skilled and experienced workers with specialized training', NOW(), NOW(), 'Admin'),
('Semi-Skilled Workers', 'Workers with moderate level of skills and some training', NOW(), NOW(), 'Admin'),
('Unskilled Workers', 'General laborers without specialized skills or training', NOW(), NOW(), 'Admin'),
('Supervisors', 'Team leaders and supervisory staff overseeing work operations', NOW(), NOW(), 'Admin'),
('Technicians', 'Technical staff responsible for equipment and machinery operations', NOW(), NOW(), 'Admin');

-- Add foreign key constraints (if users table exists)
-- ALTER TABLE `labour_groups` 
-- ADD CONSTRAINT `fk_labour_groups_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
-- ADD CONSTRAINT `fk_labour_groups_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;