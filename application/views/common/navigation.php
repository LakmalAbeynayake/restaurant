<?php 
if (is_logged_in()) {

} else {
    redirect(base_url(), 'refresh');
    exit();
}
/*
$nav_items = get_all_navs();
//print_r($nav_items);
?>

<div class="main-navigation navbar-collapse collapse  hidden-on-print">

	<!-- start: MAIN MENU TOGGLER BUTTON -->
	<div class="navigation-toggler"> <i class="clip-chevron-left"></i> <i class="clip-chevron-right"></i> </div>
	<!-- end: MAIN MENU TOGGLER BUTTON -->
	<!-- start: MAIN NAVIGATION MENU -->
	<ul class="main-navigation-menu">
	    <!--NAV DYNAMIC START-->
	    <?php
	    foreach($nav_items as $nav){//start foreach nav
    	    if($nav["url"]){
    	    ?>
    	    <li <?php if($main_menu_name==$nav["main_menu_name"] ) {echo 'class="active open"';} ?>> <a href="<?php echo base_url($nav["url"]); ?>"><?php echo $nav["display_name"]; ?><span class="selected"></span></a> </li>
    	    <?php
    	    }else{
    	    ?>
    	    
    	    <li <?php if($main_menu_name==$nav["main_menu_name"] ) {echo 'class="active open"';} ?>><a href="javascript:void(0)"><?php echo $nav["display_name"]; ?><i class="icon-arrow"></i><span class="selected"></span></a>
    			<ul class="sub-menu">
    			    <?php
    			    foreach($nav["subs"] as $key=>$sub){
    			        if(($sub["url"]) == "#"){
    			        ?>
    			        <li><?php echo $sub["display_name"]; ?></li>
    			        <?php    
    			        }
    			        else{
    			            
    			        ?>
    				    <li <?php if($sub_menu_name== $sub["sub_menu_name"] ) {echo 'class="active open"';} ?>> <a href="<?php echo base_url($sub["url"]) ?>"><?php echo $sub["display_name"]; ?></a></li>
    			        
    			        <?php
    			   
    			        }
    			        
    			    }
    			    ?>
    			</ul>
    		</li>
    	    
    	    <?php
    	    }
	        
	    }//end foreach nav
	    ?>
        <!--NAV DYNAMIC END-->
	</ul>
	
	<!-- end: MAIN NAVIGATION MENU -->
</div>
<?php

*/
?>
<!--END-->
<?php
//print_r($this->session->all_userdata()); 
//$this->load->view("common/random");
$Common_Model = new Common_Model();
$usr_permtn_pubvr = $Common_Model->is_avalable_for_use_this_link_for_user($this->session->userdata('ss_group_id'), 'users');
//echo "<pre>";
//echo print_r($usr_permtn_pubvr);	
function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $str = '';
    // $max = mb_strlen($keyspace, '8bit') - 1;
    // for ($i = 0; $i < $length; ++$i) {
    //    $str .= $keyspace[random_int(0, $max)];
    // }
    return rand(10, 100);
}
?>
<style>
    .dataTables_processing {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 40px;
        margin-left: -50%;
        margin-top: -25px;
        padding-top: 20px;
        text-align: center;
        font-size: 1.2em;
        background-color: white;
        background: -webkit-gradient(linear, left top, right top, color-stop(0%, rgba(255, 255, 255, 0)), color-stop(25%, rgba(255, 255, 255, 0.9)), color-stop(75%, rgba(255, 255, 255, 0.9)), color-stop(100%, rgba(255, 255, 255, 0)));
        background: -webkit-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
        background: -moz-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
        background: -ms-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
        background: -o-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
        background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
    }
</style>

<div class="main-navigation navbar-collapse collapse hidden-on-print">

    <!-- start: MAIN MENU TOGGLER BUTTON -->

    <div class="navigation-toggler"> <i class="clip-chevron-left"></i> <i class="clip-chevron-right"></i> </div>

    <!-- end: MAIN MENU TOGGLER BUTTON -->

    <!-- start: MAIN NAVIGATION MENU -->

    <ul class="main-navigation-menu hidden-on-print">
        <li <?php if ($main_menu_name == 'dashboard') {
                echo 'class="active open"';
            } ?>> <a href="<?php echo base_url('dashboard'); ?>"><i class="clip-home-3"></i> <span class="title"> Dashboard </span><span class="selected"></span> </a> </li>
        
        
        
        <?php 
         if($this->session->userdata('ss_group_id') != 4){
        ?>
        <li <?php if ($main_menu_name == 'products') {
                echo 'class="active open"';
            } ?>> <a href="javascript:void(0)"><i class="fa fa-barcode"></i> <span class="title"> Products </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
            <ul class="sub-menu">
                <?php
                if ($this->session->userdata('ss_group_id') == 1 || $this->session->userdata('ss_group_id') == 2) { ?>
                    <li <?php if ($sub_menu_name == 'products') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('products'); ?>"> <span class="title"> List Products</span></a></li>
                <?php } ?>
                <?php if ($this->session->userdata('ss_group_id') < 3) { ?>
                    <li <?php if ($sub_menu_name == 'add_products') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('products/add'); ?>"> <span class="title"> Add Products</span></a></li>
                <?php } ?>
            </ul>
        </li>
        <?php 
         }
        ?>
        <li <?php if ($main_menu_name == 'sales') {
                echo 'class="active open"';
            } ?>> <a href="javascript:void(0)"><i class="fa fa-heart"></i> <span class="title"> Sales </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
            <ul class="sub-menu">
                <li <?php if ($sub_menu_name == 'sales') {
                        echo 'class="active open"';
                    } ?>> <a href="<?php echo base_url('sales'); ?>"> <span class="title"> List Sales</span></a></li>
                <li <?php if ($sub_menu_name == 'credit_sales') {
                        echo 'class="active open"';
                    } ?>> <a href="<?php echo base_url('sales/credit_sales'); ?>"> <span class="title"> Credit Invoice Settlement</span></a></li>

                <?php if ($this->session->userdata('ss_group_id') == 1 || $this->session->userdata('ss_group_id') == 2 || $this->session->userdata('ss_group_id') == 4) { ?>
                    <li <?php if ($sub_menu_name == 'add_sales') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('sales/add/' . random_str(6) . (mt_rand())); ?>"> <span class="title"> Add Sales</span></a></li>
                <?php } ?>
                <?php if ($this->session->userdata('ss_group_id') < 0) { ?>
                    <li <?php if ($sub_menu_name == 'sales_return') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('sales/sales_return'); ?>"> <span class="title"> List Return Sales</span></a></li>
                <?php } ?>
            </ul>
        </li>
        <li <?php if ($main_menu_name == 'transactions') {
                echo 'class="active open"';
            } ?>> <a href="<?php echo base_url('transactions'); ?>"><i class="fa fa-money"></i> <span class="title"> Transactions </span><span class="selected"></span> </a> </li>
        
        <li <?php if ($main_menu_name == 'quotations') {
                echo 'class="active open"';
            } ?>> <a href="javascript:void(0)"><i class="fa fa-align-left"></i> <span class="title"> Quotations </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
            <ul class="sub-menu">
                <li <?php if ($sub_menu_name == 'quotations') { echo 'class="active open"';} ?>> <a href="<?php echo base_url('quotations'); ?>"> <span class="title"> List Quotation</span></a></li>
                <li <?php if ($sub_menu_name == 'quotations_add') {echo 'class="active open"';} ?>> <a href="<?php echo base_url('quotations/add'); ?>"> <span class="title"> Add Quotation</span></a></li>
            </ul>
        </li>
        <?php if ($this->session->userdata('ss_group_id') < 4) { ?>
        <?php } ?>
        <?php if ($this->session->userdata('ss_group_id') < 5) { ?>
        <?php } ?>
        
        <?php /*if ($this->session->userdata('ss_group_id') < 5) { ?>
            <li <?php if ($main_menu_name == 'stock_req') {
                    echo 'class="active open"';
                } ?>> <a href="javascript:void(0)"><i class="fa fa-align-left"></i> <span class="title"> S.R </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
                <ul class="sub-menu">
                    <li <?php if ($sub_menu_name == 'stock_req') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('stock_req'); ?>"> <span class="title"> List S.R</span></a></li>
                    <?php if ($this->session->userdata('ss_group_id') < 4) { ?>
                        <li <?php if ($sub_menu_name == 'quotations_add') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('stock_req/add'); ?>"> <span class="title"> Add S.R</span></a></li>
                    <?php } ?>
                </ul>
            </li>
        <?php } */ ?>
        
        <?php if ($this->session->userdata('ss_group_id') < 5) { ?>
            <!--<li <?php if ($main_menu_name == 'cus_orders') {
                    echo 'class="active open"';
                } ?>> <a href="javascript:void(0)"><i class="fa fa-align-left"></i> <span class="title"> Custom Orders </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
                <ul class="sub-menu">
                    <li <?php if ($sub_menu_name == 'cus_orders') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('pos/cus_orders'); ?>"> <span class="title"> List C.O</span></a></li>
                </ul>
            </li>-->
        <?php } ?>
        
        <?php if ($this->session->userdata('ss_group_id') == 1 || $this->session->userdata('ss_group_id') == 2 || $this->session->userdata('ss_group_id') == 4 || $this->session->userdata('ss_group_id') == 3) { ?>
            <li <?php if ($main_menu_name == 'purchases') {
                    echo 'class="active open"';
                } ?>> <a href="javascript:void(0)"><i class="fa fa-file-text"></i> <span class="title"> Purchases </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
                <ul class="sub-menu">
                    <?php if ($this->session->userdata('ss_group_id') == 1 || $this->session->userdata('ss_group_id') == 2 || $this->session->userdata('ss_group_id') == 4) { ?>
                        <li <?php if ($sub_menu_name == 'list_purchases') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('purchases'); ?>"> <span class="title"> List of purchases </span> </a> </li>
                        <li <?php if ($sub_menu_name == 'add_purchases') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('purchases/add/0/' . random_str(6) . mt_rand()); ?>"><?php /*?>  <a href="<?php echo base_url('menu_item/add_menu_purchases'); ?>"><?php */ ?>
                                <span class="title"> Add Purchase </span> </a> </li>
                    <?php } ?>

                    <?php if ($this->session->userdata('ss_group_id') == 1 || $this->session->userdata('ss_group_id') == 2 || $this->session->userdata('ss_group_id') == 4) { ?>
                        <li <?php if ($sub_menu_name == 'list_return_purchases') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('purchases/list_return'); ?>"> <span class="title"> List of Purchase Return </span> </a> </li>
                        <li <?php if ($sub_menu_name == 'add_purchases_return') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('purchases/add_return'); ?>"> <span class="title"> Add Purchase Return </span> </a> </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
        
        
        
        <li <?php if ($main_menu_name == 'grn') {
                echo 'class="active open"';
            } ?>> <a href="javascript:void(0)"><i class="fa fa-file-text"></i> <span class="title"> G.R.N, G.T.N </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
            <ul class="sub-menu">
                    <li <?php if ($sub_menu_name == 'list_grn') { echo 'class="active open"'; } ?>> <a href="<?php echo base_url('grn'); ?>"> <span class="title"> List of G.R.Ns </span> </a> </li>
                    <li <?php if ($sub_menu_name == 'list_gtn') {echo 'class="active open"';} ?>> <a href="<?php echo base_url('gtn/'); ?>"> <span class="title"> List of G.T.N </span> </a> </li>
                    <!--<li <?php if ($sub_menu_name == 'add_grn') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('grn/add'); ?>">
                            <span class="title"> Add G.R.N </span> </a> </li>-->
            </ul>
        </li>
        
        
        <?php if ($this->session->userdata('ss_group_id') == 1 || $this->session->userdata('ss_group_id') == 2 || $this->session->userdata('ss_group_id') == 4 || $this->session->userdata('ss_group_id') == 3) {/* ?>

            <?php ?><li <?php if ($main_menu_name == 'ingredient_grn') {
                            echo 'class="active open"';
                        } ?>> <a href="javascript:void(0)"><i class="fa fa-heart"></i> <span class="title"> Raw Materials</span><i class="icon-arrow"></i> <span class="selected"></span> </a>
                <ul class="sub-menu">
                    <?php if ($this->session->userdata('ss_group_id') == 1 || $this->session->userdata('ss_group_id') == 2 || $this->session->userdata('ss_group_id') == 4) { ?>
                        <li <?php if ($sub_menu_name == 'ingredient_grn') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('ingredient_grn'); ?>"> <span class="title"> List R.M Purchases</span></a></li>
                        <li <?php if ($sub_menu_name == 'add_ingredient_grn') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('ingredient_grn/add/' . random_str(6) . mt_rand()); ?>"> <span class="title"> Add Raw Material</span></a></li>
                    <?php } ?>
                    <li <?php if ($sub_menu_name == 'apitransfer') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('apitransfer/material'); ?>"> <span class="title"> Metarial Transfer Grn</span> </a> </li>

                    <?php if ($this->session->userdata('ss_group_id') == 1 || $this->session->userdata('ss_group_id') == 2 || $this->session->userdata('ss_group_id') == 3 || $this->session->userdata('ss_group_id') == 4) { ?>
                        <li <?php if ($sub_menu_name == 'apitrns') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('apitrns/material'); ?>"> <span class="title"> Metarial Transfer Grn(Testing Purposes)</span> </a> </li>
                    <?php } ?>
                    <?php if ($this->session->userdata('ss_group_id') == 1 || $this->session->userdata('ss_group_id') == 2 || $this->session->userdata('ss_group_id') == 4) { ?>
                        <li <?php if ($sub_menu_name == 'ingredient_grn') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('stock_adjesment'); ?>"> <span class="title"> List R.M Adjesment</span></a></li>
                        <li <?php if ($sub_menu_name == 'stock_adjesment') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('stock_adjesment/add/' . random_str(6) . mt_rand()); ?>"> <span class="title"> Add Stock Adjesment</span></a></li>
                    <?php } ?>

                </ul>
            </li><?php  ?>
        <?php */} ?>
            <li <?php if ($main_menu_name == 'transfer') {
                    echo 'class="active open"';
                } ?>> <a href="javascript:void(0)"><i class="fa fa-exchange"></i> <span class="title"> Transfers </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
                <ul class="sub-menu">
                    <li <?php if ($sub_menu_name == 'list_transfer') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('transfer'); ?>"> <span class="title"> List Transfers </span> </a> </li>
                    <li <?php if ($sub_menu_name == 'transfer_add') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('transfer/add'); ?>"> <span class="title"> New Transfer </span> </a> </li>
                </ul>
            </li>

        <?php if ($this->session->userdata('ss_group_id') < 3) { ?>
        <?php } ?>

        <?php if ($this->session->userdata('ss_group_id') < 3 || $this->session->userdata('ss_group_id') == 4) { ?>
            <li <?php if ($main_menu_name == 'adjustments') {
                    echo 'class="active open"';
                } ?>> <a href="javascript:void(0)"><i class="fa fa-cubes"></i> <span class="title"> Adjustments </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
                <ul class="sub-menu">
                    <?php if ($this->session->userdata('ss_group_id') == 1 || $this->session->userdata('ss_group_id') == 2 || $this->session->userdata('ss_group_id') == 4) { ?>
                        <li <?php if ($sub_menu_name == 'list') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('adjustments'); ?>"> <span class="title"> List of Adjustments</span></a></li>
                        <li <?php if ($sub_menu_name == 'add') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('adjustments/add/'); ?>"> <span class="title"> New Adjustment</span></a></li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
        
        <?php if ($this->session->userdata('ss_group_id') < 3) {/* ?>
            <li <?php if ($main_menu_name == 'transfer_m') {
                    echo 'class="active open"';
                } ?>> <a href="javascript:void(0)"><i class="fa fa-exchange"></i> <span class="title"> Transfers (R.M) </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
                <ul class="sub-menu">
                    <li <?php if ($sub_menu_name == 'list_transfer_m') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('stock_m_transfer/list_transfers'); ?>"> <span class="title"> List Transfers </span> </a> </li>
                    <li <?php if ($sub_menu_name == 'transfer_add') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('stock_m_transfer/new_transfer'); ?>"> <span class="title"> New Transfer </span> </a> </li>
                </ul>
            </li>
        <?php */} ?>
        <?php if ($this->session->userdata('ss_group_id') == 1 || $this->session->userdata('ss_group_id') == 2 || $this->session->userdata('ss_group_id') == 4) { ?>
            <li <?php if ($main_menu_name == 'product_damage') {
                    echo 'class="active open"';
                } ?>> <a href="javascript:void(0)"><i class="fa fa-chain-broken"></i> <span class="title"> Damage Products </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
                <ul class="sub-menu">
                    <li <?php if ($sub_menu_name == 'list_product_damage') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('product_damage'); ?>"> <span class="title"> List Damage Product </span> </a> </li>
                    <li <?php if ($sub_menu_name == 'product_damage_add') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('product_damage/add'); ?>"> <span class="title"> Add Damage Product</span> </a> </li>
                </ul>
            </li>
        <?php } ?>
        <?php /*?><li <?php if($main_menu_name=='vehicles') {echo 'class="active open"';} ?>> <a href="javascript:void(0)"><i class="fa fa-chain-broken"></i> <span class="title"> Vehicles </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
      <ul class="sub-menu">
        <li <?php if($sub_menu_name=='vehicles') {echo 'class="active open"';} ?>> <a href="<?php echo base_url('vehicles'); ?>"> <span class="title"> List vehicles </span> </a> </li>
        <li> <a href="#" data-toggle="modal" id="modal_ajax_create_vehicle_btn"> <span class="title">Add Vehicle</span> </a> </li>
      </ul>
    </li><?php */ ?>
        <?php if ($this->session->userdata('ss_group_id') < 5) { ?>
            <li <?php if ($main_menu_name == 'people') {
                    echo 'class="active open"';
                } ?>> <a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> People </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
                <ul class="sub-menu">
                    <?php

                    //if(in_multiarray("usrgp_permission_page","users", $usr_permtn_pubvr,"usrgp_permission_view",1))
                    if ($this->session->userdata('ss_group_id') < 3) {

                    ?>
                        <li <?php if ($sub_menu_name == 'users') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('users'); ?>"> <span class="title">List Users</span> </a> </li>
                    <?php } ?>
                    <?php

                    //if(in_multiarray("usrgp_permission_page","users", $usr_permtn_pubvr,"usrgp_permission_add",1))
                    if ($this->session->userdata('ss_group_id') < 3) { ?>
                        <li <?php if ($sub_menu_name == 'create_user') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('users/create_user'); ?>"> <span class="title">Add Users</span> </a> </li>
                    <?php } ?>
                    <?php

                    if (in_multiarray("usrgp_permission_page", "customer", $usr_permtn_pubvr, "usrgp_permission_view", 1) || $this->session->userdata('ss_group_id') == 4) { ?>
                        <li <?php if ($sub_menu_name == 'customers') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('customers'); ?>"> <span class="title"> List Customer</span> </a> </li>
                    <?php } ?>
                    <?php

                    if (in_multiarray("usrgp_permission_page", "customer", $usr_permtn_pubvr, "usrgp_permission_add", 1) || $this->session->userdata('ss_group_id') == 4) { ?>
                        <li> <a href="#" data-toggle="modal" id="modal_ajax_customers_btn"> <span class="title">Add Customer</span> </a> </li>
                    <?php } ?>
                    <?php if ($this->session->userdata('ss_group_id') < 3 || $this->session->userdata('ss_group_id') == 4) { ?> <li <?php if ($sub_menu_name == 'suppliers') { echo 'class="active open"'; } ?>> <a href="<?php echo base_url('suppliers'); ?>"> <span class="title"> List Suppliers</span> </a> </li>
                    <li><a id="modal_ajax_suppliers_btn" data-toggle="modal" href="#"> <span class="title"> Add Suppliers</span> </a> </li>
                    <?php } ?>
                    <?php if ($this->session->userdata('ss_group_id') < 3) { ?>

                        <li <?php if ($sub_menu_name == 'chef') {
                                echo 'class="active open"';
                            } ?>>

                            <a href="javascript:void(0)"><i class="fa fa-user"></i>

                                <span class="title"> chef </span><i class="icon-arrow"></i>

                                <span class="selected"></span>

                            </a>
                            <ul class="sub-menu">

                                <?php {

                                ?>

                                    <li <?php if (isset($sub_sub_menu_name)) {
                                            if ($sub_sub_menu_name == 'list_chef') {
                                                echo 'class="active open"';
                                            }
                                        } ?>>

                                        <a href="<?php echo base_url('chef/chef_name'); ?>">

                                            <span class="title"> List Chef</span></a>
                                    </li>


                                    <li <?php if (isset($sub_sub_menu_name)) {
                                            if ($sub_sub_menu_name == 'create_chef') {
                                                echo 'class="active open"';
                                            }
                                        } ?>>

                                        <a href="<?php echo base_url('chef/create_chef'); ?>">

                                            <span class="title"> Add chef</span></a>
                                    </li>



                                    <li <?php if (isset($sub_sub_menu_name)) {
                                            if ($sub_sub_menu_name == 'chef_schdule') {
                                                echo 'class="active open"';
                                            }
                                        } ?>>

                                        <a href="<?php echo base_url('chef/chef_schdule_view'); ?>">

                                            <span class="title">Add Schedule</span></a>
                                    </li>



                                    <li <?php if (isset($sub_sub_menu_name)) {
                                            if ($sub_sub_menu_name == 'schdule_list') {
                                                echo 'class="active open"';
                                            }
                                        } ?>>

                                        <a href="<?php echo base_url('chef/schdule_list'); ?>">

                                            <span class="title"> Schdule List</span></a>
                                    </li>



                                    <li <?php if (isset($sub_sub_menu_name)) {
                                            if ($sub_sub_menu_name == 'chef_add_item') {
                                                echo 'class="active open"';
                                            }
                                        } ?>>

                                        <a href="<?php echo base_url('chef/chef_add_item_view'); ?>">

                                            <span class="title"> Chef add items</span></a>
                                    </li>




                            </ul>
                        </li>
                <?php }
                            } ?>

                </ul>
            </li>
        <?php } ?>
        <?php if ($this->session->userdata('ss_group_id') < 3) { ?>
            <li <?php if ($main_menu_name == 'notifications') {
                    echo 'class="active open"';
                } ?>> <a href="<?php echo base_url('notifications'); ?>"><i class="fa fa-info-circle"></i> <span class="title">Notifications</span> <span class="selected"></span> </a> </li>
        <?php } ?>
        <?php if ($this->session->userdata('ss_group_id') < 3) { ?>
            <li <?php if ($main_menu_name == 'settings') {
                    echo 'class="active open"';
                } ?>> <a href="javascript:void(0)"><i class="fa fa-cog"></i> <span class="title"> Settings </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
                <ul class="sub-menu">

                    <!--<li <?php if ($sub_menu_name == 'system_settings') {
                                echo 'class="active open"';
                            } ?>>

									<a href="<?php echo base_url('system_settings'); ?>">

										<span class="title">  System Settings </span>

									</a>

								</li>-->

                    <li <?php if ($sub_menu_name == 'categories') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('system_settings/categories'); ?>"> <span class="title"> Categories </span> </a> </li>

                    <!-- <li <?php if ($sub_menu_name == 'locations') {
                                    echo 'class="active open"';
                                } ?>>

									<a href="<?php echo base_url('locations'); ?>">

										<span class="title">Locations</span>

									</a>

								</li>-->

                    <li <?php if ($sub_menu_name == 'warehouse') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('warehouse'); ?>"> <span class="title">Locations</span> </a> </li>

                    <!-- <li <?php if ($sub_menu_name == 'tax_rates') {
                                    echo 'class="active open"';
                                } ?>>

									<a href="<?php echo base_url('tax_rates'); ?>">

										<span class="title"> Tax Rates </span>

									</a>

								</li>-->

                    <li <?php if ($sub_menu_name == 'unit') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('unit'); ?>"> <span class="title"> Unit </span> </a> </li>
                    <li <?php if ($sub_menu_name == 'user_groups') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('user_groups'); ?>"> <span class="title"> Group Permissions </span> </a> </li>

                    <!--  <li <?php if ($sub_menu_name == 'backups') {
                                    echo 'class="active open"';
                                } ?>>

									<a href="<?php echo base_url('backups'); ?>">

										<span class="title">  Backups </span>

									</a>

								</li>	-->

                </ul>
            </li>
        <?php } ?>




        <!--Finance-->
        <?php /*   
 $rand_txt=234;                
{?>
 <li <?php if($main_menu_name=='finance') {echo 'class="active open"';} ?>>
	<a href="javascript:void(0)"><i class="clip-banknote"></i>
		<span class="title">Finance</span><i class="icon-arrow"></i>
		<span class="selected"></span>
	</a>
	<ul class="sub-menu">
    <?php 
        //if(in_multiarray("usrgp_permission_page","pr", $usr_permtn_pubvr,"usrgp_permission_view",1))
        {?>
        <li <?php if($sub_menu_name=='cash_book_02') {echo 'class="active open"';} ?>>
         <a href="<?php echo base_url("finance/cash_book_02/$rand_txt"); ?>">
        <span class="title">Account Summary And Petty Cash Details</span></a></li>
        
         <li <?php if($sub_menu_name=='cashier_summary') {echo 'class="active open"';} ?>>
         <a href="<?php echo base_url("finance/cashier_summary/$rand_txt"); ?>">
        <span class="title">Cashier Summary</span></a></li>
        
        <li <?php if($sub_menu_name=='products') {echo 'class="active open"';} ?>> <a href="<?php echo base_url('reports/products'); ?>"> <span class="title"> Products Report</span> </a> </li>
        
        <li <?php if($sub_menu_name=='products_v2') {echo 'class="active open"';} ?>> <a href="<?php echo base_url('reports/products_v2'); ?>"> <span class="title"> Products Report V2</span> </a> </li>
        
        <li <?php if($sub_menu_name=='stock_movement') {echo 'class="active open"';} ?>>
         <a href="<?php echo base_url("reports/stock_movement"); ?>">
        <span class="title">Sales Statement</span></a></li>
        
        <li <?php if($sub_menu_name=='stock_movement_empty') {echo 'class="active open"';} ?>>
         <a href="<?php echo base_url("reports/stock_movement_empty"); ?>">
        <span class="title">Empty Sales Statement</span></a></li>
        
        
                <?php }?>
        <?php 
        //if(in_multiarray("usrgp_permission_page","pr", $usr_permtn_pubvr,"usrgp_permission_add",1))
        ?>
		
        <?php 
        //if(in_multiarray("usrgp_permission_page","pr", $usr_permtn_pubvr,"usrgp_permission_add",1))
        ?>
        <!-- 
        <li <?php if($sub_menu_name=='petty_cash') {echo 'class="active open"';} ?>>
        <a href="<?php echo base_url("finance/petty_cash/$rand_txt"); ?>">
        <span class="title">Petty Cash</span></a></li>	 -->
        
        <!-- 
        <li <?php if($sub_menu_name=='day_end') {echo 'class="active open"';} ?>>
        <a href="<?php echo base_url("finance/day_end/$rand_txt"); ?>">
        <span class="title">Day End</span></a></li>	 -->
        <?php ?>
        
        <li <?php if($sub_menu_name=='transactions_list') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('transactions'); ?>">
										<span class="title">  Transactions</span>
									</a>
								</li>
	</ul>
</li>
<?php }*/ ?>
        <!--Finance-->

        <?php if ($this->session->userdata('ss_group_id') < 3 || $this->session->userdata('ss_group_id') == 4) { ?>
            <li <?php if ($main_menu_name == 'reports') {
                    echo 'class="active open"';
                } ?>> <a href="javascript:void(0)"><i class="fa fa-bar-chart"></i> <span class="title">Reports</span><i class="icon-arrow"></i> <span class="selected"></span> </a>
                <ul class="sub-menu">
                    <!--<li><a href="<?php echo base_url('reports/stock_movement'); ?>"><span class="title">Stock Movement</span> </a></li>-->
                    <li <?php if ($sub_menu_name == 'cashier_summary_list') {
                            echo 'class="active open"';
                        } ?>>
                        <a href="<?php echo base_url("reports/cashier_summary_list/"); ?>">
                            <span class="title">Cashier Summary Reports</span></a>
                    </li>
                    <li <?php if ($sub_menu_name == 'rep_daily_summary') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('summary/daily_summary'); ?>"> <span class="title"> Daily Summary Report</span> </a> </li>
                    <li <?php if ($sub_menu_name == 'rep_daily_sales') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('reports/daily_sales'); ?>"> <span class="title"> Daily Sales Report</span> </a> </li>
                    
                    <li <?php if ($sub_menu_name == 'daily_item_sale') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('summary/daily_item_sale'); ?>"> <span class="title"> Daily Item Sale Report</span> </a> </li>
                        
                        
                    <li <?php if ($sub_menu_name == 'rep_daily_stock') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('summary/daily_stock'); ?>"> <span class="title"> Daily Stock Report</span> </a> </li>
                    
                    <li <?php if ($sub_menu_name == 'invoices') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('reports/invoices'); ?>"> <span class="title"> Customer Invoice Report</span> </a> </li>

                    <li <?php if ($sub_menu_name == 'ts_report_daily') { 
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('transfer/report'); ?>"> <span class="title"> Transfer Report</span> </a> </li>
                        
                    <li <?php if ($sub_menu_name == 'rep_grn') { 
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('grn/report'); ?>"> <span class="title"> G.R.N Report</span> </a> </li>

                    <!--<li <?php if ($sub_menu_name == 'sales') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('reports/sales'); ?>"> <span class="title"> Sales Report</span> </a> </li>
        -->


                    <!--
        <li <?php if ($sub_menu_name == 'rep_customer') {
                echo 'class="active open"';
            } ?>> <a href="<?php echo base_url('reports/customer'); ?>"> <span class="title"> Customer Report</span> </a> </li>
        <!--<li <?php if ($sub_menu_name == 'suppliers') {
                    echo 'class="active open"';
                } ?>> <a href="<?php echo base_url('reports/suppliers'); ?>"> <span class="title"> Suppliers Report</span> </a> </li>-->
                    <!--<li <?php if ($sub_menu_name == 'grn') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('reports/grn'); ?>"> <span class="title"> GRN Report</span> </a> </li>-->
                    <!--
                    <li <?php if ($sub_menu_name == 'products') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('reports/products'); ?>"> <span class="title"> Products Report</span> </a> </li>
                    
                    
                    <li <?php if ($sub_menu_name == 'row_material') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('reports/row_material'); ?>"> <span class="title"> RM Report</span> </a> </li>
                    -->
                    
                    
                    <li <?php if ($sub_menu_name == 'reports/payments') {
                            echo 'class="active open"';
                        } ?>> <a href="<?php echo base_url('reports/payments'); ?>"> <span class="title"> Cash Report</span> </a> </li>
                    <!-- <li <?php if ($sub_menu_name == 'service_charges') {
                                    echo 'class="active open"';
                                } ?>> <a href="<?php echo base_url('reports/service_charge'); ?>"> <span class="title"> Service Charge Report</span> </a> </li>
        <!--<li <?php if ($sub_menu_name == 'products_quantity') {
                    echo 'class="active open"';
                } ?>> <a href="<?php echo base_url('reports/products_quantity'); ?>"> <span class="title"> Products Quantity Report</span> </a> </li>-->
                    <!--<li <?php if ($sub_menu_name == 'menuitems') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('reports/menuitem'); ?>"> <span class="title"> Menu Items Report</span> </a> </li>-->
                    <!--<li <?php if ($sub_menu_name == 'menuavailable') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('reports/menu_available_item'); ?>"> <span class="title">Available menu Item Report</span> </a> </li>-->
                    <!--<li <?php if ($sub_menu_name == 'supplier_products') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('reports/supplier_products'); ?>"> <span class="title"> Supplier Products Report</span> </a> </li>-->
                    <!--<li <?php if ($sub_menu_name == 'print_product_code') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('reports/print_product_code'); ?>"> <span class="title"> Products Code Print</span> </a> </li>-->
                    <!---->
                    <!--<li <?php if ($sub_menu_name == 'user_activitie') {
                                echo 'class="active open"';
                            } ?>> <a href="<?php echo base_url('reports/alert_quantity'); ?>"> <span class="title"> Alert Quantity</span> </a> </li>-->
                    <?php if($this->session->userdata('ss_group_id') < 3){ ?>
                    
                        <li <?php if ($sub_menu_name == 'user_activitie') { echo 'class="active open"';} ?>> <a href="<?php echo base_url('reports/user_activitie'); ?>"> <span class="title"> User Activitie</span> </a> </li>
                    
                    <?php } ?>
                    
                    
                </ul>
            </li>
        <?php } ?>
    </ul>

    <!-- end: MAIN NAVIGATION MENU -->

</div>