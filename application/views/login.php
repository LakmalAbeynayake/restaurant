<?php $this->load->view("common/header"); ?>
.3<!-- end: HEAD -->
<!-- start: BODY -->

<body class="login example2" style="<?php /*?>background-image:url(<?php echo asset_url(); ?>images/login_cover.png); background-repeat:no-repeat; background-size:cover<?php */?>">
<div class="main-login <?php /*?>col-sm-4 col-sm-offset-4<?php */?>">
  <div class="logo">Sign in to your account</div>
  <div style="" class="box-login col-md-offset-4 col-md-4"><!-- start: LOGIN BOX -->
    <div class="col-md-12">
      <h3>STAFF </h3>
      <p> Please enter your name and password to log in. </p>
      <form class="form-login" action="#" method="post" id="form-login">
        <div class="errorHandler alert alert-danger no-display" id="error_msg"> <i class="fa fa-remove-sign"></i> Login Failed, Please try again </div>
        <?php //echo validation_errors('<p class="error">'); ?>
        <fieldset>
          <div class="form-group"> <span class="input-icon">
            <input id="user_username" type="text" class="form-control" name="user_username" placeholder="Username" value="">
            <i class="fa fa-user"></i> </span> </div>
          <div class="form-group form-actions"> <span class="input-icon">
            <input type="password" class="form-control password" name="password" placeholder="Password" value="">
            <i class="fa fa-lock"></i> <a class="forgot" href="#"> I forgot my password </a> </span> </div>
          <div class="form-actions">
            <label for="remember" class="checkbox-inline">
              <input type="checkbox" class="grey remember" id="remember" name="remember">
              Keep me signed in </label>
            <button type="submit" class="btn btn-bricky pull-right"> Login <i class="fa fa-arrow-circle-right"></i> </button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
  <?php /*?><div class="box-login col-md-4 col-md-offset-2">
				<h3>STAFF - Sign in to your account</h3>
				<p>
					Please enter your name and password to log in.
				</p>
				
			</div><?php */?>
  <!-- end: LOGIN BOX --></div>
<!-- start: FORGOT BOX -->
<div class="box-forgot">
  <h3>Forget Password?</h3>
  <p> Enter your e-mail address below to reset your password. </p>
  <form class="form-forgot">
    <div class="errorHandler alert alert-danger no-display"> <i class="fa fa-remove-sign"></i> You have some form errors. Please check below. </div>
    <fieldset>
      <div class="form-group"> <span class="input-icon">
        <input type="email" class="form-control" name="email" placeholder="Email">
        <i class="fa fa-envelope"></i> </span> </div>
      <div class="form-actions"> <a class="btn btn-light-grey go-back"> <i class="fa fa-circle-arrow-left"></i> Back </a>
        <button type="submit" class="btn btn-bricky pull-right"> Submit <i class="fa fa-arrow-circle-right"></i> </button>
      </div>
    </fieldset>
  </form>
</div>
<!-- end: FORGOT BOX --> 
<!-- start: REGISTER BOX 
			<div class="box-register">
				<h3>Sign Up</h3>
				<p>
					Enter your personal details below:
				</p>
				<form class="form-register">
					<div class="errorHandler alert alert-danger no-display">
						<i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
					</div>
					<fieldset>
						<div class="form-group">
							<input type="text" class="form-control" name="full_name" placeholder="Full Name">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="address" placeholder="Address">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="city" placeholder="City">
						</div>
						<div class="form-group">
							<div>
								<label class="radio-inline">
									<input type="radio" class="grey" value="F" name="gender">
									Female
								</label>
								<label class="radio-inline">
									<input type="radio" class="grey" value="M" name="gender">
									Male
								</label>
							</div>
						</div>
						<p>
							Enter your account details below:
						</p>
						<div class="form-group">
							<span class="input-icon">
								<input type="email" class="form-control" name="email" placeholder="Email">
								<i class="fa fa-envelope"></i> </span>
						</div>
						<div class="form-group">
							<span class="input-icon">
								<input type="password" class="form-control" id="password" name="password" placeholder="Password">
								<i class="fa fa-lock"></i> </span>
						</div>
						<div class="form-group">
							<span class="input-icon">
								<input type="password" class="form-control" name="password_again" placeholder="Password Again">
								<i class="fa fa-lock"></i> </span>
						</div>
						<div class="form-group">
							<div>
								<label for="agree" class="checkbox-inline">
									<input type="checkbox" class="grey agree" id="agree" name="agree">
									I agree to the Terms of Service and Privacy Policy
								</label>
							</div>
						</div>
						<div class="form-actions">
							<a class="btn btn-light-grey go-back">
								<i class="fa fa-circle-arrow-left"></i> Back
							</a>
							<button type="submit" class="btn btn-bricky pull-right">
								Submit <i class="fa fa-arrow-circle-right"></i>
							</button>
						</div>
					</fieldset>
				</form>
			</div>
			--> 
<!-- end: REGISTER BOX --> 
<!-- start: COPYRIGHT -->
<div class="copyright col-md-12"> 2015 &copy; stock management system by sallelanka solutions. </div>
<!-- end: COPYRIGHT -->
</div>
<?php $this->load->view("common/footer"); ?>
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 
<script src="<?php echo asset_url(); ?>plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo asset_url(); ?>js/login.js"></script> 
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 
<script>
			jQuery(document).ready(function() {
				Main.init();
				Login.init();
			});
			
			function login(form) {

                $('body').modalmanager('loading');
                setTimeout(function() {
                    $.ajax({
                        url: "<?php echo base_url('users/login_web'); ?>", // Url to which the request is send
                        type: "POST", // Type of request to be send, called as method
                        data: new FormData(form), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false, // To send DOMDocument or non processed data file it is set to false
                        dataType: "JSON",
                        success: function(data) // A function to be called if request succeeds
                        {
                            var obj = data;//jQuery.parseJSON(data);
                            if (obj.status == 0) {
                                $('#error_msg').show();
                                $('body').modalmanager('removeLoading');
                                // $('body').attr('class','');
                            } else {
                                //window.location = "<?php echo base_url('common');?>";
                                if (obj.ss_group_id == 3) {
                                    window.location = "<?php echo base_url('posplus/app');?>";
                                } else {
                                    window.location = "<?php echo base_url('dashboard');?>";
                                }
                            };
            
                        }
                    });
                }, 1000);
            }
		function customer_login(form){
			
			$('body').modalmanager('loading');
                setTimeout(function () {
                    $.ajax({
                    url: "<?php echo base_url('customers/login'); ?>", // Url to which the request is send
                    type: "POST",             // Type of request to be send, called as method
                    data: new FormData(form), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                    contentType: false,       // The content type used when sending data to the server.
                    cache: false,             // To unable request pages to be cached
                    processData:false,        // To send DOMDocument or non processed data file it is set to false
                        success: function(data)   // A function to be called if request succeeds
                        {
                            var obj = jQuery.parseJSON(data);
                            if (obj.status==0) 
                                {
									$('#error_msg').show();
                                    $('body').modalmanager('removeLoading');
                                   // $('body').attr('class','');
                                } 
                                else
                                {
									window.location = "<?php echo base_url('customer');?>";
                                };

                        }
                    });
                }, 1000);
		
			}
		</script>
</body>
<!-- end: BODY -->
</html>