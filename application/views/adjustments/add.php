<?php
$this->load->view("common/header");
?>
<!-- end: HEAD -->

<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->

<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">

<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />

<style type="text/css">
    label {
        font-weight: 700;
    }

    .table>thead:first-child>tr:first-child>th,
    .table>thead:first-child>tr:first-child>td,
    .table-striped thead tr.primary:nth-child(2n+1) th {
        background-color: #428bca;
        border-color: #357ebd;
        border-top: 1px solid #357ebd;
        color: white;
        text-align: center;
    }

    .table th,
    .table td {
        vertical-align: middle !important;
    }
    
    /**/
    input[type="text"][readonly] {
        /* Your styles for readonly text inputs */
        background-color: #f4f4f4; /* Example background color */
        color: #666; /* Example text color */
        border: 1px solid #ccc; /* Example border color */
        cursor: not-allowed; /* Example cursor style */
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
                                <a href="#">
                                    Dashboard
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    Stock Adjesment
                                </a>
                            </li>

                            <li class="active">
                                Add Stock Adjesment
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
                            <h1>Add Stock Adjesment</h1>
                        </div>

                        <p>Please fill in the information below. The field labels marked with * are required input fields.</p>
                    </div>
                </div>
                <!-- end: PAGE HEADER -->
                <!-- start: PAGE CONTENT 
                    <!-- start grid -->
                <form class="bv-form" accept-charset="utf-8" method="post" enctype="multipart/form-data" role="form" id="save_adj">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger" style="<?php $s = validation_errors();
                                                                    if (empty($s)) {
                                                                        echo 'display:none';
                                                                    } ?>">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <?php echo validation_errors(); ?>
                            </div>
                            <!-- start: DYNAMIC TABLE PANEL -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-plus"></i>
                                    Apply Adjustments
                                    <input type="hidden" id="uuid" name="uuid" value="">
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Date *</label>

                                                <input type="datetime-local" required id="adj_date" class="form-control date" name="adj_date" value="" onchange="formatDate(this)">
                                                
                                                <input type="hidden" id="new_date" value="">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Location *</label>
                                                <select id="location_id" name="location_id" class="form-control search-select" onchange="get_data()">
                                                    <?php
                                                     $sel='';
                                                    foreach ($warehouse as $key => $wh) {
                                                     if($this->session->userdata('ss_warehouse_id') == $wh->id)
    												  {
    													  $sel=' selected="selected"';
    												  }else $sel = '';
                                                        echo "<option $sel value=" . $wh->id . ">" . $wh->name . "</option>";
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="sticker" class="col-md-12">
                                        <div class="well well-sm">
                                            <div style="margin-bottom:0;" class="form-group">
                                                <div class="input-group wide-tip">
                                                    
                                                    
                                                </div>
                                            </div>


                                            <div class="clearfix"></div>
                                            <div class="control-group table-group">
                                                <label class="table-label">Order Items</label>
                                                <div class="col-md-12">
                                                    <br>
                                                    <div style="display:flex;justify-content: space-between;">
                                                        <?php
                                                            foreach($types as $type){
                                                                echo '<label style="background: #ffffff;padding: 10px;border: solid 2px #7f7fff;border-radius: 10px;" for="pt_'.$type->product_type_id.'"> <input id="pt_'.$type->product_type_id.'" checked type="checkbox" class="product_type" style="width: 20px;height: 20px;vertical-align: bottom;" value="'.$type->product_type_id.'"> '.$type->product_type_name.' </label>';
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="controls table-controls">
                                                    <table class="table items table-striped table-bordered table-condensed table-hover" id="adj_table">
                                                        <thead>
                                                            <tr>
                                                                <th class="col-md-4">Item Name (Item Code)</th>
                                                                <th class="col-md-1">System Quantity</th>
                                                                <th class="col-md-1">Physical Quantity</th>
                                                                <th class="col-md-1">Adjustment</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td colspan="4" class="text-center">Loading <i class="fa fa-spinner fa-spin"></i> </td>
                                                            </tr>
                                                            <?php 
                                                            /*
                                                            ?>
                                                            <tr data-product_id = "${data.product_id}" >
                                                                <th>
                                                                    <!--Item Name (Item Code)-->
                                                                    <input name="data[product_id]['pid']" value="${data.product_id}" type="hidden" >
                                                                    ${data.product_name}
                                                                </th>
                                                                <th>
                                                                    <!--System Quantity-->
                                                                    <input name="data[product_id]['qty']" value="${data.closing_balance}" type="hidden">
                                                                    ${data.closing_balance}
                                                                </th>
                                                                <th>
                                                                    <!--Physical Quantity-->
                                                                    <input name="data[product_id]['phy']" value="" type="text"   class="">
                                                                </th>
                                                                <th>
                                                                    <!--Adjustment-->
                                                                    <input name="data[product_id]['adj']" value="0" type="text" readonly id="adj_${data.product_id}">
                                                                </th>
                                                            </tr>
                                                            <?php 
                                                            */
                                                            ?>
                                                        </tbody>
                                                        <tfoot>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <label for="ponote">Note</label> <textarea name="note" cols="40" rows="10" class="form-control" id="ponote" style="margin-top: 10px; height: 100px;"></textarea>
                                        </div>
                                        
                                        <div class="col-md-12">
										    <div class="from-group">
										        <input type="submit" id="submitbtn" name="submit" style="padding: 6px 15px; margin:15px 0;" class="btn btn-primary" value="Submit" >
										        <button id="reset" class="btn btn-danger" type="reset">Reset</button>
										    </div>
										</div>
                                        
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- end: DYNAMIC TABLE PANEL -->
                    </div>
            </div>
            <!-- end grid -->
            </form>
        </div>
        <!-- end: PAGE -->
    </div>
    <!-- end: MAIN CONTAINER -->
    <!-- start: FOOTER -->
    <div class="footer clearfix">
        <div class="footer-inner">
            2018 &copy; smartsalleepos.com
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

    <!-- start: MAIN JAVASCRIPTS -->
    <?php $this->load->view("common/footer"); ?>

    <script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
    <!--<script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script>-->
    <script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script>
    <?php /*?><script type="text/javascript" src="<?php echo asset_url(); ?>js/perches.js"></script><?php */ ?>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>
    <!--<script type="text/javascript" src="<?php echo asset_url(); ?>js/form-validation-add_grn.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/addmenu.js"></script>-->

    <script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script>

    <!-- end: MAIN JAVASCRIPTS -->
    <script type="text/javascript">
    
        var defaultHTMLContent = '';
        $(document).ready(()=>{
            defaultHTMLContent = getDefaultHTMLContent("adj_table");
            $('#uuid').val(uuidv4());
            $('#adj_table > tbody').empty();
            
            $(document).on('keydown', function(event) {
                if (event.key === 'Enter') {
                    if (event.ctrlKey) {
                        // If Ctrl+Enter is pressed, submit the form
                        $(event.target).closest('form').submit();
                    } else if (event.shiftKey) {
                        // Prevent default Enter key behavior
                        event.preventDefault();
                        
                        // Get the currently focused element
                        var $current = $(event.target);
    
                        // Find the previous input element of type text that is not disabled, readonly, and visible within #adj_table
                        var $inputs = $('#adj_table').find('input[type="text"]:not(:disabled):not([readonly]):visible');
                        var currentIndex = $inputs.index($current);
                        var $prev = $inputs.eq(currentIndex - 1);
                        
                        // If there is a previous input, focus on it
                        if ($prev.length) {
                            $prev.focus();
                        }
    
                        return false;
                    } else {
                        // Prevent default Enter key behavior
                        event.preventDefault();
                        
                        // Get the currently focused element
                        var $current = $(event.target);
    
                        // Find the next input element of type text that is not disabled, readonly, and visible within #adj_table
                        var $inputs = $('#adj_table').find('input[type="text"]:not(:disabled):not([readonly]):visible');
                        var currentIndex = $inputs.index($current);
                        var $next = $inputs.eq(currentIndex + 1);
                        
                        // If there is a next input, focus on it
                        if ($next.length) {
                            $next.focus();
                        }else{
                            var $first = $inputs.eq(0);
                            if ($first.length) {
                                $first.focus();
                            }
                        }
    
                        return false;
                    }
                }
            });
        });
        
        //function to initiate bootstrap-datepicker
        $(function() {
            /*$('#adj_date').datetimepicker({
                defaultDate: '',
                format : "YYYY-MM-DD"
            }).on('dp.change', function(e) {
                get_data();
                // Your onchange event handling code here
                // console.log("Selected date changed to: " + e.date.format("YYYY-MM-DD"));
            });*/
             // Get today's date
            var today = new Date();
            
            // Set the maximum date to today
            var maxDate = today.toISOString().substring(0, 10); // Keep only the date part
            var maxTime = "T23:59"; // Set the time to 11:59 PM
            var maxDateTime = maxDate + maxTime;
            
            // Set the minimum date to 3 days before today
            var threeDaysAgo = new Date(today);
            threeDaysAgo.setDate(today.getDate() - 3);
            var minDate = threeDaysAgo.toISOString().substring(0, 10); // Keep only the date part
            var minTime = "T00:00"; // Set the time to 12:00 AM
            var minDateTime = minDate + minTime;
            
            // Set the min and max attributes of the input element
            document.getElementById("adj_date").setAttribute("min", minDateTime);
            document.getElementById("adj_date").setAttribute("max", maxDateTime);
            $("#adj_date").focus();
        });
        function formatDate(input) {
            // Get the value of the input element
            let dateValue = input.value;
            
            // Split the date value by '-'
            let parts = dateValue.split('-');
            
            // Rearrange the date parts in YYYY-MM-DD format
            let formattedDate = parts[0] + '-' + (parts[1].length === 1 ? '0' + parts[1] : parts[1]) + '-' + (parts[2].length === 1 ? '0' + parts[2] : parts[2]);
            
            // Set the formatted date back to the input element
            //input.value = formattedDate;
            
            $('#new_date').val(formattedDate);
            get_data();
        }

        
        async function get_data() {
            console.log($('#new_date').val());
            const date = $('#new_date').val();
            const location_id = $('#location_id').val();
            
            if(date === ''){
                bootbox.alert("Date is required",()=>{
                    $("#adj_date").focus();
                });
                return false;
            }
            
            resetTable();
            // Make an AJAX post request
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>stock_adjesment/get_daily_stock",
                data: {
                    date: date,
                    location_id: location_id
                },
                dataType: 'json',
                success: function(response) {
                    
                    manage_resp(response).then(function() {
                        // This code runs after the $.each() loop completes
                        init_dt();
                    });
                },
                error: function(error) {
                    console.error("Error in AJAX request:", error);
                    alert("Error in AJAX request");
                }
            });
        }
        
        function manage_resp(response) {
            $('#adj_table > tbody').empty();
            return new Promise(function(resolve, reject) {
                $.each(Object.keys(response), (a, b) => {
                    var data = response[b];
                    var tr_html = `
                        <tr data-product_id="${data.product_id}" data-product_type="${data.product_type}">
                            <th>
                                <input name="data[${data.product_id}][pid]" value="${data.product_id}" type="hidden">
                                ${data.product_name}
                            </th>
                            <th>
                                <input name="data[${data.product_id}][qty]" value="${data.closing_balance}" type="hidden">
                                ${data.closing_balance.toFixed(2)}
                            </th>
                            <th>
                                <input name="data[${data.product_id}][phy]" value="" type="text" class="">
                            </th>
                            <th>
                                <input name="data[${data.product_id}][adj]" value="0" type="text" readonly id="adj_${data.product_id}">
                            </th>
                        </tr>
                    `;
        
                    $('#adj_table > tbody').append(tr_html);
        
                    // Resolve the Promise when the loop completes
                    if (a === Object.keys(response).length - 1) {
                        resolve();
                    }
                });
            });
        }
        
        function init_dt() {
            $('#adj_table').DataTable({
                paging: false,
                destroy: true
            });
        }
        
        $(document).on('change','input',function(){
            allowDecimals(this);
            var product_id = $(this).closest('tr').data('product_id');
            var physical_qty = this.value;
            var system_qty   = $(`[name="data[${product_id}][qty]"]`).val();
            
            var adjustment_qty = physical_qty - system_qty;

            $(`[name="data[${product_id}][adj]"]`).val(adjustment_qty);
        });
        
        function sanitize_before(){
            
            $('body').modalmanager('loading');

            $('input[name^="data["][name$="][phy]"]').each(function() {
                $(this).prop('readonly', true);
            });

            $('#adj_table > tbody > tr').each(function(a,b){
                product_id = $(this).data('product_id');
                var adj_qty   = $(`[name="data[${product_id}][adj]"]`).val();
                if(adj_qty == 0){
                    $(`input[name="data[${product_id}][pid]"]`).prop('disabled', true);
                    $(`input[name="data[${product_id}][qty]"]`).prop('disabled', true);
                    $(`input[name="data[${product_id}][phy]"]`).prop('disabled', true);
                    $(`input[name="data[${product_id}][adj]"]`).prop('disabled', true);
                }
            });
        }
        
        function allowDecimals(inputElement) {
            inputElement.addEventListener('change', function() {
                // Get the value entered by the user
                let value = inputElement.value.trim();
        
                // Check if the entered value is a valid number
                if (isNaN(value)) {
                    // If not a valid number, set the value to 0
                    inputElement.value = 0;
                } else {
                    // If it's a valid number, update the value to its float representation
                    inputElement.value = parseFloat(value);
                }
            });
        }
        function applyHTMLContent(elementId, htmlContent) {
            var element = document.getElementById(elementId);
            if (element) {
                element.innerHTML = htmlContent;
            } else {
                console.error("Element not found with ID: " + elementId);
            }
        }
        function getDefaultHTMLContent(elementId) {
            var element = document.getElementById(elementId);
            if (element) {
                return element.innerHTML;
            } else {
                return null; // Element not found
            }
        }
        function resetTable() {
            applyHTMLContent("adj_table", defaultHTMLContent);
        }

        $(document).on('change','.product_type',function(){
           var type = this.value;
           
           if($(this).prop('checked') === true)
           {
               $(`[data-product_type="${type}"]`).show();
               return;
           }
           $(`[data-product_type="${type}"]`).hide();
        });
        
        $('#save_adj').on('submit', function(e) {
            e.preventDefault();
            
            // Show Bootbox confirmation dialog
            bootbox.confirm({
                message: "Are you sure you want to submit this form?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if (result) {
                        sanitize_before();
                        $('#submitbtn').prop('disabled', true);
                        var fields = $("#save_adj").serialize();
                        $.ajax({
                            url: "<?php echo base_url() ?>stock_adjesment/save_adjustment",
                            type: "POST",
                            dataType: "json",
                            data: fields,
                            success: function(response) {
                                if(response.success) {
                                    window.location.href = "<?php echo base_url() ?>adjustments/view/" + response.last_id;
                                } else {
                                    bootbox.alert("ERROR!");
                                    console.log(response);
                                }
                            },
                            error: function(error) {
                                // Handle error
                                console.error("Error:", error);
                            }
                        });
                        console.log(fields);
                    }
                }
            });
        });
        
        function uuidv4() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0,
                    v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }
    </script>
</body>
<!-- end: BODY -->

</html>