   <!-- /subnavbar -->

<div class="main">

  <div class="main-inner">

    <div class="container">

      <div class="row">

	  
<?php if($this->session->flashdata('msg')){?>
<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> <?php echo $this->session->flashdata('msg'); ?> 
</div>
<?php }?>
   <div class="span12">

<h2>Batch</h2>

 <p class="pull-right">  

   						<a href="<?= site_url('admin/batch/create_origin_batch') ?>"><input type="button" value="Create Batch" class="btn btn-primary"> </a></p>



                               <div class="table-responsive">
 <table class="table table-striped table-bordered table-hover" id="dataTables-example">



                                    <thead>



                                        <tr>



                                            <th>Batch</th>

											  <th>start time</th>
											  <th>End time</th>
											  <th>Batch Code</th>

												<th>Action</th>



                                        </tr>



                                    </thead>



                                    <tbody>



          <?php foreach ($batch as $ctgy):?>



			<tr class="odd gradeX">
			<td><?php echo $ctgy->name; ?></td>
			<td><?php echo $ctgy->start_time; ?></td>
			<td><?php echo $ctgy->end_time; ?></td>
			<td><?php echo $ctgy->code; ?></td>
			<td>
			
				<a  href="<?= site_url('admin/batch/edit_origin_batch')."/".$ctgy->id; ?>">Edit</a>
			 | <a onclick="return confirm('Are you sure  to Delete The Batch!')" href="<?= site_url('admin/batch/delete_origin_batch')."/".$ctgy->id; ?>">Delete</a>
				
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
