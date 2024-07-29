<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class App_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function get_product_by_cat_id($category_id = '')
    {
        $this->db->select('product_id,product_name,product_code,product_price,product_thumb,cat_id,sub_cat_id');
        $this->db->from('product');
        $this->db->where('cat_id', $category_id);
        $this->db->where('product_status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    public function get_all_category()
    {
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where('cat_status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    function get_next_ref_no_by_customer_id($customer_id)
    {
        $this->db->select("COUNT(`sale_id`) AS sales_count");
        $this->db->where("customer_id", $customer_id);
        $result   = $this->db->get("`sales`");
        $result   = $result->row();
        $sale_ref = sprintf("%03d", $result->sales_count + 1);
        $sale_ref = date('Ymdhis') . $customer_id . $sale_ref;
        return $sale_ref;
    }
    function save_sale_header(&$sales_data, $sale_id = false)
    {
        if (!$sale_id) {
            if ($this->db->insert('sales', $sales_data)) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        }
    }
    function update_sale($sale_data)
    {
        if ($sale_data['sale_id']) {
            $this->db->query('UPDATE `sales` SET `sale_total` = 2 WHERE `sale_id` = ' . $sale_id);
		}
    }
    function get_product_details_by_id($id)
    {
        $this->db->select('*');
        /*product_cost , product_price , credit_salling_price , wholesale_price*/
        $this->db->from('product p');
        $this->db->where("p.product_id", $id);
        $query = $this->db->get();//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result;
        } else {
            return false;
        }
    }
    function sale_items_in($sale_details)
    {
        /*$data = array(
        'sale_id' => $sale_details['sale_id'],
        'product_id' => $sale_details['product_id'],
        'product_code' => $sale_details['product_code'],
        'product_name' => $sale_details['product_name'],
        'quantity' => $sale_details['quantity'],
        'unit_price' => $sale_details['unit_price'],
        'gross_total' => $sale_details['gross_total']
        );*/
        if ($this->db->insert('sale_items', $sale_details)) {
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
            'user_id' => $this->session->userdata('ss_user_id')
        );
        if ($this->db->insert('sale_payments', $data)) {
            return true;
        } else {
            return false;
        }
    }
    function complete_sale($sale_id)
    {
        return $this->db->query('UPDATE `sales` SET `sale_status`= 2 WHERE `sale_id` = ' . $sale_id);
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
        $warehouse_id = '';
        $this->db->select('*');
        $this->db->from('sales');
        $this->db->where("sale_id", $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_sale_items_by_sale_id($sale_id)
    {
        $this->db->select('product_name,quantity');
        $this->db->from('sale_items');
        $this->db->where("sale_items.sale_id", $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    
    
    
	/*function get_all_sales($start = '', $length = '', $search_key_val = '', $dine_type = '', $sale_status = '', $sale_id = '')
    {
        $warehouse_id = '';
        $this->db->select('sales.*, customer.cus_name');
        $this->db->from('customer');
        $this->db->join('sales', 'sales.customer_id = customer.cus_id', 'left');
        if ($dine_type)
            $this->db->where("sales.dine_type", $dine_type);
        if ($sale_status)
            $this->db->where("sales.sale_status", $sale_status);
        if ($sale_id)
            $this->db->where("sales.sale_id", $sale_id);
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
        $this->db->order_by("sales.sale_id", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_all_sales_c($start = '', $length = '', $search_key_val = '', $dine_type = '', $sale_status = '')
    {
        $warehouse_id = '';
        $this->db->select('COUNT(sales.sale_id) AS count_s');
        $this->db->from('customer');
        $this->db->join('sales', 'sales.customer_id = customer.cus_id', 'left');
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
    }public function get_sale_item_list_by_sale_id($sale_id)
    {
        $this->db->select('sale_items.product_id, product.product_name, product.product_code, sale_items.quantity, sale_items.discount, sale_items.discount_val, sale_items.unit_price, sale_items.gross_total,product.product_part_no,product.product_oem_part_number');
        $this->db->from('sale_items');
        $this->db->join('product', 'sale_items.product_id = product.product_id', 'left');
        $this->db->order_by("sale_items.id", "asc");
        $this->db->where("sale_items.sale_id", $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }function get_customers($id = '')
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
    }public function check1()
    {
        $this->db->select('*');
        $this->db->from('sale_items');
        $query = $this->db->get();
        return $query->result_array();
    }function save_product($data)
    {
        if ($this->db->insert('product', $data)) {
            $lst = $this->db->insert_id();
            $dta = $this->update_product_code($lst);
            return $dta;
        } else {
            return false;
        }
    }function update_product_code($product_id = '')
    {
        $data = array(
            'product_code' => "PD" . sprintf("%04d", $product_id)
        );
        $this->db->where('product_id', $product_id);
        $this->db->update('product', $data);
        return $product_id;
    }function get_sub_category_by_cat_id($category_id = '')
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
    function get_product_by_code($product_code = '', $customer_id = '', $warehouse_id = '')
    {
        $this->db->select('p.product_id,p.product_code,p.product_name,p.product_price');
        $this->db->from('product p');
        if ($product_code) {
            $this->db->like('p.product_name', $product_code);
            $this->db->or_like('p.product_code', $product_code);
            $this->db->limit('5');
        }
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
    function get_warehouse()
    {
        $this->db->select('*');
        $this->db->from('warehouses');
        $this->db->where('status', 1);
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
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
	*/
}