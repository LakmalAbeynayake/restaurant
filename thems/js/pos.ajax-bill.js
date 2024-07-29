
         var site = {"base_url":"http:\/\/localhost/inventry_pos\/","settings":{"logo":"logo2.png","logo2":"logo3.png","site_name":"Stock Manager Advance","language":"english","default_warehouse":"1","accounting_method":"0","default_currency":"USD","default_tax_rate":"1","rows_per_page":"10","version":"3.0.1.20","default_tax_rate2":"1","dateformat":"5","sales_prefix":"SALE","quote_prefix":"QUOTE","purchase_prefix":"PO","transfer_prefix":"TR","delivery_prefix":"DO","payment_prefix":"IPAY","return_prefix":"RETURNSL","expense_prefix":null,"item_addition":"0","theme":"default","product_serial":"1","default_discount":"1","product_discount":"1","discount_method":"1","tax1":"1","tax2":"1","overselling":"0","iwidth":"800","iheight":"800","twidth":"60","theight":"60","watermark":"0","smtp_host":"pop.gmail.com","bc_fix":"4","auto_detect_barcode":"1","captcha":"0","reference_format":"2","racks":"1","attributes":"1","product_expiry":"0","decimals":"2","decimals_sep":".","thousands_sep":",","invoice_view":"0","default_biller":null,"rtl":"0","each_spent":null,"ca_point":null,"each_sale":null,"sa_point":null,"sac":"0","qty_decimals":"2","display_all_products":"0"},"dateFormats":{"js_sdate":"dd\/mm\/yyyy","php_sdate":"d\/m\/Y","mysq_sdate":"%d\/%m\/%Y","js_ldate":"dd\/mm\/yyyy hh:ii","php_ldate":"d\/m\/Y H:i","mysql_ldate":"%d\/%m\/%Y %H:%i"}}, pos_settings = {"pos_id":"1","cat_limit":"22","pro_limit":"20","default_category":"1","default_customer":"1","default_biller":"3","display_time":"1","cf_title1":"GST Reg","cf_title2":"VAT Reg","cf_value1":"123456789","cf_value2":"987654321","receipt_printer":"BIXOLON SRP-350II","cash_drawer_codes":"x1C","focus_add_item":"Ctrl+F3","add_manual_product":"Ctrl+Shift+M","customer_selection":"Ctrl+Shift+C","add_customer":"Ctrl+Shift+A","toggle_category_slider":"Ctrl+F11","toggle_subcategory_slider":"Ctrl+F12","cancel_sale":"F4","suspend_sale":"F7","print_items_list":"F9","finalize_sale":"F8","today_sale":"Ctrl+F1","open_hold_bills":"Ctrl+F2","close_register":"Ctrl+F10","keyboard":"1","pos_printers":"BIXOLON SRP-350II, BIXOLON SRP-350II","java_applet":"0","product_button_color":"default","tooltips":"1","paypal_pro":"0","stripe":"0","rounding":"0","char_per_line":"42","pin_code":null};
         var lang = {unexpected_value: 'Unexpected value provided!', select_above: 'Please select above first', r_u_sure: 'Are you sure?'};
      

setInterval(function () {
			 if(localStorage.getItem('gtotal'))
			    $("span#gtotal").text(formatMoney(localStorage.getItem('gtotal')));
				
			 if (localStorage.getItem('reload')){
				 localStorage.clear();
				 window.location.reload();
				 }
			if(localStorage.getItem('posdiscount')){
				order_discount = localStorage.getItem('posdiscount');
				$("input#posdiscount").val(order_discount);
				$('#tds').text(order_discount);
			}
			if (localStorage.getItem('positems')) {
				$("#posTable tbody").empty();
				positems = JSON.parse(localStorage.getItem('positems'));
				//console.log();
				pos_settings.item_order =1;
				if (pos_settings.item_order == 1) {
					sortedItems = _.sortBy(positems, function(o){ return [parseInt(o.category), parseInt(o.order)]; } );
				}
            $.each(sortedItems, function () {
				var item = this;
				var pos = JSON.parse(localStorage.getItem('positems'));
				item.row.p_price = pos[item.item_id].p_price;
				loadItems(item);
/*-----------
DMP
------------*/
 var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
                positems[item_id] = item;
                item.order = item.order ? item.order : new Date().getTime();
                var product_id = item.row.id, item_type = item.row.type, combo_items = item.combo_items, item_price = item.row.price, item_qty = item.qty, item_aqty = item.row.quantity, item_tax_method = item.row.tax_method, item_ds = item.row.discount, item_discount = 0, item_option = item.row.option, item_code = item.row.code, item_serial = item.row.serial, item_name = item.row.product_name.replace(/"/g, "&#034;").replace(/'/g, "&#039;");
                var product_unit = item.row.unit, base_quantity = item.row.base_quantity;
                var unit_price = item.row.real_unit_price;
                if(item.row.fup != 1 && product_unit != item.row.base_unit) {
				    $.each(item.units, function(){
                        if (this.id == product_unit) {
                            base_quantity = formatDecimal(unitToBaseQty(item.row.qty, this), 4);
                            unit_price = formatDecimal((parseFloat(item.row.base_unit_price)*(unitToBaseQty(1, this))), 4);
                        }
                    });
                }
/*-----------
------------*/
			});
			
			}else {
				if(localStorage.getItem('clear')){
					$("#posTable tbody").empty();
				}
			}
			grand_total_cal();
		},1000);
	
		
          
  $(document).ready( function() {
		
		$(window).resize();
		$(".pos-tip").tooltip();
		$("#poswarehouse").select2();
		$("#poscustomer").select2();
		$('#add_item').focus();
		$('#content').css("background-color","#FFF");
		$('#leftdiv').css("background-color","#f4f4f4");
		$('#cpinner').css("background-color","#f4f4f4");
		$('#product-list').css("min-height", 90);
		$('#left-middle').css("background-color","#FFF");
		$('table >thead >tr >th').css("background-color","#FFF").css("color","#000").css("border-top-color","#FFF").css("border-bottom-color","#000");
		
		var date = new Date();
		if(date.getMonth() != 11)
		$('.snow').css("display","none");
		widthFunctions();
		});
		  
function isAddedProduct(pid){
var rowCount= $("#posTable > tbody > tr").length;

for(i=1; i<=rowCount; i++){
		var product_fld='#product_id_'+i; 
		//alert(product_fld);
		var product_id=parseInt($(product_fld).val());
		if(product_id==pid){
		if(localStorage.getItem('qty')){
				 var qty = JSON.parse(localStorage.getItem('qty'))
				 
					var new_qty       = qty.new_qty;
					var item_id       = qty.item_id;
					var product_price = qty.product_price; 
					//console.log(item_id);
				//alert(new_qty);
					$('#quantity_'+item_id+'').val(new_qty);
					$('#subtotal_'+item_id+'').text(formatMoney(parseFloat(product_price) * parseFloat(new_qty)));
					$('#ssubtotal_'+item_id+'').val(parseFloat(product_price) * parseFloat(new_qty));
					grand_total_cal();
					localStorage.removeItem('qty');
				 }
			return 1;
		}
	}
}

		  		  
 $(window).bind("resize", widthFunctions);

function widthFunctions(e) {
	var wh = $(window).height(),
	lth = $('#left-top').height(),
	lbh = $('#left-bottom').height();
	wh -= 60;
	$('#item-list').css("height", wh - 110);
	$('#item-list').css("min-height", 568);
	$('#left-middle').css("height", wh - lbh - 100);
	$('#left-middle').css("min-height", 478);
	$('#product-list').css("height", wh - lbh - 105);
	$('#product-list').css("min-height", 478);
	$('#poswarehouse').css("width", $('#left-middle').width());
	$('#poscustomer').css("width", $('#left-middle').width());
	}

function getNumber(x) {
    return accounting.unformat(x);
}

function formatQuantity(x) {
    return (x != null) ? '<div class="text-center">' + formatNumber(x, site.settings.qty_decimals) + '</div>' : '';
}

function formatNumber(x, d) {
    if (!d && d != 0) {
        d = site.settings.decimals;
    }
    if (site.settings.sac == 1) {
        return formatSA(parseFloat(x).toFixed(d));
    }
    return accounting.formatNumber(x, d, site.settings.thousands_sep == 0 ? ' ' : site.settings.thousands_sep, site.settings.decimals_sep);
}

function formatMoney(x, symbol) {
    if (!symbol) {
        symbol = "";
    }
    if (site.settings.sac == 1) {
        return symbol + '' + formatSA(parseFloat(x).toFixed(site.settings.decimals));
    }
    return accounting.formatMoney(x, symbol, site.settings.decimals, site.settings.thousands_sep == 0 ? ' ' : site.settings.thousands_sep, site.settings.decimals_sep, "%s%v");
}

function formatDecimal(x) {
    return parseFloat(parseFloat(x).toFixed(site.settings.decimals));
}

function is_valid_discount(mixed_var) {
    return (is_numeric(mixed_var) || (/([0-9]%)/i.test(mixed_var))) ? true : false;
}

function is_numeric(mixed_var) {
    var whitespace = " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
    return (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -
        1)) && mixed_var !== '' && !isNaN(mixed_var);
}

function is_float(mixed_var) {
    return +mixed_var === mixed_var && (!isFinite(mixed_var) || !!(mixed_var % 1));
}

function currencyFormat(x) {
    if (x != null) {
        return formatMoney(x);
    } else {
        return '0';
    }
}

function formatSA(x) {
    x = x.toString();
    var afterPoint = '';
    if (x.indexOf('.') > 0)
        afterPoint = x.substring(x.indexOf('.'), x.length);
    x = Math.floor(x);
    x = x.toString();
    var lastThree = x.substring(x.length - 3);
    var otherNumbers = x.substring(0, x.length - 3);
    if (otherNumbers != '')
        lastThree = ',' + lastThree;
    var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;
    return res;
}

//var positems = {};
function add_invoice_item(item) {
    loadItems(item);
}



/*if (typeof(Storage) === "undefined") {
    $(window).bind('beforeunload', function(e) {
        if (count > 1) {
            var message = "You will loss data!";
            return message;
        }
    });
}*/

function loadItems(item) {
	var rowCount= $("#posTable > tbody > tr").length;
	rowCount++;
    var row_no = rowCount;// Math.floor((Math.random() * 1000) + 1);
    var tr_html;
    var newTr = $('<tr id="row_'+row_no+'" class="row_'+row_no+'" data-item-id="'+row_no+'"></tr>');
        tr_html  = '<td><strong>'+item.label+'</strong></td>';
        tr_html += '<td class="text-right"><strong>'+formatMoney(item.row.product_price)+'</strong></td>';
        tr_html += '<td style="text-align:center"><strong>'+item.qty+'</strong></td>';
        tr_html += '<td class="text-right"><strong><span class="text-right ssubtotal" id="subtotal_'+row_no+'">'+formatMoney(item.row.p_price)+'</span></td>'; 
    newTr.html(tr_html);
    newTr.prependTo("#posTable");
    grand_total_cal();
	$('#id-name').val("quantity_"+row_no);
 }
 
/*
$(document).on("change", '.rquantity', function() {

    if (!is_numeric($(this).val()) || $(this).val() == 0) {
        bootbox.alert(lang.unexpected_value);
        return false;
    }

    var new_qty       = $(this).val();
    var item_id       = $(this).attr('data-item');
    var product_price = remove_comma($('#sprice_'+item_id+'').text()); 

    $('#subtotal_'+item_id+'').text(formatMoney(parseFloat(product_price) * parseFloat(new_qty)));
    $('#ssubtotal_'+item_id+'').val(parseFloat(product_price) * parseFloat(new_qty));
    grand_total_cal();
});
*/

var itemQty=0;
function grand_total_cal(argument) {
	//alert(argument);
    var to = 0;
    var order_discount = 0;
	var shipping =  0;//tship
    $( ".ssubtotal" ).each(function( index ) {
        to += remove_comma($( this ).text());
		//itemQty = index+1;
    });
	
	itemQty = $('#posTable >tbody > tr').length;
	$("#titems").text(itemQty);
	
    var ds = $("span#tds").text();
    if (ds.indexOf("%") !== -1) {
        var pds = ds.split("%");
        if (!isNaN(pds[0])) {
            order_discount = formatDecimal((to * parseFloat(pds[0])) / 100);
        } else {
            order_discount = formatDecimal(ds);
        }
    } else {
        order_discount = formatDecimal(ds);
    }

		//if(localStorage.getItem('posdiscount')){
		//order_discount = $('#tds').text(formatMoney(localStorage.getItem('posdiscount')));
		//}
		
		if(localStorage.getItem('posshipping')){	
			shipping = localStorage.getItem('posshipping');
			$('#tship').text(formatMoney(shipping));
		}

    $("span#total").text(formatMoney(to));
	
	
}


function remove_comma(value) {
    return parseFloat(value.replace(/,/g, ''))
}


function is_numeric(mixed_var) {
    var whitespace = " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
    return (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -
        1)) && mixed_var !== '' && !isNaN(mixed_var);
}

function formatDecimal(x) {
    return parseFloat(parseFloat(x).toFixed(site.settings.decimals));
}


function formatMoney(x, symbol) {
    if (!symbol) {
        symbol = "";
    }
    if (site.settings.sac == 1) {
        return symbol + '' + formatSA(parseFloat(x).toFixed(site.settings.decimals));
    }
    return accounting.formatMoney(x, symbol, site.settings.decimals, site.settings.thousands_sep == 0 ? ' ' : site.settings.thousands_sep, site.settings.decimals_sep, "%s%v");
}