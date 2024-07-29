<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_Return extends CI_Controller {

    var $main_menu_name = "sales";
	var $sub_menu_name = "sales_return";

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Sales_Model');
		$this->load->model('Sales_Return_Model');
		$this->load->model('Supplier_Model');
		$this->load->model('Warehouse_Model');
		$this->load->model('Common_Model');
		$this->load->model('Tax_Rates_Model');
		$this->load->model('Customer_Model');
	}
	
	//Sales reterun list page
	public function index()
	{
		$data['sales'] = $this->Sales_Model->get_all_sales();
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = $this->sub_menu_name;
        $this->load->view('sales_return',$data);
	}
	
	//Sales reterun get sold qty
	public function get_avalable_product_qty_for_return()
    {	
		$product_id=$this->input->get('product_id');
		$warehouse_id=$this->input->get('warehouse_id');
		$sale_id=$this->input->get('sale_id');
		$qty=$this->input->get('qty');
		$saleqty=$this->Sales_Return_Model->get_avalable_product_qty_for_return($product_id,$warehouse_id,$sale_id);
		$salereturnqty=$this->Sales_Return_Model->get_sales_return_product_qty($product_id,$warehouse_id,$sale_id);
		$totalRemaningQty=$saleqty-$salereturnqty;
		//echo "qty:$qty , remmnaingQty:$saleqty , salereturnqty:$salereturnqty";
		if($qty<=$totalRemaningQty){
			$remmnaingQty=$saleqty;
		}else {
			$remmnaingQty=0;
		}
		
		echo json_encode(array('remmnaingQty'=>$remmnaingQty));
	}
	
	//Add sales return form
    public function sales_return_add()
    {
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = '';
		
		//get sale id
		$sale_id=$this->uri->segment('3');
		$data['sale_item_list']= $this->Sales_Model->get_sale_item_list_by_sale_id($sale_id);
		$data['sale_details']= $this->Sales_Model->get_sale_info($sale_id);
		$data['sale_id']=$sale_id;
		//get suppliers list
		$data['suppliers'] = $this->Supplier_Model->get_all_supplier();
		$data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
		$data['tax_rates_list'] = $this->Tax_Rates_Model->get_all_tax_rates();
		$data['customer_list'] = $this->Customer_Model->get_all_customers();
		$data['status_list'] = $this->Common_Model->get_all_status();
		
        $this->load->view('sales_return_add',$data);
    }
	
	
	//Save sales return
	//Insert data to payment table with type 'sales_return'
	public function save_sales_return()
	
	{
		$rowCount=$this->input->post('rowCount');
		$sl_rtn_datetime_1=$this->input->post('sl_rtn_datetime');
		$sl_rtn_datetime=date('Y-m-d H:i:s', strtotime($sl_rtn_datetime_1));
		$user_id=$this->session->userdata('ss_user_id');
		
		$error='';
		$disMsg='';
		$lastid='';
		$sl_rtn_id='';
		
		/* payment validation start */
		$sale_pymnt_amount=$this->input->post('sale_pymnt_amount');
		$sale_id=$this->input->post('sale_id');
		$sale_pymnt_ref_no=$this->input->post('sale_pymnt_ref_no');
		$sale_pymnt_paying_by=$this->input->post('sale_pymnt_paying_by');
		$sale_pymnt_date_time=$sl_rtn_datetime;
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
		
		if($sale_pymnt_amount){
		$tmp=number_format($sale_pymnt_amount, 2, '.','');
		}else{
			$tmp=0;
		}
		//echo $tmp;
        if ($this->form_validation->run() == FALSE)
        {
           $st = array('status' =>0,'validation' => validation_errors());
		   $disMsg=validation_errors();
		   $error=true;
        }else if($tmp!=$this->input->post('sl_rtn_total')){
			$error=true;
			$disMsg='Invalid Amount';
		}
		/* end payment validation start */
		
		
		
		
		if(!$error){
			$data=array(
				'sl_rtn_reference_no'=>$this->input->post('sl_rtn_reference_no'),
				'sale_id'=>$this->input->post('sale_id'),
				'customer_id'=>$this->input->post('customer_id'),
				'warehouse_id'=>$this->input->post('warehouse_id'),
				'sl_rtn_datetime'=>$sl_rtn_datetime,
				'sl_rtn_inv_discount'=>$this->input->post('sl_rtn_inv_discount'),
				'sl_rtn_total'=>$this->input->post('sl_rtn_total'),
				'sl_rtn_datetime_created'=>date('Y-m-d H:i:s'),
				'sl_rtn_inv_discount_amount'=>$this->input->post('sl_rtn_inv_discount_amount'),
				'sl_rtn_note'=>$this->input->post('sl_rtn_note'),
				'user_id'=>$user_id
			);
			$_insert=$this->Sales_Return_Model->save_sales_return($data,$sl_rtn_id);
			$lastid=$this->db->insert_id();
			$sl_rtn_id=$lastid;
			$disMsg='Sale return successfully added';
			
			//insert sale item data
			$row=$this->input->post('row');
			$rowCount=$this->input->post('rowCount');
			//print_r($row);
			$data_item=array();
			for($i=1; $i<=$rowCount; $i++){
				if(isset($row[$i]['product_id'][0]))
				{
					
				$data_item=array(
					'sl_rtn_id'=>$sl_rtn_id,
					'product_id'=>$row[$i]['product_id'][0],
					'quantity'=>$row[$i]['qty'][0],
					'discount'=>$row[$i]['discount'][0],
					'unit_price'=>$row[$i]['unit_price'][0],
					'discount_val'=>floatval($row[$i]['discount_val'][0]),
					'gross_total'=>$row[$i]['gross_total'][0]
				);
				$slrtnitmid=$this->Sales_Return_Model->save_sales_return_item($data_item);
				$slrtnitmid=$this->db->insert_id();
				//add record for f4 table
				$type='sl_rtn';
				$ref_id=$slrtnitmid;
				$product=$row[$i]['product_id'][0];
				$quantity=$row[$i]['qty'][0];
				$unit_cost=$row[$i]['unit_price'][0];
				$this->Common_Model->add_fi_table($type,$ref_id,$product,$quantity,$unit_cost);
				}
			}
			//add sales return payments
				$data=array(
				'sale_pymnt_amount'=>$sale_pymnt_amount,	
				'sale_pymnt_ref_no'=>$sale_pymnt_ref_no,
				'sale_pymnt_paying_by'=>$sale_pymnt_paying_by,
				'sale_pymnt_date_time'=>$sale_pymnt_date_time_send,
				'sale_pymnt_note'=>$sale_pymnt_note,
				'user_id'=>$user_id,
				'sale_id'=>$sl_rtn_id,
				'sale_pymnt_added_date_time'=>date('Y-m-d H:i:s'),
				'sale_pymnt_cheque_no'=>$sale_pymnt_cheque_no,
				'sale_pymnt_crdt_card_no'=>$sale_pymnt_crdt_card_no,
				'sale_pymnt_crdt_card_holder_name'=>$sale_pymnt_crdt_card_holder_name,
				'sale_pymnt_crdt_card_type'=>$sale_pymnt_crdt_card_type,
				'sale_pymnt_crdt_card_month'=>$sale_pymnt_crdt_card_month,
				'sale_pymnt_crdt_card_year'=>$sale_pymnt_crdt_card_year,
				'sale_payment_type' => 'sales_return'
			);
			
               if ($this->Sales_Model->save_sale_payments($data,$sale_pymnt_id)) {
                   
               } else {
                    $error=true;
               }
				//end add return payments
		
		}else {
			$error=true;
		}
		
						
		echo json_encode(array('sale_id'=>$lastid,'error'=>$error,'disMsg'=>$disMsg,));
		
	}	

	//Sales return details page
	public function sales_return_details()
	{
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = '';
		
		//get sale id
		$sl_rtn_id=$this->uri->segment('3');
		$data['sale_rtn_details']= $this->Sales_Return_Model->get_sale_return_info($sl_rtn_id);
		
		if($data['sale_rtn_details']){
		
		$data['sale_rtn_item_list']= $this->Sales_Return_Model->get_sale_return_item_list($sl_rtn_id);
		$data['total_paid_amount']=$this->Sales_Model->get_total_paid_by_sale_id($sl_rtn_id);
		$data['customer_details']= $this->Customer_Model->get_customer_info($data['sale_rtn_details']['customer_id']);
		$data['warehouse_details']= $this->Warehouse_Model->get_warehouse_info($data['sale_rtn_details']['warehouse_id']);
		$data['sale_payments_list']= $this->Sales_Model->get_sale_payments_by_sale_id($sl_rtn_id);
		$data['sl_rtn_id']=$sl_rtn_id;
        
		$this->load->view('sales_return_details',$data);
		}
		else show_404();
		
	}	
	
	public function invoice_print()
	{
		$sl_rtn_id=$this->uri->segment('3');
		$data['sale_rtn_details']= $this->Sales_Return_Model->get_sale_return_info($sl_rtn_id);
		//get sale item list
		$data['sale_rtn_item_list']= $this->Sales_Return_Model->get_sale_return_item_list($sl_rtn_id);
		
		$data['customer_details']= $this->Customer_Model->get_customer_info($data['sale_rtn_details']['customer_id']);
		$data['warehouse_details']=  $this->Warehouse_Model->get_warehouse_info($data['sale_rtn_details']['warehouse_id']);
		//$data['sale_payments_list']= $this->Sales_Model->get_sale_payments_by_sale_id($sale_id);
		
		
		$data['cr_limit_list'] = $this->Common_Model->get_all_cr_limit();
        $this->load->view('models/print_sales_return_invoice',$data);
	}
	
	//Sales return details list 
	public function list_sales_return()
	{
		$requestData= $_REQUEST;
		$data = array();
		$sales = $this->Sales_Return_Model->get_all_sales_return();
		$totalData = count($sales);
		$totalFiltered = $totalData;  
		
		foreach ($sales as $row){
			$nestedData=array(); 
			$sl_rtn_id=$row['sl_rtn_id'];
			$sale_id=$row['sale_id'];
			$total_paid_amount=$this->Sales_Model->get_total_paid_by_sale_id($sale_id);
			$nestedData[] =display_date_time_format($row['sl_rtn_datetime']);
			$nestedData[] = $row['sl_rtn_reference_no'];
			$nestedData[] = $row['sale_reference_no'];
			$nestedData[] = $row['cus_name'];
			$nestedData[] = number_format($row['sls_rtn_total_paid'], 2, '.', ',');
			
			$nestedData[] = '<div class="btn-group text-left">
								<button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
								<ul role="menu" class="dropdown-menu pull-right">
								<li><a href="'.base_url().'sales/sales_return_details/'.$sl_rtn_id.'"><i class="fa fa-file-text-o"></i> Return Sale Details</a></li>
								</ul></div>';
	
			$data[] = $nestedData;
	}
	
		$json_data = array(
				"recordsTotal"    => intval( $totalData ),  
				"recordsFiltered" => intval( $totalFiltered ),
				"data"            => $data 
				);
	
		echo json_encode($json_data); 
	}
}