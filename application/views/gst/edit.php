<script>
function get_course_category(course_id){
	$.post("<?php echo site_url('admin/admission/get_course_category'); ?>", { course_id : course_id  },function(msg){

		$('#cr_ctg').html(msg);

	});
//	alert(course_id)
}

function sdisp(st){
	if(st=='1'){
	$(".pmdetails").show();
	}else{
		$(".pmdetails").hide();
	}

}


function get_course_ctgy_price(ctgy){
	//alert($('#cr_ctg').val());
	var course_id = $('#cr_cor').val();
	var branch_id = $('#cr_br').val();

	$.post("<?php echo site_url('admin/admission/get_course_ctgy_price'); ?>", { course_id : course_id, category_id : ctgy, branch_id : branch_id  },function(msg){
	//alert(msg)
		$('#price').val(msg);

	});
//	alert(course_id)


}

</script>
<script src="<?php echo base_url()?>assets/validate/dist/jquery.validate.js"></script>				<script>

	$().ready(function() {
		// validate the comment form when it is submitted

		// validate signup form on keyup and submit
		$("#rejoin-form").validate({
			rules: {
				'course': "required",
				'course_ctgy': "required"

			},
			messages: {
				'course': "Please choose your course",
				'course_ctgy': "Please choose COURSE CATEGORY"

			}
		});

		// propose username by combining first- and lastname

	});
			</script>

<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <?php echo validation_errors(); ?>
</div>


<div class="main">

  <div class="main-inner">

    <div class="container">




    <div class="row">
 <div class="span6">
<div class="widget ">
<div class="widget-header">
<h3>EDIT GST BILL </h3>

</div>

 <form action="<?php echo site_url('admin/gst/edit_sales')."/".$sales['id']?>" method="post">

 <div class="table-responsive">
 <table class="table table-striped table-bordered table-hover" id="dataTables-example">



								<tr><th>SL No.</th>	<td><input class="form-control" readonly="readonly" name="sl_no" value="<?php echo $sales['sl_no']; ?>" type="text"></td> </tr>
								<tr><th>Name OF PURCHASE</th>
					<td>
					<div id="cid">
					<select id="customer_id"    name="customer_id">
				<option value="">-Select customer-</option>
				<?php foreach($customer as $pr){ ?>
				<option  <?php if($sales['customer_id']==$pr['id']){ ?> selected="selected" <?php } ?>    value="<?php echo $pr['id']; ?>"><?php echo $pr['name']; ?></option>
				<?php } ?>
					</select><span style="padding-left: 30px"><a onclick="cn()"><i class="icon-plus"></i></a></span>
		</div>

			<div id="cn" style="display: none;">
					<input id="customer_name"    name="customer_name">
				<span style="padding-left: 30px"><a onclick="cid()"><i class="icon-minus"></i></a></span>
		</div>

					</td>  </tr>

 <tr> <th>GST NO</th><td> <input name="gst_no"  value="<?php echo $sales['gst_no']; ?>"  type="text"></td>   </tr>

						        <tr> <th>VEHICLE NUMBER</th><td> <input value="<?php echo $sales['vehicle_number']; ?>" name="vehicle_number" type="text"></td>   </tr>

						        <tr> <th>VEHICLE OWNER</th><td> <input value="<?php echo $sales['vehicle_owner']; ?>" name="vehicle_owner" type="text"></td>   </tr>

								<tr><th>DELIVERY POINT ADDRESS</th><td><textarea name="address"> <?php echo $sales['address']; ?></textarea></td>  </tr>
								<tr><th>DATE</th><td><input id="date" name="bill_date" value="<?php echo $sales['bill_date']; ?>" type="text"></td>  </tr>

								<tr><th>Payment Type</th> <td><select id="payment_status"  onchange="sdisp(this.value)"  name="payment_status">
				<option value="0">-Select Type-</option>
				<option <?php if($sales['payment_status']=='1'){ ?> selected="selected" <?php } ?>  value="1">Paid</option>
				<option <?php if($sales['payment_status']=='2'){ ?> selected="selected" <?php } ?>  value="2">Unpaid</option>
					</select></td>  </tr>

					<tr <?php if($sales['payment_status']=='2'){ ?>style="display:none" <?php } ?> class="pmdetails"><th>Paid Amount</th><td><input type="text"  name="paid_amount" value="<?php echo $sales['paid_amount']; ?>" > </td>  </tr>

						<tr <?php if($sales['payment_status']=='2'){ ?>style="display:none" <?php } ?> class="pmdetails"><th>Payment Type</th><td>
							<input type="radio" <?php if($sales['type']=='1'){ ?> checked="checked" <?php } ?>  name="type" value="1" > Cash
								<input type="radio" <?php if($sales['type']=='2'){ ?> checked="checked" <?php } ?>   name="type" value="2" > Cheque
						 </td>  </tr>

<tr  <?php if($sales['payment_status']=='2'){ ?>style="display:none" <?php } ?> class="pmdetails"><th>Paymet Details</th><td><textarea name="paiddetails"><?php echo $sales['paiddetails']; ?></textarea></td>  </tr>


                                 </table>
</div>

</div>
</div>

 <div class="span6">
<div class="widget ">
<div class="widget-header">
<h3>ITEM DETAILS</h3>

</div>

 	<table class="table table-striped table-bordered table-hover">

									<thead>
										<tr>
<th>PRODUCT</th>
<th>QUANTITY</th>
<th>AMOUNT</th>

										</tr>
									</thead>

									<tbody>
<?php $sm=1; foreach ($products as $fm){?>
<tr>
<td><?php echo $fm['name'];?></td>
<td><input name="prod[<?php echo $fm['id'];?>]" value="<?php echo $fm['stock'];?>" type="text"></td>
<td><input name="amount[<?php echo $fm['id'];?>]" value="<?php echo $fm['amount'];?>" type="text"></td>
</tr>
<?php } ?>



							     <tr ><th colspan="3" align="right"> <input type="submit" value="Submit" class="btn btn-primary pull-right"></th></tr>
									</tbody>


</table>




								 </form>

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
    $( "#date" ).datepicker({
		changeMonth: true,
            changeYear: true,
						dateFormat: 'dd-mm-yy'
	});

	 $( "#doj" ).datepicker({
		changeMonth: true,
            changeYear: true,
						dateFormat: 'dd-mm-yy'
	});
  });

  function cid(){
   $( "#cid" ).show();
    $( "#cn" ).hide();

  	}

  function cn(){
  	 $( "#cid" ).hide();
    $( "#cn" ).show();
  	}

  </script>
