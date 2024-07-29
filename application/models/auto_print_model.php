<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class auto_print_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function check_juice_printables($cat_id = "", $sale_id = "")
    {
        $this->db->select_min('sale_items.sale_id');
        $this->db->from('sale_items');
        $this->db->join('product', 'product.product_id = sale_items.product_id');
        if (!$sale_id)
            $this->db->join('sales', 'sales.sale_id = sale_items.sale_id');
        $this->db->where('sale_items.print_status', 0);
        if ($cat_id) {
            $this->db->where('product.cat_id', $cat_id);
        }
        if ($sale_id) {
            $this->db->where('sale_items.sale_id ', $sale_id);
        } else {
            $this->db->where('sales.sale_type ', 'android_pos_sale');
        }
        $query = $this->db->get();
        return $query->row();
    }
    function check_kitchen_printables($cat_id = "", $sale_id = "")
    {
        $this->db->select_min('sale_items.sale_id');
        $this->db->from('sale_items');
        if (!$sale_id)
            $this->db->join('sales', 'sales.sale_id = sale_items.sale_id');
        $this->db->join('product', 'product.product_id = sale_items.product_id');
        $this->db->where('sale_items.print_status', 0);
        $this->db->where('date(sale_items.sale_datetime)', date("Y-m-d"));
        if ($cat_id) {
            $this->db->where('product.cat_id !=', $cat_id);
        }
        if ($sale_id) {
            $this->db->where('sale_items.sale_id ', $sale_id);
        } else {
            $this->db->where('sales.sale_type ', 'android_pos_sale');
        }
        $query = $this->db->get();
        return $query->row();
    }
    function check_n_get_minimum_sale_id_printable($sale_id = "")
    {
        $this->db->select_min('sale_items.sale_id');
        $this->db->from('sale_items');
        $this->db->join('product', 'product.product_id = sale_items.product_id');
        $this->db->where('sale_items.print_status', 0);
        $this->db->where('product.is_ko ', 1);
        if ($sale_id) {
            $this->db->where('sale_items.sale_id ', $sale_id);
        }
        $query = $this->db->get();
        return $query->row();
    }
    function check_kitchen_printables_by_is_ko($sale_id = "")
    {
        $this->db->select_min('sale_items.sale_id');
        $this->db->from('sale_items');
        if (!$sale_id)
            $this->db->join('sales', 'sales.sale_id = sale_items.sale_id');
        $this->db->join('product', 'product.product_id = sale_items.product_id');
        $this->db->where('sale_items.print_status', 0);
        $this->db->where('date(sale_items.sale_datetime)', date("Y-m-d"));
        $this->db->where('product.is_ko ', 1);
        if ($sale_id) {
            $this->db->where('sale_items.sale_id ', $sale_id);
        } /*else {
            $this->db->where('sales.sale_type ', 'android_pos_sale');
        }*/
        $query = $this->db->get();
        return $query->row();
    }
    function get_sale_print()
    {
        $this->db->select('sales.*');
        $this->db->from('sales');
        //$this->db->join('sale_items si');
        $this->db->where('print_status', '0');
        //$this->db->or_where('print_status','2');
        //$this->db->where('printable_status','0');
        $this->db->order_by('sale_id');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }
    function get_sale_info($sale_id)
    {
        $warehouse_id = '';
        $this->db->select('sale_id,customer_id,table_id,dine_type,continued,kitchen_note');
        $this->db->from('sales');
        $this->db->where("sale_id", $sale_id);
        $query = $this->db->get();
        return $query->row();
    }
    function get_pending_sale_item_list_by_sale_id($sale_id, $cat_id = "")
    {
        $this->db->select('sale_items.product_id, product.product_name, sale_items.quantity');
        $this->db->from('sale_items');
        $this->db->join('product', 'sale_items.product_id = product.product_id', 'left');
        $this->db->order_by("sale_items.id", "desc");
        if ($cat_id)
            $this->db->where('product.cat_id', $cat_id);
        if ($sale_id)
            $this->db->where("sale_items.sale_id", $sale_id);
        $this->db->where('print_status ', '0');
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_pending_sale_item_list_for_direct_kitchen($sale_id)
    {
        $this->db->select('sale_items.product_id, product.product_name, sale_items.quantity');
        $this->db->from('sale_items');
        $this->db->join('product', 'sale_items.product_id = product.product_id', 'left');
        $this->db->order_by("sale_items.id", "desc");
        if ($sale_id)
            $this->db->where("sale_items.sale_id", $sale_id);
        
        $this->db->where("sale_items.sale_id", $sale_id);
        $this->db->where('sale_items.print_status', 0);
        $this->db->where('product.is_ko ', 1);
        $query = $this->db->get();
        return $query->result();
    }
    function get_pending_kitchen_sale_item_list_by_sale_id($sale_id, $cat_id = "")
    {
        $this->db->select('sale_items.product_id, product.product_name, sale_items.quantity');
        $this->db->from('sale_items');
        $this->db->join('product', 'sale_items.product_id = product.product_id', 'left');
        $this->db->order_by("sale_items.id", "asc");
        if ($cat_id)
            $this->db->where('product.cat_id !=', $cat_id);
        if ($sale_id)
            $this->db->where("sale_items.sale_id", $sale_id);
        $this->db->where('print_status ', '0');
        $query = $this->db->get();
        return $query->result();
    }
    function set_printed($sale_id, $cat_id)
    {
        if (!$sale_id)
            return false;
        if (!$cat_id)
            return false;
        $items = array(
            'print_status' => 1
        );
        $this->db->where('product.cat_id', $cat_id);
        $this->db->where('sale_id', $sale_id);
        if ($this->db->update('sale_items JOIN product ON sale_items.product_id = product.product_id', $items)) {
            $data = array(
                'print_status' => 1
            );
            $this->db->where('sale_id', $sale_id);
            $this->db->update('sales', $data);
            return 1;
        }
    }
    //by cat id
    function set_printed_kitchen($sale_id, $cat_id)
    {
        if (!$sale_id)
            return false;
        if (!$cat_id)
            return false;
        $items = array(
            'print_status' => 1
        );
        $this->db->where('product.cat_id !=', $cat_id);
        $this->db->where('sale_id', $sale_id);
        if ($this->db->update('sale_items JOIN product ON sale_items.product_id = product.product_id', $items)) {
            $data = array(
                'print_status' => 1
            );
            $this->db->where('sale_id', $sale_id);
            $this->db->update('sales', $data);
            return 1;
        }
    }
    //direct order
    function set_printed_kitchen_order($sale_id)
    {
        if (!$sale_id)
            return false;
        $items = array(
            'print_status' => 1
        );
        $this->db->where('sale_id', $sale_id);
        if ($this->db->update('sale_items JOIN product ON sale_items.product_id = product.product_id', $items)) {
            $data = array(
                'print_status' => 1
            );
            $this->db->where('sale_id', $sale_id);
            $this->db->update('sales', $data);
            return ($this->db->affected_rows() > 0) ? true:false;
        }
    }
    function cancel_kot($sale_id)
    {
        $items = array(
            'print_status' => 2
        );
        $this->db->where('sale_id', $sale_id);
        if ($this->db->update('sale_items', $items)) {
            $data = array(
                'print_status' => 1
            );
            $this->db->where('sale_id', $sale_id);
            $this->db->update('sales', $data);
            return 1;
        }
        //echo $this->db->last_query();
    }
}