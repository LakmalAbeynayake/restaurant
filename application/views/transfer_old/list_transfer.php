<?php $this->load->view("common/header"); ?>

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
            <li> <a href="<?php echo base_url('dashboard'); ?>"> DASHBOARD </a> </li>
            <li> <a href="<?php echo base_url('marketing'); ?>"> STOCK TRANSFER </a> </li>
            <li class="active"> LIST  TRANSFER  </li>
            <li class="search-box">
              <form class="sidebar-search">
                <div class="form-group">
                  <input type="text" placeholder="Start Searching...">
                  <button class="submit"> <i class="clip-search-3"></i> </button>
                </div>
              </form>
            </li>
          </ol>
          <div class="page-header">
            <h3>LIST TRANSFER   </h3>
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
            <div class="panel-heading"> <i class="fa fa-external-link-square"></i> LIST TRANSFER 
              <div class="panel-tools" style="top:2px;">
                <ul class="dropdown-menu dropdown-light pull-right">
                  <li> </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="panel-body">
            <div id="error"></div>
            <table class="table table-bordered table-condensed table-hover table-striped dataTable" id="warehouse_table">
              <thead>
                <tr>
                  <th>DATE</th>
                  <th>TRANSFER NO</th>
                  <th class="col-md-1">REF.NO</th>
                  <th>USER NAME</th>
                   <th>OUTLET NAME</th>
                   <th class="col-md-1">STATUS</th>
                    <th class="col-md-1">GRN STATUS</th>
                  <th class="col-md-1">Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>DATE</th>
                  <th>TRANSFER NO</th>
                  <th class="col-md-1">REF.NO</th>
                  <th>USER NAME</th>
                   <th>OUTLET NAME</th>
                    <th class="col-md-1">STATUS</th>.
                    <th class="col-md-1">GRN STATUS</th>
                  <th class="col-md-1">Action</th>
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
  <div class="footer-inner"> 2014 &copy; clip-one by cliptheme. </div>
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

<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url('thems/js/bootbox.min.js'); ?>"></script>
<?php $type="1";?>
<script>

			jQuery(document).ready(function() {
    loadGrid();
});

function loadGrid() {
    $('#warehouse_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "<?php echo base_url('stock_transfer/get_transfer_list') ?>",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ],
        "fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay) {}
    });
}
var table = $('#warehouse_table').DataTable();
$('#warehouse_table tbody').on('click', 'tr', function() {});

function approval_requste(id) {
    bootbox.confirm({
        title: "Are You Sure ?",
        message: "Do you want to approval this price list ?.",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> No Cancel'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Yes Confirm'
            }
        },
        callback: function(result) {
            if (result == true) {
                jQuery.ajax({
                    type: "POST", 
                    url: "<?php echo base_url().'price_adminstration/approval_price_list?id='?>" + id,
                           data: 'id='+id,
                    cache: false,
                    success: function(response) {
                        var obj = JSON.parse(response);
                        if (obj.status == 1) {} else {
                            bootbox.alert({
                                message: obj.message,
                                size: 'small'
                            });
                        }
                        loadGrid();
                    }
                });
            }
        }
    });
}


function reject_requste(id) {
    bootbox.confirm({
        title: "Are You Sure ?",
        message: "Do you want to reject this price list?.",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> No Cancel'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Yes Confirm'
            }
        },
        callback: function(result) {
            if (result == true) {
                jQuery.ajax({
                    type: "POST", 
                    url: "<?php echo base_url().'price_adminstration/reject_price_list?id='?>" + id,
                           data: 'id='+id,
                    cache: false,
                    success: function(response) {
                        var obj = JSON.parse(response);
                        if (obj.status == 1) {} else {
                            bootbox.alert({
                                message: obj.message,
                                size: 'small'
                            });
                        }
                        loadGrid();
                    }
                });
            }
        }
    });
}





		</script>
</body>

<!-- end: BODY -->

</html>