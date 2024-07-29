<?php $this->load->view("common/header"); ?>
<!-- end: HEAD -->
<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<!-- end: HEAD -->
<!-- start: BODY -->
<style>
    .form-group{
        cursor:pointer;
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
            <div class="modal fade" id="panel-config" tabindex-d="-1" role="dialog" aria-hidden="true">
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
                                Add Product
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
                            <h1>Add <?php echo isset($pd)? "Sub" : ""; ?> Product <?php echo isset($pd)? "for <strong>".$pd->product_name : "</strong>"; ?></h1>
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
                                Add Product
                            </div>
                            <div class="panel-body">
                                <div id="error"></div>
                                <?php
                                $config = array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'add_product_form', 'name' => 'add_product_form');
                                echo form_open_multipart("#", $config);
                                ?>
                                <!--coll left start-->
                                <div class="col-md-6 pull-left">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="product_name">
                                            Product Name *
                                        </label>
                                        <div class="col-sm-8">
                                            <input tabindex-d="1" type="text" id="product_name" class="form-control" name="product_name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="product_code">
                                            Product Code *
                                        </label>
                                        <div class="col-sm-8">
                                            <?php
                                            $reference_no = $this->common_model->gen_ref_number('product_id', 'product', 'PD');
                                            $product_id = $this->common_model->gen_ref_number('product_id', 'product', '');
                                            ?>
                                            <input tabindex-d="2" type="text" id="product_code" class="form-control" name="product_code" value="<?php echo $reference_no ?>">
                                            <input type="hidden" id="product_id" class="form-control" name="product_id" value="<?php echo $product_id ?>">
                                        </div>
                                    </div>
                                    
                                    <?php if(isset($pd)){?>
                                        <input type="hidden" id="category" name="category" value="<?php echo $pd->cat_id; ?>">
                                                <?php }else
                                    {?>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="category">
                                            Category*
                                        </label>
                                        <div class="col-sm-8">
                                            <select tabindex-d="3" class="form-control search-select" id="category" name="category">
                                                <option value="">&nbsp;</option>
                                                <?php foreach ($main_category as $key => $category) { ?>
                                                    <option value="<?php echo $category->cat_id; ?>"><?php echo $category->cat_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php }?>
                                    
                                    <?php if(isset($pd)){?>
                                        <input type="hidden" id="subcategory" name="subcategory" value="<?php echo $pd->sub_cat_id; ?>">
                                    <?php }else
                                    {?>
                                                
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="subcategory">
                                            Sub Category
                                        </label>
                                        <div id="subcat_data" class="col-sm-8">
                                            <select tabindex-d="4" data-placeholder="Select Category to load Subcategories" id="subcategory" class="form-control search-select" name="subcategory">
                                                <option selected="selected" value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <?php }?>
                                    
                                    <?php if(isset($pd)){?>
                                        <input type="hidden" id="product_type" name="product_type" value="<?php echo $pd->product_type_id; ?>">
                                    <?php }else {?>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="product_type">
                                                Product Type
                                            </label>
                                            <div class="col-sm-8">
                                                <select tabindex-d="4" data-placeholder="Select Product type" class="form-control search-select" name="product_type" id="product_type">
                                                    <option selected="selected" value=""></option>
                                                    <?php foreach($product_types as $p){ ?>
                                                        <option value="<?php echo $p->product_type_id;?>"><?php echo $p->product_type_name;?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php }?>
                                    
                                    <?php if(isset($pd)){?>
                                        <input type="hidden" id="main_id" name="main_id" value="<?php echo $pd->product_id; ?>">
                                    <?php }else {?>
                                        <input type="hidden" id="main_id" name="main_id" value="0">
                                    <?php }?>
                                    
                                    
                                    
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="product_size">
                                            Product Weight / Volume / Weight *
                                        </label>
                                        <div class="col-sm-8"  style="padding:0">
                                            <div class="col-sm-6">
                                                <input type="text" name="product_size" id="product_size" placeholder="<?php if(isset($pd))echo $pd->product_size; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <?php if(isset($pd)){?>
                                                    <?php echo $pd->unit_name; ?>
                                                    <input type="hidden" id="unit" name="unit" value="<?php echo $pd->product_unit; ?>">
                                                <?php }else
                                                {?>
                                                
                                                <select tabindex-d="5" class="form-control search-select" id="unit" name="unit">
                                                    <?php foreach ($unit_type as $key => $unit) {
                                                        if ($unit->unit_code == "Item") {
                                                            echo "<option selected value='$unit->unit_id'>$unit->unit_code</option>";
                                                        } else {
                                                            echo "<option value='$unit->unit_id'>$unit->unit_code</option>";
                                                        }
                                                    } ?>
                                                </select>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="userfile">
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
                                                            <input tabindex-d="6" type="file" class="file-input" name="userfile">
                                                        </div>
                                                        <a href="#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
                                                            <i class="fa fa-times"></i> Remove
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--coll left end-->
                                <!--coll right start-->
                                <div class="col-md-6 pull-right">
                                    <!-- cost -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="product_cost">
                                            Product Cost *
                                        </label>
                                        <div class="col-sm-8">
                                            <input tabindex-d="8" type="text" id="product_cost" class="form-control auto" name="product_cost">
                                        </div>
                                    </div>
                                    <div class="form-group collapse">
                                        <label class="col-sm-3 control-label" for="prices_table">
                                            Prices
                                        </label>
                                        <div class="col-sm-8">
                                            <!-- Plus Button -->
                                            <button type="button" class="btn btn-primary" onClick="check()">Add Price</button>
                                            <table class="table" id="prices_table">
                                                <thead>
                                                    <tr>
                                                        <th>Price type</th>
                                                        <th>Value</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="product_price">
                                            Display Price *
                                        </label>
                                        <div class="col-sm-8">
                                            <input tabindex-d="7" type="text" id="product_price" class="form-control" name="product_price">
                                        </div>
                                    </div>
                                
                                    <div class="form-group collapse">
                                        <label class="col-sm-3 control-label" for="alert_qty">
                                            Alert Quantity
                                        </label>
                                        <div class="col-sm-8">
                                            <input tabindex-d="11" type="text" id="alert_qty" name="alert_qty" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group collapse">
                                        <label class="col-sm-3 control-label" for="store_position">
                                            Store Position
                                        </label>
                                        <div class="col-sm-8">
                                            <input tabindex-d="12" type="text" id="store_position" class="form-control" name="store_position">
                                        </div>
                                    </div>
                                    <!--na-->
                                    
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="control-label col-sm-3" for="product_details" style="margin-left:-14px">
                                                Product Details
                                            </label>
                                            <div class="col-sm-8">
                                                <textarea tabindex-d="14" style="margin-left:8px; width:106%;" class="ckeditor form-control" cols="12" rows="2" name="product_details"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12"> 
                                            <div class="col-sm-3 row">
                                                <label> Order Token </label>
                                            </div>
                                            <div class="col-sm-8" style="padding-left:55px">
                                                <select class="form-group search-select" id="ott" name="ott">
                                                    <?php foreach($ot_types as $type){ ?>
                                                        <option value="<?php echo $type->ott_id ?>"><?php echo $type->ott_description; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--coll right end-->

                                <div class="form-group">
                                    <div class="col-sm-12 text-right">
                                        <button tabindex-d="15" class="btn btn-primary btn-squared" type="submit">
                                            Add Product
                                        </button>
                                    </div>
                                </div>
                                </form>
                            </div>
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
    <div id="event-management" class="modal fade" tabindex-d="-1" data-width="760" style="display: none;">
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
    <!-- Price Type Modal -->
    <div class="modal fade" id="priceTypeModal" tabindex-d="-1" role="dialog" aria-labelledby="priceTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog-d" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="priceTypeModalLabel">Select Price Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Price Type Options -->
                    <select id="priceTypeSelect" class="form-control">
                        <?php
                        // Loop through priceTypes and generate options dynamically
                        foreach ($price_types as $priceType) {
                            echo "<option value='{$priceType->pt_id}'>{$priceType->pt_name}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="showSelectedPriceType()">Select</button>
                </div>
            </div>
        </div>
    </div>
    <!-- start: MAIN JAVASCRIPTS -->
    <?php $this->load->view("common/footer"); ?>
    <!-- end: MAIN JAVASCRIPTS -->
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
    <script src="<?php echo asset_url(); ?>plugins/jquery-validation/dist/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/autoNumeric.js"></script>
    <script src="<?php echo asset_url(); ?>js/form-validation-add-product.js"></script>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
    <?php $price_types_json = json_encode($price_types); ?>
    <script>
        // Use the JSON string in JavaScript
        var priceTypes = <?php echo $price_types_json; ?>;
        console.log(priceTypes);
        jQuery(document).ready(function() {
            /*$(".search-select").select2({
            	allowClear: true
            });*/
            FormValidator.init();
            $('.auto').autoNumeric('init');
        });
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
        //$('#priceTypeModal').modal('hide');
        function check() {
            var product_cost = $('#product_cost').val();
            if (isNaN(product_cost) || !product_cost > 0) {
                alert("Please enter the product cost! Pricing will run over the product cost.");
                return false;
            } else {
                $('#priceTypeModal').modal('show');
            }
        }

        function showSelectedPriceType() {
            var product_cost = $('#product_cost').val();
            if (isNaN(product_cost) || !product_cost > 0) {
                alert("Please enter the product cost! Pricing will run over the product cost.");
                return false;
            }
            $('#product_cost').attr('readonly', 'true');
            // Close the modal
            $('#priceTypeModal').modal('hide');
            // Get the selected value from the dropdown
            var selectedValue = document.getElementById("priceTypeSelect").value;
            // loop through priceTypes array and find the data of the price type that selected
            $(priceTypes).each((a, b) => {
                console.log('b', b.pt_id);
                // if found a match
                if (b.pt_id == selectedValue) {
                    console.log('b', b);
                    // calculate the price here
                    calculateAndAppendPrice(b);
                    // append the row to $('#prices_table > tbody')
                }
            });
        }

        function calculateAndAppendPrice(selectedPriceType) {
            if ($('#pt_' + selectedPriceType.pt_id).length > 0) {
                alert("Already added!");
                return false;
            }
            // Assuming selectedPriceType is the object received from console.log('b', b);
            // Get the required values from the selected price type
            var addOrDeduct = selectedPriceType.add_or_deduct;
            var percentageOrAmount = selectedPriceType.percentage_or_amount;
            var amount = parseFloat(selectedPriceType.amount);
            // Assuming you have a variable for the product cost
            var productCost = parseFloat($('#product_cost').val());
            // Calculate the price based on the selected price type
            var calculatedPrice = 0;
            if (addOrDeduct === 'add') {
                if (percentageOrAmount === 'percentage') {
                    calculatedPrice = productCost + (productCost * amount / 100);
                } else {
                    calculatedPrice = productCost + amount;
                }
            } else {
                if (percentageOrAmount === 'percentage') {
                    calculatedPrice = productCost - (productCost * amount / 100);
                } else {
                    calculatedPrice = productCost - amount;
                }
            }
            // Append the calculated price to the table
            var tableRow = '<tr id="pt_' + selectedPriceType.pt_id + '" <input type="hidden" name="pt_id[]" value="' + selectedPriceType.pt_id + '">>' +
                '<td>' + selectedPriceType.pt_name + '</td>' +
                '<td> <input type="text" readonly name="prices[' + selectedPriceType.pt_id + ']" value="' + calculatedPrice.toFixed(2) + '"></td>' +
                '<td>' +
                '<button type="button" class="btn btn-xs btn-warning" title="fix" onclick="fix(this)"><i class="fa fa-gavel"></i></button> ' +
                '<button type="button" class="btn btn-xs btn-danger" title="remove" onclick="remove(this)"><i class="fa fa-times"></i></button>' +
                '</td>' +
                '</tr>';
            $('#prices_table tbody').append(tableRow);
        }

        function add_product(form) {
            $('body').modalmanager('loading');
            setTimeout(function() {
                $.ajax({
                    url: "<?php echo base_url('products/save_product'); ?>", // Url to which the request is send
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
                        } else {
                            $('body').modalmanager('removeLoading');
                            $('body').attr('class', '');
                            set_message('categories notice!', 'Product successfully Added');
                            document.getElementById("add_product_form").reset();
                            setTimeout(function() {
                                window.location.reload(this);
                            }, 2000);
                        };
                    }
                });
            }, 1000);
        }

        function remove(elem) {
            $(elem).closest('tr').remove();
        }

        function fix(elem) {
            var tr = $(elem).closest('tr');
            var elem = $(tr).find('input[name="value[]"]');
            var value = $(tr).find('input[name="value[]"]').val();
            $(elem).val(roundUpToMultipleOfTen(value).toFixed(2));
        }

        function roundUpToMultipleOfTen(number) {
            return Math.ceil(number / 10) * 10;
        }
        /*focus chk*/
        $('input').focus(function() {
            console.log(this.id);
        });
        /*end focus*/
    </script>
</body>
<!-- end: BODY -->

</html>