<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/{vue_capture?}', function() {
    return view('welcome');
})->where('vue_capture', '[\/\w\.-]*');

Route::get('/reset-password', [UserController::class, 'showResetForm']);
Route::post('/reset-password', [UserController::class, 'reset']);