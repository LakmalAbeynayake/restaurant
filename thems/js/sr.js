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

function addProductToListByID(product_id, product_name, product_code, product_price, product_part_no, product_oem_part_number, item_cost, qty_q, discount) {
    var customer_id = $('#customer_id').val(),
        $rowCount = $('#rowCount'),
        error = false,
        qty = qty_q > 0 ? qty_q : 1;

    if (customer_id === '') {
        error = true;
    }

    if (error) {
        bootbox.alert('Please select Customer before adding any product', function() {
            $('#add_item').focus();
        });
    } else {
        var rowCount = parseInt($rowCount.val()) + 1;
        $rowCount.val(rowCount);

        var product_price_dis = convertToAmount(product_price);
        var sub_total_item = convertToAmount(product_price * qty);
        var product_part_no_txt = product_part_no ? ', SAP Code.:' + product_part_no : '';

        var newRowHTML = `<tr class="child" id="row_${rowCount}">
            <td>${product_name} (${product_code})${product_part_no_txt}
                <input type="hidden" class="form-control text-center rquantity" name="row[${rowCount}][product_id][]" value="${product_id}" id="product_id_${rowCount}">
            </td>
            
            <td>
                <input type="text" class="form-control text-center rquantity" name="row[${rowCount}][qty][]" value="${qty}" id="quantity_${rowCount}" onclick="this.select(); setTmpVal(this.value);" onchange="changeQtyByProductID(this.value,${rowCount});">
            </td>
            <td>
                <a onclick="deleteSalesItem(${rowCount})" class="text-center"><i class="fa fa-times tip podel" title="Remove" style="cursor:pointer;"></i></a>
            </td>
        </tr>`;

        $('#soTable tbody').prepend(newRowHTML);
        calculateTotal();
    }
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
    //alert('test');
    //get row
    var rowCount = parseInt($('#rowCount').val());
    var quantity_tot = 0;
    var product_price_tot = 0;
    var subtotal = 0;
    var subtotal_item = 0;
    var balance = 0;
    var paid = 0;
    var cost_total = 0;
    for (i = 1; i <= rowCount; i++) {
        var quantity_fld = '';
        var cost_fld = '';
        quantity_fld = '#quantity_' + i;
        var item_cost_fld = '#item_cost_' + i;
        subtotal_fld = '#subtotal_' + i;
        discount_fld = '#discount_' + i;
        discount_val_fld = '#discount_val_' + i;
        product_price_fld = '#product_price_' + i;
        item_price_p_fld = '#item_price_p_' + i;
        gross_total_fld = '#gross_total_' + i;
        var quantity_val = parseFloat($(quantity_fld).val());
        var item_cost_val = parseFloat($(item_cost_fld).val());
        var discount_val = parseFloat($(discount_fld).val());
        var product_price_val = parseFloat($(product_price_fld).val());
        var item_price_p_val = parseFloat($(item_price_p_fld).val());
        //alert(product_price_p_val);
        product_price_val = product_price_val + item_price_p_val;
        var paid = parseFloat($('#paid').val());
        var sale_inv_discount = ($('#sale_inv_discount').val());
        //if(isNaN(quantity_val)) 
        {}
        //else
        {
            //alert(quantity_fld+':'+quantity_val);
            quantity_tot = quantity_tot + quantity_val;
            if (item_cost_val) {
                cost_total = cost_total + (item_cost_val * quantity_val);
            }
            //set item total
            var price = 0,
                afterDiscount = 0;
            price = product_price_val * quantity_val;
            // alert(product_price_val);
            // discount = Number(discount);
            //afterDiscount=price - ( price*discount_val/100 );
            //set discount_val
            //$(discount_val_fld).val((price*discount_val/100));
            /* calculate discount*/
            //alert(product_price_val+' '+quantity_val);
            //alert(afterDiscount);
            //text box exist check, for when delete item
            if ($(discount_fld).length) {
                ds = $(discount_fld).val();
            } else {
                ds = '';
            }
            //set temp val
            //$('#tmpVal').val(ds);
            var error = false;
            tmpDisVal = 0;
            if (ds.indexOf("%") !== -1) {
                var pds = ds.split("%");
                //alert(1);
                if (!isNaN(pds[0])) {
                    afterDiscount = price - (price * pds[0] / 100);
                    tmpDisVal = price * pds[0] / 100;
                } else {
                    error = true;
                }
            } else {
                if (!isNaN(ds)) {
                    afterDiscount = price - ds;
                    tmpDisVal = ds;
                    //alert('ds:'+ds);
                } else {
                    error = true;
                }
            }
            if (error) {
                $(discount_fld).val($('#tmpVal').val());
                bootbox.alert('Error! Invalid Discount', function() {});
                //set old value
                ds = $('#tmpVal').val();
                if (ds.indexOf("%") !== -1) {
                    var pds = ds.split("%");
                    if (!isNaN(pds[0])) {
                        afterDiscount = price - (price * pds[0] / 100);
                        tmpDisVal = price * pds[0] / 100;
                    } else {
                        error = true;
                    }
                } else {
                    if (!isNaN(ds)) {
                        afterDiscount = price - ds;
                        tmpDisVal = ds;
                    } else {
                        error = true;
                    }
                }
            }
            //alert(afterDiscount);
            //Set discount fld value
            $(discount_val_fld).val(tmpDisVal);
            $('#cost_total').val((cost_total));
            //alert(afterDiscount);
            $(gross_total_fld).val((afterDiscount));
            $(subtotal_fld).text(convertToAmount(afterDiscount));
            //alert(afterDiscount);
            /* end calculate discount*/
        }
        var product_price_fld = '';
        product_price_fld = '#product_price_' + i;
        var product_price_val = parseFloat($(product_price_fld).val());
        if (isNaN(product_price_val)) {} else {
            subtotal = subtotal + (afterDiscount);
        }
    }
    //discount calculation
    var inv_discount = 0;
    //if(isNaN(sale_inv_discount)) 
    {}
    //else
    {
        //var tds=sale_inv_discount;
        //inv_discount=sale_inv_discount;
        //subtotal=subtotal-inv_discount;
        var item_discount = 0,
            discount = sale_inv_discount;
        //alert(discount);
        ds = discount ? discount : '0';
        //var str = "Hello world, % to the universe.";
        var n = ds.indexOf("%");
        //alert(n);
        //if (ds.indexOf("%") !== -1) 
        {}
        //alert(ds);	
        if (ds.indexOf("%") !== -1) {
            var pds = ds.split("%");
            //alert(pds[0]);
            if (!isNaN(pds[0])) {
                //alert(pds[0]);
                if (pds[0] == '') {
                    alert('invalid discount');
                    $('#sale_inv_discount').val();
                } else if (pds[0] == '%') {
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
            if (isNaN(ds)) {
                alert('invalid discount');
                $('#sale_inv_discount').val();
            } else {
                inv_discount = ds;
            }
            // inv_discount = parseFloat(ds);
        }
        //alert(item_discount);
    }
    var gross_total = subtotal; //set grand total
    subtotal = subtotal - inv_discount;
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
    //set cursser to update qty
    var tmp = $("#rowCount").val();
    var tmpFld = "#quantity_" + tmp;
    $(tmpFld).focus();
    $(tmpFld).select();
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