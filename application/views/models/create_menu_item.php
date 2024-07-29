		<style type="text/css">
			body .modal {
	    /* new custom width */
	    width: 750px;
	    /* must be half of the width, minus scrollbar on the left (30px) */
	    margin-left: -375px;
			}
			</style>
            <form role="form" class="form-horizontal" id="create_item_form" action="#" method="post">
<blockquote>
  <p>
    <input type="hidden" value="<?php echo $type;?>" name="type" id="type"/>
    <input type="hidden" value="<?php echo $item_id;?>" name="item_id" id="item_id"/>
  </p>
</blockquote>
<div class="modal-header">
  
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>


    <h4 class="modal-title"><?php echo $pageName ?></h4>

 
    <p><font style="color:#333;">Please fill in the information below. The field labels marked with * are required input fields.</font>
    </p>
  
</div>
    <div class="col-md-12">
        <div class="errorHandler alert alert-danger no-display">
            <i class="fa fa-times-sign"></i>
           
              <p> You have some form errors. Please check below.
              </p>
           
        </div>
    </div>              
            <div class="modal-body">
                <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                    <div class="form-group">
                  
                        <h5>
                          <label class="control-label">
                               Code*
                          </label>
                      </h5>
                            <input type="text" <?php echo (isset($item_list['item_code']))?'value="'.$item_list['item_code'].'"':null;?> class="form-control" name="item_code" id="item_code">
                    </div>
                    <div class="form-group">
                        <h5>
                        <label class="control-label">
							 Name*
						</label></h5>
                            <input type="text" <?php echo (isset($item_list['item_name']))?'value="'.$item_list['item_name'].'"':null;?> class="form-control" name="item_name" id="item_name">
                    </div>
                    
                    
                    
                    
                    
                    
                    
                     <div class="form-group" style="display:none;">
                        <h5>
                        <label class="control-label">
							 Name (Sinhala)*
						</label></h5>
                            <input type="text" <?php echo (isset($item_list['item_name_sin']))?'value="'.$item_list['item_name_sin'].'"':null;?> class="form-control" name="item_name_sin" id="item_name_sin">
                    </div>
                    
                    <div class="form-group">
                        <h5>
                        <label class="control-label">
							 Unit
						</label></h5>
                            <select id="item_unit" class="form-control" name="item_unit">
                  <!--<option value="">-- Select Warehouse --</option>-->
                  <?php 
																
                                                  foreach ($unit_list as $row)
                                                   {
																  $sel='';
																  if($item_list['item_unit']==$row['unit_id'])
																  {
																	  $sel=' selected="selected"';
																  }
                                                              ?>
                  <option <?php echo $sel?> value="<?php echo $row['unit_id']; ?>"> <?php echo $row['unit_name']; ?> </option>
                  <?php }?>
                </select>
                    </div>
                    
                    <div class="form-group" style="display:none;">
                        <h5>
                        <label class="control-label">
							 Item Type
						</label></h5>
                            <select id="item_type" class="form-control" name="item_type">
                  <option value="Extra">Extra</option>
               <option value="Menu"  <?php if(isset($item_list['item_type']) && $item_list['item_type']=='Menu') echo 'selected="selected"'; ?>>Menu</option>
                  <option value="Extra" <?php if(isset($item_list['item_type']) && $item_list['item_type']=='Extra') echo 'selected="selected"'; ?>>Extra</option>
                   <option value="Furniture" <?php if(isset($item_list['item_type']) && $item_list['item_type']=='Furniture') echo 'selected="selected"'; ?>>Furniture</option>
                    <option value="Marquee" <?php if(isset($item_list['item_type']) && $item_list['item_type']=='Marquee') echo 'selected="selected"'; ?>>Marquee</option>
                 
                </select>
                    </div>
                    
<div class="form-group">
                        <h5>
                        <label class="control-label">
							  Price*
						</label></h5>
                            <input type="text" <?php echo (isset($item_list['item_price_1']))?'value="'.$item_list['item_price_1'].'"':null;?> class="form-control" name="item_price_1" id="item_price_1">
                    </div>
                    
                     <div class="form-group">
                        <h5>
                        <label class="control-label">
							 Cost*
						</label></h5>
                            <input type="text" <?php echo (isset($item_list['item_cost']))?'value="'.$item_list['item_cost'].'"':null;?> class="form-control" name="item_cost" id="item_cost">
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
<script src="<?php echo asset_url(); ?>js/form-validation-create_item.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->

	<script>
        jQuery(document).ready(function() {
            FormValidator.init();
        });
    </script>
    
<script type="text/javascript">
function insertItemData(){
//	alert(22);


var type=$('#type').val();

var item_id=$('#item_id').val();
var item_code=$('#item_code').val();
var item_name=$('#item_name').val();
var item_name_sin=$('#item_name_sin').val();
var item_price_1=$('#item_price_1').val();
var item_price_2=$('#item_price_2').val();
var item_image=$('#item_image').val();
var item_unit=$('#item_unit').val();
var item_type=$('#item_type').val();
var item_cost=$('#item_cost').val();
//alert(item_price_1);
					 
	$.post( "<?php echo base_url("menu_item/save_menu_item"); ?>", {item_price_1:item_price_1, item_price_2:item_price_2, type:type,item_unit:item_unit,item_type:item_type, item_id:item_id, item_code:item_code, item_name:item_name,item_name_sin:item_name_sin, item_cost:item_cost})
	.done(function( data ) {
		
	  var obj = jQuery.parseJSON(data);
	   // alert(obj.type); //last id

	  $('div#ajax-modal').modal('hide');
	  loadGrid();// load location data
	  
	  
	  if(obj.type=='E'){
		  
		   displayNotice('page','Menu has been updated successfully!')
		   setTimeout(explode, 1000);
		     
	  }
	  
	  function explode(){
  		location.reload()
		}

	  if(obj.type=='A'){
		  displayNotice('page','Menu has been added successfully!');
		  setTimeout(explode, 1000);  
			
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