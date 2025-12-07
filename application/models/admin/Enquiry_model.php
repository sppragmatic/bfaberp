<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Enquiry_model extends CI_Model
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
		$this->load->library('session');
	
	}
	

		function insert_enquiry($data){
			$this->db->insert('enquiry',$data);
			$this->session->set_flashdata('msg','Your Enquiry Created Successfully');
			return $this->db->insert_id();
		}

		function get_allenquiry(){
			$this->db->select('enquiry.*,course.name AS course_name');
			$this->db->from('enquiry');
			$this->db->join('course','enquiry.course_id=course.id');
			$this->db->order_by('id','DESC');	
			$this->db->limit(50);
			return $this->db->get()->result();
		}

		function get_allcourse(){
			return $this->db->get('course')->result();
		}
		
		function get_enquiry($id=NULL){
		return $this->db->get_where('enquiry',array('id'=>$id))->row();
		}
		
		function update_enquiry($data,$id){
			$this->db->update('enquiry',$data,array('id'=>$id));
			$this->session->set_flashdata('msg','Your Enquiry Updated Successfully');
		}
		
		function delete_enquiry($id){
			$this->db->delete('enquiry',array('id'=>$id));
			$this->session->set_flashdata('msg','Your Enquiry Deleted Successfully');
		}

		/* course category start here*/	
}
