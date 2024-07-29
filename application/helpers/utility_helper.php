<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!function_exists('display_date_time_format')) {
    function display_date_time_format($datetime)
    {
        return date('Y-m-d  H:i A', strtotime($datetime)); //$dateTime->format("d/m/y  H:i A"); 
    }
}
if (!function_exists('asset_url')) {
    function asset_url($type = 0)
    {
        return base_url() . 'thems/';
    }
}
if (!function_exists('site_date_time')) {
    function site_date_time($site_date_time)
    {
        if ($site_date_time) {
            return date('j M Y  H:i A', strtotime($site_date_time));
        }
    }
}
if (!function_exists('site_date')) {
    function site_date($date)
    {
        if ($date) {
            return date('j M Y', strtotime($date));
        }
    }
}
function image_url($type = 0)
{
    return base_url() . 'thems/images';
}
function premition($sub_menu_name)
{
    $CI =& get_instance(); //get instance, access the CI superobject
    if ($CI->session->userdata('ss_user_group_name') and $CI->session->userdata('ss_user_group_name') == 'Sale mStaff')
        return true;
}
function is_logged_in()
{
    // Get current CodeIgniter instance
    $CI =& get_instance();
    // We need to use $CI->session instead of $this->session
    $ss_user_id = $CI->session->userdata('ss_user_id');
    //echo "uid:".$user_id;
    if ($ss_user_id) {
        return true;
        //redirect(base_url(),'refresh');
    } else {
        return false;
    }
}
function in_multiarray($field, $elem, $array, $field_2, $elem_2)
{
    $top    = sizeof($array) - 1;
    $bottom = 0;
    while ($bottom <= $top) {
        if ($array[$bottom][$field] == $elem && $array[$bottom][$field_2] == $elem_2) {
            return true;
        } else if (is_array($array[$bottom][$field]))
            if (in_multiarray($elem, ($array[$bottom][$field])))
                return true;
        $bottom++;
    }
    return false;
}

function get_all_navs() {
    $CI =& get_instance();
	$nav = array();
	
	$CI->db->select('*');
	$CI->db->order_by("menu_id", "asc");
	$CI->db->where("menu_parent_id", "0");
	$CI->db->where("is_nav", "1");
	$CI->db->where("menu_status", "1");
	$nav_main_list = $CI->db->get('access_points');
	$nav_main_list = $nav_main_list->result_array();
	
	//print_r($nav_main_list);
	
	foreach($nav_main_list as $row){ //going through all navs
	
	    // check if available
	    
	    $has_access = check_permission($row['menu_id'],$CI->session->userdata( 'ss_group_id' ));
	    $has_access = 1;
	    if(!$has_access)continue;
	    
	    // end cjeck if
	    //create nav for append
	    $nav_main = array(
	        "id"=>$row['menu_id'],
	        "main_menu_name"=> $row['menu_name'],
	        "display_name"=>$row['menu_display_name'],
	        "url"=>$row['menu_url'],
	        "subs"=>""
	    );
	    $nav_sub = array();
	    $CI->db->select('*');
 		$CI->db->where("menu_parent_id", $row['menu_id']);
 		$CI->db->where("menu_status", "1");
 		$nav_sub = $CI->db->get('access_points');
 		$nav_sub = $nav_sub->result_array();
 		
 		$sub_list =array();
 		foreach($nav_sub as $row_sub){
 		    if(check_permission($row_sub['menu_id'],$CI->session->userdata( 'ss_group_id' ))){
	        }else continue;
	    
 		    $sub =array(
 		        "id"=> $row_sub["menu_id"],
 		        "display_name"=> $row_sub["menu_display_name"],
 		        "sub_menu_name"=> $row_sub["menu_name"],
 		        "url"=> $row_sub["menu_url"],
 		        );
 		    //print_r($row_sub);
 		    array_push($sub_list,$sub);
 		}
 		$nav_main["subs"]=$sub_list;
 		
 		array_push($nav,$nav_main);
 		
	}
	//echo "<pre>";
	//print_r($nav);
	return $nav;
}
function check_permission($menu_id,$group_id)
{
    $CI =& get_instance();
    $CI->db->select('*');
	$CI->db->from('access_allocation');
	$array = array('menu_id' => $menu_id, 'group_id' => $group_id, 'has_access'=> 1);
	$CI->db->where($array); 
	$query = $CI->db->get();
	if($query->num_rows())
	    return $query->row()->has_access;
	else return 0;
}

function list_menu(){
    $CI =& get_instance();
    
    $CI->db->select('*');
 	$CI->db->where("menu_status", "1");
 	$nav_sub = $CI->db->get('access_points');
 	return $nav_sub->result_array();
}
?>