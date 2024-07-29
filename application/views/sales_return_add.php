	<?php $this->load->view("common/header"); ?>
	<!-- end: HEAD -->
       
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->

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
									<a href="#">
										 Dashboard 
									</a>
								</li>
                                
								<li>
									<a href="<?php echo base_url('sales'); ?>">
										Sales Return
									</a>
								</li>

								<li class="active">
										Add
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
								<h1>Add Sales Return</h1>
							</div>

                            <p>Please fill in the information below. The field labels marked with * are required input fields.</p>
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
									<i class="fa fa-plus"></i>
									Add Sales Return
								</div>
								<div class="panel-body">
                            <div class="alert alert-danger" style="display:none;">
                                <h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>
                               
                                <strong></strong> <span class="errortxt"></span>
                            </div>
                         <div class="alert alert-success" style="display:none;">
                                <button class="close" data-dismiss="alert">
                                    ×
                                </button>
                                <i class="fa fa-check-circle"></i>
                                <strong></strong><span class="succetxt"></span>
                            </div> 
                            
                            
                                
                                
                   		<form role="form" class="form-horizontal" id="create_sales_return_form" action="#" method="post">
                        
                        <div class="col-md-12"></div><!--col-md-12-->
                        <div class="col-md-12">
                                  
                                    
                      <div class="col-md-4">
                            <div class="form-group">
                                <label>Date *</label>
                               
                                <?php $nowdate=date("Y-m-d H:i:s");?>
                                    <input id="sl_rtn_datetime" name="sl_rtn_datetime" type='text' class="form-control date" value="" data-bv-field="date"/>
                                    
            
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Reference No</label>
                                <?php
									$ref_id = new Common_Model();
									$sl_rtn_reference_no = $ref_id->gen_ref_number('sl_rtn_id','sales_return','');
								?>
                                <input type='text' class="form-control" id="sl_rtn_reference_no" name="sl_rtn_reference_no" value="<?php echo $sl_rtn_reference_no ?>" readonly/>
                            </div>
                        </div>
										</div> <!--col-md-8-->
                                        

                                        
                                        <!-- item add box-->
                                        <div id="sticker" class="col-md-12">
											<div class="">
												

											<div class="clearfix"></div>
											<div class="control-group table-group">
												<label class="table-label">Order Items</label>
													<div class="controls table-controls">
<table class="table items table-striped table-bordered table-condensed table-hover" id="soTable">
    <thead>
        <tr>
            <th class="col-md-6">Product Name (Product Code)</th>
            <th class="col-md-1">Selling Price</th>
            <th class="col-md-1">Quantity</th>
            <th class="col-md-2 text-right">Discount</th>
            
            <th class="text-right">Subtotal </th>
            <th style="width: 30px !important; text-align: center;"><i class="fa fa-trash-o"></i></th>
        </tr>
    </thead>
            <tbody>
		<?php 
		//print_r($sale_item_list);
        $tmpcount=0;
		$Subtotal=0;
        foreach ($sale_item_list as $row)
        {
        $tmpcount++;
		$product_id=$row['product_id'];
		$Subtotal+=$row['gross_total'];
		
		//calculate qty: returnqty=soldqty-alredy returned qty
		$alredyReturnedQty=0;
		$modelSR = new Sales_Return_Model();
		$alredyReturnedQty = $modelSR->get_sales_return_product_qty($product_id,$sale_details['warehouse_id'],$sale_id);
		$remaintQty=$row['quantity']-$alredyReturnedQty;
        ?> 
                <tr id="row_<?php echo $tmpcount; ?>" class="child">
                <td><?php echo $row['product_name']; ?> (<?php echo $row['product_code']; ?>)<?php if ($row['product_part_no']) echo ", Part No.:".$row['product_part_no']; ?>
<?php if ($row['product_oem_part_number']) echo ", OEM Part No.:".$row['product_oem_part_number']; ?>
<input type="hidden" id="product_id_<?php echo $tmpcount ?>" value="<?php echo $product_id ?>" name="row[<?php echo $tmpcount ?>][product_id][]" class="form-control text-center rquantity"></td>
                <td class="text-right"><input type="hidden" value="<?php echo $row['unit_price'] ?>" id="product_price_<?php echo $tmpcount ?>" name="row[<?php echo $tmpcount ?>][unit_price][]"><?php echo number_format($row['unit_price'], 2, '.', ',') ?>
                
                <input type="hidden" value="0" id="item_price_p_<?php echo $tmpcount ?>" name="row[<?php echo $tmpcount ?>][item_price_p][]" style="width:50px;">
                </td>
                
                <td><?php //echo $alredyReturnedQty ?>
                <input type="text" onChange="changeQtyByProductID(this.value,<?php echo $tmpcount ?>);" onClick="this.select(); setTmpVal(this.value);" id="quantity_<?php echo $tmpcount ?>" value="<?php echo $remaintQty ?>" name="row[<?php echo $tmpcount ?>][qty][]" class="form-control text-center rquantity">
                </td>
                
                <td class="text-right"><span id="sdiscount_1446800197032" class="text-right sdiscount text-danger">
                <input type="text" style="width:50px;" id="discount_<?php echo $tmpcount ?>" value="<?php echo $row['discount']; ?>" name="row[<?php echo $tmpcount ?>][discount][]" onChange="changeDiscountByProductID(this.value,1);">
                 </span>
                 <input type="hidden" id="discount_val_<?php echo $tmpcount ?>" value="<?php echo $row['discount_val']; ?>" name="row[<?php echo $tmpcount ?>][discount_val][]">
                 <input type="hidden" id="discount_val_tot_<?php echo $tmpcount ?>" value="0" name="row[<?php echo $tmpcount ?>][discount_val_tot][]"></td>
                
                <td class="text-right">
                <span id="subtotal_<?php echo $tmpcount ?>" class="text-right ssubtotal">
				
				<?php echo number_format($row['gross_total'], 2, '.', ',') ?></span>               
                <input type="hidden" id="gross_total_<?php echo $tmpcount ?>" value="<?php echo $row['gross_total'] ?>"
                 name="row[<?php echo $tmpcount ?>][gross_total][]">
                
                </td>
                <td><a onClick="deleteSalesItem(<?php echo $tmpcount ?>)"><i style="cursor:pointer;" title="Remove" id="1446800197032" class="fa fa-times tip podel"></i></a></td>
                </tr>
<?php }?>   
            </tbody>
    <tfoot>
        <tr class="tfoot active" id="tfoot">
            <th colspan="4" class="text-right">Total Amount</th>
            <th class="text-right"><span id="Subtotal"><?php echo number_format($Subtotal, 2, '.', ',') ?></span></th>
            
        </tr>
     
    </tfoot>
</table>
                                                        
                                                        
                                                        <!-- start list -->
                                                        <!-- end list -->
													</div>
												</div>
											</div>
                                        <!-- end item add box-->

									
                                                
                                                <div id="extras-con" class="row">
															
                                                            <div class="col-md-4">
											<div class="form-group">
											
					                           <input type="hidden" title="" data-original-title="" value="<?php echo $sale_details['sale_inv_discount'] ?>" class="form-control input-tip" id="sl_rtn_inv_discount" name="sl_rtn_inv_discount" readonly>
											</div>
										</div>

     
													</div>
                                                           
                        </div> <!-- end: col-md-12-->
                        
                        
                        
<!-- footer amount details -->
 <div class="col-md-12">
 <div style="margin-bottom: 0;" class="well well-sm" id="bottom-total">
<div style="margin-bottom: 0px; z-index: 50000;" id="bottom-total">
<table style="margin-bottom:0;" class="table table-bordered table-condensed totals">
<tbody><tr class="warning">
<td width="30%">Total <span id="f_total" class="totals_val pull-right">0.00</span></td>
<td width="30%">Order Discount <span id="tds" class="totals_val pull-right"><?php echo number_format($sale_details['sale_inv_discount_amount'], 2, '.', ',') ?></span></td>
<td>Return Amount <span id="gtotal" class="totals_val pull-right"><?php echo number_format($sale_details['sale_total'], 2, '.', ',') ?></span></td>
</tr>
</tbody></table>
</div>
</div>
</div>
<div style="height:15px; clear: both;"></div>
<!-- end footer amount details -->


<!--error msg start-->
<div class="col-md-12">
<?php 
$obj = new Sales_Model();
$total_paid_amount=$this->Sales_Model->get_total_paid_by_sale_id($sale_id);
if (empty($total_paid_amount)) {
		  $pay_st = 'Pending';
		}else{
		  if ($total_paid_amount >= $sale_details['sale_total']) {
			$pay_st = 'Paid';
		  }else{
			$pay_st = 'Partial';
		  }
		}
?>
<div class="alert alert-warning">Please be informed that this sale payment status is <?php echo $pay_st ?>. Payment Status: <strong><?php echo $pay_st ?></strong> &amp; Paid Amount <strong><?php echo number_format($total_paid_amount, 2, '.', ',') ?></strong></div> </div>
  <div style="height:15px; clear: both;"></div>   
 <!--end error msg --> 
  
  
<!-- start payments-->
<div class="col-md-12">
<div class="well well-sm">
<div class="row">
<div class="col-md-4">
<div class="form-group">

<label for="payment_reference_no">Payment Reference No *</label> <input type="text" required id="payment_reference_no" class="form-control tip" value="<?php echo "SRP/".$sl_rtn_reference_no ?>" name="sale_pymnt_ref_no" data-bv-field="payment_reference_no" data-original-title="" title="">
<small style="display: none;" class="help-block" data-bv-validator="notEmpty" data-bv-for="payment_reference_no" data-bv-result="NOT_VALIDATED">Please enter/select a value</small></div>
</div>

<div class="col-sm-4">
<div class="payment">
<div class="form-group">
<label for="amount_1">Amount *</label> <input required type="text" class="pa form-control kb-pad amount" id="sale_pymnt_amount" name="sale_pymnt_amount">
</div>
</div>
</div>

<div class="col-sm-4">
<div class="payment">
<div class="form-group">
<label for="amount_1">Paying by</label>
<select class="form-control paid_by" id="sale_pymnt_paying_by" name="sale_pymnt_paying_by" data-bv-field="paid_by" tabindex="-1" title="Paying by *" onChange="changePayingby(this.value)">
<option value="Cash">Cash</option>
<option value="Credit Card">Credit Card</option>
<option value="Cheque">Cheque</option>
</select>

</div>
</div>
</div>

<!-- payment options start-->
<div class="clearfix"></div>


<div id="cheque_dtls" style="display:none;" class="paying_by_details col-sm-12">
<label for="date">Cheque No *</label> <input type="text" id="sale_pymnt_cheque_no" class="form-control" value="" name="sale_pymnt_cheque_no" data-bv-field="date">
</div> <!--cheque-->

<div id="credit_card" style="display:none;" class="paying_by_details">
<div class="col-sm-5">
<div class="form-group">
<input type="text" id="sale_pymnt_crdt_card_no" class="form-control tip" value="" name="sale_pymnt_crdt_card_no" placeholder="Credit Card No *">
</div>
</div> <!--col-sm-5-->
<div class="col-sm-5 pull-right">
<div class="form-group">
<input type="text" id="sale_pymnt_crdt_card_holder_name" class="form-control tip" value="" name="sale_pymnt_crdt_card_holder_name" placeholder="Holder Name *">
</div>
</div> <!--col-sm-5-->

<div class="col-sm-3" style="margin-right:60px;">
<div class="form-group">
<select class="form-control paid_by" id="sale_pymnt_crdt_card_type" name="sale_pymnt_crdt_card_type" data-bv-field="paid_by">
<option value="">-- Select Credit Card Type --</option>
<option value="Visa">Visa</option>
<option value="MasterCard">MasterCard</option>
<option value="Amex">Amex</option>
<option value="Discover">Discover</option>
</select>
</div>
</div> <!--col-sm-3-->

<div class="col-sm-3">
<div class="form-group">
<input type="text" id="sale_pymnt_crdt_card_month" class="form-control tip" value="" name="sale_pymnt_crdt_card_month" placeholder="Month *">
</div>
</div> <!--col-sm-3-->

<div class="col-sm-3 pull-right">
<div class="form-group">
<input type="text" id="sale_pymnt_crdt_card_year" class="form-control tip" value="" name="sale_pymnt_crdt_card_year" placeholder="Year *">
</div>
</div> <!--col-sm-3-->
</div> <!--credit_card-->
<div class="clearfix"></div>
<!-- end payment optiones -->

</div>



</div>
</div>
<!-- end payments-->                 
                        
 <!--start return note-->
<div class="col-md-12">
<label for="payment_reference_no">Return Note</label> 
<textarea name="sl_rtn_note" rows="2" cols="10" class="ckeditor form-control" id="sl_rtn_note"></textarea>

<div style="height:15px; clear: both;"></div>   
</div>

<!--end start return note-->                      
                        
                        <div class="col-md-12">
                        <div class="modal-footer" style="margin-bottom:10px;">
            				<input type="submit" class="btn btn-primary" value="Return Sales" name="return_sale" id="return_sale"> <button id="reset" class="btn btn-danger" type="button">Reset</button>
            			</div>
                        </div>
                         <input name="sl_rtn_inv_discount_amount" type="hidden" id="sl_rtn_inv_discount_amount" value="<?php echo $sale_details['sale_inv_discount_amount'] ?>">
                         <input name="sl_rtn_total" type="hidden" id="sale_total" value="<?php echo $sale_details['sale_total'] ?>">
                         <input name="sale_paid" type="hidden" id="sale_paid" value="0">
                        <input name="sale_balance" type="hidden" id="sale_balance" value="0">
                        
                        <input name="warehouse_id" type="hidden" id="warehouse_id" value="<?php echo $sale_details['warehouse_id']; ?>">
                         <input name="customer_id" type="hidden" id="customer_id" value="<?php echo $sale_details['customer_id']; ?>">
                          <input name="sale_id" type="hidden" id="sale_id" value="<?php echo $sale_id;?>">
                          <input name="rowCount" type="hidden" id="rowCount" value="<?php echo $tmpcount ?>">
                         
                   		 </form>
									
							<!-- end: DYNAMIC TABLE PANEL -->
                           <div style="height:15px; clear: both;"></div>  
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


<input name="tmpVal" type="hidden" id="tmpVal" value="0">


		<!-- start ajax model -->
		<div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
		<!-- end ajax model -->
        
        

		<!-- start: MAIN JAVASCRIPTS -->
		<?php $this->load->view("common/footer"); ?>
        <script src="<?php echo asset_url(); ?>js/jquery-ui.js" ></script>		
	
		<script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script>
		
		<script type="text/javascript" src="<?php echo asset_url(); ?>js/perches.js"></script>
		<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>
        
        <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script>
         <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script>
          <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
        
        
		<!-- end: MAIN JAVASCRIPTS -->
        
 		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
		<script src="<?php echo asset_url(); ?>js/form-validation-create_sales_return.js"></script>
        <script src="<?php echo asset_url(); ?>js/sales.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
        
<script>

calculateTotal();


	$('#sl_rtn_datetime').datetimepicker({
		defaultDate: new Date()
		});
		

$('#add_item').keypress(function(e){
    if ( e.which == 13 ) return false;
    //or...
    if ( e.which == 13 ) e.preventDefault();
 }); 


function changeQtyByProductID(qty,nxtCount){
	//alert(qty+' '+nxtCount);
	var quantity_fld='#quantity_'+nxtCount;
	var product_id_fld='#product_id_'+nxtCount;
	if(isNaN(qty)) {
		displayNotice('page','Invalid Quantity');
		
		
		//alert(quantity_fld);
		var oldVal=$('#tmpVal').val();
		$(quantity_fld).val(oldVal); //set last val
	}else {
		//getavalable product count
		var product_id_fld='#product_id_'+nxtCount;
		var product_id=$(product_id_fld).val();
		var sale_id=$('#sale_id').val();
		
		var warehouse_id=$('#warehouse_id').val();
		$.get( "<?php echo base_url();?>sales_return/get_avalable_product_qty_for_return", { product_id: product_id, warehouse_id: warehouse_id,sale_id:sale_id,qty:qty } )
			.done(function( data ) {
				var obj = jQuery.parseJSON(data);
				if(obj.remmnaingQty){
					calculateTotal();
				}else{
					 bootbox.alert('Unexpected value provided!', function () { });
					
					var oldVal=$('#tmpVal').val();
					$(quantity_fld).val(oldVal); //set last val
				}
				
	   });
	   
		//end getavalable product count
		
		
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

function insertSalesReturnData(){
	
	
	var type='A';
	
	 var fields = $("#create_sales_return_form").serialize();
	  
	  var rowCount=$('#rowCount').val();

	  if(rowCount!=0){
		  $("#return_sale").prop("disabled", true);
		  $("#return_sale").val('Please wait...');

		 // create_sales_form.add_sale.disabled = true;
   		// create_sales_form.add_sale.value = "Please wait...";
    	//	return true;
	
	//alert(fields);
	//type:type, sale_reference_no:sale_reference_no
	$.post( "<?php echo base_url();?>sales_return/save_sales_return", fields)
	  .done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
				
				$('.alert-success').hide();
				$('.alert-danger').show();
				$( ".errortxt" ).html( obj.disMsg );
				window.scrollTo(600,200);
				//empty item table
				$("#return_sale").prop("disabled", false);
		  		$("#return_sale").val('Return Sale');
				
			}
			if(obj.error==0){
				//$('.alert-danger').hide();
				//$('.alert-success').show();
				//$( ".succetxt" ).text( obj.disMsg );
				window.scrollTo(500, 0);
				//$("#soTable tr:gt(0)").remove();
				$("#soTable > tbody").empty();
				displayNotice('page','Sale return successfully added!');
				
				//clearForm();
				//empty footer details
				
				//alert(obj.sale_id);
				sendUrl='sales/sales_return';
				//alert(sendUrl);
				
				setTimeout(function(){
  window.location.href = "<?php echo base_url();?>"+sendUrl;
}, 1000);

				
				
			}
			
			
	  });
return false;

	  }else  {
		 bootbox.alert('Please add products.', function () {
                        $('#add_item').focus();
                    });
	  }
	  
}

     
	 function changePayingby(val){

	   	$('.paying_by_details').hide();	
		if(val=='Credit Card'){
			$('#credit_card').show();	
		}
		if(val=='Cheque'){
			$('#cheque_dtls').show();	
		}
	 }		
</script>


	</body>
	<!-- end: BODY -->
</html>