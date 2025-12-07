
<script type="text/javascript">
  function PrintDiv() {    
           var divToPrint = document.getElementById('print');
           var popupWin = window.open('', '_blank', 'width=800,height=800');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
            popupWin.document.close();
                }
</script>




<div class="main">

  <div class="main-inner">

    <div class="container">

    <div class="row">

   <div class="span12">
   <h2>Student Payment</h2>
<a class="btn btn-success" href="<?php echo site_url('admin/admin/index');?>"> Back </a>
<div class="widget ">
<div class="widget-content">

 <div>

<input type="button" value="Print" onclick="PrintDiv();"></div>
<div id="print">

 <div class="table-responsive">
 <table  width="100%" border="1" cellspacing="1" cellpadding="0" style="font-size: 5px !mportant">

                                    
		<tr >
			<td width="25%" align="center"><img src="<?php echo base_url()."/assets/img/first.jpg" ?>"></td>
			<td width="50%" style="text-align: center"><?php if($report['type']=='1'){  ?> RECEIPT <?php } ?>  <?php if($report['type']=='2'){  ?>  PAYMENT <?php } ?> VOUCHER<br> <img src="<?php echo base_url()."/assets/img/second.jpg" ?>"></td>
			<td width="25%"><p>BRANCH :<?php echo  $report['br_code']; ?>  /   Sl NO : <?php echo  $report['id']; ?> </p>
			<p>Party Name: <?php echo $report['pnme']; ?></p>
			<p>Party code: <?php echo $report['party_name']; ?></p>
			<p>Date:  <?php echo date('d-m-Y',strtotime($report['entry_date'])); ?></p>
			</td>
			
		</tr>
		

	
	<tr>
	<td colspan="3">
Received with thanks from :<strong> <?php echo $report['pnme']; ?> </strong><br />
	</td>	
	</tr>

<tr>
	<td colspan="3">

Rupees (In Words):  <strong><?php echo $this->payment_model->convertNumber($report['amount']);  ?> ONLY /-</strong><br />
</td>
</tr>

<tr>
	<td colspan="2">

Rupees (In Number):<strong> <?php echo $report['amount']; ?></strong><br />
</td>


</tr>

	<tr>
	<td colspan="3">
Transaction Type : <span  contenteditable="true">  <?php if($report['type']==1){  ?> Receipt <?php }else{  ?> Payment <?php } ?>   </span><br />
	</td>	
	</tr>

	<tr>
	<td colspan="3">

Towords : <span contenteditable="true"> <?php echo $report['remarks']; ?></span><br>
	</td>	
	</tr>

	
	<tr class="odd gradeX">
			<td colspan="3" style="text-align: center"><br>Bhubaneswar

 H.O: Address:
221,Saheed Nagar, BBSR,Odisha
 Contact:
+91 94-38-734530
B.O:  Branch Office:
215, 2nd Floor,Saheed Nagar, BBSR,Odisha 
<br />
B.O: Cuttack
 Address:
2nd Floor,Above Grand Automobile,Arunodaya Market,Link Road, CTC,Odisha
<br />
B.O: Balasore
 Address:
C/o Ashok Ku. Sing,Opposite Of Kalinga Hotel, Near (Gandhi Smruti Bhaban), Balasore-756001,Odisha<br />
<b>Email : questqsk@yahoo.com, Website : www.questbbsr.org, facebook : questbbsr24X7<b><br />

</td>
			
		</tr>
<tr>
<td colspan="" align="right">
<p class="pull-left">
<br/ >
<br/ >

<b> <?php if($report['type']=='1'){  ?> Received From <?php } ?>  <?php if($report['type']=='2'){  ?>  Paid To <?php } ?></b>
</p>
</td>
<td></td>

<td colspan="" align="right">
<p class="pull-right">
<br/ >
<br/ >

<b>Authorised Signatory&nbsp;&nbsp;&nbsp;&nbsp;</b>
</p>
</td>
</tr>
	
                                </table>
</div>
							<br/>
							<hr />	
							<br/>	
								<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size: 5px !mportant">

     <tr >
			<td width="25%" align="center"><img src="<?php echo base_url()."/assets/img/first.jpg" ?>"></td>
			<td width="50%" style="text-align: center"><?php if($report['type']=='1'){  ?> RECEIPT <?php } ?>  <?php if($report['type']=='2'){  ?>  PAYMENT <?php } ?> VOUCHER<br> <img src="<?php echo base_url()."/assets/img/second.jpg" ?>"></td>
			<td width="25%"><p>BRANCH :<?php echo  $report['br_code']; ?>  /   Sl NO : <?php echo  $report['id']; ?> </p>
			<p>Party Name: <?php echo $report['pnme']; ?></p>
			<p>Party code: <?php echo $report['party_name']; ?></p>
			<p>Date:  <?php echo date('d-m-Y',strtotime($report['entry_date'])); ?></p>
			</td>
			
		</tr>
		


	<tr>
	<td colspan="3" >
Received with thanks from : <strong><?php echo $report['pnme']; ?></strong>
</td>
</tr>
	<tr>
	<td colspan="3">

Rupees (In Words):  <strong> <?php echo $this->payment_model->convertNumber($report['amount']);  ?> ONLY /-</strong><br />
</td>
</tr>

	<tr>
	<td colspan="2">

Rupees (In Number):<strong> <?php echo $report['amount']; ?></strong><br />
</td>


</tr>

	<tr>
	<td colspan="3">

Transaction Type: <span contenteditable="true">  <?php if($report['type']=='1'){  ?> Receipt <?php } ?>  <?php if($report['type']=='2'){  ?>  Payment <?php } ?></span><br />
</td>
</tr>

	<tr>
	<td colspan="3">

Towords  : <span contenteditable="true">  <?php echo $report['remarks']; ?></span><br>
</td>
</tr>
	<tr class="odd gradeX">
			<td colspan="3" style="text-align: center"><br>Bhubaneswar

 H.O: Address:
221,Saheed Nagar, BBSR,Odisha
 Contact:
+91 94-38-734530
B.O:  Branch Office:
215, 2nd Floor,Saheed Nagar, BBSR,Odisha 
<br />
B.O: Cuttack
 Address:
2nd Floor,Above Grand Automobile,Arunodaya Market,Link Road, CTC,Odisha
<br />
B.O: Balasore
 Address:
C/o Ashok Ku. Sing,Opposite Of Kalinga Hotel, Near (Gandhi Smruti Bhaban), Balasore-756001,Odisha<br />
<b>Email : questqsk@yahoo.com, Website : www.questbbsr.org, facebook : questbbsr24X7</b><br/ >
</td>
		</tr>
<tr>
<td colspan="" align="right">
<p class="pull-left">
<br/ >
<br/ >

<b> <?php if($report['type']=='1'){  ?> Received From <?php } ?>  <?php if($report['type']=='2'){  ?>  Paid To <?php } ?></b>
</p>
</td>
<td></td>

<td colspan="" align="right">
<p class="pull-right">
<br/ >
<br/ >

<b>Authorised Signatory&nbsp;&nbsp;&nbsp;&nbsp;</b>
</p>
</td>
</tr>
	
	
	
                                </table>
</div>
								
								</div>
 
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

<script>
  $(function() {
    $( ".dob" ).datepicker({
		changeMonth: true,
            changeYear: true,
	});







$("#admission").validate({
			rules: {
				amt_paid : "required",
				paid_date: "required",
				next_date: "required"
				},
			messages: {
				amt_paid : "Please enter The Paid Amount!",
				paid_date: "Please Enter the Paid Date!",
				next_date: "Please Enter The Next Date!"
			}
		});




  });
</script>