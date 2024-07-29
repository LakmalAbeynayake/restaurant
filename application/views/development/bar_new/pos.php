<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>POS Module | Stock Manager Advance</title>

    <link rel="stylesheet" href="<?php echo asset_url(); ?>css/perfect-scrollbar.min.css" />
    <script src="<?php echo asset_url(); ?>js/moment.min.js"></script>
    <link rel="stylesheet" href="<?php echo asset_url(); ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo asset_url(); ?>css/style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo asset_url(); ?>css/bar.0.3.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo asset_url(); ?>css/jquery-ui.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
    <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/iCheck/skins/all.css">
    <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/gritter/css/jquery.gritter.css" type="text/css">
    <link rel="stylesheet" href="<?php echo asset_url(); ?>css/print_pos.css" type="text/css" media="print" />
    <!--<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen" />-->
    <!--<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />-->
    <style>
        @font-face {
            font-family: FontAwesome;
            font-weight: 400;
            font-style: normal
        }

        @font-face {
            font-family: Ubuntu;
            font-style: normal;
            font-weight: 400
        }

        @font-face {
            font-family: 'Ubuntu';
            font-style: normal;
            font-weight: 700;
            src: local('Ubuntu Bold'), local('Ubuntu-Bold'),
                url(<?php echo asset_url(); ?>fonts/trnbTfqisuuhRVI3i45C5w.woff) format('woff');
        }

        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6,
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: Ubuntu, sans-serif
        }

        .hide_me {
            visibility: hidden
        }

        .modal.fade.in {
            top: 4%
        }

        .btn-round-xs {
            border-radius: 11px;
            padding-left: 10px;
            padding-right: 10px
        }

        #makeMeScrollable {
            width: 100%;
            position: relative;
            clear: both
        }

        #add_item {
            background: right no-repeat;
            padding-right: 17px
        }

        .select2-container .select2-choice .select2-arrow {
            background-image: none !important;
            width: 28px !important;
            text-align: center;
            padding-top: 0
        }

        .select2-container .select2-choice .select2-arrow b {
            background: 0 0 !important;
            display: block;
            height: 100%;
            width: 100%
        }

        .select2-container .select2-choice .select2-arrow b:before {
            content: "\f078";
            display: inline;
            font-family: FontAwesome;
            font-weight: 300;
            height: auto;
            text-shadow: none
        }

        .select2-dropdown-open.select2-container-active .select2-choice .select2-arrow b:before {
            content: "\f077"
        }

        .select2-container-multi .select2-choices {
            background-image: none !important;
            background-color: #FFF !important
        }

        body {
            font-size: 13px
        }

        .input-group-addon {
            text-align: left;
            background-color: inherit
        }

        #s2id_poscustomer {
            border-left: 0;
            background-color: inherit;
            border-top: 0 none
        }

        #cpinner {
            width: 100%
        }

        .tab-green>li.active>a,
        .tab-green>li.active>a:focus,
        .tab-green>li.active>a:hover {
            border-color: #3d9400 #ddd transparent;
            border-top: 2px solid #3d9400
        }

        .tab-green>li>a:hover {
            color: #3d9400
        }

        .tab-green>li.dropdown.open.active>a:focus,
        .tab-green>li.dropdown.open.active>a:hover,
        .tab-green>li.open .dropdown-toggle {
            background-color: #3d9400;
            border-color: #3d9400;
            color: #fff
        }

        .tab-green .active>a,
        .tab-green .active>a:focus,
        .tab-green .active>a:hover,
        .tab-green .dropdown-menu>li>a:focus,
        .tab-green .dropdown-menu>li>a:hover {
            background-color: #3d9400
        }

        body .modal {
            width: auto !important
        }

        .dataTables_processing {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 40px;
            margin-left: -50%;
            margin-top: -25px;
            padding-top: 0;
            text-align: center;
            font-size: 2em;
            background-color: #fff;
            background: -webkit-gradient(linear, left top, right top, color-stop(0, rgba(255, 255, 255, 0)), color-stop(25%, rgba(255, 255, 255, .9)), color-stop(75%, rgba(255, 255, 255, .9)), color-stop(100%, rgba(255, 255, 255, 0)));
            background: -webkit-linear-gradient(left, rgba(255, 255, 255, 0) 0, rgba(255, 255, 255, .9) 25%, rgba(255, 255, 255, .9) 75%, rgba(255, 255, 255, 0) 100%);
            background: -moz-linear-gradient(left, rgba(255, 255, 255, 0) 0, rgba(255, 255, 255, .9) 25%, rgba(255, 255, 255, .9) 75%, rgba(255, 255, 255, 0) 100%);
            background: -ms-linear-gradient(left, rgba(255, 255, 255, 0) 0, rgba(255, 255, 255, .9) 25%, rgba(255, 255, 255, .9) 75%, rgba(255, 255, 255, 0) 100%);
            background: -o-linear-gradient(left, rgba(255, 255, 255, 0) 0, rgba(255, 255, 255, .9) 25%, rgba(255, 255, 255, .9) 75%, rgba(255, 255, 255, 0) 100%);
            background: linear-gradient(to right, rgba(255, 255, 255, 0) 0, rgba(255, 255, 255, .9) 25%, rgba(255, 255, 255, .9) 75%, rgba(255, 255, 255, 0) 100%)
        }


        .form-control.input-sm {
            font-size: 19px !important;
        }

        .ui-widget {
            font-size: 1.8em;
        }

        #ajaxproducts {
            height: 100%;
            width: 100%;
            overflow: hidden;
        }

        /*#item-list{
    width: 100%;
    height: 100%;
    overflow-y: scroll;
    padding-right: 17px; /* Increase/decrease this value for cross-browser compatibility */
        /*	margin-bottom: -17px;
    box-sizing: content-box; /* So the width will be 100% + 17px */
        /*}*/
        #item-list {
            width: 100%;
            height: 500px;
            overflow-y: scroll;
            padding-right: 17px;
            margin-bottom: -17px;
            box-sizing: content-box;
            /* height: 30%; */
        }

        .home-fer_btn {

            font-weight: bold;
            font-size: 19px;
            height: 120px;
            min-width: 208px;
            max-width: 180px;
            width: 290px;
            text-transform: uppercase;
            font-family: sans-serif;
        }

        .cal-wap button {
            width: 80px;
            height: 80px;
            font-size: 40px;
            margin: 5px;
            background-color: #orange;
        }

        .amount-wap button {
            width: 97px;
            height: 55px;
            font-size: 35px;
            margin: 3px;
        }

        .amount-wap {
            margin-top: 20px;
        }

        .form-control.input-sm {
            font-size: 14px;
            height: 47px;
            line-height: 16px;
            padding: 3px;
            font-size: 16px;
        }

        /*.nav-tabs li.active>a{
	margin:0 -1px -8px 0 !important;
}*/
        .nav-tabs li.active>a {
            margin: 0 -1px 0 0;
        }

        /*the container must be positioned relative:*/
        .autocomplete {
            position: relative;
            display: inline-block;
        }

        input {
            border: 1px solid transparent;
            background-color: #f1f1f1;
            padding: 10px;
            font-size: 16px;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            /*position the autocomplete items to be the same width as the container:*/
            width: 400px;
            top: 5%;
            left: 0;
            right: 0;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }

        /*when hovering an item:*/
        .autocomplete-items div:hover {
            background-color: #e9e9e9;
        }

        /*when navigating through the items using the arrow keys:*/
        .autocomplete-active {
            background-color: DodgerBlue !important;
            color: #ffffff;
        }

        .btn-group-vertical {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin: 1px 0px 1px 0px;
        }

        /*
.btn-group-vertical>.btn,
.btn-group-vertical>.btn-group,
.btn-group-vertical>.btn-group>.btn {
    display: block;
    float: none;
    width: 100%;
    max-width: 100%;
    padding: 2px 5px 5px 5px;
    font-size:20px;
}
*/
        .tab-pane.perf_scroll.ps-container.active {
            max-height: 511px;
        }

        .navbar-nav>li.active {
            margin-bottom: -10px;
        }
    </style>
</head>
<body>
    <noscript>
        <div class="global-site-notice noscript">
            <div class="notice-inner">
                <p><strong>JavaScript seems to be disabled in your browser.</strong><br>
                    You must have JavaScript enabled in
                    your browser to utilize the functionality of this website. </p>
            </div>
        </div>
    </noscript>
    <!-- start -->
    <?php $this->load->view("bar/navigation") ?>
    <div class=" panel-scroll" style="height:auto">
        <div class="tabbable tabs-top">

            <?php //$this->load->view("bar/sub_category-slider"); 
            ?>
            <div class="tab-content">
                <div id="Sales" class="tab-pane active">
                    <div class="table-responsive">
                        <!-- panel one -->
                        <?php $this->load->view("bar/biller") ?>
                        <!-- end panel one -->
                    </div>
                </div>
                <div id="dine_in" class="tab-pane">
                    <!-- content here -->
                    <?php $this->load->view("bar/dine_in") ?>
                </div>
                <div id="take_away" class="tab-pane">
                    <!-- content here -->
                    <?php $this->load->view("bar/take_away") ?>
                </div>
                <div id="delivery" class="tab-pane">
                    <!-- content here -->
                    <?php $this->load->view("bar/delivery_s") ?>
                </div>
                <div id="add_product" class="tab-pane">
                    <!-- content here -->
                    <?php $this->load->view("bar/add_product") ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade in" id="modal_login" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i></button>
                    <h4 class="modal-title" id="dsModalLabel">Enter Username and Password</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" value="" class="form-control" id="username" />
                    </div>
                    <div class="form-group">
                        <label for="password">Username</label>
                        <input type="password" name="password" value="" class="form-control" id="password" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_login" class="btn btn-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end -->

    <input type="hidden" id="fucking_done" value="0">

    <!-- end pop upbox-->
    <script type="text/javascript" src="<?php echo asset_url(); ?>plugins/jQuery-lib/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>plugins/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>plugins/jquery-validation/dist/jquery.validate.min.js"></script>
    <!--<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.js"></script> -->
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.custom.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/perfect-scrollbar.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery-ui.min.js"></script>
    <!--
<script type="text/javascript" src="<?php echo asset_url(); ?>js/ui-modals.js"></script>-->
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
    <!--<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script> -->
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.sendkeys.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/bililiteRange.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script>
    <!-- jQuery Kinetic - for touch -->
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.kinetic.min.js"></script>
    <!--<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.smoothdivscroll-1.3-min.js" ></script> -->
    <!--<script type="text/javascript" src="<?php echo asset_url(); ?>js/plugins.min.js"></script> -->
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/autoNumeric.js"></script>
    <!--<script type="text/javascript" src="<?php echo asset_url(); ?>js/dragscroll.js"></script>-->
    <script type="text/javascript">
        $('.perf_scroll,#product-list').perfectScrollbar({
            suppressScrollX: true
        });
        //$('#product-list, #category-list, #subcategory-list, #brands-list').perfectScrollbar({suppressScrollX: true});

        var jsonarray = <?php print_r($product_list) ?>;
        var base_url = '<?php echo base_url(); ?>';
        $('#modal-loading').show();
    </script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>plugins/gritter/js/jquery.gritter.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>plugins/iCheck/jquery.icheck.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/bar.ajax.3.1.js"></script>
    <script>
        function validate_qty() {
            $(":focus").each(function() {
                focused = this.id;
            });
            var for_fld = "#" + focused;
            var for_val = $(for_fld).val();
            if (for_val > 1000) {
                $(for_fld).val(1);
                displayNotice("page", " Invalid quantity :  " + for_val);
            }
        }

        /*function validate_cash() {
        	$(":focus").each(function() {
        		// alert("Focused Elem_id = "+ this.id );
        		focused = this.id;
        	});
        	// alert(focused);
        	var for_fld = "#" + focused;
        	var for_val = $(for_fld).val();
        	if (for_val > 9999) {
        		//  alert("Invalid");
        		$(for_fld).val(0);
        		displayNotice("page", " Invalid quantity :  " + for_val);
        		$('#add_item').focus();
        	}
        }*/

        function cal_amount_btn_click(val) {
            /*
            	var cash_en_val = 0;
            	var cash_en_tot = parseFloat($('#cash_en_tot').val());
            	var cash_en_val = parseFloat(val);
            	$('#cash_en').val(cash_en_val + cash_en_tot);
            	grand_total_cal();
            	$('#cash_en_tot').val(cash_en_val + cash_en_tot);
            */
        }

        function clear_amount() {
            $(":focus").each(function() {
                // alert("Focused Elem_id = "+ this.id );
                focused = this.id;
            });
            var focused_fld = "#" + focused;
            $(focused_fld).val(0);
            grand_total_cal();
            $("#qty_en_tot").val('');
        }

        function cal_btn_click(val) {
            var focused = '';
            var focused_fld = "";
            var qty_en_tot = $("#qty_en_tot").val();
            $("#qty_en_tot").val(qty_en_tot + val);
            var qty_en_tot_new = $("#qty_en_tot").val();
            var qty_old_val = '';
            set_val = qty_en_tot + val;
            // alert(qty_en_tot);
            $(":focus").each(function() {
                // alert("Focused Elem_id = "+ this.id );
                focused = this.id;
            });
            var focused_fld = "#" + focused;
            // alert(focused_fld);
            var qty_old_val = $(focused_fld).val();
            // alert(qty_old_val);
            //alert('qty_old_val:'+qty_old_val);
            if (val == '-') {
                // $(focused_fld).val(set_val);
            } else {
                // $(focused_fld).val(set_val);
            }
            $(focused_fld).val(qty_en_tot_new);
            //set blank
            grand_total_cal();
        }

        function form_submit() {
            var a = $('.cb_list input[type="radio"]:checked').val();
            $('#modal-loading').show();
            /*---- add to bill ----*/
            $('#bill_date').text('Date: ' + $('#sale_datetime').val());
            /*-- end --*/
            var fields = $("#pos-sale-form").serialize();
            /*console.log(fields);*/
            $.post("<?php echo base_url(); ?>pos/pos_submit", fields).done(function(data) {
                var obj = jQuery.parseJSON(data);
                /*console.log(obj);*/
                if (obj.error == 1) {
                    bootbox.alert(obj.disMsg);
                    window.scrollTo(500, 0);
                }
                if (obj.error == 0) {
                    $('#fucking_done').val(1);
                    $("#soTable > tbody").empty();
                    /*fbs_click_pos_no_c(obj.sale_id);*///HTML PRINT
                    /*cashier_kot(obj.sale_id, 0);*/
                    <?php
                    if($this->session->userdata('ss_user_id') != 65) /*==65*/
                    {
                    ?>
                        print_kot(obj.sale_id,1)
                        //
                            //setTimeout(check_kitchen_printables(obj.sale_id), 1000);
                    <?php
                    }else {
                    ?>
                        setTimeout(form_reset(), 1000);
                    <?php
                    }
                    ?>
                }
            });
        }

        function form_submit_for_kot(what) {
            //alert("Came to form_submit_for_kot");

            $('#cash_balance').text('');
            $('#modal-loading').show();
            /*---- add to bill ----*/
            $('#bill_date').text('Date: ' + $('#sale_datetime').val());
            /*-- end --*/
            var fields = $("#pos-sale-form").serialize();
            /*console.log(fields);*/
            $.post("<?php echo base_url(); ?>pos/pos_submit", fields).done(function(data) {
                var obj = jQuery.parseJSON(data);
                /*console.log(obj);*/
                if (obj.error == 1) {
                    $('.alert-success').hide();
                    $('.alert-danger').show();
                    $(".errortxt").text(obj.disMsg);
                    window.scrollTo(500, 0);
                }
                if (obj.error == 0) {
                    window.scrollTo(500, 0);
                    $("#soTable > tbody").empty();
                    $('#fucking_done').val(1);
                    fbs_click_kot(obj.sale_id);
                    /*cashier_kot(obj.sale_id, 0);*/
                    <?php
                    if($this->session->userdata('ss_user_id') == 65){
                          echo 'setTimeout(check_kitchen_printables(obj.sale_id), 1000);';
                    }else echo 'setTimeout(form_reset(), 1000);';
                    ?>
                }
            });
        }

        function printf() {
            $("#view_bill_modal").modal('show');
            $("#view_bill_modal").modal().on("shown.bs.modal", function() {
                console.log('attempting to print...');
                site.settings.printable = true;
                console.log('printable status :' + site.settings.printable);
                if (site.settings.printable === true) {
                    $('#modal-loading').hide();
                    window.print();
                    console.log('doc printed');
                    site.settings.printable = false;
                    console.log('print status changed to:' + site.settings.printable);
                } else console.log('not printed');
                $("#view_bill_modal").modal('hide');
            }).on("hidden.bs.modal", function() {});
        }

        function form_reset() {
            var done = $('#fucking_done').val();
            if (done == 1) {
                if (!$('#sale_id').val()) form_clear();
                else form_locate();
            }
        }

        function form_clear() {
            $('#pay_cc').val(0);
            $('#pay_cash').val(0);
            $('#cash_en_tot').val(0);
            $('#cb_1').iCheck("check");
            $('#table_id').val('').trigger('change');
            $('#pos-sale-form').trigger("reset");
            window.location.reload();
        }

        function form_locate() {
            window.location.href = '<?php echo base_url("bar"); ?>';
        }
        /*$('select#category').on('change', function() {
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
        				displayNotice("Product Info", "No Subcategory found for the select category.");
        			}
        		},
        		error: function() {
        			alert('Error occured while getting data from server.');
        		}
        	});
        });*/
        $('#save_product').on('click', (function(event) {
            /*console.log(event);	alert();*/
            if (event.target.id == "save_product") event.preventDefault();
            add_product();
        }));

        function add_product() {
            var fields = $("#add_product_form").serialize();
            var product_name = $('#product_name').val();
            if (product_name == "") {
                $('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>Complete form data</div>');
                $('#product_name').focus();
                return false;
            }
            var category = $('#category').val();
            if (category == "") {
                $('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>Complete form data</div>');
                $('#category').focus();
                return false;
            }
            var product_price = $('#product_price').val();
            if (product_price == "") {
                $('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>Complete form data</div>');
                $('#product_price').focus();
                return false;
            }
            var product_cost = $('#product_cost').val();
            if (product_cost == "") {
                $('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>Complete form data</div>');
                $('#product_cost').focus();
                return false;
            }
            var rowCount = 1;
            if (rowCount != 0) {
                $("#save_product").prop("disabled", true);
                $("#save_product").html('Please wait... <i class="fa fa-spinner fa-spin"></i>');
                $.post("<?php echo base_url(); ?>bar/save_pos_product", fields).done(function(data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.status == 1) {
                        $('div#error').html('<div class="alert alert-block alert-success fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>SUCCEED</div>');
                        window.location.reload(true);
                    } else {
                        $('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>INVALID DATA !</div>');
                    }
                });
                return false;
            } else {
                bootbox.alert('Please complete form data', function() {
                    $('#add_item').focus();
                });
            }
        }
        jQuery(document).ready(function() {
            <?php
            if ($sale_id) {
                if ($sale_details[0]['dine_type'] == 1) echo '$(\'#content\').css(\'background-color\',\'#d9534f\');';
                else if ($sale_details[0]['dine_type'] == 2) echo '$(\'#content\').css(\'background-color\',\'#5cb85c\');';
                else if ($sale_details[0]['dine_type'] == 3) echo '$(\'#content\').css(\'background-color\',\'#eea236\');';
                echo '{';
                $l = count($sale_item_list);
                $c = 1;
                foreach ($sale_item_list as $row) {
                    echo 'var jsonObj_' . $c .
                        ' = [{"id":' . rand(1000, 5000) .
                        ',"product_id":"' . $row['product_id'] .
                        '","product_code":"' . $row['product_code'] .
                        '","product_price":"' . $row['unit_price'] .
                        '","label":"' . $row['product_code'] .
                        ' | ' . $row['product_name'] .
                        '","product_name":"' . $row['product_name'] .
                        '","qty":"' . $row['quantity'] .
                        '","printed":"1"}];';
                    echo 'add_invoice_item(jsonObj_' . $c .
                        ');';
                    $c++;
                }
                echo '}';
                if ($sale_details[0]['dine_type'] == 3) {
                    echo '$(\'.hide_me\').css(\'visibility\',\'visible\');';
                    /*$('#posshipping').val();*/
                }
                if ($sale_details[0]['table_id'])
                    echo "$('#table_id').val(" . $sale_details[0]['table_id'] . ").trigger('change');";
            } else echo '$(\'#content\').css(\'background-color\',\'#5cb85c\');loadDelivery();loadDineIn();loadTakeaway();'; ?>
        });
        var table;

        function loadDelivery(table_name = '', dine_type = '') {
            table = $('#delivery_table').DataTable({
                "dom": "Bftrip",
                "bProcessing": true,
                "ajax": {
                    "url": "<?php echo base_url('bar/list_pos_sales') ?>",
                    "data": {
                        dine_type: 3
                    },
                    "complete": function() {
                        $(".select2-nosearch").select2({
                            minimumResultsForSearch: Infinity
                        });
                        $(".pos-tip").tooltip();
                    }
                },
                "bPaginate": false,
                "autoWidth": false,
                "bDestroy": true,
                "iDisplayLength": 10,
                "order": [
                    [1, "desc"]
                ]
            });
        }

        function loadTakeaway(table_name = '', dine_type = '') {
            table = $('#takeaway').DataTable({
                "dom": "Bftrip",
                "bProcessing": true,
                "ajax": {
                    "url": "<?php echo base_url('bar/list_pos_sales') ?>",
                    "data": {
                        dine_type: 2
                    },
                    "complete": function() {
                        $(".select2-nosearch").select2({
                            minimumResultsForSearch: Infinity
                        });
                        $(".pos-tip").tooltip();
                    }
                },
                "bPaginate": false,
                "autoWidth": false,
                "bDestroy": true,
                "iDisplayLength": 10,
                "order": [
                    [1, "desc"]
                ]
            });
        }
        /*end take away */
        function loadDineIn(table_name = '', dine_type = '') {
            table = $('#dine_in_table').DataTable({
                "dom": "Bftrip",
                "bProcessing": true,
                "ajax": {
                    "url": "<?php echo base_url('bar/list_pos_sales') ?>",
                    "data": {
                        dine_type: 1
                    },
                    "complete": function() {
                        $(".select2-nosearch").select2({
                            minimumResultsForSearch: Infinity
                        });
                        $(".pos-tip").tooltip();
                    }
                },
                "bPaginate": false,
                "autoWidth": false,
                "bDestroy": true,
                "iDisplayLength": 10,
                "order": [
                    [1, "desc"]
                ],
            });
        }

        function click_sales_view_btn(sale_id) {
            var $modal = $('#ajax-modal');
            $('body').modalmanager('loading');
            setTimeout(function() {
                $modal.load('<?php echo base_url("sales/sale_details?sale_id="); ?>' + sale_id, '', function() {
                    $modal.modal();
                    $(".search-select").select2({
                        placeholder: "Select a State",
                        allowClear: true
                    });
                });
            }, 1000);
        }

        function fbs_click(id) {
            u = location.href;
            t = document.title;
            window.open('<?php echo base_url() ?>bar/print_reciept?sale_id=' + id, 'sharer', 'toolbar=0,status=0,width=626,height=700, left=10, top=10,scrollbars=yes');
            return false;
        }

        function fbs_click_pos(id) {
            complete_sale(id);
            u = location.href;
            t = document.title;
            window.open('<?php echo base_url() ?>sales/sale_details_pos?sale_id=' + id, 'sharer', 'toolbar=0,status=0,width=626,height=700, left=10, top=10,scrollbars=yes');
            return false;
            /*console.log(mywindow);*/
        }

        function fbs_click_kot(id) {
            u = location.href;
            t = document.title;
            window.open('<?php echo base_url() ?>sales/sale_details_kot?sale_id=' + id, 'sharer', 'toolbar=0,status=0,width=626,height=700, left=10, top=10,scrollbars=yes');
            return false;
            /*console.log(mywindow);*/
        }

        function fbs_click_pos_no_c(id) {
            u = location.href;
            t = document.title;
            window.open('<?php echo base_url() ?>sales/sale_details_pos?sale_id=' + id, 'sharer', 'toolbar=0,status=0,width=626,height=700, left=10, top=10,scrollbars=yes');
            return false;
        }

        function edit_sale(id) {
            window.location = '<?php echo base_url() ?>bar/0/' + id;
            return false;
        }
        /*function resetfun() {
        	this.location.reload(true);
        }*/
        function complete_sale(id) {
            jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'bar/complete_sale' ?>",
                data: {
                    sale_id: id,
                },
                cache: false,
                success: function(response) {
                    displayNotice('page', 'Sale Completed !!');
                    loadDineIn();
                    loadTakeaway();
                    loadDelivery();
                }
            });
        }

        function ready_sale(id, cus_phone, amount) {
            bootbox.prompt({
                title: "This is a prompt with a set of checkbox inputs!",
                value: ['1', '3'],
                inputType: 'checkbox',
                inputOptions: [{
                        text: 'Rider Name <input type="text" id="rider_name">',
                        value: '1',
                    },
                    {
                        text: 'Rider Phone <input type="text" id="rider_phone">',
                        value: '2',
                    }
                ],
                callback: function(result) {
                    var rider_name = $('#rider_name').val();
                    var rider_phone = $('#rider_phone').val();
                    if (rider_name == "" || rider_phone == "") {
                        bootbox.alert("Rider name or phone is empty!");
                        return false;
                    } else
                        jQuery.ajax({
                            type: "POST",
                            url: "<?php echo base_url() . 'bar/ready_sale' ?>",
                            data: {
                                sale_id: id,
                                cus_phone: cus_phone,
                                rider_name: rider_name,
                                rider_phone: rider_phone,
                                amount: amount
                            },
                            cache: false,
                            success: function(response) {
                                displayNotice('page', 'Sale Completed !!');
                                loadDineIn();
                                loadTakeaway();
                                loadDelivery();
                            }
                        });
                }
            });
            /* bootbox.confirm("<form id='infos' action=''>\
                 First name:<input type='text' name='first_name' /><br/>\
                 Last name:<input type='text' name='last_name' />\
                 </form>", function(result) {
                     if(result)
                         $('#infos').submit();
             });*/
            /*
            bootbox.prompt({
                title: "Please enter OTP", 
                centerVertical: true,
                callback: function(result){ 
                    if(result !== null){
                        if(result == obj.otp){
                            send_rq(id);
                        }else
                            bootbox.alert("Invalid OTP!");
                    }
                }
            });
            */
            /*	*/
        }

        function ready_takeaway(sale_id, cus_phone, amount) {
            bootbox.confirm("Are you sure?", function(result) {
                if (result == true) {
                    jQuery.ajax({
                        type: "POST",
                        url: "<?php echo base_url() . 'bar/ready_takeaway' ?>",
                        data: {
                            sale_id: sale_id,
                            cus_phone: cus_phone,
                            amount: amount
                        },
                        cache: false,
                        success: function(response) {
                            displayNotice('page', 'Sale is ready !!');
                            loadDineIn();
                            loadTakeaway();
                            loadDelivery();
                        }
                    });
                }
            });
        }

        function cancel_sale(id) {
            jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'bar/get_otp' ?>",
                data: {
                    sale_id: id,
                },
                cache: false,
                success: function(response) {
                    var obj = jQuery.parseJSON(response);
                    if (obj.error == 109) {
                        bootbox.alert("Insufficient balance!");
                    } else if (obj.error > 0) {
                        bootbox.alert("Error!");
                    } else {
                        bootbox.prompt({
                            title: "Please enter OTP",
                            centerVertical: true,
                            callback: function(result) {
                                if (result !== null) {
                                    if (result == obj.otp) {
                                        send_rq(id);
                                    } else
                                        bootbox.alert("Invalid OTP!");
                                }
                            }
                        });
                    }
                }
            });
        }

        function cancel_sale_by_login(id) {
            site.data.cancel_id = id;
            $("#modal_login").modal("show");
        }
        $(document).on("click", "#btn_login", function() {
            $.ajax({
                dataType: "JSON",
                type: "POST",
                url: "<?php echo base_url() . 'pos/check_user' ?>",
                data: {
                    username: $('#username').val(),
                    password: $('#password').val()
                },
                cache: false,
                success: function(data) {
                    if (data.success) {
                        $("#modal_login").modal("hide");
                        send_rq(site.data.cancel_id);
                    } else {
                        bootbox.alert(data.validation);
                    }
                }
            });
        });

        function send_rq(id) {
            jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'bar/cancel_sale' ?>",
                data: {
                    sale_id: id,
                },
                cache: false,
                success: function(response) {
                    console.log("cancel sale response \n");
                    console.log(response);
                    displayNotice('page', 'Sale Cancelled !!');
                    loadDineIn();
                    loadTakeaway();
                    loadDelivery();
                }
            });
        }

        function set_as_paid(sid) {
            var sale_pymnt_date_time = $('#sale_datetime').val();
            var paid_by = $('#paying_by_' + sid).val();
            var given_amount = $('#c_pay_amount_' + sid).val();
            jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'bar/set_as_paid' ?>",
                data: {
                    sale_id: sid,
                    paid_by: paid_by,
                    sale_pymnt_date_time: sale_pymnt_date_time,
                    given_amount: given_amount
                },
                cache: false,
                success: function(response) {
                    displayNotice('page', 'Payment Succeed!!');
                    loadDineIn();
                    loadTakeaway();
                    loadDelivery();
                }
            });

        }

        function delete_invoice(sid) {
            var group_id = $('#group_id').val();
            /*var confm =	window.confirm("Delete This Invoice ?");*/
            if (group_id != 3) {
                bootbox.confirm('Delete Invoice ' + sid + '?', function(e) {
                    if (e) {
                        jQuery.ajax({
                            type: "POST",
                            url: "<?php echo base_url() . 'sales/sales_delete?sale_id=' ?>" + sid,
                            cache: false,
                            success: function(response) {
                                displayNotice('page', 'Successfully Deleted!!');
                            }
                        });
                    }
                });
            }
        }

        function delete_payments(sid) {
            var group_id = $('#group_id').val();
            /*var confm =	window.confirm("Delete Payments ?");*/
            if (group_id != 3) {
                bootbox.confirm('Delete Invoice Payments of Invoice ID: ' + sid + '?', function(e) {
                    if (e) {
                        jQuery.ajax({
                            type: "POST",
                            url: "<?php echo base_url() . 'sales/sale_pymnts_delete?sale_id=' ?>" + sid + "&in_type=sale",
                            cache: false,
                            success: function(response) {
                                displayNotice('page', 'Successfully Deleted!!');
                                loadDelivery();
                                loadDineIn();
                                loadTakeaway();
                            }
                        });
                    }
                });
            }
        }

        function autocomplete(inp, arr) {
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            var currentFocus;
            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;
                /*close any already open lists of autocompleted values*/
                closeAllLists();
                if (!val) {
                    return false;
                }
                currentFocus = -1;
                /*create a DIV element that will contain the items (values):*/
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                /*append the DIV element as a child of the autocomplete container:*/
                this.parentNode.appendChild(a);
                /*for each item in the array...*/
                for (i = 0; i < arr.length; i++) {
                    /*check if the item starts with the same letters as the text field value:*/
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        /*create a DIV element for each matching element:*/
                        b = document.createElement("DIV");
                        /*make the matching letters bold:*/
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        /*insert a input field that will hold the current array item's value:*/
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        /*execute a function when someone clicks on the item value (DIV element):*/
                        b.addEventListener("click", function(e) {
                            /*insert the value for the autocomplete text field:*/
                            inp.value = this.getElementsByTagName("input")[0].value;
                            /*close the list of autocompleted values,
                            (or any other open lists of autocompleted values:*/
                            closeAllLists();
                            get_cus_name(inp.value);
                        });
                        a.appendChild(b);
                    }
                }
            });
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        if (x) x[currentFocus].click();
                    }
                }
            });

            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }

            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }

            function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function(e) {
                closeAllLists(e.target);
            });
        }

        <?php
        //print_r($customers);
        $str = "var customers =[";
        foreach ($customers as $cus) {
            if ($cus['cus_phone'] != 0 && $cus['cus_phone'] != "") {
                $str .= '"' . $cus['cus_phone'] . '",';
            }
        }
        $str .= '""]';
        echo $str;
        ?>

        //var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];
        autocomplete(document.getElementById("cus_phone"), customers);
        /*$("#poscustomer").select2({
            allowClear: true,
            ajax: {
                url: "<?php echo base_url('customers/search_customer_by_phone') ?>",
                dataType: 'json',
                delay: 250,
                data: function(query) {
                    if (!query) query = '';
                    return {
                        search_string: query,
                        format: 'json'
                    };
                },
                results: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.cus_phone,
                                slug: item.cus_id,
                                id: item.cus_id
                            };
                        })
                    };
                },
                cache: true
            }
        });*/
        function get_cus_name(cus_phone) {
            jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'customers/get_customer_info_by_phone' ?>",
                data: {
                    cus_phone: cus_phone,
                },
                cache: false,
                success: function(response) {
                    console.log(response);
                    var obj = jQuery.parseJSON(response);
                    $('#cus_name').val(obj.cus_name);
                }
            });
        }
        $('#keyboard_panel > .btn-group-vertical.key >.btn-group>.btn').on('mousedown',
            function(event) {
                event.preventDefault();
                var ti = event.target;
                var key_value = $(ti).data("key");
                var key_value = key_value + "";
                var focused = '';
                $(":focus").each(function() {
                    focused = this.id;
                });
                if (key_value == "Enter") {
                    if ($('#' + focused).hasClass("rquantity")) {
                        $('#add_item').focus();
                    } else
                    if (focused == "add_item") {
                        $('#save').click();
                    }
                } else {
                    var e = jQuery.Event("keydown");
                    e.key = key_value;
                    $('#' + focused).trigger(e);
                }
            }
            //grand_total_cal();
        );
        $('#keyboard_panel > .btn-group-vertical.money >.btn-group>.btn').on('mousedown',
            function(event) {
                event.preventDefault();

                var focused = '';
                $(":focus").each(function() {
                    focused = this.id;
                });

                if (focused != "pay_cash" && focused != "pay_cc") {
                    focused = "pay_cash";
                    $('#' + focused).focus();
                }

                var ti = event.target;
                var key_value = parseInt($(ti).data("money"));
                var current_val = parseInt($('#' + focused).val());
                if (isNaN(current_val)) current_val = 0;

                var new_val = current_val + key_value;
                $('#' + focused).val(new_val);
                var e = jQuery.Event("keydown");
                //e.key = key_value;
                e.which = 13;
                $('#' + focused).trigger(e);
                
                if(focused == "pay_cash" || focused == "pay_cc")
                    grand_total_cal();
            }
        );
        $('#add_note').on('click', function(e) {
            e.preventDefault();
            bootbox.prompt("Kitchen Note", function(result) {
                $('#kitchen_note').val(result);
            });
        });

        function check_kitchen_printables(id) {
            $.ajax({
                url: "<?php echo base_url() ?>pos/check_kitchen_orders",
                dataType: "JSON",
                method: "POST",
                data: {
                    "sale_id": id
                },
                beforeSend: function() {
                    console.count("K.O.T");
                },
                success: function(data) {
                    if (data.success) {
                        console.count("K.O.T FOUND");
                        console.log(data);
                        //alert("sale_id:"+data.sale_id);
                        var sale_id = data.sale_id;
                        print_off_kot(sale_id);
                    } else {
                        console.count("K.O.T NOT FOUND");
                    }
                    setTimeout(form_reset(), 1000);
                },
                error: function(data) {
                    $('#console').text(data.responseText);
                    console.log(data);
                }
            });
        }

        function print_kot(id,form_rest){
            $.ajax({
                url: "<?php echo base_url() ?>auto_print/get_kot_url",
                dataType: "JSON",
                method: "POST",
                data: {
                    "sale_id": id,
                    "printer_name" : "Microsoft Print to PDF"
                },
                beforeSend: function() {
                    console.count("K.O.T");
                },
                success: function(data) {
                    console.log(data);
                    if (data.success) {
                        window.open(data.url);
                        //window.location.href = data.url;
                        if(form_rest)
                            setTimeout(form_reset(), 1000);
                    } else {
                        if(form_rest)
                            setTimeout(form_reset(), 1000);
                    }
                },
                error: function(data) {
                    console.log("error");
                    console.log(data.responseText);
                }
            });
        }

        function print_off_kot(sale_id) {
            <?php
            $key = "DQ2V2KR0G-d7a18a2de2ded8c1f33dbe6b1a83f5f115b04249e9d63b274cf8ffe11f6f4ded";
            $protocol = "http://";
            $domain = "isurugm.newviableerp.com/";
            $path = "pos/ap_kot_kitchen_json?sale_id="; //
            $dataType = "application/json";
            $printerName = "XP-80C-2"; //change here to "POS-80"
            $print_href_open = 'skyprint:?key=' . $key . '&protocol=' . $protocol . '&domain=' . $domain . '&path=' . $path;
            $print_href_close = '&dataType=' . $dataType . '&printerName=' . $printerName . '&print_id=ktchn_kot&num_copy=1';
            ?>
            window.location.href = "<?php echo $print_href_open; ?>" + sale_id + "<?php echo $print_href_close; ?>";
        }

        function print_off_bot(sale_id) {
            <?php
            $key = "DQ2V2KR0G-d7a18a2de2ded8c1f33dbe6b1a83f5f115b04249e9d63b274cf8ffe11f6f4ded";
            $protocol = "http://";
            $domain = "isurugm.newviableerp.com/";
            $path = "pos/ap_kot_json?sale_id="; //
            $dataType = "application/json";
            $printerName = "XP-80C-2"; //change here to "POS-80 - kitchen"
            $print_href_open = 'skyprint:?key=' . $key . '&protocol=' . $protocol . '&domain=' . $domain . '&path=' . $path;
            $print_href_close = '&dataType=' . $dataType . '&printerName=' . $printerName . '&print_id=ktchn_kot&num_copy=1';
            ?>
            window.location.href = "<?php echo $print_href_open; ?>" + sale_id + "<?php echo $print_href_close; ?>";
        }

<?php
    if($this->session->userdata('ss_user_id') != 65){
        echo '
        setInterval(function() {
            print_kot("","");
        }, 20000);';
    }
?>
        


        function cashier_invoice(id) {
            <?php

            $key = "DQ2V2KR0G-d7a18a2de2ded8c1f33dbe6b1a83f5f115b04249e9d63b274cf8ffe11f6f4ded";
            $protocol = "http://";
            $domain = "isurugm.newviableerp.com/";
            $path = "vs/sales/sale_details_pos?sale_id="; //
            $dataType = "text/html";
            $printerName = "Default";
            $print_href_open = 'skyprint:?key=' . $key . '&protocol=' . $protocol . '&domain=' . $domain . '&path=' . $path;
            $print_href_close = '&dataType=' . $dataType . '&printerName=' . $printerName . '&print_id=cashier_invoice';

            ?>
            window.location.href = "<?php echo $print_href_open; ?>" + id + "<?php echo $print_href_close; ?>";
        }

        function cashier_kot(id, ckot) {
            <?php

            $key = "DQ2V2KR0G-d7a18a2de2ded8c1f33dbe6b1a83f5f115b04249e9d63b274cf8ffe11f6f4ded";
            $protocol = "http://";
            $domain = "isurugm.newviableerp.com/";
            $path = "vs/sales/sale_details_kot?sale_id="; //
            $dataType = "text/html";
            $printerName = "Microsoft Print To PDF";
            $print_href_open = 'skyprint:?key=' . $key . '&protocol=' . $protocol . '&domain=' . $domain . '&path=' . $path;
            $print_href_close = '&dataType=' . $dataType . '&printerName=' . $printerName . '&print_id=cashier_kot';

            ?>
            window.location.href = "<?php echo $print_href_open; ?>" + id + "<?php echo $print_href_close; ?>";
            
            setTimeout(check_kitchen_printables(id), 1000);
        }
        
        console.log("%cSTOP! Developers only.", "font-size: 40px; color:red");
    </script>
</body>

</html>