var positems = {};
var site = {
        base_url: "http://localhost/inventry_pos/",
        mousedown_x: '',
        mousedown_y: '',
        mouseup_x: '',
        mouseup_y: '',
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
            printable: false
        },
        dateFormats: {
            js_sdate: "dd/mm/yyyy",
            php_sdate: "d/m/Y",
            mysq_sdate: "%d/%m/%Y",
            js_ldate: "dd/mm/yyyy hh:ii",
            php_ldate: "d/m/Y H:i",
            mysql_ldate: "%d/%m/%Y %H:%i"
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
        extra_charges: 10
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
setInterval(function() {
    if (typeof moment !== "undefined") {
        var a = new moment();
        $("#display_time").text(a.format((site.dateFormats.js_sdate).toUpperCase() + " HH:mm"));
        $("#sale_datetime").val(a.format(("Y-MM-D HH:mm:ss")))
    }
}, 1000);
$(document).ready(function() {
    $(".auto").autoNumeric("init");
    /*$(".pos-tip").tooltip();*/
    $("#poswarehouse").select2({
        allowClear: true,
        minimumResultsForSearch: Infinity
    });
	$("#table_id").select2({
        allowClear: true,
        minimumResultsForSearch: Infinity
    });
    $("#poscustomer").select2({
        allowClear: true
    }).change(function() {
        /*var data = $("#poscustomer").select2('data');*/
        $('#bill_customer').text('Customer:' + (($("#poscustomer").select2('data')).text).split('-')[0].replace('-', ''));
    });
    $("#category").select2({
        allowClear: true
    });
    $('input[type="checkbox"].red, input[type="radio"].red').iCheck({
        checkboxClass: "icheckbox_minimal-red",
        radioClass: "iradio_minimal-red",
    });
    $('input[type="checkbox"].green, input[type="radio"].green').iCheck({
        checkboxClass: "icheckbox_minimal-green",
        radioClass: "iradio_minimal-green",
    });
    $('input[type="checkbox"].orange, input[type="radio"].orange').iCheck({
        checkboxClass: "icheckbox_minimal-orange",
        radioClass: "iradio_minimal-orange",
    });
    $('input[type="checkbox"].divi_1, input[type="radio"].divi_1').iCheck({
        checkboxClass: "icheckbox_minimal-orange",
        radioClass: "iradio_minimal-orange",
    });
    $('input[type="checkbox"].divi_2, input[type="radio"].divi_2').iCheck({
        checkboxClass: "icheckbox_minimal-orange",
        radioClass: "iradio_minimal-orange",
    });
    $("#bill_customer").text('Customer:' + (($("#poscustomer").select2('data')).text).split('-')[0].replace('-', ''));
    $("#add_item").focus();
    $("#modal-loading").hide();
    localStorage.clear();
    localStorage.setItem("reload", 1);
    $(window).resize();
    widthFunctions();
    /*$("#product-list").css("min-height", 90);*/
	setInterval(function(){
		loadDelivery();
		},5000);
}).ajaxStart(function() {
    //$("#modal-loading").show();
    //$("#modal-loading").css("z-index", "9999");
}).ajaxStop(function() {
    //$("#modal-loading").hide();
}).on("change", ".rquantity", function() {
    var b = $(this).closest("tr");
    if (!is_numeric($(this).val()) || parseFloat($(this).val()) == 0) {
        $(this).val(1);
        /*bootbox.alert(lang.unexpected_value);*/
        return
    } else {
        /*console.log('change');*/
		var product_id = $(b).attr('data-item-id');
		$('#item_count-'+product_id).text($(this).val());
        grand_total_cal();
    }
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
        $(this).val(1).focus().select();
        return false;
    } else {
        /*console.log('keyup');*/
        grand_total_cal();
    }
}).on("click", ".rquantity", function() {
        
		setTimeout(function(){
		$(this).select();	
			},2000);
		//$(this).val(null);
		
}).on("click", "#reset", function() {
    bootbox.confirm({
        size: "small",
        message: "Are you sure?",
        callback: function(a) {
            if (a == true) {
                $("#posTable tbody").empty();
                grand_total_cal(0);
                $("input#posdiscount").val(0);
                $("#tds").text(0);
                $("input#posshipping").val(0);
                $("#tship").text(0);
                localStorage.clear();
                form_clear();
                form_locate();
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
        displayNotice("page", " Character you typed is not allowed !! ");
    }
    if (event.ctrlKey === true) {
        if (event.key == '1') {
            event.preventDefault();
            open_tab('Sales');
        } else
        if (event.key == '2') {
            event.preventDefault();
            open_tab('dine_in');
        } else
        if (event.key == '3') {
            event.preventDefault();
            open_tab('take_away');
        } else
        if (event.key == '4') {
            event.preventDefault();
            open_tab('delivery');
        } else
        if (event.key == '5') {
            event.preventDefault();
            open_tab('add_product');
        }
    }
});

function open_tab(tab_id) {
    $('a[href="#' + tab_id + '"]').tab('show');
}
$("#add_item").autocomplete({
    source: jsonarray,
    minLength: 1,
    autoFocus: false,
    delay: 200,
    response: function(b, c) {
        if ($(this).val().length >= 16 && c.content[0].id == 0) {
            $(this).val("");
            $("#add_item").val("").removeClass("ui-autocomplete-loading")
        } else {
            if (c.content.length == 1 && c.content[0].id != 0) {} else {
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
            var d = add_invoice_item(c.item,'');
            if (d) {
                $(this).val("")
            }
            $("#add_item").val("").removeClass("ui-autocomplete-loading")
        } else {
            bootbox.alert("No matching result found! Product might be out of stock in the selected warehouse.")
        }
    }
});
$("#poswarehouse").change(function(a) {
    localStorage.setItem("poswarehouse", $(this).val())
});
$("#poscustomer").change(function(a) {
    localStorage.setItem("poscustomer", $(this).val())
});
$("#clearLS").click(function() {
    localStorage.clear();
    localStorage.setItem("clear", 1)
})
$("#add_item").bind("keypress", function(b) {
    if (b.keyCode == 13) {
        b.preventDefault();
        $("#payment").click();
        $(this).autocomplete("search")
    }
});
$("#posTable").bind("keypress", function(b) {
    //console.log( b.key );
    b.shiftKey == false;
    if (b.key != 'Backspace')
        if (b.which < 46 || b.which > 57) {
            b.preventDefault()
        } else {
            if (b.which < 93 || b.which > 105) {} else {}
        }
});
$(".open-category").click(function() {
    $("#category-slider").toggle("slide", {
        direction: "right"
    }, 300)
});
$(".open-subcategory").click(function() {
    $("#subcategory-slider").toggle("slide", {
        direction: "right"
    }, 300)
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
$(window).bind("resize", widthFunctions);

function widthFunctions(d) {
    var b = $(window).height(),
        c = $("#left-top").height(),
        a = $("#left-bottom").height();
    $(".item-list").css("height", b - 122);
    $(".item-list").css("min-height", 538);
    $("#left-middle").css("height", b - c - a - 150);
    $("#left-middle").css("min-height", 200);
    $("#product-list").css("height", b - c - a - 117);
    $("#product-list").css("min-height", 232);
	$("#cpinner").css("min-height", 534);
    $(".select2-container").css("width", "100%");
	$('.item-list').css("height","100%");
}
var product_variant = 0,
    shipping = 0,
    p_page = 0,
    per_page = 0,
    tcp = "8",
    cat_id = "8",
    ocat_id = "1",
    sub_cat_id = 0,
    osub_cat_id
/*,



    DT = 1*/
;
var base_url = $("#base_url").val();
$(document)/*.on("click", ".category", function() {
        if (cat_id != $(this).val()) {
            $("#modal-loading").show("fast");
            $("#open-category").click();
            cat_id = $(this).val();
            $.ajax({
                type: "get",
                url: base_url + "pos/ajaxcategorydata",
                data: {
                    category_id: cat_id
                },
                dataType: "json",
                success: function(c) {
                    $("#item-list").empty();
                    var d = $('<div id="scrollable"></div>');
                    d.html(c.products);
                    d.appendTo("#item-list");
                    $("#subcategory-list").empty();
                    var b = $("<div></div>");
                    b.html(c.subcategories);
                    b.appendTo("#subcategory-list");
                    tcp = c.tcp;
                    //scrollMe()
                }
            }).done(function() {
                p_page = "n";
                $("#category-" + cat_id).addClass("active");
                if (cat_id != ocat_id) {
                    $("#category-" + ocat_id).removeAttr("style");
                    $("#category-" + ocat_id).removeClass("active")
                }
                $(".active").css("background-color", "#999");
                ocat_id = cat_id;
                $("#modal-loading").hide();
                $(".pos-tip").tooltip()
            })
        }
    }).on("click", ".subcategory", function() {
        $("#modal-loading").show();
        if (sub_cat_id != $(this).val()) {
            $("#open-subcategory").click();
            sub_cat_id = $(this).val();
            $.ajax({
                type: "get",
                url: base_url + "pos/ajaxproducts",
                data: {
                    category_id: cat_id,
                    subcategory_id: sub_cat_id,
                    per_page: p_page
                },
                dataType: "html",
                success: function(a) {
                    $("#item-list").empty();
                    var b = $('<div id="scrollable"></div>');
                    b.html(a);
                    b.appendTo("#item-list");
                    //scrollMe()
                }
            }).done(function() {
                p_page = "n";
                $("#subcategory-" + sub_cat_id).addClass("active");
                $("#subcategory-" + osub_cat_id).removeClass("active");
                osub_cat_id = sub_cat_id;
                $("#modal-loading").hide();
                $(".pos-tip").tooltip()
            })
        }
    })*/
    /*.on("click", ".product", function(a) {
    	
    	})*/
    .on("click", ".posdel", function(b) {
        var c = $(this).closest("tr");
        c.remove();
        grand_total_cal();
    }).on("click", "#submit-sale", function() {
        /*console.log('submit sale clicked...');*/
        site.settings.printable = true;
        $("#submit-sale").attr("disabled", true);
        $('#paymentModal').modal('hide');
        form_submit();
    }).on("click", "#save", function() {
		
    if ($("#posTable >tbody > tr").length > 0) {
        var a = $('.cb_list input[type="radio"]:checked:first').val();
		//alert('a:'+a);
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
                bootbox.confirm("Add order ?", function(result){ 
					 if(result == true){
							form_submit_for_kot(result);
					}
				});
            } else $("#pshipping").click();
                    }
                });
            } else {
                bootbox.confirm("Add order ?", function(result){ 
					 if(result == 'true'){
							form_submit_for_kot(result);
					}
				});
            }
        } else if (a == 1){
			//alert('a:'+a);
				var table_id = $('#table_id').val();
				if(table_id == ''){
				bootbox.alert('Please select table number!');
				}else{
					bootbox.confirm("Add order ?", function(result){ 
						if(result == true){
								form_submit_for_kot(result);
						}
					});
				}
           }else{
			   bootbox.confirm("Add order ?", function(result){ 
						if(result == true){
								form_submit_for_kot(result);
						}
					});
			   }
    } else {
        displayNotice("", "Please add product before payment. Thank you !! ");
        $("#add_item").focus()
    }

        /*console.log('submit sale clicked...');*/
        //site.settings.printable = true;
        //$("#submit-sale").attr("disabled", true);
        //$('#paymentModal').modal('hide');
		
        
    })
    /*function stopRKey(a) {

    	var a = (a) ? a : ((event) ? event : null);

    	var b = (a.target) ? a.target : ((a.srcElement) ? a.srcElement : null);

    	if ((a.keyCode == 13) && (b.type == "text")) {

    		return false

    	}

    }

    document.onkeypress = stopRKey;*/
    .on("click", function(b) {
        if (!$(b.target).is(".open-category, .cat-child") && !$(b.target).parents("#category-slider").size() && $("#category-slider").is(":visible")) {
            $("#category-slider").toggle("slide", {
                direction: "right"
            }, 500)
        }
        if (!$(b.target).is(".open-subcategory, .cat-child") && !$(b.target).parents("#subcategory-slider").size() && $("#subcategory-slider").is(":visible")) {
            $("#subcategory-slider").toggle("slide", {
                direction: "right"
            }, 200)
        }
        if (!$(b.target).is(".open-keyboard")) {
            var a = document.activeElement;
            if (a.id != "") {
                $("#id-name").val(a.id)
            }
        }
    }).on("mousedown", ".product", function(event) {
        var x = event.clientX;
        var y = event.clientY;
        site.mousedown_x = x;
        site.mousedown_y = y;
        /*var coords = "X coords: " + x + ", Y coords: " + y;
        console.log(coords);*/
    }).on("mouseup", ".product", function(event) {
        var x = event.clientX;
        var y = event.clientY;
        /*site.mouseup_x =x;
        site.mouseup_y =y;
        var coords = "X coords: " + x + ", Y coords: " + y;
        console.log(coords);*/
        if (site.mousedown_x == x) add_products_to_pos_table(event);
       /* else console.log('dragged');*/
    });

function add_products_to_pos_table(a) {
	var target_id = '';
    function randomIntFromInterval(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    }
	target_id = a.target.id;
    /*console.log($('#'+(a.target.id)).attr('value'));*/
    var po = {};
    var id = randomIntFromInterval(1000, 9999);
    var label = $('#' + (target_id)).attr('value') + '|' + $('#' + (target_id)).attr('data-original-title');
    var product_code	= $('#' + (target_id)).attr('value');
    var product_id 		= $('#' + (target_id)).attr('product_id');
    var product_name 	= $('#' + (target_id)).attr('data-original-title');
    var product_price 	= $('#' + (target_id)).attr('product_price');
    var value 			= $('#' + (target_id)).attr('value');
    po.id = id;
    po.label = label;
    po.product_code = product_code;
    po.product_id = product_id;
    po.product_name = product_name;
    po.product_price = product_price;
    po.value = product_name;
    //po.product_id
    /*console.log(po);*/
    /*$("#modal-loading").show();*/
    add_invoice_item(po,'');
    /*$("#modal-loading").hide();*/
    /*code = $(this).val(), wh = $("#poswarehouse").val(), cu = $("#poscustomer").val();
        $.ajax({
            type: "get",
            url: base_url + "pos/getProductDataByCode",
            data: {
                code: code,
                warehouse_id: wh,
                customer_id: cu
            },
            dataType: "json",
            success: function(b) {
                a.preventDefault();
                if (b !== null) {
					console.log(b[0]);
                    add_invoice_item(b[0]);
                    $("#modal-loading").hide()
                } else {
                    bootbox.alert("No matching result found! Product might be out of stock in the selected warehouse.");
                    $("#modal-loading").hide()
                }
            }
        })*/
}
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
    var a = $("#product_id_" + pc).val();
    if (a) {
        var d = $("#product_id_" + pc).attr('row_id');
        var c = "#quantity_" + d;
        var h = parseFloat($(c).val());
        $(c).val(h + 1);
		//alert(pc);
		$('#item_count-'+pc).text(h+1);
        grand_total_cal();
        //document.getElementById("quantity_" + d).focus();
        //document.getElementById("quantity_" + d).select();
        return 1
    }
}

function add_invoice_item(c,status) {
	//alert(status);
	//console.log(c[0].id);
	//console.log(c);
	var row = c[0];//console.log(c.id);
	if(row)row.editable = 'readonly';
	//console.log(row);
	//if(status == 0)(c[0]).push('editable','readonly');
	//console.log(c);
    rowCount++;
    if (rowCount == 1) {
        if ($("#poswarehouse").val() && $("#poscustomer").val()) {
            /*$("#poscustomer , #poswarehouse").select2("readonly", true);*/
        } else {
            bootbox.alert(lang.select_above);
            c = null;
            return false;
        }
    }
    if (c == null) {
        return false;
    }
    var b = "";
    if (rowCount) {
        b = isAddedProduct(c.product_id)
    }
    if (!b) {
        $("#count").val(++count);
        if (typeof c[0] !== "undefined") {
            loadItemsDef(c)
        } else {
            loadItems(c)
        }
        /*var a = count;

        positems[a] = c;

        rowCount++;

        positems[a].order = rowCount;

        positems[a].product_price = parseInt(c.product_price);

        localStorage.setItem("positems", JSON.stringify(positems))*/
    }
}
/*if (typeof (Storage) === "undefined") {

	$(window).bind("beforeunload", function (b) {

		if (count > 1) {

			var a = "You will loss data!";

			return a

		}

	})

}*/
function loadItems(e) {
	$('#item_count-'+e.product_id).text(1).show();
	
    /*console.log('load items');*/
    var c = $("#count").val();
    var f;
    var a = $('<tr id="row_' + c + '" class="row_' + c + '" data-item-id="' + e.product_id + '"></tr>');
    f = '<td><input type="hidden" value="' + e.product_id + '" class="rid" name="product_id[]" id="product_id_' + e.product_id + '" row_id="' + c + '"><input type="hidden" value="' + e.product_code + '" class="rcode" name="product_code[]"><input type="hidden" value="' + e.product_name + '" class="rname" name="product_name[]">' + e.label + "</td>";
    f += '<td class="text-right"><input class="form-control input-sm text-center rquantity rprice" style="width:100%;cursor:pointer" type="text" type="text" value="' + e.product_price + '" id="sprice_' + c + '" name="net_price[]" ondblclick="enable_(this)" onclick="this.select" onblur="disable_(this)" readonly></td>"';
    f += '<td><input type="number" role="textbox" tabIndex="' + c + '" aria-haspopup="true" class="form-control input-sm text-center rquantity " name="quantity[]" value="1" data-item="' + e.product_id + '" id="quantity_' + c + '" onclick="this.select"></td>';
    f += ' <td class="text-right"><input type="hidden" value="' + e.product_price + '" id="ssubtotal_' + c + '" name="ssubtotal[]"><span class="text-right ssubtotal" id="subtotal_' + c + '">' + formatMoney(e.product_price) + "</span></td>";
    f += '<td style="background-color:orange" class="text-center posdel" onClick="delRow(' + c + ')" ><i class="fa fa-times tip pointer " id="1451881153671" title="Remove" style="cursor:pointer;"></i></td>';
    a.html(f);
    a.prependTo("#posTable");
    create_bill(c, e.product_name, e.product_price);
    grand_total_cal();
    //$("#quantity_" + c).focus().select();
    /*var d = JSON.parse(localStorage.getItem("positems"))*/
}

function loadItemsDef(e) { /*console.log('load items - def');*/
console.log(e[0].editable);
    var b = $("#count").val();
    var c = b;
    var f;
    var a = $('<tr id="row_' + c + '" class="row_' + c + '" data-item-id="' + e[0].product_id + '"></tr>');
    f = '<td><input type="hidden" value="' + e[0].product_id + '" class="rid" name="product_id[]" id="product_id_' + e[0].product_id + '" row_id="' + c + '"><input type="hidden" value="' + e[0].product_code + '" class="rcode" name="product_code[]"><input type="hidden" value="' + e[0].product_name + '" class="rname" name="product_name[]">' + e[0].label + "</td>";
    f += '<td class="text-right"><input class="form-control input-sm text-center rquantity rprice" ' + e[0].editable + ' style="width:100%" type="text" type="text" value="' + e[0].product_price + '" id="sprice_' + c + '" name="net_price[]" ondblclick="enable_(this)" onclick="this.select" onblur="disable_(this)" readonly></td>"';
    f += '<td><input type="number" role="textbox" tabIndex="' + c + '" aria-haspopup="true" class="form-control input-sm text-center rquantity " ' + e[0].editable + ' name="quantity[]" value="' + parseInt(e[0].qty) + '" data-id="1451881153671" data-item="' + e[0].product_id + '" id="quantity_' + c + '" onclick="this.select;"></td>';
    f += '<td class="text-right"><input type="hidden" value="' + e[0].product_price + '" id="ssubtotal_' + c + '" name="ssubtotal[]"><span class="text-right ssubtotal" id="subtotal_' + c + '">' + formatMoney(parseInt(e[0].qty) * e[0].product_price) + "</span></td>";
    f += '<td style="background-color:orange" class="text-center posdel" onClick="delRow(' + c + ')"><i class="fa fa-times tip pointer " id="1451881153671" title="Remove" style="cursor:pointer;"></i></td>';
    a.html(f);
    a.prependTo("#posTable");
    create_bill(c, e[0].product_name, e[0].product_price);
    grand_total_cal();
    /*$("#id-name").val("quantity_" + c);*/
    $("#quantity_" + c).focus().select();
    /*var d = JSON.parse(localStorage.getItem("positems"))*/
}

function create_bill(c, product_name, product_price) {
    /*------------------

    	ADD TO BILL-TABLE

    		----------------*/
    a = $('<tr class="text-right bill_content	bill_tr_id' + c + '"></tr>');
    f = '<td class="text-center">*</td>';
    f += '<td style="text-align:left">' + product_name + '</td>';
    f += '<td class="text-center	bill_td_qty_' + c + '">1</td>';
    f += '<td class="text-right 	bill_td_price_' + c + '" id="">' + product_price + '</td>';
    f += '<td class="text-right		bill_td_amount_' + c + '">' + product_price + '</td>';
    a.html(f);
    a.prependTo("#bill_table");
	//a.prependTo("#bill_table_print");
    a = $('<tr class="text-right 	bill_tr_id' + c + '"></tr>');
    f = '<td class="text-center">*</td>';
    f += '<td style="text-align:left">' + product_name + '</td>';
    f += '<td class="text-center	bill_td_qty_' + c + '">1</td>';
    a.html(f);
    a.prependTo("#kot_table");
	a.prependTo("#kot_table_print");
    /*----------------

    		END 

    		--------------*/
}

function enable_(element) {
    $(element).attr('readonly', false);
}

function disable_(element) {
    $(element).attr('readonly', true);
}

function delRow(a) {
    $(".bill_tr_id" + a).remove();
	
	$('#item_count-'+a).text(0).hide();
		
    delete positems[a];
    localStorage.setItem("positems", JSON.stringify(positems))
}
var itemQty = 0;

function grand_total_cal(c) {
    /*console.log('calculating total...');*/
    var invoice_type = $("input:radio[name='delivery_status']:checked").val();
    var ssubtotal = 0;
    var posdiscount = 0;
    /*-- get data and set sub totals in #postable --*/
    for (c = 0; c <= count; c++) {
        /*console.log('c:'+c);*/
        var product_price = $('#sprice_' + c).val();
        if (product_price) {
            $('.bill_td_price_' + c).text(product_price);
            var p_qty = $('#quantity_' + c).val();
            $('.bill_td_qty_' + c).html(p_qty);
            product_price = remove_comma(product_price);
            var p_sub_total = product_price * p_qty;
            ssubtotal += p_sub_total;
            $('#subtotal_' + c).text(formatMoney(p_sub_total));
            $("#ssubtotal_" + c).val(parseFloat(p_sub_total));
            $('.bill_td_amount_' + c).text(formatMoney(p_sub_total));
        }
    }
    var tot_discount = $("span#tds").text();
    if (parseInt(tot_discount) > 0) {
        $('#td_order_discount').parent().removeClass('no-print');
        $('#td_order_discount').parent().css('display', '');
        $('#td_order_discount').text('(' + tot_discount + ')');
        if (tot_discount.indexOf("%") !== -1) {
            var e = tot_discount.split("%");
            if (!isNaN(e[0])) {
                posdiscount = formatDecimal((ssubtotal * parseFloat(e[0])) / 100)
            } else {
                posdiscount = formatDecimal(tot_discount)
            }
        } else {
            posdiscount = formatDecimal(tot_discount)
        }
    } else {
        $('#td_order_discount').parent().addClass('no-print');
        $('#td_order_discount').parent().css('display', 'none');
    }
    /*console.log('total:'+ssubtotal);*/
    $("span#total").text(formatMoney(ssubtotal));
    $(".td_sub_total").text(formatMoney(ssubtotal));
    var extra_charges_amount = 0; /*console.log('dine type:'+invoice_type);*/
    if (invoice_type == 1) {
        extra_charges_amount += formatDecimal((ssubtotal * pos_settings.extra_charges) / 100);
        $('#extra_charges').val(pos_settings.extra_charges + '%');
        $('#extra_charges_amount').val(extra_charges_amount);
        $('#sc_sp').html('(S.C ' + pos_settings.extra_charges + '% included)');
        $('#sc_sp').css('visibility', 'visible');
        $('#td_service_charges').parent().removeClass('no-print');
        $('#td_service_charges').text(formatMoney(extra_charges_amount));
        $('#td_service_charges').parent().css('display', '');
    } else {
        $('#extra_charges').val('');
        $('#extra_charges_amount').val();
        $('#sc_sp').css('visibility', 'hidden');
        $('#td_service_charges').parent().addClass('no-print');
        $('#td_service_charges').parent().css('display', 'none');
    }
    itemQty = $("#posTable >tbody > tr").length;
    if (itemQty < 1) $('#sc_sp').css('visibility', 'hidden');
    ssubtotal += extra_charges_amount;
    /*console.log('item qty:'+itemQty);

    console.log('amount_val_1:'+(ssubtotal - posdiscount));

    console.log('posdiscount:'+(posdiscount));*/
    $("input#amount_val_1").val(ssubtotal - posdiscount);
    $("input#posdiscount").val(posdiscount);
    /*    if (c == 0) {

            $("span#titems").text(c)

        } else {*/
    $("span#titems").text(itemQty)
    /*    }*/
    var posshipping = $("#posshipping").val();
    /*console.log('tship:'+(posshipping));*/
    if (invoice_type == 3) {
        if (!posshipping) posshipping = 0;
        $("span#tship").text(formatMoney(posshipping));
        $('#td_delivery_charges').parent().removeClass('no-print');
        $('#td_delivery_charges').text(formatMoney(posshipping));
        $('#td_delivery_charges').parent().css('display', '');
    } else {
        $("#posshipping").val('0');
        $("#shipping_address").val('');
        posshipping = 0;
        $('#td_delivery_charges').parent().addClass('no-print');
        $('#td_delivery_charges').parent().css('display', 'none');
    }
    $("span#gtotal").text(formatMoney(ssubtotal - posdiscount + parseInt(posshipping))); /*console.log('gtotal:'+(formatMoney(ssubtotal - posdiscount + parseInt(posshipping))));*/
    $(".id_total_amount").text(formatMoney(ssubtotal - posdiscount + parseInt(posshipping)));
    localStorage.setItem("gtotal", formatMoney(ssubtotal - posdiscount + parseInt(posshipping)));
    $("#grand_total").val(ssubtotal - posdiscount + parseInt(posshipping));
}
$("#ppdiscount").click(function(a) {
    a.preventDefault();
    $("#dsModal").modal()
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
                    $("#tds").text(formatMoney(a));
                    $("#posdiscount").val(a);
                    localStorage.removeItem("posdiscount");
                    localStorage.setItem("posdiscount", a);
                    $("#pos_discount_input1").val(a)
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
        $("#tds").text(a);
        $("#posdiscount").val(a);
        localStorage.removeItem("posdiscount");
        localStorage.setItem("posdiscount", a);
        $("#pos_discount_input1").val(a)
    } else {
        bootbox.alert(lang.unexpected_value)
    }
    $("#dsModal").modal("hide");
    grand_total_cal()
});
$("#payment").click(function(b) {
    if ($("#posTable >tbody > tr").length > 0) {
		
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
                        } else $("#pshipping").click();
                    }
                });
            } else {
                load_payment_grid()
            }
        } else {
			if (a == 1){
				var table_id = $('#table_id').val();
				if(table_id == ''){
				bootbox.alert('Please select table number !');
				
				}else load_payment_grid();
			} else load_payment_grid();
			
            
        }
    } else {
        displayNotice("", "Please add product before payment. Thank you !! ");
        $("#add_item").focus()
    }
});

function load_payment_grid() {
    $("span#twt").text($("span#gtotal").text());
    $("span#item_count").text($("span#titems").text());
    $("#paymentModal").modal();
}
$("#paymentModal").on("shown.bs.modal", function() {
    $('#paid_by_1').val('cash').trigger('change');
    $("input.amount").focus().select();
}).on("hidden.bs.modal", function(e) {
    /*console.log(e);*/
    $('#add_item').focus();
});
$(document).on("change", ".paid_by", function() {
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
}).on("click", ".quick-cash", function() {
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
}).on("click", "#clear-cash-notes", function() {
    $(".quick-cash").find(".badge").remove();
    $("#" + pi).val("0").focus()
}).on("focus", ".amount", function() {
    pi = $(this).attr("id");
    calculateTotals()
}).on("blur", ".amount", function() {
    calculateTotals()
}).on("keyup", ".amount", function() {
    calculateTotals()
});

function calculateTotals() {
    console.log('calculateTotals....');
    var c = 0;
    var b = remove_comma($("span#twt").text());
    var a = $(".amount");
    $.each(a, function(e) {
        var d = remove_comma($(this).val());
        c += parseFloat(d ? d : 0)
    });
    $("#total_paying").text(formatMoney(c));
    $("#td_paying_amount").text(formatMoney(c)).parent().css('display', '');
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
        url: base_url + "pos/get_customers",
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

    window.open(base_url + "sales/sale_details?sale_id=" + a, "sharer", "toolbar=0,status=0,width=384,height=700, left=10, top=10,scrollbars=yes");

    return false

}

*/
$(window).keydown(function(a) {
    if (a.altKey) {
        if (a.key == 1) {
            $("#cb_1").iCheck("check");
            grand_total_cal();
            $("#add_item").focus();
        } else {
            if (a.key == 2) {
                $("#cb_2").iCheck("check");
                grand_total_cal();
                $("#add_item").focus();
            } else {
                if (a.key == 3) {
                    $("#cb_3").iCheck("check");
                    grand_total_cal();
                    $("#add_item").focus();
                } else {
                    if (a.key == 4) {
                        $("#add_item").focus();
                    } else if (a.key == 5) printElem("drawer");
                }
            }
        }
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
    if (e.target.id == 'delivery-panel-refresh') loadDelivery();
    else if (e.target.id == 'takeaway-panel-refresh') loadTakeaway();
    else if (e.target.id == 'dine_in-panel-refresh') loadDineIn();
});
$('input.ds').on('ifChecked', function(event) {
    /*console.log(event);*/
    if (event.target.value == 1) {
        $('#content').css('background-color', '#428bca');
        $('.hide_me').css('visibility', 'hidden');
        grand_total_cal();
    }
    if (event.target.value == 2) {
        $('#content').css('background-color', 'black');
        $('.hide_me').css('visibility', 'hidden');
        grand_total_cal();
    }
    if (event.target.value == 3) {
        $('#content').css('background-color', '#eea236');
        $('.hide_me').css('visibility', 'visible');
        grand_total_cal();
    }
});
$('input.ds').on('ifUnchecked', function(event) {
    $('#delivary_status').val(0);
    $('#content').css('background-color', '#FFF');
    /*var cur_status = $('#delivary_status').val();

    alert(cur_status );*/
});
$('#div_1 , #div_1_2').on('click', function() {
    $('#cb_1').iCheck("check");
    grand_total_cal();
});
$('#div_2 , #div_2_2').on('click', function() {
    $('#cb_2').iCheck("check");
    grand_total_cal();
});
$('#div_3 , #div_3_2').on('click', function() {
    $('#cb_3').iCheck("check");
    grand_total_cal();
});
$('#poss_1 , #poss_1_2').on('click', function() {
    $('#divi_1').iCheck("check");
   // grand_total_cal();
});
$('#poss_2 , #poss_2_2').on('click', function() {
    $('#divi_2').iCheck("check");
   // grand_total_cal();
});
$("#view_bill").click(function(b) {
    b.preventDefault();
    $("#view_bill_modal").modal();
});

$('.cat').click(function(e){
	//cat_title_nme
	var cat_title_nme 	= $(this).attr('cat_title_nme');
	var cat_title_id 	= $(this).attr('cat_title_id');
	
	$('#cat_title_'+cat_title_id).text(cat_title_nme);
	});