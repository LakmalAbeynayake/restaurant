	<?php $this->load->view("common/header"); ?>
	<!-- end: HEAD -->
       
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/jquery.dataTables.css">	


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
                                
								<li class="active">
									Locations
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
								<h1>Locations</h1>
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
									Locations
									<div class="panel-tools" style="top:2px;">
												<button class="btn btn-blue dropdown-toggle" data-toggle="dropdown">
													<i class="fa fa-list"></i> Add New
												</button>
												<ul class="dropdown-menu dropdown-light pull-right">
														<li>
															<a id="modal_ajax_locations_btn" data-toggle="modal" href="#">
																<i class="fa fa-plus"></i> Add Location
															</a>
														</li>
														
													</ul>
												</div>
								</div>
								<div class="panel-body">
                                
                                    <div class="container">
                                    <table id="employee-grid"  cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover table-full-width" width="100%">
                                    <thead>
                                    <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
									<th>Address</th>
									<th>Actions</th>
                                    </tr>
                                    </thead>
                                    </table>
                                    </div>
                                    

<!--
									<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
										<thead>
											<tr>
												<th class="hidden-xs">Code</th>
												
												<th>Name</th>
												<th>Phone</th>
												<th>Email</th>
												<th>Address</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
                                        <?php 
										//$this->load->database();
										//$supplierslist=$this->data['suppliers'];
										foreach ($locations as $row)
										{
										?>
											<tr>
												<td><?php echo $row['location_code'] ?></td>
												<td><?php echo $row['location_name'] ?></td>
												<td><?php echo $row['location_phone'] ?> 	</td>
												<td><?php echo $row['location_email'] ?></td>
                                                <td><?php echo $row['location_address'] ?></td>
												<td align="right">
														<p>
                                                          <a onClick="click_supplier_update_btn(<?php echo $row['location_id'] ?>)" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers">
															<i class="glyphicon fa fa-edit"></i></a>
                                                            
                                                            <?php if($row['location_status']==1){ ?>
                                                            <a class="btn btn-xs btn-green tooltips" data-placement="top" data-original-title="Disable supplier" onClick="disableSupplierData(<?php echo $row['location_id'] ?>)">
															<i class="glyphicon fa fa-check"></i></a>
                                                            <?php } ?>
                                                            
															<?php if($row['location_status']==0){ ?>
                                                            <a class="btn btn-xs btn-warning tooltips" data-placement="top" data-original-title="Enable supplier" onClick="enableSupplierData(<?php echo $row['location_id'] ?>)">
															<i class="glyphicon fa fa-minus-circle"></i></a>
                                                            <?php } ?>
                                                            
                                                            
															<a class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Delete supplier" onClick="deleteSupplierData(<?php echo $row['location_id'] ?>)">
															<i class="glyphicon fa fa-trash-o"></i></a>
                                                            
														</p>
												</td>
											</tr>
                                            <?php }
										?>
										</tbody>
									</table>-->
                                    
                                    
                                    
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


   
   		<div id="static" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
			<div class="modal-body">
				<p>
					Would you like to continue with some arbitrary task?
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-default">
					Cancel
				</button>
				<button type="button" data-dismiss="modal" class="btn btn-primary">
					Continue Task
				</button>
			</div>
		</div>                                             
                                               
		<!-- start: MAIN JAVASCRIPTS -->
		<?php $this->load->view("common/footer"); ?>
		<!-- end: MAIN JAVASCRIPTS -->



		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!--<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/jquery.js"></script>-->
       <script src="<?php echo asset_url(); ?>plugins/jQuery-lib/2.0.3/jquery.min.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 
		
<script type="text/javascript" language="javascript" >
var j = jQuery.noConflict();
function loadGrid(){
	j('#employee-grid').DataTable().ajax.reload();
}
	jQuery(document).ready(function() {
		var dataTable = j('#employee-grid').DataTable( {
			"processing": true,
			"serverSide": true,
			"ajax":{
				url :"locations/list_location", // json datasource
				type: "post",  // method  , by default get
				error: function(){  // error handling
					j(".employee-grid-error").html("");
					j("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					//$("#employee-grid_processing").css("display","none");
				}
			}
		} );
		
	} );
</script>          
		
		<script>
			jQuery(document).ready(function() {
				//Main.init();
				TableData.init();
				//UIModals.init();
			});
			
			
jQuery(document).ready(function() {
	//conirm
	$( "#conirm" ).click(function() {
		var sel_id=$('#sel_id').val(); 
		var popup_type=$('#popup_type').val();
		var page=$('#page').val();
		var location_id=sel_id;
		
if(page=='location'){
	if(popup_type=='delete'){
			$.post( "locations/delete", {location_id:location_id})
		  .done(function( data ) {
		  var obj = jQuery.parseJSON(data);
				loadGrid();// load supplier data
				displayNotice('page','Location has been deleted successfully!')
		  });
	}else if(popup_type=='disable') {
		$.post( "locations/disable", {location_id:location_id})
		     .done(function( data ) {
		     var obj = jQuery.parseJSON(data);
			 loadGrid();// load supplier data
			 displayNotice('page','Location has been disabled successfully!')
	   });
	}
	else if(popup_type=='enable') {
		$.post( "locations/enable", {location_id:location_id})
		     .done(function( data ) {
		     var obj = jQuery.parseJSON(data);
			 loadGrid();// load supplier data
			 displayNotice('page','Location has been enabled successfully!')
	   });
	}
} //end page check
});
	

});				


function deleteLocationData(location_id){
	$("#myModal4").modal();
	$('#sel_id').val(location_id); 
	$('#popup_type').val('delete');
	$('#page').val('location');
	$("#label").text("Are you sure you want to delete this location?");
}

function disableLocationData(location_id){
	$("#myModal4").modal();
	$('#sel_id').val(location_id); 
	$('#popup_type').val('disable');
	$('#page').val('location');
	$("#label").text("Are you sure you want to disable this location?");
}

function enableLocationData(location_id){
	$("#myModal4").modal();
	$('#sel_id').val(location_id); 
	$('#page').val('location');
	$('#popup_type').val('enable');
	$("#label").text("Are you sure you want to enable this location?");
}

	function click_supplier_update_btn(location_id){
		
		var $modal = $('#ajax-modal');
		 $('body').modalmanager('loading');
		 
                setTimeout(function () {
                    $modal.load('<?php echo base_url("locations/create_location?location_id="); ?>'+location_id, '', function () {
                        $modal.modal();
                    });
                }, 1000);
	}

		</script>
        
	</body>
	<!-- end: BODY -->
</html>