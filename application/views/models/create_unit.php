<form role="form" class="form-horizontal" id="create_unit_form" action="#" method="post">
<input type="hidden" value="<?php echo $type;?>" name="type" id="type"/>
<input type="hidden" value="<?php echo $unit_id;?>" name="unit_id" id="unit_id"/>
<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?php echo $pageName ?></h4>
            <font style="color:#333;">Please fill in the information below. The field labels marked with * are required input fields.</font>
            </div>
    <div class="col-md-12">
        
    </div>              
            <div class="modal-body">
            <div id="error"></div>
                <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                    <!--<h5>Parent Category *</h5>
                    <p>
                        <div class="form-group">
                            <select id="form-field-select-3" class="form-control search-select">
                                <option value="">&nbsp;</option>
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AZ">Arizona</option>
                             </select>
                        </div>
                    </p>-->
                    <div class="form-group">
                        <h5>
                        <label class="control-label">
							 Code*
						</label></h5>
                            <input type="text" <?php echo (isset($suppliyer['unit_code']))?'value="'.$suppliyer['unit_code'].'"':null;?> class="form-control" name="unit_code" id="unit_code" <?php if (isset($type)) if($type=='E') echo 'readonly';?>>
                    </div>
                    <div class="form-group">
                        <h5>
                        <label class="control-label">
							 Name*
						</label></h5>
                            <input type="text" <?php echo (isset($suppliyer['unit_name']))?'value="'.$suppliyer['unit_name'].'"':null;?> class="form-control" name="unit_name" id="unit_name">
                    </div>
                    
                                                 -   
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <input type="submit" name="add_category" value="<?php echo $btnText; ?>" class="btn btn-primary">
            </div>
            </div> <!--/.col-md-12-->
</form>

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
<script src="<?php echo asset_url(); ?>js/form-validation-create_unit.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->

<script>
   jQuery(document).ready(function() {
        FormValidator.init();
   });
</script>
    
<script type="text/javascript">
function insertLocationData(){
	
var type=$('#type').val();
var unit_name=$('#unit_name').val();
var unit_code=$('#unit_code').val();
var unit_id=$('#unit_id').val();
					 
	$.post( "unit/save_unit", {type:type, unit_id:unit_id, unit_name:unit_name, unit_code:unit_code })
	.done(function( data ) {
		
	  var obj = jQuery.parseJSON(data);
	   // alert(obj.type); //last id
	   
	   if (obj.status==0) 
	{
		$('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>'+obj.validation+'</div>');
		$('body').modalmanager('removeLoading');
		$('body').attr('class','');
	}
	 else {

	  $('div#ajax-modal').modal('hide');
	  loadGrid();// load location data
	  
	  if(obj.type=='E'){
		  
		  displayNotice('page','Unit has been updated successfully!')
	  }
	  if(obj.type=='A'){
			displayNotice('page','Unit has been added successfully!')    
	  }
	 }
	  });
return false;
}
</script>