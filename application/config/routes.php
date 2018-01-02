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

$route['index.html'] = "frontend";
$route['news-(:any).html'] = "cms/article/$1";
$route['c_(:any).html'] = "cms/articlelist/$1";
$route['products.html']   = "product/index";
$route['products-(:any).html']   = "product/index/$1";
$route['product-(:any).html']   = "product/item/$1";

$route['web-(:any).html'] = "cms/single/$1";
$route['news.html']   = "cms/news";
$route['aboutus.html']   = "cms/aboutus";
$route['aboutus_index_(:any).html']   = "cms/aboutus/$1";

$route['contact.html']   = "cms/contact";
$route['culture.html']   = "cms/culture";

$route['backendin.html']     = "hzzadmin/backbone";
$route['backendlogin.html']     = "hzzadmin/admin/login";
$route['b_(:any)_(:any).html'] = "hzzadmin/$1/$2";

$route['default_controller'] = "frontend";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */