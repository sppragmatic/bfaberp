<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Account Controller
 * 
 * Handles account management including purchase accounts, payments, party management
 * and financial reporting functionality
 * 
 * @category Controller
 * @package  Admin
 */
class Account extends CI_Controller
{
    /**
     * @var array Common data for all methods
     */
    public $data = [];

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
     * Account model
     *
     * @var object
     */
    public $account_model;

    /**
     * Pagination library
     *
     * @var object
     */
    public $pagination;

    /**
     * Constructor - Initialize required libraries, models and authentication
     */
    public function __construct()
    {
        parent::__construct();
        
        // Load database first
        $this->load->database();
        
        // Load libraries
        $this->load->library(['ion_auth', 'form_validation', 'pagination', 'session']);
        
        // Load helpers
        $this->load->helper(['url', 'form', 'language']);
        
        // Load models
        $this->load->model(['common_model', 'payment_model', 'account_model']);
        
        // Load language
        $this->lang->load('auth');
        
        // Set common data
        $this->data['year_id'] = $this->common_model->get_fa();
        
        // Check authentication
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }
    }

     /**
     * Display purchase challan for a given account (purchase)
     * @param int $id Account ID
     */
    public function challan($id = null)
    {
        if (empty($id)) {
            show_404();
        }

        $branch_id = $this->session->userdata('branch_id');
        // Get purchase account details by account id (ensure branch security)
        $account = $this->db->get_where('account', [
            'id' => $id,
            'trash' => 0,
            'branch_id' => $branch_id
        ])->row_array();

        if (empty($account)) {
            $this->session->set_flashdata('error', 'Account record not found or has been deleted');
            redirect('admin/account/view_account');
            return;
        }

        // Get related purchase_account by trans_no
        $purchase = $this->db->get_where('purchase_account', [
            'invid' => $account['trans_no'],
            'trash' => 0,
            'branch_id' => $branch_id
        ])->row_array();

        // Get party and material details
        $party = $this->db->get_where('party', [
            'id' => $account['party_id']
        ])->row_array();
        $material = $this->db->get_where('material', [
            'id' => $account['material_id']
        ])->row_array();

        $data = [
            'account' => $account,
            'purchase' => $purchase,
            'party' => $party,
            'material' => $material
        ];

        $this->load->view('common/header');
        $this->load->view('purchase/challan', $data);
        $this->load->view('common/footer');
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
        // Update the accounts table
        $this->db->where('id', $id);
        $updated = $this->db->update('accounts', ['signature_image' => $signature_image]);
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
     * View trashed (deleted) payment records
     */
    public function trash_payment()
    {
        $branch_id = $this->session->userdata('branch_id');
        $this->data['customer'] = $this->account_model->get_party($branch_id);
        // Get only deleted payments (trash=1)
        $this->data['sales'] = $this->account_model->get_allpayments_trash($branch_id);
        // Initialize search parameters
        $this->data['party_id'] = '';
        $this->data['start_date'] = '';
        $this->data['end_date'] = '';
        $this->_loadView('account/trash_payment');
    }

    /**
     * Main account creation page
     * 
     * @param int|null $id Account ID for editing
     * @return void
     */
    public function index($id = null)
    {
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        
        // Initialize form data
        $this->_initializeAccountForm($branch_id);
        
        // Set validation rules
        $this->_setAccountValidationRules();

        
        if ($this->form_validation->run() === TRUE) {
            // Handle form submission
            $this->_processAccountCreation($branch_id, $entry_by);

        } else {
            // Handle form display
            $this->_setFormDisplayData();
            
            $this->_loadView('account/add');
        }
    }

    /**
     * AJAX method to get parties by material ID
     * 
     * @return void
     */
    public function get_matparty()
    {
        $material_id = $this->input->get_post('material_id');
        $branch_id = $this->session->userdata('branch_id');
        
        if (empty($material_id)) {
            echo json_encode(['error' => 'Material ID is required']);
            return;
        }
        
        if (empty($branch_id)) {
            echo json_encode(['error' => 'Branch ID is required']);
            return;
        }
        
        $parties = $this->account_model->get_matparty($material_id);
        
        $options = ['<option value="0">Select Party</option>'];
        foreach ($parties as $party) {
            $options[] = '<option value="' . htmlspecialchars($party['id']) . '">' 
                        . htmlspecialchars($party['name']) . '</option>';
        }
        
        echo implode('', $options);
    }


    /**
     * Restore a deleted (trashed) account and its related purchase_account
     * @param int $id Account ID
     */
    public function restore($id)
    {
        if (empty($id)) {
            show_404();
        }
        $branch_id = $this->session->userdata('branch_id');
        // Get the trashed account
        $account = $this->db->get_where('account', [
            'id' => $id,
            'trash' => 1,
            'branch_id' => $branch_id
        ])->row_array();
        if (empty($account)) {
            $this->session->set_flashdata('error', 'Account record not found or not deleted');
            redirect('admin/account/trash_account');
            return;
        }
        // Restore main account
        $restore_data = [
            'trash' => 0,
            'is_deleted' => 0,
            'deleted_at' => null,
            'deleted_by' => null
        ];
        $this->db->update('account', $restore_data, ['id' => $id]);
        // Restore related purchase_account
        $this->db->update('purchase_account', $restore_data, ['invid' => $account['trans_no']]);
        $this->session->set_flashdata('success', 'Account record restored successfully');
        redirect('admin/account/trash_account');
    }

    /**
     * Edit account record
     * 
     * @param int|null $id Account ID
     * @return void
     */
    public function edit_account($id = null)
    {
        if (empty($id)) {
            show_404();
        }
        
        $branch_id = $this->session->userdata('branch_id');
        
        // Get account data (check if not deleted and ensure branch_id security)
        $this->data['account'] = $account = $this->db->get_where('account', [
            'id' => $id,
            'trash' => 0,
            'branch_id' => $branch_id
        ])->row_array();
        
        if (empty($account)) {
            $this->session->set_flashdata('error', 'Account record not found or has been deleted');
            redirect('admin/account/view_account');
        }
        
        // Initialize form data
        $this->data['material'] = $this->account_model->get_material();
        $this->data['party'] = $this->account_model->get_matparty($account['material_id']);
        $this->data['title'] = "Edit Account";
        
        // Set validation rules
        $this->_setAccountValidationRules();
        
        if ($this->form_validation->run() === TRUE) {
            $this->_processAccountUpdate($id, $account);
        } else {
            $this->_loadView('account/edit');
        }
    }
    
    /**
     * Process account update
     * 
     * @param int $id Account ID
     * @param array $account Current account data
     * @return void
     */
    private function _processAccountUpdate($id, $account)
    {
        // Start database transaction
        $this->db->trans_start();
        
        try {
            // Prepare update data
            $data = [
                'party_id' => $this->input->post('party_id'),
                'material_id' => $this->input->post('material_id'),
                'paiddetails' => $this->input->post('paiddetails'),
                'payment_status' => $this->input->post('payment_status'),
                'refno' => $this->input->post('refno'),
                'stock' => $this->input->post('stock'),
                'unit' => $this->input->post('unit'),
                'amount' => $this->input->post('amount'),
                'vehicle_no' => $this->input->post('vehicle_no'),
                'type' => $this->input->post('type'),
                'entry_date' => date('Y-m-d', strtotime($this->input->post('entry_date'))),
                'remarks' => $this->input->post('remarks'),
                'updated_by' => $this->session->userdata('identity'),
                'updated_at' => date('Y-m-d H:i:s'),
                'branch_id' => $this->session->userdata('branch_id'),
                'year_id' => $this->data['year_id']
            ];
            
            $payment_status = $this->input->post('payment_status');
            if ($payment_status == 1) {
                $data['paid_amount'] = $this->input->post('paid_amount');
            } else {
                $data['paid_amount'] = 0;
                $data['paiddetails'] = '';
            }
            
            // Update main account record

            $this->account_model->update_account($id, $data);
            
            // Update purchase account
            $purchase_data = [
                'credit' => $this->input->post('amount'),
                'details' => $this->input->post('paiddetails'),
                'debit' => ($payment_status == 1) ? $this->input->post('paid_amount') : 0,
                'type' => ($payment_status == 1) ? $this->input->post('type') : 0,
                'updated_by' => $this->session->userdata('identity'),
                'updated_at' => date('Y-m-d H:i:s'),
                'branch_id' => $this->session->userdata('branch_id'),
                'year_id' => $this->data['year_id']
            ];
            
            $this->db->update('purchase_account', $purchase_data, ['invid' => $account['trans_no']]);
            
            // (Removed duplicate update call)
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'Failed to update account record');
            } else {
                $this->session->set_flashdata('success', 'Account record updated successfully');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Account update failed: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'An error occurred while updating account');
        }
        
        redirect('admin/account/view_account');
    }

        public function trash_account()
    {
        $branch_id = $this->session->userdata('branch_id');
        $this->data['material'] = $this->account_model->get_material();
        // Get only deleted accounts (trash=1)
        $this->data['account'] = $this->account_model->get_allaccount_trash($branch_id);
        // Initialize search parameters
        $this->data['party_id'] = '';
        $this->data['material_id'] = '';
        $this->data['start_date'] = '';
        $this->data['end_date'] = '';
        $this->_loadView('account/trash_account');
    }

    public function approve($id = null)
    {
        $account = $this->account_model->get_account($id);
        $cond['material_id'] = $account['material_id'];
        $cond['branch_id'] = $account['branch_id'];
        $this->db->select("*");
        $this->db->from("material_stock");
        $this->db->where($cond);
        $res = $this->db->get();
        $num = $res->num_rows();
        if ($num == 0) {
            $ins['branch_id'] = $account['branch_id'];
            $ins['stock'] = $account['stock'];
            $ins['material_id'] = $account['material_id'];
            $ins['entry_by'] = $this->session->userdata('identity');
            $ins['entry_date'] = date('Y-m-d H:i:s');
            $ins['year_id'] = $this->data['year_id'];
            $this->db->insert("material_stock", $ins);
        } else {
            $rwdata = $res->row_array();
            $nwstock = $rwdata['stock'] + $account['stock'];
            $upcond['id'] = $rwdata['id'];
            $upd['stock'] = $nwstock;
            $upd['updated_by'] = $this->session->userdata('identity');
            $upd['updated_at'] = date('Y-m-d H:i:s');
            $this->db->update("material_stock", $upd, $upcond);

        }
        $account_cond['id'] = $id;
        $accoun_up['status'] = 1;
        $accoun_up['approved_by'] = $this->session->userdata('identity');
        $accoun_up['approved_at'] = date('Y-m-d H:i:s');
        $upres = $this->db->update("account", $accoun_up, $account_cond);
        redirect("admin/account");
    }

    public function admin_account()
    {

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['material'] = $this->account_model->get_material();
        $this->data['branch'] = $this->account_model->get_branch();

        $this->data['account'] = $this->account_model->get_adminallaccount($branch_id);

        $this->data['party_id'] = '';
        $this->data['branch_id'] = '';
        $this->data['material_id'] = '';
        $this->data['start_date'] = '';
        $this->data['end_date'] = '';

        $this->load->view("common/header");
        $this->load->view("account/admview_account", $this->data);
        $this->load->view("common/footer");

    }

    public function adminsearch_account()
    {

        $this->data['branch'] = $this->account_model->get_branch();
        $this->data['party_id'] = $party_id = $this->input->post('party_id');
        $this->data['material_id'] = $material_id = $this->input->post('material_id');
        $this->data['branch_id'] = $branch_id = $this->input->post('branch_id');
        $this->data['start_date'] = $start_date = $this->input->post('start_date');
        $this->data['end_date'] = $end_date = $this->input->post('end_date');
  $this->data['party'] = $party = $this->account_model->get_matparty($material_id);
        // if ($material_id != 0) {
        //     $this->data['party'] = $party = $this->account_model->get_matparty($material_id);
        // } else {

        //     $this->data['party'] = array();
        // }

        $this->db->select('account.*,material.name as matname, party.name as partyname');
        $this->db->from('account');
        $this->db->join('material', 'account.material_id=material.id');
        $this->db->join('party', 'account.party_id=party.id');
        $this->db->where('account.trash', 0); // Exclude deleted records
        $this->db->where('account.year_id', $this->data['year_id']); // Filter by financial year

        if ($start_date != '' && $end_date != '') {

            $st = date('Y-m-d', strtotime($start_date));
            $et = date('Y-m-d', strtotime($end_date));
            $this->db->where("account.entry_date >= '$st' AND account.entry_date <= '$et' ");
            $cond = array();
            if ($party_id != 0) {
                $cond['account.party_id'] = $party_id;
            }

            if ($material_id != 0) {
                $cond['account.material_id'] = $material_id;

            }
            if ($branch_id != 0) {
                $cond['account.branch_id'] = $branch_id;

            }

            $this->db->where($cond);

        } else {
            $cond = array();
            if ($party_id != 0) {
                $cond['account.party_id'] = $party_id;
            }

            if ($material_id != 0) {
                $cond['account.material_id'] = $material_id;

            }

            if ($branch_id != 0) {
                $cond['account.branch_id'] = $branch_id;

            }
            $this->db->where($cond);

        }

        $this->db->order_by('id', "DESC");
        $query = $this->db->get();
        $data = $query->result_array();
        $this->data['account'] = $data;

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['material'] = $this->account_model->get_material();

        $this->load->view("common/header");
        $this->load->view("account/admview_account", $this->data);
        $this->load->view("common/footer");

    }

    /**
     * View account records (excluding deleted)
     * 
     * @return void
     */
    public function view_account()
    {
        $branch_id = $this->session->userdata('branch_id');
        
        $this->data['material'] = $this->account_model->get_material();
         $this->data['party'] = $party = $this->account_model->get_matparty(0);
        // Get non-deleted accounts only
        $this->data['account'] = $this->account_model->get_allaccount($branch_id, false);
        
        // Initialize search parameters
        $this->data['party_id'] = '';
        $this->data['material_id'] = '';
        $this->data['start_date'] = '';
        $this->data['end_date'] = '';

        $this->_loadView('account/view_account');
    }

    public function search_account()
    {

        $branch_id = $this->session->userdata('branch_id');

        $this->data['party_id'] = $party_id = $this->input->post('party_id');
        $this->data['material_id'] = $material_id = $this->input->post('material_id');
        $this->data['start_date'] = $start_date = $this->input->post('start_date');
        $this->data['end_date'] = $end_date = $this->input->post('end_date');
        $this->data['party'] = $party = $this->account_model->get_matparty($material_id);
       
        $this->db->select('account.*,material.name as matname, party.name as partyname');
        $this->db->from('account');
        $this->db->join('material', 'account.material_id=material.id');
        $this->db->join('party', 'account.party_id=party.id');
        $this->db->where('account.branch_id', $branch_id);
        $this->db->where('account.trash', 0); // Exclude deleted records
        $this->db->where('account.year_id', $this->data['year_id']); // Filter by financial year

        if ($start_date != '' && $end_date != '') {

            $st = date('Y-m-d', strtotime($start_date));
            $et = date('Y-m-d', strtotime($end_date));
            $this->db->where("account.entry_date >= '$st' AND account.entry_date <= '$et' ");
            $cond = array();
            // Fix: Use $party_id instead of undefined $customer_id
            if ($party_id != 0) {
                $cond['account.party_id'] = $party_id;
            }

            if ($material_id != 0) {
                $cond['account.material_id'] = $material_id;

            }

            $this->db->where($cond);

        } else {
            $cond = array();
            if ($party_id != 0) {
                $cond['account.party_id'] = $party_id;
            }

            if ($material_id != 0) {
                $cond['account.material_id'] = $material_id;

            }
            $this->db->where($cond);

        }

        $this->db->order_by('id', "DESC");
        $query = $this->db->get();
        $data = $query->result_array();
        $this->data['account'] = $data;

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['material'] = $this->account_model->get_material();

        $this->load->view("common/header");
        $this->load->view("account/view_account", $this->data);
        $this->load->view("common/footer");

    }

    public function view_party_account_details($p_c)
    {

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');

        $account = $this->account_model->get_unpartyaccount($p_c);

        $len = count($account);

        $this->data['code'] = $p_c;
        $this->data['account'] = $account;
        $this->data['party'] = $this->account_model->get_party($branch_id);

        $this->load->view("common/header");
        $this->load->view("account/un_report", $this->data);
        $this->load->view("common/footer");

    }

    public function report2323()
    {

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');

        $account = $this->account_model->get_allpartyaccount($branch_id);

        $len = count($account);

        $this->data['account'] = $account;
        $this->data['party'] = $this->account_model->get_party($branch_id);

        $this->load->view("common/header");
        $this->load->view("account/report", $this->data);
        $this->load->view("common/footer");
    }



    public function report()
    {
        $this->data['party'] = $this->account_model->get_party();

        $this->data['branch'] = $this->account_model->get_branch();
        $this->load->view("common/header");
        $this->load->view("account/report", $this->data);
        $this->load->view("common/footer");
    }

    public function getreport()
    {

        $this->data['party'] = $this->account_model->get_party();
        $this->data['branch'] = $this->account_model->get_branch();

        $this->data['party_id'] = $party_id = $this->input->post('party_id');
        $this->data['branch_id'] = $branch_id = $this->input->post('branch_id');
        $this->data['start_date'] = $start_date = $this->input->post('start_date');
        $this->data['end_date'] = $end_date = $this->input->post('end_date');

        $this->db->select('purchase_account.*,party.name as partyname');
        $this->db->from('purchase_account');
        $this->db->join('party', 'purchase_account.party_id=party.id');
        $this->db->where('purchase_account.trash', 0); // Exclude deleted records
        $this->db->where('party.trash', 0); // Exclude deleted parties
        $this->db->where('purchase_account.year_id', $this->data['year_id']); // Filter by financial year
        if ($start_date != '' && $end_date != '') {

            $st = date('Y-m-d', strtotime($start_date));
            $et = date('Y-m-d', strtotime($end_date));
            $this->db->where("purchase_account.entry_date >= '$st' AND purchase_account.entry_date <= '$et' ");
            $cond = array();
            // if ($customer_id != 0) {
            //     $cond['purchase_account.customer_id'] = $customer_id;
            // }

            if ($branch_id != 0) {
                $cond['purchase_account.branch_id'] = $branch_id;
            }
            $this->db->where($cond);

        } else {
            //echo "i will stop here".$customer_id;exit;
            $cond = array();
            if ($party_id != 0) {
                $cond['purchase_account.party_id'] = $party_id;
            }
            if ($branch_id != 0) {
                $cond['purchase_account.branch_id'] = $branch_id;
            }
            $this->db->where($cond);

        }
        $alsales = $this->db->get()->result_array();
        $this->data['sales'] = $alsales;

        $this->load->view("common/header");
        $this->load->view("account/admin_report", $this->data);
        $this->load->view("common/footer");

    }

    public function view_details($entry_date = null)
    {

        $branch_id = 1;
        $this->data['account'] = $this->account_model->view_details($entry_date);
        $this->data['entry_date'] = $entry_date;
        $this->load->view("common/header");
        $this->load->view("account/view_details", $this->data);
        $this->load->view("common/footer");

    }

    /**
     * View party records (excluding deleted)
     * 
     * @return void
     */
    public function party()
    {
        $branch_id = $this->session->userdata('branch_id');
        
        // Get non-deleted parties only
        $this->data['party'] = $this->account_model->get_allparty($branch_id, false);
        
        $this->_loadView('account/view_party');
    }

    public function create_party($id = null)
    {

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');

    // $this->data['material'] = $this->account_model->get_material();

        $br = $this->account_model->get_pr($branch_id);
        $b_c = strtoupper($this->account_model->get_brcode($branch_id));

        $this->data['code'] = $code = $b_c . "PT" . $br;

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        //validate form input

    $this->form_validation->set_rules('name', "Party Name", 'required');
    $this->form_validation->set_rules('contact_no', "Contact No", 'required|numeric|exact_length[10]|is_unique[party.contact_no]');
    $this->form_validation->set_rules('address', "Address", 'required');
        //$this->form_validation->set_rules('unpublish_date', "Unpublish Date", 'required|xss_clean');

        if ($this->form_validation->run() == true) {
            $data = array('name' => $this->input->post('name'),
                'address' => $this->input->post('address'),
                'code' => $this->input->post('code'),
                'branch_id' => $branch_id,
                'contact_no' => $this->input->post('contact_no'),
                'entry_by' => $entry_by,
                'entry_date' => date('Y-m-d'),
                'remarks' => $this->input->post('remarks'),
            );

            $exam_id = $this->account_model->create_party($data);
            if ($exam_id) {

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/account/party");

            }

        } else {

            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            if ($this->input->post('name') != null) {
                $this->data['name'] = $this->input->post('name');
            } else {
                $this->data['name'] = '';
            }

            if ($this->input->post('address') != null) {
                $this->data['address'] = $this->input->post('address');
            } else {
                $this->data['address'] = '';
            }

            if ($this->input->post('contact_no') != null) {
                $this->data['contact_no'] = $this->input->post('contact_no');
            } else {
                $this->data['contact_no'] = '';
            }

            if ($this->input->post('remarks') != null) {
                $this->data['remarks'] = $this->input->post('remarks');
            } else {
                $this->data['remarks'] = '';
            }

            $this->session->set_flashdata('msg', 'Create Payment');

            $this->load->view("common/header");
            $this->load->view("account/add_party", $this->data);
            $this->load->view("common/footer");

        }

    }

    public function edit_party($id = null)
    {

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }
    // $this->data['material'] = $this->account_model->get_material();

    $this->form_validation->set_rules('name', "Party Name", 'required');
    $this->form_validation->set_rules('contact_no', "Contact No", 'required|numeric|exact_length[10]');
    $this->form_validation->set_rules('address', "Address", 'required');

        if ($this->form_validation->run() == true) {
            $data = array('name' => $this->input->post('name'),
                'address' => $this->input->post('address'),
                'contact_no' => $this->input->post('contact_no'),
                'remarks' => $this->input->post('remarks'),
            );

            $exam_id = $this->account_model->update_party($id, $data);
            if ($exam_id) {

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/account/party");

            }

        } else {

            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            if ($this->input->post('name') != null) {
                $this->data['name'] = $this->input->post('name');
            } else {
                $this->data['name'] = '';
            }

            if ($this->input->post('address') != null) {
                $this->data['address'] = $this->input->post('address');
            } else {
                $this->data['address'] = '';
            }

            if ($this->input->post('contact_no') != null) {
                $this->data['contact_no'] = $this->input->post('contact_no');
            } else {
                $this->data['contact_no'] = '';
            }
            $this->session->set_flashdata('msg', 'Create Payment');
            $this->data['party'] = $this->account_model->edit_party($id);
            $this->load->view("common/header");
            $this->load->view("account/edit_party", $this->data);
            $this->load->view("common/footer");

        }

    }

    public function misc()
    {

        $this->data['account'] = array();
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->load->view("common/header");
        $this->load->view("account/misc", $this->data);
        $this->load->view("common/footer");
    }

    // other payment
    public function other()
    {

        $this->data['account'] = array();
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->load->view("common/header");
        $this->load->view("account/other", $this->data);
        $this->load->view("common/footer");
    }

    public function interview()
    {

        $this->data['account'] = array();
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->load->view("common/header");
        $this->load->view("account/interview", $this->data);
        $this->load->view("common/footer");
    }

    // start of the payment

    public function add_payment($id = null)
    {
        $this->data['customer'] = $this->account_model->get_party();
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        //$this->data['products'] = $this->production_model->get_product();

        $br = $this->account_model->get_br($branch_id);
        $b_c = strtoupper($this->account_model->get_brcode($branch_id));

        $this->data['trans_no'] = $trans_no = $b_c . "P" . $br;

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        $this->form_validation->set_rules('party_id', "Party Name", 'required');
        $this->form_validation->set_rules('debit', "Amount", 'required');
        $this->form_validation->set_rules('entry_date', "Payment Date", 'required');
        $this->form_validation->set_rules('details', "Details", 'required');

        if ($this->form_validation->run() == true) {
            $data = array('invid' => $this->input->post('sl_no'),
                'party_id' => $this->input->post('party_id'),
                'entry_date' => date("Y-m-d", strtotime($this->input->post('entry_date'))),
                'debit' => $this->input->post('debit'),
                'details' => $this->input->post('details'),
                'branch_id' => $this->session->userdata('branch_id'),
                'year_id' => $this->data['year_id'],
                'entry_by' => $this->session->userdata('identity'),
            );

            $exam_id = $this->account_model->create_payment($data);
            if ($exam_id) {
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/account/view_payment");

            }

        } else {

            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            if ($this->input->post('party_id') != null) {
                $this->data['party_id'] = $this->input->post('party_id');
            } else {
                $this->data['party_id'] = '';
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

            $this->load->view("common/header");
            $this->load->view("account/add_payment", $this->data);
            $this->load->view("common/footer");

        }

    }

    public function edit_payment($id = null)
    {
        if (empty($id)) {
            show_404();
        }
        
        $branch_id = $this->session->userdata('branch_id');
        
        // Verify payment belongs to current branch
        $payment_check = $this->db->get_where('purchase_account', [
            'id' => $id,
            'branch_id' => $branch_id,
            'trash' => 0
        ])->row_array();
        
        if (empty($payment_check)) {
            $this->session->set_flashdata('error', 'Payment record not found or access denied');
            redirect('admin/account/view_payment');
        }
        
        $this->data['sales'] = $payment = $this->account_model->edit_payment($id);
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->account_model->get_party($branch_id);

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        $this->form_validation->set_rules('party_id', "Party Name", 'required');
        $this->form_validation->set_rules('debit', "Amount", 'required');
        $this->form_validation->set_rules('entry_date', "Payment Date", 'required');
        $this->form_validation->set_rules('details', "Details", 'required');

        if ($this->form_validation->run() == true) {

            $data = array('invid' => $this->input->post('sl_no'),
                'party_id' => $this->input->post('party_id'),
                'entry_date' => date("Y-m-d", strtotime($this->input->post('entry_date'))),
                'debit' => $this->input->post('debit'),
                'details' => $this->input->post('details'),
                'branch_id' => $this->session->userdata('branch_id'),
                'entry_by' => $this->session->userdata('identity'),
                'updated_by' => $this->session->userdata('identity'),
                'updated_at' => date('Y-m-d H:i:s'),
                'year_id' => $this->data['year_id']
            );

            $uc['id'] = $id;
            $update = $this->db->update('purchase_account', $data, $uc);

            if ($update) {

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/account/view_payment");

            }

        } else {

            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->session->set_flashdata('msg', 'Create Payment');
            $this->load->view("common/header");
            $this->load->view("account/edit_payment", $this->data);
            $this->load->view("common/footer");

        }

    }

    /**
     * View payment records (excluding deleted)
     * 
     * @return void
     */
    public function view_payment()
    {
        $branch_id = $this->session->userdata('branch_id');
        
        // Initialize search parameters
        $this->data['party_id'] = '';
        $this->data['start_date'] = '';
        $this->data['end_date'] = '';
        
        // Get non-deleted data
        $this->data['customer'] = $this->account_model->get_party($branch_id, false);
        $this->data['sales'] = $this->account_model->get_allpayments($branch_id, false);

        $this->_loadView('account/view_payment');
    }

    public function search_payment()
    {
        $this->data['party_id'] = $party_id = $this->input->post("party_id");
        //    $this->data['material_id'] = $material_id = $this->input->post('material_id');
        $this->data['start_date'] = $start_date = $this->input->post("start_date");
        $this->data['end_date'] = $end_date = $this->input->post("end_date");
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->account_model->get_party($branch_id);

        $this->db->select('purchase_account.*,party.name as customername');
        $this->db->from('purchase_account');
        $this->db->join('party', 'purchase_account.party_id=party.id');
        $this->db->where('purchase_account.branch_id', $branch_id);
        $this->db->where('purchase_account.trash', 0); // Exclude deleted records
        $this->db->where('party.trash', 0); // Exclude deleted parties
        $this->db->where('purchase_account.year_id', $this->data['year_id']); // Filter by financial year

        if ($start_date != '' && $end_date != '') {

            $st = date('Y-m-d', strtotime($start_date));
            $et = date('Y-m-d', strtotime($end_date));
            $this->db->where("purchase_account.entry_date >= '$st' AND purchase_account.entry_date <= '$et' ");
            $cond = array();
            if ($party_id != 0) {
                $cond['purchase_account.party_id'] = $party_id;
            }
            $this->db->where($cond);

        } else {
            //echo "i will stop here".$customer_id;exit;
            $cond = array();
            if ($party_id != 0) {
                $cond['purchase_account.party_id'] = $party_id;
            }
            $this->db->where($cond);

        }

        $this->db->order_by('id', "DESC");
        $query = $this->db->get();
        $this->data['sales'] = $sales = $query->result_array();

        $this->load->view("common/header");
        $this->load->view("account/view_payment", $this->data);
        $this->load->view("common/footer");

    }

    /**
     * Soft delete payment record
     * 
     * @param int|null $id Payment ID
     * @return void
     */
    public function delete_payment($id = null)
    {
        if (empty($id)) {
            show_404();
        }
        
        // Check if payment exists and is not already deleted (ensure branch_id security)
        $branch_id = $this->session->userdata('branch_id');
        $payment = $this->db->get_where('purchase_account', [
            'id' => $id,
            'trash' => 0,
            'branch_id' => $branch_id
        ])->row_array();
        
        if (empty($payment)) {
            $this->session->set_flashdata('error', 'Payment record not found or already deleted');
            redirect('admin/account/view_payment');
            return;
        }
        
        // Soft delete with audit trail
        $update_data = [
            'status' => 1,
            'trash' => 1,
            'is_deleted' => 1,
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => $this->session->userdata('identity'),
            'year_id' => $this->data['year_id']
        ];
        
        if ($this->db->update('purchase_account', $update_data, ['id' => $id])) {
            $this->session->set_flashdata('success', 'Payment record deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete payment record');
        }
        
        redirect('admin/account/view_payment');
    }

    /**
     * Soft delete party record
     * 
     * @param int $id Party ID
     * @return void
     */
    public function delete_party($id)
    {
        if (empty($id)) {
            show_404();
        }
        
        // Check if party exists and is not already deleted (ensure branch_id security)
        $branch_id = $this->session->userdata('branch_id');
        $party = $this->db->get_where('party', [
            'id' => $id,
            'trash' => 0,
            'branch_id' => $branch_id
        ])->row_array();
        
        if (empty($party)) {
            $this->session->set_flashdata('error', 'Party not found or already deleted');
            redirect('admin/account/party');
            return;
        }
        
        // Check if party has related records
        $has_accounts = $this->db->get_where('account', [
            'party_id' => $id,
            'trash' => 0
        ])->num_rows() > 0;
        
        $has_payments = $this->db->get_where('purchase_account', [
            'party_id' => $id,
            'trash' => 0
        ])->num_rows() > 0;
        
        if ($has_accounts || $has_payments) {
            $this->session->set_flashdata('error', 'Cannot delete party as it has related account records');
            redirect('admin/account/party');
            return;
        }
        
        // Soft delete with audit trail
        $update_data = [
            'trash' => 1,
            'is_deleted' => 1,
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => $this->session->userdata('identity'),
            'year_id' => $this->data['year_id']
        ];
        
        if ($this->db->update('party', $update_data, ['id' => $id])) {
            $this->session->set_flashdata('success', 'Party deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete party');
        }
        
        redirect('admin/account/party');
    }

    /**
     * Soft delete account record and related purchase account
     * 
     * @param int $id Account ID
     * @return void
     */
    public function delete($id)
    {
        if (empty($id)) {
            show_404();
        }
        
        // Start database transaction
        $this->db->trans_start();
        
        try {
            // Get account record (check if not already deleted and ensure branch_id security)
            $branch_id = $this->session->userdata('branch_id');
            $account = $this->db->get_where('account', [
                'id' => $id,
                'trash' => 0,
                'branch_id' => $branch_id
            ])->row_array();
            
            if (empty($account)) {
                $this->session->set_flashdata('error', 'Account record not found or already deleted');
                redirect('admin/account/view_account');
                return;
            }
            
            // Check if account is approved - prevent deletion of approved accounts
            if (isset($account['status']) && $account['status'] == 1) {
                $this->session->set_flashdata('error', 'Cannot delete approved account records');
                redirect('admin/account/view_account');
                return;
            }
            
            // Soft delete main account record
            $update_data = [
                'trash' => 1,
                'is_deleted' => 1,
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => $this->session->userdata('identity'),
                'year_id' => $this->data['year_id']
            ];
            
            $this->db->update('account', $update_data, ['id' => $id]);
            
            // Soft delete related purchase account
            $purchase_update = [
                'trash' => 1,
                'status' => 1,
                'is_deleted' => 1,
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => $this->session->userdata('identity'),
                'year_id' => $this->data['year_id']
            ];
            
            $this->db->update('purchase_account', $purchase_update, ['invid' => $account['trans_no']]);
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'Failed to delete account record');
            } else {
                $this->session->set_flashdata('success', 'Account record deleted successfully');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Account deletion failed: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'An error occurred while deleting account');
        }
        
        redirect('admin/account/view_account');
    }
    
    /**
     * Initialize account form data
     * 
     * @param int $branch_id Branch ID
     * @return void
     */
    private function _initializeAccountForm($branch_id)
    {
        $this->data['material'] = $this->account_model->get_material();
        $this->data['title'] = "Create Account";
        
        $br = $this->account_model->get_br($branch_id);
        $this->data['trans_no'] = "BFABPU" . $br;
    }
    
    /**
     * Set account validation rules
     * 
     * @return void
     */
    private function _setAccountValidationRules()
    {
        $rules = [
            ['field' => 'payment_status', 'label' => 'Payment Status', 'rules' => 'required|trim'],
            ['field' => 'vehicle_no', 'label' => 'Vehicle No', 'rules' => 'required|trim'],
            ['field' => 'amount', 'label' => 'Total Amount', 'rules' => 'required|numeric'],
            ['field' => 'entry_date', 'label' => 'Entry Date', 'rules' => 'required|trim'],
            ['field' => 'refno', 'label' => 'Reference No', 'rules' => 'required|trim'],
            ['field' => 'material_id', 'label' => 'Material Name', 'rules' => 'required|integer'],
            ['field' => 'party_id', 'label' => 'Party Name', 'rules' => 'required|integer'],
            ['field' => 'stock', 'label' => 'Quantity', 'rules' => 'required|numeric']
        ];
        
        $this->form_validation->set_rules($rules);
    }
    
    /**
     * Process account creation
     * 
     * @param int $branch_id Branch ID
     * @param string $entry_by Entry user
     * @return void
     */
    private function _processAccountCreation($branch_id, $entry_by)
    {
        // Start database transaction
        $this->db->trans_start();
        try {
            // Prepare account data
            $account_data = [
                'trans_no' => $this->input->post('trans_no'),
                'vehicle_no' => $this->input->post('vehicle_no'),
                'party_id' => $this->input->post('party_id'),
                'material_id' => $this->input->post('material_id'),
                'paiddetails' => $this->input->post('paiddetails'),
                'paid_amount' => $this->input->post('paid_amount'),
                'payment_status' => $this->input->post('payment_status'),
                'refno' => $this->input->post('refno'),
                'amount' => $this->input->post('amount'),
                'stock' => $this->input->post('stock'),
                'unit' => $this->input->post('unit'),
                'entry_date' => date('Y-m-d', strtotime($this->input->post('entry_date'))),
                'remarks' => $this->input->post('remarks'),
                'type' => $this->input->post('type'),
                'entry_by' => $entry_by,
                'branch_id' => $branch_id,
                'year_id' => $this->data['year_id']
            ];
            // Fix: If payment status is unpaid, set paid_amount and paiddetails to 0/empty
            if ($this->input->post('payment_status') == 0 || strtolower($this->input->post('payment_status')) === 'unpaid') {
                $account_data['paid_amount'] = 0;
                $account_data['paiddetails'] = '';
            }

        
            // Create account
            $account_id = $this->account_model->create_account($account_data);
            // Remove debug exit to allow transaction completion
            
            if ($account_id) {
                // Generate invoice number
                $count = $this->db->where('branch_id', $branch_id)->count_all_results('purchase_account');
                $invno = "BFABPAY" . ($count + 1);
                
                // Prepare purchase account data
                $purchase_data = [
                    'invid' => $this->input->post('trans_no'),
                    'invno' => $invno,
                    'party_id' => $this->input->post('party_id'),
                    'details' => $this->input->post('paiddetails'),
                    'credit' => $this->input->post('amount'),
                    'entry_date' => date('Y-m-d', strtotime($this->input->post('entry_date'))),
                    'entry_by' => $entry_by,
                    'branch_id' => $branch_id,
                    'year_id' => $this->data['year_id']
                ];
                
                // Set debit and type based on payment status
                $payment_status = $this->input->post('payment_status');
                if ($payment_status == 1) {
                    $purchase_data['debit'] = $this->input->post('paid_amount');
                    $purchase_data['type'] = $this->input->post('type');
                } else {
                    $purchase_data['debit'] = 0;
                    $purchase_data['type'] = 0;
                    $purchase_data['details'] = '';
                }
                
                $this->db->insert('purchase_account', $purchase_data);
            }
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'Failed to create account record');
            } else {
                $this->session->set_flashdata('success', 'Account record created successfully');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Account creation failed: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'An error occurred while creating account');
        }
        
        redirect('admin/account/view_account');
    }
    
    /**
     * Set form display data with input persistence
     * 
     * @return void
     */
    private function _setFormDisplayData()
    {
        $this->data['message'] = validation_errors() ?: 
                                 ($this->ion_auth->errors() ?: 
                                 $this->session->flashdata('message'));
        
        // Form field persistence
        $fields = [
            'party_id', 'vehicle_no', 'paiddetails', 'paid_amount', 
            'refno', 'stock', 'payment_status', 'remarks', 'entry_date', 'amount'
        ];
        
        foreach ($fields as $field) {
            $this->data[$field] = $this->input->post($field) ?: '';
        }
        
        // Get party data for the form
        $branch_id = $this->session->userdata('branch_id');
        $this->data['party'] = $this->account_model->get_party($branch_id);
        
        $this->session->set_flashdata('msg', 'Create Payment');
    }
    
    /**
     * Load view with header and footer
     * 
     * @param string $view View name
     * @param array $data Additional data (optional)
     * @return void
     */
    private function _loadView($view, $data = [])
    {
        $view_data = array_merge($this->data, $data);
        
        $this->load->view('common/header', $view_data);
        $this->load->view($view, $view_data);
        $this->load->view('common/footer', $view_data);
    }

}
