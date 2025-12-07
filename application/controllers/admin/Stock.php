<?php defined('BASEPATH') or exit('No direct script access allowed');

class Stock extends CI_Controller
{
    /**
     * Common model
     *
     * @var object
     */
    public $common_model;

    /**
     * Payment model
     *
     * @var object
     */
    public $payment_model;

    /**
     * Stock model
     *
     * @var object
     */
    public $stock_model;

    /**
     * Pagination library
     *
     * @var object
     */
    public $pagination;

    public function __construct()
    {

        parent::__construct();
        $this->load->database();

        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('common_model');
        $this->load->model('payment_model');
        $this->load->model('stock_model');
        //$this->load->model('admin/production_model');
        $this->load->database();
        $this->lang->load('auth');
        $this->load->helper('language');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('session');
        $this->data['year_id'] = $this->common_model->get_fa();
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

    }

    public function index()
    {
        $this->data['products'] = $products = $this->stock_model->get_product();
        $this->data['branches'] = $branches = $this->stock_model->get_branch();
        $allstock = array();
        foreach ($products as $pr) {
            $st = array();
            foreach ($branches as $br) {
                $cond['product_id'] = $pr['id'];
                $cond['branch_id'] = $br['id'];
                $stock = $this->stock_model->get_stock($cond);
                $st[] = $stock;
            }
            $pr['stock'] = $st;
            $allstock[] = $pr;
        }

        $this->data['allstock'] = $allstock;
        $this->load->view("common/header");
        $this->load->view("stock/stock", $this->data);
        $this->load->view("common/footer");
    }

    public function material()
    {
        $this->data['products'] = $products = $this->stock_model->get_material();
        $this->data['branches'] = $branches = $this->stock_model->get_branch();
        $allstock = array();
        foreach ($products as $pr) {
            $st = array();
            foreach ($branches as $br) {
                $cond['material_id'] = $pr['id'];
                $cond['branch_id'] = $br['id'];
                $stock = $this->stock_model->get_matstock($cond);
                $st[] = $stock;
            }
            $pr['stock'] = $st;
            $allstock[] = $pr;
        }

        $this->data['allstock'] = $allstock;
        $this->load->view("common/header");
        $this->load->view("stock/matstock", $this->data);
        $this->load->view("common/footer");
    }

    /**
     * Stock Adjustment List View
     * Display all stock adjustments with pagination
     */
    public function adjustment($page = null)
    {
        $branch_id = $this->session->userdata('branch_id');
        
        // Get total count for pagination
        $total_rows = $this->stock_model->count_adjustments($branch_id);
        
        // Pagination configuration
        $this->load->library('pagination');
        $config['base_url'] = site_url('admin/stock/adjustment');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = true;
        $config['cur_tag_open'] = '<li><a style="color:red">';
        $config['cur_tag_close'] = '</a></li>';
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $this->pagination->initialize($config);
        
        // Get adjustments for current page
        $this->data['adjustments'] = $this->stock_model->get_adjustments($page, $branch_id, $config['per_page']);
       
     
        $this->data['pagination'] = $this->pagination->create_links();
        
        $this->load->view("common/header");
        $this->load->view("stock/adjustment_list", $this->data);
        $this->load->view("common/footer");
    }

    /**
     * Add Stock Adjustment
     * Create new stock adjustment with validation
     */
    public function add_adjustment()
    {
        $branch_id = $this->session->userdata('branch_id');
        $user_id = $this->session->userdata('user_id');
        
        // Load required data
        $this->data['products'] = $this->stock_model->get_product();
        $this->data['title'] = "Add Stock Adjustment";
        
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        // Set validation rules
        $this->form_validation->set_rules('product_id', 'Product', 'required|integer');
        $this->form_validation->set_rules('adjustment_type', 'Adjustment Type', 'required|in_list[increase,decrease]');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('adjustment_date', 'Adjustment Date', 'required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'required|min_length[5]|max_length[500]');

        if ($this->form_validation->run() == true) {
            $product_id = $this->input->post('product_id');
            $adjustment_type = $this->input->post('adjustment_type');
            $quantity = floatval($this->input->post('quantity'));
            $adjustment_date = date('Y-m-d', strtotime($this->input->post('adjustment_date')));
            $remarks = trim($this->input->post('remarks'));
            
            // Check if product exists in stock table
            $current_stock = $this->stock_model->get_current_stock($product_id, $branch_id);
            
            // Calculate new stock quantity
            if ($adjustment_type == 'increase') {
                $new_quantity = $current_stock + $quantity;
                $adjustment_quantity = $quantity;
            } else {
                // For decrease, check if sufficient stock exists
                if ($current_stock < $quantity) {
                    $this->session->set_flashdata('error', 'Insufficient stock! Current stock: ' . $current_stock . ', Requested decrease: ' . $quantity);
                    redirect('admin/stock/add_adjustment');
                    return;
                }
                $new_quantity = $current_stock - $quantity;
                $adjustment_quantity = -$quantity; // Store as negative for decrease
            }
            
            // Prepare adjustment data
            $adjustment_data = array(
                'product_id' => $product_id,
                'branch_id' => $branch_id,
                'adjustment_type' => $adjustment_type,
                'quantity' => $adjustment_quantity,
                'previous_stock' => $current_stock,
                'new_stock' => $new_quantity,
                'adjustment_date' => $adjustment_date,
                'remarks' => $remarks,
                'created_by' => $user_id,
                'created_at' => date('Y-m-d H:i:s')
            );
            
            // Start transaction
            $this->db->trans_start();
            
            try {
                // Add approval fields to adjustment data
                $adjustment_data['approval_status'] = 'pending';
                $adjustment_data['stock_updated'] = 0;
                
                // Insert adjustment record
                $adjustment_id = $this->stock_model->create_adjustment($adjustment_data);
                
                if ($adjustment_id) {
                    // Do not update stock table immediately - wait for approval
                    
                    $this->db->trans_complete();
                    
                    if ($this->db->trans_status() === FALSE) {
                        $this->session->set_flashdata('error', 'Error processing stock adjustment. Please try again.');
                    } else {
                        $this->session->set_flashdata('success', 'Stock adjustment created successfully and is pending approval!');
                        redirect('admin/stock/adjustment');
                    }
                } else {
                    throw new Exception('Failed to create adjustment record');
                }
            } catch (Exception $e) {
                $this->db->trans_rollback();
                log_message('error', 'Stock adjustment error: ' . $e->getMessage());
                $this->session->set_flashdata('error', 'Error creating stock adjustment: ' . $e->getMessage());
            }
        }
        
        // Handle validation errors or display form
        $this->data['message'] = (validation_errors() ? validation_errors() : 
            ($this->ion_auth->errors() ? $this->ion_auth->errors() : 
            ($this->session->flashdata('error') ? $this->session->flashdata('error') : 
            $this->session->flashdata('message'))));
        
        // Preserve form data on validation failure
        $this->data['product_id'] = $this->input->post('product_id') ? $this->input->post('product_id') : '';
        $this->data['adjustment_type'] = $this->input->post('adjustment_type') ? $this->input->post('adjustment_type') : '';
        $this->data['quantity'] = $this->input->post('quantity') ? $this->input->post('quantity') : '';
        $this->data['adjustment_date'] = $this->input->post('adjustment_date') ? $this->input->post('adjustment_date') : date('d-m-Y');
        $this->data['remarks'] = $this->input->post('remarks') ? $this->input->post('remarks') : '';

        $this->load->view("common/header");
        $this->load->view("stock/add_adjustment", $this->data);
        $this->load->view("common/footer");
    }

    /**
     * View Stock Adjustment Details
     */
    public function view_adjustment($id)
    {
        $adjustment = $this->stock_model->get_adjustment_by_id($id);
        
        if (!$adjustment) {
            $this->session->set_flashdata('error', 'Adjustment record not found.');
            redirect('admin/stock/adjustment');
        }
        
        $this->data['adjustment'] = $adjustment;
        
        $this->load->view("common/header");
        $this->load->view("stock/view_adjustment", $this->data);
        $this->load->view("common/footer");
    }

    /**
     * Delete Stock Adjustment (Soft delete)
     */
    public function delete_adjustment($id)
    {
        $adjustment = $this->stock_model->get_adjustment_by_id($id);
        
        if (!$adjustment) {
            $this->session->set_flashdata('error', 'Adjustment record not found.');
            redirect('admin/stock/adjustment');
        }
        
        // Soft delete the adjustment
        $delete_data = array(
            'deleted' => 1,
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => $this->session->userdata('user_id')
        );
        
        if ($this->stock_model->update_adjustment($id, $delete_data)) {
            $this->session->set_flashdata('success', 'Stock adjustment deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Error deleting stock adjustment.');
        }
        
        redirect('admin/stock/adjustment');
    }

    /**
     * Test AJAX functionality
     */
    public function test_ajax()
    {
        $this->data['products'] = $this->stock_model->get_product();
        $this->load->view("common/header");
        $this->load->view("stock/test_ajax", $this->data);
        $this->load->view("common/footer");
    }

    /**
     * AJAX: Get current stock for a product
     */
    public function get_current_stock()
    {
        // Allow both AJAX and direct POST requests for debugging
        $product_id = $this->input->post('product_id');
        $branch_id = $this->session->userdata('branch_id');
        
        // Set content type to JSON
        $this->output->set_content_type('application/json');
        
        if (!$product_id || !is_numeric($product_id)) {
            $this->output->set_output(json_encode(array(
                'success' => false, 
                'message' => 'Invalid product ID',
                'debug' => array(
                    'product_id' => $product_id,
                    'branch_id' => $branch_id
                )
            )));
            return;
        }

        try {
            $stock = $this->stock_model->get_current_stock($product_id, $branch_id);
            
            $this->output->set_output(json_encode(array(
                'success' => true,
                'stock' => number_format($stock, 2),
                'raw_stock' => $stock,
                'debug' => array(
                    'product_id' => $product_id,
                    'branch_id' => $branch_id
                )
            )));
        } catch (Exception $e) {
            $this->output->set_output(json_encode(array(
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'debug' => array(
                    'product_id' => $product_id,
                    'branch_id' => $branch_id
                )
            )));
        }
    }

    /**
     * Approve Stock Adjustment and Update Stock
     */
    public function approve_adjustment($id)
    {
        $adjustment = $this->stock_model->get_adjustment_by_id($id);
        
        if (!$adjustment) {
            $this->session->set_flashdata('error', 'Adjustment record not found.');
            redirect('admin/stock/adjustment');
        }
        
        // Check if already approved
        if ($adjustment['approval_status'] == 'approved') {
            $this->session->set_flashdata('error', 'This adjustment is already approved.');
            redirect('admin/stock/adjustment');
        }
        
        $branch_id = $this->session->userdata('branch_id');
        $user_id = $this->session->userdata('user_id');
        
        // Start transaction
        $this->db->trans_start();
        
        try {
            // Get current stock
            $current_stock = $this->stock_model->get_current_stock($adjustment['product_id'], $branch_id);
            
            // Calculate new stock based on adjustment
            if ($adjustment['adjustment_type'] == 'increase') {
                $new_stock = $current_stock + abs($adjustment['quantity']);
            } else {
                $new_stock = $current_stock - abs($adjustment['quantity']);
                
                // Check if new stock would be negative
                if ($new_stock < 0) {
                    $this->session->set_flashdata('error', 'Cannot approve adjustment: would result in negative stock. Current stock: ' . number_format($current_stock, 2));
                    redirect('admin/stock/adjustment');
                    return;
                }
            }
            
            // Update stock
            $stock_updated = $this->stock_model->update_stock($adjustment['product_id'], $branch_id, $new_stock);
            
            if ($stock_updated) {
                // Update adjustment status
                $approval_data = array(
                    'approval_status' => 'approved',
                    'approved_by' => $user_id,
                    'approved_at' => date('Y-m-d H:i:s'),
                    'stock_updated' => 1
                );
                
                $this->stock_model->update_adjustment($id, $approval_data);
                
                $this->db->trans_commit();
                $this->session->set_flashdata('success', 'Stock adjustment approved and stock updated successfully.');
            } else {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Failed to update stock. Please try again.');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Stock approval error: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Error approving adjustment: ' . $e->getMessage());
        }
        
        redirect('admin/stock/adjustment');
    }

    /**
     * Reject Stock Adjustment
     */
    public function reject_adjustment($id)
    {
        $adjustment = $this->stock_model->get_adjustment_by_id($id);
        
        if (!$adjustment) {
            $this->session->set_flashdata('error', 'Adjustment record not found.');
            redirect('admin/stock/adjustment');
        }
        
        // Check if already processed
        if ($adjustment['approval_status'] != 'pending') {
            $this->session->set_flashdata('error', 'This adjustment has already been processed.');
            redirect('admin/stock/adjustment');
        }
        
        $user_id = $this->session->userdata('user_id');
        
        // Update adjustment status
        $rejection_data = array(
            'approval_status' => 'rejected',
            'approved_by' => $user_id,
            'approved_at' => date('Y-m-d H:i:s'),
            'stock_updated' => 0
        );
        
        if ($this->stock_model->update_adjustment($id, $rejection_data)) {
            $this->session->set_flashdata('success', 'Stock adjustment rejected successfully.');
        } else {
            $this->session->set_flashdata('error', 'Error rejecting adjustment.');
        }
        
        redirect('admin/stock/adjustment');
    }

}
