<?php
/**
 * Labour Groups Database Setup Script
 * Run this script to create the labour_groups table
 */

// Database configuration from CodeIgniter config
$host = 'localhost';
$username = 'root';
$password = ''; // Usually empty for XAMPP
$database = 'bricks';

try {
    // Create connection
    $conn = new mysqli($host, $username, $password, $database);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    echo "Connected successfully to database: $database<br><br>";
    
    // Check if table already exists
    $checkTable = "SHOW TABLES LIKE 'labour_groups'";
    $result = $conn->query($checkTable);
    
    if ($result->num_rows > 0) {
        echo "Table 'labour_groups' already exists!<br>";
        
        // Show current structure
        $showStructure = "DESCRIBE labour_groups";
        $structureResult = $conn->query($showStructure);
        
        echo "<h3>Current table structure:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        
        while($row = $structureResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . $row['Default'] . "</td>";
            echo "<td>" . $row['Extra'] . "</td>";
            echo "</tr>";
        }
        echo "</table><br>";
        
        // Check if we need to update the table structure
        $checkColumns = "SHOW COLUMNS FROM labour_groups WHERE Field IN ('created_by', 'updated_by')";
        $columnResult = $conn->query($checkColumns);
        
        $needsUpdate = false;
        while($row = $columnResult->fetch_assoc()) {
            if (strpos($row['Type'], 'int') !== false) {
                $needsUpdate = true;
                break;
            }
        }
        
        if ($needsUpdate) {
            echo "<h3>Updating table structure to remove user dependencies...</h3>";
            
            // Drop foreign key constraints if they exist
            $conn->query("ALTER TABLE labour_groups DROP FOREIGN KEY IF EXISTS fk_labour_groups_created_by");
            $conn->query("ALTER TABLE labour_groups DROP FOREIGN KEY IF EXISTS fk_labour_groups_updated_by");
            
            // Update column types
            $updateSQL = "ALTER TABLE labour_groups 
                         MODIFY COLUMN created_by varchar(100) DEFAULT 'System',
                         MODIFY COLUMN updated_by varchar(100) DEFAULT 'System'";
            
            if ($conn->query($updateSQL) === TRUE) {
                echo "✅ Table structure updated successfully!<br>";
                
                // Update existing data
                $updateData = "UPDATE labour_groups SET 
                              created_by = 'Admin' WHERE created_by IS NOT NULL AND created_by != '',
                              updated_by = 'Admin' WHERE updated_by IS NOT NULL AND updated_by != ''";
                $conn->query($updateData);
                
                echo "✅ Existing data updated successfully!<br>";
            } else {
                echo "❌ Error updating table: " . $conn->error . "<br>";
            }
        } else {
            echo "✅ Table structure is already correct!<br>";
        }
        
    } else {
        echo "Creating new 'labour_groups' table...<br>";
        
        // Create table SQL
        $createSQL = "CREATE TABLE IF NOT EXISTS `labour_groups` (
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
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        if ($conn->query($createSQL) === TRUE) {
            echo "✅ Table 'labour_groups' created successfully!<br>";
            
            // Insert sample data
            $insertSQL = "INSERT INTO `labour_groups` (`name`, `description`, `created_at`, `updated_at`, `created_by`) VALUES
                         ('Skilled Workers', 'Highly skilled and experienced workers with specialized training', NOW(), NOW(), 'Admin'),
                         ('Semi-Skilled Workers', 'Workers with moderate level of skills and some training', NOW(), NOW(), 'Admin'),
                         ('Unskilled Workers', 'General laborers without specialized skills or training', NOW(), NOW(), 'Admin'),
                         ('Supervisors', 'Team leaders and supervisory staff overseeing work operations', NOW(), NOW(), 'Admin'),
                         ('Technicians', 'Technical staff responsible for equipment and machinery operations', NOW(), NOW(), 'Admin')";
            
            if ($conn->query($insertSQL) === TRUE) {
                echo "✅ Sample data inserted successfully!<br>";
            } else {
                echo "❌ Error inserting sample data: " . $conn->error . "<br>";
            }
        } else {
            echo "❌ Error creating table: " . $conn->error . "<br>";
        }
    }
    
    // Show final table data
    echo "<h3>Current labour groups:</h3>";
    $selectSQL = "SELECT * FROM labour_groups ORDER BY id";
    $result = $conn->query($selectSQL);
    
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Name</th><th>Description</th><th>Created At</th><th>Created By</th></tr>";
        
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . substr($row['description'], 0, 50) . "...</td>";
            echo "<td>" . $row['created_at'] . "</td>";
            echo "<td>" . $row['created_by'] . "</td>";
            echo "</tr>";
        }
        echo "</table><br>";
    } else {
        echo "No labour groups found.<br>";
    }
    
    echo "<br><h3>✅ Setup Complete!</h3>";
    echo "<p>You can now access the Labour Groups module at: <a href='/erp/index.php/admin/labour_group' target='_blank'>/erp/index.php/admin/labour_group</a></p>";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>

<style>
body { font-family: Arial, sans-serif; padding: 20px; }
h3 { color: #2c3e50; }
table { border-collapse: collapse; margin: 10px 0; }
th, td { padding: 8px; text-align: left; }
th { background-color: #3498db; color: white; }
tr:nth-child(even) { background-color: #f2f2f2; }
</style>