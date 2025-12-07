
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
   <h2>All Transaction</h2>

<div class="widget ">


<div class="widget-content">
<form id="user_sch" action="<?php echo site_url("admin/account/misc_report");?>" enctype="multipart/form-data" method="post" >	


<div class="span3">
   <div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Start Date</label>
                    <div class="col-lg-8">
					<input type="text" id="start_date" name="start_date" class="form-control">
					 </div>
                	</div>

</div>




<div class="span3">
   <div class="form-group">
                    <label for="text1" class="control-label col-lg-4">End Date</label>
                    <div class="col-lg-8">
					<input type="text" id="end_date" name="end_date" class="form-control">
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


<div class="widget ">
<div class="widget-content">
   <h2>view Account</h2>

</div>
</div>
<p class="pull-right ">  

   						<a href="<?= site_url('admin/account/index') ?>"><input type="button" value="New Payment" class="btn btn-primary"> </a></p>
<table class="table table-striped table-bordered table-hover" >

									<thead>
										<tr>
										<th>Transaction Id</th>
										<th>Party Name</th>
										<th>Type</th>
										<th>Amount</th>
										<th>Date</th>
										<th>Remarks</th>
										<th>Action</th>
										</tr>
									</thead>

									<tbody>
<?php $sm=1; foreach ($account as $fm){?>
<tr>
<td><?php echo $fm['trans_no'];?></td>
<td><?php echo $fm['party_name'];?></td>
<td><?php if($fm['type']=='1'){ ?> Money Receive <?php } ?> <?php if($fm['type']=='2'){ ?>Payment <?php } ?></td>
<td><?php echo $fm['amount'];?></td>
<td><?php echo $fm['entry_date'];?></td>
<td><?php echo $fm['remarks'];?></td>
<td><!--<a href="<?php echo site_url('admin/account/edit_account')."/".$fm['id']; ?>">Edit</a> &nbsp; | &nbsp;<a href="<?php echo site_url('admin/account/delete')."/".$fm['id']; ?>">Delete</a>--></td>
</tr>
<?php } ?>


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

