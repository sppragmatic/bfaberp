
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">
          <div class="widget">
            <div class="widget-header">
              <i class="icon-user"></i>
              <h3>User Management</h3>
            </div>
            <div class="widget-content">
              <div class="form-group">
                <div class="btn-toolbar pull-right" style="margin-bottom: 10px;">
                  <a href="<?php echo site_url('admin/auth/create_user'); ?>" class="btn btn-primary">
                    <i class="icon-plus icon-white"></i> Add New User
                  </a>
                  <a href="<?php echo site_url('admin/auth/create_group'); ?>" class="btn btn-success">
                    <i class="icon-group icon-white"></i> Create Group
                  </a>
                </div>
                <div class="clearfix"></div>
                <?php if($message): ?>
                <div id="infoMessage" class="alert alert-info">
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
              <i class="icon-th-list"></i>
              <h3>Users List</h3>
            </div>
            <div class="widget-content">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                  <thead>
                    <tr>
                      <th>SL NO</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Email</th>
                      <th>Groups</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $sl = 1; ?>
                    <?php foreach ($users as $user): ?>
                    <tr>
                      <td><?php echo $sl++; ?></td>
                      <td><?php echo htmlspecialchars($user->first_name); ?></td>
                      <td><?php echo htmlspecialchars($user->last_name); ?></td>
                      <td><?php echo htmlspecialchars($user->email); ?></td>
                      <td>
                        <?php foreach ($user->groups as $group): ?>
                          <span class="label label-info">
                            <?php echo anchor("admin/auth/edit_group/".$group->id, $group->name, 'class="text-white"'); ?>
                          </span>
                        <?php endforeach ?>
                      </td>
                      <td>
                        <?php if($user->active): ?>
                          <span class="label label-success">Active</span>
                        <?php else: ?>
                          <span class="label label-important">Inactive</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <div class="btn-group">
                          <a href="<?php echo site_url('admin/auth/edit_user/'.$user->id); ?>" 
                             class="btn btn-mini btn-info" title="Edit User">
                            <i class="icon-edit icon-white"></i>
                          </a>
                          <?php if($user->active): ?>
                            <a href="<?php echo site_url('admin/auth/deactivate/'.$user->id); ?>" 
                               class="btn btn-mini btn-warning" title="Deactivate User"
                               onclick="return confirm('Are you sure you want to deactivate this user?');">
                              <i class="icon-ban-circle icon-white"></i>
                            </a>
                          <?php else: ?>
                            <a href="<?php echo site_url('admin/auth/activate/'.$user->id); ?>" 
                               class="btn btn-mini btn-success" title="Activate User"
                               onclick="return confirm('Are you sure you want to activate this user?');">
                              <i class="icon-ok icon-white"></i>
                            </a>
                          <?php endif; ?>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /row -->
    </div>
    <!-- /container -->
  </div>
  <!-- /main-inner -->
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

.btn-toolbar {
  margin-bottom: 15px;
}

.btn-toolbar .btn {
  margin-left: 5px;
}

.table thead th {
  background: #f8f9fa;
  font-weight: 600;
  color: #495057;
  text-transform: uppercase;
  font-size: 11px;
  border-color: #dee2e6;
}

.table td {
  vertical-align: middle;
  padding: 12px 8px;
}

.btn-group .btn {
  margin-right: 2px;
}

.label {
  font-size: 10px;
  margin-right: 3px;
}

.text-white {
  color: white !important;
  text-decoration: none;
}

.text-white:hover {
  color: #f0f0f0 !important;
  text-decoration: none;
}

.alert {
  border-radius: 6px;
  margin-bottom: 15px;
}
</style>


