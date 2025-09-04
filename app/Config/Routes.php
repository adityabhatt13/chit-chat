<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->match(['GET','POST'], 'auth/signup', 'Auth::signup');
$routes->match(['GET','POST'], 'auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('dashboard', 'Dashboard::index');
$routes->get('dashboard/chat/(:num)', 'Dashboard::chat/$1');
$routes->post('dashboard/sendMessage/(:num)', 'Dashboard::sendMessage/$1');

// API routes for chat messages
$routes->group('api', function($routes) {
    $routes->group('message', function($routes) {
        $routes->post('send', 'Api\MessageController::send');
        $routes->get('conversation/(:num)', 'Api\MessageController::conversation/$1');
        $routes->get('poll/(:num)', 'Api\MessageController::poll/$1');
    });
});
