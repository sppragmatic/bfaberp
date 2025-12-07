<!-- Centralized Admin Sales CSS -->


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
            "zeroRecords": "No sales summary data found matching your criteria",
            "info": "Showing _START_ to _END_ of _TOTAL_ sales records",
            "infoEmpty": "No sales data available",
            "infoFiltered": "(filtered from _MAX_ total records)",
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


<script type="text/javascript">
function PrintDiv() {
    var divToPrint = document.getElementById('print');
    var popupWin = window.open('', '_blank', 'width=800,height=800');
    popupWin.document.open();
    popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
    popupWin.document.close();
}
</script>


<div class="admin-sales-view">
    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12">

                        <!-- Alert Messages -->
                        <?php if ($this->session->flashdata('msg')): ?>
                        <div class="alert alert-success no-print">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> <?php echo $this->session->flashdata('msg'); ?>
                        </div>
                        <?php endif; ?>

                        <!-- Enhanced Sales Summary Filter Panel -->
                        <div class="search_panel">
                            <h3 class="search_header">📊 Sales Summary Analytics</h3>

                            <div class="search_conent">
                                <form id="summary_search" action="<?php echo site_url('admin/sales/getsummery'); ?>"
                                    enctype="multipart/form-data" method="post">
                                    <div class="row">
                                        <div class="span3">
                                            <div class="form-group">
                                                <label for="customer_id" class="control-label">
                                                    <i class="fa fa-user"></i> Select Party
                                                </label>
                                                <select id="customer_id" class="chosen-select" name="customer_id">
                                                    <option value="0">-All Parties-</option>
                                                    <?php foreach ($customer as $pr): ?>
                                                    <option <?php if ($pr['id'] == $customer_id): ?> selected="selected"
                                                        <?php endif; ?> value="<?php echo $pr['id']; ?>">
                                                        <?php echo $pr['name']; ?>
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
                                                <input type="text" id="start_date" value="<?php echo $start_date; ?>"
                                                    name="start_date" class="form-control">
                                            </div>
                                        </div>

                                        <div class="span3">
                                            <div class="form-group">
                                                <label for="end_date" class="control-label">
                                                    <i class="fa fa-calendar"></i> End Date
                                                </label>
                                                <input type="text" id="end_date" value="<?php echo $end_date; ?>"
                                                    name="end_date" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Professional Button Container -->
                                    <div class="row">
                                        <div class="span12">
                                            <div class="button-container"
                                                style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 15px 0; border-top: 2px solid #f1f3f4;">
                                                <!-- Filter Action Buttons -->
                                                <div class="filter-buttons"
                                                    style="display: flex; gap: 15px; align-items: center;">
                                                    <input type="submit" id="search_btn"
                                                        value="📈 Generate Summary Report" class="btn btn-primary"
                                                        style="margin: 0;" />
                                                    <input type="button" id="reset_btn" value="🔄 Reset Filters"
                                                        class="btn btn-secondary" onclick="resetForm()"
                                                        style="margin: 0; background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;" />
                                                </div>

                                                <!-- Report Action Buttons -->
                                                <div class="report-buttons"
                                                    style="display: flex; gap: 10px; align-items: center;">
                                                    <input type="button" value="🖨️ Print Report"
                                                        class="btn btn-success" onclick="window.print()"
                                                        style="margin: 0; background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <div id="print">
<style>
    @media print {
        @page {
            margin-top: 0;
        }
    }
    @media print {
        /* Hide table header after first page */
        thead { display: table-header-group; }
        @page {
            margin-top: 2cm;
        }
        body.print-hide-thead thead {
            display: none !important;
        }
    }
/* // Hide table header after first page when printing */

    .print-header {
        page-break-inside: avoid;
        break-inside: avoid;
        display: block;
    }
    @media print {
        .print-header {
            display: block;
            position: running(header);
        }
        @page {
            @top-center {
                content: element(header);
            }
        }
        body > .print-header {
            display: block;
        }
        body > .print-header ~ * .print-header {
            display: none !important;
        }
    }
</style>
                            <!-- Enhanced Admin Summary Data Table -->
                            <div class="table-responsive">
                                <table id="admin_summary_table" class="table table-striped table-bordered table-hover" border="1px">


                                    <thead>


                                        <tr>
                                            <th colspan="8" style="text-align:center">

                                                                                             <div class="print-header">
                                                                                                 <div style="display:flex; align-items:center; margin-bottom:8px;">
                                                                                                        <div style="width:80px; min-width:80px; height:60px;  display:flex; align-items:center; justify-content:center; margin-right:16px;">
                                                                                                            <span style="font-size:11px; color:#888;">
                                                                                                                <img src="<?= base_url(); ?>/assets/logo.jpg" alt="Logo" style="max-height:50px;" />
                                                                                                            </span>
                                                                                                        </div>
                                                                                                        <div style="flex:1; text-align:center;margin-left: -60px;">
                                                                                                            <div style="font-size:18px; font-weight:bold;">M/S BHABANI FLY ASH BRICKS</div>
                                                                                                            <div style="font-size:13px;"> At- Padhisahi, Butupali, Dist-Boudh</div>
                                                                                                            <div style="font-size:13px;">Contact : 7749002141 (Gagan Behera)</div>
                                                                                                            <div style="font-size:13px;">Mail ID: bhabaniflyashbricks3@gmail.com</div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                             </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>SL NO.</th>
                                            <th>INV NO.</th>

                                            <th>CUSTOMER NAME</th>
                                            <th>DATE</th>
                                            <th>PRODUCT DETAILS</th>

                                            <th>TOTAL AMOUNT</th>
                                            <th>PAID AMOUNT</th>
                                            <th>DUE</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $sm = 1;
                                        $tc = 0;
                                        $td = 0;
                                        $serial = 1;
                                        $unique = array();
                                        foreach ($sales as $fm) {
                                            // Use invno as unique key, change if needed
                                            if (in_array($fm['invno'], $unique)) continue;
                                            $unique[] = $fm['invno'];
                                            $tc = $tc + $fm['credit'];
                                            $td = $td + $fm['debit'];
                                        ?>
                                        <tr>
                                            <td><?php echo $serial++; ?></td>
                                            <td><?php echo $fm['invno']; ?></td>
                                            <td><?php echo $fm['customername']; ?></td>
                                            <td><?php echo date('d.m.Y', strtotime($fm['entry_date'])); ?></td>
                                            <td> <?php if ($fm['invid'] != '0') { ?>
                                                <?php echo $this->sales_model->get_details($fm['invid']); ?>
                                                <?php } else { ?>
                                                &nbsp;
                                                <?php } ?>
                                            </td>
                                            <td><?php echo $fm['credit']; ?></td>
                                            <td><?php echo $fm['debit']; ?></td>
                                            <td><?php if ($fm['credit'] != 0) { echo $fm['credit'] - $fm['debit']; } else { echo '------'; } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td>Total</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo $tc; ?></td>
                                            <td><?php echo $td; ?></td>
                                            <td><?php echo $tc - $td; ?></td>
                                        </tr>

                                    </tbody>


                                </table>
                            </div>
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

    <script src="<?php echo base_url() ?>assets/validate/dist/jquery.validate.js"></script>
    <!-- jQuery UI already loaded at the top -->
    <script>
    $(function() {
        // Simple default jQuery UI datepickers
        $("#start_date, #end_date").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy'
        });

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

    // Simple reset form function
    function resetForm() {
        $('#customer_id').val('0').trigger('chosen:updated');
        $('#start_date').val('');
        $('#end_date').val('');
    }


    window.onbeforeprint = function() {
    setTimeout(function() {
        var pages = Math.ceil(document.body.scrollHeight / window.innerHeight);
        if (pages > 1) {
            document.body.classList.add('print-hide-thead');
        }
    }, 100);
};
window.onafterprint = function() {
    document.body.classList.remove('print-hide-thead');
};


    </script>

    <style>
      #admin_summary_table thead th {
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
        #admin_summary_table, #admin_summary_table *,
        .filter-print-label {
          visibility: visible !important;
        }
                #admin_summary_table {
                    /* Removed position: fixed and related properties to prevent table from repeating on every page */
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
        #admin_summary_table thead th, #admin_summary_table tbody td, #admin_summary_table tfoot td {
          page-break-inside: avoid;
        }
                html, body {
                    margin-top: 0 !important;
                    padding-top: 0 !important;
                    margin-bottom: 0 !important;
                    padding-bottom: 0 !important;
                    margin-left: 0 !important;
                    margin-right: 0 !important;
                    padding-left: 0 !important;
                    padding-right: 0 !important;
                    height: auto !important;
                    background: #fff !important;
                }
        #admin_summary_table thead th {
          background: #e0e0e0 !important;
          color: #000 !important;
          -webkit-print-color-adjust: exact;
        }
        #admin_summary_table tbody td, #admin_summary_table tfoot td {
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
        a[href]:after {
          content: none !important;
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