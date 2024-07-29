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
<!-- DataTables Buttons CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
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
                        <h1>Daily Stock Summary</h1>
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
                                    <div class="col-sm-4 collapse">
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
                                        foreach($types as $type){
                                            echo '<label style="background: #ffffff;padding: 10px;border: solid 2px #7f7fff;border-radius: 10px;" for="pt_'.$type->product_type_id.'"> <input id="pt_'.$type->product_type_id.'" checked type="checkbox" class="product_type" style="width: 20px;height: 20px;vertical-align: bottom;" value="'.$type->product_type_id.'"> '.$type->product_type_name.' </label>';
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div id="printableArea" style="overflow: auto;">
                                <div class="page-header text-center">
                                    <!--<h1>Daily Summary Report</h1>-->
                                </div>
                                <table class="table table-bordered table-condensed table-hover table-striped dataTable" id="summary_table">
                                    <thead>
                                        <tr style="position: sticky;top: 60px;">
                                            <th>Product Name (Code)</th>
                                            <th>Opening Balance</th>
                                            <th>G.R.N</th>
                                            <th>G.T.N</th>
                                            <th>Sale</th>
                                            <th>Recipe</th>
                                            <th>Cancel</th>
                                            <th>Damadges</th>
                                            <th>Staff Meal</th>
                                            <th>Adjustments</th>
                                            <th>Closing Balance</th>
                                            <th>Opening Amount</th>
                                            <th>G.R.N Amount</th>
                                            <th>G.T.N Amount</th>
                                            <th>Sale Amount</th>
                                            <th>Recipe Amount</th>
                                            <th>Cancel Amount</th>
                                            <th>Damadges Amount</th>
                                            <th>Staff Meal Amount</th>
                                            <th>Adjustments Amount</th>
                                            <th>Closing Balance Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody> </tbody>
                                    <tfoot>
                                        <tr>
                                            <!-- Footer cells to display totals -->
                                            <td>Total</td>
                                            <td id="total_opening_balance"></td>
                                            <td id="total_grn_quantity"></td>
                                            <td id="total_gtn_quantity"></td>
                                            <td id="total_sale_quantity"></td>
                                            <td id="total_consume_quantity"></td>
                                            <td id="total_return_quantity"></td>
                                            <td id="total_damadge_quantity"></td>
                                            <td id="total_staff_meal"></td>
                                            <td id="total_adjusted_quantity"></td>
                                            <td id="total_closing_balance"></td>
                                            <td id="total_opening_balance_amount"></td>
                                            <td id="total_grn_amount"></td>
                                            <td id="total_gtn_amount"></td>
                                            <td id="total_sale_amount"></td>
                                            <td id="total_consume_amount"></td>
                                            <td id="total_return_amount"></td>
                                            <td id="total_damadge_amount"></td>
                                            <td id="total_staff_meal_amount"></td>
                                            <td id="total_adjusted_amount"></td>
                                            <td id="total_closing_balance_amount"></td>
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
    
    <!-- DataTables Buttons JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>

    
    
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
                url: "<?php echo base_url() ?>summary/get_daily_stock",
                data: {
                    date: date,
                    update: update,
                    location_id : srh_warehouse_id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    // Call the generateReport function with the response
                    if ($(response).length) {
                        // Wrap the manage_response function in a promise
                        manage_response(response)
                            .then(init_dt).then(calculateTotals) // Chain the promise resolution to call init_dt
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
        function appendRowToTable(data) {
            // Create a new row HTML string using a template literal
            var tr = `<tr data-product_type="${data.product_type}">
                        <td>${data.product_name} (${data.product_id})</td>
                        <td>${data.opening_balance}</td>
                        <td>${data.grn_quantity}</td>
                        <td>${data.gtn_quantity}</td>
                        <td>${data.sale_quantity}</td>
                        <td>${data.consume_quantity}</td>
                        <td>${data.return_quantity}</td>
                        <td>${data.damadge_quantity}</td>
                        <td>${data.staff_meal}</td>
                        <td>${data.adjusted_quantity}</td>
                        <td>${data.closing_balance}</td>
                        <td>${data.opening_balance_amount}</td>
                        <td>${data.grn_amount}</td>
                        <td>${data.gtn_amount}</td>
                        <td>${data.sale_amount}</td>
                        <td>${data.consume_amount}</td>
                        <td>${data.return_amount}</td>
                        <td>${data.damadge_amount}</td>
                        <td>${data.staff_meal_amount}</td>
                        <td>${data.adjusted_amount}</td>
                        <td>${data.closing_balance_amount}</td>
                     </tr>`;
            // Append the new row HTML string to the table
            $('#summary_table tbody').append(tr);
        }
        function init_types(){
            $('.product_type').each(function(a,b){
                var type = this.value;
                if($(this).prop('checked') === true)
               {
                   $(`[data-product_type="${type}"]`).show();
                   return;
               }
               $(`[data-product_type="${type}"]`).hide();
            });
        }
        $(document).on('change', '.product_type', function() {
            var type = this.value;
            $(`[data-product_type="${type}"]`).toggle($(this).prop('checked'));
            calculateTotals();
        });
        function calculateTotals() {
            let totals = new Array(20).fill(0);
        
            $('#summary_table tbody tr:visible').each(function() {
                $(this).find('td').each(function(index) {
                    if (index > 0 && index <= 20) { // Only consider relevant columns (index 1 to 20)
                        totals[index - 1] += parseFloat($(this).text()) || 0;
                    }
                });
            });
        
            updateFooter(totals);
        }
        
        function updateFooter(totals) {
            let ids = [
                'total_opening_balance', 'total_grn_quantity', 'total_gtn_quantity', 'total_sale_quantity', 
                'total_consume_quantity', 'total_return_quantity', 'total_damadge_quantity', 'total_staff_meal', 
                'total_adjusted_quantity', 'total_closing_balance', 'total_opening_balance_amount', 'total_grn_amount', 
                'total_gtn_amount', 'total_sale_amount', 'total_consume_amount', 'total_return_amount', 
                'total_damadge_amount', 'total_staff_meal_amount', 'total_adjusted_amount', 'total_closing_balance_amount'
            ];
        
            ids.forEach((id, index) => {
                $(`#${id}`).text(totals[index].toFixed(3));
            });
        }
        function init_dt() { 
            $('#summary_table').DataTable({
                dom: 'Blfrtip',
                paging: false,
                destroy: true,
                buttons: [
                    {
                        extend: 'excelHtml5', // Add Excel export button
                        exportOptions: {
                            modifier: {
                                selected: true,
                                search: 'none'
                            },
                            rows: function (idx, data, node) {
                                return $(node).is(':visible');
        
                            }
                        }
                    }, // Add Excel export button
                    'pdfHtml5'
                ]
            });
            init_types();
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
            $('#srh_date').datetimepicker({
                defaultDate: new Date(),
                format: "YYYY/MM/DD"
            });
            $('#srh_date_to').datetimepicker({
                format: "YYYY/MM/DD"
            });
            defaultHTMLContent = getDefaultHTMLContent("summary_table");
        });
        function resetTable() {
            applyHTMLContent("summary_table", defaultHTMLContent);
        }
        function convertMoney(number) {
            var formattedNumber = number.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            return formattedNumber;
        }
    </script>
</body>
<!-- end: BODY -->
</html>