<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Auto_Print extends CI_Controller
{
    var $key        = "2XRDDIUFZ-68611547a09780f0f64ae9e4e3ab7ef7e28468219bf21b0fbe893cba04cbe630";
    var $domain     = "isurugm.newviableerp.com";
    var $protocol   = "http";
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Colombo");
        $this->load->library("sky_print");
    }
    public function index()
    {
        /*$this->sky_print->key($this->key);
        $this->sky_print->domain($this->domain);
        $this->sky_print->row("ROW 1 COL 1");
        $this->sky_print->row("ROW 2 COL 1,ROW 2  COL 2");
        $result = $this->sky_print->row();*/
        $result = $this->build_sky_page_kot(84);
        
        echo "<pre>";
        print_r($result);
        echo "</pre>";
    }
    
    function get_kot_url(){
        $printer_name = $this->input->post('printer_name');
        $sale_id      = $this->input->post('sale_id');
        $success = false;
        
        if(!$sale_id){
            $this->load->model("auto_print_model");
            $sale_data = $this->auto_print_model->check_n_get_minimum_sale_id_printable("", "");
            if (isset($sale_data->sale_id)) {
                if ($sale_data->sale_id > 0) {
                    $sale_id = $sale_data->sale_id;
                    $success = true;
                }
            }
        }
        if($sale_id > 0){
            $data_path  = "pos/ap_kot_kitchen_json?sale_id=".$sale_id;
            $call_back  = "isurugm.newviableerp.com/pos/printed_successfully_kot?sale_id=".$sale_id;
            
            $dataType   = "application/json";
            //$printer_name   = "XP-80C-2";
            //$print_job  = $this->build_kot($sale_id);
            $print_job  = $this->build_sky_page_kot($sale_id);
            $approach   = "offline";
            
            if(!$print_job['success']){
                echo json_encode(array(
                    "success" => false,
                    "url" => ""
                ));
                exit;
            }
            
            $data_array = array(
                "key" => $this->key,
                "protocol" => $this->protocol,
                "domain" => $this->domain,
                "data_path" => $data_path,
                "dataType" =>$dataType,
                "printerName" =>$printer_name,
                "print_id" => "ktchn_kot",
                "num_copy" => "1",
                "call_back" => $call_back,
                "print_job" => $print_job,
                "approach" => $approach
            );
            $josn = json_encode($data_array);
            
            //echo "\n".base64_encode($josn)."\n";
            
            $offline_url = 'skyprint:'.base64_encode($josn);
            /*echo "<br>\n\n";
            echo $offline_url;
            echo "<br>\n\n";*/
            echo json_encode(array(
                "success" => true,
                "url" => $offline_url
            ));
        }else{
            echo json_encode(array(
                "success" => false,
                "url" => ""
            ));
        }
        
        /*$josn = '{  
            "key" : "'.$key.'",
            "protocol" : "'.$protocol.'",
            "domain" : "'.$domain.'",
            "data_path": "'.$data_path.'",
            "dataType" : "'.$dataType.'",
            "printerName" : "'.$printer_name.'",
            "print_id" : "ktchn_kot",
            "num_copy" : "1",
            "call_back":"'.$call_back.'",
            "print_job":"'.$print_job.'",
            "approach":"'.$approach.'"
        }';*/
    }

    /*custom page functions*/
    function build_kot($sale_id){
        $success = false;
        $this->load->model("auto_print_model");
            //= $this->input->get('sale_id');
        $cat_id     = 999; //$this->input->get('cat_id');
        $sale_info  = $this->auto_print_model->get_sale_info($sale_id);
        $sale_items = $this->auto_print_model->get_pending_sale_item_list_for_direct_kitchen($sale_id);
        $data       = array();
        if (!empty($sale_items)) {
            $default_size      = "12";
            //HEADER
            $columns           = array();
            $columns[]         = "          K.O.T";
            $row['columns']    = $columns;
            $row['offset']     = 20;
            $row['font']       = "Consolas";
            $row['font_size']  = 13;
            $row['font_style'] = "bold";
            array_push($data, $row);
            
            //BILL NO
            $columns           = array();
            $columns[]         = "BILL NO:" . $sale_info->sale_id;
            $row['columns']    = $columns;
            $row['offset']     = 20;
            $row['font']       = "Courier New";
            $row['font_size']  = $default_size;
            $row['font_style'] = "bold";
            array_push($data, $row);
            
            //ORDER TYPE
            $columns = array();
            if ($sale_info->dine_type == 1) {
                $columns[] = "DINE IN";
            } else if ($sale_info->dine_type == 2) {
                $columns[] = "TAKE AWAY";
            } else if ($sale_info->dine_type == 3) {
                $columns[] = "DELIVERY";
            }
            $row['columns']    = $columns;
            $row['offset']     = 20;
            $row['font']       = "Courier New";
            $row['font_size']  = $default_size;
            $row['font_style'] = "bold";
            array_push($data, $row);
            
            //NOTES
            $columns = array();
            if ($sale_info->dine_type == 1) {
                if ($sale_info->continued > 0) {
                    $columns[] = "CONTIBUE TO TABLE " . $sale_info->table_id;
                } else
                    $columns[] = "TABLE " . $sale_info->table_id;
                $row['columns']    = $columns;
                $row['offset']     = 20;
                $row['font']       = "Courier New";
                $row['font_size']  = $default_size;
                $row['font_style'] = "bold";
                array_push($data, $row);
            }
            
            //EMPTY LINE
            $row['columns'] = array();
            $row['offset']  = 10;
            array_push($data, $row);
            
            //ORDER ITEM TABLE
            $columns           = array();
            $columns[]         = "       ITEM          QTY";
            $row['columns']    = $columns;
            $row['offset']     = 20;
            $row['font']       = "Courier New";
            $row['font_size']  = $default_size;
            $row['font_style'] = "bold";
            array_push($data, $row);
            
            //ORDER ITEMS LIST
            foreach ($sale_items as $item) {
                $columns           = array();
                $columns[]         = $item->product_name;
                $columns[]         = "-" . intval($item->quantity);
                $row['columns']    = $columns;
                $row['offset']     = 20;
                $row['font']       = "Courier New";
                $row['font_size']  = 12;
                $row['font_style'] = "bold";
                array_push($data, $row);
            }
            $success = true;
        }
        
        /*echo json_encode(array(
            'success' => $success,
            'data' => $data
        ));*/
        return array(
            'success' => $success,
            'data' => $data
        );
    }
    function build_sky_page_kot($sale_id){
        $success = false;
        $this->load->model("auto_print_model");
        $sale_info  = $this->auto_print_model->get_sale_info($sale_id);
        $sale_items = $this->auto_print_model->get_pending_sale_item_list_for_direct_kitchen($sale_id);
        
        $settings = array('font_size' => 12, 'font' => 'Consolas', 'font_style'=> 'bold');
        if (!empty($sale_items)) {
            $_row_settings = array('font_size' => 13, 'font' => 'Consolas', 'font_style'=> 'bold');
            $this->sky_print->row("          K.O.T",$_row_settings,FALSE);
            $this->sky_print->row("BILL NO:" . $sale_info->sale_id,$settings);
            
            //ORDER TYPE
            if ($sale_info->dine_type == 1) {
                $this->sky_print->row("DINE IN",$settings);
            } else if ($sale_info->dine_type == 2) {
                $this->sky_print->row("TAKE AWAY",$settings);
            } else if ($sale_info->dine_type == 3) {
                $this->sky_print->row("DELIVERY",$settings);
            }
            
            //NOTES
            
            $columns = array();
            if ($sale_info->dine_type == 1) {
                if ($sale_info->continued > 0) {
                    $this->sky_print->row("CONTIBUE TO TABLE " . $sale_info->table_id,$settings);
                } else
                    $this->sky_print->row("TABLE " . $sale_info->table_id);
            }
            
            //EMPTY LINE
            $this->sky_print->row(" ",array(),FALSE);
            
            //ORDER ITEM TABLE
            $this->sky_print->row("       ITEM          QTY","",FALSE);
            
            //ORDER ITEMS LIST
            foreach ($sale_items as $item) {
                $str = $item->product_name.",-" . intval($item->quantity);
                $this->sky_print->row($str);
            }
            $success = true;
        }
        return array(
            'success' => $success,
            'data' => $this->sky_print->row()
        );
    }
    function test_page(){
        $data       = array();
        $default_size      = "12";
        $columns           = array();
        $row               = array();
        
        $columns[]         = "LINE 1";
        $row['columns']    = $columns;
        $row['offset']     = 20;
        $row['font']       = "Consolas";
        $row['font_size']  = 13;
        $row['font_style'] = "bold";
        array_push($data, $row);
    }
}