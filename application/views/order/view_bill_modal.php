<div class="modal fade in" id="view_bill_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header no-print">
        <button type="button" class="close no-print" data-dismiss="modal"><span aria-hidden="true"> <i class="fa fa-2x">&times;</i></span><span class="sr-only">Close</span> </button>
        <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();"> <i class="fa fa-print"></i> Print </button>
        <h4 class="modal-title no-print" id="vbModalLabel">Title</h4>
      </div>
      <div class="modal-body" style="page-break-after:always; margin-top:-20px">
  		 <div>
            <div class="col-xs-12 text-center">
              <center>
                <div style="display:none; border:solid 3px; border-radius:50px; width:13%; padding:15px; line-height:1"><span style="font-size:31px;font-weight:bold">SO</span> <span style="font-size:14px;font-weight:bold">Yummy</span></div>
              </center>
              <img alt="logo" src="<?php echo asset_url(); ?>images/logo_print.png" style="margin-top: 1px;width: 100px;">
              <p style="font-size:15px"><?php echo $get_warehouse[0]->address; ?></p>
              <?php
	  //print_r($get_warehouse[0]);
	   if($get_warehouse[0]->email) echo $get_warehouse[0]->email."<br>"; ?>
              <?php if($get_warehouse[0]->phone) echo "<span style=\"font-weight:bold; font-size:15px\">".$get_warehouse[0]->phone."</span><br>"; ?>
            </div>
            <!--col-xs-12-->
            <div>
              <div class="col-xs-6">
                <p id="bill_no" style="font-size:16px; font-weight:bold;margin: 0px 35px 0px 0px;">Bill No: </p>
              </div>
              <div class="col-xs-6 pull-right">
                <p style="margin-bottom:-4px;">Cashier :<?php echo $this->session->userdata['ss_user_first_name'] ?></p>
                <p style="margin-bottom:-2px;" id="bill_customer">Customer: </p>
                <p id="bill_date">Date: </p>
              </div>
            </div>
            <div class="col-md-12">
              <table id="bill_table" class="print-table" style="width:100%">
                <thead style="border-bottom:dashed;border-top:dashed">
                  <tr class="report_view_th text-center">
                    <th style="width:5%" class="text-center">*</th>
                    <th style="width:40%">Description</th>
                    <th style="width:10%" class="text-center">Qty</th>
                    <th style="width:10%" class="text-center">Price</th>
                    <th style="text-align:right"> Amount</th>
                  </tr>
                </thead>
                <tbody>
                  <tr style="display:none">
                    <td style="text-align:center; width:40px; vertical-align:middle;font-weight:bold; font-size:16px">*</td>
                    <td style="vertical-align:middle;font-weight:bold; font-size:15px">&nbsp;</td>
                    <td style="width: 80px; text-align:center; vertical-align:middle;font-weight:bold; font-size:15px">&nbsp;</td>
                    <td style="text-align:right; width:100px;">&nbsp;</td>
                    <td style="text-align:right; width:120px; padding-right:10px;">&nbsp;</td>
                  </tr>
                  <tr style="border-top:dashed;">
                    <td style="text-align:right;" colspan="4">SubTotal</td>
                    <td style="text-align:right; padding-right:10px;" id="td_sub_total">&nbsp;</td>
                  </tr>
                  <tr style="display:none">
                    <td style="text-align:right; font-weight:bold;" colspan="4">Delivery Charges</td>
                    <td style="text-align:right; padding-right:10px;" id="td_delivery_charges">&nbsp;</td>
                  </tr>
                  <tr style="display:none">
                    <td style="text-align:right; font-weight:bold;" colspan="4">Service Charges </td>
                    <td style="float:right; padding-right:10px;" id="td_service_charges">&nbsp;</td>
                  </tr>
                  <tr style="display:none">
                    <td style="text-align:right; font-weight:bold;" colspan="4">Order Discount</td>
                    <td style="text-align:right; padding-right:10px; border-bottom:solid 1px #000000" id="td_order_discount">()</td>
                  </tr>
                  <tr>
                    <td style="text-align:right; font-weight:bold; font-size:16px" colspan="4">Total Amount</td>
                    <td style="text-align:right; padding-right:10px; font-size:16px; font-weight:bold; border-bottom:4px double #000;" id="id_total_amount"></td>
                  </tr>
                  <tr style="display:none">
                    <td style="text-align:right; font-weight:bold;" colspan="4">Paying Amount <span id="td_paying_by"></span></td>
                    <td style="text-align:right; padding-right:10px; font-weight:bold" id="td_paying_amount">&nbsp;</td>
                  </tr>
                  <tr style="display:none">
                    <td style="font-size:16px;text-align:right; font-weight:bold" colspan="4">Balance Amount</td>
                    <td style="text-align:right; font-weight:bold; border-bottom:4px double #000;"><p style="font-size:16px;margin: 0px;" id="td_balance_amount">&nbsp;&nbsp; </p></td>
                  </tr>
                </tbody>
              </table>
              <br/>
              <p style="font-weight:bold;text-align:center"><i class="fa fa-facebook"></i>: bakerschoice.colombo <?php /*?><?php if($get_warehouse[0]->email) echo $get_warehouse[0]->email ?><?php */?> </p>
            </div>
          </div>
        <!--end .row--> 
        <!--Start K.O.T-->
        <div style="padding-top:50px;" class="no-print">
          <!--<div align="center" style="font-size:16px; font-weight:bold;"> K.O.T </div>-->
          <div class="col-xs-12">
          	<p style="font-size:16px; text-align:center; font-weight:bold;margin:0px;">K.O.T </p>
            <p style="font-size:16px; font-weight:bold;margin: 0px 35px 0px 0px;">Bill No: </p>
          </div>
          <table class="print-table" style="width:100%">
            <thead style="border-bottom:dashed;border-top:dashed">
              <tr class="report_view_th text-center">
                <th style="width:10%">*</th>
                <th style="width:25%">Description</th>
                <th style="width:10%">Qty</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="text-align:center; width:40px; vertical-align:middle;font-weight:bold; font-size:16px">*</td>
                <td style="vertical-align:middle;font-weight:bold; font-size:16px">&nbsp;</td>
                <td style="width: 80px; text-align:center; vertical-align:middle;font-weight:bold; font-size:18px">&nbsp;</td>
              </tr>
            </tbody>
          </table>
        </div>
        <!--END K.O.T--> 
      </div>
      
      <div class="modal-footer" style="border:none;display:none">
      <div style="padding-top:50px;">
          <!--<div align="center" style="font-size:16px; font-weight:bold;"> K.O.T </div>-->
          <div class="col-xs-12">
          	<p style="font-size:16px; text-align:center; font-weight:bold;margin:0px;">K.O.T </p>
            <p style="font-size:16px; text-align:left; font-weight:bold;margin: 0px 35px 0px 0px;">Bill No: </p>
          
          <table id="kot_table" class="print-table" style="width:100%">
            <thead style="border-bottom:dashed;border-top:dashed">
              <tr class="report_view_th text-center">
                <th style="width:5%" class="text-center">*</th>
                <th style="width:75%" class="text-center">Description</th>
                <th style="width:10%" class="text-center">Qty</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table></div>
        </div>
      </div>
    
    </div>
  </div>
</div>
