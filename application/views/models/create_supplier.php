		<style type="text/css">
			body .modal {
	    /* new custom width */
	    width: 750px;
	    /* must be half of the width, minus scrollbar on the left (30px) */
	    margin-left: -375px;
			}
			</style>
<form role="form" class="form-horizontal" id="create_supplier_form" action="#" method="post">
<input type="hidden" value="<?php echo $type;?>" name="type" id="type"/>
<input type="hidden" value="<?php echo $supp_id;?>" name="supp_id" id="supp_id"/>
<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?php echo $pageName ?></h4>
            <font style="color:#333;">Please fill in the information below. The field labels marked with * are required input fields.</font>
            </div>
              
            <div class="modal-body">
             <div id="error"></div>
                <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                    <div class="form-group">
                        <h5>
                        <label class="control-label">
							Code *
						</label></h5>
                        
                            <input type="text" <?php echo (isset($suppliyer['supp_code']))?'value="'.$suppliyer['supp_code'].'"':null;?> class="form-control" name="supp_code" id="supp_code" <?php if (isset($type)) if($type=='E') echo 'readonly';?>>
                       
                    </div>
                    
                    <div class="form-group">
                        <h5>
                        <label class="control-label">
							Company Name*
						</label></h5>
                        
                            <input type="text" <?php echo (isset($suppliyer['supp_company_name']))?'value="'.$suppliyer['supp_company_name'].'"':null;?> class="form-control" name="supp_company_name" id="supp_company_name">
                       
                    </div>
                    <div class="form-group">
  						 <h5>Address </h5>
                        
                            <input type="text" <?php echo (isset($suppliyer['supp_address']))?'value="'.$suppliyer['supp_address'].'"':null;?>  class="form-control" name="supp_address" id="supp_address">
                      
                    </div>
                    <div class="form-group">
						<h5>Company Phone </h5>
                       
                            <input type="text" <?php echo (isset($suppliyer['supp_company_phone']))?'value="'.$suppliyer['supp_company_phone'].'"':null;?>  class="form-control" name="supp_company_phone" id="supp_company_phone">
                        
                        </div>
                        <div class="form-group">
 					<h5>Country *</h5>

                            <select class="select2-container form-control search-select" id="country_id" name="country_id">
                            <option value="">&nbsp;</option>
							<?php 
                            foreach ($country_list as $row)
                            {
								$sel='';
								if(isset($suppliyer['country_id'])){
									if($suppliyer['country_id']==$row['country_id']){
										$sel=' selected="selected"';
									}
								}else if(251==$row['country_id']){
										$sel=' selected="selected"';
									}
                            ?>       
                                <option<?php echo $sel;?> value="<?php echo $row['country_id'];?>"><?php echo $row['country_short_name']; ?></option>
                             <?php }  ?>
                             </select>
                        </div>
                        <div class="form-group">
                        <h5>City </h5>
                       
                            <input type="text" <?php echo (isset($suppliyer['supp_city']))?'value="'.$suppliyer['supp_city'].'"':null;?>  class="form-control" name="supp_city" id="supp_city">
                      
                        </div>
                        <div class="form-group">
                        <h5>State </h5>
                       
                            <input type="text" <?php echo (isset($suppliyer['supp_state']))?'value="'.$suppliyer['supp_state'].'"':null;?> class="form-control" name="supp_state" id="supp_state">
                       
                        </div>
                        <div class="form-group">
                        <h5>Postal Code </h5>
                       
                            <input type="text" <?php echo (isset($suppliyer['supp_postal_code']))?'value="'.$suppliyer['supp_postal_code'].'"':null;?>  class="form-control" name="supp_postal_code" id="supp_postal_code">
                        
                        </div>
                        
                        <div class="form-group">
                         <h5>Fax </h5>
                            <input type="text" <?php echo (isset($suppliyer['supp_fax']))?'value="'.$suppliyer['supp_fax'].'"':null;?>  class="form-control" name="supp_fax" id="supp_fax">
                        </div>
                        
                        
                    </div>
                    
                    
                    
                    <div class="col-md-5 pull-right">
                    <div class="form-group">
                        <h5>Email Address </h5>
                            <input type="text" <?php echo (isset($suppliyer['supp_email']))?'value="'.$suppliyer['supp_email'].'"':null;?>  class="form-control" name="supp_email" id="supp_email">
    				</div>
                    <div class="form-group">
                     <h5>Credit Limit </h5>
                            <select class="form-control" id="cr_limit_id" name="cr_limit_id">
                            <option value="">&nbsp;</option>
							<?php 
                            foreach ($cr_limit_list as $row)
                            {
								$sel='';
								if(isset($suppliyer['cr_limit_id'])){
									if($suppliyer['cr_limit_id']==$row->cr_limit_id){
										$sel=' selected="selected"';
									}
								}
                            ?>       
                                
                                <option<?php echo $sel;?> value="<?php echo $row->cr_limit_id; ?>"><?php echo $row->cr_limit_name; ?></option>
                             <?php }  ?>
                             </select>
                        
                            </div>
                            <div class="form-group">            
                        <h5>Bank </h5>
                        
                            <input type="text" <?php echo (isset($suppliyer['supp_bank']))?'value="'.$suppliyer['supp_bank'].'"':null;?>  class="form-control" name="supp_bank" id="supp_bank">
                      
                        </div>
                        <div class="form-group">
                         <h5>Branch </h5>
                       
                            <input type="text" <?php echo (isset($suppliyer['supp_bank_branch']))?'value="'.$suppliyer['supp_bank_branch'].'"':null;?>  class="form-control" name="supp_bank_branch" id="supp_bank_branch">
                        
                        </div>
                        <div class="form-group">
                         <h5>Account Number  </h5>
                       
                            <input type="text" <?php echo (isset($suppliyer['supp_account_number']))?'value="'.$suppliyer['supp_account_number'].'"':null;?>  class="form-control" name="supp_account_number" id="supp_account_number">
                       
                        </div>
                        <div class="form-group">
                          <h5>Credit Period </h5>
                      
                            <input type="text" <?php echo (isset($suppliyer['supp_credit_period']))?'value="'.$suppliyer['supp_credit_period'].'"':null;?>  class="form-control" name="supp_credit_period" id="supp_credit_period">
                       
                        </div>
                        <div class="form-group">
                         <h5>Contact Person Name </h5>
                       
                            <input type="text" <?php echo (isset($suppliyer['supp_contact_person_name']))?'value="'.$suppliyer['supp_contact_person_name'].'"':null;?> class="form-control" name="supp_contact_person_name" id="supp_contact_person_name">
                       
                        </div>
                        <div class="form-group">  
                         <h5>Contact Person Phone </h5>
                        
                            <input type="text" <?php echo (isset($suppliyer['supp_contact_person_phone']))?'value="'.$suppliyer['supp_contact_person_phone'].'"':null;?>  class="form-control" name="supp_contact_person_phone" id="supp_contact_person_phone">
                       
                        </div>
                        <div class="form-group">
                         <h5>Contact Person Email </h5>
                        
                            <input type="text" <?php echo (isset($suppliyer['supp_contact_person_email']))?'value="'.$suppliyer['supp_contact_person_email'].'"':null;?>  class="form-control" name="supp_contact_person_email" id="supp_contact_person_email">
                        
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
		<script src="<?php echo asset_url(); ?>js/form-validation-create_supplier.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
        

                        
		<script>
			jQuery(document).ready(function() {
				FormValidator.init();
				$("#country_id").select2();
				
				//add another one
				/*
				$( "#conirm" ).click(function() {
					var sel_id=$('#sel_id').val(); 
					var popup_type=$('#popup_type').val();
					var page=$('#page').val();
					var supp_id=sel_id;
					
					if(popup_type=='add_new'){
						$('#ajax-modal').modal('hide');
						$('body').modalmanager('loading');
							setTimeout(function () {
								$modal.load('<?php echo base_url("suppliers/create_supplier"); ?>', '', function () {
									$modal.modal();
								});
							}, 1000);
						loadGrid();	
					}
				});
				*/
			});
			
		</script>
        
<script type="text/javascript">
function insertSupplierData(){
var type=$('#type').val();
var supp_id=$('#supp_id').val();
var cr_limit_id=$('#cr_limit_id').val();
var country_id=$('#country_id').val();	
var supp_company_name 	= $('#supp_company_name').val();
var supp_company_phone=$('#supp_company_phone').val();
var supp_city=$('#supp_city').val();
var supp_state=$('#supp_state').val();
var supp_fax=$('#supp_fax').val();
var supp_postal_code=$('#supp_postal_code').val();
var supp_address=$('#supp_address').val();
var supp_email=$('#supp_email').val();
var supp_contact_person_name=$('#supp_contact_person_name').val();
var supp_contact_person_phone=$('#supp_contact_person_phone').val();
var supp_contact_person_email=$('#supp_contact_person_email').val();
var supp_bank=$('#supp_bank').val();
var supp_bank_branch=$('#supp_bank_branch').val();
var supp_account_number=$('#supp_account_number').val();
var supp_credit_period=$('#supp_credit_period').val();
var supp_code=$('#supp_code').val();	
	 
	$.post( "<?php echo base_url("suppliers/save_supplier"); ?>", {type:type, supp_id:supp_id, cr_limit_id:cr_limit_id, country_id:country_id, supp_company_name:supp_company_name, supp_company_phone:supp_company_phone, supp_city:supp_city, supp_state:supp_state, supp_fax:supp_fax, supp_postal_code:supp_postal_code, supp_postal_code:supp_postal_code, supp_address:supp_address, supp_email:supp_email, supp_contact_person_name:supp_contact_person_name, supp_contact_person_phone:supp_contact_person_phone, supp_contact_person_email:supp_contact_person_email, supp_bank:supp_bank, supp_bank_branch:supp_bank_branch, supp_account_number:supp_account_number, supp_credit_period:supp_credit_period, supp_code:supp_code})
	  .done(function( data ) {
		
	  var obj = jQuery.parseJSON(data);
	  
	  
	    //alert(obj.status); //last id
	    if (obj.status==0) 
	{
		$('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>'+obj.validation+'</div>');
		$('body').modalmanager('removeLoading');
		$('body').attr('class','');
	}
	 else {
	  
	 // $('#ajax-modal').modal('hide');
	   $('div#ajax-modal').modal('hide');

	  loadGrid();// load supplier data
		
	  if(obj.type=='E'){
		 displayNotice('page','Supplier has been updated successfully!');
	  }
	  if(obj.type=='A'){
		displayNotice('page','Supplier has been added successfully!'); 
		document.getElementById("create_supplier_form").reset();
	  }
	}
	  });
return false;
}
    </script>
