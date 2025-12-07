<link rel="stylesheet" href="<?php echo base_url();?>assets/css/sales-centralized.css">

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
                        <h3 class="search_header">VIEW SALES</h3>

                        <div class="search_conent">

                            <form id="user_sch" action="<?php echo site_url("admin/sales/search_sales");?>"
                                enctype="multipart/form-data" method="post">


                                <div class="row">
                                    <div class="span3">
                                        <div class="form-group">


                                            <label for="text1" class="control-label col-lg-4">Select Branch</label>
                                            <select id="branch_id" name="branch_id">
                                                <option value="0">-Select Branch-</option>
                                                <?php foreach($branch as $br){ ?>
                                                <option <?php if($br['id']==$branch_id){ ?> selected="selected"
                                                    <?php } ?> value="<?php echo $br['id']; ?>">
                                                    <?php echo $br['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="span3">
                                        <div class="form-group">

                                            <td>
                                                <label for="text1" class="control-label col-lg-4">Select Party</label>
                                                <select id="customer_id" class="chosen-select"
                                                    style="height:500px !important;" name="customer_id">
                                                    <option value="0">-Select Party-</option>
                                                    <?php foreach($customer as $pr){ ?>
                                                    <option <?php if($pr['id']==$customer_id){ ?> selected="selected"
                                                        <?php } ?> value="<?php echo $pr['id']; ?>">
                                                        <?php echo $pr['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </div>
                                    </div>

                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">Start Date</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="start_date" value="<?php echo $start_date; ?>"
                                                    name="start_date" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="row">
                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">End Date</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="end_date" value="<?php echo $end_date; ?>"
                                                    name="end_date" class="form-control">
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
                    <p class="pull-right ">

                        <a href="<?= site_url('admin/sales/index') ?>"><input type="button" value="New Sales"
                                class="btn btn-primary"> </a>
                    </p>
                    <!-- Enhanced Admin Sales Data Table -->
                    <div class="table-responsive">
                        <table id="admin_sales_table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">SL NO.</th>
                                    <th style="width: 100px;">DATE</th>
                                    
                                    <th style="width: 150px;">CUSTOMER NAME</th>
                                    <th style="width: 100px;">AMOUNT</th>
                                    <th style="width: 80px;">Status</th>
                                    <th style="width: 220px;">Products & Quantity</th>
                                    <th style="width: 150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sm = 1; foreach ($sales as $fm) {
                                    $allitem = $fm['allitem'];
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $sm++; ?></td>
                                    <td class="text-center"><?php echo date('d-m-Y', strtotime($fm['bill_date'])); ?>
                                    </td>
                                   
                                    <td><?php echo $fm['customername']; ?></td>
                                    <td class="text-right amount-positive">
                                        ₹<?php echo number_format($fm['total_amount'], 2); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($fm['payment_status'] == 2) { ?>
                                        <span class="status-badge status-unpaid">UNPAID</span>
                                        <?php } ?>
                                        <?php if($fm['payment_status'] == 1) { ?>
                                        <span class="status-badge status-paid">PAID</span>
                                        <?php } ?>
                                    </td>
                                                                        <td>
                                                                            <?php 
                                                                                $product_list = array();
                                                                                foreach ($allitem as $am) {
                                                                                    if (!empty($am['stock'])) {
                                                                                        $product_list[] = '<span style="color:#1565c0;font-weight:bold;">' . htmlspecialchars($am['name']) . '</span> <span style="color:#388e3c;">(' . number_format($am['stock'],2) . ')</span>';
                                                                                    }
                                                                                }
                                                                                $products_str = implode(', ', $product_list);
                                                                                if ($fm['payment_status'] == 0) {
                                                                                    echo $products_str ? $products_str . ' <span class="status-badge status-unpaid">UNPAID</span>' : '<span class="status-badge status-unpaid">UNPAID</span>';
                                                                                } else {
                                                                                    echo $products_str;
                                                                                }
                                                                            ?>
                                                                        </td>
                                    <td class="text-center">
                                        <?php if($fm['trash'] == 0) { ?>
                                        <?php if($fm['status'] == 0) { ?>
                                        <a href="<?php echo site_url('admin/sales/edit_sales')."/".$fm['id']; ?>"
                                            class="action-btn btn-edit" title="Edit Sale">
                                            <i class="icon-edit"></i>
                                        </a>
                                        <a href="<?php echo site_url('admin/sales/delete')."/".$fm['id']; ?>"
                                            class="action-btn btn-delete" title="Delete Sale"
                                            onclick="return confirm('Are you sure you want to delete this sale?')">
                                            <i class="icon-trash"></i>
                                        </a>
                                        <a href="<?php echo site_url('admin/sales/approve')."/".$fm['id']; ?>"
                                            class="action-btn btn-approve" title="Approve Sale">
                                            <i class="icon-ok"></i>
                                        </a>
                                        <?php } else { ?>
                                        <span class="status-badge status-paid">Approved</span>
                                        <a href="<?php echo site_url('admin/sales/chalan')."/".$fm['id']; ?>"
                                            class="action-btn btn-print" title="Print Challan">
                                            <i class="icon-print"></i>
                                        </a>
                                        <?php if($this->session->userdata('user_id') == 1) { ?>
                                        <a href="<?php echo site_url('admin/sales/edit_sales')."/".$fm['id']; ?>"
                                            class="action-btn btn-edit" title="Edit Sale">
                                            <i class="icon-edit"></i>
                                        </a>
                                        <a href="<?php echo site_url('admin/sales/delete')."/".$fm['id']; ?>"
                                            class="action-btn btn-delete" title="Delete Sale"
                                            onclick="return confirm('Are you sure you want to delete this sale?')">
                                            <i class="icon-trash"></i>
                                        </a>
                                        <?php } ?>
                                        <?php } ?>
                                        <?php } ?>
                                        <?php if($fm['trash'] == 1) { ?>
                                        <span class="text-danger"><strong>DELETED</strong></span>
                                        <!-- <a href="<?php echo site_url('admin/sales/activate')."/".$fm['id']; ?>"
                                            class="action-btn btn-approve" title="Activate Sale">
                                            <i class="icon-repeat"></i>
                                        </a> -->
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                           
                        </table>
                    </div>



                    <!-- <?php echo $pagination; ?> -->

                    <div id="main-table">


                        <div class="pull-right">


                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Enhanced JavaScript Dependencies -->

<script type="text/javascript">
// Enhanced Admin Sales JavaScript - Aligned with Financial Report

function clearFilters() {
    var table = $('#admin_sales_table').DataTable();
    table.search('').columns().search('').draw();
    $('.dataTables_filter input').val('').trigger('input');

    // Add visual feedback
    $('.dataTables_filter input').addClass('clearing');
    setTimeout(function() {
        $('.dataTables_filter input').removeClass('clearing');
    }, 300);

    showMessage('Filters cleared successfully', 'info');
}

function showMessage(text, type) {
    // Create toast-style message
    var alertClass = 'alert-' + (type || 'info');
    var message = $('<div class="alert ' + alertClass +
        ' alert-dismissible fade show" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">' +
        '<strong>' + text + '</strong>' +
        '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
        '</div>');

    $('body').append(message);

    // Auto-remove after 3 seconds
    setTimeout(function() {
        message.alert('close');
    }, 3000);
}

function exportToCSV() {
    var table = $('#admin_sales_table').DataTable();
    var data = table.rows({
        search: 'applied'
    }).data();

    if (data.length === 0) {
        showMessage('No data to export', 'warning');
        return;
    }

    var csv = 'SL NO,Date,Vehicle No,Vehicle Owner,Customer Name,Amount,Status\n';

    data.each(function(row) {
        // Extract basic data from row (adjust indexes as needed)
        var rowData = [
            $(row[0]).text() || row[0], // SL NO
            $(row[1]).text() || row[1], // Date
            $(row[2]).text() || row[2], // Vehicle No
            $(row[3]).text() || row[3], // Vehicle Owner
            $(row[4]).text() || row[4], // Customer
            $(row[5]).text() || row[5], // Amount
            $(row[6]).text() || row[6] // Status
        ];
        csv += rowData.join(',') + '\n';
    });

    var blob = new Blob([csv], {
        type: 'text/csv'
    });
    var url = window.URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'admin_sales_report_' + new Date().toISOString().slice(0, 10) + '.csv';
    a.click();
    window.URL.revokeObjectURL(url);

    showMessage('CSV export completed successfully', 'success');
}

function printTable() {
    var table = $('#admin_sales_table').DataTable();
    var tableHtml = table.table().container().outerHTML;

    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Admin Sales Report</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin: 20px 0; }');
    printWindow.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
    printWindow.document.write('th { background-color: #f8f9fa; font-weight: bold; }');
    printWindow.document.write('tr:nth-child(even) { background-color: #f9f9f9; }');
    printWindow.document.write(
        '@media print { .dataTables_wrapper > div:not(.table-responsive) { display: none !important; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<h2>Admin Sales Report - ' + new Date().toLocaleDateString() + '</h2>');
    printWindow.document.write(tableHtml);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

$(document).ready(function() {
    // Initialize Date Pickers (jQuery UI)
    $("#start_date, #end_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy'
    });

    // Initialize Chosen Select
    var config = {
        '.chosen-select': {
            width: "100%"
        },
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
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }

    // Initialize the Enhanced DataTable
    var table = $('#admin_sales_table').DataTable({
        "responsive": true,
        "processing": true,
        "lengthMenu": [
            [10, 25, 50, 100, 250, -1],
            [10, 25, 50, 100, 250, "All"]
        ],
        "pageLength": 25,
        "dom": '<"top-controls"<"left-controls"l><"center-controls"><"right-controls"f>>rt<"bottom-controls"<"left-info"i><"right-pagination"p>>',
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "search": "Search:",
            "searchPlaceholder": "Search all columns...",
            "zeroRecords": "No matching admin sales records found",
            "info": "Showing _START_ to _END_ of _TOTAL_ records",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "processing": "Loading admin sales data...",
            "paginate": {
                "first": "«",
                "last": "»",
                "next": "›",
                "previous": "‹"
            },
            "emptyTable": "No admin sales data available",
            "loadingRecords": "Loading..."
        },
        "order": [
            [1, "desc"]
        ], // Order by date column
        "columnDefs": [{
                "targets": [-1], // Action column
                "orderable": false,
                "searchable": false,
                "width": "150px"
            },
            {
                "targets": [5], // Amount column
                "className": "text-right",
                "render": function(data, type, row) {
                    if (type === 'display' && data) {
                        // Extract numeric value from formatted currency
                        var numVal = data.toString().replace(/[₹,\s]/g, '');
                        if (!isNaN(numVal) && numVal !== '') {
                            return '₹' + parseFloat(numVal).toLocaleString('en-IN', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    }
                    return data || '₹0.00';
                }
            },
            {
                "targets": [0], // SL NO column
                "width": "60px",
                "className": "text-center"
            },
            {
                "targets": [1], // Date column
                "width": "100px",
                "className": "text-center"
            }
        ],
        "footerCallback": function(row, data, start, end, display) {
            var api = this.api();

            // Helper function to get numeric value from formatted currency
            var numVal = function(i) {
                var val = typeof i === 'string' ?
                    i.replace(/[\₹,\s]/g, '') :
                    typeof i === 'number' ? i : 0;
                return parseFloat(val) || 0;
            };

            // Calculate total amount for visible (filtered) data
            var totalAmount = api.column(5, {
                    page: 'current'
                }).data()
                .reduce(function(a, b) {
                    return numVal(a) + numVal(b);
                }, 0);

            // Format currency function
            var formatCurrency = function(amount) {
                return '₹' + amount.toLocaleString('en-IN', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            };

            // Update footer with total
            $('#total_amount_footer').html('<strong>' + formatCurrency(totalAmount) + '</strong>');

            // Product totals removed: no product columns in table
        },
        "drawCallback": function(settings) {
            // Re-initialize tooltips after each draw
            $('[data-toggle="tooltip"]').tooltip();

            // Add row hover effects
            $('#admin_sales_table tbody tr').hover(
                function() {
                    $(this).addClass('table-hover-highlight');
                },
                function() {
                    $(this).removeClass('table-hover-highlight');
                }
            );

            // Update record count display
            var api = this.api();
            var recordsTotal = api.page.info().recordsTotal;
            var recordsDisplay = api.page.info().recordsDisplay;

            if (recordsDisplay !== recordsTotal) {
                $('.dataTables_info').append(
                    ' <span class="badge badge-info">Filtered</span>'
                );
            }
        },
        "initComplete": function() {
            var api = this.api();

            // Enhanced search input styling
            $('.dataTables_filter input')
                .attr('placeholder', '🔍 Search admin sales records...')
                .addClass('form-control-search');

            // Add enhanced control buttons
            $('.dataTables_filter').after(
                '<div class="table-actions ml-3">' +
                '<button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearFilters()" title="Clear all filters">' +
                '<i class="fa fa-eraser"></i> Clear' +
                '</button>' +
                '<button type="button" class="btn btn-sm btn-outline-success ml-2" onclick="exportToCSV()" title="Export to CSV">' +
                '<i class="fa fa-download"></i> Export' +
                '</button>' +
                '<button type="button" class="btn btn-sm btn-outline-primary ml-2" onclick="printTable()" title="Print table">' +
                '<i class="fa fa-print"></i> Print' +
                '</button>' +
                '</div>'
            );

            // Adjust controls layout
            $('.top-controls .right-controls').css({
                'display': 'flex',
                'align-items': 'center',
                'gap': '10px'
            });

            // Add loading overlay functionality
            $('#admin_sales_table').on('processing.dt', function(e, settings, processing) {
                if (processing) {
                    $('.dataTables_wrapper').addClass('loading');
                } else {
                    $('.dataTables_wrapper').removeClass('loading');
                }
            });
        }
    });

    // Add search input enhancements
    $('.dataTables_filter input').on('input', function() {
        var val = $(this).val();
        if (val.length > 0) {
            $(this).addClass('has-content');
        } else {
            $(this).removeClass('has-content');
        }
    });

    // Add keyboard shortcuts
    $(document).on('keydown', function(e) {
        if (e.ctrlKey) {
            switch (e.which) {
                case 70: // Ctrl+F for search
                    e.preventDefault();
                    $('.dataTables_filter input').focus();
                    break;
                case 69: // Ctrl+E for export
                    e.preventDefault();
                    exportToCSV();
                    break;
                case 80: // Ctrl+P for print
                    e.preventDefault();
                    printTable();
                    break;
            }
        }

        if (e.key === 'Escape') {
            $('.dataTables_filter input').blur();
            clearFilters();
        }
    });

    // Show keyboard shortcuts help
    console.log('Admin Sales View Keyboard Shortcuts:');
    console.log('Ctrl+F: Focus search box');
    console.log('Ctrl+E: Export to CSV');
    console.log('Ctrl+P: Print table');
    console.log('Escape: Clear filters');
});
</script>