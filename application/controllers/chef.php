<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class chef extends CI_Controller {
 var $main_menu_name = "people";
var $sub_menu_name = "chef";
private $table = 'chef';

public function __construct()
{
parent::__construct();       

$this->load->model('Sales_Model');
//$this->load->model('Supplier_Model');
$this->load->model('Warehouse_Model');
$this->load->model('Common_Model');
//$this->load->model('Tax_Rates_Model');
//$this->load->model('Customer_Model');
//$this->load->model('Sales_Return_Model');
//$this->load->model('User_Model');
//$this->load->model('Transfer_Model');
//$this->load->model('Purchases_Model');
//$this->load->model('Product_Damage_Model');
$this->load->model('User_Group_Model');
//$this->load->model('Purchases_Model');
$this->load->model('chef_Model');

}

//Sales list page load
/*public function index()
{

$data['sales'] = $this->Sales_Model->get_all_sales('','','');
$data['main_menu_name'] = $this->main_menu_name;
$data['sub_menu_name'] = $this->sub_menu_name;
        $this->load->view('sales',$data);
}	*/






 	



public function chef_name(){


     

$data['main_menu_name'] = $this->main_menu_name;
$data['sub_menu_name'] = "chef";
$data['sub_sub_menu_name'] = "list_chef";
$this->load->view('view_chef',$data);

}



public function load_chef(){


$requestData= $_REQUEST;


$data = array();

$search_key=$this->input->get('search');
$search_key_val=$search_key['value'];
$start=$this->input->get('start');
$length=$this->input->get('length');


$sales = $this->chef_Model->chef_details($start,$length,$search_key_val);// TAKE  DATA USING  THE MODEL
$sales_count = $this->chef_Model->chef_details('','','');

$totalData = 0;

if($search_key_val){
$sales_c = $this->chef_Model->chef_details('','',$search_key_val);
$totalData = count($sales_c);	
}else
$totalData = count($sales_count);

$totalFiltered = $totalData;  
$style ='';
if($this->session->userdata('ss_group_id') == 3)
{
$style = 'display:none';
}

foreach ($sales as $row){
$nestedData=array(); 
//$sale_id=$row['sale_id'];
//	$total_paid_amount=0;
//	$total_paid_amount=$this->Sales_Model->get_total_paid_by_sale_id($sale_id);
//	$return_tot_amt=0;
//$chief_id=$row['chief_id'];
//	$to_be_paid=$row['sale_total']-$return_tot_amt;
       // $nestedData[] = $row['id'];
//$nestedData[] = $row['sale_id'].'&nbsp;('.$row['sale_reference_no'].')';
//	$nestedData[] =display_date_time_format($row['sale_datetime']);
//$nestedData[] = $row['chief_id'];
//$nestedData[] = $row['Group_id'];
//$nestedData[] = $row['Warehouse_id'];
$nestedData[] = $row['chef_Fname'];
$nestedData[] = $row['chef_Lname'];
$nestedData[] = $row['Gender'];
$nestedData[] = $row['user_phone'];
$nestedData[] = $row['user_email'];
   $nestedData[] = $row['username'];
//$nestedData[] = $row['username'];


//$nestedData[] = $row['password'];
 //  $nestedData[] = $row['password'];

//$nestedData[] = $row['Duty_status'];
//$nestedData[] = $row['chief_status'];


$row_action = '<div class="btn-group text-left">
                            <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu pull-right">';


if($row['chef_status']==1){
$row_action.=' <li><a style="cursor: pointer;" onClick="disableUserData('.$row['chef_id'].')"><i class="fa fa-check"></i> Disable User</a></li>';
}

if($row['chef_status']==0){
$row_action.=' <li><a style="cursor: pointer;" onClick="enableUserData('.$row['chef_id'].')"><i class="glyphicon fa fa-minus-circle"></i> Enable User</a></li>';
}







                         $row_action.= '                           
<li><a href="'.base_url().'chef/create_chef/'.$row['chef_id'].'"><i class="fa fa-edit"></i> Edit User</a></li>
<li class="divider"></li>



<li><a href="'.base_url().'chef/chef_change_pw/'.$row['chef_id'].'"><i class="fa fa-pencil"></i> Change Password</a></li>

<li class="divider"></li>
<li><a style="cursor: pointer;" onClick="deleteUserData('.$row['chef_id'].')"><i class="fa fa-trash-o"></i> Delete chef</a></li>
 <li><a href="'.base_url().'chef/chef_add_item_view/'.$row['chef_id'].'"><i class="fa fa-edit"></i> Add Items</a></li>

                            </ul></div>';


$nestedData[]=$row_action;	

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

public function load_item(){


$requestData= $_REQUEST;


$data = array();

$search_key=$this->input->get('search');
$search_key_val=$search_key['value'];
$start=$this->input->get('start');
$length=$this->input->get('length');


$sales = $this->chef_Model->chef_items_details($start,$length,$search_key_val);// TAKE  DATA USING  THE MODEL
$sales_count = $this->chef_Model->chef_items_details('','','');

$totalData = 0;

if($search_key_val){
$sales_c = $this->chef_Model->chef_items_details('','',$search_key_val);
$totalData = count($sales_c);	
}else
$totalData = count($sales_count);

$totalFiltered = $totalData;  
$style ='';
if($this->session->userdata('ss_group_id') == 3)
{
$style = 'display:none';
}

foreach ($sales as $row){
$nestedData=array(); 
//$sale_id=$row['sale_id'];
//	$total_paid_amount=0;
//	$total_paid_amount=$this->Sales_Model->get_total_paid_by_sale_id($sale_id);
//	$return_tot_amt=0;
//$chief_id=$row['chief_id'];
//	$to_be_paid=$row['sale_total']-$return_tot_amt;
       // $nestedData[] = $row['id'];
//$nestedData[] = $row['sale_id'].'&nbsp;('.$row['sale_reference_no'].')';
//	$nestedData[] =display_date_time_format($row['sale_datetime']);
//$nestedData[] = $row['chief_id'];
//$nestedData[] = $row['Group_id'];
//$nestedData[] = $row['Warehouse_id'];
$nestedData[] = $row['product_id'];
$nestedData[] = $row['product_code'];
$nestedData[] = $row['product_name'];

//$nestedData[] = $row['username'];


//$nestedData[] = $row['password'];
 //  $nestedData[] = $row['password'];

//$nestedData[] = $row['Duty_status'];
//$nestedData[] = $row['chief_status'];







                         

$row_action = '<div class="btn-group text-left">
                            <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu pull-right">';


$row_action.= '                           
<li><a href="'.base_url().'chef/create_chef/'.$row['product_id'].'"><i class="fa fa-edit"></i> Select Quantity</a></li>
<li class="divider"></li>




                         </ul></div>';


$nestedData[]=$row_action;	

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




public function create_chef()
{ 
$data['main_menu_name'] = $this->main_menu_name;
$data['sub_menu_name'] = 'chef';
$data['sub_sub_menu_name'] = "create_chef";
$data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
$data['user_group_list'] = $this->User_Group_Model->get_all_user_group();

$chef_id=$this->uri->segment('3');
        if (isset($chef_id)) {
$chef_id=$chef_id;
}
else {
$chef_id='';
}



if($chef_id){

$data['chef_id']=$chef_id;
$data['type']='E';
$data['pageName']='UPDATE CHEF';
$data['btnText']='Update Chef';
$data['user_details']= $this->chef_Model->get_chef_info($chef_id);	
}

else{
$data['chef_id']='';
$data['type']='A';
$data['pageName']='ADD chef';
$data['btnText']='Add chef';
$data['user']=array();
}
//$data['country_list'] = $this->Common_Model->get_all_country();
        $this->load->view('create_chef',$data);
}


public function saves_chef()
{
$type=$this->input->post('type');

$this->load->library('form_validation'); //form validation lib
$this->form_validation->set_rules('chef_Fname', 'First Name', 'required');
if($type=='A'){
$this->form_validation->set_rules('username', 'User Name', 'required|is_unique[chef.username]');
$this->form_validation->set_rules('user_email', ' Email', 'required|is_unique[chef.user_email]');
}

if ($this->form_validation->run() == FALSE)
        {
           $st = array('user_group_status' =>0,'validation' => validation_errors());
           echo json_encode($st);
        }
        else
        {
//print_r($_POST);
   $chef_id=$this->input->post('chef_id');
//$invoice_name=$this->input->post('invoice_name');
$chef_Fname= $this->input->post('chef_Fname');
$chef_Lname= $this->input->post('chef_Lname');
$user_email= $this->input->post('user_email');
$user_phone= $this->input->post('user_phone');
$username= $this->input->post('username');
$password= $this->input->post('password');
$Gender= $this->input->post('Gender');
$Group_id= $this->input->post('Group_id');
$warehouse_id= $this->input->post('warehouse_id');
$chef_status= $this->input->post('chef_status');


if($type=='A'){
$password=$this->input->post('password');
//$password=hash('sha512', $password); 
$user_data=array(
   //'invoice_name'=>$invoice_name,
'chef_Fname'=>$chef_Fname,
'chef_Lname'=>$chef_Lname,
'user_email'=>$user_email,
'user_phone'=>$user_phone,
'username'=>$username,
'password'=>$password,
'Gender'=>$Gender,
'Group_id'=>$Group_id,

'warehouse_id'=>$warehouse_id,
'chef_status'=>1,



);
}
else {
$user_data=array(
'chef_Fname'=>$chef_Fname,
'chef_Lname'=>$chef_Lname,
'user_email'=>$user_email,
'user_phone'=>$user_phone,
'username'=>$username,
'password'=>$password,
'Gender'=>$Gender,
'Group_id'=>$Group_id,
'warehouse_id'=>$warehouse_id,

);
}



if ($this->chef_Model->saves_chef($user_data,$chef_id)) {

                        $st = array('chef_status' =>1,'validation' =>'Done!','type'=>$type);
                               echo json_encode($st);

                       } else {

                               $st = array('chef_status' =>0,'validation' =>'error occurred please contact your system administrator','type'=>$type);
                               echo json_encode($st); 
                       }	
}
//print_r($_REQUEST);
}


public function chef_change_pw(){
$data['main_menu_name'] = $this->main_menu_name;
$data['sub_menu_name'] = 'chef';

$chef_id=$this->uri->segment('3');
        if (isset($chef_id)) {
$chef_id=$chef_id;
}
else {
$chef_id='';
}
$data['chef_id']=$chef_id;
$this->load->view('chef_change_pw',$data);
}




public function chef_change_pw_submit(){
$chef_id=$this->input->post('chef_id');

$this->load->library('form_validation'); //form validation lib
// $this->form_validation->set_rules('user_password', 'Password', 'required');
// $this->form_validation->set_rules('user_password_again', ' Confirm Password', 'required');

$this->form_validation->set_rules('password','Password','required|min_length[8]|matches[user_password_again]');
$this->form_validation->set_rules('user_password_again', 'Password Confirmation', 'required|min_length[8]');


if ($this->form_validation->run() == FALSE)
        {
           $st = array('chef_status' =>0,'validation' => validation_errors());
           echo json_encode($st);
        }
        else
        {

$password= $this->input->post('password');
//$user_password_send=hash('sha512', $user_password); 
$user_data=array(
'password'=>$password,
);

if ($this->chef_Model->save_chef_pw($user_data,$chef_id)) {

                        $st = array('user_group_status' =>1,'validation' =>'Done!');
                               echo json_encode($st);

                       } else {

                               $st = array('user_group_status' =>0,'validation' =>'error occurred please contact your system administrator','type'=>$type);
                               echo json_encode($st);
                       }	
}
}






function delete_chef() {
$chef_id	= $this->input->post('chef_id');
$this->chef_Model->delete_chef($chef_id);
        if ($chef_id) {
        echo json_encode(array('id'=>$chef_id));
        } else {
        echo json_encode(array('user_group_status'=>'error'));
        }
}

function disable_user() {
$chef_id= $this->input->post('chef_id');
$this->chef_Model->disable_user($chef_id);
        if ($chef_id) {
        echo json_encode(array('id'=>$chef_id));
        } else {
        echo json_encode(array('user_group_status'=>'error'));
        }
}

function enable_user() {
$chef_id	= $this->input->post('chef_id');
$this->chef_Model->enable_user($chef_id);
        if ($chef_id) {
        echo json_encode(array('id'=>$chef_id));
        } else {
        echo json_encode(array('user_group_status'=>'error'));
        }






}


public function add_items(){


     

$data['main_menu_name'] = $this->main_menu_name;
$data['sub_menu_name'] = "chef";
$data['sub_sub_menu_name'] = "add_items";
$this->load->view('chef_add_items',$data);

}

function table_screenn(){

        $data['customer_id'] = 0;
        /*$data['product_list_by_category'] = $product_list_by_category;
        $data['sub_category']  = $this->Restaurant_Model->get_sub_category_by_cat_id(1);
        $data['get_customer']  = $this->Restaurant_Model->get_customer();
        $data['get_warehouse'] = $this->Restaurant_Model->get_warehouse();*/
$this->load->view('restaurant/tables/table_manage_screen',$data);
}




 public function chef_add_item_view()
    { $data['main_menu_name'] = $this->main_menu_name;
$data['sub_menu_name'] = "chef";
$data['sub_sub_menu_name'] = "chef_add_item";
//get suppliers list
//$data['suppliers'] = $this->Supplier_Model->get_all_supplier();
$data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
$data['food_categoray_list'] = $this->chef_Model->get_all_food_categoray();
//$data['chef_name_list'] = $this->chef_Model->get_chef_infossss();
//$data['customer_list'] = $this->Customer_Model->get_all_customers();
//$data['status_list'] = $this->Common_Model->get_all_status();
//print_r($data['chef_name_list']);

//$data['user_details']= $this->chef_Model->get_chef_name();	


        $chef_id=$this->uri->segment('3');
        if (isset($chef_id)) {
$chef_id=$chef_id;
}
else {
$chef_id='';
}



if($chef_id){

$data['chef_id']=$chef_id;
$data['type']='E';
$data['pageName']='UPDATE CHEF';
$data['btnText']='Update Chef';
$data['user_details']= $this->chef_Model->get_chef_info($chef_id);	
}

else{
$data['chef_id']='';
$data['type']='A';
$data['pageName']='ADD chef';
$data['btnText']='Add chef';
$data['user']=array();
}
//$data['country_list'] = $this->Common_Model->get_all_country();

        $this->load->view('add_items_chef',$data);
    }







 public function suggestions($value='')
    {
//print_r($_GET);

$term=$this->input->get('term');
$in_type=$this->input->get('t');
$data['sales'] = $this->chef_Model->get_products_suggestions($term);
$json = array();
//echo "Count:".count($data['sales']);
//print_r($data['sales']);
foreach ($data['sales'] as $row)
{
//set price
$price_tmp=0;
if($in_type=='Cash'){
$price_tmp=$row['product_price'];
}
if($in_type=='Credit'){
$price_tmp=$row['product_price'];//$price_tmp=$row['credit_salling_price'];
}
if($in_type=='Wholesale'){
$price_tmp=$row['wholesale_price'];
}

$product_name=$row['product_name'];
$product_code=$row['product_code'];
//$product_part_no=$row['product_part_no'];
//$product_oem_part_number=$row['product_oem_part_number'];
$product_id=$row['product_id'];
//$product_price=$price_tmp;
//$sendParameters="'$product_id','$product_name','$product_code','$product_price'";
//$sendParameters="$product_id,$product_name,$product_code,$product_price";
$extraName='';
//$extraName.=", Selling Price: ".number_format($product_price, 2, '.', ',');
//if($product_part_no) $extraName.=", Part No: $product_part_no";
//if($product_oem_part_number) $extraName.=", OEM Part No: $product_oem_part_number";




$json_itm=array(
//'id'=> $row['product_id'],
'product_id'=> $row['product_id'],
'product_code'=> $row['product_code'],
'product_name'=> $row['product_name'],
//'product_price'=> $price_tmp,
//'product_part_no'=> $row['product_part_no'],
//'item_cost'=> $row['product_cost'],
//'product_oem_part_number'=> $row['product_oem_part_number'],
                 'value'=> $row['product_name']." (".$row['product_code'].")",
                    'label'=> $row['product_name']." (".$row['product_code'].")$extraName"
                    );
array_push($json,$json_itm);
}	
echo json_encode($json);	
    }


public function save_chef_add_items()
{
//$sale_reference_no=$this->input->post('sale_reference_no');
// $query   = $this->Sales_Model->get_next_ref_no();
       // $result  	= $query->row();
       // $sale_reference_no	= sprintf("%05d", $result->sale_id+1);


$warehouse_id=$this->input->post('warehouse_id');
$chef_Fname=$this->input->post('chef_Fname');
$chef_id=$this->input->post('chef_id');


$sale_datetime_1=$this->input->post('sale_datetime');
$sale_datetime=date('Y-m-d H:i:s', strtotime($sale_datetime_1));
$Duty_status=$this->input->post('Duty_status');

$cat_id=$this->input->post('cat_id');
$result=$this->chef_Model->get_product_category_name($cat_id);

$cat_name=$result['cat_name'];
$product_name=$this->input->post('product_name');
$product_code=$this->input->post('product_code');
$rowCount=$this->input->post('rowCount');

$error='';
$disMsg='';
$lastid='';
$sale_id='';

if(!$error){
$data=array(
//'sale_reference_no'=>$sale_reference_no,
'warehouse_id'=>$warehouse_id,
'sale_datetime'=>$sale_datetime,
'chef_Fname'=>$chef_Fname,
'Duty_status'=>$Duty_status,
'cat_id'=>$cat_id,
'cat_name'=>$cat_name,
'product_name'=>$product_name,
'product_code'=>$product_code,
'chef_id'=>$chef_id,

);
$_insert=$this->chef_Model->save_sales($data,$sale_id);
$lastid=$this->db->insert_id();
$sale_id=$lastid;
//insert user activity
//$this->Common_Model->add_user_activitie("Added Sale, (Invoice No:$sale_reference_no)");
$disMsg='Item successfully added';

//insert sale item data
$row=$this->input->post('row');
$rowCount=$this->input->post('rowCount');
$data_item=array();
for($i=1; $i<=$rowCount; $i++){
//echo "/ $rowCount , Test:".$row[$i]['product_id'][0];
if(isset($row[$i]['product_name'][0]))
{	
$data_item=array(
//'sale_id'=>$sale_id,
'product_name'=>$row[$i]['product_name'][0],
//'quantity'=>$row[$i]['qty'][0],

);
   $this->chef_Model->save_sales_item($data_item,$lastid);
$itemid=$this->db->insert_id();
//insert user activity
//$this->Common_Model->add_user_activitie("Added Sale Item, (Id:$itemid)");

//add reford for f4 table
$type='sale';
$ref_id=$sale_id;
//$product=$row[$i]['product_id'][0];
//$quantity=$row[$i]['qty'][0];
//$unit_cost=$row[$i]['unit_price'][0];
//$this->Common_Model->add_fi_table($type,$ref_id,$product,$quantity,$unit_cost);
}
}

}else {

$disMsg='Please select these before adding any product:'.$disMsg;
}	

$this->session->set_flashdata('message', 'Sale successfully added!');

echo json_encode(array('sale_id'=>$lastid,'error'=>$error,'disMsg'=>$data_item,));
}
 



 
 public function get_avalable_product_qty(){
$product_id=$this->input->get('product_id');
$warehouse_id=$this->input->get('warehouse_id');

$data['total']=$this->chef_Model->get_avalable_product_qty($product_id,$warehouse_id);
echo json_encode(array('remmnaingQty'=>$data['total']));
}



public function chef_schdule_view(){

$data['main_menu_name'] = $this->main_menu_name;
$data['sub_menu_name'] = "chef";
$data['sub_sub_menu_name'] = "chef_schdule";
$this->load->view('chef_schdule',$data);

}




 public function chef_name_suggestions($value='')
    {
//print_r($_GET);

$term=$this->input->get('term');
$in_type=$this->input->get('t');
$data['sales'] = $this->chef_Model->get_chef_suggestions($term);
$json = array();
//echo "Count:".count($data['sales']);
//print_r($data['sales']);
foreach ($data['sales'] as $row)
{
//set price
$price_tmp=0;
if($in_type=='Cash'){
$price_tmp=$row['product_price'];
}
if($in_type=='Credit'){
$price_tmp=$row['product_price'];//$price_tmp=$row['credit_salling_price'];
}
if($in_type=='Wholesale'){
$price_tmp=$row['wholesale_price'];
}

$chef_Fname=$row['chef_Fname'];
$chef_id=$row['chef_id'];
//$product_part_no=$row['product_part_no'];
///$product_oem_part_number=$row['product_oem_part_number'];
//$product_id=$row['product_id'];
//$product_price=$price_tmp;
$sendParameters="'$chef_id','$chef_Fname'";
$sendParameters="$chef_id,$chef_Fname";
$extraName='';
//$extraName.=", Selling Price: ".number_format($product_price, 2, '.', ',');
//if($product_part_no) $extraName.=", Part No: $product_part_no";
//if($product_oem_part_number) $extraName.=", OEM Part No: $product_oem_part_number";




$json_itm=array(
//'id'=> $row['product_id'],
'chef_Fname'=> $row['chef_Fname'],
'chef_id'=> $row['chef_id'],
//'product_name'=> $row['product_name'],
//'product_price'=> $price_tmp,
//'product_part_no'=> $row['product_part_no'],
//'item_cost'=> $row['product_cost'],
//'product_oem_part_number'=> $row['product_oem_part_number'],
                 'value'=> $row['chef_Fname']." (".$row['chef_id'].")",
                    'label'=> $row['chef_Fname']." (".$row['chef_id'].")$extraName"
                    );
array_push($json,$json_itm);
}	
echo json_encode($json);	
    }









public function save_chef_schdule()
{
//$sale_reference_no=$this->input->post('sale_reference_no');
// $query   = $this->Sales_Model->get_next_ref_no();
       // $result  	= $query->row();
       // $sale_reference_no	= sprintf("%05d", $result->sale_id+1);


//$warehouse_id=$this->input->post('warehouse_id');
//$chef_Fname=$this->input->post('chef_Fname');
//$chef_id=$this->input->post('chef_id');
    
$sale_datetime_on=$this->input->post('sale_datetime_on');

$sale_datetime_on=date('Y-m-d H:i:s', strtotime($sale_datetime_on));

$sale_datetime_off=$this->input->post('sale_datetime_off');

$sale_datetime_off=date('Y-m-d H:i:s', strtotime($sale_datetime_off));
//$chef_id=$this->input->post('chef_id');

//$cat_id=$this->input->post('cat_id');
//$result=$this->chef_Model->get_product_category_name($cat_id);

//$cat_name=$result['cat_name'];
//$product_name=$this->input->post('product_name');
//$product_code=$this->input->post('product_code');
$rowCount=$this->input->post('rowCount');

$error='';
$disMsg='';
$lastid='';
$sale_id='';

if(!$error){
$data=array(
//'sale_reference_no'=>$sale_reference_no,
//'warehouse_id'=>$warehouse_id,
'on_time'=>$sale_datetime_on,
'off_time'=>$sale_datetime_off,
//'chef_Fname'=>$chef_Fname,
//'chef_id'=>$chef_id,
//'cat_id'=>$cat_id,
//'cat_name'=>$cat_name,
//'product_name'=>$product_name,
//'product_code'=>$product_code,

);
//$_insert=$this->chef_Model->save_chef_schdule($data,$sale_id);
//$lastid=$this->db->insert_id();
//$sale_id=$lastid;
//insert user activity
//$this->Common_Model->add_user_activitie("Added Sale, (Invoice No:$sale_reference_no)");
//$disMsg='schdule successfully added';

//insert sale item data
$row=$this->input->post('row');
$rowCount=$this->input->post('rowCount');
$data_item=array();
for($i=1; $i<=$rowCount; $i++){
//echo "/ $rowCount , Test:".$row[$i]['product_id'][0];
if(isset($row[$i]['chef_id'][0]))
{	
$data_item=array(
//'sale_id'=>$sale_id,
'chef_id'=>$row[$i]['chef_id'][0],
'on_time'=>$sale_datetime_on,
'off_time'=>$sale_datetime_off
//'chef_Fname'=>$row[$i]['chef_Fname'][0],


);
   $this->chef_Model->save_chef_name_for_schdule($data_item,$sale_id,$lastid);
$itemid=$this->db->insert_id();
//insert user activity
//$this->Common_Model->add_user_activitie("Added Sale Item, (Id:$itemid)");

//add reford for f4 table
$type='sale';
$ref_id=$sale_id;
$product=$row[$i]['chef_id'][0];
//$product=$row[$i]['chef_Fname'][0];

//$unit_cost=$row[$i]['unit_price'][0];
//$this->Common_Model->add_fi_table($type,$ref_id,$product,$quantity,$unit_cost);
}
}

}else {

$disMsg='Please select these before adding any product:'.$disMsg;
}	

$this->session->set_flashdata('message', 'Sale successfully added!');

echo json_encode(array('sale_id'=>$lastid,'error'=>$error,'disMsg'=>$disMsg,));
}
 




public function schdule_list() { 
      
$data['main_menu_name'] = $this->main_menu_name;
$data['sub_menu_name'] = "chef";
$data['sub_sub_menu_name'] = "schdule_list";
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
       $data['chef_list'] = $this->chef_Model->get_all_chefs();
$data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info(1);
        $this->load->view('chef_schdule_list', $data);
    }


 public function get_list_sales_for_print($value = '') {
        //print_r($_REQUEST);
        $srh_to_date = '';
        $srh_from_date = '';
        $srh_warehouse_id = $this->input->post('srh_warehouse_id');
       // $srh_chef_id = $this->input->post('srh_chef_id');
   $srh_chef_Fname = $this->input->post('srh_chef_Fname');
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



        $sales = $this->chef_Model->get_all_sales_for_report($srh_warehouse_id, $srh_to_date, $srh_from_date, '', '', '',$srh_chef_Fname);
        //echo $this->db->last_query();
        $totalData = count($sales);
        $totalFiltered = $totalData;

        foreach ($sales as $row) {
            $nestedData = array();
            $p_status = '';
            $pay_st = '';
           // $sale_id = $row['sale_id'];
            //$total_paid_amount = 0;
            //$total_paid_amount = $this->Sales_Model->get_total_paid_by_sale_id($sale_id);
            //$total_paid_amount=$row['total_paid_amount']; 

            //$return_tot_amt = 0;
           // $return_tot_amt = $this->Sales_Return_Model->get_total_return_by_sale_id($sale_id);

            //$nestedData[] = display_date_time_format($row['sale_datetime']);
           // $nestedData[] = $row['sale_reference_no'];
           //$nestedData[] = $row['cus_name'];


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
//$nestedData[] = $row['chef_id'];
$nestedData[] = $row['chef_name'];
$nestedData[] = $row['on_time'];
$nestedData[] = $row['off_time'];

//$nestedData[] = $row['chef_Fname'];
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





       
    
public function load_order_items_chef(){
//print_r($_REQUEST);

$requestData= $_REQUEST;
$chef_id = $this->input->get('chef_id');


$data = array();

$search_key=$this->input->get('search');
$search_key_val=$search_key['value'];
$start=$this->input->get('start');
$length=$this->input->get('length');


$sales = $this->chef_Model->load_sale_items($start,$length,$search_key_val,$chef_id);// TAKE  DATA USING  THE MODEL
$sales_count = $this->chef_Model->load_sale_items('','','','');

$totalData = 0;

if($search_key_val){
$sales_c = $this->chef_Model->load_sale_items('','',$search_key_val,'');
$totalData = count($sales_c);	
}else
//$totalData = count($sales_count);

$totalFiltered = $totalData;  
$style ='';
if($this->session->userdata('ss_group_id') == 3)
{
$style = 'display:none';
}

foreach ($sales as $row){
$nestedData=array(); 
//$sale_id=$row['sale_id'];
//	$total_paid_amount=0;
//	$total_paid_amount=$this->Sales_Model->get_total_paid_by_sale_id($sale_id);
//	$return_tot_amt=0;
//$chief_id=$row['chief_id'];
//	$to_be_paid=$row['sale_total']-$return_tot_amt;
       // $nestedData[] = $row['id'];
//$nestedData[] = $row['sale_id'].'&nbsp;('.$row['sale_reference_no'].')';
//	$nestedData[] =display_date_time_format($row['sale_datetime']);
//$nestedData[] = $row['chief_id'];

$nestedData[] = $row['product_name'];
$nestedData[] =  $row['quantity'];
//$nestedData[] = $row['item_status'];

if($row['item_status']=='Pending') {
$nestedData[]='<span class="label label-warning">'.$row['item_status'].'</span>'; 
}else {
$nestedData[]='<span class="label label-sm label-success">'.$row['item_status'].'</span>'; 
}

$nestedData[] = '<div class="timer well"></div><input type="hidden" value="'.$row["received_time"].'">';


if ($row['item_status']==='Pending')

{
$nestedData[] = '<a class="btn btn-danger  "  onClick=change_status('.$row['sale_id'].',"'.$row['item_status'].'",'.$row['product_id'].') >pending</a>';
}else if($row['item_status']==='Cooking'){

$nestedData[] = '<a class="btn btn-primary"  onClick=change_status('.$row['sale_id'].',"'.$row['item_status'].'",'.$row['product_id'].') >cooking</a>';

}else if($row['item_status']==='Finish'){

$nestedData[] = '<a class="btn btn-success"  onClick=change_status('.$row['sale_id'].',"'.$row['item_status'].'",'.$row['product_id'].') ><i class="fa fa-times fa fa-white"></i></a>';	
}


//$nestedData[] = $row['product_name'];


//$nestedData[] = $row['password'];
 //  $nestedData[] = $row['password'];

//$nestedData[] = $row['Duty_status'];
//$nestedData[] = $row['chief_status'];





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


    




public function category_change_status()
    {

           if($this->chef_Model->category_change_status($this->input->post('sale_id'),$this->input->post('item_status'),$this->input->post('product_id'))) {

                   $st = array('status' =>'cooking','validation' =>'Done!');
                   echo json_encode($st);

           }else {

                   $st = array('status' =>'Pending','validation' =>'error occurred please contact your system administrator');
                   echo json_encode($st);
           }
    }




}
