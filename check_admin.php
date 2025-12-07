<?php
// Quick script to check and fix admin group assignment
// Place this in your ERP root directory and run it once

// Include CodeIgniter bootstrap
require_once('index.php');

// Get CI instance
$CI =& get_instance();

// Load Ion Auth
$CI->load->library('ion_auth');
$CI->load->database();

echo "<h2>Ion Auth Admin Check</h2>";

// Check if user is logged in
if (!$CI->ion_auth->logged_in()) {
    echo "User is not logged in. Please login first.<br>";
    echo '<a href="index.php/admin/auth/login">Login here</a>';
    exit;
}

// Get current user
$user = $CI->ion_auth->user()->row();
echo "Current User: " . $user->email . "<br>";

// Check current groups
$user_groups = $CI->ion_auth->get_users_groups($user->id)->result();
echo "Current Groups: ";
foreach($user_groups as $group) {
    echo $group->name . " ";
}
echo "<br>";

// Check if admin group exists
$admin_group = $CI->ion_auth->group('admin')->row();
if (!$admin_group) {
    echo "Admin group doesn't exist. Creating it...<br>";
    $CI->ion_auth->create_group('admin', 'Administrator');
    $admin_group = $CI->ion_auth->group('admin')->row();
}
echo "Admin Group ID: " . $admin_group->id . "<br>";

// Check if user is in admin group
$is_admin = $CI->ion_auth->is_admin();
echo "Is Admin: " . ($is_admin ? 'YES' : 'NO') . "<br>";

// If not admin, add to admin group
if (!$is_admin) {
    echo "Adding user to admin group...<br>";
    $result = $CI->ion_auth->add_to_group($admin_group->id, $user->id);
    if ($result) {
        echo "Success! User added to admin group.<br>";
        echo "Please refresh this page to verify.<br>";
    } else {
        echo "Error adding user to admin group: " . $CI->ion_auth->errors() . "<br>";
    }
}

echo "<br><a href='index.php/admin/auth'>Go to Admin Panel</a>";
?>