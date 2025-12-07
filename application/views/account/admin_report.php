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
  @media print {
    body * {
      visibility: hidden !important;
    }
    #admin_report_table, #admin_report_table *,
    .filter-print-label {
      visibility: visible !important;
    }
    #admin_report_table {
      position: fixed !important;
      left: 0;
      top: 40px;
      width: 100% !important;
      z-index: 9999;
      margin: 0 !important;
      page-break-before: always;
    }
    .filter-print-label {
      position: fixed !important;
      left: 0;
      top: 0;
      width: 100% !important;
      display: block !important;
      margin-bottom: 10px !important;
      font-weight: bold !important;
      font-size: 14px !important;
      color: #000 !important;
      background: #fff !important;
      padding: 10px 0 0 10px !important;
      z-index: 10000;
    }
    #admin_report_table thead th, #admin_report_table tbody td, #admin_report_table tfoot td {
      page-break-inside: avoid;
    }
    html, body {
      margin: 0 !important;
      padding: 0 !important;
      height: auto !important;
      background: #fff !important;
    }
    #admin_report_table thead th {
      background: #e0e0e0 !important;
      color: #000 !important;
      -webkit-print-color-adjust: exact;
    }
    #admin_report_table tbody td, #admin_report_table tfoot td {
      background: #fff !important;
      color: #000 !important;
      border: 1px solid #000 !important;
      padding: 4px !important;
    }
    .total-row {
      background-color: #e0e0e0 !important;
      font-weight: bold !important;
      -webkit-print-color-adjust: exact;
    }
    .day-total {
      background-color: #d0d0d0 !important;
      padding: 8px !important;
      text-align: center !important;
      font-weight: bold !important;
      border: 1px solid #000 !important;
      -webkit-print-color-adjust: exact;
    }
    @page {
      margin: 0.5in;
      size: A4;
    }
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      color: #000 !important;
      background: white !important;
    }
    h5, h6 {
      font-size: 12px !important;
      margin: 5px 0 !important;
      color: #000 !important;
    }
    /* Hide page URL/footer in print */
    a[href]:after {
      content: none !important;
    }
    .filter-print-label {
      display: block !important;
      margin-bottom: 10px !important;
      font-weight: bold !important;
      font-size: 14px !important;
      color: #000 !important;
    }
  }
  .summary-box {
    border-radius: 5px;
    margin-bottom: 15px;
  }
  .total-row {
    font-weight: bold;
  }
  .day-total h6 {
    text-align: center;
    font-size: 16px;
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
            <h3 class="search_header">PURCHASE ACCOUNT REPORT</h3>
            <div class="search_conent">
              <form id="user_sch" action="<?php echo site_url('admin/account/getreport'); ?>" enctype="multipart/form-data" method="post">
                <div class="row">
                  <div class="span3">
                    <div class="form-group">
                      <label for="party_id" class="control-label col-lg-4">Select Party</label>
                      <select id="party_id" name="party_id" class="chosen-select">
                        <option value="0">-Select Party-</option>
                        <?php foreach($party as $pr){ ?>
                        <option value="<?php echo $pr['id']; ?>" <?php if($pr['id']==$party_id){ ?> selected="selected" <?php } ?>><?php echo $pr['name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="span3">
                    <div class="form-group">
                      <label for="branch_id" class="control-label col-lg-4">Select Branch</label>
                      <select id="branch_id" name="branch_id">
                        <option value="0">-All Branch-</option>
                        <?php foreach($branch as $br){ ?>
                        <option value="<?php echo $br['id']; ?>" <?php if($br['id']==$branch_id){ ?> selected="selected" <?php } ?>><?php echo $br['name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="span3">
                    <div class="form-group">
                      <label for="start_date" class="control-label col-lg-4">Start Date</label>
                      <div class="col-lg-8">
                        <input type="text" id="start_date" name="start_date" value="<?php echo $start_date; ?>" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="span3">
                    <div class="form-group">
                      <label for="end_date" class="control-label col-lg-4">End Date</label>
                      <div class="col-lg-8">
                        <input type="text" id="end_date" name="end_date" value="<?php echo $end_date; ?>" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="span2"><br />
                    <input type="submit" id="tags" value="Search" class="btn btn-primary" />
                  </div>
                  <div class="span2"><br />
                    <button type="button" class="btn btn-info btn-print" style="width: 100%;" onclick="window.print();"><i class="icon-print"></i> Print</button>
                  </div>
                </div>
                
              </form>
            </div>
          </div>
          <p class="pull-right ">
            <a href="<?= site_url('admin/sales/index') ?>"><input type="button" value="New Sales" class="btn btn-primary"> </a>
          </p>


          <div class="table-responsive">
          <div class="row">
                  <div class="span12">
                    <span class="filter-print-label" style="font-weight:bold; font-size:14px;" id="filterPrintLabel">
                      Report For: 
                      <?php if($party_id && $party_id != 0) echo 'Party: '.htmlspecialchars($party[array_search($party_id, array_column($party, 'id'))]['name']).' | '; ?>
                      <?php if($branch_id && $branch_id != 0) echo 'Branch: '.htmlspecialchars($branch[array_search($branch_id, array_column($branch, 'id'))]['name']).' | '; ?>
                      <?php if($start_date) echo 'Start Date: '.htmlspecialchars($start_date).' | '; ?>
                      <?php if($end_date) echo 'End Date: '.htmlspecialchars($end_date); ?>
                    </span>
                  </div>
                </div>
          
          <table id="admin_report_table" class="table table-striped table-bordered table-hover sales-table">
              <thead>
                <tr>
                  <th class="text-center">SL NO.</th>
                  <th class="text-center">INVOICE NO.</th>
                  <th class="text-center">CUSTOMER NAME</th>
                  <th class="text-center">DATE</th>
                  <th class="text-center">PENDING</th>
                  <th class="text-center">GIVEN</th>
                  <th class="text-center">DUE</th>
                </tr>
              </thead>
              <tbody>
                <?php $sm=1; $tc = 0; $td = 0; foreach ($sales as $fm){ $tc = $tc+$fm['credit']; $td = $td+$fm['debit']; ?>
                <tr>
                     <td class="text-center"><?php echo $sm++; ?></td>
                  <td class="text-center"><?php echo $fm['invid'];?></td>
                  <td><?php echo $fm['partyname'];?></td>
                  <td class="text-center">
                    <?php echo date('d-m-Y', strtotime($fm['entry_date'])); ?>
                  </td>
                  <td class="text-right"><?php echo $fm['credit'];?></td>
                  <td class="text-right"><?php echo $fm['debit'];?></td>
                  <td class="text-right"><?php echo $fm['credit']-$fm['debit'];?></td>
                </tr>
                <?php } ?>
                <tr>
                  <td class="text-center">Total</td>
                  <td></td>
                    <td></td>
                  <td></td>
                  <td class="text-right"><?php echo $tc;?></td>
                  <td class="text-right"><?php echo $td; ?></td>
                  <td class="text-right"><?php echo $tc-$td; ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Enhanced JavaScript Dependencies -->
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

  window.addEventListener('beforeprint', function() {
    document.getElementById('filterPrintLabel').style.display = 'block';
  });
  window.addEventListener('afterprint', function() {
    document.getElementById('filterPrintLabel').style.display = 'none';
  });
});
</script>