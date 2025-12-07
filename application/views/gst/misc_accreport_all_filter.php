
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
   <h2> Transaction Details Of <?php echo  date('d-m-Y',strtotime($dt)); ?></h2>
<p class="pull-right"><a href="<?php echo site_url('admin/account/misc_acreport')."/".$start_date."/".$end_date ; ?>" class="btn btn-primary">Back</a></p>
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
<th colspan="7"><h3>Party Transaction Details Of <?php echo  date('d-m-Y',strtotime($dt)); ?></h3></th>										

										
										</tr>
										<tr>
<th>SL No</th>										
<th>Transaction No</th>										
<th>Name</th>										
<th>Code</th>
<th>Entry Date</th>
<th>Type</th>
<th>Amoutnt</th>
										
										</tr>
									</thead>

									<tbody>
<?php $sm=1;$tp=0; foreach ($report as $fm){
	
	//$tp= $tp+$fm['amount'];
	?>
<tr>
<td> <?php echo  $fm['s_id']; ?></td>
<td><?php echo  $fm['trans_no']; ?></td>
<td><?php echo  $fm['name']; ?></td>
<td><?php echo $fm['code'];?></td>
<td><?php echo $fm['entry_date'];?></td>
<td><?php if($fm['type']=='1'){ ?> Money Receive <?php } ?> <?php if($fm['type']=='2'){ ?>Payment <?php } ?></td>
<td><?php echo $fm['amount'];?></td>


</tr>

	
<?php } ?>

<!--	<tr>
<th>Total Amount</th>										

<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
						
<td><b><?php echo $tp; ?> </b></td>										</tr>-->
									</tbody>


</table>





<table class="table table-striped table-bordered table-hover">

									<thead>
									
									<tr>
<th colspan="5"><h3>Student Transaction Details Of <?php echo  date('d-m-Y',strtotime($dt)); ?></h3></th>										

										
										</tr>
										<tr>
<th>SL No</th>										
<th>User Id</th>										
<th>Name</th>										
<th>Remarks</th>
<th>Total Amount</th>
										
										</tr>
									</thead>

									<tbody>
<?php $sm=1;$tp=0; foreach ($student_report as $fm){
	
	$tp= $tp+$fm['amt_paid'];
	?>
<tr>
<td>Sl NO : <?php echo  $fm['s_id']; ?></td>
<td> <?php echo  $fm['username']; ?></td>
<td><?php echo  $fm['name']; ?></td>
<td><?php echo $fm['remarks'];?></td>
<td><?php echo $fm['amt_paid'];?></td>

</tr>

	
<?php } ?>

	<tr>
<th>Total Amount</th>										

<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
						
<td><b><?php echo $tp; ?> </b></td>										</tr>
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

