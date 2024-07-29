		<style type="text/css">
			body .modal {
	    /* new custom width */
	    width: 750px;
	    /* must be half of the width, minus scrollbar on the left (30px) */
	    margin-left: -375px;
			}
			</style>
            <form role="form" class="form-horizontal" id="create_warehouse_form" action="#" method="post">
<input type="hidden" value="<?php echo $type;?>" name="type" id="type"/>
<input type="hidden" value="<?php echo $warehouse_id;?>" name="warehouse_id" id="warehouse_id"/>
<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?php echo $pageName ?></h4>
            <font style="color:#333;">Please fill in the information below. The field labels marked with * are required input fields.</font>
            </div>
    <div class="col-md-12">
        <div class="errorHandler alert alert-danger no-display">
            <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
        </div>
    </div>              
            <div class="modal-body">
                <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                    <div class="form-group">
                        <h5>
                        <label class="control-label">
							 Name*
						</label></h5>
                            <input type="text" <?php echo (isset($warehouse_list['name']))?'value="'.$warehouse_list['name'].'"':null;?> class="form-control" name="name" id="name">
                    </div>
                    <div class="form-group">
                        <h5>
                        <label class="control-label">
							 Code*
						</label></h5>
                            <input type="text" <?php echo (isset($warehouse_list['code']))?'value="'.$warehouse_list['code'].'"':null;?> class="form-control" name="code" id="code">
                    </div>
                    
                    <div class="form-group">
                        <h5>
                        <label class="control-label">
							 Phone*
						</label></h5>
                            <input type="text" <?php echo (isset($warehouse_list['phone']))?'value="'.$warehouse_list['phone'].'"':null;?> class="form-control" name="phone" id="phone">
                    </div>
                    
                    <div class="form-group">
                        <h5>
                        <label class="control-label">
							 Email
						</label></h5>
                            <input <?php echo (isset($warehouse_list['email']))?'value="'.$warehouse_list['email'].'"':null;?> type="text" class="form-control" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <h5>
                        <label class="control-label">
							 Address
						</label></h5>
                            <input <?php echo (isset($warehouse_list['address']))?'value="'.$warehouse_list['address'].'"':null;?> type="text" class="form-control" name="address" id="address">
                    </div>
                    
                    
                    
                    
                    
                                                       
                   
                    
                     <div class="form-group">
                        <h5>
                        <label class="control-label">
							 Type
						</label></h5>
                        <?php //echo 'type:'.$warehouse_list['warehouses_type']; ?>
                           <select id="warehouses_type" class="form-control" name="warehouses_type">
                                                                <?php 
					$sel_c='';
					$sel_r='';
				
				
					
					if(isset($warehouse_list['warehouses_type']) && $warehouse_list['warehouses_type']==1){
						$sel_c=' selected';
					}
					if(isset($warehouse_list['warehouses_type']) && $warehouse_list['warehouses_type']==2){
						$sel_r=' selected';
					}
					
				?> 
                <option value="">-Select-</option>
                  <option value="1"<?php echo $sel_c; ?>>Department</option>
                  <option value="2"<?php echo $sel_r; ?>>Outlet</option>
               
                  
								                             </select>
                    </div>  
                    
                     </div>                                 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <input type="submit" name="add_category" value="<?php echo $btnText; ?>" class="btn btn-primary">
            </div>
            </div> <!--/.col-md-12-->
</form>

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
<script src="<?php echo asset_url(); ?>js/form-validation-create_warehouse.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->

	<script>
        jQuery(document).ready(function() {
            FormValidator.init();
        });
    </script>
    
<script type="text/javascript">
function insertWarehouseData(){
//	alert(22);


var type=$('#type').val();

var name=$('#name').val();
var code=$('#code').val();
var warehouse_id=$('#warehouse_id').val();
var phone=$('#phone').val();
var email=$('#email').val();
var address=$('#address').val();
var warehouses_type=$('#warehouses_type').val();
					 
	$.post( "warehouse/save_warehouse", {type:type, warehouse_id:warehouse_id, name:name, code:code, phone:phone, email:email, address:address, warehouses_type:warehouses_type })
	.done(function( data ) {
		
	  var obj = jQuery.parseJSON(data);
	   // alert(obj.type); //last id

	  $('div#ajax-modal').modal('hide');
	  loadGrid();// load location data
	  
	  if(obj.type=='E'){
		  
		   displayNotice('page','Warehouse has been updated successfully!')
	  }
	  if(obj.type=='A'){
		  displayNotice('page','Warehouse has been added successfully!')  
			
	  }
	  
	  })
	    .fail(function() {
    //alert( "error" );
  })
  .always(function() {
    //alert( "finished" );
});
	  
return false;
}
    </script>