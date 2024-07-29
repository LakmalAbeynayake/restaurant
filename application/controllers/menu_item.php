<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class menu_item extends CI_Controller {

    var $main_menu_name = "settings";
	var $sub_menu_name = "menu_items_list";

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Purchases_Model');
		
		$this->load->model('Common_Model');
		$this->load->model('Customer_Model');
		
		$this->load->model('Menu_Items_List_Model');
		$this->load->model('Unit_Model');
		
	}
	
	//Sales list page load
	public function index()
	{
		 
		//$data['sales'] = $this->Sales_Model->get_all_sales();
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = $this->sub_menu_name;
        $this->load->view('menu_items_list',$data);
	}
	
	public function menu_items_list()
	{
		 
		//$data['sales'] = $this->Sales_Model->get_all_sales();
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = 'menu_items_list';
        $this->load->view('menu_items_list',$data);
	}	
	
	//

	
 
	
public function save_menu_item()
	{
		$item_id=$this->input->post('item_id');
		$item_name=$this->input->post('item_name');
		$item_name_sin=$this->input->post('item_name_sin');
	//	$item_code=$this->Common_Model->gen_ref_number('item_id','menu_item','ITM/');
		$item_code=$this->input->post('item_code');
		$item_price_1=$this->input->post('item_price_1');
		$item_price_2=$this->input->post('item_price_2');
		$item_image=$this->input->post('item_image');
		$type=$this->input->post('type');
		$item_type=$this->input->post('item_type');
		$item_unit=$this->input->post('item_unit');
		$item_cost=$this->input->post('item_cost');
		
		$code=$this->Menu_Items_List_Model->get_itemcode();

		$data=array(
			'item_name'=>$item_name,
			'item_name_sin'=>$item_name_sin,
			'item_code'=>$item_code,
			'item_price_1'=>$item_price_1,
			'item_price_2'=>$item_price_2,
			'item_type'=>$item_type,
			'item_unit'=>$item_unit,
			'item_cost'=>$item_cost
		);
		
		if($type=='A'){
			$_insert=$this->Menu_Items_List_Model->save_menu_item($data);
			//echo $this->db->last_query();
			$lastid=$this->db->insert_id();
			if ($lastid) {
				echo json_encode(array('id'=>$lastid,'type'=>$type));
			} else {
				echo json_encode(array('status'=>'error'));
			}
		}
		if($type=='E'){
			$this->Menu_Items_List_Model->save_menu_item($data,$item_id);
			//echo $this->db->last_query();
			echo json_encode(array('type'=>$type));
		}
		if($code==$item_code){
			$this->Menu_Items_List_Model->update_menu_item($data,$item_code);
			//echo $this->db->last_query();
			echo json_encode(array('type'=>$type));
		}
	
}

public function get_list_menu_item($value='')
	{
		
	        $values = $this->Menu_Items_List_Model->get_all_menu_items();
			//echo 'test';
			//print_r($values);
				$columns = array( 
					0 =>'item_id', 
					1 => 'item_id',
					2=> 'item_id',
					3 =>'item_id', 
					4 => 'item_id',	
				);
	        $data = array();
			$totalData = count($values);
			$totalFiltered = $totalData; 

	        if (!empty($values)) {
	            foreach ($values as $users) {
					
	            $row = array();
				$img_url='';
				if(!$users->item_image) {
					$img_url='no_image.png';
				}else {
					$img_url=$users->item_image;
				}
	              //  $row[] = '<div style="margin-bottom: 0px; width: 50px; height: 50px;" class="fileupload-new thumbnail"><img alt="" src="'.asset_url()."uploads/thumbs/".$img_url.'"></div>';
	                $row[] = $users->item_id;
	                $row[] = $users->item_code;
	                $row[] = $users->item_name;
					//if (is_avalable_link($this->session->userdata('ss_group_id'),1)) {
	                $row[] = $users->item_price_1;
					$row[] = $users->item_cost;
					//}
				
					$tmp='';
					//if($users->item_type=='Extra') $tmp='Extra'; else $tmp='Menu';
					 $row[] = $users->item_type;
										
					$actionTxtDisble='';
					$actionTxtEnable='';
					$actionTxtUpdate='';
					$actionTxtDelete='';
					$actionTxtItm='';
					//if ($this->session->userdata('ss_group_id')==2)
					{ 
					$actionTxtUpdate='<a onClick="click_menu_item_update_btn('.$users->item_id.')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="glyphicon fa fa-edit"></i></a> &nbsp;';
					}
					if($users->item_status==1){
						$actionTxtDisble = '<a class="btn btn-xs btn-green tooltips" data-placement="top" data-original-title="Disable customer" onClick="disableMenuData('.$users->item_id.')"><i class="glyphicon fa fa-check"></i></a> &nbsp;';
				}
					if($users->item_status==0){
						$actionTxtEnable = '<a class="btn btn-xs btn-warning tooltips" data-placement="top" data-original-title="Disable customer" onClick="enableMenuData('.$users->item_id.')"><i class="glyphicon fa fa-minus-circle"></i></a> &nbsp;';
				}
					$actionTxtDelete='<a class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Delete customer" onClick="deleteMenuData('.$users->item_id.')">
																		<i class="glyphicon fa fa-trash-o"></i></a>';
																		
					
				//if ($this->session->userdata('ss_group_id')==2)
					{ 
				$row[]=$actionTxtUpdate.$actionTxtDisble.$actionTxtEnable;
					}
	
	                $data[] = $row;
	            }


	            $output = array('data' =>$data);
					$json_data = array(
			//"draw"            => intval( $requestData['draw'] ),  
			"recordsTotal"    => intval( $totalData ),  
			"recordsFiltered" => intval( $totalFiltered ),
			"data"            => $data 
			);
	            echo json_encode($json_data);
	        }else{
	            $output = array('data' =>'');
	            echo json_encode($output);

	        }
	   }
	   
	

	
	public function create_menu_item()
	{
        if (isset($_GET['item_id'])) {
			$item_id=$_GET['item_id'];
		}
		else {
			$item_id='';
		}
		if($item_id){
			$data['item_id']=$item_id;
			$data['type']='E';
			$data['pageName']='UPDATE ITEM';
			$data['btnText']='Update Item';
			$data['item_list']= $this->Menu_Items_List_Model->get_item_info($item_id);	
			
			
		}
		else {
			$data['item_id']='';
			$data['type']='A';
			$data['pageName']='ADD ITEM';
			$data['btnText']='Add Item';
			$data['item_list']['item_code']=$this->Common_Model->gen_ref_number('item_id','menu_item','ITM/');
			$data['suppliyer']=array();
		}
		$data['unit_list']=$this->Unit_Model->get_all_unit();
        $this->load->view('models/create_menu_item',$data);
	}


	function delete_menu() {
		$item_id	= $this->input->post('item_id');
		$this->Menu_Items_List_Model->delete_menu($item_id);
        if ($item_id) {
        	echo json_encode(array('id'=>$item_id));
        } else {
        	echo json_encode(array('status'=>'error'));
        }
	}
	
	function disable_menu() {
		$item_id	= $this->input->post('item_id');
		$this->Menu_Items_List_Model->disable_menu($item_id);
        if ($item_id) {
        	echo json_encode(array('id'=>$item_id));
        } else {
        	echo json_encode(array('status'=>'error'));
        }
	}
	
	function enable_menu() {
		$item_id	= $this->input->post('item_id');
		$this->Menu_Items_List_Model->enable_menu($item_id);
        if ($item_id) {
        	echo json_encode(array('id'=>$item_id));
        } else {
        	echo json_encode(array('status'=>'error'));
        }
	}
	  public function add_menu_purchases()
    {
		//if (!$this->User_Model->is_logged_in_k()) {
		//	$this->User_Model->checkLoginPanel_k();
		//}
      $data['main_menu_name'] = 'categories';
      $data['sub_menu_name'] = 'add_purchases';
      //$data['warehouse'] = $this->purchases_model->get_warehouse();
     //$data['supplier'] = $this->purchases_model->get_supplier();
            
      if (isset($_POST['submit'])) {

              $this->form_validation->set_rules('supplier', 'supplier', 'required');

              if ($this->form_validation->run() == FALSE)
              {
                $this->load->view('purchases',$data);
              }
              else
              {
                $podate       = $this->input->post('podate');
                $reference_no = $this->input->post('reference_no');
                $supplier     = $this->input->post('supplier');
                $discount     = $this->input->post('discount');
                $powarehouse  = $this->input->post('powarehouse'); 
                $note         = $this->input->post('note');
                $grand_total  = $this->input->post('hgtotal');
                $total        = $this->input->post('total');
                $order_cal_des= $this->input->post('order_cal_des');
				$supp_invocie_no           = $this->input->post('supp_invocie_no');

                $grn_header_id = $this->purchases_model->add_grn_header($podate,$reference_no,$supplier,$discount, $powarehouse,$note , $grand_total,$total,$order_cal_des,$supp_invocie_no);

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
                  //echo count($product_array);
                  //die();
                  for ($i=0; $i <count($product_array); $i++) { 
                    $this->purchases_model->add_grn_list_item($product_id_array[$i], $grn_header_id,$product_array[$i], $product_name_array[$i], $unit_cost_array[$i], $quantity_array[$i], $product_discount_array[$i],$gross_total,$sub_total[$i],$discount_cal[$i]);
                    $this->common_model->add_fi_table("grn",$grn_header_id,$product_id_array[$i],$quantity_array[$i],$unit_cost_array[$i]);
                  }

                $this->index(1);

                }
              }
        }else{

            $this->load->view('purchases',$data);

        }
      
    }
}