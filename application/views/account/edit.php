<link rel="stylesheet" href="<?php echo base_url();?>assets/css/sales-form.css">

<script>
function get_party(material_id){
	$.post("<?php echo site_url('admin/account/get_matparty'); ?>", { material_id : material_id  },function(msg){
/alert(msg);
		$('#party_id').html(msg);

	});
//	alert(course_id)
}

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

      <!-- Page Header -->
      <div class="page-header-card">
        <h1><i class="fas fa-edit"></i> Edit Material</h1>
        <p>Update material entry details</p>
      </div>

      <div class="row">
        <div class="span12">
          <div class="widget modern-widget">
            <div class="widget-header modern-header">
              <h3><i class="fas fa-box"></i> EDIT MATERIAL</h3>
            </div>
            <form action="<?php echo site_url('admin/account/edit_account')."/".$account['id']?>" method="post" class="modern-form">
              <div class="widget-content modern-content">
 <div class="table-responsive">
 <table class="table table-striped table-bordered table-hover" id="dataTables-example">



								<tr><th>Transaction No.</th>	<td><input class="form-control" name="trans_no" value="<?php echo $account['trans_no']; ?>" type="text"></td> </tr>
								<tr><th>Vehicle NO</th>	<td><input class="form-control" name="vehicle_no" value="<?php echo $account['vehicle_no']; ?>" type="text"></td> </tr>
								<tr><th>Material Name</th>
								<td><select id="material_id" name="material_id">
								<option value="">-Select Material-</option>
								<?php foreach($material as $pr){ ?>
								<option  <?php if($account['material_id']==$pr['id']){ ?> selected="selected" <?php } ?>   value="<?php echo $pr['id']; ?>"><?php echo $pr['name']; ?></option>
								<?php } ?>
								</select></td>  </tr>



								<tr><th>Party Name</th>
								<td><select id="party_id" name="party_id">
								<option value="">-Select Party-</option>
								<?php foreach($party as $pr){ ?>
								<option <?php if($account['party_id']==$pr['id']){ ?> selected="selected" <?php } ?>    value="<?php echo $pr['id']; ?>"><?php echo $pr['name']; ?></option>
								<?php } ?>
								</select></td>  </tr>

								<tr><th>Payment Type</th> <td>
									<select id="payment_status" onchange="sdisp(this.value)" name="payment_status">
										<option value="0">-Select Type-</option>
										<option <?php if($account['payment_status']=='1'){ ?> selected="selected" <?php } ?> value="1">Paid</option>
										<option <?php if($account['payment_status']=='0'){ ?> selected="selected" <?php } ?> value="0">Unpaid</option>
									</select>
								</td></tr>

								<!-- Payment details fields, only show if Paid -->
								<tr class="pmdetails" <?php if($account['payment_status']!='1'){ ?>style="display:none"<?php } ?>>
									<th>Paid Amount</th>
									<td><input name="paid_amount" value="<?php echo $account['paid_amount']; ?>" type="text"></td>
								</tr>
								<tr class="pmdetails" <?php if($account['payment_status']!='1'){ ?>style="display:none"<?php } ?>>
									<th>Payment Type</th>
									<td>
										<input type="radio" <?php if($account['type']=='1'){ ?> checked="checked" <?php } ?> name="type" value="1"> Cash
										<input type="radio" <?php if($account['type']=='2'){ ?> checked="checked" <?php } ?> name="type" value="2"> Cheque
									</td>
								</tr>
								<tr class="pmdetails" <?php if($account['payment_status']!='1'){ ?>style="display:none"<?php } ?>>
									<th>Payment Details</th>
									<td><textarea name="paiddetails"><?php echo $account['paiddetails']; ?></textarea></td>
								</tr>

  				<tr> <th>Ref No</th><td> <input name="refno" value="<?php echo $account['refno']; ?>" type="text"></td>   </tr>
					<tr> <th>Quantity</th><td> <input name="stock" value="<?php echo $account['stock']; ?>" type="text"></td>   </tr>
					<tr> <th>Unit</th><td> <input name="unit" value="<?php echo isset($account['unit']) ? $account['unit'] : ''; ?>" type="text" placeholder="e.g. kg, litre, pcs"></td>   </tr>
									  <tr> <th>Amount</th><td> <input name="amount" value="<?php echo $account['amount']; ?>" type="text"></td>   </tr>
								<tr><th>Date</th><td><input id="date" name="entry_date" value="<?php echo $account['entry_date']; ?>" type="text"></td>  </tr>
								<tr><th>Remarks</th><td><textarea name="remarks"><?php echo $account['remarks']; ?></textarea></td>  </tr>
							     <tr><th colspan="2" align="right"> <input type="submit" value="Update" class="btn btn-primary pull-right"></th></tr>

                                 </table>
</div>
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

  </script>
