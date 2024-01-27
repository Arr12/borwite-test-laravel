<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TravelController;

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

Route::prefix('/travel')->name('api.travel.')->group(function(){
    Route::get('/', [TravelController::class, 'create'])->name('create');
    Route::post('/store', [TravelController::class, 'store'])->name('store');
    Route::post('/destroy/{id}', [TravelController::class, 'destroy'])->name('destroy');
    Route::post('/update/{id}', [TravelController::class, 'update'])->name('update');
});
