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
                        <h3 class="search_header">VIEW PURCHASE</h3>
                        <div class="search_conent">
                            <form id="user_sch" action="<?php echo site_url('admin/account/search_account'); ?>" enctype="multipart/form-data" method="post">
                                <div class="row">
                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="branch_id" class="control-label col-lg-4">Select Branch</label>
                                            <select id="branch_id" name="branch_id">
                                                <option value="0">-Select Branch-</option>
                                                <?php foreach($branch as $br){ ?>
                                                <option <?php if($br['id']==$branch_id){ ?> selected="selected" <?php } ?> value="<?php echo $br['id']; ?>">
                                                    <?php echo $br['name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="material_id" class="control-label col-lg-4">Select Material</label>
                                            <select id="material_id" name="material_id" onchange="get_party(this.value);">
                                                <option value="0">-Select Material-</option>
                                                <?php foreach($material as $prd){ ?>
                                                <option <?php if($prd['id']==$material_id){ ?> selected="selected" <?php } ?> value="<?php echo $prd['id']; ?>">
                                                    <?php echo $prd['name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="party_id" class="control-label col-lg-4">Select Party</label>
                                            <select id="party_id" name="party_id" class="chosen-select">
                                                <option value="0">-Select Party-</option>
                                                <?php foreach($party as $pa){ ?>
                                                <option <?php if($pa['id']==$party_id){ ?> selected="selected" <?php } ?> value="<?php echo $pa['id']; ?>">
                                                    <?php echo $pa['name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
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
                                </div>
                            </form>
                        </div>
                    </div>
                    <p class="pull-right ">
                        <a href="<?= site_url('admin/account/index') ?>"><input type="button" value="New Purchase" class="btn btn-primary"> </a>
                    </p>
                    <style>
                        /* Force table header to match admin_sales.php */
                        #admin_account_table thead th {
                            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%) !important;
                            color: #fff !important;
                            border: none !important;
                            font-weight: 600 !important;
                            text-align: center !important;
                            padding: 12px 8px !important;
                            font-size: 12px !important;
                        }
                    </style>
                    <div class="table-responsive">
                        <table id="admin_account_table" class="table table-striped table-bordered table-hover sales-table">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 60px;">SL NO.</th>
                                    <th class="text-center" style="width: 100px;">DATE</th>
                                    <th class="text-center" style="width: 120px;">TRANSACTION ID</th>
                                    <th class="text-center" style="width: 120px;">REF NO</th>
                                    <th class="text-center" style="width: 120px;">VEHICLE NO</th>
                                    <th class="text-center" style="width: 150px;">PARTY NAME</th>
                                    <th class="text-center" style="width: 150px;">MATERIAL NAME</th>
                                    <th class="text-right" style="width: 100px;">QUANTITY</th>
                                     <th class="text-right" style="width: 100px;">UNIT</th>
                                    <th class="text-right" style="width: 100px;">AMOUNT</th>
                                    <th class="text-center" style="width: 80px;">PAYMENT STATUS</th>
                                    <th class="text-center" style="width: 150px;">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sm=1; foreach ($account as $fm){?>
                                <tr>
                                    <td class="text-center"><?php echo $sm++;?></td>
                                    <td class="text-center"><?php echo date('d-m-Y', strtotime($fm['entry_date']));?></td>
                                    <td><?php echo $fm['trans_no'];?></td>
                                    <td><?php echo $fm['refno'];?></td>
                                    <td><?php echo $fm['vehicle_no'];?></td>
                                    <td><?php echo $fm['partyname'];?></td>
                                    <td><?php echo $fm['matname'];?></td>
                                    <td class="text-right"><?php echo number_format($fm['stock'],2);?></td>
                                     <td><?php echo $fm['unit'];?></td>
                                    <td class="text-right">₹<?php echo number_format($fm['amount'],2);?></td>
                                    <td class="text-center">
                                        <?php if($fm['payment_status']==1){ ?>
                                            <span class="status-badge status-paid">PAID</span>
                                        <?php } else { ?>
                                            <span class="status-badge status-unpaid">UNPAID</span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($fm['trash']==0){ ?>
                                            <?php if($fm['status']==0){ ?>
                                                <a href="<?php echo site_url('admin/account/edit_account')."/".$fm['id']; ?>" class="action-btn btn-edit" title="Edit Account">
                                                    <i class="icon-edit"></i>
                                                </a>
                                                <a href="<?php echo site_url('admin/account/delete')."/".$fm['id']; ?>" class="action-btn btn-delete" title="Delete Account" onclick="return confirm('Are you sure you want to delete this account?')">
                                                    <i class="icon-trash"></i>
                                                </a>
                                                <a href="<?php echo site_url('admin/account/approve')."/".$fm['id']; ?>" class="action-btn btn-approve" title="Approve Account">
                                                    <i class="icon-ok"></i>
                                                </a>
                                            <?php } else { ?>
                                                <span class="status-badge status-paid">APPROVED</span>
                                                <a href="<?php echo site_url('admin/account/challan')."/".$fm['id']; ?>" title="Print Purchase Challan" target="_blank" class="btn btn-xs btn-info" style="padding:2px 8px; font-size:12px; line-height:1.2; border-radius:4px; margin-left:4px;">
                                                    <i class="icon-print"></i> Print
                                                </a>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <span class="text-danger"><strong>DELETED</strong></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
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
function get_party(material_id) {
    $.post("<?php echo site_url('admin/account/get_matparty'); ?>", {
        material_id: material_id
    }, function(msg) {
        $('#party_id').html(msg);
        $("#party_id").trigger("chosen:updated");
    });
}

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
    $('#admin_account_table').DataTable({
        "responsive": true,
        "processing": true,
        "lengthMenu": [[10, 25, 50, 100, 250, -1], [10, 25, 50, 100, 250, "All"]],
        "pageLength": 25,
        "dom": '<"top-controls"<"left-controls"l><"center-controls"><"right-controls"f>>rt<"bottom-controls"<"left-info"i><"right-pagination"p>>',
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "search": "Search:",
            "searchPlaceholder": "Search all columns...",
            "zeroRecords": "No matching account records found",
            "info": "Showing _START_ to _END_ of _TOTAL_ records",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "processing": "Loading account data...",
            "paginate": {
                "first": "«",
                "last": "»",
                "next": "›",
                "previous": "‹"
            },
            "emptyTable": "No account data available",
            "loadingRecords": "Loading..."
        },
        "order": [[1, "desc"]],
        "columnDefs": [
            { "targets": [-1], "orderable": false, "searchable": false, "width": "150px" },
            { "targets": [7,8], "className": "text-right" },
            { "targets": [0], "width": "60px", "className": "text-center" },
            { "targets": [1], "width": "100px", "className": "text-center" }
        ]
    });
});
</script>