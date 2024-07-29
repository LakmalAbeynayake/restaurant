<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proceed_Order extends CI_Controller {

    var $main_menu_name = "proceed_order";
	var $sub_menu_name = "proceed_order";

	public function __construct()
	{
		parent::__construct();

		
	
		$this->load->model('Warehouse_Model');
		$this->load->model('Common_Model');
		
		$this->load->model('Customer_Model');
		
		$this->load->model('Order_Model');
		$this->load->model('Proceed_Order_Model');
		$this->load->model('Transfer_Model');
	}
	
	//Sales list page load
	public function index()
	{
		 
		$data['sales'] = $this->Sales_Model->get_all_sales();
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = $this->sub_menu_name;
        $this->load->view('sales',$data);
	}	
	
	//Sales details view
	public function view()
	{
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = '';
		
		//get sale id
		$sale_id=$this->uri->segment('3');
		$data['order_item_list']= $this->Order_Model->get_order_item_list_by_order_id($sale_id);
		$data['order_details']= $this->Order_Model->get_sale_info($sale_id);
		
		//$data['total_paid_amount']=$this->Order_Model->get_total_paid_by_sale_id($sale_id);
		
		$data['customer_details']= $this->Customer_Model->get_customer_info($data['order_details']['customer_id']);
		$data['warehouse_details']= $this->Warehouse_Model->get_warehouse_info($data['order_details']['warehouse_id']);		
		//$data['sale_payments_list']= $this->Order_Model->get_sale_payments_by_sale_id($sale_id);
		
		$old_payment_tot=0;
		$retured_payment_tot=0;
		$retured_payment_msg_this='';
		$old_payments_dis_msg_this='';
		
	
        $this->load->view('order_view',$data);
	}
	public function pending_order_view()
	{
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name']  = '';
		
		//get sale id
		$sale_id=$this->uri->segment('3');
		$data['order_item_list']= $this->Order_Model->get_order_item_list_by_order_id($sale_id);
		$data['order_details']= $this->Order_Model->get_sale_info($sale_id);
		
		//$data['total_paid_amount']=$this->Order_Model->get_total_paid_by_sale_id($sale_id);
		
		$data['customer_details']= $this->Customer_Model->get_customer_info($data['order_details']['customer_id']);
		$data['warehouse_details']= $this->Warehouse_Model->get_warehouse_info($data['order_details']['warehouse_id']);		
		//$data['sale_payments_list']= $this->Order_Model->get_sale_payments_by_sale_id($sale_id);
		
		$old_payment_tot=0;
		$retured_payment_tot=0;
		$retured_payment_msg_this='';
		$old_payments_dis_msg_this='';
		
	
        $this->load->view('order_view',$data);
	
	}
	public function proceed_order_view()
	{
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = '';
		
	
		$sale_id=$this->uri->segment('3');
		$data['order_item_list']= $this->Order_Model->get_order_item_list_by_order_id($sale_id);
		$data['order_details']= $this->Order_Model->get_sale_info($sale_id);
		
		
		$data['customer_details']= $this->Customer_Model->get_customer_info($data['order_details']['customer_id']);
		$data['warehouse_details']= $this->Warehouse_Model->get_warehouse_info($data['order_details']['warehouse_id']);		
		
		
		$old_payment_tot=0;
		$retured_payment_tot=0;
		$retured_payment_msg_this='';
		$old_payments_dis_msg_this='';
		
	
        $this->load->view('order_view',$data);
	}

	//Sales add page
	
	

	//Sales reference no jenarate	
	public function get_next_ref_no(){
		$query=$this->Order_Model->get_next_ref_no();
		$result = $query->row();
		//print_r($result);
		$sale_reference_no=sprintf("%05d", $result->order_id+1);
		$sale_reference_no=$sale_reference_no;
		echo json_encode(array('sale_reference_no'=>$sale_reference_no));
	}
	
	
	 public function suggestions($value='')
    {
		//print_r($_GET);
		$term=$this->input->get('term');
		$in_type=$this->input->get('t');
		$data['sales'] = $this->Sales_Model->get_products_suggestions($term);
		$json = array();
		//echo "Count:".count($data['sales']);
		//print_r($data['sales']);
		foreach ($data['sales'] as $row)
		{
			//set price
			$price_tmp=0;
			if($in_type=='Cash'){
				$price_tmp=$row['product_price'];
			}
			if($in_type=='Credit'){
				$price_tmp=$row['credit_salling_price'];
			}
			if($in_type=='Wholesale'){
				$price_tmp=$row['wholesale_price'];
			}
			
			$product_name=$row['product_name'];
			$product_code=$row['product_code'];
			$product_part_no=$row['product_part_no'];
			$product_oem_part_number=$row['product_oem_part_number'];
			$product_id=$row['product_id'];
			$product_price=$price_tmp;
			$sendParameters="'$product_id','$product_name','$product_code','$product_price'";
			$sendParameters="$product_id,$product_name,$product_code,$product_price";
			$extraName='';
			$extraName.=", Selling Price: ".number_format($product_price, 2, '.', ',');
			if($product_part_no) $extraName.=", Part No: $product_part_no";
			if($product_oem_part_number) $extraName.=", OEM Part No: $product_oem_part_number";
			

			
			
			 $json_itm=array(
			 		'id'=> $row['product_id'],
					'product_id'=> $row['product_id'],
					'product_code'=> $row['product_code'],
					'product_name'=> $row['product_name'],
					'product_price'=> $price_tmp,
					'product_part_no'=> $row['product_part_no'],
					'item_cost'=> $row['product_cost'],
					'product_oem_part_number'=> $row['product_oem_part_number'],
                    'value'=> $row['product_name']." (".$row['product_code'].")",
                    'label'=> $row['product_name']." (".$row['product_code'].")$extraName"
                    );
					array_push($json,$json_itm);
		}		
		echo json_encode($json);		
    }
	
	//Sale details page

	public function list_orders()
	{
	$requestData=$this->input->get();
	
	$search_key=$this->input->get('search');
	//print_r($search_key);
	//echo $search_key['value'];
	$search_key_val=$search_key['value'];
	$start=$this->input->get('start');
	$length=$this->input->get('length');
	$columns = array( 
		0 =>'sale_id', 
		1 => 'sale_reference_no',
		2=> 'sale_id',
		3 =>'sale_id', 
		4 => 'sale_id',
		5=> 'sale_id'
	);
	
	$data = array();
	$sales_tot = $this->Proceed_Order_Model->get_all_order('','','');
	
	//echo $start."/".$length."/".$search_key_val;
	$sales = $this->Proceed_Order_Model->get_all_order($start,$length,$search_key_val);
	$totalData = '';
	
	if($search_key_val){
		$tmp = $this->Proceed_Order_Model->get_all_order('','',$search_key_val);
		$totalData = count($tmp);
	}else
	$totalData = count($sales_tot);
	
	$totalFiltered = $totalData;  
	
	foreach ($sales as $row){
		$nestedData=array(); 
		$sale_id=$row['proceed_id'];
		
		$nestedData[] =display_date_time_format($row['proceed_datetime_create']);
		$nestedData[] = $row['proceed_ref_no'];
		$nestedData[] = $row['user_first_name']." ".$row['user_last_name'];
		
		
		
		$actionTxtDisble='';
		$actionTxtEnable='';
		$actionTxtUpdate='';
		$actionTxtDelete='';
		
		$url=base_url("proceed_order/order_details?order_id=$sale_id");
		$actionTxtUpdate='<a onClick="fbs_click('.$row['proceed_id'].')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="clip-zoom-in-2"></i></a> &nbsp;';
		
		$actionTxtViewDetails='<a href="'.base_url().'order/view/'.$sale_id.'" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-file-text-o"></i></a> &nbsp;';
	
	$nestedData[] = '<div class="btn-group text-left">
                            
							<button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                           
						    <ul role="menu" class="dropdown-menu pull-right">
                           
						   
						    <li><a onClick="fbs_click('.$row['proceed_id'].')" data-toggle="modal" href="#" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-print"></i> Print Proceed Order</a></li>
						   
						   
						   <li><a href="'.base_url().'purchases/add/'.$row['proceed_id'].'"><i class="fa fa-file-text"></i> Add GRN</a></li>
                            
							
							
							</ul></div>';
	
	$data[] = $nestedData;
}

	$json_data = array(
			"draw"            => intval($requestData['draw']),  
			"recordsTotal"    => intval($totalData),  
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data 
			);

	echo json_encode($json_data); 
	}
	  public function add_order()
    {
		$data['main_menu_name'] ='order';
		$data['sub_menu_name']  ='add_order';
		
		//get suppliers list
		$data['suppliers']      = $this->Supplier_Model->get_all_supplier();
		$data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
		$data['tax_rates_list'] = $this->Tax_Rates_Model->get_all_tax_rates();
		$data['customer_list']  = $this->Customer_Model->get_all_customers();
		$data['status_list']    = $this->Common_Model->get_all_status();
		
        $this->load->view('add_order',$data);
    }
	public function proceed_order_list()
	{
		 
		$data['sales']=$this->Proceed_Order_Model->get_all_order();
		$data['main_menu_name'] ='proceed_order';
		$data['sub_menu_name']  ='proceed_order';
        $this->load->view('proceed_order',$data);
	}	
	 public function pending_order_list()
	{
		 
		$data['sales']=$this->Order_Model->get_all_pending_order();
		$data['main_menu_name'] ='order';
		$data['sub_menu_name']  ='pending_order';
        $this->load->view('proceed_order_rep',$data);
	}	
	public function pending_list_orders()
	{     
		//print_r($this->input->get("date"));
		$date= $this->input->get('date');
		
		//$date = date();
	$requestData=$this->input->get();
	$search_key=$this->input->get('search');
	$search_key_val=$search_key['value'];
	$start=$this->input->get('start');
	$length=$this->input->get('length');
	
	$columns = array( 
		0 =>'sale_id', 
		1 => 'sale_reference_no',
		2=> 'sale_id',
		3 =>'sale_id', 
		4 => 'sale_id',
		5=> 'sale_id'
	);
	
	$data = array();
	$sales_tot = $this->Order_Model->get_all_order();
	$sales = $this->Order_Model->get_all_pending_order($start,$length,$search_key_val,$date);
	
	$totalData = count($sales_tot);
	$totalFiltered = $totalData;  
	
	foreach ($sales as $row){
		$nestedData=array(); 
		$sale_id=$row['order_id'];
	$nestedData[]='<center><input checked type="checkbox" id="odr_'.$row['order_id'].'" name="odr_'.$row['order_id'].'" value="'.$row['order_id'].'""></center>';
		$nestedData[] =display_date_time_format($row['order_datetime']);
		$nestedData[] = $row['order_reference_no'];
		$nestedData[] = $row['cus_name'];
		
	
		
		
		
		if ($row['status']=='0') {
		  $pay_st = '<span class="label label-warning">Pending</span>';
		}else{
		  if ($row['status']=='1') {
			$pay_st = '<span class="label label-success">Approved</span>';
		  }
		 
		  
		  
		  
		}
		
		$nestedData[]=$pay_st;
		
		
		//$nestedData[] = $row['sale_id'];
		$actionTxtDisble='';
		$actionTxtEnable='';
		$actionTxtUpdate='';
		$actionTxtDelete='';
		
		$url=base_url("order/order_details?order_id=$sale_id");
		$actionTxtUpdate='<a onClick="fbs_click('.$row['order_id'].')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="clip-zoom-in-2"></i></a> &nbsp;';
		
		$actionTxtViewDetails='<a href="'.base_url().'order/view/'.$sale_id.'" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-file-text-o"></i></a> &nbsp;';
	
	$nestedData[] = '<center><div class="btn-group text-left">
                            <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu pull-right">
                           <!-- <li><a href="'.base_url().'order/view/'.$sale_id.'"><i class="fa fa-file-text-o"></i> Pending Order Details</a></li>-->
                            
							
							<!--
							 <li><a onClick="fbs_click('.$row['order_id'].')" data-toggle="modal" href="#" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-print"></i> Print Order</a></li>-->
							
                            </ul></div></center>';
	
	$data[] = $nestedData;
}

	$json_data = array(
			//"draw"            => intval($requestData['draw']),  
			"recordsTotal"    => intval($totalData),  
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data 
			);

	echo json_encode($json_data); 
	} 
	
	
public function proceed(){
	   
	    $list = $this->input->post('list');
	
		$query    		= $this->Order_Model->get_proceed_ref_no();
        $result  		= $query->row();
        $proceed_ref_no	= sprintf("%05d", $result->proceed_ref_no+1);
		$user_id=$this->session->userdata('ss_user_id');
		
		//print_r($list);
		$this->Order_Model->proceed($list);
		
		$proceed_order_value=$this->Order_Model->get_proceeded_items($list);
		$order_values= $this->Order_Model->get_order($list);
		
	
        //print_r($proceed_order_value);
		//print_r($order_values);
$sbdate='';	
$crdate='';	
		foreach($order_values as $order)
		{
			$crdate =$order['order_datetime_created'];
			$sbdate =$order['order_datetime'];
			
		}
		$orderz=array
		(  
		   'user_id '=>$user_id, 
		   'proceed_ref_no'=>$proceed_ref_no,
		   'proceed_datetime_create'=>$crdate,
		   'proceed_datetime_submit'=>$sbdate
		 );
		$this->Order_Model->save_proceed($orderz);
		
		//print_r($proceed_order_value);
		
$last_id = $this->db->insert_id();	
		foreach($proceed_order_value as $row){
		
		   
		   $product_id =$row['product_id'];
		   $quantity=$row['quantity'];
		  
		   $data=array
		   (
		   
		   
		        'proceed_id'=>$last_id,
		        'po_item_id'=>$product_id,	
				'po_item_quantity'=>$quantity
		   
		
			 );
		   $this->Order_Model->save_proceed_items($data);
		
		}
     
		
		
	}
		public function cancel()
		{
		    $order_id=$this->input->post('sale_id');
			
			$this->Order_Model->cancel($order_id);
			
		}
		
	public function proceed_order_details()
	{
		/*
		
					'po_item_id' 		=> $row['po_item_id'],
					'po_item_quantity'	=> $row['po_item_quantity'],
					'product_name'		=> $row['product_name']
			
		*/
		$proceed_id=$this->input->get('proceed_id');
		$data['proceed_item']= $this->Proceed_Order_Model->get_proceed_item_list($proceed_id);
		/*$raw_item_list= $this->Proceed_Order_Model->get_proceed_item_list($proceed_id);
		
		print_r($raw_item_list);
		$item_list =array();
		
		foreach($raw_item_list as $row){ 
		print_r($row['po_item_id']);
			$data1 = array();
				$data1[] = $row['po_item_id'];
				$data1[] = $row['po_item_quantity'];
				$data1[] = $row['product_name'];
			
				$item_list[] = $data1;
			}
			print_r($item_list);
//			echo count($item_list);
			
			$c = count($item_list);
			for($i = 0; $i < $c; $i++){
				foreach( $item_list[$i] as $row){
					print_r($row);
						//if (in_array("mac", $os)) {
						//echo "Got mac";
						//}
					}
			}*/
		
		$data['proceed_ref_no']=$this->Proceed_Order_Model->get_proceed_ref($proceed_id);
		//$data['cr_limit_list'] = $this->Common_Model->get_all_cr_limit();
        $this->load->view('models/view_proceed_order',$data);
	}	
	  
	public function get_order_details_for_grn(){
		
		$proceed_id=$this->input->get('po_id');
		$data['proceed_item']= $this->Proceed_Order_Model->get_proceed_item_list($proceed_id);
		$data['proceed_ref_no']=$this->Proceed_Order_Model->get_proceed_ref($proceed_id);
		echo json_encode($data);
		
	}
		
}