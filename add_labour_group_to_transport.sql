-- SQL script to add labour_group_id column to transport table
-- This adds support for labour groups in Bricks Loading Details section

-- Add labour_group_id column to transport table
ALTER TABLE `transport` 
ADD COLUMN `labour_group_id` int(11) DEFAULT NULL COMMENT 'Foreign key to labour_groups table' 
AFTER `product_id`;

-- Add foreign key constraint (optional - only if labour_groups table exists)
-- ALTER TABLE `transport` 
-- ADD CONSTRAINT `fk_transport_labour_group` 
-- FOREIGN KEY (`labour_group_id`) REFERENCES `labour_groups` (`id`) 
-- ON DELETE SET NULL ON UPDATE CASCADE;

-- Add index for better performance
ALTER TABLE `transport` 
ADD INDEX `idx_labour_group_id` (`labour_group_id`);

-- Update table comment to reflect the change
ALTER TABLE `transport` 
COMMENT = 'Stores loading and transport details for production with labour group support';