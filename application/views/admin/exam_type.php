   
   <!-- /subnavbar -->
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
	  
   <div class="span12">
<h2>INTERVIEW</h2>
 <p class="pull-right">  
   						<a href="<?= site_url('admin/admin/create_type') ?>"><input type="button" value="Create Interview" class="btn btn-primary"> </a></p>

                               <div class="table-responsive">
 <table class="table table-striped table-bordered table-hover" id="dataTables-example">

                                    <thead>

                                        <tr>

                                            <th>Interview Name</th>
											  <th>Description</th>
												<th>Action</th>

                                        </tr>

                                    </thead>

                                    <tbody>

          <?php foreach ($exam_type as $ctgy):?>

		<tr class="odd gradeX">

			<td><?php echo $ctgy->name;?></td>

			<td><?php echo $ctgy->description;?></td>

			<td>
			
			
			<a onclick="return confirm('Are you sure  to Edit The Exam Type!')" href="<?= site_url('admin/admin/edit_type')."/".$ctgy->id; ?>">Edit</a>
			 | <a onclick="return confirm('Are you sure  to Delete Exam Type!')" href="<?= site_url('admin/admin/delete_type')."/".$ctgy->id; ?>">Delete</a>

			</td>

		</tr>

		<?php endforeach;?>

                                    

                                    </tbody>

                                </table>
</div>

                            </div>     

                        </div>

                    </div>

                </div>

            </div>