<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js" type="text/javascript" ></script>
<link href="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.css" />


<script>
$(document).ready(function() {
        $('#form_table').DataTable({
                responsive: true
        });
    });


</script>





<style>

#form_table_length{
    display: none !important;
}
#form_table_info{
    display: none !important;
}
#form_table_paginate{
    display: none !important;
}

</style>

<!-- Centralized Admin Sales CSS -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/admin-sales-common.css">
<link rel="stylesheet" href="<?php echo base_url()?>assets/ui/jquery-ui.css" />
<script src="<?php echo base_url()?>assets/ui/jquery-ui.js"></script>

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
            <h3 class="search_header">VIEW STOCK</h3>
            <div class="search_conent">
              <!-- Add filter form here if needed -->
              <form>
                <div class="row">
                  <div class="span3">
                    <div class="form-group">
                      <label for="start_date" class="control-label">Start Date</label>
                      <input type="text" id="start_date" name="start_date" class="form-control">
                    </div>
                  </div>
                  <div class="span3">
                    <div class="form-group">
                      <label for="end_date" class="control-label">End Date</label>
                      <input type="text" id="end_date" name="end_date" class="form-control">
                    </div>
                  </div>
                  <div class="span2"><br />
                    <input type="submit" value="Search" class="btn btn-primary" />
                  </div>
                </div>
              </form>
            </div>
          </div>
</script>
<script>
$(function() {
  $("#start_date, #end_date").datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: 'dd-mm-yy'
  });
});
</script>
          <div class="table-responsive">
            <table id="stock_table" class="table table-striped table-bordered table-hover sales-table">
              <thead>
                <tr>
                  <th>Produt</th>
                  <?php  foreach ($branches as $pm){?>
                  <th style="color: red"><?php echo $pm['name'];?></th>
                  <?php }?>
                  <th style="color: green">All Stock</th>
                </tr>
              </thead>
              <tbody>
                <?php $sm=1; foreach ($allstock as $fm){
                    $allitem = $fm['stock'];
                ?>
                <tr>
                  <td><?php echo $fm['name'];?></td>
                  <?php 
                  $allrw = 0;
                   foreach ($allitem as $am){
                    $allrw = $allrw +$am;
                    ?>
                    <td style="color: red"><b><?php echo $am;?></b></td>
                    <?php }?>
                  <td style="color: green"><b><?php echo $allrw;?></b></td>
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




