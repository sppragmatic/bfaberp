

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/sales-form.css">


<script>
function sdisp(st) {
    if (st == '1') {
        $(".pmdetails").show();
    } else {
        $(".pmdetails").hide();
    }

}

// Contact number validation functions
let contactValidationTimeout;

function validateContactNumber(contactNo) {
    const messageDiv = $('#contact_validation_message');

    // Reset styling
    $('#contact_no').removeClass('party-found party-not-found');

    // Clear previous timeout
    clearTimeout(contactValidationTimeout);

    // Reset fields
    $('#customer_name').val('').prop('readonly', false).removeClass('party-found');
    $('#party_id').val('');

    if (!contactNo || contactNo.length < 10) {
        messageDiv.html('').removeClass('text-info text-success text-warning text-danger');
        return;
    }

    // Show loading message
    messageDiv.html('<i class="fa fa-spinner fa-spin"></i> Checking mobile number in party records...')
        .removeClass('text-success text-warning text-danger')
        .addClass('text-info');

    // Debounce the validation
    contactValidationTimeout = setTimeout(function() {
        checkContactInParty(contactNo);
    }, 800); // Wait 800ms after user stops typing
}

function checkContactInParty(contactNo) {
    const messageDiv = $('#contact_validation_message');

    // Show loading state
    messageDiv.html('<i class="fa fa-spinner fa-spin"></i> <strong>Checking:</strong> Validating mobile number...')
        .removeClass('text-success text-warning text-danger')
        .addClass('text-info');

    $.ajax({
        url: '<?php echo site_url("admin/sales/check_contact_in_party"); ?>',
        type: 'POST',
        data: {
            contact_no: contactNo
        },
        dataType: 'json',
        success: function(response) {
            if (response.exists && response.party) {
                // Party found - auto-fill details
                messageDiv.html('<i class="fa fa-check-circle"></i> <strong>Party Found:</strong> ' +
                        response.party.name +
                        '<br><small>Address: ' + (response.party.address || 'Not specified') + '</small>')
                    .removeClass('text-info text-warning text-danger')
                    .addClass('text-success');

                // Style the input to show it's found
                $('#contact_no').addClass('party-found');

                // Auto-fill customer details
                $('#customer_name').val(response.party.name)
                    .prop('readonly', true)
                    .addClass('party-found');
                $('#party_id').val(response.party.id);

                // If address field exists, auto-fill it
                if ($('textarea[name="address"]').length && response.party.address) {
                    $('textarea[name="address"]').val(response.party.address);
                }

            } else {
                // Party not found - allow new customer creation
                messageDiv.html(
                        '<i class="fa fa-info-circle"></i> <strong>New Customer:</strong> This mobile number is not in party records.<br>' +
                        '<small>You can enter customer name below. New customer will be created.</small>')
                    .removeClass('text-info text-success text-danger')
                    .addClass('text-warning');

                // Style the input to show it's new
                $('#contact_no').addClass('party-not-found');

                // Enable manual customer name entry
                $('#customer_name').prop('readonly', false)
                    .removeClass('party-found')
                    .attr('placeholder', 'Enter customer name for new customer')
                    .focus();
            }
        },
        error: function(xhr, status, error) {
            messageDiv.html(
                    '<i class="fa fa-exclamation-triangle"></i> <strong>Error:</strong> Unable to validate mobile number. Please try again.'
                )
                .removeClass('text-info text-success text-warning')
                .addClass('text-danger');
            console.error('Validation error:', error);
        }
    });
}

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
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                            <div>
                                <h1>
                                    <i class="icon-plus-circle"
                                        style="color: #3498db; margin-right: 12px; font-size: 32px;"></i>
                                    Add New Sales
                                </h1>
                                <p>Create new sales record with customer details and product information</p>
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
                            <form action="<?php echo site_url('admin/sales/index')?>" method="post" class="modern-form">
                                <table class="table-modern sales-info-table">
                                    <tr>
                                        <th>SL No.</th>
                                        <td><input class="form-control" readonly="readonly" name="sl_no"
                                                value="<?php echo $trans_no; ?>" type="text"></td>

                                        <th>DATE</th>
                                        <td><input id="date" name="bill_date" type="text"></td>
                                    </tr>
                                    <tr>
                                        <th>Name OF PURCHASE</th>
                                        <td>
                                            <div id="cid">

                                                <select  id="customer_id"  class="chosen-select" name="customer_id">
                                                    <option value="">-Select customer-</option>
                                                    <?php foreach($customer as $pr){ ?>
                                                    <option value="<?php echo $pr['id']; ?>">
                                                        <?php echo $pr['name']; ?>
                                                        <?php if(!empty($pr['contact_no'])): ?>
                                                        - <?php echo $pr['contact_no']; ?>
                                                        <?php endif; ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                                <!-- <span style="padding-left: 30px"><a onclick="cn()"><i class="icon-plus"></i></a></span> -->


                                                <!-- Search functionality info -->
                                                <div
                                                    style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); padding: 8px 12px; margin: 8px 0; border: 1px solid #2196f3; border-radius: 6px; box-shadow: 0 2px 4px rgba(33,150,243,0.1);">
                                                    <small><strong><i class="icon-search" style="color: #1976d2;"></i>
                                                            Search Feature:</strong> Click dropdown and type to search
                                                        customers by name or contact number</small>
                                                </div>

                                                <!-- Commented out Add New Customer functionality -->
                                                <!-- 
                                                <span style="margin-left: 15px;">
                                                    <a onclick="cn()" class="btn-primary-gradient" style="padding: 8px 12px; font-size: 12px;">
                                                        <i class="icon-plus"></i> Add New Customer
                                                    </a>
                                                </span>
                                                -->
                                            </div>
                                        </td>
                                    </tr>

                                    <th>Payment Status</th>
                                    <td><select id="payment_status" onchange="sdisp(this.value)" name="payment_status">
                                            <option value="">-Select Type-</option>
                                            <option value="1">Paid</option>
                                            <option value="2">Un Paid</option>
                                        </select></td>
                                    </tr>

                                    <tr>
                                        <th>VEHICLE NUMBER</th>
                                        <td><input name="vehicle_number" type="text"></td>

                                        <th style="display:none;" class="pmdetails">Paid Amount</th>
                                        <td style="display:none;" class="pmdetails">
                                            <input type="text" name="paid_amount">
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>VEHICLE OWNER</th>
                                        <td><input name="vehicle_owner" type="text"></td>

                                        <th style="display:none;" class="pmdetails">Payment Type</th>
                                        <td style="display:none;" class="pmdetails">
                                            <input type="radio" name="type" value="1"> Cash
                                            <input type="radio" name="type" value="2"> Cheque
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>DELIVERY POINT ADDRESS</th>
                                        <td><textarea name="address"></textarea></td>

                                        <th style="display:none;" class="pmdetails">Payment Details</th>
                                        <td style="display:none;" class="pmdetails">
                                            <textarea name="paiddetails"></textarea>
                                        </td>
                                    </tr>
                                </table>
                        </div>
                    </div>

                    <!-- Item Details Container -->
                    <div class="data-table-container">
                        <div class="table-header">
                            <h3>
                                <i class="icon-list"></i>
                                Item Details
                            </h3>
                            <div class="table-controls">
                                <span>Grand Total: <strong id="grand_total_display">₹0.00</strong></span>
                            </div>
                        </div>

                        <div style="padding: 0;">
                            <table class="table-modern">
                                <thead>
                                    <tr>
                                        <th>PRODUCT</th>
                                        <th>QUANTITY</th>
                                        <th>RATE</th>
                                        <th>AMOUNT</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $sm=1; foreach ($products as $fm){?>
                                    <tr>
                                        <td><?php echo $fm['name'];?></td>
                                        <td><input name="prod[<?php echo $fm['id'];?>]" class="span2 quantity-input"
                                                type="number" step="0.01" min="0"
                                                data-product-id="<?php echo $fm['id'];?>"
                                                onkeyup="calculateAmount(<?php echo $fm['id'];?>)"
                                                onchange="calculateAmount(<?php echo $fm['id'];?>)"></td>
                                        <td><input name="rate[<?php echo $fm['id'];?>]" class="span2 rate-input"
                                                type="number" step="0.01" min="0"
                                                data-product-id="<?php echo $fm['id'];?>"
                                                onkeyup="calculateAmount(<?php echo $fm['id'];?>)"
                                                onchange="calculateAmount(<?php echo $fm['id'];?>)"></td>
                                        <td><input name="amount[<?php echo $fm['id'];?>]" class="span2 amount-input"
                                                type="number" step="0.01" min="0"
                                                data-product-id="<?php echo $fm['id'];?>" readonly></td>
                                    </tr>
                                    <?php } ?>

                                    <!-- Additional Charges Section -->
                                    <tr style="background-color: #f9f9f9;">
                                        <td colspan="3" align="right"><strong>Sub Total (Products):</strong></td>
                                        <td><input name="sub_total" id="sub_total" class="span2" type="number"
                                                step="0.01" readonly
                                                style="background-color: #e9ecef; font-weight: bold;"></td>
                                    </tr>

                                    <tr>
                                        <td colspan="3" align="right"><strong>Transportation Charge:</strong></td>
                                        <td><input name="transportation_charge" id="transportation_charge"
                                                class="span2 charge-input" type="number" step="0.01" min="0" value="0"
                                                onkeyup="calculateGrandTotal()" onchange="calculateGrandTotal()"
                                                placeholder="0.00"></td>
                                    </tr>

                                    <tr>
                                        <td colspan="3" align="right"><strong>Loading Charge:</strong></td>
                                        <td><input name="loading_charge" id="loading_charge" class="span2 charge-input"
                                                type="number" step="0.01" min="0" value="0"
                                                onkeyup="calculateGrandTotal()" onchange="calculateGrandTotal()"
                                                placeholder="0.00"></td>
                                    </tr>

                                    <tr class="total-row"
                                        style="background-color: #f5f5f5; font-weight: bold; border-top: 2px solid #ddd;">
                                        <td colspan="3" align="right"><strong>GRAND TOTAL:</strong></td>
                                        <td><input name="total_amount" id="total_amount" class="span2" type="number"
                                                step="0.01" readonly
                                                style="font-weight: bold; background-color: #d4edda; border: 2px solid #c3e6cb; font-size: 16px;">
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Submit Section -->
                    <div class="submit-section-container">
                        <div class="submit-buttons">
                            <button type="submit" class="btn-success-gradient">
                                <i class="icon-save"></i> Save Sales Record
                            </button>
                            <a href="<?= site_url('admin/sales/view_sales') ?>" class="btn-primary-gradient">
                                <i class="icon-remove"></i> Cancel
                            </a>
                        </div>
                        <div class="submit-help-text">
                            <i class="icon-info-circle"></i>
                            Please review all information before submitting the sales record.
                        </div>
                    </div>

                    </form>
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

    $(document).ready(function() {
        // Initialize Date Pickers (jQuery UI)
        $("#start_date, #end_date").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy'
        });

        // Initialize Chosen Select (after DOM and Chosen JS loaded)
     
    });
    </script>