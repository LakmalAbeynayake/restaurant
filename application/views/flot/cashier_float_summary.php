<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<!-- start: HEAD -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php
    header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    ?>
    <title>
        <?php
        if (isset($sub_menu_name))
            echo strtoupper($sub_menu_name . ' - ');
        ?>
        STOCK MANAGEMENT SYSTEM</title>
    <!-- start: META -->
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="description" />
    <meta name="author" />
    <!--<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap/css/bootstrap.min.css">
-->
    <?php
    $this->load->view("common/header");
    ?>
</head>
<div style="top:5px;" class="panel-tools open">
    <button style="display:none" data-toggle="dropdown" class="btn btn-blue dropdown-toggle" onClick="window.print()"><i class="fa fa-print"></i></button>
</div>
<style type="text/css">
    th {
        text-align: center !important;
    }
    .report_view_th {
        color: #000 !important;
        text-align: center !important;
    }
    body {
        background-color: #fff !important;
        font-size: 12px;
        /*	font-family: "serif";*/
        /*, Times, serif; */
        /* font-family:verdana; */
        /* BPmono helvetica; */
        letter-spacing: 0.5px;
        margin-right: 10px;
        color: #000 !important;
    }
    p {
        margin: 0;
    }
    .print-table td,
    th {
        padding: 0px;
        vertical-align: top !important;
    }
    thead {
        display: table-header-group;
    }
    tfoot {
        display: table-footer-group;
    }
    #cashtable>tbody>tr>td:nth-child(3) {
        text-align: right;
        width: 50%;
    }
</style>
<style type="text/css" media="print">
    .print-table {
        width: 100%;
    }
    .td_border_bottom_1 {
        border-bottom: 1px solid #666 !important;
    }
    .td_border_bottom_2 {
        border-bottom: 4px double #666 !important;
    }
    .td_border_top_1 {
        border-top: 1px double #666 !important;
    }
    .pagebreak {
        page-break-before: always;
    }
    h1,
    h2,
    h3 {
        margin-bottom: 0 !important;
        margin-top: 0 !important;
    }
    h1,
    .h1,
    h2,
    .h2,
    h3,
    .h3 {
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }
    /*
td{
    padding:5px;
}
*/
    @page {
        size: auto;
        /* auto is the initial value */
        margin: 0;
        /* this affects the margin in the printer settings */
    }
    .row {
        padding-left: 20px;
        padding-right: 15px;
    }
</style>
<!--  onLoad="window.print(),window.close()" -->
<?php
//print_r($warehouse_details);
//print_r($transactions_details);
$close_text = '';
if ($this->session->userdata('ss_warehouse_id') == 8) {
    $close_text = '';
} else {
}
$close_text = ',window.close()';
$print_text = 'window.print()';
if ($this->session->userdata('ss_user_id') == 1) {
    $close_text = '';
    $print_text = '';
}
$close_text = '';
?>
<body onLoad="<?php echo $print_text; ?> <?php echo $close_text; ?>">
    <div class="print_area print" style="width:100%;">
        <div class="row">
            <div class="col-xs-12" style="text-align:center">
                <center>
                    <div style="display:none; border:solid 3px; border-radius:50px; width:13%; padding:15px; line-height:1"><span style="font-size:31px;font-weight:bold">SO</span> <span style="font-size:14px;font-weight:bold">--</span></div>
                </center>
                <H2 style="font-size:25px; margin-bottom:0px; font-weight: bold; margin-top: 1px; line-height: 0.9;"> <?php echo $transactions_details['name']; ?></H2>
                <!-- 
      <p class="text-center" style="font-weight:bold; font-size:17px;">Mobile Phone & Accessories</p> -->
                <p style="font-size:15px"><?php echo $transactions_details['address']; ?></p>
                <?php if ($transactions_details['email']) //echo $warehouse_details['email']."<br>"; 
                ?>
                <?php if ($transactions_details['phone']) echo "<span style=\"font-size:15px\">  " . $transactions_details['phone'] . "</span><br>"; ?>
                <p style="padding:3px; font-weight:bold;">SHIFT DETAILS REPORT</p>
                <!-- <p style="font-size:15px">INVOICE<P/>-->
                <div style="height:2px; border-bottom: 0px dashed black;"></div>
            </div>
            <!--col-xs-12-->
        </div>
        <div class="row">
            <div class="col-xs-12" style="margin-left:0px;">
                <div class="" style="margin-left:0px; padding-left:0;">
                    <div class="col-xs-6">
                        <table>
                            <tr>
                                <td>Ref. No</td>
                                <td>:</td>
                                <td><?php echo $transactions_details['ref_no']; ?></td>
                            </tr>
                            <tr>
                                <td>Start Time</td>
                                <td>:</td>
                                <td> <?php echo site_date_time($transactions_details['c_f_m_date_time']); //date("Y-m-d", strtotime($sale_details['sale_datetime'])); 
                                        ?></td>
                            </tr>
                            <tr>
                                <td>Shift Status </td>
                                <td>:</td>
                                <td><?php
                                    if ($transactions_details['float_status'] == 1) echo "Active";
                                    else echo "Closed"; ?></td>
                            </tr>
                            <tr>
                                <td>Shift End Time </td>
                                <td>:</td>
                                <td>
                                    <?php
                                    if ($transactions_details['float_status'] == 2)
                                        echo site_date_time($end_date_time);
                                    ?></td>
                            </tr>
                            <tr>
                                <td>User </td>
                                <td>:</td>
                                <td><?php echo $transactions_details['user_first_name']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- start payment methord -->
        <div class="row col-md-12">
            <div class="col-md-12">
                <h4>CASH PAYMENTS</h4>
                <table>
                    <?php foreach ($transactions_items as $row) {
                        if ($row['float_type'] == 1) {
                            continue;
                        }
                    ?>
                        <tr>
                            <td width="10%">5000</td>
                            <td width="10%">x</td>
                            <td width="10%"><?php echo $row['c_count_5000']; ?></td>
                            <td width="10%">=</td>
                            <td width="10%"><?php echo  number_format($row['c_count_5000'] * 5000, 2, '.', ','); ?></td>
                        </tr>
                        <tr>
                            <td>1000</td>
                            <td>x</td>
                            <td><?php echo $row['c_count_1000']; ?></td>
                            <td>=</td>
                            <td><?php echo  number_format($row['c_count_1000'] * 1000, 2, '.', ','); ?></td>
                        </tr>
                        <tr>
                            <td>500</td>
                            <td>x</td>
                            <td><?php echo $row['c_count_500']; ?></td>
                            <td>=</td>
                            <td><?php echo  number_format($row['c_count_500'] * 500, 2, '.', ','); ?></td>
                        </tr>
                        
                        <tr>
                            <td>100</td>
                            <td>x</td>
                            <td><?php echo $row['c_count_100']; ?></td>
                            <td>=</td>
                            <td><?php echo  number_format($row['c_count_100'] * 100, 2, '.', ','); ?></td>
                        </tr>
                        <tr>
                            <td>50</td>
                            <td>x</td>
                            <td><?php echo $row['c_count_50']; ?></td>
                            <td>=</td>
                            <td><?php echo  number_format($row['c_count_50'] * 50, 2, '.', ','); ?></td>
                        </tr>
                        <tr>
                            <td>20</td>
                            <td>x</td>
                            <td><?php echo $row['c_count_20']; ?></td>
                            <td>=</td>
                            <td><?php echo  number_format($row['c_count_20'] * 20, 2, '.', ','); ?></td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>x</td>
                            <td><?php echo $row['c_count_10']; ?></td>
                            <td>=</td>
                            <td><?php echo  number_format($row['c_count_10'] * 10, 2, '.', ','); ?></td>
                        </tr>
                        <tr>
                            <td>10 (C)</td>
                            <td>x</td>
                            <td><?php echo $row['c_count_10_c']; ?></td>
                            <td>=</td>
                            <td><?php echo  number_format($row['c_count_10_c'] * 10, 2, '.', ','); ?></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>x</td>
                            <td><?php echo $row['c_count_5_c']; ?></td>
                            <td>=</td>
                            <td><?php echo  number_format($row['c_count_5_c'] * 5, 2, '.', ','); ?></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>x</td>
                            <td><?php echo $row['c_count_2_c']; ?></td>
                            <td>=</td>
                            <td><?php echo  number_format($row['c_count_2_c'] * 2, 2, '.', ','); ?></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>x</td>
                            <td><?php echo $row['c_count_1_c']; ?></td>
                            <td>=</td>
                            <td><?php echo  number_format($row['c_count_1_c'] * 1, 2, '.', ','); ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <hr>
                <table class="table table-stripe table-hover" id="cashtable">
                    <tr>
                        <td width="10%">
                        </td>
                        <td width="10%">
                            <h4></h4>
                        </td>
                        <td width="10%">
                            <h4></h4>
                        </td>
                    </tr>
                    <tr>
                        <td>+ Opening Balance</td>
                        <td>:</td>
                        <td><?php echo number_format($opening_balance, 2, '.', ','); ?></td>
                    </tr>
                    <tr>
                        <td>+ Transfer to Petty Cash</td>
                        <td>:</td>
                        <td><?php echo number_format($transfer_to_petty_cash, 2, '.', ','); ?></td>
                    </tr>
                    <tr>
                        <td>+ Total Cash (Sale + Advance Payments )</td>
                        <td>:</td>
                        <td><?php echo  number_format($sale_cash_total, 2, '.', ','); ?></td>
                    </tr>
                    <tr>
                        <td>- Total Return Cash Sale</td>
                        <td>:</td>
                        <td><?php echo number_format($sale_return_cash_total, 2, '.', ','); ?></td>
                    </tr>
                    <tr class="collapse">
                        <td>+ Tranfer to petty cash</td>
                        <td>:</td>
                        <td><?php echo number_format($tranfer_pettycash_total, 2, '.', ','); ?></td>
                    </tr>
                    <!-- 
        <tr>
            <td>+ Cash Reciepts</td>
            <td>:</td>
            <td></td>
        </tr> -->
                    <tr class="">
                        <td>- Expencess(Petty Cash)</td>
                        <td>:</td>
                        <td><?php echo number_format($expencess_total, 2, '.', ','); ?></td>
                    </tr>
                    <tr>
                        <td>- Withdrawals</td>
                        <td>:</td>
                        <td><?php echo number_format($withdraval_total, 2, '.', ','); ?></td>
                    </tr>
                    <tr>
                        <td>
                            <stong>= Cash in Hand</stong>
                        </td>
                        <td>:</td>
                        <td>
                            <stong><?php echo number_format(($opening_balance + $transfer_to_petty_cash + $sale_cash_total + $tranfer_pettycash_total) - ($withdraval_total + $expencess_total + $sale_return_cash_total), 2, '.', ','); ?></stong>
                        </td>
                    </tr>
                </table>
                <hr>
                <h4>CARD PAYMENTS</h4>
                <table class="table table-stripe">
                    <tr>
                        <th colspan="3" style="text-align:left !important">
                            Total : <?php echo $sale_card_total; ?>
                        </th>
                    </tr>
                    <!--<tr>
                        <td width="10%">
                            <h4>Card Type</h4>
                        </td>
                        <td width="10%">
                            <h4>Physical</h4>
                        </td>
                        <td width="10%">
                            <h4>System</h4>
                        </td>
                    </tr>
                    <tr>
                        <td>MAST</td>
                        <td><?php echo  number_format($master_card, 2, '.', ','); ?></td>
                        <td><?php echo  number_format($master_card_system, 2, '.', ','); ?></td>
                    </tr>
                    <tr>
                        <td>VISA</td>
                        <td><?php echo  number_format($visa_card, 2, '.', ','); ?></td>
                        <td><?php echo  number_format($visa_card_system, 2, '.', ','); ?></td>
                    </tr>
                    <tr>
                        <td>AMEX</td>
                        <td><?php echo  number_format($amex_card, 2, '.', ','); ?></td>
                        <td><?php echo  number_format($amex_card_system, 2, '.', ','); ?></td>
                    </tr>-->
                </table>
                <hr>
                <h4>PickMe PAYMENTS</h4>
                <table class="table-stripe">
                    <tr>
                        <td><?php echo  number_format($sale_pickme_total, 2, '.', ','); ?></td>
                    </tr>
                </table>
                <hr>
                <h4>Float Balance</h4>
                <table>
                    <tr>
                        <td width="10%"></td>
                        <td width="10%">CASH</td>
                        <td width="10%">CARD</td>
                        <td width="10%">PickMe</td>
                        <!--<td width="10%">CHEQUE</td>-->
                    </tr>
                    <tr>
                        <td>Physical</td>
                        <td><?php echo  number_format($total_cash, 2, '.', ','); ?></td>
                        <td><?php echo  number_format($total_card, 2, '.', ','); ?></td>
                        <td>n/a</td>
                        <!--  <td><?php echo  number_format($total_cheque, 2, '.', ','); ?></td>-->
                    </tr>
                    <tr>
                        <td>System</td>
                        <td><?php echo  number_format(($sale_cash_total + $opening_balance + $tranfer_pettycash_total) - ($withdraval_total + $expencess_total + $sale_return_cash_total), 2, '.', ','); ?></td>
                        <td><?php echo  number_format($total_card_system, 2, '.', ','); ?></td>
                        <td><?php echo  number_format($sale_pickme_total, 2, '.', ','); ?></td>
                        <!--<td><?php echo  number_format($total_cheque_system, 2, '.', ','); ?></td>-->
                    </tr>
                    <tr>
                        <td>Varience</td>
                        <td><?php echo  number_format($closing_balance - (($tranfer_pettycash_total + $sale_cash_total + $opening_balance) - ($withdraval_total + $expencess_total + $sale_return_cash_total)), 2, '.', ','); ?></td>
                        <td><?php echo  number_format($total_card - $total_card_system, 2, '.', ','); ?></td>
                        <td>n/a</td>
                        <!-- <td><?php echo  number_format($total_cheque - $total_cheque_system, 2, '.', ','); ?></td>-->
                    </tr>
                </table>
                <hr>
                <table>
                    <tr>
                        <td width="10%">
                            <h4>Summary of Sale</h4>
                        </td>
                        <td width="10%">
                            <h4></h4>
                        </td>
                        <td width="10%">
                            <h4></h4>
                        </td>
                    </tr>
                    <tr>
                        <td>Sale Total</td>
                        <td>:</td>
                        <td><?php echo number_format($retail_sale_total, 2, '.', ','); ?></td>
                    </tr>
                    <tr>
                        <td>Staff Credit Sale Total</td>
                        <td>:</td>
                        <td><?php echo number_format($credit_staff_sale_total, 2, '.', ','); ?></td>
                    </tr>
                    <tr>
                        <td>Sale Return Total</td>
                        <td>:</td>
                        <td><?php echo number_format($retail_sale_return__total, 2, '.', ','); ?></td>
                    </tr>
                    <!---<tr>
            <td>Wholsale Sale Total</td>
            <td>:</td>
            <td><?php echo number_format($wholesale_sale_total, 2, '.', ','); ?></td>
        </tr>-->
                    <!--<tr>
            <td>Sale Total</td>
            <td>:</td>
            <td><?php echo number_format($wholesale_sale_total + $retail_sale_total, 2, '.', ','); ?></td>
        </tr>-->
                </table>
                <hr>
                <h4>Cash Withdrawals (Owner)</h4>
                <table>
                    <tr>
                        <td width="10%">
                            <h4>Receipt No</h4>
                        </td>
                        <td width="10%">
                            <h4>Amount</h4>
                        </td>
                        <td width="10%">
                            <h4>Remarks</h4>
                        </td>
                    </tr>
                    <?php foreach ($withdraval_list as $wl) { ?>
                        <tr>
                            <td><?php echo  $wl['acctrnss_id'];  ?></td>
                            <td><?php echo  $wl['acctrnss_amount']; ?></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        <!-- end payment methad -->
        <div class="print-start">
            <?php //print_r($sale_details);
            ?>
            <div class="row col-md-12">
            </div>
        </div>
    </div>
    <!--
<div class="pagebreak"> - </div>
-->
    <!--print-start-->
</body>
<!-- <script src="<?php echo asset_url(); ?>plugins/jQuery-lib/2.0.3/jquery.min.js"></script>-->
<script type="text/javascript">
    jQuery(document).ready(function() {
        setTimeout(
            function() {
                //do something special
            }, 2000);
        //alert();
        //window.close();
        // $("#modal_ajax_sales_payment_btn").trigger("click");
        //fbs_click('<?php //echo $sale_id 
                        ?>')
        //Main.init();
        //TableData.init();
        //UIModals.init();
    });
</script>