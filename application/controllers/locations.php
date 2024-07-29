<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Locations extends CI_Controller {

    var $main_menu_name = "settings";
	var $sub_menu_name = "locations";

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Location_Model');
	}
	
	public function index()
	{
		$data['locations'] = $this->Location_Model->get_all_location();
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = $this->sub_menu_name;
		$this->load->view('locations',$data);
	}
	
	public function save_location()
	{
		$location_id=$this->input->post('location_id');
		$type=$this->input->post('type');
		$location_name=$this->input->post('location_name');
		$location_code=$this->input->post('location_code');
		$location_phone=$this->input->post('location_phone');
		$location_email=$this->input->post('location_email');
		$location_fax=$this->input->post('location_fax');
		$location_address=$this->input->post('location_address');

		$data=array(
			'location_name'=>$location_name,
			'location_code'=>$location_code,
			'location_phone'=>$location_phone,
			'location_email'=>$location_email,
			'location_fax'=>$location_fax,
			'location_address'=>$location_address,
			'location_code'=>$location_code
		);
		
		$_insert=$this->Location_Model->save_location($data,$location_id);
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


	public function list_location()
	{
	$requestData= $_REQUEST;
	
	$columns = array( 
		0 =>'location_code', 
		1 => 'location_name',
		2=> 'location_phone',
		1 => 'location_email',
		3 =>'location_address', 
		5=> 'location_id'
	);
	
	$data = array();
	$location = $this->Location_Model->get_all_location();
	$totalData = count($location);
	$totalFiltered = $totalData;  
	
	foreach ($location as $row){
		$nestedData=array(); 
		$nestedData[] =$row['location_code'];
		$nestedData[] = $row['location_name'];
		$nestedData[] = $row['location_phone'];
		$nestedData[] =$row['location_email'];
		$nestedData[] = $row['location_address'];
		$actionTxtDisble='';
		$actionTxtEnable='';
		$actionTxtUpdate='';
		$actionTxtDelete='';
		$actionTxtUpdate='<a onClick="click_supplier_update_btn('.$row['location_id'].')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="glyphicon fa fa-edit"></i></a> &nbsp;';
		if($row['location_status']==1){
			$actionTxtDisble = '<a class="btn btn-xs btn-green tooltips" data-placement="top" data-original-title="Disable supplier" onClick="disableLocationData('.$row['location_id'].')"><i class="glyphicon fa fa-check"></i></a> &nbsp;';
	}
		if($row['location_status']==0){
			$actionTxtEnable = '<a class="btn btn-xs btn-warning tooltips" data-placement="top" data-original-title="Disable supplier" onClick="enableLocationData('.$row['location_id'].')"><i class="glyphicon fa fa-minus-circle"></i></a> &nbsp;';
	}
		$actionTxtDelete='<a class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Delete supplier" onClick="deleteLocationData('.$row['location_id'].')">
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

	public function create_location()
	{
        if (isset($_GET['location_id'])) {
			$location_id=$_GET['location_id'];
		}
		else {
			$location_id='';
		}
		if($location_id){
			$data['location_id']=$location_id;
			$data['type']='E';
			$data['pageName']='UPDATE LOCATION';
			$data['btnText']='Update Location';
			$data['locations']= $this->Location_Model->get_location_info($location_id);	
		}
		else {
			$data['location_id']='';
			$data['type']='A';
			$data['pageName']='ADD LOCATION';
			$data['btnText']='Add Location';
			$data['suppliyer']=array();
		}
        $this->load->view('models/create_locations',$data);
	}


	function delete_location() {
		$location_id	= $this->input->post('location_id');
		$this->Location_Model->delete_location($location_id);
        if ($location_id) {
        	echo json_encode(array('id'=>$location_id));
        } else {
        	echo json_encode(array('status'=>'error'));
        }
	}
	
	function disable_location() {
		$location_id	= $this->input->post('location_id');
		$this->Location_Model->disable_location($location_id);
        if ($location_id) {
        	echo json_encode(array('id'=>$location_id));
        } else {
        	echo json_encode(array('status'=>'error'));
        }
	}
	
	function enable_location() {
		$location_id	= $this->input->post('location_id');
		$this->Location_Model->enable_location($location_id);
        if ($location_id) {
        	echo json_encode(array('id'=>$location_id));
        } else {
        	echo json_encode(array('status'=>'error'));
        }
	}
}