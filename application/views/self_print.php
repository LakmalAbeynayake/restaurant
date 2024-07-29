<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    	<div style="padding:100px;cursor:not-allowed">
            <h3 style="text-align:center;">SENSUCHI <br>K.O.T PRINTING PAGE</h3>
            <h1 style="text-align:center; color:#F09">DON'T CLOSE THIS WINDOW</h1>
        </div>
    </body>
    <script src="<?php echo asset_url(); ?>plugins/jQuery-lib/2.0.3/jquery.min.js"></script>
    <script>
	
	var reallys = false;
	var allows = true;
	window.onbeforeunload = function() {
	  if(allows){
		  if(!reallys && true){
			  reallys = true;
			  var msg = "PLEASE DON'T CLOSE BROWSER UNLESS DAY END";
			  return msg;
			  }
		  }else{
			  allows = true;
		  }
  	}
	
        function fbs_click(id) {
    u = location.href;
    t = document.title;
    window.open('<?php echo base_url(); ?>sales/print_kot?sale_id=' + id, 'sharer'+ id, 'toolbar=0,status=0,width=350,height=700, left=10, top=10,scrollbars=yes');
    return 1;
}
    
    
    $(document).ready(function(){
        setInterval(function(){
            jQuery.ajax({
		type: "POST",
		url: "<?php echo base_url().'app_android/get_print_details'?>",
		cache: false,
		success: function (response) {
			//alert(JSON.parse(response));
                        var sale_id = JSON.parse(response);
                        if(sale_id){
                          var result = fbs_click(sale_id); 
                          if(result){
                              jQuery.ajax({
                                type: "POST",
                                url: "<?php echo base_url().'app_android/set_printed'?>",
                                data: {
                                    sale_id: sale_id,
                                },
                                cache: false,
                                success: function (response1) {
                                    console.log(response1);
                                }
		
                                });
                          }
                        }
		}
	});
        
        
    
    }, 8000);
//        setTimeOut(function(){
//        
//        fbs_click(1);
//        
//    },30000);
    });
    </script>
</html>
