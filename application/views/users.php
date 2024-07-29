	<?php $this->load->view("common/header"); ?>
	<!-- end: HEAD -->
       
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/select2/select2.css" />
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />
		<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">


		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/jQuery-Tags-Input/jquery.tagsinput.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/summernote/build/summernote.css">

		<style type="text/css">
			.table > thead:first-child > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table-striped thead tr.primary:nth-child(2n+1) th {
			    background-color: #428bca;
			    border-color: #357ebd;
			    border-top: 1px solid #357ebd;
			    color: white;
			    text-align: center;
			}

		</style>
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
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
                                
								<li class="active">
									List User
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
								<h1>User</h1>
							</div>

                            <p>Please use the table below to navigate or filter the results. </p>
						</div>
					</div>
					<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT 
                    <!-- start grid -->
                    <div class="row">
						<div class="col-md-12">
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Users
                                    <div class="panel-tools" style="top:2px;">
												<button class="btn btn-blue dropdown-toggle" data-toggle="dropdown">
													<i class="fa fa-list"></i> Add New
												</button>
												<ul class="dropdown-menu dropdown-light pull-right">
														<li>
															<a id="" data-toggle="modal" href="<?php echo base_url('users/create_user'); ?>">
																<i class="fa fa-plus"></i> Add User
															</a>
														</li>
														
													</ul>
												</div>
								</div>
							    <div class="panel-body">
							        
							        <div class="col-md-12">
							            <div class="col-md-2">
							                <div class="form-group">
    											<label for="form-field-1" class="control-label">Location *</label>
    											
                                                <?php //print_r($user_details);?>
    												<select id="warehouse_id" class="form-control " name="warehouse_id" onchange="loadGrid()">
    												    <option value=""> -- all -- </option>
    												    <?php 
                                                                  foreach ($warehouse_list as $row)
                                                                  {
    																  $sel='';
    																  if($this->session->userdata('ss_warehouse_id') ==$row->id){
    																		  $sel=' selected="selected"';
    																	  }
                                                                  ?>  
                                                                            
    																		<option <?php echo $sel; ?>value="<?php echo $row->id; ?>">
    																		<?php echo $row->name; ?>
                                                                            </option>
                                                                  <?php }?>
    																		
    												</select>
    										</div> 
							            </div>
							        </div>
							        
							    <div id="error"></div>
								  <table class="table table-bordered table-condensed table-hover table-striped dataTable" id="products_table">
									  <thead>
							              <tr>
											  <th>First Name</th>
											  <th>Last Name</th>
											  <th>Email Address</th>
											  <th>Group</th>
											  <th>Action</th>
							              </tr>
							          </thead>
							          <tfoot>
											  
												<th>First Name</th>
												<th>Last Name</th>
												<th>Email Address</th>
												<th>Group</th>
												<th>Action</th>
								            </tr>
								      </tfoot>
						          </table>
								</div>
							</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					<!--</div>-->

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

		<!-- start ajax model -->
		<div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
		<!-- end ajax model -->

		<!-- start: MAIN JAVASCRIPTS -->
		<?php $this->load->view("common/footer"); ?>
		<!-- end: MAIN JAVASCRIPTS -->
		<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script>
        <script>
			jQuery(document).ready(function() {
				//TableData.init();
				loadGrid();
			});


			function loadGrid() {

					    $('#products_table').DataTable({
					        "ajax": {
					            url : "<?php echo base_url('users/get_list_user') ?>",
					            data : {
					                location_id : $('#warehouse_id').val()
					            }
					        },
					        "bDestroy": true,
					        "iDisplayLength": 10
					    });

					}
					
	function deleteUserData(user_id){
	$("#myModal4").modal();
	$('#sel_id').val(user_id); 
	$('#popup_type').val('delete');
	$('#page').val('supp');
	$("#label").text("Are you sure you want to delete this supplier?");
}

function disableUserData(user_id){
	$("#myModal4").modal();
	$('#sel_id').val(user_id); 
	$('#popup_type').val('disable');
	$('#page').val('supp');
	$("#label").text("Are you sure you want to disable this supplier?");
}

function enableUserData(user_id){
	$("#myModal4").modal();
	$('#sel_id').val(user_id); 
	$('#page').val('supp');
	$('#popup_type').val('enable');
	$("#label").text("Are you sure you want to enable this supplier?");
}

jQuery(document).ready(function() {
	//conirm
	$( "#conirm" ).click(function() {
		var sel_id=$('#sel_id').val(); 
		var popup_type=$('#popup_type').val();
		var page=$('#page').val();
		var user_id=sel_id;
		
if(page=='supp'){
	if(popup_type=='delete'){
			$.post( "users/delete_user", {user_id:user_id})
		  .done(function( data ) {
		  var obj = jQuery.parseJSON(data);
				loadGrid();// load supplier data
				displayNotice('page','User has been deleted successfully!')
		  });
	}else if(popup_type=='disable') {
		$.post( "users/disable_user", {user_id:user_id})
		     .done(function( data ) {
		     var obj = jQuery.parseJSON(data);
			 loadGrid();// load supplier data
			 displayNotice('page','User has been disabled successfully!')
	   });
	}
	else if(popup_type=='enable') {
		$.post( "users/enable_user", {user_id:user_id})
		     .done(function( data ) {
		     var obj = jQuery.parseJSON(data);
			 loadGrid();// load supplier data
			 displayNotice('page','User has been enabled successfully!')
	   });
	}
} //end page check
	
	});
	

});			
		</script>
	</body>
	<!-- end: BODY -->
</html>