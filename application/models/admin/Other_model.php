<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class other_model extends CI_Model
{
	/**
	 * Holds an array of tables used
	 *
	 * @var array
	 **/
	public $tables = array();

	/**
	 * activation code
	 *
	 * @var string
	 **/
	public $activation_code;

	/**
	 * forgotten password key
	 *
	 * @var string
	 **/
	public $forgotten_password_code;

	/**
	 * new password
	 *
	 * @var string
	 **/
	public $new_password;

	/**
	 * Identity
	 *
	 * @var string
	 **/
	public $identity;

	/**
	 * Where
	 *
	 * @var array
	 **/
	public $_ion_where = array();

	/**
	 * Select
	 *
	 * @var array
	 **/
	public $_ion_select = array();

	/**
	 * Like
	 *
	 * @var array
	 **/
	public $_ion_like = array();

	/**
	 * Limit
	 *
	 * @var string
	 **/
	public $_ion_limit = NULL;

	/**
	 * Offset
	 *
	 * @var string
	 **/
	public $_ion_offset = NULL;

	/**
	 * Order By
	 *
	 * @var string
	 **/
	public $_ion_order_by = NULL;

	/**
	 * Order
	 *
	 * @var string
	 **/
	public $_ion_order = NULL;

	/**
	 * Hooks
	 *
	 * @var object
	 **/
	protected $_ion_hooks;

	/**
	 * Response
	 *
	 * @var string
	 **/
	protected $response = NULL;

	/**
	 * message (uses lang file)
	 *
	 * @var string
	 **/
	protected $messages;

	/**
	 * error message (uses lang file)
	 *
	 * @var string
	 **/
	protected $errors;

	/**
	 * error start delimiter
	 *
	 * @var string
	 **/
	protected $error_start_delimiter;

	/**
	 * error end delimiter
	 *
	 * @var string
	 **/
	protected $error_end_delimiter;

	/**
	 * caching of users and their groups
	 *
	 * @var array
	 **/
	public $_cache_user_in_group = array();

	/**
	 * caching of groups
	 *
	 * @var array
	 **/
	protected $_cache_groups = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->config('ion_auth', TRUE);
		$this->load->helper('cookie');
		$this->load->helper('date');
		$this->lang->load('ion_auth');
	
	}
	

		function insert_form($data){
			$this->db->insert('admission_form',$data);
			return $this->db->insert_id();
			
		}
		
		function insert_onlineuser_form($data){
			$this->db->insert('online_user',$data);
			return $this->db->insert_id();			
		}

		function get_allform(){
			$this->db->where('admit_status',0);
			$this->db->order_by('id',"DESC");
			return $this->db->get('other_form')->result();
		}

		function get_form($id){
		return $this->db->get_where('other_form',array('id'=>$id))->row();
		//echo $this->db->last_query();exit;
		}
		
		function get_studentcourse($id){
			return $this->db->get_where('student_price',array('user_id'=>$id))->result_array();
		}
		
		
		function get_studentcoursesel($id){
			return $this->db->get_where('student_course',array('user_id'=>$id))->result_array();
		}
		
		
		function update_form($data,$id){
			$this->db->update('admission_form',$data,array('id'=>$id));
		}
		
		function delete_form($id){
			$this->db->delete('other_form',array('id'=>$id));
		}
		
		function get_allcourse(){
			return $this->db->get('course')->result();
		}	
		
		
		function get_allcourseby(){
			return $this->db->get('course')->result_array();
		}		

		function course_ctgy($id){
			$query = $this->db->get_where('course_category',array('course_id'=>$id));
			return $query->result();
		}
		
		function course_ctgy_ajax($id){
			$query = $this->db->get_where('course_category',array('course_id'=>$id));
			return $query->result_array();
		}
		
		
		function course_ctgyby($id){
			$query = $this->db->get_where('course_category',array('course_id'=>$id));
			return $query->result_array();
		}
		
		function course_fee($id,$branch_id){
			$query = $this->db->get_where('course_fee',array('course_ctgy_id'=>$id,'branch_id'=>$branch_id));
			return $query;
		}
		
		function get_allbranch(){
			return $this->db->get('branch')->result();
		}
		
		function get_exambatch(){
				
			return $this->db->get('batch')->result();
		}
		function get_originbatch(){
				
			return $this->db->get('origin_batch')->result();
		}
		
		function get_reportdata($data){
		
			return $this->db->get_where('other_form',$data)->result();
		}
		
		
		function get_price_edit($user_id, $course_id, $course_ctgy_id){
			$data['user_id']= $user_id;
			$data['course_id']= $course_id;
			$data['course_ctgy_id']= $course_ctgy_id;
			$dd=  $this->db->get_where('student_price',$data)->row_array();
			return $dd['course_price'];
		}
		
		function delete_prevcourse($id){
			$this->db->delete('student_price',array('user_id'=>$id));
			$this->db->delete('student_course',array('user_id'=>$id));
			return 1;
		}
		
		
		function get_brcode($id){
			$data['id'] = $id;	
			$code =  $this->db->get_where('branch',$data)->row_array();
			return $code['code'];
		}
		
		function get_btcode($id){
			$data['id'] = $id;
			$code = $this->db->get_where('batch',$data)->row_array();
			return $code['code'];
		
		}
		function get_obcode($id){
				$data['id'] = $id;
				$code = $this->db->get_where('origin_batch',$data)->row_array();
				return $code['code'];
		}
		function get_br($branch_id){
			$sql = "SELECT COUNT(id) AS c_id FROM admission_form WHERE branch_id={$branch_id}";
			$res = $this->db->query($sql);
			$count = $res->row_array();
			return $count['c_id']+1;
			
		}
		
		
		
		function create_transfer($data){
			$sql = $this->db->insert('batch_transfer',$data);
			return $sql;
		}
	
		function insert_course($data){
			$sql = $this->db->insert('student_course',$data);
			return $sql;
		}
	

		function insert_price($data){
			$sql = $this->db->insert('student_price',$data);
			return $this->db->insert_id();
		}


function get_student_coursedetails($user_id){
	$this->db->select("student_price.*,course.name as cr_name,
course_category.name as ctg_name");
	$this->db->from("student_price");
	$this->db->join("course","student_price.course_id=course.id");
	$this->db->join("course_category","student_price.course_ctgy_id=course_category.id");
	$this->db->where('user_id', $user_id);
	$c_d = $this->db->get()->result_array();
	return $c_d;
		
}

function get_student_details($user_id){
	$this->db->select("admission_form.*,origin_batch.name as o_name,batch.name as b_name");
	$this->db->from("admission_form");
	$this->db->join("origin_batch","admission_form.origin_batch_id=origin_batch.id");
	$this->db->join("batch","admission_form.exam_batch_id=batch.id");
	$this->db->where('admission_form.username', $user_id);
	$c_d = $this->db->get()->row_array();

return $c_d;
	
	///return $c_d;
}
	
	
	function course_ctgy_ajaxprice($cond){
		$this->db->select("*");
		$this->db->from("course_fee");
		$this->db->where($cond);
		$data =  $this->db->get()->row_array();
		return $data['name'];exit;
	}
	
	
	function get_pr_details($id){
		$this->db->select(' student_price.*,admission_form.name, admission_form.username, admission_form.mobile, admission_form.mail_id');
		$this->db->from('student_price');
		$this->db->join('admission_form',' student_price.user_id = admission_form.username');
		$this->db->where('student_price.id',$id);
		$query = $this->db->get();
		$s_p =  $query->row();	
		return $s_p;
		
	}
	
	
		function get_student_sr($cond){
		$this->db->select("*");
		$this->db->from("admission_form");
		$this->db->where($cond);
		$this->db->order_by('name','ASC');
		$data =  $this->db->get()->result();
		return $data;
	}
	
}
