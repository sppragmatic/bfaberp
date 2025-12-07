<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Labour_group extends CI_Controller {

    /**
     * Labour group model
     *
     * @var object
     */
    public $Labour_group_model;

    /**
     * Common model
     *
     * @var object
     */
    public $common_model;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('Labour_group_model');
        $this->load->model('common_model');
        $this->load->helper(array('form', 'url'));
        
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }
    }

    // Display all labour groups
    public function index() {
        // Clear any irrelevant error messages from other modules
        $this->_clearIrrelevantFlashMessages();
        
        // Get all labour groups from the model
        $data['labour_groups'] = $this->Labour_group_model->get_all_labour_groups();
        
        // Load views with common header/footer
        $this->load->view("common/header");
        $this->load->view('admin/labour_group/listing_labour_group', $data);
        $this->load->view("common/footer");
    }

    /**
     * Clear flash messages that are not related to Labour Groups
     */
    private function _clearIrrelevantFlashMessages() {
        $current_error = $this->session->flashdata('error');
        
        // If the error message is about production, clear it since we're in labour group context
        if ($current_error && (
            strpos($current_error, 'Production') !== false || 
            strpos($current_error, 'production') !== false
        )) {
            $this->session->unset_userdata('flash:old:error');
            $this->session->unset_userdata('flash:new:error');
        }
    }

    // Show create form
    public function create() {
        // Clear any irrelevant error messages from other modules
        $this->_clearIrrelevantFlashMessages();
        
        $data['title'] = 'Create New Labour Group';
        $data['action'] = 'create';

        $this->load->view("common/header");
        $this->load->view('admin/labour_group/create_labour_group', $data);
        $this->load->view("common/footer");
    }    // Handle form submission for creating new labour group
    public function store() {
        // Set validation rules
        $this->form_validation->set_rules('name', 'Labour Group Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('description', 'Description', 'trim|max_length[500]');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, show form again with errors
            $data['title'] = 'Create New Labour Group';
            $data['action'] = 'create';
            $this->load->view("common/header");
            $this->load->view('admin/labour_group/create_labour_group', $data);
            $this->load->view("common/footer");
        } else {
            // Validation passed, prepare data for insertion
            $insert_data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'branch_id' => 1, // Default branch ID
                'entry_date' => date('Y-m-d H:i:s'),
                'entry_by' => 1 // Default user ID
            );

            $result = $this->Labour_group_model->insert_labour_group($insert_data);

            if ($result) {
                $this->session->set_flashdata('success', 'Labour Group created successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to create Labour Group. Please try again.');
            }
            
            redirect('admin/labour_group');
        }
    }

    // Show edit form
    public function edit($id = null) {
        // Clear any irrelevant error messages from other modules
        $this->_clearIrrelevantFlashMessages();
        
        if (!$id || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'Invalid Labour Group ID.');
            redirect('admin/labour_group');
        }

        $labour_group = $this->Labour_group_model->get_labour_group_by_id($id);

        if (!$labour_group) {
            $this->session->set_flashdata('error', 'Labour Group not found.');
            redirect('admin/labour_group');
        }

        $data['labour_group'] = $labour_group;
        $data['title'] = 'Edit Labour Group';
        $data['action'] = 'edit';

        $this->load->view("common/header");
        $this->load->view('admin/labour_group/edit_labour_group', $data);
        $this->load->view("common/footer");
    }

    // Handle form submission for updating labour group
    public function update($id = null) {
        if (!$id || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'Invalid Labour Group ID.');
            redirect('admin/labour_group');
        }

        // Set validation rules
        $this->form_validation->set_rules('name', 'Labour Group Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('description', 'Description', 'trim|max_length[500]');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, show form again with errors
            $labour_group = $this->Labour_group_model->get_labour_group_by_id($id);
            $data['labour_group'] = $labour_group;
            $data['title'] = 'Edit Labour Group';
            $data['action'] = 'edit';
            $this->load->view("common/header");
            $this->load->view('admin/labour_group/edit_labour_group', $data);
            $this->load->view("common/footer");
        } else {
            // Validation passed, prepare data for update
            $update_data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description')
            );

            $result = $this->Labour_group_model->update_labour_group($id, $update_data);

            if ($result) {
                $this->session->set_flashdata('success', 'Labour Group updated successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to update Labour Group. Please try again.');
            }
            
            redirect('admin/labour_group');
        }
    }

    // Show view details
    public function view($id = null) {
        // Clear any irrelevant error messages from other modules
        $this->_clearIrrelevantFlashMessages();
        
        if (!$id || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'Invalid Labour Group ID.');
            redirect('admin/labour_group');
        }

        $labour_group = $this->Labour_group_model->get_labour_group_by_id($id);

        if (!$labour_group) {
            $this->session->set_flashdata('error', 'Labour Group not found.');
            redirect('admin/labour_group');
        }

        $data['labour_group'] = $labour_group;
        $data['title'] = 'View Labour Group';

        $this->load->view("common/header");
        $this->load->view('admin/labour_group/view_labour_group', $data);
        $this->load->view("common/footer");
    }

    // Handle delete
    public function delete($id = null) {
        if (!$id || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'Invalid Labour Group ID.');
            redirect('admin/labour_group');
        }

        $result = $this->Labour_group_model->delete_labour_group($id);

        if ($result) {
            $this->session->set_flashdata('success', 'Labour Group deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete Labour Group. Please try again.');
        }
        
        redirect('admin/labour_group');
    }
}