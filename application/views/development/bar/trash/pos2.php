<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>POS Module | Stock Manager Advance</title>
      <meta http-equiv="cache-control" content="max-age=0"/>
      <meta http-equiv="cache-control" content="no-cache"/>
      <meta http-equiv="expires" content="0"/>
      <meta http-equiv="pragma" content="no-cache"/>
      <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/font-awesome/css/font-awesome.min.css">
      <link rel="stylesheet" href="<?php echo asset_url(); ?>fonts/style.css">
      <link rel="stylesheet" href="<?php echo asset_url(); ?>css/main.css">
      <link rel="stylesheet" href="<?php echo asset_url(); ?>css/main-responsive.css">
      <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/iCheck/skins/all.css">
      <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css">
      <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/perfect-scrollbar/src/perfect-scrollbar.css">
      <link rel="stylesheet" href="<?php echo asset_url(); ?>css/theme_light.css" type="text/css" id="skin_color">
      <link rel="stylesheet" href="<?php echo asset_url(); ?>css/print.css" type="text/css" media="print"/>
      <link rel="stylesheet" href="<?php echo asset_url(); ?>css/style.css" type="text/css"/>
      <link rel="stylesheet" href="<?php echo asset_url(); ?>css/posajax.css" type="text/css"/>
      <link rel="stylesheet" href="<?php echo asset_url(); ?>css/jquery-ui.css" type="text/css"/>

      <!-- <link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/> -->
      <link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
      <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">

      <!--[if gte IE 9]><!-->
      <script src="<?php echo asset_url(); ?>plugins/jQuery-lib/2.0.3/jquery.min.js"></script>
      <!--<![endif]-->
      <script src="<?php echo asset_url(); ?>plugins/jQuery-lib/2.0.3/jquery.min.js"></script>
      <script src="<?php echo asset_url(); ?>plugins/select2/select2.min.js"></script>

      <style type="text/css">
         .modal.fade.in {
             top: 0%;
         }
      </style>

   </head>
   <body>
      <noscript>
         <div class="global-site-notice noscript">
            <div class="notice-inner">
               <p><strong>JavaScript seems to be disabled in your browser.</strong><br>You must have JavaScript enabled in
                  your browser to utilize the functionality of this website.
               </p>
            </div>
         </div>
      </noscript>
      <div id="wrapper">
         <header id="header" class="navbar">
            <div class="container">
               <a class="navbar-brand" href="#"><span class="logo"><span class="pos-logo-lg">Stock Manager Advance</span><span class="pos-logo-sm">POS</span></span></a>
               <div class="header-nav">
                  <ul class="nav navbar-nav pull-right">
                     <li class="dropdown">
                        <a class="btn account dropdown-toggle" data-toggle="dropdown" href="#">
                           <img alt="" src="<?php echo image_url(); ?>/male.png" class="mini_avatar img-rounded">
                           <div class="user">
                              <span>Welcome! owner</span>
                           </div>
                        </a>
                        <ul class="dropdown-menu pull-right">
                           <li>
                              <a href="#">
                              <i class="fa fa-user"></i> Profile </a>
                           </li>
                           <li>
                              <a href="#">
                              <i class="fa fa-key"></i> Change Password </a>
                           </li>
                           <li class="divider"></li>
                           <li>
                              <a href="#">
                              <i class="fa fa-sign-out"></i> Logout </a>
                           </li>
                        </ul>
                     </li>
                  </ul>
                  <ul class="nav navbar-nav pull-right">
                     <li class="dropdown">
                        <a class="btn bblack" style="cursor: default;"><span id="display_time"></span></a>
                     </li>
                  </ul>
               </div>
            </div>
         </header>
         <div id="content">
            <div class="c1">
               <div class="pos">
                  <div id="pos">
                     <form action="#" data-toggle="validator" role="form" id="pos-sale-form" method="post" accept-charset="utf-8">
                        <input type="hidden" name="token" value="d6c35d2aebf0b3b14b4016c954dd2786" style="display:none;"/>
                        <div id="leftdiv">
                           <div id="printhead">
                              <h4 style="text-transform:uppercase;">Stock Manager Advance</h4>
                              <h5 style="text-transform:uppercase;">Order List</h5>
                              Date 31/12/2015 22:14 
                           </div>
                           <div id="left-top">
                                 <div class="form-group">
                                 <select id="poscustomer" name="poscustomer" class="form-control search-select" data-placeholder="Select customer">
                                 <option value=""></option>
                                 <?php foreach ($get_customer as $value) { ?>
                                   <option value="<?php echo $value->cus_id; ?>"><?php echo $value->cus_name; ?></option>
                                 <?php } ?>
                                 </select>
                                 </div>
                              <div class="no-print">
                                 <div class="form-group">
                                    <select name="poswarehouse" id="poswarehouse" class="form-control search-select" data-placeholder="Select Warehouse">
                                       <option value=""></option>
                                       <?php foreach ($get_warehouse as $value) { ?>
                                         <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?> | <?php echo $value->code; ?></option>
                                       <?php } ?>
                                    </select>
                                 </div>
                                 <div class="form-group" id="ui">
                                 <div class="input-group">
                                 <input type="text" name="add_item" value="" class="form-control pos-tip" id="add_item" data-placement="top" data-trigger="focus" placeholder="Scan/Search product by name/code" title="Please start typing code/name for suggestions or just scan barcode"/>
                                 <div class="input-group-addon" style="padding: 2px 5px;">
                                 </div>
                                 </div>
                                 <div style="clear:both;"></div>
                                 </div>
                              </div>
                           </div>
                           <div id="print">
                              <div id="left-middle">
                                 <div id="product-list" class="ps-container">
                                    <table style="margin-bottom: 0;" id="posTable" class="table items table-striped table-bordered table-condensed table-hover">
                                       <thead>
                                          <tr>
                                             <th width="40%">Product</th>
                                             <th width="15%">Price</th>
                                             <th width="15%">Qty</th>
                                             <th width="20%">Subtotal</th>
                                             <th style="width: 5%; text-align: center;"><i style="opacity:0.5; filter:alpha(opacity=50);" class="fa fa-trash-o"></i></th>
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
                                          <td style="padding: 5px 10px;">Items</td>
                                          <td style="padding: 5px 10px;font-size: 14px; font-weight:bold;" class="text-right">
                                             <span id="titems">00.00</span>
                                          </td>
                                          <td style="padding: 5px 10px;">Total</td>
                                          <td style="padding: 5px 10px;font-size: 14px; font-weight:bold;" class="text-right">
                                             <span id="total">00.00</span>
                                          </td>
                                       </tr>
                                       <tr>

                                          <td style="padding: 5px 10px;">Discount <a id="ppdiscount" href="#">
                                             <i class="fa fa-edit"></i>
                                             </a>
                                          </td>
                                          <td style="padding: 5px 10px;font-weight:bold;" class="text-right">
                                             <span id="tds">0.00</span>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td colspan="2" style="padding: 5px 10px; border-top: 1px solid #666; font-weight:bold; background:#333; color:#FFF;">
                                             Total Payable 
                                          </td>
                                          <td colspan="2" style="padding:5px 10px 5px 10px; font-size: 14px;border-top: 1px solid #666; font-weight:bold; background:#333; color:#FFF;" class="text-right">
                                             <span id="gtotal">00.00</span>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                                 <div class="clearfix"></div>
                                 <div style="text-align:center;" id="botbuttons">
                                    <input type="hidden" value="3" id="biller" name="biller">
                                    <div class="btn-group btn-group-justified">
                                       <div class="btn-group">
                                          <div class="btn-group btn-group-justified">
                                             <div class="btn-group">
                                                <button id="reset" class="btn btn-danger" type="button">Cancel</button>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="btn-group">
                                          <div class="btn-group btn-group-justified">
                                             <div class="btn-group">
                                                <button id="print_bill" class="btn btn-primary" type="button">
                                                <i class="fa fa-print"></i> Bill </button>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="btn-group">
                                          <button id="payment" class="btn btn-success" type="button">
                                          <i class="fa fa-money"></i> Payment </button>
                                       </div>
                                    </div>
                                 </div>
                                 <div style="clear:both; height:5px;"></div>
                                 <div id="num">
                                    <div id="icon"></div>
                                 </div>
                                 <span id="hidesuspend"></span>
                                 <input type="hidden" id="pos_note" value="" name="pos_note">
                                 <input type="hidden" id="staff_note" value="" name="staff_note">
                                 <input type="hidden" id="postax2" value="1" name="order_tax">
                                 <input type="hidden" id="posdiscount" value="" name="discount">
                                 <input type="hidden" style="display: none;" value="cash" id="rpaidby" name="rpaidby">
                                 <input type="hidden" style="display: none;" value="11" id="total_items" name="total_items">
                                 <input type="submit" style="display: none;" value="Submit Sale" id="submit_sale">
                              </div>
                           </div>
                        </div>
                     </form>
                     <div id="cp">
                        <div id="cpinner">
                           <div class="quick-menu">
                              <div id="proContainer">
                                 <div id="ajaxproducts">
                                    <div id="item-list">
                                    <div>
                                    <?php foreach ($category_by_id_1 as $key => $product) { ?>
                                       <button data-container='body' class='btn-prni btn-default product pos-tip' title='<?php echo $product->product_name; ?>' value='<?php echo $product->product_code; ?>' type='button' id='product-<?php echo $product->product_id; ?>'>
                                       <img class='img-rounded' style='width:60px;height:60px;' alt='<?php echo $product->product_name; ?>' src='<?php echo asset_url(); ?>uploads/thumbs/<?php echo $product->product_thumb; ?>'><span><?php echo $product->product_name; ?></span>
                                       </button>
                                    <?php }?>
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
                  <div style="clear:both;"></div>
               </div>
            </div>
         </div>
      </div>
      <div class="rotate btn-cat-con">
         <button type="button" id="open-subcategory" class="btn btn-warning open-subcategory">Subcategories</button>
         <button type="button" id="open-category" class="btn btn-primary open-category">Categories</button>
      </div>
      <div id="category-slider">
         <div id="category-list">
         <?php foreach ($category as $key => $cat) { ?>
            <button id="category-<?php echo $cat->cat_id; ?>" type="button" value='<?php echo $cat->cat_id; ?>' class="btn-prni category">
               <img alt="thumb" src="<?php echo asset_url(); ?>uploads/thumbs/<?php echo $cat->cat_image_thumb; ?>" style='width:60px;height:60px;' class='img-rounded img-thumbnail'/><span><?php echo $cat->cat_name; ?></span>
            </button>
         <?php } ?>
         </div>
      </div>
      <div id="subcategory-slider">
         <div id="subcategory-list">
            <?php foreach ($sub_category as $key => $sub_cat) { ?>
               <button class="btn-prni subcategory" value="<?php echo $sub_cat->sub_cat_id; ?>" type="button" id="subcategory-<?php echo $sub_cat->sub_cat_id; ?>">
                  <img class="img-rounded img-thumbnail" style="width:60px;height:60px;" src="<?php echo asset_url() ?>uploads/no-image.jpg"><span><?php echo $sub_cat->sub_cat_name; ?></span>
               </button>            
            <?php } ?>
         </div>
      </div>
      <div class="modal fade in" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i class="fa fa-2x">&times;</i></span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="payModalLabel">Finalize Sale</h4>
               </div>
               <div class="modal-body" id="payment_content">
                  <div class="row">
                     <div class="col-md-10 col-sm-9">
                        <div class="clearfir"></div>
                        <div id="payments">
                           <div class="well well-sm well_1">
                              <div class="payment">
                                 <div class="row">
                                    <div class="col-sm-5">
                                       <div class="form-group">
                                          <label for="amount_1">Amount</label>
                                          <input name="amount[]" type="text" id="amount_1" class="pa form-control kb-pad amount"/>
                                       </div>
                                    </div>
                                    <div class="col-sm-5 col-sm-offset-1">
                                       <div class="form-group">
                                          <label for="paid_by_1">Paying by</label> 
                                          <select name="paid_by[]" id="paid_by_1" class="form-control paid_by">
                                             <option value="cash">Cash</option>
                                             <option value="CC">Credit Card</option>
                                             <option value="Cheque">Cheque</option>
<!--                                          <option value="gift_card">Gift Card</option>
                                             <option value="other">Other</option>
                                             -->
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-11">
                                       <div class="form-group gc_1" style="display: none;">
                                          <label for="gift_card_no_1">Gift Card No</label> <input name="paying_gift_card_no[]" type="text" id="gift_card_no_1" class="pa form-control kb-pad gift_card_no"/>
                                          <div id="gc_details_1"></div>
                                       </div>
                                       <div class="pcc_1" style="display:none;">
                                          <div class="form-group">
                                             <input type="text" id="swipe_1" class="form-control swipe" placeholder="Name of bank"/>
                                          </div>
                                          <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <input name="cc_no[]" type="text" id="pcc_no_1" class="form-control" placeholder="Credit Card No"/>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <input name="cc_holer[]" type="text" id="pcc_holder_1" class="form-control" placeholder="Holder Name"/>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <select name="cc_type[]" id="pcc_type_1" class="form-control pcc_type" placeholder="Card Type">
                                                      <option value="Visa">Visa</option>
                                                      <option value="MasterCard">MasterCard</option>
                                                      <option value="Amex">Amex</option>
                                                      <option value="Discover">Discover</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="pcheque_1" style="display:none;">
                                          <div class="form-group"><label for="cheque_no_1">Cheque No</label> <input name="cheque_no[]" type="text" id="cheque_no_1" class="form-control cheque_no"/></div>
                                       </div>
                                       <div class="form-group">
                                          <label for="payment_note">Payment Note</label> <textarea name="payment_note[]" id="payment_note_1" class="pa form-control kb-text payment_note"></textarea>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div id="multi-payment"></div>
                        <div class="font16">
                           <table class="table table-bordered table-condensed table-striped" style="margin-bottom: 0;">
                              <tbody>
                                 <tr>
                                    <td width="25%">Total Items</td>
                                    <td width="25%" class="text-right"><span id="item_count">0.00</span></td>
                                    <td width="25%">Total Payable</td>
                                    <td width="25%" class="text-right"><span id="twt">0.00</span></td>
                                 </tr>
                                 <tr>
                                    <td>Total Paying</td>
                                    <td class="text-right"><span id="total_paying">0.00</span></td>
                                    <td>Balance</td>
                                    <td class="text-right"><span id="balance">0.00</span></td>
                                 </tr>
                              </tbody>
                           </table>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                     <div class="col-md-2 col-sm-3 text-center">
                        <span style="font-size: 1.2em; font-weight: bold;">Quick Cash</span>
                        <div class="btn-group btn-group-vertical">
                           <button type="button" class="btn btn-lg btn-info quick-cash" id="quick-payable">0.00
                           </button>
                           <button type="button" class="btn btn-lg btn-warning quick-cash">10</button><button type="button" class="btn btn-lg btn-warning quick-cash">20</button><button type="button" class="btn btn-lg btn-warning quick-cash">50</button><button type="button" class="btn btn-lg btn-warning quick-cash">100</button><button type="button" class="btn btn-lg btn-warning quick-cash">500</button><button type="button" class="btn btn-lg btn-warning quick-cash">1000</button><button type="button" class="btn btn-lg btn-warning quick-cash">5000</button> <button type="button" class="btn btn-lg btn-danger" id="clear-cash-notes">Clear</button>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button class="btn btn-block btn-lg btn-primary" id="submit-sale">Submit</button>
               </div>
            </div>
         </div>
      </div>
      <div class="modal" id="prModal" tabindex="-1" role="dialog" aria-labelledby="prModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i class="fa fa-2x">&times;</i></span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="prModalLabel"></h4>
               </div>
               <div id="pr_popover_content" class="modal-body">
                  <form class="form-horizontal" role="form">
                     <div class="form-group">
                        <label class="col-sm-4 control-label">Product Tax</label>
                        <div class="col-sm-8">
                           <select name="ptax" id="ptax" class="form-control pos-input-tip" style="width:100%;">
                              <option value="" selected="selected"></option>
                              <option value="1">No Tax</option>
                              <option value="2">VAT @10%</option>
                              <option value="3">GST @6%</option>
                              <option value="4">VAT @20%</option>
                              <option value="5">GST @0%</option>
                           </select>
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="pserial" class="col-sm-4 control-label">Serial No</label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control kb-text" id="pserial">
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="pquantity" class="col-sm-4 control-label">Quantity</label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control kb-pad" id="pquantity">
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="poption" class="col-sm-4 control-label">Product Option</label>
                        <div class="col-sm-8">
                           <div id="poptions-div"></div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="pdiscount" class="col-sm-4 control-label">Product Discount</label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control kb-pad" id="pdiscount">
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="pprice" class="col-sm-4 control-label">Unit Price</label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control kb-pad" id="pprice">
                        </div>
                     </div>
                     <table class="table table-bordered table-striped">
                        <tr>
                           <th style="width:25%;">Net Unit Price</th>
                           <th style="width:25%;"><span id="net_price"></span></th>
                           <th style="width:25%;">Product Tax</th>
                           <th style="width:25%;"><span id="pro_tax"></span></th>
                        </tr>
                     </table>
                     <input type="hidden" id="punit_price" value=""/>
                     <input type="hidden" id="old_tax" value=""/>
                     <input type="hidden" id="old_qty" value=""/>
                     <input type="hidden" id="old_price" value=""/>
                     <input type="hidden" id="row_id" value=""/>
                  </form>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="editItem">Submit</button>
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade in" id="gcModal" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i></button>
                  <h4 class="modal-title" id="myModalLabel">Sell Gift Card</h4>
               </div>
               <div class="modal-body">
                  <p>Please fill in the information below. The field labels marked with * are required input fields.</p>
                  <div class="alert alert-danger gcerror-con" style="display: none;">
                     <button data-dismiss="alert" class="close" type="button">×</button>
                     <span id="gcerror"></span>
                  </div>
                  <div class="form-group">
                     <label for="gccard_no">Card No</label> *
                     <div class="input-group">
                        <input type="text" name="gccard_no" value="" class="form-control" id="gccard_no"/>
                        <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                           <a href="#" id="genNo"><i class="fa fa-cogs"></i></a>
                        </div>
                     </div>
                  </div>
                  <input type="hidden" name="gcname" value="Gift Card" id="gcname"/>
                  <div class="form-group">
                     <label for="gcvalue">Value</label> *
                     <input type="text" name="gcvalue" value="" class="form-control" id="gcvalue"/>
                  </div>
                  <div class="form-group">
                     <label for="gcprice">Price</label> *
                     <input type="text" name="gcprice" value="" class="form-control" id="gcprice"/>
                  </div>
                  <div class="form-group">
                     <label for="gccustomer">Customer</label> <input type="text" name="gccustomer" value="" class="form-control" id="gccustomer"/>
                  </div>
                  <div class="form-group">
                     <label for="gcexpiry">Expiry Date</label> <input type="text" name="gcexpiry" value="" class="form-control date" id="gcexpiry"/>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" id="addGiftCard" class="btn btn-primary">Sell Gift Card</button>
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade in" id="mModal" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i class="fa fa-2x">&times;</i></span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="mModalLabel">Add Product Manually</h4>
               </div>
               <div class="modal-body" id="pr_popover_content">
                  <form class="form-horizontal" role="form">
                     <div class="form-group">
                        <label for="mcode" class="col-sm-4 control-label">Product Code *</label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control kb-text" id="mcode">
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="mname" class="col-sm-4 control-label">Product Name *</label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control kb-text" id="mname">
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="mtax" class="col-sm-4 control-label">Product Tax *</label>
                        <div class="col-sm-8">
                           <select name="mtax" id="mtax" class="form-control pos-input-tip" style="width:100%;">
                              <option value="" selected="selected"></option>
                              <option value="1">No Tax</option>
                              <option value="2">VAT @10%</option>
                              <option value="3">GST @6%</option>
                              <option value="4">VAT @20%</option>
                              <option value="5">GST @0%</option>
                           </select>
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="mquantity" class="col-sm-4 control-label">Quantity *</label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control kb-pad" id="mquantity">
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="mdiscount" class="col-sm-4 control-label">Product Discount</label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control kb-pad" id="mdiscount">
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="mprice" class="col-sm-4 control-label">Unit Price *</label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control kb-pad" id="mprice">
                        </div>
                     </div>
                     <table class="table table-bordered table-striped">
                        <tr>
                           <th style="width:25%;">Net Unit Price</th>
                           <th style="width:25%;"><span id="mnet_price"></span></th>
                           <th style="width:25%;">Product Tax</th>
                           <th style="width:25%;"><span id="mpro_tax"></span></th>
                        </tr>
                     </table>
                  </form>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="addItemManually">Submit</button>
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade in" id="sckModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i class="fa fa-2x">&times;</i></span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="mModalLabel">Shortcut Keys</h4>
               </div>
               <div class="modal-body" id="pr_popover_content">
                  <table class="table table-bordered table-striped table-condensed table-hover" style="margin-bottom: 0px;">
                     <thead>
                        <tr>
                           <th>Shortcut Keys</th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td>Ctrl+F3</td>
                           <td>Focus Add Item Input</td>
                        </tr>
                        <tr>
                           <td>Ctrl+Shift+M</td>
                           <td>Add Manual Item to Sale</td>
                        </tr>
                        <tr>
                           <td>Ctrl+Shift+C</td>
                           <td>Customer Input</td>
                        </tr>
                        <tr>
                           <td>Ctrl+Shift+A</td>
                           <td>Add Customer</td>
                        </tr>
                        <tr>
                           <td>Ctrl+F11</td>
                           <td>Toggle Categories Slider</td>
                        </tr>
                        <tr>
                           <td>Ctrl+F12</td>
                           <td>Toggle Subcategories Slider</td>
                        </tr>
                        <tr>
                           <td>F4</td>
                           <td>Cancel Sale</td>
                        </tr>
                        <tr>
                           <td>F7</td>
                           <td>Suspend Sale</td>
                        </tr>
                        <tr>
                           <td>F9</td>
                           <td>Print items list</td>
                        </tr>
                        <tr>
                           <td>F8</td>
                           <td>Finalize Sale</td>
                        </tr>
                        <tr>
                           <td>Ctrl+F1</td>
                           <td>Today's Sale</td>
                        </tr>
                        <tr>
                           <td>Ctrl+F2</td>
                           <td>Open Suspended Sales</td>
                        </tr>
                        <tr>
                           <td>Ctrl+F10</td>
                           <td>Close Register</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade in" id="dsModal" tabindex="-1" role="dialog" aria-labelledby="dsModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-sm">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i></button>
                  <h4 class="modal-title" id="dsModalLabel">Edit Order Discount</h4>
               </div>
               <div class="modal-body">
                  <div class="form-group">
                     <label for="order_discount_input">Order Discount</label> <input type="text" name="order_discount_input" value="" class="form-control kb-pad" id="order_discount_input"/>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" id="updateOrderDiscount" class="btn btn-primary">Update</button>
               </div>
            </div>
         </div>
      </div>

      <div class="modal fade in" id="txModal" tabindex="-1" role="dialog" aria-labelledby="txModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-sm">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i></button>
                  <h4 class="modal-title" id="txModalLabel">Edit Order Tax</h4>
               </div>
               <div class="modal-body">
                  <div class="form-group">
                     <label for="order_tax_input">Order Tax</label> 
                     <select name="order_tax_input" id="order_tax_input" class="form-control pos-input-tip" style="width:100%;">
                        <option value="" selected="selected"></option>
                        <option value="1">No Tax</option>
                        <option value="2">VAT @10%</option>
                        <option value="3">GST @6%</option>
                        <option value="4">VAT @20%</option>
                        <option value="5">GST @0%</option>
                     </select>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" id="updateOrderTax" class="btn btn-primary">Update</button>
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade in" id="susModal" tabindex="-1" role="dialog" aria-labelledby="susModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i></button>
                  <h4 class="modal-title" id="susModalLabel">Suspend Sale</h4>
               </div>
               <div class="modal-body">
                  <p>Please type reference note and submit to suspend this sale</p>
                  <div class="form-group">
                     <label for="reference_note">Reference Note</label> <input type="text" name="reference_note" value="" class="form-control kb-text" id="reference_note"/>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" id="suspend_sale" class="btn btn-primary">Submit</button>
               </div>
            </div>
         </div>
      </div>
      <div id="order_tbl">
         <span id="order_span"></span>
         <table id="order-table" class="prT table table-striped" style="margin-bottom:0;" width="100%"></table>
      </div>
      <div id="bill_tbl">
         <span id="bill_span"></span>
         <table id="bill-table" width="100%" class="prT table table-striped" style="margin-bottom:0;"></table>
         <table id="bill-total-table" class="prT table" style="margin-bottom:0;" width="100%"></table>
      </div>
      <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
      <div class="modal fade in" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true"></div>
      <div id="modal-loading" style="display: none;">
         <div class="blackbg"></div>
         <div class="loader"></div>
      </div>
      <script type="text/javascript">

         var site = {"base_url":"http:\/\/localhost/inventry_pos\/","settings":{"logo":"logo2.png","logo2":"logo3.png","site_name":"Stock Manager Advance","language":"english","default_warehouse":"1","accounting_method":"0","default_currency":"USD","default_tax_rate":"1","rows_per_page":"10","version":"3.0.1.20","default_tax_rate2":"1","dateformat":"5","sales_prefix":"SALE","quote_prefix":"QUOTE","purchase_prefix":"PO","transfer_prefix":"TR","delivery_prefix":"DO","payment_prefix":"IPAY","return_prefix":"RETURNSL","expense_prefix":null,"item_addition":"0","theme":"default","product_serial":"1","default_discount":"1","product_discount":"1","discount_method":"1","tax1":"1","tax2":"1","overselling":"0","iwidth":"800","iheight":"800","twidth":"60","theight":"60","watermark":"0","smtp_host":"pop.gmail.com","bc_fix":"4","auto_detect_barcode":"1","captcha":"0","reference_format":"2","racks":"1","attributes":"1","product_expiry":"0","decimals":"2","decimals_sep":".","thousands_sep":",","invoice_view":"0","default_biller":null,"rtl":"0","each_spent":null,"ca_point":null,"each_sale":null,"sa_point":null,"sac":"0","qty_decimals":"2","display_all_products":"0"},"dateFormats":{"js_sdate":"dd\/mm\/yyyy","php_sdate":"d\/m\/Y","mysq_sdate":"%d\/%m\/%Y","js_ldate":"dd\/mm\/yyyy hh:ii","php_ldate":"d\/m\/Y H:i","mysql_ldate":"%d\/%m\/%Y %H:%i"}}, pos_settings = {"pos_id":"1","cat_limit":"22","pro_limit":"20","default_category":"1","default_customer":"1","default_biller":"3","display_time":"1","cf_title1":"GST Reg","cf_title2":"VAT Reg","cf_value1":"123456789","cf_value2":"987654321","receipt_printer":"BIXOLON SRP-350II","cash_drawer_codes":"x1C","focus_add_item":"Ctrl+F3","add_manual_product":"Ctrl+Shift+M","customer_selection":"Ctrl+Shift+C","add_customer":"Ctrl+Shift+A","toggle_category_slider":"Ctrl+F11","toggle_subcategory_slider":"Ctrl+F12","cancel_sale":"F4","suspend_sale":"F7","print_items_list":"F9","finalize_sale":"F8","today_sale":"Ctrl+F1","open_hold_bills":"Ctrl+F2","close_register":"Ctrl+F10","keyboard":"1","pos_printers":"BIXOLON SRP-350II, BIXOLON SRP-350II","java_applet":"0","product_button_color":"default","tooltips":"1","paypal_pro":"0","stripe":"0","rounding":"0","char_per_line":"42","pin_code":null};
         var lang = {unexpected_value: 'Unexpected value provided!', select_above: 'Please select above first', r_u_sure: 'Are you sure?'};
      

          $(document).ready(function () {
               widthFunctions();
               $(".pos-tip").tooltip();
         $("#poswarehouse").select2();
         $("#poscustomer").select2();
          });

          function widthFunctions(e) {
              var wh = $(window).height(),
                  lth = $('#left-top').height(),
                  lbh = $('#left-bottom').height();

               $('#item-list').css("height", wh - 140);
               $('#item-list').css("min-height", 515);

              $('#left-middle').css("height", wh - lth - lbh - 100);
              $('#left-middle').css("min-height", 325);

              $('#product-list').css("height", wh - lth - lbh - 105);
              $('#product-list').css("min-height", 325);
              $('#product-list').css("overflow","scroll");
          }

          $(window).bind("resize", widthFunctions);


          $(document).ready( function() {
                 $("#add_item").autocomplete({
                     source: function (request, response) {
                         if (!$('#poscustomer').val()) {
                             $('#add_item').val('').removeClass('ui-autocomplete-loading');
                             bootbox.alert('Please select above first');
                             //response('');
                             $('#add_item').focus();
                             return false;
                         }
                         $.ajax({
                             type: 'get',
                             url: 'pos/getProductDataByCode',
                             dataType: "json",
                             data: {
                                 code: request.term,
                                 warehouse_id: $("#poswarehouse").val(),
                                 customer_id: $("#poscustomer").val()
                             },
                             success: function (data) {
                                 response(data);
                             }
                         });
                     },
                     minLength: 1,
                     autoFocus: false,
                     delay: 200,
                     response: function (event, ui) {
                         if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                             //audio_error.play();
                             bootbox.alert('No matching result found! Product might be out of stock in the selected warehouse.', function () {
                                 $('#add_item').focus();
                                 $('#add_item').val('').removeClass('ui-autocomplete-loading');
                             });

                             $(this).val('');
                             $('#add_item').val('').removeClass('ui-autocomplete-loading');
                         }
                         else if (ui.content.length == 1 && ui.content[0].id != 0) {
                             ui.item = ui.content[0];
                             $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                             $(this).autocomplete('close');
                         }
                         else if (ui.content.length == 1 && ui.content[0].id == 0) {
                             //audio_error.play();
                             bootbox.alert('No matching result found! Product might be out of stock in the selected warehouse.', function () {
                                 $('#add_item').focus();
                                 $('#add_item').val('').removeClass('ui-autocomplete-loading');
                             });
                             $(this).val('');
                             $('#add_item').val('').removeClass('ui-autocomplete-loading');

                         }
                     },
                     select: function (event, ui) {
                         event.preventDefault();
                         if (ui.item.id !== 0) {
                             var row = add_invoice_item(ui.item);
                             if (row)
                                 $(this).val('');
                                 $('#add_item').val('').removeClass('ui-autocomplete-loading');

                         } else {
                             //audio_error.play();
                             bootbox.alert('No matching result found! Product might be out of stock in the selected warehouse.');
                         }
                     }
                 });

                 $('#add_item').bind('keypress', function (e) {
                     if (e.keyCode == 13) {
                         e.preventDefault();
                         $(this).autocomplete("search");
                     }
                 });
          });

      </script>
      <script type="text/javascript">
        var product_variant = 0, shipping = 0, p_page = 0, per_page = 0, tcp = "8",cat_id = "8", ocat_id = "1", sub_cat_id = 0, osub_cat_id,count = 1, an = 1, DT = 1;

        $(document).on('click', '.category', function () {
            if (cat_id != $(this).val()) {
                $('#modal-loading').show();
                $('#open-category').click();
                cat_id = $(this).val();
                $.ajax({
                    type: "get",
                    url: "pos/ajaxcategorydata",
                    data: {category_id: cat_id},
                    dataType: "json",
                    success: function (data) {
                        $('#item-list').empty();
                        var newPrs = $('<div></div>');
                        newPrs.html(data.products);
                        newPrs.appendTo("#item-list");
                        $('#subcategory-list').empty();
                        var newScs = $('<div></div>');
                        newScs.html(data.subcategories);
                        newScs.appendTo("#subcategory-list");
                        tcp = data.tcp;
                    }
                }).done(function () {
                    p_page = 'n';
                    $('#category-' + cat_id).addClass('active');
                    $('#category-' + ocat_id).removeClass('active');
                    ocat_id = cat_id;
                  $('#modal-loading').hide();
                  $(".pos-tip").tooltip();
                });
            }
        });

        $('#category-' + cat_id).addClass('active');

        $(document).on('click', '.subcategory', function () {
            $('#modal-loading').show();
            if (sub_cat_id != $(this).val()) {
                $('#open-subcategory').click();
                sub_cat_id = $(this).val();
                $.ajax({
                    type: "get",
                    url: "pos/ajaxproducts",
                    data: {category_id: cat_id, subcategory_id: sub_cat_id, per_page: p_page},
                    dataType: "html",
                    success: function (data) {
                        $('#item-list').empty();
                        var newPrs = $('<div></div>');
                        newPrs.html(data);
                        newPrs.appendTo("#item-list");
                    }
                }).done(function () {
                    p_page = 'n';
                    $('#subcategory-' + sub_cat_id).addClass('active');
                    $('#subcategory-' + osub_cat_id).removeClass('active');
                    osub_cat_id = sub_cat_id; 
                  $('#modal-loading').hide();
                 $(".pos-tip").tooltip();
                });
            }
        });

          $(document).on('click', '.product', function (e) {
            $('#modal-loading').show();
            code = $(this).val(),
                wh = $('#poswarehouse').val(),
                cu = $('#poscustomer').val();
            $.ajax({
                type: "get",
                url: "pos/getProductDataByCode",
                data: {code: code, warehouse_id: wh, customer_id: cu},
                dataType: "json",
                success: function (data) {
                    e.preventDefault();
                    if (data !== null) {
                         //data.item = data.content[0];
                         add_invoice_item(data[0]);
                        $('#modal-loading').hide();
                    } else {
                        //audio_error.play();
                        bootbox.alert('No matching result found! Product might be out of stock in the selected warehouse.');
                        $('#modal-loading').hide();
                    }
                }
            });
          });

          $(document).on('click','.posdel', function (a) {

                  var row = $(this).closest('tr');
                  row.remove();
                      grand_total();

          });

        // This below code is pos payment submit ..
        $(document).on('click', '#submit-sale', function () {

            var total_paid = $("input#amount_1").val();
            var grand_total= remove_comma($("span#twt").text());

            if (total_paid == 0 || total_paid < grand_total) {
                bootbox.confirm("Paid amount is less than the payable amount. Please press OK to submit the sale.", function (res) {
                    if (res == true) {
                        //$('#pos_note').val(localStorage.getItem('posnote'));
                       // $('#staff_note').val(localStorage.getItem('staffnote'));
                        $('#submit-sale').text('Loading...').attr('disabled', true);
                        //$('#pos-sale-form').submit();
                        alert(1);
                    }
                });
                return false;
            } else {
                $(this).text('Loading...').attr('disabled', true);
               // $('#pos-sale-form').submit();
               alert(45);
            }
        });

        </script>
      <script src="<?php echo asset_url(); ?>plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
      <script src="<?php echo asset_url(); ?>plugins/bootstrap/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery-ui.min.js"></script>
      <script src="<?php echo asset_url(); ?>plugins/jquery-validation/dist/jquery.validate.min.js"></script>
      <script type="text/javascript" src="<?php echo asset_url(); ?>plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
      <script type="text/javascript" src="<?php echo asset_url(); ?>plugins/DataTables/media/js/DT_bootstrap.js"></script>
      <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>
      <script type="text/javascript" src="<?php echo asset_url();?>js/pos.ajax.js"></script>
      <script src="<?php echo asset_url(); ?>js/ui-modals.js"></script>
      <script src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
      <script src="<?php echo asset_url(); ?>js/accounting.js"></script>
      <div id="ajaxCall"><i class="fa fa-spinner fa-pulse"></i></div>
   </body>
</html>