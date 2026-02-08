<?php
// Direct database test for unloading data storage
// Run at: http://localhost/erp/test_unloading_db.php

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'erp';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Unloading Data Storage Test</h2>";
    
    // Check if fly_ash_unloading table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'fly_ash_unloading'");
    $table_exists = $stmt->rowCount() > 0;
    
    if ($table_exists) {
        echo "<p style='color: green;'>✓ fly_ash_unloading table exists</p>";
        
        // Show table structure
        echo "<h3>Table Structure:</h3>";
        $stmt = $pdo->query("DESCRIBE fly_ash_unloading");
        $fields = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        foreach ($fields as $field) {
            echo "<tr>";
            echo "<td>{$field['Field']}</td>";
            echo "<td>{$field['Type']}</td>";
            echo "<td>{$field['Null']}</td>";
            echo "<td>{$field['Key']}</td>";
            echo "<td>{$field['Default']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Test data insertion
        echo "<h3>Test Data Insertion:</h3>";
        
        $test_data = [
            'production_id' => 999,
            'material_id' => 1,
            'labour_group_id' => 1,
            'qty' => 100.50,
            'rate' => 15.75,
            'amount' => 1582.88,
            'branch_id' => 1,
            'year_id' => 1,
            'entry_by' => 'test_user',
            'entry_date' => date('Y-m-d H:i:s')
        ];
        
        try {
            $sql = "INSERT INTO fly_ash_unloading (production_id, material_id, labour_group_id, qty, rate, amount, branch_id, year_id, entry_by, entry_date) 
                    VALUES (:production_id, :material_id, :labour_group_id, :qty, :rate, :amount, :branch_id, :year_id, :entry_by, :entry_date)";
            
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute($test_data);
            
            if ($result) {
                $insert_id = $pdo->lastInsertId();
                echo "<p style='color: green;'>✓ Test insertion successful! Insert ID: {$insert_id}</p>";
                
                // Clean up test data
                $pdo->exec("DELETE FROM fly_ash_unloading WHERE production_id = 999");
                echo "<p>Test data cleaned up</p>";
            } else {
                echo "<p style='color: red;'>✗ Test insertion failed</p>";
            }
        } catch (Exception $e) {
            echo "<p style='color: red;'>✗ Insertion error: " . $e->getMessage() . "</p>";
        }
        
        // Check existing data
        echo "<h3>Existing Data:</h3>";
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM fly_ash_unloading WHERE is_deleted = 0");
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        echo "<p>Records in table: {$count}</p>";
        
        if ($count > 0) {
            $stmt = $pdo->query("SELECT * FROM fly_ash_unloading WHERE is_deleted = 0 ORDER BY id DESC LIMIT 5");
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>ID</th><th>Production ID</th><th>Material ID</th><th>Labour Group ID</th><th>Qty</th><th>Rate</th><th>Amount</th><th>Entry Date</th></tr>";
            foreach ($records as $record) {
                echo "<tr>";
                echo "<td>{$record['id']}</td>";
                echo "<td>{$record['production_id']}</td>";
                echo "<td>{$record['material_id']}</td>";
                echo "<td>{$record['labour_group_id']}</td>";
                echo "<td>{$record['qty']}</td>";
                echo "<td>{$record['rate']}</td>";
                echo "<td>{$record['amount']}</td>";
                echo "<td>{$record['entry_date']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
    } else {
        echo "<p style='color: red;'>✗ fly_ash_unloading table does not exist</p>";
        echo "<p><a href='create_tables.php'>Create the tables first</a></p>";
    }
    
    // Check related tables
    echo "<h3>Related Tables Check:</h3>";
    
    $tables_to_check = ['material', 'labour_groups', 'production'];
    foreach ($tables_to_check as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '{$table}'");
        $exists = $stmt->rowCount() > 0;
        
        if ($exists) {
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM {$table}");
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            echo "<p style='color: green;'>✓ {$table} table exists ({$count} records)</p>";
        } else {
            echo "<p style='color: red;'>✗ {$table} table missing</p>";
        }
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>Database Error: " . $e->getMessage() . "</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
table { border-collapse: collapse; margin: 10px 0; }
th, td { padding: 8px; text-align: left; }
th { background-color: #f0f0f0; }
</style>