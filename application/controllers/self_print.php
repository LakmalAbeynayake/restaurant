
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Self_print extends CI_Controller {

    var $main_menu_name = "sales";
    var $sub_menu_name = "sales";

    public function __construct() {
        parent::__construct();

        $this->load->model('Sales_Model');
    }

    //Sales list page load
    public function sales_print() {
        $this->load->view('self_print');
    }

    public function get_print_details() {
        $sale_id = $this->input->post('sale_id');

        $print['sale_details'] = $this->Sales_Model->get_sale_print();


        echo json_encode($print['sale_details']['sale_id']);
    }

    public function set_printed() {
//        echo 'lllllljj';
        $sale_id = $this->input->post('sale_id');
        //echo $sale_id;
        $print['sale_details'] = $this->Sales_Model->set_printed($sale_id);
        echo json_encode($sale_id);
    }

}
