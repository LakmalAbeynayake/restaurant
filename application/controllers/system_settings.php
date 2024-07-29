<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_Settings extends CI_Controller {

    var $main_menu_name = "settings";
	var $sub_menu_name = "system_settings";

    public function __construct(){
        parent::__construct();
        $this->load->model('Common_Model');
    }
	public function index()
	{
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = $this->sub_menu_name;
        $this->load->view('system_settings',$data);
	}
	
	function add_menu(){
	    $data['main_menu_name']="common";
	    $data['sub_menu_name']="add_page";
	    $data['menu_list'] = $this->Common_Model->list_menu();
        $this->load->view('common/add_menu', $data);
	}
	
	function save_menu(){
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('menu_name', 'Menu Name', 'required');
        $this->form_validation->set_rules('menu_display_name', 'Product Display Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'status' => 0,
                'validation' => validation_errors()
            );
            echo json_encode($st);
        } else {
            $menu_name = $this->input->post('menu_name');
            $menu_display_name = $this->input->post('menu_display_name');
            $menu_parent_id = $this->input->post('menu_parent_id');
            $menu_url = $this->input->post('menu_url');
            $menu_status = $this->input->post('menu_status');
            
            $pd = array(
                'menu_name' => $menu_name,
                'menu_display_name' => $menu_display_name,
                'menu_parent_id' => $menu_parent_id,
                'menu_url' => $menu_url,
                'menu_status' => $menu_status
            );

            $last_id    = $this->Common_Model->save_menu($pd);
            
            // permission allocation
            if($last_id){
                $gpt = $this->get_permission_types();
                $ugp = $this->get_user_groups();
                
                foreach($ugp as $rugp){
                    $prm = 0;
                    if($rugp['user_group_id'] == 1)$prm = 1;
                    $rule = array(
                        'menu_id' => $last_id,
                        'group_id' => $rugp['user_group_id'],
                        'has_permission' => $prm
                    );
                    $this->add_rule($rule);
                }
            }
            // end permission allocation
            if ($last_id) {
                $st = array(
                    'status' => 1,
                    'validation' => 'Done!',
                    'last_id' => $last_id
                );
                echo json_encode($st);
            } else {
                $st = array(
                    'status' => 0,
                    'validation' => 'error occurred please contact your system administrator'
                );
                echo json_encode($st);
            }
        }
    }
    
    function get_permission_types(){
        $this->db->select('*');
        $this->db->where("usrgp_permission_name != \"\"");
 		$nav_sub = $this->db->get('user_group_permission');
 		return $nav_sub->result_array();
    }
    
    function add_rule($rule_data)
	{
		if ($rule_data)
		{
			if($this->db->insert("permission_allocation",$rule_data))
			{
				return $this->db->insert_id();
			}else return 0;
		}
	}
	
    function update_rule($where,$per_data)
	{
		if ($where)
		{
		    $this->db->where($where);
		    if($this->db->update('permission_allocation',$per_data)){
		        return 1;
		    }else return 0;
		}else return 0;
	}
    
    public function get_user_groups()
	 {
		$this->db->select('*');
		$this->db->order_by("user_group_id", "asc");
		$query = $this->db->get("user_group");
		return $query->result_array(); 
	 }
}