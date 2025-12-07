<div class="main">

  <div class="main-inner">

    <div class="container">

      <div class="row">

   <div class="span12">
   <h2> 221 Student  Registration</h2>

<div class="widget ">


<div class="widget-content">
<font color="red"><?php echo validation_errors(); ?>

</font>
</div>
 </div>     
 
 
<div class="widget-header">
	      				<i class="icon-table"></i>
	      				<h3>221 ADMISSION FORM</h3>
	  				</div>
					

<div class="widget-content">


<form action="<?php echo site_url('admin/other_form/edit_form/'.$form->id); ?>" id="admission" class="form-horizontal" runat="server" method="POST" enctype="multipart/form-data">
<button type="submit" class="btn btn-info pull-right" >Update</button>
<!--student detail start-->
<div class="span12">
<div class="span8">
<div class="control-group">											
	<label class="control-label"  for="username">Name of the Applicant (Block letter)</label>
	<div class="controls">
		<input  type="text" name="add[name]" id="o_name" value="<?php echo $form->name;?>" class="span6" >
	</div> <!-- /controls -->				
</div> 
<div class="control-group">											
	<label class="control-label" for="username">MObile</label>
	<div class="controls">
		<input  type="text" name="add[mobile]" value="<?php echo $form->mobile;?>"  class="span6"  >
	</div> <!-- /controls -->				
</div> 
<div class="control-group">											
	<label class="control-label" for="username">Name Of Father</label>
	<div class="controls">
		<input  type="text" name="add[father]"  value="<?php echo $form->father;?>" class="span6"  >
	</div> <!-- /controls -->				
</div> 

<div class="control-group">											
	<label class="control-label" for="username">Parent's Contact No</label>
	<div class="controls">
		<input type="text" name="add[parent_no]"  value="<?php echo $form->parent_no;?>" class="span6"  >
	</div> <!-- /controls -->				
</div> 

<div class="control-group">											
	<label class="control-label" for="username">Name Of Mother</label>
	<div class="controls">
		<input  type="text" name="add[mother]" value="<?php echo $form->mother;?>" class="span6"  >
	</div> <!-- /controls -->				
</div> 
</div>

<div class="span2">
<div style="height: 185px;width: 185px;">
Profile picture
<input type="file" name="file" id="upld" class="" data-multiple-caption="{count} files selected"   style="display:none;"/>
<label for="upld"><img id="output" src="<?php echo base_url()?>upload/profile_pic/<?php echo $form->profile_pic; ?>" style="height: 138px;width: 148px;cursor:pointer;"/><span></span></label>

</div>

</div>
</div>
<!--student detail end-->

<!--student address start-->
<div class="span12">
<div class="span5">

<div class="form-group">											
	<label class="control-label" for="username">Address of Applicant</label>
	<div class="controls">
<textarea cols="8" rows="5" name="add[main_address]" class="span4"><?php echo $form->main_address ;?></textarea>
	<!-- /controls -->				
</div>
</div>

</div>
<div class="span5">
<div class="control-group">											
	<label class="control-label" for="username">Present Add.</label>
		<div class="controls">

<textarea name="add[present_address]" cols="8" rows="5" class="span4"><?php echo $form->present_address ;?></textarea>
	<!-- /controls -->				
</div>
</div>

</div>
</div>
<!--student address End-->
<!--student data start-->
<div class="span12">
<div class="span5">
<div class="control-group">											
	<label class="control-label" for="username">Date of Joining</label>
	<div class="controls">
		<input  type="text" id="doj" name="add[doj]" value="<?php echo $form->doj ;?>" class="span4"  >
	</div> <!-- /controls -->				
</div>


<div class="control-group">											
	<label class="control-label" for="username">Date of Birth</label>
	<div class="controls">
		<input  type="text" id="dob" name="add[dob]" value="<?php echo $form->dob ;?>" class="span4"  >
	</div> <!-- /controls -->				
</div>
<div class="control-group">											
	<label class="control-label" for="username">Email id</label>
	<div class="controls">
		<input  type="email" name="add[mail_id]" value="<?php echo $form->mail_id ;?>" class="span4"  >
	</div> <!-- /controls -->				
</div>
</div>
<div class="span5">
<div class="control-group">											
	<label class="control-label" for="username">Category</label>
	<div class="controls">
	<select class="span4" name="add[category]" >
		<option value=""> -Choose- </option>
		<option <?php  if($form->category == "general"){?> selected="selected"<?php } ?> value="general"> General</option>
		<option <?php  if($form->category == "obc"){?> selected="selected"<?php } ?> value="obc"> OBC </option>
		<option <?php  if($form->category == "sc"){?> selected="selected"<?php } ?> value="sc"> SC</option>
		<option <?php  if($form->category == "st"){?> selected="selected"<?php } ?> value="st"> ST</option>
	</select>
	</div>			
</div>
<div class="control-group">											
	<label class="control-label" for="username">Gender</label>
	<div class="controls">
	<select class="span4" name="add[gender]">
		<option value=""> -Choose- </option>
		<option <?php  if($form->gender == "male"){?> selected="selected"<?php } ?> value="male"> Male</option>
		<option <?php  if($form->gender == "female"){?> selected="selected"<?php } ?>  value="female"> Female</option>
	</select>
	</div>			
</div>
</div>
<div class="span5">
<div class="control-group">											
	<label class="control-label" for="username">religion</label>
	<div class="controls">
		<input  type="text" name="add[religion]"  value="<?php echo $form->religion;?>" class="span4"  >
	</div> <!-- /controls -->				
	</div> <!-- /controls -->				
</div>

</div>
<!--student data start-->
<!--student Educational qualification start-->
<div class="">
<div align="center"><h2>Educational Qualification</h2></div>
<table class="table table-striped table-bordered table-hover table-responsive">
<thead>
	<tr>
		<th></th>
		<th>Instituation Name</th>
		<th>Year of Pass out</th>
		<th>Board</th>
		<th>Percentage</th>
	
	</tr>
	</thead>
	<tbody>
	<tr>
		<td>Metric</td>
		<td><input  type="text" name="add[mtc_inst_name]" value="<?php echo $form->mtc_inst_name ;?>" style="width: 85%"></td>
		<td><input  type="text" name="add[mtc_pass_out]" value="<?php echo $form->mtc_pass_out ;?>" style="width: 85%"></td>
		<td><input  type="text" name="add[mtc_board]" value="<?php echo $form->mtc_board ;?>" style="width: 85%"></td>
		<td><input  type="text" name="add[mtc_per]" value="<?php echo $form->mtc_per ;?>" style="width: 85%"></td>
	
	</tr>
	<tr>
		<td>+2</td>
		<td><input  type="text" name="add[clg_inst_name]" value="<?php echo $form->clg_inst_name ;?>" style="width: 85%"></td>
		<td><input  type="text" name="add[clg_pass_out]" value="<?php echo $form->clg_pass_out ;?>" style="width: 85%"></td>
		<td><input  type="text" name="add[clg_board]" value="<?php echo $form->clg_board ;?>" style="width: 85%"></td>
		<td><input  type="text" name="add[clg_per]" value="<?php echo $form->clg_per ;?>" style="width: 85%"></td>
		
	</tr>
	<tr>
		<td>Graduation</td>
		<td><input  type="text" name="add[gdn_inst_name]" value="<?php echo $form->gdn_inst_name ;?>" style="width: 85%"></td>
		<td><input  type="text" name="add[gdn_pass_out]" value="<?php echo $form->gdn_pass_out ;?>" style="width: 85%"></td>
		<td><input  type="text" name="add[gdn_board]" value="<?php echo $form->gdn_board ;?>" style="width: 85%"></td>
		<td><input  type="text" name="add[gdn_per]" value="<?php echo $form->gdn_per ;?>" style="width: 85%"></td>
	
	</tr>
	<tr>
		<td>Other</td>
		<td><input  type="text" name="add[otr_inst_name]" value="<?php echo $form->otr_inst_name ;?>" style="width: 85%"></td>
		<td><input  type="text" name="add[otr_pass_out]" value="<?php echo $form->otr_pass_out ;?>" style="width: 85%"></td>
		<td><input  type="text" name="add[otr_board]" value="<?php echo $form->otr_board ;?>" style="width: 85%"></td>
		<td><input  type="text" name="add[otr_per]" value="<?php echo $form->otr_per ;?>" style="width: 85%"></td>
	
	</tr>
	</tbody>
</table>



<div class="span5">
<div class="control-group">											
	<label class="control-label" for="username"> Exam Batch</label>
	<div class="controls">
	<select class="span4" id="exam_batch" name="add[exam_batch_id]" >
		<option value=""> -Choose- </option>
		<?php foreach($e_batch as $eb){?>
	<option <?php  if($eb->id == $form->exam_batch_id){?> selected="selected"<?php } ?> value="<?php echo $eb->id?>"> <?php echo $eb->name?></option>
	<?php }?>
	</select>
	</div>			
</div>
</div>
<div class="span5">
<div class="control-group">											
	<label class="control-label" for="username"> Origin Batch</label>
	<div class="controls">
	<select class="span4" id="origin_batch" name="add[origin_batch_id]" >
		<option value=""> -Choose- </option>
		<?php foreach($o_batch as $ob){?>
	<option <?php  if($ob->id == $form->origin_batch_id){?> selected="selected"<?php } ?> value="<?php echo $ob->id?>"> <?php echo $ob->name?></option>
	<?php }?>
	</select>
	</div>			
</div>
</div>
<div class="">
<div class="control-group">											
	<label class="control-label" for="username"> Branch</label>
	<div class="controls">
	<select class="span4" name="add[branch_id]"  id="branch" required="required">
		
		<?php foreach($branch as $br){?>
	<option   value="<?php echo $br->id?>"> <?php echo $br->name?></option>
	<?php }?>
	</select>
	</div>			
</div>
</div>
</div><br><br>




</div><br><br>


<div class="widget-content">


<div class="row">

<div class="span3">
<div class="control-group">											
	<label class="control-label" for="username">User ID</label>
	<div class="controls">
	<input type="text" class="span3" id="user_id" readonly="readonly"  name="add[username]">
	</div>			
</div>
</div>

<div class="span3">
<div class="control-group">											
	<div class="controls">
	<input type="button" class="span2 btn btn-primary"  onclick="gen_userid()" value="Generate" >
	</div>			
</div>

</div>

</div>

<div class="row">
	
	<div class="span3">
<div class="control-group">											
	<label class="control-label" for="username">Password</label>
	<div class="controls">
	<input type="text" class="span3" readonly="readonly" id="password"  name="add[password]">
	</div>			
</div>
</div>

<div class="span3">
<div class="control-group">											
	<div class="controls">
	<input type="button" class="span2 btn btn-primary" onclick="gen_password();" value="Generate"  >
	</div>			
</div>

</div>
	
	
</div>





</div>
<!--student Educational qualification End-->

<h2 align="center">Courses Opted</h2>

<div class="">

<div class="row">


<div class="span7">


<table class="table table-striped table-bordered table-hover table-responsive">
<thead>
	<tr>
	<th>Course Name</th>
	
		<th>Category</th>
		<th>Price</th>
		
	</tr>
	</thead>
	<tbody>
	
	
	<?php foreach($all_courses AS $ac){ 
	$category = $ac['category'];
	?>
	<tr>
		<td><input <?php if(in_array($ac['id'],$sel_c)){ ?> checked="checked" <?php } ?> onchange="get_ctgy(this,<?php echo $ac['id']; ?>)" name="cc[]" value="<?php echo $ac['id']; ?>" type="checkbox"><?php echo $ac['name']; ?></td>
		<td ><p id="ctg<?php echo $ac['id']; ?>" >
		<?php $k=0; foreach($category AS $ctg){ $k=$k+1; ?>
		<input <?php if(in_array($ctg['id'],$dt_c)){ ?> checked=="checked" <?php } ?> onchange="get_price(this,<?php echo $ctg['id']; ?>,<?php echo $ac['id']; ?>)" id="ctg_dd<?php echo $ctg['id']; ?>" value="<?php echo $ctg['id'];?>" name="ctg_cc[<?php echo $ac['id']; ?>][<?php echo $k; ?>]" type="checkbox"> <?php echo $ctg['name']; ?> 
		<br/> 
		<?php } ?></p></td>
		<td><p id="prc<?php echo $ac['id']; ?>"   >
			
			<?php $j=0; foreach($category AS $ctg){ $j=$j+1; ?><input  type="text" id="ctg_pp<?php echo $ctg['id']; ?>"  name="ctg_pp[<?php echo $ac['id']; ?>][<?php echo $j; ?>]" <?php if(in_array($ctg['id'],$dt_c)){ ?> value="<?php echo $this->admission_model->get_price_edit($form->username,$ac['id'],$ctg['id']); ?>" <?php } ?>  readonly="readonly" /><br/> <br/> <?php } ?>
			
		</p></td>
	</tr>
	<?php } ?>	
	
	
		<tr>
	<th>Total Price</th>
	
		<th></th>
		<th><input type="text" id="total"  name="add[price]" value="0"  readonly="readonly"></th>
		
	</tr>
	
	</tbody>
</table>


</div>

<div class="span3">

<table class="table table-striped table-bordered table-hover table-responsive">

	
	

	<tr>
	
		<th>Course</th>
		<td><?php echo $form->course ;?></td>
		
	</tr>
	
	
	<tr>
	
		<th>Paid Price</th>
		<td><?php echo $form->paid_price ;?>
		<input type="hidden" name="paid_price" value="<?php echo $form->paid_price ;?>">
		</td>
		
	</tr>
	
	
	
	</tbody>
</table>

</div>

</div>

<div class="span12">
<div class="span7">
<div class="control-group">											
	<label class="control-label" for="username"> Interview Batch</label>
	<div class="controls">
	<select class="span4" id="inter_batch" name="add[inter_batch]" >
		<option value="0"> -Choose- </option>
		<?php foreach($inter_batch as $inb){?>
	<option  value="<?php echo $inb->id?>"> <?php echo $inb->name?></option>
	<?php }?>
	</select>
	</div>			
</div>
</div>
</div>


<div class="span12">
<div class="span7">
<div class="control-group">											
	<label class="control-label" for="username">Interview For</label>
	<div class="controls">
	<input  type="text" class="span6" value="<?php echo $form->interview ;?>"  name="add[interview]">
	</div>			
</div>
</div>
</div>
<div class="span12">
<div class="span7">
<div class="control-group">											
	<label class="control-label" for="username">Others</label>
	<div class="controls">
	<input  type="text" class="span6" value="<?php echo $form->other ;?>"  name="add[other]">
	</div>			
</div>
</div>
</div>
<div class="span12">
<div class="span7">
<div class="control-group">											
	<label class="control-label" for="username">How you know about institute</label>
	<div class="controls">
	<input  type="text" class="span6"  name="add[how_know]" value="<?php echo $form->how_know ;?>" >
	</div>			
</div>
</div>
</div>
<div class="span12">
<div class="span10">
<div class="control-group">											
	<label class="control-label" for="username">Declaration of Applicant</label>
	<div class="controls">
	
	</div>			
</div>
</div>
</div>

<div>
<div>
</div>
</div>

<button type="submit" class="btn btn-info" >Update</button>


		</form>	
	
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
    $( "#dob" ).datepicker({
		changeMonth: true,
            changeYear: true,
			yearRange: '1950:2012'
	});
	
	 $( "#doj" ).datepicker({
		changeMonth: true,
            changeYear: true,
			//yearRange: '1999:2012'
	});
  });
  
  
  function get_ctgy(dd, dis){
		var stg = "#ctg"+dis	
	if(dd.checked){
			$(stg).show();
	}else{
		$(stg).hide();
	}			
	}
	
  
  
  
  function get_price(dd, dis,ds){
		var total = $('#total').val();
		//alert(total);
		
		var branch = $('#branch').val();
		var ctg_pp = "#ctg_pp"+dis;
if(branch !== ""){

		var stg = "#prc"+ds	
	if(dd.checked){
			

$.post('<?= site_url('admin/admission/get_fee') ?>',{ course_ctgy_id : dis,branch_id : branch}, function(msg){
		if(msg!='0'){
				$(ctg_pp).show();
				$(ctg_pp).val(msg);			
				if(total =='0'){
					$('#total').val(msg);
				}else{
					var tt = parseFloat(total);
					//alert('uii');
					//alert(total)
					var n_t = tt+parseFloat(msg);
					$('#total').val(n_t.toFixed(2));			
				}
		}else{
			
			alert("No Fees Assigned!");	
			$(dd).prop('checked', false);		
	
	
		}	
		
		});			



	}else{
		
		//alert("i am here");
		var ct_p = $(ctg_pp).val();	
			//alert(ct_p)
			if(ct_p){
				var total = $('#total').val();
				//alert(total);
				if(total!=0){
					var c_p = parseFloat(ct_p);
					var tt = parseFloat(total);
					var ccp = tt-c_p;
					$('#total').val(ccp.toFixed(2));
								
				}			
						
			}		
		$(ctg_pp).hide();
		$(ctg_pp).val();	
	}	 // edn of the uncheck code
	
	}else{
		alert("please Choose a Branch first");
		$(dd).prop('checked', false);
	}
	}
	
	
	
		function get_fee(ids){
			
		var b_id = document.getElementById('branch').value;	
		$.post('<?= site_url('admin/admission/get_fee') ?>',{ course_ctgy_id : ids,branch_id : b_id}, function(msg){
		$('#course_fee').html(msg);	
		});					
		}





function gen_userid(){
		var branch_id =  $('#branch').val();
		var origin_batch =  $('#origin_batch').val();
		var exam_batch =  $('#exam_batch').val();
		
		if(branch_id !='' && origin_batch !='' && exam_batch !=''){
			$.post('<?= site_url('admin/admission/gen_userid') ?>',{ branch_id : branch_id, origin_batch : origin_batch,exam_batch : exam_batch   }, function(msg){
	//alert(msg);
		$('#user_id').val(msg);	
		});	
		}else{	
		alert("Make Sure That You Have slected Branch, Origin Batch & Exam Batch");	
			
		}
			
	}

  function gen_password(){
  var name = $("#o_name").val();
  var branch_id =  $('#branch').val();
		var origin_batch =  $('#origin_batch').val();
		var exam_batch =  $('#exam_batch').val();
  
 if(name!=''&& branch_id !='' && origin_batch !='' && exam_batch !=''){
	$.post('<?= site_url('admin/admission/gen_password') ?>',{ name : name, branch_id : branch_id, origin_batch : origin_batch,exam_batch : exam_batch }, function(msg){
	//	alert(msg);
		$('#password').val(msg);	
		});	
 	
 }else{
 	alert("Make Sure That You Have selected Name, Branch, Origin Batch & Exam Batch");
 }	
	
  }
  
  
  </script>			