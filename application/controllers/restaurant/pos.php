<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Pos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pos_model');
        $this->load->model('common_model');
        $this->load->model('sales_model');
        $this->load->model('category_models');
        $this->load->model('Supplier_Model');
        $this->load->model('Warehouse_Model');
        date_default_timezone_set("Asia/Colombo");
    }
    public function index()
    {
        $data['customer_id'] = 0;
        $data['sale_id']     = $this->uri->segment(3);
        if ($data['sale_id']) {
            $data['sale_details'] = $this->pos_model->get_sale_info($data['sale_id']);
            if ($data['sale_details'][0]['sale_status'] != 2) {
                $data['sale_item_list'] = $this->pos_model->get_sale_item_list_by_sale_id($data['sale_id']);
                $data['customer_id']    = $data['sale_details'][0]['customer_id'];
            } else {
                $data['customer_id'] = $this->uri->segment(2);
                $data['sale_id']     = 0;
            }
        } else {
            $data['customer_id'] = $this->uri->segment(2);
            $data['sale_id']     = 0;
        }
        $data['category_by_id_1'] = $this->pos_model->get_product_by_cat_id(3);
        $data['category']         = $this->pos_model->get_all_category();
        
        $product_list_by_category = array();
        foreach ($data['category'] as $row) {
            $get_products_cat_by_cat = $this->pos_model->get_product_by_cat_id($row->cat_id);
            $products_of_cat         = array();
            foreach ($get_products_cat_by_cat as $row_2) {
                $productData                  = array();
                $productData['product_id']    = $row_2->product_id;
                $productData['product_name']  = $row_2->product_name;
                $productData['product_code']  = $row_2->product_code;
                $productData['product_price'] = $row_2->product_price;
                $productData['product_thumb'] = $row_2->product_thumb;
                $productData['cat_id']        = $row_2->cat_id;
                $productData['sub_cat_id']    = $row_2->sub_cat_id;
                
                $products_of_cat[] = $productData;
            }
            $product_list_by_category[] = $products_of_cat;
        }
        $data['product_list_by_category'] = $product_list_by_category;
        
        $data['sub_category']  = $this->pos_model->get_sub_category_by_cat_id(1);
        $data['get_customer']  = $this->pos_model->get_customer();
        $data['get_warehouse'] = $this->pos_model->get_warehouse();
        $data['product_list']  = $this->loadProductArray();
        $data['main_category'] = $this->category_models->getCategory();
        $this->load->view('pos/pos', $data);
    }
    public function vk()
    {
        $this->load->view("pos/vk");
    }
    public function ajaxcategorydata($category_id = '')
    {
        $category_id = $this->input->get('category_id');
        $out_cat     = '';
        $out_sub     = '';
        $d           = $this->pos_model->get_product_by_cat_id($category_id);
        $s           = $this->pos_model->get_sub_category_by_cat_id($category_id);
        if (!empty($d)) {
            $c    = count($d);
            $top  = 0;
            $left = 0;
            $i    = 0;
            foreach ($d as $key => $prod) {
                if ($i < $c) {
                    $out_cat .= "<button data-container='body' class='btn-prni btn-default product pos-tip' title='" . $prod->product_name . "'  value='" . $prod->product_code . "' type='button' id='product-" . $prod->product_id . "' product_id='" . $prod->product_id . "' product_price='" . $prod->product_price . "'  style='font-weight:bold; font-size:14px; height:120px; min-width:160px;max-width:180px;position:absolute; top:" . $top . "px; left:" . $left . "px;'> 
                
                
                        <img class='img-rounded col-xs-6' style='max-height:113px;padding:0px' alt='" . $prod->product_name . "' src='" . asset_url() . "uploads/thumbs/" . $prod->product_thumb . "'>
                

                        " . substr($prod->product_name, 0, 25) . "<br>" . $prod->product_price . "
                
                
                </button>";
                    if ($left <= 550) {
                        $left += 170;
                    } else {
                        $top += 130;
                        $left = 0;
                    }
                    
                    $i++;
                } else {
                    $i++;
                }
            }
            if (!empty($s)) {
                foreach ($s as $key => $sub_cat) {
                    $out_sub .= "<button id='subcategory-" . $sub_cat->sub_cat_id . "' type='button' value='" . $sub_cat->sub_cat_id . "' class='btn-prni subcategory' ><img src='" . asset_url() . "uploads/no-image.jpg' style='width:60px;height:60px;' class='img-rounded img-thumbnail'/><span>" . $sub_cat->sub_cat_name . "</span></button>";
                }
                $jproduct = array(
                    "products" => $out_cat,
                    "subcategories" => $out_sub,
                    "tcp" => 0
                );
                $ret      = json_encode($jproduct);
                echo $ret;
            } else {
                $jproduct = array(
                    "products" => $out_cat,
                    "subcategories" => "",
                    "tcp" => 0
                );
                $ret      = json_encode($jproduct);
                echo $ret;
            }
        } else {
            $jproduct = array(
                "products" => "<div></div>",
                "subcategories" => "",
                "tcp" => 0
            );
            $ret      = json_encode($jproduct);
            echo $ret;
        }
    }
    public function ajaxproducts($category_id = '', $subcategory_id = '', $per_page = '')
    {
        $nm             = '';
        $category_id    = $this->input->get('category_id');
        $subcategory_id = $this->input->get('subcategory_id');
        $n              = $this->pos_model->get_product_by_cat_sub_id($category_id, $subcategory_id);
        if (!empty($n)) {
            $c    = count($n);
            $top  = 0;
            $left = 0;
            $i    = 0;
            foreach ($n as $key => $pro) {
                if ($i < $c) {
                    $nm .= "<button data-container='body' class='btn-prni btn-default product pos-tip' title='" . $pro->product_name . "'  value='" . $pro->product_code . "' type='button' id='product-" . $pro->product_id . "' product_id='" . $pro->product_id . "' product_price='" . $pro->product_price . "'  style='font-weight:bold; font-size:14px; height:120px; min-width:160px;max-width:180px;position:absolute; top:" . $top . "px; left:" . $left . "px;'> 
                
<img class='img-rounded col-xs-7' style='max-height:113px; padding:0px;' alt='" . $pro->product_name . "' src='" . asset_url() . "uploads/thumbs/" . $pro->product_thumb . "'>

" . $pro->product_name . "<br>" . $pro->product_price . "
                
                </button>";
                    if ($left <= 550) {
                        $left += 170;
                    } else {
                        $top += 130;
                        $left = 0;
                    }
                    /* if ($top <= 300) {
                    $top += 130;
                    } else {
                    $left += 160;
                    $top = 0;
                    }*/
                    $i++;
                } else {
                    $i++;
                }
            }
            echo $nm;
        } else {
            echo "<div></div>";
        }
    }
    public function getProductDataByCode()
    {
        $emp_array             = array();
        $product_code          = $this->input->get('code');
        $customer_id           = $this->input->get('customer_id');
        $warehouse_id          = $this->input->get('warehouse_id');
        $get_product_all_by_id = $this->pos_model->get_product_by_code($product_code, $customer_id, $warehouse_id);
        if (!empty($get_product_all_by_id)) {
            $empar = array();
            foreach ($get_product_all_by_id as $key => $value) {
                $r     = $get_product_all_by_id[$key];
                $lb    = $get_product_all_by_id[$key]->product_name;
                $label = array(
                    "id" => mt_rand(10, 10000),
                    "product_id" => $get_product_all_by_id[$key]->product_id,
                    "product_code" => $get_product_all_by_id[$key]->product_code,
                    "product_price" => $get_product_all_by_id[$key]->product_price,
                    "label" => $get_product_all_by_id[$key]->product_code . ' | ' . $get_product_all_by_id[$key]->product_name,
                    "product_name" => $get_product_all_by_id[$key]->product_name,
                    "value" => $get_product_all_by_id[$key]->product_name
                );
                array_push($empar, $label);
            }
            echo json_encode($empar);
        } else {
            echo '[{"id":0,"label":"No matching result found! Product might be out of stock in the selected warehouse.","value":"hg"}]';
        }
    }
    public function loadProductArray()
    {
        $emp_array             = array();
        $returnstr             = array();
        $product_code          = null;
        $customer_id           = $this->input->get('customer_id');
        $warehouse_id          = $this->input->get('warehouse_id');
        $get_product_all_by_id = $this->pos_model->get_product_by_code($product_code, $customer_id, $warehouse_id);
        if (!empty($get_product_all_by_id)) {
            $empar = array();
            foreach ($get_product_all_by_id as $key => $value) {
                $label = array(
                    "id" => mt_rand(10, 10000),
                    "product_id" => $get_product_all_by_id[$key]->product_id,
                    "product_code" => $get_product_all_by_id[$key]->product_code,
                    "product_price" => $get_product_all_by_id[$key]->product_price,
                    "label" => $get_product_all_by_id[$key]->product_code . ' | ' . $get_product_all_by_id[$key]->product_name,
                    "product_name" => $get_product_all_by_id[$key]->product_name,
                    "value" => $get_product_all_by_id[$key]->product_name
                );
                array_push($empar, $label);
            }
            $returnstr = json_encode($empar);
            return $returnstr;
        } else {
            echo '[{"id":0,"label":"No matching result found! Product might be out of stock in the selected warehouse.","value":"hg"}]';
        }
    }
    public function pos_submit()
    {
        $sale_id              = $this->input->post('sale_id');
        $customer_id          = $this->input->post('poscustomer');
        $poswarehouse         = $this->input->post('poswarehouse');
        $discount             = $this->input->post('discount');
        $pos_discount_input   = $this->input->post('pos_discount_input1');
        $extra_charges        = $this->input->post('extra_charges');
        $extra_charges_amount = $this->input->post('extra_charges_amount');
        $pay_amount           = $this->input->post('pay_amount');
        $grand_total          = $this->input->post('grand_total');
        $paid_by              = $this->input->post('paid_by');
        $cc_name              = $this->input->post('cc_name');
        $cc_no                = $this->input->post('cc_no');
        $pcc_holder           = $this->input->post('pcc_holder');
        $pcc_type             = $this->input->post('pcc_type');
        $payment_note         = $this->input->post('payment_note');
        $shipping             = $this->input->post('posshipping');
        $sale_date            = date('Y-m-d H:i:s', strtotime($this->input->post('sale_datetime')));
        $sale_ref             = $this->input->post('sale_reference_no');
        if (!$sale_ref) {
            $query    = $this->pos_model->get_next_ref_no();
            $result   = $query->row();
            $sale_ref = sprintf("%03d", $result->sale_id + 1);
            $sale_ref = '(' . date('d') . ')-' . $sale_ref;
        }
        $pr_id                    = $this->input->post('product_id');
        $product_code             = $this->input->post('product_code');
        $product_name             = $this->input->post('product_name');
        $net_price                = $this->input->post('net_price');
        $ssubtotal                = $this->input->post('ssubtotal');
        $quantity                 = $this->input->post('quantity');
        $sale_pymnt_balane_amount = $this->input->post('balance_amount');
        $shipping_address         = $this->input->post('shipping_address');
        $dine_type                = $this->input->post('delivery_status');
        $sale_status              = $this->input->post('sale_status');
        
        $sales_data = array(
            'sale_id' => $sale_id,
            'sale_reference_no' => $sale_ref,
            'warehouse_id' => $poswarehouse,
            'customer_id' => $customer_id,
            'sale_datetime' => $sale_date,
            'sale_note' => $payment_note,
            'sale_total' => $grand_total,
            'sale_inv_discount' => $pos_discount_input,
            'sale_inv_discount_amount' => $discount,
            'paid_by' => $paid_by,
            'sale_datetime_created' => $sale_date,
            'sale_shipping' => $shipping,
            'invoice_type' => 1,
            'shipping_address' => $shipping_address,
            'dine_type' => $dine_type,
            'sale_extra_charges' => $extra_charges,
            'sale_extra_charges_amount' => $extra_charges_amount,
            'user' => $this->session->userdata('ss_user_id')
        );
        if ($sale_id) { //echo 'with sale id';
            //$this->pos_model->save_sale_header($sale_id, $sale_ref, $poswarehouse, $customer_id, $sale_date, $payment_note, $grand_total, $pos_discount_input, $discount, $paid_by, $shipping, '1', $shipping_address, $dine_type, $extra_charges, $extra_charges_amount);
            $this->pos_model->save_sale_header($sales_data, $sale_id);
        } else { //echo 'no sale id';
            //$sale_id = $this->pos_model->save_sale_header('', $sale_ref, $poswarehouse, $customer_id, $sale_date, $payment_note, $grand_total, $pos_discount_input, $discount, $paid_by, $shipping, '1', $shipping_address, $dine_type, $extra_charges, $extra_charges_amount);
            $sale_id = $this->pos_model->save_sale_header($sales_data);
        }
        if ($sale_id) {
            for ($i = 0; $i < count($pr_id); $i++) {
                $qty = $quantity[$i];
                $np  = $net_price[$i];
                $ssb = $qty * $np; //$ssubtotal[$i]
                $this->pos_model->sale_items_in($sale_id, $pr_id[$i], $product_code[$i], $product_name[$i], $quantity[$i], $net_price[$i], $ssb);
                $this->common_model->add_fi_table('sale', $sale_id, $pr_id[$i], $quantity[$i], $net_price[$i]);
            }
            if ($pay_amount > 0) {
                $t = $this->pos_model->sales_payment($sale_id, $paid_by, $grand_total, $sale_date, $payment_note, $cc_no, $pcc_holder, $pcc_type, "sale", $pay_amount, $sale_pymnt_balane_amount);
                $this->pos_model->complete_sale($sale_id);
                if ($t == true) {
                    $data['sale_id']        = $sale_id;
                    $data['pay_amount']     = $pay_amount;
                    $data['paid_by']        = $paid_by;
                    $data['balance_amount'] = $sale_pymnt_balane_amount;
                    echo json_encode(array(
                        'sale_id' => $sale_id,
                        'sale_ref' => $sale_ref,
                        'error' => '0',
                        'disMsg' => ''
                    ));
                } else {
                    echo json_encode(array(
                        'sale_id' => '',
                        'sale_ref' => '',
                        'error' => '0',
                        'disMsg' => ''
                    ));
                }
            } else {
                echo json_encode(array(
                    'sale_id' => $sale_id,
                    'sale_ref' => $sale_ref,
                    'error' => '0',
                    'disMsg' => ''
                ));
            }
        }
    }
    public function view_bill()
    {
        $data['category_by_id_1'] = $this->pos_model->get_product_by_cat_id(1);
        $data['category']         = $this->pos_model->get_all_category();
        $data['sub_category']     = $this->pos_model->get_sub_category_by_cat_id(1);
        $data['get_customer']     = $this->pos_model->get_customer();
        $data['get_warehouse']    = $this->pos_model->get_warehouse();
        $this->load->view('pos/pos-bill', $data);
    }
    public function sale_print()
    {
        $data['sale_id']        = $this->input->get('sale_id');
        $data['pay_amount']     = $this->input->get('pay_amount');
        $data['paid_by']        = $this->input->get('paid_by');
        $data['balance_amount'] = $this->input->get('balance_amount');
        $this->load->view('pos_print_nav', $data);
    }
    public function list_pos_sales()
    {
        $search_key     = $this->input->get('search');
        $search_key_val = $search_key['value'];
        $start          = $this->input->get('start');
        $length         = $this->input->get('length');
        $dine_type      = $this->input->get('dine_type');
        $cus_id         = $this->input->get('cus_id');
        $sales          = '';
        $totalData      = 0;
        if ($search_key_val) {
            //echo 'hello 1-';
            $sales     = $this->pos_model->get_all_sales($start, $length, $search_key_val, $dine_type, '1', '', $cus_id);
            $sales_c   = $this->pos_model->get_all_sales_c('', '', $search_key_val, $dine_type, '1', $cus_id);
            $sales_c   = $sales_c[0]['count_s'];
            //print_r($sales_c);
            $totalData = $sales_c;
        } else {
            //echo 'hello 2-';
            $sales     = $this->pos_model->get_all_sales($start, $length, '', $dine_type, '1', '', $cus_id);
            $sales_c   = $this->pos_model->get_all_sales_c('', '', '', $dine_type, '1', '', $cus_id);
            $sales_c   = $sales_c[0]['count_s'];
            //print_r($sales_c); 
            $totalData = $sales_c;
        }
        $totalFiltered = $totalData;
        $style         = '';
        $data          = array();
        if ($this->session->userdata('ss_group_id') == 3) {
            $style = 'display:none';
        }
        
        //print_r($sales);
        if (!empty($sales)) {
            foreach ($sales as $row) {
                //print_r($row['sale_id']);
                $nestedData = array();
                
                $sale_id           = $row['sale_id'];
                $total_paid_amount = 0;
                $total_paid_amount = $this->pos_model->get_total_paid_by_sale_id($sale_id);
                $return_tot_amt    = 0;
                $sale_items        = $this->pos_model->get_sale_items_by_sale_id($sale_id);
                $si                = '<table class="table table-condensed dataTable">';
                for ($i = 0; $i < count($sale_items); $i++) { //print_r($sale_items[$i]);
                    $si = $si . '<tr><td class="col-xs-11">' . $sale_items[$i]['product_name'] . '</td><td class="col-xs-1"> ' . intval($sale_items[$i]['quantity']) . '' . '</td></tr>';
                }
                $si = $si . '</table>';
                
                $to_be_paid   = $row['sale_total'] - $return_tot_amt;
                $nestedData[] = $row['sale_reference_no'];
                $nestedData[] = /*display_time_format(*/ $row['sale_datetime'] /*)*/ ; //print_r($nestedData);
                $nestedData[] = $row['cus_name'];
                $nestedData[] = $si;
                $nestedData[] = '<p style="text-align:right">' . $row['sale_total'] . '</p>';
                $btn          = '';
                $cash_input   = '';
                $payment_grid = '<p style="white-space:nowrap">- payment completed -</p>';
                if ($dine_type != 3) {
                    if (empty($total_paid_amount)) {
                        $pay_st       = '<span class="label label-warning" style="font-size:14px">Pending</span>';
                        $cash_input   = '<input style="width:100%;" class="form-control input-md py_amt" sale-id="' . $sale_id . '" id="c_pay_amount_' . $sale_id . '" onclick="this.select()" value="' . $to_be_paid . '"/>';
                        $payment_grid = '
                                <select class="form-control paid_by select2-nosearch" id="paying_by_' . $sale_id . '" name="paying_by' . $sale_id . '" >
                                    <option value="Cash" selected="selected">Cash &nbsp;&nbsp;</option>
                                    <option value="CC">Credit Card &nbsp;&nbsp;</option>
                                </select>';
                        $btn          = '<div align="center" class"col-xs-12">
                                        <div class="label label-success col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px" onClick ="set_as_paid(' . $sale_id . ') ">Add Payment </div>
                                        <div class="label label-info    col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px" onClick ="fbs_click_pos_no_c(' . $sale_id . ') ">Print Bill</div>
                                        
                                        <div class="label label-warning col-xs-12" style="cursor:pointer;font-size: 14px; margin:5px 0px 1px 0px;" onClick ="edit_sale(' . $sale_id . ') ">Edit Sale</div>
                                        </div>';
                    } else {
                        if ($total_paid_amount >= $to_be_paid) {
                            $btn    = '    <div align="center" class"col-xs-12">
                                        <span class="label label-warning col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px" onClick ="complete_sale(' . $sale_id . ') ">Complete Sale</span>
                                        <span class="label label-info col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px" onClick ="fbs_click_pos(' . $sale_id . ') ">Complete and Print Sale</span>
                                    </div>';
                            $pay_st = '<span class="label label-success" style="font-size:14px">Paid</span>';
                        } else {
                            $pay_st       = '<span class="label label-info" style="font-size:14px">Partial</span>';
                            $cash_input   = '<input style="width:100%;" class="form-control input-md py_amt" sale-id="' . $sale_id . '" id="c_pay_amount_' . $sale_id . '" onclick="this.select()" value="' . $to_be_paid . ' />';
                            $payment_grid = '<select class="form-control paid_by select2-nosearch" id="paying_by_' . $sale_id . '" name="paying_by' . $sale_id . '" >
                                             <option value="Cash" selected="selected">Cash &nbsp;&nbsp;</option>
                                             <option value="CC">Credit Card &nbsp;&nbsp;</option>
                                         </select>';
                            $btn          = '<center><span class="label label-warning" style="cursor:pointer;font-size: 15px" onClick ="fbs_click_pos(' . $sale_id . ') "><i class="fa fa-print"></i></span></center>';
                        }
                    }
                } else {
                    $btn        = '    <div align="center" class"col-xs-12">
                                        <span class="label label-warning col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px" onClick ="complete_sale(' . $sale_id . ') ">Deliver without reciept</span>
                                        <span class="label label-info col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px" onClick ="fbs_click_pos(' . $sale_id . ') ">Deliver</span>
                                    </div>';
                    $pay_st     = '<span class="label label-warning" style="font-size:14px">Pending</span>';
                    $cash_input = '';
					$payment_grid	= $row['shipping_address'];
                }
                $nestedData[] = '<center>' . $pay_st . '</center>';
                /*                
                $actionTxtDisble      = '';
                $actionTxtEnable      = '';
                $actionTxtUpdate      = '';
                $actionTxtDelete      = '';
                $url                  = base_url("sales/sale_details?sale_id=$sale_id");
                $actionTxtUpdate      = '<a onClick="fbs_click(' . $row['sale_id'] . ')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="clip-zoom-in-2"></i></a> &nbsp;';
                $actionTxtViewDetails = '<a href="' . base_url() . 'sales/view/' . $sale_id . '" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-file-text-o"></i></a> &nbsp;';
                */
                
                $nestedData[] = '<div class="col-xs-12" style="padding:0px">
                                            <div class="col-xs-6">' . $payment_grid . '</div>
                                            <div class="col-xs-6">' . $cash_input . '</div>
                                        </div>';
                
                '<div class="btn-group text-left">
                <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                <ul role="menu" class="dropdown-menu pull-right">
                <li><a href="' . base_url() . 'sales/view/' . $sale_id . '"><i class="fa fa-file-text-o"></i> Sale Details</a></li>
                <li><a onClick="fbs_click_pos(' . $row['sale_id'] . ')" data-toggle="modal" href="#" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-print"></i> Print Sale</a></li>
                 
                 <!--<li><a href="' . base_url() . 'sales_return/sales_return_add/' . $sale_id . '"><i class="fa fa-angle-double-left"></i></i> Return Sale</a></li>-->
                 <li style="' . $style . '"><a href="#" onClick ="delete_invoice(' . $sale_id . ')"><i class="fa fa-trash-o"></i></i> Delete Invoice</a></li>                    
                 <li style="' . $style . '"><a href="#" onClick ="delete_payments(' . $sale_id . ')"><i class="fa fa-trash-o"></i>    Delete Payments</a></li>
                </ul></div>';
                
                $nestedData[] = $btn;
                
                
                $data[] = $nestedData;
            }
            
            $json_data = array(
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data" => $data
            );
            
            echo json_encode($json_data);
        } else {
            $json_data = array(
                "recordsTotal" => '0',
                "recordsFiltered" => '0',
                "data" => ''
            );
            echo json_encode($json_data);
        }
    }
    public function get_customers()
    {
        $srh_customer_id = $this->input->get('srh_customer_id');
        $customers       = $this->pos_model->get_customers($srh_customer_id);
        echo json_encode($customers);
    }
    public function set_as_paid()
    {
        $sale_id              = $this->input->post('sale_id');
        $paid_by              = $this->input->post('paid_by');
        $sale_pymnt_date_time = $this->input->post('sale_pymnt_date_time');
        $given_amount         = $this->input->post('given_amount');
        $sale_details         = $this->pos_model->get_sale_info($sale_id);
        $t                    = $this->pos_model->sales_payment($sale_details[0]['sale_id'], $paid_by, $sale_details[0]['sale_total'], $sale_pymnt_date_time, '', '', '', '', "sale", $given_amount, '0');
        if ($t == true) {
            echo json_encode(array(
                'sale_id' => $sale_id,
                'error' => '0',
                'disMsg' => 'Paid !'
            ));
        } else {
            echo json_encode(array(
                'sale_id' => '',
                'error' => '0',
                'disMsg' => 'Something went wrong !'
            ));
        }
    }
    public function complete_sale()
    {
        $sale_id = $this->input->post('sale_id');
        $t       = $this->pos_model->complete_sale($sale_id);
        print_r($t);
        if ($t == true) {
            echo json_encode(array(
                'sale_id' => $sale_id,
                'error' => '0',
                'disMsg' => 'Completed!'
            ));
        } else {
            echo json_encode(array(
                'sale_id' => '',
                'error' => '0',
                'disMsg' => 'Something went wrong !'
            ));
        }
    }
    
    function create_customers()
    {
        $data['nc']             = $this->input->get('nc');
        $data['id']             = 1;
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'create_customer';
        
        if (isset($_GET['cus_id'])) {
            $cus_id = $_GET['cus_id'];
        } else {
            $cus_id = '';
        }
        if ($cus_id) {
            $data['cus_id']   = $cus_id;
            $data['type']     = 'E';
            $data['pageName'] = 'UPDATE CUSTOMER';
            $data['btnText']  = 'Update Customer';
            $data['customer'] = $this->common_model->get_customer_info($cus_id);
        } else {
            $data['cus_id']   = '';
            $data['type']     = 'A';
            $data['pageName'] = 'ADD CUSTOMER';
            $data['btnText']  = 'Add Customer';
            $data['customer'] = array();
        }
        $data['country_list'] = $this->common_model->get_all_country();
        $this->load->view('models/create_customer', $data);
    }
    
    public function save_pos_product()
    {
        if ($this->input->post('product_name') == '') {
            $st = array(
                'status' => 0,
                'validation' => 'ERROR'
            );
            echo json_encode($st);
        } else {
            $product_name = $this->input->post('product_name');
            $product_code = $this->input->post('product_code');
            $category     = $this->input->post('category');
            $subcategory  = $this->input->post('subcategory');
            if (!$subcategory)
                $subcategory = 0;
            $unit                    = $this->input->post('unit');
            $product_cost            = $this->price_filter($this->input->post('product_cost'));
            $product_price           = $this->price_filter($this->input->post('product_price'));
            $wholesale_price         = $this->price_filter($this->input->post('wholesale_price'));
            $credit_salling_price    = $this->price_filter($this->input->post('credit_salling_price'));
            $tax                     = $this->input->post('tax');
            $alert_quty              = $this->input->post('alert_quty');
            $product_details         = $this->input->post('product_details');
            $product_part_no         = $this->input->post('product_part_no');
            $product_oem_part_number = $this->input->post('product_oem_part_number');
            $product_id              = $this->input->post('product_id');
            $store_position          = $this->input->post('store_position');
            $product_max_qty         = floatval($this->input->post('product_max_qty'));
            
            $product_data = array(
                'cat_id' => $category,
                'sub_cat_id' => $subcategory,
                'product_name' => $product_name,
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
                'product_max_qty' => $product_max_qty
            );
            
            
            $last_id = $this->pos_model->save_product($product_data); //, $product_code, $category, $subcategory, $unit, $product_cost, $product_price, $wholesale_price, $credit_salling_price, $tax, $alert_quty, NULL, NULL, $product_details, $product_part_no, $product_oem_part_number, $product_id, $store_position, $product_max_qty);
            if ($last_id) {
                $st = array(
                    'status' => 1,
                    'validation' => 'Done!',
                    'last_id' => "PD" . sprintf("%04d", $last_id + 1)
                );
                echo json_encode($st);
            } else {
                $st = array(
                    'status' => 0,
                    'validation' => 'error occurred please contact your system administrator'
                );
                echo json_encode($st);
            }
        }
    }
    function price_filter($amount = '')
    {
        $s = explode("Rs.", $amount);
        return str_replace(',', '', $s[1]);
    }
    public function check()
    {
        $sale_items    = $this->pos_model->check1();
        $recorded_lost = 0;
        echo '<table style="border:solid 1px"><tr style="border:solid 1px"><th style="border:solid 1px">sale id</th><th style="border:solid 1px">qty</th><th style="border:solid 1px">price</th><th style="border:solid 1px">gross total</th><th style="border:solid 1px">calculated total</th><th style="border:solid 1px">loss</th></tr>';
        foreach ($sale_items as $row) {
            
            $this_lost = (($row['quantity'] * $row['unit_price']) - $row['gross_total']);
            $recorded_lost += $this_lost;
            echo '<tr>';
            echo '<td style="border:solid 1px;">' . $row['sale_id'] . '</td><td style="border:solid 1px">' . $row['quantity'] . '</td>' . '<td style="border:solid 1px">' . $row['unit_price'] . '</td><td style="border:solid 1px">' . $row['gross_total'] . '</td>' . '<td style="border:solid 1px">' . ($row['quantity'] * $row['unit_price']) . '</td>' . '<td style="border:solid 1px">' . (($row['quantity'] * $row['unit_price']) - $row['gross_total']) . '</td>';
            echo '</tr>';
        }
        
        echo '<th>qty</th><th>price</th><th>gross total</th><th>calculated total</th><th>' . $recorded_lost . '</th></table>';
    }
}