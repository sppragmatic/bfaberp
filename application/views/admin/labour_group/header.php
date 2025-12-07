<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Labour Groups Management'; ?> - ERP System</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
    
    <!-- Custom ERP Styles -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/admin.css'); ?>">
    
    <!-- Labour Group Module Styles -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --gradient-primary: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            --gradient-light: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        /* Main Layout */
        .labour-group-layout {
            background: var(--gradient-primary);
            min-height: 100vh;
            padding: 0;
        }

        .labour-group-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Styles */
        .labour-group-header {
            background: rgba(255,255,255,0.95);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }

        .labour-group-header h1 {
            color: var(--primary-color);
            margin: 0 0 5px 0;
            font-size: 28px;
            font-weight: bold;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .labour-group-header .subtitle {
            color: #7f8c8d;
            margin: 0;
            font-size: 16px;
        }

        .labour-group-header .breadcrumb {
            background: none;
            padding: 10px 0 0 0;
            margin: 0;
            font-size: 14px;
        }

        .labour-group-header .breadcrumb-item a {
            color: var(--secondary-color);
            text-decoration: none;
        }

        .labour-group-header .breadcrumb-item.active {
            color: #6c757d;
        }

        /* Navigation Menu */
        .labour-group-nav {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .labour-group-nav .nav-tabs {
            border: none;
            margin-bottom: 0;
        }

        .labour-group-nav .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 600;
            padding: 12px 20px;
            border-radius: 8px;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .labour-group-nav .nav-link:hover {
            background: var(--gradient-light);
            color: var(--primary-color);
        }

        .labour-group-nav .nav-link.active {
            background: var(--gradient-primary);
            color: white;
        }

        /* Content Area */
        .labour-group-content {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 25px;
        }

        /* Flash Messages */
        .alert-custom {
            border: none;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success-custom {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 4px solid var(--success-color);
        }

        .alert-error-custom {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-left: 4px solid var(--danger-color);
        }

        /* Button Styles */
        .btn-gradient-primary {
            background: var(--gradient-primary);
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-gradient-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-gradient-success {
            background: linear-gradient(135deg, var(--success-color) 0%, #2ecc71 100%);
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-gradient-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(39, 174, 96, 0.4);
            color: white;
            text-decoration: none;
        }

        /* Footer */
        .labour-group-footer {
            background: rgba(255,255,255,0.9);
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .labour-group-container {
                padding: 15px;
            }
            
            .labour-group-header {
                padding: 20px;
            }
            
            .labour-group-content {
                padding: 20px;
            }
            
            .labour-group-nav .nav-link {
                margin-bottom: 10px;
                margin-right: 0;
            }
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="labour-group-layout">
    <div class="labour-group-container">
        
        <!-- Header Section -->
        <div class="labour-group-header fade-in">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1>
                        <i class="fa fa-users" style="color: var(--secondary-color); margin-right: 12px;"></i>
                        <?php echo isset($page_title) ? $page_title : 'Labour Groups Management'; ?>
                    </h1>
                    <p class="subtitle">
                        <?php echo isset($page_subtitle) ? $page_subtitle : 'Manage and organize labour groups efficiently'; ?>
                    </p>
                    
                    <!-- Breadcrumb Navigation -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?php echo site_url('admin/dashboard'); ?>">
                                    <i class="fa fa-home"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?php echo site_url('admin/labour_group'); ?>">Labour Groups</a>
                            </li>
                            <?php if (isset($breadcrumb_active)): ?>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumb_active; ?></li>
                            <?php endif; ?>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-4 text-right">
                    <?php if (isset($header_actions)): ?>
                        <?php echo $header_actions; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="labour-group-nav fade-in">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'list') ? 'active' : ''; ?>" 
                       href="<?php echo site_url('admin/labour_group'); ?>">
                        <i class="fa fa-list"></i> All Labour Groups
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'create') ? 'active' : ''; ?>" 
                       href="<?php echo site_url('admin/labour_group/create'); ?>">
                        <i class="fa fa-plus"></i> Add New Group
                    </a>
                </li>
                <?php if (isset($labour_group) && !empty($labour_group)): ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'view') ? 'active' : ''; ?>" 
                       href="<?php echo site_url('admin/labour_group/view/' . $labour_group['id']); ?>">
                        <i class="fa fa-eye"></i> View Details
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'edit') ? 'active' : ''; ?>" 
                       href="<?php echo site_url('admin/labour_group/edit/' . $labour_group['id']); ?>">
                        <i class="fa fa-edit"></i> Edit Group
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success-custom alert-custom fade-in">
            <i class="fa fa-check-circle"></i>
            <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-error-custom alert-custom fade-in">
            <i class="fa fa-exclamation-circle"></i>
            <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php endif; ?>

        <!-- Main Content Area -->
        <div class="labour-group-content fade-in">
            <!-- Content will be loaded here -->