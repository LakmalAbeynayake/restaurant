<?php /*?><div class="col-md-12" >

    

  </div><?php */?>
  
  <div class="panel panel-default" style="padding:0px; max-height:760px; overflow-y:scroll; min-width:700px">

      <div class="panel-heading"> <i class="fa fa-truck"></i> DELIVERY

        <div class="panel-tools pull-right"> 

          <!--<a class="btn btn-xs btn-link panel-collapse collapses" href="#">

                                  </a>

                                  <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">

                                      <i class="fa fa-wrench"></i>

                                  </a>--> 

          

          <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="fa fa-refresh" id="delivery-panel-refresh"> Refresh</i> </a> 

          <!--<a class="btn btn-xs btn-link panel-close" href="#">

                                      <i class="fa fa-times"></i>

                                  </a>--> 

        </div>

      </div>

      <div class="panel-body">

        <table class="table table-bordered table-condensed table-hover table-striped dataTable" id="delivery_table" style="width:100%">

          <thead>

            <tr>

              <th class="col-xs-1">ID#</th>

              <th class="col-xs-1">Time</th>

              <!--<th>Invoice No</th>-->

              <th class="col-xs-2">Customer</th>

              <th class="col-xs-3">Sale Items</th>

              <th class="col-xs-1">Grand Total</th>

              <th>PS</th> 

              <th>Location</th>
<?php /*?>
              <th class="col-xs-1">Payment Status</th>

              <th class="col-xs-2">Paying By</th>

              <th class="col-xs-1">Actions</th><?php */?>

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

              <th>PS</th> 

              <th>Location</th>

          <?php /*?>    <th>Payment Status</th>

              <th>Paying By</th>

              <th>Actions</th><?php */?>

            </tr>

          </tfoot>

        </table>

      </div>

      

    </div>