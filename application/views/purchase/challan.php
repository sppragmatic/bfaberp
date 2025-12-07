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
<a class="btn btn-success" href="<?php echo site_url('admin/account/view_account');?>"> Back </a>
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
      <span style="font-size:20px; font-weight:bold; text-decoration:underline; letter-spacing:2px;">PURCHASE DELIVERY CHALLAN</span>
    </div>
  </div>
   <div style="flex:0 0 auto; text-align:right; min-width:180px;margin-bottom:10px;">
      <span style="font-size:14px; font-style:italic; text-decoration:underline;">Original (For Supplier)</span>
    </div>
  <div class="challan-info">
    <table style="width:100%; border-collapse:collapse; margin-bottom:8px;">
      <tr>
        <td style="border:1.5px solid #333; padding:4px 8px; width:50%;"><strong>Challan No:</strong> <?php echo isset($purchase['challan_no']) ? $purchase['challan_no'] : (isset($purchase['invno']) ? $purchase['invno'] : (isset($purchase['invid']) ? $purchase['invid'] : 'N/A')); ?></td>
        <td style="border:1.5px solid #333; padding:4px 8px; width:50%;"><strong>Date:</strong> <?php $date = isset($purchase['entry_date']) ? $purchase['entry_date'] : (isset($account['entry_date']) ? $account['entry_date'] : ''); echo $date ? date('d-m-Y', strtotime($date)) : 'N/A'; ?></td>
      </tr>
      <tr>
        <td style="border:1.5px solid #333; padding:4px 8px;"><strong>Supplier:</strong> <?php echo isset($party['name']) ? $party['name'] : (isset($purchase['supplier_name']) ? $purchase['supplier_name'] : ''); ?></td>
        <td style="border:1.5px solid #333; padding:4px 8px;"><strong>Address:</strong> <?php echo isset($party['address']) ? $party['address'] : (isset($purchase['supplier_address']) ? $purchase['supplier_address'] : ''); ?></td>
      </tr>
    </table>
   
  </div>
  
    <table class="challan-table">
        <thead>
        <tr>
            <th>SL</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Rate</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // If $items is not set, create a single row from $account and $material
        $sl = 1;
        if (isset($items) && is_array($items) && count($items) > 0) {
            foreach ($items as $item) {
                echo '<tr>';
                echo '<td>' . $sl++ . '</td>';
                echo '<td>' . htmlspecialchars($item['description']) . '</td>';
                echo '<td>' . htmlspecialchars($item['quantity']) . '</td>';
                echo '<td>' . htmlspecialchars($item['unit']) . '</td>';
                echo '<td>' . number_format($item['rate'], 2) . '</td>';
                echo '<td>' . number_format($item['amount'], 2) . '</td>';
                echo '</tr>';
            }
        } else {
            // Fallback: show account/material as a single item row
            $desc = isset($material['name']) ? $material['name'] : (isset($account['description']) ? $account['description'] : '');
            $qty = isset($account['stock']) ? $account['stock'] : '';
            $unit = isset($account['unit']) ? $account['unit'] : '';
            $rate = isset($account['amount']) && isset($account['stock']) && $account['stock'] > 0 ? ($account['amount'] / $account['stock']) : '';
            $amt = isset($account['amount']) ? $account['amount'] : '';
            echo '<tr>';
            echo '<td>1</td>';
            echo '<td>' . htmlspecialchars($desc) . '</td>';
            echo '<td>' . htmlspecialchars($qty) . '</td>';
            echo '<td>' . htmlspecialchars($unit) . '</td>';
            echo '<td>' . ($rate !== '' ? number_format($rate, 2) : '') . '</td>';
            echo '<td>' . ($amt !== '' ? number_format($amt, 2) : '') . '</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
  
  
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
      <span style="font-size:20px; font-weight:bold; text-decoration:underline; letter-spacing:2px;">PURCHASE DELIVERY CHALLAN</span>
    </div>
  </div>
   <div style="flex:0 0 auto; text-align:right; min-width:180px;margin-bottom:10px;">
      <span style="font-size:14px; font-style:italic; text-decoration:underline;">Duplicate (For Factory)</span>
    </div>
  <div class="challan-info">
    <table style="width:100%; border-collapse:collapse; margin-bottom:8px;">
      <tr>
        <td style="border:1.5px solid #333; padding:4px 8px; width:50%;"><strong>Challan No:</strong> <?php echo isset($purchase['challan_no']) ? $purchase['challan_no'] : (isset($purchase['invno']) ? $purchase['invno'] : (isset($purchase['invid']) ? $purchase['invid'] : 'N/A')); ?></td>
        <td style="border:1.5px solid #333; padding:4px 8px; width:50%;"><strong>Date:</strong> <?php $date = isset($purchase['entry_date']) ? $purchase['entry_date'] : (isset($account['entry_date']) ? $account['entry_date'] : ''); echo $date ? date('d-m-Y', strtotime($date)) : 'N/A'; ?></td>
      </tr>
      <tr>
        <td style="border:1.5px solid #333; padding:4px 8px;"><strong>Supplier:</strong> <?php echo isset($party['name']) ? $party['name'] : (isset($purchase['supplier_name']) ? $purchase['supplier_name'] : ''); ?></td>
        <td style="border:1.5px solid #333; padding:4px 8px;"><strong>Address:</strong> <?php echo isset($party['address']) ? $party['address'] : (isset($purchase['supplier_address']) ? $purchase['supplier_address'] : ''); ?></td>
      </tr>
    </table>
   
  </div>
  
    <table class="challan-table">
        <thead>
        <tr>
            <th>SL</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Rate</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // If $items is not set, create a single row from $account and $material
        $sl = 1;
        if (isset($items) && is_array($items) && count($items) > 0) {
            foreach ($items as $item) {
                echo '<tr>';
                echo '<td>' . $sl++ . '</td>';
                echo '<td>' . htmlspecialchars($item['description']) . '</td>';
                echo '<td>' . htmlspecialchars($item['quantity']) . '</td>';
                echo '<td>' . htmlspecialchars($item['unit']) . '</td>';
                echo '<td>' . number_format($item['rate'], 2) . '</td>';
                echo '<td>' . number_format($item['amount'], 2) . '</td>';
                echo '</tr>';
            }
        } else {
            // Fallback: show account/material as a single item row
            $desc = isset($material['name']) ? $material['name'] : (isset($account['description']) ? $account['description'] : '');
            $qty = isset($account['stock']) ? $account['stock'] : '';
            $unit = isset($account['unit']) ? $account['unit'] : '';
            $rate = isset($account['amount']) && isset($account['stock']) && $account['stock'] > 0 ? ($account['amount'] / $account['stock']) : '';
            $amt = isset($account['amount']) ? $account['amount'] : '';
            echo '<tr>';
            echo '<td>1</td>';
            echo '<td>' . htmlspecialchars($desc) . '</td>';
            echo '<td>' . htmlspecialchars($qty) . '</td>';
            echo '<td>' . htmlspecialchars($unit) . '</td>';
            echo '<td>' . ($rate !== '' ? number_format($rate, 2) : '') . '</td>';
            echo '<td>' . ($amt !== '' ? number_format($amt, 2) : '') . '</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
  
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
        fetch('<?= site_url('admin/account/save_signature') ?>', {
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
