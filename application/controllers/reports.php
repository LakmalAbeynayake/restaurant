<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Reports extends CI_Controller
{
    var $main_menu_name = "reports";
    var $sub_menu_name = "suppliers";
    public function __construct()
    {
        parent::__construct();
        ini_set('max_execution_time', 15);
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        date_default_timezone_set("Asia/Colombo");
        $this->load->model('Common_Model');
        $this->load->model('Warehouse_Model');
        $this->load->model('Transfer_Model');
        $this->load->model('Sales_Model');
        $this->load->model('Purchases_Model');
        $this->load->model('Product_Damage_Model');
        $this->load->model('Sales_Return_Model');
        $this->load->model('Sequerty_Model');
        $this->load->model('Product_Models');
        $this->load->model('Customer_Model');
        $this->load->model('Menu_Items_List_Model');
        $this->load->model('category_models');
        $this->load->model('Report_Model');
        $this->load->model('category_models');
        $this->load->model('User_Model');
        ini_set('memory_limit', '50M');
    }
    public function products_v2()
    {
        $this->load->model('Product_Models');
        $this->load->model('category_models');
        $data['warehouse_list']    = $this->Warehouse_Model->get_all_warehouse();
        $data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info(1);
        $data['product_list']      = $this->Product_Models->getProducts();
        $data['main_menu_name']    = 'finance';
        $data['sub_menu_name']     = 'products_v2';
        $data['category_list']     = $this->category_models->getCategory();
        $data['user_list']         = $this->User_Model->getUsers();
        $this->load->view('rep_products_v2', $data);
    }
    public function index()
    {
        $this->load->model('Supplier_Model');
        $data['suppliers']      = $this->Supplier_Model->get_all_supplier();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = $this->sub_menu_name;
        $this->load->view('rep_reports', $data);
    }
    public function stock_movement()
    {
        $data['main_menu_name']    = 'finance';
        $data['sub_menu_name']     = 'stock_movement';
        $data['sub_menu_name_1']   = '';
        $data['product_list']      = $this->Product_Models->getProductsStockMovReport();
        $data['warehouse_list']    = $this->Warehouse_Model->get_all_warehouse();
        $data['category_list']     = $this->category_models->getCategory();
        $data['sub_category_list'] = $this->category_models->getSubCategory(1);
        $this->load->view('stock_movement', $data);
    }
    public function stock_movement_empty()
    {
        $data['main_menu_name']    = 'finance';
        $data['sub_menu_name']     = 'stock_movement';
        $data['sub_menu_name_1']   = '';
        $data['product_list']      = $this->Product_Models->getProductsStockMovReport();
        $data['warehouse_list']    = $this->Warehouse_Model->get_all_warehouse();
        $data['category_list']     = $this->category_models->getCategory();
        $data['sub_category_list'] = $this->category_models->getSubCategory(1);
        $data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info(1);
        $this->load->view('stock_movement_empty', $data);
    }
    public function stock_movement_list()
    {
        $product_id       = $this->input->post('product_id');
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $location_id      = $this->input->post('location_id');
        $product_name     = $this->input->post('product_name');
        $product_model    = $this->input->post('product_model');
        $srh_from_date    = $this->input->post('srh_from_date');
        $srh_to_date      = $this->input->post('srh_to_date');
        $cat_srh          = $this->input->post('cat_srh');
        $subcategory      = $this->input->post('subcategory');
        $show_all         = $this->input->post('show_all');
        $data             = array();
        $row              = "";
        $row .= "<tr>";
        $item_location_qty       = 0;
        $item_tot_qty            = 0;
        $item_warehouse_qty      = '';
        $warehosue_balance       = 0;
        $warehouse_opening_stock = 0;
        $product_info            = $this->Product_Models->get_product_by_id($product_id);
        if ($cat_srh != $product_info->cat_id && $cat_srh != '') {
            echo json_encode(array(
                "row" => ''
            ));
            die();
        }
        if ($subcategory != $product_info->sub_cat_id && $subcategory != '') {
        }
        $warehouse_opening_stock     = 0;
        $day_before                  = date('Y-m-d H:i:s', strtotime($srh_from_date . ' -1 day'));
        $opening_stock_date          = $day_before;
        $opening_stock_qty           = 0;
        $opening_stock_from_date     = '2019-10-18';
        $date_1                      = date('Y-m-d', strtotime($opening_stock_from_date . ' +1 day'));
        $os_i                        = 0;
        $os_grn                      = 0;
        $os_grn_rtn                  = 0;
        $os_grn                      = $this->Purchases_Model->getPurchasedQtyByWarehouseIdAndDateRange($location_id, $product_id, $date_1, $day_before);
        $os_grn_rtn                  = 0;
        $os_ir                       = 0;
        $os_s                        = $this->Report_Model->get_location_sale_by_location_id_and_date($location_id, $product_id, $date_1, $day_before);
        $os_h                        = $this->Report_Model->get_location_sale_by_location_id_and_date($location_id, $product_id, $date_1, $day_before, 'Hire');
        $os_st_adj                   = 0;
        $os_st_adj                   = 0;
        $os_ser_issue                = 0;
        $os_ser_issue_rtn            = 0;
        $os_exchange_qty             = 0;
        $os_exchange_qty             = intval($os_exchange_qty);
        $test_var                    = '';
        $opening_stock_qty_des       = "";
        $opening_stock_qty_des       = "<br/>wos:$warehouse_opening_stock , os_i:$os_i ,os_ir:$os_ir ,os_s:$os_s ,os_h:$os_h , os e :$os_exchange_qty:";
        $opening_stock_qty           = $warehouse_opening_stock + $os_i - $os_ir - $os_s - $os_h;
        $warehouse_opening_stock_tot = 0;
        $warehouse_opening_stock_tot = $warehouse_opening_stock + $os_grn - $os_grn_rtn - $os_i + $os_ir - $os_s - $os_h - $os_ser_issue + $os_ser_issue_rtn + $os_exchange_qty - $os_st_adj;
        $location_issue_qty          = 0;
        $location_issue_qty          = intval($location_issue_qty);
        $location_issue_return_qty   = 0;
        $location_cash_sale_qty      = $this->Report_Model->get_location_sale_by_location_id_and_date($location_id, $product_id, $srh_from_date, $srh_to_date, 'Cash');
        $location_hire_sale_qty      = $this->Report_Model->get_location_sale_by_location_id_and_date($location_id, $product_id, $srh_from_date, $srh_to_date, 'Hire');
        $purchased_qty               = $this->Purchases_Model->getPurchasedQtyByWarehouseIdAndDateRange($srh_warehouse_id, $product_id, $srh_from_date, $srh_to_date);
        $purchased_rtn_qty           = 0;
        $purchased_qty               = intval($purchased_qty);
        $sold_qty                    = $this->Report_Model->get_location_sale_by_location_id_and_date(0, $product_id, $srh_from_date, $srh_to_date, '', $srh_warehouse_id);
        $sold_qty                    = intval($sold_qty);
        $exchange_qty                = 0;
        $exchange_qty                = intval($exchange_qty);
        $other_in                    = 0;
        $other_in                    = 0;
        $ser_issue                   = 0;
        $ser_issue_rtn               = 0;
        $st_adj                      = 0;
        $st_adj                      = 0;
        $other_in                    = intval($other_in);
        $sold_val_balance            = 0;
        $sold_val_balance            = $sold_qty;
        $warehosue_balance           = $warehouse_opening_stock_tot + $purchased_qty - $purchased_rtn_qty - $sold_qty + $exchange_qty - $location_issue_qty + $location_issue_return_qty - $ser_issue + $ser_issue_rtn - $st_adj;
        $item_warehouse_qty          = '';
        $item_tot_qty                = '';
        $opening_stock_qty           = '';
        $other_in                    = '';
        $opening_stock_qty_des       = '';
        $purchased_rtn_qty           = intval($purchased_rtn_qty);
        if (!$purchased_qty)
            $purchased_qty = '';
        if (!$purchased_rtn_qty)
            $purchased_rtn_qty = '';
        if (!$st_adj)
            $st_adj = '';
        if (!$ser_issue)
            $ser_issue = '';
        if (!$ser_issue_rtn)
            $ser_issue_rtn = '';
        if (!$sold_qty)
            $sold_qty = '';
        if (!$exchange_qty)
            $exchange_qty = '';
        if (!$location_issue_return_qty)
            $location_issue_return_qty = '';
        if (!$location_issue_qty)
            $location_issue_qty = '';
        $cat_name = 'cat';
        $sale_val = '';
        if ($sold_qty)
            $sale_val = $sold_qty * $product_info->product_price;
        $pur_val = '';
        if ($pur_val)
            $pur_val = $purchased_qty * $product_info->product_cost;
        $row .= "<td align=\"left\" style=\"text-align:left\">$product_name $opening_stock_qty_des</td>";
        $row .= "<td align='right'>$product_info->cat_name</td>";
        $row .= "<td align='right'>$product_info->product_part_no</td>";
        $row .= "<td align='right'>$product_info->product_cost</td>";
        $row .= "<td align='right'>$warehouse_opening_stock_tot</td>";
        $row .= "<td align='right'>$purchased_qty </td>";
        $row .= "<td align='right'>$sold_qty </td>";
        $row .= "<td align='right'>$warehosue_balance </td>";
        $row .= "<td align='right'>$product_info->product_price</td>";
        $row .= "<td align='right'>$sale_val</td>";
        $row .= "<td align='right'>$pur_val</td>";
        $row .= "<td align='right'></td>";
        $row .= "</tr>";
        $display = false;
        if ($show_all == 'true') {
            if ($warehosue_balance != 0 || $warehouse_opening_stock != 0 || $purchased_qty != 0 || $sold_qty != 0 || $location_issue_qty != 0 || $location_issue_return_qty != 0 || $location_cash_sale_qty != 0 || $location_hire_sale_qty != 0 || $ser_issue != 0 || $ser_issue_rtn != 0 || $st_adj != 0) {
                $display = true;
            }
            $display = true;
        } else {
            if ($purchased_qty != 0 || $sold_qty != 0 || $location_issue_qty != 0 || $location_issue_return_qty != 0 || $location_cash_sale_qty != 0 || $location_hire_sale_qty != 0 || $ser_issue != 0 || $ser_issue_rtn != 0 || $st_adj != 0 || $exchange_qty != '') {
                $display = true;
            }
        }
        if ($display) {
            echo json_encode(array(
                "row" => $row
            ));
        } else {
            echo json_encode(array(
                "row" => ''
            ));
        }
    }
    public function payments()
    {
        $data['main_menu_name']    = 'reports';
        $data['sub_menu_name']     = 'reports/payments';
        $service_type              = $this->uri->segment('3');
        $data['service_type']      = $service_type;
        $pageName                  = '';
        $data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info(1);
        $data['pageName']          = $pageName;
        $data['warehouse_list']    = $this->Warehouse_Model->get_all_warehouse();
        $data['user_list']         = $this->User_Model->getUsers();
        $this->load->view('rep_payments', $data);
    }
    public function get_list_payments_for_report()
    {
        $data             = array();
        $srh_to_date      = '';
        $srh_from_date    = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $srh_type         = $this->input->post('srh_type');
        $srh_payment_term = $this->input->post('srh_payment_term');
        $srh_user_id = $this->input->post('ss_user_id');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d H:i:s', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d H:i:s', strtotime($this->input->post('srh_from_date')));
        }
        $values  = $this->Sales_Model->getPaymentsForPrint($srh_warehouse_id, $srh_to_date, $srh_from_date, $srh_type, $srh_payment_term,$srh_user_id);
        $columns = array(
            0 => 'bkng_id',
            1 => 'bkng_id',
            2 => 'bkng_id',
            3 => 'bkng_id',
            4 => 'bkng_id',
            5 => 'bkng_id',
            6 => 'bkng_id',
            7 => 'bkng_id',
            8 => 'bkng_id'
        );
        if (!empty($values)) {
            foreach ($values as $users) {
                $row             = array();
                $bkng_id         = $users->sale_id;
                $paymnt_id       = $users->sale_pymnt_id;
                $row[]           = sprintf("%04d", $users->sale_pymnt_id);
                $row[]           = $users->sale_pymnt_date_time;
                $row[]           = $users->sale_id ? $users->sale_id : $users->qts_id;//sprintf('%04d', $users->sale_id);
                $pymnt_collected = '';
                $checked_status  = '';
                if ($pymnt_collected == 1) {
                    $checked_status = 'checked=\"checked\"';
                } else {
                    $checked_status = '';
                }
                $row[]  = $users->user_first_name;
                $row[]  = $users->sale_payment_type;
                $row[]  = $users->sale_pymnt_paying_by;
                $row[]  = $users->sale_pymnt_amount;
                $paid   = 0;
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
    public function print_product_code_popup()
    {
        $data['main_menu_name'] = 'reports';
        $cat_srh                = $this->uri->segment(3);
        $sub_cat_srh            = $this->uri->segment(4);
        $data['product_list']   = $this->Product_Models->getProductsProduCodePrint($cat_srh, $sub_cat_srh);
        $this->load->view('models/print_product_code_popup', $data);
    }
    public function print_product_barcode_list_popup()
    {
        $data['main_menu_name'] = 'reports';
        $cat_srh                = $this->uri->segment(3);
        $sub_cat_srh            = $this->uri->segment(4);
        $data['product_list']   = $this->Product_Models->getProductsProduCodePrint($cat_srh, $sub_cat_srh);
        $this->load->view('models/print_product_barcode_list_popup.php', $data);
    }
    public function print_product_code_list_popup()
    {
        $data['main_menu_name'] = 'reports';
        $cat_srh                = $this->uri->segment(3);
        $sub_cat_srh            = $this->uri->segment(4);
        $data['product_list']   = $this->Product_Models->getProductsProduCodePrint($cat_srh, $sub_cat_srh);
        $this->load->view('models/print_product_code_list_popup', $data);
    }
    public function print_product_code()
    {
        $this->load->model('category_models');
        $data['main_menu_name'] = 'reports';
        $data['sub_menu_name']  = 'print_product_code';
        $cat_srh                = $this->input->post('cat_srh');
        $sub_cat_srh            = $this->input->post('cat_srh');
        $data['category_list']  = $this->category_models->getCategory();
        $this->load->view('rep_product_code_print', $data);
    }
    public function get_list_product_for_code_print($value = '')
    {
        $cat_srh     = $this->input->post('cat_srh');
        $sub_cat_srh = $this->input->post('sub_cat_srh');
        $this->load->model('Product_Models');
        $values = $this->Product_Models->getProductsProduCodePrint($cat_srh, $sub_cat_srh);
        $data   = array();
        if (!empty($values)) {
            foreach ($values as $products) {
                if ($products->product_status == 0) {
                    $k = "btn-warning";
                    $m = "fa-minus-circle";
                } else {
                    $k = "btn-green";
                    $m = "fa-check";
                }
                $retVal = (empty($products->sub_cat_name)) ? "--:--" : $products->sub_cat_name;
                $row    = array();
                $row    = array();
                $row[]  = $products->product_code;
                $row[]  = $products->product_name;
                $row[]  = $products->cat_name;
                $row[]  = $products->sub_cat_name;
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
    public function user_activitie()
    {
        $this->load->model('User_Model');
        $data['main_menu_name'] = 'reports';
        $data['sub_menu_name']  = 'user_activitie';
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['user_list']      = $this->User_Model->getUsers();
        $this->load->view('rep_user_activitie', $data);
    }
    public function get_list_user_activitie_for_print($value = '')
    {
        $this->load->model('User_Model');
        $srh_to_date      = '';
        $srh_from_date    = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d H:i:s', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d H:i:s', strtotime($this->input->post('srh_from_date')));
        }
        $srh_user_id = $this->input->post('srh_user_id');
        $this->load->model('Sales_Model');
        $columns       = array(
            0 => 'id',
            1 => 'id',
            2 => 'id',
            3 => 'id',
            4 => 'id'
        );
        $data          = array();
        $grn_data      = $this->User_Model->get_all_user_activitie_for_report($srh_warehouse_id, $srh_to_date, $srh_from_date,'','',$srh_user_id);
        $totalData     = count($grn_data);
        $totalFiltered = $totalData;
        foreach ($grn_data as $row) {
            $nestedData   = array();
            $id           = $row['id'];
            $nestedData[] = $row['details'];
            $nestedData[] = $row['user_first_name'];
            $nestedData[] = display_date_time_format($row['datetime']);
            $data[]       = $nestedData;
        }
        $json_data = array(
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
    public function grn()
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'grn';
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['supplier_list']  = $this->Purchases_Model->get_supplier();
        $this->load->view('rep_grn', $data);
    }
    public function get_list_grn_for_print($value = '')
    {
        $this->load->model('Purchases_Model');
        $srh_to_date        = '';
        $srh_from_date      = '';
        $srh_warehouse_id   = $this->input->post('srh_warehouse_id');
        $srh_supplier_id    = $this->input->post('srh_supplier_id');
        $srh_payment_status = $this->input->post('srh_payment_status');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }
        $this->load->model('Sales_Model');
        $columns       = array(
            0 => 'sale_datetime',
            1 => 'sale_reference_no',
            2 => 'cus_name',
            3 => 'sale_id',
            4 => 'sale_id',
            5 => 'sale_id'
        );
        $data          = array();
        $grn_data      = $this->Purchases_Model->get_all_grn_for_report($srh_warehouse_id, $srh_to_date, $srh_from_date, '', '', $srh_supplier_id);
        $totalData     = count($grn_data);
        $totalFiltered = $totalData;
        foreach ($grn_data as $row) {
            $p_status          = '';
            $total_paid_amount = $row['grn_total_paid'];
            if (empty($total_paid_amount)) {
                $pay_st   = '<span class="label label-warning">Pending</span>';
                $p_status = 'Pending';
            } else {
                if ($total_paid_amount >= $row['grand_total']) {
                    $pay_st   = '<span class="label label-success">Paid</span>';
                    $p_status = 'Paid';
                } else {
                    $pay_st   = '<span class="label label-info">Partial</span>';
                    $p_status = 'Partial';
                }
            }
            if ($srh_payment_status) {
                if ($srh_payment_status == $p_status) {
                    $nestedData   = array();
                    $id           = $row['id'];
                    $nestedData[] = display_date_time_format($row['date']);
                    $nestedData[] = $row['reference_no'];
                    $nestedData[] = $row['supp_company_name'];
                    $nestedData[] = $pay_st;
                    $nestedData[] = number_format($row['grand_total'], 2, '.', '');
                    $nestedData[] = number_format($total_paid_amount, 2, '.', '');
                    $nestedData[] = number_format($row['grand_total'] - $total_paid_amount, 2, '.', '');
                    $data[]       = $nestedData;
                }
            } else {
                $nestedData   = array();
                $id           = $row['id'];
                $nestedData[] = display_date_time_format($row['date']);
                $nestedData[] = $row['reference_no'];
                $nestedData[] = $row['supp_company_name'];
                $nestedData[] = $pay_st;
                $nestedData[] = number_format($row['grand_total'], 2, '.', '');
                $nestedData[] = number_format($total_paid_amount, 2, '.', '');
                $nestedData[] = number_format($row['grand_total'] - $total_paid_amount, 2, '.', '');
                $data[]       = $nestedData;
            }
        }
        $json_data = array(
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
    public function print_grn()
    {
        $this->load->model('Purchases_Model');
        $this->load->model('Supplier_Model');
        $srh_to_date                = '';
        $srh_from_date              = '';
        $srh_warehouse_id           = $this->input->get('srh_warehouse_id');
        $srh_supplier_id            = $this->input->get('srh_supplier_id');
        $srh_payment_status         = $this->input->get('srh_payment_status');
        $data['srh_payment_status'] = $srh_payment_status;
        if ($this->input->get('srh_to_date')) {
            $srh_to_date = date('Y-m-d H:i:s', strtotime($this->input->get('srh_to_date')));
        }
        if ($this->input->get('srh_from_date')) {
            $srh_from_date = date('Y-m-d H:i:s', strtotime($this->input->get('srh_from_date')));
        }
        $this->load->model('Sales_Model');
        $data['grn_list']  = $this->Purchases_Model->get_all_grn_for_report($srh_warehouse_id, $srh_to_date, $srh_from_date, '', '', $srh_supplier_id);
        $srh_supplier_name = '';
        if ($srh_warehouse_id) {
            $warehouse_details          = $this->Warehouse_Model->get_warehouse_info($srh_warehouse_id);
            $data['warehouse_details']  = $warehouse_details;
            $data['srh_warehouse_name'] = $warehouse_details['name'];
        } else {
            $data['srh_warehouse_name'] = "-All-";
        }
        if ($srh_supplier_id) {
            $supplier_details  = $this->Supplier_Model->get_supplier_info($srh_supplier_id);
            $srh_supplier_name = $supplier_details['supp_company_name'];
        }
        $data['srh_supplier_name'] = $srh_supplier_name;
        if ($srh_to_date) {
            $data['srh_to_date_dis'] = display_date_time_format($srh_to_date);
        } else {
            $data['srh_to_date_dis'] = '';
        }
        if ($srh_from_date) {
            $data['srh_from_date_dis'] = display_date_time_format($srh_from_date);
        } else {
            $data['srh_from_date_dis'] = '';
        }
        $this->load->view('models/print_grn', $data);
    }
    public function daily_sales()
    {
        $data['main_menu_name']    = $this->main_menu_name;
        $data['sub_menu_name']     = 'rep_daily_sales';
        $data['warehouse_list']    = $this->Warehouse_Model->get_all_warehouse();
        $data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info(1);
        $this->load->view('rep_sales_daily', $data);
    }
    public function sales()
    {
        $data['main_menu_name']    = $this->main_menu_name;
        $data['sub_menu_name']     = 'sales';
        $data['warehouse_list']    = $this->Warehouse_Model->get_all_warehouse();
        $data['customer_list']     = $this->Customer_Model->get_all_customers();
        $data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info(1);
        $this->load->view('rep_sales', $data);
    }
    public function print_sale()
    {
        $srh_to_date                = '';
        $srh_from_date              = '';
        $srh_warehouse_id           = $this->input->get('srh_warehouse_id');
        $srh_customer_id            = $this->input->get('srh_customer_id');
        $srh_payment_status         = $this->input->get('srh_payment_status');
        $data['srh_payment_status'] = $srh_payment_status;
        if ($this->input->get('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->get('srh_to_date')));
        }
        if ($this->input->get('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->get('srh_from_date')));
        }
        $this->load->model('Sales_Model');
        $data['sales_list'] = $this->Sales_Model->get_all_sales_for_report($srh_warehouse_id, $srh_to_date, $srh_from_date, '', '', '', $srh_customer_id);
        $srh_customer_name  = '';
        if ($srh_customer_id) {
            $customer_details          = $this->Customer_Model->get_customer_info($srh_customer_id);
            $data['srh_customer_name'] = $customer_details['cus_name'];
        } else {
            $data['srh_customer_name'] = "-All-";
        }
        if ($srh_warehouse_id) {
            $warehouse_details          = $this->Warehouse_Model->get_warehouse_info($srh_warehouse_id);
            $data['srh_warehouse_name'] = $warehouse_details['name'];
            $data['warehouse_details']  = $warehouse_details;
        } else {
            $data['srh_warehouse_name'] = "-All-";
        }
        if ($srh_to_date) {
            $data['srh_to_date_dis'] = ($srh_to_date);
        } else {
            $data['srh_to_date_dis'] = '';
        }
        if ($srh_from_date) {
            $data['srh_from_date_dis'] = ($srh_from_date);
        } else {
            $data['srh_from_date_dis'] = '';
        }
        $this->load->view('models/print_sale', $data);
    }
    public function suppliers()
    {
        $this->load->model('Supplier_Model');
        $data['suppliers']      = $this->Supplier_Model->get_all_supplier();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = $this->sub_menu_name;
        $this->load->view('rep_suppliers', $data);
    }
    public function print_supplier()
    {
        $this->load->model('Supplier_Model');
        $data['suppliers_list'] = $this->Supplier_Model->get_all_supplier();
        $this->load->view('models/print_supplier', $data);
    }
    public function products()
    {
        $this->load->model('Product_Models');
        $this->load->model('category_models');
        $data['warehouse_list']    = $this->Warehouse_Model->get_all_warehouse();
        $data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info(1);
        $data['product_list']      = $this->Product_Models->getProducts();
        $data['main_menu_name']    = 'finance';
        $data['sub_menu_name']     = 'products';
        $data['category_list']     = $this->category_models->getCategory();
        $data['user_list']         = $this->User_Model->getUsers();
       // $this->load->view('rep_products_sakura', $data);
        $this->load->view('rep_products', $data);
    }
    public function menuitem()
    {
        $this->load->model('Product_Models');
        $this->load->model('category_models');
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['product_list']   = $this->Product_Models->getProducts();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'menuitems';
        $data['category_list']  = $this->category_models->getCategory();
        $this->load->view('rep_menuitems', $data);
    }
    public function products_quantity()
    {
        $this->load->model('Product_Models');
        $this->load->model('category_models');
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['product_list']   = $this->Product_Models->getProducts();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'products_quantity';
        $data['category_list']  = $this->category_models->getCategory();
        $this->load->view('rep_products_quantity', $data);
    }
    public function supplier_products()
    {
        $this->load->model('Product_Models');
        $this->load->model('purchases_model');
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['product_list']   = $this->Product_Models->getProducts();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'supplier_products';
        $data['supplier_list']  = $this->purchases_model->get_supplier();
        $this->load->view('rep_supplier_products', $data);
    }
    public function alert_quantity()
    {
        $this->load->model('Product_Models');
        $this->load->model('category_models');
        $data['category_list']  = $this->category_models->getCategory();
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['product_list']   = $this->Product_Models->getProducts();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'alert_quantity';
        $this->load->view('rep_alert_quantity', $data);
    }
    public function print_products()
    {
        $this->load->model('Product_Models');
        $data['product_list'] = $this->Product_Models->getProducts();
        $this->load->view('models/print_products', $data);
    }
    public function print_alert_quantity()
    {
        $this->load->model('Product_Models');
        $data['product_list'] = $this->Product_Models->getProducts();
        $this->load->view('models/print_alert_quantity', $data);
    }
    public function get_list_sales_for_print($value = '')
    {
        $srh_to_date        = '';
        $srh_from_date      = '';
        $srh_warehouse_id   = $this->input->post('srh_warehouse_id');
        $srh_customer_id    = $this->input->post('srh_customer_id');
        $srh_payment_status = $this->input->post('srh_payment_status');
        $srh_payment_term   = $this->input->post('srh_payment_term');
        $in_type            = $this->input->post('in_type');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }
        if($srh_from_date == ''){
            $json_data = array(
                "recordsTotal" => intval(0),
                "recordsFiltered" => intval(0),
                "data" => array()
            );
            echo json_encode($json_data);
            exit;
        }
        $this->load->model('Sales_Model');
        $columns       = array(
            0 => 'sale_datetime',
            1 => 'sale_reference_no',
            2 => 'cus_name',
            3 => 'sale_id',
            4 => 'sale_id',
            5 => 'sale_id'
        );
        $data          = array();
        $sales         = $this->Sales_Model->get_sales_for_report($srh_warehouse_id, $srh_to_date, $srh_from_date, '', '', '', $srh_customer_id, $srh_payment_term, $in_type);
        //print_r($sales);
        //echo "hi";
        //exit;
        $totalData     = count($sales);
        $totalFiltered = $totalData;
        foreach ($sales as $row) {
            $nestedData        = array();
            $p_status          = '';
            $pay_st            = '';
            $sale_id           = $row['sale_id'];
            $total_paid_amount = $this->Sales_Model->get_total_paid_by_sale_id($sale_id);
            $sale_payments     = $this->Sales_Model->get_sale_payments_by_sale_id($sale_id);
            $return_tot_amt    = 0;
            $return_tot_amt    = 0;//$this->Sales_Return_Model->get_total_return_by_sale_id($sale_id);
            $nestedData[]      = display_date_time_format($row['sale_datetime']);
            $nestedData[]      = $row['cus_name']."-".$row['cus_phone'];
            $nestedData[]      = sprintf('%04d', $row['sale_id']);
            $dt ="";
            switch ($row['dine_type']) {
              case 1:
                $dt ='<span class="label label-warning">Dine-in</span>';
                break;
              case 2:
                $dt ='<span class="label label-success">Take Away</span>';
                break;
              case 3:
                $dt ='<span class="label label-info">Delivery</span>';
                break;
              default:
                  $dt ="n/a";
            }
            $nestedData[] = $dt;
            if (empty($total_paid_amount)) {
                $pay_st   = '<span class="label label-warning">Pending</span>';
                $p_status = 'Pending';
            } else {
                if ($total_paid_amount >= ($row['sale_total'] - $return_tot_amt)) {
                    $pay_st   = '<span class="label label-success">Paid</span>';
                    $p_status = 'Paid';
                } else {
                    $pay_st   = '<span class="label label-info">Partial</span>';
                    $p_status = 'Partial';
                }
            }
            $pay_st = "";
            foreach($sale_payments as $pym){
                //print_r($pym);
                $pay_st .= "<p>".$pym->sale_pymnt_amount."(".$pym->sale_pymnt_paying_by.")</p>";
            }
            if ($srh_payment_status) {
                if ($srh_payment_status == $p_status) {
                    $nestedData[] = $pay_st;
                    $nestedData[] = number_format($row['sale_total'], 2, '.', '');
                    //$nestedData[] = $return_tot_amt;
                    $nestedData[] = number_format($total_paid_amount, 2, '.', '');
                    $nestedData[] = number_format($row['sale_total'] - $return_tot_amt - $total_paid_amount, 2, '.', '');
                    $data[]       = $nestedData;
                }
            } else {
                $nestedData[] = $pay_st;
                $nestedData[] = number_format($row['sale_total'], 2, '.', '');
                //$nestedData[] = $return_tot_amt;
                $nestedData[] = number_format($total_paid_amount, 2, '.', '');
                $nestedData[] = number_format($row['sale_total'] - $return_tot_amt - $total_paid_amount, 2, '.', '');
                $data[]       = $nestedData;
            }
        }
        $json_data = array(
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
    public function get_list_sales_report_for_print_daily($value = '')
    {
        $srh_to_date      = '';
        $srh_from_date    = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }
        $this->load->model('Sales_Model');
        $columns       = array(
            0 => 'sale_datetime',
            1 => 'sale_reference_no',
            2 => 'cus_name',
            3 => 'sale_id',
            4 => 'sale_id',
            5 => 'sale_id'
        );
        $data          = array();
        $sales         = $this->Sales_Model->get_all_sales_return_for_report($srh_warehouse_id, $srh_to_date, $srh_from_date);
        $totalData     = count($sales);
        $totalFiltered = $totalData;
        foreach ($sales as $row) {
            $nestedData        = array();
            $sale_id           = $row['sale_id'];
            $total_paid_amount = $row['total_paid_amount'];
            $nestedData[]      = display_date_time_format($row['sl_rtn_datetime']);
            $nestedData[]      = $row['sl_rtn_reference_no'];
            if (empty($total_paid_amount)) {
                $pay_st = '<span class="label label-warning">Pending</span>';
            } else {
                if ($total_paid_amount >= $row['sl_rtn_total']) {
                    $pay_st = '<span class="label label-success">Paid</span>';
                } else {
                    $pay_st = '<span class="label label-info">Partial</span>';
                }
            }
            $nestedData[] = $pay_st;
            $nestedData[] = number_format($row['cost_total'], 2, '.', '');
            $nestedData[] = number_format($row['sl_rtn_total'], 2, '.', '');
            $nestedData[] = number_format($row['sl_rtn_total'] - $row['cost_total'], 2, '.', '');
            $data[]       = $nestedData;
        }
        $json_data = array(
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
    public function get_list_sales_for_print_daily($value = '')
    {
        $srh_to_date      = '';
        $srh_from_date    = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d H:i:s', strtotime($this->input->post('srh_to_date'))); 
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d H:i:s', strtotime($this->input->post('srh_from_date'))); 
        }
        $dine_type = $this->input->post('dine_type');
        $this->load->model('Sales_Model');
        $columns       = array(
            0 => 'sale_datetime',
            1 => 'sale_reference_no',
            2 => 'cus_name',
            3 => 'sale_id',
            4 => 'sale_id',
            5 => 'sale_id'
        );
        $data          = array();
        $sales         = $this->Sales_Model->get_all_sales_for_report($srh_warehouse_id, $srh_to_date, $srh_from_date , "","","","","","",$dine_type);
        $totalData     = count($sales);
        $totalFiltered = $totalData;
        foreach ($sales as $row) {
            $nestedData        = array();
            $sale_id           = $row['sale_id'];
            $total_paid_amount = $row['total_paid_amount'];
            $nestedData[]      = display_date_time_format($row['sale_datetime']);
            $nestedData[]      = "<a href=\"".base_url("sales/view/".$row['sale_id'])."\" target=\"_new".$row['sale_id']."\">".sprintf('%04d', $row['sale_id'])."</a>";
            if (empty($total_paid_amount)) {
                $pay_st = '<span class="label label-warning">Pending</span>';
            } else {
                if ($total_paid_amount >= $row['sale_total']) {
                    $pay_st = '<span class="label label-success">Paid</span>';
                } else {
                    $pay_st = '<span class="label label-info">Partial</span>';
                }
            }
            $nestedData[] = $row['cus_name']."-".$row['cus_phone'];
            $dt ="";
            switch ($row['dine_type']) {
              case 1:
                $dt ='<span class="label label-warning">Dine-in</span>';
                break;
              case 2:
                $dt ='<span class="label label-success">Take Away</span>';
                break;
              case 3:
                $dt ='<span class="label label-info">Delivery</span>';
                break;
              default:
                  $dt ="n/a";
            }
            $nestedData[] = $dt;
            $nestedData[] = number_format($row['cost_total'], 2, '.', '');
            $nestedData[] = number_format($row['sale_total'], 2, '.', '');
            $nestedData[] = number_format($row['sale_total'] - $row['cost_total'], 2, '.', '');
            $data[]       = $nestedData;
        }
        $json_data = array(
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
    function get_list_cancelled_sales_for_print_daily($value = '')
    {
        $srh_to_date      = '';
        $srh_from_date    = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }
        $this->load->model('Sales_Model');
        $columns       = array(
            0 => 'sale_datetime',
            1 => 'sale_reference_no',
            2 => 'cus_name',
            3 => 'sale_id',
            4 => 'sale_id',
            5 => 'sale_id'
        );
        $data          = array();
        $sales         = $this->Sales_Model->get_all_cancelled_sales_for_report($srh_warehouse_id, $srh_to_date, $srh_from_date);
        $totalData     = count($sales);
        $totalFiltered = $totalData;
        foreach ($sales as $row) {
            $nestedData        = array();
            $sale_id           = $row['sale_id'];
            $total_paid_amount = $row['total_paid_amount'];
            $nestedData[]      = display_date_time_format($row['sale_datetime']);
            $nestedData[]      = "<a href=\"".base_url("sales/view/".$row['sale_id'])."\" target=\"_new".$row['sale_id']."\">".sprintf('%04d', $row['sale_id'])."</a>";
            if (empty($total_paid_amount)) {
                $pay_st = '<span class="label label-warning">Pending</span>';
            } else {
                if ($total_paid_amount >= $row['sale_total']) {
                    $pay_st = '<span class="label label-success">Paid</span>';
                } else {
                    $pay_st = '<span class="label label-info">Partial</span>';
                }
            }
            $nestedData[] = $row['cus_name']."-".$row['cus_phone'];
            $dt ="";
            switch ($row['dine_type']) {
              case 1:
                $dt ='<span class="label label-warning">Dine-in</span>';
                break;
              case 2:
                $dt ='<span class="label label-success">Take Away</span>';
                break;
              case 3:
                $dt ='<span class="label label-info">Delivery</span>';
                break;
              default:
                  $dt ="n/a";
            }
            $nestedData[] = $dt;
            $nestedData[] = number_format($row['cost_total'], 2, '.', '');
            $nestedData[] = number_format($row['sale_total'], 2, '.', '');
            $nestedData[] = number_format($row['sale_total'] - $row['cost_total'], 2, '.', '');
            $data[]       = $nestedData;
        }
        $json_data = array(
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
    public function get_list_supplier_for_print($value = '')
    {
        $this->load->model('Supplier_Model');
        $requestData   = $_REQUEST;
        $columns       = array(
            0 => 'supp_code',
            0 => 'supp_company_name',
            1 => 'supp_email',
            2 => 'supp_company_phone',
            3 => 'supp_city',
            4 => 'country_id',
            5 => 'supp_id'
        );
        $data          = array();
        $suppliers     = $this->Supplier_Model->get_all_supplier();
        $totalData     = count($suppliers);
        $totalFiltered = $totalData;
        foreach ($suppliers as $row) {
            $nestedData   = array();
            $nestedData[] = $row['supp_code'];
            $nestedData[] = $row['supp_company_name'];
            $nestedData[] = $row['supp_email'];
            $nestedData[] = $row['supp_company_phone'];
            $nestedData[] = $row['supp_city'];
            $nestedData[] = $row['country_short_name'];
            $data[]       = $nestedData;
        }
        $json_data = array(
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
    public function get_list_supplier_product_for_print($value = '')
    {
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $supplier_srh     = $this->input->post('supplier_srh');
        $this->load->model('Product_Models');
        $values = $this->Product_Models->getSupplierProductsForReport($srh_warehouse_id, $supplier_srh);
        $data   = array();
        if (!empty($values)) {
            foreach ($values as $products) {
                if ($products->product_status == 0) {
                    $k = "btn-warning";
                    $m = "fa-minus-circle";
                } else {
                    $k = "btn-green";
                    $m = "fa-check";
                }
                $retVal              = (empty($products->sub_cat_name)) ? "--:--" : $products->sub_cat_name;
                $row                 = array();
                $transferd_qty       = 0;
                $transfer_reseve_qty = 0;
                $transferd_qty       = $this->Transfer_Model->getTransferdQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $transfer_reseve_qty = $this->Transfer_Model->getTransferResevedQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $sold_qty            = $this->Sales_Model->getSoldQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $purchased_qty       = $this->Purchases_Model->getPurchasedQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $product_damaged_qty = $this->Product_Damage_Model->getProductDamagedQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $sales_return_qty    = $this->Sales_Return_Model->getSalesReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $row                 = array();
                $balance_qty         = $purchased_qty + $transfer_reseve_qty + $sales_return_qty - $sold_qty - $transferd_qty - $product_damaged_qty;
                $row[]               = $products->product_code;
                $row[]               = $products->product_name;
                $row[]               = $products->supp_company_name;
                if ($products->product_part_no) {
                    $row[] = $products->product_part_no;
                } else {
                    $row[] = '';
                }
                $row[]  = number_format($purchased_qty, 2, '.', ',');
                $row[]  = number_format($sold_qty, 2, '.', ',');
                $row[]  = number_format($products->product_alert_qty, 2, '.', ',');
                $row[]  = number_format($balance_qty, 2, '.', ',');
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
    public function get_list_product_for_print_v2($value = '')
    {
        $srh_warehouse_id   = $this->input->post('srh_warehouse_id');
        $cat_srh            = $this->input->post('cat_srh');
        $commision_val      = $this->input->post('commision');
        $commision_val_srch = $this->input->post('commision');
        $show_all           = $this->input->post('show_all');
        $srh_user_id        = $this->input->post('srh_user_id');
        $srh_from_date      = '';
        $srh_to_date        = '';
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d H:i:s', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d H:i:s', strtotime($this->input->post('srh_from_date')));
        }
        $this->load->model('Product_Models');
        $cat_des           = $this->category_models->get_category_by_name();
        $data              = array();
        $grand_total       = 0;
        $def_grand_tot     = 0;
        $def_val_grand_tot = 0;
        $all_cakes_total   = 0;
        foreach ($cat_des as $cat_row) {
            $cat_srh     = $cat_row->cat_id;
            $values      = $this->Product_Models->getProductsForReport($srh_warehouse_id, $cat_srh);
            $cat_total   = 0;
            $net_def     = 0;
            $net_def_val = 0;
            if (!empty($values)) {
                foreach ($values as $products) {
                    if ($products->product_status == 0) {
                        $k = "btn-warning";
                        $m = "fa-minus-circle";
                    } else {
                        $k = "btn-green";
                        $m = "fa-check";
                    }
                    $retVal                   = (empty($products->sub_cat_name)) ? "--:--" : $products->sub_cat_name;
                    $row                      = array();
                    $transferd_qty            = 0;
                    $transfer_reseve_qty      = 0;
                    $selected_extra_menu_list = $this->Product_Models->get_booking_selected_menu_items_by_type($products->product_id, '', 'Extra');
                    $product_cost_cal         = 0;
                    if (isset($selected_extra_menu_list)) {
                        foreach ($selected_extra_menu_list as $row_itm) {
                            $item_dtls        = $this->Menu_Items_List_Model->get_item_info($row_itm->item_id);
                            $item_price_1     = $item_dtls['item_price_1'];
                            $bkng_itm_qty     = $row_itm->bkng_itm_qty;
                            $amount_this      = 0;
                            $amount_this      = $bkng_itm_qty * $item_price_1;
                            $product_cost_cal = $product_cost_cal + $amount_this;
                        }
                    }
                    $each_product_cost = 0;
                    if ($products->product_oem_part_number) {
                        $each_product_cost = $product_cost_cal / $products->product_oem_part_number;
                        $each_product_cost = number_format($each_product_cost, 2, '.', '');
                    }
                    $switch = '';
                    if ($each_product_cost > 0) {
                    } else {
                        if ($products->product_cost > 0) {
                            $each_product_cost = $products->product_cost;
                            $switch            = 1;
                        } else {
                            if ($products->product_price > 0) {
                                $each_product_cost = $products->product_price;
                                $switch            = 2;
                            } else {
                                $each_product_cost = 0;
                                $switch            = 3;
                            }
                        }
                    }
                    $location_id                 = 0;
                    $product_id                  = $products->product_id;
                    $warehouse_opening_stock     = 0;
                    $os_reject                   = 0;
                    $reject                      = 0;
                    $tra_out                     = 0;
                    $tra_in                      = 0;
                    $os_tra_out                  = 0;
                    $os_tra_in                   = 0;
                    $day_before                  = date('Y-m-d H:i:s', strtotime($srh_from_date . ' -1 day'));
                    $day_next                    = date('Y-m-d', strtotime($srh_from_date . ' +1 day'));
                    $opening_stock_date          = $day_before;
                    $opening_stock_qty           = 0;
                    $opening_stock_from_date     = '2019-10-23';
                    $date_1                      = date('Y-m-d', strtotime($opening_stock_from_date . ' +1 day'));
                    $os_i                        = 0;
                    $os_grn                      = 0;
                    $os_grn_rtn                  = 0;
                    $os_tra_out                  = 0;
                    $os_tra_in                   = $this->Transfer_Model->getTransferResevedQtyByWarehouseId($srh_warehouse_id, $products->product_id, $date_1, $day_before);
                    $os_reject                   = $this->Product_Damage_Model->getProductDamagedQtyByWarehouseId($srh_warehouse_id, $products->product_id, $date_1, $day_before);
                    $os_grn                      = 0;
                    $os_grn_rtn                  = 0;
                    $os_ir                       = 0;
                    $os_s                        = 0;
                    $os_h                        = 0;
                    $os_st_adj                   = 0;
                    $os_st_adj                   = 0;
                    $os_ser_issue                = 0;
                    $os_ser_issue_rtn            = 0;
                    $os_exchange_qty             = 0;
                    $os_exchange_qty             = intval($os_exchange_qty);
                    $test_var                    = '';
                    $opening_stock_qty_des       = "";
                    $opening_stock_qty_des       = 0;
                    $opening_stock_qty           = 0;
                    $warehouse_opening_stock_tot = 0;
                    $warehouse_opening_stock_tot = $warehouse_opening_stock + $os_grn - $os_grn_rtn - $os_i + $os_ir - $os_s - $os_h - $os_ser_issue + $os_ser_issue_rtn + $os_exchange_qty - $os_st_adj - $os_reject - $os_tra_out + $os_tra_in;
                    $purchased_qty               = $this->Purchases_Model->getPurchasedQtyByWarehouseId_3($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                    $p_returned_qty              = $this->Purchases_Model->getReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                    $sold_qty                    = $this->Sales_Model->getSoldQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date, $srh_user_id);
                    $sales_return_qty            = $this->Sales_Return_Model->getSalesReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                    $tra_out                     = $this->Transfer_Model->getTransferdQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                    $tra_in                      = $this->Transfer_Model->getTransferResevedQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                    $reject                      = $this->Product_Damage_Model->getProductDamagedQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                    $warehouse_opening_stock_tot = 0;
                    $warehouse_opening_stock_tot = intval($this->Purchases_Model->getPurchasedQtyByWarehouseId_2($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date, 5));
                    $next_day_openning_balance   = 0;
                    $next_day_openning_balance   = intval($this->Purchases_Model->getPurchasedQtyByWarehouseId_2($srh_warehouse_id, $products->product_id, $day_next, $day_next, 5));
                    ;
                    $product_balance    = 0;
                    $product_balance    = $warehouse_opening_stock_tot + $purchased_qty + $sales_return_qty - $sold_qty - $p_returned_qty - $reject - $tra_out + $tra_in;
                    $cost_price_sub_tot = $each_product_cost * $purchased_qty;
                    $product_price      = $products->product_price;
                    $sale_price_sub_tot = $product_price * $sold_qty;
                    $open               = '';
                    $close              = '';
                    $test               = $commision_val_srch;
                    $commision_val      = floatval($commision_val_srch);
                    if ($commision_val > 0) {
                    } else {
                        $commision_val = floatval($products->product_commision);
                    }
                    if ($products->product_commision > 0) {
                        $open  = '<label class="btn btn-warning">';
                        $close = '</label>';
                    }
                    $commision   = ($commision_val * $sale_price_sub_tot) / 100;
                    $row[]       = $products->product_name;
                    $row[]       = $products->cat_name;
                    $row[]       = $warehouse_opening_stock_tot;
                    $row[]       = number_format($purchased_qty, 2, '.', '');
                    $row[]       = number_format($p_returned_qty, 2, '.', '');
                    $row[]       = number_format($sold_qty, 2, '.', '');
                    $row[]       = number_format($reject, 2, '.', '');
                    $row[]       = number_format($tra_out, 2, '.', '');
                    $row[]       = number_format($tra_in, 2, '.', '');
                    $row[]       = number_format($product_balance, 2, '.', '');
                    $row[]       = $next_day_openning_balance;
                    $row[]       = 0;
                    $row[]       = number_format($sale_price_sub_tot, 2, '.', '');
                    $def         = $next_day_openning_balance - $product_balance;
                    $row[]       = $def;
                    $row[]       = $def * $product_price;
                    $net_def     = $net_def + $def;
                    $net_def_val = $net_def_val + ($def * $product_price);
                    $display     = 0;
                    if ($show_all == 'true') {
                        $display = 1;
                    } else if ($sold_qty != '') {
                        $display = 1;
                    }
                    if ($display) {
                        $data[] = $row;
                    }
                    $cat_total   = $cat_total + $sale_price_sub_tot;
                    $grand_total = $grand_total + $sale_price_sub_tot;
                }
            }
            if ($cat_total) {
                $row    = array();
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = "<b>" . $products->cat_name . " Tot Sale Val</b>";
                $row[]  = "<b>" . number_format($cat_total, 2, '.', '') . "</b>";
                $row[]  = '';
                $row[]  = '';
                $data[] = $row;
            }
            if ($cat_srh == 5 || $cat_srh == 8 || $cat_srh == 9) {
                $all_cakes_total = $all_cakes_total + $cat_total;
            }
            if ($cat_srh == 9) {
                $row    = array();
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = "<b>" . " All Cakes Sale Val</b>";
                $row[]  = "<b>" . number_format($all_cakes_total, 2, '.', '') . "</b>";
                $row[]  = '';
                $row[]  = '';
                $data[] = $row;
            }
        } {
            $row   = array();
            $row[] = '';
            $row[] = '';
            $row[] = '';
            $row[] = '';
            $row[] = '';
            $row[] = '';
            $row[] = '';
            $row[] = '';
            $row[] = '';
            $row[] = '';
            $row[] = '';
            $row[] = "<b> Grand Total </b>";
            $row[] = "<b>" . number_format($grand_total, 2, '.', '') . "</b>";
            $row[] = "<b>" . number_format($net_def, 2, '.', '') . "</b>";
            ;
            $row[] = "<b>" . number_format($net_def_val, 2, '.', '') . "</b>";
            ;
            $data[] = $row;
        }
        $output = array(
            'data' => $data
        );
        echo json_encode($output);
    }
    public function get_list_product_for_print($value = '')
    {
        $srh_warehouse_id   = $this->input->post('srh_warehouse_id');
        $cat_srh            = $this->input->post('cat_srh');
        $commision_val      = $this->input->post('commision');
        $commision_val_srch = $this->input->post('commision');
        $show_all           = $this->input->post('show_all');
        $srh_user_id        = $this->input->post('srh_user_id');
        $srh_from_date      = date('Y-m-d', strtotime($this->input->post('srh_from_date')));
        $srh_to_date        = date('Y-m-d', strtotime($this->input->post('srh_to_date')));
        $open_srh_to_date        = date('Y-m-d', strtotime($this->input->post('srh_from_date'). ' -1 day'));
        
        $this->load->model('Product_Models');
        $data            = array();
        $grand_total     = 0;
        $all_cakes_total = 0;
        $p_returned_qty=0;
        $values    = $this->Product_Models->getProductsForProductReport($cat_srh);
        $cat_total = 0;
        if (!empty($values)) {
            foreach ($values as $products) {
                $row                      = array();
                $each_product_cost=$products->product_cost;
                $retVal                   = (empty($products->sub_cat_name)) ? "--:--" : $products->sub_cat_name;
                
                $pur_f_open_balance=$this->Purchases_Model->getPurchasedQtyByWarehouseId($srh_warehouse_id, $products->product_id, '', $open_srh_to_date);
                $sold_f_open_balance=$this->Sales_Model->getSoldQtyByWarehouseId($srh_warehouse_id, $products->product_id, '', $open_srh_to_date, '');
                 $damage_open_balance= $this->Report_Model->getDamageQtyByWarehouseId($srh_warehouse_id, $products->product_id, '', $open_srh_to_date);
                $open_stock=($pur_f_open_balance-($sold_f_open_balance+$damage_open_balance));
                $purchased_qty      = $this->Purchases_Model->getPurchasedQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                $sold_qty           = $this->Sales_Model->getSoldQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date, $srh_user_id);
                $damage_qty      = $this->Report_Model->getDamageQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date,1);
                $staff_qty      = $this->Report_Model->getDamageQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date,2);
                $adj_qty      = $this->Report_Model->getDamageQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date,3);
                $sales_return_qty   = 0;
                $product_balance    = 0;
                $product_balance    = ($purchased_qty+$open_stock) - ($sold_qty+$damage_qty+$staff_qty+$adj_qty)  ;
                $cost_price_sub_tot = $each_product_cost * $purchased_qty;
                $product_price      = $products->product_price;
                $sale_price_sub_tot = $product_price * $sold_qty;
                $damage_value_tot   = ($damage_qty)*$product_price;
                $staff_meal_val=($staff_qty)*$product_price;
                $adj_val=$adj_qty*$product_price;
                $row[]     = $products->product_code;
                $row[]     = $products->product_name;
                $row[]     = $products->cat_name;
                
                $row[]     = number_format($open_stock, 2, '.', '');
                $row[]     = number_format($purchased_qty, 2, '.', '');
                $row[]     = number_format($sold_qty, 2, '.', '');
                $row[]     = number_format($damage_qty, 2, '.', '');
                $row[]     = number_format($staff_qty, 2, '.', '');
                $row[]     = number_format($adj_qty, 2, '.', '');
                $row[]     = number_format($product_balance, 2, '.', '');
                $row[]     = number_format($cost_price_sub_tot, 2, '.', '');
                $row[]     = number_format($sale_price_sub_tot, 2, '.', '');
                $row[]     = number_format($damage_value_tot, 2, '.', '');
                $row[]     = number_format($staff_meal_val, 2, '.', '');
                $row[]     = number_format($adj_val, 2, '.', '');
                $row[]     = number_format($product_balance*$product_price, 2, '.', '');
                $data[]=$row;
       
            }
        }
        $output = array(
            'data' => $data
        );
        echo json_encode($output);
    }
    public function get_list_product_qty_for_print($value = '')
    {
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $cat_srh          = $this->input->post('cat_srh');
        $this->load->model('Product_Models');
        $values = $this->Product_Models->getProductsForQTYReport($srh_warehouse_id, $cat_srh);
        $data   = array();
        if (!empty($values)) {
            foreach ($values as $products) {
                if ($products->product_status == 0) {
                    $k = "btn-warning";
                    $m = "fa-minus-circle";
                } else {
                    $k = "btn-green";
                    $m = "fa-check";
                }
                $retVal              = (empty($products->sub_cat_name)) ? "--:--" : $products->sub_cat_name;
                $row                 = array();
                $transferd_qty       = 0;
                $transfer_reseve_qty = 0;
                $transferd_qty       = $this->Transfer_Model->getTransferdQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $transfer_reseve_qty = $this->Transfer_Model->getTransferResevedQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $sold_qty            = $this->Sales_Model->getSoldQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $purchased_qty       = $this->Purchases_Model->getPurchasedQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $product_damaged_qty = $this->Product_Damage_Model->getProductDamagedQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $sales_return_qty    = $this->Sales_Return_Model->getSalesReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $row[]               = $products->product_code;
                $row[]               = $products->product_name;
                $row[]               = $products->cat_name;
                $row[]               = $products->sub_cat_name;
                $tmp_qty             = $purchased_qty + $transfer_reseve_qty + $sales_return_qty - $sold_qty - $transferd_qty - $product_damaged_qty;
                $row[]               = number_format(($products->product_cost), 2, '.', '');
                $row[]               = number_format(($products->product_price), 2, '.', '');
                $row[]               = number_format($tmp_qty, 2, '.', '');
                $row[]               = number_format(($products->product_cost * $tmp_qty), 2, '.', '');
                $row[]               = number_format(($products->product_price * $tmp_qty), 2, '.', '');
                $data[]              = $row;
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
    public function get_list_product_alert_quantity_for_print($value = '')
    {
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $cat_srh          = $this->input->post('cat_srh');
        $this->load->model('Product_Models');
        $values = $this->Product_Models->getProductsForReport($srh_warehouse_id, $cat_srh);
        $data   = array();
        if (!empty($values)) {
            foreach ($values as $products) {
                if ($products->product_status == 0) {
                    $k = "btn-warning";
                    $m = "fa-minus-circle";
                } else {
                    $k = "btn-green";
                    $m = "fa-check";
                }
                $retVal              = (empty($products->sub_cat_name)) ? "--:--" : $products->sub_cat_name;
                $transferd_qty       = 0;
                $transfer_reseve_qty = 0;
                $transferd_qty       = $this->Transfer_Model->getTransferdQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $transfer_reseve_qty = $this->Transfer_Model->getTransferResevedQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $sold_qty            = $this->Sales_Model->getSoldQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $purchased_qty       = $this->Purchases_Model->getPurchasedQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $product_damaged_qty = $this->Product_Damage_Model->getProductDamagedQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $sales_return_qty    = $this->Sales_Return_Model->getSalesReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $row                 = array();
                $balance_qty         = $purchased_qty + $transfer_reseve_qty + $sales_return_qty - $sold_qty - $transferd_qty - $product_damaged_qty;
                if ($balance_qty <= $products->product_alert_qty) {
                    $row[]  = $products->product_code;
                    $row[]  = $products->product_name;
                    $row[]  = $products->product_part_no;
                    $row[]  = $products->cat_name;
                    $row[]  = $products->sub_cat_name;
                    $row[]  = $products->product_alert_qty;
                    $row[]  = $products->product_max_qty;
                    $row[]  = number_format(($balance_qty), 2, '.', ',');
                    $data[] = $row;
                }
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
    public function get_list_menuitem_for_print($value = '')
    {
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $cat_srh          = $this->input->post('cat_srh');
        $srh_from_date    = '';
        $srh_to_date      = '';
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }
        $this->load->model('Product_Models');
        $values = $this->Menu_Items_List_Model->getMenuitemsForReport($srh_warehouse_id, $cat_srh);
        $data   = array();
        if (!empty($values)) {
            foreach ($values as $product) {
                $quantity = $this->Menu_Items_List_Model->get_item($product->item_code);
                if ($product->item_status == 1) {
                    $k = "btn-warning";
                    $m = "fa-minus-circle";
                } else {
                    $k = "btn-green";
                    $m = "fa-check";
                }
                $row    = array();
                $row[]  = $product->item_code;
                $row[]  = $product->item_name;
                $row[]  = $product->item_name_sin;
                $row[]  = $product->item_name_sin;
                $row[]  = $product->item_name_sin;
                $row[]  = $quantity['quantity'];
                $row[]  = $product->item_name_sin;
                $row[]  = $product->item_name_sin;
                $row[]  = $product->item_name_sin;
                $row[]  = $product->item_price_1;
                $row[]  = $product->item_cost;
                $row[]  = $product->item_cost;
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
    public function menu_available_item()
    {
        $this->load->model('Product_Models');
        $this->load->model('category_models');
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['product_list']   = $this->Product_Models->getProducts();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'menuavailable';
        $data['category_list']  = $this->category_models->getCategory();
        $this->load->view('rep_available_menuitems', $data);
    }
    public function get_list_availablemenuitem_for_print($value = '')
    {
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $cat_srh          = $this->input->post('cat_srh');
        $srh_from_date    = '';
        $srh_to_date      = '';
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }
        $this->load->model('Product_Models');
        $values = $this->Menu_Items_List_Model->getMenuitemsForReport($srh_warehouse_id, $cat_srh);
        $data   = array();
        if (!empty($values)) {
            foreach ($values as $product) {
                $quantity = $this->Menu_Items_List_Model->get_item($product->item_code);
                if ($product->item_status == 1) {
                    $k = "btn-warning";
                    $m = "fa-minus-circle";
                } else {
                    $k = "btn-green";
                    $m = "fa-check";
                }
                $row    = array();
                $cost   = $quantity['quantity'] * $product->item_price_1;
                $row[]  = $product->item_code;
                $row[]  = $product->item_name;
                $row[]  = $product->item_name_sin;
                $row[]  = $product->item_name_sin;
                $row[]  = $product->item_name_sin;
                $row[]  = $quantity['quantity'];
                $row[]  = $product->item_name_sin;
                $row[]  = $product->item_name_sin;
                $row[]  = $product->item_name_sin;
                $row[]  = $product->item_price_1;
                $row[]  = $cost;
                $row[]  = $cost;
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
    public function customer()
    {
        $data['main_menu_name']    = $this->main_menu_name;
        $data['sub_menu_name']     = 'rep_customer';
        $data['warehouse_list']    = $this->Warehouse_Model->get_all_warehouse();
        $data['customer_list']     = $this->Customer_Model->get_all_customers();
        $data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info(1);
        $this->load->view('rep_customers', $data);
    }
    function category_summary()
    {
        $data['main_menu_name']    = $this->main_menu_name;
        $data['sub_menu_name']     = 'cat_sum';
        $data['warehouse_list']    = $this->Warehouse_Model->get_all_warehouse();
        $data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info(1);
        $this->load->model('category_models');
        $data['category_list'] = $this->category_models->getCategory();
        $this->load->view('rep_cat_summary', $data);
    }
    function products_by_category()
    {
        $srh_warehouse_id   = $this->input->post('srh_warehouse_id');
        $cat_srh            = $this->input->post('cat_srh');
        $commision_val      = $this->input->post('commision');
        $commision_val_srch = $this->input->post('commision');
        $srh_from_date      = '';
        $srh_to_date        = '';
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }
        $this->load->model('Product_Models');
        $values = $this->Product_Models->getProductsForReport($srh_warehouse_id, $cat_srh);
        $data   = array();
        if (!empty($values)) {
            foreach ($values as $products) {
                if ($products->product_status == 0) {
                    $k = "btn-warning";
                    $m = "fa-minus-circle";
                } else {
                    $k = "btn-green";
                    $m = "fa-check";
                }
                $retVal                   = (empty($products->sub_cat_name)) ? "--:--" : $products->sub_cat_name;
                $row                      = array();
                $transferd_qty            = 0;
                $transfer_reseve_qty      = 0;
                $selected_extra_menu_list = $this->Product_Models->get_booking_selected_menu_items_by_type($products->product_id, '', 'Extra');
                $product_cost_cal         = 0;
                if (isset($selected_extra_menu_list)) {
                    foreach ($selected_extra_menu_list as $row_itm) {
                        $item_dtls        = $this->Menu_Items_List_Model->get_item_info($row_itm->item_id);
                        $item_price_1     = $item_dtls['item_price_1'];
                        $bkng_itm_qty     = $row_itm->bkng_itm_qty;
                        $amount_this      = 0;
                        $amount_this      = $bkng_itm_qty * $item_price_1;
                        $product_cost_cal = $product_cost_cal + $amount_this;
                    }
                }
                $each_product_cost = 0;
                if ($products->product_oem_part_number) {
                    $each_product_cost = $product_cost_cal / $products->product_oem_part_number;
                    $each_product_cost = number_format($each_product_cost, 2, '.', '');
                }
                $switch = '';
                if ($each_product_cost > 0) {
                } else {
                    if ($products->product_cost > 0) {
                        $each_product_cost = $products->product_cost;
                        $switch            = 1;
                    } else {
                        if ($products->product_price > 0) {
                            $each_product_cost = $products->product_price;
                            $switch            = 2;
                        } else {
                            $each_product_cost = 0;
                            $switch            = 3;
                        }
                    }
                }
                $purchased_qty      = $this->Purchases_Model->getPurchasedQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                $p_returned_qty     = $this->Purchases_Model->getReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                $sales              = $this->Sales_Model->get_sold_qty_and_amount($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                $sold_qty           = $sales->quantity;
                $sale_amount        = $sales->sale_total;
                $total_sales_amount = $this->Sales_Model->get_total_sales($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                $sale_p             = ($sale_amount / $total_sales_amount) * 100;
                $cost_price_sub_tot = $each_product_cost * $sold_qty;
                $product_price      = $products->product_price;
                $sale_price_sub_tot = $product_price * $sold_qty;
                $open               = '';
                $close              = '';
                $test               = $commision_val_srch;
                $commision_val      = floatval($commision_val_srch);
                if ($commision_val > 0) {
                } else {
                    $commision_val = floatval($products->product_commision);
                }
                if ($products->product_commision > 0) {
                    $open  = '<label class="btn btn-warning">';
                    $close = '</label>';
                }
                $commision = ($commision_val * $sale_price_sub_tot) / 100;
                $row[]     = $products->product_name;
                $row[]     = $open . $products->product_code . $close;
                $row[]     = number_format($sold_qty, 2, '.', '');
                $row[]     = number_format($sale_amount, 2, '.', '');
                $row[]     = number_format($sale_p, 2, '.', '') . '%';
                $row[]     = number_format($cost_price_sub_tot, 2, '.', '');
                $row[]     = number_format($sale_amount - $cost_price_sub_tot, 2, '.', '');
                if ($cost_price_sub_tot > 0)
                    $row[] = number_format((($sale_amount - $cost_price_sub_tot) / $cost_price_sub_tot) * 100, 2, '.', '') . '%';
                else
                    $row[] = '0%';
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
    /*custom*/
    function get_list_product_for_report_sakura($value = '')
    {
        $srh_warehouse_id   = $this->input->post('srh_warehouse_id');
        $cat_srh            = $this->input->post('cat_srh');
        $commision_val      = $this->input->post('commision');
        $commision_val_srch = $this->input->post('commision');
        $show_all           = $this->input->post('show_all');
        $srh_user_id        = $this->input->post('srh_user_id');
        $srh_from_date      = '';
        $srh_to_date        = '';
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d H:i:s', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d H:i:s', strtotime($this->input->post('srh_from_date')));
        }
        $this->load->model('Product_Models');
        $cat_des         = $this->category_models->get_category_by_name();
        $data            = array();
        $grand_total     = 0;
        $all_cakes_total = 0;
        foreach ($cat_des as $cat_row) {
            $cat_srh   = $cat_row->cat_id;
            $values    = $this->Product_Models->getProductsForReport($srh_warehouse_id, $cat_srh);
            $cat_total = 0;
            if (!empty($values)) {
                foreach ($values as $products) {
                    if ($products->product_status == 0) {
                        $k = "btn-warning";
                        $m = "fa-minus-circle";
                    } else {
                        $k = "btn-green";
                        $m = "fa-check";
                    }
                    $retVal                   = (empty($products->sub_cat_name)) ? "--:--" : $products->sub_cat_name;
                    $row                      = array();
                    $transferd_qty            = 0;
                    $transfer_reseve_qty      = 0;
                    $selected_extra_menu_list = $this->Product_Models->get_booking_selected_menu_items_by_type($products->product_id, '', 'Extra');
                    $product_cost_cal         = 0;
                    if (isset($selected_extra_menu_list)) {
                        foreach ($selected_extra_menu_list as $row_itm) {
                            $item_dtls        = $this->Menu_Items_List_Model->get_item_info($row_itm->item_id);
                            $item_price_1     = $item_dtls['item_price_1'];
                            $bkng_itm_qty     = $row_itm->bkng_itm_qty;
                            $amount_this      = 0;
                            $amount_this      = $bkng_itm_qty * $item_price_1;
                            $product_cost_cal = $product_cost_cal + $amount_this;
                        }
                    }
                    $each_product_cost = 0;
                    if ($products->product_oem_part_number) {
                        $each_product_cost = $product_cost_cal / $products->product_oem_part_number;
                        $each_product_cost = number_format($each_product_cost, 2, '.', '');
                    }
                    $switch = '';
                    if ($each_product_cost > 0) {
                    } else {
                        if ($products->product_cost > 0) {
                            $each_product_cost = $products->product_cost;
                            $switch            = 1;
                        } else {
                            if ($products->product_price > 0) {
                                $each_product_cost = $products->product_price;
                                $switch            = 2;
                            } else {
                                $each_product_cost = 0;
                                $switch            = 3;
                            }
                        }
                    }
                    $purchased_qty      = 0;//$this->Purchases_Model->getPurchasedQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                    $p_returned_qty     = 0;//$this->Purchases_Model->getReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                    $sold_qty           = $this->Sales_Model->getSoldQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date, $srh_user_id);
                    $sales_return_qty   = 0;//$this->Sales_Return_Model->getSalesReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                    $product_balance    = 0;
                    $product_balance    = $purchased_qty + $sales_return_qty - $sold_qty - $p_returned_qty;
                    $cost_price_sub_tot = $each_product_cost * $purchased_qty;
                    $product_price      = $products->product_price;
                    $sale_price_sub_tot = $product_price * $sold_qty;
                    $open               = '';
                    $close              = '';
                    $test               = $commision_val_srch;
                    $commision_val      = floatval($commision_val_srch);
                    if ($commision_val > 0) {
                    } else {
                        $commision_val = floatval($products->product_commision);
                    }
                    if ($products->product_commision > 0) {
                        $open  = '<label class="btn btn-warning">';
                        $close = '</label>';
                    }
                    $commision = ($commision_val * $sale_price_sub_tot) / 100;
                    $row[]     = $products->product_name;
                    $row[]     = $products->cat_name;
                    // $row[]     = number_format($purchased_qty, 2, '.', '');
                    // $row[]     = number_format($p_returned_qty, 2, '.', '');
                    $row[]     = number_format($sold_qty, 2, '.', '');
                    // $row[]     = number_format($sales_return_qty, 2, '.', '');
                    // $row[]     = number_format($product_balance, 2, '.', '');
                    // $row[]     = number_format($cost_price_sub_tot, 2, '.', '');
                    $row[]     = number_format($sale_price_sub_tot, 2, '.', '');
                    // $row[]     = number_format($sale_price_sub_tot - $commision, 2, '.', '');
                    $display   = 0;
                    if ($show_all == 'true') {
                        $display = 1;
                    } else if ($sold_qty != '') {
                        $display = 1;
                    }
                    if ($display) {
                        $data[] = $row;
                    }
                    $cat_total   = $cat_total + $sale_price_sub_tot;
                    $grand_total = $grand_total + $sale_price_sub_tot;
                }
            }
           // $cat_total=5;
            if ($cat_total) {
                $row    = array();
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = "<b>" . $products->cat_name . " Total Sale Value</b>";
                $row[]  = "<b>" . number_format($cat_total, 2, '.', '') . "</b>";
                $data[] = $row;
                
                
            }
            if ($cat_srh == 5 || $cat_srh == 8 || $cat_srh == 9) {
                $all_cakes_total = $all_cakes_total + $cat_total;
            }
            if ($cat_srh == 9) {
                $row    = array();
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = '';
                $row[]  = "<b>" . " All Cakes Sale Value</b>";
                $row[]  = "<b>" . number_format($all_cakes_total, 2, '.', '') . "</b>";
                $data[] = $row;
            }
        }
        
       // $grand_total=5555555555;
        if ($grand_total) {
            $row    = array();
            $row[]  = '';
            $row[]  = '';
            $row[]  = '';
            $row[]  = '';
            $row[]  = '';
            $row[]  = '';
            $row[]  = '';
            $row[]  = "<b> Grand Total </b>";
            $row[]  = "<b>" . number_format($grand_total, 2, '.', '') . "</b>";
            $data[] = $row;
        }
        
       // print_r( $data); die();//
        
        $output = array(
            'data' => $data
        );
        echo json_encode($output);
    }
    function service_charge(){
        $this->load->model('reports_model');
        $from = $this->input->get('from');
        $to   = $this->input->get('to');
        $total= 0;
        $amount_10p = 0;
        $amount_10b = 0;
        if($from != '' && $to != ''){
            $sale_items = $this->reports_model->svc_sale_items($from,$to);
            if(!empty($sale_items)){
                foreach($sale_items as $sale_item){
                    $product_info = $this->reports_model->svc_get_product_by_id($sale_item->product_id);
                    if($product_info->cat_id == 46 || $product_info->cat_id == 47)
                        continue;
                    if($sale_item->gross_total > 0){
                        $total += $sale_item->gross_total;
                    }
                }
            }
        }
        if($total > 0){
            $amount_10p = $total/100*10;
            $amount_10b = $amount_10p/100*10;
        }
        $data['main_menu_name']    = $this->main_menu_name;
        $data['sub_menu_name']     = 'service_charges';
        $data['warehouse_list']    = $this->Warehouse_Model->get_all_warehouse();
        $data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info(1);
        $data['from'] = $from;
        $data['to']   = $to;
        $data['total']= $total;
        $data['amount_10p']= $amount_10p;
        $data['amount_10b']= $amount_10b;
        $this->load->view('rep_svc_charges',$data);
    }
    
     public function cashier_summary_list()
    {
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['main_menu_name'] = 'reports';
        $data['sub_menu_name']  = 'cashier_summary_list';
        $this->load->view('retail_reports/cashier_summary_list', $data);
    }
    
     function get_cashier_summary_list()
	{	
	    $this->load->model('Reports_Model');
	$requestData= $_REQUEST;	
	$start=$this->input->get('start');
	$length=$this->input->get('length');
	$search=$this->input->get('search');	
	$direct_sale=$this->input->get('direct_sale');	
	$data = array();	
	$totalData = 1000;//$this->pos_model->get_all_sales("","",$search,$direct_sale);
	$sales = $this->Reports_Model->get_all_cashier_summery_list($start,$length,$search);
	$totalFiltered = $totalData; 	
	foreach ($sales as $row){
		$nestedData=array(); 
		$id=$row['c_float_mstr_id'];
		$nestedData[] =$row['c_f_m_date_time'];
		$nestedData[] =$row['ref_no'];
		$nestedData[] = $row['user_first_name']."  ".$row['user_last_name'];
		$nestedData[] = $row['name'];
		if($row['float_status']==1){
		   $pay_st='<span class="label label-warning">Active</span>'; 
		}else{
		    $pay_st='<span class="label label-success">Closed</span>';
		}
		$nestedData[]=$pay_st;	
		$nestedData[] = $row['float_details'];
		$nestedData[] = '<div class="btn-group text-left">
                            <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu pull-right">
                            <li><a target="_blank" href="'.base_url().'cash_balance/chashier_float_summay?id='.$id.'"><i class="fa fa-file-text-o"></i> Float Details</a></li>
                            <li><a target="_blank" href="'.base_url().'cash_balance/chashier_float_summay_new?id='.$id.'"><i class="fa fa-file-text-o"></i> Float Details New</a></li>
                            <li><a target="_blank" href="' . base_url() . 'cash_balance/chashier_float_sale_statment?id=' . $id . '"><i class="fa fa-file-text-o"></i> Sale Statment</a></li>
                            </ul></div>'; 
		
	
		$data[] = $nestedData;
	}

	$json_data = array(
			//"draw"            => intval( $requestData['draw'] ),  
			"recordsTotal"    => intval( $totalData ),  
			"recordsFiltered" => intval( $totalFiltered ),
			"data"            => $data 
			);

	echo json_encode($json_data); 
	}
	
	
	public function row_material()
    {
        $this->load->model('Product_Models');
        $this->load->model('category_models');
        $data['warehouse_list']    = $this->Warehouse_Model->get_all_warehouse();
        $data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info(1);
        $data['product_list']      = $this->Product_Models->getProducts();
        $data['main_menu_name']    = 'finance';
        $data['sub_menu_name']     = 'row_material';
        $data['category_list']     = $this->category_models->getCategory();
        $data['user_list']         = $this->User_Model->getUsers();
        $this->load->view('rep_row_material', $data);
    }
    
    public function get_list_row_material($value = '')
    {
        $srh_warehouse_id   = $this->input->post('srh_warehouse_id');
        $cat_srh            = $this->input->post('cat_srh');
        $commision_val      = $this->input->post('commision');
        $commision_val_srch = $this->input->post('commision');
        $show_all           = $this->input->post('show_all');
        $srh_user_id        = $this->input->post('srh_user_id');
        $srh_from_date      = date('Y-m-d', strtotime($this->input->post('srh_from_date')));
        $srh_to_date        = date('Y-m-d', strtotime($this->input->post('srh_to_date')));
        $open_srh_to_date        = date('Y-m-d', strtotime($this->input->post('srh_from_date'). ' -1 day'));
        
        $this->load->model('Product_Models');
        $data            = array();
        $grand_total     = 0;
        $all_cakes_total = 0;
        $p_returned_qty=0;
        $values    = $this->Product_Models->getRowMaterialForProductReport($cat_srh);
        $cat_total = 0;
        if (!empty($values)) {
            foreach ($values as $products) {
                $row                      = array();
                $each_product_cost=$products->item_cost;
                $retVal                   = (empty($products->sub_cat_name)) ? "--:--" : $products->sub_cat_name;
                
                $pur_f_open_balance=$this->Report_Model->getPurchasedRWQtyByWarehouseId($srh_warehouse_id, $products->item_id, '', $open_srh_to_date);
                $damage_open_balance= $this->Report_Model->getStockAdjRWQtyByWarehouseId($srh_warehouse_id, $products->item_id, '', $open_srh_to_date);
                
                
                $open_stock=($pur_f_open_balance-($damage_open_balance));
                $purchased_qty      = $this->Report_Model->getPurchasedRWQtyByWarehouseId($srh_warehouse_id, $products->item_id, $srh_from_date, $srh_to_date);
                $damage_qty      = $this->Report_Model->getStockAdjRWQtyByWarehouseId($srh_warehouse_id, $products->item_id, $srh_from_date, $srh_to_date);
                $product_balance    = 0;
                $product_balance    = ($purchased_qty+$open_stock) - ($damage_qty)  ;
                $cost_price_sub_tot = $each_product_cost * $purchased_qty;
                $product_price      = $products->item_price_1;
                $damage_value_tot   = ($damage_qty)*$product_price;
                $row[]     = $products->item_name;
                $row[]     = $products->cat_name;
                
                $row[]     = number_format($open_stock, 2, '.', '');
                $row[]     = number_format($purchased_qty, 2, '.', '');
                $row[]     = number_format($damage_qty, 2, '.', '');
                $row[]     = number_format($product_balance, 2, '.', '');
                $row[]     = number_format($cost_price_sub_tot, 2, '.', '');
                $row[]     = number_format($damage_value_tot, 2, '.', '');
                $row[]     = number_format($product_balance*$product_price, 2, '.', '');
                $data[]=$row;
       
            }
        }
          $output = array(
            'data' => $data
        );
        echo json_encode($output);
	
    }
    
    public function invoices()
    {
        $customer_id = $this->input->get('cus');
        $this->load->model('User_Model');
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'invoices';
        $data['customer_type']  = $this->input->get('ct') ? $this->input->get('ct') : 2; 
        $data['customers_except']  = $this->input->get('ce') ? explode(',', $this->input->get('ce')) : array();
        $data['customer_list']  = $this->get_customers($data['customer_type']);
        $data['location_id']  = $this->input->get('li') ? $this->input->get('li') : $this->session->userdata('ss_warehouse_id');
        $data['month']  = $this->input->get('mo') ? $this->input->get('mo') : date("m"); 
        $data['sales']          = array(); //$this->Sales_Model->get_all_sales();
        $data['user_list']      = $this->User_Model->getUsers();
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['resp_customer_list']  = $this->get_customers($data['customer_type'],$data['customers_except'],$customer_id);
        /*$data['sales_list']     = $this->get_credit_sale_by_cus_id($customer_id,$data['location_id'], $data['month'],$data['customer_type'],$data['customers_except']);*/
        $data['sales_list']  = array();
        
        $data['customer_id']    = $customer_id;
        foreach($data['resp_customer_list'] as $key => $cus){
            
            $dt = $this->get_cus_invoice_info($cus['cus_id'],$data['location_id'], $data['month']);
           /* echo "<pre>";
            echo $cus['cus_id'];
            echo $cus['cus_name'];
            print_r($dt);
            print_r($cus);
            echo "</pre>";*/
            
            $data['resp_customer_list'][$key]['sale_total'] = $dt->sale_total;
            $data['resp_customer_list'][$key]['total_paid']= $dt->total_paid;
            
        }
       /* echo "<pre>";
        print_r($data['resp_customer_list']);
        echo "</pre>";*/
        /*
        exit;*/
        //print_r($data['resp_customer_list']);
        
        $this->load->view('rep_invoices', $data);
    }
    function get_cus_invoice_info($customer_id, $warehouse_id, $month)
    {
        // Extracting the current year
        $currentYear = date('Y');
        
        // Adjusting the month value if it's less than 10 to have leading zero
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        
        // Constructing the start and end date for the given month
        $startDate = "$currentYear-$month-01 00:00:00";
        $endDate = date('Y-m-t', strtotime($startDate)) . " 23:59:59";
        
        $this->db->select('sum(sale_total) as sale_total,sum(total_paid) as total_paid');
        $this->db->from('sales s');
        
        if ($customer_id) {
            $this->db->where("s.customer_id", $customer_id);
        }
        
        if ($warehouse_id) {
            $this->db->where("s.warehouse_id", $warehouse_id);
        }
    
        
        // Adding the condition to filter by the given month
        $this->db->where("DATE(s.sale_datetime) >= ", $startDate);
        $this->db->where("DATE(s.sale_datetime) <= ", $endDate);
        
        $this->db->where("s.sale_status !=", 99);
        
        $this->db->order_by("s.sale_datetime", "desc");
    
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
    }

    function get_customers($cus_type_id,$cus_except = array(),$customer_id = "") {
		$this->db->select('customer.*');
		$this->db->order_by("cus_name", "asc");
		$this->db->where("cus_status",1);//("id !=",$id);
		$this->db->where("cus_type_id",$cus_type_id);//("id !=",$id);
		
		if($customer_id)
		    $this->db->where("cus_id",$customer_id);//("id !=",$id);
		
		
        if (!empty($cus_except)) {
            $this->db->where_not_in("cus_id", $cus_except);
        }
		
		//$this->db->where("cus_id", $id);
		$query = $this->db->get('customer');
		return $query->result_array();
	} 
	public function get_credit_sale_by_cus_id($customer_id, $warehouse_id, $month,$ct,$cus_except)
    {
        // Extracting the current year
        $currentYear = date('Y');
    
        // Adjusting the month value if it's less than 10 to have leading zero
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
    
        // Constructing the start and end date for the given month
        $startDate = "$currentYear-$month-01 00:00:00";
        $endDate = date('Y-m-t', strtotime($startDate)) . " 23:59:59";
    
        $this->db->select('s.*,c.cus_name');
        $this->db->from('sales s');
        //$this->db->join('sale_payments sp', 's.sale_id=sp.sale_id', 'left');
        $this->db->join('customer c', 'c.cus_id=s.customer_id', 'left');
        if($customer_id)
            $this->db->where("s.customer_id", $customer_id);
        
        if (!empty($cus_except)) {
            $this->db->where_not_in("s.customer_id", $cus_except);
        }
        
        if($ct)
            $this->db->where("c.cus_type_id", $ct);
            
        $this->db->where("s.warehouse_id", $warehouse_id);
        $this->db->where("s.payment_status != ", "paid"); 
    
        // Adding the condition to filter by the given month
        $this->db->where("date(s.sale_datetime) >= ", $startDate);
        $this->db->where("date(s.sale_datetime) <= ", $endDate);
    
        $this->db->order_by("s.sale_datetime", "desc");
        /*$this->db->group_by("s.sale_id");*/
        $query = $this->db->get();
        /*echo $this->db->last_query();*/
        return $query->result();
    }
}