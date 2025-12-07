<link rel="stylesheet" href="<?php echo base_url();?>assets/css/sales-form.css">

<script>
function get_course_category(course_id){
	$.post("<?php echo site_url('admin/admission/get_course_category'); ?>", { course_id : course_id  },function(msg){

		$('#cr_ctg').html(msg);

	});
//	alert(course_id)
}

function sdisp(st){
	if(st=='1'){
	$("#pmdetails").show();
	}else{
		$("#pmdetails").hide();
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
        <h1><i class="fas fa-plus-circle"></i> Add Payment</h1>
        <p>Record payment transaction</p>
      </div>

      <div class="row">
        <div class="span12">
          <div class="widget modern-widget">
            <div class="widget-header modern-header">
              <h3><i class="fas fa-credit-card"></i> ADD PAYMENT</h3>

</div>

 <form action="<?php echo site_url('admin/account/add_payment')?>" method="post">
 <div class="table-responsive">
 <table class="table table-striped table-bordered table-hover" id="dataTables-example">



								<tr><th>SL No.</th>	<td><input class="form-control" readonly="readonly" name="sl_no" value="<?php echo $trans_no; ?>" type="text"></td> </tr>
								<tr><th>Name OF PURCHASE</th>
					<td>
					<div id="cid">
					<select id="party_id"    name="party_id">
				<option value="">-Select Party-</option>
				<?php foreach($customer as $pr){ ?>
				<option  value="<?php echo $pr['id']; ?>"><?php echo $pr['name']; ?></option>
				<?php } ?>
					</select>
		</div>



					</td>  </tr>

								<tr><th>DATE</th><td><input id="date" name="entry_date" type="text"></td>  </tr>

								<tr><th>Amount</th><td><input id="amount" name="debit" type="text"></td>  </tr>
								<tr><th>Payment Details</th><td><textarea id="details" name="details" ></textarea></td>  </tr>

								<tr><th></th><td><input id="submit" name="submit" class="btn btn-primary"  value="Submit" type="submit"></td>  </tr>

	                       </table>
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
    $( "#date" ).datepicker({
		changeMonth: true,
            changeYear: true,
	});

	 $( "#doj" ).datepicker({
		changeMonth: true,
            changeYear: true,
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

  	function setamount(amt,dis){


  alert($("#amount").value());
  /*	 var amount =  parseInt($("#amount").value());
  	 var cst =  parseInt(amt);
  	 alert(amonut);
  	 alert(cst)
  	 var ns = amount+cst;
  	 $("#amount").value(ns)*/

  	}

  </script>
