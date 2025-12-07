<div class="main">
  <div class="main-inner">
    <div class="container">
      
      <!-- Page Header -->
      <div class="row">
        <div class="span12">
          <div class="widget">
            <div class="widget-header">
              <i class="icon-warning-sign"></i>
              <h3>Maintenance Mode</h3>
            </div>
            <div class="widget-content">
              <?php if($this->session->flashdata('message')): ?>
              <div class="alert alert-success">
                <?php echo $this->session->flashdata('message'); ?>
              </div>
              <?php endif; ?>
              
              <p class="text-muted">Control site maintenance mode to perform updates and system maintenance.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Maintenance Controls -->
      <div class="row">
        <div class="span8">
          <div class="widget">
            <div class="widget-header">
              <i class="icon-cog"></i>
              <h3>Maintenance Status</h3>
            </div>
            <div class="widget-content">
              
              <div class="alert <?php echo $maintenance_active ? 'alert-error' : 'alert-success'; ?>">
                <h4>
                  <i class="<?php echo $maintenance_active ? 'icon-exclamation-sign' : 'icon-ok-sign'; ?>"></i>
                  Maintenance Mode: 
                  <strong><?php echo $maintenance_active ? 'ENABLED' : 'DISABLED'; ?></strong>
                </h4>
                <p>
                  <?php if ($maintenance_active): ?>
                    The site is currently under maintenance. Visitors will see a maintenance message.
                  <?php else: ?>
                    The site is operating normally. All users can access the system.
                  <?php endif; ?>
                </p>
              </div>

              <div class="form-actions">
                <?php echo form_open('admin/admin/maintenance'); ?>
                
                <?php if ($maintenance_active): ?>
                <button type="submit" name="action" value="disable" class="btn btn-success btn-large">
                  <i class="icon-ok icon-white"></i> Disable Maintenance Mode
                </button>
                <?php else: ?>
                <button type="submit" name="action" value="enable" class="btn btn-danger btn-large"
                        onclick="return confirm('Are you sure you want to enable maintenance mode? This will make the site unavailable to regular users.');">
                  <i class="icon-warning-sign icon-white"></i> Enable Maintenance Mode
                </button>
                <?php endif; ?>
                
                <a href="<?php echo site_url('admin/auth'); ?>" class="btn">
                  <i class="icon-arrow-left"></i> Back to Admin Panel
                </a>
                
                <?php echo form_close(); ?>
              </div>
              
            </div>
          </div>
        </div>
        
        <div class="span4">
          <div class="widget">
            <div class="widget-header">
              <i class="icon-info-sign"></i>
              <h3>Information</h3>
            </div>
            <div class="widget-content">
              <h5>What is Maintenance Mode?</h5>
              <p class="text-muted">
                When maintenance mode is enabled, regular users will see a "Site Under Maintenance" message 
                while administrators can still access the system.
              </p>
              
              <h5>When to Use:</h5>
              <ul class="text-muted">
                <li>System updates</li>
                <li>Database maintenance</li>
                <li>Server maintenance</li>
                <li>Major configuration changes</li>
              </ul>
              
              <div class="alert alert-info">
                <small>
                  <i class="icon-lightbulb"></i>
                  <strong>Tip:</strong> Always inform users in advance about planned maintenance windows.
                </small>
              </div>
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

.alert {
  border-radius: 6px;
}

.alert h4 {
  margin-bottom: 10px;
}

.text-muted {
  color: #6c757d;
}

.form-actions {
  background: #f5f5f5;
  border-top: 1px solid #ddd;
  margin: 20px -20px -20px -20px;
  padding: 17px 20px 18px;
  border-radius: 0 0 8px 8px;
}

.btn-large {
  padding: 11px 19px;
  font-size: 16px;
}
</style>