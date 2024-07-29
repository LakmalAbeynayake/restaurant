<?php $this->load->view("common/header"); ?>

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
    .bold{
        font-weight: bold;
    }
    /*START*/
    .lds-dual-ring {
      display: inline-block;
      width: 80px;
      height: 80px;
    }
    .lds-dual-ring:after {
      content: " ";
      display: block;
      width: 64px;
      height: 64px;
      margin: 8px;
      border-radius: 50%;
      border: 6px solid #fff;
      border-color: #fff transparent #fff transparent;
      animation: lds-dual-ring 1.2s linear infinite;
    }
    @keyframes lds-dual-ring {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }
    
    .blackbg {
        z-index: 3;
        background-color: #666;
        -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=30)";
        filter: alpha(opacity=30);
        opacity: 0.3;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        position: fixed;
    }
</style>
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
<!-- end: HEAD -->
<!-- start: BODY -->

<body>
    <div id="modal-loading" class="no-print" style="display: none;">
        <div class="blackbg" style="display: flex;justify-content: center;align-items: center;opacity:0.9;z-index: 9999;">
            <center>
                <!--<i style="color:#FFF;" class="fa fa-spinner fa-spin fa-5x"></i>-->
                <div class="lds-dual-ring"></div>
            </center>
        </div>
    </div>
    <!-- start: HEADER -->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <!-- start: TOP NAVIGATION CONTAINER -->
        <div class="container">
            <div class="navbar-header">
                <!-- start: RESPONSIVE MENU TOGGLER -->
                <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button"> <span class="clip-list-2"></span> </button>
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
                            <li class="active"> Sales Report </li>
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
                <div id="print-section">
                    <div class="page-header text-center">
                        <h1>Daily Summary Report</h1>
                    </div>
                    <p>Please use the table below to navigate or filter the results. </p>
                    <!-- end: PAGE HEADER -->
                    <!-- start: PAGE CONTENT 
                    <!-- start grid -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- start: DYNAMIC TABLE PANEL -->
                            <div class="panel panel-default">
                                <div class="panel-heading"> <i class="fa fa-external-link-square"></i> Filters
                                    <div class="panel-tools" style="top:2px;">
                                        <button onClick="printDiv('printableArea')" class="btn btn-blue dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-print"></i> </button>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Warehouse </label>
                                            <select id="srh_warehouse_id" class="form-control" name="srh_warehouse_id">
                                                <!-- <option value="">-- Select Warehouse --</option>-->
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
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Date </label>
                                            <input id="srh_date" type='text' class="form-control date" value="" data-bv-field="date" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Date To</label>
                                            <input id="srh_date_to" type='text' class="form-control date" value="" data-bv-field="date" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pull-right">
                                        <div class="form-group">
                                            <label for="s2id_autogen1">&nbsp;<br>
                                                <br>
                                            </label>
                                            <input type="submit" name="add_category" value="Search" class="btn btn-primary" onClick="get_data()">
                                            &nbsp;&nbsp;
                                            <input type="submit" name="add_category" value="Reset" class="btn btn-danger" onClick="searchDetailsReset()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="printableArea">
                                        <div class="page-header text-center">
                                            <!--<h1>Daily Summary Report</h1>-->
                                        </div>
                                        <table class="table table-bordered table-condensed table-hover table-striped dataTable" id="summary_table">
                                            <thead>
                                                <tr>
                                                    <th>Description</th>
                                                    <th>Values</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <ul id="rep_details">
                                                        <li> Date: <span id="date"></span></li>
                                                        <li style="display:none"> Date To: <span id="date_to"></span></li>
                                                        <li> Created On: <span id="created_on"></span></li>
                                                        <li> Created By: <span id="created_by"></span></li>
                                                        <li> Last Modified on: <span id="last_modified_on"></span></li>
                                                    </ul>
                                                </tr>
                                                
                                                <!--SALES INFO-->
                                                <tr>
                                                    <th colspan="2">
                                                        <h4 class="text-center">Sales Information</h4>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Total Sale</th>
                                                    <td id="ttl_sales">
                                                        0.00
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Total Cost</th>
                                                    <td id="ttl_cost_of_sales">
                                                        0.00
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Breakdown</td>
                                                    <th>
                                                        <div class="bold">
                                                            Total Receivings: <span id="ttl_payments_for_sales"> 0.00</span>
                                                        </div>
                                                        <table class="table table-bordered table-condensed table-hover">
                                                            <tr>
                                                                <th colspan="2" class="text-center"> <h5>Sale Payments Information </h5> </th>
                                                            </tr>
                                                            <tr>
                                                                <th> Cash </th>
                                                                <td id="mop_cash" class="text-right"> 0.00 </td>
                                                            </tr>
                                                            <tr>
                                                                <th> Credit Card </th>
                                                                <td id="mop_cc" class="text-right"> 0.00 </td>
                                                            </tr>
                                                            <tr>
                                                                <th> Cheque </th>
                                                                <td id="mop_cheque" class="text-right"> 0.00 </td>
                                                            </tr>
                                                        </table>
                                                        <table class="table table-bordered table-condensed table-hover">
                                                            <tr>
                                                                <th colspan="2" class="text-center"> <h5>Order Types Information | Amount (Sale Count) </h5> </th>
                                                            </tr>
                                                            <tr>
                                                                <th> Dine IN </th>
                                                                <td id="dt_di" class="text-right"> 0.00 </td>
                                                            </tr>
                                                            <tr>
                                                                <th> Take Away </th>
                                                                <td id="dt_ta" class="text-right"> 0.00 </td>
                                                            </tr>
                                                            <tr>
                                                                <th> Delivery </th>
                                                                <td id="dt_dl" class="text-right"> 0.00 </td>
                                                            </tr>
                                                        </table>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Total Cancelations</th>
                                                    <td id="ttl_sales_cancelled"> 0.00 </td>
                                                </tr>
                                                <!--SALES RETURN INFO-->
                                                <tr>
                                                    <th colspan="2">
                                                        <h4 class="text-center">Sales Return Information</h4>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Total Return</th>
                                                    <td id="ttl_value_of_customer_returns">
                                                        0.00
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Customer Refunds</th>
                                                    <td id="ttl_value_of_pay_back_to_cus">
                                                        0.00
                                                    </td>
                                                </tr>
                                                
                                                <!--PURCHASES INFO-->
                                                <tr>
                                                    <th colspan="2">
                                                        <h4 class="text-center">Purchases Information</h4>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Total Purchases</th>
                                                    <td id="ttl_purchases_value">
                                                        0.00
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Payments for purchases</th>
                                                    <td id="ttl_pymnts_for_purchases">
                                                        0.00
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Return to suppliers</th>
                                                    <td id="ttl_value_of_return_to_suppliers">
                                                        0.00
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Supplier Refunds</th>
                                                    <td id="ttl_value_of_paybacks_from_suppliers">
                                                        0.00
                                                    </td>
                                                </tr>
                                                
                                                
                                                
                                                <!--<tr>
                                                    <th style="background-color:#C93">Net Sale</th>
                                                    <td style="background-color:#C93">
                                                        <div id="net-sales"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <th width="50%">Cost of Sales</th>
                                                    <td width="50%"></td>
                                                </tr>-->
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>
                                </div>
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
            <div class="footer-inner"> 2018 &copy; smartsalleepos.com </div>
            <div class="footer-items"> <span class="go-top"><i class="clip-chevron-up"></i></span> </div>
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
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>
    <!--<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script>-->
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
    <!-- <script src="<?php echo asset_url(); ?>js/main.js"></script>-->
    <!-- end: MAIN JAVASCRIPTS -->
    <script>
        $(document).ajaxStart(()=>{
            $('#modal-loading').show();
            setTimeout(()=>{
                var loading_html = '<div class="text-center" id="injected" style="font-size: large;color: white; display:none">Report is generating. Please wait...</div>';
                $('.lds-dual-ring').before(loading_html);
                $('#injected').show('slow');
            },3000);
        });
        
        $(document).ajaxStop(()=>{
            $('#modal-loading').hide();
            $('#injected').remove();
        });
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

        function searchDetailsReset() {
            $('#srh_date').val('');
        }

        function applyHTMLContent(elementId, htmlContent) {
          var element = document.getElementById(elementId);
          if (element) {
            element.innerHTML = htmlContent;
          } else {
            console.error("Element not found with ID: " + elementId);
          }
        }
        function get_data() {
            const date = $('#srh_date').val();
            const srh_date_to = $('#srh_date_to').val();
            resetTable();
            // Make an AJAX post request
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>summary/get_daily_report",
                data: {
                    date: date,
                    date_to: srh_date_to
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    // Call the generateReport function with the response
                    if($(response).length){
                        generateReport(response);
                    }
                    else{
                        bootbox.alert('<div class="text-center"><i class="fa fa-warning"></i> Report is generating. Please try again later or contact system administrator.</div>');
                        /*bootbox.dialog({
                              message: '<div class="text-center"><i class="fa fa-warning"></i> Report is generating. Please try again later or contact system administrator.</div>',
                              closeButton: false
                        });*/
                    }
                },
                error: function(error) {
                    console.error("Error in AJAX request:", error);
                    alert("Error in AJAX request");
                }
            });
        }

        function generateReport(jsonResponse) {
            console.log(jsonResponse);

            // Extract relevant data from the JSON response
            
            jsonResponse.extra_figures = JSON.parse(jsonResponse.extra_figures);

            /*Data allocation*/    
            
            $('#date').html(jsonResponse.rep_for_date);
            
            if(jsonResponse.rep_for_date !== undefined){
                $('#date_to').html(jsonResponse.rep_for_date);
                $('#date_to').parent().show();
            }
            
            $('#created_on').html(jsonResponse.created_on);
            $('#created_by').html(jsonResponse.created_by);
            $('#last_modified_on').html(jsonResponse.last_modified_on);
            
            $('#ttl_purchases_value').html(convertMoney(jsonResponse.ttl_purchases_value));
            $('#ttl_pymnts_for_purchases').html(convertMoney(jsonResponse.ttl_pymnts_for_purchases));
            $('#ttl_value_of_return_to_suppliers').html(convertMoney(jsonResponse.ttl_value_of_return_to_suppliers));
            $('#ttl_value_of_paybacks_from_suppliers').html(convertMoney(jsonResponse.ttl_value_of_paybacks_from_suppliers));
            $('#ttl_sales').html(convertMoney(jsonResponse.ttl_sales));
            $('#ttl_sales_cancelled').html(convertMoney(jsonResponse.ttl_sales_cancelled));
            $('#ttl_cost_of_sales').html(convertMoney(jsonResponse.ttl_cost_of_sales));
            $('#ttl_payments_for_sales').html(convertMoney(jsonResponse.ttl_payments_for_sales));
            $('#ttl_value_of_customer_returns').html(convertMoney(jsonResponse.ttl_value_of_customer_returns));
            $('#ttl_value_of_pay_back_to_cus').html(convertMoney(jsonResponse.ttl_value_of_pay_back_to_cus));
            
            var cashAmount = jsonResponse.extra_figures.sales_extra.mop.cash;
            var ccAmount = jsonResponse.extra_figures.sales_extra.mop.cc;
            var chequeAmount = jsonResponse.extra_figures.sales_extra.mop.cheque;

            var diCount = jsonResponse.extra_figures.sales_extra.dt.di.count;
            var diAmount = jsonResponse.extra_figures.sales_extra.dt.di.amount;
            
            var taCount = jsonResponse.extra_figures.sales_extra.dt.ta.count;
            var taAmount = jsonResponse.extra_figures.sales_extra.dt.ta.amount;
            
            var dlCount = jsonResponse.extra_figures.sales_extra.dt.dl.count;
            var dlAmount = jsonResponse.extra_figures.sales_extra.dt.dl.amount;
            
            $('#mop_cash').html(convertMoney(cashAmount));
            $('#mop_cc').html(convertMoney(ccAmount));
            $('#mop_cheque').html(convertMoney(chequeAmount));
            
            $('#dt_di').html(convertMoney(diAmount) + ' <span style="display: inline-block;width: 50px;"> (' + diCount +') </span>');
            $('#dt_ta').html(convertMoney(taAmount) + ' <span style="display: inline-block;width: 50px;">(' + taCount +') </span>');
            $('#dt_dl').html(convertMoney(dlAmount) + ' <span style="display: inline-block;width: 50px;">(' + dlCount +') </span>');
        }
        function convertMoney(number){
            var formattedNumber = number.toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            });
            
            return formattedNumber;
        }
        function getDefaultHTMLContent(elementId) {
            var element = document.getElementById(elementId);
            if (element) {
                return element.innerHTML;
            } else {
                return null; // Element not found
            }
        }
        var defaultHTMLContent = '', repHTMLContent = '';
        jQuery(document).ready(function() {
            //var currentDate = new Date();
            /*var tomorrow = new Date();
            currentDate = tomorrow.setDate(tomorrow.getDate() + 1);
            $('#srh_date').datetimepicker({
                defaultDate: currentDate,
                format: "YYYY/MM/DD"
            });*/
            $('#srh_date').datetimepicker({
                defaultDate: new Date(),
                format: "YYYY/MM/DD"
            });
            $('#srh_date_to').datetimepicker({
                format: "YYYY/MM/DD"
            });
            defaultHTMLContent =  getDefaultHTMLContent("summary_table");
            repHTMLContent =  getDefaultHTMLContent("rep_details");
        });
        function resetTable(){
                /*$('#date').html(jsonResponse.rep_for_date);
                $('#created_on').html(jsonResponse.created_on);
                $('#created_by').html(jsonResponse.created_by);
                $('#last_modified_on').html(jsonResponse.last_modified_on);*/
                applyHTMLContent("rep_details", repHTMLContent);
                applyHTMLContent("summary_table", defaultHTMLContent);
        }
    </script>
</body>
<!-- end: BODY -->

</html>