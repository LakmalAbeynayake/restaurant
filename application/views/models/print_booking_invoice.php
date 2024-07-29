
<!--onLoad="window.print()"-->
<body >
	<?php $this->load->view("common/header"); ?>
	<style type="text/css">
.report_view_th{
	color:#000 !important;
	font-size:12px;	
}

.table-responsive td{
	font-size:11px;
	background-color:#fff !important;	
}
h4{
	font-size:13px;
}
body{
	background-color:#fff !important;
}
</style>
		

<div class="">

         

         
            <div class="modal-body">

 <div style="top:2px;" class="panel-tools open">
<button data-toggle="dropdown" class="btn btn-blue dropdown-toggle" onClick="window.print()">
<i class="fa fa-print"></i>
</button>
</div>
<div class="row">
<div class="col-xs-12 text-center">

<div class="warehouse_name_print"><?php echo $booking_all_details[0]->name?></div>
<div><?php echo $booking_all_details[0]->address?> </div>
<div><?php echo $booking_all_details[0]->phone?> </div>
  
  </div><!--col-xs-12-->
</div><!--row-->  
 <br>


<div style="margin-bottom:15px;" class="row">

<div style="clear-both"></div>

<div class="col-xs-5 pull-left">
<?php //print_r($booking_all_details);?>
<br>
<h4 style="margin-top:10px;">Customer Details</h4>
<p>Name : <?php echo $customer_details['cus_name']; ?></p>
<p>Mobile:  <?php echo $customer_details['cus_mobile']; ?></p>
<p>Address : <?php echo $customer_details['cus_address']; ?></p>
</div>

<div class="col-xs-5 pull-right">
<?php //print_r($booking_all_details);?>
<h4 style="margin-top:10px;">Booking Details</h4>
<p>Booking ID: <?php echo $booking_all_details[0]->bkng_refno?></p>
<p>Date : <?php echo display_date_time_format($booking_all_details[0]->bkng_date)?></p>
<p>Time : <?php echo $booking_all_details[0]->bkng_time;?></p>
<p>Menu : <?php echo $booking_details->menu_name;?></p>
<p>Head Count : <?php echo $booking_all_details[0]->bkng_head_count;?></p>

<p></p>
</div>
</div>          


<!--Start Booking Menu Items-->
<legend> Menu Items</legend>
<div class="table-responsive">
<?php //print_r($booking_selected_menu_list);?>
<table class="table table-bordered table-hover table-striped print-table order-table">
<thead>
<tr class="report_view_th">
<th>No</th>
<th>Description</th>
</tr>
</thead>
<tbody>
 <?php 
 $tmpcount=0;
  foreach ($booking_selected_menu_list as $row)
 {
	if($row->bkng_itm_type=='' && $row->bkng_extra_item==''){ 
	 $tmpcount++;
 ?>  
<tr>
<td style="text-align:center; width:40px; vertical-align:middle;"><?php echo $tmpcount ?></td>
<td style="vertical-align:middle;"><?php echo $row->item_name; ?> (<?php echo $row->item_code; ?>)
  
  <?php if ($row->bkng_itm_type=='Extra') echo "/ (Extra)";?>
  <?php //if ($row['product_oem_part_number']) echo ", OEM Part No.:".$row['product_oem_part_number']; ?>
  
</td>
</tr>
<?php }
 } // End Menu Item Check
?>
</tbody>
<!--<tfoot>
<tr>
  <td style="text-align:right; padding-right:10px;" colspan="2"><strong> Total Amount </strong> <?php 
  echo number_format(($booking_all_details[0]->bkng_menu_amount), 2, '.', ',') ?>
  </td>
  </tr>
</tfoot>-->

</table>
</div> 
<!--table-responsive-->
<br>
<br>

<!--End Booking Menu Items-->


<!--Start Booking Extra Menu Items-->
<legend> Extra Menu Items</legend>
<div class="table-responsive">
<?php //print_r($booking_selected_menu_list);?>
<table class="table table-bordered table-hover table-striped print-table order-table">
<thead>
<tr class="report_view_th">
<th>No</th>
<th>Description</th>
<th style="padding-right:20px;">Amount</th>
</tr>
</thead>
<tbody>
 <?php 
 $tmpcount=0;
 $sub_total_extra_menu_items=0;
  foreach ($booking_selected_menu_list as $row)
 {
	 if($row->bkng_itm_type=='Extra' && $row->bkng_extra_item==''){ 
	 $sub_total_extra_menu_items+=$row->bkng_itm_price;
	 $tmpcount++;
 ?>  
<tr>
<td style="text-align:center; width:40px; vertical-align:middle;"><?php echo $tmpcount ?></td>
<td style="vertical-align:middle;"><?php echo $row->item_name; ?> (<?php echo $row->item_code; ?>)

  <?php if ($row->bkng_itm_type=='Extra') echo "/ (Extra)";?>
  <?php //if ($row['product_oem_part_number']) echo ", OEM Part No.:".$row['product_oem_part_number']; ?>
  
</td>
<td style="text-align:right; width:120px; padding-right:10px;"><?php echo number_format($row->bkng_itm_price, 2, '.', ',') ?></td>
</tr>
<?php }
 } // End Menu Item Check
 ?>
</tbody>
<tfoot>
<tr>
  <td style="text-align:right; padding-right:10px;" colspan="2"><strong>(No of Heds: <?php //echo $booking_all_details[0]->bkng_head_count; ?>) Total Amount </strong>
  </td>
  <td style="text-align:right; padding-right:10px;">
  <?php 
  //Multifly Head Count
  //$bkng_head_count=$booking_all_details[0]->bkng_head_count;
  //$sub_total_extra_menu_items=$sub_total_extra_menu_items*$bkng_head_count;
  //echo number_format(($sub_total_extra_menu_items), 2, '.', ',') ?>
  </td>
</tr>
</tfoot>
</table>
</div> <!--table-responsive-->
<!--End Booking Extra Menu Items-->

<br>
<br>

<!--Start Booking Extra Items-->
<legend> Extra Items</legend>
<div class="table-responsive">
<?php //print_r($booking_selected_menu_list);?>
<table class="table table-bordered table-hover table-striped print-table order-table">
<thead>
<tr class="report_view_th">
<th>No</th>
<th>Description</th>
<th style="padding-right:20px;">Amount</th>
<th style="padding-right:20px;">Quantity</th>
<th style="padding-right:20px;">Sub Total</th>
</tr>
</thead>
<tbody>
 <?php 
 $tmpcount=0;
 $sub_total_extra_items=0;
  foreach ($booking_selected_extra_item_list as $row)
 {
	 if($row->bkng_itm_type=='' && $row->bkng_extra_item=='Extra'){ 
	 $tmpcount++;
	 $sub_total_extra_items+=$row->tot_amount;
 ?>  
<tr>
<td style="text-align:center; width:40px; vertical-align:middle;"><?php echo $tmpcount ?></td>
<td style="vertical-align:middle;"><?php echo $row->item_name; ?> (<?php echo $row->item_code; ?>)

  <?php if ($row->bkng_itm_type=='Extra') echo "/ (Extra)";?>
  <?php //if ($row['product_oem_part_number']) echo ", OEM Part No.:".$row['product_oem_part_number']; ?>
  
</td>
<td style="text-align:right; width:120px; padding-right:10px;"><?php echo number_format($row->bkng_itm_price, 2, '.', ',') ?></td>
<td style="text-align:right; width:120px; padding-right:10px;"><?php echo number_format($row->bkng_itm_qty, 2, '.', ',') ?></td>
<td style="text-align:right; width:120px; padding-right:10px;"><?php echo number_format($row->tot_amount, 2, '.', ',') ?></td>
</tr>
<?php }
 } // End Menu Item Check
 ?>
</tbody>
<tfoot>
<tr>
  <td style="text-align:right; padding-right:10px;" colspan="4"><strong>Total Amount </strong>
  </td>
  
  <td style="text-align:right; padding-right:10px;"><?php echo number_format($sub_total_extra_items, 2, '.', ',') ?></td>
</tr>
</tfoot>
</table>
</div> 
<!--table-responsive-->
<!--End Booking Extra Items-->

<br>
<br>

<!--Start Booking Extra Menu Items-->
<legend class="well well-sm">  Discount & Payment Summary </legend>
<div class="table-responsive">
<?php //print_r($booking_selected_menu_list);?>
<table class="table table-bordered table-hover table-striped print-table order-table">
<thead>
<tr class="report_view_th">
<th>Description</th>
<th style="padding-right:20px;">Amount</th>
</tr>
</thead>
<tbody>
 
<tr>
<td style="vertical-align:middle;">Menu Amount
</td>
<td style="text-align:right; width:120px; padding-right:10px;">
<?php echo number_format(($booking_all_details[0]->bkng_menu_amount), 2, '.', ',') ?>
</td>
</tr>

<tr>
<td style="vertical-align:middle;">Extra Menu Items
</td>
<td style="text-align:right; width:120px; padding-right:10px;"><?php echo number_format(($sub_total_extra_menu_items), 2, '.', ',')?>
</td>
</tr>

<tr>
<td style="vertical-align:middle;">Extra Items
</td>
<td style="text-align:right; width:120px; padding-right:10px;"><?php echo number_format($sub_total_extra_items, 2, '.', ',') ?>
</td>
</tr>

</tbody>
<tfoot>
<tr>
  <td style="text-align:right; padding-right:10px;">Discount</td>
  <td style="text-align:right; padding-right:10px;"><?php echo number_format($booking_all_details[0]->bkng_discount_value, 2, '.', ',') ?></td>
</tr>
<tr>
  <td style="text-align:right; padding-right:10px;">Per Head Discount</td>
  <td style="text-align:right; padding-right:10px;"><?php echo number_format($booking_all_details[0]->bkng_per_head_discount_value, 2, '.', ',') ?></td>
</tr>
<tr>
  <td style="text-align:right; padding-right:10px;"><strong>Grand Total</strong>
  </td>
  <td style="text-align:right; padding-right:10px;">
  <strong>
  <?php 
  echo number_format($booking_all_details[0]->bkng_tot_amount, 2, '.', ',');
  ?></strong>

  
  </td>
</tr>
<tr>
  <td style="text-align:right; padding-right:10px;"><strong>Paid Amount</strong>
  </td>
  <td style="text-align:right; padding-right:10px;">
  
  </td>
</tr>
<tr>
  <td style="text-align:right; padding-right:10px;"><strong>Balance Amount</strong>
  </td>
  <td style="text-align:right; padding-right:10px;">
  
  </td>
</tr>
</tfoot>
</table>
</div> 
<!--table-responsive-->
<!--End Booking Extra Menu Items-->


<!-- payment list -->

<div class="row">
<div class="col-xs-12">
<div class="table-responsive">
<table class="table items table-striped table-bordered table-condensed table-hover">
<thead>
<tr class="report_view_th">
<th>Date</th>
<th>Payment Reference</th>
<th>Paid by</th>
<th>Amount</th>
<th>Created by</th>

</tr>
</thead>
<tbody>
<?php   foreach ($booking_payment_list as $row){?>
<tr>
<td><?php echo display_date_time_format($row->pymnt_date_time) ?></td>
<td><?php echo $row->pymnt_ref_no ?></td>
<td><?php echo $row->pymnt_paying_by ?></td>
<td><?php echo number_format($row->pymnt_amount, 2, '.', ',') ?></td>
<td> <?php echo $row->user_first_name ?> (<?php echo $row->user_group_name ?>)</td>

</tr>
<?php }?>
</tbody>
</table>
</div>
</div>
</div>
<div class="clearfix"></div>
<br>
<div class="clearfix"></div>
<!-- end payment list-->





<div class="row">
<div class="col-xs-12">
<div class="row">
 <br>
<br>

<div class="col-xs-12">
<div class="col-xs-4"> Prepared by: <br>
<br>
...................
<br>
<?php echo $user_details['user_first_name'];?>

</div> <!--col-xs-4-->

<div class="col-xs-4"> Authorized by: <br>
<br>
......................
<br>
</div> <!--col-xs-4-->

<div class="col-xs-4">Customer<br>
<br>
.............................
<br>
</div> <!--col-xs-4-->
   </div><!--col-xs-12-->
                
     <div class="row">
<p class="text-center">
<br>
<br>

Developed by: Sallelanka Solutions (pvt) Ltd.<br>
 Tel. +94777746654 WEB:www.sallelanka-solutions.com 
</p>
</div><!--row-->   
    
</div>
</div>

</div>

             
                 <!--/.col-md-12-->

</body>

