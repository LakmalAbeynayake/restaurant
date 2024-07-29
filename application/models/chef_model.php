<?php
class chef_Model extends CI_Model
{
    private $tableName = 'chef';
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library(array(
            'email'
        ));
    }
    /*
    Attempts to login employee and set session. Returns boolean based on outcome.
    */
    /*function login($user_username, $user_password)
    {
    $paa = hash('sha512', $user_password); 
    $this->db->select('user.*');
    $this->db->from('user');
    $this->db->where("user_username",$user_username);
    $this->db->where("user_password",$paa);
    $query = $this->db->get();
    //echo $this->db->last_query();
    if ($query->num_rows()==1)
    {
    $row=$query->row();
    $newdata = array(
    'user_id'  => $row->user_id
    );
    return $row->user_id;
    }
    return false;
    }
    
    public function is_logged_in_k()
    {
    
    if($this->session->userdata('ss_user_id'))
    {
    
    return true;
    }
    else
    {
    return false;
    }
    
    }
    
    function checkLoginPanel_k()
    {
    redirect(base_url('login'),'refresh');
    exit();
    
    }    
    
    public function get_all_user_activitie_for_report($srh_warehouse_id,$srh_to_date,$srh_from_date,$from='',$to='')
    {
    $this->db->select("l.*,u.*");
    $this->db->from("logs l");
    $this->db->join("user u", "u.user_id = l.user_id", "left"); 
    $this->db->join("warehouses w", "w.id = l.warehouse_id", "left");
    if($srh_warehouse_id){
    $this->db->where("l.warehouse_id",$srh_warehouse_id);//("id !=",$id);
    }
    if($srh_to_date){
    $this->db->where("l.datetime <=",$srh_to_date);//("id !=",$id);
    }
    if($srh_from_date){
    $this->db->where("l.datetime >=",$srh_from_date);//("id !=",$id);
    }
    if($to){
    $this->db->limit($to,$from);
    }    
    $this->db->group_by("l.id");
    $this->db->order_by("l.id", "desc");
    $query = $this->db->get();  
    // echo $this->db->last_query();
    return $query->result_array();
    }
    
    public function add_chef()
    {
    $data=array(
    'user_first_name'=>$this->input->post('user_first_name'),
    'user_last_name'=>$this->input->post('user_last_name'),
    'user_username'=>$this->input->post('user_username')
    );
    $this->db->insert('chef',$data);
    }
    
    function create_user_sessions($sesdata){
    
    
    $this->session->sess_expiration = 32140800; //~   one year
    $this->session->sess_expire_on_close = 'false';
    $this->session->set_userdata($sesdata);
    
    }
    
    
    
    function delete_user_sessions($sesdata){
    //$array_items = array('username', 'email');
    $this->session->unset_chefdata($sesdata);
    
    }
    
    function getUsers()
    {
    $this->db->select('u.* , ug.user_group_name');
    $this->db->from('user u');
    $this->db->join('user_group ug', 'u.group_id = ug.user_group_id', 'left');   
    $this->db->order_by("u.user_id", "desc");
    $query = $this->db->get();
    
    if($query->num_rows() >0)
    {
    return $query->result();
    }
    else
    {
    return false;
    }
    
    }
    */
    function chef_details($start, $length, $search_key_val)
    {
        $this->db->select("c.*");
        $this->db->from("chef c");
        //$this->db->join('product p','p.product_id=si.product_id');
        //$this->db->join('sales S','S.sale_id=si.sale_id');
        if ($search_key_val) {
            $this->db->where("c.chef_Fname LIKE '%$search_key_val%' OR c.chef_Lname LIKE '%$search_key_val%'  OR c.chef_id LIKE '%$search_key_val%'   ");
        }
        //$this->db->where("sales.in_type != 'Contract'");                
        //        $this->db->where("sales.in_type","cash");        
        //        $this->db->where("sales.in_type","wholesale");        
        //        $this->db->where("sales.in_type","credit");    
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
        }
        $query = $this->db->get();
        return $query->result('array');
    }
    function chef_items_details($start, $length, $search_key_val)
    {
        $this->db->select("p.*");
        $this->db->from("product p");
        //$this->db->join('product p','p.product_id=si.product_id');
        //$this->db->join('sales S','S.sale_id=si.sale_id');
        if ($search_key_val) {
            $this->db->where("p.product_name LIKE '%$search_key_val%' OR p.product_code LIKE '%$search_key_val%'  OR p.product_id LIKE '%$search_key_val%' ");
        }
        //$this->db->where("sales.in_type != 'Contract'");                
        //        $this->db->where("sales.in_type","cash");        
        //        $this->db->where("sales.in_type","wholesale");        
        //        $this->db->where("sales.in_type","credit");    
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
        }
        $query = $this->db->get();
        return $query->result('array');
    }
    function saves_chef(&$user_data, $chef_id = false)
    {
        if (!$chef_id) {
            $val = $this->db->insert($this->tableName, $user_data);
            if ($val)
                return TRUE;
            else
                return FALSE;
        } else {
            $this->db->where('chef_id', $chef_id);
            return $this->db->update($this->tableName, $user_data);
            echo $this->db->last_query();
            exit();
            //return TRUE;
        }
    }
    /*
    public function get_user_info($id)
    {
    $this->db->select('u.* , g.user_group_name');
    $this->db->from('user u');
    $this->db->join('user_group g', 'u.group_id = g.user_group_id', 'left');  
    $this->db->where('u.user_id', $id); 
    $this->db->order_by("u.user_id", "desc");
    $query = $this->db->get();
    return $query->row_array();
    
    /*
    $this->db->select('*');
    $this->db->from($this->tableName);
    $this->db->where("user_id", $id);
    $this->db->order_by("user_id", "desc");
    $query = $this->db->get();
    
    return $query->row_array(); 
    }*/
    public function get_chef_info($id)
    {
        $this->db->select('C.* ');
        $this->db->from('chef C');
        //$this->db->join('user_group g', 'u.group_id = g.user_group_id', 'left');  
        $this->db->where('C.chef_id', $id);
        $this->db->order_by("C.chef_id", "desc");
        $query = $this->db->get();
        return $query->row_array();
    }
    function save_chef_pw(&$user_data, $chef_id = false)
    {
        if (!$chef_id) {
            $val = $this->db->insert($this->tableName, $user_data);
            if ($val)
                return TRUE;
            else
                return FALSE;
        } else {
            $this->db->where('chef_id', $chef_id);
            return $this->db->update($this->tableName, $user_data);
            echo $this->db->last_query();
            exit();
            //return TRUE;
        }
    }
    public function delete_chef($chef_id)
    {
        $this->db->where('chef_id', $chef_id);
        $this->db->delete('chef');
    }
    public function disable_user($chef_id)
    {
        $data = array(
            'chef_status' => 0
        );
        $this->db->where('chef_id', $chef_id);
        $this->db->update('chef', $data);
    }
    public function enable_user($chef_id)
    {
        $data = array(
            'chef_status' => 1
        );
        $this->db->where('chef_id', $chef_id);
        $this->db->update('chef', $data);
    }
    function get_all_food_categoray()
    {
        $this->db->select('p.* ');
        $this->db->from('product_category p');
        //$this->db->where('p.cat_id'); 
        $this->db->order_by("p.cat_id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    function get_chef_name()
    {
        $this->db->select('c.* ');
        $this->db->from('chef c');
        //$this->db->where('C.chef_id');   
        //$this->db->join('chef_add_items a','a.chef_id=c.chef_id');
        $this->db->order_by("c.chef_id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    function get_chef_infossss()
    {
        $this->db->select('c.* ');
        $this->db->from('chef c');
        //$this->db->where('C.chef_id');   
        //$this->db->join('chef_add_items a','a.chef_id=c.chef_id');
        $this->db->order_by("c.chef_id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    function get_today_chef_name()
    {
        //$today1 = NOW();
        $today = date('Y-m-d H:i:s.u');
        //$today = strtotime($today);
        //print_r($today);
        $qry   = "SELECT c.chef_Fname,c.chef_id,current_timestamp(6),on_time
                      FROM chef_schdule_details
                    INNER JOIN chef c ON c.chef_id=chef_schdule_details.chef_id
                     WHERE chef_schdule_details.on_time <  current_timestamp(6) AND chef_schdule_details.off_time >  current_timestamp(6)
                    ";
        //$today = STR_TO_DATE(date('Y-m-d'), '%Y-%m-%d');
        $this->db->select('csd.*,c.chef_id ');
        $this->db->select('DATE_FORMAT(csd.on_time, "%Y-%m-%d") as added_date', FALSE);
        $this->db->from('chef_schdule_details csd');
        $this->db->join('chef c', 'c.chef_id=csd.chef_id');
        $this->db->where("DATE_FORMAT(csd.on_time, '%Y-%m-%d')", $today);
        $this->db->limit('1');
        $query = $this->db->query($qry);
        //$query = $this->db->get();
        return $query->result();
    }
    public function get_chef_infos($id)
    {
        $this->db->select('C.* ');
        $this->db->from('chef C');
        //$this->db->join('user_group g', 'u.group_id = g.user_group_id', 'left');  
        $this->db->where('C.chef_id', $id);
        $this->db->order_by("C.chef_id", "desc");
        $query = $this->db->get();
        return $query->row_array();
        /*
        $this->db->select('*');
        $this->db->from($this->tableName);
        $this->db->where("user_id", $id);
        $this->db->order_by("user_id", "desc");
        $query = $this->db->get();
        
        return $query->row_array(); */
    }
    function get_product_category_name($id)
    {
        $this->db->select('p.cat_name ');
        $this->db->from('product_category p');
        $this->db->where('p.cat_id', $id);
        // $this->db->order_by("p.product_category", "desc");
        $query = $this->db->get();
        return $query->row_array();
    }
    function get_products_suggestions($term)
    {
        $this->db->select('product' . '.*');
        $this->db->order_by("product_name", "asc");
        //$this->db->where("product_name LIKE '%$term%'");
        $this->db->where("product_name LIKE '%$term%' OR product_code LIKE '%$term%' OR product_oem_part_number LIKE '%$term%' OR product_part_no LIKE '%$term%'");
        $this->db->limit(10, 0);
        $query = $this->db->get('product');
        //echo $this->db->last_query();
        return $query->result_array();
    }
    //Sales save
    function save_sales(&$supplier_data, $sale_id = false)
    {
        if (!$sale_id) {
            $this->db->insert('chef_add_items', $supplier_data);
        } else {
            $this->db->where('sale_id', $sale_id);
            return $this->db->update('chef_add_items', $supplier_data);
        }
    }
    //Sales item save
    function save_sales_item(&$data_item, $lastid)
    {
        //$this->db->insert('chef_add_items',$data_item);
        $this->db->where('item_id', $lastid);
        return $this->db->update('chef_add_items', $data_item);
    }
    function get_avalable_product_qty($product_id, $warehouse_id)
    {
        $this->db->select_sum('fi_qty');
        $query = $this->db->get('fi_table');
        return $query->row()->fi_qty;
    }
    function get_chef_suggestions($term)
    {
        $this->db->select('chef' . '.*');
        $this->db->order_by("chef_Fname", "asc");
        //$this->db->where("product_name LIKE '%$term%'");
        $this->db->where("chef_Fname LIKE '%$term%' OR chef_id LIKE '%$term%' ");
        $this->db->limit(10, 0);
        $query = $this->db->get('chef');
        //echo $this->db->last_query();
        return $query->result_array();
    }
    function save_chef_schdule(&$supplier_data, $sale_id = false)
    {
        if (!$sale_id) {
            $this->db->insert('chef_schdule_details', $supplier_data);
        } else {
            $this->db->where('sale_id', $sale_id);
            return $this->db->update('chef_schdule_details', $supplier_data);
        }
    }
    function save_chef_name_for_schdule(&$data_item, $sale_id, $lastid)
    {
        $this->db->insert('chef_schdule_details', $data_item);
        //$this->db->where('chef_schdule_details_id', $lastid);
        //return $this->db->update('chef_schdule_details',$data_item);
    }
    function chef_schdule_details($start, $length, $search_key_val)
    {
        $this->db->select("s.*");
        $this->db->from("chef_schdule_details s");
        //$this->db->join('product p','p.product_id=si.product_id');
        //$this->db->join('sales S','S.sale_id=si.sale_id');
        if ($search_key_val) {
            $this->db->where("s.on_time LIKE '%$search_key_val%' OR s.off_time LIKE '%$search_key_val%'    ");
        }
        //$this->db->where("sales.in_type != 'Contract'");                
        //        $this->db->where("sales.in_type","cash");        
        //        $this->db->where("sales.in_type","wholesale");        
        //        $this->db->where("sales.in_type","credit");    
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
        }
        $query = $this->db->get();
        return $query->result('array');
    }
    function get_all_sales_for_report($srh_chef_name = '', $srh_to_date = '', $srh_from_date = '', $sale_id = '', $from = '', $to = '', $srh_chef_id = '')
    {
        //echo "<br/>Test".$srh_customer_id;
        $this->db->select("c.chef_Fname as chef_name,csd.*");
        $this->db->from('chef c');
        $this->db->order_by('csd.on_time', 'asc');
        $this->db->join('chef_schdule_details csd', 'c.chef_id = csd.chef_id', 'left');
        //$this->db->join('sale_payments p', 's.sale_id = p.sale_id', 'left');
        //$this->db->order_by("s.sale_id", "desc");
        //$this->db->group_by('s.sale_id');
        //$this->db->where("p.sale_payment_type",'sale');
        //if($srh_warehouse_id){
        //$this->db->where("s.warehouse_id",$srh_warehouse_id);//("id !=",$id);
        //}
        if ($srh_to_date) {
            $this->db->where("csd.on_time <=", $srh_to_date); //("id !=",$id);
        }
        if ($srh_from_date) {
            $this->db->where("csd.off_time >=", $srh_from_date); //("id !=",$id);
        }
        if ($srh_chef_id) {
            $this->db->where("c.chef_id", $srh_chef_id); //("id !=",$id);
        }
        if ($to) {
            $this->db->limit($to, $from);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }
    //Sales all get
    function get_all_sales($start = '', $length = '', $search_key_val = '')
    {
        $this->db->select('sales.*, customer.cus_name');
        $this->db->from('customer');
        $this->db->join('sales', 'sales.customer_id = customer.cus_id', 'left');
        $this->db->order_by("sales.sale_id", "desc");
        $this->db->where("sales.sale_id IS NOT NULL"); //("id !=",$id);
        if ($search_key_val) {
            $this->db->where("sales.sale_reference_no LIKE '%$search_key_val%' OR customer.cus_name LIKE '%$search_key_val%'");
            //$this->db->like('sales.sale_reference_no', $search_key_val);
            //$this->db->like('customer.cus_name', $search_key_val);
        }
        //$this->db->where("product_name LIKE '%$term%' OR product_code LIKE '%$term%' OR product_oem_part_number LIKE '%$term%' OR product_part_no LIKE '%$term%'");
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
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
    function get_all_chefs()
    {
        $this->db->select($this->tableName . '.*');
        $this->db->order_by("chef_id", "asc");
        $this->db->where("chef_status", 1); //("id !=",$id);
        //$this->db->where("cus_id", $id);
        $query = $this->db->get($this->tableName);
        return $query->result_array();
    }
    function load_sale_items($start, $length, $search_key_val, $chef_id)
    {
        $this->db->select('*');
        $this->db->from('chef_add_items');
        $this->db->where("chef_id", $chef_id);
        $qry = $this->db->get();
        $cat = array();
        if ($qry->num_rows > 0) {
            foreach ($qry->result() as $row) {
                $cat[] = $row->cat_id;
            }
        } else {
            return false;
        }
        $this->db->select("si.*");
        $this->db->from("sale_items si");
        $this->db->join('product p', 'p.product_id=si.product_id');
        //$this->db->join('sales S','S.sale_id=si.sale_id');
        $this->db->where_in('p.cat_id', $cat);
        $this->db->where("item_status", 'Pending');
        $query = $this->db->get();
        return $query->result('array');
    }
    function category_change_status($sale_id = '', $item_status = '')
    {
        // if liyna vidihak meka (thnai line eken)
        // $cat_id = ($item_status =='Pending') ? 1 : 0 ;
        if ($item_status == 'Pending') {
            $next_status = 'Cooking';
        } else if ($item_status == 'Cooking') {
            $next_status = 'Finish';
        }
        $data = array(
            'item_status' => $next_status
        );
        $this->db->where('sale_id', $sale_id);
        if ($this->db->update('sale_items', $data)) {
            return true;
        } else {
            return false;
        }
    }
}