# Production Loading & Unloading Database Tables

## Overview
This document describes the database tables created to store loading and unloading data with production_id relationships for the ERP production module.

## Table 1: `transport` (Loading Details)

### Purpose
Stores all loading details associated with production records, including quantity, rate, and amount for each product being loaded.

### Table Structure
```sql
CREATE TABLE `transport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `production_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `type` enum('loading','transport') NOT NULL DEFAULT 'loading',
  `branch_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `entry_by` varchar(100) DEFAULT NULL,
  `entry_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
);
```

### Field Descriptions
| Field | Type | Description |
|-------|------|-------------|
| `id` | int(11) | Primary key, auto-increment |
| `production_id` | int(11) | **Foreign key to production table** |
| `product_id` | int(11) | Foreign key to product table |
| `quantity` | decimal(10,2) | Loading quantity |
| `rate` | decimal(10,2) | Rate per unit |
| `amount` | decimal(10,2) | Total amount (quantity × rate) |
| `type` | enum | 'loading' or 'transport' |
| `branch_id` | int(11) | Branch identifier |
| `year_id` | int(11) | Financial year identifier |
| `entry_by` | varchar(100) | User who created record |
| `entry_date` | datetime | Creation timestamp |
| `updated_by` | varchar(100) | User who last updated |
| `updated_at` | datetime | Last update timestamp |
| `is_deleted` | tinyint(1) | Soft delete flag (0=active, 1=deleted) |

### Indexes
- Primary key on `id`
- Index on `production_id` (for fast lookups by production)
- Index on `product_id` (for product-based queries)
- Composite index on `branch_id, year_id`
- Index on `type` (for filtering loading vs transport)
- Index on `is_deleted` (for active records filtering)

---

## Table 2: `fly_ash_unloading` (Unloading Details)

### Purpose
Stores all fly ash unloading details associated with production records, including material, labour group, quantity, rate, and amount for each unloading operation.

### Table Structure
```sql
CREATE TABLE `fly_ash_unloading` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `production_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `labour_group_id` int(11) NOT NULL,
  `qty` decimal(10,2) NOT NULL DEFAULT '0.00',
  `rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `branch_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `entry_by` varchar(100) DEFAULT NULL,
  `entry_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
);
```

### Field Descriptions
| Field | Type | Description |
|-------|------|-------------|
| `id` | int(11) | Primary key, auto-increment |
| `production_id` | int(11) | **Foreign key to production table** |
| `material_id` | int(11) | Foreign key to material table |
| `labour_group_id` | int(11) | Foreign key to labour_groups table |
| `qty` | decimal(10,2) | Unloading quantity |
| `rate` | decimal(10,2) | Rate per unit |
| `amount` | decimal(10,2) | Total amount (qty × rate) |
| `branch_id` | int(11) | Branch identifier |
| `year_id` | int(11) | Financial year identifier |
| `entry_by` | varchar(100) | User who created record |
| `entry_date` | datetime | Creation timestamp |
| `updated_by` | varchar(100) | User who last updated |
| `updated_at` | datetime | Last update timestamp |
| `is_deleted` | tinyint(1) | Soft delete flag (0=active, 1=deleted) |

### Indexes
- Primary key on `id`
- Index on `production_id` (for fast lookups by production)
- Index on `material_id` (for material-based queries)
- Index on `labour_group_id` (for labour group queries)
- Composite index on `branch_id, year_id`
- Index on `is_deleted` (for active records filtering)

---

## Data Relationships

### Loading Data Flow
1. **Production Form** → Loading section with products
2. **Controller** → Processes loading array
3. **Transport Table** → Stores individual loading records
4. **Relationship**: Each loading row linked to production via `production_id`

### Unloading Data Flow
1. **Production Form** → Unloading section with materials/labour
2. **Controller** → Processes unloading array  
3. **Fly Ash Unloading Table** → Stores individual unloading records
4. **Relationship**: Each unloading row linked to production via `production_id`

## Sample Data Structure

### Loading Data Example
```sql
INSERT INTO transport VALUES 
(1, 101, 5, 100.00, 15.50, 1550.00, 'loading', 1, 1, 'admin', NOW(), NULL, NULL, 0),
(2, 101, 3, 50.00, 20.00, 1000.00, 'loading', 1, 1, 'admin', NOW(), NULL, NULL, 0);
```
*Production ID 101 has 2 loading records with different products*

### Unloading Data Example  
```sql
INSERT INTO fly_ash_unloading VALUES
(1, 101, 2, 1, 80.00, 12.75, 1020.00, 1, 1, 'admin', NOW(), NULL, NULL, 0),
(2, 101, 3, 2, 45.00, 18.50, 832.50, 1, 1, 'admin', NOW(), NULL, NULL, 0);
```
*Production ID 101 has 2 unloading records with different materials/labour groups*

## Query Examples

### Get Loading Data for Production
```sql
SELECT t.*, p.name as product_name 
FROM transport t
JOIN product p ON t.product_id = p.id  
WHERE t.production_id = 101 
AND t.type = 'loading' 
AND t.is_deleted = 0;
```

### Get Unloading Data for Production
```sql
SELECT u.*, m.name as material_name, l.name as labour_group_name
FROM fly_ash_unloading u
JOIN material m ON u.material_id = m.id
JOIN labour_groups l ON u.labour_group_id = l.id
WHERE u.production_id = 101 
AND u.is_deleted = 0;
```

### Calculate Total Loading Amount
```sql
SELECT production_id, SUM(amount) as total_loading_amount
FROM transport 
WHERE production_id = 101 
AND type = 'loading' 
AND is_deleted = 0
GROUP BY production_id;
```

### Calculate Total Unloading Amount
```sql
SELECT production_id, SUM(amount) as total_unloading_amount
FROM fly_ash_unloading 
WHERE production_id = 101 
AND is_deleted = 0
GROUP BY production_id;
```

## Installation Steps

1. **Run SQL Script**: Execute `database_tables.sql` in phpMyAdmin or MySQL
2. **Alternative**: Run `create_tables.php` in browser (http://localhost/erp/create_tables.php)
3. **Verify Creation**: Check tables exist with proper structure
4. **Test Integration**: Create/edit production records with loading/unloading data
5. **Validate Data**: Confirm records are stored correctly with production_id relationships

## Benefits

✅ **Normalized Structure**: Separate tables for loading and unloading data  
✅ **Production Relationships**: All data linked via production_id foreign key  
✅ **Audit Trail**: Complete tracking of creation and updates  
✅ **Soft Deletes**: Historical data preservation  
✅ **Performance**: Proper indexing for fast queries  
✅ **Scalability**: Handles multiple loading/unloading records per production  
✅ **Data Integrity**: Structured fields with appropriate data types