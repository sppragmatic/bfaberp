<!-- Centralized Admin Sales CSS -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/admin-sales-common.css">

<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">
          
          <?php if ($this->session->flashdata('success')): ?>
          <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
          </div>
          <?php endif; ?>

          <?php if ($this->session->flashdata('error')): ?>
          <div class="alert alert-error">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
          </div>
          <?php endif; ?>

                    <div class="search_panel">
                        <h3 class="search_header">STOCK ADJUSTMENTS</h3>
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
          <div class="table-responsive">
            <table id="adjustment_table" class="table table-striped table-bordered table-hover sales-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Previous Stock</th>
                        <th>New Stock</th>
                        <th>Status</th>
                        <th></th>Remarks</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($adjustments)): ?>
                        <?php $serial = 1; foreach ($adjustments as $adjustment): ?>
                            <tr>
                                <td><?php echo $serial++; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($adjustment['adjustment_date'])); ?></td>
                                <td><?php echo htmlspecialchars($adjustment['product_name']); ?></td>
                                <td>
                                    <?php if ($adjustment['adjustment_type'] == 'increase'): ?>
                                        <span style="color: green;"><b>Increase</b></span>
                                    <?php else: ?>
                                        <span style="color: red;"><b>Decrease</b></span>
                                    <?php endif; ?>
                                </td>
                                <td style="color: red;"><b><?php echo number_format(abs($adjustment['quantity']), 2); ?></b></td>
                                <td style="color: blue;"><b><?php echo number_format($adjustment['previous_stock'], 2); ?></b></td>
                                <td style="color: green;"><b><?php echo number_format($adjustment['new_stock'], 2); ?></b></td>
                                <td>
                                    <?php 
                                    $status = $adjustment['approval_status'] ?? 'pending';
                                    if ($status == 'approved'): ?>
                                        <span class="label label-success">Approved</span>
                                    <?php elseif ($status == 'rejected'): ?>
                                        <span class="label label-important">Rejected</span>
                                    <?php else: ?>
                                        <span class="label label-warning">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars(substr($adjustment['remarks'], 0, 30)) . (strlen($adjustment['remarks']) > 30 ? '...' : ''); ?></td>
                                <td><?php echo htmlspecialchars($adjustment['created_by_name'] ?? 'N/A'); ?></td>
                                <td>
                                    <a href="<?php echo site_url('admin/stock/view_adjustment/' . $adjustment['id']); ?>" 
                                       class="btn btn-small btn-info" title="View">
                                        <i class="icon-eye-open"></i>
                                    </a>
                                    
                                    <?php $status = $adjustment['approval_status'] ?? 'pending'; ?>
                                    <?php if ($status == 'pending'): ?>
                                        <a href="<?php echo site_url('admin/stock/approve_adjustment/' . $adjustment['id']); ?>" 
                                           class="btn btn-small btn-success" title="Approve"
                                           onclick="return confirm('Are you sure you want to approve this adjustment? This will update the stock.')">
                                            <i class="icon-ok"></i>
                                        </a>
                                        <a href="<?php echo site_url('admin/stock/reject_adjustment/' . $adjustment['id']); ?>" 
                                           class="btn btn-small btn-warning" title="Reject"
                                           onclick="return confirm('Are you sure you want to reject this adjustment?')">
                                            <i class="icon-remove"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if ($status != 'approved'): ?>
                                    <a href="<?php echo site_url('admin/stock/delete_adjustment/' . $adjustment['id']); ?>" 
                                       class="btn btn-small btn-danger" title="Delete"
                                       onclick="return confirm('Are you sure you want to delete this adjustment?')">
                                        <i class="icon-trash"></i>
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="11" style="text-align: center;">No stock adjustments found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
          </div>

          <?php if (!empty($pagination)): ?>
              <div class="pagination-wrapper">
                  <?php echo $pagination; ?>
              </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
