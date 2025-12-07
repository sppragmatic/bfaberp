<script>
function activeme(dis){
if(dis.checked){
	var sid =  dis.value;
	var status = 1;
	//alert(sid);
	$.post("<?php echo site_url('admin/academic/up_st')?>",{ id :  sid, st : status},function(msg){
		alert(msg)
		window.location.href = "<?php echo site_url('admin/academic'); ?>";
	})
}else{
	
	var sid =  dis.value;
	var status = 0;
	$.post("<?php echo site_url('admin/academic/up_st')?>",{ id :  sid, st : status },function(msg){	
	alert(msg)
	})	
}	
	
}

</script><link rel="stylesheet" href="<?php echo base_url();?>assets/css/standardized_view.css">
<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.css" />

<script type="text/javascript">
$(document).ready(function() {
    $('.table').DataTable({
        "responsive": true,
        "processing": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 25,
        "order": [[1, "asc"]]
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
<div class="widget-content">
   <h2>Academic  Year</h2>

</div>
</div>
<table class="table table-striped table-bordered table-hover">

									<thead>
										<tr>
										<th>#</th>
										<th>Name</th>
										<th>Status</th>
										</tr>
									</thead>

									<tbody>
<?php $sm=1; foreach ($year as $fm){?>
<tr>
<td><?php echo $sm++;?></td>
<td><?php echo $fm->name;?></td>
<td><input type="checkbox" value="<?php echo $fm->id;?>"  onchange="activeme(this)"  <?php if($fm->status==1){ ?> checked="checked" <?php } ?>  ></td>
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





