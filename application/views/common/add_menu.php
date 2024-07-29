	<?php $this->load->view("common/header"); ?>
	<!-- end: HEAD -->
       
        
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/select2/select2.css" />
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
        
 		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/jQuery-Tags-Input/jquery.tagsinput.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/summernote/build/summernote.css">
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->       
        

	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body>
		<!-- start: HEADER -->
		<div class="navbar navbar-inverse navbar-fixed-top">
			<!-- start: TOP NAVIGATION CONTAINER -->
			<div class="container">
				<div class="navbar-header">
					<!-- start: RESPONSIVE MENU TOGGLER -->
					<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
						<span class="clip-list-2"></span>
					</button>
					<!-- end: RESPONSIVE MENU TOGGLER -->
					<!-- start: LOGO -->
					<?php $this->load->view("common/logo"); ?>
					<!-- end: LOGO -->
				</div>
				<div class="navbar-tools">
					<!-- start: TOP NAVIGATION MENU -->
				<?php $this->load->view("common/notifications.php"); ?>
					<!-- end: TOP NAVIGATION MENU -->
				</div>
			</div>
			<!-- end: TOP NAVIGATION CONTAINER -->
		</div>
		<!-- end: HEADER -->
		<!-- start: MAIN CONTAINER -->
		<div class="main-container">
			<div class="navbar-content">
				<!-- start: SIDEBAR -->
				<?php $this->load->view("common/navigation"); ?>
				<!-- end: SIDEBAR -->
			</div>
			<!-- start: PAGE -->
			<div class="main-content">
				<!-- start: PANEL CONFIGURATION MODAL FORM -->
				<div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								<h4 class="modal-title">Panel Configuration</h4>
							</div>
							<div class="modal-body">
								Here will be a configuration form
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">
									Close
								</button>
								<button type="button" class="btn btn-primary">
									Save changes
								</button>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
				<!-- end: SPANEL CONFIGURATION MODAL FORM -->
				<div class="container">
					<!-- start: PAGE HEADER -->
					<div class="row">
						<div class="col-sm-12">
							<!-- start: PAGE TITLE & BREADCRUMB -->
							<ol class="breadcrumb">
								<li>
									<a href="<?php echo base_url('dashboard'); ?>">
										 Dashboard 
									</a>
								</li>
                                <li>
									<a href="#">
										 Product 
									</a>
								</li>
                                
								<li class="active">
									Add Product
								</li>
								<li class="search-box">
									<form class="sidebar-search">
										<div class="form-group">
											<input type="text" placeholder="Start Searching...">
											<button class="submit">
												<i class="clip-search-3"></i>
											</button>
										</div>
									</form>
								</li>
							</ol>
							<div class="page-header">
								<h1>ADD MENU</h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
						</div>
					</div>
                    <!-- start grid -->
                    <div class="row">
						<div class="col-md-12">
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Add Menu
								</div>
                                
                                <div class="panel-body">
								    <div id="error"></div>
								<?php 
										$config = array('role' =>'form', 'class'=>'form-horizontal','id'=>'add_product_form', 'name'=>'add_product_form');
										echo form_open_multipart("#",$config);
										?>                                                                   
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Menu Name
											*</label>
											<div class="col-sm-9">
												<input type="text" id="menu_name" class="form-control" name="menu_name" autocomplete="off">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="menu_url">
												Menu URL <button onclick="showinfo()" type="button" data-original-title="Info" data-placement="top" class="btn btn-xs btn-info tooltips">
        											<i class="fa fa-info"></i>
        										</button>
											</label>
											<div class="col-sm-9">
												<input type="text" id="menu_url" class="form-control" name="menu_url" autocomplete="off">
												
        										<span id="sinfo" class="collapse">
        										   <p>
												    <i>NOTE: Use "#" mark to MENU URL, for javascript popups (like "Add Customer"), then put the HTML code with trigger id into MENU DISPLAY NAME. <br>
												    ex: *Display name will be like => <code>&lt;a href=&quot;#&quot; data-toggle=&quot;modal&quot; id=&quot;modal_ajax_customers_btn&quot;&gt; &lt;span class=&quot;title&quot;&gt;Add Customer&lt;/span&gt; &lt;/a&gt;</code></i>
												    <br>
												    <br>
												    * Menu URL be like => <code>#</code>
												    </p>
        										</span>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-2">
												Display Label *</label>
											<div class="col-sm-9">
												<input type="text" id="menu_display_name" class="form-control" name="menu_display_name" autocomplete="off">
											</div>
										</div>
										<div class="form-group">
        									<label class="col-sm-2 control-label" for="form-field-1">
        										Parent Menu (if available)
        									</label>
        									<div class="col-sm-9">
        										 <select id="menu_parent_id" class="form-control" name="menu_parent_id">
                                                                    <option value="">-- Select Parent Menu --</option>
        												<?php 
        													 
                                                            foreach ($menu_list as $row){
        														  if($row['menu_parent_id']>0)continue;
                                                        ?>  
        													<option value="<?php echo $row['menu_id']; ?>"><?php echo $row['menu_display_name']; ?> </option>
                                                        <?php 
                                                              }
                                                        ?>							
        										</select>
        									</div>
        								</div>
                                        
										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="menu_status">
												Menu Status
											</label>
											<div class="col-sm-9">
												<select id="menu_parent_id" class="form-control" name="menu_status">
                                                    <option value="1" selected>Active (Default)</option>
                                                    <option value="0">Deactive</option>
                                                </select>
											</div>
										</div>
                                        
                                  <div class="form-group">
                                      <div class="col-sm-12">
                                          <button class="btn btn-primary btn-squared" type="submit">
											Add Menu
										  </button>
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
		<!-- end: MAIN CONTAINER -->
		<!-- start: FOOTER -->
		<div class="footer clearfix">
			<div class="footer-inner">
				2014 &copy; clip-one by cliptheme.
			</div>
			<div class="footer-items">
				<span class="go-top"><i class="clip-chevron-up"></i></span>
			</div>
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<?php $this->load->view("common/footer"); ?>
		<!-- end: MAIN JAVASCRIPTS -->
        
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
		<script src="<?php echo asset_url(); ?>plugins/jquery-validation/dist/jquery.validate.min.js"></script>
		<script type="text/javascript" src="<?php echo asset_url(); ?>js/autoNumeric.js"></script>
		<script src="<?php echo asset_url(); ?>js/form-validation-add-product.1.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
                        
		<script>
			jQuery(document).ready(function() {
				$(".search-select").select2({
					allowClear: true
				});
                $("#menu_name").focus();
			//	FormValidator.init();
			});
			
			$( "#add_product_form" ).submit(function( event ) {
              event.preventDefault();
              add_product();
            });

		function add_product() {

               $('body').modalmanager('loading');
                setTimeout(function () {
                    $.ajax({
                    url: "<?php echo base_url('system_settings/save_menu'); ?>", // Url to which the request is send
                    type: "POST",             // Type of request to be send, called as method
                    data: new FormData(document.getElementById("add_product_form")), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
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
                                    $('body').attr('class','');
									window.scrollTo( 500, 0 );
                                } 
                                else
                                {
                                    $('body').modalmanager('removeLoading');
                                    $('body').attr('class','');
                                    set_message('Notice!','Menu successfully Added');
									document.getElementById("add_product_form").reset();
									setTimeout(function(){
									   window.location.reload(this);
									}, 200);
                                };

                        }
                    });
                }, 1000);
		}
		/*
		$("#brand_id").select2({
	allowClear: true,
ajax: {
url: "<?php echo base_url('brands/getBrand') ?>",
		dataType: 'json',
		delay: 250,
		data: function (query) {
		if (!query)
				query = '';
		return {
		search_string: query,
				format: 'json'
		};
		},
		results: function (data) {
		return {
		results: $.map(data, function (item) {
		return {
		text: item.brand_name,
				slug: item.brand_name,
				id: item.brand_id
		};
		})
		};
		},
		cache: true
}
});
*/
$('input:text').on('focus',function(){
	this.select();
	});
/*
$("#sub_product_of").select2({
	allowClear: true,
    ajax: {
    url: "<?php echo base_url('products/getProducts') ?>",
    		dataType: 'json',
    		delay: 250,
    		data: function (query) {
    		if (!query)
    				query = '';
    		return {
    		search_string: query,
    				format: 'json'
    		};
    		},
    		results: function (data) {
    		return {
    		results: $.map(data, function (item) {
    		return {
    		text: item.product_code+ ' / '+ item.product_name,
    				slug: item.product_name,
    				id: item.product_id
    		};
    		})
    		};
    		},
    		cache: true
    }
});
*/
function showinfo(){
    $('#sinfo').toggle();
}
		</script>
	</body>
	<!-- end: BODY -->
</html>