# Sales Form Enhancement: Transportation & Loading Charges

## Overview
Added Transportation Charge and Loading Charge fields to the sales form to provide better cost tracking and accurate pricing for sales transactions.

## Changes Made

### 1. Database Schema Updates

**Migration File**: `004_add_charges_to_sales.php`
- Added `transportation_charge` DECIMAL(10,2) DEFAULT 0.00
- Added `loading_charge` DECIMAL(10,2) DEFAULT 0.00  
- Added `sub_total` DECIMAL(10,2) DEFAULT 0.00
- All fields added to the `sales` table

### 2. Frontend Changes

#### Add Sales Form (`application/views/sales/add.php`)
**New Fields Added:**
- Sub Total (Products): Shows total of product amounts only
- Transportation Charge: Input field for transportation costs
- Loading Charge: Input field for loading costs  
- Grand Total: Final total including all charges

**Enhanced JavaScript Calculations:**
- `calculateSubTotal()`: Calculates product amounts only
- `calculateGrandTotal()`: Adds transportation and loading charges
- Real-time calculation on input changes
- Input validation to prevent negative values
- Auto-formatting to 2 decimal places

#### Edit Sales Form (`application/views/sales/edit.php`)
- Added same charge fields with pre-populated values
- Identical calculation logic
- Proper data binding from existing sales records

### 3. Backend Changes

#### Sales Controller (`application/controllers/admin/Sales.php`)

**index() Method Updates:**
```php
// Extract charges from form
$transportation_charge = floatval($this->input->post('transportation_charge')) ?: 0;
$loading_charge = floatval($this->input->post('loading_charge')) ?: 0;

// Calculate totals
$sub_total = $toamount; // Products only
$toamount = $toamount + $transportation_charge + $loading_charge; // Grand total

// Add to database fields
$sales_data = array(
    // ... existing fields ...
    'transportation_charge' => $transportation_charge,
    'loading_charge' => $loading_charge,
    'sub_total' => $sub_total,
);
```

**edit_sales() Method:**
- Applied identical logic for editing existing sales
- Proper handling of charge updates in total calculations

### 4. Form Structure

**Before:**
```
Product Amount 1: 1000.00
Product Amount 2: 500.00
TOTAL AMOUNT: 1500.00
```

**After:**
```
Product Amount 1: 1000.00  
Product Amount 2: 500.00
Sub Total (Products): 1500.00
Transportation Charge: 200.00
Loading Charge: 100.00
GRAND TOTAL: 1800.00
```

### 5. User Experience Improvements

**Real-time Calculations:**
- Immediate updates when any field changes
- Visual feedback with styled total sections
- Clear separation between product costs and charges

**Input Validation:**
- Minimum value of 0 for all charge fields
- Automatic formatting to 2 decimal places
- Prevention of negative values

**Visual Design:**
- Sub Total in light background for differentiation
- Grand Total in highlighted green background
- Clear labeling and proper spacing

### 6. Data Flow

1. **User Input**: Enters product quantities, rates, transportation and loading charges
2. **Frontend Calculation**: JavaScript calculates sub-total and grand total in real-time
3. **Backend Processing**: Controller receives all values and stores in database
4. **Database Storage**: All charges stored separately for detailed reporting
5. **Edit Mode**: Pre-populates all fields from database for modifications

### 7. Benefits

**For Business:**
- Better cost tracking and profit analysis
- Accurate pricing with separate charge visibility
- Detailed breakdown for customer transparency

**For Users:**
- Clear understanding of total cost components
- Real-time calculation feedback
- Consistent experience across add/edit forms

**For System:**
- Proper data separation for reporting
- Backward compatibility maintained
- Scalable for additional charges in future

## Testing Checklist

- [ ] Add new sales with transportation and loading charges
- [ ] Edit existing sales with new charge fields
- [ ] Verify calculations are accurate in real-time
- [ ] Check database storage of all new fields
- [ ] Test form validation for negative values
- [ ] Verify total amount calculations in sales reports

## Database Migration

To apply the database changes:
1. Access: `http://localhost/erp/index.php/migrate`
2. Migration will automatically add the new columns
3. Existing sales records will have default 0.00 values for new fields

## Future Enhancements

- Add more charge types (fuel surcharge, handling fee, etc.)
- Implement percentage-based charges
- Add charge templates for quick selection
- Include charges in detailed sales reports and invoices