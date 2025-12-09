<?php /* Product Loading/Unloading Report by Labour Group and Date */ ?>
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
                            <h3>PRODUCT LOADING/UNLOADING REPORT</h3>
                        </div>
                        <div class="widget-content">
                            <div class="search_panel">
                                <h3 class="search_header">Filter Report</h3>
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
                                            <div class="span3">
                                                <div class="form-group">
                                                    <label for="labour_group_filter" class="control-label">Labour Group</label>
                                                    <select name="labour_group_filter" id="labour_group_filter" class="form-control">
                                                        <option value="">All Labour Groups</option>
                                                        <?php foreach ($labour_groups as $group): ?>
                                                            <option value="<?php echo $group['id']; ?>" <?php echo (isset($labour_group_filter) && $labour_group_filter == $group['id']) ? 'selected' : ''; ?>>
                                                                <?php echo htmlspecialchars($group['name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="span3">
                                                <br />
                                                <button type="submit" class="btn btn-primary" style="width: 100%;"><i class="icon-search"></i> Search</button>
                                                <button type="button" class="btn btn-info btn-print" style="width: 100%; margin-top: 5px;" onclick="window.print();"><i class="icon-print"></i> Print</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php if (!empty($report_data)): ?>
                                <?php
                                    $total_loading_amount = 0;
                                    $total_unloading_amount = 0;
                                    foreach ($report_data as $data) {
                                        if (!empty($data['loading'])) {
                                            foreach ($data['loading'] as $row) {
                                                $total_loading_amount += (float)$row['amount'];
                                            }
                                        }
                                        if (!empty($data['unloading'])) {
                                            foreach ($data['unloading'] as $row) {
                                                $total_unloading_amount += (float)$row['amount'];
                                            }
                                        }
                                    }
                                ?>
                                <div class="overall-summary" style="background-color: #f8f9fa; padding: 0; margin: 0; border: 2px solid #0066cc;">
                                    <h4 style="color: #0066cc; text-align: center; margin-bottom: 20px;">SUMMARY</h4>
                                    <div style="text-align:center; margin-bottom:0; font-size:1.1rem; color:#1976d2;">
                                        <strong>REPORT FOR </strong>
                                        <?php echo !empty($start_date) && !empty($end_date)
                                            ? date('d-m-Y', strtotime($start_date)) . ' to ' . date('d-m-Y', strtotime($end_date))
                                            : 'All Dates'; ?>
                                        <?php echo (isset($labour_group_filter) && !empty($labour_group_filter)) ? ' - Labour Group: ' . htmlspecialchars($labour_group_name) : ''; ?>
                                    </div>
                                    <div style="text-align:center; margin:10px 0; font-size:1.1rem; color:#333;">
                                        <strong>Total Loading Amount:</strong> ₹<?php echo number_format($total_loading_amount, 2); ?> &nbsp; | &nbsp;
                                        <strong>Total Unloading Amount:</strong> ₹<?php echo number_format($total_unloading_amount, 2); ?>
                                    </div>
                                </div>
                                <div class="report-results" style="margin-top: 20px;">
                                    <?php foreach ($report_data as $product_name => $data): ?>
                                        <div class="production-section" style="margin-bottom: 30px; border: 1px solid #ddd; padding: 15px;">
                                            <h5 style="color: #0066cc; font-weight: bold;">Product: <?php echo htmlspecialchars($product_name); ?></h5>
                                            <!-- Loading Table -->
                                            <?php if (!empty($data['loading'])): ?>
                                                <h6>Loading Details</h6>
                                                <table class="table table-striped table-bordered table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Quantity</th>
                                                            <th>Unit</th>
                                                            <th>Rate</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($data['loading'] as $row): ?>
                                                            <tr>
                                                                <td><?php echo date('d-m-Y', strtotime($row['production_date'])); ?></td>
                                                                <td><?php echo number_format($row['quantity'], 2); ?></td>
                                                                <td><?php echo htmlspecialchars($row['unit']); ?></td>
                                                                <td>₹<?php echo number_format($row['rate'], 2); ?></td>
                                                                <td>₹<?php echo number_format($row['amount'], 2); ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            <?php endif; ?>
                                            <!-- Unloading Table -->
                                            <?php if (!empty($data['unloading'])): ?>
                                                <h6>Unloading Details</h6>
                                                <table class="table table-striped table-bordered table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Material</th>
                                                            <th>Quantity</th>
                                                            <th>Unit</th>
                                                            <th>Rate</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($data['unloading'] as $row): ?>
                                                            <tr>
                                                                <td><?php echo date('d-m-Y', strtotime($row['production_date'])); ?></td>
                                                                <td><?php echo htmlspecialchars($row['material_name']); ?></td>
                                                                <td><?php echo number_format($row['qty'], 2); ?></td>
                                                                <td><?php echo htmlspecialchars($row['unit']); ?></td>
                                                                <td>₹<?php echo number_format($row['rate'], 2); ?></td>
                                                                <td>₹<?php echo number_format($row['amount'], 2); ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
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
