<?php
class Stock_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        //$this->load->database();
        $this->load->library('form_validation');
    }

    public function stock_m_tracker($data) {
        
        // Insert data into the 'stock_movements' table
        $this->db->insert('stock_movements_master', $data);

        // Return the inserted log_id
        return $this->db->insert_id();
    }
    public function addMovement($data) {
        // Validate data before inserting into the database
        $this->validateMovementData($data);

        // Insert data into the 'stock_movements' table
        $this->db->insert('stock_movements', $data);

        // Return the inserted log_id
        return $this->db->insert_id();
    }

    public function bulkInsertMovements_($data) {
        
        // Batch insert data into the 'stock_movements' table
        $this->db->insert_batch('stock_movements', $data);
        
        return $this->db->affected_rows();
    }
    public function bulkInsertMovements($data) {
        // Validate data before inserting into the database
        foreach ($data as $row) {
            $this->validateMovementData($row);
        }

        // Batch insert data into the 'stock_movements' table
        $this->db->insert_batch('stock_movements', $data);
        
        return $this->db->affected_rows();
    }

    public function getAllMovements() {
        // Retrieve all movements from the 'stock_movements' table
        $query = $this->db->get('stock_movements');
        return $query->result();
    }

    public function getMovementById($log_id) {
        // Retrieve a specific movement by log_id
        $query = $this->db->get_where('stock_movements', array('log_id' => $log_id));
        return $query->row();
    }
    
    public function getMovementBy($where) {
        // Retrieve a specific movement by log_id
        $query = $this->db->get_where('stock_movements', $where);
        return $query->row();
    }

    public function updateMovement($log_id, $data) {
        // Validate data before updating
        $this->validateMovementData($data);

        // Update the movement in the 'stock_movements' table
        $this->db->where('log_id', $log_id);
        $this->db->update('stock_movements', $data);
    }

    private function validateMovementData($data) {
        // Add your validation rules here
        $_POST = $data;
        $this->form_validation->set_rules('location_id', 'Location ID', 'required|integer');
        $this->form_validation->set_rules('product_id', 'Product ID', 'required|integer');
        $this->form_validation->set_rules('transaction_id', 'Product ID', 'required');
        // Add more rules for other fields as needed

        if ($this->form_validation->run() === FALSE) {
            // Validation failed, handle errors
            // You can redirect, log errors, or take appropriate action
            show_error(validation_errors(), 400);
        }
    }
    
    public function calculateDailyStockSummaries($date) {
        // Convert the date to MySQL date format (YYYY-MM-DD)
        $dateFormatted = date('Y-m-d', strtotime($date));

        // Select sum of quantities for each product on the specified date
        $this->db->select('product_id, SUM(IF(movement_type = "in", quantity, 0)) AS grn_quantity, SUM(IF(movement_type = "out", quantity, 0)) AS sale_quantity');
        $this->db->from('stock_movements');
        $this->db->where('DATE(movement_date)', $dateFormatted);
        $this->db->group_by('product_id');
        $query = $this->db->get();

        return $query->result_array();
    }
    
    function getLastRecordedDate($product_id="",$date="") {
        $this->db->select_max('date');
        if($product_id)
            $this->db->where('product_id', $product_id);
        if($date)
            $this->db->where('date(date) <', $date);

        $query = $this->db->get('rep_daily_stock_summary');
        $result = $query->row();
        return $result->date;
    }
    
    function get_stock($data = array()){
        if(!isset($data['location_id']) || !isset($data['product_id'])){
            return array('location_id' => 'numeric', 'product_id' => 'numeric');
        }
        $date = date("Y-m-d");
        /*get product - make this better if you have time*/
        $products = $this->get_products($data['product_id']);
        $closing_Balances = $this->get_closing_balances($data['product_id'],$date,$data['location_id']);
        $stock_balance = $this->calculate_stock_balance($products, $closing_Balances, $date,$data['location_id']);
        return $stock_balance;
    }
    function output_json_response($data) {
        header('content-type:application/json');
        echo json_encode($data);
    }
    function get_products($product_id){
        $this->db->select('product_id,product_name,product_code,product_cost,product_type_id');
        $this->db->where('product_id',$product_id);
        $query = $this->db->get('product');
        $products_raw = $query->result();
        $products = array();
        foreach($products_raw as $row){
            $products[$row->product_id] = $row;
        }
        return $products;
    }
    function get_closing_balances($product_id,$date,$location_id) {
        $lastRecordedDate = $this->getLastRecordedDate($product_id, $date,$location_id);
        $this->db->select('product_id,closing_balance');
        $this->db->where('date', $lastRecordedDate);
        $this->db->where('location_id', $location_id);
        $query_raw = $this->db->get('rep_daily_stock_summary');
        $closing_Balances_raw = $query_raw->result();
        $closing_Balances = array();
        foreach($closing_Balances_raw as $raw)
            $closing_Balances[$raw->product_id] = $raw;
        return $closing_Balances;
    }
    function calculate_stock_balance($products, $closing_Balances, $date, $location_id) {
        $stock_balance = array();
        $stock_movements = $this->get_stock_movements(array(
            'date(movement_date)' => $date,
            'location_id' => $location_id,
        ));
    
        $mapped_movements_by_product_id = array();
        foreach ($stock_movements as $movement){
            if(!isset($mapped_movements_by_product_id[$movement->product_id])){
                $mapped_movements_by_product_id[$movement->product_id] = array();
            }
            $mapped_movements_by_product_id[$movement->product_id][] = $movement;
        }
        
        foreach($products as $prd){
            $product_id = $prd->product_id;
            if (!isset($stock_balance[$product_id])) {
                $closing_Balance = isset($closing_Balances[$product_id]) ? $closing_Balances[$product_id]->closing_balance : 0;
                $stock_balance[$product_id] = array(
                    'date'          => $date,
                    'product_id'    => $product_id,
                    'product_type'    => $prd->product_type_id,
                    'product_name'  => $prd->product_name." (".$prd->product_code.")",
                    'opening_balance'   => floatVal($closing_Balance),
                    'grn_quantity'      => 0,
                    'gtn_quantity'      => 0,
                    'sale_quantity'     => 0,
                    'return_quantity'   => 0,
                    'damadge_quantity'  => 0,
                    'adjusted_quantity' => 0,
                    'consumption_quantity' => 0,
                    'closing_balance'   => floatVal($closing_Balance)
                );
            }
    
            $movements = array();
            if(isset($mapped_movements_by_product_id[$prd->product_id]))
                $movements = $mapped_movements_by_product_id[$prd->product_id];
    
            if(!empty($movements))
                foreach ($movements as $movement) {
                    // Update quantities based on movement type and origin
                    if ($movement->movement_type == 'in'){
                        $stock_balance[$product_id]['closing_balance'] += $movement->quantity;
                    }else{
                        $stock_balance[$product_id]['closing_balance'] -= $movement->quantity;
                    }
                }
        }
        return $stock_balance;
    }
    function get_stock_movements($where){
        $this->db->where($where);
        $query = $this->db->get('stock_movements');
        return $query->result();
    }
}