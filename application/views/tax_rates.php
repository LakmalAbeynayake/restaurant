	<?php $this->load->view("common/header"); ?>
	<!-- end: HEAD -->
       


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
										 Settings 
									</a>
								</li>
								<li class="active">
									Tax Rates 
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
								<h1>Tax Rates</h1>
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
									Tax Rates
								  <div class="panel-tools" style="top:2px;">
												<button class="btn btn-blue dropdown-toggle" data-toggle="dropdown">
													<i class="fa fa-list"></i> Add New
												</button>
												<ul class="dropdown-menu dropdown-light pull-right">
														<li>
															<a id="modal_ajax_tax_rates_btn" data-toggle="modal" href="#">
																<i class="fa fa-plus"></i> Add Tax Rates
															</a>
														</li>
														
									</ul>
												</div>
								</div>
								<div class="panel-body">
									<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
										<thead>
											<tr>
												<th class="hidden-xs">Name</th>
												<th>Code</th>
												<th>Tax Rate</th>
												<th>Type</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>CAT05RK</td>
												<td>Foods and Beverages</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td align="right">
														<p>
															<a href="#" class="btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="List Sub Categories">
															<i class="glyphicon fa fa-list"></i></a>
															<a href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit Category">
															<i class="glyphicon fa fa-edit"></i></a>
															<a href="#" class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Delete Category">
															<i class="glyphicon fa fa-trash-o"></i></a>
														</p>
												</td>
											</tr>
										</tbody>
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
		<!-- end: MAIN JAVASCRIPTS -->

        
  

		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script>
			jQuery(document).ready(function() {
				TableData.init();

			});

		</script>
	</body>
	<!-- end: BODY -->
</html>