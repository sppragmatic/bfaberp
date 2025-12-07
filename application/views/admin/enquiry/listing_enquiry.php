<script src="<?php echo base_url()?>assets/validate/dist/jquery.validate.js"></script>				<script>
	
	$().ready(function() {
		// validate the comment form when it is submitted
//alert("hello");
		// validate signup form on keyup and submit
		$("#user_sch").validate({
			rules: {
				'start_date': "required",
				'end_date'	: "required"	
			},
			messages: {
				'start_date': "Please Enter The Start Date",
				'end_date': "Please Enter The End Date",
			
			}
		});

		// propose username by combining first- and lastname
	
	});
			</script>
			
	<script>

	function save_me(con,id){
		$.post("<?php echo site_url('admin/enquiry/up_en')?>",{ id : id, con : con },function(msg){
			alert(msg)
		})
		
		
	}
	
	
	
	</script>	
			
			<link rel="stylesheet" href="<?php echo base_url();?>assets/css/standardized_view.css">
<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.css" />

<script type="text/javascript">
$(document).ready(function() {
    $('.table').DataTable({
        "responsive": true,
        "processing": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 25,
        "order": [[1, "desc"]]
    });
});
</script>

<div class="main listing-page">

  <div class="main-inner">

    <div class="container">

      <div class="row">

   <div class="span12">
<?php if($this->session->flashdata('msg')){?>

<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> <?php echo $this->session->flashdata('msg'); ?>
</div>

<?php }?>
<?php if($this->session->flashdata('msg_w')){?>

<div class="alert alert-danger">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Warning!</strong> <?php echo $this->session->flashdata('msg_w'); ?>
</div>
<?php }?>
<div class="widget ">
<div class="widget-content"><form id="user_sch" action="<?php echo site_url("admin/enquiry/search");?>" enctype="multipart/form-data" method="post" >	
<div class="span3">   <div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Start Date</label>     
					<div class="col-lg-8">					<input type="text" id="start_date" name="start_date" class="form-control">					 </div>   
					</div></div><div class="span3">   <div class="form-group">                    <label for="text1" class="control-label col-lg-4">End Date</label> 
					<div class="col-lg-8">					<input type="text" id="end_date" name="end_date" class="form-control">			
					</div>                	</div></div>
					
					
	
<div class="span3">
   <div class="form-group">
                    <label for="text1" class="control-label col-lg-4">Course</label>
                    <div class="col-lg-8">
					<select id="branch_id"    name="course_id">
				<option value="">-Select Class -</option>
					<?php
					foreach($course as $cls){
						?>
				<option  value="<?php echo $cls->id; ?>"><?php echo $cls->name; ?></option>
				<?php
					}
					?>
					</select>
					 </div>
                	</div>

</div>

	
					
					
					
					<div class="span2"><br/>  <input type="submit" id="tags"  value="Search" class="btn btn-primary" /></div></form>
   <h2>View Enquiry List</h2>

</div>
</div>
<p class="pull-right ">  

   						<a href="<?= site_url('admin/enquiry/create_enquiry') ?>"><input type="button" value="Create Enquiry" class="btn btn-primary"> </a></p>
<table class="table table-striped table-bordered table-hover">

									<thead>
										<tr>
										<th>#</th>
										<th>Entry Date</th>
										<th>Name</th>
										<th>Email</th>
										<th>Mobile No</th>
										<th>Course</th>
										<th>Message</th>
										</tr>
									</thead>

									<tbody>
<?php $sm=1; foreach ($enquiry as $fm){?>
<tr>
<td><?php echo $sm++;?></td>
<td><?php echo $fm->entry_date;?></td>
<td><?php echo $fm->name;?></td>
<td><?php echo $fm->email_id;?></td>
<td><?php echo $fm->mobile_no;?></td>
<td><?php echo $fm->course_name;?></td>
<td contenteditable="true"  ><textarea onchange="save_me(this.value,<?php echo $fm->id; ?>)"><?php echo $fm->message;?></textarea></td>
</tr>
<?php }?>

									</tbody>


</table>


 

<div  id="main-table">


				<div class="pull-right"> 


</div>

</div>

                            </div>     

                        </div>

                    </div>

                </div>

            </div>




<script src="<?php echo base_url()?>assets/validate/dist/jquery.validate.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/ui/jquery-ui.css" />
<script src="<?php echo base_url()?>assets/ui/jquery-ui.js"></script>
<script src="<?php echo base_url()?>assets/validate/formvalidate.js"></script>
<script>
  $(function() {
    $( "#start_date" ).datepicker({
		changeMonth: true,
            changeYear: true,
	});
	 $( "#end_date" ).datepicker({
		changeMonth: true,
            changeYear: true,
	});
  });

</script>