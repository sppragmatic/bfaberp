<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Labour_group extends CI_Controller {

    /**
     * Labour group model
     *
     * @var object
     */
    public $Labour_group_model;

    public function __construct() {
        parent::__construct();
        // Load essential libraries that are NOT auto-loaded
        $this->load->model('Labour_group_model');
        $this->load->library('form_validation');
    }

    /**
     * Display list of all labour groups
     */
    public function index() {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Labour Groups Management</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%); min-height: 100vh; }
                .container { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
                h1 { color: #2c3e50; margin-bottom: 30px; }
                .btn { padding: 10px 20px; background: #3498db; color: white; text-decoration: none; border-radius: 5px; margin: 5px; display: inline-block; }
                .btn:hover { background: #2c3e50; }
                table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
                th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
                tr:hover { background: #f8f9fa; }
                .success { color: green; background: #d4edda; padding: 10px; border-radius: 5px; margin: 10px 0; }
                .error { color: red; background: #f8d7da; padding: 10px; border-radius: 5px; margin: 10px 0; }
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>🏗️ Labour Groups Management</h1>";
        
        // Show flash messages
        if ($this->session->flashdata('success')) {
            echo "<div class='success'>✅ " . $this->session->flashdata('success') . "</div>";
        }
        if ($this->session->flashdata('error')) {
            echo "<div class='error'>❌ " . $this->session->flashdata('error') . "</div>";
        }
        
        echo "<p><a href='" . site_url('admin/labour_group/create') . "' class='btn'>➕ Add New Labour Group</a></p>";
        
        try {
            $labour_groups = $this->Labour_group_model->get_all_labour_groups();
            
            if (empty($labour_groups)) {
                echo "<p>No labour groups found. <a href='" . site_url('admin/labour_group/create') . "'>Create the first one!</a></p>";
            } else {
                echo "<table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>";
                
                foreach ($labour_groups as $group) {
                    echo "<tr>
                        <td>" . $group['id'] . "</td>
                        <td><strong>" . htmlspecialchars($group['name']) . "</strong></td>
                        <td>" . htmlspecialchars(substr($group['description'] ?: 'No description', 0, 50)) . "...</td>
                        <td>" . date('M j, Y', strtotime($group['created_at'])) . "</td>
                        <td>" . ($group['created_by'] ?: 'System') . "</td>
                        <td>
                            <a href='" . site_url('admin/labour_group/view/' . $group['id']) . "' class='btn' style='background: #28a745;'>👁️ View</a>
                            <a href='" . site_url('admin/labour_group/edit/' . $group['id']) . "' class='btn' style='background: #ffc107;'>✏️ Edit</a>
                            <a href='" . site_url('admin/labour_group/delete/' . $group['id']) . "' class='btn' style='background: #dc3545;' onclick='return confirm(\"Are you sure?\")'>🗑️ Delete</a>
                        </td>
                    </tr>";
                }
                
                echo "</tbody></table>";
            }
            
        } catch (Exception $e) {
            echo "<div class='error'>Error loading labour groups: " . $e->getMessage() . "</div>";
        }
        
        echo "</div></body></html>";
    }

    /**
     * Show form to create new labour group
     */
    public function create() {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Create Labour Group</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%); min-height: 100vh; }
                .container { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto; }
                h1 { color: #2c3e50; margin-bottom: 30px; }
                .form-group { margin-bottom: 20px; }
                label { display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50; }
                input[type='text'], textarea { width: 100%; padding: 12px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 14px; }
                input[type='text']:focus, textarea:focus { border-color: #3498db; outline: none; }
                textarea { resize: vertical; height: 120px; }
                .btn { padding: 12px 24px; background: #3498db; color: white; border: none; border-radius: 8px; cursor: pointer; text-decoration: none; display: inline-block; margin: 5px; }
                .btn:hover { background: #2c3e50; }
                .btn-secondary { background: #6c757d; }
                .error { color: red; font-size: 12px; margin-top: 5px; }
                .form-errors { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>➕ Create New Labour Group</h1>";
        
        // Show validation errors
        if (validation_errors()) {
            echo "<div class='form-errors'>" . validation_errors() . "</div>";
        }
        
        echo form_open('admin/labour_group/store');
        
        echo "<div class='form-group'>
                <label for='name'>Labour Group Name *</label>
                <input type='text' id='name' name='name' value='" . set_value('name') . "' required maxlength='100'>
                " . form_error('name', '<div class="error">', '</div>') . "
              </div>";
        
        echo "<div class='form-group'>
                <label for='description'>Description</label>
                <textarea id='description' name='description' placeholder='Enter a brief description of this labour group...' maxlength='500'>" . set_value('description') . "</textarea>
                " . form_error('description', '<div class="error">', '</div>') . "
              </div>";
        
        echo "<div class='form-group'>
                <button type='submit' class='btn'>💾 Create Labour Group</button>
                <a href='" . site_url('admin/labour_group') . "' class='btn btn-secondary'>↩️ Cancel</a>
              </div>";
        
        echo form_close();
        echo "</div></body></html>";
    }

    /**
     * Store new labour group
     */
    public function store() {
        // Set validation rules
        $this->form_validation->set_rules('name', 'Labour Group Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('description', 'Description', 'trim|max_length[500]');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, show form again with errors
            $this->create();
        } else {
            // Validation passed, insert data
            $insert_data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'created_by' => 'Admin'
            );

            $result = $this->Labour_group_model->insert_labour_group($insert_data);

            if ($result) {
                $this->session->set_flashdata('success', 'Labour Group "' . $this->input->post('name') . '" created successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to create Labour Group. Please try again.');
            }

            redirect('admin/labour_group');
        }
    }

    /**
     * View labour group details
     */
    public function view($id = null) {
        if (!$id || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'Invalid labour group ID.');
            redirect('admin/labour_group');
        }

        $labour_group = $this->Labour_group_model->get_labour_group_by_id($id);
        if (!$labour_group) {
            $this->session->set_flashdata('error', 'Labour group not found.');
            redirect('admin/labour_group');
        }

        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>View Labour Group</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%); min-height: 100vh; }
                .container { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); max-width: 800px; margin: 0 auto; }
                h1 { color: #2c3e50; margin-bottom: 30px; }
                .btn { padding: 12px 24px; background: #3498db; color: white; border: none; border-radius: 8px; cursor: pointer; text-decoration: none; display: inline-block; margin: 5px; }
                .btn:hover { background: #2c3e50; }
                .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0; }
                .info-card { background: #f8f9fa; padding: 20px; border-radius: 10px; }
                .info-card h3 { margin: 0 0 15px 0; color: #2c3e50; }
                .info-item { margin-bottom: 10px; }
                .info-item label { font-weight: 600; color: #6c757d; }
                .description { background: #e9ecef; padding: 15px; border-radius: 8px; margin: 20px 0; }
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>👁️ Labour Group Details</h1>
                
                <h2>" . htmlspecialchars($labour_group['name']) . " <small>(ID: " . $labour_group['id'] . ")</small></h2>";
        
        if (!empty($labour_group['description'])) {
            echo "<div class='description'>
                    <h4>📝 Description</h4>
                    <p>" . nl2br(htmlspecialchars($labour_group['description'])) . "</p>
                  </div>";
        } else {
            echo "<div class='description'>
                    <p><em>No description provided for this labour group.</em></p>
                  </div>";
        }
        
        echo "<div class='info-grid'>
                <div class='info-card'>
                    <h3>📅 Creation Information</h3>
                    <div class='info-item'>
                        <label>Created:</label> " . date('l, F j, Y \a\t g:i A', strtotime($labour_group['created_at'])) . "
                    </div>
                    <div class='info-item'>
                        <label>Created By:</label> " . ($labour_group['created_by'] ?: 'System') . "
                    </div>
                </div>
                
                <div class='info-card'>
                    <h3>🔄 Last Modified</h3>
                    <div class='info-item'>
                        <label>Updated:</label> " . date('l, F j, Y \a\t g:i A', strtotime($labour_group['updated_at'])) . "
                    </div>
                    <div class='info-item'>
                        <label>Updated By:</label> " . ($labour_group['updated_by'] ?: 'System') . "
                    </div>
                </div>
              </div>";
        
        echo "<div style='margin-top: 30px;'>
                <a href='" . site_url('admin/labour_group/edit/' . $labour_group['id']) . "' class='btn' style='background: #ffc107;'>✏️ Edit</a>
                <a href='" . site_url('admin/labour_group') . "' class='btn' style='background: #6c757d;'>↩️ Back to List</a>
                <a href='" . site_url('admin/labour_group/delete/' . $labour_group['id']) . "' class='btn' style='background: #dc3545;' onclick='return confirm(\"Are you sure you want to delete this labour group?\")'>🗑️ Delete</a>
              </div>";
        
        echo "</div></body></html>";
    }

    /**
     * Delete labour group
     */
    public function delete($id = null) {
        if (!$id || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'Invalid Labour Group ID.');
            redirect('admin/labour_group');
        }

        $labour_group = $this->Labour_group_model->get_labour_group_by_id($id);
        
        if (!$labour_group) {
            $this->session->set_flashdata('error', 'Labour Group not found.');
            redirect('admin/labour_group');
        }

        $result = $this->Labour_group_model->delete_labour_group($id);

        if ($result) {
            $this->session->set_flashdata('success', 'Labour Group "' . $labour_group['name'] . '" deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete Labour Group. Please try again.');
        }

        redirect('admin/labour_group');
    }
}
?>