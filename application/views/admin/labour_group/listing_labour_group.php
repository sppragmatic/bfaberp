<!-- Enhanced CSS for Professional Design -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/standardized_view.css">
<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/font/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/chosen/chosen.min.css">
<script src="<?php echo base_url();?>assets/chosen/chosen.jquery.min.js"></script>

<script type="text/javascript">
function clearFilters() {
    var table = $('.table').DataTable();
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
    var table = $('.table').DataTable();
    var data = table.rows({search: 'applied'}).data();
    
    if (data.length === 0) {
        showMessage('No data to export', 'warning');
        return;
    }
    
    var csv = 'S.No,Name,Description,Entry Date\n';
    data.each(function(row) {
        var rowData = [
            $(row[0]).text() || row[0],
            $(row[1]).text() || row[1],
            $(row[2]).text() || row[2],
            $(row[3]).text() || row[3]
        ];
        csv += rowData.join(',') + '\n';
    });
    
    var blob = new Blob([csv], { type: 'text/csv' });
    var url = window.URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'labour_group_report_' + new Date().toISOString().slice(0, 10) + '.csv';
    a.click();
    window.URL.revokeObjectURL(url);
    
    showMessage('CSV export completed successfully', 'success');
}

function printTable() {
    var table = $('.table').DataTable();
    var tableHtml = table.table().container().outerHTML;
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Labour Group Report</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin: 20px 0; }');
    printWindow.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
    printWindow.document.write('th { background-color: #f8f9fa; font-weight: bold; }');
    printWindow.document.write('tr:nth-child(even) { background-color: #f9f9f9; }');
    printWindow.document.write('@media print { .dataTables_wrapper > div:not(.table-responsive) { display: none !important; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<h2>Labour Group Report - ' + new Date().toLocaleDateString() + '</h2>');
    printWindow.document.write(tableHtml);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

$(document).ready(function() {
    var table = $('.table').DataTable({
        "responsive": true,
        "processing": true,
        "lengthMenu": [[10, 25, 50, 100, 250, -1], [10, 25, 50, 100, 250, "All"]],
        "pageLength": 25,
        "dom": '<"top-controls"<"left-controls"l><"center-controls"><"right-controls"f>>rt<"bottom-controls"<"left-info"i><"right-pagination"p>>',
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "search": "Search:",
            "searchPlaceholder": "Search labour groups...",
            "zeroRecords": "No matching labour groups found",
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
        "order": [[1, "asc"]],
        "columnDefs": [
            {
                "targets": [4], // Action column
                "orderable": false,
                "searchable": false,
                "width": "200px"
            },
            {
                "targets": [0], // Serial number column
                "width": "50px",
                "className": "text-center"
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
                
                $('.table').parent().before(tableActions);
            }
        }
    });
    
    $('select').chosen({ width: '100%', placeholder_text_single: 'Select an option' });
});
</script>

<div class="main listing-page">  <div class="main-inner">

    <div class="container">

      <div class="row">

   <div class="span12">
<?php if($this->session->flashdata('success')){?>

<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
</div>
<?php }?>
<?php if($this->session->flashdata('error')){?>

<div class="alert alert-danger">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
</div>
<?php }?>
<div class="widget ">
<div class="widget-header">
<h3>LABOUR GROUP LISTING</h3>
</div>
<div class="widget-content">


<p class="pull-right ">  

   						<a href="<?= site_url('admin/labour_group/create') ?>"><input type="button" value="Create Labour Group" class="btn btn-primary"> </a></p>
<table class="table table-striped table-bordered table-hover">

									<thead>
										<tr>
										<th>#</th>
										<th>Name</th>
										<th>Description</th>
										<th>Entry Date</th>
										<th>Action</th>
										</tr>
									</thead>

									<tbody>
<?php $sm=1; if(isset($labour_groups) && !empty($labour_groups)) { foreach ($labour_groups as $lg){
    // Handle both array and object formats
    $name = is_object($lg) ? $lg->name : (is_array($lg) ? $lg['name'] : '');
    $description = is_object($lg) ? $lg->description : (is_array($lg) ? $lg['description'] : '');
    $entry_date = is_object($lg) ? $lg->entry_date : (is_array($lg) ? $lg['entry_date'] : '');
    $id = is_object($lg) ? $lg->id : (is_array($lg) ? $lg['id'] : '');
?>
<tr>
<td><?php echo $sm++;?></td>
<td><?php echo $name;?></td>
<td><?php echo $description;?></td>
<td><?php echo date('d-m-Y', strtotime($entry_date));?></td>
<td>
<a href="<?= site_url('admin/labour_group/view/'.$id) ?>"><button type="button" class="btn btn-info btn-xs">View</button></a>
<a href="<?= site_url('admin/labour_group/edit/'.$id) ?>"><button type="button" class="btn btn-warning btn-xs">Edit</button></a>
<a href="<?= site_url('admin/labour_group/delete/'.$id) ?>" onclick="return confirm('Are you sure you want to delete this labour group?')"><button type="button" class="btn btn-danger btn-xs">Delete</button></a>
</td>
</tr>
<?php } } else { ?>
<tr>
<td colspan="5" class="text-center">No labour groups found.</td>
</tr>
<?php } ?>
									</tbody>

								</table>


</div>
</div>

</div>

      </div> <!-- /row -->

    </div> <!-- /container -->

  </div> <!-- /main-inner -->

</div> <!-- /main -->
