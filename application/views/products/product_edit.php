<?php $this->load->view("common/header"); ?>
<!-- end: HEAD -->


<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/select2/select2.css" />
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
<!--<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/jQuery-Tags-Input/jquery.tagsinput.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/summernote/build/summernote.css">-->
<link rel="stylesheet" href="<?php echo asset_url(); ?>css/jquery-ui.css">

<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->




<!-- end: HEAD -->
<!-- start: BODY -->

<style type="text/css">
    .table>thead:first-child>tr:first-child>th,
    .table>thead:first-child>tr:first-child>td,
    .table-striped thead tr.primary:nth-child(2n+1) th {
        background-color: #428bca;
        border-color: #357ebd;
        border-top: 1px solid #357ebd;
        color: white;
        font-size: 14px;
        text-align: center;
    }
</style>

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
            <!-- start: PANEL CONFIGURATION MODAL FORM -->
            <div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title">Panel Configuration</h4>
                        </div>
                        <div class="modal-body">
                            Here will be a configuration form
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Close
                            </button>
                            <button type="button" class="btn btn-primary">
                                Save changes
                            </button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
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
                                    Product
                                </a>
                            </li>

                            <li class="active">
                                Edit Product
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
                            <h1>Edit Product</h1>
                        </div>
                        <!-- end: PAGE TITLE & BREADCRUMB -->
                    </div>
                </div>
                <!-- start grid -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- start: DYNAMIC TABLE PANEL -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-external-link-square"></i>
                                Edit Product
                            </div>

                            <?php
                            $config = array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'add_product_form', 'name' => 'add_product_form');
                            echo form_open_multipart("#", $config);
                            ?>
                            <input type="hidden" name="product_id" value="<?php echo $product_details->product_id; ?>">

                            <div class="panel-body">
                                <!--coll left start-->
                                <div class="col-md-6 pull-left">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="form-field-1">
                                            Product Name
                                            *</label>
                                        <div class="col-sm-8">
                                            <input tabindex="1" type="text" id="product_name" class="form-control" name="product_name" value="<?php echo $product_details->product_name; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="form-field-2">
                                            Product Code
                                            *</label>
                                        <div class="col-sm-8">
                                            <input tabindex="2" type="text" id="product_code" class="form-control" value="<?php echo $product_details->product_code; ?>" name="product_code">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="form-field-3">
                                            Category*
                                        </label>
                                        <div class="col-sm-8">
                                            <select tabindex="3" class="form-control search-select" id="category" name="category">
                                                <option value="">&nbsp;</option>
                                                <?php foreach ($main_category as $key => $category) {
                                                    if ($product_details->cat_id == $category->cat_id) {
                                                        echo "<option selected value='$category->cat_id'>$category->cat_name</option>";
                                                    } else {
                                                        echo "<option value='$category->cat_id'>$category->cat_name</option>";
                                                    }
                                                } ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="form-field-3">
                                            Sub Category
                                        </label>
                                        <div id="subcat_data" class="col-sm-8">
                                            <select tabindex="4" data-placeholder="Select Category to load Subcategories" id="subcategory" class="form-control search-select" name="subcategory">
                                                <?php foreach ($sub_category as $key => $sub_category) {
                                                    if ($product_details->sub_cat_id == $sub_category->sub_cat_id) {
                                                        echo "<option selected value='$sub_category->sub_cat_id'>$sub_category->sub_cat_name</option>";
                                                    } else {
                                                        echo "<option value='$sub_category->sub_cat_id'>$sub_category->sub_cat_name</option>";
                                                    }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="subcategory">
                                            Product Type *
                                        </label>
                                        <div class="col-sm-8">
                                            <select tabindex-d="4" data-placeholder="Select Product type" id="subcategory" class="form-control search-select" name="product_type" id="product_type" required>
                                                <option value=""></option>
                                                <?php
                                                foreach ($product_types as $p) {
                                                ?>
                                                    <option value="<?php echo $p->product_type_id; ?>" <?php echo ($p->product_type_id == $product_details->product_type_id) ? 'selected="selected"' : '' ?>><?php echo $p->product_type_name; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="form-field-2">
                                            Product Size *
                                        </label>
                                        <div class="col-sm-8" style="display: flex;flex-direction: row;padding: 0;align-items: flex-end;justify-content: center;">
                                            <div class="col-sm-6">
                                                <input type="text" class="" id="product_size" name="product_size" value="<?php echo $product_details->product_size; ?>" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <select tabindex="5" id="form-field-select-3 unit" class="form-control search-select" name="unit">
                                                    <option value="">&nbsp;</option>
                                                    <?php foreach ($unit_type as $key => $unit) {
                                                        if ($product_details->product_unit == $unit->unit_id) {
                                                            echo "<option selected value='$unit->unit_id'>$unit->unit_code</option>";
                                                        } else {
                                                            echo "<option value='$unit->unit_id'>$unit->unit_code</option>";
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="form-field-2">
                                            Product Image
                                        </label>
                                        <div class="col-sm-8">
                                            <div class="fileupload fileupload-new" data-provides="fileupload">

                                                <div class="input-group">
                                                    <div class="form-control uneditable-input">
                                                        <i class="fa fa-file fileupload-exists"></i>
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <div class="input-group-btn">
                                                        <div class="btn btn-light-grey btn-file">
                                                            <span class="fileupload-new"><i class="fa fa-folder-open-o"></i> Select file</span>
                                                            <span class="fileupload-exists"><i class="fa fa-folder-open-o"></i> Change</span>
                                                            <input tabindex="6" type="file" class="file-input" name="userfile">
                                                        </div>
                                                        <a href="#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
                                                            <i class="fa fa-times"></i> Remove
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <img src="<?php echo base_url() ?>thems/uploads/thumbs/<?php echo $product_details->product_thumb ?>" alt="">
                                        </div>
                                    </div>

                                </div>
                                <!--coll left end-->

                                <!--coll right start-->
                                <div class="col-md-6 pull-left">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="form-field-2">
                                            Display Price *
                                        </label>
                                        <div class="col-sm-8">
                                            <input tabindex="7" type="text" id="product_price" class="form-control auto" name="product_price" value="<?php echo $product_details->product_price; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="product_cost">
                                            Product Cost *
                                        </label>
                                        <div class="col-sm-8">
                                            <input tabindex="8" type="text" id="product_cost" class="form-control auto" name="product_cost" data-a-sign="Rs. " data-d-group="2" value="<?php echo $product_details->product_cost; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group collapse">
                                        <label class="col-sm-3 control-label" for="form-field-2">
                                            Alert Quantity
                                        </label>
                                        <div class="col-sm-8">
                                            <input tabindex="11" type="text" id="form-field-2" name="alert_quty" class="form-control" value="<?php echo $product_details->product_alert_qty; ?>">
                                        </div>
                                    </div>
                                    <!--
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="form-field-2">
                                            Store Position
                                        </label>
                                        <div class="col-sm-8">
                                            <input tabindex="12" type="text" id="store_position" class="form-control" name="store_position" value="<?php echo $product_details->store_position; ?>">
                                        </div>
                                    </div>
                                    -->
                                    <!--
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="form-field-2">
                                            Type
                                        </label>
                                        <div class="col-sm-8">
                                            <input tabindex="12" type="text" id="product_part_no" class="form-control" name="product_part_no" value="<?php echo $product_details->product_part_no; ?>">
                                        </div>
                                    </div>
                                    -->
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="control-label col-sm-3" style="margin-left:-14px">
                                                Product Details
                                            </label>
                                            <div class="col-sm-8">
                                                <textarea tabindex="" 14style="margin-left:8px; width:106%;" class="ckeditor form-control" cols="12" rows="2" name="product_details"><?php echo $product_details->product_details; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            
                                            <label class="control-label col-sm-3" style="margin-left:-14px">
                                                Order Token
                                            </label>
                                            <div class="col-sm-8 ">
                                                <!--<select class="form-group select2" id="ott" name="ott">
                                                    <option value="0">No Token</option>
                                                    <?php foreach($ot_types as $type){ ?>
                                                        <option <?php echo $product_details->ott == $type->ott_id ? "selected" : "" ;?> value="<?php echo $type->ott_id ?>"><?php echo $type->ott_description; ?></option>
                                                    <?php } ?>
                                                </select>-->
                                                
                                                <div class="form-group">
                                                    <?php foreach($ot_types as $type){ ?>
                                                    <input type="radio" id="<?php echo $type->ott_description; ?>" name="ott" value="<?php echo $type->ott_id ?>" <?php echo $product_details->ott == $type->ott_id ? "checked" : "" ;?>>
                                                    <label for="<?php echo $type->ott_description; ?>"><?php echo $type->ott_description; ?></label><br>
                                                <?php } ?>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label class="control-label col-sm-3" style="margin-left:-14px">
                                                    Manage item's
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="checkbox" id="is_saleable" name="is_saleable" value="1" <?php echo $product_details->is_saleable ? 'checked':''; ?>>
                                                    <label for="is_saleable"> Sales </label><br>
                                                    
                                                    <input type="checkbox" id="is_purchasable" name="is_purchasable" value="1" <?php echo $product_details->is_purchasable ? 'checked':''; ?>>
                                                    <label for="is_purchasable"> Purchasing </label><br>
                                                    
                                                    <input type="checkbox" id="is_stockable" name="is_stockable" value="1" <?php echo $product_details->is_stockable ? 'checked':''; ?>>
                                                    <label for="is_stockable"> Stock </label><br>
                                                    
                                                    <input type="checkbox" id="is_transferable" name="is_transferable" value="1" <?php echo $product_details->is_transferable ? 'checked':''; ?>>
                                                    <label for="is_transferable"> Transfers </label>

                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-12">
                                            <button class="btn btn-primary btn-squared pull-right" type="submit">
                                                Update Product
                                            </button>
                                            
                                            <button class="btn btn-warning btn-squared pull-right" type="button" style="margin-right: 20px;" onclick="cc()">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!--coll right end-->
                            </div>
                            </form>
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
            2018 &copy;
        </div>
        <div class="footer-items">
            <span class="go-top"><i class="clip-chevron-up"></i></span>
        </div>
    </div>
    <!-- end: FOOTER -->
    <!-- start: RIGHT SIDEBAR -->
    <div id="page-sidebar">
        <a class="sidebar-toggler sb-toggle" href="#"><i class="fa fa-indent"></i></a>
        <div class="sidebar-wrapper">
            <ul class="nav nav-tabs nav-justified" id="sidebar-tab">
                <li class="active">
                    <a href="#users" role="tab" data-toggle="tab"><i class="fa fa-users"></i></a>
                </li>
                <li>
                    <a href="#favorites" role="tab" data-toggle="tab"><i class="fa fa-heart"></i></a>
                </li>
                <li>
                    <a href="#settings" role="tab" data-toggle="tab"><i class="fa fa-gear"></i></a>
                </li>
            </ul>
        </div>
    </div>
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


    <script src="<?php echo asset_url(); ?>js/jquery-ui.js"></script>
    <script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script>
    <!--<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script>-->
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->

    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
    <script src="<?php echo asset_url(); ?>plugins/jquery-validation/dist/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/autoNumeric.js"></script>
    <script src="<?php echo asset_url(); ?>js/form-validation-add-product.js"></script>


    <!--<script src="<?php echo asset_url(); ?>js/booking_add.js"></script>
    <script src="<?php echo asset_url(); ?>js/booking_extra_itm_add.js"></script>-->
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->

    <script>
        /*function save_menu_item_details() {
            var fields = $("#recipe_items_form").serialize();
            $.post("<?php echo base_url(); ?>booking/booking_menu_item_save", fields)
                .done(function(data) {
                    //alert();
                    var obj = jQuery.parseJSON(data);
                    if (obj.error == 1) {
                        $('.alert-success').hide();
                        $('.alert-danger').show();
                        $(".errortxt").text(obj.disMsg);
                    }
                    if (obj.error == 0) {
                        $("#vcl_sr_itm_save").prop("disabled", false);
                        $("#vcl_sr_itm_save").val('Add Service');
                        calculateBookingGrandTotal();
                    }
                });
            return false;
        }*/

        $('input').click(function() {
            $(this).select();
        });

        //Save Extra Items
        $("#save_form").click(function() {
            //alert();
            var fields = $("#recipe_items_form").serialize();
            // alert(fields);
            $.post("<?php echo base_url(); ?>products/save_recipe_items", fields)
                .done(function(data) {
                    //window.location.reload();
                    var obj = jQuery.parseJSON(data);
                    if (obj.error == 1) {
                        $('.alert-success').hide();
                        $('.alert-danger').show();
                        $(".errortxt").text(obj.disMsg);
                    }
                    if (obj.error == 0) {
                        displayNotice('page', 'Recipe items successfully added!');
                        $("#save_form").prop("disabled", false);
                        $("#save_form").val('Add Exttra Items');
                        //clearForm();
                        calculateBookingGrandTotal();
                    }
                });
        });

        //extra item start
        $("#add_extra_item_tab").autocomplete({
            source: function(request, response) {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>products/suggestions',
                    data: {
                        'term': request.term,
                        'location': $("#warehouse_id").val(),
                        'this_id': <?php echo $product_details->product_id; ?>
                    },
                    dataType: 'json',
                    success: (data) => {
                        response(data)
                    }
                });
            },
            //source: '<?php echo base_url(); ?>products/suggestions?w=' + $("#warehouse_id").val(),
            minLength: 1,
            autoFocus: false,
            delay: 5,
            response: function(event, ui) {
                if (ui.content.length == 1 && ui.content[0].product_id != 0) {
                    //ui.item = ui.content[0];
                    //$(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    //$(this).autocomplete('close');
                    //$(this).removeClass('ui-autocomplete-loading');
                } else if (ui.content.length == 0) {
                    var noResult = {
                        value: "",
                        label: "No matching result found! Service might be out of stock in the selected warehouse."
                    };
                    ui.content.push(noResult);
                } else {

                }
            },
            select: function(event, data) {
                //alert( "You selected: " + data.item.product_id );
                if (data.item.value) {

                    if ($('#row_e_' + parseInt(data.item.product_id)).length) {
                        calculateTotal();
                        displayNotice('page', 'Already added menu item');
                    } else {
                        add_to_recipe_list(data.item.product_id, data.item.product_code, data.item.product_name, data.item.product_price, data.item.unit_code);
                        calculateTotal();
                    }
                    $("#add_extra_item_tab").val('');
                    return false;
                }
                $(this).autocomplete('close');
                $(this).removeClass('ui-autocomplete-loading');

            }
        });

        function calculateTotal() {
            var rowCount = parseInt($('#recipe_item_table > tbody > tr').length);
            if (rowCount) {
                $('#recipe_item_table > tbody > tr').each(function(a, b) {
                    console.log('a', a);
                    console.log('b', b);

                    var item_id = $(this).data('item-id');
                    var price = $('#price_e_' + item_id).val();
                    var qty = $('#itm_qty_' + item_id).val();
                    var sub_total = parseFloat(price) * qty;
                    $('#sub_total').val(sub_total);
                });
            }

        }

        jQuery(document).ready(function() {

            FormValidator.init();
            //$('.auto').autoNumeric('init');
        });

        /*focus chk*/


        $(window).keydown(function(event) {
            //console.log(document.activeElement.id);
            $(":focus").each(function() {
                //alert("Focused Elem_id = "+ this.id );
                focus_id = this.id;
                console.log("keydown:" + focus_id + "|" + event.keyCode);

                //	alert(focus_id);
                //	alert(event.keyCode);
                var rowCount = $('#rowCount').val();
                var fld = 'quantity_' + rowCount;
                if (focus_id == fld) {
                    if (event.keyCode == 16) {
                        $('#add_item').focus();
                    }
                }
                if (event.keyCode == 18) {
                    calculateTotal();

                }

                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });

        $(window).click(function(event) {
            $(":focus").each(function() {
                //alert("Focused Elem_id = "+ this.id );
                focus_id = this.id;
                console.log("clicked:" + focus_id + "|" + event);

                //	alert(focus_id);
                //	alert(event.keyCode);
                var rowCount = $('#rowCount').val();
                var fld = 'quantity_' + rowCount;
                if (focus_id == fld) {
                    if (event.keyCode == 16) {
                        $('#add_item').focus();
                    }
                }
                if (event.keyCode == 18) {
                    calculateTotal();

                }

                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

        });
        /*end focus*/
        $('select#category').on('change', function() {

            var v = $(this).val();

            $.ajax({
                type: "get",
                async: false,
                url: "<?php echo base_url('products/get_sub_category_by_id'); ?>",
                data: {
                    category_id: v
                },
                dataType: "html",
                success: function(data) {
                    if (data != "") {
                        $('#subcat_data').empty();
                        $('#subcat_data').html(data);
                        $("#subcategory").select2({
                            allowClear: true
                        });
                    } else {
                        $('#subcat_data').empty();
                        var default_data = '<select name="subcategory" id="subcategory" class="form-control search-select" data-placeholder="Select Category to load Subcategories"></select>';
                        $('#subcat_data').html(default_data);
                        $("#subcategory").select2({
                            allowClear: true
                        });
                        set_message("Product Info", "No Subcategory found for the select category.");
                    }
                },
                error: function() {
                    alert('Error occured while getting data from server.');
                }

            });
        });

        function add_product(form) {
            $('body').modalmanager('loading');
            setTimeout(function() {
                $.ajax({
                    url: "<?php echo base_url('products/edit_product'); ?>", // Url to which the request is send
                    type: "POST", // Type of request to be send, called as method
                    data: new FormData(form), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false, // To send DOMDocument or non processed data file it is set to false
                    success: function(data) // A function to be called if request succeeds
                    {
                        var obj = jQuery.parseJSON(data);
                        if (obj.status == 0) {
                            $('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>' + obj.validation + '</div>');
                            $('body').modalmanager('removeLoading');
                            $('body').attr('class', '');
                            set_message('Notice!', 'No changes found!');
                        } else {
                            $('body').modalmanager('removeLoading');
                            $('body').attr('class', '');
                            set_message('Notice!', 'Product successfully Updated');
                            setTimeout(()=>{
                                window.location.href = "<?php echo base_url()?>products/view/<?php echo $product_details->product_id; ?>"
                            },400);
                        };

                    }
                });
            }, 1000);
        }

        function add_to_recipe_list(item_id, item_code, item_name, item_price, unit_code) {

            var sub_tot = item_price;
            var nxtCount = parseInt(item_id);

            $('#recipe_item_table tbody').prepend('<tr class="child" data-item-id="' + nxtCount + '" id="row_e_' + nxtCount + '">' +
                '<td>' + item_name + ' (' + item_code + ') ' + '<input type="hidden" name="row_e[' + nxtCount + '][item_id]" value="' + item_id + '"></td>' +
                '<td><input style="width:100%; text-align:right" type="text" name="row_e[' + nxtCount + '][bkng_itm_note]" id="item_note_' + nxtCount + '" value="">' + '</td>' +
                //'<td class="text-right"><input style="width:100%; text-align:right" type="text" name="row_e['+nxtCount+'][price]" id="price_e_'+nxtCount+'" value="'+item_price+'">'+'</td>'+
                '<td class="text-right"><input style="width:100px; text-align:right" type="text" name="row_e[' + nxtCount + '][itm_qty]" id="itm_qty_' + nxtCount + '" onclick="this.select(); setTmpVal(this.value);" onchange="allowDecimals(this);calculateTotal();"; value="' + 1 + '"> (' + unit_code + ') </td>' +
                //'<td class="text-right"><input style="width:100px; text-align:right" type="text" name="row_e['+nxtCount+'][sub_tot]" id="sub_tot_'+nxtCount+'" value="'+sub_tot+'"></td>'+
                '<td><a onclick="delete_item(this)"><i class="fa fa-times" title="Remove" style="cursor:pointer;"></i></a></td>' +
                '</tr>');
            calculateTotal();
        }

        function delete_item(a) {
            $(a).closest('tr').remove();
            $("#save_form").click();
            displayNotice('Booking', 'Menu item has been deleted successfully!');
            calculateTotal();
            return false;
        }

        function allowDecimals(input) {
            // Validate the input value to allow decimals
            var numericValue = parseFloat(input.value);

            if (isNaN(numericValue)) {
                input.value = 0; // Clear the input if not a valid number
            } else {
                // Set the input value to the validated numeric value
                input.value = numericValue.toFixed(2); // Adjust the decimal places as needed
            }
        }
        
        function cc(){
            window.location.href = "<?php echo base_url()?>products/view/<?php echo $product_details->product_id; ?>";
        }
    </script>
</body>
<!-- end: BODY -->

</html>