<?php defined('BASEPATH') or exit('No direct script access allowed');

class Enquiry extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->database();

        $this->load->library('session');
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('admin/course_model');
        $this->load->model('admin/enquiry_model');
        $this->load->model('common_model');
        $this->load->model('admin/branch_model');
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
        $this->data['course'] = $this->enquiry_model->get_allcourse();
        $this->data['enquiry'] = $this->enquiry_model->get_allenquiry();

        $this->load->view("common/header");
        $this->load->view("admin/enquiry/listing_enquiry", $this->data);
        $this->load->view("common/footer");

    }

    public function create_enquiry()
    {

        $branch_id = $this->session->userdata('branch_id');
        $entry_by = $this->session->userdata('identity');

        $this->data['course'] = $this->enquiry_model->get_allcourse();

        $this->form_validation->set_rules('enquiry[name]', 'Name', 'required');
        $this->form_validation->set_rules('enquiry[email_id]', 'Email Id', 'required');
        $this->form_validation->set_rules('enquiry[mobile_no]', 'Mobile no', 'required');
        $this->form_validation->set_rules('enquiry[course_id]', 'Course Name', 'required');

        if ($this->form_validation->run() == false) {
            $data = $this->input->post('enquiry');
            if ($data['name'] !== "") {
                $this->data['name'] = $data['name'];
            } else {
                $this->data['name'] = "";
            }

            if ($data['email_id'] !== "") {
                $this->data['email_id'] = $data['email_id'];
            } else {
                $this->data['email_id'] = "";
            }

            if ($data['mobile_no'] !== "") {
                $this->data['mobile_no'] = $data['mobile_no'];
            } else {
                $this->data['mobile_no'] = "";
            }

            if ($data['message'] !== "") {
                $this->data['message'] = $data['message'];
            } else {
                $this->data['message'] = "";
            }

            if ($data['course_id'] !== "") {
                $this->data['course_id'] = $data['course_id'];
            } else {
                $this->data['course_id'] = "";
            }

            $this->load->view("common/header");
            $this->load->view('admin/enquiry/create_enquiry', $this->data);
            $this->load->view("common/footer");

        } else {

            $enquiry = $this->input->post('enquiry');
            $enquiry['branch_id'] = $branch_id;
            $enquiry['entry_by'] = $entry_by;
            $enquiry['entry_date'] = date('Y-m-d');

            $insert = $this->enquiry_model->insert_enquiry($enquiry);
            if ($insert !== "") {
                redirect('admin/enquiry/edit_enquiry/' . $insert);
            } else {
                redirect('admin/enquiry/');
            }

        }

    }

    public function edit_enquiry($id = null)
    {
        $this->data['course'] = $this->enquiry_model->get_allcourse();
        $this->data['enquiry'] = $this->enquiry_model->get_enquiry($id);

        $this->form_validation->set_rules('enquiry[name]', 'Name', 'required');
        $this->form_validation->set_rules('enquiry[email_id]', 'Email Id', 'required');
        $this->form_validation->set_rules('enquiry[mobile_no]', 'Mobile no', 'required');
        $this->form_validation->set_rules('enquiry[course_id]', 'Course Name', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view("common/header");
            $this->load->view('admin/enquiry/edit_enquiry', $this->data);
            $this->load->view("common/footer");

        } else {

            $data = $this->input->post('enquiry');

            $update = $this->enquiry_model->update_enquiry($data, $id);
            redirect('admin/enquiry/edit_enquiry/' . $id);

        }

    }

    public function delete_enquiry($id = null)
    {

        $this->enquiry_model->delete_enquiry($id);
        $this->session->set_flashdata('msg', 'Enquiry Successfully Deleted');
        redirect('admin/enquiry/');
    }

    public function search()
    {
        $this->data['course'] = $this->enquiry_model->get_allcourse();
        $this->data['start_date'] = $st = $this->input->post('start_date');
        $this->data['course_id'] = $course_id = $this->input->post('course_id');
        $this->data['end_date'] = $et = $this->input->post('end_date');

        $start_date = date('Y-m-d', strtotime($st));
        $end_date = date('Y-m-d', strtotime($et));

        $cond = array();
        if ($course_id != '') {
            $cond['course_id'] = $course_id;
        }

        $this->db->select('enquiry.*,course.name AS course_name');
        $this->db->from('enquiry');
        $this->db->join('course', 'enquiry.course_id=course.id');
        $this->db->where("entry_date >='$start_date' AND entry_date<'$end_date'");
        $this->db->where($cond);
        $this->data['enquiry'] = $this->db->get()->result();
        $this->load->view("common/header");
        $this->load->view("admin/enquiry/search", $this->data);
        $this->load->view("common/footer");
    }
    public function up_en()
    {
        $cond['id'] = $_REQUEST['id'];
        $data['message'] = $_REQUEST['con'];
        $res = $this->db->update('enquiry', $data, $cond);
        if ($res) {
            //echo $this->db->last_query();
            echo ("Data Updated Successfully !");

        } else {

            echo ("Unable to Update!");
        }

    }

/* Course Category Start Here */

}
