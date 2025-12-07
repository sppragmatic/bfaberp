
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
   <h2>CHALLAN DETAILS</h2>
<a class="btn btn-success" href="<?php echo site_url('admin/admin/index');?>"> Back </a>
<div class="widget ">
<div class="widget-content">

 <div>

<input type="button" value="Print" onclick="PrintDiv();"></div>
<div id="print">

 <div class="table-responsive">
 <table  width="100%" border="1" cellspacing="1" cellpadding="0" style="font-size: 3px !mportant">


    <tr >

      <td>
       <span class="pull-left">Contact No :  7894351251 </span >
      </td>
 <td colspan="4" align="center">

<h5>TAX INVOICE</h5>

 <td>
    <span class="pull-left"> Contact No :  7749002141  </span >
 </td>
</tr>

         <tr >

    	<td colspan="6" align="center">
       <img style="margin-top: 3px;" src="<?= base_url();?>/assets/logo.png" />
<h5>GSTIN - 21ADFPM2158R2Z9 </h5>
    </td>


    </tr>



    <tr >
      <td colspan="2">
       <span class="pull-left">
         Name of Purchaser / Address :<br/><strong> <?php echo $sales['customername']; ?> <br/> <?php echo $sales['address']; ?> </strong><br />

GST No : <strong> <?php echo $sales['gst_no']; ?>
          </span >
      </td>

 <td colspan="4">
  <div class="table-responsive">
 <table width="100%" border="1"  cellspacing="1" cellpadding="0">
     <tr>
       <td width="50%">INOVOICE NO</td>
        <td>DATE</td>
     </tr>

     <tr>
       <td><?php echo $sales['sl_no']; ?></td>
        <td><?php echo date('d-m-Y',strtotime($sales['bill_date'])); ?></td>
     </tr>

     <tr >
       <td colspan="2">
         <div>VEHICLE NO -  <?php echo $sales['vehicle_number']; ?> </div>
         <div>DRIVER NAME -  <?php echo $sales['vehicle_owner']; ?> </div>

       </td>

     </tr>

   </table>
</div>

</td>
</tr>

<tr>
<th>Description Of Goods</th>
<th>HSN CODE</th>
<th>Qnty</th>
<th>Unit</th>
<th>Rate</th>
<th>Amount</th>
</tr>

<?php $total = 0;$grand=0;$sm=0; foreach ($products as $fm){
	//$sm=$sm+1;
  if($fm['stock']!=0){
    $sm=$sm+1;
    $total = $total + $fm['amount'];
	?>
<tr>
<td align="center"><?php echo $fm['name'];?></td>
<td align="center">6815</td>
<td align="center"><?php echo $fm['stock'];?></td>
<td align="center">Pcs.</td>
<td align="center"><?php echo $fm['amount'];?></td>
<td align="center"><?php echo $fm['amount'];?></td>
</tr>
<?php
}
} ?>
<tr>


  <tr>
  <td colspan="1" align="center">&nbsp;</td>
  <td colspan="4" align="center">TOTAL</td>
  <td align="center"><?php echo $total; ?></td>
<?php
$sgst = $cgst  =  ($total*6)/100;
$grandtotal = $total + $sgst + $cgst;

?>
  <tr>
  <tr>
    <td  colspan="1" align="center">&nbsp;</td>
  <td colspan="4" align="center">CGST @ 6 %</td>
  <td align="center"><?php echo $cgst; ?></td>
</tr>
<tr>
  <td  colspan="1" align="center">&nbsp;</td>
  <td colspan="4" align="center">SGST @ 6 % </td>
    <td  align="center" ><?php echo $sgst; ?></td>
</tr>
<tr>
  <td  colspan="1" align="center">&nbsp;</td>
  <td colspan="4" align="center">IGST @ 0 %</td>
<td align="center">0</td>
</tr>
<tr>
  <td colspan="1" align="center">&nbsp;</td>
  <td  colspan="4" align="center">GRAND TOTAL</td>
  <td align="center"><?php echo $grandtotal; ?></td>

  </tr>



<td colspan="1">
	<p class="pull-left">
<?php
$gd = number_format($grandtotal,2);

?>
  Amount Chargeable (in words) :   <?php echo $this->payment_model->convertNumber($gd);  ?> only


<br/ >
Company's PAN :  ADFPM2158R
<br/ >
<br/ >
<br/ >
<br/ >
<b>&nbsp;&nbsp;&nbsp;&nbsp;PURCHASER SIGNATURE</b>
</p>
</td>

<td colspan="5" align="right">
<p class="pull-right">
For M/S -  BHABANI FLY ASH BRICKS
<br/ >
<br/ >
<br/ >
<br/ >
<b>Authority Signature &nbsp;&nbsp;&nbsp;&nbsp;</b>
</p>
</td>
</tr>
</table>

							<hr />




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
