<?php $this->load->view("common/header"); ?>
<!-- end: HEAD -->

<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->

<style type="text/css">
.table > thead:first-child > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table-striped thead tr.primary:nth-child(2n+1) th {
	background-color: #428bca;
	border-color: #357ebd;
	border-top: 1px solid #357ebd;
	color: white;
	text-align: center;
}

.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 240px;
  height: 240px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
<!-- end: HEAD -->
<!-- start: BODY -->
<body>
<!-- start: HEADER -->
<div class="navbar navbar-inverse navbar-fixed-top"> 
  <!-- start: TOP NAVIGATION CONTAINER -->
  <div class="container">
    <div class="navbar-header"> 
      <!-- start: RESPONSIVE MENU TOGGLER -->
      <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button"> <span class="clip-list-2"></span> </button>
      <!-- end: RESPONSIVE MENU TOGGLER --> 
      <!-- start: LOGO -->
      <?php $this->load->view("common/logo"); ?>
      <!-- end: LOGO --> 
    </div>
    <div class="navbar-tools"> 
      <!-- start: TOP NAVIGATION MENU -->
      <?php $this->load->view("common/notifications.php"); ?>
      <!-- end: TOP NAVIGATION MENU --> 
    </div>
  </div>
  <!-- end: TOP NAVIGATION CONTAINER --> 
</div>
<!-- end: HEADER --> 
<!-- start: MAIN CONTAINER -->
<div class="main-container">
<div class="navbar-content"> 
  <!-- start: SIDEBAR -->
  <?php $this->load->view("common/navigation"); ?>
  <!-- end: SIDEBAR --> 
</div>
<!-- start: PAGE -->
<div class="main-content"> 
  <!-- end: SPANEL CONFIGURATION MODAL FORM -->
  <div class="container"> 
    <!-- start: PAGE HEADER -->
    <div class="row">
      <div class="col-sm-12"> 
        <!-- start: PAGE TITLE & BREADCRUMB -->
        <ol class="breadcrumb">
          <li> <a href="<?php echo base_url('dashboard'); ?>"> DASHBORD </a> </li>
          <li> <a href="#"> STOCK TRANSFER</a> </li>
          <li class="active"> TRANSFER DETAILS </li>
          <li class="search-box">
            <form class="sidebar-search">
              <div class="form-group">
                <input type="text" placeholder="Start Searching...">
                <button class="submit"> <i class="clip-search-3"></i> </button>
              </div>
            </form>
          </li>
        </ol>
        <div class="page-header">
          <h4> TRANSFER DETAILS </h4>
          </div>
        
              
              
               <div class="well well-sm">                      

<div class="col-xs-4 border-right">
<div class="col-xs-2"><i class="fa fa-3x fa-file-text-o padding010 text-muted"></i></div>
<div class="col-xs-10">
<h4 class="">TRANSFER NO : <?php echo $product_list[0]->stm_no;?></h4>
</div>
<div class="clearfix"></div>
</div>
 <!--col-xs-4-->
    
        <!--<p>Please use the table below to navigate or filter the results. </p>-->
      </div>
    </div>
    <!-- end: PAGE HEADER --> 
    <!-- start: PAGE CONTENT 
                    <!-- start grid -->
    <div class="row">
      <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <!--<div class="panel panel-default">
          <div class="panel-heading"> <i class="fa fa-external-link-square"></i> Add Bulk Products 
            <div class="panel-tools" style="top:2px;">
              <button onClick="printDiv('printableArea')" class="btn btn-blue dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-print"></i> </button>
            </div>
          </div>
        </div>-->
        <div class="panel-body">
          <div id="error"></div>
          <div class="col-md-12">
            
           
                  
            <table class="table table-bordered table-condensed table-hover table-striped dataTable" id="warehouse_table_1">
              <thead>
                <tr>
                  <th>CODE</th>
                  <th>NAME</th>
                   <th>BATCH CODE</th>
                   <th>QTY</th>
                   <th>COST</th>
                  
                </tr>
              </thead>
              <body>
                  <?php 
                    if($product_list){
                        foreach($product_list as $p){
                            ?>
                            <tr>
                                <td><?=$p->product_code;?></td>
                                <td><?=$p->product_name;?></td>
                                <td><?=$p->batch_code;?></td>
                                <td><?=$p->quantity;?></td>
                                <td><?=$p->product_cost;?></td>
                                
                            </tr>
                            
                            <?php
                        }
                    }
                    ?>
                 </body>
              <tfoot>
                <tr>
                    <th>CODE</th>
                    <th>NAME</th>
                    <th>QTY</th>
                    <th>COST</th>
                    <th>BATCH CODE</th>
                </tr>
                 </tfoot>
            </table>
            
            <div class="panel-body">
            <?php if(isset($stm_receved_status) and  $stm_receved_status==0){ ?>
              <div class="col-sm-3 pull-right ">
                        <div class="form-group">
                    <a class="btn btn-success pull-right " onClick="grn_this_transfer('<?=$p->stm_id;?>')" data-toggle="tooltip"  data-placement="center" title="GRN" ><i class="fa fa-check" aria-hidden="true"></i>APPROVE GRN</a>
               </div>
               <?php } ?>
            </div>
    
    
            
            </div>
              </div>
            </div>
            <!-------------------- -->
         
            </div> 
            
            
            
            
            
            
            
            
            
            
            
            
            
           </div>
            
           
        
           
        <!-- end: DYNAMIC TABLE PANEL --> 
      </div>
    </div>
    
    <!-- end grid --> 
    
  </div>
  <!-- end: PAGE --> 
</div>
<!-- end: MAIN CONTAINER --> 
<!-- start: FOOTER -->
<div class="footer clearfix">
  <div class="footer-inner"> 2014 &copy; clip-one by cliptheme. </div>
  <div class="footer-items"> <span class="go-top"><i class="clip-chevron-up"></i></span> </div>
</div>
<!-- end: FOOTER --> 
<!-- start: RIGHT SIDEBAR --> 
<!-- end: RIGHT SIDEBAR -->
<div id="event-management" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
        <h4 class="modal-title">Event Management</h4>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-light-grey"> Close </button>
        <button type="button" class="btn btn-danger remove-event no-display"> <i class='fa fa-trash-o'></i> Delete Event </button>
        <button type='submit' class='btn btn-success save-event'> <i class='fa fa-check'></i> Save </button>
      </div>
    </div>
  </div>
</div>
<input name="sales-rtn-val-cost" type="text" id="sales-rtn-cost-fld" value="0">
<input name="sales-rtn-val-fld" type="text" id="sales-rtn-val-fld" value="0">
<input name="sales-val-cost" type="text" id="sales-cost-fld" value="0">
<input name="sales-val-fld" type="text" id="sales-val-fld" value="0">
<input name="sale_prof" type="hidden" id="sale_prof" value="0">
<input name="return_prof" type="hidden" id="return_prof" value="0">
<!-- start ajax model -->
<div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
<!-- end ajax model --> 

<!-- start: MAIN JAVASCRIPTS -->
<?php $this->load->view("common/footer"); ?>
<script src="<?php echo asset_url(); ?>js/jquery-ui.js" ></script> 
<script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datepicker.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script> 
<!-- end: MAIN JAVASCRIPTS --> 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script> 
<script src="<?php echo asset_url(); ?>/plugins/jquery-inputlimiter/jquery.inputlimiter.1.3.1.min.js"></script> 
<script src="<?php echo asset_url(); ?>/plugins/autosize/jquery.autosize.min.js"></script> 
<script src="<?php echo asset_url(); ?>/plugins/select2/select2.min.js"></script> 
<script src="<?php echo asset_url(); ?>/plugins/jquery.maskedinput/src/jquery.maskedinput.js"></script> 
<script src="<?php echo asset_url(); ?>/plugins/jquery-maskmoney/jquery.maskMoney.js"></script> 
<script src="<?php echo asset_url(); ?>/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> 
<script src="<?php echo asset_url(); ?>/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script> 
<script src="<?php echo asset_url(); ?>/plugins/bootstrap-daterangepicker/moment.min.js"></script> 
<script src="<?php echo asset_url(); ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script> 
<script src="<?php echo asset_url(); ?>/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> 
<script src="<?php echo asset_url(); ?>/plugins/bootstrap-colorpicker/js/commits.js"></script> 
<script src="<?php echo asset_url(); ?>/plugins/jQuery-Tags-Input/jquery.tagsinput.js"></script> 
<script src="<?php echo asset_url(); ?>/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script> 
<script src="<?php echo asset_url(); ?>/plugins/summernote/build/summernote.min.js"></script> 
<script src="<?php echo asset_url(); ?>/plugins/ckeditor/ckeditor.js"></script> 
<script src="<?php echo asset_url(); ?>/plugins/ckeditor/adapters/jquery.js"></script> 
<script src="<?php echo asset_url(); ?>/js/form-elements.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script> 
<script>
		
		var form_submit;
		function printDiv(divName) {
             var printContents = document.getElementById(divName).innerHTML;
             var originalContents = document.body.innerHTML;
             document.body.innerHTML = printContents;
             window.print();
            document.body.innerHTML = originalContents;
        }
		

				
			jQuery(document).ready(function() {
			    //loadGrid();
			});

		function loadGrid() {
		    var id=$('#odr_id').val();
					    $('#warehouse_table_1').DataTable({
					        "ajax": "<?php echo base_url('stock_transfer/get_details_transfer_item_list?id=')?>"+id,
					        "data": {
							   id: id,
							},
					        oLanguage: {
                            sProcessing: '<div class="loader" id="loader"></div><div><h1>Loading......</h1></div>'
                            },
                            "processing": true,
					        "bDestroy": true,
							//"serverSide": true,
					        "iDisplayLength": 20,
							"order": false, "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                var pq = 0, sq = 0, bq = 0, pa = 0, grand_tot = 0, tech_tot = 0, parts_tot=0 , ser_tot=0;
				var ser_tot3=0;
				var ser_tot2=0;
				var ser_tot1=0;
				var ser_tot4=0;
                for (var i = 0; i < aaData.length; i++) {
                   // p = (aaData[aiDisplay[i]][2]).split('__');
					ser_tot1 += parseFloat(aaData[[i]][4]);
					ser_tot2 += parseFloat(aaData[[i]][5]);
                }
                var nCells = nRow.getElementsByTagName('th');
				nCells[4].innerHTML = '<div class="text-right">'+accounting.formatMoney(ser_tot1, "", 3, ",", ".")+' </div>';
				nCells[5].innerHTML = '<div class="text-right">'+accounting.formatMoney(ser_tot2, "", 2, ",", ".")+' </div>';
			 }
			});
		}
		
	function grn_this_transfer(id) {
    bootbox.confirm({
        title: "Are You Sure ?",
        message: "Do you want to GRN this transfer ?.",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> No Cancel'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Yes Confirm'
            }
        },
        callback: function(result) {
            if (result == true) {
                jQuery.ajax({
                    type: "POST", 
                    url: "<?php echo base_url().'apitrns/grn_transfer?id='?>" + id,
                           data: 'id='+id,
                    cache: false,
                    success: function(response) {
                        var obj = JSON.parse(response);
                        if (obj.status == 1) {
                            //------------------------
                            /*
                            jQuery.ajax({
                    type: "POST", 
                    //url: "http://admin.isurufc.newviableerp.com/stock_transfer/update_grn_recode?id="+ id,
                    url: "http://apiadmin.isurufc.newviableerp.com/index.php/api/stock_transfer/reomte_update_grn_recode?id="+ id,
                           data: 'id='+id,
                    cache: false,
                    success: function(response) {
                        var obj = JSON.parse(response);
                        if (obj.status == 1) {} else {
                            bootbox.alert({
                                message: obj.message,
                                size: 'small'
                            });
                        }
                        //loadGrid();
                    }
                });
                       */     
                            //-------------------------
                        } else {
                            bootbox.alert({
                                message: obj.message,
                                size: 'small'
                            });
                        }
                        loadGrid();
                    }
                });
            }
        }
    });
}

function grn_this_transfer(id) {
    bootbox.confirm({
        title: "Are You Sure ?",
        message: "Do you want to GRN this transfer ?.",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> No Cancel'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Yes Confirm'
            }
        },
        callback: function(result) {
            if (result == true) {
                jQuery.ajax({
                    type: "POST", 
                    url: "<?php echo base_url().'apitransfer/grn_transfer?id='?>" + id,
                           data: 'id='+id,
                    cache: false,
                    success: function(response) {
                        var obj = JSON.parse(response);
                        if (obj.status == 1) {
                            //------------------------
                            /*
                            jQuery.ajax({
                    type: "POST", 
                    //url: "http://admin.isurufc.newviableerp.com/stock_transfer/update_grn_recode?id="+ id,
                    url: "http://apiadmin.isurufc.newviableerp.com/index.php/api/stock_transfer/reomte_update_grn_recode?id="+ id,
                           data: 'id='+id,
                    cache: false,
                    success: function(response) {
                        var obj = JSON.parse(response);
                        if (obj.status == 1) {} else {
                            bootbox.alert({
                                message: obj.message,
                                size: 'small'
                            });
                        }
                        //loadGrid();
                    }
                });
                       */     
                            //-------------------------
                        } else {
                            bootbox.alert({
                                message: obj.message,
                                size: 'small'
                            });
                        }
                        //loadGrid();
                    }
                });
            }
        }
    });
}
				
	
      
    


</script>
</body>
<!-- end: BODY -->
</html>