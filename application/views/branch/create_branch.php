

<div class="main">

  <div class="main-inner">

    <div class="container">

      <div class="row">

   <div class="span12">
   <h2>QUESTION LISTING</h2>

<div class="widget ">


<form action="<?php echo site_url('admin/branch/index') ?>" id="quest-search" method="post">
<div class="widget-content">
<?php echo validation_errors(); ?>
				<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Name</label>
                    <div class="col-lg-8">
				<input type="text" value="<?php echo $name; ?>" name="branch[name]">
				 	</div>
				 	</div>
					<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Address</label>
                    <div class="col-lg-8">
				<textarea  name="branch[address]"><?php echo $address;?></textarea>
				 	</div>
				 	</div>
					<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Description</label>
                    <div class="col-lg-8">
				<input type="text" value="<?php echo  $description; ?>" name="branch[description]">
				 	</div>
				 	</div>
					
				<input type="submit"  value="Create Branch" class="btn btn-primary">
                	</div>
                	
</form>
</div>





                            </div>     

                        </div>

                    </div>

                </div>

            </div>
