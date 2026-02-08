<?php
// Test production form submission
// Run at: http://localhost/erp/test_production_form.php

if ($_POST) {
    echo "<h2>Production Form Test Results</h2>";
    
    echo "<h3>All POST Data:</h3>";
    echo "<pre>" . print_r($_POST, true) . "</pre>";
    
    echo "<h3>Unloading Data Analysis:</h3>";
    if (isset($_POST['unloading'])) {
        $unloading = $_POST['unloading'];
        echo "<p><strong>Unloading items count:</strong> " . count($unloading) . "</p>";
        
        foreach ($unloading as $index => $item) {
            echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0;'>";
            echo "<h4>Item {$index}:</h4>";
            echo "<ul>";
            echo "<li>Material ID: " . (isset($item['material_id']) ? $item['material_id'] : 'NOT SET') . "</li>";
            echo "<li>Labour Group ID: " . (isset($item['labour_group_id']) ? $item['labour_group_id'] : 'NOT SET') . "</li>";
            echo "<li>Qty: " . (isset($item['qty']) ? $item['qty'] : 'NOT SET') . "</li>";
            echo "<li>Rate: " . (isset($item['rate']) ? $item['rate'] : 'NOT SET') . "</li>";
            echo "<li>Amount: " . (isset($item['amount']) ? $item['amount'] : 'NOT SET') . "</li>";
            echo "</ul>";
            
            // Validation check
            $material_id = isset($item['material_id']) ? (int)$item['material_id'] : 0;
            $labour_group_id = isset($item['labour_group_id']) ? (int)$item['labour_group_id'] : 0;
            $qty = isset($item['qty']) ? (float)$item['qty'] : 0;
            $rate = isset($item['rate']) ? (float)$item['rate'] : 0;
            $amount = isset($item['amount']) ? (float)$item['amount'] : ($qty * $rate);
            
            if ($material_id > 0 && $labour_group_id > 0 && $qty > 0 && $amount > 0) {
                echo "<p style='color: green; font-weight: bold;'>✓ This item would be stored in database</p>";
            } else {
                echo "<p style='color: red; font-weight: bold;'>✗ This item would be SKIPPED - missing required data</p>";
                echo "<p>Validation: material_id={$material_id}, labour_group_id={$labour_group_id}, qty={$qty}, amount={$amount}</p>";
            }
            echo "</div>";
        }
    } else {
        echo "<p style='color: red;'>No unloading data found in POST!</p>";
    }
    
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Production Form Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-row { margin: 10px 0; }
        label { display: inline-block; width: 150px; }
        input, select { width: 200px; padding: 5px; }
        button { padding: 10px 20px; background: #007cba; color: white; border: none; cursor: pointer; margin: 10px 0; }
        .add-btn { background: #28a745; }
        .remove-btn { background: #dc3545; }
        .unloading-item { border: 1px solid #ddd; padding: 15px; margin: 10px 0; background: #f9f9f9; }
        h3 { color: #333; border-bottom: 2px solid #007cba; padding-bottom: 5px; }
    </style>
</head>
<body>
    <h2>Production Unloading Form Test</h2>
    
    <form method="post" action="">
        <h3>Production Details</h3>
        <div class="form-row">
            <label>Production Date:</label>
            <input type="date" name="production[date]" value="<?php echo date('Y-m-d'); ?>" required>
        </div>
        
        <div class="form-row">
            <label>Production Number:</label>
            <input type="text" name="production[trans_no]" value="TEST001" required>
        </div>
        
        <h3>Unloading Details</h3>
        <div id="unloading-container">
            <div class="unloading-item">
                <h4>Unloading Item 1</h4>
                <div class="form-row">
                    <label>Material ID:</label>
                    <select name="unloading[0][material_id]" required>
                        <option value="">Select Material</option>
                        <option value="1">Test Material 1</option>
                        <option value="2">Test Material 2</option>
                    </select>
                </div>
                <div class="form-row">
                    <label>Labour Group ID:</label>
                    <select name="unloading[0][labour_group_id]" required>
                        <option value="">Select Labour Group</option>
                        <option value="1">Test Labour Group 1</option>
                        <option value="2">Test Labour Group 2</option>
                    </select>
                </div>
                <div class="form-row">
                    <label>Quantity:</label>
                    <input type="number" name="unloading[0][qty]" step="0.01" min="0" placeholder="0.00">
                </div>
                <div class="form-row">
                    <label>Rate:</label>
                    <input type="number" name="unloading[0][rate]" step="0.01" min="0" placeholder="0.00">
                </div>
                <div class="form-row">
                    <label>Amount:</label>
                    <input type="number" name="unloading[0][amount]" step="0.01" min="0" placeholder="0.00" readonly>
                </div>
                <button type="button" class="remove-btn" onclick="removeUnloadingItem(0)">Remove Item</button>
            </div>
        </div>
        
        <button type="button" class="add-btn" onclick="addUnloadingItem()">Add Unloading Item</button>
        <br><br>
        
        <button type="submit">Test Form Submission</button>
    </form>

    <script>
        let unloadingCount = 1;
        
        function addUnloadingItem() {
            const container = document.getElementById('unloading-container');
            const itemHtml = `
                <div class="unloading-item" id="unloading-${unloadingCount}">
                    <h4>Unloading Item ${unloadingCount + 1}</h4>
                    <div class="form-row">
                        <label>Material ID:</label>
                        <select name="unloading[${unloadingCount}][material_id]" required>
                            <option value="">Select Material</option>
                            <option value="1">Test Material 1</option>
                            <option value="2">Test Material 2</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <label>Labour Group ID:</label>
                        <select name="unloading[${unloadingCount}][labour_group_id]" required>
                            <option value="">Select Labour Group</option>
                            <option value="1">Test Labour Group 1</option>
                            <option value="2">Test Labour Group 2</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <label>Quantity:</label>
                        <input type="number" name="unloading[${unloadingCount}][qty]" step="0.01" min="0" placeholder="0.00">
                    </div>
                    <div class="form-row">
                        <label>Rate:</label>
                        <input type="number" name="unloading[${unloadingCount}][rate]" step="0.01" min="0" placeholder="0.00">
                    </div>
                    <div class="form-row">
                        <label>Amount:</label>
                        <input type="number" name="unloading[${unloadingCount}][amount]" step="0.01" min="0" placeholder="0.00" readonly>
                    </div>
                    <button type="button" class="remove-btn" onclick="removeUnloadingItem(${unloadingCount})">Remove Item</button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', itemHtml);
            unloadingCount++;
        }
        
        function removeUnloadingItem(index) {
            const item = document.getElementById(`unloading-${index}`);
            if (item) {
                item.remove();
            }
        }
        
        // Auto-calculate amount
        document.addEventListener('input', function(e) {
            if (e.target.name && (e.target.name.includes('[qty]') || e.target.name.includes('[rate]'))) {
                const container = e.target.closest('.unloading-item');
                const qtyInput = container.querySelector('input[name*="[qty]"]');
                const rateInput = container.querySelector('input[name*="[rate]"]');
                const amountInput = container.querySelector('input[name*="[amount]"]');
                
                const qty = parseFloat(qtyInput.value) || 0;
                const rate = parseFloat(rateInput.value) || 0;
                const amount = qty * rate;
                
                amountInput.value = amount.toFixed(2);
            }
        });
    </script>
</body>
</html>