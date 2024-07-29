<?php $this->load->view("common/header"); ?>
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css"/>
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/jQuery-Tags-Input/jquery.tagsinput.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/summernote/build/summernote.css">
<style type="text/css">
.table > thead:first-child > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table-striped thead tr.primary:nth-child(2n+1) th {
	background-color: #428bca;
	border-color: #357ebd;
	border-top: 1px solid #357ebd;
	color: white;
	text-align: center;
}
#s2id_srh_customer_id {
	border: 0 none;
	padding: 0;
}
.pagination {
	margin-top: -15px;
}
</style>
<body>
<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button"> <span class="clip-list-2"></span> </button>
      <?php $this->load->view("common/logo"); ?>
    </div>
    <div class="navbar-tools">
      <?php $this->load->view("common/notifications.php"); ?>
    </div>
  </div>
</div>
<div class="main-container">
  <div class="navbar-content">
    <?php $this->load->view("common/navigation"); ?>
  </div>
  <div class="main-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <ol class="breadcrumb">
            <li> <a href="<?php echo base_url('dashboard'); ?>"> Dashboard </a> </li>
            <li> <a href="#"> Reports </a> </li>
            <li class="active"> Sales Report </li>
            <li class="search-box">
              <form class="sidebar-search">
                <div class="form-group">
                  <input type="text" placeholder="Start Searching...">
                  <button class="submit"> <i class="fa fa-search"></i> </button>
                </div>
              </form>
            </li>
          </ol>
          <div class="page-header">
            <h1> Sales By Product Category</h1>
          </div>
          <p>Please use the table below to navigate or filter the results. </p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12"> 
          <!-- start: DYNAMIC TABLE PANEL -->
          <div class="panel panel-default">
            <div class="panel-heading"> <i class="fa fa-external-link-square"></i> Sales Report
              <div class="panel-tools" style="top:2px;">
                <button onClick="JavaScript:fbs_click('<?php echo base_url('reports/print_sale?srh_warehouse_id=1'); ?>');" class="btn btn-blue dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-print"></i> </button>
              </div>
            </div>
            <div class="panel-body">
              <div id="error"></div>
              <div class="col-md-12">
                <div class="panel panel-default">
                  <div style="font-weight: 700;" class="panel-heading"> <i class="fa fa-filter"></i> Filters
                    <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="fa fa-refresh"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="fa fa-times"></i> </a> </div>
                  </div>
                  <div class="panel-body">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Warehouse </label>
                        <select id="srh_warehouse_id" class="form-control search-select" name="srh_warehouse_id">
                          <?php $ss_warehouse_id=$this->session->userdata('ss_warehouse_id'); foreach ($warehouse_list as $row){$sel=''; if($ss_warehouse_id==$row->id){$sel=' selected="selected"';}?>
                          <option value="<?php echo $row->id; ?>" <?php echo $sel; ?>> <?php echo $row->name; ?> </option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Customer </label>
                        <select id="srh_customer_id" class="form-control search-select" name="srh_customer_id">
                          <option value="">-Select-</option>
                          <?php 
															
															foreach ($customer_list as $row)
															{
																
															?>
                          <option value="<?php echo $row['cus_id'];?>"><?php echo $row['cus_name']; if($row['cus_phone']) echo " / ".$row['cus_phone'];?> </option>
                          <?php }  ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Payment Status </label>
                        <select id="srh_payment_status" class="form-control search-select" name="srh_payment_status">
                          <option value="">-Select-</option>
                          <option value="Pending">Pending</option>
                          <option value="Partial">Partial</option>
                          <option value="Paid">Paid</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>From Date </label>
                        <input id="srh_from_date" name="srh_from_date" type='text' class="form-control date" value="" data-bv-field="date"/>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="s2id_autogen1">To Date </label>
                        <input id="srh_to_date" name="srh_to_date" type='text' class="form-control date" value="" data-bv-field="date"/>
                      </div>
                    </div>
                    <div class="col-sm-4 pull-right">
                      <div class="form-group">
                        <label for="s2id_autogen1">&nbsp;<br>
                          <br>
                        </label>
                        <input type="submit" name="add_category" value="Search" class="btn btn-primary" onClick="searchDetails()">
                        &nbsp;&nbsp;
                        <input type="submit" name="add_category" value="Reset" class="btn btn-danger" onClick="searchDetailsReset()">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading"> <i class="clip-pie"></i> Summary
                    <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse expand" href="#"> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="fa fa-refresh"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="fa fa-times"></i> </a> </div>
                  </div>
                  <div class="panel-body collapse">
                    <div class="<!--flot-mini-container-->">
                      <div id="placeholder-h2" class="flot-placeholder" style="padding: 0px; position: relative;">
                        <table class="table table-bordered table-condensed table-hover table-striped dataTable" id="summary_table">
                          <thead>
                          <th>Description</th>
                            <th>Values</th>
                              </thead>
                          <tbody>
                            <tr>
                              <th>Total Sales</th>
                              <td><div id="total_sales">_</div></td>
                            </tr>
                            <tr>
                              <th>Total Cost</th>
                              <td><div id="total_cost">_</div></td>
                            </tr>
                            <tr>
                              <th style="background-color:#C93">Profit</th>
                              <td style="background-color:#C93"><div id="profit">_</div></td>
                            </tr>
                            <!--<tr>
                              <th>&nbsp;</th>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <th width="50%">Cost of Sales</th>
                              <td width="50%"><div id="cost-tbl">_</div></td>
                            </tr>
                            <tr>
                              <th>Cost of Sales Return</th>
                              <td><div id="sales-rtn-cost-tbl">_</div></td>
                            </tr>
                            <tr>
                              <th style="background-color:#C93">Net Cost of Sales Return</th>
                              <td style="background-color:#C93"><div id="net-cost-of-sales-return">_</div></td>
                            </tr>
                            <tr>
                              <th>&nbsp;</th>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <th style="background-color:#093">Net Margin</th>
                              <td style="background-color:#093"><div id="profit-tbl">_</div></td>
                            </tr>
                            <tr>
                              <th>Percentage (%)</th>
                              <td><div id="percentage-tbl">_</div></td>
                            </tr>-->
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <?php /*?><h4  style="font-weight:700; color:#FFF; background-color:#5bc0de; padding:0.2em; border-radius:3px" ></h4><?php */?>
                <div>
                  <?php /*print_r($category_list); class="label label-info"*/
			$c = 0;
			foreach($category_list as $row){
				//echo '<br/><br/><br/><h4  style="font-weight:700; color:#FFF; background-color:#5bc0de; padding:0.2em; border-radius:3px " >'.$row->cat_name.' <span class="badge">'.$row->cat_id.'</span></h4>';
echo '
<div class="panel panel-default">
  <div class="panel-heading"> <i class="clip-pie"></i> <span class="badge"> '.$row->cat_id.' - '.$row->cat_name.' </span>
    <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> </div>
  </div>
  <div class="panel-body">
    <div class="flot-mini-container">
      <div  class="flot-placeholder" style="padding: 0px; position: relative;">
        <table class="table table-bordered table-condensed table-hover table-striped dataTable" id="cat_'.$row->cat_id.'">
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Product ID</th>
              <th>#Sold</th>
              <th>Sales</th>
              <th>%Sales</th>
              <th>Cost</th>
              <th>Profit</th>
              <th>%Profit</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Product Name</th>
              <th>Product ID</th>
              <th>#Sold</th>
              <th>Sales</th>
              <th>%Sales</th>
              <th>Cost</th>
              <th>Profit</th>
              <th>%Profit</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>';}?>
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
      <div class="footer-inner"> 2018 &copy; smartsalleepos.com </div>
      <div class="footer-items"> <span class="go-top"><i class="clip-chevron-up"></i></span> </div>
    </div>
    <!-- end: FOOTER --> 
    <!-- start: RIGHT SIDEBAR --> 
    <!-- end: RIGHT SIDEBAR -->
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
    
    <!-- start ajax model -->
    <div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
    <!-- end ajax model --> 
  </div>
  <div>
  	<input id="total_sales_" type="hidden" value="0" />
    <input id="total_cost_" type="hidden" value="0" />
    <input id="profit_" type="hidden" value="0" />
  </div>
</div>
<!-- start: MAIN JAVASCRIPTS -->
<?php $this->load->view("common/footer"); ?>
<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery-ui.js" ></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script> 

<!-- end: MAIN JAVASCRIPTS --> 
<script>
		
		function searchDetailsReset(){
			$('#srh_to_date').val('');
			$('#srh_from_date').val('');
		}
		function searchDetails(){					
<?php
foreach ($category_list as $row) {
	
    echo 'loadGrid("cat_' . $row->cat_id . '",' . $row->cat_id . ');';
}
?>
		}
				
				
			jQuery(document).ready(function() {
				var currentDate = new Date();
				$('#srh_to_date').datetimepicker({
					defaultDate: currentDate,
					format: 'YYYY-MM-DD',
					maxDate:currentDate
				});
				$('#srh_from_date').datetimepicker({
					format: 'YYYY-MM-DD',
					maxDate:currentDate
				});
			});


			function loadGrid(table_name,cat_srh) {
				
				var srh_warehouse_id=1;
				
				var srh_from_date=$('#srh_from_date').val();
				var srh_to_date=$('#srh_to_date').val();
				

					    $('#'+table_name).DataTable({
							dom: 'Blfrtip',
							buttons: [ { 	extend: 'print',
											text:'<i class="fa fa-print fa-2x">',
											header: true,
											footer: true,
											/*autoPrint: false,*/
											title: "Baker's Choice Product Report",
											/*exportOptions:{ columns: [0,1,10,12] },*/

											customize: function ( win ) {
												$(win.document.body)
													.css( 'font-size', '12pt' )
													/*.prepend(
														<img src="http://smartsalleepos.com/bakerschoice/thems/images/logo.png" style="position:absolute; top:0; left:0; height:60px;" />'
													)*/
													;
												
												$(win.document.body).find( 'table' )
													.addClass( 'compact' )
													.css( 'font-size', 'inherit' );
													
												$(win.document.body).find( 'h1' ).html("<center>Baker's Choice Product Report</center>");
												$(win.document.body).find( 'h1' ).after("<center><h3> <?php echo $warehouse_details['address']; ?></h3></center><p style='font-size:16'><center>From date: "+$('#srh_from_date').val()+" - To date: "+$('#srh_to_date').val()+"</center></p>");
												
													 
											}
										},
										{ 
											extend: 'excel',
											text: '<i class="fa fa-file-excel-o fa-2x">',
											footer: true 
											},
										{ 	extend: 'pdf',
											text: '<i class="fa fa-file-pdf-o fa-2x"></i>',
											orientation:'landscape',
											footer: true,
											exportOptions:{ columns: [0,1,2,3,4,5,6,7,9] },
											title:	"Baker's Choice, \n <?php echo $warehouse_details['address']; ?>",
											message:	"Baker's Choice, \n <?php echo $warehouse_details['address']; ?></b>",
											/*customize: function(doc) {
    										  doc.defaultStyle.fontSize = 16; <-- set fontsize to 16 instead of 10 
										   }*/
											
										}],
					        "ajax": {
							'type': 'POST',
							'url': '<?php echo base_url('reports/products_by_category');?>',
							'data': {
							   srh_warehouse_id: srh_warehouse_id,
							   cat_srh: cat_srh,
							   srh_from_date: srh_from_date,
							   srh_to_date: srh_to_date,
							   /*commision  : $('#commision').val()*/
							}
							},
					        "bDestroy": true,
					        "iDisplayLength": 20,
							"order": [[ 1, "asc" ]], "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
								
				/*$("html, body").animate(
											{
												scrollTop: 300
											}, "slow");*/
											
                var pq = 0, sq = 0, bq = 0, pa = 0, grand_tot = 0, tech_tot = 0, parts_tot=0 , ser_tot=0;
				var TWO = 0;
				var THREE=0;
				var FOUR =0;
				var FIVE =0;
				var NINE=0
				var SIX=0;
				var SEVEN=0;
				var EIGHT=0;
				var TEN=0;
				var ELEVEN = 0;
				var TWELVE = 0;
				
                for (var i = 0; i < aaData.length; i++) {
					/*alert(aaData[[i]][5]);
                    p = (aaData[aiDisplay[i]][2]).split('__');*/
					TWO += parseFloat(aaData[[i]][2]);
					THREE += parseFloat(aaData[[i]][3]);
					/*FOUR += parseFloat(aaData[[i]][4]);*/
					FIVE += parseFloat(aaData[[i]][5]);
					SIX += parseFloat(aaData[[i]][6]);
					/*SEVEN += parseFloat(aaData[[i]][7]);
					EIGHT += parseFloat(aaData[[i]][8]);
					NINE += parseFloat(aaData[[i]][9]);
					TEN  += parseFloat(aaData[[i]][10]);
					ELEVEN += parseFloat(aaData[[i]][11]);
					TWELVE += parseFloat(aaData[[i]][12]);
					ser_cost_tot += parseFloat(aaData[[i]][10]);*/
                }
                var nCells = nRow.getElementsByTagName('th');
				nCells[2].innerHTML = '<div class="text-right">'+accounting.formatMoney(TWO, "", 2, ",", ".")+' </div>';
				nCells[3].innerHTML = '<div class="text-right">'+accounting.formatMoney(THREE, "", 2, ",", ".")+' </div>';
				/*nCells[4].innerHTML = '<div class="text-right">'+accounting.formatMoney(FOUR, "", 2, ",", ".")+' </div>';*/
				nCells[5].innerHTML = '<div class="text-right">'+accounting.formatMoney(FIVE, "", 2, ",", ".")+' </div>';
				nCells[6].innerHTML = '<div class="text-right">'+accounting.formatMoney(SIX, "", 2, ",", ".")+' </div>';
				/*nCells[7].innerHTML = '<div class="text-right">'+accounting.formatMoney(SEVEN, "", 2, ",", ".")+' </div>';
				nCells[8].innerHTML = '<div class="text-right">'+accounting.formatMoney(EIGHT, "", 2, ",", ".")+' </div>';
				nCells[9].innerHTML = '<div class="text-right">'+accounting.formatMoney(NINE, "", 2, ",", ".")+' </div>';
              	nCells[10].innerHTML = '<div class="text-right">'+accounting.formatMoney(TEN, "", 2, ",", ".")+' </div>';
				nCells[11].innerHTML = '<div class="text-right">'+accounting.formatMoney(ELEVEN, "", 2, ",", ".")+' </div>';
				nCells[12].innerHTML = '<div class="text-right">'+accounting.formatMoney(TWELVE, "", 2, ",", ".")+' </div>';*/
				
				cal_summary( parseFloat( THREE ),parseFloat( FIVE ));
            }
					    
			    });
			}
					
function cal_summary(tot_sales,tot_cost){
	tot_sales = parseFloat( accounting.formatMoney(tot_sales, "", 2, "", "."));
	var total_sales_ = parseFloat( $('#total_sales_').val() );
	total_sales_ += tot_sales
	$('#total_sales_').val(total_sales_);
	$('#total_sales').text(accounting.formatMoney(total_sales_, "", 2, ",", "."));
	
	tot_cost = parseFloat( accounting.formatMoney(tot_cost, "", 2, "", "."));
	var total_cost_ = parseFloat( $('#total_cost_').val() );
	total_cost_ += tot_cost
	$('#total_cost_').val(total_cost_);
	$('#total_cost').text(accounting.formatMoney(total_cost_, "", 2, ",", "."));
	
	$('#profit').text(accounting.formatMoney(total_sales_ - total_cost_, "", 2, ",", "."));
	}

function fbs_click(url) {
	var srh_from_date=$('#srh_from_date').val();
	var srh_to_date=$('#srh_to_date').val();
	var srh_warehouse_id=$('#srh_warehouse_id').val();
				var srh_customer_id=$('#srh_customer_id').val();
			var srh_payment_status=$('#srh_payment_status').val();
			
var d=new Date(srh_from_date);		
var srh_from_date = d.getDate()  + "-" + (d.getMonth()+1) + "-" + d.getFullYear();
var d=new Date(srh_to_date);
var srh_to_date = d.getDate()  + "-" + (d.getMonth()+1) + "-" + d.getFullYear();
			
	u=location.href;
	t=document.title;
	url='<?php echo base_url();?>'+'reports/print_sale?srh_warehouse_id='+srh_warehouse_id+'&srh_from_date='+srh_from_date+'&srh_to_date='+srh_to_date+'&srh_customer_id='+srh_customer_id+'&srh_payment_status='+srh_payment_status;
	window.open(url,'sharer','toolbar=0,status=0,width=750,height=436, left=10, top=10,scrollbars=yes');return false;
}
</script>
</body>
<!-- end: BODY -->
</html>