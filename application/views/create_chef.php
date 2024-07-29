	<?php $this->load->view("common/header"); ?>   
        

	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body>
		<!-- start: HEADER -->
		<div class="navbar navbar-inverse navbar-fixed-top">
			<!-- start: TOP NAVIGATION CONTAINER -->
			<div class="container">
				<div class="navbar-header">
					<!-- start: RESPONSIVE MENU TOGGLER -->
					<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
						<span class="clip-list-2"></span>
					</button>
					<!-- end: RESPONSIVE MENU TOGGLER -->
					<!-- end: RESPONSIVE MENU TOGGLER -->
					<!-- start: LOGO -->
					<?php $this->load->view("common/logo"); ?>
					<!-- end: LOGO -->
				</div>
				<div class="navbar-tools">
					<!-- start: TOP NAVIGATION MENU -->
				<?php $this->load->view("common/notifications.php"); ?>
					<!-- end: TOP NAVIGATION MENU -->
				</div>
			</div>
			<!-- end: TOP NAVIGATION CONTAINER -->
		</div>
		<!-- end: HEADER -->
		<!-- start: MAIN CONTAINER -->
		<div class="main-container">
			<div class="navbar-content">
				<!-- start: SIDEBAR -->
				<?php $this->load->view("common/navigation"); ?>
				<!-- end: SIDEBAR -->
			</div>
			<!-- start: PAGE -->
			<div class="main-content">
				<!-- start: PANEL CONFIGURATION MODAL FORM -->
				<div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								<h4 class="modal-title">Panel Configuration</h4>
							</div>
							<div class="modal-body">
								Here will be a configuration form
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">
									Close
								</button>
								<button type="button" class="btn btn-primary">
									Save changes
								</button>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
				<!-- end: SPANEL CONFIGURATION MODAL FORM -->
				<div class="container">
					<!-- start: PAGE HEADER -->
					<div class="row">
						<div class="col-sm-12">
							<!-- start: PAGE TITLE & BREADCRUMB -->
							<ol class="breadcrumb">
                            	<li>
									<a href="<?php echo base_url('dashboard'); ?>">
										 Dashboard 
									</a>
								</li>
								<li>
									<a href="#">
										 People 
									</a>
								</li>
                                <li>
									
									<a href="#">
										Chef
									</a>
								</li>
								<li class="active">
									<?php echo $btnText ?>
								</li>
								<li class="search-box">
									<form class="sidebar-search">
										<div class="form-group">
											<input type="text" placeholder="Start Searching...">
											<button class="submit">
												<i class="fa fa-search"></i>
											</button>
										</div>
									</form>
								</li>
							</ol>
							<div class="page-header">
								<h1><?php echo $btnText ?></h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
						</div>
					</div>
                    <!-- start grid -->
                    <div class="row">
						<div class="col-md-12">
                        
                      <?php echo validation_errors('<p class="error">'); ?>
                        
                        
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									<?php echo $btnText ?></div>
                                
                                <div class="panel-body">
                                 <div id="error"></div>
                                 
                                 
	<form role="form" class="form-horizontal" id="create_chef_form" action="">
                                    
 <!--<form role="form" class="form-horizontal" id="create_chef_form" action="#" method="post">-->
<input type="hidden" value="<?php echo $type;?>" name="type" id="type"/>
<input type="hidden" value="<?php echo $chef_id;?>" name="chef_id" id="chef_id"/>   
                                    
<!--  											<div class="col-md-12">
												<div class="errorHandler alert alert-danger no-display">
													<i class="fa fa-times-sign"></i> You have some form errors. Please check below.
												</div>
												<div class="successHandler alert alert-success no-display">
													<i class="fa fa-ok"></i> Your form validation is successful!
												</div>
											</div>-->
                                        <?php //print_r($user_details);?>
                                        
                                        <div class="col-md-5">                              

                                        <div class="form-group">
											<label for="form-field-1" class="control-label">
												First Name
											*</label>
											<div>
												<input type="text" id="chef_Fname" class="form-control" name="chef_Fname"<?php echo (isset($user_details['chef_Fname']))?'value="'.$user_details['chef_Fname'].'"':null;?>>
                                               
											</div>
										</div>
                                        <div class="form-group">
											<label for="form-field-2" class="control-label">
												Last Name
											*</label>
											<div>
												<input <?php echo (isset($user_details['chef_Lname']))?'value="'.$user_details['chef_Lname'].'"':null;?> type="text" id="chef_Lname" class="form-control" name="chef_Lname">
											</div>
										</div>
                                        
                                        <div class="form-group">
											<label for="form-field-3" class="control-label">
												Email *
											</label>
											<div>
												<input type="text" id="user_email" class="form-control" name="user_email" <?php echo (isset($user_details['user_email']))?'value="'.$user_details['user_email'].'"':null;?>>
											</div>
										</div>
                                        
                                          <div class="form-group">
											<label for="form-field-3" class="control-label">
												Phone *
											</label>
											<div>
												<input type="text" id="user_phone" class="form-control" name="user_phone" <?php echo (isset($user_details['user_phone']))?'value="'.$user_details['user_phone'].'"':null;?>>
											</div>
										</div>
                                        <div class="form-group">
											<label for="form-field-1" class="control-label">
												Username *
											</label>
											<div>
												<input type="text" id="username" class="form-control" name="username" <?php echo (isset($user_details['username']))?'value="'.$user_details['username'].'"':null;?> 
												<?php if (isset($type)) if($type=='E') echo 'readonly';?>>
											</div>
										</div>
                                        <?php if ($type=='A'){ ?>
                                       <div class="form-group">
											<label for="form-field-1" class="control-label">
												Password *										</label>
											<div>
												<input type="password" id="password" class="form-control" name="password">
											</div>
										</div>
                                        <div class="form-group">
											<label for="form-field-1" class="control-label">
												Confirm Password *
											</label>
											<div>
												<input type="password" id="user_password_again" class="form-control" name="user_password_again">
											</div>
										</div>
                                        <?php }?>
                                        </div> <!-- end: col-md-5 -->
                                        
                                         <div class="col-md-5 col-md-offset-1">   
                                         <div class="form-group">
											<label for="form-field-1" class="control-label">
												Gender *
											</label>
											<div>
												<select class="form-control" id="Gender" name="Gender">
											<option value=""></option>
											<option value="Male" <?php  
											if(isset($user_details['Gender'])) { if($user_details['Gender']=='Male')  echo'selected="selected"'; } ?>>Male</option>
											<option value="Female" <?php  
											if(isset($user_details['Gender'])) { if($user_details['Gender']=='Female')  echo'selected="selected"'; } ?>>Female</option>
										
										</select>
											</div>
										</div>
                                       <!-- <div class="form-group">
											<label for="form-field-1">
												Status *
											</label>
											<div>
												<select class="form-control" id="user_status" name="user_status">
											<option value=""></option>
											<option value="Active">Active</option>
											<option value="Inactive">Inactive</option>
										
										</select>
											</div>
										</div>-->
                                                                  
										
                                        <div class="form-group">
											<label for="form-field-1" class="control-label">
												Group
											*</label>
											<div>
												<select class="form-control" id="Group_id" name="Group_id">
											<option value="">&nbsp;</option>
											<?php 
                                                              foreach ($user_group_list as $row)
                                                               {
					$sel='';
					if(isset($user_details['Group_id'])){
						
					if($row['user_group_id']==$user_details['Group_id']){
					$sel=' selected="selected"';
					}
					
					 }else{if($row['user_group_id']==4){
					$sel=' selected="selected"';
					}
					}?>
                                                                        
																		<option <?php echo $sel; ?> value="<?php echo $row['user_group_id']; ?>">
																		<?php echo $row['user_group_name']; ?>
                                                                        </option>
                                                                        
                                                              <?php }?>
										
										</select>  
											</div>
										</div> 
                                         
                                        <div class="form-group">
											<label for="form-field-1" class="control-label">
												Warehouse 
											*</label>
											<div>
                                            <?php //print_r($user_details);?>
												<select id="warehouse_id" class="form-control " name="warehouse_id">
																  <?php 
                                                              foreach ($warehouse_list as $row){
                                                          $sel='';
					if(isset($user_details['warehouse_id'])){
						
					if($row->id==$user_details['warehouse_id']){
					$sel=' selected="selected"';
					}
			
					}?>
                                                                        
																		<option <?php echo $sel; ?> value="<?php echo $row->id; ?>">
																		<?php echo $row->name; ?>
                                                                        </option>
                                                                        
										<?php } ?>
										</select>  
											</div>
										</div> 
                                      
                                      
										
                                     <div class="form-group">
                                     <div class="col-sm-12">       
									<div class="modal-footer">
            <input type="submit" name="add_category" value="<?php echo $btnText; ?>" class="btn btn-primary"> 
            </div>
                                        </div>
                                        </div>
									</form>
								</div>
							</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					</div>

					
                    <!-- end grid -->
                    
					
			</div>
			<!-- end: PAGE -->
		</div>
		<!-- end: MAIN CONTAINER -->
		<!-- start: FOOTER -->
		<div class="footer clearfix">
			<div class="footer-inner">
				2018 &copy; smartsalleepos.com
			</div>
			<div class="footer-items">
				<span class="go-top"><i class="clip-chevron-up"></i></span>
			</div>
		</div>
		<!-- end: FOOTER -->
		<!-- start: RIGHT SIDEBAR -->
		<div id="page-sidebar">
			<a class="sidebar-toggler sb-toggle" href="#"><i class="fa fa-indent"></i></a>
			<div class="sidebar-wrapper">
				<ul class="nav nav-tabs nav-justified" id="sidebar-tab">
					<li class="active">
						<a href="#users" role="tab" data-toggle="tab"><i class="fa fa-users"></i></a>
					</li>
					<li>
						<a href="#favorites" role="tab" data-toggle="tab"><i class="fa fa-heart"></i></a>
					</li>
					<li>
						<a href="#settings" role="tab" data-toggle="tab"><i class="fa fa-gear"></i></a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="users">
						<div class="users-list">
							<h5 class="sidebar-title">On-line</h5>
							<ul class="media-list">
								<li class="media">
									<a href="#">
										<i class="fa fa-circle status-online"></i>
										<div class="media-body">
										  <h4 class="media-heading">Nicole Bell</h4>
											<span> Content Designer </span>
										</div>
									</a>
								</li>
								<li class="media">
									<a href="#">
										<div class="user-label">
											<span class="label label-success">3</span>
										</div>
										<i class="fa fa-circle status-online"></i>
										<div class="media-body">
										  <h4 class="media-heading">Steven Thompson</h4>
											<span> Visual Designer </span>
										</div>
									</a>
								</li>
								<li class="media">
									<a href="#">
										<i class="fa fa-circle status-online"></i>
										<div class="media-body">
										  <h4 class="media-heading">Ella Patterson</h4>
											<span> Web Editor </span>
										</div>
									</a>
								</li>
								<li class="media">
									<a href="#">
										<i class="fa fa-circle status-online"></i>
										<div class="media-body">
										  <h4 class="media-heading">Kenneth Ross</h4>

											<span> Senior Designer </span>
										</div>
									</a>
								</li>
							</ul>
							<h5 class="sidebar-title">Off-line</h5>
							<ul class="media-list">
								<li class="media">
									<a href="#">
									<div class="media-body">
									  <h4 class="media-heading">Nicole Bell</h4>
											<span> Content Designer </span>
										</div>
									</a>
								</li>
								<li class="media">
									<a href="#">
										<div class="user-label">
											<span class="label label-success">3</span>
										</div>
										<div class="media-body">
										  <h4 class="media-heading">Steven Thompson</h4>
											<span> Visual Designer </span>
										</div>
									</a>
								</li>
								<li class="media">
									<a href="#">
									<div class="media-body">
									  <h4 class="media-heading">Ella Patterson</h4>
											<span> Web Editor </span>
										</div>
									</a>
								</li>
								<li class="media">
									<a href="#">
									<div class="media-body">
									  <h4 class="media-heading">Kenneth Ross</h4>
											<span> Senior Designer </span>
										</div>

									</a>
								</li>
								<li class="media">
									<a href="#">
									<div class="media-body">

									  <h4 class="media-heading">Ella Patterson</h4>
											<span> Web Editor </span>
										</div>
									</a>
								</li>
								<li class="media">
									<a href="#">
									<div class="media-body">
									  <h4 class="media-heading">Kenneth Ross</h4>
											<span> Senior Designer </span>
										</div>
									</a>
								</li>
							</ul>
						</div>
						<div class="user-chat">
							<div class="sidebar-content">
								<a class="sidebar-back" href="#"><i class="fa fa-chevron-circle-left"></i> Back</a>
							</div>
							<div class="user-chat-form sidebar-content">
								<div class="input-group">
									<input type="text" placeholder="Type a message here..." class="form-control">
									<div class="input-group-btn">
										<button class="btn btn-success" type="button">
											<i class="fa fa-chevron-right"></i>
										</button>
									</div>
								</div>
							</div>
							<ol class="discussion sidebar-content">
								<li class="other">
									<div class="avatar"></div>
									<div class="messages">
										<p>
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
										</p>
										<span class="time"> 51 min </span>
									</div>
								</li>
								<li class="self">
									<div class="avatar"></div>
									<div class="messages">
										<p>
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
										</p>
										<span class="time"> 37 mins </span>
									</div>
								</li>
								<li class="other">
									<div class="avatar"></div>
									<div class="messages">
										<p>
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
										</p>
									</div>
								</li>
							</ol>
						</div>
					</div>
					<div class="tab-pane" id="favorites">
						<div class="users-list">
							<h5 class="sidebar-title">Favorites</h5>
							<ul class="media-list">
								<li class="media">
									<a href="#">
									<div class="media-body">
									  <h4 class="media-heading">Nicole Bell</h4>
											<span> Content Designer </span>
										</div>
									</a>
								</li>
								<li class="media">
									<a href="#">
										<div class="user-label">
											<span class="label label-success">3</span>
										</div>
										<div class="media-body">
										  <h4 class="media-heading">Steven Thompson</h4>
											<span> Visual Designer </span>
										</div>
									</a>
								</li>
								<li class="media">
									<a href="#">
									<div class="media-body">
									  <h4 class="media-heading">Ella Patterson</h4>
											<span> Web Editor </span>
										</div>
									</a>
								</li>
								<li class="media">
									<a href="#">
									<div class="media-body">
									  <h4 class="media-heading">Kenneth Ross</h4>
											<span> Senior Designer </span>
										</div>
									</a>
								</li>
								<li class="media">
									<a href="#">
									<div class="media-body">
									  <h4 class="media-heading">Ella Patterson</h4>
											<span> Web Editor </span>
										</div>
									</a>
								</li>
								<li class="media">
									<a href="#">
									<div class="media-body">
									  <h4 class="media-heading">Kenneth Ross</h4>
											<span> Senior Designer </span>
										</div>
									</a>
								</li>
							</ul>
						</div>
						<div class="user-chat">
							<div class="sidebar-content">
								<a class="sidebar-back" href="#"><i class="fa fa-chevron-circle-left"></i> Back</a>
							</div>
							<ol class="discussion sidebar-content">
								<li class="other">
									<div class="avatar"></div>
									<div class="messages">
										<p>
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
										</p>
										<span class="time"> 51 min </span>
									</div>
								</li>
								<li class="self">
									<div class="avatar"></div>
									<div class="messages">
										<p>
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
										</p>
										<span class="time"> 37 mins </span>
									</div>
								</li>
								<li class="other">
									<div class="avatar"></div>
									<div class="messages">
										<p>
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
										</p>
									</div>
								</li>
							</ol>
						</div>
					</div>
					<div class="tab-pane" id="settings">
						<h5 class="sidebar-title">General Settings</h5>
						<ul class="media-list">
							<li class="media">
								<div class="checkbox sidebar-content">
									<label>
										<input type="checkbox" value="" class="green" checked="checked">
										Enable Notifications
									</label>
								</div>
							</li>
							<li class="media">
								<div class="checkbox sidebar-content">
									<label>
										<input type="checkbox" value="" class="green" checked="checked">
										Show your E-mail
									</label>
								</div>
							</li>
							<li class="media">
								<div class="checkbox sidebar-content">
									<label>
										<input type="checkbox" value="" class="green">
										Show Offline Users
									</label>
								</div>
							</li>
							<li class="media">
								<div class="checkbox sidebar-content">
									<label>
										<input type="checkbox" value="" class="green" checked="checked">
										E-mail Alerts
									</label>
								</div>
							</li>
							<li class="media">
								<div class="checkbox sidebar-content">
									<label>
										<input type="checkbox" value="" class="green">
										SMS Alerts
									</label>
								</div>
							</li>
						</ul>
						<div class="sidebar-content">
							<button class="btn btn-success">
								<i class="icon-settings"></i> Save Changes
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end: RIGHT SIDEBAR -->
		<div id="event-management" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">Event Management</h4>
					</div>
					<div class="modal-body"></div>
					<div class="modal-footer">
						<button type="button" data-dismiss="modal" class="btn btn-light-grey">
							Close
						</button>
						<button type="button" class="btn btn-danger remove-event no-display">
							<i class='fa fa-trash-o'></i> Delete Event
						</button>
						<button type='submit' class='btn btn-success save-event'>
							<i class='fa fa-check'></i> Save
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<?php $this->load->view("common/footer"); ?>
		<!-- end: MAIN JAVASCRIPTS -->
       
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
		<script src="<?php echo asset_url(); ?>js/form-validation-create_chef.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
                        
		<script>

			jQuery(document).ready(function() {
				$(".search-select").select2({
					allowClear: true
				});

				FormValidator.init();
    			//$('.auto').autoNumeric('init');
				
						function test(){
	//alert(1);
}
			});



		function save_chef(form) {
               $('body').modalmanager('loading');
                setTimeout(function () {
                    $.ajax({
                    url: "<?php echo base_url('chef/saves_chef'); ?>", // Url to which the request is send
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
                                    $('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>'+obj.validation+'</div>');
                                    $('body').modalmanager('removeLoading');
                                    $('body').attr('class','');
                                } 
                                else
                                {
                                    $('body').modalmanager('removeLoading');
                                    $('body').attr('class','');
									//alert(obj.type);
									if(obj.type=='A'){
                                    set_message('user notice!','chef successfully Added');
									document.getElementById("create_chef_form").reset();
									}else {
										set_message('user notice!','chef successfully Updated');
									}
                                };

                        }
                    });
                }, 1000);
		}


	
		</script>
	</body>
	<!-- end: BODY -->
</html>