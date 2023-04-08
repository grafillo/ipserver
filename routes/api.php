<?php

use App\Http\Controllers\IpController;
use App\Http\Controllers\WebController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getwebs', [WebController::class, 'getWebs']);
Route::post('/addweb', [WebController::class, 'addWeb']);
Route::get('/getips', [IpController::class, 'getIps']);
Route::post('/addips', [IpController::class, 'addIps']);
Route::delete('/delip/{ip}', [IpController::class, 'delIp']);
Route::put('/freeze', [IpController::class, 'freezeIp']);
Route::put('/unfreeze', [IpController::class, 'unfreezeIp']);
Route::delete('/delweb/{web}', [WebController::class, 'delWeb']);

