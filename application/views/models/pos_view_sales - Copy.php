
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
</style>
<!--https://css-tricks.com/almanac/properties/p/page-break/-->

<!--onLoad="window.print()-->
<body onLoad="window.print()">

     <?php $this->load->view("common/report_header.php"); ?>
  <div class="row">
  <div class="col-xs-12">
<div class="col-xs-12">

<?php if($customer_details['cus_name']){ ?>
<p>Customer: <?php echo $customer_details['cus_code']."&nbsp;".$customer_details['cus_name']; ?> <?php echo $customer_details['cus_address']; ?></p>
<?php } ?>

<?php if($customer_details['cus_phone']){ ?>
<p>Phone : <?php echo $customer_details['cus_phone']; ?></p>
<?php } ?>


<?php if($customer_details['cus_address']){ ?>
<p>Address: <?php echo $customer_details['cus_address']; ?></p>
<?php } ?>
<p>Sales Terms: <?php echo $sale_details['in_type']; ?></p>
<p>Date: <?php echo display_date_time_format($sale_details['sale_datetime']); ?></p>
</div>

</div>
</div>

<div class="print-start">

<?php //print_r($sale_details);?>
  

<table class="print-table" width="100%">
<thead>

<tr class="report_view_th text-center">
<th class="col-xs-1" width="20px"><br/>No</th>
<th class="col-xs-2"><br/>Description</th>

<th class="col-xs-1"><br/>Quantity</th>
<th class="col-xs-1"><br/>Unit Price</th>
<th class="col-xs-1"><br/>Discount</th> 
<th class="col-xs-1" align="center">Invoice:<?php echo $sale_details['sale_reference_no']; ?> Subtotal</th>
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
  <?php echo $row['product_code']."<br>".$row['product_name']; ?></td>
<td style="width: 80px; text-align:center; vertical-align:middle;"><?php echo number_format($row['quantity'], 2, '.', ''); ?></td>
<td style="text-align:right; width:100px;"><?php echo number_format($row['unit_price'], 2, '.', ','); ?></td>

<td style="width: 100px; text-align:right; vertical-align:middle;"> (<?php echo $row['discount'] ?>) <?php echo number_format($row['discount_val'], 2, '.', ',') ?></td> <td style="text-align:right; width:120px;"><?php echo $row['gross_total']; ?></td>
</tr>
<?php }?>

<?php if ($sale_details['sale_inv_discount']){ ?>
<tr>
  <td style="text-align:right; padding-right:10px;" colspan="5">Order Discount</td>
  <td style="text-align:right; padding-right:10px;"><?php echo number_format($sale_details['sale_inv_discount_amount'], 2, '.', ',') ?></td>
</tr>
<?php }?>
<tr>
<td style="text-align:right; font-weight:bold;" colspan="5">Total Amount 
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
<td style="text-align:right; font-weight:bold;" colspan="5">Advance Paid (<?php echo $row->sale_pymnt_paying_by ?>) 
   [Date:<?php echo date('d/M/Y', strtotime($row->sale_pymnt_date_time));?>]
</td>
<td style="text-align:right; font-weight:bold; border-bottom:1px solid #000;">


<?php echo number_format($row->sale_pymnt_amount, 2, '.', ',') ?></td>
</tr>
<?php }?>

<tr>
<td style="text-align:right; font-weight:bold;" colspan="5">Balance Amount
</td>
<td style="text-align:right; font-weight:bold; border-bottom:4px double #000;">

<?php echo number_format($sale_details['sale_total']-$sale_paid, 2, '.', ',') ?></td>
</tr>
<?php }?>
<?php //if ($sale_details['customer_id']!=1)
{ ?>
<?php if ($old_payments){ ?>
<tr>
<td style="text-align:right; font-weight:bold;" colspan="5"><?php echo $old_payments_dis_msg ?>
</td>
<td style="text-align:right; font-weight:bold; border-top:1px solid #000; border-bottom:4px double #000;"><?php echo number_format($old_payments, 2, '.', ',') ?></td>
</tr>
<tr>
<td style="text-align:right; font-weight:bold;" colspan="5">Total Bill Amount
</td>
<td style="text-align:right; font-weight:bold; border-top:1px solid #000; border-bottom:4px double #000;"><?php echo number_format($old_payments+$sale_details['sale_total'], 2, '.', ',') ?></td>
</tr>
<?php }?>
<?php }?>
</tbody>
</table>
</div>



                 
 <div class="row">
 <br>
<br>

<div class="col-xs-12">
<div class="col-xs-4"> Prepared by: <br>

<br>


</div> <!--col-xs-4-->



<div class="col-xs-3 pull-right">Customer<br>


<br>
</div> <!--col-xs-4-->
   </div><!--col-xs-12-->
                
     <?php $this->load->view("common/print_footer.php"); ?>   
    
</div><!--print-start-->   
<?php if ($sale_type == "pos_sale") { ?>
<div class="no-print" style="padding-top:10px; text-transform:uppercase;" id="buttons">
   <hr>
   <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert">×</button>
      POS Sale successfully added 
   </div>
   <span class="pull-right col-xs-12">
   <a onClick="window.print();return false;" class="btn btn-block btn-primary" id="web_print" href="javascript:window.print()">Web Print</a>
   </span>
   <span class="col-xs-12">
   <a href="<?php echo base_url('pos'); ?>" class="btn btn-block btn-warning">Back to POS</a>
   </span>
   <div style="clear:both;"></div>
</div>

<?php } ?>
 </body>



