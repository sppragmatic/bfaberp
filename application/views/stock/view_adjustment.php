<link rel="stylesheet" href="<?php echo base_url();?>assets/css/admin-sales-common.css">

<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="search_panel">
                        <h3 class="search_header">STOCK ADJUSTMENT DETAILS</h3>
                        <div class="search_conent">
                            <form>
                                <div class="row">
                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="start_date" class="control-label">Start Date</label>
                                            <input type="text" id="start_date" name="start_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="form-group">
                                            <label for="end_date" class="control-label">End Date</label>
                                            <input type="text" id="end_date" name="end_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="span2"><br />
                                        <input type="submit" value="Search" class="btn btn-primary" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
<link rel="stylesheet" href="<?php echo base_url()?>assets/ui/jquery-ui.css" />
<script src="<?php echo base_url()?>assets/ui/jquery-ui.js"></script>
<script>
$(function() {
    $("#start_date, #end_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy'
    });
});
</script>

                    <div class="widget">
                        <div class="widget-content">
                            <div class="pull-left">
                                <h2>Stock Adjustment Details</h2>
                            </div>
                            <div class="pull-right no-print">
                                <a href="<?php echo site_url('admin/stock/adjustment'); ?>" class="btn">
                                    <i class="icon-arrow-left"></i> Back to List
                                </a>
                                <button onclick="window.print()" class="btn btn-info">
                                    <i class="icon-print"></i> Print
                                </button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <?php if (!empty($adjustment)): ?>
                        <div class="widget">
                            <div class="widget-content">
                                <div style="text-align: center; margin-bottom: 30px;">
                                    <h3>Stock Adjustment #<?php echo str_pad($adjustment['id'], 6, '0', STR_PAD_LEFT); ?></h3>
                                    <p style="color: #666;">Date: <?php echo date('d F Y', strtotime($adjustment['adjustment_date'])); ?></p>
                                </div>

                                <div class="row-fluid">
                                    <div class="span6">
                                        <h4 style="color: #2c5aa0; border-bottom: 2px solid #2c5aa0; padding-bottom: 5px; margin-bottom: 15px;">General Information</h4>
                                        <table class="table table-bordered info-table">
                                            <tr>
                                                <td class="label">Adjustment Date:</td>
                                                <td class="value"><?php echo date('d/m/Y', strtotime($adjustment['adjustment_date'])); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="label">Product:</td>
                                                <td class="value">
                                                    <?php echo htmlspecialchars($adjustment['product_name']); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label">Adjustment Type:</td>
                                                <td class="value">
                                                    <?php if ($adjustment['adjustment_type'] == 'increase'): ?>
                                                        <span style="color: green; font-weight: bold;">INCREASE</span>
                                                    <?php else: ?>
                                                        <span style="color: red; font-weight: bold;">DECREASE</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="span6">
                                        <h4 style="color: #2c5aa0; border-bottom: 2px solid #2c5aa0; padding-bottom: 5px; margin-bottom: 15px;">Stock Information</h4>
                                        <table class="table table-bordered info-table">
                                            <tr>
                                                <td class="label">Adjustment Quantity:</td>
                                                <td class="value">
                                                    <strong style="color: <?php echo ($adjustment['adjustment_type'] == 'increase') ? 'green' : 'red'; ?>;">
                                                        <?php echo number_format(abs($adjustment['quantity']), 2); ?>
                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label">Previous Stock:</td>
                                                <td class="value" style="color: blue; font-weight: bold;">
                                                    <?php echo number_format($adjustment['previous_stock'], 2); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label">New Stock:</td>
                                                <td class="value" style="color: green; font-weight: bold;">
                                                    <?php echo number_format($adjustment['new_stock'], 2); ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="row-fluid">
                                    <div class="span12">
                                        <h4 style="color: #2c5aa0; border-bottom: 2px solid #2c5aa0; padding-bottom: 5px; margin-bottom: 15px;">Remarks</h4>
                                        <div style="background-color: #f9f9f9; padding: 15px; border-left: 4px solid #ccc; margin-bottom: 20px;">
                                            <?php echo nl2br(htmlspecialchars($adjustment['remarks'])); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row-fluid">
                                    <div class="span6">
                                        <h4 style="color: #2c5aa0; border-bottom: 2px solid #2c5aa0; padding-bottom: 5px; margin-bottom: 15px;">Audit Information</h4>
                                        <table class="table table-bordered info-table">
                                            <tr>
                                                <td class="label">Created By:</td>
                                                <td class="value"><?php echo htmlspecialchars($adjustment['created_by_name'] ?? 'N/A'); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="label">Created At:</td>
                                                <td class="value"><?php echo date('d/m/Y H:i:s', strtotime($adjustment['created_at'])); ?></td>
                                            </tr>
                                            <?php if (!empty($adjustment['updated_at'])): ?>
                                            <tr>
                                                <td class="label">Last Modified:</td>
                                                <td class="value"><?php echo date('d/m/Y H:i:s', strtotime($adjustment['updated_at'])); ?></td>
                                            </tr>
                                            <?php endif; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="alert alert-warning">
                            <h4>Adjustment Not Found</h4>
                            <p>The requested stock adjustment could not be found or may have been deleted.</p>
                            <a href="<?php echo site_url('admin/stock/adjustment'); ?>" class="btn btn-primary">
                                Return to Adjustments List
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>