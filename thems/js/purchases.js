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