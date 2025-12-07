<?php defined('BASEPATH') or exit('No direct script access allowed');

class Branch extends CI_Controller
{
    /**
     * Branch model
     *
     * @var object
     */
    public $branch_model;

    /**
     * Common model
     *
     * @var object
     */
    public $common_model;

    public function __construct()
    {

        parent::__construct();
        $this->load->database();

        $this->load->library('session');
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('admin/branch_model');
        $this->load->model('common_model');
        $this->load->database();
        $this->lang->load('auth');
        $this->load->helper('language');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

    }

    //redirect if needed, otherwise display the user list

    public function index()
    {

        $this->data['branch'] = $this->branch_model->get_allbranch();

        $this->load->view("common/header");
        $this->load->view("admin/branch/listing_branch", $this->data);
        $this->load->view("common/footer");

    }

    public function create_branch()
    {

        $this->form_validation->set_rules('branch[name]', 'Name', 'required');
        $this->form_validation->set_rules('branch[address]', 'Address', 'required');
        $this->form_validation->set_rules('branch[code]', 'Branch Code', 'required|is_unique[branch.code]');

        if ($this->form_validation->run() == false) {

            $data = $this->input->post('branch');

            $this->data['name'] = (is_array($data) && isset($data['name'])) ? $data['name'] : "";
            $this->data['address'] = (is_array($data) && isset($data['address'])) ? $data['address'] : "";
            $this->data['code'] = (is_array($data) && isset($data['code'])) ? $data['code'] : "";

            $this->load->view("common/header");
            $this->load->view('admin/branch/create_branch', $this->data);
            $this->load->view("common/footer");

        } else {

            $name = $this->input->post('branch');

            $insert = $this->branch_model->insert_branch($name);
            if ($insert !== "") {
                redirect('admin/branch/edit_branch/' . $insert);
            } else {
                redirect('admin/branch/');
            }
        }
    }

    public function edit_branch($id = null)
    {

        $this->data['branch'] = $this->branch_model->get_branch($id);

        $this->form_validation->set_rules('branch[name]', 'Name', 'required');
        $this->form_validation->set_rules('branch[address]', 'Address', 'required');
        $this->form_validation->set_rules('branch[code]', 'Branch Code', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view("common/header");
            $this->load->view('admin/branch/edit_branch', $this->data);
            $this->load->view("common/footer");

        } else {

            $data = $this->input->post('branch');

            $update = $this->branch_model->update_branch($data, $id);
            redirect('admin/branch/edit_branch/' . $id);

        }

    }

    public function delete_branch($id = null)
    {

        if ($this->db->get_where('course_fee', array('branch_id' => $id))->num_rows() < "1") {
            $this->branch_model->delete_branch($id);
            $this->session->set_flashdata('msg', 'Branch Successfully Deleted');
            redirect('admin/branch/');
        } else {
            $this->session->set_flashdata('msg_w', 'A Course fee is related to this Branch,So it can not be deleted');
            redirect('admin/branch/');
        }

    }

}
