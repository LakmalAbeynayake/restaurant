<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class User_Groups extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_Model');
        $this->load->model('Common_Model');
        $this->load->model('User_Group_Model');
    }
    var $main_menu_name = "settings";
    var $sub_menu_name = "user_groups";
    public function index()
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = $this->sub_menu_name;
        $this->load->view('users/groups', $data);
    }
    public function permissions()
    {
        $data['main_menu_name']                  = $this->main_menu_name;
        $data['sub_menu_name']                   = $this->sub_menu_name;
        $user_group_id=$this->uri->segment('3');
		
		$data['user_group_id']=$user_group_id;
		$data['user_group_permission_page_list'] = list_menu();
		$data['user_group_group_info']=$this->User_Group_Model->get_user_group_info_by_id($user_group_id);
		
        $this->load->view('users/groups_permissions', $data);
    }
    public function save_user_group_permissions()
    {
        //print_r($_REQUEST);
        $user_group_id                           = $this->input->post('user_group_id');
        $data['user_group_permission_page_list'] = $this->User_Group_Model->get_user_group_permission_page_list_by_group_id($user_group_id);
        foreach ($data['user_group_permission_page_list'] as $row) {
            $rowname_view   = 'row_view_' . $row['user_group_permission_page_name'];
            $rowname_add    = 'row_add_' . $row['user_group_permission_page_name'];
            $rowname_edit   = 'row_edit_' . $row['user_group_permission_page_name'];
            $rowname_delete = 'row_delete_' . $row['user_group_permission_page_name'];
            $per_data       = array(
                'usrgp_permission_view' => $this->input->post($rowname_view),
                'usrgp_permission_add' => $this->input->post($rowname_add),
                'usrgp_permission_edit' => $this->input->post($rowname_edit),
                'usrgp_permission_delete' => $this->input->post($rowname_delete)
            );
            $this->User_Group_Model->change_user_group_permission_details_view_by_page($per_data, $row['user_group_permission_page_name'], $user_group_id);
        }
        $st = array(
            'status' => 1,
            'validation' => 'Done!'
        );
        echo json_encode($st);
    }
    public function get_list_user_group($value = '')
    {
        $values = $this->User_Group_Model->get_all_user_group_list();
        $data   = array();
        if (!empty($values)) {
            foreach ($values as $users) {
                $row             = array();
                $row[]           = $users->user_group_id;
                $row[]           = $users->user_group_name;
                $actionTxtDisble = '';
                $actionTxtEnable = '';
                $actionTxtUpdate = '';
                $actionTxtDelete = '';
                $actionTxtUpdate = '<a data-toggle="modal" href="' . base_url('user_groups/permissions') . '/' . $users->user_group_id . '" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit 
Group Permissions"><i class="glyphicon fa fa-tasks"></i></a> &nbsp;';
                $row[]           = $actionTxtUpdate;
                $data[]          = $row;
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
    
    function save_user_group()
	{
	    $user_group_name=$this->input->post('user_group_name');
	    
		$this->load->library('form_validation'); //form validation lib
		$this->form_validation->set_rules('user_group_name', 'User Group Name', 'required|is_unique[customer.cus_code]');
		
		if ($this->form_validation->run() == FALSE)
        {
           $st = array('status' =>0,'validation' => validation_errors());
           echo json_encode($st);
        }
        else{
        	$data=array(
        		'user_group_name'=>$user_group_name,
        		'user_group_status' => 1
        	);
    		
    		$lastid=$this->save($data);
    		
    		if($lastid) {
    		    //  add rules start
    		  $menu= $this->Common_Model->list_menu();
              $gpt = $this->Common_Model->get_permission_types();
              $ugp = $this->Common_Model->get_user_groups();
            
                foreach($menu as $mnu){
                    foreach($gpt as $ugpt){
                        $prm = 0;
                        $rule = array(
                            'menu_id' => $mnu['menu_id'],
                            'group_id' => $lastid,
                            'gp_id' => $ugpt['usrgp_permission_id'],
                            'has_permission' => $prm
                        );
                        $this->Common_Model->add_rule($rule);
                    }
                }
    		  // end add rules
    		    echo json_encode(array('id'=>$lastid,'status' =>1));
    		} else {
                echo json_encode(array('status'=>'0'));
    		}
        }
	}
	function save($data){
		if ($data)
		{
			if($this->db->insert("user_group",$data))
			{
				return $this->db->insert_id();
			}else return 0;
		}
	}
}