<?php print_r($suppliyer); ?>

<form role="form" class="form-horizontal" id="create_supplier_form" action="#" method="post">

<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">UPDATE SUPPLIER</h4>
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
                <div class="row form-group">
                    <div class="col-md-6">
                        <h5>Company Name*</h5>
                        <p>
                            <input type="text" class="form-control" name="supp_company_name" id="supp_company_name">
                        </p>
  						 <h5>Address *</h5>
                        <p>
                            <input type="text" class="form-control" name="supp_address" id="supp_address">
                        </p> 
						<h5>Company Phone *</h5>
                        <p>
                            <input type="text" class="form-control" name="supp_company_phone" id="supp_company_phone">
                        </p>
                        <h5>City *</h5>
                        <p>
                            <input type="text" class="form-control" name="supp_city" id="supp_city">
                        </p>
                        <h5>State *</h5>
                        <p>
                            <input type="text" class="form-control" name="supp_state" id="supp_state">
                        </p>
                        <h5>Postal Code *</h5>
                        <p>
                            <input type="text" class="form-control" name="supp_postal_code" id="supp_postal_code">
                        </p>
                        <h5>Country *</h5>
                        <p>

                           
                            <select id="form-field-select-3" class="form-control" id="sub_cat_id" name="sub_cat_id">
							<?php 
                            $query = $this->db->query('SELECT  country_id, country_long_name FROM mstr_country ORDER BY country_long_name');
                            foreach ($query->result() as $row)
                            {
                            ?>       
                                <option id="country_id">&nbsp;</option>
                                <option id="<?php echo $row->country_id; ?>"><?php echo $row->country_long_name; ?></option>
                             <?php }  ?>
                             </select>
                             
                             
               
                        </p>
                         <h5>Fax *</h5>
                        <p>
                            <input type="text" class="form-control" name="supp_country_name" id="country_name">
                        </p>
                        <h5>Email Address *</h5>
                        <p>
                            <input type="text" class="form-control" name="supp_email" id="supp_email">
                        </p>
                        
    
                        
                    </div>
                    <div class="col-md-6">
                     <h5>Credit Limit *</h5>
                        <p>
                            <input type="text" class="form-control" name="supp_name" id="supp_name">
                        </p>  
                                        
                        <h5>Bank *</h5>
                        <p>
                            <input type="text" class="form-control" name="supp_bank" id="supp_bank">
                        </p>
                         <h5>Branch *</h5>
                        <p>
                            <input type="text" class="form-control" name="supp_bank_branch" id="supp_bank_branch">
                        </p>
                         <h5>Account Number  *</h5>
                        <p>
                            <input type="text" class="form-control" name="supp_account_number" id="supp_account_number">
                        </p>
                          <h5>Credit Period *</h5>
                        <p>
                            <input type="text" class="form-control" name="supp_credit_period" id="supp_credit_period">
                        </p>
                         <h5>Contact Person Name *</h5>
                        <p>
                            <input type="text" class="form-control" name="supp_contact_person_name" id="supp_contact_person_name">
                        </p>   
                         <h5>Contact Person Phone *</h5>
                        <p>
                            <input type="text" class="form-control" name="supp_contact_person_phone" id="supp_contact_person_phone">
                        </p>  
                         <h5>Contact Person Email *</h5>
                        <p>
                            <input type="text" class="form-control" name="supp_contact_person_email" id="supp_contact_person_email">
                        </p>                      
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <input type="submit" name="add_category" value="Update Supplier" class="btn btn-primary">
            </div>
</form>
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
		<script src="<?php echo asset_url(); ?>js/form-validation-create_supplier.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
                        
		<script>
			jQuery(document).ready(function() {
				FormValidator.init();
			});
			
		</script>
        
<script type="text/javascript">
function insertSupplierData(){
var supp_company_name 	= $('#supp_company_name').val();
var supp_address 	= $('#supp_address').val();
var supp_email 	= $('#supp_email').val();									 
	$.post( "suppliers/insert_supplier", {supp_company_name:supp_company_name, supp_address:supp_address, supp_email:supp_email})
	  .done(function( data ) {
		
	  var obj = jQuery.parseJSON(data);
	  //  alert(obj.id); //last id
		
		var r = confirm("Supplier has been added successfully! Do you want to add another supplier?");
		 var baseUrl = '<?=base_url()?>';
		if (r == true) { 
			//clear form
			$('#supp_company_name').val('');
		}else {
			window.location.href = baseUrl+'suppliers';  
		}
		
	  });
return false;
}


$( "form#create_supplier_form" ).submit(function( event ) {

});
    </script>