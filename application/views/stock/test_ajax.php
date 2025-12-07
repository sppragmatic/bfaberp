<!DOCTYPE html>
<html>
<head>
    <title>Stock AJAX Test</title>
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.7.2.min.js"></script>
    <!-- Centralized Admin Sales CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/admin-sales-common.css">
</head>
<body>
    <h3>Stock AJAX Test</h3>
    <select id="product_test">
        <option value="">Select Product</option>
        <?php foreach ($products as $product): ?>
            <option value="<?php echo $product['id']; ?>"><?php echo htmlspecialchars($product['name']); ?></option>
        <?php endforeach; ?>
    </select>
    
    <input type="text" id="stock_result" placeholder="Stock will appear here" readonly>
    
    <button onclick="testStock()">Test Stock Load</button>
    
    <div id="debug_output"></div>
    
    <script>
    function testStock() {
        var product_id = $('#product_test').val();
        $('#debug_output').html('Testing product ID: ' + product_id);
        
        if (!product_id) {
            alert('Please select a product first');
            return;
        }
        
        $.ajax({
            url: '<?php echo site_url("admin/stock/get_current_stock"); ?>',
            type: 'POST',
            data: {product_id: product_id},
            success: function(response) {
                console.log('Response:', response);
                $('#debug_output').append('<br>Success: ' + JSON.stringify(response));
                try {
                    var data = typeof response === 'string' ? JSON.parse(response) : response;
                    if (data.success) {
                        $('#stock_result').val(data.stock);
                    } else {
                        $('#stock_result').val('Error: ' + data.message);
                    }
                } catch (e) {
                    $('#stock_result').val('Parse error');
                    $('#debug_output').append('<br>Parse error: ' + e.message);
                }
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
                $('#debug_output').append('<br>Error: ' + status + ' - ' + error);
                $('#debug_output').append('<br>Response: ' + xhr.responseText);
            }
        });
    }
    
    $('#product_test').change(testStock);
    </script>
</body>
</html>