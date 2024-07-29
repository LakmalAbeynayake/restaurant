<header id="header" <?php /*?>class="navbar"<?php */?>>
  <div class="container" style="background-color:#000;max-height: 42px;">
    <?php /*?><a class="navbar-brand" href="#"><span class="logo">
               <span class="pos-logo-lg">Baker's Choice</span>
               <span class="pos-logo-md">Baker's Choice</span></span></a><?php */?>
    <div class="header-nav" style="width: 100%;">
      <ul class="nav nav-tabs navbar-nav tab-green no-print" id="myTab3">
        <li class="active"> <a data-toggle="tab" href="#Sales" style="padding:10px"> ADD SALES</a> </li>
        
        <?php if($ftr['ism']['din']['on']){ ?>
            <li> <a onClick="loadDineIn()" data-toggle="tab" href="#dine_in" style="padding:10px"><i class="fa fa-spoon"></i><i class="fa fa-circle-o"></i> Dine In </a> </li>
        <?php } ?>
        <?php if($ftr['ism']['tkw']['on']){ ?>
            <li> <a onClick="loadTakeaway()" data-toggle="tab" href="#take_away" style="padding:10px"><i class="fa fa-money"></i> Take Away </a> </li>
        <?php } ?>
        <?php if($ftr['ism']['dlv']['on']){ ?>
            <li> <a onClick="loadDelivery()" data-toggle="tab" href="#delivery" style="padding:10px"><i class="fa fa-truck"></i> Delivery </a> </li>
        <?php } ?>
        <?php if($ftr['add_prd']){ ?>
            <li> <a data-toggle="tab" href="#add_product" style="padding:10px"><i class="fa fa-plus-square"></i> Add Product </a> </li>
        <?php } ?>
        
        <li> <a href="<?php echo base_url("sales");?>" target="_blank" style="padding:10px"><i class="fa fa-plus-square"></i> List Sale </a> </li>
      </ul>
      <ul class="nav navbar-nav" style="float:right">
        <li class="dropdown hidden-xs"> <a class="btn bred pos-tip" title="" data-placement="bottom" id="clearLS" href="#" data-original-title="Clear all locally saved data" tabindex="-1"> <i class="fa fa-eraser"></i> </a> </li>
        <li class="dropdown"> <a class="btn account dropdown-toggle" data-toggle="dropdown" href="#">
          <div class="user"> <img alt="" src="<?php echo image_url(); ?>/male.png" class="mini_avatar img-rounded"> <span>Welcome! <?php echo $this->session->userdata['ss_user_first_name'] ?></span> </div>
          </a>
          <ul class="dropdown-menu" style="float:right">
            <li style="display:none"> <a href="#"> <i class="fa fa-user"></i> Profile </a> </li>
            <li style="display:none"> <a href="#"> <i class="fa fa-key"></i> Change Password </a> </li>
            <li class="divider" style="display:none"></li>
            <li> <a href="<?php echo base_url('logout'); ?>"> <i class="fa fa-sign-out"></i> Logout </a> </li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav" style="float:right">
        <li> <a class="btn bblack"> <i class="fa fa-list"></i> <span id="order_count" class="badge"></span></a></li>
        <li class="dropdown"> <a class="btn bblack" style="cursor: default;"><span id="display_time"></span></a> </li>
        <li class="dropdown"> <a class="btn btn-default" title="" id="btn-fs" onClick="toggleFullScreen()" title="Full screen toggle" tabindex="-1"> <i class="fa fa-expand"></i> </a> </li>
        <li class="dropdown hidden-sm"> <a class="btn pos-tip" title="" data-placement="bottom" href="#" data-toggle="modal" data-target="#sckModal" data-original-title="Shortcuts" tabindex="-1"> <i class="fa fa-key"></i> </a> </li>
        <li class="dropdown" style="display:none"> <a class="btn pos-tip" title="" data-placement="bottom" href="<?php echo base_url('pos/view_bill'); ?>" target="_blank" data-original-title="View Bill Screen" tabindex="-1"> <i class="fa fa-laptop"></i> </a> </li>
        <li class="dropdown"> <a class="btn byellow pos-tip" data-placement="bottom" href="<?php echo base_url('sales_return/custom'); ?>" target="new" data-original-title="Return" tabindex="-1"> <i class="fa fa-file"></i> </a></li>
        <li class="dropdown"> <a class="btn bblue pos-tip" title="" data-placement="bottom" href="<?php echo base_url('dashboard'); ?>" target="new" data-original-title="Dashboard" tabindex="-1"> <i class="fa fa-dashboard"></i> </a> </li>
      </ul>
    </div>
  </div>
</header>
  <?php 
  if(is_logged_in()){
		}else {
			redirect(base_url(),'refresh');
			exit();
		} 
		
		?>

