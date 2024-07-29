<form role="form" class="form-horizontal" id="create_tax_rates_form" action="#">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">ADD TAX RATES</h4>
            <font style="color:#333;">Please fill in the information below. The field labels marked with * are required input fields.</font>
            </div>
            <div class="modal-body">
            <div class="row form-group">
             <div class="col-md-12">
                    <h5>Name *</h5>
                    <p>
                    <input type="text" class="form-control" value="<?php echo $id; ?>" name="tax_name" id="tax_name">
                    </p>
                    <h5>Code *</h5>
                    <p>
                    <input type="text" class="form-control" name="cat_name" id="cat_name">
                    </p>
                    <h5>Rate *</h5>
                    <p>
                    <input type="text" class="form-control" name="cat_name" id="cat_name">
                    </p>
                    <h5>Type *</h5>
                    <p>
                    <select id="form-field-select-3" class="form-control">
                                <option value="">&nbsp;</option>
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AZ">Arizona</option>
                             </select>
                    </p>
                    
                                <div class="modal-footer">
            <input type="submit" name="add_category" value="Add Tax Rates" class="btn btn-primary">
            </div>
            </div>
            </div>
            </div>

  </form>
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
		<script src="<?php echo asset_url(); ?>js/form-validation-tax_rates.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
                        
		<script>
			jQuery(document).ready(function() {
				FormValidator.init();
			});
		</script>          
