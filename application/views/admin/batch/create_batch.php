
<div class="main">

  <div class="main-inner">

    <div class="container">

      <div class="row">

	  	<div class="widget ">

	      			

	      			<div class="widget-header">

	      				<i class="icon-user"></i>

	      				<h3>Add Batch</h3>

	  				</div> <!-- /widget-header -->

					

					<div class="widget-content">

<div id="infoMessage" style="color:#F00"><?php echo validation_errors(); ?></div>



<?php echo form_open("admin/batch/create_batch");?>

			<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Batch</label>
                <div class="col-lg-8">
			 		<input type="text" value="<?php echo $name; ?>"   name="batch[name]" class="login password-field"/>
            	</div>
             </div>
			<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Start Time</label>
                <div class="col-lg-8">
			 		<input type="text" value="<?php echo $start_time; ?>"   name="batch[start_time]" class="login password-field"/>
					<p style="color:#ff0000;">In 24 Hour Format: ,eg 21.20</p>
            	</div>
             </div>
			<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">End Time</label>
                <div class="col-lg-8">
			 		<input type="text" value="<?php echo $end_time; ?>"   name="batch[end_time]" class="login password-field"/>
					<p style="color:#ff0000;">In 24 Hour Format: ,eg 17.20</p>
            	</div>
             </div>
			 
			 
			 
			 <div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Batch Code</label>
                <div class="col-lg-8">
			 		<input type="text" value="<?php echo $code; ?>"   name="batch[code]" class="login password-field"/>
            	</div>
             </div>

	     <div class="form-group">
                    <div class="col-lg-8">
                        <input type="submit" id="tags" value="Submit" class="btn btn-primary" />
                    </div>
                </div>
				
	<?php echo form_close();?>

</div>

</div>

 

 </div>

 <div class="row">

 <br /><br /><br /><br /><br /><br /><br /><br /><br />

 </div>

      <!-- /row --> 

    </div>

    <!-- /container --> 

  </div>

  <!-- /main-inner --> 

</div>

<!-- /main -->
