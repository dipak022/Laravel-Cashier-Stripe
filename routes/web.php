<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::post('/single-charge', [App\Http\Controllers\HomeController::class, 'SingleCharge'])->name('single.charge');

Route::get('plants/create', [App\Http\Controllers\SubscriptionController::class, 'PlantsCreate'])->name('plants.create');

Route::post('plants/store', [App\Http\Controllers\SubscriptionController::class, 'StoreCreate'])->name('plants.store');

Route::get('plants', [App\Http\Controllers\SubscriptionController::class, 'allPlants'])->name('plants.all');

Route::get('plants/checkout/{planId}', [App\Http\Controllers\SubscriptionController::class, 'Checkout'])->name('plants.checkout');

Route::post('plants/process', [App\Http\Controllers\SubscriptionController::class, 'ProcessPlan'])->name('plant.process');


