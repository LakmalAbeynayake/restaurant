 <?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Ingredient extends CI_Controller
{
    var $main_menu_name = "ingredient";
    var $sub_menu_name = "categories";
    function __construct()
    {
        parent::__construct();
        $this->load->model('purchases_model');
        $this->load->model('common_model');
        $this->load->model('Sequerty_Model');
        $this->load->library('form_validation');
        $this->load->model('User_Model');
        $this->load->model('Ingredient_Grn_Model');
    }
    public function index($e = 0)
    {
        //if (!$this->User_Model->is_logged_in_k()) {
        //$this->User_Model->checkLoginPanel_k();
        //}
        $data['error']          = $e;
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = "list_purchases";
        $this->load->view('ingredient_grn', $data);
    }
    public function get_list_ingredient($value = '')
    {
        $values = $this->Ingredient_Grn_Model->getpurchases();
        $data   = array();
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
                $row    = array();
                $row[]  = $purchases->date;
                $row[]  = $purchases->reference_no;
                $row[]  = $purchases->supp_company_name;
                $row[]  = $purchases->supp_invocie_no;
                $row[]  = number_format($purchases->grand_total, 2, '.', ',');
                $row[]  = number_format($purchases->grn_total_paid, 2, '.', ',');
                $row[]  = number_format($purchases->grand_total - $purchases->grn_total_paid, 2, '.', ',');
                $row[]  = $pay_st;
                $row[]  = '<div class="text-center"><div class="btn-group text-left">
                    <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                    <ul role="menu" class="dropdown-menu pull-right">
                    <li><a href="' . base_url('ingredient/details/' . $purchases->id) . '"><i class="fa fa-file-text-o"></i> GRN Details</a></li>
        <li><a onClick="fbs_click(' . $purchases->id . ')" data-toggle="modal" href="#" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-print"></i> Print GRN</a></li>
        <!--
         <li><a href="' . base_url('ingredient/print_grn_details/' . $purchases->id) . '"><i class="fa fa-file-text-o"></i> Print GRN</a></li>-->

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
    public function add_purchases()
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'add_purchases';
        $data['warehouse']      = $this->purchases_model->get_warehouse();
        $data['supplier']       = $this->purchases_model->get_supplier();
        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('supplier', 'supplier', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('purchases', $data);
            } else {
                $podate          = $this->input->post('podate');
                $reference_no    = $this->input->post('reference_no');
                $supplier        = $this->input->post('supplier');
                $discount        = $this->input->post('discount');
                $powarehouse     = $this->input->post('powarehouse');
                $note            = $this->input->post('note');
                $grand_total     = $this->input->post('hgtotal');
                $total           = $this->input->post('total');
                $order_cal_des   = $this->input->post('order_cal_des');
                $supp_invocie_no = $this->input->post('supp_invocie_no');
                $grn_header_id   = $this->purchases_model->add_grn_header($podate, $reference_no, $supplier, $discount, $powarehouse, $note, $grand_total, $total, $order_cal_des, $supp_invocie_no);
                if ($grn_header_id) {
                    $product_id_array       = $this->input->post('product_id');
                    $product_array          = $this->input->post('product');
                    $product_name_array     = $this->input->post('product_name');
                    $unit_cost_array        = $this->input->post('unit_cost');
                    $quantity_array         = $this->input->post('quantity');
                    $product_discount_array = $this->input->post('product_discount');
                    $gross_total            = $this->input->post('gross_total');
                    $sub_total              = $this->input->post('subtotal');
                    $discount_cal           = $this->input->post('discount_cal');
                    for ($i = 0; $i < count($product_array); $i++) {
                        $this->purchases_model->add_grn_list_item($product_id_array[$i], $grn_header_id, $product_array[$i], $product_name_array[$i], $unit_cost_array[$i], $quantity_array[$i], $product_discount_array[$i], $gross_total, $sub_total[$i], $discount_cal[$i]);
                        $this->common_model->add_fi_table("grn", $grn_header_id, $product_id_array[$i], $quantity_array[$i], $unit_cost_array[$i]);
                    }
                    $this->index(1);
                }
            }
        } else {
            $this->load->view('purchases', $data);
        }
    }
    public function get_product_by_code()
    {
        $emp_array             = array();
        $product_code          = $this->input->get('term');
        $get_product_all_by_id = $this->purchases_model->get_product_by_code($product_code);
        if (!empty($get_product_all_by_id)) {
            $empar = array();
            foreach ($get_product_all_by_id as $key => $value) {
                $r     = $get_product_all_by_id[$key];
                $lb    = $get_product_all_by_id[$key]->product_name;
                $label = array(
                    "id" => mt_rand(),
                    "item_id" => $get_product_all_by_id[$key]->product_id,
                    "label" => $get_product_all_by_id[$key]->product_code . ' / ' . $get_product_all_by_id[$key]->product_part_no . ' / ' . $get_product_all_by_id[$key]->product_oem_part_number . ' / ' . $get_product_all_by_id[$key]->product_name . ' / LKR.' . $get_product_all_by_id[$key]->product_cost,
                    "qty" => 1,
                    'row' => $r,
                    'value' => $get_product_all_by_id[$key]->product_name
                );
                array_push($empar, $label);
            }
            echo json_encode($empar);
        } else {
            echo '[{"id":0,"label":"No matching result found! Product might be out of stock in the selected warehouse.","value":"hg"}]';
        }
    }
    public function get_menuitem_by_code()
    {
        $emp_array             = array();
        $product_code          = $this->input->get('term');
        $get_product_all_by_id = $this->purchases_model->get_menuitem_by_code($product_code);
        if (!empty($get_product_all_by_id)) {
            $empar = array();
            foreach ($get_product_all_by_id as $key => $value) {
                $r     = $get_product_all_by_id[$key];
                $lb    = $get_product_all_by_id[$key]->item_name;
                $label = array(
                    "id" => mt_rand(),
                    "item_id" => $get_product_all_by_id[$key]->item_id,
                    "label" => $get_product_all_by_id[$key]->item_code . ' /' . $get_product_all_by_id[$key]->item_name . ' / LKR' . $get_product_all_by_id[$key]->item_price_1,
                    "qty" => 1,
                    'row' => $r,
                    'value' => $get_product_all_by_id[$key]->item_name
                );
                array_push($empar, $label);
            }
            echo json_encode($empar);
        } else {
            echo '[{"id":0,"label":"No matching result found! Product might be out of stock in the selected warehouse.","value":"hg"}]';
        }
    }
    public function ingredient_details($purchas_id = '')
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = "view_ingredient";
        $data['po_header']      = $this->Ingredient_Grn_Model->getpurchases_by_id($purchas_id);
        $data['po_middle']      = $this->Ingredient_Grn_Model->get_ingredient_data_by_id($purchas_id);
        $data['po_payment']     = $this->Ingredient_Grn_Model->get_payment_by_id($purchas_id);
        $data['po_paid_total']  = $this->purchases_model->grn_pay_total($purchas_id);
        $data['purchas_id']     = $purchas_id;
        $this->load->view('ingredient_details', $data);
    }
    public function print_grn_details()
    {
        $purchase_id             = $this->input->get('purchase_id');
        $data['ingredient_item'] = $this->Ingredient_Grn_Model->get_ingredient_item_list($purchase_id);
        $data['reference_no']    = $this->Ingredient_Grn_Model->get_ingredient_ref($purchase_id);
        $this->load->view('models/view_ingridient_grn', $data);
    }
} 