<div class="main">
  <div class="main-inner">
    <div class="container">
      <?php echo form_open(uri_string()); ?>
      
      <div class="row">
        <div class="span12">
          <div class="widget">
            <div class="widget-header">
              <i class="icon-edit"></i>
              <h3>Edit User - <?php echo htmlspecialchars($user->first_name . ' ' . $user->last_name); ?></h3>
            </div>
            <div class="widget-content">
              <div class="form-group">
                <div class="btn-toolbar pull-right" style="margin-bottom: 10px;">
                  <a href="<?php echo site_url('admin/auth'); ?>" class="btn btn-default">
                    <i class="icon-arrow-left"></i> Back to Users
                  </a>
                  <input type="submit" value="Update User" class="btn btn-primary" />
                </div>
                <div class="clearfix"></div>
                <?php if($message): ?>
                <div id="infoMessage" class="alert alert-danger">
                  <?php echo $message; ?>
                </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>



      <div class="row">
        <div class="span12">
          <div class="widget">
            <div class="widget-header">
              <i class="icon-edit"></i>
              <h3>User Information</h3>
            </div>
            <div class="widget-content">
              <div class="row-fluid">
                <div class="span6">
                  <div class="form-group">
                    <label class="control-label">First Name <span class="text-danger">*</span></label>
                    <div class="controls">
                      <?php echo form_input($first_name, '', 'class="form-control" required'); ?>
                    </div>
                  </div>
                </div>
                <div class="span6">
                  <div class="form-group">
                    <label class="control-label">Last Name <span class="text-danger">*</span></label>
                    <div class="controls">
                      <?php echo form_input($last_name, '', 'class="form-control" required'); ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row-fluid">
                <div class="span6">
                  <div class="form-group">
                    <label class="control-label">Contact Number</label>
                    <div class="controls">
                      <?php echo form_input($phone, '', 'class="form-control"'); ?>
                    </div>
                  </div>
                </div>
                <div class="span6">
                  <div class="form-group">
                    <label class="control-label">Company</label>
                    <div class="controls">
                      <?php echo form_input($company, '', 'class="form-control"'); ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row-fluid">
                <div class="span6">
                  <div class="form-group">
                    <label class="control-label">Branch</label>
                    <div class="controls">
                      <select name="branch_id" class="form-control">
                        <option value="">Select Branch</option>
                        <?php foreach($branch as $br): ?>
                          <option value="<?php echo $br->id; ?>" <?php echo (isset($user->branch_id) && $user->branch_id == $br->id) ? 'selected' : ''; ?>>
                            <?php echo $br->name; ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="span6">
                  <div class="form-group">
                    <label class="control-label">Email</label>
                    <div class="controls">
                      <input type="email" value="<?php echo $user->email; ?>" class="form-control" readonly style="background-color: #f5f5f5;">
                      <small class="help-text">Email cannot be changed</small>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row-fluid">
                <div class="span6">
                  <div class="form-group">
                    <label class="control-label">New Password</label>
                    <div class="controls">
                      <?php echo form_input($password, '', 'class="form-control" placeholder="Leave blank to keep current password"'); ?>
                      <small class="help-text">Leave blank to keep current password</small>
                    </div>
                  </div>
                </div>
                <div class="span6">
                  <div class="form-group">
                    <label class="control-label">Confirm New Password</label>
                    <div class="controls">
                      <?php echo form_input($password_confirm, '', 'class="form-control" placeholder="Confirm new password"'); ?>
                    </div>
                  </div>
                </div>
              </div>

              <?php if($this->ion_auth->is_admin()): ?>
              <div class="row-fluid">
                <div class="span12">
                  <div class="form-group">
                    <label class="control-label">User Groups</label>
                    <div class="controls">
                      <div class="checkbox-group">
                        <?php foreach ($groups as $group): ?>
                          <?php
                            $gID = $group['id'];
                            $checked = '';
                            foreach($currentGroups as $grp) {
                              if ($gID == $grp->id) {
                                $checked = ' checked="checked"';
                                break;
                              }
                            }
                          ?>
                          <label class="checkbox inline">
                            <input type="checkbox" name="groups[]" value="<?php echo $group['id']; ?>"<?php echo $checked; ?>>
                            <span class="group-label"><?php echo $group['name']; ?></span>
                          </label>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>


          	


  


     





      <?php echo form_hidden('id', $user->id); ?>
      <?php echo form_hidden($csrf); ?>
      <?php echo form_close(); ?>
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

.form-group {
  margin-bottom: 15px;
}

.control-label {
  font-weight: 600;
  color: #495057;
  margin-bottom: 5px;
  display: block;
}

.form-control, input[type="text"], input[type="email"], input[type="password"], select {
  width: 100%;
  padding: 8px 12px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 14px;
  line-height: 1.4;
  box-sizing: border-box;
}

.text-danger {
  color: #d9534f;
}

.help-text {
  color: #6c757d;
  font-size: 12px;
  margin-top: 3px;
}

.checkbox-group {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
}

.checkbox.inline {
  display: inline-flex;
  align-items: center;
  margin-right: 15px;
  margin-bottom: 8px;
}

.checkbox input[type="checkbox"] {
  width: auto;
  margin-right: 8px;
}

.group-label {
  background: #f8f9fa;
  padding: 4px 8px;
  border-radius: 3px;
  font-size: 12px;
  color: #495057;
}

.btn-toolbar {
  margin-bottom: 15px;
}

.btn-toolbar .btn {
  margin-left: 5px;
}

.alert {
  border-radius: 6px;
  margin-bottom: 15px;
}
</style>
