<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gst_model extends CI_Model
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

/////// end of the package mangement

function get_fyr(){
			$data =  $this->db->get_where('year',array('status'=>1))->row_array();
		    return $data['id'];
		}


function create_sales($data){
			$this->db->insert('gst', $data);
			$sales_id = $this->db->insert_id();
			return $sales_id;
}

function create_payment($data){
			$this->db->insert('gst_account', $data);
			$sales_id = $this->db->insert_id();
			return $sales_id;
}


function create_customer($data){
			$this->db->insert('customer', $data);
			$customer_id = $this->db->insert_id();
			return $customer_id;
}


function get_details($invid){
//  $invid = $_REQUEST['invid'];
	$query  = $this->db->get_where('gst',array('sl_no =' => $invid))->row_array();
	$id = $query['id'];
	$this->db->select('gst_item.*,product.name');
	$this->db->from('gst_item');
	$this->db->join('product','gst_item.product_id=product.id');
	$this->db->where('gst_item.sales_id',$id);
	$result =  $this->db->get()->result_array();
$html = '';
foreach ($result as  $rs) {
if($rs['stock']>0){
	$html = $html."<p> SIZE : ".$rs['name']."<b>(".$rs['stock'].")</b> </p>";
}
}
return $html;
}


	function get_proditem($id){
		$this->db->select('gst_item.*,product.name');
		$this->db->from('gst_item');
		$this->db->join('product','gst_item.product_id=product.id');
		$this->db->where('gst_item.sales_id',$id);
		return $this->db->get()->result_array();
		}



function  print_sales($id){
		$year_id = $this->get_fyr();
		$this->db->select('gst.*,customer.name as customername');
		$this->db->from('gst');
		$this->db->join('customer','gst.customer_id=customer.id');
		//$this->db->where('year_id',$year_id);
		$this->db->where('gst.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	 }


	function  get_allsales($branch_id){
		$year_id = $this->get_fyr();
		$this->db->select('gst.*,customer.name as customername');
		$this->db->from('gst');
		$this->db->join('customer','gst.customer_id=customer.id');
		$this->db->where('gst.branch_id',$branch_id);
		$this->db->order_by('gst.bill_date',"DESC");
		$query = $this->db->get();
		return $query->result_array();
	 }



	 function  get_allsalespage($id,$branch_id){
		 $year_id = $this->get_fyr();

		 if($id<=1 && $id==""){
	 		$ids=0;
	 	}else{
	 	$ids = $id-1;
	 	}
	 	//echo $ids;


		 $this->db->select('gst.*,customer.name as customername');
		 $this->db->from('gst');
		 $this->db->join('customer','gst.customer_id=customer.id');
		 $this->db->limit(20,$ids*20);
		 $this->db->ORDER_BY('gst.id','DESC');
		 $this->db->where('gst.branch_id',$branch_id);
		 $this->db->order_by('gst.bill_date',"DESC");
		 $query = $this->db->get();
		 return $query->result_array();
		}




	 function  get_allpayments($branch_id){
		 $year_id = $this->get_fyr();
		 $this->db->select('gst_account.*,customer.name as customername');
		 $this->db->from('gst_account');
		 $this->db->join('customer','gst_account.customer_id=customer.id');
		 //$this->db->where('year_id',$year_id);
		 $this->db->where('gst_account.branch_id',$branch_id);
		 $this->db->limit('50');
		 $this->db->order_by('id',"DESC");
		 $query = $this->db->get();
		 return $query->result_array();
		}

	 function  admin_allsales($id,$branch_id){

		 if($id<=1 && $id==""){
			$ids=0;
		}else{
		$ids = $id-1;
		}

		$year_id = $this->get_fyr();
		$this->db->select('gst.*,customer.name as customername');
		$this->db->from('gst');
		$this->db->join('customer','gst.customer_id=customer.id');
		$this->db->limit(20,$ids*20);
		$this->db->ORDER_BY('gst.id','DESC');
		//$this->db->where('year_id',$year_id);
	//	$this->db->order_by('gst.bill_date');
		//$this->db->limit('50');
		$this->db->order_by('gst.bill_date',"DESC");
		$query = $this->db->get();
		return $query->result_array();
	 }


	 function get_uncustomersales($code){
		$res = $this->db->query("SELECT gst.* , customer.name as pnme, customer.contact_no FROM `sales`,`customer` WHERE gst.customer_name=customer.code AND gst.customer_name='$code' ");
		$customer = $res->result_array();
	return $customer;

	 }

	 function get_receipt($code){
		$res = $this->db->query("SELECT gst.* , customer.name as pnme, customer.contact_no,branch.code as br_code  FROM `sales`,`customer`,`branch` WHERE  gst.branch_id=branch.id AND  gst.customer_name=customer.code AND gst.id='$code' ");
		$customer = $res->row_array();
		return $customer;
	 }


	function  get_allcustomersales(){
	$all_p = array();
		$res = $this->db->query("SELECT DISTINCT(gst.customer_name) as p_c, customer.name as pnme FROM `sales`,`customer` WHERE gst.customer_name=customer.code");
		$customer = $res->result_array();

		foreach($customer as $pr){

			$res1 = $this->db->query("SELECT SUM(amount) as credit FROM `sales`  WHERE gst.type=1 AND gst.customer_name='{$pr['p_c']}'");
			$credit = $res1->row_array();
		if($credit['credit'] !=''){

			$pr['credit'] = $credit['credit'];
		}else{

			$pr['credit'] = 0;
		}


			$res2 = $this->db->query("SELECT SUM(amount) as debit FROM `sales`  WHERE gst.type=2 AND gst.customer_name='{$pr['p_c']}'");
			$debit = $res2->row_array();





			if($debit['debit'] !=''){

			$pr['debit'] = $debit['debit'];
		}else{

			$pr['debit'] = 0;
		}



	$all_p[] = $pr;

		}

return $all_p;



	}



function get_customer(){
		$this->db->select('*');
		$this->db->from('customer');
		$this->db->order_by('id',"DESC");
		$query = $this->db->get();
		return $query->result_array();
}
function get_branch(){
		$this->db->select('*');
		$this->db->from('branch');
		$this->db->order_by('id',"DESC");
		$query = $this->db->get();
		return $query->result_array();
}

	function  get_allcustomer(){
		$this->db->select('*');
		$this->db->from('customer');
		//$this->db->limit('50');
		$this->db->order_by('id',"DESC");
		$query = $this->db->get();
		return $query->result_array();
	 }


	public function edit_sales($id = NULL)
	{
		$query  = $this->db->get_where('gst',array('id =' => $id))->row_array();
		return $query;
	}


	public function edit_payment($id = NULL)
	{
		$query  = $this->db->get_where('gst_account',array('id =' => $id))->row_array();
		return $query;
	}

function edit_customer($id){
		$query  = $this->db->get_where('customer',array('id =' => $id))->row_array();
		return $query;
}



public function update_payment($id, $data){
 $res = $this->db->update('gst_account', $data, array('id' => $id));
 return $res;

}

	 public function update_sales($id, $data){
	 	$res = $this->db->update('gst', $data, array('id' => $id));
		return $res;

	 }



	 public function update_customer($id, $data){
	 	$res = $this->db->update('customer', $data, array('id' => $id));
		return $res;

	 }


	public function delete_sales($id){
			$delete  = $this->db->delete('gst', array('id' => $id));
			return $delete;
	}

	// Product Type management
		function get_brcode($id){
			$data['id'] = $id;
			$code =  $this->db->get_where('branch',$data)->row_array();
			return $code['code'];
		}



	function get_br($branch_id){
			$sql = "SELECT COUNT(id) AS c_id FROM sales WHERE branch_id={$branch_id}";
			$res = $this->db->query($sql);
			$count = $res->row_array();
			return $count['c_id']+1;

		}


		function get_pr(){
			$sql = "SELECT COUNT(id) AS c_id FROM customer";
			$res = $this->db->query($sql);
			$count = $res->row_array();
			return $count['c_id']+1;

		}


	function view_details($entry_date){
		$this->db->select('gst.*');
		$this->db->from('gst');
		$this->db->where('entry_date',$entry_date);
		$this->db->order_by('id',"DESC");
		$query = $this->db->get();
		return $query->result_array();
	}



	function get_report($start_date, $end_date){

	$sql = "SELECT entry_date FROM `sales` WHERE `entry_date` > '$start_date' AND  `entry_date` < '$end_date' GROUP BY entry_date";
		$res = $this->db->query($sql);
			$p_d = $res->result_array();

$all_data = array();
	foreach($p_d as $pp){
	$edd= $pp['entry_date'];
	$sql1 = "SELECT SUM(amount) AS credit FROM `sales` WHERE `entry_date` = '$edd' AND `type`=1";
	$res1 = $this->db->query($sql1);
	$credit = $res1->row_array();


	$sql2 = "SELECT SUM(amount) AS debit FROM `sales` WHERE `entry_date` = '$edd' AND `type`=2";
	$res2 = $this->db->query($sql2);
	$debit = $res2->row_array();



	if(isset($credit['credit'])){
		$pp['credit'] = $credit['credit'];
	}else{
		$pp['credit'] = 0;
	}


	if(isset($debit['debit'])){
		$pp['debit'] = $debit['debit'];
	}else{
		$pp['debit'] = 0;
	}

$all_data[] = $pp;


	}
return $all_data;


	}




	function  get_sales_report($start_date, $end_date, $type, $customer_id, $year_id){

		$this->db->select('*');
		$this->db->from('gst');
		$this->db->where("year_id",$year_id);
		if($type!='0'){
			$this->db->where('type', $type);
		}
		if($customer_id != '0'){
			$this->db->where('customer_name', $customer_id);

		}
		if($start_date !='0' && $end_date !='0'){
			$this->db->where( "`entry_date` >= '$start_date' AND  `entry_date` <= '$end_date'");
		}

			$p_d = $this->db->get()->result_array();
//echo $this->db->last_query();exit;
		return $p_d;



	}



	}
