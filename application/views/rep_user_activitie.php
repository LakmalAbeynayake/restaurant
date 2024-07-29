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
										 Reports 
									</a>
								</li>
                                                                
								<li class="active">
									 User Activities
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
								<h1>User Activities</h1>
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
									User Activitie
                                    <div class="panel-tools" style="top:2px;">
												<!--<button onClick="JavaScript:fbs_click('<?php echo base_url('reports/print_sale?srh_warehouse_id=1'); ?>');" class="btn btn-blue dropdown-toggle" data-toggle="dropdown">
													<i class="fa fa-print"></i>
												</button>-->
												
												</div>
								</div>
								</div>
							  <div class="panel-body">
							    <div id="error"></div>
                                
                              <div class="col-md-12">
											<div class="panel panel-default">
												<div style="font-weight: 700;" class="panel-heading"></div>
													<div class="panel-body">
														
                                                        <div class="col-sm-3">
                                                      	<div class="form-group">
															<label>Location </label>
                                                       <select id="srh_warehouse_id" class="form-control" name="srh_warehouse_id">
                                                                    <option value="">-- Select Warehouse --</option>
																  <?php 
																 $ss_warehouse_id=$this->session->userdata('ss_warehouse_id'); 
                                                              foreach ($warehouse_list as $row)
                                                              {
																  $sel='';
																  if($ss_warehouse_id==$row->id)
																  {
																	  $sel=' selected="selected"';
																  }
                                                              ?>  
                                                                        
															<option value="<?php echo $row->id; ?>" <?php echo $sel; ?>>
																		<?php echo $row->name; ?>
                                                                        </option>
                                                              <?php }?>
																		
																	</select>                                          
														</div>
														</div>
                                                        
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label>User </label>
                                                                <select id="srh_user_id" class="form-control search-select" name="srh_user_id">
                                                                    <option value=""> -All- </option>
                                                                    <?php
                                                                    $ss_user_id = $this->session->userdata('ss_user_id');
                                                                    foreach ($user_list as $row) {
                                                                        $sel = '';
                                                                        if ($ss_user_id == $row->user_id) {
                                                                            $sel = ' selected="selected"';
                                                                        }
                                                                    ?>
                                                                        <option value="<?php echo $row->user_id; ?>" <?php echo $sel; ?>> <?php echo $row->user_first_name; ?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                      	<div class="form-group">
															<label>From Date  </label>
                                                         <input id="srh_from_date" name="srh_from_date" type='text' class="form-control date" value="" data-bv-field="date"/>                                                             
														</div>
														</div>
                                                        
                                                        <div class="col-sm-3">
                                                      	<div class="form-group">
															<label for="s2id_autogen1">To Date </label>
                                                          
															 <input id="srh_to_date" name="srh_to_date" type='text' class="form-control date" value="" data-bv-field="date"/>        
														</div>
													</div>
                                                    <div class="col-sm-4 pull-right">
                                                      	<div class="form-group">
															<label for="s2id_autogen1">&nbsp;<br><br>
</label>
                                                          
															 <input type="submit" name="add_category" value="Search" class="btn btn-primary" onClick="searchDetails()"> &nbsp;&nbsp;
                                                             
                                                             <input type="submit" name="add_category" value="Reset" class="btn btn-danger" onClick="searchDetailsReset()">
														</div>
													</div>
                                                   
                                                    
												</div>
											</div>  
                                
                                
								  <table class="table table-bordered table-condensed table-hover table-striped dataTable" id="warehouse_table">
									  <thead>
							            <tr>
                                    <th class="col-sm-5">Details</th>
                                   
                                    <th class="col-sm-2">User</th>
									<th class="col-sm-2">Date</th>
                                    </tr>
							          </thead>
							          <tfoot>
										<tr>
                                    <th>Details</th>
                                    
                                    <th>User</th>
									<th>Date</th>
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
        <script src="<?php echo asset_url(); ?>js/jquery-ui.js" ></script>		
		<script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script>
		<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script>
		
		<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>
        
         <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script>
          <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script>
        <script>
		
		function searchDetailsReset(){
			$('#srh_to_date').val('');
			$('#srh_from_date').val('');
		}
		function searchDetails(){
					
					loadGrid();
		}
				
				
			jQuery(document).ready(function() {
				
				
				//TableData.init();
				loadGrid();
				
				var currentDate = new Date();
				$('#srh_to_date').datetimepicker({
					defaultDate: new Date()
				});
				$('#srh_from_date').datetimepicker({
					//defaultDate: new Date()
				});
			});


			function loadGrid() {
			var srh_from_date=$('#srh_from_date').val();
			var srh_to_date=$('#srh_to_date').val();
			var srh_warehouse_id=$('#srh_warehouse_id').val();
			var srh_user_id=$('#srh_user_id').val();
			
							
					    $('#warehouse_table').DataTable({
							
							"ajax": {
							'type': 'POST',
							'url': '<?php echo base_url('reports/get_list_user_activitie_for_print');?>',
							'data': {
							   srh_from_date: srh_from_date,
							   srh_to_date: srh_to_date,
							   srh_warehouse_id: srh_warehouse_id,
							   srh_user_id : srh_user_id
							}
							},
					        "bDestroy": true,
					        "iDisplayLength": 20,
							"order": [[ 2, "desc" ]]
					    });

					}
					


function fbs_click(url) {
	var srh_from_date=$('#srh_from_date').val();
	var srh_to_date=$('#srh_to_date').val();
	var srh_warehouse_id=$('#srh_warehouse_id').val();
	
	u=location.href;
	t=document.title;
	url='<?php echo base_url();?>'+'reports/print_sale?srh_warehouse_id='+srh_warehouse_id+'&srh_from_date='+srh_from_date+'&srh_to_date='+srh_to_date;
	window.open(url,'sharer','toolbar=0,status=0,width=750,height=436, left=10, top=10,scrollbars=yes');return false;
}
</script>

     
	</body>
	<!-- end: BODY -->
</html>