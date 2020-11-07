<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\directController;

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
//get all or one register
Route::get('directory/{id?}',[directController::class,'index']);

//add a register
Route::post('add',[directController::class,'add']);

//update
Route::put('update',[directController::class,'updateContact']);

//search data
Route::get('search/{search}',[directController::class,'search']);


//delete an register 
Route::delete('delete/{id}',[directController::class,'Delete']);

//validations 
Route::post('save',[directController::class, 'testData']);