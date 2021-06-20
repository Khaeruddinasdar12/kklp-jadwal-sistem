<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false
]);

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');

Route::get('/manage-jadwal', 'Admin\JadwalController@index')->name('jadwal');
Route::post('/manage-jadwal', 'Admin\JadwalController@store')->name('jadwal.store');
Route::get('/table-jadwal', 'Admin\JadwalController@tableJadwal')->name('table.jadwal');

Route::get('/manage-pegawai', 'Admin\PegawaiController@index')->name('pegawai');
Route::post('/manage-pegawai', 'Admin\PegawaiController@store')->name('pegawai.store');
Route::get('/table-pegawai', 'Admin\PegawaiController@tablePegawai')->name('table.pegawai');
