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
	.table>thead:first-child>tr:first-child>th,
	.table>thead:first-child>tr:first-child>td,
	.table-striped thead tr.primary:nth-child(2n+1) th {
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
								<a href="#">
									Dashboard
								</a>
							</li>
							<li>
								<a href="<?php echo base_url('stock_req'); ?>">
									Quotations
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
											<i class="fa fa-search"></i>
										</button>
									</div>
								</form>
							</li>
						</ol>
						<div class="page-header">
							<h1>Add Stock Request </h1>
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
								Save Request
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
								<form role="form" class="form-horizontal" id="create_quotations_form" action="#" method="post">
									<div class="col-md-12"></div><!--col-md-12-->
									<div class="col-md-12">
										<div class="col-md-4">
											<div class="form-group">
												<label>Date *</label>
												<?php $nowdate = date("Y-m-d H:i:s"); ?>
												<input id="qts_datetime" name="qts_datetime" type='text' class="form-control date" value="" data-bv-field="date" />
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>S.R No</label>
												<input type='text' class="form-control" id="req_reference_no" name="req_reference_no" value="" readonly />
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Requesting stock for the date of</label>
												<input type='date' class="form-control" id="reqesting_for_date" name="reqesting_for_date" value="" min="<?php echo date("Y-m-d")?>" />
											</div>
										</div>
										<div class="col-sm-4">
    										<div class="form-group">
    											<label>Requesting From * </label>
    											<select id="warehouse_id" class="form-control" name="warehouse_id">
    												<!--<option value="">-- Select Warehouse --</option>-->
    												<?php
    												$ss_warehouse_id = $this->session->userdata('ss_warehouse_id');
    												foreach ($warehouse_list as $row) {
    													$sel = '';
    													if ($ss_warehouse_id == $row->id) {
    														$sel = ' selected="selected"';
    													}
    												?>
    													<option <?php echo $sel; ?> value="<?php echo $row->id; ?>">
    														<?php echo $row->name; ?>
    													</option>
    												<?php } ?>
    											</select>
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
													<input type="text" placeholder="Please add products to order list" id="add_item" class="form-control input-lg" value="" name="add_item" style="border-radius: 6px;font-size: 18px;height: 46px;line-height: 1.33;padding: 10px 16px;">
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
													<table class="table items table-striped table-bordered table-condensed table-hover" id="soTable">
														<thead>
															<tr>
																<th class="col-md-7" style="width:40%">Product Name (Product Code)</th>
																<th class="col-md-3">Quantity</th>
																<th class="col-md-2" style="text-align: center;"><i class="fa fa-trash-o"></i></th>
															</tr>
														</thead>
														<tbody></tbody>
														<tfoot></tfoot>
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
																	foreach ($tax_rates_list as $row) {
																	?>  
                                                                        
																		<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?>
                                                                        </option>
                                                              <?php } ?>
																		
																	</select>
																</div>
															</div>-->
											<div class="col-md-4">
												<div class="form-group">
													<label>Order Discount</label>
													<input type="text" title="" data-original-title="" value="" class="form-control input-tip" id="sale_inv_discount" name="qts_inv_discount" onChange="changeMainDiscount(this.value)">
												</div>
											</div>
											
										</div>
									</div> 
									<div class="col-md-12">
										<div class="modal-footer" style="margin-bottom:10px;">
											<input type="submit" class="btn btn-primary" value="Add Quotation" name="add_quotation" id="add_quotation"> <button id="reset" class="btn btn-danger" type="button">Reset</button>
										</div>
									</div>
									<input name="qts_inv_discount_amount" type="hidden" id="sale_inv_discount_amount" value="0">
									<input name="qts_total" type="hidden" id="sale_total" value="0">
									<input name="qts_paid" type="hidden" id="sale_paid" value="0">
									<input name="qts_balance" type="hidden" id="sale_balance" value="0">
									<input name="rowCount" type="text" id="rowCount" value="0">
								</form>
								<!-- end: DYNAMIC TABLE PANEL -->
								<!-- footer amount details -->
								<div style="margin-bottom: 0px; position: fixed; bottom: 0px; width: 1082px; z-index: 50000;" class="well well-sm" id="bottom-total">
									<table style="margin-bottom:0;" class="table table-bordered table-condensed totals">
										<tbody>
											<tr class="warning">
												<td width="30%">Total <span id="f_total" class="totals_val pull-right">0.00</span></td>
												<td width="30%">Order Discount <span id="tds" class="totals_val pull-right">0.00</span></td>
												<td>Grand Total <span id="gtotal" class="totals_val pull-right">0.00</span></td>
											</tr>
										</tbody>
									</table>
								</div>
								<!-- end footer amount details -->
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
				<input name="tmpVal" type="hidden" id="tmpVal" value="0">
				<!-- start ajax model -->
				<div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
				<!-- end ajax model -->
				<!-- start: MAIN JAVASCRIPTS -->
				<?php $this->load->view("common/footer"); ?>
				<script src="<?php echo asset_url(); ?>js/jquery-ui.js"></script>
				<script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script>
				<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script>
				<script type="text/javascript" src="<?php echo asset_url(); ?>js/perches.js"></script>
				<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>
				<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
				<!-- end: MAIN JAVASCRIPTS -->
				<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
				<script src="<?php echo asset_url(); ?>js/form-validation-create_quotations.js"></script>
				<script src="<?php echo asset_url(); ?>js/sr.js"></script>
				<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
				<script>
					clearForm();
					/*$(document).ready(function() {
					  $(window).keydown(function(event){
					    if(event.keyCode == 13) {
					      event.preventDefault();
					      return false;
					    }
					  });
					});*/
					$('#add_item').keypress(function(e) {
						if (e.which == 13) return false;
						//or...
						if (e.which == 13) e.preventDefault();
					});
					function addextraprice() {
						calculateTotal();
					}
					
					function changeQtyByProductID(qty, nxtCount) {
						//alert(qty+' '+nxtCount);
						if (isNaN(qty)) {
							displayNotice('page', 'Invalid Quantity');
							var quantity_fld = '#quantity_' + nxtCount;
							var product_id_fld = '#product_id' + nxtCount;
							//alert(quantity_fld);
							var oldVal = $('#tmpVal').val();
							$(quantity_fld).val(oldVal); //set last val
						} else {
							//getavalable product count
							var product_id_fld = '#product_id' + nxtCount;
							var product_id = $(product_id_fld).val();
							var warehouse_id = $('#warehouse_id').val();
							$.get("<?php echo base_url(); ?>stock_req/get_avalable_product_qty", {
									product_id: product_id,
									warehouse_id: warehouse_id
								})
								.done(function(data) {
									var obj = jQuery.parseJSON(data);
									//alert(obj.remmnaingQty);
								});
							//end getavalable product count
							calculateTotal();
							//displayNotice('page','Product quantity successfully updated!');
						}
					}
					
					function getNextRefNo() {
						//return 'SALE/2015/11/0001';
						//alert();
						$.post("<?php echo base_url(); ?>stock_req/get_next_ref_no")
							.done(function(data) {
								var obj = jQuery.parseJSON(data);
								$('#req_reference_no').val(obj.req_reference_no);
							});
						//return false;
					}
					function insertQuotationsData() {
					    
					    if(!$('#reqesting_for_date').val()){
					        bootbox.alert("Set Requesting date");
					        return;
					    }
					    
						var type = 'A';
						
						var fields = $("#create_quotations_form").serialize();
						var rowCount = $('#rowCount').val();
						if (rowCount != 0) {
							$("#add_quotation").prop("disabled", true);
							$("#add_quotation").val('Please wait...');
							
							$.post("<?php echo base_url(); ?>stock_req/save_sr", fields)
								.done(function(data) {
									var obj = jQuery.parseJSON(data);
									if (obj.error == 1) {
										$('.alert-success').hide();
										$('.alert-danger').show();
										$(".errortxt").text(obj.disMsg);
										window.scrollTo(500, 0);
										//empty item table
									}
									if (obj.error == 0) {
										window.scrollTo(500, 0);
										$("#soTable > tbody").empty();
										displayNotice('page', 'Successfully added!');
										clearForm();
										sendUrl = 'stock_req/view/' + obj.sr_id;
										window.location.href = "<?php echo base_url(); ?>" + sendUrl;
									}
								});
							return false;
						} else {
							bootbox.alert('Please add products.', function() {
								$('#add_item').focus();
							});
						}
					}
					//ItemnTotals();
					$("#add_item").autocomplete({
						source: function(request, response) {
							$.ajax({
								type: 'POST',
								url: '<?php echo base_url(); ?>products/suggestions',
								dataType: "json",
								data: {
									term: request.term,
									warehouse_id: $("#warehouse_id").val()
								},
								success: function(data) {
									response(data);
								}
							});
						},
						minLength: 1,
						autoFocus: false,
						delay: 5,
						response: function(event, ui) {
							if (ui.content.length == 1 && ui.content[0].product_id != 0) {
								ui.item = ui.content[0];
								$(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
								$(this).autocomplete('close');
								$(this).removeClass('ui-autocomplete-loading');
							} else if (ui.content.length == 0) {
								var noResult = {
									value: "",
									label: "No matching result found! Product might be out of stock in the selected warehouse."
								};
								ui.content.push(noResult);
							} else {
							}
						},
						select: function(event, data) {
							//alert( "You selected: " + data.item.product_id );
							if (data.item.value) {
								addProductToListByID(data.item.product_id, data.item.product_name, data.item.product_code, data.item.product_price, data.item.product_part_no, data.item.product_oem_part_number);
								$("#add_item").val('');
								return false;
							}
							$(this).autocomplete('close');
							$(this).removeClass('ui-autocomplete-loading');
						}
					});
					$(window).scroll(function() {
						if ($(window).scrollTop() + $(window).height() == $(document).height()) {
							//alert("bottom!");
							$('#bottom-total').css({
								position: 'static',
								width: '100%'
							});
						} else {
							$('#bottom-total').css({
								position: 'fixed',
								width: '1082px'
							});
						}
					});
					//function to initiate bootstrap-datepicker
					$(function() {
						//showKeys();
						var currentDate = new Date();
						$('#qts_datetime').datetimepicker({
							defaultDate: new Date()
						});
						//$("#warehouse_id").select2();
						$("#supp_id").select2();
						//$("#customer_id").select2();
					});
				</script>
</body>
<!-- end: BODY -->
</html>