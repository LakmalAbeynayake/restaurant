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
.dataTables_processing{position:absolute;top:50%;left:50%;width:100%;height:40px;margin-left:-50%;margin-top:-25px;padding-top:20px;text-align:center;font-size:1.2em;background-color:white;background:-webkit-gradient(linear, left top, right top, color-stop(0%, rgba(255,255,255,0)), color-stop(25%, rgba(255,255,255,0.9)), color-stop(75%, rgba(255,255,255,0.9)), color-stop(100%, rgba(255,255,255,0)));background:-webkit-linear-gradient(left, rgba(255,255,255,0) 0%, rgba(255,255,255,0.9) 25%, rgba(255,255,255,0.9) 75%, rgba(255,255,255,0) 100%);background:-moz-linear-gradient(left, rgba(255,255,255,0) 0%, rgba(255,255,255,0.9) 25%, rgba(255,255,255,0.9) 75%, rgba(255,255,255,0) 100%);background:-ms-linear-gradient(left, rgba(255,255,255,0) 0%, rgba(255,255,255,0.9) 25%, rgba(255,255,255,0.9) 75%, rgba(255,255,255,0) 100%);background:-o-linear-gradient(left, rgba(255,255,255,0) 0%, rgba(255,255,255,0.9) 25%, rgba(255,255,255,0.9) 75%, rgba(255,255,255,0) 100%);background:linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.9) 25%, rgba(255,255,255,0.9) 75%, rgba(255,255,255,0) 100%);
				}

		</style>
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body>
    <div class="row">
    <?php 
	//unset($this->session);
	
	//print_r($this->session);
	//print_r($_SESSION);
	 ?>
    </div>
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
                                  <li>
									
									<a href="#">
										Chef List
									</a>
								</li>
							</ol>
                            
							<div class="page-header">
								<h1>Chef List</h1>
							</div>

                        
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
									
                                    <div class="panel-tools" style="top:2px;">
												<button type="button" class="btn btn-blue dropdown-toggle" data-toggle="dropdown" data-toggle="modal" data-target="#myModal">
													<i class="clip-list-5"></i> Add New
												</button>
												<ul class="dropdown-menu dropdown-light pull-right">
														<li>
															<a id="" data-toggle="modal" href="<?php echo base_url('chef/create_chef'); ?>">
																<i class="fa fa-plus"></i> Add Chef
															</a>
														</li>
														
													</ul>
												</div>
	
					            </div>
								</div>
                                
                                
                                
                            <!--  <div class="panel-tools" style="top:2px;">
                              <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>


<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

  
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
      -->                        
                              
                              
                              
                              
                              
                              
                                
                                <input type="hidden" id="group_id" value="<?php echo $this->session->userdata('ss_group_id'); ?>">
							  <div class="panel-body">
							    <div id="error"></div>
								  <table width="100%" class="table table-bordered table-condensed table-hover table-striped dataTable" id="chef_table">
									  <thead>
							            <tr>
                                     
                                    <!--<th>chief_id</th>
                                    <th>Group_id</th>
                                    <th>Warehouse_id</th>-->
                                    <th>First name</th>
									<th>Last name</th>
                                    <th>Gender</th>
                                    
                               		   <th>Phone</th>
                                       <th>Email</th>
                                    <th>username</th>
                                 
                               		   
                                        <th>Action</th>
                                        
                                      
                                    
                                    </tr>
							          </thead>
                                      <tfoot>
											  
												<th>First Name</th>
												<th>Last Name</th>
												<th>Gender </th>
												<th>Phone</th>
												<th>Email</th>
                                                 <th>username</th>
                                                 <th>Action</th>
								            </tr>
						         
							                
						          </table>
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
		<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script>
        
         <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script>
          <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
          
        <script>
			jQuery(document).ready(function() {
				//TableData.init();
				loadGrid();
			});


			function loadGrid() {

					    $('#chef_table').DataTable({
							"bProcessing": true,        
                             "serverSide": true,
					        "ajax": "<?php echo base_url('chef/load_chef') ?>",
					        "bDestroy": true,
					        "iDisplayLength": 10
			});
}


function deleteUserData(chef_id){
	$("#myModal4").modal();
	$('#sel_id').val(chef_id); 
	$('#popup_type').val('delete');
	$('#page').val('supp');
	$("#label").text("Are you sure you want to delete this chef?");
}

function disableUserData(chef_id){
	$("#myModal4").modal();
	$('#sel_id').val(chef_id); 
	$('#popup_type').val('disable');
	$('#page').val('supp');
	$("#label").text("Are you sure you want to disable this chef?");
}

function enableUserData(chef_id){
	$("#myModal4").modal();
	$('#sel_id').val(chef_id); 
	$('#page').val('supp');
	$('#popup_type').val('enable');
	$("#label").text("Are you sure you want to enable this chef?");
}

jQuery(document).ready(function() {
	//conirm
	$( "#conirm" ).click(function() {
		var sel_id=$('#sel_id').val(); 
		var popup_type=$('#popup_type').val();
		var page=$('#page').val();
		var chef_id=sel_id;
		
if(page=='supp'){
	if(popup_type=='delete'){
			$.post( "delete_chef", {chef_id:chef_id})
		  .done(function( data ) {
		  var obj = jQuery.parseJSON(data);
				loadGrid();// load supplier data
				displayNotice('page','chef has been deleted successfully!')
		  });
	  
	}else if(popup_type=='disable') {
		$.post( "disable_user", {chef_id:chef_id})
		     .done(function( data ) {
		     var obj = jQuery.parseJSON(data);
			 loadGrid();// load supplier data
			 displayNotice('page','User has been disabled successfully!')
	   });
	}
	else if(popup_type=='enable') {
		$.post( "enable_user", {chef_id:chef_id})
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