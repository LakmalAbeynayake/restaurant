		<style type="text/css">
			body .modal {
	    /* new custom width */
	    width: 750px;
	    /* must be half of the width, minus scrollbar on the left (30px) */
	    margin-left: -375px;
			}
			</style>
            <form role="form" class="form-horizontal" id="create_location_form" action="#" method="post">
<input type="hidden" value="<?php echo $type;?>" name="type" id="type"/>
<input type="hidden" value="<?php echo $location_id;?>" name="location_id" id="location_id"/>
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
                            <input type="text" <?php echo (isset($locations['location_name']))?'value="'.$locations['location_name'].'"':null;?> class="form-control" name="location_name" id="location_name">
                    </div>
                    <div class="form-group">
                        <h5>
                        <label class="control-label">
							 Code*
						</label></h5>
                            <input type="text" <?php echo (isset($locations['location_code']))?'value="'.$locations['location_code'].'"':null;?> class="form-control" name="location_code" id="location_code">
                    </div>
                    
                    <div class="form-group">
                        <h5>
                        <label class="control-label">
							 Phone*
						</label></h5>
                            <input type="text" <?php echo (isset($locations['location_phone']))?'value="'.$locations['location_phone'].'"':null;?> class="form-control" name="location_phone" id="location_phone">
                    </div>
                    <div class="form-group">
                        <h5>
                        <label class="control-label">
							 Fax
						</label></h5>
                            <input type="text" <?php echo (isset($locations['location_fax']))?'value="'.$locations['location_fax'].'"':null;?> class="form-control" name="location_fax" id="location_fax">
                    </div>
                    <div class="form-group">
                        <h5>
                        <label class="control-label">
							 Email
						</label></h5>
                            <input <?php echo (isset($locations['location_email']))?'value="'.$locations['location_email'].'"':null;?> type="text" class="form-control" name="location_email" id="location_email">
                    </div>
                    <div class="form-group">
                        <h5>
                        <label class="control-label">
							 Address
						</label></h5>
                            <input <?php echo (isset($locations['location_address']))?'value="'.$locations['location_address'].'"':null;?> type="text" class="form-control" name="location_address" id="location_address">
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
<script src="<?php echo asset_url(); ?>js/form-validation-create_location.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->

	<script>
        jQuery(document).ready(function() {
            FormValidator.init();
        });
    </script>
    
<script type="text/javascript">
function insertLocationData(){
//	alert(22);


var type=$('#type').val();

var location_name=$('#location_name').val();
var location_code=$('#location_code').val();
var location_id=$('#location_id').val();
var location_name=$('#location_name').val();
var location_phone=$('#location_phone').val();
var location_email=$('#location_email').val();
var location_fax=$('#location_fax').val();
var location_address=$('#location_address').val();
					 
	$.post( "locations/save_location", {type:type, location_id:location_id, location_name:location_name, location_code:location_code, location_id:location_id, location_name:location_name, location_phone:location_phone, location_email:location_email,location_fax:location_fax, location_address:location_address })
	.done(function( data ) {
		
	  var obj = jQuery.parseJSON(data);
	   // alert(obj.type); //last id

	  $('#ajax-modal').modal('hide');
	  loadGrid();// load location data
	  
	  if(obj.type=='E'){
		  
		   displayNotice('page','Location has been updated successfully!')
	  }
	  if(obj.type=='A'){
		  displayNotice('page','Location has been added successfully!')  
			
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