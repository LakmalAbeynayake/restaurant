
<?php $this->load->view("common/header"); ?>
<div style="top:5px;" class="panel-tools open">
<button data-toggle="dropdown" class="btn btn-blue dropdown-toggle" onClick="window.print()">
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
body .modal {
/* new custom width */
width: 750px;
/* must be half of the width, minus scrollbar on the left (30px) */
margin-left: -375px;
}
.print-table td, th{
	padding:3px;
	vertical-align:top !important;
}
thead { display: table-header-group; }
tfoot { display: table-footer-group; }
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
<body onLoad="print_me()">

     
  <div id="print_area">
  <div class="col-xs-12" style="margin-left:-20px;">
  <div class="col-md-11">
  <?php $this->load->view("common/report_header.php"); ?>
  <div class="row">
  <div class="col-xs-12">
<div class="col-xs-12">
<p>Bill No:<?php echo $sale_details['sale_reference_no']; ?> </p>
<p>Acc No: xxx-xxx <?php echo substr($customer_details['cus_phone'],6);?></p>
<p>Customer: <?php echo $customer_details['cus_name']; ?></p>
<p>Payment Status: <?php echo $sale_details['in_type']; ?></p>
<p>Date: <?php echo display_date_time_format($sale_details['sale_datetime']); ?></p>

</div>
<div class="col-xs-4 pull-right">
</div>
</div>
</div>

<div class="print-start">

<?php //print_r($sale_details);?>
  

<table class="print-table" width="100%">
<thead>

<tr class="report_view_th text-center">
<th ><br/>No</th>
<th ><br/>Description</th>
<th ><br/>Code</th>
<th ><br/>Quantity</th>
<th ><br/>Unit Price</th>
<th ><br/>Discount</th> 
<th align="center"><br/>Subtotal</th>
</tr>
</thead>
<tbody>
 <?php 
 $tmpcount=0;
  foreach ($sale_item_list as $row)
 {
	 $tmpcount++;
 ?>  
<tr>
<td style="text-align:center; width:40px; vertical-align:middle;"><?php echo $tmpcount ?></td>
<td style="vertical-align:middle;">
  <?php echo $row['product_name']; ?> </td>
<td style="width: 80px; text-align:center; vertical-align:middle;"><?php echo $row['product_code']; ?></td>
<td style="width: 80px; text-align:center; vertical-align:middle;"><?php echo number_format($row['quantity'], 2, '.', ''); ?></td>
<td style="text-align:right; width:100px;"><?php echo number_format($row['unit_price'], 2, '.', ','); ?></td>

<td style="width: 100px; text-align:right; vertical-align:middle;"> <?php if($row['discount'])echo "(".$row['discount'].")" ?> <?php echo number_format($row['discount_val'], 2, '.', ',') ?></td> <td style="text-align:right; width:120px;"><?php echo $row['gross_total']; ?></td>
</tr>
<?php }?>

<?php if ($sale_details['sale_inv_discount']){ ?>
<tr>
  <td style="text-align:right; padding-right:10px;" colspan="6">Order Discount</td>
  <td style="text-align:right; padding-right:10px;"><?php echo number_format($sale_details['sale_inv_discount_amount'], 2, '.', ',') ?></td>
</tr>
<?php }?>
<tr>
<td style="text-align:right; font-weight:bold;" colspan="6">Total Amount 
</td>
<td style="text-align:right; padding-right:10px; font-weight:bold; border-top:1px solid #000; border-bottom:4px double #000;"><?php echo number_format($sale_details['sale_total'], 2, '.', ',') ?></td>
</tr>

<?php
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
<td style="text-align:right; font-weight:bold;" colspan="6">Advance Paid (<?php echo $row->sale_pymnt_paying_by ?>) 
   [Date:<?php echo date('d/M/Y', strtotime($row->sale_pymnt_date_time));?>]
</td>
<td style="text-align:right; font-weight:bold; border-bottom:1px solid #000;">


<?php echo number_format($row->sale_pymnt_amount, 2, '.', ',') ?></td>
</tr>
<?php }?>

<tr>
<td style="text-align:right; font-weight:bold;" colspan="6">Balance Amount
</td>
<td style="text-align:right; font-weight:bold; border-bottom:4px double #000;">

<?php echo number_format($sale_details['sale_total']-$sale_paid, 2, '.', ',') ?></td>
</tr>
<?php }?>
<?php //if ($sale_details['customer_id']!=1)
{ ?>
<?php if ($old_payments){ ?>
<tr>
<td style="text-align:right; font-weight:bold;" colspan="6"><?php echo $old_payments_dis_msg ?>
</td>
<td style="text-align:right; font-weight:bold; border-top:1px solid #000; border-bottom:4px double #000;"><?php echo number_format($old_payments, 2, '.', ',') ?></td>
</tr>
<tr>
<td style="text-align:right; font-weight:bold;" colspan="6">Total Bill Amount
</td>
<td style="text-align:right; font-weight:bold; border-top:1px solid #000; border-bottom:4px double #000;"><?php echo number_format($old_payments+$sale_details['sale_total'], 2, '.', ',') ?></td>
</tr>
<?php }?>
<?php }?>
</tbody>
</table>
</div>
 <!--col-xs-4-->
   </div>
   </div>
   </div>
   <!--col-xs-12-->
                
     <?php $this->load->view("common/print_footer.php"); ?>   
    
</div>
</div>
<!--print-start-->   
<?php if ($sale_type == "pos_sale") { ?>
<?php } ?>
<script type="text/javascript" src="<?php echo asset_url(); ?>plugins/jQuery-lib/2.0.3/jquery.min.js"></script>

<script>

$(document).ready(function(e) {
    window.print();
});

</script>
 </body>



