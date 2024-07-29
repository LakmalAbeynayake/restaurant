<?php $this->load->view("common/header"); ?>
<!-- end: HEAD -->
<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
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
                                <a href="<?php echo base_url('product_damage'); ?>">
                                    Damage Products
                                </a>
                            </li>
                            <li class="active">
                                Add Damage Products
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
                            <h1>Add Product Loss</h1>
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
                                Add Damage Products
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
                                <form role="form" class="form-horizontal" id="create_product_damage_form" action="#" method="post">
                                    <div class="col-md-12"></div><!--col-md-12-->
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Date *</label>
                                                <?php $nowdate = date("Y-m-d H:i:s"); ?>
                                                <input id="pdmg_datetime" name="pdmg_datetime" type='text' class="form-control date" value="" data-bv-field="date" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Reference No</label> <input type='text' class="form-control" id="pdmg_reference_no" name="pdmg_reference_no" value="" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="font-weight: 700;">Please select these before adding any product</div>
                                                <div class="panel-body">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>Location * </label>
                                                            <select id="location_id" class="form-control" name="location_id">
                                                                <!--<option value="">-- Select Warehouse --</option>-->
                                                                <?php
                                                                $ss_warehouse_id = $this->session->userdata('ss_warehouse_id');
                                                                foreach ($warehouse_list as $row) {
                                                                    $sel = '';
                                                                    if ($location_id == $row->id) {
                                                                        $sel = ' selected="selected"';
                                                                    }
                                                                ?>
                                                                    <option value="<?php echo $row->id; ?>">
                                                                        <?php echo $row->name; ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>Type * </label>
                                                            <select id="dmg_type_id" class="form-control" name="dmg_type_id">
                                                                <option value="1">WASTAGE</option>
                                                                <option value="2">STAFF MEAL</option>
                                                            </select>
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
                                                                <th class="col-md-7">Product Name (Product Code)</th>
                                                                <th>Selling Price</th>
                                                                <th class="col-md-1">Quantity</th>
                                                                <th class="col-md-1 text-right">Discount </th>
                                                                <th class="text-right">Subtotal (<span class="currency">USD</span>)</th>
                                                                <th style="width: 30px !important; text-align: center;"><i class="fa fa-trash-o"></i></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr data-item-id="144680019784" class="row_144680019784" id="row_1446800197032">
                                                                <td>
                                                                </td>
                                                                <td class="text-right">
                                                                </td>
                                                                <td>
                                                                </td>
                                                                <td class="text-right">
                                                                </td>
                                                                <td class="text-right">
                                                                </td>
                                                                <td class="text-center">
                                                                </td>
                                                            </tr>
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
                                                    <input type="hidden" title="" data-original-title="" value="" class="form-control input-tip" id="sale_inv_discount" name="pdmg_inv_discount" onChange="changeMainDiscount(this.value)">
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
                                            <input type="submit" class="btn btn-primary" value="Add Damage Products" name="add_product_damage" id="add_product_damage">
                                            <button id="reset" class="btn btn-danger" type="button">Reset</button>
                                        </div>
                                    </div>
                                    <input name="pdmg_inv_discount_amount" type="hidden" id="sale_inv_discount_amount" value="0">
                                    <input name="pdmg_total" type="hidden" id="sale_total" value="0">
                                    <input name="pdmg_paid" type="hidden" id="sale_paid" value="0">
                                    <input name="pdmg_balance" type="hidden" id="sale_balance" value="0">
                                    <input name="rowCount" type="hidden" id="rowCount" value="0">
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
                <script src="<?php echo asset_url(); ?>js/form-validation-create_product_damage.js"></script>
                <script src="<?php echo asset_url(); ?>js/damage.js"></script>
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
                    function changeQtyByProductID(qty, nxtCount) {
                        checkValidity(qty,nxtCount);
                    }
                    
                    function checkValidity(product_id,nxtCount){
                        if(accounting.unformat($('#quantity_'+nxtCount).val()) > accounting.unformat($('#balance_'+product_id).val())){
                            $('[name^="row['+nxtCount+']"]').each(function() {
                                $(this).prop('disabled', true);
                            });
                        }else{
                            $('[name^="row['+nxtCount+']"]').each(function() {
                                $(this).prop('disabled', false);
                            });
                        }
                    }
                    function getNextRefNo() {
                        //return 'SALE/2015/11/0001';
                        //alert();
                        $.post("<?php echo base_url(); ?>product_damage/get_next_ref_no")
                            .done(function(data) {
                                var obj = jQuery.parseJSON(data);
                                $('#pdmg_reference_no').val(obj.pdmg_reference_no);
                            });
                        //return false;
                    }
                    function insertDamageProductData() {
                        bootbox.confirm("Stock will be updated immediately! Are you sure?",(a)=>{
                            if(a === true)
                                apply();
                        });
                    }
                    function apply(){
                        var type = 'A';
                        var pdmg_reference_no = $('#pdmg_reference_no').val();
                        var fields = $("#create_product_damage_form").serialize();
                        var rowCount = $('#rowCount').val();
                        if (rowCount != 0) {
                            $("#add_product_damage").prop("disabled", true);
                            $("#add_product_damage").val('Please wait...');
                            // create_product_damage  _form.add_product_damage.disabled = true;
                            // create_product_damage  _form.add_product_damage.value = "Please wait...";
                            //	return true;
                            //alert(fields);
                            //type:type, pdmg_reference_no:pdmg_reference_no
                            $.post("<?php echo base_url(); ?>product_damage/save_product_damage", fields + '&uuid=' + uuidv4())
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
                                        //$('.alert-danger').hide();
                                        //$('.alert-success').show();
                                        //$( ".succetxt" ).text( obj.disMsg );
                                        window.scrollTo(500, 0);
                                        //$("#soTable tr:gt(0)").remove();
                                        $("#soTable > tbody").empty();
                                        displayNotice('page', 'Sale successfully added!');
                                        clearForm();
                                        //empty footer details
                                        //alert(obj.pdmg_id);
                                        sendUrl = 'product_damage';
                                        //alert(sendUrl);
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
                            if (!$('#location_id').val()) {
                                $('#add_item').val('').removeClass('ui-autocomplete-loading');
                                bootbox.alert('Please select to warehouse');
                                $('#add_item').focus();
                                return false;
                            }
                            $.ajax({
                                type: 'get',
                                url: '<?php echo base_url(); ?>product_damage/suggestions',
                                dataType: "json",
                                data: {
                                    term: request.term,
                                    warehouse_id: $("#pdmg_from_warehouse_id").val(),
                                    customer_id: $("#pdmg_to_warehouse_id").val(),
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
                        $('#pdmg_datetime').datetimepicker({
                            defaultDate: new Date()
                        });
                        //$("#warehouse_id").select2();
                        $("#supp_id").select2();
                        $("#customer_id").select2();
                    });
                    function uuidv4() {
                        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                            var r = Math.random() * 16 | 0,
                                v = c == 'x' ? r : (r & 0x3 | 0x8);
                            return v.toString(16);
                        });
                    }
                    function gs(product_id,nxtCount){
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
                                    checkValidity(product_id,nxtCount);
                                },100);
                            }
                        });
                    }
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
                </script>
</body>
<!-- end: BODY -->
</html>