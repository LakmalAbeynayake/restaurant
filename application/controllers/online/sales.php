<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales extends CI_Controller {

    var $main_menu_name = "sales";
	var $sub_menu_name = "sales";

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Sales_Model');
		$this->load->model('Supplier_Model');
		$this->load->model('Warehouse_Model');
		$this->load->model('Common_Model');
		$this->load->model('Tax_Rates_Model');
		$this->load->model('Customer_Model');
		$this->load->model('Sales_Return_Model');
		
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
		$data['sale_details']= $this->Sales_Model->get_sale_info($sale_id);
		
		if($data['sale_details']){
			$data['sale_item_list']= $this->Sales_Model->get_sale_item_list_by_sale_id($sale_id);
		$data['total_paid_amount']=$this->Sales_Model->get_total_paid_by_sale_id($sale_id);
		
		//echo $sale_id;
		$data['sale_payments_list']= $this->Sales_Model->get_sale_payments_by_sale_id($sale_id);
		
		$old_payment_tot=0;
		$retured_payment_tot=0;
		$retured_payment_msg_this='';
		$old_payments_dis_msg_this='';
		
		//check return payments
		$return_sales_details=$this->Sales_Return_Model->get_return_sale_info_sale_id($sale_id);
		
		
		foreach ($return_sales_details as $row)
		{
	 		//echo "sale id:$row->sale_id";
			//echo "sale_total:$row->sale_total";

				$this_balance_pament=0;
				$this_trn_amt=$row->sl_rtn_total;
				$retured_payment_tot=$retured_payment_tot+$this_trn_amt;

				$retured_payment_msg_this=$retured_payment_msg_this.' -'.$this_trn_amt.' ,';
			
			
 		}
		
		
		$old_payment_tot=$old_payment_tot-$retured_payment_tot;
		
		$data['old_payments']=$old_payment_tot;
		$data['old_payments_dis_msg']="Return Total Amount ($old_payments_dis_msg_this $retured_payment_msg_this)";
		
		$data['sale_id']=$sale_id;
			$data['customer_details']= $this->Customer_Model->get_customer_info($data['sale_details']['customer_id']);
			$data['warehouse_details']= $this->Warehouse_Model->get_warehouse_info($data['sale_details']['warehouse_id']);		
        $this->load->view('sales_view',$data);
		}else show_404();
	}

	//Sales add page
	public function add_sale_payments()
	{
		$sale_pymnt_amount=$this->input->post('sale_pymnt_amount');
		$sale_id=$this->input->post('sale_id');
		$sale_pymnt_ref_no=$this->input->post('sale_pymnt_ref_no');
		$sale_pymnt_paying_by=$this->input->post('sale_pymnt_paying_by');
		$sale_pymnt_date_time=$this->input->post('sale_pymnt_date_time');
		$sale_pymnt_date_time_send=date('Y-m-d H:i:s', strtotime($sale_pymnt_date_time));
		$sale_pymnt_cheque_no=$this->input->post('sale_pymnt_cheque_no');
		$sale_pymnt_crdt_card_no=$this->input->post('sale_pymnt_crdt_card_no');
		$sale_pymnt_crdt_card_holder_name=$this->input->post('sale_pymnt_crdt_card_holder_name');
		$sale_pymnt_crdt_card_month=$this->input->post('sale_pymnt_crdt_card_month');
		$sale_pymnt_crdt_card_year=$this->input->post('sale_pymnt_crdt_card_year');
		$sale_pymnt_crdt_card_type=$this->input->post('sale_pymnt_crdt_card_type');
		$sale_type = $this->input->post('sale_type');

		$sale_pymnt_note=$this->input->post('sale_pymnt_note');
		$user_id=$this->session->userdata('ss_user_id');
		$sale_pymnt_added_date_time=date("Y-m-d H:i:s");
		$sale_pymnt_id='';
		
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('sale_pymnt_amount', 'Amount', 'required');
		if($sale_pymnt_paying_by=='Credit Card'){
			$this->form_validation->set_rules('sale_pymnt_crdt_card_type', 'Card Type', 'required');
			$this->form_validation->set_rules('sale_pymnt_crdt_card_no', 'Credit Card No', 'required');
			$this->form_validation->set_rules('sale_pymnt_crdt_card_holder_name', 'Holder Name', 'required');
			$this->form_validation->set_rules('sale_pymnt_crdt_card_month', 'Month', 'required');
			$this->form_validation->set_rules('sale_pymnt_crdt_card_year', 'Year', 'required');
		}
		if($sale_pymnt_paying_by=='Cheque'){
			$this->form_validation->set_rules('sale_pymnt_cheque_no', 'Cheque No', 'required');
		}
		$this->form_validation->set_rules('sale_id', 'System Error', 'required');


        if ($this->form_validation->run() == FALSE)
        {
           $st = array('status' =>0,'validation' => validation_errors());
           echo json_encode($st);
        }
        else
        {
			$data=array(
				'sale_pymnt_amount'=>$sale_pymnt_amount,	
				'sale_pymnt_ref_no'=>$sale_pymnt_ref_no,
				'sale_pymnt_paying_by'=>$sale_pymnt_paying_by,
				'sale_pymnt_date_time'=>$sale_pymnt_date_time_send,
				'sale_pymnt_note'=>$sale_pymnt_note,
				'user_id'=>$user_id,
				'sale_id'=>$sale_id,
				'sale_pymnt_added_date_time'=>$sale_pymnt_added_date_time,
				'sale_pymnt_cheque_no'=>$sale_pymnt_cheque_no,
				'sale_pymnt_crdt_card_no'=>$sale_pymnt_crdt_card_no,
				'sale_pymnt_crdt_card_holder_name'=>$sale_pymnt_crdt_card_holder_name,
				'sale_pymnt_crdt_card_type'=>$sale_pymnt_crdt_card_type,
				'sale_pymnt_crdt_card_month'=>$sale_pymnt_crdt_card_month,
				'sale_pymnt_crdt_card_year'=>$sale_pymnt_crdt_card_year,
				'sale_payment_type' => $sale_type
			);
			
               if ($this->Sales_Model->save_sale_payments($data,$sale_pymnt_id)) {
                    $st = array('status' =>1,'validation' =>'Done!');
                    echo json_encode($st);
               } else {
                    $st = array('status' =>0,'validation' =>'error occurred please contact your system administrator');
                    echo json_encode($st);
               }
		}
	}	
	
	//Sales payment page 
	public function payments()
	{
        $data['sale_id'] = $this->input->get('id');
        $data['sale_type'] = $this->input->get('sale_type');
        $this->load->view('models/sales_payment',$data);	
	}
	
	//Sales save 
	//Sales item save
	//Add sales items to 54 table
	public function save_sales()
	{
		//$sale_reference_no=$this->input->post('sale_reference_no');
		 $query   		= $this->Sales_Model->get_next_ref_no();
        $result  		= $query->row();
        $sale_reference_no		= sprintf("%05d", $result->sale_id+1);
		
		
		$warehouse_id=$this->input->post('warehouse_id');
		$customer_id=$this->input->post('customer_id');
		$rowCount=$this->input->post('rowCount');
		
		$sale_datetime_1=$this->input->post('sale_datetime');
		$sale_datetime=date('Y-m-d H:i:s', strtotime($sale_datetime_1));
		$tax_rate_id=$this->input->post('tax_rate_id');
		$sale_inv_discount=$this->input->post('sale_inv_discount');
		$sale_status=$this->input->post('sale_status');
		$payment_status=$this->input->post('payment_status');
		$sale_shipping=$this->input->post('sale_shipping');
		$sale_payment_term=$this->input->post('sale_payment_term');
		$sale_total=$this->input->post('sale_total');
		$sale_paid=$this->input->post('sale_paid');
		if($sale_paid == "NaN")$sale_paid = 0;
		$sale_balance=$this->input->post('sale_balance');
		$cost_total=$this->input->post('cost_total');
		$in_type=$this->input->post('in_type');
		$sale_inv_discount_amount=$this->input->post('sale_inv_discount_amount');
		$sale_datetime_created=date('Y-m-d H:i:s');
		
		$error='';
		$disMsg='';
		$lastid='';
		$sale_id='';
		
		if(!$error){
			$data=array(
				'sale_reference_no'=>$sale_reference_no,
				'warehouse_id'=>$warehouse_id,
				'customer_id'=>$customer_id,
				'warehouse_id'=>$warehouse_id,
				'sale_datetime'=>$sale_datetime,
				'tax_rate_id'=>$tax_rate_id,
				'sale_inv_discount'=>$sale_inv_discount,
				'sale_status'=>$sale_status,
				'payment_status'=>$payment_status,
				'sale_shipping'=>$sale_shipping,
				'sale_payment_term'=>$sale_payment_term,
				'sale_total'=>$sale_total,
				'sale_paid'=>$sale_paid,
				'cost_total'=>$cost_total,
				'sale_balance'=>$sale_balance,
				'in_type'=>$in_type,
				'sale_datetime_created'=>$sale_datetime_created,
				'sale_inv_discount_amount'=>$sale_inv_discount_amount
			);
			$_insert=$this->Sales_Model->save_sales($data,$sale_id);
			$lastid=$this->db->insert_id();
			$sale_id=$lastid;
			//insert user activity
			$this->Common_Model->add_user_activitie("Added Sale, (Invoice No:$sale_reference_no)");
			$disMsg='Sale successfully added';
			
			//insert sale item data
			$row=$this->input->post('row');
			$rowCount=$this->input->post('rowCount');
			$data_item=array();
			for($i=1; $i<=$rowCount; $i++){
				//echo "/ $rowCount , Test:".$row[$i]['product_id'][0];
				if(isset($row[$i]['product_id'][0]))
				{					
				$data_item=array(
					'sale_id'=>$sale_id,
					'product_id'=>$row[$i]['product_id'][0],
					'quantity'=>$row[$i]['qty'][0],
					'discount'=>$row[$i]['discount'][0],
					'unit_price'=>$row[$i]['unit_price'][0],
					'item_cost'=>$row[$i]['item_cost'][0],
					'unit_price'=>$row[$i]['unit_price'][0]+$row[$i]['item_price_p'][0],
					'discount_val'=>$row[$i]['discount_val'][0], 
					'gross_total'=>$row[$i]['gross_total'][0]
				);
				$this->Sales_Model->save_sales_item($data_item);
				$itemid=$this->db->insert_id();
				//insert user activity
				$this->Common_Model->add_user_activitie("Added Sale Item, (Id:$itemid)");
				
				//add reford for f4 table
				$type='sale';
				$ref_id=$sale_id;
				$product=$row[$i]['product_id'][0];
				$quantity=$row[$i]['qty'][0];
				$unit_cost=$row[$i]['unit_price'][0];
				$this->Common_Model->add_fi_table($type,$ref_id,$product,$quantity,$unit_cost);
				}
			}
		
		}else {
			
			$disMsg='Please select these before adding any product:'.$disMsg;
		}	
		
		$this->session->set_flashdata('message', 'Sale successfully added!');
		
		echo json_encode(array('sale_id'=>$lastid,'error'=>$error,'disMsg'=>$disMsg,));
	}

	//Sales reference no jenarate	
	public function get_next_ref_no(){
		$query=$this->Sales_Model->get_next_ref_no();
		$result = $query->row();
		//print_r($result);
		$sale_reference_no=sprintf("%05d", $result->sale_id+1);
		$sale_reference_no=$sale_reference_no;
		echo json_encode(array('sale_reference_no'=>$sale_reference_no));
	}
	
	//Sales ger avalable product qty
	public function get_avalable_product_qty(){
		$product_id=$this->input->get('product_id');
		$warehouse_id=$this->input->get('warehouse_id');
		
		$data['total']=$this->Sales_Model->get_avalable_product_qty($product_id,$warehouse_id);
		echo json_encode(array('remmnaingQty'=>$data['total']));
	}

	//Sales add form
    public function add_sales()
    {
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = 'add_sales';
		
		//get suppliers list
		$data['suppliers'] = $this->Supplier_Model->get_all_supplier();
		$data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
		$data['tax_rates_list'] = $this->Tax_Rates_Model->get_all_tax_rates();
		$data['customer_list'] = $this->Customer_Model->get_all_customers();
		$data['status_list'] = $this->Common_Model->get_all_status();
		
        $this->load->view('add_sales',$data);
    }
	
	//Sales product items get
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
				$price_tmp=$row['product_price'];//$price_tmp=$row['credit_salling_price'];
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
	public function sale_details()
	{
		$sale_type = 0;
		$sale_id=$this->input->get('sale_id');
		$sale_type = $this->input->get('type');
		$data['sale_details']= $this->Sales_Model->get_sale_info($sale_id);
		$data['sale_type'] = $sale_type;
		//get sale item list
		$data['sale_item_list']= $this->Sales_Model->get_sale_item_list_by_sale_id($sale_id);
		
		$data['customer_details']= $this->Customer_Model->get_customer_info($data['sale_details']['customer_id']);
		$data['warehouse_details']= $this->Warehouse_Model->get_warehouse_info($data['sale_details']['warehouse_id']);
		$data['sale_payments_list']= $this->Sales_Model->get_sale_payments_by_sale_id($sale_id);
		
		//get old payments amounts
		$cus_sales_details=$this->Sales_Model->get_sale_info_by_customer_id($data['sale_details']['customer_id']);
		//print_r($cus_sales_details);
		$old_payment_tot=0;
		$retured_payment_tot=0;
		$retured_payment_msg_this='';
		$old_payments_dis_msg_this='';
		
		foreach ($cus_sales_details as $row)
		{
	 		//echo "sale id:$row->sale_id";
			//echo "sale_total:$row->sale_total";
			if($row->sale_id!=$sale_id){
			//get paid amount
			$paid_amount=$this->Sales_Model->get_total_paid_by_sale_id($row->sale_id);
			if($row->sale_total!=$paid_amount){
				//$this_balance_pament=$row->sale_total-$paid_amount;
				//$old_payment_tot=$old_payment_tot+$this_balance_pament;
				//echo "sale_total:$row->sale_total , ";
				//$old_payments_dis_msg_this=$old_payments_dis_msg_this.''.$this_balance_pament.' ,';
			}
			}
 		}
		
		//check return payments
		$return_sales_details=$this->Sales_Return_Model->get_return_sale_info_sale_id($sale_id);
		
		
		foreach ($return_sales_details as $row)
		{
	 		//echo "sale id:$row->sale_id";
			//echo "sale_total:$row->sale_total";

				$this_balance_pament=0;
				$this_trn_amt=$row->sl_rtn_total;
				$retured_payment_tot=$retured_payment_tot+$this_trn_amt;

				$retured_payment_msg_this=$retured_payment_msg_this.' -'.$this_trn_amt.' ,';
			
			
 		}
		
		
		$old_payment_tot=$old_payment_tot-$retured_payment_tot;
		
		$data['old_payments']=$old_payment_tot;
		$data['old_payments_dis_msg']="Return Total Amount ($old_payments_dis_msg_this $retured_payment_msg_this)";
		
		
		$data['cr_limit_list'] = $this->Common_Model->get_all_cr_limit();
        $this->load->view('models/view_sales',$data);
	}	
	public function sale_details_pos()
    {
		$sale_type = 0;
		$sale_id=$this->input->get('sale_id');
		$sale_type = $this->input->get('type');
		$data['sale_details']= $this->Sales_Model->get_sale_info($sale_id);
		$data['sale_type'] = $sale_type;
		//get sale item list
		$data['sale_item_list']= $this->Sales_Model->get_sale_item_list_by_sale_id($sale_id);
		
		$data['customer_details']= $this->Customer_Model->get_customer_info($data['sale_details']['customer_id']);
		$data['warehouse_details']= $this->Warehouse_Model->get_warehouse_info($data['sale_details']['warehouse_id']);
		$data['sale_payments_list']= $this->Sales_Model->get_sale_payments_by_sale_id($sale_id);
		
		//get old payments amounts
		$cus_sales_details=$this->Sales_Model->get_sale_info_by_customer_id($data['sale_details']['customer_id']);
		//print_r($cus_sales_details);
		$old_payment_tot=0;
		$retured_payment_tot=0;
		$retured_payment_msg_this='';
		$old_payments_dis_msg_this='';
		
		foreach ($cus_sales_details as $row)
		{
	 		//echo "sale id:$row->sale_id";
			//echo "sale_total:$row->sale_total";
			if($row->sale_id!=$sale_id){
			//get paid amount
			$paid_amount=$this->Sales_Model->get_total_paid_by_sale_id($row->sale_id);
			if($row->sale_total!=$paid_amount){
				//$this_balance_pament=$row->sale_total-$paid_amount;
				//$old_payment_tot=$old_payment_tot+$this_balance_pament;
				//echo "sale_total:$row->sale_total , ";
				//$old_payments_dis_msg_this=$old_payments_dis_msg_this.''.$this_balance_pament.' ,';
			}
			}
 		}
		
		//check return payments
		$return_sales_details=$this->Sales_Return_Model->get_return_sale_info_sale_id($sale_id);
		
		
		foreach ($return_sales_details as $row)
		{
	 		//echo "sale id:$row->sale_id";
			//echo "sale_total:$row->sale_total";

				$this_balance_pament=0;
				$this_trn_amt=$row->sl_rtn_total;
				$retured_payment_tot=$retured_payment_tot+$this_trn_amt;

				$retured_payment_msg_this=$retured_payment_msg_this.' -'.$this_trn_amt.' ,';
			
			
 		}
		
		
		$old_payment_tot=$old_payment_tot-$retured_payment_tot;
		
		$data['old_payments']=$old_payment_tot;
		$data['old_payments_dis_msg']="Return Total Amount ($old_payments_dis_msg_this $retured_payment_msg_this)";
		
		
		$data['cr_limit_list'] = $this->Common_Model->get_all_cr_limit();
        $this->load->view('models/view_sales_pos', $data);
    }
	
	public function pos_sale_details()
	{
		$sale_type = 0;
		$sale_id=$this->input->get('sale_id');
		$sale_type = $this->input->get('type');
		$data['sale_details']= $this->Sales_Model->get_sale_info($sale_id);
		$data['sale_type'] = $sale_type;
		//get sale item list
		$data['sale_item_list']= $this->Sales_Model->get_sale_item_list_by_sale_id($sale_id);
		
		$data['customer_details']= $this->Customer_Model->get_customer_info($data['sale_details']['customer_id']);
		$data['warehouse_details']= $this->Warehouse_Model->get_warehouse_info($data['sale_details']['warehouse_id']);
		$data['sale_payments_list']= $this->Sales_Model->get_sale_payments_by_sale_id($sale_id);
		
		//get old payments amounts
		//$cus_sales_details=$this->Sales_Model->get_sale_info_by_customer_id($data['sale_details']['customer_id']);
		//print_r($cus_sales_details);
		//$old_payment_tot=0;
		//$retured_payment_tot=0;
		//$retured_payment_msg_this='';
		//$old_payments_dis_msg_this='';
		
		/*foreach ($cus_sales_details as $row)
		{
	 		//echo "sale id:$row->sale_id";
			//echo "sale_total:$row->sale_total";
			if($row->sale_id!=$sale_id){
			//get paid amount
			$paid_amount=$this->Sales_Model->get_total_paid_by_sale_id($row->sale_id);
			if($row->sale_total!=$paid_amount){
				//$this_balance_pament=$row->sale_total-$paid_amount;
				//$old_payment_tot=$old_payment_tot+$this_balance_pament;
				//echo "sale_total:$row->sale_total , ";
				//$old_payments_dis_msg_this=$old_payments_dis_msg_this.''.$this_balance_pament.' ,';
			}
			}
 		}
		*/
		//check return payments
		//$return_sales_details = $this->Sales_Return_Model->get_return_sale_info_sale_id($sale_id);
		
		/*
		foreach ($return_sales_details as $row)
		{
	 		//echo "sale id:$row->sale_id";
			//echo "sale_total:$row->sale_total";

				$this_balance_pament=0;
				$this_trn_amt=$row->sl_rtn_total;
				$retured_payment_tot=$retured_payment_tot+$this_trn_amt;

				$retured_payment_msg_this=$retured_payment_msg_this.' -'.$this_trn_amt.' ,';
			
			
 		}*/
		
		
		//$old_payment_tot=$old_payment_tot-$retured_payment_tot;
		
		//$data['old_payments']=$old_payment_tot;
		//$data['old_payments_dis_msg']="Return Total Amount ($old_payments_dis_msg_this $retured_payment_msg_this)";
		
		//$data['cr_limit_list'] = $this->Common_Model->get_all_cr_limit();
        $this->load->view('models/pos_view_sales',$data);
	}	
	
	//Sales list
	public function list_sales()
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
	$sales_tot = $this->Sales_Model->get_all_sales();
	$sales = $this->Sales_Model->get_all_sales($start,$length,$search_key_val);
	
	$totalData = count($sales_tot);
	$totalFiltered = $totalData;  
	
	foreach ($sales as $row){
		$nestedData=array(); 
		$sale_id=$row['sale_id'];
		$total_paid_amount=0;
		$total_paid_amount=$this->Sales_Model->get_total_paid_by_sale_id($sale_id);
		$return_tot_amt=0;
		$return_tot_amt=$this->Sales_Return_Model->get_total_return_by_sale_id($sale_id);
		$to_be_paid=$row['sale_total']-$return_tot_amt;
		$nestedData[] =display_date_time_format($row['sale_datetime']);
		$nestedData[] = $row['sale_reference_no'];
		$nestedData[] = $row['cus_name'];
		/*
		$nestedData[] = number_format($row['sale_total'], 2, '.', ',');
		$nestedData[] = number_format($total_paid_amount, 2, '.', ',');
		$nestedData[] = number_format($row['sale_total']-$total_paid_amount, 2, '.', ',');
		*/
		$nestedData[] = $row['sale_total'];
		$nestedData[] = $return_tot_amt;
		
		$nestedData[] = $to_be_paid;
		$nestedData[] = $total_paid_amount;
		$nestedData[] = $to_be_paid-$total_paid_amount;
		
		
		/*
		if($row['payment_status']=='Paid') {
			$nestedData[]='<span class="label label-sm label-success">'.$row['payment_status'].'</span>'; 
		}else {
			$nestedData[]=$row['payment_status'];
		}
		*/
		if (empty($total_paid_amount)) {
		  $pay_st = '<span class="label label-warning">Pending</span>';
		}else{
		  if ($total_paid_amount >= $to_be_paid) {
			$pay_st = '<span class="label label-success">Paid</span>';
		  }else{
			$pay_st = '<span class="label label-info">Partial</span>';
		  }
		}
		
		$nestedData[]=$pay_st;
		
		$style = '';
		//$nestedData[] = $row['sale_id'];
		$actionTxtDisble='';
		$actionTxtEnable='';
		$actionTxtUpdate='';
		$actionTxtDelete='';
		
		$url=base_url("sales/sale_details?sale_id=$sale_id");
		$actionTxtUpdate='<a onClick="fbs_click('.$row['sale_id'].')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="clip-zoom-in-2"></i></a> &nbsp;';
		
		$actionTxtViewDetails='<a href="'.base_url().'sales/view/'.$sale_id.'" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-file-text-o"></i></a> &nbsp;';
	
	$nestedData[] = '<div class="btn-group text-left">
                            <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu pull-right">
                            <li><a href="'.base_url().'sales/view/'.$sale_id.'"><i class="fa fa-file-text-o"></i> Sale Details</a></li>
                            <li><a onClick="fbs_click('.$row['sale_id'].')" data-toggle="modal" href="#" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-print"></i> Print Sale</a></li>
							 <li><a href="'.base_url().'sales_return/sales_return_add/'.$sale_id.'"><i class="fa fa-angle-double-left"></i></i> Return Sale</a></li>
							 
                            </ul></div>';
							
							/*'<li style="' . $style . '"><a href="#" onClick ="delete_invoice(' . $sale_id . ')"><i class="fa fa-trash-o"></i></i> Delete Invoice</a></li>                    
                             <li style="' . $style . '"><a href="#" onClick ="delete_payments(' . $sale_id . ')"><i class="fa fa-trash-o"></i>    Delete Payments</a></li>';
	*/
	$data[] = $nestedData;
}

	$json_data = array(
			"draw"            => intval( $requestData['draw'] ),  
			"recordsTotal"    => intval( $totalData ),  
			"recordsFiltered" => intval( $totalFiltered ),
			"data"            => $data 
			);

	echo json_encode($json_data); 
	}
	  public function add_order()
    {
		$data['main_menu_name'] ='order';
		$data['sub_menu_name'] = 'add_order';
		
		//get suppliers list
		$data['suppliers'] = $this->Supplier_Model->get_all_supplier();
		$data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
		$data['tax_rates_list'] = $this->Tax_Rates_Model->get_all_tax_rates();
		$data['customer_list'] = $this->Customer_Model->get_all_customers();
		$data['status_list'] = $this->Common_Model->get_all_status();
		
        $this->load->view('add_order',$data);
    }
	public function order_list()
	{
		 
		$data['sales'] = $this->Sales_Model->get_all_sales();
		$data['main_menu_name'] ='order';
		$data['sub_menu_name'] = 'order';
        $this->load->view('order',$data);
	}	
	
	public function sales_delete()
    {
        $sale_id = $this->input->get('sale_id');
        $result  = $this->Sales_Model->delete_sales($sale_id);
        return $result;
    }
    public function sale_pymnts_delete()
    {
        $sale_id = $this->input->get('sale_id');
        $in_type = $this->input->get('in_type');
        $result  = $this->Sales_Model->delete_sale_payments($sale_id, $in_type);
        return $result;
    }
    public function sale_pymnts_delete_by_sp_id()
    {
        $sp_id  = $this->input->get('sp_id');
        $result = $this->Sales_Model->sale_pymnts_delete_by_sp_id($sp_id);
        return $result;
    }
    public function cheque_return_by_sp_id()
    {
        $sp_id  = $this->input->get('sp_id');
        $result = $this->Sales_Model->cheque_return_by_sp_id($sp_id);
        return $result;
    }
}