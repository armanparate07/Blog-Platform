<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING - DAY 2 UPDATE
| -------------------------------------------------------------------------
*/

$route['default_controller'] = 'auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth Routes
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['logout'] = 'auth/logout';

// Posts Routes
$route['posts'] = 'posts/index';
$route['posts/view/(:num)'] = 'posts/view/$1';
$route['posts/create'] = 'posts/create';
$route['posts/edit/(:num)'] = 'posts/edit/$1';
$route['posts/delete/(:num)'] = 'posts/delete/$1';

// Admin Routes
$route['admin'] = 'admin/index';
$route['admin/pending_posts'] = 'admin/pending_posts';
$route['admin/approve_post/(:num)'] = 'admin/approve_post/$1';
$route['admin/reject_post/(:num)'] = 'admin/reject_post/$1';
$route['admin/delete_post/(:num)'] = 'admin/delete_post/$1';

// Category Routes
$route['categories'] = 'categories/index';
$route['categories/create'] = 'categories/create';
$route['categories/edit/(:num)'] = 'categories/edit/$1';
$route['categories/delete/(:num)'] = 'categories/delete/$1';

// Comment Routes
$route['comments/add/(:num)'] = 'comments/add/$1';
$route['comments/delete/(:num)'] = 'comments/delete/$1';
