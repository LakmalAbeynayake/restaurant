
<ul class="nav navbar-right">
  
  <!-- start: NOTIFICATION DROPDOWN -->
  
  <li style="display:none" class="dropdown hidden-xs"> <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#"> <i class="clip-notification-2"></i> <span class="badge"> 0</span> </a>
    <ul class="dropdown-menu notifications">
      <li> <span class="dropdown-menu-title"> You have 0 notifications</span> </li>
      <li>
        <div class="drop-down-wrapper">
          <ul>
            
            <!--<li>

												<a href="javascript:void(0)">

													<span class="label label-primary"><i class="fa fa-user"></i></span>

													<span class="message"> New user registration</span>

													<span class="time"> 1 min</span>

												</a>

											</li>

											<li>

												<a href="javascript:void(0)">

													<span class="label label-success"><i class="fa fa-comment"></i></span>

													<span class="message"> New comment</span>

													<span class="time"> 7 min</span>

											</a></li>-->
            
          </ul>
        </div>
      </li>
      <li class="view-all"> <a href="javascript:void(0)"> See all notifications <i class="fa fa-arrow-circle-o-right"></i> </a> </li>
    </ul>
  </li>
  
  <!-- end: NOTIFICATION DROPDOWN --> 
  
  <!-- start: USER DROPDOWN -->
  
  <li class="dropdown hidden-xs"> <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#"> <img src="assets/images/avatar-1-small.jpg" class="circle-img" alt=""> <span class="username">Welcome <?php echo $this->session->userdata('ss_user_first_name'); ?> (<?php echo $this->session->userdata('ss_user_group_name'); ?>) </span> <i class="clip-chevron-down"></i> </a>
    <ul class="dropdown-menu">
      <li> <a href="<?php echo base_url('users/create_user'); ?>"> <i class="clip-user-2"></i> &nbsp;My Profile </a> </li>
      <li> <a href="<?php echo base_url('logout'); ?>"> <i class="clip-exit"></i> &nbsp;Log Out </a> </li>
    </ul>
  </li>
  
  <!-- end: USER DROPDOWN -->
  
</ul>
