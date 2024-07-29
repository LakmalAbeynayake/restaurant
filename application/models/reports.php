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
        $this->load->model('Product_Damage_Model');
        $this->load->model('Sales_Return_Model');
        $this->load->model('Sequerty_Model');
        $this->load->model('Product_Models');
        $this->load->model('Customer_Model');
        $this->load->model('Menu_Items_List_Model');
		$this->load->model('category_models');
		$this->load->model('Report_Model');
		
    }

    public function index() {
        $this->load->model('Supplier_Model');
        $data['suppliers'] = $this->Supplier_Model->get_all_supplier();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = $this->sub_menu_name;
        $this->load->view('rep_reports', $data);
    }
	
	public function stock_movement(){
	$data['main_menu_name'] = $this->main_menu_name;
	$data['sub_menu_name']='product_reports';
	$data['sub_menu_name_1']='';
    $data['product_list'] = $this->Product_Models->getProductsStockMovReport();
	//$data['location_list']=$this->Location_Model->get_all_location_for_dropdown();
	$data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
	$data['category_list'] 	= $this->category_models->getCategory();
	$data['sub_category_list']   = $this->category_models->getSubCategory(1);
	$this->load->view('stock_movement',$data);
	}
	
	public function stock_movement_list(){
	
	
	$product_id=$this->input->post('product_id');
	$srh_warehouse_id=$this->input->post('srh_warehouse_id');
	$location_id=$this->input->post('location_id');
	$product_name=$this->input->post('product_name');
	$product_model=$this->input->post('product_model');
	$srh_from_date=$this->input->post('srh_from_date');
	$srh_to_date=$this->input->post('srh_to_date');
	$cat_srh=$this->input->post('cat_srh');
	$subcategory=$this->input->post('subcategory');
	$show_all=$this->input->post('show_all');
	
	
	$data=array();
	
	
	
	
	//$data_list=$this->Report_Model->total_product_quantity_list($product_id);
	//$location_count=$data_list[0]['location_count'];
	//$warehouse_count=$data_list[0]['warehouse_count'];
	//$total=$location_count+$warehouse_count;
	//$location_list=$this->Location_Model->get_all_location_for_dropdown();
	/*
	echo json_encode(array("product_name"=>$product_name,"product_model"=>$product_model,"location_count"=>$location_count,"warehouse_count"=>$warehouse_count,"total"=>$total));
	*/
	
	//$srh_warehouse_id=1;
	//$product_name=$product_id;
	//$product_model=$product_id;
	$row="";
	$row.="<tr>";
	
	$item_location_qty=0;
	
	$item_tot_qty=0;
	$item_warehouse_qty='';
	$warehosue_balance=0;
	
	$warehouse_opening_stock=0;
	//get product table warehouse opening stock
	$product_info=$this->Product_Models->get_product_by_id($product_id);
	
	//category check
	
	if($cat_srh!=$product_info->cat_id && $cat_srh!=''){
		//echo json_encode(array("row"=>''));
		//die();
	}
	if($subcategory!=$product_info->sub_cat_id && $subcategory!=''){
		//echo json_encode(array("row"=>''));
		//die();
	}
	//echo "111111111,";
	
	$warehouse_opening_stock=0;//$product_info->stock_mov_avalable_qty;
	
	/*
	if($srh_warehouse_id)
	{
		$item_warehouse_qty=floatval($this->Purchases_Model->get_issued_serial_no_by_product_id_location_id($product_id,0,$srh_warehouse_id,'only_qty'));
		$item_tot_qty=$item_tot_qty+$item_warehouse_qty;
	}
	*/
	
	//echo "srh_from_date:".$srh_from_date;
	
	//opening_stock_qty get
	$day_before = date( 'Y-m-d', strtotime( $srh_from_date . ' -1 day' ) );
	$opening_stock_date=$day_before;
	$opening_stock_qty=0;
	$opening_stock_from_date='2018-12-24';//date('2018-06-24');
	$date_1=date( 'Y-m-d', strtotime( $opening_stock_from_date . ' +1 day' ) );
	$os_i=0;//$this->Report_Model->get_location_issue_by_location_id_and_date($location_id,$product_id,$date_1,$day_before);
	//os grn
	$os_grn=0;
	$os_grn_rtn=0;
	$os_grn=$this->Purchases_Model->getPurchasedQtyByWarehouseIdAndDateRange($location_id,$product_id,$date_1,$day_before);
	$os_grn_rtn=0;//$this->Purchases_Model->getPurchaseRTNdQtyByWarehouseIdAndDateRange($location_id,$product_id,$date_1,$day_before);
	$os_ir=0;//$this->Report_Model->get_location_issue_return_by_location_id_and_date($location_id,$product_id,$date_1,$day_before);
	$os_s = $this->Report_Model->get_location_sale_by_location_id_and_date($location_id,$product_id,$date_1,$day_before);
	//$os_s=$this->Report_Model->get_location_sale_by_location_id_and_date(0,$product_id,$srh_from_date,$srh_to_date,'',$srh_warehouse_id);
	//echo $this->db->last_query();
	$os_h = $this->Report_Model->get_location_sale_by_location_id_and_date($location_id,$product_id,$date_1,$day_before,'Hire');
	$os_st_adj=0;
		$os_st_adj=0;//$this->Purchases_Model->getStockAdjQtyByWarehouseIdAndDateRange($location_id,$product_id,$date_1,$day_before);
	
	//service issue 
	$os_ser_issue=0;//$this->Purchases_Model->getServiceIssueWarehouseIdAndDateRange($location_id,$product_id,$date_1,$day_before);
	$os_ser_issue_rtn=0;//$this->Purchases_Model->getServiceReturnWarehouseIdAndDateRange($location_id,$product_id,$date_1,$day_before);
	
	$os_exchange_qty=0;//$this->Report_Model->get_location_sale_exchange_by_location_id_and_date(0,$product_id,$date_1,$day_before,'',$srh_warehouse_id);
	
	$os_exchange_qty=intval($os_exchange_qty);
	
	//
	
	$test_var='';
	$opening_stock_qty_des="";
	//Start Date: $opening_stock_from_date 
	$opening_stock_qty_des="<br/>wos:$warehouse_opening_stock , os_i:$os_i ,os_ir:$os_ir ,os_s:$os_s ,os_h:$os_h , os e :$os_exchange_qty:";
	//$opening_stock_qty=$os_i-$os_ir-$os_s-$os_h;
	$opening_stock_qty=$warehouse_opening_stock+$os_i-$os_ir-$os_s-$os_h;
	$warehouse_opening_stock_tot=0;
	$warehouse_opening_stock_tot=$warehouse_opening_stock+$os_grn-$os_grn_rtn-$os_i+$os_ir-$os_s-$os_h-$os_ser_issue+$os_ser_issue_rtn+$os_exchange_qty-$os_st_adj;
	
	//$opening_stock_qty_des="wos:$warehouse_opening_stock , os_i:$os_i, os_ir:$os_ir , ";
	
	//$opening_stock_qty=$os_i;
	//opening_stock_qty end
	
	
	
	//get issue item sum
	$location_issue_qty = 0;//$this->Report_Model->get_location_issue_by_location_id_and_date($location_id,$product_id,$srh_from_date,$srh_to_date);
	$location_issue_qty=intval($location_issue_qty);
	$location_issue_return_qty = 0;//$this->Report_Model->get_location_issue_return_by_location_id_and_date($location_id,$product_id,$srh_from_date,$srh_to_date);
	$location_cash_sale_qty = $this->Report_Model->get_location_sale_by_location_id_and_date($location_id,$product_id,$srh_from_date,$srh_to_date,'Cash');
	$location_hire_sale_qty = $this->Report_Model->get_location_sale_by_location_id_and_date($location_id,$product_id,$srh_from_date,$srh_to_date,'Hire');
	//echo $this->db->last_query();
	
	//gen qty
	$purchased_qty=$this->Purchases_Model->getPurchasedQtyByWarehouseIdAndDateRange($srh_warehouse_id,$product_id,$srh_from_date,$srh_to_date);
	//get grn rtn qty
	$purchased_rtn_qty=0;//$this->Purchases_Model->getPurchaseRTNdQtyByWarehouseIdAndDateRange($srh_warehouse_id,$product_id,$srh_from_date,$srh_to_date);
	
	$purchased_qty=intval($purchased_qty);
	
	$sold_qty=$this->Report_Model->get_location_sale_by_location_id_and_date(0,$product_id,$srh_from_date,$srh_to_date,'',$srh_warehouse_id);
	$sold_qty=intval($sold_qty);
	
	$exchange_qty=0;//$this->Report_Model->get_location_sale_exchange_by_location_id_and_date(0,$product_id,$srh_from_date,$srh_to_date,'',$srh_warehouse_id);
	
	$exchange_qty=intval($exchange_qty);
	
	$other_in=0;
	$other_in=0;//$this->Report_Model->get_location_sale_exchange_by_location_id_and_date($location_id,$product_id,$srh_from_date,$srh_to_date,'','');
	
	//service issue 
	$ser_issue=0;//$this->Purchases_Model->getServiceIssueWarehouseIdAndDateRange($location_id,$product_id,$srh_from_date,$srh_to_date);
	//echo "ser_issue:$ser_issue";
	//echo $this->db->last_query();
	
	$ser_issue_rtn=0;//$this->Purchases_Model->getServiceReturnWarehouseIdAndDateRange($location_id,$product_id,$srh_from_date,$srh_to_date);
	
		$st_adj=0;
		$st_adj=0;//$this->Purchases_Model->getStockAdjQtyByWarehouseIdAndDateRange($location_id,$product_id,$srh_from_date,$srh_to_date);
	
	//$ser_issue_rtn=1;
	
	$other_in=intval($other_in);
	
	//echo "location_cash_sale_qty:$location_cash_sale_qty";
	
	$warehosue_balance=$warehouse_opening_stock_tot+$purchased_qty-$purchased_rtn_qty-$sold_qty+$exchange_qty-$location_issue_qty+$location_issue_return_qty-$ser_issue+$ser_issue_rtn-$st_adj;
	
	//$warehosue_balance=$warehouse_opening_stock_tot;
	
	//$cl_balance=0;
	
	//$cl_balance=$other_in+$opening_stock_qty+$location_issue_qty-$location_issue_return_qty-$location_cash_sale_qty-$location_hire_sale_qty;
	//$cl_balance=$opening_stock_qty;
	
	
	
	$item_warehouse_qty='';
	$item_tot_qty='';
	
	$opening_stock_qty='';
	
	//test
	//$cl_balance='';
	$other_in='';
	$opening_stock_qty_des=''; //test
	$purchased_rtn_qty=intval($purchased_rtn_qty);
//	$warehouse_opening_stock_tot=$warehouse_opening_stock;
	
	//end test
	// ($product_model) 
	
	if(!$purchased_qty) $purchased_qty='';
	if(!$purchased_rtn_qty) $purchased_rtn_qty='';
	if(!$st_adj) $st_adj='';
	if(!$ser_issue) $ser_issue='';
	if(!$ser_issue_rtn) $ser_issue_rtn='';
	if(!$sold_qty) $sold_qty='';
	if(!$exchange_qty) $exchange_qty='';
	if(!$location_issue_return_qty) $location_issue_return_qty='';
	if(!$location_issue_qty) $location_issue_qty='';
	
	$row.="<td align=\"left\" style=\"text-align:left\">$product_name $opening_stock_qty_des</td>";
	$row.="<td align='right'>$warehouse_opening_stock_tot</td>";
	
	$row.="<td align='right'>$purchased_qty </td>";
	$row.="<td align='right'>$purchased_rtn_qty</td>";
	$row.="<td align='right'>$st_adj</td>";
	$row.="<td align='right'>$ser_issue</td>";
	$row.="<td align='right'>$ser_issue_rtn</td>";
	$row.="<td align='right'>$sold_qty </td>";
	$row.="<td align='right'>$exchange_qty </td>";
	$row.="<td align='right'></td>";
	$row.="<td align='right'>$location_issue_qty</td>";
	$row.="<td align='right'>$location_issue_return_qty</td>";
	$row.="<td align='right'>$warehosue_balance </td>";
	//$row.="<td>$opening_stock_qty </td>";
	
	//$row.="<td>$location_cash_sale_qty</td>";
	//$row.="<td>$location_hire_sale_qty</td>";
	//$row.="<td>$other_in</td>";
	//$row.="<td></td>";
	//$row.="<td>$cl_balance</td>";
	$row.="</tr>";
	
	//"","","","",
	//$row="'1','2','3','4'";
	//$item_tot_qty=1; || $location_issue_return_qty!=0
	//echo "warehouse_opening_stock:$warehouse_opening_stock";
	$display=false;
	
//	echo "Test:".($show_all);
	
	if($show_all=='true'){
	if($warehosue_balance!=0 || $warehouse_opening_stock!=0 || $purchased_qty!=0 || $sold_qty!=0 || $location_issue_qty!=0 || $location_issue_return_qty!=0 || $location_cash_sale_qty!=0 || $location_hire_sale_qty!=0 || $ser_issue!=0 || $ser_issue_rtn!=0 || $st_adj!=0){
		$display=true;
	}
	}else{
		if($purchased_qty!=0 || $sold_qty!=0 || $location_issue_qty!=0 || $location_issue_return_qty!=0 || $location_cash_sale_qty!=0 || $location_hire_sale_qty!=0 || $ser_issue!=0 || $ser_issue_rtn!=0 || $st_adj!=0 || $exchange_qty!=''){
		$display=true;
	}
	}
	
	//$display=false;
	
	//$display=true; //test 
	
	
	
	if($display)
	{
	echo json_encode(array("row"=>$row));
	}else{
		echo json_encode(array("row"=>''));
	}
	}

    public function payments() {
        $data['main_menu_name'] = 'reports';
        $data['sub_menu_name'] = 'reports/payments';
        $service_type = $this->uri->segment('3');
        $data['service_type'] = $service_type;
        $pageName = '';
		$data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info(1);
        $data['pageName'] = $pageName;
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        //$data['vehicle_list'] = $this->Vehicle_Model->get_all_vehicle();
        $this->load->view('rep_payments', $data);
    }

    public function get_list_payments_for_report() {

        $data = array();
        //print_r($values);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $srh_type = $this->input->post('srh_type');
        $srh_payment_term = $this->input->post('srh_payment_term');
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }


        $values = $this->Sales_Model->getPaymentsForPrint($srh_warehouse_id, $srh_to_date, $srh_from_date, $srh_type, $srh_payment_term);

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
                $row[] = $users->user_first_name;
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
            $srh_to_date = date('Y-m-d H:i:s', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d H:i:s', strtotime($this->input->post('srh_from_date')));
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
                    $nestedData[] = number_format($row['grand_total'] - $total_paid_amount, 2, '.', '');
                    $data[] = $nestedData;
                }
            } else {
                $nestedData = array();
                $id = $row['id'];
                $nestedData[] = display_date_time_format($row['date']);
                $nestedData[] = $row['reference_no'];
                $nestedData[] = $row['supp_company_name'];
                $nestedData[] = $pay_st;
                $nestedData[] = number_format($row['grand_total'], 2, '.', '');
                $nestedData[] = number_format($total_paid_amount, 2, '.', '');
                $nestedData[] = number_format($row['grand_total'] - $total_paid_amount, 2, '.', '');
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
            $srh_to_date = date('Y-m-d H:i:s', strtotime($this->input->get('srh_to_date')));
        }
        if ($this->input->get('srh_from_date')) {
            $srh_from_date = date('Y-m-d H:i:s', strtotime($this->input->get('srh_from_date')));
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
		$data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info(1);
        $this->load->view('rep_sales_daily', $data);
    }

    public function sales() {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'sales';
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['customer_list'] = $this->Customer_Model->get_all_customers();
		$data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info(1);
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
        $data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info(1);
        $data['product_list'] = $this->Product_Models->getProducts();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'products';
        $data['category_list'] = $this->category_models->getCategory();
        $this->load->view('rep_products', $data);
    }

    public function menuitem() {
        $this->load->model('Product_Models');
        $this->load->model('category_models');
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['product_list'] = $this->Product_Models->getProducts();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'menuitems';
        $data['category_list'] = $this->category_models->getCategory();
        $this->load->view('rep_menuitems', $data);
    }

    public function products_quantity() {
        $this->load->model('Product_Models');
        $this->load->model('category_models');
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['product_list'] = $this->Product_Models->getProducts();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'products_quantity';
        $data['category_list'] = $this->category_models->getCategory();
        $this->load->view('rep_products_quantity', $data);
    }

    public function supplier_products() {
        $this->load->model('Product_Models');
        $this->load->model('purchases_model');
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['product_list'] = $this->Product_Models->getProducts();
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
        $data['product_list'] = $this->Product_Models->getProducts();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'alert_quantity';
        $this->load->view('rep_alert_quantity', $data);
    }

    public function print_products() {
        $this->load->model('Product_Models');

        $data['product_list'] = $this->Product_Models->getProducts();
        $this->load->view('models/print_products', $data);
    }

    public function print_alert_quantity() {
        $this->load->model('Product_Models');

        $data['product_list'] = $this->Product_Models->getProducts();
        $this->load->view('models/print_alert_quantity', $data);
    }

    public function get_list_sales_for_print($value = '') {
        //print_r($_REQUEST);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $srh_customer_id = $this->input->post('srh_customer_id');
        $srh_payment_status = $this->input->post('srh_payment_status');
		$srh_payment_term = $this->input->post('srh_payment_term');
		$in_type = $this->input->post('in_type');
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



        $sales = $this->Sales_Model->get_all_sales_for_report($srh_warehouse_id, $srh_to_date, $srh_from_date, '', '', '', $srh_customer_id,$srh_payment_term,$in_type);
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
		
		//print_r($this->input->post());
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $cat_srh = $this->input->post('cat_srh');
        $commision_val = $this->input->post('commision');
		  $commision_val_srch = $this->input->post('commision');

        $srh_from_date = '';
        $srh_to_date = '';
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }
//echo $srh_from_date.'\n'.$srh_to_date;
        $this->load->model('Product_Models');
        $values = $this->Product_Models->getProductsForReport($srh_warehouse_id, $cat_srh);
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


                $selected_extra_menu_list = $this->Product_Models->get_booking_selected_menu_items_by_type($products->product_id, '', 'Extra');
                //print_r($selected_extra_menu_list);
                $product_cost_cal = 0;
                if (isset($selected_extra_menu_list)) {
                    foreach ($selected_extra_menu_list as $row_itm) {
                        $item_dtls = $this->Menu_Items_List_Model->get_item_info($row_itm->item_id);
                        $item_price_1 = $item_dtls['item_price_1'];
                        $bkng_itm_qty = $row_itm->bkng_itm_qty;
                        $amount_this = 0;
                        $amount_this = $bkng_itm_qty * $item_price_1;
                        $product_cost_cal = $product_cost_cal + $amount_this;
                    }
                }
                $each_product_cost = 0;
                if ($products->product_oem_part_number) {
                    $each_product_cost = $product_cost_cal / $products->product_oem_part_number;
                    $each_product_cost = number_format($each_product_cost, 2, '.', '');
                }//if(!$each_product_cost)$each_product_cost = $products->product_cost;
                //else $each_product_cost = 0;
                $switch = '';

                if ($each_product_cost > 0) {
                    //echo "-OK-";
                } else {
                    //echo "NOT OK".$each_product_cost;
                    if ($products->product_cost > 0) {
                        $each_product_cost = $products->product_cost;
                        $switch = 1; //switch - 1
                        //echo "-OK".$products->product_cost."-";
                    } else {
                        //echo "-NOT OK".$products->product_cost."-";
                        if ($products->product_price > 0) {
                            //echo "[OK :".$products->product_price."]";
                            $each_product_cost = $products->product_price;
                            $switch = 2; //switch - 2
                            //echo "[".$each_product_cost."]";
                        } else {
                            $each_product_cost = 0;
                            $switch = 3; //switch - 3
                        }
                    }
                }/*
                  if(!number_format($products->product_cost, 2, '.', '') == 0.00){
                  $each_product_cost = $products->product_cost;
                  }
                  else $each_product_cost = number_format($products->product_price, 2, '.', '');
                 */

                //$transferd_qty=$this->Transfer_Model->getTransferdQtyByWarehouseId($srh_warehouse_id,$products->product_id,$srh_from_date,$srh_to_date);
                //$transfer_reseve_qty=$this->Transfer_Model->getTransferResevedQtyByWarehouseId($srh_warehouse_id,$products->product_id,$srh_from_date,$srh_to_date);
                //$product_damaged_qty=$this->Product_Damage_Model->getProductDamagedQtyByWarehouseId($srh_warehouse_id,$products->product_id,$srh_from_date,$srh_to_date);
//echo '|'.$srh_from_date.'\n'.$srh_to_date.'|';
                $purchased_qty = $this->Purchases_Model->getPurchasedQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                $p_returned_qty = $this->Purchases_Model->getReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                $sold_qty = $this->Sales_Model->getSoldQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                $sales_return_qty = $this->Sales_Return_Model->getSalesReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);

                $product_balance = 0;
                $product_balance = $purchased_qty + $sales_return_qty - $sold_qty - $p_returned_qty;

                //$cost_price_sub_tot=$each_product_cost*$product_balance;
                $cost_price_sub_tot = $each_product_cost * $purchased_qty;

                $product_price = $products->product_price;

                $sale_price_sub_tot = $product_price * $sold_qty;
                /* echo"|";
                  print_r($products->product_price);

                  echo"|"; */
				$open = '';
				$close= '';
				//$commision_val=intval($commision_val);
				$test=$commision_val_srch;
				$commision_val=floatval($commision_val_srch);
                if ($commision_val > 0) {
                   // $test='111';
                } else{
                    $commision_val = floatval($products->product_commision);
					//$test='22';
				}
					
					
					
				
				if($products->product_commision > 0){
						$open ='<label class="btn btn-warning">';
						$close='</label>';
					}
				
                $commision = ( $commision_val * $sale_price_sub_tot ) / 100;
                $row[] = $open.$products->product_code.$close;// . "(" . $products->product_price . ")";
                $row[] = $products->product_name;// . "(" . $each_product_cost . ")";
//$row[] = $products->product_part_no;
                $row[] = $products->cat_name;//.'|'.$test;
//$row[] = $products->sub_cat_name;
                $row[] = number_format($purchased_qty, 2, '.', '');
                $row[] = number_format($p_returned_qty, 2, '.', '');
                $row[] = number_format($sold_qty, 2, '.', '');
                $row[] = number_format($sales_return_qty, 2, '.', '');
                $row[] = number_format($product_balance, 2, '.', '');
//$row[] = number_format($product_damaged_qty, 2, '.', '');
                $row[] = ":(" . $each_product_cost . "*" . $purchased_qty . ")=";
                $row[] = number_format($cost_price_sub_tot, 2, '.', ''); //$switch .  
                $row[] = "(".$product_price."*".$sold_qty.")=";
                $row[] = number_format($sale_price_sub_tot, 2, '.', ''); //
                $row[] = number_format($commision, 2, '.', '');
                $row[] = number_format($sale_price_sub_tot - $commision, 2, '.', '');
//$row[] = number_format($transfer_reseve_qty, 2, '.', ',');
                //$row[] = $transferd_qty;
                $data[] = $row;
            }

            $output = array('data' => $data);
            echo json_encode($output);
        }else {
            $output = array('data' => '');
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

                $row[] = $products->product_code;
                $row[] = $products->product_name;
                // $row[] = $products->product_part_no;
                $row[] = $products->cat_name;
                $row[] = $products->sub_cat_name;
                $tmp_qty = $purchased_qty + $transfer_reseve_qty + $sales_return_qty - $sold_qty - $transferd_qty - $product_damaged_qty;
                $row[] = number_format(($products->product_cost), 2, '.', '');
                $row[] = number_format(($products->product_price), 2, '.', '');
                $row[] = number_format($tmp_qty, 2, '.', '');
                $row[] = number_format(($products->product_cost * $tmp_qty), 2, '.', '');
                $row[] = number_format(($products->product_price * $tmp_qty), 2, '.', '');
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

        $this->load->model('Product_Models');
        $values = $this->Product_Models->getProductsForReport($srh_warehouse_id, $cat_srh);
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
                if ($balance_qty <= $products->product_alert_qty) {

                    $row[] = $products->product_code;
                    $row[] = $products->product_name;
                    $row[] = $products->product_part_no;
                    $row[] = $products->cat_name;
                    $row[] = $products->sub_cat_name;
                    $row[] = $products->product_alert_qty;
                    $row[] = $products->product_max_qty;
                    $row[] = number_format(($balance_qty), 2, '.', ',');
                    //$row[] = $transferd_qty;
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

    public function get_list_menuitem_for_print($value = '') {
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
        //  $this->load->model('Menu_Items_List_Model');
        $this->load->model('Product_Models');

        $values = $this->Menu_Items_List_Model->getMenuitemsForReport($srh_warehouse_id, $cat_srh);
        $data = array();

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


                $row = array();


                $row[] = $product->item_code;
                $row[] = $product->item_name;
                $row[] = $product->item_name_sin;
                $row[] = $product->item_name_sin;
                $row[] = $product->item_name_sin;
                $row[] = $quantity['quantity'];
                $row[] = $product->item_name_sin;
                $row[] = $product->item_name_sin;
                $row[] = $product->item_name_sin;
                $row[] = $product->item_price_1;
                $row[] = $product->item_cost;
                $row[] = $product->item_cost;

                $data[] = $row;
            }

            $output = array('data' => $data);
            echo json_encode($output);
        } else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    }

    public function menu_available_item() {
        $this->load->model('Product_Models');
        $this->load->model('category_models');
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['product_list'] = $this->Product_Models->getProducts();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'menuavailable';
        $data['category_list'] = $this->category_models->getCategory();
        $this->load->view('rep_available_menuitems', $data);
    }

    public function get_list_availablemenuitem_for_print($value = '') {
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
        //  $this->load->model('Menu_Items_List_Model');
        $this->load->model('Product_Models');

        $values = $this->Menu_Items_List_Model->getMenuitemsForReport($srh_warehouse_id, $cat_srh);
        $data = array();

        if (!empty($values)) {
            foreach ($values as $product) {
                $quantity = $this->Menu_Items_List_Model->get_item($product->item_code);
//$unit=$this->Menu_Items_List_Model->get_availableitem($product->item_code);
//$itemunit=$this->Menu_Items_List_Model->get_menu_unit_item($product->item_code);
                if ($product->item_status == 1) {
                    $k = "btn-warning";
                    $m = "fa-minus-circle";
                } else {
                    $k = "btn-green";
                    $m = "fa-check";
                }
                //$retVal = (empty($product->sub_cat_name)) ? "--:--" : $products->sub_cat_name ;

                $row = array();
                //$available=$itemunit['item_unit']-$unit['quantity'];
                $cost = $quantity['quantity'] * $product->item_price_1;
				$row[] = $product->item_code;
                $row[] = $product->item_name;
                $row[] = $product->item_name_sin;
                $row[] = $product->item_name_sin;
                $row[] = $product->item_name_sin;
                $row[] = $quantity['quantity'];
                $row[] = $product->item_name_sin;
                $row[] = $product->item_name_sin;
                $row[] = $product->item_name_sin;
                $row[] = $product->item_price_1;
                $row[] = $cost;
                $row[] = $cost;
                $data[] = $row;
            }

            $output = array('data' => $data);
            echo json_encode($output);
        } else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    }

	public function customer() {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'customer';
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['customer_list'] = $this->Customer_Model->get_all_customers();
		$data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info(1);
        $this->load->view('rep_customers', $data);
    }

	function category_summary(){
		$data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'cat_sum';
		$data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info(1);
		$this->load->model('category_models');
		$data['category_list'] = $this->category_models->getCategory();
		
		 $this->load->view('rep_cat_summary', $data);
		}
			
	function products_by_category(){
		
		
		//print_r($this->input->post());
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
        $cat_srh = $this->input->post('cat_srh');
        $commision_val = $this->input->post('commision');
		  $commision_val_srch = $this->input->post('commision');

        $srh_from_date = '';
        $srh_to_date = '';
        if ($this->input->post('srh_to_date')) {
            $srh_to_date = date('Y-m-d 23:59:59', strtotime($this->input->post('srh_to_date')));
        }
        if ($this->input->post('srh_from_date')) {
            $srh_from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('srh_from_date')));
        }
//echo $srh_from_date.'\n'.$srh_to_date;
        $this->load->model('Product_Models');
        $values = $this->Product_Models->getProductsForReport($srh_warehouse_id, $cat_srh);
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


                $selected_extra_menu_list = $this->Product_Models->get_booking_selected_menu_items_by_type($products->product_id, '', 'Extra');
                //print_r($selected_extra_menu_list);
                $product_cost_cal = 0;
                if (isset($selected_extra_menu_list)) {
                    foreach ($selected_extra_menu_list as $row_itm) {
                        $item_dtls = $this->Menu_Items_List_Model->get_item_info($row_itm->item_id);
                        $item_price_1 = $item_dtls['item_price_1'];
                        $bkng_itm_qty = $row_itm->bkng_itm_qty;
                        $amount_this = 0;
                        $amount_this = $bkng_itm_qty * $item_price_1;
                        $product_cost_cal = $product_cost_cal + $amount_this;
                    }
                }
                $each_product_cost = 0;
                if ($products->product_oem_part_number) {
                    $each_product_cost = $product_cost_cal / $products->product_oem_part_number;
                    $each_product_cost = number_format($each_product_cost, 2, '.', '');
                }//if(!$each_product_cost)$each_product_cost = $products->product_cost;
                //else $each_product_cost = 0;
                $switch = '';

                if ($each_product_cost > 0) {
                    //echo "-OK-";
                } else {
                    //echo "NOT OK".$each_product_cost;
                    if ($products->product_cost > 0) {
                        $each_product_cost = $products->product_cost;
                        $switch = 1; //switch - 1
                        //echo "-OK".$products->product_cost."-";
                    } else {
                        //echo "-NOT OK".$products->product_cost."-";
                        if ($products->product_price > 0) {
                            //echo "[OK :".$products->product_price."]";
                            $each_product_cost = $products->product_price;
                            $switch = 2; //switch - 2
                            //echo "[".$each_product_cost."]";
                        } else {
                            $each_product_cost = 0;
                            $switch = 3; //switch - 3
                        }
                    }
                }
				$purchased_qty = $this->Purchases_Model->getPurchasedQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                $p_returned_qty = $this->Purchases_Model->getReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
				                
				$sales = $this->Sales_Model->get_sold_qty_and_amount($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
                $sold_qty =  $sales->quantity;
				$sale_amount=$sales->sale_total;
				
				$total_sales_amount = $this->Sales_Model->get_total_sales($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);
				
				$sale_p = ($sale_amount / $total_sales_amount) *100;
				//print_r($sold_qty);

				
				
				//$sales_return_qty = $this->Sales_Return_Model->getSalesReturnQtyByWarehouseId($srh_warehouse_id, $products->product_id, $srh_from_date, $srh_to_date);

                //$product_balance = 0;
                //$product_balance = $purchased_qty + $sales_return_qty - $sold_qty - $p_returned_qty;

                //$cost_price_sub_tot=$each_product_cost*$product_balance;
                $cost_price_sub_tot = $each_product_cost * $sold_qty;

                $product_price = $products->product_price;

                $sale_price_sub_tot = $product_price * $sold_qty;
                /* echo"|";
                  print_r($products->product_price);

                  echo"|"; */
				$open = '';
				$close= '';
				//$commision_val=intval($commision_val);
				$test=$commision_val_srch;
				$commision_val=floatval($commision_val_srch);
                if ($commision_val > 0) {
                   // $test='111';
                } else{
                    $commision_val = floatval($products->product_commision);
					//$test='22';
				}
					
					
					
				
				if($products->product_commision > 0){
						$open ='<label class="btn btn-warning">';
						$close='</label>';
					}
				
                $commision = ( $commision_val * $sale_price_sub_tot ) / 100;
                
                $row[] = $products->product_name;// . "(" . $each_product_cost . ")";
				$row[] = $open.$products->product_code.$close;// . "(" . $products->product_price . ")";
				$row[] = number_format($sold_qty, 2, '.', '');
                $row[] = number_format($sale_amount, 2, '.', '');
				$row[] = number_format($sale_p, 2, '.', '').'%';
				$row[] = number_format($cost_price_sub_tot, 2, '.', '');
				$row[] = number_format($sale_amount - $cost_price_sub_tot, 2, '.', '');
				if($cost_price_sub_tot>0)
				$row[] = number_format((($sale_amount - $cost_price_sub_tot)/$cost_price_sub_tot)*100, 2, '.', '').'%';
				else 
				$row[] = '0%';
				
				/*
				$row[] = number_format($purchased_qty, 2, '.', '');
                $row[] = number_format($p_returned_qty, 2, '.', '');
                
                $row[] = number_format($sales_return_qty, 2, '.', '');
                $row[] = number_format($product_balance, 2, '.', '');
//$row[] = number_format($product_damaged_qty, 2, '.', '');
                $row[] = ":(" . $each_product_cost . "*" . $purchased_qty . ")=";
                $row[] = number_format($cost_price_sub_tot, 2, '.', ''); //$switch .  
                $row[] = "(".$product_price."*".$sold_qty.")=";
                $row[] = number_format($sale_price_sub_tot, 2, '.', ''); //
                $row[] = number_format($commision, 2, '.', '');
                $row[] = number_format($sale_price_sub_tot - $commision, 2, '.', '');*/
//$row[] = number_format($transfer_reseve_qty, 2, '.', ',');
                //$row[] = $transferd_qty;
                $data[] = $row;
            }

            $output = array('data' => $data);
            echo json_encode($output);
        }else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    
		}

}
