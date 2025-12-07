
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
   <h2>Student Payment</h2>

<div class="widget ">


<div class="widget-content">
<form id="user_sch" action="<?php echo site_url("admin/account/get_report");?>" enctype="multipart/form-data" method="post" >	



<div class="span3">
   <div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Start Date</label>
                    <div class="col-lg-8">
					<input type="text" id="start_date" value="<?php echo $start_date; ?>" name="start_date" class="form-control">
					 </div>
                	</div>

</div>




<div class="span3">
   <div class="form-group">
                    <label for="text1" class="control-label col-lg-4">End Date</label>
                    <div class="col-lg-8">
					<input type="text" id="end_date" name="end_date" value="<?php echo $end_date; ?>" class="form-control">
					 </div>
                	</div>

</div>



<div class="span2"><br/>
  <input type="submit" id="tags"  value="Search" class="btn btn-primary" />
</div>
</form>

</div>
 </div>     
 </div>     
 </div>   



      <div class="row">

   <div class="span12">
 
<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> <?php echo $this->session->flashdata('msg'); ?>
</div>

<!--<p class="pull-right ">  

   						<a href="<?= site_url('admin/account/index') ?>"><input type="button" value="New Payment" class="btn btn-primary"> </a></p>
--><table class="table table-striped table-bordered table-hover">

									<thead>
										<tr>
										<th>Date</th>
										<th>Credit</th>
										<th>Debit</th>
										<th>Action</th>
										</tr>
									</thead>

									<tbody>
<?php
$t_c = 0;
$t_d = 0; 
 $sm=1; foreach ($account as $fm){
$t_c =$t_c+$fm['credit'];
$t_b =$t_c+$fm['debit'];

	
	?>
<tr>
<td><?php echo $fm['entry_date'];?></td>
<td><?php echo $fm['credit'];?></td>
<td><?php echo $fm['debit'];?></td>
<td><a href="<?php echo site_url('admin/account/view_details')."/".$fm['entry_date']; ?>">View Details</a></td>
</tr>
<?php } ?>

<tr>
<td><b>Total</b></td>
<td><b><?php echo $t_c;?></b></td>
<td><b><?php echo $t_b;?></b></td>
<td><b>&nbsp;</b></td>
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

