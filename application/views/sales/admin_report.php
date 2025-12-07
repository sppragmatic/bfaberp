

<!-- Centralized Sales CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/sales-centralized.css'); ?>" />
<!-- Enhanced CSS and JavaScript Dependencies -->


<!-- Font Awesome Icons -->

<script>
$(document).ready(function() {
    $('#admin_report_table').DataTable({
        responsive: true,
        scrollX: true,
        scrollCollapse: true,
        "pageLength": 25,
        "order": [[ 2, "desc" ]],  // Sort by date desc
        "columnDefs": [
            { "orderable": false, "targets": [0] }, // Disable sorting on sequence column
            { "className": "text-center", "targets": [0, 2] },
            { "className": "text-right", "targets": [3, 4, 5] }
        ],
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "dom": '<"top-controls"<"left-controls"l><"center-controls"f><"right-controls"B>>rt<"bottom-controls"<"pagination-info"i><"pagination-nav"p>>',
        "language": {
            "lengthMenu": "Show _MENU_ entries per page",
            "zeroRecords": "No account transactions found matching your criteria",
            "info": "Showing _START_ to _END_ of _TOTAL_ transactions",
            "infoEmpty": "No transaction data available",
            "infoFiltered": "(filtered from _MAX_ total transactions)",
            "search": "Search account data:",
            "searchPlaceholder": "Search by customer, invoice, date...",
            "paginate": {
                "first": "First",
                "last": "Last", 
                "next": "Next",
                "previous": "Previous"
            }
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api();
            
            var intVal = function ( i ) {
                if (typeof i === 'number') {
                    return i;
                }
                
                if (typeof i === 'string') {
                    var cleanValue = i.replace(/<[^>]*>/g, '')
                                      .replace(/[\₹,\s]/g, '')
                                      .replace(/[^\d.-]/g, '');
                    
                    var num = parseFloat(cleanValue);
                    return isNaN(num) ? 0 : num;
                }
                
                return 0;
            };
            
            try {
                var pendingSum = 0;
                var givenSum = 0;
                var dueSum = 0;
                
                api.rows({ page: 'current' }).nodes().each(function(node) {
                    var $row = $(node);
                    
                    pendingSum += parseFloat($row.find('td:eq(3)').attr('data-value') || '0');
                    givenSum += parseFloat($row.find('td:eq(4)').attr('data-value') || '0');
                    dueSum += parseFloat($row.find('td:eq(5)').attr('data-value') || '0');
                });
                
                var formatCurrency = function(amount) {
                    if (isNaN(amount) || !isFinite(amount)) {
                        return '₹0.00';
                    }
                    return '₹' + Number(amount).toLocaleString('en-IN', {
                        minimumFractionDigits: 2, 
                        maximumFractionDigits: 2
                    });
                };
                
                $(api.column(3).footer()).html('<strong>' + formatCurrency(pendingSum) + '</strong>');
                $(api.column(4).footer()).html('<strong>' + formatCurrency(givenSum) + '</strong>');
                $(api.column(5).footer()).html('<strong>' + formatCurrency(dueSum) + '</strong>');
                
            } catch (e) {
                console.error('Error calculating totals:', e);
                $(api.column(3).footer()).html('₹0.00');
                $(api.column(4).footer()).html('₹0.00');
                $(api.column(5).footer()).html('₹0.00');
            }
        }
    });

    // Print functionality
    $('#printReport').click(function() {
        window.print();
    });
    
    // Enhance search input
    $('.dataTables_filter input').attr('placeholder', 'Search by customer, invoice, date...');
    
    $('.dataTables_filter input').on('keyup', function() {
        var value = $(this).val();
        if (value.length > 0) {
            $(this).css('background-color', '#e8f5e8');
        } else {
            $(this).css('background-color', 'white');
        }
    });
});
</script>



<div class="admin-sales-view">
    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12">

                        <!-- Alert Messages -->
                        <?php if($this->session->flashdata('msg')): ?>
                        <div class="alert alert-success no-print">
                            <strong>Success!</strong> <?php echo $this->session->flashdata('msg'); ?>
                        </div>
                        <?php endif; ?>

                        <!-- Enhanced Filter Panel -->
                     <div class="search_panel">
                        <h3 class="search_header">SALES ACCOUNT REPORT122</h3>

                        <div class="search_conent">


                            <form id="user_sch" action="<?php echo site_url("admin/sales/getreport");?>"
                                enctype="multipart/form-data" method="post">

                                <div class="row">


                                    <div class="span3">
                                        <div class="form-group">


                                            <label for="text1" class="control-label col-lg-4">Select Party</label>
                                            <select id="customer_id" class="chosen-select" required="required"
                                                name="customer_id">
                                                <option value="0">-Select Party-</option>
                                                <?php foreach($customer as $pr){ ?>
                                                <option value="<?php echo $pr['id']; ?>"><?php echo $pr['name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="span3">
                                        <div class="form-group">

                                            <td>
                                                <label for="text1" class="control-label col-lg-4">All Branch</label>
                                                <select id="branch_id" name="branch_id">
                                                    <option value="0">-Select Branch-</option>
                                                    <?php foreach($branch as $br){ ?>
                                                    <option value="<?php echo $br['id']; ?>"><?php echo $br['name']; ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </div>
                                    </div>

                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">Start Date</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="start_date" name="start_date"
                                                    class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="row">
                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">End Date</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="end_date" name="end_date" class="form-control">
                                            </div>
                                        </div>

                                    </div>



                                    <div class="span2"><br />
                                        <input type="submit" id="tags" value="Search" class="btn btn-primary" />
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="<?= site_url('admin/sales/index') ?>" class="btn btn-report">
                            <i class="icon-plus icon-white"></i> New Sales
                        </a>
                        <button type="button" id="printReport" class="btn btn-report">
                            <i class="icon-print icon-white"></i> Print Report
                        </button>
                    </div>
                  
                    <!-- Enhanced Table Container -->
                    <div class="table-responsive">
                        <table id="admin_report_table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">SL NO.</th>
                                    <th style="width: 150px;">DATE</th>
                                    <th style="width: 150px;">CUSTOMER NAME</th>
                                    <th style="width: 200px;">DESCRIPTION</th>
                                    <th style="width: 120px;">PENDING</th>
                                    <th style="width: 120px;">GIVEN</th>
                                    <th style="width: 120px;">DUE</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php 
                                    $sequence = 1;
                                    $tc = 0;
                                    $td = 0;
                                    foreach ($sales as $fm){
                                        $tc = $tc + $fm['credit'];
                                        $td = $td + $fm['debit'];
                                        $due_amount = ($fm['credit'] != 0) ? ($fm['credit'] - $fm['debit']) : 0;
                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $sequence++; ?></td>
                                            <td class="text-center"><?php echo date('d-m-Y', strtotime($fm['entry_date'])); ?></td>
                                            <td><?php echo htmlspecialchars($fm['customername']); ?></td>
                                            <td><?php echo !empty($fm['details']) ? htmlspecialchars($fm['details']) : '<span class="text-muted">-</span>'; ?></td>
                                            <td class="text-right amount-positive">₹<?php echo number_format($fm['credit'], 2); ?></td>
                                            <td class="text-right amount-negative">₹<?php echo number_format($fm['debit'], 2); ?></td>
                                            <td class="text-right">
                                                <?php if($fm['credit'] != 0): ?>
                                                    <span class="<?php echo $due_amount > 0 ? 'amount-positive' : ($due_amount < 0 ? 'amount-negative' : 'amount-neutral'); ?>">
                                                        <strong>₹<?php echo number_format($due_amount, 2); ?></strong>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="amount-neutral">------</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th class="text-center">
                                            <i class="icon-sigma"></i>
                                        </th>
                                        <th class="text-center">
                                            <strong>TOTALS</strong>
                                        </th>
                                        <th class="text-center">
                                            <small><?php echo count($sales); ?> Records</small>
                                        </th>
                                        <th class="text-right">
                                            <strong>₹<?php echo number_format($tc, 2); ?></strong>
                                        </th>
                                        <th class="text-right">
                                            <strong>₹<?php echo number_format($td, 2); ?></strong>
                                        </th>
                                        <th class="text-right">
                                            <strong>₹<?php echo number_format($tc - $td, 2); ?></strong>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <!-- Summary Cards -->
                        <div class="row" style="margin-top: 20px;">
                            <div class="span4">
                                <div style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; padding: 15px; border-radius: 8px; text-align: center;">
                                    <h4 style="margin: 0; color: white;">Total Pending</h4>
                                    <h3 style="margin: 5px 0 0 0; color: white;">₹<?php echo number_format($tc, 2); ?></h3>
                                </div>
                            </div>
                            <div class="span4">
                                <div style="background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%); color: white; padding: 15px; border-radius: 8px; text-align: center;">
                                    <h4 style="margin: 0; color: white;">Total Given</h4>
                                    <h3 style="margin: 5px 0 0 0; color: white;">₹<?php echo number_format($td, 2); ?></h3>
                                </div>
                            </div>
                            <div class="span4">
                                <div style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: white; padding: 15px; border-radius: 8px; text-align: center;">
                                    <h4 style="margin: 0; color: white;">Net Due</h4>
                                    <h3 style="margin: 5px 0 0 0; color: white;">₹<?php echo number_format($tc - $td, 2); ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(function() {
    // Enhanced date picker configuration
    $("#start_date, #end_date").datepicker();

    // Add clear date functionality
 
})
// Clear date function
function clearDate(button) {
    $(button).prev('.form-control').val('').datepicker('setDate', null);
    $(button).closest('.form-group').removeClass('has-error has-success');
}
</script>


