<?php $this->load->view("common/header");
?>
<!-- end: HEAD -->
<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
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
    /*---loader*/
    .loader {
        border: 5px solid #FFFFFF;
        border-radius: 50%;
        border-top: 5px solid #666;
        width: 30px;
        height: 30px;
        -webkit-animation: spin 2s linear infinite;
        /* Safari */
        animation: spin 2s linear infinite;
    }
    .quick-cash {
        min-width: 80px;
        border-radius: 0px;
    }
    .quick-coin {
        min-width: 70px;
        border-radius: 50%;
    }
    input {
        text-align: center;
    }
    /* Safari */
    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
        }
    }
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    /**/
    .money_row{
        display: flex;
        align-items: center;
        justify-content: space-between;
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
                <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button"> <span class="fa fa-list"></span> </button>
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
                            <li> <a href="#"> Dashboard </a> </li>
                            <li> <a href="<?php echo base_url('sales'); ?>"> SHIFT START </a> </li>
                            <li class="active"> </li>
                            <li class="search-box">
                                <form class="sidebar-search">
                                    <div class="form-group">
                                        <input type="text" placeholder="Start Searching...">
                                        <button class="submit"> <i class="fa fa-search"></i> </button>
                                    </div>
                                </form>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- end: PAGE HEADER -->
                <!-- start: PAGE CONTENT 
                    <!-- start grid -->
                <div class="col-sm-3" style="">
                    <div class="form-group">
                        
                        <?php /* <select id="srh_warehouse_id" class="form-control" name="srh_warehouse_id">
                      <option value="">--Select Warehouse--</option>
                      <?php 
$ss_warehouse_id=$this->session->userdata('ss_warehouse_id'); 
foreach ($warehouse_list as $row){
$sel='';
if($ss_warehouse_id==$row->id)
{
	$sel=' selected="selected"';
}
?>
                      <option value="<?php echo $row->id; ?>" <?php echo $sel; ?>> <?php echo $row->name; ?> </option>
                      <?php }?>
                    </select> */ ?>
                    </div>
                </div>
                <form role="form" class="form-horizontal" id="cash_counter_form" method="post">
                    <div class="col-sm-3" style="display:none">
                        <div class="form-group">
                            <label>Date </label>
                            <input style="text-align:left" id="srh_from_date" name="srh_from_date" type='text' class="form-control date" value="" data-bv-field="date" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- start: DYNAMIC TABLE PANEL -->
                            <div class="panel panel-default" style="" >
                                <div class="panel-heading" id="scrollHere"> <i class="fa fa-plus"></i><label style="text-align: center;width: 100%;">SHIFT START</label></div>
                                <div class="panel-body">
                                    <div class="alert alert-danger" style="display:none;">
                                        <button class="close" data-dismiss="alert"> × </button>
                                        <i class="fa fa-times-circle"></i> <strong></strong> <span class="errortxt"></span>
                                    </div>
                                    <div class="alert alert-success" style="display:none;">
                                        <button class="close" data-dismiss="alert"> × </button>
                                        <i class="fa fa-check-circle"></i> <strong></strong><span class="succetxt"></span>
                                    </div>
                                    <div class="col-sm-6 panel panel-default" style="padding: 15px;display: flex;flex-direction: column;align-items: stretch;">
                                        <div class="money_row">
                                            <div>
                                                <button type="button" class="btn btn-lg btn-warning quick-cash">5000</button>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> x </label>
                                            </div>
                                            <div class="col-sm-3" >
                                                <input type="text" id="count-5000" class="form-control q_cash" name="count_5000" data-d-group="2" value="0" required>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> = </label>
                                            </div>
                                            <div class="col-sm-4" >
                                                <input readonly style="background-image:linear-gradient(to bottom, #f9f13f10 0%, #eceaf3 100%)" type="text" id="label-5000" class="form-control auto" name="label-5000" data-d-group="2" value="0.00">
                                            </div>
                                        </div>
                                        <div class="money_row">
                                            <div>
                                                <button type="button" class="btn btn-lg btn-warning quick-cash">1000</button>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> x </label>
                                            </div>
                                            <div class="col-sm-3" >
                                                <input type="text" id="count-1000" class="form-control q_cash" name="count_1000" data-d-group="2" value="0" required>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> = </label>
                                            </div>
                                            <div class="col-sm-4" >
                                                <input readonly style="background-image:linear-gradient(to bottom, #f9f13f10 0%, #eceaf3 100%)" type="text" id="label-1000" class="form-control auto" name="label-1000" data-d-group="2" value="0.00">
                                            </div>
                                        </div>
                                        <div class="money_row">
                                            <div>
                                                <button type="button" class="btn btn-lg btn-warning quick-cash">500</button>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> x </label>
                                            </div>
                                            <div class="col-sm-3" >
                                                <input type="text" id="count-500" class="form-control q_cash" name="count_500" data-d-group="2" value="0" required>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> = </label>
                                            </div>
                                            <div class="col-sm-4" >
                                                <input readonly style="background-image:linear-gradient(to bottom, #f9f13f10 0%, #eceaf3 100%)" type="text" id="label-500" class="form-control auto" name="label-500" data-d-group="2" value="0.00">
                                            </div>
                                        </div>
                                        <div class="money_row">
                                            <div>
                                                <button type="button" class="btn btn-lg btn-warning quick-cash">100</button>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> x </label>
                                            </div>
                                            <div class="col-sm-3" >
                                                <input type="text" id="count-100" class="form-control q_cash" name="count_100" data-d-group="2" value="0" required>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> = </label>
                                            </div>
                                            <div class="col-sm-4" >
                                                <input readonly style="background-image:linear-gradient(to bottom, #f9f13f10 0%, #eceaf3 100%)" type="text" id="label-100" class="form-control auto" name="label-100" data-d-group="2" value="0.00">
                                            </div>
                                        </div>
                                        <div class="money_row">
                                            <div>
                                                <button type="button" class="btn btn-lg btn-warning quick-cash">50</button>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> x </label>
                                            </div>
                                            <div class="col-sm-3" >
                                                <input type="text" id="count-50" class="form-control q_cash" name="count_50" data-d-group="2" value="0" required>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> = </label>
                                            </div>
                                            <div class="col-sm-4" >
                                                <input readonly style="background-image:linear-gradient(to bottom, #f9f13f10 0%, #eceaf3 100%)" type="text" id="label-50" class="form-control auto" name="label-50" data-d-group="2" value="0.00">
                                            </div>
                                        </div>
                                        <div class="money_row">
                                            <div>
                                                <button type="button" class="btn btn-lg btn-warning quick-cash">20</button>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> x </label>
                                            </div>
                                            <div class="col-sm-3" >
                                                <input type="text" id="count-20" class="form-control q_cash" name="count_20" data-d-group="2" value="0" required>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> = </label>
                                            </div>
                                            <div class="col-sm-4" >
                                                <input readonly style="background-image:linear-gradient(to bottom, #f9f13f10 0%, #eceaf3 100%)" type="text" id="label-20" class="form-control auto" name="label-20" data-d-group="2" value="0.00">
                                            </div>
                                        </div>
                                        <div class="money_row">
                                            <div>
                                                <button type="button" class="btn btn-lg btn-warning quick-cash">10</button>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> x </label>
                                            </div>
                                            <div class="col-sm-3" >
                                                <input type="text" id="count-10" class="form-control q_cash" name="count_10" data-d-group="2" value="0" required>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> = </label>
                                            </div>
                                            <div class="col-sm-4" >
                                                <input readonly style="background-image:linear-gradient(to bottom, #f9f13f10 0%, #eceaf3 100%)" type="text" id="label-10" class="form-control auto" name="label-10" data-d-group="2" value="0.00">
                                            </div>
                                        </div>
                                        <div class="money_row">
                                            <div>
                                                <button type="button" class="btn btn-lg btn-info quick-coin">10</button>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> x </label>
                                            </div>
                                            <div class="col-sm-3" >
                                                <input type="text" id="count-10-c" class="form-control q_cash" name="count_10_c" data-d-group="2" value="0" required>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> = </label>
                                            </div>
                                            <div class="col-sm-4" >
                                                <input readonly style="background-image:linear-gradient(to bottom, #f9f13f10 0%, #eceaf3 100%)" type="text" id="label-10-c" class="form-control auto" name="label-10-c" data-d-group="2" value="0.00">
                                            </div>
                                        </div>
                                        <div class="money_row">
                                            <div>
                                                <button type="button" class="btn btn-lg btn-info quick-coin">5</button>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> x </label>
                                            </div>
                                            <div class="col-sm-3" >
                                                <input type="text" id="count-5-c" class="form-control q_cash" name="count_5" data-d-group="2" value="0" required>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> = </label>
                                            </div>
                                            <div class="col-sm-4" >
                                                <input readonly style="background-image:linear-gradient(to bottom, #f9f13f10 0%, #eceaf3 100%)" type="text" id="label-5-c" class="form-control auto" name="label-5-c" data-d-group="2" value="0.00">
                                            </div>
                                        </div>
                                        <div class="money_row">
                                            <div>
                                                <button type="button" class="btn btn-lg btn-info quick-coin">2</button>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> x </label>
                                            </div>
                                            <div class="col-sm-3" >
                                                <input type="text" id="count-2-c" class="form-control q_cash" name="count_2" data-d-group="2" value="0" required>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> = </label>
                                            </div>
                                            <div class="col-sm-4" >
                                                <input readonly style="background-image:linear-gradient(to bottom, #f9f13f10 0%, #eceaf3 100%)" type="text" id="label-2-c" class="form-control auto" name="label-2-c" data-d-group="2" value="0.00">
                                            </div>
                                        </div>
                                        <div class="money_row">
                                            <div>
                                                <button type="button" class="btn btn-lg btn-info quick-coin">1</button>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> x </label>
                                            </div>
                                            <div class="col-sm-3" >
                                                <input type="text" id="count-1-c" class="form-control q_cash" name="count_1" data-d-group="2" value="0" required>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> = </label>
                                            </div>
                                            <div class="col-sm-4" >
                                                <input readonly style="background-image:linear-gradient(to bottom, #f9f13f10 0%, #eceaf3 100%)" type="text" id="label-1-c" class="form-control auto" name="label-1-c" data-d-group="2" value="0.00">
                                            </div>
                                        </div>
                                        <div class="money_row" style="border-top:#CCC solid 1px;">
                                            <div>
                                                <label class="fa-2x"></label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="fa-2x" style="float:right"> Cash in hand </label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="fa-2x"> = </label>
                                            </div>
                                            <div class="col-sm-4" >
                                                <input readonly style="background-image:linear-gradient(to bottom, #f9f13f10 0%, #eceaf3 100%)" type="text" id="label-cash_in_hand" class="form-control auto" name="acctrnss_amount" data-d-group="2" value="0.00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- input values start-->
                                        <div class="form-group">
                                            <h5> Date *</h5>
                                            <input id="acctrnss_date" name="acctrnss_date" type='text' class="form-control date" value="" />
                                        </div>
                                        <div class="form-group">
                                            <h5>Details</h5>
                                            <textarea type="text" class="form-control" name="acctrnss_details" id="acctrnss_details"></textarea>
                                        </div>
                                        <div class="form-group" style="display:none">
                                            <label class="col-sm-6 control-label" for="balance"> Final Balance </label>
                                            <div class="col-sm-6">
                                                <input type="text" id="balance" class="form-control auto" name="balance" data-a-sign="Rs. " data-d-group="2" value="0.00" readonly>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group" style="display:none">
                                            <label class="col-sm-6 control-label" for="remarks"> Variance </label>
                                            <div class="col-sm-6">fxd_ass_id
                                                <input type="text" id="differance" class="form-control auto" name="differance" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display:none">
                                            <label class="col-sm-6 control-label" for="remarks"> Remarks </label>
                                            <div class="col-sm-6">
                                                <input type="text" id="remarks" class="form-control auto" name="remarks">
                                            </div>
                                        </div>
                                        <input name="warehouse_id" type="hidden" id="warehouse_id" value="<?php echo $this->session->userdata('ss_warehouse_id'); ?>">
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div class="modal-footer" style="margin-bottom:10px;">
                                        <button type="submit" class="btn btn-primary" name="" id=""> SHIFT START </button>
                                        <button class="btn btn-danger" type="reset">Reset</button>
                                    </div>
                                </div>
                                
                                <!--col-md-12--><!--col-md-8-->
                                <!-- item add box-->
                                <input name="cash_in_hand" type="hidden" id="cash_in_hand" value="0" />
                                <input readonly type="hidden" id="etp_id" name="etp_id" value="0">
                                <input readonly type="hidden" id="type" name="type" value="A">
                                <input readonly type="hidden" id="fa_type_id" name="fa_type_id" value="0">
                                <input readonly type="hidden" id="fxd_ass_id" name="fxd_ass_id" value="4">
                                <!-- end: DYNAMIC TABLE PANEL -->
                                <!-- footer amount details --><!-- end footer amount details -->
                            </div>
                        </div>
                        <!-- end grid -->
                    </div>
                    <!-- end: PAGE -->
            </div>
            </form>
            <!-- end: MAIN CONTAINER -->
        </div>
    </div>
    </div>
    <!-- start: FOOTER -->
    <!-- end: FOOTER -->
    <!-- start: RIGHT SIDEBAR -->
    <!-- end: RIGHT SIDEBAR -->
    <div id="event-management" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                    <h4 class="modal-title">Event Management</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-light-grey"> Close </button>
                    <button type="button" class="btn btn-danger remove-event no-display"> <i class='fa fa-trash-o'></i> Delete Event </button>
                    <button type='submit' class='btn btn-success save-event'> <i class='fa fa-check'></i> Save </button>
                </div>
            </div>
        </div>
    </div>
    <!-- start ajax model -->
    <div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
    <!-- end ajax model -->
    <!-- start: MAIN JAVASCRIPTS -->
    <?php $this->load->view("common/footer"); ?>
    <script src="<?php echo asset_url(); ?>js/jquery-ui.js"></script>
    <script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
    <!--<script type="text/javascript" src="<?php echo asset_url(); ?>js/autoNumeric.js"></script> -->
    <!-- end: MAIN JAVASCRIPTS -->
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
    <?php /*?><script src="<?php echo asset_url(); ?>js/form-validation-create_sales.js"></script><?php */ ?>
    <?php /*?><script src="<?php echo asset_url(); ?>js/cash.js"></script><?php */ ?>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
    <script>
        var recieved_amount = 0;
        var sales_total = 0;
        var service = 0;
        var return_total = 0;
        var expences = 0;
        var balance = 0;
        $(document).ready(function(e) {
            //$('.auto').autoNumeric('init');
            $('#acctrnss_date').datetimepicker({
                defaultDate: new Date(),
                format: "YYYY-MM-DD"
            });
        });
        $(document).keypress(function(e) {
            if (e.keyCode == 13) e.preventDefault();
            if (isNaN(e.key))
                if (e.target.id != 'remarks') e.preventDefault();
            //if(e.keyCode == 0)if(e.target.id != 'remarks')e.preventDefault();
        });
        $('input').focus(function() {
            this.select
        });
        $('input').click(function() {
            this.select()
        });
        $('input').change(function(event) {
            var id = event.target.id;
            console.log('Changed Element ID :' + event.target.id);
            console.log('Recieved amount :' + recieved_amount);
            //cash bill calculate start		
            var coin;
            if (~id.indexOf("-c")) coin = '-c';
            else coin = '';
            //console.log(event);
            //console.log('ID :'+event.target.id);
            var str_1 = id.replace("count-", "");
            var str_2 = str_1.replace("-c", "");
            //console.log(str_2);
            var cash_value = parseInt(str_2);
            //console.log('CASH :'+cash_value);
            var count = parseInt(event.currentTarget.value);
            //console.log('COUNT :'+count);
            var value = cash_value * count;
            //console.log('VALUE :'+value);
            var target = '#label-' + cash_value + coin;
            //console.log(target);
            $(target).val(accounting.formatMoney(value, "", 2, ",", "."));
            //console.log(parseFloat($(target).val().replace(/,/g, "")));
            //var got_val = parseFloat($(target).val().replace(/,/g, ""));
            //end
            cash_in_hand();
        });
        function cash_in_hand() {
            var total = 0;
            for (c = 5000; c > 0; c--) {
                if (c > 10) {
                    var target = $('#label-' + c).val();
                    if (target) {
                        //console.log(target);
                        target = target.replace("Rs. ", "");
                        total += parseFloat(target.replace(/,/g, ""));
                    } else continue;
                }
                if (c == 10) {
                    var target_1 = $('#label-' + c).val();
                    target_1 = target_1.replace("Rs. ", "");
                    var target_2 = $('#label-' + c + '-c').val();
                    target_2 = target_2.replace("Rs. ", "");
                    total += parseFloat(target_1.replace(/,/g, ""));
                    total += parseFloat(target_2.replace(/,/g, ""));
                } else {
                    var target = $('#label-' + c + '-c').val();
                    if (target)
                        total += parseFloat(target.replace(/,/g, ""));
                    else continue;
                }
            }
            $('#label-cash_in_hand').val(accounting.formatMoney(total, '', 2, ',', '.'));
            $('#cash_in_hand').val(total);
            console.log('Cash in Hand :' + total);
            //balance
            var balance = recieved_amount + sales_total + service - return_total - expences;
            $('#balance').val('Rs. ' + accounting.formatMoney(balance, '', 2, ',', '.'));
            //differance
            var differance = balance - total;
            $('#differance').val(accounting.formatMoney(parseInt(differance), '', 2, ',', '.'));
            //differance
        }
        $(document).on('submit', function() {
            var fields = $("#cash_counter_form").serialize();
            var rowCount = 1;
            if (rowCount != 0) {
                $("#add_sale").prop("disabled", true);
                $("#add_sale").html('Please wait... <i class="fa fa-spinner fa-spin"></i>');
                // create_sales_form.add_sale.disabled = true;
                // create_sales_form.add_sale.value = "Please wait...";
                //	return true;
                //alert(fields);
                //type:type, sale_reference_no:sale_reference_no
                //return false;
                $.post("<?php echo base_url(); ?>cash_balance/save_cash_float_open", fields)
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
                            //	window.scrollTo(500, 0);
                            //$("#soTable tr:gt(0)").remove();
                            $("#soTable > tbody").empty();
                            displayNotice('page', 'Saved Successfully!');
                            //alert(obj.sale_id);
                            //	sendUrl='cash_balance/view/'+obj.sale_id;
                            sendUrl = 'posplus/app';
                            //
                            //alert(sendUrl);
                            // 	/cash_balance
                            //print_transactions(obj.lastid);
                            //alert();
                            window.location.href = "<?php echo base_url(); ?>" + sendUrl;
                        }
                    });
                return false;
            } else {
                bootbox.alert('Please add products.', function() {
                    $('#add_item').focus();
                });
            }
        });
    </script>
</body>
<!-- end: BODY -->
</html>