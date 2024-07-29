<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit extends CI_Controller {

    var $main_menu_name = "settings";
	var $sub_menu_name = "unit";
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('Unit_Model');
		$this->load->model('Common_Model');
	}

	public function index()
	{
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = $this->sub_menu_name;
        $this->load->view('unit',$data);
	}
	
	
	public function save_unit()
	{
		$unit_id=$this->input->post('unit_id');
		$type=$this->input->post('type');
		$unit_name=$this->input->post('unit_name');
		$unit_code=$this->input->post('unit_code');

		$data=array(
			'unit_name'=>$unit_name,
			'unit_code'=>$unit_code,
		);
		
		$this->load->library('form_validation'); //form validation lib
		if($type=='A')
		{
			$this->form_validation->set_rules('unit_code', 'Code', 'required|is_unique[mstr_unit.unit_code]');
		}
		else if($type=='E')
		{
			$this->form_validation->set_rules('unit_code', 'Code', 'required');
		}
		
		if ($this->form_validation->run() == FALSE)
        {
           $st = array('status' =>0,'validation' => validation_errors());
           echo json_encode($st);
        }
        else
        {
		
		$_insert=$this->Unit_Model->save_unit($data,$unit_id);
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
	}

	public function add_unit()
	{
        if (isset($_GET['unit_id'])) {
			$unit_id=$_GET['unit_id'];
		}
		else {
			$unit_id='';
		}
		if($unit_id){
			$data['unit_id']=$unit_id;
			$data['type']='E';
			$data['pageName']='UPDATE UNIT';
			$data['btnText']='Update Unit';
			$data['suppliyer']= $this->Unit_Model->get_unit_info($unit_id);	
		}
		else {
			$data['unit_id']='';
			$data['type']='A';
			$data['pageName']='ADD UNIT';
			$data['btnText']='Add Unit';
			$data['suppliyer']=array();
		}
        $this->load->view('models/create_unit',$data);
	}

	public function list_unit()
	{
	$requestData= $_REQUEST;
	
	$columns = array( 
		0 =>'unit_code', 
		1 => 'unit_name'
	);
	
	$data = array();
	$unit = $this->Unit_Model->get_all_unit();
	$totalData = count($unit);
	$totalFiltered = $totalData;  
	
	foreach ($unit as $row){
		$nestedData=array(); 
		$nestedData[] =$row['unit_code'];
		$nestedData[] = $row['unit_name'];
		$actionTxtDisble='';
		$actionTxtEnable='';
		$actionTxtUpdate='';
		$actionTxtDelete='';
		$actionTxtUpdate='<a onClick="click_unit_update_btn('.$row['unit_id'].')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="glyphicon fa fa-edit"></i></a> &nbsp;';
		if($row['unit_status']==1){
			$actionTxtDisble = '<a class="btn btn-xs btn-green tooltips" data-placement="top" data-original-title="Disable supplier" onClick="disableUnitData('.$row['unit_id'].')"><i class="glyphicon fa fa-check"></i></a> &nbsp;';
	}
		if($row['unit_status']==0){
			$actionTxtEnable = '<a class="btn btn-xs btn-warning tooltips" data-placement="top" data-original-title="Disable supplier" onClick="enableUnitData('.$row['unit_id'].')"><i class="glyphicon fa fa-minus-circle"></i></a> &nbsp;';
	}
		$actionTxtDelete='<a class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Delete supplier" onClick="deleteUnitData('.$row['unit_id'].')">
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


	function delete_unit() {
		$unit_id	= $this->input->post('unit_id');
		$this->Unit_Model->delete_unit($unit_id);
        if ($unit_id) {
        	echo json_encode(array('id'=>$unit_id));
        } else {
        	echo json_encode(array('status'=>'error'));
        }
	}
	
	function disable_unit() {
		$unit_id	= $this->input->post('unit_id');
		$this->Unit_Model->disable_unit($unit_id);
        if ($unit_id) {
        	echo json_encode(array('id'=>$unit_id));
        } else {
        	echo json_encode(array('status'=>'error'));
        }
	}
	
	function enable_unit() {
		$unit_id	= $this->input->post('unit_id');
		$this->Unit_Model->enable_unit($unit_id);
        if ($unit_id) {
        	echo json_encode(array('id'=>$unit_id));
        } else {
        	echo json_encode(array('status'=>'error'));
        }
	}
}