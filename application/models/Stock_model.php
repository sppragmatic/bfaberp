<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock_model extends CI_Model
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



		function get_branch(){
			return $this->db->get('branch')->result_array();
		}

		function get_product(){
				return $this->db->get('product')->result_array();
			}


		function get_stock($cond){
			$this->db->select('*');
		$this->db->from('stock');
		$this->db->where($cond);
		$query = $this->db->get();
		$num = $query->num_rows();
		if($num==0){
				$st = $stock = 0;
		}else{
				$stock = $query->row_array();
				$st=$stock['stock'];
		}

		return  $st;
		}


		function get_material(){
				return $this->db->get('material')->result_array();
			}


		function get_matstock($cond){
			$this->db->select('*');
		$this->db->from('material_stock');
		$this->db->where($cond);
		$query = $this->db->get();
		$num = $query->num_rows();
		if($num==0){
				$st = $stock = 0;
		}else{
				$stock = $query->row_array();
				$st=$stock['stock'];
		}

		return  $st;
		}

		//get_branch

		/**
		 * Stock Adjustment Methods
		 */

		/**
		 * Count total stock adjustments for pagination
		 */
		function count_adjustments($branch_id = null) {
			$this->db->select('COUNT(id) as total');
			$this->db->from('stock_adjustments');
			$this->db->where('deleted', 0);
			
			if ($branch_id) {
				$this->db->where('branch_id', $branch_id);
			}
			
			$query = $this->db->get();
			$result = $query->row_array();
			return $result['total'];
		}

		/**
		 * Get stock adjustments with pagination
		 */
		function get_adjustments($page = null, $branch_id = null, $per_page = 20) {
			$offset = $page ? ($page - 1) * $per_page : 0;
			
			$this->db->select('sa.*, p.name as product_name, u.username as created_by_name');
			$this->db->from('stock_adjustments sa');
			$this->db->join('product p', 'sa.product_id = p.id', 'left');
			$this->db->join('users u', 'sa.created_by = u.id', 'left');
			$this->db->where('sa.deleted', 0);
			
			if ($branch_id) {
				$this->db->where('sa.branch_id', $branch_id);
			}
			
			$this->db->order_by('sa.created_at', 'DESC');
			$this->db->limit($per_page, $offset);
			
			$query = $this->db->get();
			return $query->result_array();
		}

		/**
		 * Create new stock adjustment
		 */
		function create_adjustment($data) {
			$this->db->insert('stock_adjustments', $data);
			return $this->db->insert_id();
		}

		/**
		 * Get single adjustment by ID
		 */
		function get_adjustment_by_id($id) {
			$this->db->select('sa.*, p.name as product_name, u.username as created_by_name');
			$this->db->from('stock_adjustments sa');
			$this->db->join('product p', 'sa.product_id = p.id', 'left');
			$this->db->join('users u', 'sa.created_by = u.id', 'left');
			$this->db->where('sa.id', $id);
			$this->db->where('sa.deleted', 0);
			
			$query = $this->db->get();
			return $query->row_array();
		}

		/**
		 * Update adjustment record
		 */
		function update_adjustment($id, $data) {
			$this->db->where('id', $id);
			return $this->db->update('stock_adjustments', $data);
		}

		/**
		 * Get current stock for a product in a branch
		 */
		function get_current_stock($product_id, $branch_id) {
			$cond = array(
				'product_id' => $product_id,
				'branch_id' => $branch_id
			);
			
			$this->db->select('stock');
			$this->db->from('stock');
			$this->db->where($cond);
			
			$query = $this->db->get();
			
			if ($query->num_rows() > 0) {
				$result = $query->row_array();
				return floatval($result['stock']);
			} else {
				// If no stock record exists, create one with 0 stock
				$stock_data = array(
					'product_id' => $product_id,
					'branch_id' => $branch_id,
					'stock' => 0
				);
				$this->db->insert('stock', $stock_data);
				return 0;
			}
		}

		/**
		 * Update stock quantity
		 */
		function update_stock($product_id, $branch_id, $new_quantity) {
			$cond = array(
				'product_id' => $product_id,
				'branch_id' => $branch_id
			);
			
			$update_data = array('stock' => $new_quantity);
			
			// Check if stock record exists
			$this->db->where($cond);
			$query = $this->db->get('stock');
			
			if ($query->num_rows() > 0) {
				// Update existing record
				$this->db->where($cond);
				return $this->db->update('stock', $update_data);
			} else {
				// Insert new record
				$insert_data = array_merge($cond, $update_data);
				return $this->db->insert('stock', $insert_data);
			}
		}

	}
