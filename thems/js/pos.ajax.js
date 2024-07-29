var positems = {};
var site = {
		base_url: "http://localhost/inventry_pos/",
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
			display_all_products: "0"
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
		pin_code: null
	};
var lang = {
	unexpected_value: "Unexpected value provided!",
	select_above: "Please select above first",
	r_u_sure: "Are you sure?"
};
var count = $("#count").val();
var rowCount = $("#posTable > tbody > tr").length;
setInterval(function () {
	$(".alert").hide("blind", {}, 500)
}, 15000);
setInterval(function () {
	if (typeof moment !== "undefined") {
		var a = new moment();
		$("#display_time").text(a.format((site.dateFormats.js_sdate).toUpperCase() + " HH:mm"));
		$("#sale_datetime").val(a.format(("Y-MM-D HH:mm:ss")))
	}
}, 1000);
$(document).ready(function () {
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
	$("#modal-loading").hide();
	$(window).resize();
	$(".pos-tip").tooltip();
	$("#poswarehouse").select2({
		allowClear: true,
		minimumResultsForSearch: Infinity
	});
	$("#poscustomer").select2({
		allowClear: true
	});
	$("#poswarehouse").change(function (a) {
		localStorage.setItem("poswarehouse", $(this).val())
	});
	$("#poscustomer").change(function (a) {
		localStorage.setItem("poscustomer", $(this).val())
	});
	$("#clearLS").click(function () {
		localStorage.clear();
		localStorage.setItem("clear", 1)
	})
});
$(document).ready(function () {
	localStorage.clear();
	localStorage.setItem("reload", 1);
	$("#add_item").focus();
	$("#product-list").css("min-height", 90);
	widthFunctions();
});	
	$("#add_item").autocomplete({
		source: jsonarray,
		minLength: 1,
		autoFocus: false,
		delay: 200,
		response: function (b, c) {
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
		select: function (b, c) {
			b.preventDefault();
			if (c.item.id !== 0) {
				var d = add_invoice_item(c.item);
				if (d) {
					$(this).val("")
				}
				$("#add_item").val("").removeClass("ui-autocomplete-loading")
			} else {
				bootbox.alert("No matching result found! Product might be out of stock in the selected warehouse.")
			}
		}
	});
	
	$(document).bind("keyup", function (d) {
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
	});
	$("#add_item").bind("keypress", function (b) {
		if (b.keyCode == 13) {
			b.preventDefault();
			$("#payment").click();
			$(this).autocomplete("search")
		}
	});
	$("#posTable").bind("keypress", function (b) {
		b.shiftKey == false;
		if (b.which < 46 || b.which > 57) {
			b.preventDefault()
		} else {
			if (b.which < 93 || b.which > 105) {} else {}
		}
	});
	var a;
	$(document).on("focus", ".rquantity", function () {
		a = $(this).val()
	}).on("change", ".rquantity", function () {
		var b = $(this).closest("tr");
		if (!is_numeric($(this).val()) || parseFloat($(this).val()) < 0) {
			$(this).val(a);
			bootbox.alert(lang.unexpected_value);
			return
		}
	}).on("keypress", ".rquantity", function (b) {
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
	}).on("keyup", ".rquantity", function () {
		if (!is_numeric($(this).val()) || $(this).val() == 0) {
			bootbox.alert(lang.unexpected_value);
			$(this).val(1);
			return false;
		}
		/*var b = $(this).val();
		var c = $(this).attr("data-item");
		var d = remove_comma($("#sprice_" + c).text());
		$("#subtotal_" + c).text(formatMoney(parseFloat(d) * parseFloat(b)));
		$("#ssubtotal_" + c + "").val(parseFloat(d) * parseFloat(b));*/
		/*var e = {};
		e.new_qty = parseFloat(b);
		e.item_id = parseInt(c);
		e.product_price = d;*/
		grand_total_cal()
	});

function isAddedProduct(pc) {
		var a = $("#product_id_" + pc).val();
		if (a) {
			var d = $("#product_id_" + pc).attr('row_id');
			var c = "#quantity_" + d;
			var h = parseFloat($(c).val());
			$(c).val(h + 1);grand_total_cal();
			document.getElementById("quantity_" + d).focus();
			document.getElementById("quantity_" + d).select();
			return 1
		}
}
$(window).bind("resize", widthFunctions);

function widthFunctions(d) {
	var b = $(window).height(),
		c = $("#left-top").height(),
		a = $("#left-bottom").height();
	$("#item-list").css("height", b - 107);
	$("#item-list").css("min-height", 515);
	$("#left-middle").css("height", b - c - a - 102);
	$("#left-middle").css("min-height", 278);
	$("#product-list").css("height", b - c - a - 107);
	$("#product-list").css("min-height", 278);
	$(".select2-container").css("width", "100%")
}
var product_variant = 0,
	shipping = 0,
	p_page = 0,
	per_page = 0,
	tcp = "8",
	cat_id = "8",
	ocat_id = "1",
	sub_cat_id = 0,
	osub_cat_id, 
	
	DT = 1;
$(document).on("click", ".category", function () {
	var a = $("#base_url").val();
	if (cat_id != $(this).val()) {
		$("#modal-loading").show("fast");
		$("#open-category").click();
		cat_id = $(this).val();
		$.ajax({
			type: "get",
			url: a + "pos/ajaxcategorydata",
			data: {
				category_id: cat_id
			},
			dataType: "json",
			success: function (c) {
				$("#item-list").empty();
				var d = $('<div id="makeMeScrollable"></div>');
				d.html(c.products);
				d.appendTo("#item-list");
				$("#subcategory-list").empty();
				var b = $("<div></div>");
				b.html(c.subcategories);
				b.appendTo("#subcategory-list");
				tcp = c.tcp;
				//scrollMe()
			}
		}).done(function () {
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
});

var base_url = $("#base_url").val();
$(document).on("click", ".subcategory", function () {
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
			success: function (a) {
				$("#item-list").empty();
				var b = $('<div id="makeMeScrollable"></div>');
				b.html(a);
				b.appendTo("#item-list");
				//scrollMe()
			}
		}).done(function () {
			p_page = "n";
			$("#subcategory-" + sub_cat_id).addClass("active");
			$("#subcategory-" + osub_cat_id).removeClass("active");
			osub_cat_id = sub_cat_id;
			$("#modal-loading").hide();
			$(".pos-tip").tooltip()
		})
	}
});
$(document).on("click", ".product", function (a) {
	$("#modal-loading").show();
	code = $(this).val(), wh = $("#poswarehouse").val(), cu = $("#poscustomer").val();
	$.ajax({
		type: "get",
		url: base_url + "pos/getProductDataByCode",
		data: {
			code: code,
			warehouse_id: wh,
			customer_id: cu
		},
		dataType: "json",
		success: function (b) {
			a.preventDefault();
			if (b !== null) {
				add_invoice_item(b[0]);
				$("#modal-loading").hide()
			} else {
				bootbox.alert("No matching result found! Product might be out of stock in the selected warehouse.");
				$("#modal-loading").hide()
			}
		}
	})
});
$(document).on("click", ".posdel", function (b) {
	var c = $(this).closest("tr");
	c.remove();
	grand_total_cal()
});
$(document).on("click", "#submit-sale", function () {
	$("#submit-sale").attr("disabled", true);
	$('#paymentModal').modal('hide');
	form_submit();
});

/*function stopRKey(a) {
	var a = (a) ? a : ((event) ? event : null);
	var b = (a.target) ? a.target : ((a.srcElement) ? a.srcElement : null);
	if ((a.keyCode == 13) && (b.type == "text")) {
		return false
	}
}
document.onkeypress = stopRKey;*/
$(document).ready(function () {
	$("#category").select2();
	$(".auto").autoNumeric("init");
	$(".open-category").click(function () {
		$("#category-slider").toggle("slide", {
			direction: "right"
		}, 300)
	});
	$(".open-subcategory").click(function () {
		$("#subcategory-slider").toggle("slide", {
			direction: "right"
		}, 300)
	});
	$(".open-keyboard").click(function () {
		$("#keyboard-slider").toggle("slide", {
			direction: "right"
		}, 300)
	});
	$("input[type=text] select").focus(function () {
		if (this.id != "") {
			$("#id-name").val(this.id)
		}
	});
	$(document).on("click", function (b) {
		if (!$(b.target).is(".open-category, .cat-child") && !$(b.target).parents("#category-slider").size() && $("#category-slider").is(":visible")) {
			$("#category-slider").toggle("slide", {
				direction: "right"
			}, 200)
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
	})
});
if (site.settings.auto_detect_barcode == 1) {
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
}

function add_invoice_item(c) {
	rowCount++;
	if (rowCount == 1) {
		if ($("#poswarehouse").val() && $("#poscustomer").val()) {
			$("#poscustomer").select2("readonly", true);
			$("#poswarehouse").select2("readonly", true)
		} else {
			bootbox.alert(lang.select_above);
			c = null;
			return
		}
	}
	if (c == null) {
		return
	}
	var b = "";
	if (rowCount) {
		b = isAddedProduct(c.product_id)
	}
	if (!b) {
		count++;
		$("#count").val(count);
//		alert('value_added:'+count);
		if (typeof c[0] !== "undefined") {
			loadItemsDef(c)
		} else {
			loadItems(c)
		}
		var a = count;
		positems[a] = c;
		rowCount++;
		positems[a].order = rowCount;
		positems[a].p_price = parseInt(c.product_price);
		localStorage.setItem("positems", JSON.stringify(positems))
	}
}

if (typeof (Storage) === "undefined") {
	$(window).bind("beforeunload", function (b) {
		if (count > 1) {
			var a = "You will loss data!";
			return a
		}
	})
}

function loadItems(e) {
	var b = $("#count").val();
	var c = b;
	var f;
	var a = $('<tr id="row_' + c + '" class="row_' + c + '" data-item-id="' + e.product_id + '"></tr>');
	f = '<td><input type="hidden" value="' + e.product_id + '" class="rid" name="product_id[]" id="product_id_' + e.product_id + '" row_id="'+c+'"><input type="hidden" value="' + e.product_code + '" class="rcode" name="product_code[]"><input type="hidden" value="' + e.product_name + '" class="rname" name="product_name[]">' + e.label + "</td>";
	f += '<td class="text-right"><input type="hidden" value="' + e.product_price + '" id="net_price_' + e.product_id + '" name="net_price[]" class="rprice"><span class="text-right sprice" id="sprice_' + c + '">' + formatMoney(e.product_price) + "</span></td>";
	f += '<td><input type="text" role="textbox" tabIndex="' + c + '" aria-haspopup="true" class="form-control text-center rquantity " name="quantity[]" value="1" data-id="1451881153671" data-item="' + e.product_id + '" id="quantity_' + c + '" onclick="this.select();"></td>';
	f += ' <td class="text-right"><input type="hidden" value="' + e.product_price + '" id="ssubtotal_' + c + '" name="ssubtotal[]"><span class="text-right ssubtotal" id="subtotal_' + c + '">' + formatMoney(e.product_price) + "</span></td>";
	f += '<td style="background-color:orange" class="text-center posdel" onClick="delRow(' + c + ')" ><i class="fa fa-times tip pointer " id="1451881153671" title="Remove" style="cursor:pointer;"></i></td>';
	a.html(f);
	a.prependTo("#posTable");
	grand_total_cal();
	/*$("#id-name").val("quantity_" + c);*/
	document.getElementById("quantity_" + c).focus();
	document.getElementById("quantity_" + c).select();
	//var d = JSON.parse(localStorage.getItem("positems"))
}

function loadItemsDef(e) {
	var b = $("#count").val();
	var c = b;
	var f;
	var a = $('<tr id="row_' + c + '" class="row_' + c + '" data-item-id="' + e[0].product_id + '"></tr>');
	f = '<td><input type="hidden" value="' + e[0].product_id + '" class="rid" name="product_id[]" id="product_id_' + e[0].product_id + '" row_id="'+c+'"><input type="hidden" value="' + e[0].product_code + '" class="rcode" name="product_code[]"><input type="hidden" value="' + e[0].product_name + '" class="rname" name="product_name[]">' + e[0].label + "</td>";
	f += '<td class="text-right"><input type="hidden" value="' + e[0].product_price + '" id="net_price_' + e[0].product_id + '" name="net_price[]" class="rprice"><span class="text-right sprice" id="sprice_' + c + '">' + formatMoney(e[0].product_price) + "</span></td>";
	f += '<td><input type="text" role="textbox" tabIndex="' + c + '" aria-haspopup="true" class="form-control text-center rquantity " name="quantity[]" value="' + parseInt(e[0].qty) + '" data-id="1451881153671" data-item="' + e[0].product_id + '" id="quantity_' + c + '" onclick="this.select();"></td>';
	f += ' <td class="text-right"><input type="hidden" value="' + e[0].product_price + '" id="ssubtotal_' + c + '" name="ssubtotal[]"><span class="text-right ssubtotal" id="subtotal_' + c + '">' + formatMoney(parseInt(e[0].qty) * e[0].product_price) + "</span></td>";
	f += '<td style="background-color:orange" class="text-center posdel" onClick="delRow(' + c + ')" ><i class="fa fa-times tip pointer " id="1451881153671" title="Remove" style="cursor:pointer;"></i></td>';
	a.html(f);
	a.prependTo("#posTable");
	grand_total_cal();
	$("#id-name").val("quantity_" + c);
	document.getElementById("quantity_" + c).focus();
	document.getElementById("quantity_" + c).select();
	var d = JSON.parse(localStorage.getItem("positems"))
}

function delRow(a) {
	delete positems[a];
	localStorage.setItem("positems", JSON.stringify(positems))
}

var itemQty = 0;
function grand_total_cal(c) {
	/*console.log('calculating total...');*/
	var dt = $("input:radio[name='delivery_status']:checked").val();
	var ssubtotal = 0;
	var b = 0;
	var a = $("#posshipping").val();
	if(!a) a= 0;
	
	for(c=0;c<=count;c++){
		/*console.log('c:'+c);*/
		var p_price = $('#sprice_'+c).text();
		
			if(p_price){
				var p_qty	= $('#quantity_'+c).val();
				p_price = remove_comma(p_price);
				
				console.log('p_price:'+p_price);
				console.log('p_qty:'+p_qty);
				
				var p_sub_total = p_price * p_qty;
				ssubtotal += p_sub_total;
				$('#subtotal_'+c).text(formatMoney(p_sub_total));
				$("#ssubtotal_" + c).val(parseFloat(p_sub_total));
			}
		}
	
	itemQty = $("#posTable >tbody > tr").length;
	var d = $("span#tds").text();
	if (d.indexOf("%") !== -1) {
		var e = d.split("%");
		if (!isNaN(e[0])) {
			b = formatDecimal((ssubtotal * parseFloat(e[0])) / 100)
		} else {
			b = formatDecimal(d)
		}
	} else {
		b = formatDecimal(d)
	}
	console.log('total:'+ssubtotal);

	$("span#total").text(formatMoney(ssubtotal));
	var ech_am = 0; console.log('dine type:'+dt);
	if(dt == 1){
		ech_am += formatDecimal((ssubtotal * 10) / 100);
		$('#extra_charges').val('10%');
		$('#extra_charges_amount').val(ech_am);
		$('#sc_sp').css('visibility','visible');
	}else{
		$('#extra_charges').val('');
		$('#extra_charges_amount').val();
		$('#sc_sp').css('visibility','hidden');
		}
	if(itemQty < 1)$('#sc_sp').css('visibility','hidden');
		ssubtotal+=ech_am;
	/*console.log('item qty:'+itemQty);
	console.log('amount_val_1:'+(ssubtotal - b));
	console.log('posdiscount:'+(b));*/
	
	$("input#amount_val_1").val(ssubtotal - b);
	$("input#posdiscount").val(b);
	if (c == 0) {
		$("span#titems").text(c)
	} else {
		$("span#titems").text(itemQty)
	}
	
	$("span#tship").text(formatMoney(a));		console.log('tship:'+(a));
	$("span#gtotal").text(formatMoney(ssubtotal - b + parseInt(a)));console.log('gtotal:'+(formatMoney(ssubtotal - b + parseInt(a))));
	localStorage.setItem("gtotal", formatMoney(ssubtotal - b + parseInt(a)));
	$("#grand_total").val(ssubtotal - b + parseInt(a));
}

$("#ppdiscount").click(function (a) {
	a.preventDefault();
	$("#dsModal").modal()
});

/*Discount modal*/
$("#dsModal").on("shown.bs.modal", function () {
	$(this).find("#order_discount_input").select().focus();
	$("input#order_discount_input").bind("keypress", function (b) {
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
$(document).on("click", "#updateOrderDiscount", function () {
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

$("#payment").click(function (b) {
	if (itemQty > 0) {
		var a = $('.cb_list input[type="radio"]:checked:first').val();
		var c = $("#shipping_address").val();
		if (a == 3) {
			if (c == "") {
				$("#pshipping").click();
				displayNotice("", "Please confirm and update delivery details !!")
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
	$("span#twt").text($("span#gtotal").text());
	$("span#item_count").text($("span#titems").text());
	$("#paymentModal").modal();
}
$("#paymentModal").on("shown.bs.modal", function () {
	$('#paid_by_1').val('cash').trigger('change');
	$("input.amount").focus().select();
});
$(document).on("change", ".paid_by", function () {
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
});
var pi = "amount_1",
	pa = 2;
$(document).on("click", ".quick-cash", function () {
	var a = $(this);
	var e = a.contents().filter(function () {
		return this.nodeType == 3
	}).text();
	var c = ",";
	var d = $("#" + pi);
	e = formatDecimal(e.split(c).join("")) * 1 + d.val() * 1;
	d.val(formatDecimal(e)).focus();
	var b = a.find("span");
	if (b.length == 0) {
		a.append('<span class="badge">1</span>')
	} else {
		b.text(parseInt(b.text()) + 1)
	}
});
$(document).on("click", "#clear-cash-notes", function () {
	$(".quick-cash").find(".badge").remove();
	$("#" + pi).val("0").focus()
});
$(document).on("focus", ".amount", function () {
	pi = $(this).attr("id");
	calculateTotals()
}).on("blur", ".amount", function () {
	calculateTotals()
}).on("keyup", ".amount", function () {
	calculateTotals()
});

function calculateTotals() {
	var c = 0;
	var b = remove_comma($("span#twt").text());
	var a = $(".amount");
	$.each(a, function (e) {
		var d = remove_comma($(this).val());
		c += parseFloat(d ? d : 0)
	});
	$("#total_paying").text(formatMoney(c));
	$("#balance").text(formatMoney(c - b));
	$("#balance_" + pi).val(formatDecimal(c - b));
	total_paid = c;
	grand_total = b
}
$(document).on("click", "#reset", function () {
	bootbox.confirm("Are you sure?", function (a) {
		if (a == true) {
			$("#posTable tbody").empty();
			grand_total_cal(0);
			$("input#posdiscount").val(0);
			$("#tds").text(0);
			$("input#posshipping").val(0);
			$("#tship").text(0);
			localStorage.clear();
			form_locate()
		}
	});
	return false
});
$("#modal_ajax_customers_btn").click(function (b) {
	b.preventDefault();
	var a = $("#ajax-modal").modal();
	a.load(base_url + "customers/create_customers", "", function () {
		a.modal();
		setTimeout(function () {
			var c = $("#customer_mobile").val();
			$("#cus_phone").val(c);
			$("#nc").val(2);
			$("#cus_name").focus()
		}, 500)
	})
});
$("#pshipping").click(function (a) {
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
		success: function (c) {
			if (c !== null) {
				b = c[0].cus_address;
				$("#address_input").val(b);
				$("#sModal").modal();
				return b
			} else {
				bootbox.alert("No matching result found! Product might be out of stock in the selected warehouse.")
			}
		}
	})
}
$("#sModal").on("shown.bs.modal", function () {
	$(this).find("#shipping_input").select().focus()
});
$(document).on("click", "#updateShipping", function () {
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
$("#sModal").on("shown.bs.modal", function () {
	$(this).find("#shipping_input").select().focus();
	$("input#shipping_input").bind("keypress", function (b) {
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
$("#paymentModal").on("change", "#amount_1", function (a) {
	$("#pay_amount").val(remove_comma($(this).val()))
});
$("#paymentModal").on("blur", "#amount_1", function (a) {
	$("#pay_amount").val(remove_comma($(this).val()))
});
$("#paymentModal").on("change", "#payment_note_1", function (b) {
	$("#pos_note").val($(this).val());
	var a = $("#pos_note").val();
	localStorage.setItem("posnote", a)
});
$("#paymentModal").on("change", "#swipe_1", function (a) {
	$("#cc_name").val($(this).val())
});
$("#paymentModal").on("change", ".pcc_type", function (a) {
	$("#pcc_type").val($(this).val())
});
$("#paymentModal").on("change", "#pcc_holder_1", function (a) {
	$("#pcc_holder").val($(this).val())
});
$("#paymentModal").on("change", "#pcc_no_1", function (a) {
	$("#cc_no").val($(this).val())
});

function fbs_click(a) {
	u = location.href;
	t = document.title;
	window.open(base_url + "sales/sale_details?sale_id=" + a, "sharer", "toolbar=0,status=0,width=384,height=700, left=10, top=10,scrollbars=yes");
	return false
}

function getQty(c) {
	for (i = 1; i <= rowCount; i++) {
		var a = "#product_id_" + i;
		var d = parseInt($(a).val());
		if (d == c) {
			var b = "#quantity_" + i;
			var e = parseFloat($(b).val());
			return e
		} else {
			return 0
		}
	}
}

/*function scrollMe() {
	$("#makeMeScrollable").smoothDivScroll({
		hotSpotScrolling: false,
		touchScrolling: true,
		manualContinuousScrolling: false,
		mousewheelScrolling: false
	});
	$(".scrollableArea").css("max-width", 1700);
	$(".scrollWrapper").css("height", $("#product-list").height() + 150)
}*/
$(window).keydown(function (a) {
	if (a.altKey) {
		if (a.key == 1) {
			$("#cb_1").iCheck("check");grand_total_cal();$("#add_item").focus();
		} else {
			if (a.key == 2) {
				$("#cb_2").iCheck("check");grand_total_cal();$("#add_item").focus();
			} else {
				if (a.key == 3) {
					$("#cb_3").iCheck("check");grand_total_cal();$("#add_item").focus();
				} else {
					if (a.key == 4) {
						$("#add_item").focus();
					}else if (a.key == 5) printElem("drawer");
				}
			}
		}
	}
	$(":focus").each(function () {/*
		focus_id = this.id;
		var c = $("#rowCount").val();
		c++;
		var d = "quantity_" + c;
		if (a.keyCode == 118) {
			if (focus_id != d) {
				if (itemQty > 0) {
					grand_total_cal();
					$("span#twt").text($("span#gtotal").text());
					$("span#item_count").text($("span#titems").text());
					$("#paymentModal").modal()
				} else {
					var b = bootbox.alert("Please add product before payment. Thank you!");
					if (b) {
						$("#add_item").focus()
					}
				}
			} else {
				var b = $("#add_item").focus();
				if (b) {
					if (itemQty > 0) {
						grand_total_cal();
						$("span#twt").text($("span#gtotal").text());
						$("span#item_count").text($("span#titems").text());
						$("#paymentModal").modal()
					}
				}
			}
		}
	*/})
});
$(document).ajaxStart(function () {
	$("#modal-loading").show();
	$("#modal-loading").css("z-index", "99999")
});
$(document).ajaxStop(function () {
	$("#modal-loading").hide()
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
$(document).keypress(function (a) {
	if (a.altKey) {
		if (a.key == "5") {
			a.preventDefault();
			printElem("drawer")
		}
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


function remove_comma(a) {
	return parseFloat(a.replace(/,/g, ""))
}

/*function is_numeric(b) {
	var a = " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
	return (typeof b === "number" || (typeof b === "string" && a.indexOf(b.slice(-1)) === -1)) && b !== "" && !isNaN(b)
}*/

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