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


<!-- Admin Sales Filter Design CSS -->
<style>
/* Enhanced Admin Sales View Styling - Aligned with Financial Report */
.admin-sales-view {
    background-color: #f8f9fa;
    min-height: 100vh;
}

/* Modern Filter Panel Styling - Professional Design */
.search_panel,
.widget {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 25px;
    border: 1px solid #e9ecef;
}

.search_header,
.widget-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    margin: 0;
    padding: 20px 25px;
    font-size: 18px;
    font-weight: 600;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-bottom: none;
}

.search_conent,
.widget-content {
    padding: 25px;
    background: #fafbfc;
    height: auto !important;
}

.widget .row {
    display: flex !important;
    align-items: flex-end !important;
    gap: 20px !important;
    flex-wrap: wrap !important;
    margin: 0 0 15px 0 !important;
}

.widget .row>div {
    margin-bottom: 0 !important;
    display: flex !important;
    flex-direction: column !important;
    min-width: 200px !important;
    flex: 1 !important;
}

.widget .form-group {
    display: flex !important;
    flex-direction: column !important;
    height: auto !important;
    justify-content: flex-start !important;
    margin-bottom: 0 !important;
}

.widget .control-label {
    margin-bottom: 8px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    color: #2c3e50 !important;
    white-space: nowrap !important;
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
}

.widget .form-control,
.widget select {
    height: 45px !important;
    padding: 12px 15px !important;
    border: 2px solid #e1e5e9 !important;
    border-radius: 8px !important;
    font-size: 14px !important;
    font-family: inherit !important;
    line-height: 1.4 !important;
    background-color: #fff !important;
    color: #333 !important;
    transition: all 0.3s ease !important;
    box-sizing: border-box !important;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
}

.widget select {
    appearance: none !important;
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="%23667eea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6,9 12,15 18,9"></polyline></svg>') !important;
    background-repeat: no-repeat !important;
    background-position: right 12px center !important;
    background-size: 12px !important;
    padding-right: 40px !important;
    cursor: pointer !important;
}

.widget .form-control:focus,
.widget select:focus {
    border-color: #667eea !important;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1), 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    outline: none !important;
    background-color: #fafbfc !important;
}

.widget .form-control:hover,
.widget select:hover {
    border-color: #c1c7cd !important;
}

.widget .btn {
    height: 45px !important;
    padding: 12px 24px !important;
    border-radius: 25px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    transition: all 0.3s ease !important;
    border: none !important;
    cursor: pointer !important;
    background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%) !important;
    color: white !important;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3) !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    min-width: 120px !important;
    text-decoration: none !important;
}

.widget .btn:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4) !important;
    background: linear-gradient(135deg, #34495e 0%, #2980b9 100%) !important;
}

/* Chosen Select Enhancement for Party Dropdown */
.widget .chosen-container {
    width: 100% !important;
    font-size: 14px !important;
    font-family: inherit !important;
}

.widget .chosen-container-single .chosen-single {
    padding: 12px 14px !important;
    border: 2px solid #e1e5e9 !important;
    border-radius: 8px !important;
    background: white !important;
    height: 45px !important;
    line-height: 21px !important;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    transition: all 0.3s ease !important;
    display: flex !important;
    align-items: center !important;
    color: #333 !important;
    font-size: 14px !important;
}

.widget .chosen-container-single .chosen-single:hover {
    border-color: #c1c7cd !important;
}

.widget .chosen-container-single .chosen-single:focus {
    border-color: #667eea !important;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1), 0 2px 4px rgba(0, 0, 0, 0.1) !important;
}

.widget .chosen-container-active.chosen-with-drop .chosen-single {
    border-color: #667eea !important;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
}

.widget .chosen-drop {
    border: 2px solid #667eea !important;
    border-radius: 8px !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

#form_table_length {
    display: none !important;
}

#form_table_info {
    display: none !important;
}

#form_table_paginate {
    display: none !important;
}
</style>

<div class="main">

    <div class="main-inner">

        <div class="container">

            <div class="row">

                <div class="span12">

                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Success!</strong> <?php echo $this->session->flashdata('msg'); ?>
                    </div>


                    <div class="widget ">
                        <div class="widget-header">
                            <h2>📊 GST Sales Account Summary</h2>
                        </div>
                        <div class="widget-content" style="height:250px;">


                            <form id="user_sch" action="<?php echo site_url("admin/sales/getsummery");?>"
                                enctype="multipart/form-data" method="post">



                                <div class="span3">
                                    <div class="form-group">

                                        <td>
                                            <label for="text1" class="control-label col-lg-4">Select Party</label>
                                            <select id="customer_id" class="chosen-select" required="required"
                                                name="customer_id">
                                                <option value="0">-Select Party-</option>
                                                <?php foreach($customer as $pr){ ?>
                                                <option <?php if($pr['id']==$customer_id){ ?> selected="selected"
                                                    <?php } ?> value="<?php echo $pr['id']; ?>">
                                                    <?php echo $pr['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </div>
                                </div>


                                <div class="span3">
                                    <div class="form-group">

                                        <td>
                                            <label for="text1" class="control-label col-lg-4">Select Branch</label>
                                            <select id="branch_id" name="branch_id">
                                                <option value="0">-All Branch-</option>
                                                <?php foreach($branch as $br){ ?>
                                                <option <?php if($br['id']==$branch_id){ ?> selected="selected"
                                                    <?php } ?> value="<?php echo $br['id']; ?>">
                                                    <?php echo $br['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </div>
                                </div>

                                <div class="span3">
                                    <div class="form-group">
                                        <label for="text1" class="control-label col-lg-4">Start Date</label>
                                        <div class="col-lg-8">
                                            <input type="text" id="start_date" value="<?php echo $start_date; ?>"
                                                name="start_date" class="form-control">
                                        </div>
                                    </div>

                                </div>




                                <div class="span3">
                                    <div class="form-group">
                                        <label for="text1" class="control-label col-lg-4">End Date</label>
                                        <div class="col-lg-8">
                                            <input type="text" id="end_date" value="<?php echo $end_date; ?>"
                                                name="end_date" class="form-control">
                                        </div>
                                    </div>

                                </div>



                                <div class="span2"><br />
                                    <input type="submit" id="tags" value="Search" class="btn btn-primary" />
                                </div>
                            </form>

                        </div>
                    </div>
                    <p class="pull-right ">

                        <input type="button" value="Print" class="btn btn-success" onclick="PrintDiv();">
                    </p>


                    <div id="print">

                        <table class="table table-striped table-bordered table-hover" border="1px">


                            <thead>


                                <tr>
                                    <th colspan="7" style="text-align:center">
                                        <h3>BHABANI FLY ASH BRICKS</h3>
                                        <h4>BUTUPALI, BOUDH</h4>
                                    </th>
                                </tr>
                                <tr>
                                    <th>SL NO.</th>
                                    <th>CUSTOMER NAME</th>
                                    <th>DATE</th>
                                    <th>PRODUCT DETAILS</th>

                                    <th>TOTAL AMOUNT</th>
                                    <th>PAID AMOUNT</th>
                                    <th>DUE</th>

                                </tr>
                            </thead>

                            <tbody>
                                <?php $sm=1;
$tc = 0;
$td = 0;
foreach ($sales as $fm){
  $tc = $tc+$fm['credit'];
  $td = $td+$fm['debit'];

  ?>
                                <tr>
                                    <td><?php echo $fm['invno'];?></td>
                                    <td><?php echo $fm['customername'];?></td>
                                    <td><?php echo date("d.m.Y",strtotime($fm['entry_date']));?></td>

                                    <td> <?php if($fm['invid']!='0'){ ?>
                                        <?php echo $this->sales_model->get_details($fm['invid']) ;?>
                                        <?php }else{ ?>
                                        &nbsp;
                                        <?php } ?>

                                    </td>


                                    <td><?php echo $fm['credit'];?></td>
                                    <td><?php echo $fm['debit'];?></td>
                                    <td><?php  if($fm['credit']!=0){ echo $fm['credit']-$fm['debit']; }else{  echo "------";   } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td>Total</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo $tc;?></td>
                                    <td><?php echo $td; ?></td>
                                    <td><?php echo $tc-$td; ?></td>
                                </tr>

                            </tbody>


                        </table>
                    </div>



                    <div id="main-table">


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
    $("#date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy'
    });

    $("#doj").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy'
    });
});
</script>