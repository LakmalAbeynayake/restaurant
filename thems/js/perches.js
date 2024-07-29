
if(localStorage.getItem('poitems')){loadItems();}
function loadItems() {
    if (localStorage.getItem('poitems')) {
        product_discount = 0;
        order_discount = 0;
        an = 0;
        count = 0;
        total = 0;

        poitems = JSON.parse(localStorage.getItem('poitems'));
        $("#poTable tbody").empty();
        $.each(poitems, function() {
            var item = this;
            var data_item_id = item.id;
            var product_id = item.row.product_id;
            var item_name = item.row.product_name;
            var product_code = item.row.product_code;
            var product_price = item.row.product_price;
            var product_cost  = item.row.product_cost;
            var item_qty = item.qty;

            var item_ds = item.row.item_discount,
                item_discount = 0;


            var row_no = Math.random();

            var ds = item_ds ? item_ds : '0';
            if (ds.indexOf("%") !== -1) {
                var pds = ds.split("%");
                if (!isNaN(pds[0])) {
                    item_discount = formatDecimal(parseFloat(((product_cost) * parseFloat(pds[0])) / 100));
                } else {
                    item_discount = formatDecimal(ds);
                }
            } else {
                item_discount = parseFloat(ds);
            }

            product_discount += parseFloat(item_discount * item_qty);
            unit_cost         = formatDecimal(product_cost - item_discount);
            product_cost     = formatDecimal(product_cost);
			//alert(product_cost);

            var newTr = $('<tr id="row_'+row_no+'" data-item-id="'+data_item_id+'"></tr>');
            tr_html = '<td><span id="name_'+row_no+'" class="sname">'+item_name+' ('+product_code+')</span><input type="hidden" value="'+product_code+'" class="rcode" name="product[]"><input type="hidden" value="'+product_id+'" name="product_id[]"><input type="hidden" value="'+item_name+'" class="rname" name="product_name[]"><i id="'+row_no+'" data-item="'+data_item_id+'" class="pull-right fa fa-edit tip pointer edit" title="Edit" style="cursor:pointer;"></i></td>';
            tr_html += '<td class="text-right"><input style="text-align:right;" text-align="right" data-item="' + data_item_id + '" id="cost_'+row_no+'" type="text" value="'+parseFloat(product_cost)+'" name="unit_cost[]" class="rucost"><span id="scost_'+row_no+'" class="text-right scost">'+'</span></td>';
            tr_html += '<td><input class="form-control text-center rquantity" name="quantity[]" type="text" value="' + item_qty + '" data-id="' + row_no + '" data-item="' + data_item_id + '" id="quantity_' + row_no + '" onClick="this.select();"></td>';
            tr_html += '<td class="text-right"><input type="hidden" name="discount_cal[]" value="'+item_discount * item_qty+'" /><input class="form-control input-sm rdiscount" name="product_discount[]" type="text" id="discount_' + row_no + '" value="' + item_ds + '" data-item="' + data_item_id + '" id="discount_' + row_no + '" onClick="this.select();"></td>';
            tr_html += '<td class="text-right"><input name="subtotal[]" type="hidden" value="'+parseFloat(unit_cost*item_qty)+'"/><span id="subtotal_'+row_no+'" class="text-right ssubtotal">'+accounting.formatMoney((parseFloat(unit_cost)) *(parseFloat(item_qty)),"")+'</span></td>';
            tr_html += '<td class="text-center"><i class="fa fa-times tip pointer sldel" id="row_delete_'+row_no+'" title="Remove" style="cursor:pointer;"></i></td>';
            newTr.html(tr_html);
            newTr.prependTo("#poTable");
            total += parseFloat(unit_cost) * parseFloat(item_qty);
        });
        var tfoot = '<tr id="tfoot" class="tfoot active"><th colspan="2">Total</th><th class="text-center"></th>';
            tfoot += '<th class="text-right"><input type="hidden" name="order_cal_des" value="'+product_discount+'"/>' + accounting.formatMoney(product_discount,"") + '</th>';
            tfoot += '<th class="text-right"><input type="hidden" value="'+total+'" name="gross_total"/>'+ accounting.formatMoney(total,"") + '</th><th class="text-center"><i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i></th></tr>';
        $('#poTable tfoot').html(tfoot);
       // calculate_total_cost();

      // alert( (total,""));

        if (podiscount = localStorage.getItem('podiscount')) {
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
        }


       //total_discount = parseFloat(order_discount);
       var gtotal = (total - order_discount);
        $('#total').text(accounting.formatMoney(total,""));
        $('input#total').val(total);
       $('#tds').text(accounting.formatMoney(order_discount,""));
       $('#gtotal').text(accounting.formatMoney(gtotal,""));
       $('input#hgtotal').val(gtotal);

    };

}

var old_row_qty;
$(document).on("focus", '.rquantity', function() {
    old_row_qty = $(this).val();
}).on("change", '.rquantity', function() {
    var row = $(this).closest('tr');
    if (!is_numeric($(this).val())) {
        $(this).val(old_row_qty);
        bootbox.alert("unexpected value !");
        return;
    }

     var new_qty = parseFloat($(this).val());
     var item_id = $(this).attr('data-item');
   // alert(item_id);
    var poitems = JSON.parse(localStorage.getItem('poitems'));
    if(typeof poitems[item_id] !== undefined)
        poitems[item_id].qty = new_qty
    localStorage.setItem('poitems', JSON.stringify(poitems));
    loadItems();

});

var old_rucost;
$(document).on("focus", '.rucost', function() {
    old_rucost = $(this).val();
}).on("change", '.rucost', function() {
    var row = $(this).closest('tr');
    if (!is_numeric($(this).val())) {
        $(this).val(old_rucost);
        bootbox.alert("unexpected value !");
        return;
    }

     var new_rucost = parseFloat($(this).val());
     var item_id = $(this).attr('data-item');
	 
    
    var poitems = JSON.parse(localStorage.getItem('poitems'));
    if(typeof poitems[item_id] !== undefined)
        poitems[item_id].row.product_cost = new_rucost
    localStorage.setItem('poitems', JSON.stringify(poitems));
    loadItems();

});

    var old_podiscount;
    $('#podiscount').focus(function() {
        old_podiscount = $(this).val();
    }).change(function() {
        if (is_valid_discount($(this).val())) {
            localStorage.removeItem('podiscount');
            localStorage.setItem('podiscount', $(this).val());
            loadItems();
            return;
            
        }else{

            $(this).val(old_podiscount);
            bootbox.alert("unexpected value!");
        }
    });

    var old_rdiscount;
    $(document).on("focus", '.rdiscount', function() {
        old_rdiscount = $(this).val();
    }).on("change", '.rdiscount', function() {

        if (!is_valid_discount($(this).val())) {
            $(this).val(old_rdiscount);
            bootbox.alert("unexpected value!");
        }

         var new_item_discount = $(this).val();
         var item_id = $(this).attr('data-item');
        
        // alert(new_item_discount);

           var poitems = JSON.parse(localStorage.getItem('poitems'));
           poitems[item_id].row.item_discount = new_item_discount;
           //console.log(poitems[item_id].row.item_discount);
           //alert(new_item_discount);
           localStorage.setItem('poitems', JSON.stringify(poitems));
           loadItems();

    });

    $(document).on('click', '.sldel', function() {
        var row = $(this).closest('tr');
        var item_id = row.attr('data-item-id');

            poitems = JSON.parse(localStorage.getItem('poitems'));
            delete poitems[item_id];
            localStorage.setItem('poitems', JSON.stringify(poitems));
            row.remove();
            loadItems();
    });


//common function
function is_numeric(mixed_var){var whitespace=" \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";return(typeof mixed_var==='number'||(typeof mixed_var==='string'&&whitespace.indexOf(mixed_var.slice(-1))===-
1))&&mixed_var!==''&&!isNaN(mixed_var);}

function formatDecimal(x){
    return parseFloat(parseFloat(x).toFixed(2));
}

function is_valid_discount(mixed_var){return(is_numeric(mixed_var)||(/([0-9]%)/i.test(mixed_var)))?true:false;}

//end common function

var add_purchase_item = function (item) {
    var oldItems = JSON.parse(localStorage.getItem('poitems')) || [];

     if (count == 1) {
        if ($('#supplier').val()) {
            $('#supplier').select2("readonly", true);
        } else {
            bootbox.alert("Please select above first.");
            item = null;
            return;
        }
    }

    if (item == null) {
        return;
    }

    var item_id = item.id;
    if (poitems[item_id]) {
        poitems[item_id].row.qty = parseFloat(poitems[item_id].row.qty) + 1;
    } else {
        poitems[item_id] = item;
    }
    localStorage.setItem('poitems', JSON.stringify(poitems));
    loadItems();
    return true;
};

if (typeof(Storage) === "undefined") {
    $(window).bind('beforeunload', function(e) {
        if (count > 1) {
            var message = "You will loss data!";
            return message;
        }
    });
}
//*****************************

$('#poref').change(function(e) {
        localStorage.setItem('poref', $(this).val());
});

if (poref = localStorage.getItem('poref')) {
        $('#poref').val(poref);
}

//*****************
$('#powarehouse').change(function(e) {
    localStorage.setItem('powarehouse', $(this).val());
});

if (powarehouse = localStorage.getItem('powarehouse')) {
    $('#powarehouse').val(powarehouse);
}

//*****************
$('#postatus').change(function(e) {
    localStorage.setItem('postatus', $(this).val());
});

if (postatus = localStorage.getItem('postatus')) {
    $('#postatus').val(postatus);
}

//*****************
$('#ponote').change(function(e) {
    localStorage.setItem('ponote', $(this).val());
});

if (ponote = localStorage.getItem('ponote')) {
    $('#ponote').val(ponote);
}

//*************************

if (localStorage.getItem('poextras')) {
    $('#extras').iCheck('check');
    $('#extras-con').show();
}
$('#extras').on('ifChecked', function() {
    localStorage.setItem('poextras', 1);
    $('#extras-con').slideDown();
});
$('#extras').on('ifUnchecked', function() {
    localStorage.removeItem("poextras");
    $('#extras-con').slideUp();
});

//*****************
$('#tax_select').change(function(e) {
    localStorage.setItem('tax_select', $(this).val());
});

if (tax_select = localStorage.getItem('tax_select')) {
    $('#tax_select').val(tax_select);
}

//*****************
$('#podiscount').change(function(e) {
    localStorage.setItem('podiscount', $(this).val());
});

if (podiscount = localStorage.getItem('podiscount')) {
    $('#podiscount').val(podiscount);
}

//*****************
$('#poshipping').change(function(e) {
    localStorage.setItem('poshipping', $(this).val());
});

if (poshipping = localStorage.getItem('poshipping')) {
    $('#poshipping').val(poshipping);
}

//**********************
$('#supplier').change(function(e) {
    localStorage.setItem('supplier', $(this).val());
});

if (supplier = localStorage.getItem('supplier')) {
    $('#supplier').val(supplier);
}


//************** reset function *******

    $('#reset').click(function(e) {
        bootbox.confirm("Are you sure?", function(result) {
            if (result) {
                if (localStorage.getItem('poitems')) {
                    localStorage.removeItem('poitems');
                }
                if (localStorage.getItem('podiscount')) {
                    localStorage.removeItem('podiscount');
                }
                if (localStorage.getItem('tax_select')) {
                    localStorage.removeItem('tax_select');
                }
                if (localStorage.getItem('poref')) {
                    localStorage.removeItem('poref');
                }
                if (localStorage.getItem('powarehouse')) {
                    localStorage.removeItem('powarehouse');
                }
                if (localStorage.getItem('ponote')) {
                    localStorage.removeItem('ponote');
                }
                if (localStorage.getItem('posupplier')) {
                    localStorage.removeItem('posupplier');
                }
                if (localStorage.getItem('supplier')) {
                    localStorage.removeItem('supplier');
                }
                if (localStorage.getItem('poextras')) {
                    localStorage.removeItem('poextras');
                }
                if (localStorage.getItem('podate')) {
                    localStorage.removeItem('podate');
                }
                if (localStorage.getItem('postatus')) {
                    localStorage.removeItem('postatus');
                }
                if (localStorage.getItem('poshipping')) {
                    localStorage.removeItem('poshipping');
                }

               $('body').modalmanager('loading');
                location.reload();
            }
        });
    });


//************** end reset function ***


//begin calculation function //

//end calculation function //