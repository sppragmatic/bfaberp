<link rel="stylesheet" href="<?php echo base_url();?>assets/css/sales-form.css">


<script>
function get_course_category(course_id){
	$.post("<?php echo site_url('admin/admission/get_course_category'); ?>", { course_id : course_id  },function(msg){

		$('#cr_ctg').html(msg);

	});
//	alert(course_id)
}

function sdisp(st){
	if(st=='1'){
	$("#pmdetails").show();
	}else{
		$("#pmdetails").hide();
	}

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

      <!-- Page Header -->
      <div class="page-header-card">
        <h1><i class="fas fa-plus-circle"></i> Add Opening Balance</h1>
        <p>Add customer opening balance record</p>
      </div>

      <div class="row">
        <div class="span12">
          <div class="widget modern-widget">
            <div class="widget-header modern-header">
              <h3><i class="fas fa-balance-scale"></i> ADD OPENING BALANCE</h3>
            </div>

            <form action="<?php echo site_url('admin/sales/add_opening')?>" method="post" class="modern-form">
              <div class="widget-content modern-content">
                <div class="table-responsive">
                  <table class="table modern-table" id="dataTables-example">



                    <tr>
                      <th class="modern-table-header">SL No.</th>
                      <td><input class="form-control modern-input" readonly="readonly" name="sl_no" value="<?php echo $trans_no; ?>" type="text"></td>
                    </tr>
                    <tr>
                      <th class="modern-table-header">Customer Name</th>
                      <td>
                        <div id="cid">
                          <select id="customer_id" class="chosen-select modern-select" name="customer_id">
                            <option value="">-Select customer-</option>
                            <?php foreach($customer as $pr){ ?>
                            <option value="<?php echo $pr['id']; ?>"><?php echo $pr['name']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th class="modern-table-header">Date</th>
                      <td><input id="date" name="entry_date" type="text" class="form-control modern-input"></td>
                    </tr>
                    <tr>
                      <th class="modern-table-header">Opening Amount</th>
                      <td><input id="amount" name="debit" type="text" class="form-control modern-input"></td>
                    </tr>
                    <tr>
                      <th class="modern-table-header">Payment Details</th>
                      <td><textarea id="details" name="details" class="form-control modern-textarea" rows="4"></textarea></td>
                    </tr>
                    <tr>
                      <th></th>
                      <td><input id="submit" name="submit" class="btn btn-primary-gradient" value="Submit" type="submit"></td>
                    </tr>

                  </table>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

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

  	function setamount(amt,dis){


  alert($("#amount").value());
  /*	 var amount =  parseInt($("#amount").value());
  	 var cst =  parseInt(amt);
  	 alert(amonut);
  	 alert(cst)
  	 var ns = amount+cst;
  	 $("#amount").value(ns)*/

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

