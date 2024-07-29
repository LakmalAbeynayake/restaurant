<div id="wrapper">
 <div id="loader" style="padding:15%; text-align:center; display:none"> <i class="fa fa-cog fa-spin fa-4x"></i> </div>
<?php /*?><?php $this->load->view("pos/left-panel"); ?><?php */?>
<!--left panel start-->
<!--<div id="content" style="background-color:#FFF">
  <div class="c1">
    <div class="pos">
      <div id="pos">
        <form action="#" data-toggle="validator" role="form" id="pos-sale-form" name="pos-sale-form" method="post" accept-charset="utf-8">
          <input type="hidden" name="token" value="d6c35d2aebf0b3b14b4016c954dd2786" style="display:none;"/>
          <div id="leftdiv" class="ui-widget quick-menu" >
            <div id="printhead">
              <h4 style="text-transform:uppercase;">Stock Manager Advance</h4>
              <h5 style="text-transform:uppercase;">Order List</h5>
              Date 31/12/2015 22:14 </div>
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
                <?php  //print_r($get_customer); ?>
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
			//if($sale_id)if($sale_details[0]) print_r($sale_details[0]);
//				if($sale_id)if($sale_details[0]['dine_type'] == 2) echo 'checked="checked2"';
//				if($sale_id)if($sale_details[0]['dine_type'] == 3) echo 'checked="checked3"';
				 ?>
                <div class="form-group" style="background-color:#FFF">
                	<div class="input-group cb_list">
                      <div id="div_3" 	class="input-group-addon pos-tip" style="cursor:pointer; padding: 0px 8px; border-left: solid;border-right: none;  width:10%" title="Delivary"> <label style="margin: 6px 0px 6px 0px"> <input id="cb_3" name="delivery_status" class="orange" checked="checked" type="radio" style="display:none" value="3" /> </label></div>
                      <div id="div_3_2" class="input-group-addon" style="cursor:pointer; padding: 0px 0px; border-left: 0; width:100%" ><label style="cursor:pointer" for="cb_3"> <i class="fa fa-truck"></i> Delivery </label></div>
                  </div>
                </div>
                
                <div class="form-group" id="ui">
                  <div class="input-group">
                    <input type="text" name="add_item" value="" class="form-control pos-tip" id="add_item" data-placement="top" data-trigger="focus" style="background-color:#FFF"/>
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
                      <td style="padding: 5px 10px;border-top: 1px solid #DDD;">Discount &nbsp;<a id="ppdiscount" href="#"> <i class="fa fa-edit"></i> </a></td>
                      <td style="padding: 5px 10px;font-size: 14px; font-weight:bold; border-top: 1px solid #DDD;" class="text-right"><span id="tds">0.00</span></td>
                      <td style="padding: 5px 10px;border-top: 1px solid #DDD;" ><span class="hide_me"> Delivery &nbsp;<a href="#" id="pshipping"> <i class="fa fa-plus-square"></i> </a></span></td>
                      <td style="padding: 5px 10px;font-size: 14px; font-weight:bold; border-top: 1px solid #DDD;" class="text-right"><span class="hide_me"><span id="tship">0.00</span></span></td>
                    </tr>
                    <tr>
                      <td colspan="2" style="padding: 5px 10px; border-top: 1px solid #666; font-weight:bold; background:#333; color:#FFF;"> Total Payable</td>
                      <td colspan="2" style="padding:5px 10px 5px 10px; font-size: 14px;border-top: 1px solid #666; font-weight:bold; background:#333; color:#FFF;"><span id="sc_sp" style="visibility:hidden">(S.C 10% included)</span><span class="text-right pull-right" id="gtotal">0.00</span></td>
                    </tr>
                  </tbody>
                </table>
                <input type="hidden" value="3" id="biller" name="biller">
                <div class="clearfix"></div>
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
                      <button type="button" class="btn btn-success btn-block" id="payment" style="height:36px;" tabindex="-1"> <i class="fa fa-money" style="margin-right: 5px;"></i>Payment </button>
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
                <input type="hidden" name="shipping_address" id="shipping_address" value="<?php if($sale_id){if($sale_details[0]['shipping_address']) echo $sale_details[0]['shipping_address'];}else echo ''; ?>">
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
          
<!--left panel end-->
 
  

  

  <div class="modal fade in" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" id="close" class="close" data-dismiss="modal" onClick="form_reset();"><span aria-hidden="true"><i class="fa fa-2x">&times;</i></span><span class="sr-only">Close</span></button>

          <h4 class="modal-title" id="payModalLabel">Finalize Sale</h4>

        </div>

        <div class="modal-body" id="payment_content">

          <div class="row">

            <div class="col-md-10 col-sm-9">

              <div class="clearfix"></div>

              <div id="payments">

                <div class="well well-sm well_1">

                  <div class="payment">

                    <div class="row">

                      <div class="col-sm-5">

                        <div class="form-group final">

                          <label for="amount_1">Paying amount</label>

                          <input name="amount[]" type="text" id="amount_1" class="pa form-control kb-pad amount auto" value="0"/>

                        </div>

                      </div>

                      <div class="col-sm-5 col-sm-offset-1">

                        <div class="form-group ccard">

                          <label for="paid_by_1">Paying by</label>

                          <select name="paid_by" id="paid_by_1" class="form-control paid_by select2-nosearch-d">

                            <option value="cash">Cash</option>

                            <option value="CC">Credit Card</option>

                          </select>

                        </div>

                      </div>

                    </div>

                    <div class="row">

                      <div class="col-sm-11">

                        <div class="form-group gc_1" style="display: none;">

                          <label for="gift_card_no_1">Gift Card No</label>

                          <input name="paying_gift_card_no[]" type="text" id="gift_card_no_1" class="pa form-control kb-pad gift_card_no"/>

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

                                <select name="cc_type[]" id="pcc_type_1" class="form-control pcc_type">

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

                          <div class="form-group">

                            <label for="cheque_no_1">Cheque No</label>

                            <input name="cheque_no[]" type="text" id="cheque_no_1" class="form-control cheque_no"/>

                          </div>

                        </div>

                        <div class="form-group final">

                          <label for="payment_note_1">Payment Note</label>

                          <textarea name="payment_note[]" id="payment_note_1" class="pa form-control kb-text payment_note"></textarea>

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

                      <td style="width:25%">Total Items</td>

                      <td style="width:25%" class="text-right"><span id="item_count">0.00</span></td>

                      <td style="width:25%" >Total Payable</td>

                      <td style="width:25%" class="text-right"><span id="twt">0.00</span></td>

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

            <div class="col-md-2 col-sm-3 text-center"> <span style="font-size: 1.2em; font-weight: bold;">Quick Cash</span>

              <div class="btn-group btn-group-vertical">

                <button type="button" class="btn btn-lg btn-info quick-cash" id="quick-payable">0.00 </button>

                <button type="button" class="btn btn-lg btn-warning quick-cash">10</button>

                <button type="button" class="btn btn-lg btn-warning quick-cash">20</button>

                <button type="button" class="btn btn-lg btn-warning quick-cash">50</button>

                <button type="button" class="btn btn-lg btn-warning quick-cash">100</button>

                <button type="button" class="btn btn-lg btn-warning quick-cash">500</button>

                <button type="button" class="btn btn-lg btn-warning quick-cash">1000</button>

                <button type="button" class="btn btn-lg btn-warning quick-cash">5000</button>

                <button type="button" class="btn btn-lg btn-danger" id="clear-cash-notes">Clear</button>

              </div>

            </div>

          </div>

        </div>

        <div class="modal-footer" id="submit_form">

          <button class="btn btn-block btn-lg btn-primary" id="submit-sale">Submit</button>

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

            <label for="order_discount_input">Order Discount</label>

            <input type="text" name="order_discount_input" value="" class="form-control" id="order_discount_input"/>

          </div>

        </div>

        <div class="modal-footer">

          <button type="button" id="updateOrderDiscount" class="btn btn-primary">Update</button>

        </div>

      </div>

    </div>

  </div>

  <div id="order_tbl"> <span id="order_span"></span>

    <table id="order-table" class="prT table table-striped" style="margin-bottom:0;width:100%">

    </table>

  </div>

  <div id="bill_tbl"> <span id="bill_span"></span>

    <table id="bill-table" class="prT table table-striped" style="margin-bottom:0; width:100%">

    </table>

    <table id="bill-total-table" class="prT table" style="margin-bottom:0; width:100%">

    </table>

  </div>

  <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

  <div class="modal fade in" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true"></div>

  <div id="modal-loading" style="display: none;">

    <div class="blackbg" style="padding-top:250px"><center><i style="color:#FFF;" class="fa fa-spinner fa-spin fa-5x"></i></center></div>

    <div class="loader-"></div>

  </div>

  

  <div id="ajaxCall"><i class="fa fa-spinner fa-pulse"></i></div>

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

        <input id="sel_id" type="hidden"/>

        <input id="page" type="hidden"/>

        <input id="count" value="0" type="hidden"/>

        <input id="popup_type" type="hidden"/>

        <button aria-hidden="true" data-dismiss="modal" class="btn btn-default"> Close </button>

        <button id="conirm" class="btn btn-default" data-dismiss="modal"> Confirm </button>

      </div>

    </div>

  </div>

</div>