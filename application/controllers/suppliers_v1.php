<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suppliers extends CI_Controller {

    var $main_menu_name = "people";
	var $sub_menu_name = "suppliers";

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Supplier_Model');
		$this->load->model('Common_Model');
	}
	
	public function index()
	{
		$data['suppliers'] = $this->Supplier_Model->get_all_supplier();
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = $this->sub_menu_name;
		$this->load->view('suppliers',$data);
	}


	
	public function save_supplier()
	{
		$supp_id=$this->input->post('supp_id');
		$type=$this->input->post('type');
		$cr_limit_id=$this->input->post('cr_limit_id');
		$country_id=$this->input->post('country_id');	
		$supp_company_name= $this->input->post('supp_company_name');
		$supp_company_phone=$this->input->post('supp_company_phone');
		$supp_city=$this->input->post('supp_city');
		$supp_state=$this->input->post('supp_state');
		$supp_fax=$this->input->post('supp_fax');
		$supp_postal_code=$this->input->post('supp_postal_code');
		$supp_address=$this->input->post('supp_address');
		$supp_email=$this->input->post('supp_email');
		$supp_contact_person_name=$this->input->post('supp_contact_person_name');
		$supp_contact_person_phone=$this->input->post('supp_contact_person_phone');
		$supp_contact_person_email=$this->input->post('supp_contact_person_email');
		$supp_bank=$this->input->post('supp_bank');
		$supp_bank_branch=$this->input->post('supp_bank_branch');
		$supp_account_number=$this->input->post('supp_account_number');
		$supp_credit_period=$this->input->post('supp_credit_period');
		
		$data=array(
			'cr_limit_id'=>$cr_limit_id,
			'country_id'=>$country_id,
			'supp_company_name'=>$supp_company_name,
			'supp_company_phone'=>$supp_company_phone,
			'supp_city'=>$supp_city,
			'supp_state'=>$supp_state,
			'supp_fax'=>$supp_fax,
			'supp_postal_code'=>$supp_postal_code,
			'supp_address'=>$supp_address,
			'supp_email'=>$supp_email,
			'supp_contact_person_name'=>$supp_contact_person_name,
			'supp_contact_person_phone'=>$supp_contact_person_phone,
			'supp_contact_person_email'=>$supp_contact_person_email,			
			'supp_bank'=>$supp_bank,
			'supp_bank_branch'=>$supp_bank_branch,
			'supp_account_number'=>$supp_account_number,
			'supp_credit_period'=>$supp_credit_period
			
		);
		
		$_insert=$this->Supplier_Model->save_supplier($data,$supp_id);
		$lastid=$this->db->insert_id();

		if($type=='A'){
			if ($lastid) {
				echo json_encode(array('id'=>$lastid,'type'=>$type));
			} else {
				echo json_encode(array('status'=>'error'));
			}
		}
		if($type=='E'){
			echo json_encode(array('type'=>$type));
		}
	}

	public function list_supplier()
	{
	$requestData= $_REQUEST;
	
	$columns = array( 
		0 =>'supp_code', 
		0 =>'supp_company_name', 
		1 => 'supp_email',
		2=> 'supp_company_phone',
		3 =>'supp_city', 
		4 => 'country_id',
		5=> 'supp_id'
	);
	
	$data = array();
	$suppliers = $this->Supplier_Model->get_all_supplier();
	$totalData = count($suppliers);
	$totalFiltered = $totalData; 
	//print_r($suppliers);
	
	foreach ($suppliers as $row){
		$nestedData=array(); 
		$nestedData[] =$row['supp_code'];
		$nestedData[] =$row['supp_company_name'];
		$nestedData[] = $row['supp_email'];
		$nestedData[] = $row['supp_company_phone'];
		$nestedData[] =$row['supp_city'];
		$nestedData[] = $row['country_short_name'];
		$actionTxtDisble='';
		$actionTxtEnable='';
		$actionTxtUpdate='';
		$actionTxtDelete='';
		$actionTxtUpdate='<a onClick="click_supplier_update_btn('.$row['supp_id'].')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="glyphicon fa fa-edit"></i></a> &nbsp;';
		if($row['supp_status']==1){
			$actionTxtDisble = '<a class="btn btn-xs btn-green tooltips" data-placement="top" data-original-title="Disable supplier" onClick="disableSupplierData('.$row['supp_id'].')"><i class="glyphicon fa fa-check"></i></a> &nbsp;';
	}
		if($row['supp_status']==0){
			$actionTxtEnable = '<a class="btn btn-xs btn-warning tooltips" data-placement="top" data-original-title="Disable supplier" onClick="enableSupplierData('.$row['supp_id'].')"><i class="glyphicon fa fa-minus-circle"></i></a> &nbsp;';
	}
		$actionTxtDelete='<a class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Delete supplier" onClick="deleteSupplierData('.$row['supp_id'].')">
															<i class="glyphicon fa fa-trash-o"></i></a>';
	
	$nestedData[]=$actionTxtUpdate.$actionTxtDisble.$actionTxtEnable.$actionTxtDelete;
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

	public function create_supplier()
	{
        if (isset($_GET['supp_id'])) {
			$supp_id=$_GET['supp_id'];
		}
		else {
			$supp_id='';
		}
		if($supp_id){
			$data['supp_id']=$supp_id;
			$data['type']='E';
			$data['pageName']='UPDATE SUPPLIER';
			$data['btnText']='Update Supplier';
			$data['suppliyer']= $this->Supplier_Model->get_supplier_info($supp_id);	
		}
		else {
			$data['supp_id']='';
			$data['type']='A';
			$data['pageName']='ADD SUPPLIER';
			$data['btnText']='Add Supplier';
			$data['suppliyer']=array();
		}
		$data['country_list'] = $this->Common_Model->get_all_country();
		$data['cr_limit_list'] = $this->Common_Model->get_all_cr_limit();
        $this->load->view('models/create_supplier',$data);
	}


	function delete_supplier() {
		$supp_id	= $this->input->post('supp_id');
		$this->Supplier_Model->delete_supplier($supp_id);
        if ($supp_id) {
        	echo json_encode(array('id'=>$supp_id));
        } else {
        	echo json_encode(array('status'=>'error'));
        }
	}
	
	function disable_supplier() {
		$supp_id	= $this->input->post('supp_id');
		$this->Supplier_Model->disable_supplier($supp_id);
        if ($supp_id) {
        	echo json_encode(array('id'=>$supp_id));
        } else {
        	echo json_encode(array('status'=>'error'));
        }
	}
	
	function enable_supplier() {
		$supp_id	= $this->input->post('supp_id');
		$this->Supplier_Model->enable_supplier($supp_id);
        if ($supp_id) {
        	echo json_encode(array('id'=>$supp_id));
        } else {
        	echo json_encode(array('status'=>'error'));
        }
	}
}