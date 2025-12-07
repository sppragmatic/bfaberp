<?php defined('BASEPATH') or exit('No direct script access allowed');

class Backup extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->database();

        $this->load->library('session');
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('admin/batch_model');
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

        // Load the DB utility class
        $this->load->dbutil();
        $backup = &$this->dbutil->backup();
        $dt = date('d-m-Y');
        $fl = "SQL" . $dt . ".gz";
        $this->load->helper('file');
        write_file('/home1/questqj5/public_html/quest_portal_cl/' . $fl, $backup);

        $this->load->helper('download');
        force_download($fl, $backup);

        echo "Backup taken";exit;

    }

}
