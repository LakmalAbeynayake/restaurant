<?php
class Prn_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        //$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }
    function save_prn($data, $grn_id = false)
    {
        if (!$grn_id) {
            if($this->db->insert('prn', $data)){
                return $this->db->insert_id();
            }else{
                return 0;
            } 
        } else {
            $this->db->where('prn_id', $grn_id);
            $this->db->update('prn', $data);
            return $this->db->affected_rows();
        }
    }
    
    function save_prn_items($data_item)
    {
        $this->db->insert_batch('prn_items', $data_item);
        return $this->db->affected_rows();
    }
    
    public function get_grns($location_id="")
    {
        $this->db->select("grn.*,locations.name");
        $this->db->from("grn");
        $this->db->join("locations","locations.id = grn.receiver_location_id","left");
        if($location_id){
            $this->db->where("receiver_location_id", $location_id);
        }
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_grn_info($purchase_id){
        $this->db->select('*');
        $this->db->from('grn');
        $this->db->where('grn_id', $purchase_id);
        $query = $this->db->get();
        return $query->row();
    }
    function is_approved($grn_id){
        $this->db->select('approval_status');
        $this->db->from('grn');
        $this->db->where('grn_id', $grn_id);
        $query = $this->db->get();
        return $query->row()->approval_status ? false: true;
        //approval_status == 0 == false; return true; true means "not approved yet. so good to continue the approval process"
    }
    function get_grn_items($grn_id){
        $this->db->select('gi.*,p.product_name,p.product_code');
        $this->db->from('grn_items gi');
        $this->db->join('product p','p.product_id = gi.product_id','left');
        $this->db->where('gi.grn_id', $grn_id);
        $query = $this->db->get();
        return $query->result();
    }
    /**/
    function approve($purchase_id){
        $data = array(
            'approved_by' => $this->session->userdata('ss_user_id'),
            'approved_on' => date('Y-m-d H:i:s'),
            'approval_status' => 1
        );
        $this->db->where('grn_id', $purchase_id);
        $this->db->update('grn', $data);
        return $this->db->affected_rows();
    }
}