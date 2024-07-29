function calculateExtraItemSubTotal(){
	
	var rowCount=parseInt($('#rowCount_e').val());
	var service_sub_tot=0;
	var error=false;
	for(i=1; i<=rowCount; i++){
		
		
		price_fld='#price_'+i;
		var price=($(price_fld).val());
		
		//check is numaric
		if($.isNumeric(price)){
			service_sub_tot+=parseFloat(price);
		}
		else {

		}	
	}	
	
	$('#service_sub_tot').val(service_sub_tot);
	$('#service_sub_tot_dis').text(convertToAmount(service_sub_tot));
	
}

function calculateExtraItemGrandTotal(){
	
	
	//alert();
	calculateExtraItemSubTotal();
	calculateTechnicianSubTotal();
	
	calculateTotal();
	
	//set parts sub total 
	var parts_sub_tot=$('#parts_sub_tot').val();
	$('#Subtotal').text(convertToAmount(parts_sub_tot));
	
	
	
	var service_sub_tot=parseFloat($('#service_sub_tot').val());	
	var technician_sub_tot=parseFloat($('#technician_sub_tot').val());	
	var parts_sub_tot=parseFloat($('#parts_sub_tot').val());
	
	var grand_total_sub_tot=service_sub_tot+technician_sub_tot+parts_sub_tot;
	
	
	
	
	

	//set val
	$('#service_sub_tot_footer_dis').text(convertToAmount(service_sub_tot));
	$('#service_sub_tot_summ_dis').text(convertToAmount(service_sub_tot));
	
	$('#technician_sub_tot_footer_dis').text(convertToAmount(technician_sub_tot));
	$('#technician_sub_tot_summ_dis').text(convertToAmount(technician_sub_tot));
	
	$('#parts_sub_tot_footer_dis').text(convertToAmount(parts_sub_tot));
	$('#parts_sub_tot_summ_dis').text(convertToAmount(parts_sub_tot));
	
	$('#grand_total_sub_tot_footer_dis').text(convertToAmount(grand_total_sub_tot));
	$('#grand_total_sub_tot_summ_dis').text(convertToAmount(grand_total_sub_tot));
	$('#grand_total').val((grand_total_sub_tot));
	
	
	
	//alert(service_sub_tot);
	
}


	jQuery(document).ready(function() {
		
		FormValidator.init();
		
		//hide error box
		$('.alert-danger').hide();
	});
	
	jQuery(document).ready(function() {
		
		
		
		
	//conirm
	$( "#conirm" ).click(function() {
		var sel_id=$('#sel_id').val(); 
		var popup_type=$('#popup_type').val();
		var page=$('#page').val();
		var row_id=sel_id;
		
if(page=='vehicle_service'){
	if(popup_type=='delete'){
		var tmp='#row_sr_'+row_id;
		$(tmp).remove();
		displayNotice('page','ExtraItem item has been deleted successfully!');
		calculateTotal(); 
	}
} //end page check
	
	});
	

});		

function deleteExtraItemItem(row_id){
	$("#myModal4").modal();
	$('#sel_id').val(row_id); 
	$('#popup_type').val('delete');
	$('#page').val('vehicle_service');
	$("#label").text("Are you sure you want to delete this service item?");
}

function clearForm(){
	
	$('#qtyTotal').text(convertToAmount(0));
	//('#sale_datetime').text('');
	$('#sale_datetime').css("borderColor","#d5d5d5");
	$('#warehouse_id').css("borderColor","#d5d5d5");
	$('#customer_id').css("borderColor","#d5d5d5");
	//$('#tax_rate_id').css("borderColor","#d5d5d5");
	//$('#warehouse_id').val("");
	$('#customer_id').val("");

	$('#balance_dis').text(convertToAmount(0));
	$('#Subtotal').text(convertToAmount(0));
	//set ref no
	getNextRefNo();
}











//************** end reset function ***
  