	<?php $this->load->view("common/header"); ?>
	<!-- end: HEAD -->
       
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/jQuery-Tags-Input/jquery.tagsinput.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/summernote/build/summernote.css">
  <link rel="stylesheet" href="<?php echo asset_url(); ?>css/jquery-ui.css">
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
					max-height:10px;
				}
				
				.form-horizontal .form-group {
 					 margin-left: 0;
 					 margin-right: 0;
				}
		</style>

		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body>
    
		<!-- start: HEADER -->
		
		<!-- end: HEADER -->
		<!-- start: MAIN CONTAINER -->
	
				<!-- end: SPANEL CONFIGURATION MODAL FORM -->
				<div class="container">
	<!-- start: PAGE HEADER -->
						
					<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT 
                    <!-- start grid -->



                    <div class="row">
                    
						<div class="col-md-12">
						<div class="col-sm-12">
							<!-- start: PAGE TITLE & BREADCRUMB -->
							
						  <div class="page-header">
								<h1 align="center">CUSTOMER PREVIEW</h1>
							</div>

					  </div>	<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
							  <div class="panel-body">
							    <div class="alert alert-success" style="display:none;">
                                <button class="close" data-dismiss="alert">
                                    ×
                                </button>
                                <i class="fa fa-check-circle"></i>
                                <strong></strong><span class="succetxt"></span>
                            </div> 
                            
                      <form role="form" class="form-horizontal" id="create_sales_form" action="#" method="post">
                        
                        <div class="col-md-12"></div><!--col-md-12--><!--col-md-8-->
                                        

                                        
                                        <!-- item add box-->
                                        <div id="sticker" class="col-md-12">
											<div class="well">
												


											<div class="clearfix"></div>
											<div class="control-group table-group">
												<label class="table-label">Order Items</label>
													<div class="controls table-controls">
                                                   
                                                    
														<table class="table items table-striped table-bordered table-condensed table-hover" id="soTable">
															<thead>
																<tr>
																	<th class="col-md-7">Product Name (Product Code)</th>
																	<th>Selling Price</th>
																	<th class="col-md-1">Quantity</th>
																	<th class="col-md-1 text-right">Discount </th>
																	
																	<th class="text-right">Subtotal<span class="currency"></span>
                                                                    </th>
																	<th style="width: 30px !important; text-align: center;"><i class="fa fa-trash-o"></i></th>
																</tr>
															</thead>
																	<tbody>
																		<tr data-item-id="144680019784" class="row_144680019784" id="row_1446800197032">
																			<td>
																				
																			</td>
																			<td class="text-right">
																				
																			</td>
																			<td>
																				
																			</td>
																			<td class="text-right">
																				
																			</td>
																			<td class="text-right">
																				
																			</td>
																			
																			<td class="text-center">
																			
																			</td>
																		</tr>
																	</tbody>
															<tfoot>
																<!--<tr class="tfoot active" id="tfoot">
																	<th colspan="2">Total</th>
																	<th class="text-center"><span id="qtyTotal">0.00</span></th>
																	<th class="text-right"><span id=""> 0.00</span></th>
																	<th class="text-right">0.00</th>
																	<th class="text-right"><span id="Subtotal">00.00</span></th>
																	<th class="text-center"><i class="fa fa-trash-o"></i></th>
																</tr>-->
                                                                <tr class="tfoot active" id="tfoot">
																	<th colspan="4" class="text-right">Total Amount</th>
																	<th class="text-right"><span id="Subtotal">0.00</span></th>
																	
																</tr>
                                                               <!-- <tr class="tfoot active" id="tfoot">
																	<th colspan="4" class="text-right">Paid </th>
																	<th class="text-right">
                                                                    <input type="text" onChange="changePaidValue(this.value);" onClick="this.select(); setTmpVal(this.value);" id="paid" value="0.00" name="paid" class="form-control text-right rquantity">
                                                                    </th>
																	
																</tr>
                                                                <tr class="tfoot active" id="tfoot">
																	<th colspan="4" class="text-right">Balance </th>
																	<th class="text-right"><span id="balance_dis">0.00</span></th>
																	
																</tr>-->
															</tfoot>
														</table>
                                                        
                                                        
                                                        <!-- start list -->
                                                        <!-- end list -->
													</div>
												</div>
											</div>
                                        <!-- end item add box-->

									
                                                
                                                <div id="extras-con" class="row">
															<!--<div class="col-md-4">
																<div class="form-group">
																	<label for="potax2">Order Tax</label>
																	<select id="tax_rate_id" class="form-control" name="tax_rate_id">
                                                                   
																  <?php 
                                                              foreach ($tax_rates_list as $row)
                                                              {
																  
                                                              ?>  
                                                                        
																		<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?>
                                                                        </option>
                                                              <?php }?>
																		
																	</select>
																</div>
															</div>-->
                                                            
                                                            <div class="col-md-4">
											<div class="form-group">
												<label>Order Discount</label>
					                           <input type="text" title="" data-original-title="" value="" class="form-control input-tip" id="sale_inv_discount" name="sale_inv_discount" onChange="changeMainDiscount(this.value)">
											</div>
										</div>
                                        
                                        <!--<div class="col-md-4">
											<div class="form-group">
												<label>Shipping</label>
					                             <input type="text" title="" data-original-title="" name="sale_shipping" value="" class="form-control input-tip" id="sale_shipping">
											</div>
										</div>-->
                                        
                                      <!-- <div class="col-md-4">
															<div class="form-group">
													<label for="poshipping">Payment Status *</label>
													 <select id="payment_status" class="form-control selectpicker" name="payment_status">
                                                      <option value="Paid">Paid</option>
                                                     <option value="Pending">Pending</option>
                                                     <option value="Due">Due</option>
                                                     <option value="Partial">Partial</option>
                                                    
					                             </select>
															</div>
														</div>-->
                                        
                                        <!--<div class="col-md-4">
											<div class="form-group">
												<label>Sale Status *</label>
					                            <select id="sale_status" name="sale_status" class="form-control selectpicker">
                                                    <option value="Completed">Completed</option>
                                                     <option value="Pending">Pending</option>
					                             </select>
											</div>
										</div>-->
															<!--<div class="col-md-4">
																<div class="form-group">
																	<label for="podiscount">Payment Term</label>
																	<input type="text" id="sale_payment_term" class="form-control input-tip" value="" name="sale_payment_term" data-original-title="" title="">
																</div>
															</div>
														-->
                                                        
     
													</div>
                                                    
                                                    
                                                    
                                         
                                        
                                       			
										
													
                                        
                        </div> <!-- end: col-md-12-->
                        
                        
                        
                    
						
                        	<!--<div class="col-md-6">
                            <div class="form-group">
										<label for="form-field-23">
											Safe Note
										</label>
										<textarea class="form-control limited" id="form-field-23" maxlength="50"></textarea>
									</div>
                            </div>--><!-- col-md-6-->
                           
                            
                          <!-- <div class="col-md-6">
                            <div class="form-group">
										<label for="form-field-23">
											Staff Note
										</label>
										<textarea class="form-control limited" id="form-field-23" maxlength="50"></textarea>
									</div>
                            </div>--><!-- col-md-6-->
                        
                       
                        
                        <div style="display:none" class="col-md-12">
                        <div class="modal-footer" style="margin-bottom:10px;">
            				<input type="submit" class="btn btn-primary" value="Add Sales" name="add_sale" id="add_sale"> <button id="reset" class="btn btn-danger" type="button">Reset</button>
            			</div>
                        </div>
                         <input name="sale_inv_discount_amount" type="hidden" id="sale_inv_discount_amount" value="0">
                        <input name="sale_total" type="hidden" id="sale_total" value="0">
                        <input name="sale_paid" type="hidden" id="sale_paid" value="0">
                        <input name="sale_balance" type="hidden" id="sale_balance" value="0">
                        <input name="rowCount" type="hidden" id="rowCount" value="0">
                         <input name="cost_total" type="hidden" id="cost_total" value="0">
                   		 </form>
									
							<!-- end: DYNAMIC TABLE PANEL -->
                            
                            
                            <!-- footer amount details -->
                            <div style="margin-bottom: 0px; position: fixed; bottom: 0px; width: 1082px; z-index: 50000; display:none" class="well well-sm" id="bottom-total">
<table style="margin-bottom:0;" class="table table-bordered table-condensed totals">
<tbody><tr class="warning">
<td style="width:30%">Total <span id="f_total" class="totals_val pull-right">0.00</span></td>
<td style="width:30%">Order Discount <span id="tds" class="totals_val pull-right">0.00</span></td>
<td>Grand Total <span id="gtotal" class="totals_val pull-right">0.00</span></td>
</tr>
</tbody></table>
</div>
                            <!-- end footer amount details -->
                            
						</div>
					</div>

					
                    <!-- end grid -->
                    
			</div>		
			</div>
			<!-- end: PAGE -->
		</div>
		<!-- end: MAIN CONTAINER -->
		<!-- start: FOOTER --><!-- end: FOOTER -->
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


<input name="tmpVal" type="hidden" id="tmpVal" value="0">

<input name="" id="type_sale" type="hidden" value="22">
		<!-- start ajax model -->
		<div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
		<!-- end ajax model -->
        
        

		<!-- start: MAIN JAVASCRIPTS -->
		<?php $this->load->view("common/footer"); ?>
        
		<script src="<?php echo asset_url(); ?>js/jquery-ui.js" ></script>		
		<script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script>
		<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script>
		
		<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>
        
         <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script>
          <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
        
		<!-- end: MAIN JAVASCRIPTS -->
        
 		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
		<script src="<?php echo asset_url(); ?>js/form-validation-create_sales.js"></script>
        <script src="<?php echo asset_url(); ?>js/sales_pos.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
        
<script>

function addextraprice(){
	calculateTotal();
}

clearForm();


/*$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});*/

var pc = new Array();
var pq = new Array();
var position = 0;

window.setInterval(function(){

//$('#soTable tbody').remove();
//$('#soTable').append("<tbody></tbody>");
	$('#soTable tbody').empty();
	var lth = JSON.parse(localStorage.getItem("product_code")).length;	
	var pc = JSON.parse(localStorage.getItem("product_code"));
	var pq = JSON.parse(localStorage.getItem("product_qty"));
	//alert(pq);
		for(c = 0; c < lth; c++){
			//alert("no:"+(c+1)+"/pc:"+lth+"|code:"+pc[c]+"|QTY:"+pq[c]+"|PQ lth"+pq.length);
			//alert(pq[c]);
			$.ajax({
					type: "get",
					url: "<?php echo base_url();?>sales/pos_suggestions?t="+pc[c],  
					//data: {code: code, warehouse_id: wh, customer_id: cu},
					dataType: "json",
					success: function (data) {
						//e.preventDefault();
						
						if(data[0]){
						
						//check is added prodcut
						rowCount=parseInt($('#rowCount').val());
						var tmp='';
						if(rowCount){
							//alert("ADDED:"+pq[c]);
							tmp=isAddedProduct(data[0].product_id);
						}
						if(!tmp){
					addProductToListByID(data[0].product_id,data[0].product_name,data[0].product_code,data[0].product_price,data[0].product_part_no,data[0].product_oem_part_number,data[0].item_cost,pq[0]);
						}else {
							calculateTotal();
						}
						
					}
					
					}
				});
			}
			
		},2000);

$('#add_item').keypress(function(e){
    if ( e.which == 13 ) return false;
    //or...
    if ( e.which == 13 ) e.preventDefault();
 }); 


function changeQtyByProductID(qty,nxtCount){
	//alert(qty+' '+nxtCount);
	
	if(isNaN(qty)) {
		displayNotice('page','Invalid Quantity');
		var quantity_fld='#quantity_'+nxtCount;
		var product_id_fld='#product_id'+nxtCount;
		
		//alert(quantity_fld);
		var oldVal=$('#tmpVal').val();
		$(quantity_fld).val(oldVal); //set last val
	}else {
		//getavalable product count
		var product_id_fld='#product_id'+nxtCount;
		var product_id=$(product_id_fld).val();
		
		var warehouse_id=$('#warehouse_id').val();
		$.get( "<?php echo base_url();?>sales/get_avalable_product_qty", { product_id: product_id, warehouse_id: warehouse_id } )
			.done(function( data ) {
				var obj = jQuery.parseJSON(data);
				//alert(obj.remmnaingQty);
	   });
	   
	   
	   
		//end getavalable product count
		calculateTotal();
		//displayNotice('page','Product quantity successfully updated!');
	}
}

function getNextRefNo(){
	//return 'SALE/2015/11/0001';
	//alert();
	
	$.post( "<?php echo base_url();?>sales/get_next_ref_no")
	  .done(function( data ) {
		  var obj = jQuery.parseJSON(data);
		  $('#sale_reference_no').val(obj.sale_reference_no);
	  });
	//return false;
}

function insertSalesData(){
	
	;
	var type='A';
	var sale_reference_no=$('#sale_reference_no').val();
	 var fields = $("#create_sales_form").serialize();
	  
	  var rowCount=$('#rowCount').val();

	  if(rowCount!=0){
		  $("#add_sale").prop("disabled", true);
		  $("#add_sale").val('Please wait...');

		 // create_sales_form.add_sale.disabled = true;
   		// create_sales_form.add_sale.value = "Please wait...";
    	//	return true;
	
	//alert(fields);
	//type:type, sale_reference_no:sale_reference_no
	$.post( "<?php echo base_url();?>sales/save_sales", fields)
	  .done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
				
				$('.alert-success').hide();
				$('.alert-danger').show();
				$( ".errortxt" ).text( obj.disMsg );
				window.scrollTo(500, 0);
				//empty item table
				
			}
			if(obj.error==0){
				//$('.alert-danger').hide();
				//$('.alert-success').show();
				//$( ".succetxt" ).text( obj.disMsg );
				window.scrollTo(500, 0);
				//$("#soTable tr:gt(0)").remove();
				$("#soTable > tbody").empty();
				displayNotice('page','Sale successfully added!');
				
				clearForm();
				//empty footer details
				
				//alert(obj.sale_id);
				sendUrl='sales/view/'+obj.sale_id;
				//alert(sendUrl);
				window.location.href = "<?php echo base_url();?>"+sendUrl;
				
			}
			
			
	  });
return false;

	  }else  {
		 bootbox.alert('Please add products.', function () {
                        $('#add_item').focus();
                    });
	  }
	  
}


function add_items(){
        //ItemnTotals();
        $("#add_item").autocomplete(
		{
            source: '<?php echo base_url();?>sales/suggestions?t='+$("#in_type").val(),
            minLength: 1,
            autoFocus: false,
            delay: 5,
            response: function (event, ui) {
			
				if (ui.content.length == 1 && ui.content[0].product_id != 0)
				{
					//ui.item = ui.content[0];
 					//$(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
					//$(this).autocomplete('close');
                   // $(this).removeClass('ui-autocomplete-loading');
				}else if(ui.content.length ==0){
					var noResult = { value:"",label:"No matching result found! Product might be out of stock in the selected warehouse." };
            		ui.content.push(noResult);
				}else {

				}
			
            },
            select: function (event, data) {
				//alert( "You selected: " + data.item.product_id );
				if(data.item.value){
					
					//check is added prodcut
					rowCount=parseInt($('#rowCount').val());
					var tmp='';
					if(rowCount){
	  					tmp=isAddedProduct(data.item.product_id);
					}
	   				if(!tmp){
				addProductToListByID(data.item.product_id,data.item.product_name,data.item.product_code,data.item.product_price,data.item.product_part_no,data.item.product_oem_part_number,data.item.item_cost);
					}else {
						calculateTotal();
					}
				
				
				$("#add_item").val('');
					 return false;
				}
				$(this).autocomplete('close');
                    $(this).removeClass('ui-autocomplete-loading');
				
            }
        });
}
		$(window).scroll(function() {
   if($(window).scrollTop() + $(window).height() == $(document).height()) {
       //alert("bottom!");
	   $('#bottom-total').css({
        position: 'static',
		width: '100%'
    });
   }else {
	    $('#bottom-total').css({
        position: 'fixed',
		width: '1082px'
    });
   }
});

//function to initiate bootstrap-datepicker
$(function () {
	//showKeys();
	
	var currentDate = new Date();
	
	
	$('#sale_datetime').datetimepicker({
		defaultDate: new Date()
		});
	
	//$("#warehouse_id").select2();
	$("#supp_id").select2();
	$("#customer_id").select2();
	
	
});	
</script>


	</body>
	<!-- end: BODY -->
</html>