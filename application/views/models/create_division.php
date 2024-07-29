<?php 
$config = array('role' =>'form', 'class'=>'form-horizontal','id'=>'create_division_form', 'name'=>'create_division_form');
echo form_open('#',$config);
?>
<?php //print_r($category_details) ?>
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">ADD DIVISION</h4>
            <font style="color:#333;">Please fill in the information below. The field labels marked with * are required input fields.</font>
            </div>
            <div class="modal-body">
                <div id="error"></div>
            <div class="row form-group">
             <div class="col-md-12">
                 <h5>Select Floor *</h5>
                 <p>
                     <select type="dropdown" class="form-control" name="floor_id">
                         <?php foreach($floors as $flo){ ?>
                         <option value="<?php echo $flo->floor_id ?>" <?php if(isset($division_details)){$sel = ($division_details[0]->floor_id == $flo->floor_id)? 'selected="selected"':null; echo $sel;} ?> ><?php echo $flo->floor_name ?></option>
                         <?php  } ?>
                     </select>
                 </p>
                    <h5>Division Name *</h5>
                    <p>
                        <input type="hidden" value="<?php $retVal = (isset($division_details)) ? $division_details[0]->div_status : NULL ; echo $retVal; ?>" name="division_status" id="division_status">
                    <input type="hidden" value="<?php $retVal = (isset($division_details)) ? $division_details[0]->division_id : NULL ; echo $retVal; ?>" name="division_id" id="division_id">
                    <input type="text" class="form-control" value="<?php $retVal = (isset($division_details)) ? $division_details[0]->div_name : NULL ; echo $retVal; ?>" name="division_name" id="division_name">
                    </p>
                    <h5>Description *</h5>
                    <p>
                    <input type="text" class="form-control" name="description" id="description" value="<?php $retVal = (isset($division_details)) ? $division_details[0]->div_description : NULL ; echo $retVal; ?>">
                    </p>
            <div class="modal-footer">
            <input type="submit" name="add_division" value="<?php $retVal = (isset($division_details)) ? "Update Divison" : "Add Division" ; echo $retVal; ?>" class="btn btn-primary">
            </div>
            </div>
            </div>
            </div>

  </form>

		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
		<script src="<?php echo asset_url(); ?>js/form-validation-create_division.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
                        
		<script>
			jQuery(document).ready(function() {
				FormValidator.init();
			});


        function add_division(form) {

            var division_id = $("input#division_id").val();
            alert(division_id);

            if (division_id!="") {

                $('body').modalmanager('loading');
                setTimeout(function () {
                    $.ajax({
                    url: "<?php echo base_url('restaurants_settings/update_division'); ?>", // Url to which the request is send
                    type: "POST",             // Type of request to be send, called as method
                    data: new FormData(form), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                    contentType: false,       // The content type used when sending data to the server.
                    cache: false,             // To unable request pages to be cached
                    processData:false,        // To send DOMDocument or non processed data file it is set to false
                        success: function(data)   // A function to be called if request succeeds
                        {
                            var obj = jQuery.parseJSON(data);
                            if (obj.status==0) 
                                {
                                    $('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>'+obj.validation+'</div>');
                                    $('body').modalmanager('removeLoading');
                                } 
                                else
                                {
                                    $('body').modalmanager('removeLoading');
                                    $('div#ajax-modal').modal('hide');
                                    set_message('floor notice!','Division successfully updated');
                                    division_load();
                                };

                        }
                    });
                }, 1000);

            } else{
                    $('body').modalmanager('loading');
                    setTimeout(function () {
                        $.ajax({
                        url: "<?php echo base_url('restaurants_settings/save_division'); ?>", // Url to which the request is send
                        type: "POST",             // Type of request to be send, called as method
                        data: new FormData(form), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                        contentType: false,       // The content type used when sending data to the server.
                        cache: false,             // To unable request pages to be cached
                        processData:false,        // To send DOMDocument or non processed data file it is set to false
                        success: function(data)   // A function to be called if request succeeds
                        {
                            var obj = jQuery.parseJSON(data);
                            if (obj.status==0) 
                                {
                                    $('#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>'+obj.validation+'</div>');
                                    $('body').modalmanager('removeLoading');
                                } 
                                else
                                {
                                    $('body').modalmanager('removeLoading');
                                    $('div#ajax-modal').modal('hide');
                                    set_message('floor notice!','Division successfully saved');
                                    division_load();
                                };

                        }
                        });
                    }, 1000);
                };

        }

		</script>          
