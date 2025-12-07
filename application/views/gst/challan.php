
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
 <table  width="100%" border="1" cellspacing="1" cellpadding="0" style="font-size: 5px !mportant">
         <tr >

           <td>
            <span class="pull-left">SL NO . <?php echo $sales['sl_no']; ?> </span >
           </td>
    	<td colspan="2" align="center">
    	     <img style="margin-top: 3px;" src="<?= base_url();?>/assets/logo.png" />
  <h5>( FACTORY COPY )</h5>
			</td>

      <td>
       <span class="pull-right"> Date. <?php echo date('d-m-Y',strtotime($sales['bill_date'])); ?></span ><br/>
         <!--<span class="pull-right"> Contact No :  7749002141 , 7894351251 </span >-->
      </td>
    </tr>

	<tr>
	<td colspan="2">
Vehicle No / Owner :<strong> <?php echo $sales['vehicle_number']; ?> / <?php echo $sales['vehicle_owner']; ?> </strong><br />
	</td>
  <td colspan="2">

Total Amount :  <strong>  <?php echo $sales['total_amount']; ?> <?php //echo $this->payment_model->convertNumber($sales['total_amount']);  ?> </strong><br />
</td>
	</tr>

	<tr>
	<td colspan="4">
Name of Purchaser / Address :<strong> <?php echo $sales['customername']; ?> / <?php echo $sales['address']; ?> </strong><br />
	</td>
	</tr>


<tr><td colspan="4" align="center"><h3>PARTICULARS</h3></td></tr>
<tr>
<th>Sl NO</th>
<th>Size</th>
<th>Qnty</th>
<th>Amount</th>
</tr>
<?php $sm=0; foreach ($products as $fm){
	//$sm=$sm+1;
  if($fm['stock']!=0){
    $sm=$sm+1;
	?>
<tr>
<td align="center"><?php echo $sm;?></td>
<td align="center"><?php echo $fm['name'];?></td>
<td align="center"><?php echo $fm['stock'];?></td>
<td align="center"><?php echo $fm['amount'];?></td>
</tr>
<?php
}
} ?>
<tr>
<td colspan="2">
	<p class="pull-right">
<br/ >
<br/ >

<b>Signature Of Driver&nbsp;&nbsp;&nbsp;&nbsp;</b>
</p>
</td>
<td><p class="pull-right">
<br/ >
<br/ >

<b>Purcahaser Signature&nbsp;&nbsp;&nbsp;&nbsp;</b>
</p>
</td>
<td colspan="2" align="right">
<p class="pull-right">
<br/ >
<br/ >

<b>Signature Of Factory Incharge&nbsp;&nbsp;&nbsp;&nbsp;</b>
</p>
</td>
</tr>
</table>

							<hr />


             <div class="table-responsive">
 <table  width="100%" border="1" cellspacing="1" cellpadding="0" style="font-size: 5px !mportant">
                     <tr >

                       <td>
                        <span class="pull-left">SL NO . <?php echo $sales['sl_no']; ?> </span >
                       </td>
                  <td colspan="2" align="center">
                       <img style="margin-top: 3px;" src="<?= base_url();?>/assets/logo.png" />
  <h5>( TRANSPORTER COPY )</h5>
                  <!--  <h3>BHABANI FLY ASH BRICKS</h4>-->
                  <!--<h5>At-Butupali (Padhisahi),Boudh </h5>-->
                  </td>

                  <td>
                   <span class="pull-right"> Date. <?php echo date('d-m-Y',strtotime($sales['bill_date'])); ?></span ><br/>
                    <!--<span class="pull-right"> Contact No :  7749002141 , 7894351251 </span >-->

                  </td>
                </tr>

              <tr>
              <td colspan="2">
            Vehicle No / Owner :<strong> <?php echo $sales['vehicle_number']; ?> / <?php echo $sales['vehicle_owner']; ?> </strong><br />
              </td>
              <td colspan="2">

            Total Amount :  <strong>  <?php echo $sales['total_amount']; ?> <?php //echo $this->payment_model->convertNumber($sales['total_amount']);  ?> </strong><br />
            </td>
              </tr>

              <tr>
              <td colspan="4">
            Name of Purchase / Address :<strong> <?php echo $sales['customername']; ?> / <?php echo $sales['address']; ?> </strong><br />
              </td>
              </tr>


            <tr><td colspan="4" align="center"><h3>PARTICULARS</h3></td></tr>
            <tr>
            <th>Sl NO</th>
            <th>Size</th>
            <th>Qnty</th>
            <th>Amount</th>
            </tr>
            <?php $sm=0; foreach ($products as $fm){
              //$sm=$sm+1;

              if($fm['stock']!=0){
                $sm=$sm+1;
              ?>
            <tr>
            <td align="center"><?php echo $sm;?></td>
            <td align="center"><?php echo $fm['name'];?></td>
            <td align="center"><?php echo $fm['stock'];?></td>
            <td align="center"><?php echo $fm['amount'];?></td>
            </tr>
            <?php
}
          } ?>
            <tr>
            <td colspan="2">
              <p class="pull-right">
            <br/ >
            <br/ >

            <b>Signature Of Driver&nbsp;&nbsp;&nbsp;&nbsp;</b>
            </p>
            </td>
            <td><p class="pull-right">
            <br/ >
            <br/ >

            <b>Purcahaser Signature&nbsp;&nbsp;&nbsp;&nbsp;</b>
            </p>
            </td>
            <td colspan="2" align="right">
            <p class="pull-right">
            <br/ >
            <br/ >

            <b>Signature Of Factory Incharge&nbsp;&nbsp;&nbsp;&nbsp;</b>
            </p>
            </td>
            </tr>
            </table>
</div>
<hr/>
<table  width="100%" border="1" cellspacing="1" cellpadding="0" style="font-size: 5px !mportant">
       <tr >

         <td>
          <span class="pull-left">SL NO . <?php echo $sales['sl_no']; ?> </span >
         </td>
    <td colspan="2" align="center">
         <img style="margin-top: 3px;" src="<?= base_url();?>/assets/logo.png" />
  <h5>( CUSTOMER COPY )</h5>
    <!--  <h3>BHABANI FLY ASH BRICKS</h4>-->
    <!--<h5>At-Butupali (Padhisahi),Boudh </h5>-->
    </td>

    <td>
     <span class="pull-right"> Date. <?php echo date('d-m-Y',strtotime($sales['bill_date'])); ?></span ><br/>
       <!--<span class="pull-right"> Contact No :  7749002141 , 7894351251 </span >-->
    </td>
  </tr>

<tr>
<td colspan="2">
Vehicle No / Owner :<strong> <?php echo $sales['vehicle_number']; ?> / <?php echo $sales['vehicle_owner']; ?> </strong><br />
</td>
<td colspan="2">

Total Amount :  <strong>  <?php echo $sales['total_amount']; ?> <?php //echo $this->payment_model->convertNumber($sales['total_amount']);  ?> </strong><br />
</td>
</tr>

<tr>
<td colspan="4">
Name of Purchase / Address :<strong> <?php echo $sales['customername']; ?> / <?php echo $sales['address']; ?> </strong><br />
</td>
</tr>


<tr><td colspan="4" align="center"><h3>PARTICULARS</h3></td></tr>
<tr>
<th>Sl NO</th>
<th>Size</th>
<th>Qnty</th>
<th>Amount</th>
</tr>
<?php $sm=0; foreach ($products as $fm){

  if($fm['stock']!=0){
    $sm=$sm+1;
?>
<tr>
<td align="center"><?php echo $sm;?></td>
<td align="center"><?php echo $fm['name'];?></td>
<td align="center"><?php echo $fm['stock'];?></td>
<td align="center"><?php echo $fm['amount'];?></td>
</tr>
<?php
}
 } ?>
<tr>
<td colspan="2">
<p class="pull-right">
<br/ >
<br/ >

<b>Signature Of Driver&nbsp;&nbsp;&nbsp;&nbsp;</b>
</p>
</td>
<td><p class="pull-right">
<br/ >
<br/ >

<b>Purcahaser Signature&nbsp;&nbsp;&nbsp;&nbsp;</b>
</p>
</td>
<td colspan="2" align="right">
<p class="pull-right">
<br/ >
<br/ >

<b>Signature Of Factory Incharge&nbsp;&nbsp;&nbsp;&nbsp;</b>
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
