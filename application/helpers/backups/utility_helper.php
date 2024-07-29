<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('asset_url'))
{
   function asset_url($type=0)
   {
	   return base_url().'thems/';
	   
   }  
}


 	function image_url($type=0)
   {
	   return base_url().'thems/images';
	   
   }
      
?>