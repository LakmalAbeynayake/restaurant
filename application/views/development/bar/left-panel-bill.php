<div id="content">
            <div class="c1">
               <div class="pos">
                  <div id="pos">
                     <form action="pos/pos_submit" data-toggle="validator" role="form" id="pos-sale-form" method="post" accept-charset="utf-8">
                        <input type="hidden" name="token" value="d6c35d2aebf0b3b14b4016c954dd2786" style="display:none;"/>
                        <div id="leftdiv" class="ui-widget quick-menu">
                          <div id="left-top" class="quick-menu" style="display:none">
                           
                               <div class="" style="width:100%;">
                                 <select id="poscustomer" name="poscustomer" class="search-select" data-placeholder="Select customer">
                                 <option value="">-</option>
                                 <?php foreach ($get_customer as $value) { ?>
                                 <?php $sel = '';
								 if($value->cus_id == 1)
								 	$sel='selected';
								  ?>
                                   <option <?php echo $sel; ?> value="<?php echo $value->cus_id; ?>"><?php echo $value->cus_name; ?></option>
                                 <?php } ?>
                                 </select>
                                 </div>
                              <div class="no-print">
                                 <div id="input_panel" class="" style="width:100%;">
                                   <select name="poswarehouse" id="poswarehouse" class="search-select" data-placeholder="Select Warehouse">
                                       <option value="">-</option>
                                       <?php $sel = '';
									   if(count($get_warehouse) < 2)
									   		$sel='selected';
									    ?>
                                       <?php foreach ($get_warehouse as $value) { ?>
                                         <option value="<?php echo $value->id; ?>" <?php echo $sel ?>><?php echo $value->name; ?> | <?php echo $value->code; ?></option>
                                       <?php } ?>
                                    </select>
                                 </div>
                                 
                                 
                                 <div class="form-group" id="ui">
                                 <div id="input_panel" class="input-group">
                                 <input type="text" name="add_item" value="" class="form-control pos-tip" id="add_item" data-placement="top" data-trigger="focus" placeholder="Scan/Search product by name/code" title="Please start typing code/name for suggestions or just scan barcode"/>
                                 <div class="input-group-addon" style="padding: 2px 5px;"><i class="fa clip-search-2" style="font-size: 1.25em;"></i>
                                 </div>
                                 </div>
                                 <div style="clear:both;"></div>
                                 </div>
                              </div>
                           </div>
                           <div id="print">
                             <div id="left-middle">
                           	   <div id="product-list" class="ps-container ps-active-y">
                                    <table style="margin-bottom: 0;" id="posTable" class="table items table-striped table-condensed">
                                      <thead>
                                          <tr>
                                             <th style="width:50%">Product</th>
                                             <th style="width:15%">Price</th>
                                             <th style="width:15%">Qty</th>
                                             <th style="width:20%">Subtotal</th>
                                          </tr>
                                </thead>
                                       <tbody>
                                       </tbody>
                                    </table>
                                    <div style="clear:both;">
                                    </div>
                               </div>
                              </div>
                              <div style="clear:both;"></div>
                              <div id="left-bottom">
                                 <table style="width:100%; float:right; padding:5px; color:#000; background: #FFF;" >
                                    <tbody>
                                       <tr>
                                          <td style="padding: 5px 10px;border-top: 1px solid #DDD;">Items</td>
                                          <td style="padding: 5px 10px;font-size: 14px; font-weight:bold; border-top: 1px solid #DDD;" class="text-right">
                                             <span id="titems">0</span>
                                          </td>
                                          <td style="padding: 5px 10px;border-top: 1px solid #DDD;">Total</td>
                                          <td style="padding: 5px 10px;font-size: 14px; font-weight:bold; border-top: 1px solid #DDD;" class="text-right">
                                             <span id="total">0.00</span>
                                          </td>
                                       </tr>
                                       <tr>

                                          <td style="padding: 5px 10px;border-top: 1px solid #DDD;">Discount &nbsp;
                                         </td>
                                          <td style="padding: 5px 10px;font-size: 14px; font-weight:bold; border-top: 1px solid #DDD;" class="text-right">
                                             <span id="tds">0.00</span>
                                          </td>
                                          <td style="padding: 5px 10px;border-top: 1px solid #DDD;">
                                          Delivery &nbsp;
                                          </td>
                                          <td style="padding: 5px 10px;font-size: 14px; font-weight:bold; border-top: 1px solid #DDD;" class="text-right">
                                           <span id="tship">0.00</span>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td colspan="2" style="padding: 5px 0px 5px 10px; text-align:left; font-size: 1.4em; border: 1px solid #333; font-weight:bold; background:#333; color:#FFF;">
                                             Total Payable
                                             
                                          </td>
                                          <td colspan="2" style="text-align:right; padding:5px 10px 5px 0px; font-size: 1.4em; border: 1px solid #333; font-weight:bold; background:#333; color:#FFF;" class="text-right">
                                             <span id="gtotal">00.00</span>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table><input type="hidden" value="3" id="biller" name="biller">
                                 <div class="clearfix"></div>
                                 <div id="botbuttons" class="col-xs-12 text-center">
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
                                 
                                 <input name="posshipping" id="posshipping" value="0.00" type="hidden">
                                 <input name="rowCount" type="hidden" id="rowCount" value="0">
                                 <!--keyboard input-->
                                 <input id="id-name" type="hidden" value="" />
                                 <!--end keyboard input-->
                                 
                                 <input type="hidden" id="posdiscount" value="0" name="discount">
                                 <input type="hidden" id="pos_discount_input1" value="0" name="pos_discount_input1">

                                 <input type="hidden" name="pay_amount" id="pay_amount" value=""/>
                                 <input type="hidden" name="balance_amount" id="balance_amount_1" value=""/>
                                 <input type="hidden" name="grand_total" id="grand_total" value="">

                                 <input type="hidden" name="paid_by" id="paid_by_val_1" value="cash"/>
                                 <input type="hidden" name="cc_name" id="cc_name" value=""/>
                                 <input type="hidden" name="cc_no" id="cc_no" value=""/>
                                 <input type="hidden" name="pcc_holder" id="pcc_holder" value=""/>
                                 <input type="hidden" name="pcc_type" id="pcc_type" value="visa"/>
                                 <input type="hidden" name="payment_note" id="pos_note" value="" >

                              </div>
                           </div>
                       </div>
                     </form>
                     
                     <div id="bill_tbl"><span id="bill_span"></span>
<table id="bill-table" width="100%" class="prT table table-striped" style="margin-bottom:0;"></table>
<table id="bill-total-table" class="prT table" style="margin-bottom:0;" width="100%"></table>
<span id="bill_footer"></span>
</div>
                     <div id="cp">
                        <div class="glow" id="cpinner" style="width:100%">
                           <div class="quick-menu">
                              <div id="proContainer">
                                 <div id="ajaxproducts">
                                    <div id="item-list">
                                   <?php $this->load->view("pos/promo") ?>
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