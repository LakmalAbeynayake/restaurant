<body onLoad="fbs_click(<?php print_r($sale_id)?>)">

<script language="javascript" type="text/javascript">
function fbs_click(id) {
	u=location.href;
	t=document.title;
	window.open('../sales/pos_sale_details?sale_id='+id+'&pay_amount=<?php print_r($pay_amount)?>&paid_by=<?php print_r($paid_by)?>','sharer','toolbar=0,status=0,width=384,height=700, left=10, top=10,scrollbars=yes');return false;
	//window.navigator(' base_url() ');

}
</script>

<?php redirect("../pos", "refresh") ?>
</body>