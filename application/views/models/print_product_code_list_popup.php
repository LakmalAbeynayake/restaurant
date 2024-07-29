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
	        }
</style>
		

<div class="modal-header">

         

         
            <div class="modal-body">
          
            


<div class="table-responsive">
<table class="table table-bordered table-hover table-striped print-table order-table">
<thead>
 <tr class="report_view_th">
   <td> #</td>
               <td> Category</td>
              <td>  Sub Category</td>
              <td> Code</td>
              <td> Name</td>
			  <td> Cost</td>
			  <td> Selling Price</td>
</tr>
</thead>
<?php 
 $tmpcount=0;

$values=$product_list;
 $data = array();

	        if (!empty($values)) {
	            foreach ($values as $products) {
$tmpcount++;
	           ?>
               <tr>
               <td style="text-align:right; width:40px; vertical-align:middle;"><?php echo sprintf("%04d",$tmpcount); ?></td>
               <td> 
              <?php echo $products->cat_name ?>
              </td>
              <td> 
              <?php echo $products->sub_cat_name ?>
              </td>
               <td> 
              <?php echo $products->product_code ?>
              </td>
              <td> 
              <?php echo $products->product_name ?>
               <!--
                  echo "<div class=\"code_box\"<br/>$products->product_name<br/>$products->sub_cat_name<br/><div class='code-size'>( $products->product_code )</div></div>";-->
	           
               </td>
			    <td> 
              <?php echo $products->product_cost ?>
              </td>
			   <td> 
              <?php echo $products->product_price ?>
              </td>
               </tr>
               <?php
			        
	            }

	           
	        }
?>

</table>

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

