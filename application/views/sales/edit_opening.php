<link rel="stylesheet" href="<?php echo base_url();?>assets/css/sales-centralized.css">

<script>
function get_course_category(course_id){
	$.post("<?php echo site_url('admin/admission/get_course_category'); ?>", { course_id : course_id  },function(msg){

		$('#cr_ctg').html(msg);

	});
//	alert(course_id)
}


function get_course_ctgy_price(ctgy){
	//alert($('#cr_ctg').val());
	var course_id = $('#cr_cor').val();
	var branch_id = $('#cr_br').val();

	$.post("<?php echo site_url('admin/admission/get_course_ctgy_price'); ?>", { course_id : course_id, category_id : ctgy, branch_id : branch_id  },function(msg){
	//alert(msg)
		$('#price').val(msg);

	});
//	alert(course_id)


}

</script>
<script src="<?php echo base_url()?>assets/validate/dist/jquery.validate.js"></script>				<script>

	$().ready(function() {
		// validate the comment form when it is submitted

		// validate signup form on keyup and submit
		$("#rejoin-form").validate({
			rules: {
				'course': "required",
				'course_ctgy': "required"

			},
			messages: {
				'course': "Please choose your course",
				'course_ctgy': "Please choose COURSE CATEGORY"

			}
		});

		// propose username by combining first- and lastname

	});
			</script>

<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <?php echo validation_errors(); ?>
</div>


<div class="main">

  <div class="main-inner">

    <div class="container">




    <div class="row">
 <div class="span12">
<div class="widget ">
<div class="widget-header">
<h3>EDIT OPENING BALANCE</h3>

</div>

 <form action="<?php echo site_url('admin/sales/edit_opening')."/".$sales['id']?>" method="post">

 <div class="table-responsive">
 <table class="table table-striped table-bordered table-hover" id="dataTables-example">



								<tr><th>SL No.</th>	<td><input class="form-control" readonly="readonly" name="sl_no" value="<?php echo $sales['invno']; ?>" type="text"></td> </tr>
								<tr><th>Name OF Customer</th>
					<td>
					<div id="cid">
					<select id="customer_id" disabled readonly class="chosen-select"    name="customer_id">
				<option value="">-Select customer-</option>
				<?php foreach($customer as $pr){ ?>
				<option  <?php if($sales['customer_id']==$pr['id']){ ?> selected="selected" <?php } ?>    value="<?php echo $pr['id']; ?>"><?php echo $pr['name']; ?></option>
				<?php } ?>
					</select>
		</div>



					</td>  </tr>



								<tr><th>DATE</th><td><input id="date" name="entry_date" value="<?php echo $sales['entry_date']; ?>" type="text"></td>  </tr>
								<tr> <th>Opening Amount</th><td> <input value="<?php echo $sales['credit']; ?>" name="debit" type="text"></td>   </tr>
								<tr><th>DETAILS</th><td><textarea name="details"> <?php echo $sales['details']; ?></textarea></td>  </tr>
								<tr><th></th><td><input type="submit" class="btn btn-success" value="Submit" ></td>  </tr>

                                 </table>
</div>

</div>
</div>


</div>





	</div>
	</div>

	<script src="<?php echo base_url()?>assets/validate/dist/jquery.validate.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/ui/jquery-ui.css" />
<script src="<?php echo base_url()?>assets/ui/jquery-ui.js"></script>
	<script>
  $(function() {
  //	alert("hello")
    $( "#date" ).datepicker({
		changeMonth: true,
            changeYear: true,
	});

	 $( "#doj" ).datepicker({
		changeMonth: true,
            changeYear: true,
	});
  });

  function cid(){
   $( "#cid" ).show();
    $( "#cn" ).hide();

  	}

  function cn(){
  	 $( "#cid" ).hide();
    $( "#cn" ).show();
  	}

  </script>
  
   <script src="<?php echo base_url();?>assets/chosen/chosen.jquery.js" type="text/javascript"></script>

    <script type="text/javascript">

         var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }

</script>


