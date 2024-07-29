<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Cash_Balance extends CI_Controller
{
    var $main_menu_name = "finance";
    var $sub_menu_name = "cash_balance";
    public function __construct()
    {
        parent::__construct();
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $this->load->model('Cash_Balance_Model');
        $this->load->model('Warehouse_Model');
        $this->load->model('Common_Model');
        $this->load->model('Transactions_Model');
        $this->load->model('Sales_Model');
        $this->load->model('User_Model'); 
        $this->load->model('products_model'); 
        $this->load->model('Fixed_Assets_Model'); 
        date_default_timezone_set("Asia/Colombo");
    }
    // new implemetation by sachith eranga
    public function index()
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = $this->sub_menu_name;
        $this->load->view('cash_balance', $data);
    }
    public function cash_float_open()
    {
        $data['main_menu_name']         = $this->main_menu_name;
        $data['sub_menu_name']          = "cash_float_open";
        $srh_warehouse_id               = $this->session->userdata('ss_warehouse_id');
        $srh_to_date                    = date("Y-m-d 23:59:59");
        $srh_from_date                  = date("Y-m-d 00:00:00");
        $srh_type                       = '';
        $srh_payment_term               = 'Cash';
        $ss_user_id                     = $this->session->userdata('ss_user_id');
        $srh_customer_id                = '';
        $data['sale_cash_total']        = 0;
        $data['service_cash_total']     = 0;
        $data['sale_return_cash_total'] = 0;
        $this->load->view('flot/cash_float_open', $data);
    }
    public function save_cash_float_open()
    {
        $check_chashier_float = $this->User_Model->get_user_chashier_float($this->session->userdata('ss_user_id'));
        $float_status         = 0;
        if ($check_chashier_float > 0) {
            $float_status = 1;
        }
        if ($float_status == 0) {
            $acctrnss_id      = $this->input->post('acctrnss_id');
            $type             = $this->input->post('type');
            $fxd_ass_id       = $this->input->post('fxd_ass_id');
            $acctrnss_amount  = $this->input->post('cash_in_hand');
            $etp_id           = $this->input->post('etp_id');
            $warehouse_id     = $this->input->post('warehouse_id');
            $acctrnss_date    = date('Y-m-d', strtotime($this->input->post('acctrnss_date')));
            $user_id          = $this->session->userdata('ss_user_id');
            $acctrnss_details = $this->input->post('remarks');
            $this->load->library('form_validation'); //form validation lib
            if ($type == 'A') {
                $this->form_validation->set_rules('fxd_ass_id', 'required');
            } else if ($type == 'E') {
                $this->form_validation->set_rules('fxd_ass_id', 'required');
            }
            if ($this->form_validation->run() == FALSE) {
                $st = array(
                    'status' => 0,
                    'disMsg' => validation_errors(),
                    'error' => 1
                );
                echo json_encode($st);
            } else {
                $ref_no     = $this->Common_Model->gen_ref_number('c_float_mstr_id', 'cashier_float_master', 'CFL');
                $data       = array(
                    'warehouse_id' => $warehouse_id,
                    'c_f_m_date_time' => date("Y-m-d H:i:s"),
                    'float_status' => 1,
                    'user_id' => $user_id,
                    'ref_no' => $ref_no
                );
                $last_id    = $this->Cash_Balance_Model->save_cashier_float_master($data);
                $data_items = array(
                    'c_float_mstr_id' => $last_id,
                    'float_type' => 1,
                    'c_count_5000' => $this->input->post('count_5000'),
                    'c_count_1000' => $this->input->post('count_1000'),
                    'c_count_500' => $this->input->post('count_500'),
                    'c_count_100' => $this->input->post('count_100'),
                    'c_count_50' => $this->input->post('count_50'),
                    'c_count_20' => $this->input->post('count_20'),
                    'c_count_10' => $this->input->post('count_10'),
                    'c_count_10_c' => $this->input->post('count_10_c'),
                    'c_count_5_c' => $this->input->post('count_5'),
                    'c_count_2_c' => $this->input->post('count_2'),
                    'c_count_1_c' => $this->input->post('count_1'),
                    'float_item_details' => $acctrnss_details,
                    'recode_date_time' => date("Y-m-d H:i:s"),
                    'cash_on_hand' => $acctrnss_amount,
                    'total_recived_payment' => $acctrnss_amount
                );
                $this->Cash_Balance_Model->save_cashier_float_item($data_items);
                $this->session->set_userdata("ss_cashier_float_id", $last_id);
                $this->session->set_userdata("ss_cashier_float_status", 1);
                $disMsg = "done";
                if ($type == 'A') {
                    if ($last_id) {
                        echo json_encode(array(
                            'id' => $last_id,
                            'type' => $type,
                            'status' => 1,
                            'error' => 0,
                            'disMsg' => $disMsg
                        ));
                    } else {
                        echo json_encode(array(
                            'status' => '0',
                            'error' => 1,
                            'disMsg' => $disMsg
                        ));
                    }
                }
            }
        } else {
            $disMsg = "You alrady have chashier float";
            echo json_encode(array(
                'status' => '0',
                'error' => 1,
                'disMsg' => $disMsg
            ));
        }
    }
    public function cash_float_close()
    {
        $data['main_menu_name']         = $this->main_menu_name;
        $data['sub_menu_name']          = "cash_float_open";
        $srh_warehouse_id               = $this->session->userdata('ss_warehouse_id');
        $srh_to_date                    = date("Y-m-d 23:59:59");
        $srh_from_date                  = date("Y-m-d 00:00:00");
        $srh_type                       = '';
        $srh_payment_term               = 'Cash';
        $ss_user_id                     = $this->session->userdata('ss_user_id');
        $srh_customer_id                = '';
        $data['sale_cash_total']        = 0;
        $data['service_cash_total']     = 0;
        $data['sale_return_cash_total'] = 0;
        $this->load->view('flot/cash_float_close', $data);
    }
    public function save_cash_float_close()
    {
        $check_chashier_float = $this->User_Model->get_user_chashier_float($this->session->userdata('ss_user_id'));
        $float_status         = 0;
        if ($check_chashier_float > 0) {
            $float_status = 1;
        }
        if ($float_status == 1) {
            $acctrnss_id      = $this->input->post('acctrnss_id');
            $type             = $this->input->post('type');
            $fxd_ass_id       = $this->input->post('fxd_ass_id');
            $acctrnss_amount  = $this->input->post('cash_in_hand');
            $etp_id           = $this->input->post('etp_id');
            $warehouse_id     = $this->input->post('warehouse_id');
            $acctrnss_date    = date('Y-m-d', strtotime($this->input->post('acctrnss_date')));
            $user_id          = $this->session->userdata('ss_user_id');
            $acctrnss_details = $this->input->post('remarks');
            $cheque           = $this->input->post('cheque');
            $visa_card        = $this->input->post('visa_card');
            $master_card      = $this->input->post('master_card');
            $amex_card        = $this->input->post('amex_card');
            $this->load->library('form_validation'); //form validation lib
            if ($type == 'A') {
                $this->form_validation->set_rules('fxd_ass_id', 'required');
            } else if ($type == 'E') {
                $this->form_validation->set_rules('fxd_ass_id', 'required');
            }
            if ($this->form_validation->run() == FALSE) {
                $st = array(
                    'status' => 0,
                    'disMsg' => validation_errors(),
                    'error' => 1
                );
                echo json_encode($st);
            } else {
                $data    = array(
                    'float_status' => 2
                );
                $last_id = $this->session->userdata('ss_cashier_float_id');
                $this->Cash_Balance_Model->update_cashier_float_master($data, $this->session->userdata('ss_cashier_float_id'));
                $data_items = array(
                    'c_float_mstr_id' => $this->session->userdata('ss_cashier_float_id'),
                    'float_type' => 2,
                    'c_count_5000' => $this->input->post('count_5000'),
                    'c_count_1000' => $this->input->post('count_1000'),
                    'c_count_500' => $this->input->post('count_500'),
                    'c_count_100' => $this->input->post('count_100'),
                    'c_count_50' => $this->input->post('count_50'),
                    'c_count_20' => $this->input->post('count_20'),
                    'c_count_10' => $this->input->post('count_10'),
                    'c_count_10_c' => $this->input->post('count_10_c'),
                    'c_count_5_c' => $this->input->post('count_5'),
                    'c_count_2_c' => $this->input->post('count_2'),
                    'c_count_1_c' => $this->input->post('count_1'),
                    'float_item_details' => $acctrnss_details,
                    'recode_date_time' => date("Y-m-d H:i:s"),
                    'cash_on_hand' => $acctrnss_amount,
                    'cheque_on_hand' => $cheque,
                    'visa_card_on_hand' => $visa_card,
                    'master_card_on_hand' => $master_card,
                    'amex_card_on_hand' => $amex_card,
                    'total_card_on_hand' => $visa_card + $master_card + $amex_card,
                    'total_recived_payment' => $acctrnss_amount + $visa_card + $master_card + $amex_card + $cheque
                );
                $this->Cash_Balance_Model->save_cashier_float_item($data_items);
                $this->session->set_userdata("ss_cashier_float_id", 0);
                $this->session->set_userdata("ss_cashier_float_status", 0);
                $disMsg = "done";
                if ($type == 'A') {
                    if ($last_id) {
                        echo json_encode(array(
                            'id' => $last_id,
                            'type' => $type,
                            'status' => 1,
                            'error' => 0,
                            'disMsg' => $disMsg
                        ));
                    } else {
                        echo json_encode(array(
                            'status' => '0',
                            'error' => 1,
                            'disMsg' => $disMsg
                        ));
                    }
                }
            }
        } else {
            $disMsg = "You do not have chashier float";
            echo json_encode(array(
                'status' => '0',
                'error' => 1,
                'disMsg' => $disMsg
            ));
        }
    }
    function get_float_payment_total($id = '', $payment_type = '')
    {
        $this->db->select_sum('p.sale_pymnt_amount');
        $this->db->from('sale_payments p');
        $this->db->where("p.valid_status",1);
        $this->db->where("p.sale_payment_type", "sale");
        if ($id) {
            $this->db->where("p.float_id", $id);
        }
        if ($payment_type) {
            $this->db->where("p.sale_pymnt_paying_by", $payment_type);
        }
        $query  = $this->db->get();
        $result = $query->row_array();
        
        $sp = 0;
        
        if (isset($result['sale_pymnt_amount'])) {
            $sp = $result['sale_pymnt_amount']; // return $result['sale_pymnt_amount'];
        } else {
            
        }
        
        /**/
        $this->db->select_sum('p.sale_pymnt_amount');
        $this->db->from('sale_payments p');
        $this->db->join('quotations q', ' q.qts_id = p.sale_id', 'inner');
        $this->db->where("p.sale_payment_type", "custom");
        $this->db->where("p.valid_status",1);
        if ($id) {
            $this->db->where("p.float_id", $id);
        }
        if ($payment_type) {
            $this->db->where("p.sale_pymnt_paying_by", $payment_type);
        }
        $query  = $this->db->get();
        $result = $query->row_array();
        
        $qp = 0;
        if (isset($result['sale_pymnt_amount'])) {
            $qp = $result['sale_pymnt_amount'];
        } else {
            
        }
        
        return floatval($sp) + floatval($qp);
    }
    
    function get_mops(){
        $this->db->select('*');
        $this->db->from('mop');
        $this->db->where('active_status',1);
        
        $query = $this->db->get();
        return $query->result();
        
    }
    public function chashier_float_summay()
    {
        $id                                = $this->input->get('id');
        $data['transactions_details']      = $this->Cash_Balance_Model->get_chashier_foat_full_details($id);
        $data['transactions_items']        = $this->Cash_Balance_Model->get_chashier_foat_items_details($id);
        $data['opening_balance']           = 0;
        $data['closing_balance']           = 0;
        $data['tranfer_pettycash_total']   = $this->Cash_Balance_Model->get_tranfer_pettycash_total($id);
        $data['expencess_total']           = $this->Cash_Balance_Model->get_expencess_total_tmp($id);
        $data['withdraval_total']          = $this->Cash_Balance_Model->get_withdrowal_total($id);
        $data['master_card']               = 0;
        $data['visa_card']                 = 0;
        $data['amex_card']                 = 0;
        $data['total_card']                = 0;
        $data['total_cheque']              = 0;
        $data['total_cash']                = 0;
        $data['end_date_time']             = "";
        
        $data['master_card_system']        = $this->get_float_payment_total($id, "master");
        $data['visa_card_system']          = $this->get_float_payment_total($id, "visa");
        $data['amex_card_system']          = $this->get_float_payment_total($id, "amex");
        $data['total_card_system']         = floatval($data['master_card_system']) + floatval($data['visa_card_system']) + $data['amex_card_system'];
        
        $data['total_cheque_system']       = 0;
        $data['sale_cash_total']           = $this->get_float_payment_total($id, "cash");
        $data['sale_pickme_total']         = $this->get_float_payment_total($id, "pick_me");
        
        $data['sale_card_total']           = $data['total_card_system'] ;
        $data['sale_return_cash_total']    = $this->Cash_Balance_Model->get_float_payment_return_total($id, "Cash");
        $data['retail_sale_total']         = $this->Cash_Balance_Model->get_float_retail_sale_total($id);
        $data['credit_staff_sale_total']         = $this->Cash_Balance_Model->get_credit_staff_sale_total($id);
        $data['retail_sale_return__total'] = $this->Cash_Balance_Model->get_float_return_retail_sale_total($id);
        
        
        $data['transfer_to_petty_cash'] = $this->Fixed_Assets_Model->get_sum_acctrnss_amount($id, 1);
        $data['bank_deposit'] = $this->Fixed_Assets_Model->get_sum_acctrnss_amount($id, 2);
        $data['electricity_bill'] = $this->Fixed_Assets_Model->get_sum_acctrnss_amount($id, 3);
        $data['opening_balance'] = $this->Fixed_Assets_Model->get_sum_acctrnss_amount($id, 4);
        $data['expencess_total'] = $this->Fixed_Assets_Model->get_sum_acctrnss_amount($id, 5);
        $data['withdraval_total'] = $this->Fixed_Assets_Model->get_sum_acctrnss_amount($id, 6);
        $data['other_income'] = $this->Fixed_Assets_Model->get_sum_acctrnss_amount($id, 7);
        $data['addition'] = $this->Fixed_Assets_Model->get_sum_acctrnss_amount($id, 8);

        
        
        $data['wholesale_sale_total']      = 0;
        $data['withdraval_list']           = $this->Cash_Balance_Model->get_withdrowal_list($id);
        /*get sale list*/
        $husband_cash                      = 0;
        $wife_cash                         = 0;
        $husband_card                      = 0;
        $wife_card                         = 0;
        $sales                             = $this->Cash_Balance_Model->get_sales_from_float_id($id);
        /*get total_of_sale_items amount*/
        
        foreach ($data['transactions_items'] as $row) {
            if ($row['float_type'] == 1) {
                $data['opening_balance'] = $row['total_recived_payment'];
            }
            if ($row['float_type'] == 2) {
                $data['closing_balance'] = $row['cash_on_hand'];
                $data['master_card']     = $row['master_card_on_hand'];
                $data['visa_card']       = $row['visa_card_on_hand'];
                $data['amex_card']       = $row['amex_card_on_hand'];
                $data['total_card']      = $row['total_card_on_hand'];
                $data['total_cheque']    = $row['cheque_on_hand'];
                $data['total_cash']      = $row['cash_on_hand'];
                $data['end_date_time']   = $row['recode_date_time'];
            }
        }
        $this->load->view('flot/cashier_float_summary', $data);
    }
    public function chashier_float_summay_new()
    {
        $id                                = $this->input->get('id');
        $data['transactions_details']      = $this->Cash_Balance_Model->get_chashier_foat_full_details($id);
        $data['transactions_items']        = $this->Cash_Balance_Model->get_chashier_foat_items_details($id);
        $data['opening_balance']           = 0;
        $data['closing_balance']           = 0;
        $data['tranfer_pettycash_total']   = $this->Cash_Balance_Model->get_tranfer_pettycash_total($id);
        $data['expencess_total']           = $this->Cash_Balance_Model->get_expencess_total_tmp($id);
        $data['withdraval_total']          = $this->Cash_Balance_Model->get_withdrowal_total($id);
        $data['master_card']               = 0;
        $data['visa_card']                 = 0;
        $data['amex_card']                 = 0;
        $data['total_card']                = 0;
        $data['total_cheque']              = 0;
        $data['total_cash']                = 0;
        $data['end_date_time']             = "";
        
        $data['master_card_system']        = $this->get_float_payment_total($id, "master");
        $data['visa_card_system']          = $this->get_float_payment_total($id, "visa");
        $data['amex_card_system']          = $this->get_float_payment_total($id, "amex");
        $data['total_card_system']         = floatval($data['master_card_system']) + floatval($data['visa_card_system']) + $data['amex_card_system'];

        $data['total_cheque_system']       = 0;
        $data['sale_cash_total']           = $this->get_float_payment_total($id, "cash", "");
        $data['sale_pickme_total']         = $this->get_float_payment_total($id, "pick_me", "");
        $data['sale_card_total']           = $this->get_float_payment_total($id, "card", "");
        $data['sale_return_cash_total']    = $this->Cash_Balance_Model->get_float_payment_return_total($id, "Cash");
        $data['retail_sale_total']         = $this->Cash_Balance_Model->get_float_retail_sale_total($id);
        $data['retail_sale_return__total'] = $this->Cash_Balance_Model->get_float_return_retail_sale_total($id);
        $data['wholesale_sale_total']      = 0;
        $data['withdraval_list']           = $this->Cash_Balance_Model->get_withdrowal_list($id);
        $category_list                     = $this->Cash_Balance_Model->get_category_list($id);
        $cat_list                          = array();
        foreach ($category_list as $cat) {
            $cat_sale_total  = $this->Cash_Balance_Model->get_category_sale_total($id, $cat->cat_id);
            $cat_nested_list = array(
                "cat_name" => $cat->cat_name,
                "cat_sale_total" => $cat_sale_total
            );
            $cat_list[]      = $cat_nested_list;
        }
        $data['cc_charge']      = $this->Cash_Balance_Model->get_credit_card_from_float_id($id);
        $data['category_list']  = $cat_list;
        $data['expencess_list'] = $this->Cash_Balance_Model->get_expencess_list($id);
        /*get sale list*/
        $husband_cash           = 0;
        $wife_cash              = 0;
        $husband_card           = 0;
        $wife_card              = 0;
        $sales                  = $this->Cash_Balance_Model->get_sales_from_float_id($id);
        /*get total_of_sale_items amount*/
        foreach ($sales as $sale) {
            /*get total_of_food_sale_items items amount*/
            $sale_items_all         = $this->Cash_Balance_Model->get_sales_items_sum_from_sale_id($sale->sale_id);
            $sale_items_all         = $sale_items_all > 0 ? $sale_items_all : 0;
            $sale_items_food        = $this->Cash_Balance_Model->get_sales_items_sum_from_sale_id($sale->sale_id, 4);
            $sale_items_food        = $sale_items_food > 0 ? $sale_items_food : 0;
            $sale_items_other       = $sale_items_all - $sale_items_food;
            $sale_items_other       = $sale_items_other > 0 ? $sale_items_other : 0;
            /*echo "sale_items_all ";print_r($sale_items_all);echo "<br>";
            echo "sale_items_food ";print_r($sale_items_food);echo "<br>";
            echo "sale_items_other ";print_r($sale_items_other);echo "<br><hr>";*/
            $food_charge_percentage = 0;
            if ($sale_items_food > 0 && $sale_items_all > 0)
                $food_charge_percentage = $sale_items_food / $sale_items_all;
            $other_charge_percentage = 0;
            if ($sale_items_other > 0 && $sale_items_all > 0)
                $other_charge_percentage = $sale_items_other / $sale_items_all;
            $cc_charge = $sale->cc_charge;
            if ($cc_charge > 0) {
                $husband_card += floatval($sale_items_other) * floatval($food_charge_percentage);
                $wife_card += floatval($sale_items_food) * floatval($other_charge_percentage);
            }
            $service_charge = $sale->sale_extra_charges_amount;
            if ($service_charge > 0) {
                if ($sale->paid_by == "cash") {
                    $husband_cash += floatval($service_charge) * floatval($food_charge_percentage);
                    $wife_cash += floatval($service_charge) * floatval($other_charge_percentage);
                } else {
                    $husband_card += floatval($service_charge) * floatval($food_charge_percentage);
                    $wife_card += floatval($service_charge) * floatval($other_charge_percentage);
                }
            }
            if ($sale->paid_by == "cash") {
                $husband_cash += floatval($sale_items_other);
                $wife_cash += floatval($sale_items_food);
            } else {
                $husband_card += floatval($sale_items_other);
                $wife_card += floatval($sale_items_food);
            }
        }
        $data['husband_cash'] = $husband_cash;
        $data['husband_card'] = $husband_card;
        $data['wife_cash']    = $wife_cash;
        $data['wife_card']    = $wife_card;
        foreach ($data['transactions_items'] as $row) {
            if ($row['float_type'] == 1) {
                $data['opening_balance'] = $row['total_recived_payment'];
            }
            if ($row['float_type'] == 2) {
                $data['closing_balance'] = $row['cash_on_hand'];
                $data['master_card']     = $row['master_card_on_hand'];
                $data['visa_card']       = $row['visa_card_on_hand'];
                $data['amex_card']       = $row['amex_card_on_hand'];
                $data['total_card']      = $row['total_card_on_hand'];
                $data['total_cheque']    = $row['cheque_on_hand'];
                $data['total_cash']      = $row['cash_on_hand'];
                $data['end_date_time']   = $row['recode_date_time'];
            }
        }
        $this->load->view('flot/cashier_float_summary_new', $data);
    }
    public function chashier_float_sale_statment()
    {
        $this->load->model('Transfer_Model');
        $this->load->model('Purchases_Model');
        $this->load->model('Product_Damage_Model');
        $this->load->model('Sales_Return_Model');
        $id                                = $this->input->get('id');
        $data['transactions_details']      = $this->Cash_Balance_Model->get_chashier_foat_full_details($id);
        $data['transactions_items']        = $this->Cash_Balance_Model->get_chashier_foat_items_details($id);
        $data['opening_balance']           = 0;
        $data['closing_balance']           = 0;
        $data['tranfer_pettycash_total']   = $this->Cash_Balance_Model->get_tranfer_pettycash_total($id);
        $data['expencess_total']           = $this->Cash_Balance_Model->get_expencess_total_tmp($id);
        $data['withdraval_total']          = $this->Cash_Balance_Model->get_withdrowal_total($id);
        $data['master_card']               = 0;
        $data['visa_card']                 = 0;
        $data['amex_card']                 = 0;
        $data['total_card']                = 0;
        $data['total_cheque']              = 0;
        $data['total_cash']                = 0;
        $data['end_date_time']             = "";
        $data['master_card_system']        = $this->get_float_payment_total($id, "CC", "MasterCard");
        $data['visa_card_system']          = $this->get_float_payment_total($id, "CC", "visa");
        $data['amex_card_system']          = $this->get_float_payment_total($id, "CC", "Amex");
        $data['total_card_system']         = $this->get_float_payment_total($id, "CC", "");
        $data['total_cheque_system']       = 0;
        $data['sale_cash_total']           = $this->get_float_payment_total($id, "cash", "");
        $data['sale_pickme_total']         = $this->get_float_payment_total($id, "pick_me", "");
        $data['sale_card_total']           = $this->get_float_payment_total($id, "card", "");
        $data['sale_return_cash_total']    = $this->Cash_Balance_Model->get_float_payment_return_total($id, "Cash");
        $data['retail_sale_total']         = $this->Cash_Balance_Model->get_float_retail_sale_total($id);
        $data['retail_sale_return__total'] = $this->Cash_Balance_Model->get_float_return_retail_sale_total($id);
        $data['wholesale_sale_total']      = 0;
        $data['withdraval_list']           = $this->Cash_Balance_Model->get_withdrowal_list($id);
        $category_list                     = $this->Cash_Balance_Model->get_category_list($id);
        $cat_list                          = array();
        foreach ($category_list as $cat) {
            $invovie_product_list = $this->Cash_Balance_Model->get_category_product_list($id, $cat->cat_id);
            $cat_sale_total       = $this->Cash_Balance_Model->get_category_sale_total($id, $cat->cat_id);
            $product_list         = array();
            $srh_warehouse_id     = 1;
            foreach ($invovie_product_list as $row) {
                $transferd_qty       = 0;
                $transfer_reseve_qty = 0;
                $transferd_qty       = 0; // $this->Transfer_Model->getTransferdQtyByWarehouseId($srh_warehouse_id, $row['product_id']);
                $transfer_reseve_qty = $this->Transfer_Model->getTransferResevedQtyByWarehouseId($srh_warehouse_id, $row['product_id']);
                $sold_qty            = $this->Cash_Balance_Model->getSoldQtyByWarehouseId($srh_warehouse_id, $row['product_id'], '', $data['end_date_time']);
                $purchased_qty       = $this->Cash_Balance_Model->getPurchasedQtyByWarehouseId($srh_warehouse_id, $row['product_id'], '', $data['end_date_time']);
                $product_damaged_qty = $this->Cash_Balance_Model->getProductDamagedQtyByWarehouseId($srh_warehouse_id, $row['product_id'], '', $data['end_date_time']);
                $sales_return_qty    = $this->Cash_Balance_Model->getSalesReturnQtyByWarehouseId($srh_warehouse_id, $row['product_id']);
                $sold_within         = $this->Cash_Balance_Model->getSoldQtyByWarehouseIdNotInShift($srh_warehouse_id, $row['product_id'], $data['transactions_details']['c_f_m_date_time'], $data['end_date_time'], $id);
                $grn_within          = $this->Cash_Balance_Model->getPurchasedQtyByWarehouseId($srh_warehouse_id, $row['product_id'], $data['transactions_details']['c_f_m_date_time'], $data['end_date_time']);
                $damage_within       = $this->Cash_Balance_Model->getProductDamagedQtyByWarehouseId($srh_warehouse_id, $row['product_id'], $data['transactions_details']['c_f_m_date_time'], $data['end_date_time']);
                $return_within       = $this->Cash_Balance_Model->getSalesReturnQtyByWarehouseId($srh_warehouse_id, $row['product_id'], $data['transactions_details']['c_f_m_date_time'], $data['end_date_time']);
                $sold                = 0;
                $onhand              = 0;
                $amount              = 0;
                $balance             = ($purchased_qty + $transfer_reseve_qty + $sales_return_qty) - ($sold_qty + $transferd_qty + $product_damaged_qty);
                $nestedData          = array(
                    'product_name' => $row['product_name'],
                    'product_code' => $row['product_code'],
                    'product_price' => $row['product_price'],
                    'sold' => $row['quantity'],
                    'onhand' => ($balance + $row['quantity'] + $sold_within + $damage_within) - ($grn_within + $return_within),
                    'amount' => $row['gross_total'],
                    'balance' => $balance,
                    'within_grn' => $grn_within
                );
                $product_list[]      = $nestedData;
            }
            $cat_nested_list = array(
                "cat_name" => $cat->cat_name,
                "cat_sale_total" => $cat_sale_total,
                "product_list" => $product_list
            );
            $cat_list[]      = $cat_nested_list;
        }
        $data['cc_charge']      = $this->Cash_Balance_Model->get_credit_card_from_float_id($id);
        $data['category_list']  = $cat_list;
        $data['expencess_list'] = $this->Cash_Balance_Model->get_expencess_list($id);
        foreach ($data['transactions_items'] as $row) {
            if ($row['float_type'] == 1) {
                $data['opening_balance'] = $row['total_recived_payment'];
            }
            if ($row['float_type'] == 2) {
                $data['closing_balance'] = $row['cash_on_hand'];
                $data['master_card']     = $row['master_card_on_hand'];
                $data['visa_card']       = $row['visa_card_on_hand'];
                $data['amex_card']       = $row['amex_card_on_hand'];
                $data['total_card']      = $row['total_card_on_hand'];
                $data['total_cheque']    = $row['cheque_on_hand'];
                $data['total_cash']      = $row['cash_on_hand'];
                $data['end_date_time']   = $row['recode_date_time'];
            }
        }
        $this->load->view('flot/cashier_float_sale_statment', $data);
    }
    //-------------------------------------------------old imlientation
    public function save_cash_balance()
    {
        $count_warehouse_id = $this->session->userdata('ss_warehouse_id'); // $this->input->post('warehouse_id');
        $warehouse_code     = $this->Warehouse_Model->get_warehouse_info($count_warehouse_id);
        //update shift status
        $ss_user_id         = $this->session->userdata('ss_user_id');
        $shift_date         = date("Y-m-d");
        $cash_in_hand       = $this->input->post('cash_in_hand');
        $active_shift_des   = $this->Common_Model->get_active_shift_by_user_id_date($ss_user_id, $shift_date);
        //print_r($this->input->post());
        //print_r($active_shift_des);
        if (count($active_shift_des)) {
            $acctrnss_id  = $active_shift_des['acctrnss_id'];
            $shift_status = 0;
            $data         = array(
                'shift_end_datetime' => date("Y-m-d H:i:s"),
                'shift_status' => $shift_status,
                'cash_in_hand' => $cash_in_hand,
                'count_5000' => $this->input->post('count_5000'),
                'count_1000' => $this->input->post('count_1000'),
                'count_500' => $this->input->post('count_500'),
                'count_100' => $this->input->post('count_100'),
                'count_50' => $this->input->post('count_50'),
                'count_20' => $this->input->post('count_20'),
                'count_10' => $this->input->post('count_10'),
                'count_10_c' => $this->input->post('count_10_c'),
                'count_5' => $this->input->post('count_5'),
                'count_2' => $this->input->post('count_2'),
                'count_1' => $this->input->post('count_1'),
                'cheque_amount' => $this->input->post('cheque_amount'),
                'mc_amount' => $this->input->post('mc_amount'),
                'vc_amount' => $this->input->post('vc_amount')
            );
            //print_r($data);
            //    echo "acctrnss_id:$acctrnss_id";
            $_insert      = $this->Transactions_Model->save_transactions($data, $acctrnss_id);
            //    echo $this->db->last_query();
        }
        //end update shift status
        /*
        $count_date = date('Y-m-d');
        $count_user_id = $this->input->post('count_user_id');
        $count_5000 = $this->input->post('count-5000');
        $count_1000 = $this->input->post('count-1000');
        $count_500 = $this->input->post('count-500');
        $count_100 = $this->input->post('count-100');
        $count_50 = $this->input->post('count-50');
        $count_20 = $this->input->post('count-20');
        $count_10 = $this->input->post('count-10');
        $count_10_c = $this->input->post('count-10-c');
        $count_5_c = $this->input->post('count-5-c');
        $count_2_c = $this->input->post('count-2-c');
        $count_1_c = $this->input->post('count-1-c');
        */
        $error = 0;
        /*
        echo "<pre>";
        print_r($cash_count['count-5000'] );
        echo "</pre>";
        */
        if (!$error) {
            $data   = array(
                'count_warehouse_id' => $count_warehouse_id,
                'count_date' => $this->input->post('srh_from_date'),
                'count_user_id' => $this->session->userdata('ss_user_id'),
                'cash_total_amount' => $this->input->post('cash_in_hand'),
                'count-5000' => $this->input->post('count-5000'),
                'count-1000' => $this->input->post('count-1000'),
                'count-500' => $this->input->post('count-500'),
                'count-100' => $this->input->post('count-100'),
                'count-50' => $this->input->post('count-50'),
                'count-20' => $this->input->post('count-20'),
                'count-10' => $this->input->post('count-10'),
                'count-10-c' => $this->input->post('count-10-c'),
                'count-5-c' => $this->input->post('count-5-c'),
                'count-2-c' => $this->input->post('count-2-c'),
                'count-1-c' => $this->input->post('count-1-c'),
                'count_notes' => $this->input->post('count_notes')
            );
            //    print_r($this->session->userdata('cash_in_hand'));
            // $_insert = $this->Cash_Balance_Model->save_cash_balance($data);
            // $lastid = $this->db->insert_id();
            // $sale_id = $lastid;
            //insert user activity
            // $this->Common_Model->add_user_activitie("Added Cash Balance sheet, (Record_ID No:$sale_id)");
            $disMsg = 'Balance Sheet successfully added';
        } else {
            $disMsg = 'Please select these before adding any product:' . $disMsg;
        }
        $this->session->set_flashdata('message', 'Balance sheet successfully added!');
        $lastid = $acctrnss_id;
        echo json_encode(array(
            'lastid' => $lastid,
            'error' => $error,
            'disMsg' => $disMsg
        ));
    }
    public function sale_items()
    {
        $data['sales']          = $this->Sales_Model->get_all_sales();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'sale_items';
        if ($this->session->userdata('ss_group_id') < 3)
            $this->load->view('sales_items', $data);
        else
            show_404();
    }
    public function view()
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = '';
        //get sale id
        $count_id               = $this->uri->segment('3');
        $data['cash_count']     = $this->Cash_Balance_Model->get_counts_info($count_id);
        if ($data['cash_count']) {
            $data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info($data['cash_count']['count_warehouse_id']);
            $data['count_id']          = $count_id;
            $this->load->view('count_view', $data);
        } else
            show_404();
    }
    function get_drawer_cash_total()
    {
        $date              = $this->input->post('srh_from_date');
        $drawer_cash_total = $this->Cash_Balance_Model->get_drawer_cash_total($date);
        //print_r($drawer_cash_total);
        echo json_encode(array(
            'drawer_cash_total' => $drawer_cash_total['cash_total_amount'],
            'count_5000' => $drawer_cash_total['count-5000'],
            'count_1000' => $drawer_cash_total['count-1000'],
            'count_500' => $drawer_cash_total['count-500'],
            'count_100' => $drawer_cash_total['count-100'],
            'count_50' => $drawer_cash_total['count-50'],
            'count_20' => $drawer_cash_total['count-20'],
            'count_10' => $drawer_cash_total['count-10'],
            'count_10c' => $drawer_cash_total['count-10-c']
        ));
    }
}