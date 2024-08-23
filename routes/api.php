<?php

use App\Http\Controllers\DeviceController;
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

Route::group(['prefix'=>'v1/devices'],function(){
    Route::post("create",[DeviceController::class,'create']);
    Route::post("update",[DeviceController::class,'update']);
});
Route::group(['prefix'=>'v1/events'],function(){
    Route::post("trial-start",[DeviceController::class,'trial_start']);
    Route::post("trial-conversion",[DeviceController::class,'trial_conversion']);
    Route::post("direct-subscription",[DeviceController::class,'direct_subscription']);
    Route::post("paywall-view",[DeviceController::class,'paywall_view']);
    Route::post("onboarding-completion",[DeviceController::class,'onboarding_completion']);
});
Route::group(['middleware'=>'api_key'],function(){
    Route::any("createPaywall",[PayWallController::class,'createPaywall']);
    Route::any("logConversion",[PayWallController::class,'logConversion']);
    Route::any("logPaywallView",[PayWallController::class,'logPaywallView']);
    Route::any("logSession",[PayWallController::class,'logSession']);
    Route::any("updatePaywall",[PayWallController::class,'updatePaywall']);
    Route::any("deletePaywall",[PayWallController::class,'deletePaywall']);
    Route::any("getPaywall",[PayWallController::class,'getPaywall']);
    Route::any("getPaywalls",[PayWallController::class,'getPaywalls']);
});



    Route::any("getTemplate",[PayWallController::class,'getTemplate']);
