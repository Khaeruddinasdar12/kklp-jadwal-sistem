<?php

use Illuminate\Support\Facades\Route;
Auth::routes([
    'register' => false
]);

Route::get('/', 'Admin\DashboardController@main');


Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');

// MANAGE JADWAL
Route::get('/manage-jadwal', 'Admin\JadwalController@index')->name('jadwal');
Route::post('/manage-jadwal', 'Admin\JadwalController@store')->name('jadwal.store');
Route::get('/manage-jadwal/edit/{id}', 'Admin\JadwalController@edit')->name('jadwal.edit');
Route::put('/manage-jadwal/{id}', 'Admin\JadwalController@update')->name('jadwal.update');
Route::delete('/delete-jadwal/{id}', 'Admin\JadwalController@delete')->name('jadwal.delete');

Route::get('/manage-jadwal/riwayat', 'Admin\JadwalController@riwayat')->name('jadwal.riwayat');
Route::put('/manage-jadwal/selesai/{id}', 'Admin\JadwalController@selesai')->name('jadwal.selesai');

Route::get('/table-jadwal', 'Admin\JadwalController@tableJadwal')->name('table.jadwal');
Route::get('/table-riwayat-jadwal', 'Admin\JadwalController@tableRiwayat')->name('table.riwayat.jadwal');
// END MANAGE JADWAL


// MANAGE PEGAWAI
Route::get('/manage-pegawai', 'Admin\PegawaiController@index')->name('pegawai');
Route::post('/manage-pegawai', 'Admin\PegawaiController@store')->name('pegawai.store');
Route::delete('/delete-pegawai/{id}', 'Admin\PegawaiController@delete')->name('pegawai.delete');
Route::get('/table-pegawai', 'Admin\PegawaiController@tablePegawai')->name('table.pegawai');
// END MANAGE PEGAWAI


// MANAGE DEPARTEMEN 
Route::get('/manage-departemen', 'Admin\DepartemenController@index')->name('departemen');
Route::post('/manage-departemen', 'Admin\DepartemenController@store')->name('departemen.store');
Route::post('/update-departemen', 'Admin\DepartemenController@update')->name('departemen.update');
Route::delete('/delete-departemen/{id}', 'Admin\DepartemenController@delete')->name('departemen.delete');
Route::get('/table-departemen', 'Admin\DepartemenController@tableDepartemen')->name('table.departemen');
// END MANAGE DEPARTEMEN


// MANAGE ADMIN 
Route::get('/manage-admin', 'Admin\AdminController@index')->name('admin');
Route::post('/manage-admin', 'Admin\AdminController@store')->name('admin.store');
Route::get('/table-admin', 'Admin\AdminController@tableAdmin')->name('table.admin');
// END MANAGE ADMIN