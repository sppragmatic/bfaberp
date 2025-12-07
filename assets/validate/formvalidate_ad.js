
	$().ready(function() {
		// validate the comment form when it is submitted

		// validate signup form on keyup and submit
		$("#admission").validate({
			rules: {
				'add[name]': "required",
				'add[username]': "required",
				'add[password]': "required",
				'add[mobile]':{
					required: true,
					number:true,
				},
				'add[father]': "required",
				'add[mother]': "required",
				'add[dob]': "required",
				'add[main_address]': {
					required: true,
					minlength: 5
				},
				'add[category]':"required",
				'add[gender]':"required",
				
				/* matric document start*/
				'add[mtc_inst_name]':"required",
				'add[mtc_pass_out]':"required",
				'add[mtc_board]':"required",
				'add[mtc_per]':{
					required:true,
					number:true,
					maxlength: 2
					},
				/* matric document end*/
				
				/* +2 document start*/
				'add[clg_inst_name]':"required",
				'add[clg_pass_out]':"required",
				'add[clg_board]':"required",
				'add[clg_per]':{
					required:true,
					number:true,
					maxlength: 2
					},
				/* +2 document end*/
				
				/* graduation document start*/
				'add[gdn_inst_name]':"required",
				'add[gdn_pass_out]':"required",
				'add[gdn_board]':"required",
				'add[gdn_per]':{
					required:true,
					number:true,
					maxlength: 2
					},
				/* graduation document end*/
				
				/* other document start
				'add[otr_inst_name]':"required",
				'add[otr_pass_out]':"required",
				'add[otr_board]':"required",
				'add[otr_per]':"required",
				other document end*/
				
				
				'add[origin_batch_id]':"required",
				'add[exam_batch_id]':"required",
					
				/*'add[practice]':"required",*/
				
				'add[interview]':"required",
				
				'add[how_know]':"required",
				'add[mail_id]': {
					required: true,
					email: true
				},
				password: {
					required: true,
					minlength: 5
				},
				confirm_password: {
					required: true,
					minlength: 5,
					equalTo: "#password"
				},
				
				topic: {
					required: "#newsletter:checked",
					minlength: 2
				},
				agree: "required"
			},
			messages: {
				'add[name]': "Please enter your Name",
				'add[username]': "Please Generate  Username",
				'add[password]': "Please Generate  Password",
				
				'add[mobile]': {
					required:"Please enter your Mobile no",
					number:"Please enter Valid Mobile number",
					},
					
					'add[father]': "Please enter your Father Name",
					'add[mother]': "Please enter your Mother Name",
				'add[main_address]': {
					required: "Please enter Your Permanet address",
					minlength: "Your Address must consist of at least 5 characters"
				},
				
				'add[dob]':"Please Choose your Date of Birth",
					
				'add[mail_id]': {
					required:"Please enter your Email Id",
					email:"Please enter a valid email address",
					},
					
					'add[category]': "Please Choose your Caregory",
					
					'add[gender]':"Please Choose your Gender",
					
				/* matric document start*/
				'add[mtc_inst_name]': "Please Enter your 10th Instituation Name",
				'add[mtc_pass_out]':"Please Enter your 10th passout year",
				'add[mtc_board]':"Please Enter your 10th Board Name",
				'add[mtc_per]':{
					required:"Please Enter your 10th Percentage of Fullmark",
					number:"Please Enter a valid Percentage of Fullmark",
					maxlength:"Please Enter a valid Percentage of Fullmark",
					},
				/* matric document end*/
				
				/* +2 document start*/
				'add[clg_inst_name]': "Please Enter your +2 Instituation Name",
				'add[clg_pass_out]':"Please Enter your +2 passout year",
				'add[clg_board]':"Please Enter your +2 Board Name",
				'add[clg_per]':{
					required:"Please Enter your +2th Percentage of Fullmark",
					number:"Please Enter a valid Percentage of Fullmark",
					maxlength:"Please Enter a valid Percentage of Fullmark",
					},
				/* +2 document end*/
				
				/* graduation document start*/
				'add[gdn_inst_name]': "Please Enter your Graduation Instituation Name",
				'add[gdn_pass_out]':"Please Enter your Graduation passout year",
				'add[gdn_board]':"Please Enter your Graduation Board Name",
				'add[gdn_per]':{
					required:"Please Enter your graduation Percentage of Fullmark",
					number:"Please Enter a valid Percentage of Fullmark",
					maxlength:"Please Enter a valid Percentage of Fullmark",
					},
				/*graduation document end*/
				
				/* other document start
				'add[otr_inst_name]': "Please Enter your Other Qualification Instituation Name",
				'add[otr_pass_out]':"Please Enter your Other Qualification passout year",
				'add[otr_board]':"Please Enter your Other Qualification Board Name",
				'add[otr_per]':"Please Enter your Other Qualification Percentage of Fullmark",
				other document end*/
					
				'add[practice]':"Please Choose your practice type",
				
				'add[interview]':"Please Enter your Type of Interview",
				
				'add[how_know]':"Please Enter your Type of Interview",
				
				'add[exam_batch_id]': "Please Choose your Exam Batch",
				'add[origin_batch_id]': "Please Choose your origin Batch",

				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
				confirm_password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long",
					equalTo: "Please enter the same password as above"
				},
				
				agree: "Please accept our policy",
				topic: "Please select at least 2 topics"
			}
		});

		// propose username by combining first- and lastname
		$("#username").focus(function() {
			var firstname = $("#firstname").val();
			var lastname = $("#lastname").val();
			if (firstname && lastname && !this.value) {
				this.value = firstname + "." + lastname;
			}
		});

		//code to hide topic selection, disable for demo
		var newsletter = $("#newsletter");
		// newsletter topics are optional, hide at first
		var inital = newsletter.is(":checked");
		var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
		var topicInputs = topics.find("input").attr("disabled", !inital);
		// show when newsletter is checked
		newsletter.click(function() {
			topics[this.checked ? "removeClass" : "addClass"]("gray");
			topicInputs.attr("disabled", !this.checked);
		});
	});

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#output').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#upld").change(function(){
        readURL(this);
    });
 