<?php $this->load->view("common/header"); ?>
<style type="text/css">
.table > thead:first-child > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table-striped thead tr.primary:nth-child(2n+1) th {
	background-color: #428bca;
	border-color: #357ebd;
	border-top: 1px solid #357ebd;
	color: white;
	text-align: center;
}
.label {
	font-size: 100% !important;
	padding: 1em 0.6em !important;
	text-transform: capitalize;
}
body {
	font-size: 18px;
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
  
  <!-- start: PAGE -->
  
  <div class=""> 
    
    <!-- end: SPANEL CONFIGURATION MODAL FORM -->
    
    <div class="container"> 
      
      <!-- start: PAGE HEADER --> 
      
      <!-- end: PAGE HEADER --> 
      
      <!-- start: PAGE CONTENT 

                    <!-- start grid -->
      
      <div class="col-md-12" style="padding:20px;">
        <div class="col-md-12" style="padding:0px;">
          <div class="panel panel-default">
            <div class="panel-body">
              <table id="dine_in_table" class="table table-condensed dataTable" style="width:100%">
                <thead>
                  <tr>
                    <th class="col-xs-1">Ref NO</th>
                    <th class="col-xs-1">Order Type</th>
                    <th class="col-xs-1">Recieved Time</th>
                    <th class="col-xs-1">Floor</th>
                    <th class="col-xs-1">Area</th>
                    <th class="col-xs-1">Table</th>
                    <th class="col-xs-4">&nbsp;</th>
                    <th class="col-xs-2">Print</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th class="col-xs-1">Ref NO</th>
                    <th class="col-xs-1">Order Type</th>
                    <th class="col-xs-1">Recieved Time</th>
                    <th class="col-xs-1">Floor</th>
                    <th class="col-xs-1">Area</th>
                    <th class="col-xs-1">Table</th>
                    <th class="col-xs-4">&nbsp;</th>
                    <th class="col-xs-2">Print</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
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

<!-- end: MAIN JAVASCRIPTS --> 

<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script>
<?php /*?><script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/dataTables.buttons.min.js">

	</script> 
<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/buttons.print.min.js">

	</script> 
<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/buttons.flash.min.js">

	</script> 
<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/jszip.min.js">

	</script> 
<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/pdfmake.min.js">

	</script> 
<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/vfs_fonts.js"></script> 
<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/buttons.html5.min.js"></script> 
<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>js/buttons.print.min.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script> <?php */?>
<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script> 
<script>
$(document).ready(function(e) {
    loadGrid();
    setInterval(function(){
	    console.log("running....");
	    print_kot_auto();
	}, 10000);
});
function loadGrid() {
	table = $('#dine_in_table').DataTable({
		"dom": "Bftrip",
		"bProcessing": true,
		"ajax": {
			"url": "<?php echo base_url('restaurant/restaurant/kitchen_screen_details') ?>",
			"data": {},
			"complete": function () {
				}
		},
		"bPaginate": false,
		"autoWidth": false,
		"bDestroy": true,
		"iDisplayLength": 500,
		"bFilter":false,
		"order": [
			[0, "asc"]
		],
		"createdRow": function( row, data, dataIndex){
                if( data[4] ==  "RESTAURANT"){
                    $(row).css('background-color','#EACE0B')
					.css('color','#000000')
					.css('font-weight','bold');
                }
				if( data[4] ==  "BLUE LOUNGE"){
                    $(row).css('background-color','#745FEF')
					.css('color','#fff').css('font-weight','bold');
                }
				if( data[4] ==  "MAIN BAR"){
                    $(row).css('background-color','#F24044')
					.css('color','#fff').css('font-weight','bold');
                }
            }
	});
}
	

print_kot_auto();

function complete_sale_cook(id,type) {
	bootbox.confirm('CONTINUE ?',function (e){
			if(e){
	jQuery.ajax({
		type: "POST",
		url: "<?php echo base_url().'restaurant/restaurant/complete_sale_cook'?>",
		data: {
			sale_id: id,
			status: 'completed',
			type:type
		},
		cache: false,
		success: function (response) {
			displayNotice('page', 'K.O.T Completed !!');
			loadGrid();
		}
	});
	}
			});
}
function print_kot(id) {
	u = location.href;
	t = document.title;
	window.open('<?php echo base_url() ?>sales/print_kot?sale_id=' + id, 'sharer', 'toolbar=0,status=0,width=626,height=700, left=10, top=10,scrollbars=yes');
	return false;
}

function change_status(id,status,type){
	
		bootbox.confirm('CONTINUE ?',function (e){
			if(e){
					jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url().'restaurant/restaurant/change_status' ?>",
					data:{
						id:id,
						status:status,
						type:type
						},
					cache: false,
					success: function(response)
					{
						displayNotice('page','Cleared Successfully !!');
						loadGrid();
					}
					});
				}
			});
		
	
}


function check_kot(){
    jQuery.ajax({
    	type: "POST",
    	url: "<?php echo base_url().'sales/check_kot' ?>",
    	cache: false,
    	dataType: 'json',
    	success: function(response)
    	{
    		console.log(response);
    	}
	});
}



function print_kot_auto() {
	u = location.href;
	t = document.title;
	window.open('<?php echo base_url() ?>sales/print_kot_auto', 'sharer', 'toolbar=0,status=0,width=626,height=700, left=10, top=10,scrollbars=yes');
	return false;
}


</script>
</body>

<!-- end: BODY -->

</html>