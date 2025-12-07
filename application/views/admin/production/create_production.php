<?php
/**
 * Modern Create Production View
 * 
 * Professional design with enhanced UI/UX including:
 * - Gradient backgrounds and modern card layouts
 * - Interactive form elements with validation
 * - Real-time calculation displays
 * - Enhanced visual feedback and animations
 * - Responsive design for all devices
 */
?>

<div class="main"
    style="min-height: 100vh; padding: 30px 0;">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">

                    <!-- Professional Page Header -->
                    <div class="page-header-card"
                        style="background: rgba(255,255,255,0.95); border-radius: 15px; padding: 25px; margin-bottom: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); backdrop-filter: blur(10px);">
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                            <div>
                                <h1
                                    style="color: #2c3e50; margin: 0 0 5px 0; font-size: 28px; font-weight: bold; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <i class="icon-plus-circle"
                                        style="color: #3498db; margin-right: 12px; font-size: 32px;"></i>
                                    Create New Production
                                </h1>
                                <p style="color: #7f8c8d; margin: 0; font-size: 16px;">
                                    Add new production record with product details and loading/unloading information
                                </p>
                            </div>
                            <div class="action-buttons" style="display: flex; gap: 15px; align-items: center;">
                                <a href="<?= site_url('admin/production') ?>" class="btn-primary-gradient">
                                    <i class="icon-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Validation Errors -->
                    <?php if (validation_errors()): ?>
                    <div class="alert-error-modern">
                        <div class="alert-icon">
                            <i class="icon-exclamation-triangle"></i>
                        </div>
                        <div class="alert-content">
                            <strong>Please correct the following errors:</strong>
                            <?php echo validation_errors(); ?>
                        </div>
                        <button class="alert-close" onclick="this.parentElement.style.display='none'">
                            <i class="icon-remove"></i>
                        </button>
                    </div>
                    <?php endif; ?>

                    <!-- Production Form -->
                    <form action="<?php echo site_url('admin/production/create_production') ?>" id="production-form"
                        method="post" class="modern-form">

                        <div class="row">
                            <!-- Combined Production Information & Summary Panel -->
                            <div class="span12">
                                <div class="data-table-container production-info-summary-panel" style="margin-bottom: 25px;">
                                    <div class="table-header">
                                        <h3>
                                            <i class="icon-info-circle"></i>
                                            Production Information & Summary
                                        </h3>
                                    </div>

                                    <div style="padding: 20px;">
                                        <div class="row">
                                            <!-- Production Information Form -->
                                            <div class="span6">
                                                <h4 style="color: #2c3e50; font-weight: 600;">
                                                    <i class="icon-file-text"></i> Production Details
                                                </h4>
                                                <div class="production-form-container">
                                                    <div class="form-group-modern">
                                                        <label class="form-label-modern">
                                                            <i class="icon-file-text"></i>
                                                            Production Sheet Number
                                                        </label>
                                                        <div class="input-wrapper">
                                                            <input type="text" value="<?php echo $trans_no; ?>" readonly="readonly"
                                                                name="production[sheet_no]"
                                                                class="form-control-modern readonly-input">
                                                            <i class="icon-lock input-icon"></i>
                                                        </div>
                                                    </div>

                                                    <div class="form-group-modern">
                                                        <label class="form-label-modern">
                                                            <i class="icon-calendar"></i>
                                                            Production Date
                                                        </label>
                                                        <div class="input-wrapper">
                                                            <input type="text" value="<?php echo $date; ?>" id="production_date"
                                                                name="production[date]" class="form-control-modern" required>
                                                            <i class="icon-calendar-o input-icon"></i>
                                                        </div>
                                                    </div>

                                                    <div class="form-group-modern grand-total-group">
                                                        <label class="form-label-modern">
                                                            <i class="icon-calculator"></i>
                                                            Grand Total Amount
                                                        </label>
                                                        <div class="grand-total-display">
                                                            <input type="text" id="grand_total" readonly="readonly"
                                                                name="production[grand_total]" value="₹0.00"
                                                                class="grand-total-input">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Production Summary Stats -->
                                            <div class="span6">
                                                <h4 style="color: #2c3e50; font-weight: 600;">
                                                    <i class="icon-bar-chart"></i> Summary Statistics
                                                </h4>
                                                <!-- Products Total -->
                                                <div class="summary-stat-item" style="margin-bottom: 15px;">
                                                    <div class="stat-card stat-card-blue" style="margin-bottom: 0;">
                                                        <div class="stat-icon">
                                                            <i class="icon-cubes"></i>
                                                        </div>
                                                        <div class="stat-details">
                                                            <h3 id="summary_products_total">₹0.00</h3>
                                                            <p>Products Total</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Transportation Total -->
                                                <div class="summary-stat-item" style="margin-bottom: 15px;">
                                                    <div class="stat-card stat-card-green" style="margin-bottom: 0;">
                                                        <div class="stat-icon">
                                                            <i class="icon-truck"></i>
                                                        </div>
                                                        <div class="stat-details">
                                                            <h3 id="summary_loading_total">₹0.00</h3>
                                                            <p>Transportation Total</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Grand Total -->
                                                <div class="summary-stat-item">
                                                    <div class="stat-card stat-card-purple" style="margin-bottom: 0;">
                                                        <div class="stat-icon">
                                                            <i class="icon-money"></i>
                                                        </div>
                                                        <div class="stat-details">
                                                            <h3 id="summary_grand_total">₹0.00</h3>
                                                            <p>Grand Total Amount</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Details Section -->
                        <div class="row">
                            <div class="span12">
                                <div class="data-table-container">
                                    <div class="table-header">
                                        <div>
                                            <h3>
                                                <i class="icon-cubes"></i>
                                                Product Details
                                            </h3>
                                        </div>
                                        <div class="table-controls">
                                            <span class="section-total-label">
                                                Products Total: <strong id="product_total_display">₹0.00</strong>
                                            </span>
                                        </div>
                                    </div>

                                    <div style="padding: 0;">
                                        <table class="table-modern" id="products_table">
                                            <thead>
                                                <tr>
                                                    <th width="35%">
                                                        <div class="th-content">
                                                            <i class="icon-tag"></i>
                                                            <span>Product Name</span>
                                                        </div>
                                                    </th>
                                                    <th width="20%">
                                                        <div class="th-content">
                                                            <i class="icon-sort-numeric-asc"></i>
                                                            <span>Quantity</span>
                                                        </div>
                                                    </th>
                                                    <th width="20%">
                                                        <div class="th-content">
                                                            <i class="icon-money"></i>
                                                            <span>Rate (₹)</span>
                                                        </div>
                                                    </th>
                                                    <th width="25%">
                                                        <div class="th-content">
                                                            <i class="icon-calculator"></i>
                                                            <span>Amount (₹)</span>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php foreach ($products as $product): ?>
                                                <tr class="table-row product-row"
                                                    data-product-id="<?php echo $product['id']; ?>">
                                                    <td class="product-name">
                                                        <div class="product-info">
                                                            <i class="icon-cube product-icon"></i>
                                                            <span><?php echo htmlspecialchars($product['name']); ?></span>
                                                        </div>
                                                    </td>
                                                    <td class="quantity-cell">
                                                        <div class="input-group">
                                                            <input type="number"
                                                                name="prod[<?php echo $product['id']; ?>][quantity]"
                                                                class="table-input quantity-input" placeholder="0"
                                                                min="0" step="0.01">
                                                            <span class="input-unit">units</span>
                                                        </div>
                                                    </td>
                                                    <td class="rate-cell">
                                                        <div class="input-group">
                                                            <span class="input-prefix">₹</span>
                                                            <input type="number"
                                                                name="prod[<?php echo $product['id']; ?>][rate]"
                                                                class="table-input rate-input" placeholder="0.00"
                                                                min="0" step="0.01">
                                                        </div>
                                                    </td>
                                                    <td class="amount-cell">
                                                        <div class="amount-display">
                                                            <span class="currency-symbol">₹</span>
                                                            <input type="text"
                                                                name="prod[<?php echo $product['id']; ?>][amount]"
                                                                class="amount-input" readonly value="0.00">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>

                                            <tfoot>
                                                <tr class="total-row">
                                                    <td colspan="3" class="total-label-cell">
                                                        <strong>
                                                            <i class="icon-sigma"></i>
                                                            PRODUCTS TOTAL:
                                                        </strong>
                                                    </td>
                                                    <td class="total-amount-cell">
                                                        <div class="total-display">
                                                            <span class="currency-symbol">₹</span>
                                                            <input type="text" id="product_total" name="product_total"
                                                                class="total-input" readonly value="0.00">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
             
                <!-- Loading Section -->
                <div class="row">
                    <div class="span12">
                        <div class="data-table-container">
                            <div class="table-header">
                                <div>
                                    <h3>
                                        <i class="icon-upload"></i>
                                        Bricks Loading Details
                                    </h3>
                                </div>
                                <div class="table-controls">
                                    <span class="section-total-label">
                                        Loading Total: <strong id="loading_only_total_display">₹0.00</strong>
                                    </span>
                                </div>
                            </div>

                            <div style="padding: 0;">
                                <table class="table-modern" id="loading_items_table">
                                    <thead>
                                        <tr>
                                            <th width="80px">
                                                <div class="th-content">
                                                    <i class="icon-tag"></i>
                                                    <span>Product Name</span>
                                                </div>
                                            </th>
                                            <th width="100px">
                                                <div class="th-content">
                                                    <i class="icon-users"></i>
                                                    <span>Labour Group</span>
                                                </div>
                                            </th>
                                            <th width="80px">
                                                <div class="th-content">
                                                    <i class="icon-sort-numeric-asc"></i>
                                                    <span>Quantity</span>
                                                </div>
                                            </th>
                                          
                                            <th width="30px">
                                                <div class="th-content">
                                                   
                                                    <span>Unit</span>
                                                </div>
                                            </th>
                                            <th width="20px">
                                                <div class="th-content">
                                                    <i class="icon-money"></i>
                                                    <span>Rate (₹)</span>
                                                </div>
                                            </th>
                                            <th width="16%">
                                                <div class="th-content">
                                                    <i class="icon-calculator"></i>
                                                    <span>Amount (₹)</span>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($products as $product): ?>
                                        <tr class="table-row loading-row"
                                            data-product-id="<?php echo $product['id']; ?>">
                                            <td class="product-name">
                                                <div class="product-info">
                                                    <i class="icon-cube product-icon"></i>
                                                    <span><?php echo htmlspecialchars($product['name']); ?></span>
                                                </div>
                                            </td>
                                            <td class="labour-cell">
                                                <select name="loading[<?php echo $product['id']; ?>][labour_group_id]" class="table-input labour-select">
                                                    <option value="">Select Labour Group</option>
                                                    <?php if(isset($labour_groups) && !empty($labour_groups)): ?>
                                                        <?php foreach($labour_groups as $labour_group): ?>
                                                            <option value="<?php echo $labour_group['id']; ?>">
                                                                <?php echo htmlspecialchars($labour_group['name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </td>
                                            <td class="quantity-cell">
                                                <div class="input-group">
                                                    <input type="number"
                                                        name="loading[<?php echo $product['id']; ?>][quantity]"
                                                        class="table-input loading-quantity" placeholder="0" min="0"
                                                        step="0.01">
                                                </div>
                                            </td>
                                               <td class="unit-cell">
                                                <div class="input-group">
                                                    <input type="text"
                                                        name="loading[<?php echo $product['id']; ?>][unit]"
                                                        class="table-input loading-unit" placeholder="Enter unit">
                                                </div>
                                            </td>
                                            <td class="rate-cell">
                                                <div class="input-group">
                                                    <span class="input-prefix">₹</span>
                                                    <input type="number"
                                                        name="loading[<?php echo $product['id']; ?>][rate]"
                                                        class="table-input loading-rate" placeholder="0.00" min="0"
                                                        step="0.01">
                                                </div>
                                            </td>
                                            <td class="amount-cell">
                                                <div class="amount-display">
                                                    <span class="currency-symbol">₹</span>
                                                    <input type="text"
                                                        name="loading[<?php echo $product['id']; ?>][amount]"
                                                        class="amount-input loading-amount" readonly value="0.00">
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>

                                    <tfoot>
                                        <tr class="total-row">
                                            <td colspan="5" class="total-label-cell">
                                                <strong>
                                                    <i class="icon-sigma"></i>
                                                    LOADING TOTAL:
                                                </strong>
                                            </td>
                                            <td class="total-amount-cell">
                                                <div class="total-display">
                                                    <span class="currency-symbol">₹</span>
                                                    <input type="text" id="loading_total_input"
                                                        name="production[loading_amount]" class="total-input" readonly
                                                        value="0.00">
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Unloading Section -->
                <div class="row">
                    <div class="span12">
                        <div class="data-table-container">
                            <div class="table-header">
                                <div>
                                    <h3>
                                        <i class="icon-download"></i>
                                        Fly Ash Unloading Details
                                    </h3>
                                </div>
                                <div class="table-controls">
                                    <button type="button" class="btn btn-success btn-add-row" id="add_unloading_row">
                                        <i class="icon-plus"></i> Add Row
                                    </button>
                                    <span class="section-total-label">
                                        Unloading Total: <strong id="unloading_only_total_display">₹0.00</strong>
                                    </span>
                                </div>
                            </div>

                            <div style="padding: 0;">
                                <table class="table-modern" id="unloading_items_table">
                                    <thead>
                                        <tr>
                                            <th width="80px">
                                                <div class="th-content">
                                                    <i class="icon-th-list"></i>
                                                    <span>Material</span>
                                                </div>
                                            </th>
                                            <th width="100px">
                                                <div class="th-content">
                                                    <i class="icon-users"></i>
                                                    <span>Labour Group</span>
                                                </div>
                                            </th>
                                            <th width="60px">
                                                <div class="th-content">
                                                    <i class="icon-sort-numeric-asc"></i>
                                                    <span>Quantity</span>
                                                </div>
                                            </th>
                                            <th width="30">
                                                <div class="th-content">
                                                    <i class="icon-sort-numeric-asc"></i>
                                                    <span>Unit</span>
                                                </div>
                                            </th>
                                            <th width="15%">
                                                <div class="th-content">
                                                    <i class="icon-money"></i>
                                                    <span>Rate (₹)</span>
                                                </div>
                                            </th>
                                            <th width="18%">
                                                <div class="th-content">
                                                    <i class="icon-calculator"></i>
                                                    <span>Amount (₹)</span>
                                                </div>
                                            </th>
                                            <th width="8%">
                                                <div class="th-content">
                                                    <i class="icon-cogs"></i>
                                                    <span>Action</span>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody id="unloading_items_tbody">
                                        <tr class="table-row unloading-row" data-row="0">
                                            <td class="material-cell">
                                                <select name="unloading[0][material_id]" class="table-input material-select" >
                                                    <option value="">Select Material</option>
                                                    <?php if(isset($materials) && !empty($materials)): ?>
                                                        <?php foreach($materials as $material): ?>
                                                            <option value="<?php echo $material['id']; ?>">
                                                                <?php echo htmlspecialchars($material['name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </td>
                                            <td class="labour-cell">
                                                <select name="unloading[0][labour_group_id]" class="table-input labour-select" >
                                                    <option value="">Select Labour Group</option>
                                                    <?php if(isset($labour_groups) && !empty($labour_groups)): ?>
                                                        <?php foreach($labour_groups as $labour_group): ?>
                                                            <option value="<?php echo $labour_group['id']; ?>">
                                                                <?php echo htmlspecialchars($labour_group['name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </td>
                                            <td class="quantity-cell">
                                                <div class="input-group">
                                                    <input type="number" name="unloading[0][qty]" 
                                                           class="table-input unloading-quantity" 
                                                           placeholder="0" min="0" step="0.01">
                                                    
                                                </div>
                                            </td>

                                              <td class="unit-cell">
                                                <div class="input-group">
                                                    <input type="text" name="unloading[0][unit]" 
                                                           class="table-input unloading-unit" 
                                                           placeholder="Unit">
                                                   
                                                </div>
                                            </td>
                                            <td class="rate-cell">
                                                <div class="input-group">
                                                    <span class="input-prefix">₹</span>
                                                    <input type="number" name="unloading[0][rate]" 
                                                           class="table-input unloading-rate" 
                                                           placeholder="0.00" min="0" step="0.01">
                                                </div>
                                            </td>
                                            <td class="amount-cell">
                                                <div class="amount-display">
                                                    <span class="currency-symbol">₹</span>
                                                    <input type="text" name="unloading[0][amount]" 
                                                           class="amount-input unloading-amount" readonly value="0.00">
                                                </div>
                                            </td>
                                            <td class="action-cell">
                                                <button type="button" class="btn btn-danger btn-small remove-unloading-row" disabled>
                                                    <i class="icon-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>

                                    <tfoot>
                                        <tr class="total-row">
                                            <td colspan="6" class="total-label-cell">
                                                <strong>
                                                    <i class="icon-sigma"></i>
                                                    UNLOADING TOTAL:
                                                </strong>
                                            </td>
                                            <td class="total-amount-cell">
                                                <div class="total-display">
                                                    <span class="currency-symbol">₹</span>
                                                    <input type="text" id="unloading_total_input" name="production[unloading_amount]" 
                                                           class="total-input" readonly value="0.00">
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Combined Loading/Unloading Total Section -->
                <div class="row">
                    <div class="span12">
                        <div class="data-table-container">
                            <div class="table-header">
                                <div>
                                    <h3>
                                        <i class="icon-sigma"></i>
                                        Transportation Summary
                                    </h3>
                                </div>
                                <div class="table-controls">
                                    <span class="section-total-label">
                                        Grand L/U Total: <strong id="loading_total_display">₹0.00</strong>
                                    </span>
                                </div>
                            </div>

                            <!-- Loading/Unloading Total -->
                            <div class="loading-total-container">
                                <div class="total-summary-grid">
                                    <div class="summary-item">
                                        <div class="summary-icon loading-summary-icon">
                                            <i class="icon-upload"></i>
                                        </div>
                                        <div class="summary-details">
                                            <span class="summary-label">Loading Total</span>
                                            <div class="summary-amount">
                                                <span class="currency-symbol">₹</span>
                                                <span id="loading_subtotal_display">0.00</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="summary-item">
                                        <div class="summary-icon unloading-summary-icon">
                                            <i class="icon-download"></i>
                                        </div>
                                        <div class="summary-details">
                                            <span class="summary-label">Unloading Total</span>
                                            <div class="summary-amount">
                                                <span class="currency-symbol">₹</span>
                                                <span id="unloading_subtotal_display">0.00</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="summary-item grand-total-item">
                                        <div class="summary-icon grand-total-icon">
                                            <i class="icon-sigma"></i>
                                        </div>
                                        <div class="summary-details">
                                            <span class="summary-label">Transportation Total</span>
                                            <div class="summary-amount grand-total-amount">
                                                <span class="currency-symbol">₹</span>
                                                <input type="text" id="loading_unloading_total"
                                                    name="loading_unloading_total" class="loading-total-input" readonly
                                                    value="0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="row">
                    <div class="span12">
                        <div class="data-table-container submit-section-container">
                            <div class="table-header">
                                <h3>
                                    <i class="icon-check-square"></i>
                                    Complete Production Entry
                                </h3>
                            </div>

                            <div class="submit-actions-container">
                                <div class="submit-buttons">
                                    <button type="submit" class="btn-success-gradient">
                                        <i class="icon-check-circle"></i>
                                        Create Production Record
                                    </button>

                                    <a href="<?= site_url('admin/production') ?>" class="btn-primary-gradient">
                                        <i class="icon-arrow-left"></i>
                                        Back to List
                                    </a>
                                </div>

                                <div class="submit-help-text">
                                    <p><i class="icon-info-circle"></i> Review all information before submitting the
                                        production record.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Enhanced JavaScript Libraries -->
<script src="<?php echo base_url()?>assets/validate/dist/jquery.validate.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/ui/jquery-ui.css" />
<script src="<?php echo base_url()?>assets/ui/jquery-ui.js"></script>

<style>
/* Modern Create Production Styles - Aligned with Listing Page */

/* Horizontal Alignment for Production Info & Summary Panel */
.production-info-summary-panel .row {
    display: flex !important;
    align-items: flex-start !important;
    flex-wrap: nowrap !important;
    margin: 0 !important;
}

.production-info-summary-panel .span6 {
    flex: 1 !important;
    min-height: 300px !important;
    display: flex !important;
    flex-direction: column !important;
}

.production-info-summary-panel .span6:first-child {
    border-right: 2px solid #e9ecef !important;
    padding-right: 25px !important;
    margin-right: 25px !important;
}

.production-info-summary-panel .span6:last-child {
    padding-left: 25px !important;
}

.production-info-summary-panel h4 {
    text-align: center !important;
    margin-bottom: 20px !important;
    padding-bottom: 10px !important;
    border-bottom: 2px solid #f1f3f4 !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .production-info-summary-panel .row {
        flex-direction: column !important;
        flex-wrap: wrap !important;
    }
    
    .production-info-summary-panel .span6:first-child {
        border-right: none !important;
        border-bottom: 2px solid #e9ecef !important;
        padding-right: 0 !important;
        margin-right: 0 !important;
        padding-bottom: 25px !important;
        margin-bottom: 25px !important;
    }
    
    .production-info-summary-panel .span6:last-child {
        padding-left: 0 !important;
    }
}

/* Button Gradients */
.btn-primary-gradient {
    background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
    border: none;
    color: white;
    padding: 12px 24px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    border: none;
}

.btn-primary-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
    color: white;
    text-decoration: none;
}

.btn-success-gradient {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    color: white;
    padding: 12px 24px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    border: none;
}

.btn-success-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
    color: white;
    text-decoration: none;
}

/* Enhanced Alert Styles */
.alert-success-modern {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border: none;
    border-left: 5px solid #28a745;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.1);
}

.alert-error-modern {
    background: linear-gradient(135deg, #f8d7da 0%, #f1b0b7 100%);
    border: none;
    border-left: 5px solid #dc3545;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.1);
}

.alert-icon {
    font-size: 24px;
    flex-shrink: 0;
}

.alert-success-modern .alert-icon {
    color: #28a745;
}

.alert-error-modern .alert-icon {
    color: #dc3545;
}

.alert-content {
    flex: 1;
}

.alert-content strong {
    display: block;
    margin-bottom: 5px;
    font-size: 16px;
}

.alert-content p {
    margin: 0;
    color: #495057;
}

.alert-close {
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
    opacity: 0.7;
    transition: opacity 0.3s ease;
}

.alert-close:hover {
    opacity: 1;
}

/* Form Styles */
.form-group-modern {
    margin-bottom: 20px;
    position: relative;
}

.form-label-modern {
    display: block;
    margin-bottom: 10px;
    font-weight: 600;
    color: #2c3e50;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-label-modern i {
    color: #3498db;
    font-size: 16px;
}

.input-wrapper {
    position: relative;
    display: block;
    width: 100%;
}

.form-control-modern {
    width: 100%;
    padding: 12px 45px 12px 15px;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: white;
    display: block;
    box-sizing: border-box;
}

.form-control-modern:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    outline: none;
}

.readonly-input {
    background: #f8f9fa !important;
    cursor: not-allowed;
}

.input-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 16px;
    z-index: 10;
    pointer-events: none;
}

/* Statistics Dashboard */
.stats-dashboard {
    margin-bottom: 25px;
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 20px;
    transition: all 0.3s ease;
    margin-bottom: 15px;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% {
        transform: translateX(-100%);
    }

    100% {
        transform: translateX(100%);
    }
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.stat-card-blue {
    background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
    color: white;
}

.stat-card-green {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
}

.stat-card-yellow {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    color: white;
}

.stat-card-purple {
    background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);
    color: white;
}

.stat-icon {
    font-size: 36px;
    opacity: 0.9;
}

.stat-details h3 {
    margin: 0 0 5px 0;
    font-size: 28px;
    font-weight: bold;
}

.stat-details p {
    margin: 0;
    font-size: 14px;
    opacity: 0.9;
}

/* Data Table Container */
.data-table-container {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 25px;
}

.table-header {
    background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
    color: white;
    padding: 20px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.table-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
}

.table-controls {
    display: flex;
    gap: 10px;
}

/* Enhanced visibility for section totals */
.table-controls span {
    color: #ffffff !important;
    font-weight: 600;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    font-size: 14px !important;
}

.table-controls strong {
    color: #fff3cd !important;
    font-size: 16px !important;
    font-weight: 700;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
    padding: 2px 6px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
    margin-left: 5px;
}

/* Specific styling for loading total */
#loading_total_display {
    color: #d1ecf1 !important;
    background: rgba(23, 162, 184, 0.2) !important;
}

/* Specific styling for product total */
#product_total_display {
    color: #fff3cd !important;
    background: rgba(255, 193, 7, 0.2) !important;
}

/* Section total label styling */
.section-total-label {
    color: #ffffff !important;
    font-weight: 600;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    font-size: 14px !important;
}

.section-total-label strong {
    color: inherit;
    font-size: 16px !important;
    font-weight: 700;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
    padding: 3px 8px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 6px;
    margin-left: 8px;
    display: inline-block;
    min-width: 80px;
    text-align: center;
}

/* Grand Total Display */
.grand-total-display {
    position: relative;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 10px;
    padding: 0;
    border: 2px solid #3498db;
    overflow: hidden;
}

.grand-total-input {
    background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
    border: none;
    color: white;
    font-size: 20px;
    font-weight: bold;
    text-align: center;
    padding: 18px 20px;
    border-radius: 8px;
    width: 100%;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
    transition: all 0.3s ease;
}

.grand-total-input:focus {
    outline: none;
    box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
    transform: translateY(-1px);
}

/* Enhanced form group alignment */
.form-group-modern:last-child {
    margin-bottom: 0;
}

.form-group-modern:last-child .grand-total-display {
    margin-top: 5px;
}

/* Special styling for grand total form group */
.grand-total-group {
    background: rgba(52, 152, 219, 0.05);
    padding: 20px;
    border-radius: 12px;
    border: 1px solid rgba(52, 152, 219, 0.1);
    margin-top: 15px;
    box-shadow: 0 2px 8px rgba(52, 152, 219, 0.1);
}

.grand-total-group .form-label-modern {
    color: #3498db;
    font-size: 15px;
    font-weight: 700;
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.grand-total-group .form-label-modern i {
    color: #2c3e50;
    font-size: 18px;
    margin-right: 10px;
}

/* Ensure proper spacing between form elements */
.form-group-modern+.grand-total-group {
    margin-top: 25px;
}

/* Summary Section Specific Styles */
.summary-stat-item {
    width: 100%;
}

.summary-stat-item .stat-card {
    width: 100%;
    box-sizing: border-box;
}

/* Enhanced Layout Following Bootstrap Grid Standards */

/* Section Container Alignment - Bootstrap Compatible */
.row {
    margin-left: -20px;
    margin-right: -20px;
    margin-bottom: 20px;
    width: auto;
    display: block;
    *zoom: 1;
}

.row:before,
.row:after {
    content: "";
    display: table;
    line-height: 0;
}

.row:after {
    clear: both;
}

.row:last-child {
    margin-bottom: 0;
}

/* Container Wrapper for Perfect Alignment */
.modern-form {
    max-width: 100%;
    width: 100%;
}

/* Fix for Bootstrap Grid System Compatibility */
.container .row {
    margin-left: -20px;
    margin-right: -20px;
}

[class*="span"] {
    float: left;
    min-height: 1px;
    margin-left: 20px;
}

/* Standard Container Styles - Bootstrap Grid System Compatible */

/* Two Column Layout (Sections 1 & 2) - Exact Bootstrap Standards */
.span5 {
    width: 40.42553191%;
    float: left;
    margin-left: 20px;
    margin-bottom: 20px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

.span6 {
    width: 48.71794872%;
    float: left;
    margin-left: 20px;
    margin-bottom: 20px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

/* Full Width Layout (Sections 3, 4, 5) - Exact Bootstrap Standards */
.span12 {
    width: 100%;
    float: left;
    margin-left: 20px;
    margin-bottom: 20px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

/* Bootstrap Grid Reset Override */
.row .span5:first-child,
.row .span6:first-child,
.row .span12:first-child {
    margin-left: 20px;
}

/* Container Padding Adjustments for ERP Consistency */
.container {
    padding-left: 20px;
    padding-right: 20px;
}

/* Data Container Alignment */
.data-table-container {
    position: relative;
    padding: 0;
    margin-bottom: 20px;
}

/* Form Section Consistency */
.modern-form .row {
    margin-bottom: 20px;
}

.modern-form .row:last-child {
    margin-bottom: 30px;
    /* Extra space before submit buttons */
}

/* Consistent Section Spacing */
.data-table-container {
    margin-bottom: 0 !important;
}

/* Production Form Container */
.production-form-container {
    padding: 25px;
    background: rgba(248, 249, 255, 0.3);
    border-radius: 0 0 15px 15px;
}

.production-form-container .form-group-modern {
    background: white;
    padding: 20px;
    border-radius: 12px;
    border: 1px solid #e9ecef;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.production-form-container .form-group-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-color: #3498db;
}

.production-form-container .form-group-modern.grand-total-group {
    background: linear-gradient(135deg, #f8f9ff 0%, #e9ecff 100%);
    border-color: #3498db;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.15);
}

.row .data-table-container {
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border-radius: 15px;
    overflow: hidden;
}

/* Equal Height Cards for Top Two Sections */
.row .span5 .data-table-container,
.row .span6 .data-table-container {
    height: 100%;
    display: flex;
    flex-direction: column;
    min-height: 500px;
}

.row .span5 .data-table-container>div:last-child,
.row .span6 .data-table-container>div:last-child {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* Section Specific Adjustments */

/* Section 1: Production Information */
.span5:first-child .data-table-container,
.span6:first-child .data-table-container {
    background: linear-gradient(145deg, #ffffff 0%, #f8f9ff 100%);
}

/* Section 2: Production Summary */
.span5:last-child .data-table-container,
.span6:last-child .data-table-container {
    background: linear-gradient(145deg, #ffffff 0%, #fff8f0 100%);
}

/* Section 3: Product Details */
.row:nth-child(2) .data-table-container {
    background: linear-gradient(145deg, #ffffff 0%, #f0fff4 100%);
}

/* Section 4: Loading & Unloading */
.row:nth-child(3) .data-table-container {
    background: linear-gradient(145deg, #ffffff 0%, #f0f8ff 100%);
}

/* Section 5: Submit Section */
.row:last-child .page-header-card {
    background: linear-gradient(145deg, rgba(255, 255, 255, 0.98) 0%, rgba(248, 249, 255, 0.95) 100%) !important;
    border: 1px solid rgba(52, 152, 219, 0.1);
}

/* Consistent Padding for All Sections */
.data-table-container>div:not(.table-header) {
    padding: 25px;
}

/* Override padding for modern tables */
.data-table-container>div:has(.table-modern) {
    padding: 0;
}

/* Submit Section Styling */
.submit-section-container {
    background: linear-gradient(145deg, #ffffff 0%, #f8fff8 100%);
}

.submit-actions-container {
    padding: 30px;
    text-align: center;
}

.submit-buttons {
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.submit-help-text {
    color: #6c757d;
    font-size: 14px;
    font-style: italic;
}

.submit-help-text i {
    color: #3498db;
    margin-right: 8px;
}

/* Responsive Grid Alignment - Bootstrap Compatible */
@media (max-width: 1024px) {
    .row .span5 .data-table-container,
    .row .span6 .data-table-container {
        min-height: 400px;
    }

    /* Ensure proper margins on tablets */
    .row {
        margin-left: -15px;
        margin-right: -15px;
    }

    [class*="span"] {
        margin-left: 15px;
    }

    .row .span5:first-child,
    .row .span6:first-child,
    .row .span12:first-child {
        margin-left: 15px;
    }
}

@media (max-width: 768px) {

    /* Mobile Grid Reset - Full Width */
    .span5,
    .span6,
    .span12 {
        width: 100%;
        float: none;
        margin-left: 0;
        margin-bottom: 20px;
    }

    .row {
        margin-left: 0;
        margin-right: 0;
    }

    .row .span5:first-child,
    .row .span6:first-child,
    .row .span12:first-child {
        margin-left: 0;
    }

    .row .span5 .data-table-container,
    .row .span6 .data-table-container {
        min-height: auto;
    }

    .submit-buttons {
        flex-direction: column;
        align-items: center;
    }

    .btn-success-gradient,
    .btn-primary-gradient {
        width: 100%;
        max-width: 300px;
    }
}

/* Additional Summary Section Fixes */
.summary-stat-item .stat-card {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    margin: 0;
    border-radius: 12px;
    transition: all 0.3s ease;
    min-height: 80px;
}

.summary-stat-item .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.summary-stat-item .stat-icon {
    font-size: 32px;
    opacity: 0.9;
    flex-shrink: 0;
}

.summary-stat-item .stat-details h3 {
    margin: 0 0 5px 0;
    font-size: 24px;
    font-weight: bold;
}

.summary-stat-item .stat-details p {
    margin: 0;
    font-size: 14px;
    opacity: 0.9;
}

/* Responsive adjustments for summary section */
@media (max-width: 768px) {
    .span6 {
        width: 100%;
        float: none;
        margin-left: 0;
        margin-bottom: 20px;
    }

    .summary-stat-item .stat-card {
        padding: 15px;
        min-height: 70px;
    }

    .summary-stat-item .stat-icon {
        font-size: 28px;
    }

    .summary-stat-item .stat-details h3 {
        font-size: 20px;
    }
}

.stat-item:hover {
    background: #e9ecef;
    transform: translateY(-2px);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
}

.stat-products {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.stat-loading {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
}

.stat-total {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
}

.stat-details {
    flex: 1;
}

.stat-label {
    font-size: 14px;
    color: #6c757d;
    margin-bottom: 5px;
}

.stat-value {
    font-size: 18px;
    font-weight: bold;
    color: #2c3e50;
}

.stat-grand-value {
    font-size: 20px;
    color: #3498db;
}

.stat-separator {
    height: 2px;
    background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
    border-radius: 2px;
    margin: 10px 0;
}

.stat-grand {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border: 2px solid #3498db;
}

/* Section Headers */
.section-header {
    background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
    color: white;
    padding: 20px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

.header-left h3 {
    margin: 0 0 5px 0;
    font-size: 18px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.header-left p {
    margin: 0;
    opacity: 0.9;
    font-size: 14px;
}

.section-total {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(255, 255, 255, 0.2);
    padding: 8px 15px;
    border-radius: 20px;
}

.total-label {
    font-size: 14px;
    font-weight: 500;
}

.total-amount {
    font-size: 16px;
    font-weight: bold;
}

/* Table Styles */
.table-container {
    padding: 25px;
}

.modern-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 14px;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.modern-table thead th {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: none;
    padding: 15px;
    font-weight: 600;
    text-align: center;
    position: relative;
}

.th-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}

.th-content i {
    font-size: 16px;
    color: #3498db;
}

.th-content span {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.modern-table tbody td {
    padding: 15px;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
    text-align: center;
}

.product-row {
    transition: all 0.3s ease;
    background: white;
}

.product-row:hover {
    background: #f8f9fa;
    transform: scale(1.01);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.product-info {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-weight: 600;
    color: #2c3e50;
}

.product-icon {
    color: #3498db;
    font-size: 16px;
}

/* Table Input Styles */
.input-group {
    display: flex;
    align-items: center;
    position: relative;
}

.table-input {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 10px 35px 10px 15px;
    font-size: 14px;
    text-align: center;
    transition: all 0.3s ease;
    background: white;
    width: 100%;
}

.table-input:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    outline: none;
}

/* Enhanced Dropdown Styling */
.table-input select,
select.table-input,
.material-select,
.labour-select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background: white;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%233498db' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 18px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 12px 45px 12px 15px;
    font-size: 14px;
    font-weight: 500;
    color: #2c3e50;
    cursor: pointer;
    text-align: left;
    line-height: 1.4;
    min-height: 44px;
    box-sizing: border-box;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.table-input select:hover,
select.table-input:hover,
.material-select:hover,
.labour-select:hover {
    border-color: #3498db;
    background-color: #f8f9ff;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(52, 152, 219, 0.15);
}

.table-input select:focus,
select.table-input:focus,
.material-select:focus,
.labour-select:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    outline: none;
    background-color: #ffffff;
    transform: translateY(0);
}

/* Dropdown Options Styling */
.table-input select option,
select.table-input option,
.material-select option,
.labour-select option {
    padding: 10px 15px;
    font-size: 14px;
    color: #2c3e50;
    background: white;
    border: none;
}

.table-input select option:hover,
select.table-input option:hover,
.material-select option:hover,
.labour-select option:hover {
    background: #f8f9ff;
    color: #3498db;
}

.table-input select option:checked,
select.table-input option:checked,
.material-select option:checked,
.labour-select option:checked {
    background: #3498db;
    color: white;
    font-weight: 600;
}

/* Placeholder option styling */
.table-input select option[value=""],
select.table-input option[value=""],
.material-select option[value=""],
.labour-select option[value=""] {
    color: #6c757d;
    font-style: italic;
}

/* Cell-specific dropdown styling */
.material-cell select,
.labour-cell select {
    width: 100%;
    max-width: none;
}

/* Enhanced dropdown state classes */
.dropdown-focused {
    background: linear-gradient(135deg, #f8f9ff 0%, #e9ecff 100%);
    border-radius: 8px;
    transform: scale(1.02);
    transition: all 0.3s ease;
}

.dropdown-active {
    border-color: #3498db !important;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.15) !important;
    z-index: 1000;
    position: relative;
}

.has-selection {
    border-color: #28a745 !important;
    background-color: #f8fff8 !important;
    font-weight: 600;
    color: #155724 !important;
}

.has-selection:focus {
    border-color: #3498db !important;
    background-color: #ffffff !important;
}

/* Better contrast for selected options */
.material-select option:checked,
.labour-select option:checked {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%) !important;
    color: white !important;
    font-weight: bold;
}

/* Hover effects for better UX */
.material-cell:hover .material-select,
.labour-cell:hover .labour-select {
    border-color: #3498db;
    box-shadow: 0 2px 8px rgba(52, 152, 219, 0.1);
}

/* Loading state for dynamic dropdowns */
.dropdown-loading {
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236c757d' stroke-width='2'%3e%3ccircle cx='12' cy='12' r='10'%3e%3c/circle%3e%3cpath d='m16 12-4-4-4 4'%3e%3c/path%3e%3c/svg%3e");
    opacity: 0.7;
    cursor: wait;
}

/* Responsive dropdown adjustments */
@media (max-width: 768px) {
    .table-input select,
    select.table-input,
    .material-select,
    .labour-select {
        font-size: 13px;
        padding: 10px 35px 10px 12px;
        background-size: 14px;
        background-position: right 10px center;
    }
    
    .dropdown-focused {
        transform: scale(1.01);
    }
}

.input-unit {
    position: absolute;
    right: 10px;
    font-size: 11px;
    color: #6c757d;
    font-weight: 500;
}

.input-prefix {
    position: absolute;
    left: 15px;
    font-size: 14px;
    color: #6c757d;
    font-weight: 600;
}

.rate-input {
    padding-left: 35px;
}

/* Amount Display */
.amount-display {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 8px;
    padding: 10px;
    border: 2px solid #e9ecef;
}

.currency-symbol {
    font-weight: bold;
    color: #3498db;
    margin-right: 5px;
}

.amount-input {
    background: none;
    border: none;
    font-weight: bold;
    font-size: 14px;
    color: #2c3e50;
    text-align: center;
    width: 100%;
}

/* Modern Table Styles */
.table-modern {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 14px;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.table-modern thead th {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: none;
    padding: 15px 10px;
    font-weight: 600;
    text-align: center;
    position: relative;
}

.th-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
}

.th-content i {
    font-size: 16px;
    color: #3498db;
}

.th-content span {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table-modern tbody td {
    padding: 15px 10px;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
    text-align: center;
}

.table-row {
    transition: all 0.3s ease;
    background: white;
}

.table-row:hover {
    background: #f8f9fa;
    transform: scale(1.01);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.product-info {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-weight: 600;
    color: #2c3e50;
}

.product-icon {
    color: #3498db;
    font-size: 16px;
}

/* Loading Cards */
.loading-cards-container {
    padding: 25px;
    display: flex;
    gap: 25px;
    flex-wrap: wrap;
}

.loading-card {
    flex: 1;
    min-width: 300px;
    background: white;
    border: 2px solid #e9ecef;
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.loading-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border-color: #3498db;
}

.loading-card .card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    color: #2c3e50;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.card-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
}

.loading-icon {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.unloading-icon {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

.card-title h4 {
    margin: 0 0 5px 0;
    font-size: 16px;
    font-weight: 600;
}

.card-title p {
    margin: 0;
    font-size: 12px;
    color: #6c757d;
}

.card-inputs {
    padding: 20px;
}

.input-row {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.loading-input {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 12px 15px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: white;
    width: 100%;
}

.loading-input:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    outline: none;
}

.input-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: #2c3e50;
    font-size: 13px;
    margin-bottom: 8px;
}

/* Loading Total Container */
.loading-total-container {
    padding: 25px;
    background: #f8f9fa;
}

.loading-total-card {
    background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
    color: white;
    padding: 20px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 5px 20px rgba(52, 152, 219, 0.3);
}

.total-icon {
    font-size: 36px;
    opacity: 0.9;
}

.total-details {
    flex: 1;
}

.total-details .total-label {
    font-size: 16px;
    margin-bottom: 10px;
    opacity: 0.9;
}

.total-amount-display {
    display: flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    padding: 15px;
}

.loading-total-input {
    background: none;
    border: none;
    color: white;
    font-size: 20px;
    font-weight: bold;
    text-align: center;
    width: 100%;
}

/* Separated Loading/Unloading Section Styles */
.loading-section-card {
    border-left: 4px solid #28a745 !important;
}

.loading-section-card .card-header {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%) !important;
}

.loading-section-card .loading-icon {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
}

.unloading-section-card {
    border-left: 4px solid #fd7e14 !important;
}

.unloading-section-card .card-header {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%) !important;
}

.unloading-section-card .unloading-icon {
    background: linear-gradient(135deg, #fd7e14 0%, #e67e22 100%) !important;
}

/* Transportation Summary Grid */
.total-summary-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 2fr;
    gap: 20px;
    padding: 25px;
    background: #f8f9fa;
}

.summary-item {
    background: white;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.summary-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.summary-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
}

.loading-summary-icon {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.unloading-summary-icon {
    background: linear-gradient(135deg, #fd7e14 0%, #e67e22 100%);
}

.grand-total-icon {
    background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
}

.summary-details {
    flex: 1;
}

.summary-label {
    display: block;
    font-weight: 600;
    color: #2c3e50;
    font-size: 13px;
    margin-bottom: 5px;
}

.summary-amount {
    font-size: 18px;
    font-weight: bold;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 4px;
}

.grand-total-item {
    border: 3px solid #3498db;
    background: linear-gradient(135deg, #f8f9ff 0%, #e3f2fd 100%);
}

.grand-total-amount .loading-total-input {
    background: transparent;
    border: none;
    font-size: 18px;
    font-weight: bold;
    color: #2c3e50;
    padding: 0;
    width: auto;
    min-width: 120px;
}

/* Loading Section Styling - Matches Product Section */
.loading-quantity,
.loading-rate,
.loading-amount {
    /* Inherits from .table-input and .amount-input classes already defined */
}

/* Total Row Styles */
.total-row {
    background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
    color: white;
}

.total-label-cell {
    text-align: right;
    padding-right: 20px;
    font-size: 14px;
    font-weight: 600;
}

.total-display {
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    padding: 10px;
}

.total-input {
    background: none;
    border: none;
    color: white;
    font-weight: bold;
    font-size: 16px;
    text-align: center;
    width: 100%;
}

/* Responsive Design */
@media (max-width: 768px) {
    .action-buttons {
        width: 100%;
        justify-content: center;
        margin-top: 15px;
        flex-wrap: wrap;
    }

    .stats-dashboard .span12 {
        width: 100%;
        margin-bottom: 15px;
    }

    .loading-cards-container {
        flex-direction: column;
        padding: 15px;
    }

    .loading-card {
        min-width: auto;
    }

    .table-modern {
        font-size: 12px;
    }

    .th-content span {
        font-size: 10px;
    }

    .loading-total-card {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }

    /* Responsive Summary Grid */
    .total-summary-grid {
        grid-template-columns: 1fr;
        gap: 15px;
        padding: 15px;
    }

    .summary-item {
        padding: 15px;
        gap: 10px;
    }

    .summary-icon {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }

    .summary-amount {
        font-size: 16px;
    }

    .grand-total-amount .loading-total-input {
        font-size: 16px;
        min-width: 100px;
    }

    .loading-section-card,
    .unloading-section-card {
        margin-bottom: 15px;
    }

    /* Responsive Loading Table - Matches Product Table */
    /* Loading table inherits responsive styles from .table-modern */
}

/* Total Row */
.total-row {
    background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
    color: white;
}

.total-label-cell {
    text-align: right;
    padding-right: 20px;
    font-size: 14px;
    font-weight: 600;
}

.total-display {
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    padding: 10px;
}

.total-input {
    background: none;
    border: none;
    color: white;
    font-weight: bold;
    font-size: 16px;
    text-align: center;
    width: 100%;
}

/* Loading/Unloading Cards */
.loading-cards-container {
    padding: 25px;
    display: flex;
    gap: 25px;
    flex-wrap: wrap;
}

.loading-card {
    flex: 1;
    min-width: 300px;
    background: white;
    border: 2px solid #e9ecef;
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.loading-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border-color: #3498db;
}

.loading-card .card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    color: #2c3e50;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.card-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
}

.loading-icon {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.unloading-icon {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

.card-title h4 {
    margin: 0 0 5px 0;
    font-size: 16px;
    font-weight: 600;
}

.card-title p {
    margin: 0;
    font-size: 12px;
    color: #6c757d;
}

.card-inputs {
    padding: 20px;
}

.input-row {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.loading-input {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 12px 15px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: white;
}

.loading-input:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    outline: none;
}

.input-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: #2c3e50;
    font-size: 13px;
    margin-bottom: 8px;
}

/* Loading Total Container */
.loading-total-container {
    padding: 25px;
    background: #f8f9fa;
}

.loading-total-card {
    background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
    color: white;
    padding: 20px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 5px 20px rgba(52, 152, 219, 0.3);
}

.total-icon {
    font-size: 36px;
    opacity: 0.9;
}

.total-details {
    flex: 1;
}

.total-details .total-label {
    font-size: 16px;
    margin-bottom: 10px;
    opacity: 0.9;
}

.total-amount-display {
    display: flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    padding: 15px;
}

.loading-total-input {
    background: none;
    border: none;
    color: white;
    font-size: 20px;
    font-weight: bold;
    text-align: center;
    width: 100%;
}

/* Submit Section */
.submit-section {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
}

.submit-container {
    display: flex;
    gap: 20px;
    justify-content: center;
    align-items: center;
}

.btn-submit-modern {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    color: white;
    padding: 15px 30px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(40, 167, 69, 0.3);
    display: flex;
    align-items: center;
    gap: 10px;
}

.btn-submit-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(40, 167, 69, 0.4);
}

.btn-cancel-modern {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    border: none;
    color: white;
    padding: 15px 30px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 16px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(108, 117, 125, 0.3);
    display: flex;
    align-items: center;
    gap: 10px;
}

.btn-cancel-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(108, 117, 125, 0.4);
    color: white;
    text-decoration: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }

    .section-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }

    .loading-cards-container {
        flex-direction: column;
    }

    .loading-card {
        min-width: auto;
    }

    .submit-container {
        flex-direction: column;
    }

    .btn-submit-modern,
    .btn-cancel-modern {
        width: 100%;
        justify-content: center;
    }

    .summary-stats {
        gap: 15px;
    }

    .stat-item {
        padding: 12px;
    }

    .loading-total-card {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
}

/* Loading Animation */
.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* Form Validation Styles */
.form-control-modern.error {
    border-color: #dc3545;
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
}

.form-control-modern.valid {
    border-color: #28a745;
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
}

/* Focus animations */
.table-input:focus,
.loading-input:focus {
    transform: scale(1.02);
}

.product-row.highlight {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    border-left: 4px solid #ffc107;
}
</style>

<script>
$(document).ready(function() {
    // Enhanced DatePicker
    $("#production_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
        showAnim: 'slideDown',
        showButtonPanel: true,
        closeText: 'Clear',
        beforeShow: function(input, inst) {
            setTimeout(function() {
                inst.dpDiv.css({
                    'box-shadow': '0 10px 30px rgba(0,0,0,0.2)',
                    'border-radius': '10px',
                    'border': '2px solid #3498db'
                });
            }, 1);
        }
    });

    // Enhanced Form Validation
    $("#production-form").validate({
        rules: {
            'production[date]': {
                required: true
            },
            'production[sheet_no]': {
                required: true
            }
        },
        messages: {
            'production[date]': "Please select a production date",
            'production[sheet_no]': "Production sheet number is required"
        },
        highlight: function(element) {
            $(element).addClass('error').removeClass('valid');
        },
        unhighlight: function(element) {
            $(element).removeClass('error').addClass('valid');
        },
        submitHandler: function(form) {
            // Add loading state
            var submitBtn = $('.btn-success-gradient');
            var originalText = submitBtn.html();

            submitBtn.html('<i class="icon-spinner icon-spin"></i> Creating Production...').prop(
                'disabled', true);

            // Submit form
            form.submit();
        }
    });

    // Enhanced calculation functions with animations
    function calculateProductAmount(row) {
        var quantity = parseFloat(row.find('.quantity-input').val()) || 0;
        var rate = parseFloat(row.find('.rate-input').val()) || 0;
        var amount = quantity * rate;

        row.find('.amount-input').val(amount.toFixed(2));

        // Add highlight animation
        row.addClass('highlight');
        setTimeout(function() {
            row.removeClass('highlight');
        }, 1000);

        calculateProductTotal();
    }

    function calculateLoadingAmount(container, type) {
        var quantity = parseFloat(container.find('input[name*="[' + type + '_qty]"]').val()) || 0;
        var rate = parseFloat(container.find('input[name*="[' + type + '_rate]"]').val()) || 0;
        var amount = quantity * rate;

        container.find('input[name*="[' + type + '_amount]"]').val(amount.toFixed(2));

        calculateLoadingUnloadingTotal();
    }

    function calculateProductTotal() {
        var total = 0;
        $('.amount-input').not('#product_total, #loading_unloading_total').each(function() {
            var amount = parseFloat($(this).val()) || 0;
            total += amount;
        });

        $('#product_total').val(total.toFixed(2));
        $('#product_total_display').text('₹' + total.toLocaleString('en-IN', {
            minimumFractionDigits: 2
        }));
        $('#summary_products_total').text('₹' + total.toLocaleString('en-IN', {
            minimumFractionDigits: 2
        }));

        calculateGrandTotal();
    }

    // Loading Table Functions (Static Product Rows)
    function calculateLoadingRowAmount(row) {
        var quantity = parseFloat(row.find('.loading-quantity').val()) || 0;
        var rate = parseFloat(row.find('.loading-rate').val()) || 0;
        var amount = quantity * rate;

        row.find('.loading-amount').val(amount.toFixed(2));

        // Add highlight animation
        row.addClass('highlight');
        setTimeout(function() {
            row.removeClass('highlight');
        }, 1000);

        calculateLoadingTotal();
    }

    function calculateLoadingTotal() {
        var total = 0;
        $('.loading-amount').each(function() {
            var amount = parseFloat($(this).val()) || 0;
            total += amount;
        });

        // Update loading total displays
        $('#loading_total_input').val(total.toFixed(2));
        $('#loading_only_total_display').text('₹' + total.toLocaleString('en-IN', {
            minimumFractionDigits: 2
        }));
        $('#loading_subtotal_display').text(total.toLocaleString('en-IN', {
            minimumFractionDigits: 2
        }));

        calculateLoadingUnloadingTotal();
    }

    function calculateLoadingUnloadingTotal() {
        var loadingAmount = parseFloat($('#loading_total_input').val()) || 0;
        var unloadingAmount = parseFloat($('#unloading_total_input').val()) || 0;
        var total = loadingAmount + unloadingAmount;

        // Update combined totals
        $('#loading_unloading_total').val(total.toFixed(2));
        $('#loading_total_display').text('₹' + total.toLocaleString('en-IN', {
            minimumFractionDigits: 2
        }));
        $('#summary_loading_total').text('₹' + total.toLocaleString('en-IN', {
            minimumFractionDigits: 2
        }));

        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        var productTotal = parseFloat($('#product_total').val()) || 0;
        var loadingUnloadingTotal = parseFloat($('#loading_unloading_total').val()) || 0;
        var grandTotal = productTotal + loadingUnloadingTotal;

        $('#grand_total').val('₹' + grandTotal.toLocaleString('en-IN', {
            minimumFractionDigits: 2
        }));
        $('#summary_grand_total').text('₹' + grandTotal.toLocaleString('en-IN', {
            minimumFractionDigits: 2
        }));
    }

    // Event handlers for product calculations
    $('.quantity-input, .rate-input').on('input change', function() {
        var row = $(this).closest('.product-row');
        calculateProductAmount(row);
    });

    // Event handlers for loading table calculations
    $('.loading-quantity, .loading-rate').on('input change', function() {
        var row = $(this).closest('.loading-row');
        calculateLoadingRowAmount(row);
    });

    // Dynamic Unloading Section Functions
    var unloadingRowCount = 0;

    function calculateUnloadingRowAmount(row) {
        var quantity = parseFloat(row.find('.unloading-quantity').val()) || 0;
        var rate = parseFloat(row.find('.unloading-rate').val()) || 0;
        var amount = quantity * rate;

        row.find('.unloading-amount').val(amount.toFixed(2));

        // Add highlight animation
        row.addClass('highlight');
        setTimeout(function() {
            row.removeClass('highlight');
        }, 1000);

        calculateUnloadingTotal();
    }

    function calculateUnloadingTotal() {
        var total = 0;
        $('.unloading-amount').each(function() {
            var amount = parseFloat($(this).val()) || 0;
            total += amount;
        });

        // Update unloading total displays
        $('#unloading_total_input').val(total.toFixed(2));
        $('#unloading_only_total_display').text('₹' + total.toLocaleString('en-IN', {
            minimumFractionDigits: 2
        }));

        calculateLoadingUnloadingTotal();
    }

    function addUnloadingRow() {
        unloadingRowCount++;
        var materialsDropdown = '';
        var labourGroupsDropdown = '';

        // Build materials dropdown
        <?php if(isset($materials) && !empty($materials)): ?>
            materialsDropdown += '<option value="">Select Material</option>';
            <?php foreach($materials as $material): ?>
                materialsDropdown += '<option value="<?php echo $material["id"]; ?>"><?php echo htmlspecialchars($material["name"]); ?></option>';
            <?php endforeach; ?>
        <?php endif; ?>

        // Build labour groups dropdown
        <?php if(isset($labour_groups) && !empty($labour_groups)): ?>
            labourGroupsDropdown += '<option value="">Select Labour Group</option>';
            <?php foreach($labour_groups as $labour_group): ?>
                labourGroupsDropdown += '<option value="<?php echo $labour_group["id"]; ?>"><?php echo htmlspecialchars($labour_group["name"]); ?></option>';
            <?php endforeach; ?>
        <?php endif; ?>

        var newRow = `
            <tr class="table-row unloading-row" data-row="${unloadingRowCount}">
                <td class="material-cell">
                    <select name="unloading[${unloadingRowCount}][material_id]" class="table-input material-select" >
                        ${materialsDropdown}
                    </select>
                </td>
                <td class="labour-cell">
                    <select name="unloading[${unloadingRowCount}][labour_group_id]" class="table-input labour-select" >
                        ${labourGroupsDropdown}
                    </select>
                </td>
                <td class="quantity-cell">
                    <div class="input-group">
                        <input type="number" name="unloading[${unloadingRowCount}][qty]" 
                               class="table-input unloading-quantity" 
                               placeholder="0" min="0" step="0.01">                       
                    </div>
                </td>
                 <td class="unit-cell">
                    <div class="input-group">
                        <input type="text" name="unloading[${unloadingRowCount}][unit]" 
                               class="table-input unloading-unit" 
                               placeholder="Unit">                       
                    </div>
                </td>
                <td class="rate-cell">
                    <div class="input-group">
                        <span class="input-prefix">₹</span>
                        <input type="number" name="unloading[${unloadingRowCount}][rate]" 
                               class="table-input unloading-rate" 
                               placeholder="0.00" min="0" step="0.01">
                    </div>
                </td>
                <td class="amount-cell">
                    <div class="amount-display">
                        <span class="currency-symbol">₹</span>
                        <input type="text" name="unloading[${unloadingRowCount}][amount]" 
                               class="amount-input unloading-amount" readonly value="0.00">
                    </div>
                </td>
                <td class="action-cell">
                    <button type="button" class="btn btn-danger btn-small remove-unloading-row">
                        <i class="icon-trash"></i>
                    </button>
                </td>
            </tr>
        `;

        $('#unloading_items_tbody').append(newRow);
        updateUnloadingRowButtons();
    }

    function updateUnloadingRowButtons() {
        var rowCount = $('#unloading_items_tbody tr').length;
        
        // Disable remove button if only one row
        if (rowCount <= 1) {
            $('.remove-unloading-row').prop('disabled', true);
        } else {
            $('.remove-unloading-row').prop('disabled', false);
        }
    }

    // Event handlers for unloading table
    $('#add_unloading_row').on('click', function() {
        addUnloadingRow();
    });

    $(document).on('click', '.remove-unloading-row', function() {
        if ($('#unloading_items_tbody tr').length > 1) {
            $(this).closest('tr').remove();
            calculateUnloadingTotal();
            updateUnloadingRowButtons();
        }
    });

    $(document).on('input change', '.unloading-quantity, .unloading-rate', function() {
        var row = $(this).closest('.unloading-row');
        calculateUnloadingRowAmount(row);
    });

    // Initialize unloading section
    updateUnloadingRowButtons();

    // Enhanced input animations
    $('.table-input, .loading-input, .form-control-modern').on('focus', function() {
        $(this).closest('.product-row, .loading-card, .form-group-modern').addClass('focused');
    }).on('blur', function() {
        $(this).closest('.product-row, .loading-card, .form-group-modern').removeClass('focused');
    });

    // Enhanced dropdown interactions
    $(document).on('focus', '.material-select, .labour-select, select.table-input', function() {
        $(this).closest('td').addClass('dropdown-focused');
        $(this).addClass('dropdown-active');
    });

    $(document).on('blur', '.material-select, .labour-select, select.table-input', function() {
        $(this).closest('td').removeClass('dropdown-focused');
        $(this).removeClass('dropdown-active');
    });

    $(document).on('change', '.material-select, .labour-select, select.table-input', function() {
        var $this = $(this);
        var selectedText = $this.find('option:selected').text();
        
        // Add visual feedback for selection
        if ($this.val() !== '') {
            $this.addClass('has-selection');
            
            // Show selection animation
            $this.css('background-color', '#e8f5e8');
            setTimeout(function() {
                $this.css('background-color', '');
            }, 500);
        } else {
            $this.removeClass('has-selection');
        }
    });

    // Initialize existing dropdown selections
    $('.material-select, .labour-select, select.table-input').each(function() {
        if ($(this).val() !== '') {
            $(this).addClass('has-selection');
        }
    });

    // Auto-format currency inputs
    $('.amount-input, .total-input, .loading-total-input, .grand-total-input').on('input', function() {
        var value = parseFloat($(this).val().replace(/[^\d.-]/g, '')) || 0;
        if ($(this).hasClass('grand-total-input')) {
            $(this).val('₹' + value.toLocaleString('en-IN', {
                minimumFractionDigits: 2
            }));
        } else {
            $(this).val(value.toFixed(2));
        }
    });

    // Initialize calculations on page load
    calculateProductTotal();
    calculateLoadingUnloadingTotal();

    // Add smooth scroll for long forms
    $('html, body').animate({
        scrollTop: 0
    }, 500);

    // Enhanced form interactions
    $('.product-row').hover(
        function() {
            $(this).css('transform', 'scale(1.01)');
        },
        function() {
            $(this).css('transform', 'scale(1)');
        }
    );

    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl + S to submit
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            $('#production-form').submit();
        }

        // Escape to cancel
        if (e.key === 'Escape') {
            if (confirm('Are you sure you want to cancel? All unsaved changes will be lost.')) {
                window.location.href = '<?= site_url('admin/production') ?>';
            }
        }
    });

    // Auto-save draft (optional enhancement)
    var autoSaveTimer;
    $('.table-input, .loading-input').on('input', function() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(function() {
            // Auto-save logic can be implemented here
            console.log('Auto-saving draft...');
        }, 2000);
    });
});

// Enhanced focus styles
$('head').append(`
<style>
.focused {
    transform: scale(1.02) !important;
    box-shadow: 0 5px 20px rgba(52, 152, 219, 0.2) !important;
}

.product-row.focused {
    background: linear-gradient(135deg, #f8f9ff 0%, #e9ecff 100%) !important;
    border-left: 4px solid #3498db !important;
}

.loading-card.focused {
    border-color: #3498db !important;
    box-shadow: 0 10px 30px rgba(52, 152, 219, 0.2) !important;
}
</style>
`);
</script>