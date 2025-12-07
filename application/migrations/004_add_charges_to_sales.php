<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_charges_to_sales extends CI_Migration
{
    public function up()
    {
        // Add transportation_charge, loading_charge, and sub_total fields to sales table
        $fields = array(
            'transportation_charge' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
                'null' => FALSE,
                'after' => 'total_amount'
            ),
            'loading_charge' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
                'null' => FALSE,
                'after' => 'transportation_charge'
            ),
            'sub_total' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
                'null' => FALSE,
                'after' => 'loading_charge'
            )
        );
        
        $this->dbforge->add_column('sales', $fields);
        
        echo "Added transportation_charge, loading_charge, and sub_total columns to sales table\n";
    }

    public function down()
    {
        // Remove the added fields
        $this->dbforge->drop_column('sales', 'transportation_charge');
        $this->dbforge->drop_column('sales', 'loading_charge');
        $this->dbforge->drop_column('sales', 'sub_total');
        
        echo "Removed transportation_charge, loading_charge, and sub_total columns from sales table\n";
    }
}