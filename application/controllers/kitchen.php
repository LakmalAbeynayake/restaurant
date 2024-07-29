<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kitchen extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		//$this->load->model('Common');
		ini_set('max_execution_time', 15);
		$this->load->model('Common_Model');
		$this->load->model('Restaurant_Model');
		$this->load->model('Chef_Model');
		$this->load->model('pos_model');
		
		
	}
	
	public function index($loc)
	{
		$data['main_menu_name'] = '';	
		$data['sub_menu_name'] = '';
		$data['location_id'] = $loc;
		$this->load->view('posplus/kitchen_screen', $data);
	}
	function kitchen_screen_details()
    {
        return false;
        $sales     = $this->Restaurant_Model->get_all_sales_for_kitchen();
        $data          = array();
        if (!empty($sales)) {
            foreach ($sales as $row) {
                $nestedData = array();
                
				$floor_name = '';
				$area_name = '';
				$table_name = '';
				$type_name	= '';
				$floor_id	 = '';//$row['floor_id'];
				$division_id = '';//$row['division_id'];
				
				if($floor_id == 1){
					$floor_name	= 'BAR';
					if($division_id == 1){
					$area_name	= 'MAIN BAR';
					}else
					if($division_id == 2){
					$area_name	= 'BLUE LOUNGE';
					}
				}
				if($floor_id == 2){
					//$floor_name	= '<div class=\"label col-xs-12\"  style="text-align:center; padding:15px; border-radius:5px; color:black; font-weight:bold; font-size:25px; background-color:#FCF49C;"> RESTAURANT </div>';
					$floor_name	= 'RESTAURANT';
					$area_name	= 'RESTAURANT';
					$type_name	= 'rest';
					}
				
				$dine_type = $row['dine_type'];
				$dine_type_name = '';
				if($dine_type == 1)$dine_type_name = 'DINE IN';
				if($dine_type == 2)$dine_type_name = 'TAKE AWAY';
				if($dine_type == 3)$dine_type_name = 'DELIVERY';
				
				$table_name	 = 'Table '.$row['table_id'];
				if($row['table_id'] == 0)$table_name = 'no table';
				$sale_id           = $row['sale_id'];
                $sale_items        = $this->Restaurant_Model->get_sale_items_by_sale_id_for_kitchen($row['kot_id']);
                $si                = '<table class="table table-condensed dataTable" style="background-color: inherit; ">';
				$si = $si . '<tr><td class="col-xs-6 text-center" style="border-top: none;">ITEM</td><td class="col-xs-1" style="border-top: none;">QTY</td><td class="col-xs-1 text-center" style="border-top: none;">STATUS</td><td class="col-xs-1 text-center" style="border-top: none;">ACTION</td></tr>';
                for ($i = 0; $i < count($sale_items); $i++) { //print_r($sale_items[$i]);
					$item_status = $sale_items[$i]['item_status'];
					$status_label ='';
					$status_update_button = '';
					$btn_cook          = '<div align="center" class"col-xs-12">
                                        <div class="label label-warning col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px" onClick ="change_status(' . $row['kot_id'] . ',\'Cooking\',\' '.$type_name.' \') "> COOK </div>
                                        </div>';
					$btn_completed     = '<div align="center" class"col-xs-12">
                                        <div class="label label-success col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px" onClick ="change_status(' . $row['kot_id'] . ',\'Cooked\'),\' '.$type_name.' \' "> FINISH </div>
                                        </div>';
					if($item_status == 'Cooked'){
						$status_label = "<div class=\"label label-success col-xs-12\" style=\"border-radius:0\" >$item_status</div>";
						$status_update_button = '<span class="text-center">-</span>';
					}else
					if($item_status == 'Pending'){
						$status_label = "<div class=\"label label-danger col-xs-12\" style=\"border-radius:0\" >$item_status</div>";
						$status_update_button = $btn_cook;
					}else
                    if($item_status == 'Cooking'){
						$status_label = "<div class=\"label label-success col-xs-12\" style=\"border-radius:0\">$item_status</div>";
						$status_update_button = $btn_completed;
					}
					
					
					$si = $si . '<tr><td class="col-xs-6">' . $sale_items[$i]['product_name'] . '</td><td class="col-xs-1">' . intval($sale_items[$i]['quantity']).'</td><td class="col-xs-1">' .$status_label.'</td><td class="col-xs-1">'.$status_update_button.' </td></tr>';
                }
                $si = $si . '</table>
				';
				
                $nestedData[] = $row['kot_ref_no'];
				$nestedData[] = $dine_type_name;
                $nestedData[] = display_date_time_format( date('H:i:s',strtotime($row['system_date_time'])) ) ; //print_r($nestedData);
                //$nestedData[] = $row['cus_name'];
				$nestedData[] = $floor_name;
				$nestedData[] = $area_name;
				$nestedData[] = $table_name;
                $nestedData[] = $si;
                
                /*                
                $actionTxtDisble      = '';
                $actionTxtEnable      = '';
                $actionTxtUpdate      = '';
                $actionTxtDelete      = '';
                $url                  = base_url("sales/sale_details?sale_id=$sale_id");
                $actionTxtUpdate      = '<a onClick="fbs_click(' . $row['sale_id'] . ')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="clip-zoom-in-2"></i></a> &nbsp;';
                $actionTxtViewDetails = '<a href="' . base_url() . 'sales/view/' . $sale_id . '" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-file-text-o"></i></a> &nbsp;';
                */
                
                $nestedData[] = '<div class="label label-success col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px" onclick="print_kot('.$row['kot_id'].') ">Print K.O.T</div>
				<div class="label label-warning col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px" onclick="complete_sale_cook('.$row['kot_id'].') ,\' '.$type_name.' \' ">Finish Job</div>
				';
				//$nestedData[] = '';
				//$nestedData[] = '';
				//$nestedData[] = '';
                
//                $nestedData[] = $btn;
                
                
                $data[] = $nestedData;
            }
            
            $json_data = array(
                //"recordsTotal" => intval($totalData),
                //"recordsFiltered" => intval($totalFiltered),
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
	function change_status()
    {
        $sale_id = $this->input->post('id');
        $status = $this->input->post('status');
		$type = $this->input->post('status');
        $result  = $this->Restaurant_Model->update_status($sale_id, $status,$type);
        return $result;
    }
	function table_screen(){
		
        $data['customer_id'] = 0;
        /*$data['product_list_by_category'] = $product_list_by_category;
        $data['sub_category']  = $this->Restaurant_Model->get_sub_category_by_cat_id(1);
        $data['get_customer']  = $this->Restaurant_Model->get_customer();
        $data['get_warehouse'] = $this->Restaurant_Model->get_warehouse();*/
		$this->load->view('restaurant/tables/table_manage_screen',$data);
		}
	function chef_screen(){
		
        $data['customer_id'] = 0;
        /*$data['product_list_by_category'] = $product_list_by_category;
        $data['sub_category']  = $this->Restaurant_Model->get_sub_category_by_cat_id(1);
        $data['get_customer']  = $this->Restaurant_Model->get_customer();
        $data['get_warehouse'] = $this->Restaurant_Model->get_warehouse();*/
		$this->load->view('restaurant/kot/chef_screen',$data);
	}
		
	function chef_table_screen(){

       // $data['customer_id'] = 0;
        /*$data['product_list_by_category'] = $product_list_by_category;
        $data['sub_category']  = $this->Restaurant_Model->get_sub_category_by_cat_id(1);
        $data['get_customer']  = $this->Restaurant_Model->get_customer();
        $data['get_warehouse'] = $this->Restaurant_Model->get_warehouse();*/
$data['chef_name_list'] = $this->Chef_Model->get_today_chef_name();
//$data['chef_id_list'] = $this->chef_Model->get_chef_infossss();

//print_r($data['chef_name_list']);
$this->load->view('restaurant/tables/chef_table_mange_screen',$data);
}
	function list_kot()
    {
        $dine_type     	= $this->input->get('dine_type');
        $sale_status 	= $search_key['sale_status'];
        $sale_id		= $this->input->get('sale_id');
        $cus_id			= $this->input->get('cus_id');
        
        
		$sales     = $this->Restaurant_Model->get_all_sales($dine_type , $sale_status , $sale_id , $cus_id);
        
		if (!empty($sales)) {
            foreach ($sales as $row) {
                //print_r($row['sale_id']);
                $nestedData = array();
                
                $sale_id           = $row['sale_id'];
                $sale_items        = $this->Restaurant_Model->get_sale_items_by_sale_id($sale_id);
                $si                = '<table class="table table-condensed dataTable">';
                for ($i = 0; $i < count($sale_items); $i++) { //print_r($sale_items[$i]);
                    $si = $si . '<tr><td class="col-xs-11">' . $sale_items[$i]['product_name'] . '</td><td class="col-xs-1"> ' . intval($sale_items[$i]['quantity']) . '' . '</td></tr>';
                }
                $si = $si . '</table>';
                
                $nestedData[] = $row['sale_reference_no'];
                $nestedData[] = /*display_time_format(*/ $row['sale_datetime'] /*)*/ ; //print_r($nestedData);
                $nestedData[] = $row['cus_name'];
                $nestedData[] = $si;
                $nestedData[] = '<center>' . $pay_st . '</center>';
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
	
	function complete_sale_cook()
    {
        $sale_id = $this->input->post('sale_id');
        $status = $this->input->post('status');
		$type = $this->input->post('type');
		
		$data=array(
		    'kot_status'=>2,
		    'finish_by'=>$this->session->userdata('ss_user_id'),
		    'finish_on'=>date("Y-m-d h:i:s")
		    );
		
        $t       = $this->Restaurant_Model->update_kot_master($sale_id,$data);
        //print_r($t);
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
/*	public function get_all_country(){
		$data['country_list'] = $this->Cupplier_Model->get_all_country();
	}

	public function get_all_status(){
		$data['status_list'] = $this->Common_Model->get_all_status();
	}	

	*/

}