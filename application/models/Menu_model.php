<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Menu_model extends CI_Model
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
	
	
	public function category($id = NULL)
	{
		
		
	$query  = $this->db->get_where('category',array('id =' => $id))->row();		  
	return $query;
	
	}
	 
	 
	 
	 function  get_menulist(){
		$query = $this->db->get('menu');
		return $query;
	 
	 }
	
	
	public function create_menu($menu, $parent_menu, $link)
	{
			$data = array('menu'=>$menu,'parent_menu'=>$parent_menu, 'link'=>$link);
			
			
			$this->db->insert('menu', $data);
			$menu_id = $this->db->insert_id();
			$this->set_message('Menu is Created!');
		// return the brand new group id
		return $menu_id;
	}
	
	
	function get_parent($id){
		$query  = $this->db->get_where('menu',array('id =' => $id))->row_array();		  
		return $query['menu'];
	}
	
	function edit_menu($id){
		$query  = $this->db->get_where('menu',array('id =' => $id))->row();		  
		return $query;
	}


	function update_menu($id,$menu, $parent_menu, $link){
		$data = array('menu'=>$menu,'parent_menu'=>$parent_menu,'link'=>$link);
		$res = $this->db->update('menu', $data, array('id' => $id));
		return $res;
	}
	
	function delete_menu($id){
		echo "i will delete the data";
		exit;
	}
	
	
	function all_parents(){
				$query = $this->db->get('menu');
				return $query;
	}	
		
}