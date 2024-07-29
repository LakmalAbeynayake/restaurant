<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Products_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }
    function getUnit()
    {
        $this->db->select('*');
        $this->db->from('mstr_unit');
        $this->db->where('unit_status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    /*function getProductsStockMovReport($product_id = '', $start = '', $length = '', $search_key_val = '')
    {
        $this->db->select('p.* , c.cat_name , c.cat_code , s.sub_cat_name, u.unit_name');
        $this->db->from('product p');
        $this->db->join('product_category c', 'c.cat_id = p.cat_id', 'left');
        $this->db->join('product_sub_category s', 's.sub_cat_id = p.sub_cat_id', 'left');
        $this->db->join('mstr_unit u', 'u.unit_id = p.product_unit', 'left');
        if ($search_key_val) {
            $this->db->where("p.product_name LIKE '%$search_key_val%' OR p.product_code LIKE '%$search_key_val%' OR p.product_oem_part_number LIKE '%$search_key_val%'");
        }
        if ($product_id) {
            $this->db->where('p.product_id', $product_id);
        }
        // $this->db->order_by("p.product_name", "asc");
        $this->db->order_by("p.cat_id", "asc");
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
        }
        // $this->db->limit(30);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }*/
    function search($term,$purchased_id = "")
    {
        if($purchased_id){
            $this->db->select('quantity,item_cost,sub_total,discount,product.product_name,product.product_code');
            $this->db->from('purchase_items');
            $this->db->join("product", " product.product_id = purchase_items.product_id", "left");
            $this->db->where('purchase_items.purchase_id', $purchased_id);
            $query = $this->db->get();
            return $query->result_array();
        }else{
            $this->db->select('product' . '.*');
            $this->db->order_by("product_name", "asc");
            //$this->db->where("product_name LIKE '%$term%'");
            $this->db->where("product_name LIKE '%$term%' OR product_code LIKE '%$term%'");
            $this->db->limit(10, 0);
            $query = $this->db->get('product');
            //echo $this->db->last_query();
            return $query->result_array();
        }
    }
    
    function get_recipe($location_id,$product_id)
    {
        $this->db->select(' recipe_items.*, product.product_name, product.product_code');
        $this->db->from('recipe_items');
        $this->db->join('product', 'product.product_id = recipe_items.ingredient_id', 'left');
        $this->db->where("recipe_items.location_id", $location_id);
        $this->db->where("recipe_items.product_id", $product_id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
    function toggle_recipe_item($where,$prop)
    {
        $this->db->where($where);
        $this->db->update('recipe_items', array('is_active' => $prop));
        return $this->db->affected_rows();
    }
    
    function getTax()
    {
        $this->db->select('*');
        $this->db->from('tax_rates');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_products_suggestions($term,$this_id = '')
    {
        $this->db->select('*');
        $this->db->order_by("product_name", "asc");
        if($this_id){
            $this->db->where("product_name LIKE '%$term%' AND product_id != '$this_id'");
            $this->db->or_where("product_code LIKE '%$term%' AND product_id != '$this_id'");
        }else
            $this->db->where("product_name LIKE '%$term%' OR product_code LIKE '%$term%'");
        
        $this->db->limit(10, 0);
        $query = $this->db->get('product');
        //echo $this->db->last_query();
        return $query->result_array();
    }
    function save_product($data,$upc = false)
    {
        if ($this->db->insert('product', $data)) {
            $insert_id = $this->db->insert_id();
            
            if($upc)
                $this->update_product_code($insert_id);
            
            return $insert_id;
        } else {
            return 0;
        }
    }
    public function update_product($where,$data)
    {   
        $this->db->where($where);
        $this->db->update('product', $data);
        return $this->db->affected_rows();
    }
    public function update_product_code($product_id = '')
    {
        $data = array(
            'product_code' => "PD" . sprintf("%04d", $product_id)
        );
        $this->db->where('product_id', $product_id);
        $this->db->update('product', $data);
        return $product_id;
    }
    function getProducts($pt_id,$cat_id,$sub_cat_id)
    {
        $this->db->select('p.* , c.cat_name , s.sub_cat_name, u.unit_name');
        $this->db->from('product p');
        $this->db->join('product_category c', 'c.cat_id = p.cat_id', 'left');
        $this->db->join('product_sub_category s', 's.sub_cat_id = p.sub_cat_id', 'left');
        $this->db->join('mstr_unit u', 'u.unit_id = p.product_unit', 'left');
        $this->db->where("p.product_type_id", $pt_id);
        if ($cat_id) {
            $this->db->where("p.cat_id", "$cat_id");
        }
        if ($sub_cat_id) {
            $this->db->where("p.sub_cat_id", "$sub_cat_id");
        }
        $this->db->order_by("p.added_time", "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function getProductsProduCodePrint($cat_id = 0, $sub_cat_id = 0)
    {
        $this->db->select('p.* , c.cat_name , s.sub_cat_name, u.unit_name');
        $this->db->from('product p');
        $this->db->join('product_category c', 'c.cat_id = p.cat_id', 'left');
        $this->db->join('product_sub_category s', 's.sub_cat_id = p.sub_cat_id', 'left');
        $this->db->join('mstr_unit u', 'u.unit_id = p.product_unit', 'left');
        if ($cat_id) {
            $this->db->where("p.cat_id", "$cat_id");
        }
        if ($sub_cat_id) {
            $this->db->where("p.sub_cat_id", "$sub_cat_id");
        }
        $this->db->order_by("p.product_id", "asc");
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function getProductsForReport($wherehouse_id = '', $cat_srh = '')
    {
        /*$query=$this->db->query("SELECT p.*,pc.cat_name,psc.sub_cat_name, SUM(IF(ft.fi_type_id ='sale', ft.fi_qty, 0)) AS sold_qty, SUM(IF(ft.fi_type_id ='grn', ft.fi_qty, 0)) AS purchased_qty FROM product p LEFT JOIN fi_table ft ON ft.fi_item_id = p.product_id AND (ft.fi_type_id ='sale' OR ft.fi_type_id ='grn') LEFT JOIN product_category pc ON pc.cat_id = p.cat_id
        LEFT JOIN product_sub_category psc ON psc.sub_cat_id = p.sub_cat_id
        
        WHERE pc.cat_id!='' GROUP BY p.product_id  ORDER BY p.added_time desc");
        
        */
        $this->db->select("product_status,sub_cat_name,product_id,cat_name,product_price,product_cost,product_code,product_name,product_part_no,product_oem_part_number,product_commision");
        $this->db->from('product p');
        $this->db->join("product_category pc", "pc.cat_id = p.cat_id", "left");
        $this->db->join("product_sub_category psc", "psc.sub_cat_id = p.sub_cat_id", "left");
        if ($cat_srh) {
            $this->db->where("pc.cat_id", $cat_srh);
        }
        //$this->db->group_by("p.product_id"); 
        $this->db->order_by("p.cat_id", "asc");
        $this->db->order_by("p.product_name", "asc");
        $query = $this->db->get();
        // $this->db->select("p.* , SUM(IF(ft.fi_type_id ='sale',ft.fi_qty,0)) AS sold_qty");
        // $this->db->from('product p');
        // $this->db->join("fi_table ft", "ft.fi_item_id = p.product_id AND ft.fi_type_id ='sale'", "left");
        // $this->db->group_by("p.product_id"); 
        // $this->db->order_by("p.added_time", "desc");
        // echo $this->db->last_query();
        // $query = $this->db->get();  
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function getProductsForProductReport($cat_srh = '')
    {
        $this->db->select("product_status,product_id,product_price,product_cost,product_code,product_name,product_part_no,product_oem_part_number,product_commision,pc.cat_name");
        $this->db->from('product p');
        $this->db->join("product_category pc", "pc.cat_id = p.cat_id", "inner");
        /*$this->db->join("product_sub_category psc", "psc.sub_cat_id = p.sub_cat_id", "left");*/
        if ($cat_srh) {
            $this->db->where("p.cat_id", $cat_srh);
        }
        $this->db->order_by("p.product_name", "asc");
        $this->db->limit(1000);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function getSupplierProductsForReport($srh_warehouse_id, $supplier_srh)
    {
        $q = '';
        $q = "SELECT p.*,s.supp_company_name,s.supp_code,SUM(IF(ft.fi_type_id ='sale', ft.fi_qty, 0)) AS sold_qty, SUM(IF(ft.fi_type_id ='grn', ft.fi_qty, 0)) AS purchased_qty
        FROM product p 
        LEFT JOIN purchase_items pi ON pi.product_id = p.product_id 
        LEFT JOIN purchases pu ON pu.id = pi.purchase_id
        LEFT JOIN supplier s ON s.supp_id = pu.supplier_id
        LEFT JOIN fi_table ft ON ft.fi_item_id = p.product_id AND (ft.fi_type_id ='sale' OR ft.fi_type_id ='grn')";
        if ($supplier_srh) {
            $q .= "WHERE pu.supplier_id=$supplier_srh";
        } else {
            $q .= "WHERE p.product_id!=0";
        }
        $q .= " GROUP BY p.product_id  
        ORDER BY p.added_time desc";
        //echo "<br/>:".$q;
        $query = $this->db->query($q);
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_product_by_name($name = '', $product_id = '')
    {
        $this->db->select('p.*');
        $this->db->from('product p');
        $this->db->where('p.product_name', $name);
        if ($product_id) {
            $this->db->where_not_in("p.product_id", $product_id);
        }
        $this->db->order_by("p.product_name", "asc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    function get_product_by_id($product_id = '')
    {
        $this->db->select('p.*, c.cat_name, u.unit_name , t.*');
        $this->db->from('product p');
        $this->db->join('product_category c', 'p.cat_id = c.cat_id', 'left');
        $this->db->join('mstr_unit u', 'p.product_unit = u.unit_id', 'left');
        $this->db->join('tax_rates t', 'p.tax = t.id', 'left');
        $this->db->where('p.product_id', $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    function get_product_cost_by_id($product_id = '')
    {
        $this->db->select('p.product_cost');
        $this->db->from('product p');
        $this->db->where('p.product_id', $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    function get_sub_cat_name_by_id($id)
    {
        $this->db->select('s.sub_cat_name');
        $this->db->from('product_sub_category s');
        $this->db->where("s.sub_cat_id", $id);
        $query = $this->db->get();
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            // $name=$query->result();
            return $data['sub_cat_name'] = $query->row()->sub_cat_name;
        } else {
            return false;
        }
    }
    function get_warehouse_product($product_id = '')
    {
        $this->db->select("w.name ,w.code , wp.quantity");
        $this->db->from("warehouses_products wp");
        $this->db->join("warehouses w", "wp.warehouse_id = w.id", "left");
        $this->db->where("wp.product_id", $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_subcategory()
    {
        $this->db->select('*');
        $this->db->from('product_sub_category');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function update_product_($prduct_id, $is_ko, $product_name, $product_code, $category, $subcategory, $unit, $product_cost, $product_price, $wholesale_price, $credit_salling_price, $tax, $alert_quty, $imgName, $imageThumb, $product_details, $product_part_no, $product_oem_part_number, $store_position, $product_max_qty, $product_commision)
    {
        $data1 = array(
            'cat_id' => $category,
            'sub_cat_id' => $subcategory,
            'product_name' => $product_name,
            'product_code' => $product_code,
            'product_image' => $imgName,
            'product_thumb' => $imageThumb,
            'product_alert_qty' => $alert_quty,
            'product_unit' => $unit,
            'product_cost' => $product_cost,
            'product_price' => $product_price,
            'wholesale_price' => $wholesale_price,
            'credit_salling_price' => $credit_salling_price,
            'tax' => $tax,
            'product_details' => $product_details,
            'product_part_no' => $product_part_no,
            'product_oem_part_number' => $product_oem_part_number,
            'store_position' => $store_position,
            'product_max_qty' => $product_max_qty,
            'product_commision' => $product_commision,
            'is_ko' => $is_ko
        );
        $data2 = array(
            'cat_id' => $category,
            'sub_cat_id' => $subcategory,
            'product_name' => $product_name,
            'product_code' => $product_code,
            'product_alert_qty' => $alert_quty,
            'product_unit' => $unit,
            'product_cost' => $product_cost,
            'product_price' => $product_price,
            'wholesale_price' => $wholesale_price,
            'credit_salling_price' => $credit_salling_price,
            'tax' => $tax,
            'product_details' => $product_details,
            'product_part_no' => $product_part_no,
            'product_oem_part_number' => $product_oem_part_number,
            'store_position' => $store_position,
            'product_max_qty' => $product_max_qty,
            'product_commision' => $product_commision,
            'is_ko' => $is_ko
        );
        ;
        if (!empty($imgName) && !empty($imageThumb)) {
            $data = $data1;
        } else {
            $data = $data2;
        }
        $this->db->where('product_id', $prduct_id);
        if ($this->db->update('product', $data)) {
            //print_r($this->db->last_query());
            return true;
        } else {
            return false;
        }
    }
    public function delete_product($product_id = '')
    {
     
       /* if ($this->check_del($product_id)) {
            return false;
        } else {
            $this->db->delete('product', array(
                'product_id' => $product_id
            ));
            return true;
        }*/
         if(!$product_id){return false;}
        $data=array('product_status'=>0);
         $this->db->where('product_id', $product_id);
         if ($this->db->update('product', $data)) {
            return true;
        } else {
            return false;
       
        }
         
    }
    function check_del($product_id = '')
    {
        $this->db->select('product_id');
        $this->db->from('purchase_items');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function get_item_qty($product_id = '')
    {
        $this->db->select('SUM(p.quantity) AS qty');
        $this->db->from('purchase_items p');
        $this->db->where('p.product_id', $product_id);
        $query = $this->db->get();
        if ($query->result()) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    function get_item($product_id)
    {
        $this->db->select_sum('quantity');
        $this->db->from('purchase_items');
        $this->db->where('product_code', $product_id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    //added by namal
	function get_product_id($code)
    {
        $this->db->select('p.product_id');
        $this->db->from('product p');
        $this->db->where("p.product_code", $code);
        $query=$this->db->get();
        $result= $query->row_array();
        if(isset($result['product_id'])){
            return $result['product_id'];
        }else{
            return 0;
        }
    }
    
    //Added by namal
    function get_product_name($code)
    {
        $this->db->select('p.product_name');
        $this->db->from('product p');
        $this->db->where("p.product_code", $code);
        ///echo $this->db->last_query(); 
        $query=$this->db->get();
        $result= $query->row_array();
        if(isset($result['product_name'])){
            return $result['product_name'];
        }else{
            return 0;
        }
    }
    
     public function enable_product($product_id = '')
    {
     
       /* if ($this->check_del($product_id)) {
            return false;
        } else {
            $this->db->delete('product', array(
                'product_id' => $product_id
            ));
            return true;
        }*/
         if(!$product_id){return false;}
        $data=array('product_status'=>1);
         $this->db->where('product_id', $product_id);
         if ($this->db->update('product', $data)) {
            return true;
        } else {
            return false;
       
        }
         
    }
    
    
    
    function save_recipe_items($data){
        $this->db->insert('recipe_items', $data);
        return $this->db->insert_id();
    }
    function delete_recipe_items($location_id,$product_id){
        $this->db->where('location_id', $location_id);
        $this->db->where('product_id', $product_id);
        $this->db->delete('recipe_items');
        return $this->db->affected_rows();
    }
    function get_order_token_types(){
        $this->db->select('*')
                  ->from('order_token_types');
        $query =  $this->db->get();
        return $query->result();
    }
    function get_types(){
        $this->db->select('*')
                  ->from('product_type')
                  ->where('product_type_status' , 1);
        $query =  $this->db->get();
        return $query->result();
    }
    function get_price_types(){
        $this->db->select('*')
                  ->from('price_type');
        $query =  $this->db->get();
        return $query->result();
    }
    function get_product_prices($product_id){
        $this->db->select('product_prices')
                  ->from('product')
                  ->where('product_id',$product_id);
        $query =  $this->db->get();
        if($query->num_rows() > 0)
            return $query->row()->product_prices;
        return json_encode(array());
        //echo $this->db->last_query();
    }

    public function update_to_latest_grn_value($product_id) {
        $this->db->select('unit_value');
        $this->db->from('grn_items');
        $this->db->where('product_id', $product_id);
        $this->db->order_by('grn_itm_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        $unit_value = 0;
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $unit_value = $row->unit_value;
        } else {
            $unit_value = 0;
        }
        
        if($unit_value > 0){
            $this->db->where('product_id',$product_id);
            $this->db->update('product',array('product_cost' => $unit_value));
        }
    }
}
