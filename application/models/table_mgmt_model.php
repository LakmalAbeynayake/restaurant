<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class table_mgmt_model extends CI_Model {

    function __construct() {
        /* Call the Model constructor */
        parent::__construct();
    }
    
    
    public function get_divisions($floor_id){
        $this->db->where('floor_id',$floor_id);
        $this->db->where('div_status','ACT');
        $query = $this->db->get('divisions');
        return $query->result('array');
    }
    
    public function get_floors(){
//        $this->db->where('floor_id',$floor_id);
        $query = $this->db->get('floor');
        return $query->result('array');
    }
    
    public function get_table_cat(){
        $query = $this->db->get('table_category');
        return $query->result('array');
    }
    
    public function table_save($division_id='', $floor_id='', $num_of_chairs='', $table_cat='', $position='',$table_name='',$table_name_view=''){
        $data = array(
            'table_cat_id' => $table_cat,
            'division_id' => $division_id,
            'floor_id' => $floor_id,
            'num_of_chairs' => $num_of_chairs,
            'table_position' => $position,
            'description' => $table_name,
            'table_status' => 'ACT',
            'table_name' => $table_name_view
        );
        if($this->db->insert('tables', $data)){
            return  true;
        }else{
            return false;
        }
    }
    
    public function get_table($divid){
        $this->db->where('division_id',$divid);
        $query = $this->db->get('tables');
        return $query->result('array');
    }
    
    public function get_tables(){
        $this->db->select('tables.*,table_booking.reservation_status');
        $this->db->from('tables');
        $this->db->join('table_booking','table_booking.table_id=tables.table_id', 'left outer');
        //$this->db->where('table_booking.reservation_status !=','RES');
        $query = $this->db->get();
        return $query->result('array');
    }
    
    public function ge_table_by_position($divid,$floor_id,$division_id){
        //echo $division_id;
        $this->db->select('tables.*,tables.table_id AS id_of_table,table_booking.*');
        $this->db->from('tables');
        $this->db->join('table_booking','table_booking.table_id=tables.table_id', 'left outer');
        $this->db->where('table_position',$divid);
        if($floor_id!= null){
            $this->db->where('floor_id',$floor_id);
        }
        if($division_id!= null){
            $this->db->where('division_id',$division_id);
        }
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function ge_table_byid($table_id){
        $this->db->where('table_id',$table_id);
        $query = $this->db->get('tables');
        return $query->row_array();
    }
    
    public function remove_table($tableid){
        $this->db->where('table_id',$tableid);
        if($this->db->delete('tables')){
            return  true;
        }else{
            return false;
        }
    }
    
    public function get_division_byid($floor_id){
        $this->db->where('floor_id',$floor_id);
        $query = $this->db->get('divisions');
//        return $query->row_array();
        if($query->num_rows() > 0){
            return $query->result();
        }  else {
            return false;
        }
    }
    
    public function get_parameter(){
        $this->db->select('floor_id,division_id');
        $this->db->limit(1);
        $query = $this->db->get('divisions');
        
        if($query->num_rows()>0){
            return $query->first_row('array');
        }  else {
            $this->db->select('floor_id');
            $this->db->limit(1);
            $query = $this->db->get('floor');
            return $query->first_row('array');
        }
    }
    
    public function table_booking($dable_data){
        $this->db->insert('table_booking' ,$dable_data);
    }
    
    public function max_table($division_id,$floor_id){
        $this->db->select('tables.table_id AS id_of_table');
        $this->db->from('tables');
//        $this->db->where('floor_id',$floor_id);
//        $this->db->where('division_id',$division_id);
        $this->db->order_by('table_id','DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array()['id_of_table'];
        }else{
            return 0;
        }
        
    }
    
    public function get_divisions_byid($division_id){
        $this->db->where('division_id',$division_id);
        $query = $this->db->get('divisions');
        return $query->row_array();
    }
    
    public function get_floors_byid($floor_id){
        $this->db->where('floor_id',$floor_id);
        $query = $this->db->get('floor');
        return $query->row_array();
    }
    
    public function get_table_count($floor_id,$division_id){
        $this->db->select('count(table_id) AS count');
        $this->db->from('tables');
        if($floor_id!= null){
            $this->db->where('floor_id',$floor_id);
        }
        if($division_id!= null){
            $this->db->where('division_id',$division_id);
        }
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function ge_table_byid_info($table_id){
        $this->db->select('tables.*,table_booking.*,customer.cus_name');
        $this->db->from('tables');
        $this->db->join('table_booking','table_booking.table_id=tables.table_id', 'left outer');
        $this->db->join('sales','sales.sale_id=table_booking.sale_id', 'left outer');
        $this->db->join('customer','customer.cus_id=sales.customer_id', 'left outer');
        $this->db->where('tables.table_id',$table_id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function update_table($position,$tid){
        $this->db->where('table_id',$tid);
        $data = array(
            'table_position'=> $position
        );
        $this->db->update('tables',$data);
    }
    
}
