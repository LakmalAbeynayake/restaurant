
<div class="modal fade in" id="view_bill_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="font-family: monospace; font-size: 14px">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header no-print">
        <button type="button" class="close no-print" data-dismiss="modal"><span aria-hidden="true"> <i class="fa fa-2x">&times;</i></span><span class="sr-only">Close</span> </button>
        <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();"> <i class="fa fa-print"></i> Print </button>
        <h4 class="modal-title no-print" id="vbModalLabel">Title</h4>
      </div>
      <div class="modal-body" style="margin-top:-20px;padding: 15px 0px 0px 0px;" id="DivIdToPrint">
        <div style="page-break-after:always;">
          <div class="col-xs-12 text-center">
            <center>
              <div style="display:none; border:solid 3px; border-radius:50px; width:13%; padding:15px; line-height:1"><span style="font-size:31px;font-weight:bold">SO</span> <span style="font-size:14px;font-weight:bold">Yummy</span></div>
            </center>
            
           
             
            <img class="" alt="logo" src="<?php echo asset_url(); ?>images/logo_print.png" style="margin-top: 1px;width: 100px;"> 
             <h2 style="margin-top: 0px;"><?php echo $get_warehouse[0]->name; ?></h2>
            <p style="font-size:16px ; margin: 0px"><?php echo $get_warehouse[0]->address; ?></p>
            <?php

	  //print_r($get_warehouse[0]);

	   if($get_warehouse[0]->email) echo $get_warehouse[0]->email."<br>"; ?>
	  
            <?php if($get_warehouse[0]->phone) echo "<span style=\"font-weight:bold; font-size:15px\">".$get_warehouse[0]->phone."</span><br>"; ?>
          </div>
          
          <!--col-xs-12-->
          
          <div>
              <div class="row">
                  <div class="col-md-12">
                      <p id="bill_date" style="margin-bottom: 0px">Date: </p>
                  </div>
                  <div class="col-md-6">
                      
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      <p id="bill_no"  style="font-weight:bold; margin-bottom: 0px">Bill No: </p>
                      <p style="margin-bottom:0px;">Cashier :<?php echo $this->session->userdata['ss_user_first_name'] ?></p>
                  </div>
                  <div class="col-md-7">
                      
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      <p style="" id="bill_customer">Customer: </p>
                      <span style="" id="del_addr_bill"></span>
                  </div>
                  <!--<div class="col-md-6">-->
                      
                  <!--</div>-->
              </div>
<!--            <div class="">col-xs-12 row
              <p id="bill_no" style="font-weight:bold;margin: 0px 35px 0px 0px;">Bill No: </p>
              <p style="margin-bottom:-4px;">Cashier :<?php echo $this->session->userdata['ss_user_first_name'] ?></p>
              <p style="margin-bottom:-2px;" id="bill_customer">Customer: </p>
              <p id="bill_date">Date: </p>
            </div>-->
            <!--<div class="col-xs-6 pull-right row">
              
            </div>-->
          </div>
          <div ><!--class="col-md-12"-->
            <table id="bill_table" class="print-table" style="width:100%">
              <thead style="border-bottom:dashed;border-top:dashed">
                <tr class="report_view_th text-center">
                  <th style="width:5%" class="text-center">*</th>
                  <th style="width:40%">Item</th>
                  <th style="width:15%" class="text-center">Qty</th>
                  <th style="width:15%" class="text-center">Price</th>
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
                  <td style="" colspan="4">SubTotal</td>
                  <td style="text-align:right; " class="td_sub_total">&nbsp;</td>
                </tr>
                <tr style="display:none">
                  <td style="text-align:right; font-weight:bold;" colspan="4">Delivery Charges</td>
                  <td style="text-align:right; " id="td_delivery_charges">&nbsp;</td>
                </tr>
                <!-- 
                <tr style="display:none">
                  <td style="text-align:right; font-weight:bold;" colspan="4">Service Charges </td>
                  <td style="float:right; " id="td_service_charges">&nbsp;</td>
                </tr> -->
                <tr style="display:none">
                  <td style="text-align:right; font-weight:bold;" colspan="4">Order Discount</td>
                  <td style="text-align:right;  border-bottom:solid 1px #000000" id="td_order_discount">()</td>
                </tr>
                <tr>
                  <td style="  font-size:24px" colspan="4">Total:</td>
                  <td style="text-align:right;  font-size:24px;  border-bottom:4px double #000;" class="id_total_amount"></td>
                </tr>
                <!-- display:none -->
                <tr style="">
                  <td style=" font-weight:bold;" colspan="4">Paying <span id="td_paying_by"></span></td>
                  <td style="text-align:right;  font-weight:bold" id="td_paying_amount">&nbsp;</td>
                </tr>
                <tr style="">
                  <td style="font-size:24px;" colspan="4">Balance</td>
                  <td style="  border-bottom:4px double #000;text-align:right;"><p style="font-size:24px;margin: 0px;" id="td_balance_amount">&nbsp;&nbsp; </p></td>
                </tr>
              </tbody>
            </table>
            <br/>
            <?php /*?><p style="font-weight:bold;text-align:center"><i class="fa fa-facebook"></i>: bakerschoice.colombo
              <?php if($get_warehouse[0]->email) echo $get_warehouse[0]->email ?>
            </p><?php */?>
            
            <p style="text-align: center">Viable ERP by Sallelanka <br/>
 077706 9344</p>
          </div>
          <div style="text-align: center">
              <h2 style="margin-top: 5px">~~~Thank You~~~</h2>
          </div>
          
          <!--
          <div class="row" style="padding-left: 6px;text-align: center    ">
              <div class="icon"  style="float: left;padding-left: 10px;">
                  <img src="<?php echo asset_url(); ?>images/restaurant_70_1_35x35.png">
              </div>
              <div class="icon"  style="float: left">
                  <img src="<?php echo asset_url(); ?>images/baricon_35x35.png">
              </div>
              <div class="icon"  style="float: left">
                  <img src="<?php echo asset_url(); ?>images/double-bed_70_1_35x35.png">
              </div>
              <div class="icon"  style="float: left">
                  <img src="<?php echo asset_url(); ?>images/delivery-truck_70_1_35x35.png">
              </div>
          </div>
          
          -->
          <style>
              .icon img{
                  margin-left: 12px;
                    margin-right: 12px;
              }
          </style>
        </div>
        
        <!--end .row--> 
        
       
        
      </div>
      <div class="modal-footer" style="border:none;">
        <div style="padding-top:0px;"> 
          
          <!--<div align="center" style="font-size:16px; font-weight:bold;"> K.O.T </div>-->
          
          <div class="" style="font-size:20px">
            <p style=" text-align:center; font-weight:bold;margin:0px;">K.O.T </p>
            <p style=" text-align:left; font-weight:bold;margin: 0px 35px 0px 0px;" id="kot_type"></p>
            <p style=" text-align:left; font-weight:bold;margin: 0px 35px 0px 0px;" id="kot_bill_no"></p>
            <p style=" text-align:left; font-weight:bold;margin: 0px 35px 0px 0px;" id="kot_date_time"></p>
            <p style=" text-align:left; font-weight:bold;margin: 0px 35px 0px 0px;" id="kot_table_no"></p>
            <table class="print-table" style="width:100%" id="kot_table">
              <thead style="border-bottom:dashed;border-top:dashed">
                <tr class="report_view_th text-center">
                  <th style="width:5%" class="text-center">*</th>
                  <th style="width:75%" class="text-center">Description</th>
                  <th style="width:10%" class="text-center">Qty</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- 
<div id='DivIdToPrint-del'>
    <p>This is a sample text for printing purpose.</p>
</div>
<p>Do not print.</p>
<input type='button' id='btn' value='Print' onclick='printDiv();'>
-->
<script>
    function printDiv() 
{

//var gtotal=parseFloat($( "#gtotal" ).text());
//alert(gtotal);
//$( "#id_total_amount" ).text(gtotal);
 
 
  var divToPrint=document.getElementById('DivIdToPrint');

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}
</script>
