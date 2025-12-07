<?php
/**
 * Labour Group Menu Integration
 * 
 * Instructions for adding Labour Group module to your existing admin menu system
 * 
 * This file provides sample code snippets for integrating the Labour Group module
 * into your existing navigation menu. Please adapt these examples to match your
 * current menu structure and styling.
 */

/* 
====================================================================================
MENU INTEGRATION EXAMPLES
====================================================================================

1. If you have a sidebar navigation in your admin layout, add this menu item:

<li class="nav-item <?php echo ($current_page == 'labour_group') ? 'active' : ''; ?>">
    <a class="nav-link" href="<?php echo site_url('admin/labour_group'); ?>">
        <i class="icon-users nav-icon"></i>
        <span class="nav-label">Labour Groups</span>
        <span class="nav-badge">
            <?php 
            // You can load a count if needed
            // $this->load->model('Labour_group_model');
            // echo $this->Labour_group_model->count_all_labour_groups();
            ?>
        </span>
    </a>
    <ul class="nav-submenu">
        <li><a href="<?php echo site_url('admin/labour_group'); ?>">View All</a></li>
        <li><a href="<?php echo site_url('admin/labour_group/create'); ?>">Add New</a></li>
    </ul>
</li>

====================================================================================

2. If you have a dropdown menu system, add this dropdown:

<div class="dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
        <i class="icon-users"></i>
        Labour Groups
    </a>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="<?php echo site_url('admin/labour_group'); ?>">
            <i class="icon-list"></i> View All Labour Groups
        </a>
        <a class="dropdown-item" href="<?php echo site_url('admin/labour_group/create'); ?>">
            <i class="icon-plus"></i> Add New Labour Group
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?php echo site_url('admin/labour_group/export_csv'); ?>">
            <i class="icon-download"></i> Export to CSV
        </a>
    </div>
</div>

====================================================================================

3. For a horizontal navigation bar, add this item:

<ul class="navbar-nav">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
            <i class="icon-users"></i>
            Labour Management
        </a>
        <div class="dropdown-menu">
            <h6 class="dropdown-header">Labour Groups</h6>
            <a class="dropdown-item" href="<?php echo site_url('admin/labour_group'); ?>">
                <i class="icon-list"></i> All Groups
            </a>
            <a class="dropdown-item" href="<?php echo site_url('admin/labour_group/create'); ?>">
                <i class="icon-plus"></i> Add Group
            </a>
        </div>
    </li>
</ul>

====================================================================================

4. For a card-based dashboard, add this card:

<div class="col-lg-3 col-md-6">
    <div class="card card-stats">
        <div class="card-body">
            <div class="row">
                <div class="col-5">
                    <div class="icon-big text-center">
                        <i class="icon-users text-primary"></i>
                    </div>
                </div>
                <div class="col-7">
                    <div class="numbers">
                        <p class="card-category">Labour Groups</p>
                        <h3 class="card-title">
                            <?php 
                            // Load count dynamically
                            // $this->load->model('Labour_group_model');
                            // echo $this->Labour_group_model->count_all_labour_groups();
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <hr>
            <div class="stats">
                <a href="<?php echo site_url('admin/labour_group'); ?>" class="btn btn-primary btn-sm">
                    <i class="icon-arrow-right"></i> Manage Groups
                </a>
                <a href="<?php echo site_url('admin/labour_group/create'); ?>" class="btn btn-success btn-sm">
                    <i class="icon-plus"></i> Add New
                </a>
            </div>
        </div>
    </div>
</div>

====================================================================================

5. Breadcrumb navigation for Labour Group pages:

In your header/breadcrumb section, add conditional breadcrumbs:

<?php if ($this->router->class === 'labour_group'): ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?php echo site_url('admin/labour_group'); ?>">Labour Groups</a></li>
        
        <?php if ($this->router->method === 'create'): ?>
            <li class="breadcrumb-item active">Add New Labour Group</li>
        <?php elseif ($this->router->method === 'edit'): ?>
            <li class="breadcrumb-item active">Edit Labour Group</li>
        <?php elseif ($this->router->method === 'view'): ?>
            <li class="breadcrumb-item active">View Labour Group</li>
        <?php else: ?>
            <li class="breadcrumb-item active">Labour Groups</li>
        <?php endif; ?>
    </ol>
</nav>
<?php endif; ?>

====================================================================================

6. Quick Actions Widget (for dashboard):

<div class="quick-actions-widget">
    <h4>Quick Actions</h4>
    <div class="action-buttons">
        <a href="<?php echo site_url('admin/labour_group/create'); ?>" class="btn btn-primary">
            <i class="icon-plus"></i> Add Labour Group
        </a>
        <a href="<?php echo site_url('admin/labour_group'); ?>" class="btn btn-secondary">
            <i class="icon-users"></i> Manage Groups
        </a>
        <a href="<?php echo site_url('admin/labour_group/export_csv'); ?>" class="btn btn-info">
            <i class="icon-download"></i> Export Data
        </a>
    </div>
</div>

====================================================================================

7. Search Integration:

If you have a global search function, add Labour Groups to searchable entities:

In your search controller/function:
case 'labour_groups':
    $this->load->model('Labour_group_model');
    $results = $this->Labour_group_model->search_labour_groups($search_term);
    foreach ($results as $result) {
        $search_results[] = [
            'title' => $result['name'],
            'description' => $result['description'],
            'url' => site_url('admin/labour_group/view/' . $result['id']),
            'type' => 'Labour Group'
        ];
    }
    break;

====================================================================================

8. Permission-based Menu Display:

If you have role-based access control, wrap menu items with permissions:

<?php if ($this->ion_auth->in_group(['admin', 'hr_manager'])): ?>
    <li class="nav-item">
        <a href="<?php echo site_url('admin/labour_group'); ?>">
            <i class="icon-users"></i> Labour Groups
        </a>
    </li>
<?php endif; ?>

====================================================================================

IMPLEMENTATION NOTES:

1. Replace icon classes (icon-*) with your preferred icon library (FontAwesome, etc.)
2. Adjust CSS classes to match your admin theme
3. Update URLs if you've customized the routing
4. Add appropriate permissions/role checks
5. Style buttons and cards to match your design system
6. Test responsiveness on mobile devices

====================================================================================

FILE LOCATIONS TO MODIFY:

- Main admin layout: application/views/admin/layout/header.php
- Sidebar navigation: application/views/admin/layout/sidebar.php
- Dashboard widgets: application/views/admin/dashboard.php
- Breadcrumb component: application/views/admin/layout/breadcrumb.php

====================================================================================
*/

?>

<!-- 
Sample CSS for Labour Group menu styling:
Copy this to your main admin CSS file and adjust colors to match your theme
-->

<style>
/* Labour Group Menu Styling */
.labour-group-menu {
    position: relative;
}

.labour-group-menu .nav-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 20px;
    color: #2c3e50;
    text-decoration: none;
    transition: all 0.3s ease;
    border-radius: 8px;
    margin-bottom: 5px;
}

.labour-group-menu .nav-link:hover {
    background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
    color: white;
    transform: translateX(5px);
}

.labour-group-menu .nav-link.active {
    background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
}

.labour-group-menu .nav-icon {
    font-size: 18px;
    min-width: 20px;
}

.labour-group-menu .nav-badge {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 12px;
    margin-left: auto;
}

.labour-group-submenu {
    padding-left: 40px;
    margin-top: 5px;
    border-left: 2px solid #e9ecef;
    margin-left: 20px;
}

.labour-group-submenu a {
    display: block;
    padding: 8px 15px;
    color: #6c757d;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s ease;
    border-radius: 6px;
    margin-bottom: 3px;
}

.labour-group-submenu a:hover {
    color: #3498db;
    background: rgba(52, 152, 219, 0.1);
    transform: translateX(5px);
}

/* Quick Actions Widget */
.labour-group-quick-actions {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    margin-bottom: 25px;
}

.labour-group-quick-actions h4 {
    margin: 0 0 20px 0;
    color: #2c3e50;
    font-weight: 600;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 10px;
}

.labour-group-action-buttons {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.labour-group-action-buttons .btn {
    flex: 1;
    min-width: 150px;
    padding: 12px 20px;
    border-radius: 25px;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.labour-group-action-buttons .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

/* Dashboard Stats Card */
.labour-group-stats-card {
    background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
    color: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(52, 152, 219, 0.3);
    transition: all 0.3s ease;
    cursor: pointer;
}

.labour-group-stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 50px rgba(52, 152, 219, 0.4);
}

.labour-group-stats-card .icon {
    font-size: 48px;
    opacity: 0.8;
    margin-bottom: 15px;
}

.labour-group-stats-card .count {
    font-size: 36px;
    font-weight: bold;
    margin-bottom: 10px;
}

.labour-group-stats-card .label {
    font-size: 16px;
    opacity: 0.9;
}

/* Responsive Design */
@media (max-width: 768px) {
    .labour-group-action-buttons {
        flex-direction: column;
    }
    
    .labour-group-action-buttons .btn {
        min-width: auto;
    }
    
    .labour-group-menu .nav-link {
        padding: 10px 15px;
    }
    
    .labour-group-submenu {
        padding-left: 30px;
        margin-left: 15px;
    }
}
</style>

<!-- Sample JavaScript for enhanced menu interactions -->
<script>
$(document).ready(function() {
    // Highlight active menu item
    var currentPath = window.location.pathname;
    
    if (currentPath.includes('labour_group') || currentPath.includes('labour-groups')) {
        $('.labour-group-menu').addClass('active');
        $('.labour-group-menu .nav-link').addClass('active');
    }
    
    // Add loading states to quick action buttons
    $('.labour-group-quick-actions .btn').click(function() {
        var btn = $(this);
        var originalText = btn.html();
        
        btn.html('<i class="icon-spinner icon-spin"></i> Loading...');
        btn.css('pointer-events', 'none');
        
        // The page will navigate, so we don't need to restore
    });
    
    // Stats card hover effects
    $('.labour-group-stats-card').hover(
        function() {
            $(this).find('.icon').css('transform', 'scale(1.1)');
        },
        function() {
            $(this).find('.icon').css('transform', 'scale(1)');
        }
    );
    
    // Submenu toggle for mobile
    $('.labour-group-menu .nav-link').click(function(e) {
        if ($(window).width() <= 768) {
            e.preventDefault();
            $(this).siblings('.labour-group-submenu').slideToggle();
        }
    });
});
</script>