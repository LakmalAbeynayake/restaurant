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
    .bold {
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
    .dropdown-menu {
        left: -100%;
    }
</style>
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />
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
                        <h1>Daily Item Sale Report!</h1>
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
                                        <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-reorder"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item btn" href="#" onclick="get_data(true)"> Update report </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Location </label>
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
                                        <div class="form-group pull-right">
                                            <label for="s2id_autogen1">&nbsp;<br>
                                                <br>
                                            </label>
                                            <input type="submit" name="add_category" value="Search" class="btn btn-primary" onClick="get_data(false)">
                                            &nbsp;&nbsp;
                                            <input type="submit" name="add_category" value="Reset" class="btn btn-danger" onClick="searchDetailsReset()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <br>
                                <div style="display:flex;justify-content: space-between;">
                                    <?php
                                    foreach ($types as $type) {
                                        echo '<label style="background: #ffffff;padding: 10px;border: solid 2px #7f7fff;border-radius: 10px;" for="pt_' . $type->product_type_id . '"> <input id="pt_' . $type->product_type_id . '" checked type="checkbox" class="product_type" style="width: 20px;height: 20px;vertical-align: bottom;" value="' . $type->product_type_id . '"> ' . $type->product_type_name . ' </label>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div id="printableArea">
                                <div class="page-header text-center">
                                    <!--<h1>Daily Summary Report</h1>-->
                                </div>
                                <table class="table table-bordered table-condensed table-hover table-striped dataTable" id="summary_table">
                                    <thead>
                                        <tr style="position: sticky;top: 60px;">
                                            <th>Product Name (Code)</th>
                                            <th>Sold Quantity</th>
                                            <th>Return Quantity</th>
                                            <th>Balance</th>
                                            <th>Unit Price</th>
                                            <th>Sub total</th>
                                        </tr>
                                    </thead>
                                    <tbody> </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-right">Total</td>
                                            <td id="total">0.00</td>
                                        </tr>
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
        <input type="hidden" id="update" value="false">
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
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script>
    <!-- <script src="<?php echo asset_url(); ?>js/main.js"></script>-->
    <!-- end: MAIN JAVASCRIPTS -->
    <script>
        $(document).ajaxStart(() => {
            $('#modal-loading').show();
            setTimeout(() => {
                var loading_html = '<div class="text-center" id="injected" style="font-size: large;color: white; display:none">Report is generating. Please wait...</div>';
                $('.lds-dual-ring').before(loading_html);
                $('#injected').show('slow');
            }, 3000);
        });
        $(document).ajaxStop(() => {
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
        function get_data(update = false) {
            const date = $('#srh_date').val();
            const srh_date_to = $('#srh_date_to').val();
            const srh_warehouse_id = $('#srh_warehouse_id').val();
            resetTable();
            // Make an AJAX post request
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>summary/get_daily_item_sale",
                data: {
                    date: date,
                    update: update,
                    location_id: srh_warehouse_id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    // Call the generateReport function with the response
                    if ($(response).length) {
                        // Wrap the manage_response function in a promise
                        manage_response(response)
                            .then(init_dt) // Chain the promise resolution to call init_dt
                            .catch(function(error) {
                                console.error("Error in manage_response:", error);
                            });
                    } else {
                        bootbox.alert('<div class="text-center"><i class="fa fa-warning"></i> Report is generating. Please try again later or contact system administrator.</div>');
                    }
                },
                error: function(error) {
                    console.error("Error in AJAX request:", error);
                    alert("Error in AJAX request");
                }
            });
        }
        function manage_response(response) {
            return new Promise(function(resolve, reject) {
                try {
                    for (let i = 0; i < response.length; i++) {
                        appendRowToTable(response[i]);
                    }
                    resolve(); // Resolve the promise when the loop completes
                } catch (error) {
                    reject(error); // Reject the promise if there's an error
                }
            });
        }
        function init_dt() {
            $('#summary_table').DataTable({
                paging: false,
                destroy: true
            });
            $('.product_type').change();
        }
        $(document).on('change', '.product_type', function() {
            var type = this.value;
            if ($(this).prop('checked') === true) {
                $(`[data-product_type="${type}"]`).show();
                return;
            }
            $(`[data-product_type="${type}"]`).hide();
        });
        function appendRowToTable(data) {
            // Create a new row HTML string using a template literal
            var tr = `<tr data-product_type="${data.product_type}">
                        <td>${data.product_name} (${data.product_id})</td>
                        <td>${data.sale_quantity}</td> 
                        <td>${data.return_quantity}</td>
                        <td>${data.balance_quantity}</td>
                        <td>${data.unit_price}</td>
                        <td>${data.sub_total} <input type="hidden" class="sub_total" value="${data.sub_total}"></td>
                     </tr>`;
            // Append the new row HTML string to the table
            $('#summary_table tbody').append(tr);
        }
        $(document).on('change', '.product_type', function() {
            var type = this.value;
            if ($(this).prop('checked') === true) {
                $(`[data-product_type="${type}"]`).show();
                cal_total();
                return;
            }
            $(`[data-product_type="${type}"]`).hide();
            cal_total();
        });
        function cal_total() {
            var total = 0;
            $('.sub_total').each(function() {
                if ($(this).closest('tr').css('display') != 'none') {
                    total += parseFloat(this.value);
                }
            });
            $('#total').text(convertMoney(total));
        }
        function convertMoney(number) {
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
        var defaultHTMLContent = '',
            repHTMLContent = '';
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
            defaultHTMLContent = getDefaultHTMLContent("summary_table");
            repHTMLContent = getDefaultHTMLContent("rep_details");
        });
        function resetTable() {
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