<div class="modal fade in" id="print_no_kot">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" tabindex="-1"> <i class="fa fa-2x">×</i> </button>
    <div class="row" id="section-to-print">
      <div class="col-xs-12 text-center"> <img src="<?php echo asset_url(); ?>images/logo_print.png" style="margin-top: 1px;width: 100px;">
        <p style="font-size:15px">&nbsp;</p>
      </div>
      <div style="width:100%;margin-left:5px;">
        <div class="row">
          <div class="col-xs-11" style="margin-left:8px;">
            <div class="col-xs-6">
              <p style="font-size:16px; font-weight:bold;margin: 0px 35px 0px 0px;">Bill No: </p>
            </div>
            <div class="col-xs-6 pull-right">
              <p style="font-size:12px; margin-bottom:-4px;">Cashier :</p>
              <p style="margin-bottom:-2px;">Customer: </p>
              <p>Date: </p>
            </div>
          </div>
        </div>
        <div class="print-start">
          <div class="row col-md-12">
            <div class="col-xs-12">
              <table class="print-table" width="100%">
                <thead style="border-bottom:dashed;border-top:dashed">
                  <tr class="report_view_th text-center">
                    <th style="width:10%">*</th>
                    <th style="width:25%">Description</th>
                    <th style="width:10%">Qty</th>
                    <th style="width:10%">Price</th>
                    <th align="center"> Amount</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="text-align:center; width:40px; vertical-align:middle;font-weight:bold; font-size:16px">*</td>
                    <td style="vertical-align:middle;font-weight:bold; font-size:15px">&nbsp;</td>
                    <td style="width: 80px; text-align:center; vertical-align:middle;font-weight:bold; font-size:15px">&nbsp;</td>
                    <td style="text-align:right; width:100px;">&nbsp;</td>
                    <td style="text-align:right; width:120px; padding-right:10px;">&nbsp;</td>
                  </tr>
                  <tr style="border-top:dashed;">
                    <td style="text-align:right;" colspan="4">SubTotal</td>
                    <td style="text-align:right; padding-right:10px;">&nbsp;</td>
                  </tr>
                  <tr>
                    <td style="text-align:right; font-weight:bold;" colspan="4">Delivery Charges</td>
                    <td style="text-align:right; padding-right:10px;">&nbsp;</td>
                  </tr>
                  <tr>
                    <td style="text-align:right; font-weight:bold;" colspan="4">Service Charges ()</td>
                    <td style="text-align:right; padding-right:10px;">&nbsp;</td>
                  </tr>
                  <tr>
                    <td style="text-align:right; font-weight:bold;" colspan="4">Order Discount</td>
                    <td style="text-align:right; padding-right:10px; border-bottom:solid 1px #000000">()</td>
                  </tr>
                  <tr>
                    <td style="text-align:right; font-weight:bold; font-size:16px" colspan="4">Total Amount</td>
                    <td style="text-align:right; padding-right:10px; font-size:16px; font-weight:bold; border-bottom:4px double #000;">
                  </tr>
                  <tr>
                    <td style="text-align:right; font-weight:bold;" colspan="4">&nbsp;</td>
                    <td style="text-align:right; padding-right:10px; font-weight:bold">&nbsp;</td>
                  </tr>
                  <tr>
                    <td style="font-size:16px;text-align:right; font-weight:bold" colspan="4">Balance Amount</td>
                    <td style="text-align:right; font-weight:bold; border-bottom:4px double #000;"><p style="font-size:16px">&nbsp;&nbsp; </p></td>
                  </tr>
                </tbody>
              </table>
              <br>
              <p align="center" style="font-weight:bold"><i class="fa fa-facebook"></i>: soyummylk </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
