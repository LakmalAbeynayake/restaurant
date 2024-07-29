	<?php $this->load->view("common/header"); ?>
	<!-- end: HEAD -->
       
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/select2/select2.css" />
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />
		<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
	<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">

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
									<a href="<?php echo base_url('sales'); ?>">
										 Sales 
									</a>
								</li>
                               
								<li class="active">
									List Sales
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
								<h1>Pending Orders</h1>
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
									Pending Order
                                    <div class="panel-tools" style="top:2px;">
                                    
                                    
												<button class="btn btn-blue dropdown-toggle" data-toggle="dropdown">
													<i class="fa fa-list"></i> Add New
												</button>
												<ul class="dropdown-menu dropdown-light pull-right">
														<li>
															<a id="" data-toggle="modal" href="<?php echo base_url('order/add_order'); ?>">
																<i class="fa fa-plus"></i> Add Order
															</a>
														</li>
														
													</ul>
												</div>
                                    <div class="panel-tools" style="top:2px;"></div>
								</div>
								</div>
							  <div class="panel-body">
							    <div id="error"></div>
                                
                              <div class="col-md-12">
											<div class="panel panel-default">
												<div style="font-weight: 700;" class="panel-heading"></div>
													<div class="panel-body">
														
                                                        <div class="col-sm-4">
                                                      	<div class="form-group">
															<label>From Date*  </label>
                                                         <input id="srh_from_date" name="srh_from_date" type='text' class="form-control date" value="" data-bv-field="date"/>                                                             
														</div>
														</div>
                                                        
                                                        
                                                   
                                                <div class="col-sm-4">
                            <div class="form-group">
                                <label>To Date </label>
                               
                                <?php $nowdate=date("Y-m-d");?>
                                        <input id="srh_to_date" name="srh_to_date" type='text' class="form-control date" value="" data-bv-field="date"/></div>
                            </div>   
                            
                             <div class="col-sm-4">&nbsp;</div>
                            
                             <div class="col-sm-4">&nbsp;</div>
                            
                        <div class="col-sm-4">
                       
                        <input type="submit" name="add_category" value="Search" class="btn btn-primary" onClick="loadGrid()"> &nbsp;&nbsp;
                                                             
                                                             <input type="submit" name="add_category" value="Reset" class="btn btn-danger" onClick="searchDetailsReset()">
                        
                        </div> 
												</div>
                                                
											</div>  
                                    
								</div>
								</div>
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
							  <div class="panel-body">
							    <div id="error"></div>
								  
								  <table width="100%" class="table table-bordered table-condensed table-hover table-striped dataTable" id="warehouse_table">
									  <thead>
							            <tr>
                             <th><input type="checkbox" id="check_all" name="check_all" value="" class="primary" checked ></th>
                                    <th>Date</th>
                                    <th>Order No</th>
                                    <th>Customer</th>
                                   
									<!--<th>Grand Total</th>-->
									<!--<th>Return</th>
									<th>Total to be paid</th>
									<th>Paid</th>
                                    <th>Balance</th>
                                    <th>Payment Status</th>-->
                                  <!--  <th>Status</th>-->
                                     <!--<th>Action</th>-->
                                    </tr>
							          </thead>
							          <tfoot>
											  <tr>
                                           <td colspan="3">&nbsp; </td>
                             <td> <div class="pull-right"><button id="proceed" name="proceed" class="btn btn-danger">
Collected 
<i class="fa fa-arrow-circle-right"></i>
</button></div> </td>
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
		
        
		<!-- end: MAIN JAVASCRIPTS -->
		<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script>
        
         <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script>
          <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
          <script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
          
          <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>
        
       
          
        <script>
			jQuery(document).ready(function() {
				//TableData.init();
				loadGrid();
			});


			function loadGrid() {
var srh_from_date = $('#srh_from_date').val();
var srh_to_date = $('#srh_to_date').val();

					    $('#warehouse_table').DataTable({
						
							"ajax":{
										'url'	:"<?php echo base_url('order/pending_list_orders')?>",
										'data'	:{
											srh_from_date:srh_from_date , 
											srh_to_date:srh_to_date
											}
									},
							"bDestroy": true,
					        "iDisplayLength": 100,
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
					ser_tot1 += parseFloat(aaData[[i]][3]);
					ser_tot2 += parseFloat(aaData[[i]][4]);
					ser_tot3 += parseFloat(aaData[[i]][5]);	
                }
                var nCells = nRow.getElementsByTagName('th');
				//nCells[3].innerHTML = '<div class="text-right">'+accounting.formatMoney(ser_tot1, "", 2, ",", ".")+' </div>';
				
				
				//nCells[4].innerHTML = '<div class="text-right">'+accounting.formatMoney(ser_tot2, "", 2, ",", ".")+' </div>';
				//nCells[5].innerHTML = '<div class="text-right">'+accounting.formatMoney(ser_tot3, "", 2, ",", ".")+' </div>';
				
				var sales_rtn_tot_cost=ser_tot1;
				var sales_rtn_tot_val=ser_tot2;
				$('#sales-rtn-cost-fld').val(accounting.formatMoney(sales_rtn_tot_cost, "", 2, ",", "."));
				$('#sales-rtn-val-fld').val(accounting.formatMoney(sales_rtn_tot_val, "", 2, ",", "."));
				$('#sales-rtn-cost-tbl').text(accounting.formatMoney(sales_rtn_tot_cost, "", 2, ",", "."));
				$('#sales-rtn-val-tbl').text(accounting.formatMoney(sales_rtn_tot_val, "", 2, ",", "."));
				
				
				
				
              
            }
					    });

					}
$("#check_all").click(function(){
	$('input:checkbox').not(this).prop('checked',this.checked);
});
	
$("#proceed").click(function(){
var list = [];
var i = 0;	
	if ($("#warehouse_table input:checkbox:checked").length > 0)
{
					$(':checkbox:checked').each(function(i){
                            //alert($(this).val());
							
							list[i] = $(this).val();
							i++;
							
					});
}
				 $.post( "proceed",{list:list} )
            .done(function( data ) {
				 
		    // var obj = jQuery.parseJSON(data);
			 loadGrid();// load customer data
			 displayNotice('page','Proceeded successfully!')
	   });
	   });

					
function click_sales_view_btn(sale_id){	
	var $modal = $('#ajax-modal');
	 $('body').modalmanager('loading');
			setTimeout(function () {
				$modal.load('<?php echo base_url("order/order_details?order_id="); ?>'+order_id, '', function () {
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
	window.open('order/cancel?order_id='+id,'sharer','toolbar=0,status=0,width=626,height=700, left=10, top=10,scrollbars=yes');return false;
	

}

$(function () {
	//showKeys();
	
	var currentDate = new Date();
	
	
	$('#srh_to_date').datetimepicker({
		format:("YYYY/MM/DD"),
		defaultDate: new Date()
		});
	
	$('#srh_from_date').datetimepicker({
		format:("YYYY/MM/DD"),
		defaultDate: new Date()
		});
	
	//$("#warehouse_id").select2();
	//$("#supp_id").select2();
//	$("#customer_id").select2();
	
	
});	



		</script>

     
	</body>
	<!-- end: BODY -->
</html>