<!DOCTYPE html>

<head>
<title>PSD CATERS</title>

<!-- start: META -->

<meta charset="utf-8" />

<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->

<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta content="" name="description" />
<meta content="" name="author" />
<link rel="icon" type="image/png" href="<?php echo base_url(); ?>thems/images/logo-icon.png" />
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>fonts/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/customer-main.css">
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/customer-responsive.css">
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/theme_light.css" id="skin_color">
<link rel="stylesheet" href="<?php echo asset_url(); ?>css/perfect-scrollbar.min.css" />
<link rel="stylesheet" href="<?php echo asset_url(); ?>css/cusajax.0.1.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo asset_url(); ?>css/jquery-ui.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/iCheck/skins/all.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/gritter/css/jquery.gritter.css" type="text/css">
</head>
<body style="overflow:visible">
<div class="row"> </div>
<!-- start: HEADER -->
<div class="navbar navbar-inverse navbar-fixed-top"> 
  <!-- start: TOP NAVIGATION CONTAINER -->
  <div class="container">
    <div class="navbar-header">
      <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button"> <span class="fa fa-list"></span> </button>
      <a class="navbar-brand" href="<?php echo base_url('customer'); ?>">

	<img src="<?php echo asset_url(); ?>images/logo.png" style="margin-top: -15px; margin-left: -10px;

width: 60px;">

</a>
    </div>
    <div class="navbar-tools">
      <?php //$this->load->view("common/notifications.php"); ?>
    </div>
  </div>
</div>
<div class="main-container">
  <div class="navbar-content"> 
    <!--was here-->
    
    <div class="main-navigation navbar-collapse collapse" style="width:200px">
      <div class="navigation-toggler"> <i class="clip-chevron-left"></i> <i class="clip-chevron-right"></i> </div>
      <ul class="main-navigation-menu">
        <ul class="nav" style="height:200px">
          <li class="dropdown"> <a class="<?php /*?>btn<?php */?> account <?php /*?>dropdown-toggle<?php */?>" data-toggle="dropdown" href="#">
            <div class="user"> <img alt="user_img" src="<?php echo image_url(); ?>/male.png" class="mini_avatar img-rounded"> <br/>
              <span style="clear:both">Welcome! <?php echo $this->session->userdata['ss_user_first_name'] ?></span> </div>
            </a>
            <ul class="dropdown-menu pull-right" >
              <li style="display:none"> <a href="#"> <i class="fa fa-user"></i> Profile </a> </li>
              <li style="display:none"> <a href="#"> <i class="fa fa-key"></i> Change Password </a> </li>
              <li class="divider" style="display:none"></li>
              <?php /*?><li> <a href="<?php echo base_url('logout'); ?>"> <i class="fa fa-sign-out"></i> Logout </a> </li><?php */?>
            </ul>
          </li>
        </ul>
        <?php /*?><li style="margin-bottom: 50px;"> <a data-toggle="dropdown" style="padding:10px 0px 0px 40px;color: #428bca; font-weight: bold;" class="btn account dropdown-toggle"> <i class="fa fa-tr"></i> <span class="title"> <img alt="prof_pic_" style="position:absolute; left:5px;" src="<?php echo image_url(); ?>/male.png" class="mini_avatar img-rounded">Welcome! <?php echo $this->session->userdata['ss_user_first_name'] ?></span> </a> </li>
        <?php */?>
        <li class="active"> <a data-toggle="tab" href="#Products" style="padding:10px"> <i class="fa fa-shopping-cart"></i><span class="title">Cart </span> </a> </li>
        <li				  > <a data-toggle="tab" href="#delivery" style="padding:10px"> <i class="fa fa-truck"></i> <span class="title">My Orders </span></a> </li>
        <li				  > <a href="<?php echo base_url('logout'); ?>" style="padding:12px"><i class="fa fa-sign-out"></i> <span class="title">Logout </span></a> </li>
      </ul>
    </div>
  </div>
  <div class="main-content" >
    <?php /*?> <a href="http://127.0.0.1/stockmanager/manage/sales/load2" class="nav" >sales 2</a><?php */?>
    <div class="container col-xs-10" id="main_container" style="padding:0"> 
      <!-- container contents will load here-->
      <?php //$this->load->view("order/sub_category-slider"); ?>
          <div class="tab-content" style="border:none">
            <div id="Products" class="tab-pane active">
              <div class="table-responsive row"> 
                <!-- panel one -->
                <?php /*?><?php $this->load->view("order/biller") ?>
                <div class="rotate btn-cat-con">
                  <button type="button" class="btn btn-danger" id="view_bill" tabindex="-1"> <i class="fa fa-print"></i> </button>
                  <button type="button" id="open-subcategory" class="btn btn-warning open-subcategory">Subcategories</button>
                  <button type="button" id="open-category" class="btn btn-primary open-category">Categories</button>
                  <button style="display:none" id="open-keyboard" class="btn btn-success open-keyboard" type="button"><i class="clip-keyboard-2"></i></button>
                </div><?php */?>
                <?php //$this->load->view("pos/category-slider"); ?>
                <div id="cp" class="col-xs-7">
                  <div id="cpinner">
                    <ul class="nav nav-tabs navbar-nav tab-green no-print" id="myTab3" style="margin:-15px 0px 10px -10px; padding:0px">
                      <?php foreach ($category as $key => $cat) { ?>
                      <li <?php if($cat->cat_id == 3)echo 'class=active' ?>> <a data-toggle="tab" href="#cat_<?php echo $cat->cat_id; ?>" style="padding:10px"><?php echo $cat->cat_name; ?> </a> </li>
                      <?php } ?>
                    </ul>
                    <div id="ajaxproducts" >
                      <div id="item-list" style="overflow:scroll" class="dragscroll">
                        <?php
					echo '<div class="tabbable tabs-top">
							<div class="tab-content">';
				  foreach($product_list_by_category as $key=>$cat){
					  $status = '';
					  if($cat[0]['cat_id'] == 3) $status = 'active';
					  echo '<div id="cat_'.$cat[0]['cat_id'].'" class="tab-pane '.$status.'">';
					   foreach($cat as $value){
						echo " <button id='product-".$value['product_id']."' type='button'
									class='btn-prni btn-default product pos-tip box' value='".$value['product_code']."'
									data-container='body' product_price='".$value['product_price']."'
									title='".$value['product_name']."' product_id='".$value['product_id']."'
									style='font-weight:bold;font-size:14px; height:100px;min-width:163px;max-width:180px; position:relative;
									background-image:url( ".asset_url()."uploads/thumbs/".$value['product_thumb'].");
									background-repeat:no-repeat; background-position:left top;' >
                      
											<label style='background-color:rgba(255, 255, 255, 0.8); text-align:justify; font-size:16px;max-height: 67px; position:absolute; right:0; width:100%' id='product-".$value['product_id']."'
											type='button' class='btn-prni btn-default product' value='".$value['product_code']."'
											data-container='body' product_price='".$value['product_price']."'
											title='".$value['product_name']."' product_id='".$value['product_id']."'>
											".substr($value['product_name'], 0, 25)."- Rs. ".$value['product_price']."
											</label>
                      			</button>";
						   }echo '</div>';
					  }
					echo '</div>
					</div>';
				  ?>
                      </div>
                      <div style="clear:both;"></div>
                    </div>
                    <div style="clear:both;"></div>
                  </div>
                  <div style="clear:both;"></div>
                </div>
                <div class="col-xs-5 pull-right" style="padding-left:0px;">
                  <form action="#" data-toggle="validator" role="form" id="pos-sale-form" name="pos-sale-form" method="post" accept-charset="utf-8">
                    <input type="hidden" name="token" value="d6c35d2aebf0b3b14b4016c954dd2786" style="display:none;"/>
                    <div id="leftdiv" class="ui-widget quick-menu" >
                      <div id="left-top" class="quick-menu">
                        <div class="no-print">
                          <div style="display:none" id="input_panel" class="form-group">
                            <select name="poswarehouse" id="poswarehouse" class="search-select" data-placeholder="Select Warehouse">
                              <option value="">-select-</option>
                              <?php foreach ($get_warehouse as $value) { ?>
                              <option value="<?php echo $value->id; ?>" <?php if($this->session->userdata('ss_warehouse_id') == $value->id ) echo 'selected' ?>><?php echo $value->name; ?> | <?php echo $value->code; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <?php  //print_r($this->session->userdata('ss_user_id')); ?>
                          <input id="poscustomer" name="poscustomer" type="hidden" value="<?php  print_r($this->session->userdata('ss_user_id')); ?>" >
                          <input name="base_url" type="hidden" id="base_url" value="<?php echo base_url();?>">
                          <input type="hidden" id="customer_mobile" value="" />
                          <input id="cb_3" name="delivery_status" checked="checked" type="radio" style="display:none" value="3" />
                          <div class="form-group" id="ui">
                            <div class="input-group" >
                              <input type="text" name="add_item" value="" class="form-control pos-tip" id="add_item" data-placement="top" data-trigger="focus" style="background-color:#FFF"/>
                              <!--title="Please start typing code/name for suggestions"-->
                              <div class="input-group-addon" style="padding: 2px 8px; border-left: 0;"><i class="fa fa-search" style="font-size: 1em;"></i> </div>
                            </div>
                            <div style="clear:both;"></div>
                          </div>
                        </div>
                      </div>
                      <div id="print" class="no-print">
                        <div id="left-middle" style="min-height:278px;">
                          <div id="product-list" class="ps-container ps-active-y">
                            <table style="margin-bottom: 0;" id="posTable" class="table items table-striped table-bordered table-condensed table-hover">
                              <thead>
                                <tr>
                                  <th style="width:30%">Product</th>
                                  <th style="width:20%">Price</th>
                                  <th style="width:15%">Qty</th>
                                  <th style="width:20%">Subtotal</th>
                                  <th style="width: 10%; text-align: center;"><i style="opacity:0.5; filter:alpha(opacity=50);" class="fa fa-trash-o"></i></th>
                                </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                            <div style="clear:both;"></div>
                            <div class="ps-scrollbar-x-rail" style="width: 436px; display: none; left: 0px; bottom: 3px;">
                              <div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div>
                            </div>
                            <div class="ps-scrollbar-y-rail" style="top: 0px; height: 319px; display: none; right: 3px;">
                              <div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div>
                            </div>
                          </div>
                        </div>
                        <div style="clear:both;"></div>
                        <div id="left-bottom">
                          <table style="width:100%; float:right; padding:5px; color:#000; background: #FFF;" id="totalTable">
                            <tbody>
                              <tr>
                                <td style="padding: 5px 10px;border-top: 1px solid #DDD;">Items</td>
                                <td style="padding: 5px 10px;font-size: 14px; font-weight:bold; border-top: 1px solid #DDD;" class="text-right"><span id="titems">0</span></td>
                                <td style="padding: 5px 10px;border-top: 1px solid #DDD;">Total</td>
                                <td style="padding: 5px 10px;font-size: 14px; font-weight:bold; border-top: 1px solid #DDD;" class="text-right"><span id="total">0.00</span></td>
                              </tr>
                              <?php /*?><tr>
                      <td style="padding: 5px 10px;border-top: 1px solid #DDD;">Discount &nbsp;<a id="ppdiscount" href="#"> <i class="fa fa-edit"></i> </a></td>
                      <td style="padding: 5px 10px;font-size: 14px; font-weight:bold; border-top: 1px solid #DDD;" class="text-right"><span id="tds">0.00</span></td>
                      <td style="padding: 5px 10px;border-top: 1px solid #DDD;" ><span class=""> Delivery &nbsp;<a href="#" id="pshipping"> <i class="fa fa-plus-square"></i> </a></span></td>
                      <td style="padding: 5px 10px;font-size: 14px; font-weight:bold; border-top: 1px solid #DDD;" class="text-right"><span class="hide_me"><span id="tship">0.00</span></span></td>
                    </tr><?php */?>
                              <tr>
                                <td colspan="2" style="padding: 5px 10px; border-top: 1px solid #666; font-weight:bold; background:#333; color:#FFF;"> Total Payable</td>
                                <td colspan="2" style="padding:5px 10px 5px 10px; font-size: 14px;border-top: 1px solid #666; font-weight:bold; background:#333; color:#FFF;"><span id="sc_sp" style="visibility:hidden">(S.C 10% included)</span><span class="text-right pull-right" id="gtotal">0.00</span></td>
                              </tr>
                            </tbody>
                          </table>
                          <input type="hidden" value="3" id="biller" name="biller">
                          <div class="input-group" style="width:100%">
                            <label>Delivery Location </label>
                            <!--title="Please start typing code/name for suggestions"-->
                            <input type="text" name="shipping_address" class="" data-placement="top" style="background-color:#FFF" id="shipping_address" value="<?php echo $this->session->userdata['ss_user_address'] ?>">
                          </div>
                          <div style="clear:both;"></div>
                          <div id="botbuttons" class="col-xs-12 text-center">
                            <div class="row">
                              <div class="col-xs-6" style="padding: 0;display:none">
                                <button type="button" class="btn btn-warning btn-block" id="hold" style="height:36px;" tabindex="-1"> <i class="fa fa-hand-paper-o" style="margin-right: 5px;"></i>Hold </button>
                              </div>
                              <div class="col-xs-6" style="padding: 0;">
                                <div class="btn-group-vertical btn-block">
                                  <button type="button" class="btn btn-danger btn-block btn-flat cancel" id="reset" tabindex="-1" style="height:36px;"> Cancel </button>
                                </div>
                              </div>
                              <div class="col-xs-6" style="padding: 0;">
                                <button type="button" class="btn btn-success btn-block" id="payment" style="height:36px;" tabindex="-1"> <i class="fa fa-money" style="margin-right: 5px;"></i>Place Order </button>
                              </div>
                            </div>
                            <?php /*?><div class="btn-group btn-group-justified">
                                       <div class="btn-group">
                                          <div class="btn-group btn-group-justified">
                                             <div class="btn-group">
                                                <button id="reset" class="btn btn-danger" type="button">Cancel</button>
                                             </div>
                                          </div>
                                          
                                           <div class="btn-group">
                                                <button id="print_bill" class="btn btn-primary" type="button">
                                                <i class="fa fa-print"></i> Bill </button>
                                             </div>
                                          
                                       </div>
                                       
                                       <div class="btn-group">
                                          <button id="payment" class="btn btn-success" type="button">

                                          <i class="fa fa-money"></i> Payment </button>
                                       </div>
                                    </div><?php */?>
                          </div>
                          <div style="clear:both; height:5px;"></div>
                          <div id="num">
                            <div id="icon"></div>
                          </div>
                          <span id="hidesuspend"></span>
                          <?php if($sale_id) {?>
                          <input type="hidden" name="sale_id" id="sale_id" value="<?php echo $sale_id; ?>">
                          <input type="hidden" name="sale_reference_no" id="sale_reference_no" value="<?php echo $sale_details[0]['sale_reference_no']; ?>">
                          <?php } ?>
                          <input type="hidden" name="posshipping" id="posshipping" value="<?php if($sale_id){if($sale_details[0]['sale_shipping']) echo $sale_details[0]['sale_shipping'];}else echo '0.00'; ?>">
                          <input type="hidden" name="rowCount" id="rowCount" value="0">
                          <!--keyboard input-->
                          <input type="hidden" id="id-name" value="" />
                          <!--end keyboard input-->
                          <input type="hidden" name="sale_datetime" id="sale_datetime" value="0">
                          <input type="hidden" name="discount" id="posdiscount" value="0">
                          <input type="hidden" name="pos_discount_input1" id="pos_discount_input1" value="0">
                          <input type="hidden" name="pay_amount" id="pay_amount" value=""/>
                          <input type="hidden" name="balance_amount" id="balance_amount_1" value=""/>
                          <input type="hidden" name="grand_total" id="grand_total" value="">
                          <input type="hidden" name="paid_by" id="paid_by_val_1" value="cash"/>
                          <input type="hidden" name="cc_name" id="cc_name" value=""/>
                          <input type="hidden" name="cc_no" id="cc_no" value=""/>
                          <input type="hidden" name="pcc_holder" id="pcc_holder" value=""/>
                          <input type="hidden" name="pcc_type" id="pcc_type" value="visa"/>
                          <input type="hidden" name="payment_note" id="pos_note" value="" />
                          <input type="hidden" name="extra_charges" id="extra_charges" value="" />
                          <input type="hidden" name="extra_charges_amount" id="extra_charges_amount" value="" />
                          <input type="hidden" name="proContainerWidth" id="proContainerWidth" value="" />
                        </div>
                      </div>
                    </div>
                  </form>
                  <?php /*?><div id="bill_tbl"><span id="bill_span"></span>
          <table id="bill-table" width="100%" class="prT table table-striped" style="margin-bottom:0;">
          </table>
          <table id="bill-total-table" class="prT table" style="margin-bottom:0;" width="100%">
          </table>
          <span id="bill_footer"></span> </div><?php */?>
                  <div style="clear:both;"></div>
                </div>
                <!-- end panel one --> 
              </div>
            </div>
            <div id="delivery" class="tab-pane"><!-- content here -->
              <?php $this->load->view("order/delivery_s") ?>
            </div>
          </div>
        
    </div>
  </div>
</div>
</body>
<script src="<?php echo asset_url(); ?>js/moment.min.js"></script>
<noscript>
<div class="global-site-notice noscript">
  <div class="notice-inner">
    <p><strong>JavaScript seems to be disabled in your browser.</strong><br>
      You must have JavaScript enabled in
      your browser to utilize the functionality of this website.</p>
  </div>
</div>
</noscript>
<input id="count" value="0" type="hidden"/>
<input type="hidden" id="fucking_done" value="0">

<!-- end pop upbox-->
<script type="text/javascript" src="<?php echo asset_url(); ?>plugins/jQuery-lib/2.0.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery-ui.min.js"></script><!--
<script type="text/javascript" src="<?php echo asset_url(); ?>js/ui-modals.js"></script>-->
<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.sendkeys.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>js/bililiteRange.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script>
<!-- jQuery Kinetic - for touch -->
<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.kinetic.min.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.smoothdivscroll-1.3-min.js" ></script>
<!--<script type="text/javascript" src="<?php echo asset_url(); ?>js/plugins.min.js"></script> -->
<script type="text/javascript" src="<?php echo asset_url(); ?>js/autoNumeric.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>js/dragscroll.js"></script>
<script type="text/javascript">

		$('#product-list, #category-list, #subcategory-list, #brands-list').perfectScrollbar({suppressScrollX: true});
		
		/*$('#posTable').stickyTableHeaders({scrollableArea: $('#product-list')});*/
		
 	     <?php 
		 if($product_list){
		 echo 'var jsonarray =';
		 print_r($product_list);
		 echo ';';
		 }
		 else {
		 echo 'var jsonarray = {};';
		 }
		 ?>
		
		var base_url = '<?php echo base_url(); ?>';
		$('#modal-loading').show();
      </script>
<script type="text/javascript" src="<?php echo asset_url(); ?>plugins/gritter/js/jquery.gritter.min.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>plugins/iCheck/jquery.icheck.min.js"></script>
<script type="text/javascript" src="<?php echo asset_url();?>js/cus.ajax.0.1.js"></script>
<script src="<?php echo asset_url(); ?>js/cus_main.js"></script>
<script>
Main.init();
	function form_submit() {
		$('#modal-loading').show();
		
		/*---- add to bill ----*/
			$('#bill_date').text('Date: '+$('#sale_datetime').val());
		/*-- end --*/
		
		var fields = $("#pos-sale-form").serialize();
		/*console.log(fields);*/
		$.post("<?php echo base_url();?>pos/pos_submit", fields)
			.done(function (data) {
				var obj = jQuery.parseJSON(data);
				/*console.log(obj);*/
				if (obj.error == 1) {
					$('.alert-success').hide();
					$('.alert-danger').show();
					$(".errortxt").text(obj.disMsg);
					window.scrollTo(500, 0);
				}
				if (obj.error == 0) {
					window.scrollTo(500, 0);
					$("#soTable > tbody").empty();
					$('#bill_no').text('Bill No:'+obj.sale_ref);

					$('#fucking_done').val(1);
					displayNotice('page', 'Sale successfully added!');
						//setInterval(function(){form_reset();},5000);
						setTimeout(function(){form_reset();},2000);
						
				}
			});
	}

function form_reset() {
	window.location.reload(true);
}

	
function form_locate() {
	window.location.href = '<?php echo base_url();?>customer';
}

$('select#category').on('change', function () {
	var v = $(this).val();
	$.ajax({
		type: "get",
		async: false,
		url: "<?php echo base_url('products/get_sub_category_by_id'); ?>",
		data: {
			category_id: v
		},
		dataType: "html",
		success: function (data) {
			if (data != "") {
				$('#subcat_data').empty();
				$('#subcat_data').html(data);
				$("#subcategory").select2({
					allowClear: true
				});
			} else {
				$('#subcat_data').empty();
				var default_data = '<select name="subcategory" id="subcategory" class="form-control search-select" data-placeholder="Select Category to load Subcategories"></select>';
				$('#subcat_data').html(default_data);
				$("#subcategory").select2({
					allowClear: true
				});
				displayNotice("Product Info", "No Subcategory found for the select category.");
			}
		},
		error: function () {
			alert('Error occured while getting data from server.');
		}

	});
});

$('#save_product').on('click', (function (event) {
	/*console.log(event);	alert();*/
	if (event.target.id == "save_product") event.preventDefault();
	add_product();
}));

function add_product() {
	var fields = $("#add_product_form").serialize();
	/*alert(fields);*/
	var product_name = $('#product_name').val();
	if (product_name == "") {
		$('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>Complete form data</div>');
		$('#product_name').focus();
		return false;
	}
	var category = $('#category').val();
	if (category == "") {
		$('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>Complete form data</div>');
		$('#category').focus();
		return false;
	}
	var product_price = $('#product_price').val();
	if (product_price == "") {
		$('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>Complete form data</div>');
		$('#product_price').focus();
		return false;
	}
	var product_cost = $('#product_cost').val();
	if (product_cost == "") {
		$('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>Complete form data</div>');
		$('#product_cost').focus();
		return false;
	}

	var rowCount = 1;

	if (rowCount != 0) {
		$("#save_product").prop("disabled", true);
		$("#save_product").html('Please wait... <i class="fa fa-spinner fa-spin"></i>');

		$.post("<?php echo base_url();?>pos/save_pos_product", fields)
			.done(function (data) {
				var obj = jQuery.parseJSON(data);
				if (obj.status == 1) {
					$('div#error').html('<div class="alert alert-block alert-success fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>SUCCEED</div>');
					window.location.reload(true);
				} else {
					$('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>INVALID DATA !</div>');
				}
			});
		return false;

	} else {
		bootbox.alert('Please complete form data', function () {
			$('#add_item').focus();
		});
	}
}

<!-- VIEW SALES--> 
jQuery(document).ready(function () {
	<?php
if ($sale_id) {
    if ($sale_details[0]['dine_type'] == 1)
        echo '$(\'#content\').css(\'background-color\',\'#d9534f\');';
    else if ($sale_details[0]['dine_type'] == 2)
        echo '$(\'#content\').css(\'background-color\',\'#5cb85c\');';
    else if ($sale_details[0]['dine_type'] == 3)
        echo '$(\'#content\').css(\'background-color\',\'#eea236\');';
    echo '{';
    $l = count($sale_item_list);
    $c = 1;
    foreach ($sale_item_list as $row) {
        echo 'var jsonObj_' . $c . ' = [{"id":' . rand(1000, 5000) . ',"product_id":"' . $row['product_id'] . '","product_code":"' . $row['product_code'] . '","product_price":"' . $row['unit_price'] . '","label":"' . $row['product_code'] . ' | ' . $row['product_name'] . '","product_name":"' . $row['product_name'] . '","qty":"' . $row['quantity'] . '"}];';
        echo 'add_invoice_item(jsonObj_' . $c . ');';
        $c++;
    }
    echo '}';

	if($sale_details[0]['dine_type'] == 3 ){
		echo '$(\'.hide_me\').css(\'visibility\',\'visible\');';
		/*$('#posshipping').val();*/
		}
	
	
} else
    echo '$(\'#content\').css(\'background-color\',\'#5cb85c\');';
?>
loadDelivery();

});
var table;

function loadDelivery(table_name = '', dine_type = '') {
	table = $('#delivery_table').DataTable({
		"dom": "Blftrip",
		"bProcessing": true,
		"bSort":false,
		"ajax": {
			"url": "<?php echo base_url('pos/list_pos_sales') ?>",
			"data": {
				dine_type: 3,
				cus_id: $('#poscustomer').val()
			},
			"complete": function () {
				$(".select2-nosearch").select2({
					minimumResultsForSearch: Infinity
				});
				$(".pos-tip").tooltip();
			}
		},
		//"bPaginate": false,
		//"autoWidth": false,
		"bDestroy": true,
		"iDisplayLength": 10,
		"order": [
			[0, "desc"]
		]
	});
table.column( 2 ).visible( false );
table.column( 5 ).visible( false );
}
/*function abort_req() {
	$('input[type="search"]').bind('keypress', function () {
		if (table.settings()[0].jqXHR) {
			table.settings()[0].jqXHR.abort();
			$(".search-select").select2({
				allowClear: true
			});
		}
	});
}*/

function click_sales_view_btn(sale_id) {
	var $modal = $('#ajax-modal');
	$('body').modalmanager('loading');
	setTimeout(function () {
		$modal.load('<?php echo base_url("sales/sale_details?sale_id="); ?>' + sale_id, '', function () {
			$modal.modal();
			$(".search-select").select2({
				placeholder: "Select a State",
				allowClear: true
			});
		});
	}, 1000);
}

function fbs_click(id) {
	u = location.href;
	t = document.title;
	window.open('<?php echo base_url() ?>sales/sale_details?sale_id=' + id, 'sharer', 'toolbar=0,status=0,width=626,height=700, left=10, top=10,scrollbars=yes');
	return false;
}
function fbs_click_pos(id) {
	complete_sale(id);
	u = location.href;
	t = document.title;
	window.open('<?php echo base_url() ?>sales/sale_details_pos?sale_id=' + id, 'sharer', 'toolbar=0,status=0,width=626,height=700, left=10, top=10,scrollbars=yes');
	return false;
	/*console.log(mywindow);*/
}
function fbs_click_pos_no_c(id) {
	u = location.href;
	t = document.title;
	window.open('<?php echo base_url() ?>sales/sale_details_pos?sale_id=' + id, 'sharer', 'toolbar=0,status=0,width=626,height=700, left=10, top=10,scrollbars=yes');
	return false;
}
function edit_sale(id) {
	window.location = '<?php echo base_url() ?>pos/0/' + id;
	return false;
}

/*function resetfun() {
	this.location.reload(true);
}*/

function complete_sale(id) {
	jQuery.ajax({
		type: "POST",
		url: "<?php echo base_url().'pos/complete_sale'?>",
		data: {
			sale_id: id,
		},
		cache: false,
		success: function (response) {
			displayNotice('page', 'Sale Completed !!');
			loadDelivery();
			loadDineIn();
			loadTakeaway();
		}
	});
}

function set_as_paid(sid) {
	var sale_pymnt_date_time = $('#sale_datetime').val();
	var paid_by = $('#paying_by_' + sid).val();
	var given_amount = $('#c_pay_amount_' + sid).val();
	jQuery.ajax({
		type: "POST",
		url: "<?php echo base_url().'pos/set_as_paid'?>",
		data: {
			sale_id: sid,
			paid_by: paid_by,
			sale_pymnt_date_time: sale_pymnt_date_time,
			given_amount: given_amount

		},
		cache: false,
		success: function (response) {
			displayNotice('page', 'Payment Succeed!!');
loadDelivery();
loadDineIn();
loadTakeaway();
		}
	});
}

function delete_invoice(sid) {
	var group_id = $('#group_id').val();
	/*var confm =	window.confirm("Delete This Invoice ?");*/
	if (group_id != 3) {
		bootbox.confirm('Delete Invoice ' + sid + '?', function (e) {
			if (e) {
				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url().'sales/sales_delete?sale_id='?>" + sid,
					cache: false,
					success: function (response) {
						displayNotice('page', 'Successfully Deleted!!');
loadDelivery();
loadDineIn();
loadTakeaway();
					}
				});
			}
		});
	}
}

function delete_payments(sid) {
	var group_id = $('#group_id').val();
	/*var confm =	window.confirm("Delete Payments ?");*/
	if (group_id != 3) {
		bootbox.confirm('Delete Invoice Payments of Invoice ID: ' + sid + '?', function (e) {
			if (e) {
				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url().'sales/sale_pymnts_delete?sale_id='?>" + sid + "&in_type=sale",
					cache: false,
					success: function (response) {
						displayNotice('page', 'Successfully Deleted!!');
loadDelivery();
loadDineIn();
loadTakeaway();
					}
				});
			}
		});

	}
}

/*function scroll_to(val, speed) {
	$("html, body").animate({
		scrollTop: val
	}, speed);
}*/
 </script>
</html>