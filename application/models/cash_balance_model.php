<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Cash_Balance_Model extends CI_Model
{
    private $mastertableName = 'cashier_float_master';
    private $itemtableName = 'cashier_float_item';
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
    function save_cashier_float_master($data)
    {
        $this->db->insert($this->mastertableName, $data);
        return $this->db->insert_id();
    }
    function save_cashier_float_item($data)
    {
        return $this->db->insert($this->itemtableName, $data);
    }
    function update_cashier_float_master($data, $id)
    {
        if ($id > 0) {
            $this->db->where('c_float_mstr_id', $id);
            return $this->db->update($this->mastertableName, $data);
        } else {
            return false;
        }
    }
    public function get_chashier_foat_full_details($id)
    {
        $this->db->select('cm.*,u.user_first_name,ug.user_group_name,w.*');
        $this->db->from('cashier_float_master cm');
        $this->db->join('user u', 'cm.user_id = u.user_id', 'left');
        $this->db->join('user_group ug', 'u.group_id = ug.user_group_id ', 'left');
        $this->db->join('locations w', 'cm.warehouse_id = w.id', 'left');
        $this->db->where("cm.c_float_mstr_id", $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_chashier_foat_items_details($id)
    {
        $this->db->select('cmi.*');
        $this->db->from('cashier_float_item cmi');
        $this->db->where("cmi.c_float_mstr_id", $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_float_payment_total($id = '', $payment_type = '', $card_type = "")
    {
        $this->db->select_sum('p.sale_pymnt_amount');
        $this->db->from('sale_payments p');
        $this->db->join('sales s', ' s.sale_id=p.sale_id', 'inner');
        $this->db->where("s.sale_status != 99");
        $this->db->where("p.sale_payment_type", "sale");
        if ($id) {
            $this->db->where("p.float_id", $id);
        }
        if ($payment_type) {
            $this->db->where("p.sale_pymnt_paying_by", $payment_type);
        }
        if ($card_type) {
            $this->db->where("p.sale_pymnt_crdt_card_type", $card_type);
        }
        $this->db->where("p.sale_payment_type", "sale");
        $query  = $this->db->get();
        $result = $query->row_array();
        if (isset($result['sale_pymnt_amount'])) {
            return $result['sale_pymnt_amount'];
        } else {
            return 0;
        }
    }
    function get_float_retail_sale_total($id = '')
    {
        $this->db->select_sum('s.sale_total');
        $this->db->from('sales s');
        $this->db->where("s.sale_status != 99");
        if ($id) {
            $this->db->where("s.float_id", $id);
        }
        $query  = $this->db->get();
        $result = $query->row_array();
        if (isset($result['sale_total'])) {
            return $result['sale_total'];
        } else {
            return 0;
        }
    }
    function get_credit_staff_sale_total($id = '')
    {
        $this->db->select_sum('s.sale_total');
        $this->db->from('sales s');
        $this->db->join('customer c','s.customer_id = c.cus_id','left');
        $this->db->where("c.cus_type_id","2");
        $this->db->where("s.sale_status != 99");
        $this->db->where("s.payment_status","pending");
        
        if ($id) {
            $this->db->where("s.float_id", $id);
        }
        $query  = $this->db->get();
        //echo $this->db->last_query();
        $result = $query->row_array();
        if (isset($result['sale_total'])) {
            return $result['sale_total'];
        } else {
            return 0;
        }
    }
    function get_expencess_total($id = '')
    {
        $this->db->select_sum('p.acctrnss_amount');
        $this->db->from('acc_transactions p');
        if ($id) {
            $this->db->where("p.float_id", $id);
        }
        $this->db->where("p.fxd_ass_id", 5);
        $query  = $this->db->get();
        $result = $query->row_array();
        if (isset($result['acctrnss_amount'])) {
            return $result['acctrnss_amount'];
        } else {
            return 0;
        }
    }
    function get_expencess_total_tmp($id = '')
    {
        $this->db->select_sum('p.exp_total');
        $this->db->from('expenses p');
        if ($id) {
            $this->db->where("p.float_id", $id);
        }
        $query  = $this->db->get();
        $result = $query->row();
        if (isset($result->exp_total)) {
            return $result->exp_total;
        } else {
            return 0;
        }
    }
    function get_tranfer_pettycash_total($id = '')
    {
        $this->db->select_sum('p.acctrnss_amount');
        $this->db->from('acc_transactions p');
        if ($id) {
            $this->db->where("p.float_id", $id);
        }
        $this->db->where("p.fxd_ass_id", 1);
        $query  = $this->db->get();
        $result = $query->row_array();
        if (isset($result['acctrnss_amount'])) {
            return $result['acctrnss_amount'];
        } else {
            return 0;
        }
    }
    function get_withdrowal_total($id = '')
    {
        $this->db->select_sum('p.acctrnss_amount');
        $this->db->from('acc_transactions p');
        if ($id) {
            $this->db->where("p.float_id", $id);
        }
        $this->db->where("p.fxd_ass_id", 6);
        $query  = $this->db->get();
        $result = $query->row_array();
        if (isset($result['acctrnss_amount'])) {
            return $result['acctrnss_amount'];
        } else {
            return 0;
        }
    }
    function get_withdrowal_list($id = '')
    {
        $this->db->select('p.*');
        $this->db->from('acc_transactions p');
        if ($id) {
            $this->db->where("p.float_id", $id);
        }
        $this->db->where("p.fxd_ass_id", 6);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_float_payment_return_total($id = '', $payment_type = '')
    {
        $this->db->select_sum('p.sale_pymnt_amount');
        $this->db->from('sale_payments p');
        $this->db->where("p.sale_payment_type", "sales_return");
        if ($id) {
            $this->db->where("p.float_id", $id);
        }
        if ($payment_type) {
            $this->db->where("p.sale_pymnt_paying_by", $payment_type);
        }
        $query  = $this->db->get();
        $result = $query->row_array();
        if (isset($result['sale_pymnt_amount'])) {
            return $result['sale_pymnt_amount'];
        } else {
            return 0;
        }
    }
    function get_float_return_retail_sale_total($id = '')
    {
        $this->db->select_sum('s.sl_rtn_total');
        $this->db->from('sales_return s');
        if ($id) {
            $this->db->where("s.float_id", $id);
        }
        $query  = $this->db->get();
        $result = $query->row_array();
        if (isset($result['sl_rtn_total'])) {
            return $result['sl_rtn_total'];
        } else {
            return 0;
        }
    }
    function get_sales_from_float_id($float_id)
    {
        $this->db->select('sale_id,paid_by,sale_extra_charges_amount,cc_charge');
        $this->db->from('sales s');
        $this->db->where('s.float_id', $float_id);
        $this->db->where("s.sale_status != 99");
        //$this->db->where('sale_status',2);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
    function get_service_charge_from_float_id($float_id)
    {
        $this->db->select_sum('s.sale_extra_charges_amount');
        $this->db->from('sales s');
        $this->db->where("s.sale_status != 99");
        $this->db->where('s.float_id', $float_id);
        $query = $this->db->get();
        return $query->row()->sale_extra_charges_amount;
    }
    function get_sales_items_sum_from_sale_id($sale_id, $cat_id = "")
    {
        $this->db->select_sum('si.gross_total');
        $this->db->from('sale_items si');
        $this->db->join('sales s', ' s.sale_id=si.sale_id', 'inner');
        $this->db->where("s.sale_status != 99");
        if ($cat_id) {
            $this->db->join('product p', 'p.product_id = si.product_id', 'left');
            $this->db->where('p.cat_id', $cat_id);
        }
        $this->db->where('si.sale_id', $sale_id);
        $query = $this->db->get();
        return $query->row()->gross_total;
    }
    function get_category_list($float_id)
    {
        $this->db->select('c.cat_name,c.cat_id');
        $this->db->from('product_category c');
        $this->db->join('product p', 'p.cat_id = c.cat_id', 'inner');
        $this->db->join('sale_items s', 's.product_id = p.product_id', 'inner');
        $this->db->join('sales m', 'm.sale_id = s.sale_id', 'inner');
        $this->db->where('m.float_id', $float_id);
        $this->db->group_by('c.cat_id');
        $query = $this->db->get();
        return $query->result();
    }
    function get_category_sale_total($float_id, $cat_id)
    {
        $this->db->select_sum('s.gross_total');
        $this->db->from('sale_items s');
        $this->db->join('product p', 'p.product_id = s.product_id', 'inner');
        $this->db->join('sales m', 'm.sale_id = s.sale_id', 'inner');
        $this->db->where("m.sale_status != 99");
        $this->db->where('m.float_id', $float_id);
        $this->db->where('p.cat_id', $cat_id);
        $query = $this->db->get();
        return $query->row()->gross_total;
    }
    function get_credit_card_from_float_id($float_id)
    {
        $this->db->select_sum('s.cc_charge');
        $this->db->from('sales s');
        $this->db->where("s.sale_status != 99");
        $this->db->where('s.float_id', $float_id);
        $query = $this->db->get();
        return $query->row()->cc_charge;
    }
    function get_expencess_list($float_id)
    {
        $this->db->select('e.*');
        $this->db->from('expenses_items e');
        $this->db->where('e.float_id', $float_id);
        $query = $this->db->get();
        return $query->result();
    }
    function get_category_product_list($float_id, $cat_id)
    {
        $this->db->select('p.product_id,p.product_code,p.product_name,p.product_price');
        $this->db->select_sum('quantity');
        $this->db->select_sum('gross_total');
        $this->db->from('product p');
        $this->db->join('sale_items s', 's.product_id = p.product_id', 'inner');
        $this->db->join('sales m', 'm.sale_id = s.sale_id', 'inner');
        $this->db->where('m.float_id', $float_id);
        $this->db->where('p.cat_id', $cat_id);
        $this->db->group_by('p.product_id');
        $this->db->order_by('p.product_name', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getSoldQtyByWarehouseIdNotInShift($warehouse_id, $product_id, $srh_from_date = '', $srh_to_date = '', $id = '')
    {
        $this->db->select_sum('si.quantity');
        $this->db->from('sale_items si');
        $this->db->join('sales s', 's.sale_id = si.sale_id', 'inner');
        $this->db->where('s.warehouse_id', $warehouse_id);
        $this->db->where('si.product_id', $product_id);
        $this->db->where("s.sale_status != 99");
        if ($srh_to_date) {
            $this->db->where("s.sale_datetime <=", $srh_to_date); //("id !=",$id);
        }
        if ($srh_from_date) {
            $this->db->where("s.sale_datetime >=", $srh_from_date); //("id !=",$id);
        }
        if ($id) {
            $this->db->where('s.float_id !=', $id);
        }
        $query = $this->db->get();
        return $data['quantity'] = $query->row()->quantity;
    }
    public function getSoldQtyByWarehouseId($warehouse_id, $product_id, $srh_from_date = '', $srh_to_date = '')
    {
        $this->db->select_sum('si.quantity');
        $this->db->from('sale_items si');
        $this->db->join('sales s', 's.sale_id = si.sale_id', 'inner');
        $this->db->where("s.sale_status != 99");
        $this->db->where('s.warehouse_id', $warehouse_id);
        $this->db->where('si.product_id', $product_id);
        if ($srh_to_date) {
            $this->db->where("s.sale_datetime <=", $srh_to_date);
        }
        if ($srh_from_date) {
            $this->db->where("s.sale_datetime >=", $srh_from_date);
        }
        $query = $this->db->get();
        return $data['quantity'] = $query->row()->quantity;
    }
    public function getPurchasedQtyByWarehouseId($warehouse_id, $product_id, $srh_from_date = '', $srh_to_date = '')
    {
        $this->db->select_sum('pi.quantity');
        $this->db->from('purchase_items pi');
        $this->db->join('purchases p', 'p.id = pi.purchase_id', 'inner');
        $this->db->where('p.location_id', $warehouse_id);
        $this->db->where('pi.product_id', $product_id);
        $this->db->where('p.reviewed_status', "Approved");
        if ($srh_to_date) {
            $this->db->where("p.date <=", $srh_to_date);
        }
        if ($srh_from_date) {
            $this->db->where("p.date >=", $srh_from_date);
        }
        $query = $this->db->get();
        return $data['quantity'] = $query->row()->quantity;
    }
    public function getProductDamagedQtyByWarehouseId($warehouse_id, $product_id, $srh_from_date = '', $srh_to_date = '')
    {
        $this->db->select_sum('pdi.pdmgitm_quantity');
        $this->db->from('product_damage_item pdi');
        $this->db->join('product_damage p', 'p.pdmg_id = pdi.pdmg_id', 'inner');
        $this->db->where('p.warehouse_id', $warehouse_id);
        $this->db->where('pdi.product_id', $product_id);
        if ($srh_to_date) {
            $this->db->where("p.pdmg_datetime <=", $srh_to_date);
        }
        if ($srh_from_date) {
            $this->db->where("p.pdmg_datetime >=", $srh_from_date);
        }
        $query = $this->db->get();
        return $data['quantity'] = $query->row()->pdmgitm_quantity;
    }
    public function getSalesReturnQtyByWarehouseId($warehouse_id, $product_id, $srh_from_date = '', $srh_to_date = '')
    {
        $this->db->select_sum('sri.quantity');
        $this->db->from('sales_return_items sri');
        $this->db->join('sales_return sr', 'sr.sl_rtn_id = sri.sl_rtn_id', 'inner');
        $this->db->where('sr.warehouse_id', $warehouse_id);
        $this->db->where('sri.product_id', $product_id);
        if ($srh_to_date) {
            $this->db->where("sr.sl_rtn_datetime <=", $srh_to_date);
        }
        if ($srh_from_date) {
            $this->db->where("sr.sl_rtn_datetime >=", $srh_from_date);
        }
        $query = $this->db->get();
        return $data['quantity'] = $query->row()->quantity;
    }
}