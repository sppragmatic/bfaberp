
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
<a class="btn btn-success" href="<?php echo site_url('admin/sales/view_payment');?>"> Back </a>
<div class="widget ">
<div class="widget-content">

 <div>

<input type="button" value="Print" onclick="PrintDiv();"></div>
<div id="print">

 <div class="table-responsive">
 <table  width="100%" border="1" cellspacing="1" cellpadding="0" style="font-size: 5px !mportant">
         <tr>
    	<td colspan="4" align="center">
        <h5> ( FACTORY  COPY ) </h5>
        <h3>BHABANI FLY ASH BRICKS</h4>
			<h5>At-Butupali (Padhisahi),Boudh </h5>
<h5> Contact No :  7749002141 , 7894351251  </h5>
</td>
    </tr>


    <tr>
    <td colspan="4" align="center">
     <h1>MONEY RECEIPT</h1>
    </td>
    </tr>

    <tr>
    <td colspan="4">
      <br>
     <span > Date. <?php echo date('d-m-Y',strtotime($sales['entry_date'])); ?></span >
       <br>
    </td>
    </tr>

    <tr>
    	<td colspan="4">
        <br>
  SL NO . :<strong> <?php echo $sales['invno']; ?>  </strong><br />
    	</td>
    </tr>

<tr>
	<td colspan="4">
    <br>
Name :<strong> <?php echo $sales['customername']; ?>  </strong><br />
	</td>
</tr>
<tr>
  <td colspan="4">
    <br>
Address :<strong> <?php echo $sales['address']; ?>  </strong><br />
  </td>
</tr>
<tr>
  <td colspan="4">
    <br>
Total Amount :  <strong>  <?php echo $sales['debit']; ?>  (<?php echo $this->payment_model->convertNumber($sales['debit']);  ?> Only /- ) </strong><br />
</td>
</tr>



<tr>

<td colspan="4" align="right">
<p class="pull-right">
<br/ >
<br/ >
<br/ >
<br/ >
<br/ >

<b>Authorized Signature&nbsp;&nbsp;&nbsp;&nbsp;</b>
</p>
</td>
</tr>
</table>

							<hr />

              <hr/>
             <div class="table-responsive">
 <table  width="100%" border="1" cellspacing="1" cellpadding="0" style="font-size: 5px !mportant">
                     <tr>
                	<td colspan="4" align="center">
                    <h5> ( FACTORY  COPY ) </h5>
                    <h3>BHABANI FLY ASH BRICKS</h4>
            			<h5>At-Butupali (Padhisahi),Boudh </h5>
            <h5> Contact No :  7749002141 , 7894351251  </h5>
            </td>
                </tr>


                <tr>
                <td colspan="4" align="center">
                 <h1>MONEY RECEIPT</h1>
                </td>
                </tr>

                <tr>
                <td colspan="4">
                  <br>
                 <span > Date. <?php echo date('d-m-Y',strtotime($sales['entry_date'])); ?></span >
<br>
                </td>
                </tr>

                <tr>
                	<td colspan="4">
                    <br>
              SL NO . :<strong> <?php echo $sales['invno']; ?>  </strong><br />
                	</td>
                </tr>

            <tr>
            	<td colspan="4">
                <br>
            Name :<strong> <?php echo $sales['customername']; ?>  </strong><br />
            	</td>
            </tr>
            <tr>
              <td colspan="4">
                <br>
            Address :<strong> <?php echo $sales['address']; ?>  </strong><br />
              </td>
            </tr>
            <tr>
              <td colspan="4">
                <br>
            Total Amount :  <strong>  <?php echo $sales['debit']; ?>  (<?php echo $this->payment_model->convertNumber($sales['debit']);  ?> Only /- ) </strong><br />
            </td>
            </tr>



            <tr>

            <td colspan="4" align="right">
            <p class="pull-right">
            <br/ >
            <br/ >
            <br/ >
            <br/ >
            <br/ >
            <br/ >

            <b>Authorized Signature&nbsp;&nbsp;&nbsp;&nbsp;</b>
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
