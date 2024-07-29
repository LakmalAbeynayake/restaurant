<?php
class Purchases_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }
    public function getPurchasedQtyByWarehouseIdAndDateRange($location_id = '', $product_id = '', $srh_from_date = '', $srh_to_date = '')
    {
        $this->db->select_sum('pi.quantity');
        $this->db->from('purchase_items pi');
        $this->db->join('purchases p', 'p.id = pi.purchase_id', 'left');
        if ($location_id) {
            $this->db->where('p.location_id', $location_id);
        }
        if ($product_id) {
            $this->db->where('pi.product_id', $product_id);
        }
        if ($srh_from_date) {
            $srh_from_date = date('Y-m-d', strtotime($srh_from_date));
            $this->db->where("date(p.date) >=", $srh_from_date); //("id !=",$id);
        }
        if ($srh_to_date) {
            $srh_to_date = date('Y-m-d', strtotime($srh_to_date));
            $this->db->where("date(p.date) <=", $srh_to_date); //("id !=",$id);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $data['quantity'] = $query->row()->quantity;
    }
    public function getPurchaseRTNdQtyByWarehouseIdAndDateRange($location_id = '', $product_id = '', $srh_from_date = '', $srh_to_date = '')
    {
        $this->db->select_sum('pri.pur_rtn_itm_quantity');
        $this->db->from('purchase_return_items pri');
        $this->db->join('purchase_return pr', 'pri.pur_rtn_id = pr.pur_rtn_id', 'left');
        if ($location_id) {
            $this->db->where('pr.location_id', $location_id);
        }
        if ($product_id) {
            $this->db->where('pri.product_id', $product_id);
        }
        if ($srh_from_date) {
            $srh_from_date = date('Y-m-d', strtotime($srh_from_date));
            $this->db->where("date(pr.pur_rtn_datetime) >=", $srh_from_date); //("id !=",$id);
        }
        if ($srh_to_date) {
            $srh_to_date = date('Y-m-d', strtotime($srh_to_date));
            $this->db->where("date(pr.pur_rtn_datetime) <=", $srh_to_date); //("id !=",$id);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $data['pur_rtn_itm_quantity'] = $query->row()->pur_rtn_itm_quantity;
    }
    public function get_menuitem_by_code($product_code = '')
    {
        $this->db->select('p.*');
        $this->db->from('menu_item p');
        $this->db->like('p.item_name', $product_code);
        $this->db->or_like('p.item_code', $product_code);
        $this->db->limit('10');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_product_by_code($product_code = '')
    {
        $this->db->select('p.*');
        $this->db->from('product p');
        $this->db->like('p.product_name', $product_code);
        $this->db->or_like('p.product_code', $product_code);
        $this->db->limit('10');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getPurchasedQtyByWarehouseId_2($location_id, $product_id, $srh_from_date = '', $srh_to_date = '', $supp_id = '')
    {
        //echo '|'.$srh_from_date.'\n'.$srh_to_date.'|';
        $this->db->select_sum('pi.quantity');
        $this->db->from('purchase_items pi');
        $this->db->join('purchases p', 'p.id = pi.purchase_id', 'left');
        $this->db->where('p.location_id', $location_id);
        $this->db->where('pi.product_id', $product_id);
       
        if ($srh_to_date) {
            $srh_to_date = date('Y-m-d', strtotime($srh_from_date));
            $this->db->where("date(p.date) <=", $srh_to_date); //("id !=",$id);
        }
        if ($srh_from_date) {
            //echo $srh_from_date.'//';
            $srh_from_date = date('Y-m-d', strtotime($srh_from_date));
            $this->db->where("date(p.date) >=", $srh_from_date); //("id !=",$id);
        }
        $query = $this->db->get();
        return $data['quantity'] = $query->row()->quantity;
    }
    //get Purchased Qty By WarehouseId
    public function getPurchasedQtyByWarehouseId($location_id, $product_id, $srh_from_date = '', $srh_to_date = '')
    {
        $this->db->select_sum('pi.quantity');
        $this->db->from('purchase_items pi');
        $this->db->join('purchases p', 'p.id = pi.purchase_id', 'inner');
        $this->db->where('p.location_id', $location_id);
        $this->db->where('pi.product_id', $product_id);
        if ($srh_to_date) {
            $this->db->where("date(p.date) <=", $srh_to_date);
        }
        if ($srh_from_date) {
            $this->db->where("date(p.date) >=", $srh_from_date);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        //die;
        return $data['quantity'] = $query->row()->quantity;
    }
    //get Purchased Qty By WarehouseId
    public function getPurchasedQtyByWarehouseId_3($location_id, $product_id, $srh_from_date = '', $srh_to_date = '', $supp_id = '')
    {
        //echo '|'.$srh_from_date.'\n'.$srh_to_date.'|';
        $this->db->select_sum('pi.quantity');
        $this->db->from('purchase_items pi');
        $this->db->join('purchases p', 'p.id = pi.purchase_id', 'left');
        $this->db->where('p.location_id', $location_id);
        $this->db->where('pi.product_id', $product_id);
        if ($supp_id) {
            $this->db->where('p.supplier_id', $supp_id);
        } else {
            $this->db->where('p.supplier_id !=', 5);
        }
        if ($srh_to_date) {
            $this->db->where("p.date <=", $srh_to_date); //("id !=",$id);
        }
        if ($srh_from_date) {
            //echo $srh_from_date.'//';
            $this->db->where("p.date >=", $srh_from_date); //("id !=",$id);
        }
        $query = $this->db->get();
        //    echo $this->db->last_query();
        return $data['quantity'] = $query->row()->quantity;
    }
    function get_tax_by_id($tax_id = '')
    {
        $this->db->select('t.*');
        $this->db->from('tax_rates t');
        $this->db->where('t.id', $tax_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_warehouse()
    {
        $this->db->select('*');
        $this->db->from('locations');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_supplier()
    {
        $this->db->select('*');
        $this->db->from('supplier');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function add_grn_header($podate, $reference_no, $supplier, $discount, $powarehouse, $note, $grand_total, $total, $order_cal_des, $supp_invocie_no)
    {
        $data = array(
            'reference_no' => $reference_no,
            'location_id' => $powarehouse,
            'supplier_id' => $supplier,
            'date' => date('Y-m-d H:i', strtotime($podate)),
            'note' => $note,
            'total' => $total,
            'grand_total' => $grand_total,
            'discount' => $discount,
            'discount_cal' => $order_cal_des,
            'supp_invocie_no' => $supp_invocie_no
        );
        if ($this->db->insert('purchases', $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    public function add_pur_r_header($podate, $reference_no, $supplier, $discount, $powarehouse, $note, $grand_total, $total, $order_cal_des, $supp_invocie_no, $pur_id)
    {
        $data = array(
            'reference_no' => $reference_no,
            'location_id' => $powarehouse,
            'supplier_id' => $supplier,
            'date' => date('Y-m-d H:i', strtotime($podate)),
            'note' => $note,
            'total' => $total,
            'grand_total' => $grand_total,
            'discount' => $discount,
            'discount_cal' => $order_cal_des,
            'supp_invocie_no' => $supp_invocie_no,
            'purchase_id' => $pur_id,
        );
        if ($this->db->insert('purchases_return', $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    //Sales item save
    function save_grn_item($data_item)
    {
        $this->db->insert('purchase_items', $data_item);
    }
    function save_grn($data, $grn_id = false)
    {
        if (!$grn_id) {
            $this->db->insert('purchases', $data_item);
        } else {
            $this->db->where('id', $grn_id);
            return $this->db->update('purchases', $data);
        }
    }
    public function add_grn_list_item($data)
    {
        if ($this->db->insert('purchase_items', $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function add_grn_return_items($data)
    {
        if ($this->db->insert('purchase_return_items', $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function getpurchases($date="")
    {
        $this->db->select("s.*,spl.*");//sp.sale_pymnt_amount, SUM(sp.sale_pymnt_amount) AS grn_total_paid
        $this->db->from("purchases s");
        //$this->db->join("sale_payments sp", "s.id = sp.sale_id AND sp.sale_payment_type ='grn'", "left");
        $this->db->join("supplier spl", "spl.supp_id = s.supplier_id", "left");
        if($date)
            {
                //$this->db->where("date(date) >=",$date);
            }
        else
            $this->db->where("date(date) >=",date("Y-m")."-01");
        $this->db->group_by("s.id");
        $this->db->order_by("s.reference_no", "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getpurchases_by_id($po_id = '')
    {
        $this->db->select("p.* , sp.*,wh.id as location_id,wh.*");
        $this->db->from("purchases p");
        $this->db->join("supplier sp", " sp.supp_id = p.supplier_id", "left");
        $this->db->join("locations wh", " wh.id = p.location_id", "left");
        $this->db->where("p.id", $po_id);
        $this->db->order_by("p.reference_no", "desc");
        $this->db->group_by("p.id");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_purchese_data_by_id($po_id = '')
    {
        $this->db->select('quantity,item_cost,sub_total,discount,product.product_name,product.product_code');
        $this->db->from('purchase_items');
        $this->db->join("product", " product.product_id = purchase_items.product_id", "left");
        $this->db->where('purchase_items.purchase_id', $po_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_payment_by_id($purchase_id = '')
    {
        $this->db->select('sp.*');
        $this->db->from('sale_payments sp');
        $this->db->where('sp.sale_id', $purchase_id);
        $this->db->where('sp.sale_payment_type', 'grn');
        $query = $this->db->get();
        return $query->result();
    }
    function grn_pay_total($purchase_id = '')
    {
        $this->db->select('SUM(sp.sale_pymnt_amount) AS grn_paid_total');
        $this->db->from('sale_payments sp');
        $this->db->where('sp.sale_id', $purchase_id);
        $this->db->where('sp.sale_payment_type', 'grn');
        $query = $this->db->get();
        return $query->result();
    }
    /* sanath start*/
    public function get_all_grn_for_report($srh_location_id, $srh_to_date, $srh_from_date, $from = '', $to = '', $srh_supplier_id)
    {
        $this->db->select("s.*,spl.*, sp.sale_pymnt_amount, SUM(sp.sale_pymnt_amount) AS grn_total_paid");
        $this->db->from("purchases s");
        $this->db->join("sale_payments sp", "s.id = sp.sale_id AND sp.sale_payment_type ='grn'", "left");
        $this->db->join("supplier spl", "spl.supp_id = s.supplier_id", "left");
        $this->db->join("locations w", "w.id = s.location_id", "left");
        if ($srh_location_id) {
            $this->db->where("s.location_id", $srh_location_id); //("id !=",$id);
        }
        if ($srh_supplier_id) {
            $this->db->where("s.supplier_id", $srh_supplier_id); //("id !=",$id);
        }
        if ($srh_to_date) {
            $this->db->where("s.date <=", $srh_to_date); //("id !=",$id);
        }
        if ($srh_from_date) {
            $this->db->where("s.date >=", $srh_from_date); //("id !=",$id);
        }
        if ($to) {
            $this->db->limit($to, $from);
        }
        $this->db->group_by("s.id");
        $this->db->order_by("s.reference_no", "desc");
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result_array();
    }
    /* end sanath*/
    public function add_grn_header_r($sale_id_r, $podate, $reference_no, $supplier, $discount, $powarehouse, $note, $grand_total, $total, $order_cal_des, $supp_invocie_no, $ref_id_nxt = '')
    {
        $data = array(
            'purchase_id' => $sale_id_r,
            'reference_no' => $reference_no,
            'location_id' => $powarehouse,
            'supplier_id' => $supplier,
            'date' => date('Y-m-d', strtotime($podate)),
            'note' => $note,
            'total' => $total,
            'grand_total' => $grand_total,
            'discount' => $discount,
            'discount_cal' => $order_cal_des,
            'supp_invocie_no' => $supp_invocie_no,
            'warehouse_ret_id' => $ref_id_nxt
        );
        if ($this->db->insert('purchases_return', $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    public function add_grn_list_item_r($sale_id_r, $product_id_array, $grn_header_id, $product_array, $product_name_array, $unit_cost_array, $quantity_array, $product_discount_array, $gross_total, $sub_total, $discount_cal)
    {
        $data = array(
            'purchase_id' => $sale_id_r,
            'pr_id' => $grn_header_id,
            'product_id' => $product_id_array,
            'product_code' => $product_array,
            'product_name' => $product_name_array,
            'quantity' => $quantity_array,
            'unit_price' => $unit_cost_array,
            'sub_total' => $sub_total,
            'discount' => $product_discount_array,
            'discount_cal' => $discount_cal
        );
        if ($this->db->insert('purchase_return_items', $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function getpurchases_return($start = '', $length = '', $search_key_val = '', $srh_location_id = '', $srh_to_date = '', $srh_supplier_id = '')
    {
        $this->db->select("s.*,spl.*, sp.sale_pymnt_amount, SUM(sp.sale_pymnt_amount) AS grn_total_paid");
        $this->db->from("purchases_return s");
        $this->db->join("sale_payments sp", "s.pr_id = sp.sale_id AND sp.sale_payment_type ='grn_r'", "left");
        $this->db->join("supplier spl", "spl.supp_id = s.supplier_id", "left");
        if ($srh_location_id) {
            $this->db->where("s.location_id", $srh_location_id); //("id !=",$id);
        }
        if ($srh_supplier_id) {
            $this->db->where("s.supplier_id", $srh_supplier_id); //("id !=",$id);
        }
        if ($srh_to_date) {
            $srh_to_date = date('Y-m-d', strtotime($srh_to_date));
            $this->db->where("s.date <=", $srh_to_date); //("id !=",$id);
        }
        if ($search_key_val) {
            $this->db->where("s.pr_id LIKE '%$search_key_val%' OR s.reference_no LIKE '%$search_key_val%' ");
            /*OR spl.supp_company_name LIKE '%$search_key_val%'*/
        }
        /* $this->db->group_by("s.date");
        $this->db->order_by("s.date", "desc");
        */
        $this->db->group_by("s.pr_id");
        $this->db->order_by("s.pr_id", "desc");
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
        }
        $query = $this->db->get();
        /*echo "{";
        print_r($this->db->last_query());
        echo "}";*/
        /*      echo "{";
        print_r($query->result());
        echo "}";*/
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            //return false;
        }
    }
    public function getpurchases_return_by_id($po_id = '')
    {
        $this->db->select("p.* , sp.*,wh.id as location_id,wh.*");
        $this->db->from("purchases_return p");
        $this->db->join("supplier sp", " sp.supp_id = p.supplier_id", "left");
        $this->db->join("locations wh", " wh.id = p.location_id", "left");
        $this->db->where("p.pr_id", $po_id);
        $this->db->order_by("p.reference_no", "desc");
        $this->db->group_by("p.pr_id");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_purchese_return_data_by_id($po_id = '')
    {
        $this->db->select('pri.*,pr.product_name,pr.product_code');
        $this->db->from('purchase_return_items pri');
        $this->db->join('product pr','pri.product_id = pr.product_id','left');
        $this->db->where('pri.pr_id', $po_id);
        $query = $this->db->get();
        // print_r('<br><br><br><br><br>'.$this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_payment_by_id_r($purchase_id = '')
    {
        $this->db->select('sp.*');
        $this->db->from('sale_payments sp');
        $this->db->where('sp.sale_id', $purchase_id);
        $this->db->where('sp.sale_payment_type', 'grn_r');
        $query = $this->db->get();
        return $query->result();
    }
    function grn_pay_total_r($purchase_id = '')
    {
        $this->db->select('SUM(sp.sale_pymnt_amount) AS grn_paid_total');
        $this->db->from('sale_payments sp');
        $this->db->where('sp.sale_id', $purchase_id);
        $this->db->where('sp.sale_payment_type', 'grn_r');
        $query = $this->db->get();
        return $query->result();
    }
    public function getReturnQtyByWarehouseId($location_id, $product_id, $srh_from_date = '', $srh_to_date = '', $search_key_val = '', $cat_srh = '')
    {
        $this->db->select_sum('pi.quantity');
        $this->db->from('purchase_return_items pi');
        $this->db->join('purchases_return p', 'p.pr_id = pi.pr_id', 'left');
        $this->db->join('product pr', 'pi.product_id = pr.product_id');
        $this->db->join("product_category pc", "pr.cat_id = pc.cat_id", "left");
        if ($cat_srh) {
            $this->db->where("pc.cat_name", $cat_srh);
        }
        if ($search_key_val) {
            $this->db->where("pi.product_code LIKE '%$search_key_val%'", "left");
        }
        //        $this->db->where('p.location_id',$location_id);
        if ($product_id)
            $this->db->where('pi.product_id', $product_id);
        if ($srh_to_date) {
            //        $srh_to_date=date('Y-m-d',strtotime($srh_to_date . ""));    
            $this->db->where("date(p.date) <=", $srh_to_date); //("id !=",$id);
        }
        if ($srh_from_date) {
            $this->db->where("date(p.date) >=", $srh_from_date); //("id !=",$id);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        //return $data['quantity']=$query->row()->quantity;
        if ($query->num_rows() > 0) {
            return $data['quantity'] = $query->row()->quantity;
        } else {
            return 0;
        }
    }
    public function getReturnQtyByWarehouseId_v2($location_id, $product_id, $srh_from_date = '', $srh_to_date = '', $search_key_val = '', $cat_srh = '')
    {
        $this->db->select_sum('pi.quantity');
        $this->db->from('purchase_return_items pi');
        $this->db->join('purchases_return p', 'p.pr_id = pi.pr_id', 'left');
        
        if ($location_id)
                $this->db->where('p.location_id',$location_id);
        if ($product_id)
            $this->db->where('pi.product_id', $product_id);
        if ($srh_to_date) {
            $this->db->where("date(p.date) <=", $srh_to_date); //("id !=",$id);
        }
        if ($srh_from_date) {
            $this->db->where("date(p.date) >=", $srh_from_date); //("id !=",$id);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        //return $data['quantity']=$query->row()->quantity;
        if ($query->num_rows() > 0) {
            return $query->row()->quantity;
        } else {
            return 0;
        }
    }
    function getPaymentsForPrint_grn($srh_location_id = '', $srh_to_date = '', $srh_from_date = '', $srh_type = '', $srh_payment_term = '', $ss_user_id = '')
    {
        $location_id = '';
        $sel          = 'p.*,pur.*,s.supp_company_name';
        if ($ss_user_id)
            $sel .= ',u.user_first_name';
        $this->db->select($sel);
        $this->db->from('sale_payments p');
        $this->db->join('purchases pur', 'pur.id = p.sale_id', 'left');
        $this->db->join('locations w', 'w.id = pur.location_id', 'left');
        $this->db->join('supplier s', 's.supp_id = pur.supplier_id', 'left');
        if ($ss_user_id)
            $this->db->join('user u', 'u.user_id = p.user_id', 'left');
        if ($srh_type) {
            $this->db->where("p.sale_payment_type", $srh_type); //
        }
        if ($srh_payment_term) {
            $this->db->where("p.sale_pymnt_paying_by", $srh_payment_term); //
        }
        if ($ss_user_id) {
            $this->db->where("p.user_id", $ss_user_id); //
        }
        if ($srh_location_id) {
            $this->db->where("pur.location_id", $srh_location_id); //
        }
        $this->db->where("p.sale_payment_type", 'grn');
        if ($srh_to_date) {
            $this->db->where("p.sale_pymnt_added_date_time <=", $srh_to_date); //("id !=",$id);
        }
        if ($srh_from_date) {
            $this->db->where("p.sale_pymnt_added_date_time >=", $srh_from_date); //("id !=",$id);
        }
        $this->db->order_by("pur.id", "desc");
        $query = $this->db->get();
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            //return false;
        }
    }
    function getPaymentsForPrint_grn_return($srh_location_id = '', $srh_to_date = '', $srh_from_date = '', $srh_type = '', $srh_payment_term = '', $ss_user_id = '')
    {
        $location_id = '';
        $sel          = 'p.*,pur.*';
        if ($ss_user_id)
            $sel .= ',u.user_first_name';
        $this->db->select($sel);
        $this->db->from('sale_payments p');
        $this->db->join('purchases pur', 'pur.id = p.sale_id', 'left');
        $this->db->join('locations w', 'w.id = pur.location_id', 'left');
        //$this->db->join('customer c', 'c.cus_id = pur.customer_id', 'left');
        if ($ss_user_id)
            $this->db->join('user u', 'u.user_id = p.user_id', 'left');
        if ($srh_type) {
            $this->db->where("p.sale_payment_type", $srh_type); //
        }
        if ($srh_payment_term) {
            $this->db->where("p.sale_pymnt_paying_by", $srh_payment_term); //
        }
        if ($ss_user_id) {
            $this->db->where("p.user_id", $ss_user_id); //
        }
        if ($srh_location_id) {
            $this->db->where("pur.location_id", $srh_location_id); //
        }
        $this->db->where("p.sale_payment_type", 'grn_r');
        if ($srh_to_date) {
            $this->db->where("p.sale_pymnt_date_time <=", $srh_to_date); //("id !=",$id);
        }
        if ($srh_from_date) {
            $this->db->where("p.sale_pymnt_date_time >=", $srh_from_date); //("id !=",$id);
        }
        $this->db->order_by("pur.id", "desc");
        $query = $this->db->get();
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            //return false;
        }
    }
    /*posplus session*/
    function get_purchase_info($purchase_id){
        $this->db->select('*');
        $this->db->from('purchases');
        $this->db->where('id', $purchase_id);
        $query = $this->db->get();
        return $query->row();
    }
    function is_approved($purchase_id){
        $this->db->select('approval_status');
        $this->db->from('purchases');
        $this->db->where('id', $purchase_id);
        $query = $this->db->get();
        return $query->row()->approval_status ? false: true;
        //approval_status == 0 == false; return true; true means "not approved yet. so good to continue the approval process"
    }
    function is_return_approved($purchase_id){
        $this->db->select('approval_status');
        $this->db->from('purchases');
        $this->db->where('id', $purchase_id);
        $query = $this->db->get();
        return $query->row()->approval_status ? false: true;
        //approval_status == 0 == false; return true; true means "not approved yet. so good to continue the approval process"
    }
    function get_purchase_items($purchase_id){
        $this->db->select('product_id,quantity,item_cost');
        $this->db->from('purchase_items pi');
        $this->db->where('pi.purchase_id', $purchase_id);
        $query = $this->db->get();
        return $query->result();
    }
    function get_purchase_return_items($purchase_id){
        $this->db->select('product_id,quantity,item_cost');
        $this->db->from('purchase_return_items pi');
        $this->db->where('pi.pr_id', $purchase_id);
        $query = $this->db->get();
        return $query->result();
    }
    function approve($purchase_id){
        $data = array(
            'approved_by' => $this->session->userdata('ss_user_id'),
            'approved_on' => date('Y-m-d H:i:s'),
            'approval_status' => 1
        );
        $this->db->where('id', $purchase_id);
        $this->db->update('purchases', $data);
        return $this->db->affected_rows();
    }
}