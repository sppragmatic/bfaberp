<div class="main">

  <div class="main-inner">

    <div class="container">

      <div class="row">

   <div class="span12">

<div class="widget ">	

   <div class="widget-header">
<h3>VIEW LABOUR GROUP</h3>
</div>
<div class="widget-content">

<?php 
// Handle both array and object formats
$lg_id = is_object($labour_group) ? $labour_group->id : (is_array($labour_group) ? $labour_group['id'] : '');
$lg_name = is_object($labour_group) ? $labour_group->name : (is_array($labour_group) ? $labour_group['name'] : '');
$lg_description = is_object($labour_group) ? $labour_group->description : (is_array($labour_group) ? $labour_group['description'] : '');
$lg_entry_date = is_object($labour_group) ? $labour_group->entry_date : (is_array($labour_group) ? $labour_group['entry_date'] : '');
?>
<table class="table table-bordered">
<tr>
<th width="200">Field</th>
<th>Details</th>
</tr>
<tr>
<td><strong>Labour Group Name</strong></td>
<td><?php echo $lg_name; ?></td>
</tr>
<tr>
<td><strong>Description</strong></td>
<td><?php echo $lg_description ? $lg_description : 'N/A'; ?></td>
</tr>
<tr>
<td><strong>Entry Date</strong></td>
<td><?php echo date('d-m-Y H:i:s', strtotime($lg_entry_date)); ?></td>
</tr>
</table>

<div class="form-group">
	<div class="col-lg-12">
<a href="<?php echo site_url('admin/labour_group/edit/'.$lg_id); ?>" class="btn btn-warning">Edit Labour Group</a>
<a href="<?php echo site_url('admin/labour_group'); ?>" class="btn btn-default">Back to List</a>
<a href="<?php echo site_url('admin/labour_group/delete/'.$lg_id); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this labour group?')">Delete Labour Group</a>
    </div>
</div>

</div>
</div>

</div>

      </div> <!-- /row -->

    </div> <!-- /container -->

  </div> <!-- /main-inner -->

</div> <!-- /main -->
