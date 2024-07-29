<style type="text/css">
label {
	font-weight: 700;
}
.table > thead:first-child > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table-striped thead tr.primary:nth-child(2n+1) th {
	background-color:#666;
			    border-color: #666;
			    border-top: 1px solid #666;
			    color: white;
			    text-align: center;
}
.form-horizontal .form-group {
	margin-left: 0;
	margin-right: 0;
}
</style>
<style type="text/css">
label {
	font-weight: 700;
}
.table > thead:first-child > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table-striped thead tr.primary:nth-child(2n+1) th {
	 background-color: #428bca;
				    border-color: #357ebd;
				    border-top: 1px solid #357ebd;
				    color: white;
				    text-align: center;
}
.form-horizontal .form-group {
	margin-left: 0;
	margin-right: 0;
}
td {
	font-size: 13px;
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
									<a href="<?php echo base_url('requisition'); ?>">
										 List Requisition 
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
									Reference ID <?php echo $service_id ?>
									<div class="panel-tools" style="top:2px;">
                                   <!-- <button class="btn btn-blue dropdown-toggle" data-toggle="dropdown">
													<i class="fa fa-list"></i> Requisition Details
												</button>
												<ul class="dropdown-menu dropdown-light pull-right">
														<li>
															<a id="" data-toggle="modal" href="<?php echo base_url("requisition/manage/$service_id"); ?>">
																<i class="fa fa-plus"></i> Update Requisition Details
															</a>
														</li>
														
													</ul>-->
												
									</div> <!--panel-tools-->
								</div> <!--panel-heading-->
								<div class="panel-body">
									 
<div class="well well-sm">                      

<div class="col-xs-4 border-right pull-right">

<div class="col-xs-10">
<h4 class="">Reference ID : <?php echo $service_details->service_reference_no;?></h4>
<p>Date: <?php echo date('d/M/Y', strtotime($service_details->service_datetime));?></p>
<p>Project Name: <?php echo $service_details->name;?></p>



</div>
<div class="clearfix"></div>
</div>

<div class="col-xs-4 border-right">

<div class="col-xs-10">
<h4 class=""><p>Project Name: <?php echo $service_details->name;?></p></h4>

</div>
<div class="clearfix"></div>
</div>

<div class="col-xs-4 border-right">


<div class="clearfix"></div>
</div>


<div class="clearfix"></div>
</div>

 <!--col-xs-4-->



<div class="col-xs-5">
<input name="service_id" type="hidden" id="service_id" value="<?php echo $service_id ?>">
<input type="hidden" id="sale_type" name="sale_type" value="sale">


<div class="clearfix"></div>
</div> <!--col-xs-4"-->
<div class="clearfix"></div>






<div class="col-xs-12">
<br>

Note: 
	<?php //echo $requisition_details->requisition_note; ?>
    <br>
<br>


</div>

<div class="clearfix"></div>




<!-- payment list -->

<div class="row">
<div class="col-xs-12">
<div class="table-responsive">
<table class="table items table-striped table-bordered table-condensed table-hover" id="requisition_tbl">
															<thead>
																<tr>
																	<th class="col-md-4">Full Description Materials</th>
																	<th style="width:60px;">Unit</th>
																	<th style="width:60px;"">Qty</th>
																	<th class="col-md-1 text-right">Charge</th>
																	<th class="col-md-1 text-right">Discount</th>
																	
																	<th class="text-right col-md-1 ">Amount</th>
																</tr>
                                                                </thead>
																	<tbody>
<?php 
//print_r($service_);
$tmp_th_e=0;
if(count($serviceitm_list)){ 
foreach ($serviceitm_list as $key => $reqitm_dtls) {
	$tmp_th_e++;
?>
<tr id="row_e_<?php echo $tmp_th_e;?>">
			<td class="text-left">
			<?php echo $reqitm_dtls->product_name;?>
			</td>
			<td>
			<?php echo $reqitm_dtls->product_unit;?>
			</td>
			<td>
			<?php echo $reqitm_dtls->serviceitm_qty;?>
			</td>
			<td><?php echo $reqitm_dtls->product_service_charge;?></td>
			
			<td><?php echo $reqitm_dtls->serviceitm_dis_val;?></td>
			  
			
			<td align="right">
			  <?php echo $reqitm_dtls->sub_total_item;?>
			  
			  
			  </td>
			</tr>
<?php  } }?>
															
																		
																	</tbody>
															<tfoot>
															
                                                              
															</tfoot>
														</table>


</div>
</div>
</div>
<div class="clearfix"></div>
<br>
<div class="clearfix"></div>
<!-- end payment list-->



<!-- status ox -->
<form role="form" class="" id="update_req_status_form" action="#" method="post">
 <div class="footer-status-change">
<div class="col-md-12">
<br>
<input name="service_id" type="hidden" value="<?php echo $service_id;?>">
<div class="panel panel-default">
<div style="font-weight: 700;" class="panel-heading">Status</div>
<div class="panel-body">
<?php if ($this->session->userdata('ss_group_id')==1)
{ ?>
<div class="col-sm-3">
<div class="form-group">
<?php //echo 'test:'.$service_details->requisitioned_status; ?>
<label>Prepared Status</label>
<select  id="prepared_status" class="form-control" name="prepared_status">
<?php 

$sel_r='';
$sel_n='';
if(isset($service_details->prepared_status) && $service_details->prepared_status=='Prepared'){
$sel_r=' selected';
}
if(isset($service_details->prepared_status) && $service_details->prepared_status==0){
$sel_n=' selected';
}
if(!$service_details->prepared_status){	
?> 
<option value="0"<?php echo $sel_n;?>>Pending</option>
<?php }?>
<option value="Prepared"<?php echo $sel_r; ?>>Prepared</option>
</select>

  <?php 
  if($service_details->prepared_status=='Prepared'){
	  $ref_id = new User_Model();
	  $data['user_details']=$ref_id->get_user_info($service_details->prepared_user);
	 echo '<br/>Prepared by: '; 
	 echo $data['user_details']['user_first_name'].' '.$data['user_details']['user_last_name'];
  }
  ?>              
</div>
</div>
<?php }?> 


  
  <?php if ($this->session->userdata('ss_group_id')==1)
{ ?>
<div class="col-sm-3">
<div class="form-group">
<label>Approved Status</label>
<select  id="approved_status" class="form-control" name="approved_status">
<?php 
$sel_a='';
$sel_n='';
if(isset($service_details->approved_status) && $service_details->approved_status=='Approved'){
$sel_a=' selected';
}
if(isset($service_details->approved_status) && $service_details->approved_status==0){
$sel_n=' selected';
}
if(!$service_details->approved_status){	
?> 
<option value="0"<?php echo $sel_n;?>>Pending</option>
<?php }?>
<option value="Approved"<?php echo $sel_a; ?>>Approved</option>
</select>

<?php 
  if($service_details->approved_status=='Approved'){
	  $ref_id = new User_Model();
	  $data['user_details']=$ref_id->get_user_info($service_details->approved_user);
	 echo '<br/>Approved by: '; 
	 echo $data['user_details']['user_first_name'].' '.$data['user_details']['user_last_name'];
  }
  ?>
                
</div>
</div>
<?php }?>

<?php if ($this->session->userdata('ss_group_id')==1)
{ ?>
<div class="col-sm-3">
<div class="form-group">
<label>Reserved Status</label>
<select  id="reserved_status" class="form-control" name="reserved_status">
<?php 
$sel_c='';
$sel_n='';
if(isset($service_details->reserved_status) && $service_details->reserved_status=='Reserved'){
$sel_c=' selected';
}
if(isset($service_details->reserved_status) && $service_details->reserved_status==0){
$sel_n=' selected';
}
if(!$service_details->reserved_status){	
?> 
<option value="0"<?php echo $sel_n;?>>Pending</option>
<?php }?>
<option value="Reserved"<?php echo $sel_c; ?>>Reserved</option>
</select>
<?php 
  if($service_details->reserved_status=='Reserved'){
	  $ref_id = new User_Model();
	  $data['user_details']=$ref_id->get_user_info($service_details->reserved_user);
	 echo '<br/>Reserved by: '; 
	 echo $data['user_details']['user_first_name'].' '.$data['user_details']['user_last_name'];
  }
  ?>
                
</div>
</div>
<?php }?>


<div class="col-sm-3">
<div class="form-group">
<div>&nbsp;</div>
<a href="#" class="btn btn-primary show-tab pull-right" id="update_req_status_btn"> Update Status <i class="fa fa-save"></i> </a>                
</div>
</div>
   


</div>
</div>
</div>
                        </div>
                        </form>
<!-- end status box -->


<div class="buttons">
<div class="btn-group btn-group-justified">


<!--<div class="btn-group"><a title="" class="tip btn btn-primary tip" data-target="#myModal" data-toggle="modal" href="#" data-original-title="Add Payment" id="modal_ajax_sales_payment_btn"><i class="fa fa-money"></i> <span class="hidden-sm hidden-xs">Add Payment</span></a></div>
-->
<!--<div class="btn-group"><a title="" class="tip btn btn-primary tip" data-target="#myModal" data-toggle="modal" href="http://sma.tecdiary.org/sales/add_payment/2" data-original-title="Add Payment"><i class="fa fa-money"></i> <span class="hidden-sm hidden-xs">View Payment</span></a></div>-->
<!--<div class="btn-group"><a title="" class="tip btn btn-primary tip" data-target="#myModal" data-toggle="modal" href="http://sma.tecdiary.org/sales/add_delivery/2" data-original-title="Add Delivery"><i class="fa fa-truck"></i> <span class="hidden-sm hidden-xs">Add Delivery</span></a></div>-->

<div class="btn-group" onClick="fbs_click(<?php echo $service_id; ?>)"><a title="" class="tip btn btn-primary" data-original-title="Print"><i class="fa fa-print"></i> <span class="hidden-sm hidden-xs">Print</span></a>
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
				<?php echo date("Y");?> &copy; Vehical Maintacne Management System by sallelanka solutions. 
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
			


$( "#update_req_status_btn" ).click(function() {
				$("#update_req_status_btn").prop("disabled", true);
	 var fields = $("#update_req_status_form").serialize();
	 $.post( "<?php echo base_url();?>service/update_service_status", fields)
	.done(function( data ) {
		  //alert();
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
				$('.alert-success').hide();
				$('.alert-danger').show();
				//$( ".errortxt" ).text( obj.disMsg );
				bootbox.alert(obj.msg, function () {
                        
                    });
			}
			if(obj.error==0){
				displayNotice('page','Status successfully updated!');
				
				//sendUrl='<?php echo base_url();?>loan/manage/'+obj.loan_id;
				//window.location.href = sendUrl;
				
				 $("#update_req_status_btn").prop("disabled", false);
		 		 $("#update_req_status_btn").val('Update Status');
				//clearForm();
			}
			
	  });
	return false;
	
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
				url :"sales/list_sales", // json datasource
				type: "post",  // method  , by default get
				error: function(){  // error handling
					j(".employee-grid-error").html("");
					j("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					//$("#employee-grid_processing").css("display","none");
				}
			}
		} );
		
	} );
	

	



function fbs_click(id,d) {
	u=location.href;
	t=document.title;
	window.open('<?php echo base_url() ?>requisition/service_details/'+id,'sharer','toolbar=0,status=0,width=700,height=700, left=10, top=10,scrollbars=yes');return false;
}
</script>
	</body>
	<!-- end: BODY -->
</html>