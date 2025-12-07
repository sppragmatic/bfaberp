
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
   <h2>Transaction Details Of <?php echo  date('d-m-Y',strtotime($dt)); ?></h2>
<p class="pull-right"><a href="<?php echo site_url('admin/account/other_report')."/".$start_date."/".$end_date ; ?>" class="btn btn-primary">Back</a></p>
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
<th colspan="7"><h3>Transaction Details 215 Of <?php echo  date('d-m-Y',strtotime($dt)); ?></h3></th>


										</tr>
										<tr>
<th>SL No</th>
<th>User Id</th>
<th>Name</th>
<th>Remarks</th>
<th>type</th>
<th>Total Amount</th>
<th>Action</th>

										</tr>
									</thead>

									<tbody>
<?php $cd=0; $sm=1;$tp=0; foreach ($report as $fm){
$cd=$cd+1;
	$tp= $tp+$fm['amt_paid'];
	?>
<tr>
<td>Sl NO : <?php echo  $fm['s_id']; ?></td>
<td> <?php echo  $fm['username']; ?></td>
<td><?php echo  $fm['name']; ?></td>

<td><?php echo $fm['remarks'];?></td><td><?php if($fm['status']==1){  echo "Admision /Installment";  }else if($fm['status']==2){ echo "Monthly Payment";   }else if($fm['status']==3){  echo "Rejoin";  }else{ echo "Other"; } ?></td>
<td><?php echo $fm['amt_paid'];?>
  <div class="<?php echo $cd; ?>" style="display:none">
  			<input type="text" class="span1" id="edit_paid_<?php echo $cd; ?>"  value="<?php echo $fm['amt_paid']; ?>"  >
  </div>

</td>
<td>
  <div id="edit_<?php echo $cd; ?>">
  <a class="btn btn-success" onclick="edit_data(<?php echo $cd; ?>)" > <i class="icon-edit"></i>Edit</a> ||
  </div>

  <div id="save_<?php echo $cd; ?>" style="display:none">
  <a class="btn btn-success" onclick="save_data(<?php echo $cd; ?>,<?php echo $fm['s_id'] ?>)" > <i class="icon-save"></i>Save</a> ||
  </div>
</td>
</tr>


<?php } ?>

	<tr>
<th>Total Amount</th>

<td>&nbsp;</td>
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
<th colspan="6"><h3>Transaction Details 221 Of  <?php echo  date('d-m-Y',strtotime($dt)); ?>  (MISC)</h3></th>


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
  <script>

  function edit_data(idc){
		var x = confirm("Are Your Sure To Edit The Payment");
		if(x){
		var cl = "."+idc;
		$(cl).show();
		var e =  "#edit_"+idc;
		var s =  "#save_"+idc;
		$(e).hide();
		$(s).show();
		}
	}

	function save_data(idc, s_id){
		var x = confirm("Are Your Sure To Update The Payment");
		if(x){
		var ap = "#edit_paid_"+idc;
	   var amt_paid =  $(ap).val();


	//alert(amt_paid);
		//alert(disc);
		//alert(paid_date);
		$.post("<?php echo site_url("admin/account/update_misc")?>",{ id: s_id, amt_paid : amt_paid },function(msg){
			//alert(msg)
			if(msg==1){
				alert("Payment Successfully Updated!");
				//$("#edit").show();
				//$("#save").hide();

			}else{
				alert("Unable to update the Payment!");
			}

		})
		}

	}


  </script>
