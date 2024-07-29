<?php $this->load->view("common/header"); ?>
<!-- end: HEAD -->
<link rel="stylesheet" href="<?php echo asset_url(); ?>css/jquery-ui.css">

<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->

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
                                <a href="<?php echo base_url('sales'); ?>">
                                    Sales
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
                            <h1>Add Purchases </h1>
                        </div>

                        <p>Please fill in the information below. The field
                            labels marked with * are required input fields.</p>
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
                                Add G.R.N
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

                                <form role="form" class="form-horizontal" id="create_sales_form" action="#" method="post">

                                    <div class="col-md-12"></div><!--col-md-12-->
                                    <div class="col-lg-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Date *</label>

                                                <input type="text" required id="podate" class="form-control date" name="podate" data-original-title title data-bv-field="date">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                $ref_id = new Common_Model();
                                                $reference_no =
                                                    $ref_id->gen_ref_number('id', 'purchases', 'GRN/');
                                                ?>
                                                <label>Reference No</label>
                                                <input readonly type="text" id="poref" class="form-control input-tip" value="<?php echo $reference_no; ?>" name="reference_no" data-original-title title>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">

                                                <label>Supplier Reference
                                                    No</label>
                                                <input type="text" id="poref" class="form-control input-tip" value name="supp_invocie_no" data-original-title title>
                                            </div>
                                        </div>

                                        <?php /*?>
                                        <?php $display='';
                                        $userid ='';

                                        $userid
                                        =$this->session->userdata('ss_group_id');
                                        if($userid != 1){
                                        $display = 'none';
                                        }

                                        ?><?php */ ?>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Location *</label>
                                                <select id="powarehouse" name="powarehouse" class="form-control search-select">
                                                    <?php
                                                    $sel = '';
                                                    foreach ($warehouse as $key => $wh) {
                                                        $sel = $wh->id == $this->session->userdata('ss_warehouse_id') ? 'selected' : '';
                                                        echo "<option ".$sel." value=" . $wh->id . ">" . $wh->name . "</option>";
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="font-weight: 700;">Please
                                                    select these before adding
                                                    any product</div>
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label>Supplier
                                                                *</label>
                                                            <select id="supplier" name="supplier" class="form-control search-select">
                                                                <option value>&nbsp;</option>
                                                                <?php foreach ($supplier as
                                                                    $key => $sup) {
                                                                    echo "<option
                                                                    value=" . $sup->supp_id . ">" . $sup->supp_company_name . "</option>";
                                                                } ?>
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
                                                    <input type="text" placeholder="Please add products to order list" id="add_item" class="form-control input-lg" value name="add_item" onClick="add_items()" onKeyPress="add_items()" style="border-radius: 6px;font-size: 18px;height: 46px;line-height: 1.33;padding: 10px 16px;">
                                                    <!--<div style="padding-left: 10px; padding-right: 10px;" class="input-group-addon">
                                                        <i id="addIcon" class="fa fa-2x fa-plus-circle addIcon"></i>

                                                    </div>-->
                                                </div>
                                                <!-- end auto complete end -->

                                            </div>

                                            <div class="clearfix"></div>
                                            <div class="control-group table-group">
                                                <label class="table-label">Purchasing
                                                    Items</label>
                                                <div class="controls table-controls">

                                                    <table class="table items table-striped table-bordered table-condensed table-hover" id="grn_items_table">
                                                        <thead>
                                                            <tr>
                                                                <th class="col-md-7">Product Name (Product Code)</th>
                                                                <th>Cost</th>
                                                                <th class="col-md-1">Quantity</th>
                                                                <!--<th class="col-md-1 text-right">Discount </th>-->
                                                                <th class="text-right">Subtotal<span class="currency"></span></th>
                                                                <th style="width: 30px !important; text-align: center;"><i class="fa fa-trash-o"></i></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr data-item-id class="row_" id="row_">
                                                                <td></td>
                                                                <td class="text-right"></td>
                                                                <td></td>
                                                                <td class="text-right"></td>
                                                                <td class="text-center"></td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <!--<tr class="tfoot active" id="tfoot">
                                                                <th colspan="2">Total</th>
                                                                <th class="text-center"><span id="qtyTotal">0.00</span></th>
                                                                <th class="text-right"><span id=""> 0.00</span></th>
                                                                <th class="text-right">0.00</th>
                                                                <th class="text-right"><span id="Subtotal">00.00</span></th>
                                                                <th class="text-center"><i class="fa fa-trash-o"></i></th>
                                                            </tr>-->
                                                            <tr class="tfoot active" id="tfoot">
                                                                <th colspan="4" class="text-right">Total
                                                                    Amount</th>
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

                                            <div class="col-md-4 collapse">
                                                <div class="form-group">
                                                    <label>Order Discount</label>
                                                    <input type="text" title data-original-title value="0.00" class="form-control input-tip" id="sale_inv_discount" name="sale_inv_discount" onClick="this.select()" onChange="changeMainDiscount(this.value)">
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

                                        <div class="col-md-12">
                                            <div class="modal-footer" style="margin-bottom:10px;">
                                                <input type="submit" class="btn btn-primary" value="Add Purchase" name="add_purchase" id="add_purchase"> <button id="reset" class="btn btn-danger" type="button">Reset</button>
                                            </div>
                                        </div>
                                        <input name="sale_inv_discount_amount" type="hidden" id="sale_inv_discount_amount" value="0">
                                        <input name="sub_total" type="hidden" id="sub_total" value="0">
                                        <input name="sale_total" type="hidden" id="sale_total" value="0">
                                        <input name="sale_paid" type="hidden" id="sale_paid" value="0">
                                        <input name="sale_balance" type="hidden" id="sale_balance" value="0">
                                        <input name="rowCount" type="hidden" id="rowCount" value="0">
                                        <input name="cost_total" type="hidden" id="cost_total" value="0">
                                </form>

                                <!-- end: DYNAMIC TABLE PANEL -->

                                <!-- footer amount details -->
                                <div style="margin-bottom: 0px; position: fixed; bottom: 0px; width: 1082px; z-index: 50000;" class="well well-sm" id="bottom-total">
                                    <table style="margin-bottom:0;" class="table table-bordered table-condensed totals">
                                        <tbody>
                                            <tr class="warning">
                                                <td width="30%">Total <span id="f_total" class="totals_val pull-right">0.00</span></td>
                                                <td width="30%">Order
                                                    Discount <span id="tds" class="totals_val pull-right">0.00</span></td>
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
            </div>
        </div>
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

    <input name id="type_sale" type="hidden" value="22">
    <input name="in_type" id="in_type" value="Cash" type="hidden">
    <!-- start ajax model -->
    <div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
    <!-- end ajax model -->

    <!-- start: MAIN JAVASCRIPTS -->
    <?php $this->load->view("common/footer"); ?>

    <script src="<?php echo asset_url(); ?>js/jquery-ui.js"></script>
    <script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script>

    <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>

    <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>

    <!-- end: MAIN JAVASCRIPTS -->

    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
    <script src="<?php echo asset_url(); ?>js/form-validation-create_purchases.js"></script>
    <script src="<?php echo asset_url(); ?>js/purchases.js"></script>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->

    <script>
        function addextraprice() {
            calculateTotal();
        }
        clearForm();
        $(document).ready(function() {
            FormValidator.init();
            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });

        $('#add_item').keypress(function(e) {
            if (e.which == 13) return false;
            //or...
            if (e.which == 13) e.preventDefault();
        });


        $(document).keypress(function(e) {
            if (e.which == 13) return false;
            //or...
            if (e.which == 13) e.preventDefault();
        });

        $(document).on('keyup keydown', function(e) {
            shifted = e.shiftKey;
            if (shifted) {
                $("#add_item").focus();
            };
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
                //getavalable product count
                var product_id_fld = '#product_id' + nxtCount;
                var product_id = $(product_id_fld).val();

                var warehouse_id = $('#warehouse_id').val();
                $.get("<?php echo base_url(); ?>sales/get_avalable_product_qty", {
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

            $.post("<?php echo base_url(); ?>sales/get_next_ref_no")
                .done(function(data) {
                    var obj = jQuery.parseJSON(data);
                    $('#sale_reference_no').val(obj.sale_reference_no);
                });
            //return false;
        }

        function insertSalesData() {

            ;
            var type = 'A';
            var sale_reference_no = $('#sale_reference_no').val();
            var fields = $("#create_sales_form").serialize();

            var rowCount = $('#rowCount').val();

            if (rowCount != 0) {
                $("#add_purchase").prop("disabled", true);
                $("#add_purchase").val('Please wait...');

                // create_sales_form.add_purchase.disabled = true;
                // create_sales_form.add_purchase.value = "Please wait...";
                //	return true;

                //alert(fields);
                //type:type, sale_reference_no:sale_reference_no
                $.post("<?php echo base_url(); ?>purchases/save_purchases", fields)
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
                            //$("#grn_items_table tr:gt(0)").remove();
                            $("#grn_items_table > tbody").empty();
                            displayNotice('page', 'Purchase successfully added!');

                            clearForm();
                            //empty footer details

                            //alert(obj.sale_id);
                            sendUrl = 'purchases/purchases_details/' + obj.sale_id;
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

        function add_items() {
            //ItemnTotals();
            $("#add_item").autocomplete({
                source: '<?php echo base_url(); ?>purchases/suggestions?t=' + $("#in_type").val(),
                minLength: 1,
                autoFocus: false,
                delay: 5,
                response: function(event, ui) {

                    if (ui.content.length == 1 && ui.content[0].product_id != 0) {
                        //ui.item = ui.content[0];
                        //$(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                        //$(this).autocomplete('close');
                        // $(this).removeClass('ui-autocomplete-loading');
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

                        //check is added prodcut
                        rowCount = parseInt($('#rowCount').val());
                        var tmp = '';
                        if (rowCount) {
                            tmp = isAddedProduct(data.item.product_id);
                        }
                        if (!tmp) {
                            addProductToListByID(data.item.product_id, data.item.product_name, data.item.product_code, data.item.product_price, data.item.item_cost, '1');
                        } else {
                            calculateTotal();
                        }


                        $("#add_item").val('');
                        return false;
                    }
                    $(this).autocomplete('close');
                    $(this).removeClass('ui-autocomplete-loading');

                }
            });
        }

        function add_items_manually(a, b, c, d, e, f, g, h) {
            //alert(a+'|'+b+'|'+c+'|'+d+'|'+e+'|'+f+'|'+g+'|'+h);
            //check is added prodcut
            rowCount = parseInt($('#rowCount').val());
            var tmp = '';
            if (rowCount) {
                tmp = isAddedProduct(a);

            }
            if (!tmp) {
                addProductToListByID(a, b, c, d, e, f, g, parseInt(h));
            } else {
                calculateTotal();
            }
        }

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


            $('#podate').datetimepicker({
                defaultDate: new Date()
            });

            /*$("#powarehouse").select2();
            $("#supplier").select2();
            $("#customer_id").select2();
            */

        });
        
        
    function addProductToListByID(product_id, product_name, product_code, product_price, item_cost, quantity) {
        const customer_id = $('#customer_id').val();
        
        if (customer_id === '') {
            bootbox.alert('Please select a customer before adding any product', function() {
                $('#add_item').focus();
            });
            return;
        }
    
        const rowCount = parseInt($('#rowCount').val()) + 1;
        $('#rowCount').val(rowCount);
    
        const product_price_dis = convertToAmount(product_price);
        const sub_total_item = convertToAmount(product_price * quantity);
    
        const htmlTemplate = `
            <tr id="row_${rowCount}" data-row-id="${rowCount}">
                <td>${product_name} (${product_code})
                    <input type="hidden" class="form-control text-center rquantity" name="row[${rowCount}][product_id][]" value="${product_id}" id="product_id_${rowCount}">
                </td>
                <td  style="width:200px; padding-left:15px;padding-right:15px;">
                    <input class="text-right" type="text" onClick="this.select()" style="width:100%;" name="row[${rowCount}][item_cost][]" id="item_cost_${rowCount}" value="${item_cost}">
                </td>
                <td>
                    <input type="text" class="form-control text-center rquantity" name="row[${rowCount}][qty][]" value="${quantity}" id="quantity_${rowCount}" onclick="this.select(); setTmpVal(this.value);" onchange="changeQtyByProductID(this.value, ${rowCount});">
                </td>
                <td class="text-right">
                    <span class="text-right ssubtotal" id="subtotal_${rowCount}">${sub_total_item}</span>
                    <input type="hidden" name="row[${rowCount}][sub_total][]" value="0" id="sub_total_${rowCount}">
                </td>
                <td>
                    <a onclick="deleteSalesItem(${rowCount})"><i class="fa fa-times tip podel" id="${Date.now()}" title="Remove" style="cursor:pointer;"></i></a>
                </td>
            </tr>
        `;
    
        $('#grn_items_table tbody').prepend(htmlTemplate);
        calculateTotal();
    }

    
    /* end check is added produtct */
    function calculateTotal(){
        var grand_total = 0;
        $('#grn_items_table > tbody > tr').each(function(){
            var row_id = $(this).data('row-id'); 
            if(typeof row_id != 'undefined'){
                var item_cost = $('#item_cost_'+row_id).val();
                var item_quantity = $('#quantity_'+row_id).val();
                var item_subtotal = parseFloat(item_cost) * parseFloat(item_quantity);
                $('#subtotal_'+row_id).text(parseFloat(item_subtotal).toFixed(2));
                $('#sub_total_'+row_id).val(item_subtotal);
                grand_total += parseFloat(item_subtotal);
            }
        });
        $('#sub_total').val(grand_total);
        $('#Subtotal').text(grand_total.toFixed(2));
    }
    </script>
    <?php
    //get_order_item_list_by_order_id
    //get_proceed_order_item_list_by_po_id
    if ($purchased_id > 0) {
        $model = new Order_Model();
        $items = $model->get_proceed_order_item_list_by_po_id($purchased_id);
        // foreach($items as $row){
        // print_r($row);
        //}
        echo '<script type="text/javascript">';
        //$num = $row['po_item_quantity'];
        foreach ($items as $row) {
            echo 'add_items_manually(' . $row['product_id'] . ',"' . $row['product_name'] . '","' . $row['product_code'] . '",' . $row['product_price'] . ',"","","","' . $row['po_item_quantity'] . '");';
        }
        echo '</script>';
    }
    ?>
</body>
<!-- end: BODY -->
</html>