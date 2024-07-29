<?php $this->load->view("common/header"); ?>
<!-- end: HEAD -->
<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/select2/select2.css" />
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />
<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/jQuery-Tags-Input/jquery.tagsinput.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/summernote/build/summernote.css">
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
                                    Quotations
                                </a>
                            </li>
                            <li class="active">
                                List Quotations
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
                            <h1>Quotations</h1>
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
                            <div class="panel-heading">
                                <i class="fa fa-external-link-square"></i>
                                Quotations
                                <div class="panel-tools" style="top:2px;">
                                    <button class="btn btn-blue dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-list"></i> Add New
                                    </button>
                                    <ul class="dropdown-menu dropdown-light pull-right">
                                        <li>
                                            <a id="" data-toggle="modal" href="<?php echo base_url('quotations/add'); ?>">
                                                <i class="fa fa-plus"></i> Add Quotation
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Location * </label>
                                            <select id="location_id" class="form-control" onchange="loadGrid()">
                                                <!--<option value="">-- Select Warehouse --</option>-->
                                                <?php
                                                $ss_warehouse_id = $this->session->userdata('ss_warehouse_id');
                                                foreach ($warehouse_list as $row) {
                                                    $sel = '';
                                                    if ($ss_warehouse_id == $row->id) {
                                                        $sel = ' selected="selected"';
                                                    }
                                                ?>
                                                    <option <?php echo $sel; ?> value="<?php echo $row->id; ?>">
                                                        <?php echo $row->name; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group" style="padding:20px;display: flex;flex-direction: row;justify-content: space-between;align-items: center;">
                                        <label for="sf">Show Finished Quotations: </label>
                                        <input style="width: 34px;" id="sf" class="form-control" type="checkbox" onchange="loadGrid()">
                                    </div>
                                </div>
                                <div id="error"></div>
                                <table class="table table-bordered table-condensed table-hover table-striped dataTable" id="warehouse_table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Reference No</th>
                                            <th>Customer</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Date</th>
                                            <th>Reference No</th>
                                            <th>Customer</th>
                                            <th>Total</th>
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
    <div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
    <!-- end ajax model -->
    <!-- start: MAIN JAVASCRIPTS -->
    <?php $this->load->view("common/footer"); ?>
    <!-- end: MAIN JAVASCRIPTS -->
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>
    <script>
        jQuery(document).ready(function() {
            //TableData.init();
            loadGrid();
        });
        function loadGrid() {
            $('#warehouse_table').DataTable({
                "ajax": {
                    method: 'post',
                    url: "<?php echo base_url('quotations/list_quotations') ?>",
                    data: {
                        sf: $('#sf').prop('checked') ? 1 : 0,
                        location_id: $('#location_id').val()
                    }
                },
                "bDestroy": true,
                "iDisplayLength": 10,
                "order": [
                    [1, "desc"]
                ]
            });
        }
        function click_quotations_view_btn(qts_id) {
            var $modal = $('#ajax-modal');
            $('body').modalmanager('loading');
            setTimeout(function() {
                $modal.load('<?php echo base_url("quotations/quotations_details?qts_id="); ?>' + qts_id, '', function() {
                    $modal.modal();
                    $(".search-select").select2({
                        placeholder: "Select a State",
                        allowClear: true
                    });
                });
            }, 1000);
        }
        function fbs_click(id) {
            u = location.href;
            t = document.title;
            window.open('quotations/qts_details?qts_id=' + id, 'sharer', 'toolbar=0,status=0,width=626,height=700, left=10, top=10,scrollbars=yes');
            return false;
        }
        function finish_qutation(sid) {
            bootbox.confirm('Finish Qutation ' + sid + '?', function(e) {
                if (e) {
                    jQuery.ajax({
                        type: "POST",
                        url: "<?php echo base_url() . 'quotations/finish_qutation?id=' ?>" + sid,
                        cache: false,
                        success: function(response) {
                            displayNotice('page', 'Successfully Updated!!');
                            loadGrid();
                        }
                    });
                }
            });
        }
        function cancel_qutation(sid) {
            bootbox.confirm('Cancel Qutation ' + sid + '?', function(e) {
                if (e) {
                    jQuery.ajax({
                        type: "POST",
                        url: "<?php echo base_url() . 'quotations/cancel_qutation?id=' ?>" + sid,
                        cache: false,
                        success: function(response) {
                            displayNotice('page', 'Successfully Updated!!');
                            loadGrid();
                        }
                    });
                }
            });
        }
    </script>
</body>
<!-- end: BODY -->
</html>