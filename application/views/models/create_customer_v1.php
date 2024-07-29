<form role="form" class="form-horizontal" id="create_customer_form" action="#" method="post">
<input type="hidden" value="<?php echo $type;?>" name="type" id="type"/>
<input type="hidden" value="<?php echo $cus_id;?>" name="cus_id" id="cus_id"/>
<form role="form" class="form-horizontal" id="create_customer_form" action="#">

<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?php echo $pageName ?></h4>
            <font style="color:#333;">Please fill in the information below. The field labels marked with * are required input fields.</font>
            </div>
    <div class="col-md-12">
        <div class="errorHandler alert alert-danger no-display">
            <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
        </div>
        <div class="successHandler alert alert-success no-display">
            <i class="fa fa-ok"></i> Your form validation is successful!
        </div>
    </div>    
            
            <div class="modal-body">
            <div id="error"></div>
                <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                    <div class="form-group">
                        <h5>Code *</h5>
                            <input type="text" class="form-control" name="cus_code" id="cus_code" <?php echo (isset($customer['cus_code']))?'value="'.$customer['cus_code'].'"':null;?>>
                       </div>
                       <div class="form-group">
                        <h5>Name *</h5>
                       
                            <input type="text" class="form-control" name="cus_name" id="cus_name" <?php echo (isset($customer['cus_name']))?'value="'.$customer['cus_name'].'"':null;?>>
                        </div>
                        <div class="form-group">
                        <h5>Email Address *</h5>
                       
                            <input type="text" class="form-control" name="cus_email" id="cus_email" <?php echo (isset($customer['cus_email']))?'value="'.$customer['cus_email'].'"':null;?>>
                       </div>
                       <div class="form-group">
                        <h5>Phone *</h5>
                      
                            <input type="text" class="form-control" name="cus_phone" id="cus_phone" <?php echo (isset($customer['cus_phone']))?'value="'.$customer['cus_phone'].'"':null;?>>
                        </div>
                        <div class="form-group">
   						 <h5>Address *</h5>
                      
                            <input type="text" class="form-control" name="cus_address" id="cus_address" <?php echo (isset($customer['cus_address']))?'value="'.$customer['cus_address'].'"':null;?>>
                       
                        </div>
                    </div>
                    <div class="col-md-5 pull-right">
                       <div class="form-group">                     
                        <h5>City </h5>
                      
                            <input type="text" class="form-control" name="city_name" id="city_name" <?php echo (isset($customer['city_name']))?'value="'.$customer['city_name'].'"':null;?>>
                        </div>
                        <div class="form-group">
                        <h5>State </h5>
                       
                            <input type="text" class="form-control" name="cus_state" id="cus_state" <?php echo (isset($customer['cus_state']))?'value="'.$customer['cus_state'].'"':null;?>>
                       </div>
                       <div class="form-group">
                        <h5>Postal Code </h5>
                        
                            <input type="text" class="form-control" name="cus_postal_code" id="cus_postal_code" <?php echo (isset($customer['cus_postal_code']))?'value="'.$customer['cus_postal_code'].'"':null;?>>
                        </div>
                        <div class="form-group">
                        <h5>Country </h5>
                        
                            <select class="select2-container form-control search-select" id="country_id" name="country_id">
                            <option value="">-- Select Country --</option>
							<?php 
                            foreach ($country_list as $row)
                            {
								$sel='';
								$seldef='';
								if(isset($customer['country_id'])){
									if($customer['country_id']==$row['country_id']){
										$sel=' selected="selected"';
									}
								}else if($row['country_id']==251){
									$seldef=' selected="selected"';
								}
                            ?>       
                                <option<?php echo $sel;?><?php echo $seldef ?> value="<?php echo $row['country_id'];?>"><?php echo $row['country_short_name']; ?></option>
                             <?php }  ?>
                             </select>
                        </div>
                    </div>
                </div>
                
                </div> <!--col-md-12-->
            </div>
            <div class="modal-footer">
            <input type="submit" name="add_category" value="<?php echo $btnText; ?>" class="btn btn-primary">
            </div>
</form>
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION -->
		<script src="<?php echo asset_url(); ?>js/form-validation-create_customer.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
                        
		<script>
			jQuery(document).ready(function() {
				FormValidator.init();
				$("#country_id").select2();
			});
		</script>
        
<script type="text/javascript">
function insertCustomerData(){
var type=$('#type').val();
var cus_id=$('#cus_id').val();
var country_id=$('#country_id').val();
var city_name=$('#city_name').val();	
var cus_name=$('#cus_name').val();
var cus_code=$('#cus_code').val();
var cus_email=$('#cus_email').val();
var cus_phone=$('#cus_phone').val();	
var cus_address=$('#cus_address').val();
var cus_state=$('#cus_state').val();
var cus_postal_code=$('#cus_postal_code').val();

				 
	$.post( "customers/save_customer", {type:type, cus_id:cus_id, country_id:country_id, city_name:city_name, cus_name:cus_name, cus_code:cus_code, cus_email:cus_email, cus_phone:cus_phone, cus_address:cus_address, cus_state:cus_state, cus_postal_code:cus_postal_code })
	  .done(function( data ) {
		
	  var obj = jQuery.parseJSON(data);
	  
	  // alert(obj.type); //last id
	  
	  $('#ajax-modal').modal('hide');
	  loadGrid();// load customer data
		
	  if(obj.type=='E'){
		 displayNotice('page','Customer has been updated successfully!');
	  }
	  if(obj.type=='A'){
		displayNotice('page','Customer has been added successfully!')  ;
	  }
	  });
return false;
}
    </script>