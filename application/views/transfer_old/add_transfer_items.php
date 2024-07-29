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
          <li> <a href="#"> ORDER</a> </li>
          <li class="active"> NEW ORDER </li>
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
          <h4> ADD ORDER ITEMS </h4>
          </div>
        
              
              
              <div class="well well-sm">                      

<div class="col-xs-4 border-right">
<div class="col-xs-2"><i class="fa fa-3x fa-file-text-o padding010 text-muted"></i></div>
<div class="col-xs-10">
<h4 class="">ORDER NO : <?php echo $details['stm_no'];?></h4>
REFERANCE NO : <?php echo $details['stm_ref_no'];?> <br>
DATE : <?php echo $details['stm_date_time'];?> </p>
</div>
<div class="clearfix"></div>
</div>

<div class="col-xs-4 border-right">
<div class="col-xs-2"><i class="fa fa-3x fa-user padding010 text-muted"></i></div>
<div class="col-xs-10">
<h4 class=""><?php echo $details['stm_to_id']; ?></h4>
<p><?php //echo $details['cus_code']; ?></p>

</div>
<div class="clearfix"></div>
</div>

<div class="col-xs-4">
<div class="col-xs-2"><i class="fa fa-3x fa-building-o padding010 text-muted"></i></div>
<div class="col-xs-10">
<h4 class=""><?php echo $details['name']; ?></h4>
<p>USER : <?php echo $details['user_first_name']." ".$details['user_last_name']; ?></p>
</div>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div> <!--col-xs-4-->
    
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
            
            <!-------------------- -->
            <div class="panel panel-default">
              <div style="font-weight: 700;" class="panel-heading"> SELECT ORDER ITEM </div>
              <div class="panel-body"> 
               <form action = "#" method = "post"  id="form_bulk_items" name="form_bulk_items" >
                 <div class="col-md-7">
                  <div class="form-group">
                     <label>PRODUCT  </label>
                    <input  type="hidden" id="product_id"  name="product_id" class="js-data-product-sn-ajax form-control" style="padding:0px 0px; border: none; box-shadow: none" placeholder="-Select Item-" /><!--onChange="setitemselect()"-->
                     <input id="odr_id" name="odr_id" type='hidden' class="form-control" value="<?php echo $stm_id;?>"/>
                     </div>
                    </div>
                    
                    
                <div class="col-sm-2">
                  <div class="form-group">
                    <label> QUANTITY  </label>
                    <input id="req_qty" name="req_qty" type='text' class="form-control" value=""/>
                  </div>
                </div>
                 <div class="col-sm-1 pull-right" >
                  <div class="form-group">
                    <label>&nbsp;&nbsp; </label>
                    <input type="submit" name="add_category" value="ADD" class=" form-control btn btn-primary">
                  </div>
                </div>
                  </form>
                  </div>
                  </div>
                  
            <table class="table table-bordered table-condensed table-hover table-striped dataTable" id="warehouse_table_1">
              <thead>
                <tr>
                  <th>CODE</th>
                  <th>NAME</th>
                 
                  <th>UOM</th>
                   <!--<th>CPU</th>-->
                    <th>PRICE</th>
                   <th>QTY</th>
                   <th>COST</th>
                   <th  class="col-sm-2" >ACTION</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                 <th>CODE</th>
                  <th>NAME</th>
                 
                  <th>UOM</th>
                   <!--<th>CPU</th>-->
                    <th>PRICE</th>
                   <th>QTY</th>
                   <th>COST</th>
                   <th class="col-sm-2" >ACTION</th>
                </tr>
                 </tfoot>
            </table>
            
            <div class="panel-body">
            <div class="col-md-12"> 
             <div class=" pull-right ">
                <div class="form-group">
           <button type="button" class="btn btn-success pull-left " data-toggle="tooltip"  data-placement="center" title="FINISH MANUAL TRANSFER" onClick="final_order(<?php echo $details['stm_id']; ?>)" > <i class="fa fa-check" aria-hidden="true"></i> FINAL TRANSFER</button>
    </div>
    </div>
      <div class="col-sm-1 pull-right ">
                <div class="form-group">
            <a class="btn btn-primary pull-right " href="<?php echo base_url('oder/list_order')?>" data-toggle="tooltip"  data-placement="center" title="SAVE AS DRAFT" ><i class="fa fa-save" aria-hidden="true"></i> SAVE AS DRAFT</a>
       </div>
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
		
		function searchDetailsReset(){
		}
		function searchDetails(){
		        //load_summary();
				loadGrid();
		}
				
			jQuery(document).ready(function() {
				FormElements.init();
				//load_summary();
		        $('#product_id').select2('open');
			    loadGrid();
			});

		function loadGrid() {
		    var id=$('#odr_id').val();
					    $('#warehouse_table_1').DataTable({
					        "ajax": "<?php echo base_url('stock_transfer/get_trasferr_item_list?id=')?>"+id,
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
				
	function load_summary(){
        var srh_from_date=$('#srh_from_date').val();
		var srh_to_date=$('#srh_to_date').val();
		var srh_warehouse_id=$('#srh_warehouse_id').val();
		var product_id=$('#product_id').val();
        $.ajax({
        url:"<?php echo base_url('reports/get_product_history_sumary');?>",
        type:"POST",
        data:{
          srh_from_date: srh_from_date,srh_to_date:srh_to_date,srh_warehouse_id:srh_warehouse_id,product_id: product_id,
        },
        success:function(response) {
          var obj = JSON.parse(response);
          		$('#cost-tbl').text(accounting.formatMoney(obj.cost_total, "", 3, ",", "."));
				$('#sale-tbl').text(accounting.formatMoney(obj.sale_total, "", 3, ",", "."));
				$('#sales-rtn-val-tbl').text(accounting.formatMoney(obj.sale_return_total, "", 3, ",", "."));
				$('#sales-rtn-cost-tbl').text(accounting.formatMoney(obj.cost_return_total, "", 3, ",", "."));
				$('#profit-tbl').text(accounting.formatMoney(obj.profit, "", 3, ",", "."));
				$('#f-date-txt').text($('#srh_from_date').val());
				$('#t-date-txt').text($('#srh_to_date').val());
				$('#percentage-tbl').text(accounting.formatMoney(obj.ff_qty, "", 3, ",", "."));
       },
       error:function(){
        alert("error");
       }
      });
}

$(".js-data-product-sn-ajax").select2({
        ajax: {
			'type': 'POST',
				'url': '<?php echo base_url('stock_transfer/get_product_dynamic');?>',
                dataType: 'json',
                delay: 0,
                data: function (query) {
                if (!query)
                        query = '';
                return {
                search_string: query,
				// cat_srh: $("#cat_srh").val(),
				 // subcategory: $("#subcategory").val(),
                        format: 'json'
                };
                },
                results: function (data) {
                return {
                results: $.map(data, function (item) {
                return {
					//alert();
                text: item.product_name+' ('+item.product_code+')'+ item.batch,
                        slug: item.batch_id,
                        id: item.batch_id
                };
                })
                };
                },
                cache: true
         }
        });
        
        $(function () {
        $('#form_bulk_items').on('submit', function (e) {
          e.preventDefault();
          form_submit=$('form').serialize();
          $.ajax({
            type: 'post',
            url: '<?php echo base_url();?>stock_transfer/save_transfer_item',
            data: $('form').serialize(),
            success: function (data) {
              	var obj = jQuery.parseJSON( data );
              	if(obj.status==1){
              	 displayNotice( 'page', 'successfully added!' );
				 //window.location.reload(); 
				$("#form_bulk_items").trigger('reset');
				//$("#req_qty").blur();
				location.reload();
              	}else{
              	    if(obj.status==0){
              	        bootbox.alert({
                    message: obj.validation,
                    className: 'rubberBand animated'
                    })
              	    }else if(obj.status==2){
              	        /*-------------------------*/
              	     /* var dialog = bootbox.dialog({
    message: '<p class="text-center mb-0"><i class="fa fa-spin fa-cog"></i> Please Select Batch</p> <div class="text-center"> <hr><h4>  <input type="radio" name="batch_id" value="1"> Rs.120.00 : [25]<br>  <input type="radio" name="batch_id" value="2"> Rs.100.00 : [100]<br></h4> <hr> <button class="btn btn-primary" type="button" onclick="set_batch_id()">Submit</button></div>',
    closeButton: false
});*/


    //set_batch_id(obj.batch_list,form_submit,obj.selected_batch,obj.batch_stock,obj.request_qry);
    
              	        
              	        
              	        
              	        /*---------------------------------------------*/
              	    }
              	    
              	}
            }
          });
        });
      });
      
      function set_batch_id(batch_list,form_submit,selected_batch,batch_stock,request_qry){
     bootbox.prompt({
    title: "SELECT BATCH CODE",
    inputType: 'select',
    value: selected_batch,
    inputOptions:batch_list ,
    callback: function (result) {
        //-------------------------
        if(result){
            let selected_bath_array = batch_stock.find(o => o.batch_id === result);
            var selected_batch_stock=selected_bath_array.stock;
            if(request_qry<=selected_batch_stock){
                /*   ajex function  start */
                
                jQuery.ajax({
		type: "POST",
		url: "<?php echo base_url().'order/save_order_item_with_batch?id='?>"+result,
		data: form_submit,
		cache: false,
		success: function(response)
       {
			displayNotice('page','Successfully updated !!');
			setTimeout(function(){
				loadGrid();
				}, 1000);
			}
		});	
                
                
                 /*   ajex function  end */
            }else{
                bootbox.alert("Not Enough Stock In This Batch! <br><br><small> REQUESTED QUANTITY: "+request_qry+" <br>AVAILBLE QUANTITY: "+selected_batch_stock+"   </small>");
            }
        }
        //----------------------
    }
});
      }
      
      
       
      function update_aloacted_qty(id){
          bootbox.prompt({
    title: "Please Enter New Item Quantity",
    inputType: 'number',
    callback: function (result) {
        if(!result||result<=0){
            if(result!=null){
            alert("Check quantity");
           return false; 
        }
        }
        //----------------------------------------
        if(result>0){
        jQuery.ajax({
		type: "POST",
		url: "<?php echo base_url().'order/update_order_product_qty?id='?>"+id,
		data: {id:id,result:result},
		cache: false,
		success: function(response)
       {
			displayNotice('page','Successfully updated !!');
			setTimeout(function(){
				loadGrid();
				}, 1000);
			}
		});	
        }
        //---------------------------------------
    }
});
      }
      
  
  function update_product_price(id,qty){
          bootbox.prompt({
    title: "Please Enter New Price! ",
    inputType: 'text',
    callback: function (result) {
        if(!result||result<=0){
            if(result!=null){
            alert("Check quantity");
           return false; 
        }
        }
        //----------------------------------------
        if(result>0){
        jQuery.ajax({
		type: "POST",
		url: "<?php echo base_url().'order/update_order_product_price?id='?>"+id,
		data: {id:id,result:result,qty:qty},
		cache: false,
		success: function(response)
       {
			displayNotice('page','Successfully updated !!');
			setTimeout(function(){
				loadGrid();
				}, 1000);
			}
		});	
        }
        //---------------------------------------
    }
});
      }    
      
      
      
      
      
      function delete_item_block(id){
	    bootbox.confirm({
    title: "Do you want to remove this item? ",
    message: "Do you want to remove this item?.",
    buttons: {
        cancel: {
            label: '<i class="fa fa-times"></i> Cancel'
        },
        confirm: {
            label: '<i class="fa fa-check"></i> Yse Confirm'
        }
    },
    callback: function (result) {
        //console.log('This was logged in the callback: ' + result);
        //-----------------------------------------------------------
        if(result==true){
        jQuery.ajax({
		type: "POST",
		url: "<?php echo base_url().'stock_transfer/delete_tranfer_item?id='?>"+id,
		cache: false,
		data: {id:id},
		success: function(response)
       {
		displayNotice('page','Successfully removed !!');
		//*********************************************
		var obj = jQuery.parseJSON( response );
         loadGrid();  
		//*************************************************
	    }
		});
        }
       //---------------------------------------------------------- 
    }
});
	}
	
	
	
	
	
	
	
	
	
	

$('#product_id').on('change', function(e) {
    e.preventDefault();
  $("#req_qty").focus();
});	


function final_order(id) {
    bootbox.confirm({
        title: "Are You Sure ?",
        message: "Do you want to final this transfer ?.",
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
                    url: "<?php echo base_url().'stock_transfer/final_transfer?id='?>" + id,
                           data: 'id='+id,
                    cache: false,
                    success: function(response) {
                        var obj = JSON.parse(response);
                        if (obj.status == 1) {
                            window.location.replace("<?php echo base_url().'stock_transfer/list_transfers'?>");
                            
                        } else {
                            bootbox.alert({
                                message: obj.validation,
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