<script src="<?php echo base_url()?>assets/validate/dist/jquery.validate.js"></script>				<script>
	
	$().ready(function() {
		// validate the comment form when it is submitted
//alert("hello");
		// validate signup form on keyup and submit
		$("#user_sch").validate({
			rules: {
				'branch_id': "required"		
			},
			messages: {
				'branch_id': "Please choose your course"
			
			}
		});

		// propose username by combining first- and lastname
	
	});
			</script>
<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js" type="text/javascript" ></script><link href="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.css" /><script>$(document).ready(function() {        $('#form_table').DataTable({                responsive: true        });    });</script>	<script>	function get_next(page){		//alert(page)	$.post('<?= site_url('admin/admission/more_form'); ?>',{ page : page },function(msg){	//alert(msg)	$('#main-table').html(msg);		})	}		</script><style>#form_table_length{    display: none !important;}#form_table_info{    display: none !important;}#form_table_paginate{    display: none !important;}</style><div class="main">  <div class="main-inner">    <div class="container">		  <div class="row">	      <div class="row">   <div class="span12">         <?php if($this->session->flashdata('msg')){?><div class="alert alert-success">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  <strong>Success!</strong> <?php echo $this->session->flashdata('msg'); ?></div><?php }?><div class="widget "><div class="widget-content">   <h2>LIST OF  221 Admission</h2>   <p class="pull-right ">     						<a href="<?= site_url('admin/admission/fill_form') ?>"><input type="button" value="New Reg" class="btn btn-primary"> </a></p>						<div id="main-table">



<table class="table table-striped table-bordered table-hover" >									<thead>										<tr>										<th>#</th>										<th>Name</th>										<th>Email</th>										<th>Username</th>										<th>Password</th>										<th>Mobile</th><th>Doj</th>										<th>Profile Pic</th>										<th>Action</th>										</tr>									</thead>									<tbody><?php $sm=1; foreach ($form as $fm){?><tr><td><?php echo $sm++;?></td><td><?php echo $fm->name;?></td><td><?php echo $fm->mail_id;?></td><td><?php echo $fm->username;?></td><td><?php echo $fm->password;?></td><td><?php echo $fm->mobile;?></td><td><?php echo date('d-m-Y',strtotime($fm->doj));?></td><td><img src="<?php echo base_url();?>upload/profile_pic/<?php echo $fm->profile_pic?>" style="width:75px;height: :75px;"></td><td><a href="<?php echo site_url('admin/other_form/edit_form/'.$fm->id); ?>">Move Admission</a> </td></tr><?php }?>									</tbody></table>				 </div>                            </div>                             </div>
</div>                    </div>                </div>            </div>