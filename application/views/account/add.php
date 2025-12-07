<link rel="stylesheet" href="<?php echo base_url();?>assets/css/sales-form.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/admin-sales-common.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/sales-centralized.css">


<script>
function get_party(material_id){
	$.post("<?php echo site_url('admin/account/get_matparty'); ?>", { material_id : material_id  },function(msg){
//alert(msg);
		$('#party_id').html(msg);

	});
//	alert(course_id)
}

function sdisp(st){
	if(st=='1'){
	$(".pmdetails").show();
	}else{
		$(".pmdetails").hide();
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
        <h1><i class="fas fa-plus-circle"></i> Add Material</h1>
        <p>Add new material entry to account</p>
      </div>

      <div class="row">
        <div class="span12">
          <div class="widget modern-widget">
            <div class="widget-header modern-header">
              <h3><i class="fas fa-box"></i> ADD MATERIAL</h3>
            </div>
            <form action="<?php echo site_url('admin/account/index')?>" method="post" class="modern-form">
              <div class="widget-content modern-content">
                <div class="table-responsive">
                  <table class="table modern-table" id="dataTables-example">
                    <tr>
                      <th class="modern-table-header">Transaction No.</th>
                      <td><input class="form-control modern-input" name="trans_no" readonly value="<?php echo $trans_no; ?>" type="text"></td>
                    </tr>
                    <tr>
                      <th class="modern-table-header">Vehicle No.</th>
                      <td><input class="form-control modern-input" name="vehicle_no" value="<?php echo $vehicle_no; ?>" type="text"></td>
                    </tr>
                    <tr>
                      <th class="modern-table-header">Material Name</th>
                      <td>
                        <select id="material_id" name="material_id" class="form-control modern-select">
                          <option value="">-Select Material-</option>
                          <?php foreach($material as $pr){ ?>
                          <option value="<?php echo $pr['id']; ?>"><?php echo $pr['name']; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <th class="modern-table-header">Party Name</th>
                      <td>
                        <select id="party_id" name="party_id" class="form-control modern-select">
                          <option value="">-Select Party-</option>
                          <?php foreach($party as $pr){ ?>
                          <option value="<?php echo $pr['id']; ?>"><?php echo $pr['name']; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <th class="modern-table-header">Payment Status</th>
                      <td>
                        <select id="payment_status" onchange="sdisp(this.value)" name="payment_status" class="form-control modern-select">
                          <option value="">-Select Type-</option>
                          <option value="1">Paid</option>
                          <option value="0">Un Paid</option>
                        </select>
                      </td>
                    </tr>

                    <tr style="display:none" class="pmdetails">
                      <th class="modern-table-header">Paid Amount</th>
                      <td><input name="paid_amount" value="<?php echo $paid_amount; ?>" type="text" class="form-control modern-input"></td>
                    </tr>
                    <tr style="display:none" class="pmdetails">
                      <th class="modern-table-header">Payment Type</th>
                      <td>
                        <div class="radio-group">
                          <label><input type="radio" name="type" value="1"> Cash</label>
                          <label><input type="radio" name="type" value="2"> Cheque</label>
                        </div>
                      </td>
                    </tr>
                    <tr style="display:none" class="pmdetails">
                      <th class="modern-table-header">Payment Details</th>
                      <td><textarea name="paiddetails" class="form-control modern-textarea" rows="4"><?php echo $paiddetails; ?></textarea></td>
                    </tr>
                    <tr>
                      <th class="modern-table-header">Ref No.</th>
                      <td><input name="refno" value="<?php echo $refno; ?>" type="text" class="form-control modern-input"></td>
                    </tr>
                    <tr>
                      <th class="modern-table-header">Quantity</th>
                      <td><input name="stock" type="text" class="form-control modern-input"></td>
                    </tr>
                    <tr>
                      <th class="modern-table-header">Unit</th>
                      <td><input name="unit" type="text" class="form-control modern-input" placeholder="e.g. kg, litre, pcs"></td>
                    </tr>
                    <tr>
                      <th class="modern-table-header">Amount</th>
                      <td><input name="amount" value="<?php echo $amount; ?>" type="text" class="form-control modern-input"></td>
                    </tr>
                    <tr>
                      <th class="modern-table-header">Date</th>
                      <td><input id="date" name="entry_date" value="<?php echo $entry_date; ?>" type="text" class="form-control modern-input"></td>
                    </tr>
                    <tr>
                      <th class="modern-table-header">Remarks</th>
                      <td><textarea name="remarks" class="form-control modern-textarea" rows="4"><?php echo $remarks; ?></textarea></td>
                    </tr>
                    <tr>
                      <th></th>
                      <td><input type="submit" value="Add Material" class="btn btn-primary-gradient"></td>
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

	<script src="<?php echo base_url()?>assets/validate/dist/jquery.validate.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/ui/jquery-ui.css" />
<script src="<?php echo base_url()?>assets/ui/jquery-ui.js"></script>
	<script>
	$(function() {
  //	alert("hello")
    $( "#date" ).datepicker({
		changeMonth: true,
            changeYear: true,
						dateFormat: 'dd-mm-yy'
	});

	 $( "#doj" ).datepicker({
		changeMonth: true,
            changeYear: true,
						dateFormat: 'dd-mm-yy'
	});
  });

  </script>
