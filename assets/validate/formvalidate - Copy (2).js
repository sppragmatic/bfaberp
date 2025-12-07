
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
				'add[origin_batch_id]':"required",
				'add[exam_batch_id]':"required",
					
				/*'add[practice]':"required",*/
				
			//	'add[interview]':"required",
				
			//	'add[how_know]':"required",
				'add[mail_id]': {
					required: true,
					email: true
				}
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
					}
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
 