<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_labour extends CI_Controller {

    /**
     * Labour group model
     *
     * @var object
     */
    public $Labour_group_model;

    public function __construct() {
        parent::__construct();
        // Only load what we absolutely need
        $this->load->model('Labour_group_model');
    }

    public function index() {
        echo "<h2>Labour Group Test Controller</h2>";
        echo "<p>✅ Controller loaded successfully!</p>";
        
        try {
            // Test model loading
            $groups = $this->Labour_group_model->get_all_labour_groups();
            echo "<p>✅ Model loaded successfully!</p>";
            echo "<p>Found " . count($groups) . " labour groups</p>";
            
            if (count($groups) > 0) {
                echo "<h3>Labour Groups:</h3><ul>";
                foreach ($groups as $group) {
                    echo "<li>" . $group['name'] . " (ID: " . $group['id'] . ")</li>";
                }
                echo "</ul>";
            }
            
            echo "<p><a href='/erp/index.php/admin/labour_group'>Try the full Labour Group module</a></p>";
            
        } catch (Exception $e) {
            echo "<p>❌ Error: " . $e->getMessage() . "</p>";
        }
    }
}
?>