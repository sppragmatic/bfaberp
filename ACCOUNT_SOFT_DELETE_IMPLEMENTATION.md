# Account Module Soft Delete Implementation

## Overview
The Account module has been enhanced to implement comprehensive soft delete functionality, ensuring data integrity while maintaining historical records for audit and reporting purposes.

## Database Schema Requirements

To fully support the soft delete functionality, ensure your database tables have the following columns:

### 1. Account Table (`account`)
```sql
ALTER TABLE `account` 
ADD COLUMN `trash` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '0=Active, 1=Deleted',
ADD COLUMN `is_deleted` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Additional delete flag',
ADD COLUMN `deleted_at` DATETIME NULL COMMENT 'Timestamp when record was deleted',
ADD COLUMN `deleted_by` VARCHAR(100) NULL COMMENT 'User who deleted the record';

-- Create indexes for better performance
CREATE INDEX idx_account_trash ON account(trash);
CREATE INDEX idx_account_deleted ON account(is_deleted);
```

### 2. Purchase Account Table (`purchase_account`)
```sql
ALTER TABLE `purchase_account` 
ADD COLUMN `trash` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '0=Active, 1=Deleted',
ADD COLUMN `is_deleted` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Additional delete flag',
ADD COLUMN `deleted_at` DATETIME NULL COMMENT 'Timestamp when record was deleted',
ADD COLUMN `deleted_by` VARCHAR(100) NULL COMMENT 'User who deleted the record';

-- Create indexes for better performance
CREATE INDEX idx_purchase_account_trash ON purchase_account(trash);
CREATE INDEX idx_purchase_account_deleted ON purchase_account(is_deleted);
```

### 3. Party Table (`party`)
```sql
ALTER TABLE `party` 
ADD COLUMN `trash` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '0=Active, 1=Deleted',
ADD COLUMN `is_deleted` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Additional delete flag',
ADD COLUMN `deleted_at` DATETIME NULL COMMENT 'Timestamp when record was deleted',
ADD COLUMN `deleted_by` VARCHAR(100) NULL COMMENT 'User who deleted the record';

-- Create indexes for better performance
CREATE INDEX idx_party_trash ON party(trash);
CREATE INDEX idx_party_deleted ON party(is_deleted);
```

## Implementation Details

### Soft Delete Methods Enhanced

#### 1. **Account Deletion (`delete`)**
```php
Features:
- Checks if account exists and is not already deleted
- Prevents deletion of approved accounts (status = 1)
- Transaction-safe deletion of both account and related purchase_account
- Comprehensive audit trail
- Proper error handling and user feedback
```

#### 2. **Party Deletion (`delete_party`)**
```php
Features:
- Validates party existence before deletion
- Checks for related records (accounts, payments) before allowing deletion
- Prevents deletion if party has active account records
- Audit trail with user and timestamp information
```

#### 3. **Payment Deletion (`delete_payment`)**
```php
Features:
- Verifies payment record exists and is not deleted
- Updates both status and trash flags
- Complete audit trail implementation
- Transaction safety and error handling
```

### Listing Methods Updated

All listing and search methods have been updated to exclude deleted records:

#### 1. **Account Listings**
- `view_account()` - Only shows non-deleted accounts
- `search_account()` - Filters out deleted accounts from search results
- `adminsearch_account()` - Admin search excludes deleted records

#### 2. **Party Listings**
- `party()` - Shows only active parties
- All party-related dropdowns exclude deleted parties

#### 3. **Payment Listings**
- `view_payment()` - Only displays active payment records
- `search_payment()` - Filters deleted payments from search

#### 4. **Report Methods**
- `getreport()` - Excludes deleted records from financial reports
- All reporting methods filter out soft-deleted data

### Edit Methods Enhanced

#### Account Editing (`edit_account`)
- Validates that account exists and is not deleted before allowing edits
- Prevents editing of deleted records
- Enhanced error messages for deleted record access attempts

## Business Rules Implemented

### 1. **Referential Integrity Protection**
```php
// Party deletion checks for related records
if ($has_accounts || $has_payments) {
    $this->session->set_flashdata('error', 'Cannot delete party as it has related account records');
    return;
}
```

### 2. **Approved Account Protection**
```php
// Prevent deletion of approved accounts
if (isset($account['status']) && $account['status'] == 1) {
    $this->session->set_flashdata('error', 'Cannot delete approved account records');
    return;
}
```

### 3. **Cascade Soft Delete**
```php
// When deleting account, also soft delete related purchase_account
$this->db->update('purchase_account', $purchase_update, ['invid' => $account['trans_no']]);
```

## Audit Trail Features

### 1. **Complete Tracking**
Every soft delete operation records:
- **deleted_at**: Exact timestamp of deletion
- **deleted_by**: User who performed the deletion
- **trash**: Primary soft delete flag
- **is_deleted**: Additional delete flag for flexibility

### 2. **User Accountability**
```php
$update_data = [
    'trash' => 1,
    'is_deleted' => 1,
    'deleted_at' => date('Y-m-d H:i:s'),
    'deleted_by' => $this->session->userdata('identity')
];
```

## Query Filtering Implementation

### All Active Record Queries Include:
```php
$this->db->where('table.trash', 0); // Exclude deleted records
```

### JOIN Queries Filter Both Tables:
```php
$this->db->where('account.trash', 0);     // Exclude deleted accounts
$this->db->where('party.trash', 0);      // Exclude deleted parties
```

## Benefits

### 1. **Data Preservation**
- No permanent data loss
- Historical records maintained for auditing
- Ability to restore deleted records if needed

### 2. **Compliance**
- Audit trail for regulatory compliance
- User accountability for all delete operations
- Timestamp tracking for all deletions

### 3. **Business Continuity**
- Referential integrity protection
- Prevents accidental deletion of critical records
- Maintains data relationships

### 4. **User Experience**
- Clear error messages for delete operations
- Proper feedback for successful/failed deletions
- Protection against invalid delete attempts

## Administrative Operations

### View Deleted Records
```sql
-- View all deleted accounts
SELECT * FROM account WHERE trash = 1;

-- View deletion audit trail
SELECT id, trans_no, deleted_at, deleted_by 
FROM account 
WHERE trash = 1 
ORDER BY deleted_at DESC;
```

### Restore Deleted Records
```sql
-- Restore a deleted account (admin operation)
UPDATE account 
SET trash = 0, is_deleted = 0, deleted_at = NULL, deleted_by = NULL 
WHERE id = 123;

-- Restore related purchase account
UPDATE purchase_account 
SET trash = 0, is_deleted = 0, deleted_at = NULL, deleted_by = NULL 
WHERE invid = 'BFABPU001';
```

### Permanent Cleanup (Use with Caution)
```sql
-- Permanently delete very old records (yearly cleanup)
DELETE FROM account 
WHERE trash = 1 
AND deleted_at < DATE_SUB(NOW(), INTERVAL 2 YEAR);

DELETE FROM purchase_account 
WHERE trash = 1 
AND deleted_at < DATE_SUB(NOW(), INTERVAL 2 YEAR);
```

## Error Handling

### 1. **Transaction Safety**
All delete operations use database transactions to ensure data consistency.

### 2. **Validation Checks**
- Record existence validation
- Delete permission checks
- Relationship validation before deletion

### 3. **User Feedback**
- Success messages for completed operations
- Error messages for failed operations
- Informative messages for business rule violations

## Migration Notes

### 1. **Backward Compatibility**
- Existing records work without modification (trash defaults to 0)
- All current functionality preserved
- No breaking changes to existing code

### 2. **Model Updates Required**
Update corresponding model methods to respect soft delete flags:
```php
// In account_model.php
public function get_allaccount($branch_id, $include_deleted = false) {
    $this->db->where('branch_id', $branch_id);
    if (!$include_deleted) {
        $this->db->where('trash', 0);
    }
    return $this->db->get('account')->result_array();
}
```

This comprehensive soft delete implementation ensures data integrity, provides audit trails, and maintains business rule compliance while preserving all existing functionality.