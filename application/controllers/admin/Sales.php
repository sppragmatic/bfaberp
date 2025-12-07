<?php defined('BASEPATH') or exit('No direct script access allowed');

class Sales extends CI_Controller
{
    // Class properties for centralized branch and year management
    protected $branch_id;
    protected $year_id;
    protected $entry_by;

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
     * Sales model
     *
     * @var object
     */
    public $sales_model;

    /**
     * Production model
     *
     * @var object
     */
    public $production_model;

    /**
     * Data array for views
     *
     * @var array
     */
    public $data;

    /**
     * Pagination library
     *
     * @var object
     */
    public $pagination;

    public function __construct()
    {
        parent::__construct();
        
        // Set timezone
        date_default_timezone_set('Asia/Kolkata');
        
        // Load libraries (removing duplicates)
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation', 'pagination', 'session']);
        
        // Load helpers
        $this->load->helper(['url', 'language', 'form']);
        
        // Load models
        $this->load->model(['common_model', 'payment_model', 'sales_model', 'admin/production_model']);
        
        // Load language
        $this->lang->load('auth');
        
        // Initialize data array
        $this->data = array();
        
        // Check authentication
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }
        
        // Initialize centralized branch and year management
        $this->_initializeBranchAndYear();
    }

    /**
     * Ensure POST data compatibility with PHP 8+
     * Prevents trim() deprecation warnings in form validation
     */
    private function _ensurePostCompatibility()
    {
        // Override form validation library's trim method if needed
        if (version_compare(PHP_VERSION, '8.0.0', '>=')) {
            // Extend form validation to handle null values safely
            $this->form_validation->set_data($_POST);
        }
    }

    /**
     * Initialize branch_id, year_id and entry_by for all transactions
     * Centralized management to ensure consistency across all database operations
     */
    private function _initializeBranchAndYear()
    {
        // Get and validate branch_id
        $this->branch_id = $this->session->userdata('branch_id');
        if (empty($this->branch_id)) {
            $this->session->set_flashdata('error', 'Branch not found. Please login again.');
            redirect('admin/auth', 'refresh');
        }
        
        // Get and validate year_id
        $this->year_id = $this->common_model->get_fa();
        if (empty($this->year_id)) {
            $this->session->set_flashdata('error', 'Financial year not found. Please contact administrator.');
            redirect('admin/auth', 'refresh');
        }
        
        // Get entry_by (user identity)
        $this->entry_by = $this->session->userdata('identity');
        if (empty($this->entry_by)) {
            $this->entry_by = $this->session->userdata('user_id');
        }
        
        // Set in data array for views
        $this->data['branch_id'] = $this->branch_id;
        $this->data['year_id'] = $this->year_id;
        $this->data['entry_by'] = $this->entry_by;
    }

    /**
     * Get standardized transaction data with branch_id, year_id and entry_by
     * @param array $additional_data Additional data to merge
     * @return array Complete transaction data
     */
    private function _getTransactionData($additional_data = [])
    {
        $base_data = [
            'branch_id' => $this->branch_id,
            'year_id' => $this->year_id,
            'entry_by' => $this->entry_by,
            'entry_date' => date('Y-m-d')
        ];
        
        return array_merge($base_data, $additional_data);
    }

    /**
     * Execute database transaction with proper branch and year validation
     * @param callable $callback Function containing database operations
     * @param string $error_message Custom error message on failure
     * @return mixed Result of callback execution or false on error
     */
    private function _executeTransaction($callback, $error_message = 'Transaction failed')
    {
        $this->db->trans_start();
        
        try {
            $result = $callback();
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                log_message('error', $error_message . ' - Transaction rollback');
                return false;
            }
            
            return $result;
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', $error_message . ' - Exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Add branch and year filters to database queries
     * @param array $additional_conditions Additional WHERE conditions
     * @return void
     */
    private function _addBranchYearFilter($additional_conditions = [])
    {
        // Always filter by current branch
        $this->db->where('branch_id', $this->branch_id);
        
        // Add additional conditions if provided
        if (!empty($additional_conditions)) {
            foreach ($additional_conditions as $field => $value) {
                $this->db->where($field, $value);
            }
        }
    }


     /**
     * AJAX endpoint to save digital signature image to sales table
     * Expects POST: id (sales id), signature_image (base64 data)
     * Returns JSON: { status: 'success'|'error', message: string }
     */
    public function save_signature()
    {
        $this->output->set_content_type('application/json');
        $id = $this->input->post('id');
        $signature_image = $this->input->post('signature_image');
        if (empty($id) || empty($signature_image)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Missing sales id or signature image.'
            ]);
            return;
        }
        // Update the sales table
        $this->db->where('id', $id);
        $updated = $this->db->update('sales', ['signature_image' => $signature_image]);
        if ($updated) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Signature saved.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to save signature.'
            ]);
        }
    }
    
    /**
     * Get standardized query conditions for current branch and year
     * @param array $additional_conditions Additional conditions to merge
     * @return array Complete query conditions
     */
    private function _getQueryConditions($additional_conditions = [])
    {
        $base_conditions = [
            'branch_id' => $this->branch_id
        ];
        
        // For tables that have year_id column, add it
        $tables_with_year = ['sales_account', 'sales', 'purchase_account', 'purchase'];
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
        $calling_method = isset($backtrace[1]['function']) ? $backtrace[1]['function'] : '';
        
        // Add year_id for relevant operations
        if (strpos($calling_method, 'account') !== false || 
            strpos($calling_method, 'sales') !== false || 
            strpos($calling_method, 'purchase') !== false) {
            $base_conditions['year_id'] = $this->year_id;
        }
        
        return array_merge($base_conditions, $additional_conditions);
    }

    /**
     * AJAX method to check if contact number exists in party table
     * Returns JSON response for remote validation
     */
    public function check_contact_in_party()
    {
        // Set JSON header
        $this->output->set_content_type('application/json');
        
        $contact_no = trim($this->input->post('contact_no'));
        $branch_id = $this->branch_id;
        
        // Validate input
        if (empty($contact_no) || !is_numeric($contact_no)) {
            echo json_encode([
                'exists' => false, 
                'party' => null, 
                'message' => 'Valid contact number is required'
            ]);
            return;
        }
        
        try {
            // Check if contact number exists in party table for current branch
            $party = $this->db->select('id, name, contact_no, address')
                              ->from('party')
                              ->where('contact_no', $contact_no)
                            //   ->where('branch_id', $branch_id)
                              ->where('trash', 0)
                              ->limit(1)
                              ->get()
                              ->row_array();
            
            if (!empty($party)) {
                echo json_encode([
                    'exists' => true, 
                    'party' => $party,
                    'message' => 'Contact number found in Party: ' . htmlspecialchars($party['name'])
                ]);
            } else {
                echo json_encode([
                    'exists' => false, 
                    'party' => null,
                    'message' => 'Contact number not found in party records'
                ]);
            }
        } catch (Exception $e) {
            log_message('error', 'Error in check_contact_in_party: ' . $e->getMessage());
            echo json_encode([
                'exists' => false, 
                'party' => null,
                'message' => 'Database error occurred'
            ]);
        }
    }

    /**
     * AJAX method to get party details by contact number for auto-filling
     * Returns party information if found
     */
    public function get_party_by_contact()
    {
        // Set JSON header
        $this->output->set_content_type('application/json');
        
        $contact_no = trim($this->input->get('contact_no'));
        $branch_id = $this->branch_id;
        
        // Validate input
        if (empty($contact_no) || !is_numeric($contact_no)) {
            echo json_encode([
                'success' => false, 
                'message' => 'Valid contact number is required'
            ]);
            return;
        }
        
        try {
            // Get party details by contact number
            $party = $this->db->select('id, name, contact_no, address')
                              ->from('party')
                              ->where('contact_no', $contact_no)
                            //   ->where('branch_id', $branch_id)
                              ->where('trash', 0)
                              ->limit(1)
                              ->get()
                              ->row_array();
            
            if (!empty($party)) {
                echo json_encode([
                    'success' => true,
                    'party' => $party,
                    'message' => 'Party details found'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'No party found with this contact number'
                ]);
            }
        } catch (Exception $e) {
            log_message('error', 'Error in get_party_by_contact: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Database error occurred'
            ]);
        }
    }

    public function delete($id = null)
    {
        $cond['id'] = $id;
        $data['trash'] = 1;

        $this->db->select("*");
        $this->db->from("sales");
        $this->db->where($cond);
        $sales = $this->db->get()->row_array();

        $sales_ac['invid'] = $sales['sl_no'];
        $salesac_up['trash'] = 1;
        $salesac_up['status'] = 1;
        $this->db->update('sales_account', $salesac_up, $sales_ac);
        $this->db->update('sales', $data, $cond);
        redirect('admin/sales');

    }

    public function activate($id = null)
    {
        $cond['id'] = $id;
        $data['trash'] = 0;

        $this->db->select("*");
        $this->db->from("sales");
        $this->db->where($cond);
        $sales = $this->db->get()->row_array();

        $sales_ac['invid'] = $sales['sl_no'];
        $salesac_up['trash'] = 0;
        $salesac_up['status'] = 0;
        $this->db->update('sales_account', $salesac_up, $sales_ac);
        $this->db->update('sales', $data, $cond);
        redirect('admin/sales');

    }

    public function delete_customer($id)
    {
        $cond['customer_id'] = $id;
        $cond1['id'] = $id;
        $this->db->select("*");
        $this->db->from("sales");
        $this->db->where($cond);
        $sales = $this->db->get()->num_rows();
        if ($sales > 0) {

            $this->session->set_userdata('del_message', "Sales Exist With This Customer!");
        } else {

            $this->db->delete("customer", $cond1);
            $branch_id = $this->session->userdata('branch_id');
            $this->session->set_userdata('del_message', "Customer Deleted!");
        }
        redirect('admin/sales/customer/1');
    }

    public function delete_payment($id = null)
    {
        $cond['id'] = $id;
        $data['status'] = 1;
        $data['trash'] = 1;
        $this->db->update('sales_account', $data, $cond);
        redirect('admin/sales/view_payment');

    }

    public function activate_payment($id = null)
    {
        $cond['id'] = $id;
        $data['status'] = 0;
        $data['trash'] = 0;
        $this->db->update('sales_account', $data, $cond);
        redirect('admin/sales/view_payment');

    }

    public function chalan($id)
    {
        $this->data['sales'] = $sales = $this->sales_model->print_sales($id);
        $this->data['products'] = $items = $this->sales_model->get_proditem($id);

        $this->load->view("common/header");
        $this->load->view("sales/challan", $this->data);
        $this->load->view("common/footer");
    }

    public function approve($id = null)
    {
        $this->data['sales'] = $sales = $this->sales_model->edit_sales($id);
        $this->data['products'] = $items = $this->sales_model->get_proditem($id);

        foreach ($items as $it) {
            $chk['branch_id'] = $it['branch_id'];
            $chk['product_id'] = $it['product_id'];
            $this->db->select('*');
            $this->db->from('stock');
            $res = $this->db->where($chk)->get();
            $num = $res->num_rows();
            if ($num > 0) {
                $prevstock = $res->row_array();

                $newstock = $prevstock['stock'] - $it['stock'];
                $stock['stock'] = $newstock;
                $this->db->update("stock", $stock, $chk);
            }

            $prod['status'] = 1;
            $prodcond['id'] = $it['id'];
            $this->db->update("sales_item", $prod, $prodcond);
        }
        $production['status'] = 1;
        $productioncond['id'] = $id;
        $this->db->update("sales", $production, $productioncond);
        redirect('admin/sales/admin_sales');
    }

    //redirect if needed, otherwise display the user list

    public function index($id = null)
    {
        $this->data['customer'] = $this->sales_model->get_customer($this->branch_id);
        $this->data['products'] = $this->production_model->get_product();

        $br = $this->sales_model->get_br($this->branch_id);
        $b_c = strtoupper($this->sales_model->get_brcode($this->branch_id));

        $this->data['trans_no'] = $trans_no = "BFAB" . "SL" . $br;

        $sql = "SELECT COUNT(id) AS c_id FROM sales_account WHERE branch_id={$this->branch_id}";
        $res = $this->db->query($sql);
        $count = $res->row_array();
        $inv = $count['c_id'] + 1;
        $invno = "BFAB" . "INV" . $inv;

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        //validate form input

       // $this->form_validation->set_rules('contact_no', "Contact Number", 'required|trim|numeric|min_length[10]|max_length[15]');
        $this->form_validation->set_rules('customer_id', "Customer Selection", 'required');
        $this->form_validation->set_rules('payment_status', "Payment Status", 'required');
        $this->form_validation->set_rules('vehicle_number', "VEHICLE Number", 'required');
        $this->form_validation->set_rules('vehicle_owner', "VEHICLE OWNER", 'required');
        $this->form_validation->set_rules('address', "Address", 'required');
        $this->form_validation->set_rules('bill_date', "Entry Date", 'required');

        if ($this->form_validation->run() == true) {

            $amount = $this->input->post('amount');
            $prod = $this->input->post('prod');
            $toamount = 0;
            
            // Calculate total amount only for products with positive amount and quantity
            foreach ($amount as $ky => $va) {
                $product_amount = floatval($va);
                $product_quantity = isset($prod[$ky]) ? floatval($prod[$ky]) : 0;
                
                if ($product_amount > 0 && $product_quantity > 0) {
                    $toamount = $toamount + $product_amount;
                }
            }
            
            // Add transportation and loading charges to total amount
            $transportation_charge = floatval($this->input->post('transportation_charge')) ?: 0;
            $loading_charge = floatval($this->input->post('loading_charge')) ?: 0;
            $sub_total = $toamount; // Store products subtotal
            $toamount = $toamount + $transportation_charge + $loading_charge;

            $sales_data = array(
                'sl_no' => $this->input->post('sl_no'),
                'vehicle_owner' => $this->input->post('vehicle_owner'),
                'address' => $this->input->post('address'),
                'paiddetails' => $this->input->post('paiddetails'),
                'paid_amount' => $this->input->post('paid_amount'),
                'payment_status' => $this->input->post('payment_status'),
                'bill_date' => date('Y-m-d', strtotime($this->input->post('bill_date'))),
                'vehicle_number' => $this->input->post('vehicle_number'),
                'total_amount' => $toamount,
                'transportation_charge' => $transportation_charge,
                'loading_charge' => $loading_charge,
                'sub_total' => $sub_total,
            );
            
            // Use centralized transaction data method
            $data = $this->_getTransactionData($sales_data);

            if ($this->input->post('type')) {
                $data['type'] = $this->input->post('type');
            } else {
                $data['type'] = 0;
            }

          //  $contact_no = $this->input->post('contact_no');
            $customer_id = $this->input->post('customer_id');
            $customer_name = $this->input->post('customer_name');
            $prod = $this->input->post('prod');
            $amount = $this->input->post('amount');
            $rate = $this->input->post('rate');
            
            if ($customer_id == null) {
                // Create new customer using centralized transaction data
                $customer_data = array(
                    'name' => !empty($customer_name) ? $customer_name : 'Customer-' . time(),
                );
                $cusdata = $this->_getTransactionData($customer_data);
                $this->db->insert('customer', $cusdata);
                $customer_id = $this->db->insert_id();
                $data['customer_id'] = $customer_id;
            } else {
                $data['customer_id'] = $customer_id;
            }

            $exam_id = $this->sales_model->create_sales($data);
            if ($exam_id) {

                $payment_status = $this->input->post('payment_status');
                $account_data = array(
                    'invid' => $this->input->post('sl_no'),
                    'invno' => $invno,
                    'customer_id' => $customer_id,
                    'details' => $this->input->post('paiddetails'),
                    'credit' => $toamount,
                    'entry_date' => date('Y-m-d', strtotime($this->input->post('bill_date'))),
                );
                
                // Use centralized transaction data method
                $accdata = $this->_getTransactionData($account_data);

                if ($payment_status == 1) {
                    $accdata['debit'] = $this->input->post('paid_amount');
                    $accdata['type'] = $this->input->post('type');
                } else {
                    $accdata['debit'] = 0;
                    $accdata['type'] = 0;
                }

                $this->db->insert("sales_account", $accdata);

                foreach ($prod as $key => $val) {
                    // Skip products with zero amount or zero quantity
                    $product_amount = isset($amount[$key]) ? floatval($amount[$key]) : 0;
                    $product_quantity = floatval($val);
                    
                    if ($product_amount > 0 && $product_quantity > 0) {
                        $item_data = array(
                            'product_id' => $key,
                            'amount' => $product_amount,
                            'rate' => isset($rate[$key]) ? $rate[$key] : 0,
                            'stock' => $product_quantity,
                            'sales_id' => $exam_id,
                        );
                        
                        // Use centralized transaction data but override entry_date for items
                        $insitem = $this->_getTransactionData($item_data);
                        unset($insitem['year_id']); // Sales items don't need year_id
                        $this->db->insert('sales_item', $insitem);
                    }
                }

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/sales/view_sales");

            }

        } else {

            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            if ($this->input->post('customer_name') != null) {
                $this->data['customer_name'] = $this->input->post('customer_name');
            } else {
                $this->data['customer_name'] = '';
            }

            if ($this->input->post('type') != null) {
                $this->data['type'] = $this->input->post('type');
            } else {
                $this->data['type'] = '';
            }

            if ($this->input->post('remarks') != null) {
                $this->data['remarks'] = $this->input->post('remarks');
            } else {
                $this->data['remarks'] = '';
            }

            if ($this->input->post('entry_date') != null) {
                $this->data['entry_date'] = $this->input->post('entry_date');
            } else {
                $this->data['entry_date'] = '';
            }

            if ($this->input->post('amount') != null) {
                $this->data['amount'] = $this->input->post('amount');
            } else {
                $this->data['amount'] = '';
            }

            if ($this->input->post('paid_amount') != null) {
                $this->data['paid_amount'] = $this->input->post('paid_amount');
            } else {
                $this->data['paid_amount'] = '';
            }

            if ($this->input->post('paiddetails') != null) {
                $this->data['paiddetails'] = $this->input->post('paiddetails');
            } else {
                $this->data['paiddetails'] = '';
            }

            if ($this->input->post('paymet_status') != null) {
                $this->data['paymet_status'] = $this->input->post('paymet_status');
            } else {
                $this->data['paymet_status'] = '';
            }

            // Add contact_no validation data
            if ($this->input->post('contact_no') != null) {
                $this->data['contact_no'] = $this->input->post('contact_no');
            } else {
                $this->data['contact_no'] = '';
            }
            
            $this->session->set_flashdata('msg', 'Create Payment');

            $this->load->view("common/header");
            $this->load->view("sales/add", $this->data);
            $this->load->view("common/footer");

        }

    }

    public function edit_sales($id = null)
    {
        $this->data['sales'] = $sales = $this->sales_model->edit_sales($id);
        $this->data['products'] = $this->sales_model->get_proditem($id);

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->sales_model->get_customer($branch_id);

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        //validate form input
        $this->form_validation->set_rules('customer_id', "Customer Selection", 'required');
        $this->form_validation->set_rules('payment_status', "Payment Status", 'required');
        $this->form_validation->set_rules('vehicle_number', "VEHICLE Number", 'required');
        $this->form_validation->set_rules('vehicle_owner', "VEHICLE OWNER", 'required');
        $this->form_validation->set_rules('address', "Address", 'required');
        $this->form_validation->set_rules('bill_date', "Entry Date", 'required');

        if ($this->form_validation->run() == true) {

            $amount = $this->input->post('amount');
            $prod = $this->input->post('prod');
            $toamount = 0;
            
            // Calculate total amount only for products with positive amount and quantity
            foreach ($amount as $ky => $va) {
                $product_amount = floatval($va);
                $product_quantity = isset($prod[$ky]) ? floatval($prod[$ky]) : 0;
                
                if ($product_amount > 0 && $product_quantity > 0) {
                    $toamount = $toamount + $product_amount;
                }
            }
            
            // Add transportation and loading charges to total amount
            $transportation_charge = floatval($this->input->post('transportation_charge')) ?: 0;
            $loading_charge = floatval($this->input->post('loading_charge')) ?: 0;
            $sub_total = $toamount; // Store products subtotal
            $toamount = $toamount + $transportation_charge + $loading_charge;

            $data = array('sl_no' => $this->input->post('sl_no'),
                'vehicle_owner' => $this->input->post('vehicle_owner'),
                'address' => $this->input->post('address'),
                'paiddetails' => $this->input->post('paiddetails'),
                'payment_status' => $this->input->post('payment_status'),
                'bill_date' => date('Y-m-d', strtotime($this->input->post('bill_date'))),
                'vehicle_number' => $this->input->post('vehicle_number'),
                'customer_id' => $this->input->post('customer_id'),
                'branch_id' => $branch_id,
                'total_amount' => $toamount,
                'transportation_charge' => $transportation_charge,
                'loading_charge' => $loading_charge,
                'sub_total' => $sub_total,
            );

            $payment_status = $this->input->post('payment_status');

            if ($payment_status == 1) {
                $data['paid_amount'] = $this->input->post('paid_amount');
                $data['type'] = $this->input->post('type');
            } else {
                $data['paid_amount'] = 0;
                $data['paiddetails'] = '';
                $data['type'] = 0;
            }

            $acccond['invid'] = $sales['sl_no'];
            $accdata['credit'] = $toamount;
            $accdata['details'] = $this->input->post('paiddetails');
            $payment_status = $this->input->post('payment_status');
            if ($payment_status == 1) {
                $accdata['debit'] = $this->input->post('paid_amount');
                $accdata['type'] = $this->input->post('type');
            } else {
                $accdata['debit'] = 0;
                $accdata['type'] = 0;
            }
            $this->db->update("sales_account", $accdata, $acccond);

            $prod = $this->input->post('prod');
            $rate = $this->input->post('rate');

            $uc['id'] = $id;

            $update = $this->db->update('sales', $data, $uc);

            foreach ($prod as $key => $val) {
                // Skip products with zero amount or zero quantity
                $product_amount = isset($amount[$key]) ? floatval($amount[$key]) : 0;
                $product_quantity = floatval($val);
                
                if ($product_amount > 0 && $product_quantity > 0) {
                    $upcond['id'] = $key;
                    $upitem['amount'] = $product_amount;
                    $upitem['rate'] = isset($rate[$key]) ? $rate[$key] : 0;
                    $upitem['stock'] = $product_quantity;
                    $this->db->update('sales_item', $upitem, $upcond);
                } else {
                    // Delete the sales_item record if amount or quantity becomes zero
                    $delcond['id'] = $key;
                    $this->db->delete('sales_item', $delcond);
                }
            }

            if ($update) {

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/sales/view_sales");

            }

        } else {

            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            if ($this->input->post('customer_name') != null) {
                $this->data['customer_name'] = $this->input->post('customer_name');
            } else {
                $this->data['customer_name'] = '';
            }

            if ($this->input->post('type') != null) {
                $this->data['type'] = $this->input->post('type');
            } else {
                $this->data['type'] = '';
            }

            if ($this->input->post('remarks') != null) {
                $this->data['remarks'] = $this->input->post('remarks');
            } else {
                $this->data['remarks'] = '';
            }

            if ($this->input->post('entry_date') != null) {
                $this->data['entry_date'] = $this->input->post('entry_date');
            } else {
                $this->data['entry_date'] = '';
            }

            if ($this->input->post('amount') != null) {
                $this->data['amount'] = $this->input->post('amount');
            } else {
                $this->data['amount'] = '';
            }

            $this->session->set_flashdata('msg', 'Create Payment');

/*    print_r($this->data);
exit;
 */
            $this->load->view("common/header");
            $this->load->view("sales/edit", $this->data);
            $this->load->view("common/footer");

        }

    }

// start of the payemnet

    public function add_payment($id = null)
    {
        $this->data['customer'] = $this->sales_model->get_customer();
        $this->data['products'] = $this->production_model->get_product();

        $br = $this->sales_model->get_br($this->branch_id);
        $b_c = strtoupper($this->sales_model->get_brcode($this->branch_id));

        $sql = "SELECT COUNT(id) AS c_id FROM sales_account WHERE branch_id={$this->branch_id}";
        $res = $this->db->query($sql);
        $count = $res->row_array();
        $inv = $count['c_id'] + 1;
        $invno = "BFAB" . "INV" . $inv;

        $this->data['trans_no'] = $trans_no = $invno;

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        //validate form input
        $this->form_validation->set_rules('customer_id', "Customer Name", 'required');
        $this->form_validation->set_rules('debit', "Amount", 'required');
        $this->form_validation->set_rules('entry_date', "Payment Date", 'required');
        $this->form_validation->set_rules('details', "Details", 'required');

        if ($this->form_validation->run() == true) {
            $payment_data = array(
                'invid' => 0,
                'invno' => $invno,
                'customer_id' => $this->input->post('customer_id'),
                'entry_date' => date("Y-m-d", strtotime($this->input->post('entry_date'))),
                'debit' => $this->input->post('debit'),
                'details' => $this->input->post('details'),
            );
            
            // Use centralized transaction data method
            $data = $this->_getTransactionData($payment_data);

            $exam_id = $this->sales_model->create_payment($data);
            if ($exam_id) {
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/sales/view_payment");

            }

        } else {

            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            if ($this->input->post('customer_id') != null) {
                $this->data['customer_id'] = $this->input->post('customer_id');
            } else {
                $this->data['customer_id'] = '';
            }

            if ($this->input->post('debit') != null) {
                $this->data['debit'] = $this->input->post('debit');
            } else {
                $this->data['debit'] = '';
            }

            if ($this->input->post('details') != null) {
                $this->data['details'] = $this->input->post('details');
            } else {
                $this->data['details'] = '';
            }

            if ($this->input->post('entry_date') != null) {
                $this->data['entry_date'] = $this->input->post('entry_date');
            } else {
                $this->data['entry_date'] = '';
            }

            $this->session->set_flashdata('msg', 'Create Payment');
            /*    print_r($this->data);
            exit;$this->data['customer'] = $this->sales_model->get_customer($branch_id);
             */

            $this->load->view("common/header");
            $this->load->view("sales/add_payment", $this->data);
            $this->load->view("common/footer");

        }

    }

    public function edit_payment($id = null)
    {
        $this->data['sales'] = $payment = $this->sales_model->edit_payment($id);

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->sales_model->get_customer($branch_id);

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        //validate form input
        $this->form_validation->set_rules('customer_id', "Customer Name", 'required');
        $this->form_validation->set_rules('debit', "Amount", 'required');
        $this->form_validation->set_rules('entry_date', "Payment Date", 'required');
        $this->form_validation->set_rules('details', "Details", 'required');

        if ($this->form_validation->run() == true) {

            $data = array('invid' => $this->input->post('sl_no'),
                'customer_id' => $this->input->post('customer_id'),
                'entry_date' => date("Y-m-d", strtotime($this->input->post('entry_date'))),
                'debit' => $this->input->post('debit'),
                'details' => $this->input->post('details'),
                'branch_id' => $this->session->userdata('branch_id'),
                'entry_by' => $this->session->userdata('identity'),
            );

            $uc['id'] = $id;
            $update = $this->db->update('sales_account', $data, $uc);

            if ($update) {

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/sales/view_payment");

            }

        } else {

            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->session->set_flashdata('msg', 'Create Payment');
            /*    print_r($this->data);
            exit;
             */
            $this->load->view("common/header");
            $this->load->view("sales/edit_payment", $this->data);
            $this->load->view("common/footer");

        }

    }

    public function view_payment($id = null)
    {
        $this->data['customer_id'] = '';
        $this->data['start_date'] = '';
        $this->data['end_date'] = '';
        
        // Use centralized branch and year management
        $this->data['customer'] = $this->sales_model->get_customer($this->branch_id);
        $this->data['sales'] = $sales = $this->sales_model->get_allpayments_page($id, $this->branch_id);

        // Count records for pagination with proper branch and year filter
        $this->db->select("*");
        $this->db->from("sales_account");
        $this->_addBranchYearFilter(['year_id' => $this->year_id]);
        $num = $this->db->get()->num_rows();

        $this->load->library('pagination');
        $config['base_url'] = site_url('admin/sales/view_payment');
        $config['total_rows'] = $num;
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = true;
        $config['cur_tag_open'] = '<li><a style="color:red">';
        $config['cur_tag_close'] = '</a></li>';
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        $this->load->view("common/header");
        $this->load->view("sales/view_payment", $this->data);
        $this->load->view("common/footer");

    }

// code for opening balance

// start of the payemnet

    public function add_opening($id = null)
    {
        $this->data['customer'] = $this->sales_model->get_customer();
        $this->data['products'] = $this->production_model->get_product();

        $br = $this->sales_model->get_br($this->branch_id);
        $b_c = strtoupper($this->sales_model->get_brcode($this->branch_id));

        $sql = "SELECT COUNT(id) AS c_id FROM sales_account WHERE branch_id={$this->branch_id}";
        $res = $this->db->query($sql);
        $count = $res->row_array();
        $inv = $count['c_id'] + 1;
        $invno = "BFAB" . "INV" . $inv;

        $this->data['trans_no'] = $trans_no = $invno;

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        //validate form input


        $this->form_validation->set_rules('customer_id', "Customer Name", 'required');
        $this->form_validation->set_rules('debit', "Amount", 'required');
        $this->form_validation->set_rules('entry_date', "Payment Date", 'required');
        $this->form_validation->set_rules('details', "Details", 'required');


        if ($this->form_validation->run() == true) {
            $opening_data = array(
                'invid' => 0,
                'invno' => $invno,
                'customer_id' => $this->input->post('customer_id'),
                'entry_date' => date("Y-m-d", strtotime($this->input->post('entry_date'))),
                'credit' => $this->input->post('debit'),
                'details' => $this->input->post('details'),
                'opening' => 1,
            );
            
            // Use centralized transaction data method
            $data = $this->_getTransactionData($opening_data);

            $exam_id = $this->sales_model->create_payment($data);

            if ($exam_id) {
                $cond1['customer_id'] = $this->input->post('customer_id');
                $cond1['opening'] = 0;
                $cond1['entry_date'] = date("Y-m-d", strtotime($this->input->post('entry_date')));
                $data1['reset_status'] = 1;

                $this->db->update("sales_account", $data1, $cond1);

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/sales/view_opening");

            }

        } else {

            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            if ($this->input->post('customer_id') != null) {
                $this->data['customer_id'] = $this->input->post('customer_id');
            } else {
                $this->data['customer_id'] = '';
            }

            if ($this->input->post('debit') != null) {
                $this->data['debit'] = $this->input->post('debit');
            } else {
                $this->data['debit'] = '';
            }

            if ($this->input->post('details') != null) {
                $this->data['details'] = $this->input->post('details');
            } else {
                $this->data['details'] = '';
            }

            if ($this->input->post('entry_date') != null) {
                $this->data['entry_date'] = $this->input->post('entry_date');
            } else {
                $this->data['entry_date'] = '';
            }

            $this->session->set_flashdata('msg', 'Create Payment');
            /*    print_r($this->data);
            exit;$this->data['customer'] = $this->sales_model->get_customer($branch_id);
             */

            $this->load->view("common/header");
            $this->load->view("sales/add_opening", $this->data);
            $this->load->view("common/footer");

        }

    }

    public function edit_opening($id = null)
    {
        $this->data['sales'] = $payment = $this->sales_model->edit_payment($id);

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->sales_model->get_customer($branch_id);

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        //validate form input
        $this->form_validation->set_rules('debit', "Amount", 'required');
        $this->form_validation->set_rules('entry_date', "Payment Date", 'required');
        $this->form_validation->set_rules('details', "Details", 'required');

        if ($this->form_validation->run() == true) {

            $data = array('entry_date' => date("Y-m-d", strtotime($this->input->post('entry_date'))),
                'credit' => $this->input->post('debit'),
                'details' => $this->input->post('details'),
                'branch_id' => $this->session->userdata('branch_id'),
                'entry_by' => $this->session->userdata('identity'),
            );

            $uc['id'] = $id;
            $update = $this->db->update('sales_account', $data, $uc);

            if ($update) {

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/sales/view_opening");

            }

        } else {

            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->session->set_flashdata('msg', 'Create Payment');
            /*    print_r($this->data);
            exit;
             */
            $this->load->view("common/header");
            $this->load->view("sales/edit_opening", $this->data);
            $this->load->view("common/footer");

        }

    }

    public function view_opening()
    {

        $this->data['customer_id'] = '';
        $this->data['start_date'] = '';
        $this->data['end_date'] = '';
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->sales_model->get_customer($branch_id);
        $this->data['sales'] = $sales = $this->sales_model->get_allopening($branch_id);

        $this->load->view("common/header");
        $this->load->view("sales/view_opening", $this->data);
        $this->load->view("common/footer");

    }

// end of code for opening balance

    public function search_payment()
    {

        $this->data['customer_id'] = $customer_id = $this->input->post("customer_id");
        $this->data['start_date'] = $start_date = $this->input->post("start_date");
        $this->data['end_date'] = $end_date = $this->input->post("end_date");

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->sales_model->get_customer($branch_id);

        $this->db->select('sales_account.*,customer.name as customername');
        $this->db->from('sales_account');
        $this->db->join('customer', 'sales_account.customer_id=customer.id');
        $this->db->where('sales_account.branch_id', $branch_id);

        if ($start_date != '' && $end_date != '') {

            $st = date('Y-m-d', strtotime($start_date));
            $et = date('Y-m-d', strtotime($end_date));
            $this->db->where("sales_account.entry_date >= '$st' AND sales_account.entry_date <= '$et' ");
            $cond = array();
            if ($customer_id != 0) {
                $cond['sales_account.customer_id'] = $customer_id;
            }
            $this->db->where($cond);

        } else {
            $cond = array();
            if ($customer_id != 0) {
                $cond['sales_account.customer_id'] = $customer_id;
            }
            $this->db->where($cond);

        }
        $this->db->order_by('sales_account.entry_date', "DESC");
        $query = $this->db->get();
        $this->data['sales'] = $sales = $query->result_array();

        $num = $query->num_rows();

        $this->load->library('pagination');
        $config['base_url'] = site_url('admin/sales/search_payment');
        $config['total_rows'] = $num;
        $config['per_page'] = 50;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = true;
        $config['cur_tag_open'] = '<li><a style="color:red">';
        $config['cur_tag_close'] = '</a></li>';
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        $this->load->view("common/header");
        $this->load->view("sales/view_payment", $this->data);
        $this->load->view("common/footer");

    }

    /// end of the payment

    public function admin_sales($id = null)
    {
        $this->data['branch'] = $this->sales_model->get_branch();
        $this->data['customer_id'] = '';
        $this->data['branch_id'] = '';
        $this->data['start_date'] = '';
        $this->data['end_date'] = '';

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->sales_model->get_customer($branch_id);

        $this->db->select("*");
        $this->db->from("sales");
        $this->db->where("branch_id", $branch_id);
        $num = $this->db->get()->num_rows();

        $this->load->library('pagination');
        $config['base_url'] = site_url('admin/sales/admin_sales');
        $config['total_rows'] = $num;
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = true;
        $config['cur_tag_open'] = '<li><a style="color:red">';
        $config['cur_tag_close'] = '</a></li>';
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        $this->data['products'] = $this->production_model->get_product();
        $this->data['sales'] = $sales = $this->sales_model->admin_allsales($id, $branch_id);

        $this->data['products'] = $this->production_model->get_product();
        $allsales = array();
        foreach ($sales as $prod) {
            $sales_id = $prod['id'];
            $prod['allitem'] = $productitems = $this->sales_model->get_proditem($sales_id);
            $allsales[] = $prod;
        }
        $this->data['sales'] = $allsales;

        $this->load->view("common/header");
        $this->load->view("sales/admin_sales", $this->data);
        $this->load->view("common/footer");

    }

    public function admsearch_sales()
    {

        $this->data['branch'] = $this->sales_model->get_branch();
        $this->data['customer_id'] = $customer_id = $this->input->post('customer_id');
        $this->data['branch_id'] = $this->input->post('branch_id');
        $this->data['start_date'] = $start_date = $this->input->post('start_date');
        $this->data['end_date'] = $end_date = $this->input->post('end_date');

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->sales_model->get_customer($branch_id);

        $this->data['sales'] = $sales = $this->sales_model->get_allsales($branch_id);

        $this->data['products'] = $this->production_model->get_product();
        $this->db->select('sales.*,customer.name as customername');
        $this->db->from('sales');
        $this->db->join('customer', 'sales.customer_id=customer.id');
        if ($start_date != '' && $end_date != '') {

            $st = date('Y-m-d', strtotime($start_date));
            $et = date('Y-m-d', strtotime($end_date));
            $this->db->where("sales.bill_date >= '$st' AND sales.bill_date <= '$et' ");
            $cond = array();
            if ($customer_id != 0) {
                $cond['sales.customer_id'] = $customer_id;
            }

            if ($branch_id != 0) {
                $cond['sales.branch_id'] = $branch_id;
            }
            $this->db->where($cond);

        } else {
            $cond = array();
            if ($customer_id != 0) {
                $cond['sales.customer_id'] = $customer_id;
            }

            if ($branch_id != 0) {
                $cond['sales.branch_id'] = $branch_id;
            }
            $this->db->where($cond);

        }

        $this->db->order_by('sales.bill_date', "DESC");
        $query = $this->db->get();
        $sales = $query->result_array();

        $allsales = array();
        foreach ($sales as $prod) {
            $sales_id = $prod['id'];
            $prod['allitem'] = $productitems = $this->sales_model->get_proditem($sales_id);
            $allsales[] = $prod;
        }
        $this->data['sales'] = $allsales;

        $this->load->library('pagination');
        $config['base_url'] = site_url('admin/sales/search_payment');
        $config['total_rows'] = count($allsales);
        $config['per_page'] = 50;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = true;
        $config['cur_tag_open'] = '<li><a style="color:red">';
        $config['cur_tag_close'] = '</a></li>';
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        $this->load->view("common/header");
        $this->load->view("sales/admin_sales", $this->data);
        $this->load->view("common/footer");

    }

    public function view_sales($id = null)
    {

        $this->data['customer_id'] = '';
        $this->data['start_date'] = '';
        $this->data['end_date'] = '';

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->sales_model->get_customer($branch_id);


        $this->db->select("*");
        $this->db->from("sales");
        $this->db->where("branch_id", $branch_id);
        $num = $this->db->get()->num_rows();

        $this->load->library('pagination');
        $config['base_url'] = site_url('admin/sales/view_sales');
        $config['total_rows'] = $num;
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = true;
        $config['cur_tag_open'] = '<li><a style="color:red">';
        $config['cur_tag_close'] = '</a></li>';
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        $this->data['products'] = $this->production_model->get_product();
        $this->data['sales'] = $sales = $this->sales_model->get_allsalespage($id, $branch_id);

        $allsales = array();
        foreach ($sales as $prod) {
            $sales_id = $prod['id'];
            $prod['allitem'] = $productitems = $this->sales_model->get_proditem($sales_id);
            $allsales[] = $prod;
        }
        $this->data['sales'] = $allsales;

        $this->load->view("common/header");
        $this->load->view("sales/view_sales", $this->data);
        $this->load->view("common/footer");

    }

    public function search_sales()
    {

        $this->data['customer_id'] = $customer_id = $this->input->post('customer_id');
        $this->data['start_date'] = $start_date = $this->input->post('start_date');
        $this->data['end_date'] = $end_date = $this->input->post('end_date');

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->sales_model->get_customer($branch_id);

        $this->data['sales'] = $sales = $this->sales_model->get_allsales($branch_id);

        $this->data['products'] = $this->production_model->get_product();
        $this->db->select('sales.*,customer.name as customername');
        $this->db->from('sales');
        $this->db->join('customer', 'sales.customer_id=customer.id');
        $this->db->where('sales.branch_id', $branch_id);
        if ($start_date != '' && $end_date != '') {

            $st = date('Y-m-d', strtotime($start_date));
            $et = date('Y-m-d', strtotime($end_date));
            $this->db->where("sales.bill_date >= '$st' AND sales.bill_date <= '$et' ");
            $cond = array();
            if ($customer_id != 0) {
                $cond['sales.customer_id'] = $customer_id;
            }
            $this->db->where($cond);

        } else {
            $cond = array();
            if ($customer_id != 0) {
                $cond['sales.customer_id'] = $customer_id;
            }
            $this->db->where($cond);

        }

        $this->db->order_by('sales.bill_date', "DESC");
        $query = $this->db->get();
        $sales = $query->result_array();

        $allsales = array();
        foreach ($sales as $prod) {
            $sales_id = $prod['id'];
            $prod['allitem'] = $productitems = $this->sales_model->get_proditem($sales_id);
            $allsales[] = $prod;
        }
        $this->data['sales'] = $allsales;

        $this->load->view("common/header");
        $this->load->view("sales/view_sales", $this->data);
        $this->load->view("common/footer");

    }

    public function view_customer_sales_details($p_c)
    {

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');

        $sales = $this->sales_model->get_uncustomersales($p_c);

        $len = count($sales);

        $this->data['code'] = $p_c;
        $this->data['sales'] = $sales;
        $this->data['customer'] = $this->sales_model->get_customer($branch_id);

        $this->load->view("common/header");
        $this->load->view("sales/un_report", $this->data);
        $this->load->view("common/footer");

    }

    public function report44()
    {

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');

        $sales = $this->sales_model->get_allcustomersales($branch_id);

        $len = count($sales);

        $this->data['sales'] = $sales;
        $this->data['customer'] = $this->sales_model->get_customer($branch_id);

        $this->load->view("common/header");
        $this->load->view("sales/report", $this->data);
        $this->load->view("common/footer");
    }

    

    /// start fo th code for report
    public function summery()
    {
        $this->data['customer'] = $this->sales_model->get_customer();
        $this->data['branch'] = $this->sales_model->get_branch();
        $this->load->view("common/header");
        $this->load->view("sales/summery", $this->data);
        $this->load->view("common/footer");
    }

    public function credit()
    {

        $customer = $this->sales_model->get_customer();
        $all_cust = array();
        foreach ($customer as $cust) {
            $id = $cust['id'];
            $this->db->select('SUM(credit) as to_credit,SUM(debit) as to_debit');
            $this->db->from('sales_account');
            $this->db->where('customer_id', $id);
            $sl = $this->db->get()->row_array();
            $cust['credit'] = $cr = $sl['to_credit'];
            $cust['debit'] = $db = $sl['to_debit'];
            $bl = $cr - $db;
            $cust['balance'] = $bl;
            if ($bl > 0) {
                $all_cust[] = $cust;
            }
        }

        $this->data['all_cust'] = $all_cust;
        $this->load->view("common/header");
        $this->load->view("sales/credit", $this->data);
        $this->load->view("common/footer");
    }

    /**
     * Enhanced sales reporting method that provides detailed financial breakdown
     * Shows sub_total, transportation_charge, loading_charge, grand_total, paid_amount, and balance
     */
    public function financial_report($id = null)
    {
        $this->data['customer_id'] = '';
        $this->data['start_date'] = '';
        $this->data['end_date'] = '';

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->sales_model->get_customer($branch_id);

        // Get enhanced sales data with payment information
        $this->data['sales'] = $this->_getEnhancedSalesData($id, $branch_id);
        $this->data['products'] = $this->production_model->get_product();

        // Count records for pagination
        $this->db->select("*");
        $this->db->from("sales");
        $this->db->where("branch_id", $branch_id);
        $num = $this->db->get()->num_rows();

        $this->load->library('pagination');
        $config['base_url'] = site_url('admin/sales/financial_report');
        $config['total_rows'] = $num;
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = true;
        $config['cur_tag_open'] = '<li><a style="color:red">';
        $config['cur_tag_close'] = '</a></li>';
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        $this->load->view("common/header");
        $this->load->view("sales/financial_report", $this->data);
        $this->load->view("common/footer");
    }

    /**
     * Get enhanced sales data with payment tracking and financial breakdown
     * @param int $page Page number for pagination
     * @param int $branch_id Branch ID
     * @return array Enhanced sales data with payment information
     */
    private function _getEnhancedSalesData($page = null, $branch_id = null)
    {
        if ($page <= 1 && $page == "") {
            $ids = 0;
        } else {
            $ids = $page - 1;
        }

        // Enhanced query to get sales with payment information
        $this->db->select('
            sales.*, 
            customer.name as customername,
            COALESCE(sales.sub_total, 0) as sub_total,
            COALESCE(sales.transportation_charge, 0) as transportation_charge,
            COALESCE(sales.loading_charge, 0) as loading_charge,
            COALESCE(sales.paid_amount, 0) as paid_amount,
            (sales.total_amount - COALESCE(sales.paid_amount, 0)) as balance_amount
        ');
        $this->db->from('sales');
        $this->db->join('customer', 'sales.customer_id=customer.id');
        $this->db->limit(20, $ids * 20);
        $this->db->where('sales.branch_id', $branch_id);
        $this->db->order_by('sales.bill_date', "DESC");
        $query = $this->db->get();
        
        $sales = $query->result_array();
        
        // Add product items for each sale
        $enhanced_sales = array();
        foreach ($sales as $sale) {
            $sale_id = $sale['id'];
            $sale['allitem'] = $this->sales_model->get_proditem($sale_id);
            $enhanced_sales[] = $sale;
        }
        
        return $enhanced_sales;
    }

    public function getsummery()
    {

        $this->data['customer'] = $this->sales_model->get_customer();
        $this->data['branch'] = $this->sales_model->get_branch();

        $this->data['customer_id'] = $customer_id = $this->input->post('customer_id');
        $this->data['branch_id'] = $branch_id = $this->input->post('branch_id');
        $this->data['start_date'] = $start_date = $this->input->post('start_date');
        $this->data['end_date'] = $end_date = $this->input->post('end_date');

        $this->db->select('sales_account.*,customer.name as customername');
        $this->db->from('sales_account');
        $this->db->join('customer', 'sales_account.customer_id=customer.id');
        $this->db->where('sales_account.reset_status', 0);
        $this->db->where('sales_account.trash', 0);
        if ($start_date != '' && $end_date != '') {

            $st = date('Y-m-d', strtotime($start_date));
            $et = date('Y-m-d', strtotime($end_date));
            $this->db->where("sales_account.entry_date >= '$st' AND sales_account.entry_date <= '$et' ");
            $cond = array();
            if ($customer_id != 0) {
                $cond['sales_account.customer_id'] = $customer_id;
            }

            if ($branch_id != 0) {
                $cond['sales_account.branch_id'] = $branch_id;
            }
            $this->db->where($cond);

        } else {
            //echo "i will stop here".$customer_id;exit;
            $cond = array();
            if ($customer_id != 0) {
                $cond['sales_account.customer_id'] = $customer_id;
            }

            if ($branch_id != 0) {
                $cond['sales_account.branch_id'] = $branch_id;
            }
            $this->db->where($cond);

        }
        $this->db->order_by('sales_account.entry_date', "DESC");
        $alsales = $this->db->get()->result_array();
        $this->data['sales'] = $alsales;

//     print("<pre>");
        //     print_r($alsales);
        //     exit;

        $this->load->view("common/header");
        $this->load->view("sales/admin_summery", $this->data);
        $this->load->view("common/footer");

    }

    //// end of the code for report

/// start fo th code for report
    public function report()
    {
        //echo "ia mhere";exit;
        $this->data['customer'] = $this->sales_model->get_customer();
        $this->data['branch'] = $this->sales_model->get_branch();
        $this->load->view("common/header");
        $this->load->view("sales/report", $this->data);
        $this->load->view("common/footer");
    }

    public function getreport()
    {

        $this->data['customer'] = $this->sales_model->get_customer();
        $this->data['branch'] = $this->sales_model->get_branch();

        $this->data['customer_id'] = $customer_id = $this->input->post('customer_id');
        $this->data['branch_id'] = $branch_id = $this->input->post('branch_id');
        $this->data['start_date'] = $start_date = $this->input->post('start_date');
        $this->data['end_date'] = $end_date = $this->input->post('end_date');

        $this->db->select('sales_account.*,customer.name as customername');
        $this->db->from('sales_account');
        $this->db->join('customer', 'sales_account.customer_id=customer.id');
        $this->db->where('sales_account.reset_status', 0);
        $this->db->where('sales_account.trash', 0);
        if ($start_date != '' && $end_date != '') {

            $st = date('Y-m-d', strtotime($start_date));
            $et = date('Y-m-d', strtotime($end_date));
            $this->db->where("sales_account.entry_date >= '$st' AND sales_account.entry_date <= '$et' ");
            $cond = array();
            if ($customer_id != 0) {
                $cond['sales_account.customer_id'] = $customer_id;
            }

            if ($branch_id != 0) {
                $cond['sales_account.branch_id'] = $branch_id;
            }
            $this->db->where($cond);

        } else {
            //echo "i will stop here".$customer_id;exit;
            $cond = array();
            if ($customer_id != 0) {
                $cond['sales_account.customer_id'] = $customer_id;
            }

            if ($branch_id != 0) {
                $cond['sales_account.branch_id'] = $branch_id;
            }
            $this->db->where($cond);

        }
        $alsales = $this->db->get()->result_array();
        $this->data['sales'] = $alsales;

//print("<pre>");
        //print_r($alsales);
        //exit;

        $this->load->view("common/header");
        $this->load->view("sales/admin_report", $this->data);
        $this->load->view("common/footer");

    }

//// end of the code for report

    public function view_details($entry_date = null)
    {

        $branch_id = 1;
        $this->data['sales'] = $this->sales_model->view_details($entry_date);
        $this->data['entry_date'] = $entry_date;
        $this->load->view("common/header");
        $this->load->view("sales/view_details", $this->data);
        $this->load->view("common/footer");

    }

    public function customer($msg = null)
    {

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');

        $this->data['customer'] = $this->sales_model->get_allcustomer($branch_id);
        $this->load->view("common/header");
        $this->load->view("sales/view_customer", $this->data);
        $this->load->view("common/footer");

    }

    public function create_customer($id = null)
    {
        $br = $this->sales_model->get_pr($this->branch_id);
        $b_c = strtoupper($this->sales_model->get_brcode($this->branch_id));

        $this->data['code'] = $code = $b_c . "PT" . $br;

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        //validate form input
        
        // Preprocess form data to prevent null values in form validation
        $this->_preprocessFormData();

    $this->form_validation->set_rules('name', "customer Name", 'required');
    $this->form_validation->set_rules('contact_no', "Contact No", 'required|numeric|min_length[10]|max_length[10]|callback_check_unique_contact');
    $this->form_validation->set_rules('address', "Address", 'required');

        if ($this->form_validation->run() == true) {
            $customer_data = array(
                'name' => $this->_getPostData('name'),
                'address' => $this->_getPostData('address'),
                'code' => $this->_getPostData('code'),
                'contact_no' => $this->_getPostData('contact_no'),
                'remarks' => $this->_getPostData('remarks'),
            );
            
            // Use centralized transaction data method
            $data = $this->_getTransactionData($customer_data);

            $exam_id = $this->sales_model->create_customer($data);
            if ($exam_id) {

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/sales/customer");

            }

        } else {

            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            // Use helper method for safe data retrieval
            $this->data['name'] = $this->_getPostData('name');
            $this->data['address'] = $this->_getPostData('address');
            $this->data['contact_no'] = $this->_getPostData('contact_no');
            $this->data['remarks'] = $this->_getPostData('remarks');

            $this->session->set_flashdata('msg', 'Create Payment');

/*    print_r($this->data);
exit;
 */
            $this->load->view("common/header");
            $this->load->view("sales/add_customer", $this->data);
            $this->load->view("common/footer");

        }

    }

    public function edit_customer($id = null)
    {

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        //validate form input
        
        // Preprocess form data to prevent null values in form validation
        $this->_preprocessFormData();

        $this->form_validation->set_rules('name', "customer Name", 'required');
        $this->form_validation->set_rules('contact_no', "Contact No", 'required|numeric|min_length[10]|max_length[15]|callback_check_unique_contact_edit[' . $id . ']');
        $this->form_validation->set_rules('address', "Address", 'required');

        if ($this->form_validation->run() == true) {
            $data = array(
                'name' => $this->_getPostData('name'),
                'address' => $this->_getPostData('address'),
                'contact_no' => $this->_getPostData('contact_no'),
                'remarks' => $this->_getPostData('remarks'),
            );

            $exam_id = $this->sales_model->update_customer($id, $data);
            if ($exam_id) {

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/sales/customer");

            }

        } else {

            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            // Use helper method for safe data retrieval
            $this->data['name'] = $this->_getPostData('name');
            $this->data['address'] = $this->_getPostData('address');
            $this->data['contact_no'] = $this->_getPostData('contact_no');
            $this->session->set_flashdata('msg', 'Create Payment');
/*    print_r($this->data);
exit;
 */
            $this->data['customer'] = $this->sales_model->edit_customer($id);
            $this->load->view("common/header");
            $this->load->view("sales/edit_customer", $this->data);
            $this->load->view("common/footer");

        }

    }

    public function misc()
    {

        $this->data['sales'] = array();
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->load->view("common/header");
        $this->load->view("sales/misc", $this->data);
        $this->load->view("common/footer");
    }

    // other payment
    public function other()
    {

        $this->data['sales'] = array();
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->load->view("common/header");
        $this->load->view("sales/other", $this->data);
        $this->load->view("common/footer");
    }

    public function interview()
    {

        $this->data['sales'] = array();
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->load->view("common/header");
        $this->load->view("sales/interview", $this->data);
        $this->load->view("common/footer");
    }

// end of the other payment

   

    public function receipt($id)
    {
        $this->db->select('sales_account.*,customer.name as customername,customer.address as address');
        $this->db->from('sales_account');
        $this->db->join('customer', 'sales_account.customer_id=customer.id');
        $this->db->where('sales_account.id', $id);
        $query = $this->db->get();
        $this->data['sales'] = $query->row_array();

//print_r($this->data['sales']);
        //exit;

        $this->load->view("common/header");
        $this->load->view("sales/receipt", $this->data);
        $this->load->view("common/footer");

    }

    /**
     * Callback validation method to check if contact number is unique
     * Used in create_customer form validation
     */
    public function check_unique_contact($contact_no)
    {
        $branch_id = $this->branch_id;
        
        // Sanitize input - handle null values for PHP 8+ compatibility
        $contact_no = $contact_no !== null ? trim($contact_no) : '';
        
        if (empty($contact_no)) {
            return true; // Let required validation handle empty values
        }
        
        try {
            // Check if contact number already exists in customer table for current branch
            $count = $this->db->where('contact_no', $contact_no)
                             ->where('branch_id', $branch_id)
                             ->count_all_results('customer');
            
            if ($count > 0) {
                $this->form_validation->set_message('check_unique_contact', 'This contact number is already registered with another customer.');
                return false;
            }
            
            return true;
        } catch (Exception $e) {
            log_message('error', 'Error in check_unique_contact: ' . $e->getMessage());
            $this->form_validation->set_message('check_unique_contact', 'Database error occurred while validating contact number.');
            return false;
        }
    }

    /**
     * Callback validation method to check if contact number is unique for edit
     * Used in edit_customer form validation - excludes current customer record
     */
    public function check_unique_contact_edit($contact_no, $customer_id)
    {
        $branch_id = $this->branch_id;
        
        // Sanitize input - handle null values for PHP 8+ compatibility
        $contact_no = $contact_no !== null ? trim($contact_no) : '';
        $customer_id = (int) $customer_id;
        
        if (empty($contact_no)) {
            return true; // Let required validation handle empty values
        }
        
        try {
            // Check if contact number already exists in customer table for current branch
            // but exclude the current customer being edited
            $count = $this->db->where('contact_no', $contact_no)
                             ->where('branch_id', $branch_id)
                             ->where('id !=', $customer_id)
                             ->count_all_results('customer');
            
            if ($count > 0) {
                $this->form_validation->set_message('check_unique_contact_edit', 'This contact number is already registered with another customer.');
                return false;
            }
            
            return true;
        } catch (Exception $e) {
            log_message('error', 'Error in check_unique_contact_edit: ' . $e->getMessage());
            $this->form_validation->set_message('check_unique_contact_edit', 'Database error occurred while validating contact number.');
            return false;
        }
    }

    /**
     * AJAX method to check if contact number is unique
     * Used for remote validation in add_customer form
     */
    public function check_contact_unique()
    {
        // Set JSON response header
        $this->output->set_content_type('application/json');
        
        // Check if request is AJAX and POST
        if (!$this->input->is_ajax_request() || $this->input->method() !== 'post') {
            $response = array('exists' => true, 'message' => 'Invalid request');
            echo json_encode($response);
            return;
        }
        
        // Handle null values for PHP 8+ compatibility
        $contact_no_raw = $this->input->post('contact_no');
        $contact_no = $contact_no_raw !== null ? trim($contact_no_raw) : '';
        $branch_id = $this->branch_id;
        
        // Basic validation
        if (empty($contact_no)) {
            $response = array('exists' => true, 'message' => 'Contact number is required');
            echo json_encode($response);
            return;
        }
        
        // Length validation
        if (strlen($contact_no) < 10) {
            $response = array('exists' => true, 'message' => 'Contact number must be at least 10 characters');
            echo json_encode($response);
            return;
        }
        
        // Numeric validation
        if (!is_numeric($contact_no)) {
            $response = array('exists' => true, 'message' => 'Contact number must contain only numbers');
            echo json_encode($response);
            return;
        }
        
        try {
            // Check if contact number already exists in customer table for current branch
            $this->db->where('contact_no', $contact_no);
            $this->db->where('branch_id', $branch_id);
            $count = $this->db->count_all_results('customer');
            
            if ($count > 0) {
                $response = array(
                    'exists' => true, 
                    'message' => 'This contact number is already registered with another customer'
                );
            } else {
                $response = array(
                    'exists' => false, 
                    'message' => 'Contact number is available'
                );
            }
            
            echo json_encode($response);
            
        } catch (Exception $e) {
            log_message('error', 'Error in check_contact_unique AJAX: ' . $e->getMessage());
            $response = array(
                'exists' => true, 
                'message' => 'Database error occurred while validating contact number'
            );
            echo json_encode($response);
        }
    }

    /**
     * Helper method to safely get and sanitize POST data
     * @param string $key The POST key to retrieve
     * @param mixed $default Default value if key doesn't exist or is null
     * @return string Sanitized string value
     */
    private function _getPostData($key, $default = '')
    {
        $value = $this->input->post($key);
        return $value !== null ? trim($value) : $default;
    }
    
    /**
     * Preprocess form data to prevent null values causing trim() issues in PHP 8+
     * This method ensures all expected form fields have default empty string values
     * @param array $fields Optional array of specific fields to check, defaults to customer fields
     */
    private function _preprocessFormData($fields = null)
    {
        // Default to common customer form fields if no specific fields provided
        if ($fields === null) {
            $fields = array('name', 'contact_no', 'address', 'code', 'remarks');
        }
        
        // Ensure $_POST is initialized and is an array
        if (!is_array($_POST)) {
            $_POST = array();
        }
        
        // Process each field to prevent null values
        foreach ($fields as $field) {
            $value = $this->input->post($field);
            if ($value === null || $value === false) {
                $_POST[$field] = '';
            }
        }
        
        // Additional global safety for any other POST fields that might be null
        foreach ($_POST as $key => $value) {
            if ($value === null) {
                $_POST[$key] = '';
            }
        }
    }

    /**
     * Helper method to get current branch ID with validation
     * @return int Branch ID or redirect if not found
     */
    private function _getBranchId()
    {
        $branch_id = $this->session->userdata('branch_id');
        if (empty($branch_id)) {
            show_error('Branch ID not found in session. Please login again.');
        }
        return (int) $branch_id;
    }

    /**
     * Helper method to get current user identity
     * @return string User identity or redirect if not found  
     */
    private function _getUserIdentity()
    {
        $entry_by = $this->session->userdata('identity');
        if (empty($entry_by)) {
            show_error('User identity not found in session. Please login again.');
        }
        return $entry_by;
    }

    /**
     * Helper method to set form validation data for reuse
     * @param array $fields Array of field names to preserve
     */
    private function _setValidationData($fields = [])
    {
        foreach ($fields as $field) {
            $this->data[$field] = $this->input->post($field) ?? '';
        }
    }

    /**
     * Helper method to render view with common header/footer
     * @param string $view_name The view file name
     * @param array $data Optional additional data
     */
    private function _renderView($view_name, $data = [])
    {
        if (!empty($data)) {
            $this->data = array_merge($this->data, $data);
        }
        
        $this->load->view("common/header");
        $this->load->view($view_name, $this->data);
        $this->load->view("common/footer");
    }

}
