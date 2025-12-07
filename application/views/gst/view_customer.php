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

<div class="main">

    <div class="main-inner">

        <div class="container">

            <div class="row">

                <div class="span12">

                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong><?php echo $this->session->userdata('del_message'); ?></strong>
                        <?php echo $this->session->flashdata('msg'); ?>
                    </div>


                    <div class="widget ">
                        <div class="widget-content">
                            <h2>view customer</h2>

                        </div>
                    </div>
                    <p class="pull-right ">

                        <a href="<?= site_url('admin/sales/create_customer') ?>"><input type="button"
                                value="New customer" class="btn btn-primary"> </a>
                    </p>
                    <table class="table table-striped table-bordered table-hover">

                        <thead>
                            <tr>
                                <th>customer Code</th>
                                <th>customer Name</th>
                                <th>Contact No</th>
                                <th>Address</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $sm=1; foreach ($customer as $fm){?>
                            <tr>
                                <td><?php echo $fm['code'];?></td>
                                <td><?php echo $fm['name'];?></td>
                                <td><?php echo $fm['contact_no'];?></td>
                                <td><?php echo $fm['address'];?></td>
                                <td><?php echo $fm['remarks'];?></td>
                                <td><a
                                        href="<?php echo site_url('admin/sales/edit_customer')."/".$fm['id']; ?>">Edit</a>
                                    &nbsp; | &nbsp;<a
                                        href="<?php echo site_url('admin/sales/delete_customer')."/".$fm['id']; ?>">Delete</a>
                                </td>
                            </tr>
                            <?php } ?>


                        </tbody>


                    </table>




                    <div id="main-table">


                        <div class="pull-right">


                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>