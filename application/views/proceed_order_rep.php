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

td{
	
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
									 Products Report
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
								<h1>Proceed Order</h1>
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
									Proceed Order
                                   <!-- <div class="panel-tools" style="top:2px;">
												<button onClick="JavaScript:fbs_click('<?php echo base_url('reports/print_products/'); ?>');" class="btn btn-blue dropdown-toggle" data-toggle="dropdown">
													<i class="fa fa-print"></i>
												</button>
												
												</div>-->
								</div>
								</div>
							  <div class="panel-body">
							    <div id="error"></div>
                                <div class="col-md-12">
											<div class="panel panel-default">
												<div style="font-weight: 700;" class="panel-heading"></div>
													<div class="panel-body">
														
                                                        <!--<div class="col-sm-4">
                                                      	<div class="form-group">
															<label>Warehouse </label>
                                                       <select id="srh_warehouse_id" class="form-control" name="srh_warehouse_id">
                                                                    
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
														</div>-->
                                                        
                                                  <div class="col-sm-4">
                                                      	<div class="form-group">
															<label>Category</label>
                                                            <?php
															$cat_id=1;
															 //print_r($supplier_list);?>
                                                         <select id="cat_srh" name="cat_srh" class="form-control search-select">
                                                         
								                               
									                             <?php foreach ($category_list as $key => $sup) {
																	 ?>
									                               <option value="<?php echo $sup->cat_id; ?>"><?php echo $sup->cat_name; ?></option>
                                                                    <?php
																	$cat_id=$sup->cat_id;
									                             } ?>  
                                                                <!-- <option value="">--Select Category--</option>-->
								                             </select>                                                           
														</div>
														</div>
                                                     
                                                        <div class="col-sm-4">
                                                      	<div class="form-group">
															<label>From Date  </label>
                                                         <input id="srh_from_date" name="srh_from_date" type='text' class="form-control date" value="" data-bv-field="date"/>                                                             
														</div>
														</div>
                                                        
                                                        <div class="col-sm-4">
                                                      	<div class="form-group">
															<label for="s2id_autogen1">To Date </label>
                                                          
															 <input id="srh_to_date" name="srh_to_date" type='text' class="form-control date" value="" data-bv-field="date"/>        
														</div>
													</div>
                                                        
                                                        
                                                    
                                                    <div class="col-sm-4 pull-right">
                                                      	<div class="form-group">
															<label for="s2id_autogen1">&nbsp;<br><br>
</label>
                                                          
															 <input type="submit" name="add_category" value="Search" class="btn btn-primary" onClick="searchDetails()">          
														</div>
													</div>
                                                   
                                                    
												</div>
											</div> 
								  <table class="table table-bordered table-condensed table-hover table-striped dataTable" id="products_table">
									  <thead>
							              <tr>
                                    <th>Order Number</th>
                                    <th style="text-align:left;">Product Name</th>
                                     <th>Product Code</th>
                                     <!-- <th>Category</th>
                                       <th>Sub Category</th>-->
                                    <th class="col-md-1">Purchased</th>
                                    <th class="col-md-1">Sold</th>
                                    <th class="col-md-1">Sales Return</th>
                                    <th>Damage Products</th>
                                    <th style="text-align:right;">Sale Price</th>
                                    
                                    <th>price</th>
                                    <th>Balance</th>
									
									
                                    </tr>
							          </thead>
							          <tfoot>
										 <tr>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                     <!-- <th>&nbsp;</th>
                                       <th>&nbsp;</th>-->
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th class="col-md-1">&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
									
									
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
		<!-- end: MAIN JAVASCRIPTS -->
         <script src="<?php echo asset_url(); ?>js/jquery-ui.js" ></script>		
		<script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script>
		<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script>
        
		<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script>
        
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.2.3/js/dataTables.buttons.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.2.3/js/buttons.print.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.2.3/js/buttons.flash.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.2.3/js/buttons.html5.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.2.3/js/buttons.print.min.js">
        
             <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script>
          <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
          
          
      
       <script>
	   	function searchDetails(){
			products_load();
		}
			jQuery(document).ready(function() {
				
				
								var currentDate = new Date();
				var tomorrow = new Date();
				currentDate=tomorrow.setDate(tomorrow.getDate() + 1);
				
				$('#srh_to_date').datetimepicker({
					defaultDate: currentDate
				});
				
				
				$('#srh_from_date').datetimepicker({
					defaultDate: new Date()
				});
				
				//TableData.init();
				//loadGrid();
				
				
				 $("#cat_srh").select2();
				 // $("#sub_cat_srh").select2();
				//TableData.init();
				products_load();
				
				
				
			});


			function products_load() {
				var srh_warehouse_id=2;
				var cat_srh=$('#cat_srh').val();
				var srh_from_date=$('#srh_from_date').val();
				var srh_to_date=$('#srh_to_date').val();
				//buttons: ['copy', 'csv', 'excel', 'pdf','print'],

					    $('#products_table').DataTable({
							dom: 'Bfrtip',
							buttons: [ {
           extend: 'print',
           footer: true
       }],
					        "ajax": {
							'type': 'POST',
							'url': '<?php echo base_url('proceed_order/get_list_proceed_order_for_print');?>',
							'data': {
							   srh_warehouse_id: srh_warehouse_id,
							   cat_srh: cat_srh,
							   srh_from_date: srh_from_date,
							   srh_to_date: srh_to_date,
							}
							},
					        "bDestroy": true,
					        "iDisplayLength": 20,
							"order": [[ 1, "asc" ]], "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
				
                var pq = 0, sq = 0, bq = 0, pa = 0, grand_tot = 0, tech_tot = 0, parts_tot=0 , ser_tot=0;
				var ser_cost_tot=0
				var ser_price_tot=0
				//alert(aaData.length);
                for (var i = 0; i < aaData.length; i++) {
					//alert(aaData[[i]][5]);
                   // p = (aaData[aiDisplay[i]][2]).split('__');
					ser_tot += parseFloat(aaData[[i]][11]);
					ser_price_tot += parseFloat(aaData[[i]][9]);
					ser_cost_tot += parseFloat(aaData[[i]][10]);
                }
                var nCells = nRow.getElementsByTagName('th');
				nCells[11].innerHTML = '<div class="text-right">'+accounting.formatMoney(ser_tot, "", 2, ",", ".")+' </div>';
				nCells[9].innerHTML = '<div class="text-right">'+accounting.formatMoney(ser_price_tot, "", 2, ",", ".")+' </div>';
				nCells[10].innerHTML = '<div class="text-right">'+accounting.formatMoney(ser_cost_tot, "", 2, ",", ".")+' </div>';
              
            }
					    
					    });
						
						

					}
function fbs_click(url) {
	u=location.href;
	t=document.title;
	window.open(url,'sharer','toolbar=0,status=0,width=850,height=436, left=10, top=10,scrollbars=yes');return false;
}
		</script>

     
	</body>
	<!-- end: BODY -->
</html>