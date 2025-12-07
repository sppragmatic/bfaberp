

<div class="main">

  <div class="main-inner">

    <div class="container">

      <div class="row">

   <div class="span12">
 <div class="widget ">
   <div class="widget-header">
<h3>EDIT MATERIAL</h3>
</div>


<div class="widget-content">

<form action="<?php echo site_url('admin/material/edit_material')."/".$material->id ?>" id="quest-search" method="post">
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
				<input type="text" value="<?php echo $material->name; ?>" name="material[name]">
				 	</div>
				 	</div>
					<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Description</label>
                    <div class="col-lg-8">
				<textarea  name="material[address]"><?php echo $material->address;?></textarea>
				 	</div>
				 	</div>
					<div class="form-group">
			
				<input type="submit"  value="Submit" class="btn btn-primary">
				<a href="<?php echo site_url()?>/admin/material/" class="btn btn-primary">Go to material</a>
				<a href="<?php echo site_url()?>/admin/material/create_material" class="btn btn-primary">New material</a>
                	</div>
			
					
					



</form>
</div>
</div>




                            </div>     

                        </div>

                    </div>

                </div>

            </div>
