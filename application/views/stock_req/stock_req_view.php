<style type="text/css">
    .report_view_th {
        background-color: #428bca;
        color: #fff !important;
        font-size: 14px;
    }
    .table-responsive td {
        font-size: 14px;
    }
    h4 {
        font-size: 13px;
    }
    .fa-3x {
        font-size: 2em !important;
    }
</style>
<?php $this->load->view("common/header"); ?>
<!-- end: HEAD -->
<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/select2/select2.css" />
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />
<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/jQuery-Tags-Input/jquery.tagsinput.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/summernote/build/summernote.css">
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/jquery.dataTables.css">
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
                                <a href="<?php echo base_url('quotations'); ?>">
                                    List Quotations
                                </a>
                            </li>
                            <li class="active">
                                View
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
                            <?php
                            $message = $this->session->flashdata('message');
                            if ($message) { ?>
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <?php echo $message ?>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
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
                                <i class="fa fa-external-link-square"></i>
                                Quotation Number <?php echo $sr_id ?>
                                <div class="panel-tools" style="top:2px;">
                                </div> <!--panel-tools-->
                            </div> <!--panel-heading-->
                            <div class="panel-body">
                                <div class="well well-sm">
                                    <div class="col-xs-4 border-right">
                                        <div class="col-xs-2"><i class="fa fa-3x fa-file-text-o padding010 text-muted"></i></div>
                                        <div class="col-xs-10">
                                            <h4 class="">Reference No : <?php echo $qts_details['req_reference_no']; ?></h4>
                                            <p>Date: <?php echo display_date_time_format($qts_details['req_datetime']) ?></p>
                                            <p> Invoice No <?php echo $qts_details['req_reference_no']; ?> Date : <?php echo $qts_details['reqesting_for_date']; ?></p>
                                            <!--<p> Invoice User <?php echo $qts_details['user_first_name']; ?> Total <?php echo $qts_details['sale_total']; ?></p>-->
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col-xs-4 border-right">
                                        <div class="col-xs-2"><i class="fa fa-3x fa-user padding010 text-muted"></i></div>
                                        <div class="col-xs-10">
                                            <!--<h4 class=""><?php echo $customer_details['cus_name']; ?></h4>
                                            <?php echo $customer_details['cus_address']; ?><br>
                                            <p></p>
                                            Tel: <?php echo $customer_details['cus_phone']; ?><br>
                                            Email: <?php echo $customer_details['cus_email']; ?>-->
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="col-xs-2"><i class="fa fa-3x fa-building-o padding010 text-muted"></i></div>
                                        <div class="col-xs-10">
                                            <h4 class=""><?php echo $warehouse_details['name']; ?></h4>
                                            <?php echo $warehouse_details['address']; ?><p></p>
                                            Tel: <?php echo $warehouse_details['phone']; ?><br>
                                            Email: <?php echo $warehouse_details['email']; ?>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div> <!--col-xs-4-->
                                <div class="col-xs-5">
                                    <input name="qts_id" type="hidden" id="qts_id" value="<?php echo $sr_id ?>">
                                    <input type="hidden" id="qts_type" name="qts_type" value="sale">
                                    <div class="clearfix"></div>
                                </div> <!--col-xs-4"-->
                                <div class="clearfix"></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped print-table order-table">
                                        <thead>
                                            <tr class="report_view_th">
                                                <th>No</th>
                                                <th>Description (Code)</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $tmpcount = 0;
                                            foreach ($qts_item_list as $row) {
                                                $tmpcount++;
                                            ?>
                                                <tr>
                                                    <td style="text-align:center; width:40px; vertical-align:middle;"><?php echo $tmpcount ?></td>
                                                    <td style="vertical-align:middle;"><?php echo $row['product_name']; ?> (<?php echo $row['product_code']; ?>)</td>
                                                    <td style="width: 100px; text-align:center; vertical-align:middle;"><?php echo number_format($row['quantity'], 2, '.', ',') ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                        </tfoot>
                                    </table>
                                </div> <!--table-responsive-->
                                <div class="clearfix"></div>
                                <p></p>
                                <div class="well well-sm col-xs-6 pull-right">
                                    <div class="col-xs-10">
                                        <p>Created by : <?php echo $this->session->userdata('ss_user_first_name'); ?> (<?php echo $this->session->userdata('ss_user_group_name'); ?>) </p>
                                        <p>Date:<?php echo display_date_time_format($qts_details['req_datetime']) ?></p>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="clearfix"></div>
                                </div> <!--well well-sm col-xs-6 pull-right-->
                                <!-- payment list -->
                                <div class="row collapse">
                                    <div class="col-xs-12">
                                        <div class="table-responsive">
                                            <table class="table items table-striped table-bordered table-condensed table-hover">
                                                <thead>
                                                    <tr class="report_view_th">
                                                        <th>Date</th>
                                                        <th>Payment Reference</th>
                                                        <th>Paid by</th>
                                                        <th>Amount</th>
                                                        <th>Created by</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($sale_payments_list as $row) { ?>
                                                        <tr>
                                                            <td><?php echo display_date_time_format($row->sale_pymnt_date_time) ?></td>
                                                            <td><?php
                                                                echo $row->sale_pymnt_id;
                                                                if ($row->sale_pymnt_ref_no) echo "<br/>Ref.: " . $row->sale_pymnt_ref_no;
                                                                if ($row->sale_pymnt_cheque_no) echo "<br/>Cheque No.: " . $row->sale_pymnt_cheque_no;
                                                                if ($row->sale_pymnt_note) echo "<br/>Note: " . $row->sale_pymnt_note;
                                                                ?></td>
                                                            <td><?php echo $row->sale_pymnt_paying_by ?></td>
                                                            <td><?php echo number_format($row->sale_pymnt_amount, 2, '.', ',') ?></td>
                                                            <td> <?php echo $row->user_first_name ?> (<?php echo $row->user_group_name ?>)</td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <br>
                                <div class="clearfix"></div>
                                <div class="buttons">
                                    <div class="btn-group btn-group-justified">
                                        <div class="btn-group">
                                            <a title="" class="tip btn btn-primary tip" data-target="#ajax-modal" data-toggle="modal" href="#" data-original-title="Add Payment"><i class="fa fa-money"></i> <span class="hidden-sm hidden-xs">Advance Payment</span></a></div>
                                        <!--<div class="btn-group"><a title="" class="tip btn btn-primary tip" data-target="#myModal" data-toggle="modal" href="#" data-original-title="Add Payment" id="modal_ajax_qty_payment_btn"><i class="fa fa-money"></i> <span class="hidden-sm hidden-xs">Advance Payment</span></a></div>-->
                                        <div class="btn-group" onClick="fbs_click(<?php echo $sr_id; ?>)"><a title="" class="tip btn btn-primary" data-original-title="Print"><i class="fa fa-print"></i> <span class="hidden-sm hidden-xs">Print</span></a>
                                        </div>
                                    </div>
                                </div> <!--buttons-->
                            </div> <!--panel-body-->
                        </div><!--panel-->
                    </div> <!--col-md-12-->
                </div> <!--row-->
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
        <!-- start ajax model -->
        <div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;">
            <?php
            $config = array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'create_sales_payment_form', 'name' => 'create_category_form');
            echo form_open_multipart(base_url("#"), $config);
            ?>
            <?php //print_r($category_details) 
            ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">ADD PAYMENTS</h4>
            </div>
            <div class="modal-body">
                <div id="error"></div>
                <font style="color:#333;">Please fill in the information below. The field labels marked with * are required input fields.</font>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-sm-5">
                            <div class="form-group has-feedback">
                                <input name="sale_id" type="hidden" id="sale_id" value="<?php echo $sr_id; ?>" />
                                <input name="sale_type" type="hidden" id="sale_type" value="advance" />
                                <label for="date">Date *</label>
                                <input id="sale_pymnt_date_time" name="sale_pymnt_date_time" type='text' class="form-control date" value="" />
                            </div>
                        </div><!--col-sm-5-->
                        <div class="col-sm-5 pull-right">
                            <div class="form-group">
                                <label for="reference_no">Reference No</label> <input type="text" id="sale_pymnt_ref_no" class="form-control tip" value="" name="sale_pymnt_ref_no">
                            </div>
                        </div><!--col-sm-5 pull-right-->
                    </div><!--row-->
                </div><!--col-md-12-->
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="well well-sm well_1">
                            <div class="col-sm-5">
                                <div class="form-group has-feedback">
                                    <label for="date">Amount *</label> <input type="text" id="sale_pymnt_amount" class="form-control datetime text-right" value="0.00" name="sale_pymnt_amount" data-bv-field="date" onchange="calculateBalance(this.value);" onclick="this.select();" autofocus>
                                    <br />
                                    <label for="date">Cash</label> <input type="text" id="sale_pymnt_given_amount" class="form-control datetime text-right" value="0.00" name="sale_pymnt_given_amount" data-bv-field="date" onchange="calculateBalance(this.value);" onclick="this.select();" autofocus>
                                    <br />
                                    <label for="date">Cash Change </label> <input type="text" id="sale_pymnt_balance_amount" class="form-control datetime text-right" value="0.00" name="sale_pymnt_balance_amount" data-bv-field="date" autofocus>
                                </div>
                            </div><!--col-sm-5-->
                            <div class="col-sm-5 pull-right">
                                <div class="form-group">
                                    <label for="reference_no">Paying by *</label>
                                    <select class="form-control paid_by" id="sale_pymnt_paying_by" name="sale_pymnt_paying_by" data-bv-field="paid_by" tabindex="-1" title="Paying by *" onchange="changePayingby(this.value)">
                                        <option value="cash">Cash</option>
                                        <option value="visa">Visa</option>
                                        <option value="master">Master</option>
                                        <option value="cheque">Cheque</option>
                                    </select>
                                </div>
                            </div><!--col-sm-5 pull-right-->
                            <div class="clearfix"></div>
                            <div id="cheque_dtls" style="display:none;" class="paying_by_details">
                                <label for="date">Cheque No *</label> <input type="text" id="sale_pymnt_cheque_no" class="form-control datetime" value="" name="sale_pymnt_cheque_no" data-bv-field="date">
                            </div> <!--cheque-->
                            <div id="credit_card" style="display:none;" class="paying_by_details">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <input type="text" id="sale_pymnt_crdt_card_no" class="form-control tip" value="" name="sale_pymnt_crdt_card_no" placeholder="Credit Card No *">
                                    </div>
                                </div> <!--col-sm-5-->
                                <div class="col-sm-5 pull-right">
                                    <div class="form-group">
                                        <input type="text" id="sale_pymnt_crdt_card_holder_name" class="form-control tip" value="" name="sale_pymnt_crdt_card_holder_name" placeholder="Holder Name *">
                                    </div>
                                </div> <!--col-sm-5-->
                                <div class="col-sm-3" style="margin-right:60px;">
                                    <div class="form-group">
                                        <select class="form-control paid_by" id="sale_pymnt_crdt_card_type" name="sale_pymnt_crdt_card_type" data-bv-field="paid_by">
                                            <option value="Visa">Visa</option>
                                            <option value="MasterCard">MasterCard</option>
                                            <option value="Amex">Amex</option>
                                            <option value="Discover">Discover</option>
                                        </select>
                                    </div>
                                </div> <!--col-sm-3-->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input type="text" id="sale_pymnt_crdt_card_month" class="form-control tip" value="" name="sale_pymnt_crdt_card_month" placeholder="Month *">
                                    </div>
                                </div> <!--col-sm-3-->
                                <div class="col-sm-3 pull-right">
                                    <div class="form-group">
                                        <input type="text" id="sale_pymnt_crdt_card_year" class="form-control tip" value="" name="sale_pymnt_crdt_card_year" placeholder="Year *">
                                    </div>
                                </div> <!--col-sm-3-->
                            </div> <!--credit_card-->
                            <div class="clearfix"></div>
                        </div><!--well well-sm well_1-->
                    </div><!--row-->
                </div><!--col-md-12-->
                <div class="clearfix"></div>
                <div class="row form-group">
                    <div class="col-md-12">
                        <h5>Note</h5>
                        <p>
                            <input type="text" class="form-control" name="sale_pymnt_note" id="sale_pymnt_note" value="">
                        </p>
                        <div class="modal-footer">
                            <input type="submit" name="add_category" value="Add Payment" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <!-- end ajax model -->
        <!-- start: MAIN JAVASCRIPTS -->
        <?php $this->load->view("common/footer"); ?>
        <!-- end: MAIN JAVASCRIPTS -->
        <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
        <script src="<?php echo asset_url(); ?>plugins/jquery-inputlimiter/jquery.inputlimiter.1.3.1.min.js"></script>
        <script src="<?php echo asset_url(); ?>plugins/jquery.maskedinput/src/jquery.maskedinput.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>plugins/bootbox/bootbox.min.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>plugins/jquery-mockjax/jquery.mockjax.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>plugins/DataTables/media/js/DT_bootstrap.js"></script>
        <script src="<?php echo asset_url(); ?>js/table-data.js"></script>
        <script src="<?php echo asset_url(); ?>plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
        <script src="<?php echo asset_url(); ?>plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
        <script src="<?php echo asset_url(); ?>js/ui-modals.js"></script>
        <script src="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
        <script src="<?php echo asset_url(); ?>plugins/select2/select2.min.js"></script>
        <script src="<?php echo asset_url(); ?>plugins/jQuery-lib/2.0.3/jquery.min.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.js"></script>
        <script src="<?php echo asset_url(); ?>js/form-validation-sales_payment.js"></script>
        <script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script>
        <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
        <script>
            jQuery(document).ready(function() {
                TableData.init();
                //Main.init();
                //TableData.init();
                //UIModals.init();
            });
        </script>
        <script type="text/javascript" language="javascript">
            var j = jQuery.noConflict();
            function loadGrid() {
                alert();
                j('#employee-grid').DataTable().ajax.reload();
            }
            jQuery(document).ready(function() {
                var dataTable = j('#employee-grid').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: "quotations/list_quotations", // json datasource
                        type: "post", // method  , by default get
                        error: function() { // error handling
                            j(".employee-grid-error").html("");
                            j("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                            //$("#employee-grid_processing").css("display","none");
                        }
                    }
                });
            });
            function test1() {
                alert();
            }
            function fbs_click(id) {
                u = location.href;
                t = document.title;
                window.open('<?php echo base_url() ?>quotations/qts_details?qts_id=' + id, 'sharer', 'toolbar=0,status=0,width=700,height=700, left=10, top=10,scrollbars=yes');
                return false;
            }
            
        function add_sale_payments(form) {
            //$('body').modalmanager('loading');
            setTimeout(function() {
                $.ajax({
                    url: "<?php echo base_url('sales/add_sale_payments_advance'); ?>", // Url to which the request is send
                    type: "POST", // Type of request to be send, called as method
                    data: new FormData(form), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false, // To send DOMDocument or non processed data file it is set to false
                    success: function(data) // A function to be called if request succeeds
                    {
                        var obj = jQuery.parseJSON(data);
                        if (obj.status == 0)
                        {
                            $('#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>' + obj.validation + '</div>');
                            // $('body').modalmanager('removeLoading');
                        } else
                        {
                            // $('body').modalmanager('removeLoading');
                            $('div#ajax-modal').modal('hide');
                            set_message('Sales Notice!', 'Payment successfully added');
                            location.reload(true);
                        };
                    }
                });
            }, 0);
        }
        </script><script>
    function displayPayments() {
        var total_paymnt_tmp = parseFloat($('#total_paymnt_tmp').val());
        //alert(total_paymnt_tmp);
        var paid_tmp = parseFloat($('#paid_tmp').val());
        var needtopay = 0;
        needtopay = total_paymnt_tmp - paid_tmp;
        if (needtopay < 0) {
            needtopay = 0;
        }
        //lert(total_paymnt_tmp-paid_tmp)
    }
    function setAmount() {
        var total_paymnt_tmp = parseFloat($('#total_paymnt_tmp').val());
        var paid_tmp = parseFloat($('#paid_tmp').val());
        var amount = parseFloat($('#total_paymnt_tmp').val());
        $('#sale_pymnt_amount').val((total_paymnt_tmp - paid_tmp));
    }
    setAmount();
    displayPayments();
    function calculateBalance(amount1) {
        var total_paymnt = 0;
        var total_paid = 0;
        var amount = parseFloat($('#sale_pymnt_amount').val());
        var total_paymnt = parseFloat($('#total_paymnt_tmp').val());
        //alert(total_paymnt);
        var total_paid = parseFloat($('#sale_pymnt_given_amount').val());
        var amount = parseFloat(amount);
        if (isNaN(amount)) {
            set_message('Error!', 'Please enter valid amount');
            $('#sale_pymnt_amount').val('');
        } else {
            if (amount == '0.00') {
            } else {
                //$('#sale_pymnt_amount').val((amount));
                $('#sale_pymnt_balance_amount').val(((parseFloat($('#sale_pymnt_given_amount').val()) - amount)));
            }
            var balance = amount - total_paid;
            //balance=11;
            //	 $('#nw_paid_amt_dis').text(convertToAmount(amount));
            //	 $('#balance_amt_dis').text(convertToAmount(balance));
        }
        //alert();
        // $('#sale_pymnt_amount').focus();
        //setTimeout(alert(),1000)
        //alert(amount);
    }
    function convertToAmount(val)
    {
        var disval = val; //+'.00'; //.toFixed(val);
        return accounting.formatMoney(disval, "", 2, ",", "."); // €4.999,99 
    }
    function changePayingby(val) {
        $('.paying_by_details').hide();
        if (val == 'CC') {
            $('#credit_card').show();
        }
        if (val == 'Cheque') {
            $('#cheque_dtls').show();
        }
    }
    jQuery(document).ready(function() {
        FormValidator.init();
        jQuery.noConflict();
        jQuery('#sale_pymnt_date_time').datetimepicker({
            defaultDate: new Date()
        });
        calculateBalance(0);
    });
    function add_sale_payments(form) {
        //$('body').modalmanager('loading');
        setTimeout(function() {
            $.ajax({
                url: "<?php echo base_url('sales/add_sale_payments_advance'); ?>", // Url to which the request is send
                type: "POST", // Type of request to be send, called as method
                data: new FormData(form), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false
                success: function(data) // A function to be called if request succeeds
                {
                    var obj = jQuery.parseJSON(data);
                    if (obj.status == 0)
                    {
                        $('#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>' + obj.validation + '</div>');
                        // $('body').modalmanager('removeLoading');
                    } else
                    {
                        // $('body').modalmanager('removeLoading');
                        $('div#ajax-modal').modal('hide');
                        set_message('Sales Notice!', 'Payment successfully added');
                        location.reload(true);
                    };
                }
            });
        }, 0);
    }
</script>
</body>
<!-- end: BODY -->
</html>