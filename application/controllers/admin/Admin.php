<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Admin extends CI_Controller {

	public $data = [];
	public $header = [];

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
		
		// Initialize header data for menu functionality
		$this->header['menu'] = 1; // Enable menu
		$this->header['webdata'] = "";
		
		// Add admin status and session data for header menu
		if ($this->ion_auth->logged_in()) {
			$this->header['is_admin'] = $this->ion_auth->is_admin();
			$this->header['current_user'] = $this->ion_auth->user()->row();
		} else {
			$this->header['is_admin'] = false;
			$this->header['current_user'] = null;
		}
		
		// Add session branch info if available
		if ($this->session->userdata('branch_id')) {
			$this->header['ses_branch'] = $this->common_model->get_branch($this->session->userdata('branch_id'));
		}

	}



	//redirect if needed, otherwise display the user list

	function index()

	{


				$d1 = date('Y-m-d',strtotime("-1 days"));
		//$d1 = '2017-11-29';
		 $this->db->select("SUM(credit) as sales, SUM(debit) as colection");
		 $this->db->from("sales_account");
		 $this->db->where("entry_date = '$d1'");
		$data1  = $this->db->get()->row_array();
if($data1['sales']==''){
	$data1['sales']=0;
}
if($data1['colection']==''){
	$data1['colection'] = 0;
}
		$data1['date'] = date('d M', strtotime($d1));

				$d2 = date('Y-m-d',strtotime("-2 days"));
				//$d2 = '2017-11-29';
				 $this->db->select("SUM(credit) as sales, SUM(debit) as colection");
				 $this->db->from("sales_account");
				 $this->db->where("entry_date = '$d2'");
				$data2  = $this->db->get()->row_array();
				$data2['date'] = date('d M', strtotime($d2));

				if($data2['sales']==''){
					$data2['sales']=0;
				}
				if($data2['colection']==''){
					$data2['colection'] = 0;
				}

				$d3 =date('Y-m-d',strtotime("-3 days"));

				//$d3 = '2017-11-29';
				 $this->db->select("SUM(credit) as sales, SUM(debit) as colection");
				 $this->db->from("sales_account");
				 $this->db->where("entry_date = '$d3'");
				$data3  = $this->db->get()->row_array();
				$data3['date'] = date('d M', strtotime($d3));
				if($data3['sales']==''){
					$data3['sales']=0;
				}
				if($data3['colection']==''){
					$data3['colection'] = 0;
				}


				$d4 = date('Y-m-d',strtotime("-4 days"));

				//$d4 = '2017-11-29';
				 $this->db->select("SUM(credit) as sales, SUM(debit) as colection");
				 $this->db->from("sales_account");
				 $this->db->where("entry_date = '$d4'");
				$data4  = $this->db->get()->row_array();
				$data4['date'] = date('d M', strtotime($d4));
				if($data4['sales']==''){
					$data4['sales']=0;
				}
				if($data4['colection']==''){
					$data4['colection'] = 0;
				}

				$d5 = date('Y-m-d',strtotime("-5 days"));
				//$d5 = '2017-11-29';
				 $this->db->select("SUM(credit) as sales, SUM(debit) as colection");
				 $this->db->from("sales_account");
				 $this->db->where("entry_date = '$d5'");
				$data5  = $this->db->get()->row_array();
				$data5['date'] = date('d M', strtotime($d5));
				if($data5['sales']==''){
					$data5['sales']=0;
				}
				if($data5['colection']==''){
					$data5['colection'] = 0;
				}

		$this->data['data1'] = $data1;
		$this->data['data2'] = $data2;
		$this->data['data3'] = $data3;
		$this->data['data4'] = $data4;
		$this->data['data5'] = $data5;

		$this->data['exams'] = array();

		// Generate production chart data for last 5 days
		$prod1 = $prod2 = $prod3 = $prod4 = $prod5 = ['date'=>'', 'amount'=>0];

		for ($i = 1; $i <= 5; $i++) {
			$date = date('Y-m-d', strtotime("-$i days"));
			$this->db->select('SUM(grand_total) as amount');
			$this->db->from('production');
			$this->db->where("entry_date = '$date'");
			$row = $this->db->get()->row_array();
			$prod = [
				'date' => date('d M', strtotime($date)),
				'amount' => isset($row['amount']) && $row['amount'] !== '' ? (float)$row['amount'] : 0
			];
			${'prod'.$i} = $prod;
		}

		$this->data['prod1'] = $prod1;
		$this->data['prod2'] = $prod2;
		$this->data['prod3'] = $prod3;
		$this->data['prod4'] = $prod4;
		$this->data['prod5'] = $prod5;

		$this->load->view("common/header", $this->header);

		$this->load->view("admin/dashboard",$this->data);

		$this->load->view("common/footer");

	}









	function exam_type(){



		$this->data = '';

		$this->data['exam_type'] =  $this->admin_model->examtypes();

		$this->load->view("common/header", $this->header);

		$this->load->view("admin/exam_type",$this->data);

		$this->load->view("common/footer");





	}







// create a new group

	function create_type()

	{





		$this->data['title'] = "Create Exam Type";



		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())

		{

			redirect('admin/auth', 'refresh');

		}



		//validate form input

		$this->form_validation->set_rules('name', "Interview Name", 'required|xss_clean|is_unique[exam_type.name]');

		$this->form_validation->set_rules('description', "Description", 'xss_clean');



		if ($this->form_validation->run() == TRUE)

		{





			$data['name'] = $this->input->post('name');

			$data['description'] =  $this->input->post('description');

			$new_type_id =  $this->admin_model->create_type($data);

			//echo $new_category_id;exit;

			if($new_type_id)

			{

				$this->session->set_flashdata('message', $this->ion_auth->messages());

				redirect("admin/admin/exam_type");

			}

		}

		else

		{

			//display the create group form

			//set the flash data error message if there is one

			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));



	if($this->input->post('name')!= null){

		$this->data['name'] = $this->input->post('name');

		$this->data['description'] = $this->input->post('description');



	}else{

		$this->data['name'] = '';

		$this->data['description'] = '';

	}





		$this->load->view("common/header");

		$this->load->view("admin/create_type",$this->data);

		$this->load->view("common/footer");





		}

	}



	//edit a group

	function edit_type($id)

	{





		// bail if no group id given

		if(!$id || empty($id))

		{

			redirect('admin/auth', 'refresh');

		}



		$this->data['title'] = 'Edit Type';



		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())

		{

			redirect('admin/auth', 'refresh');

		}



		$exam_type = $this->admin_model->edit_type($id);



		//validate form input

		$this->form_validation->set_rules('name', 'Interview Name', 'required|xss_clean');

		$this->form_validation->set_rules('description', 'Description', 'xss_clean');



		if (isset($_POST) && !empty($_POST))

		{

			if ($this->form_validation->run() === TRUE)

			{



				 $data['name'] = $_POST['name'];

				 $data['description'] = $_POST['description'];

				$id_type = $this->admin_model->update_type($id, $data);



				if($id_type)

				{

					$this->session->set_flashdata('message', "Exam type Updated!");

				}

				else

				{

					$this->session->set_flashdata('message', $this->ion_auth->errors());

				}

				redirect("admin/admin/exam_type");

			}

		}



		//set the flash data error message if there is one

		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));



		//pass the user to the view

			$this->data['examtype'] = $exam_type;

			$this->load->view("common/header");

			$this->load->view("admin/edit_type",$this->data);

			$this->load->view("common/footer");

	}





function view_category($msg=NULL){

		$this->data['online_counter'] = $this->admin_model->get_newcomplain();

	$this->data['grievance_counter'] = $this->admin_model->get_grievance();



			if($msg == '1'){

				$this->data['msg'] = "<p style='color:red'>Category Deleted Successfully!</p>";

			}else if($msg == '2'){

					$this->data['msg'] = "<p style='color:red'>Unable To Delete The Category!<br>It is Being used by the Grievance </p>";

			}else if($msg == '3'){

					$this->data['msg'] = "<p style='color:red'>You Dont have Access to delete!</p>";

			}else{

				$this->data['msg'] = "<p style='color:green'>Listing of Categories!</p>";

			}



			$this->data['categories'] = $this->admin_model->categories()->result();

			$this->load->view("common/header",$this->header);

			$this->load->view("common/menu");

			$this->load->view("admin/view_category",$this->data);

			$this->load->view("common/footer");



}





function delete_type($id){



		$page_delete = $this->admin_model->delete_type($id);

		redirect("admin/admin/exam_type");





}











// start of the exam Board



	function exam_board(){



		$this->data = '';

		$this->data['exam_board'] =  $this->admin_model->examboard();

		$this->load->view("common/header");

		$this->load->view("admin/exam_board",$this->data);

		$this->load->view("common/footer");





	}







// create a new group

	function create_board()

	{





		$this->data['title'] = "Create Exam Board";



		$this->data['exam_type'] =  $this->admin_model->examtype();



		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())

		{

			redirect('admin/auth', 'refresh');

		}



		//validate form input

		$this->form_validation->set_rules('name', "Exam Board", 'required|xss_clean|is_unique[exam_board.name]');

		$this->form_validation->set_rules('type_id', "Exam Type", 'required|xss_clean');

		$this->form_validation->set_rules('description', "Description", 'xss_clean');



		if ($this->form_validation->run() == TRUE)

		{



			$data['name'] = $this->input->post('name');

			$data['type_id'] = $this->input->post('type_id');

			$data['description'] = $this->input->post('description');





			$new_type_id =  $this->admin_model->create_board($data);

			//echo $new_category_id;exit;

			if($new_type_id)

			{

				$this->session->set_flashdata('message', $this->ion_auth->messages());

				redirect("admin/admin/exam_board");

			}

		}

		else

		{

			//display the create group form

			//set the flash data error message if there is one

			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));



	if($this->input->post('name')!= null){

		$this->data['name'] = $this->input->post('name');

		$this->data['description'] = $this->input->post('description');



	}else{

		$this->data['name'] = '';

		$this->data['description'] = '';

	}



	if($this->input->post('type_id')!= null){

		$this->data['type_id'] = $this->input->post('type_id');



	}else{

		$this->data['type_id'] = '';

	}







		$this->load->view("common/header");

		$this->load->view("admin/create_board",$this->data);

		$this->load->view("common/footer");





		}

	}



	//edit a group

	function edit_board($id)

	{





		// bail if no group id given

		if(!$id || empty($id))

		{

			redirect('admin/auth', 'refresh');

		}

$this->data['exam_type'] =  $this->admin_model->examtype();

		$this->data['title'] = 'Edit Board';



		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())

		{

			redirect('admin/auth', 'refresh');

		}



		$exam_board = $this->admin_model->edit_board($id);



		//validate form input

		$this->form_validation->set_rules('name', 'Board Name', 'required|xss_clean');

		$this->form_validation->set_rules('type_id', "Exam Type", 'required|xss_clean');

		$this->form_validation->set_rules('description', 'Description', 'xss_clean');



		if (isset($_POST) && !empty($_POST))

		{

			if ($this->form_validation->run() === TRUE)

			{

				$id_type = $this->admin_model->update_board($id, $_POST['name'],$_POST['type_id'], $_POST['description']);



				if($id_type)

				{

					$this->session->set_flashdata('message', "Exam type Updated!");

				}

				else

				{

					$this->session->set_flashdata('message', $this->ion_auth->errors());

				}

				redirect("admin/admin/exam_board");

			}

		}



		//set the flash data error message if there is one

		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));



		//pass the user to the view

			$this->data['exam_board'] = $exam_board;

			$this->load->view("common/header");

			$this->load->view("admin/edit_board",$this->data);

			$this->load->view("common/footer");

	}





function delete_board($id){



		$page_delete = $this->admin_model->delete_board($id);

		redirect("admin/admin/exam_board");





}



/*start of the classess

*/



	function classes(){



		$this->data = '';

		$this->data['classes'] =  $this->admin_model->classes();

		$this->load->view("common/header");

		$this->load->view("admin/classes",$this->data);

		$this->load->view("common/footer");





	}







// create a new group

	function create_class()

	{





		$this->data['title'] = "Create Class";



		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())

		{

			redirect('admin/auth', 'refresh');

		}



		//validate form input

		$this->form_validation->set_rules('name', "Class Name", 'required|xss_clean|is_unique[class.name]');

		$this->form_validation->set_rules('description', "Description", 'xss_clean');



		if ($this->form_validation->run() == TRUE)

		{





			$data['name'] = $this->input->post('name');

			$data['description'] =  $this->input->post('description');

			$new_type_id =  $this->admin_model->create_class($data);

			//echo $new_category_id;exit;

			if($new_type_id)

			{

				$this->session->set_flashdata('message', $this->ion_auth->messages());

				redirect("admin/admin/classes");

			}

		}

		else

		{

			//display the create group form

			//set the flash data error message if there is one

			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));



	if($this->input->post('name')!= null){

		$this->data['name'] = $this->input->post('name');

		$this->data['description'] = $this->input->post('description');



	}else{

		$this->data['name'] = '';

		$this->data['description'] = '';

	}





		$this->load->view("common/header");

		$this->load->view("admin/create_class",$this->data);

		$this->load->view("common/footer");





		}

	}



	//edit a group

	function edit_class($id)

	{





		// bail if no group id given

		if(!$id || empty($id))

		{

			redirect('admin/auth', 'refresh');

		}



		$this->data['title'] = 'Edit Class';



		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())

		{

			redirect('admin/auth', 'refresh');

		}



		$class = $this->admin_model->edit_class($id);



		//validate form input

		$this->form_validation->set_rules('name', 'Class Name', 'required|xss_clean');

		$this->form_validation->set_rules('description', 'Description', 'xss_clean');



		if (isset($_POST) && !empty($_POST))

		{

			if ($this->form_validation->run() === TRUE)

			{



				 $data['name'] = $_POST['name'];

				 $data['description'] = $_POST['description'];

				$id_type = $this->admin_model->update_class($id, $data);



				if($id_type)

				{

					$this->session->set_flashdata('message', "Class Updated!");

				}

				else

				{

					$this->session->set_flashdata('message', $this->ion_auth->errors());

				}

				redirect("admin/admin/classes");

			}

		}



		//set the flash data error message if there is one

		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));



		//pass the user to the view

			$this->data['class'] = $class;

			$this->load->view("common/header");

			$this->load->view("admin/edit_class",$this->data);

			$this->load->view("common/footer");

	}











function delete_class($id){



		$class = $this->admin_model->delete_class($id);

		redirect("admin/admin/classes");





}



/*start of the subjects*/







	function subject(){



		$this->data = '';

		$this->data['subjects'] =  $this->admin_model->subjects();

		$this->load->view("common/header");

		$this->load->view("admin/subjects",$this->data);

		$this->load->view("common/footer");





	}







// create a new group

	function create_subject()

	{





		$this->data['title'] = "Create Subject";



		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())

		{

			redirect('admin/auth', 'refresh');

		}



		//validate form input

		$this->form_validation->set_rules('name', "Subject Name", 'required|xss_clean|is_unique[subject.name]');

		$this->form_validation->set_rules('description', "Description", 'xss_clean');



		if ($this->form_validation->run() == TRUE)

		{





			$data['name'] = $this->input->post('name');

			$data['description'] =  $this->input->post('description');

			$new_type_id =  $this->admin_model->create_subject($data);

			//echo $new_category_id;exit;

			if($new_type_id)

			{

				$this->session->set_flashdata('message', $this->ion_auth->messages());

				redirect("admin/admin/subject");

			}

		}

		else

		{

			//display the create group form

			//set the flash data error message if there is one

			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));



	if($this->input->post('name')!= null){

		$this->data['name'] = $this->input->post('name');

		$this->data['description'] = $this->input->post('description');



	}else{

		$this->data['name'] = '';

		$this->data['description'] = '';

	}





		$this->load->view("common/header");

		$this->load->view("admin/create_subject",$this->data);

		$this->load->view("common/footer");





		}

	}



	//edit a group

	function edit_subject($id)

	{





		// bail if no group id given

		if(!$id || empty($id))

		{

			redirect('admin/auth', 'refresh');

		}

		$this->data['title'] = 'Edit Subject';



		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())

		{

			redirect('admin/auth', 'refresh');

		}



		$subject = $this->admin_model->edit_subject($id);



		//validate form input

		$this->form_validation->set_rules('name', 'Subject Name', 'required|xss_clean');

		$this->form_validation->set_rules('description', 'Description', 'xss_clean');



		if (isset($_POST) && !empty($_POST))

		{

			if ($this->form_validation->run() === TRUE)

			{



				 $data['name'] = $_POST['name'];

				 $data['description'] = $_POST['description'];

				$id_type = $this->admin_model->update_subject($id, $data);



				if($id_type)

				{

					$this->session->set_flashdata('message', "Subject Updated!");

				}

				else

				{

					$this->session->set_flashdata('message', $this->ion_auth->errors());

				}

				redirect("admin/admin/subject");

			}

		}



		//set the flash data error message if there is one

		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));



		//pass the user to the view

			$this->data['subject'] = $subject;

			$this->load->view("common/header");

			$this->load->view("admin/edit_subject",$this->data);

			$this->load->view("common/footer");

	}











function delete_subject($id){



		$subject = $this->admin_model->delete_subject($id);

		redirect("admin/admin/subject");

}







function district(){
		$this->data = '';
		$this->data['district'] =  $this->admin_model->district();
		$this->load->view("common/header");
		$this->load->view("admin/district",$this->data);
		$this->load->view("common/footer");
	}

// create a new group

	function create_district()
	{
		$this->data['title'] = "Create Exam Type";
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('admin/auth', 'refresh');

		}
		$this->form_validation->set_rules('name', "Exam  Type", 'required|xss_clean|is_unique[district.name]');
		$this->form_validation->set_rules('description', "Description", 'xss_clean');
		if ($this->form_validation->run() == TRUE)
		{
			$data['name'] = $this->input->post('name');
			$data['description'] =  $this->input->post('description');
			$district_id =  $this->admin_model->create_district($data);
			if($district_id)
			{
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("admin/admin/district");
			}

		}
		else
		{
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		if($this->input->post('name')!= null){
		$this->data['name'] = $this->input->post('name');
		$this->data['description'] = $this->input->post('description');
	}else{
		$this->data['name'] = '';
		$this->data['description'] = '';
	}

		$this->load->view("common/header");
		$this->load->view("admin/create_district",$this->data);
		$this->load->view("common/footer");
		}

	}



	//edit a group

	function edit_district($id)
	{
		if(!$id || empty($id))
		{
			redirect('admin/auth', 'refresh');
		}
		$this->data['title'] = 'Edit Type';
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('admin/auth', 'refresh');
		}
		$district = $this->admin_model->edit_district($id);
		$this->form_validation->set_rules('name', 'Category Name', 'required|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'xss_clean');
		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				 $data['name'] = $_POST['name'];

				 $data['description'] = $_POST['description'];

				$id_district = $this->admin_model->update_district($id, $data);
				if($id_district)
				{
					$this->session->set_flashdata('message', "Exam type Updated!");
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("admin/admin/district");
			}
		}

		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->data['district'] = $district;
			$this->load->view("common/header");
			$this->load->view("admin/edit_district",$this->data);
			$this->load->view("common/footer");

	}


// start of the exam Board



	function city(){
		$this->data = '';
		$this->data['city'] =  $this->admin_model->place();
		$this->load->view("common/header");
		$this->load->view("admin/city",$this->data);
		$this->load->view("common/footer");
	}


// create a new group

	function create_city()
	{
		$this->data['title'] = "Create City";
		$this->data['district'] =  $this->admin_model->get_district();
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('admin/auth', 'refresh');
		}
		//validate form input
		$this->form_validation->set_rules('name', "City Name", 'required|xss_clean|is_unique[place.name]');
		$this->form_validation->set_rules('district_id', "Distrct", 'required|xss_clean');
		$this->form_validation->set_rules('description', "Description", 'xss_clean');

		if ($this->form_validation->run() == TRUE)
		{
			$data['name'] = $this->input->post('name');
			$data['district_id'] = $this->input->post('district_id');
			$data['description'] = $this->input->post('description');
			$city_id =  $this->admin_model->create_city($data);

			//echo $new_category_id;exit;

			if($city_id)
			{
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("admin/admin/city");
			}
		}
		else
		{

			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

	if($this->input->post('name')!= null){
		$this->data['name'] = $this->input->post('name');
		$this->data['description'] = $this->input->post('description');
	}else{
		$this->data['name'] = '';
		$this->data['description'] = '';
	}

	if($this->input->post('district_id')!= null){
		$this->data['district_id'] = $this->input->post('district_id');
	}else{
		$this->data['district_id'] = '';
	}

		$this->load->view("common/header");

		$this->load->view("admin/create_city",$this->data);

		$this->load->view("common/footer");
		}

	}



	//edit a group

	function edit_city($id)
	{
		if(!$id || empty($id))

		{

			redirect('admin/auth', 'refresh');

		}

	$this->data['district'] =  $this->admin_model->get_district();
		$this->data['title'] = 'Edit District';
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())

		{

			redirect('admin/auth', 'refresh');

		}

		$city = $this->admin_model->edit_city($id);
		//validate form input

		$this->form_validation->set_rules('name', 'City Name', 'required|xss_clean');
		$this->form_validation->set_rules('district_id', "District", 'required|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'xss_clean');
		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$id_type = $this->admin_model->update_city($id, $_POST['name'],$_POST['district_id'], $_POST['description']);
				if($id_type)
				{
					$this->session->set_flashdata('message', "City  Updated!");
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("admin/admin/city");
			}

		}



		//set the flash data error message if there is one

		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


		//pass the user to the view
			$this->data['city'] = $city;
			$this->load->view("common/header");
			$this->load->view("admin/edit_city",$this->data);
			$this->load->view("common/footer");

	}





function delete_city($id){
		$city_delete = $this->admin_model->delete_city($id);
		redirect("admin/admin/city");

}



function delete_district($id){
		$dist_delete = $this->admin_model->delete_district($id);
		redirect("admin/admin/district");

}

// start of the batch part



function batch(){
		$this->data = '';
		$this->data['batch'] =  $this->admin_model->get_batch();
		$this->load->view("common/header");
		$this->load->view("admin/batch",$this->data);
		$this->load->view("common/footer");
	}

// create a new group

	function create_batch()
	{
		$this->data['title'] = "Create Batch";

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('admin/auth', 'refresh');

		}
			$this->data['classes'] =  $this->admin_model->get_class();

		$this->form_validation->set_rules('name', "Batch Name", 'required|xss_clean|is_unique[batch.name]');
		$this->form_validation->set_rules('class_id', "Class", 'required');

		$this->form_validation->set_rules('description', "Description", 'xss_clean');
		if ($this->form_validation->run() == TRUE)
		{
			$data['name'] = $this->input->post('name');
			$data['class_id'] = $this->input->post('class_id');
			$data['description'] =  $this->input->post('description');


			$district_id =  $this->admin_model->create_batch($data);

			if($district_id)
			{
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("admin/admin/batch");
			}

		}
		else
		{
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		if($this->input->post('name')!= null){
		$this->data['name'] = $this->input->post('name');
		$this->data['description'] = $this->input->post('description');
	}else{
		$this->data['name'] = '';
		$this->data['description'] = '';
	}

if($this->input->post('class_id')!= null){
	$this->data['class_id'] = $this->input->post('class_id');
}else{
	$this->data['class_id'] = '';
}

		$this->load->view("common/header");
		$this->load->view("admin/create_batch",$this->data);
		$this->load->view("common/footer");
		}

	}



	//edit a group

	function edit_batch($id)
	{
		if(!$id || empty($id))
		{
			redirect('admin/auth', 'refresh');
		}
		$this->data['title'] = 'Edit Batch';
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('admin/auth', 'refresh');
		}

		$this->data['classes'] =  $this->admin_model->get_class();
		$batch = $this->admin_model->edit_batch($id);
		$this->form_validation->set_rules('name', 'Batch Name', 'required|xss_clean');
		$this->form_validation->set_rules('class_id', 'Class', 'required|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'xss_clean');
		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				 $data['name'] = $_POST['name'];
			 	 $data['class_id'] = $_POST['class_id'];
				 $data['description'] = $_POST['description'];

				$id_district = $this->admin_model->update_batch($id, $data);
				if($id_district)
				{
					$this->session->set_flashdata('message', "Exam type Updated!");
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("admin/admin/batch");
			}
		}

		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->data['batch'] = $batch;
			$this->load->view("common/header");
			$this->load->view("admin/edit_batch",$this->data);
			$this->load->view("common/footer");

	}


// start of the exam Board

function delete_batch($id){
		$dist_delete = $this->admin_model->delete_batch($id);
		redirect("admin/admin/batch");

}





	function chapter(){
		$this->data = '';
		$this->data['chapter'] =  $this->admin_model->get_chapter();
		$this->load->view("common/header");
		$this->load->view("admin/chapter",$this->data);
		$this->load->view("common/footer");
	}





	function create_chapter()
	{
		$this->data['title'] = "Create chapter";

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('admin/auth', 'refresh');

		}
			$this->data['subjects'] =  $this->admin_model->get_subject();

		$this->form_validation->set_rules('name', "Chapter Name", 'required|xss_clean|is_unique[chapter.name]');
		$this->form_validation->set_rules('subject_id', "Subject", 'required');

		$this->form_validation->set_rules('description', "Description", 'xss_clean');
		if ($this->form_validation->run() == TRUE)
		{
			$data['name'] = $this->input->post('name');
			$data['subject_id'] = $this->input->post('subject_id');

			$chapter_id =  $this->admin_model->create_chapter($data);

			if($chapter_id)
			{
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("admin/admin/chapter");
			}

		}
		else
		{
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		if($this->input->post('name')!= null){
		$this->data['name'] = $this->input->post('name');
	}else{
		$this->data['name'] = '';
	}

if($this->input->post('subject_id')!= null){
	$this->data['subject_id'] = $this->input->post('subject_id');
}else{
	$this->data['subject_id'] = '';
}

		$this->load->view("common/header");
		$this->load->view("admin/add_chapter",$this->data);
		$this->load->view("common/footer");
		}

	}



	//edit a group

	function edit_chapter($id)
	{
		if(!$id || empty($id))
		{
			redirect('admin/auth', 'refresh');
		}
		$this->data['title'] = 'Edit chapter';
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('admin/auth', 'refresh');
		}

		$this->data['subjects'] =  $this->admin_model->get_subject();
		$chapter = $this->admin_model->edit_chapter($id);


		$this->form_validation->set_rules('name', 'Chapter Name', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject', 'required|xss_clean');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				 $data['name'] = $_POST['name'];
			 	 $data['subject_id'] = $_POST['subject_id'];


				$subject_id = $this->admin_model->update_chapter($id, $data);
				if($subject_id)
				{
					$this->session->set_flashdata('message', "Subject Updated!");
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("admin/admin/chapter");
			}
		}

		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->data['chapter'] = $chapter;
			$this->load->view("common/header");
			$this->load->view("admin/edit_chapter",$this->data);
			$this->load->view("common/footer");

	}


// start of the exam Board

function delete_chapter($id){
		$dist_delete = $this->admin_model->delete_batch($id);
		redirect("admin/admin/chapter");

}

	/**
	 * System Settings - Admin Only
	 */
	public function system_settings()
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			show_error('You must be an administrator to access system settings.', 403);
		}

		$this->data['title'] = "System Settings";
		
		// Handle form submission
		if ($this->input->post()) {
			$settings = array(
				'company_name' => $this->input->post('company_name'),
				'company_address' => $this->input->post('company_address'),
				'company_phone' => $this->input->post('company_phone'),
				'company_email' => $this->input->post('company_email'),
				'tax_rate' => $this->input->post('tax_rate'),
				'currency_symbol' => $this->input->post('currency_symbol'),
			);
			
			// Save settings to database or config
			foreach ($settings as $key => $value) {
				$this->admin_model->update_setting($key, $value);
			}
			
			$this->session->set_flashdata('message', 'Settings updated successfully!');
			redirect('admin/admin/system_settings');
		}
		
		// Load current settings
		$this->data['settings'] = $this->admin_model->get_all_settings();
		
		$this->load->view("common/header", $this->header);
		$this->load->view('admin/system_settings', $this->data);
		$this->load->view("common/footer");
	}

	/**
	 * System Logs - Admin Only
	 */
	public function logs()
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			show_error('You must be an administrator to access system logs.', 403);
		}

		$this->data['title'] = "System Logs";
		
		// Read log files
		$log_path = APPPATH . 'logs/';
		$this->data['log_files'] = array();
		
		if (is_dir($log_path)) {
			$files = scandir($log_path);
			foreach ($files as $file) {
				if (pathinfo($file, PATHINFO_EXTENSION) == 'php' && strpos($file, 'log-') === 0) {
					$this->data['log_files'][] = $file;
				}
			}
		}
		
		// Read specific log file if requested
		$selected_log = $this->input->get('file');
		$this->data['selected_log'] = $selected_log;
		$this->data['log_content'] = '';
		
		if ($selected_log && file_exists($log_path . $selected_log)) {
			$content = file_get_contents($log_path . $selected_log);
			$this->data['log_content'] = $content;
		}
		
		$this->load->view("common/header", $this->header);
		$this->load->view('admin/system_logs', $this->data);
		$this->load->view("common/footer");
	}

	/**
	 * Maintenance Mode - Admin Only
	 */
	public function maintenance()
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			show_error('You must be an administrator to access maintenance mode.', 403);
		}

		$this->data['title'] = "Maintenance Mode";
		
		// Handle maintenance toggle
		if ($this->input->post('action')) {
			$action = $this->input->post('action');
			
			if ($action == 'enable') {
				// Create maintenance file
				$maintenance_file = FCPATH . '.maintenance';
				file_put_contents($maintenance_file, 'Site is under maintenance. Please check back later.');
				$this->session->set_flashdata('message', 'Maintenance mode enabled!');
			} elseif ($action == 'disable') {
				// Remove maintenance file
				$maintenance_file = FCPATH . '.maintenance';
				if (file_exists($maintenance_file)) {
					unlink($maintenance_file);
				}
				$this->session->set_flashdata('message', 'Maintenance mode disabled!');
			}
			
			redirect('admin/admin/maintenance');
		}
		
		// Check if maintenance mode is active
		$this->data['maintenance_active'] = file_exists(FCPATH . '.maintenance');
		
		$this->load->view("common/header", $this->header);
		$this->load->view('admin/maintenance_mode', $this->data);
		$this->load->view("common/footer");
	}

}
