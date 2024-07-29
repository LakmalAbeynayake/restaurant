<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Warehouse extends CI_Controller
{
    var $main_menu_name = "settings";
    var $sub_menu_name = "warehouse";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Warehouse_Model');
        $this->load->model('Common_Model');
    }
    public function index()
    {
        $data['warehouses'] = $this->Warehouse_Model->get_all_warehouse();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = $this->sub_menu_name;
        $this->load->view('locations/list_locations', $data);
    }
    public function save_warehouse()
    {
        $warehouse_id = $this->input->post('warehouse_id');
        $type = $this->input->post('type');
        $name = $this->input->post('name');
        $code = $this->input->post('code');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $warehouses_type = $this->input->post('warehouses_type');
        $data = array(
            'name' => $name,
            'code' => $code,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'warehouses_type' => $warehouses_type
        );
        $_insert = $this->Warehouse_Model->save_warehouse($data, $warehouse_id);
        //echo $this->db->last_query();
        $lastid = $this->db->insert_id();
        if ($type == 'A') {
            if ($lastid) {
                echo json_encode(array('id' => $lastid, 'type' => $type));
            } else {
                echo json_encode(array('status' => 'error'));
            }
        }
        if ($type == 'E') {
            echo json_encode(array('type' => $type));
        }
    }
    public function get_list_warehouse($value = '')
    {
        $values = $this->Warehouse_Model->get_all_warehouse();
        $data = array();
        if (!empty($values)) {
            foreach ($values as $users) {
                $row = array();
                $row[] = $users->code;
                $row[] = $users->name;
                $row[] = $users->phone;
                $row[] = $users->email;
                $row[] = $users->address;
                if ($users->warehouses_type == 1) $row[] = 'Department';
                else if ($users->warehouses_type == 2) $row[] = 'Outlet';
                else $row[] = '';
                $actionTxtDisble = '';
                $actionTxtEnable = '';
                $actionTxtUpdate = '';
                $actionTxtDelete = '';
                $actionTxtUpdate = '<a onClick="click_warehouse_update_btn(' . $users->id . ')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="glyphicon fa fa-edit"></i></a> &nbsp;';
                if ($users->status == 1) {
                    $actionTxtDisble = '<a class="btn btn-xs btn-green tooltips" data-placement="top" data-original-title="Disable customer" onClick="disableWarehouseData(' . $users->id . ')"><i class="glyphicon fa fa-check"></i></a> &nbsp;';
                }
                if ($users->status == 0) {
                    $actionTxtEnable = '<a class="btn btn-xs btn-warning tooltips" data-placement="top" data-original-title="Disable customer" onClick="enableWarehouseData(' . $users->id . ')"><i class="glyphicon fa fa-minus-circle"></i></a> &nbsp;';
                }
                $actionTxtDelete = '<a class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Delete customer" onClick="deleteWarehouseData(' . $users->id . ')">
																		<i class="glyphicon fa fa-trash-o"></i></a>';
                $row[] = $actionTxtUpdate . $actionTxtDisble . $actionTxtEnable . $actionTxtDelete;
                $data[] = $row;
            }
            $output = array('data' => $data);
            echo json_encode($output);
        } else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    }
    public function create_location()
    {
        if (isset($_GET['warehouse_id'])) {
            $warehouse_id = $_GET['warehouse_id'];
        } else {
            $warehouse_id = '';
        }
        if ($warehouse_id) {
            $data['warehouse_id'] = $warehouse_id;
            $data['type'] = 'E';
            $data['pageName'] = 'UPDATE WAREHOUSE';
            $data['btnText'] = 'Update Warehouse';
            $data['warehouse_list'] = $this->Warehouse_Model->get_warehouse_info($warehouse_id);
        } else {
            $data['warehouse_id'] = '';
            $data['type'] = 'A';
            $data['pageName'] = 'ADD WAREHOUSE';
            $data['btnText'] = 'Add Warehouse';
            $data['suppliyer'] = array();
        }
        $this->load->view('locations/create_location', $data);
    }
    function delete_warehouse()
    {
        $warehouse_id    = $this->input->post('warehouse_id');
        $this->Warehouse_Model->delete_warehouse($warehouse_id);
        if ($warehouse_id) {
            echo json_encode(array('id' => $warehouse_id));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }
    function disable_warehouse()
    {
        $warehouse_id    = $this->input->post('warehouse_id');
        $this->Warehouse_Model->disable_warehouse($warehouse_id);
        if ($warehouse_id) {
            echo json_encode(array('id' => $warehouse_id));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }
    function enable_warehouse()
    {
        $warehouse_id    = $this->input->post('warehouse_id');
        $this->Warehouse_Model->enable_warehouse($warehouse_id);
        if ($warehouse_id) {
            echo json_encode(array('id' => $warehouse_id));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }
}