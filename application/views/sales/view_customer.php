<style>
    #customer_table thead th {
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%) !important;
        color: #fff !important;
        border: none !important;
        font-weight: 600 !important;
        text-align: center !important;
        padding: 12px 8px !important;
        font-size: 12px !important;
    }
</style>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/admin-sales-common.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/sales-centralized.css">
<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.css" />


<script>
$(document).ready(function() {
    $('#customer_table').DataTable({
        "responsive": true,
        "processing": true,
        "lengthMenu": [[10, 25, 50, 100, 250, -1], [10, 25, 50, 100, 250, "All"]],
        "pageLength": 25,
        "dom": '<"top-controls"<"left-controls"l><"center-controls"><"right-controls"f>>rt<"bottom-controls"<"left-info"i><"right-pagination"p>>',
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "search": "Search:",
            "searchPlaceholder": "Search customers...",
            "zeroRecords": "No matching customer records found",
            "info": "Showing _START_ to _END_ of _TOTAL_ customers",
            "infoEmpty": "No customers available",
            "infoFiltered": "(filtered from _MAX_ total customers)",
            "processing": "Loading customer data..."
        },
        "order": [[1, "asc"]],
        "columnDefs": [
            {
                "targets": [5], // Action column
                "orderable": false,
                "searchable": false,
                "width": "150px"
            }
        ]
    });
});
</script>






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
                    <div class="table-responsive">

                        <table id="customer_table" class="table table-striped table-bordered table-hover sales-table">
                            <thead>
                                <tr>
                                    <th>Customer Code</th>
                                    <th>Customer Name</th>
                                    <th>Contact No</th>
                                    <th>Address</th>
                                    <th>Remarks</th>
                                    <th>Actions</th>
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
                                    <td style="text-align: center;">
                                        <a href="<?php echo site_url('admin/sales/edit_customer')."/".$fm['id']; ?>" class="action-btn btn-edit" title="Edit Customer">
                                            <i class="icon-edit"></i> Edit
                                        </a>
                                        <a href="<?php echo site_url('admin/sales/delete_customer')."/".$fm['id']; ?>" class="action-btn btn-delete" title="Delete Customer" onclick="return confirm('Are you sure you want to delete this customer?')">
                                            <i class="icon-trash"></i> Delete
                                        </a>
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