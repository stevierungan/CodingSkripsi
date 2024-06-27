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
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

if (session('role') == 1) {
    //LOGIN
    $routes->get('/login', 'Login::index');
    $routes->get('/logout', 'Login::logout');
    $routes->post('/login/authentication', 'Login::authentication');
    $routes->get('/login/sign_up', 'Login::sign_up');

    //HOME
    $routes->get('/', 'Home::index');
    $routes->get('/home', 'Home::index');

    //SISWA
    $routes->get('/siswa', 'Siswa::index');
    $routes->post('/siswa/tambah', 'Siswa::tambah');
    $routes->post('/siswa/edit', 'Siswa::edit');
    $routes->get('/siswa/detail/(:num)', 'Siswa::detail/$1');
    $routes->delete('/siswa/delete/(:num)', 'Siswa::delete/$1');

    //KRITERIA
    $routes->get('/kriteria', 'Kriteria::index');
    $routes->post('/kriteria/tambah', 'Kriteria::tambah');
    $routes->post('/kriteria/edit', 'Kriteria::edit');
    $routes->get('/kriteria/detail/(:num)', 'Kriteria::detail/$1');
    $routes->delete('/kriteria/delete/(:any)', 'Kriteria::delete/$1');
    $routes->post('/kriteria/ubah_bobot_kriteria', 'Kriteria::ubah_bobot_kriteria');

    // ALTERNATIF
    $routes->get('/alternatif', 'Alternatif::index');
    $routes->post('/alternatif/tambah', 'Alternatif::tambah');
    $routes->post('/alternatif/edit', 'Alternatif::edit');
    $routes->get('/alternatif/detail/(:num)', 'Alternatif::detail/$1');
    $routes->delete('/alternatif/delete/(:any)', 'Alternatif::delete/$1');

    //NILAI SISWA
    $routes->get('/nilai_siswa', 'NilaiSiswa::index');
    // $routes->get('/nilai_siswa/debug', 'NilaiSiswa::debug');
    $routes->post('/nilai_siswa/detail', 'NilaiSiswa::detail');
    $routes->post('/nilai_siswa/ubah_nilai', 'NilaiSiswa::ubah_nilai');

    //PERHITUNGAN
    $routes->get('/perhitungan', 'Perhitungan::index');

    //Kuis
    $routes->get('/kuis', 'Kuis::index');
    $routes->post('/kuis/edit_kuis', 'Kuis::edit_kuis');
    $routes->post('/kuis/get_soal_ajax', 'Kuis::get_soal_ajax');

    //CHANGE PASSWORD
    $routes->get('/change_password', 'ChangePassword::admin');
    $routes->get('/change_password/reset_password/(:any)', 'ChangePassword::reset_password/$1');
} elseif (session('role') == 2) {
    $routes->get('/', 'Home::index');
    $routes->get('/home', 'Home::index');

    $routes->get('/', 'Login::index');
    $routes->get('/login', 'Login::index');
    $routes->get('/logout', 'Login::logout');
    $routes->post('/login/authentication', 'Login::authentication');
    $routes->get('/login/sign_up', 'Login::sign_up');

    //Kuis
    $routes->get('/kuis', 'Kuis::kuis_siswa');
    $routes->post('/kuis/kuis_jawaban_siswa', 'Kuis::kuis_jawaban_siswa');

    //Hasil
    $routes->get('/hasil', 'Perhitungan::get_hasil_siswa');

    //CHANGE PASSWORD
    $routes->get('/change_password', 'ChangePassword::user');
    $routes->post('/change_password/user_ubah_pw', 'ChangePassword::user_ubah_pw');
} else {
    $routes->get('/', 'Login::index');
    $routes->get('/login', 'Login::index');
    $routes->get('/logout', 'Login::logout');
    $routes->post('/login/authentication', 'Login::authentication');
    $routes->get('/login/sign_up', 'Login::sign_up');
}


// $routes->get('/login', function () {
//     echo "hhhhh";
// }); // x
// $routes->get('/login/authentication/(:any)/(:num)', 'Login::authentication/$1/$2'); mengambil apapun setelah function authentication (method GET)

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
