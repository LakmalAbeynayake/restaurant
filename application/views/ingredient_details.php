	<?php $this->load->view("common/header"); ?>
	<!-- end: HEAD -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
        
          <link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/jquery.dataTables.css">

		<style type="text/css">
			.table > thead:first-child > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table-striped thead tr.primary:nth-child(2n+1) th {
			    background-color: #428bca;
			    border-color: #357ebd;
			    border-top: 1px solid #357ebd;
			    color: white;
			    text-align: center;
			}

		</style>
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
									<a href="#">
										 Purchases 
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
												<i class="fa fa-search"></i>
											</button>
										</div>
									</form>
								</li>
							</ol>
							<div class="page-header">
							</div>
						</div>
					</div>
					<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT 
                    <!-- start grid -->
                    <style type="text/css">
						                    	h2 {
						    font-size: 16px;
						    font-weight: bold;
						    line-height: 16px;
						}
                    </style>
                    <div class="row">
						<div class="col-md-12">
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								</div>
								<div class="panel-body">
									<div class="box-content">
									   <div class="row">
									      <div class="col-lg-12">
									         <div class="well well-sm">
									            <div class="col-xs-4 border-right">
									               <div class="col-xs-2"><i class="fa fa-3x fa-building padding010 text-muted"></i></div>
									               <div class="col-xs-10">
									               <?php //print_r($po_header) ?>
									               		<input type="hidden" id="sale_id" value="<?php echo $purchas_id; ?>">
									               		<input type="hidden" id="sale_type" value="ingredient_grn">
									                  <h2 class=""><?php echo $po_header[0]->supp_company_name; ?></h2>
									                  Supplier Address<br>
									                  <?php echo $po_header[0]->supp_address; ?>
									                  <p></p>
									                  Tel: <?php echo $po_header[0]->supp_contact_person_phone; ?>
									                  <br>Email: <?php echo $po_header[0]->supp_contact_person_email; ?>
									               </div>
									               <div class="clearfix"></div>
									            </div>
									            <div class="col-xs-4">
									               <div class="col-xs-2"><i class="fa fa-3x fa-truck padding010 text-muted"></i></div>
									               <div class="col-xs-10">
									                  <h2 class="">Stock Manager Advance</h2>
									                  <?php echo $po_header[0]->name; ?>
									                  <p><?php echo $po_header[0]->address; ?></p>
									               </div>
									               <div class="clearfix"></div>
									            </div>
									            <div class="col-xs-4 border-left">
									               <div class="col-xs-2"><i class="fa fa-3x fa-file-text-o padding010 text-muted"></i></div>
									               <div class="col-xs-10">
									                  <h2 class=""><?php echo $po_header[0]->reference_no; ?></h2>
									                  <p style="font-weight:bold;">Date: <?php echo $po_header[0]->date; ?></p>
									               </div>
									               <div class="clearfix"></div>
									            </div>
									            <div class="clearfix"></div>
									         </div>
                                  
									         <div class="table-responsive">
									            <table class="table table-bordered table-hover table-striped print-table order-table">
									               <thead>
									                  <tr>
									                     <th>No</th>
									                     <th>Description (Code)</th>
									                     <th>Quantity</th>
									                     <th style="padding-right:20px;">Unit Cost</th>
									                     <th style="padding-right:20px; text-align:center; vertical-align:middle;">Tax</th>
									                     <th style="padding-right:20px; text-align:center; vertical-align:middle;">Discount</th>
									                     <th style="padding-right:20px;">Subtotal</th>
									                  </tr>
									               </thead>
									               <tbody>
									               <?php foreach ($po_middle as $po_middle) { ?>
									                  <tr>
									                     <td style="text-align:center; width:40px; vertical-align:middle;">#</td>
									                     <td style="vertical-align:middle;"><?php echo $po_middle->product_name; ?> (<?php echo $po_middle->product_code; ?>) </td>
									                     <td style="width: 120px; text-align:center; vertical-align:middle;"><?php echo $po_middle->quantity; ?></td>
									                     <td style="text-align:right; width:120px; padding-right:10px;"><?php echo $po_middle->unit_price; ?></td>
									                     <td style="width: 120px; text-align:right; vertical-align:middle;">00.00</td>
									                     <td style="width: 120px; text-align:right; vertical-align:middle;"> <?php echo $po_middle->discount; ?></td>
									                     <td style="text-align:right; width:120px; padding-right:10px;"><?php echo $po_middle->sub_total; ?></td>
									                  </tr>
									                <?php } ?>

									               </tbody>
									               <tfoot>
									                  <tr>
									                     <td style="text-align:right; padding-right:10px; font-weight:bold;" colspan="6">
									                        Total Amount (LKR)
									                     </td>
									                     <td style="text-align:right; padding-right:10px; font-weight:bold;">
									                        <?php echo number_format($po_header[0]->total,2,'.',','); ?> 
									                     </td>
									                  </tr>
									                  <tr>
									                     <td style="text-align:right; padding-right:10px; font-weight:bold;" colspan="6">Discount</td>
									                     <td style="text-align:right; padding-right:10px; font-weight:bold;"><?php echo $po_header[0]->discount; ?></td>
									                  </tr>
									                  <tr>
									                     <td style="text-align:right; padding-right:10px; font-weight:bold;" colspan="6">Grand Total (LKR)</td>
									                     <td style="text-align:right; padding-right:10px; font-weight:bold;"><?php echo number_format($po_header[0]->grand_total,2,'.',','); ?>
   <input id="pur_grand_tot_amt" type="hidden" value="<?php echo $po_header[0]->grand_total;?>">                                                       
                                                         </td>
									                  </tr>
									                  <tr>
									                     <td style="text-align:right; padding-right:10px; font-weight:bold;" colspan="6">Paid (LKR)</td>
									                     <td style="text-align:right; padding-right:10px; font-weight:bold;">
														 <?php echo number_format($po_paid_total[0]->grn_paid_total,2,'.',','); ?>
                                                         <input id="pur_paid_amt" type="hidden" value="<?php echo $po_paid_total[0]->grn_paid_total;?>">
                                                         </td>
									                  </tr>
									                  <tr>
									                     <td style="text-align:right; padding-right:10px; font-weight:bold;" colspan="6">Balance (LKR)</td>

									                     <td style="text-align:right; padding-right:10px; font-weight:bold;">
									                     <?php 
									                     echo number_format($po_header[0]->grand_total - $po_paid_total[0]->grn_paid_total,2,'.',',');
									                     ?>
									                     </td>
									                  </tr>
									               </tfoot>
									            </table>
									         </div>
									         <div class="row">
									            <div class="col-xs-7"></div>
									         </div>
									      </div>
									   </div>
									   <div class="row">
									      <div class="col-xs-12">
									         <div class="table-responsive">
									            <table class="table table-bordered table-striped table-condensed">
									               <thead>
									                  <tr>
									                     <th>Date</th>
									                     <th>Payment Reference</th>
									                     <th>Paid by</th>
									                     <th>Amount</th>
									                     <th>Created by</th>
									                  </tr>
									               </thead>
									               <tbody>
									               <?php foreach ($po_payment as $key => $po_payment) {?>
									                  <tr>
									                     <td valign="top"><?php echo $po_payment->sale_pymnt_date_time; ?></td>
									                     <td valign="top">
														 <?php 
														 echo $po_payment->sale_pymnt_id;
														  if($po_payment->sale_pymnt_ref_no) echo "<br/>Ref.: ".$po_payment->sale_pymnt_ref_no;
														 if($po_payment->sale_pymnt_cheque_no) echo "<br/>Cheque No.: ".$po_payment->sale_pymnt_cheque_no;
														 if($po_payment->sale_pymnt_note) echo "<br/>Note: ".$po_payment->sale_pymnt_note;
														 
														 ?>
                                                         </td>
									                     <td valign="top"><?php echo $po_payment->sale_pymnt_paying_by;?></td>
									                     <td valign="top">LKR <?php echo number_format($po_payment->sale_pymnt_amount,2,'.',',');?></td>
									                     <td valign="top">Owner</td>
									                  </tr>
									               <?php } ?>
									               </tbody>
									            </table>
									         </div>
									      </div>
									   </div>
									   <div class="buttons">
									      <div class="btn-group btn-group-justified">
									         <div class="btn-group"><a data-toggle="modal" data-target="#myModal" title="" class="tip btn btn-primary tip" href="#" id="modal_ajax_sales_payment_btn" data-original-title="Add Payment"><i class="fa fa-money"></i>
									            <span class="hidden-sm hidden-xs">Add Payment</span></a>
									         </div>
									      </div>
									   </div>
									</div>
								</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					</div>

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

        
<script type="text/javascript" language="javascript" >
var j = jQuery.noConflict();
</script>
</body>
	<!-- end: BODY -->
</html>