<link rel="stylesheet" href="<?php echo base_url();?>assets/css/standardized_view.css">
<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/chosen/chosen.css">
<script src="<?php echo base_url();?>assets/chosen/chosen.jquery.min.js"></script>

<script>
$(document).ready(function() {
    $('#account_payment_table').DataTable({
        "responsive": true,
        "processing": true,
        "lengthMenu": [[10, 25, 50, 100, 250, -1], [10, 25, 50, 100, 250, "All"]],
        "pageLength": 25,
        "dom": '<"top-controls"<"left-controls"l><"center-controls"><"right-controls"f>>rt<"bottom-controls"<"left-info"i><"right-pagination"p>>',
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "search": "Search:",
            "searchPlaceholder": "Search account payments...",
            "zeroRecords": "No matching payment records found",
            "info": "Showing _START_ to _END_ of _TOTAL_ account payments",
            "infoEmpty": "No payment records available",
            "infoFiltered": "(filtered from _MAX_ total payments)",
            "processing": "Loading account payment data...",
            "paginate": {
                "first": "«",
                "last": "»", 
                "next": "›",
                "previous": "‹"
            },
            "emptyTable": "No payment data available"
        },
        "order": [[2, "desc"]],
        "columnDefs": [
            {
                "targets": [-1],
                "orderable": false,
                "searchable": false,
                "width": "180px"
            },
            {
                "targets": [3],
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
            }
        ]
    });
    $('select').chosen({
        width: '100%',
        placeholder_text_single: 'Select an option'
    });
});
</script>

<style>
#form_table_length { display: none !important; }
#form_table_info { display: none !important; }
#form_table_paginate { display: none !important; }
</style>

<div class="main view-page">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <?php if($this->session->flashdata('msg')): ?>
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Success!</strong> <?php echo $this->session->flashdata('msg'); ?>
                    </div>
                    <?php endif; ?>
                    <div class="search_panel">
                        <h3 class="search_header">Trashed Payments</h3>
                        <div class="search_conent">
                            <form id="user_sch" action="<?php echo site_url('admin/account/trash_payment'); ?>" enctype="multipart/form-data" method="post">
                                <div class="row">
                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">Select Party</label>
                                            <select id="party_id" name="party_id">
                                                <option value="0">-Select Party-</option>
                                                <?php foreach($customer as $pr){ ?>
                                                <option <?php if($pr['id']==$party_id){ ?> selected="selected" <?php } ?> value="<?php echo $pr['id']; ?>">
                                                    <?php echo $pr['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">Start Date</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="start_date" value="<?php echo $start_date; ?>" name="start_date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">End Date</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="end_date" value="<?php echo $end_date; ?>" name="end_date" class="form-control">
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
                        <a href="<?= site_url('admin/account/add_payment') ?>"><input type="button" value="New Payment" class="btn btn-primary"> </a>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="account_payment_table">
                            <thead>
                                <tr>
                                    <th style="text-align: center; font-weight: bold;">Invoice ID</th>
                                    <th style="text-align: center; font-weight: bold;">Party Name</th>
                                    <th style="text-align: center; font-weight: bold;">Date</th>
                                    <th style="text-align: center; font-weight: bold;">Amount (₹)</th>
                                    <th style="text-align: center; font-weight: bold;">Payment Mode</th>
                                    <th style="text-align: center; font-weight: bold;">Details</th>
                                    <th style="text-align: center; font-weight: bold;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sales as $fm){ if($fm['trash']==1){ ?>
                                <tr>
                                    <td><?php echo $fm['invid'];?></td>
                                    <td><?php echo $fm['customername'];?></td>
                                    <td><?php echo $fm['entry_date'];?></td>
                                    <td class="financial-cell-total">₹<?php echo number_format($fm['debit'], 2);?></td>
                                    <td style="text-align: center;">
                                        <?php if($fm['type']==1){ ?>
                                        <span class="status-badge status-paid">CASH</span>
                                        <?php } ?>
                                        <?php if($fm['type']==2){ ?>
                                        <span class="status-badge badge-warning">CHEQUE</span>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $fm['details'];?></td>
                                    <td style="text-align: center;">
                                        <a href="<?php echo site_url('admin/account/restore_payment')."/".$fm['id']; ?>" class="action-btn btn-restore" title="Restore Payment" onclick="return confirm('Are you sure you want to restore this payment?')">
                                            <i class="fa fa-undo"></i> Restore
                                        </a>
                                    </td>
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
<script src="<?php echo base_url()?>assets/validate/dist/jquery.validate.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/ui/jquery-ui.css" />
<script src="<?php echo base_url()?>assets/ui/jquery-ui.js"></script>
<script>
$(function() {
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
