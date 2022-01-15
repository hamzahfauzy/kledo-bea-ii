<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\KasbonController;
use App\Http\Controllers\Api\PegawaiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('pegawai')->group(function(){
    Route::get('/',[PegawaiController::class,'get']);
    Route::post('/',[PegawaiController::class,'create']);
});

Route::prefix('kasbon')->group(function(){
    Route::get('/',[KasbonController::class,'get']);
    Route::post('/',[KasbonController::class,'create']);
    Route::patch('setujui/{id}',[KasbonController::class,'approve']);
    Route::post('setujui-masal',[KasbonController::class,'bulkApprove']);
});