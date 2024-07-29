<?php $this->load->view("common/header"); ?>
<!-- end: HEAD -->
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
                            <li> <a href="<?php echo base_url('sales'); ?>"> Sales </a> </li>
                            <li class="active"> List Sales </li>
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
                            <h1>Sales</h1>
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
                            <div class="panel-heading"> <i class="fa fa-external-link-square"></i> Sales
                                <div class="panel-tools" style="top:2px;">
                                    <button class="btn btn-blue dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-list"></i> Add New </button>
                                    <ul class="dropdown-menu dropdown-light pull-right">
                                        <li> <a id="" data-toggle="modal" href="<?php echo base_url('sales/add/45625466'); ?>"> <i class="fa fa-plus"></i> Add Sales </a> </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-sm-12">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>User </label>
                                            <select id="srh_user_id" class="form-control search-select" name="srh_user_id" onchange="loadGrid()">
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
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>From Date </label>
                                            <input id="srh_from_date" name="srh_from_date" type='text' class="form-control date" value="" data-bv-field="date" / onchange="loadGrid()">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="s2id_autogen1">To Date </label>
                                            <input id="srh_to_date" name="srh_to_date" type='text' class="form-control date" value="" data-bv-field="date" / onchange="loadGrid()">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="s2id_autogen1">. </label>
                                            <button class="form-control btn btn-warning btn-xs" onclick="loadGrid()"> FILTER </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="error"></div>
                                <table width="100%" class="table table-bordered table-condensed table-hover table-striped dataTable" id="warehouse_table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Invoice No</th>
                                            <th>Customer</th>
                                            <th>Cahier</th>
                                            <th>Waiter</th>
                                            <th>Grand Total</th>
                                            <th class="no-sort">Return</th>
                                            <th class="no-sort">Total to be paid</th>
                                            <th class="no-sort">Paid</th>
                                            <th class="no-sort">Balance</th>
                                            <th class="no-sort">Payment Status</th>
                                            <th class="no-sort">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Date</th>
                                            <th>Invoice No</th>
                                            <th>Customer</th>
                                            <th>Cahier</th>
                                            <th>Waiter</th>
                                            <th>Grand Total</th>
                                            <th>&nbsp;</th>
                                            <th>Paid</th>
                                            <th>Balance</th>
                                            <th>Payment Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
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
    <!-- end: MAIN CONTAINER -->
    <!-- start: FOOTER -->
    <div class="footer clearfix">
        <div class="footer-inner"> 2018 &copy; smartsalleepos.com </div>
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
    <!-- start ajax model -->
    <div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
    <!-- end ajax model -->
    <!-- start: MAIN JAVASCRIPTS -->
    <?php $this->load->view("common/footer"); ?>
    <!-- end: MAIN JAVASCRIPTS -->
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/dataTables.buttons.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/buttons.print.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/buttons.flash.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/jszip.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/pdfmake.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/buttons.print.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>
    <script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script>
    <script>
        jQuery(document).ready(function() {
            //TableData.init();
            $('select[name = warehouse_table_length]').addClass('search-select');
            $('select[name = warehouse_table_length]').select2();
            $('#s2id_autogen1').css("margin-top", -8);
            var currentDate = new Date();
            $('#srh_to_date').datetimepicker({
                defaultDate: new Date()
            });
            $('#srh_from_date').datetimepicker({
                defaultDate: moment(currentDate).hours(0).minutes(0).seconds(0).milliseconds(0)
            });
            setTimeout(function() {
                loadGrid();
            }, 1000);
        });
        function loadGrid() {
            var srh_from_date = $('#srh_from_date').val();
            var srh_to_date = $('#srh_to_date').val();
            var srh_user_id = $('#srh_user_id').val();
            $('#warehouse_table').DataTable({
                dom: 'Blfrtip',
                columnDefs: [{
                    "targets": 'no-sort',
                    "orderable": false,
                }],
                buttons: [{
                    extend: 'print',
                    text: '<i class="fa fa-print fa-2x">',
                    header: true,
                    footer: true,
                    //autoPrint: false,
                    title: "SALES LIST",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    },
                    customize: function(win) {
                        $(win.document.body).css('font-size', '12pt').prepend('<img src="<?php echo asset_url(); ?>images/logo.png" style="position:absolute; top:0; left:0; height:60px;" />');
                        $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                        $(win.document.body).find('h1').html("<center>Baker's Choice Sales List</center>");
                    }
                }, {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o fa-2x">',
                    footer: true
                }, {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf-o fa-2x"></i>',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    }
                }],
                "bProcessing": true,
                "serverSide": true,
                "ajax": "<?php echo base_url('sales/list_sales?') ?>" + "srh_from_date=" + srh_from_date + "&srh_to_date=" + srh_to_date + "&srh_user_id=" + srh_user_id,
                "bDestroy": true,
                "iDisplayLength": 10,
                "order": [
                    [0, "desc"]
                ],
                "fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay) {
                    $("html, body").animate({
                        scrollTop: 100
                    }, "slow");
                    /*var pq = 0,
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
                    var ser_tot6 = 0;
                    //var sales_rtn=0;
                    for (var i = 0; i < aaData.length; i++) {
                        //alert(aaData[[i]][5]);
                        // p = (aaData[aiDisplay[i]][2]).split('__');
                        ser_tot1 += parseFloat(aaData[[i]][3]);
                        ser_tot2 += parseFloat(aaData[[i]][4]);
                        ser_tot3 += parseFloat(aaData[[i]][5]);
                        ser_tot6 += parseFloat(aaData[[i]][6]);
                    }
                    var nCells = nRow.getElementsByTagName('th');
                    nCells[3].innerHTML = '<div class="text-right">' + accounting.formatMoney(ser_tot1, "", 2, ",", ".") + ' </div>';
                    nCells[4].innerHTML = '<div class="text-right">' + accounting.formatMoney(ser_tot2, "", 2, ",", ".") + ' </div>';
                    nCells[5].innerHTML = '<div class="text-right">' + accounting.formatMoney(ser_tot3, "", 2, ",", ".") + ' </div>';
                    nCells[6].innerHTML = '<div class="text-right">' + accounting.formatMoney(ser_tot6, "", 2, ",", ".") + ' </div>';
                    var sales_rtn_tot_cost = ser_tot1;
                    var sales_rtn_tot_val = ser_tot2;
                    $('#sales-rtn-cost-fld').val(accounting.formatMoney(sales_rtn_tot_cost, "", 2, ",", "."));
                    $('#sales-rtn-val-fld').val(accounting.formatMoney(sales_rtn_tot_val, "", 2, ",", "."));
                    $('#sales-rtn-cost-tbl').text(accounting.formatMoney(sales_rtn_tot_cost, "", 2, ",", "."));
                    $('#sales-rtn-val-tbl').text(accounting.formatMoney(sales_rtn_tot_val, "", 2, ",", "."));*/
                }
            });
        }
        function click_sales_view_btn(sale_id) {
            var $modal = $('#ajax-modal');
            $('body').modalmanager('loading');
            setTimeout(function() {
                $modal.load('<?php echo base_url("sales/sale_details_pos?sale_id="); ?>' + sale_id, '', function() {
                    $modal.modal();
                    $(".search-select").select2({
                        placeholder: "Select a State",
                        allowClear: true
                    });
                });
            }, 1000);
        }
        function print_bill(element) {
            var sale_id = $(element).data('sale_id');
            u = location.href;
            t = document.title;
            window.open('sales/sale_details_pos?sale_id=' + sale_id + '&dd=1', 'sharer', 'toolbar=0,status=0,width=350,height=700, left=10, top=10,scrollbars=yes');
            return false;
        }
        function delete_invoice(elem) {
            var sale_id = $(elem).data('sale_id');
            var group_id = $('#group_id').val();
            //var confm =	window.confirm("Delete This Invoice ?");		
            if (group_id != 3) {
                bootbox.confirm('Delete Invoice ' + sale_id + '?', function(e) {
                    if (e) {
                        jQuery.ajax({
                            type: "POST",
                            url: "<?php echo base_url() . 'sales/sales_delete?sale_id=' ?>" + sale_id,
                            cache: false,
                            dataTyle: 'json',
                            success: function(response) {
                                if (response.success)
                                    displayNotice('page', 'Successfully Deleted!!');
                                else
                                    displayNotice('page', 'Please wait!');
                                loadGrid();
                            }
                        });
                    }
                });
            }
        }
        function delete_payments(elem) {
            var sale_id = $(elem).data('sale_id');
            var group_id = $('#group_id').val();
            //var confm =	window.confirm("Delete Payments ?");
            if (group_id != 3) {
                bootbox.confirm('Delete Invoice Payments of Invoice ID: ' + sale_id + '?', function(e) {
                    if (e) {
                        jQuery.ajax({
                            type: "POST",
                            url: "<?php echo base_url() . 'sales/sale_pymnts_delete?sale_id=' ?>" + sale_id + "&in_type=sale",
                            cache: false,
                            success: function(response) {
                                displayNotice('page', 'Successfully Deleted!!');
                                loadGrid();
                            }
                        });
                    }
                });
            }
        }
    </script>
</body>
<!-- end: BODY -->
</html>