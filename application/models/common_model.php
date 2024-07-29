<?php
class Common_Model extends CI_Model
{
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
    function get_all_country()
    {
        $this->db->select('country_id, country_short_name');
        $this->db->order_by("country_short_name", "asc");
        $this->db->where("country_status", "1");
        $query = $this->db->get('mstr_country');
        return $query->result_array();
    }
	
	 public function check_option_valable_by_setting_id($sett_id) {
		$this->db->select('s.sett_status');
		$this->db->from('setting s');
		$this->db->where("s.sett_id", $sett_id);
		//$this->db->where('sis.pis_number',$pis_number);
		//$query = $this->db->get('s.sett_status');
		$query = $this->db->get();
		$rtn_des=$query->result();
		return intval($rtn_des[0]->sett_status);
   }
   function search_city_by_name_and_country_id($cname,$country_id) {
        $this->db->select('c.cid,c.cname,delivery_charge');
        $this->db->from('mstr_city c');
        $this->db->order_by("c.cname", "asc");
        
        if($cname != "")
            $this->db->or_like('c.cname',$cname);
            
		$this->db->where("country_id", $country_id);
		$this->db->where("status",1);
	    $this->db->LIMIT(100);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
   
    function get_all_status()
    {
        $this->db->select('mstr_status.*');
        $this->db->order_by("status_order", "desc");
        $this->db->where("status_staus", "1");
        $query = $this->db->get('mstr_status');
        return $query->result_array();
    }
    function get_all_cr_limit()
    {
        $this->db->select('cr_limit_id, cr_limit_name');
        $this->db->order_by("cr_limit_status", "asc");
        $this->db->where("cr_limit_status", "1");
        $query = $this->db->get('mstr_cr_limit');
        return $query->result();
    }
    public function get_country_name_by_id($country_id)
    {
        $this->db->select('country_short_name');
        $this->db->order_by("country_short_name", "asc");
        $this->db->where("country_id", $country_id);
        $query = $this->db->get('mstr_country');
        return $query->result_array();
    }
    public function get_city_list_by_country_id($country_id)
    {
        $this->db->select('cname,cid');
        $this->db->order_by("cname", "asc");
        $this->db->where("country_id", $country_id);
        $query = $this->db->get('mstr_city');
        //echo $this->db->last_query();
        return $query->result();
    }
    public function gen_ref_number($column_name, $table_name, $type_code)
    {
        $this->db->select_max($column_name);
        $query = $this->db->get($table_name);
        if ($query->num_rows() > 0) {
            $g = $query->result();
            $u = $this->set_ref_no($g[0]->$column_name, $type_code);
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
        $w = $w . sprintf("%04d", $f + 1);
        return $w;
    }
    public function add_fi_table($type, $ref_id, $product, $quantity, $unit_cost)
    {
        $data = array(
            'fi_type_id' => $type,
            'fi_ref_id' => $ref_id,
            'fi_item_id' => $product,
            'fi_qty' => $quantity,
            'fi_cost' => $unit_cost
        );
        if ($this->db->insert('fi_table', $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    //User Activitie
    public function add_user_activitie($details)
    {
        $data = array(
            'details' => $details,
            'page' => base_url(uri_string()),
            'user_id' => $this->session->userdata('ss_user_id'),
            'warehouse_id' => $this->session->userdata('ss_warehouse_id'),
            'datetime' => date("Y-m-d H:i:s"),
            'ip' => $this->input->ip_address()
        );
         if($this->db->insert('logs', $data))
        {
             return $this->db->insert_id();
        }
        else
        {
            return false;
        }
    }
    public function is_avalable_for_use_this_link_for_user($group_id, $page)
    {
        $this->db->select('usrgp_permission_page,usrgp_permission_view,usrgp_permission_add,usrgp_permission_edit,usrgp_permission_delete');
        $this->db->from('user_group_permission');
        //$array = array('user_group_id' => $group_id, 'usrgp_permission_page' => $page);
        $array = array(
            'user_group_id' => $group_id
        );
        $this->db->where($array);
        $this->db->order_by("user_group_id", "desc");
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }
    public function insert_transaction($data) {
        return $this->db->insert('financial_transactions', $data);
    }
    
    /**/
    
    public function update_list()
    {
        $sales         = $this->get_credit_sales();
        foreach ($sales as $row) {
            $nestedData      = array();
            $sale_id         = $row['sale_id'];
            $order_yype_name = "";
            if ($row['dine_type'] == 1) {
                $order_yype_name = "DINE-IN";
            }
            if ($row['dine_type'] == 2) {
                $order_yype_name = "TAKE-AWAY";
            }

            $total_paid_amount = $this->get_total_paid_by_sale_id($sale_id);
            $total_advance_paid_amount = 0;
            
            if($row['qts_id'])
                $total_advance_paid_amount = $this->get_total_advance_by_qts_id($row['qts_id']);
                
            $total_paid_amount += $total_advance_paid_amount;
            
            $return_tot_amt    = $this->get_total_return_by_sale_id($sale_id);
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
            $this->db->update('sales',$update);
        }
    }
    function get_total_return_by_sale_id($sale_id)
    {
        $this->db->select_sum('sp.sale_pymnt_amount');
        $this->db->from('sale_payments sp');
        $this->db->join('sales_return sr', 'sr.sl_rtn_id = sp.sale_id', 'left');
        $this->db->where("sp.sale_payment_type", 'sales_return');
        $this->db->where("sr.sale_id", $sale_id);
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
        $this->db->where("sale_payment_type", 'custom');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->row()->sale_pymnt_amount) {
            return $query->row()->sale_pymnt_amount;
        } else {
            return 0;
        }
    }
     function get_total_paid_by_sale_id($sale_id)
    {
        $this->db->select_sum('sale_pymnt_amount');
        $this->db->from('sale_payments');
        $this->db->where("sale_id", $sale_id)->where("(sale_payment_type='sale' OR sale_payment_type='pos_sale')");
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->row()->sale_pymnt_amount) {
            return $query->row()->sale_pymnt_amount;
        } else {
            return 0;
        }
    }
    function get_credit_sales()
    {
        $this->db->select('sales.*, customer.cus_name');
        $this->db->select('u.user_first_name as cashier');
        $this->db->select('w.user_first_name as waiter');
        $this->db->from('sales');
        $this->db->join('user u', 'sales.user = u.user_id', 'left');
        $this->db->join('user w', 'sales.waiter_id = w.user_id', 'left');
        $this->db->join('customer', 'sales.customer_id = customer.cus_id', 'left');
        $this->db->where("sales.payment_status != ", "paid"); 
        $this->db->order_by("sales.sale_datetime", "desc"); 
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_usage(){
        // Execute the shell command to get CPU usage
        exec("top -bn1 | grep 'Cpu(s)' | sed 's/.*, *\\([0-9.]*\\)%* id.*/\\1/'", $output);
        
        // Get the CPU usage percentage
        $cpuUsage = 100 - floatval($output[0]);
        
        return $cpuUsage;
        /*echo json_encode(array(
            'usage' => $cpuUsage
        ));*/
    }
    function list_menu(){
        $this->db->select('*');
 		$this->db->where("menu_status", "1");
 		$nav_sub = $this->db->get('access_points');
 		return $nav_sub->result_array();
    }
}