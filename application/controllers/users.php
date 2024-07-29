<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_Model');
        $this->load->model('Customer_Model');
        $this->load->model('Common_Model');
        $this->load->model('Warehouse_Model');
        $this->load->model('User_Group_Model');
    }
    var $main_menu_name = "people";
    var $sub_menu_name = "users";
    private $table = 'user';
    public function index()
    {
       //echo hash('sha512', 'sinhademo1234**'); die();
        /*        $usr_permtn_pubvr = $this->Common_Model->is_avalable_for_use_this_link_for_user($this->session->userdata('ss_group_id'),'users');
        if(in_multiarray("usrgp_permission_page","users", $usr_permtn_pubvr,"usrgp_permission_view",1))
        {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = $this->sub_menu_name;
        $this->load->view('users',$data);    
        }else {
        $this->load->view('not_found');                
        }*/
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = $this->sub_menu_name;
        $data['warehouse_list']  = $this->Warehouse_Model->get_all_warehouse();
        $this->load->view('users', $data);
    }
    public function logout()
    {
        $sesdata = array(
            'ss_user_username' => '',
            'ss_user_id' => '',
            'ss_group_id' => '',
            'ss_warehouse_id' => '',
            'ss_user_first_name' => '',
            'ss_user_last_name' => '',
            'ss_user_group_name' => '',
            'ss_cashier_float_id' => '',
		    'ss_cashier_float_status'=>''
        );
        //insert user activity
        $this->Common_Model->add_user_activitie("Logout User");
        $this->session->unset_userdata($sesdata);
        redirect(base_url(), 'refresh');
    }
    public function login()
    {
        if ($_SERVER['CONTENT_TYPE'] !== "application/json" && $_SERVER['CONTENT_TYPE'] !== "application/json; charset=utf-8") {
            $this->output
                 ->set_content_type('application/json')
                 ->set_status_header(415 )
                 ->set_output(json_encode(array(
                     'error' => 'Invalid content type',
                     'message' => 'The type of content ('.$_SERVER['CONTENT_TYPE'].') you are trying to submit is not acceptable. JSON required.'
                 )));
            exit();
        }
        $_POST = json_decode(file_get_contents("php://input"), true);
         
        // Set the content type to application/json
        header('Content-Type: application/json');
    
        $this->load->library('form_validation'); // form validation lib
        $this->form_validation->set_rules('user_username', 'Username', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            http_response_code(400); // Bad Request
            $response = array(
                'status' => 0,
                'validation' => validation_errors()
            );
            echo json_encode($response);
        } else {
            $user_username = $this->input->post('user_username');
            $password      = $this->input->post('password');
    
            // Get user details by id
            $user_id = $this->User_Model->login($user_username, $password);
            
            if ($user_id) {
                $data['user_details'] = $this->User_Model->get_user_info($user_id);
    
                // Create sessions
                $ss_user_username = $data['user_details']['user_username'];
                $ss_user_id       = $data['user_details']['user_id'];
                $ss_group_id      = $data['user_details']['group_id'];
                $ss_warehouse_id  = $data['user_details']['warehouse_id'];
                $ss_warehouse_type = $data['user_details']['warehouses_type'];
                $ss_user_first_name = $data['user_details']['user_first_name'];
                $ss_user_last_name = $data['user_details']['user_last_name'];
                $ss_user_group_name = $data['user_details']['user_group_name'];
                $check_chashier_float = $this->User_Model->get_user_chashier_float($user_id);
                $float_status = 0;
                if ($check_chashier_float > 0) {
                    $float_status = 1; 
                }
    
                $sesdata = array(
                    'ss_user_username' => $ss_user_username,
                    'ss_user_id' => $ss_user_id,
                    'ss_group_id' => $ss_group_id,
                    'ss_warehouse_id' => $ss_warehouse_id,
                    'ss_warehouse_type' => $ss_warehouse_type,
                    'ss_user_first_name' => $ss_user_first_name,
                    'ss_user_last_name' => $ss_user_last_name,
                    'ss_user_group_name' => $ss_user_group_name,
                    'ss_cashier_float_id' => $check_chashier_float,
                    'ss_cashier_float_status' => $float_status
                );
    
                $this->User_Model->create_user_sessions($sesdata);
    
                http_response_code(200); // OK
                $response = array(
                    'status' => 1,
                    'ss_group_id' => $ss_group_id,
                    'validation' => 'Done!'
                );
    
                // Insert user activity
                $this->Common_Model->add_user_activitie("Log User");
                $this->User_Model->update_session();
                echo json_encode($response);
            } else {
                http_response_code(401); // Unauthorized
                $response = array(
                    'status' => 0,
                    'ss_group_id' => 0,
                    'validation' => 'Invalid username or password'
                );
                echo json_encode($response);
            }
        }
    }


    public function login_web(){
            // Set the content type to application/json
            header('Content-Type: application/json');
        
            $this->load->library('form_validation'); // form validation lib
            $this->form_validation->set_rules('user_username', 'Username', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                http_response_code(400); // Bad Request
                $response = array(
                    'status' => 0,
                    'validation' => validation_errors()
                );
                echo json_encode($response);
            } else {
                $user_username = $this->input->post('user_username');
                $password      = $this->input->post('password');
        
                // Get user details by id
                $user_id = $this->User_Model->login($user_username, $password);
                
                if ($user_id) {
                    $data['user_details'] = $this->User_Model->get_user_info($user_id);
        
                    // Create sessions
                    $ss_user_username = $data['user_details']['user_username'];
                    $ss_user_id       = $data['user_details']['user_id'];
                    $ss_group_id      = $data['user_details']['group_id'];
                    $ss_warehouse_id  = $data['user_details']['warehouse_id'];
                    $ss_warehouse_type = $data['user_details']['warehouses_type'];
                    $ss_user_first_name = $data['user_details']['user_first_name'];
                    $ss_user_last_name = $data['user_details']['user_last_name'];
                    $ss_user_group_name = $data['user_details']['user_group_name'];
                    $check_chashier_float = $this->User_Model->get_user_chashier_float($user_id);
                    $float_status = 0;
                    if ($check_chashier_float > 0) {
                        $float_status = 1; 
                    }
        
                    $sesdata = array(
                        'ss_user_username' => $ss_user_username,
                        'ss_user_id' => $ss_user_id,
                        'ss_group_id' => $ss_group_id,
                        'ss_warehouse_id' => $ss_warehouse_id,
                        'ss_warehouse_type' => $ss_warehouse_type,
                        'ss_user_first_name' => $ss_user_first_name,
                        'ss_user_last_name' => $ss_user_last_name,
                        'ss_user_group_name' => $ss_user_group_name,
                        'ss_cashier_float_id' => $check_chashier_float,
                        'ss_cashier_float_status' => $float_status
                    );
        
                    $this->User_Model->create_user_sessions($sesdata);
        
                    http_response_code(200); // OK
                    $response = array(
                        'status' => 1,
                        'ss_group_id' => $ss_group_id,
                        'validation' => 'Done!'
                    );
        
                    // Insert user activity
                    $this->Common_Model->add_user_activitie("Log User");
                    $this->User_Model->update_session();
                    echo json_encode($response);
                } else {
                    http_response_code(401); // Unauthorized
                    $response = array(
                        'status' => 0,
                        'ss_group_id' => 0,
                        'validation' => 'Invalid username or password'
                    );
                    echo json_encode($response);
                }
            }
        }
    public function save_user()
    {
        $type = $this->input->post('type');
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('user_first_name', 'First Name', 'required');
        if ($type == 'A') {
            $this->form_validation->set_rules('user_username', 'User Name', 'required|is_unique[user.user_username]');
            $this->form_validation->set_rules('user_email', 'User Emal', 'required|is_unique[user.user_email]');
        }
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'status' => 0,
                'validation' => validation_errors()
            );
            echo json_encode($st);
        } else {
            //print_r($_POST);
            $user_id         = $this->input->post('user_id');
            $user_first_name = $this->input->post('user_first_name');
            $user_last_name  = $this->input->post('user_last_name');
            $user_email      = $this->input->post('user_email');
            $user_username   = $this->input->post('user_username');
            $user_password   = $this->input->post('user_password');
            $user_gender     = $this->input->post('user_gender');
            $group_id        = $this->input->post('group_id');
            $warehouse_id    = $this->input->post('warehouse_id');
            if ($type == 'A') {
                $user_password      = $this->input->post('user_password');
                $user_password_send = hash('sha512', $user_password);
                $user_data          = array(
                    'user_first_name' => $user_first_name,
                    'user_last_name' => $user_last_name,
                    'user_email' => $user_email,
                    'user_gender' => $user_gender,
                    'group_id' => $group_id,
                    'warehouse_id' => $warehouse_id,
                    'user_username' => $user_username,
                    'user_password' => $user_password_send
                );
            } else {
                $user_data = array(
                    'user_first_name' => $user_first_name,
                    'user_last_name' => $user_last_name,
                    'user_email' => $user_email,
                    'user_gender' => $user_gender,
                    'group_id' => $group_id,
                    'warehouse_id' => $warehouse_id
                );
            }
            if ($this->User_Model->save_user($user_data, $user_id)) {
                $st = array(
                    'status' => 1,
                    'validation' => 'Done!',
                    'type' => $type
                );
                echo json_encode($st);
            } else {
                $st = array(
                    'status' => 0,
                    'validation' => 'error occurred please contact your system administrator',
                    'type' => $type
                );
                echo json_encode($st);
            }
        }
        //print_r($_REQUEST);
    }
    public function create_user()
    {
        $data['main_menu_name']  = $this->main_menu_name;
        $data['sub_menu_name']   = 'create_user';
        $data['warehouse_list']  = $this->Warehouse_Model->get_all_warehouse();
        $data['user_group_list'] = $this->User_Group_Model->get_all_user_group();
        $user_id                 = $this->uri->segment('3');
        if (isset($user_id)) {
            $user_id = $user_id;
        } else {
            $user_id = '';
        }
        if ($user_id) {
            $data['user_id']      = $user_id;
            $data['type']         = 'E';
            $data['pageName']     = 'UPDATE USER';
            $data['btnText']      = 'Update User';
            $data['user_details'] = $this->User_Model->get_user_info($user_id);
        } else {
            $data['user_id']  = '';
            $data['type']     = 'A';
            $data['pageName'] = 'ADD USER';
            $data['btnText']  = 'Add User';
            $data['user']     = array();
        }
        $data['country_list'] = $this->Common_Model->get_all_country();
        $this->load->view('create_user', $data);
    }
    public function get_list_user($value = '')
    {
        $location_id = $this->input->get('location_id');
        $values = $this->User_Model->getUsers($location_id);
        $data   = array();
        if (!empty($values)) {
            foreach ($values as $users) {
                $row        = array();
                $user_id    = $users->user_id;
                $row[]      = $users->user_first_name;
                $row[]      = $users->user_last_name;
                $row[]      = $users->user_email;
                $row[]      = $users->user_group_name;
                /*$actionTxtDisble='';
                $actionTxtEnable='';
                $actionTxtUpdate='';
                $actionTxtDelete='';
                $actionTxtPw='';
                $actionTxtUpdate='<a data-toggle="modal" href="'.base_url('users/create_user').'/'.$users->user_id.'" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit customers"><i class="glyphicon fa fa-edit"></i></a> &nbsp;';
                if($users->user_status==1){
                $actionTxtDisble = '<a class="btn btn-xs btn-green tooltips" data-placement="top" data-original-title="Disable customer" onClick="disableUserData('.$users->user_id.')"><i class="glyphicon fa fa-check"></i></a> &nbsp;';
                }
                
                $actionTxtPw = '<a class="btn btn-xs btn-warning tooltips" data-placement="top" data-original-title="Disable customer" href="'.base_url('users/user_change_pw').'/'.$users->user_id.'" ><i class="fa fa-pencil"></i></a> &nbsp;';
                
                if($users->user_status==0){
                $actionTxtEnable = '<a class="btn btn-xs btn-warning tooltips" data-placement="top" data-original-title="Disable customer" onClick="enableUserData('.$users->user_id.')"><i class="glyphicon fa fa-minus-circle"></i></a> &nbsp;';
                }
                */
                $row_action = '<div class="btn-group text-left">
                            <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu pull-right">';
                if ($users->user_status == 1) {
                    $row_action .= ' <li><a style="cursor: pointer;" onClick="disableUserData(' . $users->user_id . ')"><i class="fa fa-check"></i> Disable User</a></li>';
                }
                if ($users->user_status == 0) {
                    $row_action .= ' <li><a style="cursor: pointer;" onClick="enableUserData(' . $users->user_id . ')"><i class="glyphicon fa fa-minus-circle"></i> Enable User</a></li>';
                }
                $row_action .= '                          
                             <li><a href="' . base_url() . 'users/create_user/' . $user_id . '"><i class="fa fa-edit"></i> Edit User</a></li>
                                <li class="divider"></li>
                            
                             <li><a href="' . base_url() . 'users/user_change_pw/' . $user_id . '"><i class="fa fa-pencil"></i> Change Password</a></li>
                            <li class="divider"></li>
                             <li><a style="cursor: pointer;" onClick="deleteUserData(' . $users->user_id . ')"><i class="fa fa-trash-o"></i> Delete Customer</a></li>
                            </ul></div>';
                $row[]  = $row_action;
                //$row[]=$actionTxtUpdate.$actionTxtDisble.$actionTxtEnable.$actionTxtPw.$actionTxtDelete;
                $data[] = $row;
            }
            $output = array(
                'data' => $data
            );
            echo json_encode($output);
        } else {
            $output = array(
                'data' => ''
            );
            echo json_encode($output);
        }
    }
    public function user_change_pw_submit()
    {
        $user_id = $this->input->post('user_id');
        $this->load->library('form_validation'); //form validation lib
        // $this->form_validation->set_rules('user_password', 'Password', 'required');
        // $this->form_validation->set_rules('user_password_again', ' Confirm Password', 'required');
        $this->form_validation->set_rules('user_password', 'Password', 'required|min_length[8]|matches[user_password_again]');
        $this->form_validation->set_rules('user_password_again', 'Password Confirmation', 'required|min_length[8]');
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'status' => 0,
                'validation' => validation_errors()
            );
            echo json_encode($st);
        } else {
            $user_password      = $this->input->post('user_password');
            $user_password_send = hash('sha512', $user_password);
            $user_data          = array(
                'user_password' => $user_password_send
            );
            if ($this->User_Model->save_user($user_data, $user_id)) {
                $st = array(
                    'status' => 1,
                    'validation' => 'Done!'
                );
                echo json_encode($st);
            } else {
                $st = array(
                    'status' => 0,
                    'validation' => 'error occurred please contact your system administrator',
                    'type' => $type
                );
                echo json_encode($st);
            }
        }
    }
    function user_change_pw()
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'user_change_pw';
        $user_id                = $this->uri->segment('3');
        if (isset($user_id)) {
            $user_id = $user_id;
        } else {
            $user_id = '';
        }
        $data['user_id'] = $user_id;
        $this->load->view('user_change_pw', $data);
    }
    function delete_user()
    {
        $user_id = $this->input->post('user_id');
        $this->User_Model->delete_user($user_id);
        if ($user_id) {
            echo json_encode(array(
                'id' => $user_id
            ));
        } else {
            echo json_encode(array(
                'status' => 'error'
            ));
        }
    }
    function disable_user()
    {
        $user_id = $this->input->post('user_id');
        $this->User_Model->disable_user($user_id);
        if ($user_id) {
            echo json_encode(array(
                'id' => $user_id
            ));
        } else {
            echo json_encode(array(
                'status' => 'error'
            ));
        }
    }
    function enable_user()
    {
        $user_id = $this->input->post('user_id');
        $this->User_Model->enable_user($user_id);
        if ($user_id) {
            echo json_encode(array(
                'id' => $user_id
            ));
        } else {
            echo json_encode(array(
                'status' => 'error'
            ));
        }
    }
}