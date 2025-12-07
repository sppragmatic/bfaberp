<link rel="stylesheet" href="<?php echo base_url();?>assets/chosen/chosen.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Removed internal CSS -->
/* Contact validation styles */
.validation-message {
    font-size: 12px;
    margin-top: 5px;
    padding: 5px 8px;
    border-radius: 3px;
    min-height: 20px;
}

.validation-message.text-info {
    color: #31708f;
    background-color: #d9edf7;
    border: 1px solid #bce8f1;
}

.validation-message.text-success {
    color: #3c763d;
    background-color: #dff0d8;
    border: 1px solid #d6e9c6;
}

.validation-message.text-warning {
    color: #8a6d3b;
    background-color: #fcf8e3;
    border: 1px solid #faebcc;
}

.validation-message.text-danger {
    color: #a94442;
    background-color: #f2dede;
    border: 1px solid #ebccd1;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
}

.party-found {
    background-color: #dff0d8 !important;
    border-color: #d6e9c6 !important;
}
<!-- Removed internal CSS -->

<script>
function sdisp(st){
    if(st=='1'){
        $(".pmdetails").show();
    }else{
        $(".pmdetails").hide();
    }
}
</script>
<script src="<?php echo base_url()?>assets/validate/dist/jquery.validate.js"></script>
<script>
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
</script>".pmdetails").show();
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




    <div class="row">
 <div class="span6">
<div class="widget ">
<div class="widget-header">
<h3>ADD SALES</h3>

</div>

 <form action="<?php echo site_url('admin/sales/edit_sales')."/".$sales['id']?>" method="post">

 <div class="table-responsive">
 <table class="table table-striped table-bordered table-hover" id="dataTables-example">



								<tr><th>SL No.</th>	<td><input class="form-control" readonly="readonly" name="sl_no" value="<?php echo $sales['sl_no']; ?>" type="text"></td> </tr>
								<tr><th>Name OF PURCHASE</th>
					<td>
					<div id="cid">
					<select id="customer_id"   class="chosen-select"    name="customer_id">
				<option value="">-Select customer-</option>
				<?php foreach($customer as $pr){ ?>
				<option  <?php if($sales['customer_id']==$pr['id']){ ?> selected="selected" <?php } ?>    value="<?php echo $pr['id']; ?>"><?php echo $pr['name']; ?></option>
				<?php } ?>
					</select><span style="padding-left: 30px"><a onclick="cn()"><i class="icon-plus"></i></a></span>
		</div>

			<div id="cn" style="display: none;">
					<input id="customer_name"    name="customer_name">
				<span style="padding-left: 30px"><a onclick="cid()"><i class="icon-minus"></i></a></span>
		</div>

					</td>  </tr>



						        <tr> <th>VEHICLE NUMBER</th><td> <input value="<?php echo $sales['vehicle_number']; ?>" name="vehicle_number" type="text"></td>   </tr>

						        <tr> <th>VEHICLE OWNER</th><td> <input value="<?php echo $sales['vehicle_owner']; ?>" name="vehicle_owner" type="text"></td>   </tr>

								<tr><th>DELIVERY POINT ADDRESS</th><td><textarea name="address"> <?php echo $sales['address']; ?></textarea></td>  </tr>
								<tr><th>DATE</th><td><input id="date" name="bill_date" value="<?php echo $sales['bill_date']; ?>" type="text"></td>  </tr>

								<tr><th>Payment Type</th> <td><select id="payment_status"  onchange="sdisp(this.value)"  name="payment_status">
				<option value="0">-Select Type-</option>
				<option <?php if($sales['payment_status']=='1'){ ?> selected="selected" <?php } ?>  value="1">Paid</option>
				<option <?php if($sales['payment_status']=='2'){ ?> selected="selected" <?php } ?>  value="2">Unpaid</option>
					</select></td>  </tr>

					<tr <?php if($sales['payment_status']=='2'){ ?>style="display:none" <?php } ?> class="pmdetails"><th>Paid Amount</th><td><input type="text"  name="paid_amount" value="<?php echo $sales['paid_amount']; ?>" > </td>  </tr>

						<tr <?php if($sales['payment_status']=='2'){ ?>style="display:none" <?php } ?> class="pmdetails"><th>Payment Type</th><td>
							<input type="radio" <?php if($sales['type']=='1'){ ?> checked="checked" <?php } ?>  name="type" value="1" > Cash
								<input type="radio" <?php if($sales['type']=='2'){ ?> checked="checked" <?php } ?>   name="type" value="2" > Cheque
						 </td>  </tr>

<tr  <?php if($sales['payment_status']=='2'){ ?>style="display:none" <?php } ?> class="pmdetails"><th>Paymet Details</th><td><textarea name="paiddetails"><?php echo $sales['paiddetails']; ?></textarea></td>  </tr>


                                 </table>
</div>

</div>
</div>

 <div class="span6">
<div class="widget ">
<div class="widget-header">
<h3>ITEM DETAILS</h3>

</div>

 	<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
<th>PRODUCT</th>
<th>QUANTITY</th>
<th>RATE</th>
<th>AMOUNT</th>
										</tr>
									</thead>
									<tbody>
<?php $sm=1; foreach ($products as $fm){?>
<tr>
<td><?php echo $fm['name'];?></td>
<td><input name="prod[<?php echo $fm['id'];?>]" class="quantity-input" 
           value="<?php echo $fm['stock'];?>" 
           type="number" step="0.01" min="0" 
           data-product-id="<?php echo $fm['id'];?>" 
           onkeyup="calculateAmount(<?php echo $fm['id'];?>)" 
           onchange="calculateAmount(<?php echo $fm['id'];?>)"></td>
<td><input name="rate[<?php echo $fm['id'];?>]" class="rate-input" 
           value="<?php echo isset($fm['rate']) ? $fm['rate'] : ''; ?>" 
           type="number" step="0.01" min="0" 
           data-product-id="<?php echo $fm['id'];?>" 
           onkeyup="calculateAmount(<?php echo $fm['id'];?>)" 
           onchange="calculateAmount(<?php echo $fm['id'];?>)"></td>
<td><input name="amount[<?php echo $fm['id'];?>]" class="amount-input" 
           value="<?php echo $fm['amount'];?>" 
           type="number" step="0.01" min="0" 
           data-product-id="<?php echo $fm['id'];?>" readonly></td>
</tr>
<?php } ?>
							     <tr ><th colspan="4" align="right"> <input type="submit" value="Submit" class="btn btn-primary pull-right"></th></tr>
									</tbody>


</table>




								 </form>

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

  function cid(){
   $( "#cid" ).show();
    $( "#cn" ).hide();
  }

 function cn(){
   $( "#cid" ).hide();
    $( "#cn" ).show();
  }

    // Calculate amount for individual product (quantity * rate)
    function calculateAmount(productId) {
        var quantity = parseFloat($('input[name="prod[' + productId + ']"]').val()) || 0;
        var rate = parseFloat($('input[name="rate[' + productId + ']"]').val()) || 0;
        var amount = quantity * rate;
        
        // Set the calculated amount
        $('input[name="amount[' + productId + ']"]').val(amount.toFixed(2));
        
        // Recalculate total
        calculateTotalAmount();
    }

    // Calculate total amount from all products
    function calculateTotalAmount() {
        var totalAmount = 0;
        $('.amount-input').each(function() {
            var amount = parseFloat($(this).val()) || 0;
            totalAmount += amount;
        });
        
        // You can add a total display field here if needed
        console.log('Total Amount: ' + totalAmount.toFixed(2));
    }

    // Initialize calculation events when document is ready
    $(document).ready(function() {
        // Add event listeners for real-time calculation
        $('.quantity-input, .rate-input').on('input keyup change', function() {
            var productId = $(this).data('product-id');
            calculateAmount(productId);
        });
        
        // Allow direct editing of amount field and recalculate total
        $('.amount-input').on('input keyup change', function() {
            calculateTotalAmount();
        });
        
        // Calculate initial total on page load
        calculateTotalAmount();
    });  </script>
