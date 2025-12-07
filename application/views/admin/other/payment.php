<div class="main">

  <div class="main-inner">

    <div class="container">

      <div class="row">

   <div class="span12">
  
<div class="widget ">
<div class="widget-header">
 <h2>Student Payment</h2>
</div>

<div class="widget-content">
 <form id="admission" action="<?php echo site_url('admin/other_form/insert_payment'); ?>" method="post">
  
  
  
  <div class="table-responsive">
 <table class="table table-striped table-bordered table-hover" id="dataTables-example" style="width:500px" align="center">

                                    <thead>

                                        <tr>
                      
								<th>Student Name</th><td><?php echo $user_details->name; ?></td>								    
								</tr>
								<tr><th>Email</th><td><?php echo $user_details->mail_id; ?></td>	</tr>
							<tr>	<th>Contact No</th><td><?php echo $user_details->mobile; ?></td>	</tr>							    
							<tr>	<th>User Id</th><td><?php echo $user_details->username ?>	</td></tr>		
							<tr>	<th>Total Amount</th><td><?php echo $user_details->price?>	</td></tr>					    
							<tr>	<th>Wish To pay</th><td><input type="text" id="amt_paid" value="<?php echo $paid_price; ?>"  name="amt_paid" required="required" ></td></tr>		
							<tr>	<th>Payment Mode</th><td><input type="radio"  name="pay_mode" value="1" required="required" > By Cash  &nbsp; | &nbsp; <input type="radio" value="2"  name="pay_mode" required="required" > By Cheque</td></tr>									
							<tr>	<th>Join Date</th><td><input type="hidden" name="paid_date" id="paid_date" value="<?php echo date("d-m-Y", strtotime($user_details->doj)); ?>" required="required" ><?php echo date("d-m-Y", strtotime($user_details->doj)); ?>
							
								<input type="hidden" value="<?php echo $user_details->username; ?>"  name="user_id">
								<input type="hidden" value="1"  name="status">
								
							</td></tr>	
<tr>	<th>Paid Date</th><td><input type="text" name="ad_date" id="ad_date" value="<?php echo date("d-m-Y", strtotime($user_details->doj)); ?>" required="required" ></td></tr>

							
								  

	<tr>	<th>Remarks</th><td><textarea id="remarks" name="remarks" required="required" ></textarea></td></tr>					    
						


                                    </thead>

                                    <tbody>

	<!--	   
		   <tr class="odd gradeX">
			<td><input type="text"  name="amt_paid"><input type="hidden" value="<?php echo $user_details->username; ?>"  name="user_id"></td>
			<td><input type="text" id="paid_date" required="required" class="dob" name="paid_date"></td>
			<td><input type="text" id="next_date" required="required" class="dob" name="next_date"></td>
		</tr>
	-->	
		 <tr class="odd gradeX">
			
			<td colspan="3"> <input type="submit" id="tags" onclick="search_report();" value="Save" class="btn btn-primary pull-right" /></td>
		</tr>    
		                            </tbody>
                                </table>
</div>								
								
								
		</form>	





 
 
					
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
    $( ".dob" ).datepicker({
		changeMonth: true,
            changeYear: true,
	});

	
	    $( "#ad_date" ).datepicker({
		changeMonth: true,
            changeYear: true,
	});







$("#admission").validate({
			rules: {
				amt_paid : "required",
				paid_date: "required",
				next_date: "required",
				pay_mode : "required"
				},
			messages: {
				amt_paid : "Please enter The Paid Amount!",
				paid_date: "Please Enter the Paid Date!",
				next_date: "Please Enter The Next Date!",
				pay_mode : "Please Select A Payment Mode"
			}
		});




  });
</script>