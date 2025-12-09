<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Production Controller
 * 
 * Handles production management including creation, editing, approval, and deletion of production records
 * 
 * @category Controller
 * @package  Admin
 */
class Production extends CI_Controller
{
    /**
     * Production model
     *
     * @var object
     */
    public $production_model;

    /**
     * Common model
     *
     * @var object
     */
    public $common_model;

    /**
     * Sales model
     *
     * @var object
     */
    public $sales_model;

    /**
     * Stock model
     *
     * @var object
     */
    public $stock_model;

    /**
     * Labour group model
     *
     * @var object
     */
    public $Labour_group_model;

    /**
     * Data array for views
     *
     * @var array
     */
    public $data = [];

    /**
     * Constructor - Initialize required libraries, models and authentication
     */
    public function __construct()
    {
        parent::__construct();
        
        // Load database first (required by ion_auth)
        $this->load->database();
        
        // Load libraries in correct order
        $this->load->library('session');
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        
        // Load helpers
        $this->load->helper(['url', 'form', 'language']);
        
        // Load models
        $this->load->model('admin/production_model', 'production_model');
        $this->load->model('common_model');
        $this->load->model('sales_model');
        $this->load->model('stock_model');
        $this->load->model('Labour_group_model');
        
        // Load language
        $this->lang->load('auth');
        
        // Check authentication
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }
        
        // Set common data including financial year and branch
        $year_id = $this->common_model->get_fa();
        $this->data['year_id'] = (!empty($year_id) && is_numeric($year_id)) ? $year_id : 1;
        
        $branch_id = $this->session->userdata('branch_id');
        $this->data['branch_id'] = (!empty($branch_id) && is_numeric($branch_id)) ? $branch_id : 1;
    }

    /**
     * Get current financial year ID safely
     * 
     * @return int Financial year ID
     */
    private function _getYearId()
    {
        // Ensure year_id is always available and valid
        if (!isset($this->data['year_id']) || empty($this->data['year_id'])) {
            $year_id = $this->common_model->get_fa();
            $this->data['year_id'] = (!empty($year_id) && is_numeric($year_id)) ? $year_id : 1;
        }
        return $this->data['year_id'];
    }

    /**
     * Get current branch ID safely
     * 
     * @return int Branch ID
     */
    private function _getBranchId()
    {
        // Ensure branch_id is always available and valid
        if (!isset($this->data['branch_id']) || empty($this->data['branch_id'])) {
            $branch_id = $this->session->userdata('branch_id');
            $this->data['branch_id'] = (!empty($branch_id) && is_numeric($branch_id)) ? $branch_id : 1;
        }
        return $this->data['branch_id'];
    }

    /**
     * Display production listing (excluding deleted records)
     * 
     * @return void
     */
    public function index()
    {
        $branch_id = $this->session->userdata('branch_id');
        
        // Initialize search parameters
        $this->data = [
            'customer_id' => '',
            'branch_id' => '',
            'start_date' => '',
            'end_date' => '',
            'products' => $this->production_model->get_product()
        ];
        
        // Get production data with items (exclude deleted and filter by year)
        $production = $this->production_model->get_allproduction($branch_id, false, $this->_getYearId());
        $this->data['production'] = $this->_prepareProductionData($production);
        
        $this->_loadView('admin/production/listing_production');
    }

    /**
     * Search production records by date range (excluding deleted records)
     * 
     * @return void
     */
    public function search_production()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $branch_id = $this->session->userdata('branch_id');
        
        // Initialize data
        $this->data = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'customer_id' => '',
            'branch_id' => '',
            'products' => $this->production_model->get_product()
        ];
        
        // Build query using alternative approach to ensure table is selected properly
        $year_id = $this->_getYearId();
        
        // Use raw SQL for better reliability
        $date_condition = "";
        $params = array($branch_id, $year_id);
        
        if (!empty($start_date) && !empty($end_date)) {
            $start_formatted = date('Y-m-d', strtotime($start_date));
            $end_formatted = date('Y-m-d', strtotime($end_date));
            $date_condition = " AND production.date BETWEEN ? AND ?";
            $params[] = $start_formatted;
            $params[] = $end_formatted;
        }
        
        $sql = "SELECT production.*, branch.name 
                FROM production 
                INNER JOIN branch ON production.branch_id = branch.id 
                WHERE production.branch_id = ? 
                AND production.is_deleted = 0 
                AND production.year_id = ?" . $date_condition . "
                ORDER BY production.date DESC";
        
        $query = $this->db->query($sql, $params);
        $production = $query->result_array();
        $this->data['production'] = $this->_prepareProductionData($production);
        
        $this->_loadView('admin/production/listing_production');
    }

    /**
     * Admin search production records with branch and date filters (excluding deleted records)
     * 
     * @return void
     */
    public function admsearch_production()
    {
        $branch_id = $this->input->post('branch_id');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        
        // Initialize data
        $this->data = [
            'customer_id' => '',
            'branch_id' => $branch_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'products' => $this->production_model->get_product(),
            'branch' => $this->production_model->get_branch()
        ];
        
        // Build query using raw SQL for better reliability
        $year_id = $this->_getYearId();
        
        $date_condition = "";
        $branch_condition = "";
        $params = array($year_id);
        
        // Apply date filter if provided
        if (!empty($start_date) && !empty($end_date)) {
            $start_formatted = date('Y-m-d', strtotime($start_date));
            $end_formatted = date('Y-m-d', strtotime($end_date));
            $date_condition = " AND production.date BETWEEN ? AND ?";
            $params[] = $start_formatted;
            $params[] = $end_formatted;
        }
        
        // Apply branch filter if provided
        if (!empty($branch_id) && $branch_id != 0) {
            $branch_condition = " AND production.branch_id = ?";
            $params[] = $branch_id;
        }
        
        $sql = "SELECT production.*, branch.name 
                FROM production 
                INNER JOIN branch ON production.branch_id = branch.id 
                WHERE production.is_deleted = 0 
                AND production.year_id = ?" . $date_condition . $branch_condition . "
                ORDER BY production.date DESC";
        
        $query = $this->db->query($sql, $params);
        $production = $query->result_array();
        $this->data['production'] = $this->_prepareProductionData($production);
        
        $this->_loadView('admin/production/admin_production');
    }

    /**
     * Display admin production listing (excluding deleted records)
     * 
     * @return void
     */
    public function adminproduction()
    {
        $branch_id = $this->session->userdata('branch_id');
        
        // Initialize data
        $this->data = [
            'customer_id' => '',
            'branch_id' => '',
            'start_date' => '',
            'end_date' => '',
            'branch' => $this->production_model->get_branch(),
            'products' => $this->production_model->get_product()
        ];
        
        // Get production data with items (exclude deleted and filter by year)
        $production = $this->production_model->get_adminproduction($branch_id, false, $this->_getYearId());
        $this->data['production'] = $this->_prepareProductionData($production);
        
        $this->_loadView('admin/production/admin_production');
    }

    /**
     * Create new production record
     * 
     * @return void
     */
    public function create_production()
    {
        $branch_id = $this->session->userdata('branch_id');
        
        // Generate transaction number
        $br = $this->production_model->get_br($branch_id, $this->_getYearId());
        $this->data['products'] = $this->production_model->get_product();
        $this->data['materials'] = $this->stock_model->get_material();
        
        // Get labour groups from database
        $this->data['labour_groups'] = $this->Labour_group_model->get_labour_groups();
        
        $this->data['trans_no'] = "BFABPR" . $br;
        
        // Set validation rules
        $this->form_validation->set_rules('production[date]', 'Date', 'required|trim');
        
        if ($this->form_validation->run() === FALSE) {
            // Handle form display
            $production_data = $this->input->post('production');
            $this->data['date'] = isset($production_data['date']) && !empty($production_data['date']) 
                                ? $production_data['date'] 
                                : '';
            
            $this->_loadView('admin/production/create_production');
        } else {
            // Handle form submission
            $production_data = $this->input->post('production');
            $production_data['branch_id'] = $branch_id;
            $production_data['year_id'] = $this->_getYearId();
            $production_data['date'] = date('Y-m-d', strtotime($production_data['date']));
            $production_data['entry_by'] = $this->session->userdata('identity');
            $production_data['entry_date'] = date('Y-m-d H:i:s');
            
            // Process loading items and calculate loading total
            $loading_amount = 0;
            $loading_items = $this->input->post('loading');
            if (!empty($loading_items)) {
                foreach ($loading_items as $product_id => $loading_item) {
                    if (is_array($loading_item)) {
                        $quantity = isset($loading_item['quantity']) ? (float)$loading_item['quantity'] : 0;
                        $unit = isset($loading_item['unit']) ? (string)$loading_item['unit'] : "";
                        $rate = isset($loading_item['rate']) ? (float)$loading_item['rate'] : 0;
                        $amount = isset($loading_item['amount']) ? (float)$loading_item['amount'] : ($quantity * $rate);
                        
                        // Only add to total if there's meaningful data
                        if ($quantity > 0 && $amount > 0) {
                            $loading_amount += $amount;
                        }
                    }
                }
            }
            $production_data['loading_amount'] = $loading_amount;
            
            // Extract unloading data directly from production form data
            if (isset($production_data['unloading_qty'])) {
                $production_data['unloading_qty'] = (float)$production_data['unloading_qty'];
            }
            if (isset($production_data['unloading_unit'])) {
                $production_data['unloading_unit'] = (float)$production_data['unloading_unit'];
            }
            if (isset($production_data['unloading_rate'])) {
                $production_data['unloading_rate'] = (float)$production_data['unloading_rate'];
            }
            if (isset($production_data['unloading_amount'])) {
                $production_data['unloading_amount'] = (float)$production_data['unloading_amount'];
            }
            
            // Calculate grand total from all sources
            $unloading_amount = isset($production_data['unloading_amount']) ? (float)$production_data['unloading_amount'] : 0;
            
            // Calculate product total from prod items
            $product_total = 0;
            $prod_items = $this->input->post('prod');
            if (!empty($prod_items)) {
                foreach ($prod_items as $product_id => $item_data) {
                    if (is_array($item_data)) {
                        $amount = isset($item_data['amount']) ? (float)$item_data['amount'] : 0;
                        $product_total += $amount;
                    }
                }
            }
            
            // Store product total in prod_amount field
            $production_data['prod_amount'] = $product_total;
            
            // Set grand total (products + loading + unloading)
            $production_data['grand_total'] = $product_total + $loading_amount + $unloading_amount;
            
            // Start database transaction
            $this->db->trans_start();
            
            $production_id = $this->production_model->insert_production($production_data);
            
            if ($production_id && !empty($prod_items)) {
                $this->_insertProductionItems($prod_items, $production_id, $branch_id);
            }

            // Insert loading items if any
            if ($production_id && !empty($loading_items)) {
                $this->_insertLoadingItems($loading_items, $production_id, $branch_id);
            }

            // Insert unloading items if any
            $unloading_items = $this->input->post('unloading');
            log_message('debug', 'Unloading items from POST: ' . print_r($unloading_items, true));
            
            if ($production_id && !empty($unloading_items)) {
                log_message('debug', 'Calling _insertUnloadingItems with production_id: ' . $production_id);
                $this->_insertUnloadingItems($unloading_items, $production_id, $branch_id);
            } else {
                if (!$production_id) {
                    log_message('debug', 'Skipping unloading items - no production_id');
                }
                if (empty($unloading_items)) {
                    log_message('debug', 'Skipping unloading items - empty unloading data');
                }
            }
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'Failed to create production record');
            } else {
                $this->session->set_flashdata('success', 'Production record created successfully');
            }
            
            redirect('admin/production/');
        }
    }

    /**
     * Approve production and update stock (only for non-deleted records)
     * 
     * @param int $id Production ID
     * @return void
     */
    public function approve($id = null)
    {
        if (empty($id)) {
            show_404();
        }
        
        // Check if production exists and is not deleted using raw SQL
        $production_sql = "SELECT * FROM production 
                          WHERE id = ? 
                          AND is_deleted = 0 
                          AND year_id = ? 
                          AND branch_id = ?";
        $production_query = $this->db->query($production_sql, [$id, $this->_getYearId(), $this->_getBranchId()]);
        $production = $production_query->row_array();
        
        if (empty($production)) {
            $this->session->set_flashdata('error', 'Production record not found or has been deleted');
            redirect('admin/production');
        }
        
        // Get non-deleted items for this production using raw SQL
        $items_sql = "SELECT prod_item.*, product.name 
                     FROM prod_item 
                     INNER JOIN product ON prod_item.product_id = product.id 
                     WHERE prod_item.production_id = ? 
                     AND prod_item.is_deleted = 0 
                     AND prod_item.year_id = ? 
                     AND prod_item.branch_id = ?";
        $items_query = $this->db->query($items_sql, [$id, $this->_getYearId(), $this->_getBranchId()]);
        $items = $items_query->result_array();
        
        // if (empty($items)) {
        //     $this->session->set_flashdata('error', 'No items found for this production');
        //     redirect('admin/production');
        // }
        
        // Start database transaction
        $this->db->trans_start();
        
        try {
            // Update stock for each item
            foreach ($items as $item) {
                $this->_updateStock($item);
                $this->_updateProductionItemStatus($item['id'], 1);
            }
            
            // Update production status using raw SQL
            $update_production_sql = "UPDATE production SET status = 1 WHERE id = ?";
            $this->db->query($update_production_sql, [$id]);
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'Failed to approve production');
            } else {
                $this->session->set_flashdata('success', 'Production approved successfully');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Production approval failed: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'An error occurred while approving production');
        }
        
        redirect('admin/production');
    }

    /**
     * Approve production and update stock (alias for approve method)
     * 
     * @param int $id Production ID
     * @return void
     */
    public function approve_production($id = null)
    {
        // Call the existing approve method
        $this->approve($id);
    }

    /**
     * Edit production record (only non-deleted records)
     * 
     * @param int $id Production ID
     * @return void
     */
    public function edit_production($id = null)
    {
        if (empty($id)) {
            show_404();
        }
        
        // Check if production exists and is not deleted (filter by year and branch)
        $this->data['production'] = $this->db->get_where('production', [
            'id' => $id,
            'is_deleted' => 0,
            'year_id' => $this->_getYearId(),
            'branch_id' => $this->_getBranchId()
        ])->row_array();
        
        if (empty($this->data['production'])) {
            $this->session->set_flashdata('error', 'Production record not found or has been deleted');
            redirect('admin/production');
        }
        
        // Get all products and merge with existing production items
        $all_products = $this->production_model->get_product();
        $existing_items = $this->db->select('prod_item.*, product.name')
                                  ->from('prod_item')
                                  ->join('product', 'prod_item.product_id = product.id')
                                  ->where([
                                      'prod_item.production_id' => $id,
                                      'prod_item.is_deleted' => 0,
                                      'prod_item.year_id' => $this->_getYearId(),
                                      'prod_item.branch_id' => $this->_getBranchId()
                                  ])
                                  ->get()
                                  ->result_array();
        
        // Create array with existing production data indexed by product_id
        $existing_data = [];
        foreach ($existing_items as $item) {
            $existing_data[$item['product_id']] = [
                'stock' => $item['stock'],
                'quantity' => isset($item['quantity']) ? $item['quantity'] : $item['stock'],
                'rate' => isset($item['rate']) ? $item['rate'] : '',
                'amount' => isset($item['amount']) ? $item['amount'] : '',
                'loading_qty' => isset($item['loading_qty']) ? $item['loading_qty'] : '',
                'loading_rate' => isset($item['loading_rate']) ? $item['loading_rate'] : '',
                'loading_amount' => isset($item['loading_amount']) ? $item['loading_amount'] : '',
                'unloading_qty' => isset($item['unloading_qty']) ? $item['unloading_qty'] : '',
                'unloading_rate' => isset($item['unloading_rate']) ? $item['unloading_rate'] : '',
                'unloading_amount' => isset($item['unloading_amount']) ? $item['unloading_amount'] : ''
            ];
        }
        
        // Prepare products array with all products
        $products_array = [];
        foreach ($all_products as $product) {
            $product_data = [
                'id' => $product['id'], // This will be the product_id for form submission
                'name' => $product['name'],
                'stock' => isset($existing_data[$product['id']]['stock']) ? $existing_data[$product['id']]['stock'] : '',
                'quantity' => isset($existing_data[$product['id']]['quantity']) ? $existing_data[$product['id']]['quantity'] : '',
                'unit' => isset($existing_data[$product['id']]['unit']) ? $existing_data[$product['id']]['unit'] : '',
                'rate' => isset($existing_data[$product['id']]['rate']) ? $existing_data[$product['id']]['rate'] : '',
                'amount' => isset($existing_data[$product['id']]['amount']) ? $existing_data[$product['id']]['amount'] : ''
            ];
            $products_array[] = $product_data;
        }
        
        // Loading/unloading data is already in production record, no need to fetch from items
        // Data will be available in $this->data['production'] from the query above
        
        // Load existing loading items from transport table
        $loading_items = $this->_getLoadingItems($id);
        $loading_data = [];
        foreach ($loading_items as $item) {
            $loading_data[$item['product_id']] = [
                'quantity' => $item['quantity'],
                'rate' => $item['rate'],
                'unit' => $item['unit'],
                'amount' => $item['amount'],
                'labour_group_id' => isset($item['labour_group_id']) ? $item['labour_group_id'] : null
            ];
        }

        // Load existing unloading items from fly_ash_unloading table
        $unloading_items = $this->_getUnloadingItems($id);

        // Merge loading data into products array
        foreach ($products_array as $key => $product) {
            if (isset($loading_data[$product['id']])) {
                $products_array[$key]['loading_quantity'] = $loading_data[$product['id']]['quantity'];
                $products_array[$key]['loading_rate'] = $loading_data[$product['id']]['rate'];
                $products_array[$key]['loading_unit'] = $loading_data[$product['id']]['unit'];
                $products_array[$key]['loading_amount'] = $loading_data[$product['id']]['amount'];
                $products_array[$key]['loading_labour_group_id'] = $loading_data[$product['id']]['labour_group_id'];
            } else {
                $products_array[$key]['loading_quantity'] = '';
                $products_array[$key]['loading_rate'] = '';
                $products_array[$key]['loading_unit'] = '';
                $products_array[$key]['loading_amount'] = '';
                $products_array[$key]['loading_labour_group_id'] = null;
            }
        }

        $this->data['products'] = $products_array;
        
        // Get materials and labour groups for dynamic unloading section
        $this->data['materials'] = $this->stock_model->get_material();
        $this->data['labour_groups'] = $this->Labour_group_model->get_labour_groups();

        // Provide unloading items for the dynamic section
        $this->data['unloading_items'] = $unloading_items;
        
        // Set validation rules
        $this->form_validation->set_rules('production[date]', 'Date', 'required|trim');
        
        if ($this->form_validation->run() === FALSE) {
            $this->_loadView('admin/production/edit_production');
        } else {
            // Handle form submission
            $production_data = $this->input->post('production');
            $production_data['date'] = date('Y-m-d', strtotime($production_data['date']));
            $production_data['year_id'] = $this->_getYearId();
            $production_data['updated_by'] = $this->session->userdata('identity');
            $production_data['updated_at'] = date('Y-m-d H:i:s');
            
            // Extract loading/unloading data directly from production form data
            if (isset($production_data['loading_qty'])) {
                $production_data['loading_qty'] = (float)$production_data['loading_qty'];
            }
            if (isset($production_data['loading_rate'])) {
                $production_data['loading_rate'] = (float)$production_data['loading_rate'];
            }
            if (isset($production_data['loading_amount'])) {
                $production_data['loading_amount'] = (float)$production_data['loading_amount'];
            }
             if (isset($production_data['loading_unit'])) {
                $production_data['loading_unit'] = (float)$production_data['loading_unit'];
            }
            if (isset($production_data['unloading_qty'])) {
                $production_data['unloading_qty'] = (float)$production_data['unloading_qty'];
            }
            if (isset($production_data['unloading_rate'])) {
                $production_data['unloading_rate'] = (float)$production_data['unloading_rate'];
            }
            if (isset($production_data['unloading_amount'])) {
                $production_data['unloading_amount'] = (float)$production_data['unloading_amount'];
            }
            
            // Calculate grand total from all sources for update
            $loading_amount = isset($production_data['loading_amount']) ? (float)$production_data['loading_amount'] : 0;
            $unloading_amount = isset($production_data['unloading_amount']) ? (float)$production_data['unloading_amount'] : 0;
            
            // Calculate product total from prod items
            $product_total = 0;
            $prod_items = $this->input->post('prod');
            if (!empty($prod_items)) {
                foreach ($prod_items as $product_id => $item_data) {
                    if (is_array($item_data)) {
                        $amount = isset($item_data['amount']) ? (float)$item_data['amount'] : 0;
                        $product_total += $amount;
                    }
                }
            }
            
            // Store product total in prod_amount field
            $production_data['prod_amount'] = $product_total;
            
            // Set grand total (products + loading + unloading)
            $production_data['grand_total'] = $product_total + $loading_amount + $unloading_amount;
            
            $branch_id = $this->data['production']['branch_id'];
            
            // Start database transaction
            $this->db->trans_start();
            
            $this->production_model->update_production($production_data, $id);
            
            if (!empty($prod_items)) {
                $this->_updateProductionItems($prod_items, $id, $branch_id);
            }

            // Update loading items in transport table
            $loading_items = $this->input->post('loading');
            if (!empty($loading_items)) {
                $this->_updateLoadingItems($loading_items, $id, $branch_id);
            }

            // Update unloading items in fly_ash_unloading table
            $unloading_items = $this->input->post('unloading');
            if (!empty($unloading_items)) {
              
                $this->_updateUnloadingItems($unloading_items, $id, $branch_id);
            }
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'Failed to update production record');
            } else {
                $this->session->set_flashdata('success', 'Production record updated successfully');
            }
            
            redirect('admin/production/');
        }
    }

    /**
     * Soft delete production record (sets delete flag)
     * 
     * @param int $id Production ID
     * @return void
     */
    public function delete_production($id = null)
    {
        if (empty($id)) {
            show_404();
        }
        
        // Check if production record exists and is not already deleted (filter by year and branch)
        $production = $this->db->get_where('production', [
            'id' => $id,
            'is_deleted' => 0,
            'year_id' => $this->_getYearId(),
            'branch_id' => $this->_getBranchId()
        ])->row_array();
        
        if (empty($production)) {
            $this->session->set_flashdata('error', 'Production record not found or already deleted');
            redirect('admin/production/');
            return;
        }
        
        // Start database transaction
        $this->db->trans_start();
        
        try {
            // Soft delete production record
            $this->db->update('production', [
                'is_deleted' => 1,
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => $this->session->userdata('identity'),
                'year_id' => $this->_getYearId()
            ], ['id' => $id]);
            
            // Soft delete related production items
            $this->db->update('prod_item', [
                'is_deleted' => 1,
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => $this->session->userdata('identity'),
                'year_id' => $this->_getYearId()
            ], [
                'production_id' => $id,
                'is_deleted' => 0,
                'year_id' => $this->_getYearId(),
                'branch_id' => $this->_getBranchId()
            ]);
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'Failed to delete production record');
            } else {
                $this->session->set_flashdata('success', 'Production record deleted successfully');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Production deletion failed: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'An error occurred while deleting production record');
        }
        
        redirect('admin/production/');
    }


    /**
     * Prepare production data with all products (showing stock or 0)
     * 
     * @param array $production Production records
     * @return array Prepared production data
     */
    private function _prepareProductionData($production)
    {
        // Get all products once
        $all_products = $this->production_model->get_product();
        
        $prepared_production = [];
        foreach ($production as $prod) {
            // Get production items for this production (filter by year and branch)
            $production_items = $this->db->select('prod_item.*, product.name')
                                       ->from('prod_item')
                                       ->join('product', 'prod_item.product_id = product.id')
                                       ->where([
                                           'prod_item.production_id' => $prod['id'],
                                           'prod_item.is_deleted' => 0,
                                           'prod_item.year_id' => $this->_getYearId(),
                                           'prod_item.branch_id' => $prod['branch_id']
                                       ])
                                       ->get()
                                       ->result_array();
            
            // Create indexed array of production items by product_id
            $indexed_items = [];
            foreach ($production_items as $item) {
                $indexed_items[$item['product_id']] = $item;
            }
            
            // Prepare allitem array with all products
            $all_items = [];
            foreach ($all_products as $product) {
                if (isset($indexed_items[$product['id']])) {
                    // Product has stock in this production
                    $all_items[] = $indexed_items[$product['id']];
                } else {
                    // Product doesn't have stock, create empty entry
                    $all_items[] = [
                        'id' => null,
                        'product_id' => $product['id'],
                        'stock' => '0',
                        'name' => $product['name']
                    ];
                }
            }
            
            $prod['allitem'] = $all_items;
            $prepared_production[] = $prod;
        }
        return $prepared_production;
    }
    
    /**
     * Load view with header and footer
     * 
     * @param string $view View name
     * @return void
     */
    private function _loadView($view)
    {
        $this->load->view('common/header');
        $this->load->view($view, $this->data);
        $this->load->view('common/footer');
    }
    
    /**
     * Insert production items
     * 
     * @param array $prod_items Production items
     * @param int $production_id Production ID
     * @param int $branch_id Branch ID
     * @return void
     */
    private function _insertProductionItems($prod_items, $production_id, $branch_id)
    {
        foreach ($prod_items as $product_id => $item_data) {
            // Handle both old format (direct stock value) and new format (array with multiple fields)
            if (is_array($item_data)) {
                $quantity = isset($item_data['quantity']) ? (float)$item_data['quantity'] : 0;
                $rate = isset($item_data['rate']) ? (float)$item_data['rate'] : 0;
                $amount = isset($item_data['amount']) ? (float)$item_data['amount'] : ($quantity * $rate);
                
                // Only insert if quantity has data
                if ($quantity > 0) {
                    $insert_data = [
                        'product_id' => $product_id,
                        'stock' => $quantity, // For backward compatibility
                        'quantity' => $quantity,
                        'rate' => $rate,
                        'amount' => $amount,
                        'branch_id' => $branch_id,
                        'production_id' => $production_id,
                        'year_id' => $this->_getYearId(),
                        'entry_by' => $this->session->userdata('identity'),
                        'entry_date' => date('Y-m-d H:i:s')
                    ];
                    $this->db->insert('prod_item', $insert_data);
                }
            } else {
                // Handle old format for backward compatibility
                $stock = (float)$item_data;
                if ($stock > 0) {
                    $insert_data = [
                        'product_id' => $product_id,
                        'stock' => $stock,
                        'quantity' => $stock,
                        'branch_id' => $branch_id,
                        'production_id' => $production_id,
                        'year_id' => $this->_getYearId(),
                        'entry_by' => $this->session->userdata('identity'),
                        'entry_date' => date('Y-m-d H:i:s')
                    ];
                    $this->db->insert('prod_item', $insert_data);
                }
            }
        }
    }

    /**
     * Insert loading items into transport table
     * 
     * @param array $loading_items Loading items array (product_id => item_data)
     * @param int $production_id Production ID
     * @param int $branch_id Branch ID
     * @return void
     */
    private function _insertLoadingItems($loading_items, $production_id, $branch_id)
    {
        foreach ($loading_items as $product_id => $item_data) {
            if (is_array($item_data)) {
                $quantity = isset($item_data['quantity']) ? (float)$item_data['quantity'] : 0;
                $rate = isset($item_data['rate']) ? (float)$item_data['rate'] : 0;
                $unit = isset($item_data['unit']) ? (string)$item_data['unit'] : "";
                $amount = isset($item_data['amount']) ? (float)$item_data['amount'] : ($quantity * $rate);
                $labour_group_id = isset($item_data['labour_group_id']) ? (int)$item_data['labour_group_id'] : null;
                
                // Only insert if quantity has meaningful data
                if ($quantity > 0 && $amount > 0) {
                    $insert_data = [
                        'production_id' => $production_id,
                        'product_id' => $product_id,
                        'quantity' => $quantity,
                        'rate' => $rate,
                        'unit' => $unit,
                        'amount' => $amount,
                        'labour_group_id' => $labour_group_id,
                        'type' => 'loading',
                        'branch_id' => $branch_id,
                        'year_id' => $this->_getYearId(),
                        'entry_by' => $this->session->userdata('identity'),
                        'entry_date' => date('Y-m-d H:i:s')
                    ];
                    $this->db->insert('transport', $insert_data);
                }
            }
        }
    }

    /**
     * Insert unloading items into fly_ash_unloading table
     * 
     * @param array $unloading_items Unloading items array
     * @param int $production_id Production ID
     * @param int $branch_id Branch ID
     * @return void
     */
    private function _insertUnloadingItems($unloading_items, $production_id, $branch_id)
    {
        // Log for debugging
        log_message('debug', 'Inserting unloading items: ' . print_r($unloading_items, true));
        
        // Check if table exists first
        if (!$this->db->table_exists('fly_ash_unloading')) {
            log_message('error', 'fly_ash_unloading table does not exist');
            return;
        }
        
        foreach ($unloading_items as $index => $item_data) {
            if (is_array($item_data)) {
                $material_id = isset($item_data['material_id']) ? (int)$item_data['material_id'] : 0;
                $labour_group_id = isset($item_data['labour_group_id']) ? (int)$item_data['labour_group_id'] : 0;
                
                // Handle both 'qty' and 'quantity' field names for compatibility
                $qty = 0;
                if (isset($item_data['qty'])) {
                    $qty = (float)$item_data['qty'];
                } elseif (isset($item_data['quantity'])) {
                    $qty = (float)$item_data['quantity'];
                }

                $unit = isset($item_data['unit']) ? (string)$item_data['unit'] : "";
                $rate = isset($item_data['rate']) ? (float)$item_data['rate'] : 0;
                $amount = isset($item_data['amount']) ? (float)$item_data['amount'] : ($qty * $rate);
                
                // Log the parsed data
                log_message('debug', "Unloading item {$index}: material_id={$material_id}, labour_group_id={$labour_group_id}, qty={$qty}, rate={$rate}, amount={$amount}");
                
                // Only insert if all required fields have meaningful data
                if ($material_id > 0 && $labour_group_id > 0 && $qty > 0 && $amount > 0) {
                    $insert_data = [
                        'production_id' => $production_id,
                        'material_id' => $material_id,
                        'labour_group_id' => $labour_group_id,
                        'qty' => $qty,
                        'unit' => $unit,
                        'rate' => $rate,
                        'amount' => $amount,
                        'branch_id' => $branch_id,
                        'year_id' => $this->_getYearId(),
                        'entry_by' => $this->session->userdata('identity'),
                        'entry_date' => date('Y-m-d H:i:s')
                    ];
                    
                    try {
                        $result = $this->db->insert('fly_ash_unloading', $insert_data);
                        if ($result) {
                            log_message('debug', "Successfully inserted unloading item {$index}");
                        } else {
                            log_message('error', "Failed to insert unloading item {$index}: " . $this->db->last_query());
                        }
                    } catch (Exception $e) {
                        log_message('error', "Exception inserting unloading item {$index}: " . $e->getMessage());
                    }
                } else {
                    log_message('debug', "Skipping unloading item {$index} - insufficient data");
                }
            } else {
                log_message('debug', "Skipping unloading item {$index} - not an array");
            }
        }
    }

    /**
     * Get loading items for a production from transport table
     * 
     * @param int $production_id Production ID
     * @return array Loading items array
     */
    private function _getLoadingItems($production_id)
    {
        // Check if transport table exists
        if (!$this->db->table_exists('transport')) {
            return []; // Return empty array if table doesn't exist
        }
        
        try {
            $loading_items = $this->db->select('t.*, p.name as product_name')
                                     ->from('transport t')
                                     ->join('product p', 't.product_id = p.id', 'left')
                                     ->where([
                                         't.production_id' => $production_id,
                                         't.type' => 'loading',
                                         't.is_deleted' => 0
                                     ])
                                     ->get()
                                     ->result_array();
            
            return $loading_items;
        } catch (Exception $e) {
            // Log error and return empty array
            log_message('error', 'Error fetching loading items: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get unloading items for a production from fly_ash_unloading table
     * 
     * @param int $production_id Production ID
     * @return array Unloading items array
     */
    private function _getUnloadingItems($production_id)
    {
        // Check if fly_ash_unloading table exists
        if (!$this->db->table_exists('fly_ash_unloading')) {
            return []; // Return empty array if table doesn't exist
        }
        
        try {
            $unloading_items = $this->db->select('u.*, m.name as material_name, l.name as labour_group_name')
                                        ->from('fly_ash_unloading u')
                                        ->join('material m', 'u.material_id = m.id', 'left')
                                        ->join('labour_groups l', 'u.labour_group_id = l.id', 'left')
                                        ->where([
                                            'u.production_id' => $production_id,
                                            'u.is_deleted' => 0
                                        ])
                                        ->get()
                                        ->result_array();
            
            return $unloading_items;
        } catch (Exception $e) {
            // Log error and return empty array
            log_message('error', 'Error fetching unloading items: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Update loading items in transport table
     * 
     * @param array $loading_items Loading items array (product_id => item_data)
     * @param int $production_id Production ID
     * @param int $branch_id Branch ID
     * @return void
     */
    private function _updateLoadingItems($loading_items, $production_id, $branch_id)
    {
        // First, delete existing loading items for this production
        $this->db->update('transport', [
            'is_deleted' => 1,
            'updated_by' => $this->session->userdata('identity'),
            'updated_at' => date('Y-m-d H:i:s')
        ], [
            'production_id' => $production_id,
            'type' => 'loading',
            'is_deleted' => 0
        ]);

        // Insert new loading items
        $this->_insertLoadingItems($loading_items, $production_id, $branch_id);
    }

    /**
     * Update unloading items in fly_ash_unloading table
     * 
     * @param array $unloading_items Unloading items array
     * @param int $production_id Production ID
     * @param int $branch_id Branch ID
     * @return void
     */
    private function _updateUnloadingItems($unloading_items, $production_id, $branch_id)
    {
        // First, delete existing unloading items for this production
        $this->db->update('fly_ash_unloading', [
            'is_deleted' => 1,
            'updated_by' => $this->session->userdata('identity'),
            'updated_at' => date('Y-m-d H:i:s')
        ], [
            'production_id' => $production_id,
            'is_deleted' => 0
        ]);

        // Insert new unloading items
        $this->_insertUnloadingItems($unloading_items, $production_id, $branch_id);
    }

    /**
     * Update production items (handles both existing and new items)
     * 
     * @param array $prod_items Production items (product_id => stock)
     * @param int $production_id Production ID
     * @param int $branch_id Branch ID
     * @return void
     */
    private function _updateProductionItems($prod_items, $production_id, $branch_id)
    {
        // Get existing production items indexed by product_id (filter by year and branch)
        $existing_items = $this->db->select('id, product_id')
                                  ->from('prod_item')
                                  ->where([
                                      'production_id' => $production_id,
                                      'is_deleted' => 0,
                                      'year_id' => $this->_getYearId(),
                                      'branch_id' => $branch_id
                                  ])
                                  ->get()
                                  ->result_array();
        
        $existing_products = [];
        foreach ($existing_items as $item) {
            $existing_products[$item['product_id']] = $item['id'];
        }
        
        foreach ($prod_items as $product_id => $item_data) {
            // Handle both old format (direct stock value) and new format (array with multiple fields)
            if (is_array($item_data)) {
                $quantity = isset($item_data['quantity']) ? (float)$item_data['quantity'] : 0;
                $rate = isset($item_data['rate']) ? (float)$item_data['rate'] : 0;
                $amount = isset($item_data['amount']) ? (float)$item_data['amount'] : ($quantity * $rate);
                
                // Check if quantity has data
                $has_data = ($quantity > 0);
                
                if ($has_data) {
                    $update_data = [
                        'stock' => $quantity, // For backward compatibility
                        'quantity' => $quantity,
                        'rate' => $rate,
                        'amount' => $amount,
                        'updated_by' => $this->session->userdata('identity'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    
                    if (isset($existing_products[$product_id])) {
                        // Update existing item
                        $this->db->update('prod_item', $update_data, ['id' => $existing_products[$product_id]]);
                    } else {
                        // Insert new item
                        $insert_data = array_merge($update_data, [
                            'product_id' => $product_id,
                            'branch_id' => $branch_id,
                            'production_id' => $production_id,
                            'year_id' => $this->_getYearId(),
                            'is_deleted' => 0,
                            'entry_by' => $this->session->userdata('identity'),
                            'entry_date' => date('Y-m-d H:i:s')
                        ]);
                        unset($insert_data['updated_by'], $insert_data['updated_at']); // Remove update fields from insert
                        $this->db->insert('prod_item', $insert_data);
                    }
                } else if (isset($existing_products[$product_id])) {
                    // If all fields are empty/zero and we have an existing item, soft delete it
                    $this->db->update('prod_item', [
                        'is_deleted' => 1,
                        'deleted_at' => date('Y-m-d H:i:s'),
                        'deleted_by' => $this->session->userdata('identity')
                    ], ['id' => $existing_products[$product_id]]);
                }
            } else {
                // Handle old format for backward compatibility
                $stock = (float)$item_data;
                if ($stock > 0) {
                    $update_data = [
                        'stock' => $stock,
                        'quantity' => $stock,
                        'updated_by' => $this->session->userdata('identity'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    
                    if (isset($existing_products[$product_id])) {
                        // Update existing item
                        $this->db->update('prod_item', $update_data, ['id' => $existing_products[$product_id]]);
                    } else {
                        // Insert new item
                        $insert_data = [
                            'product_id' => $product_id,
                            'stock' => $stock,
                            'quantity' => $stock,
                            'branch_id' => $branch_id,
                            'production_id' => $production_id,
                            'year_id' => $this->_getYearId(),
                            'is_deleted' => 0,
                            'entry_by' => $this->session->userdata('identity'),
                            'entry_date' => date('Y-m-d H:i:s')
                        ];
                        $this->db->insert('prod_item', $insert_data);
                    }
                } else if (isset($existing_products[$product_id])) {
                    // If stock is empty/zero and we have an existing item, soft delete it
                    $this->db->update('prod_item', [
                        'is_deleted' => 1,
                        'deleted_at' => date('Y-m-d H:i:s'),
                        'deleted_by' => $this->session->userdata('identity')
                    ], ['id' => $existing_products[$product_id]]);
                }
            }
        }
    }
    
    /**
     * Update stock for a production item
     * 
     * @param array $item Production item data
     * @return void
     */
    private function _updateStock($item)
    {
        $stock_condition = [
            'branch_id' => $item['branch_id'],
            'product_id' => $item['product_id'],
            // 'year_id' => $this->_getYearId()
        ];
        
        $existing_stock = $this->db->get_where('stock', $stock_condition)->row_array();
        
        if (empty($existing_stock)) {
            // Insert new stock record
            $stock_data = [
                'branch_id' => $item['branch_id'],
                'product_id' => $item['product_id'],
                'stock' => $item['stock'],
                // 'year_id' => $this->_getYearId(),
                // 'entry_by' => $this->session->userdata('identity'),
                // 'entry_date' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('stock', $stock_data);
        } else {
            // Update existing stock
            $new_stock = $existing_stock['stock'] + $item['stock'];
            $this->db->update('stock', [
                'stock' => $new_stock,
                // 'updated_by' => $this->session->userdata('identity'),
                // 'updated_at' => date('Y-m-d H:i:s')
            ], $stock_condition);
        }
    }
    
    /**
     * Update production item status using raw SQL
     * 
     * @param int $item_id Item ID
     * @param int $status Status
     * @return void
     */
    private function _updateProductionItemStatus($item_id, $status)
    {
        $sql = "UPDATE prod_item SET status = ? WHERE id = ?";
        $this->db->query($sql, [$status, $item_id]);
    }

    /**
     * Display production report with date filtering and product-wise data
     * 
     * @return void
     */
    public function production_report()
    {
        $branch_id = $this->session->userdata('branch_id');
        
        // Initialize data
        $this->data = [
            'start_date' => '',
            'end_date' => '',
            'report_data' => [],
            'total_summary' => [
                'total_quantity' => 0,
                'total_amount' => 0,
                'loading_total_qty' => 0,
                'loading_total_amount' => 0,
                'unloading_total_qty' => 0,
                'unloading_total_amount' => 0,
                'grand_total_amount' => 0
            ]
        ];
        
        // Check if form is submitted
        if ($this->input->post()) {
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            
            $this->data['start_date'] = $start_date;
            $this->data['end_date'] = $end_date;
            
            if (!empty($start_date) && !empty($end_date)) {
                $this->data['report_data'] = $this->_getProductionReportData($start_date, $end_date, $branch_id);
             
                $this->data['total_summary'] = $this->_calculateReportSummary($this->data['report_data']);
            }
        }
      
        $this->_loadView('admin/production/production_report');
    }

    /**
     * Get production report data for given date range
     * 
     * @param string $start_date Start date
     * @param string $end_date End date
     * @param int $branch_id Branch ID
     * @return array Report data
     */
    private function _getProductionReportData($start_date, $end_date, $branch_id)
    {
        // Format dates for database query
        $start_formatted = date('Y-m-d', strtotime($start_date));
        $end_formatted = date('Y-m-d', strtotime($end_date));
        
        // Use raw SQL query to bypass query builder issues
        $sql = "SELECT production.* 
                FROM production 
                WHERE production.branch_id = ? 
                AND production.is_deleted = 0 
                AND production.year_id = ? 
                AND production.date BETWEEN ? AND ? 
                ORDER BY production.date ASC";
        
        $query = $this->db->query($sql, array($branch_id, $this->_getYearId(), $start_formatted, $end_formatted));
        $productions = $query->result_array();
        $report_data = [];
        
        foreach ($productions as $production) {
            // Get production items for this production
            $production_items = $this->db->select('prod_item.*, product.name as product_name')
                                       ->from('prod_item')
                                       ->join('product', 'prod_item.product_id = product.id')
                                       ->where([
                                           'prod_item.production_id' => $production['id'],
                                           'prod_item.is_deleted' => 0,
                                           'prod_item.year_id' => $this->_getYearId(),
                                           'prod_item.branch_id' => $branch_id
                                       ])
                                       ->get()
                                       ->result_array();

            // Get loading items from transport table
            $loading_items = $this->_getLoadingItems($production['id']);

            // Get unloading items from fly_ash_unloading table  
            $unloading_items = $this->_getUnloadingItems($production['id']);
            
            // Prepare production data
            $production_data = [
                'production' => $production,
                'items' => $production_items,
                'loading_items' => $loading_items,
                'unloading_items' => $unloading_items,
                'product_total_qty' => 0,
                'product_total_amount' => 0,
                'loading_total_qty' => 0,
                'loading_total_amount' => 0,
                'unloading_total_qty' => 0,
                'unloading_total_amount' => 0
            ];
            
            // Calculate totals for product items
            foreach ($production_items as $item) {
                $production_data['product_total_qty'] += (float)$item['quantity'];
                $production_data['product_total_amount'] += (float)$item['amount'];
            }

            // Calculate loading totals
            foreach ($loading_items as $item) {
                $production_data['loading_total_qty'] += (float)$item['quantity'];
                $production_data['loading_total_amount'] += (float)$item['amount'];
            }

            // Calculate unloading totals  
            foreach ($unloading_items as $item) {
                $production_data['unloading_total_qty'] += (float)$item['qty'];
                $production_data['unloading_total_amount'] += (float)$item['amount'];
            }
            
            $report_data[] = $production_data;
        }
        
        return $report_data;
    }

    /**
     * Calculate report summary totals
     * 
     * @param array $report_data Report data array
     * @return array Summary totals
     */
    private function _calculateReportSummary($report_data)
    {
        $summary = [
            'total_quantity' => 0,
            'total_amount' => 0,
            'loading_total_qty' => 0,
            'loading_total_amount' => 0,
            'unloading_total_qty' => 0,
            'unloading_total_amount' => 0,
            'grand_total_amount' => 0
        ];
        
        foreach ($report_data as $data) {
            // Product totals
            $summary['total_quantity'] += $data['product_total_qty'];
            $summary['total_amount'] += $data['product_total_amount'];
            
            // Loading/unloading totals from calculated amounts
            $summary['loading_total_qty'] += $data['loading_total_qty'];
            $summary['loading_total_amount'] += $data['loading_total_amount'];
            $summary['unloading_total_qty'] += $data['unloading_total_qty'];
            $summary['unloading_total_amount'] += $data['unloading_total_amount'];
            
            // Grand total (products + loading + unloading)
            $production_total = $data['product_total_amount'] + 
                               $data['loading_total_amount'] + 
                               $data['unloading_total_amount'];
            $summary['grand_total_amount'] += $production_total;
        }
        
        return $summary;
    }

}
