<!-- Enhanced CSS for Professional Design -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/standardized_view.css">
<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/font/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/chosen/chosen.min.css">
<script src="<?php echo base_url();?>assets/chosen/chosen.jquery.min.js"></script>


<script type="text/javascript">
function clearFilters() {
    var table = $('#form_table').DataTable();
    table.search('').columns().search('').draw();
    $('.dataTables_filter input').val('').trigger('input');
    showMessage('Filters cleared successfully', 'info');
}

function showMessage(text, type) {
    var alertClass = 'alert-' + (type || 'info');
    var message = $('<div class="alert ' + alertClass + ' alert-dismissible fade show" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">' +
        '<strong>' + text + '</strong>' +
        '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
        '</div>');
    
    $('body').append(message);
    setTimeout(function() { message.alert('close'); }, 3000);
}

function exportToCSV() {
    var table = $('#form_table').DataTable();
    var data = table.rows({search: 'applied'}).data();
    
    if (data.length === 0) {
        showMessage('No data to export', 'warning');
        return;
    }
    
    var csv = 'Date,Credit,Debit\n';
    data.each(function(row) {
        var rowData = [
            $(row[0]).text() || row[0],
            $(row[1]).text() || row[1],
            $(row[2]).text() || row[2]
        ];
        csv += rowData.join(',') + '\n';
    });
    
    var blob = new Blob([csv], { type: 'text/csv' });
    var url = window.URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'account_report_' + new Date().toISOString().slice(0, 10) + '.csv';
    a.click();
    window.URL.revokeObjectURL(url);
    
    showMessage('CSV export completed successfully', 'success');
}

function printTable() {
    var table = $('#form_table').DataTable();
    var tableHtml = table.table().container().outerHTML;
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Account Report</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin: 20px 0; }');
    printWindow.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
    printWindow.document.write('th { background-color: #f8f9fa; font-weight: bold; }');
    printWindow.document.write('tr:nth-child(even) { background-color: #f9f9f9; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<h2>Account Report - ' + new Date().toLocaleDateString() + '</h2>');
    printWindow.document.write(tableHtml);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

$(document).ready(function() {
    var table = $('#form_table').DataTable({
        "responsive": true,
        "processing": true,
        "lengthMenu": [[10, 25, 50, 100, 250, -1], [10, 25, 50, 100, 250, "All"]],
        "pageLength": 25,
        "dom": '<"top-controls"<"left-controls"l><"center-controls"><"right-controls"f>>rt<"bottom-controls"<"left-info"i><"right-pagination"p>>',
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "search": "Search:",
            "searchPlaceholder": "Search account records...",
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
        "order": [[0, "desc"]],
        "columnDefs": [
            {
                "targets": [3],
                "orderable": false,
                "searchable": false,
                "width": "150px"
            },
            {
                "targets": [1, 2],
                "className": "text-right"
            }
        ],
        "initComplete": function() {
            if (!$('.table-actions').length) {
                var tableActions = $('<div class="table-actions" style="margin: 15px 0; text-align: right;">' +
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
    
    $('select').chosen({ width: '100%', placeholder_text_single: 'Select an option' });
});
</script>

<div class="main">

    <div class="main-inner">

        <div class="container">


            <div class="row">

                <div class="span12">
                    <div class="search_panel">
                        <h3 class="search_header">View Report</h3>

                        <div class="search_conent">
                            <form id="user_sch" action="<?php echo site_url("admin/account/get_report");?>"
                                enctype="multipart/form-data" method="post">

                                <div class="row">

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
                                                <input type="text" id="end_date" name="end_date"
                                                    value="<?php echo $end_date; ?>" class="form-control">
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
                </div>
            </div>



            <div class="row">

                <div class="span12">

                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Success!</strong> <?php echo $this->session->flashdata('msg'); ?>
                    </div>

                    <!--<p class="pull-right ">  

   						<a href="<?= site_url('admin/account/index') ?>"><input type="button" value="New Payment" class="btn btn-primary"> </a></p>
-->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">

                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Credit</th>
                                    <th>Debit</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
$t_c = 0;
$t_d = 0; 
 $sm=1; foreach ($account as $fm){
$t_c =$t_c+$fm['credit'];
$t_b =$t_c+$fm['debit'];

	
	?>
                                <tr>
                                    <td><?php echo $fm['entry_date'];?></td>
                                    <td><?php echo $fm['credit'];?></td>
                                    <td><?php echo $fm['debit'];?></td>
                                    <td><a
                                            href="<?php echo site_url('admin/account/view_details')."/".$fm['entry_date']; ?>">View
                                            Details</a></td>
                                </tr>
                                <?php } ?>

                                <tr>
                                    <td><b>Total</b></td>
                                    <td><b><?php echo $t_c;?></b></td>
                                    <td><b><?php echo $t_b;?></b></td>
                                    <td><b>&nbsp;</b></td>
                                </tr>

                            </tbody>


                        </table>
                    </div>



                    <div id="main-table">


                        <div class="pull-right">


                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<script src="<?php echo base_url()?>assets/validate/dist/jquery.validate.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/ui/jquery-ui.css" />
<script src="<?php echo base_url()?>assets/ui/jquery-ui.js"></script>
<script>
$(function() {
    //	alert("hello")
    $("#start_date").datepicker({
        changeMonth: true,
        changeYear: true,
    });

    $("#end_date").datepicker({
        changeMonth: true,
        changeYear: true,
    });
});
</script>
