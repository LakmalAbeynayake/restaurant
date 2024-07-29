
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
<div class="col-xs-6">
<p>Customer Code: <?php echo $customer_details['cus_code']; ?></p>
<p>Name and Address: <?php echo $customer_details['cus_name']; ?> <?php echo $customer_details['cus_address']; ?> &nbsp; <?php echo $customer_details['cus_phone']; ?></p>

</div>
<div class="col-xs-4 pull-right">
<p>INVOICE: SALES RETURN </p>
<p>Date: <?php echo display_date_time_format($sale_rtn_details['sl_rtn_datetime']); ?></p>
</div>
</div>
</div>

<div class="print-start">


  

<table class="print-table" width="100%">
<thead>
<tr class="report_view_th">
  <th colspan="7" class="col-xs-1 text-right">
  <span style="float:right;">Invoice No: <?php echo $sale_rtn_details['sl_rtn_reference_no']; ?></span>
  </th>
  </tr>
<tr class="report_view_th text-center">
<th class="col-xs-1" width="20px">No</th>
<th class="col-xs-2">Description</th>
<th class="col-xs-1">Code</th>
<th class="col-xs-1">Quantity</th>
<th class="col-xs-1">Unit Price</th>
<th class="col-xs-1">Discount</th> 
<th class="col-xs-2" align="center">Subtotal</th>
</tr>
</thead>
<tbody>
 <?php 
 $tmpcount=0;
  foreach ($sale_rtn_item_list as $row)
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

<td style="width: 100px; text-align:right; vertical-align:middle;"> (<?php echo $row['discount'] ?>) <?php echo number_format($row['discount_val'], 2, '.', ',') ?></td> <td style="text-align:right; width:120px;"><?php echo $row['gross_total']; ?></td>
</tr>
<?php }?>

<?php if ($sale_rtn_details['sl_rtn_inv_discount']){ ?>
<tr>
  <td style="text-align:right; padding-right:10px;" colspan="6">Order Discount</td>
  <td style="text-align:right; padding-right:10px;"><?php echo number_format($sale_rtn_details['sale_inv_discount_amount'], 2, '.', ',') ?></td>
</tr>
<?php }?>
<tr>
<td style="text-align:right; font-weight:bold;" colspan="6">Total Amount 
</td>
<td style="text-align:right; padding-right:10px; font-weight:bold; border-top:1px solid #000; border-bottom:4px double #000;"><?php echo number_format($sale_rtn_details['sl_rtn_total'], 2, '.', ',') ?></td>
</tr>



</tbody>
</table>
</div>



                 
 <div class="row">
 <br>
<br>

<div class="col-xs-12">
<div class="col-xs-4"> Prepared by <br>

<br>


</div> <!--col-xs-4-->



<div class="col-xs-3 pull-right">Customer<br>


<br>
</div> <!--col-xs-4-->
   </div><!--col-xs-12-->
                
     <?php $this->load->view("common/print_footer.php"); ?>   
    
</div><!--print-start-->   

 </body>



