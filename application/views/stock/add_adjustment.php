<script>

// Global function to load current stock
function loadCurrentStock() {
    var product_id = $('#product_id').val();
    console.log('loadCurrentStock called - Product ID:', product_id);
    console.log('Product select element found:', $('#product_id').length > 0);
    console.log('Current stock element found:', $('#current_stock').length > 0);
    
    if (product_id && product_id != '' && product_id != 'Select Product') {
        $('#current_stock').val('Loading...');
        console.log('Making AJAX request to:', '<?php echo site_url("admin/stock/get_current_stock"); ?>');
        
        $.ajax({
            url: '<?php echo site_url("admin/stock/get_current_stock"); ?>',
            type: 'POST',
            data: {product_id: product_id},
            dataType: 'json',
            timeout: 10000,
            success: function(response) {
                console.log('AJAX Success - Response:', response);
                if (response && response.success) {
                    $('#current_stock').val(response.stock);
                    console.log('Stock value set to:', response.stock);
                } else {
                    $('#current_stock').val('0.00');
                    console.log('Setting stock to 0.00 - Response error:', response ? response.message : 'No response');
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error Details:');
                console.log('- Status:', status);
                console.log('- Error:', error);
                console.log('- Response Text:', xhr.responseText);
                console.log('- Status Code:', xhr.status);
                $('#current_stock').val('Error: ' + status);
            }
        });
    } else {
        $('#current_stock').val('');
        console.log('No product selected or invalid selection');
    }
}
</script>

<!-- Centralized Admin Sales CSS -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/admin-sales-common.css">

<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">
          <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> <?php echo $this->session->flashdata('msg'); ?>
          </div>
                    <div class="search_panel">
                        <h3 class="search_header">ADD STOCK ADJUSTMENT</h3>
                        <div class="search_conent">
                            <form>
                                <div class="row">
                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="start_date" class="control-label">Start Date</label>
                                            <input type="text" id="start_date" name="start_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="end_date" class="control-label">End Date</label>
                                            <input type="text" id="end_date" name="end_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="span2"><br />
                                        <input type="submit" value="Search" class="btn btn-primary" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
<link rel="stylesheet" href="<?php echo base_url()?>assets/ui/jquery-ui.css" />
<script src="<?php echo base_url()?>assets/ui/jquery-ui.js"></script>
<script>
$(function() {
        $("#start_date, #end_date").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
        });
});
</script>
              <!-- Add form here if needed -->
            </div>
          </div>

          <?php if (!empty($message)): ?>
          <div class="alert alert-error">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <?php echo $message; ?>
          </div>
          <?php endif; ?>

          <div class="widget">
              <div class="widget-content">
                  <div class="pull-left">
                      <h2>Add Stock Adjustment</h2>
                  </div>
                  <div class="pull-right">
                      <a href="<?php echo base_url('admin/stock/adjustment'); ?>" class="btn">
                          <i class="icon-arrow-left"></i> Back to List
                      </a>
                  </div>
                  <div class="clearfix"></div>
              </div>
          </div>
          <div class="widget">
              <div class="widget-content">
                  <?php echo form_open('admin/stock/add_adjustment', array('class' => 'form-horizontal')); ?>
                      
                      <div class="control-group">
                          <label class="control-label" for="adjustment_date">Adjustment Date <span style="color: red;">*</span></label>
                          <div class="controls">
                              <input type="text" 
                                     class="date-picker" 
                                     id="adjustment_date" 
                                     name="adjustment_date" 
                                     value="<?php echo !empty($adjustment_date) ? $adjustment_date : date('d-m-Y'); ?>" 
                                     readonly>
                          </div>
                      </div>

                      <div class="control-group">
                          <label class="control-label" for="product_id">Product <span style="color: red;">*</span></label>
                          <div class="controls">
                              <select class="span5" 
                                      id="product_id" 
                                      name="product_id" 
                                      onchange="loadCurrentStock()">
                                  <option value="">Select Product</option>
                                  <?php foreach ($products as $product): ?>
                                      <option value="<?php echo $product['id']; ?>" 
                                              <?php echo ($product_id == $product['id']) ? 'selected' : ''; ?>>
                                          <?php echo htmlspecialchars($product['name']); ?>
                                      </option>
                                  <?php endforeach; ?>
                              </select>
                              <button type="button" onclick="loadCurrentStock()" style="margin-left: 10px;" class="btn btn-small">Refresh Stock</button>
                          </div>
                      </div>

                      <div class="control-group">
                          <label class="control-label" for="current_stock">Current Stock</label>
                          <div class="controls">
                              <input type="text" 
                                     id="current_stock" 
                                     readonly 
                                     placeholder="Select product to view current stock"
                                     style="background-color: #f5f5f5;">
                          </div>
                      </div>

                      <div class="control-group">
                          <label class="control-label" for="adjustment_type">Adjustment Type <span style="color: red;">*</span></label>
                          <div class="controls">
                              <select id="adjustment_type" name="adjustment_type">
                                  <option value="">Select Type</option>
                                  <option value="increase" <?php echo ($adjustment_type == 'increase') ? 'selected' : ''; ?>>
                                      Increase Stock
                                  </option>
                                  <option value="decrease" <?php echo ($adjustment_type == 'decrease') ? 'selected' : ''; ?>>
                                      Decrease Stock
                                  </option>
                              </select>
                          </div>
                      </div>

                      <div class="control-group">
                          <label class="control-label" for="quantity">Quantity <span style="color: red;">*</span></label>
                          <div class="controls">
                              <input type="number" 
                                     id="quantity" 
                                     name="quantity" 
                                     value="<?php echo $quantity; ?>" 
                                     min="0.01" 
                                     step="0.01" 
                                     placeholder="Enter quantity">
                          </div>
                      </div>

                      <div class="control-group">
                          <label class="control-label" for="remarks">Remarks <span style="color: red;">*</span></label>
                          <div class="controls">
                              <textarea id="remarks" 
                                        name="remarks" 
                                        rows="4" 
                                        placeholder="Enter reason for stock adjustment..."><?php echo $remarks; ?></textarea>
                          </div>
                      </div>

                      <div class="form-actions">
                          <button type="submit" class="btn btn-primary">
                              <i class="icon-ok"></i> Save Adjustment
                          </button>
                          <a href="<?php echo base_url('admin/stock/adjustment'); ?>" class="btn">
                              Cancel
                          </a>
                      </div>

                  <?php echo form_close(); ?>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>