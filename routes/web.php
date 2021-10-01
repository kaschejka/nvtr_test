<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\createOrderController;
use App\Http\Controllers\eventController;
use App\Http\Controllers\event_ticketsController;
use App\Http\Controllers\type_ticketsController;


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
Route::middleware(['auth:sanctum', 'verified','role:admin'])->resource('events', eventController::class);
Route::middleware(['auth:sanctum', 'verified','role:admin'])->resource('event_tikets', event_ticketsController::class);
Route::middleware(['auth:sanctum', 'verified','role:admin'])->resource('type_tickets', type_ticketsController::class);

Route::post('/order', [createOrderController::class,'addOrder']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
