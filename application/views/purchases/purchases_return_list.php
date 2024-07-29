	<?php $this->load->view("common/header"); ?>
	<!-- end: HEAD -->
       
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">


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
										 GRN 
									</a>
								</li>
                                
								<li class="active">
									GRN List
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
								<h1>GRN Return List</h1>
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
								echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Purchase successfully added </div>';
							?>
							<script type="text/javascript">
									if (localStorage.getItem('poitems')) {
					                    localStorage.removeItem('poitems');
					                }
					                if (localStorage.getItem('podiscount')) {
					                    localStorage.removeItem('podiscount');
					                }
					                if (localStorage.getItem('tax_select')) {
					                    localStorage.removeItem('tax_select');
					                }
					                if (localStorage.getItem('poref')) {
					                    localStorage.removeItem('poref');
					                }
					                if (localStorage.getItem('powarehouse')) {
					                    localStorage.removeItem('powarehouse');
					                }
					                if (localStorage.getItem('ponote')) {
					                    localStorage.removeItem('ponote');
					                }
					                if (localStorage.getItem('posupplier')) {
					                    localStorage.removeItem('posupplier');
					                }
					                if (localStorage.getItem('supplier')) {
					                    localStorage.removeItem('supplier');
					                }
					                if (localStorage.getItem('poextras')) {
					                    localStorage.removeItem('poextras');
					                }
					                if (localStorage.getItem('podate')) {
					                    localStorage.removeItem('podate');
					                }
					                if (localStorage.getItem('postatus')) {
					                    localStorage.removeItem('postatus');
					                }
					                if (localStorage.getItem('poshipping')) {
					                    localStorage.removeItem('poshipping');
					                }

							</script>
							<?php } ?>
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									GRN (All Warehouses)
								</div>
								<div class="panel-body">
								    <div id="error"></div>
									<table width="100%" class="table table-bordered table-condensed table-hover table-striped dataTable" id="products_table">
										<thead>
								            <tr>
												<th>Date</th>
												<th>Reference No</th>
												<th>Supplier</th>
												<th>Supplier Reference No</th>
												<th>Grand Total</th>
												<th>Paid</th>
												<th>Balance</th>
												<th>Payment Status</th>
												<th>Actions</th>
								            </tr>
								        </thead>
								        <tfoot>
												<tr>
												<th>Date</th>
												<th>Reference No</th>
												<th>Supplier</th>
												<th>Supplier Reference No</th>
												<th>Grand Total</th>
												<th>Paid</th>
												<th>Balance</th>
												<th>Payment Status</th>
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
        </div>
		<!-- end: MAIN CONTAINER -->
		<!-- start: FOOTER -->
		<div class="footer clearfix">
			<div class="footer-inner">
				2015 &copy; clip-one by cliptheme.
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
				products_load();
			});
		function products_load() {

					    $('#products_table').DataTable({
							"bProcessing": true,
                             "serverSide": true,
					        "ajax": "<?php echo base_url('purchases/get_list_return_purchases') ?>",
					        "bDestroy": true,
					        "iDisplayLength": 10,
							//"order": [[ 0, "desc" ]],
							"fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
				
                var pq = 0, sq = 0, bq = 0, pa = 0, grand_tot = 0, tech_tot = 0, parts_tot=0 , ser_tot=0;
				//alert(aaData.length);
				var ser_tot3=0;
				var ser_tot2=0;
				var ser_tot1=0;
				var ser_tot4=0;
				//var sales_rtn=0;
                for (var i = 0; i < aaData.length; i++) {
					//alert(aaData[[i]][5]);
                   // p = (aaData[aiDisplay[i]][2]).split('__');
					ser_tot1 += parseFloat(aaData[[i]][3]);
					ser_tot2 += parseFloat(aaData[[i]][4]);
					ser_tot3 += parseFloat(aaData[[i]][5]);	
                }
                var nCells = nRow.getElementsByTagName('th');
				nCells[3].innerHTML = '<div class="text-right">'+accounting.formatMoney(ser_tot1, "", 2, ",", ".")+' </div>';
				
				
				nCells[4].innerHTML = '<div class="text-right">'+accounting.formatMoney(ser_tot2, "", 2, ",", ".")+' </div>';
				nCells[5].innerHTML = '<div class="text-right">'+accounting.formatMoney(ser_tot3, "", 2, ",", ".")+' </div>';
				
				var sales_rtn_tot_cost=ser_tot1;
				var sales_rtn_tot_val=ser_tot2;
				$('#sales-rtn-cost-fld').val(accounting.formatMoney(sales_rtn_tot_cost, "", 2, ",", "."));
				$('#sales-rtn-val-fld').val(accounting.formatMoney(sales_rtn_tot_val, "", 2, ",", "."));
				$('#sales-rtn-cost-tbl').text(accounting.formatMoney(sales_rtn_tot_cost, "", 2, ",", "."));
				$('#sales-rtn-val-tbl').text(accounting.formatMoney(sales_rtn_tot_val, "", 2, ",", "."));
				
				
				
				
              
            }
					    });

					}
		</script>
	</body>
	<!-- end: BODY -->
</html>