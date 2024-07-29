
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Table_management extends CI_Controller
{
    
    var $main_menu_name = "table_management";
    var $sub_menu_name = "";
        
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pos_model');
        $this->load->model('table_mgmt_model');
        date_default_timezone_set("Asia/Colombo");
    }
    public function index()
    {
        $data['main_menu_name'] = $this->main_menu_name;
	$data['sub_menu_name'] = $this->sub_menu_name;
        if($_GET){
            echo 'get';
        $floor_id = $this->input->get('floor_id');
        $division_id = $this->input->get('division_id');
        $floor_id = isset($floor_id)?$floor_id:"";
        $division_id = isset($division_id)?$division_id:"";
        }else{
            $result = $this->table_mgmt_model->get_parameter();
//            if($result){
                $division_id = @$result['division_id']?$result['division_id']:"";
                $floor_id = @$result['floor_id']?$result['floor_id']:"";
                //echo $division_id .'ddd '.$floor_id;
//            }else{
//                
//            }
            //echo 'mm';
        }
        echo 'lllll'.$floor_id;
        
        $data['floor_id'] = $floor_id;
        $data['division_id'] = $division_id;
        
        $data['divisions_info'] = $this->table_mgmt_model->get_divisions_byid($division_id);
        $data['floors_info'] = $this->table_mgmt_model->get_floors_byid($floor_id);
        $data['table_count'] = $this->table_mgmt_model->get_table_count($floor_id,$division_id);
        
        
        $data['divisions'] = $this->table_mgmt_model->get_divisions($floor_id);
        $data['floors'] = $this->table_mgmt_model->get_floors();
//        print_r(sizeof($data['divisions']));
//        if(sizeof($data['divisions']) > 0){
//            $divid = $data['divisions']['division_id'];
//        }else{
//            $divid = '';
//        }
        $data['table_data'] = $this->table_mgmt_model->get_table(1);
        
        $this->load->view('restaurant/table_management_v10' , $data);
    }
    public function add_table()
    {
        $data['id'] = 1;
        $data['table_cat'] = $this->table_mgmt_model->get_table_cat();
        $this->load->view('models/create_table',$data);
    }
    
    public function table_save(){
        $this->load->library('form_validation'); //form validation lib
        $this->load->helper('form');
        $this->form_validation->set_rules('num_of_chairs', 'Number Of Chairs', 'required');
        $division_id = $this->input->post('division_id');
        $floor_id = $this->input->post('floor_id');
        $max_id = $this->table_mgmt_model->max_table($division_id,$floor_id);
        $max_id = $max_id + 1;
        
        $table_name = 'TB'.$max_id;
        $table_name_view = 'Table '.$max_id;
        if(isset($floor_id)){
            $table_name = $table_name.'F'.$floor_id;
        }
        if(isset($division_id)){
            $table_name = $table_name.'D'.$division_id;
        }
//        $this->form_validation->set_rules('cat_name', 'Category Name', 'required');

//        if ($this->form_validation->run() == FALSE)
//        {
//           $st = array('status' =>0,'validation' => '');
//           echo json_encode($st);
//        }
//        else
//        {
            if ($this->table_mgmt_model->table_save($this->input->post('division_id'), $this->input->post('floor_id'),$this->input->post('num_of_chairs'),2,$this->input->post('position'),$table_name,$this->input->post('table_name_view'))) {

                       $st = array('status' =>1,'validation' =>'Done!');
                       echo json_encode($st);

               } else {

                       $st = array('status' =>0,'validation' =>'error occurred please contact your system administrator');
                       echo json_encode($st);
               }
//        }
    }
    
    public function delete_table(){
        $tableid = $this->input->post('tableid');
        $status = $this->table_mgmt_model->remove_table($tableid);
        echo json_encode($status);
    }
    
    public function get_division_byid(){
        $floor_id = $this->input->post('floor_id');
        $floors = $this->table_mgmt_model->get_division_byid($floor_id);
        if($floors){
            $tables = $this->table_mgmt_model->get_division_byid($floor_id);
        }
        echo json_encode($floors);
    }
    
    public function get_table_byid_ajax(){
        $tableid = $this->input->post('table_id');
        $table_info = $this->table_mgmt_model->ge_table_byid_info($tableid);
        echo json_encode($table_info);
    }
    
    public function table_update(){
        $position = $this->input->post('position');
        $tid = $this->input->post('tbid');
        $position = $this->table_mgmt_model->update_table($position,$tid);
    }
    
}