<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Common_model extends CI_Model

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

	



	
	
	public function get_branch($id = NULL)
	{
		$query  = $this->db->get_where('branch',array('id =' => $id))->row_array();		  
		return $query;
	}

	public function get_menu($group_id){
		$this->db->select('menu_access.*, menu.name as menu_name');
		$this->db->from('menu_access');		 
		$this->db->join('menu', 'menu_access.menu_id = menu.id');
		$this->db->where('menu_access.group_id = '.$group_id);
		$this->db->where('menu_access.status = 1');
		$menu = $this->db->get()->result_array();
		$menu_list = array();
		foreach($menu as $mn){
			$menu_list[] = $mn['menu_name']	;
		}
	return $menu_list;
	

	}
	
	function get_alert(){
		$num1  = $this->db->get_where('packaging',array('entry_by =' => 1))->num_rows();		  
		$num2  = $this->db->get_where('category',array('entry_by =' => 1))->num_rows();		  
		return $num1+$num2;
		
	}
	
	function getpackage(){
		$package  = $this->db->get_where('packaging',array('entry_by =' => 1))->result_array();		  return $package;
	}

	function getctgy(){
	$category  = $this->db->get_where('category',array('entry_by =' => 1))->result_array();
		return $category;
	}
	
	function get_faultyalert($data){
		$num1  = $this->db->get_where('base_purchase',$data)->num_rows();	
		return $num1;
	}
	
	function get_portname($id){
		$this->db->select('port.*, country.name as country_name');
		$this->db->from('port');		 
		$this->db->join('country', 'port.country_id = country.id');
		$this->db->where('port.id = '.$id);
		$port = $this->db->get()->row_array();
		$name = $port['name'].", ".$port['country_name'];
		return $name;
	}
	
	function get_countryname($id){
		$country  = $this->db->get_where('country',array('id =' => 1))->row_array();
		return $country['name'];
	}
	
	
	function get_fa(){
		
		$this->db->select('year.*');
		$this->db->from('year');		 
		$this->db->where('year.status',1);
		$year = $this->db->get()->row_array();
		return $year['id'];
	}
	
	function get_interview(){
		
		$batch  = $this->db->get('interview_batch')->result();
		return $batch;
	}

}