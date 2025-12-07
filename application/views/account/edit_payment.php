<link rel="stylesheet" href="<?php echo base_url();?>assets/css/sales-form.css">

<script>
function get_course_category(course_id){
	$.post("<?php echo site_url('admin/admission/get_course_category'); ?>", { course_id : course_id  },function(msg){

		$('#cr_ctg').html(msg);

	});
//	alert(course_id)
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
        <h1><i class="fas fa-edit"></i> Edit Payment</h1>
        <p>Update payment transaction details</p>
      </div>

      <div class="row">
        <div class="span12">
          <div class="widget modern-widget">
            <div class="widget-header modern-header">
              <h3><i class="fas fa-credit-card"></i> EDIT PAYMENT</h3>
            </div>
            <form action="<?php echo site_url('admin/account/edit_payment')."/".$sales['id']?>" method="post" class="modern-form">
              <div class="widget-content modern-content">

 <div class="table-responsive">
 <table class="table table-striped table-bordered table-hover" id="dataTables-example">



								<tr><th>SL No.</th>	<td><input class="form-control" readonly="readonly" name="sl_no" value="<?php echo $sales['invid']; ?>" type="text"></td> </tr>
								<tr><th>Name OF PURCHASE</th>
					<td>
					<div id="cid">
					<select id="party_id"    name="party_id">
				<option value="">-Select Party-</option>
				<?php foreach($customer as $pr){ ?>
				<option  <?php if($sales['party_id']==$pr['id']){ ?> selected="selected" <?php } ?>    value="<?php echo $pr['id']; ?>"><?php echo $pr['name']; ?></option>
				<?php } ?>
					</select>
		</div>



					</td>  </tr>



								<tr><th>DATE</th><td><input id="date" name="entry_date" value="<?php echo $sales['entry_date']; ?>" type="text"></td>  </tr>
								<tr> <th>Amount</th><td> <input value="<?php echo $sales['debit']; ?>" name="debit" type="text"></td>   </tr>
								<tr><th>DETAILS</th><td><textarea name="details"> <?php echo $sales['details']; ?></textarea></td>  </tr>
								<tr><th></th><td><input type="submit" class="btn btn-success" value="Submit" ></td>  </tr>

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

  </script>
