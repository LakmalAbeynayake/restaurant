function extra_item_qty_change(id){
	//alert(id);
	qty_fld='#itm_qty_'+id;
	qty_val=($(qty_fld).val());
	
	if($.isNumeric(qty_val)){
		//alert(qty_val);
		calculateBookingGrandTotal();
	}
	else {
		//alert('err:'+qty_val);
		bootbox.alert('Invalid Quantity', function () {
           
         });
		$(qty_fld).val($('#tmpVal').val());
	}
}

function menu_amount_per_person_deduction_change(){
	//alert();
	qty_fld='#menu_amount_per_person_deduction';
	
	qty_val=($(qty_fld).val());
	//alert(qty_val);
	if($.isNumeric(qty_val)){
		//alert(qty_val);
		calculateBookingGrandTotal();
	}
	else {
		//alert('err:'+qty_val);
		bootbox.alert('Invalid Value', function () {
           
         });
		$(qty_fld).val($('#tmpVal').val());
	}
}




function calculateMenuItemSubTotal(){
	
	
	var rowCount=parseInt($('#rowCount_sr').val());
	//alert();
	
	var menu_item_tot_amount=0;
	var error=false;
	for(i=1; i<=rowCount; i++){
		
		
		price_fld='#price_'+i;
		var price=($(price_fld).val());
		
		extra_item_fld='#extra_item_'+i;
		var extra_item=($(extra_item_fld).val());
		//alert(extra_item);
		
		var itm_type='#itm_type_'+i;
		var itm_type=($(itm_type).val());
		
		//check is numaric
		///if(itm_type=='Extra')
		{
		if($.isNumeric(price)){
			if(extra_item=='Extra'){
				menu_item_tot_amount+=parseFloat(price);
			}
		}

		}
	}
	
	
	
	var bkng_head_count=parseFloat($('#bkng_head_count').val());
	var bkng_menu_amount_current=parseFloat($('#bkng_menu_amount').val());
	var menu_amount_per_person_deduction=parseFloat($('#menu_amount_per_person_deduction').val());
	var bkng_menu_amount=bkng_menu_amount_current-parseFloat($('#deleted_menu_item_amount').val());
	$('#deleted_menu_item_amount').val(0);
	
	
	
	
	/* calculate menu_item_tot_amount*/

	
	var menu_amount_per_person=0;
	var menu_items_sub_total=0;
	menu_items_sub_total=menu_item_tot_amount;
	menu_amount_per_person=bkng_menu_amount+menu_item_tot_amount+menu_amount_per_person_deduction;
	menu_item_tot_amount=menu_amount_per_person*bkng_head_count;
	//alert(menu_amount_per_person);
	
	
	$('#menu_items_sub_total').val(convertToAmount2Des(menu_items_sub_total));
	$('#bkng_menu_amount').val(convertToAmount2Des(bkng_menu_amount));
	$('#menu_amount_per_person').val(convertToAmount2Des(menu_amount_per_person));
	$('#menu_item_tot_amount').val(convertToAmount2Des(menu_item_tot_amount));
	
	/* calculate menu_item_tot_amount end*/
	
	
	//menu_amount_per_person=bkng_menu_amount;
	//menu_amount_per_person=parseFloat($('#menu_amount_per_person').val());
	//menu_item_tot_amount=menu_amount_per_person*bkng_head_count;
	
	
	//$('#bkng_menu_amount').val(convertToAmount2Des(bkng_menu_amount));
		//alert(bkng_menu_amount);
	
	//$('#menu_items_sub_total').val(convertToAmount2Des(menu_items_sub_total));
	//$('#menu_amount_per_person').val(convertToAmount2Des(menu_amount_per_person));
	//$('#menu_item_tot_amount').val(convertToAmount2Des(menu_item_tot_amount));
	//$('#bkng_extra_menu_item_amount').val(menu_item_tot_amount);
	//$('#bkng_extra_menu_item_amount_dis').text(convertToAmount(menu_item_tot_amount));
	//$('#bkng_extra_menu_item_amount_ftr').text(convertToAmount(menu_item_tot_amount));	
	//$('#service_sub_tot_dis').text(convertToAmount(service_sub_tot));	 convertToAmount2Des
	
	//$('#bkng_menu_amount').val(convertToAmount2Des(bkng_menu_amount));
}

/* start: Marquee JS */ //marquee
function marquee_item_qty_change(id){
	
	qty_fld='#bkng_itm_qty_m_'+id;
	qty_val=($(qty_fld).val());
	//alert(qty_val);
	if($.isNumeric(qty_val)){
		//alert(qty_val);
		calculateBookingGrandTotal();
	}
	else {
		//alert('err:'+qty_val);
		bootbox.alert('Invalid', function () {  
         });
		$(qty_fld).val($('#tmpVal').val());
	}
}

function marquee_item_width_change(id){
	
	qty_fld='#bkng_itm_width_m_'+id;
	//alert(qty_fld);
	qty_val=($(qty_fld).val());
	//alert(qty_val);
	if($.isNumeric(qty_val)){
		//alert(qty_val);
		calculateBookingGrandTotal();
	}
	else {
		//alert('err:'+qty_val);
		bootbox.alert('Invalid', function () {  
         });
		$(qty_fld).val($('#tmpVal').val());
	}
}

function marquee_item_length_change(id){
	
	qty_fld='#bkng_itm_length_m_'+id;
	//alert(qty_fld);
	qty_val=($(qty_fld).val());
	if($.isNumeric(qty_val)){
		calculateBookingGrandTotal();
	}
	else {
		bootbox.alert('Invalid', function () {  
         });
		$(qty_fld).val($('#tmpVal').val());
	}
}

function marquee_item_price_change(id){
	
	qty_fld='#bkng_itm_price_m_'+id;
	//alert(qty_fld);
	qty_val=($(qty_fld).val());
	if($.isNumeric(qty_val)){
		calculateBookingGrandTotal();
	}
	else {
		bootbox.alert('Invalid', function () {  
         });
		$(qty_fld).val($('#tmpVal').val());
	}
}

function deleteMarqueeItem(row_id){
	//alert(row_id);
	$("#myModal4").modal();
	$('#sel_id').val(row_id); 
	$('#popup_type').val('delete');
	$('#page').val('marquee_item');
	$("#label").text("Are you sure you want to delete this item?");
}


function calculateMarqueeItemTotal(){
	var rowCount=parseInt($('#rowCount_m').val());
	//alert(rowCount);
	var furniture_item_tot_amount=0;
	var qty_val_sub_tot=0;
	var error=false;
	var marquee_item_tot_amount=0;
	for(i=1; i<=rowCount; i++){
		//alert(i);
		//price 
		price_fld='#bkng_itm_price_m_'+i;
		price_val=($(price_fld).val());
		if($.isNumeric(price_val)){
			//qty_val_sub_tot=parseFloat(qty_val);
		}
		
		
		//set qty fld
		qty_fld='#bkng_itm_qty_m_'+i;
		var width_fld='#bkng_itm_width_m_'+i;
		var length_fld='#bkng_itm_length_m_'+i;
		var sqrtval=$(width_fld).val()*$(length_fld).val();
		$(qty_fld).val(convertToAmount2Des(sqrtval));
		//alert(qty_fld);
		
		//quntity 
		
		qty_val=($(qty_fld).val());
		if($.isNumeric(qty_val)){
			qty_val_sub_tot=parseFloat(qty_val);
		}	
		
		//set sub to val
		sub_tot_fld='#sub_tot_m_'+i;
		
		var sub_tot=price_val*qty_val;
		//alert(sub_tot);
		
		$(sub_tot_fld).val(convertToAmount2Des(sub_tot));
		
		if($.isNumeric(sub_tot)){
			marquee_item_tot_amount+=parseFloat(sub_tot);
		}
		else {

		}	
	}
	
	//alert(furniture_item_tot_amount);
	$('#marquee_item_tot_amount').val(convertToAmount2Des(marquee_item_tot_amount));
	$('#bkng_marquee_item_amount').val(convertToAmount(marquee_item_tot_amount));
	$('#bkng_marquee_item_amount_dis').text(convertToAmount2Des(marquee_item_tot_amount));
	
	$('#bkng_marquee_item_amount_ftr').text(convertToAmount2Des(marquee_item_tot_amount));
}
/* end: Marquee JS */

/* start: Furnitue JS */
function furniture_item_price_change(id){
	
	qty_fld='#bkng_itm_price_f_'+id;
	qty_val=($(qty_fld).val());
	//alert(qty_val);
	if($.isNumeric(qty_val)){
		//alert(qty_val);
		calculateBookingGrandTotal();
	}
	else {
		//alert('err:'+qty_val);
		bootbox.alert('Invalid', function () {  
         });
		$(qty_fld).val($('#tmpVal').val());
	}
}

function furniture_item_qty_change(id){
	
	qty_fld='#bkng_itm_qty_f_'+id;
	qty_val=($(qty_fld).val());
	//alert(qty_val);
	if($.isNumeric(qty_val)){
		//alert(qty_val);
		calculateBookingGrandTotal();
	}
	else {
		//alert('err:'+qty_val);
		bootbox.alert('Invalid Quantity', function () {  
         });
		$(qty_fld).val($('#tmpVal').val());
	}
}

function deleteFurnitureItem(row_id){
	//alert(row_id);
	$("#myModal4").modal();
	$('#sel_id').val(row_id); 
	$('#popup_type').val('delete');
	$('#page').val('furniture_item');
	$("#label").text("Are you sure you want to delete this extra item?");
}


function calculateFurnitureItemTotal(){
	var rowCount=parseInt($('#rowCount_f').val());
	//alert(rowCount);
	var furniture_item_tot_amount=0;
	var qty_val_sub_tot=0;
	var error=false;
	for(i=1; i<=rowCount; i++){
		
		//price 
		price_fld='#bkng_itm_price_f_'+i;
		price_val=($(price_fld).val());
		if($.isNumeric(price_val)){
			//qty_val_sub_tot=parseFloat(qty_val);
		}
		
		//quntity 
		qty_fld='#bkng_itm_qty_f_'+i;
		qty_val=($(qty_fld).val());
		if($.isNumeric(qty_val)){
			qty_val_sub_tot=parseFloat(qty_val);
		}	
		
		//set sub to val
		sub_tot_fld='#sub_tot_f_'+i;
		var sub_tot=price_val*qty_val;
		$(sub_tot_fld).val(convertToAmount2Des(sub_tot));
		
		if($.isNumeric(sub_tot)){
			furniture_item_tot_amount+=parseFloat(sub_tot);
		}
		else {

		}	
	}
	
	//alert(furniture_item_tot_amount);
	$('#furniture_item_tot_amount').val(convertToAmount2Des(furniture_item_tot_amount));
	$('#bkng_furniture_item_amount').val(convertToAmount2Des(furniture_item_tot_amount));
	$('#bkng_furniture_item_amount_dis').text(convertToAmount2Des(furniture_item_tot_amount));
	
	$('#bkng_furniture_item_amount_ftr').text(convertToAmount2Des(furniture_item_tot_amount));
}
/* end: Furnitue JS */

function calculateGrandTotal(){
	//alert();
	var bkng_head_count=parseFloat($('#bkng_head_count').val());
	//var bkng_menu_amount=parseFloat($('#bkng_menu_amount').val())*bkng_head_count;
	var bkng_menu_amount=parseFloat($('#menu_item_tot_amount').val());
	
	var bkng_extra_menu_item_amount=parseFloat($('#bkng_extra_menu_item_amount').val());
	var bkng_extra_item_amount=parseFloat($('#bkng_extra_item_amount').val());
	var bkng_furniture_item_amount=parseFloat($('#bkng_furniture_item_amount').val());
	var bkng_marquee_item_amount=parseFloat($('#bkng_marquee_item_amount').val());
	var bkng_tot_amount=0;
	//alert(bkng_tot_amount);
	//bkng_extra_menu_item_amount
	bkng_tot_amount=bkng_menu_amount+bkng_extra_item_amount+bkng_furniture_item_amount+bkng_marquee_item_amount;
	
	//alert(bkng_tot_amount);
	//alert(bkng_extra_menu_item_amount);
	var price=bkng_tot_amount;
	
	//start discount 
	var error=false;
	var discount_amt=0;
	var tmpDisVal=0;
	
//alert(bkng_tot_amount);
	
	//start per head discount 
	var error=false;
	var per_head_discount_amt=0;

	//set discount val
	$('#discount_td').hide();
	$('#discount_per_head_td').hide();
	$('#dscount_sub_tot_footer_dis').text(convertToAmount(tmpDisVal));
	$('#bkng_discount_value').val(tmpDisVal);
	if(tmpDisVal){ 
		$('#discount_td').show();
	}
	
	//set per head discount val
	$('#dscount_per_head_sub_tot_footer_dis').text(convertToAmount(per_head_tmpDisVal));
	$('#bkng_per_head_discount_value').val(per_head_tmpDisVal);
	if(per_head_tmpDisVal){ 
		$('#discount_per_head_td').show();
	}
	
	//alert(bkng_tot_amount);
	//display
	$('#bkng_tot_amount').val(bkng_tot_amount);
	$('#bkng_tot_amount_dis').text(convertToAmount(bkng_tot_amount));
	$('#bkng_tot_amount_ftr').text(convertToAmount(bkng_tot_amount));
	
}

function changeMainDiscount(val){
	//alert();
	calculateBookingGrandTotal();
}

function changePerHeadDiscount(){
	calculateBookingGrandTotal();
}

function calculateBookingGrandTotal(){
	
	return false;
	calculateMenuItemSubTotal();
	calculateExtraItemTotal();
	calculateFurnitureItemTotal();
	calculateMarqueeItemTotal()
	calculateGrandTotal();
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
		
if(page=='extra_item'){
	if(popup_type=='delete'){
		var tmp='#row_e_'+row_id;
		$(tmp).remove();
		displayNotice('Booking','Extra item has been deleted successfully!');
		calculateBookingGrandTotal(); 
	}
} //end page check

if(page=='furniture_item'){
	if(popup_type=='delete'){
		var tmp='#row_f_'+row_id;
		$(tmp).remove();
		displayNotice('Booking','Furniture item has been deleted successfully!');
		calculateBookingGrandTotal(); 
	}
} //end page check
                                                                                                     
if(page=='marquee_item'){
	if(popup_type=='delete'){
		var tmp='#row_m_'+row_id;
		$(tmp).remove();
		displayNotice('Booking','Marquee item has been deleted successfully!');
		calculateBookingGrandTotal(); 
	}
} //end page check

if(page=='menu_item'){
	if(popup_type=='delete'){
		var tmp='#row_sr_'+row_id;
		$(tmp).remove();
		displayNotice('Booking','Menu item has been deleted successfully!');
		calculateBookingGrandTotal();
	}
} //end page check
	
	});
	

});		

function deleteServiceItem(this){
	
	$(this).closest('tr').remove();
	displayNotice('Booking','Menu item has been deleted successfully!');
	calculateTotal();
	$("#save_form").click();
	return false;	
	
	//$("#label").text("Are you sure you want to delete this menu item?");
}
function deleteExtraItem(row_id){
	//alert(row_id);
	$("#myModal4").modal();
	$('#sel_id').val(row_id); 
	$('#popup_type').val('delete');
	$('#page').val('extra_item');
	$("#label").text("Are you sure you want to delete this extra item?");
}



function clearForm(){
	
	//$('#qtyTotal').text(convertToAmount(0));
	//('#sale_datetime').text('');
	//$('#sale_datetime').css("borderColor","#d5d5d5");
	//$('#warehouse_id').css("borderColor","#d5d5d5");
	//$('#customer_id').css("borderColor","#d5d5d5");
	//$('#tax_rate_id').css("borderColor","#d5d5d5");
	//$('#warehouse_id').val("");
	//$('#customer_id').val("");

	//$('#balance_dis').text(convertToAmount(0));
	//$('#Subtotal').text(convertToAmount(0));
	//set ref no
	getNextRefNo();
}





function addServiceToListByID(item_id,item_code,item_name,item_price){
	//alert('item_id:'+item_price);
	var customer_id=$('#customer_id').val();
	error=false;
	
	if(customer_id==''){
		//error=true;	
	}
	if(error){
		 bootbox.alert('Please select Customer before adding any service', function () {
            $('#add_item').focus();
         });
	}else {
	var rowCount_sr=$('#rowCount_sr').val();
	var nxtCount=parseInt(rowCount_sr)+1;
	$('#rowCount_sr').val(nxtCount);
	//alert(product_price);
	var vcl_srvs_price=vcl_srvs_price;
	var vcl_srvs_price_dis=convertToAmount(vcl_srvs_price);
	var sub_total_item=convertToAmount(vcl_srvs_price*1); //when add qty=1
	var discount_val=0;
	var discount_val_tot=0;
	
	var tmp_amount=0;
				
	//var product_part_no_txt='';
	//var product_oem_part_number_txt='';
	//if(product_part_no) product_part_no_txt=', Part No.:'+product_part_no;
	//if(product_oem_part_number) product_oem_part_number_txt=', OEM Part No.:'+product_oem_part_number;
	//alert(rowCount);
    $('#serviceTable tbody').prepend('<tr class="child" id="row_sr_'+nxtCount+'"><td>'+item_name+' ('+item_code+') '+'<input type="hidden" name="row_sr['+nxtCount+'][itm_type][]" value="Extra" id="itm_type_'+nxtCount+'"><span class="label label-info"> (Extra)</span><input type="hidden" name="row_sr['+nxtCount+'][extra_item][]" value="Extra" id="extra_item_'+nxtCount+'"><input type="hidden" class="form-control text-center rquantity" name="row_sr['+nxtCount+'][item_id][]" value="'+item_id+'" id="item_id_'+nxtCount+'"></td><td class="text-right"><input style="width:100%; text-align:right" type="text" name="row_sr['+nxtCount+'][bkng_itm_note][]" id="bkng_itm_note_'+nxtCount+'" value="">'+'</td><td class="text-right"><input readonly style="width:100px; text-align:right" type="text" name="row_sr['+nxtCount+'][price][]" id="price_'+nxtCount+'" value="'+item_price+'">'+'</td><td><a onclick="deleteServiceItem(this)"><i class="fa fa-times tip podel" id="1446800197032" title="Remove" style="cursor:pointer;"></i></a></td></tr>');
    	calculateTotal();
    } //end error check
}

function addFurnitureToListByID(item_id,item_code,item_name,item_price){
	//alert('item_id:'+item_id);
	var customer_id=$('#customer_id').val();
	error=false;
	
	if(customer_id==''){
		//error=true;	
	}
	if(error){
		 bootbox.alert('Please select Customer before adding any service', function () {
            $('#add_item').focus();
         });
	}else {
	var rowCount_sr=$('#rowCount_sr').val();
	var nxtCount=parseInt(rowCount_sr)+1;
	$('#rowCount_sr').val(nxtCount);
	//alert(product_price);
	var vcl_srvs_price=vcl_srvs_price;
	var vcl_srvs_price_dis=convertToAmount(vcl_srvs_price);
	var sub_total_item=convertToAmount(vcl_srvs_price*1); //when add qty=1
	var discount_val=0;
	var discount_val_tot=0;
	//var product_part_no_txt='';
	//var product_oem_part_number_txt='';
	//if(product_part_no) product_part_no_txt=', Part No.:'+product_part_no;
	//if(product_oem_part_number) product_oem_part_number_txt=', OEM Part No.:'+product_oem_part_number;
	//alert(rowCount);
$('#FurnitureTable tbody').prepend('<tr class="child" id="row_sr_'+nxtCount+'"><td>'+item_name+' ('+item_code+') <span class="label label-success">(Extra menu item)</span>'+'<input type="hidden" name="row_sr['+nxtCount+'][itm_type][]" value="Extra" id="itm_type_'+nxtCount+'"><input type="hidden" class="form-control text-center rquantity" name="row_sr['+nxtCount+'][item_id][]" value="'+item_id+'" id="item_id_'+nxtCount+'"></td><td class="text-right"><input readonly style="width:100px; text-align:right" type="text" name="row_sr['+nxtCount+'][price][]" id="price_'+nxtCount+'" value="'+item_price+'">'+'</td><td><a onclick="deleteServiceItem('+nxtCount+')"><i class="fa fa-times tip podel" id="1446800197032" title="Remove" style="cursor:pointer;"></i></a></td></tr>');
	calculateTotal();
} //end error check
}

function changeDiscountByProductID(discount,nxtCount,product_id){
	calculateTotal();
}

function changePaidValue(paid){
	if(isNaN(paid)) {
		displayNotice('page','Invalid Paid Amount');
		
		//alert(quantity_fld);
		var oldVal=$('#tmpVal').val();
		$('#paid').val(oldVal); //set last val
	}else{
		
		calculateTotal();
		$('#paid').val(convertToAmount(paid));
		
	}	
}

/* check is added produtct */
function isAddedProduct(pid){
	
	//alert(pid);
	var rowCount=parseInt($('#rowCount_sr').val());
	for(i=1; i<=rowCount; i++){
		var product_fld='#item_id_'+i; 
		//alert(product_fld);
		var product_id=parseInt($(product_fld).val());
		if(product_id==pid){
			//change qty
			//var quantity_fld='#quantity_'+i;
			//var quantity_val=parseFloat($(quantity_fld).val());
			//$(quantity_fld).val(quantity_val+1)
			
			
			//alert('updated qty');
			return 1;
		}else{
			//alert('no');	
			//return 0;
		}
		
	}
}

/* check is added produtct */
function isExtraAddedProduct(pid){
	
	//alert(pid);
	var rowCount=parseInt($('#rowCount_e').val());
	for(i=1; i<=rowCount; i++){
		var product_fld='#extra_item_'+i; 
		//alert(product_fld);
		var product_id=parseInt($(product_fld).val());
		if(product_id==pid){
			//change qty
			//var quantity_fld='#quantity_'+i;
			//var quantity_val=parseFloat($(quantity_fld).val());
			//$(quantity_fld).val(quantity_val+1)
			
			
			//alert('updated qty');
			return 1;
		}else{
			//alert('no');	
			//return 0;
		}
		
	}
}



function setTmpVal(val){
	$('#tmpVal').val(val); 
}

function convertToAmount(val)
{
	var disval=val; //+'.00'; //.toFixed(val);
	return accounting.formatMoney(disval, "", 2, ",", "."); // €4.999,99 
}

function convertToAmount2Des(val)
{
	var disval=val; //+'.00'; //.toFixed(val);
	return accounting.formatMoney(disval, "", 2, "", "."); // €4.999,99 
}



/* end check is added produtct */

function calculateTotal(){
	//alert('test');
	
	//get row
	var rowCount=parseInt($('#rowCount').val());
	var quantity_tot=0;
	var product_price_tot=0;
	var subtotal=0;
	var subtotal_item=0;
	var balance=0;
	var paid=0;

	for(i=1; i<=rowCount; i++){
		var quantity_fld='';
		quantity_fld='#quantity_'+i;
		subtotal_fld='#subtotal_'+i;
		discount_fld='#discount_'+i;
		discount_val_fld='#discount_val_'+i;
		product_price_fld='#product_price_'+i;
		gross_total_fld='#gross_total_'+i;
		var quantity_val=parseFloat($(quantity_fld).val());
		var discount_val=parseFloat($(discount_fld).val());
		var product_price_val=parseFloat($(product_price_fld).val());
		var paid=parseFloat($('#paid').val());
		var sale_inv_discount=($('#sale_inv_discount').val());
		

		//if(isNaN(quantity_val)) 
		{
		}
		//else
		 {
			//alert(quantity_fld+':'+quantity_val);
			quantity_tot=quantity_tot+quantity_val;
			
			//set item total
			 var price=0, afterDiscount=0;
    		 price = product_price_val*quantity_val;
        	// discount = Number(discount);
 			//afterDiscount=price - ( price*discount_val/100 );
			//set discount_val
			//$(discount_val_fld).val((price*discount_val/100));
			
			
			/* calculate discount*/
			
			
			
			
			
			//text box exist check, for when delete item
			if($(discount_fld).length){
				ds=$(discount_fld).val();
			}else {
				ds='';
			}
			//set temp val
			//$('#tmpVal').val(ds);
			
			var error=false;
			tmpDisVal=0;
			
			if (ds.indexOf("%") !== -1) {
				var pds = ds.split("%");
		 		if (!isNaN(pds[0])) {
			 		afterDiscount = price - ( price*pds[0]/100 );
					tmpDisVal=price*pds[0]/100;
				}else{
					error=true;
				}
			}else{
				if (!isNaN(ds)) {
					afterDiscount = price - ds;
					tmpDisVal=ds;
				}else{
					error=true;
				}
			}
						
			
			
			if(error){
				$(discount_fld).val($('#tmpVal').val());
				bootbox.alert('Error! Invalid Discount', function () {   });
				//set old value
				ds=$('#tmpVal').val();
				if (ds.indexOf("%") !== -1) {
					var pds = ds.split("%");
					if (!isNaN(pds[0])) {
						afterDiscount = price - ( price*pds[0]/100 );
						tmpDisVal=price*pds[0]/100;
					}else{
						error=true;
					}
				}else{
					if (!isNaN(ds)) {
						afterDiscount = price - ds;
						tmpDisVal=ds;
					}else{
						error=true;
					}
				}

			}
			//Set discount fld value
			$(discount_val_fld).val(tmpDisVal);
			
			$(gross_total_fld).val((afterDiscount));
			$(subtotal_fld).text(convertToAmount(afterDiscount));
			
			/* end calculate discount*/
		}
		
		
		var product_price_fld='';
		product_price_fld='#product_price_'+i;
		var product_price_val=parseFloat($(product_price_fld).val());

		if(isNaN(product_price_val)) {
		}else {
			subtotal=subtotal+(afterDiscount);
		}
		

	}
	

		
	//discount calculation
	var inv_discount=0;
	//if(isNaN(sale_inv_discount)) 
	{
		
	}
	//else
	 {
		//var tds=sale_inv_discount;
		//inv_discount=sale_inv_discount;
		//subtotal=subtotal-inv_discount;
		
			var item_discount = 0,
			discount=sale_inv_discount;
			//alert(discount);
                ds = discount ? discount : '0';
				
				//var str = "Hello world, % to the universe.";
    			var n = ds.indexOf("%");
				//alert(n);
				
				//if (ds.indexOf("%") !== -1) 
				{
					
				}
			
			//alert(ds);	
            if (ds.indexOf("%") !== -1) {
                var pds = ds.split("%");
				//alert(pds[0]);
                if (!isNaN(pds[0])) {
					//alert(pds[0]);
					if(pds[0]==''){
                    	alert('invalid discount');
						$('#sale_inv_discount').val();
					} else if(pds[0]=='%'){
						alert('invalid discount');
						$('#sale_inv_discount').val();
					} else {
						inv_discount = parseFloat(((subtotal) * parseFloat(pds[0])) / 100);
					}
                } else {
                    alert('invalid discount');
					$('#sale_inv_discount').val();
                }
            } else {
				if(isNaN(ds)) {
					alert('invalid discount');
					$('#sale_inv_discount').val();
				}else {
					inv_discount=ds;
				}
               // inv_discount = parseFloat(ds);
            }
			//alert(item_discount);
	}		
	
	
	var gross_total=subtotal; //set grand total
	subtotal=subtotal-inv_discount;
	
	//display val
	$('#qtyTotal').text(convertToAmount(quantity_tot));
	$('#Subtotal').text(convertToAmount(gross_total));
	//if(balance>0)
	{
	$('#balance_dis').text(convertToAmount(balance));
	}
	$('#sale_total').val(subtotal);
	$('#sale_paid').val(paid);
	$('#sale_balance').val(balance);
	$('#sale_inv_discount_amount').val(inv_discount);
	

	
	//alert(sale_inv_discount);
	
	//footer amount bar
	$('#titems').text(quantity_tot);
	$('#gtotal').text(convertToAmount(subtotal));
	$('#tds').text(convertToAmount(inv_discount));
	$('#f_total').text(convertToAmount(gross_total));
	
	
	
}

for (var key in localStorage) {		
  //console.log(key + ':' + localStorage[key]);
}


$('#comment').keypress(function(event){

    if (event.keyCode == 10 || event.keyCode == 13) 
        event.preventDefault();

  });
  
  
//************** reset function *******

    $('#reset').click(function(e) {
        bootbox.confirm("Are you sure?", function(result) {
            if (result) {
             
               $('body').modalmanager('loading');
                location.reload();
            }
        });
    });


//************** end reset function ***
  