jQuery(document).ready(function() {
    FormValidator.init();
    //hide error box
    $('.alert-danger').hide();
});
jQuery(document).ready(function() {
    //conirm
    $("#conirm").click(function() {
        var sel_id = $('#sel_id').val();
        var popup_type = $('#popup_type').val();
        var page = $('#page').val();
        var row_id = sel_id;
        if (page == 'sale_add') {
            if (popup_type == 'delete') {
                var tmp = '#row_' + row_id;
                $(tmp).remove();
                displayNotice('page', 'Product item has been deleted successfully!');
                calculateTotal();
            }
        } //end page check
    });
});
function deleteSalesItem(row_id) {
    //alert(row_id);
    $("#myModal4").modal();
    $('#sel_id').val(row_id);
    $('#popup_type').val('delete');
    $('#page').val('sale_add');
    $("#label").text("Are you sure you want to delete this product item?");
}
function clearForm() {
    $('#qtyTotal').text(convertToAmount(0));
    //('#sale_datetime').text('');
    $('#sale_datetime').css("borderColor", "#d5d5d5");
    $('#warehouse_id').css("borderColor", "#d5d5d5");
    $('#customer_id').css("borderColor", "#d5d5d5");
    //$('#tax_rate_id').css("borderColor","#d5d5d5");
    //$('#warehouse_id').val("");
    //$('#customer_id').val("");
    $('#balance_dis').text(convertToAmount(0));
    $('#Subtotal').text(convertToAmount(0));
    //set ref no
    getNextRefNo();
}

function changeDiscountByProductID(discount, nxtCount, product_id) {
    calculateTotal();
}
function changePaidValue(paid) {
    if (isNaN(paid)) {
        displayNotice('page', 'Invalid Paid Amount');
        //alert(quantity_fld);
        var oldVal = $('#tmpVal').val();
        $('#paid').val(oldVal); //set last val
    } else {
        calculateTotal();
        $('#paid').val(convertToAmount(paid));
    }
}
function setTmpVal(val) {
    $('#tmpVal').val(val);
}
function convertToAmount(val) {
    var disval = val; //+'.00'; //.toFixed(val);
    return accounting.formatMoney(disval, "", 2, ",", "."); // €4.999,99 
}
function changeMainDiscount(val) {
    //alert(val);
    calculateTotal();
}
/* check is added produtct */
function isAddedProduct(pid) {
    //alert(pid);
    var rowCount = parseInt($('#rowCount').val());
    for (i = 1; i <= rowCount; i++) {
        var product_fld = '#product_id_' + i;
        //alert(product_fld);
        var product_id = parseInt($(product_fld).val());
        if (product_id == pid) {
            //change qty
            var quantity_fld = '#quantity_' + i;
            var quantity_val = parseFloat($(quantity_fld).val());
            $(quantity_fld).val(quantity_val + 1)
            //alert('updated qty');
            return 1;
        } else {
            //alert('no');	
            //return 0;
        }
    }
}
/* end check is added produtct */
function calculateTotal() {
    var rowCount = $('#soTable > tbody > tr').length;
    var quantity_tot = 0;
    var cost_total = 0;
    var subtotal = 0;
    var inv_discount = 0;

    for (var i = 1; i <= rowCount; i++) {
        var quantity_fld = '#quantity_' + i;
        var quantity_val = parseFloat($(quantity_fld).val());

        if (isNaN(quantity_val)) continue;

        quantity_tot += quantity_val;

        var item_cost_val = parseFloat($('#item_cost_' + i).val());
        if (item_cost_val) {
            cost_total += item_cost_val * quantity_val;
        }

        var product_price_val = parseFloat($('#product_price_' + i).val());
        var item_price_p_val = parseFloat($('#item_price_p_' + i).val());
        product_price_val += item_price_p_val;
        /**/
        var discount_val = $('#discount_' + i).val(); // parseFloat();
        var discount = 0;
    
        if(discount_val !== ""){
            if (discount_val.indexOf("%") !== -1) { 
                var e = discount_val.split("%");
                if (!isNaN(e[0])) {
                    discount = formatDecimal((product_price_val * parseFloat(e[0])) / 100);
                } else {
                    discount = formatDecimal(discount_val)
                }
            } else {
                discount = formatDecimal(discount_val)
            }
        }
        /**/

        var price = (product_price_val - discount) * quantity_val;
        
        
        var afterDiscount = price;
        
        subtotal += afterDiscount;
        
        $('#discount_val_' + i).val(discount);
        $('#gross_total_' + i).val(afterDiscount);
        $('#cost_total').val(cost_total);
        $('#subtotal_'+i).text(convertToAmount(afterDiscount));
    }
    $('#Subtotal').text(convertToAmount(subtotal));

    var sale_inv_discount = $('#sale_inv_discount').val();
    var discount = sale_inv_discount ? sale_inv_discount : '0';

    if (discount.indexOf("%") !== -1) {
        var pds = discount.split("%");
        if (!isNaN(pds[0])) {
            inv_discount = parseFloat(((subtotal) * parseFloat(pds[0])) / 100);
        }
    } else {
        if (!isNaN(discount)) {
            inv_discount = parseFloat(discount);
        }
    }

    var gross_total = subtotal - inv_discount;

    // Update UI elements
    $('#qtyTotal').text(convertToAmount(quantity_tot));
    $('#sale_total').val(gross_total);
    $('#qts_total').val(gross_total);
    $('#sale_inv_discount_amount').val(inv_discount);
    $('#titems').text(quantity_tot);
    $('#gtotal').text(convertToAmount(gross_total));
    $('#tds').text(convertToAmount(inv_discount));
    $('#f_total').text(convertToAmount(gross_total));
    
    
    var tmp = $("#rowCount").val();
    var tmpFld = "#quantity_" + tmp;
    $(tmpFld).focus().select();
}

for (var key in localStorage) {
    //console.log(key + ':' + localStorage[key]);
}
$('#comment').keypress(function(event) {
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