<?php

use App\Http\Controllers\ProductOcsController;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('oc/save', [ProductOcsController::class, 'store']);

Route::get('oc/show/{id}', [ProductOcsController::class, 'show']);

Route::get('oc/view', [ProductOcsController::class, 'index']);

