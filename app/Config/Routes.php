<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 1. HALAMAN LOGIN (Publik)
// Pastikan halaman login TIDAK terkena filter 'auth' agar bisa dibuka
$routes->get('/', 'Auth::index');

$routes->group('auth', function ($routes) {
    $routes->get('/', 'Auth::index');           // Menampilkan Form Login
    $routes->post('login', 'Auth::login');      // Proses Verifikasi Login
    $routes->get('logout', 'Auth::logout');     // Keluar Sistem
});

$routes->get('create/account', 'Auth::registrasi');
$routes->post('registrasi', 'Auth::createAccount');
$routes->get('create/account/admin', 'Auth::registrasiAdmin');
$routes->post('registrasi/admin', 'Auth::createAccountAdmin');

$routes->get('profil/admin', 'Auth::profilAdmin');
$routes->get('profil/user', 'Auth::profilUser');

// user
$routes->get('/user/dashboard', 'Dashboard::user');
$routes->get('/user/library', 'Library::user');
$routes->get('/user/keranjang', 'Keranjang::index');
$routes->post('/user/transaksi', 'Transaksi::userTransaksi');
$routes->get('/user/buku/detail/(:num)', 'Library::userBookDetail/$1');
$routes->post('/user/tambah/keranjang/(:num)', 'Keranjang::create/$1');
$routes->post('/cart/delete/(:num)', 'Keranjang::delete/$1');

$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/transaksi/admin', 'Transaksi::index');
$routes->post('/transaksi/simpan', 'Transaksi::simpan');
$routes->get('/buku/detail/(:num)', 'Library::bookDetail/$1');

// Route untuk memproses pengembalian berdasarkan ID Transaksi
$routes->get('transaksi/kembali/(:num)', 'Transaksi::kembali/$1');

// 2. AREA PROTEKSI (Harus Login)
// Semua route di dalam group ini akan dicek oleh filter 'auth'
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // Dashboard

    // SISTEM PERPUSTAKAAN (CRUD)
    $routes->group('library', function ($routes) {
        $routes->get('/', 'Library::index');                // List Buku
        $routes->get('create', 'Library::create');          // Form Tambah
        $routes->post('save', 'Library::save');             // Simpan Data Baru

        // Edit & Update
        $routes->get('edit/(:num)', 'Library::edit/$1');    // Form Edit
        $routes->post('update/(:num)', 'Library::update/$1'); // Proses Update

        // Aksi Lainnya
        $routes->get('delete/(:num)', 'Library::delete/$1');
        $routes->get('borrow/(:num)', 'Library::borrow/$1');
    });
});
