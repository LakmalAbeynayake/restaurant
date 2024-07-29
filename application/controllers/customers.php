<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customers extends CI_Controller {

    var $main_menu_name = "people";
    var $sub_menu_name = "customers";

    public function __construct() {
        parent::__construct();

        $this->load->model('Customer_Model');
        $this->load->model('Common_Model');
    }

    public function index() {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = $this->sub_menu_name;

        $this->load->view('customers', $data);
    }

    public function create_customers() {
		$data['nc'] = $this->input->get('nc');
        $data['id'] = 1;
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'create_customer';

        if (isset($_GET['cus_id'])) {
            $cus_id = $_GET['cus_id'];
        } else {
            $cus_id = '';
        }
        if ($cus_id) {
            $data['cus_id'] = $cus_id;
            $data['type'] = 'E';
            $data['pageName'] = 'UPDATE CUSTOMER';
            $data['btnText'] = 'Update Customer';
            $data['customer'] = $this->Customer_Model->get_customer_info($cus_id);
        } else {
            $data['cus_id'] = '';
            $data['type'] = 'A';
            $data['pageName'] = 'ADD CUSTOMER';
            $data['btnText'] = 'Add Customer';
            $data['customer'] = array();
            $data['customer']['cus_code'] = $this->Common_Model->gen_ref_number('cus_id', 'customer', 'CUS/');
        }
        $data['country_list'] = $this->Common_Model->get_all_country();
        $data['cus_type_list'] = $this->Customer_Model->get_all_cus_type();
        $this->load->view('models/create_customer', $data);
    }
    
    function get_customer_info_by_phone(){
        $cus_phone =  $this->input->post("cus_phone");
        $cus_data = $this->Customer_Model->get_customer_info_by_phone($cus_phone);
        echo json_encode(array(
            "cus_id"    => isset($cus_data['cus_id']) ? $cus_data['cus_id'] :       "",
            "cus_name"  => isset($cus_data['cus_name']) ? $cus_data['cus_name'] :   "",
            "cus_type"  => isset($cus_data['cus_type_id']) ? $cus_data['cus_type_id'] : ""
        ));
    }

    function get_all_customers() {
        $this->db->select('cus_name', 'cus_id');
        $this->db->order_by("cus_name", "asc");
        $this->db->where("cus_status=1"); //("id !=",$id);
        $query = $this->db->get('customers');
        return $query->result_array();
    }

    public function save_customer() {

        $cus_id = intval($this->input->post('cus_id'));
        $type = $this->input->post('type');
        $country_id = intval($this->input->post('country_id'));
        $city_name = $this->input->post('city_name');
        $cus_name = $this->input->post('cus_name');
        $cus_code = $this->input->post('cus_code');
        $cus_email = $this->input->post('cus_email');
        $cus_phone = $this->input->post('cus_phone');
        $cus_address = $this->input->post('cus_address');
        $cus_state = $this->input->post('cus_state');
        $cus_postal_code = $this->input->post('cus_postal_code');
        $cus_type_id = $this->input->post('cus_type_id');

        $this->load->library('form_validation'); //form validation lib
        if ($type == 'A') {
            $this->form_validation->set_rules('cus_code', 'Code', 'required|is_unique[customer.cus_code]');
            $this->form_validation->set_rules('cus_phone', 'Phone', 'required|is_unique[customer.cus_phone]');
        } else if ($type == 'E') {
            $this->form_validation->set_rules('cus_code', 'Code', 'required');
            $this->form_validation->set_rules('cus_phone', 'Phone', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            $st = array('status' => 0, 'validation' => validation_errors());
            echo json_encode($st);
        } else {
            $data = array(
                'country_id' => $country_id,
                'cus_id' => $cus_id,
                'city_name' => $city_name,
                'cus_name' => $cus_name,
                'cus_code' => $cus_code,
                'cus_email' => $cus_email,
                'cus_phone' => $cus_phone,
                'cus_address' => $cus_address,
                'cus_state' => $cus_state,
                'cus_postal_code' => $cus_postal_code,
                'cus_type_id'=>$cus_type_id,
            );

            $_insert = $this->Customer_Model->save_customer($data, $cus_id);
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

    public function list_customer() {
        $requestData = $_REQUEST;
        $data = array();
        $cus_type =   $this->input->post('cus_type');
        $customers = $this->Customer_Model->get_all_customer($cus_type);
        $totalData = count($customers);
        $totalFiltered = $totalData;
        
        foreach ($customers as $row) {
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
            $actionTxtUpdate = '<a onClick="click_customer_update_btn(' . $row['cus_id'] . ')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit customers"><i class="glyphicon fa fa-edit"></i></a> &nbsp;';
            if ($row['cus_status'] == 1) {
                $actionTxtDisble = '<a class="btn btn-xs btn-green tooltips" data-placement="top" data-original-title="Disable customer" onClick="disableCustomerData(' . $row['cus_id'] . ')"><i class="glyphicon fa fa-check"></i></a> &nbsp;';
            }
            if ($row['cus_status'] == 0) {
                $actionTxtEnable = '<a class="btn btn-xs btn-warning tooltips" data-placement="top" data-original-title="Disable customer" onClick="enableCustomerData(' . $row['cus_id'] . ')"><i class="glyphicon fa fa-minus-circle"></i></a> &nbsp;';
            }
            $actionTxtDelete = '<a class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Delete customer" onClick="deleteCustomerData(' . $row['cus_id'] . ')">
															<i class="glyphicon fa fa-trash-o"></i></a>';

            $nestedData[] = '<div class="btn">'.$actionTxtUpdate . $actionTxtDisble . $actionTxtEnable . $actionTxtDelete.'</div>';
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

    function delete_customer() {
        $cus_id = $this->input->post('cus_id');
        $this->Customer_Model->delete_customer($cus_id);
        if ($cus_id) {
            echo json_encode(array('id' => $cus_id));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }

    function disable_customer() {
        $cus_id = $this->input->post('cus_id');
        $this->Customer_Model->disable_customer($cus_id);
        if ($cus_id) {
            echo json_encode(array('id' => $cus_id));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }

    function enable_customer() {
        $cus_id = $this->input->post('cus_id');
        $this->Customer_Model->enable_customer($cus_id);
        if ($cus_id) {
            echo json_encode(array('id' => $cus_id));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }
    
    function search_customer_by_phone()
    {
        $cname    = $this->input->get('search_string');
        $result = $this->Customer_Model->search_customer_by_phone($cname);
        echo json_encode($result);
    }

}
