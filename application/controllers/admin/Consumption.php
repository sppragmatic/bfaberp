<?php defined('BASEPATH') or exit('No direct script access allowed');

class Consumption extends CI_Controller
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
     * Consumption model
     *
     * @var object
     */
    public $consumption_model;

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

    public function __construct()
    {

        parent::__construct();
        $this->load->database();

        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('common_model');
        $this->load->model('payment_model');
        $this->load->model('consumption_model');
        $this->load->model('account_model');
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

    public function delete($id = null)
    {
        $cond['id'] = $id;
        $data['trash'] = 1;
        $this->db->update('consumption', $data, $cond);
        redirect('admin/consumption');

    }

    public function delete_payment($id = null)
    {
        $cond['id'] = $id;
        $data['status'] = 1;
        $this->db->update('consumption_account', $data, $cond);
        redirect('admin/consumption/view_payment');

    }

    public function chalan($id)
    {
        $this->data['consumption'] = $consumption = $this->consumption_model->print_consumption($id);
        $this->data['products'] = $items = $this->consumption_model->get_proditem($id);

        //print('<pre>');
        //print_r($this->data);
        //exit;

        //$this->data['report']=$receipt;

        $this->load->view("common/header");
        $this->load->view("consumption/challan", $this->data);
        $this->load->view("common/footer");
    }

    public function approve($id = null)
    {
        //    $this->data['production'] = $this->production_model->get_production($id);
        //$this->data['products']= $items  = $this->production_model->get_approvitem($id);

        $this->data['consumption'] = $consumption = $this->consumption_model->edit_consumption($id);
        $this->data['products'] = $items = $this->consumption_model->get_proditem($id);

        foreach ($items as $it) {
            $chk['branch_id'] = $it['branch_id'];
            $chk['product_id'] = $it['product_id'];
            $this->db->select('*');
            $this->db->from('stock');
            $res = $this->db->where($chk)->get();
            $num = $res->num_rows();
            if ($num > 0) {
                $prevstock = $res->row_array();
                //$chk['id'] = $prevstock['id'];
                $newstock = $prevstock['stock'] - $it['stock'];
                $stock['stock'] = $newstock;
                $this->db->update("stock", $stock, $chk);
            }
            //exit;

            $prod['status'] = 1;
            $prodcond['id'] = $it['id'];
            $this->db->update("consumption_item", $prod, $prodcond);
        }
        //exit;
        $production['status'] = 1;
        $productioncond['id'] = $id;
        $this->db->update("consumption", $production, $productioncond);
        redirect('admin/production');
    }

    //redirect if needed, otherwise display the user list

    public function index($id = null)
    {
        //echo "i amhee";exit;
        $this->data['customer'] = $this->consumption_model->get_customer();
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['products'] = $this->account_model->get_material();

        $br = $this->consumption_model->get_br($branch_id);
        $b_c = strtoupper($this->consumption_model->get_brcode($branch_id));

        $this->data['trans_no'] = $trans_no = $b_c . "P" . $br;

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        //validate form input

        //$this->form_validation->set_rules('customer_name', "customer Name", 'required|xss_clean');

        $this->form_validation->set_rules('bill_date', "Entry Date", 'required|xss_clean');
        //$this->form_validation->set_rules('remarks', "Remakrs", 'required|xss_clean');
        //$this->form_validation->set_rules('unpublish_date', "Unpublish Date", 'required|xss_clean');

        if ($this->form_validation->run() == true) {

            //    print('<pre>');
            //    print_r($_REQUEST);
            //    exit;

            $data = array('sl_no' => $this->input->post('sl_no'),
                'bill_date' => date('Y-m-d', strtotime($this->input->post('bill_date'))),
                'branch_id' => $branch_id,
            );

            $exam_id = $this->consumption_model->create_consumption($data);
            if ($exam_id) {

                $prod = $this->input->post('prod');

                foreach ($prod as $key => $val) {
                    $insitem['material_id'] = $key;
                    $insitem['stock'] = $val;
                    $insitem['branch_id'] = $branch_id;
                    $insitem['consumption_id'] = $exam_id;
                    //print_r($insitem);
                    $this->db->insert('consumption_item', $insitem);
                }

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/consumption/view_consumption");

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

            $this->session->set_flashdata('msg', 'Create Payment');

/*    print_r($this->data);
exit;$this->data['customer'] = $this->consumption_model->get_customer($branch_id);
 */

            $this->load->view("common/header");
            $this->load->view("consumption/add", $this->data);
            $this->load->view("common/footer");

        }

    }

    public function edit_consumption($id = null)
    {
        $this->data['consumption'] = $consumption = $this->consumption_model->edit_consumption($id);
        $this->data['products'] = $this->consumption_model->get_proditem($id);

        //print('<pre>');
        //print_r($this->data['consumption']);
        //exit;

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->consumption_model->get_customer($branch_id);

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        //validate form input

        $this->form_validation->set_rules('bill_date', "Entry Date", 'required|xss_clean');

        //$this->form_validation->set_rules('unpublish_date', "Unpublish Date", 'required|xss_clean');

        if ($this->form_validation->run() == true) {

            $data = array('sl_no' => $this->input->post('sl_no'),
                'bill_date' => date('Y-m-d', strtotime($this->input->post('bill_date'))),
                'branch_id' => $branch_id,
            );

            $uc['id'] = $id;
            $update = $this->db->update('consumption', $data, $uc);
//echo $this->db->last_query();exit;

            foreach ($prod as $key => $val) {
                $upcond['id'] = $key;
                $upitem['stock'] = $val;
                //$insitem['production_id'] =$insert;
                $this->db->update('consumption_item', $upitem, $upcond);
            }

            if ($update) {

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/consumption/view_consumption");

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
            $this->load->view("consumption/edit", $this->data);
            $this->load->view("common/footer");

        }

    }

// start of the payemnet

    public function add_payment($id = null)
    {
        //echo "i amhee";exit;
        $this->data['customer'] = $this->consumption_model->get_customer();
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['products'] = $this->production_model->get_product();

        $br = $this->consumption_model->get_br($branch_id);
        $b_c = strtoupper($this->consumption_model->get_brcode($branch_id));

        $this->data['trans_no'] = $trans_no = $b_c . "P" . $br;

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        //validate form input

        //$this->form_validation->set_rules('customer_name', "customer Name", 'required|xss_clean');

        $this->form_validation->set_rules('customer_id', "Customer Name", 'required|xss_clean');
        $this->form_validation->set_rules('debit', "Amount", 'required|xss_clean');
        $this->form_validation->set_rules('entry_date', "Payment Date", 'required|xss_clean');
        $this->form_validation->set_rules('details', "Details", 'required|xss_clean');

        //$this->form_validation->set_rules('remarks', "Remakrs", 'required|xss_clean');
        //$this->form_validation->set_rules('unpublish_date', "Unpublish Date", 'required|xss_clean');

        if ($this->form_validation->run() == true) {
            $data = array('invid' => $this->input->post('sl_no'),
                'customer_id' => $this->input->post('customer_id'),
                'entry_date' => date("Y-m-d", strtotime($this->input->post('entry_date'))),
                'debit' => $this->input->post('debit'),
                'details' => $this->input->post('details'),
                'branch_id' => $this->session->userdata('branch_id'),
                'entry_by' => $this->session->userdata('identity'),
            );

            $exam_id = $this->consumption_model->create_payment($data);
            if ($exam_id) {
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/consumption/view_payment");

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
            exit;$this->data['customer'] = $this->consumption_model->get_customer($branch_id);
             */

            $this->load->view("common/header");
            $this->load->view("consumption/add_payment", $this->data);
            $this->load->view("common/footer");

        }

    }

    public function edit_payment($id = null)
    {
        $this->data['consumption'] = $payment = $this->consumption_model->edit_payment($id);

//print("<pre>");
        //print_r($payment);
        //exit;

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->consumption_model->get_customer($branch_id);

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        //validate form input
        $this->form_validation->set_rules('customer_id', "Customer Name", 'required|xss_clean');
        $this->form_validation->set_rules('debit', "Amount", 'required|xss_clean');
        $this->form_validation->set_rules('entry_date', "Payment Date", 'required|xss_clean');
        $this->form_validation->set_rules('details', "Details", 'required|xss_clean');

        //$this->form_validation->set_rules('unpublish_date', "Unpublish Date", 'required|xss_clean');
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
            $update = $this->db->update('consumption_account', $data, $uc);

            if ($update) {

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/consumption/view_payment");

            }

        } else {

            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->session->set_flashdata('msg', 'Create Payment');
            /*    print_r($this->data);
            exit;
             */
            $this->load->view("common/header");
            $this->load->view("consumption/edit_payment", $this->data);
            $this->load->view("common/footer");

        }

    }

    public function view_payment()
    {

        $this->data['customer_id'] = '';
        //    $this->data['material_id'] = $material_id = $this->input->post('material_id');
        $this->data['start_date'] = '';
        $this->data['end_date'] = '';
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->consumption_model->get_customer($branch_id);
        $this->data['consumption'] = $consumption = $this->consumption_model->get_allpayments($branch_id);

        $this->load->view("common/header");
        $this->load->view("consumption/view_payment", $this->data);
        $this->load->view("common/footer");

    }

    public function search_payment()
    {

        $this->data['customer_id'] = $customer_id = $this->input->post("customer_id");
        //    $this->data['material_id'] = $material_id = $this->input->post('material_id');
        $this->data['start_date'] = $start_date = $this->input->post("start_date");
        $this->data['end_date'] = $end_date = $this->input->post("end_date");

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->consumption_model->get_customer($branch_id);

        $this->db->select('consumption_account.*,customer.name as customername');
        $this->db->from('consumption_account');
        $this->db->join('customer', 'consumption_account.customer_id=customer.id');
        $this->db->where('consumption_account.branch_id', $branch_id);

        if ($start_date != '' && $end_date != '') {

            $st = date('Y-m-d', strtotime($start_date));
            $et = date('Y-m-d', strtotime($end_date));
            $this->db->where("consumption_account.entry_date >= '$st' AND consumption_account.entry_date <= '$et' ");
            $cond = array();
            if ($customer_id != 0) {
                $cond['consumption_account.customer_id'] = $customer_id;
            }
            $this->db->where($cond);

        } else {
            //echo "i will stop here".$customer_id;exit;
            $cond = array();
            if ($customer_id != 0) {
                $cond['consumption_account.customer_id'] = $customer_id;
            }
            $this->db->where($cond);

        }
        //$this->db->limit('50');
        $this->db->order_by('id', "DESC");
        $query = $this->db->get();
        $this->data['consumption'] = $consumption = $query->result_array();

        //$this->consumption_model->get_allpayments($branch_id);

        $this->load->view("common/header");
        $this->load->view("consumption/view_payment", $this->data);
        $this->load->view("common/footer");

    }

    /// end of the payment

    public function admin_consumption()
    {
        $this->data['branch'] = $this->consumption_model->get_branch();
        $this->data['customer_id'] = '';
        $this->data['branch_id'] = '';
        //    $this->data['material_id'] = $material_id = $this->input->post('material_id');
        $this->data['start_date'] = '';
        $this->data['end_date'] = '';

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->consumption_model->get_customer($branch_id);
        $this->data['consumption'] = $consumption = $this->consumption_model->admin_allconsumption($branch_id);

        $this->data['products'] = $this->production_model->get_product();
        $allconsumption = array();
        foreach ($consumption as $prod) {
            $consumption_id = $prod['id'];
            $prod['allitem'] = $productitems = $this->consumption_model->get_proditem($consumption_id);
            $allconsumption[] = $prod;
        }
        $this->data['consumption'] = $allconsumption;

        //print('<pre>');
        //print_r($this->data['consumption']);
        //exit;

        $this->load->view("common/header");
        $this->load->view("consumption/admin_consumption", $this->data);
        $this->load->view("common/footer");

    }

    public function admsearch_consumption()
    {

        $this->data['branch'] = $this->consumption_model->get_branch();
        $this->data['customer_id'] = $customer_id = $this->input->post('customer_id');
        $this->data['branch_id'] = $customer_id = $this->input->post('branch_id');
        //    $this->data['material_id'] = $material_id = $this->input->post('material_id');
        $this->data['start_date'] = $start_date = $this->input->post('start_date');
        $this->data['end_date'] = $end_date = $this->input->post('end_date');

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->consumption_model->get_customer($branch_id);

        $this->data['consumption'] = $consumption = $this->consumption_model->get_allconsumption($branch_id);

        $this->data['products'] = $this->production_model->get_product();
//$year_id = $this->get_fyr();
        $this->db->select('consumption.*,customer.name as customername');
        $this->db->from('consumption');
        $this->db->join('customer', 'consumption.customer_id=customer.id');
//$this->db->where('year_id',$year_id);
        //$this->db->where('consumption.branch_id',$branch_id);
        if ($start_date != '' && $end_date != '') {

            $st = date('Y-m-d', strtotime($start_date));
            $et = date('Y-m-d', strtotime($end_date));
            $this->db->where("consumption.bill_date >= '$st' AND consumption.bill_date <= '$et' ");
            $cond = array();
            if ($customer_id != 0) {
                $cond['consumption.customer_id'] = $customer_id;
            }

            if ($branch_id != 0) {
                $cond['consumption.branch_id'] = $branch_id;
            }
            $this->db->where($cond);

        } else {
            //echo "i will stop here".$customer_id;exit;
            $cond = array();
            if ($customer_id != 0) {
                $cond['consumption.customer_id'] = $customer_id;
            }

            if ($branch_id != 0) {
                $cond['consumption.branch_id'] = $branch_id;
            }
            $this->db->where($cond);

        }

//$this->db->limit('50');
        $this->db->order_by('id', "DESC");
        $query = $this->db->get();
        $consumption = $query->result_array();
//print_r($consumption);
        //exit;

        $allconsumption = array();
        foreach ($consumption as $prod) {
            $consumption_id = $prod['id'];
            $prod['allitem'] = $productitems = $this->consumption_model->get_proditem($consumption_id);
            $allconsumption[] = $prod;
        }
        $this->data['consumption'] = $allconsumption;

        //print('<pre>');
        //print_r($this->data['consumption']);
        //exit;

        $this->load->view("common/header");
        $this->load->view("consumption/admin_consumption", $this->data);
        $this->load->view("common/footer");

    }

    public function view_consumption()
    {

        $this->data['customer_id'] = '';
        //    $this->data['material_id'] = $material_id = $this->input->post('material_id');
        $this->data['start_date'] = '';
        $this->data['end_date'] = '';

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->consumption_model->get_customer($branch_id);

        $this->data['consumption'] = $consumption = $this->consumption_model->get_allconsumption($branch_id);

        $this->data['products'] = $this->account_model->get_material();
        $allconsumption = array();
        foreach ($consumption as $prod) {
            $consumption_id = $prod['id'];
            $prod['allitem'] = $productitems = $this->consumption_model->get_proditem($consumption_id);
            $allconsumption[] = $prod;
        }
        $this->data['consumption'] = $allconsumption;

        //print('<pre>');
        //print_r($this->data['consumption']);
        //exit;

        $this->load->view("common/header");
        $this->load->view("consumption/view_consumption", $this->data);
        $this->load->view("common/footer");

    }

    public function search_consumption()
    {

        $this->data['customer_id'] = $customer_id = $this->input->post('customer_id');
        //    $this->data['material_id'] = $material_id = $this->input->post('material_id');
        $this->data['start_date'] = $start_date = $this->input->post('start_date');
        $this->data['end_date'] = $end_date = $this->input->post('end_date');

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->consumption_model->get_customer($branch_id);

        $this->data['consumption'] = $consumption = $this->consumption_model->get_allconsumption($branch_id);

        $this->data['products'] = $this->production_model->get_product();
        //$year_id = $this->get_fyr();
        $this->db->select('consumption.*,customer.name as customername');
        $this->db->from('consumption');
        $this->db->join('customer', 'consumption.customer_id=customer.id');
        //$this->db->where('year_id',$year_id);
        $this->db->where('consumption.branch_id', $branch_id);
        if ($start_date != '' && $end_date != '') {

            $st = date('Y-m-d', strtotime($start_date));
            $et = date('Y-m-d', strtotime($end_date));
            $this->db->where("consumption.bill_date >= '$st' AND consumption.bill_date <= '$et' ");
            $cond = array();
            if ($customer_id != 0) {
                $cond['consumption.customer_id'] = $customer_id;
            }
            $this->db->where($cond);

        } else {
            //echo "i will stop here".$customer_id;exit;
            $cond = array();
            if ($customer_id != 0) {
                $cond['consumption.customer_id'] = $customer_id;
            }
            $this->db->where($cond);

        }

        //$this->db->limit('50');
        $this->db->order_by('id', "DESC");
        $query = $this->db->get();
        $consumption = $query->result_array();
//print_r($consumption);
        //exit;

        $allconsumption = array();
        foreach ($consumption as $prod) {
            $consumption_id = $prod['id'];
            $prod['allitem'] = $productitems = $this->consumption_model->get_proditem($consumption_id);
            $allconsumption[] = $prod;
        }
        $this->data['consumption'] = $allconsumption;

        //print('<pre>');
        //print_r($this->data['consumption']);
        //exit;

        $this->load->view("common/header");
        $this->load->view("consumption/view_consumption", $this->data);
        $this->load->view("common/footer");

    }

    public function view_customer_consumption_details($p_c)
    {

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');

        $consumption = $this->consumption_model->get_uncustomerconsumption($p_c);

        $len = count($consumption);

        $this->data['code'] = $p_c;
        $this->data['consumption'] = $consumption;
        $this->data['customer'] = $this->consumption_model->get_customer($branch_id);

        $this->load->view("common/header");
        $this->load->view("consumption/un_report", $this->data);
        $this->load->view("common/footer");

    }

    public function report44()
    {

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');

        $consumption = $this->consumption_model->get_allcustomerconsumption($branch_id);

        $len = count($consumption);

        $this->data['consumption'] = $consumption;
        $this->data['customer'] = $this->consumption_model->get_customer($branch_id);

        $this->load->view("common/header");
        $this->load->view("consumption/report", $this->data);
        $this->load->view("common/footer");
    }

    public function get_report()
    {
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');

        $this->data['customer'] = $this->consumption_model->get_customer($branch_id);
        $this->data['type'] = $type = $this->input->post('type');
        $this->data['customer_id'] = $customer_id = $this->input->post('customer_id');

        $this->data['start_date'] = $s_t = $this->input->post('start_date');
        $this->data['end_date'] = $e_t = $this->input->post('end_date');

        if ($s_t != '') {
            $start_date = date('Y-m-d', strtotime($s_t));
        } else {
            $start_date = '0';
        }

        if ($e_t != '') {
            $end_date = date('Y-m-d', strtotime($e_t));
        } else {
            $end_date = '0';
        }

        $year_id = $this->data['year_id'];
        $p_d = $this->consumption_model->get_consumption_report($start_date, $end_date, $type, $customer_id, $year_id);
        if ($s_t != '' && $e_t != '' && $type != '2') {
            $s_d = $this->consumption_model->get_student_report($start_date, $end_date, $year_id);
            $l_p = count($p_d);
            $c = 0;
            foreach ($s_d as $ss) {
                $l_p = $l_p + $c;

                $p_d[$l_p]['trans_no'] = 'STUDENT';
                $p_d[$l_p]['customer_name'] = 'STUDENT';
                $p_d[$l_p]['amount'] = $ss['a_p'];
                $p_d[$l_p]['type'] = 1;
                $p_d[$l_p]['entry_date'] = $ss['paid_date'];
                $p_d[$l_p]['remarks'] = 'Student Payment';

                $c = $c + 1;
            }

            /*    print("<pre>");
        print_r($p_d);
        echo count($p_d);
        print_r($s_d);
        exit;*/

        }

        $this->data['consumption'] = $p_d;
        $this->load->view("common/header");
        $this->load->view("consumption/acc_report", $this->data);
        $this->load->view("common/footer");

        /*if($type=='0' && $customer_id =='0'){

        if($start_date!='' && $end_date!='' ){

        $this->consumption_model->get_consumption_report($start_date, $end_date);
        }else{
        $x=0;
        }

        }else if($type!='0' && $customer_id !='0'){

        if($start_date!='' && $end_date!='' ){
        $this->consumption_model->get_consumption_report($start_date, $end_date, $type_id, $customer_id);
        }else{
        $this->consumption_model->get_consumption_report($type_id, $customer_id);
        }

        }else if($type!='0' && $customer_id =='0'){

        if($start_date!='' && $end_date!='' ){
        $this->consumption_model->get_consumption_report($start_date, $end_date, $type_id);
        }else{
        $x=0;
        }

        }else if($type=='0' && $customer_id !='0'){

        if($start_date!='' && $end_date!='' ){

        }else{
        $x=0;
        }

        }*/

        //$s_t = $this->input->post('start_date');
        //$e_t = $this->input->post('end_date');
        ////$start_date =  date('Y-m-d', strtotime($s_t));
        //$end_date = date('Y-m-d', strtotime($e_t));
        //$this->data['start_date']=$this->input->post('start_date');
        ///$this->data['end_date']=$this->input->post('end_date');
        //$this->data['consumption'] = $this->consumption_model->get_report($start_date, $end_date);
        //$this->load->view("common/header");
        //$this->load->view("consumption/view_report",$this->data);
        //$this->load->view("common/footer");
    }

/// start fo th code for report
    public function report()
    {
        //echo "ia mhere";exit;
        $this->data['customer'] = $this->consumption_model->get_customer();
        $this->data['branch'] = $this->consumption_model->get_branch();
        $this->load->view("common/header");
        $this->load->view("consumption/report", $this->data);
        $this->load->view("common/footer");
    }

    public function getreport()
    {

        $this->data['customer'] = $this->consumption_model->get_customer();
        $this->data['branch'] = $this->consumption_model->get_branch();

        $this->data['customer_id'] = $customer_id = $this->input->post('customer_id');
        $this->data['branch_id'] = $branch_id = $this->input->post('branch_id');
        //    $this->data['material_id'] = $material_id = $this->input->post('material_id');
        $this->data['start_date'] = $start_date = $this->input->post('start_date');
        $this->data['end_date'] = $end_date = $this->input->post('end_date');

//$year_id = $this->get_fyr();
        $this->db->select('consumption_account.*,customer.name as customername');
        $this->db->from('consumption_account');
        $this->db->join('customer', 'consumption_account.customer_id=customer.id');
//$this->db->where('year_id',$year_id);
        //$this->db->where('consumption.branch_id',$branch_id);
        if ($start_date != '' && $end_date != '') {

            $st = date('Y-m-d', strtotime($start_date));
            $et = date('Y-m-d', strtotime($end_date));
            $this->db->where("consumption_account.entry_date >= '$st' AND consumption_account.entry_date <= '$et' ");
            $cond = array();
            if ($customer_id != 0) {
                $cond['consumption_account.customer_id'] = $customer_id;
            }

            if ($branch_id != 0) {
                $cond['consumption_account.branch_id'] = $branch_id;
            }
            $this->db->where($cond);

        } else {
            //echo "i will stop here".$customer_id;exit;
            $cond = array();
            if ($customer_id != 0) {
                $cond['consumption_account.customer_id'] = $customer_id;
            }

            if ($branch_id != 0) {
                $cond['consumption_account.branch_id'] = $branch_id;
            }
            $this->db->where($cond);

        }
        $alconsumption = $this->db->get()->result_array();
        $this->data['consumption'] = $alconsumption;

//print("<pre>");
        //print_r($alconsumption);
        //exit;

        $this->load->view("common/header");
        $this->load->view("consumption/admin_report", $this->data);
        $this->load->view("common/footer");

    }

//// end of the code for report

    public function view_details($entry_date = null)
    {

        $branch_id = 1;
        $this->data['consumption'] = $this->consumption_model->view_details($entry_date);
        $this->data['entry_date'] = $entry_date;
        $this->load->view("common/header");
        $this->load->view("consumption/view_details", $this->data);
        $this->load->view("common/footer");

    }

    public function customer()
    {

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');

        $this->data['customer'] = $this->consumption_model->get_allcustomer($branch_id);
        //echo $this->db->last_query();exit;
        $this->load->view("common/header");
        $this->load->view("consumption/view_customer", $this->data);
        $this->load->view("common/footer");

    }

    public function create_customer($id = null)
    {

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');

        $br = $this->consumption_model->get_pr($branch_id);
        $b_c = strtoupper($this->consumption_model->get_brcode($branch_id));

        $this->data['code'] = $code = $b_c . "PT" . $br;

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        //validate form input

        $this->form_validation->set_rules('name', "customer Name", 'required|xss_clean');
        $this->form_validation->set_rules('contact_no', "Contact No", 'required|xss_clean');
        $this->form_validation->set_rules('address', "Address", 'required|xss_clean');
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

            $exam_id = $this->consumption_model->create_customer($data);
            if ($exam_id) {

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/consumption/customer");

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

/*    print_r($this->data);
exit;
 */
            $this->load->view("common/header");
            $this->load->view("consumption/add_customer", $this->data);
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

        $this->form_validation->set_rules('name', "customer Name", 'required|xss_clean');
        $this->form_validation->set_rules('contact_no', "Contact No", 'required|xss_clean');
        $this->form_validation->set_rules('address', "Address", 'required|xss_clean');
        //$this->form_validation->set_rules('unpublish_date', "Unpublish Date", 'required|xss_clean');

        if ($this->form_validation->run() == true) {
            $data = array('name' => $this->input->post('name'),
                'address' => $this->input->post('address'),
                'contact_no' => $this->input->post('contact_no'),
                'remarks' => $this->input->post('remarks'),
            );

            $exam_id = $this->consumption_model->update_customer($id, $data);
            if ($exam_id) {

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/consumption/customer");

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
/*    print_r($this->data);
exit;
 */
            $this->data['customer'] = $this->consumption_model->edit_customer($id);
            $this->load->view("common/header");
            $this->load->view("consumption/edit_customer", $this->data);
            $this->load->view("common/footer");

        }

    }

    public function misc()
    {

        $this->data['consumption'] = array();
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->load->view("common/header");
        $this->load->view("consumption/misc", $this->data);
        $this->load->view("common/footer");
    }

    // other payment
    public function other()
    {

        $this->data['consumption'] = array();
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->load->view("common/header");
        $this->load->view("consumption/other", $this->data);
        $this->load->view("common/footer");
    }

    public function interview()
    {

        $this->data['consumption'] = array();
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->load->view("common/header");
        $this->load->view("consumption/interview", $this->data);
        $this->load->view("common/footer");
    }

// end of the other payment

    public function payment()
    {
        $sql = "SELECT count(id) AS cnt  FROM `student_payment`";
        $query = $this->db->query($sql);
        $row = $query->row_array();

        $rec_limit = 50;
        $rec_count = $row['cnt'];
        $num = $rec_count / 50;
        //echo $num;exit;
        $this->data['num'] = $num;

        $this->data['consumption'] = array();
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['report'] = $report = $this->consumption_model->view_payment();

        $this->load->view("common/header");
        $this->load->view("consumption/payment", $this->data);
        $this->load->view("common/footer");
    }

    public function more_payment()
    {

        $sql = "SELECT count(id) AS cnt  FROM `student_payment`";
        $query = $this->db->query($sql);
        $row = $query->row_array();

        $rec_limit = 50;
        $rec_count = $row['cnt'];

        $page = $_REQUEST['page'] + 1;
        $offset = $rec_limit * $page;
        $left_rec = $rec_count - ($page * $rec_limit);

        $this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
        $this->db->from('student_payment');
        $this->db->join('admission_form', 'student_payment.user_id = admission_form.username');
        $this->db->join('branch', 'student_payment.branch_id = branch.id');
        $this->db->join('origin_batch', 'admission_form.origin_batch_id = origin_batch.id');
        $this->db->order_by('student_payment.id', 'DESC');
        $this->db->limit($rec_limit, $offset);
        $query = $this->db->get();
        $consumption = $query->result_array();

        $num = $rec_count / 50;

        //$this->data['bottomslider'] = $bottomslider;

        $this->data['num'] = $num;
        $this->data['report'] = $consumption;
        $consumption_count = count($consumption);
        $this->data['consumption_count'] = $consumption_count;
        $this->data['page'] = $page;
        $this->data['prev'] = $page - 2;
        $this->data['next'] = $page;
        $this->load->view("consumption/more_payment", $this->data);

    }

    public function misc_report($start_date = null, $end_date = null)
    {

        if ($this->input->post('start_date') != '') {
            $this->data['start_date'] = $s_t = $this->input->post('start_date');
            $start_date = date('Y-m-d', strtotime($s_t));
        } else {
            $this->data['start_date'] = date('d-m-Y', strtotime($start_date));
        }

        if ($this->input->post('end_date') != '') {

            $this->data['end_date'] = $e_t = $this->input->post('end_date');
            $end_date = date('Y-m-d', strtotime($e_t));
        } else {
            $this->data['end_date'] = date('d-m-Y', strtotime($end_date));
        }

        $year_id = $this->data['year_id'];
        $this->data['report'] = $report = $this->consumption_model->get_misc($start_date, $end_date, $year_id);

        $this->data['otr_report'] = $report = $this->consumption_model->get_misc_otr($start_date, $end_date, $year_id);

        $this->load->view("common/header");
        $this->load->view("consumption/misc_report", $this->data);
        $this->load->view("common/footer");

    }

    public function mon_acc_report($start_date = null, $end_date = null)
    {

        $this->data['start_date'] = '';
        $this->data['end_date'] = '';
        $this->load->view("common/header");
        $this->load->view("consumption/mon_acc_report", $this->data);
        $this->load->view("common/footer");

    }

    public function view_mon_report()
    {
        $start_date = date('y-m-d', strtotime($this->input->post('start_date')));
        $end_date = date('y-m-d', strtotime($this->input->post('end_date')));
        $year_id = $this->data['year_id'];

        $this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
        $this->db->from('student_payment');
        $this->db->join('admission_form', 'student_payment.user_id = admission_form.username');
        $this->db->join('branch', 'student_payment.branch_id = branch.id');
        $this->db->join('origin_batch', 'admission_form.origin_batch_id = origin_batch.id');
        //$this->db->where( "`` = '$dt'");
        $this->db->where("student_payment.paid_date > '$start_date' AND student_payment.paid_date <= '$end_date' ");
        $this->db->where("student_payment.year_id", $year_id);
        $this->db->where("student_payment.oth_br", 0);
        $this->db->order_by('student_payment.id', 'DESC');
        $query = $this->db->get();
        $s_p = $query->result_array();
        //    echo $this->db->last_query();exit;

        $this->db->select('student_payment.*,student_payment.id as s_id,admission_form.*,branch.code as br_code,origin_batch.name as ob_name');
        $this->db->from('student_payment');
        $this->db->join('admission_form', 'student_payment.user_id = admission_form.username');
        $this->db->join('branch', 'student_payment.branch_id = branch.id');
        $this->db->join('origin_batch', 'admission_form.origin_batch_id = origin_batch.id');
        $this->db->where("student_payment.paid_date > '$start_date' AND student_payment.paid_date <= '$end_date' ");
        $this->db->where("student_payment.oth_br", 1);
        $this->db->order_by('student_payment.id', 'DESC');
        $query = $this->db->get();
        $o_p = $query->result_array();

        //print("<pre>");
        ////print_r($s_p);
        //print_r($o_p);
        //    exit;

        $this->data['report'] = $s_p;
        $this->data['otr_report'] = $o_p;
        //$this->data['dt']=$dt;
        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $this->load->view("common/header");
        $this->load->view("consumption/mon_report_all", $this->data);
        $this->load->view("common/footer");

    }

    public function view_month_allfilter($dt = null, $start_date = null, $end_date = null)
    {

        $start_date = date('Y-m-d', strtotime($_REQUEST['start_date']));
        $end_date = date('Y-m-d', strtotime($_REQUEST['end_date']));
        $this->data['filter'] = $filter = $_REQUEST['filter'];
        $year_id = $this->data['year_id'];
        //echo $filter;exit;
        if ($filter == "0") {
            $this->data['report'] = $report = $this->consumption_model->get_mon_misc_details($start_date, $end_date, $year_id);
        }
        if ($filter == "1") {
            $this->data['report'] = $report = $this->consumption_model->get_mon_miscadmin_details($start_date, $end_date, $year_id);

        }

        if ($filter == "2") {
            $this->data['report'] = $report = $this->consumption_model->get_mon_miscmon_details($start_date, $end_date, $year_id);

        }

        if ($filter == "3") {
            $this->data['report'] = $report = $this->consumption_model->get_mon_miscmisc_details($start_date, $end_date, $year_id);

        }

        if ($filter == "4") {
            $this->data['report'] = $report = $this->consumption_model->get_mon_misinter_details($start_date, $end_date, $year_id);

        }

        if ($filter == "7") {
            $this->data['report'] = $report = $this->consumption_model->get_monrejoin_other_details($start_date, $end_date, $year_id);

        }

        $this->data['otr_report'] = $report = $this->consumption_model->get_mon_misc_details_otr($start_date, $end_date, $year_id);

        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $this->load->view("common/header");
        $this->load->view("consumption/month_report_all_filter", $this->data);
        $this->load->view("common/footer");
    }

    public function other_report($start_date = null, $end_date = null)
    {

        if ($this->input->post('start_date') != '') {
            $this->data['start_date'] = $s_t = $this->input->post('start_date');
            $start_date = date('Y-m-d', strtotime($s_t));
        } else {
            $this->data['start_date'] = date('d-m-Y', strtotime($start_date));
        }

        if ($this->input->post('end_date') != '') {

            $this->data['end_date'] = $e_t = $this->input->post('end_date');
            $end_date = date('Y-m-d', strtotime($e_t));
        } else {
            $this->data['end_date'] = date('d-m-Y', strtotime($end_date));
        }

        $this->data['report'] = $report = $this->consumption_model->get_other($start_date, $end_date);

        $this->data['otr_report'] = $report = $this->consumption_model->get_other_otr($start_date, $end_date);

        $this->load->view("common/header");
        $this->load->view("consumption/other_report", $this->data);
        $this->load->view("common/footer");

    }

    public function interview_report($start_date = null, $end_date = null)
    {

        if ($this->input->post('start_date') != '') {
            $this->data['start_date'] = $s_t = $this->input->post('start_date');
            $start_date = date('Y-m-d', strtotime($s_t));
        } else {
            $this->data['start_date'] = date('d-m-Y', strtotime($start_date));
        }

        if ($this->input->post('end_date') != '') {

            $this->data['end_date'] = $e_t = $this->input->post('end_date');
            $end_date = date('Y-m-d', strtotime($e_t));
        } else {
            $this->data['end_date'] = date('d-m-Y', strtotime($end_date));
        }

        $this->data['report'] = $report = $this->consumption_model->get_interview($start_date, $end_date);
        $this->data['otr_report'] = $report = $this->consumption_model->get_interview_otr($start_date, $end_date);
        $this->load->view("common/header");
        $this->load->view("consumption/interview_report", $this->data);
        $this->load->view("common/footer");

    }

    public function misc_acc()
    {

        $this->data['consumption'] = array();
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->load->view("common/header");
        $this->load->view("consumption/misc_acc", $this->data);
        $this->load->view("common/footer");
    }

    public function view_all($dt = null, $start_date = null, $end_date = null)
    {
        //echo " amhere";exit;
        $dt = date('Y-m-d', strtotime($dt));
        $year_id = $this->data['year_id'];
        $this->data['report'] = $report = $this->consumption_model->get_misc_details($dt, $year_id);

        $this->data['otr_report'] = $report = $this->consumption_model->get_misc_details_otr($dt, $year_id);

        $this->data['dt'] = $dt;
        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $this->load->view("common/header");
        $this->load->view("consumption/misc_report_all", $this->data);
        $this->load->view("common/footer");
    }

    public function view_allfilter($dt = null, $start_date = null, $end_date = null)
    {

        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];
        $dt = $_REQUEST['dt'];
        $this->data['filter'] = $filter = $_REQUEST['filter'];
        $dt = date('Y-m-d', strtotime($dt));
        $year_id = $this->data['year_id'];
        //echo $filter;exit;
        if ($filter == "0") {
            $this->data['report'] = $report = $this->consumption_model->get_misc_details($dt, $year_id);
        }
        if ($filter == "1") {
            $this->data['report'] = $report = $this->consumption_model->get_miscadmin_details($dt, $year_id);

        }

        if ($filter == "2") {
            $this->data['report'] = $report = $this->consumption_model->get_miscmon_details($dt, $year_id);

        }

        if ($filter == "3") {
            $this->data['report'] = $report = $this->consumption_model->get_miscmisc_details($dt, $year_id);

        }

        if ($filter == "4") {
            $this->data['report'] = $report = $this->consumption_model->get_misinter_details($dt, $year_id);

        }

        if ($filter == "7") {
            $this->data['report'] = $report = $this->consumption_model->get_rejoinprice_details($dt, $year_id);

        }

        $this->data['otr_report'] = $report = $this->consumption_model->get_misc_details_otr($dt, $year_id);

        $this->data['dt'] = $dt;
        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $this->load->view("common/header");
        $this->load->view("consumption/misc_report_all_filter", $this->data);
        $this->load->view("common/footer");
    }

    public function view_other($dt = null, $start_date = null, $end_date = null)
    {
        $dt = date('Y-m-d', strtotime($dt));
        $this->data['report'] = $report = $this->consumption_model->get_other_details($dt);
//echo $this->db->last_query();exit;
        //    print("<pre>");
        //    print_r($this->data['report']);
        //exit;

        $this->data['otr_report'] = $report = $this->consumption_model->get_other_details_otr($dt);

        $this->data['dt'] = $dt;
        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $this->load->view("common/header");
        $this->load->view("consumption/other_report_all", $this->data);
        $this->load->view("common/footer");
    }

    public function view_interview($dt = null, $start_date = null, $end_date = null)
    {
        $dt = date('Y-m-d', strtotime($dt));
        $this->data['report'] = $report = $this->consumption_model->get_interview_details($dt);
//echo $this->db->last_query();exit;
        //    print("<pre>");
        //    print_r($this->data['report']);
        //exit;

        $this->data['otr_report'] = $report = $this->consumption_model->get_interview_details_otr($dt);

        $this->data['dt'] = $dt;
        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $this->load->view("common/header");
        $this->load->view("consumption/other_interview_all", $this->data);
        $this->load->view("common/footer");
    }

    public function misc_acreport($start_date = null, $end_date = null)
    {

        if ($this->input->post('start_date') != '') {
            $this->data['start_date'] = $s_t = $this->input->post('start_date');
            $start_date = date('Y-m-d', strtotime($s_t));
        } else {
            $this->data['start_date'] = date('d-m-Y', strtotime($start_date));
        }

        if ($this->input->post('end_date') != '') {

            $this->data['end_date'] = $e_t = $this->input->post('end_date');
            $end_date = date('Y-m-d', strtotime($e_t));
        } else {
            $this->data['end_date'] = date('d-m-Y', strtotime($end_date));
        }
        $year_id = $this->data['year_id'];
        $this->data['report'] = $report = $this->consumption_model->get_accmisc($start_date, $end_date, $year_id);

        $this->load->view("common/header");
        $this->load->view("consumption/misc_accreport", $this->data);
        $this->load->view("common/footer");
    }

    public function view_all_acc($dt = null, $start_date = null, $end_date = null)
    {
        $year_id = $this->data['year_id'];
        $dt = date('Y-m-d', strtotime($dt));
        $this->data['report'] = $report = $this->consumption_model->get_misc_accdetails($dt, $year_id);
        $this->data['student_report'] = $report = $this->consumption_model->get_misc_details($dt, $year_id);
        //echo $this->db->last_query();exit;
        $this->data['dt'] = $dt;
        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $this->load->view("common/header");
        $this->load->view("consumption/misc_accreport_all", $this->data);
        $this->load->view("common/footer");
    }

    public function receipt($id)
    {
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $receipt = $this->consumption_model->get_receipt($id);

        $this->data['report'] = $receipt;

        $this->load->view("common/header");
        $this->load->view("consumption/receipt", $this->data);
        $this->load->view("common/footer");
    }

    public function update_misc()
    {
        $cond['id'] = $_REQUEST['id'];
        $data['amt_paid'] = $_REQUEST['amt_paid'];
        $res = $this->db->update("student_payment", $data, $cond);
        if ($res) {
            echo 1;exit;
        } else {

            echo 0;exit;
        }

    }

    public function finance()
    {
        $this->data['start_date'] = '';
        $this->data['end_date'] = '';
        $this->data['all_cust'] = array();

        $this->data['consumption'] = array();
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->load->view("common/header");
        $this->load->view("consumption/finance", $this->data);
        $this->load->view("common/footer");
    }

    public function get_all()
    {

        $this->data['start_date'] = $this->input->post('start_date');
        $this->data['end_date'] = $this->input->post('end_date');

        $start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
        $end_date = date('Y-m-d', strtotime($this->input->post('end_date')));

        $all_report = array();

        $sql = "SELECT SUM(amt_paid) as amt_paid FROM `student_payment` WHERE entry_date >= '$start_date' AND entry_date <= '$end_date'";
        $res = $this->db->query($sql);
        $data = $res->row_array();
        $all_report['customer_name'] = "STUDENT";
        $all_report['credit'] = $data['amt_paid'];

        $sql1 = "SELECT SUM(refund_amt) as amt_fer FROM `refund` WHERE refund_date >= '$start_date' AND refund_date <= '$end_date'";
        $res1 = $this->db->query($sql1);
        $data1 = $res1->row_array();

        $all_report['debit'] = $data1['amt_fer'];

        $p_sql = "SELECT DISTINCT(customer_name) as code,customer.name as customer_name FROM `consumption`,`customer` WHERE consumption.customer_name=customer.code";
        $p_res = $this->db->query($p_sql);
        $p_data = $p_res->result_array();

        $all_cust = array();
        foreach ($p_data as $cust) {
            $id = $cust['code'];
            $sql2 = "SELECT SUM(amount) as credit,customer_name FROM `consumption` WHERE entry_date >= '$start_date' AND entry_date <= '$end_date' AND type=1 AND customer_name='$id'";
            $res2 = $this->db->query($sql2);
            $data2 = $res2->row_array();
            $cust['credit'] = $data2['credit'];

            $sql3 = "SELECT SUM(amount) as debit,customer_name FROM `consumption` WHERE entry_date >= '$start_date' AND entry_date <= '$end_date' AND type=2 AND customer_name='$id'";
            $res3 = $this->db->query($sql3);
            $data3 = $res3->row_array();
            $cust['debit'] = $data3['debit'];
            $all_cust[] = $cust;
        }

        $all_cust[] = $all_report;

        $this->data['all_cust'] = $all_cust;

        $this->load->view("common/header");
        $this->load->view("consumption/finance", $this->data);
        $this->load->view("common/footer");
    }

}
