<?php $this->load->view("common/header"); ?>
<!-- end: HEAD -->
<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/fullcalendar/fullcalendar/fullcalendar.css">
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- end: HEAD -->
<!-- start: BODY -->

<body>
    <!-- start: HEADER -->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <!-- start: TOP NAVIGATION CONTAINER -->
        <div class="container">
            <div class="navbar-header">
                <!-- start: RESPONSIVE MENU TOGGLER -->
                <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                    <span class="clip-list-2"></span>
                </button>
                <!-- end: RESPONSIVE MENU TOGGLER -->
                <!-- start: LOGO -->
                <?php $this->load->view("common/logo"); ?>
                <!-- end: LOGO -->
            </div>
            <div class="navbar-tools">
                <!-- start: TOP NAVIGATION MENU -->
                <?php $this->load->view("common/notifications.php"); ?>
                <!-- end: TOP NAVIGATION MENU -->
            </div>
        </div>
        <!-- end: TOP NAVIGATION CONTAINER -->
    </div>
    <!-- end: HEADER -->
    <!-- start: MAIN CONTAINER -->
    <div class="main-container">
        <div class="navbar-content">
            <!-- start: SIDEBAR -->
            <?php $this->load->view("common/navigation"); ?>
            <!-- end: SIDEBAR -->
        </div>
        <!-- start: PAGE -->
        <div class="main-content">
            <!-- start: PANEL CONFIGURATION MODAL FORM -->
            <div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title">Panel Configuration</h4>
                        </div>
                        <div class="modal-body">
                            Here will be a configuration form
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Close
                            </button>
                            <button type="button" class="btn btn-primary">
                                Save changes
                            </button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!-- end: SPANEL CONFIGURATION MODAL FORM -->
            <div class="container">
                <!-- start: PAGE HEADER -->
                <div class="row">
                    <div class="col-sm-12">
                        <!-- start: PAGE TITLE & BREADCRUMB -->
                        <ol class="breadcrumb">
                            <li>
                                <i class="clip-home-3"></i>
                                <a href="#">
                                    Home
                                </a>
                            </li>
                            <li class="active">
                                Dashboard
                            </li>
                            <li class="search-box">
                                <form class="sidebar-search">
                                    <div class="form-group">
                                        <input type="text" placeholder="Start Searching...">
                                        <button class="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </li>
                        </ol>
                        <div class="page-header">
                            <h1>Dashboard <small>overview &amp; stats </small></h1>
                        </div>
                        <!-- end: PAGE TITLE & BREADCRUMB -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-th"></i>
                                Screens
                            </div>
                            <div class="panel-body panel-scroll" style="height:auto">
                                <div class="col-sm-2">
                                    
                                    <?php if($this->session->userdata('ss_warehouse_type') == 'outlet'){ ?>
                                    <a target="_blank" href="<?php echo base_url('posplus/app'); ?>"><button class="btn btn-icon btn-block">
                                            <i class="fa fa-th-large"></i>
                                            POS PLUS
                                            <!--<span class="badge badge-primary"> 4 </span>-->
                                        </button></a>
                                    <?php }?>
                                </div>
                            <div class="col-sm-2">
                                    <a target="_blank" href="<?php echo base_url('kitchen/index'); echo "/".$this->session->userdata('ss_warehouse_id') ?>">
                                        <button class="btn btn-icon btn-block" style="text-wrap: pretty;">
                                            <i class="fa fa-shopping-cart"></i>
                                            KITCHEN SCREEN
                                            <!--<span class="badge badge-primary"> 4 </span>-->
                                   <!--     </button></a>
                                </div>
                                <div class="col-sm-2">
                                    <a target="_blank" href="<?php echo base_url('self_print/sales_print'); ?>">
                                        <button class="btn btn-icon btn-block">
                                            <i class="fa fa-shopping-cart"></i>
                                            PRINTING SCREEN
                                            <!--<span class="badge badge-primary"> 4 </span>-->
                                        </button>
                                    </a>
                                </div>
                                <div class="col-sm-2">
                                    <a target="_blank" href="<?php echo base_url('app_android/sales_print'); ?>">
                                        <button class="btn btn-icon btn-block" style="text-wrap: pretty;">
                                            <i class="fa fa-shopping-cart"></i>
                                            PRINTING SCREEN 2
                                            <!--<span class="badge badge-primary"> 4 </span>-->
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <!-- <h1 style="color:red;text-align: center">Please use <strong>CTRL + F5 </strong>Keys to  update new system settings </h1>
                             <h3 style="text-align: center">One Time To One PC</h3>-->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o"></i>
                                Best Sales (<?php echo date("M-Y"); ?>)
                            </div>
                            <div id="container1" style="min-width: 300px; height: 400px; margin: 0 auto">
                                
                                
                             
                                
                                
                                
                            </div>
                              
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default collapse">
                            <div class="panel-heading">
                                <i class="fa fa-th"></i>
                                Quick Links
                            </div>
                            <div class="panel-body panel-scroll" style="height:auto">
                                <div class="col-sm-2">
                                    <a href="<?php echo base_url('products'); ?>"><button class="btn btn-icon btn-block">
                                            <i class="fa fa-barcode"></i>
                                            Products <span class="badge badge-primary"> 4 </span>
                                        </button></a>
                                </div>
                                <div class="col-sm-2">
                                    <a href="<?php echo base_url('sales/add'); ?>">
                                        <button class="btn btn-icon btn-block">
                                            <i class="fa fa-shopping-cart"></i>
                                            Add Sales <span class="badge badge-primary"> 4 </span>
                                        </button></a>
                                </div>
                                <div class="col-sm-2">
                                    <a href="<?php echo base_url('customers'); ?>">
                                        <button class="btn btn-icon btn-block">
                                            <i class="fa fa-shopping-cart"></i>
                                            Customers <span class="badge badge-primary"> 4 </span>
                                        </button></a>
                                </div>
                                <div class="col-sm-2">
                                    <a href="<?php echo base_url('suppliers'); ?>">
                                        <button class="btn btn-icon btn-block">
                                            <i class="fa fa-shopping-cart"></i>
                                            Suppliers <span class="badge badge-primary"> 4 </span>
                                        </button></a>
                                </div>
                                <div class="col-sm-2">
                                    <a href="<?php echo base_url('users'); ?>">
                                        <button class="btn btn-icon btn-block">
                                            <i class="fa fa-shopping-cart"></i>
                                            Users <span class="badge badge-primary"> 4 </span>
                                        </button></a>
                                </div>
                                <div class="col-sm-2">
                                    <a href="<?php echo base_url('purchases'); ?>">
                                        <button class="btn btn-icon btn-block">
                                            <i class="fa fa-cogs"></i>
                                            GRN <span class="badge badge-primary"> 4 </span>
                                        </button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <?php //print_r($last_5_sales_list);
                        ?>
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
						</div><?php */ ?>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <i class="fa fa-bar-chart-o"></i>
                                        Best Sales (<?php echo date("M-Y", strtotime("-1 month")) ?>)
                                    </div>
                                    <div id="container2" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <i class="fa fa-bar-chart-o"></i>
                                        Best Sales (<?php echo date("M-Y", strtotime("-2 month")) ?>)
                                    </div>
                                    <div id="container3" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <pre>
                                <?php 
                                print_r($this->session->userdata['session_id']);
                                ?>
                            </pre>
                        </div>
                    </div>
                    <!-- end: PAGE CONTENT-->
                </div>
            </div>
            <!-- end: PAGE -->
        </div>
        <!-- end: MAIN CONTAINER -->
        <!-- start: FOOTER -->
        <!-- end: FOOTER -->
        <!-- start: RIGHT SIDEBAR -->
        <!-- end: RIGHT SIDEBAR -->
        <div id="event-management" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title">Event Management</h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-light-grey">
                            Close
                        </button>
                        <button type="button" class="btn btn-danger remove-event no-display">
                            <i class='fa fa-trash-o'></i> Delete Event
                        </button>
                        <button type='submit' class='btn btn-success save-event'>
                            <i class='fa fa-check'></i> Save
                        </button>
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
            /*$(function() {
                $('#container1').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: ''
                    },
                    credits: {
                        enabled: false
                    },
                    xAxis: {
                        type: 'category',
                        labels: {
                            rotation: -60,
                            style: {
                                fontSize: '13px'
                            }
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: ''
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    series: [{
                        name: 'Sold',
                        data: [
                            <?php foreach ($current_month_best_sales as $key => $bestsales) {
                                $p_name = preg_replace("/[^a-zA-Z]/", "", $bestsales->product_name);
                            ?>['(<?php echo $bestsales->product_code; ?>) <?php echo $p_name ?> ', <?php echo $bestsales->fi_qty_tot; ?>],
                            <?php } ?>

                        ],
                        dataLabels: {
                            enabled: true,
                            rotation: -90,
                            color: '#000',
                            align: 'right',
                            y: -25,
                            style: {
                                fontSize: '12px'
                            }
                        }
                    }]
                });
                $('#container2').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: ''
                    },
                    credits: {
                        enabled: false
                    },
                    xAxis: {
                        type: 'category',
                        labels: {
                            rotation: -60,
                            style: {
                                fontSize: '13px'
                            }
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: ''
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    series: [{
                        name: 'Sold',
                        data: [
                            <?php foreach ($last_month_best_sales as $key => $bestsales) {
                                $p_name = preg_replace("/[^a-zA-Z]/", "", $bestsales->product_name); ?>['(<?php echo $bestsales->product_code; ?>)<?php echo $p_name; ?> <?php if ($bestsales->product_part_no) echo ", Part No: $bestsales->product_part_no"; ?> <?php if ($bestsales->product_oem_part_number) echo ", OEM Part No: $bestsales->product_oem_part_number"; ?>', <?php echo $bestsales->fi_qty_tot; ?>],
                            <?php } ?>
                        ],
                        dataLabels: {
                            enabled: true,
                            rotation: -90,
                            color: '#000',
                            align: 'right',
                            y: -25,
                            style: {
                                fontSize: '12px'
                            }
                        }
                    }]
                });


                $('#container3').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: ''
                    },
                    credits: {
                        enabled: false
                    },
                    xAxis: {
                        type: 'category',
                        labels: {
                            rotation: -60,
                            style: {
                                fontSize: '13px'
                            }
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: ''
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    series: [{
                        name: 'Sold',
                        data: [<?php foreach ($last_2_month_best_sales as $key => $bestsales) {
                                    $p_name = preg_replace("/[^a-zA-Z]/", "", $bestsales->product_name); ?>['(<?php echo $bestsales->product_code; ?>) <?php echo $p_name; ?> <?php if ($bestsales->product_part_no) echo ", Part No: $bestsales->product_part_no"; ?> <?php if ($bestsales->product_oem_part_number) echo ", OEM Part No: $bestsales->product_oem_part_number"; ?>', <?php echo $bestsales->fi_qty_tot; ?>],
                            <?php } ?>
                        ],
                        dataLabels: {
                            enabled: true,
                            rotation: -90,
                            color: '#000',
                            align: 'right',
                            y: -25,
                            style: {
                                fontSize: '12px'
                            }
                        }
                    }]
                });

            });
*/
            $('#pos_mode').click(function() {
                $('body').modalmanager('loading');
            });
            
            
           // alert("Please use CTRL + F5 Keys to  update new system settings. One Time To One PC ");
        </script>

</body>
<!-- end: BODY -->

</html>