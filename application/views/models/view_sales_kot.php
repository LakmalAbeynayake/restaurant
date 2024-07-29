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
<link rel="icon" type="image/png" href="<?php echo base_url();?>thems/images/your-logo-here.png" />
<link rel="stylesheet" href="<?php echo asset_url();?>plugins/bootstrap/css/bootstrap.min.css">
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
.print-table td, th {
	padding: 3px;
	vertical-align: top !important;
}
thead {
	display: table-header-group;
}
tfoot {
	display: table-footer-group;
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
size: auto;   /* auto is the initial value */
margin: 0;  /* this affects the margin in the printer settings */
}
</style>

<body style="font-size:16px">
<?php if($sale_details['sale_status'] != 3) {?>
<div style="" class="col-xs-12 print_area">
  <div align="center" style="font-size:22px; font-weight:bold;"> K.O.T <br><b><u>***CASHIER COPY***</u></b></div>
  <?php
        if($sale_details['kitchen_note'] != ""){
    ?>
  <p class="col-sm-12" style="border-bottom: dashed 2px;border-top: dashed 2px;">
      NOTE:<strong>
       <?php
        echo $sale_details['kitchen_note'];
       ?>
       </strong>
  </p>
  <?php
        }
  ?>
  <div class="col-xs-12">
    <?php 
    if($sale_details['dine_type']){
                if($sale_details['dine_type'] == 1) echo "<p style=\"font-weight:bold; font-size:14px\">Type: Dine In</p>";
                else if($sale_details['dine_type'] == 2) echo "<p style=\"font-weight:bold; font-size:14px\">Type: Take Away</p>";
                else if($sale_details['dine_type'] == 3){
                    echo "<p style=\"font-weight:bold; font-size:14px\">Type: Delivary</p>";
                }
            }
    ?>
    <p style="font-size:16px; font-weight:bold;margin: 0px 35px 0px 0px;">Bill No: <?php echo $sale_details['sale_id']; ?></p>
    <p style="font-size:16px; font-weight:bold;margin: 0px 35px 0px 0px;"><?php echo $sale_details['sale_datetime']; ?></p>
    <?php echo ($sale_details['table_id'] > 0)? "<p style=\"font-size:16px; font-weight:bold;margin: 0px 35px 0px 0px;\">Table No:".$sale_details['table_id']."</p>":"" ?>
    <?php 

                if($customer_details['cus_id'] != 1){ 

                      if($customer_details['cus_phone']){ echo "<p style=\"font-size:12px;margin-bottom:-2px;\">Customer:".($customer_details['cus_phone'])."</p>"; }

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
</div>
<?php } ?>
<script>
setTimeout(function(){
    window.print();
    setTimeout(function(){
        window.close()
    },100);
    
},1000);
</script>

</body>
