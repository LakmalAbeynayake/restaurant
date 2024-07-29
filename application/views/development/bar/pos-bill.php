<!DOCTYPE html>
<html><head>
      <meta charset="utf-8">
      <title>POS Module | Stock Manager Advance</title>
      <meta http-equiv="cache-control" content="max-age=0"/>
      <meta http-equiv="cache-control" content="no-cache"/>
      <meta http-equiv="expires" content="0"/>
      <meta http-equiv="pragma" content="no-cache"/>
     
      <link rel="stylesheet" href="<?php echo asset_url(); ?>css/perfect-scrollbar.min.css" />

       <script src="<?php echo asset_url(); ?>js/moment.min.js"></script>
       
      <?php /*?><link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap/css/bootstrap.min.css"><?php */?>

      <link rel="stylesheet" href="<?php echo asset_url(); ?>css/bootstrap.min.css">
      <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/font-awesome/css/font-awesome.min.css">
      <link rel="stylesheet" href="<?php echo asset_url(); ?>fonts/style.css">
      <link rel="stylesheet" href="<?php echo asset_url(); ?>css/main.css">
      <link rel="stylesheet" href="<?php echo asset_url(); ?>css/main-responsive.css">
      <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/iCheck/skins/all.css">
            <link rel="stylesheet" href="<?php echo asset_url(); ?>css/theme.css" type="text/css">
      <?php /*?><link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css"><?php */?>
      <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/perfect-scrollbar/src/perfect-scrollbar.css">
      <?php /*?><link rel="stylesheet" href="<?php echo asset_url(); ?>css/theme_light.css" type="text/css" id="skin_color"><?php */?>
      <?php /*?><link rel="stylesheet" href="<?php echo asset_url(); ?>css/print.css" type="text/css" media="print"/><?php */?>
      <link rel="stylesheet" href="<?php echo asset_url(); ?>css/style.css" type="text/css"/>
      <link rel="stylesheet" href="<?php echo asset_url(); ?>css/posajax.css" type="text/css"/>
      <?php /*?><link rel="stylesheet" href="<?php echo asset_url(); ?>css/jquery-ui.css" type="text/css"/><?php */?>
<!--<link rel="stylesheet" href="https://sma.tecdiary.com/themes/default/admin/assets/styles/theme.css" type="text/css" />-->

      <!-- <link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/> -->
      <link href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
      <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">

      <!--[if gte IE 9]><!-->
      <!--<![endif]-->
      <script src="<?php echo asset_url(); ?>plugins/jQuery-lib/2.0.3/jquery.min.js"></script>
      <script src="<?php echo asset_url(); ?>plugins/select2/select2.min.js"></script>


      <style type="text/css">
	  
         .modal.fade.in {
             top: 10%;
         }
		 .btn-round-xs{
border-radius: 11px;
padding-left: 10px;
padding-right: 10px;
}

.glow {
  /*display: flex;
  align-items: center;
  justify-content: center;*/
  position: relative;
  width: 250px;
  border-radius: 20px;
  /*font-family: 'Montserrat', sans-serif;
  font-size: 20px;
  font-weight: lighter;
  letter-spacing: 2px;*/
  transition: 1s box-shadow;
   box-shadow: 0 5px 35px 0px rgba(0,0,0,.3);
   
}

.glow:hover {
 
}

.glow:hover:before, .glow:hover:after {
  display: block;
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
  background: #FDA8CF;
  border-radius: 20px;
  z-index: -1;
  animation: 1s clockwise infinite;
}

.glow:hover:after {
  background: #F3CE5E;
  animation: 2s counterclockwise infinite;
}

@keyframes clockwise {
  0% {
    top: -5px;
    left: 0;
  }
  12% {
    top: -2px;
    left: 2px;
  }
  25% {
    top: 0;
    left: 5px;    
  }
  37% {
    top: 2px;
    left: 2px;
  }
  50% {
    top: 5px;
    left: 0;    
  }
  62% {
    top: 2px;
    left: -2px;
  }
  75% {
    top: 0;
    left: -5px;
  }
  87% {
    top: -2px;
    left: -2px;
  }
  100% {
    top: -5px;
    left: 0;    
  }
}

@keyframes counterclockwise {
  0% {
    top: -5px;
    right: 0;
  }
  12% {
    top: -2px;
    right: 2px;
  }
  25% {
    top: 0;
    right: 5px;    
  }
  37% {
    top: 2px;
    right: 2px;
  }
  50% {
    top: 5px;
    right: 0;    
  }
  62% {
    top: 2px;
    right: -2px;
  }
  75% {
    top: 0;
    right: -5px;
  }
  87% {
    top: -2px;
    right: -2px;
  }
  100% {
    top: -5px;
    right: 0;    
  }
}

/*--------------------*/
/* Colors */
/* SVG Colors */
.sky-blue {
  fill: #d8e9e8;
}
.snow-white {
  fill: #fff;
}
.sun-yellow {
  fill: #fbb040;
}
.atlantic-blue {
  fill: #9cc5ca;
}
.sand-yellow {
  fill: #ffde2f;
}
.mountain-yellow {
  fill: #fbab18;
}
.fall-orange {
  fill: #f26522;
}
.tree-brown {
  fill: #7a4900;
}
.mountain-brown {
  fill: #a84d10;
}
.style9 {
  stroke: #7a4900;
  stroke-miterlimit: 10;
  fill: none;
}
.style10 {
  fill: #663700;
}
.style11 {
  fill: #d4ece3;
}
.style12 {
  fill: #b45014;
}
.style13 {
  fill-rule: evenodd;
  clip-rule: evenodd;
  fill: #fbab18;
}
.style14 {
  fill-rule: evenodd;
  clip-rule: evenodd;
  fill: #f26522;
}
.style15 {
  fill-rule: evenodd;
  clip-rule: evenodd;
  fill: #7a4900;
}
.style16 {
  fill: #a7c8ca;
}
.style17 {
  fill: #7a4900;
  clip-rule: evenodd;
  fill-rule: evenodd;
}
.style18 {
  fill: #df6420;
}
.style19 {
  fill-rule: evenodd;
  clip-rule: evenodd;
  fill: #663700;
}
.style20 {
  fill: #6d6e71;
}
.style21 {
  fill: #e86d1f;
}
.style22 {
  fill: #151c24;
}
.style23 {
  fill: #ffe23c;
}
.boat,
.sand-bar {
  display: none;
}

/* Animations */
@media screen and (orientation: landscape) and (max-aspect-ratio: 2/1) {
  .mural {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    -webkit-animation: pan-mural-landscape 8s forwards ease;
    animation: pan-mural-landscape 8s forwards ease;
  }
}
@media screen and (orientation: portrait) {
  .mural {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    -webkit-animation: pan-mural-portrait 10s forwards ease;
    animation: pan-mural-portrait 10s forwards ease;
  }
}
/*.sky,
body {
  -webkit-animation: darken-sky 2s 2s forwards;
  animation: darken-sky 2s 2s forwards;
}
*/
.snow {
  background-image: url("<?php echo asset_url(); ?>images/snowh.png"), url("<?php echo asset_url(); ?>images/snow3q.png"), url("<?php echo asset_url(); ?>images/snow3q.png");
  -webkit-animation: show 0.25s 3s forwards, snowing 10s linear infinite;
  animation: show 0.25s 3s forwards, snowing 20s linear infinite;
}
.message {
  -webkit-animation: show 0.5s 6s forwards;
  animation: show 0.5s 6s forwards;
}
body {

}
.credits {
  opacity: 0;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
  filter: alpha(opacity=0);
}
.stage {
  position: relative;
  height: 100%;
  width: 100%;
  height: 100vh;
  overflow: hidden;
}
.ocean {
  position: fixed;
  width: 100%;
  height: 32.3%;
  background-color: #9cc5ca;
  bottom: 0;
}
.mural {
  position: relative;
  left: 0;
  bottom: 0;
  display: block;
  height: 100%;
  height: 100vh;
  z-index: 1;
}
.snow {
  position: absolute;
  opacity: 0;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
  filter: alpha(opacity=0);
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 2;
}
.message {
	font-style:italic;
  width: 100%;
  padding-top: 2em;
  padding-top: 5vh;
  color: #ffde2f;
  text-shadow: 2px 2px 4px #000;
  text-transform: uppercase;
  font-size: 2.6em;
  line-height: 2.6em;
  position: absolute;
  top: 0;
  z-index: 35;
  opacity: 0;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
  filter: alpha(opacity=0);
  text-align: center;
}
.message h1 {
  font-size: 10vh;
  margin: 0;
  font-weight: 700;
  line-height: 1em;
  margin-bottom: 0.25em;
  margin-bottom: 1vh;
}
.message h2 {
  font-size: 6vh;
  margin: 0;
  line-height: 1em;
  font-style: normal;
  font-weight: 100;
}
@media screen and (orientation: portrait) {
  .message h1 {
    font-size: 7vh;
  }
  .message h2 {
    font-size: 5vh;
  }
}
@-webkit-keyframes pan-mural-landscape {
  0% {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
  }
  100% {
    -webkit-transform: translate3d(-25%, 0, 0);
    transform: translate3d(-25%, 0, 0);
  }
}
@keyframes pan-mural-landscape {
  0% {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
  }
  100% {
    -webkit-transform: translate3d(-25%, 0, 0);
    transform: translate3d(-25%, 0, 0);
  }
}
@-webkit-keyframes pan-mural-portrait {
  0% {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
  }
  100% {
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0);
  }
}
@keyframes pan-mural-portrait {
  0% {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
  }
  100% {
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0);
  }
}
@-webkit-keyframes darken-sky {
  0% {
    background-color: #d8e9e8;
    fill: #d8e9e8;
  }
  70% {
    background-color: #b6420b;
    fill: #b6420b;
  }
  100% {
    background-color: #203938;
    fill: #203938;
  }
}
@keyframes darken-sky {
  0% {
    background-color: #d8e9e8;
    fill: #d8e9e8;
  }
  70% {
    background-color: #b6420b;
    fill: #b6420b;
  }
  100% {
    background-color: #203938;
    fill: #203938;
  }
}
@-webkit-keyframes sunset-clouds {
  0% {
    opacity: 100;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=10000)";
    filter: alpha(opacity=10000);
    fill: #fff;
  }
  10% {
    fill: #fbab18;
  }
  100% {
    opacity: 0;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
    filter: alpha(opacity=0);
  }
}
@keyframes sunset-clouds {
  0% {
    opacity: 100;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=10000)";
    filter: alpha(opacity=10000);
    fill: #fff;
  }
  10% {
    fill: #fbab18;
  }
  100% {
    opacity: 0;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
    filter: alpha(opacity=0);
  }
}
@-webkit-keyframes hide {
  0% {
    opacity: 100;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=10000)";
    filter: alpha(opacity=10000);
  }
  100% {
    opacity: 0;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
    filter: alpha(opacity=0);
  }
}
@keyframes hide {
  0% {
    opacity: 100;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=10000)";
    filter: alpha(opacity=10000);
  }
  100% {
    opacity: 0;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
    filter: alpha(opacity=0);
  }
}
@-webkit-keyframes darken-ocean {
  0% {
    background-color: #9cc5ca;
    fill: #9cc5ca;
  }
  100% {
    background-color: #254246;
    fill: #254246;
  }
}
@keyframes darken-ocean {
  0% {
    background-color: #9cc5ca;
    fill: #9cc5ca;
  }
  100% {
    background-color: #254246;
    fill: #254246;
  }
}
@-webkit-keyframes duke-energy-colors {
  0% {
    fill: #f26522;
  }
  50% {
    fill: #ffde2f;
  }
  60% {
    fill: #f26522;
  }
  100% {
    fill: #ffde2f;
  }
}
@keyframes duke-energy-colors {
  0% {
    fill: #f26522;
  }
  50% {
    fill: #ffde2f;
  }
  60% {
    fill: #f26522;
  }
  100% {
    fill: #ffde2f;
  }
}
@-webkit-keyframes building-lights {
  0% {
    fill: #ffde2f;
  }
  100% {
    fill: #fff2ac;
  }
}
@keyframes building-lights {
  0% {
    fill: #ffde2f;
  }
  100% {
    fill: #fff2ac;
  }
}
@-webkit-keyframes bofa-lights {
  0% {
    fill: #ffeb82;
  }
  100% {
    fill: #ffde2f;
  }
}
@keyframes bofa-lights {
  0% {
    fill: #ffeb82;
  }
  100% {
    fill: #ffde2f;
  }
}
@-webkit-keyframes fly {
  0% {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
  }
  100% {
    -webkit-transform: translate3d(7000px, 0, 0);
    transform: translate3d(7000px, 0, 0);
  }
}
@keyframes fly {
  0% {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
  }
  100% {
    -webkit-transform: translate3d(7000px, 0, 0);
    transform: translate3d(7000px, 0, 0);
  }
}
@-webkit-keyframes snowing {
  0% {
    background-position: 0 0, 0 0, 0 0;
  }
  100% {
    background-position: 500px 1000px, 400px 400px, 300px 300px;
  }
}
@keyframes snowing {
  0% {
    background-position: 0 0, 0 0, 0 0;
  }
  100% {
    background-position: 500px 1000px, 400px 400px, 300px 300px;
  }
}
@-webkit-keyframes show {
  0% {
    opacity: 0;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
    filter: alpha(opacity=0);
  }
  100% {
    opacity: 1;
    -ms-filter: none;
    -webkit-filter: none;
            filter: none;
  }
}
@keyframes show {
  0% {
    opacity: 0;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
    filter: alpha(opacity=0);
  }
  100% {
    opacity: 1;
    -ms-filter: none;
    -webkit-filter: none;
            filter: none;
  }
}
      </style>

   </head>
   <div id="wrapper"><div class="snow"></div> <body>
   
      <noscript>
         <div class="global-site-notice noscript">
            <div class="notice-inner">
               <p><strong>JavaScript seems to be disabled in your browser.</strong><br>You must have JavaScript enabled in
                  your browser to utilize the functionality of this website.
               </p>
            </div>
         </div>
      </noscript>
      <?php //$this->load->view("pos/keyboard"); ?>
      
         <?php $this->load->view("pos/navigation-bill") ?>
         <?php $this->load->view("pos/left-panel-bill"); ?>
        <?php /*?> <?php $this->load->view("pos/delivery"); ?>
      <?php */?>
      <?php //$this->load->view("pos/category-slider"); ?>
      <?php //$this->load->view("pos/sub_category-slider"); ?>
   
      <div id="order_tbl">
         <span id="order_span"></span>
        <table id="order-table" class="prT table table-striped" style="margin-bottom:0;" width="100%"></table>
      </div>
      <div id="bill_tbl">
         <span id="bill_span"></span>
         <table id="bill-table" width="100%" class="prT table table-striped" style="margin-bottom:0;"></table>
         <table id="bill-total-table" class="prT table" style="margin-bottom:0;" width="100%"></table>
      </div>
      <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
      <div class="modal fade in" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true"></div>
      <div id="modal-loading" style="display: none;">
         <div class="blackbg"></div>
         <div class="loader"></div>
      </div>
            
      
     
      
<script src="<?php echo asset_url(); ?>plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
<script src="<?php echo asset_url(); ?>plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo asset_url(); ?>plugins/jquery-validation/dist/jquery.validate.min.js"></script>

<script type="text/javascript" src="<?php echo asset_url(); ?>plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>plugins/DataTables/media/js/DT_bootstrap.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery-ui.min.js"></script>

<script src="<?php echo asset_url(); ?>js/ui-modals.js"></script>
<script src="<?php echo asset_url(); ?>js/accounting.min.js"></script>
<script src="<?php echo asset_url(); ?>js/accounting.js"></script>

<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.sendkeys.js"></script>
<script type="text/javascript" src="<?php echo asset_url(); ?>js/bililiteRange.js"></script>


      <script type="text/javascript" src="<?php echo asset_url(); ?>/js/plugins.min.js"></script>
      <script>
		$('#product-list, #category-list, #subcategory-list, #brands-list').perfectScrollbar({suppressScrollX: true});
		$('#posTable').stickyTableHeaders({scrollableArea: $('#product-list')});
      </script>
<script type="text/javascript" src="<?php echo asset_url();?>js/pos.ajax-bill.js"></script> 
<script language="javascript" type="text/javascript">
$('#print_bill').click(function(){
	
	window.open('<?php echo base_url(); ?>sales/preview','sharer','toolbar=0,status=0,width=384,height=700, left=10, top=10,scrollbars=no,addressbar=no');return false;
	
	});
</script>     
      <div id="ajaxCall"><i class="fa fa-spinner fa-pulse"></i></div>
 
          
</body>
</html>