<link rel="stylesheet" href="<?php echo base_url();?>assets/css/sales-form.css">
<script>
function sdisp(st){
    if(st=='1'){
        $(".pmdetails").show();
    }else{
        $(".pmdetails").hide();
    }
}

// AJAX function to validate contact number against party table
function validateContactNumber(contactNo) {
    if (!contactNo || contactNo.length < 10) {
        resetContactValidation();
        return;
    }
    
    // Show loading message
    $('#contact_validation_message').html('Validating contact number...')
        .removeClass('text-success text-warning text-danger')
        .addClass('text-info');
    
    $.ajax({
        url: '<?php echo site_url("admin/sales/check_contact_in_party"); ?>',
        type: 'POST',
        data: { contact_no: contactNo },
        dataType: 'json',
        success: function(response) {
            if (response.exists) {
                // Contact found in party - auto-fill customer name
                $('#contact_validation_message').html(response.message)
                    .removeClass('text-info text-warning text-danger')
                    .addClass('text-success');
                $('#contact_no').addClass('party-found');
                $('#customer_name').val(response.party.name).addClass('party-found').prop('readonly', true);
                $('#party_id').val(response.party.id);
            } else {
                // Contact not found - allow manual entry
                $('#contact_validation_message').html(response.message)
                    .removeClass('text-info text-success text-danger')
                    .addClass('text-warning');
                $('#contact_no').removeClass('party-found').addClass('party-not-found');
                $('#customer_name').removeClass('party-found').prop('readonly', false);
                $('#party_id').val('');
            }
        },
        error: function() {
            $('#contact_validation_message').html('Error validating contact number. Please try again.')
                .removeClass('text-info text-success text-warning')
                .addClass('text-danger');
        }
    });
}

// Reset contact validation styling and messages
function resetContactValidation() {
    $('#contact_validation_message').html('').removeClass('text-info text-success text-warning text-danger');
    $('#contact_no').removeClass('party-found party-not-found');
    $('#customer_name').val('').prop('readonly', false).removeClass('party-found');
    $('#party_id').val('');
}
</script>
<script src="<?php echo base_url()?>assets/validate/dist/jquery.validate.js"></script>
<script>
$().ready(function() {
    // validate the comment form when it is submitted

    // validate signup form on keyup and submit
    $("#rejoin-form").validate({
        rules: {
            'course': "required",
            'course_ctgy': "required"
        },
        messages: {
            'course': "Please choose your course",
            'course_ctgy': "Please choose COURSE CATEGORY"
        }
    });

    // Contact number validation event listeners
    $(document).on('input keyup', '#contact_no', function() {
        const contactNo = $(this).val().replace(/\D/g, ''); // Remove non-digits
        $(this).val(contactNo); // Set cleaned value back

        if (contactNo.length >= 10) {
            validateContactNumber(contactNo);
        } else {
            resetContactValidation();
        }
    });

    // Additional validation on blur (when field loses focus)
    $(document).on('blur', '#contact_no', function() {
        const contactNo = $(this).val();
        if (contactNo.length >= 10) {
            validateContactNumber(contactNo);
        }
    });

    // Format contact number as user types (optional - adds spaces for readability)
    $(document).on('input', '#contact_no', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 15) {
            value = value.substring(0, 15);
        }
        $(this).val(value);
    });

    // Clear validation when switching between customer selection methods
    $(document).on('click', 'a[onclick="cn()"]', function() {
        resetContactValidation();
    });

    // propose username by combining first- and lastname
});
</script>

<?php if (validation_errors()): ?>
<div class="alert-error-modern">
    <div class="alert-icon">
        <i class="icon-exclamation-triangle"></i>
    </div>
    <div class="alert-content">
        <strong>Please correct the following errors:</strong>
        <?php echo validation_errors(); ?>
    </div>
    <button class="alert-close" onclick="this.parentElement.style.display='none'">
        <i class="icon-remove"></i>
    </button>
</div>
<?php endif; ?>

<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <!-- Professional Page Header -->
                    <div class="page-header-card">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                            <div>
                                <h1>
                                    <i class="icon-edit" style="color: #3498db; margin-right: 12px; font-size: 32px;"></i>
                                    Edit Sales Record
                                </h1>
                                <p>Update sales record with customer details and product information</p>
                            </div>
                            <div class="action-buttons" style="display: flex; gap: 15px; align-items: center;">
                                <a href="<?= site_url('admin/sales/view_sales') ?>" class="btn-primary-gradient">
                                    <i class="icon-arrow-left"></i> Back to Sales List
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Sales Information Container -->
                    <div class="data-table-container">
                        <div class="table-header">
                            <h3>
                                <i class="icon-info-circle"></i>
                                Sales Information
                            </h3>
                        </div>

                        <div style="padding: 25px;">
                            <form action="<?php echo site_url('admin/sales/edit_sales/'.$sales['id'])?>" method="post" class="modern-form">
                                <table class="table-modern sales-info-table">
                                    <tr>
                                        <th>SL No.</th>
                                        <td><input class="form-control" readonly="readonly" name="sl_no"
                                                value="<?php echo $sales['sl_no']; ?>" type="text"></td>

                                        <th>DATE</th>
                                        <td><input id="date" name="bill_date" value="<?php echo $sales['bill_date']; ?>" type="text"></td>
                                    </tr>
                                    <tr>
                                        <th>Name OF PURCHASE</th>
                                        <td>
                                            <div id="cid">
                                                <select id="customer_id" class="chosen-select" name="customer_id">
                                                    <option value="">-Select customer-</option>
                                                    <?php foreach($customer as $pr){ ?>
                                                    <option <?php if($sales['customer_id']==$pr['id']){ ?> selected="selected" <?php } ?> value="<?php echo $pr['id']; ?>">
                                                        <?php echo $pr['name']; ?>
                                                        <?php if(!empty($pr['contact_no'])): ?>
                                                        - <?php echo $pr['contact_no']; ?>
                                                        <?php endif; ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                                <!-- <span style="padding-left: 30px"><a onclick="cn()"><i class="icon-plus"></i></a></span> -->
                                            </div>

                                            <div id="cn" style="display: none;">
                                                <div class="form-group">
                                                    <label for="contact_no">Contact Number *</label>
                                                    <div style="position: relative;">
                                                        <input id="contact_no" name="contact_no" type="text"
                                                            class="form-control"
                                                            placeholder="Enter 10-15 digit mobile number" maxlength="15"
                                                            pattern="[0-9]{10,15}"
                                                            title="Please enter a valid 10-15 digit mobile number"
                                                            autocomplete="off">
                                                        <small class="text-muted">
                                                            <i class="fa fa-info-circle"></i>
                                                            Enter mobile number to check if customer exists in party
                                                            records
                                                        </small>
                                                    </div>
                                                    <div id="contact_validation_message"
                                                        class="validation-message mt-1"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="customer_name">Customer Name</label>
                                                    <input id="customer_name" name="customer_name" type="text"
                                                        class="form-control"
                                                        placeholder="Customer name (auto-filled or enter manually)">
                                                </div>
                                                <input type="hidden" id="party_id" name="party_id">
                                                <span style="padding-left: 30px"><a onclick="cid()"><i
                                                            class="icon-minus"></i></a></span>
                                            </div>
                                        </td>
                                        <th>Payment Status</th>
                                        <td><select id="payment_status" onchange="sdisp(this.value)"
                                                name="payment_status">
                                                <option value="">-Select Type-</option>
                                                <option <?php if($sales['payment_status']=='1'){ ?> selected="selected" <?php } ?> value="1">Paid</option>
                                                <option <?php if($sales['payment_status']=='2'){ ?> selected="selected" <?php } ?> value="2">Un Paid</option>
                                            </select></td>
                                    </tr>

                                    <tr>
                                        <th>VEHICLE NUMBER</th>
                                        <td><input name="vehicle_number" value="<?php echo $sales['vehicle_number']; ?>" type="text"></td>

                                        <th style="display:<?php echo ($sales['payment_status']=='2') ? 'none' : 'table-cell'; ?>" class="pmdetails">Paid Amount</th>
                                        <td style="display:<?php echo ($sales['payment_status']=='2') ? 'none' : 'table-cell'; ?>" class="pmdetails">
                                            <input type="text" name="paid_amount" value="<?php echo $sales['paid_amount']; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>VEHICLE OWNER</th>
                                        <td><input name="vehicle_owner" value="<?php echo $sales['vehicle_owner']; ?>" type="text"></td>

                                        <th style="display:<?php echo ($sales['payment_status']=='2') ? 'none' : 'table-cell'; ?>" class="pmdetails">Payment Type</th>
                                        <td style="display:<?php echo ($sales['payment_status']=='2') ? 'none' : 'table-cell'; ?>" class="pmdetails">
                                            <input type="radio" <?php if($sales['type']=='1'){ ?> checked="checked" <?php } ?> name="type" value="1"> Cash
                                            <input type="radio" <?php if($sales['type']=='2'){ ?> checked="checked" <?php } ?> name="type" value="2"> Cheque
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>DELIVERY POINT ADDRESS</th>
                                        <td><textarea name="address"><?php echo $sales['address']; ?></textarea></td>

                                        <th style="display:<?php echo ($sales['payment_status']=='2') ? 'none' : 'table-cell'; ?>" class="pmdetails">Payment Details</th>
                                        <td style="display:<?php echo ($sales['payment_status']=='2') ? 'none' : 'table-cell'; ?>" class="pmdetails">
                                            <textarea name="paiddetails"><?php echo $sales['paiddetails']; ?></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                  

                    <!-- Item Details Container -->
                    <div class="data-table-container" style="display: block !important; visibility: visible !important;">
                        <div class="table-header">
                            <h3>
                                <i class="icon-list"></i>
                                Item Details
                                <small style="font-size: 12px; opacity: 0.8;">(<?php echo isset($products) ? count($products) : 0; ?> items)</small>
                            </h3>
                            <div class="table-controls">
                                <span>Grand Total: <strong id="grand_total_display">₹<?php echo isset($sales['total_amount']) ? number_format($sales['total_amount'], 2) : '0.00'; ?></strong></span>
                            </div>
                        </div>

                        <div style="padding: 0; display: block !important; visibility: visible !important;">
                            <table class="table-modern" style="display: table !important; visibility: visible !important; width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th>PRODUCT</th>
                                        <th>QUANTITY</th>
                                        <th>RATE</th>
                                        <th>AMOUNT</th>
                                    </tr>
                                </thead>

                            <tbody>
                                <?php 
                                // Debug: Check if products exist
                                if (!isset($products) || empty($products)) {
                                    echo '<tr><td colspan="4" style="text-align: center; color: red; font-weight: bold;">No products found! Products variable: ' . (isset($products) ? 'exists but empty' : 'not set') . '</td></tr>';
                                } else {
                                    $sm=1; 
                                    foreach ($products as $fm){
                                ?>
                                
                                <tr>
                                    <td><?php echo $fm['name'];?></td>
                                    <td><input name="prod[<?php echo $fm['id'];?>]" class="span2 quantity-input"
                                            value="<?php echo $fm['stock'];?>"
                                            type="number" step="0.01" min="0"
                                            data-product-id="<?php echo $fm['id'];?>"
                                            onkeyup="calculateAmount(<?php echo $fm['id'];?>)"
                                            onchange="calculateAmount(<?php echo $fm['id'];?>)"></td>
                                    <td><input name="rate[<?php echo $fm['id'];?>]" class="span2 rate-input"
                                            value="<?php echo isset($fm['rate']) ? $fm['rate'] : ''; ?>"
                                            type="number" step="0.01" min="0"
                                            data-product-id="<?php echo $fm['id'];?>"
                                            onkeyup="calculateAmount(<?php echo $fm['id'];?>)"
                                            onchange="calculateAmount(<?php echo $fm['id'];?>)"></td>
                                    <td><input name="amount[<?php echo $fm['id'];?>]" class="span2 amount-input"
                                            value="<?php echo $fm['amount'];?>"
                                            type="number" step="0.01" min="0"
                                            data-product-id="<?php echo $fm['id'];?>" readonly></td>
                                </tr>
                                <?php 
                                    } // End foreach
                                } // End if-else
                                ?>

                                <!-- Additional Charges Section -->
                                <tr style="background-color: #f9f9f9;">
                                    <td colspan="3" align="right"><strong>Sub Total (Products):</strong></td>
                                    <td><input name="sub_total" id="sub_total" class="span2" type="number"
                                            step="0.01" readonly
                                            style="background-color: #e9ecef; font-weight: bold;"
                                            value="<?php echo isset($sales['sub_total']) ? $sales['sub_total'] : ''; ?>"></td>
                                </tr>
                                
                                <tr>
                                    <td colspan="3" align="right"><strong>Transportation Charge:</strong></td>
                                    <td><input name="transportation_charge" id="transportation_charge" class="span2 charge-input" 
                                            type="number" step="0.01" min="0" 
                                            value="<?php echo isset($sales['transportation_charge']) ? $sales['transportation_charge'] : '0'; ?>"
                                            onkeyup="calculateGrandTotal()" 
                                            onchange="calculateGrandTotal()"
                                            placeholder="0.00"></td>
                                </tr>
                                
                                <tr>
                                    <td colspan="3" align="right"><strong>Loading Charge:</strong></td>
                                    <td><input name="loading_charge" id="loading_charge" class="span2 charge-input" 
                                            type="number" step="0.01" min="0" 
                                            value="<?php echo isset($sales['loading_charge']) ? $sales['loading_charge'] : '0'; ?>"
                                            onkeyup="calculateGrandTotal()" 
                                            onchange="calculateGrandTotal()"
                                            placeholder="0.00"></td>
                                </tr>

                                <tr class="total-row" style="background-color: #f5f5f5; font-weight: bold; border-top: 2px solid #ddd;">
                                    <td colspan="3" align="right"><strong>GRAND TOTAL:</strong></td>
                                    <td><input name="total_amount" id="total_amount" class="span2" type="number"
                                            step="0.01" readonly
                                            style="font-weight: bold; background-color: #d4edda; border: 2px solid #c3e6cb; font-size: 16px;"
                                            value="<?php echo isset($sales['total_amount']) ? $sales['total_amount'] : ''; ?>"></td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Submit Section -->
                    <div class="submit-section-container">
                        <div class="submit-buttons">
                            <button type="submit" class="btn-success-gradient">
                                <i class="icon-save"></i> Update Sales Record
                            </button>
                            <a href="<?= site_url('admin/sales/view_sales') ?>" class="btn-primary-gradient">
                                <i class="icon-remove"></i> Cancel
                            </a>
                        </div>
                        <div class="submit-help-text">
                            <i class="icon-info-circle"></i>
                            Please review all information before updating the sales record.
                        </div>
                    </div>

                            </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    //	alert("hello")
    $("#date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy'
    });

    $("#doj").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy'
    });

    // Form validation for sales form
    $('form').on('submit', function(e) {
        const isContactVisible = $('#cn').is(':visible');
        const contactNo = $('#contact_no').val();
        const customerName = $('#customer_name').val();
        const customerId = $('#customer_id').val();
        const totalAmount = parseFloat($('#total_amount').val()) || 0;

        // Validate total_amount > 0
        if (totalAmount <= 0) {
            e.preventDefault();
            alert('Total amount must be greater than zero to submit the form.');
            $('#total_amount').focus();
            return false;
        }

        if (isContactVisible) {
            // Validate contact number when using manual entry
            if (!contactNo || contactNo.length < 10) {
                e.preventDefault();
                alert('Please enter a valid 10-15 digit mobile number');
                $('#contact_no').focus();
                return false;
            }

            // Validate customer name for new customers (when no party found)
            if (!$('#party_id').val() && !customerName.trim()) {
                e.preventDefault();
                alert('Please enter customer name for new customer');
                $('#customer_name').focus();
                return false;
            }
        } else {
            // Validate customer selection when using dropdown
            if (!customerId) {
                e.preventDefault();
                alert('Please select a customer from the dropdown');
                $('#customer_id').focus();
                return false;
            }
        }
    });
});

function cid() {
    $("#cid").show();
    $("#cn").hide();
}

function cn() {
    $("#cid").hide();
    $("#cn").show();
}

function setamount(amt, dis) {
    alert($("#amount").value());
    /*	 var amount =  parseInt($("#amount").value());
    	 var cst =  parseInt(amt);
    	 alert(amonut);
    	 alert(cst)
    	 var ns = amount+cst;
    	 $("#amount").value(ns)*/

}

// Calculate amount for individual product (quantity * rate)
function calculateAmount(productId) {
    var quantity = parseFloat($('input[name="prod[' + productId + ']"]').val()) || 0;
    var rate = parseFloat($('input[name="rate[' + productId + ']"]').val()) || 0;
    var amount = quantity * rate;

    // Set the calculated amount
    $('input[name="amount[' + productId + ']"]').val(amount.toFixed(2));

    // Recalculate totals
    calculateSubTotal();
}

// Calculate sub total amount from all products only
function calculateSubTotal() {
    var subTotal = 0;
    $('.amount-input').each(function() {
        var amount = parseFloat($(this).val()) || 0;
        subTotal += amount;
    });
    $('#sub_total').val(subTotal.toFixed(2));
    
    // Calculate grand total including charges
    calculateGrandTotal();
}

// Calculate grand total including transportation and loading charges
function calculateGrandTotal() {
    var subTotal = parseFloat($('#sub_total').val()) || 0;
    var transportationCharge = parseFloat($('#transportation_charge').val()) || 0;
    var loadingCharge = parseFloat($('#loading_charge').val()) || 0;
    
    var grandTotal = subTotal + transportationCharge + loadingCharge;
    $('#total_amount').val(grandTotal.toFixed(2));
    
    // Update the header display
    $('#grand_total_display').text('₹' + grandTotal.toFixed(2));
}

// Backward compatibility - redirect to new function
function calculateTotalAmount() {
    calculateSubTotal();
}

// Initialize calculation events when document is ready
$(document).ready(function() {
    // Add event listeners for real-time calculation
    $('.quantity-input, .rate-input').on('input keyup change', function() {
        var productId = $(this).data('product-id');
        calculateAmount(productId);
    });

    // Allow direct editing of amount field and recalculate totals
    $('.amount-input').on('input keyup change', function() {
        calculateSubTotal();
    });

    // Add event listeners for charge inputs
    $('.charge-input').on('input keyup change', function() {
        calculateGrandTotal();
    });

    // Specific event listeners for transportation and loading charges
    $('#transportation_charge, #loading_charge').on('input keyup change blur', function() {
        // Ensure non-negative values
        var value = parseFloat($(this).val());
        if (isNaN(value) || value < 0) {
            $(this).val('0');
        }
        calculateGrandTotal();
    });

    // Calculate initial totals on page load
    calculateSubTotal();
    
    // Format charge inputs to show proper decimal places
    $('.charge-input').on('blur', function() {
        var value = parseFloat($(this).val()) || 0;
        $(this).val(value.toFixed(2));
    });
});
</script>

<script type="text/javascript">
var config = {
    '.chosen-select': {
        disable_search_threshold: 0, // CRITICAL: Enable search immediately - 0 means search appears for any number of options
        search_contains: true, // Search anywhere in text
        placeholder_text_single: "🔍 Select option (Type to search...)",
        no_results_text: 'No results found for:',
        width: "100%",
        enable_split_word_search: true,
        search_enabled: true,
        case_sensitive_search: false,
        search_field_scale: 1.1,
        disable_search: false, // Explicitly ensure search is NOT disabled
        max_selected_options: 1
    },
    '.chosen-select-deselect': {
        allow_single_deselect: true,
        disable_search_threshold: 0,
        search_contains: true
    },
    '.chosen-select-no-single': {
        disable_search_threshold: 0,
        search_contains: true
    },
    '.chosen-select-no-results': {
        no_results_text: 'No options found matching:',
        disable_search_threshold: 0,
        search_contains: true
    },
    '.chosen-select-width': {
        width: "100%",
        disable_search_threshold: 0,
        search_contains: true
    }
}

// Apply configuration after a short delay to ensure DOM is ready
setTimeout(function() {
    for (var selector in config) {
        // Destroy existing chosen instances before reinitializing
        try {
            $(selector).chosen('destroy');
        } catch(e) {
            // Ignore if not initialized yet
        }
        $(selector).chosen(config[selector]);
    }
}, 100);
</script>