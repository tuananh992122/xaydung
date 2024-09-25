<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['gioi-thieu.html'] = 'home/gioi_thieu';
$route['lien-he.html'] = 'home/lienhe';

$route['tin-tuc.html'] = "news/index";
$route['tin-tuc/(:num)'] = "news/index/$1";
$route['tin-tuc'] = "news/index";

$route['dich-vu.html'] = "news/dichvu";
$route['dich-vu/(:any)/(:num)'] = "news/dichvu/$1/$2";
$route['dich-vu/(:any)'] = "news/dichvu/$1";


$route['tim-kiem'] = "home/search";
$route['tim-kiem/(:any)'] = "home/search";
$route['tim-kiem/(:any)/(:num)'] = "home/search/$2";

//tin tuc chi tiet
$route['(:any).html'] = "news/details";

$route['xadmin'] = "xadmin/home";
$route['xadmin/(:any)'] = "xadmin$1";
//Else

$route['(:any)'] = "home/index/$1";
$route['translate_uri_dashes'] = FALSE;
