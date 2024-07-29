    <?php 
        $config = array('role' =>'form','id'=>'create_sub_category_form', 'name'=>'create_sub_category_form');
        echo form_open_multipart(base_url("#"),$config);
    ?>
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">ADD SUB CATEGORY</h4>
            <font style="color:#333;">Please fill in the information below. The field labels marked with * are required input fields.</font>
            </div>
            <div class="modal-body">
                <div id="error"></div>
                <h5>Parent Category *</h5>
                <p>
                    <div class="form-group">
                        <select id="form-field-select-3" class="form-control search-select" name="parent_category" id="parent_category">
                        <?php foreach ($getCategory as $key => $category) { 
                            if ($category->cat_id == $sub_category_details[0]->cat_id) { ?>
                               <option selected value="<?php echo $category->cat_id; ?>"><?php echo $category->cat_name; ?></option>
                            <?php }else{?>
                               <option value="<?php echo $category->cat_id; ?>"><?php echo $category->cat_name; ?></option>
                            <?php } }?>
                         </select>
                    </div>
                </p>
                <h5>Sub Category Code *</h5>
                <p>
                <div class="form-group">
                <input type="hidden" value="<?php $retVal = (isset($sub_category_details)) ? $sub_category_details[0]->sub_cat_id : NULL ; echo $retVal; ?>" id="sub_category_tbl_id" name="sub_category_tbl_id">
                <input type="text" class="form-control" name="cat_code" id="cat_code" value="<?php $retVal = (isset($sub_category_details)) ? $sub_category_details[0]->sub_cat_code : NULL ; echo $retVal; ?>">
                </div>
                </p>
                <div class="form-group">
                <h5>Sub Category Name *</h5>
                </div>
                <div class="form-group">
                <p>
                <input type="text" class="form-control" name="cat_name" id="cat_name" value="<?php $retVal = (isset($sub_category_details)) ? $sub_category_details[0]->sub_cat_name : NULL ; echo $retVal; ?>">
                </p>  
                </div>                 
            </div>
            <div class="modal-footer">
                <input type="submit" name="add_subcategory" value="<?php $retVal = (isset($sub_category_details)) ? "Update Sub Category" : "Add Sub Category" ; echo $retVal; ?>" class="btn btn-primary">
            </div>
    <form/>

        <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
        <script src="<?php echo asset_url(); ?>js/form-validation-create_category.js"></script>
        <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
                        
        <script>
            jQuery(document).ready(function() {
                FormValidator.init();
            });


        function add_sub_category(form) {

            var sub_category_id = $("input#sub_category_tbl_id").val();

            if (sub_category_id!="") {

                $('body').modalmanager('loading');
                setTimeout(function () {
                    $.ajax({
                    url: "<?php echo base_url('product_category/update_sub_category'); ?>", // Url to which the request is send
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
                                    set_message('categories notice!','Sub Category successfully updated');
                                    category_load();
                                };

                        }
                    });
                }, 1000);

            } else{
                    $('body').modalmanager('loading');
                    setTimeout(function () {
                        $.ajax({
                        url: "<?php echo base_url('product_category/category_sub_save'); ?>", // Url to which the request is send
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
                                   // $('div#ajax-modal').modal('hide');
                                    set_message('categories notice!','Sub Category successfully added');
                                    category_load();
                                };

                        }
                        });
                    }, 1000);
                };

        }


        </script>