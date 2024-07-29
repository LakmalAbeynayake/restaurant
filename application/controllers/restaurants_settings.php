<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Restaurants_settings extends CI_Controller {

    var $main_menu_name = "restaurant_setting";
    var $sub_menu_name = "dashboard";

    public function __construct() {
        parent::__construct();
        $this->load->model('restaurants_setting_model');
        $this->load->model('floor_model');
        $this->load->model('Common_Model');
        $this->load->model('division_model');
        date_default_timezone_set("Asia/Colombo");
    }

    public function index() {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = $this->sub_menu_name;

        $this->load->view('restaurant/dashboard', $data);
    }
    
    public function floors(){
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'floor';
        $this->load->view('restaurant/floors', $data);
    }
    
    public function getFloors(){
        $values = $this->restaurants_setting_model->get_floors();
        if (!empty($values)) {
            foreach ($values as $floor) {

            if ($floor->floor_status == 0) {$k = "btn-warning";$m = "fa-minus-circle";} else {$k = "btn-green";$m = "fa-check";}
            
            $row = array();
                $row[] = $floor->floor_id;
                $row[] = strtoupper($floor->floor_name);
                $row[] = $floor->floor_description;
                $row[] = '<a class="btn btn-xs btn-blue" href="'.base_url()."system_settings/subcategories/".$floor->floor_id.'" data-toggle="modal"><i class="glyphicon fa fa-list"></i></a> <a class="btn btn-xs btn-blue" href="#" data-toggle="modal" onclick="category_edit('.$floor->floor_id.')"><i class="glyphicon fa fa-edit"></i></a>
                <a class="btn btn-xs '.$k.'" href="#" data-toggle="modal" onclick="change_status('.$floor->floor_id.','.$floor->floor_id.')"><i class="glyphicon fa '.$m.'"></i></a>
                <a class="btn btn-xs btn-bricky" href="#" data-toggle="modal" onclick="perm_delete('.$floor->floor_id.')"><i class="glyphicon fa fa-trash-o"></i></a>';
                $data[] = $row;
            }

            $output = array('data' =>$data);
            echo json_encode($output);
        }else{
            $output = array('data' =>'');
            echo json_encode($output);

        }
    }
    public function add_floor()
    {
        $data['id'] = 1;
        $this->load->view('models/create_floor',$data);
    }
    
    public function update_floor(){
        
       

               if ($this->floor_model->floor_update($this->input->post('floor_name') ,$this->input->post('description'),'ACT')) {

                       $st = array('status' =>1,'validation' =>'Done!');
                       echo json_encode($st);

               } else {

                       $st = array('status' =>0,'validation' =>'error occurred please contact your system administrator');
                       echo json_encode($st);
               }
        
    }
    
    public function save_floor(){
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('floor_name', 'Floor Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');

        if ($this->form_validation->run() == FALSE)
        {
           $st = array('status' =>0,'validation' => validation_errors());
           echo json_encode($st);
        }
        else
        {
          

               if ($this->floor_model->floor_save($this->input->post('floor_name'), $this->input->post('description'),'ACT')) {

                       $st = array('status' =>1,'validation' =>'Done!');
                       echo json_encode($st);

               } else {

                       $st = array('status' =>0,'validation' =>'error occurred please contact your system administrator');
                       echo json_encode($st);
               }
//          }
          

        }
    }
    
    public function floor_permanent_delete()
    {
           if($this->floor_model->floor_permanent_delete($this->input->post('floor_id'))) {

                   $st = array('status' =>1,'validation' =>'Done!');
                   echo json_encode($st);

           }else {

                   $st = array('status' =>0,'validation' =>'cannot delete parent category with children categorys existing');
                   echo json_encode($st);
           }
    }
    
    public function division(){
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'division';
        $this->load->view('restaurant/division_list', $data);
    }
    
    public function getDivisions(){
        $values = $this->restaurants_setting_model->get_divisions();
        if (!empty($values)) {
            foreach ($values as $div) {

            if ($div->div_status == 'ACT') {$k = "btn-warning";$m = "fa-minus-circle";} else {$k = "btn-green";$m = "fa-check";}
            
            $row = array();
                $row[] = $div->division_id;
                $row[] = $div->div_name;
                $row[] = strtoupper($div->floor_name);
                $row[] = $div->div_description;
                if($div->div_status == 'ACT'){
                    $row[] = '<span class="label label-success">active</span>';
                }else{
                    $row[] = '<span class="label label-warning">deactive</span>';
                }
                
                $row[] = ' <a class="btn btn-xs btn-blue" href="#" title="edit" data-toggle="modal" onclick="division_edit('.$div->division_id.')"><i class="glyphicon fa fa-edit"></i></a>
                <a class="btn btn-xs '.$k.'" href="#" data-toggle="modal" title="Change Status" onclick=change_status('.$div->division_id.',"'.$div->div_status.'")><i class="glyphicon fa '.$m.'"></i></a>
                <a class="btn btn-xs btn-bricky" href="#" title="delete" data-toggle="modal" onclick="perm_delete('.$div->division_id.')"><i class="glyphicon fa fa-trash-o"></i></a>';
                $data[] = $row;
            }

            $output = array('data' =>$data);
            echo json_encode($output);
        }else{
            $output = array('data' =>'');
            echo json_encode($output);

        }
    }
    
    public function add_division(){
        $data['id'] = 1;
        $data['floors'] = $this->restaurants_setting_model->get_floors();
        $this->load->view('models/create_division',$data);
    }
    
    public function update_division(){
        if ($this->division_model->division_update($this->input->post('division_id'),$this->input->post('floor_id'),$this->input->post('division_name') ,$this->input->post('description'),$this->input->post('division_status'))) {

                       $st = array('status' =>1,'validation' =>'Done!');
                       echo json_encode($st);

               } else {

                       $st = array('status' =>0,'validation' =>'error occurred please contact your system administrator');
                       echo json_encode($st);
               }
    }
    
    public function save_division(){
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('floor_id', 'Floor Id', 'required');
        $this->form_validation->set_rules('division_name', 'Division Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');

        if ($this->form_validation->run() == FALSE)
        {
           $st = array('status' =>0,'validation' => validation_errors());
           echo json_encode($st);
        }
        else
        {
          

               if ($this->division_model->division_save($this->input->post('floor_id'), $this->input->post('division_name'), $this->input->post('description'),'ACT')) {

                       $st = array('status' =>1,'validation' =>'Done!');
                       echo json_encode($st);

               } else {

                       $st = array('status' =>0,'validation' =>'error occurred please contact your system administrator');
                       echo json_encode($st);
               }
//          }
          

        }
    }
    
    public function edit_division($division_id){
        $data['floors'] = $this->restaurants_setting_model->get_floors();
        $data['division_details'] = $this->division_model->getDivison_by_id($division_id);
        $this->load->view('models/create_division',$data);
    }
    
    public function division_permanent_delete()
    {
           if($this->division_model->division_permanent_delete($this->input->post('division_id'))) {

                   $st = array('status' =>1,'validation' =>'Done!');
                   echo json_encode($st);

           }else {

                   $st = array('status' =>0,'validation' =>'error occurred please contact your system administrator');
                   echo json_encode($st);
           }
    }
    
    public function division_change_status(){
        if($this->division_model->division_change_status($this->input->post('division_id'),$this->input->post('status'))) {

                   $st = array('status' =>1,'validation' =>'Done!');
                   echo json_encode($st);

           }else {

                   $st = array('status' =>0,'validation' =>'error occurred please contact your system administrator');
                   echo json_encode($st);
           }
    }
    
    public function tables(){
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'floor';
        $this->load->view('restaurant/tables', $data);
    }
    
    public function getTables(){
        $values = $this->restaurants_setting_model->get_tables();
        if (!empty($values)) {
            foreach ($values as $floor) {

            if ($floor->floor_status == 0) {$k = "btn-warning";$m = "fa-minus-circle";} else {$k = "btn-green";$m = "fa-check";}
            
            $row = array();
                $row[] = $floor->floor_id;
                $row[] = strtoupper($floor->floor_name);
                $row[] = $floor->floor_description;
                $row[] = '<a class="btn btn-xs btn-blue" href="'.base_url()."system_settings/subcategories/".$floor->floor_id.'" data-toggle="modal"><i class="glyphicon fa fa-list"></i></a> <a class="btn btn-xs btn-blue" href="#" data-toggle="modal" onclick="category_edit('.$floor->floor_id.')"><i class="glyphicon fa fa-edit"></i></a>
                <a class="btn btn-xs '.$k.'" href="#" data-toggle="modal" onclick="change_status('.$floor->floor_id.','.$floor->floor_id.')"><i class="glyphicon fa '.$m.'"></i></a>
                <a class="btn btn-xs btn-bricky" href="#" data-toggle="modal" onclick="perm_delete('.$floor->floor_id.')"><i class="glyphicon fa fa-trash-o"></i></a>';
                $data[] = $row;
            }

            $output = array('data' =>$data);
            echo json_encode($output);
        }else{
            $output = array('data' =>'');
            echo json_encode($output);

        }
    }
    
    
}
