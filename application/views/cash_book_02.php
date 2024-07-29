<?php $this->load->view("common/header"); ?>
	<!-- end: HEAD -->
       
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/select2/select2.css" />
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />
		<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
		<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">


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
.padding_1{
	display: -moz-stack;
height: 20px;
width: 30px;;
}
.padding_2{
	display: -moz-stack;
height: 20px;
width: 60px;;
}

.button_print {
  -moz-user-select: none;
  background-color: #e9e9e9;
  background-image: linear-gradient(to bottom, #fff 0%, #e9e9e9 100%);
  border: 1px solid #999;
  border-radius: 2px;
  box-sizing: border-box;
  color: black;
  cursor: pointer;
  display: inline-block;
  font-size: 0.88em;
  margin-right: 0.333em;
  outline: medium none;
  overflow: hidden;
  padding: 0.5em 1em;
  position: relative;
  text-decoration: none;
  white-space: nowrap;
}

.table-condensed > thead > tr > th, .table-condensed > tbody > tr > th, .table-condensed > tfoot > tr > th, .table-condensed > thead > tr > td, .table-condensed > tbody > tr > td, .table-condensed > tfoot > tr > td {
  padding: 2px !important;
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
								<li>Account Summary And Petty Cash Details</li>
                                
								<li class="active"></li>
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
								<h1>Account Summary And Petty Cash Details</h1>
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
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								   Account Summary And Petty Cash Details
                                  <div class="panel-tools" style="top:2px;">
											 
												
												</div>
                                                
								</div>
                                <!--search start-->
                               
											
								<form class="bv-form" accept-charset="utf-8" method="post" enctype="multipart/form-data" role="form" action="" id="add_perchas">				
													<div class="panel-body">
                                                    
                                          <?php
$sett_admin_saparate_for_warehouse=0;
$new_mod_com=new Common_Model();
$sett_admin_saparate_for_warehouse=$new_mod_com->check_option_valable_by_setting_id(10);
if($sett_admin_saparate_for_warehouse) $display=false;
?>             
                                                     <div class="col-sm-3" <?php if(!$display) echo 'style="display:none"'; ?>>
                                                      	<div class="form-group">
															<label>Warehouse </label>
                                                            <?php //echo "";?>
                                                       <select id="srh_warehouse_id" class="form-control" name="srh_warehouse_id">
                                                                    
																  <?php 
																 $ss_warehouse_id=$this->session->userdata('ss_warehouse_id'); 
                                                              foreach ($warehouse_list as $row)
                                                              {
																  $sel='';
																  if($srh_warehouse_id==$row->id){
																	  $sel=' selected="selected"';
																  }else if($ss_warehouse_id==$row->id)
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
															<label>From Date  </label>
                                                        <!-- <input id="srh_from_date" name="srh_from_date" type='text' class="form-control date" value="" data-bv-field="date"/>     -->
                                                        
                                                        <input id="srh_from_date" name="srh_from_date" type='text' class="form-control date" value="" data-bv-field="date"/>
                                                        
                                                        <!-- <input id="srh_from_date" name="srh_from_date" type='text' class="form-control date-picker" value="<?php if($srh_from_date) echo $srh_from_date; else echo date('m/d/Y'); ?>" data-bv-field="date"/> -->                                                       
														</div>
														</div>
                                                        
                                                        <div class="col-sm-3">
                                                      	<div class="form-group">
															<label for="s2id_autogen1">To Date </label>
                                                            
                                                            <input id="srh_to_date" name="srh_to_date" type='text' class="form-control date" value="" data-bv-field="date"/>
                                                          
                                                         <!-- <input id="srh_to_date" name="srh_to_date" type='text' class="form-control date-picker" value="<?php if($srh_to_date) echo $srh_to_date; else echo date('m/d/Y'); ?>" data-bv-field="date"/>-->
															<!-- <input id="srh_to_date" name="srh_to_date" type='text' class="form-control date" value="" data-bv-field="date"/>        -->
														</div>
													</div>
                                                    
                                                    <div class="col-sm-3 pull-right">
                                                      	<div class="form-group">
															<label for="s2id_autogen1">&nbsp;<br><br>
</label>
                                                          
															<!-- type="submit"--> 
                                                            <input name="add_category" value="Search" class="btn btn-primary"  onClick="search_cash_book();"> &nbsp;&nbsp;
                                                             
                                                            <!-- <input type="submit" name="add_category" value="Reset" class="btn btn-danger">-->
														</div>
													</div>
                                                    </div>
                                                    </form>
                                                    
                                  </div>   
                                                
                                               
                                  <!--end start-->
                                  
                                    <div class="" style="">

<div class="panel-body">	
<input name="b_print" type="button" class="ip pull-rightt button_print"   onClick="printdiv('div_print');" value=" Print " style="float:right;">


<?php 
//print_r($fixed_assets_master_list);
$mod_rransactions=new Transactions_Model();
$mod_sales=new Sales_Model();
$balance_amount=0;
$debit_tot_amount=0;
$credit_tot_amount=0;

?>		
<div id="div_print" class="div_print">	
<div><h3 class="text-center" id="warehouse_name"></h3>
<p></p>

<h5 id="date_wap" class="text-center"></h5>
<h5 id="created_date_wap" class="text-center"></h5>


</div>




<!--Start Credit-->
<div class="col-sm-5 pull-left">		
 <h4 class="">Credit</h4>	
 <?php
 $tot_cash_credit=0;
 ?>   
<table class="table table-bordered table-condensed table-hover table-striped dataTable" id="fixed_assets_table">
  <tr>
    <th width="%" class="text-center">Description</th>
    <th width="%" class="text-center">Ref. No</th>
     <th width="%" class="text-center">Cash</th>
     <th width="%" class="text-center">Bank</th>
      </tr>
    

<?php
	  // print_r($mstr_expences_type_list);
	    foreach ($supplier_list as $row){
	    ?>
<tr>
       <td><?php echo $row->supp_company_name;?></td>
       <td></td>
       <td class="text-right"><div id="sup_grn_amount_<?php echo $row->supp_id;?>">0</div></td>
       <td class="text-right">&nbsp;</td>
       </tr>
<?php } ?>

<tr>
<td width="" class="">GRN Tot. Payments</td>
<td align="right"><?php //echo  sprintf("%04d", $atl->acctrnss_id);?></td>
<td width="" class="text-right"><div id="grn_payments">0</div></td>
<td width="" class="text-right">&nbsp;</td>
</tr>

<tr style="display:none">
<td width="" class="">Salary Advance</td>
<td align="right"><?php //echo  sprintf("%04d", $atl->acctrnss_id);?></td>
<td width="" class="text-right"><div id="salary_advance_payments">0</div></td>
<td width="" class="text-right">&nbsp;</td>
</tr>
  
  <tr style="display:none">
<td width="" class="">Salary </td>
<td align="right"><?php //echo  sprintf("%04d", $atl->acctrnss_id);?></td>
<td width="" class="text-right"></td>
<td width="" class="text-right"><div id="salary_payments">0</div></td>
  </tr>

 <tr style="display:none">
<td width="" class="">REP Expences </td>
<td align="right"><?php //echo  sprintf("%04d", $atl->acctrnss_id);?></td>
<td width="" class="text-right"><div id="rep_expences_payments">0</div></td>
<td width="" class="text-right">&nbsp;</td>
 </tr>

 <tr style="display:none">
<td width="" class="">Cash Expences </td>
<td align="right"><?php //echo  sprintf("%04d", $atl->acctrnss_id);?></td>
<td width="" class="text-right"><div id="cash_expences_payments">0</div></td>
<td width="" class="text-right">&nbsp;</td>
 </tr>

 <tr style="display:none">
<td width="" class="">Sales Related Expences </td>
<td align="right"><?php //echo  sprintf("%04d", $atl->acctrnss_id);?></td>
<td width="" class="text-right"><div id="sales_related_expences_payments">0</div></td>
<td width="" class="text-right">&nbsp;</td>
 </tr>

 <tr style="display:none">
<td width="" class="">Owner Withdrawls </td>
<td align="right"><?php //echo  sprintf("%04d", $atl->acctrnss_id);?></td>
<td width="" class="text-right"><div id="owner_withdrawls_payments">0</div></td>
<td width="" class="text-right">&nbsp;</td>
 </tr>

 <tr>
<td width="" class="">Bank Diposit</td>
<td align="right"><?php //echo  sprintf("%04d", $atl->acctrnss_id);?></td>
<td width="" class="text-right"><div id="bank_diposit_payments">0</div></td>
<td width="" class="text-right">&nbsp;</td>
 </tr>

  
<?php 
//echo "fa_type_id:".$fa_type_id;
$acc_transactions_list=array();
if($srh_from_date){
$acc_transactions_list=$mod_rransactions->get_acc_transactions_list("",$srh_from_date,$srh_to_date,$srh_warehouse_id);
}
//echo $this->db->last_query();
foreach ($acc_transactions_list as $atl)
{	 

if($atl->debit_credit=='Credit')
{
$tot_cash_credit+=$atl->acctrnss_amount;
?>
<?php 
}
}
//fixed_assets_list?>

<?php 
  //Start grn payment
  $grn_payment_list=array();
  $grn_payment_list=$mod_sales->get_grn_cash_book_data_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id);
  //print_r($cash_sale_list);
    foreach ($grn_payment_list as $gpl){
		 $tot_cash_credit+=$gpl->sale_pymnt_amount;
	?>
    <?php 
	} 
	 //End grn payment
	 ?>
     
     <?php 
  //Start salary payment
  $salary_payment_list=array();
  $salary_payment_list=$mod_sales->get_salary_payment_cash_book_data_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id);
  //print_r($cash_sale_list);
    foreach ($salary_payment_list as $spl){
		 $tot_cash_credit+=$spl->sp_amount;
	?>
    <?php 
	} 
	 //End grn payment
	 ?>
     <tr style="display:none">
       <td>Cash Collector Short</td>
       <td></td>
       <td class="text-right"><div id="cash_collector_short"></div></td>
       <td class="text-right">&nbsp;</td>
       </tr>
     <tr>
       <td>&nbsp;</td>
       <td></td>
       <td class="text-right">&nbsp;</td>
       <td class="text-right">&nbsp;</td>
     </tr>
     <tr>
       <td><strong>EXPENCES</strong></td>
       <td></td>
       <td class="text-right">&nbsp;</td>
       <td class="text-right">&nbsp;</td>
       </tr>
       
       
        <?php
	  // print_r($mstr_expences_type_list);
	    foreach ($mstr_expences_type_list as $row){
	    ?>
     <tr>
       <td><?php echo $row['etp_name'];?></td>
       <td></td>
       <td class="text-right"><div id="exp_amount_<?php echo $row['etp_id'];?>">0</div></td>
       <td class="text-right">&nbsp;</td>
       </tr>
       <?php } ?>
    
     <tr>
       <td><strong>Tot. Exp.</strong>&nbsp;</td>
       <td></td>
       <td class="text-right"><strong><div id="tot_expences"></div></strong></td>
       <td class="text-right">&nbsp;</td>
       </tr>
     <tr>
                    <td>Total</td>
                        <td></td>
                    
                    <td width="" class="text-right"><strong><div id="credit_total"></div></strong></td>
                    <td width="" class="text-right">&nbsp;</td>
           
                  </tr>
     <tr>
       <td>&nbsp;</td>
       <td></td>
       <td class="text-right">&nbsp;</td>
       <td class="text-right">&nbsp;</td>
       </tr>
       
        <?php
	  // print_r($mstr_expences_type_list);
	    for($k=0; $k<5; $k++){
	    ?>
     <tr>
       <td></td>
       <td></td>
       <td></td>
       <td class="text-right">&nbsp;</td>
       </tr>
       <?php } ?>
     <tr>
       <td>Cash B/B/F</td>
       <td></td>
       <td class="text-right"><div id="cash_b_b_f"></div></td>
       <td class="text-right">&nbsp;</td>
       </tr>
     <tr>
       <td><strong>Total Balance</strong></td>
       <td></td>
       <td class="text-right"><strong><div id="left_total_balance"></div></strong></td>
       <td class="text-right">&nbsp;</td>
       </tr>
    </table>
    </div>
 <!--End Credit-->  
 
 
 <!-- Start Debit -->
 <div class="col-sm-5 pull-left">		
 <h4 class="">Debit</h4>	   
<table class="table table-bordered table-condensed table-hover table-striped dataTable" id="fixed_assets_table">
  <tr>
    <th width="%" class="text-center">Description</th>
    <th width="%" class="text-center"> Purchase 
 Value</th>
     <th width="%" class="text-center">Sale Value</th>
      </tr>
    
     <tr>
<td width="" class="">Previous Day Cash Balance</td>
<td align="right"><?php //echo  sprintf("%04d", $atl->acctrnss_id);?></td>
<td width="" class="text-right"><div id="pre_day_cash_balance">0</div></td>
</tr>
<!-- 
  <tr>
<td></td>
<td width="" class="">Cash Sales</td>
<td align="right"><?php //echo  sprintf("%04d", $atl->acctrnss_id);?></td>
<td width="" class="text-right"><div id="cash_sales_payment">0</div></td>
</tr>
-->
  <?php
	  // print_r($main_category_list);
	    foreach ($main_category_list as $row){
			if($row->cat_name){
	    ?>
     <tr>
       <td><?php echo $row->cat_name;?></td>
       <td></td>
       <td class="text-right"><div id="cat_amount_<?php echo $row->cat_id;?>">0</div></td>
      
       </tr>
       <?php  } } ?>

       <tr>
         <td class=""><strong>Total</strong></td>
         <td align="right">&nbsp;</td>
         <td class="text-right"><strong><div id="tot_cat_amount_wap">0</div></strong></td>
       </tr>
       <tr>
         <td class=""></td>
         <td align="right">&nbsp;</td>
         <td class="text-right"></td>
       </tr>
       <tr style="display:none">
<td width="" class="">Advance</td>
<td align="right"><?php //echo  sprintf("%04d", $atl->acctrnss_id);?></td>
<td width="" class="text-right"><div id="advance_payment">0</div></td>
</tr>

<tr style="display:none">
<td width="" class="">Downpayments</td>
<td align="right"><?php //echo  sprintf("%04d", $atl->acctrnss_id);?></td>
<td width="" class="text-right"><div id="downpayments_payment">0</div></td>
</tr>

<tr style="display:none">
<td width="" class="">Installments</td>
<td align="right"><?php //echo  sprintf("%04d", $atl->acctrnss_id);?></td>
<td width="" class="text-right"><div id="installments_payment">0</div></td>
</tr>

<tr style="display:none">
<td width="" class="">Visiting Charges</td>
<td align="right"><?php //echo  sprintf("%04d", $atl->acctrnss_id);?></td>
<td width="" class="text-right"><div id="visiting_charges_payment">0</div></td>
</tr>

<tr style="display:none">
<td width="" class="">Wholesale</td>
<td align="right"><?php //echo  sprintf("%04d", $atl->acctrnss_id);?></td>
<td width="" class="text-right"><div id="wholesale_payment">0</div></td>
</tr>

<tr style="display:none">
<td width="" class="">Other Income</td>
<td align="right"><?php //echo  sprintf("%04d", $atl->acctrnss_id);?></td>
<td width="" class="text-right"><div id="other_income_payment">0</div></td>
</tr>

 



  <?php 
  $tot_cash_debit=0;
  $tot_cheque_debit=0;
  foreach ($fixed_assets_master_list as $faml)
  {	  
  $fam_id=$faml->fam_id;
	?>
   <!-- <tr>
    <td width="" class=""><?php echo $faml->fam_name;?></td>
   <td width=""></td>
    <td width=""></td>
     <td></td>
      <td></td>
    </tr>-->
		<?php 
        $fixed_assets_type_list=$mod_rransactions->get_fixed_assets_type_list($fam_id);
		//echo $this->db->last_query();
      foreach ($fixed_assets_type_list as $fatl)

      {	  
	   $fa_type_id=$fatl->fa_type_id;
        ?>
        <!-- <tr>
        <td width="" class=""><div class="padding_1">&nbsp;</div><?php echo $fatl->fa_type_name;?></td>
       <td width=""></td>
        <td width=""></td>
         <td></td>
          <td></td>
         </tr>-->
                  <?php 
				  //echo "fa_type_id:".$fa_type_id;
				  $acc_transactions_list=array();
				 if($srh_from_date){
                  $acc_transactions_list=$mod_rransactions->get_acc_transactions_list($fa_type_id,$srh_from_date,$srh_to_date,$srh_warehouse_id);
				 }
                  foreach ($acc_transactions_list as $atl)
                  {	 
				 
				  if($atl->debit_credit=='Debit')
				  {
					  $tot_cash_debit+=$atl->acctrnss_amount;
                    ?>
                  <?php 
				  }
				  }//fixed_assets_list?>
      <?php } //fixed_assets_type_list?>
  <?php } //fixed_assets_master_list end?>
  
  <?php 
  //Start cash sale 
  $cash_sale_list=array();
  $cash_sale_list=$mod_sales->get_cash_sale_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id,'Cash','Cash');
  //print_r($cash_sale_list);
    foreach ($cash_sale_list as $csi){
		 $tot_cash_debit+=$csi->sale_pymnt_amount;
	?>
    <?php 
	} 
	 //End cash sale 
	 ?>
     
     <?php 
  //Start Cheque sale 
  $cash_sale_list=array();
  $cash_sale_list=$mod_sales->get_cash_sale_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id,'Cash','Cheque');
  //print_r($cash_sale_list);
    foreach ($cash_sale_list as $csi){
		$tot_cheque_debit+=$csi->sale_pymnt_amount;
	?>
    <?php 
	} 
	 //End Cheque sale 
	 ?>
     
     
     <?php 
  //Start Hire Sale 
  $hire_sale_list=array();
  $hire_sale_list=$mod_sales->get_cash_sale_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id,'Hire','Cash');
  //print_r($cash_sale_list);
    foreach ($hire_sale_list as $csi){
		 $tot_cash_debit+=$csi->hire_sale_tot_amount;
	?>
    <?php 
	} 
	 //End Hire Sale 
	 ?>

     
     
    <tr>
      <td>Addition</td>
      <td></td>
      <td class="text-right"><div id="addition_payments">0</div></td>
      </tr>
      
      <tr style="display:none">
       <td>Cash Collector Excess</td>
       <td></td>
       <td class="text-right"><div id="cash_collector_excess">0</div></td>
      
       </tr>
      
       <?php
	  // print_r($mstr_expences_type_list);
	    for($k=0; $k<10; $k++){
	    ?>
     <tr>
       <td></td>
       <td></td>
       <td class="text-right">&nbsp;</td>
       </tr>
       <?php } ?>
       
      
    <tr>
      <td>&nbsp;</td>
      <td></td>
      <td class="text-right">&nbsp;</td>
      </tr>
       <tr>
      <td>&nbsp;</td>
      <td></td>
      <td class="text-right">&nbsp;</td>
      </tr>
       <tr>
      <td>&nbsp;</td>
      <td></td>
      <td class="text-right">&nbsp;</td>
      </tr>
    <tr>
                    <td><strong>Total Balance</strong></td>
                        <td></td>
                    
                    <td width="" class="text-right"><strong><div id="debit_total"></div></strong></td>
           
                  </tr>
  <tr>
    <td>Balance C/F to New Day</td>
    <td></td>
    <td class="text-right"><div id="balance_cf_to_new_day_total"></div></td>
    </tr>
</table>
</div>

<!-- End Debit -->

 
    
</div>
</div>

							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					</div>

                    <!-- end grid -->
                    
                    
                    
                    <!-- day end start -->
                      <!--start search box-->  
    <div class="panel panel-default" style="display:none">
								<div class="panel-heading">
									 <i class="fa fa-external-link-square"></i>
									Day End
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
<div class="col-sm-3" style="display:none">
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
<label>Warehouse *</label>

<select id="warehouse_id" class="form-control" name="warehouse_id" onClick="">
<!--<option value="">-- Select Warehouse --</option>-->
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
<option value="<?php echo $row->id; ?>">
<?php echo $row->name; ?>
</option>
<?php }?>
</select>                                        
</div>
</div>

<div class="col-sm-3">
<div class="form-group">
<?php
$mod_warehouse=new Warehouse_Model();
$ware_des=$mod_warehouse->get_warehouse_info($this->session->userdata('ss_warehouse_id'));
//print_r($ware_des);
//echo $ware_des['status'];
?>
<label>Status *</label>
<select id="status" class="form-control" name="status">

<?php 

$sel_e='';

$sel_d='';

?>

<option value="1" <?php if($ware_des['status']==1) echo 'selected'; //echo $sel_e; ?>>Enable</option>

<option value="0" <?php if($ware_des['status']==0) echo 'selected'; //echo $sel_d; ?> style="color:red">Disable</option>

</select>
</div>
</div>

 

<div class="col-sm-3">

                                                      	<div class="form-group">

															<label for="s2id_autogen1"> Date </label>
<br>

                                                <div> <?php echo date("Y-m-d H:i:s");?></div>          
                                                            
                  <!-- <input id="srh_from_date" readonly name="srh_from_date" type='text' class="form-control date" value="" data-bv-field="date"/>   -->                                      
                                                            

                                                            

														</div>

													</div>
                                                        <div class="col-sm-3" style="display:none">

                                                      	<div class="form-group">

															<label for="s2id_autogen1">To Date </label>

                                                             <input readonly id="srh_to_date" name="srh_to_date" type='text' class="form-control date" value="" data-bv-field="date"/>                                         
                   

                                                            

														</div>

													</div>
                                                    
                                                    <div class="col-md-3" style="margin-top:21px;">
                  <input class="btn btn-warning" value="Submit" name="search" id="day_end_btn" type="submit"> 
                  
 <input name="tot_exp" type="hidden" id="tot_exp" value="0">   
  <input name="tot_sup_grn" type="hidden" id="tot_sup_grn" value="0">               
                  
                <!--  <input name="add_category" value="Reset" class="btn btn-danger" onClick="location.reload()" type="submit">-->
                  </div> 
                  
                 
</div> 
<!--end search-->           
                                    
								</div>
							</div>
    
    <!--end search box-->  
    
                    <!-- end day end -->
                    
					
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

		<!-- start ajax model -->
		<div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
		<!-- end ajax model -->

		<!-- start: MAIN JAVASCRIPTS -->
		<?php $this->load->view("common/footer"); ?>
		<!-- end: MAIN JAVASCRIPTS -->
       
        <script src="<?php echo asset_url(); ?>js/jquery-ui.js" ></script>		

		<script src="<?php echo asset_url(); ?>js/moment-with-locales.js"></script>

		<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.js"></script>

         <script type="text/javascript" src="<?php echo asset_url(); ?>js/bootstrap-datepicker.js"></script>

		

		<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>

        

         <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.js"></script>

          <script type="text/javascript" src="<?php echo asset_url(); ?>js/accounting.min.js"></script>

		<!-- end: MAIN JAVASCRIPTS -->



        

      <script src="<?php echo asset_url(); ?>/plugins/jquery-inputlimiter/jquery.inputlimiter.1.3.1.min.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/autosize/jquery.autosize.min.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/select2/select2.min.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/jquery.maskedinput/src/jquery.maskedinput.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/jquery-maskmoney/jquery.maskMoney.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-daterangepicker/moment.min.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-colorpicker/js/commits.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/jQuery-Tags-Input/jquery.tagsinput.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/summernote/build/summernote.min.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/ckeditor/ckeditor.js"></script>

		<script src="<?php echo asset_url(); ?>/plugins/ckeditor/adapters/jquery.js"></script>

		<script src="<?php echo asset_url(); ?>/js/form-elements.js"></script>  
		
        

        

        

        <script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>

          <script type="text/javascript" src="<?php echo asset_url(); ?>js/dataTables.bootstrap.min.js"></script>
<!--<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/dataTables.buttons.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/buttons.print.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/buttons.flash.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/jszip.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/pdfmake.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/vfs_fonts.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/buttons.html5.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo asset_url(); ?>/js/buttons.print.min.js"></script>-->
    
        <script>

   jQuery(document).ready(function () {
            //conirm
            $("#day_end_btn").click(function () {
                var warehouse_id = $('#warehouse_id').val();
				var status = $('#status').val();
                //var popup_type = $('#popup_type').val();
                //var page = $('#page').val();
                //var id = sel_id;

                if (warehouse_id) {
                  
                        $.post("<?php echo base_url('finance/day_end_submit') ?>", {warehouse_id: warehouse_id,status:status})
                                .done(function (data) {
                                    var obj = jQuery.parseJSON(data);
                                   
                                    displayNotice('page', 'Day end successfully!');
                                   // location.reload(true);
                                });
                    
                } //end page check
			
            });


        });
			
		
	function search_cash_book(){
	 //$("#update_req_status_btn").prop("disabled", true);
	 var fields = '';//$("#update_req_status_form").serialize();
	 var srh_from_date=$('#srh_from_date').val();
	 var srh_to_date=$('#srh_to_date').val();
	 var srh_warehouse_id=$('#srh_warehouse_id').val();
	 
	 /* GRN Payment Start */
	 $.post( "<?php echo base_url();?>finance/cash_book_get_grn_payments?srh_from_date="+srh_from_date+"&srh_to_date="+srh_to_date, fields)
	.done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
			}
			if(obj.error==0){
			//	displayNotice('page','successfully');
				$("#grn_payments").html(obj.grn_payment_val);
			}
	  });
	  /* GRN Payment End */
	  
	/* Salary Advance Start */
	 $.post( "<?php echo base_url();?>finance/cash_book_get_salary_advance_payments?srh_from_date="+srh_from_date+"&srh_to_date="+srh_to_date, fields)
	.done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
			}
			if(obj.error==0){
				//displayNotice('page','successfully');
				$("#salary_advance_payments").html(obj.salary_advance_payments);
			}
	  });
	  /* Salary Advance End */
	  
	  
	  /* Salary Start */
	 $.post( "<?php echo base_url();?>finance/cash_book_get_salary_payments?srh_from_date="+srh_from_date+"&srh_to_date="+srh_to_date, fields)
	.done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
			}
			if(obj.error==0){
				//displayNotice('page','successfully');
				$("#salary_payments").html(obj.salary_payments);
			}
	  });
	  /* Salary End */
	  
	  

	  
	  
	  
	  /* Cash Sales Payment Start */
	  /*
	 $.post( "<?php echo base_url();?>finance/cash_book_get_cash_sale_payments?srh_from_date="+srh_from_date+"&srh_to_date="+srh_to_date, fields)
	.done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
			}
			if(obj.error==0){
				
				$("#cash_sales_payment").html(obj.cash_sales_payment);
			}
	  });
	  */
	  /* Cash Sales Payment End */
	  
	  /* advance_payment Payment Start */
	 $.post( "<?php echo base_url();?>finance/cash_book_get_cash_advance_payment?srh_from_date="+srh_from_date+"&srh_to_date="+srh_to_date, fields)
	.done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
			}
			if(obj.error==0){
				//displayNotice('page','successfully');
				$("#advance_payment").html(obj.advance_payment);
			}
	  });
	  /* advance_payment Payment End */
	  
	  /* downpayments_payment Payment Start */
	 $.post( "<?php echo base_url();?>finance/cash_book_get_downpayments_payment?srh_from_date="+srh_from_date+"&srh_to_date="+srh_to_date, fields)
	.done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
			}
			if(obj.error==0){
				//displayNotice('page','successfully');
				$("#downpayments_payment").html(obj.downpayments_payment);
			}
	  });
	  /* downpayments_payment Payment End */
	  
	  
	    /* installments_payment Payment Start */
	 $.post( "<?php echo base_url();?>finance/cash_book_get_installments_payment?srh_from_date="+srh_from_date+"&srh_to_date="+srh_to_date, fields)
	.done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
			}
			if(obj.error==0){
				//displayNotice('page','successfully');
				$("#installments_payment").html(obj.installments_payment);
			}
	  });
	  /* installments_payment Payment End */
	  

	  

	   /* rep_expences_payments Payment Start */
	 $.post( "<?php echo base_url();?>finance/cash_book_get_rep_expences_payments?srh_from_date="+srh_from_date+"&srh_to_date="+srh_to_date, fields)
	.done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
			}
			if(obj.error==0){
				//displayNotice('page','successfully');
				$("#rep_expences_payments").html(obj.rep_expences_payments);
				//$("#sales_related_expences_payments").html(obj.sales_related_expences_payments);
				
			}
	  });
	  /* rep_expences_payments Payment End */	
	  
	  /* cash_expences_payments Payment Start */
	 $.post( "<?php echo base_url();?>finance/cash_book_get_cash_expences_payments?srh_from_date="+srh_from_date+"&srh_to_date="+srh_to_date, fields)
	.done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
			}
			if(obj.error==0){
				//displayNotice('page','successfully');
				$("#cash_expences_payments").html(obj.cash_expences_payments);
				//$("#sales_related_expences_payments").html(obj.sales_related_expences_payments);
				
			}
	  });
	  /* cash_expences_payments Payment End */
	  
	   /* owner_withdrawls_payments Payment Start */
	 $.post( "<?php echo base_url();?>finance/cash_book_get_owner_withdrawls_payments?srh_from_date="+srh_from_date+"&srh_to_date="+srh_to_date+'&fxd_ass_id=6', fields)
	.done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
			}
			if(obj.error==0){
				//displayNotice('page','successfully');
				$("#owner_withdrawls_payments").html(obj.owner_withdrawls_payments);
				//$("#sales_related_expences_payments").html(obj.sales_related_expences_payments);
				
			}
	  });
	  /* owner_withdrawls_payments Payment End */
	  
	  
	   /* pre_day_cash_balance Payment Start */
	 $.post( "<?php echo base_url();?>finance/cash_book_get_owner_withdrawls_payments?srh_from_date="+srh_from_date+"&srh_to_date="+srh_to_date+'&fxd_ass_id=1', fields)
	.done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
			}
			if(obj.error==0){
				//displayNotice('page','successfully');
				$("#pre_day_cash_balance").html(obj.owner_withdrawls_payments);
				//$("#sales_related_expences_payments").html(obj.sales_related_expences_payments);
				
			}
	  });
	  /* pre_day_cash_balance Payment End */
	  
	  
	   /* bank_diposit_payments Payment Start */
	 $.post( "<?php echo base_url();?>finance/cash_book_get_owner_withdrawls_payments?srh_from_date="+srh_from_date+"&srh_to_date="+srh_to_date+'&fxd_ass_id=2', fields)
	.done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
			}
			if(obj.error==0){
				//displayNotice('page','successfully');
				$("#bank_diposit_payments").html(obj.owner_withdrawls_payments);
				
				//alert(obj.owner_withdrawls_payments);
				//$("#sales_related_expences_payments").html(obj.sales_related_expences_payments);
				
			}
	  });
	  /* bank_diposit_payments Payment End */	
	  
	   /* addition_payments Payment Start */
	 $.post( "<?php echo base_url();?>finance/cash_book_get_owner_withdrawls_payments?srh_from_date="+srh_from_date+"&srh_to_date="+srh_to_date+'&fxd_ass_id=8', fields)
	.done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
			}
			if(obj.error==0){
				//displayNotice('page','successfully');
				$("#addition_payments").html(obj.owner_withdrawls_payments);
				//$("#sales_related_expences_payments").html(obj.sales_related_expences_payments);
				
			}
	  });
	  /* addition_payments Payment End */	
	  
	  /* other_income_payment Payment Start */
	 $.post( "<?php echo base_url();?>finance/cash_book_get_owner_withdrawls_payments?srh_from_date="+srh_from_date+"&srh_to_date="+srh_to_date+'&fxd_ass_id=7', fields)
	.done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
			}
			if(obj.error==0){
				//displayNotice('page','successfully');
				$("#other_income_payment").html(obj.owner_withdrawls_payments);
				//$("#sales_related_expences_payments").html(obj.sales_related_expences_payments);
				
			}
	  });
	  /* other_income_payment Payment End */
	  
	
	
	 /* expencess Payment Start */
	  <?php
	  // print_r($mstr_expences_type_list);
	    foreach ($main_category_list as $row){
			//$etp_id=$row->cat_id;
	    ?>
	 $.post( "<?php echo base_url();?>finance/cash_book_get_cash_sale_payments?srh_from_date="+srh_from_date+"&srh_to_date="+srh_to_date+'&cat_id=<?php echo $row->cat_id;?>', fields)
	.done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
			}
			if(obj.error==0){
				
				//var tot_exp=$("#tot_exp").val();
				//alert(tot_exp);
				//displayNotice('page','successfully');
				$("#cat_amount_<?php echo $row->cat_id;?>").html(obj.cash_sales_payment);
				//$("#tot_exp").val(parseFloat(tot_exp)+parseFloat(obj.cash_sales_payment))
				//$("#sales_related_expences_payments").html(obj.sales_related_expences_payments);
				
			}
	  });
	  <?php } ?>
	  /* expencess Payment End */	
	  
	  
	  /* Sales Start */
	 // $("#tot_exp").val(0);
	  <?php
	  // print_r($mstr_expences_type_list);
	    foreach ($mstr_expences_type_list as $row){
			$etp_id=$row['etp_id'];
	    ?>
		
		
	 $.post( "<?php echo base_url();?>finance/cash_book_get_owner_withdrawls_payments?srh_from_date="+srh_from_date+"&srh_to_date="+srh_to_date+'&fxd_ass_id=5'+'&etp_id=<?php echo $etp_id;?>', fields)
	.done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
			}
			if(obj.error==0){
				//displayNotice('page','successfully');
				var tot_exp=$("#tot_exp").val();
				
				
				
				
				$("#exp_amount_<?php echo $etp_id;?>").html(obj.owner_withdrawls_payments);
				
				if(parseFloat(obj.owner_withdrawls_payments)){
					
				//	alert(tot_exp);
					
					var tot=parseFloat(tot_exp)+parseFloat(obj.owner_withdrawls_payments);
					//alert(tot+ " tot : "+tot_exp+" tot exp:"+obj.owner_withdrawls_payments+': <?php echo $etp_id;?>');
				//$("#tot_exp").val(500);
				}
				//$("#sales_related_expences_payments").html(obj.sales_related_expences_payments);
				
				//alert();
				
			}
	  });
	  <?php } ?>
	  /* Sales End */	
	  
	  
	  
	 /* GRn Start */
	 // $("#tot_exp").val(0);
	  <?php
	  // print_r($mstr_expences_type_list);
	    foreach ($supplier_list as $row){
			$supp_id=$row->supp_id;
			//http://localhost/buddhima/finance/cash_book_get_grn_payments?srh_from_date=2019/09/05&srh_to_date=2019/09/05
	    ?>
		
		
	 $.post( "<?php echo base_url();?>finance/cash_book_get_grn_payments?srh_from_date="+srh_from_date+"&srh_to_date="+srh_to_date+'&supp_id=<?php echo $supp_id;?>', fields)
	.done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
			}
			if(obj.error==0){
				//displayNotice('page','successfully');
				if(obj.grn_payment_val){
				//alert(obj.grn_payment_val);
				}
				
				$("#sup_grn_amount_<?php echo $supp_id;?>").html(obj.grn_payment_val);
				//sup_grn_amount_3
				
				//$("#sales_related_expences_payments").html(obj.sales_related_expences_payments);
				
				//alert();
				
			}
	  });
	  <?php } ?>
	  /* GRN End */	  
	  
	  
	    
	   /* sales_related_expences_payments Payment Start */
	 $.post( "<?php echo base_url();?>finance/cash_book_get_sales_related_expences_payments?srh_from_date="+srh_from_date+"&srh_to_date="+srh_to_date, fields)
	.done(function( data ) {
		  var obj = jQuery.parseJSON(data);
			if(obj.error==1){
			}
			if(obj.error==0){
				//displayNotice('page','successfully');
				
				$("#sales_related_expences_payments").html(obj.sales_related_expences_payments);
				
				// alert('Done');
				
			}
	  });
	  /* sales_related_expences_payments Payment End */  
	  	  
	  
	 
	return false;
	}
function getNum(val) {
   if (isNaN(val)) {
     return 0;
   }
   return val;
}	

function convertToAmount(val)



{



	var disval=val; //+'.00'; //.toFixed(val);



	return accounting.formatMoney(disval, "", 2, "", "."); 



}
	
	
	
	
	
/*	window.setInterval(function(){

  get_total();
}, 3000);*/


/*$(document).ajaxStart(function(e) {
   console.log('start'+e); 
   alert('start');
});*/
$(document).ajaxStop(function(e) {
  // console.log(e);
   //alert('end'); 
   get_total();
});


function get_total() {
      // 0 === $.active
	  
	  //alert('get_total'); 
	//console.log('test');
	  //calculate total
	  var credit_total=0;
	  var grn_payments=getNum(parseFloat($( "#grn_payments" ).text()));
	   var salary_advance_payments=getNum(parseFloat($( "#salary_advance_payments" ).text()));
	    var salary_payments=getNum(parseFloat($( "#salary_payments" ).text()));
		 var rep_expences_payments=getNum(parseFloat($( "#rep_expences_payments" ).text()));
		  var cash_expences_payments=getNum(parseFloat($( "#cash_expences_payments" ).text()));
		   var sales_related_expences_payments=getNum(parseFloat($( "#sales_related_expences_payments" ).text()));
		    var bank_diposit_payments=getNum(parseFloat($( "#bank_diposit_payments" ).text()));
			 var owner_withdrawls_payments=getNum(parseFloat($( "#owner_withdrawls_payments" ).text()));
			 var cash_collector_short=getNum(parseFloat($( "#cash_collector_short" ).text()));
			
			var tot_expences=0;
			<?php
	  // print_r($mstr_expences_type_list);
	    foreach ($mstr_expences_type_list as $row){
			$etp_id=$row['etp_id'];
	    ?>
		var tmp_amount=getNum(parseFloat($( "#exp_amount_"+<?php echo $etp_id;?>).text()));
		if(tmp_amount){
		var tot_expences=tot_expences+tmp_amount;
		}
		<?php } ?>
		
		var tot_sup_grn=0;
			<?php
	  // print_r($mstr_expences_type_list);
	    foreach ($supplier_list as $row){
			$supp_id=$row->supp_id;
	    ?>
		var tmp_amount=getNum(parseFloat($( "#sup_grn_amount_"+<?php echo $supp_id;?>).text()));
		if(tmp_amount){
		var tot_sup_grn=tot_sup_grn+tmp_amount;
		}
		<?php } ?>
		
			/*
			var exp_amount_1=getNum(parseFloat($( "#exp_amount_1" ).text()));
			var exp_amount_2=getNum(parseFloat($( "#exp_amount_2" ).text()));
			var exp_amount_3=getNum(parseFloat($( "#exp_amount_3" ).text()));
			var exp_amount_4=getNum(parseFloat($( "#exp_amount_4" ).text()));
			var exp_amount_5=getNum(parseFloat($( "#exp_amount_5" ).text()));
			var exp_amount_6=getNum(parseFloat($( "#exp_amount_6" ).text()));
			*/
			var tot_cat_amount=0;
			var cat_amount_1=getNum(parseFloat($( "#cat_amount_1" ).text()));
			var cat_amount_2=getNum(parseFloat($( "#cat_amount_2" ).text()));
			var cat_amount_3=getNum(parseFloat($( "#cat_amount_3" ).text()));
			var cat_amount_4=getNum(parseFloat($( "#cat_amount_4" ).text()));
			var cat_amount_5=getNum(parseFloat($( "#cat_amount_5" ).text()));
			var cat_amount_6=getNum(parseFloat($( "#cat_amount_6" ).text()));
			var cat_amount_7=getNum(parseFloat($( "#cat_amount_7" ).text()));
			var cat_amount_8=getNum(parseFloat($( "#cat_amount_8" ).text()));
			var cat_amount_9=getNum(parseFloat($( "#cat_amount_9" ).text()));
			var cat_amount_10=getNum(parseFloat($( "#cat_amount_10" ).text()));
			var cat_amount_11=getNum(parseFloat($( "#cat_amount_11" ).text()));
			
			//tot_expences=parseFloat($( "#tot_exp" ).val());
			
			
			
			tot_cat_amount=parseFloat(cat_amount_1+cat_amount_2+cat_amount_3+cat_amount_4+cat_amount_5+cat_amount_6+cat_amount_7+cat_amount_8+cat_amount_9+cat_amount_10+cat_amount_11);
			
			$("#tot_cat_amount_wap").html(convertToAmount(tot_cat_amount));
			
			//accounting.formatMoney(disval, "", 2, "", ".")
		   // var =parseFloat($( "#" ).text());
	  
	  credit_total=convertToAmount(grn_payments+salary_advance_payments+rep_expences_payments+cash_expences_payments+bank_diposit_payments+tot_expences+owner_withdrawls_payments+sales_related_expences_payments+cash_collector_short+tot_cat_amount);
	 // alert(bank_diposit_payments);
	
	  //alert(credit_total);
	  $("#credit_total").html(credit_total);
	  $("#tot_expences").html(convertToAmount(tot_expences));
	  
	  
	  
	  var debit_total=0;
	   var pre_day_cash_balance=getNum(parseFloat($( "#pre_day_cash_balance" ).text()));
	   var cash_sales_payment=getNum(parseFloat($( "#cash_sales_payment" ).text()));
	   var advance_payment=getNum(parseFloat($( "#advance_payment" ).text()));
	   var downpayments_payment=getNum(parseFloat($( "#downpayments_payment" ).text()));
	   var installments_payment=getNum(parseFloat($( "#installments_payment" ).text()));
	   var visiting_charges_payment=getNum(parseFloat($( "#visiting_charges_payment" ).text()));
	    var addition_payments=getNum(parseFloat($( "#addition_payments" ).text()));
		var cash_collector_ex=getNum(parseFloat($( "#cash_collector_excess" ).text()));
		//alert(cash_collector_ex);
	   debit_total=convertToAmount(cash_sales_payment+advance_payment+downpayments_payment+installments_payment+visiting_charges_payment+addition_payments+pre_day_cash_balance+cash_collector_ex);
	  $("#debit_total").html(debit_total);
	  
	  
	  $("#left_total_balance").html(debit_total);
	   $("#cash_b_b_f").html(convertToAmount(debit_total-credit_total));
	   $("#balance_cf_to_new_day_total").html(convertToAmount(debit_total-credit_total));
	  
	  
	  	displayNotice('page','successfully');
	  
  }
  
  
function printdiv(printpage)
{
	var warehouse_name=$( "#srh_warehouse_id option:selected" ).text();
	var srh_from_date=$('#srh_from_date').val();
	var srh_to_date=$('#srh_to_date').val();
	
	$("#warehouse_name").html(warehouse_name+'<br/>'+'Cash Book');
	$("#date_wap").html("From Date: "+srh_from_date+" , To Date: "+srh_to_date);
	$("#created_date_wap").html("Created Date: <?php echo date("d/m/Y H:i:s");?>");
			
var headstr = "<html><head><title></title></head><body>";
var footstr = "</body>";
var newstr = document.all.item(printpage).innerHTML;
var oldstr = document.body.innerHTML;
document.body.innerHTML = headstr+newstr+footstr;
window.print();
document.body.innerHTML = oldstr;
return false;
}


jQuery(document).ready(function() {
				//var currentDate = new Date();
				/*
				var tomorrow = new Date();
				currentDate=tomorrow.setDate(tomorrow.getDate() + 1);
				$('#srh_to_date').datetimepicker({
					defaultDate: currentDate,
					format:"YYYY/MM/DD"
				});
				*/
				$('#srh_to_date').datetimepicker({
					defaultDate: new Date(),
					format:"YYYY/MM/DD"
				});
				$('#srh_from_date').datetimepicker({
					defaultDate: new Date(),
					format:"YYYY/MM/DD"
				});
				//TableData.init();
				//loadGrid();
				//loadGridSalesReturn();
				//loadsummary();
			});
			
			jQuery(document).ready(function() {
				FormElements.init();
				//loadGrid();
			});


			function loadGrid() {
				           $('#transactions_table').DataTable({
					        "ajax": "<?php echo base_url('transactions/transactions_load') ?>",
					        "bDestroy": true,
					        "iDisplayLength": 10,
							 "order": [[ 0, "desc" ]]
					    });

					}
					
/*jQuery(document).ready(function() {
$( "#conirm" ).click(function() {
		var sel_id=$('#sel_id').val(); 
		var popup_type=$('#popup_type').val();
		var page=$('#page').val();
		var cus_id=sel_id;
		
if(page=='supp'){
	if(popup_type=='delete'){
			$.post( "customers/delete_customer", {cus_id:cus_id})
		  .done(function( data ) {
		  var obj = jQuery.parseJSON(data);
				loadGrid();// load customer data
				displayNotice('page','Customer has been deleted successfully!')
		  });
	}else if(popup_type=='disable') {
		$.post( "customers/disable_customer", {cus_id:cus_id})
		     .done(function( data ) {
		     var obj = jQuery.parseJSON(data);
			 loadGrid();// load customer data
			 displayNotice('page','Customer has been disabled successfully!')
	   });
	}
	else if(popup_type=='enable') {
		$.post( "customers/enable_customer", {cus_id:cus_id})
		     .done(function( data ) {
		     var obj = jQuery.parseJSON(data);
			 loadGrid();// load customer data
			 displayNotice('page','Customer has been enabled successfully!')
	   });
	}
} //end page check
	
	});

});			

function deleteCustomerData(cus_id){
	$("#myModal4").modal();
	$('#sel_id').val(cus_id); 
	$('#popup_type').val('delete');
	$('#page').val('supp');
	$("#label").text("Are you sure you want to delete this customer?");
}

function disableCustomerData(cus_id){
	$("#myModal4").modal();
	$('#sel_id').val(cus_id); 
	$('#popup_type').val('disable');
	$('#page').val('supp');
	$("#label").text("Are you sure you want to disable this customer?");
}

function enableCustomerData(cus_id){
	$("#myModal4").modal();
	$('#sel_id').val(cus_id); 
	$('#page').val('supp');
	$('#popup_type').val('enable');
	$("#label").text("Are you sure you want to enable this customer?");
}*/

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


		</script>
	</body>
	<!-- end: BODY -->
</html>