<!-- start ajax model -->
<div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
<!-- end ajax model -->
<!-- start popup box-->
<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
            <h4 class="modal-title">Confirm</h4>
        </div>
        <div class="modal-body">
            <p id="label"> </p>
        </div>
        <div class="modal-footer">
            <input id="sel_id" type="hidden" />
            <input id="page" type="hidden" />
            <input id="popup_type" type="hidden" />
            <button aria-hidden="true" data-dismiss="modal" class="btn btn-default"> Close </button>
            <button id="conirm" class="btn btn-default" data-dismiss="modal"> Confirm </button>
        </div>
    </div>
</div>
</div>
<!-- end pop upbox-->
<!-- start: MAIN JAVASCRIPTS -->
<!--[if lt IE 9]>
		<script src="<?php echo asset_url(); ?>plugins/respond.min.js"></script>
		<script src="<?php echo asset_url(); ?>plugins/excanvas.min.js"></script>
		<script type="text/javascript" src="<?php echo asset_url(); ?>plugins/jQuery-lib/1.10.2/jquery.min.js"></script>
		<![endif]-->
<!--[if gte IE 9]><!-->
<script src="<?php echo asset_url(); ?>plugins/jQuery-lib/2.0.3/jquery.min.js"></script>
<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>   -->
<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" ></script> -->
<!--<![endif]-->
<script src="<?php echo asset_url(); ?>plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
<script src="<?php echo asset_url(); ?>plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo asset_url(); ?>plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
<script src="<?php echo asset_url(); ?>plugins/blockUI/jquery.blockUI.js"></script>
<script src="<?php echo asset_url(); ?>plugins/iCheck/jquery.icheck.min.js"></script>
<script src="<?php echo asset_url(); ?>plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
<script src="<?php echo asset_url(); ?>plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
<!--<script src="<?php echo asset_url(); ?>plugins/less/less-1.5.0.min.js"></script> -->
<script src="<?php echo asset_url(); ?>plugins/jquery-cookie/jquery.cookie.js"></script>
<!--<script src="<?php echo asset_url(); ?>plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script> -->
<script src="<?php echo asset_url(); ?>js/main.js"></script>
<script src="<?php echo asset_url(); ?>plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
<script src="<?php echo asset_url(); ?>plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
<script src="<?php echo asset_url(); ?>js/ui-modals.js"></script>
<script src="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
<script src="<?php echo asset_url(); ?>plugins/select2/select2.min.js"></script>
<script src="<?php echo asset_url(); ?>plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo asset_url(); ?>plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo asset_url(); ?>plugins/DataTables/media/js/DT_bootstrap.js"></script>
<script src="<?php echo asset_url(); ?>js/table-data.js"></script>
<script src="<?php echo asset_url(); ?>plugins/gritter/js/jquery.gritter.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        Main.init();
        UIModals.init();
        setTimeout(function() {
            $(".search-select").select2({
                allowClear: true
            });
        }, 1);
    });
    $('a#modal_ajax_transactions_btn').on('click', function() {
        // create the backdrop and wait for next modal to be triggered
        $('body').modalmanager('loading');
        setTimeout(function() {
            $modal.load('<?php echo base_url("transactions/create_transactions"); ?>', '', function() {
                $modal.modal();
            });
        }, 1000);
    });
    //category model load event
    var $modal = $('#ajax-modal');
    $('a#modal_ajax_demo_btn').on('click', function() {
        // create the backdrop and wait for next modal to be triggered
        $('body').modalmanager('loading');
        setTimeout(function() {
            $modal.load('<?php echo base_url("product_category/add_category"); ?>', '', function() {
                $modal.modal();
            });
        }, 1000);
    });
    //sub category model load event
    $('a#modal_ajax_demo_btn1').on('click', function() {
        // create the backdrop and wait for next modal to be triggered
        $('body').modalmanager('loading');
        setTimeout(function() {
            $modal.load('<?php echo base_url("product_category/add_subcategory"); ?>', '', function() {
                $modal.modal();
                $(".search-select").select2({
                    allowClear: true
                });
            });
        }, 1000);
    });
    //category model load event
    // var $modal = $('#ajax-modal');
    $('a#modal_ajax_customers_btn').on('click', function() {
        // create the backdrop and wait for next modal to be triggered
        $('body').modalmanager('loading');
        setTimeout(function() {
            $modal.load('<?php echo base_url("customers/create_customers"); ?>', '', function() {
                $modal.modal();
            });
        }, 1000);
    });
    $('a#modal_ajax_create_vehicle_btn').on('click', function() {
        $('body').modalmanager('loading');
        setTimeout(function() {
            $modal.load('<?php echo base_url("vehicles/create_vehicles"); ?>', '', function() {
                $modal.modal();
            });
        }, 1000);
    });
    //category model load event
    // var $modal = $('#ajax-modal');
    $('a#modal_ajax_suppliers_btn').on('click', function() {
        // create the backdrop and wait for next modal to be triggered
        $('body').modalmanager('loading');
        setTimeout(function() {
            $modal.load('<?php echo base_url("suppliers/create_supplier"); ?>', '', function() {
                $modal.modal();
            });
        }, 1000);
    });
    //category model load event
    // var $modal = $('#ajax-modal');
    $('a#modal_ajax_tax_rates_btn').on('click', function() {
        // create the backdrop and wait for next modal to be triggered
        $('body').modalmanager('loading');
        setTimeout(function() {
            $modal.load('<?php echo base_url("tax_rates/add_tax_rates"); ?>', '', function() {
                $modal.modal();
            });
        }, 1000);
    });
    //category model load event
    var $modal = $('#ajax-modal');
    $('a#modal_ajax_locations_btn').on('click', function() {
        // create the backdrop and wait for next modal to be triggered
        $('body').modalmanager('loading');
        setTimeout(function() {
            $modal.load('<?php echo base_url("locations/create_location"); ?>', '', function() {
                $modal.modal();
            });
        }, 1000);
    });
    //sales payment model load event
    var $modal = $('#ajax-modal');
    $('a#modal_ajax_sales_payment_btn').on('click', function() {
        // create the backdrop and wait for next modal to be triggered
        //var sale_type = 'none';
        var sale_id = $('#sale_id').val();
        var sale_type = $('#sale_type').val();
        $('body').modalmanager('loading');
        setTimeout(function() {
            $modal.load('<?php echo base_url("sales/payments?id='+sale_id+'&sale_type="); ?>' + sale_type, '', function() {
                $modal.modal();
                $('#sale_pymnt_amount').focus();
            });
        }, 1000);
    });
    function set_message(title, text) {
        $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: title,
            // (string | mandatory) the text inside the notification
            text: text,
            // (string | optional) the image to display on the left
            sticky: false,
            // (int | optional) the time you want it to be alive for before fading out
            time: ''
        });
    }
    //notification
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
    $('a#modal_ajax_floor_btn').on('click', function() {
        // create the backdrop and wait for next modal to be triggered
        $('body').modalmanager('loading');
        setTimeout(function() {
            $modal.load('<?php echo base_url("restaurants_settings/add_floor"); ?>', '', function() {
                $modal.modal();
            });
        }, 1000);
    });
    $('a#modal_ajax_division_btn').on('click', function() {
        // create the backdrop and wait for next modal to be triggered
        $('body').modalmanager('loading');
        setTimeout(function() {
            $modal.load('<?php echo base_url("restaurants_settings/add_division"); ?>', '', function() {
                $modal.modal();
            });
        }, 1000);
    });
    function cash_drawer_open() {
        var id = 0;
        u = location.href;
        t = document.title;
        window.open('<?php echo base_url() ?>sales/cash_drawer_open?sale_id=' + id, 'sharer', 'toolbar=0,status=0,width=626,height=700, left=10, top=10,scrollbars=yes');
        return false;
    }
    $('a#modal_ajax_qty_payment_btn').on('click', function() {
        // create the backdrop and wait for next modal to be triggered
        //var sale_type = 'none';
        var sale_id = $('#qts_id').val();
        var sale_type = $('#sale_type').val();
        $('body').modalmanager('loading');
        setTimeout(function() {
            $modal.load('<?php echo base_url("sales/advance_payments?id='+sale_id+'&sale_type="); ?>' + sale_type, '', function() {
                $modal.modal();
                $('#sale_pymnt_amount').focus();
            });
        }, 1000);
    });
</script>
<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/buttons.print.min.js"></script>
<?php
if (defined('ENVIRONMENT')) {
    if (ENVIRONMENT == 'development') {
        echo "
        <style>
        .navbar-inverse {
        background: rgb(0 0 0) !important;
        border-color: #C8C7CC !important;
}
</style>
";
    }
}
?>
<!-- end: MAIN JAVASCRIPTS -->