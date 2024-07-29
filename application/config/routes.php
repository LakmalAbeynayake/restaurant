<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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
|    example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|    http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|    $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|    $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller']         = 'login';
$route['404_override']               = '';
$route['Dashboard']                  = 'dashboard';
$route['system_settings/categories'] = 'product_category';

$route['system_settings/menu_items_list'] = 'menu_item';

//suppliers
$route['suppliers']                 = 'suppliers';
$route['suppliers/insert_supplier'] = 'suppliers/insert_supplier';
$route['suppliers/create_supplier'] = 'suppliers/create_supplier';
$route['suppliers/delete']          = 'suppliers/delete_supplier';
$route['suppliers/disable']         = 'suppliers/disable_supplier';
$route['suppliers/enable']          = 'suppliers/enable_supplier';
$route['suppliers/list_supplier']   = 'suppliers/list_supplier';
$route['suppliers/save_supplier']   = 'suppliers/save_supplier';

//locations
$route['locations']                 = 'locations';
$route['locations/insert_location'] = 'locations/insert_location';
$route['locations/create_location'] = 'locations/create_location';
$route['locations/delete']          = 'locations/delete_location';
$route['locations/disable']         = 'locations/disable_location';
$route['locations/enable']          = 'locations/enable_location';
$route['locations/save_location']   = 'locations/save_location';
$route['locations/list_location']   = 'locations/list_location';

//warehouse
$route['warehouse'] = 'warehouse';

//unit
$route['unit']             = 'unit';
$route['unit/add_unit']    = 'unit/add_unit';
$route['unit/create_unit'] = 'unit/create_unit';
$route['unit/delete']      = 'unit/delete_unit';
$route['unit/disable']     = 'unit/disable_unit';
$route['unit/enable']      = 'unit/enable_unit';
$route['unit/save_unit']   = 'unit/save_unit';
$route['unit/list_unit']   = 'unit/list_unit';
$route['logout']           = 'users/logout';


$route['customers']    = 'customers';
$route['products']     = 'products';
$route['products/add'] = 'products/add_product';
$route['users']        = 'users';
$route['users/create'] = 'users/create_user';
$route['users/edit']   = 'users/edit_user';

$route['purchases/add/(:any)']  = 'purchases/add_purchases/$1';
$route['notifications']         = 'notifications';
$route['system_settings']       = 'system_settings';
$route['purchases/view/(:num)'] = 'purchases/purchases_details/$1';



$route['service']                 = 'service';
$route['service/manage/(:any)']   = 'service/service_add/$1';
$route['service/details/(:any)']  = 'service/service_details/$1';
$route['service/payments/(:any)'] = 'service/loan_payments/$1';


//sales
$route['sales']             = 'sales';
$route['sales/add/(:any)']  = 'sales/add_sales/$1';
$route['sales/save_sales']  = 'sales/save_sales';
$route['sales/view/(:num)'] = 'sales/view/$1';


//quotations
$route['quotations']             = 'quotations';
$route['quotations/add']         = 'quotations/quotations_add';
$route['quotations/add/(:num)']  = 'quotations/quotations_add/$1';
$route['quotations/view/(:num)'] = 'quotations/view/$1';

//product damage
$route['product_damage']     = 'product_damage';
$route['product_damage/add'] = 'product_damage/product_damage_add';

//transfer
$route['transfer']             = 'transfer';
$route['transfer/add']         = 'transfer/transfer_add';
$route['transfer/add/(:num)']  = 'transfer/transfer_add/$1';
$route['transfer/view/(:num)'] = 'transfer/view/$1';

$route['kitchen/index/(:num)'] = 'kitchen/index/$1';

//sales return
$route['sales/sales_return']                = 'sales_return';
$route['sales/sales_return/add/(:num)']     = 'sales_return/sales_return_add/$1';
$route['sales/sales_return_details/(:num)'] = 'sales_return/sales_return_details/$1';

//report
$route['reports/suppliers']      = 'reports/suppliers';
$route['reports/products']       = 'reports/products';
$route['reports/sales']          = 'reports/sales';
$route['reports/grn']            = 'reports/grn';
$route['reports/user_activitie'] = 'reports/user_activitie';

//settings
$route['tax_rates']                          = 'tax_rates';
$route['backups']                            = 'backups';
$route['system_settings/permissions/(:num)'] = 'user_groups/permissions/$1';

$route["system_settings/subcategories/(:num)"] = "product_category/subcategories/$1";

$route['ingredient/details/(:num)'] = 'ingredient/ingredient_details/$1';


$route['restaurant']                  = 'restaurant/restaurant';
$route['restaurant/view/tables']      = 'restaurant/restaurant/table_screen';
$route['restaurant/chef']             = 'restaurant/restaurant/chef_screen';
$route['restaurant/view/chef_tables'] = 'restaurant/restaurant/chef_table_screen';


$route['pos/(:num)']        = 'pos/index/$1';
$route['pos/(:num)/(:num)'] = 'pos/index/$1/$1';

$route['bar']               = 'bar/index';
$route['bar/(:num)']        = 'bar/index/$1';
$route['bar/(:num)/(:num)'] = 'bar/index/$1/$1';

$route['adjustments']     = 'stock_adjesment';
$route['adjustments/add'] = 'stock_adjesment/add';

$route['adjustments/view/(:num)'] = 'stock_adjesment/view/$1';

$route['posplus/service-worker.js'] = 'posplus/service_worker';
/* End of file routes.php */
/* Location: ./application/config/routes.php */