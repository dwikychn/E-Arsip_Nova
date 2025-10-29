<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->get('home', 'Home::index');
$routes->post('kategori/delete', 'Kategori::delete');
$routes->get('kategori/delete/(:num)', 'Kategori::delete/$1');
$routes->get('auth', 'Auth::index');
$routes->get('auth/index', 'Auth::index');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('user', 'User::index');
$routes->get('user/delete/(:num)', 'User::delete/$1');
$routes->get('departemen', 'Departemen::index');
$routes->get('kategori', 'Kategori::index');
$routes->get('arsip', 'Arsip::index');
$routes->get('arsip/deleteArsip/(:num)', 'Arsip::deleteArsip/$1');
$routes->get('arsip/updateArsip/(:num)', 'Arsip::updateArsip/$1');
$routes->get('departemen/delete/(:num)', 'Departemen::deleteDep/$1');
$routes->get('audit', 'Audit::index');
$routes->get('cari', 'Cari::index');
$routes->get('bantuan', 'Bantuan::index');
$routes->get('preview/(:num)', 'Cari::preview/$1');
$routes->get('arsip/preview/(:num)', 'Arsip::preview/$1');
$routes->get('user/change-password', 'User::changePassword');
$routes->get('activity', 'Audit::index');
$routes->get('arsip/getKategoriByDep/(:num)', 'Arsip::getKategoriByDep/$1');
$routes->get('home/lastActivityAjax', 'Home::lastActivityAjax');
$routes->get('cari/preview/(:num)', 'Cari::preview/$1');
$routes->get('user/byDepartemen/(:num)', 'User::byDepartemen/$1');
$routes->post('auth/login', 'Auth::login');
$routes->post('user/store', 'User::store');
$routes->post('user/update/(:num)', 'User::update/$1');
$routes->post('departemen/addDep', 'Departemen::addDep');
$routes->post('departemen/editDep/(:num)', 'Departemen::editDep/$1');
$routes->post('kategori/update/(:num)', 'Kategori::update/$1');
$routes->post('kategori/add', 'Kategori::add');
$routes->post('kategori/addArsip', 'Kategori::addArsip');
$routes->post('arsip/updateArsip/(:num)', 'Arsip::updateArsip/$1');
$routes->post('arsip/addArsip', 'Arsip::addArsip');
$routes->post('user/change-password', 'User::updatePassword');
$routes->post('user/update-profile/(:num)', 'User::updateProfile/$1');
$routes->post('arsip/download/(:num)', 'Arsip::download/$1');
$routes->get('/backupdb', 'Backupdb::index');
$routes->get('user/byDepartemen/(:num)', 'User::byDepartemen/$1');
$routes->post('cari/hapus_multiple', 'Cari::hapus_multiple');
$routes->post('arsip/hapus_multiple', 'Arsip::hapus_multiple');
$routes->get('/departemen/all', 'Departemen::getAll');
$routes->get('/user/byDepartemen/(:num)', 'User::byDepartemen/$1');
$routes->get('cari/stream/(:num)', 'Cari::stream/$1');
$routes->get('bantuan', 'Bantuan::index');
$routes->get('bantuan/chat/(:num)', 'Bantuan::chat/$1');
$routes->post('bantuan/kirim', 'Bantuan::kirim');
$routes->get('bantuan/refreshChat/(:num)', 'Bantuan::refreshChat/$1');