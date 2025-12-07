

<div class="main">

  <div class="main-inner">

    <div class="container">

      <div class="row">

   <div class="span12">
 

<div class="widget ">	

   <div class="widget-header">
<h3>CREATE PRODUCT</h3>
</div>
<div class="widget-content">
<form action="<?php echo site_url('admin/product/create_product') ?>" id="quest-search" method="post">
<?php echo validation_errors(); ?>
				<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Name</label>
                    <div class="col-lg-8">
				<input type="text" value="<?php echo $name; ?>" name="product[name]">
				 	</div>
				 	</div>
					<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Description</label>
                    <div class="col-lg-8">
				<textarea  name="product[address]"><?php echo $address;?></textarea>
				 	</div>
				 	</div>
					<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">product Code</label>
                    <div class="col-lg-8">
				<input type="text" value="<?php echo  $code; ?>" name="product[code]">
				 	</div>
					
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
