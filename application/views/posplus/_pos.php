<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>POS Module | Stock Manager Advance</title>
    <script src="<?php echo asset_url(); ?>js/moment.min.js"></script>
    <link rel="stylesheet" href="<?php echo asset_url(); ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo asset_url(); ?>css/style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo asset_url(); ?>css/posplus.1.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo asset_url(); ?>css/jquery-ui.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
    <link rel="stylesheet" href="<?php echo asset_url(); ?>css/print_pos.css" type="text/css" media="print" />
    <script type="text/javascript" src="<?php echo asset_url(); ?>plugins/jQuery-lib/2.0.3/jquery.min.js"></script>
    <script defer type="text/javascript" src="<?php echo asset_url(); ?>plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>plugins/bootstrap/js/bootstrap.min.js"></script>
    <script defer type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.custom.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery-ui.min.js"></script>
    <script defer type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.sendkeys.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/bililiteRange.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>
    <style>
        #bill_content {
            padding-left: 0px;
            padding-right: 0px;
        }
        .contbtn{
            cursor:pointer;font-size: 14px;margin:5px 0px 1px 0px;height: 50px;display: flex;justify-content: center;align-items: center;
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
            font-family: Ubuntu, system-ui, sans-serif;
        }
        .hide_me {
            visibility: hidden
        }
        .btn-round-xs {
            border-radius: 11px;
            padding-left: 10px;
            padding-right: 10px
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
        #cpinner {
            width: 100%;
            background-color: rgb(244, 244, 244);
            /* margin-left: 10px; */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 631px;
            padding-left: 10px;
            flex: 1;
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
        #item-list {
            width: 100%;
            height: 100%;
            overflow-y: scroll;
            box-sizing: content-box;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            align-content: flex-start;
        }
        }
        /*.home-fer_btn {
            font-weight: bold;
            font-size: 19px;
            height: 120px;
            min-width: 208px;
            max-width: 180px;
            width: 290px;
            text-transform: uppercase;
            font-family: sans-serif;
        }*/
        /*.cal-wap button {
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
        }*/
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
            position: relative;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
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
    font-size:1.1vw;
}
*/
        .navbar-nav>li.active {
            margin-bottom: -10px;
        }
        /*below active*/
        .item_btn_1 {
            font-weight: bold;
            font-size: 14px;
            height: 80px;
            min-width: 160px;
            max-width: 180px;
            position: relative;
            margin: 0px;
            width: 25%;
            background: black;
            color: white;
            cursor: pointer;
            padding: 1px;
            margin-bottom: 2px;
            margin-left: 2px;
        }
        .item_btn_1:hover {
            background: black;
            color: white;
        }
        .label-item {
            background-color: rgba(255, 255, 255, 0.95);
            /* text-align:justify;  */
            font-size: 16px;
            max-height: 67px;
            position: absolute;
            right: 0;
            width: 100%;
        }
        #item-list>div>div>div.tab-pane.active {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
        }
        .label-item {
            background-color: rgba(255, 255, 255, 0.95);
            /* text-align: justify; */
            font-size: 17px;
            max-height: 77px;
            position: absolute;
            right: 0;
            width: 100%;
            top: 2px;
        }
        .modal.fade.in:visible {
            display: flex;
            align-items: center;
        }
        /*
        $('.modal.fade.in:visible').css({
            'display': 'flex',
            'align-items': 'center'
        });
        */
        #cat_label_containet>ul,
        #cat_label_containet>ul>li {
            list-style: none;
        }
        #cat_label_containet>ul>li>a {
            position: relative;
            display: block;
            padding: 10px 15px;
            background: rgba(255, 255, 255, 0.1);
            font-size: 14px;
        }
        #cat_label_containet>ul>li>a:hover {
            text-decoration: none;
        }
        #cat_label_containet>ul>li {
            box-shadow: 2px 3px 2px 0px;
        }
        #cat_label_containet>ul>li.active {
            background: #ffee008f;
            box-shadow: inset 0 3px 5px rgb(0 0 0 / 71%);
        }
        #cat_label_containet>ul>li.active>a {
            text-decoration: none;
        }
        .price-square {
            width: 100%;
            height: 60px;
            margin: 5px;
            background-color: #db3434f7;
            color: #fff;
            text-align: center;
            line-height: 50px;
            cursor: pointer;
            font-size: 2.5vw;
            font-family: math;
        }
        .price-square:hover {
            background-color: #2980b9;
            /* Change the hover color as needed */
        }
        .table-square {
            width: 6rem;
            background-color: #db3434f7;
            color: #fff;
            text-align: center;
            line-height: 55px;
            cursor: pointer;
            font-size: 3rem;
            font-family: math;
            margin-right: 1rem;
            margin-bottom: 1rem;
        }
        .table-square:hover {
            background-color: #2980b9;
            /* Change the hover color as needed */
        }
        #content {
            padding: 10px !important;
        }
        .bill_styles {
            page-break-after: auto;
            padding-left: 0px;
            padding-right: 0px;
        }
        /*connecting*/
        .connecting {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% {
                background-color: #ff9999;
                /* Initial color */
                /*transform: scale(1);*/
            }
            50% {
                background-color: #ff6666;
                /* Intermediate color */
                /*transform: scale(1.1);*/
            }
            100% {
                background-color: #ff9999;
                /* Back to initial color */
                /*transform: scale(1);*/
            }
        }
        .btn.active,
        .btn:active {
            box-shadow: inset 0 3px 5px rgb(0 0 0);
        }
        
        #posTable > thead > tr{
            position:sticky;
            top:0px;
        }

        .ui-autocomplete{
            z-index : 9999;
        }
        
        #cus_phoneautocomplete-list{
            position: absolute;
            top: 35px;
        } 
        
        #left_side > tr{
            cursor:pointer;
        }
        
        tr.selected{
          /*-webkit-box-shadow: 0px 0px 14px 5px rgba(150,138,150,1);
            -moz-box-shadow: 0px 0px 14px 5px rgba(150,138,150,1);
            box-shadow: 0px 0px 14px 5px rgba(150,138,150,1);*/
            /*border: solid 4px #299bff;*/
            background: #35ff00;
        }
        .bootbox.modal.fade.bootbox-alert.in{
            display: flex !important;
            align-items: center;
        }
        /*#left_side > table > tbody > tr > td:nth-child(1),*/
        
        #left_side > table > tbody > tr:hover {
            border: solid 4px #299bff;
        }
        
        #left_side > table > tbody > tr > td{
            cursor:pointer;
        }
        
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
          -webkit-appearance: none;
          margin: 0;
        }
        
        /* Firefox */
        input[type=number] {
          -moz-appearance: textfield;
        }
        
        .btn-num{
            margin-right: 0.5rem;
            font-size: 2.6vw;
            width: 100%;
            height: 100%;
            line-height: 1.3333333;
        }
        .btn-money{
            width: 10vw;
            font-size: 2rem;
        }
        .table_row{
            display:flex;
            width:100%;
            justify-content: space-between;
        }
    
    #wrapper{
        padding:10px;
        height: 100%;
    }
    @media only screen and (min-width: 992px) and (max-width: 1199px) {
        #wrapper{
            padding:5px; 
            height: 100%;
        }
    }
    
    #leftdiv{
        <?php if($settings['wide_left']){?>
        /*min-width: 520px;*/
        <?php } ?>
        
        flex:0.65;
    }
    </style>
</head>
<body onload="set_window()" onbeforeunload="return reset_window()">
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
    <?php $this->load->view("posplus/navigation") ?>
    <div id="main_panel" class="no-print">
        <div class="tabbable tabs-top asa" style="height:100%">
            <?php //$this->load->view("bar/sub_category-slider"); 
            ?>
            <div class="tab-content" style="height: 100%;">
                <div id="Sales" class="tab-pane active" style="height:100%">
                    <div id="wrapper">
                        <div id="loader" style="padding:15%; text-align:center; display:none"> <i class="fa fa-cog fa-spin fa-4x"></i> </div>
                        <div id="pos" style="height:100%" class="no-print">
                                <div id="leftdiv" class="ui-widget quick-menu">
                                    <form action="#" data-toggle="validator" role="form" id="pos_form" name="pos_form" method="post" accept-charset="utf-8" style="display: flex;flex-direction: column;justify-content: space-between;">
                                        <input type="hidden" name="kitchen_note" id="kitchen_note" value="" />
                                        <div id="left-top" class="quick-menu">
                                            <div class="no-print">
                                                <div style="display:none" id="input_panel" class="form-group">
                                                    <select name="poswarehouse" id="poswarehouse" class="search-select" data-placeholder="Select Warehouse">
                                                        <option value="">-select-</option>
                                                        <?php foreach ($get_warehouse as $value) { ?>
                                                            <option value="<?php echo $value->id; ?>" <?php if ($this->session->userdata('ss_warehouse_id') == $value->id) echo 'selected' ?>><?php echo $value->name; ?> | <?php echo $value->code; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <!--<div class="form-group"></div>-->
                                                <!-- ISSUE METHODS-->
                                                <div class="form-group" style="background-color:#FFF;">
                                                    <div class="btn-group btn-group-lg" style="width:100%;display: flex;justify-content: space-between;">
                                                        <?php if($ftr['ism']['din']['on']){ ?>
                                                            <a id="dinein" style="width:100%" class="btn btn btn-success price_type" href="javascript:;">
                                                                <span><i class="fa fa-spoon"></i><i class="fa fa-circle-o"></i> Dine In</span>
                                                                <input id="cb_1" name="delivery_status" type="radio" style="display:none" value="1" />
                                                            </a>
                                                        <?php } ?>
                                                        <?php if($ftr['ism']['tkw']['on']){ ?>
                                                            <a id="take-away" style="width:100%" class="btn btn-info price_type active" href="javascript:;">
                                                                <span><i class="fa fa-money"></i> Take Away</span>
                                                                <input id="cb_2" name="delivery_status" checked="checked" type="radio" style="display:none" value="2" />
                                                            </a>
                                                        <?php } ?>
                                                        <?php if($ftr['ism']['dlv']['on']){ ?>
                                                            <a id="deliver" style="width:100%" class="btn btn-warning price_type" href="javascript:;">
                                                                <span><i class="fa fa-truck"></i> Delivery</span>
                                                                <input id="cb_3" name="delivery_status" type="radio" style="display:none" value="3" />
                                                            </a>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="form-group" style="background-color:#FFF;">
                                                        <div class="input-group" style="width:100%;">
                                                            <!--TABLE NUMBERS-->
                                                            <?php if($ftr['slt_tbl']){ ?>
                                                                <select style="margin-top:1px; display:none" id="table_id" name="table_id" class="search-select" data-placeholder="Select table">
                                                                    <option value="">SELECT TABLE</option>
                                                                </select>
                                                            <?php } ?>
                                                            <!--WAITERS-->
                                                            <?php if($ftr['slt_tbl']){ ?>
                                                                <select style="margin-top:1px; display:none" id="waiter_id" name="waiter_id" data-placeholder="SELECT WAITER">
                                                                    <option value="" selected>SELECT WAITER </option>
                                                                    <?php foreach ($get_waiter as $wit) { ?>
                                                                        <option value="<?php echo $wit->user_id ?>"><?php echo $wit->user_first_name ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            <?php } ?>
                                                            <?php if($ftr['cus_reg']){ ?>
                                                            <?php } ?>
                                                            <div class="form-group">
                                                                <input placeholder="Customer phone" class="form-control" type="<?php echo $ftr['cus_reg'] ? "text": "hidden"; ?>" inputmode="numeric" id="cus_phone" name="cus_phone" value="" onkeyup="focusOnEnter(event, 'cus_name'),focusOnEnterUP(event)"  autocomplete="off">
                                                                <input placeholder="Customer name" class="form-control" type="<?php echo $ftr['cus_reg'] ? "text": "hidden"; ?>" id="cus_name" name="cus_name" value="" onkeyup="focusOnEnter(event, 'add_item')"  autocomplete="off"/>
                                                            </div>
                                                            <?php ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group" id="ui">
                                                    <div class="input-group">
                                                        <input type="text" name="add_item" value="" class="form-control pos-tip" id="add_item" autocomplete="off" data-placement="top" data-trigger="focus" style="background-color:#FFF"/>
                                                        <!--title="Please start typing code/name for suggestions"-->
                                                        <div class="input-group-addon" style="padding: 2px 8px; border-left: 0;"><i class="fa fa-search" style="font-size: 1em;"></i> </div>
                                                    </div>
                                                    <div style="clear:both;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="left-middle" style="height:100%">
                                            <div id="product-list" class="ps-container ps-active-y" style="overflow-y: scroll;">
                                                <table style="margin-bottom: 0;" id="posTable" class="table items table-striped table-bordered table-condensed table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:40%">Product</th>
                                                            <th style="width:15%">Price</th>
                                                            <th style="width:10%">Qty</th>
                                                            <th style="width:20%">Subtotal</th>
                                                            <th style="width: 10%; text-align: center;"><i style="opacity:0.5; filter:alpha(opacity=50);" class="fa fa-trash-o"></i></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                                <div style="clear:both;"></div>
                                                <div class="ps-scrollbar-x-rail" style="width: 436px; display: none; left: 0px; bottom: 3px;">
                                                    <div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div>
                                                </div>
                                                <div class="ps-scrollbar-y-rail" style="top: 0px; height: 319px; display: none; right: 3px;">
                                                    <div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="clear:both;"></div>
                                        <div id="left-bottom">
                                            <table style="width:100%; float:right; padding:5px; color:#000; background: #FFF;">
                                                <tbody>
                                                    <tr>
                                                        <td style="padding: 5px 10px;border-top: 1px solid #DDD; font-size:1.1vw;">Items</td>
                                                        <td style="padding: 5px 10px;font-size: 14px; font-weight:bold; border-top: 1px solid #DDD;" class="text-right"><span id="titems">0</span></td>
                                                        <td style="padding: 5px 10px;border-top: 1px solid #DDD; font-size:1.1vw">Total</td>
                                                        <td style="padding: 5px 10px;font-size: 14px; font-weight:bold; border-top: 1px solid #DDD;font-size:1.1vw" class="text-right"><span id="sub_total">0.00</span></td>
                                                    </tr>
                                                    
                                                    
                                                    
                                                </tbody>
                                            </table>
                                            <div style="width:100%;display:flex;justify-content: space-around; padding: 5px 10px;">
                                                <?php if($ftr['dsc_bll']){?>
                                                <div style="font-size:20px">
                                                        <a id="ppdiscount" class="btn btn-default" href="#" style="width: 100%;display: flex;justify-content: space-between;"> Discount: <span id="discount_amount"></span> </a>
                                                        <a href="#" class="btn btn-default" id="add_note" style="width: 100%;margin-top: 5px;"> Notes <i class="fa fa-edit"></i></a>
                                                </div>
                                                <?php }?>
                                                
                                                <?php if($ftr['bll_nte']){?>
                                                    <label for="is_seperate" style="padding: 5px 10px;font-size: 14px;font-weight:bold;display: flex;align-items: center;" class="text-right btn btn-default">
                                                        <span id="tds" class="collapse">0.00</span>
                                                        <input type="checkbox" name="is_print" value="1" id="is_print" style="height:25px; width:25px;" checked="" class="collapse">
                                                        
                                                        <span>Separate</span>
                                                        <input type="checkbox" name="is_seperate" value="1" id="is_seperate" style="height:25px; width:25px;">
                                                    </label>
                                                <?php }?>
                                                
                                                <label for="call_order" style="padding: 5px 10px;font-size: 14px;font-weight:bold;display: flex;align-items: center;" class="text-right btn btn-default">
                                                    Call Order
                                                    <input type="checkbox" name="call_order" value="1" id="call_order" style="height:25px; width:25px;">
                                                </label>
                                                
                                                <div style="padding: 5px 10px;">
                                                    <span class="hide_me">
                                                        <a id="pshipping" class="btn btn-default" href="#" style="width: 100%;display: flex;justify-content: space-between;"> Delivery : <span id="delivery_amount"></span> </a> 
                                                    </span>
                                                </div>
                                            </div>
                                            <div style="width:100%;display:flex;border: solid;background: #dbdbdb;">
                                                <div style="flex: 1;"> <span style="color:#787878">Total : </span> <span class="" id="gtotal">0.00</span></div>
                                                <div style="flex: 1;"> <span style="color:#787878">Balance : </span><span id="cash_balance">0.00</span></div>
                                            </div>
                                            <?php if($settings['mlt_pmt']){ ?>
                                                
                                            <?php }else{ ?>
                                            <div style="width:100%;display:flex;justify-content: space-between;">
                                                <div class="payments" style="padding: 5px 10px;border-top: 1px solid #666;font-weight:bold;background:#333;color:#FFF;width: 100%; <?php echo $ftr['pmt_csh'] ? "": "visibility:hidden"; ?>">
                                                    CASH :
                                                    <input type="hidden" name="payment[0][type]" value="cash" class="payment-type">
                                                    <input type="text" name="payment[0][amount]" value="0.00" class="payment-amount form-control" id="pay_cash" style="background-color:#FFF; height: 60px; font-size: 2.5em; width: 208px; text-align: right;" onkeyup="grand_total_cal()" onkeypress="focusOnEnter(event, '<?php echo $ftr['pmt_vsa'] ? "pay_cc": "save"; ?>');return isDecimal(event)" onClick="this.select()" placeholder="CASH"  autocomplete="off">
                                                </div>
                                                <div class="payments" style="padding: 5px 10px;border-top: 1px solid #666;font-weight:bold;background:#333;color:#FFF;width: 100%; <?php echo $ftr['pmt_vsa'] ? "": "visibility:hidden"; ?>">
                                                    VISA :
                                                    <input type="hidden" name="payment[1][type]" value="visa" class="payment-type">
                                                    <input type="text" name="payment[1][amount]" value="0.00" class="payment-amount form-control" id="pay_cc" style="background-color:#FFF; height: 60px; font-size: 2.5em; width: 208px; text-align: right;" onkeyup="grand_total_cal()" onkeypress="focusOnEnter(event, 'save');return isDecimal(event)" onClick="this.select()" placeholder="VISA"  autocomplete="off">
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <input type="hidden" value="3" id="biller" name="biller">
                                            <div class="clearfix"></div>
                                            <div id="botbuttons" class="col-xs-12 text-center">
                                                <div class="row">
                                                    <div class="col-xs-12" style="padding: 0;">
                                                        <div class="col-xs-6 <?php echo $settings['mlt_pmt'] ? "collapse" : ""; ?>" style="padding: 0;">
                                                            <button type="button" class="btn btn-danger btn-block btn-flat cancel" id="reset" tabindex="-1" style="height:80px;"> Cancel </button>
                                                        </div>
                                                        
                                                        <div class="col-xs-6" style="padding: 0;">
                                                            <button type="button" class="btn btn-primary btn-block" id="save" style="height:80px;font-size: 2rem;" tabindex="-1"><?php echo $settings['mlt_pmt'] ? '<i class="fa fa-plus-circle" style="margin-right: 5px;"></i> ADD ORDER' : '<i class="fa fa-check-circle" style="margin-right: 5px;"></i> ADD ORDER'; ?></button>
                                                        </div>
                                                        
                                                        
                                                        <?php if($settings['mlt_pmt']){ ?>
                                                        <div class="col-xs-6" style="padding: 0;">
                                                            <button type="button" class="btn btn-success btn-block btn-flat" id="payment" tabindex="-1" style="height:80px;font-size: 2rem;"> <i class="fa fa-money"></i> PAY </button>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <span id="hidesuspend"></span>
                                            <input type="hidden" name="sale_id" id="sale_id" value="">
                                            <input type="hidden" name="posshipping" id="posshipping" value="0">
                                            <input type="hidden" name="shipping_address" id="shipping_address" value="">
                                            <!--keyboard input-->
                                            <input type="hidden" id="id-name" value="" />
                                            <!--end keyboard input-->
                                            <input type="hidden" name="sale_datetime" id="sale_datetime" value="0">
                                            <input type="hidden" name="discount" id="discount" value="0">
                                            <input type="hidden" name="pos_discount_input" id="pos_discount_input" value="0">
                                            <input type="hidden" name="pay_amount" id="pay_amount" value="" />
                                            <input type="hidden" name="balance_amount" id="balance_amount_1" value="" />
                                            <input type="hidden" name="grand_total" id="grand_total" value="">
                                            <input type="hidden" name="paid_by" id="paid_by_val_1" value="cash" />
                                            <input type="hidden" name="cc_name" id="cc_name" value="" />
                                            <input type="hidden" name="cc_no" id="cc_no" value="" />
                                            <input type="hidden" name="pcc_holder" id="pcc_holder" value="" />
                                            <input type="hidden" name="pcc_type" id="pcc_type" value="visa" />
                                            <input type="hidden" name="payment_note" id="pos_note" value="" />
                                            <input type="hidden" name="extra_charges" id="extra_charges" value="" />
                                            <input type="hidden" name="extra_charges_amount" id="extra_charges_amount" value="" />
                                            <input type="hidden" name="continued" id="continued" value="0" />
                                            <input name="uniq_id" type="hidden" id="uniq_id" value="">
                                            
                                            <input name="kot_id" type="hidden" id="kot_id" value="">
                                            <input name="kot_ref_no" type="hidden" id="kot_ref_no" value="">
                                            <input name="kot_item_count" type="hidden" id="kot_item_count" value="0">
                                            
                                            <input name="ns" type="hidden" id="ns" value="on">
                                            
                                            <input name="cus_id" type="hidden" id="cus_id" value="">
                                            <input name="cus_type" type="hidden" id="cus_type" value="1">
                                            <div id="hidden_payments" style="display: none;"></div>
                                        </div>
                                    </form>
                                </div>
                            <?php /*?><div id="bill_tbl"><span id="bill_span"></span>
          <table id="bill-table" width="100%" class="prT table table-striped" style="margin-bottom:0;">
          </table>
          <table id="bill-total-table" class="prT table" style="margin-bottom:0;" width="100%">
          </table>
          <span id="bill_footer"></span> </div><?php */ ?>
                            <div id="cpinner" class="no-print">
                                <?php if($settings['mlt_pmt']){ ?>
                                    <!--multiple payments-->
                                    <div id="multiple_payments" class="well col-md-12" style="display:none;height:100%">
                                        <div style="width:40vw">
                                            <table id="payment_list" class="table" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <td>Payment type</td>
                                                        <td>Payment Amount</td>
                                                        <td>Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Payment rows will be added here -->
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td class="text=-right">Total</td>
                                                        <td><span id="total_paid_amount">0.00</span></td>
                                                        <td>
                                                            <button type="button" id="add_new_payment" class="btn btn-lg btn-default" style="border-radius:8px"><i class="fa fa-plus-circle fa-2x pull-right" style="margin: 0;"></i></button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            
                                        </div>
                                    </div>
                                    
                                <?php }else{ ?>
                                
                                <?php } ?>    
                                    
                                <!-- Tab Start -->
                                <div id="cat_label_containet" style="border-bottom: solid 4px #428bca;" class="no-print">
                                    <ul id="cat_tabs" style="padding:0px;overflow: auto;display: flex;flex-wrap: wrap;">
                                        <li <?php echo 'class=active' ?>> <a data-toggle="tab" href="#cat_<?php echo 1000; ?>" style="background:rgba(255, 255, 255, 0.1); font-size:1.1vw; display:none">Featured </a>
                                            <?php foreach ($category as $key => $cat) { ?>
                                        <li style="" <?php if ($cat->cat_id == $settings['def_cat'] ) echo 'class=active' ?>> <a data-toggle="tab" data-cat-id="<?php echo $cat->cat_id; ?>" href="#cat_<?php echo $cat->cat_id; ?>" style=""><?php echo $cat->cat_name; ?> </a> </li>
                                    <?php } ?>
                                    </ul>
                                </div>
                                <div id="item-list" style="overflow: auto" class="no-print"></div>
                                <?php if($settings['key_brd']){ ?>
                                    <?php if($settings['key_brd_lyt'] == 2){ ?>
                                        <!--keyboard type 2-->
                                        <div style="clear: both;border-top: 4px solid rgb(66, 139, 202);display: flex;" id="keyboard_panel" class="no-print">
                                            <div class="key" role="group" style="display:flex;flex-wrap: wrap;flex-direction: column;flex: 1;">
                                                <div style="display: flex;justify-content: space-between;margin-bottom: 5px;">
                                                        <button type="button" class="btn btn-warning btn-num" data-key="1">1</button>
                                                        <button type="button" class="btn btn-warning btn-num" data-key="2">2</button>
                                                        <button type="button" class="btn btn-warning btn-num" data-key="3">3</button>
                                                </div>
                                                <div style="display: flex;justify-content: space-between;margin-bottom: 5px;">
                                                        <button type="button" class="btn btn-warning btn-num" data-key="4">4</button>
                                                        <button type="button" class="btn btn-warning btn-num" data-key="5">5</button>
                                                        <button type="button" class="btn btn-warning btn-num" data-key="6">6</button>
                                                </div>
                                                <div style="display: flex;justify-content: space-between;margin-bottom: 5px;">
                                                        <button type="button" class="btn btn-warning btn-num" data-key="7">7</button>
                                                        <button type="button" class="btn btn-warning btn-num" data-key="8">8</button>
                                                        <button type="button" class="btn btn-warning btn-num" data-key="9">9</button>
                                                </div>
                                                <div style="display: flex;justify-content: center;">
                                                    <button type="button" class="btn btn-warning btn-num" data-key="0">0</button>
                                                </div>
                                                <div style="display: flex;justify-content: center;">
                                                        <button type="button" class="btn btn-danger btn-num" data-key="backspace"> <i class="fa fa-chevron-left"></i> </button>
                                                        <button type="button" class="btn btn-success btn-num" data-key="Enter">&nbsp;ENTER</button>
                                                    
                                                </div>
                                            </div>
                                            <div class="money" role="group" style="display:flex;flex: 1;flex-direction: column;align-items: center;justify-content: space-between;">
                                                <button type="button" class="btn btn-danger btn-money" data-money="20">20</button>
                                                <button type="button" class="btn btn-danger btn-money" data-money="50">50</button>
                                                <button type="button" class="btn btn-danger btn-money" data-money="100">100</button>
                                                <button type="button" class="btn btn-danger btn-money" data-money="500">500</button>
                                                <button type="button" class="btn btn-danger btn-money" data-money="1000">1000</button>
                                                <button type="button" class="btn btn-danger btn-money" data-money="5000">5000</button>
                                                
                                            </div>
                                        </div>
                                    <?php }else{ ?>
                                        <!--keyboard type 1-->
                                        <div style="clear:both;border-top: solid 4px #428bca;" id="keyboard_panel" class="no-print">
                                    <div class="btn-group-vertical key" role="group" style="display:flex">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning " data-key="0">0</button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning " data-key="1">1</button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning " data-key="2">2</button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning " data-key="3">3</button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning " data-key="4">4</button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning " data-key="5">5</button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning " data-key="6">6</button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning " data-key="7">7</button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning " data-key="8">8</button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning " data-key="9">9</button>
                                        </div>
                                        <!--<div class="btn-group">
                                
                            </div>-->
                                    </div>
                                    <div class="btn-group-vertical key" role="group" style="display:flex">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success " data-key="Enter">&nbsp;ENTER</button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-danger " data-key="backspace">CLEAR</button>
                                        </div>
                                        <div class="btn-group">&nbsp;</div>
                                        <div class="btn-group">&nbsp;</div>
                                        <div class="btn-group">&nbsp;</div>
                                    </div>
                                    <div class="btn-group-vertical money" role="group" style="display:flex">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-danger " data-money="20">20</button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-danger " data-money="50">50</button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-danger " data-money="100">100</button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-danger " data-money="500">500</button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-danger " data-money="1000">1000</button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-danger " data-money="5000">5000</button>
                                        </div>
                                        <div class="btn-group">&nbsp;</div>
                                        <div class="btn-group">&nbsp;</div>
                                        <div class="btn-group">&nbsp;</div>
                                    </div>
                                </div>
                                    <?php } ?>
                                <?php } ?>
                                
                            </div>
                        </div>
                        <div id="drawer"></div>
                        <input type="hidden" id="cash_en_tot" value="0" readonly>
                        <input type="hidden" id="qty_en_tot" value="">
                        <?php //$this->load->view("posplus/delivery"); 
                        ?>
                        <?php //$this->load->view("posplus/sckModal"); 
                        ?>
                        <!--END OF BILL MODAL-->
                        <!--LAST BILL MODAL-->
                        <div class="modal fade in no-print" id="last_bill_list" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="font-family: monospace; font-size: 14px">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header no-print">
                                        <button type="button" class="close no-print" data-dismiss="modal"><span aria-hidden="true"> <i class="fa fa-2x">&times;</i></span><span class="sr-only">Close</span> </button>
                                        <h4 class="modal-title no-print">LAST FIVE BILLS</h4>
                                    </div>
                                    <div class="modal-body" style="margin-top:-20px;padding: 15px 0px 0px 0px;">
                                    </div>
                                    <div class="modal-footer" style="border:none;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--END OF LAST BILL MODAL-->
                        <!--TABLE MODAL-->
                        <div class="modal fade" id="select_table_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header no-print">
                                        <button type="button" class="close no-print" data-dismiss="modal"><span aria-hidden="true"> <i class="fa fa-2x">&times;</i></span><span class="sr-only">Close</span> </button>
                                        <h4 class="modal-title no-print text-center" id="">SELECT TABLE</h4>
                                    </div>
                                    <div class="modal-body" style="display: flex;flex-wrap: wrap;justify-content: space-around"></div>
                                </div>
                            </div>
                        </div>
                        <!--END OF TABLE MODAL-->
                        <!--TABLE MODAL-->
                        <div class="modal fade" id="select_price_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header no-print">
                                        <button type="button" class="close no-print" data-dismiss="modal"><span aria-hidden="true"> <i class="fa fa-2x">&times;</i></span><span class="sr-only">Close</span> </button>
                                        <h4 class="modal-title no-print text-center" id="">SELECT PRICE</h4>
                                    </div>
                                    <div class="modal-body" style="display: flex;flex-wrap: wrap;justify-content: space-around;flex-direction: column;align-items: center;"></div>
                                </div>
                            </div>
                        </div>
                        <!--END OF TABLE MODAL-->
                        <div class="rotate btn-cat-con">
                            <button type="button" class="btn btn-danger" id="view_bill" tabindex="-1"> <i class="fa fa-print"></i> </button>
                            <?php if($settings['key_brd']){ ?>
                                <button type="button" class="btn btn-default" id="open-keyboard"><i class="fa fa-keyboard-o"></i></button>
                            <?php } ?>
                        </div>
                        <?php //$this->load->view("posplus/category-slider"); ?>

                        <!-- start -->
                        <div class="modal fade in" id="dsModal" tabindex="-1" role="dialog" aria-labelledby="dsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i></button>
                                        <h4 class="modal-title" id="dsModalLabel">Edit Order Discount</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="order_discount_input">Order Discount</label>
                                            <input type="text" name="order_discount_input" value="" class="form-control" id="order_discount_input" />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="updateOrderDiscount" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!---->
                        <div id="order_tbl"> <span id="order_span"></span>
                            <table id="order-table" class="prT table table-striped" style="margin-bottom:0;width:100%">
                            </table>
                        </div>
                        <div id="bill_tbl"> <span id="bill_span"></span>
                            <table id="bill-table" class="prT table table-striped" style="margin-bottom:0; width:100%">
                            </table>
                            <table id="bill-total-table" class="prT table" style="margin-bottom:0; width:100%">
                            </table>
                        </div>
                        <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
                        <div class="modal fade in" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true"></div>
                        <div id="modal-loading" class="no-print">
                            <div class="blackbg" style="display: flex;justify-content: center;align-items: center;opacity:0.9">
                                <center>
                                    <i style="color:#FFF;" class="fa fa-spinner fa-spin fa-5x"></i>
                                </center>
                            </div>
                            <div class="loader-"></div>
                        </div>
                        <div id="ajaxCall"><i class="fa fa-spinner fa-pulse"></i></div>
                        <!-- start ajax model -->
                        <div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
                        <!-- end ajax model -->
                        <!-- start popup box-->
                        <div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                                    <h4 class="modal-title">Confirm</h4>
                                </div>
                                <div class="modal-body">
                                    <p id="label"> </p>
                                </div>
                                <div class="modal-footer">
                                    <input id="sel_id" type="hidden" />
                                    <input id="page" type="hidden" />
                                    <input id="count" value="0" type="hidden" />
                                    <input id="popup_type" type="hidden" />
                                    <button aria-hidden="true" data-dismiss="modal" class="btn btn-default"> Close </button>
                                    <button id="conirm" class="btn btn-default" data-dismiss="modal"> Confirm </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if($ftr['ism']['din']['on']){ ?>
                <div id="dine_in" class="tab-pane">
                    <!-- content here -->
                    <?php $this->load->view("posplus/dine_in") ?>
                </div>
                <?php } ?>
                <?php if($ftr['ism']['tkw']['on']){ ?>
                <div id="take_away" class="tab-pane">
                    <!-- content here -->
                    <?php $this->load->view("posplus/take_away") ?>
                </div>
                <?php } ?>
                <?php if($ftr['ism']['dlv']['on']){ ?>
                <div id="delivery" class="tab-pane">
                    <!-- content here -->
                    <?php $this->load->view("posplus/delivery_s") ?>
                </div>
                <?php } ?>
                <?php if($ftr['add_prd']){ ?>
                <div id="add_product" class="tab-pane">
                    <!-- content here -->
                    <?php $this->load->view("posplus/add_product") ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!--BILL MODAL-->
    <div class="modal fade" id="view_bill_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="font-family: monospace;font-size: 14px;line-height: 15px;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" id="bill_content">
                <div class="modal-header no-print">
                    <button type="button" class="close no-print" data-dismiss="modal"><span aria-hidden="true"> <i class="fa fa-2x">&times;</i></span><span class="sr-only">Close</span> </button>
                    <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();"> <i class="fa fa-print"></i> Print </button>
                    <h4 class="modal-title no-print text-center" id="vbModalLabel">INVOICE</h4>
                </div>
                <div class="modal-body bill_styles" style="margin-top:-20px;padding: 15px 0px 0px 0px;">
                    <!--COMPANY LOGO AND OTHER DETAILS-->
                    <div class="text-center">
                        <!--<center>
                            <div style="display:none; border:solid 3px; border-radius:50px; width:13%; padding:15px; line-height:1"><span style="font-size:31px;font-weight:bold">SO</span> <span style="font-size:14px;font-weight:bold">Yummy</span></div>
                        </center>
                        <img class="" alt="logo" src="<?php echo asset_url(); ?>images/logo_print.png" style="margin-top: 1px;width: 100px;">-->
                        <h2 class="wh_name" style="margin-top: -5px;margin-bottom: 0px;"></h2>
                        <p class="wh_address" style="font-size:16px ; margin: 0px"></p>
                        <span class="wh_phone" style="font-weight:bold; font-size:15px"></span>
                        <span class="wh_email"></span>
                    </div>
                    <!--BILL OTHER DETAILS-->
                    <div class="">
                        <p id="bill_no_sanitized" style="text-align:center;font-size:18px;font-weight:bold; margin-top: 5px;margin-bottom: 5px;"></p>
                        <p id="table_no" style="font-weight:bold; margin-bottom: 0px"></p>
                        <p id="bill_dine_type" style="font-weight:bold; margin-bottom: 0px"></p>
                        <p id="bill_date" style="font-weight:bold; margin-bottom: 0px">Date: </p>
                        <p id="cashier_name" style="font-weight:bold; margin-bottom: 0px">Cashier:</p>
                        <!--delivery details-->
                        <p style="" id="bill_customer">Customer: </p>
                        <span style="" id="del_addr_bill"></span>
                    </div>
                    <div class="">
                        <table id="bill_table" class="print-table" style="width:100%">
                            <thead style="border-bottom:dashed;border-top:dashed">
                                <tr class="report_view_th text-center">
                                    <th>ITEM</th>
                                    <th class="text-center">QTY</th>
                                    <th style="text-align:right">AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                    <div style="text-align: center;font-size: 10px;line-height:9px">
                        <br />
                        <p id="bill_no" style="font-weight:bold; margin-bottom: 0px">Bill No: </p>
                        <p style="text-align: center">Viable ERP by Sallelanka <br /> 077706 9344</p>
                        <h2 style="margin-top: 5px">~~~Thank You~~~</h2>
                    </div>
                </div>
                <div class="modal-footer" style="display:none;border:none; padding:0px 5px 0px 5px;" id="kot_footer">
                    <div class="" style="font-size:1.1vw">
                        <p style=" text-align:center; font-weight:bold;margin:0px;">K.O.T </p>
                        <p style=" text-align:left; font-weight:bold;margin: 0px 35px 0px 0px;" id="kot_type"></p>
                        <p style=" text-align:left; font-weight:bold;margin: 0px 35px 0px 0px;" id="kot_bill_no"></p>
                        <p style=" text-align:left; font-weight:bold;margin: 0px 35px 0px 0px;" id="kot_table_no"></p>
                        <p style=" text-align:left; font-weight:bold;margin: 0px 35px 0px 0px;" id="kot_date_time"></p>
                        <table class="print-table" style="width:100%" id="kot_table">
                            <thead style="border-bottom:dashed;border-top:dashed">
                                <tr class="report_view_th text-center">
                                    <th style="width:75%" class="text-center">ITEM</th>
                                    <th style="width:10%" class="text-center">QTY</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in" id="modal_login_discount" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i></button>
                    <h4 class="modal-title" id="dsModalLabel">Enter Username and Password</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username_discount">Username</label>
                        <input type="text" name="username_discount" value="" class="form-control" id="username_discount" />
                    </div>
                    <div class="form-group">
                        <label for="password_discount">Password</label>
                        <input type="password" name="password_discount" value="" class="form-control" id="password_discount" />
                    </div>
                        <input type="hidden" value="" id="purpose" />
                    <!--<div class="form-group">
                        <label for="password">Reasons for cancellation</label>
                        <textarea name="cancellation_reasons" class="form-control" id="cancellation_reasons" /></textarea>
                    </div>-->
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_login_discount" class="btn btn-primary">Next</button>
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
                        <label for="password">Password</label>
                        <input type="password" name="password" value="" class="form-control" id="password" />
                    </div>
                    <div class="form-group">
                        <label for="password">Reasons for cancellation</label>
                        <textarea name="cancellation_reasons" class="form-control" id="cancellation_reasons" /></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_login" class="btn btn-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade in" id="modal_login_2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i></button>
                    <h4 class="modal-title" id="dsModalLabel">Enter Username and Password</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username_2" value="" class="form-control" id="username_2" />
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password_2" value="" class="form-control" id="password_2" />
                    </div>
                    <div class="form-group">
                        <label for="password">Reasons for cancellation</label>
                        <textarea name="cancellation_reasons_2" class="form-control" id="cancellation_reasons_2" /></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_login_2" class="btn btn-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
    <!-- impliment by sachith for sale item delete -->
    <div class="modal fade in" id="modal_login_3" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i></button>
                    <h4 class="modal-title" id="dsModalLabel">Enter Username and Password</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username_3" value="" class="form-control" id="username_3" />
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password_3" value="" class="form-control" id="password_3" />
                    </div>
                    <div class="form-group">
                        <label for="password">Reasons for cancellation</label>
                        <textarea name="cancellation_reasons_2" class="form-control" id="cancellation_reasons_2" /></textarea>
                        <input type="hidden" name="sale_item_id_d_delete" value="" class="form-control" id="sale_item_id_d_delete" />
                        <input type="hidden" value="" class="form-control" id="sale_item_id_tr_delete" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_login_3" class="btn btn-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end -->
    <!-- Modal -->
    <div class="modal fade" id="discountModal" tabindex="-1" role="dialog" aria-labelledby="discountModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="discountModalLabel">Enter Item Discount</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="discountInput">Discount (%) / (Rs.)</label>
              <input type="text" class="form-control" id="discountInput" placeholder="Enter discount percentage or Number">
              <input type="hidden" class="form-control" id="target_input">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="saveDiscountBtn">Save</button>
            <button type="button" class="btn btn-danger" id="clearInputsBtn">Clear Inputs</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade in" id="splitmodal" tabindex="-1" role="dialog" aria-labelledby="splitmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i></button>
                    <h4 class="modal-title" id="splitmodalLabel">Split Bill</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-6 ">
                        <div class="well" id="left_side"  style="max-height: 60vh;overflow: auto;">
                            <table class="table table-condensed dataTable" id="old_items">
                                <tbody></tbody>
                            </table>
                        </div>
                        <a class="btn btn-lg btn-primary" style="width: 100%;" id="move_right"> <i class="fa fa-chevron-right"></i></a>
                    </div>
                    <div class="col-md-6 ">
                        <form id="new_form">
                            <input type="hidden" id="unique_id" name="unique_id" value="">
                            <input type="hidden" id="split_bill_id" name="split_bill_id" value="">
                            <input type="hidden" id="new_bill_id" name="new_bill_id" value="">
                            <div class="well" id="right_side"  style="max-height: 60vh;overflow: auto;">
                                <table class="table table-condensed dataTable" id="new_items">
                                    <tbody></tbody>
                                </table>
                            </div>
                        </form>
                        <a class="btn btn-lg btn-default" style="width: 100%;" id="move_left"> <i class="fa fa-chevron-left"></i></a>
                    </div>
                    <span class="clearfix"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" id="create" class="btn btn-primary">Create</button>
                </div>
            </div>
        </div>
    </div>
    
    <input type="hidden" id="del_row_id" value="">
    <input type="hidden" id="terminal_id" value="">
    <script>
        class RowCollector {
            constructor() {
                this.rows = [];
                this.printer_name = "";
            }
            
            setPrinter(printer_name){
                this.printer_name = printer_name;
            }
            
            getPrinter(){
                return this.printer_name;
            }
        
            addRow(columns, offset = 20, font = "Courier New", fontSize = 12, fontStyle = "bold") {
                const row = {
                    columns: columns,
                    offset: offset,
                    font_size: fontSize
                };
                this.rows.push(row);
            }
            getRows() {
                return this.rows;
            }
            toJSON(sc) {
                return JSON.stringify({ data: this.rows, success: sc, pn: this.printer_name });
            }
        }
   </script>
    <script type="text/javascript">
        var defaultHTMLContent = '';
        var jsonarray = localStorage['local_items'] === undefined ? [] : JSON.parse(localStorage['local_items']);
        var products = [];
        if(jsonarray.length > 0){
            $.each(jsonarray, (a, b) => {
                products[b.product_id] = b
            });
        }
        /*
        var jsonarray = <?php print_r($product_list) ?>;
        var products = [];
            $.each(jsonarray, (a, b) => {
                products[b.product_id] = b
            });
        */
        var base_url = '<?php echo base_url(); ?>';
        /*
        <?php $price_types_json = json_encode($price_types); ?>
        var priceTypes = <?php echo $price_types_json; ?>;
        var priceTypesMapped = [];
        $(priceTypes).each((a, b) => {
            priceTypesMapped[b.pt_id] = b;
        });*/
        
    </script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/posplus.9.js"></script>
    <script>
        
        async function set_terminal() {
            var terminal_id = uuidv4();
            var terminals = JSON.parse(localStorage.getItem('terminals')) || [];

            if (terminals.length < 2) {
                terminals.push(terminal_id);
            } else {
                // Replace the oldest terminal ID with the new one
                var shifted = terminals.shift(); // Remove the oldest terminal ID
                terminals.push(terminal_id); // Push the new terminal ID
                /*alert("shifted:"+shifted);*/
            }
            /*alert("");*/
            localStorage.setItem('terminals', JSON.stringify(terminals));
            $('#terminal_id').val(terminal_id);
            /*implement firebase here to save terminal id with user_id*/
        }
        $(window).on('beforeunload', function() {
            remove_terminal();
        });
        
        function remove_terminal() {
            /*alert("This just Ran");
            var terminal_id = $('#terminal_id').val();
            var terminals = JSON.parse(localStorage.getItem('terminals')) || [];
            var index = terminals.indexOf(terminal_id);
            if (index !== -1) {
                terminals.splice(index, 1);
                localStorage.setItem('terminals', JSON.stringify(terminals));
            }*/
            return false;
        }

        /*OFFLINE*/
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                //Register SW
                navigator.serviceWorker.register('<?php echo base_url() ?>posplus/service-worker.js')
                    .then(registration => {
                        console.log('Service worker registered:', registration);
                    })
                    .catch(error => {
                        console.log('Service worker registration failed:', error);
                    });
                // Listen for messages from the service worker
                navigator.serviceWorker.addEventListener('message', function(event) {
                    if (event.data && event.data.action === 'updateCache') {
                        // Call your function or perform any desired action
                        console.log('POS JS: Triggered client function updateCache');
                        get_items();
                    } else
                    if (event.data && event.data.action === 'reload_page') {
                        if (localStorage.reload_count == undefined) {
                            localStorage.setItem('reload_count', '2');
                            window.location.reload()
                        }
                    }
                });
            });
        } else {
            //alert("WARNING! SERVICE WORKER FAILED.");
            //document.body.style.display = 'none';
        }
        function toggleFullScreen() {
            if (document.fullscreenElement) {
                document
                    .exitFullscreen()
                    .then(() => console.log("Document Exited from Full screen mode"))
                    .catch((err) => console.error(err));
                $('#btn-fs').html('<i class="fa fa-arrows-alt"></i> </a>');
            } else {
                document.documentElement.requestFullscreen();
                $('#btn-fs').html('<i class="fa fa-times"></i> </a>');
            }
        }
        function is_touch_enabled() {
            return ('ontouchstart' in window) ||
                (navigator.maxTouchPoints > 0) ||
                (navigator.msMaxTouchPoints > 0);
        }
        /*$("#cusModal").on("shown.bs.modal", function() {
            $('#cus_phone').focus();
        });
        $('#cus_name').on('blur', function() {
            $("#cusModal").modal('hide');
        });*/
        
        
        $(document).ready(function() {
            get_products();
            checkLogin();
            check_for_updates();
            set_terminal();
            defaultHTMLContent = getDefaultHTMLContent("pos_form");
            initializeIndexedDB();
            /*Check for updates*/
            /*Check the session*/
            /*Init tables*/
            fillModalBodyWithSquares(site.numTables);
            get_count();
            generateTables(site.numTables);
            /**/
            apply_ac();
            $('#cat_tabs > li.active > a').click();
            $(window).on('resize',()=>{ widthFunctions(<?php echo $settings['num_col']; ?>)});
        });
        
        function get_count(){
            $.ajax({
                dataType: "JSON",
                type: "POST",
                url: '<?php echo base_url() ?>posplus/get_inv_count',
                cache: false,
                success: function(resp){
                    var next_id = resp.count;
                    localStorage.setItem([getCurrentDate()], next_id);
                },error: function(){
                    if(localStorage.getItem(getCurrentDate()) == undefined){
                        localStorage.setItem([getCurrentDate()], 0);
                    }
                }
            });
        }
        function get_products(){
            // apply_ac();
            // $('#cat_tabs > li.active > a').click();
            // return false;
            $.ajax({
                dataType: "JSON",
                type: "POST",
                url: '<?php echo base_url() ?>posplus/get_products',
                cache: false,
                success: function(resp){
                    localStorage.setItem('local_items',JSON.stringify(resp));
                    jsonarray = resp;
                    $.each(resp, (a, b) => {
                        products[b.product_id] = b
                    });
                    $('#cat_tabs > li.active > a').click();
                    apply_ac();
                },
                error: function(){
                    bootbox.alert("You are offline!");
                }
            });
        }
        // Call the function to initialize IndexedDB
        function initializeIndexedDB() {
            const dbName = '<?php echo $this->db->database; ?>';
            const storeName = 'orders';
            // Open or create the database
            const request = indexedDB.open(dbName, 1);
            // Setup the database schema if it doesn't exist
            request.onupgradeneeded = function(event) {
                const db = event.target.result;
                // Check if the object store exists, and create it if it doesn't
                if (!db.objectStoreNames.contains(storeName)) {
                    db.createObjectStore(storeName, {
                        keyPath: 'orderId',
                        autoIncrement: true
                    });
                }
            };
            // Handle success or error when opening the database
            request.onsuccess = function(event) {
                const db = event.target.result;
                /*console.log(`Successfully opened ${dbName} database`);*/
                // Perform any additional actions with the database as needed
                // (e.g., query data, add records, etc.)
            };
            request.onerror = function(event) {
                console.error(`Error opening ${dbName} database: ${event.target.error}`);
            };
        }
        async function check_for_updates() {
            if (localStorage.reload_count !== undefined) {
                var rc = parseInt(localStorage.reload_count);
                if (rc > 0) {
                    await ham();
                    localStorage.setItem('reload_count', --rc);
                    bootbox.dialog({
                        message: '<h1 class="text-center"><i class="fa fa-cog fa-spin"></i> </h1><div class="text-center"><h3>Working on Updates. Please wait!</h3><h3>System will restart several times.</h3></div>',
                        closeButton: false
                    });
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                } else if (rc == 0) {
                    await ham();
                    localStorage.removeItem('reload_count');
                    bootbox.dialog({
                        message: '<h1 class="text-center"><i class="fa fa-cog fa-spin"></i> </h1><div class="text-center"><h3>Working on Updates. Please wait!</h3><h3>System will restart several times.</h3></div>',
                        closeButton: false
                    });
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                }
            }
        }
        async function ham() {
            // Get all visible modals
            var visibleModals = document.querySelectorAll('.modal.fade.in');
            // Iterate through each visible modal and close it
            visibleModals.forEach(function(modal) {
                $(modal).modal('hide');
            });
        }
        // Use a generic selector for all modal elements
        $(".modal").on("show.bs.modal", function() {
            $(this).css({
                'display': 'grid',
                'align-items': 'center'
            });
        });
<?php if($ftr['ism']['din']['on']){ ?>
        $(document).on('click','#dinein', function(event) {
            $('.price_type').removeClass('active');
            $(this).addClass('active');
            //$(':radio[name=delivery_status][value=1]').iCheck('check');
            $(':radio[name=delivery_status][value=1]').prop("checked", true);
            $('#select_table_modal').modal('show');
            $('#table_id').show();
            $('#waiter_id').show();
        });
        $(document).on('touchstart','#dinein',function(){
            setTimeout(()=>{
                $('.price_type').removeClass('active');
            $(this).addClass('active');
            //$(':radio[name=delivery_status][value=1]').iCheck('check');
            $(':radio[name=delivery_status][value=1]').prop("checked", true);
            $('#select_table_modal').modal('show');
            $('#table_id').show();
            $('#waiter_id').show();
            },700);
        });
<?php } ?>
<?php if($ftr['ism']['tkw']['on']){ ?>
        $(document).on('click','#take-away', function(event) {
            $('.price_type').removeClass('active');
            $(this).addClass('active');
            $(':radio[name=delivery_status][value=2]').prop("checked", true);
            $('#table_id').hide();
            $('#table_id').val("");
            $('#waiter_id').hide();
            $('#waiter_id').val("");
        });
<?php } ?>
<?php if($ftr['ism']['dlv']['on']){ ?>
        $('#deliver').on('click touchstart', function(event) {
            $('.price_type').removeClass('active');
            $(this).addClass('active');
            $(':radio[name=delivery_status][value=3]').prop("checked", true);
            $('#table_id').hide();
            $('#table_id').val("");
            $('#waiter_id').hide();
            $('#waiter_id').val("");
        });
<?php } ?>
        
        /**/
        function init_pos() {
            /*console.log("init pos");*/
            count_orders();
            /*$("#cusModal").modal();*/
            <?php echo $ftr['cus_reg'] ? "$('#cus_phone').focus();": "$('#add_item').focus();"; ?>
            
            <?php if($settings['key_brd']){ ?>
                /*if(localStorage.keyboard === 'show' || localStorage.keyboard === 'hide'){
                    if(localStorage.keyboard === 'show')
                        $('#keyboard_panel').show();
                    else if(localStorage.keyboard === 'hide')
                        $('#keyboard_panel').hide();
                }else{
                    localStorage.setItem('keyboard','show');
                    $('#keyboard_panel').show();
                }*/
                if (['show', 'hide'].includes(localStorage.keyboard)) {
                    $('#keyboard_panel').toggle(localStorage.keyboard === 'show');
                } else {
                    localStorage.setItem('keyboard', 'show');
                    $('#keyboard_panel').show();
                }
            <?php } ?>
            
            $("#modal-loading").hide();
            setTimeout(()=>{
                widthFunctions(<?php echo $settings['num_col']; ?>);
            },700);
        }
        /*Check Login Process*/
        async function checkLogin() {
            try {
                const loginData = await performLogin();
                handleSuccessfulLogin(loginData);
            } catch (error) {
                handleLoginError(error);
            }
        }
        async function performLogin() {
            var terminal_id = localStorage.getItem('terminal_id');
            /*console.log('terminal_id',terminal_id);*/
            
            const loginUrl = "<?php echo base_url() ?>posplus/app_login";
            
            // Create a new FormData object
            const formData = new FormData();
            formData.append('terminal_id', terminal_id);
            
            const response = await fetch(loginUrl, {
                method: "POST",
                body: formData, // Send form data instead of JSON
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            
            return await response.json();
        }

        function handleSuccessfulLogin(data) {
            if (data.status) {
                // Successful login handling logic
                setCashierDetails(data.cashier);
                setWhDetails(data.wh);
                setBaseURL(data.base_url);
                localStorage.setItem('login_response', JSON.stringify(data));
                init_pos();
                /*Submit Queue to the server if there's any*/
                submitDataFromIndexedDB();
            } else {
                handleFailedLogin(data.cashier);
            }
        }
        function setCashierDetails(cashier) {
            site.cashierFloatId = cashier.float_id;
            site.cashierName = cashier.name;
            site.userID = cashier.user_id;
            document.getElementById('cashier_name').innerHTML = "Cashier :" + (site.cashierName).toUpperCase();
            $('.user > span').html('Welcome ' + site.cashierName);
        }
        function setWhDetails(wh) {
            site.wh_id = wh.id;
            site.wh_code = wh.code;
            site.wh_name = wh.name;
            site.wh_address = wh.address;
            site.wh_phone = wh.phone;
            site.wh_email = wh.email;
        }
        function setBaseURL(baseURL) {
            site.base_url = baseURL;
        }
        function handleFailedLogin(errorDetails) {
            document.getElementById('modal-loading').style.display = 'block';
            alert("PLEASE START NEW SHIFT BEFORE CONTINUE!");
            window.location.href = "<?php echo base_url(); ?>dashboard";
            console.log("Login failed!");
            console.log("Error Details:", errorDetails);
        }
        function handleLoginError(error) {
            console.log('handling login error:', error);
            if (localStorage.login_response == undefined || typeof localStorage.login_response != 'string') {
                console.error("AJAX error:", error);
                $('body').html("<h1> Critical Error! </h1><p>Please check the internet connection and refresh (Press `F5`) the application!</p>");
                checkInternetConnection(true);
            } else {
                handleOfflineLogin();
            }
        }
        function handleOfflineLogin() {
            $('#header > div').addClass('connecting');
            const loginData = JSON.parse(localStorage.login_response);
            setCashierDetails(loginData.cashier);
            setWhDetails(loginData.wh);
            setBaseURL(loginData.base_url);
            localStorage.setItem('login_response', JSON.stringify(loginData));
            init_pos();
            checkInternetConnection();
        }
        async function openDb() {
            const dbPromise = indexedDB.open("loginDataDB", 1);
            dbPromise.onupgradeneeded = function(event) {
                const db = event.target.result;
                // Create object store for cashier
                if (!db.objectStoreNames.contains("cashier")) {
                    db.createObjectStore("cashier", {
                        keyPath: "id",
                        autoIncrement: true
                    });
                }
                // Create object store for wh
                if (!db.objectStoreNames.contains("wh")) {
                    db.createObjectStore("wh", {
                        keyPath: "id",
                        autoIncrement: true
                    });
                }
                // Create object store for base_url
                if (!db.objectStoreNames.contains("base_url")) {
                    db.createObjectStore("base_url", {
                        keyPath: "id",
                        autoIncrement: true
                    });
                }
            };
            return new Promise((resolve, reject) => {
                dbPromise.onsuccess = function(event) {
                    const db = event.target.result;
                    resolve(db);
                };
                dbPromise.onerror = function(event) {
                    reject(event.target.error);
                };
            });
        }
        async function deleteDatabase(dbName) {
            try {
                await indexedDB.deleteDatabase(dbName);
                console.log(`Database "${dbName}" deleted successfully.`);
            } catch (error) {
                console.error(`Error deleting database "${dbName}":`, error);
            }
        }
        /*End of check login process*/
        function checkInternetConnection(reload = false) {
            var checkInterval;
            function isOnline() {
                /*timeout controller*/
                var controller = new AbortController();
                var timeoutId = setTimeout(() => controller.abort(), 5000);
                fetch('https://www.google.com', {
                        method: 'HEAD',
                        mode: 'no-cors',
                        signal: controller.signal
                    })
                    .then(function() {
                        submitDataFromIndexedDB();
                        console.log("You are online.");
                        $('#header > div').removeClass('connecting');
                        clearTimeout(timeoutId);
                        if (reload) window.location.reload();
                    })
                    .catch(function() {
                        checkInterval = setTimeout(isOnline, 5000);
                        console.warn("You are offline. Please check your internet connection. - 1");
                    });
            }
            // Check initially
            isOnline();
        }
        // Event listener for changes in online/offline status
        window.addEventListener('online', function() {
            console.log("You are back online!");
            $('#header > div').removeClass('connecting');
            submitDataFromIndexedDB();
        });
        window.addEventListener('offline', function() {
            $('#header > div').addClass('connecting');
            console.warn("You are offline. Please check your internet connection. - 2");
        });
        /**/
        function set_window() {
            /*console.log(localStorage.getItem('windows_in_use'));*/
            if (localStorage.getItem('windows_in_use') === 1) {
                /*alert(1);*/
                window.close();
            } else {
                /*alert(2);*/
                localStorage.setItem("windows_in_use", "0");
            }
        }
        function reset_window() {
            //alert(3);
            localStorage.setItem("windows_in_use", "0");
        }
        function validate_qty() {
            $(":focus").each(function() {
                focused = this.id;
            });
            var for_fld = "#" + focused;
            var for_val = $(for_fld).val();
            if (for_val > 10000) {
                $(for_fld).val(1);
                //displayNotice("page", " Invalid quantity :  " + for_val);
            }
        }
        
        function validate_qtty(a) {
            // Get the value of the input field
            var quantity = $(a).val();
            
            // Check if the quantity is a positive integer
            if (quantity !== '' && !isNaN(quantity) && parseFloat(quantity) > 0) {
                // Quantity is valid
                
            } else {
                // Quantity is not valid, apply red border
                $(a).val(1);
            }
        }
        
        function validate_discount(a){
            var enteredDiscount = $(a).val();
        
            // Regular expression to match valid discount inputs
            var discountRegex = /^(\d{1,2}(\.\d{1,2})?|100(\.0{1,2})?)%?$|^(\d+(\.\d{1,2})?)$/;
        
            // Test the discount input against the regex
            if (!discountRegex.test(enteredDiscount)) {
                // If the input is invalid, clear the input field
                $(a).val('');
            }
        }

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
        /*START OFFLINE SUPPORT FUNCTIONS*/
        function getCurrentDate() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const formattedDateTime = `${year}_${month}_${day}`;
            return formattedDateTime;
        }
        function sanitizeID(id) {
            var removed = id.slice(2);
            return id;
        }
        function createId(branchCode, shift_id, isOnline = 1) {
            // Retrieve the last ID from local storage
            var next_id = parseInt(localStorage[getCurrentDate()]);
            // Check if the last ID is not a number (NaN)
            if (isNaN(next_id)) {
                // Handle local storage error
                //alert("Local DB error! - " + next_id);
                console.warn("Local DB initiating... New ID - " + next_id);
                // Set a default value for last ID and update local storage
                localStorage.setItem([getCurrentDate()], 1);
                next_id = 1;
            } else {
                localStorage.setItem([getCurrentDate()], ++next_id);
            }
            // Get the current date and time components
            const now = new Date();
            const date = now.getDate().toString().padStart(2, '0');
            const hour = now.getHours().toString().padStart(2, '0');
            const minute = now.getMinutes().toString().padStart(2, '0');
            const second = now.getSeconds().toString().padStart(2, '0');
            // Convert online flag to '1' or '0'
            const onlineFlag = isOnline ? '1' : '0';
            // Pad the shift_id to ensure it always has a length of 6 characters
            const paddedBranchCode = branchCode.toString().padStart(2, '0');
            // Pad the shift_id to ensure it always has a length of 6 characters
            const paddedShiftId = shift_id.toString().padStart(4, '0');
            // Pad the last ID to ensure it always has a length of 3 characters
            next_id = next_id.toString().padStart(3, '0');
            // Construct and return the ID
            return `${paddedBranchCode}${paddedShiftId}${next_id}`;
            //branchCode    : 2
            //paddedShiftId : 6
            //date          : 2
            //hour          : 2
            //second        : 2
            //next_id       : 3
            //11111111111111111 = 17 chars
        }
        function createOT(ott, shift_id) {
            // Retrieve the last ID from local storage
            var next_id = parseInt(localStorage[ott.toString() + getCurrentDate()]);
            // Check if the last ID is not a number (NaN)
            if (isNaN(next_id)) {
                // Handle local storage error
                //alert("Local DB error! - " + next_id);
                console.warn("Local DB initiating... New ID - " + next_id);
                // Set a default value for last ID and update local storage
                localStorage.setItem([ott.toString() + getCurrentDate()], 1);
                next_id = 1;
            } else {
                localStorage.setItem([ott.toString() + getCurrentDate()], ++next_id);
            }
            // Get the current date and time components
            const now = new Date();
            const date = now.getDate().toString().padStart(2, '0');
            const hour = now.getHours().toString().padStart(2, '0');
            const minute = now.getMinutes().toString().padStart(2, '0');
            const second = now.getSeconds().toString().padStart(2, '0');
            // Pad the shift_id to ensure it always has a length of 6 characters
            const paddedBranchCode = site.wh_code.toString().padStart(2, '0');
            // Pad the shift_id to ensure it always has a length of 6 characters
            const paddedShiftId = shift_id.toString().padStart(6, '0');
            // Pad the last ID to ensure it always has a length of 3 characters
            next_id = next_id.toString().padStart(3, '0');
            // Construct and return the ID
            return `${paddedBranchCode}${paddedShiftId}${next_id}`;
        }
        function uuidv4() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0,
                    v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }
        /**/
        /**/
        function collectPayments() {
            var c = 0;
            let paymentDetails = '';
            //$('#payment_list tbody tr').each(function() {
            $('.payments').each(function() {
                let paymentType = $(this).find('.payment-type').val();
                let paymentAmount = $(this).find('.payment-amount').val();
                if (paymentType && paymentAmount) {
                    paymentDetails += `
                        <input type="hidden" name="payment[${c}][type]" value="${paymentType}">
                        <input type="hidden" name="payment[${c}][amount]" value="${paymentAmount}">
                    `;
                }
                c++;
            });
            $('#hidden_payments').html(paymentDetails);
        }
        function updateTotal() {
            let total = 0;
            //$('#payment_list tbody tr').each(function() {
            $('.payments').each(function() {
                let amount = parseFloat($(this).find('.payment-amount').val());
                if (!isNaN(amount)) {
                    total += amount;
                }
            });
            $('#total_paid_amount').text(total.toFixed(2));
            return total.toFixed(2);
        }
        
        <?php if($settings['mlt_pmt']){ ?>

        // Function to add a new payment row
        function addPaymentRow(amount = 0) {
            
            /**/
            if(!amount > 0){
                const bill_total = $('#grand_total').val();
                const pay_amount = $('#pay_amount').val();
                
                if(bill_total > 0){
                    amount = bill_total - pay_amount;
                }
            }
            /**/
            
            var c = site.pc++;
            let newRow = `
                <tr class="payments">
                    <td>
                        <select class="form-control payment-type" name="payment[${c}][type]">
                            <?php echo $ftr['pmt_csh'] ? '<option value="cash">Cash</option>': ''; ?>
                            <?php echo $ftr['pmt_vsa'] ? '<option value="visa">VISA</option>': ''; ?>
                        </select>
                    </td>
                    <td>
                        <input id="${generateRandomString()}" type="text" name="payment[${c}][amount]" class="form-control payment-amount" step="0.01" min="0" value="${amount}" onkeypress="isDecimal(event)" autocomplete="off">
                    </td>
                    <td>
                        <button class="btn btn-danger delete-payment">Delete</button>
                    </td>
                </tr>
            `;
            $('#payment_list tbody').append(newRow);
            $('#payment_list tbody tr:last .payment-amount').focus();
            setTimeout(()=>{
                grand_total_cal();
            },100);
        }
        
        function generateRandomString() {
          const length = 9;
          const characters = '0123456789';
          let result = '';
        
          for (let i = 0; i < length; i++) {
            const randomIndex = Math.floor(Math.random() * characters.length);
            result += characters.charAt(randomIndex);
          }
        
          return result;
        }
    
        // Event listener for adding a new payment
        $('#add_new_payment').click(function() {
            addPaymentRow();
        });
    
        // Event delegation for deleting a payment
        $('#payment_list').on('click', '.delete-payment', function() {
            $(this).closest('tr').remove();
            grand_total_cal();
        });
    
        // Event delegation for updating the total when payment amount changes
        $('#payment_list').on('input', '.payment-amount', function() {
            grand_total_cal();
        });
    
        
        <?php } ?>
        /**/
        /**/
        async function validate() {
            var a = $(':radio[name=delivery_status]:checked').val();
            if (a == 1) {
                var table_id = $('#table_id').val();
                var waiter_id = $('#waiter_id').val();
                if (waiter_id == '') {
                    bootbox.alert('Please select Waiter!');
                    document.getElementById('save').disabled = false;
                    return false;
                }
                if (table_id == '') {
                    bootbox.alert('Please select table number!');
                    document.getElementById('save').disabled = false;
                    return false;
                }
                /*$('#kot_table_no').text("Table No:" + table_id);*/
            }
            /* Check if items are there to submit */
            if (! $('#posTable > tbody > tr').length > 0) {
                alert("No Items!");
                document.getElementById('save').disabled = false;
                return false;
            }
        
            /* Check payments */
            var pay_cash = $('#pay_cash').val() ? $('#pay_cash').val() : 0;
            var pay_cc = $('#pay_cc').val() ? $('#pay_cc').val() : 0;
        
            if (!is_numeric($('#pay_cc').val() ? $('#pay_cc').val() : 0)) {
                bootbox.alert("Invalid values for VISA payment");
                document.getElementById('save').disabled = false;
                return false;
            }
        
            if (!is_numeric($('#pay_cash').val() ? $('#pay_cash').val() : 0)) {
                bootbox.alert("Invalid values for Cash payment");
                document.getElementById('save').disabled = false;
                return false;
            }
        
            if ($('#pay_cc').val() > parseFloat(accounting.unformat($('#gtotal').text()))) {
                bootbox.alert("Invalid VISA payment");
                document.getElementById('save').disabled = false;
                return false;
            }
            
        
            const posTbody = $('#posTable tbody');
            var nott = 0;
            var ott = [];
            posTbody.find('tr').each(function (index, row) {
                var product_ott = $(row).find('[id^=product_ott_]').val();
                nott += parseFloat(accounting.unformat(product_ott)) > 0 ? 1 : 0;
                if (parseFloat(accounting.unformat(product_ott)) > 0) {
                    if (!ott.includes(product_ott)) {
                        ott.push(product_ott);
                    }
                }
                
            });
            
            $('#kot_item_count').val(nott);
            
            /*checking numbers*/
            var itm_length = $('#posTable > tbody > tr').length;
            var submit_itm_sum = 0;
            
            // Calculate the sum of quantities
            $('[name="quantity[]"]').each(function() {
                submit_itm_sum += parseFloat($(this).val()) || 0;
            });
            
            if (submit_itm_sum > 0){
                /*aulak na*/
            }else if($('#pay_cc').val() > 0 || $('#pay_cash').val() > 0){
                if($('#continued').val() == 1 && itm_length > 0 ){
                    /*aulak na*/
                }else if($('#continued').val() == 1 && !itm_length > 0){
                    alert("CALL 077-4009171: S1");
                    reset_bill();
                    return true;
                }else{
                    alert("CALL 077-4009171: S2");
                    reset_bill();
                    return false;
                }
            }else{
                reset_bill();
                return false;
            }

            collectPayments();

            if(nott > 0){
                get_ot(ott);
            }else{
                var sale_id = $('#sale_id').val() != "" ? $('#sale_id').val() : createId(site.wh_id, site.cashierFloatId);
                form_submit(sale_id);
            }
        }
        
        <?php if($settings['mlt_pmt']){ ?>
        $('#payment').on('click',()=>{
            if($('#posTable > tbody > tr').length > 0){
                $('#multiple_payments').css('display','block');
                $('#cat_label_containet').css('display','none');
                $('#item-list').css('display','none');
                addPaymentRow();
                //addPaymentRow(parseFloat(accounting.unformat($('#gtotal').text())));
            }else
                alert("No Items!");
        });
        <?php } ?>

        $("#add_item").bind("keypress", function(b) {
            if (b.keyCode == 13) {
                b.preventDefault();
                    if($('#posTable > tbody > tr').length > 0){
                        <?php if($settings['mlt_pmt']){ ?>
                            $('#payment').click();
                        <?php }else{ ?>
                            $("#pay_cash").focus();
                            $("#pay_cash").select();
                            $(this).autocomplete("search");
                        <?php } ?>    
                    }
            }
        });

        function add_ot(ot_id, ot_type, ot_ref_no) {
            var $form = $('#pos_form');
            
            // Create hidden input elements using jQuery
            var $input1 = $('<input>').attr({
                type: 'hidden',
                name: 'ot[' + ot_type + '][id]',
                value: ot_id
            });
            
            var $input2 = $('<input>').attr({
                type: 'hidden',
                name: 'ot[' + ot_type + '][ot_type]',
                value: ot_type
            });
            
            var $input3 = $('<input>').attr({
                type: 'hidden',
                name: 'ot[' + ot_type + '][ot_ref_no]',
                value: ot_ref_no
            });
            
            // Append the hidden inputs to the form using jQuery
            $form.append($input1, $input2, $input3);
            
            // Log the HTML of the created elements
            console.log("A",$input1[0].outerHTML);
            console.log("B",$input2[0].outerHTML);
            console.log("C",$input3[0].outerHTML);
        }

        async function get_ot(ott) {
            
            /*$('#view_bill_modal').show();
            $('#view_bill_modal').css('opacity','0.8');*/
            
            var sale_id = $('#sale_id').val() != "" ? $('#sale_id').val() : createId(site.wh_id, site.cashierFloatId);
            var kot_ref = "";
            var kot_id = "";
            var isTimeout = false;
        
            // Setting a timeout for 3 seconds
            const timeoutPromise = new Promise((resolve, reject) => {
                setTimeout(() => {
                    isTimeout = true;
                    reject(new Error('Timeout'));
                }, 3000); // 3 seconds
            });
        
            try {
                // Making the AJAX request
                const data = await Promise.race([
                    $.ajax({
                        dataType: "JSON",
                        type: "POST",
                        data: {
                            sale_id : sale_id,
                            ott : ott
                        },
                        url: site.base_url + 'posplus/get_ot',
                        cache: false
                    }),
                    timeoutPromise
                ]);
        
                if (!isTimeout) {
                    console.log("OT DATA",data);
                    site.ott_data = data;
                    $('#ns').val('on');
                    
                    if(Object.keys(site.ott_data).length > 0){
                        $.each(site.ott_data,(a,b)=>{
                            if (b.i) {
                                add_ot(b.i, b.t, b.r);
                            }
                        });
                    }
                    
                    /*console.log("OT DATA NEXT",data[3]);*/
                    /*$.each(data,(a,b)=>{
                        console.log(b);
                        if (b.i) {
                            $('#kot_id').val(data.i);
                            $('#kot_ref_no').val(data.r);
                        }
                    });*/
                    // If the request did not timeout
                    /**/
                }
            } catch (error) {
                if (isTimeout) {
                    console.error('Request timed out');
                } else {
                    console.error("Error fetching OT:", error);
                }
                $('#ns').val('off');
                var ott_data = {};
                $.each(ott,(a,b)=>{
                    console.log(a);
                    console.log(b);
                    if (parseInt(b) > 0) {
                        var otr = createOT(b,site.cashierFloatId);
                        if(!ott_data.hasOwnProperty(b)){
                            ott_data[b] = {};
                        }
                            ott_data[b]["i"] = "";
                            ott_data[b]["r"] = otr;
                            ott_data[b]["t"] = b;
                            add_ot("", b, otr);
                    }
                });
                site.ott_data = ott_data;
            } finally {
                // Always call after the try-catch block finishes executing
                form_submit(sale_id);
            }
        }
        
        async function form_submit(sale_id = '') {
            if(!sale_id){
                validate();
                return false;
            }
            console.log("FORM SUBMIT");
            $('#sale_id').val(sale_id);
            $('#uniq_id').val(uuidv4());
            var formData = $("#pos_form").serialize();
            var resp = await saveToIndexedDB(sale_id, formData);
            if(resp){
                prep_bill(sale_id);
                $('#sale_id').val("");
                $('#continued').val(0);
                $("#table_id").css("pointer-events", "unset");
                $("#waiter_id").css("pointer-events", "unset");
                $('a[data-toggle="tab"][href="#Sales"]').html("Add Sale").removeAttr('style');
                submitDataFromIndexedDB();
            }else{
                bootbox.alert("Invalid sales data. Please Enter the bill again!",function(){
                    window.location.reload();
                });
            }
        }
        /* START SUBMISSION PROCESS*/
        function saveToIndexedDB(key, data) {
            return new Promise((resolve, reject) => {
                const dbName = '<?php echo $this->db->database; ?>';
                const storeName = 'orders';
                const request = indexedDB.open(dbName, 1);
                request.onupgradeneeded = (event) => {
                    const db = event.target.result;
                    if (!db.objectStoreNames.contains(storeName)) {
                        db.createObjectStore(storeName, {
                            keyPath: 'id'
                        });
                    }
                };
                request.onsuccess = (event) => {
                    const db = event.target.result;
                    const transaction = db.transaction(storeName, 'readwrite');
                    const objectStore = transaction.objectStore(storeName);
                    const addObject = {
                        id: key,
                        data: data,
                    };
                    const addObjectRequest = objectStore.put(addObject);
                    addObjectRequest.onsuccess = () => {
                        resolve(true);
                    };
                    addObjectRequest.onerror = () => {
                        reject(false);
                    };
                };
                request.onerror = () => {
                    reject(false);
                };
            });
        }
        async function submitDataFromIndexedDB() {
            const dbName = '<?php echo $this->db->database; ?>';
            const storeName = 'orders';
            // Open the IndexedDB
            const db = await new Promise((resolve, reject) => {
                const request = indexedDB.open(dbName, 1);
                request.onsuccess = (event) => {
                    resolve(event.target.result);
                };
                request.onerror = () => {
                    reject('Failed to open IndexedDB');
                };
            });
            const transaction = db.transaction(storeName, 'readwrite');
            const objectStore = transaction.objectStore(storeName);
            const keys = await new Promise((resolve) => {
                const keysRequest = objectStore.getAllKeys();
                keysRequest.onsuccess = (event) => {
                    resolve(event.target.result);
                };
            });
            // Function to submit data to the server
            const submitToServer = async (key) => {
                const data = await new Promise((resolve) => {
                    console.log(key);
                    const getRequest = objectStore.get(key);
                    getRequest.onsuccess = (event) => {
                        resolve(event.target.result);
                    };
                });
                console.log('data from DB', data.data);
                const serializedData = data.data;
                const controller = new AbortController();
                //const timeoutId = setTimeout(() => controller.abort(), 5000); // 5-second timeout
                try {
                    const response = await fetch(site.base_url + 'posplus/pos_submit', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: serializedData,
                        signal: controller.signal, // Connect AbortController.signal to the fetch request
                    });
                    //clearTimeout(timeoutId); // Clear the timeout if the fetch request completes before the timeout
                    if (response.ok) {
                        const responseData = await response.json();
                        console.log('JSON Response:', responseData);
                        if (responseData.success) {
                            // If the submission is successful, delete the key from IndexedDB
                            const keyToDelete = key;
                            deleteKeyFromIndexedDB(keyToDelete)
                                .then(() => {
                                    console.log(`Key "${keyToDelete}" deleted successfully.`);
                                })
                                .catch((error) => {
                                    console.error('Error deleting key:', error.message);
                                });
                        } else {
                            console.log('Failure!');
                        }
                    } else {
                        console.error(`Failed to submit data for key ${key}`);
                        checkInternetConnection();
                    }
                } catch (error) {
                    console.error(`Error submitting data for key ${key}: ${error}`);
                }
            };
            // Submit data for each key
            await Promise.all(keys.map(submitToServer));
            // Close the connection to the database
            db.close();
            count_orders();
        }
        function viewAllOrdersFromIndexedDB() {
            const dbName = '<?php echo $this->db->database; ?>';
            const storeName = 'orders';
            // Open the IndexedDB
            const request = indexedDB.open(dbName, 1);
            request.onsuccess = (event) => {
                const db = event.target.result;
                const transaction = db.transaction(storeName, 'readonly');
                const objectStore = transaction.objectStore(storeName);
                const getAllRequest = objectStore.getAll();
                getAllRequest.onsuccess = (event) => {
                    const orders = event.target.result;
                    console.log('All Orders in IndexedDB:');
                    orders.forEach((order) => {
                        console.log(order);
                    });
                    // Close the connection to the database
                    db.close();
                };
                getAllRequest.onerror = () => {
                    console.error('Failed to retrieve orders from IndexedDB');
                };
            };
            request.onerror = () => {
                console.error('Failed to open IndexedDB');
            };
        }
        function countRemainingOrdersInIndexedDB() {
            const dbName = '<?php echo $this->db->database; ?>';
            const storeName = 'orders';
            return new Promise((resolve, reject) => {
                const request = indexedDB.open(dbName, 1);
                request.onsuccess = (event) => {
                    const db = event.target.result;
                    const transaction = db.transaction(storeName, 'readonly');
                    const objectStore = transaction.objectStore(storeName);
                    const countRequest = objectStore.count();
                    countRequest.onsuccess = (event) => {
                        const count = event.target.result;
                        db.close();
                        resolve(count);
                    };
                    countRequest.onerror = () => {
                        db.close();
                        reject('Failed to get the count of orders from IndexedDB');
                    };
                };
                request.onerror = () => {
                    reject('Failed to open IndexedDB');
                };
            });
        }
        function count_orders() {
            countRemainingOrdersInIndexedDB().then((count) => {
                    $('#order_count').html(count);
                    //console.log(`Remaining orders in IndexedDB: ${count}`);
                })
                .catch((error) => {
                    console.error(error);
                });
        }
        async function deleteKeyFromIndexedDB(key) {
            // Open a connection to the IndexedDB database
            const dbName = '<?php echo $this->db->database; ?>';
            const storeName = 'orders';
            const db = await new Promise((resolve, reject) => {
                const request = indexedDB.open(dbName, 1);
                request.onerror = (event) => {
                    reject(new Error('Error opening IndexedDB'));
                };
                request.onsuccess = (event) => {
                    resolve(event.target.result);
                };
            });
            // Open a transaction and get the object store
            const transaction = db.transaction(storeName, 'readwrite');
            const objectStore = transaction.objectStore(storeName);
            // Delete the key from the object store
            const deleteRequest = objectStore.delete(key);
            // Return a promise for the delete operation
            return new Promise((resolve, reject) => {
                deleteRequest.onsuccess = (event) => {
                    resolve();
                };
                deleteRequest.onerror = (event) => {
                    reject(new Error('Error deleting key from IndexedDB'));
                };
            });
        }
        /*END OF OFFLINE*/
        function fillModalBodyWithSquares(numTables) {
            var modalBody = document.querySelector('#select_table_modal .modal-body');
            modalBody.innerHTML = '';
            
            var rowDiv; // Variable to hold the current row div
            
            for (var i = 1; i <= numTables; i++) {
                if ((i - 1) % 10 === 0) {
                    // Create a new row div every 10 squares
                    rowDiv = document.createElement('div');
                    rowDiv.classList.add('table_row');
                    modalBody.appendChild(rowDiv);
                }
                
                var tableSquare = document.createElement('div');
                tableSquare.classList.add('table-square');
                tableSquare.textContent = i;
                tableSquare.setAttribute('data-table-number', i);
                tableSquare.addEventListener('click', function() {
                    //alert('Selected Table: ' + this.getAttribute('data-table-number'));
                    change_selected_table(this.getAttribute('data-table-number'));
                });
                
                rowDiv.appendChild(tableSquare);
            }
        }
        function change_selected_table(tableNumber) {
            $('#table_id').val(tableNumber).trigger('change');
            $('#select_table_modal').modal('hide');
        }
        /*
        function set_queue(formDataJson){
            console.log(formDataJson);
            var submit_q = $.parseJSON(localStorage.getItem('submit_q')) ? $.parseJSON(localStorage.getItem('submit_q')) : {};
            console.log('submit_q',submit_q);
            submit_q[$('#uniq_id').val()] = formDataJson;
            localStorage.setItem('submit_q', JSON.stringify(submit_q));
            console.log('submit_q',submit_q);
            alert("Queueed!");
            $('#modal-loading').hide();
        }*/
        /*
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
                }*/
        function num_simplify(key) {
            let stringWithoutFirstSeven = key.substring(14);
            return stringWithoutFirstSeven;
        }
        function get_otn(n){
            if(n == 1)
                return "Chinese OT";
            if(n == 2)
                return "Tea OT";
            if(n == 3)
                return "Bain.M OT";
            if(n == 4)
                return "Juice OT";
            else 
                return "NO O.T";
        }
        function get_printer_name(n){
            if(n == 1)
                return "POS-80-Series";
            if(n == 2)
                return "Microsoft Print To PDF";
            if(n == 3)
                return "Microsoft Print To PDF";
            if(n == 4)
                return "Microsoft Print To PDF";
            else 
                return "";
        }
        async function prep_bill(key) {
            
            console.log("site.ott_data", site.ott_data);
            
            var print_jobs = [];
            
            if(site.ott_data !== undefined){
                if(Object.keys(site.ott_data).length > 0){
                    $.each(site.ott_data,(a,b)=>{
                        console.log("b.t",b.t);
                        if (b.t) {
                            print_jobs[b.t] = new RowCollector();
                        }
                    });
                }
                console.log("FKN HELLL",print_jobs);
            }
            
            const total_paid = parseFloat(updateTotal()); /*parseFloat(parseFloat($('#pay_cash').val()) + parseFloat($('#pay_cc').val())).toFixed(2);*/
            const is_kot = total_paid > 0 ? false : true;
            
            const dineType = $(':radio[name=delivery_status]:checked').val() == '1' ? "Dine In" : "Take Away";
            const tableID = $('#table_id').val();
            const posTbody = $('#posTable tbody');
            const billTableTbody = $('#bill_table tbody');
            const tfoot = $('#bill_table tfoot');
        
            /*create bill header*/
            $(".wh_name").html(site.wh_name);
            $(".wh_address").html(site.wh_address);
            $(".wh_phone").html(site.wh_phone);
            $(".wh_email").html(site.eh_email);
            $("#bill_no").html(key);
            //$("#bill_no_sanitized").html('KOT:' + sanitizeID(key.toString()));
            
            var santid = 'Bill No:' + sanitizeID(key.toString());

            var kotItemCount = parseInt($('#kot_item_count').val());
            var nsValue = $('#ns').val();
            var ottDataLength = site.ott_data !== undefined ? Object.keys(site.ott_data).length : 0;
            
            if (kotItemCount > 0 && nsValue === 'on') {
                if (ottDataLength > 0) {
                    $("#bill_no_sanitized").html(santid);
                    $.each(site.ott_data, (a, b) => {
                        if (b.i) {
                            var otn = get_otn(b.t);
                            $("#bill_no_sanitized").after('<b>' + otn + ':' + b.r + '</b>');
                        }
                    });
                } else {
                    alert("Invalid Scenario");
                    return false;
                }
            } else if (kotItemCount > 0 && nsValue === 'off') {
                if (ottDataLength > 0) {
                    $("#bill_no_sanitized").html(santid);
                    $.each(site.ott_data, (a, b) => {
                        if (b.i) {
                            var otn = get_otn(b.t);
                            $("#bill_no_sanitized").after('<b>' + otn + '(OFF):' + b.r + '</b>');
                        }
                    });
                } else {
                    alert("Invalid Scenario OFF");
                    return false;
                }
            } else if (!kotItemCount > 0) {
                $("#bill_no_sanitized").html(santid);
            } else {
                alert("NEW SCENARIO");
                
                console.log("kotItemCount",kotItemCount);
                console.log("nsValue",nsValue);
                console.log("ottDataLength",ottDataLength);
                return false;
            }


            if (tableID > 0) $("#table_no").html("Table: " + tableID);
                else $("#table_no").html("");

            var cus_phone = $('#cus_phone').val() || '(no number)';
            var cus_name = $('#cus_name').val() || '(walk-in)';
            var cus_txt = "Customer: " + cus_phone + ' ' + cus_name;
            $('#bill_customer').text(cus_txt);
        
            $("#bill_dine_type").text(dineType);
            $("#cashier_name").text("Cashier: " + site.cashierName + "("+site.userID+")");
        
            /*create bill body*/
            var total_amount = 0;
            posTbody.find('tr').each(function (index, row) {
                var is_old = $(row).find('[name^=product_name]').val() === undefined;
                if(is_kot && is_old){
                    return true;
                }
                
                var productName = $(row).find('[id^=product_name_]').val();
                var product_code = $(row).find('[id^=product_code_]').val();
                var quantity = $(row).find('[id^=quantity_]').val();
                var amount = $(row).find('.ssubtotal').text();
        
                billTableTbody.append('<tr><td colspan="3">(' + product_code + ')' + productName + '</td></tr>');
                billTableTbody.append('<tr><td colspan="2" class="text-right">' + quantity + '</td><td class="text-right">' + amount + '</td></tr>');
        
                total_amount += parseFloat(accounting.unformat(amount));
                /*OTT*/
                var ott = $(row).data('ott');
                const extra_offset = 5;
                var temp_offset = 0;
                if(ott != "undefined"){
                    if(print_jobs[parseInt(ott)] !== undefined){
                        const ra = print_jobs[parseInt(ott)].getRows();
                        if(ra.length === 0){
                            print_jobs[parseInt(ott)].addRow([get_otn(parseInt(ott)) + "-"+site.ott_data[parseInt(ott)].r.toString().padStart(3, '0')], 5, "Courier New", 12, "bold");
                            //print_jobs[parseInt(ott)].addRow([site.ott_data[parseInt(ott)].r.toString().padStart(3, '0')], extra_offset, "Courier New", 12, "bold");
                            print_jobs[parseInt(ott)].addRow([santid], extra_offset, "Courier New", 12, "bold");
                            print_jobs[parseInt(ott)].addRow([dineType], extra_offset, "Courier New", 12, "bold");
                            print_jobs[parseInt(ott)].addRow([cus_txt], extra_offset, "Courier New", 12, "bold");
                            print_jobs[parseInt(ott)].addRow([$("#bill_date").text()], extra_offset, "Courier New", 12, "bold");
                            print_jobs[parseInt(ott)].addRow(["Cashier: " + site.cashierName + "("+site.userID+")"], extra_offset, "Courier New", 12, "bold");
                            if(tableID > 0)
                                print_jobs[parseInt(ott)].addRow(["Table : " + tableID], extra_offset, "Courier New", 12, "bold");
                            
                            temp_offset = 10;
                        }else{
                            temp_offset = 0;
                        }
                        print_jobs[parseInt(ott)].setPrinter(get_printer_name(parseInt(ott)));
                        print_jobs[parseInt(ott)].addRow([productName, quantity], extra_offset+temp_offset, "Courier New", 12, "regular");
                    }
                }
            });
            
            /*CREATE BILL FOOTER*/
            tfoot.empty();
            tfoot.append('<tr style="border-top:dashed;"><td colspan="2">SubTotal</td><td style="text-align:right;">' + parseFloat(total_amount).toFixed(2) + '</td></tr>');

            /*checking for item discounts*/
            var dsc = 0;
            posTbody.find('tr').each(function (index, row) {
                var dis_am = $(row).find('[id^=product_discount_amount_]').val();
                if (parseFloat(dis_am) > 0) dsc++;
            });
            /*if discounted item count > 0, add a title*/
            if (dsc > 0 && !is_kot) {
                tfoot.append('<tr style="border-top:dashed;margin-top:5px"><td colspan="3"><b>Applied Discounts</b></td></tr>');
            }

            /*applying HTML for item discounts*/
            if (dsc > 0 && !is_kot)
            posTbody.find('tr').each(function (index, row) {
                var row_id = $(row).data('row-id');
                var dis    = $('#product_discount_' + row_id);
                var dis_am = $('#product_discount_amount_' + row_id).val();
                if (parseFloat(dis_am) > 0) {
                    var productCode = $('#product_code_' + row_id).val();
                    tfoot.append('<tr style="border-top:dashed;"><td>' + productCode + '</td><td>' + dis + ' Dis</td><td style="text-align:right;"> Dis/Itm: ' + dis_am + '</td></tr>');
                }
            });

            /*CHecking order discount*/
            var tot_discount = $("#order_discount_input").val() || "0";
            var discount = 0;
            if (tot_discount != "") {
                if (tot_discount.includes("%")) {
                    var e = tot_discount.split("%");
                    discount = isNaN(e[0]) ? formatDecimal(tot_discount) : formatDecimal((total_amount * parseFloat(e[0])) / 100);
                } else {
                    discount = formatDecimal(tot_discount);
                }
            }
            if (discount > 0) {
                total_amount -= discount;
                tfoot.append('<tr><td style="font-size:24px" colspan="2">Discount:</td><td style="text-align:right;font-size:24px;border-bottom:4px double #000;border-top: solid 2px;">' + discount + '(' + tot_discount + ')' + '</td></tr>');
            }

            /*Apply total amount*/
            tfoot.append('<tr><td style="font-size:24px" colspan="2">Total:</td><td style="text-align:right;font-size:24px;border-bottom:4px double #000;border-top: solid 2px;">' + parseFloat(total_amount).toFixed(2) + '</td></tr>');
            
            if(!is_kot){
                $('.payments').each(function() {
                    let paymentType = $(this).find('.payment-type').val();
                    let paymentAmount = $(this).find('.payment-amount').val();
                    if (paymentType && paymentAmount > 0) {
                        tfoot.append('<tr><td colspan="2">'+paymentType+':</td><td>' + parseFloat(paymentAmount).toFixed(2) + '</td></tr>');
                    }
                });
                
                tfoot.append('<tr><td colspan="2">Total paid:</td><td style="text-align:right;">' + parseFloat(total_paid).toFixed(2) + '</td></tr>');
                
                if (total_paid > 0) {
                    var balance = parseFloat(total_paid) - parseFloat(total_amount);
                    tfoot.append('<tr><td style="font-size:24px;" colspan="2">Balance:</td><td style="font-size:24px;" class="text-right">' + parseFloat(balance).toFixed(2) + '</td></tr>');
                }
            }else
                tfoot.append('<tr><td style="font-size:24px;" class="text-center" colspan="3">**Order Token**</td></tr>');
            
            var jobs = [];
            $.each(print_jobs,(a,b)=>{
                if(b !== undefined){
                    var crr = b.getRows();
                    jobs.push(JSON.parse(b.toJSON(crr.length > 0)));
                }
            });
            
            if(Object.keys(jobs).length > 0){
                console.log(jobs);
                post_data(JSON.stringify(jobs));
            }
            
            $('#posTable > tbody').empty();
            $("#view_bill_modal").modal('show');
        }
        function post_data(json_data){
            window.location.href= "vpos:"+json_data;
        }
        window.onafterprint = () => {
            if($('a[data-toggle="tab"][href="#take_away"]').css('display') == 'none'){
                window.location.reload();
            }
            reset_bill();
        };
        $("#view_bill_modal").on("shown.bs.modal", function() {window.print();}).on("hidden.bs.modal", function() {
            //$('#save').attr('disabled',false);
            $('#add_item').focus();
            /*
            <?php echo $ftr['cus_reg'] ? "text": "hidden"; ?>
            */
            document.getElementById('save').disabled = false;
        });
        function getDefaultHTMLContent(elementId) {
            var element = document.getElementById(elementId);
            if (element) {
                return element.innerHTML;
            } else {
                return null; // Element not found
            }
        }
        function applyHTMLContent(elementId, htmlContent) {
            var element = document.getElementById(elementId);
            if (element) {
                element.innerHTML = htmlContent;
            } else {
                console.error("Element not found with ID: " + elementId);
            }
        }
        function reset_bill() {
            $('#hidden_payments').empty();
            $('#payment_list > tbody').empty();
            
            $('#multiple_payments').css('display','none');
            $('#cat_label_containet').css('display','');
            $('#item-list').css('display','');
            
            /*applyHTMLContent("pos_form", defaultHTMLContent);
            apply_ac();
            grand_total_cal();
            $("#view_bill_modal").modal('hide');
            return false;*/
            /*window.location.reload();*/
            if($('a[data-toggle="tab"][href="#take_away"]').css('display') == 'none'){
                window.location.reload();
            }
            /*BILL*/
            var billTable = document.getElementById('bill_table');
            var tbody = billTable.querySelector('tbody');
            tbody.innerHTML = '';
            var tfoot = billTable.querySelector('tfoot');
            tfoot.innerHTML = '';
            /*KOT*/
            var kotTable = document.getElementById('kot_table');
            var tbody = billTable.querySelector('tbody');
            tbody.innerHTML = '';
            var tfoot = billTable.querySelector('tfoot');
            tfoot.innerHTML = '';
            
            /*reset form data*/
            $('#cus_phone').val("");
            $('#cus_name').val("");
            $('#cus_id').val("1");
            
            $('#pay_cc').val(0);
            $('#pay_cash').val(0);
            $('#cash_en_tot').val(0);
            
            $('#take-away').click();
            $('#table_id').val('').trigger('change');
            $('#pos_form').trigger("reset");
            /*$("#cusModal").modal();*/
            $('#posTable > tbody').empty();
            
            $('#discount').val('');
            $('#pos_discount_input').val(0);
            $('#discount_amount').text("");
            $('#order_discount_input').val(0);
            
            $('#kot_id').val('');
            $('#kot_ref_no').val('');
            $('#kot_item_count').val(0);
            $('#ns').val('on');
            
            $('a[href="#cat_5"]').click();
            $('#is_seperate').prop('checked',false);
            $('#call_order').prop('checked',false);
            grand_total_cal();
            $("#view_bill_modal").modal('hide');
        }
        
        var table;
        function loadDataTable(tableId, dineType) {
            return $('#' + tableId).DataTable({
                "dom": "Bftrip",
                "bProcessing": true,
                "ajax": {
                    "url": site.base_url + "posplus/list_pos_sales",
                    "data": {
                        dine_type: dineType
                    },
                    "complete": function() {
                        $(".select2-nosearch").select2({
                            minimumResultsForSearch: Infinity
                        });
                    }
                },
                "bPaginate": false,
                "autoWidth": false,
                "bDestroy": true,
                "iDisplayLength": 1000,
                "order": [
                    [1, "desc"]
                ]
            });
        }
        <?php if($ftr['ism']['dlv']['on']){ ?>
        function loadDelivery() {
            return loadDataTable('delivery_table', 3);
        }
        <?php } ?>
        <?php if($ftr['ism']['tkw']['on']){ ?>
        function loadTakeaway() {
            return loadDataTable('takeaway', 2);
        }
        <?php } ?>
        <?php if($ftr['ism']['din']['on']){ ?>
        function loadDineIn() {
            return loadDataTable('dine_in_table', 1);
        }
        <?php } ?>
        
        function print_cancelled(id) {
            u = location.href;
            t = document.title;
            window.open(site.base_url + 'sales/sale_details_pos?sale_id=' + id, 'sharer', 'toolbar=0,status=0,width=626,height=700, left=10, top=10,scrollbars=yes');
            return false;
        }
        async function complete_and_print(id) {
            await complete_sale(id);
            u = location.href;
            t = document.title;
            window.open(site.base_url + 'sales/sale_details_pos?sale_id=' + id, 'sharer', 'toolbar=0,status=0,width=626,height=700, left=10, top=10,scrollbars=yes');
            return false;
        }
        function print_bill(id) {
            u = location.href;
            t = document.title;
            $('#dine_in-panel-refresh').click();
            $('#takeaway-panel-refresh').click();
            window.open(site.base_url + 'sales/sale_details_pos_without_balance?sale_id=' + id, 'sharer', 'toolbar=0,status=0,width=626,height=700, left=10, top=10,scrollbars=yes');
            return false;
        }
        <?php if($ftr['edt_sle']){?>
        function edit_sale(id) {
            jQuery.ajax({
                type: "POST",
                url: site.base_url + "posplus/get_sale_info",
                data: {
                    sale_id: id.toString(),
                },
                cache: false,
                dataType: "JSON",
                success: function(response) {
                    console.log(response);
                    
                    if(parseInt(response.ready_sale) == 1){
                        $('#add_item').css('visibility','hidden');
                        $('#cat_label_containet').css('visibility','hidden');
                        $('#item-list').css('visibility','hidden');
                    }
                    
                    $('#sale_id').val(response.sale_id);
                    $('#continued').val(1);
                    $('a[data-toggle="tab"][href="#Sales"]').html("continue sale no: " + response.sale_id).css({
                        'background': 'white',
                        'color': 'red',
                    });
                    $('a[data-toggle="tab"][href="#dine_in"]').html("Continue Sale").css({
                        'display': 'none'
                    });
                    $('a[data-toggle="tab"][href="#take_away"]').html("Continue Sale").css({
                        'display': 'none',
                    });
                    $(':radio[name=delivery_status][value=' + response.dine_type + ']').prop("checked", true);
                    /*$('.ds[value=' + response.dine_type + ']').prop("checked", true);*/
                    if (response.dine_type == 1) {
                        /*Dine IN*/
                        $("#waiter_id").val(response.waiter_id);
                        $('.price_type').removeClass('active');
                        $('a#dinein').addClass('active');
                        $("a#dinein").css("pointer-events", "none");
                        $(':radio[name=delivery_status][value=1]').prop("checked", true);
                        $('#table_id').val(response.table_id);
                        $('#table_id').show();
                        $('#waiter_id').show();
                    } else {
                        $('.price_type').removeClass('active');
                        $('a#take-away').addClass('active');
                        $(':radio[name=delivery_status][value=2]').prop("checked", true);
                        $('#table_id').hide();
                        $('#waiter_id').hide();
                        $('#table_id').val("");
                    }

                    $('#cus_id').val(response.customer_id);
                    $('#cus_name').val(response.customer.cus_name);
                    $('#cus_phone').val(response.customer.cus_phone);
                    
                    $("#order_discount_input").val(response.sale_inv_discount);
                    $("#order_discount_input").val(response.sale_inv_discount_amount);

                    open_tab('Sales');
                    $("#table_id").css("pointer-events", "none");
                    $("#waiter_id").css("pointer-events", "none");

                    $(response.items).each(function(a,b){
                        console.log('items b', b);
                        
                        var product = {
                            "id": b.id,
                            "product_id": b.product_id,
                            "product_id_sub": '',
                            "product_code": b.product_code,
                            "product_name": b.product_name,
                            "product_price": b.unit_price,
                            "discount" : b.discount,
                            "discount_val" : b.discount_val,
                            "quantity" : b.quantity,
                            "no_name" : 1
                        };
                        console.log(product);
                        add_to_list(product);
                    });
                    
                    $("#discount_amount").text(response.sale_inv_discount);
                    $("#discount").val(response.sale_inv_discount);
                    $("#pos_discount_input").val(response.sale_inv_discount);
                }
            });
        }
        <?php }?>
        /*function resetfun() {
        	this.location.reload(true);
        }*/
        async function complete_sale(id) {
            alert("COMPLETE SALE");
            jQuery.ajax({
                type: "POST",
                url: site.base_url + 'bar/complete_sale',
                data: {
                    sale_id: id,
                },
                cache: false,
                success: function(response) {
                    //displayNotice('page', 'Sale Completed !!');
                    <?php if($ftr['ism']['din']['on']){ ?>
                    loadDineIn();
                    <?php } ?>
                    <?php if($ftr['ism']['tkw']['on']){ ?>
                    loadTakeaway();
                    <?php } ?>
                    <?php if($ftr['ism']['dlv']['on']){ ?>
                    loadDelivery();
                    <?php } ?>
                }
            });
            var now = new Date();
        }
        
        $(document).on('click','#left_side > table > tbody > tr',function(){
            if($(this).hasClass("selected")){
                $(this).removeClass("selected");
            }else{
                $('.selected').removeClass("selected");
                $(this).addClass("selected");
            }
        });
        /*$('#create').on('click',function(){
            bootbox.alert("SURE?");
        });*/
        $(document).on('click','#move_right',function(){
            if($('.selected').length == 1){
                
                const sale_item_id = $('.selected').data('sale_item_id');
                const product_price = $('.selected').data('sale_item_price');
                const product_id = $('.selected').data('product_id');
                const name = $('.selected').find('td:nth-child(1)').text();
                const qtty = parseInt($('.selected').find('td:nth-child(2)').text());
                
                if(qtty > 1){
                    let moving_qtty = prompt("PLEASE ENTER THE QUANTITY:", qtty);
                    var iData = {
                        "product_id": product_id,
                        "siid": sale_item_id,
                        "qtty": qtty,
                        "product_price": product_price,
                        "moving_qtty": moving_qtty,
                        "name": name
                    }
                    if (moving_qtty != null && !isNaN(parseInt(moving_qtty)) && moving_qtty > 0 && moving_qtty <= qtty) {
                        if(moving_qtty == qtty){
                            $('.selected').remove();
                        }else{
                            $('.selected').find('td:nth-child(2)').text(accounting.formatMoney((qtty - moving_qtty),"",2,""));
                        }
                        add_to_right(iData);
                    }
                }else{
                    var iData = {
                        "product_id": product_id,
                        "siid": sale_item_id,
                        "qtty": qtty,
                        "moving_qtty": qtty,
                        "product_price": product_price,
                        "name": name
                    }
                    $('.selected').remove();
                    add_to_right(iData);
                }
            }
        }); 
        function add_to_right(data){
            console.log(data);
            var c = data.siid;
            var f = `<td>
                        <input type="hidden" value="${data.siid}"                       name="updates[`+c+`][siid]">
                        <input type="hidden" value="${data.moving_qtty}"    name="updates[`+c+`][si_qty]">
                        <input type="hidden" value="${data.product_id}" name="updates[`+c+`][product_id]">
                        <input type="hidden" value="${data.product_price}" name="updates[`+c+`][product_price]">
                        <input type="hidden" value="${data.qtty}" name="updates[`+c+`][product_qty]">
                        <input type="hidden" value="${data.name.trim()}" name="updates[`+c+`][product_name]">${data.name}</td>
                    <td class="text-right">
                        ${accounting.formatMoney(data.moving_qtty,"",2,"")}
                    </td>`;
                
                    var a = $('<tr id="sow_' + c + '" data-row-id="' + c + '"></tr>').html(f);
                    a.prependTo("#new_items > tbody");
            
            
        }
        function add_to_left(data){
            console.log(data);
            var c = data.id;
            var f = `<td>
                        ${data.product_name}
                     </td>
                    <td class="text-right">
                        ${data.quantity}
                    </td>`;
                
                    var a = $(`<tr data-product_id="${data.product_id}" data-sale_item_id="${c}"></tr>`).html(f);
                    a.prependTo("#old_items > tbody");
            
        }
        $(document).on('click','#create',function(){
            bootbox.confirm("Split the Bill?",function(e){
                if(e === true){
                    askSplit();
                }
            });
        });
        
        async function askSplit(){
            try {
                var splitResponse = await performSplit();
                console.log(splitResponse);
                if(splitResponse.success){
                    window.location.reload();
                }else{
                    bootbox.alert("ERROR! Please try again!",()=>{
                        window.location.reload();
                    });
                }
            } catch (error) {
                //console.error(splitResponse);
            }
        }
        
        async function performSplit() {
            var nb_id = createId(site.wh_id, site.cashierFloatId);
            $('#new_bill_id').val(nb_id);
            $('#unique_id').val(uuidv4());

            const url = "<?php echo base_url() ?>pos/split_bill";
            // Create a new FormData object
            const formData = new FormData(document.getElementById('new_form')); // Assuming 'new_form' is the ID of the form

            try {
                const response = await fetch(url, {
                    method: "POST",
                    body: formData, // Send form data
                });
        
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return await response.json();
            } catch (error) {
                console.error('Error:', error);
                // Handle error
            }
        }

        async function split_sale(id) {
            $('#split_bill_id').val(id);
            $("#old_items > tbody").empty();
            //return;
            jQuery.ajax({
                type: "POST",
                url: site.base_url + "posplus/get_sale_info",
                data: {
                    sale_id: id.toString(),
                },
                cache: false,
                dataType: "JSON",
                success: function(response) {
                    $.each(response.items,(a,b)=>{
                        add_to_left(b);
                        console.log(b); 
                    });
                    $('#splitmodal').modal();
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
                            url: site.base_url + "bar/ready_sale",
                            data: {
                                sale_id: id,
                                cus_phone: cus_phone,
                                rider_name: rider_name,
                                rider_phone: rider_phone,
                                amount: amount
                            },
                            cache: false,
                            success: function(response) {
                                //displayNotice('page', 'Sale Completed !!');
                                <?php if($ftr['ism']['din']['on']){ ?>
                                loadDineIn();
                                <?php } ?>
                                <?php if($ftr['ism']['tkw']['on']){ ?>
                                loadTakeaway();
                                <?php } ?>
                                <?php if($ftr['ism']['dlv']['on']){ ?>
                                loadDelivery();
                                <?php } ?>
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
                        url: site.base_url + "bar/ready_takeaway",
                        data: {
                            sale_id: sale_id,
                            cus_phone: cus_phone,
                            amount: amount
                        },
                        cache: false,
                        success: function(response) {
                            //displayNotice('page', 'Sale is ready !!');
                            <?php if($ftr['ism']['din']['on']){ ?>
                            loadDineIn();
                            <?php } ?>
                            <?php if($ftr['ism']['tkw']['on']){ ?>
                            loadTakeaway();
                            <?php } ?>
                            <?php if($ftr['ism']['dlv']['on']){ ?>
                            loadDelivery();
                            <?php } ?>
                        }
                    });
                }
            });
        }
        function cancel_sale(id) {
            jQuery.ajax({
                type: "POST",
                url: site.base_url + 'bar/get_otp',
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
                url: site.base_url + 'pos/check_user',
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
                },
                error: function(data) {
                    bootbox.alert(data.responseText);
                }
            });
        });
        function remove_sale_item_by_login(id) {
            <?php /*
            if($sale_id){
            ?>
                $('#del_row_id').val(id);
               // $("#modal_login_2").modal("show");
            <?php 
            }else {
            ?>
                $('#'+id).remove();
                grand_total_cal();
            <?php 
            }
            */ ?>
            /*
            grand_total_cal()
            
            */
            $('#' + id).remove();
            grand_total_cal();
        }
        $(document).on("click", "#btn_login_2", function() {
            $.ajax({
                dataType: "JSON",
                type: "POST",
                url: site.base_url + 'pos/check_user',
                data: {
                    username: $('#username_2').val(),
                    password: $('#password_2').val()
                },
                cache: false,
                success: function(data) {
                    if (data.success) {
                        $("#modal_login_2").modal("hide");
                        var tr_id = $('#del_row_id').val();
                        $('#' + tr_id).remove();
                        grand_total_cal();
                    } else {
                        bootbox.alert(data.validation);
                    }
                },
                error: function(data) {
                    bootbox.alert(data.responseText);
                }
            });
        });
        function send_rq(id) {
            jQuery.ajax({
                type: "POST",
                url: site.base_url + 'posplus/cancel_sale',
                data: {
                    sale_id: id,
                    cancellation_reasons: $('#cancellation_reasons').val(),
                    uuid : uuidv4()
                },
                cache: false,
                success: function(response) {
                    console.log("cancel sale response \n");
                    console.log(response);
                    $('#cancellation_reasons').val("");
                    //displayNotice('page', 'Sale Cancelled !!');
                    <?php if($ftr['ism']['din']['on']){ ?>
                    loadDineIn();
                    <?php } ?>
                    <?php if($ftr['ism']['tkw']['on']){ ?>
                    loadTakeaway();
                    <?php } ?>
                    <?php if($ftr['ism']['dlv']['on']){ ?>
                    loadDelivery();
                    <?php } ?>
                    print_cancelled(id);
                },
                error: function(data) {
                    bootbox.alert(data.responseText);
                }
            });
        }
        function set_as_paid(sid) {
            var sale_pymnt_date_time = $('#sale_datetime').val();
            var paid_by = $('#paying_by_' + sid).val();
            var given_amount = $('#c_pay_amount_' + sid).val();
            var paid_by_2 = $('#paying_by_2_' + sid).val();
            var given_amount_2 = $('#c_pay_amount_2_' + sid).val();
            jQuery.ajax({
                type: "POST",
                url: site.base_url + 'bar/set_as_paid',
                data: {
                    sale_id: sid,
                    paid_by: paid_by,
                    sale_pymnt_date_time: sale_pymnt_date_time,
                    given_amount: given_amount,
                    paid_by_2: paid_by_2,
                    given_amount_2: given_amount_2
                },
                cache: false,
                success: function(response) {
                    //displayNotice('page', 'Payment Succeed!!');
                    <?php if($ftr['ism']['din']['on']){ ?>
                    loadDineIn();
                    <?php } ?>
                    <?php if($ftr['ism']['tkw']['on']){ ?>
                    loadTakeaway();
                    <?php } ?>
                    <?php if($ftr['ism']['dlv']['on']){ ?>
                    loadDelivery();
                    <?php } ?>
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
                            url: site.base_url + 'sales/sales_delete?sale_id=' + sid,
                            cache: false,
                            success: function(response) {
                                //displayNotice('page', 'Successfully Deleted!!');
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
                            url: site.base_url + 'sales/sale_pymnts_delete?sale_id=' + sid + "&in_type=sale",
                            cache: false,
                            success: function(response) {
                                //displayNotice('page', 'Successfully Deleted!!');
                                <?php if($ftr['ism']['din']['on']){ ?>
                                loadDineIn();
                                <?php } ?>
                                <?php if($ftr['ism']['tkw']['on']){ ?>
                                loadTakeaway();
                                <?php } ?>
                                <?php if($ftr['ism']['dlv']['on']){ ?>
                                loadDelivery();
                                <?php } ?>
                            }
                        });
                    }
                });
            }
        }
        <?php /*
        
        */ ?>
        <?php
        //print_r($customers);
        /*$str = "var customers =[";
        foreach ($customers as $cus) {
            if ($cus['cus_phone'] != 0 && $cus['cus_phone'] != "") {
                $str .= '"' . $cus['cus_phone'] . '",';
            }
        }
        $str .= '""]';
        echo $str;*/
        ?>
        /*autocomplete(document.getElementById("cus_phone"), customers);*/
        function update_cus_list(){
            jQuery.ajax({
                type: "POST",
                url: site.base_url + 'posplus/get_phone',
                dataType: 'json',
                cache: false,
                success: function(response) {
                    customers = response;
                }
            });
        }
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
                url: site.base_url + 'customers/get_customer_info_by_phone',
                data: {
                    cus_phone: cus_phone,
                },
                dataType: 'json',
                cache: false,
                success: function(response) {
                    console.log(response);
                    if(response.cus_name != ""){
                        $('#cus_name').val(response.cus_name);
                        $('#cus_type').val(response.cus_type);
                        $('#cus_id').val(response.cus_id);
                        $('#add_item').focus();
                    }
                    else{
                        $('#cus_name').focus();
                    } 
                    
                    if(response.cus_type == 2){
                        bootbox.alert("STAFF MEMBER DETECTED!");
                    }
                }
            });
        }
        <?php if($settings['key_brd']){ ?>
        
        $('#open-keyboard').on('click',()=>{
            if ($('#keyboard_panel').is(':visible')) {
                $('#keyboard_panel').hide();
                localStorage.setItem('keyboard', 'hide');
            } else {
                $('#keyboard_panel').show();
                localStorage.setItem('keyboard', 'show');
            }
        });
        
        
        $('#keyboard_panel div.key button').on('mousedown',
            function(event) {
                event.preventDefault();
                var ti = event.target;
                var key_value = $(ti).data("key");
                var key_value = key_value + "";
                var focused = '';
                $(":focus").each(function() {
                    focused = this.id;
                });
                if($('#' + focused).attr('readonly') !== undefined){
                    return false;
                }
                if (key_value == "Enter") {
                    if ($('#' + focused).hasClass("rquantity")) {
                        //$('#add_item').focus();
                    } else
                    if (focused == "add_item") {
                        $('#save').click();
                    }
                } else {
                    var e = jQuery.Event("keydown");
                    e.key = key_value;
                    $('#' + focused).trigger(e);
                    
                    
                    var e2 = jQuery.Event("keyup");
                    e2.key = key_value;
                    $('#' + focused).trigger(e2);
                }
                /*if ($('#' + focused).hasClass("rquantity")){
                    $('#' + focused).change();
                }
                if ($('#' + focused).hasClass("rprice")){
                    $('#' + focused).change();
                }
                if ($('#' + focused).hasClass("rprice")){
                }*/
                $('#' + focused).change(); 
            }
        );
        $('#keyboard_panel div.money button').on('mousedown',
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
                if (focused == "pay_cash" || focused == "pay_cc")
                    grand_total_cal();
            }
        );
        <?php } ?>
        $('#add_note').on('click', function(e) {
            e.preventDefault();
            bootbox.prompt("Kitchen Note", function(result) {
                $('#kitchen_note').val(result);
            });
        });
        console.log("%cSTOP! Developers only.", "font-size: 40px; color:red");
        $(document).on("click", "#btn_login_3", function() {
            $.ajax({
                dataType: "JSON",
                type: "POST",
                url: site.base_url + 'pos/check_user',
                data: {
                    username: $('#username_3').val(),
                    password: $('#password_3').val()
                },
                cache: false,
                success: function(data) {
                    if (data.success) {
                        $("#modal_login_3").modal("hide");
                        var s_i_id = $('#sale_item_id_d_delete').val();
                        $('#username_3').val('');
                        $('#password_3').val('');
                        delete_invoice_item_by_s_item_id(s_i_id);
                    } else {
                        bootbox.alert(data.validation);
                    }
                },
                error: function(data) {
                    bootbox.alert(data.responseText);
                }
            });
        });
        function remove_saved_sale_item_by_login_(id,btn) {
            var tr = $(btn).closest('tr');
            var rid = $(tr).data('row-id');
            $('#sale_item_id_tr_delete').val(rid);
            $('#sale_item_id_d_delete').val(id);
            $("#modal_login_3").modal("show");
        }
        function remove_saved_sale_item_by_login(id) {
            $('#sale_item_id_d_delete').val(id);
            $("#modal_login_3").modal("show");
        }
        function delete_invoice_item_by_s_item_id(sid) {
            var group_id = $('#group_id').val();
            /*var confm =	window.confirm("Delete This Invoice ?");*/
            if (group_id != 3) {
                bootbox.confirm('Remove Item ID' + sid + '?', function(e) {
                    if (e) {
                        jQuery.ajax({
                            type: "POST",
                            url: site.base_url + 'sales/sales_item_delete?sale_id=' + sid + '&uuid='+uuidv4(),
                            cache: false,
                            dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                console.log(response.success);
                                //displayNotice('page', 'Successfully Deleted!!');
                                var rid = $('#sale_item_id_tr_delete').val();
                                if(rid){
                                    if(response.success){
                                        $('#row_'+rid).remove();
                                        bootbox.alert("Removed!");
                                    }
                                }else{
                                    <?php if($ftr['ism']['din']['on']){ ?>
                                    loadDineIn();
                                    <?php } ?>
                                    <?php if($ftr['ism']['tkw']['on']){ ?>
                                    loadTakeaway();
                                    <?php } ?>
                                    <?php if($ftr['ism']['dlv']['on']){ ?>
                                    loadDelivery();
                                    <?php } ?>
                                }
                            }
                        });
                    }
                });
            }
        }
                
        function getAmountForPtId2(productData) {
            let amount = 0; // Default to 0
            for (const price of productData.product_prices) {
                if (price.pt_id === 2) {
                    amount = price.amount.p1;
                    break;
                }
            }
            return amount;
        }

        $('#cat_tabs > li > a').on('click', function() {
            $('#item-list').empty();
            var cat_id = $(this).data('cat-id');
            var btn_list = ''; // Create an empty string to hold the HTML content
            if(jsonarray.length > 0){
                $.each(jsonarray, (a, b) => {
                    if (b.product_cat_id == cat_id) {
                        var san = sanitize_item(b);
                        var lbl_price = getAmountForPtId2(b);
                        
                        if(parseFloat(lbl_price) > 0){
                            /*console.log('san ',san);*/
                            if(san){
                                /*console.log('b', b);
                                console.log('b.product_prices', Object.keys(b.product_prices).length);*/
                                var btn = '<button id="product-' + b.product_id + '" type="button" class="item_btn_1 product box" value="' + b.product_id + '" product_price=\'' + JSON.stringify(b.product_prices) + '\' title="' + b.product_name + '" product_id="' + b.product_id + '" product_name="' + b.product_name + '">' +
                                    b.product_name + '<br>' + lbl_price
                                    '</button>';
                                btn_list += btn; // Append the button HTML to itemListHTML
                            }
                        }
                        
                    }
                });
                // Append all buttons at once to the item-list
                $('#item-list').append(btn_list);
            }
        });
        /*$('a[href="#Sales"]').on('shown.bs.tab', function (e) {
            //widthFunctions(<?php echo $settings['num_col']; ?>);
        });*/
        function focusOnEnter(event, targetElementId) {
            console.log('target',targetElementId);
            if (event.key === "Enter") {
                event.preventDefault();
                document.getElementById(targetElementId).focus();
                if(typeof document.getElementById(targetElementId).select !== 'undefined')
                    document.getElementById(targetElementId).select();
            }
        }
        function focusOnEnterUP(event) {
            if(document.getElementById('cus_phone').value.length > 0){
                if(validatePhoneNumber(document.getElementById('cus_phone').value)){
                    get_cus_name(document.getElementById('cus_phone').value);
                }
            }else{
                document.getElementById('cus_phone').value = "";
            }
        }
        
        $(document).on('click','.itm_discount',function(){
            var tr = $(this).closest('tr');
            var row_id = $(tr).data('row-id');
        
            var current_discount = "";
            var current_discount_amount = 0;
            if($('#product_discount_'+row_id).val()){
                current_discount = $('#product_discount_'+row_id).val();
                current_discount_amount = parseFloat($('#product_discount_amount_'+row_id).val());
            }
            
            $("#modal_login_discount").modal("show");
            $('#btn_login_discount').off("click").on("click", function() {
                $.ajax({
                    dataType: "JSON",
                    type: "POST",
                    url: site.base_url + 'pos/authorize',
                    data: {
                        username: $('#username_discount').val(),
                        password: $('#password_discount').val(),
                        auth_for : 'item_discount'
                    },
                    cache: false,
                    success: function(data) {
                        $("#modal_login_discount").modal("hide");
                        if (data.success) {
                            // Open Bootstrap modal 
                            $('#discountModal').modal('show');
                        
                            // Assign current discount value to the modal inputs
                            $('#target_input').val(row_id);
                            $('#discountInput').val(current_discount);
                            var pn = $('#row_'+row_id+' > td:nth-child(1)').text();
                            $('#discountModalLabel').html(`<small>ENTER ITEM DISCOUNT FOR</small> <strong>${pn}</strong>`);
                        } else {
                            bootbox.alert(data.validation);
                        }
                    },
                    error: function(data) {
                        bootbox.alert(data.responseText);
                    }
                });
            });
        });
        
        $('#discountModal').on('shown.bs.modal', function (e) {
            $('#discountInput').focus().select();
        });
        $('#discountModal').on('hidden.bs.modal', function (e) {
            $('#target_input').val("");
            $('#discountInput').val("");
            $('#discountModalLabel').html("ENTER ITEM DISCOUNT");
        });
        
        $('#clearInputsBtn').on('click',()=>{
            $('#discountInput').val("");
            setTimeout(()=>{
                $('#discountInput').focus().select();
            },100);
        });
        
        $(document).on('keypress','#discountInput',function(e){
           if(e.keyCode == 13){
               bootbox.confirm("Are you sure?", function(result) {
                    if (result == true) {
                        $('#saveDiscountBtn').click();
                    }else
                        setTimeout(()=>{
                            $('#discountInput').focus().select();
                        },100);
                });
           }
        });
        
        $('#saveDiscountBtn').on('click',()=>{
            
            var row_id  = $('#target_input').val();
            var product_price = parseFloat($('#pro_price_'+row_id).val());
            var enteredDiscount = $('#discountInput').val() !== '' ? $('#discountInput').val() : 0;
    
            var discount = 0;
    
            // Check if discount is a percentage or amount
            if(enteredDiscount != ""){
                if (enteredDiscount.indexOf("%") !== -1) { 
                    var e = enteredDiscount.split("%");
                    if (!isNaN(e[0])) {
                        discount = formatDecimal((product_price * parseFloat(e[0])) / 100);
                    } else {
                        discount = formatDecimal(enteredDiscount)
                    }
                } else {
                    discount = formatDecimal(enteredDiscount)
                }
            }
            
            /*validate discount*/
            if(discount > product_price){
                bootbox.alert("Discount is higher than product price!");
                return false;
            }
    
            // Assign calculated discount to relevant input elements
            $('#product_discount_'+row_id).val(enteredDiscount);
            $('#product_discount_amount_'+row_id).val(discount);
            
            if(discount > 0){
                $('#row_'+row_id).css('background','#ff8686');
                $('#row_'+row_id+' > td:nth-child(1) > button').html(""+enteredDiscount+" Dis");
            }
            else{
                $('#row_'+row_id).css('background','unset');
                $('#row_'+row_id+' > td:nth-child(1) > button').html('<i class="fa fa-percent"></i>');
            } 
            
            $('.rprice').change();
            $('#discountModal').modal('hide');
        });
        // Attach keyup event listener to the discount input field
        $('#discountInput').on('input', function() {
            // Get the value of the input field
            var enteredDiscount = $(this).val();
        
            // Regular expression to match valid discount inputs
            var discountRegex = /^(\d{1,2}(\.\d{1,2})?|100(\.0{1,2})?)%?$|^(\d+(\.\d{1,2})?)$/;
        
            // Test the discount input against the regex
            if (!discountRegex.test(enteredDiscount)) {
                // If the input is invalid, clear the input field
                $(this).val('');
            }
        });
        
        function gs(product_id, row_id){
            var location_id = $("#poswarehouse").val();
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
                    /*$('#balance_'+product_id).val(bal);*/
                    setTimeout(()=>{
                        checkValidity(row_id,bal);
                    },100);
                }
            });
        }
        function checkValidity(row_id,bal){
            $('#'+row_id+ ' > td:nth-child(1)').find('span').after(" ("+bal+")");
            /*if(accounting.unformat($('#quantity_'+product_id).val()) > accounting.unformat($('#balance_'+product_id).val())){
                $('[name^="row['+product_id+']"]').each(function() {
                    $(this).prop('disabled', true);
                });
            }else{
                $('[name^="row['+product_id+']"]').each(function() {
                    $(this).prop('disabled', false);
                });
            }*/
        }
        /**/
    </script>
</body>
</html>