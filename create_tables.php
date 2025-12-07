<?php
// Database table creation script for production loading and unloading
// Run this file in your browser: http://localhost/erp/create_tables.php

// Database configuration (adjust as needed)
$host = 'localhost';
$username = 'root';
$password = ''; // Default XAMPP password is empty
$database = 'erp'; // Change to your database name

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Creating Production Loading and Unloading Tables</h2>";
    
    // Create Transport table for loading details
    $transportTable = "
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
      KEY `idx_type` (`type`),
      KEY `idx_is_deleted` (`is_deleted`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
    ";
    
    $pdo->exec($transportTable);
    echo "<p style='color: green;'>✓ Transport table created successfully</p>";
    
    // Create Fly Ash Unloading table
    $unloadingTable = "
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
    ";
    
    $pdo->exec($unloadingTable);
    echo "<p style='color: green;'>✓ Fly Ash Unloading table created successfully</p>";
    
    echo "<h3>Table Structure Details:</h3>";
    
    // Show Transport table structure
    echo "<h4>Transport Table (for Loading Details):</h4>";
    $result = $pdo->query("DESCRIBE transport");
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>{$row['Field']}</td>";
        echo "<td>{$row['Type']}</td>";
        echo "<td>{$row['Null']}</td>";
        echo "<td>{$row['Key']}</td>";
        echo "<td>{$row['Default']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Show Fly Ash Unloading table structure  
    echo "<h4>Fly Ash Unloading Table:</h4>";
    $result = $pdo->query("DESCRIBE fly_ash_unloading");
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>{$row['Field']}</td>";
        echo "<td>{$row['Type']}</td>";
        echo "<td>{$row['Null']}</td>";
        echo "<td>{$row['Key']}</td>";
        echo "<td>{$row['Default']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h3 style='color: green;'>✓ All tables created successfully!</h3>";
    echo "<p><strong>Next Steps:</strong></p>";
    echo "<ul>";
    echo "<li>Loading data will be stored in the 'transport' table with production_id relationship</li>";
    echo "<li>Unloading data will be stored in the 'fly_ash_unloading' table with production_id relationship</li>";
    echo "<li>Both tables include audit trails (entry_by, entry_date, updated_by, updated_at)</li>";
    echo "<li>Soft delete functionality with is_deleted flag</li>";
    echo "<li>You can now test the production forms with loading and unloading data</li>";
    echo "</ul>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    echo "<p>Please check:</p>";
    echo "<ul>";
    echo "<li>XAMPP MySQL is running</li>";
    echo "<li>Database name is correct (currently set to 'erp')</li>";
    echo "<li>Username and password are correct</li>";
    echo "</ul>";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
table { border-collapse: collapse; margin: 10px 0; }
th { background-color: #f0f0f0; padding: 8px; }
td { padding: 8px; }
</style>