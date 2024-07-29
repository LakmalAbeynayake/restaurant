var positems = {};
var site = {
        "base_url": "http:\/\/localhost/inventry_pos\/",
        "settings": {
            "logo": "logo2.png","logo2": "logo3.png","site_name": "Stock Manager Advance","language": "english","default_warehouse": "1","accounting_method": "0","default_currency": "USD","default_tax_rate": "1","rows_per_page": "10","version": "3.0.1.20","default_tax_rate2": "1","dateformat": "5","sales_prefix": "SALE","quote_prefix": "QUOTE","purchase_prefix": "PO","transfer_prefix": "TR","delivery_prefix": "DO","payment_prefix": "IPAY","return_prefix": "RETURNSL","expense_prefix": null,"item_addition": "0","theme": "default","product_serial": "1","default_discount": "1","product_discount": "1","discount_method": "1","tax1": "1","tax2": "1","overselling": "0","iwidth": "800","iheight": "800","twidth": "60","theight": "60","watermark": "0","smtp_host": "pop.gmail.com","bc_fix": "4","auto_detect_barcode": "1","captcha": "0","reference_format": "2","racks": "1","attributes": "1","product_expiry": "0","decimals": "2","decimals_sep": ".","thousands_sep": ",","invoice_view": "0","default_biller": null,"rtl": "0","each_spent": null,"ca_point": null,"each_sale": null,"sa_point": null,"sac": "0","qty_decimals": "2","display_all_products": "0"
        },
        "dateFormats": {
            "js_sdate": "dd\/mm\/yyyy","php_sdate": "d\/m\/Y","mysq_sdate": "%d\/%m\/%Y","js_ldate": "dd\/mm\/yyyy hh:ii","php_ldate": "d\/m\/Y H:i","mysql_ldate": "%d\/%m\/%Y %H:%i"
        }
    },
    pos_settings = {
        "pos_id": "1","cat_limit": "22","pro_limit": "20","default_category": "1","default_customer": "1","default_biller": "3","display_time": "1","cf_title1": "GST Reg","cf_title2": "VAT Reg","cf_value1": "123456789","cf_value2": "987654321","receipt_printer": "BIXOLON SRP-350II","cash_drawer_codes": "x1C","focus_add_item": "Ctrl+F3","add_manual_product": "Ctrl+Shift+M","customer_selection": "Ctrl+Shift+C","add_customer": "Ctrl+Shift+A","toggle_category_slider": "Ctrl+F11","toggle_subcategory_slider": "Ctrl+F12","cancel_sale": "F4","suspend_sale": "F7","print_items_list": "F9","finalize_sale": "F8","today_sale": "Ctrl+F1","open_hold_bills": "Ctrl+F2","close_register": "Ctrl+F10","keyboard": "1","pos_printers": "BIXOLON SRP-350II, BIXOLON SRP-350II","java_applet": "0","product_button_color": "default","tooltips": "1","paypal_pro": "0","stripe": "0","rounding": "0","char_per_line": "42","pin_code": null
    };
var lang = {
    unexpected_value: 'Unexpected value provided!',
    select_above: 'Please select above first',
    r_u_sure: 'Are you sure?'
};
var count = $('#count').val();
var rowCount = $("#posTable > tbody > tr").length;
//--
setInterval(function() {
    //alert(localStorage.getItem("poswarehouse"));
    $(".alert").hide('blind', {}, 500)
}, 15000);
var now = new moment();
$('#display_time').text(now.format((site.dateFormats.js_sdate).toUpperCase() + " HH:mm"));
setInterval(function() {
    var now = new moment();
    $('#display_time').text(now.format((site.dateFormats.js_sdate).toUpperCase() + " HH:mm"));
}, 1000);
//--
$(document).ready(function() {
    $("#makeMeScrollable").draggable({
        axis: "y"
    });
    $('#modal-loading').hide();
    //scrollMe();
    // widthFunctions();
    $(window).resize();
    $(".pos-tip").tooltip();
    $("#poswarehouse").select2();
    $("#poscustomer").select2();
    //local set from clone          
    /*$(document).on('change', '.rserial', function () {

            var item_id = $(this).closest('tr').attr('data-item-id');

            positems[item_id].row.serial = $(this).val();

            localStorage.setItem('positems', JSON.stringify(positems));

         });

    	 */
    $('#poswarehouse').change(function(e) {
        localStorage.setItem('poswarehouse', $(this).val());
    });
    $('#poscustomer').change(function(e) {
        localStorage.setItem('poscustomer', $(this).val());
    });
    $('#clearLS').click(function() {
        localStorage.clear();
        localStorage.setItem("clear", 1);
    });
    //end local set from clone  
});
$(document).ready(function() {
    localStorage.clear();
    localStorage.setItem('reload', 1);
    $('#add_item').focus();
    $('#content').css("background-color", "#FFF");
    $('#leftdiv').css("background-color", "#f4f4f4");
    $('#cpinner').css("background-color", "#f4f4f4");
    $('#product-list').css("min-height", 90);
    widthFunctions();
    $("#add_item").autocomplete({
        source: jsonarray
            /*function (request, response) {

                         if (!$('#poscustomer').val()) {

                             $('#add_item').val('').removeClass('ui-autocomplete-loading');

                             bootbox.alert('Please select above first');

                             //response('');

                             $('#add_item').focus();

                             return false;

                         }

                         $.ajax({

                             type: 'get',

                             url: 'pos/getProductDataByCode',

                             dataType: "json",

                             data: {

                                 code: request.term,

                                 warehouse_id: $("#poswarehouse").val(),

                                 customer_id: $("#poscustomer").val()

                             },

                             success: function (data) {

                                 response(data);

								 scrollMe();

                             }

                         });

                     }*/
            ,
        minLength: 1,
        autoFocus: false,
        delay: 200,
        response: function(event, ui) {
            if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                //audio_error.play();
                /*bootbox.alert('No matching result found! Product might be out of stock in the selected warehouse.', function () {

                    $('#add_item').focus();

                    $('#add_item').val('').removeClass('ui-autocomplete-loading');

                });*/
                $(this).val('');
                $('#add_item').val('').removeClass('ui-autocomplete-loading');
            } else if (ui.content.length == 1 && ui.content[0].id != 0) {
                // ui.item = ui.content[0];
                // $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                // $(this).autocomplete('close');
            } else if (ui.content.length == 1 && ui.content[0].id == 0) {
                //audio_error.play();
                /*bootbox.alert('No matching result found! Product might be out of stock in the selected warehouse.', function () {

                    $('#add_item').focus();

                    $('#add_item').val('').removeClass('ui-autocomplete-loading');

                });*/
                $(this).val('');
                $('#add_item').val('').removeClass('ui-autocomplete-loading');
            }
        },
        select: function(event, ui) {
            event.preventDefault();
            if (ui.item.id !== 0) {
                //===
                /*var tmp='';

                rowCount=parseInt($('#rowCount').val());

                if(rowCount){

                	//alert("ADDED:"+pq[c]);

                	tmp=isAddedProduct(ui.item.id);

                }*/
                //====
                //									alert(ui.item);
                var row = add_invoice_item(ui.item);
                if (row) $(this).val('');
                $('#add_item').val('').removeClass('ui-autocomplete-loading');
            } else {
                //audio_error.play();
                bootbox.alert('No matching result found! Product might be out of stock in the selected warehouse.');
            }
        }
    });
    $('#add_item').bind('keypress', function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $(this).autocomplete("search");
        }
    });
    $('#posTable').bind('keypress', function(e) {});
    $(document).bind('mousedown', function(event) { //event.preventDefault();
        //console.log(event);
        var clsList = event.target.className;
        if (clsList.indexOf('clickable') != -1) {
            //alert('found and approved');
            //event.preventDefault();
        } else {
            event.preventDefault();
            //alert('Not found and denied');
        }
    });
    /* --------------------------

     * Edit Row Quantity Method

    --------------------------- */
    var old_row_qty;
    $(document).on("focus", '.rquantity', function() {
        old_row_qty = $(this).val();
    }).on("change", '.rquantity', function() {
        var row = $(this).closest('tr');
        if (!is_numeric($(this).val()) || parseFloat($(this).val()) < 0) {
            $(this).val(old_row_qty);
            bootbox.alert(lang.unexpected_value);
            return;
        }
        var new_qty = parseFloat($(this).val()),
            item_id = row.attr('data-item-id');
        positems[item_id].qty = new_qty;
        if (positems[item_id].row.unit != positems[item_id].row.base_unit) {
            $.each(positems[item_id].units, function() {
                if (this.id == positems[item_id].row.unit) {
                    positems[item_id].row.base_quantity = unitToBaseQty(new_qty, this);
                }
            });
        }
        //alert(new_qty);
        positems[item_id].row.qty = new_qty;
        var pos = JSON.parse(localStorage.getItem('positems'));
        //var price 
        //console.log(pos[item_id]);
        positems[item_id].p_price = formatMoney(parseInt(pos[item_id].row.product_price) * new_qty);
        localStorage.setItem('positems', JSON.stringify(positems));
        //loadItems();
    });
    /* --------------------------

     * End Row Quantity Method

    --------------------------- */
});

function isAddedProduct(pid) {
    //alert(pid);
    for (i = 1; i <= rowCount; i++) {
        var product_fld = '#product_id_' + i;
        //alert(product_fld);
        var product_id = parseInt($(product_fld).val());
        if (product_id == pid) {
            var quantity_fld = '#quantity_' + i;
            var quantity_val = parseFloat($(quantity_fld).val());
            $(quantity_fld).val(quantity_val + 1);
            //-----------------------------------//
            //bootbox.alert('Item already added to List !!');
            var new_qty = $(quantity_fld).val();
            var item_id = product_id; //$(this).attr('data-item');
            var product_price = remove_comma($('#sprice_' + i + '').text());
            $('#subtotal_' + i + '').text(formatMoney(parseFloat(product_price) * parseFloat(new_qty)));
            $('#ssubtotal_' + i + '').val(parseFloat(product_price) * parseFloat(new_qty));
            /**/
            var pos = JSON.parse(localStorage.getItem('positems'));
            //var price 
            //console.log(pos[pid]);
            positems[pid].p_price = formatMoney(parseInt(pos[pid].row.product_price) * new_qty);
            positems[pid].qty = new_qty;
            //alert(positems[pid].qty);
            localStorage.setItem('positems', JSON.stringify(positems));
            /**/
            grand_total_cal();
            //-----------------------------------//
            //grand_total_cal();
            return 1;
        } else {
            //alert('no');	
            //return 0;
        }
    }
}
/*setInterval(

		  

		  function(){

			  $(".select2-container").css("width","100%");

			  }

		  

		  ,1000);*/
$(window).bind("resize", widthFunctions);

function widthFunctions(e) {
    var wh = $(window).height(),
        lth = $('#left-top').height(),
        lbh = $('#left-bottom').height();
    $('#item-list').css("height", wh - 107);
    $('#item-list').css("min-height", 515);
    $('#left-middle').css("height", wh - lth - lbh - 102);
    $('#left-middle').css("min-height", 278);
    $('#product-list').css("height", wh - lth - lbh - 107);
    $('#product-list').css("min-height", 278);
    //$('#poswarehouse').css("width", $('#left-middle').width());
    //$('#poscustomer').css("width", $('#left-middle').width());
    $(".select2-container").css("width", "100%");
    /*$('.scrollableArea').css("max-width",1000);

    */
}
var product_variant = 0,
    shipping = 0,
    p_page = 0,
    per_page = 0,
    tcp = "8",
    cat_id = "8",
    ocat_id = "1",
    sub_cat_id = 0,
    osub_cat_id, count = 1,
    an = 1,
    DT = 1;
$(document).on('click', '.category', function() {
    if (cat_id != $(this).val()) {
        $('#modal-loading').show();
        $('#open-category').click();
        cat_id = $(this).val();
        $.ajax({
            type: "get",
            url: "pos/ajaxcategorydata",
            data: {
                category_id: cat_id
            },
            dataType: "json",
            success: function(data) {
                $('#item-list').empty();
                var newPrs = $('<div id="makeMeScrollable"></div>');
                newPrs.html(data.products);
                newPrs.appendTo("#item-list");
                $('#subcategory-list').empty();
                var newScs = $('<div></div>');
                newScs.html(data.subcategories);
                newScs.appendTo("#subcategory-list");
                tcp = data.tcp;
                $("#makeMeScrollable").draggable({
                    axis: "y"
                });
            }
        }).done(function() {
            p_page = 'n';
            //console.log("cat id"+cat_id+"\n oct id"+ocat_id);
            $('#category-' + cat_id).addClass('active');
            if (cat_id != ocat_id) {
                $('#category-' + ocat_id).removeAttr('style');
                $('#category-' + ocat_id).removeClass('active');
            }
            $('.active').css('background-color', '#999');
            ocat_id = cat_id;
            $('#modal-loading').hide();
            $(".pos-tip").tooltip();
        });
    }
});
//$('#category-' + cat_id).addClass('active');
$('#dashboard').click(function() {
    $('#modal-loading').show();
});
$(document).on('click', '.subcategory', function() {
    $('#modal-loading').show();
    if (sub_cat_id != $(this).val()) {
        $('#open-subcategory').click();
        sub_cat_id = $(this).val();
        $.ajax({
            type: "get",
            url: "pos/ajaxproducts",
            data: {
                category_id: cat_id,
                subcategory_id: sub_cat_id,
                per_page: p_page
            },
            dataType: "html",
            success: function(data) {
                $('#item-list').empty();
                var newPrs = $('<div id="makeMeScrollable"></div>');
                newPrs.html(data);
                newPrs.appendTo("#item-list");
                $("#makeMeScrollable").draggable({
                    axis: "y"
                });
            }
        }).done(function() {
            p_page = 'n';
            $('#subcategory-' + sub_cat_id).addClass('active');
            $('#subcategory-' + osub_cat_id).removeClass('active');
            osub_cat_id = sub_cat_id;
            $('#modal-loading').hide();
            $(".pos-tip").tooltip();
        });
    }
});
$(document).click(function() {
    //$('.active').css('background-color','#39F');
});
$(document).on('click', '.product', function(e) {
    $('#modal-loading').show();
    code = $(this).val(),
        wh = $('#poswarehouse').val(),
        cu = $('#poscustomer').val();
    $.ajax({
        type: "get",
        url: "pos/getProductDataByCode",
        data: {
            code: code,
            warehouse_id: wh,
            customer_id: cu
        },
        dataType: "json",
        success: function(data) {
            e.preventDefault();
            if (data !== null) {
                //data.item = data.content[0];
                add_invoice_item(data[0]);
                $('#modal-loading').hide();
            } else {
                //audio_error.play();
                bootbox.alert('No matching result found! Product might be out of stock in the selected warehouse.');
                $('#modal-loading').hide();
            }
        }
    });
});
$(document).on('click', '.posdel', function(a) {
    var row = $(this).closest('tr');
    row.remove();
    grand_total_cal();
    //console.log(JSON.parse(localStorage.getItem('positems')));
});
// This below code is pos payment submit ..
$(document).on('click', '#submit-sale', function() {
    $('#submit-sale').css('display', 'none');
    var total_paid = $("input#amount_1").val();
    var grand_total = remove_comma($("span#twt").text());
    if (total_paid == 0 || total_paid < grand_total) {
        bootbox.confirm("Paid amount is less than the payable amount. Please press OK to submit the sale.", function(res) {
            if (res == true) {
                //$('#pos_note').val(localStorage.getItem('posnote'));
                //$('#staff_note').val(localStorage.getItem('staffnote'));
                $('#submit-sale').text('Loading...');
                form_submit(); //$('#pos-sale-form').submit();
            } else $("input#amount_1").val(0);
        });
        return false;
    } else {
        $(this).text('Loading...').attr('disabled', true);
        form_submit(); //$('#pos-sale-form').submit();
    }
});

function stopRKey(evt) {
    var evt = (evt) ? evt : ((event) ? event : null);
    var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
    if ((evt.keyCode == 13) && (node.type == "text")) {
        return false;
    }
}
document.onkeypress = stopRKey;
//-- pos.ajax.old 
$(document).ready(function() {
    $(".open-category").click(function() {
        $('#category-slider').toggle('slide', {
            direction: 'right'
        }, 700);
    });
    $(".open-subcategory").click(function() {
        $('#subcategory-slider').toggle('slide', {
            direction: 'right'
        }, 700);
    });
    $(".open-keyboard").click(function() {
        $('#keyboard-slider').toggle('slide', {
            direction: 'right'
        }, 700);
    });
    /*$('#poscustomer').click(function(){

    	alert();

    	});*/
    $("input[type=text] select").focus(function() {
        if (this.id != '') $('#id-name').val(this.id);
    });
    $(document).on('click', function(e) {
        if (!$(e.target).is(".open-category, .cat-child") && !$(e.target).parents("#category-slider").size() && $('#category-slider').is(':visible')) {
            $('#category-slider').toggle('slide', {
                direction: 'right'
            }, 700);
        }
        if (!$(e.target).is(".open-subcategory, .cat-child") && !$(e.target).parents("#subcategory-slider").size() && $('#subcategory-slider').is(':visible')) {
            $('#subcategory-slider').toggle('slide', {
                direction: 'right'
            }, 700);
        }
        if (!$(e.target).is(".open-keyboard")) {
            var focused = document.activeElement;
            //alert(focused.id);
            if (focused.id != '') $('#id-name').val(focused.id);
            //alert($('#id-name').val())
        }
        //OLD KEYBOARD
        /*if ($(e.target).parents("#keyboard-slider").size()) {

           var focused = document.activeElement;

			//alert(focused.id);

			//if(focused.id != '')

			//$('#id-name').val(focused.id);

			

			//alert(focused.nodeName);

		

			//alert($(focused.nodeName+"[name='"+focused.name+"']").attr("data-value"));

		var input_val = $(focused.nodeName+"[name='"+focused.name+"']").attr("data-value");

		

		var old_val = $('#'+$('#id-name').val()).val();

		var new_val =  old_val+""+input_val;

			//$('#'+$('#id-name').val()).val(old_val+""+input_val);

		

			

			//$('#'+$('#id-name').val()).sendkeys(input_val);

		

        }*/
        //END OLD KEYBOARD
        /*if (!$(e.target).is(".keyboard-class")) {

        var focused = document.activeElement;

        	//alert(focused.id);

        	//if(focused.id != '')

        	//$('#id-name').val(focused.id);

        	

        	//alert(focused.nodeName);

        

        	//alert($(focused.nodeName+"[name='"+focused.name+"']").attr("data-value"));

        var input_val = $(focused.nodeName+"[name='"+focused.name+"']").attr("data-value");

        

        $('#'+$('#id-name').val()).val(input_val);

        //$('#id-name').text(input_val);

        }*/
    });
});
if (site.settings.auto_detect_barcode == 1) {
    $(document).ready(function() {
        var pressed = false;
        var chars = [];
        $(window).keypress(function(e) {
            if (e.key == '%') {
                pressed = true;
            }
            chars.push(String.fromCharCode(e.which));
            if (pressed == false) {
                setTimeout(function() {
                    if (chars.length >= 8) {
                        var barcode = chars.join("");
                        $("#add_item").focus().autocomplete("search", barcode);
                    }
                    chars = [];
                    pressed = false;
                }, 200);
            }
            pressed = true;
        });
    });
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
    return (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -1)) && mixed_var !== '' && !isNaN(mixed_var);
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
    if (x.indexOf('.') > 0) afterPoint = x.substring(x.indexOf('.'), x.length);
    x = Math.floor(x);
    x = x.toString();
    var lastThree = x.substring(x.length - 3);
    var otherNumbers = x.substring(0, x.length - 3);
    if (otherNumbers != '') lastThree = ',' + lastThree;
    var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;
    return res;
}
//var positems = {};
function add_invoice_item(item) {
    rowCount++;
    if (rowCount == 1) {
        if ($('#poswarehouse').val() && $('#poscustomer').val()) {
            $('#poscustomer').select2("readonly", true);
            $('#poswarehouse').select2("readonly", true);
        } else {
            bootbox.alert(lang.select_above);
            item = null;
            return;
        }
    }
    if (item == null) {
        return;
    }
    var tmp = '';
    //alert(rowCount);
    if (rowCount) {
        //alert("ADDED:"+pq[c]);
        //	tmp=isAddedProduct(item.row.product_id);
    }
    if (!tmp) {
        count++;
        $('#count').val(count)
        loadItems(item);
        var item_id = count; // item.item_id;
        /*alert (item_id);*/
        //		if (positems[item_id]) {
        //			/*var new_qty = parseFloat(positems[item_id].row.qty) + 1;*/
        //			var new_qty = getQty(positems[item_id]);
        //			positems[item_id].row.base_quantity = new_qty;
        //			if(positems[item_id].row.unit != positems[item_id].row.base_unit) {
        //				$.each(positems[item_id].units, function(){
        //					if (this.id == positems[item_id].row.unit) {
        //						positems[item_id].row.base_quantity = unitToBaseQty(new_qty, this);
        //					}
        //				});
        //			}
        //			positems[item_id].row.qty = new_qty;
        //
        //		} else {
        positems[item_id] = item;
        //		}
        //var htmls = $('#posTable >tbody').html();
        //alert(htmls);
        rowCount++;
        positems[item_id].order = rowCount; //new Date().getTime();
        positems[item_id].p_price = parseInt(item.row.product_price);
        //positems[item_id].row.product_price = formatMoney(parseInt(item.row.product_price)*parseInt(item.row.qty));
        localStorage.setItem('positems', JSON.stringify(positems));
    }
    //console.log(localStorage.getItem("positems"));
    //END LOCAL
}
if (typeof(Storage) === "undefined") {
    $(window).bind('beforeunload', function(e) {
        if (count > 1) {
            var message = "You will loss data!";
            return message;
        }
    });
}

function loadItems(item) {
    var Count = $('#count').val(); //$("#posTable > tbody > tr").length;
    //rowCount++;
    var row_no = Count; // Math.floor((Math.random() * 1000) + 1);
    var tr_html;
    var newTr = $('<tr id="row_' + row_no + '" class="row_' + row_no + '" data-item-id="' + item.row.product_id + '"></tr>');
    tr_html = '<td><input type="hidden" value="' + item.row.product_id + '" class="rid" name="product_id[]" id="product_id_' + rowCount + '"><input type="hidden" value="' + item.row.product_code + '" class="rcode" name="product_code[]"><input type="hidden" value="' + item.row.product_name + '" class="rname" name="product_name[]">' + item.label + '</td>';
    tr_html += '<td class="text-right"><input type="hidden" value="' + item.row.product_price + '" id="price_' + row_no + '" name="net_price[]" class="rprice"><span class="text-right sprice" id="sprice_' + row_no + '">' + formatMoney(item.row.product_price) + '</span></td>';
    tr_html += '<td><input type="text" role="textbox" tabIndex="' + row_no + '" aria-haspopup="true" class="form-control kb-pad text-center rquantity ui-keyboard-input ui-widget-content ui-corner-all input-sm" name="quantity[]" value="1" data-id="1451881153671" data-item="' + row_no + '" id="quantity_' + row_no + '" onclick="this.select();"></td>';
    tr_html += ' <td class="text-right"><input type="hidden" value="' + item.row.product_price + '" id="ssubtotal_' + row_no + '" name="ssubtotal[]"><span class="text-right ssubtotal" id="subtotal_' + row_no + '">' + formatMoney(item.row.product_price) + '</span></td>';
    tr_html += '<td class="text-center posdel" onClick="delRow(' + row_no + ')" ><i class="fa fa-times tip pointer " id="1451881153671" title="Remove" style="cursor:pointer;"></i></td>';
    newTr.html(tr_html);
    newTr.prependTo("#posTable");
    grand_total_cal();
    $('#id-name').val("quantity_" + row_no);
    document.getElementById("quantity_" + row_no).focus();
    document.getElementById("quantity_" + row_no).select();
    var ms = JSON.parse(localStorage.getItem('positems'));
    //console.log(ms);
}

function delRow(item_id) { // previous delRow code: item.row.product_id
    delete positems[item_id];
    localStorage.setItem('positems', JSON.stringify(positems));
}
/*function changeQty(q){

	// alert(r);

	   localStorage.setItem('qty', q);

	 }*/
$(document).on("change", '.rquantity', function() {
    if (!is_numeric($(this).val()) || $(this).val() == 0) {
        bootbox.alert(lang.unexpected_value);
        return false;
    }
    var new_qty = $(this).val();
    var item_id = $(this).attr('data-item');
    var product_price = remove_comma($('#sprice_' + item_id + '').text());
    $('#subtotal_' + item_id + '').text(formatMoney(parseFloat(product_price) * parseFloat(new_qty)));
    $('#ssubtotal_' + item_id + '').val(parseFloat(product_price) * parseFloat(new_qty));
    var qty = {};
    qty['new_qty'] = parseFloat(new_qty);
    qty['item_id'] = parseInt(item_id);
    qty['product_price'] = product_price;
    //localStorage.setItem('qty',JSON.stringify(qty));
    //alert();
    //console.log(JSON.parse(localStorage.getItem('qty')));
    grand_total_cal();
});
var itemQty = 0;

function grand_total_cal(argument) {
    var to = 0;
    var order_discount = 0;
    var shipping = $('#posshipping').val(); //tship
    $(".ssubtotal").each(function(index) {
        to += remove_comma($(this).text());
    });
    itemQty = $('#posTable >tbody > tr').length; //index+1;
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
    $("span#total").text(formatMoney(to));
    $("input#amount_val_1").val(to - order_discount);
    $("input#posdiscount").val(order_discount);
    if (argument == 0) $("span#titems").text(argument);
    else $("span#titems").text(itemQty);
    $("span#tship").text(formatMoney(shipping));
    $("span#gtotal").text(formatMoney(to - order_discount + parseInt(shipping)));
    localStorage.setItem('gtotal', formatMoney(to - order_discount + parseInt(shipping)));
    $("#grand_total").val(to - order_discount + parseInt(shipping));
    //alert(order_discount);
}

function remove_comma(value) {
    return parseFloat(value.replace(/,/g, ''))
}

function is_numeric(mixed_var) {
    var whitespace = " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
    return (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -1)) && mixed_var !== '' && !isNaN(mixed_var);
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
$("#ppdiscount").click(function(e) {
    e.preventDefault();
    //var dval = $('#posdiscount').val() ? $('#posdiscount').val() : '0';
    //$('#order_discount_input').val(dval);
    $('#dsModal').modal();
});
$('#dsModal').on('shown.bs.modal', function() {
    $(this).find('#order_discount_input').select().focus();
    $('input#order_discount_input').bind('keypress', function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            var ds = $('#order_discount_input').val() ? $('#order_discount_input').val() : '0';
            if (is_valid_discount(ds)) {
                if (is_valid_discount(ds)) {
                    $('#tds').text(formatMoney(ds));
                    $('#posdiscount').val(ds);
                    localStorage.removeItem('posdiscount');
                    localStorage.setItem('posdiscount', ds);
                    $('#pos_discount_input1').val(ds);
                } else {
                    bootbox.alert(lang.unexpected_value);
                }
                $('#dsModal').modal('hide');
                grand_total_cal();
            } else {
                bootbox.alert(lang.unexpected_value);
            }
            $('#dsModal').modal('hide');
        }
    });
});
$(document).on('click', '#updateOrderDiscount', function() {
    var ds = $('#order_discount_input').val() ? $('#order_discount_input').val() : '0';
    if (is_valid_discount(ds)) {
        $('#tds').text(ds);
        $('#posdiscount').val(ds);
        localStorage.removeItem('posdiscount');
        localStorage.setItem('posdiscount', ds);
        $('#pos_discount_input1').val(ds);
    } else {
        bootbox.alert(lang.unexpected_value);
    }
    $('#dsModal').modal('hide');
    grand_total_cal();
});
// payment model section 
$("#payment").click(function(e) {
    if (itemQty > 0) {
        $("span#twt").text($("span#gtotal").text());
        $("span#item_count").text($("span#titems").text());
        $('#paymentModal').modal();
    } else {
        bootbox.alert("Please add product before payment. Thank you!");
    };
});
$('#paymentModal').on('shown.bs.modal', function() {
    $("input.amount").focus();
});
$(document).on('change', '.paid_by', function() {
    var p_val = $(this).val(),
        id = $(this).attr('id'),
        pa_no = id.substr(id.length - 1);
    $('#rpaidby').val(p_val);
    if (p_val == 'cash' || p_val == 'other') {
        $('.pcheque_' + pa_no).hide();
        $('.pcc_' + pa_no).hide();
        $('.pcash_' + pa_no).show();
        $('#payment_note_' + pa_no).focus();
        $('#paid_by_val_1').val(p_val);
    } else if (p_val == 'CC' || p_val == 'stripe' || p_val == 'ppp') {
        $('.pcheque_' + pa_no).hide();
        $('.pcash_' + pa_no).hide();
        $('.pcc_' + pa_no).show();
        $('#swipe_' + pa_no).focus();
        $('#paid_by_val_1').val(p_val);
    } else if (p_val == 'Cheque') {
        $('.pcc_' + pa_no).hide();
        $('.pcash_' + pa_no).hide();
        $('.pcheque_' + pa_no).show();
        $('#cheque_no_' + pa_no).focus();
    } else {
        $('.pcheque_' + pa_no).hide();
        $('.pcc_' + pa_no).hide();
        $('.pcash_' + pa_no).hide();
    }
    if (p_val == 'gift_card') {
        $('.gc_' + pa_no).show();
        $('.ngc_' + pa_no).hide();
        $('#gift_card_no_' + pa_no).focus();
    } else {
        $('.ngc_' + pa_no).show();
        $('.gc_' + pa_no).hide();
        $('#gc_details_' + pa_no).html('');
    }
});
var pi = 'amount_1',
    pa = 2;
$(document).on('click', '.quick-cash', function() {
    var $quick_cash = $(this);
    var amt = $quick_cash.contents().filter(function() {
        return this.nodeType == 3;
    }).text();
    var th = ',';
    var $pi = $('#' + pi);
    amt = formatDecimal(amt.split(th).join("")) * 1 + $pi.val() * 1;
    $pi.val(formatDecimal(amt)).focus();
    var note_count = $quick_cash.find('span');

    if (note_count.length == 0) {
        $quick_cash.append('<span class="badge">1</span>');
    } else {
        note_count.text(parseInt(note_count.text()) + 1);
    }
});
$(document).on('click', '#clear-cash-notes', function() {
    $('.quick-cash').find('.badge').remove();
    $('#' + pi).val('0').focus();
});
$(document).on('focus', '.amount', function() {
    pi = $(this).attr('id');
    calculateTotals();
}).on('blur', '.amount', function() {
    calculateTotals();
});

function calculateTotals() {
    var total_paying = 0;
    var gtotal = remove_comma($("span#twt").text());
    var ia = $(".amount");
    $.each(ia, function(i) {
        total_paying += parseFloat($(this).val() ? $(this).val() : 0);
    });
    $('#total_paying').text(formatMoney(total_paying));
    $('#balance').text(formatMoney(total_paying - gtotal));
    $('#balance_' + pi).val(formatDecimal(total_paying - gtotal));
    total_paid = total_paying;
    grand_total = gtotal;
}
$(document).on('click', '#reset', function() {
    bootbox.confirm("Are you sure?", function(res) {
        if (res == true) {
            $("#posTable tbody").empty();
            grand_total_cal(0);
            $("input#posdiscount").val(0);
            $('#tds').text(0);
            $("input#posshipping").val(0);
            $('#tship').text(0.00);
            localStorage.clear();
            //localStorage.setItem('reload',1);
            window.location.reload();
            //resetArray();
        }
    });
    return false;
});
/*Create Customer*/
$("#modal_ajax_customers_btn").click(function(e) {
    e.preventDefault();
    //shipping = $('#posshipping').val() ? $('#posshipping').val() : shipping;
    //$('#shipping_input').val(shipping);
    var $modal = $('#ajax-modal').modal();
    $modal.load(base_url + "customers/create_customers", '', function() {
        $modal.modal();
    });
});
/*End Create Customer*/
$("#pshipping").click(function(e) {
    e.preventDefault();
    shipping = $('#posshipping').val() ? $('#posshipping').val() : shipping;
    $('#shipping_input').val(shipping);
    $('#sModal').modal();
});
$('#sModal').on('shown.bs.modal', function() {
    $(this).find('#shipping_input').select().focus();
});
$(document).on('click', '#updateShipping', function() {
    var s = parseFloat($('#shipping_input').val() ? $('#shipping_input').val() : '0');
    if (is_numeric(s)) {
        $('#posshipping').val(s);
        localStorage.setItem('posshipping', s);
        // shipping = s;
        grand_total_cal();
        $('#sModal').modal('hide');
    } else {
        bootbox.alert(lang.unexpected_value);
    }
});
$('#sModal').on('shown.bs.modal', function() {
    $(this).find('#shipping_input').select().focus();
    $('input#shipping_input').bind('keypress', function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            var s = parseFloat($('#shipping_input').val() ? $('#shipping_input').val() : '0');
            if (is_numeric(s)) {
                $('#posshipping').val(s);
                localStorage.setItem('posshipping', s);
                // shipping = s;
                grand_total_cal();
                $('#sModal').modal('hide');
            } else {
                bootbox.alert(lang.unexpected_value);
            }
        }
    });
});
//*********************************************
$('#paymentModal').on('change', '#amount_1', function(e) {
    $('#pay_amount').val($(this).val());
});
$('#paymentModal').on('blur', '#amount_1', function(e) {
    $('#pay_amount').val($(this).val());
});
$('#paymentModal').on('change', '#payment_note_1', function(e) {
    $('#pos_note').val($(this).val());
    var v = $('#pos_note').val();
    localStorage.setItem('posnote', v);
});
//$('#paymentModal').on('select2-close', '#paid_by_1', function (e) {
//    $('#paid_by_val_1').val($(this).val());
//});
$('#paymentModal').on('change', '#swipe_1', function(e) {
    $('#cc_name').val($(this).val());
});
$('#paymentModal').on('change', '.pcc_type', function(e) {
    $('#pcc_type').val($(this).val());
});
$('#paymentModal').on('change', '#pcc_holder_1', function(e) {
    $('#pcc_holder').val($(this).val());
});
$('#paymentModal').on('change', '#pcc_no_1', function(e) {
    $('#cc_no').val($(this).val());
});

function fbs_click(id) {
    u = location.href;
    t = document.title;
    window.open('sales/sale_details?sale_id=' + id, 'sharer', 'toolbar=0,status=0,width=384,height=700, left=10, top=10,scrollbars=yes');
    return false;
}

function getQty(pid) {
    //alert(pid);
    for (i = 1; i <= rowCount; i++) {
        var product_fld = '#product_id_' + i;
        //alert(product_fld);
        var product_id = parseInt($(product_fld).val());
        if (product_id == pid) {
            //change qty
            var quantity_fld = '#quantity_' + i;
            var quantity_val = parseFloat($(quantity_fld).val());
            //$(quantity_fld).val(quantity_val+1);
            //			//-----------------------------------//
            //				
            //				var new_qty       = $(quantity_fld).val();
            //				var item_id       = product_id;//$(this).attr('data-item');
            //				var product_price = remove_comma($('#sprice_'+i+'').text()); 
            //				
            //				$('#subtotal_'+i+'').text(formatMoney(parseFloat(product_price) * parseFloat(new_qty)));
            //				$('#ssubtotal_'+i+'').val(parseFloat(product_price) * parseFloat(new_qty));
            //			
            //grand_total_cal();
            //-----------------------------------//
            //grand_total_cal();
            return quantity_val;
        } else {
            //alert('no');	
            return 0;
        }
    }
}

function scrollMe() {
    $("#makeMeScrollable").smoothDivScroll({
        hotSpotScrolling: false,
        touchScrolling: true,
        manualContinuousScrolling: false,
        mousewheelScrolling: false
    });
    $('.scrollableArea').css("max-width", 1700);
    $('.scrollWrapper').css("height", $('#product-list').height() + 270);
}
/*

	

	 var ds = podiscount;

            if (ds.indexOf("%") !== -1) {

                var pds = ds.split("%");

                if (!isNaN(pds[0])) {

                    order_discount = ((total) * parseFloat(pds[0])) / 100;

                } else {

                    order_discount = parseFloat(ds);

                }

            } else {

                order_discount = parseFloat(ds);

            }

	*/
/*focus chk*/
$(window).keydown(function(event) {
    //console.log("|KEY CODE"+event.keyCode);
    //console.log(document.activeElement.id);
    $(":focus").each(function() {
        //alert("Focused Elem_id = "+ this.id );
        focus_id = this.id;
        //console.log("|FOCUSED:"+focus_id+"|");
        //	alert(focus_id);
        //	alert(event.keyCode);
        var rowCount = $('#rowCount').val();
        rowCount++;
        var fld = 'quantity_' + rowCount;
        //console.log("RowCount:"+rowCount);
        //console.log("FLD:"+fld);
        if (focus_id == fld) {
            if (event.keyCode == 16) {
                $('#add_item').focus();
            }
        }
        /*if(event.keyCode == 18) {

		calculateTotals();



    }

	*/
        if (event.keyCode == 118) {
            if (focus_id != fld) {
                if (itemQty > 0) {
                    grand_total_cal();
                    //calculateTotals();
                    $("span#twt").text($("span#gtotal").text());
                    $("span#item_count").text($("span#titems").text());
                    $('#paymentModal').modal();
                } else {
                    var done = bootbox.alert("Please add product before payment. Thank you!");
                    if (done) $('#add_item').focus();
                };
            } else {
                var done = $('#add_item').focus();
                if (done) {
                    if (itemQty > 0) {
                        grand_total_cal();
                        //calculateTotals();
                        $("span#twt").text($("span#gtotal").text());
                        $("span#item_count").text($("span#titems").text());
                        $('#paymentModal').modal();
                    }
                }
            }
        }
        if (event.keyCode == 13) event.preventDefault(); //{
        //		
        //		/**/
        //		if(focus_id == 'amount_1')
        //			{
        //				$('#add_item').focus();
        //				var total_paid = $("input#amount_1").val();
        //				var grand_total= remove_comma($("span#twt").text());
        //	
        //				if (total_paid == 0 || total_paid < grand_total) {
        //					bootbox.confirm("Paid amount is less than the payable amount. Please press OK to submit the sale.", function (res) {
        //						if (res == true) {
        //							//$('#pos_note').val(localStorage.getItem('posnote'));
        //							//$('#staff_note').val(localStorage.getItem('staffnote'));
        //							$('#submit-sale').text('Loading...');
        //							form_submit();//$('#pos-sale-form').submit();
        //							location.reload();
        //						}else $("input#amount_1").val(0);
        //					});
        //					return false;
        //				} else {
        //					$(this).text('Loading...').attr('disabled', true);
        //					form_submit();//$('#pos-sale-form').submit();
        //					location.reload();
        //				}
        //			}else{
        //		/**/
        //      event.preventDefault();
        //     return false;
        //	 }
        //    }
    });
});
$(document).ajaxStart(function() {
    $('#modal-loading').show();
    $('#modal-loading').css('z-index', '99999');
});
$(document).ajaxStop(function() {
    $('#modal-loading').hide();
});

function form_reset() {
    var done = $('#fucking_done').val();
    if (done) window.location.reload(true);
}

function displayNotice(page, msg) {
    //alert();
    $.gritter.add({
        // (string | mandatory) the heading of the notification
        title: 'Notice!',
        // (string | mandatory) the text inside the notification
        text: msg,
        // (string | optional) the image to display on the left
        image: '',
        // (bool | optional) if you want it to fade out on its own or just sit there
        sticky: false,
        // (int | optional) the time you want it to be alive for before fading out
        time: ''
    });
    return false;
}