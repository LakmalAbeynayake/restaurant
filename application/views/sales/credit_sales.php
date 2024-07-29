<?php
$this->load->view("common/header");
?>
<!-- end: HEAD -->
<?php
$tmp_id = 0;
?>
<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<style type="text/css">
    label {
        font-weight: 700;
    }
    .form-horizontal .form-group {
        margin-left: 0;
        margin-right: 0;
    }
    td {
        vertical-align: text-top;
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
                <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button"> <span class="clip-list-2"></span> </button>
                <!-- end: RESPONSIVE MENU TOGGLER -->
                <!-- start: LOGO -->
                <?php
                $this->load->view("common/logo");
                ?>
                <!-- end: LOGO -->
            </div>
            <div class="navbar-tools">
                <!-- start: TOP NAVIGATION MENU -->
                <?php
                $this->load->view("common/notifications.php");
                ?>
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
            <?php
            $this->load->view("common/navigation");
            ?>
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
                            <li> <a href="<?php echo base_url('sales2?s=' . rand()); ?>"> Credit Invoice Settlement </a> </li>
                            <li class="active"> Customer Payment </li>
                            <li class="search-box">
                                <form class="sidebar-search">
                                    <div class="form-group">
                                        <input type="text" placeholder="Start Searching...">
                                        <button class="submit"> <i class="clip-search-3"></i> </button>
                                    </div>
                                </form>
                            </li>
                        </ol>
                        <div class="page-header">
                            <h1> Staff Invoice Settlement</h1>
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
                            <div class="panel-heading"> <i class="fa fa-plus"></i> Staff meal Payment </div>
                            <div class="panel-body">
                                <div class="alert alert-danger" style="display:none;">
                                    <button class="close" data-dismiss="alert"> × </button>
                                    <i class="fa fa-times-circle"></i> <strong></strong> <span class="errortxt"></span>
                                </div>
                                <div class="alert alert-success" style="display:none;">
                                    <button class="close" data-dismiss="alert"> × </button>
                                    <i class="fa fa-check-circle"></i> <strong></strong><span class="succetxt"></span>
                                </div>
                                <form role="form" class="form-horizontal" id="create_collection_form" action="#" method="post">
                                    <div class="col-md-12"></div>
                                    <!--col-md-12-->
                                    <!-- start payments-->
                                    <div class="col-md-12">
                                        <div class="well well-sm" id="filters_panel">
                                            <div class="row">
                                                <!--<div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label>Customer Type</label>
                                                        <select id="srh_cus_type_id" class="form-control search-select" name="srh_cus_type_id" onchange="loadGrid()">
                                                            <option value=""> -All- </option>
                                                            <option value="1"> Regular </option>
                                                            <option value="2"> Staff </option>
                                                            <option value="3"> Special </option>
                                                        </select>
                                                    </div>
                                                </div>-->
                                                <div class="col-sm-2">
                                                        <label>Location * </label>
                                                        <select id="warehouse_id" class="form-control search-select" name="warehouse_id"  onChange="change_filters()">
                                                            <!--<option value="">-- Select Warehouse --</option>-->
                                                            <?php
                                                            $ss_warehouse_id = $location_id ? $location_id : $this->session->userdata('ss_warehouse_id');
                                                            foreach ($warehouse_list as $row) {
                                                                $sel  = '';
                                                                $hide = '';
                                                                if ($ss_warehouse_id == $row->id) {
                                                                    $sel = ' selected="selected"';
                                                                }
                                                            ?>
                                                                <option <?php echo $sel, $hide;?> value="<?php echo $row->id;?>">
                                                                    <?php
                                                                    echo $row->name;
                                                                    ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label for="month">Month of <?php echo date("Y"); ?> * </label>
                                                        <select id="month" class="form-control search-select" name="month" onChange="change_filters()">
                                                            <option value="">-- Select Month --</option>
                                                            <option value="1">January</option>
                                                            <option value="2">February</option>
                                                            <option value="3">March</option>
                                                            <option value="4">April</option>
                                                            <option value="5">May</option>
                                                            <option value="6">June</option>
                                                            <option value="7">July</option>
                                                            <option value="8">August</option>
                                                            <option value="9">September</option>
                                                            <option value="10">October</option>
                                                            <option value="11">November</option>
                                                            <option value="12">December</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label for="customer_type">Customer Type *</label>
                                                        <select id="customer_type" class="form-control search-select" onChange="change_filters()">
                                                            <!--<option value="">-- All --</option>-->
                                                            <option value="1">Regular</option>
                                                            <option value="2" selected>Staff</option>
                                                            <option value="3">Special</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                 
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label for="customer_id">Customer </label>
                                                        <?php //echo "cus id".$customer_id ?>
                                                        <select id="customer_id" class="form-control search-select" name="customer_id" onChange="change_filters()">
                                                            <option value="">-- All --</option>
                                                            <?php foreach ($customer_list as $row) { ?>
                                                                <option <?php
                                                                        if ($row['cus_id'] == $customer_id) echo 'selected'; ?> value="<?php echo $row['cus_id']; ?>">
                                                                    <?php echo $row['cus_name']; if ($row['cus_phone']) echo " / " . $row['cus_phone']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label for="customers_except">Customers Except</label>
                                                        <div style="overflow: auto;height: 100px;">
                                                            <select id="customers_except" class="form-control" name="customers_except[]" multiple style="width:100%;" onChange="change_filters()"> <!---->
                                                                <?php 
                                                                $customers_except_mapped = array();
                                                                foreach($customers_except as $mp)
                                                                    $customers_except_mapped[$mp] = $mp;
                                                                foreach ($customer_list as $row) { ?>
                                                                    <option <?php if (isset($customers_except_mapped[$row['cus_id']])) echo 'selected'; ?> value="<?php echo $row['cus_id']; ?>"> <?php echo $row['cus_name']; if ($row['cus_phone']) echo " / " . $row['cus_phone']; ?> </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                <?php /*if($customer_id){ ?>
                                                <?php }*/ ?>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        Total Credit Amount : <span class="form-control text-right" id="credit_amount"style="color: red;font-weight: bold;font-size: 16px;"></span>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="well well-sm">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Payment Date</label>
                                                        <input id="sale_pymnt_date_time" name="sale_pymnt_date_time" type='text' class="form-control date-time" value="<?php echo date("Y-m-d H:i:s"); ?>" data-bv-field="date" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="payment">
                                                        <div class="form-group">
                                                            <label for="sale_pymnt_paying_by">Paying by</label>
                                                            <select class="form-control paid_by" id="sale_pymnt_paying_by" name="sale_pymnt_paying_by" data-bv-field="paid_by" tabindex="-1" title="Paying by *" onChange="changePayingby(this.value)">
                                                                <option value="salary">Salary</option>
                                                                <option value="cash">Cash</option>
                                                                <option value="visa">Visa</option>
                                                                <option value="master">Master</option>
                                                                <option value="ceft">Online Payment</option>
                                                                <option value="donation">Donation</option>
                                                                <!--<option value="Cheque">Cheque</option>
                                                                <option value="Return_Cash">Return Cash</option>-->
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="payment">
                                                        <div class="form-group">
                                                            <label for="sale_pymnt_amount">Amount *</label>
                                                            <input readonly type="text" class="pa form-control kb-pad amount" id="sale_pymnt_amount" name="sale_pymnt_amount" value="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- payment options start-->
                                                <div class="clearfix"></div>
                                                <div id="cheque_dtls" style="display:none;" class="paying_by_details col-sm-12">
                                                    <label for="sale_pymnt_cheque_no">Cheque No *</label>
                                                    <input type="text" id="sale_pymnt_cheque_no" class="form-control" value="" name="sale_pymnt_cheque_no">
                                                </div>
                                                <!--cheque-->
                                                <div id="credit_card" style="display:none;" class="paying_by_details">
                                                    <div class="col-sm-5">
                                                        <div class="form-group">
                                                            <input type="text" id="sale_pymnt_crdt_card_no" class="form-control tip" value="" name="sale_pymnt_crdt_card_no" placeholder="Credit Card No *">
                                                        </div>
                                                    </div>
                                                    <!--col-sm-5-->
                                                    <div class="col-sm-5 pull-right">
                                                        <div class="form-group">
                                                            <input type="text" id="sale_pymnt_crdt_card_holder_name" class="form-control tip" value="" name="sale_pymnt_crdt_card_holder_name" placeholder="Holder Name *">
                                                        </div>
                                                    </div>
                                                    <!--col-sm-3-->
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <input type="text" id="sale_pymnt_crdt_card_month" class="form-control tip" value="" name="sale_pymnt_crdt_card_month" placeholder="Month *">
                                                        </div>
                                                    </div>
                                                    <!--col-sm-3-->
                                                    <div class="col-sm-3 pull-right">
                                                        <div class="form-group">
                                                            <input type="text" id="sale_pymnt_crdt_card_year" class="form-control tip" value="" name="sale_pymnt_crdt_card_year" placeholder="Year *">
                                                        </div>
                                                    </div>
                                                    <!--col-sm-3-->
                                                </div>
                                                <!--credit_card-->
                                                <div class="clearfix"></div>
                                                <!-- end payment optiones -->
                                                <div id="note_grid" class="form-group">
                                                    <div class="col-sm-12">
                                                        <label class="control-label"> Note </label>
                                                        <textarea id="sale_note" class="ckeditor form-control" cols="10" rows="2" name="sale_note"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($customer_id){ ?>
                                        <?php } ?>
                                    </div>
                                    <!-- end payments-->
                                    
                                    <!--col-md-8-->
                                    <!-- item add box-->
                                    <div id="sticker" class="col-md-12">
                                        <div class="well well-sm">
                                            <div class="form-group">
                                                <!-- auto complete start -->
                                                <div class="input-group wide-tip" style="display:none">
                                                    <div style="padding-left: 10px; padding-right: 10px;" class="input-group-addon"> <i class="fa fa-2x fa-barcode addIcon"></i> </div>
                                                    <input type="text" placeholder="Please add products to order list" id="add_item" class="form-control input-lg" value="" name="add_item" style="border-radius: 6px;font-size: 18px;height: 46px;line-height: 1.33;padding: 10px 16px;">
                                                    <!--<div style="padding-left: 10px; padding-right: 10px;" class="input-group-addon">
                                                            <i id="addIcon" class="fa fa-2x fa-plus-circle addIcon"></i>
                                                        </div>-->
                                                </div>
                                                <!-- end auto complete end -->
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="control-group table-group">
                                                <p id="loader" align="center" style="display:none">Loading...<i class="fa fa-spin fa-spinner"></i></p>
                                                <div class="controls table-controls">
                                                    <!--<pre>
                                                        <?php print_r($sales_list);?>
                                                    </pre>-->
                                                    <table class="table items table-striped table-bordered table-condensed table-hover" id="cash_collect">
                                                        <thead>
                                                            <tr>
                                                                <th class="">No.</th>
                                                                <th class="col-md-2">Customer</th>
                                                                <th class="col-md-2">Invoice No</th>
                                                                <th class="col-md-1">Invoice Date</th>
                                                                <th class="col-md-1">Total Amount</th>
                                                                <th class="col-md-1">Paid Amount</th>
                                                                <th class="col-md-1">Balance Amount</th>
                                                                <th class="col-md-1"> 
                                                                    <label for="select_all">Select All</label>
                                                                    <input type="checkbox" id="select_all" />
                                                                </th>
                                                                <th class="col-md-1">Paying Amount</th>
                                                                <th style="width: 30px !important; text-align: center;"><i class="fa fa-trash-o"></i></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $tmpcount = 0;
                                                            $tmptot   = 0;
                                                            foreach ($sales_list as $row) {
                                                                //if ($tmpcount > 15) break;
                                                                $balance_amount   = 0;
                                                                $sale_tot_amount  = 0;
                                                                $sale_id          = $row->sale_id;
                                                                //$sale_info        = $this->Sales_Model->get_sale_info($sale_id);
                                                                $sale_tot_amount  = $row->sale_total; //$sale_info['sale_total'];
                                                                $sale_paid_amount = $row->total_paid; //$this->Sales_Model->get_total_paid_by_sale_id($sale_id);
                                                                $balance_amount   = $sale_tot_amount - $sale_paid_amount;
                                                                $balance_amount   = (float) $balance_amount;
                                                                //check allredy added 
                                                                
                                                                if ($balance_amount > 0) {
                                                                    $tmpcount++;
                                                            ?>
                                                                    <tr id="row_c_<?php echo $tmpcount; ?>" data-id="<?php echo $tmpcount; ?>">
                                                                        <td class="text-center"><?php echo $tmpcount; ?></td>
                                                                        <td class="text-center"><?php echo $row->cus_name ?></td>
                                                                        <td class="text-center"><?php echo $row->sale_id; ?>
                                                                            <input style="text-align:right" name="row_c[<?php echo $tmpcount; ?>][sale_id]" type="hidden" id="sale_id_<?php echo $tmpcount; ?>" value="<?php echo $row->sale_id; ?>">
                                                                        </td>
                                                                        <td class="text-left"><?php $phpdate = strtotime($row->sale_datetime); echo date('Y-m-d', $phpdate); ?></td>
                                                                        <td class="text-right"><?php echo $row->sale_total; ?></td>
                                                                        <td class="text-right"><?php //echo $row->paid_amount; ?>
                                                                            <?php echo $sale_paid_amount; ?></td>
                                                                        <td class="text-left"><?php //echo $balance_amount; ?>
                                                                            <input style="text-align:right" readonly name="balance_amount" type="text" id="balance_amount_<?php echo $tmpcount; ?>" value="<?php echo $balance_amount; ?>">
                                                                        </td>
                                                                        <td class="text-left">
                                                                            <label style="display: flex;align-items: center;flex-direction: row;justify-content: space-evenly;" class="form-control" for="collection_c_<?php echo $tmpcount;?>">Collect <input row_n="<?php echo $tmpcount; ?>" class="checkbox" id="collection_c_<?php echo $tmpcount;?>" name="row_c[<?php echo $tmpcount; ?>][collection]" value="1" type="checkbox"></label>
                                                                        </td>
                                                                        <td class="text-left"><input value="0" id="amount_<?php echo $tmpcount; ?>" name="row_c[<?php echo $tmpcount; ?>][amount]" class="added_amount" type="text" style="text-align:right" onClick="this.select(); setTmpVal(this.value);" onChange="changeAmount(<?php echo $tmpcount; ?>)"></td>
                                                                        <!-- -->
                                                                        <td><a onClick="deleteCollectCashItem(<?php echo $tmpcount; ?>)"><i style="cursor:pointer;" title="Remove" id="1446800197032" class="fa fa-times tip podel"></i></a></td>
                                                                    </tr>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="7" class="text-right"><strong>Total Amount </strong></td>
                                                                <td class="text-right">
                                                                    <div id="tot_amount_div" style="font-weight:bold">0.00</div>
                                                                    <input name="smp_amount" type="hidden" id="smp_amount" value="0">
                                                                </td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="modal-footer" style="margin-bottom:10px;">
                                            <?php if($customer_id){ ?>
                                            <?php } ?>
                                                <input type="submit" class="btn btn-primary" value="Add Payments" name="add_payments" id="add_payments" onClick="insertPaymentsData();">
                                            <button id="reset" class="btn btn-danger" type="button">Reset</button>
                                        </div>
                                    </div>
                                    <input name="sale_inv_discount_amount" type="hidden" id="sale_inv_discount_amount" value="0">
                                    <input name="sale_total" type="hidden" id="sale_total" value="0">
                                    <input name="sale_paid" type="hidden" id="sale_paid" value="0">
                                    <input name="sale_balance" type="hidden" id="sale_balance" value="0">
                                    <input name="rowCount" type="hidden" id="rowCount" value="<?php echo $tmpcount; ?>">
                                    <input name="cost_total" type="hidden" id="cost_total" value="0">
                                    <input name="cus_credit_limit" type="hidden" id="cus_credit_limit" value="0">
                                    <input name="base_url" type="hidden" id="base_url" value="<?php echo base_url(); ?>">
                                    <input name="full_amount" type="hidden" id="full_amount">
                                </form>
                                <input name="" type="hidden" id="tmpVal">
                                <!-- end: DYNAMIC TABLE PANEL -->
                                <!-- footer amount details -->
                                <div style="margin-bottom: 0px; position: fixed; bottom: 0px; width: 1082px; z-index: 50000;" class="well well-sm" id="bottom-total">
                                    <table style="margin-bottom:0;" class="table table-bordered table-condensed totals">
                                        <tbody>
                                            <tr class="warning">
                                                <td class="credit_limit_td_class" style="float:right">Total Paying Amount :&nbsp;<span style="min-width:70px; text-align:right" id="total_amount-txt" class="credit_limit_val pull-right">0.00</span></td>
                                                <!--<td class="credit_limit_td_class" style="float:right">Available Amount :&nbsp;<span style="min-width:70px; text-align:right" id="avl_amount-txt" class="credit_limit_val pull-right">0.00</span></td>-->
                                                <td class="credit_limit_td_class" style="float:right">
                                                    Total Credit Amount :
                                                    <span style="min-width:70px; text-align:right" id="customer_balance" class="credit_limit_val pull-right">0.00</span>
                                                </td>
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
        <div class="footer-items"> <span class="go-top"><i class="clip-chevron-up"></i></span> </div>
    </div>
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
    <input name="tmpVal" type="hidden" id="tmpVal" value="0">
    <input name="" id="type_sale" type="hidden" value="22">
    <!-- start ajax model -->
    <div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
    <!-- end ajax model -->
    <a id="modal_ajax_serial_no" data-toggle="modal" href="#"></a> <a id="modal_ajax_serial_no_view" data-toggle="modal" href="#"></a>
    <input name="" type="hidden" id="curr_row_no" value="0">
    <!-- start: MAIN JAVASCRIPTS -->
    <?php
    $this->load->view("common/footer");
    ?>
    <!--<script type="text/javascript" src="<?php echo asset_url();?>js/accounting.js"></script>-->
    <script type="text/javascript" src="<?php echo asset_url();?>js/accounting.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
    <!--<script src="<?php
                        echo asset_url();
                        ?>js/collect_cash.js"></script>-->
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
    <script>
    $(document).ready(function(){
        cus_balance();
        selectValue("month",<?php echo $month ?>); 
        selectValue("customer_type",<?php echo $customer_type ?>); 
    });
        $("#checkAll").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        $('.checkbox').bind('change', function(e) {
            if (!e.target.checked) {
                var id_num;
                var str = e.target.name;
                if (str) {
                    str = str.replace('row_c[', '');
                    str = str.replace('][collection]', '');
                    id_num = str;
                }
                $('#amount_' + id_num).val('0');
                calculateTotalAmount();
            } else {
                var arr = $('.added_amount'),
                    sum = 0;
                $.each(arr, function() {
                    sum += parseFloat($('#' + this.id).val()) || 0;
                });
                var id_num;
                var str = e.target.name;
                if (str) {
                    str = str.replace('row_c[', '');
                    str = str.replace('][collection]', '');
                    id_num = str;
                }
                var has_to_pay = $('#balance_amount_' + id_num).val();
                $('#amount_' + id_num).val(has_to_pay);
                calculateTotalAmount();
            }
            if (false == $(this).prop("checked")) {
                $("#select_all").prop('checked', false);
            }
            if ($('.checkbox:checked').length == $('.checkbox').length) {
                $("#select_all").prop('checked', true);
            }
        });
        $('input:text').click(function() {
            this.select();
        });
        function cus_balance(){
            var sum = 0;

            $('#cash_collect > tbody > tr').each(function(a,b) {
                var id = $(b).data('id');
                var has_to_pay = $('#balance_amount_' + id).val();
                sum += parseFloat(has_to_pay);
            });

            $('#credit_amount').text(convertToAmount(sum));
            $('#customer_balance').text(sum);
        }
        $("#select_all").change(function(e) {
            if (e.target.checked) {
                var sum = 0;
                $('#cash_collect > tbody > tr').each(function(a,b) {
                    var id = $(b).data('id');
                    var has_to_pay = $('#balance_amount_' + id).val();
                    $('#amount_' + id).val(has_to_pay);
                    $('#collection_c_' + id).prop('checked', true);
                });
                calculateTotalAmount();
            } else {
                $('#cash_collect > tbody > tr').each(function(a,b) {
                    var id = $(b).data('id');
                    $('#amount_' + id).val(0);
                    $('#collection_c_' + id).prop('checked', false);
                });
                calculateTotalAmount();
            }
        });
        function calculateTotalAmount() {
            var sum = 0;
            $('#cash_collect > tbody > tr').each(function(a,b) {
                var id = $(b).data('id');
                var has_to_pay = $('#amount_' + id).val();
                sum += parseFloat(has_to_pay);
            });

            $('#sale_pymnt_amount').val(sum);
            $('#tot_amount_div').text(convertToAmount(sum));
            $('#total_amount-txt').text(convertToAmount(sum));
        }
        function convertToAmount(val) {
            var disval = val;
            return accounting.formatMoney(disval, "", 2, ",", ".");
        }
        function convertToAmount2Des(val) {
            var disval = val;
            return accounting.formatMoney(disval, "", 2, "", ".");
        }
        function changeAmount(row) {
            var collection_fld = "#collection_c_" + row;
            var amount_fld = "#amount_" + row;
            var amount_val = parseFloat($(amount_fld).val());
            if (amount_val) {
                var pay_amount = $('#sale_pymnt_amount').val();
                var arr = $('.added_amount'),
                    sum = 0;
                $.each(arr, function() {
                    sum += parseFloat(this.value) || 0;
                });
                sum -= amount_val;
                var has_to_pay = amount_val;
                var balance_to_continue = pay_amount - sum;
                if (balance_to_continue >= has_to_pay) {
                    $(collection_fld).prop("checked", true);
                } else {
                    $(collection_fld).prop("checked", false);
                    $(amount_fld).val('0');
                }
            } else {
                $(collection_fld).prop("checked", false);
            }
            calculateTotalAmount();
        }
        $("form").submit(function(e) {
            return false;
        });
        function insertPaymentsData() {
            $('body').modalmanager('loading');
            $("#add_payments").val('Please wait...');
            $("#filters_panel").css('display','none');
            $("#add_payments").prop("disabled", true);
            calculateTotalAmount();
            setTimeout(function() {
                var fields = $("#create_collection_form").serialize();
                var rowCount = $('input[type="checkbox"]:checked').length;
                var customer_id = accounting.unformat($('#tot_amount_div').text());
                var smp_amount = $('#smp_amount').val();
                if (!customer_id > 0) {
                    bootbox.alert('No selected invoices!', function() {});
                    $("#add_payments").prop("disabled", false);
                    $("#add_payments").val('Re try');
                } else if (!smp_amount) {
                    bootbox.alert('Please select pending invoice', function() {
                        $('#add_item').focus();
                    });
                    $("#add_payments").prop("disabled", false);
                    $("#add_payments").val('Re try');
                } else if (rowCount != 0) {
                    $.post("<?php echo base_url(); ?>sales/save_batch_payments", fields).done(function(data) {
                        var obj = jQuery.parseJSON(data);
                        if (obj.error == 1) {
                            $('.alert-success').hide();
                            $('.alert-danger').show();
                            $(".errortxt").text(obj.disMsg);
                            window.scrollTo(500, 0);
                        }
                        if (obj.error == 0) {
                            window.scrollTo(500, 0);
                            $("#cash_collect > tbody").empty();
                            displayNotice('page', 'Payments successfully added!');
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        }
                    });
                    return false;
                } else {
                    bootbox.alert('Please select invocies', function() {
                        $('#add_item').focus();
                    });
                }
            }, 1000);
        }
        function change_filters() {
            var val = $('#customer_id').val();
            var lo = $('#warehouse_id').val();
            var mo = $('#month').val();
            var ct = $('#customer_type').val();
            var ce = $('#customers_except').val();
            $('body').modalmanager('loading');
            sendUrl = 'sales/credit_sales/' + val+'?li='+lo+'&mo='+mo+'&ct='+ct+'&ce='+ce;
            location.href = "<?php echo base_url();?>" + sendUrl;
        }
        function deleteCollectCashItem(row_id) {
            var val = '#row_c_' + row_id;
            $(val).remove();
        }
        $(document).ajaxStart(function() {
            $('#loader').show('fast');
        });
        $(document).ajaxStop(function() {
            $('#loader').hide('fast');
        });
        function setTmpVal(val) {
            $('#tmpVal').val(val);
        }
        function changePayingby(val) {
            $('.paying_by_details').hide();
            if (val == 'Credit Card') {
                $('#credit_card').show();
            }
            if (val == 'Cheque') {
                $('#cheque_dtls').show();
            }
        }
        function selectValue(elem,valueToSelect) {
            var selectElement = document.getElementById(elem);
            $(selectElement).val(valueToSelect);
        }
        
        $(document).ready(function() {
            $('#customers_except').select2({
                placeholder: "Select customers to filter out",
                /*tags: true*/
            });
        });
    </script>
</body>
<!-- end: BODY -->
</html>