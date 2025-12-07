

<div class="main">

  <div class="main-inner">

    <div class="container">

      <div class="row">

   <div class="span12">
   <h2>Student Enquiry Form</h2>

<div class="widget ">	
<form action="<?php echo site_url('admin/enquiry/create_enquiry') ?>" id="quest-search" method="post">
<div class="widget-content">
<p style="color: #b90000"><?php echo validation_errors(); ?></p>

					
					
					
					<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Name</label>
                    <div class="col-lg-8">
				<input type="text" value="<?php echo $name; ?>" name="enquiry[name]">
				 	</div>
				 	</div>
					
					<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Phone</label>
                    <div class="col-lg-8">
				<input type="text" required="required" value="<?php echo $name; ?>" name="enquiry[mobile_no]">
				 	</div>
				 	</div>
					
					
					<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Email Id</label>
                    <div class="col-lg-8">
				<input type="text" required="required" value="<?php echo $email_id; ?>" name="enquiry[email_id]">
				 	</div>
				 	</div>
					
					
					<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Course Name</label>
                    <div class="col-lg-8">
				
					<select required="required" name="enquiry[course_id]">
					<option value="" >-Select A Course-</option>
		<?php foreach($course as $cse){	?>
				<option <?php if($cse->id==$course_id){?> selected="selected" <?php }?> value="<?php echo $cse->id; ?>" ><?php echo $cse->name; ?></option>
				<?php }?>
				 	</select>
					</div>
				 	</div>

				
				<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Message</label>
                    <div class="col-lg-8">
			<textarea  required="required" name="enquiry[message]"> </textarea>
				 	</div>
				 	</div>
					
					
				
					<div class="form-group">	
					<br>
					</div>	
					<div class="form-group">	
				<input type="submit"  value="Submit" class="btn btn-primary">
                	</div>
			
					
					


</div>
</form>
</div>





                            </div>     

                        </div>

                    </div>

                </div>

            </div>
