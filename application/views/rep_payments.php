<?php $this->load->view("common/header"); ?>
<!-- end: HEAD -->


<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" type="text/css" />
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal.css" type="text/css" />
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/jQuery-Tags-Input/jquery.tagsinput.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/summernote/build/summernote.css">


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

    td {
        text-align: right !important;
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
                            <li> <a href="<?php echo base_url('dashboard'); ?>"> Dashboard </a> </li>
                            <li> <a href="#"> Reports </a> </li>
                            <li class="active"> Cash Report </li>
                            <li class="search-box">
                                <form class="sidebar-search">
                                    <div class="form-group">
                                        <input type="text" placeholder="Start Searching...">
                                        <button class="submit"> <i class="fa fa-search"></i> </button>
                                    </div>
                                </form>
                            </li>
                        </ol>
                        <div class="page-header">
                            <h1>Payments Report</h1>
                        </div>
                        <div>
                            <!--<input type="button" height="20" width="20" onClick="load_list()">Click</input>-->
                            <?php /*?><table id="list_staff" class="table table-bordered table-condensed table-hover table-striped dataTable">
                <tbody>
                  
                </tbody>
            </table><?php */ ?>
                        </div>
                        <p>Please use the table below to navigate or filter the results. </p>
                    </div>
                </div>
                <!-- end: PAGE HEADER -->
                <!-- start: PAGE CONTENT 
                    <!-- start grid -->

                <div class="row">
                    <div class="col-md-12">
                        <!-- start: DYNAMIC TABLE PANEL -->
                        <div class="panel panel-default">
                            <div class="panel-heading"> <i class="fa fa-external-link-square"></i> User Payments
                                <div class="panel-tools" style="top:2px;">
                                    <!--<button onClick="JavaScript:fbs_click('<?php echo base_url('reports/print_sale?srh_warehouse_id=1'); ?>');" class="btn btn-blue dropdown-toggle" data-toggle="dropdown">
													<i class="fa fa-print"></i>
												</button>-->

                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="error"></div>
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div style="font-weight: 700;" class="panel-heading"></div>
                                    <div class="panel-body">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <?php
                                                $ss_group_id = $this->session->userdata('ss_group_id');

                                                if ($ss_group_id != 3) { ?>
                                                    <label>Warehouse </label>
                                                    <select id="srh_warehouse_id" class="form-control search-select" name="srh_warehouse_id">
                                                        <?php
                                                        $ss_warehouse_id = $this->session->userdata('ss_warehouse_id');
                                                        foreach ($warehouse_list as $row) {
                                                            $sel = '';
                                                            if ($ss_warehouse_id == $row->id) {
                                                                $sel = ' selected="selected"';
                                                            }
                                                        ?>
                                                            <option value="<?php echo $row->id; ?>" <?php echo $sel; ?>> <?php echo $row->name; ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                <?php } else if ($ss_group_id == 3) {

                                                ?>
                                                    <input name="srh_warehouse_id" type="hidden" value="<?php echo $this->session->userdata('ss_warehouse_id'); ?>">
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <?php
                                                $ss_group_id = $this->session->userdata('ss_group_id');

                                                $disable = 'disabled';
                                                $collapse    = 'collapse';
                                                if ($ss_group_id == 1) {
                                                    $disable  = '';
                                                    $collapse = '';
                                                }

                                                ?>
                                                <input type="hidden" id="user_group" name="user_group" value=" <?php echo $ss_group_id ?>">
                                                <label>User </label>
                                                <select id="srh_user_id" class="form-control search-select" name="srh_user_id">
                                                    <option value=""> -Select- </option>
                                                    <?php
                                                    $ss_user_id = $this->session->userdata('ss_user_id');
                                                    foreach ($user_list as $row) {
                                                        $sel = '';
                                                        if ($ss_user_id == $row->user_id) {
                                                            $sel = ' selected="selected"';
                                                        }
                                                    ?>
                                                        <option value="<?php echo $row->user_id; ?>" <?php echo $sel; ?>> <?php echo $row->user_first_name; ?> </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div style="display:none" class="col-sm-4">
                                            <div class="form-group">
                                                <label>Type </label>
                                                <select id="srh_type" class="form-control search-select" name="srh_type">
                                                    <option value="">-- Select --</option>
                                                    <option value="sale"> Sales </option>
                                                    <option value="sales_return"> Sales Return </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div style="display:none" class="col-sm-4">
                                            <div class="form-group">
                                                <label>Payment Term </label>
                                                <select id="srh_payment_term" class="form-control search-select" name="srh_payment_term">
                                                    <option value="">-- Select --</option>
                                                    <option value="Cash"> Cash </option>
                                                    <option value="Cheque"> Cheque </option>
                                                    <option value="Return Payment"> Return Payment </option>
                                                    <option value="Credit Card"> Credit Card </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>From Date </label>
                                                <input id="srh_from_date" name="srh_from_date" type='text' class="form-control date" value="" data-bv-field="date" />

                                                <!--  <input id="srh_from_date" name="srh_from_date" type='text' class="form-control date-time" value="<?php echo date('Y-m-d'); ?>" data-bv-field="date"/> -->
                                                <?php //echo date('m/d/Y', strtotime('-1 day', strtotime(date('m/d/Y')))); 
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="s2id_autogen1">To Date </label>

                                                <input id="srh_to_date" name="srh_to_date" type='text' class="form-control date" value="" data-bv-field="date" />

                                                <!--  <input id="srh_to_date" name="srh_to_date" type='text' class="form-control date-time" value="<?php echo date('Y-m-d'); ?>" data-bv-field="date"/> -->
                                            </div>
                                        </div>
                                        <div class="col-sm-4 pull-right">
                                            <div class="form-group">
                                                <label for="s2id_autogen1">&nbsp;<br>
                                                    <br>
                                                </label>
                                                <input type="submit" name="add_category" value="Search" class="btn btn-primary" onClick="searchDetails()">
                                                &nbsp;&nbsp;
                                                <input type="submit" name="add_category" value="Reset" class="btn btn-danger" onClick="searchDetailsReset()">
                                                &nbsp;&nbsp;

                                                <!--  <input onClick="print_booking_report();" type="submit" name="add_category" value="Print" class="btn btn-success">-->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-blue dropdown-toggle" data-toggle="dropdown" id="excel"> <i class="fa fa-fw" aria-hidden="true" title="Copy to use file-excel-o"></i> </button>
                                <button onClick="printDiv('printableArea')" class="btn btn-blue dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-print"></i> </button>

                                <!-- <input type="button" class="pull-right" value="Print Cash Report" onClick="printDiv('printableArea')">-->
                                <br>
                                <br>
                                <div id="ExcelArea">
                                    <div id="printableArea">
                                        <div class="page-header">
                                            <h1>Payments Report</h1>
                                            <button style="display:none" value="hello" data-toggle="collapse" data-onstyle="success" data-size="small" data-target="#not_for_sales_staff" />
                                        </div>
                                        <table id="" class="table table-bordered table-condensed table-hover table-striped dataTable">
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td class="text-right">From Date: <span id="f-date-txt"></span>, To Date: <span id="t-date-txt"></span></td>
                                                </tr>
                                                <tr>
                                                    <th width="50%">Cash ( Sales ) ( + )</th>
                                                    <td width="50%">
                                                        <div id="cash_sum_tbl">0.00</div>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <th width="50%">Cash ( Advance ) ( + )</th>
                                                    <td width="50%">
                                                        <div id="cash_sum_tbl_q">0.00</div>
                                                    </td>
                                                </tr>

                                                <tr class="collapse <?php echo $collapse; ?>">
                                                    <th width="50%">Cash Return ( Sales Return ) ( - )</th>
                                                    <td width="50%">
                                                        <div id="sales_return_tbl">0.00</div>
                                                    </td>
                                                </tr>

                                                <tr class="collapse">
                                                    <th>Expenses in cash ( - )</th>
                                                    <td>
                                                        <div id="exp_summ_tbl">0.00</div>
                                                    </td>
                                                </tr>

                                                <tr class="collapse <?php echo $collapse; ?>">
                                                    <th width="50%">GRN Return Payments In cash ( + )</th>
                                                    <td width="50%">
                                                        <div id="sales_return_grn_tbl">0.00</div>
                                                    </td>
                                                </tr>

                                                <tr class="collapse <?php echo $collapse; ?>">
                                                    <th width="50%">GRN Payments In cash ( - )</th>
                                                    <td width="50%">
                                                        <div id="sales_grn_tbl">0.00</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th style="background:#CC0">Cash in Hand ( Subtotal )</th>
                                                    <td style="background:#CC0">
                                                        <div id="cash_in_hand_tbl_2">0.00</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th></th>
                                                </tr>

                                                <tr>
                                                    <th width="50%">Credit Card - VISA ( sale )</th>
                                                    <td width="50%">
                                                        <div id="cc_sum_tbl">0.00</div>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <th width="50%">Credit Card - VISA ( advance )</th>
                                                    <td width="50%">
                                                        <div id="cc_sum_tbl_q">0.00</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th width="50%" style="background: #c961e0;">Total Visa</th>
                                                    <td width="50%" style="background: #c961e0;">
                                                        <div id="card_in_hand">0.00</div>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th></th>
                                                </tr>
                                                
                                                <tr>
                                                    <th width="50%" style="background:#0F6">Balance</th>
                                                    <td width="50%" style="background:#0F6">
                                                        <div id="amount_in_hand_tbl_2">0.00</div>
                                                    </td>
                                                </tr>

                                                <!-- <tr>
                    <th>Sales Return </th>
                    <td><div id="sales-rtn-cost-tbl">0.00</div></td>
                    </tr>-->

                                            </tbody>

                                        </table>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="panel panel-default">
                                        <div class="panel-heading"> <i class="fa fa-external-link-square"></i> CASH PAYMENTS</div>
                                        <table width="100%" class="table table-bordered table-condensed table-hover table-striped dataTable" id="cash_table">
                                            <thead>
                                                <tr>
                                                    <th>Ref. No.</th>
                                                    <th>Payment Date</th>
                                                    <th>Invoice No</th>
                                                    <th>Customer</th>
                                                    <th class="text-right" style="text-align:right !important;">Type</th>
                                                    <th class="text-right" style="text-align:right !important;">Payment Term</th>
                                                    <th class="text-right" style="text-align:right !important;">Paid Amount</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="panel panel-default">
                                        <div class="panel-heading"> <i class="fa fa-external-link-square"></i> ADVANCE PAYMENTS IN CASH</div>
                                        <table width="100%" class="table table-bordered table-condensed table-hover table-striped dataTable" id="cash_q_table">
                                            <thead>
                                                <tr>
                                                    <th>Ref. No.</th>
                                                    <th>Payment Date</th>
                                                    <th>Quotation No</th>
                                                    <th>Customer</th>
                                                    <th class="text-right" style="text-align:right !important;">Type</th>
                                                    <th class="text-right" style="text-align:right !important;">Payment Term</th>
                                                    <th class="text-right" style="text-align:right !important;">Paid Amount</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="panel panel-default">
                                        <div class="panel-heading"> <i class="fa fa-external-link-square"></i> CREDIT CARD PAYMENTS</div>
                                        <table width="100%" class="table table-bordered table-condensed table-hover table-striped dataTable" id="cc_table">
                                            <thead>
                                                <tr>
                                                    <th>Ref. No.</th>
                                                    <th>Payment Date</th>
                                                    <th>Invoice No</th>
                                                    <th>Customer</th>
                                                    <th class="text-right" style="text-align:right !important;">Type</th>
                                                    <th class="text-right" style="text-align:right !important;">Payment Term</th>
                                                    <th class="text-right" style="text-align:right !important;">Paid Amount</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="panel panel-default">
                                        <div class="panel-heading"> <i class="fa fa-external-link-square"></i> ADVANCE PAYMENTS IN CREDIT CARD</div>
                                        <table width="100%" class="table table-bordered table-condensed table-hover table-striped dataTable" id="cc_q_table">
                                            <thead>
                                                <tr>
                                                    <th>Ref. No.</th>
                                                    <th>Payment Date</th>
                                                    <th>Quotation No</th>
                                                    <th>Customer</th>
                                                    <th class="text-right" style="text-align:right !important;">Type</th>
                                                    <th class="text-right" style="text-align:right !important;">Payment Term</th>
                                                    <th class="text-right" style="text-align:right !important;">Paid Amount</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <br />
                                    <br />
                                    <div class="<?php echo $collapse; ?>" id="not_for_sales_staff">
                                        <div class="panel panel-default">
                                            <div class="panel-heading"> <i class="fa fa-external-link-square"></i> Sales Return List </div>
                                            <table width="100%" class="table table-bordered table-condensed table-hover table-striped dataTable" id="warehouse_table_rtn">
                                                <thead>
                                                    <tr>
                                                        <th>Ref. No.</th>
                                                        <th>Payment Date</th>
                                                        <th>Return Invoice No</th>
                                                        <th>Customer</th>
                                                        <th class="text-right" style="text-align:right !important;">Type</th>
                                                        <th class="text-right" style="text-align:right !important;">Payment Term</th>
                                                        <th class="text-right" style="text-align:right !important;">Paid Amount</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="panel panel-default">
                                            <div class="panel-heading"> <i class="fa fa-external-link-square"></i> GRN List </div>
                                            <table width="100%" class="table table-bordered table-condensed table-hover table-striped dataTable" id="warehouse_table_grn">
                                                <thead>
                                                    <tr>
                                                        <th>Ref. No.</th>
                                                        <th>Payment Date</th>
                                                        <th>GTN Invoice No</th>
                                                        <th>Supplier</th>
                                                        <th class="text-right" style="text-align:right !important;">Type</th>
                                                        <th class="text-right" style="text-align:right !important;">Payment Term</th>
                                                        <th class="text-right" style="text-align:right !important;">Paid Amount</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="panel panel-default">
                                            <div class="panel-heading"> <i class="fa fa-external-link-square"></i> GRN Return List </div>
                                            <table width="100%" class="table table-bordered table-condensed table-hover table-striped dataTable" id="warehouse_table_grn_return">
                                                <thead>
                                                    <tr>
                                                        <th>Ref. No.</th>
                                                        <th>Payment Date</th>
                                                        <th>GTN Invoice No</th>
                                                        <!-- <th>Supplier</th>-->
                                                        <th class="text-right" style="text-align:right !important;">Type</th>
                                                        <th class="text-right" style="text-align:right !important;">Payment Term</th>
                                                        <th class="text-right" style="text-align:right !important;">Paid Amount</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <!--  <th>&nbsp;</th>-->
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="panel-heading"> <i class="fa fa-external-link-square"></i> Expenses </div>
                                    <table width="100%" class="table table-bordered table-condensed table-hover table-striped dataTable" id="expenses_table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Ref. No.</th>
                                                <th>Date</th>
                                                <th>Expenses Type</th>
                                                <th>Rate</th>
                                                <th class="text-right" style="text-align:right !important;">Qty</th>
                                                <th class="text-right" style="text-align:right !important;">Discount</th>
                                                <th class="text-right" style="text-align:right !important;">Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- end: DYNAMIC TABLE PANEL -->
                        </div>
                    </div>

                    <!-- end grid -->

                    <input name="" id="cash_sum_fld" type="hidden">
                    <input name="" id="sales_rtn_summ_fld" type="hidden">
                    <input name="" id="grn_summ_fld" type="hidden">
                    <input name="" id="grn_return_summ_fld" type="hidden">
                    <input name="" id="exp_summ_fld" type="hidden">

                    <input name="" id="cc_sum_fld" type="hidden">


                </div>
                <!-- end: PAGE -->
            </div>
        </div>
        <!-- end: MAIN CONTAINER -->
        <!-- start: FOOTER -->
        <div class="footer clearfix">
            <div class="footer-inner"> <?php echo date("Y"); ?> &copy; </div>
            <div class="footer-items"> <span class="go-top"><i class="fa fa-chevron-up"></i></span> </div>
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

        <!-- start ajax model -->
        <div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
        <!-- end ajax model -->

        <!-- start: MAIN JAVASCRIPTS -->
        <?php $this->load->view("common/footer"); ?>
        <script src="<?php echo asset_url(); ?>js/jquery-ui.js"></script>
        <script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script>
        <script src="<?php echo asset_url(); ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>



        <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script>

        <!-- end: MAIN JAVASCRIPTS -->

        <script>
            function searchDetailsReset() {
                $('#srh_to_date').val('');
                $('#srh_from_date').val('');
            }

            function searchDetails() {
                loadTables();
            }
            $(document).ajaxStart(function() {
                $('body').modalmanager('loading');
            });
            $(document).ajaxStop(function() {
                $('body').modalmanager('removeLoading');
                $('body').removeClass('modal-open');
                $('body').removeClass('page-overflow');
                // $( "#loader" ).fadeOut();
            });

            function loadTables() {
                var srh_from_date = $('#srh_from_date').val();
                var srh_to_date = $('#srh_to_date').val();
                $('#f-date-txt').text(srh_from_date);
                $('#t-date-txt').text(srh_to_date);
                var srh_warehouse_id = $('#srh_warehouse_id').val();
                var srh_type = $('#srh_type').val();
                var srh_payment_term = $('#srh_payment_term').val();
                var ss_user_id = $('#srh_user_id').val();
                //alert(ss_user_id);
                $('#cash_table').DataTable({
                    "ajax": {
                        'type': 'POST',
                        'url': '<?php echo base_url('reports/get_list_payments_for_report '); ?>',
                        'data': {
                            srh_from_date: srh_from_date,
                            srh_to_date: srh_to_date,
                            srh_warehouse_id: srh_warehouse_id,
                            srh_type: 'sale',
                            srh_payment_term: 'cash',
                            ss_user_id: ss_user_id,
                        }
                    },
                    "bDestroy": true,
                    "iDisplayLength": 20,
                    "order": [
                        [1, "desc"]
                    ],
                    "fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay) {
                        var pq = 0,
                            sq = 0,
                            bq = 0,
                            pa = 0,
                            grand_tot = 0,
                            tech_tot = 0,
                            parts_tot = 0,
                            ser_tot = 0;
                        //alert(aaData.length);
                        var ser_tot3 = 0;
                        var ser_tot2 = 0;
                        var ser_tot1 = 0;
                        var ser_tot4 = 0;
                        var pay_type = '';
                        var sales_return_tot = 0;
                        var sales_grn_tot = 0;
                        //var sales_rtn=0;
                        for (var i = 0; i < aaData.length; i++) {
                            //alert(aaData[[i]][5]);
                            // p = (aaData[aiDisplay[i]][2]).split('__');
                            ser_tot1 += parseFloat(aaData[[i]][4]);
                            //pay_type=aaData[[i]][4];
                            if (aaData[[i]][4] == 'sale') {
                                ser_tot2 += parseFloat(aaData[[i]][6]);
                                //alert(aaData[[i]][4]);
                                //alert(ser_tot2);
                            } else {
                                //ser_tot2 -= parseFloat(aaData[[i]][6]);
                                if (aaData[[i]][4] == 'grn') {
                                    sales_grn_tot += parseFloat(aaData[[i]][6]);
                                }
                                if (aaData[[i]][4] == 'sales_return') {
                                    //alert(aaData[[i]][4]);
                                    sales_return_tot += parseFloat(aaData[[i]][6]);
                                    //alert(sales_return_tot);
                                }
                            }
                            //ser_tot3 += parseFloat(aaData[[i]][5]);	
                        }
                        var nCells = nRow.getElementsByTagName('th');
                        //	nCells[3].innerHTML = '<div class="text-right">'+accounting.formatMoney(ser_tot1, "", 2, ",", ".")+' </div>';
                        nCells[6].innerHTML = '<div class="text-right">' + accounting.formatMoney(ser_tot2 - sales_grn_tot - sales_return_tot, "", 2, ",", ".") + ' </div>';
                        //	nCells[5].innerHTML = '<div class="text-right">'+accounting.formatMoney(ser_tot3, "", 2, ",", ".")+' </div>';
                        var sales_rtn_tot_cost = ser_tot1;
                        var sales_rtn_tot_val = ser_tot2;
                        //alert(ser_tot2);
                        $('#cash_sum_tbl').text(accounting.formatMoney(ser_tot2, "", 2, ",", "."));
                        $('#cash_sum_fld').val(ser_tot2 - sales_grn_tot - sales_return_tot);
                        $('#sales-rtn-cost-tbl').text(accounting.formatMoney(sales_rtn_tot_cost, "", 2, ",", "."));
                        calculate_cah_in_hand();
                    }
                });
                
                $('#cash_q_table').DataTable({
                    "ajax": {
                        'type': 'POST',
                        'url': '<?php echo base_url('reports/get_list_payments_for_report '); ?>',
                        'data': {
                            srh_from_date: srh_from_date,
                            srh_to_date: srh_to_date,
                            srh_warehouse_id: srh_warehouse_id,
                            srh_type: 'custom',
                            srh_payment_term: 'cash',
                            ss_user_id: ss_user_id,
                        }
                    },
                    "bDestroy": true,
                    "iDisplayLength": 20,
                    "order": [
                        [1, "desc"]
                    ],
                    "fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay) {
                        var ser_tot2 = 0;
                        for (var i = 0; i < aaData.length; i++) {
                            if (aaData[[i]][4]) {
                                ser_tot2 += parseFloat(aaData[[i]][6]);
                            }
                        }
                        var nCells = nRow.getElementsByTagName('th');
                        nCells[6].innerHTML = '<div class="text-right">' + accounting.formatMoney(ser_tot2, "", 2, ",", ".") + ' </div>';
                        $('#cash_sum_tbl_q').text(accounting.formatMoney(ser_tot2, "", 2, ",", "."));
                        calculate_cah_in_hand();
                    }
                });

                //credit table
                $('#cc_table').DataTable({
                    "ajax": {
                        'type': 'POST',
                        'url': '<?php echo base_url('reports/get_list_payments_for_report '); ?>',
                        'data': {
                            srh_from_date: srh_from_date,
                            srh_to_date: srh_to_date,
                            srh_warehouse_id: srh_warehouse_id,
                            srh_type: 'sale',
                            srh_payment_term: 'visa',
                            ss_user_id: ss_user_id,
                        }
                    },
                    "bDestroy": true,
                    "iDisplayLength": 20,
                    "order": [
                        [1, "desc"]
                    ],
                    "fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay) {
                        var sale = 0;
                        for (var i = 0; i < aaData.length; i++) {
                            if (aaData[[i]][4]) {
                                sale += parseFloat(aaData[[i]][6]);
                            }	
                        }
                        var nCells = nRow.getElementsByTagName('th');
                        nCells[6].innerHTML = '<div class="text-right">' + accounting.formatMoney(sale, "", 2, ",", ".") + ' </div>';
                        $('#cc_sum_tbl').text(accounting.formatMoney(sale, "", 2, ",", "."));
                        calculate_cah_in_hand();
                    }
                });
                
                $('#cc_q_table').DataTable({
                    "ajax": {
                        'type': 'POST',
                        'url': '<?php echo base_url('reports/get_list_payments_for_report '); ?>',
                        'data': {
                            srh_from_date: srh_from_date,
                            srh_to_date: srh_to_date,
                            srh_warehouse_id: srh_warehouse_id,
                            srh_type: 'custom',
                            srh_payment_term: 'visa',
                            ss_user_id: ss_user_id,
                        }
                    },
                    "bDestroy": true,
                    "iDisplayLength": 20,
                    "order": [
                        [1, "desc"]
                    ],
                    "fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay) {
                        var sale = 0;
                        for (var i = 0; i < aaData.length; i++) {
                            if (aaData[[i]][4]) {
                                sale += parseFloat(aaData[[i]][6]);
                            } 
                        }
                        var nCells = nRow.getElementsByTagName('th');
                        nCells[6].innerHTML = '<div class="text-right">' + accounting.formatMoney(sale, "", 2, ",", ".") + ' </div>';
                        $('#cc_sum_tbl_q').text(accounting.formatMoney(sale, "", 2, ",", "."));
                        calculate_cah_in_hand();
                    }
                });
                /* return start */
                /* return end */
                /* grn start */
                /* grn return end */
                //loadexpenses
                //alert();
                /*$('#expenses_table').DataTable({
							
							"ajax": {
							'type': 'POST',
							'url': '<?php echo base_url('reports/get_list_expenses_for_report'); ?>',
							'data': {
							   srh_from_date: srh_from_date,
							   srh_to_date: srh_to_date,
							   srh_warehouse_id: srh_warehouse_id,
							    srh_type: srh_type,
								 srh_payment_term: srh_payment_term,
								 ss_user_id: ss_user_id,
							}
							},
					        "bDestroy": true,
					        "iDisplayLength": 20,
							"order": [[ 0, "asc" ]], "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
				
                var pq = 0, sq = 0, bq = 0, pa = 0, grand_tot = 0, tech_tot = 0, parts_tot=0 , ser_tot=0;
				//alert(aaData.length);
				var ser_tot3=0;
				var ser_tot2=0;
				var ser_tot1=0;
				var ser_tot4=0;
				var pay_type='';
				//var sales_rtn=0;
                for (var i = 0; i < aaData.length; i++) {
					//alert(aaData[[i]][5]);
                   // p = (aaData[aiDisplay[i]][2]).split('__');
					ser_tot1 += parseFloat(aaData[[i]][3]);
					//pay_type=aaData[[i]][4];
					//if(aaData[[i]][4]=='sale'){
					ser_tot2 += parseFloat(aaData[[i]][7]);
					//}else {
						//ser_tot2 -= parseFloat(aaData[[i]][6]);
					//}
					//ser_tot3 += parseFloat(aaData[[i]][5]);	
                }
                var nCells = nRow.getElementsByTagName('th');
			//	nCells[3].innerHTML = '<div class="text-right">'+accounting.formatMoney(ser_tot1, "", 2, ",", ".")+' </div>';
				
				
				nCells[7].innerHTML = '<div class="text-right">'+accounting.formatMoney(ser_tot2, "", 2, ",", ".")+' </div>';
			//	nCells[5].innerHTML = '<div class="text-right">'+accounting.formatMoney(ser_tot3, "", 2, ",", ".")+' </div>';
				
				var sales_rtn_tot_cost=ser_tot1;
				var sales_rtn_tot_val=ser_tot2;
				
				
				$('#exp_summ_tbl').text(accounting.formatMoney(ser_tot2, "", 2, ",", "."));
				$('#exp_summ_fld').val(ser_tot2);
				var cash_in_hand=0;
				cash_in_hand=$('#cash_sum_fld').val()-ser_tot2;
				
				//alert();
				
				$('#cash_in_hand_tbl').text(accounting.formatMoney(cash_in_hand, "", 2, ",", "."));
				
			calculate_cah_in_hand();	
              
            }
					    }); */
            }

            function calculate_cah_in_hand() {
                
                const sale_cash  = parseFloat(accounting.unformat($('#cash_sum_tbl').text()));
                const adv_cash  = parseFloat(accounting.unformat($('#cash_sum_tbl_q').text()));
                
                var total_cash = adv_cash+sale_cash;
                
                $('#cash_in_hand_tbl_2').text(accounting.formatMoney(total_cash, "", 2, ",", "."));
                
                /*visa*/
                const sale_visa  = parseFloat(accounting.unformat($('#cc_sum_tbl').text()));
                const adv_visa  = parseFloat(accounting.unformat($('#cc_sum_tbl_q').text()));
                
                var total_visa = sale_visa+adv_visa;
                
                $('#card_in_hand').text(accounting.formatMoney(total_visa, "", 2, ",", "."));
                
                
                $('#amount_in_hand_tbl_2').text(accounting.formatMoney(total_cash + total_visa, "", 2, ",", "."));
                
                
                
            }
            /*end of user list*/
            jQuery(document).ready(function() {
                $('.date-time').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true
                });
                var tomorrow = new Date();
                currentDate = tomorrow.setDate(tomorrow.getDate() - 30);
                //loadTables();
            });
            /*
            function print_booking_report(url) {
                var srh_from_date = $('#srh_from_date').val();
                var srh_to_date = $('#srh_to_date').val();
                var srh_warehouse_id = $('#srh_warehouse_id').val();
                var srh_type = $('#srh_type').val();
                var srh_payment_term = $('#srh_payment_term').val();
                var ss_user_id = $('#ss_user_id').val();
                u = location.href;
                t = document.title;
                url = '<?php echo base_url(); ?>' + 'reports/print_booking_report?srh_warehouse_id=' + srh_warehouse_id + '&srh_from_date=' + srh_from_date + '&srh_to_date=' + srh_to_date + '&srh_type=' + srh_type + '&srh_payment_term=' + srh_payment_term + '&ss_user_id=' + ss_user_id;
                window.open(url, 'sharer', 'toolbar=0,status=0,width=750,height=436, left=10, top=10,scrollbars=yes');
                return false;
            }
            */
            function changeColectedStatus(id, sta) {
                var fld_id = 'collected_' + id;
                // alert(sta);
                paymnt_id = id;
                if (sta) {
                    pymnt_collected = 1;
                } else {
                    pymnt_collected = 0;
                }
                $.post("<?php echo base_url(); ?>booking/change_collected_status", {
                        paymnt_id: paymnt_id,
                        pymnt_collected: pymnt_collected
                    })
                    .done(function(data) {
                        var obj = jQuery.parseJSON(data);
                        if (obj.status == 0) {}
                    });
                if (sta) {
                    displayNotice('Payment', 'Advance Payment Collected');
                    // Code in the case checkbox is checked.
                } else {
                    displayNotice('Payment', 'Deleted Advance payment collect status');
                    // alert('no');
                    // Code in the case checkbox is NOT checked.
                }
                return false;
            }

            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }

            $(function() {
                $('#excel').click(function() {
                    var url = 'data:application/vnd.ms-excel,' + encodeURIComponent($('#ExcelArea').html())
                    location.href = url
                    return false
                })
            })

            jQuery(document).ready(function() {
                var currentDate = new Date();
                $('#srh_to_date').datetimepicker({
                    defaultDate: new Date()
                });
                $('#srh_from_date').datetimepicker({
                    defaultDate: new Date()
                });
            });
        </script>
        <div id="log"> </div>
</body>
<!-- end: BODY -->

</html>