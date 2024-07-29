
<body>
<!-- start: MAIN CONTAINER -->



<div class="main-container">
  <div class="main-navigation"> 
    <?php $this->load->view("order/navigation") ?>
    <!-- start: MAIN MENU TOGGLER BUTTON -->
    
    <div class="navigation-toggler"> <i class="clip-chevron-left"></i> <i class="clip-chevron-right"></i> </div>
    <ul class="main-navigation-menu">
      <li class="active">
      	<a data-toggle="tab" href="#Products" style="padding:10px">
        	<i class="fa fa-truck"></i> <span class="title"> Rack </span><span class="selected"></span>
        </a>
      </li>
      <li> <a data-toggle="tab" href="#Sales" style="padding:10px"><i class="fa fa-shopping-cart"></i> My Cart</a> </li>
      <li> <a data-toggle="tab" href="#delivery" style="padding:10px"><i class="fa fa-truck"></i> My Orders </a> </li>
    </ul>
  </div>
  <?php /*?><div class="navbar-content"> 
     start: SIDEBAR 
    <div class="main-navigation navbar-collapse collapse">
      <?php $this->load->view("order/navigation") ?>
       start: MAIN MENU TOGGLER BUTTON 
      <ul class="main-navigation-menu">
        <li class="active"> <a data-toggle="tab" href="#Products" style="padding:10px"><i class="fa fa-truck"></i> Rack </a> </li>
        <li> <a data-toggle="tab" href="#Sales" style="padding:10px"><i class="fa fa-shopping-cart"></i> My Cart</a> </li>
        <li> <a data-toggle="tab" href="#delivery" style="padding:10px"><i class="fa fa-truck"></i> My Orders </a> </li>
      </ul>
    </div>
    
     end: SIDEBAR  
  </div><?php */?>
  <div class="main-content">
    <?php /*?> <a href="http://127.0.0.1/stockmanager/manage/sales/load2" class="nav" >sales 2</a><?php */?>
    <div class="container" id="main_container"> 
      <!-- start -->
      
      <div class=" panel-scroll" style="height:auto">
        <div class="tabbable tabs-top">
          <?php $this->load->view("order/sub_category-slider"); ?>
          <div class="tab-content">
            <div id="Sales" class="tab-pane">
              <div class="table-responsive"> 
                <!-- panel one -->
                <?php $this->load->view("order/biller") ?>
                <!-- end panel one --> 
              </div>
            </div>
            <div id="Products" class="tab-pane active">
              <div class="table-responsive"> 
                <!-- panel one -->
                <?php /*?><?php $this->load->view("order/biller") ?><?php */?>
                <div class="rotate btn-cat-con">
                  <button type="button" class="btn btn-danger" id="view_bill" tabindex="-1"> <i class="fa fa-print"></i> </button>
                  <button type="button" id="open-subcategory" class="btn btn-warning open-subcategory">Subcategories</button>
                  <button type="button" id="open-category" class="btn btn-primary open-category">Categories</button>
                  <button style="display:none" id="open-keyboard" class="btn btn-success open-keyboard" type="button"><i class="clip-keyboard-2"></i></button>
                </div>
                <?php $this->load->view("pos/category-slider"); ?>
                <div id="cp">
                  <div id="cpinner">
                    <div class="quick-menu" >
                      <div id="proContainer">
                        <div id="ajaxproducts" >
                          <div id="item-list" style="overflow:scroll" class="dragscroll">
                            <div id="makeMeScrollable">
                              <?php 
					  if($category_by_id_1){
									 $c = count($category_by_id_1);
									 $top = 0 ;
									 $left  = 0;
									 	for($i = 0; $i < $c; $i++ ){
											?>
                              <button 
                      id='product-<?php echo $category_by_id_1[$i]->product_id; ?>'
                      type='button'
                      class='btn-prni btn-default product pos-tip box'
                      value='<?php echo $category_by_id_1[$i]->product_code; ?>'
                      
                      data-container='body'
                      
                      product_price='<?php echo $category_by_id_1[$i]->product_price; ?>'
                      title='<?php echo $category_by_id_1[$i]->product_name; ?>'
                      product_id='<?php echo $category_by_id_1[$i]->product_id; ?>'
                      
                      style='font-weight:bold;font-size:14px;
                      			height:100px;min-width:150px;max-width:180px;
                              	position:relative;
                             <?php /*?> position:absolute;
                              top:<?php echo $top ?>px;
                              left:<?php echo $left ?>px;<?php */?>
                              background-image:url(<?php echo asset_url(); ?>uploads/thumbs/<?php echo $category_by_id_1[$i]->product_thumb; ?>);
                              background-repeat:no-repeat;
                              background-position:left top;'
                          
                      
                      
                      
                      >
                              <?php /*?><img class='img-rounded col-xs-6' style='padding:0px;' alt='<?php echo $category_by_id_1[$i]->product_name; ?>' src='<?php echo asset_url(); ?>uploads/thumbs/<?php echo $category_by_id_1[$i]->product_thumb; ?>'> <?php */?>
                              <label style="background-color:rgba(255, 255, 255, 0.8); position:absolute; right:0; width:100%"
                       
                       id='product-<?php echo $category_by_id_1[$i]->product_id; ?>'
                      type='button'
                      class='btn-prni btn-default product'
                      value='<?php echo $category_by_id_1[$i]->product_code; ?>'
                      
                      data-container='body'
                      
                      product_price='<?php echo $category_by_id_1[$i]->product_price; ?>'
                      title='<?php echo $category_by_id_1[$i]->product_name; ?>'
                      product_id='<?php echo $category_by_id_1[$i]->product_id; ?>'
                       
                       > <?php echo substr($category_by_id_1[$i]->product_name, 0, 25).'<br>'.$category_by_id_1[$i]->product_price; ?> </label>
                              </button>
                              <?php
					  
												/*if($left <= 550){
													$left +=170;
												}else{
													$top += 130;
													$left = 0;
												}*/
												
										}//end for loop
					  }?>
                              
                              <!--PREVIOUS WORKING-->
                              <?php /*?><?php foreach ($category_by_id_1 as $key => $product) { ?>
                                  
                                    <button style='font-weight:bold; font-size:12px; height:120px; min-width:150px; max-width:180px' data-container='body' class='btn-prni btn-default product pos-tip' title='<?php echo $product->product_name; ?>' value='<?php echo $product->product_code; ?>' type='button' id='product-<?php echo $product->product_id; ?>'>                                        
                                        <div class="row col-xs-12" style="height:100%;">
                                            <div class="col-xs-8" style="height:100%;">
	                                            <img class='img-rounded' style='height:113px; width:90px; margin-left:-16px;' alt='<?php echo $product->product_name; ?>' src='<?php echo asset_url(); ?>uploads/thumbs/<?php echo $product->product_thumb; ?>'>
                                            </div>
                                        	<div class="col-xs-4" style="height:100%; text-align:left; margin-left:0px; "><?php echo substr($product->product_name, 0, 20).'<br>'.$product->product_price; ?>
                                        	</div>
                                        </div>
                                    </button>
                                    
                                   
                                    <?php }?><?php */?>
                              
                              <!--PREVIOUS WORKING END--> 
                              
                            </div>
                          </div>
                          <div style="clear:both;"></div>
                        </div>
                      </div>
                    </div>
                    <div style="clear:both;"></div>
                  </div>
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
      <!-- end --> 
      <!-- container contents will load here--> 
    </div>
  </div>
</div>
</body>
<!-- end: BODY -->
</html><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>POS Module | Stock Manager Advance</title>
<link rel="stylesheet" href="<?php echo asset_url(); ?>css/perfect-scrollbar.min.css" />
<script src="<?php echo asset_url(); ?>js/moment.min.js"></script>
<link rel="stylesheet" href="<?php echo asset_url(); ?>css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/font-awesome/css/font-awesome.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>css/style.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo asset_url(); ?>css/cusajax.0.1.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo asset_url(); ?>css/jquery-ui.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/iCheck/skins/all.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/gritter/css/jquery.gritter.css" type="text/css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>css/print_pos.css" type="text/css" media="print"/>
<!--<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen" />-->
<!--<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />-->
<style>
@font-face {
	font-family: FontAwesome;
	font-weight: 400;
	font-style: normal
}
@font-face {
	font-family: Ubuntu;
	font-style: normal;
	font-weight: 400
}
@font-face {
	font-family: 'Ubuntu';
	font-style: normal;
	font-weight: 700;
src: local('Ubuntu Bold'), local('Ubuntu-Bold'), url(<?php echo asset_url();
?>fonts/trnbTfqisuuhRVI3i45C5w.woff) format('woff');
}
.h1, .h2, .h3, .h4, .h5, .h6, body, h1, h2, h3, h4, h5, h6 {
	font-family: Ubuntu, sans-serif
}
.hide_me {
	visibility: hidden
}
.modal.fade.in {
	top: 4%
}
.btn-round-xs {
	border-radius: 11px;
	padding-left: 10px;
	padding-right: 10px
}
#makeMeScrollable {
	width: 100%;
	position: relative;
	clear: both
}
#add_item {
	background: right no-repeat;
	padding-right: 17px
}
.select2-container .select2-choice .select2-arrow {
	background-image: none!important;
	width: 28px!important;
	text-align: center;
	padding-top: 0
}
.select2-container .select2-choice .select2-arrow b {
	background: 0 0!important;
	display: block;
	height: 100%;
	width: 100%
}
.select2-container .select2-choice .select2-arrow b:before {
	content: "\f078";
	display: inline;
	font-family: FontAwesome;
	font-weight: 300;
	height: auto;
	text-shadow: none
}
.select2-dropdown-open.select2-container-active .select2-choice .select2-arrow b:before {
	content: "\f077"
}
.select2-container-multi .select2-choices {
	background-image: none!important;
	background-color: #FFF!important
}
body {
	font-size: 13px
}
.input-group-addon {
	text-align: left;
	background-color: inherit
}
#s2id_poscustomer {
	border-left: 0;
	background-color: inherit;
	border-top: 0 none
}
#cpinner {
	width: 100%
}
.tab-green>li.active>a, .tab-green>li.active>a:focus, .tab-green>li.active>a:hover {
	border-color: #3d9400 #ddd transparent;
	border-top: 2px solid #3d9400
}
.tab-green>li>a:hover {
	color: #3d9400
}
.tab-green>li.dropdown.open.active>a:focus, .tab-green>li.dropdown.open.active>a:hover, .tab-green>li.open .dropdown-toggle {
	background-color: #3d9400;
	border-color: #3d9400;
	color: #fff
}
.tab-green .active>a, .tab-green .active>a:focus, .tab-green .active>a:hover, .tab-green .dropdown-menu>li>a:focus, .tab-green .dropdown-menu>li>a:hover {
	background-color: #3d9400
}
body .modal {
	width: auto!important
}
.dataTables_processing {
	position: absolute;
	top: 50%;
	left: 50%;
	width: 100%;
	height: 40px;
	margin-left: -50%;
	margin-top: -25px;
	padding-top: 0;
	text-align: center;
	font-size: 2em;
	background-color: #fff;
	background: -webkit-gradient(linear, left top, right top, color-stop(0, rgba(255,255,255,0)), color-stop(25%, rgba(255,255,255,.9)), color-stop(75%, rgba(255,255,255,.9)), color-stop(100%, rgba(255,255,255,0)));
	background: -webkit-linear-gradient(left, rgba(255,255,255,0) 0, rgba(255,255,255,.9) 25%, rgba(255,255,255,.9) 75%, rgba(255,255,255,0) 100%);
	background: -moz-linear-gradient(left, rgba(255,255,255,0) 0, rgba(255,255,255,.9) 25%, rgba(255,255,255,.9) 75%, rgba(255,255,255,0) 100%);
	background: -ms-linear-gradient(left, rgba(255,255,255,0) 0, rgba(255,255,255,.9) 25%, rgba(255,255,255,.9) 75%, rgba(255,255,255,0) 100%);
	background: -o-linear-gradient(left, rgba(255,255,255,0) 0, rgba(255,255,255,.9) 25%, rgba(255,255,255,.9) 75%, rgba(255,255,255,0) 100%);
	background: linear-gradient(to right, rgba(255,255,255,0) 0, rgba(255,255,255,.9) 25%, rgba(255,255,255,.9) 75%, rgba(255,255,255,0) 100%)
}
#ajaxproducts {
	height: 100%;
	width: 100%;
	overflow: hidden;
}
#item-list {
	width: 100%;
	height: 100%;
	overflow-y: scroll;
	padding-right: 17px; /* Increase/decrease this value for cross-browser compatibility */
	margin-bottom: -17px;
	box-sizing: content-box; /* So the width will be 100% + 17px */
}
</style>
</head>
<body>
<noscript>
<div class="global-site-notice noscript">
  <div class="notice-inner">
    <p><strong>JavaScript seems to be disabled in your browser.</strong><br>
      You must have JavaScript enabled in
      your browser to utilize the functionality of this website. </p>
  </div>
</div>
</noscript>
<input type="hidden" id="fucking_done" value="0">

<!-- end pop upbox--> 
<script type="text/javascript" src="<?php echo asset_url(); ?>plugins/jQuery-lib/2.0.3/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>plugins/select2/select2.min.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>plugins/bootstrap/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/perfect-scrollbar.min.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery-ui.min.js"></script> <!--
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
					//displayNotice('page', 'Sale successfully added!');
					/*$('#submit_form').html('<button onClick="fbs_click('+obj.sale_id+')" class="btn btn-block btn-lg btn-success" id="print_sale"><i class="fa fa-print"></i><span class="hidden-sm hidden-xs">Print</span></button>');*/

					$('#bill_no').text('Bill No:'+obj.sale_ref);

					$('#fucking_done').val(1);
					//$('#bill_customer').text('Customer :'+$(".select2-chosen").text());
					//fbs_click(obj.sale_id);
/*console.log($(".select2-chosen"));*/
fbs_click(obj.sale_id);
form_reset();
					/*$("#view_bill_modal").modal().on("shown.bs.modal", function() {
						console.log('attempting to print...');
						console.log('printable status :'+site.settings.printable);
						if(site.settings.printable === true){
						window.print();
						console.log('doc printed');
						site.settings.printable = false;
						console.log('print status changed to:'+site.settings.printable);
						}else console.log('not printed');
						$("#view_bill_modal").modal('hide');
						})
						.on("hidden.bs.modal", function() {
						form_reset();
						})*/
					//console.log('line:'+138);
				}
			});
	}

function form_reset() {
	/*
	console.log('requested to form reset.');*/
	var done = $('#fucking_done').val();
	if (done == 1) {
		if(!$('#sale_id').val())
		form_clear();
		else form_locate();
	}
}
function form_clear(){
	/*
	console.log('clearing...');
	window.location.reload(true);
	site.settings.printable = true;
	*/

grand_total_cal();
loadDelivery();
loadDineIn();
loadTakeaway();

$('#amount_1').val('0');
$('#balance_amount_1').val('');
$('#bill_customer').val('');
$('#cb_2').iCheck('check');
$('#cc_name').val('');
$('#cc_no').val('');
$('#content').css('background-color','#5cb85c');
$('#extra_charges').val('');
$('#extra_charges_amount').val('0');
$('#fucking_done').val('0');
$('#grand_total').val('');
$('#id-name').val('');
$('#kot_table >tbody').empty();
$('#order_discount_input').val('0');
$('#pay_amount').val('');
$('#paymentModal').modal('hide');
$('#pcc_holder').val('');
$('#pcc_type').val('');
$('#pos_discount_input1').val('');
$('#pos_note').val('');
$('#poscustomer').select2('readonly', false);
$('#poscustomer').val('1').trigger('change');
$('#posdiscount').val('');
$('#posshipping').val('0');
$('#posTable >tbody').empty();
$('#rowCount').val('0');
$('#sale_datetime').val('');
$('#sale_id').val('');
$('#sale_reference_no').val('');
$('#shipping_address').val('');
$('#shipping_input').val('0');
$('#submit-sale').attr('disabled', false);
$('#tds').text('0.00');
$('.bill_content').remove();

$('#modal-loading').hide();
	}
	
function form_locate() {
	window.location.href = '<?php echo base_url();?>pos';
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
loadDineIn();
loadTakeaway();
});
var table;

function loadDelivery(table_name = '', dine_type = '') {
	table = $('#delivery_table').DataTable({
		"dom": "Bftrip",
		"bProcessing": true,
		"ajax": {
			"url": "<?php echo base_url('pos/list_pos_sales') ?>",
			"data": {
				dine_type: 3
			},
			"complete": function () {
				$(".select2-nosearch").select2({
					minimumResultsForSearch: Infinity
				});
				$(".pos-tip").tooltip();
			}
		},
		"bPaginate": false,
		"autoWidth": false,
		"bDestroy": true,
		"iDisplayLength": 10,
		"order": [
			[0, "desc"]
		]
	});
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

function loadTakeaway(table_name = '', dine_type = '') {
	table = $('#takeaway').DataTable({
		"dom": "Bftrip",
		"bProcessing": true,
		"ajax": {
			"url": "<?php echo base_url('pos/list_pos_sales') ?>",
			"data": {
				dine_type: 2
			},
			"complete": function () {
				$(".select2-nosearch").select2({
					minimumResultsForSearch: Infinity
				});
				$(".pos-tip").tooltip();
			}
		},
		"bPaginate": false,
		"autoWidth": false,
		"bDestroy": true,
		"iDisplayLength": 10,
		"order": [
			[0, "desc"]
		]
	});
}
/*end take away */
function loadDineIn(table_name = '', dine_type = '') {
	table = $('#dine_in_table').DataTable({
		"dom": "Bftrip",
		"bProcessing": true,
		"ajax": {
			"url": "<?php echo base_url('pos/list_pos_sales') ?>",
			"data": {
				dine_type: 1
			},
			"complete": function () {
				$(".select2-nosearch").select2({
					minimumResultsForSearch: Infinity
				});
				$(".pos-tip").tooltip();
			}
		},
		"bPaginate": false,
		"autoWidth": false,
		"bDestroy": true,
		"iDisplayLength": 10,
		"order": [
			[0, "desc"]
		],
	});
}

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
</body>
</html>