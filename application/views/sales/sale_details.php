<style type="text/css">
    .fa-3x {
        font-size: 2em !important;
    }
    .report_view_th {
        background-color: #428bca;
        color: #fff !important;
        font-size: 14px;
    }
    .table-responsive td {
        font-size: 14px;
    }
    /*h4 {
        font-size: 13px;
    }*/
    
    .modal-dialog {
        width: 100% !important;
        margin: 0 !important;
    }
    tr.strikethrough {
        text-decoration: line-through; /* Apply strikethrough style */
        color: #969696;
    }
    
</style>
<?php $this->load->view("common/header"); ?>
<!-- end: HEAD -->
<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />
<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">
<!--<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">-->
<!--<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">-->
<!--<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/jQuery-Tags-Input/jquery.tagsinput.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/summernote/build/summernote.css">-->
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
                                <a href="<?php echo base_url('sales'); ?>">
                                    Sales
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
                            }else{
                                $err_message = $this->session->flashdata('err_message');
                                if ($err_message){
                                ?>
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <?php echo $err_message ?>
                                </div>
                                <?php
                                }
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
                                Sale Number <?php echo $sale_id ?>
                                <div class="panel-tools" style="top:2px;">
                                    <button class="btn btn-blue dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-list"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-light pull-right">
                                        <li>
                                            <a id="" data-toggle="modal" href="<?php echo base_url('sales/add/423214568'); ?>">
                                                <i class="fa fa-plus"></i> Add Sales
                                            </a>
                                        </li>
                                    </ul>
                                </div> <!--panel-tools-->
                            </div> <!--panel-heading-->
                            <div class="panel-body">
                                <div class="well well-sm">
                                    <div class="col-xs-4 border-right">
                                        <div class="col-xs-2"><i class="fa fa-3x fa-file-text-o padding010 text-muted"></i></div>
                                        <div class="col-xs-10">
                                            <h4 class="">Invoice No : <?php echo $sale_details['sale_id']; ?></h4>
                                            
                                            <?php
                                            
                                            if ($sale_details['sale_status'] == 99) {
                                                echo '<span class="label label-danger">Canceled Sale: '.$sale_details['cancellation_reasons'].'</span>';
                                            }
                                            
                                            ?>
                                            
                                            <!--<h4 class="">Invoice No : <?php echo $sale_details['sale_reference_no']; ?></h4>-->
                                            
                                            <?php if($sale_details['qts_id']){ ?>
                                                <div class="well" style="background: white;font-size: medium;font-weight: bold;">
                                                    <p class="">Qutation No : <?php echo $sale_details['qts_reference_no']; ?></p>
                                                </div>
                                            <?php } ?>
                                            <p>Date: <?php echo display_date_time_format($sale_details['sale_datetime']) ?></p>
                                            <?php
                                            $total_advance_paid_amount = 0;
                                            if($sale_details['qts_id'])
                                                $total_advance_paid_amount = $this->Sales_Model->get_total_advance_by_qts_id($sale_details['qts_id']);
                                            $total_paid_amount = $this->Sales_Model->get_total_paid_by_sale_id($sale_id);
                                            $total_paid_amount += $total_advance_paid_amount;
                                            $styles = "";
                                            if (empty($total_paid_amount)) {
                                                $pay_st = 'Pending';
                                                $styles = 'style="font-weight: 900;background: lightyellow;"';
                                            } else {
                                                if ($total_paid_amount >= $sale_details['sale_total']) {
                                                    $pay_st = 'Paid';
                                                    $styles = 'style="font-weight: 900;background: lightgreen;"';
                                                } else {
                                                    $pay_st = 'Partial';
                                                    $styles = 'style="font-weight: 900;background: lightblue;"';
                                                }
                                            }
                                            
                                            if($pay_st == 'Pending' && ($sale_details['pay_cash'] > 0 || $sale_details['pay_visa'] > 0) ){
                                                echo "<code>Error detected in payments. Amount given in cash is ".$sale_details['pay_cash']." and  given amount by card is ".$sale_details['pay_visa']."</code>";
                                            }
                                            
                                            ?>
                                            <p <?php echo $styles; ?> > Payment Status : <?php echo $pay_st ?></p>
                                            
                                            
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col-xs-4 border-right">
                                        <div class="col-xs-2"><i class="fa fa-3x fa-user padding010 text-muted"></i></div>
                                        <div class="col-xs-10">
                                            <h4 class=""><?php echo $customer_details['cus_name']; ?></h4>
                                            <?php echo $customer_details['cus_address']; ?><br>
                                            <p></p>
                                            Tel: <?php echo $customer_details['cus_phone']; ?><br>
                                            Email: <?php echo $customer_details['cus_email']; ?>
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
                                    <input name="sale_id" type="hidden" id="sale_id" value="<?php echo $sale_id ?>">
                                    <input type="hidden" id="sale_type" name="sale_type" value="sale">
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
                                                <th style="padding-right:20px;">Discount</th>
                                                <th style="padding-right:20px;">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $tmpcount = 0;
                                            $tmptot = 0;
                                            foreach ($sale_item_list as $row) {
                                                $tmpcount++;
                                                if($row['valid_status'])
                                                    $tmptot = $tmptot + $row['gross_total'];
                                            ?>
                                                <tr <?php echo $row['valid_status'] ? '':'class="strikethrough"' ?>>
                                                    <td style="text-align:center; width:40px; vertical-align:middle;"><?php echo $tmpcount ?></td>
                                                    <td style="vertical-align:middle;"><?php echo $row['product_name']; ?> (<?php echo $row['product_code']; ?>)</td>
                                                    <td style="width: 100px; text-align:center; vertical-align:middle;"><?php echo number_format($row['quantity'], 2, '.', ',') ?></td>
                                                    <td><?php echo number_format($row['unit_price'], 2, '.', ',') ?></td>
                                                    <td style="text-align:right; width:120px; padding-right:10px;">(<?php echo $row['discount'] ?>) <?php echo number_format($row['discount_val'], 2, '.', ',') ?></td>
                                                    <td style="text-align:right; width:120px; padding-right:10px;"><?php echo $row['gross_total']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <?php if($sale_details['sale_inv_discount'] > 0 ){ ?>
                                            <tr>
                                                <td style="text-align:right; padding-right:10px;" colspan="5">Order Discount</td>
                                                <td style="text-align:right; padding-right:10px;"><?php echo $sale_details['sale_inv_discount']; ?>(<?php echo number_format($sale_details['sale_inv_discount_amount'], 2, '.', ',') ?>)</td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <td style="text-align:right; padding-right:10px;" colspan="5">Total Amount
                                                </td>
                                                <td style="text-align:right; padding-right:10px;"><?php echo number_format($sale_details['sale_total'], 2, '.', ',') ?>
                                                    <input type="hidden" value="<?php echo $sale_details['sale_total'] ?>" id="total_paymnt_tmp">
                                                    <input type="hidden" value="<?php echo $total_paid_amount; ?>" id="paid_tmp">
                                                </td>
                                            </tr>
                                            <?php //if ($sale_details['customer_id']!=1)
                                            { ?>
                                                <?php if ($old_payments) { ?>
                                                    <tr>
                                                        <td style="text-align:right; padding-right:10px;" colspan="5"><?php echo $old_payments_dis_msg ?></td>
                                                        <td style="text-align:right; padding-right:10px;"><?php echo number_format($old_payments, 2, '.', ',') ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:right; padding-right:10px;" colspan="5">Total Amount to be paid</td>
                                                        <td style="text-align:right; padding-right:10px;"><?php echo number_format(($sale_details['sale_total'] + $old_payments), 2, '.', ',') ?></td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                            <tr>
                                                <td style="text-align:right; padding-right:10px;" colspan="5">Paid
                                                </td>
                                                <td style="text-align:right; padding-right:10px;"><?php echo number_format($total_paid_amount, 2, '.', ',') ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:right; padding-right:10px;" colspan="5">Balance
                                                </td>
                                                <td style="text-align:right; padding-right:10px;"><?php echo number_format(($sale_details['sale_total'] - $total_paid_amount + $old_payments), 2, '.', ',') ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:right; padding-right:10px;" colspan="5">&nbsp;</td>
                                                <td style="text-align:right; padding-right:10px;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:right; padding-right:10px;" colspan="5">&nbsp;</td>
                                                <td style="text-align:right; padding-right:10px;">&nbsp;</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div> <!--table-responsive-->
                                <div class="clearfix"></div>
                                <p></p>
                                <div class="well well-sm col-xs-6 pull-right">
                                    <div class="col-xs-10">
                                        <p>
                                            <?php //echo $tmptot;
                                            echo "Created by: ". $sale_details['cashier'];
                                            echo $sale_details['waitername'] ? "<br>Waiter: ". $sale_details['waitername'] : '';
                                            ?><br>
                                            <!--Created by : <?php echo $this->session->userdata('ss_user_first_name'); ?> (<?php echo $this->session->userdata('ss_user_group_name'); ?>) -->
                                        </p>
                                        <p>Date:<?php echo display_date_time_format($sale_details['sale_datetime_created']) ?></p>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="clearfix"></div>
                                </div> <!--well well-sm col-xs-6 pull-right-->
                                <!-- advance payment list -->
                                <!--<pre>
                                </pre>-->
                                    
                                <?php if($sale_details['qts_id']){ 
                                    $this->db->select('sp.*, u.user_first_name, ug.user_group_name');
                                    $this->db->from('sale_payments sp');
                                    $this->db->join('user u', 'u.user_id = sp.user_id', 'left');
                                    $this->db->join('user_group ug', 'u.group_id = ug.user_group_id', 'left');
                                    $this->db->where('sp.sale_payment_type','custom');
                                    $this->db->where('sp.qutation_id',$sale_details['qts_id']);
                                    $query = $this->db->get();
                                    $result = $query->result();
                                    
                                    //print_r($result);
                                ?>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h3>Advance Payments</h3>
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
                                                    <?php foreach ($result as $row) { ?>
                                                        <tr <?php echo $row->valid_status ? '':'class="strikethrough"' ?>>
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
                                <?php } ?>
                                
                                <!-- payment list -->
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h3>Payments</h3>
                                        <div class="table-responsive">
                                            <table class="table items table-striped table-bordered table-condensed table-hover">
                                                <thead>
                                                    <tr class="report_view_th">
                                                        <th>Date</th>
                                                        <th>Payment Reference</th>
                                                        <th>Paid by</th>
                                                        <th>Amount</th>
                                                        <th>Created by</th>
                                                        <?php if($this->session->userdata('ss_group_id') != 3) {?>
                                                        <th>Action</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($sale_payments_list as $row) { ?>
                                                        <tr <?php echo $row->valid_status ? '':' class="strikethrough"'; ?>>
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
                                                            <?php if($this->session->userdata('ss_group_id') != 3) {?>
                                                            <th> 
                                                                <button data-msg="Remove the payment <?php echo number_format($row->sale_pymnt_amount, 2, '.', ',') ?> paid by <?php echo $row->sale_pymnt_paying_by ?> ?" onclick="sale_pymnts_delete_by_sp_id(<?php echo $row->sale_pymnt_id; ?>,this)" class="btn btn-danger <?php echo $row->valid_status ? '':' collapse'; ?>"> <i class="fa fa-times"></i> </button>
                                                            </th> 
                                                        <?php } ?>
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
                                <!-- end payment list-->
                                <div class="buttons">
                                    <div class="btn-group btn-group-justified">
                                        <?php if(($sale_details['sale_total'] - $total_paid_amount + $old_payments) != 0 && $sale_details['sale_status'] != 99){?>
                                            <div class="btn-group"><a title="" class="tip btn btn-success tip" data-target="#myModal" data-toggle="modal" href="#" data-original-title="Add Payment" id="modal_ajax_sales_payment_btn"><i class="fa fa-money"></i> <span class="hidden-sm hidden-xs">Add Payment</span></a></div>
                                        <?php } ?>
                                        <!--<div class="btn-group"><a title="" class="tip btn btn-primary tip" data-target="#myModal" data-toggle="modal" href="http://sma.tecdiary.org/sales/add_payment/2" data-original-title="Add Payment"><i class="fa fa-money"></i> <span class="hidden-sm hidden-xs">View Payment</span></a></div>-->
                                        <!--<div class="btn-group"><a title="" class="tip btn btn-primary tip" data-target="#myModal" data-toggle="modal" href="http://sma.tecdiary.org/sales/add_delivery/2" data-original-title="Add Delivery"><i class="fa fa-truck"></i> <span class="hidden-sm hidden-xs">Add Delivery</span></a></div>-->
                                        
                                        <?php if($this->session->userdata('ss_group_id') < 3  && $sale_details['sale_status'] != 99){?>
                                            <div class="btn-group" data-sale_id="<?php echo $sale_id; ?>" onClick="cancel_sale(`<?php echo $sale_details['sale_id'] ?>`)"><a title="" class="tip btn btn-danger" data-original-title="Print"><i class="fa fa-times"></i> <span class="hidden-sm hidden-xs">Cancel Sale</span></a></div>
                                        <?php } ?>
                                        
                                        <div class="btn-group" data-sale_id="<?php echo $sale_id; ?>" onClick="print_bill(this)"><a title="" class="tip btn btn-warning" data-original-title="Print"><i class="fa fa-print"></i> <span class="hidden-sm hidden-xs">Print</span></a>
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
        <div class="modal fade in" id="modal_login" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i></button>
                        <h4 class="modal-title" id="dsModalLabel">Enter Username and Password</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" value="" class="form-control" id="username" />
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" value="" class="form-control" id="password" />
                        </div>
                        <div class="form-group">
                            <label for="password">Reasons for cancellation</label>
                            <textarea name="cancellation_reasons" class="form-control" id="cancellation_reasons" /></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn_login" class="btn btn-primary">Next</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- start: MAIN JAVASCRIPTS -->
        <?php $this->load->view("common/footer"); ?>
        <!-- end: MAIN JAVASCRIPTS -->
        <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
        <!--<script src="<?php echo asset_url(); ?>plugins/jquery-inputlimiter/jquery.inputlimiter.1.3.1.min.js"></script>-->
        <!--<script src="<?php echo asset_url(); ?>plugins/jquery.maskedinput/src/jquery.maskedinput.js"></script>-->
        <script type="text/javascript" src="<?php echo asset_url(); ?>plugins/bootbox/bootbox.min.js"></script>
        <!--<script type="text/javascript" src="<?php echo asset_url(); ?>plugins/jquery-mockjax/jquery.mockjax.js"></script>-->
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
        <script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script>
        <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
        <script>
            jQuery(document).ready(function() {
                TableData.init();
                //Main.init();
                //TableData.init();
                //UIModals.init();
                
                
                
                <?php 
                
                if($pay_st == 'Pending' && ($sale_details['pay_cash'] > 0 || $sale_details['pay_visa'] > 0) ){
                    echo "bootbox.alert(\"Please check the payments! <code>Error or Changes detected in payments. Amount given in cash is ".$sale_details['pay_cash']." and  given amount by card is ".$sale_details['pay_visa']."</code>\");";
                }
                                            
                ?>
                
                
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
                        url: "sales/list_sales", // json datasource
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
            
            <?php if($sale_details['qts_id']){  ?>
                function print_bill(element) {
                    var sale_id = $(element).data('sale_id');
                    u = location.href;
                    t = document.title;
                    window.open('<?php echo base_url() ?>sales/sale_details_quot?sale_id=' + sale_id, 'sharer', 'toolbar=0,status=0,width=384,height=700, left=10, top=10,scrollbars=yes');
                    return false;
                }
            <?php } else {  ?>
                function print_bill(element) {
                    var sale_id = $(element).data('sale_id');
                    u = location.href;
                    t = document.title;
                    window.open('<?php echo base_url() ?>sales/sale_details_pos?sale_id=' + sale_id + '&dd=1', 'sharer', 'toolbar=0,status=0,width=384,height=700, left=10, top=10,scrollbars=yes');
                    return false;
                }
            <?php }  ?>
            
            
            function sale_pymnts_delete_by_sp_id(sp_id,elem){
                var msg = $(elem).data('msg');
                bootbox.confirm(msg,(e)=>{
                    if(e){
                        $.ajax({
                            'url' : '<?php echo base_url() ?>sales/sale_pymnts_delete_by_sp_id',
                            'dataType' : 'json',
                            'data' : {
                                sp_id : sp_id
                            },
                            'success' : function(response){
                                if(response.success){
                                    bootbox.alert("Sale Payment Deleted successfully");
                                    setTimeout(function(){
                                        window.location.reload();
                                    },300);
                                }else{
                                    bootbox.alert("Error!");
                                }
                            },
                            'error' : function(response){
                                console.error('Payment response',response);
                                bootbox.alert("Error!");
                                /*setTimeout(function(){
                                        window.location.reload();
                                    },300);*/
                            }
                        });
                    }
                });
            }
            
            
        /**/
        function cancel_sale(id) {
            <?php if($this->session->userdata('ss_group_id') < 3){?>
                bootbox.prompt({
                    title: 'Please enter the cancellation reason:',
                    centerVertical: true,
                    callback: function(result) {
                        if(result != null){
                            if(result.trim().length > 0)
                                send_rq(result);
                            else{
                                bootbox.alert("Cancellation reason is required!");
                            }
                        }
                    }
                });
            <?php }else{ ?>
                $("#modal_login").modal("show");
            <?php } ?>
        }
        <?php if($this->session->userdata('ss_group_id') < 3){?>
            
        <?php }else{ ?>
            $(document).on("click", "#btn_login", function() {
                $.ajax({
                    dataType: "JSON",
                    type: "POST",
                    url: '<?php echo base_url()?>pos/check_user',
                    data: {
                        username: $('#username').val(),
                        password: $('#password').val()
                    },
                    cache: false,
                    success: function(data) {
                        if (data.success) {
                            $("#modal_login").modal("hide");
                            var cr = $('#cancellation_reasons').val();
                            if(cr.trim().length > 0)
                                send_rq(cr);
                            else{
                                bootbox.alert("Cancellation reason is required!");
                            }
                        } else {
                            bootbox.alert(data.validation);
                        }
                    },
                    error: function(data) {
                        bootbox.alert(data.responseText);
                    }
                });
            });
        <?php } ?>
        
        function send_rq(cancellation_reasons) {
            jQuery.ajax({
                type: "POST",
                url: '<?php echo base_url()?>posplus/cancel_sale',
                data: {
                    sale_id: '<?php echo $sale_details['sale_id']; ?>',
                    cancellation_reasons: cancellation_reasons,
                    uuid : uuidv4()
                },
                cache: false,
                success: function(response) {
                    window.location.reload();
                },
                error: function(data) {
                    bootbox.alert(data.responseText);
                }
            });
        }
        function uuidv4() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0,
                    v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        } 
        </script>
</body>
<!-- end: BODY -->
</html>