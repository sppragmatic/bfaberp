




<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
	  	<div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>Add Interview</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
<div id="infoMessage" style="color:#F00"><?php echo $message;?></div>

<?php echo form_open("admin/admin/create_type");?>
 				<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Interview Name</label>
                    <div class="col-lg-8">
                              
							  <input type="text" value="<?php echo $name; ?>"   name="name" class="login password-field"/>
<!--							    <?php echo form_input($category_name);?><br/>
-->                      </div>
                	</div>
                   <div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Description</label>
                    <div class="col-lg-8">
                      <input type="text" value="<?php echo $description; ?>"  name="description" class="login password-field"/>
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