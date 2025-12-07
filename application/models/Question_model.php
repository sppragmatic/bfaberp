<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question_model extends CI_Model
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
	
	
	public function set_message_delimiters($start_delimiter, $end_delimiter)
	{
		$this->message_start_delimiter = $start_delimiter;
		$this->message_end_delimiter   = $end_delimiter;

		return TRUE;
	}
	public function set_error($error)
	{
		$this->errors[] = $error;

		return $error;
	}
	public function set_message($message)
	{
		$this->messages[] = $message;

		return $message;
	}
	
	
	public function edit_question($id = NULL)
	{				
		$query  = $this->db->get_where('question',array('id =' => $id))->row_array();		  
		return $query;	
	}
	 
	public function  questions(){
			
		$this->db->select('question.*, sections.name as section');
		$this->db->from('question');		 
		$this->db->join('sections', 'question.id_section = sections.id');
		$this->db->limit(10);		
		$query = $this->db->get();
		return $query->result(); 
	 }
	 
	 
	 	public function  sec_questions($id_section){
			
		$this->db->select('question.*, sections.name as section');
		$this->db->from('question');
		$this->db->join('sections', 'question.id_section = sections.id');
		$this->db->where('question.id_section', $id_section);
		$this->db->ORDER_BY('question.appear_order','ASC');
		//$this->db->limit(10);		
		$query = $this->db->get();
		return $query->result(); 
	 }
	 
	 
	 
	 function exam_sesquestions($id_section){
	 	$this->db->select('question.*, sections.name as section');
		$this->db->from('question');		 
		$this->db->join('sections', 'question.id_section = sections.id');
		$this->db->join('exam', 'question.exam_id = exam.id');
		$this->db->where('question.id_section', $id_section);
		$this->db->ORDER_BY('question.appear_order','ASC');
		$this->db->limit(10);
		$query = $this->db->get();
		return $query->result(); 
	 }
	 
	 
	  function exam_questions($id_section){
	 	$this->db->select('question.*, sections.name as section');
		$this->db->from('question');		 
		$this->db->join('sections', 'question.id_section = sections.id');
		$this->db->where('question.id_section', $id_section);
		$this->db->ORDER_BY('question.sort','ASC');
		//$this->db->where('question.section_id', $section_id);
		$query = $this->db->get();
		return $query->result(); 
	 }
	 
	 
	 
	  function get_section(){
		 $this->db->select("*");
		 $this->db->from("sections");	
		 $this->db->ORDER_BY("id","DESC");
		return  $this->db->get()->result();
		 //$query;
	 	
	 }
	 
	 	 


	  function get_exam(){
		$query = $this->db->get('exam');
		return $query->result();
	 	
	 }



	  function get_exam_type(){
		$query = $this->db->get('exam_type');
		return $query->result();
	 	
	 }	
	
	public function create_question($data)
	{

			$this->db->insert('question', $data);
			$question_id = $this->db->insert_id();

		$this->set_message('Exam  Created!');
		// return the brand new group id
		return $question_id;
	}
	

	function update_question($id,$data){
		$res = $this->db->update('question', $data, array('id' => $id));
		return $res;

	}
	
	function update_examquestion($id, $data){
		
		$num  = $this->db->get_where('cur_question',array('id_question =' => $id))->num_rows();
		//echo $num;exit;
		if($num > 0){
			$res = $this->db->update('cur_question', $data, array('id_question' => $id));
		}
		
		
		$res = $this->db->update('examsection_questions', $data, array('id_question' => $id));
		return $res;
		
	}
	

	public function delete_question($id){
//		echo "i will delete the type";exit;
		
			$delete  = $this->db->delete('question', array('id' => $id)); 
	}

public function get_examsection($exam_id){

		
		$this->db->select('exam_section.*, sections.id as sec_id, sections.name as section');
		$this->db->from('exam_section');		 
		$this->db->join('sections', 'exam_section.section_id = sections.id');
		$this->db->where('exam_section.exam_id', $exam_id);
		$query = $this->db->get();
		return $query->result(); 
		
		
	

}



	  function get_sortquestions($id_section){
	 	$this->db->select('question.*, sections.name as section');
		$this->db->from('question');		 
		$this->db->join('sections', 'question.id_section = sections.id');
		$this->db->where('question.id_section', $id_section);
		$this->db->ORDER_BY('question.sort','ASC');
		//$this->db->where('question.section_id', $section_id);
		$query = $this->db->get();
		return $query->result(); 
	 }



	
}
