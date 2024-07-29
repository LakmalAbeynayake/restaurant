<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Restaurant_Model extends CI_Model
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
    function get_next_ref_no()
    {
        $this->db->select("COUNT(`sale_id`) AS sale_id");
        $this->db->where("DATE(`sale_datetime`)", date("Y-m-d"));
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
            $this->db->query('DELETE FROM `sale_payments` WHERE `sale_id` = ' . $sale_id . ' AND `sale_payment_type`= "sale" ');
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
    function get_all_sales($dine_type = '', $sale_status = '', $sale_id = '' , $cus_id = '')
    {
        $warehouse_id = '';
        $this->db->select('sales.*, customer.cus_name');
        $this->db->from('sales');
        $this->db->join('customer', 'sales.customer_id = customer.cus_id', 'left');
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
	function get_pending_sale_item_list_by_sale_id($id)
    {
        $this->db->select('sale_items.separate_status,sale_items.product_id, product.product_name, product.product_code, sale_items.quantity, sale_items.discount, sale_items.discount_val, sale_items.unit_price, sale_items.gross_total');
        $this->db->from('sale_items');
        $this->db->join('product', 'sale_items.product_id = product.product_id', 'inner');
        $this->db->where("sale_items.kot_id", $id);
        $this->db->order_by("sale_items.id", "asc");
	///	$this->db->where('print_status ','0');
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
	function get_all_sale_items_old()
    {
        $this->db->select('product.product_name,sales.sale_datetime,sales.sale_reference_no, customer.cus_name,sale_items.sale_id,sale_items.id,sales.table_id,division_id');
        $this->db->from('sale_items');
        $this->db->join('product', 'product.product_id = sale_items.product_id');
        $this->db->join('sales', 'sales.sale_id = sale_items.sale_id', 'left');
        $this->db->join('customer ', 'customer.cus_id = sales.customer_id');
        $this->db->order_by("sale_items.sale_id", "desc");
		$this->db->where('item_status != "Cooked"');
        /*if ($search_key_val) {
            $this->db->where("sales.sale_reference_no LIKE '%$search_key_val%' OR product.product_code LIKE '%$search_key_val%' OR customer.cus_name LIKE '%$search_key_val%'");
        }
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
        }*/
        $query = $this->db->get();
        return $query->result_array();
    }
	
	function get_all_sales_for_kitchen_old()
    {
        $warehouse_id = '';
        $this->db->select('sales.*, customer.cus_name');
        $this->db->from('sale_items');
		$this->db->join('sales', 'sales.sale_id = sale_items.sale_id', 'inner');
        $this->db->join('customer', 'sales.customer_id = customer.cus_id', 'inner');
        $this->db->join('product', 'product.product_id = sale_items.product_id', 'inner');
        //$this->db->where("sales.sale_cook_status", "pending");
		//$this->db->where("sale_items.item_status != 'Cooked'");
		//$this->db->where("sale_items.print_status", 0);
		$this->db->where("product.is_ko", 1);
		$this->db->where("date(sale_items.sale_datetime)", date("Y-m-d"));
        $this->db->order_by("sales.sale_id", "asc");
		$this->db->group_by("sales.sale_id");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function get_all_sales_for_kitchen()
    {
        $warehouse_id = '';
        $this->db->select('s.*, k.*');
        $this->db->from('kot_master k');
		$this->db->join('sales s', 's.sale_id = k.sale_id', 'inner');
        //$this->db->join('sale_items si', 'si.kot_id = k.kot_id', 'inner');
        //$this->db->join('product p', 'p.product_id = p.product_id', 'inner');
        $this->db->where("k.kot_status", 0);
        $this->db->or_where("k.kot_status",1 );
        $this->db->order_by("k.kot_id", "desc");
		$this->db->group_by("k.kot_id");
		$this->db->limit(10);
        $query = $this->db->get();
        return $query->result_array();
    }
	function get_sale_items_by_sale_id_for_kitchen_old($sale_id)
    {
        $this->db->select('product_name,quantity,item_status,id');
        $this->db->from('sale_items');
        $this->db->where("sale_items.sale_id", $sale_id);
		//$this->db->where('item_status != "Cooked"');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    	function get_sale_items_by_sale_id_for_kitchen($kot_id)
    {
        $this->db->select('product_name,quantity,item_status,id');
        $this->db->from('sale_items');
        $this->db->where("sale_items.kot_id", $kot_id);
		//$this->db->where('item_status != "Cooked"');
        $query = $this->db->get();
        return $query->result_array();
    }
    
	function update_status($id, $status,$type='')
    {
		if ($id && $status) {
            $status_data = array(
                'item_status' => $status,
            );
            $this->db->where('sale_id', $id);
            if ($this->db->update('sale_items', $status_data)) {
				if($type == 'rest'){
					$sales_data = array(
					'is_editable' => 0,
					);
					$this->db->where('sale_id', $id);
					if ($this->db->update('sales', $sales_data)){
							return 1;
					}
				}else return 1;
			}
		}
       // $this->db->query('DELETE FROM `sale_payments` WHERE `sale_id` = ' . $sale_id . ' AND `sale_payment_type` = "' . $in_type . '" ');
    }
	function complete_sale_cook($sale_id,$status,$type='')
    {
				if($type == 'rest')
				$this->db->query('UPDATE `sales` SET `is_editable`= 0 WHERE `sale_id` = ' . $sale_id);
				
        return 	$this->db->query('UPDATE `sales` SET `sale_cook_status`= "'.$status.'" WHERE `sale_id` = ' . $sale_id);
    }
    
    function update_kot_master($kot_id,$data){
        if($kot_id){
         $this->db->where('kot_id', $kot_id);
          return   $this->db->update('kot_master', $data);
        }else{
            return false;
        }
        
    }
}