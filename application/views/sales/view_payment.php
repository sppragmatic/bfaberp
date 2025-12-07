<link rel="stylesheet" href="<?php echo base_url();?>assets/css/standardized_view.css">
<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.css" />
<!-- Font Awesome Icons for Action Buttons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Chosen Library for Enhanced Select Dropdowns -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/chosen/chosen.css">
<script src="<?php echo base_url();?>assets/chosen/chosen.jquery.min.js"></script>


<script>
$(document).ready(function() {
    $('#payment_table').DataTable({
        "responsive": true,
        "processing": true,
        "lengthMenu": [[10, 25, 50, 100, 250, -1], [10, 25, 50, 100, 250, "All"]],
        "pageLength": 25,
        "dom": '<"top-controls"<"left-controls"l><"center-controls"><"right-controls"f>>rt<"bottom-controls"<"left-info"i><"right-pagination"p>>',
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "search": "Search:",
            "searchPlaceholder": "Search payment records...",
            "zeroRecords": "No matching payment records found",
            "info": "Showing _START_ to _END_ of _TOTAL_ payments",
            "infoEmpty": "No payment records available",
            "infoFiltered": "(filtered from _MAX_ total payments)",
            "processing": "Loading payment data...",
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
                "targets": [6],
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
    
    // Initialize Chosen for select dropdowns
    $('.chosen-select').chosen({
        width: '100%',
        placeholder_text_single: 'Select an option'
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

.chosen-select {
    z-index: 9999;
}

/* Enhanced Action Button Styling */
.action-btn {
    display: inline-block;
    padding: 4px 8px;
    margin: 0 2px;
    border-radius: 4px;
    font-size: 11px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    vertical-align: middle;
}

.action-btn i {
    margin-right: 4px;
    font-size: 10px;
}

.btn-edit {
    background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
    color: white;
    border: 1px solid #17a2b8;
}

.btn-edit:hover {
    background: linear-gradient(135deg, #117a8b 0%, #0c5460 100%);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(23, 162, 184, 0.3);
}

.btn-delete {
    background: linear-gradient(135deg, #dc3545 0%, #bd2130 100%);
    color: white;
    border: 1px solid #dc3545;
}

.btn-delete:hover {
    background: linear-gradient(135deg, #bd2130 0%, #a01e2a 100%);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
}

.btn-info {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    color: white;
    border: 1px solid #6c757d;
}

.btn-info:hover {
    background: linear-gradient(135deg, #495057 0%, #343a40 100%);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(108, 117, 125, 0.3);
}

.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
    color: white;
    border: 1px solid #28a745;
}

.btn-success:hover {
    background: linear-gradient(135deg, #1e7e34 0%, #155724 100%);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
}

.status-badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: bold;
    text-transform: uppercase;
}

.status-deleted {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Improved table actions column */
td[style*="text-align: center"] {
    white-space: nowrap;
    padding: 8px 4px !important;
}

/* Enhanced Date Field Styling */
#start_date, #end_date {
    position: relative;
    padding: 6px 12px 6px 35px !important;
    height: 32px !important;
    border: 2px solid #e1e5e9 !important;
    border-radius: 6px !important;
    font-size: 13px !important;
    background: #fff !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05) !important;
    line-height: 1.2 !important;
}

#start_date:focus, #end_date:focus {
    border-color: #007bff !important;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25) !important;
    outline: none !important;
}

/* Date field containers with icons */
#start_date, #end_date {
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="%23007bff" viewBox="0 0 16 16"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5 0zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/></svg>') !important;
    background-repeat: no-repeat !important;
    background-position: 10px center !important;
    background-size: 16px 16px !important;
}

/* Date field label styling */
.form-group label[for="text1"] {
    font-weight: 600 !important;
    color: #495057 !important;
    margin-bottom: 5px !important;
    font-size: 13px !important;
}

/* Container improvements for date fields */
.span3 .form-group {
    margin-bottom: 15px !important;
}

.span3 .col-lg-8 {
    width: 100% !important;
    margin-left: 0 !important;
}

.span3 .control-label {
    width: 100% !important;
    text-align: left !important;
    margin-left: 0 !important;
    padding-left: 0 !important;
}
</style>

<div class="main view-page">

    <div class="main-inner">

        <div class="container">

            <div class="row">

                <div class="span12">

                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Success!</strong> <?php echo $this->session->flashdata('msg'); ?>
                    </div>



                    <div class="search_panel">
                        <h3 class="search_header">View Payment</h3>

                        <div class="search_conent">
                            <form id="user_sch" action="<?php echo site_url("admin/sales/search_payment");?>"
                                enctype="multipart/form-data" method="post">

                                <div class="span3">
                                    <div class="form-group">

                                        <td>
                                            <label for="text1" class="control-label col-lg-4">Select Party</label>
                                            <select id="customer_id" class="chosen-select" name="customer_id">
                                                <option value="0">-Select Party-</option>
                                                <?php foreach($customer as $pr){ ?>
                                                <option <?php if($pr['id']==$customer_id){ ?> selected="selected"
                                                    <?php } ?> value="<?php echo $pr['id']; ?>">
                                                    <?php echo $pr['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
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




                                <div class="span3">
                                    <div class="form-group">
                                        <label for="text1" class="control-label col-lg-4">End Date</label>
                                        <div class="col-lg-8">
                                            <input type="text" id="end_date" value="<?php echo $end_date; ?>"
                                                name="end_date" class="form-control">
                                        </div>
                                    </div>

                                </div>



                                <div class="span2"><br />
                                    <input type="submit" id="tags" value="Search" class="btn btn-primary" />
                                </div>
                            </form>
                        </div>
                    </div>

                    <p class="pull-right ">

                        <a href="<?= site_url('admin/sales/add_payment') ?>"><input type="button"
                                value="New Money Recipt" class="btn btn-primary"> </a>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="payment_table">
                            <thead>
                                <tr>
                                    <th style="text-align: center; font-weight: bold;">SL NO.</th>
                                    <th style="text-align: center; font-weight: bold;">Receipt No.</th>
                                    <th style="text-align: center; font-weight: bold;">Customer Name</th>
                                    <th style="text-align: center; font-weight: bold;">Date</th>
                                    <th style="text-align: center; font-weight: bold;">Amount (₹)</th>
                                    <th style="text-align: center; font-weight: bold;">Payment Type</th>
                                    <th style="text-align: center; font-weight: bold;">Details</th>
                                    <th style="text-align: center; font-weight: bold;">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                                                <?php $sm=1; foreach ($sales as $fm){
if($fm['debit']!=0){
    ?>
                                                                <tr>
                                                                        <td class="text-center"><?php echo $sm++; ?></td>
                                                                        <td><?php echo $fm['invno'];?></td>
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
                                        <?php if($fm['trash']==0){ ?>
                                        <a href="<?php echo site_url('admin/sales/edit_payment')."/".$fm['id']; ?>" class="action-btn btn-edit" title="Edit Payment">
                                            <i class="icon-edit"></i> Edit
                                        </a>
                                        <a href="<?php echo site_url('admin/sales/delete_payment')."/".$fm['id']; ?>" class="action-btn btn-delete" title="Delete Payment" onclick="return confirm('Are you sure you want to delete this payment?')">
                                            <i class="icon-trash"></i> Delete
                                        </a>
                                        <a href="<?php echo site_url('admin/sales/receipt')."/".$fm['id']; ?>" class="action-btn btn-info" title="Print Receipt">
                                            <i class="icon-print"></i> Print
                                        </a>
                                        <?php }else{ ?>
                                        <span class="status-badge status-deleted">DELETED</span>
                                        <a href="<?php echo site_url('admin/sales/activate_payment')."/".$fm['id']; ?>" class="action-btn btn-success" title="Activate Payment">
                                            <i class="icon-ok"></i> Activate
                                        </a>
                                        <?php } ?>

                                    </td>
                                </tr>
                                <?php
}
} ?>


                            </tbody>


                        </table>
                    </div>

                    <?php echo $pagination; ?>

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