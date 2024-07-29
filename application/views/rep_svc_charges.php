<?php $this->load->view("common/header"); ?>
<!-- end: HEAD -->
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
        </div>
      </div>
      <div id="print-section">
        <div class="page-header">
          <h1>Service Charge Report</h1>
        </div>
        <p>Please use the table below to navigate or filter the results. </p>
        
        <!-- end: PAGE HEADER --> 
        <!-- start: PAGE CONTENT 
                    <!-- start grid -->
        <div class="row">
          <div class="col-md-12"> 
            <!-- start: DYNAMIC TABLE PANEL -->
            <div class="panel panel-default">
              <div class="panel-heading"> <i class="fa fa-external-link-square"></i> Sales Report
                <div class="panel-tools" style="top:2px;">
                  <button onClick="printDiv('printableArea')" class="btn btn-blue dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-print"></i> </button>
                </div>
              </div>
            </div>
            <div class="panel-body">
              <div id="error"></div>
              <div class="col-md-12">
                <div class="panel panel-default">
                  <div style="font-weight: 700;" class="panel-heading"></div>
                  <div class="panel-body">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Warehouse </label>
                        <select id="srh_warehouse_id" class="form-control" name="srh_warehouse_id">
                          <!-- <option value="">-- Select Warehouse --</option>-->
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
                <div id="printableArea">
                        <div style="font-weight:bold">From Date: <span id="f-date-txt"><?php echo $from; ?></span>, To Date: <span id="t-date-txt"><?php echo $to; ?></span></div>
                  <table class="table table-bordered table-condensed table-hover table-striped dataTable" id="summary_table">
                    <thead>
                    <th>Description</th>
                      <th>Values</th>
                      </thead>
                    <tbody>
                      
                      <tr>
                        <th>Sales</th>
                        <td style="text-align:right"><div class="money"><?php echo ($total > 0)?$total:"0.00"; ?></div></td>
                      </tr>
                      <!--<tr>-->
                      <!--  <th>Sales Return</th>-->
                      <!--  <td><div id="sales-rtn-val-tbl">Loading....</div></td>-->
                      <!--</tr>-->
                      <tr>
                        <th>10% Amount</th>
                        <td style="text-align:right"><div class="money"><?php echo $amount_10p; ?></div></td>
                      </tr>
                      <tr>
                        <th>10% Breakage</th>
                        <td style="text-align:right"><div class="money"><?php echo $amount_10b; ?></div></td>
                      </tr>
                      <tr>
                        <th style="background-color:#C93">Total Payable Service Charge</th>
                        <td style="background-color:#C93;text-align:right"><div class="money"><?php echo $amount_10p-$amount_10b; ?></div></td>
                      </tr>
                    </tbody>
                    <tfoot>
                    </tfoot>
                  </table>
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
  </div>
  <!-- end: MAIN CONTAINER --> 
  <!-- start: FOOTER -->
  <div class="footer clearfix">
    <div class="footer-inner"> 2018 &copy; smartsalleepos.com </div>
    <div class="footer-items"> <span class="go-top"><i class="clip-chevron-up"></i></span> </div>
  </div>
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
<input name="sales-rtn-val-cost" type="hidden" id="sales-rtn-cost-fld" value="0">
<input name="sales-rtn-val-fld" type="hidden" id="sales-rtn-val-fld" value="0">
<input name="sale-fld" type="hidden" id="sale-fld" value="0">
<input name="cost-fld" type="hidden" id="cost-fld" value="0">

<!-- start ajax model -->
<div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
<!-- end ajax model --> 

<!-- start: MAIN JAVASCRIPTS -->
<?php $this->load->view("common/footer"); ?>
<!--<script src="<?php echo asset_url(); ?>js/jquery-ui.js" ></script> -->
<script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script> 
<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script> 
<!--<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datepicker.js"></script> -->
<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script> 
<!-- <script src="<?php echo asset_url(); ?>js/main.js"></script>--> 
<!-- end: MAIN JAVASCRIPTS --> 
<script>
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

function searchDetailsReset() {
    $('#srh_to_date').val('');
    $('#srh_from_date').val('');
    window.location.href = '<?php echo base_url();?>reports/service_charge';
}

jQuery(document).ready(function() {
    var tomorrow = new Date();
    currentDate = tomorrow.setDate(tomorrow.getDate() + 1);
    $('#srh_to_date').datetimepicker({
        <?php echo ($to != '')?"":"defaultDate: new Date(),"; ?>
        format: "YYYY/MM/DD"
    });
    $('#srh_from_date').datetimepicker({
        <?php echo ($from != '')?"":"defaultDate: new Date(),"; ?>
        format: "YYYY/MM/DD"
    });
    
    $('.money').each(function(){
        var money = $(this).html();
        $(this).html(accounting.formatMoney(money, "", 2, ",", "."));
    });
});

function searchDetails() {
    var srh_from_date = $('#srh_from_date').val();
    var srh_to_date = $('#srh_to_date').val();
    var srh_warehouse_id = $('#srh_warehouse_id').val();
    $.ajax({
        type:'POST',
        url :'<?php echo base_url();?>' + 'reports/service_charge',
        data:{
            from: srh_from_date,
            to  : srh_to_date,
            warehouse_id: srh_warehouse_id
        }
    });
    window.location.href = '<?php echo base_url();?>reports/service_charge?from='+srh_from_date+'&to='+srh_to_date;
}
</script>
</body>
<!-- end: BODY -->
</html>