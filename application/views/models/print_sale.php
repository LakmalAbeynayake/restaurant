
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

<h4 style="margin-top:10px;">Report : Sales Report</h4>
<p>Customer : <?php echo $srh_customer_name ?></p>
<p>Payment Status : <?php echo $srh_payment_status ?></p>
<p>From Date : <?php echo $srh_from_date_dis ?></p>
<p>To Date : <?php echo $srh_to_date_dis ?></p>
</div>
</div>          


<div class="table-responsive">


<table class="table table-bordered table-hover table-striped print-table order-table">
<thead>
<tr class="report_view_th">
<th class="col-sm-1 text-center">No</th>
<th>Date</th>
<th>Invoice No</th>
<th>Customer</th>
<th>Payment Status</th>

<th>Grand Total</th><th>Return</th>
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
 $return_grand_tot_amt=0;
 $sub_total_balance=0;
  $net_sub_total_balance=0;
   $ref_sale_model=new Sales_Model();
  foreach ($sales_list as $row)
 
 {
	 $tmpcount++;
	 
	 $total_paid_amount=$ref_sale_model->get_total_paid_by_sale_id($row['sale_id']);
	// $total_paid_amount=0;
	 
	 $return_tot_amt=0;
	 $sale_id=$row['sale_id'];
	 $ref_sales_rtn_mod=new Sales_Return_Model;
		$return_tot_amt=$ref_sales_rtn_mod->Sales_Return_Model->get_total_return_by_sale_id($sale_id);
		$return_grand_tot_amt=$return_grand_tot_amt+$return_tot_amt;
		
	 $pay_st='';
	 if (empty($total_paid_amount)) {
		  $pay_st = 'Pending';
		}else{
		  if ($total_paid_amount >= ($row['sale_total']-$return_tot_amt)) {
			$pay_st = 'Paid';
		  }else{
			$pay_st = 'Partial';
		  }
		}
		if($srh_payment_status){
			if($srh_payment_status==$pay_st)
		{
			
		$tot_grand_total+=$row['sale_total'];
		$tot_total_paid_amount+=$total_paid_amount;
		$sub_total_balance=$row['sale_total']-$total_paid_amount-$return_tot_amt;
		$tot_net_amount+=$sub_total_balance;
		
 ?>  
<tr>
<td style="text-align:right; width:40px; vertical-align:middle;"><?php echo sprintf("%04d",$tmpcount); ?></td>
<td style="vertical-align:middle;">
 <?php echo display_date_time_format($row['sale_datetime']); ?> </td>
<td><?php echo $row['sale_reference_no']; ?></td>
<td><?php echo $row['cus_name']; ?></td>
<td> <?php echo $pay_st; ?></td>
<td> <?php echo number_format($row['sale_total'], 2, '.', ','); ?></td>
<td> <?php echo number_format($return_tot_amt, 2, '.', ','); ?></td>
<td> <?php echo number_format($total_paid_amount, 2, '.', ','); ?></td>
<td> <?php echo number_format($sub_total_balance, 2, '.', ','); ?></td>

</tr>
<?php }}   else {
	$tot_grand_total+=$row['sale_total'];
		$tot_total_paid_amount+=$total_paid_amount;
		$sub_total_balance=$row['sale_total']-$total_paid_amount-$return_tot_amt;
		$tot_net_amount+=$sub_total_balance;
	?>
    <tr>
<td style="text-align:right; width:40px; vertical-align:middle;"><?php echo sprintf("%04d",$tmpcount); ?></td>
<td style="vertical-align:middle;">
 <?php echo display_date_time_format($row['sale_datetime']); ?> </td>
<td><?php echo $row['sale_reference_no']; ?></td>
<td><?php echo $row['cus_name']; ?></td>
<td> <?php echo $pay_st; ?></td>
<td> <?php echo number_format($row['sale_total'], 2, '.', ','); ?></td>
<td> <?php echo number_format($return_tot_amt, 2, '.', ','); ?></td>
<td> <?php echo number_format($total_paid_amount, 2, '.', ','); ?></td>
<td> <?php echo number_format($sub_total_balance, 2, '.', ','); ?></td>

</tr>
<?php } }?>
<tr>
<td style="text-align:right; width:40px; vertical-align:middle;"></td>
<td style="vertical-align:middle;">
</td>
<td></td>
<td></td>
<td> </td>
<th class="text-right"> <?php echo number_format($tot_grand_total, 2, '.', ','); ?></th>
<th> <?php echo number_format($return_grand_tot_amt, 2, '.', ','); ?></th>
<th class="text-right"> <?php echo number_format( $tot_total_paid_amount, 2, '.', ','); ?></th>
<th class="text-right"> <?php echo number_format($tot_net_amount, 2, '.', ','); ?></th>

</tr>
</tbody>
<tfoot>

</tfoot>
</table>
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

