
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
	font-size:11px;
	
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
</style>
<!--https://css-tricks.com/almanac/properties/p/page-break/-->

<!--onLoad="window.print()-->
<body onLoad="window.print()">

     <?php $this->load->view("common/report_header.php"); ?>
  <div class="row">
  <div class="col-xs-12">
<div class="col-xs-6">
<h4>From:</h4>
<p><?php echo $warehouse_details['name']; ?> (<?php echo $warehouse_details['code']; ?>)</p>
<p><?php echo $warehouse_details['address']; ?></p>
<p>Tel: <?php echo $warehouse_details['phone']; ?></p>
</div>
<div class="col-xs-4 pull-right">
<h4>To:</h4>
<p><?php echo $to_warehouse_details['name']; ?> (<?php echo $warehouse_details['code']; ?>)</p>
<p><?php echo $warehouse_details['address']; ?></p>
<p>Tel: <?php echo $warehouse_details['phone']; ?></p>
</div>
</div>
</div>

<div class="print-start">


  

<table class="print-table" width="100%">
<thead>
<tr class="report_view_th">
  <th colspan="7" class="col-xs-1 text-right">
  <span style="float:right;">Reference No: <?php echo $trnsfr_details['trnsfr_reference_no']; ?></span>
  </th>
  </tr>
<tr class="report_view_th text-center">
<th class="col-xs-1">No</th>
<th class="col-xs-2">Description</th>
<th class="col-xs-1">Part No.</th>
<th class="col-xs-1">Quantity</th>
<th class="col-xs-1">Unit Price</th>

<th class="col-xs-2" align="center">Subtotal</th>
</tr>
</thead>
<tbody>
 <?php 
 $subtotal=0;
 $tmpcount=0;
  foreach ($trnsfr_item_list as $row)
 {
	 $tmpcount++;
	 $subtotal=$subtotal+$row['trnsfr_itm_quantity']*$row['trnsfr_itm_unit_price'];
	 
 ?>  
<tr>
<td style="text-align:center; width:40px; vertical-align:middle;"><?php echo $tmpcount ?></td>
<td style="vertical-align:middle;">
 <?php echo $row['product_name']; ?> (<?php echo $row['product_code']; ?>) <?php if ($row['product_oem_part_number']) echo ", OEM:".$row['product_oem_part_number']; ?></td>
<td style="vertical-align:middle;"><?php echo $row['product_part_no']; ?></td>
<td style="width: 80px; text-align:center; vertical-align:middle;"><?php echo number_format($row['trnsfr_itm_quantity'], 2, '.', ''); ?></td>
<td style="text-align:right; width:100px;"><?php echo number_format($row['trnsfr_itm_unit_price'], 2, '.', ','); ?></td>
<td style="text-align:right; width:120px;"><?php echo number_format($subtotal, 2, '.', ','); ?></td>
</tr>
<?php }?>


<tr>
<td style="text-align:right; font-weight:bold;" colspan="5">Total Amount 
</td>
<td style="text-align:right; padding-right:10px; font-weight:bold; border-top:1px solid #000; border-bottom:1px solid #000;"><?php echo number_format($trnsfr_details['trnsfr_total'], 2, '.', ',') ?></td>
</tr>

</tbody>
</table>
</div>



                 
 <div class="row">
 <br>
<br>

<div class="col-xs-12">
<div class="col-xs-5"> Prepared by:<?php echo $this->session->userdata('ss_user_first_name'); ?> (<?php echo $this->session->userdata('ss_user_group_name'); ?>) <br>
<br>
<br>
<br>
<br>

.............................
<br>
Stamp & Signature

</div> <!--col-xs-4-->



<div class="col-xs-5 pull-right">Received by: <br>
<br>
<br>
<br>
<br>

.............................
<br>
Stamp & Signature
</div> <!--col-xs-4-->
   </div><!--col-xs-12-->
 <div class="clear-both"></div>
 &nbsp;
<br>


                
     <?php $this->load->view("common/print_footer.php"); ?>   
    
</div><!--print-start-->   

 </body>



