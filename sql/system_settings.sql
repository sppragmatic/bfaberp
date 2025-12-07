-- SQL script to create system_settings table for ERP system
-- Run this in your database to enable the settings functionality

CREATE TABLE IF NOT EXISTS `system_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `setting_description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert default settings
INSERT INTO `system_settings` (`setting_key`, `setting_value`, `setting_description`) VALUES
('company_name', 'My ERP Company', 'Company name displayed in the system'),
('company_address', '', 'Company address for reports and documents'),
('company_phone', '', 'Company contact phone number'),
('company_email', '', 'Company email address'),
('tax_rate', '18', 'Default tax rate percentage'),
('currency_symbol', '₹', 'Currency symbol for display');

-- Note: Run this SQL script in your database management tool (phpMyAdmin, etc.)
-- to create the required table and default settings.