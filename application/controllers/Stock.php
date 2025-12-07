<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

    /**
     * Stock model
     *
     * @var object
     */
    public $Stock_model;

    /**
     * Pagination library
     *
     * @var object
     */
    public $pagination;

    public function __construct()
    {
        parent::__construct();
        
        // Load required libraries
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Stock_model');
        
        // Check if user is logged in
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }

    // Display stock listing
    public function index()
    {
        $data['title'] = 'Stock Management';
        
        // Pagination configuration
        $config['base_url'] = base_url('stock/index');
        $config['total_rows'] = $this->Stock_model->count_stock();
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;
        
        // Pagination styling
        $config['full_tag_open'] = '<ul class="pagination justify-content-end">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');
        
        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['stock'] = $this->Stock_model->get_stock($config['per_page'], $page);
        $data['pagination'] = array(
            'links' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'per_page' => $config['per_page'],
            'offset' => $page
        );
        
        $this->load->view('stock/index', $data);
    }

    // Display stock adjustments
    public function adjustment()
    {
        $data['title'] = 'Stock Adjustments';
        
        // Pagination configuration
        $config['base_url'] = base_url('stock/adjustment');
        $config['total_rows'] = $this->Stock_model->count_adjustments();
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;
        
        // Pagination styling
        $config['full_tag_open'] = '<ul class="pagination justify-content-end">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');
        
        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['adjustments'] = $this->Stock_model->get_adjustments($config['per_page'], $page);
        $data['pagination'] = array(
            'links' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'per_page' => $config['per_page'],
            'offset' => $page
        );
        
        $this->load->view('stock/adjustment_list', $data);
    }

    // Add new stock adjustment - display form and process form
    public function add_adjustment()
    {
        // Check if form is submitted
        if ($this->input->method() === 'post') {
            // Validation rules
            $this->form_validation->set_rules('adjustment_date', 'Adjustment Date', 'required');
            $this->form_validation->set_rules('branch_id', 'Branch', 'required|numeric');
            $this->form_validation->set_rules('product_id', 'Product', 'required|numeric');
            $this->form_validation->set_rules('adjustment_type', 'Adjustment Type', 'required|in_list[increase,decrease]');
            $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('remarks', 'Remarks', 'required');

            if ($this->form_validation->run() == TRUE) {
                $this->_process_adjustment();
                return;
            }
        }

        // Display form
        $data['title'] = 'Add Stock Adjustment';
        $data['branches'] = $this->Stock_model->get_branches();
        
        $this->load->view('stock/add_adjustment', $data);
    }

    // Process stock adjustment
    private function _process_adjustment()
    {

        // Prepare adjustment data
        $adjustment_date = $this->input->post('adjustment_date');
        // Convert date from dd/mm/yyyy to yyyy-mm-dd
        $date_parts = explode('/', $adjustment_date);
        if (count($date_parts) == 3) {
            $adjustment_date = $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0];
        }

        $adjustment_data = array(
            'product_id' => $this->input->post('product_id'),
            'branch_id' => $this->input->post('branch_id'),
            'adjustment_type' => $this->input->post('adjustment_type'),
            'quantity' => $this->input->post('quantity'),
            'adjustment_date' => $adjustment_date,
            'remarks' => $this->input->post('remarks'),
            'created_by' => $this->ion_auth->user()->row()->id,
            'created_at' => date('Y-m-d H:i:s')
        );

        // Get current stock
        $current_stock = $this->Stock_model->get_current_stock(
            $adjustment_data['product_id'], 
            $adjustment_data['branch_id']
        );

        $adjustment_data['previous_stock'] = $current_stock;

        // Calculate new stock
        if ($adjustment_data['adjustment_type'] == 'increase') {
            $adjustment_data['new_stock'] = $current_stock + $adjustment_data['quantity'];
        } else {
            $adjustment_data['new_stock'] = $current_stock - $adjustment_data['quantity'];
            
            // Check if new stock would be negative
            if ($adjustment_data['new_stock'] < 0) {
                $this->session->set_flashdata('error', 'Cannot decrease stock below zero. Current stock is ' . number_format($current_stock, 2));
                redirect('stock/add_adjustment');
                return;
            }
        }

        // Start transaction
        $this->db->trans_start();

        // Create adjustment record
        $adjustment_id = $this->Stock_model->create_adjustment($adjustment_data);

        if ($adjustment_id) {
            // Update stock
            $stock_update = $this->Stock_model->update_stock(
                $adjustment_data['product_id'],
                $adjustment_data['branch_id'],
                $adjustment_data['new_stock']
            );

            if ($stock_update) {
                $this->db->trans_commit();
                $this->session->set_flashdata('success', 'Stock adjustment created successfully.');
                redirect('stock/adjustment');
            } else {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Failed to update stock. Please try again.');
                redirect('stock/add_adjustment');
            }
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Failed to create adjustment. Please try again.');
            redirect('stock/add_adjustment');
        }
    }

    // View specific adjustment
    public function view_adjustment($id = null)
    {
        if (!$id || !is_numeric($id)) {
            show_404();
        }

        $adjustment = $this->Stock_model->get_adjustment_by_id($id);
        
        if (!$adjustment) {
            show_404();
        }

        $data['title'] = 'View Stock Adjustment';
        $data['adjustment'] = $adjustment;
        
        $this->load->view('stock/view_adjustment', $data);
    }

    // Delete adjustment (soft delete)
    public function delete_adjustment($id = null)
    {
        if (!$id || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'Invalid adjustment ID.');
            redirect('stock/adjustment');
            return;
        }

        // Get adjustment details before deletion
        $adjustment = $this->Stock_model->get_adjustment_by_id($id);
        
        if (!$adjustment) {
            $this->session->set_flashdata('error', 'Adjustment not found.');
            redirect('stock/adjustment');
            return;
        }

        // Start transaction
        $this->db->trans_start();

        // Reverse the stock adjustment
        $current_stock = $this->Stock_model->get_current_stock($adjustment->product_id, $adjustment->branch_id);
        
        if ($adjustment->adjustment_type == 'increase') {
            // Reverse increase (subtract the quantity)
            $new_stock = $current_stock - $adjustment->quantity;
        } else {
            // Reverse decrease (add the quantity)
            $new_stock = $current_stock + $adjustment->quantity;
        }

        // Check if reversal would result in negative stock
        if ($new_stock < 0) {
            $this->session->set_flashdata('error', 'Cannot delete adjustment: would result in negative stock.');
            redirect('stock/adjustment');
            return;
        }

        // Update stock
        $stock_updated = $this->Stock_model->update_stock($adjustment->product_id, $adjustment->branch_id, $new_stock);

        if ($stock_updated) {
            // Soft delete the adjustment
            $delete_data = array(
                'deleted' => 1,
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => $this->ion_auth->user()->row()->id
            );

            $this->db->where('id', $id);
            $deleted = $this->db->update('stock_adjustments', $delete_data);

            if ($deleted) {
                $this->db->trans_commit();
                $this->session->set_flashdata('success', 'Stock adjustment deleted successfully.');
            } else {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Failed to delete adjustment.');
            }
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Failed to reverse stock changes.');
        }

        redirect('stock/adjustment');
    }

    // AJAX: Get products by branch
    public function get_products_by_branch()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $branch_id = $this->input->post('branch_id');
        
        if (!$branch_id || !is_numeric($branch_id)) {
            echo json_encode(array('success' => false, 'message' => 'Invalid branch ID'));
            return;
        }

        $products = $this->Stock_model->get_products_by_branch($branch_id);
        
        echo json_encode(array(
            'success' => true,
            'products' => $products
        ));
    }

    // AJAX: Get current stock for a product in a branch
    public function get_current_stock_ajax()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $product_id = $this->input->post('product_id');
        $branch_id = $this->input->post('branch_id');
        
        if (!$product_id || !is_numeric($product_id) || !$branch_id || !is_numeric($branch_id)) {
            echo json_encode(array('success' => false, 'message' => 'Invalid parameters'));
            return;
        }

        $stock = $this->Stock_model->get_current_stock($product_id, $branch_id);
        
        echo json_encode(array(
            'success' => true,
            'stock' => $stock
        ));
    }
}