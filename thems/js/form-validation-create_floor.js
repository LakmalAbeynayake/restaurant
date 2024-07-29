var FormValidator = function () {
	
    // function to initiate Validation Sample 1
    var runValidator1 = function () {
		//alert();
        var form1           =   $('#create_floor_form');
        var errorHandler1   =   $('.errorHandler', form1);
        var successHandler1 =   $('.successHandler', form1);

        $('#create_floor_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            ignore: "",
            rules: {
				floor_name: {
                    minlength: 2,
                    required: true
                },
                description: {
                    minlength: 2,
                    required: true
                }		
               
            },
            
            invalidHandler: function (event, validator) { //display error alert on form submit
                successHandler1.hide();
                errorHandler1.show();
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
            },
            submitHandler: function (form) {
                    add_floor(form);
                }
        });
    };
 

// function to initiate Validation Sample 1
    var runValidator2 = function () {
        //alert();
        var form1           =   $('#create_sub_category_form');
        var errorHandler1   =   $('.errorHandler', form1);
        var successHandler1 =   $('.successHandler', form1);

        $('#create_sub_category_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            ignore: "",
            rules: {
                parent_category: {
                    required: true
                },
                cat_code: {
                    minlength: 4,
                    required: true
                },       
                cat_name: {
                    required: true
                }       
               
            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                successHandler1.hide();
                errorHandler1.show();
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
            },
            submitHandler: function (form) {
                    add_sub_category(form);
                }
        });
    };



    return {
        //main function to initiate template pages
        init: function () {
            runValidator1();
            runValidator2();
        }
    };
}();