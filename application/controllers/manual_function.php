<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Manual_Function extends CI_Controller {
    var $main_menu_name = "";
	var $sub_menu_name = "";

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Colombo");
        $this->load->model('country_model');
		$this->load->model('Common_Model');
	
		$this->load->model('Purchases_Model');
		$this->load->model('Sales_Model');
		$this->load->model('Manual_Query_With_Grn_Model');
	
    }
	public function index()
	{
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = $this->sub_menu_name;	
		
		
	}

    
    public function  stock_zero(){
       echo "start"; 
    $productlist=$this->Manual_Query_With_Grn_Model->get_all_product_data();
    
   
     foreach($productlist as $p){
         
         $qty= $this->Manual_Query_With_Grn_Model->getSoldqty($p['product_id']);
         if($qty==0){
            continue; 
         }
        // $qty=($qty*-1);
        // echo $p['product_name']." - ".$qty."<br>";
        $unit_price=$p['product_cost'];
        if(!$unit_price){$unit_price=0;}
          $data_item = array(
                            'purchase_id' => 1,
                            'product_id' => $p['product_id'],
                            'product_code' => $p['product_code'],
                            'product_name' => $p['product_name'],
                            'quantity' => $qty,
                            'unit_price' => $unit_price,
                            'sub_total' => $qty*$unit_price
                        );
                        $this->Purchases_Model->save_grn_item($data_item);   
     }
     
     
    
        
    }





	


	
 
  
   
    
    
    
}