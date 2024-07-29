<div id="wrapper">
  
  <div id="loader" align="center" style="padding:15%; display:none"> <i class="fa fa-cog fa-spin fa-4x"></i> </div>
  
  <?php $this->load->view("pos/left-panel"); ?>
  <?php $this->load->view("pos/delivery"); ?>
  <div class="rotate btn-cat-con">
    <button type="button" id="open-subcategory" class="btn btn-warning open-subcategory">Subcategories</button>
    <button type="button" id="open-category" class="btn btn-primary open-category">Categories</button>
    <button style="display:none" id="open-keyboard" class="btn btn-success open-keyboard" type="button"><i class="clip-keyboard-2"></i></button>
  </div>
  <?php $this->load->view("pos/category-slider"); ?>
  <?php $this->load->view("pos/sub_category-slider"); ?>
  <div class="modal fade in" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel" aria-hidden="true" style="left: 10%;margin-left:0px;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onClick="form_reset();"><span aria-hidden="true"><i class="fa fa-2x">&times;</i></span><span class="sr-only">Close</span></button>
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
                        <div class="form-group">
                          <label for="amount_1">Amount</label>
                          <input name="amount[]" type="text" id="amount_1" class="pa form-control kb-pad amount"/>
                        </div>
                      </div>
                      <div class="col-sm-5 col-sm-offset-1">
                        <div class="form-group">
                          <label for="paid_by_1">Paying by</label>
                          <select name="paid_by" id="paid_by_1" class="form-control paid_by select2-nosearch">
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
                          <div class="form-group">
                            <label for="cheque_no_1">Cheque No</label>
                            <input name="cheque_no[]" type="text" id="cheque_no_1" class="form-control cheque_no"/>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="payment_note">Payment Note</label>
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
    <table id="order-table" class="prT table table-striped" style="margin-bottom:0;" width="100%">
    </table>
  </div>
  <div id="bill_tbl"> <span id="bill_span"></span>
    <table id="bill-table" width="100%" class="prT table table-striped" style="margin-bottom:0;">
    </table>
    <table id="bill-total-table" class="prT table" style="margin-bottom:0;" width="100%">
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
  <div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none; left:49%"></div>
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