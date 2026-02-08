<?php
/**
 * Enhanced Production Listing View - Standardized Design
 * 
 * Professional design matching view_sales pattern including:
 * - Consistent styling with standardized_view.css
 * - Enhanced DataTables with export functionality
 * - Font Awesome icons integration
 * - Chosen library for improved dropdowns
 * - Advanced search and filtering capabilities
 * - Responsive design for all devices
 */

// JavaScript libraries now loaded globally from header.php
?>

<!-- Enhanced CSS for Professional Design matching view_sales -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/standardized_view.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/font/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/chosen/chosen.min.css">

<!-- CSS and JavaScript libraries now loaded from header.php -->

<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    
                    <!-- Professional Page Header - Standardized Design -->
                    <div class="widget">
                        <div class="widget-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-bottom: 2px solid #667eea; padding: 15px 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            <h3 style="margin: 0; color: #ffffff; font-size: 18px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;"><i class="icon-cog" style="color: #ffffff; margin-right: 8px; font-size: 14px;"></i> PRODUCTION MANAGEMENT</h3>
                            <div class="pull-right">
                                <a href="<?= site_url('admin/production/create_production') ?>" class="btn" style="background: linear-gradient(135deg, #00b894 0%, #00cec9 100%); color: white; border: none; padding: 8px 16px; border-radius: 4px; text-decoration: none; margin-left: 5px; box-shadow: 0 2px 4px rgba(0, 184, 148, 0.3);">
                                    <i class="icon-plus" style="font-size: 11px;"></i> New Production
                                </a>
                                <a href="<?= site_url('admin/production/production_report') ?>" class="btn" style="background: linear-gradient(135deg, #e17055 0%, #fd79a8 100%); color: white; border: none; padding: 8px 16px; border-radius: 4px; text-decoration: none; margin-left: 5px; box-shadow: 0 2px 4px rgba(225, 112, 85, 0.3);">
                                    <i class="icon-bar-chart" style="font-size: 11px;"></i> Reports
                                </a>
                            </div>
                        </div>
                        <div class="widget-content">
                    
                            <!-- Standardized Flash Messages -->
                            <?php if($this->session->flashdata('success') || $this->session->flashdata('msg')){?>
                            <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Success!</strong> <?php echo $this->session->flashdata('success') ?: $this->session->flashdata('msg'); ?>
                            </div>
                            <?php }?>
                            
                            <?php if($this->session->flashdata('error') || $this->session->flashdata('msg_w')){?>
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?: $this->session->flashdata('msg_w'); ?>
                            </div>
                            <?php }?>

                            <!-- Professional Filter Panel -->
                            <div class="widget widget-filter-panel" style="margin-bottom: 25px;">
                                <div class="widget-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-bottom: 2px solid #667eea; padding: 15px 20px; border-radius: 7px 7px 0 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <h4 style="margin: 0; color: #ffffff; font-size: 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;"><i class="icon-filter" style="color: #ffffff; margin-right: 8px; font-size: 12px;"></i> Production Filters</h4>
                                    <div class="widget-toolbar">
                                        <a href="#" id="toggle-filters" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 6px 10px; border-radius: 4px; text-decoration: none; transition: all 0.3s ease; font-size: 12px; display: inline-flex; align-items: center; justify-content: center;" title="Toggle Filters">
                                            <i class="icon-chevron-up" style="font-size: 14px; transition: transform 0.3s ease;"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="widget-content" id="filter-content">
                                    <form id="production_search_form" action="<?php echo site_url("admin/production/admsearch_production");?>" 
                                        method="post" class="form-horizontal">
                                        
                                        <!-- Simplified Filter Layout -->
                                        <table style="width: 100%; border-collapse: separate; border-spacing: 20px 0;">
                                            <tr>
                                                <!-- Start Date -->
                                                <td style="width: 30%; vertical-align: top;">
                                                    <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #333; font-size: 13px;">
                                                        <i class="icon-calendar" style="color: #007bff; margin-right: 6px; font-size: 11px;"></i>Start Date
                                                    </label>
                                                    <div style="display: flex; align-items: stretch; width: 100%;">
                                                        <span style="background: #f8f9fa; border: 1px solid #ced4da; border-right: none; padding: 8px 10px; border-radius: 4px 0 0 4px; color: #6c757d; display: flex; align-items: center; justify-content: center; min-width: 38px;">
                                                            <i class="icon-calendar" style="font-size: 11px;"></i>
                                                        </span>
                                                        <input type="text" id="start_date" name="start_date" 
                                                            value="<?php echo $start_date; ?>"
                                                            class="date-picker" readonly
                                                            placeholder="Select Start Date"
                                                            style="border: 1px solid #ced4da; border-radius: 0 4px 4px 0; padding: 8px 12px; flex: 1; font-size: 13px; height: auto;">
                                                    </div>
                                                </td>
                                                
                                                <!-- End Date -->
                                                <td style="width: 30%; vertical-align: top;">
                                                    <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #333; font-size: 13px;">
                                                        <i class="icon-calendar" style="color: #007bff; margin-right: 6px; font-size: 11px;"></i>End Date
                                                    </label>
                                                    <div style="display: flex; align-items: stretch; width: 100%;">
                                                        <span style="background: #f8f9fa; border: 1px solid #ced4da; border-right: none; padding: 8px 10px; border-radius: 4px 0 0 4px; color: #6c757d; display: flex; align-items: center; justify-content: center; min-width: 38px;">
                                                            <i class="icon-calendar" style="font-size: 11px;"></i>
                                                        </span>
                                                        <input type="text" id="end_date" name="end_date" 
                                                            value="<?php echo $end_date; ?>"
                                                            class="date-picker" readonly
                                                            placeholder="Select End Date"
                                                            style="border: 1px solid #ced4da; border-radius: 0 4px 4px 0; padding: 8px 12px; flex: 1; font-size: 13px; height: auto;">
                                                    </div>
                                                </td>

                                                <!-- Status Filter -->
                                                <td style="width: 25%; vertical-align: top;">
                                                    <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #333; font-size: 13px;">
                                                        <i class="icon-flag" style="color: #007bff; margin-right: 6px; font-size: 11px;"></i>Status
                                                    </label>
                                                    <select name="status_filter" id="status_filter" class="chosen-select" 
                                                        style="width: 100%; border: 1px solid #ced4da; padding: 8px 12px; border-radius: 4px; font-size: 13px; background: #fff;">
                                                        <option value="">All Status</option>
                                                        <option value="0" <?php echo (isset($status_filter) && $status_filter === '0') ? 'selected' : ''; ?>>Pending</option>
                                                        <option value="1" <?php echo (isset($status_filter) && $status_filter === '1') ? 'selected' : ''; ?>>Approved</option>
                                                    </select>
                                                </td>
                                                
                                                <!-- Action Buttons -->
                                                <td style="width: 15%; vertical-align: top;">
                                                    <label style="display: block; margin-bottom: 8px; font-weight: bold; color: transparent; font-size: 13px;">Actions</label>
                                                    <div style="display: flex; gap: 5px;">
                                                        <button type="submit" class="btn" style="background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%); color: white; border: none; padding: 8px 12px; font-size: 12px; border-radius: 4px; box-shadow: 0 2px 4px rgba(108, 92, 231, 0.3);">
                                                            <i class="icon-search" style="font-size: 11px;"></i> Search
                                                        </button>
                                                        <button type="button" id="clear-filters" class="btn" style="background: linear-gradient(135deg, #636e72 0%, #74b9ff 100%); color: white; border: none; padding: 8px 10px; font-size: 12px; border-radius: 4px; box-shadow: 0 2px 4px rgba(99, 110, 114, 0.3);">
                                                            <i class="icon-refresh" style="font-size: 11px;"></i> Reset
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Filter Summary -->
                                        <div class="filter-summary-container" id="filter-summary">
                                            <div class="filter-summary-content">
                                                <div class="alert alert-info filter-summary-alert">
                                                    <div class="summary-info">
                                                        <i class="icon-info-sign" style="font-size: 11px;"></i>
                                                        <strong>Active Filters:</strong>
                                                        <span id="summary-text"></span>
                                                    </div>
                                                    <div class="summary-actions">
                                                        <button type="button" class="btn btn-mini" id="clear-all-filters">
                                                            <i class="icon-remove" style="font-size: 11px;"></i> Clear All
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            <!-- Standardized Data Table -->
                            <div class="table-responsive">
                                <table id="listingTable" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Sheet No.</th>
                                            <?php foreach ($products as $pm){?>
                                            <th class="text-center"><?php echo $pm['name'];?></th>
                                            <?php }?>
                                            <th class="text-center">Actions</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $sequence = 1; foreach ($production as $fm){
                                        $allitem = $fm['allitem'];
                                        ?>
                                        <tr class="<?php echo ($fm['status'] == 1) ? 'row-approved' : 'row-pending'; ?>">
                                            <td class="text-center"><?php echo $sequence++;?></td>
                                            <td class="text-center"><?php echo date('d-m-Y', strtotime($fm['date']));?></td>
                                            <td class="text-center"><strong><?php echo $fm['sheet_no'];?></strong></td>
                                            <?php foreach ($products as $pm){?>
                                            <td class="text-center">
                                                <?php 
                                                $found = false;
                                                foreach($allitem as $item) {
                                                    if($item['product_id'] == $pm['id']) {
                                                        echo '<span class="badge badge-success">' . number_format($item['stock'], 0) . '</span>';
                                                        $found = true;
                                                        break;
                                                    }
                                                }
                                                if(!$found) echo '<span class="badge">0</span>';
                                                ?>
                                            </td>
                                            <?php }?>
                                            <td class="text-center">
                                               
                                                    <a href="<?php echo site_url('admin/production/edit_production/'.$fm['id']); ?>" 
                                                       title="Edit Production" style="background: none; border: none; padding: 4px; color: #007bff; cursor: pointer;">
                                                        <i class="icon-edit" style="font-size: 15px;"></i>
                                                    </a>
                                                    <a href="<?php echo site_url('admin/production/view_production/'.$fm['id']); ?>" 
                                                       title="View Details" style="background: none; border: none; padding: 4px; color: #17a2b8; cursor: pointer;">
                                                        <i class="icon-eye-open" style="font-size: 15px;"></i>
                                                    </a>
                                                    <a onclick="confirmDelete(<?php echo $fm['id']; ?>)" 
                                                       title="Delete Production" style="background: none; border: none; padding: 4px; color: #dc3545; cursor: pointer;">
                                                        <i class="icon-trash" style="font-size: 15px;"></i>
                                                    </a>
                                                
                                            </td>
                                            <td class="text-center">
                                                <?php if($fm['status'] == 1){?>
                                                    <span class="badge badge-success"><i class="icon-check" style="font-size: 11px;"></i> Approved</span>
                                                <?php } else {?>
                                                    <a href="javascript:void(0);" onclick="confirmApprove(<?php echo $fm['id']; ?>)" title="Approve Production" style="color: #e17055; text-decoration: underline; font-weight: 600; font-size: 13px; background: none; border: none; padding: 0;">
                                                        <i class="icon-time" style="font-size: 11px; color: #e17055;"></i> Approve
                                                    </a>
                                                <?php }?>
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript will be loaded in footer -->

<style>
/* Production-Specific Styles - Enhanced Filter Panel Design */

/* Production row status indicators */
.row-approved {
    background-color: rgba(40, 167, 69, 0.05) !important;
}

.row-pending {
    background-color: rgba(255, 193, 7, 0.05) !important;
}

/* Badge styling for quantities */
.badge {
    display: inline-block;
    padding: 0.25em 0.6em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.375rem;
    background-color: #6c757d;
    color: #fff;
}

.badge-success {
    background-color: #28a745;
}

/* Table button spacing */
.btn-sm {
    margin: 1px;
}

/* Widget Header Styling - Matching Table Headers */
.widget {
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    overflow: hidden;
}

.widget .widget-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 2px solid #dee2e6;
    border-radius: 7px 7px 0 0;
    padding: 15px 20px;
    position: relative;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.widget .widget-header h3,
.widget .widget-header h4 {
    margin: 0;
    color: #495057;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
}

.widget .widget-header h3 {
    font-size: 18px;
}

.widget .widget-header h4 {
    font-size: 16px;
}

.widget .widget-header h3 i,
.widget .widget-header h4 i {
    color: #007bff;
    margin-right: 8px;
    font-size: 16px;
}

/* Filter Panel Styling */
.widget-filter-panel {
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    overflow: visible !important;
}

.widget-toolbar {
    position: static;
    transform: none;
}

.widget-filter-panel .widget-content {
    padding: 25px;
    background: #fafbfc;
    overflow: visible !important;
}

/* Clean Filter Layout Styles */
.date-picker {
    background: #fff !important;
    cursor: pointer !important;
}

.date-picker:focus {
    border-color: #007bff !important;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3) !important;
    outline: none !important;
}

.btn:hover {
    opacity: 0.8;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
    color: #fff;
}

.date-preset {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    color: #495057;
}

.date-preset:hover,
.date-preset.active {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
}

/* Chosen select overrides */
.chosen-container {
    font-size: 13px;
    z-index: 1000 !important;
}

.chosen-container-single .chosen-single {
    height: auto;
    min-height: 36px;
    line-height: 1.5;
    border: 1px solid #ced4da;
    border-radius: 4px;
    background: #fff;
    padding: 6px 12px;
}

.chosen-container .chosen-drop {
    z-index: 1001 !important;
    border: 1px solid #ced4da;
    border-radius: 4px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.chosen-container .chosen-results {
    max-height: 300px;
    overflow-y: auto;
    padding: 8px 0;
}

.chosen-container .chosen-results li {
    padding: 8px 12px;
    line-height: 1.5;
    white-space: normal;
}

.chosen-container .chosen-results li.highlighted {
    background-color: #007bff;
    color: #fff;
}

/* Form Control Enhancements */
.control-group {
    margin-bottom: 0;
    width: 100%;
}

.control-label {
    font-weight: 600;
    color: #555;
    margin-bottom: 8px;
    display: block;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.control-label i {
    color: #007bff;
    margin-right: 6px;
    width: 14px;
    text-align: center;
    font-size: 13px;
}

.controls {
    position: relative;
    width: 100%;
}

/* Form Control Consistency */
.control-group {
    margin-bottom: 15px;
}

.filter-select {
    width: 100% !important;
    min-width: 120px;
}

/* Filter Summary Styling */
.filter-summary-container {
    margin-top: 20px;
    display: none;
    width: 100%;
}

.filter-summary-content {
    width: 100%;
}

.filter-summary-alert {
    background: #e3f2fd;
    border: 1px solid #bbdefb;
    color: #1565c0;
    border-radius: 6px;
    padding: 12px 15px;
    margin: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.summary-info {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 8px;
}

.summary-actions {
    flex-shrink: 0;
}

/* Ensure proper spacing */
.widget-content .row-fluid + .row-fluid {
    margin-top: 0;
}

.widget-content .control-group:last-child {
    margin-bottom: 0;
}

/* Input Styling */
.input-prepend {
    display: flex;
    width: 100%;
    align-items: stretch;
}

.input-prepend .add-on {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 1px solid #ced4da;
    color: #6c757d;
    padding: 9px 12px;
    border-radius: 4px 0 0 4px;
    font-size: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    border-right: none;
}

.input-prepend input {
    border: 1px solid #ced4da;
    border-left: none;
    border-radius: 0 4px 4px 0;
    padding: 9px 12px;
    font-size: 13px;
    flex: 1;
    min-width: 0;
    height: auto;
    line-height: 1.4;
}

.input-prepend input:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.1);
    outline: none;
    z-index: 2;
    position: relative;
}

.input-prepend input:focus + .add-on {
    border-color: #007bff;
}

.date-picker {
    background: #fff !important;
    cursor: pointer !important;
}

/* Consistent input heights */
.input-small, .input-medium, .filter-select {
    height: 38px;
    padding: 9px 12px;
    font-size: 13px;
    line-height: 1.4;
    border: 1px solid #ced4da;
    border-radius: 4px;
    background: #fff;
    transition: all 0.2s ease;
}

.input-small:focus, .input-medium:focus, .filter-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.1);
    outline: none;
}

/* Ensure all form elements align properly */
.controls > * {
    vertical-align: top;
}

/* Button alignment */
.btn {
    height: 38px;
    padding: 9px 16px;
    font-size: 13px;
    line-height: 1.4;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    text-decoration: none;
    transition: all 0.2s ease;
    border-radius: 4px;
    border: 1px solid transparent;
    cursor: pointer;
}

.btn-small {
    height: 34px;
    padding: 7px 12px;
    font-size: 12px;
}

.btn-mini {
    height: 30px;
    padding: 5px 10px;
    font-size: 11px;
}

/* Button Group Styling */
.btn-group .btn {
    margin-right: 5px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.date-preset {
    background: #fff;
    border: 1px solid #ced4da;
    color: #6c757d;
    transition: all 0.2s ease;
}

.date-preset:hover,
.date-preset.active {
    background: #007bff;
    border-color: #007bff;
    color: #fff;
}

/* Select Styling */
select.input-small,
select.input-medium {
    padding: 6px 8px;
    font-size: 14px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    background: #fff;
}

/* Chosen Select Overrides */
.chosen-container {
    font-size: 14px;
    z-index: 1000 !important;
}

.chosen-container-single .chosen-single {
    height: auto;
    min-height: 36px;
    line-height: 1.5;
    border: 1px solid #ced4da;
    border-radius: 4px;
    background: #fff;
    padding: 6px 12px;
}

.chosen-container .chosen-drop {
    z-index: 1001 !important;
    border: 1px solid #ced4da;
    border-radius: 4px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.chosen-container .chosen-results {
    max-height: 300px;
    overflow-y: auto;
    padding: 8px 0;
}

.chosen-container .chosen-results li {
    padding: 8px 12px;
    line-height: 1.5;
    white-space: normal;
}

.chosen-container .chosen-results li.highlighted {
    background-color: #007bff;
    color: #fff;
}

/* Filter Summary Styling */
#filter-summary .alert {
    background: #e3f2fd;
    border: 1px solid #bbdefb;
    color: #1565c0;
    border-radius: 6px;
    padding: 10px 15px;
    margin: 0;
}

#filter-summary .alert .btn {
    padding: 2px 8px;
    font-size: 11px;
    line-height: 1.4;
}

/* Animation for collapsible filter */
#filter-content {
    transition: all 0.3s ease;
    overflow: hidden;
}

#filter-content.collapsed {
    height: 0;
    padding: 0 20px;
}

/* Enhanced Toggle Button Styling */
#toggle-filters {
    background: rgba(255,255,255,0.2) !important;
    color: white !important;
    border: 1px solid rgba(255,255,255,0.3) !important;
    padding: 6px 10px !important;
    border-radius: 4px !important;
    text-decoration: none !important;
    transition: all 0.3s ease !important;
    font-size: 12px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    min-width: 32px !important;
    height: 28px !important;
}

#toggle-filters:hover {
    background: rgba(255,255,255,0.3) !important;
    border-color: rgba(255,255,255,0.5) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2) !important;
}

#toggle-filters:active {
    transform: translateY(0) !important;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1) !important;
}

#toggle-filters i {
    transition: transform 0.3s ease !important;
    font-size: 14px !important;
    color: white !important;
}

#toggle-filters.collapsed i {
    transform: rotate(180deg) !important;
}

/* Enhanced button styling */
.btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border: none;
    box-shadow: 0 2px 4px rgba(0,123,255,0.3);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
    box-shadow: 0 4px 8px rgba(0,123,255,0.4);
    transform: translateY(-1px);
}

.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
    border: none;
    box-shadow: 0 2px 4px rgba(40,167,69,0.3);
}

.btn-success:hover {
    background: linear-gradient(135deg, #1e7e34 0%, #155724 100%);
    box-shadow: 0 4px 8px rgba(40,167,69,0.4);
    transform: translateY(-1px);
}

/* Responsive Design for Mobile */
@media (max-width: 768px) {
    /* Stack table cells vertically on mobile */
    table[style*="border-spacing"] {
        display: block !important;
        width: 100% !important;
    }
    
    table[style*="border-spacing"] tr {
        display: block !important;
        margin-bottom: 15px !important;
    }
    
    table[style*="border-spacing"] td {
        display: block !important;
        width: 100% !important;
        margin-bottom: 15px !important;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px !important;
    }
    
    /* Date range mobile layout */
    td div[style*="white-space: nowrap"] {
        white-space: normal !important;
    }
    
    .input-prepend {
        display: block !important;
        margin: 5px 0 !important;
        width: 100% !important;
    }
    
    .input-prepend input {
        width: calc(100% - 50px) !important;
    }
    
    /* Button mobile layout */
    .date-preset {
        display: block !important;
        width: 100% !important;
        margin: 3px 0 !important;
        text-align: center !important;
    }
    
    button[style*="margin-right"] {
        display: block !important;
        width: 100% !important;
        margin: 5px 0 !important;
    }
    
    /* Select mobile styling */
    select {
        width: 100% !important;
        max-width: 100% !important;
    }
}

@media (max-width: 768px) {
    .widget-filter-panel .widget-content {
        padding: 20px 15px;
    }
    
    .widget-filter-panel .widget-header {
        padding: 12px 15px;
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }
    
    .filter-row {
        gap: 12px;
    }
    
    .filter-row-secondary {
        margin-top: 20px;
        padding-top: 15px;
    }
    
    .quick-date-buttons .btn {
        min-width: 70px;
        font-size: 10px;
        padding: 5px 6px;
    }
    
    .filter-summary-alert {
        flex-direction: column;
        align-items: stretch;
        text-align: center;
        gap: 12px;
    }
    
    .summary-actions {
        align-self: center;
    }
}

@media (max-width: 480px) {
    .widget-filter-panel .widget-content {
        padding: 15px 10px;
    }
    
    .quick-date-buttons {
        flex-direction: column;
        gap: 6px;
    }
    
    .quick-date-buttons .btn {
        width: 100%;
        min-width: auto;
    }
    
    .action-buttons-container {
        flex-direction: column;
        gap: 6px;
    }
    
    .btn-filter-action {
        width: 100%;
        min-width: auto;
    }
    
    .date-range-container .input-prepend {
        width: 100%;
    }
    
    .date-range-container .input-prepend input {
        width: calc(100% - 40px);
    }
}

/* Hide DataTables Processing Overlay Completely */
.dataTables_processing {
    display: none !important;
    visibility: hidden !important;
    opacity: 0 !important;
    height: 0 !important;
    width: 0 !important;
    position: absolute !important;
    z-index: -1 !important;
}

.dataTables_wrapper .dataTables_processing {
    display: none !important;
    visibility: hidden !important;
}

/* Hide any loading overlays */
.loading-overlay,
.dt-processing,
.processing {
    display: none !important;
}

/* Ensure table displays properly without overlays */
.dataTables_wrapper {
    position: relative;
}

.dataTables_wrapper table {
    clear: both;
    margin-top: 6px !important;
    margin-bottom: 6px !important;
    max-width: none !important;
    border-collapse: separate !important;
}

/* DataTables Pagination Fix */
.dataTables_wrapper .dataTables_paginate {
    float: right;
    text-align: right;
    padding-top: 0.25em;
    margin-top: 15px !important;
    display: block !important;
}

.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_processing,
.dataTables_wrapper .dataTables_paginate {
    color: #333;
    display: block !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius: 2px;
    padding: 6px 12px;
    margin-left: 2px;
    display: inline-block;
    cursor: pointer;
    color: #333 !important;
    border: 1px solid transparent;
    line-height: 1.42857143;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    background-color: #337ab7;
    border-color: #337ab7;
    color: white !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background-color: #eee;
    border-color: #ddd;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
    cursor: default;
    color: #777 !important;
    border: 1px solid transparent;
    background: transparent;
}

.dataTables_wrapper .dataTables_info {
    padding-top: 8px;
    white-space: nowrap;
    margin-top: 15px !important;
    float: left;
}

/* Loading state */
.loading .widget-content {
    position: relative;
    pointer-events: none;
}

.loading .widget-content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255,255,255,0.8);
    z-index: 10;
}

.loading .widget-content::after {
    content: 'Loading...';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #007bff;
    color: white;
    padding: 10px 20px;
    border-radius: 4px;
    z-index: 11;
    font-size: 14px;
}

/* Ensure Chosen dropdown always appears on top */
.chosen-container.chosen-container-active .chosen-drop {
    z-index: 9999 !important;
}

.chosen-container .chosen-drop {
    z-index: 9999 !important;
    position: absolute;
}

.widget-filter-panel {
    position: relative;
}

.widget-filter-panel .widget-content {
    position: relative;
}
</style>

<script>
// Ensure jQuery compatibility with existing menu functionality
(function($) {
    'use strict';
    
    // Store original jQuery to preserve menu functionality
    if (window.jQuery && window.jQuery !== $) {
        window.$original = window.jQuery;
    }
    
    $(document).ready(function() {
        console.log('DOM ready, initializing DataTable...');
    
    // Simple DataTable initialization
    var table = $('#listingTable').DataTable({
        "dom": '<"top"Bl>rt<"bottom"ip><"clear">',
        "buttons": [
            {
                extend: 'copy',
                text: '<i class="fa fa-copy"></i> Copy',
                className: 'btn btn-success btn-sm'
            },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i> Excel',
                    className: 'btn btn-success btn-sm'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf-o"></i> PDF',
                    className: 'btn btn-success btn-sm'
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Print',
                    className: 'btn btn-success btn-sm'
                }
            ],
            "paging": true,
            "pageLength": 25,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "order": [[ 1, "desc" ]],
            "columnDefs": [
                {
                    "targets": -1,
                    "orderable": false
                }
            ],
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search production records...",
                "lengthMenu": "Show _MENU_ entries",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                }
            },
            "responsive": true,
        "autoWidth": false,
        "stateSave": true,
        "processing": false,
        "initComplete": function(settings, json) {
            console.log('DataTable initialization complete');
            console.log('Pagination info:', this.api().page.info());
            
            // Force pagination display
            $('.dataTables_paginate').show();
            $('.dataTables_info').show();
            $('.dataTables_length').show();
            
            // Hide any processing overlays
            $('.dataTables_processing').hide();
            $('body').removeClass('dt-processing');
            
            // Restore original jQuery for menu compatibility
            if (window.$original) {
                window.jQuery = window.$original;
                window.$ = window.$original;
            }
        }
    });
        
    console.log('DataTable initialized successfully');
    
    // Form submission handler
    $('#production_search_form').on('submit', function(e) {
        e.preventDefault();
        window.location.href = $(this).attr('action') + '?' + $(this).serialize();
    });
    
    // Enhanced Filter Panel Functionality
    
    // Toggle filter panel collapse
    $('#toggle-filters').on('click', function(e) {
            e.preventDefault();
            var $content = $('#filter-content');
            var $button = $(this);
        
        if ($content.hasClass('collapsed')) {
            $content.removeClass('collapsed');
            $button.removeClass('collapsed');
            $button.find('i').removeClass('icon-chevron-down').addClass('icon-chevron-up');
        } else {
            $content.addClass('collapsed');
            $button.addClass('collapsed');
            $button.find('i').removeClass('icon-chevron-up').addClass('icon-chevron-down');
        }
    });
    
    // Enhanced Date Picker with better UX - with error handling
    var $datePickers = $("#start_date, #end_date");
    if ($datePickers.length > 0) {
        $datePickers.datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
            showAnim: 'fadeIn',
            showButtonPanel: true,
            closeText: 'Clear',
            beforeShow: function(input, inst) {
                setTimeout(function() {
                    inst.dpDiv.css({
                        'box-shadow': '0 10px 25px rgba(0,0,0,0.2)',
                        'border-radius': '6px',
                        'border': '1px solid #007bff'
                    });
                }, 1);
            },
            onSelect: function() {
                try {
                    updateFilterSummary();
                } catch (e) {
                    console.log('Error updating filter summary:', e);
                }
            }
        });
    }
    
    // Quick date presets functionality
    $('.date-preset').on('click', function(e) {
        e.preventDefault();
        var days = parseInt($(this).data('days'));
        var endDate = new Date();
        var startDate = new Date();
        
        if (days === 0) {
            // Today only
            startDate = endDate;
        } else {
            // Last N days
            startDate.setDate(endDate.getDate() - days);
        }
        
        var formatDate = function(date) {
            var dd = String(date.getDate()).padStart(2, '0');
            var mm = String(date.getMonth() + 1).padStart(2, '0');
            var yyyy = date.getFullYear();
            return dd + '-' + mm + '-' + yyyy;
        };
        
        $('#start_date').val(formatDate(startDate));
        $('#end_date').val(formatDate(endDate));
        
        // Update button states
        $('.date-preset').removeClass('active');
        $(this).addClass('active');
        
            updateFilterSummary();
        });
        
        // Clear filters functionality
        $('#clear-filters, #clear-all-filters').on('click', function(e) {
        e.preventDefault();
        $('#production_search_form')[0].reset();
        $('.date-preset').removeClass('active');
        $('.chosen-select').val('').trigger('chosen:updated');
        $('#filter-summary').slideUp();
        
        // Add visual feedback
        var $btn = $(this);
        var originalText = $btn.html();
        $btn.html('<i class="icon-spinner icon-spin"></i> Clearing...');
        
        setTimeout(function() {
            $btn.html(originalText);
            window.location.href = '<?php echo site_url('admin/production'); ?>';
            }, 500);
        });
        
    // Enhanced Chosen dropdown initialization - with error handling
    var $chosenSelects = $(".chosen-select");
    if ($chosenSelects.length > 0) {
        $chosenSelects.chosen({
            width: "100%",
            placeholder_text_single: "Select an option",
            no_results_text: "No results matched",
            allow_single_deselect: true
        }).change(function() {
            try {
                updateFilterSummary();
            } catch (e) {
                console.log('Error updating filter summary:', e);
            }
        });
    }        // Records per page change
        $('#per_page').on('change', function() {
            var pageLength = $(this).val();
            if (pageLength == -1) {
                pageLength = 9999999; // Show all
            }
            table.page.len(parseInt(pageLength)).draw();
        });
        
        // Export functionality
        $('#export-results').on('click', function(e) {
        e.preventDefault();
        var $btn = $(this);
        var originalText = $btn.html();
        
        $btn.html('<i class="icon-spinner icon-spin"></i> Exporting...').prop('disabled', true);
        
        // Trigger DataTables Excel export
        if (table.button) {
            table.button('.buttons-excel').trigger();
        }
        
        setTimeout(function() {
            $btn.html(originalText).prop('disabled', false);
            }, 2000);
        });
        
        // Form submission with loading state
        $('#production_search_form').on('submit', function(e) {
            var $form = $(this);
            var $submitBtn = $form.find('button[type="submit"]');
            var originalText = $submitBtn.html();
            
            $submitBtn.html('<i class="icon-spinner icon-spin"></i> Searching...').prop('disabled', true);
            $form.closest('.widget').addClass('loading');
            
            // Allow form to submit normally
            // Loading state will be cleared by page reload
        });
        
    // Filter summary update function
    function updateFilterSummary() {
        var summary = [];
        var $summary = $('#filter-summary');
        
        // Check if summary element exists
        if ($summary.length === 0) {
            return;
        }
        
        // Check date range with null checks
        var $startDate = $('#start_date');
        var $endDate = $('#end_date');
        var startDate = $startDate.length ? $startDate.val() : '';
        var endDate = $endDate.length ? $endDate.val() : '';
        
        if (startDate && endDate) {
            summary.push('Date: ' + startDate + ' to ' + endDate);
        } else if (startDate) {
            summary.push('Start Date: ' + startDate);
        } else if (endDate) {
            summary.push('End Date: ' + endDate);
        }
        
        // Check status filter with null check
        var $statusFilter = $('#status_filter');
        if ($statusFilter.length) {
            var status = $statusFilter.val();
            if (status && status !== '') {
                var statusText = status === '1' ? 'Approved' : 'Pending';
                summary.push('Status: ' + statusText);
            }
        }
        
        // Update summary display
        if (summary.length > 0) {
            var $summaryText = $('#summary-text');
            if ($summaryText.length) {
                $summaryText.html(summary.join(', '));
            }
            $summary.slideDown();
        } else {
            $summary.slideUp();
        }
    }    // Initialize filter summary on page load - with error handling
    try {
        updateFilterSummary();
    } catch (e) {
        console.log('Error initializing filter summary:', e);
    }
    
    // Auto-hide flash messages with fade effect
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
    
    }); // End document ready
    
})(jQuery); // End jQuery compatibility wrapper// Global functions that need to be accessible from HTML onclick events
function confirmDelete(productionId) {
    if (confirm('Are you sure you want to delete this production record?')) {
        window.location.href = '<?php echo site_url('admin/production/delete_production/'); ?>' + productionId;
    }
}

function confirmApprove(productionId) {
    if (confirm('Are you sure you want to approve this production?')) {
        window.location.href = '<?php echo site_url('admin/production/approve_production/'); ?>' + productionId;
    }
}
</script>
