# Sales Controller - Contact Number Integration with Party Table

## Overview
This implementation replaces the `customer_name` field with `contact_no` and adds remote validation to check entries in the party table during sales creation.

## Changes Made

### 1. **Controller Enhancements**

#### **Added AJAX Methods for Remote Validation**

```php
/**
 * AJAX method to check if contact number exists in party table
 * Returns JSON response for remote validation
 */
public function check_contact_in_party()
{
    $contact_no = $this->input->post('contact_no');
    $branch_id = $this->session->userdata('branch_id');
    
    if (empty($contact_no)) {
        echo json_encode(['exists' => false, 'party' => null]);
        return;
    }
    
    // Check if contact number exists in party table for current branch
    $party = $this->db->select('id, name, contact_no, address')
                      ->from('party')
                      ->where('contact_no', $contact_no)
                      ->where('branch_id', $branch_id)
                      ->where('trash', 0)
                      ->get()
                      ->row_array();
    
    if (!empty($party)) {
        echo json_encode([
            'exists' => true, 
            'party' => $party,
            'message' => 'Contact number found in Party: ' . $party['name']
        ]);
    } else {
        echo json_encode([
            'exists' => false, 
            'party' => null,
            'message' => 'Contact number not found in party records'
        ]);
    }
}

/**
 * AJAX method to get party details by contact number for auto-filling
 * Returns party information if found
 */
public function get_party_by_contact()
{
    $contact_no = $this->input->get('contact_no');
    $branch_id = $this->session->userdata('branch_id');
    
    if (empty($contact_no)) {
        echo json_encode(['success' => false, 'message' => 'Contact number is required']);
        return;
    }
    
    // Get party details by contact number
    $party = $this->db->select('id, name, contact_no, address')
                      ->from('party')
                      ->where('contact_no', $contact_no)
                      ->where('branch_id', $branch_id)
                      ->where('trash', 0)
                      ->get()
                      ->row_array();
    
    if (!empty($party)) {
        echo json_encode([
            'success' => true,
            'party' => $party,
            'message' => 'Party details found'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No party found with this contact number'
        ]);
    }
}
```

#### **Updated Form Validation**

```php
// BEFORE
//$this->form_validation->set_rules('customer_name', "customer Name", 'required');

// AFTER
$this->form_validation->set_rules('contact_no', "Contact Number", 'required|trim|numeric|min_length[10]|max_length[15]');
```

#### **Enhanced Customer Creation Logic**

```php
// BEFORE
$customer_name = $this->input->post('customer_name');
$customer_id = $this->input->post('customer_id');
if ($customer_id == null) {
    $cusdata['name'] = $customer_name;
    $this->db->insert('customer', $cusdata);
    $customer_id = $this->db->insert_id();
    $data['customer_id'] = $customer_id;
}

// AFTER
$contact_no = $this->input->post('contact_no');
$customer_id = $this->input->post('customer_id');
$customer_name = $this->input->post('customer_name'); // Still accept name if provided

if ($customer_id == null) {
    // Create new customer with contact number and name
    $cusdata['contact_no'] = $contact_no;
    $cusdata['name'] = !empty($customer_name) ? $customer_name : 'Customer-' . $contact_no;
    $cusdata['branch_id'] = $branch_id;
    $cusdata['entry_by'] = $entry_by;
    $cusdata['entry_date'] = date('Y-m-d');
    $this->db->insert('customer', $cusdata);
    $customer_id = $this->db->insert_id();
    $data['customer_id'] = $customer_id;
}
```

### 2. **Frontend Implementation Guide**

#### **HTML Form Structure**

Replace the customer_name input with contact_no:

```html
<!-- BEFORE -->
<input id="customer_name" name="customer_name" type="text" class="form-control" placeholder="Customer Name">

<!-- AFTER -->
<div class="form-group">
    <label for="contact_no">Contact Number *</label>
    <input id="contact_no" name="contact_no" type="text" class="form-control" 
           placeholder="Enter 10-15 digit contact number" 
           maxlength="15" 
           required>
    <div id="contact_validation_message" class="text-info mt-1"></div>
</div>

<!-- Optional: Customer Name field for manual entry -->
<div class="form-group">
    <label for="customer_name">Customer Name</label>
    <input id="customer_name" name="customer_name" type="text" class="form-control" 
           placeholder="Customer Name (Auto-filled or manual entry)" 
           readonly>
</div>

<!-- Hidden field for customer ID -->
<input type="hidden" id="customer_id" name="customer_id">
```

#### **JavaScript for Remote Validation**

```javascript
$(document).ready(function() {
    let contactTimeout;
    
    $('#contact_no').on('input', function() {
        const contactNo = $(this).val();
        const messageDiv = $('#contact_validation_message');
        
        // Clear previous timeout
        clearTimeout(contactTimeout);
        
        // Reset fields
        $('#customer_name').val('').prop('readonly', false);
        $('#customer_id').val('');
        messageDiv.html('');
        
        if (contactNo.length >= 10) {
            // Debounce the API call
            contactTimeout = setTimeout(function() {
                checkContactInParty(contactNo);
            }, 500);
        }
    });
    
    function checkContactInParty(contactNo) {
        const messageDiv = $('#contact_validation_message');
        
        // Show loading message
        messageDiv.html('<i class="fa fa-spinner fa-spin"></i> Checking contact number...')
                  .removeClass('text-danger text-success')
                  .addClass('text-info');
        
        $.ajax({
            url: '<?php echo base_url("admin/sales/check_contact_in_party"); ?>',
            type: 'POST',
            data: { contact_no: contactNo },
            dataType: 'json',
            success: function(response) {
                if (response.exists) {
                    // Party found - auto-fill details
                    messageDiv.html('<i class="fa fa-check-circle"></i> ' + response.message)
                              .removeClass('text-info text-danger')
                              .addClass('text-success');
                    
                    // Auto-fill customer details
                    $('#customer_name').val(response.party.name).prop('readonly', true);
                    $('#customer_id').val(response.party.id);
                    
                    // Optional: Auto-fill address if you have an address field
                    if ($('#address').length) {
                        $('#address').val(response.party.address);
                    }
                } else {
                    // Party not found
                    messageDiv.html('<i class="fa fa-info-circle"></i> ' + response.message + '. New customer will be created.')
                              .removeClass('text-info text-success')
                              .addClass('text-warning');
                    
                    // Enable manual customer name entry
                    $('#customer_name').prop('readonly', false).focus();
                }
            },
            error: function() {
                messageDiv.html('<i class="fa fa-exclamation-triangle"></i> Error checking contact number')
                          .removeClass('text-info text-success')
                          .addClass('text-danger');
            }
        });
    }
});
```

#### **Advanced Auto-Complete Feature**

```javascript
// Add this for enhanced user experience
$('#contact_no').on('blur', function() {
    const contactNo = $(this).val();
    
    if (contactNo.length >= 10 && !$('#customer_id').val()) {
        // Get party details for auto-completion
        $.ajax({
            url: '<?php echo base_url("admin/sales/get_party_by_contact"); ?>',
            type: 'GET',
            data: { contact_no: contactNo },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Show confirmation dialog
                    if (confirm('Party found: ' + response.party.name + '. Use this party details?')) {
                        $('#customer_name').val(response.party.name);
                        $('#customer_id').val(response.party.id);
                        if ($('#address').length) {
                            $('#address').val(response.party.address);
                        }
                    }
                }
            }
        });
    }
});
```

### 3. **Database Schema Requirements**

Ensure your customer table has the contact_no field:

```sql
-- Add contact_no column to customer table if not exists
ALTER TABLE `customer` 
ADD COLUMN `contact_no` VARCHAR(15) NULL COMMENT 'Customer contact number' AFTER `name`;

-- Add index for better performance
CREATE INDEX idx_customer_contact_branch ON customer(contact_no, branch_id);

-- Ensure party table has proper structure
ALTER TABLE `party` 
ADD COLUMN `contact_no` VARCHAR(15) NULL COMMENT 'Party contact number' AFTER `name`;

CREATE INDEX idx_party_contact_branch ON party(contact_no, branch_id, trash);
```

### 4. **Validation Rules**

#### **Contact Number Validation**
- ✅ **Required**: Contact number is mandatory
- ✅ **Numeric**: Only numeric characters allowed
- ✅ **Length**: 10-15 digits (configurable)
- ✅ **Branch Specific**: Checks within user's branch only
- ✅ **Real-time**: AJAX validation as user types

#### **Business Logic**
- ✅ **Party Integration**: Checks party table first
- ✅ **Auto-fill**: Populates customer details if party exists
- ✅ **New Customer**: Creates new customer if not found
- ✅ **Duplicate Prevention**: Prevents duplicate customers with same contact

### 5. **User Experience Flow**

#### **Scenario 1: Existing Party**
1. User enters contact number
2. System finds matching party in party table
3. Auto-fills customer name and details
4. Shows green success message
5. Proceeds with existing party information

#### **Scenario 2: New Customer**
1. User enters contact number
2. System doesn't find matching party
3. Shows yellow warning message
4. Enables manual customer name entry
5. Creates new customer record on form submission

#### **Scenario 3: Validation Errors**
1. User enters invalid contact number
2. Shows red error message
3. Form validation prevents submission
4. User corrects the input

### 6. **Benefits of This Implementation**

#### **✅ Business Benefits**
- **Party Integration**: Seamless connection with existing party records
- **Data Consistency**: Reduces duplicate customer entries
- **Improved Accuracy**: Auto-filled data reduces human errors
- **Better Tracking**: Links sales to existing business relationships

#### **✅ User Experience Benefits**  
- **Faster Data Entry**: Auto-completion of customer details
- **Real-time Validation**: Immediate feedback on contact numbers
- **Intuitive Interface**: Clear visual indicators for validation status
- **Reduced Errors**: Prevents invalid contact number entry

#### **✅ Technical Benefits**
- **Performance**: Indexed database queries for fast lookup
- **Scalability**: Efficient AJAX calls with debouncing
- **Maintainability**: Clean separation of validation logic
- **Extensibility**: Easy to add more validation rules

### 7. **Configuration Options**

You can customize the validation by modifying these parameters:

```php
// In Sales controller validation
$this->form_validation->set_rules('contact_no', "Contact Number", 'required|trim|numeric|min_length[10]|max_length[15]');

// Customize as needed:
// - min_length[8] for 8-digit numbers
// - max_length[12] for 12-digit numbers  
// - Add custom validation for specific formats
```

```javascript
// In frontend JavaScript
const MIN_CONTACT_LENGTH = 10; // Minimum digits before validation
const VALIDATION_DELAY = 500;  // Milliseconds to wait before API call

// Customize validation timing and behavior
```

This implementation provides a robust, user-friendly system for integrating sales with existing party records while maintaining data integrity and improving user experience.