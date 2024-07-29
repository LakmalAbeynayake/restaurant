<?php
$config = array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'create_category_form', 'name' => 'create_category_form');
echo form_open_multipart(base_url("#"), $config);
?>
<?php //print_r($category_details) 
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">ADD CATEGORY</h4>
    <font style="color:#333;">Please fill in the information below. The field labels marked with * are required input fields.</font>
</div>
<div class="modal-body">
    <div id="error"></div>
    <div class="row form-group">
        <div class="col-md-12">
            <h5>Category Code *</h5>
            <p>
                <input type="hidden" value="<?php $retVal = (isset($category_details)) ? $category_details[0]->cat_id : NULL;
                                            echo $retVal; ?>" name="category_tbl_id" id="category_tbl_id">
                <input type="text" class="form-control" value="<?php $retVal = (isset($category_details)) ? $category_details[0]->cat_code : NULL;
                                                                echo $retVal; ?>" name="cat_id" id="cat_id">
            </p>
            <h5>Category Name *</h5>
            <p>
                <input type="text" class="form-control" name="cat_name" id="cat_name" value="<?php $retVal = (isset($category_details)) ? $category_details[0]->cat_name : NULL;
                                                                                                echo $retVal; ?>">
            </p>
            <h5>Category Font Color</h5>
            <p>
                <input type="color" class="form-control" name="color" id="color" value="<?php $retVal = (isset($category_details)) ? $category_details[0]->color : NULL;
                                                                                        echo $retVal; ?>">
            </p>
            <h5>Category Background Color</h5>
            <p>
                <input type="color" class="form-control" name="bg_color" id="bg_color" value="<?php $retVal = (isset($category_details)) ? $category_details[0]->bg_color : NULL;
                                                                                                echo $retVal; ?>">
            </p>
            <h5>Category Image</h5>
            <p>
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="input-group">
                    <div class="form-control uneditable-input">
                        <i class="fa fa-file fileupload-exists"></i>
                        <span class="fileupload-preview"></span>
                    </div>
                    <div class="input-group-btn">
                        <div class="btn btn-light-grey btn-file">
                            <span class="fileupload-new"><i class="fa fa-folder-open-o"></i> Select file</span>
                            <span class="fileupload-exists"><i class="fa fa-folder-open-o"></i> Change</span>
                            <input type="file" class="file-input" id="cat_image" name="userfile">
                        </div>
                        <a href="#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
                            <i class="fa fa-times"></i> Remove
                        </a>
                    </div>
                </div>
            </div>
            </p>
            <div class="modal-footer">
                <input type="submit" name="add_category" value="<?php $retVal = (isset($category_details)) ? "Update Category" : "Add Category";
                                                                echo $retVal; ?>" class="btn btn-primary">
            </div>
        </div>
    </div>
</div>
</form>
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
<script src="<?php echo asset_url(); ?>js/form-validation-create_category.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
<script>
    jQuery(document).ready(function() {
        FormValidator.init();
    });
    function add_category(form) {
        var category_id = $("input#category_tbl_id").val();
        if (category_id != "") {
            $('body').modalmanager('loading');
            setTimeout(function() {
                $.ajax({
                    url: "<?php echo base_url('product_category/update_category'); ?>", // Url to which the request is send
                    type: "POST", // Type of request to be send, called as method
                    data: new FormData(form), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false, // To send DOMDocument or non processed data file it is set to false
                    success: function(data) // A function to be called if request succeeds
                    {
                        var obj = jQuery.parseJSON(data);
                        if (obj.status == 0) {
                            $('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>' + obj.validation + '</div>');
                            $('body').modalmanager('removeLoading');
                        } else {
                            $('body').modalmanager('removeLoading');
                            $('div#ajax-modal').modal('hide');
                            set_message('categories notice!', 'Category successfully updated');
                            category_load();
                        };
                    }
                });
            }, 1000);
        } else {
            $('body').modalmanager('loading');
            setTimeout(function() {
                $.ajax({
                    url: "<?php echo base_url('product_category/category_save'); ?>", // Url to which the request is send
                    type: "POST", // Type of request to be send, called as method
                    data: new FormData(form), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false, // To send DOMDocument or non processed data file it is set to false
                    success: function(data) // A function to be called if request succeeds
                    {
                        var obj = jQuery.parseJSON(data);
                        if (obj.status == 0) {
                            $('#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>' + obj.validation + '</div>');
                            $('body').modalmanager('removeLoading');
                        } else {
                            $('body').modalmanager('removeLoading');
                            $('div#ajax-modal').modal('hide');
                            set_message('categories notice!', 'Category successfully added');
                            category_load();
                        };
                    }
                });
            }, 1000);
        };
    }
</script>