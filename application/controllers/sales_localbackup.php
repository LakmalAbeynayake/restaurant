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
	}
	
	public function index()
	{
		$data['sales'] = $this->Sales_Model->get_all_sales();

		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = $this->sub_menu_name;
        $this->load->view('sales',$data);
	}	
	
	
	
	public function view()
	{
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = '';
		
		//get sale id
		$sale_id=$this->uri->segment('3');
		
		$data['sale_item_list']= $this->Sales_Model->get_sale_item_list_by_sale_id($sale_id);
		$data['sale_details']= $this->Sales_Model->get_sale_info($sale_id);
		
		$data['total_paid_amount']=$this->Sales_Model->get_total_paid_by_sale_id($sale_id);
		
		$data['customer_details']= $this->Customer_Model->get_customer_info($data['sale_details']['customer_id']);
		$data['warehouse_details']= $this->Warehouse_Model->get_warehouse_info($data['sale_details']['warehouse_id']);
		
		//$data['total_balance_amount']=$data['sale_item_list']['sale_total'];
		
		$data['sale_payments_list']= $this->Sales_Model->get_sale_payments_by_sale_id($sale_id);
		
		$data['sale_id']=$sale_id;
        $this->load->view('sales_view',$data);
	}

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
				'sale_pymnt_crdt_card_year'=>$sale_pymnt_crdt_card_year
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
	
	
	public function payments()
	{
        $data['sale_id'] = $this->input->get('id');
		$sale_id=$data['sale_id'];
		$data['sale_details']= $this->Sales_Model->get_sale_info($sale_id);
		$data['total_paid_amount']=$this->Sales_Model->get_total_paid_by_sale_id($sale_id);
		//$data['country_list'] = $this->Common_Model->get_all_country();
        $this->load->view('models/sales_payment',$data);	
	}
	
	
	public function save_sales()
	
	{
		//echo "<pre>",print_r($_POST['row']);
		//echo "<pre>",print_r($_POST);	
		$sale_reference_no=$this->input->post('sale_reference_no');
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
		$sale_balance=$this->input->post('sale_balance');
		$sale_inv_discount_amount=$this->input->post('sale_inv_discount_amount');
		$sale_datetime_created=date('Y-m-d H:i:s');
		
		$error='';
		$disMsg='';
		$lastid='';
		$sale_id='';
		//echo "<br/>Test";
		
		if($sale_reference_no=='') { 
			//$disMsg='Reference no';
			//$error=1;
		}
		
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
				'sale_balance'=>$sale_balance,
				'sale_datetime_created'=>$sale_datetime_created,
				'sale_inv_discount_amount'=>$sale_inv_discount_amount
			);
			$_insert=$this->Sales_Model->save_sales($data,$sale_id);
			$lastid=$this->db->insert_id();
			$sale_id=$lastid;
			$disMsg='Sale successfully added';
			
			//insert sale item data
			$row=$this->input->post('row');
			$rowCount=count($row);
			//print_r($row);
			$data_item=array();
			for($i=1; $i<=$rowCount; $i++){
				if($row[$i]['product_id'][0])
				{
					
				$data_item=array(
					'sale_id'=>$sale_id,
					'product_id'=>$row[$i]['product_id'][0],
					'quantity'=>$row[$i]['qty'][0],
					'discount'=>$row[$i]['discount'][0],
					'unit_price'=>$row[$i]['unit_price'][0],
					'discount_val'=>$row[$i]['discount_val'][0], 
					'gross_total'=>$row[$i]['gross_total'][0]
				);
				$this->Sales_Model->save_sales_item($data_item);
				//echo "<br/>qty:".$row[$i]['qty'][0];
				}
			}
		
		}else {
			
			$disMsg='Please select these before adding any product:'.$disMsg;
		}
		
		//redirect sale details page
		//redirect(base_url('sales/view/164'),'refresh');
		
		
		$this->session->set_flashdata('message', 'Sale successfully added!');
		
		echo json_encode(array('sale_id'=>$lastid,'error'=>$error,'disMsg'=>$disMsg,));
		
		
		//json_encode(array('type'=>$lastid,'error'=>0,'error_msg'=>''));
		//echo json_encode(array('type'=>56));
	}
	
public function get_next_ref_no(){
	$query=$this->Sales_Model->get_next_ref_no();
	$result = $query->row();
	//print_r($result);
	$sale_reference_no=sprintf("%05d", $result->sale_id+1);
	$sale_reference_no=$sale_reference_no;
	echo json_encode(array('sale_reference_no'=>$sale_reference_no));
}

public function get_avalable_product_qty(){
	$product_id=$this->input->get('product_id');
	$warehouse_id=$this->input->get('warehouse_id');
	
	$data['total']=$this->Sales_Model->get_avalable_product_qty($product_id,$warehouse_id);
	echo json_encode(array('remmnaingQty'=>$data['total']));
}

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
	
	
	 public function suggestions($value='')
    {
		$term=$this->input->get('term');
		$data['sales'] = $this->Sales_Model->get_products_suggestions($term);
		$json = array();
		//echo "Count:".count($data['sales']);
		//print_r($data['sales']);
		$tmpcount=0;
		foreach ($data['sales'] as $row)
		{
			
			$product_name=$row['product_name'];
			$product_code=$row['product_code'];
			$product_part_no=$row['product_part_no'];
			$product_oem_part_number=$row['product_oem_part_number'];
			$product_id=$row['product_id'];
			$product_price=$row['product_price'];
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
					'product_price'=> $row['product_price'],
                    'value'=> $row['product_name']." (".$row['product_code'].")",
                    'label'=> $row['product_name']." (".$row['product_code'].")$extraName"
                    );
					array_push($json,$json_itm);
					
					//if (++$tmpcount == 10) break;
		}
		
		//print_r($json);
		
		echo json_encode($json);		
    }
	
	public function sale_details()
	{
		
		$sale_id=$this->input->get('sale_id');
		$data['sale_details']= $this->Sales_Model->get_sale_info($sale_id);
		
		//get sale item list
		$data['sale_item_list']= $this->Sales_Model->get_sale_item_list_by_sale_id($sale_id);
		
		$data['customer_details']= $this->Customer_Model->get_customer_info($data['sale_details']['customer_id']);
		$data['warehouse_details']= $this->Warehouse_Model->get_warehouse_info($data['sale_details']['warehouse_id']);
		
		$data['cr_limit_list'] = $this->Common_Model->get_all_cr_limit();
        $this->load->view('models/view_sales',$data);
	}	
	
	
	public function list_sales()
	{
	$requestData= $_REQUEST;
	
	$columns = array( 
		0 =>'sale_id', 
		1 => 'sale_id',
		2=> 'sale_id',
		3 =>'sale_id', 
		4 => 'sale_id',
		5=> 'sale_id'
	);
	
	$data = array();
	$sales = $this->Sales_Model->get_all_sales();
	$totalData = count($sales);
	$totalFiltered = $totalData;  
	
	foreach ($sales as $row){
		$nestedData=array(); 
		$sale_id=$row['sale_id'];
		$total_paid_amount=$this->Sales_Model->get_total_paid_by_sale_id($sale_id);
		$nestedData[] =display_date_time_format($row['sale_datetime']);
		$nestedData[] = $row['sale_reference_no'];
		$nestedData[] = $row['cus_name'];
		
		$nestedData[] = number_format($row['sale_total'], 2, '.', ',');
		$nestedData[] = number_format($total_paid_amount, 2, '.', ',');
		$nestedData[] = number_format($row['sale_total']-$total_paid_amount, 2, '.', ',');
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
		  if ($total_paid_amount >= $row['sale_total']) {
			$pay_st = '<span class="label label-success">Paid</span>';
		  }else{
			$pay_st = '<span class="label label-info">Partial</span>';
		  }
		}
		
		$nestedData[]=$pay_st;
		
		
		//$nestedData[] = $row['sale_id'];
		$actionTxtDisble='';
		$actionTxtEnable='';
		$actionTxtUpdate='';
		$actionTxtDelete='';
		//<button data-toggle="dropdown" class="btn btn-blue dropdown-toggle" onclick="JavaScript:fbs_click('http://localhost/inventry_pos/reports/print_sale');"><i class="fa fa-print"></i></button>
		
		//$actionTxtUpdate='<a onClick="click_sales_view_btn('.$row['sale_id'].')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="clip-zoom-in-2"></i></a> &nbsp;';
		
		$url=base_url("sales/sale_details?sale_id=$sale_id");
		$actionTxtUpdate='<a onClick="fbs_click('.$row['sale_id'].')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="clip-zoom-in-2"></i></a> &nbsp;';
		
		$actionTxtViewDetails='<a href="'.base_url().'sales/view/'.$sale_id.'" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-file-text-o"></i></a> &nbsp;';
		//$actionTxtViewDetails='';
		
	
	$nestedData[]=$actionTxtUpdate.$actionTxtViewDetails;
	$data[] = $nestedData;
}

	$json_data = array(
			//"draw"            => intval( $requestData['draw'] ),  
			"recordsTotal"    => intval( $totalData ),  
			"recordsFiltered" => intval( $totalFiltered ),
			"data"            => $data 
			);

	echo json_encode($json_data); 
	}
	

}