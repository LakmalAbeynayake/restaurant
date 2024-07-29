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
</style>
<style>
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
          <li> <a href="<?php echo base_url('dashboard'); ?>"> DASHBOARD </a> </li>
          <li> <a href="#"> TRANSFER </a> </li>
          <li class="active"> NEW TRANSFER  </li>
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
          <h3> NEW TRANSFER (RAW MATERIALS) </h3>
        </div>
        <p>Please use the table below to navigate or filter the results. </p>
      </div>
    </div>
    <!-- end: PAGE HEADER --> 
    <!-- start: PAGE CONTENT 
                    <!-- start grid -->
    <div class="row">
      <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
          <div class="panel-heading"> <i class="fa fa-external-link-square"></i>  NEW TRANSFER  (RAW MATERIALS)
            <div class="panel-tools" style="top:2px;">
              <button onClick="printDiv('printableArea')" class="btn btn-blue dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-print"></i> </button>
            </div>
          </div>
        </div>
        <div class="panel-body">
          <div id="error"></div>
          <div class="col-md-12">
            
            <!-------------------- -->
            <div class="panel panel-default">
              <div style="font-weight: 700;" class="panel-heading"> NEW TRANSFER  (RAW MATERIALS)</div>
              <div class="panel-body"> 
               <form action = "#" method = "post"  id="form_add_new_bulk_master" name="form_add_new_bulk_master" >
                   
                   
              <div class="col-sm-3">
              <div class="form-group">
                <label>WAREHOUSE * </label>
                <select id="warehouse_id" class="form-control search-select" name="warehouse_id">
                  <option value="">-- Select Warehouse --</option>
                  <?php     $ss_warehouse_id=$this->session->userdata('ss_warehouse_id'); 
                            foreach ($warehouse_list as $row)
                            {	
                                $sel='';
							    if($ss_warehouse_id==$row->id){
									$sel=' selected="selected"';
							}?>
                  <option value="<?php echo $row->id; ?>" <?php echo $sel ?> > <?php echo $row->name; ?> </option>
                  <?php }?>
                </select>
              </div>
            </div>
            
              <div class="col-sm-3">
              <div class="form-group">
                <label>TRANSFER TO * </label>
                <select id="odr_type" class="form-control search-select" name="odr_type" onChange="remove_selected_price_type()">
                  <option value=""> - Select Destination -</option>
                  <?php   
                            foreach ($outlet_list as $row)
                            {
                          
                            ?>
                  <option value="<?php echo $row->outlet_code; ?>"  > <?php echo $row->outlet_code; ?> </option>
                  <?php }?>
                </select>
              </div>
            </div>
    
                    
                     <div class="col-sm-2 ">
                  <div class="form-group">
                    <label>REFERANCCE NO *  </label>
                    <input id="ref_no" name="ref_no" type='text' class="form-control" value=""/>
                  </div>
                </div>
                
                <div class="col-sm-12 ">
                  <div class="form-group">
                    <label>NOTE  </label>
                    <textarea id="note" name="note" rows="4" cols="50" class="form-control"></textarea>
                  </div>
                </div>
                
                
                 <div class="col-sm-3 pull-right" >
                  <div class="form-group">
                    <label>&nbsp;&nbsp; </label>
                    <input type="submit" name="add_category" value="START NEW TRANSFER" class=" form-control btn btn-primary">
                  </div>
                </div>
                  </form>
              </div>
            </div>
            <!-------------------- -->
          
            
            </div> 
            
            
            
            
           </div>
            
          
        
            
             
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
		
		
	
			jQuery(document).ready(function() {
				FormElements.init();
			});

$(".js-data-customer-sn-ajax").select2({
        ajax: {
			'type': 'POST',
				'url': '<?php echo base_url('order/get_customer_dynamic');?>',
                dataType: 'json',
                delay: 0,
                data: function (query) {
							//alert(1);
                if (!query)
                        query = '';
                return {
                search_string: query,
				 //cat_srh: $("#cat_srh").val(),
				 // subcategory: $("#subcategory").val(),
                        format: 'json'
                };
                },
                results: function (data) {
                return {
                results: $.map(data, function (item) {
                return {
					//alert();
                text: item.cus_name+' ('+item.cus_code+')',
                        slug: item.cus_id,
                        id: item.cus_id
                };
                })
                };
                },
                cache: true
         }
        });
        
        
        
        
        $(".js-data-sale-rep-sn-ajax").select2({
        ajax: {
			'type': 'POST',
				'url': '<?php echo base_url('order/get_user_dynamic');?>',
                dataType: 'json',
                delay: 0,
                data: function (query) {
							//alert(1);
                if (!query)
                        query = '';
                return {
                search_string: query,
				 //cat_srh: $("#cat_srh").val(),
				 // subcategory: $("#subcategory").val(),
                        format: 'json'
                };
                },
                results: function (data) {
                return {
                results: $.map(data, function (item) {
                return {
					//alert();
                text: item.user_first_name+' '+item.user_last_name,
                        slug: item.user_id,
                        id: item.user_id
                };
                })
                };
                },
                cache: true
         }
        });
        
        
        
         $(".js-data-order-price-type-sn-ajax").select2({
        ajax: {
			'type': 'POST',
				'url': '<?php echo base_url('order/get_order_price_type_dynamic');?>',
                dataType: 'json',
                delay: 0,
                data: function (query) {
							//alert(1);
                if (!query)
                        query = '';
                return {
                search_string: query,
				 order_type: $("#odr_type").val(),
				 // subcategory: $("#subcategory").val(),
                        format: 'json'
                };
                },
                results: function (data) {
                return {
                results: $.map(data, function (item) {
                return {
					//alert();
                text: item.pri_type_name,
                        slug: item.pri_type_id,
                        id: item.pri_type_id
                };
                })
                };
                },
                cache: true
         }
        });
        
        
        function remove_selected_price_type(){
            $('#odr_price_type_id').val('');
// alert();
        }
        
        
        
        
        $(function () {
        $('#form_add_new_bulk_master').on('submit', function (e) {
          e.preventDefault();
          $.ajax({
            type: 'post',
            url: '<?php echo base_url();?>stock_m_transfer/save_trasfer_master',
            data: $('form').serialize(),
            success: function (data) {
              	var obj = jQuery.parseJSON( data );
              	if(obj.status==1){
              	 displayNotice( 'page', 'successfully added!' );
				  window.location.replace("<?php echo base_url().'stock_m_transfer/add_transfer_items?id='?>"+obj.result);
              	}else{
              	    bootbox.alert({
                    message: obj.validation,
                    className: 'rubberBand animated'
                    })
              	}
            }
          });
        });
      });
      
      
     



</script>
</body>
<!-- end: BODY -->
</html>