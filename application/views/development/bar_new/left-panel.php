<style type="text/css">
    .item_btn_1 {
        font-weight: bold;
        font-size: 14px;
        height: 110px;
        min-width: 160px;
        max-width: 180px;
        position: relative;
        margin: 5px;
    }

    .label-item {
        background-color: rgba(255, 255, 255, 0.95);
        /* text-align:justify;  */
        font-size: 16px;
        max-height: 67px;
        position: absolute;
        right: 0;
        width: 100%;
    }

    .label-item {
        background-color: rgba(255, 255, 255, 0.95);
        /* text-align: justify; */
        font-size: 13px;
        max-height: 67px;
        position: absolute;
        right: 0;
        width: 100%;
    }
</style>

<div id="content" style="background-color:#FFF">
    <div class="c1">
        <div class="pos">
            <div id="pos">
                <form action="#" data-toggle="validator" role="form" id="pos-sale-form" name="pos-sale-form" method="post" accept-charset="utf-8">
                    <input type="hidden" name="token" value="d6c35d2aebf0b3b14b4016c954dd2786" style="display:none;" />
                    <input type="hidden" name="kitchen_note" id="kitchen_note" value="" />
                    <div id="leftdiv" class="ui-widget quick-menu">
                        <div id="printhead">
                            <h4 style="text-transform:uppercase;">Stock Manager Advance</h4>
                            <h5 style="text-transform:uppercase;">Order List</h5>
                            Date 31/12/2015 22:14
                        </div>
                        <div id="left-top" class="quick-menu">
                            <div class="no-print">
                                <div style="display:none" id="input_panel" class="form-group">
                                    <select name="poswarehouse" id="poswarehouse" class="search-select" data-placeholder="Select Warehouse">
                                        <option value="">-select-</option>
                                        <?php foreach ($get_warehouse as $value) { ?>
                                            <option value="<?php echo $value->id; ?>" <?php if ($this->session->userdata('ss_warehouse_id') == $value->id) echo 'selected' ?>><?php echo $value->name; ?> | <?php echo $value->code; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <!--<div class="form-group"></div>-->
                                <?php
                                echo ($customer_id > 1) ? '<div class="form-group"><input class="form-control" type="text" readonly id="cus_phone" name="cus_phone" value="' . $cus_phone . '" /></div>' : '<div class="form-group"><input  placeholder="Customer phone" class="form-control" type="text" id="cus_phone" name="cus_phone" value="" /><input placeholder="Customer name" class="form-control" type="text" id="cus_name" name="cus_name" value="" /></div>';
                                /*
                ?>
                <div class="form-group" style="background-color:#FFF">
                  <div class="input-group">
                    <select style="margin-top:1px" id="poscustomer" name="poscustomer" class="search-select" data-placeholder="Select customer">
                      <option value="">-</option>
                      <?php foreach ($get_customer as $value) { ?>
                      <?php $sel = '';
						  if($value->cus_id == $customer_id )$sel='selected';
						  else if($value->cus_id == 1) $sel='selected'; 
						 ?>
                      <option <?php echo $sel; ?> value="<?php echo $value->cus_id; ?>"><?php echo $value->cus_name.'-'.$value->cus_phone; ?></option>
                      <?php } ?>
                    </select>
                    <input name="base_url" type="hidden" id="base_url" value="<?php echo base_url();?>">
                    <input type="hidden" id="customer_mobile" value="" />
                    <div class="input-group-addon pos-tip" style="padding: 2px 8px; border-left: 0; height:34px" title="Add Customer"> <a href="#" id="modal_ajax_customers_btn" class="external" tabindex="-1"> <i class="fa fa-plus-circle" id="addIcon" style="font-size: 1.2em;"></i> </a> </div>
                  </div>
                </div>
                <?php
                */
                                //if($sale_id)if($sale_details[0]) print_r($sale_details[0]);
                                //				if($sale_id)if($sale_details[0]['dine_type'] == 2) echo 'checked="checked2"';
                                //				if($sale_id)if($sale_details[0]['dine_type'] == 3) echo 'checked="checked3"';
                                ?>
                                <div class="form-group" style="background-color:#FFF;">
                                    <div class="input-group cb_list">
                                        <div id="div_1" class="input-group-addon" style="cursor:pointer; padding: 0px 8px; border-left: solid;border-right: none; width:10%;" title="Dine In">
                                            <label style="margin: 6px 0px 6px 0px">
                                                <input id="cb_1" name="delivery_status" class="red ds" <?php if ($sale_id) {
                                                                                                            if ($sale_details[0]['dine_type'] == 1) echo 'checked="checked"';
                                                                                                        } ?> type="radio" style="display:none" value="1" />
                                            </label>
                                        </div>
                                        <div id="div_1_2" class="input-group-addon" style="cursor:pointer; padding: 0px 8px; border-left: 0; width:10%">
                                            <label style="cursor:pointer" for="cb_1"> <i class="fa fa-spoon"></i><i class="fa fa-circle-o"></i> Dine In </label>
                                        </div>
                                        <div id="div_2" class="input-group-addon" style="cursor:pointer; padding: 0px 8px; border-left: solid;border-right: none; width:10% " title="Take Away">
                                            <label style="margin: 6px 0px 6px 0px">
                                                <input id="cb_2" name="delivery_status" class="green ds" <?php if ($sale_id) {
                                                                                                                if ($sale_details[0]['dine_type'] == 2) echo 'checked="checked"';
                                                                                                            } else echo 'checked="checked"'; ?> type="radio" style="display:none" value="2" />
                                            </label>
                                        </div>
                                        <div id="div_2_2" class="input-group-addon" style="cursor:pointer; padding: 0px 8px; border-left: 0;">
                                            <label style="cursor:pointer" for="cb_2"> <i class="fa fa-money"></i>Take Away </label>
                                        </div>
                                        <div id="div_3" class="input-group-addon" style="cursor:pointer; padding: 0px 8px; border-left: solid;border-right: none;  width:10%" title="Delivary">
                                            <label style="margin: 6px 0px 6px 0px">
                                                <input id="cb_3" name="delivery_status" class="orange ds" <?php if ($sale_id) if ($sale_details[0]['dine_type'] == 3) echo 'checked="checked"'; ?> type="radio" style="display:none" value="3" />
                                            </label>
                                        </div>
                                        <div id="div_3_2" class="input-group-addon" style="cursor:pointer; padding: 0px 0px; border-left: 0; width:100%">
                                            <label style="cursor:pointer" for="cb_3"> <i class="fa fa-truck"></i> Delivery </label>
                                        </div>
                                    </div>
                                    <?php if ($order_place == 'sss') { ?>
                                        <input type="hidden" id="floor_id" name="floor_id" value="1">
                                        <div class="input-group cb_list">
                                            <div id="poss_1" class="input-group-addon" style="cursor:pointer; padding: 0px 8px; border-left: solid;border-right: none;" title="">
                                                <label style="margin: 6px 0px 6px 0px">
                                                    <input id="poss_1" name="division_id" class="divi_1" <?php if ($sale_id) {
                                                                                                                if ($sale_details[0]['division_id'] == 1) echo 'checked="checked"';
                                                                                                            } else echo 'checked="checked"'; ?> type="radio" style="" value="1" />
                                                </label>
                                            </div>
                                            <div id="pos_1_2" class="col-xs-1 input-group-addon" style="cursor:pointer; padding: 0px 8px; border: none;">
                                                <label style="cursor:pointer;text-align:left" for="poss_1">
                                                    <!--<i class="fa fa-spoon"></i><i class="fa fa-circle-o"></i>--> MAIN BAR
                                                </label>
                                            </div>
                                            <div id="pos_2" class="input-group-addon" style="cursor:pointer; padding: 0px 8px; border-left: solid;border-right: none; ">
                                                <label style="margin: 6px 0px 6px 0px">
                                                    <input id="poss_2" name="division_id" class="divi_2" <?php if ($sale_id) {
                                                                                                                if ($sale_details[0]['division_id'] == 2) echo 'checked="checked"';
                                                                                                            }  ?> type="radio" style="display:none" value="2" />
                                                </label>
                                            </div>
                                            <div id="pos_2_2" class="col-xs-1 input-group-addon" style="cursor:pointer; padding: 0px 8px; border: none;border-top: 0;">
                                                <label style="cursor:pointer" for="poss_2">
                                                    <!--<i class="fa fa-money"></i>-->BLUE LOUNGE
                                                </label>
                                            </div>
                                        </div>
                                    <?php }
                                    if ('rest' == 'rest') { ?>
                                        <input type="hidden" id="floor_id" name="floor_id" value="2">
                                    <?php } ?>
                                    <div class="form-group" style="background-color:#FFF;">
                                        <div class="input-group" style="width:100%;">
                                            <select style="margin-top:1px" id="table_id" name="table_id" class="search-select" data-placeholder="Select table">
                                                <option value="">SELECT TABLE</option>
                                                <?php
                                                $start = 1;
                                                if ($order_place == 'bar') $start = 1;
                                                for ($i = $start; $i < 51; $i++) {
                                                    //if($i == 13) continue;
                                                    if ($sale_details[0]['dine_type'] == 3) {
                                                        echo '$(\'.hide_me\').css(\'visibility\',\'visible\');';
                                                        /*$('#posshipping').val();*/
                                                    }
                                                ?>
                                                    <option class="opt_<?php echo $i ?>" <?php if (isset($sale_details[0]['table_id']) == $i) if ($sale_details[0]['dine_type'] == 1) echo 'selected' ?> value="<?php echo $i ?>"><?php echo 'Table ' . $i ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="ui">
                                    <div class="input-group">
                                        <input type="text" name="add_item" value="" class="form-control pos-tip" id="add_item" data-placement="top" data-trigger="focus" style="background-color:#FFF" />
                                        <!--title="Please start typing code/name for suggestions"-->
                                        <div class="input-group-addon" style="padding: 2px 8px; border-left: 0;"><i class="fa fa-search" style="font-size: 1em;"></i> </div>
                                    </div>
                                    <div style="clear:both;"></div>
                                </div>
                            </div>
                        </div>
                        <div id="print" class="no-print">
                            <div id="left-middle">
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
                                        <tr>
                                            <td style="padding: 5px 10px;border-top: 1px solid #DDD;"><label for="ppdiscount">Discount</label> <a id="ppdiscount" class="btn btn-lg" href="#"><i class="fa fa-dollar"></i> </a>
                                                <br><label for="add_note">Note</label> <a href="#" class="btn btn-lg" id="add_note"><i class="fa fa-edit"></i></a>
                                            </td>
                                            <td style="padding: 5px 10px;font-size: 14px; font-weight:bold; border-top: 1px solid #DDD;" class="text-right"><span id="tds">0.00</span>
                                                <input type="checkbox" name="is_print" value="1" id="is_print" style="height:25px; width:25px;" checked>
                                            </td>
                                            <td style="padding: 5px 10px;border-top: 1px solid #DDD;"><span class="hide_me"> Delivery &nbsp;<a href="#" id="pshipping"> <i class="fa fa-plus-square"></i> </a></span></td>
                                            <td style="padding: 5px 10px;font-size: 14px; font-weight:bold; border-top: 1px solid #DDD;" class="text-right"><span class="hide_me"><span id="tship">0.00</span></span></td>
                                        </tr>
                                        <tr>
                                            <td>Total: <span class="" id="gtotal" style=" font-size:25px">0.00</span></td>
                                            <td colspan="3">Balance : <span id="cash_balance" style=" font-size:25px"></span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="1" style="padding: 5px 10px; border-top: 1px solid #666; font-weight:bold; background:#333; color:#FFF;"> Cash :
                                                <input type="text" name="pay_cash" value="0" class="form-control" id="pay_cash" style="background-color:#FFF; height: 60px; font-size: 2.5em; width: 208px; text-align: right;" onkeyup="grand_total_cal()" onClick=this.select()>
                                            </td>
                                            <td colspan="3" style="padding: 5px 10px; border-top: 1px solid #666; font-weight:bold; background:#333; color:#FFF;"> C.C :
                                                <input type="text" name="pay_cc" value="0" class="form-control" id="pay_cc" style="background-color:#FFF; height: 60px; font-size: 2.5em; width: 208px; text-align: right;" onkeyup="grand_total_cal()" onClick=this.select()>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="hidden" value="3" id="biller" name="biller">
                                <div class="clearfix"></div>
                                <div id="botbuttons" class="col-xs-12 text-center">
                                    <div class="row">
                                        <div class="col-xs-12" style="padding: 0;">
                                            <div class="col-xs-12" style="padding: 0;">
                                                <button type="button" class="btn btn-primary btn-block" id="save" style="height:80px;" tabindex="-1"> <i class="fa fa-hand-paper-o" style="margin-right: 5px;"></i>SAVE INVOICE</button>
                                            </div>
                                            <div class="col-xs-6" style="padding: 0;">
                                                <button type="button" class="btn btn-danger btn-block btn-flat cancel" id="reset" tabindex="-1" style="height:55px;"> Cancel </button>
                                            </div>
                                            <div class="col-xs-6" style="padding: 0;">
                                                <button type="button" class="btn btn-success btn-block" id="payment" style="height:55px;" tabindex="-1"> <i class="fa fa-money" style="margin-right: 5px;"></i>Payment Type</button>
                                            </div>

                                            <!--
                      <div class="col-xs-6" style="padding: 0;">
                        <button type="button" class="btn btn-success btn-block" id="" style="height:55px;" tabindex="-1"> <i class="fa fa-money" style="margin-right: 5px;"></i>Payment </button>
                      </div>-->
                                            <div class="col-xs-6" id="print_button_container"></div>
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
                                    </div><?php */ ?>
                                </div>
                                <div style="clear:both; height:5px;"></div>
                                <div id="num">
                                    <div id="icon"></div>
                                </div>
                                <span id="hidesuspend"></span>
                                <?php if ($sale_id) { ?>
                                    <input type="hidden" name="sale_id" id="sale_id" value="<?php echo $sale_id; ?>">
                                    <input type="hidden" name="sale_reference_no" id="sale_reference_no" value="<?php echo $sale_details[0]['sale_reference_no']; ?>">
                                <?php } ?>
                                <input type="hidden" name="posshipping" id="posshipping" value="<?php if ($sale_id) {
                                                                                                    if ($sale_details[0]['sale_shipping']) echo $sale_details[0]['sale_shipping'];
                                                                                                } else echo '0.00'; ?>">
                                <input type="hidden" name="shipping_address" id="shipping_address" value="<?php if ($sale_id) {
                                                                                                                if ($sale_details[0]['shipping_address']) echo $sale_details[0]['shipping_address'];
                                                                                                            } else echo ''; ?>">
                                <input type="hidden" name="rowCount" id="rowCount" value="0">
                                <!--keyboard input-->
                                <input type="hidden" id="id-name" value="" />
                                <!--end keyboard input-->
                                <input type="hidden" name="sale_datetime" id="sale_datetime" value="0">
                                <input type="hidden" name="discount" id="posdiscount" value="0">
                                <input type="hidden" name="pos_discount_input1" id="pos_discount_input1" value="0">
                                <input type="hidden" name="pay_amount" id="pay_amount" value="" />
                                <input type="hidden" name="balance_amount" id="balance_amount_1" value="" />
                                <input type="hidden" name="grand_total" id="grand_total" value="">
                                <input type="hidden" name="paid_by" id="paid_by_val_1" value="cash" />
                                <input type="hidden" name="cc_name" id="cc_name" value="" />
                                <input type="hidden" name="cc_no" id="cc_no" value="" />
                                <input type="hidden" name="pcc_holder" id="pcc_holder" value="" />
                                <input type="hidden" name="pcc_type" id="pcc_type" value="visa" />
                                <input type="hidden" name="payment_note" id="pos_note" value="" />
                                <input type="hidden" name="extra_charges" id="extra_charges" value="" />
                                <input type="hidden" name="extra_charges_amount" id="extra_charges_amount" value="" />
                            </div>
                        </div>
                    </div>
                </form>
                <?php /*?><div id="bill_tbl"><span id="bill_span"></span>
          <table id="bill-table" width="100%" class="prT table table-striped" style="margin-bottom:0;">
          </table>
          <table id="bill-total-table" class="prT table" style="margin-bottom:0;" width="100%">
          </table>
          <span id="bill_footer"></span> </div><?php */ ?>
                <div id="cpinner" style="background-color:#f4f4f4;margin-left:10px;display: flex;flex-direction: column;justify-content: space-between;">
                    <!-- Tab Start -->
                    <div style="display: flex;flex-direction: column;">
                        <div id="cat_label_containet">
                            <ul class="nav nav-tabs navbar-nav tab-green no-print" id="myTab3" style="margin:0px 0px 10px 10px;padding:0px;overflow: scroll;">
                                <li <?php echo 'class=active' ?>> <a data-toggle="tab" href="#cat_<?php echo 1000; ?>" style="background:rgba(255, 255, 255, 0.7); font-size:20px; display:none">Featured </a>
                                    <?php foreach ($category as $key => $cat) { ?>
                                <li style="" <?php if ($cat->cat_id == 3) echo 'class=active' ?>> <a data-toggle="tab" href="#cat_<?php echo $cat->cat_id; ?>" style="background:rgba(255, 255, 255, 0.7); font-size:15px;"><?php echo $cat->cat_name; ?> </a> </li>
                            <?php } ?>
                            </ul>
                        </div>
                        <div id="item-list" style="overflow:scroll" class="dragscroll">
                            <?php
                            echo '<div class="tabbable tabs-top">
							<div class="tab-content">';


                            //	print_r($product_list_by_category);
                            foreach ($product_list_by_category as $key => $cat) {
                                $status = '';
                                if (isset($cat[0]['cat_id'])) {
                                } else {
                                    continue;
                                }
                                if ($cat[0]['cat_id'] == 3) $status = 'active';

                                //print_r($cat);
                                echo '<div id="cat_' . $cat[0]['cat_id'] . '" class="tab-pane ' . $status . ' perf_scroll">';
                                foreach ($cat as $value) {
                                    echo " <button id='product-" . $value['product_id'] . "' type='button'
									class='item_btn_1 btn-prni btn-default product pos-tip box' value='" . $value['product_code'] . "'
									data-container='body' product_price='" . $value['product_price'] . "'
									title='" . $value['product_name'] . "' product_id='" . $value['product_id'] . "'
									style='background-image:url( " . asset_url() . "uploads/thumbs/" . $value['product_thumb'] . ");
									background-repeat:no-repeat; background-position:left top;' product_name=\"$value[product_name]\">
                      
											<label style='' id='product-" . $value['product_id'] . "'
											type='button' class='label-item btn-prni btn-default ' value='" . $value['product_code'] . "'
											data-container='body' product_price='" . $value['product_price'] . "'
											title='" . $value['product_name'] . "' product_id='" . $value['product_id'] . "'>
											" . substr($value['product_name'], 0, 35) . "- Rs. " . $value['product_price'] . "
											</label>
                      			</button>";
                                }
                                echo '</div>';
                            }


                            // featured items
                            echo '<div id="cat_' . '1000' . '" class="tab-pane active">';
                            //foreach ($category_by_id_1 as $key => $product) 
                            {

                            ?>

                                <!--  <button data-container="body" class="home-item_btn_1 btn-prni btn-default product pos-tip" title="" value="<?php echo $product->product_code; ?>" type="button" id="product-<?php echo $product->product_code; ?>" product_id="<?php echo $product->product_id; ?>" product_price="<?php echo $product->product_price; ?>" product_name="<?php echo $product->product_name; ?>" style="position:; top:0px; left:0px;" data-original-title="Extra Special 375ml"> 
					<?php echo substr($product->product_name, 0, 25) . "<br>" . $product->product_price; ?>	</button>   -->

                            <?php
                            }
                            echo '</div>';


                            echo '</div>
					</div>';
                            ?>
                        </div>
                    </div>
                    <div style="clear:both;" id="keyboard_panel">
                        <div class="btn-group-vertical key" role="group" style="display:flex">
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning " data-key="0">0</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning " data-key="1">1</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning " data-key="2">2</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning " data-key="3">3</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning " data-key="4">4</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning " data-key="5">5</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning " data-key="6">6</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning " data-key="7">7</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning " data-key="8">8</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning " data-key="9">9</button>
                            </div>
                            <!--<div class="btn-group">
                                
                            </div>-->
                        </div>

                        <div class="btn-group-vertical key" role="group" style="display:flex">
                            <div class="btn-group">
                                <button type="button" class="btn btn-success " data-key="Enter">&nbsp;ENTER</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger " data-key="backspace">CLEAR</button>
                            </div>
                            <div class="btn-group">&nbsp;</div>
                            <div class="btn-group">&nbsp;</div>
                            <div class="btn-group">&nbsp;</div>
                        </div>
                        <div class="btn-group-vertical money" role="group" style="display:flex">
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger " data-money="20">20</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger " data-money="50">50</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger " data-money="100">100</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger " data-money="500">500</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger " data-money="1000">1000</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger " data-money="5000">5000</button>
                            </div>
                            <div class="btn-group">&nbsp;</div>
                            <div class="btn-group">&nbsp;</div>
                            <div class="btn-group">&nbsp;</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="drawer"></div>
<input type="hidden" id="cash_en_tot" value="0" readonly>
<input type="hidden" id="qty_en_tot" value="">