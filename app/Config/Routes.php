<?php

use CodeIgniter\Router\RouteCollection;
use App\Controller\EmployeesController;
use App\Controller\PositionsController;
use App\Controller\SalariesController;
/**
 * @var RouteCollection $routes
 */

$routes->group('dashboard', static function ($routes){
    $routes->get('', 'Home::index');

    $routes->group('employee', static function ($routes){
        $routes->get('', 'EmployeesController::index');
        $routes->get('create', 'EmployeesController::create');
        $routes->post('create', 'EmployeesController::save');
        $routes->post('list', 'EmployeesController::list');
        $routes->post('dropdown', 'EmployeesController::dropdown');
        $routes->get('edit/(:any)', 'EmployeesController::edit/$1');
        $routes->post('edit/(:any)', 'EmployeesController::update/$1');
        $routes->delete('delete/(:any)', 'EmployeesController::delete/$1');
    });

    $routes->group('position', static function ($routes){
        $routes->get('', 'PositionsController::index');
        $routes->get('dropdown', 'PositionsController::dropdown');
        $routes->post('list', 'PositionsController::list');
        $routes->get('edit/(:any)', 'PositionsController::edit/$1');
        $routes->post('edit/(:any)', 'PositionsController::update/$1');
        $routes->delete('delete/(:any)', 'PositionsController::delete/$1');

    });

    $routes->group('salary', static function ($routes){
        $routes->get('', 'SalariesController::index');
        $routes->get('create', 'SalariesController::create');
        $routes->post('create', 'SalariesController::save');
        $routes->post('list', 'SalariesController::list');
        $routes->post('getTotal', 'SalariesController::getTotal');
        $routes->get('edit/(:any)', 'SalariesController::edit/$1');
        $routes->post('edit/(:any)', 'SalariesController::update/$1');
        $routes->delete('delete/(:any)', 'SalariesController::delete/$1');
    });

    $routes->group('userManagement', static function ($routes){
        $routes->get('', 'UsersController::index');
        $routes->get('create', 'UsersController::create');
        $routes->post('create', 'UsersController::save');
        $routes->post('list', 'UsersController::list');
        $routes->get('edit/(:any)', 'UsersController::edit/$1');
        $routes->post('edit/(:any)', 'UsersController::update/$1');
        $routes->delete('delete/(:any)', 'UsersController::delete/$1');
    });
    

    $routes->group('role', static function ($routes){
        $routes->get('dropdown', 'RoleController::dropdown');
    });
});
