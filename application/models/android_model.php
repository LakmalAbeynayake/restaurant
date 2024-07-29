<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Android_Model extends CI_Model
{
    private $tableName = 'sales';
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }

   function get_products_suggestions($term,$vh_id)
    {
        $this->db->select('product' . '.*');
        $this->db->order_by("product_name", "asc");
		$this->db->load('vehicles','loaded_items.vh_id = vehicles.vh_id)');
        //$this->db->where("product_name LIKE '%$term%'");
        $this->db->where("product_name LIKE '%$term%' OR product_code LIKE '%$term%' OR product_oem_part_number LIKE '%$term%' OR product_part_no LIKE '%$term%'");
        $this->db->where("loaded_items",$vh_id);
		$this->db->limit(10, 0);
        $query = $this->db->get('product');
        return $query->result_array();
    }
}