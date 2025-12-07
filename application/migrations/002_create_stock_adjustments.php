<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_stock_adjustments extends CI_Migration {

    public function up()
    {
        // Create stock_adjustments table
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'product_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
            'branch_id' => array(
                'type' => 'INT', 
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
            'adjustment_type' => array(
                'type' => 'ENUM',
                'constraint' => array('increase', 'decrease'),
                'default' => 'increase'
            ),
            'quantity' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => FALSE
            ),
            'previous_stock' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ),
            'new_stock' => array(
                'type' => 'DECIMAL', 
                'constraint' => '10,2',
                'default' => 0.00
            ),
            'adjustment_date' => array(
                'type' => 'DATE',
                'null' => FALSE
            ),
            'remarks' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'created_by' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => FALSE
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
                'default' => NULL
            ),
            'deleted' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0
            ),
            'deleted_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
                'default' => NULL
            ),
            'deleted_by' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => TRUE,
                'default' => NULL
            )
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('product_id');
        $this->dbforge->add_key('branch_id');
        $this->dbforge->add_key('adjustment_date');
        $this->dbforge->add_key('created_at');
        
        $this->dbforge->create_table('stock_adjustments');

        // Add foreign key constraints (if your database supports them)
        if ($this->db->platform() === 'mysql') {
            $this->db->query('ALTER TABLE `stock_adjustments` 
                             ADD CONSTRAINT `fk_stock_adj_product` 
                             FOREIGN KEY (`product_id`) REFERENCES `product`(`id`) ON DELETE CASCADE');
            
            $this->db->query('ALTER TABLE `stock_adjustments` 
                             ADD CONSTRAINT `fk_stock_adj_branch` 
                             FOREIGN KEY (`branch_id`) REFERENCES `branch`(`id`) ON DELETE CASCADE');
            
            $this->db->query('ALTER TABLE `stock_adjustments` 
                             ADD CONSTRAINT `fk_stock_adj_created_by` 
                             FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE RESTRICT');
        }
    }

    public function down()
    {
        // Drop foreign key constraints first
        if ($this->db->platform() === 'mysql') {
            $this->db->query('ALTER TABLE `stock_adjustments` DROP FOREIGN KEY `fk_stock_adj_product`');
            $this->db->query('ALTER TABLE `stock_adjustments` DROP FOREIGN KEY `fk_stock_adj_branch`');
            $this->db->query('ALTER TABLE `stock_adjustments` DROP FOREIGN KEY `fk_stock_adj_created_by`');
        }
        
        $this->dbforge->drop_table('stock_adjustments');
    }
}