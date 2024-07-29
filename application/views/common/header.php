<!DOCTYPE html>

<!-- Template Name: Clip-One - Responsive Admin Template build with Twitter Bootstrap 3.x Version: 1.4 Author: ClipTheme -->

<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->

<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->

<!--[if !IE]><!-->

<html lang="en" class="no-js">

<!--<![endif]-->

<!-- start: HEAD -->

<head>
<title>Stock Management System</title>

<!-- start: META -->

<meta charset="utf-8" />

<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->

<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta content="" name="description" />
<meta content="" name="author" />
<link rel="icon" type="image/png" href="<?php echo base_url(); ?>thems/images/logo-icon.png" />

<!-- end: META -->

<!-- start: MAIN CSS -->

<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>fonts/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/main.css">
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/main-responsive.css">
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/iCheck/skins/all.css">
<!--<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css">-->
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/perfect-scrollbar/src/perfect-scrollbar.css">
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/theme_light.css" id="skin_color">
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/print.css" media="print"/>

<!--[if IE 7]>



		<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/font-awesome/css/font-awesome-ie7.min.css">



		<![endif]-->

<!-- end: MAIN CSS -->

<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

</head>

<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/select2/select2.css" />
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" />
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/bootstrap-modal/css/bootstrap-modal.css" />
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/datepicker/css/datepicker.css">
<!--<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">-->
<!--<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">-->
<!--<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">-->
<!--<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/jQuery-Tags-Input/jquery.tagsinput.css">
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/summernote/build/summernote.css">-->
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/bootstrap-datetimepicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>plugins/gritter/css/jquery.gritter.css">
<style type="text/css">
body .modal {
/* new custom width



	    width: 750px; */



	    /* must be half of the width, minus scrollbar on the left (30px) 



	    margin-left: -375px;*/



}
button.dt-button, div.dt-button, a.dt-button {
	-moz-user-select: none;
	background-color: #e9e9e9;
	background-image: linear-gradient(to bottom, #fff 0%, #e9e9e9 100%);
	border: 1px solid #999;
	border-radius: 2px;
	box-sizing: border-box;
	color: black;
	cursor: pointer;
	display: inline-block;
	font-size: 0.7em;
	margin-right: 0em;
	margin-bottom: 0em;
	outline: medium none;
	overflow: hidden;
	padding: 0.5em 1em;
	position: relative;
	text-decoration: none;
	white-space: nowrap;
	margin-left: 0.333em;
	float: right !important;/* padding-right: 15px;

  

  text-align: right;

  border-right: 5px solid #eee;

  border-left: 0;*/

}
/*

@media print {

  body * {

    visibility: hidden;

  }

  #print-section, #print-section * {

    visibility: visible;

  }

  #print-section {

    position: absolute;

    left: 0;

    top: 0;

  }*/

}


.container {
        min-height: 90vh !important;
}

/* Styles for print */
@media print {
    .show-on-print {
        display: block !important;
    }
    .hidden-on-print {
        display: none !important;
    }
    * {
        background: white !important;;
    }
    .main-content{
        margin-left:0 !important;
    }
    .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
        padding: 2px !important;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
    }
}

</style>
<?php 



$this->session->userdata('ss_group_id');



clearstatcache();?>
