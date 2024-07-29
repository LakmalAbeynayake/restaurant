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
								<h1>Supplier Products Report</h1>
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
									Product Report
                                    <div class="panel-tools" style="top:2px;">
												<button title="Print Product Sticker" onClick="JavaScript:fbs_click('<?php echo base_url('reports/print_product_code_popup/'); ?>');" class="btn btn-blue dropdown-toggle" data-toggle="dropdown">
													<i class="fa fa-print"></i>
												</button>
                                                
                                                <button title="Print Product List" onClick="JavaScript:fbs_click_list('<?php echo base_url('reports/print_product_code_list_popup/'); ?>');" class="btn btn-blue dropdown-toggle" data-toggle="dropdown">
													<i class="fa fa-print"></i>
												</button>
                                                
                                                <button title="Print Product Barcode" onClick="JavaScript:fbs_click_list('<?php echo base_url('reports/print_product_barcode_list_popup/'); ?>');" class="btn btn-blue dropdown-toggle" data-toggle="dropdown">
													<i class="fa fa-print"></i>
												</button>
												
												</div>
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
															<label>Sub Category</label>
                                                            <?php //print_r($supplier_list);?>
                                                            <?php
															
												$ref_id = new category_models();
												$sub_category_list = $ref_id->getSubCategoryPrint();
												?>
                                                         <select id="sub_cat_srh" name="sub_cat_srh" class="form-control search-select">
                                                         
								                                <option value="">--Select Sub Category--</option>
									                             <?php foreach ($sub_category_list as $key => $sup) {
																	 ?>
									                               <option value="<?php echo $sup->sub_cat_id; ?>"><?php echo $sup->cat_name; ?> / <?php echo $sup->sub_cat_name; ?> </option>
                                                                    <?php
									                             } ?>  
                                                                
								                             </select>                                                           
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
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                     <th>Category</th>
                                      <th>Sub Category</th>
                                    </tr>
							          </thead>
							          <tfoot>
										 <tr>
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                     <th>Category</th>
                                      <th>Sub Category</th>
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
		<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script>
      
       <script>
	   	function searchDetails(){
			products_load();
		}
			jQuery(document).ready(function() {
				
				 $("#cat_srh").select2();
				  $("#sub_cat_srh").select2();
				 
				//TableData.init();
				products_load();
			});


			function products_load() {
				var srh_warehouse_id=1;
				var cat_srh=$('#cat_srh').val();
				var sub_cat_srh=$('#sub_cat_srh').val();

					    $('#products_table').DataTable({
					        "ajax": {
							'type': 'POST',
							'url': '<?php echo base_url('reports/get_list_product_for_code_print');?>',
							'data': {
							   srh_warehouse_id: 1,
							   cat_srh: cat_srh,
							    sub_cat_srh: sub_cat_srh,
							}
							},
					        "bDestroy": true,
					        "iDisplayLength": 20,
							"order": [[ 1, "asc" ]]
					    
					    });
						
						

					}
					

function fbs_click_list(url) {
	var cat_srh=$('#cat_srh').val();
	var sub_cat_srh=$('#sub_cat_srh').val();
	url=url+'/'+cat_srh+'/'+sub_cat_srh;
	u=location.href;
	t=document.title;
	window.open(url,'sharer','toolbar=0,status=0,width=850,height=436, left=10, top=10,scrollbars=yes');return false;
}
	
						
function fbs_click(url) {
	var cat_srh=$('#cat_srh').val();
	var sub_cat_srh=$('#sub_cat_srh').val();
	url=url+'/'+cat_srh+'/'+sub_cat_srh;
	u=location.href;
	t=document.title;
	window.open(url,'sharer','toolbar=0,status=0,width=850,height=436, left=10, top=10,scrollbars=yes');return false;
}
		</script>

     
	</body>
	<!-- end: BODY -->
</html>