<?php 
$config = array('role' =>'form', 'class'=>'form-horizontal','id'=>'create_table_form', 'name'=>'create_table_form');
echo form_open_multipart(base_url("#"),$config);
?>
<?php //print_r($category_details) ?>
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">ADD TABLE</h4>
            <font style="color:#333;">Please fill in the information below. The field labels marked with * are required input fields.</font>
            </div>
            <div class="modal-body">
                <div id="error"></div>
            <div class="row form-group">
             <div class="col-md-12">
                    <h5>Table Category *</h5>
                    <p>
                    <input type="hidden" value="<?php $retVal = (isset($table_details)) ? $table_details[0]->table_id : NULL ; echo $retVal; ?>" name="table_id" id="table_id">
                    <!--<input type="text" class="form-control" value="<?php $retVal = (isset($table_details)) ? $table_details[0]->cat_code : NULL ; echo $retVal; ?>" name="cat_id" id="cat_id">-->
                    </p>
                    <p>
                        <select class="form-control" name="table_cat" id="table_cat">
                            <?php foreach ($table_cat as $row){ ?>
                            <option value="<?php echo $row['table_cat_id'] ?>"><?php echo $row['table_cat_name'] ?></option>>
                            <?php } ?>
                        </select>
                    </p>
                    <h5>Number Of Chairs *</h5>
                    <p>
                    <input type="number" class="form-control" name="num_of_chairs" id="num_of_chairs" value="<?php $retVal = (isset($table_details)) ? $table_details[0]->cat_name : NULL ; echo $retVal; ?>">
                    </p>
                    
            <div class="modal-footer">
            <input type="submit" name="add_table" value="<?php $retVal = (isset($table_details)) ? "Update Table" : "Add Table" ; echo $retVal; ?>" class="btn btn-primary">
            </div>
            </div>
            </div>
            </div>

  </form>

		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
		<script src="<?php echo asset_url(); ?>js/form-validation-create_table.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
                        
		<script>
			jQuery(document).ready(function() {
				FormValidator.init();
			});


        function add_table() {

            var table_id = $("#table_id").val();
            var division_id = $('#selected_division_id').val();
            var floor_id = $('#selected_floor_id').val();
            var num_of_chairs = $('#num_of_chairs').val();
            var table_cat = $('#table_cat').val();
            var position = $('#position').val();
//            var selected_division_id = 
//            alert(num_of_chairs);

            if (table_id!="") {

                $('body').modalmanager('loading');
                setTimeout(function () {
                    $.ajax({
                    url: "<?php echo base_url('table_management/update_table'); ?>", // Url to which the request is send
                    type: "POST",             // Type of request to be send, called as method
                    data: {}, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
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
                                    set_message('categories notice!','Category successfully updated');
                                    category_load();
                                };

                        }
                    });
                }, 1000);

            } else{
                    $('body').modalmanager('loading');
                    setTimeout(function () {
                        $.ajax({
                        url: "<?php echo base_url('table_management/table_save'); ?>", // Url to which the request is send
                        type: "POST",             // Type of request to be send, called as method
                        data: {division_id:division_id,floor_id:floor_id,num_of_chairs:num_of_chairs,table_cat:table_cat,position:position}, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
//                        contentType: false,       // The content type used when sending data to the server.
//                        cache: false,             // To unable request pages to be cached
//                        processData:false,        // To send DOMDocument or non processed data file it is set to false
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
                                    set_message('table notice!','Table successfully added');
//                                    category_load();
                                };

                        }
                        });
                    }, 1000);
                };

        }

		</script>          
