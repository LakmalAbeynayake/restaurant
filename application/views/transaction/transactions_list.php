<?php echo $this->load->view("common/header"); ?>
<!-- end: HEAD -->

<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<!--<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/select2/select2.css" />
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />
<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">-->


<!--<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/jQuery-Tags-Input/jquery.tagsinput.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/summernote/build/summernote.css">-->

<style type="text/css">
    .table > thead:first-child > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table-striped thead tr.primary:nth-child(2n+1) th {
        background-color: #428bca;
        border-color: #357ebd;
        border-top: 1px solid #357ebd;
        color: white;
        text-align: center;
    }

</style>
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
                                    Pay Role 
                                </a>
                            </li>

                            <li class="active">Transaction</li>
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
                            <h1>Transaction</h1>
                        </div>

                        <p>Please use the table below to navigate or filter the results. </p>
                    </div>
                </div>
                <!-- end: PAGE HEADER -->
                <!-- start: PAGE CONTENT 
                <!-- start grid -->
                <div class="row">
                    <div class="col-md-12">
                    
    <!--start search box-->  
    <div class="panel panel-default">
								<div class="panel-heading">
									 <i class="fa fa-external-link-square"></i>
									Search
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
										</a>
										
										<a class="btn btn-xs btn-link panel-refresh" href="#">
											<i class="fa fa-refresh"></i>
										</a>
										<a class="btn btn-xs btn-link panel-expand" href="#">
											<i class="fa fa-resize-full"></i>
										</a>
										<a class="btn btn-xs btn-link panel-close" href="#">
											<i class="fa fa-times"></i>
										</a>
									</div>
								</div>
								<div class="panel-body">
									
                           <!--start search-->                       
<div class="col-md-12">
 <?php
$sett_admin_saparate_for_warehouse=0;
$new_mod_com=new Common_Model();
$sett_admin_saparate_for_warehouse=$new_mod_com->check_option_valable_by_setting_id(10);
if($sett_admin_saparate_for_warehouse) $display=false;

//$display=true;
?>
<div class="col-sm-3"  <?php if(!$display) echo 'style="display:none"'; ?>>
<div class="form-group">
<label>Warehouse </label>
<select id="srh_warehouse_id" class="form-control" name="srh_warehouse_id">

<?php 
$ss_warehouse_id=$this->session->userdata('ss_warehouse_id'); 
foreach ($warehouse_list as $row)
{
$sel='';
if($ss_warehouse_id==$row->id)
{
$sel=' selected="selected"';
}
?>  

<option value="<?php echo $row->id; ?>" <?php echo $sel; ?>>
<?php echo $row->name; ?>
</option>
<?php }?>

</select>                                          
</div>
</div>

<div class="col-sm-3">
<div class="form-group">
<label>Type </label>

<select class="select2-container form-control" id="fxd_ass_id" name="fxd_ass_id">
                          <option value="">-- Select Transaction--</option>
						  <?php foreach($transactions_type as $row){
							  $sel='';
					  if(isset($transactions_details['fxd_ass_id'])){
						  if($transactions_details['fxd_ass_id']==$row['fxd_ass_id']){
						  $sel='selected="selected"';
						  }
						  } ?>
                          <option <?php echo $sel; ?> value="<?php echo $row['fxd_ass_id'];?>"><?php echo $row['fxd_ass_name'];?></option>
                          <?php }?>
                            </select>                                         
</div>
</div>

 

<div class="col-sm-3">

                                                      	<div class="form-group">

															<label for="s2id_autogen1">From Date </label>

                                                            <!--<input id="srh_from_date" name="srh_from_date" type='text' class="form-control date-picker" value="<?php echo date('m/d/Y'); ?>" data-bv-field="date"/>-->
                                                            
                   <input id="srh_from_date" name="srh_from_date" type='text' class="form-control date" value="" data-bv-field="date"/>                                         
                                                            

                                                            

														</div>

													</div>
                                                        <div class="col-sm-3">

                                                      	<div class="form-group">

															<label for="s2id_autogen1">To Date </label>

                                                             <input id="srh_to_date" name="srh_to_date" type='text' class="form-control date" value="" data-bv-field="date"/>                                         
                   

                                                            

														</div>

													</div>
                                                    
                                                    <div class="col-md-3" style="margin-top:21px;">
                  <input class="btn btn-primary" value="Search" name="search" id="search" type="submit" onClick="search_by_custum_value()"> 
                  <input name="add_category" value="Reset" class="btn btn-danger" onClick="location.reload()" type="submit">
                  </div> 
                  
                 
</div> 
<!--end search-->           
                                    
								</div>
							</div>
    
    <!--end search box-->  
    
    
    
    <!--start list table-->  
    <div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-search"></i>
									Salary List
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
										</a>
										
										<a class="btn btn-xs btn-link panel-refresh" href="#">
											<i class="fa fa-refresh"></i>
										</a>
										<a class="btn btn-xs btn-link panel-expand" href="#">
											<i class="fa fa-resize-full"></i>
										</a>
										<a class="btn btn-xs btn-link panel-close" href="#">
											<i class="fa fa-times"></i>
										</a>
									</div>
                                    
                                    <div class="panel-tools" style="top:2px;">
                                   <i class="fa fa-external-link-square"></i>
								    transactions
                                  <div class="panel-tools" style="top:2px;">
											   <button class="btn btn-blue dropdown-toggle" data-toggle="dropdown">
													<i class="clip-list-5"></i> Add New
												</button>
												<ul class="dropdown-menu dropdown-light pull-right">
														<li>
															<a id="modal_ajax_transactions_btn" data-toggle="modal" href="#">
																<i class="fa fa-plus"></i> Add  Transactions
														  </a>
														</li>
														
													</ul>
												</div>
                                </div>
                                
								</div>
								<div class="panel-body">
									
                         <table class="table table-bordered table-condensed table-hover table-striped dataTable" id="transactions_table">
									  <thead>
							              <tr>
                                                <th>No</th>
												<th>Name</th>
												<th>Type</th>
												<th>Cat</th>
                                                <th>Date</th>
                                                <th>Amount</th>
												<th>Actions</th>
                                    </tr>
							          </thead>
							          <tfoot>
											   <tr>
                                                <th>No</th>
                                                <th>Name</th>
												<th>Type</th>
												<th>Cat</th>
												<th>Date</th>
												<th>Amount</th>											
												<th>Actions</th>
                                    </tr>
								           
						          </table>
                         
                         
                           
                        </div>
							</div>   
      <!--end list table-->                                    
                    
                        <!-- start: DYNAMIC TABLE PANEL -->
                        
                       
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
            
        </div>
        <div class="footer-items">
            <span class="go-top"><i class="clip-chevron-up"></i></span>
        </div>
    </div>
    <!-- end: FOOTER -->

    <!-- start ajax model -->
    <div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
    <!-- end ajax model -->

    <!-- start: MAIN JAVASCRIPTS -->
    <?php $this->load->view("common/footer"); ?>
    <!-- end: MAIN JAVASCRIPTS -->
   
  
   <script src="<?php echo asset_url(); ?>js/jquery-ui.js" ></script>		

		<script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script>

		<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script>
        <script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>
         <script type="text/javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script>
         
         
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/dataTables.buttons.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/buttons.print.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/buttons.flash.min.js">
	</script>
	
    <script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/jszip.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/pdfmake.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/vfs_fonts.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/buttons.html5.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/buttons.print.min.js"></script>
   
   <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script>

          <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>     
          
          <script src="<?php echo asset_url(); ?>/plugins/select2/select2.min.js"></script>  
          
    <script>
    
    
    function print_transaction(id){
        u = location.href;
        t = document.title;
        window.open('transactions/print_transaction?id=' + id+'&dd=1', 'sharer', 'toolbar=0,status=0,width=350,height=700, left=10, top=10,scrollbars=yes');
        return false;
    }
	
	 $('#srh_from_date').datetimepicker({
        format: 'YYYY-MM-DD',

         <?php
//if (isset($salary_byid['sl_date']))
 {
    $d = date("Y, m-2, d", strtotime(date("Y-m-d"))); //(1985,01,01)
    ?>
            defaultDate: new Date (<?php echo $d ?>)
<?php }
// else
 { ?>
           // defaultDate: new Date()
<?php } ?>

        });
		
		 $('#srh_to_date').datetimepicker({
        format: 'YYYY-MM-DD',

            defaultDate: new Date()


        });
	
	jQuery(document).ready(function() {
//FormElements.init();
//var tomorrow = new Date();
//currentDate=tomorrow.setDate(tomorrow.getDate() + 1);
loadGrid();
});

        jQuery(document).ready(function () {
          //  loadGrid();
        });

function search_by_custum_value(){
	loadGrid();
}
        function loadGrid() {
			var warehouse_name=$( "#srh_warehouse_id option:selected" ).text();
			var warehouse_id=$("#srh_warehouse_id").val();
			var srh_to_date=$("#srh_to_date").val();
			var srh_from_date=$("#srh_from_date").val();
			var fxd_ass_id=$("#fxd_ass_id").val();
			var srh_user_name='';
			var data = $('#srh_user_id').select2('data');
			if(data) {
				srh_user_name=data.text;
			}			
			var srh_user_id=$("#srh_user_id").val();
			var message="<div  style='text-align:center'>  <h2>"+warehouse_name+"</h2><h4>User Payment Details</h4><h5>Employee : "+srh_user_name+"</h5><h5>From Date: "+srh_from_date+" , To Date: "+srh_to_date+"</h5></div>";
            $('#transactions_table').DataTable({
				"sDom": '<"top"lfB>rt<"bottom"ip><"clear">',
					buttons: [
       { extend: 'print', text: 'Print',footer: true, message: message,title: '',
	   exportOptions:{
		stripHtml:false,
		columns: [ 0, 1, 2, 5, 6, 7 ]
		// columns: [ 0, ':visible' ],
	},
	   },
       { extend: 'excel', text: 'Save as Excel',footer: true, message: message,title: ''},
	
    ],
				"bProcessing": true,
        		"serverSide": true,
				"ajax": {
								 'type': 'POST',
								 'url': '<?php echo base_url('transactions/transactions_load') ?>',
								 'data': {
								 fxd_ass_id: fxd_ass_id,
								 warehouse_id:warehouse_id,
								 srh_to_date:srh_to_date,
								 srh_from_date:srh_from_date
								}
							 },
               // "ajax": "<?php echo base_url('salary/get_salary_list') ?>",
                "bDestroy": true,
                "iDisplayLength": 10,
				 "lengthMenu": [[10,50,150,-1], [10,50,150,'All']],
                "order": [[0, "desc"]],
				"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;	 
				// Remove the formatting to get integer data for summation
				var intVal = function ( i ) {
					return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ?	i : 0;
				};
				var col_1=0;
				var table = $('#transactions_table').DataTable();
				<?php			?>
					},
            });
        }
        $('a#modal_ajax_salary_btn').on('click', function () {
            $('body').modalmanager('loading');
            setTimeout(function () {
                $modal.load('<?php echo base_url("salary/create_salary"); ?>', '', function () {

                    $modal.modal();

                });
            });
        });
function update_transactions(acctrnss_id){	
//alert(fxd_ass_id);	
	var $modal = $('#ajax-modal');
	 $('body').modalmanager('loading');
			setTimeout(function () {
				$modal.load('<?php echo base_url("transactions/create_transactions?acctrnss_id="); ?>'+acctrnss_id, '', function () {
					$modal.modal();
					/*$("#country_id").select2();
					$(".search-select").select2({
				         placeholder: "Select a State",
				         allowClear: true
				    });*/
				});
			}, 1000);
}


        jQuery(document).ready(function () {
            //conirm
            $("#conirm").click(function () {
                var sel_id = $('#sel_id').val();
                var popup_type = $('#popup_type').val();
                var page = $('#page').val();
                var id = sel_id;

                if (page == 'salary_list') {
                    if (popup_type == 'delete') {
                        $.post("<?php echo base_url('salary/delete') ?>", {id: id})
                                .done(function (data) {
                                    var obj = jQuery.parseJSON(data);
                                    loadGrid();// load supplier data
                                    displayNotice('page', 'Salary has been deleted successfully!');
                                   // location.reload(true);
                                });
                    }
                } //end page check
            });


        });


        function deleteSalaryData(id) {
            $("#myModal4").modal();
            $('#sel_id').val(id);
            $('#popup_type').val('delete');
            $('#page').val('salary_list');
            $("#label").text("Are you sure you want to delete this Salary?");
        }
        function click_salary_btn(id) {

            var $modal = $('#ajax-modal');
            $('body').modalmanager('loading');

            setTimeout(function () {
                $modal.load('<?php echo base_url("salary/create_salary?mstr_sal_id="); ?>' + id, '', function () {
                    $modal.modal();
                });
            }, 1000);
        }
		
        $(".js-data-user-ajax-srh").select2({
        ajax: {
        url: "<?php echo base_url('salary/getUser') ?>",
                dataType: 'json',
                delay: 10,
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
                var text1 = item.user_first_name + "  (" + item.user_group_name + ")";
                return {
                text: text1,
                        slug: item.user_first_name,
                        id: item.user_id
                };
                })
                };
                },
                cache: true
        }
        });
    </script>
</body>