      <link href="<?= base_url();?>/assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />

   <div id="content">



            <div class="inner">

            <div class="row">

                    <div class="col-lg-12">





                        <h2> Data Tables </h2>







                    </div>

                </div>

            

            

<div class="row">

                <div class="col-lg-12">

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            All Users List

                        </div>

                        <div class="panel-body">

                            <div class="table-responsive">

                               <div class="table-responsive">
 <table class="table table-striped table-bordered table-hover" id="dataTables-example">

                                    <thead>

                                        <tr>

                                            <th>First Name</th>

                                            <th>Last Name</th>

                                            <th>Email</th>

                                            <th>group</th>

                                            <th>Status</th>

                                            <th>Action</th>

                                        </tr>

                                    </thead>

                                    <tbody>

          <?php foreach ($users as $user):?>

		<tr class="odd gradeX">

			<td><?php echo $user->first_name;?></td>

			<td><?php echo $user->last_name;?></td>

			<td><?php echo $user->email;?></td>

			<td>

				<?php foreach ($user->groups as $group):?>

					<?php echo anchor("auth/edit_group/".$group->id, $group->name) ;?><br />

                <?php endforeach?>

			</td>

			<td><?php echo ($user->active) ? anchor("admin/auth/deactivate/".$user->id, lang('index_active_link')) : anchor("admin/auth/activate/". $user->id, lang('index_inactive_link'));?></td>

			<td><?php echo anchor("admin/auth/edit_user/".$user->id, 'Edit') ;?></td>

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



<p><?php echo anchor('admin/auth/create_user', lang('index_create_user_link'))?> | <?php echo anchor('admin/auth/create_group', lang('index_create_group_link'))?></p>





</div>

</div>

  <!-- END GLOBAL SCRIPTS -->

        <!-- PAGE LEVEL SCRIPTS -->

    <script src="<?= base_url();?>/assets/plugins/dataTables/jquery.dataTables.js"></script>

    <script src="<?= base_url();?>/assets/plugins/dataTables/dataTables.bootstrap.js"></script>

     <script>

         $(document).ready(function () {

             $('#dataTables-example').dataTable();

         });

    </script>