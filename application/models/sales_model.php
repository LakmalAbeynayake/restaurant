<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Sales_Model extends CI_Model
{
    private $tableName = 'sales';
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
    public function get_cash_sale_by_date_range($srh_from_date, $srh_to_date, $srh_warehouse_id, $in_type, $sale_pymnt_paying_by)
    {
        $this->db->select('sp.*,SUM(sp.sale_pymnt_amount) as hire_sale_tot_amount,u.user_first_name');
        $this->db->from('sale_payments sp');
        $this->db->join('sales s', 'sp.sale_id=s.sale_id', 'left');
        $this->db->join('user u', 'sp.cash_collector_id=u.user_id', 'left');
        //if($srh_to_date)
        {
            $srh_to_date = date('Y-m-d', strtotime($srh_to_date));
            //  $this->db->where("s.sale_datetime <=",$srh_to_date);
            $this->db->where("date(sp.sale_pymnt_date_time) <=", $srh_to_date);
        }
        //if($srh_from_date)
        {
            $srh_from_date = date('Y-m-d', strtotime($srh_from_date));
            $this->db->where("date(sp.sale_pymnt_date_time) >=", $srh_from_date);
        }
        //$this->db->where("s.sale_manual_setlmnt_status",0);
        //sale_manual_setlmnt_status
        if ($in_type) {
            $this->db->where('s.in_type', $in_type);
        }
        if ($srh_warehouse_id) {
            $this->db->where('s.warehouse_id', $srh_warehouse_id);
        }
        if ($sale_pymnt_paying_by) {
            $this->db->where('sp.sale_pymnt_paying_by', $sale_pymnt_paying_by);
        }
        $this->db->where('sp.sale_pymnt_amount != ', '0.00');
        $this->db->group_by('cash_collector_id');
        //$this->db->group_by('s.sale_id');    
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
    public function get_grn_cash_book_data_by_date_range($srh_from_date, $srh_to_date, $srh_warehouse_id)
    {
        $this->db->select('sp.*');
        $this->db->from('sale_payments sp');
        $this->db->join('purchases p', 'sp.sale_id=p.id', 'left'); {
            $srh_to_date = date('Y-m-d', strtotime($srh_to_date));
            $this->db->where("date(sp.sale_pymnt_date_time) <=", $srh_to_date);
        } {
            $srh_from_date = date('Y-m-d', strtotime($srh_from_date));
            $this->db->where("date(sp.sale_pymnt_date_time) >=", $srh_from_date);
        }
        if ($srh_warehouse_id) {
            $this->db->where('p.warehouse_id', $srh_warehouse_id);
        }
        $this->db->where('sp.sale_pymnt_amount != ', '0.00');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
    public function get_salary_payment_cash_book_data_by_date_range($srh_from_date, $srh_to_date, $srh_warehouse_id)
    {
        $this->db->select('sp.*');
        $this->db->from('salary_payment sp');
        //$this->db->join('purchases p','sp.sale_id=p.id','left');
        {
            $srh_to_date = date('Y-m-d', strtotime($srh_to_date));
            $this->db->where("date(sp.sp_date) <=", $srh_to_date);
        } {
            $srh_from_date = date('Y-m-d', strtotime($srh_from_date));
            $this->db->where("date(sp.sp_date) >=", $srh_from_date);
        }
        if ($srh_warehouse_id) {
            $this->db->where('sp.warehouse_id', $srh_warehouse_id);
        }
        $this->db->where('sp.sp_amount != ', '0.00');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
    //get Sold Qty By WarehouseId
    public function getSoldQtyByWarehouseId($warehouse_id, $product_id, $srh_from_date = '', $srh_to_date = '', $srh_user_id = '')
    {
        $this->db->select_sum('si.quantity');
        $this->db->from('sale_items si');
        $this->db->join('sales s', 's.sale_id = si.sale_id', 'inner');
        if ($product_id)
            $this->db->where('si.product_id', $product_id);
        if ($srh_user_id) {
            $this->db->where("si.user", $srh_user_id);
        }
        if ($srh_to_date) {
            $this->db->where("date(s.sale_datetime) <=", $srh_to_date); //("id !=",$id);
        }
        if ($srh_from_date) {
            $this->db->where("date(s.sale_datetime) >=", $srh_from_date); //("id !=",$id);
        }
        $query = $this->db->get();
        return $query->row()->quantity;
    }
    function get_all_sales_return_for_report($srh_warehouse_id = '', $srh_to_date = '', $srh_from_date = '', $sale_id = '', $from = '', $to = '')
    {
        $this->db->select('sr.* , c.cus_name ,SUM(p.sale_pymnt_amount) AS total_paid_amount');
        $this->db->from('sales_return sr');
        $this->db->join('customer c', 'sr.customer_id = c.cus_id', 'left');
        $this->db->join('sale_payments p', 'sr.sl_rtn_id = p.sale_id', 'left');
        $this->db->where("p.sale_payment_type", 'sales_return');
        //$this->db->join('sales_return sr', 'sr.sale_id = p.sale_id', 'left');
        $this->db->order_by("sr.sl_rtn_id", "desc");
        $this->db->group_by('sr.sl_rtn_id');
        if ($srh_warehouse_id) {
            $this->db->where("sr.warehouse_id", $srh_warehouse_id); //("id !=",$id);
        }
        if ($srh_to_date) {
            $this->db->where("sr.sl_rtn_datetime <=", $srh_to_date); //("id !=",$id);
        }
        if ($srh_from_date) {
            $this->db->where("sr.sl_rtn_datetime >=", $srh_from_date); //("id !=",$id);
        }
        //if($sl_rtn_id){
        //$this->db->where("sr.sl_rtn_id =",$sl_rtn_id);//("id !=",$id);
        //    }
        if ($to) {
            $this->db->limit($to, $from);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }
    //Sales get information
    public function get_sale_info_by_customer_id($id)
    {
        $this->db->select('s.*');
        //$this->db->select('u.user_first_name as waitername');
        $this->db->from('sales s');
        $this->db->where("s.customer_id", $id);
        // $this->db->join('user u', 'u.user_id = s.waiter_id', 'left');
        $this->db->order_by("s.sale_id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    function getPaymentsForPrint($srh_warehouse_id = '', $srh_to_date = '', $srh_from_date = '', $srh_type = '', $srh_payment_term = '', $srh_user_id = '')
    {
        if($srh_type == 'sale'){
            $this->db->select('p.*,c.cus_name,b.*,u.user_first_name');
        }
        $this->db->from('sale_payments p');
        if($srh_type == 'custom'){
            $this->db->select('p.*,c.cus_name,b.*,u.user_first_name');
        }
        if($srh_type == 'sale'){
            $this->db->join('sales b', 'b.sale_id = p.sale_id', 'left');
        }
        if($srh_type == 'custom'){
            $this->db->join('quotations b', 'b.qts_id = p.sale_id', 'left');
        }
        $this->db->join('locations w', 'w.id = b.warehouse_id', 'left');
        $this->db->join('customer c', 'c.cus_id = b.customer_id', 'left');
        $this->db->join('user u', 'u.user_id = p.user_id', 'left');
        if ($srh_type) {
            $this->db->where("p.sale_payment_type", $srh_type);
        }
        if ($srh_payment_term) {
            $this->db->where("p.sale_pymnt_paying_by", $srh_payment_term);
        }
        if ($srh_warehouse_id) {
            $this->db->where("b.warehouse_id", $srh_warehouse_id);
        }
        if ($srh_to_date) {
            $this->db->where("p.sale_pymnt_date_time <=", $srh_to_date); //("id !=",$id);
        }
        if ($srh_from_date) {
            $this->db->where("p.sale_pymnt_date_time >=", $srh_from_date); //("id !=",$id);
        }
        if ($srh_user_id) {
            $this->db->where("p.user_id", $srh_user_id);
        }
        $this->db->where("p.valid_status", 1);
        $this->db->group_by("p.sale_pymnt_id");
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            //return false;
        }
    }
    //Sales best for dashboard
    function getBestSales($year = null, $month = 0, $from = 0, $to = 0)
    {
        $this->db->select('SUM(ft.fi_qty)AS fi_qty_tot,p.product_name,p.product_code');
        $this->db->from('fi_table ft');
        $this->db->join('product p', 'ft.fi_item_id = p.product_id', 'left');
        $this->db->where('ft.fi_type_id', 'sale');
        if ($month) {
            $this->db->where('MONTH(ft.fi_date_time)', $month, FALSE);
        }
        if ($year) {
            $this->db->where('YEAR(ft.fi_date_time)', $year, FALSE);
        }
        if ($to) {
            $this->db->limit($to, $from);
        }
        $this->db->order_by("fi_qty_tot", "desc");
        $this->db->group_by('ft.fi_item_id');
        $query = $this->db->get();
        return $query->result();
    }
    //Sales genarate referance number
    function get_next_ref_no()
    {
        $this->db->select_max('sale_id');
        return $this->db->get('sales');
    }
    //Sales get avalable product qty
    function get_avalable_product_qty($product_id, $warehouse_id)
    {
        $this->db->select_sum('fi_qty');
        $query = $this->db->get('fi_table');
        return $query->row()->fi_qty;
    }
    //Sales get toatal paid 
    function get_total_paid_by_sale_id($sale_id)
    {
        $this->db->select_sum('sale_pymnt_amount');
        $this->db->from('sale_payments');
        $this->db->where("sale_id", $sale_id)->where("(sale_payment_type='sale')")->where("valid_status",1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->row()->sale_pymnt_amount) {
            return $query->row()->sale_pymnt_amount;
        } else {
            return 0;
        }
    }
    function get_total_advance_by_qts_id($sale_id)
    {
        $this->db->select_sum('sale_pymnt_amount');
        $this->db->from('sale_payments');
        $this->db->where("qutation_id", $sale_id);
        $this->db->where("valid_status", 1);
        $this->db->where("sale_payment_type", 'custom');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->row()->sale_pymnt_amount) {
            return $query->row()->sale_pymnt_amount;
        } else {
            return 0;
        }
    }
    //Sales get information
    public function get_sale_info($id)
    {
        $this->db->select('s.*,q.qts_reference_no');
        $this->db->select('u.user_first_name as waitername');
        $this->db->select('ca.user_first_name as cashier');
        $this->db->from('sales s');
        $this->db->join('user u', 'u.user_id = s.waiter_id', 'left');
        $this->db->join('user ca', 'ca.user_id = s.user', 'left');
        $this->db->join('quotations q', 'q.qts_id = s.qts_id', 'left');
        $this->db->where("s.sale_id", $id);
        $this->db->order_by("s.sale_id", "desc");
        $query = $this->db->get();
        return $query->row_array();
    }
    //Sales item list get by id 
    public function get_sale_item_list_by_sale_id($sale_id,$vaild = 0)
    {
        $this->db->select('sale_items.product_id, sale_items.valid_status,product.product_name, product.product_code, sale_items.quantity, sale_items.discount, sale_items.discount_val, sale_items.unit_price, sale_items.gross_total');
        $this->db->from('sale_items');
        $this->db->join('product', 'sale_items.product_id = product.product_id', 'left');
        $this->db->order_by("sale_items.id", "desc");
        $this->db->where("sale_items.sale_id", $sale_id); //("id !=",$id);
        if($vaild){
            $this->db->where("valid_status", 1);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    //Sales save
    function save_sales(&$supplier_data, $sale_id = false)
    {
        if (!$sale_id) {
            return $this->db->insert($this->tableName, $supplier_data);
        } else {
            $this->db->where('sale_id', $sale_id);
            return $this->db->update($this->tableName, $supplier_data);
        }
    }
    //Sales item save
    function save_sales_item(&$data_item)
    {
        $this->db->insert('sale_items', $data_item);
    }
    //Sales get for report
    function get_all_sales_for_report($srh_warehouse_id = '', $srh_to_date = '', $srh_from_date = '', $sale_id = '', $from = '', $to = '', $srh_customer_id = '', $srh_payment_term = '', $in_type = '', $dine_type = '')
    {
        //echo "<br/>Test".$srh_customer_id;
        $this->db->select('s.* , c.cus_name,c.cus_phone ,SUM(p.sale_pymnt_amount) AS total_paid_amount');
        $this->db->from('sales s');
        $this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
        $this->db->join('sale_payments p', 's.sale_id = p.sale_id', 'left');
        $this->db->order_by("s.sale_id", "desc");
        $this->db->group_by('s.sale_id');
        //$this->db->where("p.sale_payment_type",'sale');
        if ($srh_warehouse_id) {
            $this->db->where("s.warehouse_id", $srh_warehouse_id); //("id !=",$id);
        }
        if ($srh_to_date) {
            $this->db->where("date(s.sale_datetime) <=", $srh_to_date); //("id !=",$id);
        }
        if ($srh_from_date) {
            $this->db->where("date(s.sale_datetime) >=", $srh_from_date); //("id !=",$id);
        }
        if ($sale_id) {
            $this->db->where("s.sale_id =", $sale_id); //("id !=",$id);
        }
        if ($dine_type) {
            $this->db->where("s.dine_type", $dine_type); //("id !=",$id);
        }
        if ($in_type) {
            $this->db->where("s.in_type =", $in_type); //("id !=",$id);
        }
        if ($srh_payment_term) {
            $this->db->where("p.sale_pymnt_paying_by =", $srh_payment_term); //("id !=",$id);
        }
        if ($srh_customer_id) {
            $this->db->where("s.customer_id", $srh_customer_id); //("id !=",$id);
        }
        $this->db->where("s.sale_status != 99"); //("id !=",$id);
        if ($to) {
            $this->db->limit($to, $from);
        } else {
            $this->db->limit(8000);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }
    function get_sales_for_report($srh_warehouse_id = '', $srh_to_date = '', $srh_from_date = '', $sale_id = '', $from = '', $to = '', $srh_customer_id = '', $srh_payment_term = '', $in_type = '', $dine_type = '')
    {
        //echo "<br/>Test".$srh_customer_id;
        $this->db->select('s.sale_datetime,s.sale_id,s.dine_type, s.sale_total , c.cus_name,c.cus_phone');
        $this->db->from('sales s');
        $this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
        $this->db->order_by("s.sale_id", "desc");
        //$this->db->group_by('s.sale_id');
        //$this->db->where("p.sale_payment_type",'sale');
        if ($srh_warehouse_id) {
            $this->db->where("s.warehouse_id", $srh_warehouse_id); //("id !=",$id);
        }
        if ($srh_to_date) {
            $this->db->where("date(s.sale_datetime) <=", $srh_to_date); //("id !=",$id);
        }
        if ($srh_from_date) {
            $this->db->where("date(s.sale_datetime) >=", $srh_from_date); //("id !=",$id);
        }
        if ($sale_id) {
            $this->db->where("s.sale_id =", $sale_id); //("id !=",$id);
        }
        if ($dine_type) {
            $this->db->where("s.dine_type", $dine_type); //("id !=",$id);
        }
        if ($in_type) {
            $this->db->where("s.in_type =", $in_type); //("id !=",$id);
        }
        if ($srh_customer_id) {
            $this->db->where("s.customer_id", $srh_customer_id); //("id !=",$id);
        }
        $this->db->where("s.sale_status != 99"); //("id !=",$id);
        if ($to) {
            $this->db->limit($to, $from);
        } else {
            $this->db->limit(1000);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }
    function get_all_cancelled_sales_for_report($srh_warehouse_id = '', $srh_to_date = '', $srh_from_date = '', $sale_id = '', $from = '', $to = '', $srh_customer_id = '', $srh_payment_term = '', $in_type = '')
    {
        //echo "<br/>Test".$srh_customer_id;
        $this->db->select('s.* , c.cus_name ,c.cus_phone,SUM(p.sale_pymnt_amount) AS total_paid_amount');
        $this->db->from('sales s');
        $this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
        $this->db->join('sale_payments p', 's.sale_id = p.sale_id', 'left');
        $this->db->order_by("s.sale_id", "desc");
        $this->db->group_by('s.sale_id');
        //$this->db->where("p.sale_payment_type",'sale');
        if ($srh_warehouse_id) {
            $this->db->where("s.warehouse_id", $srh_warehouse_id); //("id !=",$id);
        }
        if ($srh_to_date) {
            $this->db->where("s.sale_datetime <=", $srh_to_date); //("id !=",$id);
        }
        if ($srh_from_date) {
            $this->db->where("s.sale_datetime >=", $srh_from_date); //("id !=",$id);
        }
        if ($sale_id) {
            $this->db->where("s.sale_id =", $sale_id); //("id !=",$id);
        }
        if ($in_type) {
            $this->db->where("s.in_type =", $in_type); //("id !=",$id);
        }
        if ($srh_payment_term) {
            $this->db->where("p.sale_pymnt_paying_by =", $srh_payment_term); //("id !=",$id);
        }
        if ($srh_customer_id) {
            $this->db->where("s.customer_id", $srh_customer_id); //("id !=",$id);
        }
        $this->db->where("s.sale_status", 99); //("id !=",$id);
        if ($to) {
            $this->db->limit($to, $from);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }
    //Sales all get
    function get_all_sales($customer_id, $ss, $ps, $srh_location_id, $start = '', $length = '', $search_key_val = '', $item_count = '', $order = '', $srh_from_date = '', $srh_to_date = '', $srh_user_id = '')
    {
        if($item_count){
            $this->db->select('count(sales.sale_id) as count');
        }else{
            $this->db->select('sales.*, customer.cus_name');
            $this->db->select('u.user_first_name as cashier');
            $this->db->select('w.user_first_name as waiter');
        }
        
        $this->db->from('sales');
        $this->db->join('user u', 'sales.user = u.user_id', 'left');
        $this->db->join('user w', 'sales.waiter_id = w.user_id', 'left');
        $this->db->join('customer', 'sales.customer_id = customer.cus_id', 'left');
    
        if ($order) {
                $col_name = 'sale_datetime';
                $odr = 'DESC';
                switch ($order['column']) {
                    case 0:
                        $col_name = 'sale_datetime';
                        $odr = $order['dir'];
                        break;
                    case 1:
                        $col_name = 'sale_id';
                        $odr = $order['dir'];
                        break;
                    case 2:
                        $col_name = 'customer.cus_name';
                        $odr = $order['dir'];
                        break;
                    case 3:
                        $col_name = 'sale_total';
                        $odr = $order['dir'];
                        break;
                    default:
                        $col_name = 'sale_datetime';
                        $odr = 'DESC';
                        break;
                }
                $this->db->order_by($col_name, $odr);
        }
        /*if ($this->session->userdata('ss_user_id') == 9) {
        } else {
            $this->db->order_by("sale_datetime", "desc");
        }*/
    
        $this->db->where("sales.sale_id IS NOT NULL");
    
        if ($search_key_val) {
            $this->db->where("(sales.sale_id LIKE '%$search_key_val%' OR customer.cus_name LIKE '%$search_key_val%')");
        }
        if ($srh_to_date) {
            $this->db->where("sales.sale_datetime <=", $srh_to_date);
        }
        if ($srh_from_date) {
            $this->db->where("sales.sale_datetime >=", $srh_from_date);
        }
        if ($customer_id > 0) {
            $this->db->where("sales.customer_id", $customer_id);
        }
        if ($srh_user_id) {
            $this->db->where("sales.user", $srh_user_id);
        }
        if ($srh_location_id > 0) {
            $this->db->where("sales.warehouse_id", $srh_location_id);
        }
        if ($ss != '') {
            $this->db->where("sales.sale_status", $ss);
        }
        if ($ps != '') {
            $this->db->where("sales.payment_status", $ps);
        }
        /*if ($this->session->userdata('ss_group_id') == '3') {
            // Additional filtering for cashiers
            $this->db->where("sales.float_id", $this->session->userdata('ss_cashier_float_id'));
        }*/
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
        }
        $query = $this->db->get();
    
        if ($item_count) {
            return $query->row()->count;
        } else {
            return $query->result_array();
        }
    }
    function get_all_sales_count($customer_id,$ss,$ps,$srh_location_id,$search_key_val, $srh_from_date, $srh_to_date, $srh_user_id)
    {
        $search_key_val = "";
        $this->db->select('COUNT(sales.sale_id) AS count_s');
        $this->db->from('sales');
        $this->db->where("sales.sale_id IS NOT NULL"); //("id !=",$id);
        if ($search_key_val) {
            $this->db->where("sales.sale_reference_no LIKE '%$search_key_val%' OR customer.cus_name LIKE '%$search_key_val%'");
        }
        if ($srh_to_date) {
            $this->db->where("sales.sale_datetime <=", $srh_to_date);
        }
        if ($srh_from_date) {
            $this->db->where("sales.sale_datetime >=", $srh_from_date);
        }
        if ($srh_user_id) {
            $this->db->where("sales.user", $srh_user_id);
        }
        if ($srh_location_id > 0) {
            $this->db->where("sales.warehouse_id", $srh_location_id);
        }
        if ($customer_id > 0) {
            $this->db->where("sales.customer_id", $customer_id);
        }
        if ($ss != '') {
            $this->db->where("sales.sale_status", $ss);
        }
        if ($ps != '') {
            $this->db->where("sales.payment_status", $ps);
        }
        //$this->db->join('customer', 'sales.customer_id = customer.cus_id', 'left');
        //$this->db->where("sales.sale_id IS NOT NULL"); //("id !=",$id);
        /*if ($search_key_val) {
        $this->db->where("sales.sale_reference_no LIKE '%$search_key_val%' OR customer.cus_name LIKE '%$search_key_val%'");
        }*/
        $query = $this->db->get();
        return $query->row()->count_s;
    }
    //Sales get for print
    function get_all_sales_for_print_sales()
    {
        $this->db->select('s.* , c.cus_name ,SUM(p.sale_pymnt_amount) AS total_paid_amount');
        $this->db->from('sales s');
        $this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
        $this->db->join('sale_payments p', 's.sale_id = p.sale_id', 'left');
        $this->db->order_by("s.sale_id", "desc");
        $this->db->group_by('s.sale_id');
        $this->db->where("s.sale_id IS NOT NULL"); //("id !=",$id);
        $query = $this->db->get();
        return $query->result_array();
    }
    //Sales payment get 
    function get_sale_payments_by_sale_id($sale_id,$valid=0)
    {
        //echo $sale_id;
        $this->db->select('sale_payments.*,user.user_first_name,user_group.user_group_name');
        $this->db->from('sale_payments');
        $this->db->join('user', 'sale_payments.user_id = user.user_id', 'left');
        $this->db->join('user_group', 'user.group_id = user_group.user_group_id', 'left');
        $this->db->order_by("sale_payments.sale_pymnt_id", "desc");
        $this->db->where("sale_payments.sale_id", $sale_id);
        $this->db->where("sale_payments.sale_payment_type", 'sale');
        if($valid)
            $this->db->where("sale_payments.valid_status", 1);
        $query = $this->db->get();
        return $query->result();
    }
    //Get product sujetions
    function get_products_suggestions($term)
    {
        $this->db->select('product.*');
        $this->db->order_by("product_name", "asc");
        //$this->db->where("product_name LIKE '%$term%'");
        $this->db->where("product_name LIKE '%$term%' OR product_code LIKE '%$term%'");
        $this->db->limit(10, 0);
        $query = $this->db->get('product');
        //echo $this->db->last_query();
        return $query->result_array();
    }
    //Get all products
    function get_all_products()
    {
        $this->db->select('product' . '.*');
        $this->db->order_by("product_name", "asc");
        $this->db->where("product_id IS NOT NULL"); //("id !=",$id);
        $query = $this->db->get('product');
        return $query->result_array();
    }
    //Sales payment save
    function save_sale_payments(&$data, $sale_pymnt_id = false)
    {
        if (!$sale_pymnt_id) {
            return $this->db->insert('sale_payments', $data);
        } else {
            $this->db->where('supp_id', $sale_pymnt_id);
            return $this->db->update('sale_payments', $data);
        }
    }
    public function get_purchase_info_r($id)
    {
        $this->db->select('*');
        $this->db->from('purchases');
        $this->db->where("purchases.id", $id);
        $this->db->order_by("purchases.id", "desc");
        $query = $this->db->get();
        //print_r ($query-> result());
        return $query->row_array();
    }
    function get_products_suggestions_r($term, $sale_id)
    {
        $query = $this->db->query("SELECT * FROM `product` WHERE `product_code` LIKE '%$term%' OR `product_name` LIKE '%$term%' LIMIT 15");
        return $query->result();
    }
    public function gen_ref_number_booking($column_name, $table_name, $type_code, $whecol = '', $wheval = '')
    {
        $this->db->select_max($table_name . '.' . $column_name);
        if ($whecol) {
            $this->db->where($whecol, $wheval);
        }
        if ($type_code == "Credit") {
            $this->db->where('in_type', 'Credit');
        } else if ($type_code == "Contract") {
            $this->db->where('in_type', 'Contract');
        } else {
            $this->db->where("in_type != 'Credit'");
            $this->db->where("in_type != 'Contract'");
        }
        $query = $this->db->get($table_name);
        if ($query->num_rows() > 0) {
            $g = $query->result();
            $u = $this->set_ref_no($g[0]->$column_name, '');
            return $u;
        } else {
            return false;
        }
    }
    function set_ref_no($f, $t)
    {
        $w = '';
        $d = date('Y/m/');
        if ($t) {
            $w = $t;
        }
        $w = $w . sprintf("%03d", $f + 1);
        return $w;
    }
    public function get_sold_qty_and_amount($warehouse_id, $product_id, $srh_from_date = '', $srh_to_date = '')
    {
        $this->db->select_sum('si.quantity');
        $this->db->select_sum('s.sale_total');
        $this->db->from('sale_items si');
        $this->db->join('sales s', 's.sale_id = si.sale_id', 'left');
        $this->db->where('s.warehouse_id', $warehouse_id);
        $this->db->where('si.product_id', $product_id);
        if ($srh_to_date) {
            $this->db->where("s.sale_datetime <=", $srh_to_date); //("id !=",$id);
        }
        if ($srh_from_date) {
            $this->db->where("s.sale_datetime >=", $srh_from_date); //("id !=",$id);
        }
        $query = $this->db->get();
        return $query->row();
    }
    public function get_total_sales($warehouse_id, $product_id, $srh_from_date = '', $srh_to_date = '')
    {
        $this->db->select_sum('s.sale_total');
        $this->db->from('sales s');
        $this->db->where('s.warehouse_id', $warehouse_id);
        if ($srh_to_date) {
            $this->db->where("s.sale_datetime <=", $srh_to_date); //("id !=",$id);
        }
        if ($srh_from_date) {
            $this->db->where("s.sale_datetime >=", $srh_from_date); //("id !=",$id);
        }
        $query = $this->db->get();
        return $data['sale_total'] = $query->row()->sale_total;
    }
    function get_sale_print()
    {
        $this->db->select('sales.*');
        $this->db->from('sales');
        //$this->db->join('sale_items si');
        $this->db->where('print_status', '0');
        $this->db->or_where('print_status', '2');
        //$this->db->where('printable_status','0');
        $this->db->order_by('sale_id');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }
    function set_printed($sale_id)
    {
        $items = array(
            'print_status' => 1
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
    public function get_sale_id($sale_ref_no)
    {
        $this->db->select('sale_id');
        $this->db->from('sales');
        $this->db->where("uniq_id", $sale_ref_no);
        $query  = $this->db->get();
        $result = $query->row_array();
        if (isset($result['sale_id'])) {
            return $result['sale_id'];
        } else {
            return 0;
        }
    }
    public function get_kot_info($id)
    {
        $this->db->select('*');
        $this->db->from('kot_master');
        $this->db->where("kot_id", $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_pending_kot_info()
    {
        $this->db->select('*');
        $this->db->from('kot_master');
        $this->db->where("is_auto_printed", 0);
        $this->db->order_by("kot_id", "asc");
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }
    function delete_sale_item_dis($id)
    {
        if ($id > 0) {
            $this->db->where('id', $id);
            return $this->db->delete('sale_items');
        } else {
            return false;
        }
    }
    function get_sale_id_by_sale_item_id($id)
    {
        $this->db->select('sales.sale_id,sales.warehouse_id,sales.sale_datetime');
        $this->db->from('sales');
        $this->db->join('sale_items', 'sales.sale_id = sale_items.sale_id', 'left');
        $this->db->where("sale_items.id", $id);
        $query = $this->db->get();
        return $query->row();
    }
    function get_sale_item_info($id)
    {
        $this->db->select('product_id,quantity,unit_price');
        $this->db->from('sale_items');
        $this->db->where("id", $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function get_sale_item_total($id)
    {
        $this->db->select_sum('si.cost_total');
        $this->db->select_sum('si.gross_total');
        $this->db->from('sale_items si');
        $this->db->where('si.sale_id', $id);
        $this->db->where('si.valid_status', 1);
        $query  = $this->db->get();
        $result = $query->row_array();
        /*echo $this->db->last_query();*/
        if (isset($result['gross_total'])) {
            return $return_data = array(
                'cost_total' => $result['cost_total'],
                'gross_total' => $result['gross_total']
            );
        } else {
            return $return_data = array(
                'cost_total' => 0,
                'gross_total' => 0
            );
        }
    }
    function update_sale_master($sale_id, $data)
    {
        if (!$sale_id)
            return false;
        $this->db->where('sale_id', $sale_id);
        if ($this->db->update('sales', $data)) {
            return true;
        }
        return false;
    }
    function sale_pymnts_delete_by_sp_id($id)
    {
        if ($id > 0) {
            $this->db->where('sale_pymnt_id', $id);
            $result =  $this->db->update('sale_payments',array('valid_status'=> 0));
            return $this->db->affected_rows() > 0 ? true: false;
            /*$this->db->where('sale_pymnt_id', $id);
            $result =  $this->db->delete('sale_payments');
            return $this->db->affected_rows() > 0 ? true: false;*/
        } else {
            return false;
        }
    }
    function update_sale_record($row){
        
        $sale_id = $row['sale_id'];
        $total_paid_amount = $this->get_total_paid_by_sale_id($sale_id);
        $total_advance_paid_amount = 0;
        
        if($row['qts_id'])
            $total_advance_paid_amount = $this->Sales_Model->get_total_advance_by_qts_id($row['qts_id']);
            
        $total_paid_amount += $total_advance_paid_amount;
        
        $return_tot_amt    = 0;//$this->Sales_Return_Model->get_total_return_by_sale_id($sale_id);
        $to_be_paid        = $row['sale_total'] - $return_tot_amt;
        $balance = $to_be_paid - $total_paid_amount;
        
        $pay_st = 'pending';
        if($balance == 0){
            $pay_st = 'paid';
        }else if($balance < $to_be_paid){
            $pay_st = 'partial';
        }
        $update = array(
            'total_paid' => $total_paid_amount,
            'total_balance' => $balance,
            'payment_status' => $pay_st,
        );
        $this->db->where('sale_id',$sale_id);
        if($this->db->update('sales',$update)){
            
            return true;
            
        }else{
            
            return false;
        }
    }
    function delete_sale_payments_dis($id)
    {
        if ($id > 0) {
            $this->db->where('sale_id', $id);
            $result =  $this->db->delete('sale_payments');
            return $this->db->affected_rows() > 0 ? true: false;
        } else {
            return false;
        }
    }
    function sales_delete_dis($id)
    {
        if ($id > 0) {
            $this->db->trans_start();
            $this->cancel_movements($id);
            $this->db->where('sale_id', $id);
            $this->db->delete('sales');
            $this->db->trans_complete();
            return $this->db->affected_rows() > 0 ? true: false;
        } else {
            return false;
        }
    }
    function cancel_movements($id){
        //SELECT * FROM `stock_movements` WHERE `origin` = 'sale' AND `origin_id` LIKE '0100001819082757001'
        
        $this->db->select('*');
        $this->db->from('stock_movements');
        //$this->db->where('origin', 'sale');
        $this->db->where('origin_id', $id);
        $query = $this->db->get();
        
        $trans_ids = array();
        if ($query->num_rows() > 0) {
            // echo $this->db->last_query();
            $result = $query->result();
            // print_r($result);
            foreach($result as $row){
                $trans_ids[] = $row->transaction_id;
            }
        } else {
            
        }
        // delete stock movements header files - DB trigger will delete the rest
        if(!empty($trans_ids)){
            foreach($trans_ids as $id){
                $this->db->where('trans_id', $id);
                $this->db->delete('stock_movements_master');
            }
        }
    }
    function update_advance_sale_payment($data, $id)
    {
        if ($id > 0) {
            $this->db->where('sale_id', $id);
            $this->db->where('qutation_id', $id);
            return $this->db->update('sale_payments', $data);
        } else {
            return false;
        }
    }
    function get_advance_qty_sale_payments_by_sale_id($sale_id)
    {
        $this->db->select('sale_payments.*,user.user_first_name,user_group.user_group_name');
        $this->db->from('sale_payments');
        $this->db->join('user', 'sale_payments.user_id = user.user_id', 'left');
        $this->db->join('user_group', 'user.group_id = user_group.user_group_id', 'left');
        $this->db->order_by("sale_payments.sale_pymnt_id", "desc");
        $this->db->where("sale_payments.qutation_id", $sale_id);
        $this->db->where("sale_payments.sale_payment_type", 'custom');
        $query = $this->db->get();
        return $query->result();
    }
    function get_all_sales_for_report_new($srh_warehouse_id = '', $srh_to_date = '', $srh_from_date = '', $sale_id = '', $from = '', $to = '', $srh_customer_id = '', $srh_payment_term = '', $in_type = '', $dine_type = '')
    {
        $this->db->select('s.* , c.cus_name,c.cus_phone');
        $this->db->from('sales s');
        $this->db->join('customer c', 's.customer_id = c.cus_id', 'inner');
        $this->db->order_by("s.sale_id", "desc");
        if ($srh_warehouse_id) {
            $this->db->where("s.warehouse_id", $srh_warehouse_id); //("id !=",$id);
        }
        if ($srh_to_date) {
            $this->db->where("date(s.sale_datetime) <=", $srh_to_date); //("id !=",$id);
        }
        if ($srh_from_date) {
            $this->db->where("date(s.sale_datetime) >=", $srh_from_date); //("id !=",$id);
        }
        if ($sale_id) {
            $this->db->where("s.sale_id =", $sale_id); //("id !=",$id);
        }
        if ($dine_type) {
            $this->db->where("s.dine_type", $dine_type); //("id !=",$id);
        }
        if ($in_type) {
            $this->db->where("s.in_type =", $in_type); //("id !=",$id);
        }
        if ($srh_payment_term) {
            //$this->db->where("p.sale_pymnt_paying_by =", $srh_payment_term); //("id !=",$id);
        }
        if ($srh_customer_id) {
            $this->db->where("s.customer_id", $srh_customer_id); //("id !=",$id);
        }
        $this->db->where("s.sale_status != 99"); //("id !=",$id);
        if ($to) {
            $this->db->limit($to, $from);
        } else {
            $this->db->limit(500);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }
}