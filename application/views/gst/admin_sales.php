<link rel="stylesheet" href="<?php echo base_url();?>assets/chosen/chosen.css">
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

<div class="main">

  <div class="main-inner">

    <div class="container">

      <div class="row">

   <div class="span12">

<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> <?php echo $this->session->flashdata('msg'); ?>
</div>


<div class="widget ">
<div class="widget-header">
   <h2>view sales</h2>
</div>
<div class="widget-content" style="height:250px !important;">


   <form id="user_sch" action="<?php echo site_url("admin/sales/admsearch_sales");?>" enctype="multipart/form-data" method="post" >

  <!-- <div class="span3">
      <div class="form-group">

   	<td>
   	 <label for="text1" class="control-label col-lg-4">Select Party</label>
   	<select id="type"    name="type">
   				<option value="0">-Select Product-</option>
          <?php foreach($products as $prd){ ?>
   				<option  value="<?php echo $prd['id']; ?>"><?php echo $prd['name']; ?></option>
   				<?php } ?>
   					</select></td>
   </div>
 </div> -->

 <div class="span3">
    <div class="form-group">

   <td>
    <label for="text1" class="control-label col-lg-4">Select Branch</label>
   <select id="branch_id" name="branch_id" >
         <option value="0">-Select Branch-</option>
        <?php foreach($branch as $br){ ?>
         <option  <?php if($br['id']==$branch_id){ ?>  selected="selected" <?php } ?>  value="<?php echo $br['id']; ?>"><?php echo $br['name']; ?></option>
         <?php } ?>
           </select></td>
 </div>
 </div>

   <div class="span3">
      <div class="form-group">

   	<td>
   	 <label for="text1" class="control-label col-lg-4">Select Party</label>
   	<select id="customer_id" class="chosen-select" style="height:500px !important;"   name="customer_id">
   				<option value="0">-Select Party-</option>
   				<?php foreach($customer as $pr){ ?>
   				<option <?php if($pr['id']==$customer_id){ ?> selected="selected" <?php } ?>  value="<?php echo $pr['id']; ?>"><?php echo $pr['name']; ?></option>
   				<?php } ?>
   					</select></td>
   </div>
   </div>

   <div class="span3">
      <div class="form-group">
                       <label for="text1" class="control-label col-lg-4">Start Date</label>
                       <div class="col-lg-8">
   					<input type="text" id="start_date" value="<?php echo $start_date; ?>"  name="start_date" class="form-control">
   					 </div>
                   	</div>

   </div>




   <div class="span3">
      <div class="form-group">
                       <label for="text1" class="control-label col-lg-4">End Date</label>
                       <div class="col-lg-8">
   					<input type="text" id="end_date" value="<?php echo $end_date; ?>"  name="end_date" class="form-control">
   					 </div>
                   	</div>

   </div>



   <div class="span2"><br/>
     <input type="submit" id="tags"  value="Search" class="btn btn-primary" />
   </div>
   </form>

</div>
</div>
<p class="pull-right ">

   						<a href="<?= site_url('admin/gst/index') ?>"><input type="button" value="New Sales" class="btn btn-primary"> </a></p>
<table class="table table-striped table-bordered table-hover">


									<thead>
										<tr>
										<th>SL NO.</th>
										<th>DATE</th>
										<th>VEHICLE NO</th>
										<th>VEHICLE OWNER</th>
										<th>CUSTOMER NAME</th>
										<th>AMOUNT</th>
                    <th>Status</th>
										<?php  foreach ($products as $pm){?>
										<th style="color: red"><?php echo $pm['name'];?></th>
										<?php }?>
<th>Remarks</th>
                  	<th>Action</th>
										</tr>
									</thead>

									<tbody>
<?php $sm=1; foreach ($sales as $fm){
		$allitem = $fm['allitem'];
	?>
<tr>
<td><?php echo $fm['sl_no'];?></td>
<td><?php echo $fm['bill_date'];?></td>
<td><?php echo $fm['vehicle_number'];?></td>
<td><?php echo $fm['vehicle_owner'];?></td>
<td><?php echo $fm['customername'];?></td>
<td><?php echo $fm['total_amount'];?></td>
<td><?php if($fm['payment_status']==0){ ?>  UNPAID <?php } ?> <?php if($fm['payment_status']==1){ ?>  PAID <?php } ?></td>
<?php  foreach ($allitem as $am){?>
										<td style="color: red"><b><?php echo $am['stock'];?></b></td>
										<?php }?>

<td><?php echo $fm['paiddetails'];?></td>
<td>
<?php if($fm['trash']==0){ ?>

<?php if($fm['status']==0){ ?>
<a href="<?php echo site_url('admin/gst/edit_sales')."/".$fm['id']; ?>">Edit</a> &nbsp; | &nbsp;<a href="<?php echo site_url('admin/gst/delete')."/".$fm['id']; ?>">Delete</a> | &nbsp;<a href="<?php echo site_url('admin/gst/approve')."/".$fm['id']; ?>">APPROVE</a>
<?php }else{ ?>
APPROVED | &nbsp;<a href="<?php echo site_url('admin/gst/chalan')."/".$fm['id']; ?>">PRINT</a>

<?php if($this->session->userdata('user_id')==1){ ?> | <a href="<?php echo site_url('admin/gst/edit_sales')."/".$fm['id']; ?>">EDIT</a> &nbsp;  | <a href="<?php echo site_url('admin/gst/delete')."/".$fm['id']; ?>">DELETE</a>   <?php } ?>
<?php } ?>
<?php } ?>
<?php if($fm['trash']==1){ ?>
DELETED
<?php } ?>

</td>
</tr>
<?php } ?>


									</tbody>


</table>



<?php echo $pagination; ?>

<div  id="main-table">


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
              $( "#start_date" ).datepicker({
          		changeMonth: true,
                      changeYear: true,
          	});

          	 $( "#end_date" ).datepicker({
          		changeMonth: true,
                      changeYear: true,
          	});
            });

            </script>
            <script src="<?php echo base_url();?>assets/chosen/chosen.jquery.js" type="text/javascript"></script>

                <script type="text/javascript">

                     var config = {
                  '.chosen-select'           : {},
                  '.chosen-select-deselect'  : {allow_single_deselect:true},
                  '.chosen-select-no-single' : {disable_search_threshold:10},
                  '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                  '.chosen-select-width'     : {width:"95%"}
                }
                for (var selector in config) {
                  $(selector).chosen(config[selector]);
                }

            </script>
