# Labour Group Module - Installation & Setup Guide

## Overview
The Labour Group module is a comprehensive CRUD (Create, Read, Update, Delete) system for managing labour groups in your ERP system. It features a modern UI with gradient backgrounds (#2c3e50 to #3498db), professional form handling, data validation, and responsive design.

## Features
- ✅ Complete CRUD operations (Create, Read, Update, Delete)
- ✅ Professional UI/UX with modern gradient design
- ✅ Form validation and error handling
- ✅ DataTables integration with search, sort, and pagination
- ✅ Responsive design for all devices
- ✅ Export functionality (CSV)
- ✅ Audit trail (created_by, updated_by, timestamps)
- ✅ Character counting for descriptions
- ✅ Confirmation dialogs for delete operations
- ✅ Loading states and animations
- ✅ Professional error messaging
- ✅ Clean, SEO-friendly URLs

## Installation Steps

### 1. Database Setup
Execute the SQL schema to create the labour_groups table:

```sql
-- Run this SQL in your database
source application/sql/labour_groups_schema.sql;
```

Or manually create the table:

```sql
CREATE TABLE `labour_groups` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `description` text DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `created_by` int(11) DEFAULT NULL,
    `updated_by` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`),
    KEY `idx_created_at` (`created_at`),
    KEY `idx_updated_at` (`updated_at`),
    CONSTRAINT `fk_labour_groups_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_labour_groups_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 2. File Structure
Ensure all module files are in place:

```
application/
├── controllers/admin/
│   └── Labour_group.php                    ✅ Main controller
├── models/
│   └── Labour_group_model.php              ✅ Database model
├── views/admin/labour_group/
│   ├── listing_labour_group.php            ✅ List view
│   ├── create_labour_group.php             ✅ Create form
│   ├── edit_labour_group.php               ✅ Edit form
│   ├── view_labour_group.php               ✅ Details view
│   └── menu_integration_guide.php          ✅ Menu guide
├── config/
│   └── routes.php                          ✅ Updated routes
└── sql/
    └── labour_groups_schema.sql            ✅ Database schema
```

### 3. Routes Configuration
Routes are already configured in `application/config/routes.php`:

```php
// Labour Group Routes
$route['admin/labour-groups'] = 'admin/labour_group';
$route['admin/labour-groups/create'] = 'admin/labour_group/create';
$route['admin/labour-groups/edit/(:num)'] = 'admin/labour_group/edit/$1';
$route['admin/labour-groups/view/(:num)'] = 'admin/labour_group/view/$1';
$route['admin/labour-groups/delete/(:num)'] = 'admin/labour_group/delete/$1';
```

### 4. Menu Integration
Add Labour Group to your admin navigation. See `menu_integration_guide.php` for detailed examples.

Quick example for sidebar menu:
```php
<li class="nav-item">
    <a class="nav-link" href="<?php echo site_url('admin/labour_group'); ?>">
        <i class="icon-users nav-icon"></i>
        <span class="nav-label">Labour Groups</span>
    </a>
</li>
```

### 5. Dependencies Check
Ensure these CodeIgniter libraries and helpers are loaded:

**Required Libraries:**
- Form Validation
- Session
- Database

**Required Helpers:**
- URL helper
- Form helper

**Database Tables:**
- `labour_groups` table (created by schema)

**Note:** This module has been simplified to work independently without user table dependencies. Audit trail fields (`created_by`, `updated_by`) now store simple text values instead of user IDs.

### 6. Database Migration (If Updating Existing Installation)
If you already have the labour_groups table with user table dependencies, run the migration script:

```sql
-- Run this SQL to update existing table structure
source application/sql/migrate_labour_groups.sql;
```

This will convert user ID references to simple text values.

## URL Structure

| Action | URL | Method |
|--------|-----|---------|
| List All | `/admin/labour-groups` | GET |
| Create Form | `/admin/labour-groups/create` | GET |
| Store New | `/admin/labour_group/store` | POST |
| View Details | `/admin/labour-groups/view/123` | GET |
| Edit Form | `/admin/labour-groups/edit/123` | GET |
| Update | `/admin/labour_group/update/123` | POST |
| Delete | `/admin/labour-groups/delete/123` | GET/POST |
| AJAX Data | `/admin/labour-groups/ajax/get-all` | GET |
| Export CSV | `/admin/labour-groups/export` | GET |

## Testing the Installation

### 1. Basic Functionality Test
1. Navigate to `/admin/labour-groups`
2. Verify the listing page loads with proper styling
3. Click "Add New Labour Group" - form should load
4. Create a test labour group with name "Test Group" and description
5. Verify it appears in the listing
6. Test edit, view, and delete functions

### 2. Validation Test
1. Try creating a labour group with empty name - should show validation error
2. Try creating duplicate names - should prevent duplicates
3. Test character limit validation for description

### 3. Responsive Design Test
1. Test on mobile devices (responsive design)
2. Verify all buttons and forms work on touch devices
3. Check that tables are scrollable on small screens

### 4. Data Integrity Test
1. Verify audit trail is working (created_by, updated_by fields)
2. Test foreign key constraints
3. Check that timestamps update correctly

## Customization Options

### 1. Styling Customization
The module uses the color scheme: `linear-gradient(135deg, #2c3e50 0%, #3498db 100%)`

To change colors, update CSS variables in each view file:
```css
:root {
    --primary-color: #2c3e50;
    --secondary-color: #3498db;
    --gradient: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
}
```

### 2. Add Custom Fields
To add new fields to labour groups:

1. **Update Database:**
```sql
ALTER TABLE labour_groups ADD COLUMN new_field VARCHAR(255) NULL AFTER description;
```

2. **Update Model:** Add field to `$fillable_fields` array in `Labour_group_model.php`

3. **Update Controller:** Add validation rules in `store()` and `update()` methods

4. **Update Views:** Add form fields in create/edit forms, display in listing/view

### 3. Add Bulk Operations
To add bulk delete/export functionality:

1. Add checkboxes to listing table
2. Create bulk action dropdown
3. Add JavaScript to handle bulk selections
4. Create controller methods for bulk operations

### 4. Add File Uploads
To add document uploads to labour groups:

1. Create `labour_group_documents` table
2. Add file upload field to forms
3. Update controller to handle file uploads
4. Display documents in view page

## Security Considerations

### 1. Authentication
- All controller methods check `ion_auth->logged_in()`
- Redirects to login if not authenticated

### 2. Input Validation
- Server-side validation for all inputs
- XSS prevention with `htmlspecialchars()`
- SQL injection prevention with CodeIgniter's Query Builder

### 3. CSRF Protection
- Enable CSRF protection in CodeIgniter config
- Forms include CSRF tokens automatically

### 4. Permission Checks
Add permission checks to controller methods:
```php
if (!$this->ion_auth->in_group(['admin', 'hr_manager'])) {
    show_error('You do not have permission to access this page.', 403);
}
```

## Performance Optimization

### 1. Database Indexing
- Primary key on `id`
- Unique index on `name` 
- Indexes on `created_at`, `updated_at`
- Foreign key indexes for audit trail

### 2. Pagination
- Implemented in listing view with configurable page size
- AJAX loading for better performance

### 3. Caching
To add caching:
```php
// In model methods
$this->db->cache_on();
$result = $this->db->get('labour_groups');
$this->db->cache_off();
```

### 4. Database Query Optimization
- Uses joins for audit trail data
- Efficient queries with proper WHERE clauses
- Pagination to limit result sets

## Troubleshooting

### Common Issues

1. **404 Error on Labour Group Pages**
   - Check routes configuration
   - Verify controller file exists and is properly named
   - Ensure URL rewriting is enabled

2. **Database Connection Errors**
   - Verify database credentials in `config/database.php`
   - Check if `labour_groups` table exists
   - Ensure foreign key constraints are properly set

3. **Permission Denied Errors**
   - Verify Ion Auth is properly installed
   - Check user roles and permissions
   - Ensure session is working correctly

4. **Styling Issues**
   - Verify CSS files are loading
   - Check for CSS conflicts with existing styles
   - Ensure gradient backgrounds are supported by browser

5. **Form Validation Not Working**
   - Check if Form Validation library is loaded
   - Verify validation rules are properly set
   - Ensure form fields have correct names

### Debug Mode
Enable CodeIgniter debug mode:
```php
// In index.php
define('ENVIRONMENT', 'development');
```

### Error Logging
Check CodeIgniter error logs:
```
application/logs/log-YYYY-MM-DD.php
```

## Support & Maintenance

### Regular Maintenance Tasks
1. **Database Cleanup:** Archive old records periodically
2. **Performance Monitoring:** Check query performance
3. **Security Updates:** Keep CodeIgniter updated
4. **Backup:** Regular database backups
5. **Log Monitoring:** Check error logs regularly

### Updates and Upgrades
- Keep documentation updated when making changes
- Test thoroughly before deploying updates
- Maintain backward compatibility when possible
- Version control all changes

### Contact Information
For technical support or questions about this module:
- Document any customizations made
- Keep track of version numbers
- Maintain change logs

---

**Installation Complete!** 🎉

Your Labour Group module is now ready to use. Access it at `/admin/labour-groups` and start managing your labour groups with the professional, modern interface.