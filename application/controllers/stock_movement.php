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
border: 1px solid gray !important;
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

									Stock Movement Report

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

								<h1>Stock Movement Report</h1>

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

									Total Quantity  Report

                                     <div class="panel-tools" style="top:2px;">

												<!--<button onClick="printDiv('printableArea')" class="btn btn-blue dropdown-toggle" data-toggle="dropdown">

													<i class="fa fa-print"></i>

												</button>-->

												

												</div>

								</div>

								</div>

							  <div class="panel-body">

							    <div id="error"></div>

                                

                              <div class="col-md-12">

											<div class="panel panel-default">

												<div style="font-weight: 700;" class="panel-heading"></div>

													<div class="panel-body">


<div class="col-sm-3">
<div class="form-group">
<label>Warehouse </label>
<select id="srh_warehouse_id" class="form-control" name="srh_warehouse_id">
<option value="">--Select Warehouse--</option>
<?php 
$ss_warehouse_id=$this->session->userdata('ss_warehouse_id'); 
foreach ($warehouse_list as $row){
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

<div class="col-sm-3" style="display:none">
                                                      	<div class="form-group">
															<label>Location </label>
                                                           
                                                      <select  id="location_id" class="form-control search-select" name="location_id"  >


<option value="">-All location -</option> 
						
  <?php 						
						foreach ($location_list as $row)
							{?>
                            
                            
                            <?php if ($row['location_id']!=1){ ?>
                            <option  value="<?php echo $row['location_id'];?>">												
							
							<?php echo $row['location_name'];?>                                                       
                            </option>				   
                            <?php }?>
							<?php }  ?>
                            
                           
                            
<!-- <option value="n">-Not Select location -</option>   -->                      			 
						     						
</select>                                         
														</div>
														</div>

<div class="col-sm-3">

                                                      	<div class="form-group">

															<label for="s2id_autogen1">From Date </label>

<?php //echo '12/25/2018';//echo date('m/d/Y'); ?>

                                                            <!--<input id="srh_from_date" name="srh_from_date" type='text' class="form-control date-picker" value="<?php echo date('m/d/Y'); ?>" data-bv-field="date"/>-->
                                                            
                                                               <input id="srh_from_date" name="srh_from_date" type='text' class="form-control date" value="" data-bv-field="date"/>
                                                            
                                                            
                                                            

                                                            

														</div>

													</div>
                                                        <div class="col-sm-3">

                                                      	<div class="form-group">

															<label for="s2id_autogen1">To Date </label>

<input id="srh_to_date" name="srh_to_date" type='text' class="form-control date" value="" data-bv-field="date"/>

                                                            <!--<input id="srh_to_date" name="srh_to_date" type='text' class="form-control date-picker" value="<?php echo date('m/d/Y'); ?>" data-bv-field="date"/>-->

                                                            

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
																	$cat_id=$sup->cat_id;
									                             } ?>  
                                                                
							                              </select>                                                           
														</div>
													  </div>

 <div class="col-sm-3">                                                       
  <div class="form-group">
											<label class=" control-label" for="form-field-3" >
												Sub Category
											</label>
											
                                            <div id="subcat_data">
											<select onChange="" data-placeholder="Select Category to load Subcategories" id="subcategory" class="form-control search-select" name="subcategory">
											<option selected="selected" value=""></option>
											</select>
                                            </div>
											</div>
										</div>                                                          
                                                
   
   <div class="col-sm-3">
                                                      	<div class="form-group">
<label>Product</label>
<select  id="product_id" class="form-control search-select" name="product_id" >
<option value="">--Select Product--</option>
<?php 	foreach ($product_list as $row => $product){?>
<option  value="<?php echo $product->product_id;?>">									<?php echo $product->product_name.' ( '.$product->product_oem_part_number.' ) ';?>
</option>				   
<?php }  ?>
</select>                                         
</div>
</div>  

<div class="col-sm-3">
                                                      	<div class="form-group">
                                                        <label class="" for="costbox">Show all avalable items :</label>
                                                        <br>
<input type="checkbox" id="show_all">
                                                        </div>
                                                        </div> 
                                                                                                   
 <div class="col-sm-3 pull-right" style="margin-top:26px;">
 <div class="form-group">
<input type="submit" name="add_category" value="Search" class="btn btn-primary" onClick="table_details()"> &nbsp;&nbsp;
<button id="reset" class="btn btn-danger" type="button">Reset</button>
</div>
</div>
</div>
</div>  
                                         
    
<?php //print_r($location_list);?>
<!--<p onClick="reset_datatable()" class="btn-green">Print Report</p>-->

<button onClick="reset_datatable()" id="reset_datatable_btn" class="btn btn-green pull-right" type="button">Print Report</button>

<div style="height:40px; text-align:center; font-size:20px !important">
<span id="loader" style="display:none; text-align:center;" align="center">Loading... <i class="fa fa-spin fa-spinner"></i></span>
&nbsp;
</div>
<table class="table table-bordered table-condensed table-hover table-striped dataTable" id="total_product_qty_table" width="100%">
<thead><tr>

<th width="60%">Product(Model)</th>
<th  width="5%">  Op/Bl</th>
<th  width="5%">GRN</th>
<th  width="5%">GRN RTN</th>
<th  width="5%">Adj</th>
<th  width="5%">Ser Out.</th>
<th  width="5%">Ser. In</th>
<th  width="5%">Sale</th>
<th  width="5%">Wr. Ex In </th>
<th  width="5%">Ex. Out</th>
<th  width="5%">Load</th>
<th  width="5%">Unload</th>
<th  width="5%">Cl/Bl</th>
</tr></th>

<tbody id="occupancyBody">
<tr>
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
  <td></td>
  <td></td>
  <td></td>
</tbody>
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
</table>
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

		<!-- end: MAIN CONTAINER -->

		<!-- start: FOOTER -->

		<div class="footer clearfix">

			<div class="footer-inner">

				

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
        <input type="hidden" id="invoice_tot" name="invoice_tot" value="0">
        <input type="hidden" id="closing_balance_tot" name="closing_balance_tot" value="0">
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

		<!-- end: MAIN JAVASCRIPTS -->



        

      <script src="<?php echo asset_url(); ?>/plugins/jquery-inputlimiter/jquery.inputlimiter.1.3.1.min.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/autosize/jquery.autosize.min.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/select2/select2.min.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/jquery.maskedinput/src/jquery.maskedinput.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/jquery-maskmoney/jquery.maskMoney.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-daterangepicker/moment.min.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-colorpicker/js/commits.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/jQuery-Tags-Input/jquery.tagsinput.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/summernote/build/summernote.min.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/ckeditor/ckeditor.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/ckeditor/adapters/jquery.js"></script>

		<script src="<?php echo asset_url(); ?>/js/form-elements.js"></script>  
		
        

        

        

        <script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>

          <script type="text/javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/dataTables.buttons.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/buttons.print.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/buttons.flash.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/jszip.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/pdfmake.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/vfs_fonts.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/buttons.html5.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/buttons.print.min.js"></script>
          

        <script>
$('select#cat_srh').on('change', function(){
	//alert();

			   		var v = $(this).val();

					$.ajax({
					  type: "get",
					  async: false,
					  url: "<?php echo base_url('products/get_sub_category_by_id'); ?>",
					  data: { category_id: v },
					  dataType: "html",
					  success: function(data) {
						if(data != "") {
							$('#subcat_data').empty();
							$('#subcat_data').html(data);
							$("#subcategory").select2({allowClear: true});
						} else {
							$('#subcat_data').empty();
							var default_data = '<select name="subcategory" id="subcategory" class="form-control search-select" data-placeholder="Select Category to load Subcategories"></select>';
							$('#subcat_data').html(default_data);
							$("#subcategory").select2({allowClear: true});
							set_message("Product Info","No Subcategory found for the select category.");
						}},
					  error: function(){
       					alert('Error occured while getting data from server.');
    				  }
					  
					});
			});
		
		
function searchDetails(){
	
	$('#total_product_qty_table tbody').empty();
	 var table= $('#total_product_qty_table').DataTable();
 	table.destroy();
	
loadGrid();

						 
}


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
				//loadGrid();
				//loadGridSalesReturn();
				//loadsummary();
			});
			
jQuery(document).ready(function() {
FormElements.init();
var tomorrow = new Date();
currentDate=tomorrow.setDate(tomorrow.getDate() + 1);
loadGrid();
});


function loadGrid() {
	//$('#total_product_qty_table').empty()
	




var product_id=$('#product_id').val();
/*

$('#total_product_qty_table').DataTable({
"sDom": '<"top"lfB>rt<"bottom"ip><"clear">',
"bDestroy": true,
buttons: [{
    extend: 'print',
    text: 'Print current page',
    exportOptions: {
        stripHtml: false
    }
}, {
    extend: 'pdf',
    text: 'Save PDF',
    exportOptions: {
        stripNewlines: false
    }
},
{ extend: 'excel', 
    text: 'Save as Excel',
    exportOptions: {
        stripHtml: false
    },
    footer: true,
	},
],
"order": [[ 1, "desc" ]], "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
var pq = 0, sq = 0, bq = 0, pa = 0, grand_tot = 0, tech_tot = 0, parts_tot=0 , ser_tot=0
               var ser_tot1=0
			   var ser_tot2=0
			   var ser_tot3=0
			  for (var i = 0; i < aaData.length; i++) {
               ser_tot1 += parseFloat(aaData[[i]][1]);	 
			   ser_tot2 += parseFloat(aaData[[i]][2]);	
			   ser_tot3 += parseFloat(aaData[[i]][3]);
					 }
                var nCells = nRow.getElementsByTagName('th');
                nCells[1].innerHTML = '<div class="text-center">'+accounting.formatMoney(ser_tot1, "", 2, ",", ".")+' </div>';
                nCells[2].innerHTML = '<div class="text-center">'+accounting.formatMoney(ser_tot2, "", 2, ",", ".")+' </div>';
	            nCells[3].innerHTML = '<div class="text-center">'+accounting.formatMoney(ser_tot3, "", 2, ",", ".")+' </div>';
}
});*/
} 

$(document).ajaxStart(function() {
    $('#loader').show('fast');
	
	
	//$("#reset_datatable_btn").hide();
});

$(document).ajaxStop(function() {
    $('#loader').hide('fast');
	//$("#reset_datatable_btn").show();
	//reset_datatable();
});


function table_details(){
	
	$('#total_product_qty_table tbody').empty();
	
	
	//alert(1);
	//var row="<tr><td>1</td><td></td><td></td><td></td></tr>";
	//$('#total_product_qty_table >tbody:last').append(row);
//var t = $('#total_product_qty_table').DataTable();
	//t.clear();
	var products=<?php echo json_encode($product_list); ?>;	
	var srh_product_id=$('#product_id').val();
	var srh_warehouse_id=$('#srh_warehouse_id').val();
	var location_id=$('#location_id').val();
	var srh_from_date=$('#srh_from_date').val();
	var srh_to_date=$('#srh_to_date').val();
	var cat_srh=$('#cat_srh').val();
	var subcategory=$('#subcategory').val();
	var show_all=$('#show_all').val();
	
	var count='';
		if(srh_product_id==0){
			count=products.length;
							}else{
								count=1; }
	    for(var i=0;i<count;i++){
						var product_id='';
						var product_name='';
						var product_model='';	
							if(srh_product_id==0){
										product_id=products[i]['product_id'];
										product_name=products[i]['product_name'];
										product_model=products[i]['product_oem_part_number'];
													}else{	
														var index = products.findIndex(x => x.product_id == srh_product_id);
														product_id=products[index]['product_id'];
														product_name=products[index]['product_name'];
														product_model=products[index]['product_oem_part_number'];	
														}
														
  $.ajax({
		type:'POST',
		url:'<?php echo base_url('reports/stock_movement_list');?>',     
		   async: true, 
		data:{
			product_id:product_id,
			product_name:product_name,
			product_model:product_model,
			srh_warehouse_id:srh_warehouse_id,
			location_id:location_id,
			srh_from_date:srh_from_date,
			srh_to_date:srh_to_date,
			cat_srh:cat_srh,
			subcategory:subcategory,
			show_all:$("#show_all").is(':checked'),
			},
		success: function(data){
			var obj = jQuery.parseJSON(data);
			
			
			
			if(obj.row){
				$('#total_product_qty_table >tbody:last').append(obj.row);
			}
			
			
			if(srh_product_id!='' && obj.row==''){
				//alert('not avalable');
				bootbox.alert(product_name+' not avalable in all locations', function () {
				});
			}
			
			
		/*
			t.row.add( ["","","","",
            		
                     ] ).draw( false );
					 
			*/	 
                             },
        });	
		
		//if(i==(count-1)){
			if(i==(count-1)){
				//alert('last record');
				//console.log('last record');
				$('#last_record').val('last_record');
			}
			
			//alert(i);
				//alert(count);
		//}
		
		
																
	    }
		
		//alert();
		

//reset_datatable();	
	
}

function reset_datatable(){
	
	//$("#reset_datatable_btn").hide();
	
	 var table= $('#total_product_qty_table').DataTable();
 	table.destroy();
	var warehouse_name=$( "#srh_warehouse_id option:selected" ).text();
	var srh_from_date=$('#srh_from_date').val();
	var srh_to_date=$('#srh_to_date').val();

	 //TableData.init();
	 	var message="<div  style='text-align:center'><h4>"+warehouse_name+" <br/> Stock Movement Report</h4><h5>From Date: "+srh_from_date+" , To Date: "+srh_to_date+", Created Date: <?php echo date("m/d/Y H:i:s"); ?></h5></div>";



		  $('#total_product_qty_table').DataTable({
			  
			  "bDestroy": true,
			   "lengthMenu": [[10,50,150,-1], [10,50,150,'All']],
			    "footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;	 
				// Remove the formatting to get integer data for summation
				var intVal = function ( i ) {
					//alert(i);
					return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ?	i : 0;
				};
	 
				
				var col_1=0;
				var table = $('#total_product_qty_table').DataTable();
				
				
				<?php
				//$k=0;
				
				//for($k=0; $k<8; $k++){
				
				// $k++;?>
				col_1 = api.column( 1 ).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				},0 );
				
				
				var column = table.column( 1 );
				$( column.footer() ).html(
				column.data().reduce( function (a,b) {
					return "<span style='text-align: right;'>"+col_1+"<span>";
				} )
				
				);
				
				col_1 = api.column( 2).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				},0 );
				
				
				var column = table.column( 2 );
				$( column.footer() ).html(
				column.data().reduce( function (a,b) {
					return "<span style='text-align: right;'>"+col_1+"<span>";
				} )
				
				);
				
				<!---->
				col_1 = api.column(3).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				},0 );
				
				
				var column = table.column(3);
				$( column.footer() ).html(
				column.data().reduce( function (a,b) {
					return "<span style='text-align: right;'>"+col_1+"<span>";
				} )
				
				);
				<!---->
				<!---->
				col_1 = api.column(4).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				},0 );
				
				
				var column = table.column(4);
				$( column.footer() ).html(
				column.data().reduce( function (a,b) {
					return "<span style='text-align: right;'>"+col_1+"<span>";
				} )
				
				);
				<!---->
				<!---->
				col_1 = api.column(5).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				},0 );
				
				
				var column = table.column(5);
				$( column.footer() ).html(
				column.data().reduce( function (a,b) {
					return "<span style='text-align: right;'>"+col_1+"<span>";
				} )
				
				);
				<!---->
				<!---->
				col_1 = api.column(6).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				},0 );
				
				
				var column = table.column(6);
				$( column.footer() ).html(
				column.data().reduce( function (a,b) {
					return "<span style='text-align: right;'>"+col_1+"<span>";
				} )
				
				);
				<!---->
				<!---->
				col_1 = api.column(7).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				},0 );
				
				
				var column = table.column(7);
				$( column.footer() ).html(
				column.data().reduce( function (a,b) {
					return "<span style='text-align: right;'>"+col_1+"<span>";
				} )
				
				);
				<!---->
				<!---->
				col_1 = api.column(8).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				},0 );
				
				
				var column = table.column(8);
				$( column.footer() ).html(
				column.data().reduce( function (a,b) {
					return "<span style='text-align: right;'>"+col_1+"<span>";
				} )
				
				);
				<!---->
				
				<!---->
				col_1 = api.column(9).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				},0 );
				
				
				var column = table.column(9);
				$( column.footer() ).html(
				column.data().reduce( function (a,b) {
					return "<span style='text-align: right;'>"+col_1+"<span>";
				} )
				
				);
				<!---->
				
				<!---->
				col_1 = api.column(10).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				},0 );
				var column = table.column(10);
				$( column.footer() ).html(
				column.data().reduce( function (a,b) {
					return "<span style='text-align: right;'>"+col_1+"<span>";
				} )
				);
				<!---->
				
				<!---->
				col_1 = api.column(11).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				},0 );
				var column = table.column(11);
				$( column.footer() ).html(
				column.data().reduce( function (a,b) {
					return "<span style='text-align: right;'>"+col_1+"<span>";
				} )
				);
				<!---->
				
				<!---->
				col_1 = api.column(12).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				},0 );
				var column = table.column(12);
				$( column.footer() ).html(
				column.data().reduce( function (a,b) {
					return "<span style='text-align: right;'>"+col_1+"<span>";
				} )
				);
				<!---->
				
				<!---->
				/*col_1 = api.column(13).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				},0 );
				var column = table.column(13);
				$( column.footer() ).html(
				column.data().reduce( function (a,b) {
					return "<span style='text-align: right;'>"+col_1+"<span>";
				} )
				);*/
				<!---->
				
				
				<?php
				//}
				?>

				
					
					},
					//"bFilter": false,
					"bPaginate": true,
						"sDom": '<"top"lfB>rt<"bottom"ip><"clear">',
					
				buttons: [
						   { extend: 'print', text: 'Print',footer: true, message: message,title: ''},
							 { extend: 'excel', text: 'Save as Excel',footer: true, message: message,title: ''},
							 { extend: 'pdf', text: 'Save as Pdf',footer: true, message: message,title: ''},
							 
						],
						
				});
				
				
	
	
}
$('#reset').click(function(e) {
        bootbox.confirm("Are you sure?", function(result) {
            if (result) {

               $('body').modalmanager('loading');
                location.reload();
            }
        });
    });
</script>

</body>

	<!-- end: BODY -->

</html>