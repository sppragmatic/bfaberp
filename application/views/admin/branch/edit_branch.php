

<div class="main">

  <div class="main-inner">

    <div class="container">

      <div class="row">

   <div class="span12">
  
<div class="widget ">
<div class="widget-header">
<h3>CREATE BRANCH</h3>
</div>
<div class="widget-content">

<form action="<?php echo site_url('admin/branch/edit_branch')."/".$branch->id ?>" id="quest-search" method="post">

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
				<input type="text" value="<?php echo $branch->name; ?>" name="branch[name]">
				 	</div>
				 	</div>
					<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Address</label>
                    <div class="col-lg-8">
				<textarea  name="branch[address]"><?php echo $branch->address;?></textarea>
				 	</div>
				 	</div>
					<div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Branch Code</label>
                    <div class="col-lg-8">
				<input type="text" value="<?php echo  $branch->code; ?>" name="branch[code]">
				 	</div>
					
				<input type="submit"  value="Submit" class="btn btn-primary">
				<a href="<?php echo site_url()?>/admin/branch/" class="btn btn-primary">Go to Branch</a>
				<a href="<?php echo site_url()?>/admin/branch/create_branch" class="btn btn-primary">New Branch</a>
                	</div>
			
					
					



</form>
</div>
</div>




                            </div>     

                        </div>

                    </div>

                </div>

            </div>
