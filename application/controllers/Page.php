<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Page extends CI_Controller {



	function __construct()

	{

		parent::__construct();
	$this->load->database();
		$this->load->library('ion_auth');
date_default_timezone_set('Asia/Kolkata'); 
		$this->load->library('form_validation');

		$this->load->helper('url');
if (!$this->ion_auth->logged_in())
		{
			redirect('admin/auth', 'refresh');
		}


		$this->load->model('admin_model');
		$this->load->model('common_model');



		// Load MongoDB library instead of native db driver if required

		$this->config->item('use_mongodb', 'ion_auth') ?

		$this->load->library('mongo_db') :

		$this->load->database();



		$this->lang->load('auth');

		$this->load->helper('language');


		$this->data['title'] = "Create Exam";
		if (!$this->ion_auth->logged_in())
		{
			redirect('admin/auth', 'refresh');
		}

	}



	//redirect if needed, otherwise display the user list

	function index()
	{
	redirect('admin/auth', 'refresh');
}

}
