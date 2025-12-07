<div class="main">

  <div class="main-inner">

    <div class="container">

      <div class="row">

   <div class="span12">
 
<?php if(validation_errors()){ ?>
<div class="alert alert-danger">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Validation Error!</strong><br><?php echo validation_errors(); ?>
</div>
<?php } ?>

<div class="widget ">	

   <div class="widget-header">
<h3>EDIT LABOUR GROUP</h3>
</div>
<div class="widget-content">
<?php 
// Handle both array and object formats
$lg_id = is_object($labour_group) ? $labour_group->id : (is_array($labour_group) ? $labour_group['id'] : '');
$lg_name = is_object($labour_group) ? $labour_group->name : (is_array($labour_group) ? $labour_group['name'] : '');
$lg_description = is_object($labour_group) ? $labour_group->description : (is_array($labour_group) ? $labour_group['description'] : '');
?>
<form action="<?php echo site_url('admin/labour_group/update/'.$lg_id) ?>" id="labour-group-form" method="post">

				<div class="form-group">
                    <label for="name" class="control-label col-lg-4">Labour Group Name</label>
                    <div class="col-lg-8">
				<input type="text" value="<?php echo set_value('name', $lg_name); ?>" name="name" id="name" class="form-control" required>
				 	</div>
				 </div>
				 
					<div class="form-group">
                    <label for="description" class="control-label col-lg-4">Description</label>
                    <div class="col-lg-8">
				<textarea name="description" id="description" class="form-control" rows="4"><?php echo set_value('description', $lg_description); ?></textarea>
				 	</div>
				 </div>
					
				<div class="form-group">
					<div class="col-lg-12">
				<input type="submit" value="Update Labour Group" class="btn btn-primary">
				<a href="<?php echo site_url('admin/labour_group'); ?>" class="btn btn-default">Cancel</a>
                	</div>
				</div>
			
					
				</form>
</div>
</div>

</div>

      </div> <!-- /row -->

    </div> <!-- /container -->

  </div> <!-- /main-inner -->

</div> <!-- /main -->
