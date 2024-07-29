<style type="text/css">
.report_view_th{
	background-color:#428bca;
	color:#fff !important;
	font-size:14px;	
}
.table-responsive td{
	font-size:14px;	
}
h4{
	font-size:13px;
}
.fa-3x {
  font-size: 2em !important;
}
</style>
		 margin-right: 0;
				}
		</style>

	<?php $this->load->view("common/header"); ?>
	<!-- end: HEAD -->
       
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/select2/select2.css" />
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />
		<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/jQuery-Tags-Input/jquery.tagsinput.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/summernote/build/summernote.css">
          <link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/jquery.dataTables.css">
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
				<!-- end: SPANEL CONFIGURATION MODAL FORM -->
				<div class="container">
					<!-- start: PAGE HEADER -->
					<div class="row">
						<div class="col-sm-12">
							<!-- start: PAGE TITLE & BREADCRUMB -->
							<ol class="breadcrumb">
                            	<li>
									<a href="<?php echo base_url('dashboard'); ?>">
										 Dashboard 
									</a>
								</li>
								<li>
									<a href="<?php echo base_url('sales/sales_return'); ?>">
										 Sales Return
									</a>
								</li>
                               
								<li class="active">
									View Details: Reference Number <?php echo $sale_rtn_details['sl_rtn_reference_no']; ?>
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
                               <?php  
							   $message = $this->session->flashdata('message');
							   if($message){ ?>
                               	<div class="alert alert-success">
									<button type="button" class="close" data-dismiss="alert">×</button>
<?php echo $message ?> </div>
                               		
                               <?php
                               }
							    ?>
                               
                                 
							</div>

                            
						</div>
					</div>
					<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT 
                    <!-- start grid -->
                    <div class="row">
						<div class="col-md-12">
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Return Sale Number <?php echo $sl_rtn_id ?>
									<div class="panel-tools" style="top:2px;">
											
												
									</div> <!--panel-tools-->
								</div> <!--panel-heading-->
								<div class="panel-body">
									 
<div class="well well-sm">                      

<div class="col-xs-4 border-right">
<div class="col-xs-2"><i class="fa fa-3x fa-file-text-o padding010 text-muted"></i></div>
<div class="col-xs-10">
<h4 class="">Reference No : <?php echo $sale_rtn_details['sl_rtn_reference_no'];?></h4>
<p>Date: <?php echo display_date_time_format($sale_rtn_details['sl_rtn_datetime'])?></p>

</div>
<div class="clearfix"></div>
</div>

<div class="col-xs-4 border-right">
<div class="col-xs-2"><i class="fa fa-3x fa-user padding010 text-muted"></i></div>
<div class="col-xs-10">
<h4 class=""><?php echo $customer_details['cus_name']; ?></h4>
<?php echo $customer_details['cus_address']; ?><br>
<p></p>
Tel:  <?php echo $customer_details['cus_phone']; ?><br>
Email: <?php echo $customer_details['cus_email']; ?> </div>
<div class="clearfix"></div>
</div>

<div class="col-xs-4">
<div class="col-xs-2"><i class="fa fa-3x fa-building-o padding010 text-muted"></i></div>
<div class="col-xs-10">
<h4 class=""><?php echo $warehouse_details['name']; ?></h4>

<?php echo $warehouse_details['address']; ?><p></p>
Tel: <?php echo $warehouse_details['phone']; ?><br>
Email: <?php echo $warehouse_details['email']; ?> </div>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div> <!--col-xs-4-->



<div class="col-xs-5">
<input name="sale_id" type="hidden" id="sale_id" value="<?php echo $sl_rtn_id ?>">
<input type="hidden" id="sale_type" name="sale_type" value="sale">


<div class="clearfix"></div>
</div> <!--col-xs-4"-->
<div class="clearfix"></div>

<div class="table-responsive">
<table class="table table-bordered table-hover table-striped print-table order-table">
<thead>
<tr class="report_view_th">
<th>No</th>
<th>Description (Code)</th>
<th>Quantity</th>
<th style="text-align:center; vertical-align:middle;">Unite Price</th> <th style="padding-right:20px;">Discount</th>
<th style="padding-right:20px;">Subtotal</th>
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
<td style="vertical-align:middle;"><?php echo $row['product_name']; ?> (<?php echo $row['product_code']; ?>)
<?php if ($row['product_part_no']) echo ", Part No.:".$row['product_part_no']; ?>
<?php if ($row['product_oem_part_number']) echo ", OEM Part No.:".$row['product_oem_part_number']; ?>

</td>
<td style="width: 100px; text-align:center; vertical-align:middle;"><?php echo number_format($row['quantity'], 2, '.', ',') ?></td>
<td><?php echo number_format($row['unit_price'], 2, '.', ',') ?></td>
 <td style="text-align:right; width:120px; padding-right:10px;">(<?php echo $row['discount'] ?>) <?php echo number_format($row['discount_val'], 2, '.', ',') ?></td>
<td style="text-align:right; width:120px; padding-right:10px;"><?php echo $row['gross_total']; ?></td>
</tr>
<?php }?>
</tbody>
<tfoot>
<tr>
  <td style="text-align:right; padding-right:10px;" colspan="5">Order Discount</td>
  <td style="text-align:right; padding-right:10px;">(<?php echo $sale_rtn_details['sl_rtn_inv_discount'];?>) <?php echo number_format($sale_rtn_details['sl_rtn_inv_discount_amount'], 2, '.', ',') ?></td>
</tr>
<tr>
<td style="text-align:right; padding-right:10px;" colspan="5">Total Amount 
</td>
<td style="text-align:right; padding-right:10px;"><?php echo number_format($sale_rtn_details['sls_rtn_total_paid'], 2, '.', ',') ?></td>
</tr>

</tfoot>
</table>
</div> <!--table-responsive-->



<div class="clearfix"></div>
<p></p>
<div class="well well-sm col-xs-6 pull-right">                      


<div class="col-xs-10">
<p>Created by : <?php echo $this->session->userdata('ss_user_first_name'); ?> (<?php echo $this->session->userdata('ss_user_group_name'); ?>) </p>

<p>Date:<?php echo display_date_time_format($sale_rtn_details['sl_rtn_datetime_created'])?></p>
 </div>
<div class="clearfix"></div>

<div class="clearfix"></div>
</div> <!--well well-sm col-xs-6 pull-right-->


<div class="buttons">
<div class="btn-group btn-group-justified">


<div class="btn-group" onClick="print_sales_return(<?php echo $sl_rtn_id; ?>)"><a title="" class="tip btn btn-primary" data-original-title="Print"><i class="fa fa-print"></i> <span class="hidden-sm hidden-xs">Print</span></a>
</div>
 
</div>
</div> <!--buttons-->
								</div> <!--panel-body-->
							</div><!--panel-->
							
						</div> <!--col-md-12-->
					</div> <!--row-->

					
                    <!-- end grid -->
                    
					
			</div>
			<!-- end: PAGE -->
		</div>
		<!-- end: MAIN CONTAINER -->
		<!-- start: FOOTER -->
		<div class="footer clearfix">
			<div class="footer-inner">
				2018 &copy; smartsalleepos.com
			</div>
			<div class="footer-items">
				<span class="go-top"><i class="clip-chevron-up"></i></span>
			</div>
		</div>
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

		<!-- start ajax model -->
		<div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
		<!-- end ajax model -->

		<!-- start: MAIN JAVASCRIPTS -->
		<?php $this->load->view("common/footer"); ?>
		<!-- end: MAIN JAVASCRIPTS -->

		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="<?php echo asset_url(); ?>plugins/jquery-inputlimiter/jquery.inputlimiter.1.3.1.min.js"></script>
		<script src="<?php echo asset_url(); ?>plugins/jquery.maskedinput/src/jquery.maskedinput.js"></script>
		<script type="text/javascript" src="<?php echo asset_url(); ?>plugins/bootbox/bootbox.min.js"></script>
		<script type="text/javascript" src="<?php echo asset_url(); ?>plugins/jquery-mockjax/jquery.mockjax.js"></script>
		<script type="text/javascript" src="<?php echo asset_url(); ?>plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="<?php echo asset_url(); ?>plugins/DataTables/media/js/DT_bootstrap.js"></script>
		<script src="<?php echo asset_url(); ?>js/table-data.js"></script>
		<script src="<?php echo asset_url(); ?>plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
		<script src="<?php echo asset_url(); ?>plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
		<script src="<?php echo asset_url(); ?>js/ui-modals.js"></script>
		<script src="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
		<script src="<?php echo asset_url(); ?>plugins/select2/select2.min.js"></script>
        
       <script src="<?php echo asset_url(); ?>plugins/jQuery-lib/2.0.3/jquery.min.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.js"></script>

		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->     
<script type="application/javascript">
function print_sales_return(id) {
	u=location.href;
	t=document.title;
	window.open('<?php echo base_url() ?>sales_return/invoice_print/'+id,'sharer','toolbar=0,status=0,width=700,height=700, left=10, top=10,scrollbars=yes');return false;
}
</script>
	</body>
	<!-- end: BODY -->
</html>