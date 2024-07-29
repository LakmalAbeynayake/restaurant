

<body onLoad="window.print()">
	<?php $this->load->view("common/header"); ?>
	<style type="text/css">
body, .main-container, .footer, .main-navigation, ul.main-navigation-menu > li > ul.sub-menu, .navigation-small ul.main-navigation-menu > li > ul.sub-menu {
  background-color: #fff !important;
}
.report_view_th{
	background-color:#fff;
	color:#fff !important;
	font-size:12px;
	text-align:center;	
}
.table-responsive td{
	font-size:8px;	
}
h4{
	font-size:8px;
}
.code-size{
	font-size:8px;
	font-weight:bold;
}
.code_box{
			float: left;
			height: 25px;
			margin-bottom: 50px;
			margin-right: 42px;
			width: 110px;
			font-size:8px;
			text-align:center;
	        }
</style>
		

<div class="modal-header">

         

         
            <div class="modal-body">
          
            


<div class="">

<?php 

$values=$product_list;
 $data = array();

	        if (!empty($values)) {
	            foreach ($values as $products) {

	           
/*	            $row = array();
                  $row[] = '<div style="margin-bottom: 0px; width: 50px; height: 50px;" class="fileupload-new thumbnail"><img alt="" src="'.asset_url()."uploads/thumbs/".$products->product_thumb.'"></div>';
                  $row[] = $products->product_code;
                 
                  $row[] = $products->product_part_no;
	                $row[] = $products->product_name;
	                $row[] = $products->cat_name;
	                $row[] = $retVal;*/
					$name=substr($products->product_name,0,25);
                  echo "<div class=\"code_box\"<br/>$name<br/>";
				  ?>
                  <img class="" alt="<?php echo $products->product_code; ?>" src="<?php echo base_url().'products/gen_barcode/'.$products->product_code.'/20'; ?>"></div>
                  <?php
	                
	            }

	           
	        }
?>


</div>

<div class="row">
<div class="col-xs-12">
</div>
<div class="col-xs-5 pull-right">
<div class="well well-sm">

</div>
</div>
</div>

             
                 <!--/.col-md-12-->

</body>

