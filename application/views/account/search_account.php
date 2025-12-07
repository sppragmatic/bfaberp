<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.css" />


<script>
$(document).ready(function() {
    $('#form_table').DataTable({
        responsive: true
    });
});



function get_party(material_id) {
    $.post("<?php echo site_url('admin/account/get_matparty'); ?>", {
        material_id: material_id
    }, function(msg) {
        alert(msg);
        $('#party_id').html(msg);

    });
    //	alert(course_id)
}
</script>





<style>
#form_table_length {
    display: none !important;
}

#form_table_info {
    display: none !important;
}

#form_table_paginate {
    display: none !important;
}
</style>

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
                        <h3 class="search_header">View Purchase</h3>

                        <div class="search_conent">
                            <form id="user_sch" action="<?php echo site_url("admin/account/search_account");?>"
                                enctype="multipart/form-data" method="post">

                                <div class="row">
                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">Select Material</label>
                                            <select id="material_id" name="material_id"
                                                onchange="get_party(this.value);" name="type">
                                                <option value="0">-Select Material-</option>
                                                <?php foreach($material as $prd){ ?>
                                                <option <?php if($prd['id']==$material_id){ ?> selected="selected"
                                                    <?php } ?> value="<?php echo $prd['id']; ?>">
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
                                                <option <?php if($pa['id']==$party_id){ ?> selected="selected"
                                                    <?php } ?> value="<?php echo $pa['id']; ?>">
                                                    <?php echo $pa['name']; ?></option>
                                                <?php } ?>
                                            </select>
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
                    <p class="pull-right ">

                        <a href="<?= site_url('admin/account/index') ?>"><input type="button" value="New Purchase"
                                class="btn btn-primary"> </a>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">

                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Transaction Id</th>
                                    <th>Party Name</th>
                                    <th>Material Name</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $sm=1; foreach ($account as $fm){?>
                                <tr>
                                    <td><?php echo $fm['entry_date'];?></td>
                                    <td><?php echo $fm['trans_no'];?></td>
                                    <td><?php echo $fm['partyname'];?></td>
                                    <td><?php echo $fm['matname'];?></td>
                                    <td><?php echo $fm['stock'];?></td>
                                    <td><?php echo $fm['amount'];?></td>
                                    <td><?php if($fm['payment_status']==1){ ?> PAID <?php } ?>
                                        <?php if($fm['payment_status']==2){ ?> UNPAID <?php } ?></td>
                                    <td><?php if($fm['status']==0){ ?><a
                                            href="<?php echo site_url('admin/account/edit_account')."/".$fm['id']; ?>">Edit</a>
                                        &nbsp;
                                        | &nbsp;<a
                                            href="<?php echo site_url('admin/account/delete')."/".$fm['id']; ?>">Delete</a>|
                                        &nbsp;<a
                                            href="<?php echo site_url('admin/account/approve')."/".$fm['id']; ?>">Approve</a>
                                        <?php } ?>
                                        &nbsp;<?php if($fm['status']==1){ ?> APPROVED <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>


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
