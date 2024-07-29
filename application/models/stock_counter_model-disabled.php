<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Stock_Counter_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
         $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
         $this->load->model('Purchases_Model');
         $this->load->model('Sales_Model');
         $this->load->model('Report_Model');
    }
    
    
    
    
    function get_outlet_finish_product_stock_count($product_id){
        
        $srh_from_date='';
        $srh_to_date='';
        $srh_warehouse_id='';
        
        $purchased_qty  = $this->getPurcheseTotal($product_id);
        $sold_qty       = $this->getSoldTotal($product_id);
        $damage_qty     = $this->getDamageTotal($product_id);
        $stock=$purchased_qty-($sold_qty+$damage_qty);
        return $stock;
    }
    
    
     private function getPurcheseTotal($product_id)
    {
        $this->db->select_sum('pi.quantity');
        $this->db->from('purchase_items pi');
        $this->db->where('pi.product_id', $product_id);
        $query = $this->db->get();
        return $data['quantity'] = $query->row()->quantity;
    }
    
    public function getSoldTotal($product_id)
    {
        $this->db->select_sum('si.quantity');
        $this->db->from('sale_items si');
        $this->db->where('si.product_id', $product_id);
        $query = $this->db->get();
        return $query->row()->quantity;
    }
    
    	function getDamageTotal($product_id){
	    $this->db->select_sum('si.pdmgitm_quantity');
        $this->db->from('product_damage_item si');
        $this->db->where('si.product_id', $product_id);
        $query = $this->db->get();
        return $query->row()->pdmgitm_quantity;
	}
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //old implentations
    //product full_stock_balance start--------------------------------------------------------------------------------
    function get_stock_balance($warehouse_id='',$product_id){
       /* $intermediate_grn_total= $this->get_production_intermediate_grn_qty($warehouse_id,$product_id);
        $grn_total= $this->get_grn_qty($warehouse_id,$product_id);
        $issue_qty= $this->get_production_issue_qty($warehouse_id,$product_id);
        $damage_total= $this->get_damage_qty($warehouse_id,$product_id);
        $grn_return_total= $this->get_grn_return_qty($warehouse_id,$product_id);
        $convert_product_qty = $this->get_production_converted_qty($warehouse_id,$product_id);
        $product_balance=((($grn_total+$intermediate_grn_total)-$grn_return_total)-$damage_total)-($issue_qty+$convert_product_qty);
        $temp_balance= round($product_balance,3);
        if($temp_balance==(-0)){
            return 0;
        }else{
            return $temp_balance;
        }*/
        
        return $this->get_stock_balance_batch('',$product_id);
    }
    function get_grn_qty($warehouse_id='',$product_id)
    {
        $this->db->select_sum('p.quantity');
        $this->db->from('purchase_items p');
        $this->db->join('purchases pm','pm.id=p.purchase_id','inner');
        $this->db->where('p.product_id', $product_id);
        $this->db->where('pm.approval_status', 1);
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['quantity']))
        {
            return $result['quantity'];
        }else{
       return 0;
        }
    }
    
    function get_production_intermediate_grn_qty($warehouse_id='',$product_id)
    {
        $this->db->select_sum('p.quantity');
        $this->db->from('production_grn_intermediat_product p');
        if($warehouse_id){
            $this->db->join('production_grn g','g.pgrnm_id=p.pgrnm_id','inner');
            $this->db->where('g.pgrnm_warehouse_id', $warehouse_id);
        }
        $this->db->where('p.pgtni_status', 1);
        $this->db->where('p.product_mat_id', $product_id);
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['quantity']))
        {
            return $result['quantity'];
        }else{
       return 0;
        }
    }
    function get_production_issue_qty($warehouse_id='',$product_id)
    {
        $this->db->select_sum('p.quantity');
        $this->db->from('production_stock_in_out p');
        $this->db->where('p.product_mat_id', $product_id);
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['quantity']))
        {
            return $result['quantity'];
        }else{
       return 0;
        }
    }
    function get_damage_qty($warehouse_id='',$product_id)
    {
        return 0;
        $this->db->select_sum('p.pdmgitm_quantity');
        $this->db->from('product_damage_item p');
        $this->db->where('p.product_id', $product_id);
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['pdmgitm_quantity']))
        {
            return $result['pdmgitm_quantity'];
        }else{
       return 0;
        }
    }
     function get_grn_return_qty($warehouse_id='',$product_id)
    {
        $this->db->select_sum('p.quantity');
        $this->db->from('purchase_return_items p');
        $this->db->where('p.product_id', $product_id);
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['quantity']))
        {
            return $result['quantity'];
        }else{
       return 0;
        }
    }
     function get_production_issued_total_qty($warehouse_id='',$product_id){
       return 0;
    }
    
     function get_production_converted_qty($warehouse_id='',$product_id)
    {
        $this->db->select_sum('p.pc_qty');
        $this->db->from('production_convert p');
        if($warehouse_id){
            $this->db->where('p.pc_warehouse', $warehouse_id);
        }
        $this->db->where('p.pc_status', 1);
        $this->db->where('p.pc_parduct_mat_id', $product_id);
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['pc_qty']))
        {
            return $result['pc_qty'];
        }else{
       return 0;
        }
    }
    //product full_stock_balance end----------------------------------------------------------------------------------------------
    
    
    
    
    
    
    
    
    //batch_stock balance start------------------------------------------------------------------------------------------------------useble funtion from 2023-01-09
      function get_stock_balance_batch($warehouse_id='',$product_id,$batch_id=''){
        $grn_total= $this->get_batch_grn_qty($warehouse_id,$product_id,$batch_id);
        $grn_return_total= $this->get_batch_grn_return_qty($warehouse_id,$product_id,$batch_id);
        $issue_qty= $this->get_batch_production_issue_qty($warehouse_id,$product_id,$batch_id);
        $adjesment_total= $this->get_batch_adjesment_qty($warehouse_id,$product_id,$batch_id);
        $value_added_grn= $this->get_production_intermediate_grn_batch_qty($warehouse_id,$product_id,$batch_id);
        $transfer_to_finish= $this->get_production_converted_batch_qty($warehouse_id,$product_id,$batch_id);
        $damage_qty= $this->get_damage_batch_qty('',$product_id,$batch_id);
        $additional_qty= 0;//$this->get_addtional_batch_qty('',$product_id,$batch_id);
        $product_balance=(($grn_total-$grn_return_total-$damage_qty)-($issue_qty+$transfer_to_finish)+($value_added_grn+$adjesment_total))+($additional_qty);
        $temp_balance= round($product_balance,3);
        if($temp_balance==(-0)){
            return 0;
        }else{
            return $temp_balance;
        }
    }
    function get_batch_grn_qty($warehouse_id='',$product_id='',$batch_id='')
    {
        $this->db->select_sum('p.quantity');
        $this->db->from('btatch_prroduct_grn bg');
        $this->db->join('purchase_items p','p.id=bg.grn_item_id','inner');
         if($warehouse_id){
          $this->db->join('purchases pm','pm.id=p.purchase_id','inner');
          $this->db->where('pm.warehouse_id', $warehouse_id);
        }
        if($product_id){
          $this->db->where('bg.product_id', $product_id);  
        }
        if($batch_id){
        $this->db->where('bg.batch_id', $batch_id);
        }
        if($batch_id){
            $this->db->group_by('bg.batch_id');
        }else{
            $this->db->group_by('bg.product_id');
        }
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['quantity']))
        {
            return $result['quantity'];
        }else{
       return 0;
        }
    }
    function get_batch_production_issue_qty($warehouse_id='',$product_id='',$batch_id='')
    {
        $this->db->select_sum('p.quantity');
        $this->db->from('production_stock_in_out p');
        if($product_id){
        $this->db->where('p.product_mat_id', $product_id);
        }
        if($batch_id){
           $this->db->where('p.product_mat_batch_id', $batch_id); 
        }
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['quantity']))
        {
            return $result['quantity'];
        }else{
       return 0;
        }
    }
    
     function get_batch_adjesment_qty($warehouse_id='',$product_id='',$batch_id='')
    {
        $this->db->select_sum('p.batch_qty');
        $this->db->from('batch_stock_adjesment p');
        if($product_id){
            $this->db->where('p.product_id', $product_id);
        }
        if($batch_id){
            $this->db->where('p.batch_id', $batch_id);
        }
        if($warehouse_id){
             $this->db->where('p.warehouse_id', $warehouse_id);
        }
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['batch_qty']))
        {
            return $result['batch_qty'];
        }else{
       return 0;
        }
    }
     function get_batch_grn_return_qty($warehouse_id='',$product_id='',$batch_id='')
    {
        $this->db->select_sum('p.quantity');
        $this->db->from('purchase_return_items p');
         if($warehouse_id){
          $this->db->join('purchase_return pr','pr.pur_return_id=p.pur_return_id','inner');
          $this->db->where('pr.warehouse_id', $warehouse_id);
        }
        if($product_id){
        $this->db->where('p.product_id', $product_id);
        }
        if($batch_id){
        $this->db->where('p.batch_id', $batch_id);
        }
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['quantity']))
        {
            return $result['quantity'];
        }else{
       return 0;
        }
    }
    
    
    function get_production_intermediate_grn_batch_qty($warehouse_id='',$product_id='',$batch_id='')
    {
        $this->db->select_sum('p.quantity');
        $this->db->from('production_grn_intermediat_product p');
        if($warehouse_id){
            $this->db->join('production_grn g','g.pgrnm_id=p.pgrnm_id','inner');
            $this->db->where('g.pgrnm_warehouse_id', $warehouse_id);
        }
        $this->db->where('p.pgtni_status', 1);
        if($product_id){
            $this->db->where('p.product_mat_id', $product_id);
        }
        if($batch_id){
           $this->db->where('p.batch_id', $batch_id); 
        }
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['quantity']))
        {
            return $result['quantity'];
        }else{
       return 0;
        }
    }
    
    function get_production_converted_batch_qty($warehouse_id='',$product_id='',$batch_id='')
    {
        $this->db->select_sum('p.pc_qty');
        $this->db->from('production_convert p');
        if($warehouse_id){
            $this->db->where('p.pc_warehouse', $warehouse_id);
        }
        $this->db->where('p.pc_status', 1);
        if($product_id){
         $this->db->where('p.pc_parduct_mat_id', $product_id);   
        }
         if($batch_id){
         $this->db->where('p.pc_product_mat_batch_id', $batch_id);   
        }
        
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['pc_qty']))
        {
            return $result['pc_qty'];
        }else{
       return 0;
        }
    }
    
    function get_damage_batch_qty($warehouse_id='',$product_id='',$batch_id='')
    {
        $this->db->select_sum('p.pdmgitm_quantity');
        $this->db->from('product_damage_item p');
        if($product_id){
        $this->db->where('p.product_id', $product_id);
        }
         if($batch_id){
           $this->db->where('p.batch_id', $batch_id); 
        }
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['pdmgitm_quantity']))
        {
            return $result['pdmgitm_quantity'];
        }else{
       return 0;
        }
    }
    
     //product batch_stock balance end-------------------------------------------------------------------------------
     
     //product batch purcheses balance stsrt ------------------------------------------------------------------------
     
     function get_purchased_stock_balance($product_id,$grn_id){
        $grn_total= $this->get_purchased_grn_qty($product_id,$grn_id);
        $grn_return_total= $this->get_purchased_return_grn_qty_total($product_id,$grn_id);
        $product_balance=$grn_total-$grn_return_total;
        return $product_balance;
    }
     function get_purchased_grn_qty($product_id,$grn_id)
    {
        $this->db->select_sum('p.quantity');
        $this->db->from('purchase_items p');
        $this->db->where('p.product_id', $product_id);
        $this->db->where('p.id', $grn_id);
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['quantity']))
        {
            return $result['quantity'];
        }else{
       return 0;
        }
    }
    
    function get_manufactured_qty($product_id)
    {
        $this->db->select_sum('p.output_qty');
        $this->db->from('production_batch_items p');
        $this->db->where('p.pbi_product_id', $product_id);
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['output_qty']))
        {
            return $result['output_qty'];
        }else{
       return 0;
        }
    }
    function get_purchased_return_grn_qty_total($product_id,$grn_id)
    {
        $this->db->select_sum('p.quantity');
        $this->db->from('purchase_return_items p');
        $this->db->where('p.product_id', $product_id);
        $this->db->where('p.grn_item_id', $grn_id);
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['quantity']))
        {
            return $result['quantity'];
        }else{
       return 0;
        }
    }
    
    
     
     
     //product batch purcheses balance end ------------------------------------------------------------------------
     
     
     
     
     
     
     
     
     
     
     
     
     
     //new update for production final product stock count
     
      function getFinalProductStockBalance($warehouse_id='',$product_id='',$batch_id=''){
        $grn_total= $this->getFinalProductStockGRN($warehouse_id,$product_id,$batch_id);
        $intermediate_grn_total= $this->getIntermediateConvertGRN($warehouse_id,$product_id,$batch_id);
        $converted_procuct_total= $this->get_onverted_product_qty($warehouse_id,$product_id,$batch_id);
        $issued_qty= $this->get_issued_product_qty($warehouse_id,$product_id,$batch_id);
        $manufactured=0;// $this->get_manufactured_qty($product_id);
        $product_balance=((($grn_total+$manufactured)-$intermediate_grn_total)+($converted_procuct_total))-$issued_qty;
        $temp_balance= round($product_balance,3);
        if($temp_balance==(-0)){
            return 0;
        }else{
            return $temp_balance;
        }
    }
    function getFinalProductStockGRN($warehouse_id='',$product_id='',$batch_id='')
    {
        $this->db->select_sum('p.quantity');
        $this->db->from('production_grn_items p');
        if($warehouse_id){
            $this->db->join('production_grn g','g.pgrnm_id=p.pgrnm_id','inner');
            $this->db->where('g.pgrnm_warehouse_id', $warehouse_id);
        }if($batch_id){
          $this->db->where('p.pbi_id', $batch_id);  
        }
        $this->db->where('p.product_id', $product_id);
        $this->db->where('p.pgrnp_status', 1);
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['quantity']))
        {
            return $result['quantity'];
        }else{
       return 0;
        }
    }
     function getIntermediateConvertGRN($warehouse_id='',$product_id='',$batch_id='')
    {
        $this->db->select_sum('p.quantity');
        $this->db->from('production_grn_intermediat_product p');
        if($warehouse_id){
            $this->db->join('production_grn g','g.pgrnm_id=p.pgrnm_id','inner');
            $this->db->where('g.pgrnm_warehouse_id', $warehouse_id);
        }
        if($batch_id){
           $this->db->where('p.pbi_id', $product_id); 
        }
        $this->db->where('p.pgtni_status', 1);
        $this->db->where('p.product_id', $product_id);
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['quantity']))
        {
            return $result['quantity'];
        }else{
       return 0;
        }
    }
    
     function get_onverted_product_qty($warehouse_id='',$product_id='',$batch_id='')
    {
        $this->db->select_sum('p.pc_qty');
        $this->db->from('production_convert p');
        if($warehouse_id){
            $this->db->where('p.pc_warehouse', $warehouse_id);
        }
         if($batch_id){
           $this->db->where('p.converted_batch_id', $batch_id); 
        }
        $this->db->where('p.pc_status', 1);
        $this->db->where('p.pc_prodcut_id', $product_id);
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['pc_qty']))
        {
            return $result['pc_qty'];
        }else{
       return 0;
        }
    }
    
     function get_issued_product_qty($warehouse_id='',$product_id='',$batch_id='')
    {
        $this->db->select_sum('p.quantity');
        $this->db->from('stock_transfer_item p');
        $this->db->where('p.product_id', $product_id);
         if($batch_id){
           $this->db->where('p.batch_id', $batch_id); 
        }
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['quantity']))
        {
            return $result['quantity'];
        }else{
       return 0;
        }
    }
     
     
     
     
      function get_addtional_batch_qty($warehouse_id='',$product_id='',$batch_id='')
    {
        $this->db->select_sum('p.req_qty');
        $this->db->from('addtional_items p');
        $this->db->where('p.product_id', $product_id);
         if($batch_id){
           $this->db->where('p.batch_id', $batch_id); 
        }
        $query = $this->db->get();
        $result=$query->row_array();
        if(isset($result['req_qty']))
        {
            return $result['req_qty'];
        }else{
       return 0;
        }
    }
     
   
}