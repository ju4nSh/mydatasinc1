<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::login');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

$routes->get('index', 'Home::index');
$routes->get('login', 'Home::login');
$routes->post('registrar', 'Home::registrar');
$routes->get('mostrarRegistrar', 'Home::mostrarRegistrar');
$routes->get('perfil', 'Home::perfil');
$routes->get('llenarPerfil', 'Home::llenarPerfil');
$routes->post('ModificarPerfil', 'Home::ModificarPerfil');
$routes->get('tablas', 'Home::tablas');
$routes->post('guardar', 'Home::guardar');
$routes->get('salir', 'Home::salir');
$routes->get('productos', 'Home::productos');
$routes->get('obtenerproductos', 'Productos::getProduct');
$routes->post('obtenercategoriaId', 'Productos::getCategory_Id');

$routes->get('obtenercategoria', 'Productos::obtenerCategoria');
$routes->get('obtenerdetallescategoria/(:any)', 'Productos::obtenerDetallesCategoria/$1');
$routes->get('attributesCategory/(:any)', 'Productos::attributesCategory/$1');
$routes->post('publicarMercadolibre', 'Productos::publicarMercadolibre');
$routes->post('actualizarproducto', 'Productos::actualizarProducto');
$routes->get('mostrarClientesReferenciados', 'Home::mostrarClientesReferenciados');
$routes->post('agregarClienteRef', 'Home::agregarClienteRef');
$routes->post('eliminarClienteRef', 'Home::eliminarClienteRef');


$routes->get('generateClient', 'Clientes::llenarClientes');
$routes->get('usuarios', 'Clientes::index');
$routes->get('listarClientes', 'Clientes::listarClientes');
$routes->post('listarClientesnavegacion', 'Clientes::listarClientesNavegacion');
$routes->post('listarClientesOffset', 'Clientes::listarClientesOffset');

$routes->get('mostrarDatosApi', 'Home::mostrarDatosApi');
$routes->get('datosApi', 'Home::datosApi');

// paginacion de productos
$routes->get('getData/(:any)/(:any)/(:any)/(:any)', 'Productos::getData/$1/$2/$3/$4');
$routes->get('getData/(:any)/(:any)', 'Productos::getData/$1/$2');
$routes->get('createLinks/(:any)/(:any)', 'Productos::createLinks/$1/$2');

// obtener todos los productos de mercadolibre
$routes->post('getAllProduct', 'Productos::getAllProduct');

// activar o descativar productos | eliminar productos
$routes->get('actualizarStatus/(:any)/(:any)', 'Productos::pausarActivarEliminar/$1/$2');
//Graficos
$routes->get('graficoCircular', 'Graficos::graficoCircular');