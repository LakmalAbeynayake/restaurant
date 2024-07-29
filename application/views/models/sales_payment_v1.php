<style type="text/css">
td {
	font-size:11px;
}
</style>
			<?php 
$config = array('role' =>'form', 'class'=>'form-horizontal','id'=>'create_sales_payment_form', 'name'=>'create_category_form');
echo form_open_multipart(base_url("#"),$config);
?>
<?php //print_r($category_details) ?>
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">ADD PAYMENTS</h4>
            
            </div>
            <div class="modal-body">
                <div id="error"></div>
                <font style="color:#333;">Please fill in the information below. The field labels marked with * are required input fields.</font>
                
 <div class="row">
 <div class="col-md-12">               
<div class="col-sm-5">
<div class="form-group has-feedback">
<input name="sale_id" type="hidden" id="sale_id" value="<?php echo $sale_id; ?>"/>
<input name="sale_type" type="hidden" id="sale_type" value="<?php echo $sale_type; ?>"/>
<label for="date">Date *</label> 
<input id="sale_pymnt_date_time" name="sale_pymnt_date_time" type='text' class="form-control date" value=""/>
</div>
</div><!--col-sm-5-->
<div class="col-sm-5 pull-right">
<div class="form-group">
<label for="reference_no">Reference No</label> <input type="text" id="sale_pymnt_ref_no" class="form-control tip" value="" name="sale_pymnt_ref_no">
</div>
</div><!--col-sm-5 pull-right-->
</div><!--row-->
</div><!--col-md-12-->

<div class="clearfix"></div>

 <div class="row">
 <div class="col-md-12">
<div class="well well-sm well_1">             
<div class="col-sm-5">
<div class="form-group has-feedback">
<label for="date">Amount *</label> <input type="text" id="sale_pymnt_amount" class="form-control datetime text-right" value="" name="sale_pymnt_amount" data-bv-field="date" onchange="calculateBalance(this.value);" onclick="this.select();" autofocus><br />
<label for="date">Cash</label> <input type="text" autofocus="" onclick="this.select();" onchange="calculateBalance(this.value);" data-bv-field="date" name="sale_pymnt_given_amount" value="0.00" class="form-control datetime text-right" id="sale_pymnt_given_amount">
<br>
<label for="date">Cash Change </label> <input type="text" autofocus="" data-bv-field="date" name="sale_pymnt_balance_amount" value="0.00" class="form-control datetime text-right" id="sale_pymnt_balance_amount">
</div>
</div><!--col-sm-5-->
<div class="col-sm-5 pull-right">
<div class="form-group">
<label for="reference_no">Paying by *</label> 
<select class="form-control paid_by" id="sale_pymnt_paying_by" name="sale_pymnt_paying_by" data-bv-field="paid_by" tabindex="-1" title="Paying by *" onchange="changePayingby(this.value)">
<option value="Cash">Cash</option>
<option value="Credit Card">Credit Card</option>
<option value="Cheque">Cheque</option>
</select>
</div>



</div><!--col-sm-5 pull-right-->
<div class="clearfix"></div>


<div id="cheque_dtls" style="display:none;" class="paying_by_details">
<label for="date">Cheque No *</label> <input type="text" id="sale_pymnt_cheque_no" class="form-control datetime" value="" name="sale_pymnt_cheque_no" data-bv-field="date">
</div> <!--cheque-->

<div id="credit_card" style="display:none;" class="paying_by_details">
<div class="col-sm-5">
<div class="form-group">
<input type="text" id="sale_pymnt_crdt_card_no" class="form-control tip" value="" name="sale_pymnt_crdt_card_no" placeholder="Credit Card No *">
</div>
</div> <!--col-sm-5-->
<div class="col-sm-5 pull-right">
<div class="form-group">
<input type="text" id="sale_pymnt_crdt_card_holder_name" class="form-control tip" value="" name="sale_pymnt_crdt_card_holder_name" placeholder="Holder Name *">
</div>
</div> <!--col-sm-5-->

<div class="col-sm-3" style="margin-right:60px;">
<div class="form-group">
<select class="form-control paid_by" id="sale_pymnt_crdt_card_type" name="sale_pymnt_crdt_card_type" data-bv-field="paid_by">
<option value="Visa">Visa</option>
<option value="MasterCard">MasterCard</option>
<option value="Amex">Amex</option>
<option value="Discover">Discover</option>
</select>
</div>
</div> <!--col-sm-3-->

<div class="col-sm-3">
<div class="form-group">
<input type="text" id="sale_pymnt_crdt_card_month" class="form-control tip" value="" name="sale_pymnt_crdt_card_month" placeholder="Month *">
</div>
</div> <!--col-sm-3-->

<div class="col-sm-3 pull-right">
<div class="form-group">
<input type="text" id="sale_pymnt_crdt_card_year" class="form-control tip" value="" name="sale_pymnt_crdt_card_year" placeholder="Year *">
</div>
</div> <!--col-sm-3-->
</div> <!--credit_card-->
<div class="clearfix"></div>

</div><!--well well-sm well_1-->
</div><!--row-->
</div><!--col-md-12-->

 <div class="clearfix"></div>            
                
            <div class="row form-group">
             <div class="col-md-12">
                    <h5>Note</h5>
                    <p>
                    <input type="text" class="form-control" name="sale_pymnt_note" id="sale_pymnt_note" value="">
                    </p>
            <div class="modal-footer">
            <input type="submit" name="add_category" value="Add Payment" class="btn btn-primary">
            </div>
            </div>
            </div>
            </div>

  </form>

		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY VALIDATION-->
		<script src="<?php echo asset_url(); ?>js/form-validation-sales_payment.js"></script>
        
        
        		<!--[if gte IE 9]><!-->
		
        
        
        		<?php //$this->load->view("common/footer"); ?>
              
		<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>		
		<script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script>
		<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script>
        
         <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script>
          <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>

          
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY  VALIDATION-->
                        
	 <script>
	 function displayPayments(){
	 	var total_paymnt_tmp=parseFloat($('#total_paymnt_tmp').val());
		 //alert(total_paymnt_tmp);
		 var paid_tmp=parseFloat($('#paid_tmp').val());
		 var needtopay=0;
		 needtopay=total_paymnt_tmp-paid_tmp;
		 if(needtopay<0) {
			 needtopay=0;
		 }
		 //lert(total_paymnt_tmp-paid_tmp)
		 
		 
	 }
	 
	 function setAmount(){
		 var total_paymnt_tmp=parseFloat($('#total_paymnt_tmp').val());
		 var paid_tmp=parseFloat($('#paid_tmp').val());
		 var amount=parseFloat($('#total_paymnt_tmp').val());
		  $('#sale_pymnt_amount').val((total_paymnt_tmp-paid_tmp));
		 
	 }
	 
	 setAmount();
	 
	 displayPayments();
	 
	 function calculateBalance(amount){
		 var total_paymnt=parseFloat($('#total_paymnt').val());
		 var total_paid=parseFloat($('#total_paid').val());
		 var amount=parseFloat(amount);
		 
		 
		 
		 if(isNaN(amount)) {
			  set_message('Error!','Please enter valid amount');
		
			$('#sale_pymnt_amount').val('');
			
		 }else {
			 if(amount=='0.00'){
				 
			 }else {
				 $('#sale_pymnt_amount').val((amount));
			 }
			 
		 var balance=total_paymnt-amount-total_paid;
		 //balance=11;
		 $('#nw_paid_amt_dis').text(convertToAmount(amount));
		 $('#balance_amt_dis').text(convertToAmount(balance));
		 }

		 
		 //alert();
		 
		 
		// $('#sale_pymnt_amount').focus();
		//setTimeout(alert(),1000)
		 //alert(amount);
	 }
	 
function convertToAmount(val)
{
	var disval=val; //+'.00'; //.toFixed(val);
	return accounting.formatMoney(disval, "", 2, ",", "."); // €4.999,99 
}


		
	 function changePayingby(val){

	   	$('.paying_by_details').hide();	
		if(val=='Credit Card'){
			$('#credit_card').show();	
		}
		if(val=='Cheque'){
			$('#cheque_dtls').show();	
		}
	 }

			jQuery(document).ready(function() {
				FormValidator.init();
				
				jQuery.noConflict();
				jQuery('#sale_pymnt_date_time').datetimepicker({
					defaultDate: new Date()
				});
				
				calculateBalance(0);
				
			});


        function add_sale_payments(form) {
                    //$('body').modalmanager('loading');
                    setTimeout(function () {
                        $.ajax({
                        url: "<?php echo base_url('sales/add_sale_payments'); ?>", // Url to which the request is send
                        type: "POST",             // Type of request to be send, called as method
                        data: new FormData(form), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                        contentType: false,       // The content type used when sending data to the server.
                        cache: false,             // To unable request pages to be cached
                        processData:false,        // To send DOMDocument or non processed data file it is set to false
                        success: function(data)   // A function to be called if request succeeds
                        {
                            var obj = jQuery.parseJSON(data);
                            if (obj.status==0) 
                                {
                                    $('#error').html('<div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><i class="fa fa-times-circle"></i> Error!</h4>'+obj.validation+'</div>');
                                   // $('body').modalmanager('removeLoading');
                                } 
                                else
                                {
                                   // $('body').modalmanager('removeLoading');
                                    $('div#ajax-modal').modal('hide');
                                    set_message('Sales Notice!','Payment successfully added');
									location.reload(true);
                                };

                        }
                        });
                    }, 0);
              
			  

        }
		
		
			   

		</script>          
