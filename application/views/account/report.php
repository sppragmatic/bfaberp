<style>
  #admin_report_table thead th {
    background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%) !important;
    color: #fff !important;
    border: none !important;
    font-weight: 600 !important;
    text-align: center !important;
    padding: 12px 8px !important;
    font-size: 12px !important;
  }
</style>
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
            <h3 class="search_header">VIEW PURCHASE ACCOUNT REPORT</h3>
            <div class="search_conent">
              <form id="user_sch" action="<?php echo site_url('admin/account/getreport'); ?>" enctype="multipart/form-data" method="post">
                <div class="row">
                  <div class="span3">
                    <div class="form-group">
                      <label for="party_id" class="control-label col-lg-4">Select Party</label>
                      <select id="party_id" name="party_id" class="chosen-select">
                        <option value="0">-Select Party-</option>
                        <?php foreach($party as $pr){ ?>
                        <option value="<?php echo $pr['id']; ?>"><?php echo $pr['name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="span3">
                    <div class="form-group">
                      <label for="branch_id" class="control-label col-lg-4">All Branch</label>
                      <select id="branch_id" name="branch_id">
                        <option value="0">-Select Branch-</option>
                        <?php foreach($branch as $br){ ?>
                        <option value="<?php echo $br['id']; ?>"><?php echo $br['name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="span3">
                    <div class="form-group">
                      <label for="start_date" class="control-label col-lg-4">Start Date</label>
                      <div class="col-lg-8">
                        <input type="text" id="start_date" name="start_date" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="span3">
                    <div class="form-group">
                      <label for="end_date" class="control-label col-lg-4">End Date</label>
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
          <p class="pull-right ">
            <a href="<?= site_url('admin/sales/index') ?>"><input type="button" value="New Sales" class="btn btn-primary"> </a>
          </p>
          <div class="table-responsive">
            <table id="admin_report_table" class="table table-striped table-bordered table-hover sales-table">
              <thead>
                <tr>
                  <th class="text-center">SL NO.</th>
                  <th class="text-center">DATE</th>
                  <th class="text-center">PARTY NAME</th>
                  <th class="text-center">BRANCH</th>
                  <th class="text-center">AMOUNT</th>
                  <th class="text-center">ACTION</th>
                </tr>
              </thead>
              <tbody>
                <?php if(isset($sales) && is_array($sales)) { $sm=1; foreach ($sales as $row) { ?>
                <tr>
                  <td class="text-center"><?php echo $sm++; ?></td>
                  <td class="text-center"><?php echo isset($row['entry_date']) ? date('d-m-Y', strtotime($row['entry_date'])) : ''; ?></td>
                  <td><?php echo isset($row['partyname']) ? $row['partyname'] : ''; ?></td>
                  <td><?php echo isset($row['branch_id']) ? $row['branch_id'] : ''; ?></td>
                  <td class="text-right">₹<?php echo isset($row['amount']) ? number_format($row['amount'],2) : '0.00'; ?></td>
                  <td class="text-center">-</td>
                </tr>
                <?php }} ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Enhanced JavaScript Dependencies -->
<script src="<?php echo base_url()?>assets/validate/dist/jquery.validate.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/ui/jquery-ui.css" />
<script src="<?php echo base_url()?>assets/ui/jquery-ui.js"></script>
<script src="<?php echo base_url();?>assets/chosen/chosen.jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
  // Initialize Date Pickers
  $("#start_date").datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: 'dd-mm-yy'
  });
  $("#end_date").datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: 'dd-mm-yy'
  });
  // Initialize Chosen Select
  var config = {
    '.chosen-select': { width: "100%" },
    '.chosen-select-deselect': { allow_single_deselect: true },
    '.chosen-select-no-single': { disable_search_threshold: 10 },
    '.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
    '.chosen-select-width': { width: "95%" }
  };
  for (var selector in config) {
    $(selector).chosen(config[selector]);
  }
  // Initialize DataTable
  $('#admin_report_table').DataTable({
    "responsive": true,
    "processing": true,
    "lengthMenu": [[10, 25, 50, 100, 250, -1], [10, 25, 50, 100, 250, "All"]],
    "pageLength": 25,
    "dom": '<"top-controls"<"left-controls"l><"center-controls"><"right-controls"f>>rt<"bottom-controls"<"left-info"i><"right-pagination"p>>',
    "language": {
      "lengthMenu": "Show _MENU_ entries",
      "search": "Search:",
      "searchPlaceholder": "Search all columns...",
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
      },
      "emptyTable": "No data available",
      "loadingRecords": "Loading..."
    },
    "order": [[1, "desc"]],
    "columnDefs": [
      { "targets": [-1], "orderable": false, "searchable": false, "width": "120px" },
      { "targets": [0], "width": "60px", "className": "text-center" },
      { "targets": [1], "width": "100px", "className": "text-center" },
      { "targets": [4], "className": "text-right" }
    ]
  });
});
</script>
