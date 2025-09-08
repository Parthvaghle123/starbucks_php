<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::dashboard');
$routes->get('/login', 'Auth::login');
$routes->post('/loginAuth', 'Auth::loginAuth');
$routes->get('/register', 'Auth::register');
$routes->post('/store', 'Auth::store');
$routes->get('/dashboard', 'Auth::dashboard');
$routes->get('/logout', 'Auth::logout');
$routes->get('/gift', 'Home::gift');
$routes->get('/menu', 'Home::menu');
$routes->post('/checkout', 'Home::checkout');
$routes->post('manage_cart', 'Home::manage_cart');
$routes->post('update_cart', 'Home::update_cart');
$routes->get('mycart', 'Home::mycart');
$routes->get('/', 'Home::index1');
$routes->post('/place-order', 'Home::placeOrder');
$routes->get('/orders', 'Auth::orders'); // or Home::orders if used in Home controller
$routes->post('/cancelOrder', 'Home::cancelOrder');
$routes->get('download-bill/(:num)', 'OrderController::downloadBill/$1');
$routes->get('/change-password', 'Auth::changePasswordForm');
$routes->post('/verify-email', 'Auth::verifyEmail');
$routes->post('/change-password', 'Auth::updatePassword');

// Public Product API Routes
$routes->get('/api/products', 'Home::apiProducts');
$routes->get('/api/products/menu', 'Home::apiMenuProducts');
$routes->get('/api/products/gift', 'Home::apiGiftProducts');
$routes->get('/api/debug/products', 'Home::debugProducts');

// Admin Panel Routes
$routes->get('/admin', 'AdminController::index');
$routes->get('/admin/login', 'AdminController::login');
$routes->post('/admin/authenticate', 'AdminController::authenticate');
$routes->get('/admin/dashboard', 'AdminController::dashboard');
$routes->get('/admin/users', 'AdminController::users');
$routes->get('/admin/orders', 'AdminController::orders');
$routes->get('/admin/products', 'AdminController::products');
$routes->get('/admin/logout', 'AdminController::logout');

$routes->get('/admin/api/users', 'AdminController::apiUsers');
$routes->delete('/admin/api/users/delete/(:num)', 'AdminController::deleteUser/$1');
$routes->delete('/admin/api/users/delete-simple/(:num)', 'AdminController::deleteUserSimple/$1');
$routes->get('/admin/api/test/database', 'AdminController::testDatabase');
$routes->get('/admin/api/orders', 'AdminController::apiOrders');
$routes->put('/admin/api/orders/(:num)/status', 'AdminController::updateOrderStatus/$1');
$routes->put('/admin/api/orders/cancel/(:num)', 'AdminController::updateOrderStatus/$1');

// Admin Product API Routes
$routes->get('/admin/api/products', 'AdminController::apiProducts');
$routes->post('/admin/addProduct', 'AdminController::addProduct');
$routes->post('/admin/updateProduct/(:num)', 'AdminController::updateProduct/$1');
$routes->post('/admin/deleteProduct/(:num)', 'AdminController::deleteProduct/$1');
$routes->get('/admin/api/products/(:num)', 'AdminController::getProduct/$1');
$routes->post('/admin/api/products/(:num)/toggle-status', 'AdminController::toggleProductStatus/$1');