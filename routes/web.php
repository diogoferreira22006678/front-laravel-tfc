<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/details', function(){
    return view('portfolio-details');
});

/*****************BACK************************/

Route::get('/admin', function(){
    return view('admin.index');
});

Route::get('/admin/containers', function(){
    return view('admin.containers.containers');
});

Route::get('/admin/arduinos', function(){
    return view('admin.containers.arduinos');
});

Route::get('/admin/sensors', function(){
    return view('admin.sensors.sensors');
});