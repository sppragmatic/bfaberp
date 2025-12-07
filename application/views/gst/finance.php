
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
<div class="main">

  <div class="main-inner">

    <div class="container">


  <div class="row">

   <div class="span12">
   <h2>Finanace Report</h2>

<div class="widget ">


<div class="widget-content">
<form id="user_sch" action="<?php echo site_url("admin/account/get_all");?>" enctype="multipart/form-data" method="post" >	


<div class="span3">
   <div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Start Date</label>
                    <div class="col-lg-8">
					<input type="text" id="start_date" name="start_date" value="<?php echo $start_date; ?>" class="form-control">
					 </div>
                	</div>

</div>




<div class="span3">
   <div class="form-group">
                    <label for="text1" class="control-label col-lg-4">End Date</label>
                    <div class="col-lg-8">
					<input type="text" id="end_date" name="end_date"  value="<?php echo $end_date; ?>" class="form-control">
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

   						</p>
						
						
	<form style="display:hidden" name="hiddenForm" id="hiddenForm" method="post" action="<?php echo site_url('admin/report/export'); ?>">
        <input type="hidden" id="hiddenExportText" name="hiddenExportText">
        
        </form>
      <input type="button" class="btn pull-right" value="Export to Excel" onclick = "excel_export();" class="button">

<div><input type="button" value="Print" class="btn-success" onclick="PrintDiv();"> </div>
<div id="print" class="print">						
<table class="table table-striped table-bordered table-hover" >

									<thead>
										<tr>
										<th>Party Name</th>
										<th>Credit</th>
										<th>Debit</th>
										</tr>
									</thead>

									<tbody>
<?php $sm=1; 
$to_c=0;
$to_d=0;
foreach ($all_cust as $fm){
$to_c=$to_c+$fm['credit'];
$to_d=$to_d+$fm['debit'];
	?>
<tr>

<td><?php echo $fm['party_name'];?></td>

<td><?php echo $fm['credit'];?></td>
<td><?php echo $fm['debit'];?></td>
</tr>
<?php } ?>
<tr>
<th>Total</th>
<th><?php echo $to_c; ?></th>
<th><?php echo $to_d; ?></th>
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

