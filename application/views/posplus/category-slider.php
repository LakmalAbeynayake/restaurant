<div id="category-slider">
  <div id="category-list">
    <?php foreach ($category as $key => $cat) { ?>
    <button id="category-<?php echo $cat->cat_id; ?>" type="button" value='<?php echo $cat->cat_id; ?>' class="btn-prni category"> <img alt="cat thumb" src="<?php echo asset_url(); ?>uploads/thumbs/<?php echo $cat->cat_image_thumb; ?>" style='width:60px;height:60px;' class='img-rounded img-thumbnail'/><span><?php echo $cat->cat_name; ?></span> </button>
    <?php } ?>
  </div>
</div>
