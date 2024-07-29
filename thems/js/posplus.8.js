var positems = {};
var site = {
        base_url: "http://localhost/inventry_pos/",
        cashierFloatId: 0,
        onprocess: false,
        cashierName: "",
        userID: "",
        wh_code: "",
        wh_name: "",
        wh_address: "",
        wh_phone: "",
        wh_email: "",
        numTables: 45,
        kot: false,
        pc: 0,
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

var rowCount = $("#posTable > tbody > tr").length;
setInterval(function() {
    $(".alert").hide("blind", {}, 500)
}, 15000);

function check_terminal() {
    var terminal_id = $('#terminal_id').val();
    var terminals = JSON.parse(localStorage.getItem('terminals')) || [];

    if (!terminals.includes(terminal_id)) {
        console.error("Terminal Error:",terminals);
        bootbox.alert('Page has expired',function(){
            $('body').empty();
            window.close();
        });
    }

    if ($('#continued').val() !== '0') {
        window.location.reload();
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
    var price = parseFloat($('#pro_price_' + row_id).val());

    var itm_discount = get_itm_discount(row_id);
    price -= itm_discount;
    var sub_total = new_quantity * price;

    $('#pro_subtotal_' + row_id).val(sub_total);
    $('#subtotal_' + row_id).text(sub_total.toFixed(2));

    grand_total_cal();
}).on("change", ".rprice", function() {
    var b = $(this).closest("tr");
    if (!is_numeric($(this).val()) || parseFloat($(this).val()) === 0) {
        $(this).val(1);
    } else {

    }
    var row_id = $(b).data('row-id');
    var new_quantity = parseFloat($('#quantity_' + row_id).val());
    var price = parseFloat($(this).val());

    var itm_discount = get_itm_discount(row_id);
    price -= itm_discount;

    var sub_total = new_quantity * price;

    $('#pro_subtotal_' + row_id).val(sub_total);
    $('#subtotal_' + row_id).text(sub_total.toFixed(2));

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
    }
    grand_total_cal();
}).on("keyup", ".rquantity", function() {
    grand_total_cal();
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
}).keypress(function(event) {
    if (String.fromCharCode(event.which) == "'") {
        event.preventDefault();
        //displayNotice("page", " Character you typed is not allowed !! ");
    }
});

function open_tab(tab_id) {
    $('a[href="#' + tab_id + '"]').tab('show');
}

function change_deli_type(elem) {
    if ($(elem).val() == 1) {
        $('#store_id_div').show();
        $('#delivery_address_div').hide();
    } else {
        $('#store_id_div').hide();
        $('#delivery_address_div').show();
    }
}
function apply_ac(){
    $("#add_item").autocomplete({
        source: jsonarray,
        minLength: 1,
        autoFocus: false,
        delay: 200,
        response: function(b, c) {
            //console.log($(this).val().length);
            if ($(this).val().length >= 16 && c.content[0].id === 0) {
                //alert(2);
                $(this).val("");
                $("#add_item").val("").removeClass("ui-autocomplete-loading")
            } else {
                if (c.content.length == 1 && c.content[0].id !== 0) {
                    /*console.log(c.content[0].id);*/
                    //select item
                    //$(this).val("");
                    //	alert(JSON.stringify(c.content[0]));
                    validate_item(c.content[0]);
                    $(this).val("");
                    //$(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', c);
                } else {
                    if (c.content.length == 1 && c.content[0].id === 0) {
                        $(this).val("");
                        $("#add_item").val("").removeClass("ui-autocomplete-loading");
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
}

$("input[type=text] select").focus(function() {
    if (this.id != "") {
        $("#id-name").val(this.id)
    }
});
 
function divideCssValue(cssValue, divisor) {
    // Extract the numeric part from the CSS value string
    const numericValue = parseFloat(cssValue);
    // Divide the numeric value by the given divisor
    var result = numericValue / divisor;
    const padding = 4; /*px*/
    result = result - (padding * divisor);
    // Return the result as a string with 'px' appended
    return Math.round(result) + 'px';
}

function widthFunctions(cols) {
    console.warn("widthFunctions");
    $('#main_panel').css('height', $(window).height() - $('#header').height());
    $('#cpinner').css('height', $('#leftdiv').height());
    
    var item_list_length = $('#item-list').css('width');
    var btn_length = divideCssValue(item_list_length, cols);
    $('.item_btn_1').css('width',btn_length)
}

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
    wh = $("#poswarehouse").val(), cu = $('#cus_id').val();
    var product = {
        "product_id": product_id
    };
    validate_item(product);
    $("#modal-loading").hide();
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
    wh = $("#poswarehouse").val(), cu = $('#cus_id').val();
    var product = {
        "product_id": product_id,
        "product_id_sub": product_id_sub,
        "product_code": product_code,
        "product_name": product_name,
        "product_price": product_price,
        "product_ott": product_ott,
        "discount": 0,
        "discount_val": 0,
        "quantity": 1,
        "no_name": 0
    };
    /*console.log(product);*/
    add_to_list(product);
    $("#modal-loading").hide();
}).on("click", ".posdel", function(b) {
    var c = $(this).closest("tr");
    var tr_id = $(c).attr('id');
    remove_sale_item_by_login(tr_id);
}).on("click", "#save", function() {
    this.disabled = true;
    this.blur();
    setTimeout(()=>{
        form_submit();
    },100);
});

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
    var price_type_id = $("input:radio[name='delivery_status']:checked").val();
    var priceFound = false; // Flag to track if a price is found

    if (Object.keys(prices).length) {
        var priceKeys = Object.keys(prices);
        for (var i = 0; i < priceKeys.length; i++) {
            var a = priceKeys[i];
            var pti = prices[a];

            if (pti.pt_id == price_type_id) {
                priceFound = true; // Set the flag to true when a price is found

                if (Object.keys(pti.amount).length > 1) {
                    // Create price selection modal
                    $('#select_price_modal .modal-body').empty();
                    var prd_btn = '';

                    var modalBody = document.querySelector('#select_price_modal .modal-body');
                    modalBody.innerHTML = '';

                    $.each(pti.amount, (c, d) => {
                        prd_btn += '<button type="button" class="price-square product_validated" ott="' + item.product_ott + '" product_price="' + d + '" title="' + item.product_id + '" product_id="' + item.product_id + '" product_name="' + item.product_name + '">Rs. ' + d + '</button>';
                    });

                    $('#select_price_modal .modal-body').html(prd_btn);
                    $('#select_price_modal').modal();
                } else {
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
                        "discount": 0,
                        "discount_val": 0,
                        "quantity": 1,
                        "no_name": 0
                    };
                    add_to_list(product);
                    $("#select_price_modal").modal('hide');
                    $("#modal-loading").hide();
                }
                break;
            }
        }
    }

    if (!priceFound) {
        var str = $(':radio[name=delivery_status]:checked').parent().find('span').html();
        
        // Remove leading and trailing whitespace
        str.trim();
        
        // Replace multiple spaces and newlines with a single space
        //str = str.replace(/\s+/g, ' ');
        bootbox.alert("No prices found for:"+ str,()=>{
            $('#add_item').focus();
        });
    }
}

function validate_price_type(){
    if($('#posTable > tbody > tr').length){
        $('.price_type:not(.active)').addClass('disabled').removeAttr('href');
    }else{
        $('.price_type').removeClass('disabled').attr('href','javascript:;');
    }
}
function sanitize_item(item) {
    item = products[item.product_id];
    $("#qty_en_tot").val('');
    var prices = item.product_prices;
    var price_type_id = $("input:radio[name='delivery_status']:checked").val();
    if (Object.keys(prices).length) {
        var priceKeys = Object.keys(prices);
        for (var i = 0; i < priceKeys.length; i++) {
            var a = priceKeys[i];
            var pti = prices[a];
            if (pti.pt_id == price_type_id) {
                if (Object.keys(pti.amount).length > 1) {
                    $.each(pti.amount, (c, d) => {
                        if (parseFloat(d) > 0)
                            return true;
                        else
                            console.log('else one: ',item);
                    });
                } else {
                    // Get an array of values
                    var values = Object.values(pti.amount);
                    // Access the value of the first key without using the key name
                    var product_price = values[0];
                    if (parseFloat(product_price) > 0)
                        return true;
                    else
                        console.log('else two: ',item);
                }
                return false;
            }else {
                return true;
            };
        }
    } else {
        /*console.log('else four: ',item)*/
        return false
    };
}

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
        /*console.log('went through this shit');*/
    }

    var f = `<td style="overflow: visible;max-width: 50px;">
                <input type="hidden" value="${e.product_id}" class="rid" ${e.no_name !== 1 ? `name="product_id[]"` : ''}  id="product_id_${c}">
                <input type="hidden" value="${e.product_ott}" class="rid" ${e.no_name !== 1 ? `name="product_ott[]"` : ''}  id="product_ott_${c}">
                <input type="hidden" value="${e.product_code}" class="rcode" ${e.no_name !== 1 ? `name="product_code[]"` : ''}  id="product_code_${c}">
                <input type="hidden" value="${print_status}" id="print_status_${c}" ${e.no_name !== 1 ? `name="print_status[]"` : ''}>
                <input type="hidden" value="${e.product_name}" ${e.no_name !== 1 ? `name="product_name[]"` : ''}  id="product_name_${c}">
                <input type="hidden" value="${e.discount}" ${e.no_name !== 1 ? `name="product_discount[]"` : ''} id="product_discount_${c}">
                <input type="hidden" value="${e.discount_val}" ${e.no_name !== 1 ? `name="product_discount_amount[]"` : ''}  id="product_discount_amount_${c}">
                
                <span style="text-wrap: nowrap;">${e.product_name}</span>
                <button type="button" class="btn btn-default ${e.no_name !== 1 ? `itm_discount` : `collapse`}" style="float: right;">${ e.discount_val > 0 ? e.discount+` Dis` : `<i class="fa fa-percent"></i>` }</button>
        </td>
        <td class="text-right" style="vertical-align: bottom !important;">
            ${e.no_name !== 1 ? `` : e.product_price}
            <input class="form-control input-sm text-center rprice" style="width:100%;" type="${e.no_name !== 1 ? `number` : 'hidden'}" value="${e.product_price}" id="pro_price_${c}" ${e.no_name !== 1 ? `name="net_price[]" readonly` : 'readonly'} onClick="this.select()">
        </td>
        <td style="vertical-align: bottom !important;">
            ${e.no_name !== 1 ? `` : e.quantity}
            <input type="${e.no_name !== 1 ? `text` : 'hidden'}" role="textbox" tabIndex="${c}" aria-haspopup="true" class="form-control input-sm text-center rquantity" ${e.no_name !== 1 ? `name="quantity[]"` : 'readonly'} value="${e.quantity}" data-item="${e.product_id}" id="quantity_${c}" onclick="this.select()" onkeyup="validate_qty()" onkeypress="return isDecimal(event)">
        </td>
        <td class="text-right"  style="vertical-align: bottom !important;">
            <input type="hidden" value="1" id="separate_status_${c}" ${e.no_name !== 1 ? `name="separate_status[]"` : ''} class="pull-left">
            <input type="hidden" value="${e.product_price}" id="pro_subtotal_${c}" ${e.no_name !== 1 ? `name="ssubtotal[]"` : ''}>
            <span class="text-right ssubtotal" id="subtotal_${c}">${formatMoney(e.product_price * e.quantity)}</span>
        </td>
        <td style="background-color:${e.no_name !== 1 ? `orange` : '#c0beb9'}" class="text-center ${e.no_name !== 1 ? `posdel` : ''}">
            ${e.no_name !== 1 ? `<i class="fa fa-trash tip pointer" title="Remove" style="cursor:pointer;border: solid 2px;padding: 10px;border-radius: 30px;"></i>` : '<i class="fa fa-minus" onclick="remove_saved_sale_item_by_login_('+e.id+',this);" style="cursor:pointer;border: solid 2px;padding: 10px;border-radius: 30px;"></i>'}
        </td>`;

    var a = $('<tr id="row_' + c + '" data-row-id="' + c + '" data-ott="' + e.product_ott + '"></tr>').html(f);
    a.prependTo("#posTable");
    grand_total_cal();
    $("#quantity_" + c).focus().select();
    if(parseInt(e.is_rti) == 1)
        gs(e.product_id, "row_" + c);
}


function grand_total_cal(c) {
    
    validate_price_type();
    
    var invoice_type = $("input:radio[name='delivery_status']:checked").val();

    var sub_total = 0;
    $('.ssubtotal').each(function(a, b) {
        sub_total += parseFloat(accounting.unformat($(this).text()));
    });

    $("#sub_total").text(formatMoney(sub_total));

    var tot_discount = $("#order_discount_input").val() ? $("#order_discount_input").val() : "0";
    var discount = 0;

    if (tot_discount != "") {
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
    var itemQty = $("#posTable >tbody > tr").length;
    if (itemQty < 1) $('#sc_sp').css('visibility', 'hidden');
    sub_total += extra_charges_amount;
    $("input#discount").val(discount);
    $("span#titems").text(itemQty)
    var posshipping = $("#posshipping").val();
    if (invoice_type == 3) {

    } else {

    }

    var g_total = sub_total - discount + parseInt(posshipping);
    /*var pay_cash = parseFloat($("#pay_cash").val());
    var pay_cc = parseFloat($("#pay_cc").val());*/
    //$('#td_paying_amount').text(formatMoney(pay_cash + pay_cc));
    $('#pay_amount').val(updateTotal());
    var cash_balance = updateTotal() - g_total;
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

        if (tot_discount != "") {
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

        if (total_amount < discount) {
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

$("#pshipping").click(function(a) {
    a.preventDefault();
    shipping = $("#posshipping").val() ? $("#posshipping").val() : shipping;
    $("#shipping_input").val(shipping);
    shippingAddr = $("#shipping_address").val() ? $("#shipping_address").val() : "";
    if (shippingAddr) {
        $("#address_input").val(shippingAddr);
        $("#sModal").modal();
    } else {
        getAddressByCusId();
    }
});

function getAddressByCusId() {
    var b = "";
    var a = $('#cus_id').val();
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

$(window).keydown(function(a) {
    if (a.altKey) {
        if (a.key == 5) printElem("drawer")
    }
});

function printElem(b) {
    var c = document.getElementById(b).innerHTML;
    var a = window.open("", "Print", "height=1,width=1");
    a.document.close();
    a.focus();
    a.print();
    a.close();
    return true
};

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
function isDecimal(event) {
    const charCode = (event.which) ? event.which : event.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
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
/*$('input').on('ifChecked', function(event) {
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
});*/

var radioButtons = document.querySelectorAll('input[name="delivery_status"]');
// Add event listener to each radio button
radioButtons.forEach(function(radio) {
    radio.addEventListener('change', function() {
        grand_total_cal();
    });
});

$("#view_bill").click(function(b) {
    b.preventDefault();
    $("#view_bill_modal").modal();
});
/*$("#pay_cash").bind("keypress", function(b) {
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
        $('#save').click();
    }
});
*/

function get_itm_discount(row_id) {
    var discount_val = $('#product_discount_amount_' + row_id).val();
    if (discount_val !== '') {
        return parseFloat(discount_val);
    }
    return 0;
}

function validatePhoneNumber(phoneNumber) {

    // Regular expression for validating phone numbers
    var phoneRegex = /^\d{10}$/;

    // Test the input phone number against the regex pattern 
    var r = phoneRegex.test(phoneNumber);
    if (!r) {
        $('#cus_phone').css('box-shadow', 'inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px #E91E63');
        $('#cus_phone').css('border-color', '#E91E63');
    } else {
        $('#cus_phone').css('box-shadow', '');
        $('#cus_phone').css('border-color', '');
    }
    return r;
}