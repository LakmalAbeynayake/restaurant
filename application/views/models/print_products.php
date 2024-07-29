<div style="top:2px;" class="panel-tools open">
<button data-toggle="dropdown" class="btn btn-blue dropdown-toggle" onClick="window.print()">
<i class="fa fa-print"></i>
</button>
</div>

<body onLoad="window.print()">
	<?php $this->load->view("common/header"); ?>
	<style type="text/css">
.report_view_th{
	background-color:#428bca;
	color:#fff !important;
	font-size:12px;
	text-align:center;	
}
.table-responsive td{
	font-size:11px;	
}
h4{
	font-size:13px;
}
</style>
		

<div class="modal-header">

         

         
            <div class="modal-body">
            <p>Product Report</p>
            


<div class="table-responsive">

<table class="table table-bordered table-hover table-striped print-table order-table">
<thead>
<tr class="report_view_th">
<th class="text-center">No</th>
<th class="text-center">Product Code</th>
<th class="text-center">Product Name</th>
<th class="text-center">Purchased</th>
<th class="text-center">Sold</th>
<th class="text-center">Balance</th>
<th class="text-center">Profit and/or Loss</th>

</tr>
</thead>
<tbody>
 <?php 
 $tmpcount=0;
  foreach ($product_list as $products)
 {
	 $tmpcount++;
 ?>  
<tr>
<td style="text-align:right; width:40px; vertical-align:middle;"><?php echo sprintf("%04d",$tmpcount); ?></td>
<td style="vertical-align:middle;"><?php echo $products->product_code; ?> </td>
<td><?php echo $products->product_name; ?></td>
<td class="text-right"><?php echo "(".$products->product_cost.") "."0.00"; ?></td>
<td class="text-right"> <?php echo "(".$products->product_price.") "."0.00"; ?></td>
<td class="text-right"> <?php echo '' ?></td>
<td class="text-right"> <?php echo '' ?></td>
</tr>
<?php }?>
</tbody>
<tfoot>

</tfoot>
</table>
</div>

<div class="row">
<div class="col-xs-12">
</div>
<div class="col-xs-5 pull-right">
<div class="well well-sm">
<p>
Created by:  <?php echo $this->session->userdata('ss_user_first_name'); ?> (<?php echo $this->session->userdata('ss_user_group_name'); ?>)</p> <p>
Date: <?php echo display_date_time_format(date("Y-m-d H:i:s")); ?> </p>
</div>
</div>
</div>

             
                 <!--/.col-md-12-->

</body>

