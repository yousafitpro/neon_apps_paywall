<?php

use App\Http\Controllers\PayWallController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware'=>'api_key'],function(){
    Route::any("createPaywall",[PayWallController::class,'createPaywall']);
    Route::any("updatePaywall",[PayWallController::class,'updatePaywall']);
    Route::any("deletePaywall",[PayWallController::class,'deletePaywall']);
    Route::any("getPaywall",[PayWallController::class,'getPaywall']);
    Route::any("getPaywalls",[PayWallController::class,'getPaywalls']);
});

