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
            <p>Supplier Report</p>
            


<div class="table-responsive">

<table class="table table-bordered table-hover table-striped print-table order-table">
<thead>
<tr class="report_view_th">
<th class="col-sm-1 text-center">No</th>
<th class="col-sm-2 text-center">Code</th>
<th class="col-sm-4 text-center">Company Name</th>
<th class="text-center">Phone</th>
<th class="text-center">Email</th> 

</tr>
</thead>
<tbody>
 <?php 
 $tmpcount=0;
  foreach ($suppliers_list as $row)
 {
	 $tmpcount++;
 ?>  
<tr>
<td style="text-align:right; width:40px; vertical-align:middle;"><?php echo sprintf("%04d",$tmpcount); ?></td>
<td style="vertical-align:middle;">
 <?php echo $row['supp_code']; ?> </td>
<td style="text-align:left; vertical-align:middle;"><?php echo $row['supp_company_name']; ?></td>
<td><?php echo $row['supp_company_phone']; ?></td>
<td> <?php echo $row['supp_email']; ?></td>
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

