<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pagnation extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        //$this->load->library('ion_auth');

        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('common_model');
        $this->load->model('admin/admission_model');
        $this->load->database();
        //$this->lang->load('auth');
        $this->load->helper('language');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('pagination');
        /*if (!$this->ion_auth->logged_in())
    {
    redirect('admin/auth', 'refresh');
    }*/
    }

    //redirect if needed, otherwise display the user list
    public function mypage($id = null)
    {

        $config['base_url'] = site_url() . '/admin/pagnation/mypage/';
        $config['total_rows'] = 200;
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;
        $this->pagination->initialize($config);

        echo $this->pagination->create_links();

    }
}
