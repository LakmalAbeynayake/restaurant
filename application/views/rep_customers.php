<?php $this->load->view("common/header"); ?>
<!-- end: HEAD -->

<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/jQuery-Tags-Input/jquery.tagsinput.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/summernote/build/summernote.css">
<style type="text/css">
.table > thead:first-child > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table-striped thead tr.primary:nth-child(2n+1) th {
	background-color: #428bca;
	border-color: #357ebd;
	border-top: 1px solid #357ebd;
	color: white;
	text-align: center;
}
#s2id_srh_customer_id {
	border: 0 none;
	padding: 0;
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
      <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button"> <span class="clip-list-2"></span> </button>
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
          <li> <a href="<?php echo base_url('dashboard'); ?>"> Dashboard </a> </li>
          <li> <a href="#"> Reports </a> </li>
          <li class="active"> Sales Report </li>
          <li class="search-box">
            <form class="sidebar-search">
              <div class="form-group">
                <input type="text" placeholder="Start Searching...">
                <button class="submit"> <i class="fa fa-search"></i> </button>
              </div>
            </form>
          </li>
        </ol>
        <div class="page-header">
          <h1>Customer Report</h1>
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
          <div class="panel-heading"> <i class="fa fa-external-link-square"></i> Customer Report
            <div class="panel-tools" style="top:2px; display:none">
              <button onClick="JavaScript:fbs_click('<?php echo base_url('reports/print_sale?srh_warehouse_id=1'); ?>');" class="btn btn-blue dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-print"></i> </button>
            </div>
          </div>
        </div>
        <div class="panel-body">
          <div id="error"></div>
          <div class="col-md-12">
            <div class="panel panel-default">
              <div style="font-weight: 700;" class="panel-heading"></div>
              <div class="panel-body">
                <div class="col-sm-4 collapse"> 
                  <div class="form-group">
                    <label>Warehouse </label>
                    <select id="srh_warehouse_id" class="form-control search-select" name="srh_warehouse_id">
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
                      <option value="<?php echo $row->id; ?>" <?php echo $sel; ?>> <?php echo $row->name; ?> </option>
                      <?php }?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Customer </label>
                    <select id="srh_customer_id" class="form-control search-select" name="srh_customer_id">
                      <option value="">-Select-</option>
                      <?php 
															
															foreach ($customer_list as $row)
															{
																
															?>
                      <option <?php echo 'value="'.$row['cus_id'].'"'; /*echo ($row['cus_id'] == 1)?'selected':'';*/ ?>><?php echo $row['cus_name']; if($row['cus_phone']) echo " / ".$row['cus_phone'];?> </option>
                      <?php }  ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Payment Status </label>
                    <select id="srh_payment_status" class="form-control search-select" name="srh_payment_status">
                      <option value="">-Select-</option>
                      <option value="Pending">Pending</option>
                      <option value="Partial">Partial</option>
                      <option value="Paid">Paid</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Paymet Term </label>
                    <select id="srh_payment_term" class="form-control search-select" name="srh_payment_term">
                      <option value="">-Select-</option>
                      <option value="Cash">Cash</option>
                      <option value="Cheque">Cheque</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-4 collapse">
                  <div class="form-group">
                    <label for="in_type">Sales Terms * </label>
                    <select id="in_type" class="form-control search-select" name="in_type">
                      <option value="">-Select-</option>
                      <option value="Cash">Cash</option>
                      <option value="Credit">Credit</option>
                      <option value="Wholesale">Wholesale</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>From Date </label>
                    <input id="srh_from_date" name="srh_from_date" type='text' class="form-control date" value="" data-bv-field="date"/>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="s2id_autogen1">To Date </label>
                    <input id="srh_to_date" name="srh_to_date" type='text' class="form-control date" value="" data-bv-field="date"/>
                  </div>
                </div>
                <div class="col-sm-4 pull-right">
                  <div class="form-group">
                    <label for="s2id_autogen1">&nbsp;<br>
                      <br>
                    </label>
                    <input type="submit" name="add_category" value="Search" class="btn btn-primary" onClick="searchDetails()">
                    &nbsp;&nbsp;
                    <input type="submit" name="add_category" value="Reset" class="btn btn-danger" onClick="searchDetailsReset()">
                  </div>
                </div>
              </div>
            </div>
            <table class="table table-bordered table-condensed table-hover table-striped dataTable" id="warehouse_table">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Customer</th>
                  <th>Invoice No</th>
                  <th>Invoice Type</th>
                  <th>Payment Type</th>
                  <th>Grand Total</th>
                  <!--<th>Return</th>-->
                  <!--<th>Paid</th>-->
                  <th>Balance</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Date</th>
                  <th>Customer</th>
                  <th>Invoice No</th>
                  <th>Invoice Type</th>
                  <th>Payment Type</th>
                  <th>Grand Total</th>
                  <!--<th>Return</th>-->
                  <!--<th>Paid</th>-->
                  <th>Balance</th>
                </tr>
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
  <div class="footer-inner"> 2018 &copy; smartsalleepos.com </div>
  <div class="footer-items"> <span class="go-top"><i class="clip-chevron-up"></i></span> </div>
</div>
<!-- end: FOOTER --> 
<!-- start: RIGHT SIDEBAR --> 
<!-- end: RIGHT SIDEBAR -->
<div id="event-management" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
        <h4 class="modal-title">Event Management</h4>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-light-grey"> Close </button>
        <button type="button" class="btn btn-danger remove-event no-display"> <i class='fa fa-trash-o'></i> Delete Event </button>
        <button type='submit' class='btn btn-success save-event'> <i class='fa fa-check'></i> Save </button>
      </div>
    </div>
  </div>
</div>

<!-- start ajax model -->
<div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
<!-- end ajax model --> 

<!-- start: MAIN JAVASCRIPTS -->
<?php $this->load->view("common/footer"); ?>
<script src="<?php echo asset_url(); ?>js/jquery-ui.js" ></script> 
<script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script> 

<!-- end: MAIN JAVASCRIPTS --> 
<script>
function searchDetailsReset() {
    $('#srh_to_date').val('');
    $('#srh_from_date').val('');
}

function searchDetails() {
    loadGrid();
}
jQuery(document).ready(function() {
    //loadGrid();
    var currentDate = new Date();
    $('#srh_to_date').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });
    $('#srh_from_date').datetimepicker({
        //defaultDate: new Date(),
        format: 'YYYY-MM-DD'
    });
    //$("#srh_customer_id").select2({allowClear: true, placeholder: "Select an attribute"});
});

function loadGrid() {
    var srh_from_date = $('#srh_from_date').val();
    var srh_to_date = $('#srh_to_date').val();
    var srh_warehouse_id = $('#srh_warehouse_id').val();
    var srh_customer_id = $('#srh_customer_id').val();
    var srh_payment_status = $('#srh_payment_status').val();
    var srh_from_date2 = $('#srh_from_date').val();
    if (srh_from_date2) {
        srh_from_date2 = 'From :' + srh_from_date2 + '\n';
    }
    var srh_to_date2 = $('#srh_to_date').val();
    if (srh_to_date2) {
        srh_to_date2 = 'To :' + srh_to_date2;
    }
    var srh_customer_id2 = $('#srh_customer_id option:selected').text();
    if (srh_customer_id2) {
        srh_customer_id2 = '\n Customer :' + srh_customer_id2;
    }
    var srh_payment_status2 = $('#srh_payment_status').val();
    if (srh_payment_status2) {
        srh_payment_status2 = '\n Payment Status :' + srh_payment_status2;
    }
    var srh_payment_term2 = $('#srh_payment_term').val();
    if (srh_payment_term2) {
        srh_payment_term2 = '\n Paymet Term :' + srh_payment_term2;
    }
    var in_type2 = $('#in_type').val();
    if (in_type2) {
        in_type2 = '\n Invoice Type :' + in_type2;
    }
    $('#warehouse_table').DataTable({
        dom: 'Blfrtip',
        buttons: [{
                extend: 'print',
                text: '<i class="fa fa-print fa-2x">',
                header: true,
                footer: true,
                /*autoPrint: false,*/
                title: "Baker's Choice Sales Report",
                exportOptions: {
                    columns: [0, 1, 3, 4, 6, 7]
                },
                message: srh_from_date2 + ' ' + srh_to_date2 + '<br/>' + srh_customer_id2 + '<br/>' + srh_payment_status2 + '<br/>' + srh_payment_term2,
                customize: function(win) {
                    $(win.document.body)
                        .css('font-size', '12pt')
                        .prepend(
                            '<img src="<?php echo asset_url(); ?>images/logo.png" style="position:absolute; top:0; left:0; height:60px;" />'
                        );
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                    //$(win.document.body).find( 'h1' ).html("<center>Baker's Choice Sales Report<br/></h1><h3 style='margin-top:-5px;'><?php echo $warehouse_details['address']; ?><br/><?php echo $warehouse_details['email']; ?><br/> <?php echo $warehouse_details['phone']; ?></h3></center>");
                    $(win.document.body).find('h1').append("<h3 style='margin-top:-5px;'><?php echo $warehouse_details['address']; ?><br/><?php echo $warehouse_details['email']; ?><br/> <?php echo $warehouse_details['phone']; ?></h3>").css("text-align", "center");
                    /*$(win.document.body).find('tr:nth-child(odd) td').each(function(index){
                   									 $(this).css('background-color','#D0D0D0');
													 });
												$(win.document.body).find('table').each(function(index){
                   									 $(this).css('width','0%');
													 //$(this).css('background-color','#D0D0D0');
													 });
												$(win.document.body).find('tr > th:nth-child(1)').each(function(index){
                   									 $(this).css('width','20px');
													 //$(this).css('background-color','#D0D0D0');
													 });
												$(win.document.body).find('tr > th:nth-child(2)').each(function(index){
                   									 $(this).css('width','20px');
													 //$(this).css('background-color','#D0D0D0');
													 });
													 
												$(win.document.body).find('tr > th:nth-child(3)').each(function(index){
                   									 $(this).css('width','20px');
													 //$(this).css('background-color','#D0D0D0');
													 });
													 
												$(win.document.body).find('tr > th:nth-child(4)').each(function(index){
                   									 $(this).css('width','20px');
													 //$(this).css('background-color','#D0D0D0');
													 });*/
                }
            },
            {
                extend: 'excel',
                text: '<i class="fa fa-file-excel-o fa-2x">',
                exportOptions: {
                    columns: [0, 1, 3, 4, 6, 7]
                },
                title: "Baker's Choice Customer Report \n <?php echo $warehouse_details['address']; ?> \n <?php echo $warehouse_details['email'];?>",
                //messageTop: "<?php echo $warehouse_details['address']; ?> ",
                message: srh_from_date2 + srh_to_date2 + srh_customer_id2 + srh_payment_status2 + srh_payment_term2,
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    console.log(sheet);
                    //  
                    //    $('c[r=A1] t', sheet).text( "Baker's Choice Customer Report");
                    //	$('c[r=A2] t', sheet).text( "<?php echo $warehouse_details['address']; ?>" );
                    //	$('c[r=A3] t', sheet).text( "From: "+ $('#srh_from_date').val()+" To:"+ $('#srh_to_date').val() );
                },
                footer: true
            },
            {
                extend: 'pdf',
                text: '<i class="fa fa-file-pdf-o fa-2x"></i>',
                orientation: 'landscape',
                footer: true,
                exportOptions: {
                    columns: [0, 1, 3, 4, 6, 7]
                },
                title: "Baker's Choice Customer Report \n <?php echo $warehouse_details['address']; ?>",
                message: srh_from_date2 + srh_to_date2 + srh_customer_id2 + srh_payment_status2 + srh_payment_term2,
                customize: function(doc) {
                    // doc.defaultStyle.fontSize = 16; //<-- set fontsize to 16 instead of 10 
                }
            }
        ],
        "ajax": {
            'type': 'POST',
            'url': '<?php echo base_url('reports/get_list_sales_for_print ');?>',
            'data': {
                srh_from_date: srh_from_date,
                srh_to_date: srh_to_date,
                srh_warehouse_id: srh_warehouse_id,
                srh_customer_id: srh_customer_id,
                srh_payment_status: srh_payment_status,
                srh_payment_term: $('#srh_payment_term').val(),
                in_type: $('#in_type').val()
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ]
    });
}

function fbs_click(url) {
    var srh_from_date = $('#srh_from_date').val();
    var srh_to_date = $('#srh_to_date').val();
    var srh_warehouse_id = $('#srh_warehouse_id').val();
    var srh_customer_id = $('#srh_customer_id').val();
    var srh_payment_status = $('#srh_payment_status').val();
    var d = new Date(srh_from_date);
    var srh_from_date = d.getDate() + "-" + (d.getMonth() + 1) + "-" + d.getFullYear();
    var d = new Date(srh_to_date);
    var srh_to_date = d.getDate() + "-" + (d.getMonth() + 1) + "-" + d.getFullYear();
    u = location.href;
    t = document.title;
    url = '<?php echo base_url();?>' + 'reports/print_sale?srh_warehouse_id=' + srh_warehouse_id + '&srh_from_date=' + srh_from_date + '&srh_to_date=' + srh_to_date + '&srh_customer_id=' + srh_customer_id + '&srh_payment_status=' + srh_payment_status;
    window.open(url, 'sharer', 'toolbar=0,status=0,width=750,height=436, left=10, top=10,scrollbars=yes');
    return false;
}
</script>
</body>
<!-- end: BODY -->
</html>