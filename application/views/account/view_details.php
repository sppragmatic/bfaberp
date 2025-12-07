
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
   <h2>Account Summery Of  <?php echo $entry_date;?></h2>

</div>
</div>
<p class="pull-right ">  

   						<a href="<?= site_url('admin/account/index') ?>"><input type="button" value="New Payment" class="btn btn-primary"> </a></p>


<table class="table table-striped table-bordered table-hover" id="form_table">

									<thead>
										<tr>
										<th>Transaction Id</th>
										<th>Party Name</th>
										<th>Type</th>
										<th>Amount</th>
										<th>Date</th>
										</tr>
									</thead>

									<tbody>
<?php 
$t_c = 0;
$t_d = 0;
$sm=1; foreach ($account as $fm){
if($fm['type']==1){
	$t_c = $t_c+ $fm['amount'];
	
}
if($fm['type']==2){
$t_d = $t_d+$fm['amount'];
	
}


	?>
<tr>
<td><?php echo $fm['trans_no'];?></td>
<td><?php echo $fm['party_name'];?></td>
<td><?php if($fm['type']=='1'){ ?> Credit <?php } ?> <?php if($fm['type']=='2'){ ?>Debit <?php } ?></td>
<td><?php echo $fm['amount'];?></td>
<td><?php echo $fm['entry_date'];?></td>

</tr>
<?php } ?>


									</tbody>
<tr>
<th colspan="2">Total credit</th>
<th colspan="3"><?php echo $t_c; ?></th>
</tr >

<tr>
<th colspan="2">Total Debit</th>
<th colspan="3"><?php echo $t_d; ?></th>
</tr>


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




