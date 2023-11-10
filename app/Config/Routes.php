<?php

namespace Config;

use App\Controllers\Home;
use App\Controllers\Komik;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
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
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->addPlaceholder('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
$routes->get('coba2/(:uuid)', function ($uuid) {
    echo "UUID: $uuid";
});
$routes->get('/', 'Home::index');
$routes->get('/book', 'Book::index');
$routes->get('/book/create', 'Book::create');
$routes->post('/book/create', 'Book::save');
$routes->get('/book/edit/(:any)', 'Book::edit/$1');
$routes->post('/book/edit/(:any)', 'Book::update/$1');
$routes->get('/book/(:any)', 'Book::detail/$1');
$routes->delete('/book/(:num)', 'Book::delete/$1');
$routes->post('/book/import', 'Book::importData');


// $routes->get('/komik', 'Komik::index');
// $routes->get('/komik/create', 'Komik::create');
// $routes->post('/komik/create', 'Komik::save');
// $routes->get('/komik/edit/(:any)', 'Komik::edit/$1');
// $routes->post('/komik/edit/(:any)', 'Komik::update/$1');
// $routes->get('/komik/(:any)', 'Komik::detail/$1');
// $routes->delete('/komik/(:num)', 'Komik::delete/$1');

$routes->group('komik', function ($r) {
    $r->get('/', 'Komik::index');
    $r->get('create', 'Komik::create');
    $r->post('create', 'Komik::save');
    $r->get('edit/(:any)', 'Komik::edit/$1');
    $r->post('edit/(:any)', 'Komik::update/$1');
    $r->get('(:any)', 'Komik::detail/$1');
    $r->delete('(:num)', 'Komik::delete/$1');
    $r->post('import', 'Komik::importData');
});


$routes->get('/container', 'Container::index');
$routes->get('/container2', 'Container::index2');
//$routes->get('/users', 'Admin\Users::index');
$routes->get('/master', 'Admin\Master::index');
$routes->group('adm', function ($r) {
    $r->get('users', 'Admin\Users::index');
    $r->get('master', 'Admin\Master::index');
});

$routes->get('/produk/index', 'produk::index')->setAutoRoute(true);
$routes->addRedirect('/produk', 'produk/index');

$routes->get('/supplier/index', 'Supplier::index')->setAutoRoute(true);
$routes->addRedirect('/supplier', 'supplier/index');

$routes->get('/layanan/index', 'Layanan::index')->setAutoRoute(true);
$routes->addRedirect('/layanan', 'layanan/index');

$routes->get('/login', 'Auth::indexlogin');
$routes->post('/login/auth', 'Auth::auth');
$routes->get('/login/register', 'Auth::indexregister');
$routes->post('/login/save', 'Auth::saveRegister');
$routes->get('/logout', 'Auth::logout');
$routes->group(
    'users',
    ['filter' => 'auth'],
    function ($r) {
        $r->get('/', 'Users::index');
        $r->get('index', 'Users::index');
        $r->get('create', 'Users::create');
        $r->post('create', 'Users::save');
        $r->get('edit/(:num)', 'Users::edit/$1');
        $r->post('edit/(:num)', 'Users::update/$1');
        $r->delete('(:num)', 'Users::delete/$1');
    }
);

$routes->group('jual', ['filter' => 'auth'], function ($r) {
    $r->get('/', 'Penjualan::index');
    $r->get('load',  'Penjualan::loadCart');
    $r->get('gettotal', 'Penjualan::getTotal');
    $r->post('/', 'Penjualan::addCart');
    $r->post('update', 'Penjualan::updateCart');
    $r->post('bayar', 'Penjualan::pembayaran');
    $r->delete('(:any)', 'Penjualan::deleteCart/$1');
    $r->get('laporan', 'Penjualan::report');
    $r->post('laporan/filter', 'Penjualan::filter');
    $r->get('exportpdf', 'Penjualan::exportPDF');
    $r->get('exportexcel', 'Penjualan::exportExcel');
});

$routes->group('beli', ['filter' => 'auth'], function ($r) {
    $r->get('/', 'Pembelian::index');
    $r->get('load',  'Pembelian::loadCart');
    $r->get('gettotal', 'Pembelian::getTotal');
    $r->post('/', 'Pembelian::addCart');
    $r->post('update', 'Pembelian::updateCart');
    $r->post('bayar', 'Pembelian::pembayaran');
    $r->delete('(:any)', 'Pembelian::deleteCart/$1');
    $r->get('laporan', 'Pembelian::report');
    $r->post('laporan/filter', 'Pembelian::filter');
    $r->get('exportpdf', 'Pembelian::exportPDF');
    $r->get('exportexcel', 'Pembelian::exportExcel');
});

$routes->post('/chart-transaksi', 'Home::showChartTransaksi');
$routes->post('/chart-customer', 'Home::showChartCustomer');

$routes->post('/chart-pembelian', 'Home::showChartPembelian');
$routes->post('/chart-supplier', 'Home::showChartSupplier');

$routes->post('/chart-layanan', 'Home::showChartPembelian');
$routes->post('/chart-layanan', 'Home::showChartLayanan');

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
