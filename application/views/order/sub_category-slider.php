<div id="subcategory-slider">
         <div id="subcategory-list">
            <?php foreach ($sub_category as $key => $sub_cat) { ?>
               <button class="btn-prni subcategory" value="<?php echo $sub_cat->sub_cat_id; ?>" type="button" id="subcategory-<?php echo $sub_cat->sub_cat_id; ?>">
                  <img alt="sub category image" class="img-rounded img-thumbnail" style="width:60px;height:60px;" src="<?php echo asset_url() ?>uploads/no-image.jpg"><span><?php echo $sub_cat->sub_cat_name; ?></span>
               </button>            
            <?php } ?>
         </div>
      </div>