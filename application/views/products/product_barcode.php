<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Print Barcodes | Stock Manager Advance</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/font-awesome/css/font-awesome.min.css">
      </head>
      <style>
.table.barcodes td {
   border-top: 0px;
   padding: 0px;
}
.table.barcodes .table-barcode {
    width: 100%;
}
.table.barcodes .table-barcode td {
    padding: 2px!important;
}
.bold {
    font-weight: 900;
}
.table-barcode tr{ line-height: 0.5; }

table{ line-height: 1.5; margin-bottom: 0px;  margin-left: 0mm;}

img{width: 145px; height: 30px;}
      body{font-size:13px;text-align:center;color:#000;background:#FFF;}body:before,body:after{display:none;}.tab-wrapper{max-width:1000px;margin:0 auto;}.table td{text-align:center;}h4{margin:5px;padding:0;}@media print {.table td{border-color:#F9F9F9!important;}.tab-wrapper{width:auto!important;}h3{margin-top:0;}.container p,.pagination,.well{display:none;}hr{page-break-after:always;}}</style>
   
   </style>
   </head>
   <body>
      <div class="tab-wrapper">
         <div class="well">
            <span style="margin-top:15px; display: block;">
               <div class="btn-group">
                  <a class="btn btn-primary" href="#" onclick="window.print(); return false;"><i class="fa fa-print"></i> Print</a>
                  <a class="btn btn-danger" onclick="javascript:window.close()"><i class="fa fa-times"></i> Close</a>
               </div>
            </span>
         </div>
         <table class="table barcodes">
            <tbody>
            <?php for ($i=0; $i < 12 ; $i++) { ?>
               <tr>
                  <td style="height: 80px;">
                     <table class="table-barcode">
                        <tbody>
                           <tr>
                              <td colspan="2" class="bold" style="font-size: 12px;">JCB SERVICE PARTS</td>
                           </tr>
                           <tr>
                              <td colspan="2" class="text-center bc"><img src="<?php echo base_url().'products/gen_barcode/'.$product_details->product_code.'/30'; ?>" alt='<?php echo $product_details->product_code; ?>'/></td>
                           </tr>
                           <tr>
				<?php echo $product_details->product_code;?> | <?php echo substr($product_details->product_name, 0,15);?>
                           </tr>
                        </tbody>
                     </table>
                  </td>
                  <td style="height: 80px;">
                     <table class="table-barcode">
                        <tbody>
                           <tr>
                              <td colspan="2" class="bold" style="font-size: 12px;">JCB SERVICE PARTS</td>
                           </tr>
                           <tr>
                              <td colspan="2" class="text-center bc">
                              <img src="<?php echo base_url().'products/gen_barcode/'.$product_details->product_code.'/30'; ?>"alt='<?php echo $product_details->product_code; ?>'/></td>
                           </tr>
			   <tr>
                              <?php echo $product_details->product_code;?> | <?php echo substr($product_details->product_name, 0,15);?>
                           </tr>
                        </tbody>
                     </table>
                  </td>
                  <td style="height: 80px;">
                     <table class="table-barcode">
                        <tbody>
                           <tr>
                              <td colspan="2" class="bold" style="font-size: 12px;">JCB SERVICE PARTS</td>
                           </tr>
                           <tr>
                              <td colspan="2" class="text-center bc"><img src="<?php echo base_url().'products/gen_barcode/'.$product_details->product_code.'/30'; ?>"alt='<?php echo $product_details->product_code; ?>'/></td>
                           </tr>
                           <tr>
				<?php echo $product_details->product_code;?> | <?php echo substr($product_details->product_name, 0,15);?>
                           </tr>
                        </tbody>
                     </table>
                  </td>
                  <td style="height: 80px;">
                     <table class="table-barcode">
                        <tbody>
                           <tr>
                              <td colspan="2" class="bold" style="font-size: 12px;">JCB SERVICE PARTS</td>
                           </tr>
                           <tr>
                              <td colspan="2" class="text-center bc"><img src="<?php echo base_url().'products/gen_barcode/'.$product_details->product_code.'/30'; ?>"alt='<?php echo $product_details->product_code; ?>'/></td>
                           </tr>
                           <tr>
                              <?php echo $product_details->product_code;?> | <?php echo substr($product_details->product_name, 0,15);?>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
            <?php } ?>
            </tbody>
         </table>
         <div class="well">
            <span style="margin-top:15px; display: block;">
               <div class="btn-group">
                  <a class="btn btn-primary" href="#" onclick="window.print(); return false;"><i class="fa fa-print"></i> Print</a>
                  <a class="btn btn-danger" onclick="javascript:window.close()"><i class="fa fa-times"></i> Close</a>
               </div>
            </span>
         </div>
      </div>
   </body>
</html>