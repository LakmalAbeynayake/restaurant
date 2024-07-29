<?php $this->load->view("common/header"); ?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/fullcalendar/fullcalendar/fullcalendar.css">
<body>
<div class="container"> 
  <!-- start: PAGE HEADER -->
  <div class="row">
    <div class="col-sm-12"> 
      <!-- start: PAGE TITLE & BREADCRUMB --> 
      <!-- start: LOGO -->
      <?php $this->load->view("common/logo"); ?>
      <!-- end: LOGO -->
      <div class="page-header">
        <h1>Dashboard <small>overview &amp; stats </small></h1>
      </div>
      <!-- end: PAGE TITLE & BREADCRUMB --> 
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading"> <i class="fas fa-bell"></i> Notifications (<?php echo date("D-M-Y"); ?>) </div>
        <div id="container1" style="min-width: 300px; height: 200px; margin: 0 auto"></div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading"> <i class="fa fa-th"></i> Your Locations </div>
        <div class="panel-body panel-scroll" style="height:auto">
          <div class="col-sm-2"> <a href="<?php echo base_url('restaurant'); ?>">
            <button class="btn btn-icon btn-block"> <i class="fa fa-th-large fa-2x"></i> Restaurant <span class="badge badge-primary"> 4 </span> </button>
            </a> </div>
          <div class="col-sm-2"> <a href="<?php echo base_url('sales/add'); ?>">
            <button class="btn btn-icon btn-block"> <i class="fa fa-heart fa-2x"></i> Banquet <span class="badge badge-primary"> 4 </span> </button>
            </a> </div>
          <div class="col-sm-2"> <a href="<?php echo base_url('customers'); ?>">
            <button class="btn btn-icon btn-block"> <i class="fas fa-person-booth fa-2x"></i> Room Posting <span class="badge badge-primary"> 4 </span> </button>
            </a> </div>
          <div class="col-sm-2"> <a href="<?php echo base_url('suppliers'); ?>">
            <button class="btn btn-icon btn-block"> <i class="fa fa-shopping-cart fa-2x"></i> Food Orer <span class="badge badge-primary"> 4 </span> </button>
            </a> </div>
          <div class="col-sm-2"> <a href="<?php echo base_url('users'); ?>">
            <button class="btn btn-icon btn-block"> <i class="fa fa-user fa-2x"></i> Guest Information <span class="badge badge-primary"> 4 </span> </button>
            </a> </div>
          <div class="col-sm-2"> <a href="<?php echo base_url('dashboard'); ?>">
            <button class="btn btn-icon btn-block"> <i class="fa fa-2x fa-building"></i> Back Office <span class="badge badge-primary"> 0 </span> </button>
            </a> </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <?php //print_r($last_5_sales_list);?>
      <?php /*?><div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-tasks"></i>
									 Latest Five
								</div>
								<div class="panel-body panel-scroll" style="height:auto">
									<div class="tabbable tabs-top">
												<ul class="nav nav-tabs tab-green" id="myTab3">
													<li class="active">
														<a data-toggle="tab" href="#Sales">
															Sales
														</a>
													</li>
													
													<li class="">
														<a data-toggle="tab" href="#Grn">
															GRN
														</a>
													</li>
													
												</ul>
												<div class="tab-content">
													<div id="Sales" class="tab-pane active">
														<div class="table-responsive">
															<table class="table table-bordered table-hover" id="sample-table-1">
																<thead>
																	<tr>
																		
																		<th>Date</th>
																		<th>Invoice No</th>
																		<th>Customer</th>
																		<th>Grand Total</th>
																		<th>Paid</th>
																		<th>Balance</th>
																		<th>Payment Status</th>
																	</tr>
																</thead>
																<tbody>
                                                                <?php 
																foreach ($last_5_sales_list as $row){
																
																		 $total_paid_amount=$row['total_paid_amount'];
																		 if (empty($total_paid_amount)) {
																			 $pay_st = '<span class="label label-warning">Pending</span>';
																			}else{
																			  if ($total_paid_amount >= $row['sale_total']) {
																				$pay_st = '<span class="label label-success">Paid</span>';
																			  }else{
																				$pay_st = '<span class="label label-info">Partial</span>';
																			  }
																			}	
																	
																	?>
																	<tr>
																		
																		<td><?php echo display_date_time_format($row['sale_datetime']); ?></td>
																		<td><?php echo $row['sale_reference_no']; ?></td>
																		<td><?php echo $row['cus_name']; ?></td>
																		<td> <?php echo number_format($row['sale_total'], 2, '.', ','); ?></td>
																		<td><?php echo number_format($total_paid_amount, 2, '.', ','); ?></td>
																		<td><?php echo number_format($row['sale_total']-$total_paid_amount, 2, '.', ','); ?></td>
																		<td><?php echo $pay_st; ?></td>
																	</tr>
                                                                    <?php }?>
																																		
																</tbody>
															</table>
														</div>

													</div>
													<div id="Grn" class="tab-pane">
													<div class="table-responsive">
															<table class="table table-bordered table-hover" id="sample-table-1">
																<thead>
																	<tr>
																		
																		<th>Date</th>
																		<th>Reference No</th>
																		<th>Supplier</th>
																		<th>Grand Total</th>
																		<th>Paid</th>
																		<th>Balance</th>
																		<th>Payment Status</th>
																	</tr>
																</thead>
																<tbody>
                                                                <?php 
																foreach ($last_5_grn_list as $row){
																
																		 $total_paid_amount=$row['grn_total_paid'];
																		 if (empty($total_paid_amount)) {
																			 $pay_st = '<span class="label label-warning">Pending</span>';
																			}else{
																			  if ($total_paid_amount >= $row['grand_total']) {
																				$pay_st = '<span class="label label-success">Paid</span>';
																			  }else{
																				$pay_st = '<span class="label label-info">Partial</span>';
																			  }
																			}	
																	
																	?>
																	<tr>
																		
																		<td><?php echo display_date_time_format($row['date']); ?></td>
																		<td><?php echo $row['reference_no']; ?></td>
																		<td><?php echo $row['supp_company_name']; ?></td>
																		<td> <?php echo number_format($row['grand_total'], 2, '.', ','); ?></td>
																		<td><?php echo number_format($total_paid_amount, 2, '.', ','); ?></td>
																		<td><?php echo number_format($row['grand_total']-$total_paid_amount, 2, '.', ','); ?></td>
																		<td><?php echo $pay_st; ?></td>
																	</tr>
                                                                    <?php }?>
																																		
																</tbody>
															</table>
														</div>
													</div>
													<div id="Purchases" class="tab-pane">
													3
													</div>
													<div id="Customers" class="tab-pane">
													4
													</div>
													<div id="Suppliers" class="tab-pane">
													5
													</div>
												</div>
											</div>
									</div>
							</div>
						</div><?php */?>
      <div class="row">
        <div class="col-sm-6">
          <div class="panel panel-default">
            <div class="panel-heading"> <i class="fa fa-bar-chart-o"></i> Best Sales (<?php echo date("M-Y",strtotime("-1 month")) ?>) </div>
            <div id="container2" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="panel panel-default">
            <div class="panel-heading"> <i class="fa fa-bar-chart-o"></i> Best Sales (<?php echo date("M-Y",strtotime("-2 month")) ?>) </div>
            <div id="container3" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
          </div>
        </div>
      </div>
      <!-- end: PAGE CONTENT--> 
    </div>
  </div>
  <!-- end: PAGE --> 
</div>
<!-- end: MAIN CONTAINER --> 
<!-- start: FOOTER --><!-- end: FOOTER --> 
<!-- start: RIGHT SIDEBAR --><!-- end: RIGHT SIDEBAR -->
<div id="event-management" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
        <h4 class="modal-title">Event Management</h4>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-light-grey"> Close </button>
        <button type="button" class="btn btn-danger remove-event no-display"> <i class='fa fa-trash-o'></i> Delete Event </button>
        <button type='submit' class='btn btn-success save-event'> <i class='fa fa-check'></i> Save </button>
      </div>
    </div>
  </div>
</div>
<!-- start: MAIN JAVASCRIPTS -->
<?php $this->load->view("common/footer"); ?>
<!-- end: MAIN JAVASCRIPTS --> 
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> 
<script src="<?php echo asset_url(); ?>plugins/jquery.sparkline/jquery.sparkline.js"></script> 
<script src="<?php echo asset_url(); ?>plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script> 
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<?php 

//echo "<pre>"; print_r($current_month_best_sales);
//echo date("m",strtotime("-1 month"));
?>
<script src="<?php echo asset_url(); ?>js/highcharts.js"></script> 
<script type="text/javascript">
				$(function () {
           $('#container1').highcharts({
                chart: {type: 'column'},
                title: {text: ''},
                credits: {enabled: false},
                xAxis: {type: 'category', labels: {rotation: -60, style: {fontSize: '13px'}}},
                yAxis: {min: 0, title: {text: ''}},
                legend: {enabled: false},
                series: [{
                    name: 'Sold',
                    data: [
					<?php foreach ($current_month_best_sales as $key => $bestsales) {
						$p_name=preg_replace("/[^a-zA-Z]/", "",$bestsales->product_name);
						?>
					  ['(<?php echo $bestsales->product_code; ?>) <?php echo $p_name ?> ',<?php echo $bestsales->fi_qty_tot; ?>],
					<?php }?>
										
					],
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#000',
                        align: 'right',
                        y: -25,
                        style: {fontSize: '12px'}
                    }
                }]
            });
           $('#container2').highcharts({
                chart: {type: 'column'},
                title: {text: ''},
                credits: {enabled: false},
                xAxis: {type: 'category', labels: {rotation: -60, style: {fontSize: '13px'}}},
                yAxis: {min: 0, title: {text: ''}},
                legend: {enabled: false},
                series: [{
                    name: 'Sold',
                    data: [
					<?php foreach ($last_month_best_sales as $key => $bestsales) { $p_name=preg_replace("/[^a-zA-Z]/", "",$bestsales->product_name);?>
					['(<?php echo $bestsales->product_code; ?>)<?php echo $p_name; ?> <?php if ($bestsales->product_part_no) echo ", Part No: $bestsales->product_part_no"; ?> <?php if ($bestsales->product_oem_part_number) echo ", OEM Part No: $bestsales->product_oem_part_number"; ?>', <?php echo $bestsales->fi_qty_tot; ?>],
					<?php }?>
					],
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#000',
                        align: 'right',
                        y: -25,
                        style: {fontSize: '12px'}
                    }
                }]
            });
			
			
           $('#container3').highcharts({
                chart: {type: 'column'},
                title: {text: ''},
                credits: {enabled: false},
                xAxis: {type: 'category', labels: {rotation: -60, style: {fontSize: '13px'}}},
                yAxis: {min: 0, title: {text: ''}},
                legend: {enabled: false},
                series: [{
                    name: 'Sold',
                    data: [<?php foreach ($last_2_month_best_sales as $key => $bestsales) { $p_name=preg_replace("/[^a-zA-Z]/", "",$bestsales->product_name);?>
					['(<?php echo $bestsales->product_code; ?>) <?php echo $p_name; ?> <?php if ($bestsales->product_part_no) echo ", Part No: $bestsales->product_part_no"; ?> <?php if ($bestsales->product_oem_part_number) echo ", OEM Part No: $bestsales->product_oem_part_number"; ?>', <?php echo $bestsales->fi_qty_tot; ?>],
					<?php }?>],
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#000',
                        align: 'right',
                        y: -25,
                        style: {fontSize: '12px'}
                    }
                }]
            });
			
					});
					
					$('#pos_mode').click(function(){
						$('body').modalmanager('loading');
	});
		</script>
</body>
<!-- end: BODY -->
</html>