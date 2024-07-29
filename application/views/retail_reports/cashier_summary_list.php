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
								<li class="active">
									Reports
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
								<h1>Cashier Summary Report</h1>
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
									Cashier Summary Report
                                    <div class="panel-tools" style="top:2px;">
											
												<ul class="dropdown-menu dropdown-light pull-right">
														<li>
														
														</li>
														
													</ul>
												</div>
								</div>
								</div>
							  <div class="panel-body">
							    <div id="error"></div>
								  <table class="table table-bordered table-condensed table-hover table-striped dataTable" id="warehouse_table">
									  <thead>
							            <tr>
                                    <th>Date</th>
                                    <th>Ref No</th>
                                    <th>User</th>
									<th>Warehouse</th>
									<th>Float Status</th>
									<th>Remarks</th>
                                    <th>Action</th>
                                    </tr>
							          </thead>
							          <tfoot>
											  <tr>
                                    <th>Date</th>
                                    <th>Ref No</th>
                                    <th>User</th>
									<th>Warehouse</th>
									<th>Float Status</th>
									<th>Remarks</th>
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
           <script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>
          <script type="text/javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script>
          
        <script>
			jQuery(document).ready(function() {
				//TableData.init();
				loadGrid();
			});


			function loadGrid() {

					    $('#warehouse_table').DataTable({
					        "ajax": "<?php echo base_url('reports/get_cashier_summary_list') ?>",
					        "bDestroy": true,
							"serverSide": true,
					        "iDisplayLength": 10,
							"order": [[ 0, "desc" ]], "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
				
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
				//	ser_tot1 += parseFloat(aaData[[i]][3]);
				//	ser_tot2 += parseFloat(aaData[[i]][4]);
				//	ser_tot3 += parseFloat(aaData[[i]][5]);	
                }
                var nCells = nRow.getElementsByTagName('th');
				//nCells[3].innerHTML = '<div class="text-right">'+accounting.formatMoney(ser_tot1, "", 2, ",", ".")+' </div>';
				
				
				//nCells[4].innerHTML = '<div class="text-right">'+accounting.formatMoney(ser_tot2, "", 2, ",", ".")+' </div>';
				//nCells[5].innerHTML = '<div class="text-right">'+accounting.formatMoney(ser_tot3, "", 2, ",", ".")+' </div>';
				
				var sales_rtn_tot_cost=ser_tot1;
				var sales_rtn_tot_val=ser_tot2;
				//$('#sales-rtn-cost-fld').val(accounting.formatMoney(sales_rtn_tot_cost, "", 2, ",", "."));
			//	$('#sales-rtn-val-fld').val(accounting.formatMoney(sales_rtn_tot_val, "", 2, ",", "."));
			//	$('#sales-rtn-cost-tbl').text(accounting.formatMoney(sales_rtn_tot_cost, "", 2, ",", "."));
			//	$('#sales-rtn-val-tbl').text(accounting.formatMoney(sales_rtn_tot_val, "", 2, ",", "."));
				
				
				
				
              
            }
					    });

					}
					
function click_sales_view_btn(sale_id){	
	var $modal = $('#ajax-modal');
	 $('body').modalmanager('loading');
			setTimeout(function () {
				$modal.load('<?php echo base_url("sales/sale_details?sale_id="); ?>'+sale_id, '', function () {
					$modal.modal();
					$(".search-select").select2({
				            placeholder: "Select a State",
				            allowClear: true
				        });
				});
			}, 1000);
}


function fbs_click(id) {
	u=location.href;
	t=document.title;
	window.open('<?php echo base_url() ?>pos/sale_details_stn_duplicate?sale_id='+id,'sharer','toolbar=0,status=0,width=626,height=700, left=10, top=10,scrollbars=yes');return false;
	

}

function clear_sale(sid, wid) {
	/*if (group_id != 3) {}*/
	var locale = {
		OK: 'I Suppose',
		CONFIRM: 'Go Ahead',
		CANCEL: 'Maybe Not'
	};
	bootbox.addLocale('custom', locale);
	bootbox.prompt({
		title: "ARE YOU SURE ? yes / no ",
		locale: 'custom',
		callback: function(result) {
			//console.log('This was logged in the callback: ' + result);
			if (result == 'yes') {
				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url().'pos/clear_sale'?>",
					data: {
						sale_id: sid,
						warehouse_id: wid
					},
					cache: false,
					success: function(response) {
						displayNotice('page', 'Successfully Cleared!!');
						loadGrid();
					}
				});
			}
		}
	});
}

		</script>

     
	</body>
	<!-- end: BODY -->
</html>