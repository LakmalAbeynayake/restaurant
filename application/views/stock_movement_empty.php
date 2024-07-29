<?php $this->load->view("common/header"); ?>
<!-- end: HEAD -->

<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<?php /*?><link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/select2/select2.css" />
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />
		<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/jQuery-Tags-Input/jquery.tagsinput.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/summernote/build/summernote.css"><?php */?>
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
      <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button"> <span class="clip-list-2"></span> </button>
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
            <li> <a href="<?php echo base_url('dashboard'); ?>"> Dashboard </a> </li>
            <li> <a href="#"> Reports </a> </li>
            <li class="active"> Empty Sales Statement </li>
            <li class="search-box">
              <form class="sidebar-search">
                <div class="form-group">
                  <input type="text" placeholder="Start Searching...">
                  <button class="submit"> <i class="fa fa-search"></i> </button>
                </div>
              </form>
            </li>
          </ol>
        </div>
      </div>
      <div id="print-section">
        <div class="page-header">
          <h1>Empty Sales Statement </h1>
        </div>
        <p>Please use the table below to navigate or filter the results. </p>
        
        <!-- end: PAGE HEADER --> 
        <!-- start: PAGE CONTENT 
                    <!-- start grid -->
        <div class="row">
          <div class="col-md-12"> 
            <!-- start: DYNAMIC TABLE PANEL -->
            <div class="panel panel-default">
              <div class="panel-heading"> <i class="fa fa-external-link-square"></i> Empty Sales Statement 
                <div class="panel-tools" style="top:2px;">
                  <button onClick="printDiv('printableArea')" class="btn btn-blue dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-print"></i> </button>
                </div>
              </div>
            </div>
            <div class="panel-body">
              <div id="error"></div>
              <div class="col-md-12">
                <div class="panel panel-default">
                  <div style="font-weight: 700;" class="panel-heading"></div>
                  <div class="panel-body">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Warehouse </label>
                        <select id="srh_warehouse_id" class="form-control" name="srh_warehouse_id">
                          <!-- <option value="">-- Select Warehouse --</option>-->
                          <?php 
																 $ss_warehouse_id=$this->session->userdata('ss_warehouse_id'); 
                                                              foreach ($warehouse_list as $row)
                                                              {
																  $sel='';
																  if($ss_warehouse_id==$row->id)
																  {
																	  $sel=' selected="selected"';
																  }
                                                              ?>
                          <option value="<?php echo $row->id; ?>" <?php echo $sel; ?>> <?php echo $row->name; ?> </option>
                          <?php }?>
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
                <div id="printableArea">
                <!-- 
                <table>
                <tr>
                        <td></td>
                        <td id="f-date-td" class="text-right">From Date: <span id="f-date-txt">Loading....</span>, To Date: <span id="t-date-txt">Loading....</span></td>
                    </tr>
                      </table> -->
                  <table class="table table-bordered table-condensed table-hover table-striped dataTable" id="summary_table">
                    <thead>
                    <tr>  
                      <th>KIND</th>
                      <th>IN HAND</th>
                      <th>RECEIVED FROM FACTORY</th>
                      <th>ON REFUND</th>
                      <th>AMOUNT <br>
                        Rs.</th>
                      <th>TOTAL</th>
                      <th>RETURN TO FACTORY</th>
                      <th>SOLD</th>
                      <th>AMOUNT<br>
                        Rs.</th>
                      </thead>
                    <tbody>
                      <tr>
                        <td>Bear Empties (Q)</td>
                        <td><div id="bear_empties_q"></div></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>Bear Empties (P)</td>
                        <td></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      </tr>
                      <tr>
                        <td>DCSL  (Q)</td>
                        <td><div id="es_q"></div></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      </tr>
                      <tr>
                        <td>DCSL (P)</td>
                        <td><div id="es_p"></div></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>DCSL (N)</td>
                        <td></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>Toddy - Empty</td>
                        <td></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      
                      <tr>
                        <td>Arrack Plastic Crates</td>
                        <td><div id="arrack_plastic_crates"></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      
                      <tr>
                        <td>Beer Plastic Crates</td>
                        <td><div id="beer_plastic_crates"></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      
                       <tr>
                        <td>Arrack Wooden Crates</td>
                        <td></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      
                       <tr>
                        <td>Toddy Wooden Crates</td>
                        <td></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                       <tr>
                         <td>&nbsp;</td>
                         <td></td>
                         <td>&nbsp;</td>
                         <td><strong>TOTAL</strong></td>
                         <td>&nbsp;</td>
                         <td>&nbsp;</td>
                         <td>&nbsp;</td>
                         <td><strong>TOTAL</strong></td>
                         <td>&nbsp;</td>
                       </tr>
                     
                    </tbody>
                    <tfoot>
                    </tfoot>
                  </table>
                </div>
                <br>
                <br>
               
              </div>
            </div>
            <!-- end: DYNAMIC TABLE PANEL --> 
          </div>
        </div>
        
        <!-- end grid --> 
        
      </div>
      <!-- end: PAGE --> 
    </div>
  </div>
  <!-- end: MAIN CONTAINER --> 
  <!-- start: FOOTER -->
  <div class="footer clearfix">
    <div class="footer-inner"> 2018 &copy; smartsalleepos.com </div>
    <div class="footer-items"> <span class="go-top"><i class="clip-chevron-up"></i></span> </div>
  </div>
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
<input name="sales-rtn-val-cost" type="hidden" id="sales-rtn-cost-fld" value="0">
<input name="sales-rtn-val-fld" type="hidden" id="sales-rtn-val-fld" value="0">
<input name="sale-fld" type="hidden" id="sale-fld" value="0">
<input name="cost-fld" type="hidden" id="cost-fld" value="0">

<!-- start ajax model -->
<div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
<!-- end ajax model --> 

<!-- start: MAIN JAVASCRIPTS -->
<?php $this->load->view("common/footer"); ?>
<script src="<?php echo asset_url(); ?>js/jquery-ui.js" ></script> 
<script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datepicker.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script> 
<!-- <script src="<?php echo asset_url(); ?>js/main.js"></script>--> 
<!-- end: MAIN JAVASCRIPTS --> 
<script>
		function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
		
		function searchDetailsReset(){
			$('#srh_to_date').val('');
			$('#srh_from_date').val('');
		}
		function searchDetails(){
					
				//alert();
				var fields='';
				 var srh_from_date=$('#srh_from_date').val();
	 var srh_to_date=$('#srh_to_date').val();
	 var srh_warehouse_id=$('#srh_warehouse_id').val();
	 
			$.post( "<?php echo base_url();?>finance/get_empty_qty_by_id?srh_from_date="+srh_from_date+"&srh_to_date="+srh_to_date, fields)
			.done(function( data ) {
			var obj = jQuery.parseJSON(data);
			if(obj.error==1){
			}
			if(obj.error==0){
			//displayNotice('page','successfully');
				$("#bear_empties_q").html(obj.bear_empties_q);	
				$("#es_q").html(obj.es_q);
				$("#es_p").html(obj.es_p);
				$("#arrack_plastic_crates").html(obj.arrack_plastic_crates);
				$("#beer_plastic_crates").html(obj.beer_plastic_crates)	
			}
			});
				
				
					//loadGrid();
					//loadGridSalesReturn();
		}
			
			
			$('#summary_table').DataTable({
							dom: 'Bfrtip',
							searching: false,
							paginate:false,
							bInfo: false,
							bSort:false,
							bDestroy: true,
							/*bLengthChange: false,
    						bFilter: true,*/
							buttons: [ { 	extend: 'print',
											text:'<i class="fa fa-print fa-2x">',
											//header: true,
											//footer: true,
											//autoPrint: false,
											title: "Empty Sales Statement",
											message:'From date: '+$('#f-date-txt').text() + '- To Date:'+$('#t-date-txt').text(),
											customize: function ( win ) {
												$(win.document.body)
													.css( 'font-size', '12pt' )
													.prepend(
														'<img src="<?php echo asset_url(); ?>images/logo.png" style="position:absolute; top:0; left:0; height:60px;" />'
													);
												$(win.document.body).find( 'table' )
													.addClass( 'compact' )
													.css( 'font-size', 'inherit' );
													//$(win.document.body).find( 'h1' ).prepend("<center>");
												//$(win.document.body).find( 'h1' ).html("<center>Baker's Choice Daily Sales Reporst <br/></h1><h3 style='margin-top:-5px;'><?php echo $warehouse_details['address']; ?><br/><?php echo $warehouse_details['email']; ?><br/> <?php echo $warehouse_details['phone']; ?></h3></center>");
												$(win.document.body).find( 'h1' ).append("<h3 style='margin-top:-5px;'></h3>").css("text-align","center");
											}
										},
										{ 
											extend: 'excel',
											text: '<i class="fa fa-file-excel-o fa-2x">',
											message:'From date: '+$('#f-date-txt').text() + '- To Date:'+$('#t-date-txt').text(),
											footer: true 
											},
										{ 	extend: 'pdf',
											text: '<i class="fa fa-file-pdf-o fa-2x"></i>',
											orientation:'landscape',
											footer: true,
											title:	"Baker's Choice Daily Sales Report, \n <?php echo $warehouse_details['address']; ?> \n From date: "+$('#f-date-txt').text() + "- To Date:"+$('#t-date-txt').text(),
											//message:,
											
											customize: function(doc) {
										   }
											
										}]
});	
				
			jQuery(document).ready(function() {
				//var currentDate = new Date();
				var tomorrow = new Date();
				currentDate=tomorrow.setDate(tomorrow.getDate() + 1);
				$('#srh_to_date').datetimepicker({
					defaultDate: currentDate,
					format:"YYYY/MM/DD"
				});
				$('#srh_from_date').datetimepicker({
					defaultDate: new Date(),
					format:"YYYY/MM/DD"
				});
				//TableData.init();
				loadGrid();
				loadGridSalesReturn();
				loadsummary();
			});

var test1=1;
function loadGridSalesReturn() {
	

	}
var sumry_tbl = '';
			function loadGrid() {
			
            //  alert(1);
           

					}
function loadsummary(){
	}

function fbs_click(url) {
	var srh_from_date=$('#srh_from_date').val();
	var srh_to_date=$('#srh_to_date').val();
	var srh_warehouse_id=$('#srh_warehouse_id').val();
	
	u=location.href;
	t=document.title;
	url='<?php echo base_url();?>'+'reports/print_sale?srh_warehouse_id='+srh_warehouse_id+'&srh_from_date='+srh_from_date+'&srh_to_date='+srh_to_date;
	window.open(url,'sharer','toolbar=0,status=0,width=750,height=436, left=10, top=10,scrollbars=yes');return false;
}
</script>
</body>
<!-- end: BODY -->
</html>