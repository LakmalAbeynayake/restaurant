<div style="top:2px;" class="panel-tools open">
<button data-toggle="dropdown" class="btn btn-blue dropdown-toggle" onClick="window.print()">
<i class="fa fa-print"></i>
</button>
</div>

<body onLoad="window.print()">
	<?php $this->load->view("common/header"); ?>
	<style type="text/css">
.report_view_th{
	background-color:#428bca;
	color:#fff !important;
	font-size:12px;
	text-align:center;	
}
.table-responsive td{
	font-size:11px;	
}
h4{
	font-size:13px;
}
.code-size{
	font-size:17px;
	font-weight:bold;
}
.code_box{
			float: left;
			height: 50px;
			margin-bottom: 50px;
			margin-right: 20px;
			width: 200px;
			font-size:17px;
	        }
</style>
		

<div class="modal-header">

         

         
            <div class="modal-body">
          
            


<div class="table-responsive">

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
                  echo "<div class=\"code_box\"<br/>$products->product_name<br/>$products->sub_cat_name<br/><div class='code-size'>( $products->product_code )</div></div>";
	                
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

