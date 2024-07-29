<!DOCTYPE html>

<html lang="en" class="no-js">

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
<link rel="icon" type="image/png" href="<?php echo base_url();?>thems/images/your-logo-here.png" />
<link rel="stylesheet" href="<?php echo asset_url();?>plugins/bootstrap/css/bootstrap.min.css">
</head>
<div style="top:5px;" class="panel-tools open">
  <button style="display:none" data-toggle="dropdown" class="btn btn-blue dropdown-toggle" onClick="window.print()"><i class="fa fa-print"></i></button>
</div>
<style type="text/css">
<?php /*?>th {
	text-align: center !important;
}
.report_view_th {
	color: #000 !important;
	text-align: center !important;
}
body {
	background-color: #fff !important;
	font-size: 12px;
}<?php */?>
p {
	margin: 0;
}

<?php /*?>.print-table td, th {
	padding: 3px;
	vertical-align: top !important;
}
thead {
	display: table-header-group;
}
tfoot {
	display: table-footer-group;
}<?php */?>
</style>
<style type="text/css" media="print">
.print-table {
	width: 100%;
}
.pagebreak {
	page-break-before: always;
}
 @page {
size: auto;   /* auto is the initial value */
margin: 0;  /* this affects the margin in the printer settings */
}
</style>

<body style="font-family: monospace; font-size: 14px" onLoad="start()">
<div class="print_area print" style="width:100%;margin-left:0px;">
  <div class="row">
    <div class="col-xs-12 text-center">
      <center>
        <div style="display:none; border:solid 3px; border-radius:50px; width:13%; padding:15px; line-height:1"><span style="font-size:31px;font-weight:bold">SO</span> <span style="font-size:14px;font-weight:bold">Yummy</span></div>
      </center>
     <!--  <img src="<?php echo asset_url(); ?>images/logo_print.png" style="margin-top: 1px;width: 100px;"> -->
     <h2><?php echo $warehouse_details['name']; ?></h2>
      <p style="font-size:15px"><?php echo $warehouse_details['address']; ?></p>
      <?php if($warehouse_details['email']) echo $warehouse_details['email']."<br>"; ?>
      <?php if($warehouse_details['phone']) echo "<span style=\"font-weight:bold; font-size:15px\">".$warehouse_details['phone']."</span><br>"; ?>
    </div>
    
    <!--col-xs-12--> 
    
  </div>
  <div class="row">
                  <div class="col-md-6">
                      <p id="bill_date" style="margin-bottom: 0px">Date: </p>
                  </div>
                  <div class="col-md-6">
                      <p> <?php echo display_date_time_format($sale_details['sale_datetime']); ?></p>
                  </div>
              </div>
    
    <div class="row">
                  <div class="col-md-12">
                      <p id="bill_no"  style="font-weight:bold; margin-bottom: 0px">Bill No: <?php echo $sale_details['sale_reference_no']; ?></p>
                    
                      <?php 

            if($customer_details['cus_id'] != 1){ 

    //        	  if($customer_details['cus_address']){ echo "<p>Address: ".$customer_details['cus_address']."</p>"; }

                  if($customer_details['cus_phone']){ echo "<p style=\"font-size:12px;margin-bottom:-4px;\">Acc No: xxx-xxx ".substr($customer_details['cus_phone'],6)."</p>"; }

            }

        if($sale_details['dine_type'])

        if($sale_details['dine_type'] == 1) echo "<p style=\"font-size:13px\">Type: Dine In</p>";

        else if($sale_details['dine_type'] == 2) echo "<p style=\"font-size:13px\">Type: Take Away</p>";

        else if($sale_details['dine_type'] == 3){

                 echo "<p style=\"font-size:13px\">Type: Delivery</p>";

                 echo "<p>Delivery Address: ".$sale_details['shipping_address']." </p>";

                 } ?>
                  </div>
              </div>
    <div class="row">
                  <div class="col-md-12">
                      <p style="" id="bill_customer">Customer: <?php echo $customer_details['cus_name']; ?></p>
                  </div>
              </div>
  <div class="print-start">
    <?php //print_r($sale_details);?>
    <div class="row col-md-12">
      <div class="col-xs-12">
        <table class="print-table" width="100%">
          <thead style="border-bottom:dashed;border-top:dashed">
            <tr class="report_view_th text-center">
              <th style="width:5%">*</th>
              <th style="width:40%">Description</th>
              <th style="width:15%">Qty</th>
              <th style="width:15%">Price</th>
              <?php /*?><th class="col-xs-1"><br/>Discount</th> <?php */?>
              <th align="center"> Amount</th>
            </tr>
          </thead>
          <tbody>
            <?php 

 $tmpcount=0;

 $gtotal  =0;

  foreach ($sale_item_list as $row)

 {

	 $gtotal += $row['gross_total'];

	 $tmpcount++;

 ?>
            <tr>
              <td style="text-align:center; width:40px; vertical-align:middle;font-weight:bold; font-size:13px">*</td>
              <td style="vertical-align:middle;font-weight:bold; font-size:13px"><?php echo $row['product_name'] ?></td>
              <td style="width: 80px; text-align:center; vertical-align:middle;font-weight:bold; font-size:13px"><?php echo ( $row['quantity']+0); ?></td>
              <td style="text-align:right; width:100px;"><?php echo number_format($row['unit_price'], 2, '.', ','); ?></td>
              <?php /*?><td style="width: 100px; text-align:right; vertical-align:middle;"> (<?php echo $row['discount'] ?>) <?php echo number_format($row['discount_val'], 2, '.', ',') ?></td><?php */?>
              <td style="text-align:right; width:120px; padding-right:10px;"><?php echo $row['gross_total']; ?></td>
            </tr>
            <?php }?>
            <tr style="border-top:dashed;">
              <td style="" colspan="4">SubTotal</td>
              <td style="text-align:right; padding-right:10px;"><?php echo number_format($gtotal, 2, '.', ',') ?></td>
            </tr>
            <?php if($sale_details['sale_shipping'] > 0){ ?>
            <tr>
              <td style=" font-weight:bold;" colspan="4">Delivery Charges</td>
              <td style="text-align:right; padding-right:10px;"><?php echo number_format($sale_details['sale_shipping'], 2, '.', ',')?></td>
            </tr>
            <?php } ?>
            <?php if($sale_details['sale_extra_charges']){ ?>
            <tr>
              <td style=" font-weight:bold;" colspan="4">Service Charges
                <?php //echo '('.$sale_details['sale_extra_charges'].')'; ?></td>
              <td style="text-align:right; padding-right:10px;"><?php echo number_format($sale_details['sale_extra_charges_amount'], 2, '.', ',')?></td>
            </tr>
            <?php } ?>
            <?php if ($sale_details['sale_inv_discount_amount']){ ?>
            <tr>
              <td style=" font-weight:bold;" colspan="4">Order Discount</td>
              <td style="text-align:right; padding-right:10px; border-bottom:solid 1px #000000">(<?php echo number_format($sale_details['sale_inv_discount_amount'], 2, '.', ',') ?>)</td>
            </tr>
            <?php }?>
            <tr>
              <td style=" font-weight:bold; font-size:24px" colspan="4">Total Amount</td>
              <td style="text-align:right; padding-right:10px; font-size:15px; font-weight:bold; border-bottom:4px double #000;"><?php echo number_format($sale_details['sale_total'], 2, '.', ',') ?>
            </tr>
            <?php if($sale_details['dine_type'] != 3){ ?>
            <?php 

			if(isset($sale_payments_list[0]))

			if($sale_payments_list[0]->sale_pymnt_paying_by){ ?>
            <tr>
              <td style="text-align:right; font-weight:bold;" colspan="4"><?php 

echo $sale_payments_list[0]->sale_pymnt_paying_by ?></td>
              <td style="text-align:right; padding-right:10px; font-weight:bold"><?php

if($sale_payments_list[0]->sale_pymnt_given_amount)

 echo number_format($sale_payments_list[0]->sale_pymnt_given_amount, 2, '.', ',');

 else echo number_format(0, 2, '.', ',') ?></td>
            </tr>
            <?php } ?>
            <?php

if(isset($sale_payments_list[0])) 

if( floatval($sale_payments_list[0]->sale_pymnt_given_amount) > 0 ){

?>
            <tr>
              <td style="font-size:15px;text-align:right; font-weight:bold" colspan="4">Balance Amount</td>
              <td style="text-align:right; font-weight:bold; border-bottom:4px double #000;"><p style="font-size:15px">
                  <?php 

if($sale_payments_list[0]->sale_pymnt_given_amount)

echo number_format($sale_payments_list[0]->sale_pymnt_given_amount-$sale_details['sale_total'], 2, '.', ',');

else echo number_format(0, 2, '.', ',');

			}?>
                  &nbsp;&nbsp; </p></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <br>
        
        <?php //if( floatval($sale_payments_list[0]->sale_pymnt_given_amount) > 0 ) echo '2'; else echo '1'; ?>
      </div>
      <div style="text-align: center">
              <h2 style="margin-top: 5px">~~~Thank You~~~</h2>
          </div>
          <div class="row collapse" style="padding-left: 6px;text-align: center    ">
              <div class="icon"  style="float: left;padding-left: 10px;">
                  <img src="<?php echo asset_url(); ?>images/restaurant_70_1_35x35.png">
              </div>
              <div class="icon"  style="float: left">
                  <img src="<?php echo asset_url(); ?>images/baricon_35x35.png">
              </div>
              <div class="icon"  style="float: left">
                  <img src="<?php echo asset_url(); ?>images/double-bed_70_1_35x35.png">
              </div>
              <div class="icon"  style="float: left">
                  <img src="<?php echo asset_url(); ?>images/delivery-truck_70_1_35x35.png">
              </div>
          </div>
          <style>
              .icon img{
                  margin-left: 12px;
                    margin-right: 12px;
              }
          </style>
    </div>
  </div>
</div>
<script>
    function start(){
        setTimeout(function(){
            window.print();
        },200);
        
        setTimeout(function(){
            window.close();
        },300);
        
    }
</script>
<?php /*?><div class="pagebreak"> - </div><?php */?>
<?php /*?><div class="col-xs-12 print_area">
  <div align="center" style="font-size:16px; font-weight:bold;"> K.O.T </div>
  <div class="col-xs-6">
    <p style="font-size:16px; font-weight:bold;margin: 0px 35px 0px 0px;">Bill No: <?php echo $sale_details['sale_reference_no']; ?></p>
    <?php 

                if($customer_details['cus_id'] != 1){ 

                      if($customer_details['cus_phone']){ echo "<p style=\"font-size:12px;margin-bottom:-2px;\">Acc No: xxx-xxx ".substr($customer_details['cus_phone'],6)."</p>"; }

                }

            if($sale_details['dine_type'])

            if($sale_details['dine_type'] == 1) echo "<p style=\"font-weight:bold; font-size:14px\">Type: Dine In</p>";

            else if($sale_details['dine_type'] == 2) echo "<p style=\"font-weight:bold; font-size:14px\">Type: Take Away</p>";

            else if($sale_details['dine_type'] == 3){

                     echo "<p style=\"font-weight:bold; font-size:14px\">Type: Delivary</p>";

                     

                     } ?>
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

 $tmpcount=0;

 $gtotal  =0;

 foreach ($sale_item_list as $row){ ?>
        <tr>
          <td style="text-align:center; width:40px; vertical-align:middle;font-weight:bold; font-size:16px">*</td>
          <td style="vertical-align:middle;font-weight:bold; font-size:16px"><?php echo $row['product_name'] ?></td>
          <td style="width: 80px; text-align:center; vertical-align:middle;font-weight:bold; font-size:18px"><?php echo intval( $row['quantity']); ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div><?php */?>

<!--print-start-->

</body>
