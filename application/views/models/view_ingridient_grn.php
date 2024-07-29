
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

     <?php $this->load->view("common/ingrediants_header.php"); ?>
  <div class="row">
  <div class="col-xs-12">
<div class="col-xs-6">
 
<p>Ingredient Reference No: <?php   print_r($reference_no[0]['reference_no'])?></p>

</div>
<div class="col-xs-4 pull-right">
<p>Date: <?php  echo date('Y:m:d') ?></p>
</div>
</div>
</div>

<div class="print-start">

<?php //print_r($sale_details);?>
  

<table class="print-table" width="100%">
<thead>

<tr class="report_view_th text-center">
<th class="col-xs-1" width="20px"><br/>No</th>
<th class="col-xs-2"><br/>Date</th>
<th class="col-xs-1"><br/>Supplier</th>
<th class="col-xs-1"><br/>Grand Total</th>
<th class="col-xs-1"><br/>Discount</th>
<th class="col-xs-1"><br/>Balance</th> 
<!--<th class="col-xs-1" align="center">Proceed Order ref:<?php echo $sale_details['sale_reference_no']; ?> Subtotal</th>-->
</tr>
</thead>
<tbody>
 <?php 
 $tmpcount=0;
  foreach ($ingredient_item as $row)
 {
	 $tmpcount++;
	 $balance=$row['grand_total']-$row['discount_cal'];
 ?>  
<tr>
<td style="text-align:center; width:40px; vertical-align:middle;"><?php echo $tmpcount ?></td>
<td style="vertical-align:middle;">
  <?php  echo $row['date']?> </td>
<td style="width: 80px; text-align:center; vertical-align:middle;"><?php echo $row['supp_company_name']; ?></td>
<td style="width: 80px; text-align:center; vertical-align:middle;"><?php echo $row['grand_total']; ?></td>
<td style="width: 80px; text-align:center; vertical-align:middle;"><?php echo $row['discount_cal']; ?></td>
<td style="width: 80px; text-align:center; vertical-align:middle;"><?php echo $balance ?></td>

</tr>

<?php }?>


<?php
$Sales_Model = new Ingredient_Grn_Model();
?>
<?php //if ($sale_details['customer_id']!=1)
{ ?>
<?php  ?>


<?php }?>

</tbody>
</table>
</div>



                 
 <div class="row">
 <br>
<br>

<div class="col-xs-12">
<!--<div class="col-xs-4"> Prepared by: <br>-->

<br>


</div> <!--col-xs-4-->



<div class="col-xs-3 pull-right">Create<br><p> <?php echo $this->session->userdata('ss_user_first_name'); ?> (<?php echo $this->session->userdata('ss_user_group_name'); ?>)</p></p>


<br>
</div> <!--col-xs-4-->
   </div><!--col-xs-12-->
                
     <?php $this->load->view("common/print_footer.php"); ?>   
    
<!--</div><!--print-start-->   
<!--<?php /*if ($sale_type == "pos_sale")*/ { ?>
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

<?php } ?>-->
 </body>



