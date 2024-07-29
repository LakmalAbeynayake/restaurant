<?php
class Gtn_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        //$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }
    function save_gtn($data, $gtn_id = false) 
    {
        if (!$gtn_id) {
            $this->db->insert('gtn', $data);
            return $this->db->insert_id();
        } else {
            $this->db->where('id', $gtn_id);
            $this->db->update('purchases', $data);
            return $this->db->affected_rows();
        }
    }
    
    function save_gtn_items($data_item)
    {
        $this->db->insert_batch('gtn_items', $data_item);
        return $this->db->affected_rows();
    }
    
    public function get_gtns()
    {
        $this->db->select("gtn.*,locations.name");
        $this->db->from("gtn");
        $this->db->join("locations","locations.id = gtn.receiver_location_id","left");
        $this->db->where("sender_location_id", $this->session->userdata('ss_warehouse_id'));
        $query = $this->db->get();
        return $query->result();
    }
    /*posplus session*/
    function get_purchase_info($purchase_id){
        $this->db->select('*');
        $this->db->from('purchases');
        $this->db->where('id', $purchase_id);
        $query = $this->db->get();
        return $query->row();
    }
    function is_approved($purchase_id){
        $this->db->select('approval_status');
        $this->db->from('purchases');
        $this->db->where('id', $purchase_id);
        $query = $this->db->get();
        return $query->row()->approval_status ? false: true;
        //approval_status == 0 == false; return true; true means "not approved yet. so good to continue the approval process"
    }
    function approve($gtn_id){
        $data = array(
            'approved_by' => $this->session->userdata('ss_user_id'),
            'approved_on' => date('Y-m-d H:i:s'),
            'approval_status' => 1
        );
        $this->db->where('gtn_id', $gtn_id);
        $this->db->update('gtn', $data);
        return $this->db->affected_rows();
    }
}