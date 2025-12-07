<?php
// Debug script to test edit production loading and unloading data
// Run this at: http://localhost/erp/debug_edit.php?id=1

// Include CodeIgniter bootstrap
define('BASEPATH', TRUE);
require_once('index.php');

// Get the CI instance
$CI =& get_instance();

// Set default production ID
$production_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

echo "<h2>Debug: Edit Production Loading & Unloading Data</h2>";
echo "<p><strong>Production ID:</strong> {$production_id}</p>";

// Check if tables exist
echo "<h3>Database Tables Status:</h3>";
echo "<ul>";

// Check transport table
if ($CI->db->table_exists('transport')) {
    echo "<li style='color: green;'>✓ Transport table exists</li>";
    
    // Show structure
    $fields = $CI->db->field_data('transport');
    echo "<ul>";
    foreach ($fields as $field) {
        echo "<li>{$field->name} ({$field->type})</li>";
    }
    echo "</ul>";
} else {
    echo "<li style='color: red;'>✗ Transport table does not exist</li>";
}

// Check fly_ash_unloading table  
if ($CI->db->table_exists('fly_ash_unloading')) {
    echo "<li style='color: green;'>✓ Fly Ash Unloading table exists</li>";
    
    // Show structure
    $fields = $CI->db->field_data('fly_ash_unloading');
    echo "<ul>";
    foreach ($fields as $field) {
        echo "<li>{$field->name} ({$field->type})</li>";
    }
    echo "</ul>";
} else {
    echo "<li style='color: red;'>✗ Fly Ash Unloading table does not exist</li>";
}
echo "</ul>";

// Check if production exists
echo "<h3>Production Data:</h3>";
$production = $CI->db->get_where('production', ['id' => $production_id])->row_array();
if ($production) {
    echo "<p style='color: green;'>✓ Production {$production_id} found</p>";
    echo "<pre>" . print_r($production, true) . "</pre>";
} else {
    echo "<p style='color: red;'>✗ Production {$production_id} not found</p>";
}

// Test loading items retrieval
echo "<h3>Loading Items Test:</h3>";
try {
    $loading_items = $CI->db->select('t.*, p.name as product_name')
                           ->from('transport t')
                           ->join('product p', 't.product_id = p.id', 'left')
                           ->where([
                               't.production_id' => $production_id,
                               't.type' => 'loading',
                               't.is_deleted' => 0
                           ])
                           ->get()
                           ->result_array();
    
    if (!empty($loading_items)) {
        echo "<p style='color: green;'>✓ Found " . count($loading_items) . " loading items</p>";
        echo "<pre>" . print_r($loading_items, true) . "</pre>";
    } else {
        echo "<p style='color: orange;'>⚠ No loading items found for production {$production_id}</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

// Test unloading items retrieval
echo "<h3>Unloading Items Test:</h3>";
try {
    $unloading_items = $CI->db->select('u.*, m.name as material_name, l.name as labour_group_name')
                             ->from('fly_ash_unloading u')
                             ->join('material m', 'u.material_id = m.id', 'left')
                             ->join('labour_groups l', 'u.labour_group_id = l.id', 'left')
                             ->where([
                                 'u.production_id' => $production_id,
                                 'u.is_deleted' => 0
                             ])
                             ->get()
                             ->result_array();
    
    if (!empty($unloading_items)) {
        echo "<p style='color: green;'>✓ Found " . count($unloading_items) . " unloading items</p>";
        echo "<pre>" . print_r($unloading_items, true) . "</pre>";
    } else {
        echo "<p style='color: orange;'>⚠ No unloading items found for production {$production_id}</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

// Test materials and labour groups
echo "<h3>Materials & Labour Groups:</h3>";
$materials = $CI->db->get('material')->result_array();
$labour_groups = $CI->db->get('labour_groups')->result_array();

echo "<p><strong>Materials:</strong> " . count($materials) . " found</p>";
echo "<p><strong>Labour Groups:</strong> " . count($labour_groups) . " found</p>";

echo "<h3>Actions:</h3>";
echo "<ul>";
echo "<li><a href='admin/production/edit_production/{$production_id}'>Test Edit Production {$production_id}</a></li>";
echo "<li><a href='create_tables.php'>Create Database Tables</a></li>";
echo "<li><a href='debug_edit.php?id=" . ($production_id + 1) . "'>Test Next Production</a></li>";
echo "</ul>";

?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
pre { background: #f5f5f5; padding: 10px; border-radius: 4px; }
ul { margin-left: 20px; }
</style>