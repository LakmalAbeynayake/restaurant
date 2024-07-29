<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Transfer_Model extends CI_Model
{
    private $tableName = 'transfer';
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
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
    function getwarehousename($wid)
    {
        $this->db->select('warehouses.name');
        $this->db->from('warehouses');
        $this->db->where("id", $wid);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row_array();
    }
    //Sales genarate referance number
    function get_next_ref_no()
    {
        $this->db->select_max('trnsfr_id');
        return $this->db->get('transfer');
    }
    //Sales get avalable product qty
    function get_avalable_product_qty($product_id, $warehouse_id)
    {
        $this->db->select_sum('fi_qty');
        $query = $this->db->get('fi_table');
        return $query->row()->fi_qty;
    }
    //Sales get information
    public function get_trnsfr_info($id)
    {
        $this->db->select('transfer.*,user.user_first_name,user.user_last_name,user.user_id');
        $this->db->from('transfer');
        $this->db->join('user','user.user_id = transfer.user_id','left');
        $this->db->where("trnsfr_id", $id);
        $this->db->order_by("trnsfr_id", "desc");
        $query = $this->db->get();
        return $query->row_array();
    }
    //Sales item list get by id 
    public function get_trnsfr_item_list_by_trnsfr_id($trnsfr_id)
    {
        $this->db->select('transfer_item.trnsfr_itm_unit_value,transfer_item.product_id, product.product_name, product.product_code, transfer_item.trnsfr_itm_quantity');
        $this->db->from('transfer_item');
        $this->db->join('product', 'transfer_item.product_id = product.product_id', 'left');
        $this->db->order_by("transfer_item.trnsfr_itm_id", "desc");
        $this->db->where("transfer_item.trnsfr_id", $trnsfr_id); //("id !=",$id);
        $query = $this->db->get();
        return $query->result_array();
    }
    //getTransferdQtyByWarehouseId
    public function getTransferdQtyByWarehouseId($warehouse_id, $product_id)
    {
        $this->db->select_sum('ti.trnsfr_itm_quantity');
        $this->db->from('transfer_item ti');
        $this->db->join('transfer t', 't.trnsfr_id = ti.trnsfr_id', 'left');
        $this->db->where('t.trnsfr_from_warehouse_id', $warehouse_id);
        $this->db->where('ti.product_id', $product_id);
        $query = $this->db->get();
        return $data['total_transferd'] = $query->row()->trnsfr_itm_quantity;
    }
    //getTransferResevedQtyByWarehouseId
    public function getTransferResevedQtyByWarehouseId($warehouse_id, $product_id)
    {
        $this->db->select_sum('ti.trnsfr_itm_quantity');
        $this->db->from('transfer_item ti');
        $this->db->join('transfer t', 't.trnsfr_id = ti.trnsfr_id', 'left');
        $this->db->where('t.trnsfr_to_location_id', $warehouse_id);
        $this->db->where('ti.product_id', $product_id);
        $query = $this->db->get();
        return $data['total_transferd'] = $query->row()->trnsfr_itm_quantity;
    }
    //Sales save
    function save_transfer(&$supplier_data, $trnsfr_id = false)
    {
        if (!$trnsfr_id) {
            $this->db->insert($this->tableName, $supplier_data);
        } else {
            $this->db->where('trnsfr_id', $trnsfr_id);
            return $this->db->update($this->tableName, $supplier_data);
        }
    }
    //Sales item save
    function save_transfer_item(&$data_item)
    {
        $this->db->insert('transfer_item', $data_item);
    }
    //Sales get for report
    function get_all_transfer_for_report($srh_warehouse_id = '', $srh_to_date = '', $srh_from_date = '', $trnsfr_id = '', $from = '', $to = '')
    {
        $this->db->select('s.* , c.cus_name');
        $this->db->from('transfer s');
        $this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
        $this->db->order_by("s.trnsfr_id", "desc");
        $this->db->group_by('s.trnsfr_id');
        if ($srh_warehouse_id) {
            $this->db->where("s.warehouse_id", $srh_warehouse_id); //("id !=",$id);
        }
        if ($srh_to_date) {
            $this->db->where("s.trnsfr_datetime <=", $srh_to_date); //("id !=",$id);
        }
        if ($srh_from_date) {
            $this->db->where("s.trnsfr_datetime >=", $srh_from_date); //("id !=",$id);
        }
        if ($trnsfr_id) {
            $this->db->where("s.trnsfr_id =", $trnsfr_id); //("id !=",$id);
        }
        if ($to) {
            $this->db->limit($to, $from);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    //Sales all get
    function get_all_transfer($location_id)
    {
        $this->db->select('t.*, w.name');
        $this->db->from('transfer t');
        $this->db->join('locations w', 't.trnsfr_to_location_id = w.id', 'left');
        $this->db->where("location_id",$location_id);
        $this->db->order_by("t.trnsfr_id", "desc");
        //$this->db->where("t.trnsfr_id IS NOT NULL"); //("id !=",$id);
        $query = $this->db->get();
        return $query->result();
    }
    //Sales get for print
    function get_all_transfer_for_print_transfer()
    {
        $this->db->select('s.* , c.cus_name ');
        $this->db->from('transfer s');
        $this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
        $this->db->order_by("s.trnsfr_id", "desc");
        $this->db->group_by('s.trnsfr_id');
        $this->db->where("s.trnsfr_id IS NOT NULL"); //("id !=",$id);
        $query = $this->db->get();
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
    function is_approved($trnsfr_id){
        $this->db->select('approval_status');
        $this->db->from('transfer');
        $this->db->where('trnsfr_id', $trnsfr_id);
        $query = $this->db->get();
        return $query->row()->approval_status == 1 ? TRUE: FALSE;
    }
    function get_transfer_items($transfer_id){
        $this->db->select('product_id,trnsfr_itm_quantity,trnsfr_itm_unit_value');
        $this->db->from('transfer_item');
        $this->db->where('trnsfr_id', $transfer_id);
        $query = $this->db->get();
        return $query->result();
    }
    function approve($trnsfr_id){
        $data = array(
            'approved_by' => $this->session->userdata('ss_user_id'),
            'approved_on' => date('Y-m-d H:i:s'),
            'approval_status' => 1
        );
        $this->db->where('trnsfr_id', $trnsfr_id);
        $this->db->update('transfer', $data);
        return $this->db->affected_rows();
    }
    function get_product_list(){
        return $this->set_product_list();
    }
    private function set_product_list(){
        //get_all_product_list_for_processing
        $this->db->select('product_id,product_name,product_code,product_cost,product_type_id');
        $query = $this->db->get('product');
        $products_raw = $query->result();
        $products = array();
        foreach($products_raw as $row){
            $products[$row->product_id] = $row;
        }
        return $products;
    }
    function get_transfer_details_list($from_date='',$to_date='',$location=''){
        return $this->set_transfer_details_list($from_date,$to_date,$location);
    }
    private function set_transfer_details_list($from_date='',$to_date='',$location_id=''){
        
        /*get transfer for the date*/
       
        $where = array(
            'location_id' => $location_id
        );
        $this->db->select('*');
        $this->db->from('transfer');
        if($location_id){
            $this->db->where($where);
        }
        if($from_date && $to_date){
            $this->db->where('date(trnsfr_datetime) =>',$from_date);
            $this->db->where('date(trnsfr_datetime) =<',$to_date);
        }else if($from_date){
            $this->db->where('date(trnsfr_datetime)',$from_date);
        }else if($to_date){
            $this->db->where('date(trnsfr_datetime)',$to_date);
        }
        $query = $this->db->get();
        $master_list = $query->result();
        $id_list = array();
        $mapped_master_data_by_id = array();
        foreach($master_list as $row){
            $mapped_master_data_by_id[$row->trnsfr_id] = $row;
            $id_list[] = $row->trnsfr_id;
        }
        
        if(empty($id_list)){
           return array(); 
        }
        
        /*get transfer items for the date*/
        $this->db->select('*');
        $this->db->from('transfer_item');
        $this->db->where_in('trnsfr_id',$id_list);
        $query = $this->db->get();
        $item_list= $query->result();
        
        $products = $this->get_product_list();
        
        $retun_data=array();
         foreach($item_list as $row){
            $retun_data[] = array(
                "trnsfr_id"=>$row->trnsfr_id,
                "datetime"=>$mapped_master_data_by_id[$row->trnsfr_id]->trnsfr_datetime,
                "reference_no"=>$mapped_master_data_by_id[$row->trnsfr_id]->trnsfr_reference_no,
                "product_type"=> $products[$row->product_id]->product_type_id,
                "product_code"=> $products[$row->product_id]->product_code,
                "product_name"=> $products[$row->product_id]->product_name,
                "itm_quantity"=>$row->trnsfr_itm_quantity,
                "unit_value"=> $row->trnsfr_itm_unit_value,
                "amount"=> $row->trnsfr_itm_unit_value * $row->trnsfr_itm_quantity
            );
        }
        return $retun_data;
    }
}