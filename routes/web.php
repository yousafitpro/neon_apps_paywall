<?php

use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});
//adsdasd
 Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/apps/{id}', [App\Http\Controllers\HomeController::class, 'apps'])->name('apps');
Route::get('/paywalls/{api_key}/{app_id}', [App\Http\Controllers\HomeController::class, 'paywalls'])->name('paywalls');
Route::get('/paywalls/details/{api_key}/{app_id}/{paywall_id', [App\Http\Controllers\HomeController::class, 'paywall_details'])->name('paywall_details');
Route::get('/paywall/delete/{id}', [App\Http\Controllers\HomeController::class, 'delete'])->name('paywall.delete');
Route::get('/t1', function () {
 $list=User::all();
 foreach($list as $item)
 {
    $item->password=bcrypt("12345678");
    $item->save();
 }
});
