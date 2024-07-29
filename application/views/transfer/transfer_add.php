<?php $this->load->view("common/header"); ?>
<!-- end: HEAD -->
<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">
<!--<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/jQuery-Tags-Input/jquery.tagsinput.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">-->
<!--<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/summernote/build/summernote.css">-->
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
    .form-control[disabled], fieldset[disabled] .form-control {
        border: solid 2px red;
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
                                <a href="<?php echo base_url('transfer'); ?>">
                                    Transfer
                                </a>
                            </li>
                            <li class="active">
                                Add Transfer
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
                            <h1>Add Transfer </h1>
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
                                Add Transfer
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
                                <form role="form" class="form-horizontal" id="create_transfer_form" action="#" method="post">
                                    <div class="col-md-12"></div><!--col-md-12-->
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Date *</label>
                                                <?php $nowdate = date("Y-m-d H:i:s"); ?>
                                                <input id="trnsfr_datetime" name="trnsfr_datetime" type='text' class="form-control date" value="" data-bv-field="date" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Reference No</label>
                                                <input type='text' class="form-control" id="trnsfr_reference_no" name="trnsfr_reference_no" value="<?php echo isset($td) ? $td->trnsfr_reference_no : "";?>" readonly />
                                                <input type='hidden' id="trnsfr_id" name="trnsfr_id" value="<?php echo isset($td) ? $td->trnsfr_id : "";?>"/>
                                                
                                            </div>
                                        </div>
                                        <input type="hidden" id="location_id" name="location_id" value="<?php echo $this->session->userdata('ss_warehouse_id'); ?>">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="customer_id">Transfer Location *</label>
                                                <select id="trnsfr_to_location_id" class="form-control" name="trnsfr_to_location_id">
                                                    <!--<option value="">-- Select the receiver --</option>-->
                                                    <?php
                                                    $ss_warehouse_id = isset($td) ? $td->location_id : $this->session->userdata('ss_warehouse_id');
                                                    foreach ($warehouse_list as $row) {
                                                        if ($ss_warehouse_id == $row->id) {
                                                            continue;
                                                        }
                                                    ?>
                                                        <option value="<?php echo $row->id; ?>" <?php echo isset($td) ? ($td->trnsfr_to_location_id == $row->id ? "selected" : "") : "";   ?> > <?php echo $row->name; ?> </option>
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
                                                                <th class="col-md-6">Product Name (Product Code)</th>
                                                                <th>Item Value</th>
                                                                <th class="col-md-2">Quantity</th>
                                                                <!--<th class="col-md-1 text-right">Discount </th>-->
                                                                <th class="text-right">Subtotal (<span class="currency">USD</span>)</th>
                                                                <th style="width: 30px !important; text-align: center;"><i class="fa fa-trash-o"></i></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr class="tfoot active" id="tfoot">
                                                                <th colspan="4" class="text-right">Total Amount</th>
                                                                <th class="text-right"><span id="Subtotal">0.00</span></th>
                                                            </tr>
                                                            <!-- <tr class="tfoot active" id="tfoot">
																	<th colspan="4" class="text-right">Paid </th>
																	<th class="text-right">
                                                                    <input type="text" onChange="changePaidValue(this.value);" onClick="this.select(); setTmpVal(this.value);" id="paid" value="0.00" name="paid" class="form-control text-right rquantity">
                                                                    </th>
																	
																</tr>
                                                                <tr class="tfoot active" id="tfoot">
																	<th colspan="4" class="text-right">Balance </th>
																	<th class="text-right"><span id="balance_dis">0.00</span></th>
																	
																</tr>-->
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
                                                    <!--<label>Order Discount</label>-->
                                                    <input type="hidden" title="" data-original-title="" value="" class="form-control input-tip" id="sale_inv_discount" name="trnsfr_inv_discount" onChange="changeMainDiscount(this.value)">
                                                </div>
                                            </div>
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
                                        <div class="col-md-12 well">
                                            <textarea name="trnsfr_note" style="width:100%" placeholder="Add Notes here..." maxlength ="1000"></textarea>
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
                                            <input type="submit" class="btn btn-primary" value="<?php echo isset($td)? "Save Changes" : "Add Transfer"  ?>" name="add_transfer" id="add_transfer"> <button id="reset" class="btn btn-danger" type="button">Reset</button>
                                        </div>
                                    </div>
                                    <input name="trnsfr_total" type="hidden" id="trnsfr_total" value="0">
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
                <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>
                <!--<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script>-->
                <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
                <!-- end: MAIN JAVASCRIPTS -->
                <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
                <script src="<?php echo asset_url(); ?>js/form-validation-create_transfer.js"></script>
                <script src="<?php echo asset_url(); ?>js/transfer.js"></script>
                <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
                <script>
                
                var old_items = <?php echo isset($tdi) ? json_encode($tdi) :  json_encode(array()); ?>;
                
                    clearForm();
                    $(document).ready(function() {
                        
                        if(Object.keys(old_items).length > 0){
                            old_items.forEach((a,b)=>{
                                /*console.log(a.product_id)*/
                                add_to_list(a.product_id, a.product_name, a.product_code, 0, a.trnsfr_itm_unit_value, a.trnsfr_itm_quantity, a.trnsfr_itm_id);
                                //add_to_list(a.product_id, "data.item.product_name", "data.item.product_code", a.trnsfr_itm_unit_value, data.item.product_cost);
                            });
                        }
                        
                      /*$(window).keydown(function(event){
                        if(event.keyCode == 13) {
                          event.preventDefault();
                          return false;
                        }
                      });*/
                    });
                    $('#add_item').keypress(function(e) {
                        if (e.which == 13) return false;
                        //or...
                        if (e.which == 13) e.preventDefault();
                    });
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
                            
                            return false;
                            //getavalable product count
                            var product_id_fld = '#product_id' + nxtCount;
                            var product_id = $(product_id_fld).val();
                            var warehouse_id = $('#warehouse_id').val();
                            $.get("<?php echo base_url(); ?>transfer/get_avalable_product_qty", {
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
                        if(!$('#trnsfr_reference_no').val())
                        $.post("<?php echo base_url(); ?>transfer/get_next_ref_no")
                            .done(function(data) {
                                var obj = jQuery.parseJSON(data);
                                $('#trnsfr_reference_no').val(obj.trnsfr_reference_no);
                            });
                        //return false;
                    }
                    
                    function del_itm_from_server(row_id){
                        var db_id = $('#row_'+row_id).data('db_id');
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url(); ?>transfer/del_items',
                            dataType: "json",
                            data: {
                                db_id: db_id
                            },
                            success: function(data) {
                                console.log(data);
                                if(data.success){
                                    var tmp = '#row_' + row_id;
                                    $(tmp).remove();
                                    displayNotice('page', 'Product item has been deleted successfully!');
                                    calculateTotal();  
                                }
                            }
                        });
                    }

                    function insertTransferData() {
                        var type = 'A';
                        var trnsfr_reference_no = $('#trnsfr_reference_no').val();
                        var fields = $("#create_transfer_form").serialize();
                        var rowCount = $('#soTable > tbody > tr').length;
                        if (parseInt(rowCount) != 0) {
                            $("#add_transfer").prop("disabled", true);
                            $("#add_transfer").val('Please wait...');
                            // create_transfer_form.add_transfer.disabled = true;
                            // create_transfer_form.add_transfer.value = "Please wait...";
                            //	return true;
                            //alert(fields);
                            //type:type, trnsfr_reference_no:trnsfr_reference_no
                            $.post("<?php echo base_url(); ?>transfer/save_transfer", fields)
                                .done(function(data) {
                                    var obj = jQuery.parseJSON(data);
                                    if (obj.error == 1) {
                                        $('.alert-success').hide();
                                        $('.alert-danger').show();
                                        $(".errortxt").text(obj.disMsg);
                                        window.scrollTo(500, 0);
                                        //empty item table
                                        $("#add_transfer").prop("disabled", false);
                                        $("#add_transfer").val('Try Again');
                                    }
                                    if (obj.error == 0) {
                                        window.scrollTo(500, 0);
                                        $("#soTable > tbody").empty();
                                        displayNotice('page', 'Transfer successfully added!');
                                        clearForm();
                                        sendUrl = 'transfer/view/'+obj.trnsfr_id;
                                        window.location.replace("<?php echo base_url(); ?>" + sendUrl);
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
                            if (!$('#trnsfr_to_location_id').val()) {
                                $('#add_item').val('').removeClass('ui-autocomplete-loading');
                                bootbox.alert('Please select the receiving location');
                                $('#add_item').focus();
                                return false;
                            }
                            if (!$('#location_id').val()) {
                                $('#add_item').val('').removeClass('ui-autocomplete-loading');
                                bootbox.alert('Please select from warehouse');
                                $('#add_item').focus();
                                return false;
                            }
                            if ($('#trnsfr_to_location_id').val() == $('#location_id').val()) {
                                $('#add_item').val('').removeClass('ui-autocomplete-loading');
                                bootbox.alert('Please select different warehouse');
                                $('#add_item').focus();
                                return false;
                            }
                            
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo base_url(); ?>products/suggestions',
                                dataType: "json",
                                data: {
                                    term: request.term,
                                    location_id: $("#location_id").val()
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
                            } else {}
                        },
                        select: function(event, data) {
                            //alert( "You selected: " + data.item.product_id );
                            if (data.item.value) {
                                add_to_list(data.item.product_id, data.item.product_name, data.item.product_code, data.item.product_price, data.item.product_cost);
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
                        $('#trnsfr_datetime').datetimepicker({
                            defaultDate: new Date()
                        });
                        //$("#warehouse_id").select2();
                        $("#supp_id").select2();
                        $("#customer_id").select2();
                    });
                    
                    
                    /**/
                    function validateQuantity(input) {
                        // Regular expression to match numbers with up to 3 decimal places
                        var regex = /^\d*\.?\d{0,3}$/;
                    
                        // Check if input matches the regex
                        if (regex.test(input)) {
                            return parseFloat(input); // Parse input to float and return
                        } else {
                            return false; // Return false if input doesn't match criteria
                        }
                    }
                    
                    function add_to_list(product_id, product_name, product_code, product_price, item_cost, userInput = 0, db_id = 0) {

                        if($('#row_'+parseInt(product_id)).length){
                            bootbox.alert("Already added");
                            $('#quantity_'+parseInt(product_id)).focus().select();
                            return;
                        }
                        
                        var userInput = userInput ? userInput : prompt("Please enter the quantity (up to 3 decimal places):");
                        // Validate the input
                        var quantity = validateQuantity(userInput);
                        
                        if (isNaN(quantity) === false) {
                            
                        } else {
                            // Input is not valid
                            bootbox.alert("Invalid quantity entered. Please enter a number with up to 3 decimal places.");
                            return;
                        }
                        
                        
                        var customer_id = $('#customer_id').val();
                    
                        if (customer_id === '') {
                            bootbox.alert('Please select a customer before adding any product', function () {
                                $('#add_item').focus();
                            });
                        } else {
                            var nxtCount = parseInt(product_id);
                            
                            var product_price_dis = convertToAmount(product_price);
                            var sub_total_item = convertToAmount(product_price * 1);
                            var discount_val = 0;
                            var discount_val_tot = 0;
                    
                            $('#soTable tbody').prepend(`
                                <tr class="child" id="row_${nxtCount}" data-product-id="${nxtCount}" data-db_id="${db_id}">
                                    <td>${product_name} (${product_code})</td>
                                    <td class="text-right">
                                        <input class="form-control" type="text" value="${item_cost}" id="item_cost_${nxtCount}" onchange="calculateTotal()" name="row[${nxtCount}][unit_value]">
                                    </td>
                                    <td style="display: flex;align-content: center;align-items: center;">
                                        <input type="hidden" name="row[${nxtCount}][product_id]" value="${nxtCount}">
                                        <input type="text" class="form-control text-center rquantity" readonly name="row[${nxtCount}][qty]" value="${quantity}" id="quantity_${nxtCount}"  onchange="calculateTotal()">
                                         / 
                                        <input type="text" class="form-control text-center" readonly  name="row[${nxtCount}][bal]" value="0" id="balance_${nxtCount}"   onchange="checkValidity(${nxtCount})">
                                    </td>
                                    <td class="text-right">
                                        <span class="text-right" id="subtotal_${nxtCount}">${sub_total_item}</span>
                                        <input type="hidden" name="row[${nxtCount}][gross_total]" value="0" id="gross_total_${nxtCount}">&nbsp;
                                    </td>
                                    <td>
                                        <a onclick="deleteSalesItem(${nxtCount})">
                                            <i class="fa fa-times tip podel" id="1446800197032" title="Remove" style="cursor:pointer;"></i>
                                        </a>
                                    </td>
                                </tr>
                            `);
                            calculateTotal();
                            gs(parseInt(product_id));
                        }
                    }
                    
                    function checkValidity(product_id){
                        if(accounting.unformat($('#quantity_'+product_id).val()) > accounting.unformat($('#balance_'+product_id).val())){
                            $('[name^="row['+product_id+']"]').each(function() {
                                $(this).prop('disabled', true);
                            });
                        }else{
                            $('[name^="row['+product_id+']"]').each(function() {
                                $(this).prop('disabled', false);
                            });
                        }
                    }

                    function calculateTotal() {
                        var rowCount = parseInt($('#soTable > tbody > tr').length);
                        var quantity_tot = 0;
                        var subtotal = 0;
                        var cost_total = 0;
                        var inv_discount = parseFloat($('#sale_inv_discount').val()) || 0;
                    
                        $('#soTable > tbody > tr').each(function(a,b){
                            var i = $(this).data('product-id');
                            
                            var quantity_val = parseFloat($('#quantity_' + i).val()) || 0;
                            var item_cost_val = parseFloat($('#item_cost_' + i).val()) || 0;
                            var product_price_val = parseFloat($('#product_price_' + i).val()) || 0;
                            var item_price_p_val = parseFloat($('#item_price_p_' + i).val()) || 0;
                            var discount_val = parseFloat($('#discount_' + i).val()) || 0;
                    
                            var price = (product_price_val + item_price_p_val) * quantity_val;
                            var afterDiscount = price - (price * discount_val / 100);
                            
                            if (!isNaN(quantity_val)) {
                                quantity_tot += quantity_val;
                                cost_total += item_cost_val * quantity_val;
                                subtotal += afterDiscount;
                            }
                            
                            $('#subtotal_' + i).text(convertToAmount(item_cost_val * quantity_val));
                            $('#gross_total_' + i).val((item_cost_val * quantity_val).toFixed(2));
                            
                        });

                        var totalDiscount = (subtotal * inv_discount) / 100;
                        var grandTotal = subtotal - totalDiscount;
                    
                        $('#Subtotal').text(convertToAmount(cost_total));
                        //$('#balance_dis').text(convertToAmount(balance));
                        $('#trnsfr_total').val(cost_total);
                    }

                function addextraprice(){
                    
                }
                function gs(product_id){
                    var location_id = $("#location_id").val();
                    $.ajax({
                        type: 'POST',
                        url : '<?php echo base_url("transfer/get_stock_balance")?>',
                        dataType: 'JSON',
                        data: {
                            product_id : product_id,
                            location_id : location_id,
                        },
                        success : function(response){
                            console.log(response);
                            var bal = response.b;
                            $('#balance_'+product_id).val(bal);
                            setTimeout(()=>{
                                checkValidity(product_id);
                            },100);
                        }
                    });
                }
                function fv(){
                    $('#soTable').each(function(a,b){
                        
                    });
                }
                </script>
</body>
<!-- end: BODY -->
</html>