	<?php $this->load->view("common/header"); ?>
	<!-- end: HEAD -->
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
										 Ingredient Stock Adjesment 
									</a>
								</li>
                                
								<li class="active">
									Ingredient Stock Adjesment List
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
								<h1>Stock Adjustments List</h1>
							</div>

                            <p>Please use the table below to navigate or filter the results. </p>
						</div>
					</div>
					<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT 
                    <!-- start grid -->
                    <div class="row">
						<div class="col-md-12">
							<?php if ($error ==1) {
								echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Successfully added </div>';
							?>
							
							<?php } ?>
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									GRN (All Warehouses)
								</div>
								<div class="panel-body">
								    <div class="col-md-2 <?php echo $this->session->userdata('ss_group_id') == 3 ? 'collapse' : ''; ?>">
                                        <div class="form-group">
                                            <label>Location *</label>
                                            <select id="location_id" name="location_id" class="form-control search-select" onchange="products_load()">
                                                <?php 
                                                $sel='';
                                                foreach ($warehouse as $key => $wh) {
                                                    if($this->session->userdata('ss_warehouse_id') == $wh->id)
    												  {
    													  $sel=' selected="selected"';
    												  }else $sel = '';
                                                    echo "<option $sel value=" . $wh->id . ">" . $wh->name . "</option>";
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
								    <div id="error"></div>
									<table class="table table-bordered table-condensed table-hover table-striped dataTable" id="stock_adj_table">
										<thead>
								            <tr>
												<th>Created On</th>
												<th>Date for</th>
												<th>Reference No</th>
												<th>Added by</th>
												<th>Approval Status</th>
												<th>Actions</th>
								            </tr>
								        </thead>
								        <tfoot>
											<tr>
												<th>Created On</th>
												<th>Date for</th>
												<th>Reference No</th>
												<th>Added by</th>
												<th>Approval Status</th>
												<th>Actions</th>
								            </tr>
								        </tfoot>
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

		<!-- start: MAIN JAVASCRIPTS -->
		<?php $this->load->view("common/footer"); ?>
		<!-- end: MAIN JAVASCRIPTS -->
		<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
        <script>
			jQuery(document).ready(function() {
				//TableData.init();
				products_load();
			});


			function products_load() {
			    var location_id = $('#location_id').val();
			    $('#stock_adj_table').DataTable({
			        "ajax": {
                        method: 'POST',
                        url: "<?php echo base_url('stock_adjesment/get_list') ?>",
                        data: {
                            location_id : location_id
                        }
                    },
			        "bDestroy": true,
			        "iDisplayLength": 10,
					"order": [[0 , "desc" ]], "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {}
			    });
			}
					
			function fbs_click(id) {
			    u=location.href;
			    t=document.title;
			    window.open('Ingredient/print_grn_details?purchase_id='+id,'sharer','toolbar=0,status=0,width=626,height=700, left=10, top=10,scrollbars=yes');return false;
			}
		</script>
	</body>
	<!-- end: BODY -->
</html>