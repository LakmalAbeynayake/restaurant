<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Warehouse_Model extends CI_Model
{
    private $tableName = 'locations';
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
    function save_warehouse(&$warehouse_data, $warehouse_id = false)
    {
        if (!$warehouse_id) {
            $this->db->insert($this->tableName, $warehouse_data);
        } else {
            $this->db->where('id', $warehouse_id);
            return $this->db->update($this->tableName, $warehouse_data);
        }
    }
    function get_all_warehouse()
    {
        $this->db->select($this->tableName . '.*');
        $this->db->order_by("id", "asc");
        $this->db->where("id IS NOT NULL"); //("id !=",$id);
        $query = $this->db->get($this->tableName);
        return $query->result();
    }
    public function get_warehouse_info($id)
    {
        $this->db->select('*');
        $this->db->from($this->tableName);
        $this->db->where("id", $id);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->row_array();
    }
    public function delete_warehouse($warehouse_id)
    {
        $this->db->where('id', $warehouse_id);
        $this->db->delete($this->tableName);
    }
    public function disable_warehouse($warehouse_id)
    {
        $data = array(
            'status' => 0
        );
        $this->db->where('id', $warehouse_id);
        $this->db->update($this->tableName, $data);
    }
    public function enable_warehouse($warehouse_id)
    {
        $data = array(
            'status' => 1
        );
        $this->db->where('id', $warehouse_id);
        $this->db->update($this->tableName, $data);
    }
}