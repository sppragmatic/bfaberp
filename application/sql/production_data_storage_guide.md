# Production Loading & Unloading Data Storage Implementation

## Overview
This implementation handles the storage of loading details in the `transport` table and fly ash unloading details in the `fly_ash_unloading` table according to the form fields in both create and edit production pages.

## Database Schema

### Transport Table
Stores loading details with the following structure:
- `id`: Primary key
- `production_id`: Foreign key to production table
- `product_id`: Foreign key to product table  
- `quantity`: Loading quantity
- `rate`: Loading rate per unit
- `amount`: Total amount (qty × rate)
- `type`: 'loading' or 'transport' 
- `branch_id`, `year_id`: Standard tracking fields
- `entry_by`, `entry_date`: Creation tracking
- `updated_by`, `updated_at`: Update tracking
- `is_deleted`: Soft delete flag

### Fly Ash Unloading Table
Stores unloading details with the following structure:
- `id`: Primary key
- `production_id`: Foreign key to production table
- `material_id`: Foreign key to material table
- `labour_group_id`: Foreign key to labour_groups table
- `qty`: Unloading quantity
- `rate`: Unloading rate per unit
- `amount`: Total amount (qty × rate)
- `branch_id`, `year_id`: Standard tracking fields
- `entry_by`, `entry_date`: Creation tracking
- `updated_by`, `updated_at`: Update tracking
- `is_deleted`: Soft delete flag

## Controller Implementation

### Create Production (`create_production()`)

#### Loading Data Processing:
1. Extracts loading items from `$this->input->post('loading')`
2. Calculates loading total amount for production record
3. Calls `_insertLoadingItems()` to store individual loading records in transport table
4. Each loading item includes: product_id, quantity, rate, amount, type='loading'

#### Unloading Data Processing:
1. Extracts unloading items from `$this->input->post('unloading')`
2. Calls `_insertUnloadingItems()` to store individual unloading records
3. Each unloading item includes: material_id, labour_group_id, qty, rate, amount

### Edit Production (`edit_production()`)

#### Data Loading for Edit Form:
1. `_getLoadingItems($id)` - Retrieves existing loading data from transport table
2. `_getUnloadingItems($id)` - Retrieves existing unloading data from fly_ash_unloading table
3. Data is made available to view via `$this->data['loading_items']` and `$this->data['unloading_items']`

#### Data Update Processing:
1. `_updateLoadingItems()` - Soft deletes existing records, inserts new ones
2. `_updateUnloadingItems()` - Soft deletes existing records, inserts new ones
3. Uses transaction to ensure data consistency

## Key Methods

### `_insertLoadingItems($loading_items, $production_id, $branch_id)`
- Processes loading form data array
- Validates quantity > 0 and amount > 0 before insertion
- Inserts records into `transport` table with type='loading'

### `_insertUnloadingItems($unloading_items, $production_id, $branch_id)`
- Processes unloading form data array  
- Validates material_id, labour_group_id, qty, and amount > 0
- Inserts records into `fly_ash_unloading` table

### `_getLoadingItems($production_id)`
- Retrieves existing loading items with product names
- Joins transport and product tables
- Filters by production_id, type='loading', is_deleted=0

### `_getUnloadingItems($production_id)`
- Retrieves existing unloading items with material and labour group names
- Joins fly_ash_unloading, material, and labour_groups tables
- Filters by production_id and is_deleted=0

### `_updateLoadingItems($loading_items, $production_id, $branch_id)`
- Soft deletes existing loading records for the production
- Calls `_insertLoadingItems()` to insert new records
- Maintains audit trail with updated_by and updated_at

### `_updateUnloadingItems($unloading_items, $production_id, $branch_id)`
- Soft deletes existing unloading records for the production  
- Calls `_insertUnloadingItems()` to insert new records
- Maintains audit trail with updated_by and updated_at

## Form Data Structure

### Loading Form Data
```php
$loading_items = [
    'product_id_1' => [
        'quantity' => 100.00,
        'rate' => 15.50,
        'amount' => 1550.00
    ],
    'product_id_2' => [
        'quantity' => 50.00,
        'rate' => 20.00,
        'amount' => 1000.00
    ]
];
```

### Unloading Form Data  
```php
$unloading_items = [
    0 => [
        'material_id' => 1,
        'labour_group_id' => 3,
        'qty' => 80.00,
        'rate' => 12.75,
        'amount' => 1020.00
    ],
    1 => [
        'material_id' => 2,
        'labour_group_id' => 1,
        'qty' => 45.00,
        'rate' => 18.50,
        'amount' => 832.50
    ]
];
```

## Usage Instructions

### Database Setup
1. Run the SQL script: `application/sql/create_transport_unloading_tables.sql`
2. This will create both required tables with proper indexes

### Implementation Status
- ✅ Database schema created
- ✅ Create production loading/unloading data storage implemented
- ✅ Edit production loading/unloading data storage implemented  
- ✅ Data retrieval methods for edit forms implemented
- ✅ Soft delete and update tracking implemented
- ✅ Transaction handling for data consistency

### Testing
1. Create a new production with loading and unloading data
2. Verify records are inserted into transport and fly_ash_unloading tables
3. Edit the production and modify loading/unloading data
4. Verify old records are soft deleted and new records are inserted
5. Check that totals are calculated correctly in production record

## Benefits
1. **Normalized Data**: Loading and unloading details stored in separate tables
2. **Audit Trail**: Complete tracking of who created/updated records and when
3. **Soft Deletes**: Historical data preservation
4. **Transaction Safety**: All operations wrapped in database transactions
5. **Data Validation**: Ensures only meaningful data is stored
6. **Flexible Structure**: Can accommodate additional loading/unloading types in future