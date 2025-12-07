<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Production_model extends CI_Model
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



		function get_brcode($id){
			$data['id'] = $id;
			$code =  $this->db->get_where('branch',$data)->row_array();
			return $code['code'];
		}



	function get_br($branch_id, $year_id = null){
		$year_condition = "";
		if ($year_id !== null) {
			$year_condition = " AND year_id = " . intval($year_id);
		}
		
		$sql = "SELECT COUNT(id) AS c_id FROM production WHERE branch_id = ? AND is_deleted = 0" . $year_condition;
		$res = $this->db->query($sql, array($branch_id));
		$count = $res->row_array();
		return $count['c_id']+1;

	}
		function insert_production($data){
			$this->db->insert('production',$data);
			$this->session->set_flashdata('msg','Your production Created Successfully');
			return $this->db->insert_id();
		}


		function get_product(){
			return $this->db->get('product')->result_array();
		}

	function get_allproduction($branch_id, $include_deleted = false, $year_id = null){
		//return $this->db->get('production')->result_array();
		$this->db->select('production.*,branch.name');
	$this->db->from('production');
	$this->db->join('branch','production.branch_id=branch.id');
	$this->db->where('production.branch_id',$branch_id);
	
	// Filter deleted records if specified
	if (!$include_deleted) {
		$this->db->where('production.is_deleted', 0);
	}
	
	// Filter by year if specified
	if ($year_id !== null) {
		$this->db->where('production.year_id', $year_id);
	}
	
	return $this->db->get()->result_array();

	}
	function get_adminproduction($branch_id, $include_deleted = false, $year_id = null){
		//return $this->db->get('production')->result_array();
		$this->db->select('production.*,branch.name');
	$this->db->from('production');
	$this->db->join('branch','production.branch_id=branch.id');
	//$this->db->where('production.branch_id',$branch_id);
	
	// Filter deleted records if specified
	if (!$include_deleted) {
		$this->db->where('production.is_deleted', 0);
	}
	
	// Filter by year if specified
	if ($year_id !== null) {
		$this->db->where('production.year_id', $year_id);
	}
	
	return $this->db->get()->result_array();

	}

		function get_branch(){
				$this->db->select('*');
				$this->db->from('branch');
				$this->db->order_by('id',"DESC");
				$query = $this->db->get();
				return $query->result_array();
				// print_r($query->result_array())
				 //exit;
		}


	function get_proditem($id, $include_deleted = false, $year_id = null, $branch_id = null){
		$this->db->select('prod_item.*,product.name');
		$this->db->from('prod_item');
		$this->db->join('product','prod_item.product_id=product.id');
		$this->db->where('prod_item.production_id',$id);
		
		// Filter deleted records if specified
		if (!$include_deleted) {
			$this->db->where('prod_item.is_deleted', 0);
		}
		
		// Filter by year if specified
		if ($year_id !== null) {
			$this->db->where('prod_item.year_id', $year_id);
		}
		
		// Filter by branch if specified
		if ($branch_id !== null) {
			$this->db->where('prod_item.branch_id', $branch_id);
		}
		
		return $this->db->get()->result_array();
		}


	function get_approvitem($id, $include_deleted = false, $year_id = null, $branch_id = null){
		$this->db->select('prod_item.*,product.name');
		$this->db->from('prod_item');
		$this->db->join('product','prod_item.product_id=product.id');
		$this->db->where('prod_item.production_id',$id);
		$this->db->where('prod_item.status',0);
		
		// Filter deleted records if specified
		if (!$include_deleted) {
			$this->db->where('prod_item.is_deleted', 0);
		}
		
		// Filter by year if specified
		if ($year_id !== null) {
			$this->db->where('prod_item.year_id', $year_id);
		}
		
		// Filter by branch if specified
		if ($branch_id !== null) {
			$this->db->where('prod_item.branch_id', $branch_id);
		}
		
		return $this->db->get()->result_array();
		}


	function get_production($id, $include_deleted = false, $year_id = null, $branch_id = null){
	if($id!==""){
		$this->db->where('id', $id);
		
		// Filter deleted records if specified
		if (!$include_deleted) {
			$this->db->where('is_deleted', 0);
		}
		
		// Filter by year if specified
		if ($year_id !== null) {
			$this->db->where('year_id', $year_id);
		}
		
		// Filter by branch if specified
		if ($branch_id !== null) {
			$this->db->where('branch_id', $branch_id);
		}
		
		return $this->db->get('production')->row_array();
	}else{
		echo '<h2> Something Error  </h2>';
	}
	}		function update_production($data,$id){
			$this->db->update('production',$data,array('id'=>$id));
			$this->session->set_flashdata('msg','Your production Updated Successfully');
		}

		function delete_production($id){
			$this->db->delete('production',array('id'=>$id));
			$this->session->set_flashdata('msg','Your production Deleted Successfully');
		}







}
