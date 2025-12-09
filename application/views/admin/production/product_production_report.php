<link rel="stylesheet" href="<?php echo base_url();?>assets/css/admin-sales-common.css">
<style>
  @media print {
    .navbar, .sidebar, .footer, .search_panel, .widget-header, .btn-print, .main-menu, .header, .menu, .alert, .subnavbar-inner {
        display: none !important;
    }
    body, .main, .main-inner, .container, .row, .span12, .widget, .widget-content {
        background: #fff !important;
        box-shadow: none !important;
        color: #000 !important;
    }
    .overall-summary, .report-results, .production-section {
        page-break-inside: avoid;
    }
    table {
        page-break-inside: avoid;
    }
    @page {
        margin: 20mm 10mm 20mm 10mm;
        size: auto;
        /* Hide header/footer in Chrome, Edge, Opera */
        /* These are non-standard but supported by some browsers */
        @top-center { content: none !important; }
        @bottom-center { content: none !important; }
    }
    /* Hide header/footer in Firefox */
    html, body {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    /* Hide header/footer in Safari (WebKit) */
    @media print {
        body::after, body::before {
            display: none !important;
            content: none !important;
        }
    }
}
</style>

<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget">
                        <div class="widget-header">
                            <h3>PRODUCT PRODUCTION REPORT</h3>
                        </div>
                        <div class="widget-content">
                            <!-- Enhanced Filter Panel -->
                            <div class="search_panel">
                                <h3 class="search_header">Filter Product Production Report</h3>
                                <div class="search_conent">
                                    <form method="post" class="form-horizontal">
                                        <div class="row">
                                            <div class="span2">
                                                <div class="form-group">
                                                    <label for="start_date" class="control-label">Start Date</label>
                                                    <input type="text" name="start_date" id="start_date" value="<?php echo htmlspecialchars($start_date); ?>" class="form-control" placeholder="dd-mm-yyyy">
                                                </div>
                                            </div>
                                            <div class="span2">
                                                <div class="form-group">
                                                    <label for="end_date" class="control-label">End Date</label>
                                                    <input type="text" name="end_date" id="end_date" value="<?php echo htmlspecialchars($end_date); ?>" class="form-control" placeholder="dd-mm-yyyy">
                                                </div>
                                            </div>
                                            <div class="span3">
                                                <div class="form-group">
                                                    <label for="product_filter" class="control-label">Product (Optional)</label>
                                                    <select name="product_filter" id="product_filter" class="form-control">
                                                        <option value="">All Products</option>
                                                        <?php if (!empty($products)): ?>
                                                            <?php foreach ($products as $product): ?>
                                                                <option value="<?php echo htmlspecialchars($product['name']); ?>" <?php echo ($product_filter === $product['name']) ? 'selected' : ''; ?>>
                                                                    <?php echo htmlspecialchars($product['name']); ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="span3">
                                                <br />
                                                <button type="submit" class="btn btn-primary" style="width: 48%;"><i class="icon-search"></i> Search</button>
                                                <button type="button" class="btn btn-info btn-print" style="width: 48%; margin-left: 2%;" onclick="window.print();"><i class="icon-print"></i> Print</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <?php if (!empty($report_data)): ?>
                                <!-- Overall Summary (Moved to Top) -->
                                <div class="overall-summary" style="background-color: #f8f9fa; padding: 0; margin: 0; border: 2px solid #0066cc; page-break-after: always;">
                                    <h4 style="color: #0066cc; text-align: center; margin-bottom: 20px;">PRODUCT-WISE SUMMARY</h4>
                                    <div style="text-align:center; margin-bottom:0; font-size:1.1rem; color:#1976d2;">
                                        <strong>REPORT FOR </strong>
                                        <?php echo !empty($start_date) && !empty($end_date)
                                            ? date('d-m-Y', strtotime($start_date)) . ' to ' . date('d-m-Y', strtotime($end_date))
                                            : 'All Dates'; ?>
                                    </div>
                                    <div style="overflow-x:auto; margin:0; padding:0;">
                                        <table style="width:100%; background-color:white; border-collapse:collapse; margin:0; padding:0;">
                                            <thead>
                                                <tr>
                                                    <th style="color:#28a745; text-align:center; border:1px solid #ddd; padding:10px;">Production Summary</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="text-align:center; border:1px solid #ddd; padding:10px;">
                                                        <strong>Total Quantity:</strong> <?php echo number_format($total_summary['total_quantity'], 2); ?><br>
                                                        <strong>Total Amount:</strong> ₹<?php echo number_format($total_summary['total_amount'], 2); ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="grand-summary" style="background-color: #0066cc; color: white; padding: 0; margin: 0; text-align: center; border-radius: 0;">
                                        <h4 style="margin: 0;">GRAND TOTAL AMOUNT: ₹<?php echo number_format($total_summary['total_amount'], 2); ?></h4>
                                    </div>
                                </div>
                                
                                <!-- Report Results -->
                                <div class="report-results" style="margin-top: 20px; page-break-before: always;">
                                    <h4>Product Production Details: <?php echo date('d-m-Y', strtotime($start_date)) . ' to ' . date('d-m-Y', strtotime($end_date)); ?></h4>
                                    
                                    <?php foreach ($report_data as $product_data): ?>
                                        <div class="product-section" style="margin-bottom: 30px; border: 1px solid #ddd; padding: 15px;">
                                            <!-- Product Header -->
                                            <div class="product-header" style="background-color: #f8f9fa; padding: 10px; margin-bottom: 15px;">
                                                <h5 style="margin: 0;">
                                                    <strong><?php echo htmlspecialchars($product_data['product_name']); ?></strong>
                                                </h5>
                                            </div>
                                            
                                            <!-- Production Details -->
                                            <?php if (!empty($product_data['items']) || $product_data['total_quantity'] > 0): ?>
                                                <div class="production-details" style="margin-bottom: 15px;">
                                                    <h6 style="color: #0066cc; font-weight: bold;">
                                                        PRODUCTION DETAILS
                                                        <span style="float: right;">
                                                            Total Qty: <?php echo number_format($product_data['total_quantity'], 2); ?> | 
                                                            Total: ₹<?php echo number_format($product_data['total_amount'], 2); ?>
                                                        </span>
                                                    </h6>
                                                    <?php if (!empty($product_data['items'])): ?>
                                                        <table class="table table-striped table-bordered table-condensed">
                                                            <thead>
                                                                <tr>
                                                                    <th>Sheet No.</th>
                                                                    <th>Date</th>
                                                                    <th>Quantity</th>
                                                                    <th>Rate</th>
                                                                    <th>Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($product_data['items'] as $item): ?>
                                                                    <tr>
                                                                        <td><?php echo htmlspecialchars($item['sheet_no']); ?></td>
                                                                        <td><?php echo date('d-m-Y', strtotime($item['production_date'])); ?></td>
                                                                        <td><?php echo number_format($item['quantity'], 2); ?></td>
                                                                        <td>₹<?php echo number_format($item['rate'], 2); ?></td>
                                                                        <td>₹<?php echo number_format($item['amount'], 2); ?></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                            <tfoot class="total-row" style="background-color: #f5f5f5; font-weight: bold;">
                                                                <tr>
                                                                    <td colspan="2">SUBTOTAL:</td>
                                                                    <td><?php echo number_format($product_data['total_quantity'], 2); ?></td>
                                                                    <td>-</td>
                                                                    <td>₹<?php echo number_format($product_data['total_amount'], 2); ?></td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    <?php else: ?>
                                                        <p style="text-align: center; color: #999;">No production details found</p>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <!-- Loading Details - HIDDEN -->
                                           
                                            
                                            <!-- Unloading Details - HIDDEN -->
                                         
                                            
                                       
                                            <div class="product-total" style="background-color: #e9f4ff; padding: 10px; margin-top: 10px; border-radius: 5px;">
                                                <h6 style="margin: 0; color: #0066cc; font-weight: bold;">
                                                    PRODUCT TOTAL: ₹<?php echo number_format($product_data['total_amount'], 2); ?>
                                                  
                                                </h6>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php elseif (!empty($start_date) && !empty($end_date)): ?>
                                <div class="alert alert-info" style="margin-top: 20px;">
                                    <strong>No Data Found:</strong> No production records found for the selected date range and product.
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning" style="margin-top: 20px;">
                                    <strong>Please Enter Dates:</strong> Select start and end dates to generate the report.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery UI for datepicker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/ui/jquery-ui.css" />
<script src="<?php echo base_url(); ?>assets/ui/jquery-ui.js"></script>

<script>
$(document).ready(function() {
    // Initialize datepickers
    $("#start_date, #end_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
        maxDate: 0 // Restrict to today and before
    });
    
    // Print functionality
    $('.btn-print').click(function() {
        window.print();
    });
});

// Print styles
window.addEventListener('beforeprint', function() {
    document.body.classList.add('print-mode');
});

window.addEventListener('afterprint', function() {
    document.body.classList.remove('print-mode');
});
</script>

<style>
.summary-box {
    border-radius: 5px;
    margin-bottom: 15px;
}

.product-section {
    border-radius: 5px;
}

.total-row {
    font-weight: bold;
}

.product-total h6 {
    text-align: left;
    font-size: 14px;
}
</style>
