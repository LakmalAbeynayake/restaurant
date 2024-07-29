<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Purchases extends CI_Controller
{
    var $main_menu_name = "purchases";
    var $sub_menu_name = "categories";
    function __construct()
    {
        parent::__construct();
        $this->load->model('Transfer_Model');
        $this->load->model('Customer_Model');
        $this->load->model('Sales_Return_Model');
        $this->load->model('purchases_model');
        $this->load->model('common_model');
        $this->load->model('Sequerty_Model');
        $this->load->library('form_validation');
        $this->load->model('User_Model');
        $this->load->model('Supplier_Model');
        $this->load->model('Warehouse_Model');
        $this->load->model('Sales_Model');
        $this->load->model('Tax_Rates_Model');
        $this->load->model('Product_Damage_Model');
        $this->load->model('Proceed_Order_Model');
        $this->load->model('Order_Model');
        $this->load->model('Common_Model');
    }
    public function index($e = 0)
    {
        //if (!$this->User_Model->is_logged_in_k()) {
        //$this->User_Model->checkLoginPanel_k();
        //}
        $data['error']          = $e;
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = "list_purchases";
        $this->load->view('purchases/purchases_list', $data);
    }
    public function get_list_purchases($value = '')
    {
        $date = '';
        $i      = 0;
        $values = $this->purchases_model->getpurchases($date);
        $data   = array();
        $pay_st;
        if (!empty($values)) {
            foreach ($values as $purchases) {
                /*if (empty($purchases->sale_pymnt_amount)) {
                    $pay_st = '<span class="label label-warning">Pending</span>';
                } else {
                    if ($purchases->grn_total_paid >= $purchases->grand_total) {
                        $pay_st = '<span class="label label-success">Paid</span>';
                    } else {
                        $pay_st = '<span class="label label-info">Partial</span>';
                    }
                }*/
                //print_r($values[i]);
                //$count = $this->purchases_model->get_no_of_return_purchases($values[$i]->id);
                //$return_amount = $this->purchases_model->get_return_amount($values[$i]->id);
                //print_r($return_amount);
                //$r = $return_amount[0]['sum'];
                $i++;
                //print_r($count[0]->count);
                $row    = array();
                $row[]  = $purchases->date;
                $row[]  = $purchases->reference_no;
                //$row[] = '';//$count[0]->count;    
                $row[]  = $purchases->supp_company_name;
                //$row[] = $purchases->supp_invocie_no;
                //if($r){$row[] = $r;}
                //$row[] = '0.00';//else
                //                    $grand_tot= $purchases->grand_total;
                $row[]  = $purchases->supp_invocie_no; // $purchases->grand_total;
                $row[]  = number_format($purchases->grand_total, 2, '.', '');
                //$row[] = number_format($purchases->grand_total-$r,2,'.',',');
                $row[]  = '-';//number_format($purchases->grn_total_paid, 2, '.', '');
                $row[]  = '-';//number_format($purchases->grand_total - $purchases->grn_total_paid, 2, '.', '');
                $row[]  = '-';//$pay_st;
                $row[]  = '<div class="text-center"><div class="btn-group text-left">

                    <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>

                    <ul role="menu" class="dropdown-menu pull-right">

                          

                    <li><a href="' . base_url('purchases/view/' . $purchases->id) . '"><i class="fa fa-file-text-o"></i> GRN Details</a></li>            

                    <li><a href="' . base_url() . 'purchases/add_return/' . $purchases->id . '"><i class="fa fa-angle-double-left"></i></i> Return GRN</a></li>

                    

                    </ul></div>

                    </div>';
                $data[] = $row;
            }
            $output = array(
                'data' => $data
            );
            echo json_encode($output);
        } else {
            $output = array(
                'data' => ''
            );
            echo json_encode($output);
        }
    }
    public function test()
    {
        $this->purchases_model->update_purchase_qty(1, 4, 1, 500);
    }
    public function add_return($purchased_id = 0)
    {
        //if (!$this->User_Model->is_logged_in_k()) {
        //    $this->User_Model->checkLoginPanel_k();
        //}
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'add_purchases_return';
        $data['supplier']       = $this->purchases_model->get_supplier();
        $data['purchased_id']   = $purchased_id;
        if($purchased_id > 0)
            $data['purchased_details'] = $this->purchases_model->getpurchases_by_id($purchased_id);
        
        $data['warehouse']      = $this->purchases_model->get_warehouse();
        $data['supplier']       = $this->purchases_model->get_supplier();
        $this->load->view('purchases/add_return', $data);
    }
    
    public function list_return($e = 0)
    {
        //if (!$this->User_Model->is_logged_in_k()) {
        //$this->User_Model->checkLoginPanel_k();
        //}
        $data['error']          = $e;
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = "list_return_purchases";
        $this->load->view('purchases/purchases_return_list', $data);
    }
    /*
    
    public function add_return()
    
    {
    
    $data['main_menu_name'] = $this->main_menu_name;
    
    $data['sub_menu_name'] = '';
    
    
    
    //get sale id
    
    $sale_id=$this->uri->segment('3');
    
    $data['sale_item_list']=array();
    
    //$data['sale_item_list']= $this->Sales_Model->get_sale_item_list_by_sale_id($sale_id);
    
    $data['sale_details']= $this->Sales_Model->get_purchase_info($sale_id);
    
    $data['sale_id']=$sale_id;
    
    //get suppliers list
    
    $data['suppliers'] = $this->Supplier_Model->get_all_supplier();
    
    $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
    
    $data['tax_rates_list'] = $this->Tax_Rates_Model->get_all_tax_rates();
    
    $data['customer_list'] = $this->Customer_Model->get_all_customers();
    
    $data['status_list'] = $this->Common_Model->get_all_status();
    
    $data['cr_limit_list'] = $this->Common_Model->get_all_cr_limit();
    
    $this->load->view('add_return',$data);
    
    }*/
    public function suggestions($value = '')
    {
        $this->load->model('products_model');
        
        $term           = $this->input->get('term');
        $in_type        = $this->input->get('t');
        $result         = $this->products_model->search($term);
        $json           = array();
        
        foreach ($result as $row) {
            
            $product_name            = $row['product_name'];
            $product_code            = $row['product_code'];
            $product_id              = $row['product_id'];
            $json_itm = array(
                'id' => $row['product_id'],
                'product_id' => $row['product_id'],
                'product_code' => $row['product_code'],
                'product_name' => $row['product_name'],
                'item_cost' => $row['product_cost'],
                'value' => $row['product_name'] . " (" . $row['product_code'] . ")",
                'label' => $row['product_name'] . " (" . $row['product_code'] . ")"
            );
            array_push($json, $json_itm);
        }
        echo json_encode($json);
    }
    
    public function save_purchases()
    {
        //print_r($_SUBMIT);
        //print_r($this->input->post());
        $disMsg = '';
        $error  = '';
        $lastid = '';
        $this->form_validation->set_rules('supplier', 'supplier', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('purchases', $data);
        } else {
            $podate              = $this->input->post('podate');
            $reference_no        = $this->input->post('reference_no');
            $location_id        = $this->input->post('powarehouse');
            $warehouse_code      = $this->Warehouse_Model->get_warehouse_info($location_id);
            $perfix_for_contract = 'G' . $warehouse_code['code'] . "/"; //contract
            $ref_id_nxt          = $this->common_model->gen_ref_number('id', 'purchases', '');
            $reference_no        = $this->common_model->gen_ref_number('id', 'purchases', $perfix_for_contract);
            $supplier            = $this->input->post('supplier');
            $discount            = $this->input->post('sale_inv_discount');
            $powarehouse         = $this->input->post('powarehouse');
            $note                = $this->input->post('note');
            $grand_total         = $this->input->post('sub_total'); //$this->input->post('sale_total');
            $total               = $this->input->post('sub_total');
            $order_cal_des       = $this->input->post('order_cal_des');
            $supp_invocie_no     = $this->input->post('supp_invocie_no');
            $grn_header_id       = $this->purchases_model->add_grn_header($podate, $reference_no, $supplier, $discount, $powarehouse, $note, $grand_total, $total, $order_cal_des, $supp_invocie_no, $ref_id_nxt);
            $lastid              = $this->db->insert_id();
            if ($grn_header_id) {
                //insert sale item data
                $row       = $this->input->post('row');
                $rowCount  = $this->input->post('rowCount');
                $data_item = array();
                for ($i = 1; $i <= $rowCount; $i++) {
                    //echo "/ $rowCount , Test:".$row[$i]['product_id'][0];
                    if (isset($row[$i]['product_id'][0])) {
                        $data_item = array(
                            'purchase_id' => $grn_header_id,
                            'product_id' => $row[$i]['product_id'][0],
                            'quantity' => $row[$i]['qty'][0],
                            'item_cost' => $row[$i]['item_cost'][0],
                            'sub_total' => $row[$i]['sub_total'][0],
                            'discount' => 0,
                            'discount_cal' => 0
                        );
                        $this->purchases_model->add_grn_list_item($data_item);
                    }
                }
                $disMsg = 'Purchase successfully added';
                $this->session->set_flashdata('message', 'Purchase successfully added!');
                echo json_encode(array(
                    'sale_id' => $lastid,
                    'error' => $error,
                    'disMsg' => $disMsg
                ));
            }
        }
    }
    public function add_purchases($purchased_id = "")
    {
        $data['suppliers']      = $this->Supplier_Model->get_all_supplier();
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['warehouse']      = $this->purchases_model->get_warehouse();
        $data['supplier']       = $this->purchases_model->get_supplier();
        $data['purchased_id']   = $purchased_id;
        $data['tax_rates_list'] = $this->Tax_Rates_Model->get_all_tax_rates();
        $data['customer_list']  = $this->Customer_Model->get_all_customers();
        $data['status_list']    = $this->Common_Model->get_all_status();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'add_purchases';
        //$items = $this->Order_Model->get_proceed_order_item_list_by_po_id($purchased_id);
        //if($items)
        $this->load->view('purchases/add_purchases', $data);
        //else show_404();
        /*
        
        //if (!$this->User_Model->is_logged_in_k()) {
        
        //    $this->User_Model->checkLoginPanel_k();
        
        //}
        
        */
    }
    public function get_avalable_product_qty_for_return_purchases()
    {
        $product_id       = $this->input->get('product_id');
        $location_id     = $this->input->get('location_id');
        $sale_id          = $this->input->get('sale_id');
        $qty              = $this->input->get('qty');
        $saleqty          = $this->Sales_Return_Model->get_avalable_product_qty_for_return($product_id, $location_id, $sale_id);
        $salereturnqty    = $this->Sales_Return_Model->get_sales_return_product_qty($product_id, $location_id, $sale_id);
        $totalRemaningQty = $saleqty - $salereturnqty;
        //echo "qty:$qty , remmnaingQty:$saleqty , salereturnqty:$salereturnqty";
        if ($qty <= $totalRemaningQty) {
            $remmnaingQty = $saleqty;
        } else {
            $remmnaingQty = 0;
        }
        echo json_encode(array(
            'remmnaingQty' => $remmnaingQty
        ));
    }
    public function save_purchases_return()
    {
        $disMsg = '';
        $error  = '';
        $lastid = '';
        $this->form_validation->set_rules('supplier', 'supplier', 'required');
        if ($this->form_validation->run() == FALSE) {
            return;
            //$this->load->view('purchases', $data);
        } else {
            $purchase_id         = $this->input->post('purchase_id');
            $podate              = $this->input->post('podate');
            $reference_no        = $this->input->post('reference_no');
            $location_id         = $this->input->post('powarehouse');
            $warehouse_code      = $this->Warehouse_Model->get_warehouse_info($location_id);
            $perfix_for_contract = 'GR' . $warehouse_code['code'] . "/"; //contract
            $ref_id_nxt          = $this->common_model->gen_ref_number('pr_id', 'purchases_return', '');
            $reference_no        = $this->common_model->gen_ref_number('pr_id', 'purchases_return', $perfix_for_contract);
            $supplier            = $this->input->post('supplier');
            $discount            = $this->input->post('sale_inv_discount');
            $powarehouse         = $this->input->post('powarehouse');
            $note                = $this->input->post('note');
            $grand_total         = $this->input->post('sub_total'); //$this->input->post('sale_total');
            $total               = $this->input->post('sub_total');
            $order_cal_des       = $this->input->post('order_cal_des');
            $supp_invocie_no     = $this->input->post('supp_invocie_no');
            
            $this->db->trans_start();
            $grn_header_id       = $this->purchases_model->add_pur_r_header($podate, $reference_no, $supplier, $discount, $powarehouse, $note, $grand_total, $total, $order_cal_des, $supp_invocie_no, $ref_id_nxt,$purchase_id);
            $lastid              = $this->db->insert_id();
            if ($grn_header_id) {
                //insert sale item data
                $row       = $this->input->post('row');
                $rowCount  = $this->input->post('rowCount');
                $data_item = array();
                for ($i = 1; $i <= $rowCount; $i++) {
                    //echo "/ $rowCount , Test:".$row[$i]['product_id'][0];
                    if (isset($row[$i]['product_id'][0])) {
                        $data_item = array(
                            'pr_id' => $grn_header_id,
                            'product_id' => $row[$i]['product_id'][0],
                            'quantity' => $row[$i]['qty'][0],
                            'item_cost' => $row[$i]['item_cost'][0],
                            'sub_total' => $row[$i]['sub_total'][0]
                        );
                        $this->purchases_model->add_grn_return_items($data_item);
                    }
                }
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE){
                $disMsg = 'Purchase return attempt failed';
                $this->session->set_flashdata('message', 'Purchase return attempt failed!');
                echo json_encode(array(
                    'sale_id' => "",
                    'error' => "",
                    'disMsg' => $disMsg
                ));
            }else{
                $disMsg = 'Purchase successfully added';
                $this->session->set_flashdata('message', 'Purchase return successfully added!');
                echo json_encode(array(
                    'sale_id' => $lastid,
                    'error' => "",
                    'disMsg' => $disMsg
                ));
            }
        }
    }
    public function get_product_by_code()
    {
        $emp_array             = array();
        $product_code          = $this->input->get('term');
        $s_tmp_id              = strtotime("now"); //$this->input->get('s_tmp_id');
        $get_product_all_by_id = $this->purchases_model->get_product_by_code($product_code);
        if (!empty($get_product_all_by_id)) {
            $empar = array();
            //$s_tmp_id=0;
            foreach ($get_product_all_by_id as $key => $value) {
                $r     = $get_product_all_by_id[$key];
                $lb    = $get_product_all_by_id[$key]->product_name;
                // mt_rand()
                $label = array(
                    "id" => $s_tmp_id,
                    "item_id" => $get_product_all_by_id[$key]->product_id,
                    "label" => $get_product_all_by_id[$key]->product_code . ' / ' . $get_product_all_by_id[$key]->product_part_no . ' / ' . $get_product_all_by_id[$key]->product_oem_part_number . ' / ' . $get_product_all_by_id[$key]->product_name . ' / LKR.' . $get_product_all_by_id[$key]->product_cost,
                    "qty" => 1,
                    'row' => $r,
                    'value' => $get_product_all_by_id[$key]->product_name
                );
                array_push($empar, $label);
                //$s_tmp_id++;
            }
            echo json_encode($empar);
        } else {
            echo '[{"id":0,"label":"No matching result found! Product might be out of stock in the selected warehouse.","value":"hg"}]';
        }
    }
    public function get_product_by_code_r()
    {
        $emp_array             = array();
        $product_code          = $this->input->get('term');
        $sale_id               = $this->input->get('sale_id');
        //         $this->Sales_Model->get_products_suggestions($term,$sale_id);
        $s_tmp_id              = strtotime("now"); //$this->input->get('s_tmp_id');
        //      $get_product_all_by_id  = $this->purchases_model->get_product_by_code($product_code);
        $get_product_all_by_id = $this->Sales_Model->get_products_suggestions_r($product_code, $sale_id);
        // print_r($get_product_all_by_id );
        if (!empty($get_product_all_by_id)) {
            $empar = array();
            //$s_tmp_id=0;
            foreach ($get_product_all_by_id as $key => $value) {
                $r     = $get_product_all_by_id[$key];
                $lb    = $get_product_all_by_id[$key]->product_name;
                // mt_rand()
                $label = array(
                    "id" => $s_tmp_id,
                    "item_id" => $get_product_all_by_id[$key]->product_id,
                    "label" => $get_product_all_by_id[$key]->product_code . ' / ' . ' / ' . $get_product_all_by_id[$key]->product_name . ' / LKR.' . $get_product_all_by_id[$key]->product_price,
                    "qty" => 1,
                    'row' => $r,
                    'value' => $get_product_all_by_id[$key]->product_name
                );
                array_push($empar, $label);
                //$s_tmp_id++;
            }
            echo json_encode($empar);
        } else {
            echo '[{"id":0,"label":"No matching result found! Product might be out of stock in the selected warehouse.","value":"hg"}]';
        }
    }
    public function purchases_details($purchas_id = '')
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = "view_purchases";
        $data['po_header']      = $this->purchases_model->getpurchases_by_id($purchas_id);
        
        if ($data['po_header']) {
            $data['po_middle']     = $this->purchases_model->get_purchese_data_by_id($purchas_id);
            $data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info($data['po_header'][0]->location_id);
            //print_r($data['po_middle']);
            //$data['po_header_r'] = $this->purchases_model->getpurchases_return_by_id_sum($purchas_id);
            //  print_r($data['po_header_r']);
            //$po_header = $this->purchases_model->getpurchases_return_by_id($purchas_id);
            //$data['po_header']['0']['purchase_id']; 
            // $data['po_middle_r'] = $this->purchases_model->get_purchese_return_data_by_id($data['po_header_r'][0]->pr_id);
            $data['po_payment']    = $this->purchases_model->get_payment_by_id($purchas_id);
            $data['po_paid_total'] = $this->purchases_model->grn_pay_total($purchas_id);
            $data['purchas_id']    = $purchas_id;
            $this->load->view('purchases/purchases_details', $data);
        } else
            show_404();
    }
    public function return_details($purchas_id = '')
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = "view_purchases";
        $data['po_header']      = $this->purchases_model->getpurchases_return_by_id($purchas_id);
        $po_header              = $this->purchases_model->getpurchases_return_by_id($purchas_id);
        $data['po_middle']      = $this->purchases_model->get_purchese_return_data_by_id($data['po_header'][0]->pr_id);
        $data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info($data['po_header'][0]->location_id);
        $data['po_payment']     = $this->purchases_model->get_payment_by_id_r($purchas_id);
        $data['po_paid_total']  = $this->purchases_model->grn_pay_total_r($purchas_id);
        $data['purchas_id']     = $purchas_id;
        $this->load->view('purchases/return_details', $data);
    }
    public function get_list_return_purchases($value = '')
    {
        $search_key       = $this->input->get('search');
        $search_key_val   = $search_key['value'];
        $start            = $this->input->get('start');
        $length           = $this->input->get('length');
        $srh_warehouse_id = $this->input->get('srh_warehouse_id');
        $srh_to_date      = $this->input->get('srh_to_date');
        $srh_supplier_id  = $this->input->get('srh_supplier_id');
        $totalData        = 0;
        $values           = '';
        if ($search_key_val) {
            $values       = $this->purchases_model->getpurchases_return($start, $length, $search_key_val, $srh_warehouse_id, $srh_to_date, $srh_supplier_id);
            $values_count = $this->purchases_model->getpurchases_return('', '', $search_key_val, $srh_warehouse_id, $srh_to_date, $srh_supplier_id);
            $totalData    = empty($values_count) ? 0 : count($values_count);
        } else {
            $values       = $this->purchases_model->getpurchases_return($start, $length, '', $srh_warehouse_id, $srh_to_date, $srh_supplier_id);
            $values_count = $this->purchases_model->getpurchases_return('', '', '', $srh_warehouse_id, $srh_to_date, $srh_supplier_id);
            $totalData    = empty($values_count) ? 0 : count($values_count);
        }
        $totalFiltered = $totalData;
        /*echo "{";
        
        print_r($totalData);
        
        echo "|";
        
        print_r($totalFiltered);
        
        echo "}";*/
        /*
        
        "recordsTotal"    => intval( $totalData ),  
        
        "recordsFiltered" => intval( $totalFiltered ),
        
        'data' =>$data*/
        $data          = array();
        $pay_st;
        if (!empty($values)) {
            foreach ($values as $purchases) {
                if (empty($purchases->sale_pymnt_amount)) {
                    $pay_st = '<span class="label label-warning">Pending</span>';
                } else {
                    if ($purchases->grn_total_paid >= $purchases->grand_total) {
                        $pay_st = '<span class="label label-success">Paid</span>';
                    } else {
                        $pay_st = '<span class="label label-info">Partial</span>';
                    }
                }
                $row   = array();
                $row[] = $purchases->date;
                $row[] = $purchases->reference_no;
                $row[] = $purchases->supp_company_name;
                $row[] = $purchases->supp_invocie_no;
                $row[] = number_format($purchases->grand_total, 2, '.', '');
                $row[] = number_format($purchases->grn_total_paid, 2, '.', '');
                $row[] = number_format($purchases->grand_total - $purchases->grn_total_paid, 2, '.', '');
                $row[] = $pay_st;
                if (!$this->input->get('request_for'))
                    $row[] = '<div class="text-center"><div class="btn-group text-left">

                    <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>

                    <ul role="menu" class="dropdown-menu pull-right">

                     <li><a href="' . base_url('purchases/return_details/' . $purchases->pr_id) . '"><i class="fa fa-file-text-o"></i> GRN Details</a></li></ul></div>

                    

                    </div>';
                $data[] = $row;
            }
            $output = array(
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                'data' => $data
            );
            echo json_encode($output);
        } else {
            $output = array(
                'data' => ''
            );
            echo json_encode($output);
        }
    }
    public function getpurchases_by_id($pid)
    {
        $this->db->select("*");
        $this->db->from("purchases");
        $this->db->where("id", $pid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    public function getpurchases_return_by_id($pid)
    {
        $this->db->select("*");
        $this->db->from("purchases_return");
        $this->db->where("pr_id", $pid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    /*Approve and generate GRN*/
    function approve(){
        $this->load->model('grn_model');
        $this->load->model('stock_model');
        $this->load->model('products_model');
        /*Check permission*/
        
        /*End Check permission*/
        $purchase_id = $this->input->post('purchase_id');
        
        $purch_info =$this->getpurchases_by_id($purchase_id);
        
        $uuid = $this->input->post('uuid');
        if(!$purchase_id > 0 || !$this->session->userdata('ss_user_id') || !$uuid){
            http_response_code(400);
            return;
        }

        // if not approved yet (go to model function to get a better idea for the return value)
        if($this->purchases_model->is_approved($purchase_id)){
            $this->db->trans_start();
            
            $grn_ref_no    = '';
            $this->db->select('count(grn_id) as count');
            $this->db->from('grn');
            $this->db->where('receiver_location_id', $purch_info->location_id);
            $query        = $this->db->get();
            $count_result = $query->num_rows();
            if ($count_result > 0) {
                // If there are rows returned
                $r          = $query->row()->count;
                // Adding padding with 5 zeros
                $grn_ref_no = 'GRNP'.$purch_info->location_id.'-' . $purch_info->location_id . '-' . str_pad(($r + 1), 5, '0', STR_PAD_LEFT);
            } else {
                // If no rows are returned, set the count to 0
                $grn_ref_no = 'GRNP'.$purch_info->location_id.'-' . $purch_info->location_id . '-' . str_pad(1, 5, '0', STR_PAD_LEFT);
            }

            /*create origin entry - grn*/
            $ori_data = array(
                'sender_location_id'   => $purch_info->location_id,
                'receiver_location_id'   => $purch_info->location_id,
                'grn_ref_no'    => $grn_ref_no,
                'sender_ref_no' => $purch_info->reference_no,
                'origin_id'     => $purchase_id,
                'origin_type'   => 'purchase',
                'date_time'     => $purch_info->date,
                'uuid'          => $uuid,
                'approval_status'   => 1,
                'approved_by'   => $this->session->userdata('ss_user_id'),
                'approved_on'   => $purch_info->date
            );
            $origin_id = $this->grn_model->save_grn($ori_data);
            $grn_item_data = array();
            
            if(!$origin_id){
                http_response_code(403);
                return;
            }

            /*end create origin entry*/
            $purchase_items = $this->purchases_model->get_purchase_items($purchase_id);
            
            
            // Stock Movement Records
            // arry for
            $movements_list = array();
            foreach($purchase_items as $item){
                $data = array(
                    'location_id' => $purch_info->location_id,
                    'transaction_id' => $uuid,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_value' => $item->item_cost,
                    'movement_type' => 'in',
                    'movement_date' => $purch_info->date,
                    'origin' => 'grn',
                    'origin_id' => $origin_id
                );
                $movements_list[] = $data;
                
                $itm_data = array(
                    'grn_id'    => $origin_id,
                    'transaction_id' => $uuid,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_value' => $item->item_cost
                );
                $grn_item_data[] = $itm_data;
                
                $this->products_model->update_to_latest_grn_value($item->product_id);
            }
            
            $rec = $this->grn_model->save_grn_items($grn_item_data);
            if(!$rec){
                http_response_code(500);
                return;
            }

            $track_data = array( 'trans_id' => $uuid,'location_id' => $purch_info->location_id,'date_time' => $purch_info->date,'added_by' => $this->session->userdata('ss_user_id'));
            $this->stock_model->stock_m_tracker($track_data);
            $this->stock_model->bulkInsertMovements($movements_list);
            $this->purchases_model->approve($purchase_id);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE){
                http_response_code(500);
                /*
                    $error_message = $this->db->error()['message'];
                    echo json_encode(array(
                        "error" => "Database error: $error_message"
                    ));
                */
                exit;
            }
            
            foreach($purchase_items as $item){
                $this->products_model->update_to_latest_grn_value($item->product_id);
            }
            
            http_response_code(200);
            exit;
        }
        http_response_code(403);
        // Call the addMovement method from the model 
        // $log_id = $this->Stock_model->addMovement($data);
    }
    
    /*Approve and generate GR Note*/
    function approve_return(){
        $this->load->model('prn_model');
        $this->load->model('stock_model');
        $this->load->model('products_model');
        
        /*Check permission*/
        /*End Check permission*/
        $purchase_id = $this->input->post('return_id');
        
        $purch_info =$this->getpurchases_return_by_id($purchase_id);
        
        $uuid = $this->input->post('uuid');
        if(!$purchase_id > 0 || !$this->session->userdata('ss_user_id') || !$uuid){
            http_response_code(400);
            return;
        }

        // if not approved yet (go to model function to get a better idea for the return value)
        if($this->purchases_model->is_return_approved($purchase_id)){
            $this->db->trans_start();
            
            $grn_ref_no    = '';
            $this->db->select('count(grn_return_id) as count');
            $this->db->from('prn');
            $this->db->where('location_id', $purch_info->location_id);
            $query        = $this->db->get();
            $count_result = $query->num_rows();
            if ($count_result > 0) {
                // If there are rows returned
                $r          = $query->row()->count;
                // Adding padding with 5 zeros
                $grn_ref_no = 'PRN'.$purch_info->location_id.'-' . $purch_info->location_id . '-' . str_pad(($r + 1), 5, '0', STR_PAD_LEFT);
            } else {
                // If no rows are returned, set the count to 0
                $grn_ref_no = 'PRN'.$purch_info->location_id.'-' . $purch_info->location_id . '-' . str_pad(1, 5, '0', STR_PAD_LEFT);
            }

            /*create origin entry - grn*/
            $ori_data = array(
                'pr_id'         => $purchase_id,
                'location_id'   => $purch_info->location_id,
                'prn_ref_no'    => $grn_ref_no,
                'date_time'     => $purch_info->date,
                'uuid'          => $uuid,
                'approval_status'   => 1,
                'approved_by'   => $this->session->userdata('ss_user_id'),
                'approved_on'   => $purch_info->date
            );
            $origin_id = $this->prn_model->save_prn($ori_data);
            $grn_item_data = array();
            
            if(!$origin_id){
                http_response_code(403);
                return;
            }

            /*end create origin entry*/
            $purchase_items = $this->purchases_model->get_purchase_return_items($purchase_id);
            
            
            // Stock Movement Records
            // arry for
            $movements_list = array();
            foreach($purchase_items as $item){
                $data = array(
                    'location_id' => $purch_info->location_id,
                    'transaction_id' => $uuid,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_value' => $item->item_cost,
                    'movement_type' => 'out',
                    'movement_date' => $purch_info->date,
                    'origin' => 'prn',
                    'origin_id' => $origin_id
                );
                $movements_list[] = $data;
                
                $itm_data = array(
                    'prn_id'    => $origin_id,
                    'transaction_id' => $uuid,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_value' => $item->item_cost
                );
                $grn_item_data[] = $itm_data;
            }
            
            $rec = $this->prn_model->save_prn_items($grn_item_data);
            if(!$rec){
                http_response_code(500);
                return;
            }

            $track_data = array( 'trans_id' => $uuid,'location_id' => $purch_info->location_id,'date_time' => $purch_info->date,'added_by' => $this->session->userdata('ss_user_id'));
            $this->stock_model->stock_m_tracker($track_data);
            $this->stock_model->bulkInsertMovements($movements_list);
            $this->purchases_model->approve($purchase_id);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE){
                http_response_code(500);
                /*
                    $error_message = $this->db->error()['message'];
                    echo json_encode(array(
                        "error" => "Database error: $error_message"
                    ));
                */
                exit;
            }
            
            foreach($purchase_items as $item){
                $this->products_model->update_to_latest_grn_value($item->product_id);
            }
            
            http_response_code(200);
            exit;
        }
        http_response_code(403);
        // Call the addMovement method from the model 
        // $log_id = $this->Stock_model->addMovement($data);
    }
}