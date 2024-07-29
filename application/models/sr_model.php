<?php
if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}
class Sr_Model extends CI_Model
{
    private $tableName = "stock_requisitions";
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
    //Sales best for dashboard
    function getBestSales($year = null, $month = 0, $from = 0, $to = 0)
    {
        $this->db->select("SUM(ft.fi_qty)AS fi_qty_tot,p.product_name,p.product_code,p.product_part_no,p.product_oem_part_number");
        $this->db->from("fi_table ft");
        $this->db->join("product p", "ft.fi_item_id = p.product_id", "left");
        $this->db->where("ft.fi_type_id", "sale");
        if ($month) {
            $this->db->where("MONTH(ft.fi_date_time)", $month, false);
        }
        if ($year) {
            $this->db->where("YEAR(ft.fi_date_time)", $year, false);
        }
        if ($to) {
            $this->db->limit($to, $from);
        }
        $this->db->order_by("fi_qty_tot", "desc");
        $this->db->group_by("ft.fi_item_id");
        $query = $this->db->get();
        return $query->result();
    }
    //Sales genarate referance number
    function get_next_ref_no()
    {
        $this->db->select_max("qts_id");
        return $this->db->get("stock_requisitions");
    }
    //Sales get avalable product qty
    function get_avalable_product_qty($product_id, $warehouse_id)
    {
        $this->db->select_sum("fi_qty");
        $query = $this->db->get("fi_table");
        return $query->row()->fi_qty;
    }
    //Sales get information
    public function get_sr_info($id)
    {
        $this->db->select("*");
        $this->db->from("stock_requisitions");
        $this->db->where("req_id", $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    //Sales item list get by id
    public function get_sr_item_list_by_sr_id($qts_id)
    {
        $this->db->select("stock_requisition_items.product_id, product.product_name, product.product_code, stock_requisition_items.quantity");
        $this->db->from("stock_requisition_items");
        $this->db->join("product", "stock_requisition_items.product_id = product.product_id", "left");
        $this->db->order_by("stock_requisition_items.id", "desc");
        $this->db->where("stock_requisition_items.req_id", $qts_id); //("id !=",$id);
        $query = $this->db->get();
        return $query->result_array();
    }
    //Sales save
    function save_stock_requisitions(&$supplier_data, $qts_id = false)
    {
        if (!$qts_id) {
            $this->db->insert($this->tableName, $supplier_data);
        } else {
            $this->db->where("qts_id", $qts_id);
            return $this->db->update($this->tableName, $supplier_data);
        }
    }
    //Sales item save
    function save_stock_requisitions_item(&$data_item)
    {
        $this->db->insert("stock_requisition_items", $data_item);
    }
    //Sales get for report
    function get_all_stock_requisitions_for_report($srh_warehouse_id = "", $srh_to_date = "", $srh_from_date = "", $qts_id = "", $from = "", $to = "")
    {
        $this->db->select("s.* , c.cus_name");
        $this->db->from("stock_requisitions s");
        $this->db->join("customer c", "s.customer_id = c.cus_id", "left");
        $this->db->order_by("s.qts_id", "desc");
        $this->db->group_by("s.qts_id");
        if ($srh_warehouse_id) {
            $this->db->where("s.warehouse_id", $srh_warehouse_id); //("id !=",$id);
        }
        if ($srh_to_date) {
            $this->db->where("s.qts_datetime <=", $srh_to_date); //("id !=",$id);
        }
        if ($srh_from_date) {
            $this->db->where("s.qts_datetime >=", $srh_from_date); //("id !=",$id);
        }
        if ($qts_id) {
            $this->db->where("s.qts_id =", $qts_id); //("id !=",$id);
        }
        if ($to) {
            $this->db->limit($to, $from);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    //Sales all get
    function get_all_stock_requisitions()
    {
        $this->db->select("stock_requisitions.*");
        $this->db->from("stock_requisitions");
        $this->db->order_by("stock_requisitions.req_id", "desc");
        //$this->db->where("stock_requisitions.qts_id IS NOT NULL"); //("id !=",$id);
        //$this->db->where("stock_requisitions.qutation_status",1);
        $query = $this->db->get();
        return $query->result_array();
    }
    //Sales get for print
    function get_all_stock_requisitions_for_print_stock_requisitions()
    {
        $this->db->select("s.* , c.cus_name ");
        $this->db->from("stock_requisitions s");
        $this->db->join("customer c", "s.customer_id = c.cus_id", "left");
        $this->db->order_by("s.qts_id", "desc");
        $this->db->group_by("s.qts_id");
        $this->db->where("s.qts_id IS NOT NULL"); //("id !=",$id);
        $query = $this->db->get();
        return $query->result_array();
    }
    //Get product sujetions
    function get_products_suggestions($term)
    {
        $this->db->select("product" . ".*");
        $this->db->order_by("product_name", "asc");
        //$this->db->where("product_name LIKE '%$term%'");
        $this->db->where("product_name LIKE '%$term%' OR product_code LIKE '%$term%' OR product_oem_part_number LIKE '%$term%' OR product_part_no LIKE '%$term%'");
        $this->db->limit(10, 0);
        $query = $this->db->get("product");
        //echo $this->db->last_query();
        return $query->result_array();
    }
    //Get all products
    function get_all_products()
    {
        $this->db->select("product" . ".*");
        $this->db->order_by("product_name", "asc");
        $this->db->where("product_id IS NOT NULL"); //("id !=",$id);
        $query = $this->db->get("product");
        return $query->result_array();
    }
     function update_stock_requisitions($id, $data)
    {
        if ($id>0) {
           $this->db->where("qts_id", $id);
            return $this->db->update($this->tableName, $data);
        } else {
            return false;
        }
    }
}