<?php $this->load->view("common/header"); ?>
<!-- end: HEAD -->
<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<style type="text/css">
    .table>thead:first-child>tr:first-child>th,
    .table>thead:first-child>tr:first-child>td,
    .table-striped thead tr.primary:nth-child(2n+1) th {
        background-color: #428bca;
        border-color: #357ebd;
        border-top: 1px solid #357ebd;
        color: white;
        text-align: center;
    }
    td {}
    .active {
        font-weight: bold;
    }
    
    .dataTables_processing.panel.panel-default{
        display: flex;
        align-content: center;
        justify-content: center;
        align-items: center;
        height: 100%;
        width: 100%;
        top: 0;
    }
    .pricelist{
        list-style: none;padding: 0;text-wrap: nowrap;
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
                                    Product
                                </a>
                            </li>
                            <li class="active">
                                List Product
                            </li>
                            <li class="search-box">
                                <form class="sidebar-search">
                                    <div class="form-group">
                                        <input id="door" type="text" placeholder="Start Searching...">
                                        <button class="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </li>
                        </ol>
                        <div class="page-header">
                            <!--<h1>Product</h1>-->
                        </div>
                    </div>
                </div>
                <!-- end: PAGE HEADER -->
                <!-- start: PAGE CONTENT 
                    <!-- start grid -->
                <div class="row">
                    
                    <div class="col-sm-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="clip-stats"></i>
								Filters
								<div class="panel-tools">
									<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
									</a>
									<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
										<i class="fa fa-wrench"></i>
									</a>
									<a class="btn btn-xs btn-link panel-refresh" href="#">
										<i class="fa fa-refresh"></i>
									</a>
									<a class="btn btn-xs btn-link panel-close" href="#">
										<i class="fa fa-times"></i>
									</a>
								</div>
							</div>
							<div class="panel-body">
								<div class="col-xs-12 col-sm-6 col-md-3">
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
								</div>
								<div class="col-xs-12 col-sm-6 col-md-3">
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
								</div>
							</div>
						</div>
					</div>
                    
                    
                    
                    <div class="col-md-12">
                        <ul class="nav nav-tabs" id="product_types">
                            <?php foreach($types as $key=>$row){ ?>
                                <li title="<?php echo $row->product_type_description ?>" data-pt-id="<?php echo $row->product_type_id ?>" class="<?php echo $key == 0 ? 'active' : '' ?> li_pt"><a data-toggle="tab" href="#type<?php echo $key?>"><?php echo $row->product_type_name ?> <i class="fa fa-refresh fa-2x"></i></a></li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content">
                            <?php foreach($types as $key=>$row){ ?>
                                <div id="type<?php echo $key?>" class="tab-pane fade in <?php echo $key == 0 ? 'active' : '' ?>">
                                    <table class="table table-bordered table-condensed table-hover table-striped dataTable" id="products_table<?php echo $row->product_type_id ?>" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Product Image</th>
                                                        <th>Product Code</th>
                                                        <th>Product Name</th>
                                                        <th>Category</th>
                                                        <th>Sub Category</th>
                                                        <th>Display Price</th>
                                                        <!--<th>Wholesale Price</th>-->
                                                        <!--<th>Credit Price</th>-->
                                                        <th>Product Cost</th>
                                                        <!--<th>Units in Batch</th>-->
                                                        <th>Quantity</th>
                                                        <th>Order Token</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Product Image</th>
                                                        <th>Product Code</th>
                                                        <th>Product Name</th>
                                                        <th>Category</th>
                                                        <th>Sub Category</th>
                                                        <th>Display Price</th>
                                                        <!--<th>Wholesale Price</th>-->
                                                        <!--<th>Credit Price</th>-->
                                                        <th>Product Cost</th>
                                                        <!--<th>Units in Batch</th>-->
                                                        <th>Quantity</th>
                                                        <th>Order Token</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <!---->
                    <!-- start: DYNAMIC TABLE PANEL -->
                    <!-- end: DYNAMIC TABLE PANEL -->
                </div>
            </div>
            <!-- end grid -->
        </div>
        <!-- end: PAGE -->
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
    <!-- start ajax model -->
    <div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
    <!-- end ajax model -->
    <!-- start: MAIN JAVASCRIPTS -->
    <?php $this->load->view("common/footer"); ?>
    <!-- end: MAIN JAVASCRIPTS -->
    <script>
        jQuery(document).ready(function() {
            //TableData.init();
            //products_load();
            $('select[name = products_table_length]').addClass('search-select');
            $('select[name = products_table_length]').select2();
            $('#s2id_autogen1').css("margin-top", -8);

            $('#product_types > li:nth-child(1)').click();
        });
        
        $('.li_pt').on('click',function(){
            var pt_id = $(this).data('pt-id');
            //if(!$.fn.dataTable.isDataTable('#products_table'+pt_id))
            products_load(pt_id,$('#category').val(),$('#subcategory').val())
        });
        
        function products_load(pt_id,cat_id,sub_cat_id) {
            var dataTable = $('#products_table' + pt_id).DataTable({
                dom: 'Blfrtip',
                buttons: [{
                        extend: 'print',
                        text: '<i class="fa fa-print fa-2x">',
                        header: true,
                        footer: true,
                        title: "Product List",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 5, 6, 7, 8, 9, 10, 11]
                        },
                        customize: function(win) {}
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel-o fa-2x">',
                        footer: true
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fa fa-file-pdf-o fa-2x"></i>',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 5, 6, 7, 8, 9, 10, 11]
                        }
                    }
                    /*
                    ,
                    {
                        text: '<i class="fa fa-refresh fa-2x"></i>',
                        action: function(e, dt, node, config) {
                            dt.ajax.reload();
                        }
                    }*/
                ],
                ajax: {
                    url: "<?php echo base_url('products/get_list_product') ?>",
                    type: 'POST',
                    data: {
                        pt_id: pt_id,
                        cat_id : cat_id,
                        sub_cat_id : sub_cat_id
                    }
                },
                bDestroy: true,
                bProcessing: true,
                /*serverSide: true,*/
                iDisplayLength: 10
            });
        }

        function print_barcode(product_id) {
            window.open('products/single_barcode/' + product_id, 'sma_popup', 'width=900,height=600,scrollbars=yes,menubar=yes,status=no,resizable=yes,screenx=0,screeny=0');
        }
        function product_delete(product_id) {
            var r = confirm("Are you sure you want to disable this item !");
            if (r == true) {
                products_load();
                $.ajax({
                    url: "<?php echo base_url('products/delete_product'); ?>",
                    type: "POST",
                    data: {
                        product_id: product_id
                    },
                    success: function(data) {
                        var obj = jQuery.parseJSON(data);
                        if (obj.status == 0) {
                            $('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>' + obj.validation + '</div>');
                        } else {
                            set_message('Product notice!', 'Product disabled successfully');
                            products_load();
                        };
                    }
                });
            }
        }
        function product_enable(product_id) {
            var r = confirm("Are you sure you want to Enable this item !");
            if (r == true) {
                products_load();
                $.ajax({
                    url: "<?php echo base_url('products/enable_product'); ?>",
                    type: "POST",
                    data: {
                        product_id: product_id
                    },
                    success: function(data) {
                        var obj = jQuery.parseJSON(data);
                        if (obj.status == 0) {
                            $('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>' + obj.validation + '</div>');
                        } else {
                            set_message('Product notice!', 'Product permanent deleted successfully');
                            products_load();
                        };
                    }
                });
            }
        }
        
        $(document).on('keyup','#door',function(){
            if(this.value == 'prices'){
                $(this).val('');
                window.open('<?php echo base_url('products/prices'); ?>', 'popup', 'width=900,height=600,scrollbars=yes,menubar=yes,status=no,resizable=yes,screenx=0,screeny=0');
            }else if(this.value == 'update'){
                $(this).val('');
                window.open('<?php echo base_url('products/update'); ?>', 'popup', 'width=900,height=600,scrollbars=yes,menubar=yes,status=no,resizable=yes,screenx=0,screeny=0');
            }
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
    </script>
</body>
<!-- end: BODY -->
</html>