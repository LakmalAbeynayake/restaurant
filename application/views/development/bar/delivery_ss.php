<div class="col-md-12" style="padding:20px;">
  <div class="col-md-10" style="padding:0px;">
    <div class="panel panel-default">

    
      <div class="panel-heading"> <i class="fa fa-truck"></i> DELIVERY 
        <div class="panel-tools pull-right"> 
          <!--<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                  </a>
                                  <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
                                      <i class="fa fa-wrench"></i>
                                  </a>--> 
          
          <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="fas fa-sync-alt" id="delivery-panel-refresh"> Refresh</i> </a> 
          <!--<a class="btn btn-xs btn-link panel-close" href="#">
                                      <i class="fa fa-times"></i>
                                  </a>--> 
        </div>
      </div>
      <div class="panel-body">
        <div id="error"></div>
        <table width="100%" class="table table-bordered table-condensed table-hover table-striped dataTable" id="delivery_table">
          <thead>
            <tr>
              <th style="width:5%">ID#</th>
              <th style="width:10%">Time</th>
              <!--<th>Invoice No</th>-->
              <th>Customer</th>
              <th>Sale Items</th>
              <th>Grand Total</th>
              <!--<th>Return</th>-->
              <!--<th>Balance</th>-->
              <th>Payment Status</th>
              <th>Paying By</th>
              <th width="10px">Collect</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>ID#</th>
              <th>Time</th>
              <!--<th>Invoice No</th>-->
              <th>Customer</th>
              <th>Sale Items</th>
              <th>Grand Total</th>
              <!--<th>&nbsp;</th>-->
              <!--<th>Balance</th>-->
              <th>Payment Status</th>
              <th>Paying By</th>
              <th>Collect</th>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="col-xs-2">
        <input id="string" class="form-control" type="hidden" value="credit"/>
      </div>
    </div>
  </div>
</div>
