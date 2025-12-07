<link rel="stylesheet" href="<?php echo base_url();?>assets/css/sales-centralized.css">


<script>
$(document).ready(function() {
        $('#form_table').DataTable({
                responsive: true
        });
    });


</script>


<script type="text/javascript">
  function PrintDiv() {
           var divToPrint = document.getElementById('print');
           var popupWin = window.open('', '_blank', 'width=800,height=800');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
            popupWin.document.close();
                }
</script>


<!-- Removed internal CSS -->

<!-- #form_table_length{
    display: none !important;
}
#form_table_info{
    display: none !important;
}
#form_table_paginate{
    display: none !important;
} -->

<!-- Removed internal CSS -->

<div class="main">

  <div class="main-inner">

    <div class="container">

      <div class="row">

   <div class="span12">

<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> <?php echo $this->session->flashdata('msg'); ?>
</div>


<p class="pull-right ">

   						  <input type="button" value="Print" class="btn btn-success" onclick="PrintDiv();"></p>


              <div id="print">
              <div class="table-responsive">
<table class="table table-striped table-bordered table-hover sales-table" border="1px">


									<thead>


                    <tr>
                    <th colspan="7" style="text-align:center" ><h3>BHABANI FLY ASH BRICKS</h3><h4>BUTUPALI, BOUDH</h4></th>
                    </tr>

                    <tr>
                    <th colspan="7" style="text-align:center" ><h4>CUSTOMER CREDIT REPORT AS ON Dt. <?php echo date("d M Y"); ?></h4></th>
                    </tr>
                		<tr>
										<th>SL NO.</th>
                    	<th>CUSTOMER NAME</th>
										<th>Contact No</th>
                    <th>Total Amount</th>
                    <th>Given Amount</th>
                    <th>Due Amount</th>
										</tr>
									</thead>

									<tbody>
<?php $sm=1;
$sl = 0;

foreach ($all_cust as $fm){
  $sl =  $sl+1;
  ?>
<tr>
<td><?php echo $sl; ?></td>
<td><?php echo $fm['name'];?></td>
<td><?php echo $fm['contact_no'];?></td>
<td><?php echo $fm['credit'];?></td>
<td><?php echo $fm['debit'];?></td>
<td><font color="red"><strong><?php echo $fm['balance'];?></strong></font></td>
</tr>
<?php } ?>

									</tbody>


</table>
</div>
</div>


<div  id="main-table">


				<div class="pull-right">


</div>

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
          						dateFormat: 'dd-mm-yy'
          	});

          	 $( "#doj" ).datepicker({
          		changeMonth: true,
                      changeYear: true,
          						dateFormat: 'dd-mm-yy'
          	});
            });

            </script>

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
