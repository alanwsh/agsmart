<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ApiController;
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

Route::get('/',[ImageController::class,'index']);
Route::prefix('api')->name('api.')->group(function(){
    Route::get('/image/popular',[ApiController::class,'most_popular_image'])->name('popular');
    Route::get('/image/mostviewed',[ApiController::class,'top10viewed']);
    Route::get('/images',[ApiController::class,'images']);
    Route::get('/image/{id}',[ApiController::class,'image']);
    Route::get('/images/page/{page?}',[ApiController::class,'paginated_image']);
    Route::post('/image/create',[ApiController::class,'create_image'])->name('create');
});