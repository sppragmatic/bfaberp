<style>
  /* Match admin_sales panel header style */
  .widget-header.modern-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: #fff !important;
    border-radius: 8px 8px 0 0 !important;
    font-weight: 600;
    text-align: center;
    font-size: 18px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.08) !important;
    padding: 16px 0 !important;
  }
</style>
<style>
  /* Match admin_sales table header style */
  #dataTables-example thead th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: #fff !important;
    font-weight: bold;
    border-bottom: 2px solid #4b3fa2;
    text-align: center;
    vertical-align: middle;
    font-size: 15px;
    letter-spacing: 0.5px;
  }
</style>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="page-header-card">
        <h1><i class="fas fa-trash"></i> Deleted Parties (Trash)</h1>
        <p>List of deleted parties. Only admin can restore.</p>
      </div>
      <div class="row">
        <div class="span12">
          <div class="widget modern-widget">
            <div class="widget-header modern-header">
              <h3><i class="fas fa-users"></i> DELETED PARTIES</h3>
            </div>
            <div class="widget-content modern-content">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-responsive" id="dataTables-example" style="width:100%;">
                  <thead>
                    <tr>
                      <th>Party Code</th>
                      <th>Party Name</th>
                      <th>Contact No</th>
                      <th>Address</th>
                      <th>Remark</th>
                      <th>Deleted At</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($party)) { foreach ($party as $row) { ?>
                    <tr class="danger">
                      <td><?php echo $row['code']; ?></td>
                      <td><?php echo $row['name']; ?></td>
                      <td><?php echo $row['contact_no']; ?></td>
                      <td><?php echo $row['address']; ?></td>
                      <td><?php echo $row['remarks']; ?></td>
                      <td><?php echo $row['deleted_at']; ?></td>
                      <td>
                        <?php if ($this->ion_auth->is_admin()) { ?>
                        <a href="<?php echo site_url('admin/party/restore/'.$row['id']); ?>" class="btn btn-xs btn-info" title="Restore" onclick="return confirm('Restore this party?');" style="margin-right:5px;">
                          <i class="fa fa-undo"></i>
                        </a>
                        <?php } ?>
                      </td>
                    </tr>
                    <?php }} else { ?>
                    <tr><td colspan="7">No deleted parties found.</td></tr>
                    <?php } ?>
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
