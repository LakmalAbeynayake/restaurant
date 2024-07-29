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
            .modal-dialog{
                padding: 0;
                margin: 0;
                width: 100%;
            }
    		
            .modal-dialog{
                padding: 0 !important;
                width: 100% !important;
                margin: 0 !important;
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
										 G.R.N 
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
									<?php echo $po_header->grn_ref_no; ?> - 
									    Goods Received from <b><?php echo $sender_location['name']; ?>(location)</b> on <b><?php echo date('Y-m-d H:i A', strtotime($po_header->date_time)); ?></b>
									</b>
								</div>
								<div class="panel-body">
									<div class="box-content">
									   <div class="row">
									      <div class="col-lg-12">
									         <div class="well well-sm">
									            <div class="col-xs-4 border-right">
									               <div class="col-xs-2"><i class="fa fa-3x fa-building padding010 text-muted"></i></div>
									               <div class="col-xs-10">
									                   <?php  ?>
									                   From: 
									                   <h2 class=""><?php echo $sender_location['name']; ?></h2>
									                   Supplier Address<br>
									                   <?php echo $sender_location['address']; ?>
									                   <p></p>
									                   Tel: <?php echo $sender_location['phone']; ?>
									                   <br>Email: <?php echo $sender_location['email']; ?>
									               </div>
									               <div class="clearfix"></div>
									            </div>
									            <?php if($po_header->approval_status){ ?>
                                            <div class="col-xs-4 ">
									            <code style="padding:0">
									                Status      : Approved. Stock has been updated! <br>
									                Approved On : <?php echo $po_header->approved_on; ?><br>
									                Approved By : <?php echo $po_header->approved_by; ?>
									            </code>
									        </div>
                                        <?php }else{ ?>
                                            <div class="col-xs-4 ">
									            <code style="padding:0">
									                Status      : Not Approved. Stock has NOT been updated! <br>
									                Approved On : --/--<br>
									                Approved By : --/--
									            </code>
									        </div>
                                        <?php } ?>
									            <!--<div class="col-xs-4">
									               <div class="col-xs-2"><i class="fa fa-3x fa-truck padding010 text-muted"></i></div>
									               <div class="col-xs-10">
									                  <h2 class="">Stock Manager Advance</h2>
									                  <?php echo $po_header->name; ?>
									                  <p><?php echo $po_header->address; ?></p>
									               </div>
									               <div class="clearfix"></div>
									            </div>
									            <div class="col-xs-4 border-left">
									               <div class="col-xs-2"><i class="fa fa-3x fa-file-text-o padding010 text-muted"></i></div>
									               <div class="col-xs-10">
									                  <h2 class=""><?php echo $po_header->reference_no; ?></h2>
									                  <p style="font-weight:bold;">Date: <?php echo $po_header->date; ?></p>
									               </div>
									               <div class="clearfix"></div>
									            </div>-->
									            <div class="clearfix"></div>
									         </div>
                                  
									         <div class="table-responsive">
									            <table class="table table-bordered table-hover table-striped print-table order-table">
									               <thead>
									                  <tr>
									                     <th>No</th>
									                     <th>Description (Code)</th>
									                     <th>Quantity</th>
									                     <th style="padding-right:20px;">Unit Value</th>
									                     <!--<th style="padding-right:20px; text-align:center; vertical-align:middle;">Tax</th>
									                     <th style="padding-right:20px; text-align:center; vertical-align:middle;">Discount</th>-->
									                     <th style="padding-right:20px;">Subtotal</th>
									                  </tr>
									               </thead>
									               <tbody>
									               <?php 
									               $total = 0;
									               foreach ($po_middle as $po_middle) { 
									                $total += ($po_middle->unit_value * $po_middle->quantity);
									               ?>
									                  <tr>
									                     <td style="text-align:center; width:40px; vertical-align:middle;">#</td>
									                     <td style="vertical-align:middle;"><?php echo $po_middle->product_name; ?> (<?php echo $po_middle->product_code; ?>) </td>
									                     <td style="width: 120px; text-align:center; vertical-align:middle;"><?php echo number_format($po_middle->quantity, 2, '.',','); ?></td>
									                     <td style="text-align:right; width:120px; padding-right:10px;"><?php echo number_format($po_middle->unit_value , 2, '.',','); ?></td>
									                     <td style="text-align:right; width:120px; padding-right:10px;"><?php echo number_format($po_middle->unit_value * $po_middle->quantity, 2, '.',','); ?></td>
									                  </tr>
									                <?php } ?>

									               </tbody>
									               <tfoot>
									                  <tr>
									                     <td style="text-align:right; padding-right:10px; font-weight:bold;" colspan="4">
									                        Total Value (LKR)
									                     </td>
									                     <td style="text-align:right; padding-right:10px; font-weight:bold;">
									                        <?php echo number_format($total,2,'.',','); ?> 
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
									   <div class="buttons">
									      <div class="btn-group btn-group-justified">
									          <?php if(!$po_header->approval_status){ ?>
                                                <div class="btn-group"><a data-toggle="modal" title="" class="tip btn btn-warning tip" href="#" onclick="approve()" id="approve" data-original-title="Add to Stock"><i class="fa fa-check"></i>
                                                    <span class="hidden-sm hidden-xs">Approve and add to Stock</span></a>
									            </div>
									          <?php } ?>
									          <div class="btn-group"><a class="tip btn btn-success tip" href=""> <i class="fa fa-print"></i> <span class="hidden-sm hidden-xs">Print G.R.N</span></a></div>
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
<script>
    function uuidv4() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16 | 0,
                v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }

    function approve(){
        bootbox.confirm("Are you sure?",(a)=>{
            if(a){
                $('#approve').prop('disabled',true);

                var grn_id = <?php echo $grn_id; ?>;
                //var approval_status = <?php echo $po_header->approval_status;?>;
                //var approved_by = <?php echo $this->session->userdata('ss_user_id');?>;
        
                var jsonData = {
                      grn_id: grn_id,
                      uuid: uuidv4()
                    };
        
                // AJAX POST request
                $.ajax({
                    url: "<?php echo base_url()?>grn/approve",
                    type: "POST",
                    dataType: "json",
                    data: jsonData,
                    statusCode: {
                        200: function(response) {
                            console.log('200',response);
                            // Handle a successful response with status code 200
                            bootbox.alert("Success: " + JSON.stringify(response));
                            setTimeout(()=>{
                                window.location.reload();
                            },300);
                        },
                        201: function(response) {
                            console.log('201',response);
                            // Handle a successful response with status code 201
                            bootbox.alert("Created: " + JSON.stringify(response));
                        },
                        404: function(response) {
                            console.log('404',response);
                            // Handle a not found response with status code 404
                            bootbox.alert("Not Found");
                        },
                        500: function() {
                            console.log('500',response);
                            // Handle a server error response with status code 500
                            bootbox.alert("Internal Server Error");
                        }
                        // Add more status code handlers as needed
                    },
                    error: function(error) {
                        console.log('error',error);
                        // Handle other errors
                        //bootbox.alert("Error: " + JSON.stringify(error));
                    }
                });
            }
        });
    }

</script>
</body>
	<!-- end: BODY -->
</html>