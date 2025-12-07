<link rel="stylesheet" href="<?php echo base_url('assets/css/sales-centralized.css'); ?>" />
<?php if (validation_errors()): ?>
<div class="alert alert-danger">
	<?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
	<strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
</div>
<?php endif; ?>
<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger">
	<strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
</div>
<?php endif; ?>

<div class="main">
	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span8 offset2">
					<div class="search_panel">
						<h3 class="search_header">Add Customer</h3>
						<div class="search_conent">
							<form action="<?php echo site_url('admin/sales/create_customer') ?>" method="post" autocomplete="off" id="customer-form">
								<div class="row">
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label for="code" class="control-label">Customer Code</label>
											<input value="<?php echo $code; ?>" name="code" id="code" type="text" class="form-control" readonly="readonly" placeholder="Auto-generated customer code">
										</div>
									</div>
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label for="name" class="control-label">Customer Name</label>
											<input value="<?php echo $name; ?>" name="name" id="name" type="text" class="form-control" required placeholder="Enter full customer name">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label for="contact_no" class="control-label">Contact No</label>
											<input name="contact_no" id="contact_no" value="<?php echo $contact_no; ?>" type="text" class="form-control" required placeholder="Enter phone number or email">
											<?php echo form_error('contact_no', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label for="address" class="control-label">Address</label>
											<textarea name="address" id="address" class="form-control" rows="3" required placeholder="Enter complete address including city, state, and postal code"><?php echo $address; ?></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label for="remarks" class="control-label">Remark</label>
											<textarea name="remarks" id="remarks" class="form-control" rows="3" placeholder="Additional notes or comments (optional)"><?php echo $remarks; ?></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-12 text-end">
										<input type="submit" value="Create Customer" class="btn btn-primary" />
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</script>
<script src="<?php echo base_url()?>assets/validate/dist/jquery.validate.js"></script>				<script>
	
	$().ready(function() {
		// validate the comment form when it is submitted

		// validate signup form on keyup and submit
		$("#rejoin-form").validate({
			rules: {
				'course': "required",
				'course_ctgy': "required"
				
			},
			messages: {
				'course': "Please choose your course",
				'course_ctgy': "Please choose COURSE CATEGORY"
			
			}
		});

		// propose username by combining first- and lastname
	
	});
			</script>
	
</div>
								 
								 
	
						 
								 
	</div>						 
	</div>	
	
<script src="<?php echo base_url()?>assets/validate/dist/jquery.validate.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/ui/jquery-ui.css" />
<script src="<?php echo base_url()?>assets/ui/jquery-ui.js"></script>

<!-- Enhanced Customer Form JavaScript -->
<script>
$(document).ready(function() {
	// Helper function to clean validation messages
	function cleanValidationMessages($element) {
		// Remove all validation status messages
		$element.siblings('.contact-validation-status').remove();
		$element.parent().find('.contact-validation-status').remove();
		$element.closest('td').find('.contact-validation-status').remove();
		
		// Remove jQuery validation error labels
		$element.siblings('label.error').remove();
		$element.parent().find('label.error').remove();
	}

	// Enhanced form validation
	$("#customer-form").validate({
		rules: {
			name: {
				required: true,
				minlength: 2
			},
			contact_no: {
				required: true,
				minlength: 10,
				remote: {
					url: "<?php echo site_url('admin/sales/check_contact_unique'); ?>",
					type: "post",
					data: {
						contact_no: function() {
							return $("#customer-form input[name='contact_no']").val();
						}
					},
					dataFilter: function(data, type) {
						// Clear validation flag when response received
						isValidating = false;
						
						<!-- Removed legacy rejoin-form validation block -->
				}
			},
			address: {
				required: true,
				minlength: 10
			}
		},
		messages: {
			name: {
				required: "Please enter customer name",
				minlength: "Customer name must be at least 2 characters"
			},
			contact_no: {
				required: "Please enter contact number",
				minlength: "Contact number must be at least 10 characters",
				remote: "This contact number is already registered with another customer"
			},
			address: {
				required: "Please enter customer address",
				minlength: "Address must be at least 10 characters"
			}
		},
		errorPlacement: function(error, element) {
			error.insertAfter(element);
		},
		highlight: function(element) {
			$(element).addClass('error');
		},
		unhighlight: function(element) {
			$(element).removeClass('error');
		}
	});
	
	// Enhanced form submission with loading state
	$("#customer-form").on('submit', function(e) {
		if ($(this).valid()) {
			var submitBtn = $(this).find('input[type="submit"]');
			submitBtn.addClass('loading');
			submitBtn.val('Creating Customer...');
			
			// Disable form inputs during submission
			$(this).find('input, textarea').prop('disabled', true);
		}
	});
	
	// Auto-format contact number with validation indicator
	$('input[name="contact_no"]').on('input', function() {
		var value = $(this).val().replace(/\D/g, '');
		if (value.length >= 10) {
			$(this).val(value.substring(0, 10));
		}
		
		// Remove any existing validation indicators
		$(this).removeClass('checking valid-contact invalid-contact');
		$(this).siblings('.contact-validation-status').remove();
	});
	
	// Add validation status indicators for contact field
	$('input[name="contact_no"]').on('blur', function() {
		var $this = $(this);
		if ($this.val().length >= 10) {
			$this.addClass('checking');
			$this.after('<small class="contact-validation-status text-info"><i class="fa fa-spinner fa-spin"></i> Checking availability...</small>');
		}
	});
	
	// Handle remote validation feedback with enhanced UX
	var contactValidationTimer;
	var isValidating = false;
	
	$('input[name="contact_no"]').on('keyup input', function() {
		var $this = $(this);
		var contactValue = $this.val();
		
		// Clear previous timer
		clearTimeout(contactValidationTimer);
		
		// Clean all validation states and messages
		$this.removeClass('checking valid-contact invalid-contact');
		cleanValidationMessages($this);
		
		// Reset validation flag
		isValidating = false;
		
		// Only validate if length is adequate and not already validating
		if (contactValue.length >= 10 && !isValidating) {
			// Add delay to prevent excessive AJAX calls
			contactValidationTimer = setTimeout(function() {
				if (!isValidating && $this.val().length >= 10) {
					isValidating = true;
					$this.addClass('checking');
					
					// Clean again before adding new message
					cleanValidationMessages($this);
					
					// Add checking message
					$this.after('<small class="contact-validation-status text-info"><i class="fa fa-spinner fa-spin"></i> Checking availability...</small>');
					
					// Trigger validation manually
					$("#customer-form").validate().element($this);
				}
			}, 800); // 800ms delay
		}
	});
	
	// Override the remote validation to handle completion
	$('input[name="contact_no"]').on('blur', function() {
		var $this = $(this);
		setTimeout(function() {
			isValidating = false;
		}, 100);
	});
	
	// Enhanced remote validation success/error handling
	$("#customer-form").validate().settings.success = function(label, element) {
		var $element = $(element);
		if ($element.attr('name') === 'contact_no') {
			$element.removeClass('checking invalid-contact').addClass('valid-contact');
			
			// Clean all existing status messages
			cleanValidationMessages($element);
			
			// Add success message
			$element.after('<small class="contact-validation-status text-success"><i class="fa fa-check-circle"></i> Contact number is available</small>');
			
			// Reset validation flag
			isValidating = false;
		}
		label.remove();
	};
	
	// Handle validation errors and cleanup
	$("#customer-form").validate().settings.invalidHandler = function(event, validator) {
		// Reset validation flag on any validation error
		isValidating = false;
		
		// Clean up contact field if it was being validated
		var $contactField = $('input[name="contact_no"]');
		if ($contactField.hasClass('checking')) {
			$contactField.removeClass('checking');
			cleanValidationMessages($contactField);
		}
	};
	
	// Additional cleanup for contact field
	$('input[name="contact_no"]').on('focus', function() {
		var $this = $(this);
		// Clean up any stale messages when field gets focus
		if (!$this.hasClass('checking') && !$this.hasClass('valid-contact')) {
			cleanValidationMessages($this);
		}
	});
	
	// Character counter for textareas
	$('textarea').each(function() {
		var maxLength = 500;
		var placeholder = $(this).attr('placeholder');
		
		$(this).on('input', function() {
			var remaining = maxLength - $(this).val().length;
			var counterId = $(this).attr('name') + '-counter';
			
			if ($('#' + counterId).length === 0) {
				$(this).after('<small id="' + counterId + '" class="text-muted" style="float: right;"></small>');
			}
			
			$('#' + counterId).text(remaining + ' characters remaining');
			
			if (remaining < 50) {
				$('#' + counterId).removeClass('text-muted').addClass('text-warning');
			} else if (remaining < 20) {
				$('#' + counterId).removeClass('text-warning').addClass('text-danger');
			} else {
				$('#' + counterId).removeClass('text-warning text-danger').addClass('text-muted');
			}
		});
	});
	
	// Auto-capitalize customer name
	$('input[name="name"]').on('input', function() {
		var words = $(this).val().split(' ');
		for (var i = 0; i < words.length; i++) {
			if (words[i]) {
				words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1).toLowerCase();
			}
		}
		$(this).val(words.join(' '));
	});
	
	// Success animation for successful form submission
	<?php if($this->session->flashdata('success')): ?>
	setTimeout(function() {
		$('.alert-success').fadeOut('slow');
	}, 5000);
	<?php endif; ?>
	
	// Auto-hide error messages
	<?php if($this->session->flashdata('error') || validation_errors()): ?>
	setTimeout(function() {
		$('.alert-danger').fadeOut('slow');
	}, 8000);
	<?php endif; ?>
});
</script>					 
				 
		