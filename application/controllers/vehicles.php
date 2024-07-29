<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vehicles extends CI_Controller {

    var $main_menu_name = "vehicles";
    var $sub_menu_name = "vehicles";

    public function __construct() {
        parent::__construct();

        $this->load->model('Vehicles_Model');
        $this->load->model('Common_Model');
    }

    public function index() {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = $this->sub_menu_name;

        $this->load->view('vehicles', $data);
    }

    public function create_vehicles() {
		$data['nc'] = $this->input->get('nc');
        $data['id'] = 1;
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'create_vehicle';

        if (isset($_GET['veh_id'])) {
            $veh_id = $_GET['veh_id'];
        } else {
            $veh_id = '';
        }
        if ($veh_id) {
            $data['veh_id'] = $veh_id;
            $data['type'] = 'E';
            $data['pageName'] = 'UPDATE VEHICLE';
            $data['btnText'] = 'Update Vehicle';
            $data['vehicle'] = $this->Android_Model->get_vehicle_info($veh_id);
        } else {
            $data['veh_id'] = '';
            $data['type'] = 'A';
            $data['pageName'] = 'ADD VEHICLE';
            $data['btnText'] = 'Add Vehicle';
            $data['vehicle'] = array();
            $data['vehicle']['cus_code'] = $this->Common_Model->gen_ref_number('veh_id', 'vehicles', 'VEH/');
        }
        $data['country_list'] = $this->Common_Model->get_all_country();
        $this->load->view('models/create_vehicle', $data);
    }

    function get_all_vehicles() {
        $this->db->select('veh_name', 'veh_id');
        $this->db->order_by("veh_name", "asc");
        $this->db->where("veh_status=1"); //("id !=",$id);
        $query = $this->db->get('vehicles');
        return $query->result_array();
    }

    public function save_vehicle() {
		$type = $this->input->post('type');

        $veh_id = intval($this->input->post('veh_id'));
        
        $veh_code = intval($this->input->post('veh_code'));
        $veh_number = $this->input->post('veh_number');
        $veh_descripton = $this->input->post('veh_descripton');
        $veh_status = $this->input->post('veh_status');

       /* $this->load->library('form_validation'); //form validation lib
        if ($type == 'A') {
           // $this->form_validation->set_rules('$veh_code', 'Code', 'required|is_unique[vehicles.veh_code]');
            $this->form_validation->set_rules('$veh_number', 'Number', 'required|is_unique[vehicles.veh_number]');
        } else if ($type == 'E') {
            $this->form_validation->set_rules('veh_code', 'Code', 'required');
            $this->form_validation->set_rules('veh_number', 'Vehicle Number', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            $st = array('status' => 0, 'validation' => validation_errors());
            echo json_encode($st);
        } else*/ {
            $data = array(
                'veh_code' => $veh_code,
                'veh_id' => $veh_id,
                'veh_number' => $veh_number,
                'veh_descripton' => $veh_descripton,
                'veh_status' => $veh_status,
				'user_id'	=> $this->session->userdata('ss_user_id')
            );

            $_insert = $this->Vehicles_Model->save_vehicle($data, $veh_id);
            $lastid = $this->db->insert_id();

            if ($type == 'A') {
                if ($lastid) {
                    echo json_encode(array('id' => $lastid, 'type' => $type, 'status' => 1));
                } else {
                    echo json_encode(array('status' => '0'));
                }
            }
            if ($type == 'E') {
                echo json_encode(array('type' => $type, 'status' => 1));
            }

            //$st = array('status' =>1,'validation' => validation_errors());
            // echo json_encode($st);
        }
    }

    public function list_vehicles() {
        $requestData = $_REQUEST;

        $columns = array(
            0 => 'veh_id',
            1 => 'cus_name',
            2 => 'cus_email',
            3 => 'cus_phone',
            4 => 'cus_phone',
            5 => 'veh_id'
        );

        $data = array();
        $vehicles = $this->Vehicles_Model->get_all_vehicles();
        $totalData = count($vehicles);
        $totalFiltered = $totalData;

        foreach ($vehicles as $row) {
            $nestedData = array();
            $nestedData[] = $row['cus_code'];
            $nestedData[] = $row['cus_name'];
            $nestedData[] = $row['cus_email'];
            $nestedData[] = $row['cus_phone'];
            $nestedData[] = $row['city_name'];
            $actionTxtDisble = '';
            $actionTxtEnable = '';
            $actionTxtUpdate = '';
            $actionTxtDelete = '';
            $actionTxtUpdate = '<a onClick="click_vehicle_update_btn(' . $row['veh_id'] . ')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit vehicles"><i class="glyphicon fa fa-edit"></i></a> &nbsp;';
            if ($row['cus_status'] == 1) {
                $actionTxtDisble = '<a class="btn btn-xs btn-green tooltips" data-placement="top" data-original-title="Disable vehicle" onClick="disableCustomerData(' . $row['veh_id'] . ')"><i class="glyphicon fa fa-check"></i></a> &nbsp;';
            }
            if ($row['cus_status'] == 0) {
                $actionTxtEnable = '<a class="btn btn-xs btn-warning tooltips" data-placement="top" data-original-title="Disable vehicle" onClick="enableCustomerData(' . $row['veh_id'] . ')"><i class="glyphicon fa fa-minus-circle"></i></a> &nbsp;';
            }
            $actionTxtDelete = '<a class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Delete vehicle" onClick="deleteCustomerData(' . $row['veh_id'] . ')">
															<i class="glyphicon fa fa-trash-o"></i></a>';

            $nestedData[] = $actionTxtUpdate . $actionTxtDisble . $actionTxtEnable . $actionTxtDelete;
            $data[] = $nestedData;
        }

        $json_data = array(
            //"draw"            => intval( $requestData['draw'] ),  
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    function delete_vehicle() {
        $veh_id = $this->input->post('veh_id');
        $this->Android_Model->delete_vehicle($veh_id);
        if ($veh_id) {
            echo json_encode(array('id' => $veh_id));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }

    function disable_vehicle() {
        $veh_id = $this->input->post('veh_id');
        $this->Android_Model->disable_vehicle($veh_id);
        if ($veh_id) {
            echo json_encode(array('id' => $veh_id));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }

    function enable_vehicle() {
        $veh_id = $this->input->post('veh_id');
        $this->Android_Model->enable_vehicle($veh_id);
        if ($veh_id) {
            echo json_encode(array('id' => $veh_id));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }
	function login(){
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('cus_username', 'Username', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'status' => 0,
                'validation' => validation_errors()
            );
            echo json_encode($st);
        } else {
			//echo $this->input->post('cus_username');
			//echo $this->input->post('cus_password');
            $user_username = $this->input->post('cus_username');
            $password      = $this->input->post('cus_password');
            //get user details by id
//			echo $user_username.'/n';
//			echo $password;
            $veh_id       = $this->Android_Model->login($user_username, $password);
            //echo "<br/>test:$veh_id";
            if ($veh_id) {
                $data['cus_details'] = $this->Android_Model->get_vehicle_info($veh_id);
                //create sessions
				//print_r($data['cus_details']);
                $ss_cus_username     = $data['cus_details']['cus_email'];
                $ss_cus_id           = $data['cus_details']['veh_id'];
                $ss_group_id          = '5';
                $ss_warehouse_id      = $data['cus_details']['cus_warehouse_id'];
                $ss_cus_group_name   = 'vehicle';
                $sesdata              = array(
                    'ss_user_username' => $ss_cus_username,
                    'ss_user_id' => $ss_cus_id,
                    'ss_group_id' => $ss_group_id,
                    'ss_warehouse_id' => $ss_warehouse_id,
                    'ss_user_first_name' => $data['cus_details']['cus_name'],
                    'ss_user_last_name' => '',
                    'ss_user_group_name' => $ss_cus_group_name ,
                    'ss_user_address' => $data['cus_details']['cus_address']
                );

                $this->Android_Model->create_cus_sessions($sesdata);
				
				//print_r($this->session->userdata);
                // redirect(base_url().'dashboard','refresh');
                $st = array(
                    'status' => 1,
                    'validation' => 'Done!'
                );
                //insert user activity
                $this->Common_Model->add_user_activitie("Log Csutomer");
                echo json_encode($st);
            } else {
                    $st = array(
                        'status' => 0,
                        'validation' => validation_errors()
                    );
                    echo json_encode($st);
                }
        }
    }
}
