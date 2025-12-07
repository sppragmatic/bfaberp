<link rel="stylesheet" href="<?php echo base_url();?>assets/css/admin-sales-common.css">
   <style>
                            @media print {
                                body.print-mode .main-inner {
                                    box-shadow: none !important;
                                    background: #fff !important;
                                }
                                .search_panel, .btn-print, .widget-header, .navbar, .sidebar, .footer, .alert, .form-horizontal, .form-group, .datepicker, .ui-datepicker, .ui-datepicker-trigger {
                                    display: none !important;
                                }
                                .main {
                                    margin: 0 !important;
                                    padding: 0 !important;
                                    background: #fff !important;
                                }
                                .overall-summary, .report-results, .production-section, .summary-box, .grand-summary {
                                    margin: 0 !important;
                                    padding: 0 !important;
                                    border-radius: 0 !important;
                                }
                                .overall-summary {
                                    display: block !important;
                                    visibility: visible !important;
                                    opacity: 1 !important;
                                    border: 2px solid #0066cc !important;
                                    background: #f8f9fa !important;
                                    color: #222 !important;
                                    page-break-after: avoid;
                                }
                                .report-results, .production-section {
                                    page-break-inside: avoid;
                                    background: #fff !important;
                                    box-shadow: none !important;
                                    border: 1px solid #ccc !important;
                                }
                                .summary-box {
                                    border: 1px solid #bbb !important;
                                    background: #fff !important;
                                    color: #222 !important;
                                }
                                .grand-summary {
                                    background: #0066cc !important;
                                    color: #fff !important;
                                }
                                h4, h5, h6 {
                                    color: #222 !important;
                                    page-break-after: avoid;
                                    margin: 0 !important;
                                    padding: 0 !important;
                                }
                                table {
                                    page-break-inside: avoid;
                                    background: #fff !important;
                                    color: #222 !important;
                                    border: 1px solid #bbb !important;
                                    margin: 0 !important;
                                    padding: 0 !important;
                                }
                                th, td {
                                    border: 1px solid #bbb !important;
                                    color: #222 !important;
                                    margin: 0 !important;
                                    padding: 2px !important;
                                }
                                .total-row {
                                    background: #e9f4ff !important;
                                    color: #222 !important;
                                    margin: 0 !important;
                                    padding: 0 !important;
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
                            <h3>PRODUCTION REPORT</h3>
                        </div>
                        <div class="widget-content">
                            <!-- Enhanced Filter Panel -->
                            <div class="search_panel">
                                <h3 class="search_header">Filter Production Report</h3>
                                <div class="search_conent">
                                    <form method="post" class="form-horizontal">
                                        <div class="row">
                                            <div class="span3">
                                                <div class="form-group">
                                                    <label for="start_date" class="control-label">Start Date</label>
                                                    <input type="text" name="start_date" id="start_date" value="<?php echo htmlspecialchars($start_date); ?>" class="form-control" placeholder="dd-mm-yyyy">
                                                </div>
                                            </div>
                                            <div class="span3">
                                                <div class="form-group">
                                                    <label for="end_date" class="control-label">End Date</label>
                                                    <input type="text" name="end_date" id="end_date" value="<?php echo htmlspecialchars($end_date); ?>" class="form-control" placeholder="dd-mm-yyyy">
                                                </div>
                                            </div>
                                            <div class="span2">
                                                <br />
                                                <button type="submit" class="btn btn-primary" style="width: 100%;"><i class="icon-search"></i> Search</button>
                                            </div>
                                            <div class="span2">
                                                <br />
                                                <button type="button" class="btn btn-info btn-print" style="width: 100%;" onclick="window.print();"><i class="icon-print"></i> Print</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <?php if (!empty($report_data)): ?>
                                <!-- Overall Summary (Moved to Top) -->
                                <div class="overall-summary" style="background-color: #f8f9fa; padding: 0; margin: 0; border: 2px solid #0066cc; page-break-after: always;">
                                    <h4 style="color: #0066cc; text-align: center; margin-bottom: 20px;">OVERALL SUMMARY</h4>
                                    <div style="text-align:center; margin-bottom:0; font-size:1.1rem; color:#1976d2;">
                                        <strong>OVERALL REPORT FOR </strong>
                                        <?php echo !empty($start_date) && !empty($end_date)
                                            ? date('d-m-Y', strtotime($start_date)) . ' to ' . date('d-m-Y', strtotime($end_date))
                                            : 'All Dates'; ?>
                                    </div>
                                    <div style="overflow-x:auto; margin:0; padding:0;">
                                        <table style="width:100%; background-color:white; border-collapse:collapse; margin:0; padding:0;">
                                            <thead>
                                                <tr>
                                                    <th style="color:#28a745; text-align:center; border:1px solid #ddd; padding:10px;">Product Details</th>
                                                    <th style="color:#fd7e14; text-align:center; border:1px solid #ddd; padding:10px;">Loading</th>
                                                    <th style="color:#6f42c1; text-align:center; border:1px solid #ddd; padding:10px;">Unloading</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="text-align:center; border:1px solid #ddd; padding:10px;">
                                                        <strong>Total Quantity:</strong> <?php echo number_format($total_summary['total_quantity'], 2); ?><br>
                                                        <strong>Total Amount:</strong> ₹<?php echo number_format($total_summary['total_amount'], 2); ?>
                                                    </td>
                                                    <td style="text-align:center; border:1px solid #ddd; padding:10px;">
                                                        <strong>Total Quantity:</strong> <?php echo number_format($total_summary['loading_total_qty'], 2); ?><br>
                                                        <strong>Total Amount:</strong> ₹<?php echo number_format($total_summary['loading_total_amount'], 2); ?>
                                                    </td>
                                                    <td style="text-align:center; border:1px solid #ddd; padding:10px;">
                                                        <strong>Total Quantity:</strong> <?php echo number_format($total_summary['unloading_total_qty'], 2); ?><br>
                                                        <strong>Total Amount:</strong> ₹<?php echo number_format($total_summary['unloading_total_amount'], 2); ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="grand-summary" style="background-color: #0066cc; color: white; padding: 0; margin: 0; text-align: center; border-radius: 0;">
                                        <h4 style="margin: 0;">GRAND TOTAL AMOUNT: ₹<?php echo number_format($total_summary['grand_total_amount'], 2); ?></h4>
                                    </div>
                                </div>
                                <!-- Report Results -->
                                <div class="report-results" style="margin-top: 20px; page-break-before: always;">
                                    <h4>Production Report: <?php echo date('d-m-Y', strtotime($start_date)) . ' to ' . date('d-m-Y', strtotime($end_date)); ?></h4>
                                    <?php foreach ($report_data as $production_data): ?>
                                        <div class="production-section" style="margin-bottom: 30px; border: 1px solid #ddd; padding: 15px;">
                                            <!-- Production Header -->
                                            <div class="production-header" style="background-color: #f8f9fa; padding: 10px; margin-bottom: 15px;">
                                                <h5 style="margin: 0;">
                                                    Sheet No: <?php echo htmlspecialchars($production_data['production']['sheet_no']); ?> | 
                                                    Date: <?php echo date('d-m-Y', strtotime($production_data['production']['date'])); ?>
                                                    | Products Amount: ₹<?php echo number_format($production_data['production']['prod_amount'] ?? 0, 2); ?>
                                                    <?php if (!empty($production_data['production']['grand_total'])): ?>
                                                        | Grand Total: ₹<?php echo number_format($production_data['production']['grand_total'], 2); ?>
                                                    <?php endif; ?>
                                                </h5>
                                            </div>
                                            
                                            <!-- Product Details Table -->
                                            <?php if (!empty($production_data['items'])): ?>
                                                <div class="product-section">
                                                    <h6 style="color: #0066cc; font-weight: bold;">
                                                        PRODUCT DETAILS 
                                                        <span style="float: right;">
                                                            Total Qty: <?php echo number_format($production_data['product_total_qty'], 2); ?> | 
                                                            Total: ₹<?php echo number_format($production_data['product_total_amount'], 2); ?>
                                                        </span>
                                                    </h6>
                                                    <table class="table table-striped table-bordered table-condensed">
                                                        <thead>
                                                            <tr>
                                                                <th>Product Name</th>
                                                                <th>Quantity</th>
                                                                <th>Rate</th>
                                                                <th>Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($production_data['items'] as $item): ?>
                                                                <?php if ((float)$item['quantity'] > 0): ?>
                                                                    <tr>
                                                                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                                                        <td><?php echo number_format($item['quantity'], 2); ?></td>
                                                                        <td>₹<?php echo number_format($item['rate'], 2); ?></td>
                                                                        <td>₹<?php echo number_format($item['amount'], 2); ?></td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                        <tfoot class="total-row" style="background-color: #f5f5f5; font-weight: bold;">
                                                            <tr>
                                                                <td>TOTAL:</td>
                                                                <td><?php echo number_format($production_data['product_total_qty'], 2); ?></td>
                                                                <td>-</td>
                                                                <td>₹<?php echo number_format($production_data['product_total_amount'], 2); ?></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            <?php endif; ?>
                                            
                            <!-- Loading Section -->
                            <?php if (!empty($production_data['loading_items'])): ?>
                                <div class="loading-section" style="margin-top: 15px;">
                                    <h6 style="color: #0066cc; font-weight: bold;">
                                        BRICKS LOADING DETAILS 
                                        <span style="float: right;">
                                            Total Qty: <?php echo number_format($production_data['loading_total_qty'] ?? 0, 2); ?> | 
                                            Total: ₹<?php echo number_format($production_data['loading_total_amount'] ?? 0, 2); ?>
                                        </span>
                                    </h6>
                                    <table class="table table-striped table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>                                               
                                                <th>Quantity</th>
                                                 <th>Unit</th>
                                                <th>Rate</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($production_data['loading_items'] as $loading): ?>
                                                <?php if ((float)($loading['quantity'] ?? 0) > 0): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($loading['product_name'] ?? 'N/A'); ?></td>                                                       
                                                        <td><?php echo number_format($loading['quantity'] ?? 0, 2); ?></td>
                                                         <td><?php echo htmlspecialchars($loading['unit'] ?? ''); ?></td>
                                                        <td>₹<?php echo number_format($loading['rate'] ?? 0, 2); ?></td>
                                                        <td>₹<?php echo number_format($loading['amount'] ?? 0, 2); ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot class="total-row" style="background-color: #f5f5f5; font-weight: bold;">
                                            <tr>
                                                <td>TOTAL:</td>
                                               
                                                <td><?php echo number_format($production_data['loading_total_qty'] ?? 0, 2); ?></td>
                                                 <td></td>
                                                <td>-</td>
                                                <td>₹<?php echo number_format($production_data['loading_total_amount'] ?? 0, 2); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            <?php endif; ?>

                            <!-- Unloading Section -->
                            <?php if (!empty($production_data['unloading_items'])): ?>
                                <div class="unloading-section" style="margin-top: 15px;">
                                    <h6 style="color: #0066cc; font-weight: bold;">
                                        FLY ASH UNLOADING DETAILS 
                                        <span style="float: right;">
                                            Total Qty: <?php echo number_format($production_data['unloading_total_qty'] ?? 0, 2); ?> | 
                                            Total: ₹<?php echo number_format($production_data['unloading_total_amount'] ?? 0, 2); ?>
                                        </span>
                                    </h6>
                                    <table class="table table-striped table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Material</th>
                                                <th>Labour Group</th>
                                               
                                                <th>Quantity</th>
                                                 <th>Unit</th>
                                                <th>Rate</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($production_data['unloading_items'] as $unloading): ?>
                                                <?php if ((float)($unloading['qty'] ?? 0) > 0): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($unloading['material_name'] ?? 'N/A'); ?></td>
                                                        <td><?php echo htmlspecialchars($unloading['labour_group_name'] ?? 'N/A'); ?></td>
                                                     
                                                        <td><?php echo number_format($unloading['qty'] ?? 0, 2); ?></td>
                                                           <td><?php echo htmlspecialchars($unloading['unit'] ?? ''); ?></td>
                                                        <td>₹<?php echo number_format($unloading['rate'] ?? 0, 2); ?></td>
                                                        <td>₹<?php echo number_format($unloading['amount'] ?? 0, 2); ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot class="total-row" style="background-color: #f5f5f5; font-weight: bold;">
                                            <tr>
                                                <td colspan="3">TOTAL:</td>
                                                <td><?php echo number_format($production_data['unloading_total_qty'] ?? 0, 2); ?></td>
                                                <td>-</td>
                                                <td>₹<?php echo number_format($production_data['unloading_total_amount'] ?? 0, 2); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Production Day Total -->
                            <?php 
                                $product_amount = $production_data['product_total_amount'] ?? 0;
                                $loading_amount = $production_data['loading_total_amount'] ?? 0;
                                $unloading_amount = $production_data['unloading_total_amount'] ?? 0;
                                $day_total = $product_amount + $loading_amount + $unloading_amount; 
                            ?>
                            <div class="day-total" style="background-color: #e9f4ff; padding: 10px; margin-top: 10px; border-radius: 5px;">
                                <h6 style="margin: 0; color: #0066cc; font-weight: bold;">
                                    DAY TOTAL: ₹<?php echo number_format($day_total, 2); ?>
                                    <span style="font-size: 12px; font-weight: normal; margin-left: 15px;">
                                        (Products: ₹<?php echo number_format($product_amount, 2); ?> + 
                                        Loading: ₹<?php echo number_format($loading_amount, 2); ?> + 
                                        Unloading: ₹<?php echo number_format($unloading_amount, 2); ?>)
                                    </span>
                                </h6>
                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    
                                    <!-- Overall Summary -->
                                  
                                </div>
                            <?php elseif (!empty($start_date) && !empty($end_date)): ?>
                                <div class="alert alert-info" style="margin-top: 20px;">
                                    <strong>No Data Found:</strong> No production records found for the selected date range.
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
@media print {
    /* Hide everything except heading and production list */
    .form-horizontal, .btn, .btn-print {
        display: none !important;
    }
    
    
    /* Hide navigation and other page elements */
    .navbar, .subnavbar, .main-inner .container .span12 .widget .widget-content > form {
        display: none !important;
    }
    
    /* Show only the main heading */
    .widget-header h3 {
        text-align: center;
        font-size: 18px;
        margin-bottom: 20px;
        color: #000 !important;
    }
    
    /* Show only the report results heading */
    .report-results h4 {
        text-align: center;
        font-size: 16px;
        margin-bottom: 15px;
        color: #000 !important;
    }
    
    /* Style production sections for print */
    .production-section {
        page-break-inside: avoid;
        margin-bottom: 20px !important;
        border: 1px solid #000 !important;
        padding: 10px !important;
    }
    
    /* Production header styling */
    .production-header {
        background-color: #f0f0f0 !important;
        padding: 8px !important;
        margin-bottom: 10px !important;
        border: 1px solid #000 !important;
        -webkit-print-color-adjust: exact;
    }
    
    /* Table styling for print */
    .table {
        font-size: 10px !important;
        border-collapse: collapse !important;
    }
    
    .table th, .table td {
        border: 1px solid #000 !important;
        padding: 4px !important;
    }
    
    /* Total rows styling */
    .total-row {
        background-color: #e0e0e0 !important;
        font-weight: bold !important;
        -webkit-print-color-adjust: exact;
    }
    
    /* Day total styling */
    .day-total {
        background-color: #d0d0d0 !important;
        padding: 8px !important;
        text-align: center !important;
        font-weight: bold !important;
        border: 1px solid #000 !important;
        -webkit-print-color-adjust: exact;
    }
    
    /* Remove page margins and set print layout */
    @page {
        margin: 0.5in;
        size: A4;
    }
    
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        color: #000 !important;
        background: white !important;
    }
    
    /* Section headers */
    h5, h6 {
        font-size: 12px !important;
        margin: 5px 0 !important;
        color: #000 !important;
    }
}

.summary-box {
    border-radius: 5px;
    margin-bottom: 15px;
}

.production-section {
    border-radius: 5px;
}

.total-row {
    font-weight: bold;
}

.day-total h6 {
    text-align: center;
    font-size: 16px;
}
</style>