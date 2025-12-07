<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Management - <?php echo $this->config->item('site_name'); ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/datatable/css/dataTables.bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Stock Management</h4>
                        <a href="<?php echo base_url('stock/adjustment'); ?>" class="btn btn-primary">
                            <i class="fa fa-plus-minus"></i> Stock Adjustments
                        </a>
                    </div>
                    <div class="card-body">
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php endif; ?>

                        <div class="table-responsive">
                            <table id="stockTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Product Code</th>
                                        <th>Branch</th>
                                        <th>Current Stock</th>
                                        <th>Unit</th>
                                        <th>Last Updated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($stock)): ?>
                                        <?php foreach ($stock as $index => $item): ?>
                                            <tr>
                                                <td><?php echo ($pagination['offset'] + $index + 1); ?></td>
                                                <td><?php echo htmlspecialchars($item->product_name); ?></td>
                                                <td>
                                                    <code><?php echo htmlspecialchars($item->product_code); ?></code>
                                                </td>
                                                <td><?php echo htmlspecialchars($item->branch_name); ?></td>
                                                <td class="text-right">
                                                    <span class="badge <?php echo ($item->quantity > 0) ? 'badge-success' : 'badge-warning'; ?>">
                                                        <?php echo number_format($item->quantity, 2); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo htmlspecialchars($item->unit ?? 'Unit'); ?></td>
                                                <td>
                                                    <?php if ($item->updated_at): ?>
                                                        <?php echo date('d/m/Y H:i', strtotime($item->updated_at)); ?>
                                                    <?php else: ?>
                                                        <?php echo date('d/m/Y H:i', strtotime($item->created_at)); ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No stock records found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if (!empty($pagination['links'])): ?>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="pagination-info">
                                        Showing <?php echo ($pagination['offset'] + 1); ?> to 
                                        <?php echo min($pagination['offset'] + count($stock), $pagination['total_rows']); ?> 
                                        of <?php echo $pagination['total_rows']; ?> entries
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <?php echo $pagination['links']; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/datatable/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/datatable/js/dataTables.bootstrap.min.js'); ?>"></script>

    <script>
        // Initialize DataTable (client-side features only since we're using server-side pagination)
        $('#stockTable').DataTable({
            "paging": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "lengthChange": false,
            "columnDefs": [
                { "className": "text-center", "targets": [0, 6] },
                { "className": "text-right", "targets": [4] }
            ]
        });
    </script>

    <style>
        .card {
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border: none;
            border-radius: 8px;
        }

        .card-header {
            background: linear-gradient(90deg, #007bff, #0056b3);
            color: white;
            border-radius: 8px 8px 0 0 !important;
        }

        .btn-primary {
            background: linear-gradient(90deg, #007bff, #0056b3);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #0056b3, #003d82);
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        code {
            background-color: #f8f9fa;
            padding: 2px 4px;
            border-radius: 3px;
            font-size: 0.9em;
        }
    </style>
</body>
</html>