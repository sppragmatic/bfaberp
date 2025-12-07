<div class="main">
  <div class="main-inner">
    <div class="container">
      
      <!-- Page Header -->
      <div class="row">
        <div class="span12">
          <div class="widget">
            <div class="widget-header">
              <i class="icon-download-alt"></i>
              <h3>Database Backup</h3>
            </div>
            <div class="widget-content">
              <p class="text-muted">Create and manage database backups for your ERP system.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Backup Controls -->
      <div class="row">
        <div class="span8">
          <div class="widget">
            <div class="widget-header">
              <i class="icon-hdd"></i>
              <h3>Create Backup</h3>
            </div>
            <div class="widget-content">
              
              <div class="alert alert-info">
                <h4><i class="icon-info-sign"></i> Database Backup</h4>
                <p>This will create a complete backup of your ERP database including all tables and data.</p>
              </div>

              <div class="form-actions">
                <a href="<?php echo site_url('admin/backup'); ?>" class="btn btn-primary btn-large">
                  <i class="icon-download-alt icon-white"></i> Create & Download Backup
                </a>
                
                <a href="<?php echo site_url('admin/auth'); ?>" class="btn">
                  <i class="icon-arrow-left"></i> Back to Admin Panel
                </a>
              </div>
              
            </div>
          </div>
        </div>
        
        <div class="span4">
          <div class="widget">
            <div class="widget-header">
              <i class="icon-warning-sign"></i>
              <h3>Important Notes</h3>
            </div>
            <div class="widget-content">
              <h5>Before Creating Backup:</h5>
              <ul class="text-muted">
                <li>Ensure no critical operations are running</li>
                <li>Large databases may take time to backup</li>
                <li>Store backups in a secure location</li>
              </ul>
              
              <h5>Backup Information:</h5>
              <ul class="text-muted">
                <li><strong>Format:</strong> SQL (Compressed)</li>
                <li><strong>Includes:</strong> All tables & data</li>
                <li><strong>File name:</strong> SQL[date].gz</li>
              </ul>
              
              <div class="alert alert-warning">
                <small>
                  <i class="icon-exclamation-sign"></i>
                  <strong>Note:</strong> Regular backups are essential for data safety.
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