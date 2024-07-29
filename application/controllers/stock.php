<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Stock_model');
        $this->load->library('form_validation');
    }

    public function addMovement() {
        $transaction_id = uniqid('', true);
        // data from POST request
        $data = array(
            'location_id' => $this->input->post('location_id', true),
            'transaction_id' => $transaction_id,
            'product_id' => $this->input->post('product_id', true),
            'quantity' => $this->input->post('quantity', true),
            'movement_type' => $this->input->post('movement_type', true),
            'movement_date' => date('Y-m-d H:i:s'),
            'origin' => $this->input->post('origin', true),
            'origin_id' => $this->input->post('origin_id', true)
        );

        // Call the addMovement method from the model 
        $log_id = $this->Stock_model->addMovement($data);

        // You can do further processing or redirect as needed
        echo 'Movement added successfully. Log ID: ' . $log_id;
    }
    
    /*
    $where = array('product_id' => $product_id, 'location_id' => $location_id)
    */
    
    public function viewAllMovements() {
        $allMovements = $this->Stock_model->getAllMovements();
        // Process $allMovements as needed
    }
    
    public function viewMovementById($log_id) {
        $movement = $this->Stock_model->getMovementById($log_id);
        // Process $movement as needed
    }
    
    public function editMovement($log_id) {
        // Example data from POST request
        $data = array(
            'location_id' => $this->input->post('location_id', true),
            'product_id' => $this->input->post('product_id', true),
            'quantity' => $this->input->post('quantity', true),
            'movement_type' => $this->input->post('movement_type', true),
            'movement_date' => date('Y-m-d H:i:s'),
            'origin' => $this->input->post('origin', true),
            'origin_id' => $this->input->post('origin_id', true)
        );
    
        $this->Stock_model->updateMovement($log_id, $data);
        // Handle the update completion as needed
    }
}
