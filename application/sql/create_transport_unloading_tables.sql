-- Migration to create transport and fly_ash_unloading tables
-- Run this SQL in your database

-- Transport table for storing loading/transport details
CREATE TABLE IF NOT EXISTS `transport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `production_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `type` enum('loading','transport') NOT NULL DEFAULT 'loading',
  `branch_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `entry_by` varchar(100) DEFAULT NULL,
  `entry_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_production_id` (`production_id`),
  KEY `idx_product_id` (`product_id`),
  KEY `idx_branch_year` (`branch_id`, `year_id`),
  KEY `idx_is_deleted` (`is_deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Fly Ash Unloading table for storing unloading details
CREATE TABLE IF NOT EXISTS `fly_ash_unloading` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `production_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `labour_group_id` int(11) NOT NULL,
  `qty` decimal(10,2) NOT NULL DEFAULT '0.00',
  `rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `branch_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `entry_by` varchar(100) DEFAULT NULL,
  `entry_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_production_id` (`production_id`),
  KEY `idx_material_id` (`material_id`),
  KEY `idx_labour_group_id` (`labour_group_id`),
  KEY `idx_branch_year` (`branch_id`, `year_id`),
  KEY `idx_is_deleted` (`is_deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;