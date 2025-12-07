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
<style>
    @media print {
      @page {
        size: A4;
        margin: 1cm;
      }
      body {
        font-family: Arial, sans-serif;
        font-size: 13px;
        color: #000 !important;
        background: #fff !important;
        margin: 0 !important;
        padding: 0 !important;
      }
      .challan-a5 {
        width: 100%;
        max-width: 700px;
        margin: 0 auto;
        background: #fff;
        border: 2px solid #333;
        padding: 18px 18px 24px 18px;
        box-sizing: border-box;
      }
      .challan-header {
        text-align: center;
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 12px;
        border-bottom: 2px solid #333;
        padding-bottom: 8px;
      }
      .challan-logo {
        max-height: 48px;
        margin-bottom: 12px;
        display: block;
        margin-left: auto;
        margin-right: auto;
        border-bottom: 1px solid #333;
        padding-bottom: 6px;
      }
      .challan-info {
        font-size: 15px;
        margin-bottom: 12px;
        border-bottom: 1px solid #333;
        padding-bottom: 8px;
      }
      .challan-info-row {
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid #333;
        padding: 6px 0;
      }
      .challan-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 18px;
      }
      .challan-table th, .challan-table td {
        border: 1.5px solid #333;
        padding: 6px 10px;
        font-size: 13px;
        text-align: center;
      }
      .challan-table th {
        background: #e0e0e0 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }
      .challan-sign {
        font-size: 13px;
        margin-top: 22px;
        display: flex;
        justify-content: space-between;
        padding-top: 12px;
      }
      .signature-pad-box, .signature-pad-buttons {
        display: none !important;
      }
      .signature-image-print {
        display: block !important;
        margin-bottom: 2px;
        max-width: 120px;
        max-height: 40px;
      }
      .digital-signature-label {
        display: none !important;
      }
  }
  .challan-a5 {
    border: 2px solid #333;
    padding: 12px;
    box-sizing: border-box;
    margin-bottom: 20px;
  }
  .challan-header {
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 8px;
    border-bottom: 2px solid #333;
    padding-bottom: 6px;
  }
  .challan-logo {
    max-height: 40px;
    margin-bottom: 8px;
    display: block;
    margin-left: auto;
    margin-right: auto;
    border-bottom: 1px solid #333;
    padding-bottom: 4px;
  }
  .challan-info {
    font-size: 13px;
    margin-bottom: 8px;
    border-bottom: 1px solid #333;
    padding-bottom: 6px;
  }
  .challan-info-row {
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid #333;
    padding: 4px 0;
  }
  .challan-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 12px;
  }
  .challan-table th, .challan-table td {
    border: 1.5px solid #333;
    padding: 4px 6px;
    font-size: 12px;
    text-align: center;
  }
  .challan-sign {
    font-size: 12px;
    margin-top: 16px;
    display: flex;
    justify-content: space-between;
    /* border-top: 2px solid #333; */
    padding-top: 8px;
  }
</style>
  <div class="challan-a5 challan-a4">
  <div style="display:flex; align-items:center; margin-bottom:8px;">
    <div style="width:80px; min-width:80px; height:60px;  display:flex; align-items:center; justify-content:center; margin-right:16px;">
      <span style="font-size:11px; color:#888;">
        <img src="<?= base_url(); ?>/assets/logo.jpg" alt="Logo" style="max-height:50px;" />
      </span>
    </div>
    <div style="flex:1; text-align:center;margin-left: -60px;">
      <div style="font-size:18px; font-weight:bold;">M/S BHABANI FLY ASH BRICKS</div>
      <div style="font-size:13px;"> At- Padhisahi, Butupali, Dist-Boudh</div>
      <div style="font-size:13px;">Contact : 7749002141 (Gagan Behera)</div>
      <div style="font-size:13px;">Mail ID: bhabaniflyashbricks3@gmail.com</div>
    </div>
  </div>
  <div style="display:flex; align-items:center; margin-bottom:10px;">
    <div style="flex:1; text-align:center;">
      <span style="font-size:20px; font-weight:bold; text-decoration:underline; letter-spacing:2px;">DELIVERY CHALLAN</span>
    </div>
  </div>
   <div style="flex:0 0 auto; text-align:right; min-width:180px;margin-bottom:10px;">
      <span style="font-size:14px; font-style:italic; text-decoration:underline;">Original (For Customer)</span>
    </div>
  <div class="challan-info">
    <table style="width:100%; border-collapse:collapse; margin-bottom:8px;">
      <tr>
        <td style="border:1.5px solid #333; padding:4px 8px; width:50%;"><strong>Challan No:</strong> <?php echo $sales['sl_no']; ?></td>
        <td style="border:1.5px solid #333; padding:4px 8px; width:50%;"><strong>Date:</strong> <?php echo date('d-m-Y',strtotime($sales['bill_date'])); ?></td>
      </tr>
      <tr>
        <td style="border:1.5px solid #333; padding:4px 8px;"><strong>Vehicle No:</strong> <?php echo $sales['vehicle_number']; ?></td>
        <td style="border:1.5px solid #333; padding:4px 8px;"><strong>Vehicle Owner:</strong> <?php echo $sales['vehicle_owner']; ?></td>
      </tr>
    </table>
    <table style="width:100%; border-collapse:collapse; margin-bottom:8px;">
      <tr>
        <th colspan="2" style="border:1.5px solid #333; background:#e0e0e0; text-align:left; padding:4px 8px;">Delivered To (Customer)</th>
      </tr>
      <tr>
        <td colspan="2" style="border-left:1.5px solid #333; border-right:1.5px solid #333; border-bottom:1.5px solid #333; border-top:none; padding:4px 8px;"><strong>Purchaser:</strong> <?php echo $sales['customername']; ?></td>
      </tr>
      <tr>
        <td colspan="2" style="border-left:1.5px solid #333; border-right:1.5px solid #333; border-bottom:1.5px solid #333; border-top:none; padding:4px 8px;"><strong>Address:</strong> <?php echo $sales['address']; ?></td>
      </tr>
      <tr>
        <td colspan="2" style="border-left:1.5px solid #333; border-right:1.5px solid #333; border-bottom:1.5px solid #333; border-top:none; padding:4px 8px;"><strong>Total Amount:</strong> <?php echo $sales['total_amount']; ?></td>
      </tr>
    </table>
  </div>
  <table class="challan-table">
    <thead>
      <tr style="background:#e0e0e0;">
        <th>SL</th>
        <th>Description</th>
        <th>Quantity</th>
        <th>Unit</th>
        <th>Rate</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody>
      <?php $sm=0; foreach ($products as $fm){ if($fm['stock']!=0){ $sm++; ?>
      <tr>
        <td><?php echo $sm;?></td>
        <td><?php echo $fm['name'];?></td>
        <td><?php echo $fm['stock'];?></td>
        <td><?php echo isset($fm['unit']) ? $fm['unit'] : 'Pcs' ?></td>
        <td><?php echo isset($fm['rate']) ? number_format($fm['rate'],2) : '' ?></td>
        <td><?php echo $fm['amount'];?></td>
      </tr>
      <?php }} ?>
    </tbody>
  </table>
  <div style="width:100%; display:flex; justify-content:flex-end; margin-bottom:8px;">
    <table style="width:45%; min-width:150px; border-collapse:collapse; border:2px solid #333; font-size:13px;">
      <tr>
        <th style="text-align:left; border:1.5px solid #333; padding:4px 6px;">Loading Charge</th>
        <td style="border:1.5px solid #333; padding:4px 6px; text-align:right;"><?php echo isset($sales['loading_charge']) ? number_format($sales['loading_charge'],2) : '0.00'; ?></td>
      </tr>
      <tr>
        <th style="text-align:left; border:1.5px solid #333; padding:4px 6px;">Transport Charge</th>
        <td style="border:1.5px solid #333; padding:4px 6px; text-align:right;"><?php echo isset($sales['transportation_charge']) ? number_format($sales['transportation_charge'],2) : '0.00'; ?></td>
      </tr>
      <tr>
        <th style="text-align:left; border:1.5px solid #333; padding:4px 6px;">Grand Total</th>
        <td style="border:1.5px solid #333; padding:4px 6px; text-align:right; font-weight:bold;"><?php echo isset($sales['grand_total']) ? number_format($sales['grand_total'],2) : number_format($sales['total_amount'],2); ?></td>
      </tr>
    </table>
  </div>
  <div style="width:70%; text-align:left; font-size:12px; margin-bottom:8px;">
    <strong>Remarks / Note:</strong>
    <ol style="margin:4px 0 0 18px; padding:0;">
      <li>Material once sold will not be taken back.</li>
      <li>This Challan shows the actual price of goods</li>
      <li>Goods supplied are in good condition at the time of delivery.</li>
    </ol>
  </div>
  <div style="height:32px;"></div>
  <div class="challan-sign" style="display:flex; justify-content:space-between; align-items:flex-end;">
    <span style="display:flex; flex-direction:column; align-items:center;">
      <div style="height:106px;"></div>
      <span>Signature of In-Charge</span>
    </span>
    <span></span>
    <span style="display:flex; flex-direction:column; align-items:center;">
      <?php if (!empty($sales['signature_image'])): ?>
        <img src="<?php echo $sales['signature_image']; ?>" class="signature-image-print" style="display:block; position:relative; left:0; top:0; width:320px; height:100px; background:none; border:none;" />
      <?php else: ?>
        <div style="margin-bottom:6px;">
          <label class="digital-signature-label" style="font-weight:bold;">Digital Signature:</label>
          <div class="signature-pad-box" style="border:1.5px solid #333; width:320px; height:100px; background:#fff; position:relative;">
            <canvas id="signature-pad" width="320" height="100" style="width:320px;height:100px;"></canvas>
          </div>
          <img id="signature-image" class="signature-image-print" style="display:none; position:relative; left:0; top:0; width:320px; height:100px;" />
          <div class="signature-pad-buttons" style="margin-top:6px;">
            <button type="button" onclick="clearSignature()" class="btn btn-secondary btn-sm">Clear</button>
            <button type="button" onclick="saveSignature()" class="btn btn-success btn-sm">Save Signature</button>
          </div>
        </div>
      <?php endif; ?>
      <span>Signature of Receiver</span>
    </span>
  </div>
</div>

<div style="page-break-before:always;"></div>

<div class="challan-a5">
  <div style="display:flex; align-items:center; margin-bottom:8px;">
    <div style="width:80px; min-width:80px; height:60px;  display:flex; align-items:center; justify-content:center; margin-right:16px;">
      <span style="font-size:11px; color:#888;">
        <img src="<?= base_url(); ?>/assets/logo.jpg" alt="Logo" style="max-height:50px;" />
      </span>
    </div>
    <div style="flex:1; text-align:center;margin-left: -60px;">
      <div style="font-size:18px; font-weight:bold;">M/S BHABANI FLY ASH BRICKS</div>
      <div style="font-size:13px;"> At- Padhisahi, Butupali, Dist-Boudh</div>
      <div style="font-size:13px;">Contact : 7749002141 (Gagan Behera)</div>
      <div style="font-size:13px;">Mail ID: bhabaniflyashbricks3@gmail.com</div>
    </div>
  </div>
  <div style="display:flex; align-items:center; margin-bottom:10px;">
    <div style="flex:1; text-align:center;">
      <span style="font-size:20px; font-weight:bold; text-decoration:underline; letter-spacing:2px;">DELIVERY CHALLAN</span>
    </div>
  </div>
   <div style="flex:0 0 auto; text-align:right; min-width:180px;margin-bottom:10px;">
      <span style="font-size:14px; font-style:italic; text-decoration:underline;">Duplicate (For Factory)</span>
    </div>
  <div class="challan-info">
    <table style="width:100%; border-collapse:collapse; margin-bottom:8px;">
      <tr>
        <td style="border:1.5px solid #333; padding:4px 8px; width:50%;"><strong>Challan No:</strong> <?php echo $sales['sl_no']; ?></td>
        <td style="border:1.5px solid #333; padding:4px 8px; width:50%;"><strong>Date:</strong> <?php echo date('d-m-Y',strtotime($sales['bill_date'])); ?></td>
      </tr>
      <tr>
        <td style="border:1.5px solid #333; padding:4px 8px;"><strong>Vehicle No:</strong> <?php echo $sales['vehicle_number']; ?></td>
        <td style="border:1.5px solid #333; padding:4px 8px;"><strong>Owner:</strong> <?php echo $sales['vehicle_owner']; ?></td>
      </tr>
    </table>
    <table style="width:100%; border-collapse:collapse; margin-bottom:8px;">
      <tr>
        <th colspan="2" style="border:1.5px solid #333; background:#e0e0e0; text-align:left; padding:4px 8px;">Delivered To (Customer)</th>
      </tr>
      <tr>
        <td colspan="2" style="border-left:1.5px solid #333; border-right:1.5px solid #333; border-bottom:1.5px solid #333; border-top:none; padding:4px 8px;"><strong>Purchaser:</strong> <?php echo $sales['customername']; ?></td>
      </tr>
      <tr>
        <td colspan="2" style="border-left:1.5px solid #333; border-right:1.5px solid #333; border-bottom:1.5px solid #333; border-top:none; padding:4px 8px;"><strong>Address:</strong> <?php echo $sales['address']; ?></td>
      </tr>
      <tr>
        <td colspan="2" style="border-left:1.5px solid #333; border-right:1.5px solid #333; border-bottom:1.5px solid #333; border-top:none; padding:4px 8px;"><strong>Total Amount:</strong> <?php echo $sales['total_amount']; ?></td>
      </tr>
    </table>
  </div>
  <table class="challan-table">
    <thead>
      <tr style="background:#e0e0e0;">
        <th>SL</th>
        <th>Description</th>
        <th>Quantity</th>
        <th>Unit</th>
        <th>Rate</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody>
      <?php $sm=0; foreach ($products as $fm){ if($fm['stock']!=0){ $sm++; ?>
      <tr>
        <td><?php echo $sm;?></td>
        <td><?php echo $fm['name'];?></td>
        <td><?php echo $fm['stock'];?></td>
        <td><?php echo isset($fm['unit']) ? $fm['unit'] : 'Pcs' ?></td>
        <td><?php echo isset($fm['rate']) ? number_format($fm['rate'],2) : '' ?></td>
        <td><?php echo $fm['amount'];?></td>
      </tr>
      <?php }} ?>
    </tbody>
  </table>
  <div style="width:100%; display:flex; justify-content:flex-end; margin-bottom:8px;">
    <table style="width:45%; min-width:150px; border-collapse:collapse; border:2px solid #333; font-size:13px;">
      <tr>
        <th style="text-align:left; border:1.5px solid #333; padding:4px 6px;">Loading Charge</th>
        <td style="border:1.5px solid #333; padding:4px 6px; text-align:right;"><?php echo isset($sales['loading_charge']) ? number_format($sales['loading_charge'],2) : '0.00'; ?></td>
      </tr>
      <tr>
        <th style="text-align:left; border:1.5px solid #333; padding:4px 6px;">Transport Charge</th>
        <td style="border:1.5px solid #333; padding:4px 6px; text-align:right;"><?php echo isset($sales['transportation_charge']) ? number_format($sales['transportation_charge'],2) : '0.00'; ?></td>
      </tr>
      <tr>
        <th style="text-align:left; border:1.5px solid #333; padding:4px 6px;">Grand Total</th>
        <td style="border:1.5px solid #333; padding:4px 6px; text-align:right; font-weight:bold;"><?php echo isset($sales['grand_total']) ? number_format($sales['grand_total'],2) : number_format($sales['total_amount'],2); ?></td>
      </tr>
    </table>
  </div>
  <div style="width:70%; text-align:left; font-size:12px; margin-bottom:8px;">
    <strong>Remarks / Note:</strong>
    <ol style="margin:4px 0 0 18px; padding:0;">
      <li>Material once sold will not be taken back.</li>
      <li>This Challan shows the actual price of goods</li>
      <li>Goods supplied are in good condition at the time of delivery.</li>
    </ol>
  </div>
  <div style="height:32px;"></div>
  <div class="challan-sign" style="display:flex; justify-content:space-between; align-items:flex-end;">
    <span style="display:flex; flex-direction:column; align-items:center;">
      <div style="height:106px;"></div>
      <span>Signature of In-Charge</span>
    </span>
    <span></span>
    <span style="display:flex; flex-direction:column; align-items:center;">
      <?php if (!empty($sales['signature_image'])): ?>
        <img src="<?php echo $sales['signature_image']; ?>" class="signature-image-print" style="display:block; position:relative; left:0; top:0; width:320px; height:100px; background:none; border:none;" />
      <?php else: ?>
        <img id="signature-image-2" class="signature-image-print" style="display:none; position:relative; left:0; top:0; width:320px; height:100px; background:none; border:none;" />
      <?php endif; ?>
      <span>Signature of Receiver</span>
    </span>
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
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>

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
  // Signature Pad logic
  var signaturePad, signaturePad2;
  window.addEventListener('DOMContentLoaded', function() {
    var canvas = document.getElementById('signature-pad');
    if (canvas) {
      signaturePad = new SignaturePad(canvas);
    }
    var canvas2 = document.getElementById('signature-pad-2');
    if (canvas2) {
      signaturePad2 = new SignaturePad(canvas2);
    }
  });
  function clearSignature() {
    if (signaturePad) signaturePad.clear();
    document.getElementById('signature-image').style.display = 'none';
  }
  function saveSignature() {
    if (signaturePad && !signaturePad.isEmpty()) {
      var dataUrl = signaturePad.toDataURL();
      var img = document.getElementById('signature-image');
      var img2 = document.getElementById('signature-image-2');
      img.src = dataUrl;
      img.style.display = 'block';
      if (img2) {
        img2.src = dataUrl;
        img2.style.display = 'block';
      }
      // AJAX: Save signature to backend
      // Get sales id from URL (e.g., .../sales/print/123)
      var urlParts = window.location.pathname.split('/');
      var salesId = null;
      for (var i = urlParts.length - 1; i >= 0; i--) {
        if (urlParts[i] && !isNaN(urlParts[i])) {
          salesId = urlParts[i];
          break;
        }
      }
      if (salesId) {
        var formData = new FormData();
        formData.append('id', salesId);
        formData.append('signature_image', dataUrl);
        fetch('<?= site_url('admin/sales/save_signature') ?>', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            alert('Signature saved successfully!');
          } else {
            alert('Failed to save signature.');
          }
        })
        .catch(() => alert('Error saving signature.'));
      }
      signaturePad.clear();
      if (signaturePad2) signaturePad2.clear();
    }
  }
  function clearSignature() {
    if (signaturePad) signaturePad.clear();
    document.getElementById('signature-image').style.display = 'none';
    var img2 = document.getElementById('signature-image-2');
    if (img2) img2.style.display = 'none';
    if (signaturePad2) signaturePad2.clear();
  }
  function saveSignature2() {
    if (signaturePad2 && !signaturePad2.isEmpty()) {
      var dataUrl = signaturePad2.toDataURL();
      var img2 = document.getElementById('signature-image-2');
      var img = document.getElementById('signature-image');
      img2.src = dataUrl;
      img2.style.display = 'block';
      if (img) {
        img.src = dataUrl;
        img.style.display = 'block';
      }
      signaturePad2.clear();
      if (signaturePad) signaturePad.clear();
    }
  }
</script>
