<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] 			= 	'login';
$route['404_override'] 					= 	'';
$route['Dashboard'] 					=	'dashboard';
$route['system_settings/categories']	=	'product_category';

//suppliers
$route['suppliers']						=	'suppliers';
$route['suppliers/insert_supplier']		=	'suppliers/insert_supplier';
$route['suppliers/create_supplier']		=	'suppliers/create_supplier';
$route['suppliers/delete']				=	'suppliers/delete_supplier';
$route['suppliers/disable']				=	'suppliers/disable_supplier';
$route['suppliers/enable']				=	'suppliers/enable_supplier';
$route['suppliers/list_supplier']		=	'suppliers/list_supplier';
$route['suppliers/save_supplier']		=	'suppliers/save_supplier';

//locations
$route['locations']						=	'locations';
$route['locations/insert_location']		=	'locations/insert_location';
$route['locations/create_location']		=	'locations/create_location';
$route['locations/delete']				=	'locations/delete_location';
$route['locations/disable']				=	'locations/disable_location';
$route['locations/enable']				=	'locations/enable_location';
$route['locations/save_location']		=	'locations/save_location';
$route['locations/list_location']		=	'locations/list_location';

//warehouse
$route['warehouse']						    =	'warehouse';

//unit
$route['unit']						    =	'unit';
$route['unit/add_unit']				    =	'unit/add_unit';
$route['unit/create_unit']			    =	'unit/create_unit';
$route['unit/delete']				    =	'unit/delete_unit';
$route['unit/disable']				    =	'unit/disable_unit';
$route['unit/enable']				    =	'unit/enable_unit';
$route['unit/save_unit']			    =	'unit/save_unit';
$route['unit/list_unit']			    =	'unit/list_unit';
$route['logout']			            =	'users/logout';


$route['customers']						=	'customers';
$route['products']						=	'products';
$route['products/add']					=	'products/add_product';
$route['users']							=	'users';
$route['users/create']					=	'users/create_user';
$route['users/edit']					=	'users/edit_user';

$route['purchases/add'] 				=	'purchases/add_purchases';
$route['notifications'] 				=	'notifications';
$route['system_settings'] 				=	'system_settings';
$route['purchases/view/(:num)'] 		=	'purchases/purchases_details/$1';



//sales
$route['sales'] 					    =	'sales';
$route['sales/add'] 				    =	'sales/add_sales';
$route['sales/save_sales'] 			    =	'sales/save_sales';
$route['sales/view'] 				    =	'sales/view';

//report
$route['reports/suppliers'] 				    =	'reports/suppliers';
$route['reports/products'] 				    =	'reports/products';
$route['reports/sales'] 				    =	'reports/sales';
$route['reports/grn'] 				    =	'reports/grn';

//settings
$route['tax_rates'] 					=	'tax_rates';
$route['backups'] 						=	'backups';
$route['system_settings/user_groups'] 	=	'user_groups';
$route['system_settings/permissions/(:num)'] 	=	'user_groups/permissions/$1';

$route["system_settings/subcategories/(:num)"] = "product_category/subcategories/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */