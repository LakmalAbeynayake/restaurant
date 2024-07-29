	<?php
	$this->load->view("common/header");
	?>
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
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/jquery-ui.css">

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

				.table th, .table td {
				    vertical-align: middle !important;
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
									<a href="#">
										 Dashboard 
									</a>
								</li>
                                
								<li>
									<a href="#">
										Stock Adjesment
									</a>
								</li>

								<li class="active">
										Add Stock Adjesment
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
								<h1>Add Stock Adjesment</h1>
							</div>

                            <p>Please fill in the information below. The field labels marked with * are required input fields.</p>
						</div>
					</div>
					<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT 
                    <!-- start grid -->
				<form class="bv-form" accept-charset="utf-8" method="post" enctype="multipart/form-data" role="form" action="<?php echo base_url('stock_adjesment/add'); ?>" id="add_perchas">
					<div class="row">
						<div class="col-md-12">
							<div class="alert alert-danger" style="<?php $s = validation_errors(); if (empty($s)) {echo 'display:none';}?>">
							<button type="button" class="close" data-dismiss="alert">×</button>
								<?php echo validation_errors(); ?>
							</div>
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-plus"></i>
									Add Ingredient Items
							  </div>
								<div class="panel-body">
									<div class="col-md-12">
										<div class="col-md-4">
											<div class="form-group">
												<label>Date *</label>

										<input type="text" required id="podate" class="form-control date" name="podate" data-original-title="" title="" data-bv-field="date">
										</div>
										</div>
									
                                        
                                        <div class="col-md-4">
<div class="form-group">

<label> Reference No</label>
<input type="text" id="poref" class="form-control input-tip" value="" name="supp_invocie_no" data-original-title="" title="">											</div>
</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Warehouse *</label>
					                            <select id="powarehouse" name="powarehouse" class="form-control search-select">
					                             <?php foreach ($warehouse as $key => $wh) {
					                                echo"<option value=".$wh->id.">".$wh->name."</option>";
					                             } ?>  
					                             </select>
											</div>
										</div>

										<div class="col-md-8" style="display:none;">
											<div class="panel panel-default">
												<div class="panel-heading" style="font-weight: 700;">Please select these before adding any menu items</div>
													<div class="panel-body">
														<div class="form-group"><div class="col-sm-12">
															<label>Supplier *</label>
															<select id="supplier" name="supplier" class="form-control search-select">
								                                <!--<option value="">&nbsp;</option>-->
									                             <?php foreach ($supplier as $key => $sup) {
									                                echo"<option value=".$sup->supp_id.">".$sup->supp_company_name."</option>";
									                             } ?>  
								                             </select>
														</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div id="sticker" class="col-md-12">
											<div class="well well-sm">
												<div style="margin-bottom:0;" class="form-group">
												<div class="input-group wide-tip">
													<div style="padding-left: 10px; padding-right: 10px;" class="input-group-addon">
														<i class="fa fa-2x fa-barcode addIcon"></i>
													</div>
													<input type="text" placeholder="Please add Ingredients to list" id="add_item" class="form-control input-lg" value="" name="add_item"  style="border-radius: 6px;font-size: 18px;height: 46px;line-height: 1.33;padding: 10px 16px;">
														<div style="padding-left: 10px; padding-right: 10px;" class="input-group-addon">
															<i id="addIcon" class="fa fa-2x fa-plus-circle addIcon"></i>

														</div>
												</div>
											</div>


											<div class="clearfix"></div>
											<div class="control-group table-group">
												<label class="table-label">Order Items</label>
													<div class="controls table-controls">
														<table class="table items table-striped table-bordered table-condensed table-hover" id="poTable">
															<thead>
																<tr>
																	<th class="col-md-4">Menu Item Name(Item Code)</th>
																	<th class="col-md-1">Net Unit Cost</th>
																	<th class="col-md-1">Quantity</th>
																	<th class="col-md-1">Price Adj</th>
																	<th>Subtotal (<span class="currency">LKR</span>)</th>
																	<th style="width: 30px !important; text-align: center;"><i class="fa fa-trash-o"></i></th>
																</tr>
															</thead>
																	<tbody>

																	</tbody>
															<tfoot>
															</tfoot>
														</table>
													</div>
												</div>
											</div>

												<label class="checkbox-inline"><p></p>
													<input type="checkbox" class="square-black" value="" id="extras">
													<label for="extras">More Options</label>
												</label>

													<div id="extras-con" class="row" style="display: none;">
															<div class="col-md-4">
																<div class="form-group">
																	<label for="podiscount">Discount (5/5%)</label>
																	<input type="text" id="podiscount" class="form-control input-tip" value="" name="discount" data-original-title="" title="">
																</div>
															</div>
													</div>
												<div class="clearfix"></div>
												<div class="form-group">
												<label for="ponote">Note</label> <textarea name="note" cols="40" rows="10" class="form-control" id="ponote" style="margin-top: 10px; height: 100px;"></textarea>
												</div>
										</div>
										<div class="col-md-12">
											<div style="" class="well well-sm" id="bottom-total">
											<table style="margin-bottom:0;" class="table table-bordered table-condensed totals">
											<tbody><tr class="warning">
											<td>Total <span id="total" class="totals_val pull-right">0.00</span><input type="hidden" value="0.00" name="total" id="total"/></td>
											<td>Order Discount <span id="tds" class="totals_val pull-right">0.00</span></td>
											<td>Grand Total <span id="gtotal" class="totals_val pull-right">0.00</span><input type="hidden" value="0.00" name="hgtotal" id="hgtotal"/></td>
											</tr>
											</tbody></table>
											</div>

											<div class="col-md-12">
											<div class="from-group"><input type="submit" name="submit" style="padding: 6px 15px; margin:15px 0;" class="btn btn-primary" id="add_pruchase" value="Submit" name="add_pruchase">
											<button id="reset" class="btn btn-danger" type="button">Reset</button>
											</div>
											</div>
										</div>
        							</div>
        							
								</div>
							</div>
														<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					</div>
                    <!-- end grid -->
                </form> 
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

		<!-- start: MAIN JAVASCRIPTS -->
		<?php $this->load->view("common/footer"); ?>

		<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>		
		<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
		<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script>
		<script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script>
		<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script>
		<?php /*?><script type="text/javascript" src="<?php echo asset_url(); ?>js/perches.js"></script><?php */?>
		<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>
		<script type="text/javascript" src="<?php echo asset_url();?>js/form-validation-add_grn.js"></script>
     <script type="text/javascript" src="<?php echo asset_url(); ?>js/addmenu.js"></script>

		<!-- end: MAIN JAVASCRIPTS -->
		<script type="text/javascript">

    var count = 1, an = 1, product_variant = 0, DT = 1, DC = '', shipping = 0,product_tax = 0, invoice_tax = 0, total_discount = 0, total = 0,poitems = {};

        			    //function to initiate bootstrap-datepicker
            $(function () {

                $('#podate').datetimepicker({
                	defaultDate : new Date()
                });
		        $("#powarehouse").select2();
		        $("#supplier").select2();
		        //$("#status").select2();
		        $( "#podate" ).focus();

            });

        //ItemnTotals();
        $("#add_item").autocomplete({
            source: '../get_menuitem_by_code',
            minLength: 1,
            autoFocus: false,
            delay: 200,
            response: function (event, ui) {

                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    //audio_error.play();
                    bootbox.alert('No matching result found! Product might be out of stock in the selected warehouse.', function () {
                        $('#add_item').focus();
                    });
                    $(this).removeClass('ui-autocomplete-loading');
                    $(this).val('');
                }
                else if (ui.content.length == 1 && ui.content[0].id != 0) {
                   // ui.item = ui.content[0];
                  // $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    //$(this).autocomplete('close');
                    //$(this).removeClass('ui-autocomplete-loading');
                }
                else if (ui.content.length == 1 && ui.content[0].id == 0) {
                    bootbox.alert('No matching result found! Product might be out of stock in the selected warehouse.', function () {
                        $('#add_item').focus();
                    });

                    $(this).removeClass('ui-autocomplete-loading');
                    $(this).val('');
                }

            },
            select: function (event, ui) {

                if (ui.id !== 0) {
                    var row = add_purchase_item(ui.item);
                    $(this).val('');
                    return false;

                if (row)
                    $(this).val('');
                	return false;
                } else {
                   //bootbox.alert('No matching result found! Product might be out of stock in the selected warehouse.');
					set_message("Product Info","No matching result found! Menu item might be out of stock in the selected warehouse.");
                }


            }
        });

      $('#add_item').bind('keypress', function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $(this).autocomplete("search");
            }
        });
        
        </script>
	</body>
	<!-- end: BODY -->
</html>