<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class posplus_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
         $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }
    public function get_product_by_cat_id($category_id = '', $is_quick_sale=0)
    {
        $this->db->select('product_id,product_name,product_code,product_price,product_thumb,cat_id,sub_cat_id');
        $this->db->from('product');
		
		if($is_quick_sale){
            $this->db->where('is_quick_sale', $is_quick_sale);
		}else {
			if($category_id){
        		$this->db->where('cat_id', $category_id);
			}	
		}
        $this->db->where('product_status', 1);
        $this->db->order_by('product_name', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_product_by_cat_id_c($category_id = '')
    {
        $this->db->select('COUNT(product_id) as count');
        $this->db->from('product');
        $this->db->where('cat_id', $category_id);
        $this->db->where('product_status', 1);
        $this->db->order_by('product_name', 'asc');
        $query = $this->db->get();
       // echo  $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_products()
    {
        $this->db->select('p.product_id,p.product_code,p.product_name,p.product_cost,p.product_price,p.product_prices,p.cat_id,p.ott,p.is_rti');
        $this->db->from('product p');
        $this->db->where('product_prices !=', '');
        $this->db->where('product_status', 1);
        $this->db->order_by('product_name', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_category()
    {
         $this->db->select('pc.*');
        $this->db->from('product_category pc');
        $this->db->join('product p','pc.cat_id=p.cat_id','inner');
        $this->db->where('pc.cat_status', 1);
        $this->db->order_by('pc.cat_name', 'asc');
        $this->db->group_by('pc.cat_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_sub_category_by_cat_id($category_id = '')
    {
        $this->db->select('*');
        $this->db->from('product_sub_category');
        $this->db->where('cat_id', $category_id);
        $this->db->where('sub_cat_status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_product_by_cat_sub_id($category_id = '', $sub_category_id = '')
    {
        $this->db->select('product_id,product_name,product_code,product_price,product_thumb,cat_id,sub_cat_id');
        $this->db->from('product');
        $this->db->where('cat_id', $category_id);
        $this->db->where('sub_cat_id', $sub_category_id);
        $this->db->where('product_status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_customer()
    {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('cus_status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
     function get_waiter()
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('user_status', 1);
        $this->db->where('group_id', 5);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
    function get_warehouse()
    {
        $this->db->select('*');
        $this->db->from('locations');
        $this->db->where('status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_next_ref_no()
    {
        $this->db->select_max("sale_id");
        //$this->db->where("DATE(`sale_datetime`)", date("Y-m-d"));
        return $this->db->get("`sales`");
    }
    function save_sale_header(&$sales_data, $sale_id = false)
    {
        if (!$sale_id) {
            if ($this->db->insert('sales', $sales_data)) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        } else {
            //$this->db->query('DELETE FROM `sale_payments` WHERE `sale_id` = ' . $sale_id . ' AND `sale_payment_type`= "sale" ');
            $this->db->query('DELETE FROM `sale_items` WHERE `sale_id` = ' . $sale_id . '');
            $this->db->query('DELETE FROM `sales` WHERE `sale_id` = ' . $sale_id . '');
            if ($this->db->insert('sales', $sales_data)) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        }
    }
    function sale_items_in($sale_id, $pr_id, $product_code, $product_name, $quantity, $net_price, $ssubtotal)
    {
        $data = array(
            'sale_id' => $sale_id,
            'product_id' => $pr_id,
            'product_code' => $product_code,
            'product_name' => $product_name,
            'quantity' => $quantity,
            'unit_price' => $net_price,
            'gross_total' => $ssubtotal
        );
        if ($this->db->insert('sale_items', $data)) {
            return true;
        } else {
            return false;
        }
    }
    function sales_payment($sale_id = "", $paid_by = "", $pay_amount = "", $sale_date = "", $payment_note = "", $cc_no = "", $pcc_holder = "", $pcc_type = "", $type = "", $sale_pymnt_given_amount = "", $sale_pymnt_balance_amount = "")
    {
        $data = array(
            'sale_id' => $sale_id,
            'sale_pymnt_paying_by' => $paid_by,
            'sale_pymnt_amount' => $pay_amount,
            'sale_pymnt_date_time' => $sale_date,
            'sale_pymnt_added_date_time' => $sale_date,
            'sale_pymnt_crdt_card_no' => $cc_no,
            'sale_pymnt_crdt_card_holder_name' => $pcc_holder,
            'sale_pymnt_crdt_card_type' => $pcc_type,
            'sale_payment_type' => $type,
            'sale_pymnt_given_amount' => $sale_pymnt_given_amount,
            'sale_pymnt_balance_amount' => $sale_pymnt_balance_amount,
            'user_id' => $this->session->userdata('ss_user_id'),
            'float_id'	=> $this->session->userdata('ss_cashier_float_id'),
        );
        if ($this->db->insert('sale_payments', $data)) {
            return true;
        } else {
            return false;
        }
    }
    function complete_sale($sale_id)
    {
        return $this->db->query('UPDATE `sales` SET `sale_status`= 3 WHERE `sale_id` = ' . $sale_id);
    }
    function cancel_sale($sale_id , $cancellation_reasons="")
    {
        if($sale_id > 0)
        return $this->db->query('UPDATE `sales` SET `sale_status`= 99, `cancellation_reasons` = "'.$cancellation_reasons.'" WHERE `sale_id` = ' . $sale_id);
        else return false;
    }
    function get_all_sales($start = '', $length = '', $search_key_val = '', $dine_type = '', $sale_status = '', $sale_id = '')
    {
        $warehouse_id = '';
        $this->db->select('sales.*, customer.cus_name,customer.cus_phone');
        $this->db->select('u.user_first_name as waitername');
        $this->db->select('ca.user_first_name as cashier');
        $this->db->from('sales');
        $this->db->join('customer', 'sales.customer_id = customer.cus_id', 'inner');
         $this->db->join('user u', 'u.user_id = sales.waiter_id', 'left');
          $this->db->join('user ca', 'ca.user_id = sales.user', 'inner');
        if ($dine_type){
            $this->db->where("sales.dine_type", $dine_type);
			$this->db->where("DATE(sales.sale_datetime)", date("Y-m-d"));
		}
		$this->db->where("sales.sale_status != 3 AND sales.sale_status != 99");
        if ($sale_id)
            $this->db->where("sales.sale_id", $sale_id);
        if ($this->session->userdata('ss_group_id') != 1) {
            $warehouse_id = $this->session->userdata('ss_warehouse_id');
            $this->db->where("sales.warehouse_id", $warehouse_id);
        }
        if ($search_key_val) {
            $this->db->where("customer.cus_name LIKE '%$search_key_val%' OR sales.sale_id LIKE '%$search_key_val%' OR sales.sale_reference_no LIKE '%$search_key_val%' OR sales.sale_datetime LIKE '%$search_key_val%'");
        }
        $this->db->where("sales.float_id", $this->session->userdata('ss_cashier_float_id'));
        if ($start != '' && $length != '') {
            $this->db->limit(25);
            $this->db->order_by("sales.sale_id", "desc");
            $query = $this->db->get();
    		//echo $this->db->last_query();
            return $query->result_array();
        }else{
            $query = $this->db->get();
            return $query->num_rows();
        }
    }
    function get_all_sales_c($start = '', $length = '', $search_key_val = '', $dine_type = '', $sale_status = '')
    {
        $warehouse_id = '';
        $this->db->select('COUNT(sales.sale_id) AS count_s');
        $this->db->from('customer');
        $this->db->join('sales', 'sales.customer_id = customer.cus_id', 'inner');
        if ($dine_type)
            $this->db->where("sales.dine_type", $dine_type);
        if ($sale_status)
            $this->db->where("sales.sale_status", $sale_status);
        $this->db->order_by("sales.sale_id", "desc");
        if ($this->session->userdata('ss_group_id') != 1) {
            $warehouse_id = $this->session->userdata('ss_warehouse_id');
            $this->db->where("sales.warehouse_id", $warehouse_id);
        }
        if ($search_key_val) {
            $this->db->where("customer.cus_name LIKE '%$search_key_val%' OR sales.sale_id LIKE '%$search_key_val%' OR sales.sale_reference_no LIKE '%$search_key_val%' OR sales.sale_datetime LIKE '%$search_key_val%'");
        }
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_total_paid_by_sale_id($sale_id)
    {
        $this->db->select_sum('sale_pymnt_amount');
        $this->db->from('sale_payments');
        $this->db->where("sale_id", $sale_id)->where("(sale_payment_type='sale' OR sale_payment_type='pos_sale')");
        $this->db->where("sale_pymnt_paying_by !=", "Cheque_Return");
        $query = $this->db->get();
        if ($query->row()->sale_pymnt_amount) {
            return $query->row()->sale_pymnt_amount;
        } else {
            return 0;
        }
    }
    function get_sale_info($sale_id)
    {
        $this->db->select('sales.*, customer.cus_name,customer.cus_phone');
        $this->db->from('sales');
        $this->db->where("sale_id", $sale_id);
        $this->db->join('customer', 'sales.customer_id = customer.cus_id', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_sale_items_by_sale_id($sale_id)
    {
        $this->db->select('id,product_name,quantity');
        $this->db->from('sale_items');
        $this->db->where("sale_items.sale_id", $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_sale_item_list_by_sale_id($sale_id)
    {
        $this->db->select('sale_items.product_id, product.product_name, product.product_code, sale_items.quantity, sale_items.discount, sale_items.discount_val, sale_items.unit_price, sale_items.gross_total,product.product_part_no,product.product_oem_part_number');
        $this->db->from('sale_items');
        $this->db->join('product', 'sale_items.product_id = product.product_id', 'left');
        $this->db->order_by("sale_items.id", "asc");
        $this->db->where("sale_items.sale_id", $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_customers($id = '')
    {
        $this->db->select('customer.*');
        $this->db->order_by("cus_name", "asc");
        $this->db->where("cus_status", 1);
        if ($id)
            $this->db->where("cus_id", $id);
        else
            $this->db->where("cus_id !=", 1);
        $query = $this->db->get('customer');
        return $query->result_array();
    }
    public function check1()
    {
        $this->db->select('*');
        $this->db->from('sale_items');
        $query = $this->db->get();
        return $query->result_array();
    }
    function save_product($data)
    {
        if ($this->db->insert('product', $data)) {
            $lst = $this->db->insert_id();
            $dta = $this->update_product_code($lst);
            return $dta;
        } else {
            return false;
        }
    }
    function update_product_code($product_id = '')
    {
        $data = array(
            'product_code' => "PD" . sprintf("%04d", $product_id)
        );
        $this->db->where('product_id', $product_id);
        $this->db->update('product', $data);
        return $product_id;
    }
    
    function ready_sale($sale_id)
    {
        if($sale_id >1){
            if($this->db->query('UPDATE `sales` SET `ready_sale`= 1 WHERE `sale_id` = ' . $sale_id)){
    			return true;
		    }else return false;
        }else return false;
    }
}