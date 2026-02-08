-- ========================================
-- Production Loading and Unloading Tables
-- ========================================
-- 
-- This script creates two tables:
-- 1. transport - for storing loading details with production_id
-- 2. fly_ash_unloading - for storing unloading details with production_id
--
-- Run this script in phpMyAdmin or MySQL command line
-- ========================================

-- Drop tables if they exist (optional - remove these lines if you want to keep existing data)
-- DROP TABLE IF EXISTS `transport`;
-- DROP TABLE IF EXISTS `fly_ash_unloading`;

-- ========================================
-- TRANSPORT TABLE (Loading Details)
-- ========================================
CREATE TABLE IF NOT EXISTS `transport` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `production_id` int(11) NOT NULL COMMENT 'Foreign key to production table',
  `product_id` int(11) NOT NULL COMMENT 'Foreign key to product table',
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Loading quantity',
  `rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Rate per unit',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Total amount (quantity * rate)',
  `type` enum('loading','transport') NOT NULL DEFAULT 'loading' COMMENT 'Type of transport entry',
  `branch_id` int(11) NOT NULL COMMENT 'Branch ID for multi-branch system',
  `year_id` int(11) NOT NULL COMMENT 'Year ID for financial year tracking',
  `entry_by` varchar(100) DEFAULT NULL COMMENT 'User who created this record',
  `entry_date` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'When record was created',
  `updated_by` varchar(100) DEFAULT NULL COMMENT 'User who last updated this record',
  `updated_at` datetime DEFAULT NULL COMMENT 'When record was last updated',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Soft delete flag (0=active, 1=deleted)',
  PRIMARY KEY (`id`),
  KEY `idx_production_id` (`production_id`),
  KEY `idx_product_id` (`product_id`),
  KEY `idx_branch_year` (`branch_id`, `year_id`),
  KEY `idx_type` (`type`),
  KEY `idx_is_deleted` (`is_deleted`),
  KEY `idx_entry_date` (`entry_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Stores loading and transport details for production';

-- ========================================
-- FLY ASH UNLOADING TABLE (Unloading Details)  
-- ========================================
CREATE TABLE IF NOT EXISTS `fly_ash_unloading` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `production_id` int(11) NOT NULL COMMENT 'Foreign key to production table',
  `material_id` int(11) NOT NULL COMMENT 'Foreign key to material table',
  `labour_group_id` int(11) NOT NULL COMMENT 'Foreign key to labour_groups table',
  `qty` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Unloading quantity',
  `rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Rate per unit',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Total amount (qty * rate)',
  `branch_id` int(11) NOT NULL COMMENT 'Branch ID for multi-branch system',
  `year_id` int(11) NOT NULL COMMENT 'Year ID for financial year tracking',
  `entry_by` varchar(100) DEFAULT NULL COMMENT 'User who created this record',
  `entry_date` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'When record was created',
  `updated_by` varchar(100) DEFAULT NULL COMMENT 'User who last updated this record',
  `updated_at` datetime DEFAULT NULL COMMENT 'When record was last updated',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Soft delete flag (0=active, 1=deleted)',
  PRIMARY KEY (`id`),
  KEY `idx_production_id` (`production_id`),
  KEY `idx_material_id` (`material_id`),
  KEY `idx_labour_group_id` (`labour_group_id`),
  KEY `idx_branch_year` (`branch_id`, `year_id`),
  KEY `idx_is_deleted` (`is_deleted`),
  KEY `idx_entry_date` (`entry_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Stores fly ash unloading details for production';

-- ========================================
-- INSERT SAMPLE DATA (Optional - for testing)
-- ========================================

-- Sample loading data (assuming production_id=1 exists)
-- INSERT INTO `transport` (`production_id`, `product_id`, `quantity`, `rate`, `amount`, `type`, `branch_id`, `year_id`, `entry_by`) 
-- VALUES 
-- (1, 1, 100.00, 15.50, 1550.00, 'loading', 1, 1, 'admin'),
-- (1, 2, 50.00, 20.00, 1000.00, 'loading', 1, 1, 'admin');

-- Sample unloading data (assuming production_id=1, material_id=1, labour_group_id=1 exist)
-- INSERT INTO `fly_ash_unloading` (`production_id`, `material_id`, `labour_group_id`, `qty`, `rate`, `amount`, `branch_id`, `year_id`, `entry_by`) 
-- VALUES 
-- (1, 1, 1, 80.00, 12.75, 1020.00, 1, 1, 'admin'),
-- (1, 2, 1, 45.00, 18.50, 832.50, 1, 1, 'admin');

-- ========================================
-- VERIFICATION QUERIES
-- ========================================

-- Check if tables were created successfully
SELECT 'transport' as table_name, COUNT(*) as record_count FROM transport
UNION ALL
SELECT 'fly_ash_unloading' as table_name, COUNT(*) as record_count FROM fly_ash_unloading;

-- Show table structures
-- DESCRIBE transport;
-- DESCRIBE fly_ash_unloading;

-- ========================================
-- FOREIGN KEY CONSTRAINTS (Optional)
-- ========================================
-- Uncomment these if you want to add foreign key constraints
-- Note: Make sure the referenced tables and columns exist first

-- ALTER TABLE `transport` 
--   ADD CONSTRAINT `fk_transport_production` 
--   FOREIGN KEY (`production_id`) REFERENCES `production` (`id`) ON DELETE CASCADE,
--   ADD CONSTRAINT `fk_transport_product` 
--   FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE RESTRICT;

-- ALTER TABLE `fly_ash_unloading` 
--   ADD CONSTRAINT `fk_unloading_production` 
--   FOREIGN KEY (`production_id`) REFERENCES `production` (`id`) ON DELETE CASCADE,
--   ADD CONSTRAINT `fk_unloading_material` 
--   FOREIGN KEY (`material_id`) REFERENCES `material` (`id`) ON DELETE RESTRICT,
--   ADD CONSTRAINT `fk_unloading_labour` 
--   FOREIGN KEY (`labour_group_id`) REFERENCES `labour_groups` (`id`) ON DELETE RESTRICT;