<link rel="stylesheet" href="<?php echo base_url();?>assets/css/sales-centralized.css">


<script>
$(document).ready(function() {
    $('#form_table').DataTable({
        responsive: true,
        scrollX: true,
        scrollCollapse: true,
        "pageLength": 25,
        "order": [
            [1, "desc"]
        ],
        "columnDefs": [{
            "orderable": false,
            "targets": [-1]
        }],
        "lengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ],
        "dom": '<"top-controls"<"left-controls"l><"center-controls"f><"right-controls"B>>rt<"bottom-controls"<"pagination-info"i><"pagination-nav"p>>',
        "language": {
            "lengthMenu": "Show _MENU_ entries per page",
            "zeroRecords": "No sales data found matching your criteria",
            "info": "Showing _START_ to _END_ of _TOTAL_ sales transactions",
            "infoEmpty": "No sales data available",
            "infoFiltered": "(filtered from _MAX_ total transactions)",
            "search": "Search sales data:",
            "searchPlaceholder": "Search by customer, party, invoice...",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        }
    });
});
</script>




<div class="sales-summary">
    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12">

                        <!-- Alert Messages -->
                        <?php if($this->session->flashdata('msg')): ?>
                        <div class="alert alert-success no-print">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> <?php echo $this->session->flashdata('msg'); ?>
                        </div>
                        <?php endif; ?>

                        <!-- Enhanced Sales Summary Filter Panel -->
                        <div class="search_panel no-print">
                            <h3 class="search_header">📊 Sales Summary Analytics</h3>

                            <div class="search_conent">
                                <form id="summary_search" action="<?php echo site_url("admin/sales/getsummery");?>"
                                    enctype="multipart/form-data" method="post">
                                    <div class="row">
                                        <div class="span3">
                                            <div class="form-group">
                                                <label for="customer_id" class="control-label">
                                                    <i class="fa fa-user"></i> Select Party
                                                </label>
                                                <select id="customer_id" class="chosen-select" name="customer_id">
                                                    <option value="0">-All Parties-</option>
                                                    <?php foreach($customer as $pr): ?>
                                                    <option value="<?php echo $pr['id']; ?>">
                                                        <?php echo $pr['name']; ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="span3">
                                            <div class="form-group">
                                                <label for="branch_id" class="control-label">
                                                    <i class="fa fa-building"></i> Select Branch
                                                </label>
                                                <select id="branch_id" name="branch_id" class="form-control">
                                                    <option value="0">-All Branches-</option>
                                                    <?php foreach($branch as $br): ?>
                                                    <option value="<?php echo $br['id']; ?>">
                                                        <?php echo $br['name']; ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="span3">
                                            <div class="form-group">
                                                <label for="start_date" class="control-label">
                                                    <i class="fa fa-calendar"></i> Start Date
                                                </label>
                                                <input type="text" id="start_date" name="start_date" class="form-control">
                                            </div>
                                        </div>

                                        <div class="span3">
                                            <div class="form-group">
                                                <label for="end_date" class="control-label">
                                                    <i class="fa fa-calendar"></i> End Date
                                                </label>
                                                <input type="text" id="end_date" name="end_date" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Professional Button Container -->
                                    <div class="row">
                                        <div class="span12">
                                            <div class="button-container" style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 15px 0; border-top: 2px solid #f1f3f4;">
                                                <!-- Filter Action Buttons -->
                                                <div class="filter-buttons" style="display: flex; gap: 15px; align-items: center;">
                                                    <input type="submit" id="search_btn" value="📈 Generate Summary Report" class="btn btn-primary" style="margin: 0;" />
                                                    <input type="button" id="reset_btn" value="🔄 Reset Filters" class="btn btn-secondary" onclick="resetForm()" style="margin: 0;" />
                                                </div>
                                                
                                                <!-- Report Action Buttons -->
                                                <div class="report-buttons" style="display: flex; gap: 10px; align-items: center;">
                                                    <input type="button" value="🖨️ Print Report" class="btn btn-success" onclick="PrintDiv();" style="margin: 0;" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Action Buttons -->


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(function() {
    // Initialize date pickers
    $("#start_date, #end_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
        showButtonPanel: true
    });


    // Initialize chosen select
    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {
            allow_single_deselect: true
        },
        '.chosen-select-no-single': {
            disable_search_threshold: 10
        },
        '.chosen-select-no-results': {
            no_results_text: 'Oops, nothing found!'
        },
        '.chosen-select-width': {
            width: "95%"
        }
    };

 
    // Print functionality
    $('#print_report').click(function() {
        window.print();
    });
});

// Reset form function
function resetForm() {
    $('#summary_search')[0].reset();
    $('.chosen-select').val('').trigger('chosen:updated');
    $('#start_date, #end_date').val('');
}


</script>