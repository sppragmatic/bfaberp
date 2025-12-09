<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <title>BHABANI FLY ASH BRICKS</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta name="apple-mobile-web-app-capable" content="yes">

    <link href="<?= base_url();?>/assets/css/bootstrap.min.css" rel="stylesheet">

    <link href="<?= base_url();?>/assets/css/bootstrap-responsive.min.css" rel="stylesheet">
    <!--
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"

        rel="stylesheet">-->

    <link href="<?= base_url();?>/assets/css/font-awesome.css" rel="stylesheet">

    <link href="<?= base_url();?>/assets/css/style.css" rel="stylesheet">

    <link href="<?= base_url();?>/assets/css/pages/dashboard.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->

    <!--[if lt IE 9]>

      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>

    <![endif]-->
    <script src="<?= base_url();?>/assets/js/jquery-1.7.2.min.js"></script>
    <!-- <script src="<?= base_url();?>assets/datepicker/jquery-1.10.2.js"></script>-->
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/chosen/chosen.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/ui/jquery-ui.css" />
    
    <!-- DataTables JavaScript Libraries -->
    <script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
    
    <!-- Chosen jQuery -->
    <script src="<?php echo base_url();?>assets/chosen/chosen.jquery.min.js"></script>
    
    <!-- jQuery UI -->
    <script src="<?php echo base_url();?>assets/ui/jquery-ui.js"></script>
    
    <!-- jQuery Validate -->
    <script src="<?php echo base_url();?>assets/validate/dist/jquery.validate.js"></script>
    <!-- Centralized Admin Sales CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/admin-sales-common.css">
    <style>
    /* Modern Navbar/Header Styling */
    body {
        background: #f8f9fa;
        font-family: 'Segoe UI', 'Open Sans', Arial, sans-serif;
    }
    .navbar {
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%) !important;
        border: none !important;
        box-shadow: 0 4px 16px rgba(44,62,80,0.08);
        min-height: 60px;
        margin-bottom: 0;
    }
    .navbar-inner {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0 24px;
        min-height: 60px;
        display: flex;
        align-items: center;
    }
    .navbar .brand {
        color: #fff !important;
        font-size: 22px;
        font-weight: 700;
        letter-spacing: 1px;
        padding: 12px 0;
        text-shadow: 0 2px 8px rgba(44,62,80,0.08);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .navbar .brand img {
        height: 36px;
        margin-right: 10px;
    }
    .navbar .nav {
        margin: 0;
        display: flex;
        align-items: center;
        gap: 18px;
    }
    .navbar .nav > li > a {
        color: #fff !important;
        font-size: 15px;
        font-weight: 500;
        padding: 12px 18px !important;
        border-radius: 8px;
        transition: background 0.2s, color 0.2s;
    }
    .navbar .nav > li > a:hover, .navbar .nav > li.active > a {
        background: rgba(255,255,255,0.12) !important;
        color: #ffeaa7 !important;
        text-decoration: none;
    }
    .navbar .nav .dropdown-menu {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(44,62,80,0.12);
        border: none;
        margin-top: 8px;
    }
    .navbar .nav .dropdown-menu > li > a {
        color: #2c3e50 !important;
        font-size: 15px;
        padding: 10px 20px;
        border-radius: 6px;
    }
    .navbar .nav .dropdown-menu > li > a:hover {
        background: #f0f8ff !important;
        color: #3498db !important;
    }
    .navbar .btn-navbar {
        background: #3498db !important;
        border: none;
        color: #fff;
        font-size: 20px;
        border-radius: 6px;
        margin-top: 12px;
    }
    @media (max-width: 991px) {
        .navbar-inner {
            flex-direction: column;
            align-items: flex-start;
            padding: 0 10px;
        }
        .navbar .brand {
            font-size: 18px;
            padding: 10px 0;
        }
        .navbar .nav {
            flex-direction: column;
            width: 100%;
            gap: 0;
        }
        .navbar .nav > li > a {
            width: 100%;
            padding: 12px 10px !important;
        }
    }

    /* Match Credit Report menu style to other dropdown menus */
    .nav .dropdown .dropdown-toggle {
    background: linear-gradient(90deg, #1976d2 0%, #64b5f6 100%);
    color: #fff !important;
    border-radius: 6px;
    padding: 8px 18px;
    font-weight: 500;
    transition: background 0.2s;
  }
  .nav .dropdown.open .dropdown-toggle,
  .nav .dropdown .dropdown-toggle:hover {
    background: linear-gradient(90deg, #1565c0 0%, #1976d2 100%);
    color: #fff !important;
  }
  .nav .dropdown-menu {
    background: #f4f6fb;
    border-radius: 0 0 8px 8px;
    box-shadow: 0 2px 8px rgba(33,150,243,0.07);
    min-width: 180px;
    padding: 8px 0;
  }
  .nav .dropdown-menu > li > a {
    color: #1976d2 !important;
    font-weight: 500;
    padding: 8px 22px;
    transition: background 0.2s, color 0.2s;
  }
  .nav .dropdown-menu > li > a:hover {
    background: #e3f2fd;
    color: #1565c0 !important;
  }
    </style>
</head>

<body>

    <div class="navbar navbar-fixed-top">

        <div class="navbar-inner">

            <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                        class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a
                    class="brand" href="<?= site_url('admin/admin/index'); ?>">
                    <!--<img  style="width:150px !important" src="<?= base_url();?>/assets/img/logo.png"   />--> BHABANI FLY ASH
                    BRICKS
                </a>

                <div class="nav-collapse">

                    <ul class="nav pull-right">

                        <!--<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i

                            class="icon-cog"></i> Account <b class="caret"></b></a>

            <ul class="dropdown-menu">

              <li><a href="javascript:;">Settings</a></li>

              <li><a href="javascript:;">Help</a></li>

            </ul>

          </li>-->

                        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                    class="icon-user"></i>
                                <?php $data =  $this->session->userdata('identity'); ?>

                                <?php echo $data; ?> <b class="caret"></b></a>

                            <ul class="dropdown-menu">

                                <li><a href="javascript:;">Profile</a></li>
                                <li><a href="<?= site_url('admin/auth/change_password'); ?>">Change Password</a></li>

                                <li><a href="<?= site_url('admin/auth/logout'); ?>">Logout</a></li>

                            </ul>

                        </li>

                    </ul>

                    <!--  <form class="navbar-search pull-right">

          <input type="text" class="search-query" placeholder="Search">

        </form>-->

                </div>

                <!--/.nav-collapse -->

            </div>

            <!-- /container -->

        </div>

        <!-- /navbar-inner -->

    </div>

    <!-- /navbar -->

    <?php
    $sesdata = $this->session->userdata;
    $group = isset($sesdata['group']) ? $sesdata['group'] : null;
    $menus = null;
    if (isset($this->common_model) && $group !== null) {
        $menus = $this->common_model->get_menu($group);
    }


?>

    <div class="subnavbar">

        <div class="subnavbar-inner">

            <div class="container">

                <ul class="mainnav">

                  
                    <li class="active"><a href="<?= site_url('admin/admin/index'); ?>"><i
                                class="icon-dashboard"></i><span>Dashboard</span> </a> </li>


                    <?php 
                    // Check if user is admin using passed data
                    $is_admin = isset($is_admin) ? $is_admin : false;
                    if($group==1 || $is_admin){  
                    ?>
                    <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i
                                class="icon-cog"></i><span>ADMIN SETTINGS</span> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <!-- User Management -->
                            <li class="nav-header" style="color: #999; font-weight: bold; padding: 3px 20px;">User Management</li>
                            <li><a href="<?= site_url('admin/auth/'); ?>"><i class="icon-user"></i><span>Manage Users</span></a></li>
                            <li><a href="<?= site_url('admin/auth/create_user'); ?>"><i class="icon-plus"></i><span>Add New User</span></a></li>
        
                            
                            <li class="divider"></li>
                            
                            <!-- Branch Management -->
                            <li class="nav-header" style="color: #999; font-weight: bold; padding: 3px 20px;">Branch Management</li>
                            <li><a href="<?= site_url('admin/branch/index'); ?>"><i class="icon-building"></i><span>Manage Branches</span></a></li>
                            <li><a href="<?= site_url('admin/branch/create_branch'); ?>"><i class="icon-plus-sign"></i><span>Add New Branch</span></a></li>
                            
                            <li class="divider"></li>
                            
            <!-- Master Data -->
            <li class="nav-header" style="color: #999; font-weight: bold; padding: 3px 20px;">Master Data</li>
            <li><a href="<?= site_url('admin/material'); ?>"><i class="icon-th-list"></i><span>Material Master</span></a></li>
            <li><a href="<?= site_url('admin/product'); ?>"><i class="icon-tags"></i><span>Product Master</span></a></li>
            <li><a href="<?= site_url('admin/labour_group/'); ?>"><i class="icon-user"></i><span>Labour Groups</span></a></li>                            <li class="divider"></li>
                            
                            <?php if($is_admin): ?>
                            <li class="divider"></li>
                            <li class="nav-header" style="color: #d9534f; font-weight: bold; padding: 3px 20px;">Advanced</li>
                            <li><a href="<?= site_url('admin/admin/logs'); ?>"><i class="icon-file-text"></i><span>System Logs</span></a></li>
                            <li><a href="<?= site_url('admin/admin/maintenance'); ?>"><i class="icon-warning-sign"></i><span>Maintenance Mode</span></a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <?php }  ?>


                    <?php if($group==2){  ?>
                    <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i
                                class="icon-list-alt"></i><span>Production</span> <b class="caret"></b></a>
                        <ul class="dropdown-menu">

                            <li><a href="<?= site_url('admin/production'); ?>"><span>View
                                        Production</span> </a></li>
                            <li><a href="<?= site_url('admin/production/create_production'); ?>"><span>Add
                                        Production</span> </a></li>
                            <!-- <li><a href="<?= site_url('admin/production/production_report'); ?>"><span>Production Report</span> </a></li> -->
  <li><a href="<?= site_url('admin/production/product_production_report'); ?>"><span> PRODUCTION REPORT</span> </a></li>
                            <li><a href="<?= site_url('admin/production/product_loading_unloading_report'); ?>"><span> LOADING/UNLOADING REPORT</span> </a></li>
                        </ul>
                    </li>
                    <?php }  ?>

                    <?php if($group==1){  ?>
                    <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i
                                class="icon-list-alt"></i><span>PRODUCTION</span> <b class="caret"></b></a>
                        <ul class="dropdown-menu">

                            <li><a href="<?= site_url('admin/production/adminproduction'); ?>"><span>VIEW PRODUCTION</span> </a></li>
                            <li><a href="<?= site_url('admin/production/create_production'); ?>"><span>ADD
                                        PRODUCTION</span> </a></li>
                            <li><a href="<?= site_url('admin/production/production_report'); ?>"><span>PRODUCTION REPORT</span> </a></li>
                            <li><a href="<?= site_url('admin/production/product_production_report'); ?>"><span> PRODUCTION REPORT</span> </a></li>
                            <li><a href="<?= site_url('admin/production/product_loading_unloading_report'); ?>"><span>PRODUCT LOADING/UNLOADING REPORT</span> </a></li>
                        </ul>
                    </li>

                    <?php }  ?>

                    <?php if($group==2){  ?>
                    <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i
                                class="icon-list-alt"></i><span>Sales</span> <b class="caret"></b></a>
                        <ul class="dropdown-menu">

                            <li><a href="<?= site_url('admin/sales/index/'); ?>"><span>Add Sales</span> </a></li>
                            <li><a href="<?= site_url('admin/sales/view_sales'); ?>"><span>View Sales</span> </a></li>
                            <li><a href="<?= site_url('admin/sales/create_customer'); ?>"><span>View Customer</span>
                                </a></li>
                            <li><a href="<?= site_url('admin/sales/customer'); ?>"><span>Add Customer </span> </a></li>
                        </ul>
                    </li>



                    <?php }  ?>


<!-- 
                    <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i
                                class="icon-list-alt"></i><span>GST</span> <b class="caret"></b></a>
                        <ul class="dropdown-menu">

                            <li><a href="<?= site_url('admin/gst/index/'); ?>"><span>Add GST Bill </span> </a></li>
                            <li><a href="<?= site_url('admin/gst/view_sales'); ?>"><span>View GST Bill </span> </a></li>

                        </ul>
                    </li> -->




                    <?php if($group==1){  ?>
                    <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i
                                class="icon-list-alt"></i><span>SALES</span> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?= site_url('admin/sales/index/'); ?>"><span>NEW SALES </span> </a></li>
                            <li><a href="<?= site_url('admin/sales/admin_sales'); ?>"><span>VIEW SALES</span> </a></li>
                            <li><a href="<?= site_url('admin/sales/create_customer'); ?>"><span>ADD CUSTOMER</span> </a>
                            </li>
                            <li><a href="<?= site_url('admin/sales/customer'); ?>"><span>VIEW CUSTOMER</span> </a></li>
                            <li><a href="<?= site_url('admin/sales/summery'); ?>"><span>SALES SUMMERY </span> </a></li>
                        </ul>
                    </li>

                    <?php }  ?>



                    <?php if($group==1){  ?>
                    <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i
                                class="icon-list-alt"></i><span>PAYMENT COLLECTION</span> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?= site_url('admin/sales/view_payment'); ?>"><span> VIEW PAYMENT </span> </a>
                            </li>
                            <li><a href="<?= site_url('admin/sales/add_payment'); ?>"><span> NEW PAYMENT </span> </a>
                            </li>
                            <li><a href="<?= site_url('admin/sales/report'); ?>"><span>PAYMENT REPORT </span> </a></li>

                            <li><a href="<?= site_url('admin/sales/add_opening'); ?>"><span> NEW OPENING </span> </a>
                            </li>
                            <li><a href="<?= site_url('admin/sales/view_opening'); ?>"><span>VIEW OPENING </span> </a>
                            </li>

                        </ul>
                    </li>

                    <?php }  ?>





                    <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i
                                class="icon-list-alt"></i><span>PURCHASE</span> <b class="caret"></b></a>
                        <ul class="dropdown-menu">

                            <li><a href="<?= site_url('admin/account/'); ?>"><span>NEW PURCHASE</span> </a></li>
                          
                            <?php if($group==1 || $is_admin){ ?>
                            <li><a href="<?= site_url('admin/account/admin_account'); ?>"><span>VIEW PURCHASE</span></a></li>
                            <?php }else{ ?>
                            <li><a href="<?= site_url('admin/account/view_account'); ?>"><span>VIEW PURCHASE</span> </a>
                            </li>
                            <?php } ?>

                          
                          
                          
                            <?php if($group==1 || $is_admin){ ?>
                            <li><a href="<?= site_url('admin/account/trash_account'); ?>"><span>PURCHASE TASH</span></a></li>
                            <?php } ?>
                            <li><a href="<?= site_url('admin/account/create_party'); ?>"><span>ADD PARTY </span> </a>
                            </li>
                            <li><a href="<?= site_url('admin/account/party'); ?>"><span>VIEW PARTY </span> </a></li>

                            <li><a href="<?= site_url('admin/account/view_payment'); ?>"><span> VIEW PAYMENT </span>
                                </a></li>
                            <?php if($group==1 || $is_admin){ ?>
                            <li><a href="<?= site_url('admin/account/trash_payment'); ?>"><span>PAYMENT TRASH</span></a></li>
                            <?php } ?>
                            <li><a href="<?= site_url('admin/account/add_payment'); ?>"><span> NEW PAYMENT </span> </a>
                            </li>
                            <li><a href="<?= site_url('admin/account/report'); ?>"><span>PAYMENT REPORT </span> </a>
                            </li>


                        </ul>
                    </li>





                    <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i
                                class="icon-list-alt"></i><span>Stock</span> <b class="caret"></b></a>
                        <ul class="dropdown-menu">

                            <li><a href="<?= site_url('admin/stock/index/'); ?>"><span>Brick Stock</span> </a></li>
                            <li><a href="<?= site_url('admin/stock/material'); ?>"><span>Material Stock</span> </a></li>
                            <li class="divider"></li>
                            <li><a href="<?= site_url('admin/stock/adjustment'); ?>"><span>Stock Adjustments</span> </a></li>
                        </ul>
                    </li>





                    <?php  if(is_array($menus) && in_array("Manage Question", $menus)){ ?>




                    <?php } ?>















                    <!--<li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-list-alt"></i><span>Account</span> <b class="caret"></b></a>
				<ul class="dropdown-menu">

				<li><a href="<?= site_url('admin/account/party'); ?>"><span>Create Account</span> </a></li>
				<li><a href="<?= site_url('admin/account/view_account'); ?>"><span>Create Voucher</span> </a></li>
		<li><a href="<?= site_url('admin/account/report'); ?>"><span>View Account Report</span> </a></li>
		<li><a href="<?= site_url('admin/account/misc_acc'); ?>"><span>Finance Report</span> </a></li>
	<li><a href="<?= site_url('admin/account/finance'); ?>"><span>Finance All Report</span> </a></li>
		</ul>
				</li>-->



                    <li class="active"><a href="<?= site_url('admin/sales/credit'); ?>"><i
                                class="icon-list-alt"></i><span>CREDIT REPORT</span> </a> </li>



                </ul>

            </div>

            <!-- /container -->

        </div>

        <!-- /subnavbar-inner -->

    </div>