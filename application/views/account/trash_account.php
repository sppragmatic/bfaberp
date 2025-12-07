<?php
// Trash Account Page - Same design as view_account, but only shows deleted (trashed) accounts
// This file is based on view_account.php with minor changes for trash context
?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/admin-sales-common.css">
<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/chosen/chosen.css">
<script src="<?php echo base_url();?>assets/chosen/chosen.jquery.min.js"></script>

<script type="text/javascript">
// ...existing code from view_account.php for DataTable, export, print, etc...
</script>

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
                        <h3 class="search_header">Trashed Purchases</h3>
                        <div class="search_conent">
                            <form id="user_sch" action="<?php echo site_url('admin/account/trash_account'); ?>" enctype="multipart/form-data" method="post">
                                <!-- Optionally add filters for trashed accounts -->
                                <div class="row">
                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">Select Material</label>
                                            <select id="material_id" name="material_id" onchange="get_party(this.value);">
                                                <option value="0">-Select Material-</option>
                                                <?php foreach($material as $prd){ ?>
                                                <option <?php if($prd['id']==$material_id){ ?> selected="selected" <?php } ?> value="<?php echo $prd['id']; ?>">
                                                    <?php echo $prd['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">Select Party</label>
                                            <select id="party_id" name="party_id">
                                                <option value="0">-Select Party-</option>
                                                <?php foreach($party as $pa){ ?>
                                                <option <?php if($pa['id']==$party_id){ ?> selected="selected" <?php } ?> value="<?php echo $pa['id']; ?>">
                                                    <?php echo $pa['name']; ?></option>
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
                                </div>
                                <div class="row">
                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">End Date</label>
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
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="account_table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Transaction Id</th>
                                    <th>Ref No</th>
                                    <th>Vehicle No</th>
                                    <th>Party Name</th>
                                    <th>Material Name</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Amount</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($account as $fm){ if($fm['trash']==1){ ?>
                                <tr>
                                    <td><?php echo $fm['entry_date'];?></td>
                                    <td><?php echo $fm['trans_no'];?></td>
                                    <td><?php echo $fm['refno'];?></td>
                                    <td><?php echo $fm['vehicle_no'];?></td>
                                    <td><?php echo $fm['partyname'];?></td>
                                    <td><?php echo $fm['matname'];?></td>
                                    <td><?php echo $fm['stock'];?></td>
                                    <td><?php echo isset($fm['unit']) ? $fm['unit'] : ''; ?></td>
                                    <td class="financial-cell-total">₹<?php echo number_format($fm['amount'], 2);?></td>
                                    <td style="text-align: center;">
                                        <?php if($fm['payment_status']==1){ ?>
                                        <span class="status-badge status-paid">PAID</span>
                                        <?php } ?>
                                        <?php if($fm['payment_status']==2){ ?>
                                        <span class="status-badge status-unpaid">UNPAID</span>
                                        <?php } ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="<?php echo site_url('admin/account/restore')."/".$fm['id']; ?>" class="action-btn btn-restore" title="Restore Account" onclick="return confirm('Are you sure you want to restore this account?')">
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
