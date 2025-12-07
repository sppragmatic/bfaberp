<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('migration');
        
        // Only allow in development environment
        if (ENVIRONMENT !== 'development') {
            show_404();
        }
    }

    public function index()
    {
        echo "<h2>Migration Status</h2>";
        
        $current_version = $this->migration->current();
        
        if ($current_version === FALSE) {
            echo "<p style='color: red;'>Migration failed!</p>";
            echo "<p>Error: " . $this->migration->error_string() . "</p>";
        } else {
            echo "<p style='color: green;'>Migration successful!</p>";
            echo "<p>Current version: " . $current_version . "</p>";
        }
    }

    public function latest()
    {
        echo "<h2>Migrating to Latest Version</h2>";
        
        if ($this->migration->latest() === FALSE) {
            echo "<p style='color: red;'>Migration failed!</p>";
            echo "<p>Error: " . $this->migration->error_string() . "</p>";
        } else {
            echo "<p style='color: green;'>Migration to latest version successful!</p>";
        }
    }

    public function version($version = null)
    {
        if ($version === null) {
            echo "<p>Please specify a version number.</p>";
            return;
        }
        
        echo "<h2>Migrating to Version $version</h2>";
        
        if ($this->migration->version($version) === FALSE) {
            echo "<p style='color: red;'>Migration failed!</p>";
            echo "<p>Error: " . $this->migration->error_string() . "</p>";
        } else {
            echo "<p style='color: green;'>Migration to version $version successful!</p>";
        }
    }
}