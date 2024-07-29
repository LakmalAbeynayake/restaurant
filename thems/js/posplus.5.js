var positems = {};
var site = {
        base_url: "http://localhost/inventry_pos/",
        cashierFloatId : 0,
        cashierName : "",
        userID : "",
        wh_code: "",
        wh_name: "",
        wh_address: "",
        wh_phone: "",
        wh_email: "",
        numTables: 50,
        kot : false, 
        settings: {
            logo: "logo2.png",
            logo2: "logo3.png",
            site_name: "Stock Manager Advance",
            language: "english",
            default_warehouse: "1",
            accounting_method: "0", 
            default_currency: "USD",
            default_tax_rate: "1",
            rows_per_page: "10",
            version: "3.0.1.20",
            default_tax_rate2: "1",
            dateformat: "5",
            sales_prefix: "SALE",
            quote_prefix: "QUOTE",
            purchase_prefix: "PO",
            transfer_prefix: "TR",
            delivery_prefix: "DO",
            payment_prefix: "IPAY",
            return_prefix: "RETURNSL",
            expense_prefix: null,
            item_addition: "0",
            theme: "default",
            product_serial: "1",
            default_discount: "1",
            product_discount: "1",
            discount_method: "1",
            tax1: "1",
            tax2: "1",
            overselling: "0",
            iwidth: "800",
            iheight: "800",
            twidth: "60",
            theight: "60",
            watermark: "0",
            smtp_host: "pop.gmail.com",
            bc_fix: "4",
            auto_detect_barcode: "1",
            captcha: "0",
            reference_format: "2",
            racks: "1",
            attributes: "1",
            product_expiry: "0",
            decimals: "2",
            decimals_sep: ".",
            thousands_sep: ",",
            invoice_view: "0",
            default_biller: null,
            rtl: "0",
            each_spent: null,
            ca_point: null,
            each_sale: null,
            sa_point: null,
            sac: "0",
            qty_decimals: "2",
            display_all_products: "0",
            printable: false,
            check_deli: false
        },
        dateFormats: {
            js_sdate: "dd/mm/yyyy",
            php_sdate: "d/m/Y",
            mysq_sdate: "%d/%m/%Y",
            js_ldate: "dd/mm/yyyy hh:ii",
            php_ldate: "d/m/Y H:i",
            mysql_ldate: "%d/%m/%Y %H:%i"
        },
        data: {
            cancel_id: 0
        }
    },
    pos_settings = {
        pos_id: "1",
        cat_limit: "22",
        pro_limit: "20",
        default_category: "1",
        default_customer: "1",
        default_biller: "3",
        display_time: "1",
        cf_title1: "GST Reg",
        cf_title2: "VAT Reg",
        cf_value1: "123456789",
        cf_value2: "987654321",
        receipt_printer: "BIXOLON SRP-350II",
        cash_drawer_codes: "x1C",
        focus_add_item: "Ctrl+F3",
        add_manual_product: "Ctrl+Shift+M",
        customer_selection: "Ctrl+Shift+C",
        add_customer: "Ctrl+Shift+A",
        toggle_category_slider: "Ctrl+F11",
        toggle_subcategory_slider: "Ctrl+F12",
        cancel_sale: "F4",
        suspend_sale: "F7",
        print_items_list: "F9",
        finalize_sale: "F8",
        today_sale: "Ctrl+F1",
        open_hold_bills: "Ctrl+F2",
        close_register: "Ctrl+F10",
        keyboard: "1",
        pos_printers: "BIXOLON SRP-350II, BIXOLON SRP-350II",
        java_applet: "0",
        product_button_color: "default",
        tooltips: "1",
        paypal_pro: "0",
        stripe: "0",
        rounding: "0",
        char_per_line: "42",
        pin_code: null,
        extra_charges: '0'
    };
var lang = {
    unexpected_value: "Unexpected value provided!",
    select_above: "Please select above first",
    r_u_sure: "Are you sure?"
};
var count = $("#count").val();
var rowCount = $("#posTable > tbody > tr").length;
setInterval(function() {
    $(".alert").hide("blind", {}, 500)
}, 15000);

function check_terminal(){
    var terminal_id = $('#terminal_id').val();
    var local_id = localStorage.getItem('terminal_id');
    
    if(terminal_id !== local_id){
        bootbox.alert('Page has expired');
        $('body').empty();
        window.close();
    }
}
setInterval(function() {
    if (typeof moment !== "undefined") {
        var a = new moment();
        $("#display_time").text(a.format((site.dateFormats.js_sdate).toUpperCase() + " HH:mm"));
        $("#kot_date_time").text(a.format((site.dateFormats.js_sdate).toUpperCase() + " HH:mm"));
        $("#sale_datetime").val(a.format(("Y-MM-D HH:mm:ss")));
        $("#bill_date").text("Date: " + a.format(("Y-MM-D HH:mm")));
    }
}, 1000);

$(document).ready(function() {
    $(window).focus(function() {
        check_terminal();
        checkLogin();
    });
});

$(document).ajaxStart(function() {
    $('#ajaxCall').show();
}).ajaxStop(function() {
    $('#ajaxCall').hide();
}).on("change", ".rquantity", function() { 
    var b = $(this).closest("tr");
    if (!is_numeric($(this).val()) || parseFloat($(this).val()) === 0) {
        $(this).val(1);
    } else {
        
    }
    var row_id = $(b).data('row-id');
    var new_quantity = parseFloat($(this).val());
    var price = parseFloat($('#pro_price_'+row_id).val());
    
    var itm_discount = get_itm_discount(row_id);
    price -= itm_discount;
    var sub_total = new_quantity * price;
    
    $('#pro_subtotal_'+row_id).val(sub_total);
    $('#subtotal_'+row_id).text(sub_total.toFixed(2));
    
    grand_total_cal();
}).on("change", ".rprice", function() {
    var b = $(this).closest("tr");
    if (!is_numeric($(this).val()) || parseFloat($(this).val()) === 0) {
        $(this).val(1);
    } else {
        
    }
    var row_id = $(b).data('row-id');
    var new_quantity = parseFloat($('#quantity_'+row_id).val());
    var price = parseFloat($(this).val());
    
    var itm_discount = get_itm_discount(row_id);
    price -= itm_discount;
    
    var sub_total = new_quantity * price;
    
    $('#pro_subtotal_'+row_id).val(sub_total);
    $('#subtotal_'+row_id).text(sub_total.toFixed(2));
    
    grand_total_cal();
}).on("keypress", ".rquantity", function(b) {
    if (b.key == "Escape") {
        if ((b.target.id).indexOf("quantity") != -1) {
            var c = $(this).closest("tr");
            c.remove();
            $("#add_item").focus()
        }
    }
    if (b.key == "Enter") {
        $("#add_item").focus()
    } else {
        /*console.log('keypress');*/
        grand_total_cal();
    }
}).on("keyup", ".rquantity", function() {
    if (!is_numeric($(this).val()) || $(this).val() < 0) {
        /*bootbox.alert(lang.unexpected_value);*/
        // $(this).val(1).focus().select();
        // return false;
        grand_total_cal();
    } else {
        /*console.log('keyup');*/
        grand_total_cal();
    }
}).on("click", "#reset", function() {
    bootbox.confirm({
        size: "small",
        message: "Are you sure?",
        callback: function(a) {
            if (a === true) {
                window.location.reload();
            }
        }
    });
    return false
}).bind("keyup", function(d) {
    if (d.target.classList[0] == "select2-input") {
        var b = d.target.value;
        if (!isNaN(b)) {
            $("#customer_mobile").val(d.target.value)
        }
    }
    if (d.key == "Enter") {
        if (d.target.classList[0] == "select2-input") {
            if ($(".select2-results > li").hasClass("select2-no-results")) {
                $("#modal_ajax_customers_btn").click();
                $("#select2-drop").slideUp("fast")
            }
        }
        var c = d.target.id;
        if (c.indexOf("c_pay_amount_") != -1) {
            set_as_paid(d.target.attributes["sale-id"].value)
        }
        if (d.target.id == "amount_1") {
            $("#pay_amount").val(remove_comma($("#amount_1").val()));
            $("#submit-sale").click()
        }
        if (d.target.id == "swipe_1") {
            if (d.target.value) {
                $("#pcc_no_1").focus()
            }
        }
        if (d.target.id == "pcc_no_1") {
            if (d.target.value) {
                $("#pay_amount").val(remove_comma($("#amount_1").val()))
            }
            $("#submit-sale").click()
        }
        if (d.target.id == "pcc_holder_1") {
            if (d.target.value) {
                $("#pay_amount").val(remove_comma($("#amount_1").val()))
            }
            $("#submit-sale").click()
        }
    }
}).keypress(function(event) {
    if (String.fromCharCode(event.which) == "'") {
        event.preventDefault();
        //displayNotice("page", " Character you typed is not allowed !! ");
    }
});
function open_tab(tab_id) {
    $('a[href="#' + tab_id + '"]').tab('show');
}

function change_deli_type(elem){
    if($(elem).val() == 1){
        $('#store_id_div').show();
        $('#delivery_address_div').hide();
    }else{
        $('#store_id_div').hide();
        $('#delivery_address_div').show();
    }
}
$("#add_item").autocomplete({
    source: jsonarray,
    minLength: 1,
    autoFocus: false,
    delay: 200,
    response: function(b, c) {
        //console.log($(this).val().length);
        if ($(this).val().length >= 16 && c.content[0].id == 0) {
            //alert(2);
            $(this).val("");
            $("#add_item").val("").removeClass("ui-autocomplete-loading")
        } else {
            if (c.content.length == 1 && c.content[0].id != 0) {
                console.log(c.content[0].id);
                //select item
                //$(this).val("");
                //	alert(JSON.stringify(c.content[0]));
                validate_item(c.content[0]);
                $(this).val("");
                //$(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', c);
            } else {
                if (c.content.length == 1 && c.content[0].id == 0) {
                    $(this).val("");
                    $("#add_item").val("").removeClass("ui-autocomplete-loading")
                }
            }
        }
    },
    select: function(b, c) {
        b.preventDefault();
        if (c.item.id !== 0) {
            var d = validate_item(c.item);
            //console.log(c.item);
            if (d) {
                $(this).val("")
            }
            $("#add_item").val("").removeClass("ui-autocomplete-loading")
        } else {
            bootbox.alert("No matching result found! Product might be out of stock in the selected warehouse.")
        }
    }
});
$("#add_item").bind("keypress", function(b) {
    if (b.keyCode == 13) {
        b.preventDefault();
        //$("#payment").click();
         $("#pay_cash").focus();
         $("#pay_cash").select();
        var result = 1;
        //alert("FS KOT");//(result);
        $(this).autocomplete("search")
    }
});
$(".open-keyboard").click(function() {
    $("#keyboard-slider").toggle("slide", {
        direction: "right"
    }, 300)
});
$("input[type=text] select").focus(function() {
    if (this.id != "") {
        $("#id-name").val(this.id)
    }
});
$("#modal_ajax_customers_btn").click(function(b) {
    b.preventDefault();
    var a = $("#ajax-modal").modal();
    a.load(base_url + "customers/create_customers", "", function() {
        a.modal();
        setTimeout(function() {
            var c = $("#customer_mobile").val();
            $("#cus_phone").val(c);
            $("#nc").val(2); 
            $("#cus_name").focus()
        }, 500)
    }) 
});
function widthFunctions(d) {
    $('#main_panel').css('height', $(window).height() - $('#header').height() );
    $('#cpinner').css('height', $('#leftdiv').height() );
}
$(window).bind("resize", widthFunctions);
var product_variant = 0,
    shipping = 0,
    p_page = 0,
    per_page = 0,
    tcp = "8",
    cat_id = "8",
    ocat_id = "1",
    sub_cat_id = 0,
    osub_cat_id;

$(document).on("click", ".product", function(a) {
        //console.log(this);
        $("#modal-loading").show();
        product_id_sub = $(this).attr('product_id_sub');
        product_id = $(this).attr('product_id');
        product_code = $(this).attr('product_code');
        product_name = $(this).attr('product_name');
        product_price = $(this).attr('product_price');
        label = $(this).attr('label');
        value = $(this).attr('title');
        wh = $("#poswarehouse").val(), cu = $("#poscustomer").val();
        var product = {
            "product_id": product_id
        };
        validate_item(product);
        $("#modal-loading").hide();
        /*$.ajax({
            type: "get",
            url: site.base_url + "pos/getProductDataByCode",
            data: {
                code: product_code,
                warehouse_id: wh,
                customer_id: cu
            },
            dataType: "json",
            success: function(b) {
                a.preventDefault();
                if (b !== null) {
                    validate_item(b[0]);
                    $("#modal-loading").hide()
                } else {
                    bootbox.alert("No matching result found! Product might be out of stock in the selected warehouse.");
                    $("#modal-loading").hide()
                }
            }
        })*/
    }).on("click", ".product_validated", function(a) {
        $("#select_price_modal").modal('hide');
        product_id_sub = $(this).attr('product_id_sub');
        product_id = $(this).attr('product_id');
        product_code = $(this).attr('product_code');
        product_name = $(this).attr('product_name');
        product_price = $(this).attr('product_price');
        product_ott = $(this).attr('ott');
        label = $(this).attr('label');
        value = $(this).attr('title');
        wh = $("#poswarehouse").val(), cu = $("#poscustomer").val();
        var product = {
            "product_id": product_id,
            "product_id_sub": product_id_sub,
            "product_code": product_code,
            "product_name": product_name,
            "product_price": product_price,
            "product_ott": product_ott,
            "discount" : 0,
            "discount_val" : 0,
            "quantity" : 1,
            "no_name" : 0
        };
        console.log(product);
        add_to_list(product);
        $("#modal-loading").hide();
    }).on("click", ".posdel", function(b) {
        var c = $(this).closest("tr");
        var tr_id = $(c).attr('id');
        remove_sale_item_by_login(tr_id);
    }).on("click", "#submit-sale", function() {
        console.log('submit sale clicked...');
        var paid_by = $('#paid_by_1').val();
        if (paid_by == 'CC')
            if (!$('#swipe_1').val() || !$('#pcc_no_1').val() || !$('#pcc_holder_1').val())
                bootbox.alert('Card detail fields are required !');
            else {
                $("#submit-sale").attr("disabled", true);
                $('#paymentModal').modal('hide');
                form_submit();
            }
        else {
            site.settings.printable = true;
            $("#submit-sale").attr("disabled", true);
            $('#paymentModal').modal('hide');
            form_submit();
        }
    }).on("click", "#save", function() {
        if ($("#posTable >tbody > tr").length > 0) {
            var a = $(':radio[name=delivery_status]:checked').val();
            var shipping_address = $("#shipping_address").val();
            var shipping_charges = $("#posshipping").val();
            if (a == 3) {
                //$('#kot_type').text("Delivery");
                
                if (site.settings.check_deli) {
                    if (shipping_address == "") {
                        $("#pshipping").click();
                        displayNotice("", "Please confirm and update delivery details !!")
                    } else if (shipping_charges == 0) {
                        bootbox.confirm({
                            size: "small",
                            message: " Delivery charges : Rs. 0.00 /=. Continue ?",
                            callback: function(a) {
                                if (a == true) {
                                    $('#del_addr_bill').val(shipping_address);
                                    form_submit();
                                } else $("#pshipping").click();
                            }
                        });
                    } else {
                        $('#del_addr_bill').text("Address:" + shipping_address);
                        form_submit();
                    }
                } else {
                    form_submit();
                }
            } else if (a == 1) {
                var table_id = $('#table_id').val();
                var waiter_id = $('#waiter_id').val();
                if (waiter_id == '') {
                    bootbox.alert('Please select Waiter!');
                    return false;
                }
                $('#kot_table_no').text("Table No:" + table_id);
                if (table_id == '') {
                    bootbox.alert('Please select table number!');
                } else {
                    var result = 1;
                    form_submit();
                    $("#add_item").focus();
                }
            } else {
                
                form_submit();
                $("#add_item").focus();
            }
        } else {
            // displayNotice("", "Please add product before payment. Thank you !! ");
            $("#add_item").focus()
        }
        
    }).on("click", function(b) {});
/*if (site.settings.auto_detect_barcode == 1) {
	$(document).ready(function () {
		var b = false;
		var a = [];
		$(window).keypress(function (c) {
			if (c.key == "%") {
				b = true
			}
			a.push(String.fromCharCode(c.which));
			if (b == false) {
				setTimeout(function () {
					if (a.length >= 8) {
						var d = a.join("");
						$("#add_item").focus().autocomplete("search", d)
					}
					a = [];
					b = false
				}, 200)
			}
			b = true
		})
	})
}*/
function isAddedProduct(pc) {
    return 0;
    var a = $("#product_id_" + pc).val();
    if (a) {
        var d = $("#product_id_" + pc).attr('row_id');
        var c = "#quantity_" + d;
        var h = parseFloat($(c).val());
        $(c).val(h + 1);
        grand_total_cal();
        document.getElementById("quantity_" + d).focus();
        document.getElementById("quantity_" + d).select();
        return 1
    }
}

function validate_item(item) {
    
    item = products[item.product_id];
    $("#qty_en_tot").val('');
    var prices = item.product_prices;
    var price_type_id = $('.cb_list input[type="radio"]:checked').val();
    if (Object.keys(prices).length) {
    
        var priceKeys = Object.keys(prices);
        for (var i = 0; i < priceKeys.length; i++) {
            var a = priceKeys[i];
            var pti = prices[a];
    
            if (pti.pt_id == price_type_id) {
                
                if(Object.keys(pti.amount).length > 1){
                    console.log(pti.amount);
                    //create price selection modal
                    $('#select_price_modal .modal-body').empty();
                    var prd_btn = '';
                    
                    var modalBody = document.querySelector('#select_price_modal .modal-body');
                    modalBody.innerHTML = '';
            
                    $.each(pti.amount,(c,d)=>{
                        console.log(d);
                        prd_btn += '<button type="button" class="price-square product_validated" ott="'+item.product_ott+'" product_price="'+d+'" title="'+item.product_id+'" product_id="'+item.product_id+'" product_name="'+item.product_name+'">'+d+'</button>';
                    });
                    
                    $('#select_price_modal .modal-body').html(prd_btn);
                    $('#select_price_modal').modal();
                }else{
                    console.log('single price:',pti.amount);
                    // Get an array of values
                    var values = Object.values(pti.amount);
                    
                    // Access the value of the first key without using the key name
                    var product_price = values[0];
                    var product = {
                        "product_id": item.product_id,
                        "product_id_sub": '',
                        "product_code": item.product_code,
                        "product_name": item.product_name,
                        "product_price": product_price,
                        "product_ott": item.product_ott,
                        "discount" : 0,
                        "discount_val" : 0,
                        "quantity"  : 1,
                        "no_name"   : 0
                    };
                    console.log(product);
                    add_to_list(product);
                    $("#select_price_modal").modal('hide');
                    $("#modal-loading").hide();
                }
                break;
            }
        }
    }
}
function sanitize_item(item) {
    item = products[item.product_id];
    $("#qty_en_tot").val('');
    var prices = item.product_prices;
    var price_type_id = $('.cb_list input[type="radio"]:checked').val();
    if (Object.keys(prices).length) {
        var priceKeys = Object.keys(prices);
        for (var i = 0; i < priceKeys.length; i++) {
            var a = priceKeys[i];
            var pti = prices[a];
            if (pti.pt_id == price_type_id) {
                if(Object.keys(pti.amount).length > 1){
                    $.each(pti.amount,(c,d)=>{
                        if(parseFloat(d) > 0)
                            return true;
                    });
                }else{
                    console.log('single price:',pti.amount);
                    // Get an array of values
                    var values = Object.values(pti.amount);
                    
                    // Access the value of the first key without using the key name
                    var product_price = values[0];
                    
                    if(parseFloat(product_price) > 0)
                            return true;
                }
                return false;
            }
        }
    }else return false;
}
/*if (typeof (Storage) === "undefined") {
	$(window).bind("beforeunload", function (b) {
		if (count > 1) {
			var a = "You will loss data!";
			return a
		}
	})
}*/
function add_to_list(e) {
    var print_status = 0;
    var printed = 0;

    if (typeof e.printed !== 'undefined') {
        printed = 1;
        print_status = 1;
    }
    
    if (typeof e.discount === 'undefined') {
        e.discount = 0;
        e.discount_val = 0;
    }
    if (typeof e.quantity === 'undefined') {
        e.quantity = 1;
    }

    var c = uuidv4().replace(/-/g, '');
    var nameAttributes = ''; // Initialize name attributes string

    // Check if e.no_name is not defined or equal to 0
    if (typeof e.no_name === 'undefined' || e.no_name !== 1) {
        // Create name attributes if e.no_name is not defined or not equal to 1
        e.no_name = 0;
        console.log('went through this shit');
    }

    var f = `<td style="display:flex;flex-direction: row;align-items: flex-end;justify-content: space-between;">
                <input type="hidden" value="${e.product_id}" class="rid" ${e.no_name !== 1 ? `name="product_id[]"` : ''}  id="product_id_${c}">
                <input type="hidden" value="${e.product_ott}" class="rid" ${e.no_name !== 1 ? `name="product_ott[]"` : ''}  id="product_ott_${c}">
                <input type="hidden" value="${e.product_code}" class="rcode" ${e.no_name !== 1 ? `name="product_code[]"` : ''}  id="product_code_${c}">
                <input type="hidden" value="${print_status}" id="print_status_${c}" ${e.no_name !== 1 ? `name="print_status[]"` : ''}>
                <input type="hidden" value="${e.product_name}" ${e.no_name !== 1 ? `name="product_name[]"` : ''}  id="product_name_${c}">
                ${e.product_name}
                <button type="button" class="btn btn-default ${e.no_name !== 1 ? `itm_discount` : `collapse`}">${ e.discount_val > 0 ? e.discount+` Dis` : `<i class="fa fa-dollar"></i>` }</button>
                <input type="hidden" value="${e.discount}" ${e.no_name !== 1 ? `name="product_discount[]"` : ''} id="product_discount_${c}">
                <input type="hidden" value="${e.discount_val}" ${e.no_name !== 1 ? `name="product_discount_amount[]"` : ''}  id="product_discount_amount_${c}">
        </td>
        <td class="text-right">
            ${e.no_name !== 1 ? `` : e.product_price}
            <input class="form-control input-sm text-center rprice" style="width:100%;" type="${e.no_name !== 1 ? `text` : 'hidden'}" value="${e.product_price}" id="pro_price_${c}" ${e.no_name !== 1 ? `name="net_price[]"` : 'readonly'} onClick="this.select()">
        </td>
        <td>
            ${e.no_name !== 1 ? `` : e.quantity}
            <input type="${e.no_name !== 1 ? `text` : 'hidden'}" role="textbox" tabIndex="${c}" aria-haspopup="true" class="form-control input-sm text-center rquantity" ${e.no_name !== 1 ? `name="quantity[]"` : 'readonly'} value="${e.quantity}" data-item="${e.product_id}" id="quantity_${c}" onclick="this.select()" onkeyup="validate_qty()">
        </td>
        <td class="text-right">
            <input type="hidden" value="1" id="separate_status_${c}" ${e.no_name !== 1 ? `name="separate_status[]"` : ''} class="pull-left">
            <input type="hidden" value="${e.product_price}" id="pro_subtotal_${c}" ${e.no_name !== 1 ? `name="ssubtotal[]"` : ''}>
            <span class="text-right ssubtotal" id="subtotal_${c}">${formatMoney(e.product_price * e.quantity)}</span>
        </td>
        <td style="background-color:${e.no_name !== 1 ? `orange` : '#c0beb9'}" class="text-center ${e.no_name !== 1 ? `posdel` : ''}">
            ${e.no_name !== 1 ? `<i class="fa fa-trash tip pointer" title="Remove" style="cursor:pointer;border: solid 2px;padding: 10px;border-radius: 30px;"></i>` : '<i class="fa fa-minus" onclick="remove_saved_sale_item_by_login_('+e.id+',this);" style="cursor:pointer;border: solid 2px;padding: 10px;border-radius: 30px;"></i>'}
        </td>`;

    var a = $('<tr id="row_' + c + '" data-row-id="' + c + '" data-ott="'+e.product_ott+'"></tr>').html(f);
    a.prependTo("#posTable");
    grand_total_cal();
    $("#quantity_" + c).focus().select();
}

function enable_(element) {
    $(element).attr('readonly', false);
}

function disable_(element) {
    $(element).attr('readonly', true);
}

var itemQty = 0;

function grand_total_cal(c) {
    var invoice_type = $("input:radio[name='delivery_status']:checked").val();
    
    var sub_total = 0;
    $('.ssubtotal').each(function(a,b){
        sub_total += parseFloat(accounting.unformat($(this).text()));
    });

    $("#sub_total").text(formatMoney(sub_total));

    var tot_discount = $("#order_discount_input").val() ? $("#order_discount_input").val() : "0";
    var discount = 0;

    if(tot_discount != ""){
        if (tot_discount.indexOf("%") !== -1) { 
            var e = tot_discount.split("%");
            if (!isNaN(e[0])) {
                discount = formatDecimal((sub_total * parseFloat(e[0])) / 100);
            } else {
                discount = formatDecimal(tot_discount)
            }
        } else {
            discount = formatDecimal(tot_discount)
        }
    }
    var extra_charges_amount = 0; /*console.log('dine type:'+invoice_type);*/
    itemQty = $("#posTable >tbody > tr").length;
    if (itemQty < 1) $('#sc_sp').css('visibility', 'hidden');
    sub_total += extra_charges_amount;
    $("input#discount").val(discount);
    $("span#titems").text(itemQty)
    var posshipping = $("#posshipping").val();
    if (invoice_type == 3) {
        
    } else {
        
    }
    
    var g_total = sub_total - discount + parseInt(posshipping);
    var pay_cash = parseFloat($("#pay_cash").val());
    var pay_cc = parseFloat($("#pay_cc").val());
    //$('#td_paying_amount').text(formatMoney(pay_cash + pay_cc));
    $('#pay_amount').val(pay_cash + pay_cc);
    var cash_balance = pay_cash + pay_cc - g_total;
    $("span#gtotal").text(formatMoney(g_total));
    if (parseFloat(g_total) === 0) {
        $("span#cash_balance").text(formatMoney(0));
        $("#td_balance_amount").text(formatMoney(0));
    } else {
        $("span#cash_balance").text(formatMoney(cash_balance));
        $("#td_balance_amount").text(formatMoney(cash_balance));
    }
    
    $("#grand_total").val(g_total);
}
$("#ppdiscount").click(function(a) {
    a.preventDefault();
    $("#dsModal").modal();
});
/*Discount modal*/
$("#dsModal").on("shown.bs.modal", function() {
    $(this).find("#order_discount_input").select().focus();
    $("input#order_discount_input").bind("keypress", function(b) {
        if (b.keyCode == 13) {
            b.preventDefault();
            var a = $("#order_discount_input").val() ? $("#order_discount_input").val() : "0";
            if (is_valid_discount(a)) {
                if (is_valid_discount(a)) {
                    //$("#discount_amount").text(formatMoney(a));
                    $("#discount_amount").text(a);
                    $("#discount").val(a);
                    localStorage.removeItem("discount");
                    localStorage.setItem("discount", a);
                    $("#pos_discount_input").val(a);
                } else {
                    bootbox.alert(lang.unexpected_value)
                }
                $("#dsModal").modal("hide");
                grand_total_cal()
            } else {
                bootbox.alert(lang.unexpected_value)
            }
            $("#dsModal").modal("hide")
        }
    })
});

$(document).on("click", "#updateOrderDiscount", function() {
    var a = $("#order_discount_input").val() ? $("#order_discount_input").val() : "0";
    if (is_valid_discount(a)) {
        /*
        localStorage.removeItem("discount");
        localStorage.setItem("discount", a);
        */
        /*Discount*/
        var total_amount = parseFloat(accounting.unformat($('#sub_total').text()));
        var tot_discount = $("#order_discount_input").val() ? $("#order_discount_input").val() : "0";
        var discount = 0;
        
        if(tot_discount != ""){
            if (tot_discount.indexOf("%") !== -1) { 
                var e = tot_discount.split("%");
                if (!isNaN(e[0])) {
                    discount = formatDecimal((total_amount * parseFloat(e[0])) / 100);
                } else {
                    discount = formatDecimal(tot_discount)
                }
            } else {
                discount = formatDecimal(tot_discount)
            }
        }
        
        if(total_amount < discount){
            bootbox.alert("Discount is higher than bill value!");
            $("#pos_discount_input").val("")
            $("#order_discount_input").val("")
            return;
        }
        $("#discount_amount").text(a);
        $("#discount").val(a);
        $("#pos_discount_input").val(a);
    } else {
        bootbox.alert(lang.unexpected_value)
    }
    $("#dsModal").modal("hide");
    grand_total_cal()
});
$("#payment").click(function(b) {
    return false;
    if (itemQty > 0) {
        var a = $('.cb_list input[type="radio"]:checked:first').val();
        var shipping_address = $("#shipping_address").val();
        var shipping_charges = $("#posshipping").val();
        if (a == 3) {
            if (shipping_address == "") {
                $("#pshipping").click();
                displayNotice("", "Please confirm and update delivery details !!")
            } else if (shipping_charges == 0) {
                bootbox.confirm({
                    size: "small",
                    message: " Delivery charges : Rs. 0.00 /=. Continue ?",
                    callback: function(a) {
                        if (a == true) {
                            load_payment_grid()
                        } else
                            $("#pshipping").click();
                    }
                });
            } else {
                load_payment_grid()
            }
        } else {
            load_payment_grid()
        }
    } else {
        //displayNotice("", "Please add product before payment. Thank you !! ");
        $("#add_item").focus()
    }
});
$("#payment_no_bill").click(function(b) {
    if (itemQty > 0) {
        var a = $('.cb_list input[type="radio"]:checked:first').val();
        var shipping_address = $("#shipping_address").val();
        var shipping_charges = $("#posshipping").val();
        if (a == 3) {
            if (shipping_address == "") {
                $("#pshipping").click();
                displayNotice("", "Please confirm and update delivery details !!")
            } else if (shipping_charges == 0) {
                bootbox.confirm({
                    size: "small",
                    message: " Delivery charges : Rs. 0.00 /=. Continue ?",
                    callback: function(a) {
                        if (a == true) {
                            load_payment_grid()
                        } else
                            $("#pshipping").click();
                    }
                });
            } else {
                load_payment_grid()
            }
        } else {
            load_payment_grid()
        }
    } else {
        displayNotice("", "Please add product before payment. Thank you !! ");
        $("#add_item").focus()
    }
});

function load_payment_grid() {
    $("#paymentModal").modal();
}
$("#paymentModal").on("shown.bs.modal", function() {
    //$('#paid_by_1').val('cash').trigger('change');
    //$("input.amount").focus().select();
}).on("hidden.bs.modal", function(e) {
    /*console.log(e);*/
    $('#add_item').focus();
});
$(document)
    .on("change", ".paid_by", function() {
        var a = $(this).val(),
            c = $(this).attr("id"),
            b = c.substr(c.length - 1);
        $("#rpaidby").val(a);
        if (a == "cash" || a == "other") {
            $(".pcheque_" + b).hide();
            $(".pcc_" + b).hide();
            $(".pcash_" + b).show();
            $("#payment_note_" + b).focus();
            $("#paid_by_val_1").val(a)
        } else {
            if (a == "CC" || a == "stripe" || a == "ppp") {
                $(".pcheque_" + b).hide();
                $(".pcash_" + b).hide();
                $(".pcc_" + b).show();
                $("#swipe_" + b).focus();
                $("#paid_by_val_1").val(a)
            } else {
                if (a == "Cheque") {
                    $(".pcc_" + b).hide();
                    $(".pcash_" + b).hide();
                    $(".pcheque_" + b).show();
                    $("#cheque_no_" + b).focus()
                } else {
                    $(".pcheque_" + b).hide();
                    $(".pcc_" + b).hide();
                    $(".pcash_" + b).hide()
                }
            }
        }
        if (a == "gift_card") {
            $(".gc_" + b).show();
            $(".ngc_" + b).hide();
            $("#gift_card_no_" + b).focus()
        } else {
            $(".ngc_" + b).show();
            $(".gc_" + b).hide();
            $("#gc_details_" + b).html("")
        }
        calculateTotals();
    })
    .on("click", ".quick-cash", function() {
        var a = $(this);
        var e = a.contents().filter(function() {
            return this.nodeType == 3
        }).text();
        var c = ",";
        var d = $("#amount_1");
        e = formatDecimal(e.split(c).join("")) * 1 + remove_comma(d.val()) * 1;
        d.val(formatDecimal(e)).focus().change();
        var b = a.find("span");
        if (b.length == 0) {
            a.append('<span class="badge">1</span>')
        } else {
            b.text(parseInt(b.text()) + 1)
        }
    })
    .on("click", "#clear-cash-notes", function() {
        $(".quick-cash").find(".badge").remove();
        $("#" + pi).val("0").focus()
    })
    .on("focus", ".amount", function() {
        pi = $(this).attr("id");
        calculateTotals()
    }).on("blur", ".amount", function() {
        calculateTotals()
    }).on("keyup", ".amount", function() {
        calculateTotals()
    });

function calculateTotals() {
    // alert(33);
    console.log('calculateTotals....');
    var c = 0;
    var b = remove_comma($("span#twt").text());
    var a = $(".amount");
    $.each(a, function(e) {
        var d = remove_comma($(this).val());
        c += parseFloat(d ? d : 0)
    });
    $("#total_paying").text(formatMoney(c));
    var pay_cash = $("#pay_cash").val();
    // alert(pay_cash);
    //	$("#td_paying_amount").text(formatMoney(c)).parent().css('display','');
    $("#td_paying_amount").text(formatMoney(pay_cash));
    $("#td_paying_by").text($("#paid_by_1").val());
    $("#balance").text(formatMoney(c - b));
    if ((c - b) >= 0) {
        $("#td_balance_amount").text(formatMoney(c - b)).parent().parent().css('display', '');
    }
    //$("#balance_" + pi).val(formatDecimal(c - b));
    total_paid = c;
    grand_total = b
}
$("#pshipping").click(function(a) {
    a.preventDefault();
    shipping = $("#posshipping").val() ? $("#posshipping").val() : shipping;
    $("#shipping_input").val(shipping);
    shippingAddr = $("#shipping_address").val() ? $("#shipping_address").val() : "";
    if (shippingAddr) {
        $("#address_input").val(shippingAddr);
        $("#sModal").modal()
    } else {
        getAddressByCusId()
    }
});

function getAddressByCusId() {
    var b = "";
    var a = $("#poscustomer").val();
    $.ajax({
        type: "get",
        url: site.base_url + "pos/get_customers",
        data: {
            srh_customer_id: a
        },
        dataType: "json",
        success: function(c) {
            if (c !== null) {
                b = c[0].cus_address;
                $("#address_input").val(b);
                $("#sModal").modal();
                return b
            } else {
                bootbox.alert("No result found!")
            }
        }
    })
}
/*$("#sModal").on("shown.bs.modal", function() {
    $(this).find("#shipping_input").select().focus()
});*/
$("#sModal").on("shown.bs.modal", function() {
    $(this).find("#shipping_input").select().focus();
    $("input#shipping_input").bind("keypress", function(b) {
        if (b.keyCode == 13) {
            b.preventDefault();
            var a = parseFloat($("#shipping_input").val() ? $("#shipping_input").val() : "0");
            if (is_numeric(a)) {
                $("#posshipping").val(a);
                localStorage.setItem("posshipping", a);
                grand_total_cal();
                $("#sModal").modal("hide")
            } else {
                bootbox.alert(lang.unexpected_value)
            }
        }
    })
});
$(document).on("click", "#updateShipping", function() {
    var b = parseFloat($("#shipping_input").val() ? $("#shipping_input").val() : "0");
    var a = $("#address_input").val();
    $("#shipping_address").val(a);
    if (is_numeric(b)) {
        $("#posshipping").val(b);
        localStorage.setItem("posshipping", b);
        grand_total_cal();
        $("#sModal").modal("hide")
    } else {
        bootbox.alert(lang.unexpected_value)
    }
});
$("#paymentModal").on("change", "#amount_1", function(a) {
    $("#pay_amount").val(remove_comma($(this).val()))
}).on("blur", "#amount_1", function(a) {
    $("#pay_amount").val(remove_comma($(this).val()))
}).on("change", "#payment_note_1", function(b) {
    $("#pos_note").val($(this).val());
    var a = $("#pos_note").val();
    localStorage.setItem("posnote", a);
}).on("change", "#swipe_1", function(a) {
    $("#cc_name").val($(this).val())
}).on("change", ".pcc_type", function(a) {
    $("#pcc_type").val($(this).val())
}).on("change", "#pcc_holder_1", function(a) {
    $("#pcc_holder").val($(this).val())
}).on("change", "#pcc_no_1", function(a) {
    $("#cc_no").val($(this).val())
});
/*function fbs_click(a) {
    u = location.href;
    t = document.title;
    window.open(site.base_url + "sales/sale_details?sale_id=" + a, "sharer", "toolbar=0,status=0,width=384,height=700, left=10, top=10,scrollbars=yes");
    return false
}
*/
$(window).keydown(function(a) {
    if (a.altKey) {
        if (a.key == 5) printElem("drawer")
    }
});

function displayNotice(a, b) {
    $.gritter.add({
        title: "Notice!",
        text: b,
        image: "",
        sticky: false,
        time: "100"
    });
    return false
}

function printElem(b) {
    var c = document.getElementById(b).innerHTML;
    var a = window.open("", "Print", "height=1,width=1");
    a.document.close();
    a.focus();
    a.print();
    a.close();
    return true
};
function generateTables(num) {
    var selectElement = document.getElementById('table_id');
    for (let i = 1; i <= num; i++) {
        var option = document.createElement('option');
        option.className = 'opt_' + i;
        option.value = i;
        option.textContent = 'Table ' + (i < 10 ? '0' : '') + i;
        selectElement.appendChild(option);
    }
}
function remove_comma(a) {
    return parseFloat(a.replace(/,/g, ""))
}

function formatDecimal(a) {
    return parseFloat(parseFloat(a).toFixed(site.settings.decimals))
}

function formatMoney(a, b) {
    if (!b) {
        b = ""
    }
    if (site.settings.sac == 1) {
        return b + "" + formatSA(parseFloat(a).toFixed(site.settings.decimals))
    }
    return accounting.formatMoney(a, b, site.settings.decimals, site.settings.thousands_sep == 0 ? " " : site.settings.thousands_sep, site.settings.decimals_sep, "%s%v")
}

function getNumber(a) {
    return accounting.unformat(a)
}

function formatQuantity(a) {
    return (a != null) ? '<div class="text-center">' + formatNumber(a, site.settings.qty_decimals) + "</div>" : ""
}

function formatNumber(a, b) {
    if (!b && b != 0) {
        b = site.settings.decimals
    }
    if (site.settings.sac == 1) {
        return formatSA(parseFloat(a).toFixed(b))
    }
    return accounting.formatNumber(a, b, site.settings.thousands_sep == 0 ? " " : site.settings.thousands_sep, site.settings.decimals_sep)
}

function formatMoney(a, b) {
    if (!b) {
        b = ""
    }
    if (site.settings.sac == 1) {
        return b + "" + formatSA(parseFloat(a).toFixed(site.settings.decimals))
    }
    return accounting.formatMoney(a, b, site.settings.decimals, site.settings.thousands_sep == 0 ? " " : site.settings.thousands_sep, site.settings.decimals_sep, "%s%v")
}

function formatDecimal(a) {
    return parseFloat(parseFloat(a).toFixed(site.settings.decimals))
}

function is_valid_discount(a) {
    return (is_numeric(a) || (/([0-9]%)/i.test(a))) ? true : false
}

function is_numeric(b) {
    var a = " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
    return (typeof b === "number" || (typeof b === "string" && a.indexOf(b.slice(-1)) === -1)) && b !== "" && !isNaN(b)
}

function is_float(a) {
    return +a === a && (!isFinite(a) || !!(a % 1))
}

function currencyFormat(a) {
    if (a != null) {
        return formatMoney(a)
    } else {
        return "0"
    }
}

function formatSA(b) {
    b = b.toString();
    var d = "";
    if (b.indexOf(".") > 0) {
        d = b.substring(b.indexOf("."), b.length)
    }
    b = Math.floor(b);
    b = b.toString();
    var c = b.substring(b.length - 3);
    var a = b.substring(0, b.length - 3);
    if (a != "") {
        c = "," + c
    }
    var e = a.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + c + d;
    return e
}
$('.panel-refresh').click(function(e) {
    e.preventDefault();
    if (e.target.id == 'delivery-panel-refresh')
        loadDelivery();
    else if (e.target.id == 'takeaway-panel-refresh')
        loadTakeaway();
    else if (e.target.id == 'dine_in-panel-refresh')
        loadDineIn();
});
$('input').on('ifChecked', function(event) {
    if (event.target.value == 1) {
        $('#content').css('background-color', '#d9534f');
        $('.hide_me').css('visibility', 'hidden');
        grand_total_cal();
    }
    if (event.target.value == 2) {
        $('#content').css('background-color', '#5cb85c');
        $('.hide_me').css('visibility', 'hidden');
        grand_total_cal();
    }
    if (event.target.value == 3) {
        $('#content').css('background-color', '#eea236');
        $('.hide_me').css('visibility', 'visible');
        grand_total_cal();
    }
});

var radioButtons = document.querySelectorAll('.ds');
// Add event listener to each radio button
radioButtons.forEach(function(radio) {
    radio.addEventListener('change', function() {
        console.log('radio', this);
        grand_total_cal();
    });
});

$("#view_bill").click(function(b) {
    b.preventDefault();
    $("#view_bill_modal").modal();
});
$("#pay_cash").bind("keypress", function(b) {
    if (b.keyCode == 13) {
        b.preventDefault();
        //$("#payment").click();
         $("#pay_cc").focus();
         $("#pay_cc").select();
    }
});
$("#pay_cc").bind("keypress", function(b) {
    if (b.keyCode == 13) {
        b.preventDefault();
        $("#pay_cc").blur();
        form_submit();
    }
});


function get_itm_discount(row_id){
    var discount_val = $('#product_discount_amount_'+row_id).val();
    if(discount_val !== ''){
        return parseFloat(discount_val);
    }
    return 0;
}

function set_date(){
    var today = new Date();

    // Calculate tomorrow's date
    var tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);

    // Calculate one month from tomorrow
    var oneMonthFromTomorrow = new Date(tomorrow);
    oneMonthFromTomorrow.setMonth(oneMonthFromTomorrow.getMonth() + 1);

    // Format the dates in the required format (YYYY-MM-DD)
    var tomorrowFormatted = tomorrow.toISOString().split('T')[0];
    var oneMonthFromTomorrowFormatted = oneMonthFromTomorrow.toISOString().split('T')[0];

    // Set the minimum and maximum attributes of the date input field
    document.getElementById('delivery_date').setAttribute('min', tomorrowFormatted);
    document.getElementById('delivery_date').setAttribute('max', oneMonthFromTomorrowFormatted);
}
function validatePhoneNumber(phoneNumber) {
    
    // Regular expression for validating phone numbers
    var phoneRegex = /^\d{10}$/;

    // Test the input phone number against the regex pattern
    var r =phoneRegex.test(phoneNumber);
    if(!r)
        bootbox.alert('Invalid Phone number : '+ phoneNumber);
    return r;
}