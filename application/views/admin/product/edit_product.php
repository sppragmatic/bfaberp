

<div class="main">

  <div class="main-inner">

    <div class="container">

      <div class="row">

   <div class="span12">
<div class="widget ">
   <div class="widget-header">
<h3>EDIT PRODUCT</h3>
</div>

<div class="widget-content">

<form action="<?php echo site_url('admin/product/edit_product')."/".$product->id ?>" id="quest-search" method="post">


<?php if($this->session->flashdata('msg')){?>
<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> <?php echo $this->session->flashdata('msg'); ?> 
</div>
<?php }?>

<?php echo validation_errors(); ?>
				<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Name</label>
                    <div class="col-lg-8">
				<input type="text" value="<?php echo $product->name; ?>" name="product[name]">
				 	</div>
				 	</div>
					<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Description</label>
                    <div class="col-lg-8">
				<textarea  name="product[address]"><?php echo $product->address;?></textarea>
				 	</div>
				 	</div>
					<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">product Code</label>
                    <div class="col-lg-8">
				<input type="text" value="<?php echo  $product->code; ?>" name="product[code]">
				 	</div>
					
				<input type="submit"  value="Submit" class="btn btn-primary">
				<a href="<?php echo site_url()?>/admin/product/" class="btn btn-primary">Go to product</a>
				<a href="<?php echo site_url()?>/admin/product/create_product" class="btn btn-primary">New product</a>
                	</div>
			
			
</form>
</div>
</div>





                            </div>     

                        </div>

                    </div>

                </div>

            </div>
