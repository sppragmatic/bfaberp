<!-- Centralized Admin Sales CSS -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/sales-centralized.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/chosen/chosen.css">

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
                        <h3 class="search_header">VIEW OPENING BALANCES</h3>
                        <div class="search_conent">
                            <!-- Add filter form here if needed -->
                        </div>
                    </div>
                    <p class="pull-right ">
                        <a href="<?= site_url('admin/sales/add_opening') ?>"><input type="button" value="Add Opening" class="btn btn-primary"> </a>
                    </p>
                    <div class="table-responsive">
                        <table id="opening_table" class="table table-striped table-bordered table-hover sales-table">


                            <thead>
                                <tr>

                                    <th>SL NO.</th>
                                    <th>CUSTOMER NAME</th>
                                    <th>DATE</th>

                                    <th>AMOUNT</th>
                                    <th>PAYMENT TYPE</th>
                                    <th>DETAILS </th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $sm=1; foreach ($sales as $fm){
  ?>
                                <tr>
                                    <td><?php echo $fm['invno'];?></td>
                                    <td><?php echo $fm['customername'];?></td>
                                    <td><?php echo $fm['entry_date'];?></td>
                                    <td><?php echo $fm['credit'];?></td>
                                    <td><?php if($fm['type']==1){ ?> CASH <?php } ?> <?php if($fm['type']==2){ ?> CHEQUE
                                        <?php } ?> </td>
                                    <td><?php echo $fm['details'];?></td>
                                    <td>
                                        <?php if($fm['status']==0){ ?>
                                        <a
                                            href="<?php echo site_url('admin/sales/edit_opening')."/".$fm['id']; ?>">Edit</a>
                                        &nbsp;
                                        | &nbsp;<a
                                            href="<?php echo site_url('admin/sales/receipt')."/".$fm['id']; ?>">PRINT</a>
                                        <?php }else{ ?>
                                        DELETED
                                        <?php } ?>

                                    </td>
                                </tr>
                                <?php
} ?>


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

<script src="<?php echo base_url();?>assets/chosen/chosen.jquery.js" type="text/javascript"></script>

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