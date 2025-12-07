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
   <h2>Student Payment</h2>

<div class="widget ">


<div class="widget-content">
<form id="user_sch" action="<?php echo site_url("admin/account/interview_report");?>" enctype="multipart/form-data" method="post" >	






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
					<input type="text" id="end_date" value="<?php echo $end_date; ?>" name="end_date" class="form-control">
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
   <h2>view Account (INTERVIEW)</h2>

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
<th colspan="6"><h3>Transaction Details Between  <?php echo  date('d-m-Y',strtotime($start_date)); ?> AND <?php echo  date('d-m-Y',strtotime($end_date)); ?></h3> </th>										

										
										</tr>						
										<tr>
<th>Date</th>										
<th>Collection</th>
<th>Colection(221)</th>
<th>Refund</th>
<th>Total</th>
<th>Action</th>

										
										</tr>
									</thead>

									<tbody>
<?php $sm=1;$tp=0; $lp = 0; $or_t=0; $rf= 0;  foreach ($report as $fm){
	
	$tp= $tp+$fm['credit'];
	
	?>
<tr>
<td><?php echo $fm['date'];?></td>
<td><?php echo $fm['credit'];?></td>
<td><?php  $or_t=$or_t+$fm['credit_otr']; echo $fm['credit_otr'];?></td>
<td><?php  $rf= $rf+$fm['debit'];  echo $fm['debit'];?></td>
<td><?php  $x = $fm['credit']+$fm['credit_otr']-$fm['debit']; echo $x;?></td>

<td><a href="<?php echo site_url('admin/account/view_interview')."/".$fm['date']."/".date('Y-m-d',strtotime($start_date))."/".date('Y-m-d',strtotime($end_date)); ?>">View Details</a> &nbsp; </td>


</tr>

	
<?php 
$lp = $lp+$x;
} ?>

	<tr>
<th>Total Amount</th>										
<td><?php echo $tp; ?></td>
<td><?php echo $or_t; ?></td>
<td><?php echo $rf; ?></td>
<td><?php echo $lp; ?></td>
							<td>&nbsp;</td>			
										</tr>
									</tbody>


</table>




<hr/>



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
