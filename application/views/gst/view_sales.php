<!-- Enhanced CSS for Professional Design -->


<script type="text/javascript">
function clearFilters() {
    var table = $('#form_table').DataTable();
    table.search('').columns().search('').draw();
    $('.dataTables_filter input').val('').trigger('input');
    showMessage('Filters cleared successfully', 'info');
}

function showMessage(text, type) {
    var alertClass = 'alert-' + (type || 'info');
    var message = $('<div class="alert ' + alertClass +
        ' alert-dismissible fade show" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">' +
        '<strong>' + text + '</strong>' +
        '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
        '</div>');

    $('body').append(message);
    setTimeout(function() {
        message.alert('close');
    }, 3000);
}

function exportToCSV() {
    var table = $('#form_table').DataTable();
    var data = table.rows({
        search: 'applied'
    }).data();

    if (data.length === 0) {
        showMessage('No data to export', 'warning');
        return;
    }

    var csv = 'SL NO,Date,Vehicle No,Vehicle Owner,Customer Name,Amount,Status\n';
    data.each(function(row) {
        var rowData = [
            $(row[0]).text() || row[0],
            $(row[1]).text() || row[1],
            $(row[2]).text() || row[2],
            $(row[3]).text() || row[3],
            $(row[4]).text() || row[4],
            $(row[5]).text() || row[5],
            $(row[6]).text() || row[6]
        ];
        csv += rowData.join(',') + '\n';
    });

    var blob = new Blob([csv], {
        type: 'text/csv'
    });
    var url = window.URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'gst_sales_report_' + new Date().toISOString().slice(0, 10) + '.csv';
    a.click();
    window.URL.revokeObjectURL(url);

    showMessage('CSV export completed successfully', 'success');
}

function printTable() {
    var table = $('#form_table').DataTable();
    var tableHtml = table.table().container().outerHTML;

    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>GST Sales Report</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin: 20px 0; }');
    printWindow.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
    printWindow.document.write('th { background-color: #f8f9fa; font-weight: bold; }');
    printWindow.document.write('tr:nth-child(even) { background-color: #f9f9f9; }');
    printWindow.document.write(
        '@media print { .dataTables_wrapper > div:not(.table-responsive) { display: none !important; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<h2>GST Sales Report - ' + new Date().toLocaleDateString() + '</h2>');
    printWindow.document.write(tableHtml);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

$(document).ready(function() {
    var table = $('#form_table').DataTable({
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
            "searchPlaceholder": "Search all GST sales...",
            "zeroRecords": "No matching records found",
            "info": "Showing _START_ to _END_ of _TOTAL_ records",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "processing": "Loading data...",
            "paginate": {
                "first": "«",
                "last": "»",
                "next": "›",
                "previous": "‹"
            }
        },
        "order": [
            [1, "desc"]
        ],
        "columnDefs": [{
                "targets": [7], // Action column
                "orderable": false,
                "searchable": false,
                "width": "200px"
            },
            {
                "targets": [5], // Amount column
                "className": "text-right",
                "render": function(data, type, row) {
                    if (type === 'display' && data && !isNaN(data)) {
                        return '₹' + parseFloat(data).toLocaleString('en-IN', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    }
                    return data || '₹0.00';
                }
            },
            {
                "targets": [0], // SL NO column
                "width": "80px",
                "className": "text-center"
            }
        ],
        "initComplete": function() {
            if (!$('.table-actions').length) {
                var tableActions = $(
                    '<div class="table-actions" style="margin: 15px 0; text-align: right;">' +
                    '<button type="button" class="btn btn-info btn-sm" onclick="clearFilters()" title="Clear all filters">' +
                    '<i class="icon-refresh"></i> Clear Filters' +
                    '</button> ' +
                    '<button type="button" class="btn btn-success btn-sm" onclick="exportToCSV()" title="Export to CSV">' +
                    '<i class="icon-download-alt"></i> Export CSV' +
                    '</button> ' +
                    '<button type="button" class="btn btn-primary btn-sm" onclick="printTable()" title="Print table">' +
                    '<i class="icon-print"></i> Print' +
                    '</button>' +
                    '</div>');

                $('#form_table_wrapper').before(tableActions);
            }
        }
    });

    $('select').chosen({
        width: '100%',
        placeholder_text_single: 'Select an option'
    });
});
</script>

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
                        <h3 class="search_header">View Sales</h3>

                        <div class="search_conent">


                            <form id="user_sch" action="<?php echo site_url("admin/sales/search_sales");?>"
                                enctype="multipart/form-data" method="post">


                                <div class="row">

                                    <div class="span3">
                                        <div class="form-group">

                                            <td>
                                                <label for="text1" class="control-label col-lg-4">Select Party</label>
                                                <select id="customer_id" class="chosen-select" name="customer_id">
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




                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">End Date</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="end_date" value="<?php echo $end_date; ?>"
                                                    name="end_date" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="span2"><br />
                                        <input type="submit" id="tags" value="Search" class="btn btn-primary" />
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <p class="pull-right ">

                        <a href="<?= site_url('admin/gst/index') ?>"><input type="button" value="New Sales"
                                class="btn btn-primary"> </a>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">


                            <thead>
                                <tr>
                                    <th>SL NO.</th>
                                    <th>DATE</th>
                                    <th>VEHICLE NO</th>
                                    <th>VEHICLE OWNER</th>
                                    <th>CUSTOMER NAME</th>
                                    <th>AMOUNT</th>
                                    <th>Status</th>
                                    <?php  foreach ($products as $pm){?>
                                    <th style="color: red"><?php echo $pm['name'];?></th>
                                    <?php }?>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $sm=1; foreach ($sales as $fm){
		$allitem = $fm['allitem'];
	?>
                                <tr>
                                    <td><?php echo $fm['sl_no'];?></td>
                                    <td><?php echo $fm['bill_date'];?></td>
                                    <td><?php echo $fm['vehicle_number'];?></td>
                                    <td><?php echo $fm['vehicle_owner'];?></td>
                                    <td><?php echo $fm['customername'];?></td>
                                    <td><?php echo $fm['total_amount'];?></td>
                                    <td><?php if($fm['payment_status']==0){ ?> UNPAID <?php } ?>
                                        <?php if($fm['payment_status']==1){ ?> PAID <?php } ?></td>
                                    <?php  foreach ($allitem as $am){?>
                                    <td style="color: red"><b><?php echo $am['stock'];?></b></td>
                                    <?php }?>
                                    <td>
                                        <?php if($fm['trash']==0){ ?>

                                        <?php if($fm['status']==0){ ?>
                                        <a href="<?php echo site_url('admin/gst/edit_sales')."/".$fm['id']; ?>">Edit</a>
                                        &nbsp; | &nbsp;<a
                                            href="<?php echo site_url('admin/gst/delete')."/".$fm['id']; ?>">Delete</a>
                                        |
                                        &nbsp;<a
                                            href="<?php echo site_url('admin/gst/approve')."/".$fm['id']; ?>">APPROVE</a>
                                        <?php }else{ ?>
                                        APPROVED | &nbsp;<a
                                            href="<?php echo site_url('admin/gst/chalan')."/".$fm['id']; ?>">PRINT</a>
                                        <?php } ?>
                                        <?php } ?>
                                        <?php if($fm['trash']==1){ ?>
                                        DELETED
                                        <?php } ?>

                                    </td>
                                </tr>
                                <?php } ?>


                            </tbody>


                        </table>
                    </div>


                    <?php echo $pagination; ?>

                    <div id="main-table">


                        <div class="pull-right">


                        </div>

                    </div>

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
});
</script>

<script type="text/javascript">
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
}
for (var selector in config) {
    $(selector).chosen(config[selector]);
}
</script>