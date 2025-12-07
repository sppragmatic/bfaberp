
<!-- Centralized Sales CSS -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/sales-centralized.css">








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
                        <h3 class="search_header">SALES ACCOUNT REPORT12</h3>

                        <div class="search_conent">


                            <form id="user_sch" action="<?php echo site_url("admin/sales/getreport");?>"
                                enctype="multipart/form-data" method="post">

                                <div class="row">


                                    <div class="span3">
                                        <div class="form-group">


                                            <label for="text1" class="control-label col-lg-4">Select Party</label>
                                            <select id="customer_id" class="chosen-select" required="required"
                                                name="customer_id">
                                                <option value="0">-Select Party-</option>
                                                <?php foreach($customer as $pr){ ?>
                                                <option value="<?php echo $pr['id']; ?>"><?php echo $pr['name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="span3">
                                        <div class="form-group">

                                            <td>
                                                <label for="text1" class="control-label col-lg-4">All Branch</label>
                                                <select id="branch_id" name="branch_id">
                                                    <option value="0">-Select Branch-</option>
                                                    <?php foreach($branch as $br){ ?>
                                                    <option value="<?php echo $br['id']; ?>"><?php echo $br['name']; ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </div>
                                    </div>

                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">Start Date</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="start_date" name="start_date"
                                                    class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="row">
                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">End Date</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="end_date" name="end_date" class="form-control">
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

                        <a href="<?= site_url('admin/sales/index') ?>"><input type="button" value="New Sales"
                                class="btn btn-primary"> </a>
                    </p>

                    <div id="main-table">


                        <div class="pull-right">


                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


