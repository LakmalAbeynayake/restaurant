<style>
.hide_this {
	display: none
}
</style>
<div class="main-container"> 
  
  <!-- start: PAGE -->
  <div class="main-content"> 
    <!-- start: PANEL CONFIGURATION MODAL FORM --><!-- /.modal --> 
    <!-- end: SPANEL CONFIGURATION MODAL FORM -->
    <div class="container"> 
      <!-- start: PAGE HEADER -->
      <div class="row">
        <div class="col-sm-12"> 
          <!-- start: PAGE TITLE & BREADCRUMB -->
          <ol class="breadcrumb">
          </ol>
          <div class="page-header">
            <h1>Add Product</h1>
          </div>
          <!-- end: PAGE TITLE & BREADCRUMB --> 
        </div>
      </div>
      <!-- start grid -->
      
      <div class="row">
        <div class="col-md-12"> 
          <!-- start: DYNAMIC TABLE PANEL -->
          <div class="panel panel-default">
            <div class="panel-heading"> <i class="fa fa-external-link-square"></i> Add Product </div>
            <div class="panel-body">
              <div id="error"></div>
              <form method="post" accept-charset="utf-8" role="form" class="form-horizontal" id="add_product_form" name="add_product_form" enctype="multipart/form-data" novalidate="novalidate"> 
              <?php 
										//$config = array('role' =>'form', 'class'=>'form-horizontal','id'=>'add_product_form', 'name'=>'add_product_form');
										//echo form_open_multipart("#",$config);
										?>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="product_name"> Product Name
                  *</label>
                <div class="col-sm-9">
                  <input type="text" id="product_name" class="form-control" name="product_name" required="required">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="product_code"> Product Code
                  *</label>
                <div class="col-sm-9">
                  <?php
												$ref_id = new Common_Model();
												$reference_no = $ref_id->gen_ref_number('product_id','product','PD');
												$product_id = $ref_id->gen_ref_number('product_id','product','');
												?>
                  <input type="text" id="product_code" class="form-control" name="product_code" value="<?php echo $reference_no ?>">
                  <input type="hidden" id="product_id" class="form-control" name="product_id" value="<?php echo $product_id ?>">
                </div>
              </div>
              <div class= "form-group" style="display:none">
                <label class="col-sm-2 control-label" for="form-field-2"> SAP Code </label>
                <div class="col-sm-9">
                  <input type="text" id="product_part_no" class="form-control" name="product_part_no">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="form-field-3" > Category* </label>
                <div class="col-sm-9">
                  <select class="form-control search-select allow-clear" id="category" name="category">
                    <option value="">&nbsp;</option>
                    <?php foreach ($main_category as $key => $category) {?>
                    <option value="<?php echo $category->cat_id; ?>"><?php echo $category->cat_name; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="form-field-3" > Sub Category </label>
                <div id="subcat_data" class="col-sm-9">
                  <select data-placeholder="Select Category to load Subcategories" id="subcategory" class="form-control search-select" name="subcategory">
                    <option selected="selected" value="">-</option>
                  </select>
                </div>
              </div>
              <div class="form-group hide_this">
                <label class="col-sm-2 control-label" for="form-field-2"> Product Unit * </label>
                <div class="col-sm-9">
                  <select class="form-control search-select" id="unit" name="unit">
                    <option selected value="6">6</option>
                    <?php /*?><?php foreach ($unit_type as $key => $unit) {
						                            	if ($unit->unit_code == "Item") {
						                            		echo "<option selected value='$unit->unit_id'>$unit->unit_code</option>";
						                            	}else{
						                            		echo "<option value='$unit->unit_id'>$unit->unit_code</option>";
						                            	}
						                            } ?> <?php */?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="form-field-2"> Retail Price * </label>
                <div class="col-sm-9">
                  <input name="product_price" type="text" required="required" class="form-control auto" id="product_price" data-a-sign="Rs. " data-d-group="2">
                </div>
              </div>
              <div class="form-group hide_this">
                <label class="col-sm-2 control-label" for="form-field-2"> Wholesale Price * </label>
                <div class="col-sm-9">
                  <input type="text" id="wholesale_price" class="form-control" name="wholesale_price" data-a-sign="Rs. " data-d-group="2" value="Rs. 0.00">
                </div>
              </div>
              <div class="form-group hide_this">
                <label class="col-sm-2 control-label" for="form-field-2"> Credit Selling Price * </label>
                <div class="col-sm-9">
                  <input type="text" id="credit_salling_price" class="form-control" name="credit_salling_price" data-a-sign="Rs. " data-d-group="2" value="Rs. 0.00">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="form-field-2"> Product Cost * </label>
                <div class="col-sm-9">
                  <input name="product_cost" data-a-sign="Rs. " type="text" required="required" class="form-control auto" id="product_cost">
                </div>
              </div>
              <div class="form-group hide_this">
                <label class="col-sm-2 control-label" for="form-field-2"> Tax Method </label>
                <div class="col-sm-9">
                  <select class="form-control search-select" id="tax" name="tax">
                    <?php foreach ($tax as $key => $tax) {
						                            	echo "<option value='$tax->id'>$tax->name</option>";
						                            } ?>
                  </select>
                </div>
              </div>
              <div class="form-group hide_this">
                <label class="col-sm-2 control-label" for="form-field-2"> Minimum Quantity </label>
                <div class="col-sm-9">
                  <input type="text" id="alert_quty" name="alert_quty" class="form-control" value="1">
                </div>
              </div>
              <div class="form-group hide_this">
                <label class="col-sm-2 control-label" for="form-field-2"> Maximum Quantity </label>
                <div class="col-sm-9">
                  <input type="text" id="product_max_qty" name="product_max_qty" class="form-control">
                </div>
              </div>
              <div class="form-group hide_this">
                <label class="col-sm-2 control-label" for="form-field-2"> Store Position </label>
                <div class="col-sm-9">
                  <input type="text" id="store_position" class="form-control" name="store_position">
                </div>
              </div>
              <div class="form-group hide_this">
                <label class="col-sm-2 control-label" for="form-field-2"> Product Image </label>
                <div class="col-sm-9">
                  <div class="form-group">
                    <div class="col-sm-4">
                      <label> </label>
                      <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="input-group">
                          <div class="form-control uneditable-input"> <i class="fa fa-file fileupload-exists"></i> <span class="fileupload-preview"></span> </div>
                          <div class="input-group-btn">
                            <div class="btn btn-light-grey btn-file"> <span class="fileupload-new"><i class="fa fa-folder-open-o"></i> Select file</span> <span class="fileupload-exists"><i class="fa fa-folder-open-o"></i> Change</span>
                              <input type="file" class="file-input" name="userfile">
                            </div>
                            <a href="#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload"> <i class="fa fa-times"></i> Remove </a> </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group hide_this">
                <div class="col-sm-12">
                  <label class="control-label"> Product Details </label>
                  <textarea class="ckeditor form-control" cols="10" rows="10" name="product_details"></textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-12">
                  <button id="save_product" class="btn btn-primary btn-squared"> Add Product </button>
                </div>
              </div>
              </form>
            </div>
          </div>
        </div>
        <!-- end: DYNAMIC TABLE PANEL --> 
      </div>
    </div>
    <!-- end grid --> 
  </div>
  <!-- end: PAGE --> 
</div>
