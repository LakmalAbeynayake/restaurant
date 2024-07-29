<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Service extends CI_Controller {



    var $main_menu_name = "service";

	var $sub_menu_name = "service";



	public function __construct()

	{

		parent::__construct();



		

		$this->load->model('Service_Model');

		$this->load->model('Supplier_Model');

		$this->load->model('Warehouse_Model');

		$this->load->model('Common_Model');

		$this->load->model('Tax_Rates_Model');

		$this->load->model('Customer_Model');

		$this->load->model('Sequerty_Model');

		$this->load->model('Product_Models');

		//$this->load->model('Requisition_Model');

		$this->load->model('User_Model');

		

	}

	

	//Requisition list page load

	public function index()

	{

		$data['service'] = $this->Service_Model->get_all_service();

		$data['main_menu_name'] = $this->main_menu_name;

		$data['sub_menu_name'] = $this->sub_menu_name;

        $this->load->view('service',$data);

	}	

	

	public function update_service_status()

	{

        $service_id = $this->input->post('service_id');

		

		//echo "ser id:$sevice_id";

		$disMsg='';

		$prepared_user=0;

		$reserved_user=0;

		$approved_user=0;

		if($this->input->post('prepared_status')=='Prepared')  $prepared_user=$this->session->userdata('ss_user_id');

		if($this->input->post('reserved_status')=='Reserved')  $reserved_user=$this->session->userdata('ss_user_id');

		if($this->input->post('approved_status')=='Approved')  $approved_user=$this->session->userdata('ss_user_id');

		

				$data_edit=array(

				'prepared_status'=>$this->input->post('prepared_status'),

			    'reserved_status'=>$this->input->post('reserved_status'),

				'approved_status'=>$this->input->post('approved_status'),

				'prepared_user'=>$prepared_user,

				'reserved_user'=>$reserved_user,

				'approved_user'=>$approved_user,

			);

			$_insert=$this->Service_Model->save_service($data_edit,$service_id);

			

			

			//echo $this->db->last_query();

        

        echo json_encode(array('req_id'=>$service_id,'error'=>'','disMsg'=>$disMsg,));

	}

		

	public function service_add_row()

	{

		$product_id=$this->input->post('id');

		

		$rowCount=$this->input->post('rowCount');

		$warehouse_id=$this->input->post('warehouse_id');

		$service_datetime=$this->input->post('service_datetime');

		$service_return_date=$this->input->post('service_return_date');

		$service_customer_id=$this->input->post('service_customer_id');

		$product_charge_type=$this->input->post('product_charge_type');

		$service_diposit=$this->input->post('service_diposit');

		$service_responsible_person=$this->input->post('service_responsible_person');

		

		

		$pro_dlts=$this->Product_Models->get_product_by_id($product_id);

		

		

		//print_r($pro_dlts);

		$row_details='';

		$msg='';

		$error=false;

		

		$selbox='';

		//test 

		//$rowCount_e=1;

		$tmp_th_e=$rowCount;

		$pymnt_cheque_date='';

		$required_date=date('m/d/Y');

		$serviceitm_qty=1;

		

		//get pr item qty by id

		//$serviceitm_qty=

		

		$sub_total_item=0.00;

		

		

		//validate

		$this->load->library('form_validation');

		//$this->form_validation->set_rules('bank_id_'.$tmp_th_e, 'Bank', 'required');

		//if ($this->form_validation->run() != FALSE)

		

		/*if(!$warehouse_id){

			$error=true;

			$msg.="Project, ";

		}*/

		if(!$service_datetime){

			$error=true;

			$msg.="Service Date, ";

		}

		/*if(!$service_return_date){

			$error=true;

			$msg.="Return Date, ";

		}*/

		/*if(!$service_customer_id){

			$error=true;

			$msg.="Service Place, ";

		}*/

		/*if(!$service_responsible_person){

			$error=true;

			$msg.="Responsible Person , ";

		}*/

		

		//$error=false;

		if (!$error)

        {

             $itm_charge_type=$product_charge_type;

			 $product_service_charge=0.00;

			

			 

			 

			$row_details="

			<tr id=\"row_e_$tmp_th_e\">

			<td class=\"text-left\">

			$pro_dlts->product_name

			<input type=\"hidden\" style=\"width:100%; text-align:left\" name=\"row_e[$tmp_th_e][product_name][]\" id=\"product_name_$tmp_th_e\" value=\"$pro_dlts->product_name\" class=\"pymnt_amount\">

			<input type=\"hidden\" style=\"width:100%; text-align:left\" name=\"row_e[$tmp_th_e][product_id][]\" id=\"product_id_$tmp_th_e\" value=\"$pro_dlts->product_id\" class=\"product_id\">

			</td>

			<td>

			<input type=\"hidden\" style=\"width:100%; text-align:right\" name=\"row_e[$tmp_th_e][product_unit][]\" id=\"product_unit_$tmp_th_e\" value=\"$pro_dlts->product_unit\" class=\"product_unit\">

			</td>

			

			<td><input type=\"text\" style=\"width:100%; text-align:right\" name=\"row_e[$tmp_th_e][serviceitm_qty][]\" id=\"serviceitm_qty_$tmp_th_e\" value=\"$serviceitm_qty\" class=\"serviceitm_qty\" onchange=\"changeQtyByProductID(this.value,$tmp_th_e);\" onclick=\"this.select(); setTmpVal(this.value);\"></td>

			

			<td><input type=\"text\" style=\"width:100%; text-align:right\" name=\"row_e[$tmp_th_e][product_service_charge][]\" id=\"product_cost_$tmp_th_e\" value=\"$product_service_charge\" class=\"product_service_charge\"></td>

			

			<td><input type=\"text\" style=\"width:100%; text-align:right\" name=\"row_e[$tmp_th_e][serviceitm_dis][]\" id=\"serviceitm_dis_$tmp_th_e\" value=\"0\" class=\"serviceitm_dis\" onchange=\"changeDiscountByProductID(this.value,1);\" onclick=\"this.select(); setTmpVal(this.value);\">

			<input type=\"hidden\" style=\"width:100%; text-align:right\" name=\"row_e[$tmp_th_e][serviceitm_dis_val][]\" id=\"serviceitm_dis_val_$tmp_th_e\" value=\"0\" class=\"serviceitm_dis_val\">

			</td>

			<td><input type=\"text\" style=\"width:100%; text-align:right\" name=\"row_e[$tmp_th_e][sub_total_item][]\" id=\"sub_total_item_$tmp_th_e\" value=\"$sub_total_item\" class=\"\"></td>

			<td><a onclick=\"deleteServiceItem(1)\"><i style=\"cursor:pointer;\" title=\"Remove\" id=\"1446800197032\" class=\"fa fa-times tip podel\"></i></a></td>

			</tr>

			";

			

		 $e = array('status' =>1,'row_details' =>$row_details);

		 echo json_encode($e);

		

		}else {

			$e = array('status' =>0,'row_details' =>'','msg'=>$msg);

		 	echo json_encode($e);

		}

		

	}

	

	public function service_print()

	{	

		$service_id=$this->uri->segment('3');

		$data['service_details']=$this->Service_Model->get_service_details_by_id($service_id);

		$service_details=$data['service_details'];

		

		//get sale item list

		$data['service_item_list']=$this->Service_Model->get_service_items_by_id($service_id);

		

		

		$data['customer_details']= $this->Customer_Model->get_customer_info($service_details->service_customer_id);

		//$data['warehouse_details']= $this->Warehouse_Model->get_warehouse_info($data['service_details']['warehouse_id']);

		

		//print_r($data['service_details']);

        $this->load->view('models/service_print',$data);

	}

		

		

	

	//Requisition details view

	public function view()

	{

		$data['main_menu_name'] = $this->main_menu_name;

		$data['sub_menu_name'] = '';

		

		//get sale id

		$service_id=$this->uri->segment('3');

		$data['service_item_list']= $this->Service_Model->get_service_item_list_by_service_id($service_id);

		$data['service_details']= $this->Service_Model->get_service_info($service_id);

		

	

		$data['customer_details']= $this->Customer_Model->get_customer_info($data['service_details']['customer_id']);

		$data['warehouse_details']= $this->Warehouse_Model->get_warehouse_info($data['service_details']['warehouse_id']);		

		

		$data['service_id']=$service_id;

        $this->load->view('service_view',$data);

	}



	//Requisition add page

	public function add_service_payments()

	{

		$service_pymnt_amount=$this->input->post('service_pymnt_amount');

		$service_id=$this->input->post('service_id');

		$service_pymnt_ref_no=$this->input->post('service_pymnt_ref_no');

		$service_pymnt_paying_by=$this->input->post('service_pymnt_paying_by');

		$service_pymnt_date_time=$this->input->post('service_pymnt_date_time');

		$service_pymnt_date_time_send=date('Y-m-d H:i:s', strtotime($service_pymnt_date_time));

		$service_pymnt_cheque_no=$this->input->post('service_pymnt_cheque_no');

		$service_pymnt_crdt_card_no=$this->input->post('service_pymnt_crdt_card_no');

		$service_pymnt_crdt_card_holder_name=$this->input->post('service_pymnt_crdt_card_holder_name');

		$service_pymnt_crdt_card_month=$this->input->post('service_pymnt_crdt_card_month');

		$service_pymnt_crdt_card_year=$this->input->post('service_pymnt_crdt_card_year');

		$service_pymnt_crdt_card_type=$this->input->post('service_pymnt_crdt_card_type');

		$service_type = $this->input->post('service_type');



		$service_pymnt_note=$this->input->post('service_pymnt_note');

		$user_id=$this->session->userdata('ss_user_id');

		$service_pymnt_added_date_time=date("Y-m-d H:i:s");

		$service_pymnt_id='';

		

        $this->load->library('form_validation'); //form validation lib

        $this->form_validation->set_rules('service_pymnt_amount', 'Amount', 'required');

		if($service_pymnt_paying_by=='Credit Card'){

			$this->form_validation->set_rules('service_pymnt_crdt_card_type', 'Card Type', 'required');

			$this->form_validation->set_rules('service_pymnt_crdt_card_no', 'Credit Card No', 'required');

			$this->form_validation->set_rules('service_pymnt_crdt_card_holder_name', 'Holder Name', 'required');

			$this->form_validation->set_rules('service_pymnt_crdt_card_month', 'Month', 'required');

			$this->form_validation->set_rules('service_pymnt_crdt_card_year', 'Year', 'required');

		}

		if($service_pymnt_paying_by=='Cheque'){

			$this->form_validation->set_rules('service_pymnt_cheque_no', 'Cheque No', 'required');

		}

		$this->form_validation->set_rules('service_id', 'System Error', 'required');





        if ($this->form_validation->run() == FALSE)

        {

           $st = array('status' =>0,'validation' => validation_errors());

           echo json_encode($st);

        }

        else

        {

			$data=array(

				'service_pymnt_amount'=>$service_pymnt_amount,	

				'service_pymnt_ref_no'=>$service_pymnt_ref_no,

				'service_pymnt_paying_by'=>$service_pymnt_paying_by,

				'service_pymnt_date_time'=>$service_pymnt_date_time_send,

				'service_pymnt_note'=>$service_pymnt_note,

				'user_id'=>$user_id,

				'service_id'=>$service_id,

				'service_pymnt_added_date_time'=>$service_pymnt_added_date_time,

				'service_pymnt_cheque_no'=>$service_pymnt_cheque_no,

				'service_pymnt_crdt_card_no'=>$service_pymnt_crdt_card_no,

				'service_pymnt_crdt_card_holder_name'=>$service_pymnt_crdt_card_holder_name,

				'service_pymnt_crdt_card_type'=>$service_pymnt_crdt_card_type,

				'service_pymnt_crdt_card_month'=>$service_pymnt_crdt_card_month,

				'service_pymnt_crdt_card_year'=>$service_pymnt_crdt_card_year,

				'service_payment_type' => $service_type

			);

			

               if ($this->Service_Model->save_service_payments($data,$service_pymnt_id)) {

                    $st = array('status' =>1,'validation' =>'Done!');

                    echo json_encode($st);

               } else {

                    $st = array('status' =>0,'validation' =>'error occurred please contact your system administrator');

                    echo json_encode($st);

               }

		}

	}	

	

	//Requisition payment page 

	public function payments()

	{

        $data['service_id'] = $this->input->get('id');

        $data['service_type'] = $this->input->get('service_type');

        $this->load->view('models/service_payment',$data);	

	}

	

	

/*	public function update_service_status()

	{

        $service_id = $this->input->post('service_id');

		$disMsg='';

		

				$data_edit=array(

				'service_prepared_status'=>$this->input->post('service_prepared_status'),

				'service_authorized_status'=>$this->input->post('service_authorized_status'),

			    'service_checked_status'=>$this->input->post('service_checked_status'),

				'service_approved_status'=>$this->input->post('service_approved_status'),

			);

			$_insert=$this->Service_Model->save_service($data_edit,$service_id);

			

			//echo $this->db->last_query();

        

        echo json_encode(array('service_id'=>$service_id,'error'=>'','disMsg'=>$disMsg,));

	}

	*/

	

	//Requisition save 

	//Requisition item save

	//Add service items to 54 table

	public function save_service()

	{

		$warehouse_id=$this->input->post('warehouse_id');

		$service_id=$this->input->post('service_id');

		$rowCount=$this->input->post('rowCount');

		$service_datetime=date('Y-m-d H:i:s', strtotime($this->input->post('service_datetime')));

		$service_return_date=date('Y-m-d H:i:s', strtotime($this->input->post('service_return_date')));

		$service_customer_id=$this->input->post('service_customer_id');

		//$product_charge_type=$this->input->post('product_charge_type');

		$service_diposit=$this->input->post('service_diposit');

		$service_responsible_person=$this->input->post('service_responsible_person');

		//$=$this->input->post('');

		

		

		$service_net_total=$this->input->post('service_net_total');

		$service_vat=$this->input->post('service_vat');

		$service_discount=$this->input->post('service_discount');

		$service_discount_amt=$this->input->post('service_discount_amt');

		$current_mileage=$this->input->post('current_mileage');

		$nature_of_work=$this->input->post('nature_of_work');



		

			$service_reference_no=$this->input->post('service_reference_no');

	

		

		$error='';

		$disMsg='';

		$lastid='';

		//$service_id='';

		//echo 'dis:'.$service_discount;

		

		if(!$error){

			$data_save=array(

			'service_reference_no'=>$service_reference_no,

				'service_datetime'=>$service_datetime,

				'service_return_date'=>$service_return_date,

				'service_customer_id'=>$service_customer_id,

				'service_net_total'=>$service_net_total,

				'service_diposit'=>$service_diposit,

				'service_vat'=>$service_vat,

				'service_discount'=>$service_discount,

				'service_discount_amt'=>$service_discount_amt,

				 'warehouse_id'=>$warehouse_id,

				 'service_responsible_person'=>$service_responsible_person,

				 'nature_of_work'=>$nature_of_work,

				 'current_mileage'=>$current_mileage

				);

			



			if($service_id){

				//echo '111111111111';

				

				$service_id=$service_id;

				$this->Service_Model->save_service($data_save,$service_id);

				

				//echo $this->db->last_query();

				//delete old req items

				$this->Service_Model->delete_old_service_items($service_id);

				$disMsg='Requisition successfully updated';

				

			}else {

				

			$_insert=$this->Service_Model->save_service($data_save,'');

			

			

			$lastid=$this->db->insert_id();

			$service_id=$lastid;

			$disMsg='Requisition successfully added';

			}

			

			

			

			//insert sale item data

			$row=$this->input->post('row_e');

			$rowCount=$this->input->post('rowCount');

			//echo 'test:'.$rowCount;

			$data_item=array();

			for($i=1; $i<=$rowCount; $i++){

				if(isset($row[$i]['product_name'][0]))

				{

					

				$data_item=array(

					'service_id'=>$service_id,

					'product_name'=>$row[$i]['product_name'][0],

					'serviceitm_qty'=>$row[$i]['serviceitm_qty'][0],

					'product_service_charge'=>$row[$i]['product_service_charge'][0],

					'serviceitm_dis'=>$row[$i]['serviceitm_dis'][0],

					'serviceitm_dis_val'=>$row[$i]['serviceitm_dis_val'][0],

					'sub_total_item'=>$row[$i]['sub_total_item'][0],

					'product_unit'=>$row[$i]['product_unit'][0],					

				);

				$this->Service_Model->save_service_item($data_item);

				

				//add reford for f4 table

				/*

				$type='service';

				$ref_id=$service_id;

				$product=$row[$i]['product_name'][0];

				$quantity=$row[$i]['product_name'][0];

				$unit_cost=$row[$i]['product_name'][0];

				$this->Common_Model->add_fi_table($type,$ref_id,$product,$quantity,$unit_cost);*/

				}

			}

		

		}else {

			

			$disMsg='Please select these before adding any product:'.$disMsg;

		}	

		

	//	echo "Test:".$service_id;;

		

		$this->session->set_flashdata('message', 'Requisition successfully added!');

		

		echo json_encode(array('service_id'=>$service_id,'error'=>$error,'disMsg'=>$disMsg,));

	}



	//Requisition reference no jenarate	

	public function get_next_ref_no(){

		$query=$this->Service_Model->get_next_ref_no();

		$result = $query->row();

		//print_r($result);

		$service_reference_no=sprintf("%05d", $result->service_id+1);

		$service_reference_no=$service_reference_no;

		echo json_encode(array('service_reference_no'=>$service_reference_no));

	}

	

	//Requisition ger avalable product qty

	public function get_avalable_product_qty(){

		$product_id=$this->input->get('product_id');

		$warehouse_id=$this->input->get('warehouse_id');

		

		$data['total']=$this->Service_Model->get_avalable_product_qty($product_id,$warehouse_id);

		echo json_encode(array('remmnaingQty'=>$data['total']));

	}

	

	//equisition details view

	public function service_details()

	{

		$data['main_menu_name'] = $this->main_menu_name;

		$data['sub_menu_name'] = '';

		

		//get sale id

		$service_id=$this->uri->segment('3');

		if(isset($service_id)){

			$data['service_details']=$this->Service_Model->get_service_details_by_id($service_id);

			$data['serviceitm_list']=$this->Service_Model->get_service_items_by_id($service_id);

		}

		$data['service_id'] =$service_id;

		

        $this->load->view('service_details',$data);

		

	}



	//Requisition add form

    public function service_add()

    {

		$data['main_menu_name'] = $this->main_menu_name;

		$data['sub_menu_name'] = 'service_add';

		

		$service_id=$this->uri->segment('3');

		$data['serviceitm_list']=array();

		if(isset($service_id)){

			$data['service_details']=$this->Service_Model->get_service_details_by_id($service_id);

			$data['serviceitm_list']=$this->Service_Model->get_service_items_by_id($service_id);

		}

		

		$data['service_id'] =$service_id;

		//get suppliers list

		$data['suppliers'] = $this->Supplier_Model->get_all_supplier();

		$data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();

		$data['tax_rates_list'] = $this->Tax_Rates_Model->get_all_tax_rates();

		//$data['suppliers'] = $this->Customer_Model->get_all_customers('Rent');

		$data['status_list'] = $this->Common_Model->get_all_status();

		//$data['pr_list'] = $this->Requisition_Model->get_all_requisition_names();

		

        $this->load->view('service_add',$data);

    }

	

	

	

	//Requisition product items get

	 public function suggestions($value='')

    {

		$term=$this->input->get('term');

		$data['service'] = $this->Service_Model->get_products_suggestions($term);

		$json = array();

		//echo "Count:".count($data['service']);

		//print_r($data['service']);

		foreach ($data['service'] as $row)

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

					'product_part_no'=> $row['product_part_no'],

					'product_oem_part_number'=> $row['product_oem_part_number'],

                    'value'=> $row['product_name']." (".$row['product_code'].")",

                    'label'=> $row['product_name']." (".$row['product_code'].")$extraName"

                    );

					array_push($json,$json_itm);

		}		

		echo json_encode($json);		

    }

	

	//Sale details page

	public function service_details_print()

	{

		

		$service_id=$this->input->get('service_id');

		$data['service_details']= $this->Service_Model->get_service_info($service_id);

		

		//get sale item list

		$data['service_item_list']= $this->Service_Model->get_service_item_list_by_service_id($service_id);

		

		$data['customer_details']= $this->Customer_Model->get_customer_info($data['service_details']['customer_id']);

		$data['warehouse_details']= $this->Warehouse_Model->get_warehouse_info($data['service_details']['warehouse_id']);

		

		$data['cr_limit_list'] = $this->Common_Model->get_all_cr_limit();

        $this->load->view('models/service_print',$data);

	}

	



	

	//Service list

	public function list_service()

	{

	$requestData= $_REQUEST;

	

	$columns = array( 

		0 =>'service_id', 

		1 => 'service_id',

		2=> 'service_id',

		3 =>'service_id', 

		4 => 'service_id',

		5=> 'service_id'

	);

	

	$data = array();

	$service = $this->Service_Model->get_all_service();

	$totalData = count($service);

	$totalFiltered = $totalData;  

	

	foreach ($service as $row){

		$nestedData=array(); 

		$service_id=$row['service_id'];

		$total_paid_amount='';

		

		$nestedData[] = $row['service_reference_no'];

		$nestedData[] =$row['cus_name'];

		$nestedData[]=$row['supp_company_name'];

		$nestedData[] = date('d/M/Y', strtotime($row['service_datetime']));

		$nestedData[] = date('d/M/Y', strtotime($row['service_return_date']));

		

		$prepared_status_dis='';

		$checked_status_dis='';

		$approved_status_dis='';

		$authorized_status_dis='';

		

		

		if (empty($row['service_prepared_status'])) {

		  $prepared_status_dis = '<span class="label label-warning">Pending</span>';

		}else if($row['service_prepared_status']=='Prepared'){

			$prepared_status_dis = '<span class="label label-success">Prepared</span>';

		}

		if (empty($row['service_checked_status'])) {

		  $checked_status_dis = '<span class="label label-warning">Pending</span>';

		}else if($row['service_checked_status']=='Checked'){

			$checked_status_dis = '<span class="label label-success">Checked</span>';

		}

		if (empty($row['service_approved_status'])) {

		  $approved_status_dis = '<span class="label label-warning">Pending</span>';

		}else if($row['service_approved_status']=='Approved'){

			$approved_status_dis = '<span class="label label-success">Approved</span>';

		}

		

		if (empty($row['service_authorized_status'])) {

		  $authorized_status_dis = '<span class="label label-warning">Pending</span>';

		}else if($row['service_authorized_status']=='Authorized'){

			$authorized_status_dis = '<span class="label label-success">Authorized</span>';

		}

		

		$nestedData[] = $prepared_status_dis;

		$nestedData[] = $checked_status_dis;

		$nestedData[] = $approved_status_dis;

		$nestedData[]=$authorized_status_dis;

		

		

		//$nestedData[] = $row['service_id'];

		$actionTxtDisble='';

		$actionTxtEnable='';

		$actionTxtUpdate='';

		$actionTxtDelete='';

		

		$url=base_url("service/service_details?service_id=$service_id");

		$actionTxtUpdate='<a onClick="fbs_click('.$row['service_id'].')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="clip-zoom-in-2"></i></a> &nbsp;';

		

		$actionTxtViewDetails='<a href="'.base_url().'service/details/'.$service_id.'" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-file-text-o"></i></a> &nbsp;';

	

	$nestedData[] = '<div class="btn-group text-left">

                            <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>

                            <ul role="menu" class="dropdown-menu pull-right">

                            <li><a href="'.base_url().'service/details/'.$service_id.'"><i class="fa fa-file-text-o"></i> Service Details</a></li>

							 <li><a href="'.base_url().'service/manage/'.$service_id.'"><i class="fa fa-file-text-o"></i> Update Service Details</a></li>

                            <li><a onClick="fbs_click('.$row['service_id'].')" data-toggle="modal" href="#" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-print"></i> Print Service</a></li>

							

							

							

                            </ul></div>';

	

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