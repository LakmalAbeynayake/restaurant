<!DOCTYPE html>

<html lang="en" class="no-js">

<!--<![endif]-->

<!-- start: HEAD -->

<head>
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

    <meta charset="utf-8" />
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="description" />
    <meta name="author" />
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>thems/images/your-logo-here.png" />
    <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap/css/bootstrap.min.css">
</head>
<style type="text/css">
    body {
        font-family: monospace;
        font-size: 13px;
    }

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
    }

    p {
        margin: 0;
    }

    .print-table td,
    th {
        padding: 3px;
        vertical-align: top !important;
    }

    thead {
        display: table-header-group;
    }

    tfoot {
        display: table-footer-group;
    }
    .watermark {
        position: fixed;
        /* Fixed positioning to keep it on top */
        top: 40%;
        /* Adjust top position */
        left: 50%;
        /* Adjust left position */
        transform: translate(-50%, -50%) rotate(-60deg);
        /* Center the watermark and rotate */
        font-size: 60px;
        /* Adjust font size */
        color: rgba(0, 0, 0, 0.35);
        /* Adjust color and opacity */
        pointer-events: none;
        /* Make sure it doesn't interfere with clicks */
        z-index: 9999;
        /* Ensure it's on top of other content */
        font-family: Arial, sans-serif;
        /* Adjust font family */
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

    @page {
        size: auto;
        /* auto is the initial value */
        margin: 0;
        /* this affects the margin in the printer settings */
    }
    .watermark {
        position: fixed;
        /* Fixed positioning to keep it on top */
        top: 20%;
        /* Adjust top position */
        left: 50%;
        /* Adjust left position */
        transform: translate(-50%, -50%) rotate(-50deg);
        /* Center the watermark and rotate */
        font-size: 60px;
        /* Adjust font size */
        color: rgba(0, 0, 0, 0.35) !important;
        /* Adjust color and opacity */
        pointer-events: none;
        /* Make sure it doesn't interfere with clicks */
        z-index: 9999;
        /* Ensure it's on top of other content */
        font-family: Arial, sans-serif;
        /* Adjust font family */
    }
</style>

<body style="font-size:16px">
    <div class="print_area print" style="width:100%;margin-left:5px;page-break-after:auto">
        <div class="row">
            <div class="col-xs-12 text-center">
                <?php if ($warehouse_details['name']) echo "<h3>" . $warehouse_details['name'] . "</h3>"; ?>
                <?php
                $show_logo = 0;
                $show_logo = 1;
                if ($show_logo) { ?>
                    <!--<img src="<?php echo asset_url(); ?>images/logo_print.png" style="margin-top: 1px;width: 100px;">-->
                <?php } ?>
                <p style="font-size:15px"><?php echo $warehouse_details['address']; ?></p>
                <?php //if ($warehouse_details['email']) echo '<p style="font-size:13px">' . $warehouse_details['email'] . "</p>"; ?>
                <?php if ($warehouse_details['phone']) echo "<span style=\"font-weight:bold; font-size:15px\">" . $warehouse_details['phone'] . "</span><br>"; ?>
            </div>
            <!--col-xs-12-->
        </div><div class="watermark">
                Waiter Copy
            </div>
        <div class="row">
            <div class="col-xs-12" style="margin-left:8px;">
                <?php 
                if($sale_details['sale_status'] == 99)
                { ?>
                <p style="border-top: dashed;border-bottom: dashed;">
                    
                    <span style="font-size:25px;">CANCELLED SALE</span><br>
                    Reason : <?php echo $sale_details['cancellation_reasons']; ?> <br>
                    Signaute : ____________________
                </p>
                <?php } ?>
                <div class="">
                    
                    <p style="font-size:16px; font-weight:bold;margin: 0px 35px 0px 0px;" class="text-center">-Waiter Copy-</p>
                    <p style="font-size:16px; font-weight:bold;margin: 0px 35px 0px 0px;">Bill No: <?php echo substr($sale_details['sale_id'],-4); ?></p>
                    <?php
                    if ($sale_details['table_id']) echo "<p style=\"font-weight:bold; font-size:14px\">Table: " . $sale_details['table_id'] . "</p>";
                    if ($customer_details['cus_id'] != 1) {
                        //        	  if($customer_details['cus_address']){ echo "<p>Address: ".$customer_details['cus_address']."</p>"; }
                        if ($customer_details['cus_phone']) {
                            echo "<p style=\"font-weight:bold;font-size:14px;margin-bottom:-2px;\">Customer: ".$customer_details['cus_name']." 07x-xxx-" . substr($customer_details['cus_phone'],-4) ."</p>";
                        }
                    }

                    if ($sale_details['dine_type'])
                        if ($sale_details['dine_type'] == 1) echo "<p style=\"font-weight:bold; font-size:14px\">Type: Dine In</p>";
                        else if ($sale_details['dine_type'] == 2) echo "<p style=\"font-weight:bold; font-size:14px\">Type: Take Away</p>";
                        else if ($sale_details['dine_type'] == 3) {
                            echo "<p style=\"font-weight:bold; font-size:14px\">Type: Delivary</p>";
                            echo ($sale_details['shipping_address'] != "") ? "<p>Delivery Address: " . $sale_details['shipping_address'] . " </p>" : "";
                            //echo ($sale_details['rider_name'])"<p>Delivery Address: ".$sale_details['shipping_address']." </p>";
                        } ?>
                    <p style="font-weight:bold">Date: <?php echo display_date_time_format($sale_details['sale_datetime']); ?></p>
                    <!--<p style="margin-bottom:-2px;">Customer: <?php echo $customer_details['cus_name']; ?></p>-->
                    <p style="margin-bottom:-4px;">Cashier :<?php echo $this->session->userdata('ss_user_first_name'); ?></p>
                    
                    <?php if(isset($reprinted)){?>
                          <p style="margin-bottom:-4px;"><?php echo $reprinted; ?></p>
                    <?php } ?>
                    
                </div>
            </div>
        </div>
        <div class="print-start">
            <?php //print_r($sale_details);
            ?>
            <div class="row col-md-12">
                <div class="col-xs-12">
                    <table class="print-table" width="100%">
                        <thead style="border-bottom:dashed;border-top:dashed">
                            <tr class="report_view_th text-center">
                                <th style="width:5%" class="collapse">*</th>
                                <th style="width:40%">ITEM</th>
                                <th style="width:10%">QTY</th>
                                <th style="width:10%" class="collapse">PRICE</th>
                                <?php /*?><th class="col-xs-1"><br/>Discount</th> <?php */ ?>
                                <th style="width:10%" align="center"> AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $tmpcount = 0;
                            $gtotal  = 0;
                            foreach ($sale_item_list as $row) {
                                $gtotal += $row['gross_total'];
                                $tmpcount++;
                            ?>
                                <tr>
                                    <td style="text-align:center; width:40px; vertical-align:middle;font-weight:bold; font-size:16px" class="collapse">*</td>
                                    <td style="vertical-align:middle;"><?php echo $row['product_name'] ?></td>
                                    <td style="text-align:center;"><?php echo ($row['quantity']+0); ?></td>
                                    <td style="text-align:right;" class="collapse"><?php echo number_format($row['unit_price'], 2, '.', ','); ?></td>
                                    <?php /*?><td style="width: 100px; text-align:right; vertical-align:middle;"> (<?php echo $row['discount'] ?>) <?php echo number_format($row['discount_val'], 2, '.', ',') ?></td><?php */ ?>
                                    <td style="text-align:right;"><?php echo $row['gross_total']; ?></td>
                                </tr>
                            <?php } ?>
                            <tr style="border-top:dashed;">
                                <td style="text-align:left;" colspan="2">SubTotal</td>
                                <td style="text-align:right; padding-right:10px;"><?php echo number_format($gtotal, 2, '.', ',') ?></td>
                            </tr>
                            <?php if ($sale_details['sale_shipping'] > 0) { ?>
                                <tr>
                                    <td style="text-align:left; font-weight:bold;" colspan="2">Delivery Charges</td>
                                    <td style="text-align:right; padding-right:10px;"><?php echo number_format($sale_details['sale_shipping'], 2, '.', ',') ?></td>
                                </tr>
                            <?php } ?>
                            <?php if ($sale_details['sale_extra_charges']) { ?>
                                <tr>
                                    <td style="text-align:left; font-weight:bold;" colspan="2">Service Charges
                                        <?php //echo '('.$sale_details['sale_extra_charges'].')'; 
                                        ?></td>
                                    <td style="text-align:right; padding-right:10px;"><?php echo '(' . $sale_details['sale_extra_charges'] . ')' . number_format($sale_details['sale_extra_charges_amount'], 2, '.', ',') ?></td>
                                </tr>
                            <?php } ?>
                            <?php if ($sale_details['sale_inv_discount_amount']) { ?>
                                <tr>
                                    <td style="text-align:left; font-weight:bold;" colspan="2">Order Discount</td>
                                    <td style="text-align:right; padding-right:10px; border-bottom:solid 1px #000000">(<?php echo number_format($sale_details['sale_inv_discount_amount'], 2, '.', ',') ?>)</td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td style="text-align:left; font-weight:bold; font-size:26px" colspan="2">Total</td>
                                <td style="text-align:right; font-size:26px; font-weight:bold; border-bottom:4px double #000;"><?php echo number_format($sale_details['sale_total'], 2, '.', ',') ?></td>
                            </tr>
                                  

                      
                                <!--END-->
                                
                                
                        </tbody>
                    </table>
                    <br>
                </div>
            </div>
        </div>
        <p class="text-center">
            <small>
                <?php echo $sale_details['sale_id']; ?>
            </small><br>
          <small><small><small> Viable ERP by Sallelanka Solutions(PVT)Ltd 
                    (Madushan - 077706 9344)</small> </small></small>
        </p>
       
    </div>

    <?php 
    $kot = false;
    if($kot)
    if ($sale_details['sale_status'] != 3 && $sale_details['sale_status'] != 99) { ?>
        <div style="" class="col-xs-12 print_area">
            <div align="center" style="font-size:20px; font-weight:bold;"> K.O.T <br><b><u>**cashier copy**</u></b></div>
            <div class="col-xs-12">
                <?php
                if ($sale_details['dine_type']) {
                    if ($sale_details['dine_type'] == 1) echo "<p style=\"font-weight:bold; font-size:14px\">Type: Dine In</p>";
                    else if ($sale_details['dine_type'] == 2) echo "<p style=\"font-weight:bold; font-size:14px\">Type: Take Away</p>";
                    else if ($sale_details['dine_type'] == 3) {
                        echo "<p style=\"font-weight:bold; font-size:14px\">Type: Delivary</p>";
                    }
                }
                ?>
                <p style="font-size:16px; font-weight:bold;margin: 0px 35px 0px 0px;">Bill No: <?php echo $sale_details['sale_id']; ?></p>
                <p style="font-size:16px; font-weight:bold;margin: 0px 35px 0px 0px;"><?php echo $sale_details['sale_datetime']; ?></p>
                <?php echo ($sale_details['table_id'] > 0) ? "<p style=\"font-size:16px; font-weight:bold;margin: 0px 35px 0px 0px;\">Table No:" . $sale_details['table_id'] . "</p>" : "" ?>
                <?php

                if ($customer_details['cus_id'] != 1) {

                    if ($customer_details['cus_phone']) {
                        echo "<p style=\"font-size:12px;margin-bottom:-2px;\">Customer:".$customer_details['cus_name']." 07x-xxx-" . substr($customer_details['cus_phone'],-4) . "</p>";
                    }
                }


                ?>
            </div>
            <div class="col-xs-12">
                <table class="print-table" width="100%">
                    <thead style="border-bottom:dashed;border-top:dashed">
                        <tr class="report_view_th text-center">
                            <th style="width:10%">*</th>
                            <th style="width:25%">Description</th>
                            <th style="width:10%">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $tmpcount = 0;

                        $gtotal  = 0;

                        foreach ($sale_item_list as $row) { ?>
                            <tr>
                                <td style="text-align:center; width:40px; vertical-align:middle;font-weight:bold; font-size:16px">*</td>
                                <td style="vertical-align:middle;font-weight:bold; font-size:16px"><?php echo $row['product_name'] ?></td>
                                <td style="width: 80px; text-align:center; vertical-align:middle;font-weight:bold; font-size:18px"><?php echo ($row['quantity']+0); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
    <script>
    window.onafterprint = function(){
        window.close();
    };
        setTimeout(function() {
            window.print();
        }, 200);
    </script>

</body>