<div class="main">
  <div class="main-inner">
    <div class="container">
      
      <!-- Page Header -->
      <div class="row">
        <div class="span12">
          <div class="widget">
            <div class="widget-header">
              <i class="icon-file-text"></i>
              <h3>System Logs</h3>
            </div>
            <div class="widget-content">
              <p class="text-muted">Monitor system activity and troubleshoot issues with detailed logs.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Log Files List and Content -->
      <div class="row">
        <div class="span4">
          <div class="widget">
            <div class="widget-header">
              <i class="icon-list"></i>
              <h3>Available Log Files</h3>
            </div>
            <div class="widget-content">
              <?php if (!empty($log_files)): ?>
              <ul class="nav nav-list">
                <?php foreach ($log_files as $file): ?>
                <li class="<?php echo ($selected_log == $file) ? 'active' : ''; ?>">
                  <a href="?file=<?php echo urlencode($file); ?>">
                    <i class="icon-file"></i> <?php echo $file; ?>
                  </a>
                </li>
                <?php endforeach; ?>
              </ul>
              <?php else: ?>
              <p class="text-muted">No log files found.</p>
              <?php endif; ?>
              
              <div class="form-actions" style="margin: 0; padding-top: 15px; border-top: 1px solid #ddd;">
                <a href="<?php echo site_url('admin/auth'); ?>" class="btn btn-default">
                  <i class="icon-arrow-left"></i> Back to Admin Panel
                </a>
              </div>
            </div>
          </div>
        </div>
        
        <div class="span8">
          <div class="widget">
            <div class="widget-header">
              <i class="icon-eye-open"></i>
              <h3>Log Content</h3>
              <?php if ($selected_log): ?>
              <div class="widget-buttons">
                <span class="label label-info"><?php echo $selected_log; ?></span>
              </div>
              <?php endif; ?>
            </div>
            <div class="widget-content">
              <?php if ($selected_log && $log_content): ?>
              <div style="background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 15px;">
                <pre style="background: none; border: none; margin: 0; max-height: 400px; overflow-y: auto; font-size: 12px; line-height: 1.4;"><?php echo htmlspecialchars($log_content); ?></pre>
              </div>
              <?php elseif ($selected_log): ?>
              <div class="alert alert-warning">
                <i class="icon-warning-sign"></i> Log file is empty or could not be read.
              </div>
              <?php else: ?>
              <div class="alert alert-info">
                <i class="icon-info-sign"></i> Select a log file from the left panel to view its contents.
              </div>
              <?php endif; ?>
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
  position: relative;
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

.widget-buttons {
  position: absolute;
  top: 15px;
  right: 20px;
}

.widget-content {
  background: white;
  border-radius: 0 0 8px 8px;
  padding: 20px;
}

.nav-list > li > a {
  padding: 8px 15px;
  border-radius: 4px;
}

.nav-list > .active > a {
  background: #667eea;
  color: white;
}

.text-muted {
  color: #6c757d;
}

.alert {
  border-radius: 6px;
}

.form-actions {
  background: transparent;
  border: none;
  margin: 0;
  padding: 0;
}
</style>