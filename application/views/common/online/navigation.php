<?php  

		if(is_logged_in()){
			
		}else {
			redirect(base_url(),'refresh');
			exit();
		}
//print_r($this->session->all_userdata()); 
?>
				<div class="main-navigation navbar-collapse collapse">
              
					<!-- start: MAIN MENU TOGGLER BUTTON -->
  <div class="navigation-toggler">
						<i class="clip-chevron-left"></i>
						<i class="clip-chevron-right"></i>
					</div>
					<!-- end: MAIN MENU TOGGLER BUTTON -->
					<!-- start: MAIN NAVIGATION MENU -->
					<ul class="main-navigation-menu">
						<li <?php if($main_menu_name=='dashboard') {echo 'class="active open"';} ?>>
							<a href="<?php echo base_url('dashboard'); ?>"><i class="clip-home-3"></i>
								<span class="title"> Dashboard </span><span class="selected"></span>
							</a>
						</li>
						
                        <li <?php if($main_menu_name=='products') {echo 'class="active open"';} ?>>
							<a href="javascript:void(0)"><i class="fa fa-barcode"></i>
								<span class="title"> Products </span><i class="icon-arrow"></i>
								<span class="selected"></span>
							</a>
							<ul class="sub-menu">
								<li <?php if($sub_menu_name=='products') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('products'); ?>">
										<span class="title"> List Products</span></a></li>
								<li <?php if($sub_menu_name=='add_products') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('products/add'); ?>">
										<span class="title"> Add Products</span></a></li>
								
								
							</ul>
						</li>
                        <li <?php if($main_menu_name=='sales') {echo 'class="active open"';} ?>>
							<a href="javascript:void(0)"><i class="fa fa-heart"></i>
								<span class="title"> Sales </span><i class="icon-arrow"></i>
								<span class="selected"></span>
							</a>
							<ul class="sub-menu">
								<li <?php if($sub_menu_name=='sales') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('sales'); ?>">
										<span class="title"> List Sales</span></a></li>
								<li <?php if($sub_menu_name=='add_sales') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('sales/add'); ?>">
										<span class="title"> Add Sales</span></a></li>
                                        <li <?php if($sub_menu_name=='sales_return') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('sales/sales_return'); ?>">
                                    <span class="title"> List Return Sales</span></a></li>
							</ul>
						</li>
                        <li <?php if($main_menu_name=='quotations') {echo 'class="active open"';} ?>>
							<a href="javascript:void(0)"><i class="clip-heart"></i>
								<span class="title"> Quotations </span><i class="icon-arrow"></i>
								<span class="selected"></span>
							</a>
							<ul class="sub-menu">
								<li <?php if($sub_menu_name=='quotations') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('quotations'); ?>">
										<span class="title"> List Quotation</span></a></li>
								<li <?php if($sub_menu_name=='quotations_add') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('quotations/add'); ?>">
										<span class="title"> Add Quotation</span></a></li>	
							</ul>
						</li>
						<li <?php if($main_menu_name=='purchases') {echo 'class="active open"';} ?>>
							<a href="javascript:void(0)"><i class="fa fa-star"></i>
								<span class="title">  GRN  </span><i class="icon-arrow"></i>
								<span class="selected"></span>
							</a>
							<ul class="sub-menu">
								<li <?php if($sub_menu_name=='list_purchases') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('purchases'); ?>">
										<span class="title"> List GRN </span>
									</a>
								</li>

								<li <?php if($sub_menu_name=='add_purchases') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('purchases/add'); ?>">
										<span class="title"> Add GRN </span>
									</a>
								</li>							
							</ul>
						</li>
                        <li <?php if($main_menu_name=='transfer') {echo 'class="active open"';} ?>>
							<a href="javascript:void(0)"><i class="fa fa-star-o"></i>
								<span class="title"> Transfers  </span><i class="icon-arrow"></i>
								<span class="selected"></span>
							</a>
							<ul class="sub-menu">
								<li <?php if($sub_menu_name=='list_transfer') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('transfer'); ?>">
										<span class="title"> List Transfers </span>
									</a>
								</li>

								<li <?php if($sub_menu_name=='transfer_add') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('transfer/add'); ?>">
										<span class="title"> Add Transfer </span>
									</a>
								</li>							
							</ul>
						</li>
                         <li <?php if($main_menu_name=='product_damage') {echo 'class="active open"';} ?>>
							<a href="javascript:void(0)"><i class="fa clip-puzzle-3"></i>
								<span class="title"> Damage Products  </span><i class="icon-arrow"></i>
								<span class="selected"></span>
							</a>
							<ul class="sub-menu">
								<li <?php if($sub_menu_name=='list_product_damage') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('product_damage'); ?>">
										<span class="title"> List Damage Product </span>
									</a>
								</li>

								<li <?php if($sub_menu_name=='product_damage_add') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('product_damage/add'); ?>">
										<span class="title"> Add Damage Product</span>
									</a>
								</li>							
							</ul>
						</li>
						
						<li <?php if($main_menu_name=='people') {echo 'class="active open"';} ?>>
							<a href="javascript:void(0)"><i class="clip-user-3"></i>
								<span class="title"> People </span><i class="icon-arrow"></i>
								<span class="selected"></span>
							</a>
							<ul class="sub-menu">
                            
                            
								<li <?php if($sub_menu_name=='users') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('users'); ?>">
										<span class="title">List Users</span>
									</a>
								</li>
                                
                                <?php 
								//if(premition())
								{?>
                                
								<li <?php if($sub_menu_name=='create_user') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('users/create_user'); ?>">
										<span class="title">Add Users</span>
									</a>
								</li>
                                <?php } ?>
								
								<li <?php if($sub_menu_name=='customers') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('customers'); ?>">
										<span class="title"> List Customer</span>
									</a>
								</li>
								<li>
									<a href="#" data-toggle="modal" id="modal_ajax_customers_btn">
										<span class="title">Add Customer</span>
									</a>
								</li>
								<li <?php if($sub_menu_name=='suppliers') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('suppliers'); ?>">
										<span class="title"> List Suppliers</span>
									</a>
								</li>
								<li><a id="modal_ajax_suppliers_btn" data-toggle="modal" href="#">
										<span class="title"> Add Suppliers</span>
									</a>
								</li>
							</ul>
						</li>
						<li <?php if($main_menu_name=='notifications') {echo 'class="active open"';} ?>>
							<a href="<?php echo base_url('notifications'); ?>"><i class="clip-notification"></i>
								<span class="title">Notifications</span>
								<span class="selected"></span>
							</a>
						</li>
                        <li <?php if($main_menu_name=='settings') {echo 'class="active open"';} ?>>
							<a href="javascript:void(0)"><i class="clip-cog-2"></i>
								<span class="title"> Settings </span><i class="icon-arrow"></i>
								<span class="selected"></span>
							</a>
							<ul class="sub-menu">
								
								<!--<li <?php if($sub_menu_name=='system_settings') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('system_settings'); ?>">
										<span class="title">  System Settings </span>
									</a>
								</li>-->
                                <li <?php if($sub_menu_name=='categories') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('system_settings/categories'); ?>">
										<span class="title"> Categories </span>
									</a>
								</li>
                               <!-- <li <?php if($sub_menu_name=='locations') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('locations'); ?>">
										<span class="title">Locations</span>
									</a>
								</li>-->
                                <li <?php if($sub_menu_name=='warehouse') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('warehouse'); ?>">
										<span class="title">Warehouse</span>
									</a>
								</li>
                               <!-- <li <?php if($sub_menu_name=='tax_rates') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('tax_rates'); ?>">
										<span class="title"> Tax Rates </span>
									</a>
								</li>-->
                                <li <?php if($sub_menu_name=='unit') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('unit'); ?>">
										<span class="title"> Unit </span>
									</a>
								</li>
                                 <li <?php if($sub_menu_name=='user_groups') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('system_settings/user_groups'); ?>">
										<span class="title">   Group Permissions </span>
									</a>
								</li>	
                              <!--  <li <?php if($sub_menu_name=='backups') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('backups'); ?>">
										<span class="title">  Backups </span>
									</a>
								</li>	-->				
							</ul>
						</li>
						<li <?php if($main_menu_name=='reports') {echo 'class="active open"';} ?>>
							<a href="javascript:void(0)"><i class="clip-bars"></i>
								<span class="title">Reports</span><i class="icon-arrow"></i>
								<span class="selected"></span>
							</a>
							<ul class="sub-menu">
                            	<li <?php if($sub_menu_name=='sales') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('reports/sales'); ?>">
										<span class="title"> Sales Report</span>
									</a>
								</li>
								<li <?php if($sub_menu_name=='suppliers') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('reports/suppliers'); ?>">
										<span class="title"> Suppliers Report</span>
									</a>
								</li>
								 <li <?php if($sub_menu_name=='grn') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('reports/grn'); ?>">
										<span class="title"> GRN Report</span>
									</a>
								</li>
                                <li <?php if($sub_menu_name=='products') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('reports/products'); ?>">
										<span class="title"> Products Report</span>
									</a>
								
								</li>
								 <li <?php if($sub_menu_name=='user_activitie') {echo 'class="active open"';} ?>>
									<a href="<?php echo base_url('reports/user_activitie'); ?>">
										<span class="title"> User Activitie</span>
									</a>
								</li>
							</ul>
						</li>
  </ul>
					<!-- end: MAIN NAVIGATION MENU -->
				</div>
