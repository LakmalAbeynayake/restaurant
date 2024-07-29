<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_Damage extends CI_Controller {

    var $main_menu_name = "product_damage";
	var $sub_menu_name = "product_damage";

	public function __construct()
	{
		parent::__construct();

		
		$this->load->model('Product_Damage_Model');
		$this->load->model('Supplier_Model');
		$this->load->model('Warehouse_Model');
		$this->load->model('Common_Model');
		$this->load->model('Tax_Rates_Model');
		$this->load->model('Customer_Model');
	}
	
	//Product_ Damage list page load
	public function index()
	{
		//$data['product_damage'] = $this->Product_Damage_Model->get_all_product_damage();
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = $this->sub_menu_name;
        $this->load->view('product_damage',$data);
	}	
	
	//Product  Damage details view
	public function view()
	{
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = '';
		
		//get sale id
		$pdmg_id=$this->uri->segment('3');
		$data['pdmg_item_list']= $this->Product_Damage_Model->get_pdmg_item_list_by_pdmg_id($pdmg_id);
		$data['pdmg_details']= $this->Product_Damage_Model->get_pdmg_info($pdmg_id);
		
	
		$data['customer_details']= $this->Customer_Model->get_customer_info($data['pdmg_details']['customer_id']);
		$data['warehouse_details']= $this->Warehouse_Model->get_warehouse_info($data['pdmg_details']['warehouse_id']);		
		
		$data['pdmg_id']=$pdmg_id;
        $this->load->view('product_damage_view',$data);
	}

	//Product  Damage add page
	public function add_pdmg_payments()
	{
		$pdmg_pymnt_amount=$this->input->post('pdmg_pymnt_amount');
		$pdmg_id=$this->input->post('pdmg_id');
		$pdmg_pymnt_ref_no=$this->input->post('pdmg_pymnt_ref_no');
		$pdmg_pymnt_paying_by=$this->input->post('pdmg_pymnt_paying_by');
		$pdmg_pymnt_date_time=$this->input->post('pdmg_pymnt_date_time');
		$pdmg_pymnt_date_time_send=date('Y-m-d H:i:s', strtotime($pdmg_pymnt_date_time));
		$pdmg_pymnt_cheque_no=$this->input->post('pdmg_pymnt_cheque_no');
		$pdmg_pymnt_crdt_card_no=$this->input->post('pdmg_pymnt_crdt_card_no');
		$pdmg_pymnt_crdt_card_holder_name=$this->input->post('pdmg_pymnt_crdt_card_holder_name');
		$pdmg_pymnt_crdt_card_month=$this->input->post('pdmg_pymnt_crdt_card_month');
		$pdmg_pymnt_crdt_card_year=$this->input->post('pdmg_pymnt_crdt_card_year');
		$pdmg_pymnt_crdt_card_type=$this->input->post('pdmg_pymnt_crdt_card_type');
		$pdmg_type = $this->input->post('pdmg_type');

		$pdmg_pymnt_note=$this->input->post('pdmg_pymnt_note');
		$user_id=$this->session->userdata('ss_user_id');
		$pdmg_pymnt_added_date_time=date("Y-m-d H:i:s");
		$pdmg_pymnt_id='';
		
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('pdmg_pymnt_amount', 'Amount', 'required');
		if($pdmg_pymnt_paying_by=='Credit Card'){
			$this->form_validation->set_rules('pdmg_pymnt_crdt_card_type', 'Card Type', 'required');
			$this->form_validation->set_rules('pdmg_pymnt_crdt_card_no', 'Credit Card No', 'required');
			$this->form_validation->set_rules('pdmg_pymnt_crdt_card_holder_name', 'Holder Name', 'required');
			$this->form_validation->set_rules('pdmg_pymnt_crdt_card_month', 'Month', 'required');
			$this->form_validation->set_rules('pdmg_pymnt_crdt_card_year', 'Year', 'required');
		}
		if($pdmg_pymnt_paying_by=='Cheque'){
			$this->form_validation->set_rules('pdmg_pymnt_cheque_no', 'Cheque No', 'required');
		}
		$this->form_validation->set_rules('pdmg_id', 'System Error', 'required');


        if ($this->form_validation->run() == FALSE)
        {
           $st = array('status' =>0,'validation' => validation_errors());
           echo json_encode($st);
        }
        else
        {
			$data=array(
				'pdmg_pymnt_amount'=>$pdmg_pymnt_amount,	
				'pdmg_pymnt_ref_no'=>$pdmg_pymnt_ref_no,
				'pdmg_pymnt_paying_by'=>$pdmg_pymnt_paying_by,
				'pdmg_pymnt_date_time'=>$pdmg_pymnt_date_time_send,
				'pdmg_pymnt_note'=>$pdmg_pymnt_note,
				'user_id'=>$user_id,
				'pdmg_id'=>$pdmg_id,
				'pdmg_pymnt_added_date_time'=>$pdmg_pymnt_added_date_time,
				'pdmg_pymnt_cheque_no'=>$pdmg_pymnt_cheque_no,
				'pdmg_pymnt_crdt_card_no'=>$pdmg_pymnt_crdt_card_no,
				'pdmg_pymnt_crdt_card_holder_name'=>$pdmg_pymnt_crdt_card_holder_name,
				'pdmg_pymnt_crdt_card_type'=>$pdmg_pymnt_crdt_card_type,
				'pdmg_pymnt_crdt_card_month'=>$pdmg_pymnt_crdt_card_month,
				'pdmg_pymnt_crdt_card_year'=>$pdmg_pymnt_crdt_card_year,
				'pdmg_payment_type' => $pdmg_type
			);
			
               if ($this->Product_Damage_Model->save_pdmg_payments($data,$pdmg_pymnt_id)) {
                    $st = array('status' =>1,'validation' =>'Done!');
                    echo json_encode($st);
               } else {
                    $st = array('status' =>0,'validation' =>'error occurred please contact your system administrator');
                    echo json_encode($st);
               }
		}
	}	
	
	//Product  Damage payment page 
	public function payments()
	{
        $data['pdmg_id'] = $this->input->get('id');
        $data['pdmg_type'] = $this->input->get('pdmg_type');
        $this->load->view('models/product_damage_payment',$data);	
	}
	
	//Product  Damage save 
	//Product  Damage item save
	//Add product_damage items to 54 table
	public function save_product_damage()
	{
	    $this->load->model('stock_model');
		$uuid=$this->input->post('uuid');
		$pdmg_reference_no=$this->input->post('pdmg_reference_no');
		$warehouse_id=$this->input->post('warehouse_id');
		$rowCount=$this->input->post('rowCount');
		
		$pdmg_datetime_1=$this->input->post('pdmg_datetime');
		$pdmg_datetime=date('Y-m-d H:i:s', strtotime($pdmg_datetime_1));
		$pdmg_inv_discount=$this->input->post('pdmg_inv_discount');		
		$pdmg_total=$this->input->post('pdmg_total');
		$dmg_type_id=$this->input->post('dmg_type_id');
		
		$pdmg_datetime_created= date('Y-m-d H:i:s' , strtotime($pdmg_datetime_1));
		
		$movements_list = array();
		
		
		$error='';
		$disMsg='';
		$lastid='';
		$pdmg_id='';
		
		if(!$error){

		    $this->db->trans_start();

			$data=array(
				'pdmg_reference_no'=>$pdmg_reference_no,
				'warehouse_id'=>$warehouse_id,
				'pdmg_datetime'=>$pdmg_datetime,
				'pdmg_total'=>$pdmg_total,
				'pdmg_datetime_created'=>$pdmg_datetime_created,
				'dmg_type_id'=>$dmg_type_id
			);
			$_insert=$this->Product_Damage_Model->save_product_damage($data,$pdmg_id);
			$lastid=$this->db->insert_id();
			$pdmg_id=$lastid;
			$disMsg='Damadge successfully added';
			
			//insert sale item data
			$row=$this->input->post('row');
			$rowCount=$this->input->post('rowCount');
			$data_item=array();
			for($i=1; $i<=$rowCount; $i++){
				if(isset($row[$i]['product_id'][0]))
				{
				    $data_item=array(
				        'pdmg_id'=>$pdmg_id,
				        'product_id'=>$row[$i]['product_id'][0],
				        'pdmgitm_quantity'=>$row[$i]['qty'][0],
				        'pdmgitm_unit_cost'=>$row[$i]['unit_price'][0],
				    );
				    $this->Product_Damage_Model->save_product_damage_item($data_item);
				
    				//add reford for f4 table
    				$type='prodcut_damage';
    				$ref_id=$pdmg_id;
    				$product=$row[$i]['product_id'][0];
    				$pdmg_itm_quantity=$row[$i]['qty'][0];
    				$unit_cost=$row[$i]['unit_price'][0];
    				$this->Common_Model->add_fi_table($type,$ref_id,$product,$pdmg_itm_quantity,$unit_cost);

    				$data = array(
                        'location_id' => $warehouse_id,
                        'transaction_id' => $uuid,
                        'product_id' => $row[$i]['product_id'][0],
                        'unit_value' => floatval($unit_cost),
                        'quantity' => $row[$i]['qty'][0],
                        'movement_type' => 'out',
                        'movement_date' => $pdmg_datetime_created,
                        'origin' => $dmg_type_id == 1 ? 'damage' : 'staff_meal',
                        'origin_id' => $pdmg_id
                    );
                    $movements_list[] = $data;
				}
			}

            $track_data = array( 'trans_id' => $uuid,'location_id' => $warehouse_id,'date_time' => $pdmg_datetime_created, 'added_by' => $this->session->userdata('ss_user_id'));
            $this->stock_model->stock_m_tracker($track_data);
            $this->stock_model->bulkInsertMovements($movements_list);
            
            $this->db->trans_complete();
        
		/*print_r($movements_list);*/
		}else {
			$disMsg='Please select these before adding any product:'.$disMsg;
		}	
		
		$this->session->set_flashdata('message', 'Product damage details successfully added!');
		
		echo json_encode(array('pdmg_id'=>$lastid,'error'=>$error,'disMsg'=>$disMsg,));
	}

	//Product  Damage reference no jenarate	
	public function get_next_ref_no(){
		$query=$this->Product_Damage_Model->get_next_ref_no();
		$result = $query->row();
		//print_r($result);
		$pdmg_reference_no=sprintf("%05d", $result->pdmg_id+1);
		$pdmg_reference_no=$pdmg_reference_no;
		echo json_encode(array('pdmg_reference_no'=>$pdmg_reference_no));
	}
	
	//Product  Damage ger avalable product qty
	public function get_avalable_product_qty(){
		$product_id=$this->input->get('product_id');
		$warehouse_id=$this->input->get('warehouse_id');
		
		$data['total']=$this->Product_Damage_Model->get_avalable_product_qty($product_id,$warehouse_id);
		echo json_encode(array('remmnaingQty'=>$data['total']));
	}

	//Product  Damage add form
    public function product_damage_add()
    {
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = 'product_damage_add';
		
		//get suppliers list
		$data['suppliers'] = $this->Supplier_Model->get_all_supplier();
		$data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
		$data['tax_rates_list'] = $this->Tax_Rates_Model->get_all_tax_rates();
		$data['customer_list'] = $this->Customer_Model->get_all_customers();
		$data['status_list'] = $this->Common_Model->get_all_status();
		
        $this->load->view('product_damage_add',$data);
    }
	
	//Product  Damage product items get
	 public function suggestions($value='')
    {
		$term=$this->input->get('term');
		$data['product_damage'] = $this->Product_Damage_Model->get_products_suggestions($term);
		$json = array();
		//echo "Count:".count($data['product_damage']);
		//print_r($data['product_damage']);
		foreach ($data['product_damage'] as $row)
		{
			$product_name=$row['product_name'];
			$product_code=$row['product_code'];
			
			$product_id=$row['product_id'];
			$product_price=$row['product_price'];
			$sendParameters="'$product_id','$product_name','$product_code','$product_price'";
			$sendParameters="$product_id,$product_name,$product_code,$product_price";
			$extraName='';
			$extraName.=", Selling Price: ".number_format($product_price, 2, '.', ',');
			
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
		}		
		echo json_encode($json);		
    }
	
	//Sale details page
	public function product_damage_details()
	{
		
		$pdmg_id=$this->input->get('pdmg_id');
		$data['pdmg_details']= $this->Product_Damage_Model->get_product_damage_info($pdmg_id);
		
		$data['warehouse_details']= $this->Warehouse_Model->get_warehouse_info($data['pdmg_details']['warehouse_id']);
		
		
		//get sale item list
		$data['pdmg_item_list']= $this->Product_Damage_Model->get_product_damage_item_list_by_product_damage_id($pdmg_id);
		
		
		
		$data['cr_limit_list'] = $this->Common_Model->get_all_cr_limit();
        $this->load->view('models/product_damage_print',$data);
	}	
	
	//Product  Damage list
	public function list_product_damage()
	{
	$requestData= $_REQUEST;
	
	$columns = array( 
		0 =>'pdmg_id', 
		1 => 'pdmg_id',
		2=> 'pdmg_id',
		3 =>'pdmg_id', 
		4 => 'pdmg_id',
		5=> 'pdmg_id'
	);
	
	$data = array();
	$product_damage = $this->Product_Damage_Model->get_all_product_damage();
	$totalData = count($product_damage);
	$totalFiltered = $totalData;  
	
	foreach ($product_damage as $row){
		$nestedData=array(); 
		$pdmg_id=$row['pdmg_id'];
		$total_paid_amount='';
		$nestedData[] =display_date_time_format($row['pdmg_datetime']);
		$nestedData[] = $row['pdmg_reference_no'];
		
		$nestedData[] = $row['name'];		
		$nestedData[] =number_format($row['pdmg_total'], 2, '.', ',');		
		$url=base_url("product_damage/pdmg_details?pdmg_id=$pdmg_id");
		$actionTxtUpdate='<a onClick="fbs_click('.$row['pdmg_id'].')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="clip-zoom-in-2"></i></a> &nbsp;';
		
		$actionTxtViewDetails='<a href="'.base_url().'product_damage/view/'.$pdmg_id.'" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-file-text-o"></i></a> &nbsp;';
	
	$nestedData[] = '<div class="btn-group text-left">
                            <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu pull-right">
                            
                            <li><a onClick="fbs_click('.$row['pdmg_id'].')" data-toggle="modal" href="#" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-print"></i> Print Product Damage</a></li>
							
                            </ul></div>';
							
							/*<li><a href="'.base_url().'product_damage/view/'.$pdmg_id.'"><i class="fa fa-file-text-o"></i> Transfer Details</a></li>*/
	
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