<?php
// Debug script to test unloading data posting
// Place this at: http://localhost/erp/debug_unloading.php

if ($_POST) {
    echo "<h2>Posted Data Debug</h2>";
    echo "<h3>Raw POST data:</h3>";
    echo "<pre>" . print_r($_POST, true) . "</pre>";
    
    echo "<h3>Unloading Data Analysis:</h3>";
    if (isset($_POST['unloading'])) {
        $unloading_items = $_POST['unloading'];
        echo "<p><strong>Unloading items found:</strong> " . count($unloading_items) . "</p>";
        
        foreach ($unloading_items as $index => $item) {
            echo "<h4>Item {$index}:</h4>";
            echo "<ul>";
            echo "<li><strong>Material ID:</strong> " . (isset($item['material_id']) ? $item['material_id'] : 'NOT SET') . "</li>";
            echo "<li><strong>Labour Group ID:</strong> " . (isset($item['labour_group_id']) ? $item['labour_group_id'] : 'NOT SET') . "</li>";
            echo "<li><strong>Quantity:</strong> " . (isset($item['qty']) ? $item['qty'] : 'NOT SET') . "</li>";
            echo "<li><strong>Rate:</strong> " . (isset($item['rate']) ? $item['rate'] : 'NOT SET') . "</li>";
            echo "<li><strong>Amount:</strong> " . (isset($item['amount']) ? $item['amount'] : 'NOT SET') . "</li>";
            echo "</ul>";
            
            // Check validation
            $material_id = isset($item['material_id']) ? (int)$item['material_id'] : 0;
            $labour_group_id = isset($item['labour_group_id']) ? (int)$item['labour_group_id'] : 0;
            $qty = isset($item['qty']) ? (float)$item['qty'] : 0;
            $rate = isset($item['rate']) ? (float)$item['rate'] : 0;
            $amount = isset($item['amount']) ? (float)$item['amount'] : ($qty * $rate);
            
            if ($material_id > 0 && $labour_group_id > 0 && $qty > 0 && $amount > 0) {
                echo "<p style='color: green;'>✓ Item {$index} would be inserted</p>";
            } else {
                echo "<p style='color: red;'>✗ Item {$index} would be skipped - missing required data</p>";
            }
        }
    } else {
        echo "<p style='color: red;'>No unloading data found in POST</p>";
    }
    
    exit;
}
?>

<form method="post" action="">
    <h2>Test Unloading Data Submission</h2>
    
    <h3>Unloading Item 1:</h3>
    <label>Material ID: <input type="number" name="unloading[0][material_id]" value="1"></label><br><br>
    <label>Labour Group ID: <input type="number" name="unloading[0][labour_group_id]" value="1"></label><br><br>
    <label>Quantity: <input type="number" step="0.01" name="unloading[0][qty]" value="100"></label><br><br>
    <label>Rate: <input type="number" step="0.01" name="unloading[0][rate]" value="15.50"></label><br><br>
    <label>Amount: <input type="number" step="0.01" name="unloading[0][amount]" value="1550"></label><br><br>
    
    <h3>Unloading Item 2:</h3>
    <label>Material ID: <input type="number" name="unloading[1][material_id]" value="2"></label><br><br>
    <label>Labour Group ID: <input type="number" name="unloading[1][labour_group_id]" value="2"></label><br><br>
    <label>Quantity: <input type="number" step="0.01" name="unloading[1][qty]" value="50"></label><br><br>
    <label>Rate: <input type="number" step="0.01" name="unloading[1][rate]" value="20.00"></label><br><br>
    <label>Amount: <input type="number" step="0.01" name="unloading[1][amount]" value="1000"></label><br><br>
    
    <button type="submit">Test Submit</button>
</form>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
label { display: block; margin: 5px 0; }
input { width: 200px; padding: 5px; }
button { padding: 10px 20px; background: #007cba; color: white; border: none; cursor: pointer; }
pre { background: #f5f5f5; padding: 10px; border-radius: 4px; }
</style>