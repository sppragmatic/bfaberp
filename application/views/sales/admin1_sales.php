
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
<div class="widget-content">
   <h2>view sales</h2>

</div>
</div>
<p class="pull-right ">  

   						<a href="<?= site_url('admin/sales/index') ?>"><input type="button" value="New Sales" class="btn btn-primary"> </a></p>
<table class="table table-striped table-bordered table-hover">

									
									<thead>
										<tr>
										<th>SL NO.</th>
										<th>DATE</th>
										<th>VEHICLE NO</th>
										<th>VEHICLE OWNER</th>
										<th>CUSTOMER NAME</th>
										<th>AMOUNT</th>
										<?php  foreach ($products as $pm){?>
										<th style="color: red"><?php echo $pm['name'];?></th>
										<?php }?>
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
<?php  foreach ($allitem as $am){?>
										<td style="color: red"><b><?php echo $am['stock'];?></b></td>
										<?php }?>
<td>
<?php if($fm['trash']==0){ ?>

<?php if($fm['status']==0){ ?>
<a href="<?php echo site_url('admin/sales/edit_sales')."/".$fm['id']; ?>">Edit</a> &nbsp; | &nbsp;<a href="<?php echo site_url('admin/sales/delete')."/".$fm['id']; ?>">Delete</a> | &nbsp;<a href="<?php echo site_url('admin/sales/approve')."/".$fm['id']; ?>">APPROVE</a>
<?php }else{ ?>
APPROVED | &nbsp;<a href="<?php echo site_url('admin/sales/chalan')."/".$fm['id']; ?>">PRINT</a>
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


 

<div  id="main-table">


				<div class="pull-right"> 


</div>

</div>

                            </div>     

                        </div>

                    </div>

                </div>

            </div>




