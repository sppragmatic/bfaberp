
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
 



 
 
<div class="widget ">
<div class="widget-content">
   <h2>Transaction Details Of <?php echo  date('d-m-Y',strtotime($dt)); ?> 
   
  
   </h2>
<br/>
   
   <form method="post" action="<?php echo site_url('admin/account/view_allfilter') ?>">
   <select name="filter">
<option <?php if($filter=='0'){ ?> selected="selected" <?php } ?> value="0">All</option>
   <option <?php if($filter=='1'){ ?> selected="selected" <?php } ?> value="1">Admission/installment</option>
<option <?php if($filter=='2'){ ?> selected="selected" <?php } ?> value="2">Monthly</option>
<option <?php if($filter=='3'){ ?> selected="selected" <?php } ?> value="3">Misc Payment</option>
<option <?php if($filter=='4'){ ?> selected="selected" <?php } ?> value="4">Interview</option>
<option <?php if($filter=='7'){ ?> selected="selected" <?php } ?> value="7">Rejoin</option>

</select>
<input type="hidden" name="start_date" value="<?php echo $start_date; ?>">
<input type="hidden" name="end_date" value="<?php echo $end_date; ?>">
<input type="hidden" name="dt" value="<?php echo $dt; ?>">

<input type="submit" class="btn btn-primary" value="Search">
   </form>
   <p class="pull-right"><a href="<?php echo site_url('admin/account/misc_report')."/".$start_date."/".$end_date ; ?>" class="btn btn-primary">Back</a></p>
</div>
</div>
<div id="json"> </div>

<form style="display:hidden" name="hiddenForm" id="hiddenForm" method="post" action="<?php echo site_url('admin/report/export'); ?>">
        <input type="hidden" id="hiddenExportText" name="hiddenExportText">
        
        </form>
      <input type="button" class="btn pull-right" value="Export to Excel" onclick = "excel_export();" class="button">

<div><input type="button" value="Print" class="btn-success" onclick="PrintDiv();"> </div>
<div id="print" class="print">
<table class="table table-striped table-bordered table-hover">

									<thead>
									
									<tr>
<th colspan="6"><h3>Transaction Details 215 Of <?php echo  date('d-m-Y',strtotime($dt)); ?>    &nbsp;( <?php if($filter=='0'){ ?> ALL <?php } ?>
   <?php if($filter=='1'){ ?> Admission/Installment<?php } ?>
   <?php if($filter=='2'){ ?> Monthly <?php } ?>
 <?php if($filter=='3'){ ?> Mis Payment Report<?php } ?>
  <?php if($filter=='4'){ ?> Interview <?php } ?>
   )</h3></th>										

										
										</tr>
										<tr>
<th>SL No</th>										
<th>User Id</th>										
<th>Name</th>										
<th>Remarks</th>
<th>type</th>
<th>Total Amount</th>
										
										</tr>
									</thead>

									<tbody>
<?php $sm=1;$tp=0; foreach ($report as $fm){
	
	$tp= $tp+$fm['amt_paid'];
	?>
<tr>
<td>Sl NO : <?php echo  $fm['s_id']; ?></td>
<td> <?php echo  $fm['username']; ?></td>
<td><?php echo  $fm['name']; ?></td>

<td><?php echo $fm['remarks'];?></td><td><?php if($fm['status']==1){  echo "Admision /Installment";  }else if($fm['status']==2){ echo "Monthly Payment";   }else if($fm['status']==3){  echo "Rejoin";  }else{ echo "Other"; } ?></td>
<td><?php echo $fm['amt_paid'];?></td>

</tr>

	
<?php } ?>

	<tr>
<th>Total Amount</th>										

<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
						
<td><b><?php echo $tp; ?> </b></td>	

									</tr>
									</tbody>


</table>






<table class="table table-striped table-bordered table-hover">

									<thead>
									
									<tr>
<th colspan="6"><h3>Transaction Details 221 Of  <?php echo  date('d-m-Y',strtotime($dt)); ?></h3></th>										

										
										</tr>
										<tr>
<th>SL No</th>										
<th>User Id</th>										
<th>Name</th>										
<th>Remarks</th>
<th>type</th>
<th>Total Amount</th>
										
										</tr>
									</thead>

									<tbody>
<?php $sm=1;$tp=0; foreach ($otr_report as $fm){
	
	$tp= $tp+$fm['amt_paid'];
	?>
<tr>
<td>Sl NO : <?php echo  $fm['s_id']; ?></td>
<td> <?php echo  $fm['username']; ?></td>
<td><?php echo  $fm['name']; ?></td>

<td><?php echo $fm['remarks'];?></td><td><?php if($fm['status']==1){  echo "Admision /Installment";  }else if($fm['status']==2){ echo "Monthly Payment";   }else if($fm['status']==3){  echo "Rejoin";  }else{ echo "Other"; } ?></td>
<td><?php echo $fm['amt_paid'];?></td>

</tr>

	
<?php } ?>

	<tr>
<th>Total Amount</th>										

<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
						
<td><b><?php echo $tp; ?> </b></td>		

							</tr>
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

