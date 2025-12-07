<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.css" />


<script>
$(document).ready(function() {
    $('#form_table').DataTable({
        responsive: true
    });
});
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

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/standardized_view.css">
<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<!-- Enhanced CSS for Professional Design -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/standardized_view.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/dataTables.bootstrap.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/font/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/chosen/chosen.min.css">

<script type="text/javascript">
$(document).ready(function() {
    $('.table').DataTable({
        "responsive": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 25,
        "order": [[0, "desc"]]
    });
});
</script>

<div class="main view-page">

    <div class="main-inner">

        <div class="container">

            <div class="row">

                <div class="span12">

                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Success!</strong> <?php echo $this->session->flashdata('msg'); ?>
                    </div>


                    <div class="widget ">
                        <div class="widget-content">
                            <h2>view Party</h2>

                        </div>
                    </div>
                    <p class="pull-right ">
                        <a href="<?= site_url('admin/account/create_party') ?>"><input type="button" value="New Party" class="btn btn-primary"> </a>
                        <?php if ($this->ion_auth->is_admin()) { ?>
                        <a href="<?= site_url('admin/party/trash') ?>"><input type="button" value="View Trash" class="btn btn-danger"> </a>
                        <?php } ?>
                    </p>
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">

                        <thead>
                            <tr>
                                <th>Party Code</th>
                                <th>Party Name</th>
                                <th>Contact No</th>
                                <th>Address</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $sm=1; foreach ($party as $fm){?>
                            <tr>
                                <td><?php echo $fm['code'];?></td>
                                <td><?php echo $fm['name'];?></td>
                                <td><?php echo $fm['contact_no'];?></td>
                                <td><?php echo $fm['address'];?></td>
                                <td><?php echo $fm['remarks'];?></td>
                                <td><a href="<?php echo site_url('admin/account/edit_party')."/".$fm['id']; ?>">Edit</a>
                                    &nbsp; | &nbsp;<a
                                        href="<?php echo site_url('admin/account/delete_party')."/".$fm['id']; ?>">Delete</a>
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