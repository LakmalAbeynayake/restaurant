<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports extends CI_Controller {

    var $main_menu_name = "reports";
    var $sub_menu_name = "suppliers";

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_Model');
        $this->load->model('Warehouse_Model');
        $this->load->model('Transfer_Model');
        $this->load->model('Sales_Model');
        $this->load->model('Purchases_Model');
        $this->load->model('Supplier_Model');
        $this->load->model('Product_Damage_Model');
        $this->load->model('Sales_Return_Model');
        $this->load->model('Sequerty_Model');
        $this->load->model('Product_Models');
        $this->load->model('Customer_Model');
        $this->load->model('Expenses_Model');
        $this->load->model('User_Model');
    }

    public function index() {
        $this->load->model('Supplier_Model');
        $data['suppliers'] = $this->Supplier_Model->get_all_supplier();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = $this->sub_menu_name;
        $this->load->view('rep_reports', $data);
    }

    public function customer_receivable() {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'customer_receivable';
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['customer_list'] = $this->Customer_Model->get_all_customers();
        $this->load->view('rep_customer_receivable', $data);
    }

    public function customer_summery() {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'customer_summery';
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['customer_list'] = $this->Customer_Model->get_all_customers();
        $this->load->view('rep_customer_summery', $data);
    }

    public function customer_balance_summery() {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'customer_summery_balance';
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['customer_list'] = $this->Customer_Model->get_all_customers();
        $this->load->view('rep_customer_balance_summery', $data);
    }

    public function daily_customer_balance_summery() {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'customer_summery';
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['customer_list'] = $this->Customer_Model->get_all_customers();
        $this->load->view('rep_daily_customer_balance_summery', $data);
    }

    public function supplier_summery() {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'supplier_summery';
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['supplier_list'] = $this->Supplier_Model->get_all_supplier();
        $this->load->view('rep_supplier_summery', $data);
    }

    public function supplier_balance() {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'supplier_balance';
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['supplier_list'] = $this->Purchases_Model->get_supplier();
        $this->load->view('rep_supplier_balance', $data);
    }

    public function cheque() {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'cheque';
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['customer_list'] = $this->Customer_Model->get_all_customers();
        $this->load->view('rep_cheque', $data);
    }

    public function unrealized_cheque() {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'unrealized_cheque';
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['customer_list'] = $this->Customer_Model->get_all_customers();
        $this->load->view('rep_unrealized_cheque', $data);
    }

    public function return_cheque() {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'return_cheque';
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['customer_list'] = $this->Customer_Model->get_all_customers();
        $this->load->view('rep_cheque_return', $data);
    }

    function print_customer_receivable() {
        $data['main_menu_name'] = 'reports';

        $srh_warehouse_id = $this->input->get('srh_warehouse_id');
        $srh_customer_id = $this->input->get('srh_customer_id');
        $srh_from_date = $this->input->get('srh_from_date');
        $srh_to_date = $this->input->get('srh_to_date');

        if ($srh_warehouse_id) {
            $warehouse_details = $this->Warehouse_Model->get_warehouse_info($srh_warehouse_id);
            $data['srh_warehouse_name'] = $warehouse_details['name'];
            $data['warehouse_details'] = $warehouse_details;
            $data['warehouse_id'] = $srh_warehouse_id;
            $customer_details = $this->Customer_Model->get_all_customer_print($srh_customer_id);
            $data['customer_details'] = $customer_details;
            $data['srh_from_date'] = $srh_from_date;
            $data['srh_to_date'] = $srh_to_date;
            $data['srh_customer_id'] = $srh_customer_id;
        } else {
            $data['srh_warehouse_name'] = "-All-";
        }



        $this->load->view('models/print_customer_receivable', $data);
    }

    function print_customer_summery() {
        $data['main_menu_name'] = 'reports';

        $srh_warehouse_id = $this->input->get('srh_warehouse_id');
        $srh_customer_id = $this->input->get('srh_customer_id');
        $srh_from_date = $this->input->get('srh_from_date');
        $srh_to_date = $this->input->get('srh_to_date');
        $type = $this->input->get('type');
        //echo $type;
        //$data['summery_returns']= $this->Sales_Model->get_all_sales_return_for_summery_report($srh_warehouse_id,$srh_to_date,$srh_from_date,'','','',$srh_customer_id) ;
        $data['customers'] = $this->Customer_Model->get_customers($srh_customer_id);
        if ($srh_warehouse_id) {
//			$data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info($this->session->userdata('ss_warehouse_id'));
            $warehouse_details = $this->Warehouse_Model->get_warehouse_info($srh_warehouse_id);
            $data['srh_warehouse_name'] = $warehouse_details['name'];
            $data['warehouse_details'] = $warehouse_details;
            $data['warehouse_id'] = $srh_warehouse_id;
            $data['srh_from_date'] = $srh_from_date;
            $data['srh_to_date'] = $srh_to_date;
            $data['srh_customer_id'] = $srh_customer_id;
        } else {
            $data['srh_warehouse_name'] = "-All-";
        }
        if ($type == 'a') {
            $data['summery'] = $this->Customer_Model->get_all_customer();
            $this->load->view('rep_summery_view', $data);
        }
        if ($type == 'b')
            $this->load->view('rep_summery_balance_view', $data);
    }

    function print_daily_customer_summery() {
        $data['main_menu_name'] = 'reports';
        $srh_warehouse_id = $this->input->get('srh_warehouse_id');
        $srh_customer_id = $this->input->get('srh_customer_id');
        $srh_from_date = $this->input->get('srh_from_date');
        $srh_to_date = $this->input->get('srh_to_date');
        $type = $this->input->get('type');
        //echo $type;
        //$data['summery_returns']= $this->Sales_Model->get_all_sales_return_for_summery_report($srh_warehouse_id,$srh_to_date,$srh_from_date,'','','',$srh_customer_id) ;
        $data['summery'] = $this->Sales_Model->get_all_sales_for_summery_report($srh_warehouse_id, $srh_to_date, $srh_from_date, '', '', '', $srh_customer_id);
        //print_r($data['summery']);

        if ($srh_warehouse_id) {
            $warehouse_details = $this->Warehouse_Model->get_warehouse_info($srh_warehouse_id);
            $data['srh_warehouse_name'] = $warehouse_details['name'];
            $data['warehouse_details'] = $warehouse_details;
            $data['warehouse_id'] = $srh_warehouse_id;
            $customer_details = $this->Customer_Model->get_all_customer_print($srh_customer_id);
            $data['customer_details'] = $customer_details;
            $data['srh_from_date'] = $srh_from_date;
            $data['srh_to_date'] = $srh_to_date;
            $data['srh_customer_id'] = $srh_customer_id;
        } else {
            $data['srh_warehouse_name'] = "-All-";
        }

        if ($type == 'a')
            $this->load->view('rep_summery_view', $data);

        if ($type == 'b')
            $this->load->view('rep_summery_balance_view', $data);
    }

    function print_supplier_summery() {
        $data['main_menu_name'] = 'reports';
        $srh_warehouse_id = $this->input->get('srh_warehouse_id');
        $srh_supplier_id = $this->input->get('srh_supplier_id');
        $srh_from_date = $this->input->get('srh_from_date');
        $srh_to_date = $this->input->get('srh_to_date');
        //$data['summery_returns']= $this->Sales_Model->get_all_purchases_return_for_summery_report($srh_warehouse_id,$srh_to_date,$srh_from_date,'','','',$srh_customer_id) ;
        //print_r($data['summery_returns']);
        //$data['summery']= $this->Sales_Model->get_all_purchases_for_summery_report($srh_warehouse_id,$srh_to_date,$srh_from_date,'','','',$srh_customer_id) ;
        //print_r($data['summery']);
        if ($srh_warehouse_id) {
            $warehouse_details = $this->Warehouse_Model->get_warehouse_info($srh_warehouse_id);
            $data['warehouse_details'] = $warehouse_details;
            $data['warehouse_id'] = $srh_warehouse_id;
            $supplier_details = $this->Supplier_Model->get_all_supplier_for_report($srh_supplier_id);
            $data['customer_details'] = $supplier_details;
            $data['srh_from_date'] = $srh_from_date;
            $data['srh_to_date'] = $srh_to_date;
            $data['srh_supplier_id'] = $srh_supplier_id;
        } else {
            $data['srh_warehouse_name'] = "-All-";
        }
        $this->load->view('rep_supp_summery_view', $data);
    }

    public function payments() {
        $data['main_menu_name'] = 'reports';
        $data['sub_menu_name'] = 'reports/payments';
        $service_type = $this->uri->segment('3');
        $data['service_type'] = $service_type;
        $pageName = '';
        $data['pageName'] = $pageName;
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['user_list'] = $this->User_Model->getUsers();
        $this->load->view('rep_payments', $data);
    }

    public function get_list_expenses_for_report() {
        $data = array();
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $srh_type = $this->input->post('srh_type');
        $srh_payment_term = $this->input->post('srh_payment_term');
        $ss_user_id = $this->input->post('ss_user_id');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }
        $values = $this->Expenses_Model->get_all_expenses_items_for_report($srh_warehouse_id, $srh_to_date, $srh_from_date, $srh_type, $srh_payment_term, $ss_user_id);
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
        $itm_count = 0;
        if (!empty($values)) {
            foreach ($values as $users) {
                $row = array();
                $itm_count++;
                $exp_id = $users->exp_id;
                $row[] = sprintf("%03d", $itm_count);
                $row[] = sprintf("%04d", $users->exp_id);
                $row[] = $users->exp_datetime;
                //$row[]=$users->user_first_name;
                $row[] = $users->product_name;
                //$row[]=$users->unit_name;
                $row[] = $users->product_cost;
                $row[] = $users->expitm_qty;
                $row[] = "($users->expitm_dis_val)" . $users->expitm_dis_val;
                $row[] = $users->sub_total_item;
                //$paymnt_id=$users->sale_pymnt_id;
                $row[] = '';
                //  $row[] = sprintf("%04d", $users->sale_pymnt_id);
                //  $row[] = $users->sale_pymnt_date_time;
                //   $row[] = $users->sale_reference_no;
                // checked="checked"
                $pymnt_collected = '';
                $checked_status = '';
                if ($pymnt_collected == 1) {
                    $checked_status = 'checked=\"checked\"';
                } else {
                    $checked_status = '';
                }
                /*
                  $row[] = "<label class=\"checkbox-inline\">
                  <input id=\"collected_$paymnt_id\" type=\"checkbox\" class=\"flat-red\" value=\"$paymnt_id\" onchange=\"changeColectedStatus($paymnt_id,this.checked)\" $checked_status>
                  Collected
                  </label>";
                 */
                // $row[] =  $users->user_first_name;
                // $row[] =  $users->sale_payment_type;
                // $row[] =  $users->sale_pymnt_paying_by;
                // $row[] = $users->sale_pymnt_amount;		
                $paid = 0;
                //$paid=$this->Booking_Model->get_total_paid_by_booking_id($bkng_id);
                //$row[] =number_format($paid, 2, '.', ',');
                //$row[] =number_format($users->bkng_tot_amount-$paid, 2, '.', ',');
                //$row[]=$actionTxtUpdate.$actionTxtDisble.$actionTxtEnable.$actionTxtPw.$actionTxtDelete;

                $data[] = $row;
            }


            $output = array('data' => $data);
            echo json_encode($output);
        } else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    }

    public function get_list_payments_for_report() {

        $data = array();
        //print_r($values);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $srh_type = $this->input->post('srh_type');
        $srh_payment_term = $this->input->post('srh_payment_term');
        $ss_user_id = $this->input->post('ss_user_id');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }

//echo $srh_to_date.'--';
//echo $srh_from_date.'--';

        $values = $this->Sales_Model->getPaymentsForPrint($srh_warehouse_id, $srh_to_date, $srh_from_date, $srh_type, $srh_payment_term, $ss_user_id);

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
                $invoice_no = '';
                $display = false;
                if ($users->sale_payment_type == 'sale') {
                    $invoice_no = $users->sale_reference_no;
                    $display = true;
                } else if ($users->sale_payment_type == 'sales_return') {
                    //get sales return ref no
                    $sales_return_des = $this->Sales_Return_Model->get_sale_return_info($users->sale_id);
                    $invoice_no = $sales_return_des['sl_rtn_reference_no'];
                    $warehouse_id_sales_rtn = $sales_return_des['warehouse_id'];
                    if ($warehouse_id_sales_rtn == $srh_warehouse_id) {
                        $display = true;
                    } else {
                        $display = false;
                    }
                }

                if ($display) {

                    $row = array();
                    $bkng_id = $users->sale_id;
                    $paymnt_id = $users->sale_pymnt_id;
                    $row[] = sprintf("%04d", $users->sale_pymnt_id);
                    $row[] = site_date_time($users->sale_pymnt_added_date_time);
                    $row[] = $invoice_no;


                    // checked="checked"
                    $pymnt_collected = '';
                    $checked_status = '';
                    if ($pymnt_collected == 1) {
                        $checked_status = 'checked=\"checked\"';
                    } else {
                        $checked_status = '';
                    }
                    /*
                      $row[] = "<label class=\"checkbox-inline\">
                      <input id=\"collected_$paymnt_id\" type=\"checkbox\" class=\"flat-red\" value=\"$paymnt_id\" onchange=\"changeColectedStatus($paymnt_id,this.checked)\" $checked_status>
                      Collected
                      </label>";
                     */
                    $row[] = $users->cus_name;
                    $row[] = $users->sale_payment_type;
                    $row[] = $users->sale_pymnt_paying_by;
                    $row[] = $users->sale_pymnt_amount;
                    $paid = 0;
                    //$paid=$this->Booking_Model->get_total_paid_by_booking_id($bkng_id);
                    //$row[] =number_format($paid, 2, '.', ',');
                    //$row[] =number_format($users->bkng_tot_amount-$paid, 2, '.', ',');
                    //$row[]=$actionTxtUpdate.$actionTxtDisble.$actionTxtEnable.$actionTxtPw.$actionTxtDelete;

                    $data[] = $row;
                }
            }


            $output = array('data' => $data);
            echo json_encode($output);
        } else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    }

    public function get_list_users_for_report() {

        $data = array();
        //print_r($values);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $srh_type = $this->input->post('srh_type');
        $srh_payment_term = $this->input->post('srh_payment_term');
        $ss_user_id = $this->input->post('ss_user_id');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }


        $values = $this->Sales_Model->getPaymentsForPrint($srh_warehouse_id, $srh_to_date, $srh_from_date, $srh_type, $srh_payment_term, $ss_user_id);

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
                $invoice_no = '';
                $display = false;
                if ($users->sale_payment_type == 'sale') {
                    $invoice_no = $users->sale_reference_no;
                    $display = true;
                } else if ($users->sale_payment_type == 'sales_return') {
                    //get sales return ref no
                    $sales_return_des = $this->Sales_Return_Model->get_sale_return_info($users->sale_id);
                    $invoice_no = $sales_return_des['sl_rtn_reference_no'];
                    $warehouse_id_sales_rtn = $sales_return_des['warehouse_id'];
                    if ($warehouse_id_sales_rtn == $srh_warehouse_id) {
                        $display = true;
                    } else {
                        $display = false;
                    }
                }

                if ($display) {

                    $row = array();
                    $bkng_id = $users->sale_id;
                    $paymnt_id = $users->sale_pymnt_id;
                    $row[] = sprintf("%04d", $users->sale_pymnt_id);
                    $row[] = site_date_time($users->sale_pymnt_added_date_time);
                    $row[] = $invoice_no;


                    // checked="checked"
                    $pymnt_collected = '';
                    $checked_status = '';
                    if ($pymnt_collected == 1) {
                        $checked_status = 'checked=\"checked\"';
                    } else {
                        $checked_status = '';
                    }
                    /*
                      $row[] = "<label class=\"checkbox-inline\">
                      <input id=\"collected_$paymnt_id\" type=\"checkbox\" class=\"flat-red\" value=\"$paymnt_id\" onchange=\"changeColectedStatus($paymnt_id,this.checked)\" $checked_status>
                      Collected
                      </label>";
                     */
                    $row[] = $users->cus_name;
                    $row[] = $users->sale_payment_type;
                    $row[] = $users->sale_pymnt_paying_by;
                    $row[] = $users->sale_pymnt_amount;
                    $paid = 0;
                    //$paid=$this->Booking_Model->get_total_paid_by_booking_id($bkng_id);
                    //$row[] =number_format($paid, 2, '.', ',');
                    //$row[] =number_format($users->bkng_tot_amount-$paid, 2, '.', ',');
                    //$row[]=$actionTxtUpdate.$actionTxtDisble.$actionTxtEnable.$actionTxtPw.$actionTxtDelete;

                    $data[] = $row;
                }
            }


            $output = array('data' => $data);
            echo json_encode($output);
        } else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    }

    public function get_list_payments_for_report_rtn() {

        $data = array();
        //print_r($values);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $srh_type = $this->input->post('srh_type');
        $srh_payment_term = $this->input->post('srh_payment_term');
        $ss_user_id = $this->input->post('ss_user_id');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }


        $values = $this->Sales_Model->getPaymentsForPrint_rtn($srh_warehouse_id, $srh_to_date, $srh_from_date, $srh_type, $srh_payment_term, $ss_user_id);

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
                $invoice_no = '';
                $display = false;

                //get sales return ref no
                //$sales_return_des=$this->Sales_Return_Model->get_sale_return_info($users->sale_id);
                //$invoice_no=$sales_return_des['sl_rtn_reference_no'];
                //$warehouse_id_sales_rtn=$sales_return_des['warehouse_id'];





                $row = array();
                //$bkng_id=$users->sale_id;
                //$paymnt_id=$users->sale_pymnt_id;

                $row[] = sprintf("%04d", $users->sale_pymnt_id);
                $row[] = $users->sale_pymnt_date_time;
                $row[] = $users->sl_rtn_reference_no;
                $row[] = $users->cus_name;
                $row[] = $users->sale_payment_type;
                $row[] = $users->sale_pymnt_paying_by;
                $row[] = $users->sale_pymnt_amount;
                // $row[] = sprintf("%04d", $users->sale_pymnt_id);
                //  $row[] = $users->sale_pymnt_date_time;
                //  $row[] = $invoice_no;
                //$pymnt_collected='';
                //	$checked_status='';
                // $row[] =  $users->sale_payment_type;
                // $row[] =  $users->sale_pymnt_paying_by;
                //$row[] = $users->sale_pymnt_amount;		
                $paid = 0;


                $data[] = $row;
            }


            $output = array('data' => $data);
            echo json_encode($output);
        } else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    }

    public function get_list_payments_for_report_grn() {

        $data = array();
        //print_r($values);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $srh_type = $this->input->post('srh_type');
        $srh_payment_term = $this->input->post('srh_payment_term');
        $ss_user_id = $this->input->post('ss_user_id');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }

//echo $srh_to_date."<br>";
//echo $srh_from_date;

        $values = $this->Purchases_Model->getPaymentsForPrint_grn($srh_warehouse_id, $srh_to_date, $srh_from_date, $srh_type, $srh_payment_term, $ss_user_id);

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
				//print_r( $users);
                $invoice_no = '';
                $display = false;

                //get sales return ref no
                //$sales_return_des=$this->Sales_Return_Model->get_sale_return_info($users->sale_id);
                //$invoice_no=$sales_return_des['sl_rtn_reference_no'];
                //$warehouse_id_sales_rtn=$sales_return_des['warehouse_id'];





                $row = array();
                //$bkng_id=$users->sale_id;
                //$paymnt_id=$users->sale_pymnt_id;

                $row[] = sprintf("%04d", $users->sale_pymnt_id);
                $row[] = $users->sale_pymnt_date_time;
                $row[] = $users->reference_no;
                $row[] = $users->supp_company_name;
                $row[] = $users->sale_payment_type;
                $row[] = $users->sale_pymnt_paying_by;
                $row[] = $users->sale_pymnt_amount;
                // $row[] = sprintf("%04d", $users->sale_pymnt_id);
                //  $row[] = $users->sale_pymnt_date_time;
                //  $row[] = $invoice_no;
                //$pymnt_collected='';
                //	$checked_status='';
                // $row[] =  $users->sale_payment_type;
                // $row[] =  $users->sale_pymnt_paying_by;
                //$row[] = $users->sale_pymnt_amount;		
                $paid = 0;


                $data[] = $row;
            }


            $output = array('data' => $data);
            echo json_encode($output);
        } else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    }

    public function get_list_payments_for_report_grn_return() {

        $data = array();
        //print_r($values);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $srh_type = $this->input->post('srh_type');
        $srh_payment_term = $this->input->post('srh_payment_term');
        $ss_user_id = $this->input->post('ss_user_id');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }
//echo $srh_to_date."<br>";
//echo $srh_from_date;

        $values = $this->Purchases_Model->getPaymentsForPrint_grn_return($srh_warehouse_id, $srh_to_date, $srh_from_date, $srh_type, $srh_payment_term, $ss_user_id);

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
                $invoice_no = '';
                $display = false;

                //get sales return ref no
                //$sales_return_des=$this->Sales_Return_Model->get_sale_return_info($users->sale_id);
                //$invoice_no=$sales_return_des['sl_rtn_reference_no'];
                //$warehouse_id_sales_rtn=$sales_return_des['warehouse_id'];





                $row = array();
                //$bkng_id=$users->sale_id;
                //$paymnt_id=$users->sale_pymnt_id;

                $row[] = sprintf("%04d", $users->sale_pymnt_id);
                $row[] = $users->sale_pymnt_date_time;
                $row[] = $users->reference_no;
                $row[] = $users->sale_payment_type;
                $row[] = $users->sale_pymnt_paying_by;
                $row[] = $users->sale_pymnt_amount;
                // $row[] = sprintf("%04d", $users->sale_pymnt_id);
                //  $row[] = $users->sale_pymnt_date_time;
                //  $row[] = $invoice_no;
                //$pymnt_collected='';
                //	$checked_status='';
                // $row[] =  $users->sale_payment_type;
                // $row[] =  $users->sale_pymnt_paying_by;
                //$row[] = $users->sale_pymnt_amount;		
                $paid = 0;


                $data[] = $row;
            }


            $output = array('data' => $data);
            echo json_encode($output);
        } else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    }

    public function get_list_payments_for_balance_report() {

        $data = array();
        //print_r($values);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_customer_id = $this->input->post('srh_customer_id');
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $srh_type = $this->input->post('srh_type');
        $srh_payment_term = $this->input->post('srh_payment_term');
        $ss_user_id = $this->input->post('ss_user_id');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }


        $values = $this->Sales_Model->getPaymentsForBalance($srh_warehouse_id, $srh_to_date, $srh_from_date, $srh_type, $srh_payment_term, $ss_user_id, $srh_customer_id);

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

                $row = array();
                $bkng_id = $users->sale_id;
                $paymnt_id = $users->sale_pymnt_id;
                $row[] = sprintf("%04d", $users->sale_pymnt_id);
                $row[] = $users->sale_pymnt_date_time;
                $row[] = $users->sale_reference_no;


                // checked="checked"
                $pymnt_collected = '';
                $checked_status = '';
                if ($pymnt_collected == 1) {
                    $checked_status = 'checked=\"checked\"';
                } else {
                    $checked_status = '';
                }
                /*
                  $row[] = "<label class=\"checkbox-inline\">
                  <input id=\"collected_$paymnt_id\" type=\"checkbox\" class=\"flat-red\" value=\"$paymnt_id\" onchange=\"changeColectedStatus($paymnt_id,this.checked)\" $checked_status>
                  Collected
                  </label>";
                 */
                //$row[] =  $users->user_first_name;
                $row[] = $users->sale_payment_type;
                $row[] = $users->sale_pymnt_paying_by;
                $row[] = $users->sale_pymnt_amount;
                $paid = 0;
                //$paid=$this->Booking_Model->get_total_paid_by_booking_id($bkng_id);
                //$row[] =number_format($paid, 2, '.', ',');
                //$row[] =number_format($users->bkng_tot_amount-$paid, 2, '.', ',');
                //$row[]=$actionTxtUpdate.$actionTxtDisble.$actionTxtEnable.$actionTxtPw.$actionTxtDelete;

                $data[] = $row;
            }


            $output = array('data' => $data);
            echo json_encode($output);
        } else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    }

    public function get_list_purchase_payments_for_balance_report() {

        $data = array();
        //print_r($values);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_supplier_id = $this->input->post('srh_supplier_id');
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $srh_type = $this->input->post('srh_type');
        $srh_payment_term = $this->input->post('srh_payment_term');
        $ss_user_id = $this->input->post('ss_user_id');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }

        $search_key = $this->input->post('search');
        $search_key_val = $search_key['value'];
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $values = '';
        $totalData = 0;
        if ($search_key_val) {
            $values = $this->Sales_Model->getPurchasePaymentsForBalance($srh_warehouse_id, $srh_to_date, '', $srh_type, $srh_payment_term, '', $srh_supplier_id, $start, $length, $search_key_val);
            $values_count = $this->Sales_Model->getPurchasePaymentsForBalance($srh_warehouse_id, $srh_to_date, '', $srh_type, $srh_payment_term, '', $srh_supplier_id, '', '', $search_key_val);
            $totalData = count($values_count);
        } else {
            $values = $this->Sales_Model->getPurchasePaymentsForBalance($srh_warehouse_id, $srh_to_date, '', $srh_type, $srh_payment_term, '', $srh_supplier_id, $start, $length, '');
            $values_count = $this->Sales_Model->getPurchasePaymentsForBalance($srh_warehouse_id, $srh_to_date, '', $srh_type, $srh_payment_term, '', $srh_supplier_id, '', '', '');
            $totalData = count($values_count);
        }
        $totalFiltered = $totalData;

        // $values = $this->Sales_Model->getPurchasePaymentsForBalance($srh_warehouse_id,$srh_to_date,$srh_from_date,$srh_type,$srh_payment_term,$ss_user_id,$srh_supplier_id);

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

                $row = array();
                $bkng_id = $users->sale_id;
                $paymnt_id = $users->sale_pymnt_id;
                $row[] = sprintf("%04d", $users->sale_pymnt_id);
                $row[] = $users->sale_pymnt_date_time;
                $row[] = $users->reference_no;


                // checked="checked"
                $pymnt_collected = '';
                $checked_status = '';
                if ($pymnt_collected == 1) {
                    $checked_status = 'checked=\"checked\"';
                } else {
                    $checked_status = '';
                }
                /*
                  $row[] = "<label class=\"checkbox-inline\">
                  <input id=\"collected_$paymnt_id\" type=\"checkbox\" class=\"flat-red\" value=\"$paymnt_id\" onchange=\"changeColectedStatus($paymnt_id,this.checked)\" $checked_status>
                  Collected
                  </label>";
                 */
                //$row[] =  $users->user_first_name;
                $row[] = $users->sale_payment_type;
                $row[] = $users->sale_pymnt_paying_by;
                $row[] = $users->sale_pymnt_amount;
                $paid = 0;
                //	$paid=$this->Booking_Model->get_total_paid_by_booking_id($bkng_id);
                //	$row[] =number_format($paid, 2, '.', ',');
                //	$row[] =number_format($users->bkng_tot_amount-$paid, 2, '.', ',');
                //		$row[]=$actionTxtUpdate.$actionTxtDisble.$actionTxtEnable.$actionTxtPw.$actionTxtDelete;

                $data[] = $row;
            }


            $output = array(
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalFiltered,
                'data' => $data
            );
            echo json_encode($output);
        } else {
            $output = array(
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalFiltered,
                'data' => ''
            );
            echo json_encode($output);
        }
    }

    public function customer_balance() {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'customer_balance';

        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['customer_list'] = $this->Customer_Model->get_all_customers();
        if ($this->input->get('type')) {
            $data['wh'] = $this->input->get('wh');
            $data['cs'] = $this->input->get('cs');
            $data['dt'] = $this->input->get('dt');
            $data['csn'] = $this->input->get('csn');
            $this->load->view('rep_customer_balance_print', $data);
        } else {
            $this->load->view('rep_customer_balance', $data);
        }
    }

    public function get_list_sales_for_print_balance($value = '') {
        //print_r($_REQUEST);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $srh_customer_id = $this->input->post('srh_customer_id');
        $srh_payment_status = $this->input->post('srh_payment_status');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }



        $this->load->model('Sales_Model');
        $columns = array(
            0 => 'sale_datetime',
            1 => 'sale_reference_no',
            2 => 'cus_name',
            3 => 'sale_id',
            4 => 'sale_id',
            5 => 'sale_id'
        );

        $data = array();



        $sales = $this->Sales_Model->get_all_sales_for_report_balance($srh_warehouse_id, $srh_to_date, $srh_from_date, '', '', '', $srh_customer_id);
        //echo $this->db->last_query();
        $totalData = count($sales);
        $totalFiltered = $totalData;

        foreach ($sales as $row) {
            $nestedData = array();
            $p_status = '';
            $pay_st = '';
            $sale_id = $row['sale_id'];
            $total_paid_amount = 0;
            $total_paid_amount = $this->Sales_Model->get_total_paid_by_sale_id($sale_id);
            //$total_paid_amount=$row['total_paid_amount']; 

            $return_tot_amt = 0;
            $return_tot_amt = $this->Sales_Return_Model->get_total_return_by_sale_id($sale_id);


            $nestedData[] = $row['sale_id'];
            $nestedData[] = display_date_time_format($row['sale_datetime']);

            $nestedData[] = $row['sale_reference_no'];
            $nestedData[] = $row['cus_name'];


            if (empty($total_paid_amount)) {
                $pay_st = '<span class="label label-warning">Pending</span>';
                $p_status = 'Pending';
            } else {
                if ($total_paid_amount >= ($row['sale_total'] - $return_tot_amt)) {
                    $pay_st = '<span class="label label-success">Paid</span>';
                    $p_status = 'Paid';
                } else {
                    $pay_st = '<span class="label label-info">Partial</span>';
                    $p_status = 'Partial';
                }
            }

            if ($srh_payment_status) {
                if ($srh_payment_status == $p_status) {
                    $nestedData[] = $pay_st;
                    //$nestedData[] = number_format($row['cost_total'], 2, '.', '');
                    $nestedData[] = number_format($row['sale_total'], 2, '.', '');
                    $nestedData[] = $return_tot_amt;
                    $nestedData[] = number_format($total_paid_amount, 2, '.', '');
                    $nestedData[] = number_format($row['sale_total'] - $return_tot_amt - $total_paid_amount, 2, '.', '');

                    $data[] = $nestedData;
                }
            } else {
                $nestedData[] = $pay_st;
                //$nestedData[] = number_format($row['cost_total'], 2, '.', '');
                $nestedData[] = number_format($row['sale_total'], 2, '.', '');
                $nestedData[] = $return_tot_amt;
                $nestedData[] = number_format($total_paid_amount, 2, '.', '');
                $nestedData[] = number_format($row['sale_total'] - $return_tot_amt - $total_paid_amount, 2, '.', '');

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            //"draw"            => intval( $requestData['draw'] ),  
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function get_list_sales_return_for_balance_report($value = '') {
        //print_r($_REQUEST);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_customer_id = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }

        if ($this->input->post('srh_customer_id')) {
            $srh_customer_id = $this->input->post('srh_customer_id');
        }



        $this->load->model('Sales_Model');
        $columns = array(
            0 => 'sale_datetime',
            1 => 'sale_reference_no',
            2 => 'cus_name',
            3 => 'sale_id',
            4 => 'sale_id',
            5 => 'sale_id'//,
                //6=>'sale_id'
        );

        $data = array();
        /*


          if($srh_customer_id){

          $this->db->where("s.customer_id=",$srh_customer_id);

          }

         */


        $sales = $this->Sales_Model->get_all_sales_return_for_balance_report($srh_warehouse_id, $srh_to_date, $srh_from_date, $srh_customer_id);
        //echo $this->db->last_query();
        $totalData = count($sales);
        $totalFiltered = $totalData;

//	print_r($sales);

        foreach ($sales as $row) {
            $nestedData = array();
            $total_paid_amount = $row['total_paid_amount'];
            $pay_st = '';
            $nestedData[] = display_date_time_format($row['sl_rtn_datetime']);
            $nestedData[] = $row['sl_rtn_reference_no'];

            $nestedData[] = $row['cus_name'];

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
            $nestedData[] = $row['sl_rtn_total'];
            $data[] = $nestedData;
        }

        $json_data = array(
            //"draw"            => intval( $requestData['draw'] ),  
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function get_list_cheque_for_report() {

        $data = array();
        //print_r($values);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $srh_type = $this->input->post('srh_type');
        $srh_payment_term = $this->input->post('srh_payment_term');
        $ss_user_id = $this->input->post('ss_user_id');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }


        $values = $this->Sales_Model->getChequeForPrint($srh_warehouse_id, $srh_to_date, $srh_from_date, $srh_type, $srh_payment_term, $ss_user_id);

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
        $tmp_id = 0;
        if (!empty($values)) {
            foreach ($values as $users) {

                $row = array();
                $bkng_id = $users->sale_id;
                $paymnt_id = $users->sale_pymnt_id;
                $tmp_id++;
                $row[] = $tmp_id;
                $row[] = $users->cus_name;
                $row[] = site_date_time($users->sale_pymnt_added_date_time);
                $row[] = $users->sale_pymnt_note;
                $row[] = $users->sale_pymnt_cheque_no;
                $row[] = site_date($users->sale_pymnt_date_time);
                $row[] = $users->sale_reference_no;


                // checked="checked"
                $pymnt_collected = '';
                $checked_status = '';
                if ($pymnt_collected == 1) {
                    $checked_status = 'checked=\"checked\"';
                } else {
                    $checked_status = '';
                }
                /*
                  $row[] = "<label class=\"checkbox-inline\">
                  <input id=\"collected_$paymnt_id\" type=\"checkbox\" class=\"flat-red\" value=\"$paymnt_id\" onchange=\"changeColectedStatus($paymnt_id,this.checked)\" $checked_status>
                  Collected
                  </label>";
                 */
                //$row[] =  $users->user_first_name;
                // $row[] =  $users->sale_payment_type;

                $row[] = $users->sale_pymnt_amount;
                $paid = 0;
                //$paid=$this->Booking_Model->get_total_paid_by_booking_id($bkng_id);
                //$row[] =number_format($paid, 2, '.', ',');
                //$row[] =number_format($users->bkng_tot_amount-$paid, 2, '.', ',');
                //$row[]=$actionTxtUpdate.$actionTxtDisble.$actionTxtEnable.$actionTxtPw.$actionTxtDelete;

                $data[] = $row;
            }


            $output = array('data' => $data);
            echo json_encode($output);
        } else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    }

    public function get_list_unrealized_cheque_for_report() {

        $data = array();
        //print_r($values);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $srh_type = $this->input->post('srh_type');
        $srh_payment_term = $this->input->post('srh_payment_term');
        $ss_user_id = $this->input->post('ss_user_id');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }


        $values = $this->Sales_Model->getUnrealizedChequeForPrint($srh_warehouse_id, $srh_to_date, $srh_from_date, $srh_type, $srh_payment_term, $ss_user_id);

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
        $tmp_id = 0;
        if (!empty($values)) {
            foreach ($values as $users) {

                $row = array();
                $bkng_id = $users->sale_id;
                $paymnt_id = $users->sale_pymnt_id;
                $tmp_id++;
                $row[] = $tmp_id;
                $row[] = $users->cus_name;
                $row[] = site_date_time($users->sale_pymnt_added_date_time);
                $row[] = $users->sale_pymnt_note;
                $row[] = $users->sale_pymnt_cheque_no;
                $row[] = site_date($users->sale_pymnt_date_time);
                $row[] = $users->sale_reference_no;


                // checked="checked"
                $pymnt_collected = '';
                $checked_status = '';
                if ($pymnt_collected == 1) {
                    $checked_status = 'checked=\"checked\"';
                } else {
                    $checked_status = '';
                }
                /*
                  $row[] = "<label class=\"checkbox-inline\">
                  <input id=\"collected_$paymnt_id\" type=\"checkbox\" class=\"flat-red\" value=\"$paymnt_id\" onchange=\"changeColectedStatus($paymnt_id,this.checked)\" $checked_status>
                  Collected
                  </label>";
                 */
                //$row[] =  $users->user_first_name;
                // $row[] =  $users->sale_payment_type;

                $row[] = $users->sale_pymnt_amount;
                $paid = 0;
                //$paid=$this->Booking_Model->get_total_paid_by_booking_id($bkng_id);
                //$row[] =number_format($paid, 2, '.', ',');
                //$row[] =number_format($users->bkng_tot_amount-$paid, 2, '.', ',');
                //$row[]=$actionTxtUpdate.$actionTxtDisble.$actionTxtEnable.$actionTxtPw.$actionTxtDelete;

                $data[] = $row;
            }


            $output = array('data' => $data);
            echo json_encode($output);
        } else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    }

    public function get_list_return_cheque_for_report() {

        $data = array();
        //print_r($values);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $srh_type = $this->input->post('srh_type');
        $srh_payment_term = $this->input->post('srh_payment_term');
        $ss_user_id = $this->input->post('ss_user_id');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }


        $values = $this->Sales_Model->getRetChequeForPrint($srh_warehouse_id, $srh_to_date, $srh_from_date, $srh_type, $srh_payment_term, $ss_user_id);

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
        $tmp_id = 0;
        if (!empty($values)) {
            foreach ($values as $users) {

                $row = array();
                $bkng_id = $users->sale_id;
                $paymnt_id = $users->sale_pymnt_id;
                $tmp_id++;
                $row[] = $tmp_id;
                $row[] = $users->cus_name;
                $row[] = site_date_time($users->sale_pymnt_added_date_time);
                $row[] = $users->sale_pymnt_note;
                $row[] = $users->sale_pymnt_cheque_no;
                $row[] = site_date($users->sale_pymnt_date_time);
                $row[] = $users->sale_reference_no;


                // checked="checked"
                $pymnt_collected = '';
                $checked_status = '';
                if ($pymnt_collected == 1) {
                    $checked_status = 'checked=\"checked\"';
                } else {
                    $checked_status = '';
                }
                /*
                  $row[] = "<label class=\"checkbox-inline\">
                  <input id=\"collected_$paymnt_id\" type=\"checkbox\" class=\"flat-red\" value=\"$paymnt_id\" onchange=\"changeColectedStatus($paymnt_id,this.checked)\" $checked_status>
                  Collected
                  </label>";
                 */
                //$row[] =  $users->user_first_name;
                // $row[] =  $users->sale_payment_type;

                $row[] = $users->sale_pymnt_amount;
                $paid = 0;
                //$paid=$this->Booking_Model->get_total_paid_by_booking_id($bkng_id);
                //$row[] =number_format($paid, 2, '.', ',');
                //$row[] =number_format($users->bkng_tot_amount-$paid, 2, '.', ',');
                //$row[]=$actionTxtUpdate.$actionTxtDisble.$actionTxtEnable.$actionTxtPw.$actionTxtDelete;

                $data[] = $row;
            }


            $output = array('data' => $data);
            echo json_encode($output);
        } else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    }

    public function print_product_code_popup() {
        $data['main_menu_name'] = 'reports';
        $cat_srh = $this->uri->segment(3);
        $sub_cat_srh = $this->uri->segment(4);
        $data['product_list'] = $this->Product_Models->getProductsProduCodePrint($cat_srh, $sub_cat_srh);
        $this->load->view('models/print_product_code_popup', $data);
    }

    public function print_product_barcode_list_popup() {
        $data['main_menu_name'] = 'reports';
        $cat_srh = $this->uri->segment(3);
        $sub_cat_srh = $this->uri->segment(4);
        $data['product_list'] = $this->Product_Models->getProductsProduCodePrint($cat_srh, $sub_cat_srh);
        $this->load->view('models/print_product_barcode_list_popup.php', $data);
    }

    public function print_product_code_list_popup() {
        $data['main_menu_name'] = 'reports';
        $cat_srh = $this->uri->segment(3);
        $sub_cat_srh = $this->uri->segment(4);
        $data['product_list'] = $this->Product_Models->getProductsProduCodePrint($cat_srh, $sub_cat_srh);
        $this->load->view('models/print_product_code_list_popup', $data);
    }

    public function print_product_code() {
        $this->load->model('category_models');
        $data['main_menu_name'] = 'reports';
        $data['sub_menu_name'] = 'print_product_code';

        $cat_srh = $this->input->post('cat_srh');
        $sub_cat_srh = $this->input->post('cat_srh');


        $data['category_list'] = $this->category_models->getCategory();
        // $data['sub_category_list']   = $this->category_models->getSubCategory(1);

        $this->load->view('rep_product_code_print', $data);
    }

    public function get_list_product_for_code_print($value = '') {
        $cat_srh = $this->input->post('cat_srh');
        $sub_cat_srh = $this->input->post('sub_cat_srh');

        $this->load->model('Product_Models');
        $values = $this->Product_Models->getProductsProduCodePrint($cat_srh, $sub_cat_srh);
        $data = array();

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

                $row = array();

                $row[] = $products->product_code;
                $row[] = $products->product_name;
                $row[] = $products->cat_name; //. " ($products->supp_code)";
                $row[] = $products->sub_cat_name;
                //$row[] = $transferd_qty;
                $data[] = $row;
            }

            $output = array('data' => $data);
            echo json_encode($output);
        } else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    }

    public function user_activitie() {
        $data['main_menu_name'] = 'reports';
        $data['sub_menu_name'] = 'user_activitie';
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $this->load->view('rep_user_activitie', $data);
    }

    public function get_list_user_activitie_for_print($value = '') {
        $this->load->model('User_Model');
        //print_r($_REQUEST);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }
        $this->load->model('Sales_Model');
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'id',
            3 => 'id',
            4 => 'id',
        );
        $data = array();
        $grn_data = $this->User_Model->get_all_user_activitie_for_report($srh_warehouse_id, $srh_to_date, $srh_from_date);
        $totalData = count($grn_data);
        $totalFiltered = $totalData;

        foreach ($grn_data as $row) {
            $nestedData = array();
            $id = $row['id'];
            $nestedData[] = $row['details'];
            /* $nestedData[]=$row['page']; */
            $nestedData[] = $row['user_first_name'];
            $nestedData[] = display_date_time_format($row['datetime']);

            $data[] = $nestedData;
        }

        $json_data = array(
            //"draw"            => intval( $requestData['draw'] ),  
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function grn() {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'grn';
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['supplier_list'] = $this->Purchases_Model->get_supplier();
        $this->load->view('rep_grn', $data);
    }

    public function get_list_grn_for_print($value = '') {
        $this->load->model('Purchases_Model');
        //print_r($_REQUEST);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $srh_supplier_id = $this->input->post('srh_supplier_id');
        $srh_payment_status = $this->input->post('srh_payment_status');

        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }

        $this->load->model('Sales_Model');
        $columns = array(
            0 => 'sale_datetime',
            1 => 'sale_reference_no',
            2 => 'cus_name',
            3 => 'sale_id',
            4 => 'sale_id',
            5 => 'sale_id'
        );
        $data = array();
        $grn_data = $this->Purchases_Model->get_all_grn_for_report($srh_warehouse_id, $srh_to_date, $srh_from_date, '', '', $srh_supplier_id);
        $totalData = count($grn_data);
        $totalFiltered = $totalData;

        foreach ($grn_data as $row) {


            $p_status = '';
            $total_paid_amount = $row['grn_total_paid'];
            if (empty($total_paid_amount)) {
                $pay_st = '<span class="label label-warning">Pending</span>';
                $p_status = 'Pending';
            } else {
                if ($total_paid_amount >= $row['grand_total']) {
                    $pay_st = '<span class="label label-success">Paid</span>';
                    $p_status = 'Paid';
                } else {
                    $pay_st = '<span class="label label-info">Partial</span>';
                    $p_status = 'Partial';
                }
            }

            $return_amount = $this->Purchases_Model->get_return_amount($row['id']);
//if($return_amount[0]['sum'])
//print_r($return_amount[0]['sum']);
            if ($srh_payment_status) {
                if ($srh_payment_status == $p_status) {
                    $nestedData = array();
                    $id = $row['id'];
                    $nestedData[] = display_date_time_format($row['date']);
                    $nestedData[] = $row['reference_no'];
                    $nestedData[] = $row['supp_company_name'];
                    $nestedData[] = $pay_st;
                    $nestedData[] = number_format($row['grand_total'], 2, '.', '');
                    $nestedData[] = number_format($total_paid_amount, 2, '.', '');
                    if ($return_amount[0]['sum']) {
                        $nestedData[] = $return_amount[0]['sum'];
                    } else
                        $nestedData[] = '0.00';
                    $nestedData[] = number_format($row['grand_total'] - $total_paid_amount - $return_amount[0]['sum'], 2, '.', '');
                    $data[] = $nestedData;
                }
            }
            else {
                $nestedData = array();
                $id = $row['id'];
                $nestedData[] = display_date_time_format($row['date']);
                $nestedData[] = $row['reference_no'];
                $nestedData[] = $row['supp_company_name'];
                $nestedData[] = $pay_st;
                $nestedData[] = number_format($row['grand_total'], 2, '.', '');
                $nestedData[] = number_format($total_paid_amount, 2, '.', '');
                if ($return_amount[0]['sum']) {
                    $nestedData[] = $return_amount[0]['sum'];
                } else
                    $nestedData[] = '0.00';
                $nestedData[] = number_format($row['grand_total'] - $total_paid_amount - $return_amount[0]['sum'], 2, '.', '');
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            //"draw"            => intval( $requestData['draw'] ),  
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function print_grn() {

        $this->load->model('Purchases_Model');
        $this->load->model('Supplier_Model');
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->get('srh_warehouse_id');
        $srh_supplier_id = $this->input->get('srh_supplier_id');
        $srh_payment_status = $this->input->get('srh_payment_status');
        $data['srh_payment_status'] = $srh_payment_status;
        //echo "$srh_warehouse_id";
        if ($this->input->get('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->get('srh_to_date')));
        }
        if ($this->input->get('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->get('srh_from_date')));
        }
        $this->load->model('Sales_Model');
        //$data['sales_list'] = $this->Sales_Model->get_all_sales_for_print_sales();
        $data['grn_list'] = $this->Purchases_Model->get_all_grn_for_report($srh_warehouse_id, $srh_to_date, $srh_from_date, '', '', $srh_supplier_id);

        $srh_supplier_name = '';

        if ($srh_warehouse_id) {
            $warehouse_details = $this->Warehouse_Model->get_warehouse_info($srh_warehouse_id);
            $data['warehouse_details'] = $warehouse_details;
            $data['srh_warehouse_name'] = $warehouse_details['name'];
        } else {
            $data['srh_warehouse_name'] = "-All-";
        }
        if ($srh_supplier_id) {
            $supplier_details = $this->Supplier_Model->get_supplier_info($srh_supplier_id);

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

    public function daily_sales() {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'daily_sales';
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $this->load->view('rep_sales_daily', $data);
    }

    public function sales() {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'sales';
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['customer_list'] = $this->Customer_Model->get_all_customers();
        $this->load->view('rep_sales', $data);
    }

    public function print_sale() {
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->get('srh_warehouse_id');
        $srh_customer_id = $this->input->get('srh_customer_id');
        //echo "cus id:".$srh_customer_id;
        $srh_payment_status = $this->input->get('srh_payment_status');
        $data['srh_payment_status'] = $srh_payment_status;
        if ($this->input->get('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->get('srh_to_date')));
        }
        if ($this->input->get('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->get('srh_from_date')));
        }
        $this->load->model('Sales_Model');
        //$data['sales_list'] = $this->Sales_Model->get_all_sales_for_print_sales();
        $data['sales_list'] = $this->Sales_Model->get_all_sales_for_report($srh_warehouse_id, $srh_to_date, $srh_from_date, '', '', '', $srh_customer_id);



        $srh_customer_name = '';

        if ($srh_customer_id) {
            $customer_details = $this->Customer_Model->get_customer_info($srh_customer_id);
            //$data['customer_details']=$customer_details;
            $data['srh_customer_name'] = $customer_details['cus_name'];
        } else {
            $data['srh_customer_name'] = "-All-";
        }

        if ($srh_warehouse_id) {
            $warehouse_details = $this->Warehouse_Model->get_warehouse_info($srh_warehouse_id);
            $data['srh_warehouse_name'] = $warehouse_details['name'];
            $data['warehouse_details'] = $warehouse_details;
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

    public function suppliers() {
        $this->load->model('Supplier_Model');
        $data['suppliers'] = $this->Supplier_Model->get_all_supplier();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = $this->sub_menu_name;
        $this->load->view('rep_suppliers', $data);
    }

    public function print_supplier() {
        $this->load->model('Supplier_Model');
        $data['suppliers_list'] = $this->Supplier_Model->get_all_supplier();
        $this->load->view('models/print_supplier', $data);
    }

    public function products() {
        $this->load->model('Product_Models');
        $this->load->model('category_models');
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['product_list'] = $this->Product_Models->getProducts('', '', '');
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'products';
        $data['category_list'] = $this->category_models->getCategory();
        $this->load->view('rep_products', $data);
    }

    public function products_quantity() {
        $this->load->model('Product_Models');
        $this->load->model('category_models');
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['product_list'] = $this->Product_Models->getProducts('', '', '');
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'products_quantity';
        $data['category_list'] = $this->category_models->getCategory();
        $this->load->view('rep_products_quantity', $data);
    }

    public function supplier_products() {
        $this->load->model('Product_Models');
        $this->load->model('purchases_model');
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['product_list'] = $this->Product_Models->getProducts('', '', '');
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'supplier_products';
        $data['supplier_list'] = $this->purchases_model->get_supplier();

        $this->load->view('rep_supplier_products', $data);
    }

    public function alert_quantity() {
        $this->load->model('Product_Models');
        $this->load->model('category_models');
        $data['category_list'] = $this->category_models->getCategory();

        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['product_list'] = $this->Product_Models->getProducts('', '', '');
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'alert_quantity';
        $this->load->view('rep_alert_quantity', $data);
    }

    public function print_products() {
        $this->load->model('Product_Models');

        $data['product_list'] = $this->Product_Models->getProducts('', '', '');
        $this->load->view('models/print_products', $data);
    }

    public function print_alert_quantity() {
        $this->load->model('Product_Models');

        $data['product_list'] = $this->Product_Models->getProducts('', '', '');
        $this->load->view('models/print_alert_quantity', $data);
    }

    public function get_list_sales_for_print($value = '') {
        //print_r($_REQUEST);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $srh_customer_id = $this->input->post('srh_customer_id');
        $srh_payment_status = $this->input->post('srh_payment_status');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }



        $this->load->model('Sales_Model');
        $columns = array(
            0 => 'sale_datetime',
            1 => 'sale_reference_no',
            2 => 'cus_name',
            3 => 'sale_id',
            4 => 'sale_id',
            5 => 'sale_id'
        );

        $data = array();



        $sales = $this->Sales_Model->get_all_sales_for_report($srh_warehouse_id, $srh_to_date, $srh_from_date, '', '', '', $srh_customer_id);
        //echo $this->db->last_query();
        $totalData = count($sales);
        $totalFiltered = $totalData;

        foreach ($sales as $row) {
            $nestedData = array();
            $p_status = '';
            $pay_st = '';
            $sale_id = $row['sale_id'];
            $total_paid_amount = 0;
            $total_paid_amount = $this->Sales_Model->get_total_paid_by_sale_id($sale_id);
            //$total_paid_amount=$row['total_paid_amount']; 

            $return_tot_amt = 0;
            $return_tot_amt = $this->Sales_Return_Model->get_total_return_by_sale_id($sale_id);

            $nestedData[] = display_date_time_format($row['sale_datetime']);
            $nestedData[] = $row['sale_reference_no'];
            $nestedData[] = $row['cus_name'];


            if (empty($total_paid_amount)) {
                $pay_st = '<span class="label label-warning">Pending</span>';
                $p_status = 'Pending';
            } else {
                if ($total_paid_amount >= ($row['sale_total'] - $return_tot_amt)) {
                    $pay_st = '<span class="label label-success">Paid</span>';
                    $p_status = 'Paid';
                } else {
                    $pay_st = '<span class="label label-info">Partial</span>';
                    $p_status = 'Partial';
                }
            }

            if ($srh_payment_status) {
                if ($srh_payment_status == $p_status) {
                    $nestedData[] = $pay_st;
                    //$nestedData[] = number_format($row['cost_total'], 2, '.', '');
                    $nestedData[] = number_format($row['sale_total'], 2, '.', '');
                    $nestedData[] = $return_tot_amt;
                    $nestedData[] = number_format($total_paid_amount, 2, '.', '');
                    $nestedData[] = number_format($row['sale_total'] - $return_tot_amt - $total_paid_amount, 2, '.', '');

                    $data[] = $nestedData;
                }
            } else {
                $nestedData[] = $pay_st;
                //$nestedData[] = number_format($row['cost_total'], 2, '.', '');
                $nestedData[] = number_format($row['sale_total'], 2, '.', '');
                $nestedData[] = $return_tot_amt;
                $nestedData[] = number_format($total_paid_amount, 2, '.', '');
                $nestedData[] = number_format($row['sale_total'] - $return_tot_amt - $total_paid_amount, 2, '.', '');

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            //"draw"            => intval( $requestData['draw'] ),  
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function get_list_sales_report_for_print_daily($value = '') {
        //print_r($_REQUEST);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        
//		$srh_to_date = $this->input->post('srh_to_date');
//		$srh_from_date = $this->input->post('srh_from_date');
		if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }

//echo $srh_to_date;


        $this->load->model('Sales_Model');
        $columns = array(
            0 => 'sale_datetime',
            1 => 'sale_reference_no',
            2 => 'cus_name',
            3 => 'sale_id',
            4 => 'sale_id',
            5 => 'sale_id'
        );

        $data = array();



        $sales = $this->Sales_Model->get_all_sales_return_for_report($srh_warehouse_id, $srh_to_date, $srh_from_date);
        //echo $this->db->last_query();
        $totalData = count($sales);
        $totalFiltered = $totalData;

        foreach ($sales as $row) {
            $nestedData = array();
            $sale_id = $row['sale_id'];
            $total_paid_amount = $row['total_paid_amount']; //$this->Sales_Model->get_total_paid_by_sale_id($sale_id);
            $nestedData[] = display_date_time_format($row['sl_rtn_datetime']);
            $nestedData[] = $row['sl_rtn_reference_no'];

            $nestedData[] = $row['cus_name'];

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

            $data[] = $nestedData;
        }

        $json_data = array(
            //"draw"            => intval( $requestData['draw'] ),  
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function get_list_sales_report_for_sales_report($value = '') {
        //print_r($_REQUEST);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $srh_customer_id = $this->input->post('srh_customer_id');
        //	echo 'cus id'.$srh_customer_id;
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }



        $this->load->model('Sales_Model');
        $columns = array(
            0 => 'sale_datetime',
            1 => 'sale_reference_no',
            2 => 'cus_name',
            3 => 'sale_id',
            4 => 'sale_id',
            5 => 'sale_id'
        );

        $data = array();



        $sales = $this->Sales_Model->get_all_sales_return_for_report_2($srh_warehouse_id, $srh_to_date, $srh_from_date, $srh_customer_id);
        //echo $this->db->last_query();
        $totalData = count($sales);
        $totalFiltered = $totalData;

        foreach ($sales as $row) {
            $nestedData = array();
            $sale_id = $row['sale_id'];
            $total_paid_amount = $row['total_paid_amount']; //$this->Sales_Model->get_total_paid_by_sale_id($sale_id);
            $nestedData[] = display_date_time_format($row['sl_rtn_datetime']);
            $nestedData[] = $row['sl_rtn_reference_no'];

            $nestedData[] = $row['cus_name'];

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
            //$nestedData[] = number_format($row['cost_total'], 2, '.', '');
            $nestedData[] = number_format($row['sl_rtn_total'], 2, '.', '');

            //$nestedData[] = number_format($row['sl_rtn_total']-$row['cost_total'], 2, '.', '');

            $data[] = $nestedData;
        }

        $json_data = array(
            //"draw"            => intval( $requestData['draw'] ),  
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function get_list_sales_for_print_daily($value = '') {
        //print_r($_REQUEST);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }



        $this->load->model('Sales_Model');
        $columns = array(
            0 => 'sale_datetime',
            1 => 'sale_reference_no',
            2 => 'cus_name',
            3 => 'sale_id',
            4 => 'sale_id',
            5 => 'sale_id'
        );

        $data = array();



        $sales = $this->Sales_Model->get_all_sales_for_report($srh_warehouse_id, $srh_to_date, $srh_from_date);
        //echo $this->db->last_query();
        $totalData = count($sales);
        $totalFiltered = $totalData;

        foreach ($sales as $row) {
            $nestedData = array();
            $sale_id = $row['sale_id'];
            $total_paid_amount = $row['total_paid_amount']; //$this->Sales_Model->get_total_paid_by_sale_id($sale_id);
            $nestedData[] = display_date_time_format($row['sale_datetime']);
            $nestedData[] = $row['sale_reference_no'];
            $nestedData[] = $row['in_type'];
            $nestedData[] = $row['cus_name'];



            if (empty($total_paid_amount)) {
                $pay_st = '<span class="label label-warning">Pending</span>';
            } else {
                if ($total_paid_amount >= $row['sale_total']) {
                    $pay_st = '<span class="label label-success">Paid</span>';
                } else {
                    $pay_st = '<span class="label label-info">Partial</span>';
                }
            }

            $nestedData[] = $pay_st;
            $nestedData[] = number_format($row['cost_total'], 2, '.', '');
            $nestedData[] = number_format($row['sale_total'], 2, '.', '');

            $nestedData[] = number_format($row['sale_total'] - $row['cost_total'], 2, '.', '');

            $data[] = $nestedData;
        }

        $json_data = array(
            //"draw"            => intval( $requestData['draw'] ),  
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function get_list_supplier_for_print($value = '') {
        $this->load->model('Supplier_Model');
        $requestData = $_REQUEST;


        $columns = array(
            0 => 'supp_code',
            0 => 'supp_company_name',
            1 => 'supp_email',
            2 => 'supp_company_phone',
            3 => 'supp_city',
            4 => 'country_id',
            5 => 'supp_id'
        );

        $data = array();
        $suppliers = $this->Supplier_Model->get_all_supplier();
        $totalData = count($suppliers);
        $totalFiltered = $totalData;

        //print_r($suppliers);

        foreach ($suppliers as $row) {
            $nestedData = array();
            $nestedData[] = $row['supp_code'];
            $nestedData[] = $row['supp_company_name'];
            $nestedData[] = $row['supp_email'];
            $nestedData[] = $row['supp_company_phone'];
            $nestedData[] = $row['supp_city'];
            $nestedData[] = $row['country_short_name'];
            $data[] = $nestedData;
        }
        $json_data = array(
            //"draw"            => intval( $requestData['draw'] ),  
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function get_list_supplier_product_for_print($value = '') {
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $supplier_srh = $this->input->post('supplier_srh');
        $this->load->model('Product_Models');
        $values = $this->Product_Models->getSupplierProductsForReport($srh_warehouse_id, $supplier_srh);
        $data = array();
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
                $row = array();
                //get transferd qty
                $transferd_qty = 0;
                $transfer_reseve_qty = 0;
                $transferd_qty = $this->Transfer_Model->getTransferdQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $transfer_reseve_qty = $this->Transfer_Model->getTransferResevedQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $sold_qty = $this->Sales_Model->getSoldQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $purchased_qty = $this->Purchases_Model->getPurchasedQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $product_damaged_qty = $this->Product_Damage_Model->getProductDamagedQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $sales_return_qty = $this->Sales_Return_Model->getSalesReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id);

                $row = array();
                $balance_qty = $purchased_qty + $transfer_reseve_qty + $sales_return_qty - $sold_qty - $transferd_qty - $product_damaged_qty;
                $row[] = $products->product_code;
                $row[] = $products->product_name;
                $row[] = $products->supp_company_name; //. " ($products->supp_code)";
                if ($products->product_part_no) {
                    $row[] = $products->product_part_no;
                } else {
                    $row[] = '';
                }
                $row[] = number_format($purchased_qty, 2, '.', ',');
                $row[] = number_format($sold_qty, 2, '.', ',');
                $row[] = number_format($products->product_alert_qty, 2, '.', ',');
                $row[] = number_format($balance_qty, 2, '.', ',');
                //$row[] = $transferd_qty;
                $data[] = $row;
            }

            $output = array('data' => $data);
            echo json_encode($output);
        } else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    }

    public function get_list_product_for_print($value = '') {
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $cat_srh = $this->input->post('cat_srh');

        $srh_from_date = '';
        $srh_to_date = '';
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }

        /*         * ****************** */
        $search_key = $this->input->post('search');
        $search_key_val = $search_key['value'];
        $start = $this->input->post('start');
        $length = $this->input->post('length');

        $this->load->model('Product_Models');
        $values = '';
        $totalFiltered = 0;

//	$sales = $this->Sales_Model->get_all_sales($start,$length,$search_key_val);
//	$sales_count = $this->Sales_Model->get_all_sales('','','');

        $totalData = 0;
//	echo $length."//";
        //$getSumProductsForReport = $this->Product_Models->getSumProductsForReport($srh_warehouse_id,$cat_srh);

        if ($search_key_val) {
            $values = $this->Product_Models->getProductsForReport($srh_warehouse_id, $cat_srh, $start, $length, $search_key_val);
            $values_c = $this->Product_Models->getProductsForReport_c($srh_warehouse_id, $cat_srh, '', '', $search_key_val);
            $totalData = $values_c[0]->count;
        } else {
            $values = $this->Product_Models->getProductsForReport($srh_warehouse_id, $cat_srh, $start, $length, '');
            $values_c = $this->Product_Models->getProductsForReport_c($srh_warehouse_id, $cat_srh, $start, '', '');
            //print_r($values_c[0]->count);
            $totalData = $values_c[0]->count;
        }

        $totalFiltered = $totalData;
        /*         * ****************** */

        $costPriceTot = 0; //$this->Purchases_Model->getPurchasedQtyByWarehouseId('','',$srh_from_date,$srh_to_date);

        $data = array();

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

                $row = array();

                //get transferd qty
                $transferd_qty = 0;
                $transfer_reseve_qty = 0;

                //$transferd_qty=$this->Transfer_Model->getTransferdQtyByWarehouseId($srh_warehouse_id,$products->product_id,$srh_from_date,$srh_to_date);
                //$transfer_reseve_qty=$this->Transfer_Model->getTransferResevedQtyByWarehouseId($srh_warehouse_id,$products->product_id,$srh_from_date,$srh_to_date);
                $sold_qty = $this->Sales_Model->getSoldQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);

                $purchased_qty = $this->Purchases_Model->getPurchasedQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);

                //echo	$srh_warehouse_id;

                $purchases_return_qty = $this->Purchases_Model->getReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);

                //$purchased_qty=1;
                //$product_damaged_qty=$this->Product_Damage_Model->getProductDamagedQtyByWarehouseId($srh_warehouse_id,$products->product_id,$srh_from_date,$srh_to_date);
                $sales_return_qty = $this->Sales_Return_Model->getSalesReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);

                $product_balance = 0;
                //$product_balance=$purchased_qty+$transfer_reseve_qty+$sales_return_qty-$sold_qty-$transferd_qty-$product_damaged_qty-$purchases_return_qty;

                $product_balance = $purchased_qty + $sales_return_qty - $sold_qty - $purchases_return_qty;

                $sale_price_sub_tot = $products->product_price * $product_balance;
                $cost_price_sub_tot = $products->product_cost * $product_balance;
                $row[] = $products->product_code;
                $row[] = $products->product_name;
                $row[] = $products->product_part_no;
                $row[] = $products->cat_name;
                $row[] = $products->sub_cat_name;
                $row[] = number_format($purchased_qty, 2, '.', ',');
                $row[] = number_format($sold_qty, 2, '.', ',');
                $row[] = number_format($sales_return_qty, 2, '.', ',');
                $row[] = number_format($purchases_return_qty, 2, '.', ',');
                $row[] = '0'; //number_format($product_damaged_qty, 2, '.', ',');
                $row[] = $sale_price_sub_tot;
                $row[] = $cost_price_sub_tot;
                //$row[] = number_format($transferd_qty, 2, '.', ',');
                //$row[] = number_format($transfer_reseve_qty, 2, '.', ',');
                $row[] = $product_balance;
                //	$costPriceTot += $cost_price_sub_tot;
                //$row[] = $transferd_qty;
                $data[] = $row;
            }
            /**/

            $purchased_qty = 0;
            $purchases_return_qty = 0;
            $sold_qty = 0;
            $sales_return_qty = 0;
            $product_balance = 0;

            $sale_price_tot = 0;
            $cost_price_tot = 0;
            /* $product_id				= '';
              if (!empty($values_c)) {


              $transferd_qty=0;
              $transfer_reseve_qty=0;
              $transferd_qty=0;//$this->Transfer_Model->getTransferdQtyByWarehouseId($srh_warehouse_id,$products->product_id,$srh_from_date,$srh_to_date);
              $transfer_reseve_qty= 0;//$this->Transfer_Model->getTransferResevedQtyByWarehouseId($srh_warehouse_id,$products->product_id,$srh_from_date,$srh_to_date);
              $sold_qty=$this->Sales_Model->getSoldQtyByWarehouseId($srh_warehouse_id,$product_id,$srh_from_date,$srh_to_date,$search_key_val,$cat_srh);
              $purchased_qty=$this->Purchases_Model->getPurchasedQtyByWarehouseId($srh_warehouse_id,$product_id,$srh_from_date,$srh_to_date,$search_key_val,$cat_srh);
              $purchases_return_qty=$this->Purchases_Model->getReturnQtyByWarehouseId($srh_warehouse_id,$product_id,$srh_from_date,$srh_to_date,$search_key_val,$cat_srh);
              $product_damaged_qty= 0;//$this->Product_Damage_Model->getProductDamagedQtyByWarehouseId($srh_warehouse_id,$products->product_id,$srh_from_date,$srh_to_date);
              $sales_return_qty=$this->Sales_Return_Model->getSalesReturnQtyByWarehouseId($srh_warehouse_id,$product_id,$srh_from_date,$srh_to_date,$search_key_val,$cat_srh);


              //$product_balance=$purchased_qty+$transfer_reseve_qty+$sales_return_qty-$sold_qty-$transferd_qty-$product_damaged_qty-$purchases_return_qty;

              //$sale_price_tot=$this->Sales_Model->getSoldPriceByWarehouseId($srh_warehouse_id,'',$srh_from_date,$srh_to_date,$search_key_val,$cat_srh);
              //$cost_price_tot=$this->Sales_Model->getCostPriceByWarehouseId($srh_warehouse_id,'',$srh_from_date,$srh_to_date,$search_key_val,$cat_srh);

              //$sale_price_tot=$product_price*$product_balance;
              //$cost_price_tot=$product_cost*$product_balance;


              } */
            /**/

            /**/
            $output = array(
                "purchased_qty" => intval($purchased_qty),
                "sold_qty" => intval($sold_qty),
                "sales_return_qty" => intval($sales_return_qty),
                "purchases_return_qty" => intval($purchases_return_qty),
                "product_balance" => intval($product_balance),
                "damadge_qty" => 0,
                "sale_price_tot" => floatval($sale_price_tot),
                "cost_price_tot" => floatval($cost_price_tot),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                'data' => $data);
            echo json_encode($output);
        } else {
            $output = array(
                "recordsTotal" => '',
                "recordsFiltered" => '',
                'data' => '');
            echo json_encode($output);
        }
    }

    public function get_list_product_for_print_summary($value = '') {
        $srh_warehouse_id = $this->input->get('srh_warehouse_id');
        $cat_srh = $this->input->get('cat_srh');

        $srh_from_date = '';
        $srh_to_date = '';
        if ($this->input->get('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->get('srh_to_date')));
        }

        if ($this->input->get('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->get('srh_from_date')));
        }
        /* echo $srh_from_date;echo "||";
          echo $srh_to_date; */

//	$sales = $this->Sales_Model->get_all_sales($start,$length,$search_key_val);
//	$sales_count = $this->Sales_Model->get_all_sales('','','');

        $totalData = 0;
//	echo $length."//";
        //$getSumProductsForReport = $this->Product_Models->getSumProductsForReport($srh_warehouse_id,$cat_srh);
        //$all_values = $this->Product_Models->getProductIdsForReport($srh_warehouse_id,$cat_srh,'','','');
        $values = $this->Product_Models->getProductIdsForReport($srh_warehouse_id, $cat_srh);
        //print_r($values);	
        /* 	if($search_key_val){
          $values = $this->Product_Models->getProductsForReport($srh_warehouse_id,$cat_srh,$start,$length,$search_key_val);
          $values_c = $this->Product_Models->getProductsForReport_c($srh_warehouse_id,$cat_srh,'','',$search_key_val);
          $totalData = $values_c[0]->count;
          }else{
          $values = $this->Product_Models->getProductsForReport($srh_warehouse_id,$cat_srh,$start,$length,'');
          $values_c = $this->Product_Models->getProductsForReport_c($srh_warehouse_id,$cat_srh,$start,'','');
          //print_r($values_c[0]->count);
          $totalData = $values_c[0]->count;
          } */

        //$totalFiltered = $totalData;
        /*         * ****************** */

        $purchased_qty_tot = 0;
        $purchases_return_qty_tot = 0;
        $sold_qty_tot = 0;
        $sales_return_qty_tot = 0;
        $product_balance_tot = 0;
        $sale_price_tot = 0;   //$this->Purchases_Model->getPurchasedQtyByWarehouseId('','',$srh_from_date,$srh_to_date);
        $cost_price_tot = 0;
        $data = array();

        if (!empty($values)) {
            foreach ($values as $products) {


                $transferd_qty = 0;
                $transfer_reseve_qty = 0;

                $sold_qty = $this->Sales_Model->getSoldQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);

                $sold_qty_tot += $sold_qty;
                /* echo "|sq:".$sold_qty."|";
                  echo "|sqt:".$sold_qty_tot."|"; */
                $purchased_qty = $this->Purchases_Model->getPurchasedQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                $purchased_qty_tot += $purchased_qty;

                $purchases_return_qty = $this->Purchases_Model->getReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);

                $purchases_return_qty_tot+= $purchases_return_qty;

                $sales_return_qty = $this->Sales_Return_Model->getSalesReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                $sales_return_qty_tot += $sales_return_qty;

                $product_balance = $purchased_qty + $sales_return_qty - $sold_qty - $purchases_return_qty;
                $product_balance_tot += $product_balance;

                $sale_price_tot += $products->product_price * $product_balance;
                $cost_price_tot += $products->product_cost * $product_balance;
            }
            /**/
//$output = array();
            $output = array(
                "purchased_qty" => intval($purchased_qty_tot),
                "sold_qty" => intval($sold_qty_tot),
                "sales_return_qty" => intval($sales_return_qty_tot),
                "purchases_return_qty" => intval($purchases_return_qty_tot),
                "product_balance" => intval($product_balance_tot),
                "damadge_qty" => 0,
                "sale_price_tot" => floatval($sale_price_tot),
                "cost_price_tot" => floatval($cost_price_tot)
            );

            echo json_encode($output);
        } else {
            $output = array(
                "recordsTotal" => '',
                "recordsFiltered" => '',
                'data' => '');
            echo json_encode($output);
        }
    }

    public function get_list_product_for_print_sub($value = '') {
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $cat_srh = $this->input->post('cat_srh');

        $srh_from_date = '';
        $srh_to_date = '';
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }


        /*         * ****************** */

        $search_key = $this->input->post('search');
        $search_key_val = $search_key['value'];
        $start = $this->input->post('start');
        $length = $this->input->post('length');

        $this->load->model('Product_Models');
        $values = '';
        $totalFiltered = 0;

//	$sales = $this->Sales_Model->get_all_sales($start,$length,$search_key_val);
//	$sales_count = $this->Sales_Model->get_all_sales('','','');

        $totalData = 0;
//	echo $length."//";

        if ($search_key_val) {
            $values = $this->Product_Models->getProductsForReport($srh_warehouse_id, $cat_srh, $start, $length, $search_key_val);
            $values_c = $this->Product_Models->getProductsForReport($srh_warehouse_id, $cat_srh, '', '', $search_key_val);
            $totalData = count($values_c);
        } else {
            $values = $this->Product_Models->getProductsForReport($srh_warehouse_id, $cat_srh, $start, $length, '');
            $values_c = $this->Product_Models->getProductsForReport($srh_warehouse_id, $cat_srh, $start, '', '');
            $totalData = count($values_c);
        }

        $totalFiltered = $totalData;
        /*         * ****************** */

        $costPriceTot = 0; //$this->Purchases_Model->getPurchasedQtyByWarehouseId('','',$srh_from_date,$srh_to_date);

        $data = array();

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

                $row = array();

                //get transferd qty
                $transferd_qty = 0;
                $transfer_reseve_qty = 0;

                $transferd_qty = $this->Transfer_Model->getTransferdQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                $transfer_reseve_qty = $this->Transfer_Model->getTransferResevedQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                $sold_qty = $this->Sales_Model->getSoldQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                $purchased_qty = $this->Purchases_Model->getPurchasedQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                //echo	$srh_warehouse_id;
                $purchases_return_qty = $this->Purchases_Model->getReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);

                //$purchased_qty=1;
                $product_damaged_qty = $this->Product_Damage_Model->getProductDamagedQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                $sales_return_qty = $this->Sales_Return_Model->getSalesReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                $product_balance = 0;
                $product_balance = $purchased_qty + $transfer_reseve_qty + $sales_return_qty - $sold_qty - $transferd_qty - $product_damaged_qty - $purchases_return_qty;
                $sale_price_sub_tot = $products->product_price * $product_balance;
                $cost_price_sub_tot = $products->product_cost * $product_balance;

                $row[] = $products->product_code;
                $row[] = $products->product_name;
                $row[] = $products->product_part_no;
                $row[] = $products->cat_name;
                $row[] = $products->sub_cat_name;
                $row[] = number_format($purchased_qty, 2, '.', ',');
                $row[] = number_format($sold_qty, 2, '.', ',');
                $row[] = number_format($sales_return_qty, 2, '.', ',');
                $row[] = number_format($purchases_return_qty, 2, '.', ',');
                $row[] = number_format($product_damaged_qty, 2, '.', ',');
                $row[] = $sale_price_sub_tot;
                $row[] = $cost_price_sub_tot;
                //	$row[] = number_format($transferd_qty, 2, '.', ',');
                //	$row[] = number_format($transfer_reseve_qty, 2, '.', ',');
                $row[] = $product_balance;
                $costPriceTot += $cost_price_sub_tot;
                //	$row[] = $transferd_qty;
                $data[] = $row;
            }

            $output = array(
                "costPriceTot" => $costPriceTot,
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                'data' => $data);
            echo json_encode($output);
        } else {
            $output = array(
                "recordsTotal" => '',
                "recordsFiltered" => '',
                'data' => '');
            echo json_encode($output);
        }
    }

    public function get_list_product_qty_for_print($value = '') {
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $cat_srh = $this->input->post('cat_srh');

        $this->load->model('Product_Models');
        $values = $this->Product_Models->getProductsForQTYReport($srh_warehouse_id, $cat_srh);

        $data = array();

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

                $row = array();

                //get transferd qty
                $transferd_qty = 0;
                $transfer_reseve_qty = 0;
                $transferd_qty = $this->Transfer_Model->getTransferdQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $transfer_reseve_qty = $this->Transfer_Model->getTransferResevedQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $sold_qty = $this->Sales_Model->getSoldQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $purchased_qty = $this->Purchases_Model->getPurchasedQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $product_damaged_qty = $this->Product_Damage_Model->getProductDamagedQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $sales_return_qty = $this->Sales_Return_Model->getSalesReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                $p_returned_qty = $this->Purchases_Model->getReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id);


                $row[] = $products->product_code;
                $row[] = $products->product_name;
                // $row[] = $products->product_part_no;
                //  $row[] = $products->cat_name;
                //  $row[] = $products->sub_cat_name;

                $tmp_qty = $purchased_qty + $transfer_reseve_qty + $sales_return_qty - $sold_qty - $transferd_qty - $product_damaged_qty - $p_returned_qty;
                // $row[] = number_format(($products->product_cost), 2, '.', '');
                // $row[] = number_format(($products->product_price), 2, '.', '');

                $row[] = number_format($tmp_qty, 2, '.', '');

                //  $row[] = number_format(($products->product_cost*$tmp_qty), 2, '.', '');
                // $row[] = number_format(($products->product_price*$tmp_qty), 2, '.', '');
                //$row[] = $transferd_qty;
                $data[] = $row;
            }

            $output = array('data' => $data);
            echo json_encode($output);
        } else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    }

    public function get_list_product_alert_quantity_for_print($value = '') {
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $cat_srh = $this->input->post('cat_srh');
        $cat_srh = '';
        $this->load->model('Product_Models');
        $values = $this->Product_Models->getProductsForReport($srh_warehouse_id, $cat_srh);

        $data = array();

        if (!empty($values)) {
            foreach ($values as $products) {
                //print_r($products);
                if ($products->product_status == 0) {
                    $k = "btn-warning";
                    $m = "fa-minus-circle";
                } else {
                    $k = "btn-green";
                    $m = "fa-check";
                }
                $retVal = (empty($products->sub_cat_name)) ? "--:--" : $products->sub_cat_name;

                //get transferd qty
                $transferd_qty = 0;
                $transfer_reseve_qty = 0;
                //1
                $transferd_qty = $this->Transfer_Model->getTransferdQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                //2
                $transfer_reseve_qty = $this->Transfer_Model->getTransferResevedQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                //3
                $sold_qty = $this->Sales_Model->getSoldQtyByWarehouseId($srh_warehouse_id, $products->product_id);

                //4
                $purchased_qty = $this->Purchases_Model->getPurchasedQtyByWarehouseId($srh_warehouse_id, $products->product_id);

                //5
                $p_returned_qty = $this->Purchases_Model->getReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id);

                //6
                $product_damaged_qty = $this->Product_Damage_Model->getProductDamagedQtyByWarehouseId($srh_warehouse_id, $products->product_id);
                //7
                $sales_return_qty = $this->Sales_Return_Model->getSalesReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id);

                $row = array();
                $balance_qty = $purchased_qty + $transfer_reseve_qty + $sales_return_qty - $sold_qty - $transferd_qty - $product_damaged_qty - $p_returned_qty;
                if ($products->product_alert_qty > 0)
                    if ($balance_qty < $products->product_alert_qty) {

                        $row[] = $products->product_code;
                        $row[] = $products->product_name;

                        // $row[] = $products->cat_name;
                        // $row[] = $products->sub_cat_name;
                        $row[] = $products->product_alert_qty;
                        $row[] = $products->product_max_qty;


                        $row[] = number_format(($balance_qty), 2, '.', ',');
                        $row[] = $products->product_max_qty - $balance_qty;
                        //$row[] = $transferd_qty;
                        //print_r($row);
                        $data[] = $row;
                    }
            }
            //print_r($data);
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    }

}
