<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
class API extends CI_Controller
{
    var $main_menu_name = "";
    var $sub_menu_name = "";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->model('api_model');
        header('Content-Type: application/json');
        if (!isset($_SERVER['CONTENT_TYPE'])) {
            $this->output
                 ->set_content_type('application/json')
                 ->set_status_header(415 )
                 ->set_output(json_encode(array(
                     'error' => 'Content Type undefined',
                     'message' => 'The type of content you are trying to submit must be defined.'
                 )));
            exit();
        }

        if ($_SERVER['CONTENT_TYPE'] !== "application/json" && $_SERVER['CONTENT_TYPE'] !== "application/json; charset=utf-8") {
            $this->output
                 ->set_content_type('application/json')
                 ->set_status_header(415 )
                 ->set_output(json_encode(array(
                     'error' => 'Invalid content type',
                     'message' => 'The type of content ('.$_SERVER['CONTENT_TYPE'].') you are trying to submit is not acceptable. JSON required.'
                 )));
            exit();
        }
        $_POST = json_decode(file_get_contents("php://input"), true);
    }
    public function index()
    {
        $data = array(
            "status" => 0,
            "msg" => "Error",
            "err_code" => "error-200-a"
        );
        echo json_encode($data);
    }

    function get_products($category_id = "")
    {
        $authKey    = $this->input->post('authKey');
        $auth = $this->auth($authKey);
        if(!$auth['success']){
            http_response_code(401);
            return;
        }
        
        $category_id = $this->input->post('category_id');
        $out_cat     = '';
        $out_sub     = '';
        $d           = $this->api_model->get_product_by_cat_id($category_id);
        if (!empty($d)) {
            foreach ($d as $key => $row) {
                $d[$key]->product_id    = $d[$key]->product_id + 0;
                $d[$key]->product_price = $d[$key]->product_price + 0;
                $d[$key]->cat_id        = $d[$key]->cat_id + 0;
                //$d[$key]->cat_name      = $d[$key]->cat_name;
                $d[$key]->sub_cat_id    = $d[$key]->sub_cat_id + 0;
            }
            echo json_encode(array(
                "success" => true,
                "products" => $d
            ));
        } else {
            $jproduct = array();
            echo json_encode(array(
                "success" => false
            ));
        }
    }
    function get_product_info()
    {
        $product_id = $this->input->post('product_id');
        $out_cat    = '';
        $out_sub    = '';
        $d          = $this->api_model->get_product_by_product_id($product_id);
        if (!empty($d)) {
            $d['product_thumb'] = asset_url() . 'uploads/thumbs/' . $d['product_thumb'];
            $d['product_image'] = asset_url() . 'uploads/' . $d['product_image'];
            $d['product_id']    = $d['product_id'] + 0;
            $d['product_price'] = $d['product_price'] + 0;
            $d['cat_id']        = $d['cat_id'] + 0;
            $d['sub_cat_id']    = $d['sub_cat_id'] + 0;
            $d['min_order_qty'] = $d['min_order_qty'] + 0;
            $d['sizes']         = json_decode("{}");
            $sizes              = $this->api_model->get_product_sizes_by_product_id($product_id);
            if (!empty($sizes)) {
                $d['sizes'] = $sizes;
            }
            echo json_encode(array(
                "status" => 1,
                "msg" => "Success",
                "product_info" => $d
            ));
        } else {
            $jproduct = array();
            $ret      = json_encode(array(
                "status" => 0,
                "msg" => "Failed. (Error code: error-404-i)",
                "product_info" => json_decode("{}")
            ));
            echo $ret;
        }
    }
    /*add grn*/
    public function create_grn()
    {
        $location_key           = $this->input->post('authKey');
        $receiver_id            = $this->input->post('receiver_id');
        $origin_type            = $this->input->post('origin_type');
        $origin_id              = $this->input->post('origin_id');
        $date_time              = $this->input->post('date_time');
        $uuid                   = $this->input->post('uuid');
        $items                  = $this->input->post('items');
        $cus_order_id                  = $this->input->post('cus_order_id');
        
        /* Start validation */
        $auth = $this->auth($location_key);
        if(!$auth['success']){
            http_response_code(401);
            return;
        }
        
        if (empty($items)) {
            http_response_code(400);
            echo "Items is empty.";
            return;
        }
        
        if (!$receiver_id) {
            http_response_code(400);
            echo "Receiver ID is not provided.";
            return;
        }
        
        if (!$origin_type) {
            http_response_code(400);
            echo "Origin type is not provided.";
            return;
        }
        
        if (!$origin_id) {
            http_response_code(400);
            echo "Origin ID is not provided.";
            return;
        }
        
        if (!$date_time) {
            http_response_code(400);
            echo "Date time is not provided.";
            return;
        }
        
        if (!$uuid) {
            http_response_code(400);
            echo "UUID is not provided.";
            return;
        }

        $this->load->model('grn_model');
        
        $sender = $auth['data'];

        $ori_data = array(
            'sender_location_id'   => $sender->id,
            'receiver_location_id'   => $receiver_id,
            'grn_ref_no'    => 'GRN-IN-'.$sender->id.'',
            'origin_id'     => $origin_id,
            'origin_type'   => $origin_type,
            'date_time'     => $date_time,
            'uuid'          => $uuid,
            'cus_order_id'  => $cus_order_id
        );
        $this->db->trans_start();
        $grn_id = $this->grn_model->save_grn($ori_data);
        
        /*mapping pro*/
        $products = array();
        
        $this->db->select('product_id,product_code');
        $this->db->from('product');
        $query = $this->db->get();
        $products_raw = $query->result();
        
        foreach($products_raw as $itm){
            $products[$itm->product_code] = $itm;
        }
        
        $product_codes_not_found = array();
        
        /*end mapping*/
        foreach($items as $item){
            if(isset($products[$item['product_code']])){
                $itm_data = array(
                    'grn_id'    => $grn_id,
                    'transaction_id' => $uuid,
                    'product_id' => $products[$item['product_code']]->product_id,
                    'quantity' => $item['quantity'],
                    'unit_value' => $item['unit_value']
                );
                $grn_item_data[] = $itm_data;
            }else{
                $product_codes_not_found[] = $item['product_code'];
            }
        }
        
        /*before save grn items*/
        if(!empty($product_codes_not_found)){
            echo json_encode(array(
                'error' => 'Missing items found',
                'data'  => $product_codes_not_found
            ));
            return;
        }
        
        
        $num_of_rec = $this->grn_model->save_grn_items($grn_item_data);
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE){
            $this->common_model->add_user_activitie("GRN saved - failed");
            $this->output
                 ->set_content_type('application/json')
                 ->set_status_header(409)
                 ->set_output(json_encode(array(
                     'error' => 'Duplicate entry',
                     'message' => 'The resource you are trying to create already exists.'
                 )));
        } else {
            $this->common_model->add_user_activitie("GRN saved - $sender->id/id#$grn_id");
            http_response_code(200);
        }
    }
    
    function auth($location_key){
        if(!$location_key){
            return array(
                'success' => false
            );
        }
        
        $this->db->select('*');
        $this->db->from('locations');
        $this->db->where('auth_code',$location_key);
        $query = $this->db->get();
        $result = $query->row();
        
        return array(
                'success'   => true,
                'data'      => $result
        );
    }
    function get_locations(){
        $location_key           = $this->input->post('authKey');
        
        /* Start validation */
        $auth = $this->auth($location_key);
        if(!$auth['success']){
            echo json_encode(array(
                'success' => false,
                'msg' => 'Authentication failed'
            ));
            return;
        }
        
        $this->db->select('name,code,auth_code');
        $this->db->from('locations');
        $query = $this->db->get();
        $r = $query->result();
        
        echo json_encode(array(
            'success' => empty($r) ? false : true,
            'msg' => 'Authentication passed',
            'data' => $r
        ));
        return;
    }
}