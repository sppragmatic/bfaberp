<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	/**
	 * Reference to the CI singleton
	 *
	 * @var	object
	 */
	private static $instance;

	/**
	 * CI_Loader
	 *
	 * @var	CI_Loader
	 */
	public $load;

	/**
	 * Benchmark class
	 *
	 * @var	object
	 */
	public $benchmark;

	/**
	 * Hooks class
	 *
	 * @var	object
	 */
	public $hooks;

	/**
	 * Config class
	 *
	 * @var	object
	 */
	public $config;

	/**
	 * Log class
	 *
	 * @var	object
	 */
	public $log;

	/**
	 * UTF-8 class
	 *
	 * @var	object
	 */
	public $utf8;

	/**
	 * URI class
	 *
	 * @var	object
	 */
	public $uri;

	/**
	 * Router class
	 *
	 * @var	object
	 */
	public $router;

	/**
	 * Output class
	 *
	 * @var	object
	 */
	public $output;

	/**
	 * Security class
	 *
	 * @var	object
	 */
	public $security;

	/**
	 * Input class
	 *
	 * @var	object
	 */
	public $input;

	/**
	 * Lang class
	 *
	 * @var	object
	 */
	public $lang;

	/**
	 * Database class (loaded by auto-loader)
	 *
	 * @var	object
	 */
	public $db;

	/**
	 * Session class (loaded by library)
	 *
	 * @var	object
	 */
	public $session;

	/**
	 * Email class (loaded by library)
	 *
	 * @var	object
	 */
	public $email;

	/**
	 * Form validation class (loaded by library)
	 *
	 * @var	object
	 */
	public $form_validation;

	/**
	 * Ion Auth library (loaded by library)
	 *
	 * @var	object
	 */
	public $ion_auth;

	/**
	 * Pagination library (loaded by library)
	 *
	 * @var	object
	 */
	public $pagination;

	/**
	 * Upload library (loaded by library)
	 *
	 * @var	object
	 */
	public $upload;

	/**
	 * Image library (loaded by library)
	 *
	 * @var	object
	 */
	public $image_lib;

	/**
	 * Cart library (loaded by library)
	 *
	 * @var	object
	 */
	public $cart;

	/**
	 * Calendar library (loaded by library)
	 *
	 * @var	object
	 */
	public $calendar;

	/**
	 * User agent library (loaded by library)
	 *
	 * @var	object
	 */
	public $agent;

	/**
	 * XML-RPC library (loaded by library)
	 *
	 * @var	object
	 */
	public $xmlrpc;

	/**
	 * Zip library (loaded by library)
	 *
	 * @var	object
	 */
	public $zip;

	/**
	 * MongoDB library (loaded by library)
	 *
	 * @var	object
	 */
	public $mongo_db;

	/**
	 * Migration library (loaded by library)
	 *
	 * @var	object
	 */
	public $migration;

	/**
	 * Unit test library (loaded by library)
	 *
	 * @var	object
	 */
	public $unit;

	/**
	 * Profiler library (loaded by library)
	 *
	 * @var	object
	 */
	public $profiler;

	/**
	 * Parser library (loaded by library)
	 *
	 * @var	object
	 */
	public $parser;

	/**
	 * Table library (loaded by library)
	 *
	 * @var	object
	 */
	public $table;

	/**
	 * Trackback library (loaded by library)
	 *
	 * @var	object
	 */
	public $trackback;

	/**
	 * Typography library (loaded by library)
	 *
	 * @var	object
	 */
	public $typography;

	/**
	 * FTP library (loaded by library)
	 *
	 * @var	object
	 */
	public $ftp;

	/**
	 * Encryption library (loaded by library)
	 *
	 * @var	object
	 */
	public $encrypt;

	/**
	 * Encryption library (CI 3.x)
	 *
	 * @var	object
	 */
	public $encryption;

	/**
	 * Ion Auth model (loaded by model)
	 *
	 * @var	object
	 */
	public $ion_auth_model;

	/**
	 * Exceptions class
	 *
	 * @var	object
	 */
	public $exceptions;

	// Common Model Properties
	/**
	 * Admin model
	 *
	 * @var	object
	 */
	public $admin_model;

	/**
	 * Common model
	 *
	 * @var	object
	 */
	public $common_model;

	/**
	 * Branch model
	 *
	 * @var	object
	 */
	public $branch_model;

	/**
	 * Payment model
	 *
	 * @var	object
	 */
	public $payment_model;

	/**
	 * Account model
	 *
	 * @var	object
	 */
	public $account_model;

	/**
	 * Production model
	 *
	 * @var	object
	 */
	public $production_model;

	/**
	 * Sales model
	 *
	 * @var	object
	 */
	public $sales_model;

	/**
	 * Stock model
	 *
	 * @var	object
	 */
	public $stock_model;

	/**
	 * Stock model (uppercase S)
	 *
	 * @var	object
	 */
	public $Stock_model;

	/**
	 * Labour group model
	 *
	 * @var	object
	 */
	public $Labour_group_model;

	/**
	 * Product model
	 *
	 * @var	object
	 */
	public $product_model;

	/**
	 * Material model
	 *
	 * @var	object
	 */
	public $material_model;

	/**
	 * Purchase model
	 *
	 * @var	object
	 */
	public $purchase_model;

	/**
	 * Consumption model
	 *
	 * @var	object
	 */
	public $consumption_model;

	/**
	 * GST model
	 *
	 * @var	object
	 */
	public $gst_model;

	/**
	 * Report model
	 *
	 * @var	object
	 */
	public $report_model;

	/**
	 * Question model
	 *
	 * @var	object
	 */
	public $question_model;

	/**
	 * Admission model
	 *
	 * @var	object
	 */
	public $admission_model;

	/**
	 * Course model
	 *
	 * @var	object
	 */
	public $course_model;

	/**
	 * Enquiry model
	 *
	 * @var	object
	 */
	public $enquiry_model;

	/**
	 * Batch model
	 *
	 * @var	object
	 */
	public $batch_model;

	/**
	 * Data array for views
	 *
	 * @var	array
	 */
	public $data;

	/**
	 * Header data for views
	 *
	 * @var	array
	 */
	public $header;

	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();
		log_message('info', 'Controller Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Get the CI singleton
	 *
	 * @static
	 * @return	object
	 */
	public static function &get_instance()
	{
		return self::$instance;
	}

}
