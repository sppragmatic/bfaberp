<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_approval_status_to_stock_adjustments extends CI_Migration {

    public function up()
    {
        // Add approval status columns
        $fields = array(
            'approval_status' => array(
                'type' => 'ENUM',
                'constraint' => array('pending', 'approved', 'rejected'),
                'default' => 'pending',
                'after' => 'remarks'
            ),
            'approved_by' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => TRUE,
                'after' => 'approval_status'
            ),
            'approved_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
                'after' => 'approved_by'
            ),
            'stock_updated' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'after' => 'approved_at'
            )
        );
        
        $this->dbforge->add_column('stock_adjustments', $fields);
        
        // Add foreign key constraint for approved_by
        if ($this->db->platform() === 'mysql') {
            $this->db->query('ALTER TABLE `stock_adjustments` 
                             ADD CONSTRAINT `fk_stock_adj_approved_by` 
                             FOREIGN KEY (`approved_by`) REFERENCES `users`(`id`) ON DELETE SET NULL');
        }
        
        // Update existing records to have pending status and mark them as stock updated
        $this->db->query("UPDATE stock_adjustments SET approval_status = 'pending', stock_updated = 1 WHERE approval_status IS NULL");
    }

    public function down()
    {
        // Drop foreign key constraint first
        if ($this->db->platform() === 'mysql') {
            $this->db->query('ALTER TABLE `stock_adjustments` DROP FOREIGN KEY `fk_stock_adj_approved_by`');
        }
        
        // Drop columns
        $this->dbforge->drop_column('stock_adjustments', 'approval_status');
        $this->dbforge->drop_column('stock_adjustments', 'approved_by');
        $this->dbforge->drop_column('stock_adjustments', 'approved_at');
        $this->dbforge->drop_column('stock_adjustments', 'stock_updated');
    }
}