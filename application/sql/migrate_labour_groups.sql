-- Migration script to update existing labour_groups table
-- Run this if you already have the table with user ID references

-- First, drop foreign key constraints if they exist
ALTER TABLE `labour_groups` DROP FOREIGN KEY IF EXISTS `fk_labour_groups_created_by`;
ALTER TABLE `labour_groups` DROP FOREIGN KEY IF EXISTS `fk_labour_groups_updated_by`;

-- Change created_by and updated_by columns to VARCHAR
ALTER TABLE `labour_groups` 
MODIFY COLUMN `created_by` varchar(100) DEFAULT 'System',
MODIFY COLUMN `updated_by` varchar(100) DEFAULT 'System';

-- Update existing data to use 'Admin' instead of user IDs
UPDATE `labour_groups` SET 
`created_by` = 'Admin' 
WHERE `created_by` IS NOT NULL AND `created_by` != '';

UPDATE `labour_groups` SET 
`updated_by` = 'Admin' 
WHERE `updated_by` IS NOT NULL AND `updated_by` != '';

-- Drop unnecessary indexes
ALTER TABLE `labour_groups` DROP INDEX IF EXISTS `idx_labour_groups_created_by`;
ALTER TABLE `labour_groups` DROP INDEX IF EXISTS `idx_labour_groups_updated_by`;

-- Ensure we have the right indexes
ALTER TABLE `labour_groups` ADD INDEX `idx_labour_groups_created_at` (`created_at`);

COMMIT;