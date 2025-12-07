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
<script>
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
	

<link rel="stylesheet" href="<?php echo base_url('assets/css/sales-centralized.css'); ?>" />
<?php if (validation_errors()): ?>
<div class="alert alert-success">
	<?php echo validation_errors(); ?>
</div>
<?php endif; ?>



<div class="main">
	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span8 offset2">
					<div class="search_panel">
						<h3 class="search_header">Edit Customer</h3>
						<div class="search_conent">
							<form action="<?php echo site_url('admin/sales/edit_customer')."/".$customer['id']?>" method="post" autocomplete="off">
								<div class="row">
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label for="name" class="control-label">Customer Name</label>
											<input value="<?php echo $customer['name']; ?>" name="name" id="name" type="text" class="form-control" required>
										</div>
									</div>
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label for="contact_no" class="control-label">Contact No</label>
											<input name="contact_no" id="contact_no" value="<?php echo $customer['contact_no']; ?>" type="text" class="form-control" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label for="address" class="control-label">Address</label>
											<textarea name="address" id="address" class="form-control" rows="3" required><?php echo $customer['address']; ?></textarea>
										</div>
									</div>
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label for="remarks" class="control-label">Remark</label>
											<textarea name="remarks" id="remarks" class="form-control" rows="3"><?php echo $customer['remarks']; ?></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-12 text-end">
										<input type="submit" value="Update" class="btn btn-primary" />
									</div>
								</div>
							</form>
						</div>
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
    $( "#date" ).datepicker({
		changeMonth: true,
            changeYear: true,
	});
	
	 $( "#doj" ).datepicker({
		changeMonth: true,
            changeYear: true,
	});
  });
  
  </script>					 
				 
		