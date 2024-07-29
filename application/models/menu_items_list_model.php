<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Menu_Items_List_Model extends CI_Model {
	  private $tableName = 'menu_item';



public function __construct()

   {

      parent::__construct();



   }


	//save
	function save_menu_item(&$arr,$id=false)
	{
		if (!$id)
		{
			$this->db->insert('menu_item',$arr);
			
		}else {
			$this->db->where('item_id', $id);
			return $this->db->update('menu_item',$arr);
			
		}
	}
	
	
	function save_menu_item_assign_item(&$arr,$id=false)
	{
		if (!$id)
		{
			$this->db->insert('menu_item_assign_item',$arr);
		}
	}
	

	
	function get_all_menu_items() {
		$this->db->select($this->tableName.'.*');
		$this->db->order_by("item_id", "asc");
		$this->db->where("item_id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get($this->tableName);
		return $query->result();
	}
	
	public function get_item_info($id)
	 {
		$this->db->select('*');
		$this->db->from($this->tableName);
		$this->db->where("item_id", $id);
		$this->db->order_by("item_id", "desc");
		$query = $this->db->get();
		return $query->row_array(); 
	 }

	 
	 	public function get_item_info_obj($id)
	 {
		$this->db->select('*');
		$this->db->from($this->tableName);
		$this->db->where("item_id", $id);
		$this->db->order_by("item_id", "desc");
		$query = $this->db->get();
		return $query->result(); 
	 }	 
	function get_selected_all_menu_items($menu_id) {
		$this->db->select('s.*,i.*');
		$this->db->from('menu_assign_item s');
		$this->db->join('menu_item i', 'i.item_id = s.item_id', 'left');
		$this->db->order_by("i.menu_id", "asc");
		$this->db->where("s.menu_id",$menu_id);//("id !=",$id);
		$query = $this->db->get();
		return $query->result();
	}
	
	 
	
	public function delete_menu($menu_id)
	{
		$this->db->where('menu_id', $menu_id);
		$this->db->delete($this->tableName);
	
	}
	
	public function delete_menu_assign_item($menu_id)
	{
		$this->db->where('menu_id', $menu_id);
		$this->db->delete('menu_assign_item');
	
	}
	

	public function disable_menu($menu_id)
	{
		$data = array(
			'menu_status' => 0
		);	
		$this->db->where('menu_id', $menu_id);
		$this->db->update($this->tableName, $data);
	}
	
	public function enable_menu($menu_id)
	{
		$data = array(
			'menu_status' => 1
		);	
		$this->db->where('menu_id', $menu_id);
		$this->db->update($this->tableName, $data);
		
	}

   function getMenuitemsForReport($wherehouse_id,$cat_srh)
   {
	 

	    $this->db->select($this->tableName.'.*');
		$this->db->order_by("item_code", "ASC");
		$this->db->where("item_id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get($this->tableName);
		return $query->result();
	  
  
   }
      function get_item($product_id)
{
  $this->db->select_sum('quantity');
  $this->db->from('menu_purchase_items' );
  $this->db->order_by("product_code", "ASC");
  $this->db->where('product_code',$product_id);
  $query = $this->db->get();
  return $query->row_array();
  
  }
        function get_availableitem($product_id)
{
  $this->db->select_sum('quantity');
  $this->db->from('menu_purchase_items' );
  $this->db->order_by("product_code", "ASC");
  $this->db->where('product_code',$product_id);
  $query = $this->db->get();
  return $query->row_array();
  
  }
         function get_menu_unit_item($product_id)
{
  $this->db->select_sum('item_unit');
  $this->db->from('menu_item');
  $this->db->order_by("item_code", "ASC");
  $this->db->where('item_code',$product_id);
  $query = $this->db->get();
  return $query->row_array();
  
  }
  public function get_warehouse()
  {
     $this->db->select('*');
     $this->db->from('warehouses');
     $query = $this->db->get();
     if($query->num_rows() >0)
     {
       return $query->result();
     }
     else
     {
       return false;
     }
  }
 function get_itemcode()
  {
	
  $this->db->select_sum('item_code');
  $this->db->from('menu_item');
  $this->db->order_by("item_code","ASC");
  
  $query = $this->db->get();
  return $query->row_array();
	
	
	  
  }
  function update_menu_item(&$arr,$id=false)
	{
	
			$this->db->update('menu_item',$arr);
			
		
			$this->db->where('item_code',$item_code);
			return $this->db->update('menu_item',$arr);
			
			
	}
}

