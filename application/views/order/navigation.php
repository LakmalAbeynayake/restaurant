<header id="header" <?php /*?>class="navbar"<?php */?>>

  <div class="container" style="background-color:#000">

    <?php /*?><a class="navbar-brand" href="#"><span class="logo">

               <span class="pos-logo-lg">Baker's Choice</span>

               <span class="pos-logo-md">Baker's Choice</span></span></a><?php */?>

    <div class="header-nav" style="float:left">

      <ul class="nav navbar-nav<?php /*?> pull-right<?php */?>">

        
        <li class="dropdown"> <a class="btn account dropdown-toggle" data-toggle="dropdown" href="#">

          <div class="user"> <img alt="" src="<?php echo image_url(); ?>/male.png" class="mini_avatar img-rounded"> <span>Welcome! <?php echo $this->session->userdata['ss_user_first_name'] ?></span> </div>

          </a>

          <ul class="dropdown-menu<?php /*?> pull-right<?php */?>">

            <li style="display:none"> <a href="#"> <i class="fa fa-user"></i> Profile </a> </li>

            <li style="display:none"> <a href="#"> <i class="fa fa-key"></i> Change Password </a> </li>

            <li class="divider" style="display:none"></li>

            <li> <a href="<?php echo base_url('logout'); ?>"> <i class="fa fa-sign-out"></i> Logout </a> </li>

          </ul>

        </li>

      </ul>

      <ul class="nav navbar-nav<?php /*?> pull-right<?php */?>">

        <li class="dropdown"> <a class="btn bblack" style="cursor: default;"><span id="display_time"></span></a> </li>

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