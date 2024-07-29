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
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />
<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/jquery.dataTables.css">
<style>
    .modal-dialog{
        padding: 0 !important;
        width: 100% !important;
        margin: 0 !important;
    }
    .missing{
        border: solid red;
        font-weight: bold;
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
                                <a href="<?php echo base_url('transfer'); ?>">
                                    List Transfer
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
                                Transfer Number <?php echo $trnsfr_id ?>
                                <div class="panel-tools" style="top:2px;">
                                </div> <!--panel-tools-->
                            </div> <!--panel-heading-->
                            <div class="panel-body">
                                <div class="well well-sm">
                                    <div class="col-xs-4 border-right">
                                        <div class="col-xs-2"><i class="fa fa-3x fa-file-text-o padding010 text-muted"></i></div>
                                        <div class="col-xs-10">
                                            <h4 class="">Reference No : <?php echo $trnsfr_details['trnsfr_reference_no']; ?></h4>
                                            <p>Date: <?php echo site_date_time($trnsfr_details['added_on']) ?></p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="col-xs-2"><i class="fa fa-3x fa-building-o padding010 text-muted"></i></div>
                                        <div class="col-xs-10">
                                            <h4 class="">From:<?php echo $location_details['name']; ?></h4>
                                            <?php echo $location_details['address']; ?><p></p>
                                            Tel: <?php echo $location_details['phone']; ?><br>
                                            Email: <?php echo $location_details['email']; ?>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col-xs-4 border-right">
                                        <div class="col-xs-2"><i class="fa fa-3x fa-building-o padding010 text-muted"></i></div>
                                        <div class="col-xs-10">
                                            <h4 class="">To:<?php echo $receiver_details['name']; ?></h4>
                                            <?php echo $receiver_details['address']; ?><br>
                                            Tel: <?php echo $receiver_details['phone']; ?><br>
                                            Email: <?php echo $receiver_details['email']; ?>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div> <!--col-xs-4-->
                                
                                <?php if($trnsfr_details['approval_status']){ ?>
                                            <div class="well">
									            <code style="padding:0">
									                Status      : Approved. Stock has been updated! <br>
									                Approved On : <?php echo $trnsfr_details['approved_on']; ?><br>
									                Approved By : <?php echo $trnsfr_details['approved_by']; ?>
									            </code>
									        </div>
                                        <?php }else{ ?>
                                            <div class="well">
									            <code style="padding:0">
									                Status      : Not Approved. Stock has NOT been updated! <br>
									                Approved On : --/--<br>
									                Approved By : --/--
									            </code>
									        </div>
                                        <?php } ?>
                                
                                <div class="col-xs-5">
                                    <input name="trnsfr_id" type="hidden" id="trnsfr_id" value="<?php echo $trnsfr_id ?>">
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
                                                <th style="text-align:center; vertical-align:middle;">Unite Price</th>
                                                <!--<th style="padding-right:20px;">Discount</th>-->
                                                <th style="padding-right:20px;">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total = 0;
                                            $tmpcount = 0;
                                            foreach ($trnsfr_item_list as $row) {
                                                $tmpcount++;
                                            ?>
                                                <tr id="itm_<?php echo $row['product_id']; ?>">
                                                    <td style="text-align:center; width:40px; vertical-align:middle;"><?php echo $tmpcount ?></td>
                                                    <td style="vertical-align:middle;"><?php echo $row['product_name']; ?> (<?php echo $row['product_code']; ?>)</td>
                                                    <td style="width: 100px; text-align:center; vertical-align:middle;"><?php echo number_format($row['trnsfr_itm_quantity'], 2, '.', ',') ?></td>
                                                    <td><?php echo number_format($row['trnsfr_itm_unit_value'], 2, '.', ',') ?></td>
                                                    <!--<td style="text-align:right; width:120px; padding-right:10px;">(<?php //echo $row['discount'] ?>) <?php //echo number_format($row['discount_val'], 2, '.', ',') ?></td>-->
                                                    <td style="text-align:right; width:120px; padding-right:10px;"><?php echo number_format($row['trnsfr_itm_quantity'] * $row['trnsfr_itm_unit_value'],2,'.',',' ); ?></td>
                                                </tr>
                                                <?php 
                                                
                                                $total += ($row['trnsfr_itm_quantity'] * $row['trnsfr_itm_unit_value']) ; ?>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <!--<td style="text-align:right; padding-right:10px;" colspan="4">Order Discount</td>-->
                                                <td style="text-align:right; padding-right:10px;"><?php //echo number_format($trnsfr_details['trnsfr_inv_discount_amount'], 2, '.', ',') ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:right; padding-right:10px;" colspan="4">Total Amount
                                                </td>
                                                <td style="text-align:right; padding-right:10px;"><?php echo number_format($trnsfr_details['trnsfr_total'], 2, '.', ',') ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div> <!--table-responsive-->
                                <div class="clearfix"></div>
                                <p></p>
                                <div class="well well-sm col-xs-6 pull-right">
                                    <div class="col-xs-10">
                                        <p>Created by : <?php echo $trnsfr_details['user_first_name']." ".$trnsfr_details['user_last_name'] ?> (<?php echo $trnsfr_details['user_id']; ?>) </p>
                                        <p>Date:<?php echo display_date_time_format($trnsfr_details['added_on']) ?></p>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="clearfix"></div>
                                </div> <!--well well-sm col-xs-6 pull-right-->
                                <div class="buttons">
                                    <div class="btn-group btn-group-justified">
                                        <?php if(!$trnsfr_details['approval_status']){ ?>
                                        <div class="btn-group"><a data-toggle="modal" title="" class="tip btn btn-warning tip" href="#" onclick="approve()" id="approve" data-original-title="Add to Stock"><i class="fa fa-check"></i>
                                            <span class="hidden-sm hidden-xs">Approve and Deduct from Stock</span></a>
							            </div>
                                        <div class="btn-group"><a data-toggle="modal" title="" class="tip btn btn-default tip" href="<?php echo base_url("transfer/add/".$trnsfr_details['trnsfr_id']) ?>"><i class="fa fa-edit"></i>
                                            <span class="hidden-sm hidden-xs">Edit</span></a>
							            </div>
							          <?php } ?>
                                        <div class="btn-group" onClick="print_doc(<?php echo $trnsfr_id; ?>)"><a title="" class="tip btn btn-primary" data-original-title="Print"><i class="fa fa-print"></i> <span class="hidden-sm hidden-xs">Print</span></a>
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
        <div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
        <!-- end ajax model -->
        <!-- start: MAIN JAVASCRIPTS -->
        <?php $this->load->view("common/footer"); ?>
        <!-- end: MAIN JAVASCRIPTS -->
        <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
        <script type="text/javascript" src="<?php echo asset_url(); ?>plugins/bootbox/bootbox.min.js"></script>
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
            function uuidv4() {
                return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                    var r = Math.random() * 16 | 0,
                        v = c == 'x' ? r : (r & 0x3 | 0x8);
                    return v.toString(16);
                });
            }
            jQuery(document).ready(function() {
                var dataTable = j('#employee-grid').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: "transfer/list_transfer", // json datasource
                        type: "post", // method  , by default get
                        error: function() { // error handling
                            j(".employee-grid-error").html("");
                            j("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                            //$("#employee-grid_processing").css("display","none");
                        }
                    }
                });
            });
            
            function print_doc(id) {
                u = location.href;
                t = document.title;
                window.open('<?php echo base_url() ?>transfer/trnsfr_details?trnsfr_id=' + id, 'sharer', 'toolbar=0,status=0,width=700,height=700, left=10, top=10,scrollbars=yes');
                return false;
            }
            
            function approve(){
                
                bootbox.confirm("Are you sure?",(a)=>{
                    if(a){
                        $('#approve').prop('disabled',true);
                        var transfer_id = <?php echo $trnsfr_details['trnsfr_id']; ?>;
                        var jsonData = {
                              transfer_id: transfer_id,
                              uuid: uuidv4()
                            };
                        // AJAX POST request
                        $.ajax({
                            url: "<?php echo base_url()?>transfer/approve",
                            type: "POST",
                            dataType: "json",
                            data: jsonData,
                            success: function(resp){
                                console.log(resp);
                                
                                if(resp.success){
                                    bootbox.alert("Approved");
                                    setTimeout(()=>{
                                        window.location.reload();
                                    },300);
                                }else{
                                    bootbox.alert(`
                                    <div class="alert alert-danger"> <i class="fa fa-times-circle"></i> <strong>ERROR!</strong> Unauthorized Items or check stock in the warehouse and try again. </div>`,()=>{
                                        //window.location.reload();
                                    });
                                    console.log(resp.list);
                                    var l = resp.list;
                                    l.forEach((a,b)=>{
                                        console.log(a);
                                        $('#itm_'+a).addClass('missing');
                                    });
                                }
                            },
                            /*statusCode: {
                                200: function(response) {
                                    console.log('200',response);
                                    // Handle a successful response with status code 200
                                    bootbox.alert("Approved");
                                    setTimeout(()=>{
                                        window.location.reload();
                                    },300);
                                },
                                201: function(response) {
                                    console.log('201',response);
                                    // Handle a successful response with status code 201
                                    bootbox.alert("Created: " + JSON.stringify(response));
                                },
                                404: function(response) {
                                    console.log('404',response);
                                    // Handle a not found response with status code 404
                                    bootbox.alert("Not Found");
                                },
                                500: function(response) {
                                    console.log('500',response);
                                    // Handle a server error response with status code 500
                                    bootbox.alert("Internal Server Error");
                                }
                                // Add more status code handlers as needed
                            }*/
                            error: function(error) {
                                bootbox.alert("Unexpected Error",()=>{
                                    /*window.location.reload();*/
                                });
                                console.log('error',error);
                                // Handle other errors
                                //bootbox.alert("Error: " + JSON.stringify(error));
                            }
                        });
                    }
                });
            }
        </script>
</body>
<!-- end: BODY -->
</html>