<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class manual_query_s_with_grn extends CI_Controller
{
    var $main_menu_name = "people";
    var $sub_menu_name = "suppliers";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('country_model');
        $this->load->model('Common_Model');
        $this->load->model('product_models');
        $this->load->model('purchases_model');
        $this->load->model('Manual_Query_With_Grn_Model');
        $this->load->model('category_models');
    }
    public function index()
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = $this->sub_menu_name;
        echo "<br/>";
        $data['all_data'] = $this->Manual_Query_With_Grn_Model->get_all_data();
        // print_r($data['all_data']);
        $data_list        = array(
            'reference_no' => $this->Common_Model->gen_ref_number('id', 'purchases', 'GRN'),
            'warehouse_id' => 1,
            'supplier_id' => 1,
            'date' => date("Y-m-d H:i:s")
        );
        //Add grn
        $this->purchases_model->save_grn($data_list);
        //echo $this->db->last_query();
        $grn_id       = $this->db->insert_id();
        $tot_cost_grn = 0;
        //echo "<br/>Test:".$grn_id;
        foreach ($data['all_data'] as $row) {
            print_r($row);
            echo "<br/> crd price:" . $row['credit_salling_price'];
            if (trim($row['name'])) {
                $product_code = $this->Common_Model->gen_ref_number('product_id', 'product', 'PD');
                //insert data to sub cat table
                //get category id from name, if doest hv name save and get name
                $cat_id       = '';
                $cat_data     = $this->category_models->get_category_by_name($row['category']);
                //echo "<br/>99:";
                //print_r($cat_data[0]);
                if ($cat_data) {
                    $cat_id = $cat_data[0]->cat_id;
                } else {
                    //insert cat data
                    $category_code = $this->Common_Model->gen_ref_number('cat_id', 'product_category', 'PC');
                    $category_name = $row['category'];
                    $this->category_models->category_save($category_code, $category_name);
                    $cat_id = $this->db->insert_id();
                }
                //end "get category id from name, if doest hv name save and get name"
                //get sub category id from name, if doest hv name save and get name
                $sub_cat_id   = '';
                $sub_cat_data = $this->category_models->get_sub_category_by_name($row['sub_category']);
                //print_r($sub_cat_data[0]);
                if ($sub_cat_data) {
                    $sub_cat_id = $sub_cat_data[0]->sub_cat_id;
                } else {
                    //insert sub cat data
                    $sub_cat_code = $this->Common_Model->gen_ref_number('cat_id', 'product_sub_category', 'PSC');
                    $sub_cat_name = $row['sub_category'];
                    $this->category_models->category_sub_save($cat_id, $sub_cat_code, $sub_cat_name);
                    $sub_cat_id = $this->db->insert_id();
                }
                
                $product_code1=$row['code'];
                if($product_code1){
                    $product_code=$product_code1;
                }
                //end "get sub category id from name, if doest hv name save and get name"        
                $data_list = array(
                    'cat_id' => $cat_id,
                    'sub_cat_id' => $sub_cat_id,
                    'product_name' => $row['name'],
                    'product_code' => $product_code,
                    'product_thumb' => 'no-image.jpg',
                    'product_image' => 'no-image.jpg',
                    'product_alert_qty' => 5,
                    'product_max_qty' => 15,
                    'product_unit' => 6, //$row['unit_id'],
                    'product_price' => $row['price'],
                    'product_cost' => $row['cost'],
                    'product_alert_qty' => $row['min_qty'],
                    'product_max_qty' => $row['max_qty'],
                    'credit_salling_price' => $row['credit_salling_price'],
					'shot_25'	=>	$row['price_1'],
					'shot_100'	=>	$row['price_2'],
					'shot_375'	=>	$row['price_3'],
					'shot_750'	=>	$row['price_4'],
					'product_part_no'=>	$row['type'],
                );
                $p_data    = $this->product_models->get_product_by_name($row['name']);
                if (!$p_data) {
                    //echo "<pre>";
                    //print_r($data_list);
                    $this->Manual_Query_With_Grn_Model->save_data($data_list);
                    $product_id = $this->db->insert_id();
                    echo "<br/>Item Added:" . $row['name'];
                    if ($row['qty']) {
                        //add grn item
                        $sub_total = 0;
                        $sub_total = $row['qty'] * $row['cost'];
                        $tot_cost_grn += $sub_total;
                        $data_item = array(
                            'purchase_id' => $grn_id,
                            'product_id' => $product_id,
                            'product_code' => $product_code,
                            'product_name' => $row['name'],
                            'quantity' => $row['qty'],
                            'unit_price' => $row['cost'],
                            'sub_total' => $sub_total
                        );
                        $this->purchases_model->save_grn_item($data_item);
                        echo "<br/>Item Added To GRN :" . $row['name'] . "<br/>";
                    }
                } else {
                    echo "<br/>Allredy Added:" . $row['name'] . "<br/>";
                }
                //update grn total amount
                $data_list = array(
                    'total' => $tot_cost_grn,
                    'grand_total' => $tot_cost_grn
                );
            }
            //Add grn
            $this->purchases_model->save_grn($data_list, $grn_id);
            //$this->load->view('suppliers',$data);
        } // end name have
    }
    public function get_all_country()
    {
        $data['id']             = 1;
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'create_supplier';
        $data['all_country']    = $this->country_model->get_all_country();
    }
}