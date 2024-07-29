
<?php $this->load->view("common/header"); ?>
<div style="top:5px;" class="panel-tools open">
<button style="display:none" data-toggle="dropdown" class="btn btn-blue dropdown-toggle" onClick="window.print()">
<i class="fa fa-print"></i>
</button>
</div>

<style type="text/css">
th{
	text-align:center !important;
}
.report_view_th{
	color:#000 !important;
	text-align:center !important;	
}
body{
	background-color:#fff !important;
	font-size:12px;
	
}
p{
	margin:0;
}
.modal-body {
  padding: 2px 15px 15px;
  position: relative;
}
body { 

padding:50px;
}

body .modal {
/* new custom width */
width: 750px;
/* must be half of the width, minus scrollbar on the left (30px) */

}
.print-table td, th{
	padding:3px;
	vertical-align:top !important;
}
</style>


<style type="text/css" media="print">

.print-table {
	/*page-break-before:avoid;
	page-break-after: avoid;*/
	/*page-break-inside: avoid;*/
	/*page-break-inside:avoid;*/
	width:100%;
	
}
.td_border_bottom_1{
	border-bottom:1px solid #666 !important;	
}
.td_border_bottom_2{
	border-bottom:4px double #666 !important;	
}
.td_border_top_1{
	border-top:1px double #666 !important;	
}

@media print {
  body * {
    visibility: hidden;
  }
  #print_area, #print_area * {
    visibility: visible;
  }
  #print_area {
    position: absolute;
    left: 0;
    top: 0;
  }
}
</style>
<!--https://css-tricks.com/almanac/properties/p/page-break/-->

<!--onLoad="window.print()-->
<body>

<div id="print_area" style="width:100%">
     <div class="row">
<div class="col-xs-12 text-center">
<h2><?php echo $warehouse_details['name']; ?></h2>
 <!--  <img src="<?php echo asset_url(); ?>images/logo1.png" style="margin-top: -15px;width: 160px;"> -->
  <p>
 <p style="font-size:15px"><?php echo $warehouse_details['address']; ?></p>
<?php echo $warehouse_details['email']; ?> <br>
<?php echo $warehouse_details['phone']; ?>
 
<br>

</p>
   </div><!--col-xs-12-->
</div>

  <div class="row">
  <div class="col-xs-12">
<div class="col-xs-12">
<p></p>
<p style="font-size:12px; margin-bottom:-4px;">Cashier :<?php echo $this->session->userdata('ss_user_first_name'); ?></p>
<p style="font-size:12px;margin-bottom:-4px;">Bill No: <?php echo $sale_details['sale_reference_no']; ?></p>
<p style="font-size:12px;margin-bottom:-4px;">Acc No: xxx-xxx <?php echo substr($customer_details['cus_phone'],6);?>
<p style="margin-bottom:-4px;">Customer: <?php echo $customer_details['cus_name']; ?></p>



<?php if($customer_details['cus_address']){ ?>
<p>Address: <?php echo $customer_details['cus_address']; ?></p>
<?php } ?>
<?php
/*print_r($sale_details);*/
 if($sale_details['invoice_type']){ ?>
<p>Type: <?php echo "POS"; ?></p>
<?php } ?>
<p>Date: <?php echo display_date_time_format($sale_details['sale_datetime']); ?></p>
</div>

</div>
</div>

<div class="print-start">

<?php //print_r($sale_details);?>
  
<div class="row col-md-12">
	
    <div class="col-xs-11">
    <table class="print-table" width="100%">
<thead style="border-bottom:dashed;border-top:dashed">

<tr class="report_view_th text-center">
<th style="width:10%">No</th>
<th style="width:25%">Description</th>

<th style="width:10%">Qty</th>
<th style="width:10%">Price</th>
<?php /*?><th class="col-xs-1"><br/>Discount</th> <?php */?>
<th align="center">
Amount</th>
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
<td style="text-align:center; width:40px; vertical-align:middle;"><?php echo $tmpcount ?></td>
<td style="vertical-align:middle;">
  <?php echo $row['product_name'] ?></td>
<td style="width: 80px; text-align:center; vertical-align:middle;"><?php echo number_format($row['quantity'], 2, '.', ''); ?></td>
<td style="text-align:right; width:100px;"><?php echo number_format($row['unit_price'], 2, '.', ','); ?></td>

<?php /*?><td style="width: 100px; text-align:right; vertical-align:middle;"> (<?php echo $row['discount'] ?>) <?php echo number_format($row['discount_val'], 2, '.', ',') ?></td><?php */?> 
<td style="text-align:right; width:120px; padding-right:10px;"><?php echo $row['gross_total']; ?></td>
</tr>
<?php }?>


<tr style="border-top:dashed;">
  <td style="text-align:right;" colspan="4">SubTotal</td>
  <td style="text-align:right; padding-right:10px;"><?php echo number_format($gtotal, 2, '.', ',') ?></td>
</tr>
<?php if($sale_details['sale_shipping'] > 0){ ?>
<tr>
<td style="text-align:right; font-weight:bold;" colspan="4">Delivery Charges</td>
<td style="text-align:right; padding-right:10px;"><?php echo number_format($sale_details['sale_shipping'], 2, '.', ',')?></td>
</tr>
<?php } ?>
<?php if ($sale_details['sale_inv_discount_amount']){ ?>
<tr>
<td style="text-align:right; font-weight:bold;" colspan="4">Order Discount</td>
<td style="text-align:right; padding-right:10px; border-bottom:solid 1px #000000">(<?php echo number_format($sale_details['sale_inv_discount_amount'], 2, '.', ',') ?>)</td>
</tr>
<?php }?>
<tr>
<td style="text-align:right; font-weight:bold; font-size:16px" colspan="4">Total Amount</td>
<td style="text-align:right; padding-right:10px; font-size:16px; font-weight:bold; border-bottom:4px double #000;">
<?php echo number_format($sale_details['sale_total'], 2, '.', ',') ?></tr>

<tr>
<td style="text-align:right; font-weight:bold;" colspan="4"><?php 
echo $this->input->get("paid_by") ?>
</td>
<td style="text-align:right; padding-right:10px; font-weight:bold"><?php
if($this->input->get('pay_amount'))
 echo number_format($this->input->get('pay_amount'), 2, '.', ',');
 else echo number_format(0, 2, '.', ',') ?></td>
</tr>
<tr>
<td style="font-size:16px;text-align:right; font-weight:bold" colspan="4">Balance Amount</td>
<td style="text-align:right; font-weight:bold; border-bottom:4px double #000;">
<p style="font-size:16px">
<?php 
if($this->input->get('pay_amount'))
echo number_format($this->input->get('pay_amount')-$sale_details['sale_total'], 2, '.', ',');
else echo number_format(0, 2, '.', ',');
 ?>&nbsp;&nbsp;
</p>
</td>
</tr>
<?php /*?><?php
$Sales_Model = new Sales_Model();
$sale_paid = $Sales_Model->get_total_paid_by_sale_id($sale_details['sale_id']);

$bal=$sale_details['sale_total']-$sale_paid;
 if ($bal>0){ ?>
 
 <?php  
	 $balance_amt=0;
	 $tot_advnc_paid=0;
 foreach ($sale_payments_list as $row){
	$tot_advnc_paid+=$row->sale_pymnt_amount;


	 ?>  
<tr>
<td style="text-align:right; font-weight:bold;" colspan="4">Advance Paid (<?php echo $row->sale_pymnt_paying_by ?>) 
   [Date:<?php echo date('d/M/Y', strtotime($row->sale_pymnt_date_time));?>]
</td>
<td style="text-align:right; padding-right:10px; font-weight:bold; border-bottom:1px solid #000;">


<?php echo number_format($row->sale_pymnt_amount, 2, '.', ',') ?></td>
</tr>
<?php }?>

<tr>
<td style="text-align:right;  font-weight:bold;" colspan="4">Balance Amount
</td>
<td style="text-align:right; font-weight:bold; border-bottom:4px double #000;">

<?php echo number_format($sale_details['sale_total']-$sale_paid, 2, '.', ',') ?></td>
</tr>
<?php }?><?php */?>
<?php //if ($sale_details['customer_id']!=1)
{ ?>
<?php /*?><?php if ($old_payments){ ?>
<tr>
<td style="text-align:right; font-weight:bold;" colspan="4"><?php echo $old_payments_dis_msg ?>
</td>
<td style="text-align:right; font-weight:bold; border-top:1px solid #000; border-bottom:4px double #000;"><?php echo number_format($old_payments, 2, '.', ',') ?></td>
</tr>
<tr>
<td style="text-align:right; font-weight:bold;" colspan="4">Total Bill Amount
</td>
<td style="text-align:right; font-weight:bold; border-top:1px solid #000; border-bottom:4px double #000;"><?php echo number_format($old_payments+$sale_details['sale_total'], 2, '.', ',') ?></td>
</tr>
<?php }?><?php */?>
<?php }?>
</tbody>
</table>
<br>
<p align="center" style="font-weight:bold"><i class="fa fa-facebook"></i>: bakerschoice.colombo </p>
</div>
    </div>
</div>

</div><!--print-start-->   
<?php if ($sale_type == "pos_sale") { ?>
<?php } ?>

<script type="text/javascript" src="<?php echo asset_url(); ?>plugins/jQuery-lib/2.0.3/jquery.min.js"></script>
<script>
$(document).ready(function(e) {
   setInterval(function(){ window.print();},1000);
});
</script>

</body>



