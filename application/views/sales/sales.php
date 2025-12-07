
<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js" type="text/javascript" ></script>
<link href="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.css" />


<script>
$(document).ready(function() {
        $('#form_table').DataTable({
                responsive: true
        });
    });


</script>

<script type="text/javascript">
  function PrintDiv() {    
           var divToPrint = document.getElementById('print');
          	var popupWin = window.open('', '_blank', 'width=800,height=800');
          	popupWin.document.open();
           	popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
            popupWin.document.close();
                }
				
				
 function excel_export(){

	var content = document.getElementById('print').innerHTML;
	
	$('#hiddenExportText').val(content);

	document.getElementById("hiddenForm").submit();

}				
				
				
				
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
<form id="user_sch" action="<?php echo site_url("admin/account/other_report");?>" enctype="multipart/form-data" method="post" >	


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
   <h2>view Account (MISC)</h2>

</div>
</div>
<p class="pull-right ">  

   						<a href="<?= site_url('admin/account/index') ?>"><input type="button" value="New Payment" class="btn btn-primary"> </a></p>

						<div id="json"> </div>
<form style="display:hidden" name="hiddenForm" id="hiddenForm" method="post" action="<?php echo site_url('admin/report/export'); ?>" >
        <input type="hidden" id="hiddenExportText" name="hiddenExportText">
        
        </form>
       <input type="button" class="btn pull-right" value="Export to Excel" onclick = "excel_export();" class="button">

<div><input type="button" value="Print" class="btn-success" onclick="PrintDiv();"> </div>
<div id="print" class="print">
						
						<table class="table table-striped table-bordered table-hover" >

									<thead>
										<tr>
										<th>SL NO.</th>
										<th>DATE</th>
										<th>VEHICLE NO</th>
										<th>VEHICLE OWNER</th>
										<th>CUSTOMER NAME</th>
										<th>AMOUNT</th>
										<?php if (isset($products) && !empty($products)) { ?>
											<?php foreach ($products as $pm) { ?>
											<th style="color: red"><?php echo $pm['name']; ?></th>
											<?php } ?>
										<?php } ?>
										<th>Action</th>
										</tr>
									</thead>

									<tbody>
<?php $sm=1; foreach ($account as $fm){?>
<tr>
<td><?php echo $fm['sl_no'];?></td>
<td><?php echo $fm['bill_date'];?></td>
<td><?php echo $fm['vehicle_no'];?></td>
<td><?php echo $fm['vehicle_owner'];?></td>
<td><?php echo $fm['customer_id'];?></td>
<td><?php echo isset($fm['total_amount']) ? $fm['total_amount'] : ''; ?></td>
<?php if (isset($products) && !empty($products)) { ?>
	<?php
	/* 
	 * DISPLAY ALL PRODUCTS FOR EACH TRANSACTION
	 * - Shows quantity if product exists in this transaction
	 * - Shows blank cell if product not in this transaction
	 * - Ensures consistent column alignment across all rows
	 */
	 
	// Create array for quick lookup of quantities by product_id if allitem exists
	$sale_quantities = array();
	if (isset($fm['allitem']) && is_array($fm['allitem'])) {
		foreach ($fm['allitem'] as $am) {
			$sale_quantities[$am['product_id']] = $am['stock'];
		}
	}
	
	// Show all products, with quantity if exists, blank if not
	foreach ($products as $pm) {
		$quantity = isset($sale_quantities[$pm['id']]) ? $sale_quantities[$pm['id']] : '';
	?>
	<td style="color: red; text-align: center;"><b><?php echo $quantity; ?></b></td>
	<?php } ?>
<?php } ?>
<td><!--<a href="<?php echo site_url('admin/account/edit_account')."/".$fm['id']; ?>">Edit</a> &nbsp; | &nbsp;<a href="<?php echo site_url('admin/account/delete')."/".$fm['id']; ?>">Delete</a>--></td>
</tr>
<?php } ?>


									</tbody>


</table>

</div>
 

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

