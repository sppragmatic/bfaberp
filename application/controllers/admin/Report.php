<?php defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->database();

        $this->load->library('ion_auth');

        $this->load->library('form_validation');

        $this->load->helper('url');

        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth', 'refresh');
        }

        $this->load->model('common_model');

        $this->load->model('report_model');
        $this->load->model('question_model');
        $this->load->model('admin/admission_model');

        // Load MongoDB library instead of native db driver if required

        $this->config->item('use_mongodb', 'ion_auth') ?

        $this->load->library('mongo_db') :

        $this->load->database();

        $this->lang->load('auth');

        $this->load->helper('language');

    }

    //redirect if needed, otherwise display the user list

  

    public function export()
    {
        header('Content-type: application/vnd.ms-excel');

        header("Content-Disposition: attachment; filename=Report.xls");

        header("Pragma: no-cache");

        header("Expires: 0");

        echo $_REQUEST['hiddenExportText'];
        exit;

    }
/// start of the code for branch report


}
