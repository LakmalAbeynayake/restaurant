<header style="min-height:100px; background-color:#1F1F21" id="header" class="navbar">
            <div class="container">
          
              <!-- <span class="pos-logo-lg">Baker's Choice</span>
               <span class="pos-logo-sm">Baker's Choice</span>--></span></a>
               <div class="header-nav">
               
                 <div class="row col-xs-12">
                     <div class="col-xs-4">&nbsp;</div>
                     <div class="col-xs-4"><?php $this->load->view('common/logo_pos'); ?></div>
                     <div class="col-xs-4">&nbsp;</div>
                 </div>
               </div>
            </div><div class="snow"></div><?php if(is_logged_in()){
			
		}else {
			redirect(base_url(),'refresh');
			exit();
		} ?>
         </header>