	<?php $this->load->view("common/header"); ?>

	<!-- end: HEAD -->

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

										 Settings 

									</a>

								</li>

								<li>

									<a href="<?php echo base_url('system_settings/categories'); ?>">

									Category 

									</a>

								</li>

								<li class="active">

									Sub Categories

								</li>

								<li class="search-box">

									<form class="sidebar-search">

										<div class="form-group">

											<input type="text" placeholder="Start Searching...">

											<button class="submit">

												<i class="fa fa-search"></i>

											</button>

										</div>

									</form>

								</li>

							</ol>

							<div class="page-header">

								<h1>Sub Categories</h1>

							</div>



                            <p>Please use the table below to navigate or filter the results. </p>

						</div>

					</div>

					<!-- end: PAGE HEADER -->

					<!-- start: PAGE CONTENT 

                    <!-- start grid -->

                    <div class="row">

						<div class="col-md-12">

							<!-- start: DYNAMIC TABLE PANEL -->

							<div class="panel panel-default">

								<div class="panel-body">

									<table class="table table-striped table-bordered table-hover table-full-width dataTable" id="sub_category_table">

										<thead>

								            <tr>

												<th>Sub Category Code</th>

												<th>Sub Category Name</th>

												<th>Parent Category</th>

												<th>Actions</th>

								            </tr>

								        </thead>



								        <tfoot>

												<th>Sub Category Code</th>

												<th>Sub Category Name</th>

												<th>Parent Category</th>

												<th>Actions</th>

								            </tr>

								        </tfoot>

									</table>

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

		<!-- end: FOOTER -->

		<!-- start: RIGHT SIDEBAR -->

		<!-- end: RIGHT SIDEBAR -->

		<div id="event-management" class="modal fade" tabindex="-1" data-width="760" style="display: none;">

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">

							&times;

						</button>

						<h4 class="modal-title">Event Management</h4>

					</div>

					<div class="modal-body"></div>

					<div class="modal-footer">

						<button type="button" data-dismiss="modal" class="btn btn-light-grey">

							Close

						</button>

						<button type="button" class="btn btn-danger remove-event no-display">

							<i class='fa fa-trash-o'></i> Delete Event

						</button>

						<button type='submit' class='btn btn-success save-event'>

							<i class='fa fa-check'></i> Save

						</button>

					</div>

				</div>

			</div>

		</div>



		<!-- start ajax model -->

		<div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>

		<!-- end ajax model -->



		<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-hidden="true">

				<div class="modal-content">

					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">

							&times;

						</button>

						<h4 class="modal-title">Category info</h4>

					</div>

					<div class="modal-body">

						<p>

							Do you want to permanent delete the category?

						</p>

					</div>

					<div class="modal-footer">

						<button aria-hidden="true" data-dismiss="modal" class="btn btn-default">

							Close

						</button>

						<button class="btn btn-default" data-dismiss="modal" id="confdel">

							Confirm

						</button>

					</div>

				</div>

		</div>





		<!-- start: MAIN JAVASCRIPTS -->

		<?php $this->load->view("common/footer"); ?>

		<!-- end: MAIN JAVASCRIPTS -->

		<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>

		<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script>

        <script>

			jQuery(document).ready(function() {

				//TableData.init();

				category_load();

			});





			function category_load() {



			    $('#sub_category_table').DataTable({

			        "ajax": '<?php echo base_url("product_category/get_sub_Category/$parent_cat_id"); ?>',

			        "bDestroy": true

			    });

			}



            function sub_category_edit(category_id) {



                var $modal = $('#ajax-modal');

                    

                    $('body').modalmanager('loading');

                    setTimeout(function () {

                        $modal.load('<?php echo base_url("product_category/edit_sub_category/'+category_id+'"); ?>', '', function () { 

                            $modal.modal();

                        $("select.search-select").select2({

                            allowClear: true

                        });

                    });

                    }, 1000);



            }



			function sub_perm_delete(sub_category_id) {



				$("#myModal4").modal();

	            $("button#confdel").attr("sub_cat_id",sub_category_id);



			}





			$("button#confdel").click(function() {



				$.ajax({

				    url : "<?php echo base_url('product_category/sub_category_permanent_delete'); ?>",

				    type: "POST",

				    data : {sub_cat_id:$(this).attr("sub_cat_id")},

				    success: function(data)

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

                                    set_message('categories notice!','Subcategory permanent deleted successfully');

                                    category_load();

                                };

				    }

    			});

			});



		</script>



  



		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

	</body>

	<!-- end: BODY -->

</html>