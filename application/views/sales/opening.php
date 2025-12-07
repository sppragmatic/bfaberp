
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
	<script>
	function get_next(page){
		//alert(page)
	$.post('<?= site_url('admin/account/more_payment'); ?>',{ page : page },function(msg){
	//alert(msg)
	$('#main-table').html(msg);
	
	})
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
   <h2>All Student Payment</h2>

<div class="widget ">


<div class="widget-content">


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


<p class="pull-right ">  

   						<a href="<?= site_url('admin/account/index') ?>"><input type="button" value="New Payment" class="btn btn-primary"> </a></p>

						<div id="json"> </div>
<form style="display:hidden" name="hiddenForm" id="hiddenForm" method="post" action="<?php echo site_url('admin/report/export'); ?>" >
        <input type="hidden" id="hiddenExportText" name="hiddenExportText">
        
        </form>
       <input type="button" class="btn pull-right" value="Export to Excel" onclick = "excel_export();" class="button">

<div><input type="button" value="Print" class="btn-success" onclick="PrintDiv();"> </div>
<div id="print" class="print">


<div  id="main-table">

               
			   
                       <div class="table-responsive">
 <table class="table table-striped table-bordered table-hover">

									<thead>
									
								
										<tr>
<th>SL No</th>										
<th>User Id</th>										
<th>Name</th>										
<th>Remarks</th>
<th>Type</th>
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
<td><?php echo $fm['remarks'];?></td>
<td><?php if($fm['status']==1){  echo "Admision /Installment";  }else if($fm['status']==2){ echo "Monthly Payment";   }else if($fm['status']==3){  echo "Rejoin";  }else{ echo "Other"; } ?></td>
<td><?php echo $fm['amt_paid'];?></td>

</tr>

	
<?php } ?>

	
									</tbody>


</table>
			

				<div class="pull-right"> 


<?php 
$page=0;
$curp=4;
for($i=0; $i<$curp; $i++)
{
$cur  = $i+1;
$pg_c = $page ;
?>
<?php if($num > $i){ ?>
<a onclick="get_next(<?php echo $i-1 ; ?>)" style="cursor:pointer; text-decoration:none;">
<b> <?php if($pg_c == $i){ echo '<font color="red">'.$cur."</font>";  }else{ echo $cur;  } ?></b>&nbsp;&nbsp;
</a>

<?php } ?> 

<?php } ?>


</div>
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

