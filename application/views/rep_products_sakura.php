	<?php $this->load->view("common/header"); ?>
	<!-- end: HEAD -->
       
		<style type="text/css">
			<style type="text/css">

			.table > thead:first-child > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table-striped thead tr.primary:nth-child(2n+1) th {

			    background-color: #428bca;

			    border-color: #357ebd;

			    border-top: 1px solid #357ebd;

			    color: white;

			    text-align: center;

			}
td.details-control {
    background: url('<?php echo base_url('thems/images/green_plus.png');?>') no-repeat center center;
	background-size: 20px 20px;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('<?php echo base_url('thems/images/red_plus.jpg');?>') no-repeat center center;
	background-size: 20px 20px;
}
button.dt-button, div.dt-button, a.dt-button {
  -moz-user-select: none;
  background-color: #e9e9e9;
  background-image: linear-gradient(to bottom, #fff 0%, #e9e9e9 100%);
  border: 1px solid #999;
  border-radius: 2px;
  box-sizing: border-box;
  color: black;
  cursor: pointer;
  display: inline-block;
  font-size: 0.88em;
  margin-right: 0.333em;
  outline: medium none;
  overflow: hidden;
  padding: 0.5em 1em;
  position: relative;
  text-decoration: none;
  white-space: nowrap;
}
/*td{
	text-align:right;
}*/


.table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
border: 0px solid gray !important;
    font-size: 12px;
    padding: 1px;
}

.data_table_title{
	font-size:14px;		
}
td{
	vertical-align:top !important;
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
										 Reports 
									</a>
								</li>
                                                                
								<li class="active">
									 Products Report
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
								<h1>Products Report</h1>
							</div>

                            <p>Please use the table below to navigate or filter the results. </p>
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
									Product Report
                                   <!-- <div class="panel-tools" style="top:2px;">
												<button onClick="JavaScript:fbs_click('<?php //echo base_url('reports/print_products/'); ?>');" class="btn btn-blue dropdown-toggle" data-toggle="dropdown">
													<i class="fa fa-print"></i>
												</button>
												
												</div>-->
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
                                                                        
															<option value="<?php echo $row->id; ?>" <?php echo $sel; ?>>
																		<?php echo $row->name; ?>
                                                                        </option>
                                                              <?php }?>
																		
																	</select>                                          
														</div>
														</div>
                                                        
                                                        <div class="col-sm-3">
                  <div class="form-group">
                   
                   
                    <label>User </label>
                    <select id="srh_user_id" class="form-control search-select" name="srh_user_id" 
<?php //echo $disable ?>
>
                      <option value=""> -All- </option>
                      <?php 
																 $ss_user_id=$this->session->userdata('ss_user_id'); 
                                                              foreach ($user_list as $row)
                                                              {
																  
                                                              ?>
                      <option value="<?php echo $row->user_id; ?>" <?php //echo $sel; ?>> <?php echo $row->user_first_name; ?> </option>
                      <?php }?>
                    </select>
                  </div>
                </div>
                
                                                      <div class="col-sm-3">
                                                      	<div class="form-group">
															<label>Category</label>
                                                            <?php
															$cat_id=1;
															 //print_r($supplier_list);?>
                                                         <select id="cat_srh" name="cat_srh" class="form-control search-select">
                                                          			<option value="">--Select Category--</option>
								                                 <?php foreach ($category_list as $key => $sup) {
																	 ?>
									                               	<option value="<?php echo $sup->cat_id; ?>"><?php echo $sup->cat_name; ?></option>
                                                                    <?php
																	//$cat_id=$sup->cat_id;
									                             } ?>  
                                                                
								                             </select>                                                           
														</div>
														</div>
                                                        
                                                        <div class="col-sm-3">
                                                      	<div class="form-group">
															<label>From Date  </label>
                                                         <input id="srh_from_date" name="srh_from_date" type='text' class="form-control date" value="" data-bv-field="date"/>                                                             
														</div>
														</div>
                                                        
                                                        <div class="col-sm-3">
                                                      	<div class="form-group">
															<label for="s2id_autogen1">To Date </label>
                                                          
															 <input id="srh_to_date" name="srh_to_date" type='text' class="form-control date" value="" data-bv-field="date"/>        
														</div>
                                                        </div>
                                                        
                                                        <div class="col-sm-3">
                                                      	<div class="form-group">
                                                        <label class="" for="costbox">Show all avalable items :</label>
                                                        <br>
<input type="checkbox" id="show_all" >
                                                        </div>
                                                        </div> 
                                                        
                                                        <div class="col-sm-3" style="display:none">
                                                      	<div class="form-group">
															<label for="commision">Commision</label>
                                                          
															 <input id="commision" name="commision" type='text' class="form-control" value="0.00" />        
														</div>
                                                        </div>
                                                        
                                                        
                                                    
                                                    <div class="col-sm-4 pull-right">
                                                      	<div class="form-group">
															<label for="s2id_autogen1">&nbsp;<br><br>
</label>
                                                          
															 <input type="submit" name="add_category" value="Search" class="btn btn-primary" onClick="searchDetails()">          
														</div>
													</div>
                                                   
                                                    
												</div>
											</div> 
                                            
								  <table class="table table-bordered table-condensed table-hover table-striped dataTable" id="products_table" style="overflow:scroll">
									  <thead>
							              <tr>
							                    <th style="text-align:left;">Product Name</th>
                                                <th>Category</th>
                                                <th class="col-md-1">Sold Qty</th>
                                                <th class="col-md-1">Total Sales Value</th>
                                          </tr>
							          </thead>
                                     <!-- <tbody>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      </tbody>-->
                                      
                                      <!--
							          <tfoot>
										 <tr>
	                                        <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                         	<th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>								
                                    </tr>
								      </tfoot>    --> 
								      <tfoot>
								           <tr>
	                                        <th>&nbsp;</th>
	                                        <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                           </tr>
								      </tfoot>
						          </table>
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
        <script src="<?php echo asset_url(); ?>js/jquery-ui.js" ></script>		
		<script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script>
		<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
          
          
      
       <script>
	   	function searchDetails(){
			products_load();
		}
			jQuery(document).ready(function() {
				
				var currentDate = new Date();
				var tomorrow = new Date();
				currentDate=tomorrow.setDate(tomorrow.getDate());
				
				$('#srh_to_date').datetimepicker({
					format:("YYYY/MM/DD HH:mm:ss"),
						defaultDate: "<?php echo date("Y-m-d 23:00:00");?>"
				
				//	defaultDate: currentDate
				});
				
				
				$('#srh_from_date').datetimepicker({
					//format:("YYYY/MM/DD  HH:mm:ss"),
					format:("YYYY/MM/DD  HH:mm:ss"),
					defaultDate: "<?php echo date("Y-m-d 06:00:00");?>"
					//,defaultDate: new Date()
				});
				
				//TableData.init();
				//loadGrid();
				
				
				 //$("#cat_srh").select2();
				 // $("#sub_cat_srh").select2();
				//TableData.init();
				products_load();
				
				
				
			});

/*pdf doc*/
var doc = {
    pageSize: 10,//config.pageSize,
    pageOrientation: 'landscape',//config.orientation,
    content: [
        {
            table: {
                headerRows: 1//,
                //body: rows
            },
            layout: 'noBorders'
        }
    ],
    styles: {
        tableHeader: {
            bold: true,
            fontSize: 11,
            color: 'white',
            fillColor: '#2d4154',
            alignment: 'center'
        },
        tableBodyEven: {},
        tableBodyOdd: {
            fillColor: '#f3f3f3'
        },
        tableFooter: {
            bold: true,
            fontSize: 11,
            color: 'white',
            fillColor: '#2d4154'
        },
        title: {
            alignment: 'center',
            fontSize: 16
        },
        message: {}
    },
    defaultStyle: {
        fontSize: 13
    }
};
/**/
			function products_load() {
				var srh_warehouse_id=1;
				var cat_srh=$('#cat_srh').val();
				var srh_from_date=$('#srh_from_date').val();
				var srh_to_date=$('#srh_to_date').val();
				var show_all=$('#show_all').val();
				var srh_user_id=$('#srh_user_id').val();
			//	alert(show_all);
				//buttons: ['copy', 'csv', 'excel', 'pdf','print'],

					    $('#products_table').DataTable({
							dom: 'Blfrtip',
							buttons: [ { 	extend: 'print',
											text:'<i class="fa fa-print fa-2x">',
											header: true,
											footer: true,
											//autoPrint: false,
											title: "Product Report",
//											exportOptions:{ columns: [0,1,10,12] },
//autoPrint:false,
											customize: function ( win ) {
												$(win.document.body)
													.css( 'font-size', '12pt' )
													//.prepend(
													//	'<img src="http://smartsalleepos.com/bakerschoice/thems/images/logo.png" style="position:absolute; top:0; left:0; height:60px;" />'
													//)
													;
												
												$(win.document.body).find( 'table' )
													.addClass( 'compact' )
													.css( 'font-size', 'inherit' );
													
												$(win.document.body).find( 'h1' ).html("<h2><center><?php echo $warehouse_details['name']; ?> Products Report</center></h2>");
												$(win.document.body).find( 'h1' ).after("<center><h3> <?php echo $warehouse_details['address']; ?></h3></center><p style='font-size:16'><center>From date: "+$('#srh_from_date').val()+" - To date: "+$('#srh_to_date').val()+"</center></p><p style='font-size:16'><center>Cashier :  "+$("#srh_user_id").find("option:selected").text()+"</center></p>");
												
												/*$(win.document.body).find('tr:nth-child(odd) td').each(function(index){
                   									 $(this).css('background-color','#D0D0D0');
													 });
												$(win.document.body).find('table').each(function(index){
                   									 $(this).css('width','0%');
													 //$(this).css('background-color','#D0D0D0');
													 });
												$(win.document.body).find('tr > th:nth-child(1)').each(function(index){
                   									 $(this).css('width','20px');
													 //$(this).css('background-color','#D0D0D0');
													 });
												$(win.document.body).find('tr > th:nth-child(2)').each(function(index){
                   									 $(this).css('width','20px');
													 //$(this).css('background-color','#D0D0D0');
													 });
													 
												$(win.document.body).find('tr > th:nth-child(3)').each(function(index){
                   									 $(this).css('width','20px');
													 //$(this).css('background-color','#D0D0D0');
													 });
													 
												$(win.document.body).find('tr > th:nth-child(4)').each(function(index){
                   									 $(this).css('width','20px');
													 //$(this).css('background-color','#D0D0D0');
													 });*/
													 
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
											exportOptions:{ columns: [0,1,2,3] },
											title:	"<?php echo $warehouse_details['name']; ?>, \n <?php echo $warehouse_details['address']; ?>",
//											message:	"<?php echo $warehouse_details['name']; ?>, \n <?php echo $warehouse_details['address']; ?></b>",
											customize: function(doc) {
    										  //doc.defaultStyle.fontSize = 16; //<-- set fontsize to 16 instead of 10 
										    }
											
										}],
					        "ajax": {
							'type': 'POST',
							'url': '<?php echo base_url('reports/get_list_product_for_report_sakura');?>',
							'data': {
							   srh_warehouse_id: srh_warehouse_id,
							   cat_srh: cat_srh,
							   srh_from_date: srh_from_date,
							   srh_to_date: srh_to_date,
							   show_all:$("#show_all").is(':checked'),
							   commision  : $('#commision').val(),
							    srh_user_id: srh_user_id,
							}
							},
					        "bDestroy": true,
					        "iDisplayLength": -1,
//"order": [[ 2, "asc" ]],
                            "order": [],
                            "fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay) {
                                var nCells = nRow.getElementsByTagName('th');
                                var total_sale = 0;
                                for (var i = 0; i < aaData.length; i++) {
                                    
                                    if(!isNaN(parseFloat(aaData[[i]][3])))total_sale += parseFloat(aaData[[i]][3]);
                                        //console.log(parseFloat(aaData[[i]][3]));
                                }
                                
                                nCells[3].innerHTML = '<div class="text-right">' + accounting.formatMoney(total_sale, "", 2, ",", ".") + ' </div>';
                                
                                //$('#percentage-tbl').text(accounting.formatMoney(total_sale, "", 2, ",", "."));
                            }
					    
					    });
						
						

					}
function fbs_click(url) {
	u=location.href;
	t=document.title;
	window.open(url,'sharer','toolbar=0,status=0,width=850,height=436, left=10, top=10,scrollbars=yes');return false;
}
		</script>

     
	</body>
	<!-- end: BODY -->
</html>