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
	 background-color: #428bca;
				    border-color: #357ebd;
				    border-top: 1px solid #357ebd;
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
									<a href="<?php echo base_url('service'); ?>">
										Service
									</a>
								</li>

								<li class="active">
										Add Service
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
								<h1><?php if ($service_id) echo 'Update'; else 'Add'; ?> Service </h1>
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
									Add Service
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
                            
                            
                                
                                
                   		<form role="form" class="form-horizontal" id="create_service_form" action="#" method="post">
                        
                        <div class="col-md-12"></div><!--col-md-12-->
                        <div class="col-md-12">
                                  
                                    
                     
                       <!-- <div class="col-md-4">
                            <div class="form-group">
                                <label>Serial No</label>
                                
                                <input type='text' class="form-control" id="qts_reference_no" name="qts_reference_no" value="" readonly/>
                            </div>
                        </div>
-->
                                        
										
                                        

                                        <div class="col-md-12"><?php //print_r($po_details);?>
											<div class="panel panel-default">
												<div class="panel-heading" style="font-weight: 700;">Please select these before adding any product</div>
													<div class="panel-body">
														<div class="col-sm-4">
                                                      	<div class="form-group">
															<label>Customer * </label>
                                                       <input type="text" id="cus_name" name="cus_name" class="form-control"data-bv-field="date" value="<?php if(isset($service_details->cus_name)){echo $service_details->cus_name;}  ?>">
                                                             
														</div>
														</div>
                                                        
                                                      <div class="col-sm-4">
                                                        <div class="form-group">
                                                        
											<label>
												Service Number
											</label>
											<br/>
												<input type="text" id="service_reference_no" name="service_reference_no" class="form-control"data-bv-field="date" value="<?php if(isset($service_details->service_reference_no)){echo $service_details->service_reference_no;}  ?>">
											</div>
										</div>     
                                                        
                                                         <div class="col-md-4">
                            <div class="form-group">
                            <?php // print_r($service_details);
							//echo $service_details->service_datetime;
							
							?>
                                <label>Service Start Date *</label>
                               
                            
                                    <input id="service_datetime" name="service_datetime" type='text' class="form-control date-picker" 
                                    value="<?php if(!$service_id){echo date('m/d/Y');} else echo date('m/d/Y', strtotime($service_details->service_datetime)); ?>" data-bv-field="date"/>

                            </div></div>
                            
                             <div class="col-md-4">
                            <div class="form-group">
                            <?php // print_r($service_details);
							//echo $service_details->service_datetime;
							
							?>
                                <label>Return Date *</label>
                               
                            
                                    <input id="service_return_date" name="service_return_date" type='text' class="form-control date-picker" 
                                    value="<?php if(!$service_id){echo date('m/d/Y');} else echo date('m/d/Y', strtotime($service_details->service_return_date)); ?>" data-bv-field="date"/>

                            </div></div>
                             <div class="col-md-4">
                            <div class="form-group">
															<label>Supplier  * </label><?php //print_r($suppliers);?>
                                                          <select id="supp_id" class="form-control search-select" name="supp_id">
                                                                  <option value="">-- Select --</option>
																  <?php 
															
															foreach ($suppliers as $row)
															{
																$sel='';
																if($service_details->service_customer_id==$row['supp_id']){
																$sel='selected';
																}
															?> 
																							   <option <?php echo $sel; ?>  value="<?php echo $row['supp_id'];?>"><?php echo $row['supp_company_name']; ?></option>
															 <?php }  ?>
																		
																	</select>
                                                             
														</div></div>
                                                      <!--  <div class="col-sm-4">
                                                        <div class="form-group">
                                                        
											<label>
												Responsible Person *
											</label>
											<br/>
												<input type="text" id="service_responsible_person" name="service_responsible_person" class="form-control"data-bv-field="date" value="<?php if(isset($service_details->service_responsible_person)){echo $service_details->service_responsible_person;}  ?>">
											</div>
										</div>
                                        
                                         <div class="col-sm-4">
                                                        <div class="form-group">
                                                        
											<label>
												Current Mileage 
											</label>
											<br/>
												<input type="text" id="current_mileage" name="current_mileage" class="form-control"data-bv-field="date" value="<?php if(isset($service_details->current_mileage)){echo $service_details->current_mileage;}  ?>">
											</div>
										</div>   -->
                                        
                                          
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
                                                    
														<table class="table items table-striped table-bordered table-condensed table-hover" id="service_tbl">
															<thead>
																<tr>
																	<th class="col-md-4">Item Name</th>
																	<th style="width:80px;">Unit</th>
																	<th style="width:80px;"">QTY</th>
																	<th style="width:80px;"">Repair Free </th>
																	<th style="width:60px;">Discount</th>
																	<th class="text-right col-md-2">Amount</th>
																	<th style="width: 30px !important; text-align: center;"><i class="fa fa-trash-o"></i></th>
																</tr>
                                                                </thead>
																	<tbody>
                                                                    
<?php 

//print_r($serviceitm_list);
$tmp_th_e=0;
if(count($serviceitm_list)){ 
foreach ($serviceitm_list as $key => $serviceitm_dtls) {
	$tmp_th_e++;
?>
<tr id="row_e_<?php echo $tmp_th_e;?>">
			<td class="text-left">
            <?php echo $serviceitm_dtls->product_name;?>
			<input type="hidden" style="width:100%; text-align:left" name="row_e[<?php echo $tmp_th_e;?>][product_name][]" id="product_name_<?php echo $tmp_th_e;?>" value="<?php echo $serviceitm_dtls->product_name;?>" class="pymnt_amount">
            <!--<input type="hidden" name="row_e[$tmp_th_e][product_id][]" id="product_id_$tmp_th_e" value="<?php //$pro_dlts->product_id;?>">-->
			</td>
			<td>
            <?php echo $serviceitm_dtls->unit_name ?>
           
			<input type="hidden" style="width:100%; text-align:right" name="row_e[<?php echo $tmp_th_e;?>][product_unit][]" id="product_unit_<?php echo $tmp_th_e;?>" value="<?php echo $serviceitm_dtls->product_unit;?>" class="product_unit">
			
			</td>
			<td>
            <input type="text" style="width:100%; text-align:right" name="row_e[<?php echo $tmp_th_e;?>][serviceitm_qty][]" id="serviceitm_qty_<?php echo $tmp_th_e;?>" value="<?php echo $serviceitm_dtls->serviceitm_qty;?>" class="serviceitm_qty" onChange="changeQtyByProductID(this.value,<?php echo $tmp_th_e;?>);">
            </td>
			<td> <?php //echo $serviceitm_dtls->itm_charge_type; 
			echo "<input type=\"text\" style=\"width:100%; text-align:right\" name=\"row_e[$tmp_th_e][product_service_charge][]\" id=\"itm_charge_type_$tmp_th_e\" value=\"$serviceitm_dtls->product_service_charge\" class=\"serviceitm_qty\" onChange=\"calculateTotal()\">"; ?>
			  </td>
			<td>
			  <?php echo "<input type=\"text\" style=\"width:100%; text-align:right\" name=\"row_e[$tmp_th_e][serviceitm_dis][]\" id=\"serviceitm_dis_$tmp_th_e\" value=\"$serviceitm_dtls->serviceitm_dis\" class=\"serviceitm_dis\" onchange=\"changeDiscountByProductID(this.value,1);\" onclick=\"this.select(); setTmpVal(this.value);\">
			<input type=\"hidden\" style=\"width:100%; text-align:right\" name=\"row_e[$tmp_th_e][serviceitm_dis_val][]\" id=\"serviceitm_dis_val_$tmp_th_e\" value=\"$serviceitm_dtls->serviceitm_dis_val\" class=\"serviceitm_dis_val\">" ?>
			  </td>
			<td align="right">
			<?php echo "<input type=\"text\" style=\"width:100%; text-align:right\" name=\"row_e[$tmp_th_e][sub_total_item][]\" id=\"sub_total_item_$tmp_th_e\" value=\"$serviceitm_dtls->sub_total_item\" class=\"\">"; ?>
</td>
			 
			<td><a onClick="deleteServiceItem(<?php echo $tmp_th_e;?>)"><i class="fa fa-times tip podel" id="1446800197032" title="Remove" style="cursor:pointer;"></i></a></td>
			</tr>
<?php  } }?>

<tr>
																	  <td colspan="5" class="text-right">Total</td>
																	 
                                                                      <td><input id="service_total" name="service_total" type="text" class="text-right" style="width:100%" readonly></td>
                                                                       <td></td>
                                                                      </tr>
																	  <tr>
																	    <td colspan="5" class="text-right">Discount</td>
																	    <td>
                                                                         <?php 
						
						?>
                                                                        <input id="service_discount" name="service_discount" type="text" class="text-right" style="width:100%" onChange="calculateTotal();" value="<?php if(isset($service_details->service_discount)){echo $service_details->service_discount;}?>">
                                                                        <input id="service_discount_amt" name="service_discount_amt" type="hidden" class="text-right" style="width:100%" value="<?php if(isset($service_details->service_discount_amt)){echo $service_details->service_discount_amt;}  ?>"></td>
                                                                         <td></td>
                                                                        </tr>
																      <tr>
																	  <td colspan="5" class="text-right">Net Total</td>
																	  <td>
                                                                      <input style="width:100%" name="service_net_total" id="service_net_total" type="text" readonly class="text-right">
                                                                      </td> <td></td>
                                                                      </tr>
															
																		
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

									
                                                
                                              
                                                    
                                                    
                                                    
                                         
                                        
                                       			
										
													
                                        
                        </div> <!-- end: col-md-12-->
                        
                        
                        
                    
						
                        
                       
                        <div class="col-sm-12">
                       <?php 
						//echo "dtls:".$service_details->service_discount;
						?>
                                                        <div class="form-group">
                                                        
											<label>
												Nature of Work
											</label>
											<br/>
                                            
<textarea class="form-control" cols="10" rows="2" name="nature_of_work" ><?php if(isset($service_details->nature_of_work)){echo $service_details->nature_of_work;}  ?></textarea>
                                            
											
											</div>
										</div>  
                        
                        <div class="col-md-12">
                        <div class="modal-footer" style="margin-bottom:10px;">
            				<input type="submit" class="btn btn-primary" value="Submit" name="add_quotation" id="add_quotation"> <button id="reset" class="btn btn-danger" type="button">Reset</button>
            			</div>
                        </div>
                         <input name="qts_inv_discount_amount" type="hidden" id="sale_inv_discount_amount" value="0">
                        <input name="qts_total" type="hidden" id="sale_total" value="0">
                        <input name="qts_paid" type="hidden" id="sale_paid" value="0">
                        <input name="qts_balance" type="hidden" id="sale_balance" value="0">
                        <input name="rowCount" type="hidden" id="rowCount" value="<?php echo count($serviceitm_list);?>">
                        <input name="service_id" type="hidden" id="service_id" value="<?php echo $service_id;?>">
                         <input name="service_reference_no" type="hidden" id="service_reference_no" value="<?php if (isset($service_details->service_reference_no)) echo $service_details->service_reference_no; ?>">
                        
                        
                        
                       
                        
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


<input name="tmpVal" type="text" id="tmpVal" value="0">


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
		<script src="<?php echo asset_url(); ?>js/form-validation-create_service.js"></script>
    <script src="<?php echo asset_url(); ?>js/service.js"></script>
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
				
				$("#supp_id").select2();
				calculateTotal();
				
				function deleteRequisitionItem(val){
				alert();	
				}
				//Main.init();
				
				//$('#loan_date').val('29-07-2016')
				

		
			});
			
function changeQtyByProductID(qty,nxtCount){
	//alert(qty+' '+nxtCount);
	
	if(isNaN(qty)) {
		displayNotice('page','Invalid Quantity');
		var quantity_fld='#serviceitm_qty'+nxtCount;
		var product_id_fld='#product_id'+nxtCount;
		
		//alert(quantity_fld);
		var oldVal=$('#tmpVal').val();
		$(quantity_fld).val(oldVal); //set last val
	}else {
		//getavalable product count
		var product_id_fld='#product_id'+nxtCount;
		var product_id=$(product_id_fld).val();
		
		var warehouse_id=$('#warehouse_id').val();

		//end getavalable product count
		calculateTotal();
		//displayNotice('page','Product quantity successfully updated!');
	}
}

function getNextRefNo(){
	//return 'SALE/2015/11/0001';
	//alert();
	
	$.post( "<?php echo base_url();?>service/get_next_ref_no")
	  .done(function( data ) {
		  var obj = jQuery.parseJSON(data);
		  $('#qts_reference_no').val(obj.qts_reference_no);
	  });
	//return false;
}

function insertPurchases_OrderData(){
	var type='A';
	var qts_reference_no=$('#qts_reference_no').val();
	 var fields = $("#create_service_form").serialize();
	  
	  var rowCount=$('#rowCount').val();

	  if(rowCount!=0){
		 // $("#add_quotation").prop("disabled", true);
		//  $("#add_quotation").val('Please wait...');

		 // create_service_form.add_quotation.disabled = true;
   		// create_service_form.add_quotation.value = "Please wait...";
    	//	return true;
	
	//alert(fields);
	//type:type, qts_reference_no:qts_reference_no
	$.post( "<?php echo base_url();?>service/save_service", fields)
	  .done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
				
				$('.alert-success').hide();
				$('.alert-danger').show();
				$( ".errortxt" ).text( obj.disMsg );
				window.scrollTo(500, 0);
				//empty item table
				
			}
			if(obj.error==0){
				//$('.alert-danger').hide();
				//$('.alert-success').show();
				//$( ".succetxt" ).text( obj.disMsg );
				window.scrollTo(500, 0);
				//$("#soTable tr:gt(0)").remove();
				$("#soTable > tbody").empty();
				displayNotice('page','Service successfully added!');
				
				clearForm();
				//empty footer details
				
				//alert(obj.qts_id);
				sendUrl='service/details/'+obj.service_id;
				//alert(sendUrl);
				//window.location.href = "<?php echo base_url();?>"+sendUrl;
				
			}
			
			
	  });
return false;

	  }else  {
		 bootbox.alert('Please add products.', function () {
                        $('#add_item').focus();
                    });
	  }
	  
}



        //ItemnTotals();
        $("#add_item").autocomplete({
            source: '<?php echo base_url();?>service/suggestions',
            minLength: 1,
            autoFocus: false,
            delay: 5,
            response: function (event, ui) {
			
				if (ui.content.length == 1 && ui.content[0].product_id != 0)
				{
					//ui.item = ui.content[0];
 					//$(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
					//$(this).autocomplete('close');
                   // $(this).removeClass('ui-autocomplete-loading');
				}else if(ui.content.length ==0){
					var noResult = { value:"",label:"No matching result found! Product might be out of stock in the selected warehouse." };
            		ui.content.push(noResult);
				}else {

				}
			
            },
            select: function (event, data) {
				//alert( "You selected: " + data.item.product_id );
				if(data.item.value){
					$('#rowCount').val(parseInt($('#rowCount').val())+1);
					
					//alert();
					
					/* start add items */ 
						//start get data
							$.ajax({
							url : "<?php echo base_url();?>service/service_add_row",
							type: "POST",
							data : {id:data.item.id,warehouse_id:$('#warehouse_id').val(),rowCount:$('#rowCount').val(),service_datetime:$('#service_datetime').val(),service_return_date:$('#service_return_date').val(),service_customer_id:$('#service_customer_id').val(),product_charge_type:$('#product_charge_type').val(),service_diposit:$('#service_diposit').val(),service_responsible_person:$('#service_responsible_person').val()},
							success: function(data)
							{
							var obj = jQuery.parseJSON(data);
							if (obj.status==1) 
							{
								//alert(parseInt($('#rowCount').val()));
							//alert(obj.bkng_refno);
							var row_details=obj.row_details;
							//$('#service_tbl tr:last').before(row_details);
							$('#service_tbl tr:first').after(row_details);
							var datefld='#pouired_date_'+(parseInt($('#rowCount').val()))
							//alert(datefld);
							$( datefld ).datepicker();
							
							//alert(row_details);
							return false;									
							} 
							else {
								//msg
								 bootbox.alert('Please select above details: '+obj.msg, function () {
                        $('#add_item').focus();
                    });
							}
							}
							});
					
					/* end add items */ 
					
				//addProductToListByID(data.item.product_id,data.item.product_name,data.item.product_code,data.item.product_price,data.item.product_part_no,data.item.product_oem_part_number);
				$("#add_item").val('');
					 return false;
				}
				$(this).autocomplete('close');
                    $(this).removeClass('ui-autocomplete-loading');
				
            }
        });
		
		$(window).scroll(function() {
   if($(window).scrollTop() + $(window).height() == $(document).height()) {
       //alert("bottom!");
	   $('#bottom-total').css({
        position: 'static',
		width: '100%'
    });
   }else {
	    $('#bottom-total').css({
        position: 'fixed',
		width: '1082px'
    });
   }
});

//function to initiate bootstrap-datepicker
$(function () {
	//showKeys();
	
	var curserviceDate = new Date();
	
	
	$('#pouired_date_1_del').datetimepicker({
		defaultDate: new Date()
		});
	
	//$("#warehouse_id").select2();
	//$("#supp_id").select2();
	$("#customer_id").select2();
	
});	
		</script>
</body>
	<!-- end: BODY -->
</html>