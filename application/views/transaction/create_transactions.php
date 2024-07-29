		<style type="text/css">
		    body .modal {
		        /* new custom width */
		        width: 750px;
		        /* must be half of the width, minus scrollbar on the left (30px) */
		        margin-left: -375px;
		    }
		</style>
		<form role="form" class="form-horizontal" id="create_fixed_assets_form" action="#" method="post">
		    <input type="hidden" value="<?php echo $type; ?>" name="type" id="type" />
		    <input type="hidden" value="<?php echo $acctrnss_id; ?>" name="acctrnss_id" id="acctrnss_id" />
		    <form role="form" class="form-horizontal" id="create_fixed_assets_form" action="#">
		        <div class="modal-header">
		            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		            <h4 class="modal-title"><?php echo $pageName ?></h4>
		            <font style="color:#333;">Please fill in the information below. The field labels marked with * are required input fields.</font>
		        </div>
		        <div class="modal-body">
		            <input type="hidden" value="" name="uuid" id="uuid" />
		            <div id="error"></div>
		            <div class="row">
		                <div class="col-md-12">
		                    <div class="col-sm-12 collapse">
		                        <div class="form-group">
		                            <h5>Business * </h5>
		                            <select class="select2-container form-control" id="business" name="business">
		                                <option value="">-- Select--</option>
		                                <option value="1">Retail</option>
		                                <option value="2">Destribution</option>
		                            </select>
		                        </div>
		                    </div>
		                    <div class="col-md-5">
		                        <?php //print_r($transactions_details);
                                ?>
		                        <!-- <div class="form-group">
                    <h5>Code*</h5>
                   <input type="text" class="form-control" name="fxd_ass_serial_no" id="fxd_ass_serial_no" <?php echo (isset($transactions_details['fxd_ass_serial_no'])) ? 'value="' . $transactions_details['fxd_ass_serial_no'] . '"' : null; ?>>
                    </div>-->
		                        <div class="form-group">
		                            <h5>Transaction * </h5>
		                            <?php // print_r($transactions_type);
                                    ?>
		                            <select class="select2-container form-control" id="fxd_ass_id" name="fxd_ass_id" onchange="fxd_ass_id_cahnge(this.value)">
		                                <option value="">-- Select Transaction--</option>
		                                <?php foreach ($transactions_type as $row) {
                                            $sel = '';
                                            if (isset($transactions_details['fxd_ass_id'])) {
                                                if ($transactions_details['fxd_ass_id'] == $row['fxd_ass_id']) {
                                                    $sel = 'selected="selected"';
                                                }
                                            } ?>
		                                    <option <?php echo $sel; ?> value="<?php echo $row['fxd_ass_id']; ?>"><?php echo $row['fxd_ass_name']; ?></option>
		                                <?php } ?>
		                            </select>
		                        </div>
		                        <div id='etp_id_wap' class="form-group" <?php if (empty($transactions_details['etp_id'])) echo 'style="display:none"'; ?>>
		                            <h5>Expences Type * </h5>
		                            <?php //print_r($transactions_type);
                                    ?>
		                            <select class="select2-container form-control" id="etp_id" name="etp_id">
		                                <option value="">-- Select Expences Type--</option>
		                                <?php foreach ($mstr_expences_type_list as $row) {
                                            $sel = '';
                                            if (isset($transactions_details['etp_id'])) {
                                                if ($transactions_details['etp_id'] == $row['etp_id']) {
                                                    $sel = 'selected="selected"';
                                                }
                                            } ?>
		                                    <option <?php echo $sel; ?> value="<?php echo $row['etp_id']; ?>">
		                                        <?php echo $row['etp_name']; ?></option>
		                                <?php } ?>
		                            </select>
		                        </div>
		                        <div class="form-group">
		                            <h5>Transactions Amount*</h5>
		                            <input type="text" class="form-control" name="acctrnss_amount" id="acctrnss_amount" <?php echo (isset($transactions_details['acctrnss_amount'])) ? 'value="' . $transactions_details['acctrnss_amount'] . '"' : null; ?>>
		                        </div>
		                    </div>
		                    <div class="col-md-5 pull-right">
		                        <div class="form-group">
		                            <h5> Date *</h5>
		                            <?php $nowdate = date("Y-m-d H:i:s"); ?>
		                            <input id="acctrnss_date" name="acctrnss_date" type='text' class="form-control date" value="" />
		                        </div>
		                        <div class="form-group">
		                            <h5>Details</h5>
		                            <textarea type="text" class="form-control" name="acctrnss_details" id="acctrnss_details"><?php if (isset($transactions_details['acctrnss_details'])) {
                                                                                                                                    echo htmlentities($transactions_details['acctrnss_details']);
                                                                                                                                } ?> </textarea>
		                        </div>
		                    </div>
		                </div> <!--col-md-12-->
		            </div>
		            <div class="modal-footer">
		                <input type="submit" name="add_category" value="<?php echo $btnText; ?>" class="btn btn-primary">
		            </div>
		    </form>
		    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION -->
		    <script src="<?php echo base_url(); ?>thems/js/form-validation-fix-assets.js"></script>
		    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
		    <script type="text/javascript">
		        function fxd_ass_id_cahnge(fxd_ass_id) {
		            //var id = $(this).children(":selected").attr("id");
		            //alert(this.value)
		            // alert(1);
		            // var fxd_ass_id=$("#fxd_ass_id").val();
		            //alert(fxd_ass_id);
		            if (fxd_ass_id == 5) {
		                $("#etp_id_wap").show()
		            } else {
		                $("#etp_id_wap").hide()
		            }
		        }
		        jQuery(document).ready(function() {
		            FormValidator.init();
		            //$("#fa_type_id").select2();
		            var currentDate = new Date();
		            if ($('#type').val() == "E") {
		                $('#acctrnss_date').datetimepicker({
		                    format: 'YYYY/MM/DD',
		                    defaultDate: "<?php if (isset($transactions_details['acctrnss_date'])) {
                                                echo $transactions_details['acctrnss_date'];
                                            } ?>"
		                });
		            }
		            if ($('#type').val() == "A") {
		                $('#acctrnss_date').datetimepicker({
		                    format: 'YYYY/MM/DD',
		                    defaultDate: currentDate
		                });
		            }

		            $('#uuid').val(uuidv4());
		        });
		        function insertFixedAssetsData() {
		            var fields = $('#create_fixed_assets_form').serialize();
		            //alert(fields);
		            $.post("<?php echo base_url('transactions/save_transactions'); ?>", fields)
		                .done(function(data) {
		                    var obj = jQuery.parseJSON(data);
		                    if (obj.status == 0) {
		                        $('div#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>' + obj.validation + '</div>');
		                        $('body').modalmanager('removeLoading');
		                        $('body').attr('class', '');
		                    } else {
		                        $('div#ajax-modal').modal('hide');
		                        loadGrid(); // load customer data
		                        if (obj.type == 'E') {
		                            displayNotice('page', 'Transactions has been updated successfully!');
		                        }
		                        if (obj.type == 'A') {
		                            displayNotice('page', 'Transactions has been added successfully!');
		                        }
		                        setTimeout(
		                            function() {
		                                location.reload(true);
		                                //do something special
		                            }, 1000);
		                    }
		                });
		            return false;
		        }
		        $(':checkbox').on('change', function() {
		            $(':checkbox').not(this).prop('checked', false);
		        });
		        
		        function uuidv4() {
                    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                        var r = Math.random() * 16 | 0,
                            v = c == 'x' ? r : (r & 0x3 | 0x8);
                        return v.toString(16);
                    });
                }
		    </script>