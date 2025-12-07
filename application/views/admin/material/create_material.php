

<div class="main">

  <div class="main-inner">

    <div class="container">

      <div class="row">

   <div class="span12">
<div class="widget ">
 <div class="widget-header">
<h3>CREATE MATERIAL</h3>
</div>
	
<div class="widget-content">
<form action="<?php echo site_url('admin/material/create_material') ?>" id="quest-search" method="post">

<?php echo validation_errors(); ?>
				<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Name</label>
                    <div class="col-lg-8">
				<input type="text" value="<?php echo $name; ?>" name="material[name]">
				 	</div>
				 	</div>
					<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Description</label>
                    <div class="col-lg-8">
				<textarea  name="material[address]"><?php echo $address;?></textarea>
				 	</div>
				 	</div>
					
					<div class="form-group">
				<input type="submit"  value="Submit" class="btn btn-primary">
                	</div>
</form>
</div>

</div>





                            </div>     

                        </div>

                    </div>

                </div>

            </div>
