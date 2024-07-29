

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
		
if(page=='sale_add'){
	if(popup_type=='delete'){
		var tmp='#row_'+row_id;
		$(tmp).remove();
		displayNotice('page','Product item has been deleted successfully!');
		calculateTotal(); 
	}
} //end page check
	
	});
	

});		

function deleteSalesItem(row_id){
	//alert(row_id);
	$("#myModal4").modal();
	$('#sel_id').val(row_id); 
	$('#popup_type').val('delete');
	$('#page').val('sale_add');
	$("#label").text("Are you sure you want to delete this product item?");
}

function clearForm(){
	
	$('#qtyTotal').text(convertToAmount(0));
	//('#sale_datetime').text('');
	$('#sale_datetime').css("borderColor","#d5d5d5");
	$('#warehouse_id').css("borderColor","#d5d5d5");
	$('#customer_id').css("borderColor","#d5d5d5");
	//$('#tax_rate_id').css("borderColor","#d5d5d5");
	//$('#warehouse_id').val("");
	//$('#customer_id').val("");

	$('#balance_dis').text(convertToAmount(0));
	$('#Subtotal').text(convertToAmount(0));
	//set ref no
	getNextRefNo();
}


function deleteRentItem(row_id){
	
	var val ='#row_e_'+row_id;
	
	$(val).remove(); 

}


function addProductToListByID(product_id,product_name,product_code,product_price,product_part_no,product_oem_part_number,item_cost){
	//alert(product_id);
	var customer_id=$('#customer_id').val();
	error=false;
	
	if(customer_id==''){
		error=true;	
	}
	if(error){
		 bootbox.alert('Please select Customer before adding any product', function () {
            $('#add_item').focus();
         });
	}else {
	var rowCount=$('#rowCount').val();
	var nxtCount=parseInt(rowCount)+1;
	$('#rowCount').val(nxtCount);
	//alert(product_price);
	var product_price=product_price;
	var product_price_dis=convertToAmount(product_price);
	var sub_total_item=convertToAmount(product_price*1); //when add qty=1
	var discount_val=0;
	var discount_val_tot=0;
	var product_part_no_txt='';
	var product_oem_part_number_txt='';
	if(product_part_no) product_part_no_txt=', SAP Code.:'+product_part_no;
	//if(product_oem_part_number) product_oem_part_number_txt=', OEM Part No.:'+product_oem_part_number;
	//alert(rowCount);
$('#soTable tbody').prepend('<tr class="child" id="row_'+nxtCount+'"><td>'+product_name+' ('+product_code+')'+product_part_no_txt+product_oem_part_number_txt+'<input type="hidden" class="form-control text-center rquantity" name="row['+nxtCount+'][product_id][]" value="'+product_id+'" id="product_id_'+nxtCount+'"></td><td class="text-right"><input type="hidden" name="row['+nxtCount+'][unit_price][]" id="product_price_'+nxtCount+'" value="'+product_price+'"><input type="hidden" name="row['+nxtCount+'][item_cost][]" id="item_cost_'+nxtCount+'" value="'+item_cost+'">'+product_price_dis+'</td><td><input type="text" class="form-control text-center rquantity" name="row['+nxtCount+'][qty][]" value="1" id="quantity_'+nxtCount+'" onclick="this.select(); setTmpVal(this.value);" onchange="changeQtyByProductID(this.value,'+nxtCount+');"></td><td class="text-right"><span class="text-right sdiscount text-danger" id="sdiscount_1446800197032"><input type="text" name="row['+nxtCount+'][discount][]" value="0" id="discount_'+nxtCount+'" onclick="this.select(); setTmpVal(this.value);" onchange="changeDiscountByProductID(this.value,'+nxtCount+');" style="width:50px;"> </span><input type="hidden" name="row['+nxtCount+'][discount_val][]" value="'+discount_val+'" id="discount_val_'+nxtCount+'"><input type="hidden" name="row['+nxtCount+'][discount_val_tot][]" value="'+discount_val_tot+'" id="discount_val_tot_'+nxtCount+'"></td><td class="text-right"><span class="text-right ssubtotal" id="subtotal_'+nxtCount+'">'+sub_total_item+'</span><input type="hidden" name="row['+nxtCount+'][gross_total][]" value="0" id="gross_total_'+nxtCount+'">&nbsp;</td><td><a onclick="deleteSalesItem('+nxtCount+')"><i class="fa fa-times tip podel" id="1446800197032" title="Remove" style="cursor:pointer;"></i></a></td></tr>');
	
	//$.post( "<?php echo base_url();?>sales/add_sales_item_to_list", product_id:product_id)
	//	  var obj = jQuery.parseJSON(data);

	//  });		
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



function setTmpVal(val){
	//alert(1);
	$('#tmpVal').val(val); 
}

function convertToAmount(val)
{
	var disval=val; //+'.00'; //.toFixed(val);
	return accounting.formatMoney(disval, "", 2, ",", "."); // €4.999,99 
}

function changeMainDiscount(val){
	//alert(val);
	calculateTotal();
}

/* check is added produtct */
function isAddedProduct(pid){
	
	//alert(pid);
	var rowCount=parseInt($('#rowCount').val());
	for(i=1; i<=rowCount; i++){
		var product_fld='#product_id_'+i; 
		//alert(product_fld);
		var product_id=parseInt($(product_fld).val());
		if(product_id==pid){
			//change qty
			var quantity_fld='#quantity_'+i;
			var quantity_val=parseFloat($(quantity_fld).val());
			$(quantity_fld).val(quantity_val+1)
			
			//alert('updated qty');
			return 1;
		}else{
			//alert('no');	
			//return 0;
		}
		
	}
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
	var cost_total=0;
	
	var po_total=0;
	var po_discount=0;
	var po_discount_amt=0;
	var po_vat=0;
	var po_net_total=0;

	for(i=1; i<=rowCount; i++){
		//alert();
		var quantity_fld='';
		var cost_fld='';
		quantity_fld='#serviceitm_qty_'+i;
		var item_cost_fld='#itm_charge_type_'+i;
		subtotal_fld='#sub_total_item_'+i;
		discount_fld='#serviceitm_dis_'+i;
		discount_val_fld='#serviceitm_dis_val_'+i;
		product_price_fld='#itm_charge_type_'+i;
		gross_total_fld='#gross_total_'+i;
		var quantity_val=parseFloat($(quantity_fld).val());
		var item_cost_val=parseFloat($(item_cost_fld).val());
		var discount_val=parseFloat($(discount_fld).val());
		var product_price_val=parseFloat($(product_price_fld).val());
		var paid=parseFloat($('#paid').val());
		var sale_inv_discount=($('#service_discount').val());
		
		//alert(quantity_val);

		
		//else
		 {
			//alert(quantity_fld+':'+quantity_val);
			quantity_tot=quantity_tot+quantity_val;
			
			if(item_cost_val) {
			cost_total=cost_total+(item_cost_val*quantity_val);
		 }
			
			//alert(product_price_val);
			//set item total
			 var price=0, afterDiscount=0;
    		 price = product_price_val*quantity_val;
			 //alert(price+':'+product_price_val+':'+quantity_val);
        	// discount = Number(discount);
 			//afterDiscount=price - ( price*discount_val/100 );
			//set discount_val
			//$(discount_val_fld).val((price*discount_val/100));
			
			
			/* calculate discount*/
			
			
			//alert(price);
			
			
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
					//alert(2);	
			 		afterDiscount = price - ( price*pds[0]/100 );
					tmpDisVal=price*pds[0]/100;
				}else{
					error=true;
				}
			}else{
				if (!isNaN(ds)) {
					//alert(price);	
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
			
			$('#cost_total').val((cost_total));
			$(gross_total_fld).val((afterDiscount));
			$(subtotal_fld).val(convertToAmount(afterDiscount));
			
			//alert(tmpDisVal);
			/* end calculate discount*/
		}
		//alert(afterDiscount);
		
		//var product_price_fld='';
		//product_price_fld='#product_cost_'+i;
		var product_price_val=parseFloat($(product_price_fld).val());

		if(isNaN(product_price_val)) {
		}else {
			
			subtotal=subtotal+afterDiscount;
		}
		
		//alert('tot: '+subtotal);
		$('#service_total').val(subtotal);
		//alert(subtotal);

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
	//alert(inv_discount);
	subtotal=subtotal-inv_discount;
	
	
	
	

	


	
	
	
	//set cursser to update qty
	
	var tmp=$("#rowCount").val();
	var tmpFld="#quantity_"+tmp;
	//$(tmpFld).focus();
	//$(tmpFld).select();
	
	//display po details
	//alert(subtotal);
	po_total=subtotal;
	po_net_total=subtotal;
	
	//$('#po_total').val(po_total);
	//$('#po_discount').val(po_discount);
	$('#service_discount_amt').val(inv_discount);
	//$('#service_vat').val(po_vat);
	$('#service_net_total').val((po_net_total));
	
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
  