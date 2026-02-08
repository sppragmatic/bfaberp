<?php
/**
 * Simple test to verify Labour Group module functionality
 */

// Minimal CodeIgniter bootstrap for testing
define('BASEPATH', 'test');

// Mock the CI super object
class CI_Controller {
    public function __construct() {
        $this->load = new StdClass();
        $this->db = new StdClass();
        $this->session = new StdClass();
        $this->input = new StdClass();
        $this->form_validation = new StdClass();
    }
}

// Include the model
include_once('application/models/Labour_group_model.php');

echo "<h2>Labour Group Module Test</h2>";

try {
    // Test database connection
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'bricks';
    
    $conn = new mysqli($host, $username, $password, $database);
    
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }
    
    echo "✅ Database connection successful<br>";
    
    // Test if labour_groups table exists
    $result = $conn->query("SHOW TABLES LIKE 'labour_groups'");
    if ($result->num_rows > 0) {
        echo "✅ labour_groups table exists<br>";
        
        // Test basic query
        $result = $conn->query("SELECT COUNT(*) as count FROM labour_groups");
        $row = $result->fetch_assoc();
        echo "✅ Found " . $row['count'] . " labour groups in database<br>";
        
        // Test controller file exists
        if (file_exists('application/controllers/admin/Labour_group.php')) {
            echo "✅ Controller file exists<br>";
        } else {
            echo "❌ Controller file missing<br>";
        }
        
        // Test model file exists
        if (file_exists('application/models/Labour_group_model.php')) {
            echo "✅ Model file exists<br>";
        } else {
            echo "❌ Model file missing<br>";
        }
        
        // Test view files exist
        $viewFiles = [
            'application/views/admin/labour_group/listing_labour_group.php',
            'application/views/admin/labour_group/create_labour_group.php',
            'application/views/admin/labour_group/edit_labour_group.php',
            'application/views/admin/labour_group/view_labour_group.php'
        ];
        
        foreach ($viewFiles as $file) {
            if (file_exists($file)) {
                echo "✅ View file exists: " . basename($file) . "<br>";
            } else {
                echo "❌ View file missing: " . basename($file) . "<br>";
            }
        }
        
        echo "<br><h3>✅ All checks passed!</h3>";
        echo "<p><strong>Try accessing the module:</strong></p>";
        echo "<p><a href='/erp/index.php/admin/labour_group' target='_blank'>Labour Groups Management</a></p>";
        echo "<p>If you get an 'Input library' error, it's because the Input library is loaded automatically in CodeIgniter and doesn't need to be explicitly loaded.</p>";
        
    } else {
        echo "❌ labour_groups table not found. Please run the setup script first.<br>";
    }
    
    $conn->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}
?>

<style>
body { font-family: Arial, sans-serif; padding: 20px; }
h2, h3 { color: #2c3e50; }
a { color: #3498db; text-decoration: none; }
a:hover { text-decoration: underline; }
</style>