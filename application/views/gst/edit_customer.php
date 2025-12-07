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



 
    <div class="row">
 <div class="span12">
<div class="widget ">
<div class="widget-header">
<h2>Edit customer</h2>

</div> 
 
 <form action="<?php echo site_url('admin/sales/edit_customer')."/".$customer['id']?>" method="post">
<div class="table-responsive">
 <table class="table table-striped table-bordered table-hover" id="dataTables-example">
								<tr><th>customer Name</th> <td><input value="<?php echo $customer['name']; ?>" name="name" type="text"></td>  </tr>
								
						        <tr> <th>Contact No</th><td> <input name="contact_no" value="<?php echo $customer['contact_no']; ?>" type="text"></td>   </tr>
								
								<tr><th>Address</th><td><textarea name="address"><?php echo $customer['address']; ?></textarea></td>  </tr>
								
								<tr><th>Remark</th><td><textarea name="remarks"><?php echo $customer['remarks']; ?></textarea></td>  </tr>
							     <tr><th colspan="2" align="right"> <input type="submit" value="Add" class="btn btn-primary pull-right"></th></tr>                       
                                   
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
	});
	
	 $( "#doj" ).datepicker({
		changeMonth: true,
            changeYear: true,
	});
  });
  
  </script>					 
				 
		