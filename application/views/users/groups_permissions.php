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
										User
									</a>
								</li>
                                 <li>
									
									<a href="#">
										Group Permissions
									</a>
								</li>
								<li class="active">
									<?php  echo $user_group_group_info['user_group_name']; ?>
								</li>
                                
                                
								<li class="search-box">
									<form class="sidebar-search">
										<div class="form-group">
											<input type="text" placeholder="Start Searching...">
											<button class="submit">
												<i class="clip-search-3"></i>
											</button>
										</div>
									</form>
								</li>
							</ol>
							<div class="page-header">
								<h1>Group Permissions</h1>
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
								   Group Permissions</div>
                                
                                <div class="panel-body">
                                 <div id="error"></div>
									<!--<form role="form" class="form-horizontal" id="create_user_form" action="">-->
                                    
 <form role="form" class="form-horizontal" id="create_user_form" action="#" method="post">
 
 <input name="user_group_id" type="hidden" value="<?php echo $user_group_id ?>">
 
                                    
<!--  											<div class="col-md-12">
												<div class="errorHandler alert alert-danger no-display">
													<i class="fa fa-times-sign"></i> You have some form errors. Please check below.
												</div>
												<div class="successHandler alert alert-success no-display">
													<i class="fa fa-ok"></i> Your form validation is successful!
												</div>
											</div>-->
                                        <?php //print_r($user_details);?>
                                        
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" colspan="6"><?php  echo $user_group_group_info['user_group_name']; ?> Group Permissions</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center" rowspan="2">Module Name </th>
                                                        <th class="text-center" colspan="5">Permissions</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center">Has Access</th>
                                                        <!--<th class="text-center">Add</th>-->
                                                        <!--<th class="text-center">Edit</th><th class="text-center">Delete</th><th class="text-center">Miscellaneous</th>-->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                /*print_r($user_group_permission_page_list);*/
                                                
                                                foreach ($user_group_permission_page_list as $row)
                                                {
                                                    $has_permission = check_permission($row['menu_id'],$user_group_id);
                                                ?> 
                                                <tr>
                                                    <td <?php echo $row['menu_parent_id'] > 0 ? 'style="padding-left:100px"':''; ?>>
                                                        <table style="width:100%">
                                                            <tr>
                                                                <td style="border-right:solid gray 1px;width:20%"><?php echo strip_tags($row['menu_display_name']) ?></td>
                                                                <td style="border-right:solid gray 1px;width:20%"><?php echo $row['menu_display_name'] ?></td>
                                                                <td style="border-right:solid gray 1px;width:30%;text-wrap: wrap;overflow: auto;"><code><?php echo htmlspecialchars($row['menu_display_name']); ?></code></td>
                                                                <td style="border-right:solid gray 1px;width:30%;text-wrap: wrap;overflow: auto;max-width: 150px;"><?php echo htmlspecialchars($row['menu_url']); ?></td>
                                                            </tr>
                                                        </table>
                                                         
                                                    </td>
                                                    <td class="text-center">
                                                        <label class="checkbox-inline">
                                                        <input type="checkbox" class="square-teal" value="1" <?php if ($has_permission) echo 'checked="checked"';?> name="row_view_<?php echo $row['menu_id'];?>"></label>
                                                    </td>
                                                    <!--<td class="text-center">-->
                                                    <!--    <label class="checkbox-inline">-->
                                                    <!--    <input type="checkbox" class="square-teal" value="1" <?php //if ($row['usrgp_permission_add']) echo 'checked="checked"';?> name="row_add_<?php //echo $row['usrgp_permission_page'];?>">-->
                                                    <!--    </label>-->
                                                    <!--</td>-->
                                                    <!--<td class="text-center">-->
                                                    <!--    <label class="checkbox-inline"><input type="checkbox" class="square-teal" value="1" <?php //if ($row['usrgp_permission_edit']) echo 'checked="checked"';?> name="row_edit_<?php //echo $row['usrgp_permission_page'];?>">-->
                                                    <!--    </label>-->
                                                    <!--</td>-->
                                                    <!--<td class="text-center"><label class="checkbox-inline"><input type="checkbox" class="square-teal" value="1" <?php //if ($row['usrgp_permission_delete']) echo 'checked="checked"';?> name="row_delete_<?php //echo $row['usrgp_permission_page'];?>"></td>-->
                                                    <!--<td>&nbsp;</td>-->
                                                </tr>
                                                <?php }?>
                                                </tbody>
                                                </table>
                                        </div>
                                        
                                        
                                      

										
                <div class="form-group">
                                     <div class="col-sm-12">       
									<div class="modal-footer">
            <input type="submit" name="add_category" value="Update" class="btn btn-primary">
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
				2014 &copy; clip-one by cliptheme.
			</div>
			<div class="footer-items">
				<span class="go-top"><i class="clip-chevron-up"></i></span>
			</div>
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<?php $this->load->view("common/footer"); ?>
		<!-- end: MAIN JAVASCRIPTS -->
       
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
		<script src="<?php echo asset_url(); ?>js/form-validation-create_user.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
                        
		<script>
		

			jQuery(document).ready(function() {
				$(".search-select").select2({
					allowClear: true
				});

				FormValidator.init();
    			//$('.auto').autoNumeric('init');
				
						function test(){
	alert(1);
}
			});


		function save_user(form) {
               $('body').modalmanager('loading');
                setTimeout(function () {
                    $.ajax({
                    url: "<?php echo base_url('user_groups/save_user_group_permissions'); ?>", // Url to which the request is send
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
                                    set_message('Apdated!','Group Permission has been updated successfully!');
									document.getElementById("create_user_form").reset();
									window.location.reload();
                                };

                        }
                    });
                }, 1000);
		}


	
		</script>
	</body>
	<!-- end: BODY -->
</html>