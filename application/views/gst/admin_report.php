
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
   <h2>VIEW SALES ACCOUNT REPORT</h2>
</div>
<div class="widget-content">


   <form id="user_sch" action="<?php echo site_url("admin/sales/getreport");?>" enctype="multipart/form-data" method="post" >

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
   	 <label for="text1" class="control-label col-lg-4">Select Party</label>
   	<select id="customer_id"  required="required"  name="customer_id">
   				<option value="0">-Select Party-</option>
   				<?php foreach($customer as $pr){ ?>
   				<option <?php if($pr['id']==$customer_id){ ?> selected="selected" <?php } ?>  value="<?php echo $pr['id']; ?>"><?php echo $pr['name']; ?></option>
   				<?php } ?>
   					</select></td>
   </div>
   </div>


    <div class="span3">
       <div class="form-group">

      <td>
       <label for="text1" class="control-label col-lg-4">Select Branch</label>
      <select id="branch_id" name="branch_id" >
            <option value="0">-All Branch-</option>
           <?php foreach($branch as $br){ ?>
            <option  <?php if($br['id']==$branch_id){ ?>  selected="selected" <?php } ?>  value="<?php echo $br['id']; ?>"><?php echo $br['name']; ?></option>
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

   						<a href="<?= site_url('admin/sales/index') ?>"><input type="button" value="New Sales" class="btn btn-primary"> </a></p>
<table class="table table-striped table-bordered table-hover">


									<thead>
										<tr>
										<th>SL NO.</th>
                    	<th>CUSTOMER NAME</th>
										<th>DATE</th>

										<th>PENDING</th>
                    <th>GIVEN</th>
                      <th>DUE</th>

										</tr>
									</thead>

									<tbody>
<?php $sm=1;
$tc = 0;
$td = 0;
foreach ($sales as $fm){
  $tc = $tc+$fm['credit'];
  $td = $td+$fm['debit'];

  ?>
<tr>
<td><?php echo $fm['invno'];?></td>
<td><?php echo $fm['customername'];?></td>
<td><?php echo $fm['entry_date'];?></td>
<td><?php echo $fm['credit'];?></td>
<td><?php echo $fm['debit'];?></td>
<td><?php  if($fm['credit']!=0){ echo $fm['credit']-$fm['debit']; }else{  echo "------";   } ?></td>
</tr>
<?php } ?>
<tr>
<td>Total</td>
<td></td>
<td></td>
<td><?php echo $tc;?></td>
<td><?php echo $td; ?></td>
<td><?php echo $tc-$td; ?></td>
</tr>

									</tbody>


</table>




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
              $( "#date" ).datepicker({
          		changeMonth: true,
                      changeYear: true,
          						dateFormat: 'dd-mm-yy'
          	});

          	 $( "#doj" ).datepicker({
          		changeMonth: true,
                      changeYear: true,
          						dateFormat: 'dd-mm-yy'
          	});
            });

            </script>
