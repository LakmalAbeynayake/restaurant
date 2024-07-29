<style type="text/css">
.fa-3x {
  font-size: 2em !important;
}
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
</style>
		
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
									<a href="<?php echo base_url('orders'); ?>">
										 orders 
									</a>
								</li>
                               
								<li class="active">
									View
								</li>
								<li class="search-box">
									<form class="sidebar-search">
										<div class="form-group">
											<input type="text" placeholder="Start Searching...">
											<button class="submit">
												<i class="clip-search-3"></i>
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
									Proceed Order Number <?php print_r($proceed_order_details[0]['proceed_id']); ?>
									<div class="panel-tools" style="top:2px;">
												<button class="btn btn-blue dropdown-toggle" data-toggle="dropdown">
													<i class="clip-list-5"></i> 
												</button>
												<ul class="dropdown-menu dropdown-light pull-right">
														<li>
															<a id="" data-toggle="modal" href="<?php echo base_url('orders/add'); ?>">
																<i class="fa fa-plus"></i> Add orders
															</a>
														</li>
														
													</ul>
									</div> <!--panel-tools-->
								</div> <!--panel-heading-->
								<div class="panel-body">
									 
<div class="well well-sm">                      

<div class="col-xs-4 border-right">
<div class="col-xs-2"><i class="fa fa-3x fa-file-text-o padding010 text-muted"></i></div>
<div class="col-xs-10">
<h4 class="">Proceed Order Refference No : <?php print_r($proceed_order_details[0]['proceed_ref_no']);?></h4>
<p>Date: <?php echo date('Y:m:d')?></p>
<?php 
$obj = new Proceed_Order_Model();
//$total_paid_amount=$this->Order_Model->get_total_paid_by_order_id($order_id);
/*if (empty($total_paid_amount)) {
		  $pay_st = 'Pending';
		}else{
		  if ($total_paid_amount >= $order_details['order_total']) {
			$pay_st = 'Paid';
		  }else{
			$pay_st = 'Partial';
		  }
		}*/
?>
<!--<p>orders Terms: <?php  ?></p>-->
<?php /*?><p>Payment Status : <?php echo $pay_st ?></p>
<?php */?></div>
<div class="clearfix"></div>
</div>


<!--<div class="col-xs-4">
<div class="col-xs-2"><i class="fa fa-3x fa-building-o padding010 text-muted"></i></div>
<div class="col-xs-10">
<h4 class=""><?php /*echo $warehouse_details['name'];*/ ?></h4>

<?php /* echo $warehouse_details['address'];*/ ?><p></p>
Tel: <?php /*echo $warehouse_details['phone'];*/ ?><br>
Email: <?php /*echo $warehouse_details['email'];*/ ?> </div>-->

<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div> <!--col-xs-4-->



<div class="col-xs-5">
<input name="order_id" type="hidden" id="order_id" value="<? echo $proceed_order_details['proceed_id']; ?>">
<input type="hidden" id="order_type" name="order_type" value="order">



<div class="clearfix"></div>
</div> <!--col-xs-4"-->
<div class="clearfix"></div>






<div class="table-responsive">
<table class="table table-bordered table-hover table-striped print-table order-table">
<thead>
<tr class="report_view_th">
<th>No</th>
<th>Product Name (Code)</th>
<th>Quantity</th>
<!--<th>price</th>-->
<!--<th style="text-align:center; vertical-align:middle;">Amount</th>-->
<th style="padding-right:20px;">Date</th>

</tr>
</thead>
<tbody>
 <?php 
 $tmpcount=0;
 $tmptot=0;
 $tamount=0;
  foreach ($get_product as $row)
 {
	 $price=$row['po_item_quantity']*$row['product_price'];

	 $tmptot=$tmptot+$tmpcount;
	// $tmptot=$tmptot+$row['gross_total'];
	$tmpcount++;
 ?>  
<tr>
<td style="text-align:center; width:40px; vertical-align:middle;"><?php echo $tmpcount ?></td>
<td style="vertical-align:middle;"><?php echo $row['product_name']; ?> (<?php echo $row['product_code']; ?>)
<?php if ($row['product_part_no']) echo ", Part No.:".$row['product_part_no']; ?>
<?php if ($row['product_oem_part_number']) echo ", OEM Part No.:".$row['product_oem_part_number']; ?>

</td>
<td style="width: 100px; text-align:center; vertical-align:middle;"><?php echo number_format($row['po_item_quantity'], 2, '.', ',') ?></td>
<!--<td><?php echo $row['product_price']?></td>-->
<!--<td><?php echo $price?></td>-->
<td><?php echo $row['proceed_datetime_submit']?></td>

</tr>
<?php }?>
</tbody>
<tfoot>
<tr>
 <!-- <td style="text-align:right; padding-right:10px;" colspan="5">Order Discount</td>-->
  
<!--  <td style="text-align:right; padding-right:10px;"><?php /*echo number_format($order_details['order_inv_discount_amount'], 2, '.', ',')*/ ?></td>-->
</tr>
<tr>
<!--<td style="text-align:right; padding-right:10px;" colspan="5">Total Amount </td>
<td style="text-align:right; padding-right:10px;"><input type="hidden" value="<?php /*echo $order_details['order_total']*/?>" id="total_paymnt_tmp">-->

 <?php /* echo number_format($order_details['order_total'], 2, '.', ',') */?>
  </td>
 
</tr>



</tfoot>
</table>
</div> <!--table-responsive-->



<div class="clearfix"></div>
<p></p>
<div class="well well-sm col-xs-6 pull-right">                      


<div class="col-xs-10">
<p>
<?php //echo $tmptot;?><br>

Created by : <?php echo $this->session->userdata('ss_user_first_name'); ?> (<?php echo $this->session->userdata('ss_user_group_name'); ?>) </p>

<p>Date:<?php echo $row['proceed_datetime_create']?></p>

<p>Approved by:<?php ?></p>
 </div>
<div class="clearfix"></div>

<div class="clearfix"></div>
</div> <!--well well-sm col-xs-6 pull-right-->


<!-- payment list -->
<div class="clearfix"></div>
<br>
<div class="clearfix"></div>
<!-- end payment list-->



<div class="buttons">
<div class="btn-group btn-group-justified">


<div class="btn-group"><a title="" class="tip btn btn-primary tip" data-target="#myModal" data-toggle="modal" href="#" data-original-title="Add Payment" id="modal_ajax_orders_payment_btn"><i class="fa fa-money"></i> <span class="hidden-sm hidden-xs">Add Payment</span></a></div>

<!--<div class="btn-group"><a title="" class="tip btn btn-primary tip" data-target="#myModal" data-toggle="modal" href="http://sma.tecdiary.org/orders/add_payment/2" data-original-title="Add Payment"><i class="fa fa-money"></i> <span class="hidden-sm hidden-xs">View Payment</span></a></div>-->
<!--<div class="btn-group"><a title="" class="tip btn btn-primary tip" data-target="#myModal" data-toggle="modal" href="http://sma.tecdiary.org/orders/add_delivery/2" data-original-title="Add Delivery"><i class="fa fa-truck"></i> <span class="hidden-sm hidden-xs">Add Delivery</span></a></div>-->

<div class="btn-group" onClick="fbs_click(<?php /* echo $proceed_order_details['proceed_id'];*/ ?>)"><a title="" class="tip btn btn-primary" data-original-title="Print"><i class="fa fa-print"></i> <span class="hidden-sm hidden-xs">Print</span></a>
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
				2014 &copy; clip-one by cliptheme.
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
		<script>
			jQuery(document).ready(function() {
				TableData.init();
				//Main.init();
				//TableData.init();
				//UIModals.init();

			});
		</script>
        
<script type="text/javascript" language="javascript" >




var j = jQuery.noConflict();
function loadGrid(){
	alert();
	j('#employee-grid').DataTable().ajax.reload();
}
	jQuery(document).ready(function() {
		var dataTable = j('#employee-grid').DataTable( {
			"processing": true,
			"serverSide": true,
			"ajax":{
				url :"orders/list_orders", // json datasource
				type: "post",  // method  , by default get
				error: function(){  // error handling
					j(".employee-grid-error").html("");
					j("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					//$("#employee-grid_processing").css("display","none");
				}
			}
		} );
		
	} );
	
	function test1(){
		alert();
	}
	

function fbs_click(id) {
	u=location.href;
	t=document.title;
	window.open('<?php echo base_url() ?>sales/sales_details?sales_id='+id,'sharer','toolbar=0,status=0,width=700,height=700, left=10, top=10,scrollbars=yes');return false;
}



</script>
	</body>
	<!-- end: BODY -->
</html>