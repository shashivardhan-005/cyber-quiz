<?php
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');                     // Shows User Login
$routes->post('login', 'Auth::login');                // Processes User Login
$routes->get('admin_login', 'Auth::admin_login_view');// Shows Admin Login
$routes->post('admin_attempt', 'Auth::admin_attempt');// Processes Admin Login
$routes->get('logout', 'Auth::logout');               // Logs out anyone

// QUIZ ROUTES
$routes->get('quiz/instructions', 'Quiz::instructions'); // Shows Instructions
$routes->get('quiz/start', 'Quiz::start');               // Starts the Quiz
$routes->post('quiz/submit', 'Quiz::submit');            // Saves the Score

// ADMIN ROUTES
$routes->get('dashboard', 'Admin::dashboard');           // Admin Panel
$routes->post('admin/update_profile', 'Admin::update_profile'); // Update Profile
$routes->get('admin/result_details/(:num)', 'Admin::result_details/$1'); // View Details
$routes->get('admin/all_questions', 'Admin::all_questions'); // View All Questions
