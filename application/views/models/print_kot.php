<!DOCTYPE html>
<html lang="en" class="no-js">
<!-- start: HEAD -->
<head>
    <title>STOCK MANAGEMENT SYSTEM</title>
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
}<?php */ ?>p {
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
}<?php */ ?>
</style>
<style type="text/css" media="print">
    .print-table {
        width: 100%;
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
</style>
<body style="font-size:11px;;width:100%;margin-left:5px;page-break-after:auto">
    <div class="" style="padding-top:40px; padding-bottom:40px;border-top:solid; border-bottom:solid">
        <div align="center" style="font-size:25px; font-weight:bold;"> KOT - <?php echo $kot_details['kot_ref_no'] ; //substr($sale_details['sale_id'], -4); ?> </div>
        <div class="">
            <p style="font-size:14px; font-weight:bold;margin: 0px 35px 0px 0px;">Bill No: <?php echo $sale_details['sale_id']; ?> | KOT Ref : <?php echo $kot_details['kot_ref_no']; ?> </p>
            <p style="font-size:14px; font-weight:bold;margin: 0px 35px 0px 0px;">Waiter: <?php echo $sale_details['waitername']; ?></p>
            <p style="font-size:14px; font-weight:bold;margin: 0px 35px 0px 0px;">Cashier: <?php echo $sale_details['cashier']; ?></p>
            <?php if ($sale_details['odr_type'] == 2) { ?>
                <p style="font-size:14px; font-weight:bold;margin: 0px 35px 0px 0px;"> **Call Order**</p>
            <?php } ?>
            <p style="font-size:14px; font-weight:bold;margin: 0px 35px 0px 0px;">Time &ensp;: <?php echo date('Y/m/d - g:i A', strtotime($kot_details['system_date_time'])); ?></p>
            <?php
            if ($customer_details['cus_id'] != 1) {
                if ($customer_details['cus_phone']) {
                    echo "<p style=\"font-size:12px;margin-bottom:-2px;\">Acc No: xxx-xxx " . substr($customer_details['cus_phone'], 6) . "</p>";
                }
            }
            if ($sale_details['dine_type'])
                if ($sale_details['dine_type'] == 1) echo "<p style=\"font-weight:bold; font-size:14px\">Type&ensp;&ensp;: Dine In</p>";
            else if ($sale_details['dine_type'] == 2) echo "<p style=\"font-weight:bold; font-size:14px\">Type&ensp;&ensp;: Take Away</p>";
            else if ($sale_details['dine_type'] == 3) {
                echo "<p style=\"font-weight:bold; font-size:13px\">Type: Delivary</p>";
            }
                
            if ($table_id != 0) echo "<p style=\"font-weight:bold; font-size:13px\">Table Number:" . $table_id . "</p>";
            ?>
        </div>
        <div class="">
            <table class="print-table" width="100%">
                <thead style="border-bottom:dashed;border-top:dashed">
                    <tr class="report_view_th text-center">
                        <th style="width:5%" class="text-center">*</th>
                        <th style="width:50%">Description</th>
                        <th style="width:10%" class="text-center">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tmpcount = 0;
                    $gtotal  = 0;
                    foreach ($sale_item_list as $row) { ?>
                        <tr>
                            <td style="text-align:center; width:40px; vertical-align:middle;font-weight:bold; font-size:16px">*</td>
                            <td style="vertical-align:middle;font-weight:bold; font-size:16px"><?php echo $row['product_name'] ?> <?php if ($row['separate_status'] == 1) {
                                                                                                                                        echo "**SEPARATE**";
                                                                                                                                    } ?></td>
                            <td style="width: 80px; text-align:center; vertical-align:middle;font-weight:bold; font-size:18px"><?php echo intval($row['quantity']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php if (isset($sale_details['kitchen_note'])) {
                echo "<div style='font-size:13px'>" . $sale_details['kitchen_note'] . "</div>";
            } ?>
        </div>
    </div>
    <!--<div class="print_area pagebreak" style="padding-top:40px; padding-bottom:40px;border-top:solid; border-bottom:solid">
  <div align="center" style="font-size:16px; font-weight:bold;"> K.O.T ( part 2)</div>
  <div class="">
    <p style="font-size:14px; font-weight:bold;margin: 0px 35px 0px 0px;">Bill No: <?php echo $sale_details['sale_reference_no']; ?></p>
    <p style="font-size:14px; font-weight:bold;margin: 0px 35px 0px 0px;">Time &ensp;: <?php echo date('Y/m/d - g:i A', strtotime($sale_details['sale_datetime'])); ?></p>
    <?php
    if ($customer_details['cus_id'] != 1) {
        if ($customer_details['cus_phone']) {
            echo "<p style=\"font-size:12px;margin-bottom:-2px;\">Acc No: xxx-xxx " . substr($customer_details['cus_phone'], 6) . "</p>";
        }
    }
    if ($sale_details['dine_type'])
        if ($sale_details['dine_type'] == 1) echo "<p style=\"font-weight:bold; font-size:14px\">Type&ensp;&ensp;: Dine In</p>";
        else if ($sale_details['dine_type'] == 2) echo "<p style=\"font-weight:bold; font-size:14px\">Type&ensp;&ensp;: Take Away</p>";
        else if ($sale_details['dine_type'] == 3) {
            echo "<p style=\"font-weight:bold; font-size:13px\">Type: Delivary</p>";
        }
    if ($floor_name == 'BAR') $floor_name .= ' / ' . $area_name;
    echo "<p style=\"font-weight:bold; font-size:13px\">Order Place:" . $floor_name . "</p>";
    if ($table_id != 0) echo "<p style=\"font-weight:bold; font-size:13px\">Table Number:" . $table_id . "</p>";
    ?>
  </div>
  <div class="">
    <table class="print-table" width="100%">
      <thead style="border-bottom:dashed;border-top:dashed">
        <tr class="report_view_th text-center">
          <th style="width:5%" class="text-center">*</th>
          <th style="width:50%">Description</th>
          <th style="width:10%" class="text-center">Qty</th>
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
          <td style="width: 80px; text-align:center; vertical-align:middle;font-weight:bold; font-size:18px"><?php echo intval($row['quantity']); ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>-->
    <?php /*?><div class="print_area pagebreak" style="padding-top:40px; padding-bottom:40px;border-top:solid; border-bottom:solid">
  <div align="center" style="font-size:16px; font-weight:bold;"> K.O.T ( part 3)</div>
  <div class="">
    <p style="font-size:14px; font-weight:bold;margin: 0px 35px 0px 0px;">Bill No: <?php echo $sale_details['sale_reference_no']; ?></p>
    <p style="font-size:14px; font-weight:bold;margin: 0px 35px 0px 0px;">Time &ensp;: <?php echo date('Y/m/d - g:i A', strtotime($sale_details['sale_datetime'])); ?></p>
    <?php 
                if($customer_details['cus_id'] != 1){ 
                      if($customer_details['cus_phone']){ echo "<p style=\"font-size:12px;margin-bottom:-2px;\">Acc No: xxx-xxx ".substr($customer_details['cus_phone'],6)."</p>"; }
                }
            if($sale_details['dine_type'])
            if($sale_details['dine_type'] == 1) echo "<p style=\"font-weight:bold; font-size:14px\">Type&ensp;&ensp;: Dine In</p>";
            else if($sale_details['dine_type'] == 2) echo "<p style=\"font-weight:bold; font-size:14px\">Type&ensp;&ensp;: Take Away</p>";
            else if($sale_details['dine_type'] == 3){
                     echo "<p style=\"font-weight:bold; font-size:13px\">Type: Delivary</p>";
					 }
	if($floor_name == 'BAR')$floor_name .= ' / '.$area_name;
	echo "<p style=\"font-weight:bold; font-size:13px\">Order Place:".$floor_name."</p>";
	
	if($table_id != 0)echo "<p style=\"font-weight:bold; font-size:13px\">Table Number:".$table_id."</p>";
	 ?>
  </div>
  <div class="">
    <table class="print-table" width="100%">
      <thead style="border-bottom:dashed;border-top:dashed">
        <tr class="report_view_th text-center">
          <th style="width:5%" class="text-center">*</th>
          <th style="width:50%">Description</th>
          <th style="width:10%" class="text-center">Qty</th>
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
</div><?php */ ?>
    <script>
        
        window.onafterprint = function(){
            window.close();
        };
        
        setTimeout(function() {
            window.print();
        }, 100);
        
    </script>
    <!--print-start-->
</body>