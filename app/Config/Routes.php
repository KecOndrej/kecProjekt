<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Cyklo::index');
$routes->get('cyklo', 'Cyklo::index');
$routes->get('cyklo/pridatRocnik', 'Cyklo::pridatRocnik');
$routes->post('cyklo/ulozitRocnik', 'Cyklo::ulozitRocnik');
$routes->get('cyklo/vysledky/(:num)/(:num)', 'Cyklo::vysledky/$1/$2');
$routes->get('cyklo/detailRocniku/(:num)', 'Cyklo::detailRocniku/$1');