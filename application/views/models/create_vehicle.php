<div>
  <div class="modal-content">
    <form role="form" class="form-horizontal" id="create_vehicle_form" action="#" method="post">
    <input type="hidden" value="<?php echo $type;?>" name="type" id="type"/>
    <input type="hidden" value="<?php echo $veh_id;?>" name="veh_id" id="veh_id"/>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo $pageName ?></h4>
        <font style="color:#333;">Please fill in the information below. The field labels marked with * are required input fields.</font> </div>
      <div class="modal-body">
        <div id="error"></div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-5">
              <div style="display:none;" class="form-group">
                <h5>Vehicle Code *</h5>
                <input type="text" class="form-control" name="veh_code" id="veh_code" <?php echo (isset($vehicle['veh_code']))?'value="'.$vehicle['veh_code'].'"':null;?> <?php if (isset($type)) if($type=='E') echo 'readonly';?>>
              </div>
              <div class="form-group">
                <h5>Vehicle Number *</h5>
                <input type="text" class="form-control" name="veh_number" id="veh_number" <?php echo (isset($vehicle['veh_number']))?'value="'.$vehicle['cus_name'].'"':null;?>>
              </div>
              
              <div class="form-group">
                <h5>Credit Limit *</h5>
                <input type="text" class="form-control" name="veh_descripton" id="veh_descripton" <?php echo (isset($vehicle['veh_descripton']))?'value="'.$vehicle['veh_descripton'].'"':null;?>>
              </div>
            </div>
          </div>
        </div>
        <!--col-md-12--> 
        
      </div>
      <div class="modal-footer">
        <input type="submit" name="add_category" value="<?php echo $btnText; ?>" class="btn btn-primary">
      </div>
    </form>
  </div>
</div>

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION --> 

<script src="<?php echo asset_url(); ?>js/form-validation-create_vehicle.js"></script> 

<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION--> 

<script>

			jQuery(document).ready(function() {

				FormValidator.init();

				$("#country_id").select2();

			});

		</script> 
<script type="text/javascript">

function insertFormData(){

var type=$('#type').val();

var veh_id=$('#veh_id').val();

var veh_code=$('#veh_code').val();

var veh_number=$('#veh_number').val();	

var veh_descripton=$('#veh_descripton').val();


	$.post( "<?php echo base_url('vehicles/save_vehicle'); ?>", {type:type, veh_id:veh_id, veh_code:veh_code, veh_number:veh_number, veh_descripton:veh_descripton})

	  .done(function( data ) {

		

	  var obj = jQuery.parseJSON(data);

	 if (obj.status==0) 

	{

		$('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>'+obj.validation+'</div>');

		$('body').modalmanager('removeLoading');

		$('body').attr('class','');

	} else {
		window.location.reload(true);
		}
	  });

return false;

}

    </script>