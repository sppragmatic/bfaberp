<?php defined('BASEPATH') or exit('No direct script access allowed');

class Gst extends CI_Controller
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
     * GST model
     *
     * @var object
     */
    public $gst_model;

    /**
     * Production model
     *
     * @var object
     */
    public $production_model;

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
        $this->load->model('gst_model');
        $this->load->model('admin/production_model');
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

        $this->db->select("*");
        $this->db->from("gst");
        $this->db->where($cond);
        $sales = $this->db->get()->row_array();

        $sales_ac['invid'] = $sales['sl_no'];
        $salesac_up['trash'] = 1;
        $salesac_up['status'] = 1;
        $this->db->update('gst_account', $salesac_up, $sales_ac);
//$salesitem_ac[''] = $sales['id'];
        //$saleitem_up['trash'] = 1;
        $this->db->update('sales', $data, $cond);
        redirect('admin/sales');

    }

    public function delete_customer($id)
    {
        $cond['customer_id'] = $id;
        $cond1['id'] = $id;
        $this->db->select("*");
        $this->db->from("gst");
        $this->db->where($cond);
        $sales = $this->db->get()->num_rows();
        if ($sales > 0) {

            $this->session->set_userdata('del_message', "Sales Exist With This Customer!");
        } else {

            $this->db->delete("customer", $cond1);
            $branch_id = $this->session->userdata('branch_id');
            $this->session->set_userdata('del_message', "Customer Deleted!");
        }
        redirect('admin/gst/customer/1');
    }

    public function delete_payment($id = null)
    {
        $cond['id'] = $id;
        $data['status'] = 1;
        $this->db->update('gst_account', $data, $cond);
        redirect('admin/gst/view_payment');

    }

    public function chalan($id)
    {
        $this->data['sales'] = $sales = $this->gst_model->print_sales($id);
        $this->data['products'] = $items = $this->gst_model->get_proditem($id);

        //print('<pre>');
        //print_r($this->data);
        //exit;

        //$this->data['report']=$receipt;

        $this->load->view("common/header");
        $this->load->view("gst/gstchallan", $this->data);
        $this->load->view("common/footer");
    }

    public function approve($id = null)
    {
        //    $this->data['production'] = $this->production_model->get_production($id);
        //$this->data['products']= $items  = $this->production_model->get_approvitem($id);

        $this->data['sales'] = $sales = $this->gst_model->edit_sales($id);
        $this->data['products'] = $items = $this->gst_model->get_proditem($id);

        //exit;
        $production['status'] = 1;
        $productioncond['id'] = $id;
        $this->db->update("gst", $production, $productioncond);
        redirect('admin/gst/admin_sales');
    }

    //redirect if needed, otherwise display the user list

    public function index($id = null)
    {
        //echo "i amhee";exit;
        $this->data['customer'] = $this->gst_model->get_customer();
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['products'] = $this->production_model->get_product();

        $br = $this->gst_model->get_br($branch_id);
        $b_c = strtoupper($this->gst_model->get_brcode($branch_id));

        $this->data['trans_no'] = $trans_no = "BFAB" . "SL" . $br;

        $sql = "SELECT COUNT(id) AS c_id FROM gst_account WHERE branch_id={$branch_id}";
        $res = $this->db->query($sql);
        $count = $res->row_array();
        $inv = $count['c_id'] + 1;
        $invno = "BFAB" . "INV" . $inv;

        $this->data['trans_no'] = $invno;
        //echo $invno;exit;

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        //validate form input

        //$this->form_validation->set_rules('customer_name', "customer Name", 'required');

        $this->form_validation->set_rules('payment_status', "Payment Status", 'required');
        $this->form_validation->set_rules('vehicle_number', "VEHICLE Number", 'required');
        $this->form_validation->set_rules('vehicle_owner', "VEHICLE OWNER", 'required');
        $this->form_validation->set_rules('address', "Address", 'required');
        $this->form_validation->set_rules('bill_date', "Entry Date", 'required');
        $this->form_validation->set_rules('gst_no', "GST No", 'required');

        //$this->form_validation->set_rules('remarks', "Remakrs", 'required');
        //$this->form_validation->set_rules('unpublish_date', "Unpublish Date", 'required');

        if ($this->form_validation->run() == true) {

            //    print('<pre>');
            //    print_r($_REQUEST);
            //    exit;
            $amount = $this->input->post('amount');
            $toamount = 0;
            foreach ($amount as $ky => $va) {
                $toamount = $toamount + intval($va);
            }

            $data = array('sl_no' => $this->input->post('sl_no'),
                'vehicle_owner' => $this->input->post('vehicle_owner'),
                'address' => $this->input->post('address'),
                'paiddetails' => $this->input->post('paiddetails'),
                'paid_amount' => $this->input->post('paid_amount'),
                'payment_status' => $this->input->post('payment_status'),
                'bill_date' => date('Y-m-d', strtotime($this->input->post('bill_date'))),
                //'total_amount'=>  $this->input->post('total_amount'),
                'vehicle_number' => $this->input->post('vehicle_number'),
                'branch_id' => $branch_id,
                'gst_no' => $this->input->post('gst_no'),
                'total_amount' => $toamount,
            );

            if ($this->input->post('type')) {
                $data['type'] = $this->input->post('type');
            } else {
                $data['type'] = 0;
            }

            $customer_name = $this->input->post('customer_name');
            $customer_id = $this->input->post('customer_id');
            $prod = $this->input->post('prod');
            $amount = $this->input->post('amount');
            if ($customer_id == null) {
                $cusdata['name'] = $customer_name;
                $this->db->insert('customer', $cusdata);
                $customer_id = $this->db->insert_id();
                $data['customer_id'] = $customer_id;
            } else {
                $data['customer_id'] = $customer_id;
            }

            $exam_id = $this->gst_model->create_sales($data);
            if ($exam_id) {

                $payment_status = $this->input->post('payment_status');
                $accdata = array('invid' => $this->input->post('sl_no'),
                    'invno' => $invno,
                    'customer_id' => $customer_id,
                    'details' => $this->input->post('paiddetails'),
                    'credit' => $toamount,
                    'entry_date' => date('Y-m-d', strtotime($this->input->post('bill_date'))),
                    'entry_by' => $entry_by,
                    'branch_id' => $branch_id,
                    'year_id' => $this->data['year_id'],
                );

                if ($payment_status == 1) {
                    $accdata['debit'] = $this->input->post('paid_amount');
                    $accdata['type'] = $this->input->post('type');
                } else {
                    $accdata['debit'] = 0;
                    $accdata['type'] = 0;
                }

                $this->db->insert("gst_account", $accdata);

                foreach ($prod as $key => $val) {
                    $insitem['product_id'] = $key;
                    $insitem['amount'] = $amount[$key];
                    $insitem['stock'] = $val;
                    $insitem['branch_id'] = $branch_id;
                    $insitem['sales_id'] = $exam_id;
                    //print_r($insitem);
                    $this->db->insert('gst_item', $insitem);
                }

                $this->session->set_flashdata('message', $this->ion_auth->messages());

                if ($this->ion_auth->is_admin()) {
                    redirect("admin/gst/view_adminsales");
                } else {
                    redirect("admin/gst/view_sales");
                }
                //    redirect("admin/gst/view_sales");

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
exit;$this->data['customer'] = $this->gst_model->get_customer($branch_id);
 */

//print("<pre>");

            $this->load->view("common/header");
            $this->load->view("gst/add", $this->data);
            $this->load->view("common/footer");

        }

    }

    public function edit_sales($id = null)
    {
        $this->data['sales'] = $sales = $this->gst_model->edit_sales($id);
        $this->data['products'] = $this->gst_model->get_proditem($id);

        //print('<pre>');
        //print_r($this->data['sales']);
        //exit;

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->gst_model->get_customer($branch_id);

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        //validate form input
        $this->form_validation->set_rules('payment_status', "Payment Status", 'required');
        $this->form_validation->set_rules('vehicle_number', "VEHICLE Number", 'required');
        $this->form_validation->set_rules('vehicle_owner', "VEHICLE OWNER", 'required');
        $this->form_validation->set_rules('address', "Address", 'required');
        $this->form_validation->set_rules('bill_date', "Entry Date", 'required');
        $this->form_validation->set_rules('gst_no', "GST No", 'required');

        //$this->form_validation->set_rules('unpublish_date', "Unpublish Date", 'required');

        if ($this->form_validation->run() == true) {

            $amount = $this->input->post('amount');
            $toamount = 0;
            foreach ($amount as $ky => $va) {
                $toamount = $toamount + intval($va);
            }

            $data = array('sl_no' => $this->input->post('sl_no'),
                'vehicle_owner' => $this->input->post('vehicle_owner'),
                'address' => $this->input->post('address'),
                'paiddetails' => $this->input->post('paiddetails'),
                'payment_status' => $this->input->post('payment_status'),
                'bill_date' => date('Y-m-d', strtotime($this->input->post('bill_date'))),
                //'total_amount'=>  $this->input->post('total_amount'),
                'vehicle_number' => $this->input->post('vehicle_number'),
                'customer_id' => $this->input->post('customer_id'),
                'gst_no' => $this->input->post('gst_no'),
                //'type'=>   $this->input->post('type'),
                'branch_id' => $branch_id,
                'total_amount' => $toamount,
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

//print_r($data);
            //exit;

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
            $this->db->update("gst_account", $accdata, $acccond);

            $prod = $this->input->post('prod');

            $uc['id'] = $id;

            $update = $this->db->update('gst', $data, $uc);
//echo $this->db->last_query();exit;

            foreach ($prod as $key => $val) {
                $upcond['id'] = $key;
                $upitem['amount'] = $amount[$key];
                $upitem['stock'] = $val;
                //$insitem['production_id'] =$insert;
                $this->db->update('gst_item', $upitem, $upcond);
            }

            if ($update) {

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                if ($this->ion_auth->is_admin()) {
                    redirect("admin/gst/view_adminsales");
                } else {
                    redirect("admin/gst/view_sales");
                }

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

            if ($this->input->post('gst_no') != null) {
                $this->data['gst_no'] = $this->input->post('gst_no');
            } else {
                $this->data['gst_no'] = '';
            }

            //'gst_no'=>  $gst_no,

            $this->session->set_flashdata('msg', 'Create Payment');

/*    print_r($this->data);
exit;
 */
            $this->load->view("common/header");
            $this->load->view("gst/edit", $this->data);
            $this->load->view("common/footer");

        }

    }

// start of the payemnet

    public function add_payment($id = null)
    {
        //echo "i amhee";exit;
        $this->data['customer'] = $this->gst_model->get_customer();
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['products'] = $this->production_model->get_product();

        $br = $this->gst_model->get_br($branch_id);
        $b_c = strtoupper($this->gst_model->get_brcode($branch_id));

        $sql = "SELECT COUNT(id) AS c_id FROM gst_account WHERE branch_id={$branch_id}";
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

        //$this->form_validation->set_rules('customer_name', "customer Name", 'required');

        $this->form_validation->set_rules('customer_id', "Customer Name", 'required');
        $this->form_validation->set_rules('debit', "Amount", 'required');
        $this->form_validation->set_rules('entry_date', "Payment Date", 'required');
        $this->form_validation->set_rules('details', "Details", 'required');

        //$this->form_validation->set_rules('remarks', "Remakrs", 'required');
        //$this->form_validation->set_rules('unpublish_date', "Unpublish Date", 'required');

        if ($this->form_validation->run() == true) {
            $data = array('invid' => 0,
                'invno' => $invno,
                'customer_id' => $this->input->post('customer_id'),
                'entry_date' => date("Y-m-d", strtotime($this->input->post('entry_date'))),
                'debit' => $this->input->post('debit'),
                'details' => $this->input->post('details'),
                'branch_id' => $this->session->userdata('branch_id'),
                'entry_by' => $this->session->userdata('identity'),
            );

            $exam_id = $this->gst_model->create_payment($data);
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
            exit;$this->data['customer'] = $this->gst_model->get_customer($branch_id);
             */

            $this->load->view("common/header");
            $this->load->view("gst/add_payment", $this->data);
            $this->load->view("common/footer");

        }

    }

    public function edit_payment($id = null)
    {
        $this->data['sales'] = $payment = $this->gst_model->edit_payment($id);

//print("<pre>");
        //print_r($payment);
        //exit;

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->gst_model->get_customer($branch_id);

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        //validate form input
        $this->form_validation->set_rules('customer_id', "Customer Name", 'required');
        $this->form_validation->set_rules('debit', "Amount", 'required');
        $this->form_validation->set_rules('entry_date', "Payment Date", 'required');
        $this->form_validation->set_rules('details', "Details", 'required');

        //$this->form_validation->set_rules('unpublish_date', "Unpublish Date", 'required');
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
            $update = $this->db->update('gst_account', $data, $uc);

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
            $this->load->view("gst/edit_payment", $this->data);
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
        $this->data['customer'] = $this->gst_model->get_customer($branch_id);
        $this->data['sales'] = $sales = $this->gst_model->get_allpayments($branch_id);

        $this->load->view("common/header");
        $this->load->view("gst/view_payment", $this->data);
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
        $this->data['customer'] = $this->gst_model->get_customer($branch_id);

        $this->db->select('gst_account.*,customer.name as customername');
        $this->db->from('gst_account');
        $this->db->join('customer', 'gst_account.customer_id=customer.id');
        $this->db->where('gst_account.branch_id', $branch_id);

        if ($start_date != '' && $end_date != '') {

            $st = date('Y-m-d', strtotime($start_date));
            $et = date('Y-m-d', strtotime($end_date));
            $this->db->where("gst_account.entry_date >= '$st' AND gst_account.entry_date <= '$et' ");
            $cond = array();
            if ($customer_id != 0) {
                $cond['gst_account.customer_id'] = $customer_id;
            }
            $this->db->where($cond);

        } else {
            //echo "i will stop here".$customer_id;exit;
            $cond = array();
            if ($customer_id != 0) {
                $cond['gst_account.customer_id'] = $customer_id;
            }
            $this->db->where($cond);

        }
        //$this->db->limit('50');
        $this->db->order_by('sales.bill_date', "DESC");
        $query = $this->db->get();
        $this->data['sales'] = $sales = $query->result_array();

        //$this->gst_model->get_allpayments($branch_id);

        $this->load->view("common/header");
        $this->load->view("gst/view_payment", $this->data);
        $this->load->view("common/footer");

    }

    /// end of the payment

    public function admin_sales($id = null)
    {
        $this->data['branch'] = $this->gst_model->get_branch();
        $this->data['customer_id'] = '';
        $this->data['branch_id'] = '';
        //    $this->data['material_id'] = $material_id = $this->input->post('material_id');
        $this->data['start_date'] = '';
        $this->data['end_date'] = '';

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->gst_model->get_customer($branch_id);

        $this->db->select("*");
        $this->db->from("gst");
        $this->db->where("branch_id", $branch_id);
        $num = $this->db->get()->num_rows();

        $this->load->library('pagination');
        $config['base_url'] = site_url('admin/gst/admin_sales');
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
//echo "sdsd";exit;
        $this->data['sales'] = $sales = $this->gst_model->admin_allsales($id, $branch_id);

        //$this->data['sales']= $sales = $this->gst_model->admin_allsales($branch_id);

        $this->data['products'] = $this->production_model->get_product();
        $allsales = array();
        foreach ($sales as $prod) {
            $sales_id = $prod['id'];
            $prod['allitem'] = $productitems = $this->gst_model->get_proditem($sales_id);
            $allsales[] = $prod;
        }
        $this->data['sales'] = $allsales;

        //print('<pre>');
        //print_r($this->data['sales']);
        //exit;

        $this->load->view("common/header");
        $this->load->view("gst/admin_sales", $this->data);
        $this->load->view("common/footer");

    }

    public function admsearch_sales()
    {

        $this->data['branch'] = $this->gst_model->get_branch();
        $this->data['customer_id'] = $customer_id = $this->input->post('customer_id');
//echo $customer_id;exit;
        $this->data['branch_id'] = $this->input->post('branch_id');
        //    $this->data['material_id'] = $material_id = $this->input->post('material_id');
        $this->data['start_date'] = $start_date = $this->input->post('start_date');
        $this->data['end_date'] = $end_date = $this->input->post('end_date');

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->gst_model->get_customer($branch_id);

        $this->data['sales'] = $sales = $this->gst_model->get_allsales($branch_id);

        $this->data['products'] = $this->production_model->get_product();
//$year_id = $this->get_fyr();
        $this->db->select('sales.*,customer.name as customername');
        $this->db->from('sales');
        $this->db->join('customer', 'sales.customer_id=customer.id');
//$this->db->where('year_id',$year_id);
        //$this->db->where('sales.branch_id',$branch_id);
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
            //echo "i will stop here".$customer_id;exit;
            $cond = array();
//echo $customer_id;exit;
            if ($customer_id != 0) {
                $cond['sales.customer_id'] = $customer_id;
            }

            if ($branch_id != 0) {
                $cond['sales.branch_id'] = $branch_id;
            }
            $this->db->where($cond);

//print("<pre>");
            //print_r($cond);
            //exit;

        }

//$this->db->limit('50');
        $this->db->order_by('sales.bill_date', "DESC");
//$this->db->order_by('sales.bill_date',"DESC");
        $query = $this->db->get();
        $sales = $query->result_array();
//print_r($sales);
        //exit;
        //echo $this->db->last_query();exit;

        $allsales = array();
        foreach ($sales as $prod) {
            $sales_id = $prod['id'];
            $prod['allitem'] = $productitems = $this->gst_model->get_proditem($sales_id);
            $allsales[] = $prod;
        }
        $this->data['sales'] = $allsales;

        //print('<pre>');
        //print_r($this->data['sales']);
        //exit;

        $this->load->view("common/header");
        $this->load->view("gst/admin_sales", $this->data);
        $this->load->view("common/footer");

    }

    public function view_adminsales($id = null)
    {

        $this->data['customer_id'] = '';
        //    $this->data['material_id'] = $material_id = $this->input->post('material_id');
        $this->data['start_date'] = '';
        $this->data['end_date'] = '';

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->gst_model->get_customer($branch_id);

        //$this->data['sales']= $sales = $this->gst_model->get_allsales($id,$branch_id);

        $this->db->select("*");
        $this->db->from("gst");
        $this->db->where("branch_id", $branch_id);
        $num = $this->db->get()->num_rows();

        $this->load->library('pagination');
        $config['base_url'] = site_url('admin/gst/view_sales');
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
//echo "sdsd";exit;
        $this->data['sales'] = $sales = $this->gst_model->get_allsalespage($id, $branch_id);

        $allsales = array();
        foreach ($sales as $prod) {
            $sales_id = $prod['id'];
            $prod['allitem'] = $productitems = $this->gst_model->get_proditem($sales_id);
            $allsales[] = $prod;
        }
        $this->data['sales'] = $allsales;

        //print('<pre>');
        //print_r($this->data['sales']);
        //exit;

        $this->load->view("common/header");
        $this->load->view("gst/view_adminsales", $this->data);
        $this->load->view("common/footer");

    }

    public function search_adminsales()
    {

        $this->data['customer_id'] = $customer_id = $this->input->post('customer_id');
        //    $this->data['material_id'] = $material_id = $this->input->post('material_id');
        $this->data['start_date'] = $start_date = $this->input->post('start_date');
        $this->data['end_date'] = $end_date = $this->input->post('end_date');

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->gst_model->get_customer($branch_id);

        $this->data['sales'] = $sales = $this->gst_model->get_allsales($branch_id);

        $this->data['products'] = $this->production_model->get_product();
        //$year_id = $this->get_fyr();
        $this->db->select('sales.*,customer.name as customername');
        $this->db->from('sales');
        $this->db->join('customer', 'sales.customer_id=customer.id');
        //$this->db->where('year_id',$year_id);
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
            //echo "i will stop here".$customer_id;exit;
            $cond = array();
            if ($customer_id != 0) {
                $cond['sales.customer_id'] = $customer_id;
            }
            $this->db->where($cond);

        }

        //$this->db->limit('50');
        $this->db->order_by('sales.bill_date', "DESC");
        //$this->db->order_by('sales.bill_date',"DESC");
        $query = $this->db->get();
        $sales = $query->result_array();
//print_r($sales);
        //exit;

        $allsales = array();
        foreach ($sales as $prod) {
            $sales_id = $prod['id'];
            $prod['allitem'] = $productitems = $this->gst_model->get_proditem($sales_id);
            $allsales[] = $prod;
        }
        $this->data['sales'] = $allsales;

        //print('<pre>');
        //print_r($this->data['sales']);
        //exit;

        $this->load->view("common/header");
        $this->load->view("gst/view_adminsales", $this->data);
        $this->load->view("common/footer");

    }

    public function view_sales($id = null)
    {

        $this->data['customer_id'] = '';
        //    $this->data['material_id'] = $material_id = $this->input->post('material_id');
        $this->data['start_date'] = '';
        $this->data['end_date'] = '';

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->gst_model->get_customer($branch_id);

        //$this->data['sales']= $sales = $this->gst_model->get_allsales($id,$branch_id);

        $this->db->select("*");
        $this->db->from("gst");
        $this->db->where("branch_id", $branch_id);
        $num = $this->db->get()->num_rows();

        $this->load->library('pagination');
        $config['base_url'] = site_url('admin/gst/view_sales');
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
//echo "sdsd";exit;
        $this->data['sales'] = $sales = $this->gst_model->get_allsalespage($id, $branch_id);

        $allsales = array();
        foreach ($sales as $prod) {
            $sales_id = $prod['id'];
            $prod['allitem'] = $productitems = $this->gst_model->get_proditem($sales_id);
            $allsales[] = $prod;
        }
        $this->data['sales'] = $allsales;

        //print('<pre>');
        //print_r($this->data['sales']);
        //exit;

        $this->load->view("common/header");
        if ($this->ion_auth->is_admin()) {
            $this->load->view("gst/view_adminsales", $this->data);
        } else {
            $this->load->view("gst/view_sales", $this->data);
        }

        $this->load->view("common/footer");

    }

    public function search_sales()
    {

        $this->data['customer_id'] = $customer_id = $this->input->post('customer_id');
        //    $this->data['material_id'] = $material_id = $this->input->post('material_id');
        $this->data['start_date'] = $start_date = $this->input->post('start_date');
        $this->data['end_date'] = $end_date = $this->input->post('end_date');

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->data['customer'] = $this->gst_model->get_customer($branch_id);

        $this->data['sales'] = $sales = $this->gst_model->get_allsales($branch_id);

        $this->data['products'] = $this->production_model->get_product();
        //$year_id = $this->get_fyr();
        $this->db->select('sales.*,customer.name as customername');
        $this->db->from('sales');
        $this->db->join('customer', 'sales.customer_id=customer.id');
        //$this->db->where('year_id',$year_id);
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
            //echo "i will stop here".$customer_id;exit;
            $cond = array();
            if ($customer_id != 0) {
                $cond['sales.customer_id'] = $customer_id;
            }
            $this->db->where($cond);

        }

        //$this->db->limit('50');
        $this->db->order_by('sales.bill_date', "DESC");
        //$this->db->order_by('sales.bill_date',"DESC");
        $query = $this->db->get();
        $sales = $query->result_array();
//print_r($sales);
        //exit;

        $allsales = array();
        foreach ($sales as $prod) {
            $sales_id = $prod['id'];
            $prod['allitem'] = $productitems = $this->gst_model->get_proditem($sales_id);
            $allsales[] = $prod;
        }
        $this->data['sales'] = $allsales;

        //print('<pre>');
        //print_r($this->data['sales']);
        //exit;

        $this->load->view("common/header");
        $this->load->view("gst/view_sales", $this->data);
        $this->load->view("common/footer");

    }

    public function view_customer_sales_details($p_c)
    {

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');

        $sales = $this->gst_model->get_uncustomersales($p_c);

        $len = count($sales);

        $this->data['code'] = $p_c;
        $this->data['sales'] = $sales;
        $this->data['customer'] = $this->gst_model->get_customer($branch_id);

        $this->load->view("common/header");
        $this->load->view("gst/un_report", $this->data);
        $this->load->view("common/footer");

    }

    public function report44()
    {

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');

        $sales = $this->gst_model->get_allcustomersales($branch_id);

        $len = count($sales);

        $this->data['sales'] = $sales;
        $this->data['customer'] = $this->gst_model->get_customer($branch_id);

        $this->load->view("common/header");
        $this->load->view("gst/report", $this->data);
        $this->load->view("common/footer");
    }

    

    /// start fo th code for report
    public function summery()
    {
        //echo "ia mhere";exit;
        $this->data['customer'] = $this->gst_model->get_customer();
        $this->data['branch'] = $this->gst_model->get_branch();
        $this->load->view("common/header");
        $this->load->view("gst/summery", $this->data);
        $this->load->view("common/footer");
    }

    public function credit()
    {

        //echo "ia mhere";exit;
        $customer = $this->gst_model->get_customer();
        $all_cust = array();
        foreach ($customer as $cust) {
            $id = $cust['id'];
            $this->db->select('SUM(credit) as to_credit,SUM(debit) as to_debit');
            $this->db->from('gst_account');
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
        $this->load->view("gst/credit", $this->data);
        $this->load->view("common/footer");
    }

    public function getsummery()
    {

        $this->data['customer'] = $this->gst_model->get_customer();
        $this->data['branch'] = $this->gst_model->get_branch();

        $this->data['customer_id'] = $customer_id = $this->input->post('customer_id');
        $this->data['branch_id'] = $branch_id = $this->input->post('branch_id');
        //    $this->data['material_id'] = $material_id = $this->input->post('material_id');
        $this->data['start_date'] = $start_date = $this->input->post('start_date');
        $this->data['end_date'] = $end_date = $this->input->post('end_date');

        //$year_id = $this->get_fyr();
        $this->db->select('gst_account.*,customer.name as customername');
        $this->db->from('gst_account');
        $this->db->join('customer', 'gst_account.customer_id=customer.id');
        //$this->db->where('year_id',$year_id);
        $this->db->where('gst_account.trash', 0);
        //$this->db->where('sales.branch_id',$branch_id);
        if ($start_date != '' && $end_date != '') {

            $st = date('Y-m-d', strtotime($start_date));
            $et = date('Y-m-d', strtotime($end_date));
            $this->db->where("gst_account.entry_date >= '$st' AND gst_account.entry_date <= '$et' ");
            $cond = array();
            if ($customer_id != 0) {
                $cond['gst_account.customer_id'] = $customer_id;
            }

            if ($branch_id != 0) {
                $cond['gst_account.branch_id'] = $branch_id;
            }
            $this->db->where($cond);

        } else {
            //echo "i will stop here".$customer_id;exit;
            $cond = array();
            if ($customer_id != 0) {
                $cond['gst_account.customer_id'] = $customer_id;
            }

            if ($branch_id != 0) {
                $cond['gst_account.branch_id'] = $branch_id;
            }
            $this->db->where($cond);

        }
        $this->db->order_by('gst_account.entry_date', "DESC");
        $alsales = $this->db->get()->result_array();
        $this->data['sales'] = $alsales;

        //print("<pre>");
        //print_r($alsales);
        //exit;

        $this->load->view("common/header");
        $this->load->view("gst/admin_summery", $this->data);
        $this->load->view("common/footer");

    }

    //// end of the code for report

/// start fo th code for report
    public function report()
    {
        //echo "ia mhere";exit;
        $this->data['customer'] = $this->gst_model->get_customer();
        $this->data['branch'] = $this->gst_model->get_branch();
        $this->load->view("common/header");
        $this->load->view("gst/report", $this->data);
        $this->load->view("common/footer");
    }

    public function getreport()
    {

        $this->data['customer'] = $this->gst_model->get_customer();
        $this->data['branch'] = $this->gst_model->get_branch();

        $this->data['customer_id'] = $customer_id = $this->input->post('customer_id');
        $this->data['branch_id'] = $branch_id = $this->input->post('branch_id');
        //    $this->data['material_id'] = $material_id = $this->input->post('material_id');
        $this->data['start_date'] = $start_date = $this->input->post('start_date');
        $this->data['end_date'] = $end_date = $this->input->post('end_date');

//$year_id = $this->get_fyr();
        $this->db->select('gst_account.*,customer.name as customername');
        $this->db->from('gst_account');
        $this->db->join('customer', 'gst_account.customer_id=customer.id');
//$this->db->where('year_id',$year_id);
        //$this->db->where('sales.branch_id',$branch_id);
        if ($start_date != '' && $end_date != '') {

            $st = date('Y-m-d', strtotime($start_date));
            $et = date('Y-m-d', strtotime($end_date));
            $this->db->where("gst_account.entry_date >= '$st' AND gst_account.entry_date <= '$et' ");
            $cond = array();
            if ($customer_id != 0) {
                $cond['gst_account.customer_id'] = $customer_id;
            }

            if ($branch_id != 0) {
                $cond['gst_account.branch_id'] = $branch_id;
            }
            $this->db->where($cond);

        } else {
            //echo "i will stop here".$customer_id;exit;
            $cond = array();
            if ($customer_id != 0) {
                $cond['gst_account.customer_id'] = $customer_id;
            }

            if ($branch_id != 0) {
                $cond['gst_account.branch_id'] = $branch_id;
            }
            $this->db->where($cond);

        }
        $alsales = $this->db->get()->result_array();
        $this->data['sales'] = $alsales;

//print("<pre>");
        //print_r($alsales);
        //exit;

        $this->load->view("common/header");
        $this->load->view("gst/admin_report", $this->data);
        $this->load->view("common/footer");

    }

//// end of the code for report

    public function view_details($entry_date = null)
    {

        $branch_id = 1;
        $this->data['sales'] = $this->gst_model->view_details($entry_date);
        $this->data['entry_date'] = $entry_date;
        $this->load->view("common/header");
        $this->load->view("gst/view_details", $this->data);
        $this->load->view("common/footer");

    }

    public function customer($msg = null)
    {

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');

        $this->data['customer'] = $this->gst_model->get_allcustomer($branch_id);
        //echo $this->db->last_query();exit;
        $this->load->view("common/header");
        $this->load->view("gst/view_customer", $this->data);
        $this->load->view("common/footer");

    }

    public function create_customer($id = null)
    {

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');

        $br = $this->gst_model->get_pr($branch_id);
        $b_c = strtoupper($this->gst_model->get_brcode($branch_id));

        $this->data['code'] = $code = $b_c . "PT" . $br;

        $this->data['title'] = "Create Exam";
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        //validate form input

        $this->form_validation->set_rules('name', "customer Name", 'required');
        $this->form_validation->set_rules('contact_no', "Contact No", 'required');
        $this->form_validation->set_rules('address', "Address", 'required');
        //$this->form_validation->set_rules('unpublish_date', "Unpublish Date", 'required');

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

            $exam_id = $this->gst_model->create_customer($data);
            if ($exam_id) {

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/sales/customer");

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
            $this->load->view("gst/add_customer", $this->data);
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

        $this->form_validation->set_rules('name', "customer Name", 'required');
        $this->form_validation->set_rules('contact_no', "Contact No", 'required');
        $this->form_validation->set_rules('address', "Address", 'required');
        //$this->form_validation->set_rules('unpublish_date', "Unpublish Date", 'required');

        if ($this->form_validation->run() == true) {
            $data = array('name' => $this->input->post('name'),
                'address' => $this->input->post('address'),
                'contact_no' => $this->input->post('contact_no'),
                'remarks' => $this->input->post('remarks'),
            );

            $exam_id = $this->gst_model->update_customer($id, $data);
            if ($exam_id) {

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/sales/customer");

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
            $this->data['customer'] = $this->gst_model->edit_customer($id);
            $this->load->view("common/header");
            $this->load->view("gst/edit_customer", $this->data);
            $this->load->view("common/footer");

        }

    }

    public function misc()
    {

        $this->data['sales'] = array();
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->load->view("common/header");
        $this->load->view("gst/misc", $this->data);
        $this->load->view("common/footer");
    }

    // other payment
    public function other()
    {

        $this->data['sales'] = array();
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->load->view("common/header");
        $this->load->view("gst/other", $this->data);
        $this->load->view("common/footer");
    }

    public function interview()
    {

        $this->data['sales'] = array();
        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');
        $this->load->view("common/header");
        $this->load->view("gst/interview", $this->data);
        $this->load->view("common/footer");
    }

// end of the other payment

    public function receipt($id)
    {
        //$year_id = $this->get_fyr();
        $this->db->select('gst_account.*,customer.name as customername,customer.address as address');
        $this->db->from('gst_account');
        $this->db->join('customer', 'gst_account.customer_id=customer.id');
        //$this->db->where('year_id',$year_id);
        $this->db->where('gst_account.id', $id);
        //$this->db->limit('50');
        //$this->db->order_by('sales.bill_date',"DESC");
        $query = $this->db->get();
        $this->data['sales'] = $query->row_array();

//print_r($this->data['sales']);
        //exit;

        $this->load->view("common/header");
        $this->load->view("gst/receipt", $this->data);
        $this->load->view("common/footer");

    }

   

}
