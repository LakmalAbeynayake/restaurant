
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
		
		alert(quantity_val);

		
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


function setTmpVal(val){
	//alert(1);
	$('#tmpVal').val(val); 
}

function convertToAmount(val)
{
	var disval=val; //+'.00'; //.toFixed(val);
	return accounting.formatMoney(disval, "", 2, ",", "."); // €4.999,99 
}
