
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


  <?php $this->load->view("common/report_header.php"); ?>
  
   </div><!--col-xs-12-->
</div><!--row-->  



<div style="margin-bottom:15px;" class="row">

<div class="col-xs-12 pull-left">

<h4 style="margin-top:10px;">Report : GRN Report</h4>
<p>Supplier : <?php  ?></p>
<p>From Date : <?php  ?></p>
<p>To Date : <?php  ?></p>
</div>
</div>          


<div class="table-responsive">


<table class="table table-bordered table-hover table-striped print-table order-table">
<thead>
<tr class="report_view_th">
<th class="col-sm-1 text-center">No</th>
<th>Date</th>
<th>Reference No</th>
<th>Supplier</th>
<th>Payment Status</th>
<th>Grand Total</th>
<th>Paid</th>
<th>Balance</th>

</tr>
</thead>
<tbody>
 <?php 
 //print_r($sales_list);
 $tmpcount=0;
 $tot_grand_total=0;
 $tot_total_paid_amount=0;
 $tot_net_amount=0;
  foreach ($ingredient_item as $row)
 {
	 $tmpcount++;
	 $total_paid_amount=$row['grn_total_paid'];
	 $pay_st='';
	 if (empty($total_paid_amount)) {
		  $pay_st = 'Pending';
		  
		}else{
		  if ($total_paid_amount >= $row['grand_total']) {
			$pay_st = 'Paid';
		  }else{
			$pay_st = 'Partial';
		  }
		}
		
		if($srh_payment_status){
			if($srh_payment_status==$pay_st)
		{
		$tot_grand_total+=$row['grand_total'];
		$tot_total_paid_amount+=$total_paid_amount;
		$tot_net_amount+=$row['grand_total']-$total_paid_amount;
 ?>  
<tr>
<td style="text-align:right; width:40px; vertical-align:middle;"><?php echo sprintf("%04d",$tmpcount); ?></td>
<td style="vertical-align:middle;">
 <?php echo display_date_time_format($row['date']); ?> </td>
<td><?php echo $row['reference_no']; ?></td>
<td><?php echo $row['supp_company_name']; ?></td>
<td> <?php echo $pay_st; ?></td>
<td class="text-right"> <?php echo number_format($row['grand_total'], 2, '.', ','); ?></td>
<td class="text-right"> <?php echo number_format($total_paid_amount, 2, '.', ','); ?></td>
<td class="text-right"> <?php echo number_format($row['grand_total']-$total_paid_amount, 2, '.', ','); ?></td>

</tr>
<?php }} else {
	
	$tot_grand_total+=$row['grand_total'];
		$tot_total_paid_amount+=$total_paid_amount;
		$tot_net_amount+=$row['grand_total']-$total_paid_amount;
	?>
<tr>
<td style="text-align:right; width:40px; vertical-align:middle;"><?php echo sprintf("%04d",$tmpcount); ?></td>
<td style="vertical-align:middle;">
 <?php echo display_date_time_format($row['date']); ?> </td>
<td><?php echo $row['reference_no']; ?></td>
<td><?php echo $row['supp_company_name']; ?></td>
<td> <?php echo $pay_st; ?></td>
<td class="text-right"> <?php echo number_format($row['grand_total'], 2, '.', ','); ?></td>
<td class="text-right"> <?php echo number_format($total_paid_amount, 2, '.', ','); ?></td>
<td class="text-right"> <?php echo number_format($row['grand_total']-$total_paid_amount, 2, '.', ','); ?></td>

</tr>
<?php	
} }?>
<tr>
<td style="text-align:right; width:40px; vertical-align:middle;"></td>
<td style="vertical-align:middle;">
</td>
<td></td>
<td></td>
<td> </td>
<th class="text-right"> <?php echo number_format($tot_grand_total, 2, '.', ','); ?></th>
<th class="text-right"> <?php echo number_format( $tot_total_paid_amount, 2, '.', ','); ?></th>
<th class="text-right"> <?php echo number_format($tot_net_amount, 2, '.', ','); ?></th>

</tr>
</tbody>
<tfoot>

</tfoot>
</table>
<?php if (!count($ingredient_item)){
	echo 'No data available in table';
}?>
</div>




<div class="row">
<div class="col-xs-12">
</div>
<div class="col-xs-5 pull-right">
<div class="well-sm">
<p>
Created by:  <?php echo $this->session->userdata('ss_user_first_name'); ?> (<?php echo $this->session->userdata('ss_user_group_name'); ?>)</p> <p>
Date: <?php echo display_date_time_format(date("Y-m-d H:i:s")); ?> </p>
</div>
</div>
</div>

             
                 <!--/.col-md-12-->

</body>

