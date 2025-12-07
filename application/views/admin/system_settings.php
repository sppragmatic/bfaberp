<div class="main">
  <div class="main-inner">
    <div class="container">
      
      <!-- Page Header -->
      <div class="row">
        <div class="span12">
          <div class="widget">
            <div class="widget-header">
              <i class="icon-wrench"></i>
              <h3>System Settings</h3>
            </div>
            <div class="widget-content">
              <?php if($this->session->flashdata('message')): ?>
              <div class="alert alert-success">
                <?php echo $this->session->flashdata('message'); ?>
              </div>
              <?php endif; ?>
              
              <p class="text-muted">Configure your ERP system settings and company information.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Settings Form -->
      <div class="row">
        <div class="span12">
          <div class="widget">
            <div class="widget-header">
              <i class="icon-edit"></i>
              <h3>Company Information</h3>
            </div>
            <div class="widget-content">
              <?php echo form_open('admin/admin/system_settings', array('class' => 'form-horizontal')); ?>
              
              <div class="control-group">
                <label class="control-label" for="company_name">Company Name</label>
                <div class="controls">
                  <input type="text" id="company_name" name="company_name" 
                         value="<?php echo isset($settings['company_name']) ? $settings['company_name'] : ''; ?>" 
                         class="span6" placeholder="Enter company name">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="company_address">Company Address</label>
                <div class="controls">
                  <textarea id="company_address" name="company_address" 
                            class="span6" rows="3" placeholder="Enter company address"><?php echo isset($settings['company_address']) ? $settings['company_address'] : ''; ?></textarea>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="company_phone">Phone Number</label>
                <div class="controls">
                  <input type="text" id="company_phone" name="company_phone" 
                         value="<?php echo isset($settings['company_phone']) ? $settings['company_phone'] : ''; ?>" 
                         class="span6" placeholder="Enter phone number">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="company_email">Email Address</label>
                <div class="controls">
                  <input type="email" id="company_email" name="company_email" 
                         value="<?php echo isset($settings['company_email']) ? $settings['company_email'] : ''; ?>" 
                         class="span6" placeholder="Enter email address">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="tax_rate">Default Tax Rate (%)</label>
                <div class="controls">
                  <input type="number" id="tax_rate" name="tax_rate" 
                         value="<?php echo isset($settings['tax_rate']) ? $settings['tax_rate'] : '18'; ?>" 
                         class="span2" min="0" max="100" step="0.01">
                  <span class="help-inline">Default GST/Tax rate for calculations</span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="currency_symbol">Currency Symbol</label>
                <div class="controls">
                  <input type="text" id="currency_symbol" name="currency_symbol" 
                         value="<?php echo isset($settings['currency_symbol']) ? $settings['currency_symbol'] : '₹'; ?>" 
                         class="span1" maxlength="3">
                  <span class="help-inline">Symbol used for currency display</span>
                </div>
              </div>

              <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                  <i class="icon-save icon-white"></i> Save Settings
                </button>
                <a href="<?php echo site_url('admin/auth'); ?>" class="btn">
                  <i class="icon-arrow-left"></i> Back to Admin Panel
                </a>
              </div>
              
              <?php echo form_close(); ?>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<style>
.widget {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  margin-bottom: 20px;
}

.widget-header {
  background: rgba(255,255,255,0.1);
  border-radius: 8px 8px 0 0;
  padding: 15px 20px;
  border-bottom: 1px solid rgba(255,255,255,0.2);
}

.widget-header h3 {
  color: white;
  margin: 0;
  font-weight: 600;
  text-shadow: 0 1px 2px rgba(0,0,0,0.3);
}

.widget-header i {
  color: white;
  margin-right: 8px;
}

.widget-content {
  background: white;
  border-radius: 0 0 8px 8px;
  padding: 20px;
}

.control-group {
  margin-bottom: 18px;
}

.control-label {
  font-weight: 600;
  color: #495057;
}

.form-actions {
  background: #f5f5f5;
  border-top: 1px solid #ddd;
  margin: 20px -20px -20px -20px;
  padding: 17px 20px 18px;
  border-radius: 0 0 8px 8px;
}

.alert {
  border-radius: 6px;
}

.text-muted {
  color: #6c757d;
}
</style>