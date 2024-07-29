<?php 
$tmp_id=0;
$tmp_th_e=0;
$tmp_sr_id=0;
$vcl_srvs_inv_header=0;
$service_sub_tot=0;
$parts_sub_tot=0;
$technician_sub_tot=0;
$grand_total_sub_tot=0;
$loan_title='';
//$loan_id=8;


?>
<?php $this->load->view("common/header"); ?>
<!-- end: HEAD -->

<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/jQuery-Tags-Input/jquery.tagsinput.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/summernote/build/summernote.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>css/jquery-ui.css">
<style type="text/css">
label {
	font-weight: 700;
}
.table > thead:first-child > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table-striped thead tr.primary:nth-child(2n+1) th {
	background-color:#666;
			    border-color: #666;
			    border-top: 1px solid #666;
			    color: white;
			    text-align: center;
}
.form-horizontal .form-group {
	margin-left: 0;
	margin-right: 0;
}
</style>
<style type="text/css">
label {
	font-weight: 700;
}
.table > thead:first-child > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table-striped thead tr.primary:nth-child(2n+1) th {
	background-color:#666;
			    border-color: #666;
			    border-top: 1px solid #666;
			    color: white;
			    text-align: center;
	font-size: 14px;
}
.form-horizontal .form-group {
	margin-left: 0;
	margin-right: 0;
}
td {
	font-size: 13px;
}
</style>

<!-- end: HEAD -->

<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/select2/select2.css" />
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/jQuery-Tags-Input/jquery.tagsinput.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/summernote/build/summernote.css">
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- end: HEAD -->
<!-- start: BODY -->
<body>
<!-- start: HEADER -->
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
									<a href="#">
										 Dashboard 
									</a>
								</li>
                                
								<li>
									<a href="<?php echo base_url('requisition'); ?>">
										Requisition
									</a>
								</li>

								<li class="active">
										Add Salea
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
								<h1>Add Requisition </h1>
							</div>

                            <p>Please fill in the information below. The field labels marked with * are required input fields.</p>
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
									<i class="fa fa-plus"></i>
									Add Requisition
								</div>
								<div class="panel-body">
                            <div class="alert alert-danger" style="display:none;">
                                <button class="close" data-dismiss="alert">
                                    ×
                                </button>
                                <i class="fa fa-times-circle"></i>
                                <strong></strong> <span class="errortxt"></span>
                            </div>
                         <div class="alert alert-success" style="display:none;">
                                <button class="close" data-dismiss="alert">
                                    ×
                                </button>
                                <i class="fa fa-check-circle"></i>
                                <strong></strong><span class="succetxt"></span>
                            </div> 
                            
                            
                                
                                
                   		<form role="form" class="form-horizontal" id="create_requisition_form" action="#" method="post">
                        
                        <div class="col-md-12"></div><!--col-md-12-->
                        <div class="col-md-12">
                                  
                                    
                     
                       <!-- <div class="col-md-4">
                            <div class="form-group">
                                <label>Serial No</label>
                                
                                <input type='text' class="form-control" id="qts_reference_no" name="qts_reference_no" value="" readonly/>
                            </div>
                        </div>
-->
                                        
										
                                        

                                        <div class="col-md-12">
											<div class="panel panel-default">
												<div class="panel-heading" style="font-weight: 700;">Please select these before adding any product</div>
													<div class="panel-body">
														
                                                        <div class="col-sm-4">
                                                      	<div class="form-group">
															<label>Project Name * </label>
                                                          <select id="warehouse_id" class="form-control" name="warehouse_id">
                                                                    <!--<option value="">-- Select Warehouse --</option>-->
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
                                                                        
															<option value="<?php echo $row->id; ?>">
																		<?php echo $row->name; ?>
                                                                        </option>
                                                              <?php }?>
																		
																	</select>
                                                             
														</div>
														</div>
                                                        
                                                         <div class="col-md-4">
                            <div class="form-group">
                            <?php // print_r($req_details);
							//echo $req_details->req_datetime;
							
							?>
                                <label>Date *</label>
                               
                            
                                    <input id="qts_datetime" name="qts_datetime" type='text' class="form-control date-picker" 
                                    value="<?php if(!$req_id){echo date('m/d/Y');} else echo date('m/d/Y', strtotime($req_details->req_datetime)); ?>" data-bv-field="date"/>

                            </div>
                        </div>
                                                        
                                                        
													</div>
												</div>
											</div>
										</div> <!--col-md-8-->
                                        

                                        
                                        <!-- item add box-->
                                        <div id="sticker" class="col-md-12">
											<div class="well well-sm">
												<div class="form-group">
                                        <!-- auto complete start -->
                                        	<div class="input-group wide-tip">
													<div style="padding-left: 10px; padding-right: 10px;" class="input-group-addon">
														<i class="fa fa-2x fa-barcode addIcon"></i>
													</div>
													<input type="text" placeholder="Please add products to order list" id="add_item" class="form-control input-lg" value="" name="add_item"  style="border-radius: 6px;font-size: 18px;height: 46px;line-height: 1.33;padding: 10px 16px;">
														<!--<div style="padding-left: 10px; padding-right: 10px;" class="input-group-addon">
															<i id="addIcon" class="fa fa-2x fa-plus-circle addIcon"></i>

														</div>-->
												</div>
                                        <!-- end auto complete end -->
                                                
                                               
											</div>


											<div class="clearfix"></div>
											<div class="control-group table-group">
												<label class="table-label">Order Items</label>
													<div class="controls table-controls">
                                                    
														<table class="table items table-striped table-bordered table-condensed table-hover" id="requisition_tbl">
															<thead>
																<tr>
																	<th class="col-md-4">Full Description Materials</th>
																	<th style="width:60px;">Unit</th>
																	<th style="width:60px;"">Qty in Stock</th>
																	<th class="col-md-1 text-right">Bin Card No.</th>
																	<th style="width:60px;">Required Qty</th>
																	<th class="col-md-1 text-right">Required Date </th>
																	
																	<th class="text-right">Remarks</th>
																	<th style="width: 30px !important; text-align: center;"><i class="fa fa-trash-o"></i></th>
																</tr>
                                                                </thead>
																	<tbody>
<?php 
//print_r($reqitm_list);
$tmp_th_e=0;
if(count($reqitm_list)){ 
foreach ($reqitm_list as $key => $reqitm_dtls) {
	$tmp_th_e++;
?>
<tr id="row_e_<?php echo $tmp_th_e;?>">
			<td class="text-left">
			<input type="text" style="width:100%; text-align:left" name="row_e[<?php echo $tmp_th_e;?>][product_name][]" id="product_name_<?php echo $tmp_th_e;?>" value="<?php echo $reqitm_dtls->product_name;?>" class="pymnt_amount">
            <!--<input type="hidden" name="row_e[$tmp_th_e][product_id][]" id="product_id_$tmp_th_e" value="<?php $pro_dlts->product_id;?>">-->
			</td>
			<td>
			<input type="text" style="width:100%; text-align:right" name="row_e[1][product_unit][]" id="product_unit_<?php echo $tmp_th_e;?>" value="<?php echo $reqitm_dtls->product_unit;?>" class="product_unit">
			</td>
			<td>
			<input type="text" style="width:100%; text-align:right" name="row_e[1][qty_in_stock][]" id="qty_in_stock_<?php echo $tmp_th_e;?>" value="<?php echo $reqitm_dtls->qty_in_stock;?>" class="qty_in_stock">
			</td>
			
			
			<td><input type="text" style="text-align:left; width:100px" name="row_e[1][bin_card_no][]" id="bin_card_no_<?php echo $tmp_th_e;?>" value="<?php echo $reqitm_dtls->bin_card_no;?>"></td>
			<td><input type="text" style="text-align:left; width:100px" name="row_e[1][required_qty][]" id="required_qty_<?php echo $tmp_th_e;?>" value="<?php echo $reqitm_dtls->required_qty;?>"></td>
			<td>
			<input type="text" style="width:100px; text-align:right" name="row_e[1][required_date][]" id="required_date_<?php echo $tmp_th_e;?>" value="<?php echo date('m/d/Y', strtotime($reqitm_dtls->required_date));?>" class="required_date date-picker">
           
			</td>
			<td align="right">
            <input type="text" style="width:100%; text-align:left" name="row_e[1][reqitm_remarks][]" id="reqitm_remarks_<?php echo $tmp_th_e;?>" value="<?php echo $reqitm_dtls->reqitm_remarks;?>" class="reqitm_remarks">
			
			
			</td>
			<td><a onClick="deleteRequisitionItem(<?php echo $tmp_th_e;?>)"><i class="fa fa-times tip podel" id="1446800197032" title="Remove" style="cursor:pointer;"></i></a></td>
			</tr>
<?php  } }?>
															
																		
																	</tbody>
															<tfoot>
															
                                                              
															</tfoot>
														</table>
                                                        
                                                        
                                                        <!-- start list -->
                                                        <!-- end list -->
													</div>
											  </div>
											</div>
                                        <!-- end item add box-->

									
                                                
                                                <div id="extras-con" class="row">
															<!--<div class="col-md-4">
																<div class="form-group">
																	<label for="potax2">Order Tax</label>
																	<select id="tax_rate_id" class="form-control" name="tax_rate_id">
                                                                   
																  <?php 
                                                              foreach ($tax_rates_list as $row)
                                                              {
																  
                                                              ?>  
                                                                        
																		<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?>
                                                                        </option>
                                                              <?php }?>
																		
																	</select>
																</div>
															</div>-->
                                                            
                                                            
                                        
                                        <!--<div class="col-md-4">
											<div class="form-group">
												<label>Shipping</label>
					                             <input type="text" title="" data-original-title="" name="sale_shipping" value="" class="form-control input-tip" id="sale_shipping">
											</div>
										</div>-->
                                        
                                      <!-- <div class="col-md-4">
															<div class="form-group">
													<label for="poshipping">Payment Status *</label>
													 <select id="payment_status" class="form-control selectpicker" name="payment_status">
                                                      <option value="Paid">Paid</option>
                                                     <option value="Pending">Pending</option>
                                                     <option value="Due">Due</option>
                                                     <option value="Partial">Partial</option>
                                                    
					                             </select>
															</div>
														</div>-->
                                        
                                        <!--<div class="col-md-4">
											<div class="form-group">
												<label>Sale Status *</label>
					                            <select id="sale_status" name="sale_status" class="form-control selectpicker">
                                                    <option value="Completed">Completed</option>
                                                     <option value="Pending">Pending</option>
					                             </select>
											</div>
										</div>-->
															<!--<div class="col-md-4">
																<div class="form-group">
																	<label for="podiscount">Payment Term</label>
																	<input type="text" id="sale_payment_term" class="form-control input-tip" value="" name="sale_payment_term" data-original-title="" title="">
																</div>
															</div>
														-->
                                                        
     
													</div>
                                                    
                                                    
                                                    
                                         
                                        
                                       			
										
													
                                        
                        </div> <!-- end: col-md-12-->
                        
                        
                        
                    
						
                        	<!--<div class="col-md-6">
                            <div class="form-group">
										<label for="form-field-23">
											Safe Note
										</label>
										<textarea class="form-control limited" id="form-field-23" maxlength="50"></textarea>
									</div>
                            </div>--><!-- col-md-6-->
                           
                            
                          <!-- <div class="col-md-6">
                            <div class="form-group">
										<label for="form-field-23">
											Staff Note
										</label>
										<textarea class="form-control limited" id="form-field-23" maxlength="50"></textarea>
									</div>
                            </div>--><!-- col-md-6-->
                        
                       
                        
                        <div class="col-md-12">
                        <div class="modal-footer" style="margin-bottom:10px;">
            				<input type="submit" class="btn btn-primary" value="Add Requisition" name="add_quotation" id="add_quotation"> <button id="reset" class="btn btn-danger" type="button">Reset</button>
            			</div>
                        </div>
                         <input name="qts_inv_discount_amount" type="hidden" id="sale_inv_discount_amount" value="0">
                        <input name="qts_total" type="hidden" id="sale_total" value="0">
                        <input name="qts_paid" type="hidden" id="sale_paid" value="0">
                        <input name="qts_balance" type="hidden" id="sale_balance" value="0">
                        <input name="rowCount" type="hidden" id="rowCount" value="<?php echo count($reqitm_list);?>">
                        <input name="req_id" type="hidden" id="req_id" value="<?php echo $req_id;?>">
                        
                        
                        
                       
                        
                   		 </form>
									
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


<input name="tmpVal" type="hidden" id="tmpVal" value="0">


		<!-- start ajax model -->
		<div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
		<!-- end ajax model -->
                
               					
 
                                    
		<!-- end: RIGHT SIDEBAR -->
		<!-- start: MAIN JAVASCRIPTS -->
<?php $this->load->view("common/footer"); ?>
<script src="<?php echo asset_url(); ?>js/jquery-ui.js" ></script>
<script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script> 

<!-- end: MAIN JAVASCRIPTS --> 

 		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
		<script src="<?php echo asset_url(); ?>js/form-validation-create_requisition.js"></script>
        <script src="<?php echo asset_url(); ?>js/requisition.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
        
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
        <script src="<?php echo asset_url(); ?>js/form-validation-loan_add.js"></script> 
<script src="<?php echo asset_url(); ?>js/loan_add.js"></script> 
<script src="<?php echo asset_url(); ?>js/loan_extra_itm_add.js"></script> 


		<script src="<?php echo asset_url(); ?>/plugins/jquery-inputlimiter/jquery.inputlimiter.1.3.1.min.js"></script>
		<script src="<?php echo asset_url(); ?>/plugins/autosize/jquery.autosize.min.js"></script>
		<script src="<?php echo asset_url(); ?>/plugins/select2/select2.min.js"></script>
		<script src="<?php echo asset_url(); ?>/plugins/jquery.maskedinput/src/jquery.maskedinput.js"></script>
		<script src="<?php echo asset_url(); ?>/plugins/jquery-maskmoney/jquery.maskMoney.js"></script>
		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-daterangepicker/moment.min.js"></script>
		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-colorpicker/js/commits.js"></script>
		<script src="<?php echo asset_url(); ?>/plugins/jQuery-Tags-Input/jquery.tagsinput.js"></script>
		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
		<script src="<?php echo asset_url(); ?>/plugins/summernote/build/summernote.min.js"></script>
		<script src="<?php echo asset_url(); ?>/plugins/ckeditor/ckeditor.js"></script>
		<script src="<?php echo asset_url(); ?>/plugins/ckeditor/adapters/jquery.js"></script>
		<script src="<?php echo asset_url(); ?>/js/form-elements.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script>
		
		
			jQuery(document).ready(function() {

				FormElements.init();

			});


		</script>
</body>
	<!-- end: BODY -->
</html>