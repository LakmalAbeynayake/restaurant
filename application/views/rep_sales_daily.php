<?php $this->load->view("common/header"); ?>
<!-- end: HEAD -->
<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<?php /*?><link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/select2/select2.css" />
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />
		<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/jQuery-Tags-Input/jquery.tagsinput.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/summernote/build/summernote.css"><?php */ ?>
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
    /*Start*/
    #sales_report>tbody>tr>td>table>thead>tr>td:nth-child(1) {
        width: 15% !important;
    }
    #sales_report>tbody>tr>td>table>thead>tr>td:nth-child(2) {
        width: 45% !important;
    }
    #sales_report>tbody>tr>td>table>thead>tr>td:nth-child(3) {
        width: 20% !important;
        text-align: center;
    }
    #sales_report>tbody>tr>td>table>thead>tr>td:nth-child(4) {
        width: 20% !important;
        text-align: right;
    }
    #sales_report>tbody>tr>td:nth-child(6) {
        text-align: right;
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
                    <div class="page-header">
                        <h1>Daily Sales Report</h1>
                    </div>
                    <p>Please use the table below to navigate or filter the results. </p>
                    <!-- end: PAGE HEADER -->
                    <!-- start: PAGE CONTENT 
                    <!-- start grid -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- start: DYNAMIC TABLE PANEL -->
                            <div class="panel panel-default">
                                <div class="panel-heading"> <i class="fa fa-external-link-square"></i> Sales Report
                                    <div class="panel-tools" style="top:2px;">
                                        <button onClick="printDiv('printableArea')" class="btn btn-blue dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-print"></i> </button>
                                        <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-reorder"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item btn" href="#" onclick="get_list(true)"> Update report </a>
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
                                                        <label>Location * </label>
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
                                                        <input id="srh_from_date" name="srh_from_date" type='text' class="form-control date" value="" data-bv-field="date" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Cancellations Report</label>
                                                        <input id="sc" type='checkbox' class="form-control"/>
                                                    </div>
                                                </div>
                                                <!--<div class="col-sm-4">
                                                  <div class="form-group">
                                                    <label for="s2id_autogen1">To Date </label>
                                                    <input id="srh_to_date" name="srh_to_date" type='text' class="form-control date" value="" data-bv-field="date"/>
                                                  </div>
                                                </div>-->
                                                <div class="col-sm-4 collapse">
                                                    <div class="form-group">
                                                        <label for="dine_type">Order Type </label>
                                                        <select class="form-control" id="dine_type">
                                                            <option value="">-all-</option>
                                                            <option value="1">dine in</option>
                                                            <option value="2">take away</option>
                                                            <option value="3">delivery</option>
                                                        </select>
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading"> <i class="fa fa-external-link-square"></i> Sales List </div>
                                            <div class="panel-body">
                                                <table class="table table-bordered table-condensed table-hover dataTable" id="sales_report">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Invoice No</th>
                                                            <th>Order Type</th>
                                                            <th>Cashier</th>
                                                            <th>Item</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Invoice No</th>
                                                            <th>Order Type</th>
                                                            <th>Cashier</th>
                                                            <th>Item</th>
                                                            <th id="tot_amount" class="text-right">Amount</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
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
        </div>
        <!-- end: MAIN CONTAINER -->
        <!-- start: FOOTER -->
        <div class="footer clearfix">
            <div class="footer-inner"> 2018 &copy; smartsalleepos.com </div>
            <div class="footer-items"> <span class="go-top"><i class="clip-chevron-up"></i></span> </div>
        </div>
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
    <input name="sales-rtn-val-cost" type="hidden" id="sales-rtn-cost-fld" value="0">
    <input name="sales-rtn-val-fld" type="hidden" id="sales-rtn-val-fld" value="0">
    <input name="sale-fld" type="hidden" id="sale-fld" value="0">
    <input name="cost-fld" type="hidden" id="cost-fld" value="0">
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
    <!--<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script> -->
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
    <!-- <script src="<?php echo asset_url(); ?>js/main.js"></script>-->
    <!-- end: MAIN JAVASCRIPTS -->
    <script>
        $(document).ajaxStart(() => {
            $('#modal-loading').show();
            setTimeout(() => {
                var loading_html = '<div class="text-center" id="injected" style="font-size: large;color: white; display:none">Report is generating. Please wait...</div>';
                $('.lds-dual-ring').before(loading_html);
                $('#injected').show('slow');
            }, 1000);
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
            $('#srh_from_date').val('');
        }
        function searchDetails() {
            const today = new Date(); // Get the current date and time
            // Format the current date in 'YYYY-MM-DD' format
            const formattedToday = today.toISOString().split('T')[0];
            var requesting_date = $('#srh_from_date').val();
            var demand = formattedToday === requesting_date ? true : false;
            // get_list(isSameDateAsToday());
            get_list(demand);
        }
        jQuery(document).ready(function() {
            $('#srh_from_date').datetimepicker({
                defaultDate: new Date(),
                format: "YYYY-MM-DD"
            });
        });
        function isSameDateAsToday() {
            // Get the value of #srh_from_date
            var fromDateValue = $('#srh_from_date').val();
            // Get the current date in the format YYYY/MM/DD
            var currentDate = new Date().toISOString().split('T')[0].replace(/-/g, '/');
            // Compare the dates
            return fromDateValue === currentDate;
        }
        function get_list(update = false) {
            if (!$('#srh_from_date').val()) {
                bootbox.alert("Date is required!");
                return;
            }
            $.ajax({
                url: '<?php echo base_url() ?>summary/gen_daily_sales_gon_report',
                method: 'POST',
                data: {
                    location_id: $('#srh_warehouse_id').val(),
                    date: $('#srh_from_date').val(),
                    update: update,
                    sc  : $('#sc').prop('checked')
                },
                beforeSend: () => {
                    const salesReportTable = document.getElementById("sales_report").querySelector('tbody');
                    salesReportTable.innerHTML = '';
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status === true) {
                        append_data(response);
                    } else {
                        alert('AJAX request failed: ' + response.msg);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX request failed:', textStatus, errorThrown);
                }
            });
        }
        function append_data(jsonData) {
            const salesReportTable = document.getElementById("sales_report").querySelector('tbody');
            // Process data for the table
            var tot_amount = 0;
            jsonData.data.forEach(item => {
                const newRow = salesReportTable.insertRow();
                // Add cells to the row
                const dateCell = newRow.insertCell(0);
                const invoiceNoCell = newRow.insertCell(1);
                const orderTypeCell = newRow.insertCell(2);
                const cashierCell = newRow.insertCell(3);
                const itemCell = newRow.insertCell(4);
                const amountCell = newRow.insertCell(5);
                // Populate cells with data
                dateCell.textContent = item.date;
                invoiceNoCell.innerHTML  = '<a target="_'+item.invoice_no+'" href="<?php echo base_url() ?>sales/view/'+item.invoice_no+'">'+item.invoice_no+'</a>';
                orderTypeCell.textContent = item.order_type == 1 ? "Dine-In" : "Take-Away";
                cashierCell.textContent = item.cashier_name;
                // Parse the items JSON string and create a nested table for the "item" cell
                const itemsArray = JSON.parse(item.items);
                const itemTable = document.createElement('table');
                // Add classes to the nested table
                itemTable.classList.add('table', 'table-bordered', 'table-condensed', 'table-hover', 'table-striped');
                // Create thead element and header row for the nested table
                const thead = document.createElement('thead');
                const headerRow = thead.insertRow();
                headerRow.insertCell(0).textContent = 'Code';
                headerRow.insertCell(1).textContent = 'Name';
                headerRow.insertCell(2).textContent = 'Qty';
                headerRow.insertCell(3).textContent = 'Rate';
                // Append thead to the nested table
                itemTable.appendChild(thead);
                // Populate rows in the nested table
                itemsArray.forEach(product => {
                    const productRow = itemTable.insertRow();
                    productRow.insertCell(0).textContent = product.code;
                    productRow.insertCell(1).textContent = product.name;
                    productRow.insertCell(2).textContent = product.quantity;
                    productRow.insertCell(3).textContent = product.unit_price;
                });
                // Append the nested table to the "itemCell"
                itemCell.appendChild(itemTable);
                amountCell.textContent = accounting.formatMoney(item.amount,'',2,',','.');
                tot_amount += parseFloat(item.amount);
                // Check if sale_status equals 99
                if (item.sale_status === "99") {
                    newRow.style.backgroundColor = "yellow"; // Change background color to yellow
                }
                // Add data-sale_status attribute to each row
                newRow.setAttribute("data-sale_status", item.sale_status);
            });
            $('#tot_amount').text(accounting.formatMoney(tot_amount,'Rs ',2,',','.'));
        }
    </script>
</body>
<!-- end: BODY -->
</html>