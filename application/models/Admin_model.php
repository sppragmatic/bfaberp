<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Admin_model extends CI_Model

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

	





	public function  exams(){
		$this->db->select('*');
		$this->db->from('exams');		 
		$this->db->ORDER_BY('id','ASC');
		$this->db->limit(7);
		$query = $this->db->get();
		return $query->result(); 
	 }


	

	public function edit_type($id = NULL)
	{
	$query  = $this->db->get_where('interview_batch',array('id =' => $id))->row();		  
	return $query;
	}

	 function  examtypes(){

		$query = $this->db->get('interview_batch');

		return $query->result();	 

	 }

	

	

	public function create_type($data)

	{

			$this->db->insert('interview_batch', $data);

			$type_id = $this->db->insert_id();

			$this->set_message('Exam Type Created!');

		// return the brand new group id

		return $type_id;

	}

	





	function update_type($id,$data){

		//$data = array('name'=>$name,'description'=>$description);

		$res = $this->db->update('interview_batch', $data, array('id' => $id));

		return $res;



	}

	



	public function delete_type($id){

		$this->db->delete('interview_batch', array('id'=>$id));

		return 1;

	

			//$delete  = $this->db->delete('pages', array('id' => $id)); 

	}

	

	

	

	public function edit_board($id = NULL)

	{

				

	$query  = $this->db->get_where('exam_board',array('id =' => $id))->row();		  

	return $query;

	

	}

	 

	 

	 function examtype(){

	 	$query = $this->db->get('interview_batch');

		return $query->result();	 

	 }

	 

	 function  examboard(){

		$query = $this->db->get('exam_board');

		return $query->result();	 

	 }

	

	

	public function create_board($data)

	{

			$this->db->insert('exam_board', $data);

			$type_id = $this->db->insert_id();



		$this->set_message('Exam Type Created!');

		// return the brand new group id

		return $type_id;

	}

	





	function update_board($id,$name,$type_id, $description){

		$data = array('name'=>$name,'description'=>$description,'type_id'=>$type_id);

		$res = $this->db->update('exam_board', $data, array('id' => $id));

		return $res;



	}

	



	public function delete_board($id){

		$this->db->delete('exam_board', array('id'=>$id));

		return 1;

			//$delete  = $this->db->delete('pages', array('id' => $id)); 

	}





/*start for the classes*/







public function edit_class($id = NULL)

	{

		

		

	$query  = $this->db->get_where('class',array('id =' => $id))->row();		  

	return $query;

	

	}

	 

	 

	 

	 function  classes(){

		$query = $this->db->get('class');

		return $query->result();	 

	 }

	

	

	public function create_class($data)

	{

			$this->db->insert('class', $data);

			$type_id = $this->db->insert_id();

			$this->set_message('Class Created!');

		// return the brand new group id

		return $type_id;

	}

	





	function update_class($id,$data){

		//$data = array('name'=>$name,'description'=>$description);

		$res = $this->db->update('class', $data, array('id' => $id));

		return $res;



	}

	



	public function delete_class($id){

		$this->db->delete('class', array('id'=>$id));

		return 1;

	

			//$delete  = $this->db->delete('pages', array('id' => $id)); 

	}







/*star for the subject*/









/*start for the classes*/







public function edit_subject($id = NULL)

	{

		

		

	$query  = $this->db->get_where('subject',array('id =' => $id))->row();		  

	return $query;

	

	}

	 

	 

	 

	 function  subjects(){

		$query = $this->db->get('subject');

		return $query->result();	 

	 }

	

	

	public function create_subject($data)

	{

			$this->db->insert('subject', $data);

			$type_id = $this->db->insert_id();

			$this->set_message('Subject Created!');

		// return the brand new group id

		return $type_id;

	}

	





	function update_subject($id,$data){

		//$data = array('name'=>$name,'description'=>$description);

		$res = $this->db->update('subject', $data, array('id' => $id));

		return $res;



	}

	



	public function delete_subject($id){

		$this->db->delete('subject', array('id'=>$id));

		return 1;

	

			//$delete  = $this->db->delete('pages', array('id' => $id)); 

	}





	public function edit_district($id = NULL)
	{
		$query  = $this->db->get_where('district',array('id =' => $id))->row();		  
		return $query;
	}

	 function  district(){

		$query = $this->db->get('district');

		return $query->result();	 

	 }

	

	

	public function create_district($data)
	{
			$this->db->insert('district', $data);
			$type_id = $this->db->insert_id();
			$this->set_message('District Type Created!');
		return $type_id;

	}

	





	function update_district($id,$data){
		$res = $this->db->update('district', $data, array('id' => $id));
		return $res;
	}

	



	public function delete_district($id){
		$this->db->delete('district', array('id'=>$id));
		return 1;
	}

	




	public function edit_city($id = NULL)
	{
		$query  = $this->db->get_where('place',array('id =' => $id))->row();		  
		return $query;
	}


 function  place(){
		$query = $this->db->get('place');
		return $query->result();	 
	 }

	public function create_city($data)
	{
			$this->db->insert('place', $data);
			$type_id = $this->db->insert_id();
			$this->set_message('Place Created!');
			return $type_id;

	}



	function update_city($id,$name,$district_id, $description){

		$data = array('name'=>$name,'description'=>$description,'district_id'=>$district_id);

		$res = $this->db->update('place', $data, array('id' => $id));

		return $res;



	}

	

	public function delete_city($id){

		$this->db->delete('place', array('id'=>$id));

		return 1;

			//$delete  = $this->db->delete('pages', array('id' => $id)); 

	}



	 function  get_district(){
		$query = $this->db->get('district');
		return $query->result();	 

	 }







	public function edit_batch($id = NULL)
	{
		$query  = $this->db->get_where('batch',array('id =' => $id))->row();		  
		return $query;
	}


 function  batch(){
		$query = $this->db->get('batch');
		return $query->result();	 
	 }




function get_batch(){

$this->db->select("batch.*,`class`.name as class_name");
$this->db->from('batch');
$this->db->join('class','batch.class_id=class.id');
$query = $this->db->get();
return $query->result();
}

	public function create_batch($data)
	{
			$this->db->insert('batch', $data);
			$batch_id = $this->db->insert_id();
			$this->set_message('Batch Created!');
			return $batch_id;

	}



	function update_batch($id,$data){
		//$data = array('name'=>$name,'description'=>$description);
		$res = $this->db->update('batch', $data, array('id' => $id));
		return $res;
	}

	

	public function delete_batch($id){

		$this->db->delete('batch', array('id'=>$id));

		return 1;

			//$delete  = $this->db->delete('pages', array('id' => $id)); 

	}


function get_class(){

	 	$query = $this->db->get('class');

		return $query->result();	 

	 }


/*start for the classes*/

/* start for the chapter */


	public function edit_chapter($id = NULL)
	{
		$query  = $this->db->get_where('chapter',array('id =' => $id))->row();		  
		return $query;
	}




	 function  get_subject(){
		$query = $this->db->get('subject');
		return $query->result();	 
	 }




	 function  chapter(){
		$query = $this->db->get('chapter');
		return $query->result();	 
	 }




	public function get_chapter(){

		$this->db->select("chapter.*,`subject`.name as subject_name");
		$this->db->from('chapter');
		$this->db->join('subject','chapter.subject_id=subject.id');
		$query = $this->db->get();
		return $query->result();
	}

	public function create_chapter($data)
	{
			$this->db->insert('chapter', $data);
			$chapter_id = $this->db->insert_id();
			$this->set_message('Chapter Created!');
			return $chapter_id;

	}


	function update_chapter($id,$data){
		$res = $this->db->update('chapter', $data, array('id' => $id));
		return $res;
	}

	

	public function delete_chapter($id){
		$this->db->delete('chapter', array('id'=>$id));
		return 1;
	}





/* end of the chapter */

	/**
	 * Settings Management Functions
	 */
	
	/**
	 * Get a specific setting value
	 */
	public function get_setting($key, $default = null)
	{
		$this->db->where('setting_key', $key);
		$query = $this->db->get('system_settings');
		
		if ($query->num_rows() > 0) {
			return $query->row()->setting_value;
		}
		
		return $default;
	}
	
	/**
	 * Update or insert a setting
	 */
	public function update_setting($key, $value)
	{
		$this->db->where('setting_key', $key);
		$query = $this->db->get('system_settings');
		
		if ($query->num_rows() > 0) {
			// Update existing setting
			$this->db->where('setting_key', $key);
			return $this->db->update('system_settings', array(
				'setting_value' => $value,
				'updated_at' => date('Y-m-d H:i:s')
			));
		} else {
			// Insert new setting
			return $this->db->insert('system_settings', array(
				'setting_key' => $key,
				'setting_value' => $value,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')
			));
		}
	}
	
	/**
	 * Get all settings as key-value pairs
	 */
	public function get_all_settings()
	{
		$query = $this->db->get('system_settings');
		$settings = array();
		
		foreach ($query->result() as $row) {
			$settings[$row->setting_key] = $row->setting_value;
		}
		
		return $settings;
	}
	
	/**
	 * Delete a setting
	 */
	public function delete_setting($key)
	{
		$this->db->where('setting_key', $key);
		return $this->db->delete('system_settings');
	}

}
